<?php

namespace App\Models;

use App\Database\Database;
use PDO;

class Products extends Model
{
    /**
     * Constructs the Products model.
     *
     * This constructor initializes the Products model with a database connection.
     *
     * @param Database $db The database connection.
     */

    public function __construct(Database $db)
    {
        parent::__construct($db);
    }

    /**
     * Fetches a product by its ID from the database.
     *
     * This method retrieves the product details associated with a specific ID from
     * the `products` table.
     *
     * @param int $id The product ID.
     * @return array The product data.
     */

    public function getById($id)
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare('SELECT * FROM products WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves all products.
     *
     * This method fetches all records from the `products` table.
     *
     * @return array The list of all products.
     */

    public function getAll()
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare('SELECT * FROM products');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
