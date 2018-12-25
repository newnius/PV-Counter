<?php

/* Site */
define('BASE_URL', 'http://127.0.0.1'); //make absolute url for SEO and avoid hijack, no '/' at the end
define('WEBROOT', __DIR__);
define('FORCE_VERIFY', false); // if not verified, not allowed to login
define('FEEDBACK_EMAIL', 'support@newnius.com');

/* Mysql */
/* It is not recommended to use `root` in production environment */
define('DB_HOST', 'localhost');
define('DB_PORT', 3306);
define('DB_NAME', 'analytics');
define('DB_USER', 'db_user');
define('DB_PASSWORD', 'password');
define('DB_SHOW_ERROR', false);

/* Redis */
/* Make sure that your Redis only listens to Intranet */
define('REDIS_SCHEME', 'tcp');
define('REDIS_HOST', '127.0.0.1');
define('REDIS_PORT', 6379);
define('REDIS_SHOW_ERROR', false);

/* Session */
define('ENABLE_MULTIPLE_LOGIN', true);
define('BIND_SESSION_WITH_IP', false);
define('SESSION_TIME_OUT', 1800);// 30 minutes 30*60=1800
define('ENABLE_COOKIE', true);

/* OAuth */
define('OAUTH_SITE', 'https://quickauth.newnius.com');
define('OAUTH_CLIENT_ID', 'XgaII6NxeE08LtKB');
define('OAUTH_CLIENT_SECRET', 'L9hdi4dQToM0GsDLtcYYQ3k4ZDEjuGVOtPS3nOVKlo6cxLcVjH9TqvmTBiHAgLp2');


header("content-type:text/html; charset=utf-8");

date_default_timezone_set('Asia/Shanghai');