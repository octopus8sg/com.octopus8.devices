<div class="crm-content-block">

  <div class="crm-block crm-form-block crm-basic-criteria-form-block">
    <div class="crm-accordion-wrapper crm-expenses_search-accordion">
      <div class="crm-accordion-header crm-master-accordion-header">{ts}Filter Alert Rules{/ts}</div><!-- /.crm-accordion-header -->
      <div class="crm-accordion-body">
        <table class="form-layout alertrule-filter">
          <tbody>
          <tr>
            <td class="label">{$form.alert_rule_sensor_id.label}</td>
            <td>{$form.alert_rule_sensor_id.html}</td>
            <td class="label">{$form.alert_rule_addressee_id.label}</td>
            <td>{$form.alert_rule_addressee_id.html}</td>
          </tr>
          <tr>
            <td class="label">{$form.alert_rule_civicrm.label}</td>
            <td>{$form.alert_rule_civicrm.html}</td>
            <td class="label">{$form.alert_rule_email.label}</td>
            <td>{$form.alert_rule_email.html}</td>
          </tr>
          <tr>
            <td class="label">{$form.alert_rule_telegram.label}</td>
            <td>{$form.alert_rule_telegram.html}</td>
            <td class="label">{$form.alert_rule_api.label}</td>
            <td>{$form.alert_rule_api.html}</td>
          </tr>
          </tbody>
        </table>
        <div class="crm-submit-buttons">
          {include file="CRM/common/formButtons.tpl"}
        </div>
      </div><!- /.crm-accordion-body -->
    </div><!-- /.crm-accordion-wrapper -->
  </div><!-- /.crm-form-block -->
</div>
