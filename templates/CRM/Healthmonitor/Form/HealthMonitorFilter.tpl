<div class="crm-content-block">

  <div class="crm-block crm-form-block crm-basic-criteria-form-block">
    <div class="crm-accordion-wrapper crm-expenses_search-accordion">
      <div class="crm-accordion-header crm-master-accordion-header">{ts}Search Health Monitoring{/ts}</div><!-- /.crm-accordion-header -->
      <div class="crm-accordion-body">
        <table class="form-layout">
          <tbody>
          <tr>
            <td class="label">3{$form.dateselect_from.label}</td>
            <td>{$form.dateselect_from.html}</td>
            <td class="label">4{$form.dateselect_to.label}</td>
            <td>{$form.dateselect_to.html}</td>
          </tr>
          <tr>
            <td class="label">5{$form.device_type_id.label}</td>
            <td>{$form.device_type_id.html}</td>
            <td class="label">6{$form.sensor_id.label}</td>
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

  {literal}

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