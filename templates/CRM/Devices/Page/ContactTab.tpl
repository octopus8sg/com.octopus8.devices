{crmScope extensionKey='devices'}
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
                <li id="tab_data1"
                    class="crm-tab-button ui-corner-all ui-tabs-tab ui-corner-top ui-state-default ui-tab ui-tabs-active ui-state-active">
                    <a href="#data-subtab1" title="{ts}Data{/ts}">
                        {ts}Data{/ts} <em>{$dataCount}</em>
                    </a>
                </li>
                <li id="tab_devices1"
                    class="crm-tab-button ui-corner-all ui-tabs-tab ui-corner-top ui-state-default ui-tab">
                    <a href="#devices-subtab1" title="{ts}Devices{/ts}">
                        {ts}Devices{/ts} <em>{$deviceCount}</em>
                    </a>
                </li>
                <li id="tab_analytics1"
                    class="crm-tab-button ui-corner-all ui-tabs-tab ui-corner-top ui-state-default ui-tab">
                    <a href="#analytics-subtab1" title="{ts}Analytics{/ts}">
                        {ts}Analytics{/ts} <em>{$analyticsCount}</em>
                    </a>
                </li>
                <li id="tab_alarms1"
                    class="crm-tab-button ui-corner-all ui-tabs-tab ui-corner-top ui-state-default ui-tab">
                    <a href="#alarms-subtab1" title="{ts}Alarm Rules{/ts}">
                        {ts}Alarm Rules{/ts} <em>{$alarmRuleCount}</em>
                    </a>
                </li>
                <li id="tab_alarms2"
                    class="crm-tab-button ui-corner-all ui-tabs-tab ui-corner-top ui-state-default ui-tab">
                    <a href="#alarms-subtab2" title="{ts}Alarms{/ts}">
                        {ts}Alarms{/ts} <em>{$alarmCount}</em>
                    </a>
                </li>
                <li id="tab_alarms3"
                    class="crm-tab-button ui-corner-all ui-tabs-tab ui-corner-top ui-state-default ui-tab">
                    <a href="#alarms-subtab3" title="{ts}Alert Rules{/ts}">
                        {ts}Alert Rules{/ts} <em>{$alertRuleCount}</em>
                    </a>
                </li>
                <li id="tab_alarms4"
                    class="crm-tab-button ui-corner-all ui-tabs-tab ui-corner-top ui-state-default ui-tab">
                    <a href="#alarms-subtab4" title="{ts}Alerts{/ts}">
                        {ts}Alerts{/ts} <em>{$alertCount}</em>
                    </a>
                </li>
            </ul>

            <div id="data-subtab1" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
                {include file="CRM/Devices/Page/Tabs/Data.tpl"}
            </div>
            <div id="devices-subtab1" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
                {include file="CRM/Devices/Page/Tabs/Devices.tpl"}
            </div>
            <div id="analytics-subtab1" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
                {*                {include file="CRM/Devices/Page/Tabs/Analytics.tpl"}*}
            </div>
            <div id="alarms-subtab1" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
                {include file="CRM/Devices/Page/Tabs/AlarmRules.tpl"}
            </div>
            <div id="alarms-subtab2" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
                {include file="CRM/Devices/Page/Tabs/Alarms.tpl"}
            </div>
            <div id="alarms-subtab3" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
                {include file="CRM/Devices/Page/Tabs/AlertRules.tpl"}
            </div>
            <div id="alarms-subtab4" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
                {*                {include file="CRM/Devices/Page/Tabs/Alerts.tpl"}*}
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
