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
    <ul>
      <li><i class="fa fa-user"></i> <?php echo $user->firstName; ?> <?php echo $user->lastName; ?>
        <?php if ($iOS) { ?>
          <i class="fa fa-remove" style="position: absolute;right:0;" onclick="toggleSidebar('sidebar-left');"></i>
        <?php } ?>

      </li>
    </ul>
        <?php if($user->device=='android'){ ?>
            <ul>
            <li onclick="goPage(4);toggleSidebar('sidebar-left');"><i class="fa fa-cogs"></i> Instellingen</li>
            </ul>
        <?php } ?>
    <ul>
      <li>
        <div style="position: relative;width:95%;" id="chat-input">
          <form action="#" method="post" onsubmit="sendChat();return false;">
            <input id="chat-text" autocomplete="off" type="text" style="margin:0;width:100%;font-size:1.2em;padding:0.3em 0.2em;border-radius:0.3em;">
            <i id="chat-enter" style="position:absolute;width:auto;right:0;left:auto;float:none;display:inline;top:0.25em;font-size: 1.6em;color:#aaa;" class="fa fa-caret-square-o-down"></i>
            <button type="submit" style="display:none;"></button>
          </form>
        </div>
      </li>
      <li style="height: auto;">
        <div id="chat-stream">
          <ul>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</div>
