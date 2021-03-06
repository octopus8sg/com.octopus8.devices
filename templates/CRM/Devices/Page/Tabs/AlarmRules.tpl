<div class="crm-content-block">
    <div class="action-link">
        <a class="button add-alarm-rule" href="{crmURL p="civicrm/devices/alarmrule" q="reset=1&action=add" }&cid={$contactId}">
            <i class="crm-i fa-plus-circle">&nbsp;</i>
            {ts}Add Alarm Rule{/ts}
        </a>
    </div>
    <div class="clear"></div>
    {include file="CRM/Devices/Form/AlarmRuleFilter.tpl"}
    <div class="clear"></div>
    <div class="crm-results-block">
        <div class="crm-search-results">
{*            {include file="CRM/common/enableDisableApi.tpl"}*}
{*            {include file="CRM/common/jsortable.tpl"}*}
{*            <table class="selector-alarmrules row-highlight pagerDisplay" id="myAlarmRules" name="myAlarmRules">*}
            <table class="selector-alarmrules row-highlight pagerDisplay" id="myAlarmRules" name="myAlarmRules">
                <thead class="sticky">
                <tr>
                    <th id="sortable" scope="col">
                        {ts}ID{/ts}
                    </th>
                    <th scope="col">
                        {ts}Alarm Rule Code{/ts}
                    </th>
                    <th scope="col">
                        {ts}Sensor{/ts}
                    </th>
                    <th scope="col">
                        {ts}Rule{/ts}
                    </th>
                    <th scope="col">
                        {ts}Value{/ts}
                    </th>
                    <th id="nosort">&nbsp;Action</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
{crmScript ext=com.octopus8.devices file=js/tabalarmrules.js}