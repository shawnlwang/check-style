<?php
/**
 * Created by PhpStorm.
 * User: shawn
 */
class MsgHandler implements IRunnable
{
    public function run(&$context)
    {
        // TODO: Implement run() method.
        if (empty($GLOBALS['result'])){
            Log::flow('all rules passed.');
        }

        require_once (ROOT_PATH . '/plugins/mail/Mail.php');
        $mail = new Mail();
        $mail->send();
    }
}