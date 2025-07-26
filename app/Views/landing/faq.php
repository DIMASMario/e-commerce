<?php
$this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- FAQ Hero Section -->
<section class="faq-hero py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold mb-4">Pertanyaan yang <span class="text-primary">Sering Ditanyakan</span></h1>
                <p class="lead mb-0">Temukan jawaban untuk pertanyaan umum seputar produk, pemesanan, pengiriman, dan hal lainnya.</p>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Content Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Search box -->
                <div class="mb-5">
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" id="faqSearch" placeholder="Cari pertanyaan...">
                    </div>
                </div>
                
                <!-- FAQ Categories -->
                <ul class="nav nav-pills mb-4 justify-content-center" id="faqTab" role="tablist">
                    <li class="nav-item mx-2" role="presentation">
                        <button class="nav-link active px-4 rounded-pill" id="general-tab" data-bs-toggle="pill" data-bs-target="#general" type="button" role="tab">Umum</button>
                    </li>
                    <li class="nav-item mx-2" role="presentation">
                        <button class="nav-link px-4 rounded-pill" id="product-tab" data-bs-toggle="pill" data-bs-target="#product" type="button" role="tab">Produk</button>
                    </li>
                    <li class="nav-item mx-2" role="presentation">
                        <button class="nav-link px-4 rounded-pill" id="order-tab" data-bs-toggle="pill" data-bs-target="#order" type="button" role="tab">Pemesanan</button>
                    </li>
                    <li class="nav-item mx-2" role="presentation">
                        <button class="nav-link px-4 rounded-pill" id="shipping-tab" data-bs-toggle="pill" data-bs-target="#shipping" type="button" role="tab">Pengiriman</button>
                    </li>
                    <li class="nav-item mx-2" role="presentation">
                        <button class="nav-link px-4 rounded-pill" id="return-tab" data-bs-toggle="pill" data-bs-target="#return" type="button" role="tab">Pengembalian</button>
                    </li>
                </ul>
                
                <!-- FAQ Content -->
                <div class="tab-content" id="faqTabContent">
                    <!-- General FAQ -->
                    <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                        <div class="accordion faq-accordion" id="generalAccordion">
                            <div class="accordion-item border-0 rounded-4 shadow-sm mb-3">
                                <h2 class="accordion-header" id="general1">
                                    <button class="accordion-button rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#generalCollapse1" aria-expanded="true">
                                        Apa itu Sokincek?
                                    </button>
                                </h2>
                                <div id="generalCollapse1" class="accordion-collapse collapse show" aria-labelledby="general1">
                                    <div class="accordion-body">
                                        <p>Sokincek adalah brand lokal yang menyediakan kaos kaki berkualitas premium dengan desain unik. Kami fokus pada kualitas bahan, kenyamanan, dan desain yang stylish untuk memenuhi kebutuhan fashion harian Anda.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border-0 rounded-4 shadow-sm mb-3">
                                <h2 class="accordion-header" id="general2">
                                    <button class="accordion-button collapsed rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#generalCollapse2">
                                        Bagaimana cara menghubungi customer service?
                                    </button>
                                </h2>
                                <div id="generalCollapse2" class="accordion-collapse collapse" aria-labelledby="general2">
                                    <div class="accordion-body">
                                        <p>Anda dapat menghubungi customer service kami melalui:</p>
                                        <ul>
                                            <li>Telepon: +62 856-4718-1562 (Senin-Jumat, 08.00-20.00 WIB)</li>
                                            <li>Email: novantoerilistianto@gmail.com</li>
                                            <li>Chat di website (jam operasional yang sama)</li>
                                            <li>Pesan melalui halaman Kontak Kami</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border-0 rounded-4 shadow-sm mb-3">
                                <h2 class="accordion-header" id="general3">
                                    <button class="accordion-button collapsed rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#generalCollapse3">
                                        Apakah Sokincek memiliki toko fisik?
                                    </button>
                                </h2>
                                <div id="generalCollapse3" class="accordion-collapse collapse" aria-labelledby="general3">
                                    <div class="accordion-body">
                                        <p>Ya, kami memiliki toko fisik yang berlokasi di Jalan Bibis No. 036, RT 03, Kembaran, Tamantirto, Kec. Kasihan, Kabupaten Bantul, Daerah Istimewa Yogyakarta. Anda bisa mengunjungi toko kami setiap hari dengan jam operasional:</p>
                                        <ul>
                                            <li>Senin - Jumat: 08:00 - 20:00 WIB</li>
                                            <li>Sabtu: 10:00 - 18:00 WIB</li>
                                            <li>Minggu: 10:00 - 16:00 WIB</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product FAQ -->
                    <div class="tab-pane fade" id="product" role="tabpanel" aria-labelledby="product-tab">
                        <div class="accordion faq-accordion" id="productAccordion">
                            <div class="accordion-item border-0 rounded-4 shadow-sm mb-3">
                                <h2 class="accordion-header" id="product1">
                                    <button class="accordion-button rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#productCollapse1" aria-expanded="true">
                                        Dari bahan apa kaos kaki Sokincek dibuat?
                                    </button>
                                </h2>
                                <div id="productCollapse1" class="accordion-collapse collapse show" aria-labelledby="product1">
                                    <div class="accordion-body">
                                        <p>Kaos kaki Sokincek dibuat dari bahan-bahan berkualitas tinggi seperti katun combed, polyester, spandex, dan microfiber yang dipilih untuk memastikan kenyamanan, daya tahan, dan kualitas terbaik. Komposisi bahan bervariasi tergantung pada jenis dan model kaos kaki.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border-0 rounded-4 shadow-sm mb-3">
                                <h2 class="accordion-header" id="product2">
                                    <button class="accordion-button collapsed rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#productCollapse2">
                                        Apa saja ukuran yang tersedia?
                                    </button>
                                </h2>
                                <div id="productCollapse2" class="accordion-collapse collapse" aria-labelledby="product2">
                                    <div class="accordion-body">
                                        <p>Kami menyediakan berbagai ukuran kaos kaki untuk memenuhi kebutuhan Anda:</p>
                                        <ul>
                                            <li>S (35-38): Untuk ukuran kaki kecil</li>
                                            <li>M (39-42): Untuk ukuran kaki sedang</li>
                                            <li>L (43-46): Untuk ukuran kaki besar</li>
                                        </ul>
                                        <p>Untuk ukuran khusus di luar range tersebut, silakan hubungi customer service kami.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border-0 rounded-4 shadow-sm mb-3">
                                <h2 class="accordion-header" id="product3">
                                    <button class="accordion-button collapsed rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#productCollapse3">
                                        Bagaimana cara merawat kaos kaki agar tahan lama?
                                    </button>
                                </h2>
                                <div id="productCollapse3" class="accordion-collapse collapse" aria-labelledby="product3">
                                    <div class="accordion-body">
                                        <p>Untuk menjaga kualitas dan memperpanjang umur kaos kaki Sokincek, kami menyarankan:</p>
                                        <ul>
                                            <li>Cuci dengan tangan menggunakan air dingin dan deterjen lembut</li>
                                            <li>Hindari penggunaan pemutih</li>
                                            <li>Jangan menggunakan pengering dengan suhu tinggi</li>
                                            <li>Jemur di tempat teduh untuk mencegah pudar</li>
                                            <li>Simpan di tempat kering dan bersih</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Order FAQ -->
                    <div class="tab-pane fade" id="order" role="tabpanel" aria-labelledby="order-tab">
                        <div class="accordion faq-accordion" id="orderAccordion">
                            <div class="accordion-item border-0 rounded-4 shadow-sm mb-3">
                                <h2 class="accordion-header" id="order1">
                                    <button class="accordion-button rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#orderCollapse1" aria-expanded="true">
                                        Bagaimana cara memesan produk Sokincek?
                                    </button>
                                </h2>
                                <div id="orderCollapse1" class="accordion-collapse collapse show" aria-labelledby="order1">
                                    <div class="accordion-body">
                                        <p>Anda dapat memesan produk Sokincek melalui beberapa cara:</p>
                                        <ol>
                                            <li>Website resmi kami: Pilih produk, masukkan ke keranjang, dan selesaikan pembayaran</li>
                                            <li>Toko online: Shopee (shopee.co.id/ncek.store)</li>
                                            <li>Toko fisik kami di Yogyakarta</li>
                                            <li>Hubungi customer service untuk pemesanan khusus</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border-0 rounded-4 shadow-sm mb-3">
                                <h2 class="accordion-header" id="order2">
                                    <button class="accordion-button collapsed rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#orderCollapse2">
                                        Metode pembayaran apa saja yang tersedia?
                                    </button>
                                </h2>
                                <div id="orderCollapse2" class="accordion-collapse collapse" aria-labelledby="order2">
                                    <div class="accordion-body">
                                        <p>Kami menerima berbagai metode pembayaran untuk kemudahan Anda:</p>
                                        <ul>
                                            <li>Transfer bank (BCA, BNI, Mandiri, BRI)</li>
                                            <li>E-wallet (GoPay, OVO, Dana, LinkAja)</li>
                                            <li>Kartu kredit/debit (Visa, Mastercard)</li>
                                            <li>COD (Cash On Delivery) untuk area tertentu</li>
                                            <li>Pembayaran melalui Shopee</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border-0 rounded-4 shadow-sm mb-3">
                                <h2 class="accordion-header" id="order3">
                                    <button class="accordion-button collapsed rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#orderCollapse3">
                                        Bagaimana cara mengecek status pesanan?
                                    </button>
                                </h2>
                                <div id="orderCollapse3" class="accordion-collapse collapse" aria-labelledby="order3">
                                    <div class="accordion-body">
                                        <p>Anda dapat mengecek status pesanan dengan beberapa cara:</p>
                                        <ol>
                                            <li>Login ke akun Anda di website kami dan lihat di bagian "Pesanan Saya"</li>
                                            <li>Cek email konfirmasi yang berisi informasi tracking</li>
                                            <li>Hubungi customer service kami dengan menyebutkan nomor pesanan</li>
                                            <li>Jika memesan melalui marketplace, cek status di platform tersebut</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Shipping FAQ -->
                    <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                        <div class="accordion faq-accordion" id="shippingAccordion">
                            <div class="accordion-item border-0 rounded-4 shadow-sm mb-3">
                                <h2 class="accordion-header" id="shipping1">
                                    <button class="accordion-button rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#shippingCollapse1" aria-expanded="true">
                                        Berapa lama waktu pengiriman?
                                    </button>
                                </h2>
                                <div id="shippingCollapse1" class="accordion-collapse collapse show" aria-labelledby="shipping1">
                                    <div class="accordion-body">
                                        <p>Waktu pengiriman bervariasi tergantung lokasi dan jasa ekspedisi yang dipilih:</p>
                                        <ul>
                                            <li>Jabodetabek: 1-2 hari kerja</li>
                                            <li>Pulau Jawa: 2-4 hari kerja</li>
                                            <li>Luar Jawa: 3-7 hari kerja</li>
                                            <li>Daerah terpencil: 7-14 hari kerja</li>
                                        </ul>
                                        <p>Pesanan akan diproses dalam 1x24 jam (hari kerja) setelah pembayaran dikonfirmasi.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border-0 rounded-4 shadow-sm mb-3">
                                <h2 class="accordion-header" id="shipping2">
                                    <button class="accordion-button collapsed rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#shippingCollapse2">
                                        Jasa pengiriman apa yang digunakan?
                                    </button>
                                </h2>
                                <div id="shippingCollapse2" class="accordion-collapse collapse" aria-labelledby="shipping2">
                                    <div class="accordion-body">
                                        <p>Kami bekerja sama dengan beberapa jasa ekspedisi terpercaya:</p>
                                        <ul>
                                            <li>JNE</li>
                                            <li>J&T Express</li>
                                            <li>SiCepat</li>
                                            <li>Pos Indonesia</li>
                                            <li>Anteraja</li>
                                        </ul>
                                        <p>Anda dapat memilih jasa ekspedisi yang Anda inginkan saat checkout.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border-0 rounded-4 shadow-sm mb-3">
                                <h2 class="accordion-header" id="shipping3">
                                    <button class="accordion-button collapsed rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#shippingCollapse3">
                                        Apakah Sokincek melayani pengiriman internasional?
                                    </button>
                                </h2>
                                <div id="shippingCollapse3" class="accordion-collapse collapse" aria-labelledby="shipping3">
                                    <div class="accordion-body">
                                        <p>Saat ini, Sokincek hanya melayani pengiriman ke seluruh wilayah Indonesia. Untuk pengiriman internasional, silakan hubungi customer service kami untuk informasi lebih lanjut dan penawaran khusus.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Return FAQ -->
                    <div class="tab-pane fade" id="return" role="tabpanel" aria-labelledby="return-tab">
                        <div class="accordion faq-accordion" id="returnAccordion">
                            <div class="accordion-item border-0 rounded-4 shadow-sm mb-3">
                                <h2 class="accordion-header" id="return1">
                                    <button class="accordion-button rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#returnCollapse1" aria-expanded="true">
                                        Bagaimana kebijakan pengembalian produk?
                                    </button>
                                </h2>
                                <div id="returnCollapse1" class="accordion-collapse collapse show" aria-labelledby="return1">
                                    <div class="accordion-body">
                                        <p>Kami menerima pengembalian produk dengan ketentuan:</p>
                                        <ul>
                                            <li>Pengembalian dilakukan dalam waktu 7 hari setelah produk diterima</li>
                                            <li>Produk belum digunakan, masih dalam kemasan asli, dan dengan label yang utuh</li>
                                            <li>Disertai bukti pembelian (invoice/nota)</li>
                                            <li>Cacat produksi atau kesalahan pengiriman produk</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border-0 rounded-4 shadow-sm mb-3">
                                <h2 class="accordion-header" id="return2">
                                    <button class="accordion-button collapsed rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#returnCollapse2">
                                        Bagaimana proses pengembalian dana?
                                    </button>
                                </h2>
                                <div id="returnCollapse2" class="accordion-collapse collapse" aria-labelledby="return2">
                                    <div class="accordion-body">
                                        <p>Setelah pengembalian produk disetujui, proses refund akan dilakukan dengan ketentuan:</p>
                                        <ul>
                                            <li>Refund ke metode pembayaran asal: 3-14 hari kerja tergantung bank/provider</li>
                                            <li>Pengembalian dana via transfer bank: 1-3 hari kerja</li>
                                            <li>Store credit: dapat digunakan langsung</li>
                                        </ul>
                                        <p>Biaya pengiriman untuk pengembalian produk ditanggung oleh pembeli, kecuali jika pengembalian disebabkan oleh kesalahan dari pihak kami.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border-0 rounded-4 shadow-sm mb-3">
                                <h2 class="accordion-header" id="return3">
                                    <button class="accordion-button collapsed rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#returnCollapse3">
                                        Bagaimana cara mengajukan pengembalian produk?
                                    </button>
                                </h2>
                                <div id="returnCollapse3" class="accordion-collapse collapse" aria-labelledby="return3">
                                    <div class="accordion-body">
                                        <p>Untuk mengajukan pengembalian produk, ikuti langkah-langkah berikut:</p>
                                        <ol>
                                            <li>Hubungi customer service kami melalui email atau telepon</li>
                                            <li>Sertakan nomor pesanan, detail produk, dan alasan pengembalian</li>
                                            <li>Lampirkan foto produk (jika ada cacat/kerusakan)</li>
                                            <li>Tim kami akan merespon dalam 1-2 hari kerja</li>
                                            <li>Jika disetujui, Anda akan mendapatkan petunjuk untuk mengirimkan produk kembali</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Still Have Questions -->
                <div class="card border-0 rounded-4 shadow-sm p-4 mt-5 text-center">
                    <div class="card-body">
                        <h3 class="mb-3">Masih punya pertanyaan?</h3>
                        <p class="mb-4">Jangan ragu untuk menghubungi tim customer service kami</p>
                        <a href="<?= base_url('contact') ?>" class="btn btn-primary rounded-pill px-4 py-2">Hubungi Kami</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
.faq-hero {
    padding: 5rem 0;
    background: linear-gradient(135deg, #f8f9fc, #eaecf4);
}

.nav-pills .nav-link {
    color: #6c757d;
    background-color: #f8f9fa;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.nav-pills .nav-link:hover {
    color: var(--bs-primary);
    background-color: rgba(13, 110, 253, 0.05);
}

.nav-pills .nav-link.active {
    color: #fff;
    background-color: var(--bs-primary);
}

.accordion-button:not(.collapsed) {
    color: var(--bs-primary);
    background-color: rgba(13, 110, 253, 0.05);
    box-shadow: none;
}

.accordion-button:focus {
    box-shadow: none;
    border-color: rgba(13, 110, 253, 0.1);
}
</style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('faqSearch');
    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        const allQuestions = document.querySelectorAll('.accordion-button');
        
        allQuestions.forEach(function(question) {
            const text = question.textContent.toLowerCase();
            const accordionItem = question.closest('.accordion-item');
            
            if (text.includes(query)) {
                accordionItem.style.display = '';
            } else {
                accordionItem.style.display = 'none';
            }
        });
    });
});
</script>
<?= $this->endSection() ?>