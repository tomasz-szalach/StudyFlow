<?php

require_once 'SessionController.php';

class DefaultController extends SessionController {

    public function index(){
        $this->render('login');
    }

    public function addTaskList()
    {
        $this->render('addTaskList');
    }

}
