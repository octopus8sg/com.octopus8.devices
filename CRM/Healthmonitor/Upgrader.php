<?php

use CRM_Healthmonitor_ExtensionUtil as E;

/**
 * Collection of upgrade steps.
 */
class CRM_Healthmonitor_Upgrader extends CRM_Healthmonitor_Upgrader_Base
{

    // By convention, functions that look like "function upgrade_NNNN()" are
    // upgrade tasks. They are executed in order (like Drupal's hook_update_N).

    /**
     * Example: Run an external SQL script when the module is installed.
     *
     */
    public function install()
    {
//    $this->executeSqlFile('sql/myinstall.sql');
        // Create the device_type and sensor option groups
        $deviceTypeOptionGroupId = civicrm_api3('OptionGroup',
            'create',
            ['name' => 'health_monitor_device_type',
                'title' => E::ts('HM Device Type')]);
        $deviceTypeOptionGroupId = $deviceTypeOptionGroupId['id'];
        civicrm_api3('OptionValue', 'create',
            ['value' => 1,
                'is_default' => '1',
                'name' => 'jelly8_smart_watch_1',
                'label' => E::ts('Jelly8 Smart Watch 1'),
                'option_group_id' => $deviceTypeOptionGroupId]);
        $sensorOptionGroupId = civicrm_api3('OptionGroup',
            'create',
            ['name' => 'health_monitor_sensor',
                'title' => E::ts('HM Sensor')]);
        $sensorOptionGroupId = $sensorOptionGroupId['id'];
        civicrm_api3('OptionValue', 'create',
            ['value' => 1,
                'is_default' => '1',
                'name' => 'heart_rate',
                'label' => E::ts('Heart Rate'),
                'option_group_id' => $sensorOptionGroupId]);
        civicrm_api3('OptionValue', 'create',
            ['value' => 2,
                'name' => 'blood_pressure',
                'label' => E::ts('Blood Pressure'),
                'option_group_id' => $sensorOptionGroupId]);
        civicrm_api3('OptionValue', 'create',
            ['value' => 3,
                'name' => 'body_temperature',
                'label' => E::ts('Body Temperature'),
                'option_group_id' => $sensorOptionGroupId]);


    }

    /**
     * Example: Work with entities usually not available during the install step.
     *
     * This method can be used for any post-install tasks. For example, if a step
     * of your installation depends on accessing an entity that is itself
     * created during the installation (e.g., a setting or a managed entity), do
     * so here to avoid order of operation problems.
     */
    // public function postInstall() {
    //  $customFieldId = civicrm_api3('CustomField', 'getvalue', array(
    //    'return' => array("id"),
    //    'name' => "customFieldCreatedViaManagedHook",
    //  ));
    //  civicrm_api3('Setting', 'create', array(
    //    'myWeirdFieldSetting' => array('id' => $customFieldId, 'weirdness' => 1),
    //  ));
    // }

    /**
     * Example: Run an external SQL script when the module is uninstalled.
     */
     public function uninstall() {
         try {
             $optionGroupId = civicrm_api3('OptionGroup', 'getvalue', ['return' => 'id', 'name' => 'health_monitor_device_type']);
             $optionValues = civicrm_api3('OptionValue', 'get', ['option_group_id' => $optionGroupId, 'options' => ['limit' => 0]]);
             foreach ($optionValues['values'] as $optionValue) {
                 civicrm_api3('OptionValue', 'delete', ['id' => $optionValue['id']]);
             }
             civicrm_api3('OptionGroup', 'delete', ['id' => $optionGroupId]);
         } catch (\CiviCRM_API3_Exception $ex) {
             // Ignore exception.
         }
         try {
             $optionGroupId = civicrm_api3('OptionGroup', 'getvalue', ['return' => 'id', 'name' => 'health_monitor_sensor']);
             $optionValues = civicrm_api3('OptionValue', 'get', ['option_group_id' => $optionGroupId, 'options' => ['limit' => 0]]);
             foreach ($optionValues['values'] as $optionValue) {
                 civicrm_api3('OptionValue', 'delete', ['id' => $optionValue['id']]);
             }
             civicrm_api3('OptionGroup', 'delete', ['id' => $optionGroupId]);
         } catch (\CiviCRM_API3_Exception $ex) {
             // Ignore exception.
         }
         //      $this->executeSqlFile('sql/myuninstall.sql');
     }

