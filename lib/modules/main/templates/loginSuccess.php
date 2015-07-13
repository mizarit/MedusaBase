<div id="main" onclick="clearSidebars();">
  <div id="overlay"></div>

  <div id="header">
    <h2 style="font-weight:bold;color:#fff;margin:0;position:relative;padding:0;text-transform: uppercase;font-size:2.1em;line-height:1.6em">Medusa</h2>
  </div>
  <div style="padding: 0;margin:0;">
  <h2 style="margin:0;padding:0;border-top:#fff 1px solid;background:#2ea6dd;font-size:1.5em;line-height:1.6em;color:#fff;">Inloggen</h2>
  <div style="padding: 0.5em;">
    <div style="padding: 0.5em;">
      <form action="#" method="post" id="login-form">
      <div class="form-row">
        <div class="form-label"><label for="username">Gebruikersnaam</label></div>
        <input type="text" name="username" id="username" placeholder="Gebruikersnaam" value="" class="smart-input"<?php if (isset($_SESSION['isIos'])&&$_SESSION['isIos']) echo ' style="width:90%"'; ?>>
      </div>
      <div class="form-row">
        <div class="form-label"><label for="password">Wachtwoord</label></div>
        <input type="password" name="password" id="password" value=""<?php if (isset($_SESSION['isIos'])&&$_SESSION['isIos']) echo ' style="width:90%"'; ?>>
      </div>
    </div>

    <div style="clear:both;"></div>
    <ul class="subnav">
      <li class="save" id="login-btn" onclick="$('login-form').submit();">Inloggen</li>
    </ul>
    </form>
  </div>
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
