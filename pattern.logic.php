<?php

require_once('util4p/util.php');
require_once('util4p/Random.class.php');
require_once('util4p/CRObject.class.php');
require_once('util4p/CRLogger.class.php');

require_once('Code.class.php');
require_once('PatternManager.class.php');

require_once('config.inc.php');
require_once('init.inc.php');

function pattern_add($domain, $pattern)
{
	if (Session::get('uid') === null) {
		$res['errno'] = Code::NOT_LOGED;
		return $res;
	}
	$rule = new CRObject();
	$rule->set('domain', $domain);
	$rule->set('owner', Session::get('uid'));
	$site = SiteManager::get($rule);
	if ($site === null) {
		$res['errno'] = Code::RECORD_NOT_EXIST;
	} else if ($site['verified'] !== "1") {
		$res['errno'] = Code::NEED_VERIFY;
	} else if ($domain === null || $pattern === null) {
		$res['errno'] = Code::INCOMPLETE_CONTENT;
	} else if (filter_var('http://' . $domain . $pattern, FILTER_VALIDATE_URL) === FALSE) {
		$res['errno'] = Code::INVALID_PATTERN;
	} else {
		$uri = parse_url('http://' . $domain . $pattern);
		if ($uri && isset($uri['path']) && isset($uri['query'])) {
			$res['errno'] = PatternManager::save($domain, $pattern) ? Code::SUCCESS : Code::FAIL;
		} else {
			$res['errno'] = Code::INVALID_PATTERN;
		}
	}
	$log = new CRObject();
	$log->set('scope', Session::get('uid'));
	$log->set('tag', 'pattern.add');
	$content = array('domain' => $rule->get('domain'), 'pattern' => $pattern, 'response' => $res['errno']);
	$log->set('content', json_encode($content));
	CRLogger::log($log);
	return $res;
}

function pattern_remove($domain, $pattern)
{
	if (Session::get('uid') === null) {
		$res['errno'] = Code::NOT_LOGED;
		return $res;
	}
	$rule = new CRObject();
	$rule->set('domain', $domain);
	$rule->set('owner', Session::get('uid'));
	$site = SiteManager::get($rule);
	if ($site === null) {
		$res['errno'] = Code::RECORD_NOT_EXIST;
	} else if ($domain === null || $pattern === null) {
		$res['errno'] = Code::INCOMPLETE_CONTENT;
	} else if ($site['verified'] !== "1") {
		$res['errno'] = Code::NEED_VERIFY;
	} else {
		$res['errno'] = PatternManager::remove($domain, $pattern) ? Code::SUCCESS : Code::FAIL;
	}
	$log = new CRObject();
	$log->set('scope', Session::get('uid'));
	$log->set('tag', 'pattern.remove');
	$content = array('domain' => $rule->get('domain'), 'pattern' => $pattern, 'response' => $res['errno']);
	$log->set('content', json_encode($content));
	CRLogger::log($log);
	return $res;
}

function pattern_gets($domain)
{
	if (Session::get('uid') === null) {
		$res['errno'] = Code::NOT_LOGED;
		return $res;
	}
	$rule = new CRObject();
	$rule->set('domain', $domain);
	$rule->set('owner', Session::get('uid'));
	$site = SiteManager::get($rule);
	if ($site === null) {
		$res['errno'] = Code::RECORD_NOT_EXIST;
	} else if ($site['verified'] !== "1") {
		$res['errno'] = Code::NEED_VERIFY;
		return $res;
	} else {
		$res['errno'] = Code::SUCCESS;
		$res['patterns'] = PatternManager::gets($domain);
		if ($res['patterns'] === null) {
			$res['errno'] = Code::FAIL;
		}
	}
	return $res;
}
