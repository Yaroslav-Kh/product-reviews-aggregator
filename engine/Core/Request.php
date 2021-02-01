<?php

namespace Engine\Core;

class Request
{

    public $request;

    public function __construct()
    {
        $this->request['get'] = $_GET;
        $this->request['post'] = $_POST;
        $this->request['session'] = $_SESSION;

        $this->request['protocol'] = (isset($_SERVER['HTTPS'])) ? 'https://' : 'http://';
        $this->request['domain'] = $this->request['protocol'] . $_SERVER['HTTP_HOST'] . '/';

    }


    public function get($key) {
        return $this->request[$key];
    }

}