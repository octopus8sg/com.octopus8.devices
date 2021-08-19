<div class="crm-content-block">
    <div class="action-link">
        <a class="button" href="{crmURL p="civicrm/healthmonitor/form" q="reset=1&action=add" }">
            <i class="crm-i fa-plus-circle">&nbsp;</i>
            {ts}Add Health Monitor{/ts}
        </a>
    </div>
    <div class="clear"></div>
    {include file="CRM/Healthmonitor/Form/HealthMonitorFilter.tpl"}
    <div class="clear"></div>

    <div class="crm-results-block">
        <div class="crm-search-results">
            {include file="CRM/common/enableDisableApi.tpl"}
            {include file="CRM/common/jsortable.tpl"}
            <table class="selector selector-data row-highlight pagerDisplay" id="myTable" name="myTable">
                <thead class="sticky">
                <tr>
                    <th id="sortable" scope="col">
                        {ts}ID{/ts}
                    </th>
                    <th scope="col">
                        {ts}Date{/ts}
                    </th>
                    <th scope="col">
                        {ts}Device Type{/ts}
                    </th>
                    <th scope="col">
                        {ts}Device Unique Code{/ts}
                    </th>
                    <th scope="col">
                        {ts}Sensor{/ts}
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