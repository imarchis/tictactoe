<?php
namespace TicTacToe;

interface IMoves   {
    public function takeMove($x,$y);
    public function availableMoves();
    public function getMoves();
    public function movesLeft();
}