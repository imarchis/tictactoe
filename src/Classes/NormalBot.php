<?php
namespace TicTacToe;

class NormalBot implements IBot{
    private $token;
    public function __construct($token){
        $this->token = $token;
    }
    public function getToken()
    {
        return $this->token;
    }
    public function opponent()
    {
        return $this->token == 'x'? 'o':'x';
    }
    public function move(IBoard $board, IMoves $moves, IGrid $grid)
    {
        $playerStats =  new PlayerStats($this->opponent(),$grid->makeGrid($board->boardState()),$grid->makeGrid($moves->getMoves()));
        $myStats =  new PlayerStats($this->token,$grid->makeGrid($board->boardState()),$grid->makeGrid($moves->getMoves()));
        $playerMoves = $playerStats->options();
        $myMoves = $myStats->options();
        if(in_array('1-1',$playerMoves) || $moves->movesLeft() == 9) {
            $move = '1-1';
        } else {
            $a = count($playerMoves);
            $b = count($myMoves);
            if($a == 0 && $b == 0){
                $move =$this->pick($moves->availableMoves());
            } else if($a == 0 && $b > 0){
                $move = $this->pick($myMoves);
            } else if($a > 0 && $b == 0){
                $move = $this->pick($playerMoves);
            } else {
                if ($a < $b){
                    $move = $this->pick($playerMoves);
                } else {
                    $move = $this->pick($myMoves);
                }
            }
        }
        return $move;
    }
    public function pick($moves){
        $moves = array_values($moves);
        end($moves);
        $key = key($moves);
        reset($moves);
        return $moves[rand(0, (int)$key)];
    }
}