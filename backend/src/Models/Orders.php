<?php

namespace App\Models;

use App\Database\Database;
use PDOException;

class Orders extends Model
{

    public $order_id;
    public $customer_id;
    public $order_date;
    public $status;

    /**
     * Constructs the Orders model.
     *
     * This constructor initializes the Orders model with a database connection
     * and the order details.
     *
     * @param Database $db The database connection.
     * @param int $customer_id The ID of the customer.
     * @param string $status The status of the order.
     */

    public function __construct(Database $db, $customer_id, $status)
    {
        parent::__construct($db);
        $this->order_id = null;
        $this->customer_id = $customer_id;
        $this->status = $status;
        $this->order_date = date('Y-m-d H:i:s');
    }

    /**
     * Saves the order to the database.
     *
     * This method inserts the order details into the `orders` table and commits the transaction.
     *
     * @return bool True on success, false on failure.
     */

    public function save()
    {

        $conn = $this->db->connect();
        try {

            $conn->beginTransaction();

            $sqlOptions = 'INSERT INTO orders (customer_id, status, order_date) VALUES (:customer_id, :status, :order_date)';
            $stmtOptions = $conn->prepare($sqlOptions);
            $stmtOptions->bindParam(':customer_id', $this->customer_id);
            $stmtOptions->bindParam(':status', $this->status);
            $stmtOptions->bindParam(':order_date', $this->order_date);
            $stmtOptions->execute();
            $this->order_id = $conn->lastInsertId();

            $conn->commit();

            return true;
        } catch (PDOException $e) {
            $conn->rollback();
            error_log('Failed to create order: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Retrieves the order ID.
     *
     * This method returns the ID of the order.
     *
     * @return int The order ID.
     */

    public static function getOrderId()
    {
        return self::$order_id;
    }
}
