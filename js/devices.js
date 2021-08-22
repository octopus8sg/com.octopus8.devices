CRM.$(function ($) {
    // var devices_sourceUrl = CRM.vars.sourceUrl['device_sourceUrl'];
    var devices_sourceUrl = CRM.vars.source_url['device_sourceUrl'];

    $(document).ready(function () {
        //Reset Table, add Filter and Search Possibility
        //devices datatable
        var devices_tab = $('.selector-devices');
        var devices_table = devices_tab.DataTable();
        var devices_dtsettings = devices_table.settings().init();
        devices_dtsettings.bFilter = true;
        //turn on search

        devices_dtsettings.sDom = '<"crm-datatable-pager-top"lp>Brt<"crm-datatable-pager-bottom"ip>';
        //turn of search field
        devices_dtsettings.sAjaxSource = devices_sourceUrl;
        devices_dtsettings.Buttons = ["csv", "pdf", "copy"];
        devices_dtsettings.fnServerData = function ( sSource, aoData, fnCallback ) {
            aoData.push({ "name": "device_type_id", "value": $('#device_device_type_id').val() });
            $.ajax( {
                "dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data": aoData,
                "success": fnCallback
            });
        };
        devices_table.destroy();
        var new_devices_table = devices_tab.DataTable(devices_dtsettings);
        //End Reset Table
        $('.device-filter :input').change(function(){
            new_devices_table.draw();
        });

    });


});