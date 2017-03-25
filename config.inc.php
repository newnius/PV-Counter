<?php
  header("content-type:text/html; charset=utf-8");
  date_default_timezone_set('Asia/Shanghai');//'Asia/Shanghai'   亚洲/上海

  // database  information 
  define('DB_HOST', 'localhost');
  define('DB_PORT', 3307);
  define('DB_NAME', 'analytics');
  define('DB_USER', 'root');
  define('DB_PASSWORD', '123456');

  define('REDIS_SCHEME', 'tcp');
  define('REDIS_HOST', '192.168.56.110');
  define('REDIS_PORT', 6379);

  define('WEBROOT', __DIR__);

  //make absolute url for SEO and avoid hijack
  define('BASE_URL', 'http://192.168.56.105/ana');//网站地址，没有最后的/
  
  // if not vefified, not allowed to login	
  define('FORCE_VERIFY', false);
 
  define('BIND_COOKIE_WITH_IP', false);
  define('BIND_SESSION_WITH_IP', true);
  define('SESSION_TIME_OUT', 1800);// 30min = 30*60
