<?php


namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;

class Search extends BaseController
{
    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        
        if (empty($keyword)) {
            return redirect()->to('/');
        }
        
        // Load model
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();
        
        // Search products
        $products = $productModel->search($keyword);
        
        // Search categories (optional)
        $categories = $categoryModel->like('name', $keyword)
                                   ->orLike('description', $keyword)
                                   ->findAll();
        
        $data = [
            'title' => 'Hasil Pencarian: ' . $keyword,
            'keyword' => $keyword,
            'products' => $products,
            'categories' => $categories
        ];
        
        return view('search/index', $data);
    }
}