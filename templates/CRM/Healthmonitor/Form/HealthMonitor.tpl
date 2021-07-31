{crmScope extensionKey='healthmonitor'}
{if $action eq 8}
  {* Are you sure to delete form *}
  <h3>{ts}Delete Entity{/ts}</h3>
  <div class="crm-block crm-form-block">
    <div class="crm-section">{ts 1=$healthmonitor.title}Are you sure you wish to delete the entity for device: %1?{/ts}</div>
  </div>

  <div class="crm-submit-buttons">
    {include file="CRM/common/formButtons.tpl" location="bottom"}
  </div>
{else}

  <div class="crm-block crm-form-block">

    <div class="crm-section">
      <div class="label">{$form.contact_id.label}</div>
      <div class="content">{$form.contact_id.html}</div>
      <div class="clear"></div>
    </div>

    <div class="crm-section">

      <div class="label">{$form.device_type_id.label}</div>
      <div class="content">{$form.device_type_id.html}</div>
      <div class="clear"></div>
    </div>

    <div class="crm-section">
{*      device id*}
      <div class="label">{$form.device_id.label}</div>
      <div class="content">{$form.device_id.html}</div>
      <div class="clear"></div>
    </div>

    <div class="crm-section">
      <div class="label">{$form.date.label}</div>
      <div class="content">{$form.date.html}</div>
      <div class="clear"></div>
    </div>

    <div class="crm-section">
      <div class="label">{$form.sensor_id.label}</div>
      <div class="content">{$form.sensor_id.html}</div>
      <div class="clear"></div>
    </div>

    <div class="crm-section">
      <div class="label">{$form.health_value.label}</div>
      <div class="content">{$form.health_value.html}</div>
      <div class="clear"></div>
    </div>

    <div class="crm-submit-buttons">
      {include file="CRM/common/formButtons.tpl" location="bottom"}
    </div>

  </div>
{/if}
{/crmScope}