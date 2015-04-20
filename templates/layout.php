<!DOCTYPE html>
<html>
<head>
<?php
$cache_version = '1.0.0'.time(); ?>
  <link href="/css/mobile.css?t=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
  <link href="/css/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
  <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,300italic" rel="stylesheet" type="text/css" />
  <meta name="viewport" content="user-scalable=no" />
  <link rel="apple-touch-icon-precomposed" href="/iphone-icon.png"/>
  <link rel="apple-touch-icon" href="/iphone-icon.png"/>
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <script type="text/javascript" src="/js/prototype.js"></script>
  <?php if(isset($_SESSION['isIos']) && $_SESSION['isIos']) { ?>
  <script type="text/javascript" src="/js/app-ios.js?t=<?php echo $cache_version; ?>"></script>
  <?php } ?>
  <?php if(isset($_SESSION['isAndroid']) && $_SESSION['isAndroid']) { ?>
  <script type="text/javascript" src="/js/app-android.js?t=<?php echo $cache_version; ?>"></script>
  <?php } ?>
  <script type="text/javascript" src="/js/mobile.js?t=<?php echo $cache_version; ?>"></script>
  <script type="text/javascript" src="/js/swipeable.js?t=<?php echo $cache_version; ?>"></script>
  <script type="text/javascript" src="/js/signature.js?t=<?php echo $cache_version; ?>"></script>
  
  <title>Medusa</title>
</head>
<body id="body"<?php if(isset($_SESSION['isIos']) && $_SESSION['isIos']) echo ' class="ios"'; ?>>
<?php echo $content; ?>
</body>
</html>
