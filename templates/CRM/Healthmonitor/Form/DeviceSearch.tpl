<div class="crm-content-block">
  <div class="action-link">
    <a class="button add-device" href="{crmURL p="civicrm/devices/form" q="reset=1&action=add" }&cid={$contactId}">
      <i class="crm-i fa-plus-circle">&nbsp;</i>
      {ts}Add Device{/ts}
    </a>
  </div>
  <div class="clear"></div>
  <div class="crm-content-block">

    <div class="crm-block crm-form-block crm-basic-criteria-form-block">
      <div class="crm-accordion-wrapper crm-expenses_search-accordion">
        <div class="crm-accordion-header crm-master-accordion-header">{ts}Filter Devices{/ts}</div><!-- /.crm-accordion-header -->
        <div class="crm-accordion-body">
          <table class="form-layout device-filter">
            <tbody>
            <tr>
              <td class="label">{$form.device_type_id.label}</td>
              <td>{$form.device_type_id.html}</td>
            </tr>
            </tbody>
          </table>
        </div><!- /.crm-accordion-body -->
      </div><!-- /.crm-accordion-wrapper -->
    </div><!-- /.crm-form-block -->
  </div>
  <div class="clear"></div>
  <div class="crm-results-block">
    <div class="crm-search-results">
      {include file="CRM/common/enableDisableApi.tpl"}
      {include file="CRM/common/jsortable.tpl"}
      <table class="selector selector-devices row-highlight pagerDisplay" id="myDevices" name="myDevices">
        <thead class="sticky">
        <tr>
          <th id="sortable" scope="col">
            {ts}ID{/ts}
          </th>
          <th scope="col">
            {ts}Device Code{/ts}
          </th>
          <th scope="col">
            {ts}Device Type{/ts}
          </th>
          <th scope="col">
            {ts}Contact{/ts}
          </th>
          <th id="nosort">&nbsp;Action</th>
        </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
{crmScript ext=com.octopus8.devices file=js/devices.js}