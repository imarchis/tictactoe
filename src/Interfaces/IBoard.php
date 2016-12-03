<?php
namespace TicTacToe;

interface IBoard {
    public function createBoard();
    public function boardState();
    public function markBoard($x,$y,$token);
}