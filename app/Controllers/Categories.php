<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;

class Categories extends BaseController
{
    protected $categoryModel;
    protected $productModel;
    
    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        $this->productModel = new ProductModel();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Semua Kategori',
            'categories' => $this->categoryModel->findAll()
        ];
        
        return view('categories/index', $data);
    }
    
    public function detail($id)
    {
        $category = $this->categoryModel->find($id);
        
        if (!$category) {
            return redirect()->to('categories')->with('error', 'Kategori tidak ditemukan.');
        }
        
        $data = [
            'title' => 'Produk dalam Kategori: ' . $category['name'],
            'category' => $category,
            'products' => $this->productModel->where('category_id', $id)->findAll()
        ];
        
        return view('categories/detail', $data);
    }
}