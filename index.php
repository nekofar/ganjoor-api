<?php

use Siler\GraphQL;
use Siler\Http\Request;
use Siler\Http\Response;

require 'vendor/autoload.php';

// Enable CORS
Response\header('Access-Control-Allow-Origin', '*');
Response\header('Access-Control-Allow-Headers', 'content-type');

// Respond only for POST requests
if (Request\method_is('post')) {
    // Context
    $context['loaders'] = include __DIR__ . '/loaders.php';

    // Retrieve the Schema
    $schema = include __DIR__ . '/schema.php';

    // Give it to Siler
    GraphQL\init($schema, null, $context);
}