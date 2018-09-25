<?php
/**
 * Created by PhpStorm.
 * User: shawn
 */
error_reporting(0);

if (!define(ROOT_PATH)){
    define(ROOT_PATH, dirname(__FILE__) . '/../');
}
require_once (ROOT_PATH . 'plugins/base/Global.php');

foreach ($GLOBALS['app'] as $item){
    //:todo 合法性检查
    if (!Tool::check($item)){
        continue;
    }

    //:todo 获取路径文件
    $files = Tool::getFiles($item['path']);

    //:todo 注册处理规则
    WorkSession::registerParseEvent($item['rules']);

    //:todo 开始处理
    foreach ($files as $filePath){
        Log::flow("parse begin: $filePath");

        $context = new Context($filePath);

        //:todo 规则解析
        WorkSession::parse($context);

        //:todo 解析完成后处理
        WorkSession::afterParse($context);

        Log::flow("parse end: $filePath");
    }
}

WorkSession::end($context);
