<?php

use CRM_Healthmonitor_ExtensionUtil as E;

/**
 * Collection of upgrade steps.
 */
class CRM_Healthmonitor_Upgrader extends CRM_Healthmonitor_Upgrader_Base
{

    // By convention, functions that look like "function upgrade_NNNN()" are
    // upgrade tasks. They are executed in order (like Drupal's hook_update_N).
    protected $user;
    protected $device_type1;
    protected $sensor_type1; //heart
    protected $sensor_type2; //weight
    protected $sensor_type3; //temp
    protected $sensor_type4; //diast
    protected $sensor_type5; //syst

    /**
     * Example: Run an external SQL script when the module is installed.
     *
     */
    public function install()
    {
        $this->uninstall();
//    $this->executeSqlFile('sql/myinstall.sql');
        // Create the device_type and sensor option groups
        $deviceTypeOptionGroupId = civicrm_api3('OptionGroup',
            'create',
            ['name' => 'health_monitor_device_type',
                'title' => E::ts('HM Device Type')]);
        $deviceTypeOptionGroupId = $deviceTypeOptionGroupId['id'];

        $device_type1 = civicrm_api3('OptionValue', 'create',
            ['value' => 1,
                'is_default' => '1',
                'name' => 'jelly8_smart_watch_1',
                'label' => E::ts('Jelly8 Smart Watch 1'),
                'option_group_id' => $deviceTypeOptionGroupId]);
        $this->device_type1 = $device_type1;
        civicrm_api3('OptionValue', 'create',
            ['value' => 2,
                'name' => 'jelly8_smart_weight_1',
                'label' => E::ts('Jelly8 Smart Weight 1'),
                'option_group_id' => $deviceTypeOptionGroupId]);
        civicrm_api3('OptionValue', 'create',
            ['value' => 3,
                'name' => 'jelly8_smart_height_1',
                'label' => E::ts('Jelly8 Smart Height 1'),
                'option_group_id' => $deviceTypeOptionGroupId]);
        civicrm_api3('OptionValue', 'create',
            ['value' => 4,
                'name' => 'jelly8_smart_bpm_1',
                'label' => E::ts('Jelly8 Smart Blood Pressure Monitor 1'),
                'option_group_id' => $deviceTypeOptionGroupId]);


        //sensor types
        $sensorOptionGroupId = civicrm_api3('OptionGroup',
            'create',
            ['name' => 'health_monitor_sensor',
                'title' => E::ts('HM Sensor')]);
        $sensorOptionGroupId = $sensorOptionGroupId['id'];

        $sensor_type1 = civicrm_api3('OptionValue', 'create',
            ['value' => 1,
                'is_default' => '1',
                'name' => 'heart_rate',
                'label' => E::ts('Heart Rate'),
                'option_group_id' => $sensorOptionGroupId]);
        $sensor_type2 = civicrm_api3('OptionValue', 'create',
            ['value' => 2,
                'name' => 'body_weight',
                'label' => E::ts('Body Weight'),
                'option_group_id' => $sensorOptionGroupId]);
        $sensor_type3 = civicrm_api3('OptionValue', 'create',
            ['value' => 3,
                'name' => 'body_temperature',
                'label' => E::ts('Body Temperature'),
                'option_group_id' => $sensorOptionGroupId]);
        $sensor_type4 = civicrm_api3('OptionValue', 'create',
            ['value' => 4,
                'name' => 'blood_pressure_diastolic',
                'label' => E::ts('Blood Pressure Diastolic'),
                'option_group_id' => $sensorOptionGroupId]);
        $sensor_type5 = civicrm_api3('OptionValue', 'create',
            ['value' => 5,
                'name' => 'blood_pressure_systolic',
                'label' => E::ts('Blood Pressure Systolic'),
                'option_group_id' => $sensorOptionGroupId]);
        civicrm_api3('OptionValue', 'create',
            ['value' => 6,
                'name' => 'height',
                'label' => E::ts('Height'),
                'option_group_id' => $sensorOptionGroupId]);
        $this->sensor_type1 = $sensor_type1;
        $this->sensor_type2 = $sensor_type2;
        $this->sensor_type3 = $sensor_type3;
        $this->sensor_type4 = $sensor_type4;
        $this->sensor_type5 = $sensor_type5;

        $ruleTypeGroupId = civicrm_api3('OptionGroup',
            'create',
            ['name' => 'health_alert_rule_type',
                'title' => E::ts('Health Alert Rule Type')]);
        $ruleTypeGroupId = $ruleTypeGroupId['id'];

        civicrm_api3('OptionValue', 'create',
            ['value' => 1,
                'name' => 'eq',
                'description' => '=',
                'label' => E::ts('EQ'),
                'option_group_id' => $ruleTypeGroupId]);
        civicrm_api3('OptionValue', 'create',
            ['value' => 2,
                'name' => 'ne',
                'description' => '!=',
                'label' => E::ts('NE'),
                'option_group_id' => $ruleTypeGroupId]);
        civicrm_api3('OptionValue', 'create',
            ['value' => 3,
                'name' => 'lt',
                'description' => '<',
                'label' => E::ts('LT'),
                'option_group_id' => $ruleTypeGroupId]);
        civicrm_api3('OptionValue', 'create',
            ['value' => 4,
                'name' => 'le',
                'description' => '<=',
                'label' => E::ts('LE'),
                'option_group_id' => $ruleTypeGroupId]);
        civicrm_api3('OptionValue', 'create',
            ['value' => 5,
                'name' => 'gt',
                'description' => '>',
                'label' => E::ts('GT'),
                'option_group_id' => $ruleTypeGroupId]);
        civicrm_api3('OptionValue', 'create',
            ['value' => 6,
                'name' => 'ge',
                'description' => '>=',
                'label' => E::ts('GE'),
                'option_group_id' => $ruleTypeGroupId]);
        /* now create 1 device for the 1 user
        and create data for 1 last month for this user
        */
        $users = civicrm_api3('User', 'get', [
            'sequential' => 1,
            'return' => ["contact_id"],
            'id' => 1,
        ]);
        $user = $users['values'][0];
        $this->user = $user;

//        $device_type1


    }

