function register_events_site(){
  $('#btn-site-add').click(function(e){
    $("form#form-site :input").each(function(){
      $(this).val("");
    });
    $('#form-site-delete').addClass('hidden');
    $('#form-site-site').removeAttr('disabled');
    $('#modal-site').modal('show');
  });

  $('#form-site-delete').click(function(e){
    var key = $("#form-site-key").val();
    if(!confirm('确认删除这条记录吗（操作不可逆）')){ return; }
    var ajax = $.ajax({
      url: "ajax.php?action=option_remove",
      type: 'POST',
      data: { key: key }
    });
    ajax.done(function(json){
      var res = JSON.parse(json);
      if(res["errno"] == 0){
        $('#modal-option').modal('hide');
        $('#table-option').bootstrapTable("refresh");
      }else{
        $("#form-option-msg").html(res["msg"]);
        $("#modal-option").effect("shake");
      }
    });
  });

  $("#form-site-submit").click(function(e){
    $("#form-site-submit").attr("disabled", "disabled");
    var site = $("#form-site-site").val();
    var action = "add_site";
    var ajax = $.ajax({
      url: "ajax.php?action="+action,
      type: 'POST',
      data: {
        site: site
      }
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

function load_sites(){
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
        field: 'state',
        title: '选择',
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
        field: 'add_time',
        title: 'Create Time',
        align: 'center',
        valign: 'middle',
        sortable: false,
        formatter: timeFormatter
    }, {
        field: 'operate',
        title: '操作',
        align: 'center',
        events: siteOperateEvents,
        formatter: siteOperateFormatter
    }]
  });
}

function timeFormatter(unixTimestamp){
  var d = new Date(unixTimestamp*1000);
  d.setTime( d.getTime() - d.getTimezoneOffset()*60*1000 );
  return formatDate(d, '%Y-%M-%d %H:%m');
}

function siteResponseHandler(res){
  if(res['errno'] == 0){
    return res['sites'];
  }
  alert(res['msg']);
  return [];
}

function siteOperateFormatter(value, row, index) {
  return [
    '<button class="btn btn-default edit" href="javascript:void(0)">',
    '<i class="glyphicon glyphicon-edit"></i>&nbsp;编辑',
    '</button>'
  ].join('');
}

window.siteOperateEvents = {
  'click .edit': function (e, value, row, index) {
    window.location.href = "ucenter.php?patterns&site="+row.site;
  }
};
