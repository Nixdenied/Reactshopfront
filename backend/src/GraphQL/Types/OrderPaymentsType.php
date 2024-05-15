<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

class OrderPaymentsType extends InputObjectType
{
    public function __construct()
    {
        parent::__construct([
            'fields' => static fn(): array => [
                'amount' => Type::nonNull(Type::float()),
                'currency' => Type::nonNull(Type::string()),
                'payment_method' => Type::string(),
            ]
        ]);
    }
}