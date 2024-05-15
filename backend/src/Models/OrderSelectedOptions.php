<?php

namespace App\Models;

use App\Database\Database;
use PDOException;

class OrderSelectedOptions extends Model
{
    public $order_item_id;
    public $attribute_name;
    public $attribute_value;

    /**
     * Constructs the OrderSelectedOptions model.
     *
     * This constructor initializes the OrderSelectedOptions model with a database connection
     * and the selected option details.
     *
     * @param Database $db The database connection.
     * @param int $order_item_id The ID of the order item.
     * @param string $attribute_name The name of the attribute.
     * @param string $attribute_value The value of the attribute.
     */

    public function __construct(Database $db, $order_item_id, $attribute_name, $attribute_value)
    {
        parent::__construct($db);
        $this->order_item_id = $order_item_id;
        $this->attribute_name = $attribute_name;
        $this->attribute_value = $attribute_value;
    }

    /**
     * Saves the order selected option to the database.
     *
     * This method inserts the order selected option details into the `order_selected_options` table.
     *
     * @return bool True on success, false on failure.
     */

    public function save()
    {
        $conn = $this->db->connect();
        try {
            $sql = 'INSERT INTO order_selected_options (order_item_id, attribute_name, attribute_value) VALUES (:order_item_id, :attribute_name, :attribute_value)';
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':order_item_id', $this->order_item_id);
            $stmt->bindParam(':attribute_name', $this->attribute_name);
            $stmt->bindParam(':attribute_value', $this->attribute_value);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log('Failed to save order selected option: ' . $e->getMessage());
            return false;
        }
    }
}
