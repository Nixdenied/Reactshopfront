<?php

namespace App\Models;

use App\Database\Database;
use PDO;

class Currency extends Model
{
    /**
     * Constructs the Currency model.
     *
     * This constructor initializes the Currency model with a database connection.
     *
     * @param Database $db The database connection.
     */

    public function __construct(Database $db)
    {
        parent::__construct($db);
    }
    /**
     * Retrieves currency by price ID.
     *
     * This method fetches the currency label and symbol associated with a specific price ID from
     * the `products_prices_currency` table.
     *
     * @param int $priceId The ID of the price.
     * @return array The currency associated with the specified price ID.
     */
    public function getByPriceId($priceId)
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare('SELECT label, symbol FROM products_prices_currency WHERE price_id = ?');
        $stmt->execute([$priceId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}