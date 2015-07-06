var inToggleSidebar = false;
var back_id = 1;
var back_nested_id = null;
var internal_order_counter = 0;

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

    Event.observe($('workorder-collapse-btn'), 'click', function() {
        if ($(this).hasClassName('fa-caret-down')) {
            $(this).removeClassName('fa-caret-down');
            $(this).addClassName('fa-caret-up');
            Effect.BlindDown('workorder-details', { duration: 0.3 });
        }
        else {
            $(this).addClassName('fa-caret-down');
            $(this).removeClassName('fa-caret-up');
            Effect.BlindUp('workorder-details', { duration: 0.3 });
        }
    });

    Event.observe($('new-workorder'), 'click', function() {
        Workorder.createWorkorder();
    });

    Event.observe($('date-prev-app'), 'click', function() {
        today = new Date();
        current = new Date(current_date);
        yesterday = new Date(current_date);
        yesterday.setDate(current.getDate() - 1);

        dd = yesterday.getDate()+'-'+(yesterday.getMonth()+1)+'-'+yesterday.getFullYear();
        ds = today.getDate()+'-'+(today.getMonth()+1)+'-'+today.getFullYear();
        if (dd == ds) {
            $('date-current-app').innerHTML = 'Vandaag';
        }
        else {
            $('date-current-app').innerHTML = dd;
        }

        xd = yesterday.getDate();
        if(xd<10){xd='0'+xd}
        xm = yesterday.getMonth() + 1;
        if(xm<10){xm='0'+xm}

        str = yesterday.getFullYear()+'-'+xm+'-'+xd;
        current_date = str;
        Workorder.loadAppointmentForDate(current_date);
    });

    Event.observe($('date-next-app'), 'click', function() {
        today = new Date();
        current = new Date(current_date);
        tommorow = new Date(current_date);
        tommorow.setDate(current.getDate() + 1);

        dd = tommorow.getDate()+'-'+(tommorow.getMonth()+1)+'-'+tommorow.getFullYear();
        ds = today.getDate()+'-'+(today.getMonth()+1)+'-'+today.getFullYear();
        if (dd == ds) {
            $('date-current-app').innerHTML = 'Vandaag';
        }
        else {
            $('date-current-app').innerHTML = dd;
        }

        xd = tommorow.getDate();
        if(xd<10){xd='0'+xd}
        xm = tommorow.getMonth() + 1;
        if(xm<10){xm='0'+xm}

        str = tommorow.getFullYear()+'-'+xm+'-'+xd;
        current_date = str;
        Workorder.loadAppointmentForDate(current_date);
    });

    $$('.search input').each(function(s,i) {
        Event.observe($(s), 'keyup', function() {
            Workorder.search(this.id, this.value);
        });

        Event.observe($(s), 'blur', function() {
            Workorder.searchRemove();
        });
    });

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
function goPage(page_id, prev_id)
{
    Workorder.hideLoader();
    $('container').scrollTo();

    for(i=1;i<19;i++) {
        if (!$('page-'+i)) continue;
        if (page_id == i) {
            $('page-'+i).addClassName('active');
        }
        else {
            $('page-'+i).removeClassName('active');
        }
    }

    if (prev_id > 0) {
        $('back-button').show();
        $('menu-button').hide();
        back_id = prev_id;
    }
    else if (back_nested_id > 0) {
        $('back-button').show();
        $('menu-button').hide();
        back_id = back_nested_id;
        back_nested_id = null;
    }
    else {
        back_id = 1;
        $('back-button').hide();
        $('menu-button').show();
    }
}

function setActive(which)
{
    $$('#sidebar-nav li').each(function(s,i) {
        $(s).removeClassName('active-item');
    });
    $(which).addClassName('active-item');
}

