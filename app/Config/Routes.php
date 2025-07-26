<?php

// Route Login dan Register yang lebih sederhana
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::attemptRegister');
$routes->get('logout', 'Auth::logout');

// Auth group untuk fitur tambahan dan kompatibilitas dengan kode lama
$routes->group('auth', function($routes) {
    // Route untuk kompatibilitas dengan form lama
    $routes->get('login', 'Auth::login');             // Tambahkan ini untuk kompatibilitas
    $routes->post('login', 'Auth::attemptLogin');     // Tambahkan ini untuk kompatibilitas
    $routes->get('register', 'Auth::register');       // Tambahkan ini untuk kompatibilitas
    $routes->post('register', 'Auth::attemptRegister'); // Tambahkan ini untuk kompatibilitas
    $routes->get('logout', 'Auth::logout');           // Tambahkan ini untuk kompatibilitas
    
    // Fitur merchant
    $routes->get('register-merchant', 'Auth::registerMerchant');
    $routes->post('register-merchant', 'Auth::attemptRegisterMerchant');
    
    // Rute auth lainnya jika diperlukan
});

// User routes
$routes->get('/', 'Home::index'); // Set homepage to landing page
$routes->get('search', 'Search::index'); // Tambahkan route untuk pencarian global
$routes->get('products', 'Products::index'); // Add route for products list
$routes->get('products/search', 'Products::search'); // Route untuk pencarian produk
$routes->get('products/category/(:num)', 'Products::byCategory/$1'); // Route untuk produk berdasarkan kategori
$routes->get('products/(:num)', 'Products::detail/$1'); // Route untuk detail produk

// Tambahkan route untuk kategori
$routes->get('categories', 'Categories::index'); // Menampilkan daftar kategori untuk publik
$routes->get('categories/(:num)', 'Categories::detail/$1'); // Menampilkan produk dalam kategori

$routes->get('about', 'Landing::about'); // Add route for about page
$routes->get('contact', 'Landing::contact'); // Add route for contact page
$routes->get('order/success/(:num)', 'OrderController::success/$1'); // Add route for order success
$routes->post('order/upload_proof', 'OrderController::upload_proof'); // Add route for uploading proof of payment

// Cart Routes
$routes->get('cart', 'Cart::index'); // Menampilkan halaman keranjang
$routes->post('cart/add', 'Cart::add'); // Menambah item ke keranjang
$routes->get('cart/remove/(:any)', 'Cart::remove/$1'); // Menghapus item
$routes->post('cart/update', 'Cart::update'); // Update kuantitas
$routes->get('cart/clear', 'Cart::clear'); // Mengosongkan keranjang

// Checkout routes
$routes->get('checkout', 'Checkout::index');
$routes->post('checkout/process', 'Checkout::process');
$routes->get('checkout/success/(:num)', 'Checkout::success/$1');

$routes->group('user', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'User\Dashboard::index');
    $routes->get('profile', 'User\Profile::index');
    $routes->post('profile/update', 'User\Profile::update');
    $routes->get('wishlist', 'User\Wishlist::index');
    $routes->post('wishlist/add/(:num)', 'User\Wishlist::add/$1');
    $routes->get('wishlist/remove/(:num)', 'User\Wishlist::remove/$1');
    $routes->get('orders', 'User\Orders::index');
    $routes->get('orders/detail/(:num)', 'User\Orders::detail/$1'); // Tambahkan route untuk detail pesanan user
});

// Merchant routes
$routes->group('merchant', ['filter' => 'merchant'], function($routes) {
    $routes->get('dashboard', 'Merchant\Dashboard::index');
    $routes->get('products', 'Merchant\Products::index');
    $routes->get('products/create', 'Merchant\Products::create');
    $routes->post('products/store', 'Merchant\Products::store');
    $routes->get('orders', 'Merchant\Orders::index');
});

// Admin routes
$routes->group('admin', ['filter' => 'admin'], function($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index');
    
    // Users routes
    $routes->get('users', 'Admin\Users::index');
    $routes->get('users/create', 'Admin\Users::create');
    $routes->post('users/store', 'Admin\Users::store');
    
    // Categories routes
    $routes->get('categories', 'Admin\Categories::index');
    $routes->get('categories/create', 'Admin\Categories::create');
    $routes->post('categories/store', 'Admin\Categories::store');
    $routes->get('categories/edit/(:num)', 'Admin\Categories::edit/$1');
    $routes->post('categories/update/(:num)', 'Admin\Categories::update/$1');
    $routes->post('categories/delete/(:num)', 'Admin\Categories::delete/$1');
    
    // Products routes
    $routes->get('products', 'Admin\Products::index');
    $routes->get('products/create', 'Admin\Products::create');
    $routes->post('products/store', 'Admin\Products::store');
    
    // Orders routes
    $routes->get('orders', 'Admin\Orders::index');
    $routes->get('orders/detail/(:num)', 'Admin\Orders::detail/$1');
    $routes->post('orders/update-status/(:num)', 'Admin\Orders::updateStatus/$1');
    
    // Payment routes
    $routes->get('payments', 'Admin\Payments::index');
    $routes->get('payments/detail/(:num)', 'Admin\Payments::detail/$1');
    $routes->post('payments/verify/(:num)', 'Admin\Payments::verify/$1');
    $routes->post('payments/reject/(:num)', 'Admin\Payments::reject/$1');
    
    // Reports routes
    $routes->get('reports', 'Admin\Reports::index');
});

// Routes untuk landing pages
$routes->get('faq', 'Landing::faq');
$routes->get('privacy-policy', 'Landing::privacy');
$routes->get('terms', 'Landing::terms');

// Tambahkan route ini di bagian yang sesuai
$routes->match(['get', 'post'], 'update-status', 'Landing::updateStatus');

// Rute untuk update status di Merchant Orders
$routes->match(['get', 'post'], 'merchant/orders/update-status', 'Merchant\Orders::updateStatus');

// Tambahkan route ini di file Routes.php
$routes->match(['get', 'post'], 'admin/orders/update-status', 'Admin\Orders::updateStatus');
$routes->match(['get', 'post'], 'admin/orders/update-status/(:num)', 'Admin\Orders::updateStatus/$1');
