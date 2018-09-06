<?php
require_once('global.inc.php');
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<?php require_once('head.php');?>
	<title>Manual | PV Counter</title>
</head>
<body>
<div class="wrapper">
	<?php require_once('header.php'); ?>
	<div class="container">
		<div class="row">
			<div class="col-sm-4 col-md-3 hidden-xs">
				<div id="help-nav" class="panel panel-default">
					<div class="panel-heading">Documents</div>
					<ul class="nav nav-pills nav-stacked panel-body">
						<li role="presentation">
							<a href="#qid-1">What is PV-Counter</a>
						</li>
						<li role="presentation">
							<a href="#qid-2">Easy start</a>
						</li>
						<li role="presentation">
							<a href="#qid-3">Customize url pattern</a>
						</li>
						<li role="presentation">
							<a href="#qid-feedback">Feedback</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-xs-12 col-sm-8 col-md-8 col-md-offset-1 ">
				<div id="qid-1" class="panel panel-default">
					<div class="panel-heading">What is PV-Counter</div>
					<div class="panel-body">
						<p>PV-Counter is a light-weighted third party website page visit count service. By using
							PV-Counter, it is easy to count the page views. Currently, PV-Counter is able to count PV
							(Page View), VV (Visit View) and UV (Unique View), ranging from a single page to the whole
							site.</p>
					</div>
				</div>
				<div id="qid-2" class="panel panel-default">
					<div class="panel-heading">Easy start</div>
					<div class="panel-body">
						<p>To apply PV-Counter to your website, simply add the script at the bottom,</p>
						<pre><code class="language-markup">https//cdn.newnius.com/ana/ea.js</code></pre>
						<p>and add class <em>cr-count-pv</em> to an element where the PV will be
							shown.</p>
					</div>
				</div>
				<div id="qid-3" class="panel panel-default">
					<div class="panel-heading">Customize url pattern</div>
					<div class="panel-body">
						<p>Assume a website url looks like <em>example.com/post?id=2&utm_source=</em>,
							by default, PV-Counter will ignore the query part <em>?id=2&utm_source=</em>
							, to count <em>id</em> but ignore <em>utm_source</em>, just add a pattern
							<em>/post?id=?</em>
							to the domain <em>example.com</em>.
						</p>
					</div>
				</div>
				<div id="qid-feedback" class="panel panel-default">
					<div class="panel-heading">More</div>
					<div class="panel-body">
						<p>Thank you for using. This document has not been completed yet. If you have any problem, feel
							free to contact me at <a href="mailto:support@newnius.com?subject=From PV-Counter">support@newnius.com</a>
						</p>
					</div>
				</div>

			</div>
		</div>
	</div> <!-- /container -->
	<!--This div exists to avoid footer from covering main body-->
	<div class="push"></div>
</div>
<?php require_once('footer.php'); ?>
</body>
</html>
