{crmScope extensionKey='healthmonitor'}
    {*    <div class="healthmonitoring-devices-tab view-content">*}

    {*        <div id="secondaryTabContainer" class="ui-tabs ui-widget ui-widget-content ui-corner-all">*}
    {*            {include file="CRM/common/TabSelected.tpl" defaultTab="data" tabContainer="#secondaryTabContainer"}*}

    {*            <ul class="ui-tabs-nav ui-corner-all ui-helper-reset ui-helper-clearfix ui-widget-header">*}
    {*                <li id="tab_data" class="crm-tab-button ui-corner-all ui-tabs-tab ui-corner-top ui-state-default ui-tab ui-tabs-active ui-state-active">*}
    {*                    <a href="#data-subtab" title="{ts}Data{/ts}">*}
    {*                        {ts}Data{/ts} <em>{$tabCount}</em>*}
    {*                    </a>*}
    {*                </li>*}
    {*                <li id="tab_devices" class="crm-tab-button ui-corner-all ui-tabs-tab ui-corner-top ui-state-default ui-tab">*}
    {*                    <a href="#devices-subtab" title="{ts}Devices{/ts}">*}
    {*                        {ts}Devices{/ts} <em>{$devicesCount}</em>*}
    {*                    </a>*}
    {*                </li>*}
    {*                <li id="tab_analytics" class="crm-tab-button ui-corner-all ui-tabs-tab ui-corner-top ui-state-default ui-tab">*}
    {*                    <a href="#analytics-subtab" title="{ts}Analytics{/ts}">*}
    {*                        {ts}Analytics{/ts} <em>{$analyticsCount}</em>*}
    {*                    </a>*}
    {*                </li>*}
    {*                <li id="tab_alerts" class="crm-tab-button ui-corner-all ui-tabs-tab ui-corner-top ui-state-default ui-tab">*}
    {*                    <a href="#alerts-subtab" title="{ts}Alerts{/ts}">*}
    {*                        {ts}Alerts{/ts} <em>{$alertsCount}</em>*}
    {*                    </a>*}
    {*                </li>*}
    {*            </ul>*}

    {*            <div id="data-subtab" class="ui-tabs-panel ui-widget-content ui-corner-bottom">*}
    {*                <div class="help">*}
    {*                    {if $permission EQ 'edit'}*}
    {*                        {capture assign=newContribURL}{crmURL p="civicrm/contact/view/contribution" q="reset=1&action=add&cid=`$contactId`&context=contribution"}{/capture}*}
    {*                        {capture assign=link}class="action-item" href="{$newContribURL}"{/capture}*}
    {*                        {ts 1=$link}Click <a %1>Record Contribution</a> to record a new contribution received from this contact.{/ts}*}
    {*                        {if $newCredit}*}
    {*                            {capture assign=newCreditURL}{crmURL p="civicrm/contact/view/contribution" q="reset=1&action=add&cid=`$contactId`&context=contribution&mode=live"}{/capture}*}
    {*                            {capture assign=link}class="action-item" href="{$newCreditURL}"{/capture}*}
    {*                            {ts 1=$link}Click <a %1>Submit Credit Card Contribution</a> to process a new contribution on behalf of the contributor using their credit card.{/ts}*}
    {*                        {/if}*}
    {*                    {else}*}
    {*                        {ts 1=$displayName}Contributions received from %1 since inception.{/ts}*}
    {*                    {/if}*}
    {*                </div>*}

    {*                {if $action eq 16 and $permission EQ 'edit'}*}
    {*                    <div class="action-link">*}
    {*                        <a accesskey="N" href="{$newContribURL}" class="button"><span><i class="crm-i fa-plus-circle" aria-hidden="true"></i> {ts}Record Contribution (Check, Cash, EFT ...){/ts}</span></a>*}
    {*                        {if $newCredit}*}
    {*                            <a accesskey="N" href="{$newCreditURL}" class="button"><span><i class="crm-i fa-credit-card" aria-hidden="true"></i> {ts}Submit Credit Card Contribution{/ts}</span></a>*}
    {*                        {/if}*}
    {*                        <br /><br />*}
    {*                    </div>*}
    {*                    <div class='clear'></div>*}
    {*                {/if}*}

    {*                {if $rows}*}
    {*                    {include file="CRM/Contribute/Page/ContributionTotals.tpl" mode="view"}*}
    {*                    <div class='clear'></div>*}
    {*                    {include file="CRM/Contribute/Form/Selector.tpl"}*}
    {*                {else}*}
    {*                    <div class="messages status no-popup">*}
    {*                        {icon icon="fa-info-circle"}{/icon}*}
    {*                        {ts}No contributions have been recorded from this contact.{/ts}*}
    {*                    </div>*}
    {*                {/if}*}

    {*                {if $softCredit}*}
    {*                    <div class="crm-block crm-contact-contribute-softcredit">*}
    {*                        <h3>{ts}Soft credits{/ts} {help id="id-soft_credit"}</h3>*}
    {*                        {include file="CRM/Contribute/Page/ContributionSoft.tpl"}*}
    {*                    </div>*}
    {*                {/if}*}
    {*            </div>*}
    {*            <div id="devices-subtab" class="ui-tabs-panel ui-widget-content ui-corner-bottom">*}
    {*                {if $recur}*}
    {*                    <div class="crm-block crm-contact-contribute-recur crm-contact-contribute-recur-active">*}
    {*                        <h3>{ts}Active Recurring Contributions{/ts}</h3>*}
    {*                        {include file="CRM/Contribute/Page/ContributionRecurSelector.tpl" recurRows=$activeRecurRows}*}
    {*                    </div>*}
    {*                    <div class="crm-block crm-contact-contribute-recur crm-contact-contribute-recur-inactive">*}
    {*                        <h3>{ts}Inactive Recurring Contributions{/ts}</h3>*}
    {*                        {include file="CRM/Contribute/Page/ContributionRecurSelector.tpl" recurRows=$inactiveRecurRows}*}
    {*                    </div>*}
    {*                {/if}*}
    {*            </div>*}
    {*            <div class="clear"></div>*}
    {*        </div>*}
    {*    </div>*}
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
                <table class="selector selector-{$context} row-highlight pagerDisplay" id="myTable" name="myTable">
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
                            {ts}Device ID{/ts}
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
{/crmScope}
{literal}
<script type="text/javascript">
    (function ($, _) {
        var context = {/literal}"{$context}"{literal};

        $(document).ready(function () {
            //Reset Table, add Filter and Search Possibility
            var tab = $('.selector-' + context);
            var table = tab.DataTable();
            var dtsettings = table.settings().init();
            dtsettings.bFilter = true;
            //turn on search

            dtsettings.sDom = '<"crm-datatable-pager-top"lp>rt<"crm-datatable-pager-bottom"ip>';
            //turn of search field

            dtsettings.fnServerData = function ( sSource, aoData, fnCallback ) {
                aoData.push({ "name": "dateselect_from", "value": $('#dateselect_from').val() });
                aoData.push({ "name": "dateselect_to", "value": $('#dateselect_to').val() });
                aoData.push({ "name": "device_type_id", "value": $('#device_type_id').val() });
                aoData.push({ "name": "sensor_id", "value": $('#sensor_id').val() });
                $.ajax( {
                    "dataType": 'json',
                    "type": "POST",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                });
            };
            table.destroy();
            var newtable = tab.DataTable(dtsettings);
            //End Reset Table
            $('.healthmonitor-filter :input').change(function(){
                console.log( 'change input' );
                console.log( this.id );
                console.log( this.name );
                console.log( this.value );
                newtable.draw();
            });

        });


    })(CRM.$, CRM._);


</script>
{/literal}

