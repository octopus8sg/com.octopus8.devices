{crmScope extensionKey='healthmonitor'}
        <div class="healthmonitoring-devices-tab view-content">
            <div class="action-link">
                <a class="button" target="_blank" href="{crmURL p="civicrm/healthmonitor/createsomedata"
                }">
                    <i class="crm-i fa-plus-circle">&nbsp;</i>
                    {ts}Add Sample Data {/ts}
                </a>
                <a class="button" target="_blank" href="{crmURL p="civicrm/healthmonitor/createsomerules"
                }">
                    <i class="crm-i fa-plus-circle">&nbsp;</i>
                    {ts}Add Default Device Alarm / Alert Rules{/ts}
                </a>
            </div>
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
                        <a href="#alerts-subtab1" title="{ts}Alert Rules{/ts}">
                            {ts}Alert Rules{/ts} <em>{$alertRulesCount}</em>
                        </a>
                    </li>
                    <li id="tab_alerts2" class="crm-tab-button ui-corner-all ui-tabs-tab ui-corner-top ui-state-default ui-tab">
                        <a href="#alerts-subtab2" title="{ts}Alerts{/ts}">
                            {ts}Alerts{/ts} <em>{$alertsCount}</em>
                        </a>
                    </li>
                    <li id="tab_alerts3" class="crm-tab-button ui-corner-all ui-tabs-tab ui-corner-top ui-state-default ui-tab">
                        <a href="#alerts-subtab2" title="{ts}Alarm Rules{/ts}">
                            {ts}Alerts{/ts} <em>{$alertsCount}</em>
                        </a>
                    </li>
                    <li id="tab_alerts4" class="crm-tab-button ui-corner-all ui-tabs-tab ui-corner-top ui-state-default ui-tab">
                        <a href="#alerts-subtab2" title="{ts}Alarms{/ts}">
                            {ts}Alerts{/ts} <em>{$alertsCount}</em>
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
                    {include file="CRM/Healthmonitor/Page/Tabs/AlertRules.tpl"}
                </div>
                <div class="clear"></div>
            </div>
        </div>

{/crmScope}

