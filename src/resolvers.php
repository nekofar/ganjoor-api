<?php

use Overblog\DataLoader\DataLoader;

ORM::configure('mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME'));
ORM::configure('username', getenv('DB_USER'));
ORM::configure('password', getenv('DB_PASS'));
ORM::configure('driver_options', [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']);

$poetType = [
    'category' => function ($root, $args, $context) {
        return ($context['loaders']['categoryLoader']->load($root['categoryId']));
    }
];

$categoryType = [
    'children' => function ($root, $args, $context) {
        return ($context['loaders']['categoryLoader']->loadMany(array_map(
            function ($category) {
                return $category['id'];
            },
            ORM::for_table('categories')
                ->select('id')
                ->where('parentId', $root['id'])
                ->find_array()
        )));
    }
];

$poemType = [
    'verses' => function ($root, $args, $context) {
        return ($context['loaders']['verseLoader']->loadMany(array_map(
            function ($verse) {
                return $verse['id'];
            },
            ORM::for_table('verses')
                ->select('id')
                ->where('poemId', $root['id'])
                ->find_array()
        )));
    }
];

$queryType = [
    'poets' => function ($root, $args, $context) {
        return ($context['loaders']['poetLoader']->loadMany(array_map(
            function ($poet) {
                return $poet['id'];
            },
            ORM::for_table('poets')
                ->select('id')
                ->find_array()
        )));
    },
    'poet' => function ($root, $args, $context) {
        return ($context['loaders']['poetLoader']->load($args['id']));
    },
    'category' => function ($root, $args, $context) {
        return ($context['loaders']['categoryLoader']->load($args['id']));
    },
    'poems' => function ($root, $args, $context) {
        return ($context['loaders']['poemLoader']->loadMany(array_map(
            function ($poem) {
                return $poem['id'];
            },
            ORM::for_table('poems')
                ->select('id')
                ->where('categoryId', $args['categoryId'])
                ->find_array()
        )));
    },
    'poem' => function ($root, $args, $context) {
        return ($context['loaders']['poemLoader']->load($args['id']));
    },
];

return [
    'Poet' => $poetType,
    'Category' => $categoryType,
    'Poem' => $poemType,
    'Query' => $queryType
];