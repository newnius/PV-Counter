function register_events_site() {
	$('#btn-site-add').click(function (e) {
		$('#form-site-domain').val('');
		$('#form-site-port').val('80');
		$("#form-site-msg").html('');
		$('#modal-site').modal('show');
	});

	$("#form-site-submit").click(function (e) {
		$('#modal-site').modal('hide');
		var domain = $("#form-site-domain").val();
		var port = $("#form-site-port").val();
		if (port !== "" && port !== "80")
			domain += ":" + port;
		var ajax = $.ajax({
			url: window.config.BASE_URL + "/service?action=site_add",
			type: 'POST',
			data: {domain: domain}
		});
		ajax.done(function (res) {
			if (res["errno"] !== 0) {
				$('#modal-msg').modal('show');
				$('#modal-msg-content').text(res['msg']);
			}
			$('#table-site').bootstrapTable("refresh");
		});
		ajax.fail(function (jqXHR, textStatus) {
			$('#modal-msg').modal('show');
			$('#modal-msg-content').text("Request failed :" + textStatus);
		});
	});

	$("#btn-verify-site").click(function (e) {
		$('#modal-verify-site').modal('hide');
		var domain = $("#input-verify-site").val();
		var ajax = $.ajax({
			url: window.config.BASE_URL + "/service?action=site_verify",
			type: 'POST',
			data: {domain: domain}
		});
		ajax.done(function (res) {
			if (res["errno"] !== 0) {
				$('#modal-msg').modal('show');
				$('#modal-msg-content').text(res['msg']);
			}
			$('#table-site').bootstrapTable("refresh");
		});
		ajax.fail(function (jqXHR, textStatus) {
			$('#modal-msg').modal('show');
			$('#modal-msg-content').text("Request failed :" + textStatus);
		});
	});
}

function load_sites(scope) {
	$("#table-site").bootstrapTable({
		url: window.config.BASE_URL + '/service?action=site_gets&who=' + scope,
		responseHandler: siteResponseHandler,
		cache: true,
		striped: true,
		pagination: false,
		pageSize: 10,
		pageList: [10, 25, 50, 100, 200],
		search: false,
		showColumns: false,
		showRefresh: false,
		showToggle: false,
		showPaginationSwitch: false,
		minimumCountColumns: 2,
		clickToSelect: false,
		sortName: 'nobody',
		sortOrder: 'desc',
		smartDisplay: true,
		mobileResponsive: true,
		showExport: false,
		columns: [{
			field: 'selected',
			title: 'Select',
			checkbox: true
		}, {
			field: 'owner',
			title: 'Owner',
			align: 'center',
			valign: 'middle',
			sortable: true,
			visible: scope === 'all'
		}, {
			field: 'domain',
			title: 'Domain',
			align: 'center',
			valign: 'middle',
			sortable: false,
			escape: true
		}, {
			field: 'verified',
			title: 'Verified',
			align: 'center',
			valign: 'middle',
			sortable: false,
			formatter: statusFormatter
		}, {
			field: 'operate',
			title: 'Operate',
			align: 'center',
			events: siteOperateEvents,
			formatter: siteOperateFormatter
		}]
	});
}

function statusFormatter(verified, row, index) {
	switch (verified) {
		case '0':
			return '<a href="javascript:show_verify_site_modal(\'' + encodeURI(row.domain) + '\')">Verify</a>';
		case '1':
			return 'Verified';
		default:
			return 'Unknown';
	}
}

function siteResponseHandler(res) {
	if (res['errno'] === 0) {
		return res['sites'];
	}
	$('#modal-msg').modal('show');
	$('#modal-msg-content').text(res['msg']);
	return [];
}

function siteOperateFormatter(value, row, index) {
	return [
		'<div class="btn-group" role="group" aria-label="...">',
		'<button class="btn btn-default counts">',
		'<i class="glyphicon glyphicon-eye-open"></i>&nbsp;',
		'</button>',
		'<button class="btn btn-default patterns">',
		'<i class="glyphicon glyphicon-cog"></i>&nbsp;',
		'</button>',
		'<button class="btn btn-default remove">',
		'<i class="glyphicon glyphicon-remove"></i>&nbsp;',
		'</button>&nbsp;',
		'</div>'
	].join('');
}

window.siteOperateEvents = {
	'click .patterns': function (e, value, row, index) {
		window.location.href = window.config.BASE_URL + "/ucenter?patterns&domain=" + row.domain;
	},
	'click .counts': function (e, value, row, index) {
		window.location.href = window.config.BASE_URL + "/ucenter?counts&domain=" + row.domain;
	},
	'click .remove': function (e, value, row, index) {
		if (!confirm('Are you sure to delete this site (permanently) ?')) {
			return;
		}
		var ajax = $.ajax({
			url: window.config.BASE_URL + "/service?action=site_remove",
			type: 'POST',
			data: {domain: row.domain}
		});
		ajax.done(function (res) {
			if (res["errno"] !== 0) {
				$('#modal-msg').modal('show');
				$('#modal-msg-content').text(res['msg']);
			}
			$('#table-site').bootstrapTable("refresh");
		});
		ajax.fail(function (jqXHR, textStatus) {
			$('#modal-msg').modal('show');
			$('#modal-msg-content').text("Request failed :" + textStatus);
		});
	}
};

function show_verify_site_modal(domain) {
	$('#modal-verify-site-site').text(domain);
	$("#btn-verify-site").attr("disabled", "disabled");
	$("#verify-site-msg").text('');
	$('#modal-verify-site').modal('show');
	var ajax = $.ajax({
		url: window.config.BASE_URL + "/service?action=site_get_verify_filepath",
		type: 'GET',
		data: {domain: domain}
	});
	ajax.done(function (res) {
		if (res["errno"] === 0) {
			var url = window.config.BASE_URL + '/download?filepath=' + res.filepath;
			$('#modal-verify-site-file').html('<a target="_blank" href="' + url + '">download</a>');
			$("#input-verify-site").val(domain);
			$("#btn-verify-site").removeAttr("disabled");
		} else {
			$("#verify-site-msg").html(res["msg"]);
		}
	});
}
