<?php

namespace App\GraphQL\Resolvers;

use App\Models\Gallery;
use App\Database\Database;

class GalleryResolver {

    /**
     * Resolves gallery items by product ID.
     *
     * This method is used as a GraphQL resolver to fetch gallery items
     * associated with a specific product ID. It initializes the database
     * connection and the Gallery model, then retrieves the gallery items.
     *
     * @param mixed $root
     * @param mixed $args
     * @return array
     */

    public static function resolveByProductId($root, $args) {
        $db = new Database();
        $galleryModel = new Gallery($db);
        return $galleryModel->getByProductId($root['id']);
    }
}