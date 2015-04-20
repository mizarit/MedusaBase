function alertName(person)
{
  alert(person.name);
}

function handleiOSNotifications()
{
  var hasNotifications = iOS.getSetting('notifications');
  hasNotifications = !hasNotifications;
  $('btn-iOS-notifications').style.background = hasNotifications ? '#f79035' : '#cccccc';
  iOS.setSetting('notifications', hasNotifications);
}

function handleiOSSound()
{
  var hasSound = iOS.getSetting('sound');
  hasSound = !hasSound;
  $('btn-iOS-sound').style.background = hasSound ? '#f79035' : '#cccccc';
  iOS.setSetting('sound', hasSound);
}

function handleiOSVibrate()
{
  var hasVibrate = iOS.getSetting('vibrate');
  hasVibrate = !hasVibrate;
  $('btn-iOS-vibrate').style.background = hasVibrate ? '#f79035' : '#cccccc';
  iOS.setSetting('vibrate', hasVibrate);
}

var sendToApp = function(_key, _val) {
  var iframe = document.createElement("IFRAME"); 
  iframe.setAttribute("src", _key + ":##sendToApp##" + _val); 
  document.documentElement.appendChild(iframe); 
  iframe.parentNode.removeChild(iframe); 
  iframe = null; 
}; 

var returnVal = '';
function returnValue(val)
{
  returnVal = val;
}

var log = function(_mssg){
   sendToApp("ios-log", _mssg);
};

window.iOSWrapper = Class.create({
  getSetting: function(key)
  {
    sendToApp("getsetting", key);
    
    ret = false;
    if(returnVal!='') {
      ret = returnVal == "YES";
    }
    
    return ret;
  },
  
  setSetting: function(key)
  {
    sendToApp("setsetting", key);
  },
  
  beep: function()
  {
    sendToApp("beep");
  },
  
  vibrate: function(duration)
  {
    sendToApp("vibrate", duration);
  },
  
  showToast: function(toast)
  {
    sendToApp("toast", toast);
  }
});

var iOS = new iOSWrapper;
