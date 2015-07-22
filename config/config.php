<?php

$debug_prod = true;

if (!$debug_prod && strstr($_SERVER['SERVER_NAME'], 'mizar')) {
  $config = array(
    'connection' => array(
      'server' => 'localhost',
      'database' => 'medusa',
      'username' => 'medusa',
      'password' => 'medusa'
    ),
    'connection_site' => array(
      'server' => 'localhost',
      'database' => 'iwerkbon-site',
      'username' => 'zeus4',
      'password' => 'zeus4'
    ),
    'oa' => array(
      'server' => 'http://onlineafspraken.dev.mizar-it.nl/APIREST',
      'server_beheer' => 'http://onlineafspraken.dev.mizar-it.nl/Api2013',
      'api_key' => 'fhlg83culd13-bzld03',
      'api_secret' => '22571c6007f22bbb9d3d9dbaf5a4b7e2a976fea3'
    )
  );
}
else {
  $config = array(
    'connection' => array(
      'server' => 'localhost',
      'database' => 'iwerkbon',
      'username' => 'iwerkbon',
      'password' => 'iwerkbon'
    ),
    'connection_site' => array(
      'server' => 'localhost',
      'database' => 'iwerkbon-site',
      'username' => 'zeus4',
      'password' => 'zeus4'
    ),
    'oa' => array( // Rijnstreek
      'server' => 'https://agenda.onlineafspraken.nl/APIREST',
      'server_beheer' => 'https://agenda.onlineafspraken.nl/Api2013',
      'api_key' => 'nccf92lrey49-lbaz00',
      'api_secret' => '2e2522aece449b576c3a0a03a9b4692ff0e674d4'
    ),
  );
}

$config = array_merge($config, array(
  'products' => array(
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

  )
));

?>