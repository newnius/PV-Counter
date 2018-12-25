function register_events_pattern() {
	var domain = getParameterByName('domain');
	var site = domain.split(":");
	var port = 80;
	if (site.length === 2)
		port = site[1];
	$("#form-pattern-domain").val(site[0]);
	$("#form-pattern-port").val(port);

	$('#btn-pattern-add').click(function (e) {
		$('#modal-pattern').modal('show');
		$("#form-pattern-pattern").val('');
		$("#form-pattern-msg").html('');
	});

	$("#form-pattern-submit").click(function (e) {
		var pattern = $("#form-pattern-pattern").val();
		if (pattern.length === 0) {
			return true;
		}
		$('#modal-pattern').modal('hide');
		var ajax = $.ajax({
			url: window.config.BASE_URL + "/service?action=pattern_add",
			type: 'POST',
			data: {
				domain: domain,
				pattern: pattern
			}
		});
		ajax.done(function (res) {
			if (res["errno"] !== 0) {
				$('#modal-msg').modal('show');
				$('#modal-msg-content').text(res['msg']);
			}
			$('#table-pattern').bootstrapTable("refresh");
		});
		ajax.fail(function (jqXHR, textStatus) {
			$('#modal-msg').modal('show');
			$('#modal-msg-content').text("Request failed :" + textStatus);
		});
	});
}

function load_patterns() {
	var domain = getParameterByName('domain');
	$("#table-pattern").bootstrapTable({
		url: window.config.BASE_URL + '/service?action=pattern_gets&domain=' + domain,
		responseHandler: patternResponseHandler,
		cache: true,
		striped: true,
		pagination: true,
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
			field: 'pattern',
			title: 'Pattern',
			align: 'center',
			valign: 'middle',
			sortable: true,
			escape: true
		}, {
			field: 'operate',
			title: 'Operate',
			align: 'center',
			events: patternOperateEvents,
			formatter: patternOperateFormatter
		}]
	});
}

function patternResponseHandler(res) {
	var records = [];
	if (res['errno'] === 0) {
		var patterns = res["patterns"];
		$.each(patterns, function (index, value) {
			var record = {"pattern": value};
			records.push(record);
		});
		return records;
	}
	$('#modal-msg').modal('show');
	$('#modal-msg-content').text(res['msg']);
	return [];
}

function patternOperateFormatter(value, row, index) {
	return [
		'<button class="btn btn-default remove">',
		'<i class="glyphicon glyphicon-remove"></i>&nbsp;',
		'</button>'
	].join('');
}

window.patternOperateEvents = {
	'click .remove': function (e, value, row, index) {
		var domain = $("#form-pattern-domain").val();
		var port = $("#form-pattern-port").val();
		if (port !== "" && port !== "80")
			domain += ":" + port;
		var pattern = row.pattern;
		if (!confirm('Are you sure to remove this pattern (permanently) ?')) {
			return;
		}
		var ajax = $.ajax({
			url: window.config.BASE_URL + "/service?action=pattern_remove",
			type: 'POST',
			data: {
				domain: domain,
				pattern: pattern
			}
		});
		ajax.done(function (res) {
			if (res["errno"] !== 0) {
				$('#modal-msg').modal('show');
				$('#modal-msg-content').text(res['msg']);
			}
			$('#table-pattern').bootstrapTable("refresh");
		});
		ajax.fail(function (jqXHR, textStatus) {
			$('#modal-msg').modal('show');
			$('#modal-msg-content').text("Request failed :" + textStatus);
		});
	}
};
