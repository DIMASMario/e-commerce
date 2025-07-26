<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kontak Kami</title>
    <link rel="stylesheet" href="<?= base_url('public/assets/css/style.css') ?>">
</head>
<body>
    <?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- Contact Hero Section -->
<section class="contact-hero py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Hubungi <span class="text-primary">Kami</span></h1>
                <p class="lead mb-0">Ada pertanyaan, saran, atau ingin berkolaborasi? Kami siap mendengarkan dan membantu Anda.</p>
            </div>
            <div class="col-lg-6 d-none d-lg-block text-center">
                <img src="<?= base_url('assets/images/custttom.png') ?>" alt="Contact Us" class="img-fluid contact-hero-img" style="max-height: 300px;">
            </div>
        </div>
    </div>
</section>

<!-- Contact Methods Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Customer Service -->
            <div class="col-md-4">
                <div class="contact-card card border-0 rounded-4 shadow-sm h-100 hover-lift text-center p-4">
                    <div class="contact-icon-wrapper mb-3 mx-auto">
                        <i class="bi bi-headset text-primary"></i>
                    </div>
                    <h3 class="card-title fs-4 mb-3">Customer Service</h3>
                    <p class="card-text mb-3">Layanan pelanggan kami siap membantu Anda setiap hari pukul 08.00 - 20.00 WIB</p>
                    <a href="tel:+6285647181562" class="btn btn-outline-primary rounded-pill mt-auto">
                        <i class="bi bi-telephone-fill me-2"></i>+62 856-4718-1562
                    </a>
                </div>
            </div>
            
            <!-- Email -->
            <div class="col-md-4">
                <div class="contact-card card border-0 rounded-4 shadow-sm h-100 hover-lift text-center p-4">
                    <div class="contact-icon-wrapper mb-3 mx-auto">
                        <i class="bi bi-envelope text-primary"></i>
                    </div>
                    <h3 class="card-title fs-4 mb-3">Email</h3>
                    <p class="card-text mb-3">Kirim email kepada kami untuk pertanyaan, saran, atau kolaborasi bisnis</p>
                    <a href="mailto:novantoerilistianto@gmail.com" class="btn btn-outline-primary rounded-pill mt-auto">
                        <i class="bi bi-envelope-fill me-2"></i>novantoerilistianto@gmail.com
                    </a>
                </div>
            </div>
            
            <!-- Shopee -->
            <div class="col-md-4">
                <div class="contact-card card border-0 rounded-4 shadow-sm h-100 hover-lift text-center p-4">
                    <div class="contact-icon-wrapper mb-3 mx-auto">
                        <i class="bi bi-shop text-primary"></i>
                    </div>
                    <h3 class="card-title fs-4 mb-3">Shopee Store</h3>
                    <p class="card-text mb-3">Kunjungi toko online kami di Shopee untuk pilihan produk lengkap dan promo menarik</p>
                    <a href="https://shopee.co.id/ncek.store" target="_blank" class="btn btn-outline-primary rounded-pill mt-auto">
                        <i class="bi bi-bag-fill me-2"></i>shopee.co.id/ncek.store
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form & Location Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-5">
            <!-- Contact Form -->
            <div class="col-lg-6">
                <div class="card border-0 rounded-4 shadow-sm p-4">
                    <div class="card-body">
                        <h2 class="card-title mb-4 fw-bold">Kirim Pesan</h2>
                        
                        <?php if(session()->has('message_sent')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i> Pesan Anda berhasil dikirim! Kami akan segera menghubungi Anda.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        
                        <form action="<?= base_url('contact/send') ?>" method="post">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama" required>
                                        <label for="name">Nama Lengkap</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                                        <label for="email">Email</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Subjek" required>
                                        <label for="subject">Subjek</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <textarea class="form-control" id="message" name="message" placeholder="Pesan" style="height: 150px" required></textarea>
                                        <label for="message">Pesan</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary rounded-pill py-3 px-4">
                                        <i class="bi bi-send me-2"></i>Kirim Pesan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Location & Hours -->
            <div class="col-lg-6">
                <div class="mb-5">
                    <h2 class="fw-bold mb-4">Lokasi Kami</h2>
                    <div class="ratio ratio-16x9 rounded-4 shadow-sm overflow-hidden">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.6834790267034!2d110.32984587480486!3d-7.825378177428225!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7af7e8a4482283%3A0x5f3ffc9fe5505350!2sKembaran%2C%20Tamantirto%2C%20Kec.%20Kasihan%2C%20Kabupaten%20Bantul%2C%20Daerah%20Istimewa%20Yogyakarta%2055184!5e0!3m2!1sid!2sid!4v1627286753213!5m2!1sid!2sid" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
                
                <div class="card border-0 rounded-4 shadow-sm p-4 mb-4">
                    <div class="card-body">
                        <h3 class="card-title fs-4 mb-3 fw-bold">Alamat</h3>
                        <p class="mb-0">Jalan Bibis No. 036, RT 03<br>
                        Kembaran, Tamantirto, Kec. Kasihan<br>
                        Kabupaten Bantul, Daerah Istimewa Yogyakarta 55184<br>
                        Indonesia</p>
                    </div>
                </div>
                
                <div class="card border-0 rounded-4 shadow-sm p-4">
                    <div class="card-body">
                        <h3 class="card-title fs-4 mb-3 fw-bold">Jam Operasional</h3>
                        <ul class="list-unstyled opening-hours">
                            <li class="d-flex justify-content-between">
                                <span>Senin - Jumat:</span>
                                <span>08:00 - 20:00</span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <span>Sabtu:</span>
                                <span>10:00 - 18:00</span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <span>Minggu:</span>
                                <span>10:00 - 16:00</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Pertanyaan yang Sering Diajukan</h2>
            <p class="lead text-muted">Beberapa jawaban untuk pertanyaan umum yang mungkin Anda miliki</p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="accordion" id="faqAccordion">
                    <!-- Question 1 -->
                    <div class="accordion-item border-0 rounded-4 shadow-sm mb-3">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button rounded-4 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                Berapa lama waktu pengiriman untuk pesanan saya?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Pengiriman biasanya memakan waktu 2-5 hari kerja tergantung lokasi Anda. Kami menggunakan jasa ekspedisi terpercaya untuk memastikan pesanan Anda sampai tepat waktu.
                            </div>
                        </div>
                    </div>
                    
                    <!-- Question 2 -->
                    <div class="accordion-item border-0 rounded-4 shadow-sm mb-3">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button rounded-4 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Bagaimana cara merawat kaos kaki Sokincek agar tahan lama?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Kami menyarankan untuk mencuci kaos kaki dengan tangan menggunakan air dingin dan deterjen lembut. Hindari penggunaan pemutih dan pengering panas. Jemur di tempat teduh untuk menjaga warna dan elastisitas.
                            </div>
                        </div>
                    </div>
                    
                    <!-- Question 3 -->
                    <div class="accordion-item border-0 rounded-4 shadow-sm mb-3">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button rounded-4 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Apakah ada ukuran khusus untuk kaki yang lebih besar atau kecil?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Ya, kami menyediakan berbagai ukuran dari 35 hingga 46. Jika Anda memerlukan ukuran khusus, silakan hubungi customer service kami dan kami akan berusaha membantu Anda.
                            </div>
                        </div>
                    </div>
                    
                    <!-- Question 4 -->
                    <div class="accordion-item border-0 rounded-4 shadow-sm">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button rounded-4 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Bagaimana kebijakan pengembalian produk?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Kami menerima pengembalian produk dalam waktu 7 hari setelah pesanan diterima dengan kondisi produk belum digunakan, masih dalam kemasan asli, dan disertai nota pembelian. Untuk proses lebih lanjut, silakan hubungi customer service kami.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 text-center text-lg-start">
                <h2 class="mb-3">Tetap Terhubung Dengan Kami!</h2>
                <p class="lead mb-4 mb-lg-0">Dapatkan update terbaru, diskon eksklusif dan berbagai info menarik lainnya.</p>
            </div>
            <div class="col-lg-4">
                <form class="d-flex">
                    <input type="email" class="form-control form-control-lg me-2" placeholder="Email Anda">
                    <button class="btn btn-warning btn-lg" type="submit">Daftar</button>
                </form>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
.contact-hero {
    padding: 4rem 0;
    background: linear-gradient(135deg, #f8f9fc, #eaecf4);
}

.contact-hero-img {
    filter: drop-shadow(0 10px 15px rgba(0,0,0,0.1));
}

.contact-icon-wrapper {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background-color: rgba(13, 110, 253, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
}

.contact-icon-wrapper i {
    font-size: 2rem;
}

.contact-card {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.hover-lift {
    transition: all 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}

.opening-hours li {
    padding: 8px 0;
    border-bottom: 1px solid #eee;
}

.opening-hours li:last-child {
    border-bottom: none;
}

.accordion-button:not(.collapsed) {
    color: var(--bs-primary);
    background-color: rgba(13, 110, 253, 0.1);
    box-shadow: none;
}

.accordion-button:focus {
    box-shadow: none;
    border-color: rgba(13, 110, 253, 0.1);
}

@media (max-width: 768px) {
    .contact-hero {
        padding: 3rem 0;
    }
}
</style>
<?= $this->endSection() ?>
</body>
</html>
