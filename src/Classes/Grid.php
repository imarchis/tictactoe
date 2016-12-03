<?php
namespace TicTacToe;

class Grid implements IGrid {
    public function makeGrid($array){
        if(count($array)<9){
            $array = call_user_func_array('array_merge', $array);
        }
        $grid = [];
        $grid[0]=array_slice($array,0,3);
        $grid[1]=array_slice($array,3,3);
        $grid[2]=array_slice($array,6,3);
        $grid[3]=$grid[4]=$grid[5]=$grid[6]=$grid[7]=[];
        foreach($array as $key => $val){
            if($key == 0 || $key == 3 || $key == 6){
                array_push($grid[3],$val);
                if($key == 0){
                    array_push($grid[6],$val);
                }
                if($key == 6){
                    array_push($grid[7],$val);
                }
            }
            if($key == 1 || $key == 4 || $key == 7){
                array_push($grid[4],$val);
                if($key == 4){
                    array_push($grid[6],$val);
                    array_push($grid[7],$val);
                }
            }
            if($key == 2 || $key == 5 || $key == 8){
                array_push($grid[5],$val);
                if($key == 2){
                    array_push($grid[7],$val);
                }
                if($key == 8){
                    array_push($grid[6],$val);
                }
            }
        }
        ksort($grid);
        return $grid;
    }
}