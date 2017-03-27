<?php
	require_once('config.inc.php');
	require_once('util4p/util.php');
	require_once('util4p/Session.class.php');
	require_once('init.inc.php');
	if(Session::get('username')===null){
		header('location:index.php?a=notloged');
		exit;
	}

	$page_type = 'home';
	$username = Session::get('username');

	if(isset($_GET['logs'])){
		$page_type='logs';

	}elseif(isset($_GET['sites'])){
		$page_type='sites';

  }elseif(isset($_GET['patterns'])){
		$site = cr_get_GET('site');
    $page_type='patterns';

  }elseif(isset($_GET['options'])){
    $page_type='options';

  }elseif(isset($_GET['signout'])){
    $page_type='signout';
     //signout();
		 Session::clear();
     header('location:index.php?a=signout');
     exit;
  }


  $entries = array(
    array('home', 'Home'),
    array('sites', 'Sites'),
    array('logs', 'Logs'),
    array('signout', 'Sign out')
  );
  $visible_entries = array();
  foreach($entries as $entry){
    $visible_entries[] = array($entry[0], $entry[1]);
  }

  $admin_entries = array(
    array('users', 'Sites'),
    array('options', 'Settings')
  );
  $visible_admin_entries = array();
  foreach($admin_entries as $entry){
    $visible_admin_entries[] = array($entry[0], $entry[1]);
  }
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
    <title>Easy Analytics</title>
    <link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="style.css" rel="stylesheet"/>
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="//cdn.newnius.com/bootstrap-table/bootstrap-table.min.css">

    <script type="text/javascript">
      var page_type = "<?=$page_type?>";
    </script>
  </head>

  <body>
    <div class="wrapper">
      
      <?php require_once('header.php'); ?>
      <?php require_once('modals.php'); ?>
      <div class="container">
        <div class="row">
          
          <div class="hidden-xs hidden-sm col-md-2 col-lg-2">
            <div class="panel panel-default">
              <div class="panel-heading">Menubar(User)</div>
              <ul class="nav nav-pills nav-stacked panel-body">
                <?php foreach($visible_entries as $entry){ ?>
                <li role="presentation" <?php if($page_type==$entry[0])echo 'class="disabled"'; ?> >
                  <a href="?<?=$entry[0]?>"><?=$entry[1]?></a>
                </li>
                <?php } ?>
              </ul>
            </div>
          </div>
          
          <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
            <div class="visible-xs visible-sm">
              <div class=" panel panel-default">
                <div class="panel-heading">Menubar(User)</div>
                <ul class="nav nav-pills panel-body">
                  <?php foreach($visible_entries as $entry){ ?>
                  <li role="presentation" <?php if($page_type==$entry[0])echo 'class="disabled"'; ?> >
                    <a href="?<?=$entry[0]?>"><?=$entry[1]?></a>
                  </li>
                  <?php } ?>
                </ul>
              </div>
            </div>

            <?php if($page_type == 'home'){ ?>
            <div id="home">
              <div class="panel panel-default">
                <div class="panel-heading">Welcome</div> 
                <div class="panel-body">
                  Welcome back, <?php echo htmlspecialchars($username) ?>.<br/>
                  Curent IP: &nbsp; <?=cr_get_client_ip() ?>.<br/>
                  Current time: &nbsp; <?php echo date('H:i:s',time()) ?>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading">Notices</div> 
                <div class="panel-body">
                  <h4 class="text-info">Notice</h4>
                  <ul>
                    <li>No notice</li>
                  </ul>
                </div>
              </div>
            </div>
      
            <?php }elseif($page_type == 'users'){ ?>
            <div id="users">
              <div class="panel panel-default">
                <div class="panel-heading">Users</div> 
                <div class="panel-body">
                  <div class="table-responsive">
                    <div id="toolbar"></div>
                    <table id="table-user" data-toolbar="#toolbar" class="table table-striped">
                    </table> 
                    <span class="text-info">* 2 b done</span>
                  </div>
                </div>
              </div>
            </div>
  
            <?php }elseif($page_type == 'sites'){ ?>
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

            <?php }elseif($page_type == 'patterns'){ ?>
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

            <?php }elseif($page_type == 'logs'){ ?>
            <div id="logs">
              <div class="panel panel-default">
                <div class="panel-heading">Recent activities</div> 
                <div class="panel-body">
                  <div class="table-responsive">
                    <div id="toolbar"></div>
                    <table id="table-log" data-toolbar="#toolbar" class="table table-striped">
                    </table> 
                    <span class="text-info">* Last 20 recent records</span>
                  </div>
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
    <?php require_once('footer.php'); ?>

    <script src="static/util.js"></script>
    <script src="static/site.js"></script>
    <script src="static/pattern.js"></script>
    <script src="static/ucenter.js"></script>

    <script src="//cdn.newnius.com/bootstrap-table/bootstrap-table.min.js"></script>
    <script src="//cdn.newnius.com/bootstrap-table/locale/bootstrap-table-en-US.min.js"></script>
    <script src="//cdn.newnius.com/bootstrap-table/extensions/mobile/bootstrap-table-mobile.min.js"></script>
    <script src="//cdn.newnius.com/bootstrap-table/extensions/export/bootstrap-table-export.min.js"></script>
    <script src="//cdn.newnius.com/jquery-plugin-tableExport/tableExport.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="//cdn.bootcss.com/jqueryui/1.11.4/jquery-ui.js"></script> 
  </body>
</html>
