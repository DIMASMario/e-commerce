<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\MerchantProfileModel;

class Auth extends BaseController
{
    protected $userModel;
    protected $merchantModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->merchantModel = new MerchantProfileModel();
    }
    
    public function index()
    {
        return redirect()->to('/auth/login');
    }
    
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return $this->redirectBasedOnRole();
        }
        
        return view('auth/login');
    }
    
    public function attemptLogin()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $role = $this->request->getPost('role');

        $user = $this->userModel->where('email', $email)
                                ->where('role', $role)
                                ->first();

        if (!$user) {
            log_message('error', "User tidak ditemukan: $email, role: $role");
            return redirect()->back()->withInput()->with('error', 'Email atau password salah');
        } else {
            if (password_verify($password, $user['password'])) {
                // login sukses
            } else {
                log_message('error', "Password salah untuk: $email, role: $role");
                return redirect()->back()->withInput()->with('error', 'Email atau password salah');
            }
        }
        
        // Set session
        session()->set([
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
            'isLoggedIn' => true
        ]);
        
        return $this->redirectBasedOnRole();
    }
    
    public function register()
    {
        if (session()->get('isLoggedIn')) {
            return $this->redirectBasedOnRole();
        }
        
        return view('auth/register');
    }
    
    public function attemptRegister()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]',
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Insert user data
        $userData = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'), // Will be hashed in model
            'role' => 'user',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $this->userModel->insert($userData);
        
        return redirect()->to('auth/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
    
    public function registerMerchant()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'user') {
            return redirect()->to('auth/login')->with('error', 'Anda harus login terlebih dahulu');
        }
        
        return view('auth/register_merchant');
    }
    
    public function attemptRegisterMerchant()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'user') {
            return redirect()->to('auth/login')->with('error', 'Anda harus login terlebih dahulu');
        }
        
        $rules = [
            'shop_name' => 'required|min_length[3]|max_length[100]',
            'address' => 'required|min_length[10]',
            'contact' => 'required|min_length[10]|max_length[20]',
            'terms' => 'required',
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Update user role
        $this->userModel->update(session()->get('id'), ['role' => 'merchant']);
        
        // Insert merchant profile
        $merchantData = [
            'user_id' => session()->get('id'),
            'shop_name' => $this->request->getPost('shop_name'),
            'address' => $this->request->getPost('address'),
            'contact' => $this->request->getPost('contact'),
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $this->merchantModel->insert($merchantData);
        
        // Update session
        session()->set('role', 'merchant');
        
        return redirect()->to('merchant/dashboard')->with('success', 'Selamat! Akun merchant Anda telah aktif.');
    }
    
    public function logout()
    {
        session()->destroy();
        return redirect()->to('auth/login')->with('success', 'Anda telah berhasil logout');
    }
    
    private function redirectBasedOnRole()
    {
        $role = session()->get('role');
        
        if ($role === 'admin') {
            return redirect()->to('admin/dashboard');
        } else if ($role === 'merchant') {
            return redirect()->to('merchant/dashboard');
        } else {
            return redirect()->to('user/dashboard');
        }
    }
    
    public function initAdmin()
    {
        // This method is for development only, to create the first admin
        // Should be removed in production
        
        $existingAdmin = $this->userModel->where('role', 'admin')->first();
        
        if ($existingAdmin) {
            return redirect()->to('auth/login')->with('error', 'Admin sudah ada');
        }
        
        $adminData = [
            'name' => 'Administrator',
            'email' => 'admin@socksin.com',
            'password' => password_hash('admin123', PASSWORD_DEFAULT), // hash password
            'role' => 'admin',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $this->userModel->insert($adminData);
        
        return redirect()->to('auth/login')->with('success', 'Admin berhasil dibuat! Email: admin@socksin.com, Password: admin123');
    }
    
    public function doLogin()
    {
        // Validasi input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'email' => 'required|valid_email',
            'password' => 'required'
        ]);
        
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        
        $userModel = model('UserModel');
        $user = $userModel->where('email', $email)->first();
        
        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Email tidak ditemukan');
        }
        
        if (!password_verify($password, $user->password)) {
            return redirect()->back()->withInput()->with('error', 'Password salah');
        }
        
        // Set session user
        session()->set([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_role' => $user->role,
            'logged_in' => true
        ]);
        
        // Redirect sesuai role
        if ($user->role == 'admin') {
            return redirect()->to('admin/dashboard');
        } else {
            return redirect()->to('/');
        }
    }
}