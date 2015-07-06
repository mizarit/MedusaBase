function update(what)
{
    alert(what);
}

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

var consumer_li;

function addContact(firstName, lastName)
{
    consumer_li = new Element('li');
    consumer_li.innerHTML = firstName+' '+lastName;
    $('consumer-list').insert(consumer_li);
}

function addPhone(phoneNumber)
{
    consumer_li.insert({bottom: '<span><i class="fa fa-phone"></i> '+phoneNumber+'</span>'});
}

function addEmail(email)
{
    consumer_li.insert({bottom: '<span><i class="fa fa-envelope"></i> <a href="mailto:'+email+'">'+email+'</a></span>'});
}

function addAddress(street, zipCode, city, country)
{
    consumer_li.insert({bottom: '<span><i class="fa fa-home"></i> '+street+'<br><i style="margin-left:1.2em;"></i> '+zipCode+' '+city+' '+country+'</span>'});
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

function checkJS()
{
    return true;
}