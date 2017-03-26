<?php
	require_once('util4p/RedisDAO.class.php');
	require_once('util4p/CRObject.class.php');

	class PatternManager
	{

		/* site sample: blog.newnius.com:8080 */
		/* pattern sample: /view.php?id=? */
		public static function save($site, $pattern){
			$arr = parse_url('http://example.com'.$pattern);
			//var_dump($arr);
			if(!isset($arr['path']))return 0;// must set
			if(!isset($arr['query']))return 0;// no need to add pattern
			$redis = RedisDAO::instance();
			if($redis===null)return false;
			$scope = 'pattern_'.base64_encode($site);
			return $redis->sadd($scope, $pattern)===1;
		}
	
		public static function remove($site, $pattern){
			$redis = RedisDAO::instance();
			if($redis===null)return 0;
			$scope = 'pattern_'.base64_encode($site);
			return $redis->srem($scope, $pattern)===1;
		}

		public static function gets($rule){
			$site = $rule->get('site');
			$scope = 'pattern_'.base64_encode($site);
			$redis = RedisDAO::instance();
			if($redis===null)return array();
			return $redis->smembers($scope);
		}
	
		public static function get_match_pattern($site, $url)
		{
			if(filter_var($url, FILTER_VALIDATE_URL) === FALSE){
				return null;
			}
			$arr = parse_url($url);
			if(!isset($arr['path']))return 0;// must set
			if(!isset($arr['query']))return 0;// no need to add pattern

			$rule = new CRObject();
			$rule->set('site', $site);
			$patterns = self::gets($rule);
			
			foreach($patterns as $pattern){
				$tmp = parse_url('http://'.$site.$pattern);
				if($arr['path']===$tmp['path']){
					parse_str($arr['query'], $arr_1);
					parse_str($tmp['query'], $arr_2);
					$keys_1 = array_keys($arr_1);
					$keys_2 = array_keys($arr_2);
					$keys_3 = array_intersect($keys_1, $keys_2);
					if(count($keys_3) === count($keys_2)){
						return $pattern;
					}
				}
			}
			return null;
		}

	}


