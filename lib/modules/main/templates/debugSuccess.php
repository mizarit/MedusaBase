<link href="/css/demo.css?t=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
  var isIos = <?php echo isset($_SESSION['isIos'])?'true':'false'; ?>;
  var isAndroid = <?php echo isset($_SESSION['isAndroid'])?'true':'false'; ?>;
  function moreInfo()
  {
    $('more-info').hide();
    $$('.more-info').each(function(s,i) {
      $(s).style.display = 'table-row';
    });
  }
  
  Event.observe(window, 'load', function() {
    if(isIos) {
      var hasSound = iOS.getSetting('sound')=="1";
      var hasVibrate = iOS.getSetting('vibrate')=="1";
      var hasNotifications = iOS.getSetting('notifications')=="1";
      
      $('btn-iOS-sound').style.background = hasSound ? '#f79035' : '#cccccc';
      $('btn-iOS-vibrate').style.background = hasVibrate ? '#f79035' : '#cccccc';
      $('btn-iOS-notifications').style.background = hasNotifications ? '#f79035' : '#cccccc';
    }
    else if(isAndroid) {
      var hasSound = Android.getSetting('sound')=="1";
      var hasVibrate = Android.getSetting('vibrate')=="1";
      var hasNotifications = Android.getSetting('notifications')=="1";
      
      $('btn-sound').style.background = hasSound ? '#f79035' : '#cccccc';
      $('btn-vibrate').style.background = hasVibrate ? '#f79035' : '#cccccc';
      $('btn-notifications').style.background = hasNotifications ? '#f79035' : '#cccccc';
    }
    else {
      hasSound = hasVibrate = hasNotitications = false;
    }
  });
</script>
<div id="main">
  <h2 style="color:#fff;font-weight:bold;margin:0.1em 0;position:relative;">Medusa Debugger</h2>
  <div id="debug-container">
    <div id="overlay" style="display:none;"></div>

 
    <button style="width:48%;background:#2f7ae1;" onclick="$('overlay').style.display='block';$('overlay').addClassName('popup');window.location.href=window.location.href;">Refresh</button>
    <button style="width:49%;background:#f79035;" onclick="$('overlay').style.display='block';$('overlay').addClassName('popup');window.location.href='/main/index?ju=<?php echo $user_id; ?>';">Mobiele weergave</button>
    <hr>
    <h2>Android test suite</h2>
    <button <?php if(!isset($_SESSION['isAndroid']) || !$_SESSION['isAndroid']) echo ' disabled="disabled" style="background:#cccccc;"'; ?> onclick="window.Android.beep();">Sound</button>
    <button <?php if(!isset($_SESSION['isAndroid']) || !$_SESSION['isAndroid']) echo ' disabled="disabled" style="background:#cccccc;"'; ?> onclick="window.Android.vibrate(500);">Vibrate</button>
    <button <?php if(!isset($_SESSION['isAndroid']) || !$_SESSION['isAndroid']) echo ' disabled="disabled" style="background:#cccccc;"'; ?> onclick="window.Android.showToast('Dit is een toast bericht!');">Toast</button>
    <button <?php if(!isset($_SESSION['isAndroid']) || !$_SESSION['isAndroid']) echo ' disabled="disabled" style="background:#cccccc;"'; ?> id="btn-sound" onclick="handleSound();">Sound</button>
    <button <?php if(!isset($_SESSION['isAndroid']) || !$_SESSION['isAndroid']) echo ' disabled="disabled" style="background:#cccccc;"'; ?> id="btn-vibrate" onclick="handleVibrate();">Vibrate</button>
    <button <?php if(!isset($_SESSION['isAndroid']) || !$_SESSION['isAndroid']) echo ' disabled="disabled" style="background:#cccccc;"'; ?> id="btn-notifications" onclick="handleNotifications();">Notificaties</button><br>

    <form action="#" method="post" id="frm">
    <textarea name="msg" id="msg" cols="40" rows="4" style="width:97%;margin: 0 1%;"><?php echo isset($_POST['msg'])?$_POST['msg']:''; ?></textarea><br>
    <input type="hidden" name="msgtype" id="msgtype" value="message">
    <button <?php if(!isset($_SESSION['isAndroid']) || !$_SESSION['isAndroid']) echo ' disabled="disabled" style="background:#cccccc;"'; ?> type="button" onclick="$('frm').submit();">Bericht verzenden</button>
    <button <?php if(!isset($_SESSION['isAndroid']) || !$_SESSION['isAndroid']) echo ' disabled="disabled" style="background:#cccccc;"'; ?> type="button" onclick="$('msgtype').value='payload';$('frm').submit();">Payload verzenden</button>
    <button <?php if(!isset($_SESSION['isAndroid']) || !$_SESSION['isAndroid']) echo ' disabled="disabled" style="background:#cccccc;"'; ?> type="button" onclick="alert(window.Android.getPayload());">Payload<br>ophalen</button>
    </form>
    <?php if (isset($push_result)) echo $push_result; ?>
    <hr>
    <h2>iOS test suite</h2>
    <button <?php if(!isset($_SESSION['isIos']) || !$_SESSION['isIos']) echo ' disabled="disabled" style="background:#cccccc;"'; ?> onclick="window.iOS.beep();">Sound</button>
    <button <?php if(!isset($_SESSION['isIos']) || !$_SESSION['isIos']) echo ' disabled="disabled" style="background:#cccccc;"'; ?> onclick="window.iOS.vibrate(500);">Vibrate</button>
    <button <?php if(!isset($_SESSION['isIos']) || !$_SESSION['isIos']) echo ' disabled="disabled" style="background:#cccccc;"'; ?> onclick="window.iOS.showToast('Dit is een toast bericht!');">Toast</button>
    <button <?php if(!isset($_SESSION['isIos']) || !$_SESSION['isIos']) echo ' disabled="disabled" style="background:#cccccc;"'; ?> id="btn-iOS-sound" onclick="handleiOSSound();">Sound</button>
    <button <?php if(!isset($_SESSION['isIos']) || !$_SESSION['isIos']) echo ' disabled="disabled" style="background:#cccccc;"'; ?> id="btn-iOS-vibrate" onclick="handleiOSVibrate();">Vibrate</button>
    <button <?php if(!isset($_SESSION['isIos']) || !$_SESSION['isIos']) echo ' disabled="disabled" style="background:#cccccc;"'; ?> id="btn-iOS-notifications" onclick="handleiOSNotifications();">Notificaties</button><br>
    
    <form action="#" method="post" id="frm-iOS">
    <textarea disabled="disabled" name="msg-iOS" id="msg-iOS" cols="40" rows="4" style="width:97%;margin: 0 1%;"><?php echo isset($_POST['msg'])?$_POST['msg']:''; ?></textarea><br>
    <input type="hidden" name="msgtype-iOS" id="msgtype-iOS" value="message">
    <button type="button" <?php if(!isset($_SESSION['isIos']) || !$_SESSION['isIos']) echo ' disabled="disabled" style="background:#cccccc;"'; ?> onclick="$('frm-iOS').submit();">Bericht verzenden</button>
    <button type="button" <?php if(!isset($_SESSION['isIos']) || !$_SESSION['isIos']) echo ' disabled="disabled" style="background:#cccccc;"'; ?> onclick="$('msgtype-iOS').value='payload';$('iOS').submit();">Payload verzenden</button>
    <button type="button" <?php if(!isset($_SESSION['isIos']) || !$_SESSION['isIos']) echo ' disabled="disabled" style="background:#cccccc;"'; ?> onclick="alert(window.iOS.getPayload());">Payload<br>ophalen</button>
  </div>
</div>