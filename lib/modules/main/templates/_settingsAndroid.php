<div id="page-4" style="padding:0 1em;">
    <h2>Instellingen</h2>
  <input id="notifications" type="checkbox" onchange="Android.setSetting('notifications', this.checked ? '1' : '0');$('notifications-vibrate').disabled=this.checked?'':'disabled';$('notifications-sound').disabled=this.checked?'':'disabled';">
  <label class="checkbox" for="notifications" style="margin-bottom:0.4em;"> Notificaties ontvangen</label><br>

  <div style="padding-left:2em;">
    <input id="notifications-vibrate" type="checkbox" checked="checked" onchange="Android.setSetting('vibrate', this.checked ? '1' : '0');">
    <label class="checkbox" for="notifications-vibrate" style="margin-bottom:0.4em;"> Trillen toestaan</label><br>

    <input id="notifications-sound" type="checkbox" checked="checked" onchange="Android.setSetting('sound', this.checked ? '1' : '0');">
    <label class="checkbox" for="notifications-sound" style="margin-bottom:0.4em;"> Geluid toestaan</label>
  </div>
</div>
<script type="text/javascript">
Event.observe(window, 'load', function() {
  $('notifications').checked = (Android.getSetting('notifications') == "1");
  $('notifications-vibrate').checked = (Android.getSetting('vibrate') == "1");
  $('notifications-sound').checked = (Android.getSetting('sound') == "1");
  if (Android.getSetting('notifications') == "0") {
    $('notifications-vibrate').disabled = 'disabled';
    $('notifications-sound').disabled = 'disabled';
  }
});
</script>