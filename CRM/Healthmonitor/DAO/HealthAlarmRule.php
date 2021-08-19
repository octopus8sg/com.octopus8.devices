<?php

/**
 * @package CRM
 * @copyright CiviCRM LLC https://civicrm.org/licensing
 *
 * Generated from com.octopus8.healthmonitor/xml/schema/CRM/Healthmonitor/HealthAlarmRule.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:ddeda03032a41ad44e74dfccfc939d52)
 */
use CRM_Healthmonitor_ExtensionUtil as E;

/**
 * Database access object for the HealthAlarmRule entity.
 */
class CRM_Healthmonitor_DAO_HealthAlarmRule extends CRM_Core_DAO {
  const EXT = E::LONG_NAME;
  const TABLE_ADDED = '';

  /**
   * Static instance to hold the table name.
   *
   * @var string
   */
  public static $_tableName = 'civicrm_health_alarm_rule';

  /**
   * Should CiviCRM log any modifications to this table in the civicrm_log table.
   *
   * @var bool
   */
  public static $_log = TRUE;

  /**
   * Unique HealthAlarmRule ID
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
   * Alert Name
   *
   * @var string
   */
  public $name;

  /**
   * FK to Address Contact
   *
   * @var int
   */
  public $addressee_id;

  /**
   * FK to Alert
   *
   * @var int
   */
  public $alert_id;

  /**
   * Class constructor.
   */
  public function __construct() {
    $this->__table = 'civicrm_health_alarm_rule';
    parent::__construct();
  }

  /**
   * Returns localized title of this entity.
   *
   * @param bool $plural
   *   Whether to return the plural version of the title.
   */
  public static function getEntityTitle($plural = FALSE) {
    return $plural ? E::ts('Health Alarm Rules') : E::ts('Health Alarm Rule');
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
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'addressee_id', 'civicrm_contact', 'id');
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'alert_id', 'civicrm_health_alert', 'id');
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
          'description' => E::ts('Unique HealthAlarmRule ID'),
          'required' => TRUE,
          'where' => 'civicrm_health_alarm_rule.id',
          'table_name' => 'civicrm_health_alarm_rule',
          'entity' => 'HealthAlarmRule',
          'bao' => 'CRM_Healthmonitor_DAO_HealthAlarmRule',
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
          'where' => 'civicrm_health_alarm_rule.contact_id',
          'table_name' => 'civicrm_health_alarm_rule',
          'entity' => 'HealthAlarmRule',
          'bao' => 'CRM_Healthmonitor_DAO_HealthAlarmRule',
          'localizable' => 0,
          'FKClassName' => 'CRM_Contact_DAO_Contact',
          'add' => NULL,
        ],
        'name' => [
          'name' => 'name',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => E::ts('Name'),
          'description' => E::ts('Alert Name'),
          'required' => TRUE,
          'maxlength' => 255,
          'size' => CRM_Utils_Type::HUGE,
          'import' => TRUE,
          'where' => 'civicrm_health_alarm_rule.name',
          'export' => TRUE,
          'table_name' => 'civicrm_health_alarm_rule',
          'entity' => 'HealthAlarmRule',
          'bao' => 'CRM_Healthmonitor_DAO_HealthAlarmRule',
          'localizable' => 0,
          'add' => NULL,
        ],
        'addressee_id' => [
          'name' => 'addressee_id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => E::ts('FK to Address Contact'),
          'where' => 'civicrm_health_alarm_rule.addressee_id',
          'table_name' => 'civicrm_health_alarm_rule',
          'entity' => 'HealthAlarmRule',
          'bao' => 'CRM_Healthmonitor_DAO_HealthAlarmRule',
          'localizable' => 0,
          'FKClassName' => 'CRM_Contact_DAO_Contact',
          'add' => NULL,
        ],
        'alert_id' => [
          'name' => 'alert_id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => E::ts('FK to Alert'),
          'where' => 'civicrm_health_alarm_rule.alert_id',
          'table_name' => 'civicrm_health_alarm_rule',
          'entity' => 'HealthAlarmRule',
          'bao' => 'CRM_Healthmonitor_DAO_HealthAlarmRule',
          'localizable' => 0,
          'FKClassName' => 'CRM_Healthmonitor_DAO_HealthAlert',
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
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'health_alarm_rule', $prefix, []);
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
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'health_alarm_rule', $prefix, []);
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
    $indices = [
      'index_name' => [
        'name' => 'index_name',
        'field' => [
          0 => 'name',
        ],
        'localizable' => FALSE,
        'sig' => 'civicrm_health_alarm_rule::0::name',
      ],
    ];
    return ($localize && !empty($indices)) ? CRM_Core_DAO_AllCoreTables::multilingualize(__CLASS__, $indices) : $indices;
  }

}
