<?php
namespace TicTacToe;

interface ISession {
    public function all();
    public function start();
    public function destroy();
    public function set($key,$var);
    public function get($key);
    public function remove($var);
}