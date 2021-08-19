<?php

/**
 * @package CRM
 * @copyright CiviCRM LLC https://civicrm.org/licensing
 *
 * Generated from com.octopus8.healthmonitor/xml/schema/CRM/Healthmonitor/HealthMonitor.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:ca7ec4cb28a0dfc0cae1ca48702d5201)
 */
use CRM_Healthmonitor_ExtensionUtil as E;

/**
 * Database access object for the HealthMonitor entity.
 */
class CRM_Healthmonitor_DAO_HealthMonitor extends CRM_Core_DAO {
  const EXT = E::LONG_NAME;
  const TABLE_ADDED = '';

  /**
   * Static instance to hold the table name.
   *
   * @var string
   */
  public static $_tableName = 'civicrm_health_monitor';

  /**
   * Should CiviCRM log any modifications to this table in the civicrm_log table.
   *
   * @var bool
   */
  public static $_log = TRUE;

  /**
   * Unique HealthMonitor ID
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
   * Health Monitor Time
   *
   * @var datetime
   */
  public $date;

  /**
   * @var int
   */
  public $device_type_id;

  /**
   * FK to Device
   *
   * @var int
   */
  public $device_id;

  /**
   * @var int
   */
  public $sensor_id;

  /**
   * Sensor Value
   *
   * @var float
   */
  public $sensor_value;

  /**
   * Class constructor.
   */
  public function __construct() {
    $this->__table = 'civicrm_health_monitor';
    parent::__construct();
  }

  /**
   * Returns localized title of this entity.
   *
   * @param bool $plural
   *   Whether to return the plural version of the title.
   */
  public static function getEntityTitle($plural = FALSE) {
    return $plural ? E::ts('Health Monitors') : E::ts('Health Monitor');
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
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'device_id', 'civicrm_device', 'id');
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
          'description' => E::ts('Unique HealthMonitor ID'),
          'required' => TRUE,
          'import' => TRUE,
          'where' => 'civicrm_health_monitor.id',
          'export' => TRUE,
          'table_name' => 'civicrm_health_monitor',
          'entity' => 'HealthMonitor',
          'bao' => 'CRM_Healthmonitor_DAO_HealthMonitor',
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
          'import' => TRUE,
          'where' => 'civicrm_health_monitor.contact_id',
          'export' => TRUE,
          'table_name' => 'civicrm_health_monitor',
          'entity' => 'HealthMonitor',
          'bao' => 'CRM_Healthmonitor_DAO_HealthMonitor',
          'localizable' => 0,
          'FKClassName' => 'CRM_Contact_DAO_Contact',
          'add' => NULL,
        ],
        'date' => [
          'name' => 'date',
          'type' => CRM_Utils_Type::T_DATE + CRM_Utils_Type::T_TIME,
          'title' => E::ts('Date'),
          'description' => E::ts('Health Monitor Time'),
          'required' => TRUE,
          'import' => TRUE,
          'where' => 'civicrm_health_monitor.date',
          'export' => TRUE,
          'table_name' => 'civicrm_health_monitor',
          'entity' => 'HealthMonitor',
          'bao' => 'CRM_Healthmonitor_DAO_HealthMonitor',
          'localizable' => 0,
          'html' => [
            'type' => 'Select Date',
            'formatType' => 'activityDateTime',
          ],
          'add' => NULL,
        ],
        'device_type_id' => [
          'name' => 'device_type_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => E::ts('Device Type'),
          'import' => TRUE,
          'where' => 'civicrm_health_monitor.device_type_id',
          'export' => TRUE,
          'default' => '1',
          'table_name' => 'civicrm_health_monitor',
          'entity' => 'HealthMonitor',
          'bao' => 'CRM_Healthmonitor_DAO_HealthMonitor',
          'localizable' => 0,
          'html' => [
            'type' => 'Select',
          ],
          'pseudoconstant' => [
            'optionGroupName' => 'health_monitor_device_type',
            'optionEditPath' => 'civicrm/admin/options/health_monitor_device_type',
          ],
          'add' => NULL,
        ],
        'device_id' => [
          'name' => 'device_id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => E::ts('FK to Device'),
          'required' => TRUE,
          'import' => TRUE,
          'where' => 'civicrm_health_monitor.device_id',
          'export' => TRUE,
          'table_name' => 'civicrm_health_monitor',
          'entity' => 'HealthMonitor',
          'bao' => 'CRM_Healthmonitor_DAO_HealthMonitor',
          'localizable' => 0,
          'FKClassName' => 'CRM_Healthmonitor_DAO_Device',
          'add' => NULL,
        ],
        'sensor_id' => [
          'name' => 'sensor_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => E::ts('Sensor'),
          'required' => TRUE,
          'import' => TRUE,
          'where' => 'civicrm_health_monitor.sensor_id',
          'export' => TRUE,
          'default' => '1',
          'table_name' => 'civicrm_health_monitor',
          'entity' => 'HealthMonitor',
          'bao' => 'CRM_Healthmonitor_DAO_HealthMonitor',
          'localizable' => 0,
          'html' => [
            'type' => 'Select',
          ],
          'pseudoconstant' => [
            'optionGroupName' => 'health_monitor_sensor',
            'optionEditPath' => 'civicrm/admin/options/health_monitor_sensor',
          ],
          'add' => NULL,
        ],
        'sensor_value' => [
          'name' => 'sensor_value',
          'type' => CRM_Utils_Type::T_MONEY,
          'title' => E::ts('Sensor Value'),
          'description' => E::ts('Sensor Value'),
          'required' => TRUE,
          'precision' => [
            20,
            2,
          ],
          'import' => TRUE,
          'where' => 'civicrm_health_monitor.sensor_value',
          'dataPattern' => '/^\d+(\.\d{2})?$/',
          'export' => TRUE,
          'table_name' => 'civicrm_health_monitor',
          'entity' => 'HealthMonitor',
          'bao' => 'CRM_Healthmonitor_DAO_HealthMonitor',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
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
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'health_monitor', $prefix, []);
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
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'health_monitor', $prefix, []);
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
