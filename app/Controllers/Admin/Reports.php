<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\PaymentModel;
use App\Models\UserModel;

class Reports extends BaseController
{
    protected $orderModel;
    protected $paymentModel;
    protected $userModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->paymentModel = new PaymentModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Example report data: total orders, total payments, user count, recent orders
        $totalOrders = $this->orderModel->countAllResults();
        $totalPayments = $this->paymentModel->countAllResults();
        $totalUsers = $this->userModel->countAllResults();

        // Get recent orders with user info
        $db = \Config\Database::connect();
        $recentOrders = $db->table('orders as o')
            ->select('o.*, u.name as user_name')
            ->join('users as u', 'u.id = o.user_id')
            ->orderBy('o.created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Laporan Admin',
            'totalOrders' => $totalOrders,
            'totalPayments' => $totalPayments,
            'totalUsers' => $totalUsers,
            'recentOrders' => $recentOrders,
        ];

        return view('admin/reports/index', $data);
    }
}
