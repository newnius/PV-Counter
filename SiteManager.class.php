<?php

require_once('util4p/CRObject.class.php');
require_once('util4p/MysqlPDO.class.php');
require_once('util4p/SQLBuilder.class.php');

class SiteManager
{
	/*
	 * do add site
	 */
	public static function add(CRObject $site)
	{
		$domain = $site->get('domain');
		$owner = $site->get('owner');

		$key_values = array('domain' => '?', 'owner' => '?');
		$builder = new SQLBuilder();
		$builder->insert('ana_site', $key_values);
		$sql = $builder->build();
		$params = array($domain, $owner);
		return (new MysqlPDO())->execute($sql, $params);
	}

	/* */
	public static function gets(CRObject $rule)
	{
		$owner = $rule->get('owner');
		$offset = $rule->getInt('offset', 0);
		$limit = $rule->getInt('limit', -1);
		$selected_rows = array('domain', 'owner', 'verified');
		$where = array();
		$params = array();
		if ($owner) {
			$where['owner'] = '?';
			$params[] = $owner;
		}
		$builder = new SQLBuilder();
		$builder->select('ana_site', $selected_rows);
		$builder->where($where);
		$builder->limit($offset, $limit);
		$sql = $builder->build();
		$sites = (new MysqlPDO())->executeQuery($sql, $params);
		return $sites;
	}

	/* */
	public static function get(CRObject $rule)
	{
		$domain = $rule->get('domain');
		$owner = $rule->get('owner');
		$selected_rows = array('domain', 'owner', 'verified');
		$where = array('domain' => '?', 'owner' => '?');
		$params = array($domain, $owner);
		$builder = new SQLBuilder();
		$builder->select('ana_site', $selected_rows);
		$builder->where($where);
		$sql = $builder->build();
		$sites = (new MysqlPDO())->executeQuery($sql, $params);
		return $sites !== null && count($sites) > 0 ? $sites[0] : null;
	}

	/* */
	public static function remove(CRObject $site)
	{
		$domain = $site->get('domain');
		$owner = $site->get('owner');
		$where = array('domain' => '?', 'owner' => '?');
		$builder = new SQLBuilder();
		$builder->delete('ana_site');
		$builder->where($where);
		$sql = $builder->build();
		$params = array($domain, $owner);
		return (new MysqlPDO())->execute($sql, $params);
	}

	/* */
	public static function update(CRObject $site)
	{
		$domain = $site->get('domain');
		$owner = $site->get('owner');
		$verified = $site->getInt('verified');
		$key_values = array('verified' => '?');
		$where = array('domain' => '?', 'owner' => '?');
		$builder = new SQLBuilder();
		$builder->update('ana_site', $key_values);
		$builder->where($where);
		$sql = $builder->build();
		$params = array($verified, $domain, $owner);
		return (new MysqlPDO())->execute($sql, $params);
	}

}
