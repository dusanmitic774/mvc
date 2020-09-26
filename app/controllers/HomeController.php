<?php

namespace controllers;

use Controller;

class HomeController extends Controller
{
    public function notFound()
    {
        $this->view->render('404/404');
    }
}