<?php


namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table      = 'orders';
    protected $primaryKey = 'id';
    
    protected $useAutoIncrement = true;
    protected $returnType     = 'object';
    
    protected $allowedFields = [
        'user_id', 'invoice_number', 'name', 'email', 'address', 
        'phone', 'city', 'postal_code', 'payment_method',
        'total_amount', 'total_price', 'status'
    ];
    
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    
    public function getOrdersByUser($userId)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
    
    public function getOrderWithDetails($orderId)
    {
        $db = \Config\Database::connect();
        
        $order = $this->find($orderId);
        if (!$order) {
            return null;
        }
        
        // Get order details
        $orderDetails = $db->table('order_details')
                          ->select('order_details.*, products.name as product_name, products.image')
                          ->join('products', 'products.id = order_details.product_id')
                          ->where('order_id', $orderId)
                          ->get()
                          ->getResultArray();
        
        // Get payment info
        $payment = $db->table('payments')
                      ->where('order_id', $orderId)
                      ->get()
                      ->getRowArray();
        
        // Get user info
        $user = $db->table('users')
                   ->where('id', $order['user_id'])
                   ->get()
                   ->getRowArray();
        
        // Merge all data
        $order['details'] = $orderDetails;
        $order['payment'] = $payment;
        $order['user'] = $user;
        
        return $order;
    }
    
    public function getOrdersByMerchant($merchantId)
    {
        $db = \Config\Database::connect();
        
        return $db->table('orders as o')
                 ->select('o.*, u.name as user_name, COUNT(od.id) as total_items')
                 ->join('order_details as od', 'o.id = od.order_id')
                 ->join('products as p', 'p.id = od.product_id')
                 ->join('users as u', 'u.id = o.user_id')
                 ->where('p.merchant_id', $merchantId)
                 ->groupBy('o.id')
                 ->orderBy('o.created_at', 'DESC')
                 ->get()
                 ->getResultArray();
    }
}