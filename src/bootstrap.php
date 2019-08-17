<?php

use Dotenv\Dotenv;
use GraphQL\Executor\Executor;
use GraphQL\GraphQL;
use Siler\Http\Request;
use Siler\Http\Response;

// Loads environment variables
Dotenv::create('../')->load();

// Enable CORS
Response\header('Access-Control-Allow-Origin', '*');
Response\header('Access-Control-Allow-Headers', 'content-type');

// Respond only for POST requests
if (Request\method_is('post')) {
    // Context
    $context['loaders'] = include 'loaders.php';

    // Retrieve the Schema
    $schema = include 'schema.php';

    // Initializes a new GraphQL endpoint.
    if (preg_match('#application/json(;charset=utf-8)?#', Request\header('Content-Type'))) {
        $data = Request\json('php://input');
    } else {
        $data = Request\post();
    }

    if (!is_array($data)) {
        throw new UnexpectedValueException('Input should be a JSON object');
    }

    // Executes a GraphQL query over a schema.
    $promise = GraphQL::promiseToExecute(
        Executor::getPromiseAdapter(),
        $schema,
        Siler\array_get($data, 'query'),
        null,
        $context,
        Siler\array_get($data, 'variables'),
        Siler\array_get($data, 'operationName')
    );

    Response\json($graphQLPromiseAdapter->wait($promise));
}