    /**
     * Example: Work with entities usually not available during the install step.
     *
     * This method can be used for any post-install tasks. For example, if a step
     * of your installation depends on accessing an entity that is itself
     * created during the installation (e.g., a setting or a managed entity), do
     * so here to avoid order of operation problems.
     */
    public function postInstall()
    {
        if (!empty($this->user)) {
            $user = $this->user;
//            CRM_Core_Error::debug_var('user', $user);
            $contact_id = $user['contact_id'];
            $device_type1 = $this->device_type1;
            $sensor_type1 = $this->sensor_type1;
            $sensor_type2 = $this->sensor_type2;
            $sensor_type3 = $this->sensor_type3;
            $sensor_type4 = $this->sensor_type4;
            $sensor_type5 = $this->sensor_type5;
            $this->generateAlertRule('recovery', $contact_id, $sensor_type1, 80);
            $this->generateAlertRule('manageble', $contact_id, $sensor_type1, 100);
            $this->generateAlertRule('challenge', $contact_id, $sensor_type1, 120);
            $this->generateAlertRule('burn', $contact_id, $sensor_type1, 140);
            $this->generateAlertRule('danger', $contact_id, $sensor_type1, 160);
            $this->generateAlertRule('skinny', $contact_id, $sensor_type2, 50, "le");
            $this->generateAlertRule('fatty', $contact_id, $sensor_type2, 100);
            $this->generateAlertRule('hypothermia', $contact_id, $sensor_type3, 35, "le");
            $this->generateAlertRule('fever', $contact_id, $sensor_type3, 37.1);
            $this->generateAlertRule('hyperthermia', $contact_id, $sensor_type3, 37.9);
            $this->generateAlertRule('diast_hypotension', $contact_id, $sensor_type4, 60.01,"le");
            $this->generateAlertRule('diast_hypertension', $contact_id, $sensor_type4, 90.01);
            $this->generateAlertRule('syst_hypotension', $contact_id, $sensor_type5, 90.01, "le");
            $this->generateAlertRule('syst_hypertension', $contact_id, $sensor_type5, 140.01);
            $this->generateOneMonthData($device_type1, $sensor_type1, 55, 65, $contact_id);
            $this->generateOneMonthData($device_type1, $sensor_type2, 69.9, 73.3, $contact_id);
            $this->generateOneMonthData($device_type1, $sensor_type3, 35.5, 37.3, $contact_id);
            $this->generateOneMonthData($device_type1, $sensor_type4, 59.01, 90.02, $contact_id);
            $this->generateOneMonthData($device_type1, $sensor_type5, 89.01, 140.02, $contact_id);
        } else {
            return;
        }

    }

