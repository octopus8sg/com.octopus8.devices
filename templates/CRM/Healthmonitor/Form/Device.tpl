{crmScope extensionKey='device'}
{if $action eq 8}
  {* Are you sure to delete form *}
  <h3>{ts}Delete Device{/ts}</h3>
  <div class="crm-block crm-form-block">
    <div class="crm-section">{ts 1=$myentity.title}Are you sure you wish to delete the entity with title: %1?{/ts}</div>
  </div>

  <div class="crm-submit-buttons">
    {include file="CRM/common/formButtons.tpl" location="bottom"}
  </div>
{else}

  <div class="crm-block crm-form-block">

    <div class="crm-section">
      <div class="label">{$form.name.label}</div>
      <div class="content">{$form.name.html}</div>
      <div class="clear"></div>
    </div>

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
      <div class="label">{$form.default_client.label}</div>
      <div class="content">{$form.default_client.html}</div>
      <div class="clear"></div>
    </div>

    <div class="crm-submit-buttons">
      {include file="CRM/common/formButtons.tpl" location="bottom"}
    </div>

  </div>
{/if}
{/crmScope}