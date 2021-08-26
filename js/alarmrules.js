CRM.$(function ($) {
    var alarmrules_sourceUrl = CRM.vars.source_url['alarm_rules_sourceUrl'];
    // var alarmrules_sourceUrl = "";

    $(document).ready(function () {
        //Reset Table, add Filter and Search Possibility
        //alarmrules datatable
        var alarmrules_tab = $('.selector-alarmrules');
        var alarmrules_table = alarmrules_tab.DataTable();
        var alarmrules_dtsettings = alarmrules_table.settings().init();
        alarmrules_dtsettings.bFilter = true;
        //turn on search

        alarmrules_dtsettings.sDom = '<"crm-datatable-pager-top"lp>Brt<"crm-datatable-pager-bottom"ip>';
        //turn of search field
        alarmrules_dtsettings.sAjaxSource = alarmrules_sourceUrl;
        alarmrules_dtsettings.Buttons = ["csv", "pdf", "copy"];
        alarmrules_dtsettings.fnServerData = function ( sSource, aoData, fnCallback ) {
            aoData.push({ "name": "alarm_rule_sensor_id", "value": $('#alarm_rule_sensor_id').val() });
            aoData.push({ "name": "alarm_rule_addressee_id", "value": $('#alarm_rule_addressee_id').val() });
            aoData.push({ "name": "alarm_rule_civicrm", "value": $('#alarm_rule_civicrm').is(":checked") });
            aoData.push({ "name": "alarm_rule_email", "value": $('#alarm_rule_email').is(":checked") });
            aoData.push({ "name": "alarm_rule_telegram", "value": $('#alarm_rule_telegram').is(":checked") });
            aoData.push({ "name": "alarm_rule_api", "value": $('#alarm_rule_api').is(":checked") });
            $.ajax( {
                "dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data": aoData,
                "success": fnCallback
            });
        };
        alarmrules_table.destroy();
        var new_alarmrules_table = alarmrules_tab.DataTable(alarmrules_dtsettings);
        new_alarmrules_table.draw();
        //End Reset Table
        $('.alarmrule-filter :input').change(function(){
            new_alarmrules_table.draw();
        });

    });


});