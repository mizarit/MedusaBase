<div id="sidebar-right" class="sidebar">
  <div id="sidebar-right-inner" class="sidebar-inner">
    <h3 id="chat-title">Chat<i class="fa fa-close" id="chat-close" onclick="toggleSidebar('sidebar-right');"></i></h3>
    <div id="chat-stream">
      <ul>
      </ul>
    </div>
    <div id="chat-form">
      <form action="#" method="post" onsubmit="sendChat();return false;">
        <input id="chat-text" autocomplete="off" type="text" value="">
        <button id="chat-enter" type="submit">stuur</button>
      </form>
    </div>
  </div>
</div>