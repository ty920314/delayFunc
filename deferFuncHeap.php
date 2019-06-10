<?php
namespace app;
/**
 * User: ty920314
 * Date: 19/6/10
 * Time: 下午7:02
 */
/**
 * 创造一个堆栈 让我们的功能拥有自动根据权重排序的能力!
 * Class deferFuncHeap
 */
class DeferFuncHeap extends \SplHeap {
    private $callable;
    /**
     * @param \Closure|array $func
     * @param array $param default []
     * @param int 权重 越高越优先 $weight
     * @throws \Exception
     */
    public function defer($func, $param = [], $weight = 0){
        if(is_callable($func)){
            if(!$this->callable instanceof self){
                $this->callable = new self;
            }
            $this->callable->insert([
                'callable'=>$func,
                'params'=>$param,
                'weight'=>$weight
            ]);
        }else{
            throw new \Exception("defer param:func need callable!");
        }
    }
    protected function compare($value1, $value2)
    {
        return $value1['weight']-$value2['weight'];
    }
    /**
     * send data to Client
     * @param $return
     * @return string|void
     */
    public function Json($return){
        echo json_encode($return);
        //该函数flush数据输出至客户端
        fastcgi_finish_request();
        if(!empty($this->callable)){
            foreach ($this->callable as $k=>$func){
                call_user_func_array($func['callable'],$func['params']);
            }
        }
    }
}



