CRM.$(function ($) {

        $("a.add-alert-rule").click(function( event ) {
            event.preventDefault();
            var href = $(this).attr('href');
            // alert(href);
            var $el = CRM.loadForm(href, {
                dialog: {width: '50%', height: '50%'}
            }).on('crmFormSuccess', function() {
                var hm_tab = $('.selector-alertrules');
                var hm_table = hm_tab.DataTable();
                hm_table.draw();
            });
        });


        var alertrules_sourceUrl = CRM.vars.source_url['alertrules_sourceUrl'];
        // alert(alertrules_sourceUrl);
        // var alertrules_sourceUrl = "";
    $(document).ready(function () {
    // $("a.alert-rules-subtab").click(function (event) {
        //Reset Table, add Filter and Search Possibility
        //alertrules datatable
        var alertrules_tab = $('.selector-alertrules');
        var alertrules_table = alertrules_tab.DataTable();
        var alertrules_dtsettings = alertrules_table.settings().init();
        alertrules_dtsettings.bFilter = true;
        //turn on search

        // alertrules_dtsettings.sDom = '<"crm-datatable-pager-top"lp>Brt<"crm-datatable-pager-bottom"ip>';
        //turn of search field
        alertrules_dtsettings.sAjaxSource = alertrules_sourceUrl;
        // alertrules_dtsettings.Buttons = ["csv", "pdf", "copy"];
        // alertrules_dtsettings.fnInitComplete = function (oSettings, json) {
        //     // $("a.view-device").css('background','red');
        //     // $("a.view-device").click(function (event) {
        //     //     event.preventDefault();
        //     //     var href = $(this).attr('href');
        //     //     // alert(href);
        //     //     var $el = CRM.loadForm(href, {
        //     //         dialog: {width: '50%', height: '50%'}
        //     //     }).on('crmFormSuccess', function () {
        //     //         var hm_tab = $('.selector-devices');
        //     //         var hm_table = hm_tab.DataTable();
        //     //         hm_table.draw();
        //     //     });
        //     // });
        //     // // $("a.update-device").css('background','blue');
        //     // $("a.update-device").click(function (event) {
        //     //     event.preventDefault();
        //     //     var href = $(this).attr('href');
        //     //     // alert(href);
        //     //     var $el = CRM.loadForm(href, {
        //     //         dialog: {width: '50%', height: '50%'}
        //     //     }).on('crmFormSuccess', function () {
        //     //         var hm_tab = $('.selector-devices');
        //     //         var hm_table = hm_tab.DataTable();
        //     //         hm_table.draw();
        //     //     });
        //     // });
        // };
        alertrules_dtsettings.fnDrawCallback = function (oSettings) {
            // $("a.view-device").css('background','red');
            $("a.view-alert-rule").click(function (event) {
                event.preventDefault();
                var href = $(this).attr('href');
                // alert(href);
                var $el = CRM.loadForm(href, {
                    dialog: {width: '50%', height: '50%'}
                }).on('crmFormSuccess', function () {
                    var hm_tab = $('.selector-alertrules');
                    var hm_table = hm_tab.DataTable();
                    hm_table.draw();
                });
            });
            // $("a.update-device").css('background','blue');
            $("a.update-alert-rule").click(function (event) {
                event.preventDefault();
                var href = $(this).attr('href');
                // alert(href);
                var $el = CRM.loadForm(href, {
                    dialog: {width: '50%', height: '50%'}
                }).on('crmFormSuccess', function () {
                    var hm_tab = $('.selector-alertrules');
                    var hm_table = hm_tab.DataTable();
                    hm_table.draw();
                });
            });
            $("a.delete-alert-rule").click(function (event) {
                event.preventDefault();
                var href = $(this).attr('href');
                // alert(href);
                var $el = CRM.loadForm(href, {
                    dialog: {width: '50%', height: '50%'}
                }).on('crmFormSuccess', function () {
                    var hm_tab = $('.selector-alertrules');
                    var hm_table = hm_tab.DataTable();
                    hm_table.draw();
                });
            });
        };
        alertrules_dtsettings.fnServerData = function ( sSource, aoData, fnCallback ) {
            aoData.push({ "name": "alert_rule_id",
                "value": $('#alert_rule_id').val() });
            aoData.push({ "name": "contact_id",
                "value": $('#alert_rule_contact_id').val() });
            aoData.push({ "name": "sensor_id",
                "value": $('#alert_rule_sensor_id').val() });
            aoData.push({ "name": "alert_rule_addressee_id",
                "value": $('#alert_rule_addressee_id').val() });
            aoData.push({ "name": "alert_rule_type",
                "value": $('#alert_rule_type').val() });
            $.ajax( {
                "dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data": aoData,
                "success": fnCallback
            });
        };
        alertrules_table.destroy();
        var new_alertrules_table = alertrules_tab.DataTable(alertrules_dtsettings);
        new_alertrules_table.draw();
        //End Reset Table
        $('.alertrule-filter :input').change(function(){
            new_alertrules_table.draw();
        });

    });


});