<?php
/**
 * 事件，执行module模块 rule模块
 * Class Event
 * User: shawn
 */
class Event
{
    private $class = null;

    /**
     * Event constructor.
     * @param $className 规则或解析类名
     */
    public function __construct($className)
    {
        $this->class = $className;
    }

    public function getName(){
        return $this->class;
    }

    public function run(&$context){
        if (strpos($this->class, 'Rule') !== false) {
            require_once(ROOT_PATH . 'plugins/rules/' . $this->class . '.php');
        }

        //类名跟文件名默认相同
        if (!class_exists($this->class)){
            return false;
        }
        $instance = new $this->class();

        //事件或Rule都需要继承IRunnable
        if (!method_exists($instance, 'run')){
            return false;
        }

        //RULE，则解析前需加载代码块
        if ($instance instanceof RuleBase){
            $module = $instance->getModuleType();
            //未加载过，则加载代码块
            if (!empty($module) && !$context->isModuleSet($module)) {
                require_once(ROOT_PATH . 'plugins/modules/' . $module . '.php');
                $moduleInstance = new $module();
                $moduleInstance->exec($context);
            }

            //Rule这里执行基类exec方法，方便包装结果处理
            return $instance->exec($context);
        }

        return $instance->run($context);
    }
}