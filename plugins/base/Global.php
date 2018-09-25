<?php
/**
 * Created by PhpStorm.
 * User: shawn
 */
require_once (ROOT_PATH . 'plugins/tools/PubFunc.php');
require_once (ROOT_PATH . 'plugins/base/Tool.php');
require_once (ROOT_PATH . 'plugins/tools/Log.php');
require_once (ROOT_PATH . 'config/config.php');
require_once (ROOT_PATH . 'plugins/base/PregConst.php');
require_once (ROOT_PATH . 'plugins/base/Context.php');
require_once (ROOT_PATH . 'plugins/base/WorkSession.php');
require_once (ROOT_PATH . 'plugins/base/ModuleType.php');
require_once (ROOT_PATH . 'plugins/base/IRunnable.php');
require_once (ROOT_PATH . 'plugins/base/ModuleBase.php');
require_once (ROOT_PATH . 'plugins/base/RuleBase.php');

//注册解析结果处理事件，每个文件解析后执行
require_once (ROOT_PATH . 'plugins/base/AfterEachParse.php');
WorkSession::registerAfterParseEvent('AfterEachParse');

//注册消息处理事件，解析结束后执行
require_once (ROOT_PATH . 'plugins/base/MsgHandler.php');
WorkSession::registerEndEvent('MsgHandler');