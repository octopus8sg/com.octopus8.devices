{* HEADER *}

<div class="crm-submit-buttons">
{include file="CRM/common/formButtons.tpl" location="top"}
</div>

{* FIELD EXAMPLE: OPTION 1 (AUTOMATIC LAYOUT) *}

{foreach from=$elementNames item=elementName}
  <div class="crm-section">
    <div class="label">{$form.$elementName.label}</div>
    <div class="content">{$form.$elementName.html}</div>
    <div class="clear"></div>
  </div>
{/foreach}

{* FIELD EXAMPLE: OPTION 2 (MANUAL LAYOUT)*}

  <div>
    <span>{$form.contact_id.label}</span>
    <span>{$form.contact_id.html}</span>
  </div>


  <div>
    <span>{$form.sensor_id.label}</span>
    <span>{$form.sensor_id.html}</span>
  </div>


  <div>
    <span>{$form.rule_id.label}</span>
    <span>{$form.rule_id.html}</span>
  </div>


  <div>
    <span>{$form.sensor_value.label}</span>
    <span>{$form.sensor_value.html}</span>
  </div>

{* FOOTER *}
<div class="crm-submit-buttons">
{include file="CRM/common/formButtons.tpl" location="bottom"}
</div>