function register_events_site() {
	$('#btn-site-add').click(function (e) {
		$('#form-site-domain').val('');
		$('#form-site-port').val('80');
		$("#form-site-msg").html('');
		$('#modal-site').modal('show');
	});

	$("#form-site-submit").click(function (e) {
		$("#form-site-submit").attr("disabled", "disabled");
		var domain = $("#form-site-domain").val();
		var port = $("#form-site-port").val();
		if (port !== "" && port !== "80")
			domain += ":" + port;
		var ajax = $.ajax({
			url: "ajax.php?action=site_add",
			type: 'POST',
			data: {domain: domain}
		});
		ajax.done(function (res) {
			if (res["errno"] === 0) {
				$('#modal-site').modal('hide');
				$('#table-site').bootstrapTable("refresh");
			} else {
				$("#form-site-msg").html(res["msg"]);
				$("#modal-site").effect("shake");
			}
			$("#form-site-submit").removeAttr("disabled");
		});
		ajax.fail(function (jqXHR, textStatus) {
			alert("Request failed :" + textStatus);
			$("#form-site-submit").removeAttr("disabled");
		});
	});

	$("#btn-verify-site").click(function (e) {
		$("#btn-verify-site").attr("disabled", "disabled");
		$("#verify-site-msg").text('Pending...');
		var domain = $("#input-verify-site").val();
		var ajax = $.ajax({
			url: "ajax.php?action=site_verify",
			type: 'POST',
			data: {domain: domain}
		});
		ajax.done(function (res) {
			if (res["errno"] === 0) {
				$('#modal-verify-site').modal('hide');
				$('#table-site').bootstrapTable("refresh");
			} else {
				$("#verify-site-msg").text(res["msg"]);
				$("#modal-verify-site").effect("shake");
			}
			$("#btn-verify-site").removeAttr("disabled");
		});
		ajax.fail(function (jqXHR, textStatus) {
			alert("Request failed :" + textStatus);
			$("#btn-verify-site").removeAttr("disabled");
		});
	});
}

function load_sites(scope) {
	var $table = $("#table-site");
	$table.bootstrapTable({
		url: 'ajax.php?action=site_gets&who=' + scope,
		responseHandler: siteResponseHandler,
		cache: true,
		striped: true,
		pagination: false,
		pageSize: 25,
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
			visible: scope==='all'
		}, {
			field: 'domain',
			title: 'Domain',
			align: 'center',
			valign: 'middle',
			sortable: false
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
			return '<a href="javascript:show_verify_site_modal(\'' + row.domain + '\')">Verify</a>';
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
	alert(res['msg']);
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
		window.location.href = "ucenter.php?patterns&domain=" + row.domain;
	},
	'click .counts': function (e, value, row, index) {
		window.location.href = "ucenter.php?counts&domain=" + row.domain;
	},
	'click .remove': function (e, value, row, index) {
		if (!confirm('Are you sure to delete this site (permanently) ?')) {
			return;
		}
		var ajax = $.ajax({
			url: "ajax.php?action=site_remove",
			type: 'POST',
			data: {domain: row.domain}
		});
		ajax.done(function (res) {
			if (res["errno"] === 0) {
				$('#table-site').bootstrapTable("refresh");
			} else {
				alert(res['msg']);
			}
		});
	}
};

function show_verify_site_modal(domain) {
	$('#modal-verify-site-site').text(domain);
	$("#btn-verify-site").attr("disabled", "disabled");
	$("#verify-site-msg").text('');
	$('#modal-verify-site').modal('show');
	var ajax = $.ajax({
		url: "ajax.php?action=site_get_verify_filepath",
		type: 'GET',
		data: {domain: domain}
	});
	ajax.done(function (res) {
		if (res["errno"] === 0) {
			var url = '/download.php?filepath=' + res.filepath;
			$('#modal-verify-site-file').html('<a target="_blank" href="' + url + '">download</a>');
			$("#input-verify-site").val(domain);
			$("#btn-verify-site").removeAttr("disabled");
		} else {
			$("#verify-site-msg").html(res["msg"]);
		}
	});
}
