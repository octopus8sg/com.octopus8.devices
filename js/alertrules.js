CRM.$(function ($) {
    var alertrules_sourceUrl = CRM.vars.source_url['alert_rules_sourceUrl'];
    // var alertrules_sourceUrl = "";

    $(document).ready(function () {
        //Reset Table, add Filter and Search Possibility
        //alertrules datatable
        var alertrules_tab = $('.selector-alertrules');
        var alertrules_table = alertrules_tab.DataTable();
        var alertrules_dtsettings = alertrules_table.settings().init();
        alertrules_dtsettings.bFilter = true;
        //turn on search

        alertrules_dtsettings.sDom = '<"crm-datatable-pager-top"lp>Brt<"crm-datatable-pager-bottom"ip>';
        //turn of search field
        alertrules_dtsettings.sAjaxSource = alertrules_sourceUrl;
        alertrules_dtsettings.Buttons = ["csv", "pdf", "copy"];
        alertrules_dtsettings.fnServerData = function ( sSource, aoData, fnCallback ) {
            aoData.push({ "name": "alert_rule_sensor_id", "value": $('#alert_rule_sensor_id').val() });
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