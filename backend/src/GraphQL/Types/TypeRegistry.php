<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\NamedType;
use App\GraphQL\Types\ProductType;
use App\GraphQL\Types\AttributesType;
use App\GraphQL\Types\CategoriesType;
use App\GraphQL\Types\CurrencyType;
use App\GraphQL\Types\ItemsType;
use App\GraphQL\Types\PricesType;
use App\GraphQL\Types\OrderSelectedOptionsType;
use App\GraphQL\Types\OrdersType;
use App\GraphQL\Schema\MutationType;
use App\GraphQL\Schema\QueryType;
use App\GraphQL\Types\OrdersResponseType;

final class TypeRegistry
{
    /** @var array<string, Type&NamedType> */
    private static array $types = [];

    /** @return Type&NamedType */
    public static function load(string $typeName): Type
    {
        if (isset(self::$types[$typeName])) {
            return self::$types[$typeName];
        }

        // For every type, this class must define a method with the same name
        // but the first letter is in lower case.
        $methodName = match ($typeName) {
            'ID' => 'id',
            default => lcfirst($typeName),
        };
        if (!method_exists(self::class, $methodName)) {
            throw new \Exception("Unknown GraphQL type: {$typeName}.");
        }

        $type = self::{$methodName}(); // @phpstan-ignore-line variable static method call
        if (is_callable($type)) {
            $type = $type();
        }

        return self::$types[$typeName] = $type;
    }

    /** @return Type&NamedType */
    private static function byClassName(string $className): Type
    {
        $classNameParts = explode('\\', $className);
        $baseClassName = end($classNameParts);
        // All type classes must use the suffix Type.
        // This prevents name collisions between types and PHP keywords.
        $typeName = preg_replace('~Type$~', '', $baseClassName);

        // Type loading is very similar to PHP class loading, but keep in mind
        // that the **typeLoader** must always return the same instance of a type.
        // We can enforce that in our type registry by caching known types.
        return self::$types[$typeName] ??= new $className;
    }

    /** @return \Closure(): (Type&NamedType) */
    private static function lazyByClassName(string $className): \Closure
    {
        return static fn() => self::byClassName($className);
    }
    public static function product(): callable
    {
        return self::lazyByClassName(ProductType::class);
    }

    public static function attributes(): callable
    {
        return self::lazyByClassName(AttributesType::class);
    }

    public static function categories(): callable
    {
        return self::lazyByClassName(CategoriesType::class);
    }

    public static function currency(): callable
    {
        return self::lazyByClassName(CurrencyType::class);
    }

    public static function items(): callable
    {
        return self::lazyByClassName(ItemsType::class);
    }

    public static function prices(): callable
    {
        return self::lazyByClassName(PricesType::class);
    }

    public static function mutation(): callable
    {
        return self::lazyByClassName(MutationType::class);
    }

    public static function query(): callable
    {
        return self::lazyByClassName(QueryType::class);
    }

    public static function orders(): callable
    {
        return self::lazyByClassName(OrdersType::class);
    }

    public static function selectedOptions(): callable
    {
        return self::lazyByClassName(OrderSelectedOptionsType::class);
    }

    public static function orderPayments(): callable
    {
        return self::lazyByClassName(OrderPaymentsType::class);
    }

    public static function orderItems(): callable
    {
        return self::lazyByClassName(OrderItemsType::class);
    }

    public static function ordersResponseType(): callable
    {
        return self::lazyByClassName(OrdersResponseType::class);
    }
}