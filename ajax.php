<?php
	require_once('config.inc.php');
	require_once('util4p/util.php');
	require_once('util4p/CRObject.class.php');
	require_once('util4p/CRErrorCode.class.php');
	require_once('PatternManager.class.php');
	require_once('SiteManager.class.php');
	require_once('functions.php');
	require_once('init.inc.php');

	$res = array( 'errno' => CRErrorCode::UNKNOWN_REQUEST );


	$action = cr_get_GET('action');
	switch($action){
		case 'add_site':
			$site = new CRObject();
			$site->set('site', cr_get_POST('site'));
			$site->set('owner', Session::get('username'));
			$res = site_add($site);
			break;
		case 'remove_site':
			$site = new CRObject();
			$site->set('site', cr_get_POST('site'));
			$site->set('owner', Session::get('username'));
			$res = site_remove($site);
			break;
		case 'get_sites':
			$rule = new CRObject();
			$rule->set('owner', Session::get('username'));
			$res = site_gets($rule);
			break;
		case 'add_pattern':
			$site = cr_get_POST('site');
			$pattern = cr_get_POST('pattern');
			$res = pattern_add($site, $pattern);
			break;
		case 'remove_pattern':
			$site = cr_get_POST('site');
			$pattern = cr_get_POST('pattern');
			$res = pattern_remove($site, $pattern);
			break;
		case 'get_patterns':
			$rule = new CRObject();
			$rule->set('site', cr_get_GET('site'));
			$res = pattern_gets($rule);
			break;
		case 'get_verify_site_token':
			$site = cr_get_GET('site');
			$res = site_verify_token_get($site);
			break;
		case 'verify_site':
			$site = cr_get_POST('site');
			$res = site_verify($site);
			break;
		default:
			;
	}

	if(!isset($res['msg'])){
		$res['msg'] = CRErrorCode::getErrorMsg($res['errno']);
	}
	echo json_encode($res);
