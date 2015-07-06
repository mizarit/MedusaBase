<div id="page-2" style="padding: 0;margin:0;" class="active">
  <h2 style="margin:0;padding:0;border-top:#fff 1px solid;background:#2ea6dd;font-size:1.5em;line-height:1.6em;color:#fff;">Afspraken</h2>
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
  Event.observe(window, 'load', function() {
    Workorder.loadAppointmentForDate('<?php echo date('Y-m-d'); ?>');
  });
  var shortlistItems = <?php echo json_encode(array(
    array(
      'title' => 'Diensten',
      'items' => array(
        array(
          'title' => '010 Onderhoud',
          'items' => array(
            array(
              'title' => 'CV ketel (solo) tot 40KW',
              'price' => 74.5
            ),
            array(
              'title' => 'CV ketel (combi) tot 40KW',
              'price' => 90
            ),
            array(
              'title' => 'CV ketel (solo) tot 80KW',
              'price' => 96
            ),
            array(
              'title' => 'CV ketel (combi) tot 80KW',
              'price' => 111
            ),
            array(
              'title' => 'Moederhaard',
              'price' => 74.5
            ),
            array(
              'title' => 'Gasboiler',
              'price' => 63.5
            ),
            array(
              'title' => 'Gashaard',
              'price' => 62.5
            ),
            array(
              'title' => 'Badgeiser',
              'price' => 58
            ),
            array(
              'title' => 'Keukengeiser',
              'price' => 49
            ),
            array(
              'title' => 'Douchegeiser',
              'price' => 55
            ),
            array(
              'title' => 'WTW unit',
              'price' => 64
            ),
            array(
              'title' => 'Zonneboiler',
              'price' => 52
            ),
            array(
              'title' => 'MV box',
              'price' => 29
            ),
            array(
              'title' => 'Toeslag eenmalig onderhoud',
              'price' => 12.5
            )
          )
        ),
        array(
          'title' => '020 Service',
          'items' => array(
            array(
              'title' => 'CV ketel (solo) tot 40KW',
              'price' => 97
            ),
            array(
              'title' => 'CV ketel (combi) tot 40KW',
              'price' => 101
            ),
            array(
              'title' => 'CV ketel (solo) tot 80KW',
              'price' => 125.5
            ),
            array(
              'title' => 'CV ketel (combi) tot 80KW',
              'price' => 137
            ),
            array(
              'title' => 'Moederhaard',
              'price' => 95
            ),
            array(
              'title' => 'Gasboiler',
              'price' => 84
            ),
            array(
              'title' => 'Gashaard',
              'price' => 73.5
            ),
            array(
              'title' => 'Badgeiser',
              'price' => 73.5
            ),
            array(
              'title' => 'Keukengeiser',
              'price' => 68
            ),
            array(
              'title' => 'Douchegeiser',
              'price' => 72
            ),
            array(
              'title' => 'WTW unit',
              'price' => 91
            ),
            array(
              'title' => 'Zonneboiler',
              'price' => 78
            ),
            array(
              'title' => 'MV box',
              'price' => 40
            ),
            array(
              'title' => 'Toeslag eenmalig onderhoud',
              'price' => 12.5
            )
          )
        ),
        array(
          'title' => '030 All-in',
          'items' => array(
          array(
              'title' => 'CV ketel (solo) tot 40KW',
              'price' => 139.5
            ),
            array(
              'title' => 'CV ketel (combi) tot 40KW',
              'price' => 158
            ),
            array(
              'title' => 'CV ketel (solo) tot 80KW',
              'price' => 167.5
            ),
            array(
              'title' => 'CV ketel (combi) tot 80KW',
              'price' => 179.5
            ),
            array(
              'title' => 'Toeslag eenmalig onderhoud',
              'price' => 12.5
            )
          )
        ),
        array(
          'title' => 'OGP',
          'items' => array(
            array(
              'title' => 'CV ketel (combi) tot 40KW',
              'price' => 158
            )
          )
        ),
      )
    ),
    array(
      'title' => 'Arbeidsloon',
      'items' => array(
        array(
          'title' =>'Klanten',
          'items' => array(
            array(
            'title' =>'Ma t/m Vrijdag',
            'items' => array(
              array(
                'title' => 'Arbeidsloon per uur',
                'price' => 64
              ),
              array(
                'title' => 'Arbeidsloon per 15 min.',
                'price' => 16
              ),
              array(
                'title' => 'Arbeidsloon per 30 min.',
                'price' => 32
              ),
              array(
                'title' => 'Arbeidsloon per 45 min.',
                'price' => 48
              ),
              array(
                'title' => 'Voorrijtarief',
                'price' => 38
              ),
              array(
                'title' => 'Basistarief 1-14 min.',
                'price' => 54
              ),
              array(
                'title' => 'Basistarief 15-30 min.',
                'price' => 70
              ),
            )
          ),
          array(
            'title' =>'Avond',
            'items' => array(
              array(
                'title' => 'Arbeidsloon per uur',
                'price' => 90
              ),
              array(
                'title' => 'Arbeidsloon per 15 min.',
                'price' => 22.5
              ),
              array(
                'title' => 'Arbeidsloon per 30 min.',
                'price' => 45
              ),
              array(
                'title' => 'Arbeidsloon per 45 min.',
                'price' => 67.5
              ),
              array(
                'title' => 'Voorrijtarief',
                'price' => 47
              ),
              array(
                'title' => 'Basistarief 1-14 min.',
                'price' => 69.5
              ),
              array(
                'title' => 'Basistarief 15-30 min.',
                'price' => 92
              ),
            )
          ),
          array(
            'title' =>'Zaterdag',
            'items' => array(
              array(
                'title' => 'Arbeidsloon per uur',
                'price' => 102
              ),
              array(
                'title' => 'Arbeidsloon per 15 min.',
                'price' => 25.5
              ),
              array(
                'title' => 'Arbeidsloon per 30 min.',
                'price' => 51
              ),
              array(
                'title' => 'Arbeidsloon per 45 min.',
                'price' => 76.5
              ),
              array(
                'title' => 'Voorrijtarief',
                'price' => 52
              ),
              array(
                'title' => 'Basistarief 1-14 min.',
                'price' => 77.5
              ),
              array(
                'title' => 'Basistarief 15-30 min.',
                'price' => 103
              ),
            )
          ),
          array(
            'title' =>'Zondag',
            'items' => array(
              array(
                'title' => 'Arbeidsloon per uur',
                'price' => 127.5
              ),
              array(
                'title' => 'Arbeidsloon per 15 min.',
                'price' => 31.88
              ),
              array(
                'title' => 'Arbeidsloon per 30 min.',
                'price' => 63.76
              ),
              array(
                'title' => 'Arbeidsloon per 45 min.',
                'price' => 95.64
              ),
              array(
                'title' => 'Voorrijtarief',
                'price' => 65
              ),
              array(
                'title' => 'Basistarief 1-14 min.',
                'price' => 96.88
              ),
              array(
                'title' => 'Basistarief 15-30 min.',
                'price' => 128.76
              ),
            )
          )
          )
        ),
        array(
          'title' =>'Niet klanten',
          'items' => array(
              array(
                'title' =>'Ma t/m Vrijdag',
                'items' => array(
                  array(
                    'title' => 'Arbeidsloon per uur',
                    'price' => 72
                  ),
                  array(
                    'title' => 'Arbeidsloon per 15 min.',
                    'price' => 18
                  ),
                  array(
                    'title' => 'Arbeidsloon per 30 min.',
                    'price' => 36
                  ),
                  array(
                    'title' => 'Arbeidsloon per 45 min.',
                    'price' => 54
                  ),
                  array(
                    'title' => 'Voorrijtarief',
                    'price' => 42
                  ),
                  array(
                    'title' => 'Basistarief 1-14 min.',
                    'price' => 60
                  ),
                  array(
                    'title' => 'Basistarief 15-30 min.',
                    'price' => 78
                  ),
                )
              ),
              array(
                'title' =>'Avond',
                'items' => array(
                  array(
                    'title' => 'Arbeidsloon per uur',
                    'price' => 94
                  ),
                  array(
                    'title' => 'Arbeidsloon per 15 min.',
                    'price' => 23.5
                  ),
                  array(
                    'title' => 'Arbeidsloon per 30 min.',
                    'price' => 47
                  ),
                  array(
                    'title' => 'Arbeidsloon per 45 min.',
                    'price' => 70.5
                  ),
                  array(
                    'title' => 'Voorrijtarief',
                    'price' => 56
                  ),
                  array(
                    'title' => 'Basistarief 1-14 min.',
                    'price' => 79.5
                  ),
                  array(
                    'title' => 'Basistarief 15-30 min.',
                    'price' => 103
                  ),
                )
              ),
              array(
                'title' =>'Zaterdag',
                'items' => array(
                  array(
                    'title' => 'Arbeidsloon per uur',
                    'price' => 107
                  ),
                  array(
                    'title' => 'Arbeidsloon per 15 min.',
                    'price' => 26.75
                  ),
                  array(
                    'title' => 'Arbeidsloon per 30 min.',
                    'price' => 53.5
                  ),
                  array(
                    'title' => 'Arbeidsloon per 45 min.',
                    'price' => 80.25
                  ),
                  array(
                    'title' => 'Voorrijtarief',
                    'price' => 60
                  ),
                  array(
                    'title' => 'Basistarief 1-14 min.',
                    'price' => 86.75
                  ),
                  array(
                    'title' => 'Basistarief 15-30 min.',
                    'price' => 113.5
                  ),
                )
              ),
              array(
                'title' =>'Zondag',
                'items' => array(
                  array(
                    'title' => 'Arbeidsloon per uur',
                    'price' => 145
                  ),
                  array(
                    'title' => 'Arbeidsloon per 15 min.',
                    'price' => 36.25
                  ),
                  array(
                    'title' => 'Arbeidsloon per 30 min.',
                    'price' => 72.5
                  ),
                  array(
                    'title' => 'Arbeidsloon per 45 min.',
                    'price' => 108.75
                  ),
                  array(
                    'title' => 'Voorrijtarief',
                    'price' => 70
                  ),
                  array(
                    'title' => 'Basistarief 1-14 min.',
                    'price' => 106.25
                  ),
                  array(
                    'title' => 'Basistarief 15-30 min.',
                    'price' => 142.5
                  ),
                )
              )
          )
        )
      )
    )

  )); ?>;
  Workorder.setShortlistItems(shortlistItems);
</script>
