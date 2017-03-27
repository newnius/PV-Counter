<div class="modal fade" id="modal-pattern" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id = "modal-pattern-title">Add pattern</h4>
      </div>
      <div class="modal-body">
        <form id="form-pattern" action="javascript:void(0)">
          <label for="domain" class="sr-only">Domain</label>
          <input type="text" id="form-pattern-domain" class="form-group form-control" disabled />
          <label for="port" class="sr-only">Port</label>
          <input type="number" id="form-pattern-port" class="form-group form-control" disabled />
          <label for="pattern" class="sr-only">Pattern</label>
          <input type="text" id="form-pattern-pattern" class="form-group form-control" placeholder="sample: /list.php?fid=3&sid=4" required>
	  			<div>
            <button id="form-pattern-submit" type="submit" class="btn btn-primary">Save</button>
						<span id="form-pattern-msg" class="text-danger"></span>
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
        <h4 class="modal-site-title" >Add Site</h4>
      </div>
      <div class="modal-body">
        <form id="form-site" action="javascript:void(0)">
          <label for="domain" class="sr-only">Domain</label>
          <input type="text" id="form-site-domain" class="form-group form-control " placeholder="example.com" required />
          <label for="port" class="sr-only">Port</label>
          <input type="number" id="form-site-port" class="form-group form-control " placeholder="80" required />
	  			<div>
            <button id="form-site-submit" type="submit" class="btn btn-primary">Save</button>
						<span id="form-site-msg" class="text-danger"></span>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
