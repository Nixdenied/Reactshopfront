<?php

namespace App\GraphQL\Resolvers;

use App\Models\Items;
use App\Database\Database;

class ItemsResolver {

    /**
     * Resolves items by product ID.
     *
     * This method is used as a GraphQL resolver to fetch items
     * associated with a specific product ID. It initializes the database
     * connection and the Items model, then retrieves the items.
     *
     * @param mixed $root
     * @param mixed $args
     * @return array
     */

    public static function resolveByProductId($root, $args) {
        $db = new Database();
        $itemsModel = new Items($db);
        return $itemsModel->getByProductId($root['id']);
    }
}