<?php
/**
 * Created by PhpStorm.
 * User: shawn
 */
if (!function_exists('get_called_class')) {
    function get_called_class()
    {
        $objects = array();
        $traces = debug_backtrace();
        foreach ($traces as $trace) {
            if (isset($trace['object'])) {
                if (is_object($trace['object'])) {
                    $objects[] = $trace['object'];
                }
            }
        }
        if (count($objects)) {
            return get_class($objects[0]);
        }
    }
}