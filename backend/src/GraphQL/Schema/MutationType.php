<?php

namespace App\GraphQL\Schema;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\GraphQL\Resolvers\OrdersResolver;
use App\GraphQL\Types\TypeRegistry;

class MutationType extends ObjectType
{
    /**
     * Constructs the MutationType.
     *
     * This constructor initializes the mutation type for the GraphQL schema,
     * defining the available mutation fields and their resolvers.
     */
    
    public function __construct()
    {
        parent::__construct([
            'fields' => static fn(): array => [
                'createOrders' => [
                    'type' => Type::nonNull(Type::listOf(TypeRegistry::ordersResponseType())),
                    'args' => [
                        'orders' => Type::nonNull(Type::listOf(TypeRegistry::orders()))
                    ],
                    'resolve' => [OrdersResolver::class, 'createOrders']
                ]
            ]
        ]);
    }
}
