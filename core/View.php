<?php

class View
{
    public function render($fileName, $data = [])
    {
        extract($data);
        include VIEWS . $fileName . '.php';
    }
}
