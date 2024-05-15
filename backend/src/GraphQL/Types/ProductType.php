<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\GraphQL\Resolvers\AttributesResolver;
use App\GraphQL\Resolvers\GalleryResolver;
use App\GraphQL\Resolvers\PricesResolver;
use App\GraphQL\Types\TypeRegistry;

class ProductType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'fields' => static fn (): array => [
                'id' => Type::int(),
                'external_id' => Type::string(),
                'name' => Type::string(),
                'inStock' => Type::Boolean(),
                'gallery' => [
                    'type' => Type::listOf(Type::String()),
                    'resolve' => [GalleryResolver::class, 'resolveByProductId']
                ],
                'description' => Type::string(),
                'category' => Type::string(),
                'prices' => [
                    'type' => Type::listOf(TypeRegistry::prices()),
                    'resolve' => [PricesResolver::class, 'resolveByProductId']
                ],
                'brand' => Type::string(),
                'attributes' => [
                    'type' => Type::listOf(TypeRegistry::attributes()),
                    'resolve' => [AttributesResolver::class, 'resolveByProductId']
                ]
            ],
        ]);
    }
}