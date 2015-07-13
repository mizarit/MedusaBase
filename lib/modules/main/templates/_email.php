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