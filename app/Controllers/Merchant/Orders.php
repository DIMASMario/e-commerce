<?php

namespace App\Controllers\Merchant;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderDetailModel;
use App\Models\ProductModel;
use App\Models\UserModel;
use App\Libraries\EmailService;

class Orders extends BaseController
{
    protected $orderModel;
    protected $orderDetailModel;
    protected $productModel;
    protected $userModel;
    
    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->orderDetailModel = new OrderDetailModel();
        $this->productModel = new ProductModel();
        $this->userModel = new UserModel();
    }
    
    public function index()
    {
        $merchantId = session()->get('id');
        
        $orders = $this->orderModel->getOrdersByMerchant($merchantId);
        
        $data = [
            'title' => 'Daftar Pesanan',
            'orders' => $orders
        ];
        
        return view('merchant/orders/index', $data);
    }
    
    public function detail($id)
    {
        $merchantId = session()->get('id');
        $order = $this->orderModel->getOrderWithDetails($id);
        
        // Verify merchant has products in this order
        $hasProductInOrder = false;
        foreach ($order['details'] as $detail) {
            $product = $this->productModel->find($detail['product_id']);
            if ($product && $product['merchant_id'] == $merchantId) {
                $hasProductInOrder = true;
                break;
            }
        }
        
        if (!$hasProductInOrder) {
            return redirect()->to('merchant/orders')->with('error', 'Pesanan tidak ditemukan atau tidak berisi produk Anda.');
        }
        
        // Filter to only show merchant's products in order details
        $merchantOrderDetails = array_filter($order['details'], function($detail) use ($merchantId) {
            $product = $this->productModel->find($detail['product_id']);
            return ($product && $product['merchant_id'] == $merchantId);
        });
        
        $data = [
            'title' => 'Detail Pesanan #' . $id,
            'order' => $order,
            'orderDetails' => $merchantOrderDetails
        ];
        
        return view('merchant/orders/detail', $data);
    }
    
    public function updateStatus($id)
    {
        $merchantId = session()->get('id');
        $order = $this->orderModel->find($id);
        
        if (!$order) {
            return redirect()->to('merchant/orders')->with('error', 'Pesanan tidak ditemukan.');
        }
        
        // Check if merchant has products in this order
        $hasProductInOrder = false;
        $orderDetails = $this->orderDetailModel->where('order_id', $id)->findAll();
        
        foreach ($orderDetails as $detail) {
            $product = $this->productModel->find($detail['product_id']);
            if ($product && $product['merchant_id'] == $merchantId) {
                $hasProductInOrder = true;
                break;
            }
        }
        
        if (!$hasProductInOrder) {
            return redirect()->to('merchant/orders')->with('error', 'Pesanan tidak ditemukan atau tidak berisi produk Anda.');
        }
        
        $status = $this->request->getPost('status');
        
        if (!in_array($status, ['paid', 'shipped', 'cancelled'])) {
            return redirect()->back()->with('error', 'Status pesanan tidak valid.');
        }
        
        // Only update if status is different
        if ($order['status'] != $status) {
            $this->orderModel->update($id, ['status' => $status]);
            
            // Send email notification if order is shipped
            if ($status == 'shipped') {
                $user = $this->userModel->find($order['user_id']);
                $emailService = new EmailService();
                $emailService->sendOrderShippedNotification($user['email'], $order, $user);
            }
        }
        
        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}