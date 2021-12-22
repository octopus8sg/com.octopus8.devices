{crmScope extensionKey='com.octopus8.devices'}
    <div class="crm-content-block">
        <div class="action-link">
            {*        {debug}*}
            <a class="button add-devicedata" href="{crmURL p="civicrm/devices/devicedata" q="reset=1&action=add" }">
                <i class="crm-i fa-plus-circle">&nbsp;</i>
                {ts}Add Device Data{/ts}
            </a>
        </div>
        <div class="clear"></div>
        {include file="CRM/Devices/Form/DeviceDataFilter.tpl"}
        <div class="clear"></div>
        <div class="crm-results-block">
            <div class="crm-search-results">
                {include file="CRM/common/enableDisableApi.tpl"}
                {include file="CRM/common/jsortable.tpl"}
                <table class="selector-devicedata row-highlight pagerDisplay" id="DeviceData" name="DeviceData">
                    <thead class="sticky">
                    <tr>
                        <th id="sortable" scope="col">
                            {ts}ID{/ts}
                        </th>
                        <th scope="col">
                            {ts}Device Owner{/ts}
                        </th>
                        <th scope="col">
                            {ts}Data Date{/ts}
                        </th>
                        <th scope="col">
                            {ts}Device Type{/ts}
                        </th>
                        <th scope="col">
                            {ts}Code{/ts}
                        </th>
                        <th scope="col">
                            {ts}Sensor{/ts}
                        </th>
                        <th scope="col">
                            {ts}Data Value{/ts}
                        </th>
                        <th id="nosort">&nbsp;Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
{crmScript ext=com.octopus8.devices file=js/devicedata.js}
{/crmScope}