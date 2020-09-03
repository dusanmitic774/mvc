<?php

class View
{
    public $isLoggedIn = null;

    public function render($fileName, $data = [])
    {
        extract($data);
        include VIEWS . $fileName . '.php';
    }
}
