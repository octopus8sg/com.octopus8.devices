{crmScope extensionKey='healthmonitor'}
{*{debug}*}
{literal}
  <!--link id="bsdp-css" href="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet"-->
{/literal}
  <div class="crm-content-block">

    <div class="crm-block crm-form-block crm-basic-criteria-form-block">
      <div class="crm-accordion-wrapper crm-expenses_search-accordion collapsed">
        <div class="crm-accordion-header crm-master-accordion-header">{ts}Search Device Data{/ts}</div><!-- /.crm-accordion-header -->
        <div class="crm-accordion-body">
          <table class="form-layout">
            <tbody>
            <tr>
              <td class="label">{$form.contact_id.label}</td>
              <td>{$form.contact_id.html}</td>
              <td class="label">{$form.device_id.label}</td>
              <td>{$form.device_id.html}</td>
            </tr>
            <tr>
              <td class="label">{$form.dateselect_from.label}</td>
              <td>{$form.dateselect_from.html}</td>
              <td class="label">{$form.dateselect_to.label}</td>
              <td>{$form.dateselect_to.html}</td>
            </tr>
            <tr>
              <td class="label">{$form.device_type_id.label}</td>
              <td>{$form.device_type_id.html}</td>
              <td class="label">{$form.sensor_id.label}</td>
              <td>{$form.sensor_id.html}</td>
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
      <a class="button" href="{crmURL p="civicrm/healthmonitor/form" q="reset=1&action=add" }">
        <i class="crm-i fa-plus-circle">&nbsp;</i>
        {ts}Add New Health Monitor{/ts}
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
              {ts}Contact{/ts}
            </th>
            <th scope="col">
              {ts}Device Type{/ts}
            </th>
            <th scope="col">
              {ts}Device{/ts}
            </th>
            <th scope="col">
              {ts}Date{/ts}
            </th>
            <th scope="col">
              {ts}Sensor{/ts}
            </th>
            <th scope="col">
              {ts}Value{/ts}
            </th>
            <th>&nbsp;</th>
          </tr>
          </thead>
          {foreach from=$entities item=row}
            <tr>
              <td>{$row.id}</td>
              <td>{$row.contact}</td>
              <td>{$row.device_type_id}</td>
              <td>{$row.device}</td>
              <td>{$row.date}</td>
              <td>{$row.sensor_id}</td>
              <td>{$row.sensor_value}</td>
              <td class="right nowrap">
                  <span>
                    <a class="action-item crm-hover-button" target="_blank" href="{crmURL p='civicrm/healthmonitor/form' q="id=`$row.id`&action=update"}"><i class="crm-i fa-pencil"></i>&nbsp;{ts}Edit{/ts}</a>
                    <a class="action-item crm-hover-button" target="_blank" href="{crmURL p='civicrm/healthmonitor/form' q="id=`$row.id`&action=delete"}"><i class="crm-i fa-trash"></i>&nbsp;{ts}Delete{/ts}</a>
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

{literal}
  <!--script src="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script-->
  <script type="text/javascript">
    CRM.$(function($) {

      $("input[name='dateselect_to']").datepicker({
        format: "yy-mm-dd",
        altFormat: "yy-mm-dd",
        dateFormat: "yy-mm-dd"
      });
      $("input[name='dateselect_from']").datepicker({
        format: "yy-mm-dd",
        altFormat: "yy-mm-dd",
        dateFormat: "yy-mm-dd"
      });
    });
  </script>
{/literal}