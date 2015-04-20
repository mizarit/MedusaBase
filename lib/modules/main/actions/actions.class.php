<?php

use OAuth\OAuth1\Service\FitBit;
use OAuth\Common\Storage\Session;
use OAuth\Common\Consumer\Credentials;

class MainActions extends Actions {
  public function executeDebug($params = array())
  {
    $user_id = Registry::get('user_id');
    $this->user_id = $user_id;

    if (isset($_POST['msg'])) {
      //$push_api_key = 'AIzaSyBeMCQm0bMhd_BSn7Me1xbsFMDdgXxwl_A';
      $push_api_key = 'AIzaSyD75eOpS3dk3zjjDi5fwYic5LwpVGaY7Ws';
      $push_project = '567105785293';

      if (strpos($_SERVER['SERVER_NAME'], 'mizar')) {
        $test_users = array(6, 8);
      }
      else {
        $test_users = array(9,10,11);
      }

      $receiver_ids = array();
      foreach ($test_users as $test_user) {
        $notifiers = Notifier::model()->findAllByAttributes(new Criteria(array('user_id' => $test_user, 'pushDevice' => 'android')));
        foreach ($notifiers as $notifier) {
          $receiver_ids[] = $notifier->pushId;
        }
      }

      if ($_POST['msgtype'] == 'message') {
        $data = array(
          'registration_ids' => $receiver_ids,
          'data' => array(
            'message' => $_POST['msg']
          ),
        );
      }
      else {
        // payload
          $payload = explode("\n", $_POST['msg']);
        $data = array(
          'registration_ids' => $receiver_ids,
          'data' => array(
            'payload' => trim($payload[0]),
            'payload_args' => trim($payload[1])
          ),
        );
      }
      $url = 'https://android.googleapis.com/gcm/send';

      $headers = array(
        'Authorization: key=' . $push_api_key,
        'Content-Type: application/json'
      );

      $curl = curl_init();
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      $output = curl_exec($curl);
      ob_start();
      echo '<pre>';
      var_dump(json_decode($output));
      echo '</pre>';
      $push_result = ob_get_clean();
      $this->push_result = $push_result;
    }
  }

  public function executeAbout($params = array())
  {

  }

  public function executeIndex($params = array())
  {
    $user_id = Registry::get('user_id');
    $user = new User;
    $user->firstName = 'Ricardo';
    $user->lastName = 'Matters';

    $this->user = $user;
    $this->user_id = $user_id;

    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
      header('Content-Type: application/json');
      echo json_encode(array(

      ));
      exit;
    }

