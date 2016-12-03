<?php
namespace TicTacToe;

class AdvancedBot implements IBot{
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
        $playerOldMoves = $playerStats->oldMoves();
        $myOldMoves = $myStats->oldMoves();
        $oldMoves = array_merge($playerOldMoves,$myOldMoves);
        $chars = [];
        foreach ($playerOldMoves as $move){
            $mc = explode('-',$move);
            foreach($mc as $c) {
                if(!in_array($c, $chars)){
                    array_push($chars,$c);
                }
            }
        }
        $b = [];
        foreach ($chars as $char1) {
            foreach ($chars as $char2) {
                $b[] = $char1 . '-'.$char2;
            }
        }
        $combinations = array_values(array_unique($b));
        $intersectingPlayerMoves = array_diff($combinations,$playerOldMoves);
        $freeIntersectingPlayerMoves = array_diff($intersectingPlayerMoves,$oldMoves);
        $bestMove = array_intersect($playerMoves,$myMoves,$freeIntersectingPlayerMoves);
        if(in_array('1-1',$playerMoves) || $moves->movesLeft() == 9) {
            $move = '1-1';
        } else if(!empty($bestMove)) {
            $move = $this->pick($bestMove);
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
                if($a > $b) {
                    $move = $this->pick($myMoves);
                } else if ($a < $b){
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