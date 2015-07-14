<!DOCTYPE html>
<html manifest="/cache.manifest2">
<head>
  <link href="/css/mobile.css" rel="stylesheet" type="text/css" />
  <link href="/css/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
  <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,300italic" rel="stylesheet" type="text/css" />
  <meta name="viewport" content="user-scalable=no" />
  <link rel="apple-touch-icon-precomposed" href="/iphone-icon.png"/>
  <link rel="apple-touch-icon" href="/iphone-icon.png"/>
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <script type="text/javascript" src="/js/offline.js"></script>
  <script type="text/javascript" src="/js/prototype.js"></script>
  <script type="text/javascript" src="/js/scriptaculous.js?load=effects"></script>
  <script type="text/javascript" src="/js/effects.js"></script>
  <script type="text/javascript" src="/js/helpers.js"></script>
  <script type="text/javascript" src="/js/sidebar.js"></script>
  <?php if(isset($_SESSION['isIos']) && $_SESSION['isIos']) { ?>
  <script type="text/javascript" src="/js/app-ios.js"></script>
  <?php } ?>
  <?php if(isset($_SESSION['isAndroid']) && $_SESSION['isAndroid']) { ?>
  <script type="text/javascript" src="/js/app-android.js"></script>
  <?php } ?>
  <script type="text/javascript" src="/js/mobile.js"></script>
  <script type="text/javascript" src="/js/swipeable.js"></script>
  <script type="text/javascript" src="/js/signature.js"></script>
  <title>iWerkbon</title>
</head>
<body id="body"<?php if(isset($_SESSION['isIos']) && $_SESSION['isIos']) echo ' class="ios"'; ?>>
<div id="connection-down"><div>Er is geen internet verbinding.</div></div>
<?php echo $content; ?>
</body>
</html>
