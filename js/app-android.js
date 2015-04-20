function countStep() {
    $('android-step').style.display = 'block';
    setTimeout(function() { $('android-step').style.display = 'none'; }, 500);
}

function totalSteps(steps) {
    $('android-step-counter').innerHTML = steps;
}

function toastName(person)
{
    window.Android.showToast(person.name);
}

function handleNotifications()
{
  var hasNotifications = Android.getSetting('notifications')=="1";
  hasNotifications = !hasNotifications;
  $('btn-notifications').style.background = hasNotifications ? '#f79035' : '#cccccc';
  Android.setSetting('notifications', hasNotifications ? "1" : "0");
}

function handleSound()
{
  var hasSound = Android.getSetting('sound')=="1";
  hasSound = !hasSound;
  $('btn-sound').style.background = hasSound ? '#f79035' : '#cccccc';
  Android.setSetting('sound', hasSound ? "1" : "0");
}

function handleVibrate()
{
  var hasVibrate = Android.getSetting('vibrate')=="1";
  hasVibrate = !hasVibrate;
  $('btn-vibrate').style.background = hasVibrate ? '#f79035' : '#cccccc';
  Android.setSetting('vibrate', hasVibrate ? "1" : "0");
}