    /**
     * Example: Run an external SQL script when the module is uninstalled.
     */
    public function uninstall()
    {
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

        try {
            $optionGroupId = civicrm_api3('OptionGroup', 'getvalue', ['return' => 'id', 'name' => 'health_alert_rule_type']);
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
     * @param $zone_name
     * @param $sensor_type
     * @param $rule_id
     * @param $sensor_value
     * @param $contact_id
     * @throws CiviCRM_API3_Exception
     * The proc creates 1 device, 7 rules and 31 day sensor values
     */
    public function generateAlertRule($zone_name, $contact_id, $sensor_type, $sensor_value, $rule_id = "gt")
        /**
         * @param $device_type
         * @param $sensor_type
         * @param $sensor_type2
         * @param $sensor_type3
         * @param $contact_id
         * @throws CiviCRM_API3_Exception
         * The proc creates 1 device, 7 rules and 31 day sensor values
         */
    {
        $sensor_type1id = $sensor_type['id'];
        $sensor_type1name = $sensor_type['values'][$sensor_type1id]['name'];
        $alert_code = $contact_id . "_" . $zone_name . '_' . rand(10000, 99999);

        $result = civicrm_api3('HealthAlertRule', 'create', [
            'contact_id' => $contact_id,
            'code' => $alert_code,
            'sensor_id' => $sensor_type1name,
            'sensor_value' => $sensor_value,
            'rule_id' => $rule_id,
            'api.HealthAlarmRule.create' => [
                'contact_id' => $contact_id,
                'addressee_id' => $contact_id,
                'rule_id' => "\$value.id",
                'code' => $contact_id . "_" . $alert_code,
                'title' =>
                    $zone_name,
                'message' => "Attention Message. Contact #" . $contact_id .  " has reached the " . $zone_name . "."],
        ]);
        CRM_Core_Error::debug_var('result1', $result);
        return $result;
    }

    public function generateOneMonthData($device_type, $sensor_type, $sensor_val_min, $sensor_val_max, $contact_id)
    {
        $device_type1id = $device_type['id'];
        $device_type1name = $device_type['values'][$device_type1id]['name'];
        $sensor_type1id = $sensor_type['id'];
        $sensor_type1name = $sensor_type['values'][$sensor_type1id]['name'];
        $device_name = $contact_id . "_" . $device_type1name . '_' . rand(10000, 99999);

        $device = civicrm_api3('Device', 'create', [
            'contact_id' => $contact_id,
            'name' => $device_name,
            'device_type_id' => $device_type1name,
        ]);
//        CRM_Core_Error::debug_var('device', $device);


        CRM_Core_Error::debug_var('device', $device);
        $time = strtotime("-32 days", time());
        $date = date("Y-m-d H:i:s", $time);
        CRM_Core_Error::debug_var('date', $date);


        for ($i = 0; $i < 31; $i++) {
            $time = strtotime("+1 day", $time);
            $date = date("Y-m-d H:i:s", $time);
            if (is_float($sensor_val_min) OR is_float($sensor_val_max)) {
                $intval_min = intval($sensor_val_min * 100);
                $intval_max = intval($sensor_val_max * 100);
                $sensor_value = 0.01 * random_int($intval_min, $intval_max);
            } else {
                $sensor_value = random_int($sensor_val_min, $sensor_val_max);
            }
//            CRM_Core_Error::debug_var('date', $date);
//            CRM_Core_Error::debug_var('i', $i);

            $result = civicrm_api3('HealthMonitor', 'create', [
                'date' => $date,
                'sensor_value' => $sensor_value,
                'device_code' => $device_name,
                'contact_id' => $contact_id,
                'sensor_id' => $sensor_type1name,
            ]);
//            CRM_Core_Error::debug_var('result1', $result);
        }
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
