<?php

class Controller_Index extends Controller_Base {
    public function __construct() {
        parent::__construct();
    }

    public function route() {
        $this->assign('title', 'Home');
        $this->render('pages/index.tpl');
    }
}
