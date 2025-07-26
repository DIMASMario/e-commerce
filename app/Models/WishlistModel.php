<?php

namespace App\Models;

use CodeIgniter\Model;

class WishlistModel extends Model
{
    protected $table      = 'wishlists';
    protected $primaryKey = 'id';
    
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    
    protected $allowedFields = [
        'user_id', 'product_id'
    ];
    
    public function isProductInWishlist($userId, $productId)
    {
        return $this->where('user_id', $userId)
                    ->where('product_id', $productId)
                    ->countAllResults() > 0;
    }
    
    public function getWishlistWithProducts($userId)
    {
        $db = \Config\Database::connect();
        
        return $db->table('wishlists as w')
                 ->select('w.*, p.name, p.description, p.price, p.stock, p.image, c.name as category_name, mp.shop_name')
                 ->join('products as p', 'p.id = w.product_id')
                 ->join('categories as c', 'c.id = p.category_id')
                 ->join('merchant_profiles as mp', 'mp.user_id = p.merchant_id')
                 ->where('w.user_id', $userId)
                 ->get()
                 ->getResultArray();
    }
}