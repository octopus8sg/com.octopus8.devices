CRM.$(function ($) {
    var alarm_sourceUrl = CRM.vars.source_url['alarm_sourceUrl'];
    // var alarm_sourceUrl = "";

    $(document).ready(function () {
        //Reset Table, add Filter and Search Possibility
        //alarmrules datatable
        var alarm_tab = $('.selector-alarm');
        var alarm_table = alarm_tab.DataTable();
        var alarm_dtsettings = alarm_table.settings().init();
        alarm_dtsettings.bFilter = true;
        //turn on search

        alarm_dtsettings.sDom = '<"crm-datatable-pager-top"lp>Brt<"crm-datatable-pager-bottom"ip>';
        //turn of search field
        alarm_dtsettings.sAjaxSource = alarm_sourceUrl;
        alarm_dtsettings.Buttons = ["csv", "pdf", "copy"];
        alarm_dtsettings.fnInitComplete = function (oSettings, json) {
            // $("a.view-device").css('background','red');
            // $("a.view-device").click(function (event) {
            //     event.preventDefault();
            //     var href = $(this).attr('href');
            //     // alert(href);
            //     var $el = CRM.loadForm(href, {
            //         dialog: {width: '50%', height: '50%'}
            //     }).on('crmFormSuccess', function () {
            //         var hm_tab = $('.selector-devices');
            //         var hm_table = hm_tab.DataTable();
            //         hm_table.draw();
            //     });
            // });
            // // $("a.update-device").css('background','blue');
            // $("a.update-device").click(function (event) {
            //     event.preventDefault();
            //     var href = $(this).attr('href');
            //     // alert(href);
            //     var $el = CRM.loadForm(href, {
            //         dialog: {width: '50%', height: '50%'}
            //     }).on('crmFormSuccess', function () {
            //         var hm_tab = $('.selector-devices');
            //         var hm_table = hm_tab.DataTable();
            //         hm_table.draw();
            //     });
            // });
        };
        alarm_dtsettings.fnDrawCallback = function (oSettings) {
            // $("a.view-device").css('background','red');
            $("a.view-alarm").click(function (event) {
                event.preventDefault();
                var href = $(this).attr('href');
                // alert(href);
                var $el = CRM.loadForm(href, {
                    dialog: {width: '50%', height: '50%'}
                }).on('crmFormSuccess', function () {
                    var hm_tab = $('.selector-alarm');
                    var hm_table = hm_tab.DataTable();
                    hm_table.draw();
                });
            });
            // $("a.update-device").css('background','blue');
            $("a.update-alarm").click(function (event) {
                event.preventDefault();
                var href = $(this).attr('href');
                // alert(href);
                var $el = CRM.loadForm(href, {
                    dialog: {width: '50%', height: '50%'}
                }).on('crmFormSuccess', function () {
                    var hm_tab = $('.selector-alarm');
                    var hm_table = hm_tab.DataTable();
                    hm_table.draw();
                });
            });
            $("a.delete-alarm").click(function (event) {
                event.preventDefault();
                var href = $(this).attr('href');
                // alert(href);
                var $el = CRM.loadForm(href, {
                    dialog: {width: '50%', height: '50%'}
                }).on('crmFormSuccess', function () {
                    var hm_tab = $('.selector-alarm');
                    var hm_table = hm_tab.DataTable();
                    hm_table.draw();
                });
            });
        };
        alarm_dtsettings.fnServerData = function ( sSource, aoData, fnCallback ) {
            aoData.push({ "name": "alarm_id",
                "value": $('#alarm_id').val() });
            aoData.push({ "name": "contact_id",
                "value": $('#alarm_contact_id').val() });
            aoData.push({ "name": "sensor_id",
                "value": $('#alarm_sensor_id').val() });
            aoData.push({ "name": "dateselect_relative",
                "value": $('#alarm_dateselect_relative').val() });
            aoData.push({ "name": "dateselect_from",
                "value": $('#alarm_dateselect_from').val() });
            aoData.push({ "name": "dateselect_to",
                "value": $('#alarm_dateselect_to').val() });
            $.ajax( {
                "dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data": aoData,
                "success": fnCallback
            });
        };
        alarm_table.destroy();
        var new_alarm_table = alarm_tab.DataTable(alarm_dtsettings);
        new_alarm_table.draw();
        //End Reset Table
        $('.alarm-filter :input').change(function(){
            new_alarm_table.draw();
        });

    });


});