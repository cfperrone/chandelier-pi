<?php

class Controller_Base {
    protected $request;
    protected $response;
    private $view;
    protected $config;
    protected $dao;

    function __construct() {
        if (!$this->request) {
            $this->request = HTTP_Request::getInstance();
        }
        if (!$this->response) {
            $this->response = HTTP_Response::getInstance();
        }
        $this->view = $this->createView();
        $this->config = new Config();

        $this->dao = new DAO();
    }

    private function getView() {
        return $this->view;
    }

    private function createView() {
        $view = new Smarty();
        $root_dir = "/home/pi/www/chandelier/";
        $view->setTemplateDir($root_dir . 'templates');
        $view->setCompileDir($root_dir . 'tmp/templates_c');
        $view->setCacheDir($root_dir . 'tmp/smarty_cache');
        $view->caching = 0;
        $view->left_delimiter = "{% ";
        $view->right_delimiter = " %}";
        return $view;
    }

    protected function render($file) {
        $view = $this->getView();

        // assign site global values
        $view->assign(array(
            'site_url'  => 'http://raspberrypi/',
        ));

        $view->display($file);
    }

    protected function assign() {
        $args = func_get_args();
        return call_user_func_array(array($this->getView(), 'assign'), $args);
    }

    // Returns a string timestamp formatted for insertion in mysql
    protected function now() {
        return date( 'Y-m-d H:i:s' );
    }
}
