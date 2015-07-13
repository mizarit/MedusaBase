var inToggleSidebar = false;

function toggleSidebar(which, force)
{
    if (inToggleSidebar && !force) return;

    if (which == 'sidebar-right') return;

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

    if (which =='sidebar-left') {
        Workorder.updateWorkorderCount();
    }
    //alert(which);
}

function clearSidebars()
{
    //$('sidebar-left').removeClassName('active');
    //$('sidebar-right').removeClassName('active');
}

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

Event.observe(window, 'load', function() {
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

    refreshChat();

});