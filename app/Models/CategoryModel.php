<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table      = 'categories';
    protected $primaryKey = 'id';
    
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    
    protected $allowedFields = ['name', 'description'];
    
    // Tambahkan method afterFind untuk menangani data yang tidak memiliki created_at
    protected function afterFind($data)
    {
        // Jika data tunggal
        if (isset($data['data'])) {
            if (!isset($data['data']['created_at'])) {
                $data['data']['created_at'] = date('Y-m-d H:i:s');
            }
        } 
        // Jika data multiple
        else if (is_array($data)) {
            foreach ($data as $key => $row) {
                if (!isset($row['created_at'])) {
                    $data[$key]['created_at'] = date('Y-m-d H:i:s');
                }
            }
        }
        
        return $data;
    }
}