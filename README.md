## 背景
该工具用于 编码规范规则自定义 及 规则检查 


<h2 id="catalog">目录</h2>

- [代码结构](#construct)
- [使用说明](#introduction)
- [开发说明](#producttion)

## 正文

<h3 id="construct">代码结构</h3>
目录：
```
| -- config
　　+ -- config.php　　　//配置文件
| -- main
　　+ -- App.php　　　　//启动文件
| -- plugins
　　| -- base　　　　
　　　　+ -- AfterEachParse.php
　　　　+ -- Context.php　　
　　　　+ -- Event.php　　　
　　　　+ -- EventFlow.php
　　　　+ -- Global.php
　　　　+ -- IRunnable.php
　　　　+ -- ModuleBse.php
　　　　+ -- ModuleType.php
　　　　+ -- MsgHandler.php
　　　　+ -- RuleBase.php
　　　　+ -- Tool.php
　　　　+ -- WorkSession.php
　　| -- log
　　| -- mail　　　　
　　　　+ -- Mail.php
　　　　+ -- MailContent.php
　　| -- modules　　　　
　　　　+ -- ModuleClass.php
　　　　+ -- ModuleFunc.php
　　| -- rules　　　　
　　　　+ -- UseJsonFormatReturnRule.php
　　| -- tools　　　　
　　　　+ -- Log.php
　　　　+ -- PubFunc.php
　　　　+ -- Tof.php
+ -- README.md
```

<h3 id="introduction">使用说明</h3>
- ```config/config.php``` 配置说明：
```
$GLOBALS['app'] = array(
    array(
        'path' => '/data/release/xxx/api/app/Http/Controllers/Api',
        'rules' => array('IllegalAnnotationRule'),
    ),
);
```
```path``` ：待检查代码文件或路径
```rules``` ：用于检查该路径或文件的规则
```
$GLOBALS['ruleAnnotation'] = array(
	'IllegalAnnotationRule' => '注释不符合规范'
);
```
```ruleAnnotation``` ：规则文案，在邮件内容中会使用到
```
$GLOBALS['mail-receivers'] = 'shawn';
```
```mail-receivers``` ：邮件或通知的相关人
- ```运行方式```：
crontab定时任务，使用php执行App.php启动文件


<h3 id="producttion">开发说明</h3>

<h4>模块简介</h4>

- ```plugins/modules``` :代码结构模块抽象
该目录下存放代码结构的类

> 例如 类， 类有名称，类中有方法，有成员变量，我们编写```ModuleClass```代码块，该类的实例化对象列表会传入规则中被解析
例如```UseJsonFormatReturnRule```规则，指定了会解析```ModuleClass``` 结构，而```UseJsonFormatReturnRule```的```run```方法中将会接收到代码块```$modules```

以```ModuleClass```为例：
```
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
     * @param $context
     * @param $content
     */
    public function run(&$context, $content){
        //:todo to get model
        $model = null;
        $this->setModule($context, $model);
    }
}
```
编写```plugins/modules```模块需要注意以下：
1、需继承```ModuleBase```
2、在```function run```中可通过```$content```获取文件内容，如需获取其它数据可通过文件上下文```$context```
3、必须通过```$this->setModule($context, $model)```提交解析出来的代码模块

- ```plugins/rules``` :代码规范抽象规则
该目录下存放规则类

> 例如```在控制器方法中使用json格式化返回值```这个条规则，我们编写了```UseJsonFormatReturnRule```
规则将会指定解析```plugins/modules```中的代码块，在这个规则中，我们指定了```$this->moduleType = ModuleType::CLASS_MODULE;``` 意味着该规则会解析```ModuleClass``` 结构

```
class UseJsonFormatReturnRule extends RuleBase
{
    /**
     * 该RULE需加载 类模块
     * UseSRFInControllerRule constructor.
     */
    public function __construct()
    {
        $this->moduleType = ModuleType::CLASS_MODULE;
    }


    public function run(&$context, $modules)
    {
        // TODO: Implement run() method.
        //... 在这里解析代码模块$modules，获取不符合该规则的 digest, filePath，line， detail，并调用addRuleResult提交
        $this->addRuleResult('digest', 'filePath', 'line', 'detail');
        
    }
}
```
编写```plugins/rules```模块需要注意以下：
1、需继承```RuleBase```
2、需要在```__construct()```中指定```ModuleType```，既规则要解析的代码结构模块
3、多个规则可使用相同的```ModuleType```
4、在```function run```中可通过```$modules```获取代码模块，必须通过```$this->addRuleResult```提交规则解析结果

<h4>开发步骤</h4>

- 如规则对应的代码结构在```plugins/modules```中未实现，需要先开发```plugins/modules```，如存在可直接使用
- 根据上述注意事项编写Rule放入```plugins/rules```中
- 根据上述编辑```config/config.php```，提交代码并发布


**[⬆ 返回顶部](#catalog)**