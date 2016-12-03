<?php
namespace TicTacToe;

interface IPlayerStatistics {
    public function oldMoves();
    public function options();
    public function isWinner();
}