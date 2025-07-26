<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\UserModel;

class Orders extends BaseController
{
    protected $orderModel;
    protected $userModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();
        $orders = $db->table('orders as o')
            ->select('o.*, u.name as user_name')
            ->join('users as u', 'u.id = o.user_id')
            ->orderBy('o.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Kelola Pesanan',
            'orders' => $orders,
        ];

        return view('admin/orders/index', $data);
    }
    
    public function detail($id)
    {
        $orderModel = model('OrderModel');
        
        // Ubah query untuk menggunakan tabel orders saja tanpa join ke customers
        $order = $orderModel->select('orders.*, users.name as user_name, users.email as user_email')
                        ->join('users', 'users.id = orders.user_id', 'left')
                        ->where('orders.id', $id)
                        ->first();
    
        // Ambil item pesanan
        $orderItemModel = model('OrderDetailModel'); // Sesuaikan dengan nama model yang benar
        $items = $orderItemModel->select('order_details.*, products.name as product_name, products.price, products.image')
                           ->join('products', 'products.id = order_details.product_id')
                           ->where('order_id', $id)
                           ->findAll();
    
        $data = [
            'title' => 'Detail Pesanan #' . $id,
            'order' => $order,
            'items' => $items
        ];
    
        return view('admin/orders/detail', $data);
    }
    
    public function updateStatus($id = null)
    {
        // Jika dipanggil via URL tanpa parameter
        if (!$id) {
            $id = $this->request->getPost('id');
        }
        
        $status = $this->request->getPost('status');
        
        // Validasi data
        if (!$id || !$status) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Parameter tidak lengkap'
            ]);
        }
        
        // Update status di model
        $model = model('OrderModel');
        $result = $model->update($id, ['status' => $status]);
        
        if ($result) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Status pesanan berhasil diperbarui'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal memperbarui status pesanan'
            ]);
        }
    }
}
