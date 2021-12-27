<h3>{ts}Summary Static Data{/ts} {*{help id="id-member-intro"}*}</h3>

<table class="report">
    <tr class="columnheader-dark">
        <th scope="col">SENSORS</th>
        <th scope="col">CONTACTS WITH DEVICES</th>
        <th scope="col">DEVICES</th>
        <th scope="col">ALARM RULES</th>
        <th scope="col">ALERT RULES</th>
    </tr>

    <tr>
        <td align="right"><a href = "{crmURL p='civicrm/admin/options/o8_device_sensor'}">{$sensorsCount}</a></td>
        <td align="right">{$deviceUserCount}</td>
        <td align="right"><a href = "{crmURL p='civicrm/devices/search'}">{$deviceCount}</a></td>
        <td align="right">{$alarmRuleCount}</td>
        <td align="right">{$alertRuleCount}</td>
    </tr>
</table>
<div class="spacer"></div>
<h3>{ts}Summary Transactional Data{/ts} {*{help id="id-member-intro"}*}</h3>

<table class="report">
    <tr class="columnheader-dark">
        <th scope="col"></th>
        <th scope="col">LAST YEAR</th>
        <th scope="col">THIS YEAR</th>
        <th scope="col">LAST MONTH</th>
        <th scope="col">THIS MONTH</th>
    </tr>

    <tr>
        <td font-size14pt label><strong>Data</strong></td>
        <td align="right">{$last_year_datas_Count}</td>
        <td align="right">{$this_year_datas_Count}</td>
        <td align="right">{$last_month_datas_Count}</td>
        <td align="right">{$this_month_datas_Count}</td>
    </tr>
    <tr>
        <td font-size14pt label><strong>Alarms</strong></td>
        <td align="right">{$last_year_alarms_Count}</td>
        <td align="right">{$this_year_alarms_Count}</td>
        <td align="right">{$last_month_alarms_Count}</td>
        <td align="right">{$this_month_alarms_Count}</td>
    </tr>
    <tr>
        <td font-size14pt label><strong>Alerts</strong></td>
        <td align="right">{$last_year_alerts_Count}</td>
        <td align="right">{$this_year_alerts_Count}</td>
        <td align="right">{$last_month_alerts_Count}</td>
        <td align="right">{$this_month_alerts_Count}</td>
    </tr>
</table>