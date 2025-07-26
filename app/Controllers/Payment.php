<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\PaymentModel;
use App\Models\UserModel;
use App\Libraries\EmailService;

class Payment extends BaseController
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
    
    public function index($orderId)
    {
        $userId = session()->get('id');
        
        $order = $this->orderModel->find($orderId);
        
        if (!$order || $order['user_id'] != $userId) {
            return redirect()->to('user/orders')->with('error', 'Pesanan tidak ditemukan');
        }
        
        $payment = $this->paymentModel->where('order_id', $orderId)->first();
        
        // If payment already exists, redirect to order details
        if ($payment) {
            return redirect()->to('user/orders/detail/' . $orderId)
                            ->with('info', 'Anda sudah melakukan pembayaran untuk pesanan ini');
        }
        
        // Get bank account information
        $bankAccounts = [
            [
                'bank' => 'BCA',
                'account_name' => 'PT SOCKSIN INDONESIA',
                'account_number' => '8720384935'
            ],
            [
                'bank' => 'BNI',
                'account_name' => 'PT SOCKSIN INDONESIA',
                'account_number' => '0954283751'
            ],
            [
                'bank' => 'Mandiri',
                'account_name' => 'PT SOCKSIN INDONESIA',
                'account_number' => '1370085429364'
            ]
        ];
        
        $data = [
            'title' => 'Pembayaran Pesanan',
            'order' => $order,
            'bankAccounts' => $bankAccounts
        ];
        
        return view('payment/index', $data);
    }
    
    public function upload($orderId)
    {
        $userId = session()->get('id');
        
        $order = $this->orderModel->find($orderId);
        
        if (!$order || $order['user_id'] != $userId) {
            return redirect()->to('user/orders')->with('error', 'Pesanan tidak ditemukan');
        }
        
        $payment = $this->paymentModel->where('order_id', $orderId)->first();
        
        // If payment already exists, redirect to order details
        if ($payment) {
            return redirect()->to('user/orders/detail/' . $orderId)
                            ->with('info', 'Anda sudah melakukan pembayaran untuk pesanan ini');
        }
        
        $validationRules = [
            'payment_proof' => [
                'label' => 'Bukti Pembayaran',
                'rules' => 'uploaded[payment_proof]|max_size[payment_proof,2048]|mime_in[payment_proof,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Bukti pembayaran harus diunggah',
                    'max_size' => 'Ukuran file maksimal 2MB',
                    'mime_in' => 'Format file harus jpg, jpeg, atau png'
                ]
            ],
        ];
        
        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $img = $this->request->getFile('payment_proof');
        
        if ($img->isValid() && !$img->hasMoved()) {
            // Generate random name
            $newName = $img->getRandomName();
            
            // Create upload directory if not exists
            $uploadPath = './uploads/payments';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            // Move file to uploads directory
            $img->move($uploadPath, $newName);
            
            // Create payment record
            $paymentData = [
                'order_id' => $orderId,
                'user_id' => $userId,
                'payment_proof' => $newName,
                'status' => 'waiting',
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $this->paymentModel->insert($paymentData);
            
            // Update order status
            $this->orderModel->update($orderId, ['status' => 'paid']);
            
            // Send email notification to admin
            $this->sendAdminNotification($orderId);
            
            return redirect()->to('user/orders/detail/' . $orderId)
                            ->with('success', 'Bukti pembayaran berhasil diunggah. Admin akan segera memverifikasi pembayaran Anda.');
        }
        
        return redirect()->back()->with('error', 'Gagal mengunggah bukti pembayaran');
    }
    
    private function sendAdminNotification($orderId)
    {
        $order = $this->orderModel->find($orderId);
        $user = $this->userModel->find($order['user_id']);
        $admin = $this->userModel->where('role', 'admin')->first();
        
        if ($admin) {
            $emailService = new EmailService();
            $emailService->sendPaymentNotification($admin['email'], $order, $user);
        }
    }
}