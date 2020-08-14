<?php

namespace controllers;

use Controller;
use models\User;

class UsersController extends Controller
{
    public function index()
    {
        echo 'Index Function';
    }

    public function show()
    {
        $user    = new User();
        $results = $user->select()->find(8)->get();


        if ($results != false) {
            $this->view->render('test/test', [
                'users' => $results
            ]);
        } else {
            echo 'Syntax Error';
        }

    }

    public function delete()
    {
        $user = new User();
        $user->delete(10);
    }

    public function create()
    {
        $this->view->render('create/create');
    }

    public function store()
    {
//        var_dump($_POST['fname']);die();
        $user = new User();
        $user->create(['fname' => $_POST['fname'], 'lname' => $_POST['lname']]);

        redirect('/users/show');
    }

    public function update()
    {
        $user = new User();
        $user->update(['lname' => 'Mitic', 'fname' => 'Latinka'], 3);
    }
}