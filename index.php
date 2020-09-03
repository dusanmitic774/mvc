<link rel="stylesheet" href="css/style.css">
<?php

session_start();
require_once 'config/autoload.php';
require_once 'routes/web.php';


$test = Route::run($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

// CHANGED DOCUMENT ROOT in 000-default apache file from /html to /mvc