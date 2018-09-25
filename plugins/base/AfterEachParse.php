<?php
/**
 * Created by PhpStorm.
 * User: shawn
 */

class AfterEachParse implements IRunnable
{
    /**
     * 将规则处理结果放到Global中
     * @param $context
     */
    public function run(&$context){
        $result = $context->getAllRuleResult();
        if (empty($result)){
            return;
        }
        if (!isset($GLOBALS['result'])){
            $GLOBALS['result'] = array();
        }
        foreach ($result as $ruleName => $checkResult){
            if (!isset($GLOBALS['result'][$ruleName])){
                $GLOBALS['result'][$ruleName] = array();
            }
            $GLOBALS['result'][$ruleName] = array_merge($GLOBALS['result'][$ruleName], $checkResult);
        }
    }
}