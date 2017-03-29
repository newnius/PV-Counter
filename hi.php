<?php
	require_once('config.inc.php');
	require_once('predis/autoload.php');
	require_once('util4p/util.php');
	require_once('util4p/RedisDAO.class.php');
	require_once('util4p/CRObject.class.php');
	require_once('PatternManager.class.php');
	require_once('init.inc.php');

	$ua = cr_get_SERVER('HTTP_USER_AGENT');
	$url = cr_get_SERVER('HTTP_REFERER');
	$accept_language = cr_get_SERVER('HTTP_ACCEPT_LANGUAGE');
	$client_ip = cr_get_client_ip();


	$res = array(
		'pv' => '-1',
		'site_pv' => '-1',
		'site_vv' => '-1'
	);



	if(filter_var($url, FILTER_VALIDATE_URL) === FALSE)
	{
  	echo "invalid url\n";
		exit;
	}

	$arr = parse_url($url);

	$site = '';
	if(isset($arr['host']))
		$site .= $arr['host'];
	if(isset($arr['port']))
		$site .= ':'.$arr['port'];
	
	$page = $arr['path'];

	$pattern = PatternManager::get_match_pattern($site, $url);

	if($pattern !== null){
		$pattern_url = parse_url('http://'.$site.$pattern);
		parse_str($pattern_url['query'], $tmp_arr_1);
		parse_str($arr['query'], $tmp_arr_2);
		$tmp_arr = array();
		foreach(array_keys($tmp_arr_1) as $key){
			$tmp_arr[$key] = $tmp_arr_2[$key];
		}
		$page = $arr['path'].'?';
		$page .= http_build_query($tmp_arr);
	}
	
	$redis = RedisDAO::instance();
	if($redis===null)exit;

	$scope = 'site_'.base64_encode($site);
	$res['pv'] = $redis->hincrby($scope, 'pv_'.base64_encode($page), 1);
	$res['page'] = $page;

	$res['site_pv'] = $redis->hincrby($scope, '_SITE_PV_', 1);
	

	$referrer = cr_get_GET('ref', '');
	$referrer = urldecode($referrer);
	if(filter_var($referrer, FILTER_VALIDATE_URL) !== FALSE){
		$arr_ref = parse_url($referrer);
		$arr_origin = parse_url($url);
		if($arr_ref['host'] === $arr_origin['host']){
			if(!isset($arr_ref['port']))
				$arr_ref['port'] = 80;
			if(!isset($arr_origin['port']))
				$arr_origin['port'] = 80;
			if($arr_ref['port'] === $arr_origin['port']){
				$res['site_vv'] = $redis->hget($scope, '_SITE_VV_');
			}
		}
	}
	if($res['site_vv']==='-1'){
		$res['site_vv'] = $redis->hincrby($scope, '_SITE_VV_', 1);
	}


	$json = json_encode($res);
	if(isset($_GET['callback'])){
		$json = $_GET['callback'].'('.$json.')';
	}
	echo $json;
