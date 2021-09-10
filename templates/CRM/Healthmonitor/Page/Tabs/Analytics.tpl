<h3>Device Data Chart</h3>
<div class="clear"></div>
{include file="CRM/Healthmonitor/Form/ChartFilter.tpl"}
<div class="clear"></div>
<div style="display: block; height: 300px !important; width: 100% !important;">
<canvas id="ChartLine" style="display: block; width: 100% !important;"></canvas>
</div>
<div class="clear"></div>

{crmScript ext=com.octopus8.devices file=js/Chart.bundle.min.js}
{crmScript ext=com.octopus8.devices file=js/analytics.js}
