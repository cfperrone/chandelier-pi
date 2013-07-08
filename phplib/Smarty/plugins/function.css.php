<?php

    function smarty_function_css($params, &$smarty) {
        if (!array_key_exists('file', $params)) {
            return;
        }

        $file = $params['file'];
        $output = '<link rel="stylesheet" type="text/css" href="/assets/css/' . $file . '">';
        return $output;
    }
