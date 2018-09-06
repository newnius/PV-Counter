<?php
	require_once('global.inc.php');
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<?php require_once('head.php');?>
	<link href="//cdn.bootcss.com/prism/9000.0.1/themes/prism.css" rel="stylesheet">
	<title>PV Counter | Light-weighted third party visit count service</title>
</head>

<body>
<div class="wrapper">
	<?php require_once('header.php'); ?>
	<div class="container">
		<div class="jumbotron">
			<h2 class="center">PV Counter</h2>
			<p class="center">A light-weighted third party website page visit count service. It's easy and totally free to use.</p>
			<div>
				<h4>Include (JQuery required)</h4>
				<pre><code class="language-markup"><?= htmlspecialchars('<script async src="//cdn.newnius.com/ana/ea.js"></script>') ?></code></pre>
				<h4>Show visit count</h4>
				<pre><code class="language-markup"><?= htmlspecialchars('Visits:<span class="cr_count_site_pv"></span>') ?></code></pre>
			</div>
			<div>
				<h4>Demo</h4>
				<table class="table">
					<tr>
						<th>PV(cr_count_pv):</th>
						<td><span class="cr_count_pv"></span></td>
					</tr>
					<tr>
						<th>PV(Whole site, cr_count_site_pv):</th>
						<td><span class="cr_count_site_pv"></span></td>
					</tr>
					<tr>
						<th>PV(Whole site, 24h, cr_count_site_pv_24h):</th>
						<td><span class="cr_count_site_pv_24h"></span></td>
					</tr>
					<tr>
						<th>VV(Whole site, cr_count_site_vv):</th>
						<td><span class="cr_count_site_vv"></span></td>
					</tr>
					<tr>
						<th>VV(Whole site, 24h, cr_count_site_vv_24h):</th>
						<td><span class="cr_count_site_vv_24h"></span></td>
					</tr>
					<tr>
						<th>UV(Whole site, cr_count_site_uv):</th>
						<td><span class="cr_count_site_uv"></span></td>
					</tr>
					<tr>
						<th>UV(Whole site, 24h, cr_count_site_uv_24h):</th>
						<td><span class="cr_count_site_uv_24h"></span></td>
					</tr>
				</table>
			</div>
		</div>
	</div> <!-- /container -->
	<!--This div exists to avoid footer from covering main body-->
	<div class="push"></div>
</div>
<?php require_once('footer.php'); ?>

<script src="//cdn.bootcss.com/prism/9000.0.1/prism.js"></script>
</body>
</html>
