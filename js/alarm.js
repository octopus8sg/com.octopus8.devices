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

        alarm_dtsettings.sDom = '<"crm-datatable-pager-top"lp>rt<"crm-datatable-pager-bottom"ip>';
        //turn of search field
        alarm_dtsettings.sAjaxSource = alarm_sourceUrl;
        alarm_dtsettings.fnServerData = function ( sSource, aoData, fnCallback ) {
            aoData.push({ "name": "alarm_sensor_id", "value": $('#alarm_sensor_id').val() });
            aoData.push({ "name": "alarm_addressee_id", "value": $('#alarm_addressee_id').val() });
            aoData.push({ "name": "alarm_civicrm", "value": $('#alarm_civicrm').is(":checked") });
            aoData.push({ "name": "alarm_email", "value": $('#alarm_email').is(":checked") });
            aoData.push({ "name": "alarm_dateselect_from", "value": $('#alarm_dateselect_from').val() });
            aoData.push({ "name": "alarm_dateselect_to", "value": $('#alarm_dateselect_to').val() });
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