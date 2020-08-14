<?php

require_once 'constants.php';
require_once FUNCTIONS . '/functions.php';


spl_autoload_register(function ($className) {
    $fileName = str_replace('\\', '/', $className) . '.php';

    if (file_exists(APP . $fileName)) {
        require_once APP . $fileName;
    } elseif (file_exists(CORE . $fileName)) {
        require_once CORE . $fileName;
    } else {
        throw new Exception('File (' . $fileName . '(does not exist');
    }
});
