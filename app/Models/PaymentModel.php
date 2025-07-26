<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table      = 'payments';
    protected $primaryKey = 'id';
    
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    
    protected $allowedFields = [
        'order_id', 'user_id', 'payment_proof', 'status', 'created_at', 'updated_at', 'verified_by', 'verification_note'
    ];
    
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    
    public function getPaymentWithOrder($id)
    {
        $db = \Config\Database::connect();
        
        return $db->table('payments as p')
                 ->select('p.*, o.total_price, o.status as order_status')
                 ->join('orders as o', 'o.id = p.order_id')
                 ->where('p.id', $id)
                 ->get()
                 ->getRowArray();
    }
    
    public function getPaymentByOrder($orderId)
    {
        return $this->where('order_id', $orderId)->first();
    }
    
    public function getPaymentsWithDetails()
    {
        $db = \Config\Database::connect();
        
        // Memisahkan data pembayaran berdasarkan status untuk tab yang berbeda
        $result = $db->table('payments as p')
            ->select('p.*, o.total_price, o.status as order_status, u.name as user_name, o.invoice_number')
            ->join('orders as o', 'o.id = p.order_id')
            ->join('users as u', 'u.id = p.user_id')
            ->orderBy('p.created_at', 'DESC')
            ->get()
            ->getResultArray();
        
        // Memisahkan pembayaran berdasarkan statusnya
        $waiting = array_filter($result, function($item) {
            return $item['status'] === 'pending_verification' || $item['status'] === 'waiting';
        });
        
        $verified = array_filter($result, function($item) {
            return $item['status'] === 'verified';
        });
        
        $rejected = array_filter($result, function($item) {
            return $item['status'] === 'rejected';
        });
        
        return [
            'all' => $result,
            'waiting' => array_values($waiting),
            'verified' => array_values($verified),
            'rejected' => array_values($rejected),
        ];
    }
}
