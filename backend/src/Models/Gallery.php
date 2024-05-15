<?php

namespace App\Models;

use App\Database\Database;
use PDO;

class Gallery extends Model
{

    /**
     * Constructs the Gallery model.
     *
     * This constructor initializes the Gallery model with a database connection.
     *
     * @param Database $db The database connection.
     */

    public function __construct(Database $db)
    {
        parent::__construct($db);
    }

    /**
     * Retrieves gallery images by product ID.
     *
     * This method fetches all gallery images associated with a specific product ID from
     * the `products_gallery` table.
     *
     * @param int $productId The ID of the product.
     * @return array The gallery images associated with the specified product ID.
     */

    public function getByProductId($productId)
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare('SELECT value FROM products_gallery WHERE product_id = ?');
        $stmt->execute([$productId]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function ($item) {
            return $item['value'];
        }, $results);
    }
}