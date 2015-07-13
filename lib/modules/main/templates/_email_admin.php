<p>Beste beheerder,</p>

<p>Bijgevoegd een kopie van de werkbon en eventuele factuur van de werkzaamheden die vandaag bij <?php echo $app['customer']; ?> zijn uitgevoerd.</p>

<p>Met vriendelijke groet,</p>

<p><?php echo $params['sender_name']; ?></p>

<hr>
<p>Onderstaande informatie is bedoeld voor de ontwikkelaar.</p>
<pre>
  <?php echo $_POST['startWork'].' - '.$_POST['finishWork']; ?>
  <?php var_dump($app); ?>
  <?php var_dump($rows); ?>
</pre>
