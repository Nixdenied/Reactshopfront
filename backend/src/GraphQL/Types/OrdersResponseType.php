<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class OrdersResponseType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'fields' => static fn(): array => [
                'order_id' => Type::nonNull(Type::int()),
                'status' => Type::nonNull(Type::string()),
                'message' => Type::nonNull(Type::string())            ]
        ]);
    }
}