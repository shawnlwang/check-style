<?php
/**
 * Created by PhpStorm.
 * User: shawn
 */

class Log
{
    /**
     * 错误日志文件
     */
    const ERROR_LOG_PATH = '/plugins/log/error.log';

    /**
     * 流水日志文件
     */
    const FLOW_LOG_PATH = '/plugins/log/flow.log';

    /**
     * 流水
     * @param $content
     */
    public static function flow($content){
        self::addLog($content, 'flow');
    }

    /**
     * 错误
     * @param $content
     */
    public static function error($content){
        self::addLog($content, 'error');
    }

    /**
     * 添加日志
     * @param $content
     * @param string $type
     */
    private static function addLog($content, $type = 'flow')
    {
        $time = date("Y-m-d H:i:s");
        $log = "[$time]" . $content . "\n";
        if ($type == 'error') {
            self::fileInputAdd(ROOT_PATH. self::ERROR_LOG_PATH, $log);
        } else if ($type == 'flow') {
            self::fileInputAdd(ROOT_PATH . self::FLOW_LOG_PATH, $log);
        }
    }

    /**
     * 写入：在原内容后添加
     * @param $filePath
     * @param $content
     */
    private static function fileInputAdd($filePath,$content){
        $fpo = fopen($filePath,'a');
        fwrite($fpo,$content);
        fclose($fpo);
    }
}