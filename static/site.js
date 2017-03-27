function register_events_site()
{
	$('#btn-site-add').click(function(e){
		$('#form-site-domain').val('');
		$('#form-site-port').val('80');
		$('#modal-site').modal('show');
	});

	$("#form-site-submit").click(function(e){
		$("#form-site-submit").attr("disabled", "disabled");
		var domain = $("#form-site-domain").val();
		var port = $("#form-site-port").val();
		var site = domain;
		if(port != "" && port!= "80")
			site += ":" + port;
		var ajax = $.ajax({
			url: "ajax.php?action=add_site",
			type: 'POST',
			data: { site: site }
		});
		ajax.done(function(json){
			var res = JSON.parse(json);
			if(res["errno"] == 0){
				$('#modal-site').modal('hide');
				$('#table-site').bootstrapTable("refresh");
			}else{
				$("#form-site-msg").html(res["msg"]);
				$("#modal-site").effect("shake");
			}
			$("#form-site-submit").removeAttr("disabled");
		});
		ajax.fail(function(jqXHR,textStatus){
			alert("Request failed :" + textStatus);
			$("#form-site-submit").removeAttr("disabled");
		});
	});
}

function load_sites()
{
	$table = $("#table-site");
	$table.bootstrapTable({
		url: 'ajax.php?action=get_sites',
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
			sortable: true
		}, {
			field: 'site',
			title: 'Site',
			align: 'center',
			valign: 'middle',
			sortable: false
		}, {
			field: 'operate',
			title: 'Operate',
			align: 'center',
			events: siteOperateEvents,
			formatter: siteOperateFormatter
		}]
	});
}

function siteResponseHandler(res)
{
	if(res['errno'] == 0){
		return res['sites'];
	}
	alert(res['msg']);
	return [];
}

function siteOperateFormatter(value, row, index)
{
	return [
		'<div class="btn-group" role="group" aria-label="...">',
		'<button class="btn btn-default view" href="javascript:void(0)">',
		'<i class="glyphicon glyphicon-eye-open"></i>&nbsp;Patterns',
		'</button>',
		'<button class="btn btn-default remove" href="javascript:void(0)">',
		'<i class="glyphicon glyphicon-remove"></i>&nbsp;Delete',
		'</button>&nbsp;',
		'</div>'
	].join('');
}

window.siteOperateEvents = {
	'click .view': function (e, value, row, index) {
		window.location.href = "ucenter.php?patterns&site="+row.site;
	},
	'click .remove': function (e, value, row, index) {
		if(!confirm('Are you sure to delete this site (permanently) ?')){ return; }
		var ajax = $.ajax({
			url: "ajax.php?action=remove_site",
			type: 'POST',
			data: { site: row.site }
		});
		ajax.done(function(json){
			var res = JSON.parse(json);
			if(res["errno"] == 0){
				$('#table-site').bootstrapTable("refresh");
			}else{
				alert(res['msg']);
			}
		});
  }
};