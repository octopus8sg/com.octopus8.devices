{crmScope extensionKey='healthmonitor'}
        <div class="healthmonitoring-devices-tab view-content">

            <div id="secondaryTabContainer" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
                {include file="CRM/common/TabSelected.tpl" defaultTab="data" tabContainer="#secondaryTabContainer"}

                <ul class="ui-tabs-nav ui-corner-all ui-helper-reset ui-helper-clearfix ui-widget-header">
                    <li id="tab_data" class="crm-tab-button ui-corner-all ui-tabs-tab ui-corner-top ui-state-default ui-tab ui-tabs-active ui-state-active">
                        <a href="#data-subtab" title="{ts}Data{/ts}">
                            {ts}Data{/ts} <em>{$dataCount}</em>
                        </a>
                    </li>
                    <li id="tab_devices" class="crm-tab-button ui-corner-all ui-tabs-tab ui-corner-top ui-state-default ui-tab">
                        <a href="#devices-subtab" title="{ts}Devices{/ts}">
                            {ts}Devices{/ts} <em>{$devicesCount}</em>
                        </a>
                    </li>
                    <li id="tab_analytics" class="crm-tab-button ui-corner-all ui-tabs-tab ui-corner-top ui-state-default ui-tab">
                        <a href="#analytics-subtab" title="{ts}Analytics{/ts}">
                            {ts}Analytics{/ts} <em>{$analyticsCount}</em>
                        </a>
                    </li>
                    <li id="tab_alerts" class="crm-tab-button ui-corner-all ui-tabs-tab ui-corner-top ui-state-default ui-tab">
                        <a href="#alerts-subtab" title="{ts}Alerts{/ts}">
                            {ts}Alerts{/ts} <em>{$alertsCount}</em>
                        </a>
                    </li>
                </ul>

                <div id="data-subtab" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
                    {include file="CRM/Healthmonitor/Page/Tabs/Data.tpl"}
                </div>
                <div id="devices-subtab" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
                2
                </div>
                <div id="analytics-subtab" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
                3
                </div>
                <div id="alerts-subtab" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
                4
                </div>
                <div class="clear"></div>
            </div>
        </div>

{/crmScope}
{literal}
<script type="text/javascript">
    (function ($, _) {
        var context = {/literal}"{$context}"{literal};

        $(document).ready(function () {
            //Reset Table, add Filter and Search Possibility
            var tab = $('.selector-' + context);
            var table = tab.DataTable();
            var dtsettings = table.settings().init();
            dtsettings.bFilter = true;
            //turn on search

            dtsettings.sDom = '<"crm-datatable-pager-top"lp>rt<"crm-datatable-pager-bottom"ip>';
            //turn of search field

            dtsettings.fnServerData = function ( sSource, aoData, fnCallback ) {
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
            table.destroy();
            var newtable = tab.DataTable(dtsettings);
            //End Reset Table
            $('.healthmonitor-filter :input').change(function(){
                console.log( 'change input' );
                console.log( this.id );
                console.log( this.name );
                console.log( this.value );
                newtable.draw();
            });

        });


    })(CRM.$, CRM._);


</script>
{/literal}

