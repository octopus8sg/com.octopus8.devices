CRM.$(function ($) {
    // var alert_sourceUrl = "";
    $(document).ready(function () {
        var alert_sourceUrl = CRM.vars.source_url['alerts_source_url'];
        //Reset Table, add Filter and Search Possibility
        //alertrules datatable
        var alert_tab = $('.selector-alert');
        var alert_table = alert_tab.DataTable();
        var alert_dtsettings = alert_table.settings().init();
        alert_dtsettings.bFilter = true;
        //turn on search

        alert_dtsettings.sDom = '<"crm-datatable-pager-top"lp>rt<"crm-datatable-pager-bottom"ip>';
        //turn of search field
        alert_dtsettings.sAjaxSource = alert_sourceUrl;
        alert_dtsettings.fnInitComplete = function (oSettings, json) {
        };
        alert_dtsettings.fnDrawCallback = function (oSettings) {
            // $("a.view-device").css('background','red');
            $("a.view-alert").click(function (event) {
                event.preventDefault();
                var href = $(this).attr('href');
                // alert(href);
                var $el = CRM.loadForm(href, {
                    dialog: {width: '50%', height: '50%'}
                }).on('crmFormSuccess', function () {
                    var hm_tab = $('.selector-alert');
                    var hm_table = hm_tab.DataTable();
                    hm_table.draw();
                });
            });
            // $("a.update-device").css('background','blue');
            $("a.edit-alert").click(function (event) {
                event.preventDefault();
                var href = $(this).attr('href');
                // alert(href);
                var $el = CRM.loadForm(href, {
                    dialog: {width: '50%', height: '50%'}
                }).on('crmFormSuccess', function () {
                    var hm_tab = $('.selector-alert');
                    var hm_table = hm_tab.DataTable();
                    hm_table.draw();
                });
            });
            $("a.delete-alert").click(function (event) {
                event.preventDefault();
                var href = $(this).attr('href');
                // alert(href);
                var $el = CRM.loadForm(href, {
                    dialog: {width: '50%', height: '50%'}
                }).on('crmFormSuccess', function () {
                    var hm_tab = $('.selector-alert');
                    var hm_table = hm_tab.DataTable();
                    hm_table.draw();
                });
            });
        };
        alert_dtsettings.fnServerData = function ( sSource, aoData, fnCallback ) {
            aoData.push({ "name": "alert_id",
                "value": $('#alert_id').val() });
            aoData.push({ "name": "contact_id",
                "value": $('#alert_contact_id').val() });
            aoData.push({ "name": "sensor_id",
                "value": $('#alert_sensor_id').val() });
            aoData.push({ "name": "addressee_id",
                "value": $('#alert_addressee_id').val() });
            aoData.push({ "name": "alert_rule_type",
                "value": $('#alert_alert_rule_type').val() });
            aoData.push({ "name": "dateselect_from",
                "value": $('#alert_dateselect_from').val() });
            aoData.push({ "name": "dateselect_to",
                "value": $('#alert_dateselect_to').val() });
            $.ajax( {
                "dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data": aoData,
                "success": fnCallback
            });
        };
        alert_table.destroy();
        var new_alert_table = alert_tab.DataTable(alert_dtsettings);
        new_alert_table.draw();
        //End Reset Table
        $('.alert-filter :input').change(function(){
            new_alert_table.draw();
        });

    });
});