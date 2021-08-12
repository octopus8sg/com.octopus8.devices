{crmScope extensionKey='healthmonitor'}
  <div class="crm-content-block">

    <div class="crm-block crm-form-block crm-basic-criteria-form-block">
      <div class="crm-accordion-wrapper crm-expenses_search-accordion collapsed">
        <div class="crm-accordion-header crm-master-accordion-header">{ts}Search Devices{/ts}</div><!-- /.crm-accordion-header -->
        <div class="crm-accordion-body">
          <table class="form-layout">
            <tbody>
            <tr>
              <td class="label">{$form.device_name.label}</td>
              <td>{$form.device_name.html}</td>
            </tr>
            <tr>
              <td class="label">{$form.contact_id.label}</td>
              <td>{$form.contact_id.html}</td>
            </tr>
            <tr>
              <td class="label">{$form.device_type_id.label}</td>
              <td>{$form.device_type_id.html}</td>
            </tr>
            </tbody>
          </table>
          <div class="crm-submit-buttons">
            {include file="CRM/common/formButtons.tpl"}
          </div>
        </div><!- /.crm-accordion-body -->
      </div><!-- /.crm-accordion-wrapper -->
    </div><!-- /.crm-form-block -->


    <div class="action-link">
      <a class="button" href="{crmURL p="civicrm/device/form" q="reset=1&action=add" }">
        <i class="crm-i fa-plus-circle">&nbsp;</i>
        {ts}Add New Device{/ts}
      </a>
    </div>

    <div class="clear"></div>

    <div class="crm-results-block">
      {include file="CRM/common/pager.tpl" location="top"}
      {include file="CRM/common/enableDisableApi.tpl"}
      {include file="CRM/common/jsortable.tpl"}

      <div class="crm-search-results">
        <table class="selector row-highlight display">
          <thead class="sticky">
          <tr>
            <th id="sortable" scope="col">
              {ts}ID{/ts}
            </th>
            <th scope="col">
              {ts}Device Unique Code{/ts}
            </th>
            <th scope="col">
              {ts}Device Type{/ts}
            </th>
            <th scope="col">
              {ts}Contact{/ts}
            </th>
            <th  id="nosort">&nbsp;</th>
          </tr>
          </thead>
          {foreach from=$entities item=row}
            <tr>
              <td>{$row.id}</td>
              <td>{$row.name}</td>
              <td>{$row.device_type}</td>
              <td>{$row.contact}</td>
              <td class="right nowrap">
                  <span>
                    <a class="action-item crm-hover-button" href="{crmURL p='civicrm/device/form' q="id=`$row.id`&action=update"}"><i class="crm-i fa-pencil"></i>&nbsp;{ts}Edit{/ts}</a>
                    <a class="action-item crm-hover-button" href="{crmURL p='civicrm/device/form' q="id=`$row.id`&action=delete"}"><i class="crm-i fa-trash"></i>&nbsp;{ts}Delete{/ts}</a>
                  </span>
              </td>
            </tr>
          {/foreach}
        </table>

      </div>

      {include file="CRM/common/pager.tpl" location="bottom"}
    </div>
  </div>
{/crmScope}