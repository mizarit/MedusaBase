<?php

setlocale(LC_TIME, 'nl_NL');

require('config.php');
require('lib/Registry.lib.php');
foreach ($config as $key => $value) {
  Registry::set($key, $value);
}

require('lib/model/base/Base.php');
require('lib/model/base/Criteria.php');
require('lib/model/Cache.php');
require('lib/model/User.php');
require('lib/model/Day.php');
require('lib/model/Hour.php');
require('lib/model/Entrycode.php');
require('lib/model/Challenge.php');
require('lib/model/ChallengeUser.php');
require('lib/model/Team.php');
require('lib/model/TeamUser.php');
require('lib/model/Message.php');
require('lib/model/Notifier.php');

$db_config = Registry::get('connection');

$db = new mysqli($db_config['server'], $db_config['username'], $db_config['password'], $db_config['database']);
mysqli_set_charset($db, 'utf8');
mysqli_query($db, 'SET NAMES utf8mb4');
Registry::set('db', $db);

require('lib/Tools.lib.php');
require('lib/Route.lib.php');
require('lib/Actions.lib.php');
require('lib/vendor/onlineafspraken/api.lib.php');
require('lib/vendor/phpmailer/PHPMailerAutoload.php');
require('lib/vendor/fpdf/FPDF.class.php');
require('lib/vendor/PDF/PDF.lib.php');
/*
for ($i = 0; $i <10; $i++) {
  $code = rand(100000,999999);
  echo $code."<br>\n";
}
exit;
*/