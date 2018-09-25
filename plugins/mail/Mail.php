<?php
/**
 * Created by PhpStorm.
 * User: shawn
 */
require_once (ROOT_PATH . 'plugins/tools/Tof.php');
class Mail{
    private $receivers = 'shawn';
    private $title;

    public function __construct()
    {
        $this->title = '编码规范检查报告'.'('.Date('Y-m-d', time()).')';
        $this->receivers = $GLOBALS['mail-receivers'];
    }

    public function send(){
        ob_start();
        require_once('MailContent.php');
        $sender = new Tof();
        $ret = $sender->sendMail($this->receivers, '', $this->title, ob_get_contents());
        ob_clean();
        Log::flow("sendMail return: $ret");
    }
}