<?php

use Dotenv\Dotenv;
use Siler\GraphQL;
use Siler\Http\Request;
use Siler\Http\Response;

// Loads environment variables
Dotenv::create( '../')->load();

// Enable CORS
Response\header('Access-Control-Allow-Origin', '*');
Response\header('Access-Control-Allow-Headers', 'content-type');

// Respond only for POST requests
if (Request\method_is('post')) {
    // Context
    $context['loaders'] = include 'loaders.php';

    // Retrieve the Schema
    $schema = include 'schema.php';

    // Give it to Siler
    GraphQL\init($schema, null, $context);
}