<?php

namespace App\Models;

use App\Database\Database;
use PDOException;

class OrderItem extends Model
{
    public $order_id;
    public $order_item_id;
    public $product_id;
    public $quantity;

    /**
     * Constructs the OrderItem model.
     *
     * This constructor initializes the OrderItem model with a database connection
     * and the order item details.
     *
     * @param Database $db The database connection.
     * @param int $order_id The ID of the order.
     * @param string $product_id The ID of the product.
     * @param int $quantity The quantity of the product.
     */

    public function __construct(Database $db, $order_id, $product_id, $quantity)
    {
        parent::__construct($db);
        $this->order_id = $order_id;
        $this->order_item_id = null;
        $this->product_id = $product_id;
        $this->quantity = $quantity;
    }

    /**
     * Saves the order item to the database.
     *
     * This method inserts the order item details into the `order_items` table
     * and commits the transaction.
     *
     * @return bool True on success, false on failure.
     */

    public function save()
    {

        $conn = $this->db->connect();
        try {

            $conn->beginTransaction();

            $sqlOptions = 'INSERT INTO order_items (order_id, product_id, quantity) VALUES (:order_id, :product_id, :quantity)';
            $stmtOptions = $conn->prepare($sqlOptions);
            $stmtOptions->bindParam(':order_id', $this->order_id);
            $stmtOptions->bindParam(':product_id', $this->product_id);
            $stmtOptions->bindParam(':quantity', $this->quantity);
            $stmtOptions->execute();
            $this->order_item_id = $conn->lastInsertId();

            $conn->commit();

            return true;
        } catch (PDOException $e) {
            $conn->rollback();
            error_log('Failed to create order: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Retrieves the order item ID.
     *
     * This method returns the ID of the order item.
     *
     * @return int The order item ID.
     */

    public static function getOrderItemId()
    {
        return self::$order_item_id;
    }
}
