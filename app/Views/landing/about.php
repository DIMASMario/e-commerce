<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Sokincek</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <?= $this->renderSection('styles') ?>
</head>
<body>

<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- Hero Section -->
<section class="about-hero bg-light py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Kualitas Premium <span class="text-primary">untuk Setiap Langkah</span></h1>
                <p class="lead mb-4">Kami menciptakan kaos kaki yang tidak hanya nyaman, tetapi juga merupakan pernyataan gaya yang unik untuk setiap kesempatan.</p>
                <a href="<?= base_url('products') ?>" class="btn btn-primary btn-lg rounded-pill">Jelajahi Koleksi Kami</a>
            </div>
            <div class="col-lg-6 mt-5 mt-lg-0 text-center">
                <div class="hero-image-container">
                    <img src="<?= base_url('assets/images/ChatGPT Image Jul 24, 2025, 10_18_33 AM.png') ?>" alt="Premium Quality Socks" class="img-fluid about-hero-img">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Story -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="position-relative story-image-container">
                    <img src="<?= base_url('assets/images/story.jpg') ?>" alt="Our Story" class="img-fluid rounded-4 shadow story-img">
                    <div class="experience-badge position-absolute bg-primary text-white py-3 px-4 rounded-4 shadow-lg">
                        <h2 class="display-4 fw-bold mb-0">5+</h2>
                        <p class="mb-0">Tahun Pengalaman</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <h2 class="section-title position-relative pb-3 mb-4">Kisah Kami</h2>
                <p class="lead fw-bold mb-4">Dari toko kecil menjadi brand lokal yang dicintai</p>
                <p>Sokincek dimulai pada tahun 2018 dengan ide sederhana - membuat kaos kaki yang benar-benar nyaman dengan desain yang tidak biasa. Kami mulai dengan satu mesin jahit di garasi dan tekad kuat untuk menciptakan produk lokal berkualitas tinggi.</p>
                <p>Setiap pasang kaos kaki Sokincek dirancang dengan perhatian pada detail, kenyamanan, dan daya tahan. Kami berkomitmen untuk menggunakan material premium yang lembut di kulit namun tahan lama dalam penggunaan sehari-hari.</p>
                <p>Kini, kami telah tumbuh menjadi brand lokal yang dikenal dengan kaos kaki premium berkualitas ekspor, namun tetap mempertahankan nilai-nilai inti kami: kualitas tanpa kompromi, desain yang unik, dan kepuasan pelanggan yang utama.</p>
            </div>
        </div>
    </div>
</section>

