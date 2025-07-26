<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table            = 'cart';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['user_id', 'product_id', 'quantity'];
    
    /**
     * Menambahkan produk ke keranjang atau mengupdate kuantitas jika sudah ada.
     */
    public function addToCart($userId, $productId, $quantity = 1)
    {
        // Cek apakah item sudah ada di keranjang
        $item = $this->where('user_id', $userId)
                     ->where('product_id', $productId)
                     ->first();

        if ($item) {
            // Jika sudah ada, update kuantitasnya
            $newQuantity = $item['quantity'] + $quantity;
            $this->update($item['id'], ['quantity' => $newQuantity]);
        } else {
            // Jika belum ada, tambahkan sebagai item baru
            $this->insert([
                'user_id'    => $userId,
                'product_id' => $productId,
                'quantity'   => $quantity,
            ]);
        }
    }

    /**
     * Mengambil semua item di keranjang untuk user tertentu, beserta detail produk dan kategori.
     *
     * @param int $userId
     * @return array
     */
    public function getCartItems(int $userId): array
    {
        // HAPUS 'products.slug' DARI BARIS DI BAWAH INI
        return $this->select('cart.*, products.name, products.price, products.image, categories.name as category_name')
            ->join('products', 'products.id = cart.product_id')
            ->join('categories', 'categories.id = products.category_id', 'left') // Gunakan left join untuk jaga-jaga
            ->where('cart.user_id', $userId)
            ->orderBy('cart.created_at', 'DESC')
            ->asArray()
            ->findAll();
    }

    /**
     * Menghitung total harga dari semua item di keranjang user.
     */
    public function calculateCartTotal($userId)
    {
        $items = $this->getCartItems($userId); // UBAH INI
        $total = 0;

        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return $total;
    }

    /**
     * Mengupdate kuantitas item tertentu di keranjang.
     */
    public function updateQuantity($cartItemId, $quantity)
    {
        $this->update($cartItemId, ['quantity' => $quantity]);
    }
}