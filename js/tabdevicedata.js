CRM.$(function ($) {

    var devices_sourceUrl = CRM.vars.source_url['data_sourceUrl'];

    $(document).ready(function () {
        //Reset Table, add Filter and Search Possibility
        //devices datatable
        var devices_tab = $('.selector-devicedata');
        var devices_table = devices_tab.DataTable();
        var devices_dtsettings = devices_table.settings().init();
        devices_dtsettings.bFilter = true;
        //turn on search

        devices_dtsettings.sDom = '<"crm-datatable-pager-top"lp>Brt<"crm-datatable-pager-bottom"ip>';
        //turn of search field
        devices_dtsettings.sAjaxSource = devices_sourceUrl;
        devices_dtsettings.fnInitComplete = function (oSettings, json) {
        };
        devices_dtsettings.fnDrawCallback = function (oSettings) {
            // $("a.view-device").css('background','red');
            $("a.view-devicedata").click(function (event) {
                event.preventDefault();
                var href = $(this).attr('href');
                // alert(href);
                var $el = CRM.loadForm(href, {
                    dialog: {width: '50%', height: '50%'}
                }).on('crmFormSuccess', function () {
                    var hm_tab = $('.selector-devicedata');
                    var hm_table = hm_tab.DataTable();
                    hm_table.draw();
                });
            });
            // $("a.update-device").css('background','blue');
            $("a.edit-devicedata").click(function (event) {
                event.preventDefault();
                var href = $(this).attr('href');
                // alert(href);
                var $el = CRM.loadForm(href, {
                    dialog: {width: '50%', height: '50%'}
                }).on('crmFormSuccess', function () {
                    var hm_tab = $('.selector-devicedata');
                    var hm_table = hm_tab.DataTable();
                    hm_table.draw();
                });
            });
            $("a.delete-devicedata").click(function (event) {
                event.preventDefault();
                var href = $(this).attr('href');
                // alert(href);
                var $el = CRM.loadForm(href, {
                    dialog: {width: '50%', height: '50%'}
                }).on('crmFormSuccess', function () {
                    var hm_tab = $('.selector-devicedata');
                    var hm_table = hm_tab.DataTable();
                    hm_table.draw();
                });
            });
        };
        devices_dtsettings.fnServerData = function ( sSource, aoData, fnCallback ) {
            aoData.push({ "name": "device_data_id",
                "value": $('#device_data_id').val() });
            aoData.push({ "name": "device_type_id",
                "value": $('#device_data_device_type_id').val() });
            aoData.push({ "name": "device_id",
                "value": $('#device_data_device_id').val() });
            aoData.push({ "name": "contact_id",
                "value": $('#device_data_contact_id').val() });
            aoData.push({ "name": "sensor_id",
                "value": $('#device_data_sensor_id').val() });
            aoData.push({ "name": "dateselect_from",
                "value": $('#device_data_dateselect_from').val() });
            aoData.push({ "name": "dateselect_to",
                "value": $('#device_data_dateselect_to').val() });

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
        $('.devicedata-filter :input').change(function(){
            new_devices_table.draw();
        });

    });


});