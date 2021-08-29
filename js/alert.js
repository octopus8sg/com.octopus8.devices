CRM.$(function ($) {
    var alert_sourceUrl = CRM.vars.source_url['alert_sourceUrl'];
    // var alert_sourceUrl = "";

    $(document).ready(function () {
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
        alert_dtsettings.fnServerData = function ( sSource, aoData, fnCallback ) {
            aoData.push({ "name": "alert_sensor_id", "value": $('#alert_sensor_id').val() });
            aoData.push({ "name": "alert_addressee_id", "value": $('#alert_addressee_id').val() });
            aoData.push({ "name": "alert_civicrm", "value": $('#alert_civicrm').is(":checked") });
            aoData.push({ "name": "alert_email", "value": $('#alert_email').is(":checked") });
            aoData.push({ "name": "alert_dateselect_from", "value": $('#alert_dateselect_from').val() });
            aoData.push({ "name": "alert_dateselect_to", "value": $('#alert_dateselect_to').val() });
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