<?php
namespace TicTacToe;

class Board implements IBoard {
    private $state;
    public function __construct(){
        $this->createBoard();
    }
    public function createBoard() {
        $this->state=array_fill(0, 3, array_fill(0, 3, ''));
    }
    public function boardState(){
        return $this->state;
    }
    public function markBoard ($x,$y,$token){
        $this->state[$x][$y]=$token;
    }
}