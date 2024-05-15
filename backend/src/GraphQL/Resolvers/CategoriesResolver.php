<?php

namespace App\GraphQL\Resolvers;

use App\Models\Categories;
use App\Database\Database;

class CategoriesResolver {

    /**
     * Resolves all categories.
     *
     * This method is used as a GraphQL resolver to fetch all categories.
     * It initializes the database connection and the Categories model,
     * then retrieves all categories.
     *
     * @param mixed $root
     * @param mixed $args
     * @return array
     */

    public static function resolveAll($root, $args) {
        $db = new Database();
        $categoriesModel = new Categories($db);
        return $categoriesModel->getAll();
    }
}
