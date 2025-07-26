<?php


namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\WishlistModel;

class Dashboard extends BaseController
{
    protected $orderModel;
    protected $productModel;
    protected $wishlistModel;
    
    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->productModel = new ProductModel();
        $this->wishlistModel = new WishlistModel();
    }
    
    public function index()
    {
        $userId = session()->get('id');
        
        // Recent orders
        $recentOrders = $this->orderModel->getOrdersByUser($userId);
        
        // Wishlist items
        $db = \Config\Database::connect();
        $wishlistItems = $db->table('wishlists')
                           ->select('wishlists.*, products.name, products.price, products.image')
                           ->join('products', 'products.id = wishlists.product_id')
                           ->where('wishlists.user_id', $userId)
                           ->limit(4)
                           ->get()
                           ->getResultArray();
        
        // Recommended products - can be recent products for now
        $recommendedProducts = $this->productModel->orderBy('created_at', 'DESC')
                                                 ->limit(4)
                                                 ->find();
        
        $data = [
            'title' => 'Dashboard Saya',
            'recentOrders' => $recentOrders,
            'wishlistItems' => $wishlistItems,
            'recommendedProducts' => $recommendedProducts
        ];
        
        return view('user/dashboard', $data);
    }
}