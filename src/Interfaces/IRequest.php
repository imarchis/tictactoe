<?php
namespace TicTacToe;

interface IRequest{
    public function getRequest();
    public function get($key);
}