$(function () {
	$("#btn-signout").click(function (e) {
		e.preventDefault();
		var ajax = $.ajax({
			url: window.config.BASE_URL + "/service?action=user_signout",
			type: 'POST',
			data: {}
		});
		ajax.done(function (res) {
			window.location.href = window.config.BASE_URL + '/';
		});
	});

	$("#btn-oauth-login").click(function (e) {
		e.preventDefault();
		var ajax = $.ajax({
			url: window.config.BASE_URL + "/service?action=oauth_get_url",
			type: 'POST',
			data: {}
		});
		ajax.done(function (res) {
			window.location.href = res['url'];
		});
	});
});