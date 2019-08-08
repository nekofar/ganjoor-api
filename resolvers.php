<?php

use Dotenv\Dotenv;

Dotenv::create(__DIR__)->load();

ORM::configure('mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME'));
ORM::configure('username', getenv('DB_USER'));
ORM::configure('password', getenv('DB_PASS'));
ORM::configure('driver_options', [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']);

$poetType = [
    'category' => function ($root, $args) {
        return ORM::for_table('categories')
            ->where('id', $root['categoryId'])
            ->find_one();
    }
];

$categoryType = [
    'children' => function ($root, $args) {
        return ORM::for_table('categories')
            ->where('parentId', $root['id'])
            ->find_many();
    }
];

$poemType = [
    'verses' => function ($root, $args) {
        return ORM::for_table('verses')
            ->where('poemId', $root['id'])
            ->find_many();
    }
];

$queryType = [
    'poets' => function ($root, $args) {
        return ORM::for_table('poets')
            ->find_many();
    },
    'poet' => function ($root, $args) {
        return ORM::for_table('poets')
            ->where('id', $args['id'])
            ->find_one();
    },
    'category' => function ($root, $args) {
        return ORM::for_table('categories')
            ->where('id', $args['id'])
            ->find_one();
    },
    'poems' => function ($root, $args) {
        return ORM::for_table('poems')
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
    'Poet' => $poetType,
    'Category' => $categoryType,
    'Poem' => $poemType,
    'Query' => $queryType
];