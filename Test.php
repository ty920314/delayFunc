<?php
namespace app;
class Controller extends DeferFuncHeap {
    /**
     * @return string|void
     * @throws \Exception
     */
    public function actionTest()
    {
        $return = [];
        $return['error'] = 0;
        $return['msg'] = 'ok';
        $msg = '发送短信';
       $this->defer(function ($name, $phone) use ($msg){
            //模拟逻辑 耗时10秒
            sleep(10);
            $this->send($name,$phone,$msg);
        },['name','phone'],1);
        $this->defer([$this,'log'],['array_test'],77);
        return $this->json($return);
    }
    
    public function send($name,$phone,$msg)
    {
        //发短信
        sleep(5);
    }
    public function log($logMessage)
    {
        $this->log->debug("ty:%s",$logMessage);
    }
}

