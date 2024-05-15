<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class CategoriesType extends ObjectType
{
    /**
     * Constructs the CategoriesType.
     *
     * This constructor initializes the categories type for the GraphQL schema,
     * defining the available fields.
     */
    
    public function __construct()
    {
        parent::__construct([
            'fields' => static fn (): array => [
                'name' => Type::string(),
            ]
        ]);
    }
}