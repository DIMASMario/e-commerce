<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Profile extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $userId = session()->get('id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('/auth/login')->with('error', 'User tidak ditemukan.');
        }

        $data = [
            'title' => 'Profil Saya',
            'user' => $user,
        ];

        return view('user/profile', $data);
    }
}
