<?php

namespace App\Models;

use App\Database\Database;
use PDO;

class Prices extends Model
{

    /**
     * Constructs the Prices model.
     *
     * This constructor initializes the Prices model with a database connection.
     *
     * @param Database $db The database connection.
     */

    public function __construct(Database $db)
    {
        parent::__construct($db);
    }

    /**
     * Retrieves prices by product ID.
     *
     * This method fetches all prices associated with a specific product ID from
     * the `products_prices` table.
     *
     * @param int $productId The ID of the product.
     * @return array The prices associated with the specified product ID.
     */

    public function getByProductId($productId)
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare('SELECT * FROM products_prices WHERE product_id = ?');
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}