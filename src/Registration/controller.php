<?php

namespace Registration;

class Controller
{
    public $fields = [
        'username' => [
            'type' => 'text',
            'placeholder' => 'Username'
        ],
        'password' => [
            'type' => 'password',
            'placeholder' => 'Password'
        ],
        'email' => [
            'type' => 'email',
            'placeholder' => 'Email Address'
        ],
    ];
}
