<?php

    function smarty_function_icon($params, &$smarty) {
        if (!array_key_exists('file', $params)) {
            return;
        }

        $file = $params['file'];
        $output = '<img src="/assets/img/icons/' . $file . '.png" width="16px" height="16px" alt="' . $file . '" />';
        return $output;
    }
