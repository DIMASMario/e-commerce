<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\MerchantProfileModel;
use App\Models\WishlistModel;

class Products extends BaseController
{
    protected $productModel;
    protected $categoryModel;
    protected $merchantProfileModel;
    protected $wishlistModel;
    
    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->merchantProfileModel = new MerchantProfileModel();
        $this->wishlistModel = new WishlistModel();
    }
    
    public function index()
    {
        $perPage = 12; // Jumlah produk per halaman, sesuaikan jika perlu

        // Ambil data produk yang sudah dipaginasi
        $products = $this->productModel
            ->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->paginate($perPage);

        $data = [
            'title' => 'Semua Produk',
            'products' => $products,
            'pager' => $this->productModel->pager,
            'totalProducts' => $this->productModel->pager->getTotal(), // Tambahkan baris ini
            'categories' => $this->categoryModel->findAll() // Tambahkan baris ini
        ];

        return view('products/index', $data);
    }
    
    public function detail($id)
    {
        $product = $this->productModel->getProductWithDetails($id);
        
        if (!$product) {
            return redirect()->to('products')->with('error', 'Produk tidak ditemukan.');
        }
        
        // Get merchant info
        $merchant = $this->merchantProfileModel->getMerchantProfileWithUser($product['merchant_id']);
        
        // Get related products (same category, different product)
        $relatedProducts = $this->productModel->where('category_id', $product['category_id'])
                                             ->where('id !=', $id)
                                             ->limit(4)
                                             ->find();
        
        // Check if product is in wishlist (if user is logged in)
        $isInWishlist = false;
        if (session()->get('isLoggedIn')) {
            $userId = session()->get('id');
            $isInWishlist = $this->wishlistModel->checkProductInWishlist($userId, $id) ? true : false;
        }
        
        $data = [
            'title' => $product['name'],
            'product' => $product,
            'merchant' => $merchant,
            'relatedProducts' => $relatedProducts,
            'isInWishlist' => $isInWishlist
        ];
        
        return view('products/detail', $data);
    }
    
    public function byCategory($categoryId)
    {
        $category = $this->categoryModel->find($categoryId);
        
        if (!$category) {
            return redirect()->to('products')->with('error', 'Kategori tidak ditemukan.');
        }
        
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 12;
        
        // Get products by category with pagination
        $products = $this->productModel->getProductsByCategory($categoryId, $page, $perPage);
        $pager = $this->productModel->pager;
        
        // Get all categories for filter
        $categories = $this->categoryModel->findAll();
        
        $data = [
            'title' => 'Kategori: ' . $category['name'],
            'products' => $products,
            'pager' => $pager,
            'categories' => $categories,
            'currentCategory' => $category
        ];
        
        return view('products/by_category', $data);
    }
    
    public function search()
    {
        $keyword = $this->request->getGet('keyword');
        
        if (empty($keyword)) {
            return redirect()->to('products');
        }
        
        $productModel = new \App\Models\ProductModel();
        $products = $productModel->search($keyword);
        
        $data = [
            'title' => 'Hasil Pencarian: ' . $keyword,
            'products' => $products,
            'keyword' => $keyword
        ];
        
        return view('products/search', $data);
    }
    
    public function create()
    {
        $data = [
            'title' => 'Tambah Produk',
            'categories' => $this->categoryModel->findAll(), // Ambil semua kategori
            'validation' => \Config\Services::validation()
        ];
        return view('admin/products/create', $data);
    }
}