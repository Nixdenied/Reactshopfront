<?php

namespace App\GraphQL\Schema;

use App\GraphQL\Types\TypeRegistry;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\GraphQL\Types\Product;
use App\GraphQL\Types\AttributesType;
use App\GraphQL\Types\CategoriesType;
use App\Models\Products;
use App\Models\Attributes;
use App\Models\Categories;
use App\Database\Database;
use App\GraphQL\Resolvers\ProductResolver;
use App\GraphQL\Resolvers\AttributesResolver;
use App\GraphQL\Resolvers\CategoriesResolver;

class QueryType extends ObjectType
{
    /**
     * Constructs the QueryType.
     *
     * This constructor initializes the query type for the GraphQL schema,
     * defining the available query fields and their resolvers.
     */
    
    public function __construct()
    {
        parent::__construct([
            'fields' => static fn(): array => [
                'product' => [
                    'type' => TypeRegistry::product(),
                    'args' => ['id' => Type::nonNull(Type::String())],
                    'resolve' => [ProductResolver::class, 'resolveById']
                ],
                'allProducts' => [
                    'type' => Type::listOf(TypeRegistry::product()),
                    'resolve' => [ProductResolver::class, 'resolveAll']
                ],
                'attributesById' => [
                    'type' => TypeRegistry::attributes(),
                    'args' => ['id' => Type::nonNull(Type::String())],
                    'resolve' => [AttributesResolver::class, 'resolveByProductId']
                ],
                'allCategories' => [
                    'type' => Type::listOf(TypeRegistry::categories()),
                    'resolve' => [CategoriesResolver::class, 'resolveAll'],
                ],
            ]
        ]);
    }
}
