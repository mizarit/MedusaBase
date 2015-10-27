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
require('lib/model/Credentials.php');
require('lib/model/User.php');
require('lib/model/Team.php');
require('lib/model/TeamUser.php');
require('lib/model/Message.php');
require('lib/model/Notifier.php');
require('lib/model/Company.php');
require('lib/model/Setting.php');
require('lib/model/Resource.php');
require('lib/model/Appointment.php');
require('lib/model/Customer.php');
require('lib/model/Workorder.php');
require('lib/model/Address.php');
require('lib/model/Checklist.php');
require('lib/model/ChecklistRow.php');
require('lib/model/ChecklistValue.php');
require('lib/model/ChecklistAppointment.php');
require('lib/model/Field.php');
require('lib/model/FieldValue.php');
require('lib/model/Category.php');
require('lib/model/Product.php');
require('lib/model/ProductCategory.php');

$db_config = Registry::get('connection');
$db = new mysqli($db_config['server'], $db_config['username'], $db_config['password'], $db_config['database']);
mysqli_set_charset($db, 'utf8');
mysqli_query($db, 'SET NAMES utf8mb4');
Registry::set('db', $db);

$db_site_config = Registry::get('connection_site');
$db_site = new mysqli($db_site_config['server'], $db_site_config['username'], $db_site_config['password'], $db_site_config['database']);
mysqli_set_charset($db_site, 'utf8');
mysqli_query($db_site, 'SET NAMES utf8mb4');
Registry::set('db_site', $db_site);

require('lib/Tools.lib.php');
require('lib/Route.lib.php');
require('lib/Actions.lib.php');
//require('lib/vendor/onlineafspraken/api.lib.php');
//require('lib/vendor/phpmailer/PHPMailerAutoload.php');
//require('lib/vendor/fpdf/FPDF.class.php');
//require('lib/vendor/PDF/PDF.lib.php');
