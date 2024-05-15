<?php

/**
 * Summary of namespace App\GraphQL\Resolvers
 */
namespace App\GraphQL\Resolvers;

use App\Models\Orders;
use App\Models\OrderItem;
use App\Models\OrderSelectedOptions;
use App\Models\OrderPayments;
use App\Database\Database;

/**
 * Summary of OrdersResolver
 */
class OrdersResolver {
    /**
     * Creates orders.
     *
     * This method is used as a GraphQL resolver to create multiple orders.
     * It initializes the database connection and uses the Orders, OrderItem,
     * OrderSelectedOptions, and OrderPayments models to save the order data.
     * 
     * @param mixed $root
     * @param mixed $args
     * @param mixed $context
     * @param mixed $info
     * @return array
     */
    public static function createOrders($root, $args, $context, $info) {
        $db = new Database();
        
        $results = [];
        foreach ($args['orders'] as $orderData) {
            $order = new Orders($db, $orderData['customer_id'], $orderData['status']);
            $order->save();
            
            if ($order->order_id) {
                
                foreach ($orderData['order_items'] as $item) {
                    $orderItem = new OrderItem($db, $order->order_id, $item['product_id'], $item['quantity']);
                    $orderItem->save();
                    
                    
                    if (isset($item['order_selected_options'])) {
                        foreach ($item['order_selected_options'] as $option) {
                            $selectedOption = new OrderSelectedOptions($db, $orderItem->order_item_id, $option['attribute_name'], $option['attribute_value']);
                            $selectedOption->save(); 
                        }
                    }
                }

                
                if (isset($orderData['order_payments'])) {
                    $payment = $orderData['order_payments'];
                    $orderPayment = new OrderPayments($db, $order->order_id, $payment['amount'], $payment['currency'], $payment['payment_method'], $payment['payment_date'] ?? null);
                    $orderPayment->save(); 
                }

                $results[] = [
                    'order_id' => $order->order_id,
                    'status' => 'success',
                    'message' => 'Order created successfully'
                ];
            } else {
                $results[] = [
                    'order_id' => null,
                    'status' => 'error',
                    'message' => 'Failed to create order'
                ];
            }
        }
        return $results;
    }
}
