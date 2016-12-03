<?php
namespace TicTacToe;

interface IGame {
    public function playerMove($boardState);
    public function botMove();
    public function getStatus();
    public function showHint();
    public function isOver();

}