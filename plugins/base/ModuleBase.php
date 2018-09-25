<?php
/**
 * 代码结构实体基类 描述结构实体 例如：类，注释，关键字
 * User: shawn
 */
abstract class ModuleBase
{
    /**
     * @var int 结构实体类型
     */
    public $moduleType = 0;

    public function getModuleType(){
        return $this->moduleType;
    }

    public function exec(&$context){
        $content = $context->getContent();

        //解析模块
        $this->run($context, $content);
    }

    /**
     * 子类需继承实现
     * @param $context 当前文件上下文
     * @param $content 当前文件内容
     * @return mixed
     */
    public abstract function run(&$context, $content);

    /**
     * 提交解析出来的代码块
     * @param $context
     * @param $model
     * @return mixed
     */
    public function setModule(&$context, $model){
        return $context->setModule($model, $this->getModuleType());
    }

    /**
     * 计算未闭合标签数
     * @param $row
     * @return int
     */
    public function countTag($row){
        return mb_substr_count($row, '(') + mb_substr_count($row, '{') - mb_substr_count($row, ')') - mb_substr_count($row, '}');
    }
}