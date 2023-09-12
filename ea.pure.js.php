<?php
require_once('config.inc.php');

header('Content-Type: application/javascript');
?>

function cr_count_jsonp(url, callback) {
  var callbackName = 'jsonp_callback_' + Math.round(100000 * Math.random());
  window[callbackName] = function(data) {
    delete window[callbackName];
    document.body.removeChild(script);
    callback(data);
  };

  var script = document.createElement('script');
  script.src = url + (url.indexOf('?') >= 0 ? '&' : '?') + 'callback=' + callbackName + '&ref=' + document.referrer;
  document.body.appendChild(script);
}

function cr_count_replaceall(clazz, value) {
  var els = document.getElementsByClassName(clazz);
  Array.prototype.forEach.call(els, function(el) {
    el.innerHTML = value;
  });
}

cr_count_jsonp('<?= BASE_URL ?>/hi', function(data) {
  cr_count_replaceall('cr_count_pv', data.pv);
  cr_count_replaceall('cr_count_site_pv', data.site_pv);
  cr_count_replaceall('cr_count_site_pv_24h', data.site_pv_24h);
  cr_count_replaceall('cr_count_site_vv', data.site_vv);
  cr_count_replaceall('cr_count_site_vv_24h', data.site_vv_24h);
  cr_count_replaceall('cr_count_site_uv', data.site_uv);
  cr_count_replaceall('cr_count_site_uv_24h', data.site_uv_24h);
});