<?= $benchmark->start(); ?>
<?= $cache->start(); ?>
<html>
  <head>
    <?= $helpers->meta_tags(); ?>
    <?= $helpers->meta_orch(); ?>
    
    <?= $html->stylesheet_link('/products.css'); ?>
    <?= $this->stylesheets(); ?>
    <?= $html->javascript_link('/javascripts/jquery-1.4.4.min.js'); ?>
    
    <script type="text/javascript"> 
    <!--//--><![CDATA[//><!--
      var params=<?= json_encode($this->params); ?>
    //--><!]]>
    </script>
    
  </head>
  
  <body id="<?= str_replace(' ', '-', strtolower($display['site_title'])); ?>">
      
      <?php foreach($notice->pull() as $key => $value): ?>
        <div class="flash <?= $key ?>">
          <p><b><?= $key ?>:</b><?= $value ?></p>
        </div>
      <?php endforeach; ?>
      
      <?= $this->partial('layouts/header'); ?>
      <?= $this->yield(); ?>
      <?= $this->partial('layouts/footer'); ?>
      
      <?= $this->javascripts(); ?>
  </body>
</html>
<?= $cache->end(); ?>
<?= $benchmark->end(); ?>