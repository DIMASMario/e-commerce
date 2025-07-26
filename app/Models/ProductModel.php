<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table      = 'products';
    protected $primaryKey = 'id';
    
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    
    protected $allowedFields = [
        'merchant_id', 'name', 'description', 'price', 
        'stock', 'image', 'category_id', 'created_at'
    ];
    
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    
    public function getProductWithDetails($productId)
    {
        $db = \Config\Database::connect();
        
        $product = $db->table('products')
                     ->select('products.*, categories.name as category_name')
                     ->join('categories', 'categories.id = products.category_id')
                     ->where('products.id', $productId)
                     ->get()
                     ->getRowArray();
        
        return $product;
    }
    
    public function getProductsWithPagination($page = 1, $perPage = 12)
    {
        $offset = ($page - 1) * $perPage;
        
        $this->join('categories', 'categories.id = products.category_id')
             ->select('products.*, categories.name as category_name')
             ->orderBy('products.created_at', 'DESC');
        
        return $this->paginate($perPage);
    }
    
    public function getProductsByCategory($categoryId, $page = 1, $perPage = 12)
    {
        $offset = ($page - 1) * $perPage;
        
        $this->join('categories', 'categories.id = products.category_id')
             ->select('products.*, categories.name as category_name')
             ->where('products.category_id', $categoryId)
             ->orderBy('products.created_at', 'DESC');
        
        return $this->paginate($perPage);
    }
    
    public function searchProducts($keyword, $page = 1, $perPage = 12)
    {
        $offset = ($page - 1) * $perPage;
        
        $this->join('categories', 'categories.id = products.category_id')
             ->select('products.*, categories.name as category_name')
             ->groupStart()
             ->like('products.name', $keyword)
             ->orLike('products.description', $keyword)
             ->orLike('categories.name', $keyword)
             ->groupEnd()
             ->orderBy('products.created_at', 'DESC');
        
        return $this->paginate($perPage);
    }
    
    public function getProductsByMerchant($merchantId)
    {
        return $this->where('merchant_id', $merchantId)
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }

    public function getProductsWithDetails()
    {
        return $this->select('products.*, categories.name as category_name, merchant_profiles.shop_name as merchant_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->join('merchant_profiles', 'merchant_profiles.user_id = products.merchant_id', 'left')
            ->orderBy('products.created_at', 'DESC')
            ->findAll();
    }
    
    public function search($keyword)
    {
        return $this->select('products.*, categories.name as category_name')
                    ->join('categories', 'categories.id = products.category_id', 'left')
                    ->like('products.name', $keyword)
                    ->orLike('products.description', $keyword)
                    ->orLike('categories.name', $keyword)
                    ->findAll();
    }
}
