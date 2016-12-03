<?php
namespace TicTacToe;

class Api implements \MoveInterface, IGameApi {
    private $session;
    public function __construct(ISession $session){
        $this->session = $session;
    }
    public function startGame(IRequest $request){
        $playerToken = $request->get('player');
        $player = new Player($playerToken);
        $botToken = $playerToken == 'x'?'o':'x';
        $level = $request->get('level');
        if ($level == 0){
            $bot = new EasyBot($botToken);
        } elseif($level == 1) {
            $bot = new NormalBot($botToken);
        } else {
            $bot = new AdvancedBot($botToken);
        }
        $game = new TicTacToe(new Grid(),new Board(), new Moves(), $bot, $player);
        $this->session->set('player',$player);
        $this->session->set('bot',$bot);
        $this->session->set('game',$game);
        return $game->getStatus();
    }
    public function newGame(){
        $bot = $this->session->get('bot');
        $player = $this->session->get('player');
        $game = new TicTacToe(new Grid(),new Board(), new Moves(), $bot, $player);
        $this->session->set('game',$game);
        return $game->getStatus();
    }
    public function resetGame(){
        $this->session->remove('player');
        $this->session->remove('bot');
        $this->session->remove('game');
    }
    public function newMove(IRequest $request){
        /** @var TicTacToe $game */
        $game = $this->session->get('game');
        $boardState = json_decode($request->get('board'));
        /** using the \MoveInterface method */
        $move = $this->makeMove($boardState);
        /** TicTacToe::getStatus method contains the botMove [which is the next move] */
        $response = $game->getStatus();
        $response['nextMove']=$move;
        return $response;
    }
    public function showHint(){
        /** @var TicTacToe $game */
        $game = $this->session->get('game');
        $hint = $game->showHint();
        return ['hint'=>$hint];
    }

    /**
     * Makes a move using the $boardState
     * $boardState contains 2 dimensional array of the game field
     * X represents one team, O - the other team, empty string means field is not yet taken.
     * example
     * [['X', 'O', '']
     * ['X', 'O', 'O']
     * ['', '', '']]
     * Returns an array, containing x and y coordinates for next move, and the unit that now occupies it.
     * Example: [2, 0, 'O'] - upper right corner - O player
     *
     * @param array $boardState Current board state
     * @param string $playerUnit Player unit representation
     *
     * @return array
     */
    public function makeMove($boardState, $playerUnit = 'X')
    {        /** @var TicTacToe $game */
        $game = $this->session->get('game');
        $game->playerMove($boardState);
        $move = [];
        if(!$game->isOver()){
            $move = $game->botMove();
        }
        return $move;
    }
}