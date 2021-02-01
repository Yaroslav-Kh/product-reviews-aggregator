<?php


namespace Engine\Core;

abstract class Controller
{
    protected $view;
    protected $request;
    protected $model;

    public function __construct()
    {

    	$this->request = new Request();
        $this->view = new View();

    }

    protected function model($model) {
        $this->model = new $model();
    }

}