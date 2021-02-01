<?php


namespace Engine\Libraries;


class Flash
{

    public static function set($name, $message): void
    {

        if (!isset($_SESSION[$name])) {
            $_SESSION[$name] = [
                'message'   => $message
            ] ;
        }

    }

    public static function get($name) {
        if (isset($_SESSION[$name])) {
            $flash = $_SESSION[$name];
            unset($_SESSION[$name]);
    
            return $flash;
        } else {
            return false;
        }
      
    }

}