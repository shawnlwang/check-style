<?php
/**
 * Created by PhpStorm.
 * User: shawn
 */

$GLOBALS['app'] = array(
    array(
        'path' => '/data/release/test.com/app/Http/Controllers/Api',
        'rules' => array('IllegalAnnotationRule'),
    ),
);

/**
 * 规则文案
 */
$GLOBALS['ruleAnnotation'] = array(
    'IllegalAnnotationRule' => '注释不符合规范'
);

/**
 * 收件人
 */
$GLOBALS['mail-receivers'] = 'shawn';