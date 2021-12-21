{crmScope extensionKey='com.octopus8.devices'}
  <div class="crm-content-block">

    <div class="crm-block crm-form-block crm-basic-criteria-form-block">
      <div class="crm-accordion-wrapper crm-expenses_search-accordion">
        <div class="crm-accordion-header crm-master-accordion-header">{ts}Filter Devices{/ts}</div><!-- /.crm-accordion-header -->
        <div class="crm-accordion-body">
          <table class="form-layout device-filter">
            <tbody>
            <tr>
              <td class="label">{$form.device_device_id.label}</td>
              <td>{$form.device_device_id.html}</td>
            </tr>
            <tr>
              <td class="label">{$form.device_device_type_id.label}</td>
              <td>{$form.device_device_type_id.html}</td>
            </tr>
            <tr>
              <td class="label">{$form.device_contact_id.label}</td>
              <td>{$form.device_contact_id.html}</td>
            </tr>
            </tbody>
          </table>
        </div><!- /.crm-accordion-body -->
      </div><!-- /.crm-accordion-wrapper -->
    </div><!-- /.crm-form-block -->
  </div>
{*  {debug}*}
{/crmScope}