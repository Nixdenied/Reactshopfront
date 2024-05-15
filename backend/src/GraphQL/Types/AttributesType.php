<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\GraphQL\Resolvers\ItemsResolver;

class AttributesType extends ObjectType
{

    /**
     * Constructs the AttributesType.
     *
     * This constructor initializes the attributes type for the GraphQL schema,
     * defining the available fields and their resolvers.
     */

    public function __construct()
    { {
            parent::__construct([
                'fields' => static fn(): array => [
                    'external_id' => Type::string(),
                    'name' => Type::string(),
                    'type' => Type::string(),
                    'items' => [
                        'type' => Type::listOf(TypeRegistry::items()),
                        'resolve' => [ItemsResolver::class, 'resolveByProductId']
                    ],
                ]
            ]);
        }
    }
}