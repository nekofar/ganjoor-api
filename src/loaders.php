<?php

use GraphQL\GraphQL;
use Overblog\DataLoader\DataLoader;
use Overblog\DataLoader\Promise\Adapter\Webonyx\GraphQL\SyncPromiseAdapter;
use Overblog\PromiseAdapter\Adapter\WebonyxGraphQLSyncPromiseAdapter;

$graphQLPromiseAdapter = new SyncPromiseAdapter();
$dataLoaderPromiseAdapter = new WebonyxGraphQLSyncPromiseAdapter($graphQLPromiseAdapter);

GraphQL::setPromiseAdapter($graphQLPromiseAdapter);

$poetLoader = new DataLoader(
    function ($keys) use ($dataLoaderPromiseAdapter) {
        $categories = ORM::for_table('poets')
            ->where_id_in($keys)
            ->find_array();

        return $dataLoaderPromiseAdapter->createAll($categories);
    },
    $dataLoaderPromiseAdapter
);

$categoryLoader = new DataLoader(
    function ($keys) use ($dataLoaderPromiseAdapter) {
        $categories = ORM::for_table('categories')
            ->where_id_in($keys)
            ->find_array();

        return $dataLoaderPromiseAdapter->createAll($categories);
    },
    $dataLoaderPromiseAdapter
);

$categoryByParentIdLoader = new DataLoader(
    function ($keys) use ($dataLoaderPromiseAdapter) {
        $categories = ORM::for_table('categories')
            ->where_in('parentId', $keys)
            ->find_array();

        $collection = new Cake\Collection\Collection($categories);

        return $dataLoaderPromiseAdapter->createAll(array_values($collection->groupBy('parentId')->toArray()));
    },
    $dataLoaderPromiseAdapter
);

$poemLoader = new DataLoader(
    function ($keys) use ($dataLoaderPromiseAdapter) {
        $poems = ORM::for_table('poems')
            ->where_id_in($keys)
            ->find_array();

        return $dataLoaderPromiseAdapter->createAll($poems);
    },
    $dataLoaderPromiseAdapter
);

$verseLoader = new DataLoader(
    function ($keys) use ($dataLoaderPromiseAdapter) {
        $verses = ORM::for_table('verses')
            ->where_id_in($keys)
            ->find_array();

        return $dataLoaderPromiseAdapter->createAll($verses);
    },
    $dataLoaderPromiseAdapter
);

$verseByPoemIdLoader = new DataLoader(
    function ($keys) use ($dataLoaderPromiseAdapter) {
        $verses = ORM::for_table('verses')
            ->where_in('poemId', $keys)
            ->find_array();

        $collection = new Cake\Collection\Collection($verses);

        return $dataLoaderPromiseAdapter->createAll(array_values($collection->groupBy('poemId')->toArray()));
    },
    $dataLoaderPromiseAdapter
);

return compact(
    'verseLoader',
    'verseByPoemIdLoader',
    'categoryLoader',
    'categoryByParentIdLoader',
    'poetLoader',
    'poemLoader'
);