<?php

/**
 * @package CRM
 * @copyright CiviCRM LLC https://civicrm.org/licensing
 *
 * Generated from com.octopus8.healthmonitor/xml/schema/CRM/Healthmonitor/HealthAlarm.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:70b4178fc29680e14694e65cd5e20225)
 */
use CRM_Healthmonitor_ExtensionUtil as E;

/**
 * Database access object for the HealthAlarm entity.
 */
class CRM_Healthmonitor_DAO_HealthAlarm extends CRM_Core_DAO {
  const EXT = E::LONG_NAME;
  const TABLE_ADDED = '';

  /**
   * Static instance to hold the table name.
   *
   * @var string
   */
  public static $_tableName = 'civicrm_health_alarm';

  /**
   * Should CiviCRM log any modifications to this table in the civicrm_log table.
   *
   * @var bool
   */
  public static $_log = TRUE;

  /**
   * Unique HealthAlarm ID
   *
   * @var int
   */
  public $id;

  /**
   * FK to Contact
   *
   * @var int
   */
  public $contact_id;

  /**
   * FK to Health Alert Data
   *
   * @var int
   */
  public $health_alert_id;

  /**
   * FK to Health Alarm Rule
   *
   * @var int
   */
  public $alarm_rule_id;

  /**
   * CiviCRM note created
   *
   * @var datetime
   */
  public $civicrm;

  /**
   * Email sent
   *
   * @var datetime
   */
  public $email;

  /**
   * SMS sent
   *
   * @var datetime
   */
  public $sms;

  /**
   * API alarm sent
   *
   * @var datetime
   */
  public $api;

  /**
   * Class constructor.
   */
  public function __construct() {
    $this->__table = 'civicrm_health_alarm';
    parent::__construct();
  }

  /**
   * Returns localized title of this entity.
   *
   * @param bool $plural
   *   Whether to return the plural version of the title.
   */
  public static function getEntityTitle($plural = FALSE) {
    return $plural ? E::ts('Health Alarms') : E::ts('Health Alarm');
  }

