<?php

use CRM_Devices_ExtensionUtil as E;

/**
 * Collection of upgrade steps.
 */
class CRM_Devices_Upgrader extends CRM_Devices_Upgrader_Base
{

    // By convention, functions that look like "function upgrade_NNNN()" are
    // upgrade tasks. They are executed in order (like Drupal's hook_update_N).
    protected $user1;
    protected $user2;
    protected $user3;
    protected $user4;
    protected $user5;
    protected $device_type1;
    protected $sensor_type1; //heart
    protected $sensor_type2; //weight
    protected $sensor_type3; //temp
    protected $sensor_type4; //diast
    protected $sensor_type5; //syst
    protected $sensor_type6; //height
    protected $sensor_type7; //lat
    protected $sensor_type8; //lon
    protected $sensor_type9; //oxy

    /**
     * Example: Run an external SQL script when the module is installed.
     *
     */
    public function install()
    {
        $this->uninstall();
        // Create the device_type and sensor option groups
        $deviceTypeOptionGroupId = civicrm_api3('OptionGroup',
            'create',
            ['name' => 'o8_device_type',
                'title' => E::ts('Device Type')]);
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
            ['name' => 'o8_device_sensor',
                'title' => E::ts('Device Sensor')]);
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
        $sensor_type6 = civicrm_api3('OptionValue', 'create',
            ['value' => 6,
                'name' => 'height',
                'label' => E::ts('Height'),
                'option_group_id' => $sensorOptionGroupId]);
        $sensor_type7 = civicrm_api3('OptionValue', 'create',
            ['value' => 7,
                'name' => 'latitude',
                'label' => E::ts('Latitude'),
                'option_group_id' => $sensorOptionGroupId]);
        $sensor_type8 = civicrm_api3('OptionValue', 'create',
            ['value' => 8,
                'name' => 'longitude',
                'label' => E::ts('Longitude'),
                'option_group_id' => $sensorOptionGroupId]);
        $sensor_type9 = civicrm_api3('OptionValue', 'create',
            ['value' => 9,
                'name' => 'oxygen',
                'label' => E::ts('Oxygen'),
                'option_group_id' => $sensorOptionGroupId]);
        $this->sensor_type1 = $sensor_type1;
        $this->sensor_type2 = $sensor_type2;
        $this->sensor_type3 = $sensor_type3;
        $this->sensor_type4 = $sensor_type4;
        $this->sensor_type5 = $sensor_type5;
        $this->sensor_type6 = $sensor_type6;
        $this->sensor_type7 = $sensor_type7;
        $this->sensor_type8 = $sensor_type8;
        $this->sensor_type9 = $sensor_type9;

