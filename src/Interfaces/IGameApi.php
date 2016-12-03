<?php
namespace TicTacToe;

interface IGameApi
{
    public function startGame(IRequest $request);
    public function newGame();
    public function resetGame();
    public function newMove(IRequest $request);
    public function showHint();
}