<?php
:\wamp64\www\capstone_project\sokincek_project\app\Controllers\Admin\Orders.php
public function updateStatus($id)
{
    $status = $this->request->getPost('status');
    
    if (!in_array($status, ['pending', 'paid', 'processing', 'shipped', 'completed', 'cancelled'])) {
        return redirect()->to('admin/orders/detail/' . $id)->with('error', 'Status tidak valid.');
    }
    
    $this->orderModel->update($id, [
        'status' => $status,
        'updated_at' => date('Y-m-d H:i:s')
    ]);
    
    // Jika status berubah menjadi 'shipped', kirim email notifikasi ke pelanggan
    if ($status === 'shipped') {
        $order = $this->orderModel->find($id);
        $user = $this->userModel->find($order['user_id']);
        
        // Uncomment jika ingin mengaktifkan fitur notifikasi email
        // $email = \Config\Services::email();
        // $email->setTo($user['email']);
        // $email->setSubject('Pesanan Anda Telah Dikirim - ' . $order['invoice_number']);
        // $email->setMessage('Pesanan Anda dengan nomor invoice ' . $order['invoice_number'] . ' telah dikirim.');
        // $email->send();
    }
    
    return redirect()->to('admin/orders/detail/' . $id)->with('success', 'Status pesanan berhasil diperbarui.');
}