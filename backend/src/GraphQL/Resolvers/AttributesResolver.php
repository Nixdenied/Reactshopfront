<?php

namespace App\GraphQL\Resolvers;

use App\Models\Attributes;
use App\Database\Database;

class AttributesResolver {

    /**
     * Resolves attributes by product ID.
     *
     * This method is used as a GraphQL resolver to fetch attributes
     * associated with a specific product ID. It initializes the database
     * connection and the Attributes model, then retrieves the attributes.
     *
     * @param mixed $root
     * @param mixed $args
     * @return array
     */

    public static function resolveByProductId($root, $args) {
        $db = new Database();
        $attributesModel = new Attributes($db);
        return $attributesModel->getByProductId($root['id']);
    }
}
