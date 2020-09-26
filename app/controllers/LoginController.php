<?php

namespace controllers;

use Auth;
use Controller;
use Flash;
use Hash;
use Input;
use models\User;
use Session;
use Token;

class LoginController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->user = new User();
        parent::__construct();
    }

    public function loginForm()
    {
        $this->view->render('login/login');
    }

    public function login()
    {
        if (Token::check($_POST['token'])) {
            $passed = $this->user->validate(
                [
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
                ]
            );
        } else {
            die('Token invalid');
        }

        // if validation passes ...
        if ($passed) {
            // selects username attempting to login
            $result = $this->user->select()->where([['username', '=', Input::get('username')]])->first();

            // checks if username exists in db
            if (! empty($result)) {
                $password = $result->password;

                // checks if passwords match
                if (Hash::verify($_POST['password'], $password)) {
                    Session::set('user_session', $result->id);
                    redirect(route('home'));
                } else {
                    Flash::msg('password', 'Wrong Password');
                }
            } else {
                Flash::msg('error', 'No such user');
                redirect(route('users.login'));
            }
        } else {
            $errors = $this->user->errors();

            Input::setPostData($_POST);
            Flash::errors($errors);
            redirect(route('users.login'));
        }
    }

    public function logOut()
    {
        if (Auth::check()) {
            Session::delete('user_session');

            redirect(route('home'));
        }

        redirect(route('home'));
    }
}
