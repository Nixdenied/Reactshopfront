<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

class OrderSelectedOptionsType extends InputObjectType
{
    public function __construct()
    {
        parent::__construct([
            'fields' => static fn(): array => [
                'attribute_name' => Type::string(),
                'attribute_value' => Type::string(),
            ]
        ]);
    }
}