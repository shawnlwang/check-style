<?php
/**
 * 规则实体基类，定义，解析，输出不符合规则代码
 * User: shawn
 */
abstract class RuleBase
{
    public $result = null;

    /**
     * @var int 规则解析的结构实体类型
     */
    public $moduleType = 0;

    public function getModuleType(){
        return $this->moduleType;
    }

    /**
     * 子类需继承实现
     * @param $context
     * @param $modules
     * @return mixed
     */
    public abstract function run(&$context, $modules);

    /**
     * 规则默认执行
     * @param $context
     */
    public function exec(&$context){
        $this->result = array();

        $modules = $context->getModules($this->getModuleType());

        //执行规则
        $this->run($context, $modules);

        //提交规则解析出来的结果
        $context->setRuleResult($this->result, get_called_class());
    }

    /**
     * 处理解析出来的不符合规则结果
     * @param $digest 摘要
     * @param $filePath 文件完整路径
     * @param $line 行号
     * @param string $detail 详情
     */
    public function addRuleResult($digest, $filePath, $line, $detail=''){
        $position = 'Filename: ' . Tool::getFileName($filePath) . '|Line: ' . $line;
        $detail =  'Detail: ' . $detail . '|FilePath: ' . $filePath . '|Line: ' . $line;
        $this->result[] = array('digest' => $digest, 'position' => $position, 'detail' => $detail);
    }
}