<?php

namespace App\Controllers;

class Landing extends BaseController
{
    public function index()
    {
        return view('landing/index');
    }

    public function about()
    {
        return view('landing/about');
    }

    public function contact()
    {
        return view('landing/contact');
    }

    public function faq()
    {
        $data = [
            'title' => 'FAQ | Sokincek'
        ];
        return view('landing/faq', $data);
    }

    public function privacy()
    {
        $data = [
            'title' => 'Kebijakan Privasi | Sokincek'
        ];
        return view('landing/privacy', $data);
    }

    public function terms()
    {
        $data = [
            'title' => 'Syarat & Ketentuan | Sokincek'
        ];
        return view('landing/terms', $data);
    }
    
    // Tambahkan method updateStatus
    public function updateStatus()
    {
        // Logika untuk memperbarui status
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');
        
        // Validasi data
        if (!$id || !$status) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Parameter tidak lengkap'
            ]);
        }
        
        // Update status di model (tambahkan kode sesuai model yang Anda gunakan)
        $model = model('OrderModel'); // sesuaikan dengan nama model Anda
        $model->update($id, ['status' => $status]);
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Status berhasil diperbarui'
        ]);
    }
    
    public function test()
    {
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Test method works!'
        ]);
    }
}
