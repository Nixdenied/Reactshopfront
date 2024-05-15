<?php

namespace App\GraphQL\Resolvers;

use App\Models\Currency;
use App\Database\Database;

class CurrencyResolver {

    /**
     * Resolves currency by price ID.
     *
     * This method is used as a GraphQL resolver to fetch currency data
     * associated with a specific price ID. It initializes the database
     * connection and the Currency model, then retrieves the currency data.
     *
     * @param mixed $root
     * @param mixed $args
     * @return array
     */

    public static function resolveByPriceId($root, $args) {      
        $db = new Database();
        $currencyModel = new Currency($db);
        return $currencyModel->getByPriceId($root['id']);
    }
}
