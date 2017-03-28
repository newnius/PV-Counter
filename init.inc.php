<?php
	require_once('predis/autoload.php');
	require_once('config.inc.php');
	require_once('util4p/MysqlPDO.class.php');
	require_once('util4p/RedisDAO.class.php');
	require_once('util4p/Session.class.php');
	require_once('util4p/CRObject.class.php');

	init_mysql();
	init_redis();
	init_Session();

	function init_mysql(){
		$config = new CRObject();
		$config->set('host', DB_HOST);
		$config->set('port', DB_PORT);
		$config->set('db', DB_NAME);
		$config->set('user', DB_USER);
		$config->set('password', DB_PASSWORD);
		MysqlPDO::configure($config);
	}

	function init_redis(){
		$config = new CRObject();
		$config->set('scheme', REDIS_SCHEME);
		$config->set('host', REDIS_HOST);
		$config->set('port', REDIS_PORT);
		$config->set('show_error', REDIS_SHOW_ERROR);
		RedisDAO::configure($config);
	}

	function init_Session(){
		$config = new CRObject();
		$config->set('time_out', SESSION_TIME_OUT);
		$config->set('bind_ip', BIND_SESSION_WITH_IP);
		Session::configure($config);
	}
