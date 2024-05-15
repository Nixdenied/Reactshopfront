<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ItemsType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'fields' => static fn(): array => [
                'displayValue' => Type::string(),
                'value' => Type::string(),
                'external_id' => Type::string(),
            ]
        ]);
    }
}