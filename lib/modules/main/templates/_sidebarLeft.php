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


    <div id="sidebar-left-inner" class="sidebar-inner" style="overflow:scroll;width:100%;">
      <h3><i class="fa fa-arrow-left" id="nav-back" onclick="closeSubmenu();"></i>Menu<i class="fa fa-close" id="nav-close" onclick="closeSubmenu();toggleSidebar('sidebar-left');"></i></h3>
      <div id="mainnav" class="active">
        <ul style="margin-top:0.5em;">
          <li style="background:#fec508;color:#fff;"><i class="fa fa-user"></i> <span id="user-name">Blondie dollie</span></li>
          <li onclick="setActive(this);goPage(2);toggleSidebar('sidebar-left');"><i class="fa fa-calendar"></i> Afspraken</li>
          <!--<li onclick="setActive(this);goPage(1);toggleSidebar('sidebar-left');"><i class="fa fa-users"></i> Klanten</li>-->
          <li onclick="setActive(this);Workorder.showWorkorders();goPage(16);toggleSidebar('sidebar-left');"><i class="fa fa-wrench"></i> Werkbonnen (<span id="workorder-count">0</span>)</li>
          <!--<li onclick="setActive(this);goPage(10);toggleSidebar('sidebar-left');"><i class="fa fa-comment"></i> Notities</li>-->
        </ul>
          <ul>
            <?php if($user->device=='android' || $user->device=='ios'){ ?>
            <li class="subnav" onclick="openSubmenu();"><i class="fa fa-cogs"></i> Instellingen<span><i class="fa fa-chevron-right"></i></span></li>
            <?php } ?>
            <li onclick="window.location.href='/main/logoff';toggleSidebar('sidebar-left');"><i class="fa fa-sign-out"></i> Uitloggen</li>
          </ul>
          <?php if (strpos($_SERVER['SERVER_NAME'], 'mizar')) { ?>
            <ul>
              <li onclick="window.location.href=window.location.href;"><i class="fa fa-refresh"></i> Verversen</li>
              <li onclick="localStorage.clear();window.location.href='/main/index';"><i class="fa fa-refresh"></i> Cache legen</li>
              <li onclick="window.location.href='/main/debug?ju=<?php echo $user_id; ?>';"><i class="fa fa-bug"></i>Debugger</li>
            </ul>
          <?php } ?>

      </div>
    <div id="subnav">
      <h4>Instellingen</h4>

      <h5>Notificaties</h5>
      <?php if(isset($_SESSION['isAndroid']) && $_SESSION['isAndroid']){ ?>
        <ul>
          <li>
            <label for="notifications">Notificaties ontvangen</label>
            <input id="notifications" type="checkbox" checked="checked" onchange="Android.setSetting('notifications', this.checked ? '1' : '0');$('notifications-vibrate').disabled=this.checked?'':'disabled';$('notifications-sound').disabled=this.checked?'':'disabled';"><span onclick="$('notifications').click();" class="checkbox"></span>
          </li>
          <li>
            <label for="notifications-sound">Geluid toestaan</label>
            <input id="notifications-sound" type="checkbox" checked="checked" onchange="Android.setSetting('sound', this.checked ? '1' : '0');"><span class="checkbox" onclick="$('notifications-sound').click();"></span>
          </li>
          <li>
            <label for="notifications-vibrate">Trillen toestaan</label>
            <input id="notifications-vibrate" type="checkbox" checked="checked" onchange="Android.setSetting('vibrate', this.checked ? '1' : '0');"><span class="checkbox" onclick="$('notifications-vibrate').click();"></span>
          </li>
        </ul>
      <?php } ?>
      <?php  if(isset($_SESSION['isIos']) && $_SESSION['isIos']){ ?>
        <ul>
          <li>
            <label for="notifications">Notificaties ontvangen</label>
            <input id="notifications" type="checkbox" checked="checked" onchange="iOS.setSetting('notifications', this.checked ? '1' : '0');$('notifications-vibrate').disabled=this.checked?'':'disabled';$('notifications-sound').disabled=this.checked?'':'disabled';"><span onclick="$('notifications').click();" class="checkbox"></span>
          </li>
          <li>
            <label for="notifications-sound">Geluid toestaan</label>
            <input id="notifications-sound" type="checkbox" checked="checked" onchange="iOS.setSetting('sound', this.checked ? '1' : '0');"><span class="checkbox" onclick="$('notifications-sound').click();"></span>
          </li>
          <li>
            <label for="notifications-vibrate">Trillen toestaan</label>
            <input id="notifications-vibrate" type="checkbox" checked="checked" onchange="iOS.setSetting('vibrate', this.checked ? '1' : '0');"><span class="checkbox" onclick="$('notifications-vibrate').click();"></span>
          </li>
        </ul>
      <?php } ?>
    </div>
  </div>
</div>
<script type="text/javascript">
  function openSubmenu()
  {
    $('subnav').addClassName('available');
    $('mainnav').removeClassName('active');
    $('subnav').addClassName('active');
    $('nav-back').style.visibility = 'visible';

    inToggleSidebar = true;
    /*setTimeout(function() { inToggleSidebar = false; }, 700);*/
  }

  function closeSubmenu()
  {
    if($('subnav').hasClassName('active')) {
      $('subnav').removeClassName('available');
      $('mainnav').addClassName('active');
      $('subnav').removeClassName('active');
      $('nav-back').style.visibility = 'hidden';

      inToggleSidebar = true;
      setTimeout(function() { inToggleSidebar = false; }, 700);
    }
    else {
      inToggleSidebar = false;
    }
  }
</script>
