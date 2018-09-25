<?php
/**
 * Created by PhpStorm.
 * User: shawn
 */

class ModuleClass extends ModuleBase
{
    /**
     * CLASS_MODULE
     * Module_Class constructor.
     */
    public function __construct()
    {
        $this->moduleType = ModuleType::CLASS_MODULE;
    }

    /**
     * 解析出CLASS_MODULE 调用 setModule
     * @param 当前文件上下文 $context
     * @param 当前文件内容 $content
     * @return mixed|void
     */
    public function run(&$context, $content){
        $model = null;
        foreach ($content as $line => $row){
            if (!empty($model)){
                //扑捉成员函数
                $isMatched = preg_match(PregConst::PREG_FUNCTION, $row, $funcMatches);
                if ($isMatched){
                    $model['function'][] = array('name' => trim($funcMatches[2]), 'mode' => trim($funcMatches[1]), 'callFunc' => array(), 'line' => $line + 1);
                }

                //扑捉调用函数
                $isMatched = preg_match(PregConst::PREG_CALL_FUNCTION, $row, $callFuncMatches);
                if ($isMatched && isset($model['function'][count($model['function']) - 1])){
                    $model['function'][count($model['function']) - 1]['callFunc'][] = array('name' => trim($callFuncMatches[1]), 'line' => $line + 1);
                }
                //存储块
                if ($line == count($content) - 1){
                    $model['end'] = $line;
                    $this->setModule($context, $model);
                }
            }

            //类名扑捉
            $isMatched = preg_match(PregConst::PREG_CLASS_NAME, $row, $matches);
            if (!$isMatched){
                continue;
            }

            //存储块
            if (!empty($model)){
                $model['end'] = $line -1;
                $this->setModule($context, $model);
            }
            $model = array('className' => trim($matches[1]), 'start' => $line + 1, 'function' => array());
        }
    }
}