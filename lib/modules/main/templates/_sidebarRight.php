<div id="sidebar-right" class="sidebar">
  <div id="sidebar-right-inner" class="sidebar-inner" style="overflow:scroll;">

    <div style="position: relative;width:98%;" id="chat-input">
      <i class="fa fa-remove" style="position: absolute;right:<?php echo $iOS? '-0.9em':'0'; ?>;top:0;border:none;font-size:1.5em;" onclick="toggleSidebar('sidebar-right');"></i>
      <form action="#" method="post" onsubmit="sendChat();return false;">
        <input id="chat-text" autocomplete="off" type="text" style="margin:2em 0 0 0;width:100%;font-size:1.2em;padding:0.3em 0.2em;border-radius:0.3em;">
        <i id="chat-enter" style="position:absolute;width:auto;right:0;left:auto;float:none;display:inline;top:1.7em;font-size: 1.6em;color:#aaa;" class="fa fa-caret-square-o-down"></i>
        <button type="submit" style="display:none;"></button>
      </form>
    </div>
    <div id="chat-stream">
      <ul>
      </ul>
    </div>
  </div>
</div>