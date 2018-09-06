function register_events_count() {
}

function load_counts() {
	var domain = getParameterByName('domain');
	var $table = $("#table-pattern");
	$table.bootstrapTable({
		url: 'ajax.php?action=count_gets&domain=' + domain,
		responseHandler: countResponseHandler,
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
			field: 'metric',
			title: 'Metric',
			align: 'center',
			valign: 'middle',
			sortable: true
		}, {
			field: 'page',
			title: 'Page',
			align: 'center',
			valign: 'middle',
			sortable: true
		}, {
			field: 'count',
			title: 'Count',
			align: 'center',
			valign: 'middle',
			sortable: true
		}]
	});
}

function countResponseHandler(res) {
	var records = [];
	if (res['errno'] === 0) {
		var patterns = res["counts"];
		$.each(patterns, function (index, value) {
			var tmp = index.split(":");
			var record = {"metric": tmp[0], "page": tmp[1], "count": value};
			records.push(record);
		});
		return records;
	}
	alert(res['msg']);
	return [];
}