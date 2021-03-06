<div class="crm-content-block">
    <div class="clear"></div>
    {include file="CRM/Devices/Form/AlertFilter.tpl"}
    <div class="clear"></div>
    <div class="crm-results-block">
        <div class="crm-search-results">
            {include file="CRM/common/enableDisableApi.tpl"}
            {include file="CRM/common/jsortable.tpl"}
            <table class="selector-alert row-highlight pagerDisplay" id="SearchAlerts" name="SearchAlerts">
                <thead class="sticky">
                <tr>
                    <th id="sortable" scope="col">
                        {ts}ID{/ts}
                    </th>
                    <th scope="col">
                        {ts}Date{/ts}
                    </th>
                    <th scope="col">
                        {ts}Device Contact{/ts}
                    </th>
                    <th scope="col">
                        {ts}Alert Contact{/ts}
                    </th>
                    <th scope="col">
                        {ts}Device Data{/ts}
                    </th>
                    <th scope="col">
                        {ts}CiviCRM{/ts}
                    </th>
                    <th scope="col">
                        {ts}Email{/ts}
                    </th>
                    <th id="nosort">&nbsp;Action</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
{crmScript ext=com.octopus8.devices file=js/alerts.js}