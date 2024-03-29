<?php
require_once('config.inc.php');

header('Content-Type: application/javascript');
?>

$(function () {
	var referrer = document.referrer;
	var ajax = $.ajax({
		url: "<?= BASE_URL ?>/hi",
		type: 'GET',
		dataType: "jsonp",
		data: {ref: referrer}
	});
	ajax.done(function (json) {
		$(".cr_count_pv").each(function () {
			$(this).text(json.pv);
		});
		$(".cr_count_site_pv").each(function () {
			$(this).text(json.site_pv);
		});
		$(".cr_count_site_pv_24h").each(function () {
			$(this).text(json.site_pv_24h);
		});
		$(".cr_count_site_vv").each(function () {
			$(this).text(json.site_vv);
		});
		$(".cr_count_site_vv_24h").each(function () {
			$(this).text(json.site_vv_24h);
		});
		$(".cr_count_site_uv").each(function () {
			$(this).text(json.site_uv);
		});
		$(".cr_count_site_uv_24h").each(function () {
			$(this).text(json.site_uv_24h);
		});
	});
});
