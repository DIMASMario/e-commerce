<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // Ubah dari return view('welcome_message') ke view landing page
        $data = [
            'title' => 'Socksin - Toko Kaos Kaki Online'
        ];
        
        // Pastikan file landing/index.php tersedia di app/Views/
        return view('landing/index', $data);
    }
}
