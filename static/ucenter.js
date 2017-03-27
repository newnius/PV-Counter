$(function(){
	switch(page_type){
		case "logs":
			load_logs();
			break;
		case "sites":
			load_sites();
			register_events_site();
			break;
		case "patterns":
			load_patterns();
			register_events_pattern();
			break;
		case "changepwd":
			register_events_user();
			break;
		default:
			;
	}
});

function load_logs(){
	$table = $("#table-log");
	$table.bootstrapTable({
		url: 'ajax.php?action=get_signin_log',
		responseHandler: signinLogResponseHandler,
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
			sortable: true,
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

var signinLogResponseHandler = function(res){
	if(res['errno'] == 0){
		return res['logs'];
	}
	alert(res['msg']);
	return [];
}
