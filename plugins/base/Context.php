<?php
/**
 * Created by PhpStorm.
 * User: shawn
 */

/**
 * 解析流程上下文
 * Class Context
 */
class Context
{
    /**
     * 文件路径
     * @var null
     */
    private $filePath = null;

    /**
     * 解析出来的结构块
     * @var array
     */
    private $modules = array();

    /**
     * 规则解析结果
     * @var array
     */
    private $ruleResult = array();

    /**
     * 代码文本内容
     * @var null|string
     */
    private $content = null;

    /**
     * 已解析过的块
     * @var array
     */
    private $moduleParsed = array();

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
        $fileContent = file_get_contents($this->filePath);
        $this->content = explode(PHP_EOL, $fileContent);
    }

    public function __destruct()
    {
        unset($this->content);
        unset($this->modules);
        unset($this->filePath);
    }

    /**
     * 获取文件内容
     * @return array|null|string
     */
    public function getContent(){
        return $this->content;
    }

    /**
     * 获取文件路径
     * @return null
     */
    public function getFilePath(){
        return $this->filePath;
    }

    /**
     * 获取文件名称
     * @return bool|string
     */
    public function getFileName(){
        return Tool::getFileName($this->filePath);
    }

    /**
     * 添加块
     * @param $module
     * @param $type
     */
    public function setModule($module, $type){
        $this->moduleParsed[] = $type;
        if (empty($module)){
            return;
        }
        if (!isset($this->modules[$type])){
            $this->modules[$type] = array();
        }
        $this->modules[$type][] = $module;
    }

    /**
     * 获取块
     * @param $moduleType
     * @return null
     */
    public function getModules($moduleType){
        if (empty($this->modules[$moduleType])){
            return null;
        }
        return $this->modules[$moduleType];
    }

    /**
     * 设置规则执行结果
     * @param $result
     * @param $rule
     */
    public function setRuleResult($result, $rule){
        if (empty($result)){
            return;
        }
        if (!isset($this->ruleResult[$rule])){
            $this->ruleResult[$rule] = array();
        }
        $this->ruleResult[$rule] = array_merge($this->ruleResult[$rule], $result);
    }

    /**
     * 获取解析结果
     * @return array
     */
    public function getAllRuleResult(){
        return $this->ruleResult;
    }

    /**
     * 获取规则执行结果
     * @param $rule
     * @return mixed
     */
    public function getRuleResult($rule){
        if (!isset($this->ruleResult[$rule])){
            return null;
        }
        return $this->ruleResult[$rule];
    }

    /**
     * 是否已解析过
     * @param $type
     * @return bool
     */
    public function isModuleSet($type){
        return in_array($type, $this->moduleParsed);
    }
}