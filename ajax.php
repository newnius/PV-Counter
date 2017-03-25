<?php
	//var_dump($_SERVER);
	require_once('util4p/util.php');
	require_once('predis/autoload.php');
	require_once('util4p/RedisDAO.class.php');
	require_once('util4p/CRObject.class.php');
	require_once('util4p/CRErrorCode.class.php');
	require_once('PatternManager.class.php');

	$config = new CRObject();
	$config->set('scheme', 'tcp');
	$config->set('host', '192.168.56.110');
	$config->set('port', '6379');
	RedisDAO::configure($config);

	$res = array( 'errno' => CRErrorCode::UNKNOWN_REQUEST );


	$action = cr_get_GET('action');
	switch($action){
		case 'add_pattern':
			$site = cr_get_GET('site');
			$pattern = cr_get_GET('pattern');
			$res = pattern_add($site, $pattern);
			break;
		case 'remove_pattern':
			$res = pattern_remove(null);
			break;
		case 'get_patterns':
			$res = pattern_gets(null);
			break;
		default:
			;
	}

	if(!isset($res['msg'])){
		$res['msg'] = CRErrorCode::getErrorMsg($res['errno']);
	}
	echo json_encode($res);


	function pattern_add($site, $pattern){
		$res['errno'] = CRErrorCode::SUCCESS;
		if($site===null || $pattern===null){
			$res['errno'] = CRErrorCode::INCOMPLETE_CONTENT;
			return $res;
		}
		if(filter_var('http://'.$site.$pattern, FILTER_VALIDATE_URL) === FALSE){
			$res['errno'] = CRErrorCode::FAIL;
		}
		$success = PatternManager::save($site, $pattern);
		if(!$success){
			$res['errno'] = CRErrorCode::FAIL;
		}
		return $res;
	}
	function pattern_remove($pattern){
		$res['errno'] = CRErrorCode::IN_DEVELOP;
		return $res;
	}
	function pattern_gets($rule){
		$res['errno'] = CRErrorCode::IN_DEVELOP;
		return $res;
	}

