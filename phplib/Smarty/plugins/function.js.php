<?php

    function smarty_function_js($params, &$smarty) {
        if (!array_key_exists('file', $params)) {
            return;
        }

        $file = $params['file'];
        $output = '<script type="text/javascript" src="/assets/js/' . $file . '"></script>';
        return $output;
    }
