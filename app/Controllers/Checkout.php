<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\CartModel;
use App\Models\OrderDetailModel;
use App\Models\PaymentModel;

class Checkout extends BaseController
{
    protected $cartModel;
    protected $orderModel;
    protected $orderDetailModel;
    protected $paymentModel;
    protected $db;
    
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->cartModel = new CartModel();
        $this->orderModel = new OrderModel();
        $this->orderDetailModel = new OrderDetailModel();
        $this->paymentModel = new PaymentModel();
    }
    
    public function index()
    {
        // Redirect jika user belum login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu untuk checkout');
        }
        
        $userId = session()->get('id');
        
        // Ambil item cart untuk user yang sedang login
        $cartItems = $this->cartModel->getCartItems($userId);
        
        // Redirect jika cart kosong
        if (empty($cartItems)) {
            return redirect()->to('/cart')->with('error', 'Keranjang Anda masih kosong');
        }
        
        // Hitung total belanjaan
        $cartTotal = 0;
        foreach ($cartItems as $item) {
            $cartTotal += ($item['price'] * $item['quantity']);
        }
        
        $data = [
            'title' => 'Checkout',
            'cartItems' => $cartItems,
            'cartTotal' => $cartTotal
        ];
        
        return view('checkout/index', $data);
    }
    
    public function process()
    {
        // Pastikan user sudah login
        if (!session()->get('user_id')) {
            return redirect()->to('login')->with('error', 'Silakan login terlebih dahulu untuk melakukan checkout.');
        }

        // Validasi data
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required',
            'email' => 'required|valid_email',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'payment_method' => 'required'
        ]);
        
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        
        // Pastikan user_id tidak null
        $userId = session()->get('user_id');
        
        // Simpan order langsung dengan data pelanggan
        $orderModel = model('OrderModel');
        $orderId = $orderModel->insert([
            'user_id' => $userId,
            'invoice_number' => $this->generateInvoiceNumber(),
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'city' => $this->request->getPost('city'),
            'postal_code' => $this->request->getPost('postal_code'),
            'payment_method' => $this->request->getPost('payment_method'),
            'total_amount' => $this->calculateTotalAmount(),
            'total_price' => $this->calculateTotalPrice(),
            'status' => 'waiting_payment',
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        // Simpan item order dari cart ke database
        $cart = session()->get('cart') ?? [];
        $orderDetailModel = model('OrderDetailModel');
        
        foreach ($cart as $item) {
            $orderDetailModel->insert([
                'order_id' => $orderId,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
            
            // Optional: Kurangi stok produk
            $productModel = model('ProductModel');
            $product = $productModel->find($item['id']);
            if ($product) {
                $newStock = $product['stock'] - $item['quantity'];
                $productModel->update($item['id'], ['stock' => max(0, $newStock)]);
            }
        }
        
        // Kosongkan keranjang setelah checkout
        session()->remove('cart');
        
        // Redirect ke halaman sukses
        return redirect()->to('checkout/success/' . $orderId);
    }
    
    public function success($orderId)
    {
        // Redirect jika user belum login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        
        $userId = session()->get('id');
        
        // Ambil data order
        $order = $this->orderModel->find($orderId);
        
        // Validasi order dimiliki oleh user yang sedang login
        if (!$order || $order['user_id'] != $userId) {
            return redirect()->to('/')->with('error', 'Pesanan tidak ditemukan');
        }
        
        // Jika total_amount kosong atau 0, coba ambil dari total_price
        if (empty($order['total_amount']) || $order['total_amount'] == 0) {
            if (!empty($order['total_price'])) {
                $order['total_amount'] = $order['total_price'];
            } else {
                // Jika keduanya 0, hitung dari order_details
                $orderDetails = $this->orderDetailModel->where('order_id', $orderId)->findAll();
                $totalAmount = 0;
                foreach ($orderDetails as $item) {
                    $totalAmount += ($item['price'] * $item['quantity']);
                }
                $order['total_amount'] = $totalAmount;
                
                // Update order di database
                $this->orderModel->update($orderId, [
                    'total_amount' => $totalAmount,
                    'total_price' => $totalAmount
                ]);
            }
        }
        
        // Ambil data payment
        $payment = $this->paymentModel->where('order_id', $orderId)->first();
        
        $data = [
            'title' => 'Checkout Berhasil',
            'order' => $order,
            'payment' => $payment
        ];
        
        return view('checkout/success', $data);
    }
    
    /**
     * Generate unique invoice number
     * Format: INV-YYYYMMDD-XXXX (XXXX is random number)
     * 
     * @return string
     */
    private function generateInvoiceNumber()
    {
        $prefix = 'INV';
        $dateCode = date('Ymd');
        $randomCode = sprintf("%04d", mt_rand(1, 9999));
        
        return $prefix . '-' . $dateCode . '-' . $randomCode;
    }
    
    /**
     * Hitung total jumlah barang di keranjang
     * 
     * @return int
     */
    private function calculateTotalAmount()
    {
        $cart = session()->get('cart') ?? [];
        $totalAmount = 0;
        
        foreach ($cart as $item) {
            $totalAmount += $item['quantity'];
        }
        
        return $totalAmount;
    }

    /**
     * Hitung total harga barang di keranjang
     * 
     * @return float
     */
    private function calculateTotalPrice()
    {
        $cart = session()->get('cart') ?? [];
        $totalPrice = 0;
        
        foreach ($cart as $item) {
            $totalPrice += ($item['price'] * $item['quantity']);
        }
        
        return $totalPrice;
    }
}