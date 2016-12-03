<?php
namespace TicTacToe;

class Player implements IPlayer {
    private  $token;
    public function __construct($token) {
        $this->token = $token;
    }
    public function getToken()
    {
        return $this->token;
    }
    public function pick($moves){
        $moves = array_values($moves);
        end($moves);
        $key = key($moves);
        reset($moves);
        return $moves[rand(0, (int)$key)];
    }

}