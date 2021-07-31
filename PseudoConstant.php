<?php

class CRM_HealthMonitor_PseudoConstant extends CRM_Core_PseudoConstant {

    public static function healthMonitorDeviceType() {
        $types = CRM_Core_OptionGroup::values('healt_monitor_device_type');
        return $types;
    }

    public static function healthMonitorSensor() {
        $types = CRM_Core_OptionGroup::values('healt_monitor_sensor');
        return $types;
    }

}