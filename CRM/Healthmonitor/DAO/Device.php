<?php

/**
 * @package CRM
 * @copyright CiviCRM LLC https://civicrm.org/licensing
 *
 * Generated from com.octopus8.healthmonitor/xml/schema/CRM/Healthmonitor/Device.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:d5a2966a15a452821a6abd69d2e3c742)
 */
use CRM_Healthmonitor_ExtensionUtil as E;

/**
 * Database access object for the Device entity.
 */
class CRM_Healthmonitor_DAO_Device extends CRM_Core_DAO {
  const EXT = E::LONG_NAME;
  const TABLE_ADDED = '';

  /**
   * Static instance to hold the table name.
   *
   * @var string
   */
  public static $_tableName = 'civicrm_device';

  /**
   * Should CiviCRM log any modifications to this table in the civicrm_log table.
   *
   * @var bool
   */
  public static $_log = TRUE;

  /**
   * Unique Device ID
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
   * @var string
   */
  public $name;

  /**
   * @var int
   */
  public $device_type_id;

  /**
   * @var bool
   */
  public $default_client;

  /**
   * Class constructor.
   */
  public function __construct() {
    $this->__table = 'civicrm_device';
    parent::__construct();
  }

  /**
   * Returns localized title of this entity.
   *
   * @param bool $plural
   *   Whether to return the plural version of the title.
   */
  public static function getEntityTitle($plural = FALSE) {
    return $plural ? E::ts('Devices') : E::ts('Device');
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
          'description' => E::ts('Unique Device ID'),
          'required' => TRUE,
          'where' => 'civicrm_device.id',
          'table_name' => 'civicrm_device',
          'entity' => 'Device',
          'bao' => 'CRM_Healthmonitor_DAO_Device',
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
          'required' => TRUE,
          'where' => 'civicrm_device.contact_id',
          'table_name' => 'civicrm_device',
          'entity' => 'Device',
          'bao' => 'CRM_Healthmonitor_DAO_Device',
          'localizable' => 0,
          'FKClassName' => 'CRM_Contact_DAO_Contact',
          'add' => NULL,
        ],
        'name' => [
          'name' => 'name',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => E::ts('Name'),
          'required' => FALSE,
          'maxlength' => 255,
          'size' => CRM_Utils_Type::HUGE,
          'where' => 'civicrm_device.name',
          'table_name' => 'civicrm_device',
          'entity' => 'Device',
          'bao' => 'CRM_Healthmonitor_DAO_Device',
          'localizable' => 0,
          'add' => NULL,
        ],
        'device_type_id' => [
          'name' => 'device_type_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => E::ts('Device Type'),
          'where' => 'civicrm_device.device_type_id',
          'default' => 'NULL',
          'table_name' => 'civicrm_device',
          'entity' => 'Device',
          'bao' => 'CRM_Healthmonitor_DAO_Device',
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
        'default_client' => [
          'name' => 'default_client',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => E::ts('Default Client'),
          'required' => FALSE,
          'where' => 'civicrm_device.default_client',
          'default' => 'true',
          'table_name' => 'civicrm_device',
          'entity' => 'Device',
          'bao' => 'CRM_Healthmonitor_DAO_Device',
          'localizable' => 0,
          'html' => [
            'type' => 'CheckBox',
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
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'device', $prefix, []);
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
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'device', $prefix, []);
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
