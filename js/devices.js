CRM.$(function ($) {
    // $("a.add-device").css('background','black');

    $("a.add-device").click(function (event) {
        event.preventDefault();
        var href = $(this).attr('href');
        alert(href);
        var $el = CRM.loadForm(href, {
            dialog: {width: '50%', height: '50%'}
        }).on('crmFormSuccess', function () {
            var hm_tab = $('.selector-devices');
            var hm_table = hm_tab.DataTable();
            hm_table.draw();
        });
    });



    $(document).ready(function () {

        var devices_sourceUrl = CRM.vars.source_url['device_sourceUrl'];
        //Reset Table, add Filter and Search Possibility
        //devices datatable
        var devices_tab = CRM.$('.selector-devices');
        var devices_table = devices_tab.DataTable();
        var devices_dtsettings = devices_table.settings().init();
        devices_dtsettings.bFilter = true;
        //turn on search
        devices_dtsettings.fnDrawCallback = function (oSettings) {
            // $("a.add-device").css('background','red');
            CRM.$("a.add-device").click(function (event) {
                event.preventDefault();
                var href = $(this).attr('href');
                // alert(href);
                var $el = CRM.loadForm(href, {
                    dialog: {width: '50%', height: '50%'}
                }).on('crmFormSuccess', function () {
                    var hm_tab = $('.selector-devices');
                    var hm_table = hm_tab.DataTable();
                    hm_table.draw();
                });
            });
        };
        devices_dtsettings.fnServerData = function (sSource, aoData, fnCallback) {
            aoData.push({
                "name": "device_type_id",
                "value": $('#device_device_type_id').val()
            });
            aoData.push({
                "name": "type_id",
                "value": $('#device_type_id').val()
            });
            aoData.push({
                "name": "contact_id",
                "value": $('#contact_id').val()
            });
            aoData.push({
                "name": "device_name",
                "value": $('#device_name').val()
            });
            $.ajax({
                "dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data": aoData,
                "success": fnCallback
            });
        };
        devices_dtsettings.sDom = '<"crm-datatable-pager-top"lp>Brt<"crm-datatable-pager-bottom"ip>';
        //turn of search field
        devices_dtsettings.sAjaxSource = devices_sourceUrl;
        devices_dtsettings.Buttons = ["csv", "pdf", "copy"];


        devices_table.destroy();
        var new_devices_table = devices_tab.DataTable(devices_dtsettings);
        //End Reset Table

        $('.device-filter :input').change(function () {
            // devices_table.destroy();
            // new_devices_table.destroy();
            // new_devices_table = devices_tab.DataTable(devices_dtsettings);
            alert(JSON.stringify(new_devices_table.settings().init()));
            new_devices_table.draw();
        });
        $('#device_name').keyup(function () {
            // devices_table.destroy();
            // new_devices_table.destroy();
            // new_devices_table = devices_tab.DataTable(devices_dtsettings);
            new_devices_table.draw();
        });

    });


});