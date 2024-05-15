<?php

namespace App\GraphQL\Resolvers;

use App\Models\Prices;
use App\Database\Database;

class PricesResolver {
    /**
     * Resolves prices by product ID.
     *
     * This method is used as a GraphQL resolver to fetch prices
     * associated with a specific product ID. It initializes the database
     * connection and the Prices model, then retrieves the prices.
     * 
     * @param mixed $root
     * @param mixed $args
     * @return array
     */
    public static function resolveByProductId($root, $args) {
        $db = new Database();
        $pricesModel = new Prices($db);
        return $pricesModel->getByProductId($root['id']);
    }
}