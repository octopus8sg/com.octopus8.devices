{crmScope extensionKey='com.octopus8.devices'}
<div class="crm-content-block">
    {*{debug}*}
    <div class="crm-block crm-form-block crm-basic-criteria-form-block">
        <div class="crm-accordion-wrapper crm-expenses_search-accordion">
            <div class="crm-accordion-header crm-master-accordion-header">{ts}Filter Alert Data{/ts}</div>
            <!-- /.crm-accordion-header -->
            <div class="crm-accordion-body">
                {if isset($contactId)}
                    <table class="form-layout alert-filter">
                {else}
                    <table class="form-layout alert-filter">
                {/if}
                        <tbody>
                            <tr>
                                <td class="label">{$form.alert_id.label}</td>
                                <td>{$form.alert_id.html}</td>
                            </tr>
                            <tr>
                                <td class="label">{$form.alert_contact_id.label}</td>
                                <td>{$form.alert_contact_id.html}</td>
                                <td class="label">{$form.alert_addressee_id.label}</td>
                                <td>{$form.alert_addressee_id.html}</td>
                            </tr>

                        <tr>
                            <td class="label">{$form.alert_dateselect_from.label}</td>
                            <td>{$form.alert_dateselect_from.html}</td>
                            <td class="label">{$form.alert_dateselect_to.label}</td>
                            <td>{$form.alert_dateselect_to.html}</td>
                        </tr>
                        <tr>
                            <td class="label">{$form.alert_sensor_id.label}</td>
                            <td>{$form.alert_sensor_id.html}</td>
                            <td class="label">{$form.alert_alert_rule_type.label}</td>
                            <td>{$form.alert_alert_rule_type.html}</td>
                        </tr>
                        </tbody>
                    </table>
            </div>
            <!- /.crm-accordion-body -->
        </div><!-- /.crm-accordion-wrapper -->
    </div><!-- /.crm-form-block -->
</div>
{*    <script src="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>*}

{literal}

    <script type="text/javascript">
        // CRM.$(function ($) {
        //     $('input.hasDatepicker')
        //         .crmDatepicker({
        //             format: "yy-mm-dd",
        //             altFormat: "yy-mm-dd",
        //             dateFormat: "yy-mm-dd"
        //         });
        //
        // });
        CRM.$(function($) {
          $("input[name='alert_dateselect_to']").datepicker({
            format: "yy-mm-dd",
            altFormat: "yy-mm-dd",
            dateFormat: "yy-mm-dd"
          });
          $("input[name='alert_dateselect_from']").datepicker({
            format: "yy-mm-dd",
            altFormat: "yy-mm-dd",
            dateFormat: "yy-mm-dd"
          });
        });
    </script>
{/literal}
{/crmScope}
