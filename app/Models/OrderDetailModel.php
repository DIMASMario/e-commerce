<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderDetailModel extends Model
{
    protected $table      = 'order_details';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    
    protected $allowedFields = [
        'order_id', 'product_id', 'quantity', 'price'
    ];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    public function getDetailsByOrder($orderId)
    {
        $db = \Config\Database::connect();
        
        return $db->table('order_details as od')
                 ->select('od.*, p.name, p.image')
                 ->join('products as p', 'p.id = od.product_id', 'left')
                 ->where('od.order_id', $orderId)
                 ->get()
                 ->getResultArray();
    }
}