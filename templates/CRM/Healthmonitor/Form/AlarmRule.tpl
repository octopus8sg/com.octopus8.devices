{* HEADER *}
<h1>{$error}</h1>
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

<div class="crm-section">
    <div class="label">{$form.contact_id.label}</div>
    <div class="content">{$form.contact_id.html}</div>
    <div class="clear"></div>
</div>

<div class="crm-section">
    <div class="label">{$form.code.label}</div>
    <div class="content">{$form.code.html}</div>
</div>


<div class="crm-section">
    <div class="label">{$form.sensor_id.label}</div>
    <div class="content">{$form.sensor_id.html}</div>
</div>


<div class="crm-section">
    <div class="label">{$form.rule_id.label}</div>
    <div class="content">{$form.rule_id.html}</div>
</div>


<div class="crm-section">
    <div class="label">{$form.sensor_value.label}</div>
    <div class="content">{$form.sensor_value.html}</div>
</div>

{* FOOTER *}
<div class="crm-submit-buttons">
    {include file="CRM/common/formButtons.tpl" location="bottom"}
</div>
