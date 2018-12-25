<?php
require_once('predis/autoload.php');

require_once('util4p/util.php');
require_once('util4p/ReSession.class.php');
require_once('util4p/AccessController.class.php');

require_once('config.inc.php');
require_once('secure.inc.php');
require_once('init.inc.php');


if (Session::get('uid') === null) {
	header('location:index.php?a=notloged');
	exit;
}

$page_type = 'home';
$uid = Session::get('uid');
$nickname = Session::get('nickname');

if (isset($_GET['logs'])) {
	$page_type = 'logs';

} elseif (isset($_GET['logs_all'])) {
	$page_type = 'logs_all';

} elseif (isset($_GET['sites'])) {
	$page_type = 'sites';

} elseif (isset($_GET['sites_all'])) {
	$page_type = 'sites_all';

} elseif (isset($_GET['patterns'])) {
	$page_type = 'patterns';

} elseif (isset($_GET['counts'])) {
	$page_type = 'counts';

} elseif (isset($_GET['visitors'])) {
	$page_type = 'visitors';
}

$entries = array(
	array('home', 'Home'),
	array('sites', 'Sites'),
	array('logs', 'Logs'),
	array('sites_all', 'Sites (All)'),
	array('logs_all', 'Logs (All)'),
	array('visitors', 'Visitors')
);
$visible_entries = array();
foreach ($entries as $entry) {
	if (AccessController::hasAccess(Session::get('role', 'visitor'), 'ucenter.' . $entry[0])) {
		$visible_entries[] = array($entry[0], $entry[1]);
	}
}

?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<?php require('head.php'); ?>
	<title>Management | PV Counter</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.12.1/dist/bootstrap-table.min.css" rel="stylesheet">
	<script type="text/javascript">
		var page_type = "<?=$page_type?>";
	</script>
</head>

<body>
<div class="wrapper">
	<?php require('header.php'); ?>
	<?php require('modals.php'); ?>
	<div class="container">
		<div class="row">

			<div class="hidden-xs hidden-sm col-md-2 col-lg-2">
				<div class="panel panel-default">
					<div class="panel-heading">Menu Bar</div>
					<ul class="nav nav-pills nav-stacked panel-body">
						<?php foreach ($visible_entries as $entry) { ?>
							<li role="presentation" <?php if ($page_type == $entry[0]) echo 'class="disabled"'; ?> >
								<a href="?<?= $entry[0] ?>"><?= $entry[1] ?></a>
							</li>
						<?php } ?>
					</ul>
				</div>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">

				<div class="visible-xs visible-sm">
					<div class=" panel panel-default">
						<div class="panel-heading">Menu Bar</div>
						<ul class="nav nav-pills panel-body">
							<?php foreach ($visible_entries as $entry) { ?>
								<li role="presentation" <?php if ($page_type == $entry[0]) echo 'class="disabled"'; ?> >
									<a href="?<?= $entry[0] ?>"><?= $entry[1] ?></a>
								</li>
							<?php } ?>
						</ul>
					</div>
				</div>

				<?php if ($page_type === 'home') { ?>
					<div id="home">
						<div class="panel panel-default">
							<div class="panel-heading">Welcome</div>
							<div class="panel-body">
								Welcome back, <?php echo htmlspecialchars($nickname) ?>.<br/>
								Current IP: &nbsp; <?= cr_get_client_ip() ?>.<br/>
								Current time: &nbsp; <?php echo date('H:i:s', time()) ?>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">Notices</div>
							<div class="panel-body">
								<h4 class="text-info">Notice</h4>
								<p>Nothing new here.</p>
							</div>
						</div>
					</div>

				<?php } elseif ($page_type === 'sites' || $page_type === 'sites_all') { ?>
					<div id="sites">
						<div class="panel panel-default">
							<div class="panel-heading">Sites</div>
							<div class="panel-body">
								<div class="table-responsive">
									<div id="toolbar">
										<button id="btn-site-add" class="btn btn-primary">
											<i class="glyphicon glyphicon-plus"></i> Add
										</button>
									</div>
									<table id="table-site" data-toolbar="#toolbar" class="table table-striped">
									</table>
								</div>
							</div>
						</div>
					</div>

				<?php } elseif ($page_type === 'patterns') { ?>
					<div id="patterns">
						<div class="panel panel-default">
							<div class="panel-heading">Patterns</div>
							<div class="panel-body">
								<div class="table-responsive">
									<div id="toolbar">
										<button id="btn-pattern-add" class="btn btn-primary">
											<i class="glyphicon glyphicon-plus"></i> Add
										</button>
									</div>
									<table id="table-pattern" data-toolbar="#toolbar" class="table table-striped">
									</table>
								</div>
							</div>
						</div>
					</div>

				<?php } elseif ($page_type === 'counts') { ?>
					<div id="patterns">
						<div class="panel panel-default">
							<div class="panel-heading">Patterns</div>
							<div class="panel-body">
								<div class="table-responsive">
									<div id="toolbar"></div>
									<table id="table-pattern" data-toolbar="#toolbar" class="table table-striped">
									</table>
								</div>
							</div>
						</div>
					</div>

				<?php } elseif ($page_type === 'logs' || $page_type === 'logs_all') { ?>
					<div id="logs">
						<div class="panel panel-default">
							<div class="panel-heading">Recent activities</div>
							<div class="panel-body">
								<div class="table-responsive">
									<div id="toolbar"></div>
									<table id="table-log" data-toolbar="#toolbar" class="table table-striped">
									</table>
									<span class="text-info">* At most 1000 recent activities</span>
								</div>
							</div>
						</div>
					</div>

				<?php } elseif ($page_type === 'visitors') { ?>
					<div id="visitors">
						<div class="panel panel-default">
							<div class="panel-heading">Visitors</div>
							<div class="panel-body">
								<table class="table table-striped table-bordered">
									<tr>
										<th>PV</th>
										<td><span class="cr_count_site_pv">Loading</span></td>
									</tr>
									<tr>
										<th>UV</th>
										<td><span class="cr_count_site_uv">Loading</span></td>
									</tr>
									<tr>
										<th>PV (today)</th>
										<td><span class="cr_count_site_pv_24h">Loading</span></td>
									</tr>
									<tr>
										<th>UV (today)</th>
										<td><span class="cr_count_site_uv_24h">Loading</span></td>
									</tr>
								</table>
							</div>
						</div>
					</div>

				<?php } ?>

			</div>
		</div>
	</div> <!-- /container -->

	<!--This div exists to avoid footer from covering main body-->
	<div class="push"></div>
</div>
<?php require('footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.12.1/dist/bootstrap-table.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.12.1/dist/extensions/mobile/bootstrap-table-mobile.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.12.1/dist/extensions/export/bootstrap-table-export.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.1/tableExport.min.js"></script>

<script src="static/site.js"></script>
<script src="static/pattern.js"></script>
<script src="static/count.js"></script>
<script src="static/ucenter.js"></script>

</body>
</html>