    if (isset($params['return_data']) && $params['return_data']) {
      return $local_data;
    }
  }

  public function executeGroupchat($params = array())
  {
    $user_id = Registry::get('user_id');
    $current_user = User::model()->findByAttributes(new Criteria(array('xid' => $user_id)));

    if (isset($_POST['chat']) && trim($_POST['chat']) != '') {

      $emojis = array(
        // smilies
        "\xf0\x9f\x98\x80" => "1F600",
        "\xf0\x9f\x98\x81" => "1F601",
        "\xf0\x9f\x98\x82" => "1F602",
        "\xf0\x9f\x98\x83" => "1F603",
        "\xf0\x9f\x98\x84" => "1F604",
        "\xf0\x9f\x98\x85" => "1F605",
        "\xf0\x9f\x98\x86" => "1F606",
        "\xf0\x9f\x98\x87" => "1F607",
        "\xf0\x9f\x98\x88" => "1F608",
        "\xf0\x9f\x98\x89" => "1F609",
        "\xf0\x9f\x98\x8a" => "1F60A",
        "\xf0\x9f\x98\x8b" => "1F60B",
        "\xf0\x9f\x98\x8c" => "1F60C",
        "\xf0\x9f\x98\x8d" => "1F60D",
        "\xf0\x9f\x98\x8e" => "1F60E",
        "\xf0\x9f\x98\x8f" => "1F60F",
        "\xf0\x9f\x98\x90" => "1F610",
        "\xf0\x9f\x98\x91" => "1F611",
        "\xf0\x9f\x98\x92" => "1F612",
        "\xf0\x9f\x98\x93" => "1F613",
        "\xf0\x9f\x98\x94" => "1F614",
        "\xf0\x9f\x98\x95" => "1F615",
        "\xf0\x9f\x98\x96" => "1F616",
        "\xf0\x9f\x98\x97" => "1F617",
        "\xf0\x9f\x98\x98" => "1F618",
        "\xf0\x9f\x98\x99" => "1F619",
        "\xf0\x9f\x98\x9A" => "1F61A",
        "\xf0\x9f\x98\x9B" => "1F61B",
        "\xf0\x9f\x98\x9C" => "1F61C",
        "\xf0\x9f\x98\x9D" => "1F61D",
        "\xf0\x9f\x98\x9E" => "1F61E",
        "\xf0\x9f\x98\x9F" => "1F61F",
        "\xf0\x9f\x98\xA0" => "1F620",
        "\xf0\x9f\x98\xA1" => "1F621",
        "\xf0\x9f\x98\xA2" => "1F622",
        "\xf0\x9f\x98\xA3" => "1F623",
        "\xf0\x9f\x98\xA4" => "1F624",
        "\xf0\x9f\x98\xA5" => "1F625",
        "\xf0\x9f\x98\xA6" => "1F626",
        "\xf0\x9f\x98\xA7" => "1F627",
        "\xf0\x9f\x98\xA8" => "1F628",
        "\xf0\x9f\x98\xA9" => "1F629",
        "\xf0\x9f\x98\xAA" => "1F62A",
        "\xf0\x9f\x98\xAB" => "1F62B",
        "\xf0\x9f\x98\xAC" => "1F62C",
        "\xf0\x9f\x98\xAD" => "1F62D",
        "\xf0\x9f\x98\xAE" => "1F62E",
        "\xf0\x9f\x98\xAF" => "1F62F",
        "\xf0\x9f\x98\xB0" => "1F630",
        "\xf0\x9f\x98\xB1" => "1F631",
        "\xf0\x9f\x98\xB2" => "1F632",
        "\xf0\x9f\x98\xB3" => "1F633",
        "\xf0\x9f\x98\xB4" => "1F634",
        "\xf0\x9f\x98\xB5" => "1F635",
        "\xf0\x9f\x98\xB6" => "1F636",
        "\xf0\x9f\x98\xB7" => "1F637",
        "\xf0\x9f\x98\xB8" => "1F638",
        "\xf0\x9f\x98\xB9" => "1F639",
        "\xf0\x9f\x98\xBA" => "1F63A",
        "\xf0\x9f\x98\xBB" => "1F63B",
        "\xf0\x9f\x98\xBC" => "1F63C",
        "\xf0\x9f\x98\xBD" => "1F63D",
        "\xf0\x9f\x98\xBE" => "1F63E",
        "\xf0\x9f\x98\xBF" => "1F63F",
        "\xf0\x9f\x99\x80" => "1F640",
        "\xf0\x9f\x99\x81" => "1F641",
        "\xf0\x9f\x99\x82" => "1F642",
        "\xf0\x9f\x99\x83" => "1F643",
        "\xf0\x9f\x99\x84" => "1F644",
        "\xf0\x9f\x99\x85" => "1F645",
        "\xf0\x9f\x99\x86" => "1F646",
        "\xf0\x9f\x99\x87" => "1F647",
        "\xf0\x9f\x99\x88" => "1F648",
        "\xf0\x9f\x99\x89" => "1F649",
        "\xf0\x9f\x99\x8A" => "1F64A",
        "\xf0\x9f\x99\x8B" => "1F64B",
        "\xf0\x9f\x99\x8C" => "1F64C",
        "\xf0\x9f\x99\x8D" => "1F64D",
        "\xf0\x9f\x99\x8E" => "1F64E",
        "\xf0\x9f\x99\x8F" => "1F64F",

        // transport
        "\xf0\x9f\x9a\x80" => "1F680",
        "\xf0\x9f\x9a\x83" => "1F683",
        "\xf0\x9f\x9a\x84" => "1F684",
        "\xf0\x9f\x9a\x85" => "1F685",
        "\xf0\x9f\x9a\x87" => "1F687",
        "\xf0\x9f\x9a\x89" => "1F689",
        "\xf0\x9f\x9a\x8c" => "1F68C",
        "\xf0\x9f\x9a\x8f" => "1F68F",
        "\xf0\x9f\x9a\x91" => "1F691",
        "\xf0\x9f\x9a\x92" => "1F692",
        "\xf0\x9f\x9a\x93" => "1F693",
        "\xf0\x9f\x9a\x95" => "1F695",
        "\xf0\x9f\x9a\x97" => "1F697",
        "\xf0\x9f\x9a\x99" => "1F699",
        "\xf0\x9f\x9a\x9a" => "1F69A",
        "\xf0\x9f\x9a\xa2" => "1F6A2",
        "\xf0\x9f\x9a\xa4" => "1F6A4",
        "\xf0\x9f\x9a\xa5" => "1F6A5",
        "\xf0\x9f\x9a\xa7" => "1F6A7",
        "\xf0\x9f\x9a\xa8" => "1F6A8",
        "\xf0\x9f\x9a\xa9" => "1F6A9",
        "\xf0\x9f\x9a\xaa" => "1F6AA",
        "\xf0\x9f\x9a\xab" => "1F6AB",
        "\xf0\x9f\x9a\xac" => "1F6AC",
        "\xf0\x9f\x9a\xad" => "1F6AD",
        "\xf0\x9f\x9a\xb2" => "1F6B2",
        "\xf0\x9f\x9a\xb6" => "1F6B6",
        "\xf0\x9f\x9a\xb9" => "1F6B9",
        "\xf0\x9f\x9a\xba" => "1F6BA",
        "\xf0\x9f\x9a\xbb" => "1F6BB",
        "\xf0\x9f\x9a\xbc" => "1F6BC",
        "\xf0\x9f\x9a\xbd" => "1F6BD",
        "\xf0\x9f\x9a\xbe" => "1F6BE",
        "\xf0\x9f\x9b\x80" => "1F6C0",
      );

      // generate the uncategorized icons

      foreach ($emojis as $emoji_code => $emoji_name) {
        if (strstr($_POST['chat'], $emoji_code)) {
          $_POST['chat'] = str_replace($emoji_code, '&#' . hexdec($emoji_name) . ';', $_POST['chat']);
        }
      }

      $message = new Message;
      $message->sender = $current_user->id;
      $message->date = date('Y-m-d H:i:s');
      $message->cinterface = 'stream';
      $message->message = $_POST['chat'];
      $message->save();

      // send push notifications
      // find all team users
// ANDROID
      $push_api_key = 'AIzaSyD75eOpS3dk3zjjDi5fwYic5LwpVGaY7Ws';
      $receiver_ids = array();
      $team_users = TeamUser::model()->findAllByAttributes(new Criteria(array('team_id' => $team->team->id)));
      foreach ($team_users as $team_user) {
        // get all notifiers for the user
        $notifiers = Notifier::model()->findAllByAttributes(new Criteria(array('user_id' => $team_user->user->id, 'pushDevice' => 'android')));
        foreach ($notifiers as $notifier) {
          $receiver_ids[] = $notifier->pushId;
        }
      }
      if (count($receiver_ids) > 0) {
        $data = array(
          'registration_ids' => $receiver_ids,
          'data' => array(
            'message' => $current_user->firstName . ': ' . $_POST['chat']
          ),
        );
        $url = 'https://android.googleapis.com/gcm/send';

        $headers = array(
          'Authorization: key=' . $push_api_key,
          'Content-Type: application/json'
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $output = curl_exec($curl);
      }

// IOS
      $receiver_ids = array();
      foreach ($team_users as $team_user) {
        // get all notifiers for the user
        $notifiers = Notifier::model()->findAllByAttributes(new Criteria(array('user_id' => $team_user->user->id, 'pushDevice' => 'ios')));
        foreach ($notifiers as $notifier) {
          $receiver_ids[] = $notifier->pushId;
        }
      }
      if (count($receiver_ids) > 0) {
        $passphrase = 'm00nr1s1n@';
        $message = $current_user->firstName . ': ' . $_POST['chat'];

        foreach ($receiver_ids as $receiver_id) {

          $ctx = stream_context_create();
          stream_context_set_option($ctx, 'ssl', 'local_cert', 'apn.pem');
          stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

          // Open a connection to the APNS server
          $fp = stream_socket_client(
            'ssl://gateway.sandbox.push.apple.com:2195', $err,
            $errstr, 15, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

          if ($fp) {
            $body['aps'] = array(
              'alert' => $message,
              'sound' => 'default'
            );

            $payload = json_encode($body);
            $msg = chr(0) . pack('n', 32) . pack('H*', $receiver_id) . pack('n', strlen($payload)) . $payload;
            $result = fwrite($fp, $msg, strlen($msg));
            fclose($fp);
          }
        }
      }
    }

    if ($current_user) {
      if (isset($_POST['read']) && $_POST['read']) {
        $current_user->lastRead = date('Y-m-d H:i:s');
        $current_user->save();
      }
    }

    $count = 0;
    if ($current_user) {
      // count messages
      $c = new Criteria(array('date' => array($current_user->lastRead, '>')), null, 'date DESC LIMIT 50');
      $count = Message::model()->count($c);
    }

    // find team messages
    $messages = Message::model()->findAllByAttributes(new Criteria(array(), null, 'date DESC LIMIT 50'));
    ob_start();
    ?>
    <ul>
      <?php
      $senders = array();
      $first = true;
      foreach ($messages as $message) {
        if (!isset($senders[$message->sender])) {
          $senders[$message->sender] = User::model()->findByPk($message->sender);
        }
        if ($first) {
          $first = false; ?>
          <li
            style="text-align:right;padding: 0.1em 0.1em 0 0;font-size:0.3em;font-style:italic;"><?php echo date('H:i', strtotime($message->date)); ?></li>
        <?php
        }
        ?>
        <li>
          <strong<?php if ($current_user->id == $message->sender) echo ' style="color:#41df22;"' ?>><?php echo $senders[$message->sender]->firstName; ?>
            :</strong> <?php echo $message->message; ?></li>
      <?php
      }
      if (count($messages) < 50) {
        ?>
        <li><strong style="color:#ccfc0c;">Beheerder:</strong> Welkom bij de team-chat!</li>
      <?php } ?>
    </ul>
    <?php
    $html = ob_get_clean();
    $data = array(
      'html' => $html,
      'count' => $count,
    );
    if ($current_user) {

      // find popup message, if any
      $message = Message::model()->findByAttributes(new Criteria(array('user_id' => $current_user->id, 'cinterface' => 'popup', 'delivered' => 0), null, 'date DESC'));
      if ($message) {
        $data['popup'] = array(
          'title' => $message->title,
          'content' => $message->message
        );
        $message->delivered = 1;
        $message->save();
      }
    }

    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
  }

  public function executeSignature($params = array())
  {
    if (isset($_POST['image'])) {
      $filename = time().'.png';

      $image = base64_decode($_POST['image']);
      file_put_contents(getcwd().'/img/signatures/'.$filename, $image);
      $url = 'https://'.$_SERVER['SERVER_NAME'].'/img/signatures/'.$filename;
      echo 'Bestand opgeslagen: <a target="_blank" href="'.$url.'">'.$url.'</a>';
      exit;
    }
  }

  public function executeImagecapture($params = array())
  {
    if (count($_FILES) > 0) {
      foreach ($_FILES as $file) {
        if ($file['size'] == 0) continue;
      }
      $filename = $file['name'];
      move_uploaded_file($file['tmp_name'], getcwd().'/img/signatures/'.$filename);

      $url = 'https://'.$_SERVER['SERVER_NAME'].'/img/signatures/'.$filename;
      echo 'Bestand opgeslagen: <a target="_blank" href="'.$url.'">'.$url.'</a>';
      exit;
    }
  }

}