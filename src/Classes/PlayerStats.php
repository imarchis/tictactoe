<?php
namespace TicTacToe;

class PlayerStats implements IPlayerStatistics{
    private $player;
    private $grid;
    private $movesGrid;
    public function __construct($player, $grid, $movesGrid){
        $this->player = $player;
        $this->grid = $grid;
        $this->movesGrid = $movesGrid;
    }
    public function oldMoves(){
        $found = [];
        foreach ($this->grid as $k => $section){
            $keys = array_keys($section,$this->player);
            if(!empty($keys)){
                foreach($keys as $key){
                    array_push($found, $this->movesGrid[$k][$key]);
                }
            }
        }
        return array_unique($found);
    }
    public function options(){
        $found = [];
        foreach ($this->grid as $k => $section){
            $total = count(array_keys($section,$this->player));
            if($total > 0){
                $found[$k] = $total;
            }
        }
        arsort($found);
        $max = current($found);
        $optimal = array_keys($found, $max );
        $positions = [];
        foreach($optimal as $section){
            $p=$this->grid[$section];
            $f = array_keys($p,'');
            if(!empty($f)){
                foreach($f as $key){
                    if($this->grid[$section][$key] != $this->player){
                        array_push($positions, $this->movesGrid[$section][$key]);
                    }
                }
            }
        }
        return array_unique($positions);
    }
    public function isWinner(){

        $found = [];
        foreach ($this->grid as $k => $section){
            $found[$k] =count(array_keys($section,$this->player));
        }
        return false !== array_search(3,$found);
    }
}