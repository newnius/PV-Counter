<?php

require_once('util4p/util.php');
require_once('util4p/CRObject.class.php');
require_once('util4p/Random.class.php');
require_once('util4p/AccessController.class.php');
require_once('util4p/CRLogger.class.php');

require_once('Code.class.php');
require_once('SiteManager.class.php');
require_once('Spider.class.php');

require_once('config.inc.php');
require_once('init.inc.php');

function site_add(CRObject $site)
{
	if (Session::get('uid') === null) {
		$res['errno'] = Code::NOT_LOGED;
		return $res;
	}
	/*TODO: validate domain*/
	$rule = new CRObject();
	$rule->set('domain', $site->get('domain', ''));
	$rule->set('owner', Session::get('uid'));
	if (SiteManager::get($rule) !== null) {
		$res['errno'] = Code::RECORD_ALREADY_EXIST;
	} else {
		$res['errno'] = SiteManager::add($rule) ? Code::SUCCESS : Code::FAIL;
	}
	$log = new CRObject();
	$log->set('scope', Session::get('uid'));
	$log->set('tag', 'site.add');
	$content = array('domain' => $rule->get('domain'), 'response' => $res['errno']);
	$log->set('content', json_encode($content));
	CRLogger::log($log);
	return $res;
}

function site_remove(CRObject $site)
{
	if (Session::get('uid') === null) {
		$res['errno'] = Code::NOT_LOGED;
		return $res;
	}
	$rule = new CRObject();
	$rule->set('domain', $site->get('domain', ''));
	$rule->set('owner', Session::get('uid'));
	$res['errno'] = SiteManager::remove($rule) ? Code::SUCCESS : Code::FAIL;
	$log = new CRObject();
	$log->set('scope', Session::get('uid'));
	$log->set('tag', 'site.remove');
	$content = array('domain' => $rule->get('domain'), 'response' => $res['errno']);
	$log->set('content', json_encode($content));
	CRLogger::log($log);
	return $res;
}

function site_gets(CRObject $rule)
{
	if (Session::get('uid') === null) {
		$res['errno'] = Code::NOT_LOGED;
		return $res;
	}
	if($rule->get('who') !== 'all'){
		$rule->set('owner', Session::get('uid'));
	}
	if($rule->get('owner') === null || $rule->get('owner')!==Session::get('uid')){
		if(!AccessController::hasAccess(Session::get('role', 'visitor'), 'site.get_others')){
			$res['errno'] = Code::NO_PRIVILEGE;
			return $res;
		}
	}
	$res['sites'] = SiteManager::gets($rule);
	$res['errno'] = $res['sites'] === null?Code::FAIL:Code::SUCCESS;
	return $res;
}

function site_get_verify_filepath(CRObject $site)
{
	if (Session::get('uid') === null) {
		$res['errno'] = Code::NOT_LOGED;
		return $res;
	}
	$rule = new CRObject();
	$rule->set('domain', $site->get('domain'));
	$rule->set('owner', Session::get('uid'));
	if (SiteManager::get($rule) === null) {
		$res['errno'] = Code::RECORD_NOT_EXIST;
	} else {
		$res['errno'] = Code::SUCCESS;
		$res['filepath'] = Random::randomString(32) . '.txt';
		Session::put('filepath:' . $site->get('domain', ''), $res['filepath']);
	}
	return $res;
}

function site_verify(CRObject $site)
{
	if (Session::get('uid') === null) {
		$res['errno'] = Code::NOT_LOGED;
		return $res;
	}
	$filename = Session::get('filepath:' . $site->get('domain', ''), '');
	$url = 'http://' . $site->get('domain', '') . '/' . $filename;
	$spider = new Spider();

	$rule = new CRObject();
	$rule->set('domain', $site->get('domain', ''));
	$rule->set('owner', Session::get('uid'));
	if (SiteManager::get($rule) === null) {
		$res['errno'] = Code::RECORD_NOT_EXIST;
	} else if ($filename === '') {
		$res['errno'] = Code::FAIL;
	} else if (!$spider->doGet($url)) {
		$res['errno'] = Code::FAIL;
	} else if ($spider->getStatusCode() !== 200) {
		$res['errno'] = Code::FAIL;
		$res['msg'] = 'Server returns: ' . $spider->getStatusCode();
	} else {
		$rule->set('verified', 1);
		$res['errno'] = SiteManager::update($rule) ? Code::SUCCESS : Code::FAIL;
	}
	$log = new CRObject();
	$log->set('scope', Session::get('uid'));
	$log->set('tag', 'site.verify');
	$content = array('domain' => $rule->get('domain'), 'response' => $res['errno']);
	$log->set('content', json_encode($content));
	CRLogger::log($log);
	return $res;
}
