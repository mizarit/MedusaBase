<script type="text/javascript">
  var user_id = <?php echo $user_id; ?>;
  var iOS = /(iPad|iPhone|iPod)/g.test( navigator.userAgent );
  var isIos = <?php echo isset($_SESSION['isIos'])?'true':'false'; ?>;
  var isAndroid = <?php echo isset($_SESSION['isAndroid'])?'true':'false'; ?>;
  <?php $iOS = (bool)preg_match("/(iPad|iPhone|iPod)/si", $_SERVER['HTTP_USER_AGENT']); ?>
</script>
<div id="container"<?php if($iOS) echo ' class="iOS"'; ?>">
<?php require(dirname(__FILE__).'/_sidebarLeft.php'); ?>
<?php require(dirname(__FILE__).'/_sidebarRight.php'); ?>
<div id="main" onclick="clearSidebars();">
  <div id="overlay"></div>

  <div id="header">
    <h2 style="font-weight:bold;color:#fff;margin:0.1em 0 0 0;position:relative;padding:0;text-transform: uppercase;font-size:2em;">
      <?php if ($iOS) { ?>
        <button class="fa fa-reorder delayed" id="menu-button" class="delayed" onclick="toggleSidebar('sidebar-left');" style="position:absolute;left:-0.7em;color:#fff;top:0.1em;"></button>
        <button id="back-button" class="delayed" onclick="goPage(1);" style="display:none;background:url(/img/button-back.png);background-size:100% 100%;width: 0.9em; height: 1.6em;position:absolute;left:0.7em;top:0.4em;padding:0;margin:0;"></button>
        <?php if (strpos($_SERVER['SERVER_NAME'], 'mizar') || in_array($user->id, array(9,10,11))) { ?>
          <button class="fa fa-cog delayed" onclick="window.location.href='/main/debug?ju=<?php echo $user_id; ?>';" style="margin:0;padding:0;position:absolute;right:0.3em;top:0.1em;color:#fff;width:auto;font-size:1em;"></button>
        <?php } ?>
      <?php } else { ?>
        <button id="back-button" class="delayed" onclick="goPage(1);" style="display:none;background:url(/img/button-back.png);background-size:100% 100%;width: 0.9em; height: 1.6em;position:absolute;left:0.4em;top:0.3em;padding:0;margin:0;"></button>
        <?php if (strpos($_SERVER['SERVER_NAME'], 'mizar') || in_array($user->id, array(9,10,11))) { ?>
          <button class="fa fa-cog delayed" onclick="window.location.href='/main/debug?ju=<?php echo $user_id; ?>';" style="margin:0;padding:0;position:absolute;right:0.3em;top:0.1em;color:#fff;width:auto;font-size:1em;"></button>
        <?php } ?>


      <?php } ?>Medusa</h2>
  </div>
    <div id="page-1" class="active">


  </div>
  <div id="page-2">


  </div>
  <div id="page-3">

  </div>
    <?php

   if(isset($_SESSION['isIos'])){
     require(dirname(__FILE__).'/_settingsIos.php');
   }
   if(isset($_SESSION['isAndroid'])){
     require(dirname(__FILE__).'/_settingsAndroid.php');
   }
?>

</div>
</div>
