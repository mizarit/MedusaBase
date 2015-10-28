var back_id = 1;
var back_nested_id = null;

var page_stack = [2];

Offline.options = {checks: {xhr: {url: '/main/connectionTest'}}};

Offline.on('up', function() {
    $('connection-down').removeClassName('active');
});


Offline.on('down', function() {
    $('connection-down').addClassName('active');
});

function redirect(uri) {
    if(navigator.userAgent.match(/Android/i))
        document.location=uri;
    else
        window.location.replace(uri);
}

var bconfirm_in_loop = false;
var bconfirm_answer = false;

function bconfirm(text)
{
    if (text) {
        show_bconfirm(text);
    }
    if(!bconfirm_in_loop) {
        return bconfirm_answer;
    }
    setTimeout(bconfirm, 1000);
}

function show_bconfirm(text)
{
    bconfirm_in_loop = true;

    $('overlay').addClassName('popup');
    $('prompt').style.display = 'block';
    $('prompt').innerHTML = '';

    var div = new Element('div');
    div.innerHTML = text;

    var button2 = new Element('button');
    button2.innerHTML = 'Nee';
    div.insert(button2);
    Event.observe(button2, 'click', function() {
        bconfirm_answer = false;
        bconfirm_in_loop = false;
        $('overlay').removeClassName('popup');
        $('prompt').style.display = 'none';
    });

    var button1 = new Element('button');
    button1.innerHTML = 'Ja';
    div.insert(button1);
    Event.observe(button1, 'click', function() {
        bconfirm_answer = true;
        bconfirm_in_loop = false;
        $('overlay').removeClassName('popup');
        $('prompt').style.display = 'none';
    });

    $('prompt').insert(div);

    return bconfirm_answer;
}

function goBack()
{
    if (change_counter > 0) {
        if (!confirm('Je hebt wijzigingen gemaakt die niet zijn opgeslagen. Wil je dit formulier verlaten?')) {
            return;
        }
    }

    //Android.log('back');
    //Android.log(page_stack.join());

    current_page = page_stack.pop();
    prev = page_stack[page_stack.length - 1];
    goPage(prev);
}

function goPage(page_id) {

    change_counter = 0;

    Workorder.hideLoader();
    $('container').scrollTo();

    if (page_stack[page_stack.length - 1] != page_id) {
        page_stack.push(page_id);
    }

    //Android.log('next');
    //Android.log(page_stack.join());

    for(i=1;i<20;i++) {
        if (!$('page-'+i)) continue;
        if (page_id == i) {
            $('page-'+i).addClassName('active');
        }
        else {
            $('page-'+i).removeClassName('active');
        }
    }

    if (page_stack.length > 1) {
        // something to go back to
        $('back-button').show();
        $('menu-button').hide();
        if (isAndroid) {
            Android.setPhysicalBackCallback("goBack();");
        }
    }
    else {
        $('back-button').hide();
        $('menu-button').show();
        if (isAndroid) {
            Android.setPhysicalBackCallback("");
        }
    }

    page_titles = {
        1: 'Klanten',
        2: 'Afspraken',
        3: 'Werkbon',
        4: 'page 4',
        5: 'Digitale handtekening',
        6: 'Reistijden',
        7: 'Urenregistratie',
        8: 'Situatiefoto\'s',
        9: 'Afrekenen',
        10: 'Notities',
        11: 'page 11',
        12: 'Orderregels',
        13: 'Werkzaamheden toevoegen',
        14: 'Uren toevoegen',
        15: 'Product toevoegen',
        16: 'Werkbonnen',
        17: 'Snelkeuze',
        18: 'Controleren',
        19: 'Klant details'
    };
    $('page-title').innerHTML = page_titles[page_id];
    /*
     if (prev_id > 0) {
     $('back-button').show();
     $('menu-button').hide();
     back_id = prev_id;
     if (isAndroid) {
     Android.setPhysicalBackCallback("goPage("+back_id+");");
     }
     }
     else if (back_nested_id > 0) {
     $('back-button').show();
     $('menu-button').hide();
     back_id = back_nested_id;
     back_nested_id = null;
     if (isAndroid) {
     Android.setPhysicalBackCallback("goPage("+back_id+");");
     }
     }
     else {
     back_id = 1;
     $('back-button').hide();
     $('menu-button').show();
     if (isAndroid) {
     Android.setPhysicalBackCallback("");
     }
     }
     */

}

function setActive(which)
{
    $$('#sidebar-nav li').each(function(s,i) {
        $(s).removeClassName('active-item');
    });
    $(which).addClassName('active-item');
}

function toast(message) {
    if (isIos) {
        iOS.showToast(message);
    }
    else if (isAndroid) {
        Android.showToast(message);
    }
    else {
        alert(message);
    }
}

function isMoney(v) {
    console.log('implement isMoney');
    return true;
}

function isVAT(vat){
    if (vat != 21 && vat != 6) return false;
    return true;
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

function imageSelected(image)
{
    Workorder.addPhoto(image);
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

    if($('overlay')) {
        renderDataset();
    }

    setTimeout(function() {
        loadDataset();
    }, 30000);
});