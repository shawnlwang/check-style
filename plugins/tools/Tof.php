<?php
/**
 * Created by PhpStorm.
 * User: shawn
 */

class Tof
{
    private $client;

    public function __destruct() {
        unset($this->client);
    }
    private function _initClient($service) {
    }

    /**
     * 发送邮件
     * @param $receiver
     * @param $cc
     * @param $subject
     * @param $msg
     * @param string $priority
     * @return mixed
     */
    public function sendMail($receiver, $cc, $subject, $msg, $priority='Hight') {
        $ret = false;
        return $ret;
    }

    /**
     * 发送微信
     * @param $receiver
     * @param $msgInfo
     * @return bool|string
     */
    public function sendWX($receiver, $msgInfo) {
        $rst = false;
        //:todo send weixin
        return $rst;
    }
}