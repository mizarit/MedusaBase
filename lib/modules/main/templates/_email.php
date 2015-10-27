<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>iWerkbon</title>
  <style tyle="text/css">
    tr, td {
      padding: 0;
      margin: 0;
      border: none;
    }

    * {
      font-family: 'Verdana';
      font-size: 13px;
      color: #1a1a1a;
    }

    h1 {
      font-size: 18px;
      text-align: left;
      color: #00b4ff;
    }

    p {
      margin-top: 20px;
    }
    p a {
      text-decoration: none;
      font-size: 13px;
    }
    table {
      margin-bottom: 30px;
    }
    td {
      padding: 5px 0;
    }
  </style>
  <img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/img/logo-iwerkbon.png" style="width:140px;">
<p>Beste <?php echo $app['customer']; ?>,</p>
<p>Bijgevoegd een kopie van de werkbon van de werkzaamheden die vandaag bij u zijn uitgevoerd.</p>
<?php

switch ($payment['paymethod']) {
  case 'pin':
    echo '<p>Daarnaast bijgevoegd de factuur van de werkzaamheden.De factuur is reeds per pin-betaling voldaan.</p>';
    break;
  case 'cash':
    echo '<p>Daarnaast bijgevoegd de factuur van de werkzaamheden.De factuur is reeds per contant voldaan.</p>';
    break;
  case 'invoice':
    echo '<p>Daarnaast bijgevoegd de factuur van de werkzaamheden. De factuur is op rekening. Zie de bijgevoegde factuur voor de betalingsvoorwaarden.</p>';
    break;
  case 'service':
    echo '<p>De werkzaamheden zijn als service uitgevoerd.</p>';
    break;
}
?>

<p>Met vriendelijke groet,</p>

<p><?php echo $params['sender_name']; ?></p>
<?php
/*
?>
<pre>
  <?php echo $_POST['startWork'].' - '.$_POST['finishWork']; ?>
  <?php var_dump($app); ?>
  <?php var_dump($rows); ?>
</pre>
*/ ?>