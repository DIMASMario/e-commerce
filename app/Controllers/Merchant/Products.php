<?php


namespace App\Controllers\Merchant;

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
        $merchantId = session()->get('id');
        
        $products = $this->productModel->getMerchantProducts($merchantId);
        
        $data = [
            'title' => 'Kelola Produk',
            'products' => $products
        ];
        
        return view('merchant/products/index', $data);
    }
    
    public function create()
    {
        $data = [
            'title' => 'Tambah Produk Baru',
            'categories' => $this->categoryModel->findAll()
        ];
        
        return view('merchant/products/create', $data);
    }
    
    public function store()
    {
        $merchantId = session()->get('id');
        
        $rules = [
            'name' => 'required|min_length[3]|max_length[255]',
            'description' => 'required',
            'price' => 'required|numeric|greater_than[0]',
            'stock' => 'required|integer|greater_than_equal_to[0]',
            'category_id' => 'required|integer',
            'image' => 'uploaded[image]|max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Handle image upload
        $img = $this->request->getFile('image');
        $newName = $img->getRandomName();
        
        // Create upload directory if it doesn't exist
        $uploadPath = './uploads/products';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
        
        $img->move($uploadPath, $newName);
        
        $data = [
            'merchant_id' => $merchantId,
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'category_id' => $this->request->getPost('category_id'),
            'image' => $newName,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $this->productModel->insert($data);
        
        return redirect()->to('merchant/products')->with('success', 'Produk berhasil ditambahkan.');
    }
    
    public function edit($id)
    {
        $merchantId = session()->get('id');
        $product = $this->productModel->find($id);
        
        if (!$product || $product['merchant_id'] != $merchantId) {
            return redirect()->to('merchant/products')->with('error', 'Produk tidak ditemukan.');
        }
        
        $data = [
            'title' => 'Edit Produk',
            'product' => $product,
            'categories' => $this->categoryModel->findAll()
        ];
        
        return view('merchant/products/edit', $data);
    }
    
    public function update($id)
    {
        $merchantId = session()->get('id');
        $product = $this->productModel->find($id);
        
        if (!$product || $product['merchant_id'] != $merchantId) {
            return redirect()->to('merchant/products')->with('error', 'Produk tidak ditemukan.');
        }
        
        $rules = [
            'name' => 'required|min_length[3]|max_length[255]',
            'description' => 'required',
            'price' => 'required|numeric|greater_than[0]',
            'stock' => 'required|integer|greater_than_equal_to[0]',
            'category_id' => 'required|integer'
        ];
        
        // Only validate image if a new one is uploaded
        $img = $this->request->getFile('image');
        if ($img->isValid() && !$img->hasMoved()) {
            $rules['image'] = 'uploaded[image]|max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]';
        }
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'category_id' => $this->request->getPost('category_id')
        ];
        
        // Handle image update if a new one is uploaded
        if ($img->isValid() && !$img->hasMoved()) {
            $newName = $img->getRandomName();
            
            // Create upload directory if it doesn't exist
            $uploadPath = './uploads/products';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            $img->move($uploadPath, $newName);
            
            // Delete old image
            if (file_exists('./uploads/products/' . $product['image']) && $product['image'] != 'default.jpg') {
                unlink('./uploads/products/' . $product['image']);
            }
            
            $data['image'] = $newName;
        }
        
        $this->productModel->update($id, $data);
        
        return redirect()->to('merchant/products')->with('success', 'Produk berhasil diperbarui.');
    }
    
    public function delete($id)
    {
        $merchantId = session()->get('id');
        $product = $this->productModel->find($id);
        
        if (!$product || $product['merchant_id'] != $merchantId) {
            return redirect()->to('merchant/products')->with('error', 'Produk tidak ditemukan.');
        }
        
        // Check if product has orders
        $db = \Config\Database::connect();
        $hasOrders = $db->table('order_details')
                       ->where('product_id', $id)
                       ->countAllResults();
        
        if ($hasOrders > 0) {
            return redirect()->to('merchant/products')->with('error', 'Produk tidak dapat dihapus karena sudah terdapat pesanan.');
        }
        
        // Delete product image
        if (file_exists('./uploads/products/' . $product['image']) && $product['image'] != 'default.jpg') {
            unlink('./uploads/products/' . $product['image']);
        }
        
        $this->productModel->delete($id);
        
        return redirect()->to('merchant/products')->with('success', 'Produk berhasil dihapus.');
    }
}