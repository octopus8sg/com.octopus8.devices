{* HEADER *}

<div class="crm-submit-buttons">
  {include file="CRM/common/formButtons.tpl" location="top"}
</div>

{* FIELD EXAMPLE: OPTION 1 (AUTOMATIC LAYOUT) *}

<div>
  <span>{$form.contact_id.label}</span>
  <span>{$form.contact_id.html}</span>
</div>

<div>
  <span>{$form.alarm_rule_id.label}</span>
  <span>{$form.alarm_rule_id.html}</span>
</div>

<div>
  <span>{$form.health_monitor_id.label}</span>
  <span>{$form.health_monitor_id.html}</span>
</div>

{* FOOTER *}
<div class="crm-submit-buttons">
  {include file="CRM/common/formButtons.tpl" location="bottom"}
</div>
