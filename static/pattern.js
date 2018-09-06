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
		$("#form-pattern-submit").attr("disabled", "disabled");
		var pattern = $("#form-pattern-pattern").val();
		var ajax = $.ajax({
			url: "ajax.php?action=pattern_add",
			type: 'POST',
			data: {
				domain: domain,
				pattern: pattern
			}
		});
		ajax.done(function (res) {
			if (res["errno"] === 0) {
				$('#modal-pattern').modal('hide');
				$('#table-pattern').bootstrapTable("refresh");
			} else {
				$("#form-pattern-msg").html(res["msg"]);
				$("#modal-pattern").effect("shake");
			}
			$("#form-pattern-submit").removeAttr("disabled");
		});
		ajax.fail(function (jqXHR, textStatus) {
			alert("Request failed :" + textStatus);
			$("#form-pattern-submit").removeAttr("disabled");
		});
	});
}

function load_patterns() {
	var domain = getParameterByName('domain');
	var $table = $("#table-pattern");
	$table.bootstrapTable({
		url: 'ajax.php?action=pattern_gets&domain=' + domain,
		responseHandler: patternResponseHandler,
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
			field: 'pattern',
			title: 'Pattern',
			align: 'center',
			valign: 'middle',
			sortable: false
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
	alert(res['msg']);
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
			url: "ajax.php?action=pattern_remove",
			type: 'POST',
			data: {
				domain: domain,
				pattern: pattern
			}
		});
		ajax.done(function (res) {
			if (res["errno"] === 0) {
				$('#table-pattern').bootstrapTable("refresh");
			} else {
				alert(res["msg"]);
			}
		});
	}
};
