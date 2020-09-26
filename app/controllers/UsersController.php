<?php

namespace controllers;

use Auth;
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
        $user  = $users->select()->find($id)->first();

        if (Auth::check()) {
            if (! empty($user)) {
                if (Auth::user()->username == $user->username) {
                    $this->view->render('show/show', [
                        'user' => $user,
                    ]);
                } else {
                    Flash::msg('loggedin', 'Not Your account');
                    redirect(route('home'));
                }
            } else {
                redirect(route('404'));
            }
        } else {
            Flash::msg('loggedin', 'You need to log in first');
            redirect(route('home'));
        }
    }

    public function edit($id)
    {
        $user = new User();
        $user = $user->select()->find($id)->get();

        if (! empty($user)) {
            $this->view->render('edit/edit', [
                'user' => $user[0],
            ]);
        }
    }

    public function delete()
    {
        $user = new User();
        $user->delete($_POST['id']);
        redirect(route('home'));
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

            redirect(route('home'));
        } else {
            $errors = $user->errors();

            Input::setPostData($_POST);
            Flash::errors($errors);
            redirect(route('users.create'));
        }
    }

    public function update()
    {
        $user   = new User();
        $result = $user->select()->find($_POST['id'])->first();

        $passed = $user->validateUser('update');

        if ($passed) {
            if (! empty($result)) {
                $user->update([
                    'username' => $_POST['username'],
                    'password' => Hash::password($_POST['password']),
                    'email'    => $_POST['email'],
                ], $result->id);

                redirect(route('home'));
            }
        } else {
            $errors = $user->errors();

            Flash::errors($errors);
            redirect(route('users.edit') . $result->id);
        }
    }

    public function upload($id)
    {
        $unique      = uniqid('', true);
        $target_dir  = "images/";
        $target_file = $target_dir . $unique . '_' . basename($_FILES["img"]["name"]);
        if (isset($_POST["btn"])) {
            $check = getimagesize($_FILES["img"]["tmp_name"]);
            if ($check !== false) {
                // upload image
                if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
                    echo "The file " . basename($_FILES["img"]["name"]) . " has been uploaded.";
                } else {
                    Flash::msg('image', 'Sorry, there was an error uploading your file.');
                    redirect(route('users.show') . $id);
                }
            } else {
                Flash::msg('image', 'File is not an image');
                redirect(route('users.show') . $id);
            }
        }
        $user = new User();
        $user->update(['image' => $target_file], $id);

        redirect(route('home'));
    }
}
