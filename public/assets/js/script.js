/**
 * Socksin - Main JavaScript File
 */

// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    
    // Activate tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Product image zoom effect
    const productMainImage = document.getElementById('product-main-image');
    if (productMainImage) {
        productMainImage.addEventListener('mousemove', function(e) {
            const { left, top, width, height } = e.target.getBoundingClientRect();
            const x = (e.clientX - left) / width * 100;
            const y = (e.clientY - top) / height * 100;
            
            // Set the zoom position
            this.style.transformOrigin = `${x}% ${y}%`;
        });
        
        productMainImage.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.5)';
        });
        
        productMainImage.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    }

    // Product gallery thumbnail click
    const galleryThumbnails = document.querySelectorAll('.product-thumbnail');
    if (galleryThumbnails.length > 0) {
        galleryThumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                // Remove active class from all thumbnails
                document.querySelectorAll('.product-thumbnail').forEach(t => {
                    t.classList.remove('active');
                });
                
                // Add active class to clicked thumbnail
                this.classList.add('active');
                
                // Update main image
                const mainImage = document.getElementById('product-main-image');
                mainImage.src = this.dataset.image;
                mainImage.parentElement.href = this.dataset.image;
            });
        });
    }

    // Quantity increment/decrement buttons in product detail
    const quantityInput = document.getElementById('quantity');
    if (quantityInput) {
        document.querySelector('.quantity-increment').addEventListener('click', function() {
            let value = parseInt(quantityInput.value);
            const max = parseInt(quantityInput.getAttribute('max')) || 100;
            
            if (value < max) {
                quantityInput.value = value + 1;
            }
        });
        
        document.querySelector('.quantity-decrement').addEventListener('click', function() {
            let value = parseInt(quantityInput.value);
            const min = parseInt(quantityInput.getAttribute('min')) || 1;
            
            if (value > min) {
                quantityInput.value = value - 1;
            }
        });
    }

    // Cart quantity buttons
    function updateCartQuantity(inputId, increment) {
        const input = document.getElementById(inputId);
        if (!input) return;
        
        let value = parseInt(input.value);
        const min = parseInt(input.getAttribute('min')) || 1;
        const max = parseInt(input.getAttribute('max')) || 100;
        
        if (increment && value < max) {
            input.value = value + 1;
        } else if (!increment && value > min) {
            input.value = value - 1;
        }
    }
    
    window.incrementQuantity = function(inputId) {
        updateCartQuantity(inputId, true);
    }
    
    window.decrementQuantity = function(inputId) {
        updateCartQuantity(inputId, false);
    }

    // Image preview for file uploads
    const fileInputs = document.querySelectorAll('input[type="file"][data-preview]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const previewId = this.dataset.preview;
            const preview = document.getElementById(previewId);
            
            if (this.files && this.files[0] && preview) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.parentElement.classList.remove('d-none');
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
    });

    // Password visibility toggle
    const togglePasswordButtons = document.querySelectorAll('.toggle-password');
    togglePasswordButtons.forEach(button => {
        button.addEventListener('click', function() {
            const passwordInput = this.previousElementSibling;
            const icon = this.querySelector('i');
            
            // Toggle password visibility
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    });

    // Back to top button
    const backToTopButton = document.getElementById('back-to-top');
    if (backToTopButton) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add('show');
            } else {
                backToTopButton.classList.remove('show');
            }
        });
        
        backToTopButton.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({top: 0, behavior: 'smooth'});
        });
    }

    // Auto hide alerts after 5 seconds
    const autoHideAlerts = document.querySelectorAll('.alert-dismissible.auto-hide');
    autoHideAlerts.forEach(alert => {
        setTimeout(() => {
            const closeButton = alert.querySelector('.btn-close');
            if (closeButton) {
                closeButton.click();
            }
        }, 5000);
    });
    
    // Form validation for checkout
    const checkoutForm = document.getElementById('checkoutForm');
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let hasError = false;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    hasError = true;
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            if (hasError) {
                e.preventDefault();
                alert('Silakan lengkapi semua field yang diperlukan');
            }
        });
    }
});

// Add to cart animation
function addToCartAnimation(button) {
    button.disabled = true;
    
    // Add spinner
    const originalText = button.innerHTML;
    button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menambahkan...';
    
    setTimeout(() => {
        button.innerHTML = '<i class="bi bi-check-lg"></i> Berhasil Ditambahkan';
        button.classList.remove('btn-primary');
        button.classList.add('btn-success');
        
        setTimeout(() => {
            button.innerHTML = originalText;
            button.classList.remove('btn-success');
            button.classList.add('btn-primary');
            button.disabled = false;
        }, 1500);
    }, 800);
}

// Wishlist toggle animation
function toggleWishlist(button, isAdd) {
    button.disabled = true;
    
    if (isAdd) {
        // Adding to wishlist
        setTimeout(() => {
            button.innerHTML = '<i class="bi bi-heart-fill"></i> Ditambahkan ke Wishlist';
            button.classList.remove('btn-outline-danger');
            button.classList.add('btn-danger');
        }, 300);
    } else {
        // Removing from wishlist
        setTimeout(() => {
            button.innerHTML = '<i class="bi bi-heart"></i> Dihapus dari Wishlist';
            button.classList.remove('btn-danger');
            button.classList.add('btn-outline-danger');
        }, 300);
    }
}