<?php


namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\WishlistModel;
use App\Models\ProductModel;

class Wishlist extends BaseController
{
    protected $wishlistModel;
    protected $productModel;
    
    public function __construct()
    {
        $this->wishlistModel = new WishlistModel();
        $this->productModel = new ProductModel();
    }
    
    public function index()
    {
        $userId = session()->get('id');
        $wishlistItems = $this->wishlistModel->getWishlistWithProducts($userId);
        
        $data = [
            'title' => 'Wishlist Saya',
            'wishlistItems' => $wishlistItems
        ];
        
        return view('user/wishlist', $data);
    }
    
    public function add($productId)
    {
        $userId = session()->get('id');
        
        // Check if product exists
        $product = $this->productModel->find($productId);
        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan');
        }
        
        // Check if already in wishlist
        if ($this->wishlistModel->isProductInWishlist($userId, $productId)) {
            return redirect()->back()->with('info', 'Produk sudah ada di wishlist');
        }
        
        // Add to wishlist
        $this->wishlistModel->insert([
            'user_id' => $userId,
            'product_id' => $productId
        ]);
        
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke wishlist');
    }
    
    public function remove($productId)
    {
        $userId = session()->get('id');
        
        $this->wishlistModel->where('user_id', $userId)
                            ->where('product_id', $productId)
                            ->delete();
                            
        return redirect()->back()->with('success', 'Produk berhasil dihapus dari wishlist');
    }
}