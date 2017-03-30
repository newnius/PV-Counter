<?php
	require_once('config.inc.php');
	require_once('util4p/util.php');
	require_once('util4p/Session.class.php');
	require_once('init.inc.php');
	$access_token = cr_get_GET('access_token', '');
	$userid = cr_get_GET('userid', '');

	// should be the same with callback in request
	$url = urlencode(BASE_URL.'/auth.php');

	$url = 'https://quickauth.newnius.com/auth.php?userid='.$userid.'&access_token='.$access_token.'&url='.$url;

	$response = cr_curl($url);
	if(!$response['err']){
		$data = $response['content'];
		$a_data = json_decode($data, true);
		if($a_data['errorno'] === 0){
			Session::put('username', $a_data['user']['username']);
			header('location: ucenter.php');
		}else{
			echo 'Auth failed';
			exit;
		}
	}
	echo $response['err'];
	exit;
