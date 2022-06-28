<?php
namespace Civi\Api4;

/**
 * DeviceData entity.
 *
 * Provided by the FIXME extension.
 *
 * @package Civi\Api4
 */
class DeviceData extends Generic\DAOEntity {
    public static function permissions() {
        return [
            'meta' => ['access CiviCRM'],
            'default' => ['access CiviCRM'],
        ];
    }

}
