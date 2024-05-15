<?php

namespace App\Models;

use App\Database\Database;
use PDO;

class Attributes extends Model {
    /**
     * Constructs the Attributes model.
     *
     * This constructor initializes the Attributes model with a database connection.
     *
     * @param Database $db The database connection.
     */
    public function __construct(Database $db) {
        parent::__construct($db);
    }
    /**
     * Retrieves attributes by product ID.
     *
     * This method fetches all attributes associated with a specific product ID from
     * the `products_attributes` table.
     *
     * @param int $productId The ID of the product.
     * @return array The attributes associated with the specified product ID.
     */
    public function getByProductId($productId) {
        $conn = $this->db->connect();
        $stmt = $conn->prepare('SELECT * FROM products_attributes WHERE product_id = ?');
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}