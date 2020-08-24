<?php

namespace models;

use Model;
use Token;

class User extends Model
{
    public function __construct()
    {
        parent::__construct('users');
    }

    public function validateUser($action)
    {
        $email = [
            'required' => true,
            'max'      => 50,
        ];

        if ($action == 'create') {
            $email['unique'] = 'users';
        }

        if (Token::check($_POST['token'])) {
            return $this->validate([
                'username' => $_POST['username'],
                'email'    => $_POST['email'],
                'password' => $_POST['password'],
            ],
                [
                    'username' => [
                        'required' => true,
                        'min'      => 2,
                        'max'      => 20,
                    ],
                    'email'    => $email,

                    'password' => [
                        'required' => true,
                        'min'      => 3,
                    ]
                ]);
        } else {
            die('Token invalid');
        }
    }
}