{crmScope extensionKey='com.octopus8.devices'}
    <div class="crm-content-block">
        <div class="action-link">
            {*        {debug}*}
            <a class="button add-device" href="{crmURL p="civicrm/devices/form" q="reset=1&action=add" }">
                <i class="crm-i fa-plus-circle">&nbsp;</i>
                {ts}Add Device{/ts}
            </a>
        </div>
        <div class="clear"></div>
        {include file="CRM/Devices/Form/DeviceFilter.tpl"}
        <div class="clear"></div>
        <div class="crm-results-block">
            <div class="crm-search-results">
                {include file="CRM/common/enableDisableApi.tpl"}
                {include file="CRM/common/jsortable.tpl"}
                <table class="selector-devices row-highlight pagerDisplay" id="Devices" name="Devices">
                    <thead class="sticky">
                    <tr>
                        <th id="sortable" scope="col">
                            {ts}ID{/ts}
                        </th>
                        <th scope="col">
                            {ts}Code{/ts}
                        </th>
                        <th scope="col">
                            {ts}Type{/ts}
                        </th>
                        <th scope="col">
                            {ts}Owner{/ts}
                        </th>
                        <th id="nosort">&nbsp;Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
{crmScript ext=com.octopus8.devices file=js/devices.js}
{/crmScope}