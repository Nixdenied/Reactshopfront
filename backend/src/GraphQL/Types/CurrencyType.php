<?php

 namespace App\GraphQL\Types;

 use GraphQL\Type\Definition\ObjectType;
 use GraphQL\Type\Definition\Type;

 class CurrencyType extends ObjectType {
    public function __construct() {
        parent::__construct([
            'fields' => static fn (): array => [
                'label' => Type::string(),
                'symbol' => Type::string(),
            ]
            ]);
    }
 }