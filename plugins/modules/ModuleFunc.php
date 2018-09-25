<?php
/**
 * Created by PhpStorm.
 * User: shawn
 */

class ModuleFunc extends ModuleBase
{
    /**
     * CLASS_MODULE
     * Module_Class constructor.
     */
    public function __construct()
    {
        $this->moduleType = ModuleType::FUNC_MODULE;
    }

    public function run(&$context, $content)
    {
        $model = null;
        foreach ($content as $line => $row) {
            if (!empty($model)){
                //扑捉调用函数
                $isMatched = preg_match(PregConst::PREG_CALL_FUNCTION, '', $callFuncMatches);
                if ($isMatched){
                    $model['callFunc'][] = array('name' => trim($callFuncMatches[1]), 'line' => $line + 1);
                }

                //扑捉对象实例化
                $isMatched = preg_match(PregConst::PREG_NEW_INSTANCE, '', $instanceMatches);
                if ($isMatched){
                    $model['newInstance'][] = array('name' => trim($instanceMatches[1]), 'line' => $line + 1);
                }
            }

            //扑捉成员函数
            $isMatched = preg_match(PregConst::PREG_FUNCTION, $row, $funcMatches);
            if (!$isMatched){
                continue;
            }

            //存储块
            if (!empty($model)){
                $model['end'] = $line -1;
                $this->setModule($context, $model);
                $model = null;
            }
            $model = array(
                'filePath' => $context->getFilePath(),
                'functionName' => trim($funcMatches[2]),
                'mode' => trim($funcMatches[1]),
                'annotation' => $this->getAnnotation($content, $line),
                'callFunc' => array(),
                'newInstance' => array(),
                'start' => $line,
                'end' => $line
            );
        }
        //存储块
        if (!empty($model)){
            $model['end'] = $line -1;
            $this->setModule($context, $model);
        }
    }

    /**
     * 获取方法注释
     * @param $row
     * @param $funcLine
     * @return string
     */
    private function getAnnotation($row, $funcLine){
        for($idx = $funcLine - 1; $idx > 0; $idx--) {
            $isMatched = preg_match(PregConst::PREG_ANNOTATION_ROW, $row[$idx]);
            if (!$isMatched) {
                $annotation = array_splice($row, $idx + 1, $funcLine - $idx -1);
                return trim(implode(PHP_EOL, $annotation));
            }
        }
        return null;
    }
}