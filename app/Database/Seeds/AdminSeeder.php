<?php
<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Contoh data admin
        $data = [
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => password_hash('password123', PASSWORD_DEFAULT),
            'role' => 'admin',
        ];

        // Using Query Builder
        $this->db->table('users')->insert($data);
    }
}