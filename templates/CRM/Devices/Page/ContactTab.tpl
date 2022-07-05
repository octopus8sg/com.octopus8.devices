{crmScope extensionKey='com.octopus8.devices'}
    <div class="devices-tab view-content">
        {*            <div class="action-link">*}
        {*                <a class="button" target="_blank" href="{crmURL p="civicrm/device/makedata" q="cid=$contactId"}">*}
        {*                    <i class="crm-i fa-plus-circle">&nbsp;</i>*}
        {*                    {ts}Add Sample Data {/ts}*}
        {*                </a>*}
        {*                <a class="button" target="_blank" href="{crmURL p="civicrm/device/makerules" q="cid=$contactId"}">*}
        {*                    <i class="crm-i fa-plus-circle">&nbsp;</i>*}
        {*                    {ts}Add Default Device Alert / Alarm Rules{/ts}*}
        {*                </a>*}
        {*            </div>*}
        <div id="secondaryTabContainer1" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
            {include file="CRM/common/TabSelected.tpl" defaultTab="data" tabContainer="#secondaryTabContainer1"}

            <ul class="ui-tabs-nav ui-corner-all ui-helper-reset ui-helper-clearfix ui-widget-header">
                <li id="tab_data"
                    class="crm-tab-button ui-corner-all ui-tabs-tab ui-corner-top ui-state-default ui-tab ui-tabs-active ui-state-active">
                    <a href="#data-subtab" title="{ts}Data{/ts}">
                        {ts}Data{/ts} <em>{$dataCount}</em>
                    </a>
                </li>
                <li id="tab_devices"
                    class="crm-tab-button ui-corner-all ui-tabs-tab ui-corner-top ui-state-default ui-tab">
                    <a href="#devices-subtab" title="{ts}Devices{/ts}">
                        {ts}Devices{/ts} <em>{$deviceCount}</em>
                    </a>
                </li>
                <li id="tab_analytics"
                    class="crm-tab-button ui-corner-all ui-tabs-tab ui-corner-top ui-state-default ui-tab">
                    <a href="#analytics-subtab" title="{ts}Analytics{/ts}">
                        {ts}Analytics{/ts} <em>{$analyticsCount}</em>
                    </a>
                </li>
                <li id="tab_alarm_rules"
                    class="crm-tab-button ui-corner-all ui-tabs-tab ui-corner-top ui-state-default ui-tab">
                    <a href="#alarm-rules-subtab" title="{ts}Alarm Rules{/ts}">
                        {ts}Alarm Rules{/ts} <em>{$alarmRuleCount}</em>
                    </a>
                </li>
                <li id="tab_alarms"
                    class="crm-tab-button ui-corner-all ui-tabs-tab ui-corner-top ui-state-default ui-tab">
                    <a href="#alarms-subtab" title="{ts}Alarms{/ts}">
                        {ts}Alarms{/ts} <em>{$alarmCount}</em>
                    </a>
                </li>
                <li id="tab_alert_rules"
                    class="crm-tab-button ui-corner-all ui-tabs-tab ui-corner-top ui-state-default ui-tab">
                    <a href="#alert-rules-subtab" title="{ts}Alert Rules{/ts}">
                        {ts}Alert Rules{/ts} <em>{$alertRuleCount}</em>
                    </a>
                </li>
                <li id="tab_alerts"
                    class="crm-tab-button ui-corner-all ui-tabs-tab ui-corner-top ui-state-default ui-tab">
                    <a href="#alerts-subtab" title="{ts}Alerts{/ts}">
                        {ts}Alerts{/ts} <em>{$alertCount}</em>
                    </a>
                </li>
            </ul>

            <div id="data-subtab" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
                {include file="CRM/Devices/Page/Tabs/Data.tpl"}
            </div>
            <div id="devices-subtab" class="devices-subtab ui-tabs-panel ui-widget-content ui-corner-bottom">
                {include file="CRM/Devices/Page/Tabs/Devices.tpl"}
            </div>
            <div id="analytics-subtab" class="analytics-subtab ui-tabs-panel ui-widget-content ui-corner-bottom">
                {include file="CRM/Devices/Page/Tabs/Analytics.tpl"}
            </div>
            <div id="alarm-rules-subtab" class="alarm-rules-subtab ui-tabs-panel ui-widget-content ui-corner-bottom">
                {include file="CRM/Devices/Page/Tabs/AlarmRules.tpl"}
            </div>
            <div id="alarms-subtab" class="alarms-subtab ui-tabs-panel ui-widget-content ui-corner-bottom">
                {include file="CRM/Devices/Page/Tabs/Alarms.tpl"}
            </div>
            <div id="alert-rules-subtab" class="alert-rules-subtab ui-tabs-panel ui-widget-content ui-corner-bottom">
                {include file="CRM/Devices/Page/Tabs/AlertRules.tpl"}
            </div>
            <div id="alerts-subtab" class="alerts-subtab ui-tabs-panel ui-widget-content ui-corner-bottom">
                {include file="CRM/Devices/Page/Tabs/Alerts.tpl"}
            </div>
            <div class="clear"></div>
        </div>
    </div>
{/crmScope}

{literal}
    <script type="text/javascript">
        CRM.$(function ($) {
            $('input.hasDatepicker')
                .crmDatepicker({
                    format: "yy-mm-dd",
                    altFormat: "yy-mm-dd",
                    dateFormat: "yy-mm-dd"
                });

        });
        // CRM.$(function($) {
        //   $("input[name='dateselect_to']").datepicker({
        //     format: "yy-mm-dd",
        //     altFormat: "yy-mm-dd",
        //     dateFormat: "yy-mm-dd"
        //   });
        //   $("input[name='dateselect_from']").datepicker({
        //     format: "yy-mm-dd",
        //     altFormat: "yy-mm-dd",
        //     dateFormat: "yy-mm-dd"
        //   });
        // });
    </script>
{/literal}
