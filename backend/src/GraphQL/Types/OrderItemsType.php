<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

class OrderItemsType extends InputObjectType
{
    public function __construct()
    {
        parent::__construct([
            'fields' => static fn(): array => [
                'product_id' => Type::nonNull(Type::string()),
                'quantity' => Type::nonNull(Type::int()),
                'order_selected_options' => type::listOf(TypeRegistry::selectedOptions())
            ]
        ]);
    }
}