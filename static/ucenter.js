$(function () {
	switch (page_type) {
		case "logs":
			load_logs('self');
			break;
		case "logs_all":
			load_logs('all');
			break;
		case "sites":
			load_sites('self');
			register_events_site();
			break;
		case "sites_all":
			load_sites('all');
			register_events_site();
			break;
		case "patterns":
			load_patterns();
			register_events_pattern();
			break;
		case "counts":
			load_counts();
			register_events_count();
			break;
		default:
			break;
	}
});

function load_logs(scope) {
	var $table = $("#table-log");
	$table.bootstrapTable({
		url: 'ajax.php?action=log_gets&who=' + scope,
		responseHandler: logResponseHandler,
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
		sortName: 'default',
		sortOrder: 'desc',
		smartDisplay: true,
		mobileResponsive: true,
		showExport: false,
		columns: [{
			field: 'scope',
			title: 'UID',
			align: 'center',
			valign: 'middle',
			sortable: false,
			visible: scope==='all'
		}, {
			field: 'tag',
			title: 'Tag',
			align: 'center',
			valign: 'middle',
			sortable: false
		}, {
			field: 'time',
			title: 'Time',
			align: 'center',
			valign: 'middle',
			sortable: false,
			formatter: timeFormatter
		}, {
			field: 'ip',
			title: 'IP',
			align: 'center',
			valign: 'middle',
			sortable: false,
			formatter: long2ip
		}, {
			field: 'content',
			title: 'Content',
			align: 'center',
			valign: 'middle',
			sortable: false
		}]
	});
}

var logResponseHandler = function (res) {
	if (res['errno'] === 0) {
		return res['logs'];
	}
	alert(res['msg']);
	return [];
};
