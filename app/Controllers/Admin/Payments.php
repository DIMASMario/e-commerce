<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PaymentModel;
use App\Models\OrderModel;
use App\Models\UserModel;
use App\Models\OrderDetailModel;
use App\Libraries\EmailService;

class Payments extends BaseController
{
    protected $paymentModel;
    protected $orderModel;
    protected $userModel;
    protected $orderDetailModel;
    
    public function __construct()
    {
        $this->paymentModel = new PaymentModel();
        $this->orderModel = new OrderModel();
        $this->userModel = new UserModel();
        $this->orderDetailModel = new OrderDetailModel();
    }
    
    public function index()
    {
        $paymentsData = $this->paymentModel->getPaymentsWithDetails();
        
        $data = [
            'title' => 'Kelola Pembayaran',
            'payments' => $paymentsData['all'],
            'waitingPayments' => $paymentsData['waiting'],
            'verifiedPayments' => $paymentsData['verified'],
            'rejectedPayments' => $paymentsData['rejected']
        ];
        
        return view('admin/payments/index', $data);
    }
    
    public function detail($id)
    {
        $payment = $this->paymentModel->find($id);
        
        if (!$payment) {
            return redirect()->to('admin/payments')->with('error', 'Pembayaran tidak ditemukan.');
        }
        
        $order = $this->orderModel->find($payment['order_id']);
        $user = $this->userModel->find($payment['user_id']);
        $orderDetails = $this->orderDetailModel->getDetailsByOrder($payment['order_id']);
        
        // Hitung total pesanan dari order_details jika total_amount tidak ada atau 0
        if (empty($order['total_amount']) || $order['total_amount'] == 0) {
            $totalAmount = 0;
            foreach ($orderDetails as $item) {
                $totalAmount += ($item['price'] * $item['quantity']);
            }
            $order['total_amount'] = $totalAmount;
            
            // Update order di database
            $this->orderModel->update($order['id'], [
                'total_amount' => $totalAmount,
                'total_price' => $totalAmount
            ]);
        }
        
        $data = [
            'title' => 'Detail Pembayaran',
            'payment' => $payment,
            'order' => $order,
            'user' => $user,
            'orderDetails' => $orderDetails
        ];
        
        return view('admin/payments/detail', $data);
    }
    
    public function verify($id)
    {
        $payment = $this->paymentModel->find($id);
        
        if (!$payment) {
            return redirect()->to('admin/payments')->with('error', 'Pembayaran tidak ditemukan.');
        }
        
        $adminId = session()->get('id');
        $note = $this->request->getPost('verification_note') ?? 'Pembayaran diverifikasi';
        
        // Update payment status
        $this->paymentModel->update($id, [
            'status' => 'verified', 
            'verified_by' => $adminId,
            'verification_note' => $note,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        
        // Update order status to paid
        $this->orderModel->update($payment['order_id'], ['status' => 'paid']);
        
        // Send notification to user (with try-catch for error handling)
        try {
            $order = $this->orderModel->find($payment['order_id']);
            $user = $this->userModel->find($payment['user_id']);
            
            $emailService = new \App\Libraries\EmailService();
            $emailService->sendPaymentVerificationNotification($user['email'], $order, $user);
        } catch (\Exception $e) {
            log_message('error', 'Failed to send verification email: ' . $e->getMessage());
            // Continue execution even if email fails
        }
        
        return redirect()->to('admin/payments')->with('success', 'Pembayaran berhasil diverifikasi.');
    }
    
    public function reject($id)
    {
        $payment = $this->paymentModel->find($id);
        
        if (!$payment) {
            return redirect()->to('admin/payments')->with('error', 'Pembayaran tidak ditemukan.');
        }
        
        $adminId = session()->get('id');
        $reason = $this->request->getPost('reason');
        
        if (empty($reason)) {
            return redirect()->back()->with('error', 'Alasan penolakan harus diisi.');
        }
        
        // Update payment status
        $this->paymentModel->update($id, [
            'status' => 'rejected',
            'verified_by' => $adminId,
            'verification_note' => $reason,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        
        // Update order status to waiting_payment
        $this->orderModel->update($payment['order_id'], ['status' => 'waiting_payment']);
        
        // Send notification to user
        $order = $this->orderModel->find($payment['order_id']);
        $user = $this->userModel->find($payment['user_id']);
        
        $emailService = new EmailService();
        $emailService->sendPaymentRejectionNotification($user['email'], $order, $user, $reason);
        
        return redirect()->to('admin/payments')->with('success', 'Pembayaran ditolak dan pemberitahuan telah dikirim ke pelanggan.');
    }
}