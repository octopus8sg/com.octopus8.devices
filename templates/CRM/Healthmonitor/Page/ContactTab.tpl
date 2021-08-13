{crmScope extensionKey='healthmonitor'}
        <div class="healthmonitoring-devices-tab view-content">

            <div id="secondaryTabContainer1" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
                {include file="CRM/common/TabSelected.tpl" defaultTab="data" tabContainer="#secondaryTabContainer1"}

                <ul class="ui-tabs-nav ui-corner-all ui-helper-reset ui-helper-clearfix ui-widget-header">
                    <li id="tab_data1" class="crm-tab-button ui-corner-all ui-tabs-tab ui-corner-top ui-state-default ui-tab ui-tabs-active ui-state-active">
                        <a href="#data-subtab1" title="{ts}Data{/ts}">
                            {ts}Data{/ts} <em>{$dataCount}</em>
                        </a>
                    </li>
                    <li id="tab_devices1" class="crm-tab-button ui-corner-all ui-tabs-tab ui-corner-top ui-state-default ui-tab">
                        <a href="#devices-subtab1" title="{ts}Devices{/ts}">
                            {ts}Devices{/ts} <em>{$deviceCount}</em>
                        </a>
                    </li>
                    <li id="tab_analytics1" class="crm-tab-button ui-corner-all ui-tabs-tab ui-corner-top ui-state-default ui-tab">
                        <a href="#analytics-subtab1" title="{ts}Analytics{/ts}">
                            {ts}Analytics{/ts} <em>{$analyticsCount}</em>
                        </a>
                    </li>
                    <li id="tab_alerts1" class="crm-tab-button ui-corner-all ui-tabs-tab ui-corner-top ui-state-default ui-tab">
                        <a href="#alerts-subtab1" title="{ts}Alerts{/ts}">
                            {ts}Alerts{/ts} <em>{$alertCount}</em>
                        </a>
                    </li>
                </ul>

                <div id="data-subtab1" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
                    {include file="CRM/Healthmonitor/Page/Tabs/Data.tpl"}
                </div>
                <div id="devices-subtab1" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
                    {include file="CRM/Healthmonitor/Page/Tabs/Devices.tpl"}
                </div>
                <div id="analytics-subtab1" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
                    {include file="CRM/Healthmonitor/Page/Tabs/Analytics.tpl"}
                </div>
                <div id="alerts-subtab1" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
                4
                </div>
                <div class="clear"></div>
            </div>
        </div>

{/crmScope}
{literal}
<script type="text/javascript">
    (function ($, _) {
        var data_sourceUrl = {/literal}"{$data_sourceUrl}"{literal};
        var devices_sourceUrl = {/literal}"{$devices_sourceUrl}"{literal};

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
                aoData.push({ "name": "dateselect_from", "value": $('#dateselect_from').val() });
                aoData.push({ "name": "dateselect_to", "value": $('#dateselect_to').val() });
                aoData.push({ "name": "device_type_id", "value": $('#device_type_id').val() });
                aoData.push({ "name": "sensor_id", "value": $('#sensor_id').val() });
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

            //devices datatable
            var devices_tab = $('.selector-devices');
            var devices_table = devices_tab.DataTable();
            var devices_dtsettings = devices_table.settings().init();
            devices_dtsettings.bFilter = true;
            //turn on search

            devices_dtsettings.sDom = '<"crm-datatable-pager-top"lp>rt<"crm-datatable-pager-bottom"ip>';
            //turn of search field
            devices_dtsettings.sAjaxSource = devices_sourceUrl;
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


    })(CRM.$, CRM._);


</script>
{/literal}

