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

  if(isset($_GET['changepwd'])){
    $page_type='changepwd';
  
  }elseif(isset($_GET['users'])){
    $page_type='users';
  
  }elseif(isset($_GET['logs'])){
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
    array('changepwd', 'Change pwd'),
    array('logs', 'Logs'),
    array('sites', 'Sites'),
    array('admin', '管理入口'),
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
    <meta name="keywords" content="吉林大学,数量经济研究中心,吉林大学数量经济研究中心,吉林大学商学院,教育部人文社会科学重点研究基地"/>
    <meta name="description" content="吉林大学数量经济研究中心成立于1999年10月，2000年9月25日被教育部批准为普通高等学校人文社会科学重点研究基地。研究内容包括：经济增长、经济波动与经济政策、金融与投资、区域经济和产业经济、微观经济、经济系统模拟实验和经济权力范式、经济博弈论、数量经济分析方法等。" />
    <meta name="author" content="Newnius"/>
    <link rel="icon" href="favicon.ico"/>
    <title>个人中心 | 数量经济研究中心</title>
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
              <div class="panel-heading">Menubar</div>
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
                <div class="panel-heading">Menubar</div>
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
      
            <?php }elseif($page_type == 'profile'){ ?>
            <div id="profile">
              <div class="panel panel-default">
                <div class="panel-heading">基本信息</div> 
                <div class="panel-body">
                  <form id="form-profile" action="javascript:void(0)">
                    <table class="table">
                      <tr>
                        <th>图片</th>
                        <td>
                          <div>
                            <img id="profile-picture" style="max-width:100px;" src="images/no-user-image.gif" alt="教师照片" />
                          </div>
                          <input id="form-profile-picture" name="picture" type="file" class="hidden" />
                          <button id="form-profile-upload" class="btn btn-default edit hidden">更换图片</button>
                        </td>
                      </tr>
                      <tr>
                        <th>姓名</th>
                        <td>
                          <span class="view" id="profile-name-zh">Loading...</span>
                          <input type="text" id="form-profile-name-zh" class="form-group form-control edit hidden" placeholder="姓名（中文）" maxlength=24 required />
                        </td>
                      </tr>
                      <tr>
                        <th>姓名（英）</th>
                        <td>
                          <span class="view" id="profile-name-en">Loading...</span>
                          <input type="text" id="form-profile-name-en" class="form-group form-control edit hidden" placeholder="姓名（英文）" maxlength=24 required />
                        </td>
                      </tr>
                      <tr class="hidden">
                        <th>分组</th>
                        <td>
                          <span class="view" id="profile-group">Loading...</span>
                          <select id="form-profile-group" class="form-group form-control edit hidden" required>
                            <option value="0">其他</option>
                            <option value="1">兼职研究员</option>
                            <option value="2">专职研究员</option>
                          </select>
                        </td>
                      </tr>
                      <tr class="hidden">
                        <th>职称</th>
                        <td>
                          <span class="view" id="profile-title">Loading...</span>
                          <select id="form-profile-title" class="form-group form-control edit hidden" required>
                            <option value="0">其他</option>
                            <option value="1">讲师</option>
                            <option value="2">副教授</option>
                            <option value="3">教授</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <button id="form-profile-edit" class="btn btn-default view">
                            <i class="glyphicon glyphicon-edit"></i>
                            &nbsp;编辑
                          </button>
                        </td>
                        <td>
                          <button id="form-profile-save" class="btn btn-default edit hidden">
                            <i class="glyphicon glyphicon-floppy-disk"></i>
                            &nbsp;保存
                          </button>
                        </td>
                      </tr>
                    </table>
                  </form>
                </div>
              </div>
            </div>
     
            <?php }elseif($page_type == 'changepwd'){ ?>
            <div id="changepwd">
              <div class="panel panel-default">
                <div class="panel-heading">修改密码</div> 
                <div class="panel-body">
                  <div id="resetpwd">
                    <h2>修改密码</h2>
                    <form class="form-changepwd">
                      <div class="form-group">
                        <label class="sr-only" for="inputOldpwd">Old password</label>
                        <div class="input-group">
                          <div class="input-group-addon">
                            <span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
                          </div>
                          <input type="password" class="form-control" id="oldpwd" placeholder="原来的密码" required />
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="sr-only" for="inputPassword">New Password</label>
                        <div class="input-group">
                          <div class="input-group-addon">
                            <span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
                          </div>
                          <input type="password" class="form-control" id="password" placeholder="新的密码" required />
                        </div>
                      </div>
                      <button id="btn-changepwd" class="btn btn-md btn-primary " type="submit" >确认修改</button>
                      <span id="changepwd-msg" class="text-danger"></span>
                    </form>
                  </div>
                </div>
              </div>
            </div>
   
            <?php }elseif($page_type == 'users'){ ?>
            <div id="users">
              <div class="panel panel-default">
                <div class="panel-heading">用户管理</div> 
                <div class="panel-body">
                  <div class="table-responsive">
                    <div id="toolbar">
                      <button id="btn-user-add" class="btn btn-primary">
                        <i class="glyphicon glyphicon-plus"></i> 添加用户
                      </button>
                    </div>
                    <table id="table-user" data-toolbar="#toolbar" class="table table-striped">
                    </table> 
                    <span class="text-info">* 学术团队根据用户名增序排序</span><br/>
                    <span class="text-info">* 不支持现有用户的用户名修改操作</span><br/>
                    <span class="text-info">* 不支持修改自己的角色</span>
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

            <?php }elseif($page_type == 'options'){ ?>
            <div id="options">
              <div class="panel panel-default">
                <div class="panel-heading">网站参数设置</div> 
                <div class="panel-body">
                  <div class="table-responsive">
                    <div id="toolbar">
                      <button id="btn-option-add" class="btn btn-primary hidden">
                        <i class="glyphicon glyphicon-plus"></i> 添加设置
                      </button>
                    </div>
                    <table id="table-option" data-toolbar="#toolbar" class="table table-striped">
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
                    <span class="text-info">* 最多显示20条最近的记录</span>
                  </div>
                </div>
              </div>
            </div>

            <?php }elseif($page_type == 'admin'){ ?>
            <div class=" panel panel-default">
              <div class="panel-heading">管理入口</div>
              <h4 style="text-align:center">中英文统一管理后台</h4>
              <ul class="nav nav-pills panel-body">
                <?php foreach($visible_admin_entries as $entry){ ?>
                <li role="presentation" <?php if($page_type==$entry[0])echo 'class="disabled"'; ?> >
                  <a href="?<?=$entry[0]?>"><?=$entry[1]?></a>
                </li>
                <?php } ?>
              </ul>
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
    <script src="static/script.js"></script>
    <script src="static/pattern.js"></script>
    <script src="static/ucenter.js"></script>

    <script src="//cdn.newnius.com/bootstrap-table/bootstrap-table.min.js"></script>
    <script src="//cdn.newnius.com/bootstrap-table/locale/bootstrap-table-en-US.min.js"></script>
    <script src="//cdn.newnius.com/bootstrap-table/extensions/mobile/bootstrap-table-mobile.min.js"></script>
    <script src="//cdn.newnius.com/bootstrap-table/extensions/export/bootstrap-table-export.min.js"></script>
    <script src="//cdn.newnius.com/jquery-plugin-tableExport/tableExport.min.js"></script>

    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="//cdn.bootcss.com/blueimp-md5/1.1.1/js/md5.min.js"></script>
    <script src="//cdn.bootcss.com/jqueryui/1.11.4/jquery-ui.js"></script> 
  </body>
</html>