        $ruleTypeGroupId = civicrm_api3('OptionGroup',
            'create',
            ['name' => 'o8_device_rule_type',
                'title' => E::ts('Alarm Rule Type')]);
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

//        $this->createFor5Users();

    }

    public function createFor5Users()
    {
        $users = civicrm_api3('Contact', 'get', [
            'sequential' => 1,
            'return' => ["id"],
            'contact_type' => "Individual",
            'deceased_date' => ['IS NULL' => 1],
        ]);
        if (!empty($users['values'][0])) {
            $user = $users['values'][0];
            $this->createforauser($user);
//                        CRM_Core_Error::debug_var('user', $user);
        } else {
            return;
        }
        if (!empty($users['values'][1])) {
            $user = $users['values'][1];
            $this->createforauser($user);
//                        CRM_Core_Error::debug_var('user', $user);
        } else {
            return;
        }
        if (!empty($users['values'][2])) {
            $user = $users['values'][2];
            $this->createforauser($user);
//                        CRM_Core_Error::debug_var('user', $user);
        } else {
            return;
        }
        if (!empty($users['values'][3])) {
            $user = $users['values'][3];
            $this->createforauser($user);
//                        CRM_Core_Error::debug_var('user', $user);
        } else {
            return;
        }
        if (!empty($users['values'][4])) {
            $user = $users['values'][4];
            $this->createforauser($user);
//                        CRM_Core_Error::debug_var('user', $user);
        } else {
            return;
        }
    }

    //Create data for a user
    function createforauser($user)
    {
        $contact_id = $user['contact_id'];
        $device_type1 = $this->device_type1;
        $sensor_type1 = $this->sensor_type1;
        $sensor_type2 = $this->sensor_type2;
        $sensor_type3 = $this->sensor_type3;
        $sensor_type4 = $this->sensor_type4;
        $sensor_type5 = $this->sensor_type5;
        $this->generateAlarmRule('slow', $contact_id, $sensor_type1, 50, "le");
        $this->generateAlarmRule('recovery', $contact_id, $sensor_type1, 80);
        $this->generateAlarmRule('manageble', $contact_id, $sensor_type1, 100);
        $this->generateAlarmRule('challenge', $contact_id, $sensor_type1, 120);
        $this->generateAlarmRule('burn', $contact_id, $sensor_type1, 140);
        $this->generateAlarmRule('danger', $contact_id, $sensor_type1, 160);
        $this->generateAlarmRule('skinny', $contact_id, $sensor_type2, 50, "le");
        $this->generateAlarmRule('fatty', $contact_id, $sensor_type2, 100);
        $this->generateAlarmRule('hypothermia', $contact_id, $sensor_type3, 35, "le");
        $this->generateAlarmRule('fever', $contact_id, $sensor_type3, 37.1);
        $this->generateAlarmRule('hyperthermia', $contact_id, $sensor_type3, 37.9);
        $this->generateAlarmRule('diast_hypotension', $contact_id, $sensor_type4, 60.01, "le");
        $this->generateAlarmRule('diast_hypertension', $contact_id, $sensor_type4, 90.01);
        $this->generateAlarmRule('syst_hypotension', $contact_id, $sensor_type5, 90.01, "le");
        $this->generateAlarmRule('syst_hypertension', $contact_id, $sensor_type5, 140.01);
        $this->generateOneMonthData($device_type1,
            $sensor_type1,
            49,
            161, $contact_id);
        $this->generateOneMonthData($device_type1,
            $sensor_type2,
            49.9,
            100.1,
            $contact_id);
        $this->generateOneMonthData($device_type1,
            $sensor_type3,
            34.9,
            38.1,
            $contact_id);
        $this->generateOneMonthData($device_type1,
            $sensor_type4,
            59.01,
            90.02,
            $contact_id);
        $this->generateOneMonthData($device_type1,
            $sensor_type5,
            89.01,
            140.02,
            $contact_id);

    }

    /**
     * Example: Run an external SQL script when the module is uninstalled.
     */

    public function uninstall()
    {
        try {
            $optionGroupId = civicrm_api3('OptionGroup',
                'getvalue', ['return' => 'id',
                    'name' => 'o8_device_type']);
            $optionValues = civicrm_api3('OptionValue',
                'get', ['option_group_id' => $optionGroupId, 'options' => ['limit' => 0]]);
            foreach ($optionValues['values'] as $optionValue) {
                civicrm_api3('OptionValue', 'delete', ['id' => $optionValue['id']]);
            }
            civicrm_api3('OptionGroup', 'delete', ['id' => $optionGroupId]);
        } catch (\CiviCRM_API3_Exception $ex) {
            // Ignore exception.
        }
        try {
            $optionGroupId = civicrm_api3('OptionGroup',
                'getvalue', ['return' => 'id', 'name' => 'o8_device_sensor']);
            $optionValues = civicrm_api3('OptionValue',
                'get', ['option_group_id' => $optionGroupId, 'options' => ['limit' => 0]]);
            foreach ($optionValues['values'] as $optionValue) {
                civicrm_api3('OptionValue', 'delete', ['id' => $optionValue['id']]);
            }
            civicrm_api3('OptionGroup', 'delete', ['id' => $optionGroupId]);
        } catch (\CiviCRM_API3_Exception $ex) {
            // Ignore exception.
        }

        try {
            $optionGroupId = civicrm_api3('OptionGroup',
                'getvalue', ['return' => 'id', 'name' => 'o8_device_rule_type']);
            $optionValues = civicrm_api3('OptionValue',
                'get', ['option_group_id' => $optionGroupId, 'options' => ['limit' => 0]]);
            foreach ($optionValues['values'] as $optionValue) {
                civicrm_api3('OptionValue', 'delete', ['id' => $optionValue['id']]);
            }
            civicrm_api3('OptionGroup', 'delete', ['id' => $optionGroupId]);
        } catch (\CiviCRM_API3_Exception $ex) {
            // Ignore exception.
        }

    }

    public function makeRules()
    {
        $contact_id = CRM_Utils_Request::retrieve('cid', 'Positive');
//        CRM_Core_Error::debug_var('contact_id', $contact_id);
        $sensor_type1 = 'heart_rate';
        $sensor_type2 = 'body_weight';
        $sensor_type3 = 'body_temperature';
        $sensor_type4 = 'blood_pressure_diastolic';
        $sensor_type5 = 'blood_pressure_systolic';
//        CRM_Core_Error::debug_var('sensor_type5', sensor_type5);
        CRM_Healthmonitor_Upgrader::generateAlarmRuleSensorName('slow', $contact_id, $sensor_type1, 50, "le");
        CRM_Healthmonitor_Upgrader::generateAlarmRuleSensorName('recovery', $contact_id, $sensor_type1, 80);
        CRM_Healthmonitor_Upgrader::generateAlarmRuleSensorName('manageble', $contact_id, $sensor_type1, 100);
        CRM_Healthmonitor_Upgrader::generateAlarmRuleSensorName('challenge', $contact_id, $sensor_type1, 120);
        CRM_Healthmonitor_Upgrader::generateAlarmRuleSensorName('burn', $contact_id, $sensor_type1, 140);
        CRM_Healthmonitor_Upgrader::generateAlarmRuleSensorName('danger', $contact_id, $sensor_type1, 160);
        CRM_Healthmonitor_Upgrader::generateAlarmRuleSensorName('skinny', $contact_id, $sensor_type2, 50, "le");
        CRM_Healthmonitor_Upgrader::generateAlarmRuleSensorName('fatty', $contact_id, $sensor_type2, 100);
        CRM_Healthmonitor_Upgrader::generateAlarmRuleSensorName('hypothermia', $contact_id, $sensor_type3, 35, "le");
        CRM_Healthmonitor_Upgrader::generateAlarmRuleSensorName('fever', $contact_id, $sensor_type3, 37.1);
        CRM_Healthmonitor_Upgrader::generateAlarmRuleSensorName('hyperthermia', $contact_id, $sensor_type3, 37.9);
        CRM_Healthmonitor_Upgrader::generateAlarmRuleSensorName('diast_hypotension', $contact_id, $sensor_type4, 60.01, "le");
        CRM_Healthmonitor_Upgrader::generateAlarmRuleSensorName('diast_hypertension', $contact_id, $sensor_type4, 90.01);
        CRM_Healthmonitor_Upgrader::generateAlarmRuleSensorName('syst_hypotension', $contact_id, $sensor_type5, 90.01, "le");
        CRM_Healthmonitor_Upgrader::generateAlarmRuleSensorName('syst_hypertension', $contact_id, $sensor_type5, 140.01);
    }

    public function makeData()
    {
        $contact_id = CRM_Utils_Request::retrieve('cid', 'Positive');
        $device_type1 = 'jelly8_smart_watch_1';
        $device_type2 = 'jelly8_smart_weight_1';
        $device_type3 = 'jelly8_smart_height_1';
        $device_type4 = 'jelly8_smart_bpm_1';
        $device_type5 = 'jelly8_smart_bpm_1';
        $sensor_type1 = 'heart_rate';
        $sensor_type2 = 'body_weight';
        $sensor_type3 = 'body_temperature';
        $sensor_type4 = 'blood_pressure_diastolic';
        $sensor_type5 = 'blood_pressure_systolic';

        CRM_Healthmonitor_Upgrader::generateOneMonthDataNamed($device_type1, $sensor_type1, 49, 161, $contact_id);
        CRM_Healthmonitor_Upgrader::generateOneMonthDataNamed($device_type2, $sensor_type2, 49.9, 100.1, $contact_id);
        CRM_Healthmonitor_Upgrader::generateOneMonthDataNamed($device_type3, $sensor_type3, 34.9, 38.1, $contact_id);
        CRM_Healthmonitor_Upgrader::generateOneMonthDataNamed($device_type4, $sensor_type4, 59.01, 90.02, $contact_id);
        CRM_Healthmonitor_Upgrader::generateOneMonthDataNamed($device_type5, $sensor_type5, 89.01, 140.02, $contact_id);
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
    public function generateAlarmRule($zone_name,
                                      $contact_id,
                                      $sensor_type,
                                      $sensor_value,
                                      $rule_id = "gt")
    {
        $sensor_type1id = $sensor_type['id'];
        $sensor_type1name = $sensor_type['values'][$sensor_type1id]['name'];
        $alarm_code = $contact_id . "_" . $zone_name . '_' . rand(10000, 99999);

        $result = civicrm_api3('AlarmRule', 'create', [
            'contact_id' => $contact_id,
            'code' => $alarm_code,
            'sensor_id' => $sensor_type1name,
            'sensor_value' => $sensor_value,
            'rule_id' => $rule_id,
            'api.AlertRule.create' => [
                'contact_id' => $contact_id,
                'addressee_id' => $contact_id,
                'rule_id' => "\$value.id",
                'code' => $contact_id . "_" . $alarm_code,
                'title' =>
                    strtoupper($zone_name . ' ' . $sensor_type1name),
                'message' => "Attention Message. Contact #" . $contact_id . " has reached the " . $zone_name . "."],
        ]);
//        CRM_Core_Error::debug_var('result1', $result);
        return $result;
    }

    public function generateAlarmRuleSensorName($zone_name,
                                                $contact_id,
                                                $sensor_name,
                                                $sensor_value,
                                                $rule_id = "gt")
    {
        $alarm_code = $contact_id . "_" . $zone_name . '_' . $sensor_name . rand(10000, 99999);
//        CRM_Core_Error::debug_var('alarm_code', $alarm_code);
        $result = civicrm_api3('AlarmRule', 'create', [
            'contact_id' => $contact_id,
            'code' => $alarm_code,
            'sensor_id' => $sensor_name,
            'sensor_value' => $sensor_value,
            'rule_id' => $rule_id,
            'api.DeviceAlertRule.create' => [
                'contact_id' => $contact_id,
                'addressee_id' => $contact_id,
                'rule_id' => "\$value.id",
                'code' => $contact_id . "_" . $alarm_code,
                'title' =>
                    strtoupper($zone_name . ' ' . $sensor_name),
                'message' => "Attention Message. Contact #" . $contact_id . " has reached the " . $zone_name . "."],
        ]);
//       CRM_Core_Error::debug_var('result1', $result);
        return $result;
    }

    public function generateOneMonthData($device_type,
                                         $sensor_type,
                                         $sensor_val_min,
                                         $sensor_val_max,
                                         $contact_id)
    {
        $device_type1id = $device_type['id'];
        $device_type1name = $device_type['values'][$device_type1id]['name'];
        $sensor_type1id = $sensor_type['id'];
        $sensor_type1name = $sensor_type['values'][$sensor_type1id]['name'];
        $device_name = $contact_id . "_" . $device_type1name . '_' . rand(10000, 99999);
        $device_name = preg_replace('/[^a-z0-9 ]/i', '', $device_name);

        $device = civicrm_api3('Device', 'create', [
            'contact_id' => $contact_id,
            'code' => $device_name,
            'device_type_id' => $device_type1name,
        ]);
//        CRM_Core_Error::debug_var('device', $device);


//        CRM_Core_Error::debug_var('device', $device);
        $time = strtotime("-32 days", time());
        $date = date("Y-m-d H:i:s", $time);
//        CRM_Core_Error::debug_var('date', $date);

        for ($i = 0; $i < 31; $i++) {
//            CRM_Core_Error::debug_var('i', $i);
            $time = strtotime("+1 day", $time);
            $date = date("Y-m-d H:i:s", $time);
//            CRM_Core_Error::debug_var('date' . $i, $date);
            if (is_float($sensor_val_min) OR is_float($sensor_val_max)) {
                $intval_min = intval($sensor_val_min * 100);
                $intval_max = intval($sensor_val_max * 100);
                $sensor_value = 0.01 * random_int($intval_min, $intval_max);
            } else {
                $sensor_value = random_int($sensor_val_min, $sensor_val_max);
            }
//            CRM_Core_Error::debug_var('date', $date);
//            CRM_Core_Error::debug_var('sensor_value', $sensor_value);

            $result = civicrm_api3('DeviceData', 'create', [
                'date' => $date,
                'sensor_value' => $sensor_value,
                'device_code' => $device_name,
                'device_id' => $device['id'],
                'contact_id' => $contact_id,
                'sensor_id' => $sensor_type1name,
            ]);
//            CRM_Core_Error::debug_var('result' . $i, $result);
        }
    }

    public function generateOneMonthDataNamed($device_type_name, $sensor_type_name, $sensor_val_min, $sensor_val_max, $contact_id)
    {
        $device_name = $contact_id . "_" . $device_type_name . '_' . rand(10000, 99999);

        $device = civicrm_api3('Device', 'create', [
            'contact_id' => $contact_id,
            'name' => $device_name,
            'device_type_id' => $device_type_name,
        ]);
//        CRM_Core_Error::debug_var('device', $device);


//        CRM_Core_Error::debug_var('device', $device);
        $time = strtotime("-32 days", time());
        $date = date("Y-m-d H:i:s", $time);
//        CRM_Core_Error::debug_var('date', $date);


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
                'sensor_id' => $sensor_type_name,
            ]);
//            CRM_Core_Error::debug_var('result1', $result);
        }
    }

    /**
     * Example: Run a simple query when a module is enabled.
     */
    public function enable()
    {
        CRM_Core_DAO::executeQuery('alter table civicrm_o8_device_alarm_rule modify sensor_value decimal(20,8) not null comment \'Sensor Value\'');
        CRM_Core_DAO::executeQuery('alter table civicrm_o8_device_data modify sensor_value decimal(20,8) not null comment \'Sensor Value\'');
    }

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
