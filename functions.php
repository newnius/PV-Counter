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
		$res['errno'] = CRErrorCode::SUCCESS;
		$res['token'] = Random::randomString(18).'.txt';
		return $res;
	}

	function site_verify($site)
	{
		$res['errno'] = CRErrorCode::IN_DEVELOP;
		return $res;
	}
