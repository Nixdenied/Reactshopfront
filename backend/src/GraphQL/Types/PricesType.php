<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\GraphQL\Resolvers\CurrencyResolver;

class PricesType extends ObjectType{
    public function __construct() {
        parent::__construct([
            'fields' => static fn (): array => [
                'amount' => Type::float(),
                'currency' => [
                    'type' => TypeRegistry::currency(),
                    'resolve' => [CurrencyResolver::class, 'resolveByPriceId']
                ],
                ]
            ]);
    }
}