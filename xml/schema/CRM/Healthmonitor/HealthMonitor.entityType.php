<?php
// This file declares a new entity type. For more details, see "hook_civicrm_entityTypes" at:
// https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
return [
  [
    'name' => 'HealthMonitor',
    'class' => 'CRM_Healthmonitor_DAO_HealthMonitor',
    'table' => 'civicrm_health_monitor',
  ],
];
