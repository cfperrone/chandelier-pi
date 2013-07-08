<?php

// This controller is designed to show and eventually allow for editable runtime configuration
class Controller_Config extends Controller_Base {
    public function __construct() {
        parent::__construct();
    }

    public function route() {
        // convert config to strings
        $output = array();
        foreach ($this->config->getAll() as $key=>$value) {
            if ($value == null) {
                $output[$key] = NULL;
            } else if (is_array($value)) {
                $output[$key] = json_encode($value);
            } else if (is_bool($value)) {
                $output[$key] = $value?"TRUE":"FALSE";
            } else {
                $output[$key] = $value;
            }
        }

        $this->assign('title', 'Configuration');
        $this->assign('config', $output);
        $this->render('pages/config.tpl');
    }
}
