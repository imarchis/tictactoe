<?php
namespace TicTacToe;

class EasyBot implements IBot{
    private $token;
    public function __construct($token){
        $this->token = $token;
    }
    public function move(IBoard $board,IMoves $moves, IGrid $grid)
    {
        $myMoves = $moves->availableMoves();
        return $this->pick($myMoves);
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

    public function opponent()
    {
        return $this->token == 'x'? 'o':'x';
    }
}