<!-- Our Values -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title position-relative pb-3">Nilai-Nilai Kami</h2>
            <p class="lead">Prinsip yang memandu setiap langkah perjalanan kami</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 rounded-4 shadow-sm h-100 hover-lift">
                    <div class="card-body p-4 text-center">
                        <div class="value-icon mb-4">
                            <i class="bi bi-award fs-1 text-primary"></i>
                        </div>
                        <h3 class="card-title mb-3">Kualitas Premium</h3>
                        <p class="card-text">Kami menggunakan bahan berkualitas tinggi dan teknik manufaktur terbaik untuk memastikan setiap pasang kaos kaki Sokincek nyaman dan tahan lama.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 rounded-4 shadow-sm h-100 hover-lift">
                    <div class="card-body p-4 text-center">
                        <div class="value-icon mb-4">
                            <i class="bi bi-palette fs-1 text-primary"></i>
                        </div>
                        <h3 class="card-title mb-3">Desain Unik</h3>
                        <p class="card-text">Kami percaya kaos kaki bukan hanya aksesori, tetapi pernyataan gaya. Setiap desain dibuat untuk mengekspresikan keunikan dan personalitas pemakainya.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 rounded-4 shadow-sm h-100 hover-lift">
                    <div class="card-body p-4 text-center">
                        <div class="value-icon mb-4">
                            <i class="bi bi-heart fs-1 text-primary"></i>
                        </div>
                        <h3 class="card-title mb-3">Kepuasan Pelanggan</h3>
                        <p class="card-text">Komitmen kami adalah memberikan pengalaman belanja terbaik, mulai dari pemilihan produk hingga pengiriman ke tangan Anda dengan layanan pelanggan yang responsif.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Manufacturing Process -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 order-lg-2 mb-4 mb-lg-0">
                <div class="manufacturing-image-container">
                    <img src="<?= base_url('assets/images/manufacturing.png') ?>" alt="Manufacturing Process" class="img-fluid rounded-4 shadow manufacturing-img">
                </div>
            </div>
            <div class="col-lg-6 order-lg-1">
                <h2 class="section-title position-relative pb-3 mb-4">Proses Pembuatan</h2>
                <p>Setiap pasang kaos kaki Sokincek melalui proses yang teliti dan penuh perhatian. Dimulai dengan pemilihan bahan premium yang lembut namun tahan lama, dilanjutkan dengan proses tenun yang presisi menggunakan mesin modern.</p>
                <div class="process-steps">
                    <div class="d-flex mb-3">
                        <div class="process-number rounded-circle bg-primary text-white me-3 d-flex align-items-center justify-content-center">1</div>
                        <div>
                            <h5>Pemilihan Bahan</h5>
                            <p>Hanya bahan berkualitas terbaik yang kami gunakan, dengan perhatian khusus pada kenyamanan dan daya tahan.</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="process-number rounded-circle bg-primary text-white me-3 d-flex align-items-center justify-content-center">2</div>
                        <div>
                            <h5>Desain</h5>
                            <p>Tim desainer kami menciptakan pola dan motif unik yang menjadi ciri khas Sokincek.</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="process-number rounded-circle bg-primary text-white me-3 d-flex align-items-center justify-content-center">3</div>
                        <div>
                            <h5>Produksi</h5>
                            <p>Menggunakan teknologi mesin modern dengan tetap mempertahankan ketelitian pengerjaan manual.</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="process-number rounded-circle bg-primary text-white me-3 d-flex align-items-center justify-content-center">4</div>
                        <div>
                            <h5>Kontrol Kualitas</h5>
                            <p>Setiap pasang kaos kaki diperiksa secara teliti sebelum sampai ke tangan pelanggan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title position-relative pb-3">Tim Kami</h2>
            <p class="lead">Orang-orang hebat di balik kesuksesan Sokincek</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 rounded-4 shadow-sm hover-lift overflow-hidden">
                    <div class="team-img-container">
                        <img src="<?= base_url('assets/images/abielweb.jpg') ?>" class="card-img-top team-img" alt="Team Member">
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title mb-1">Gianniva abiel</h5>
                        <p class="text-muted">Founder & CEO</p>
                        <div class="social-links mt-3">
                            <a href="#" class="social-link"><i class="bi bi-linkedin"></i></a>
                            <a href="#" class="social-link"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="social-link"><i class="bi bi-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 rounded-4 shadow-sm hover-lift overflow-hidden">
                    <div class="team-img-container">
                        <img src="<?= base_url('assets/images/fattah1.png') ?>" class="card-img-top team-img" alt="Team Member">
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title mb-1">Fattah</h5>
                        <p class="text-muted">Design Director</p>
                        <div class="social-links mt-3">
                            <a href="#" class="social-link"><i class="bi bi-linkedin"></i></a>
                            <a href="#" class="social-link"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="social-link"><i class="bi bi-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 rounded-4 shadow-sm hover-lift overflow-hidden">
                    <div class="team-img-container">
                        <img src="<?= base_url('assets/images/farhan2.jpg') ?>" class="card-img-top team-img" alt="Team Member">
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title mb-1">Farhan</h5>
                        <p class="text-muted">Production Manager</p>
                        <div class="social-links mt-3">
                            <a href="#" class="social-link"><i class="bi bi-linkedin"></i></a>
                            <a href="#" class="social-link"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="social-link"><i class="bi bi-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="cta-section py-5">
    <div class="container">
        <div class="row align-items-center rounded-4 bg-primary p-5 shadow">
            <div class="col-lg-8 text-center text-lg-start">
                <h2 class="text-white mb-3">Temukan Koleksi Kaos Kaki Premium Kami</h2>
                <p class="text-white-50 mb-4 mb-lg-0">Jelajahi berbagai pilihan desain unik dengan kualitas premium untuk gaya dan kenyamanan sehari-hari.</p>
            </div>
            <div class="col-lg-4 text-center text-lg-end">
                <a href="<?= base_url('products') ?>" class="btn btn-light btn-lg rounded-pill px-4 fw-bold">Belanja Sekarang</a>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
.about-hero {
    padding: 6rem 0;
    background: linear-gradient(135deg, #f8f9fc, #eaecf4);
    position: relative;
    overflow: hidden;
}

/* Hero Image */
.hero-image-container {
    max-height: 450px;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
}

.about-hero-img {
    max-height: 400px;
    width: auto;
    filter: drop-shadow(0 20px 30px rgba(0,0,0,0.15));
    transition: transform 0.5s ease;
    object-fit: contain;
}

.about-hero-img:hover {
    transform: scale(1.05) rotate(2deg);
}

/* Story Image */
.story-image-container {
    height: 400px;
    overflow: hidden;
    border-radius: 1rem;
}

.story-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Manufacturing Image */
.manufacturing-image-container {
    height: 400px;
    overflow: hidden;
    border-radius: 1rem;
}

.manufacturing-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Team Images */
.team-img-container {
    height: 300px;
    overflow: hidden;
}

.team-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.card:hover .team-img {
    transform: scale(1.05);
}

.section-title {
    position: relative;
    margin-bottom: 1.5rem;
    font-weight: 700;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 50px;
    height: 3px;
    background-color: var(--bs-primary);
}

.text-center .section-title::after {
    left: 50%;
    transform: translateX(-50%);
}

.experience-badge {
    bottom: -20px;
    right: 30px;
}

.value-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background-color: rgba(13, 110, 253, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.process-number {
    width: 40px;
    height: 40px;
    flex-shrink: 0;
    font-weight: bold;
}

.social-links {
    display: flex;
    justify-content: center;
    gap: 10px;
}

.social-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background-color: #f0f0f0;
    color: #333;
    text-decoration: none;
    transition: all 0.3s;
}

.social-link:hover {
    background-color: var(--bs-primary);
    color: #fff;
    transform: translateY(-3px);
}

.hover-lift {
    transition: all 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}

.cta-section {
    margin: 3rem 0;
}

@media (max-width: 768px) {
    .about-hero {
        padding: 3rem 0;
    }
    
    .hero-image-container,
    .story-image-container,
    .manufacturing-image-container,
    .team-img-container {
        height: auto;
        max-height: 300px;
    }
    
    .experience-badge {
        bottom: 10px;
        right: 10px;
        padding: 1.5rem !important;
    }
    
    .experience-badge h2 {
        font-size: 2.5rem;
    }
}
</style>
<?= $this->endSection() ?>
</body>
</html>