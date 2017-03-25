<?php
	//var_dump($_SERVER);
	require_once('util4p/util.php');
	require_once('predis/autoload.php');
	require_once('util4p/RedisDAO.class.php');
	require_once('util4p/CRObject.class.php');
	require_once('PatternManager.class.php');

	$ua = cr_get_SERVER('HTTP_USER_AGENT');
	$refer = cr_get_SERVER('HTTP_REFERER');
	$accept_language = cr_get_SERVER('HTTP_ACCEPT_LANGUAGE');
	$client_ip = cr_get_client_ip();


	$res = array(
		'pv' => '-1',
		'site_pv' => '-1'
	);



	if(filter_var($refer, FILTER_VALIDATE_URL) === FALSE)
	{
  	echo "Not valid url\n";
		exit;
	}

	$config = new CRObject();
	$config->set('scheme', 'tcp');
	$config->set('host', '192.168.56.110');
	$config->set('port', '6379');
	RedisDAO::configure($config);



	$arr = parse_url($refer);

	$site = '';
	if(isset($arr['host']))
		$site .= $arr['host'];
	if(isset($arr['port']))
		$site .= ':'.$arr['port'];
	
//$pattern = '/jlucqe/view.php?ID=?&SID=?';
//PatternManager::save($site, $pattern);


	$pattern = PatternManager::get_match_pattern($site, $refer);

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
	}else{
		$page = $arr['path'].'?'.$arr['query'];
	}
	
	$redis = RedisDAO::instance();
	if($redis===null)exit;

	$scope = 'site_'.base64_encode($site);
	$res['pv'] = $redis->hincrby($scope, 'pv_'.base64_encode($page), 1);
	$res['page'] = $page;

	$res['site_pv'] = $redis->hincrby($scope, '_SITE_PV_', 1);
	


	$json = json_encode($res);
	if(isset($_GET['callback'])){
		$json = $_GET['callback'].'('.$json.')';
	}
	echo $json;



?>