function imageSelected(image)
{
    Workorder.addPhoto(image);
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

window.workorderObject = Class.create({
    workorders: [],
    appointments: [],
    apps_in_date: [],
    current_workorder: 0,
    current_row: 0,
    selectedPhoto: 0,
    tmp_workorder: {},
    shortlistItems: {},
    currentShortlist: {},
    shortlistLevel: 0,
    searchDelay: 0,

    startWork: function () {
        // store current timestamp
        var d = new Date();

        $('sn-2').addClassName('inactive');
        $('sn-2').addClassName('readable');
        $('sn-2').innerHTML = 'Gestart om '+ d.getHours() + ':'+ ('0'+d.getMinutes()).slice(-2)+ '<span class="fa fa-check"></span>';
        $('sn-7').removeClassName('inactive');

        wo = this.loadWorkorder(this.current_workorder);
        wo.startWork = d.getHours() + ':'+ d.getMinutes();

        this.setTmpWorkorder(wo);
        this.saveWorkorder();

        wo = this.loadWorkorder(this.current_workorder);

        Effect.BlindUp('workorder-details', { duration: 0.3 });

        $('workorder-collapse-btn').addClassName('fa-caret-down');
        $('workorder-collapse-btn').removeClassName('fa-caret-up');
    },

    finishWork: function () {
        var d = new Date();

        $('sn-7').addClassName('inactive');
        $('sn-7').addClassName('readable');
        $('sn-7').innerHTML = 'Afgerond om '+ d.getHours() + ':'+ ('0'+d.getMinutes()).slice(-2)+'<span class="fa fa-check"></span>';

        wo = this.loadWorkorder(this.current_workorder);
        wo.finishWork = d.getHours() + ':'+ d.getMinutes();

        timeval1 = wo.startWork.split(':');
        tv1 = (parseInt(timeval1[0])*60) + parseInt(timeval1[1]);

        timeval2 = wo.finishWork.split(':');
        tv2 = (parseInt(timeval2[0])*60) + parseInt(timeval2[1]);

        diff = tv2 - tv1;

        row = {
            type: 'hours',
            minutes: diff,
            desc: 'Arbeidstijd'
        };

        wo.rows.push(row);

        this.setTmpWorkorder(wo);
        this.saveWorkorder();

        wo = this.loadWorkorder(this.current_workorder);
    },

    startTravel: function ()
    {

    },

    finishTravel: function () {

    },

    setAppointments: function (appointments)
    {
        this.appointments = appointments;
    },

    loadAppointmentForDate: function(date)
    {
        this.showLoader();
        new Ajax.Request('/main/loadAppointments', {
            parameters: {
                date: date
            },
            onSuccess: function(transport) {
                for ( date in transport.responseJSON) {
                    for (app_id in transport.responseJSON[date]) {
                        Workorder.appointments[app_id] = transport.responseJSON[date][app_id];

                        if (!Workorder.apps_in_date[date]) {
                            Workorder.apps_in_date[date] = [];
                        }
                        $(Workorder.apps_in_date[date]).push(app_id);
                    }
                }
                Workorder.renderAppointmentsForDate(date);
                Workorder.hideLoader();
            },
            onFailure: function()
            {
                Workorder.hideLoader();
            }
        });
    },

    showLoader: function() {
        $('overlay').addClassName('popup');
    },

    hideLoader: function() {
        $('overlay').removeClassName('popup');
    },

    renderAppointmentsForDate: function(date)
    {
        $('appointment-list').innerHTML = '';

        $(this.apps_in_date[date]).each(function(s, i) {
            app = $(Workorder.appointments[s]);
            li = new Element('li');
            li.id = 'app-'+s;
            Event.observe(li, 'click', function() {
                Workorder.loadAppointment(this.id.substr(4));
                goPage(3, 2);
            });
            li.innerHTML = app.orderrows[0]+'<br>'+app.time;

            if(app.customer!='') {
                span = new Element('span');
                span.innerHTML = app.customer;
                li.insert(span);
                if (app.address!='') {
                    span = new Element('span');
                    span.innerHTML = app.address+'<br>'+app.zipcode+' '+app.city;
                    li.insert(span);
                }
                if (app.phone!='') {
                    span = new Element('span');
                    span.innerHTML = app.phone;
                    li.insert(span);
                }
                if (app.email!='') {
                    span = new Element('span');
                    span.innerHTML = app.email;
                    li.insert(span);
                }
            }
            i = new Element('i');
            i.addClassName('fa');
            i.addClassName('fa-chevron-right');
            li.insert(i);

            $('appointment-list').insert(li);
        });
    },

    /*

     <li onclick="Workorder.loadAppointment(<?php echo $appointment['Id']; ?>);goPage(3,2);">
     <?php echo $appointment['Name']; ?><br>
     <?php echo date('H:i', strtotime($appointment['StartTime'])); ?>
     - <?php echo date('H:i', strtotime($appointment['FinishTime'])); ?>
     <?php if ($consumer) {

     ?>
     <span><?php echo $consumer['FirstName']; ?> <?php echo $consumer['LastName']; ?></span>
     <?php if ($consumer['Street']) { ?><span><?php echo $consumer['Street']; ?> <?php echo $consumer['HouseNr']; ?><?php echo $consumer['HouseNrAddition']; ?>
     <br>
     <?php echo $consumer['ZipCode']; ?> <?php echo $consumer['City']; ?></span><?php } ?>
     <?php if ($consumer['MobilePhone']) { ?><span><?php echo $consumer['MobilePhone']; ?></span><?php } ?>
     <?php if ($consumer['Phone']) { ?><span><?php echo $consumer['Phone']; ?>
     </span><?php } ?>
     <?php if ($consumer['Email']) { ?><span><?php echo $consumer['Email']; ?>
     </span><?php } ?>
     <?php } ?>
     <i class="fa fa-chevron-right"></i>
     </li>

     */
    loadAppointment: function (appointment_id) {
        if(this.appointments[appointment_id]) {
            app = this.appointments[appointment_id];

            if(!this.workorders[appointment_id]) {
                wo = {
                    app: app,
                    startWork: null,
                    finishWork: null,
                    startTravel: null,
                    finishTravel: null,
                    remarks: '',
                    rows: [
                        /*{
                            type: 'activity',
                            cost: '9,95',
                            desc: 'Test activity'
                        },
                        {
                            type: 'product',
                            cost: '24,95',
                            vat: 21,
                            desc: 'Test product'
                        }*/
                    ],
                    photos: [],
                    signature: null,
                    payment: {}
                };

                this.setWorkorder(wo, appointment_id);
            }
            this.loadWorkorder(appointment_id);

            return this.appointments[appointment_id];
        }
        else {
            // clear the workorder form
            return null;
        }
    },

    loadWorkorder: function(workorder_id) {

        if (this.workorders[workorder_id]) {
            this.tmp_workorder = this.workorders[workorder_id];
            this.current_workorder = workorder_id;

            app = this.tmp_workorder.app;

            if (app['address']) {
                $('address').value = app['address'];
                $('address').removeClassName('empty');
            }
            if (app['phone']) {
                $('phone').value = app['phone'];
                $('phone').removeClassName('empty');
            }
            if (app['city']) {
                $('city').value = app['city'];
                $('city').removeClassName('empty');
            }
            if (app['zipcode']) {
                $('zipcode').value = app['zipcode'];
                $('zipcode').removeClassName('empty');
            }
            if (app['customer']) {
                $('customer').value = app['customer'];
                $('customer').removeClassName('empty');
            }
            if (app['debitor']) {
                $('debitor').value = app['debitor'];
                $('debitor').removeClassName('empty');
            }
            if (app['contact']) {
                $('contact').value = app['contact'];
                $('contact').removeClassName('empty');
            }
            if (app['workorder']) {
                $('workorder').value = app['workorder'];
                $('workorder').removeClassName('empty');
            }
            if (app['email']) {
                $('email').value = app['email'];
                $('email').removeClassName('empty');
            }

            if (this.tmp_workorder.startWork) {
                $('sn-2').addClassName('inactive');
                $('sn-2').addClassName('readable');
                $('sn-2').innerHTML = 'Gestart om '+ this.tmp_workorder.startWork+'<span class="fa fa-check"></span>';
                if (this.tmp_workorder.finishWork) {
                    $('sn-7').addClassName('inactive');
                    $('sn-7').addClassName('readable');
                    $('sn-3').removeClassName('inactive');
                    $('sn-4').removeClassName('inactive');
                    $('sn-8').removeClassName('inactive');
                }
                else {
                    $('sn-7').addClassName('active');
                    $('sn-7').removeClassName('inactive');
                }
            }
            else {
                $('sn-2').removeClassName('inactive');
                $('sn-2').innerHTML = 'Werkzaamheden starten';
                $('sn-3').addClassName('inactive');
                $('sn-4').addClassName('inactive');
                $('sn-5').addClassName('inactive');
                $('sn-6').addClassName('inactive');
                $('sn-7').addClassName('inactive');
                $('sn-8').addClassName('inactive');
            }

            return this.tmp_workorder;
        }
        return null;
    },

    setReady: function(ready)
    {
      // todo: set marked as ready
        console.log('Mark as ready');
    },

    finalizeWorkorder: function()
    {
        $('sn-6').removeClassName('inactive');
        $('sn-8').addClassName('readable');

        wo = this.getTmpWorkorder();
        wo.remarks = $('remarks').value;
        this.setTmpWorkorder(wo);
        this.saveWorkorder();
        $('remarks-summary').innerHTML = wo.remarks;
        goPage(5,3);
    },

    createWorkorder: function() {
        internal_order_counter++;
        str = "" + internal_order_counter
        pad = "0000000"
        workorder = pad.substring(0, pad.length - str.length) + str;

        app = {
            id: internal_order_counter,
            workorder: 'WO-M'+workorder,
            address: '',
            zipcode: '',
            city: '',
            contact: '',
            customer: '',
            debitor: '',
            email: '',
            phone: '',
            time: '',
            orderrows: {
                0: 'Handmatige werkbon'
            }
        };

        wo = {
            app: app,
            startWork: null,
            finishWork: null,
            startTravel: null,
            finishTravel: null,
            rows: [

            ],
            photos: [],
            signature: null,
            payment: {}
        };

        this.appointments[internal_order_counter] = app;
        this.setWorkorder(wo, internal_order_counter);
        this.loadWorkorder(internal_order_counter);
        goPage(3,2);
    },

    saveWorkorder: function() {
        this.workorders[this.current_workorder] = this.tmp_workorder;
    },

    setWorkorder: function(workorder, workorder_id) {
        this.workorders[workorder_id] = workorder;
        this.tmp_workorder = workorder;
    },

    getWorkorder: function()
    {
        return this.workorders[this.current_workorder];

    },

    getTmpWorkorder: function()
    {
        return this.tmp_workorder;

    },

    setTmpWorkorder: function(workorder) {
        this.tmp_workorder = workorder;
    },

    showOrderrows: function()
    {
        wo = this.getTmpWorkorder();
        if(wo.rows.length > 0) {
            $('no-orderrows').hide();
            $('orderrows').show();
            $('orderrows').innerHTML = '';
            $(wo.rows).each(function(s,i) {
                var li = new Element('li');
                li.innerHTML = s.desc + '<br>';
                li.id = 'row-cnt-'+i;
                li.addClassName('row-type-'+ s.type);
                switch(s.type) {
                    case 'activity':
                      if  (s.cost != '0,00')
                        {
                            var span = new Element('span');
                            span.innerHTML = '&euro; ' + parseFloat(s.cost).toFixed(2).replace('.', ',');
                            li.insert(span);
                        }
                        break;
                    case 'hours':
                        var span = new Element('span');
                        span.innerHTML = s.minutes+'m';
                        li.insert(span);

                        break;
                    case 'product':
                        if  (s.cost != '0,00' && s.cost != '')
                        {
                            var span = new Element('span');
                            span.innerHTML = s.amount+' x &euro; ' + parseFloat(s.cost).toFixed(2).replace('.', ',');
                            li.insert(span);
                        }
                        break;
                }
                var btn1 = new Element('button');
                btn1.innerHTML = 'Bewerken';
                Event.observe(btn1, 'click', function() {
                    row = $(this).parentNode.id.substr(8);
                    wo = Workorder.getTmpWorkorder();
                    r = wo.rows[row];
                    switch(r.type) {
                        case 'product':
                            Workorder.editProduct(r, row);
                            break;
                        case 'activity':
                            Workorder.editActivity(r, row);
                            break;
                        case 'hours':
                            Workorder.editHours(r, row);
                            break;
                    }
                });
                li.insert(btn1);

                var btn2 = new Element('button');
                btn2.innerHTML = 'Verwijderen';
                Event.observe(btn2, 'click', function() {
                    row = $(this).parentNode.id.substr(8);
                    wo = Workorder.getTmpWorkorder();
                    wo.rows.splice(row,1);
                    Workorder.setTmpWorkorder(wo);
                    Workorder.showOrderrows();

                });
                li.insert(btn2);

                Event.observe(li, 'click', function() {
                    $$('#orderrows li button').each(function(s, i) {
                       $(s).hide(); // hide all buttons, also of other rows
                    });
                    $$('#orderrows #row-cnt-'+this.id.substr(8)+' button').each(function(s, i) {
                        $(s).show(); // show all buttons, only for this row
                    });

                });
                $('orderrows').insert(li);
            });

            $$('#orderrows li button').each(function(s, i) {
                $(s).hide(); // hide all buttons, also of other rows
            });

            $('workorder-summary').innerHTML = $('orderrows').innerHTML;
            $('invoice-summary').innerHTML = $('orderrows').innerHTML;
            $('check-summary').innerHTML = $('orderrows').innerHTML;
        }
        else {
            $('no-orderrows').show();
            $('orderrows').hide();
        }


    },

    checkWorkorder: function()
    {
        wo = this.getTmpWorkorder();
        $('remarks').innerHTML = wo.remarks;
        goPage(18, 3);
    },

    updateWorkorderCount: function()
    {
        s = 0;
        for (k in this.workorders) {
            if (this.workorders.hasOwnProperty(k)) s++;
        }
        $('workorder-count').innerHTML = s;
    },

    addQuicklist: function()
    {
        this.loadQuicklist(0);

        goPage(17,12);
        back_nested_id = 3;
    },

    loadQuicklist: function(parent) {
        this.shortlistLevel = 0;
        this.currentShortlist = this.shortlistItems;

        this.renderCurrentShortlist();

    },

    renderCurrentShortlist: function()
    {
        $('shortlist-picker').innerHTML = '';

        $(this.currentShortlist).each(function(s, i) {

            li = new Element('li');
            li.innerHTML = s.title;

            li.id = 'shortlist-item-'+Workorder.shortlistLevel+'-'+i;

            Event.observe(li, 'click', function() {
                m = this.id.substr(15);
                p = m.split('-');
                item = Workorder.currentShortlist[p[1]];
                if (item.price) {
                    Workorder.addQuicklistRow(item.title, item.price);
                }
                else {
                    Workorder.currentShortlist = item.items;
                    Workorder.shortlistLevel++;
                    Workorder.renderCurrentShortlist();
                }
            });

            $('shortlist-picker').insert(li);

        });
    },

    setShortlistItems: function(items) {
        this.shortlistItems = items;
    },

    addQuicklistRow: function(which, cost)
    {
        r = {
            desc: which,
            cost: cost,
            type: 'activity'
        }
        wo = this.getTmpWorkorder();
        wo.rows.push(r);

        this.setTmpWorkorder(wo);
        goPage(12, 3);
        this.showOrderrows();
    },

    addActivity: function()
    {
        goPage(13,12);
        back_nested_id = 3;

        $('activityrowdesc').value = 'Omschrijving';
        $('activityrowdesc').addClassName('empty');
        $('activityrowcost').value = '0,00';
        $('activityrowcost').addClassName('empty');

        $('activity-add-btn').show();
        $('activity-save-btn').hide();
    },

    editActivity: function(v, r) {
        $('activityrowdesc').value = v.desc;
        $('activityrowdesc').removeClassName('empty');
        $('activityrowcost').value = v.cost;
        $('activityrowcost').removeClassName('empty');

        $('activity-add-btn').hide();
        $('activity-save-btn').show();

        this.current_row = r;

        goPage(13,12);
        back_nested_id = 3;
    },

    addActivityRow: function()
    {
        this.saveActivityRow(true);
    },

    saveActivityRow: function(add)
    {
        desc = $('activityrowdesc').value;
        cost = $('activityrowcost').value;
        if(desc.length < 2 || desc == 'Omschrijving') {
            toast('Omschrijving is te kort.');
        }
        else if (!isMoney(cost)) {
            toast('Kosten is niet juist ingevoerd.');
        }
        else {
            r = {
                desc: desc,
                cost: cost,
                type: 'activity'
            }
            wo = this.getTmpWorkorder();
            if (add) {
                wo.rows.push(r);
            }
            else {
                wo.rows[this.current_row] = r;
            }
            this.setTmpWorkorder(wo);
            goPage(12, 3);
            this.showOrderrows();
        }
    },

    addHours: function()
    {
        goPage(14,12);
        back_nested_id = 3;

        $('hoursrowdesc').value = 'Omschrijving';
        $('hoursrowdesc').addClassName('empty');
        $('hoursrowminutes').value = '0';
        $('hoursrowminutes').addClassName('empty');

        $('hours-add-btn').show();
        $('hours-save-btn').hide();
    },

    editHours: function(v, r) {
        $('hoursrowdesc').value = v.desc;
        $('hoursrowdesc').removeClassName('empty');
        $('hoursrowminutes').value = v.minutes;
        $('hoursrowminutes').removeClassName('empty');

        $('hours-add-btn').hide();
        $('hours-save-btn').show();

        this.current_row = r;

        goPage(14,12);
        back_nested_id = 3;
    },

    addHoursRow: function()
    {
        this.saveHoursRow(true);
    },

    saveHoursRow: function(add)
    {
        desc = $('hoursrowdesc').value;
        minutes = $('hoursrowminutes').value;
        if(desc.length < 2 || desc == 'Omschrijving') {
            toast('Omschrijving is te kort.');
        }
        else if (isNaN(minutes)) {
            toast('Minuten is niet juist ingevoerd.');
        }
        else {
            r = {
                desc: desc,
                minutes: minutes,
                type: 'hours'
            }
            wo = this.getTmpWorkorder();
            if (add) {
                wo.rows.push(r);
            }
            else {
                wo.rows[this.current_row] = r;
            }
            this.setTmpWorkorder(wo);
            goPage(12, 3);
            this.showOrderrows();
        }
    },

    addProduct: function()
    {
        $('productrowdesc').value = 'Omschrijving';
        $('productrowdesc').addClassName('empty');
        $('productrowcost').value = '0,00';
        $('productrowcost').addClassName('empty');
        $('productrowvat').value = '21';
        $('productrowvat').addClassName('empty');
        $('productrowamount').value = '1';
        $('productrowamount').addClassName('empty');
        goPage(15,12);
        back_nested_id = 3;

        $('product-add-btn').show();
        $('product-save-btn').hide();
    },

    editProduct: function(v, r) {
        $('productrowdesc').value = v.desc;
        $('productrowdesc').removeClassName('empty');
        $('productrowcost').value = v.cost;
        $('productrowcost').removeClassName('empty');
        $('productrowvat').value = v.vat;
        $('productrowvat').removeClassName('empty');
        $('productrowamount').value = v.amount;
        $('productrowamount').removeClassName('empty');

        $('product-add-btn').hide();
        $('product-save-btn').show();

        this.current_row = r;

        goPage(15,12);
        back_nested_id = 3;
    },

    addProductRow: function()
    {
        this.saveProductRow(true);
    },

    saveProductRow: function(add)
    {
        desc = $('productrowdesc').value;
        cost = $('productrowcost').value;
        vat = $('productrowvat').value;
        amount = $('productrowamount').value;
        if(desc.length < 2 || desc == 'Omschrijving') {
            toast('Omschrijving is te kort.');
        }
        else if (!isMoney(cost)) {
            toast('Kosten is niet juist ingevoerd.');
        }
        else if (!isVAT(vat)) {
            toast('BTW is niet juist ingevoerd.');
        }
        else {
            r = {
                desc: desc,
                cost: cost,
                vat: vat,
                amount: amount,
                type: 'product'
            }
            wo = this.getTmpWorkorder();
            if (add) {
                wo.rows.push(r);
            }
            else {
                wo.rows[this.current_row] = r;
            }
            this.setTmpWorkorder(wo);
            goPage(12, 3);
            this.showOrderrows();
        }
    },

    // saves the current workorder form into tmp_workorder
    saveWorkorderForm: function()
    {
        this.tmp_workorder.app.address = $('address').value;
        this.tmp_workorder.app.phone = $('phone').value;
        this.tmp_workorder.app.city = $('city').value;
        this.tmp_workorder.app.zipcode = $('zipcode').value;
        this.tmp_workorder.app.customer = $('customer').value;
        this.tmp_workorder.app.debitor = $('debitor').value;
        this.tmp_workorder.app.contact = $('contact').value;
        this.tmp_workorder.app.workorder = $('workorder').value;
        this.tmp_workorder.app.email = $('email').value;

        this.setWorkorder(this.tmp_workorder, this.current_workorder);

        s = 0;
        for (k in this.workorders) {
            if (this.workorders.hasOwnProperty(k)) s++;
        }
        $('workorder-count').innerHTML = s;

        toast('Wijzigingen opgeslagen.');
        Workorder.showWorkorders();
        goPage(16);
    },

    saveWorkorderRows: function()
    {
        this.setWorkorder(this.tmp_workorder, this.current_workorder);
        $('sn-3').addClassName('active');
        toast('Wijzigingen opgeslagen.');
    },

    saveSignature: function(image) {
        wo = this.getTmpWorkorder();
        wo.signature = image;
        this.setTmpWorkorder(wo);
        this.saveWorkorder();
        $('sn-5').removeClassName('inactive');
        $('sn-6').addClassName('inactive');
        $('sn-6').addClassName('readable');
        $('sn-3').addClassName('inactive');
        goPage(3);
    },

    addPhoto: function(image) {
        wo = this.getTmpWorkorder();
        wo.photos.push(image);
        this.setTmpWorkorder(wo);
        this.renderPhotos();
    },

    renderPhotos: function() {
        wo = this.getTmpWorkorder();
        $('images').innerHTML = '';
        $(wo.photos).each(function(s,i) {
            var img = new Element('img', { src: 'data:image/jpg;base64,'+s });
            var li = new Element('li');
            li.id = 'photo-upload-'+i;
            li.insert(img);
            Event.observe(li, 'click', function() {
                $$('#images li').each(function(s,i) {
                    if ($(s).hasClassName('selected')) {
                        $(s).removeClassName('selected');
                    }
                });
                $(this).addClassName('selected');
                Workorder.selectedPhoto = li.id.substr(13);
                $('photo-delete').show();
            });

                Event.observe(li, 'blur', function() {
                    $(this).setAttribute('style', 'border: none;');
                    $('photo-delete').hide();
                });
            $('images').insert(li);
        });
        if (wo.photos.length > 0 ) {
            $('no-photos').hide();
        }
        else {
            $('no-photos').show();
        }
        $('photo-delete').hide();
        Event.observe($('photo-delete'), 'click', function() {
            wo = Workorder.getTmpWorkorder();
            removed = wo.photos.splice(Workorder.selectedPhoto, 1);
            Workorder.setTmpWorkorder(wo);
            Workorder.renderPhotos();
            $('photo-delete').hide();
        });
    },



    savePhotoForm: function()
    {
        wo = this.getTmpWorkorder();
        cnt = wo.photos.length;
        if(cnt > 0) {
            $('sn-4').addClassName('active');
        }
        $('photo-count').innerHTML = cnt;
        this.saveWorkorder();
        goPage(3);
    },

    showWorkorders: function()
    {
        $('workorder-list').innerHTML = '';
        s = 0;
        for (k in this.workorders) {
            if (this.workorders.hasOwnProperty(k)) s++;
        }
        if (s > 0) {

            $(this.workorders).each(function (s, i) {
                var li = new Element('li');
                li.innerHTML = s.app.orderrows[0] + '<br>' + s.app.workorder + '<br>' + s.app.time + '<i class="fa fa-chevron-right"></i>';
                if (s.finished) {
                    li.addClassName('finished');
                }
                eval("Event.observe(li, 'click', function() { Workorder.loadWorkorder("+ s.app.id + ");goPage(3,16); });");

                $('workorder-list').insert(li);
            });
        }
        else {
            var li = new Element('li');
            li.innerHTML = 'Er zijn geen werkbonnen gevonden.';
            li.setAttribute('style', 'height:auto;');
            $('workorder-list').insert(li);
        }
    },

    calculateInvoice: function()
    {
        $('invoice-summary').innerHTML = $('workorder-summary').innerHTML;
    },

    startPayment: function(paymethod)
    {
        /*
         app: app,
         startWork: null,
         finishWork: null,
         startTravel: null,
         finishTravel: null,
         rows: [

        ],
        photos: [],
            signature: null,
        payment: {}
         */
        this.showLoader();
        var wo = this.getWorkorder();
        new Ajax.Request('/main/save', {
            parameters: {
                app: Object.toJSON(wo.app),
                startWork: wo.startWork,
                finishWork: wo.finishWork,
                startTravel: wo.startTravel,
                finishTravel: wo.finishTravel,
                remarks: wo.remarks,
                rows: Object.toJSON(wo.rows),
                photos: Object.toJSON(wo.photos),
                signature: wo.signature,
                payment: Object.toJSON(wo.payment)
            },
            onSuccess: function (transport) {
                if(transport.responseText == 'OK') {
                    wo.finished = true;
                    Workorder.setWorkorder(wo, Workorder.current_workorder);
                    Workorder.showWorkorders();
                    goPage(16);
                }
            }
        });

    },

    search: function(field, value)
    {
        this.searchDelay++;
        this.searchField = field;
        this.searchValue = value;

        setTimeout(this.searchDo, 250);
    },

    searchDo: function() {
        Workorder.searchDelay--;
        if (Workorder.searchDelay <= 0) {
            new Ajax.Request('/main/search', {
                parameters: {
                    field: Workorder.searchField,
                    value: Workorder.searchValue
                },
                onSuccess: function(transport)
                {
                    Workorder.searchResults = transport.responseJSON;

                    div = new Element('div');
                    div.addClassName('search-result');
                    var ul = new Element('ul');
                    $(transport.responseJSON).each(function(result, i) {
                        var li = new Element('li');
                        li.id = 'result-'+i;
                        li.innerHTML = result.title;
                        ul.insert(li);
                        Event.observe(li, 'click', function(event) {
                            for(i in Workorder.searchResults[this.id.substr(7)]['fields']) {
                                $(i).value = Workorder.searchResults[this.id.substr(7)]['fields'][i];
                            }

                            Element.remove($(this).parentNode.parentNode);
                        });
                    });
                    div.insert(ul);
                    $(Workorder.searchField).parentNode.appendChild(div);

                }
            });
        }
    },

    searchRemove: function()
    {
        setTimeout(function() {
            divs = $$('.search .search-result');
            if (divs) {
                $(divs).each(function(div) {
                    Element.remove(div);
                });
            }
        }, 200);
    }
});

var Workorder = new workorderObject;


Event.observe(window, 'load', function() {
var smart_inputs = [];
$$('.smart-input').each(function(s,i) {
    default_value = $(s).value;
    smart_inputs[$(s).id] = default_value;
    Event.observe($(s), 'focus' , function() {
        if ($(this).hasClassName('empty')) {
            $(this).removeClassName('empty');
            $(this).value = '';
        }
    });

    Event.observe($(s), 'blur' , function() {
        if ($(this).value == '') {
            $(this).addClassName('empty');
            $(this).value = smart_inputs[$(this).id];
        }
    });
});
});