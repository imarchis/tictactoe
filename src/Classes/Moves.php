<?php
namespace TicTacToe;

class Moves implements IMoves {
    private $moves;
    private $takenMoves;
    public function __construct(){
        $b = [];
        foreach (range(0,2) as $char1) {
            foreach (range(0,2) as $char2) {
                $b[] = $char1 . '-'.$char2;
            }
        }
        $this->takenMoves = [];
        $this->moves = $b;
    }
    public function takeMove($x,$y){
        array_push($this->takenMoves,$x.'-'.$y);
    }
    public function availableMoves(){
        return array_diff($this->moves,$this->takenMoves);
    }
    public function getMoves(){
        return $this->moves;
    }
    public function movesLeft(){
        return count($this->availableMoves());
    }
}