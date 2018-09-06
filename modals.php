<div class="modal fade" id="modal-pattern" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">Add pattern</h4>
			</div>
			<div class="modal-body">
				<form id="form-pattern" action="javascript:void(0)">
					<label for="form-pattern-domain" class="sr-only">Domain</label>
					<input type="text" id="form-pattern-domain" class="form-group form-control" disabled/>
					<label for="form-pattern-port" class="sr-only">Port</label>
					<input type="number" id="form-pattern-port" class="form-group form-control" disabled/>
					<label for="form-pattern-pattern]" class="sr-only">Pattern</label>
					<input type="text" id="form-pattern-pattern" class="form-group form-control"
						   placeholder="sample: /list.php?fid=3&sid=4" required>
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
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">Add Site</h4>
			</div>
			<div class="modal-body">
				<form id="form-site" action="javascript:void(0)">
					<label for="form-pattern-domain" class="sr-only">Domain</label>
					<input type="text" id="form-site-domain" class="form-group form-control " placeholder="example.com"
						   required/>
					<label for="form-pattern-port" class="sr-only">Port</label>
					<input type="number" id="form-site-port" class="form-group form-control " placeholder="80"
						   required/>
					<div>
						<button id="form-site-submit" type="submit" class="btn btn-primary">Save</button>
						<span id="form-site-msg" class="text-danger"></span>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-verify-site" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">Verify Site</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" id="input-verify-site"/>
				<h4>Your are verifying:&nbsp;&nbsp;<span id="modal-verify-site-site" class="text-success"></span></h4>
				<ol>
					<li>Put this file (<span id="modal-verify-site-file" class="text-info">Loading...</span> ) in the root dir.</li>
					<li>Click the button below to verify.</li>
				</ol>
				<div>
					<button id="btn-verify-site" type="button" class="btn btn-primary" disabled>Verify</button>
					<span id="verify-site-msg" class="text-danger"></span>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- msg modal -->
<div class="modal fade" id="modal-msg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 id="modal-msg-title" class="modal-title">Notify</h4>
			</div>
			<div class="modal-body">
				<h4 id="modal-msg-content" class="text-msg text-center">Hello World!</h4>
			</div>
		</div>
	</div>
</div>
