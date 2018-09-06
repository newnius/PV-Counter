<?php

require_once('predis/autoload.php');
require_once('util4p/CRObject.class.php');
require_once('util4p/ReSession.class.php');
require_once('util4p/RedisDAO.class.php');

require_once('Code.class.php');
require_once('Counter.class.php');
require_once('SiteManager.class.php');

require_once('config.inc.php');
require_once('init.inc.php');

function count_gets($domain)
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
	} else {
		$res['errno'] = Code::SUCCESS;
		$res['counts'] = Counter::gets($domain);
		if ($res['counts'] === null) {
			$res['errno'] = Code::FAIL;
		}
	}
	return $res;
}