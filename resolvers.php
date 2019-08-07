<?php

use RedBeanPHP\R;
use function Siler\Dotenv\env;

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

R::setup('mysql:host=' . env('DB_HOST') . ';dbname=' . env('DB_NAME'),
    env('DB_USER'),
    env('DB_PASS'));

$queryType = [
    'poets' => function () {
        return R::findAll('poets');
    },
    'poet' => function ($id) {
        return R::findOne('poets', 'id = ?', $id);
    }
];

return [
    'Query' => $queryType
];
