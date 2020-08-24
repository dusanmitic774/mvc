<?php

namespace controllers;

use Controller;
use Hash;
use models\User;
use Session;
use Token;
use Flash;
use Input;

class UsersController extends Controller
{
    public function index()
    {
        $user    = new User();
        $results = $user->select()->get();

        if ($results !== false) {
            $this->view->render('index/index', [
                'users' => $results
            ]);
        } else {
            echo 'Syntax Error';
        }
    }

    public function show($id)
    {
        $users = new User();
        $user  = $users->select()->find($id)->get();

        if ( ! empty($user)) {
            $this->view->render('show/show', [
                'user' => $user[0],
            ]);
        } else {
            redirect('404');
        }
    }

    public function edit($id)
    {
        $user = new User();
        $user = $user->select()->find($id)->get();

        if ( ! empty($user)) {
            $this->view->render('edit/edit', [
                'user' => $user[0],
            ]);
        }
    }

    public function delete()
    {
        $user = new User();
        $user->delete($_POST['id']);
        redirect('');
    }

    public function create()
    {
        $this->view->render('create/create');
    }

    public function store()
    {
        $user = new User();

        $passed = $user->validateUser('create');

        if ($passed) {
            $user->create([
                'username' => $_POST['username'],
                'password' => Hash::password($_POST['password']),
                'email'    => $_POST['email'],
            ]);

            redirect('');
        } else {
            $errors = $user->errors();

            Input::setPostData($_POST);
            Flash::errors($errors);
            redirect('users/create');
        }
    }

    public function update()
    {
        $user = new User();
        $id   = $user->select()->find($_POST['id'])->get();

        $passed = $user->validateUser('update');

        if ($passed) {
            if ( ! empty($id)) {
                $user->update([
                    'username' => $_POST['username'],
                    'password' => $_POST['password'],
                    'email'    => $_POST['email'],
                ], $id[0]->id);

                redirect('');
            }
        } else {
            $errors = $user->errors();

            Flash::errors($errors);
            redirect('users/edit/' . $id[0]->id);
        }
    }

    public function loginForm()
    {
        $this->view->render('login/login');
    }

    public function login()
    {
        $user = new User();

        if (Token::check($_POST['token'])) {
            $passed = $user->validate([
                'username' => $_POST['username'],
                'password' => $_POST['password'],
            ],
                [
                    'username' => [
                        'required' => true,
                    ],
                    'password' => [
                        'required' => true,
                    ]
                ]);
        } else {
            die('Token invalid');
        }

        if ($passed) {
            $result = $user->select()->where([['username', '=', $_POST['username']]])->get();
            if ( ! empty($result)) {
                $password = $result[0]->password;
                if (Hash::veryfy($_POST['password'], $password)) {
                    Session::set('username-' . $result[0]->username, $result[0]->id);
                    $lol = 'lol';
                }

            } else {
                Flash::msg('error', 'No such user');
                redirect('users/login');
            }
        } else {
            $errors = $user->errors();

            Input::setPostData($_POST);
            Flash::errors($errors);
            redirect('users/login');
        }

    }
}