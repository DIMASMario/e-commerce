<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Users extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $users = $this->userModel->findAll();

        $data = [
            'title' => 'Kelola Pengguna',
            'users' => $users,
        ];

        return view('admin/users/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Pengguna',
        ];

        return view('admin/users/create', $data);
    }

    public function store()
    {
        $postData = $this->request->getPost();

        $this->userModel->save([
            'name' => $postData['name'],
            'email' => $postData['email'],
            'role' => $postData['role'],
            'password' => password_hash($postData['password'], PASSWORD_DEFAULT),
        ]);

        return redirect()->to(base_url('admin/users'))->with('success', 'Pengguna berhasil ditambahkan.');
    }
}
