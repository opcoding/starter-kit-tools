<?php

use Opcoding\StarterKit\Tools\StarterKit;

return[
    StarterKit::KEY_QUESTION_DOCKER => [
        1 => [
            'question' => 'Do you want docker ?',
            'default' => 'y',
            'choices' => [
                'y' => 'Yes',
                'n' => 'No',
            ],
            'example' => null,
        ],
        2 => [
            'question' => 'Choose your container name ',
            'default' => 'project',
            'example' => '<comment>Project</comment> which become project-api_php',
        ],
        3 => [
            'question' => 'Choose your apache port ',
            'default' => '8080',
            'example' => null,
        ]
    ],
    StarterKit::KEY_QUESTION_ASSETS => [
        1 => [
            'question' => 'What bootstrap theme you want ? ',
            'default' => 'mdb',
            'choices' => [
                'mdb' => 'Bootstrap Material Design',
                'bt' => 'Bootstrap'
            ],

        ],
    ],
    StarterKit::KEY_QUESTION_COMPOSER => [
        1 => [
            'question' => 'Choose your project name ',
            'default' => null,
            'example' => 'foo/bar',
        ],
        2 => [
            'question' => 'Choose your project description ',
            'default' => null,
            'example' => 'My foo Bar Project',
        ],
        3 => [
            'question' => 'What namespace need to be autoload ? ',
            'default' => null,
            'example' =>  'Foo\\\\Bar',
        ],
        4 => [
            'question' => 'Which name for your application (displayed on your site) ? ',
            'default' => 'Objective PHP',
            'example' =>  'My project',
        ],
    ]
];