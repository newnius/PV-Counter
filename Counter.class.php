<?php

require_once('predis/autoload.php');
require_once('util4p/RedisDAO.class.php');

class Counter
{
	private static $redis = null;

	private static function _connect()
	{
		if (self::$redis === null) {
			self::$redis = RedisDAO::instance();
		}
		return true;
	}

	public static function PV_count($domain, $page, $increment)
	{
		self::_connect();
		$res = array();
		$tomorrow_morning = mktime(0, 0, 0, date('n'), date('j') + 1);
		$res['pv'] = self::$redis->hincrby($domain, 'PV:' . $page, $increment);
		$res['site_pv'] = self::$redis->hincrby($domain, 'SITE_PV:', $increment);
		$site_pv_24h_key = 'SITE_PV_24H_' . $tomorrow_morning . ':' . $domain;
		$res['site_pv_24h'] = self::$redis->incrby($site_pv_24h_key, $increment);
		if ($res['site_pv_24h'] === $increment) {
			self::$redis->expire($site_pv_24h_key, $tomorrow_morning - time());
		}
		return $res;
	}

	public static function VV_count($domain, $page, $increment)
	{
		self::_connect();
		$res = array();
		$tomorrow_morning = mktime(0, 0, 0, date('n'), date('j') + 1);
		$res['site_vv'] = self::$redis->hincrby($domain, 'SITE_VV:', $increment);
		$site_vv_24h_key = 'SITE_VV_24H_' . $tomorrow_morning . ':' . $domain;
		$res['site_vv_24h'] = self::$redis->incrby($site_vv_24h_key, $increment);
		if ($res['site_vv_24h'] === $increment) {
			self::$redis->expire($site_vv_24h_key, $tomorrow_morning - time());
		}
		return $res;
	}

	public static function UV_count($domain, $page, $increment)
	{
		self::_connect();
		$res = array();
		$tomorrow_morning = mktime(0, 0, 0, date('n'), date('j') + 1);
		$res['site_uv'] = self::$redis->hincrby($domain, 'SITE_UV:', $increment);
		$site_uv_24h_key = 'SITE_UV_24H_' . $tomorrow_morning . ':' . $domain;
		$res['site_uv_24h'] = self::$redis->incrby($site_uv_24h_key, $increment);
		if ($res['site_uv_24h'] === $increment) {
			self::$redis->expire($site_uv_24h_key, $tomorrow_morning - time());
		}
		return $res;
	}

	public static function gets($domain)
	{
		self::_connect();
		$data = self::$redis->hgetall($domain);
		return $data;
	}
}