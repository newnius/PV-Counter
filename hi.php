<?php
require_once('predis/autoload.php');
require_once('util4p/util.php');
require_once('util4p/RedisDAO.class.php');
require_once('util4p/CRObject.class.php');

require_once('util4p/Random.class.php');

require_once('Code.class.php');
require_once('Counter.class.php');
require_once('PatternManager.class.php');
require_once('config.inc.php');
require_once('init.inc.php');


session_start();

$url = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';

$client_ip = cr_get_client_ip();


function get_domain($url)
{
	$uri = parse_url($url);

	if ($uri === false || !isset($uri['host'])) {
		return false;
	}
	$domain = $uri['host'];
	if (isset($arr['port'])) {
		$domain .= ':' . $uri['port'];
	}
	return $domain;
}

function get_page($url)
{
	$uri = parse_url($url);
	$domain = get_domain($url);
	/* get related pattern */
	$pattern = PatternManager::get_match_pattern($domain, $url);

	/* build url*/
	$page = $uri['path'];
	if ($pattern !== null) {
		$pattern_url = parse_url('http://' . $domain . $pattern);
		parse_str($pattern_url['query'], $tmp_arr_1);
		parse_str($uri['query'], $tmp_arr_2);
		$tmp_arr = array();
		foreach (array_keys($tmp_arr_1) as $key) {
			$tmp_arr[$key] = $tmp_arr_2[$key];
		}
		$page = $uri['path'] . '?';
		$page .= http_build_query($tmp_arr);
	}
	return $page;
}


/* default response */
$res = array(
	'errno' => Code::SUCCESS,
	'page' => '',

	'pv' => '99+',
	'site_pv' => '99+',
	'site_pv_24h' => '99+',

	'site_vv' => '99+',
	'site_vv_24h' => '99+',

	'site_uv' => '99+',
	'site_uv_24h' => '99+'
);

/* validate url */
if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
	$res['errno'] = Code::INVALID_DOMAIN;
	exit;
}


$domain = get_domain($url);
$page = get_page($url);

$res['page'] = $page;

/* count */
$redis = RedisDAO::instance();
if ($redis === null) {
	$res['errno'] = Code::UNABLE_TO_CONNECT_REDIS;
	exit;
}


$PV_count = Counter::PV_count($domain, $page, 1);

/* VV */
$increment = 1;

$referrer = cr_get_GET('ref', '');
$referrer = urldecode($referrer);

$uri_ref = parse_url($referrer);
$uri_origin = parse_url($url);
if ($uri_ref !== false && $uri_origin !== false && isset($uri_ref['host']) && isset($uri_origin['host'])) {
	if ($uri_ref['host'] === $uri_origin['host']) {
		$increment = 0;
	}
}

$VV_count = Counter::VV_count($domain, $page, $increment);

/* UV */
/* TODO use another to determine unique view */
$tomorrow_morning = mktime(0, 0, 0, date('n'), date('j') + 1);
$increment = 0;
if (!isset($_COOKIE['_uv']) || $_COOKIE['_uv'] !== $domain) {
	$increment = 1;
}
if (!isset($_COOKIE['_uv']) || $_COOKIE['_uv'] !== $domain) {
	setcookie('_uv', $domain, $tomorrow_morning);
}
$UV_count = Counter::UV_count($domain, $page, $increment);

/* Combine data */
$res = array_replace($res, $PV_count, $VV_count, $UV_count);


$json = json_encode($res);
if (isset($_GET['callback'])) {
	$json = $_GET['callback'] . '(' . $json . ')';
}
echo $json;
