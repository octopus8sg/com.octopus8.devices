
{* FIELD EXAMPLE: OPTION 2 (MANUAL LAYOUT)*}

<div class="crm-section">
  <div class="label">{$form.contact_id.label}</div>
  <div class="content">{$form.contact_id.html}</div>
</div>
<div class="crm-section">
  <div class="label">{$form.addressee_id.label}</div>
  <div class="content">{$form.addressee_id.html}</div>
</div>
<div class="crm-section">
  <div class="label">{$form.rule_id.label}</div>
  <div class="content">{$form.rule_id.html}</div>
</div>
<div class="crm-section">
  <div class="label">{$form.title.label}</div>
  <div class="content">{$form.title.html}</div>
</div>
<div class="crm-section">
  <div class="label">{$form.message.label}</div>
  <div class="content">{$form.message.html}</div>
</div>
<div class="crm-section">
  <div class="label">{$form.civicrm.label}</div>
  <div class="content">{$form.civicrm.html}</div>
</div>
<div class="crm-section">
  <div class="label">{$form.email.label}</div>
  <div class="content">{$form.email.html}</div>
</div>

{* FOOTER *}
<div class="crm-submit-buttons">
  {include file="CRM/common/formButtons.tpl" location="bottom"}
</div>
