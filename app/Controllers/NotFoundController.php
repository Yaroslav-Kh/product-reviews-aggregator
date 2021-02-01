<?php


namespace App\Controllers;

use Engine\Core\Controller;

class NotFoundController extends Controller
{

    public function index($folder) {

        return $this->view->render('not_found');

    }

}