<div id="page-2" style="padding: 0;margin:0;" class="active">
  <div style="padding: 0.5em;">
    <div class="date-selector">
      <div id="date-prev-app" class="date-prev"><i class="fa fa-caret-left"></i></div>
      <div id="date-current-app" class="date-current">Vandaag</div>
      <div id="date-next-app" class="date-next"><i class="fa fa-caret-right"></i></div>
    </div>

    <ul id="appointment-list">
    <?php
    /*
    $json_appointments = array();

    $oa = Registry::get('oa_api');
    $agenda = Registry::get('oa_agenda');
    $appointments = $oa->sendRequest('getAppointments', array(
      'AgendaId' => $agenda['Id'],
      'ResourceId' => 1, // Blonde Dollie
      'StartDate' => date('y-m-d'),
      'EndDate' => date('y-m-d')
    ));
    if (isset($appointments['Appointment'])) {
      foreach ($appointments['Appointment'] as $appointment) {
        $consumer = false;
        if ($appointment['CustomerId']) {
          $consumer = $oa->sendRequest('getCustomer', array(
            'id' => $appointment['CustomerId']
          ));
          if ($consumer) {
            $consumer = $consumer['Customer'][0];
          }
        }

        $json_appointments[$appointment['Id']] = array(
          'orderrows' => array($appointment['Name']),
          'workorder' => 'WO-'.str_pad($appointment['Id'], 8, '0', STR_PAD_LEFT),
          'time' => date('H:i', strtotime($appointment['StartTime'])).' - '.date('H:i', strtotime($appointment['FinishTime'])),
          'id' => $appointment['Id']
        );
        ?>
        <li onclick="Workorder.loadAppointment(<?php echo $appointment['Id']; ?>);goPage(3,2);">
          <?php echo $appointment['Name']; ?><br>
          <?php echo date('H:i', strtotime($appointment['StartTime'])); ?>
            - <?php echo date('H:i', strtotime($appointment['FinishTime'])); ?>
          <?php if ($consumer) {
            $json_appointments[$appointment['Id']]['customer'] = $consumer['FirstName'].' '.$consumer['LastName'];
            $json_appointments[$appointment['Id']]['contact'] = $consumer['FirstName'].' '.$consumer['LastName'];
            $json_appointments[$appointment['Id']]['address'] = $consumer['Street'].' '.$consumer['HouseNr'].$consumer['HouseNrAddition'];
            $json_appointments[$appointment['Id']]['zipcode'] = $consumer['ZipCode'];
            $json_appointments[$appointment['Id']]['city'] = $consumer['City'];
            $json_appointments[$appointment['Id']]['phone'] = $consumer['Phone'];
            $json_appointments[$appointment['Id']]['email'] = $consumer['Email'];
            ?>
          <span><?php echo $consumer['FirstName']; ?> <?php echo $consumer['LastName']; ?></span>
            <?php if ($consumer['Street']) { ?><span><?php echo $consumer['Street']; ?> <?php echo $consumer['HouseNr']; ?><?php echo $consumer['HouseNrAddition']; ?>
              <br>
              <?php echo $consumer['ZipCode']; ?> <?php echo $consumer['City']; ?></span><?php } ?>
            <?php if ($consumer['MobilePhone']) { ?><span><?php echo $consumer['MobilePhone']; ?></span><?php } ?>
            <?php if ($consumer['Phone']) { ?><span><?php echo $consumer['Phone']; ?>
              </span><?php } ?>
            <?php if ($consumer['Email']) { ?><span><?php echo $consumer['Email']; ?>
              </span><?php } ?>
          <?php } ?>
          <i class="fa fa-chevron-right"></i>
        </li>
      <?php
      }
    }*/
      ?>
    </ul>
  </div>
</div>
<script type="text/javascript">
  var shortlistItems = <?php echo json_encode(Registry::get('products')); ?>;
Event.observe(window, 'load', function() {
  Workorder.loadAppointmentForDate('<?php echo date('Y-m-d'); ?>');
  Workorder.loadWorkordersFromBackend('<?php echo date('Y-m-d'); ?>');
  Workorder.setShortlistItems(shortlistItems);

  Workorder.loadConsumers();
});
</script>
