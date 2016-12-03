<?php
namespace TicTacToe;

class Request implements IRequest {
    private $request;
    private $accepted = ['player','board','level'];
    public  function  __construct($requestData) {
        foreach($requestData as $key => $data){
            if(in_array($key,$this->accepted)){
                $this->request[$key]=$data;
            }
        }
    }
    public function getRequest()
    {
        return $this->request;
    }
    public function get($key)
    {
        return  isset($this->request[$key])?$this->request[$key]:null;
    }
}