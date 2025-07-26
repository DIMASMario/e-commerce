<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class Orders extends BaseController
{
    protected $orderModel;
    protected $orderDetailModel;

    public function __construct()
    {
        $this->orderModel = model('OrderModel');
        $this->orderDetailModel = model('OrderDetailModel');
    }

    public function index()
    {
        // Kode untuk halaman daftar pesanan
        $orders = $this->orderModel->where('user_id', session()->get('user_id'))->findAll();
        
        return view('user/orders/index', [
            'title' => 'Daftar Pesanan',
            'orders' => $orders
        ]);
    }

    /**
     * Menampilkan detail pesanan
     */
    public function detail($id = null)
    {
        // Validasi ID
        if (!$id) {
            return redirect()->to('user/orders')->with('error', 'ID pesanan tidak valid');
        }
        
        // Ambil data pesanan
        $order = $this->orderModel->where('id', $id)
                                 ->where('user_id', session()->get('user_id'))
                                 ->first();
        
        // Jika tidak ditemukan atau bukan milik user ini
        if (!$order) {
            return redirect()->to('user/orders')->with('error', 'Pesanan tidak ditemukan');
        }
        
        // Ambil detail item pesanan
        $items = $this->orderDetailModel->select('order_details.*, products.name as product_name, products.image')
                                       ->join('products', 'products.id = order_details.product_id')
                                       ->where('order_id', $id)
                                       ->findAll();
        
        return view('user/orders/detail', [
            'title' => 'Detail Pesanan #' . $id,
            'order' => $order,
            'items' => $items
        ]);
    }
}
