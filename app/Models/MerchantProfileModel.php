<?php

namespace App\Models;

use CodeIgniter\Model;

class MerchantProfileModel extends Model
{
    protected $table      = 'merchant_profiles';
    protected $primaryKey = 'id';
    
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    
    protected $allowedFields = [
        'user_id', 'shop_name', 'address', 'contact', 'created_at'
    ];
    
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    
    public function getMerchantProfileByUserId($userId)
    {
        return $this->where('user_id', $userId)->first();
    }
    
    public function getMerchantProfileWithUser($userId)
    {
        $db = \Config\Database::connect();
        
        $builder = $db->table('merchant_profiles as mp');
        $builder->select('mp.*, u.name, u.email')
                ->join('users as u', 'u.id = mp.user_id')
                ->where('mp.user_id', $userId);
                
        $result = $builder->get()->getRowArray();
        
        return $result;
    }
    
    public function getAllMerchantProfiles()
    {
        $db = \Config\Database::connect();
        
        $builder = $db->table('merchant_profiles as mp');
        $builder->select('mp.*, u.name, u.email')
                ->join('users as u', 'u.id = mp.user_id');
                
        $result = $builder->get()->getResultArray();
        
        return $result;
    }
}