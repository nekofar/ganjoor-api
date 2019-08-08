<?php

use Dotenv\Dotenv;
use RedBeanPHP\R;

Dotenv::create(__DIR__)->load();

R::setup('mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASS'));

$queryType = [
    'poets' => function () {
        return R::findAll('poets');
    },
    'poet' => function ($root, $args) {
        return R::findOne('poets', 'id = ?', [$args['id']]);
    },
    'categories' => function ($root, $args) {
        return R::findAll('categories', 'poetId = ?', [$args['poetId']]);
    },
    'category' => function ($root, $args) {
        return R::findOne('categories', 'id = ?', [$args['id']]);
    },
    'poems' => function ($root, $args) {
        return R::findAll('poems', 'categoryId = ?', [$args['categoryId']]);
    },
    'poem' => function ($root, $args) {
        return R::findOne('poems', 'id = ?', [$args['id']]);
    },
];

return [
    'Query' => $queryType
];