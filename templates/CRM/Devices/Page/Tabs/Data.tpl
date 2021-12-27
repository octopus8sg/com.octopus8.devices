<div class="crm-content-block">
    <div class="clear"></div>
    {include file="CRM/Devices/Form/DeviceDataFilter.tpl"}
    <div class="clear"></div>

    <div class="crm-results-block">
        <div class="crm-search-results">
            {include file="CRM/common/enableDisableApi.tpl"}
            {include file="CRM/common/jsortable.tpl"}
            <table class="selector-devicedata row-highlight pagerDisplay" id="myTable" name="myTable">
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
                        {ts}Device Code{/ts}
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
{crmScript ext=com.octopus8.devices file=js/tabdevicedata.js}