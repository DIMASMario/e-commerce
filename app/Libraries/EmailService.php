<?php

namespace App\Libraries;

class EmailService 
{
    protected $email;
    protected $config;
    
    public function __construct()
    {
        $this->config = config('Email');
        $this->config->SMTPTimeout = 30; // Tingkatkan timeout
        
        // Load email library
        $this->email = \Config\Services::email($this->config);
    }
    
    public function sendEmail($to, $subject, $message)
    {
        try {
            // Tentukan pengirim dan penerima
            $this->email->setFrom($this->config->fromEmail, $this->config->fromName);
            $this->email->setTo($to);
            
            // Atur subject dan pesan
            $this->email->setSubject($subject);
            $this->email->setMessage($message);
            
            // Coba kirim email
            if ($this->email->send(false)) {
                return true;
            } else {
                // Log error
                log_message('error', 'Error sending email: ' . $this->email->printDebugger(['headers']));
                return false;
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception in sending email: ' . $e->getMessage());
            return false;
        }
    }
    
    public function sendPaymentVerificationNotification($userEmail, $order, $user)
    {
        $subject = "[Pembayaran Diverifikasi] Order ID #{$order['id']}";
        
        $message = "
        <h2>Pembayaran Anda Telah Diverifikasi</h2>
        <p>Halo {$user['name']},</p>
        <p>Pembayaran Anda untuk pesanan berikut telah diverifikasi:</p>
        <ul>
            <li><strong>Order ID:</strong> #{$order['id']}</li>
            <li><strong>Total:</strong> Rp " . number_format($order['total_price'] ?? $order['total_amount'] ?? 0, 0, ',', '.') . "</li>
        </ul>
        <p>Pesanan Anda akan segera diproses dan dikirim. Anda dapat memantau status pesanan Anda melalui halaman pesanan di akun Anda.</p>
        <p><a href='" . base_url('user/orders/' . $order['id']) . "'>Lihat Detail Pesanan</a></p>
        <p>Terima kasih telah berbelanja di Sokincek Shop!</p>
        ";
        
        return $this->sendEmail($userEmail, $subject, $message);
    }
    
    public function sendPaymentRejectionNotification($userEmail, $order, $user, $reason)
    {
        $subject = "[Pembayaran Ditolak] Order ID #{$order['id']}";
        
        $message = "
        <h2>Pembayaran Anda Ditolak</h2>
        <p>Halo {$user['name']},</p>
        <p>Mohon maaf, pembayaran Anda untuk pesanan berikut telah ditolak:</p>
        <ul>
            <li><strong>Order ID:</strong> #{$order['id']}</li>
            <li><strong>Total:</strong> Rp " . number_format($order['total_price'] ?? $order['total_amount'] ?? 0, 0, ',', '.') . "</li>
        </ul>
        <p><strong>Alasan Penolakan:</strong></p>
        <div style='padding: 10px; background-color: #f8f9fa; border-left: 4px solid #dc3545; margin: 10px 0;'>
            {$reason}
        </div>
        <p>Silakan upload ulang bukti pembayaran Anda dengan mengikuti link berikut:</p>
        <p><a href='" . base_url('payments/upload/' . $order['id']) . "'>Upload Bukti Pembayaran</a></p>
        <p>Jika Anda memiliki pertanyaan, silakan hubungi customer service kami.</p>
        ";
        
        return $this->sendEmail($userEmail, $subject, $message);
    }
}