<?php

namespace App\GraphQL;

use App\GraphQL\Types\TypeRegistry;
use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;

class SchemaSetup extends Schema
{
    /**
     * Constructs the SchemaSetup.
     *
     * This constructor initializes the GraphQL schema with the specified
     * query and mutation types from the TypeRegistry.
     */
    public function __construct()
    {
        parent::__construct(
            (new SchemaConfig())
                ->setQuery(TypeRegistry::load('Query'))
                ->setMutation(TypeRegistry::load('Mutation'))
        );
    }

    /**
     * Builds and returns a new instance of the SchemaSetup.
     *
     * This static method is a factory method for creating a new
     * instance of the SchemaSetup class.
     *
     * @return SchemaSetup A new instance of the SchemaSetup class.
     */

    public static function build()
    {
        return new self();
    }
}
