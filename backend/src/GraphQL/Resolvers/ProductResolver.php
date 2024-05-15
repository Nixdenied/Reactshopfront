<?php

namespace App\GraphQL\Resolvers;

use App\Models\Products;
use App\Database\Database;

class ProductResolver {
    /**
     * Resolves a product by its ID.
     *
     * This method is used as a GraphQL resolver to fetch a product
     * associated with a specific ID. It initializes the database
     * connection and the Products model, then retrieves the product.
     * 
     * @param mixed $root
     * @param mixed $args
     * @return array
     */
    public static function resolveById($root, $args) {
        $db = new Database();
        $productModel = new Products($db);
        return $productModel->getById($args['id']);
    }

    /**
     * Resolves all products.
     *
     * This method is used as a GraphQL resolver to fetch all products.
     * It initializes the database connection and the Products model,
     * then retrieves all products.
     * 
     * @param mixed $root
     * @param mixed $args
     * @return array
     */
    public static function resolveAll($root, $args) {
        $db = new Database();
        $productModel = new Products($db);
        return $productModel->getAll();
    }
}
