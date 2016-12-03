<?php
namespace TicTacToe;

interface IBot extends IPlayer {
    public function move(IBoard $board,IMoves $moves, IGrid $grid);
    public function opponent();
}