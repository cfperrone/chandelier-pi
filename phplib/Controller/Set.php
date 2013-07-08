<?php

class Controller_Set extends Controller_Base {
    public function __construct() {
        parent::__construct();
    }

    public function route() {
        if ($this->request->isPost()) {
            $this->setValues();
        } else {
            $this->showForm();
        }
    }

    /**
     * Shows the form for users to modify settings
     */
    private function showForm() {
        // get the current values
        $this->assign('config', $this->config->getAll());

        $this->assign('title', 'Configure');
        $this->render('pages/set.tpl');
    }

    /**
     * Actually commits values from the POST request
     */
    private function setValues() {
        $proc = new Proc($this->config);

        // figure out what function we're calling
        $function = $this->request->getPost('function', null);
        if ($function == 'solid') {
            // determine the selected colors
            $colors = array(
                'red'   => (int)$this->request->getPost('red', 0),
                'green' => (int)$this->request->getPost('green', 0),
                'blue'  => (int)$this->request->getPost('blue', 0),
            );

            // save the colors to the config
            $this->config->set('solid_rgb', $colors);

            // fork off the function
            $proc->runFunction('solid');
        } else if ($function == 'pulse') {
            // determine the selected colors
            $colors = array(
                'red' => (int)$this->request->getPost('red', 0),
                'green' => (int)$this->request->getPost('green', 0),
                'blue' => (int)$this->request->getPost('blue', 0),
            );

            // get the wait and hold values
            $wait = (int)$this->request->getPost('wait', 0);
            $hold = (int)$this->request->getPost('hold', 0);

            // save the config
            $this->config->setArray(array(
                'pulse_rgb' => $colors,
                'pulse_wait_time' => $wait,
                'pulse_hold_time' => $hold,
            ));

            // fork off the function
            $proc->runFunction('pulse');
        } else if ($function == 'dual') {
            // determine selected colors
            $colors1 = array(
                'red' => (int)$this->request->getPost('red1', 0),
                'green' => (int)$this->request->getPost('green1', 0),
                'blue' => (int)$this->request->getPost('blue1', 0),
            );
            $colors2 = array(
                'red' => (int)$this->request->getPost('red2', 0),
                'green' => (int)$this->request->getPost('green2', 0),
                'blue' => (int)$this->request->getPost('blue2', 0),
            );

            // get the wait and hold values
            $wait = (int)$this->request->getPost('wait', 0);
            $hold = (int)$this->request->getPost('hold', 0);

            // save the config
            $this->config->setArray(array(
                'dual_rgb_0' => $colors1,
                'dual_rgb_1' => $colors2,
                'pulse_wait_time' => $wait,
                'pulse_hold_time' => $hold,
            ));

            // fork off the function
            $proc->runFunction('dual');
        } else if ($function == 'multi') {
            $wait = (int)$this->request->getPost('wait', 0);
            $hold = (int)$this->request->getPost('hold', 0);

            $multi = $this->request->getPost('multi', array());
            $output = array();
            foreach ($multi as $index=>$rgb) {
                $arr = array('wait' => $wait, 'hold' => $hold);
                foreach ($rgb as $color=>$value) {
                    if ($value == '') {
                        $arr[$color] = 0;
                    } else {
                        $arr[$color] = (int)$value;
                    }
                }
                $output[] = $arr;
            }

            $this->config->set("multi_array", $output);

            $proc->runFunction('multi');
        } else if ($function == 'off') {
            echo "turning off";
            $proc->runFunction('off');
        }
    }
}
