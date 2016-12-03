<?php
namespace TicTacToe;

class Session implements ISession {
    public function __construct() {
        $this->start();
    }
    public function all()
    {
        return $_SESSION;
    }
    public function start()
    {
        if (version_compare(PHP_VERSION, '5.4.0', '<')) {
            if(session_id() == '') { session_start();}
        } else  {
            if (session_status() == PHP_SESSION_NONE) {session_start();}
        }
    }
    public function destroy()
    {
        session_destroy();
        unset($_SESSION);
    }
    public function set($key,$var)
    {
        $_SESSION[$key] = $var;
    }
    public function get($key)
    {
        return  isset($_SESSION[$key])?$_SESSION[$key]:null;
    }
    public function remove($key)
    {
        unset($_SESSION[$key]);
    }
}