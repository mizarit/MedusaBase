<?php

use OAuth\OAuth1\Service\FitBit;
use OAuth\Common\Storage\Session;
use OAuth\Common\Consumer\Credentials;

class MainActions extends Actions {
  public function executeConnectionTest($params = array())
  {
    echo 'OK';
    exit;
  }

  public function executeDebug($params = array())
  {
    $user_id = Registry::get('user_id');
    $this->user_id = $user_id;

    if (isset($_POST['msg'])) {
      $push_api_key = 'AIzaSyDtav4GVB3sPVn0jEPjGfUd7LQ6N56DJPQ';
      $push_project = '665687130761';


      $receiver_ids = array();
      /*foreach ($test_users as $test_user) {
        $notifiers = Notifier::model()->findAllByAttributes(new Criteria(array('user_id' => $test_user, 'pushDevice' => 'android')));
        foreach ($notifiers as $notifier) {
          $receiver_ids[] = $notifier->pushId;
        }
      }*/
      $receiver_ids[] = 'APA91bGityQXiAOsNxX_8JuQnnXIFup2_Srhdf0Yl2dyJJFehENSVt4Yc3CkrrLfYA2qOroDU4ptPykWPiT-VnwXSY-DpVNffnzDBoD8kBACuJxmSQKuCBB8hFwXpBJOqc8tjVbjlV0CDju5LiBRMwiaLVdWHZS76A';

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

  private function sign($parameters, $salt, $secret = null) {
    $parameters = array_merge($parameters, array(
      'api_format' => 'jsonp',
      'ApplicationId' => 'OABeheerApp'
    ));

    ksort($parameters);
    $sign = '';
    foreach ($parameters as $k => $v) {
        if (in_array($k, array('api_salt', 'api_key', 'api_signature'))) continue;
      $sign .= $k . $v;
    }
    $sign .= 'OABeheerApp';

    if($secret) {
      $sign .= $secret;
    }
    $sign .= $salt;

    //echo "\n\n".$sign."\n\n";
    $hash = sha1(str_replace(' ', '', $sign));
    return $hash;
  }

  private function apiCall($parameters, $salt, $secret = null)
  {
    $hash = $this->sign($parameters, $salt, $secret);
    $config = Registry::get('oa');
    $url = trim($config['server_beheer'], '/').'/?';
    //$url = 'http://onlineafspraken.dev.mizar-it.nl/Api2013/?';
    foreach ($parameters as $key => $value) {
      $url .= $key.'='.$value.'&';
    }
    $url .= 'api_format=jsonp&ApplicationId=OABeheerApp&api_signature='.$hash.'&api_jsonp_callback=_jqjsp';
    $response = file_get_contents($url);
    //echo $response;
    $json = json_decode(rtrim(substr($response, 7), ')'), true);
    return $json;
  }

  public function executeLogoff($params = array())
  {
    setcookie('xid_id', null, strtotime('+- year'), '/');
    echo "<script>window.location.href='/main/login';</script>";
    exit;
  }

  public function executeLogin($params = array())
  {
    if (isset($_POST['username'])) {
      $username = $_POST['username'];
      $password = $_POST['password'];

      $credentials = \Credentials::model()->findAllByAttributes(new Criteria(array(
        'username' => $username,
        'active' => 1,
        'type' => 'resource'
      )));
      if ($credentials) {
        foreach ($credentials as $credential) {
          if($credential->password == hash('sha512', $password.$credential->salt)) {
            $resource = Resource::model()->findByAttributes(new Criteria(array(
              'credentials_id' => $credential->id
            )));
            if ($resource) {
              $uid = 'gen'.time().rand(1000000,9999999);
              $resource->xid = $uid;
              $resource->save();
              setcookie('xid_id', $resource->xid, strtotime('+1 year'), '/');
              echo "<script>window.location.href='/main/index';</script>";
              exit;
            }
          }
        }
      }

      $this->error = 'Gebruikersnaam of wachtwoord niet juist';
    }
  }

  private function _searchCustomerAPI($value, $offset = 0, $limit = 50)
  {
    $oa = Registry::get('oa_api');
    $agenda = Registry::get('oa_agenda');
    $consumers = $oa->sendRequest('getCustomers', array(
      'AgendaId' => $agenda['Id'],
      'Offset' => $offset,
      'Limit' => $limit
    ));

    $fullList = array();
    foreach ($consumers['Customer'] as $customer) {
      $tmp = array(
        'Name' => str_replace('  ', ' ', $customer['FirstName'].' '.$customer['Insertions'].' '.$customer['LastName']),
        'Addresss' => str_replace('  ', ' ', $customer['Street'].' '.$customer['HouseNr'].' '.$customer['HouseNrAddition']),
        'ZipCode' => $customer['ZipCode'],
        'City' => $customer['City'],
        'Phone' => $customer['Phone']!=''?$customer['Phone']:$customer['MobilePhone'],
        'Email' => $customer['Email'],
        'SearchKey' => strtoupper(str_replace(' ', '', $customer['ZipCode'].$customer['HouseNr']))
      );
      $fullList[] = $tmp;
    }

    if (($consumers['Stats']->Offset + $consumers['Stats']->Records) < $consumers['Stats']->TotalRecords ) {
      $offset += $limit;
      $more = $this->_searchCustomerAPI($value, $offset, $limit);
      $fullList = array_merge($fullList, $more);
    }

    return $fullList;
  }

  private function _searchCustomer($value)
  {
    $cache = isset($_SESSION['customer_cache']) ? $_SESSION['customer_cache'] : false;
    if (!$cache || $cache['lifetime'] < strtotime('-1 hour')) {
      $customers = $this->_searchCustomerAPI($value);
      $cache['customers'] = $customers;
      $cache['lifetime'] = time();
      $_SESSION['customer_cache'] = $cache;
    }
    $customers = $cache['customers'];
    $search = strtoupper(str_replace(' ', '', $value));
    $results = array();
    foreach ($customers as $customer) {
      if (strstr($customer['SearchKey'], 0, strlen($search)) == $search) {
        $results[] = $customer;
      }
    }

    $data = array();
    $results = array_slice($results, 0, 5);
    foreach ($results as $result) {
      $data[] = array(
        'title' => $result['Name'],
        'fields' => array(
          'customer' => $result['Name'],
          'contact' => $result['Name'],
          'address' => $result['Addresss'],
          'zipcode' => $result['ZipCode'],
          'city' => $result['City'],
          'phone' => $result['Phone'],
          'email' => $result['Email']
        )
      );
    }

    return $data;
  }

  private function _searchProductrowdesc($value)
  {
    $data = array();

    $fullList = array();
    $products = Registry::get('products');
    foreach ($products as $product_category) {
      if ($product_category['title']=='Diensten') {
        foreach ($product_category['items'] as $product_subcategory) {
          foreach ($product_subcategory['items'] as $item) {
            $fullList[] = array(
              'title' => $product_subcategory['title'].' > '.$item['title'],
              'itemtitle' => $item['title'],
              'price' => $item['price']
            );
          }
        }
      }
    }
    foreach ($fullList as $listItem) {
      if (strstr($listItem['title'], $value)) {
        $data[] = array(
          'title' => $listItem['title'],
          'fields' => array(
            'productrowdesc' => $listItem['itemtitle'],
            'productrowcost' => $listItem['price']
          )
        );
      }
    }
    $data = array_splice($data, 0 ,5);

    return $data;
  }

  private function _searchContractor($value)
  {
    $data = array();
    /*
    $data = array(
      array(
        'title' => 'Test',
        'fields' => array(
          'contractor' => 'Test'
        )
      ),
      array(
        'title' => 'Test 1',
        'fields' => array(
          'contractor' => 'Test 1'
        )
      ),
      array(
        'title' => 'Test 2',
        'fields' => array(
          'contractor' => 'Test 2'
        )
      )
    );*/

    return $data;
  }

  private function _searchHoursrowdesc($value)
  {
    $data = array();
    $fullList = array();
    $products = Registry::get('products');
    foreach ($products as $product_category) {
      if ($product_category['title']=='Diensten') {
        foreach ($product_category['items'] as $product_subcategory) {
          foreach ($product_subcategory['items'] as $item) {
            $fullList[] = array(
              'title' => $product_subcategory['title'].' > '.$item['title'],
              'itemtitle' => $item['title'],
              'price' => $item['price']
            );
          }
        }
      }
    }
    foreach ($fullList as $listItem) {
      if (strstr($listItem['title'], $value)) {
        $data[] = array(
          'title' => $listItem['title'],
          'fields' => array(
            'hoursrowdesc' => $listItem['itemtitle'],
          )
        );
      }
    }
    $data = array_splice($data, 0 ,5);

    return $data;
  }

  private function _searchActivityrowdesc($value)
  {
    $data = array();

    $fullList = array();
    $products = Registry::get('products');
    foreach ($products as $product_category) {
      if ($product_category['title']=='Arbeidsloon') {
        foreach ($product_category['items'] as $product_subcategory) {
          foreach ($product_subcategory['items'] as $item) {
            foreach ($item['items'] as $subitem) {
              $fullList[] = array(
                'title' => $product_subcategory['title'] . ' > ' . $item['title'] . ' > ' . $subitem['title'],
                'itemtitle' => $subitem['title'],
                'price' => $subitem['price']
              );
            }
          }
        }
      }
    }
    foreach ($fullList as $listItem) {
      if (strstr(strtolower($listItem['title']), strtolower($value))) {
        $data[] = array(
          'title' => $listItem['title'],
          'fields' => array(
            'activityrowdesc' => $listItem['itemtitle'],
            'activityrowcost' => $listItem['price']

          )
        );
      }
    }
    $data = array_splice($data, 0 ,5);

    return $data;
  }

  public function executeSearch($params = array())
  {
    //$field = 'hoursrowdesc';
    //$value = '02';
    $field = $_POST['field'];
    $value = $_POST['value'];

    $method = '_search'.ucfirst($field);
    if (method_exists($this, $method)) {
      $result = $this->$method($value);
    }

    header('Content-Type: application/json');
    echo json_encode($result);
    exit;
  }

  public function executeSave($params = array())
  {
    $user_id = Registry::get('user_id');
    $user = User::model()->findByAttributes(new Criteria(array('xid' => $user_id)));
    $resource = Resource::model()->findByAttributes(new Criteria(array('xid' => $user_id)));
    $company = Company::model()->findByPk($resource->company_id);

    $app = json_decode($_POST['app'], true);
    $rows = json_decode($_POST['rows'], true);
    $payment = json_decode($_POST['payment'], true);
    $signature = base64_decode($_POST['signature']);
    $images = array();
    $photos = json_decode($_POST['photos'], true);
    if (is_array($photos)) {
      foreach ($photos as $photo) {
        $images[] = base64_decode($photo);
      }
    }

    $params['documenttype'] = 'Factuur';
    $params['title'] = $app['workorder'];
    $params['invoicenr'] = $app['workorder'];
    $params['customernr'] = isset($app['debitor'])?$app['debitor']:'';
    $params['enddate'] = date('Y-m-d', strtotime('+4 weeks'));
    $params['customer'] = $app['customer'].PHP_EOL.$app['address'].PHP_EOL.$app['zipcode'].' '.$app['city'];
    $params['remarks'] = $_POST['remarks'];
    $params['ready'] = $_POST['ready'];
    $params['payment'] = $payment;

    foreach ($rows as $row) {
      $tariff = $amount = 0;
      switch ($row['type']) {
        case 'hours':
          $tariff = 50;
          if ($row['minutes'] > 0) {
            $amount = round(60 / $row['minutes'], 1);
          }
          break;
        case 'product':
          $tariff = $row['cost'];
          $amount = $row['amount'];
          break;
        case 'activity':
          $tariff = $row['cost'];
          $amount = 1;
          break;
      }
      $params['rows'][] = array(
        'type' => $row['desc'],
        'tariff' => $tariff,
        'amount' => $amount
      );
    }

    $params['companyname'] = $company->getSetting('companyname');
    $params['kvk'] = $company->getSetting('kvk');
    $params['btw'] = $company->getSetting('btw');
    $params['iban'] = $company->getSetting('iban');
    $params['iban_name'] = $company->getSetting('iban_name');
    $params['site'] = $company->getSetting('site');
    $params['email'] = $company->getSetting('email');
    $params['invoicedays'] = $company->getSetting('invoicedays');
    $params['color1'] = $company->getSetting('color1');
    $params['color2'] = $company->getSetting('color2');
    $params['logo'] = $company->getSetting('logo');
    $params['sender_name'] = $company->getSetting('sender_name');
    $params['sender_email'] = $company->getSetting('sender_email');
    $params['admin_email'] = $company->getSetting('admin_email');
    $params['in_btw'] = $company->getSetting('in_btw');
    //$params['admin_email'] = 'rfphancy@gmail.com';

    if (!is_dir(getcwd() . '/workorders')) {
      mkdir(getcwd() . '/workorders', 0777);
    }
    if (!is_dir(getcwd() . '/workorders/' . $params['invoicenr'])) {
      mkdir(getcwd() . '/workorders/' . $params['invoicenr']);
    }
    file_put_contents(getcwd().'/workorders/'.$params['invoicenr'].'/signature.png', $signature);
    $image = imagecreatefrompng(getcwd().'/workorders/'.$params['invoicenr'].'/signature.png');
    $size = getimagesize(getcwd().'/workorders/'.$params['invoicenr'].'/signature.png');
    $new_image = imagecreatetruecolor($size[0], $size[1]);
    $white = imagecolorallocate($new_image,  255, 255, 255);
    imagefilledrectangle($new_image, 0, 0, $size[0], $size[1], $white);
    imagecopy($new_image, $image, 0, 0, 0, 0, $size[0], $size[1]);
    imagejpeg($new_image, getcwd().'/workorders/'.$params['invoicenr'].'/signature.jpg');
    $params['signature'] = getcwd().'/workorders/'.$params['invoicenr'].'/signature.jpg';

    $params['images'] = array();
    $x = 0;
    foreach ($images as $image) {
      $x++;
      file_put_contents(getcwd().'/workorders/'.$params['invoicenr'].'/photo-'.$x.'.jpg', $image);
      $params['images'][] = getcwd().'/workorders/'.$params['invoicenr'].'/photo-'.$x.'.jpg';
    }

    if (in_array($payment['paymethod'], array('pin', 'cash', 'invoice'))) {
      $invoice = $this->generateInvoice($params);
    }

    $params['documenttype'] = 'Werkbon';

    $workorder = $this->generateWorkorderCC($params);

    ob_start();
    include(dirname(__FILE__).'/../templates/_email.php');
    $mail_html = ob_get_clean();

    $mail = new PHPMailer;
    $mail->isSendmail();
    $mail->setFrom($params['sender_email'], $params['sender_name']);
    $mail->addReplyTo($params['sender_email'], $params['sender_name']);

    $mail->msgHTML($mail_html);
    $mail->AltBody = $mail_html;
    if (in_array($payment['paymethod'], array('pin', 'cash', 'invoice'))) {
      $mail->addStringAttachment(file_get_contents($invoice), 'factuur-' . $params['invoicenr'] . '.pdf');
    }
    $mail->addStringAttachment(file_get_contents($workorder), 'werkbon-'.$params['invoicenr'].'.pdf');

    if ($app['email']) {
      $mail->addAddress($app['email'], $app['customer']);
      $mail->addCC($params['admin_email'], $params['sender_name']);
      if (in_array($payment['paymethod'], array('pin', 'cash', 'invoice'))) {
        $mail->Subject = 'Werkbon en factuur van onze werkzaamheden';
      }
      else {
        $mail->Subject = 'Werkbon van onze werkzaamheden';
      }

      $mail->send();
    }

    $mail->clearAddresses();

    ob_start();
    include(dirname(__FILE__).'/../templates/_email_admin.php');
    $mail_html = ob_get_clean();
    $mail->msgHTML($mail_html);
    $mail->AltBody = $mail_html;
    if (in_array($payment['paymethod'], array('pin', 'cash', 'invoice'))) {
      $mail->Subject = 'Nieuwe werkbon en factuur';
    }
    else {
      $mail->Subject = 'Nieuwe werkbon';
    }

    $mail->addAddress($params['admin_email'], $params['sender_name']);

    foreach($images as $c => $image) {
      $mail->addStringAttachment($image, 'situatie-foto-'.($c+1).'.jpg');
    }

    if (!$mail->send()) {
    } else {
    }

    echo 'OK';
    exit;
  }

  public function generateInvoice($params = array())
  {
    $color1_r = hexdec(substr($params['color1'],0,2));
    $color1_g = hexdec(substr($params['color1'],2,2));
    $color1_b = hexdec(substr($params['color1'],4,2));

    $color2_r = hexdec(substr($params['color2'],0,2));
    $color2_g = hexdec(substr($params['color2'],2,2));
    $color2_b = hexdec(substr($params['color2'],4,2));

    $pdf= new PDF();
    $pdf->AddPage();
    $pdf->AddFont('Futura');
    $pdf->AddFont('Futura', 'B');
    $pdf->SetFont('Futura','',14);
    $pdf->SetRightMargin(0);
    $pdf->SetFillColor(247,247,247);
    $pdf->Rect(0,0,220,28, 'F');
    $pdf->Image(getcwd().'/img/'.$params['logo'],10,2, 45);

    $pdf->setY(5);
    $pdf->setX(100);
    $pdf->SetFontSize(10);
    $pdf->SetTextColor($color2_r,$color2_g,$color2_b);
    $pdf->Write(4, $params['companyname']);
    $pdf->Ln(4);
    $pdf->SetFontSize(8);
    $pdf->SetTextColor($color1_r,$color1_g,$color1_b);
    $pdf->setX(100);
    $pdf->Write(5, $params['site'].' | '.$params['email']);
    $pdf->Ln(4);
    $pdf->setX(100);
    $pdf->Write(5, 'KvK '.$params['kvk'].' | BTW '.$params['btw'].' | IBAN '.$params['iban']);
    $pdf->Ln(8);
    $pdf->setX(100);
    $pdf->SetTextColor($color2_r,$color2_g,$color2_b);
    $pdf->SetFontSize(14);
    $pdf->SetStyle('B',true);
    $pdf->Write(5, strtoupper($params['documenttype']));
    $pdf->Ln(5);
    $pdf->SetStyle('B',false);

    $pdf->SetStyle('B',true);
    $pdf->SetFontSize(16);
    $pdf->SetTextColor($color2_r,$color2_g,$color2_b);
    $pdf->Ln(5);
    $pdf->Write(5,$params['title']);

    $nr = $params['title'];

    $offset = 0;

    $pdf->Ln(10);
    $pdf->SetFontSize(10);
    $pdf->SetTextColor($color1_r,$color1_g,$color1_b);
    $pdf->Write(5, 'Uw gegevens');
    $pdf->Ln(5);
    $pdf->SetStyle('B',false);
    $parts = explode("\n",$params['customer']);
    if (count($parts) < 5) {
      for($c = count($parts); $c < 5; $c++) {
        $parts[] = '';
      }
    }
    $parts = array_slice($parts,0,5);
    foreach ($parts as $part) {
      $pdf->Write(5, html_entity_decode($part));
      $pdf->Ln(5);
    }
    $offset += ((count($parts) - 3) * 5);

    $pdf->Ln(5);


    $pdf->SetStyle('B',true);
    $pdf->Write(5, 'Kenmerken');
    $pdf->Ln(5);
    $pdf->SetStyle('B',false);

    $pdf->Write(5, 'Factuurdatum');
    $pdf->Write(5, '');
    $pdf->SetX(50);
    $pdf->Write(5, date('d-m-Y', strtotime($params['enddate'])));
    $pdf->Write(5, '');
    $pdf->Ln(5);
    $pdf->Write(5, 'Factuurnummer');
    //$pdf->Write(5, 'Ordernummer');
    $pdf->SetX(50);
    $code =  $params['invoicenr'];

    $pdf->Write(5, $code);
    //$pdf->Write(5, $invoice->getCode());
    $pdf->Ln(5);
    $pdf->Write(5, 'Debiteurnummer');
    $pdf->SetX(50);
    $pdf->Write(5, $params['customernr']);

    $pdf->Ln(10);

    $pdf->SetStyle('B',true);
    $pdf->SetTextColor($color2_r,$color2_g,$color2_b);
    $pdf->Write(5, 'Omschrijving');
    $pdf->SetX(120);
    $pdf->Write(5, 'Uren/Aantal');
    $pdf->SetX(150);
    $pdf->Write(5, 'Tarief');
    $pdf->SetX(180);
    $pdf->Write(5, 'Totaal');
    $pdf->Ln(10);

    $pdf->SetLineWidth(0.3);
    $pdf->SetDrawColor(178,178,178);
    $pdf->Line(10,98+$offset,200,98+$offset);

    $pdf->SetTextColor($color1_r,$color1_g,$color1_b);
    $pdf->SetStyle('B',false);

    $vat = strtotime($params['enddate']) < strtotime(date('2012-10-01')) && strtotime($params['enddate']) > 0 ? 19 : 21;
    $vat_factor = 100 + $vat;


    $rows = array();
    $total = 0;
    foreach ($params['rows'] as $row) {
      if ($params['in_btw'] == 1) {
        $rows[] = array(
          $row['type'],
          $row['amount'],
          '€ '.str_replace(',00', ',-', number_format($row['tariff'] , 2, ',', '.')),
          '€ '.str_replace(',00', ',-', number_format($row['amount']*$row['tariff'] , 2, ',', '.'))
        );
      }
      else {
        $r1 = ($row['tariff'] / $vat_factor) * 100;
        $rows[] = array(
          $row['type'],
          $row['amount'],
          '€ '.str_replace(',00', ',-', number_format($row['tariff'] , 2, ',', '.')),
          '€ '.str_replace(',00', ',-', number_format($row['amount']*$r1 , 2, ',', '.'))
        );
      }

      $total += ($row['amount']*$row['tariff']);
    }

    for ($c = count($rows); $c < (24 - ($offset/5)); $c++)
    {
      $rows[] = array('', '', '', '');
    }

    foreach ($rows as $row) {
      $pdf->Write(5, $row[0]);
      $pdf->SetX(120);
      $pdf->SetFont('Futura','',9);
      $pdf->Write(5, $row[1]);

      $pdf->SetFont('Arial','',9);
      $pdf->SetX(150);
      $pdf->Write(5, $row[2]);
      $pdf->SetX(180);
      $pdf->SetFont('Arial','',9);
      $pdf->Write(5, $row[3]);
      $pdf->SetFont('Futura','',9);
      $pdf->Ln(5);
    }

    $pdf->SetLineWidth(0.3);
    $pdf->SetDrawColor(178,178,178);
    $pdf->Line(10,223,200,223);
    $pdf->Ln(5);


    if ($params['in_btw'] == 1) {
      $total_ex = ($total / $vat_factor)*100;
      // todo: recalculate total and total_ex
    }
    else {
      $total_ex = ($total / $vat_factor)*100;
    }


//  $trtotime($invoice->getDate()) < strtotime(date('2012-10-01')) ? 19 : 21;
    //$vat_factor = (100 + $vat) / 100;

    //$total_ex = $invoice->getHourrate() * $time;
    //$total = ($invoice->getHourrate() * $time) * $vat_factor;

    $pdf->SetX(140);
    $pdf->Write(5, 'Totaal exclusief BTW');
    $pdf->SetX(180);
    $pdf->SetFont('Arial','',10);
    $pdf->Write(5, '€ '.str_replace(',00', ',-', number_format($total_ex, 2, ',', '.')));
    $pdf->SetFont('Futura','',10);
    $pdf->Ln(5);

    $pdf->SetX(140);
    $pdf->Write(5, $vat.'% BTW');
    $pdf->SetX(180);
    $pdf->SetFont('Arial','',10);
    $pdf->Write(5, '€ '.str_replace(',00', ',-', number_format($total - $total_ex , 2, ',', '.')));
    $pdf->SetFont('Futura','',10);
    $pdf->Ln(5);

    $pdf->SetLineWidth(0.5);
    $pdf->SetDrawColor(178,178,178);
    $pdf->Line(10,238,200,238);
    $pdf->Ln(5);

    $pdf->SetStyle('B',true);
    $pdf->SetFontSize(12);
    $pdf->SetTextColor($color2_r,$color2_g,$color2_b);
    $pdf->SetTextColor($color2_r,$color2_g,$color2_b);
    $pdf->SetX(140);
    $pdf->Write(5, 'Totaal');
    $pdf->SetX(180);
    $pdf->SetFont('Arial','',12);
    $pdf->SetStyle('B',true);
    $pdf->Write(5, '€ '.str_replace(',00', ',-', number_format($total, 2, ',', '.')));
    $pdf->SetFont('Futura','',10);
    $pdf->Ln(5);

    $pdf->SetFont('Futura','',10);
    $pdf->SetStyle('B',false);
    $pdf->SetStyle('B',false);
    $pdf->SetFontSize(10);
    $pdf->SetTextColor($color1_r,$color1_g,$color1_b);
    //$pdf->Ln(($invoice->getPayed() > 0) ? 8 : 18);
    $pdf->Ln(18);

    switch($params['payment']['paymethod']) {
      case 'invoice':

        $pdf->SetX(17);
        $pdf->Write(5, 'Wij verzoeken u vriendelijk het factuurbedrag binnen '.$params['invoicedays'].' dagen na factuurdatum over te maken op bankrekening');
        $pdf->Ln(5);
        $pdf->SetX(33);
        $pdf->Write(2, $params['iban'].' tnv '.$params['iban_name'].' o.v.v. uw debiteurnummer en factuurnummer.');
        break;

      case 'cash':
        $pdf->SetX(17);
        $pdf->Write(5, 'Deze factuur is reeds per contant voldaan.');
        $pdf->Ln(5);
        break;

      case 'pin':
        $pdf->SetX(17);
        $pdf->Write(5, 'Deze factuur is reeds per pin-betaling voldaan.');
        $pdf->Ln(5);
        break;
    }


    if (!is_dir(getcwd().'/invoices')) {
      mkdir(getcwd().'/invoices', 0777);
    }
    $pdf->Output(getcwd().'/invoices/'.$params['invoicenr'].'.pdf');

    return getcwd().'/invoices/'.$params['invoicenr'].'.pdf';
    /*
    $server = str_replace('cms.', '', $_SERVER['HTTP_HOST']);

    header('Location: http://'.$server.'/invoices/'.$params['invoicenr'].'.pdf');
    exit;*/
  }

  public function generateWorkorderCC($params = array()) {
    $color1_r = hexdec(substr($params['color1'],0,2));
    $color1_g = hexdec(substr($params['color1'],2,2));
    $color1_b = hexdec(substr($params['color1'],4,2));

    $color2_r = hexdec(substr($params['color2'],0,2));
    $color2_g = hexdec(substr($params['color2'],2,2));
    $color2_b = hexdec(substr($params['color2'],4,2));

    $pdf= new PDF();
    $pdf->AddPage();
    $pdf->AddFont('Futura');
    $pdf->AddFont('Futura', 'B');
    $pdf->SetFont('Futura','',14);
    $pdf->SetRightMargin(0);
    $pdf->SetFillColor(247,247,247);
    $pdf->Rect(0,0,220,28, 'F');
    $pdf->Image(getcwd().'/img/'.$params['logo'],10,5, 45);

    $pdf->setY(5);
    $pdf->setX(100);
    $pdf->SetFontSize(10);
    $pdf->SetTextColor($color2_r,$color2_g,$color2_b);
    $pdf->Write(4, $params['companyname']);
    $pdf->Ln(4);
    $pdf->SetFontSize(8);
    $pdf->SetTextColor($color1_r,$color1_g,$color1_b);
    $pdf->setX(100);
    $pdf->Write(5, $params['site'].' | '.$params['email']);
    $pdf->Ln(4);
    $pdf->setX(100);
    $pdf->Write(5, 'KvK '.$params['kvk'].' | BTW '.$params['btw'].' | IBAN '.$params['iban']);
    $pdf->Ln(8);
    $pdf->setX(100);
    $pdf->SetTextColor($color2_r,$color2_g,$color2_b);
    $pdf->SetFontSize(14);
    $pdf->SetStyle('B',true);
    $pdf->Write(5, strtoupper($params['documenttype']));
    $pdf->Ln(5);
    $pdf->SetStyle('B',false);

    $pdf->SetStyle('B',true);
    $pdf->SetFontSize(16);
    $pdf->SetTextColor($color2_r,$color2_g,$color2_b);
    $pdf->Ln(5);
    $pdf->Write(5,$params['title']);

    $nr = $params['title'];

    $offset = 0;

    $pdf->Ln(10);
    $pdf->SetFontSize(10);
    $pdf->SetTextColor($color1_r,$color1_g,$color1_b);
    $pdf->Write(5, 'Uw gegevens');
    $pdf->Ln(5);
    $pdf->SetStyle('B',false);
    $parts = explode("\n",$params['customer']);
    if (count($parts) < 3) {
      for($c = count($parts); $c < 3; $c++) {
        $parts[] = '';
      }
    }
    $parts = array_slice($parts,0,3);
    foreach ($parts as $part) {
      $pdf->Write(5, html_entity_decode($part));
      $pdf->Ln(5);
    }
    $offset += ((count($parts) - 3) * 5);



    $pdf->Write(5, 'Debiteurnummer '.$params['customernr']);

    $pdf->Ln(10);

    $pdf->SetStyle('B',true);
    $pdf->SetTextColor($color2_r,$color2_g,$color2_b);
    $pdf->Write(5, 'Omschrijving');
    $pdf->SetX(120);
    $pdf->Write(5, 'Uren/Aantal');

    $pdf->Ln(10);

    $pdf->SetLineWidth(0.3);
    $pdf->SetDrawColor(178,178,178);
    $pdf->Line(10,78+$offset,200,78+$offset);

    $pdf->SetTextColor($color1_r,$color1_g,$color1_b);
    $pdf->SetStyle('B',false);

    $rows = array();
    $total = 0;
    foreach ($params['rows'] as $row) {
      $rows[] = array(
        $row['type'],
        $row['amount'],

      );
      $total += ($row['amount']*$row['tariff']);
    }

    for ($c = count($rows); $c < (16 - ($offset/5)); $c++)
    {
      $rows[] = array('', '');
    }

    foreach ($rows as $row) {
      $pdf->Write(5, $row[0]);
      $pdf->SetX(120);
      $pdf->SetFont('Futura','',9);
      $pdf->Write(5, $row[1]);
      $pdf->Ln(5);
    }

    $pdf->SetLineWidth(0.3);
    $pdf->SetDrawColor(178,178,178);
    $pdf->Line(10,163,200,163);
    $pdf->Ln(5);

    if(count($params['images']) > 6) {
      $params['images'] = array_slice($params['images'],0,6);
    }
    $x = -1;
    $y = 0;
    foreach ($params['images'] as $image) {
      $x++;
      if ($x == 3) {
        $x = 0;
        $y++;
      }

      $pdf->Image($image,10 + ($x * 65),170 + ($y * 30), 60);
    }

    $pdf->SetY(230);
    $pdf->SetFont('Futura','',9);
    $pdf->Write(5, 'Handtekening klant:');
    $pdf->Image($params['signature'],10,240, 70);

    $pdf->SetY(230);
    $pdf->SetX(120);
    $pdf->Write(5, 'Werkzaamheden gereed: '.$params['ready']?'Ja':'Nee');

    $pdf->SetY(250);
    $pdf->SetX(120);
    $pdf->Write(5, 'Opmerkingen:');
    $pdf->Ln(5);
    $pdf->SetX(120);
    $pdf->Write(5, $params['remarks']);

    if (!is_dir(getcwd().'/workorders')) {
      mkdir(getcwd().'/workorders', 0777);
    }
    $pdf->Output(getcwd().'/workorders/'.$params['invoicenr'].'.pdf');

    //header('Location: /workorders/'.$params['invoicenr'].'.pdf');
    //exit;
    return getcwd().'/workorders/'.$params['invoicenr'].'.pdf';

  }
  public function executeAbout($params = array())
  {

  }

  public function executeIndex($params = array())
  {

    $user_id = Registry::get('user_id');
    $user = Resource::model()->findByAttributes(new Criteria(array('xid' => $user_id)));
    if (!$user) {
      header('Location: /main/login');
    }
    $this->user = $user;
    $this->user_id = $user_id;

    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
      header('Content-Type: application/json');
      echo json_encode(array(

      ));
      exit;
    }
  }

  public function executeLoadAppointments($params = array())
  {
    $json_appointments = array();

    $date = date('Y-m-d', strtotime($_POST['date']));

    $user_id = Registry::get('user_id');
    $resource = Resource::model()->findByAttributes(new Criteria(array('xid' => $user_id)));

    $appointments = Appointment::model()->findAllByAttributes(new Criteria(array(
      'resource_id' => $resource->id
    )));
    if ($appointments) {
      foreach ($appointments as $appointment) {
        if ($date != date('Y-m-d', strtotime($appointment->date))) continue;
        $customer = false;
        if ($appointment->customer_id > 0) {
          $customer = Customer::model()->findByPk($appointment->customer_id);
        }
        $address = Address::model()->findByPk($appointment->address_id);

        $json_appointments[$appointment->id] = array(
          'orderrows' => array($appointment->title),
          'workorder' => 'WO-'.str_pad($appointment->id, 8, '0', STR_PAD_LEFT),
          'time' => date('H:i', strtotime($appointment->date)) . ' - ' . date('H:i', strtotime($appointment->enddate)),
          'id' => $appointment->id
        );
        if ($customer) {
          $json_appointments[$appointment->id]['customer'] = $customer->title;
          $json_appointments[$appointment->id]['contact'] = $customer->title;
          $json_appointments[$appointment->id]['phone'] = $customer->phone;
          $json_appointments[$appointment->id]['email'] = $customer->email;
          $json_appointments[$appointment->id]['debitor'] = '';
        }

        if ($address) {
          $json_appointments[$appointment->id]['address'] = $address->address;
          $json_appointments[$appointment->id]['zipcode'] = $address->zipcode;
          $json_appointments[$appointment->id]['city'] = $address->city;
        }

        $checklists = ChecklistAppointment::model()->findAllByAttributes(new Criteria(array('appointment_id' => $appointment->id)));
        foreach ($checklists as $checklist) {
          $rows = ChecklistRow::model()->findAllByAttributes(new Criteria(array('checklist_id' => $checklist->checklist_id, 'active' => 1)));
          foreach ($rows as $row) {
            $json_appointments[$appointment->id]['checklist'][$checklist->checklist_id][$row->id] = $row->label;
          }
        }
        // TODO:
        // prepared order rows
        // extra fields for customer
        // extra fields for appointment
      }
    }

    header('Content-Type: application/json');
    echo json_encode(array(date('y-m-d', strtotime($date)) => $json_appointments, 'username' => $resource->name, 'resource' => $resource->id, 'xid' => Registry::get('user_id')));
    exit;
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