<?php


namespace App\Controllers\Merchant;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\OrderModel;
use App\Models\MerchantProfileModel;

class Dashboard extends BaseController
{
    protected $productModel;
    protected $orderModel;
    protected $merchantProfileModel;
    
    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->orderModel = new OrderModel();
        $this->merchantProfileModel = new MerchantProfileModel();
    }
    
    public function index()
    {
        $merchantId = session()->get('id');
        
        // Get merchant profile
        $merchantProfile = $this->merchantProfileModel->getMerchantProfileWithUser($merchantId);
        
        // Total products
        $totalProducts = $this->productModel->where('merchant_id', $merchantId)->countAllResults();
        
        // Low stock products (less than 10 items)
        $lowStockProducts = $this->productModel->where('merchant_id', $merchantId)
                                              ->where('stock <', 10)
                                              ->findAll();
        
        // Recent orders containing merchant's products
        $recentOrders = $this->orderModel->getOrdersByMerchant($merchantId);
        
        // Sales statistics
        $db = \Config\Database::connect();
        
        // Calculate total sales
        $totalSales = $db->table('order_details as od')
                        ->select('SUM(od.quantity * od.price) as total')
                        ->join('products as p', 'p.id = od.product_id')
                        ->join('orders as o', 'o.id = od.order_id')
                        ->where('p.merchant_id', $merchantId)
                        ->where('o.status !=', 'cancelled')
                        ->get()
                        ->getRow();
                        
        $totalSalesAmount = $totalSales ? $totalSales->total : 0;
        
        $data = [
            'title' => 'Dashboard Merchant',
            'merchantProfile' => $merchantProfile,
            'totalProducts' => $totalProducts,
            'lowStockProducts' => $lowStockProducts,
            'recentOrders' => $recentOrders,
            'totalSales' => $totalSalesAmount
        ];
        
        return view('merchant/dashboard', $data);
    }
}