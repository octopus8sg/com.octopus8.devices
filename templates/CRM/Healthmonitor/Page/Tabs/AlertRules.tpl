<div class="crm-content-block">
    <div class="action-link">
        <a class="button" target="_blank" href="{crmURL p="civicrm/alertrule/form" q="reset=1&action=add" }">
            <i class="crm-i fa-plus-circle">&nbsp;</i>
            {ts}Add Alert Rule{/ts}
        </a>
    </div>
    <div class="clear"></div>
    {include file="CRM/Healthmonitor/Form/AlertRuleFilter.tpl"}
    <div class="clear"></div>
    <div class="crm-results-block">
        <div class="crm-search-results">
            {include file="CRM/common/enableDisableApi.tpl"}
            {include file="CRM/common/jsortable.tpl"}
            <table class="selector selector-alertrules row-highlight pagerDisplay" id="myAlertRules" name="myAlertRules">
                <thead class="sticky">
                <tr>
                    <th id="sortable" scope="col">
                        {ts}ID{/ts}
                    </th>
                    <th scope="col">
                        {ts}Unique Code{/ts}
                    </th>
                    <th scope="col">
                        {ts}Sensor Name{/ts}
                    </th>
                    <th scope="col">
                        {ts}Rule Name{/ts}
                    </th>
                    <th scope="col">
                        {ts}Sensor Value{/ts}
                    </th>
                    <th id="nosort">&nbsp;Action</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>