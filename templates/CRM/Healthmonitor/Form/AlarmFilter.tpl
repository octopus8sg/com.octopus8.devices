 <div class="crm-content-block">

    <div class="crm-block crm-form-block crm-basic-criteria-form-block">
      <div class="crm-accordion-wrapper crm-expenses_search-accordion">
        <div class="crm-accordion-header crm-master-accordion-header">{ts}Filter Alarm Data{/ts}</div><!-- /.crm-accordion-header -->
        <div class="crm-accordion-body">
          <table class="form-layout alarm-filter">
            <tbody>
            <tr>
              <td class="label">{$form.alarm_dateselect_from.label}</td>
              <td>{$form.alarm_dateselect_from.html}</td>
              <td class="label">{$form.alarm_dateselect_to.label}</td>
              <td>{$form.alarm_dateselect_to.html}</td>
            </tr>
            <tr>
              <td class="label">{$form.alarm_sensor_id.label}</td>
              <td>{$form.alarm_sensor_id.html}</td>
              <td class="label">{$form.alarm_addressee_id.label}</td>
              <td>{$form.alarm_addressee_id.html}</td>
            </tr>
            <tr>
              <td class="label">{$form.alarm_civicrm.label}</td>
              <td>{$form.alarm_civicrm.html}</td>
              <td class="label">{$form.alarm_email.label}</td>
              <td>{$form.alarm_email.html}</td>
            </tr>
{*            <tr>*}
{*              <td class="label">{$form.alarm_telegram.label}</td>*}
{*              <td>{$form.alarm_rule_telegram.html}</td>*}
{*              <td class="label">{$form.alarm_api.label}</td>*}
{*              <td>{$form.alarm_rule_api.html}</td>*}
{*            </tbody>*}
          </table>
          <div class="crm-submit-buttons">
            {include file="CRM/common/formButtons.tpl"}
          </div>
        </div><!- /.crm-accordion-body -->
      </div><!-- /.crm-accordion-wrapper -->
    </div><!-- /.crm-form-block -->
 </div>