    /**
     * Example: Run a simple query when a module is enabled.
     */
    // public function enable() {
    //  CRM_Core_DAO::executeQuery('UPDATE foo SET is_active = 1 WHERE bar = "whiz"');
    // }

    /**
     * Example: Run a simple query when a module is disabled.
     */
    // public function disable() {
    //   CRM_Core_DAO::executeQuery('UPDATE foo SET is_active = 0 WHERE bar = "whiz"');
    // }

    /**
     * Example: Run a couple simple queries.
     *
     * @return TRUE on success
     * @throws Exception
     */
    // public function upgrade_4200() {
    //   $this->ctx->log->info('Applying update 4200');
    //   CRM_Core_DAO::executeQuery('UPDATE foo SET bar = "whiz"');
    //   CRM_Core_DAO::executeQuery('DELETE FROM bang WHERE willy = wonka(2)');
    //   return TRUE;
    // }


    /**
     * Example: Run an external SQL script.
     *
     * @return TRUE on success
     * @throws Exception
     */
    // public function upgrade_4201() {
    //   $this->ctx->log->info('Applying update 4201');
    //   // this path is relative to the extension base dir
    //   $this->executeSqlFile('sql/upgrade_4201.sql');
    //   return TRUE;
    // }


    /**
     * Example: Run a slow upgrade process by breaking it up into smaller chunk.
     *
     * @return TRUE on success
     * @throws Exception
     */
    // public function upgrade_4202() {
    //   $this->ctx->log->info('Planning update 4202'); // PEAR Log interface

    //   $this->addTask(E::ts('Process first step'), 'processPart1', $arg1, $arg2);
    //   $this->addTask(E::ts('Process second step'), 'processPart2', $arg3, $arg4);
    //   $this->addTask(E::ts('Process second step'), 'processPart3', $arg5);
    //   return TRUE;
    // }
    // public function processPart1($arg1, $arg2) { sleep(10); return TRUE; }
    // public function processPart2($arg3, $arg4) { sleep(10); return TRUE; }
    // public function processPart3($arg5) { sleep(10); return TRUE; }

    /**
     * Example: Run an upgrade with a query that touches many (potentially
     * millions) of records by breaking it up into smaller chunks.
     *
     * @return TRUE on success
     * @throws Exception
     */
    // public function upgrade_4203() {
    //   $this->ctx->log->info('Planning update 4203'); // PEAR Log interface

    //   $minId = CRM_Core_DAO::singleValueQuery('SELECT coalesce(min(id),0) FROM civicrm_contribution');
    //   $maxId = CRM_Core_DAO::singleValueQuery('SELECT coalesce(max(id),0) FROM civicrm_contribution');
    //   for ($startId = $minId; $startId <= $maxId; $startId += self::BATCH_SIZE) {
    //     $endId = $startId + self::BATCH_SIZE - 1;
    //     $title = E::ts('Upgrade Batch (%1 => %2)', array(
    //       1 => $startId,
    //       2 => $endId,
    //     ));
    //     $sql = '
    //       UPDATE civicrm_contribution SET foobar = whiz(wonky()+wanker)
    //       WHERE id BETWEEN %1 and %2
    //     ';
    //     $params = array(
    //       1 => array($startId, 'Integer'),
    //       2 => array($endId, 'Integer'),
    //     );
    //     $this->addTask($title, 'executeSql', $sql, $params);
    //   }
    //   return TRUE;
    // }

}
