<?php
include('vendor/autoload.php');

$api = new TicTacToe\Api(new TicTacToe\Session());
$request = new TicTacToe\Request($_REQUEST);
echo json_encode(call_user_func([$api,$_REQUEST['action']],$request));