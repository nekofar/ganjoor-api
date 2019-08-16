<?php

use Siler\GraphQL;

$typeDefs = file_get_contents(__DIR__ . '/schema.graphql');
$resolvers = include 'resolvers.php';

return GraphQL\schema($typeDefs, $resolvers);