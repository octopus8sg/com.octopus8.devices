
CRM.$(function ($) {
    var data_sourceUrl = CRM.vars.source_url['data_sourceUrl'];

    $(document).ready(function () {
        //Reset Table, add Filter and Search Possibility
        var hm_tab = $('.selector-data');
        var hm_table = hm_tab.DataTable();
        var hm_dtsettings = hm_table.settings().init();
        hm_dtsettings.bFilter = true;
        //turn on search

        hm_dtsettings.sDom = '<"crm-datatable-pager-top"lp>rt<"crm-datatable-pager-bottom"ip>';
        //turn of search field
        hm_dtsettings.sAjaxSource = data_sourceUrl;
        hm_dtsettings.fnServerData = function ( sSource, aoData, fnCallback ) {
            aoData.push({ "name": "dateselect_from", "value": $('#data_dateselect_from').val() });
            aoData.push({ "name": "dateselect_to", "value": $('#data_dateselect_to').val() });
            aoData.push({ "name": "device_type_id", "value": $('#data_device_type_id').val() });
            aoData.push({ "name": "sensor_id", "value": $('#data_sensor_id').val() });
            $.ajax( {
                "dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data": aoData,
                "success": fnCallback
            });
        };
        hm_table.destroy();

        var new_hm_table = hm_tab.DataTable(hm_dtsettings);

        //End Reset Table
        $('.healthmonitor-filter :input').change(function(){
            new_hm_table.draw();
        });
    });


});