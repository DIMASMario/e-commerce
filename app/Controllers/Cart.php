<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\ProductModel;

class Cart extends BaseController
{
    protected $cartModel;
    protected $productModel;

    public function __construct()
    {
        $this->cartModel = new CartModel();
        $this->productModel = new ProductModel();
        helper(['form', 'number']);
    }

    /**
     * Menampilkan halaman keranjang belanja.
     */
    public function index()
    {
        $userId = session()->get('id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login untuk melihat keranjang Anda.');
        }

        $data = [
            'title'     => 'Keranjang Belanja',
            'cartItems' => $this->cartModel->getCartItems($userId), // UBAH INI
            'cartTotal' => $this->cartModel->calculateCartTotal($userId)
        ];
        
        // Pastikan Anda sudah membuat view di app/Views/cart/index.php
        return view('cart/index', $data);
    }

    /**
     * Menambahkan item ke keranjang.
     */
    public function add()
    {
        $userId = session()->get('id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login untuk menambahkan produk.');
        }

        $productId = $this->request->getPost('product_id');
        $quantity  = $this->request->getPost('quantity') ?? 1;
        $buyNow    = $this->request->getPost('buy_now') ?? 0; // Tambah parameter buy_now

        // --- TAMBAHKAN VALIDASI INI ---
        if (empty($productId)) {
            log_message('error', 'Mencoba menambahkan ke keranjang dengan product_id kosong.');
            return redirect()->back()->with('error', 'Gagal menambahkan produk, ID produk tidak ditemukan.');
        }
        // --- AKHIR VALIDASI ---

        // Panggil method di CartModel untuk menambah/update item
        $this->cartModel->addToCart($userId, $productId, $quantity);

        // Redirect berdasarkan parameter buy_now
        if ($buyNow == 1) {
            return redirect()->to('checkout')->with('success', 'Produk siap untuk checkout!');
        } else {
            return redirect()->to('cart')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
        }
    }

    /**
     * Mengupdate isi keranjang.
     */
    public function update()
    {
        $userId = session()->get('id');
        $items = $this->request->getPost();

        foreach ($items as $rowid => $item) {
            if (isset($item['qty'])) {
                $this->cartModel->updateQuantity($rowid, $item['qty']);
            }
        }
        
        return redirect()->to('/cart')->with('success', 'Keranjang berhasil diperbarui.');
    }

    /**
     * Menghapus satu item dari keranjang.
     */
    public function remove($cartItemId)
    {
        $this->cartModel->delete($cartItemId);
        return redirect()->to('/cart')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    /**
     * Mengosongkan seluruh keranjang.
     */
    public function clear()
    {
        $userId = session()->get('id');
        $this->cartModel->where('user_id', $userId)->delete();
        
        return redirect()->to('/cart')->with('success', 'Keranjang berhasil dikosongkan.');
    }
}