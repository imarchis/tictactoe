<?php
namespace TicTacToe;

class TicTacToe implements IGame{
    private $grid;
    private $board;
    private $moves;
    private $player;
    private $bot;
    private $winner;
    private $type;
    private $status;
    private $playerMove;
    private $botMove;
    private $lastMove;
    public function __construct(IGrid $grid,IBoard $board, IMoves $moves,IBot $bot, IPlayer $player ){
        $this->grid = $grid;
        $this->board = $board;
        $this->moves = $moves;
        $this->bot = $bot;
        $this->player = $player;
        $this->winner = null;
        $this->status = 'on';
    }
    public function playerMove($boardState){
        $move = ['','',$this->player->getToken()];
        $playerMove = '';
        foreach($boardState as $key => $val) {
            $diff = array_diff_assoc($val,$this->board->boardState()[$key]);
            if(!empty($diff)){
                $playerMove = $key .'-'.key($diff);
            }
        }
        if(!empty($playerMove)) {
            $c = explode('-',$playerMove);
            $x = $c[0];$y=$c[1];
            $this->board->markBoard($x,$y,$this->player->getToken());
            $this->playerMove= $playerMove;
            $this->lastMove = $playerMove;
            $this->moves->takeMove($x,$y);
            $this->getStatus();
            $move = [$x,$y,$this->player->getToken()];
        }
        return $move;
    }
    public function botMove() {
        $botMove = $this->bot->move($this->board,$this->moves, $this->grid);
        $move = ['','',$this->bot->getToken()];
        if(!empty($botMove)){
            $c = explode('-',$botMove);
            $x = $c[0];$y=$c[1];
            $this->board->markBoard($x,$y,$this->bot->getToken());
            $this->moves->takeMove($x,$y);
            $this->botMove = $botMove;
            $this->lastMove = $botMove;
            $this->getStatus();
            $move = [$x,$y,$this->bot->getToken()];
        }
        return $move;
    }
    public function getStatus(){
        $ps = new PlayerStats($this->player->getToken(),$this->grid->makeGrid($this->board->boardState()),$this->grid->makeGrid($this->moves->getMoves()));
        $bs = new PlayerStats($this->bot->getToken(),$this->grid->makeGrid($this->board->boardState()),$this->grid->makeGrid($this->moves->getMoves()));
        if($ps->isWinner() ) {
            $this->winner = $this->player->getToken();
            $this->type = 'player';
            $this->status = 'over';
        } else if( $bs->isWinner() ) {
            $this->winner = $this->bot->getToken();
            $this->type = 'bot';
            $this->status = 'over';
        } else {
            if($this->moves->movesLeft() <= 1 && count($ps->options()) == 0 && count($bs->options()) == 0){
                $this->type = 'draw';
                $this->status = 'over';
            } else {
                $this->type = 'undecided';
                $this->status = 'on';
            }
        }
        return [
            'winner' => $this->winner,'type'=>$this->type, 'status'=>$this->status,
            'player' => $this->player->getToken(), 'playerMove'=>$this->playerMove,
            'bot' => $this->bot->getToken(), 'botMove'=>$this->botMove,
            'lastMove'=> $this->lastMove,
            'movesLeft' => $this->moves->movesLeft()
        ];
    }
    public function showHint(){
        $playerStats = new PlayerStats($this->player->getToken(),$this->grid->makeGrid($this->board->boardState()),$this->grid->makeGrid($this->moves->getMoves()));
        $botStats = new PlayerStats($this->bot->getToken(),$this->grid->makeGrid($this->board->boardState()),$this->grid->makeGrid($this->moves->getMoves()));
        $botMoves = $botStats->options();
        $myMoves = $playerStats->options();
        if(in_array('1-1',$botMoves) || $this->moves->movesLeft() == 9) {
            $move = '1-1';
        } else {
            $a = count($botMoves);
            $b = count($myMoves);
            if($a == 0 && $b == 0){
                $move = $this->player->pick($this->moves->availableMoves());
            } else if($a == 0 && $b > 0){
                $move = $this->player->pick($myMoves);
            } else if($a > 0 && $b == 0){
                $move = $this->player->pick($botMoves);
            } else {
                if($a > $b) {
                    $move = $this->player->pick($myMoves);
                } else if ($a < $b){
                    $move = $this->player->pick($botMoves);
                } else {
                    $move = $this->player->pick($myMoves);
                }
            }
        }
        return $move;
    }
    public function isOver(){
        $this->getStatus();
        return $this->status == 'over';
    }
}