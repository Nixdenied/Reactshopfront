<?php

namespace App\Models;

use App\Database\Database;
use PDO;

class Categories extends Model
{

    /**
     * Constructs the Categories model.
     *
     * This constructor initializes the Categories model with a database connection.
     *
     * @param Database $db The database connection.
     */

    public function __construct(Database $db)
    {
        parent::__construct($db);
    }

    /**
     * Retrieves all categories.
     *
     * This method fetches all records from the `categories` table.
     *
     * @return array The list of all categories.
     */

    public function getAll()
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare('SELECT * FROM categories');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}