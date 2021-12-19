<?php

/**
 * @package CRM
 * @copyright CiviCRM LLC https://civicrm.org/licensing
 *
 * Generated from com.octopus8.devices/xml/schema/CRM/Devices/02_DeviceData.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:dbe59b63a42bbd2b134d1b69d359ccdf)
 */
use CRM_Devices_ExtensionUtil as E;

/**
 * Database access object for the DeviceData entity.
 */
class CRM_Devices_DAO_DeviceData extends CRM_Core_DAO {
  const EXT = E::LONG_NAME;
  const TABLE_ADDED = '';

  /**
   * Static instance to hold the table name.
   *
   * @var string
   */
  public static $_tableName = 'civicrm_o8_device_data';

  /**
   * Should CiviCRM log any modifications to this table in the civicrm_log table.
   *
   * @var bool
   */
  public static $_log = TRUE;

  /**
   * Unique Device Data ID
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
   * Device Data Time
   *
   * @var datetime
   */
  public $date;

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
    $this->__table = 'civicrm_o8_device_data';
    parent::__construct();
  }

  /**
   * Returns localized title of this entity.
   *
   * @param bool $plural
   *   Whether to return the plural version of the title.
   */
  public static function getEntityTitle($plural = FALSE) {
    return $plural ? E::ts('Device Datas') : E::ts('Device Data');
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
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'device_id', 'civicrm_o8_device', 'id');
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
          'description' => E::ts('Unique Device Data ID'),
          'required' => TRUE,
          'where' => 'civicrm_o8_device_data.id',
          'table_name' => 'civicrm_o8_device_data',
          'entity' => 'DeviceData',
          'bao' => 'CRM_Devices_DAO_DeviceData',
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
          'where' => 'civicrm_o8_device_data.contact_id',
          'table_name' => 'civicrm_o8_device_data',
          'entity' => 'DeviceData',
          'bao' => 'CRM_Devices_DAO_DeviceData',
          'localizable' => 0,
          'FKClassName' => 'CRM_Contact_DAO_Contact',
          'add' => NULL,
        ],
        'date' => [
          'name' => 'date',
          'type' => CRM_Utils_Type::T_DATE + CRM_Utils_Type::T_TIME,
          'title' => E::ts('Date'),
          'description' => E::ts('Device Data Time'),
          'required' => TRUE,
          'import' => TRUE,
          'where' => 'civicrm_o8_device_data.date',
          'export' => TRUE,
          'table_name' => 'civicrm_o8_device_data',
          'entity' => 'DeviceData',
          'bao' => 'CRM_Devices_DAO_DeviceData',
          'localizable' => 0,
          'html' => [
            'type' => 'Select Date',
            'formatType' => 'activityDateTime',
          ],
          'add' => NULL,
        ],
        'device_id' => [
          'name' => 'device_id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => E::ts('FK to Device'),
          'required' => TRUE,
          'import' => TRUE,
          'where' => 'civicrm_o8_device_data.device_id',
          'export' => TRUE,
          'table_name' => 'civicrm_o8_device_data',
          'entity' => 'DeviceData',
          'bao' => 'CRM_Devices_DAO_DeviceData',
          'localizable' => 0,
          'FKClassName' => 'CRM_Devices_DAO_Device',
          'add' => NULL,
        ],
        'sensor_id' => [
          'name' => 'sensor_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => E::ts('Sensor'),
          'required' => TRUE,
          'import' => TRUE,
          'where' => 'civicrm_o8_device_data.sensor_id',
          'export' => TRUE,
          'default' => '1',
          'table_name' => 'civicrm_o8_device_data',
          'entity' => 'DeviceData',
          'bao' => 'CRM_Devices_DAO_DeviceData',
          'localizable' => 0,
          'html' => [
            'type' => 'Select',
          ],
          'pseudoconstant' => [
            'optionGroupName' => 'o8_sensor',
            'optionEditPath' => 'civicrm/admin/options/o8_sensor',
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
          'where' => 'civicrm_o8_device_data.sensor_value',
          'dataPattern' => '/^\d+(\.\d{8})?$/',
          'export' => TRUE,
          'table_name' => 'civicrm_o8_device_data',
          'entity' => 'DeviceData',
          'bao' => 'CRM_Devices_DAO_DeviceData',
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
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'o8_device_data', $prefix, []);
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
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'o8_device_data', $prefix, []);
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