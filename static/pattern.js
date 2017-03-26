function register_events_pattern(site){
  $('#btn-pattern-add').click(function(e){
    $('#form-pattern-delete').addClass('hidden');
    $('#modal-pattern').modal('show');
  });

  $('#form-pattern-delete').click(function(e){
    var site = $("#form-pattern-site").val();
    var pattern = $("#form-pattern-pattern").val();
    if(!confirm('Are you sure to remove this pattern (permanently) ?')){ return; }
    var ajax = $.ajax({
      url: "ajax.php?action=remove_pattern",
      type: 'POST',
      data: {
				site: site,
				pattern: pattern
			}
    });
    ajax.done(function(json){
      var res = JSON.parse(json);
      if(res["errno"] == 0){
        $('#modal-pattern').modal('hide');
        $('#table-pattern').bootstrapTable("refresh");
      }else{
        $("#form-pattern-msg").html(res["msg"]);
        $("#modal-pattern").effect("shake");
      }
    });
  });

  $("#form-pattern-submit").click(function(e){
    $("#form-pattern-submit").attr("disabled", "disabled");
    var domain = $("#form-pattern-domain").val();
    var port = $("#form-pattern-port").val();
		var site = domain;
		if(port != "" && port!= "80")
    	site += ":" + port;
    var pattern = $("#form-pattern-pattern").val();
    var ajax = $.ajax({
      url: "ajax.php?action=add_pattern",
      type: 'POST',
      data: {
        site: site,
        pattern: pattern
      }
    });
    ajax.done(function(json){
      var res = JSON.parse(json);
      if(res["errno"] == 0){
        $('#modal-pattern').modal('hide');
        $('#table-pattern').bootstrapTable("refresh");
      }else{
        $("#form-pattern-msg").html(res["msg"]);
        $("#modal-pattern").effect("shake");
      }
      $("#form-pattern-submit").removeAttr("disabled");
    });
    ajax.fail(function(jqXHR,textStatus){
      alert("Request failed :" + textStatus);
      $("#form-pattern-submit").removeAttr("disabled");
    });
  });
}

function load_patterns(site){
	var arr = site.split(":");
	var domain = arr[0];
	var port = 80;
	if(arr.length==2)
		port = arr[1];
	$("#form-pattern-domain").val(domain);
	$("#form-pattern-port").val(port);


  $table = $("#table-pattern");
  $table.bootstrapTable({
    url: 'ajax.php?action=get_patterns&site='+site,
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
        title: '选择',
        checkbox: true
    }, {
        field: 'pattern',
        title: 'Pattern',
        align: 'center',
        valign: 'middle',
        sortable: false
    }, {
        field: 'operate',
        title: '操作',
        align: 'center',
        events: patternOperateEvents,
        formatter: patternOperateFormatter
    }]
  });
}

function patternResponseHandler(res){
  var records = [];
	if(res['errno'] == 0){
		var patterns = res["patterns"];
		$.each(patterns, function(index ,value){
			var record = { "pattern": value };
			records.push(record);
		});
		return records;
  }
  alert(res['msg']);
  return [];
}

function patternOperateFormatter(value, row, index) {
  return [
    '<button class="btn btn-danger remove" href="javascript:void(0)">',
    '<i class="glyphicon glyphicon-remove"></i>&nbsp;删除',
    '</button>'
  ].join('');
}

window.patternOperateEvents = {
  'click .remove': function (e, value, row, index) {
    var domain = $("#form-pattern-domain").val();
    var port = $("#form-pattern-port").val();
		var site = domain;
		if(port != "" && port!= "80")
    	site += ":" + port;
    var pattern = row.pattern;
    if(!confirm('Are you sure to remove this pattern (permanently) ?')){ return; }
    var ajax = $.ajax({
      url: "ajax.php?action=remove_pattern",
      type: 'POST',
      data: {
				site: site,
				pattern: pattern
			}
    });
    ajax.done(function(json){
      var res = JSON.parse(json);
      if(res["errno"] == 0){
        $('#table-pattern').bootstrapTable("refresh");
      }else{
				alert(res["msg"]);
      }
    });
  }
};
