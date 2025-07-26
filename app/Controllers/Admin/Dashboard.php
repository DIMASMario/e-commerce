<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\OrderModel;
use App\Models\PaymentModel;
use App\Models\ProductModel;

class Dashboard extends BaseController
{
    protected $userModel;
    protected $orderModel;
    protected $paymentModel;
    protected $productModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->orderModel = new OrderModel();
        $this->paymentModel = new PaymentModel();
        $this->productModel = new ProductModel();
    }
    
    public function index()
    {
        $db = \Config\Database::connect();
        
        // Total users
        $totalUsers = $this->userModel->countAllResults();
        $totalMerchants = $this->userModel->where('role', 'merchant')->countAllResults();
        
        // Orders statistics
        $totalOrders = $this->orderModel->countAllResults();
        $pendingOrders = $this->orderModel->where('status', 'pending')->countAllResults();
        $shippedOrders = $this->orderModel->where('status', 'shipped')->countAllResults();
        
        // Payments waiting for verification
        $pendingPayments = $this->paymentModel->where('status', 'waiting')->countAllResults();
        
        // Total revenue
        $totalRevenue = $this->orderModel->where('status !=', 'cancelled')->selectSum('total_price')->first()->total_price ?? 0;
        
        // Products stats
        $totalProducts = $this->productModel->countAllResults();
        
        // Recent orders
        $recentOrders = $db->table('orders')
                          ->select('orders.*, users.name as user_name')
                          ->join('users', 'users.id = orders.user_id')
                          ->orderBy('orders.created_at', 'DESC')
                          ->limit(5)
                          ->get()
                          ->getResultArray();
        
        // Recent payments
        $recentPayments = $db->table('payments')
                            ->select('payments.*, orders.total_price, users.name as user_name')
                            ->join('orders', 'orders.id = payments.order_id')
                            ->join('users', 'users.id = payments.user_id')
                            ->orderBy('payments.created_at', 'DESC')
                            ->limit(5)
                            ->get()
                            ->getResultArray();
        
        $data = [
            'title' => 'Dashboard Admin',
            'totalUsers' => $totalUsers,
            'totalMerchants' => $totalMerchants,
            'totalOrders' => $totalOrders,
            'pendingOrders' => $pendingOrders,
            'shippedOrders' => $shippedOrders,
            'pendingPayments' => $pendingPayments,
            'totalRevenue' => $totalRevenue,
            'totalProducts' => $totalProducts,
            'recentOrders' => $recentOrders,
            'recentPayments' => $recentPayments
        ];
        
        return view('admin/dashboard', $data);
    }
}