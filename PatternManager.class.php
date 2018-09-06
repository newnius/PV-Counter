<?php

require_once('predis/autoload.php');
require_once('util4p/RedisDAO.class.php');

class PatternManager
{

	/* site sample: blog.newnius.com:8080 */
	/* pattern sample: /view.php?id=? */
	public static function save($domain, $pattern)
	{
		$uri = parse_url('http://' . $domain . $pattern);
		if ($uri && isset($uri['path']) && isset($uri['query'])) {
			$redis = RedisDAO::instance();
			if ($redis === null) {
				return false;
			}
			$scope = 'patterns:' . $domain;
			return $redis->sadd($scope, $pattern) === 1;
		}
		return false;
	}

	/* */
	public static function remove($domain, $pattern)
	{
		$redis = RedisDAO::instance();
		if ($redis === null) {
			return false;
		}
		$scope = 'patterns:' . $domain;
		return $redis->srem($scope, $pattern) === 1;
	}

	/* */
	public static function gets($domain)
	{
		$scope = 'patterns:' . $domain;
		$redis = RedisDAO::instance();
		if ($redis === null) {
			return array();
		}
		return $redis->smembers($scope);
	}

	/* */
	public static function get_match_pattern($domain, $url)
	{
		if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
			return null;
		}
		$uri = parse_url($url);
		if ($uri && isset($uri['path']) && isset($uri['query'])) {
			$patterns = self::gets($domain);
			foreach ($patterns as $pattern) {
				$tmp = parse_url('http://' . $domain . $pattern);
				if ($uri['path'] === $tmp['path']) {
					parse_str($uri['query'], $arr_1);
					parse_str($tmp['query'], $arr_2);
					$keys_1 = array_keys($arr_1);
					$keys_2 = array_keys($arr_2);
					$keys_3 = array_intersect($keys_1, $keys_2);
					if (count($keys_3) === count($keys_2)) {
						return $pattern;
					}
				}
			}
		}
		return null;
	}

}
