<script type="text/javascript">
  var user_id = '<?php echo $user_id; ?>';
  var current_date = '<?php echo date('Y-m-d'); ?>';
  //var iOS = /(iPad|iPhone|iPod)/g.test( navigator.userAgent );
  var isIos = <?php echo isset($_SESSION['isIos'])?'true':'false'; ?>;
  var isAndroid = <?php echo isset($_SESSION['isAndroid'])?'true':'false'; ?>;
  <?php $iOS = isset($_SESSION['isIos']); ?>
</script>
<div id="container<?php //if($iOS) echo ' class="iOS"'; ?>">
<?php require(dirname(__FILE__).'/_sidebarLeft.php'); ?>
<?php require(dirname(__FILE__).'/_sidebarRight.php'); ?>
<div id="main" onclick="clearSidebars();">
  <div id="overlay"></div>

  <div id="header">
    <h2 style="font-weight:bold;color:#fff;margin:0;position:relative;padding:0;text-transform: none;font-size:2.1em;line-height:1.6em">
      <?php //if ($iOS) { ?>
        <button class="fa fa-reorder delayed" id="menu-button" class="delayed" onclick="toggleSidebar('sidebar-left');" style="position:absolute;left:<?php echo $iOS? '-0.9':'0.1'; ?>em;color:#fff;top:<?php echo $iOS? '0.1':'0.15'; ?>em;font-size:1.2em;"></button>
        <!--<button class="fa fa-comments-o delayed" id="menu-button" class="delayed" onclick="toggleSidebar('sidebar-right', true);" style="position:absolute;right:<?php echo $iOS? '-0.9':'0.1'; ?>em;color:#fff;top:<?php echo $iOS? '0.1':'0.10'; ?>em;font-size:1.2em;"></button>-->
        <button class="fa fa-caret-left delayed" id="back-button" onclick="goBack();" style="display:none;position:absolute;left:<?php echo $iOS? '-0.9':'0.1'; ?>em;color:#fff;top:<?php echo $iOS? '0.1':'0.15'; ?>em;font-size:1.2em;"></button>
        <?php /*if (strpos($_SERVER['SERVER_NAME'], 'mizar') || in_array($user->id, array(9,10,11))) { ?>
          <button class="fa fa-cog delayed" onclick="window.location.href='/main/debug?ju=<?php echo $user_id; ?>';" style="margin:0;padding:0;position:absolute;right:0.3em;top:0.1em;color:#fff;width:auto;font-size:1em;"></button>
        <?php }*/ ?>
      <?php /*} else { ?>
        <button id="back-button" class="delayed" onclick="goPage(1);" style="display:none;background:url(/img/button-back.png);background-size:100% 100%;width: 0.9em; height: 1.6em;position:absolute;left:0.4em;top:0.3em;padding:0;margin:0;"></button>
        <?php /*if (strpos($_SERVER['SERVER_NAME'], 'mizar') || in_array($user->id, array(9,10,11))) { ?>
          <button class="fa fa-cog delayed" onclick="window.location.href='/main/debug?ju=<?php echo $user_id; ?>';" style="margin:0;padding:0;position:absolute;right:0.3em;top:0.1em;color:#fff;width:auto;font-size:1em;"></button>
        <?php }*/ ?>


      <?php //} ?>iWerkbon</h2>
  </div>
  <?php require(dirname(__FILE__).'/_consumers.php'); ?>
  <?php require(dirname(__FILE__).'/_appointments.php'); ?>
  <?php require(dirname(__FILE__).'/_worksheets.php'); ?>
  <?php require(dirname(__FILE__).'/_orderrows.php'); ?>
  <?php require(dirname(__FILE__).'/_workorders.php'); ?>
  <?php
   if(isset($_SESSION['isIos']) && $_SESSION['isIos']){
     require(dirname(__FILE__).'/_settingsIos.php');
   }
   else if(isset($_SESSION['isAndroid']) && $_SESSION['isAndroid']){
     require(dirname(__FILE__).'/_settingsAndroid.php');
   }
  else {
    //require(dirname(__FILE__).'/_settingsAndroid.php');
  }
?>
    <?php require(dirname(__FILE__).'/_check.php'); ?>
    <?php require(dirname(__FILE__).'/_signature.php'); ?>
    <?php require(dirname(__FILE__).'/_travel.php'); ?>
    <?php require(dirname(__FILE__).'/_hours.php'); ?>
    <?php require(dirname(__FILE__).'/_photos.php'); ?>
    <?php require(dirname(__FILE__).'/_checkout.php'); ?>
    <?php require(dirname(__FILE__).'/_notes.php'); ?>
</div>
</div>
<?php if(isset($_SESSION['isIos']) && $_SESSION['isIos']){ ?>
<style type="text/css">
  input {
    width: 90%;
  }
</style>
<?php } ?>
