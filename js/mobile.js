var internal_order_counter = 0;
var change_counter = 0;
var smart_inputs = [];

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
    cdate: '',

    initialize: function(config)
    {
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




        Event.observe($('wo-date-prev-app'), 'click', function() {
            today = new Date();
            current = new Date(current_date);
            yesterday = new Date(current_date);
            yesterday.setDate(current.getDate() - 1);

            dd = yesterday.getDate()+'-'+(yesterday.getMonth()+1)+'-'+yesterday.getFullYear();
            ds = today.getDate()+'-'+(today.getMonth()+1)+'-'+today.getFullYear();
            if (dd == ds) {
                $('wo-date-current-app').innerHTML = 'Vandaag';
                $('new-workorder').show();
            }
            else {
                $('wo-date-current-app').innerHTML = dd;
                $('new-workorder').hide();
            }

            xd = yesterday.getDate();
            if(xd<10){xd='0'+xd}
            xm = yesterday.getMonth() + 1;
            if(xm<10){xm='0'+xm}

            str = yesterday.getFullYear()+'-'+xm+'-'+xd;
            current_date = str;
            Workorder.loadWorkordersForDate(current_date);
        });

        Event.observe($('wo-date-next-app'), 'click', function() {
            today = new Date();
            current = new Date(current_date);
            tommorow = new Date(current_date);
            tommorow.setDate(current.getDate() + 1);

            dd = tommorow.getDate()+'-'+(tommorow.getMonth()+1)+'-'+tommorow.getFullYear();
            ds = today.getDate()+'-'+(today.getMonth()+1)+'-'+today.getFullYear();
            if (dd == ds) {
                $('wo-date-current-app').innerHTML = 'Vandaag';
                $('new-workorder').show();
            }
            else {
                $('wo-date-current-app').innerHTML = dd;
                $('new-workorder').hide();
            }

            xd = tommorow.getDate();
            if(xd<10){xd='0'+xd}
            xm = tommorow.getMonth() + 1;
            if(xm<10){xm='0'+xm}

            str = tommorow.getFullYear()+'-'+xm+'-'+xd;
            current_date = str;
            Workorder.loadWorkordersForDate(current_date);
        });


        $$('.search input').each(function(s,i) {
            Event.observe($(s), 'keyup', function() {
                Workorder.search(this.id, this.value);
            });

            Event.observe($(s), 'blur', function() {
                Workorder.searchRemove();
            });
        });

        $$('.smart-input').each(function(s,i) {
            default_value = $(s).value;
            smart_inputs[$(s).id] = default_value;

            Event.observe($(s), 'change' , function() {
                change_counter++;
            });

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

        this.loadLocal();


    },

    startWork: function () {
        // store current timestamp
        var d = new Date();

        $('sn-2').addClassName('inactive');
        $('sn-2').addClassName('readable');
        $('sn-2').innerHTML = 'Gestart om '+ d.getHours() + ':'+ ('0'+d.getMinutes()).slice(-2)+ '<span class="fa fa-check"></span>';
        $('sn-7').removeClassName('inactive');

        wo = this.loadWorkorder(this.current_workorder);
        wo.startWork = d.getHours() + ':'+ ('0'+d.getMinutes()).slice(-2);

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
        wo.finishWork = d.getHours() + ':'+ ('0'+d.getMinutes()).slice(-2);

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

    loadAppointmentFromLocalStorage: function(date)
    {
        apps = localStorage.getItem('apps_'+date);
        if (apps) {
            json_apps = JSON.parse(apps);

            Workorder.apps_in_date[date] = [];
            for (app_id in json_apps) {

                json_apps[app_id]['orderrows'] = JSON.parse(json_apps[app_id]['orderrows']);
                Workorder.appointments[app_id] = json_apps[app_id];

                if (!Workorder.apps_in_date[date]) {
                    Workorder.apps_in_date[date] = [];
                }
                $(Workorder.apps_in_date[date]).push(app_id);
            }

            Workorder.renderAppointmentsForDate(date);
        }

    },

    loadAppointmentsFromBackend: function(date)
    {
        this.cdate = date;
        new Ajax.Request('/main/loadAppointments', {
            parameters: {
                date: date
            },
            onSuccess: function(transport) {

                for ( date in transport.responseJSON) {
                    localStorage.setItem('apps_20'+date, JSON.stringify(transport.responseJSON[date]));
                }
                Workorder.loadAppointmentFromLocalStorage(Workorder.cdate);
                setTimeout(function() {
                    Workorder.loadAppointmentsFromBackend(Workorder.cdate);
                },300000); // 5 minutes

            },
            onFailure: function()
            {
            }
        });
    },

    loadAppointmentForDate: function(date)
    {
        this.cdate = date;
        this.loadAppointmentFromLocalStorage(date);
        this.loadAppointmentsFromBackend(date);

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

    loadAppointment: function (appointment_id) {
        if(this.appointments[appointment_id]) {
            app = this.appointments[appointment_id];

            date = new Date();
            m = date.getMonth()+1;
            if (m < 10) m = '0'+m;
            d = date.getDate();
            if (d < 10) d = '0'+d;
            wo_date = date.getFullYear()+'-'+m+'-'+d;

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
                    payment: {},
                    ready: false,
                    finished: false,
                    date: wo_date
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
                    $('sn-7').innerHTML = 'Afgerond om '+ this.tmp_workorder.finishWork+'<span class="fa fa-check"></span>';
                    $('sn-7').addClassName('inactive');
                    $('sn-7').addClassName('readable');
                    if (this.tmp_workorder.finished) {
                        $('sn-3').addClassName('inactive');
                        $('sn-8').addClassName('inactive');
                        $('sn-6').addClassName('inactive');
                        $('sn-4').removeClassName('inactive');
                    }
                    else {
                        $('sn-3').removeClassName('inactive');
                        $('sn-4').removeClassName('inactive');
                        $('sn-8').removeClassName('inactive');
                    }
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
        wo = this.getTmpWorkorder();
        wo.ready = ready;
        this.setTmpWorkorder(wo);
        this.saveWorkorder();
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

    deleteWorkorder: function()
    {
        if(confirm('Weet je zeker dat je deze werkbon wilt verwijderen?')) {
            delete this.workorders[this.current_workorder];
            this.current_workorder = null;

            this.saveLocal();
            page_stack = [16];
            goPage(16);
        }
    },

    createWorkorder: function() {
        internal_order_counter++;
        str = "" + internal_order_counter
        pad = "0000000"
        workorder = pad.substring(0, pad.length - str.length) + str;

        date = new Date();
        m = date.getMonth()+1;
        if (m < 10) m = '0'+m;
        d = date.getDate();
        if (d < 10) d = '0'+d;
        wo_date = date.getFullYear()+'-'+m+'-'+d;

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
            payment: {},
            finished: false,
            ready: false,
            date: wo_date
        };

        this.appointments[internal_order_counter] = app;
        this.setWorkorder(wo, internal_order_counter);
        this.loadWorkorder(internal_order_counter);
        goPage(3,2);
    },

    saveWorkorder: function() {
        this.workorders[this.current_workorder] = this.tmp_workorder;
        this.saveLocal();
    },

    saveLocal: function() {
        if(localStorage.getItem('workorders')) {
            workorder_ids  = [];
        }
        else {
            workorder_ids  = JSON.parse(localStorage.getItem('workorders'));
            if (!workorder_ids) {
                workorder_ids  = [];
            }
        }

        for (i in this.workorders) {
            if (this.workorders.hasOwnProperty(i)) {
                localStorage.setItem('workorder_'+i, Object.toJSON(this.workorders[i]));
                workorder_ids.push(i);
            }
        }

        localStorage.setItem('workorders', Object.toJSON(workorder_ids));
        localStorage.setItem('tmp_workorder', Object.toJSON(this.tmp_workorder));
    },

    loadLocal: function() {
        wos = localStorage.getItem('workorders');
        if (wos) {
            wo = JSON.parse(wos);
            if (wo) {
                for (i in wo) {
                    if (wo.hasOwnProperty(i)) {
                        wo_id = wo[i];
                        workorder = localStorage.getItem('workorder_' + wo_id);
                        if (workorder) {
                            this.workorders[wo_id] = JSON.parse(workorder);
                        }
                    }
                }
            }
        }
        two = JSON.parse(localStorage.getItem('tmp_workorder'));
        if (two) {
            this.tmp_workorder = two;
        }

    },

    setWorkorder: function(workorder, workorder_id) {
        this.workorders[workorder_id] = workorder;
        this.tmp_workorder = workorder;
        this.saveLocal();
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
        this.saveLocal();
    },

    showOrderrows: function()
    {
        wo = this.getTmpWorkorder();
        var total = 0;
        if(wo.rows.length > 0) {
            $('no-orderrows').hide();
            $('orderrows').show();
            $('orderrows').innerHTML = '';
            $(wo.rows).each(function(s,i) {
                var li = new Element('li');
                li.innerHTML = s.desc + '<br>';
                li.id = 'row-cnt-' + i;
                li.addClassName('row-type-' + s.type);
                switch (s.type) {
                    case 'activity':
                        if (s.cost != '0,00') {
                            var span = new Element('span');
                            span.innerHTML = '&euro; ' + parseFloat(s.cost).toFixed(2).replace('.', ',');
                            total += parseFloat(s.cost);
                            li.insert(span);
                        }
                        break;
                    case 'hours':
                        var span = new Element('span');
                        span.innerHTML = s.minutes + 'm';
                        li.insert(span);

                        break;
                    case 'product':
                        if (s.cost != '0,00' && s.cost != '') {
                            var span = new Element('span');
                            span.innerHTML = s.amount + ' x &euro; ' + parseFloat(s.cost).toFixed(2).replace('.', ',');
                            total += (s.amount * parseFloat(s.cost));
                            li.insert(span);
                        }
                        break;
                }

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

                if (!s.locked) {
                    var btn1 = new Element('button');
                    btn1.innerHTML = 'Bewerken';
                    Event.observe(btn1, 'click', function () {
                        row = $(this).parentNode.id.substr(8);
                        wo = Workorder.getTmpWorkorder();
                        r = wo.rows[row];
                        switch (r.type) {
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
                }

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

            var li = new Element('li');
            li.innerHTML = 'Totaal<br>';
            var span = new Element('span');
            span.innerHTML = '&euro; '+parseFloat(total).toFixed(2).replace('.', ',');
            li.addClassName('row-total');
            li.insert(span);
            $('workorder-summary').innerHTML = $('orderrows').innerHTML;
            $('workorder-summary').insert(li);

            $('invoice-summary').innerHTML = $('workorder-summary').innerHTML;

            $('check-summary').innerHTML = $('workorder-summary').innerHTML;
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
            if (this.workorders.hasOwnProperty(k)) {
                if(!this.workorders[k].finished) {
                    s++;
                }
            }
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
            type: 'activity',
            locked: true
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
        goPage(9, 5);
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

    loadWorkordersForDate: function(date)
    {
        $('workorder-list').innerHTML = '';
        var s = 0;
        var ddate = date;
        $(this.workorders).each(function (x, i) {
            if(x.date == ddate) {
                s++;
            }
        });
        if (s > 0) {

            $(this.workorders).each(function (s, i) {
                if (s.date != ddate) return;

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

    showWorkorders: function()
    {
        date = new Date();
        m = date.getMonth()+1;
        if (m < 10) m = '0'+m;
        d = date.getDate();
        if (d < 10) d = '0'+d;
        wo_date = date.getFullYear()+'-'+m+'-'+d;

        this.loadWorkordersForDate(wo_date);
    },

    calculateInvoice: function()
    {
        $('invoice-summary').innerHTML = $('workorder-summary').innerHTML;
    },

    startPayment: function(paymethod)
    {

        this.showLoader();
        var wo = this.getWorkorder();
        wo.payment = { paymethod: paymethod };
        this.setWorkorder(wo, this.current_workorder);
        this.setTmpWorkorder(wo);

        new Ajax.Request('/main/save', {
            parameters: {
                app: Object.toJSON(wo.app),
                startWork: wo.startWork,
                finishWork: wo.finishWork,
                startTravel: wo.startTravel,
                finishTravel: wo.finishTravel,
                remarks: wo.remarks,
                ready: wo.ready,
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
                    page_stack = [];
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

        setTimeout(this.searchDo, 500);
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
                                $(i).removeClassName('empty');
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

var Workorder;

Event.observe(window, 'load', function() {
    Workorder = new workorderObject;
});
