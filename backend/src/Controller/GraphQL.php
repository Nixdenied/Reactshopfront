<?php

namespace App\Controller;

use App\GraphQL\SchemaSetup;
use GraphQL\GraphQL as GraphQLBase;

class GraphQL {
    
    public static function handle() {
        try {
            $schema = SchemaSetup::build();
            $rawInput = file_get_contents('php://input');
            $input = json_decode($rawInput, true);
            $query = $input['query'];
            $variableValues = $input['variables'] ?? [];

            $result = GraphQLBase::executeQuery($schema, $query, null, null, $variableValues);
            $output = $result->toArray();
        } catch (\Throwable $e) {
            $output = [
                'error' => ['message' => $e->getMessage()],
            ];
        }

        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($output);
    }
}
