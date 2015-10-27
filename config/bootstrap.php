<?php
/*
if (!isset($_SERVER['HTTPS'])) {
  $url = 'https://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
  header("Location: {$url}");
  exit;
}
*/
ini_set('display_errors', true);
error_reporting(E_ALL);

$first_run = false;

// core init
require('bootstrap-cli.php');

if (!isset($_COOKIE['xid_id'])) {
  $user_id = 'native'.time().rand(1000000,9999999);
  $first_run = true;
}
else if (isset($_GET['ju'])) {
  $user_id = $_GET['ju'];
} else {
  $user_id = $_COOKIE['xid_id'];
}

$current_user = Resource::model()->findByAttributes(new Criteria(array('xid' => $user_id)));
if (!$current_user) {
  $current_user = new Resource;
  $current_user->xid = $user_id;
  $current_user->save();
  setcookie('xid_id', $current_user->xid, strtotime('+1 year'), '/');
}

if (!session_id()) session_start();

Registry::set('user_id',$user_id);
/*
$oa = new OAAPI();
Registry::set('oa_api', $oa);
$agendas = $oa->sendRequest('getAgendas');
if (isset($agendas['Agenda'])) {
  $agenda = array_shift($agendas['Agenda']);
  Registry::set('oa_agenda', $agenda);
}
*/
$device_info = $_GET;
if (!isset($_GET['device']) && isset($_SESSION['device_info'])) {
  $device_info = json_decode($_SESSION['device_info'], true);
}
if (isset($device_info['device'])) {
  if ($current_user) {
    switch($device_info['device']) {
      case 'android':
          if ($device_info['android_id'] != '') {
            $notifier = Notifier::model()->findByAttributes(new Criteria(array('user_id' => $current_user->id, 'pushDevice' => 'android', 'pushId' => $device_info['android_id'])));
            if (!$notifier) {
              $notifier = new Notifier;
              $notifier->user_id = $current_user->id;
              $notifier->pushDevice = 'android';
              $notifier->pushId = $device_info['android_id'];
              $notifier->save();
            }

            $current_user->device = 'android';
            $current_user->notifier = $device_info['android_id'];
            $current_user->save();
          }
        $_SESSION['isAndroid'] = true;
        break;
        
        case 'ios':
          if ($device_info['ios_id'] != '') {
            $notifier = Notifier::model()->findByAttributes(new Criteria(array('user_id' => $current_user->id, 'pushDevice' => 'ios', 'pushId' => $device_info['ios_id'])));
            if (!$notifier) {
              $notifier = new Notifier;
              $notifier->user_id = $current_user->id;
              $notifier->pushDevice = 'ios';
              $notifier->pushId = $device_info['ios_id'];
              $notifier->save();
            }

            $current_user->device = 'ios';
            $current_user->notifier = $device_info['ios_id'];
            $current_user->save();
          }

        $_SESSION['isIos'] = true;
        break;
    }
  }
  else {
    $_SESSION['device_info'] = json_encode($device_info);
    switch($device_info['device']) {
      case 'android':
        $_SESSION['isAndroid'] = true;
        break;
        
        case 'ios':
          $_SESSION['isIos'] = true;
        break;
    }
  }
}


if (isset($_GET['device'])) {
  // device info is saved above, redirect to cachable page
  header('Location: /main/index');
  exit;
}
if ($first_run) {
  //redirect using a script, because we need to send the cookie
  echo "<script>window.location.href='/main/login';</script>";
  exit;
}
$action = Route::resolve();
/*if (is_numeric($user_id) && !in_array($action['action'], array('signature','imagecapture','debug'))) {
  $action = array('module' => 'main', 'action' => 'index', 'params' => array());
}*/

$module_class = 'lib/modules/' . $action['module'] . '/actions/actions.class.php';
$module_name = ucfirst($action['module']) . 'Actions';
$action_name = 'execute' . ucfirst($action['action']);
require($module_class);
$module = new $module_name;
$module->action = $action['action'];
$module->module = $action['module'];
$module->{$action_name}($action['params']);
$module->render();

exit;
?>