<?php

namespace App\Models;

use App\Database\Database;

abstract class Model
{
    protected $db;
    
    /**
     * Constructs the base Model.
     *
     * This constructor initializes the base Model with a database connection.
     *
     * @param Database $db The database connection.
     */

    public function __construct(Database $db)
    {
        $this->db = $db;
    }
}
