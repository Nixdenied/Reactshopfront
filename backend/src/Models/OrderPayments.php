<?php

namespace App\Models;

use App\Database\Database;
use PDOException;

class OrderPayments extends Model
{
    public $payment_id;
    public $order_id;
    public $amount;
    public $currency;
    public $payment_date;
    public $payment_method;


    /**
     * Constructs the OrderPayments model.
     *
     * This constructor initializes the OrderPayments model with a database connection
     * and the payment details.
     *
     * @param Database $db The database connection.
     * @param int $order_id The ID of the order.
     * @param float $amount The amount of the payment.
     * @param string $currency The currency of the payment.
     * @param string $payment_method The method of the payment.
     * @param string|null $payment_date The date of the payment.
     */

    public function __construct(Database $db, $order_id, $amount, $currency, $payment_method, $payment_date = null)
    {
        parent::__construct($db);
        $this->order_id = $order_id;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->payment_method = $payment_method;
        $this->payment_date = $payment_date ?: date('Y-m-d H:i:s');
    }

    /**
     * Saves the order payment to the database.
     *
     * This method inserts the order payment details into the `order_payments` table.
     *
     * @return bool True on success, false on failure.
     */

    public function save()
    {
        $conn = $this->db->connect();
        try {
            $sql = 'INSERT INTO order_payments (order_id, amount, currency, payment_date, payment_method) VALUES (:order_id, :amount, :currency, :payment_date, :payment_method)';
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':order_id', $this->order_id);
            $stmt->bindParam(':amount', $this->amount);
            $stmt->bindParam(':currency', $this->currency);
            $stmt->bindParam(':payment_date', $this->payment_date);
            $stmt->bindParam(':payment_method', $this->payment_method);
            $stmt->execute();
            $this->payment_id = $conn->lastInsertId();
            return true;
        } catch (PDOException $e) {
            $conn->rollback();
            error_log('Failed to save payment: ' . $e->getMessage());
            return false;
        }
    }
}
