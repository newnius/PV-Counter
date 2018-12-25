function register_events_count() {
}

function load_counts() {
	var domain = getParameterByName('domain');
	$("#table-pattern").bootstrapTable({
		url: window.config.BASE_URL + '/service?action=count_gets&domain=' + domain,
		responseHandler: countResponseHandler,
		cache: true,
		striped: true,
		pagination: true,
		pageSize: 10,
		pageList: [10, 25, 50, 100, 200],
		search: true,
		showColumns: false,
		showRefresh: true,
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
			sortable: true,
			escape: true
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
	$('#modal-msg').modal('show');
	$('#modal-msg-content').text(res['msg']);
	return [];
}