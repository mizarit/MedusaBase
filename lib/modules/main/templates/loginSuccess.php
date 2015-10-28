<div id="main" onclick="clearSidebars();">
  <div id="overlay"></div>

  <div style="text-align:center;padding: 1em 0;"><img src="/img/logo-iwerkbon.png"></div>
  <div style="padding: 0;margin:0;">
    <form action="#" method="post" id="login-form">
    <div style="padding: 0.5em;">


      <div class="form-row">
        <div class="form-label"><label for="username">Gebruikersnaam</label></div>
        <input autocomplete="off" type="text" name="username" id="username" placeholder="Gebruikersnaam" value="" class="smart-input" style="width:98%">
      </div>
      <div class="form-row">
        <div class="form-label"><label for="password">Wachtwoord</label></div>
        <input type="password" name="password" id="password" value="" style="width:98%">
      </div>
    </div>

    <div style="clear:both;"></div>
    <ul class="subnav">
      <li class="button-3" id="login-btn" onclick="$('login-form').submit();">Inloggen</li>
    </ul>

    </form>
</div>
</div>
<script type="text/javascript">
  //var iOS = /(iPad|iPhone|iPod)/g.test( navigator.userAgent );
  var isIos = <?php echo isset($_SESSION['isIos'])&&$_SESSION['isIos']?'true':'false'; ?>;
  var isAndroid = <?php echo isset($_SESSION['isAndroid'])&&$_SESSION['isAndroid']?'true':'false'; ?>;
  <?php $iOS = isset($_SESSION['isIos']); ?>
  <?php if (isset($error)) { ?>
  toast('<?php echo $error; ?>');
  <?php } ?>
</script>
