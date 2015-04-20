<?php
//$c = new Criteria(array('team_id' => $team->id, 'date' => array($user->lastRead, '>')), null, 'date DESC LIMIT 50');
//$count = Message::model()->count($c);
$count = 0;
if ($count > 0) {
  ?>
  <div id="chat-count" onclick="toggleSidebar('sidebar-left');" style="position: absolute;top:<?php echo $iOS? '0.1':'0.3'; ?>em;left:<?php echo $iOS? '1.5':'0.3'; ?>em;width:2em;height:2em;z-index:10;">
    <i class="fa fa-circle" style="position:absolute;left:0;top:0;font-size:2em;color:#c00;"></i>
    <div id="chat-count-value" style="font-weight:bold;color:#fff;position:absolute;top:0;left:0;width:1.7em;line-height:2em;font-size:1em;text-align:center;"><?php echo $count; ?></div>
  </div>
<?php } ?>
<div id="sidebar-left" class="sidebar">
  <div id="sidebar-left-inner" class="sidebar-inner" style="overflow:scroll;">
    <ul id="sidebar-nav">
      <li class="main-item"><i class="fa fa-user"></i> Mijn account
        <i class="fa fa-remove" style="position: absolute;right:<?php echo $iOS? '-0.9em':'0'; ?>;top:0;border:none;" onclick="toggleSidebar('sidebar-left');"></i></li>

      <li class="disabled-item" onclick="setActive(this);goPage(1);toggleSidebar('sidebar-left');"><i class="fa fa-users"></i> Klanten</li>
      <li class="disabled-item" onclick="setActive(this);goPage(2);toggleSidebar('sidebar-left');"><i class="fa fa-calendar"></i> Afspraken</li>
      <li class="disabled-item" onclick="setActive(this);goPage(3);toggleSidebar('sidebar-left');"><i class="fa fa-wrench"></i> Werkbonnen</li>
      <li class="disabled-item" onclick="setActive(this);goPage(6);toggleSidebar('sidebar-left');"><i class="fa fa-car"></i> Reistijden</li>
      <li class="disabled-item" onclick="setActive(this);goPage(7);toggleSidebar('sidebar-left');"><i class="fa fa-clock-o"></i> Urenregistratie</li>
      <li class="disabled-item" onclick="setActive(this);goPage(8);toggleSidebar('sidebar-left');"><i class="fa fa-photo"></i> Situatiefoto's</li>
      <li class="disabled-item" onclick="setActive(this);goPage(9);toggleSidebar('sidebar-left');"><i class="fa fa-euro"></i> Kassa</li>
      <li class="disabled-item" onclick="setActive(this);goPage(10);toggleSidebar('sidebar-left');"><i class="fa fa-comment"></i> Notities</li>
      <li onclick="setActive(this);goPage(5);toggleSidebar('sidebar-left');"><i class="fa fa-pencil-square-o"></i> Digitale handtekening</li>
      <li onclick="setActive(this);goPage(4);toggleSidebar('sidebar-left');"><i class="fa fa-cogs"></i> Instellingen</li>
      <li onclick="window.location.href=window.location.href;"><i class="fa fa-bug"></i> Verversen</li>
      <li onclick="window.location.href='/main/debug?ju=<?php echo $user_id; ?>';"><i class="fa fa-bug"></i>Debugger</li>
    </ul>

  </div>
</div>
