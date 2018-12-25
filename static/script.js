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