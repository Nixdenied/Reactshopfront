<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

class OrdersType extends InputObjectType
{
    public function __construct()
    {
        parent::__construct([
            'fields' => static fn(): array => [
                'customer_id' => Type::nonNull(Type::int()),
                'status' => Type::string(),
                'order_items' => Type::nonNull(Type::listOf(TypeRegistry::orderItems())),
                'order_payments' => TypeRegistry::orderPayments(),
            ]
        ]);
    }
}