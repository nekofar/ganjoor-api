<?php

use Dotenv\Dotenv;

Dotenv::create(__DIR__)->load();

ORM::configure('mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME'));
ORM::configure('username', getenv('DB_USER'));
ORM::configure('password', getenv('DB_PASS'));
ORM::configure('driver_options', [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']);

$queryType = [
    'poets' => function () {
        return ORM::for_table('poets')
            ->find_many();
    },
    'poet' => function ($root, $args) {
        return ORM::for_table('poets')
            ->where('id', $args['id'])
            ->find_one();
    },
    'categories' => function ($root, $args) {
        return ORM::for_table('categories')
            ->where('poetId', $args['poetId'])
            ->find_many();
    },
    'category' => function ($root, $args) {
        return ORM::for_table('categories')
            ->where('id', $args['id'])
            ->find_one();
    },
    'poems' => function ($root, $args) {
        return ORM::for_table('categories')
            ->where('categoryId', $args['categoryId'])
            ->find_many();
    },
    'poem' => function ($root, $args) {
        return ORM::for_table('poems')
            ->where('id', $args['id'])
            ->find_one();
    },
];

return [
    'Query' => $queryType
];