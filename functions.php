<?php
	require_once('config.inc.php');
	require_once('util4p/util.php');
	require_once('util4p/CRObject.class.php');
	require_once('util4p/CRErrorCode.class.php');
	require_once('util4p/Random.class.php');
	require_once('PatternManager.class.php');
	require_once('SiteManager.class.php');
	require_once('init.inc.php');

	function pattern_add($site, $pattern)
	{
		$rule = new CRObject();
		$rule->set('site', $site);
		$rule->set('owner', Session::get('username'));
		$site_tmp = SiteManager::get($rule);
		if($site_tmp===null){
			$res['errno'] = CRErrorCode::RECORD_NOT_EXIST;
			return $res;
		}
		if($site_tmp['status']!=1){
			$res['errno'] = CRErrorCode::NEED_VERIFY;
			return $res;
		}
		$res['errno'] = CRErrorCode::SUCCESS;
		if($site===null || $pattern===null){
			$res['errno'] = CRErrorCode::INCOMPLETE_CONTENT;
			return $res;
		}
		if(filter_var('http://'.$site.$pattern, FILTER_VALIDATE_URL) === FALSE){
			$res['errno'] = CRErrorCode::INVALID_PATTERN;
			return $res;
		}
		$success = PatternManager::save($site, $pattern);
		if(!$success){
			$res['errno'] = CRErrorCode::FAIL;
		}
		return $res;
	}


	function pattern_remove($site, $pattern)
	{
		$rule = new CRObject();
		$rule->set('site', $site);
		$rule->set('owner', Session::get('username'));
		$site_tmp = SiteManager::get($rule);
		if($site_tmp===null){
			$res['errno'] = CRErrorCode::RECORD_NOT_EXIST;
			return $res;
		}
		if($site_tmp['status']!=1){
			$res['errno'] = CRErrorCode::NEED_VERIFY;
			return $res;
		}
		$res['errno'] = CRErrorCode::SUCCESS;
		$success = PatternManager::remove($site, $pattern);
		if(!$success){
			$res['errno'] = CRErrorCode::FAIL;
		}
		return $res;
	}

	function pattern_gets($rule)
	{
		$rule_tmp = new CRObject();
		$rule_tmp->set('site', $rule->get('site'));
		$rule_tmp->set('owner', Session::get('username'));
		$site_tmp = SiteManager::get($rule_tmp);
		if($site_tmp===null){
			$res['errno'] = CRErrorCode::RECORD_NOT_EXIST;
			return $res;
		}
		if($site_tmp['status']!=1){
			$res['errno'] = CRErrorCode::NEED_VERIFY;
			return $res;
		}
		$res['errno'] = CRErrorCode::SUCCESS;
		$res['patterns'] = PatternManager::gets($rule);
		if($res['patterns']===null){
			$res['errno'] = CRErrorCode::FAIL;
		}
		return $res;
	}

	function site_add($site)
	{
		$rule = new CRObject();
		$rule->set('site', $site->get('site'));
		$rule->set('owner', Session::get('username'));
		$site_tmp = SiteManager::get($rule);
		if($site_tmp!==null){
			$res['errno'] = CRErrorCode::RECORD_ALREADY_EXIST;
			return $res;
		}
		$res['errno'] = CRErrorCode::SUCCESS;
		$success = SiteManager::add($site);
		if(!$success){
			$res['errno'] = CRErrorCode::FAIL;
		}
		return $res;
	}

	function site_remove($site)
	{
		$rule = new CRObject();
		$rule->set('site', $site->get('site'));
		$rule->set('owner', Session::get('username'));
		$site_tmp = SiteManager::get($rule);
		if($site_tmp===null){
			$res['errno'] = CRErrorCode::RECORD_NOT_EXIST;
			return $res;
		}
		$res['errno'] = CRErrorCode::SUCCESS;
		$success = SiteManager::remove($site);
		if(!$success){
			$res['errno'] = CRErrorCode::FAIL;
		}
		return $res;
	}

	function site_gets($rule)
	{
		$res['errno'] = CRErrorCode::SUCCESS;
		$res['sites'] = SiteManager::gets($rule);
		if($res['sites']===null){
			$res['errno'] = CRErrorCode::FAIL;
		}
		return $res;
	}

	function site_verify_token_get($site)
	{
		if($site===null){
			$res['errno'] = CRErrorCode::CAN_NOT_BE_EMPTY;
			return $res;
		}
		$res['errno'] = CRErrorCode::SUCCESS;
		$res['token'] = Random::randomString(18).'.txt';
		Session::put('token_'.$site, $res['token']);
		return $res;
	}

	function site_verify($site)
	{
		$rule = new CRObject();
		$rule->set('site', $site);
		$rule->set('owner', Session::get('username'));
		$site_tmp = SiteManager::get($rule);
		if($site_tmp===null){
			$res['errno'] = CRErrorCode::RECORD_NOT_EXIST;
			return $res;
		}
		$token = Session::get('token_'.$site);
		if($token===null){
			$res['errno'] = CRErrorCode::FAIL;
			return $res;
		}
		$url = 'http://'.$site.'/'.$token;
		$response = cr_curl($url);
		if($response['err']){
			$res['errno'] = CRErrorCode::FAIL;
			$res['msg'] = $response['err'];
			return $res;
		}
		if($response['headers']['http_code'] !== 200){
			$res['errno'] = CRErrorCode::FAIL;
			$res['msg'] = 'Server returns: '.$response['headers']['http_code'];
			return $res;
		}
		$site_arr = new CRObject();
		$site_arr->set('site', $site);
		$site_arr->set('owner', $rule->get('owner'));
		$site_arr->set('status', 1);
		
		$success = SiteManager::update($site_arr);
		if(!$success){
			$res['errno'] = CRErrorCode::FAIL;
		}
		$res['errno'] = CRErrorCode::SUCCESS;
		return $res;
	}
