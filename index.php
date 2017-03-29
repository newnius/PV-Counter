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
		<title>Easy Analytics | Third party visit analytics</title>
		<link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet"/>
		<link href="style.css" rel="stylesheet"/>
		<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
		<link href="//cdn.bootcss.com/prism/9000.0.1/themes/prism.css" rel="stylesheet">
	</head>

	<body>
		<div class="wrapper">
		<?php require_once('header.php'); ?>
			<div class="container">
				<div class="jumbotron">
					<h2 class="center">Easy Analytics</h2>
					<p class="center">A third party website visit count and analytics service. It's easy and amlost free to use.</p>
					<div>
						<h4>Include (JQuery required)</h4>
						<pre><code class="language-markup"><?=htmlspecialchars('<script async src="//cdn.newnius.com/ana/ea.js"></script>')?></code></pre>
						<h4>Show visit count</h4>
						<pre><code class="language-markup"><?=htmlspecialchars('Visited:<span class="cr_count_pv"></span>')?></code></pre>
					</div>
					<div>
						<h4>Demo</h4>
						<h4>Visited: <span class="cr_count_pv"></span></h4>
						<h4>Visited(All pages): <span class="cr_count_site_pv"></span></h4>
					</div>
				</div>
			</div> <!-- /container -->
			<!--This div exists to avoid footer from covering main body-->
			<div class="push"></div>
		</div>
		<?php require_once('footer.php'); ?>

		<script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="//cdn.bootcss.com/prism/9000.0.1/prism.js"></script>
	</body>
</html>
