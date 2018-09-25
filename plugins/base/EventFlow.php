<?php
/**
 * 事件流，命令链
 * User: shawn
 */
class EventFlow
{
    private $list = array();

    public function add($event){
        $this->list[$event->getName()] = $event;
    }

    public function remove($event){
        unset($this->list[$event->getName()]);
    }

    public function clear(){
        $this->list = array();
    }

    public function exec(&$context){
        foreach($this->list as $name => $event){
            $ret = $event->run($context);
            if(!empty($ret)){
                Log::error($name . ' exec failed. returns ' . $ret);
            }
        }
        return true;
    }
}