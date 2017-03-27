<?php
	require_once('config.inc.php');
	require_once('util4p/Session.class.php');
	require_once('init.inc.php');
?>
<header id="header" class="navbar navbar-default">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?=BASE_URL?>">Easy Analytics</a>
		</div>

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-right">
			<?php if(!Session::get('username')){ ?>
				<li><a href="https://quickauth.newnius.com/login.php?redirect=<?=BASE_URL?>/auth.php">Sign in</a></li>
				<li><a href="https://quickauth.newnius.com/register.php?redirect=<?=BASE_URL?>/auth.php">SIgn up</a></li>
			<?php }else{ ?>
				<li><a href="<?=BASE_URL?>/ucenter.php"><?=htmlspecialchars(Session::get('username'))?></a></li>
			<?php } ?>
				<li class="dropdown">
					<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">More<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="help.php">Help</a></li>
						<li role="separator" class="divider"></li>
					<?php if(Session::get('username')){ ?>
						<li><a href="<?=BASE_URL?>/ucenter.php?signout">Sign out</a></li>
					<?php } ?>
					</ul>
				</li>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container -->
</header>