  /**
   * Returns foreign keys and entity references.
   *
   * @return array
   *   [CRM_Core_Reference_Interface]
   */
  public static function getReferenceColumns() {
    if (!isset(Civi::$statics[__CLASS__]['links'])) {
      Civi::$statics[__CLASS__]['links'] = static::createReferenceColumns(__CLASS__);
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'contact_id', 'civicrm_contact', 'id');
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'health_alert_id', 'civicrm_health_alert', 'id');
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'alarm_rule_id', 'civicrm_health_alarm_rule', 'id');
      CRM_Core_DAO_AllCoreTables::invoke(__CLASS__, 'links_callback', Civi::$statics[__CLASS__]['links']);
    }
    return Civi::$statics[__CLASS__]['links'];
  }

  /**
   * Returns all the column names of this table
   *
   * @return array
   */
  public static function &fields() {
    if (!isset(Civi::$statics[__CLASS__]['fields'])) {
      Civi::$statics[__CLASS__]['fields'] = [
        'id' => [
          'name' => 'id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => E::ts('Unique HealthAlarm ID'),
          'required' => TRUE,
          'where' => 'civicrm_health_alarm.id',
          'table_name' => 'civicrm_health_alarm',
          'entity' => 'HealthAlarm',
          'bao' => 'CRM_Healthmonitor_DAO_HealthAlarm',
          'localizable' => 0,
          'html' => [
            'type' => 'Number',
          ],
          'readonly' => TRUE,
          'add' => NULL,
        ],
        'contact_id' => [
          'name' => 'contact_id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => E::ts('FK to Contact'),
          'where' => 'civicrm_health_alarm.contact_id',
          'table_name' => 'civicrm_health_alarm',
          'entity' => 'HealthAlarm',
          'bao' => 'CRM_Healthmonitor_DAO_HealthAlarm',
          'localizable' => 0,
          'FKClassName' => 'CRM_Contact_DAO_Contact',
          'add' => NULL,
        ],
        'health_alert_id' => [
          'name' => 'health_alert_id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => E::ts('FK to Health Alert Data'),
          'where' => 'civicrm_health_alarm.health_alert_id',
          'table_name' => 'civicrm_health_alarm',
          'entity' => 'HealthAlarm',
          'bao' => 'CRM_Healthmonitor_DAO_HealthAlarm',
          'localizable' => 0,
          'FKClassName' => 'CRM_Healthmonitor_DAO_HealthAlert',
          'add' => NULL,
        ],
        'alarm_rule_id' => [
          'name' => 'alarm_rule_id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => E::ts('FK to Health Alarm Rule'),
          'where' => 'civicrm_health_alarm.alarm_rule_id',
          'table_name' => 'civicrm_health_alarm',
          'entity' => 'HealthAlarm',
          'bao' => 'CRM_Healthmonitor_DAO_HealthAlarm',
          'localizable' => 0,
          'FKClassName' => 'CRM_Healthmonitor_DAO_HealthAlarmRule',
          'add' => NULL,
        ],
        'civicrm' => [
          'name' => 'civicrm',
          'type' => CRM_Utils_Type::T_DATE + CRM_Utils_Type::T_TIME,
          'title' => E::ts('Sivicrm'),
          'description' => E::ts('CiviCRM note created'),
          'import' => TRUE,
          'where' => 'civicrm_health_alarm.civicrm',
          'export' => TRUE,
          'table_name' => 'civicrm_health_alarm',
          'entity' => 'HealthAlarm',
          'bao' => 'CRM_Healthmonitor_DAO_HealthAlarm',
          'localizable' => 0,
          'add' => NULL,
        ],
        'email' => [
          'name' => 'email',
          'type' => CRM_Utils_Type::T_DATE + CRM_Utils_Type::T_TIME,
          'title' => E::ts('Email'),
          'description' => E::ts('Email sent'),
          'import' => TRUE,
          'where' => 'civicrm_health_alarm.email',
          'export' => TRUE,
          'table_name' => 'civicrm_health_alarm',
          'entity' => 'HealthAlarm',
          'bao' => 'CRM_Healthmonitor_DAO_HealthAlarm',
          'localizable' => 0,
          'add' => NULL,
        ],
        'sms' => [
          'name' => 'sms',
          'type' => CRM_Utils_Type::T_DATE + CRM_Utils_Type::T_TIME,
          'title' => E::ts('Sms'),
          'description' => E::ts('SMS sent'),
          'import' => TRUE,
          'where' => 'civicrm_health_alarm.sms',
          'export' => TRUE,
          'table_name' => 'civicrm_health_alarm',
          'entity' => 'HealthAlarm',
          'bao' => 'CRM_Healthmonitor_DAO_HealthAlarm',
          'localizable' => 0,
          'add' => NULL,
        ],
        'api' => [
          'name' => 'api',
          'type' => CRM_Utils_Type::T_DATE + CRM_Utils_Type::T_TIME,
          'title' => E::ts('Api'),
          'description' => E::ts('API alarm sent'),
          'import' => TRUE,
          'where' => 'civicrm_health_alarm.api',
          'export' => TRUE,
          'table_name' => 'civicrm_health_alarm',
          'entity' => 'HealthAlarm',
          'bao' => 'CRM_Healthmonitor_DAO_HealthAlarm',
          'localizable' => 0,
          'add' => NULL,
        ],
      ];
      CRM_Core_DAO_AllCoreTables::invoke(__CLASS__, 'fields_callback', Civi::$statics[__CLASS__]['fields']);
    }
    return Civi::$statics[__CLASS__]['fields'];
  }

  /**
   * Return a mapping from field-name to the corresponding key (as used in fields()).
   *
   * @return array
   *   Array(string $name => string $uniqueName).
   */
  public static function &fieldKeys() {
    if (!isset(Civi::$statics[__CLASS__]['fieldKeys'])) {
      Civi::$statics[__CLASS__]['fieldKeys'] = array_flip(CRM_Utils_Array::collect('name', self::fields()));
    }
    return Civi::$statics[__CLASS__]['fieldKeys'];
  }

  /**
   * Returns the names of this table
   *
   * @return string
   */
  public static function getTableName() {
    return self::$_tableName;
  }

  /**
   * Returns if this table needs to be logged
   *
   * @return bool
   */
  public function getLog() {
    return self::$_log;
  }

  /**
   * Returns the list of fields that can be imported
   *
   * @param bool $prefix
   *
   * @return array
   */
  public static function &import($prefix = FALSE) {
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'health_alarm', $prefix, []);
    return $r;
  }

  /**
   * Returns the list of fields that can be exported
   *
   * @param bool $prefix
   *
   * @return array
   */
  public static function &export($prefix = FALSE) {
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'health_alarm', $prefix, []);
    return $r;
  }

  /**
   * Returns the list of indices
   *
   * @param bool $localize
   *
   * @return array
   */
  public static function indices($localize = TRUE) {
    $indices = [];
    return ($localize && !empty($indices)) ? CRM_Core_DAO_AllCoreTables::multilingualize(__CLASS__, $indices) : $indices;
  }

}
