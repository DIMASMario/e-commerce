<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class Categories extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $categories = $this->categoryModel->findAll();
        
        // Tambahkan created_at jika tidak ada
        foreach ($categories as &$category) {
            if (!isset($category['created_at'])) {
                $category['created_at'] = date('Y-m-d H:i:s');
            }
        }

        $data = [
            'title' => 'Kelola Kategori',
            'categories' => $categories
        ];

        return view('admin/categories/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Kategori'
        ];

        return view('admin/categories/create', $data);
    }

    public function store()
    {
        $postData = $this->request->getPost();

        $this->categoryModel->save([
            'name' => $postData['name'],
            'description' => $postData['description'] ?? ''
        ]);

        return redirect()->to(base_url('admin/categories'))->with('success', 'Kategori berhasil ditambahkan.');
    }
}
