<?php

use GraphQL\GraphQL;
use Overblog\DataLoader\DataLoader;
use Overblog\DataLoader\Promise\Adapter\Webonyx\GraphQL\SyncPromiseAdapter;
use Overblog\PromiseAdapter\Adapter\WebonyxGraphQLSyncPromiseAdapter;

$graphQLPromiseAdapter = new SyncPromiseAdapter();
$dataLoaderPromiseAdapter = new WebonyxGraphQLSyncPromiseAdapter($graphQLPromiseAdapter);

GraphQL::setPromiseAdapter($graphQLPromiseAdapter);

$verseLoader = new DataLoader(
    function ($keys) use ($dataLoaderPromiseAdapter) {
        $verses = ORM::for_table('verses')
            ->where_id_in($keys)
            ->find_array();

        return $dataLoaderPromiseAdapter->createAll($verses);
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

$categoryLoader = new DataLoader(
    function ($keys) use ($dataLoaderPromiseAdapter) {
        $categories = ORM::for_table('categories')
            ->where_id_in($keys)
            ->find_array();

        return $dataLoaderPromiseAdapter->createAll($categories);
    },
    $dataLoaderPromiseAdapter
);

$poetLoader = new DataLoader(
    function ($keys) use ($dataLoaderPromiseAdapter) {
        $categories = ORM::for_table('poets')
            ->where_id_in($keys)
            ->find_array();

        return $dataLoaderPromiseAdapter->createAll($categories);
    },
    $dataLoaderPromiseAdapter
);

return compact('verseLoader', 'categoryLoader', 'poetLoader', 'poemLoader');