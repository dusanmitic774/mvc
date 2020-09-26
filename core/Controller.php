<?php

abstract class Controller
{
    protected $view = null;

    public function __construct()
    {
        $this->view = new View();
    }

    public function notFound()
    {
        $this->view->render('404/404');
    }
}
