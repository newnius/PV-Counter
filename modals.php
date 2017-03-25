<!-- addContact Modal -->
<div class="modal fade" id="addContactModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div id="reg-model-body" class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id = "regModalLabel">添加联系人</h4>
      </div>
      <div class="modal-body">
        <form id="form-add-contact" action="#">
          <label for="contact_name" class="sr-only">姓名</label>
          <input type="text" id="add-contact-name" class="form-group form-control " placeholder="姓名" required autofocus>
          
          <div id="add-contact-telephones" >
	    <div class="input-group form-group"><label for="telephone" class="sr-only">电话号</label>
            <input type="telephone" class="form-group form-control" placeholder="电话号码" required autofocus>
            <a class="input-group-addon telephone-input-del" href="javascript:void(0)"><span class="glyphicon glyphicon-trash"></span></a>
            </div>
            <a class="telephone-add input-group form-group" href="javascript:void(0)"><span class="input-group-addon glyphicon glyphicon-plus"></span></a>
          </div>
          <label for="remark" class="sr-only">备注</label>
          <input type="text" id="add-contact-remark" class="form-group form-control" placeholder="备注" required>
          <label for="contact_group" class="sr-only">分组</label>
          <select id="add-contact-group" class="form-group form-control "  required>
	  </select>
	  <div>
            <button id="btn-add-contact" type="submit" class="btn btn-primary btn-block">添加</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modal-site" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-site-title" >修改联系人信息</h4>
      </div>
      <div class="modal-body">
        <form id="form-site" action="javascript:void(0)">
          <label for="site" class="sr-only">Site</label>
          <input type="text" id="form-site-site" class="form-group form-control " placeholder="example.com:8080" required />
          
	  			<div>
            <button id="form-site-submit" type="submit" class="btn btn-primary">Save</button>
            <button id="form-site-delete" type="button" class="btn btn-danger">Delete</button>
						<span id="form-site-msg" class="text-danger"></span>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
