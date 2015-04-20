var inToggleSidebar = false;

function toggleSidebar(which, force)
{
    if (inToggleSidebar && !force) return;

    inToggleSidebar = true;
    setTimeout(function() { inToggleSidebar = false; }, 700);

    if (which =='sidebar-left' && $('sidebar-right').hasClassName('active')) {
        $('sidebar-right').removeClassName('active');
    }
    if (which =='sidebar-right' && $('sidebar-left').hasClassName('active')) {
        $('sidebar-left').removeClassName('active');
    }
    if ($(which).hasClassName('active')) {
        $(which).removeClassName('active');
    }
    else {
        $(which+'-inner').scrollTop = 0;
        $(which).addClassName('active');
    }

    if (which =='sidebar-right') {
        refreshChat(null, true);
        //$('chat-count').style.display = 'none';
    }
    //alert(which);
}

function clearSidebars()
{
    //$('sidebar-left').removeClassName('active');
    //$('sidebar-right').removeClassName('active');
}

function redirect(uri) {
    if(navigator.userAgent.match(/Android/i))
        document.location=uri;
    else
        window.location.replace(uri);
}

Event.observe(window, 'load', function() {

    if(isAndroid) {
        var hasSound = Android.getSetting('sound')=="1";
        var hasVibrate = Android.getSetting('vibrate')=="1";
        var hasNotifications = Android.getSetting('notifications')=="1";
        $('notifications').checked = hasNotifications ? 'checked' : '';
        $('notifications-vibrate').checked = hasVibrate ? 'checked' : '';
        $('notifications-sound').checked = hasSound ? 'checked' : '';
        $('notifications-vibrate').disabled = hasNotifications ? '' : 'disabled';
        $('notifications-sound').disabled = hasNotifications ? '' : 'disabled';
    }

    if(isIos) {
        var iOS = new iOSWrapper;
        var hasSound = iOS.getSetting('sound')=="1";
        var hasVibrate = iOS.getSetting('vibrate')=="1";
        var hasNotifications = iOS.getSetting('notifications')=="1";
        $('notifications').checked = hasNotifications ? 'checked' : '';
        $('notifications-vibrate').checked = hasVibrate ? 'checked' : '';
        $('notifications-sound').checked = hasSound ? 'checked' : '';
        $('notifications-vibrate').disabled = hasNotifications ? '' : 'disabled';
        $('notifications-sound').disabled = hasNotifications ? '' : 'disabled';
    }

    var swipeMain = $('body');
    var swipeMainObj = new Swipeable(swipeMain);

    var w = $('body').getWidth();

    // menu left
    swipeMain.observe("swipe:right", function () {
        p = swipeMainObj.lastStartX / (w / 100);

        if (p < 20) {
            if ($('sidebar-right').hasClassName('active')) {
                toggleSidebar('sidebar-right');
            }
            else if (!$('sidebar-left').hasClassName('active')) {
                toggleSidebar('sidebar-left');
            }
        }
    });

    if ($('sidebar-left')) {
        var swipeSidebarLeft = $('sidebar-left');
        var swipeSidebarLeftObj = new Swipeable(swipeSidebarLeft);
        swipeSidebarLeft.observe("swipe:left", function () {
            p = swipeSidebarLeftObj.lastStartX / (w / 100);
            if (p > 80) {
                if ($('sidebar-left').hasClassName('active')) {
                    if (!inChat) {
                        toggleSidebar('sidebar-left');
                    }
                    inChat = false;
                }
            }
        });
    }

    var inChat = false;

     // menu right
     swipeMain.observe("swipe:left",function() {
         p = swipeMainObj.lastStartX / (w /100);

         if (p > 80) {
             if( $('sidebar-left').hasClassName('active')) {
                toggleSidebar('sidebar-left');
             }
             else if ( !$('sidebar-right').hasClassName('active')) {
                toggleSidebar('sidebar-right');
             }
         }
     });


     if($('sidebar-right')) {
         var swipeSidebarRight = $('sidebar-right');
         var swipeSidebarRightObj = new Swipeable(swipeSidebarRight);
         swipeSidebarRight.observe("swipe:right", function () {
             p = swipeSidebarRightObj.lastStartX / (w / 100);
             if (p < 20) {
                 if ($('sidebar-right').hasClassName('active')) {
                     if (!inChat) {
                         toggleSidebar('sidebar-right');
                     }
                     inChat = false;
                 }
             }
         });
     }

    Event.observe($('chat-enter'), 'click', function() {
        inChat = true;
        sendChat();
    });
    Event.observe($('chat-enter'), 'touchstart', function() {
        inChat = true;
        sendChat();
    });

    if($('overlay')) {
        renderDataset();
    }

    setTimeout(function() {
        loadDataset();
    }, 30000);

    //toggleSidebar('sidebar-left');
    //goPage(4);
    refreshChat();
});

function sendChat()
{
    if ($('chat-text').value != '') {
        refreshChat($('chat-text').value);
        $('chat-text').value = '';
    }
}

function refreshChat(new_chat, read)
{
    new Ajax.Request('/main/groupchat?ju='+user_id, {
        parameters: {
            chat: new_chat,
            read: read
        },
        onSuccess: function(transport) {
            $('chat-stream').innerHTML = transport.responseJSON.html;
            if (transport.responseJSON.count > 0) {
                $('chat-count-value').innerHTML = transport.responseJSON.count;
                $('chat-count').style.display = 'block';
            }
            else {
                $('chat-count').style.display = 'none';
            }

        }
    });
    setTimeout(refreshChat, 15000);
}
function loadDataset()
{
    new Ajax.Request('/main/index?ju='+user_id, {
        onSuccess: function(transport) {

            renderDataset();
        }
    });

    setTimeout(function() {
        loadDataset();
    }, 30000);
}

function renderDataset()
{

}
function goPage(page_id, team_id)
{
    $('container').scrollTo();

    for(i=1;i<11;i++) {
        if (page_id == i) {
            $('page-'+i).addClassName('active');
        }
        else {
            $('page-'+i).removeClassName('active');
        }
    }

    if (page_id==1) {
        //$('back-button').hide();
        //$('menu-button').show();
    }
    else {
        //$('back-button').show();
        //$('menu-button').hide();
    }
}

function setActive(which)
{
    $$('#sidebar-nav li').each(function(s,i) {
        $(s).removeClassName('active-item');
    });
    $(which).addClassName('active-item');
}




