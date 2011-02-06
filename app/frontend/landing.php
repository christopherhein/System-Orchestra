<?php
require_once("../lib/framework/info.php");
$info = New Info();
?>
<html>
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <title>Orchestra :: Landing Page</title>
    
    <style type="text/css">
      body {
        margin: 0;
        padding: 0;
        background: #efefef;
        font-family: helvetica;
        font-size: 12px;
        height: 100%;
        overflow: auto;
      }
      #content {
        position: relative;
        background: #fff;
        width:550px;
        min-height: 30px;
        padding: 20px 50px;
        margin: 10 auto;
        overflow: auto;
      }
    </style>
    
  </head>
  
  <body id="orchestra-landing">
    <div id="content">
      <h1>Orchestra Landing Page</h1>
      <p>Congrats on starting your Orchestra application!</p>
      <p>If you are seeing this than you haven't setup your default route system yet. to do so uncomment $default['controller'] = 'pages'; and $default['action'] = 'splash'; in config/routes.php</p>
      <p>If you'd like to look around this page will show you some of the settings for this application and your system.</p>
      
      
      <h3>Version</h3>
      <p><?= $info->version(); ?></p>
      
      <h3>Display Config Variables</h3>
      <ul>
        <?php foreach($info->display() as $key => $value): ?>
          <li><b><?= $key ?></b>: <?= $value ?></li>
        <?php endforeach; ?>  
      </ul>
      
      <h3>App Config Variables</h3>
      <ul>
        <?php foreach($info->app() as $key => $value): ?>
          <li><b><?= $key ?></b>: <?= $value ?></li>
        <?php endforeach; ?>  
      </ul>
      
      <h3>Autoloaded Files</h3>
      <ul>
        <?php foreach($info->autoload() as $key => $value): ?>
          <li>
            <b><?= $key ?></b>:
            <ul>
              <?php foreach($value as $load): ?>
                <li><?= ucfirst($load) ?></li>
              <?php endforeach; ?>
            </ul>
          </li>
        <?php endforeach; ?>  
      </ul>
      
      <h3>Required Files</h3>
      <ul>
        <?php foreach($info->required() as $key => $value): ?>
          <li>
            <b><?= $key ?></b>:
            <ul>
              <?php foreach($value as $load): ?>
                <li><?= ucfirst($load) ?></li>
              <?php endforeach; ?>
            </ul>
          </li>
        <?php endforeach; ?>  
      </ul>
      
      
    </div>
  </body>
  
  <script src="/javascripts/jquery-1.4.4.min.js"></script>
  
</html>