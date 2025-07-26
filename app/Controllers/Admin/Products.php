<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;

class Products extends BaseController
{
    protected $productModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        // Ambil data produk dengan JOIN ke tabel kategori dan users (untuk nama merchant)
        $products = $this->productModel
            ->select('products.*, categories.name as category_name, users.name as merchant_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->join('users', 'users.id = products.merchant_id', 'left') // Asumsi ada kolom merchant_id di tabel products
            ->findAll();

        $data = [
            'title' => 'Manajemen Produk',
            'products' => $products
        ];

        return view('admin/products/index', $data);
    }

    public function create()
    {
        $categories = $this->categoryModel->orderBy('name', 'ASC')->findAll();

        // If no categories found, you may want to seed or handle this case
        if (empty($categories)) {
            // Optionally, you can add default categories here or notify admin
        }

        $data = [
            'title' => 'Tambah Produk',
            'categories' => $categories,
        ];

        return view('admin/products/create', $data);
    }

    public function store()
    {
        // 1. Validasi input, termasuk nama kategori
        $rules = [
            'name' => 'required|min_length[3]',
            'category_name' => 'required|min_length[3]',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'uploaded[image]|max_size[image,1024]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. Proses Kategori
        $categoryName = $this->request->getPost('category_name');
        $category = $this->categoryModel->where('name', $categoryName)->first();

        if ($category) {
            // Jika kategori sudah ada, pakai ID yang ada
            $categoryId = $category['id'];
        } else {
            // Jika belum ada, buat kategori baru
            $this->categoryModel->save([
                'name' => $categoryName,
                'slug' => url_title($categoryName, '-', true)
            ]);
            $categoryId = $this->categoryModel->getInsertID();
        }

        // 3. Proses Upload Gambar
        $imageFile = $this->request->getFile('image');
        $imageName = $imageFile->getRandomName();
        $imageFile->move(ROOTPATH . 'public/uploads/products', $imageName);

        // 4. Simpan data produk dengan category_id yang sudah didapat
        $this->productModel->save([
            'name' => $this->request->getPost('name'),
            'slug' => url_title($this->request->getPost('name'), '-', true),
            'category_id' => $categoryId,
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'description' => $this->request->getPost('description'),
            'image' => $imageName
        ]);

        return redirect()->to('/admin/products')->with('success', 'Produk berhasil ditambahkan.');
    }
}
