# Sokincek - Website E-Commerce Khusus Penjualan Kaos Kaki

Sokincek adalah platform e-commerce yang berfokus pada penjualan kaos kaki premium dengan kualitas tinggi. Website ini dibangun menggunakan CodeIgniter 4 dan menyediakan sistem lengkap untuk admin, merchant, dan user dengan fitur pembayaran manual dan notifikasi email otomatis.

## 🚀 Fitur Utama

### 👤 User (Pelanggan)
- Registrasi dan login
- Edit profil pengguna
- Katalog produk kaos kaki dengan filter kategori
- Pencarian produk
- Keranjang belanja
- Sistem checkout lengkap
- Upload bukti pembayaran
- Tracking status pesanan
- Riwayat transaksi
- Wishlist produk

### 🛍️ Merchant (Penjual)
- Dashboard merchant
- CRUD produk kaos kaki
- Manajemen toko
- Lihat dan kelola pesanan masuk
- Update status pesanan
- Statistik penjualan
- Profil toko

### 🛠️ Admin
- Dashboard admin lengkap
- Manajemen user dan merchant (CRUD, ban/unban)
- Verifikasi pembayaran
- Laporan transaksi dan penjualan
- Kelola kategori produk
- Sistem notifikasi email otomatis
- Monitoring semua aktivitas

## 🛠️ Teknologi yang Digunakan

- **Framework**: CodeIgniter 4
- **Database**: MySQL
- **Frontend**: Bootstrap 5
- **Icons**: Bootstrap Icons
- **Email**: PHPMailer/SMTP
- **Authentication**: Manual login/logout
- **File Upload**: Bukti pembayaran
- **Architecture**: MVC Pattern

## 📋 Persyaratan Sistem

- PHP 8.0 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Composer
- Web server (Apache/Nginx)
- Ekstensi PHP yang diperlukan:
  - php-curl
  - php-gd
  - php-intl
  - php-json
  - php-mbstring
  - php-mysqlnd

## 🔧 Instalasi

### 1. Clone Repository
```bash
git clone [repository-url]
cd sokincek_project
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Konfigurasi Environment
```bash
cp .env.example .env
```

Edit file `.env` dan sesuaikan konfigurasi database dan email:

```env
# Database
database.default.hostname = localhost
database.default.database = capstone_project
database.default.username = your_username
database.default.password = your_password
database.default.DBDriver = MySQLi

# Email Configuration
mail.fromEmail = noreply@socksin.com
mail.fromName  = Socksin Notifikasi
mail.protocol = smtp
mail.SMTPHost = live.smtp.mailtrap.io
mail.SMTPUser = api
mail.SMTPPass = your_smtp_password
mail.SMTPPort = 587
mail.SMTPCrypto = tls
mail.mailType = html
```

### 4. Setup Database
```bash
# Import database
mysql -u username -p database_name < capstone_project.sql

# Atau jalankan migrasi (jika tersedia)
php spark migrate
php spark db:seed DatabaseSeeder
```

### 5. Set Permissions
```bash
chmod -R 755 writable/
chmod -R 755 public/uploads/
```

### 6. Jalankan Aplikasi
```bash
php spark serve
```

Akses aplikasi di `http://localhost:8080`

## 📁 Struktur Database

### Tabel Utama:

#### users
```sql
- id (PK)
- name
- email
- password
- role (admin/user/merchant)
- created_at
```

#### products
```sql
- id (PK)
- merchant_id (FK)
- name
- description
- price
- stock
- image
- category_id (FK)
- created_at
```

#### orders
```sql
- id (PK)
- user_id (FK)
- total_price
- status (pending/paid/shipped/canceled)
- created_at
```

#### payments
```sql
- id (PK)
- order_id (FK)
- user_id (FK)
- payment_proof (image)
- status
- created_at
```

[Lihat ERD lengkap di dokumentasi]

## 🎯 Panduan Penggunaan

### Admin
1. Login dengan akun admin
2. Kelola user dan merchant dari dashboard
3. Verifikasi pembayaran yang masuk
4. Monitor laporan penjualan
5. Kelola kategori produk

### Merchant
1. Daftar sebagai merchant
2. Lengkapi profil toko
3. Tambah produk kaos kaki
4. Kelola pesanan masuk
5. Update status pengiriman

### User
1. Registrasi akun baru
2. Browse katalog kaos kaki
3. Tambah produk ke keranjang
4. Checkout dan upload bukti pembayaran
5. Track status pesanan

## 📧 Sistem Notifikasi Email

Setiap kali user mengupload bukti pembayaran, sistem akan:
- Mengirim email notifikasi ke admin
- Subject: "[Pembayaran Baru] Order ID #123 oleh User X"
- Berisi link ke dashboard admin dan detail pesanan

## 🔐 Keamanan

- Password hashing menggunakan PHP password_hash()
- Validasi input pada semua form
- Protection terhadap SQL injection
- File upload security untuk bukti pembayaran
- Role-based access control

## 📱 Responsive Design

Website fully responsive menggunakan Bootstrap 5:
- Mobile-first approach
- Optimized untuk semua ukuran layar
- Touch-friendly interface
- Fast loading dengan optimized assets

## 🎨 Fitur UI/UX

- Modern dan clean design
- Smooth animations dan transitions
- User-friendly navigation
- Intuitive checkout process
- Professional product showcase
- Dark/light mode support (opsional)

## 🔧 Maintenance

### Update Dependencies
```bash
composer update
```

### Clear Cache
```bash
php spark cache:clear
```

### Database Backup
```bash
mysqldump -u username -p database_name > backup.sql
```

## 📊 Monitoring & Analytics

- Sales dashboard dengan grafik
- User activity tracking
- Inventory management
- Revenue reports
- Popular products analytics

## 🤝 Contributing

1. Fork repository
2. Buat feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📝 License

Project ini menggunakan [MIT License](LICENSE).

## 👥 Tim Pengembang

- **Gianniva Abiel** - Founder & CEO
- **Fattah** - Design Director  
- **Farhan** - Production Manager

## 📞 Support

Untuk bantuan teknis atau pertanyaan:
- Email: support@sokincek.com
- Website: [sokincek.com](http://sokincek.com)

## 🔄 Changelog

### v1.0.0 (Current)
- ✅ Initial release
- ✅ Basic e-commerce functionality
- ✅ User, Merchant, Admin roles
- ✅ Payment verification system
- ✅ Email notifications
- ✅ Responsive design

### Roadmap
- [ ] Payment gateway integration
- [ ] Advanced analytics
- [ ] Mobile app
- [ ] Multi-language support
- [ ] Social media integration

---

**Sokincek** - *Kualitas Premium untuk Setiap Langkah* 🧦
