<?php
	require_once('config.inc.php');
?>
<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<meta name="keywords" content="url visit count, visit analytics, visit count"/>
		<meta name="description" content="Easy Analytics is a third party url visit count and analyze service. You can customize how to count visited time of given url pattern." />
		<meta name="author" content="Newnius"/>
		<link rel="icon" href="favicon.ico"/>
		<title>Manual | QuickAuth</title>
		<link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet"/>
		<link href="style.css" rel="stylesheet"/>
		<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
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
										<a href="#qid-1">What is Easy Analytics</a>
									</li>
									<li role="presentation">
										<a href="#qid-2">Basic use(easy start)</a>
									</li>
									<li role="presentation">
										<a href="#qid-3">Advanced use(customize url pattern)</a>
									</li>
									<li role="presentation">
										<a href="#qid-feedback">Feedback</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="col-xs-12 col-sm-8 col-md-8 col-md-offset-1 ">
							<div id="qid-1" class="panel panel-default">
								<div class="panel-heading">What is Easy Analytics</div> 
								<div class="panel-body">
									<p>To Be Done ^_^</p>
								</div>
							</div>
							<div id="qid-feedback" class="panel panel-default">
								<div class="panel-heading">More</div> 
								<div class="panel-body">
									<p>Thank you for using. This document has not been completed. If you have any problem, please contact me at <a href="mailto:support@newnius.com?subject=From Ana">support@newnius.com</a></p>
								</div>
							</div>

					</div>
				</div>
			</div> <!-- /container -->
			<!--This div exists to avoid footer from covering main body-->
			<div class="push"></div>
		</div>
		<?php require_once('footer.php'); ?>
		<script src="script.js"></script>
		<script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	</body>
</html>
