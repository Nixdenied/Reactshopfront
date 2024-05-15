<?php

namespace App\Models;

use App\Database\Database;
use PDO;

class Items extends Model
{

    /**
     * Constructs the Items model.
     *
     * This constructor initializes the Items model with a database connection.
     *
     * @param Database $db The database connection.
     */

    public function __construct(Database $db)
    {
        parent::__construct($db);
    }
    
    /**
     * Retrieves items by attribute ID.
     *
     * This method fetches all items associated with a specific attribute ID from
     * the `products_attributes_items` table.
     *
     * @param int $id The ID of the attribute.
     * @return array The items associated with the specified attribute ID.
     */

    public function getByProductId($id)
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare('SELECT * FROM products_attributes_items WHERE attribute_id = ?');
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}