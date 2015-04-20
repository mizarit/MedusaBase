<h1>Notification test suite</h1>
<form action="#" method="post">
  <input <?php if (isset($_POST['device']) && $_POST['device']=='ios') echo ' checked="checked"'; ?> type="radio" id="device-ios" name="device" value="ios"> <label for="device-ios">iOS</label><br>
  <input <?php if (isset($_POST['device']) && $_POST['device']=='android') echo ' checked="checked"'; ?> type="radio" id="device-android" name="device" value="android"> <label for="device-android">Android</label><br>
  <hr>
  <input <?php if (isset($_POST['app']) && $_POST['app']=='hc') echo ' checked="checked"'; ?> type="radio" id="app-hc" name="app" value="hc"> <label for="app-hc">Health Challenge</label><br>
  <input <?php if (isset($_POST['app']) && $_POST['app']=='medusa') echo ' checked="checked"'; ?> type="radio" id="app-medusa" name="app" value="medusa"> <label for="app-medusa">Medusa</label><br>
  <hr>

  <label for="message">Message</label><br><textarea name="message" id="message"></textarea>
  <hr>
  <input type="checkbox" name="silent" id="silent"> <label for="silent">Silent push with payload</label><br>
  <label for="badge">Badge</label> <input type="input" name="badge" id="badge" style="width:30px;"><br>

  <button type="submit">Send</button>

</form>
<?php
if (isset($_POST['device'])) {
  switch($_POST['device']) {
    case 'ios':
      if ($_POST['app']=='hc') {
        $deviceToken = '02d947d0f7fd7930ab8f2e8e51955a0ee425ea494389eacc17286c523067527b'; // HC
        $pem = 'apn.pem';
        $passphrase = 'm00nr1s1n@';
      }
      else {
        $deviceToken = '22d626d3be8234cf8ba1c8187aaa14d80fb76ba52e7df94c450189856f7ad092'; // Medusa
        $pem = 'apn-medusa.pem';
        $passphrase = 'm00nr1s1n@';
      }

      $ctx = stream_context_create();
      stream_context_set_option($ctx, 'ssl', 'local_cert', $pem);
      stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

      // Open a connection to the APNS server
      $fp = stream_socket_client(
        'ssl://gateway.sandbox.push.apple.com:2195', $err,
        $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

      if (!$fp)
        exit("Failed to connect: $err $errstr" . PHP_EOL);

      echo 'Connected to APNS' . PHP_EOL;

      // Create the payload body
      if (isset($_POST['silent'])) {
        $body['aps'] = array(
          'alert' => '',
          'content-available' => 1,
          'badge' => (int)$_POST['badge'],
          'payload' => 'alertName',
          'payload_params' => "{name:'Ricardo'}"
        );
      }
      else {
        $body['aps'] = array(
          'alert' => $_POST['message'],
          'sound' => 'default',
          'badge' => (int)$_POST['badge'],
        );
      }

      $payload = json_encode($body);
      $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
      $result = fwrite($fp, $msg, strlen($msg));

      if (!$result)
        echo 'Message not delivered' . PHP_EOL;
      else
        echo 'Message successfully delivered' . PHP_EOL;

      // Close the connection to the server
      fclose($fp);
      break;

    case 'android':
      if ($_POST['app']=='hc') {
        $push_api_key = 'AIzaSyD75eOpS3dk3zjjDi5fwYic5LwpVGaY7Ws';
        $receiver_ids = array(
          'APA91bG7qaIVRBgNX9jfv_REl90P_39QMhVmxpdYTrNQn7M_vGYlJsEwwOG4GY0AixWdxU7k-_CZfCpsbb2tyRvtEDs8f0tHIv00BftureyF7smRKJAhDPAgwbds1E46ItjKDoPu0pKJlv_LXzkCE11pAZABShXiDQ0mudL3w6PXOReaNWRpQhM'
        );
      }
      else {
        $push_api_key = 'AIzaSyDtav4GVB3sPVn0jEPjGfUd7LQ6N56DJPQ';
        $receiver_ids = array(
          'APA91bGityQXiAOsNxX_8JuQnnXIFup2_Srhdf0Yl2dyJJFehENSVt4Yc3CkrrLfYA2qOroDU4ptPykWPiT-VnwXSY-DpVNffnzDBoD8kBACuJxmSQKuCBB8hFwXpBJOqc8tjVbjlV0CDju5LiBRMwiaLVdWHZS76A'
        );
      }


      if (isset($_POST['silent'])) {
        // payload
        $data = array(
          'registration_ids' => $receiver_ids,
          'data' => array(
            'payload' => "toastName\n{name:'Ricardo'}"
          ),
        );
      }
      else {
        $data = array(
          'registration_ids' => $receiver_ids,
          'data' => array(
            'message' => $_POST['message']
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
      echo '<pre>';
      var_dump(json_decode($output));
      echo '</pre>';

      break;
  }
}