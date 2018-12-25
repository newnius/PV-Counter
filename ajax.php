<?php

require_once('util4p/util.php');
require_once('util4p/CRObject.class.php');

require_once('Code.class.php');
require_once('PatternManager.class.php');
require_once('SiteManager.class.php');
require_once('Securer.class.php');

require_once('user.logic.php');
require_once('site.logic.php');
require_once('pattern.logic.php');
require_once('count.logic.php');

require_once('config.inc.php');
require_once('init.inc.php');


function csrf_check($action)
{
	/* check referer, just in case I forget to add the method to $post_methods */
	$referer = cr_get_SERVER('HTTP_REFERER', '');
	$url = parse_url($referer);
	$host = isset($url['host']) ? $url['host'] : '';
	$host .= isset($url['port']) && $url['port'] !== 80 ? ':' . $url['port'] : '';
	if ($host !== cr_get_SERVER('HTTP_HOST')) {
		return false;
	}
	$post_methods = array(
		'site_add',
		'site_remove',
		'pattern_add',
		'pattern_remove',
		'site_verify',
		'user_signout'
	);
	if (in_array($action, $post_methods)) {
		return Securer::validate_csrf_token();
	}
	return true;
}

function print_response($res)
{
	if (!isset($res['msg']))
		$res['msg'] = Code::getErrorMsg($res['errno']);
	$json = json_encode($res);
	header('Content-type: application/json');
	echo $json;
}


$res = array('errno' => Code::UNKNOWN_REQUEST);

$action = cr_get_GET('action');

if (!csrf_check($action)) {
	$res['errno'] = 99;
	$res['msg'] = 'invalid csrf_token';
	print_response($res);
	exit(0);
}

switch ($action) {
	case 'site_add':
		$site = new CRObject();
		$site->set('domain', cr_get_POST('domain'));
		$res = site_add($site);
		break;

	case 'site_remove':
		$site = new CRObject();
		$site->set('domain', cr_get_POST('domain'));
		$res = site_remove($site);
		break;

	case 'site_gets':
		$rule = new CRObject();
		$rule->set('who', cr_get_GET('who', 'self'));
		$res = site_gets($rule);
		break;

	case 'pattern_add':
		$domain = cr_get_POST('domain');
		$pattern = cr_get_POST('pattern');
		$res = pattern_add($domain, $pattern);
		break;

	case 'pattern_remove':
		$domain = cr_get_POST('domain');
		$pattern = cr_get_POST('pattern');
		$res = pattern_remove($domain, $pattern);
		break;

	case 'pattern_gets':
		$domain = cr_get_GET('domain');
		$res = pattern_gets($domain);
		break;

	case 'site_get_verify_filepath':
		$site = new CRObject();
		$site->set('domain', cr_get_GET('domain'));
		$res = site_get_verify_filepath($site);
		break;

	case 'site_verify':
		$site = new CRObject();
		$site->set('domain', cr_get_POST('domain'));
		$res = site_verify($site);
		break;

	case 'count_gets':
		$domain = cr_get_GET('domain');
		$res = count_gets($domain);
		break;

	case 'user_signout':
		$res = user_signout();
		break;

	case 'log_gets':
		$rule = new CRObject();
		$rule->set('who', cr_get_GET('who', 'self'));
		$rule->set('offset', cr_get_GET('offset'));
		$rule->set('limit', cr_get_GET('limit'));
		$rule->set('order', 'latest');
		$res = log_gets($rule);
		break;

	case 'oauth_get_url':
		$res = oauth_get_url();
		break;

	default:
		break;
}

print_response($res);
