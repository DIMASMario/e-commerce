<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Kaos Kaki Sepak Bola', 'slug' => 'sepak-bola'],
            ['name' => 'Kaos Kaki SD', 'slug' => 'sd'],
            ['name' => 'Kaos Kaki SMP', 'slug' => 'smp'],
            ['name' => 'Kaos Kaki SMA', 'slug' => 'sma'],
            ['name' => 'Kaos Kaki Kerja', 'slug' => 'kerja'],
            ['name' => 'Kaos Kaki Model', 'slug' => 'model'],
            ['name' => 'Kaos Kaki Muslim', 'slug' => 'muslim'],
        ];

        $this->db->table('categories')->insertBatch($data);
    }
}
