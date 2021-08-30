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
                        <table class="form-layout searchalert-filter">
                        {/if}
                        <tbody>
                        {if isset($contactId)}
                            {else}
                            <tr>
                                <td class="label">{$form.alert_contact_id.label}</td>
                                <td>{$form.alert_contact_id.html}</td>
                            </tr>
                        {/if}
                        <tr>
                            <td class="label">{$form.alert_dateselect_from.label}</td>
                            <td>{$form.alert_dateselect_from.html}</td>
                            <td class="label">{$form.alert_dateselect_to.label}</td>
                            <td>{$form.alert_dateselect_to.html}</td>
                        </tr>
                        <tr>
                            <td class="label">{$form.alert_sensor_id.label}</td>
                            <td>{$form.alert_sensor_id.html}</td>
                            <td class="label">{$form.alert_addressee_id.label}</td>
                            <td>{$form.alert_addressee_id.html}</td>
                        </tr>
                        <tr>
                            <td class="label">{$form.alert_civicrm.label}</td>
                            <td>{$form.alert_civicrm.html}</td>
                            <td class="label">{$form.alert_email.label}</td>
                            <td>{$form.alert_email.html}</td>
                        </tr>
                        {*            <tr>*}
                        {*              <td class="label">{$form.alert_telegram.label}</td>*}
                        {*              <td>{$form.alert_rule_telegram.html}</td>*}
                        {*              <td class="label">{$form.alert_api.label}</td>*}
                        {*              <td>{$form.alert_rule_api.html}</td>*}
                        {*            </tbody>*}
                    </table>
                    <div class="crm-submit-buttons">
                        {include file="CRM/common/formButtons.tpl"}
                    </div>
            </div>
            <!- /.crm-accordion-body -->
        </div><!-- /.crm-accordion-wrapper -->
    </div><!-- /.crm-form-block -->
</div>
