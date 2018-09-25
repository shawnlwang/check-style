<?php
/**
 * Created by PhpStorm.
 * User: shawn
 */
require_once('EventFlow.php');
require_once('Event.php');
class WorkSession
{
    /**
     * @var null 解析处理事件
     */
    private static $parseEvents = null;

    /**
     * @var null 解析完成后待处理事件
     */
    private static $endEvents = null;

    /**
     * @var null 解析后待处理事件
     */
    private static $afterParseEvents = null;

    /**
     * 注册解析命令链
     * @param $className
     * @param bool $isCover 是否清空之前注册
     */
    public static function registerParseEvent($className, $isCover=true){
        if (empty(self::$parseEvents)){
            self::$parseEvents = new EventFlow();
        }
        if ($isCover){
            self::$parseEvents->clear();
        }
        if (!is_array($className)) {
            self::$parseEvents->add(self::getEvent($className));
        } else{
            foreach ($className as $class){
                self::$parseEvents->add(self::getEvent($class));
            }
        }
    }

    /**
     * 注册解析后命令链
     * @param $className
     */
    public static function registerAfterParseEvent($className){
        if (empty(self::$afterParseEvents)){
            self::$afterParseEvents = new EventFlow();
        }
        self::$afterParseEvents->add(self::getEvent($className));
    }

    /**
     * 注册module解析命令到命令链
     * @param $className
     */
    public static function registerEndEvent($className){
        if (empty(self::$endEvents)){
            self::$endEvents = new EventFlow();
        }
        self::$endEvents->add(self::getEvent($className));
    }

    /**
     * 发布解析命令
     * @param $context
     */
    public static function parse($context){
        if (empty(self::$parseEvents)){
            return;
        }
        self::$parseEvents->exec($context);
    }

    /**
     * 发布解析完成命令
     * @param $context
     */
    public static function afterParse($context){
        if (empty(self::$afterParseEvents)){
            return;
        }
        self::$afterParseEvents->exec($context);
    }

    /**
     * 发布解析完成事件，触发命令链执行
     * @param $context
     */
    public static function end(){
        if (empty(self::$endEvents)){
            return;
        }
        self::$endEvents->exec();
    }

    /**
     * 生成事件
     * @param $className
     * @return Event
     */
    private static function getEvent($className){
        return new Event($className);
    }
}