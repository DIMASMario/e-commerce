<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\PaymentModel;

class OrderController extends BaseController
{
    public function success($orderId)
    {
        $orderModel = new OrderModel();
        $order = $orderModel->find($orderId);

        // Pastikan order milik user yang sedang login
        if (!$order || $order['user_id'] != session()->get('id')) {
            return redirect()->to('/')->with('error', 'Pesanan tidak ditemukan.');
        }

        return view('order/success', ['order' => $order]);
    }

    public function upload_proof()
    {
        $orderId = $this->request->getPost('order_id');
        $validationRule = [
            'payment_proof' => [
                'label' => 'Bukti Pembayaran',
                'rules' => 'uploaded[payment_proof]'
                    . '|is_image[payment_proof]'
                    . '|mime_in[payment_proof,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                    . '|max_size[payment_proof,2048]',
            ],
        ];

        if (!$this->validate($validationRule)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $img = $this->request->getFile('payment_proof');

        if ($img->isValid() && !$img->hasMoved()) {
            $newName = $img->getRandomName();
            $img->move(FCPATH . 'uploads/payments', $newName);

            $paymentModel = new PaymentModel();
            // Update record payment yang sudah ada
            $paymentModel->where('order_id', $orderId)
                         ->set(['payment_proof' => $newName, 'status' => 'pending_verification'])
                         ->update();

            return redirect()->to('/order/success/' . $orderId)->with('success', 'Bukti pembayaran berhasil diunggah.');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah bukti pembayaran.');
    }
}