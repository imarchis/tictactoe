<?php
namespace TicTacToe;

interface IPlayer{
    public function getToken();
    public function pick($moves);

}