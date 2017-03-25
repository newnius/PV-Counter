<?php
  require_once('util4p/CRObject.class.php');
  require_once('util4p/MysqlPDO.class.php');
  require_once('util4p/SQLBuilder.class.php');

  class SiteManager
  {
    /*
     * do add site 
     */
    public static function add($site)
    {
      $site_s = $site->get('site');
      $owner = $site->get('owner');

      $key_values = array( 'site' => '?', 'owner' => '?', 'add_time' => '?' );
      $builder = new SQLBuilder();
      $builder->insert('cr_site', $key_values);
      $sql = $builder->build();
      $params = array( $site_s, $owner, time());
      $count = (new MysqlPDO())->execute($sql, $params);
      return $count===1;
    }


    /*
     */
    public static function gets($rule)
    {
      $owner = $rule->get('owner');
			$offset = $rule->getInt('offset', 0);
			$limit = $rule->getInt('limit', -1);
			$selected_rows = array('site', 'owner', 'status', 'add_time');
      $where_arr = array();
      $params = array();
			if($owner){
				$where_arr['owner'] = '?';
				$params[] = $owner;
			}
      $builder = new SQLBuilder();
      $builder->select('cr_site', $selected_rows);
      $builder->where($where_arr);
			$builder->limit($offset, $limit);
      $sql = $builder->build();
      $sites = (new MysqlPDO())->executeQuery($sql, $params);
      return $sites;
    }

    /*
     */
    public static function remove($site)
    {
      $site_s = $site->get('site');
      $where_arr = array('site' => '?');
      $builder = new SQLBuilder();
      $builder->delete('cr_site');
      $builder->where($where_arr);
      $sql = $builder->build();
      $params = array( $site_s );
      $count = (new MysqlPDO())->execute($sql, $params);
      return $count===1;
    }


    /*
     */
    public function update($site)
    {
			$site_s = $site->get('site');
			$status = $site->getInt('status');

      $key_values = array('status' => '?');
      $where_arr = array('site'=>'?');

      $builder = new SQLBuilder();
      $builder->update('cr_site', $key_values);
      $sql = $builder->where($where_arr);
      $sql = $builder->build();
      $params = array( $status, $site_s );
      $count = (new MysqlPDO())->execute($sql, $params);
      return $count===1;
    }

  }
