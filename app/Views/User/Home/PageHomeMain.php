<style>
@media screen and (max-width: 453px) {
    .AdmissionFooter a {
        font-size: 1rem;
        padding: 10px;
        margin-top: -21px;
        margin-bottom: 20px;
    }
}

@media screen and (min-width: 768px) {
    .AdmissionFooter a {
        font-size: 2rem;
        padding: 10px;
        margin-top: -30px;
        margin-bottom: 30px;
    }
}

.overlay-bottom::after {
    bottom: 0;
    background: url(uploads/background/overlay-bottom.png) bottom center no-repeat;
    background-size: contain;
}

.overlay-bottom::after,
.overlay-top::before {
    position: absolute;
    content: "";
    width: 100%;
    height: 85px;
    left: 0;
    z-index: 1;
}
</style>

<!-- <img class="img-fluid" data-src="<?=base_url('uploads/banner/backtoschool.png')?>" alt="" srcset=""> -->

<!-- Carousel Start -->
<?= $this->include('User/Home/PageHomeCarousel') ?>
<!-- Carousel End -->


<!-- Excellence Start -->
<?= $this->include('User/Home/PageHomeRecommend')?>
<!-- Excellence End -->

<!-- Welcome To Start -->
<?= $this->include('User/Home/PageHomeWelcome')?>
<!-- Welcome To End -->

<!-- Spotlight Feature Start -->
<?= $this->include('User/Home/PageHomeSpotlight') ?>
<!-- Spotlight Feature End -->
 
<!-- Facts Start -->
<?= $this->include('User/Home/PageHomeCounter')?>
<!-- Facts End -->

<!-- News Start -->
<?= $this->include('User/Home/PageHomeNews') ?>
<!-- News End -->


<style>
    .management-section {
        background-color: #ffffff;
        background-image: 
            url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Cg fill='%23249ffd' fill-opacity='0.03'%3E%3Cpath d='M0 0h40v40H0V0zm40 40h40v40H40V40zm0-40h20v20H40V0zM0 40h20v20H0V40zm20 0h20v20H20V40zm0-20h20v20H20V20z'/%3E%3C/g%3E%3C/svg%3E"),
            radial-gradient(at 0% 0%, rgba(36, 159, 253, 0.08) 0px, transparent 50%),
            radial-gradient(at 100% 100%, rgba(251, 126, 156, 0.08) 0px, transparent 50%);
        padding: 120px 0;
        position: relative;
        overflow: hidden;
    }

    /* LUXURIOUS SVG OVERLAYS */
    .mgmt-svg-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 0;
        opacity: 0.5;
    }

    /* Floating Abstract SVG Shapes */
    .mgmt-shape {
        position: absolute;
        z-index: 0;
        opacity: 0.15;
        animation: shape-float 20s infinite linear;
    }

    @keyframes shape-float {
        0% { transform: translate(0, 0) rotate(0deg); }
        33% { transform: translate(30px, 50px) rotate(120deg); }
        66% { transform: translate(-20px, 20px) rotate(240deg); }
        100% { transform: translate(0, 0) rotate(360deg); }
    }

    /* Multi-dimensional blobs refined */
    .mgmt-blob {
        position: absolute;
        border-radius: 50%;
        filter: blur(100px);
        z-index: 0;
        opacity: 0.5;
    }
    .blob-1 { width: 400px; height: 400px; background: rgba(251, 126, 156, 0.15); top: -100px; left: -100px; }
    .blob-2 { width: 500px; height: 500px; background: rgba(36, 159, 253, 0.15); bottom: -150px; right: -150px; }
    .blob-3 { width: 300px; height: 300px; background: rgba(251, 126, 156, 0.08); top: 20%; right: 10%; }

    .manager-card {
        background: transparent; /* Minimalist: No background */
        border: none;
        padding: 0;
        box-shadow: none;
        transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
        position: relative;
        z-index: 1;
        text-align: center;
    }

    .manager-card.prominent {
        transform: scale(1.15);
        z-index: 10;
        filter: drop-shadow(0 20px 40px rgba(0,0,0,0.1));
    }

    .manager-card.leader-secondary {
        filter: drop-shadow(0 15px 30px rgba(0,0,0,0.05));
    }

    .manager-card:hover {
        transform: translateY(-20px) scale(prominent ? 1.18 : 1.05); /* Conditional logic handled by CSS classes */
    }
    
    .manager-card.prominent:hover { transform: translateY(-20px) scale(1.18); }
    .manager-card.leader-secondary:hover { transform: translateY(-15px) scale(1.05); }

    .manager-img-wrapper {
        border-radius: 0; /* Fully transparent PNG look */
        overflow: visible;
        margin-bottom: 0;
        position: relative;
    }

    .manager-img-wrapper img {
        width: 100%;
        height: auto;
        transition: all 0.6s ease;
    }

    .manager-card:hover .manager-img-wrapper img {
        /* Subtle glow on hover */
        filter: brightness(1.05);
    }

    .manager-card.leader-secondary:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 50px rgba(36, 159, 253, 0.12);
    }

    .manager-img-wrapper {
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 0;
        position: relative;
    }

    .manager-img-wrapper img {
        width: 100%;
        height: auto;
        transition: transform 0.6s ease;
    }

    .manager-card:hover .manager-img-wrapper img {
        transform: scale(1.05);
    }

    .manager-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        padding: 5px 15px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .leader-primary .manager-badge { color: var(--primary); border: 1px solid rgba(251, 126, 156, 0.2); }
    .leader-secondary .manager-badge { color: var(--secondary); border: 1px solid rgba(36, 159, 253, 0.2); }

    .eis-button {
        background: var(--secondary);
        color: #fff;
        border: none;
        padding: 15px 40px;
        border-radius: 50px;
        font-weight: 700;
        box-shadow: 0 10px 20px rgba(36, 159, 253, 0.3);
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .eis-button:hover {
        background: var(--primary);
        color: #fff;
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(251, 126, 156, 0.4);
    }

    @media (max-width: 991px) {
        .management-section { padding: 60px 0; }
        .manager-card { margin-bottom: 20px !important; }
        .manager-card.prominent {
            transform: scale(1.0); /* Remove scaling for flat balance on mobile */
            max-width: 240px; /* Balance with col-6 items below */
            margin-left: auto;
            margin-right: auto;
        }
    }
</style>

<section class="management-section">
    <!-- Luxurious SVG Background Overlays -->
    <div class="mgmt-svg-bg">
        <svg width="100%" height="100%" viewBox="0 0 1000 1000" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0,1000 C300,800 400,950 700,800 C900,700 1000,750 1000,750 L1000,1000 L0,1000 Z" fill="rgba(36, 159, 253, 0.03)"></path>
            <path d="M0,1000 C200,900 300,980 500,900 C700,820 800,880 1000,800 L1000,1000 L0,1000 Z" fill="rgba(251, 126, 156, 0.03)"></path>
        </svg>
    </div>

    <!-- Floating SVG Ornaments -->
    <div class="mgmt-shape shape-1" style="top: 15%; left: 5%;">
        <svg width="120" height="120" viewBox="0 0 100 100">
            <circle cx="50" cy="50" r="40" stroke="var(--primary)" stroke-width="0.3" fill="none" />
            <circle cx="50" cy="50" r="30" stroke="var(--primary)" stroke-width="1.5" fill="none" stroke-dasharray="5 5" />
        </svg>
    </div>
    <div class="mgmt-shape shape-2" style="bottom: 15%; right: 5%;">
        <svg width="150" height="150" viewBox="0 0 100 100">
            <rect x="20" y="20" width="60" height="60" rx="10" stroke="var(--secondary)" stroke-width="0.3" fill="none" transform="rotate(45 50 50)" />
            <rect x="30" y="30" width="40" height="40" rx="8" stroke="var(--secondary)" stroke-width="1" fill="none" transform="rotate(45 50 50)" stroke-dasharray="10 5" />
        </svg>
    </div>

    <!-- Decorative Dimension Blobs -->
    <div class="mgmt-blob blob-1"></div>
    <div class="mgmt-blob blob-2"></div>
    <div class="mgmt-blob blob-3"></div>

    <div class="container">
        <!-- Section Header -->
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 700px; position: relative; z-index: 1;">
            <span class="section-subtitle">SKJ Management</span>
            <h1 class="display-5 mb-4" style="font-weight: 800; color: #1a2a4d;">ผู้บริหารสถานศึกษา</h1>
            <div class="mx-auto" style="width: 100px; height: 5px; background: linear-gradient(to right, var(--primary), var(--secondary)); border-radius: 5px;"></div>
        </div>

        <!-- Single Row Hierarchy -->
        <div class="row g-2 g-md-4 align-items-end justify-content-center" style="position: relative; z-index: 1;">
            <!-- Leader (First & Most Prominent) -->
            <div class="col-lg-4 col-md-6 col-12 order-lg-1 wow fadeInUp" data-wow-delay="0.2s">
                <div class="manager-card prominent">
                    <div class="manager-img-wrapper">
                        <img src="<?=base_url();?>/uploads/director/nayk.png" alt="Director" loading="lazy">
                    </div>
                </div>
            </div>
            
            <!-- Deputy 1 -->
            <div class="col-lg-3 col-md-6 col-6 order-lg-2 wow fadeInUp" data-wow-delay="0.3s">
                <div class="manager-card leader-secondary">
                    <div class="manager-img-wrapper">
                        <img src="<?=base_url();?>/uploads/director/pa-a.png" alt="Deputy Director 1" loading="lazy">
                    </div>
                </div>
            </div>

            <!-- Deputy 2 -->
            <div class="col-lg-3 col-md-6 col-6 order-lg-3 wow fadeInUp" data-wow-delay="0.4s">
                <div class="manager-card leader-secondary">
                    <div class="manager-img-wrapper">
                        <img src="<?=base_url();?>/uploads/director/pa.png" alt="Deputy Director 2" loading="lazy">
                    </div>
                </div>
            </div>
        </div>

        <!-- EIS Link (Hidden as in previous state) -->
        <!-- <div class="text-center mt-5 wow fadeInUp" data-wow-delay="0.5s">
            <a href="<?= base_url('Manager/Dashboard') ?>" class="eis-button">
                <i class="bi bi-shield-lock-fill"></i> เข้าสู่ระบบ EIS
            </a>
        </div> -->
    </div>
</section>



<!-- NewsReward Start -->
<?= $this->include('User/Home/PageHomeNewsReward') ?>
<!-- NewsReward End -->




<?= $this->include('User/Home/PageGroupSKJ') ?>

<!-- Slogan Start -->
<?= $this->include('User/Home/PageHomeSlogan') ?>
<!-- Slogan End -->

<!-- SKJstdio Start -->
<?= $this->include('User/Home/PageHomeSKJstdio') ?>
<!-- SKJstdio End -->


<!-- Welcome Modal -->
<?php if (isset($welcome_modal_status) && $welcome_modal_status == 'on' && !empty($welcome_modal_images) && is_array($welcome_modal_images)): ?>
<div class="modal fade" id="welcomeModal" tabindex="-1" aria-labelledby="welcomeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 bg-transparent position-relative">
            <div class="modal-body text-center p-0 overflow-hidden rounded-3 shadow-lg" style="background-color: transparent;">
                <?php if (count($welcome_modal_images) == 1): ?>
                    <img src="<?php echo base_url('uploads/welcome/' . $welcome_modal_images[0]); ?>" class="img-fluid rounded-3" alt="ประกาศ">
                <?php else: ?>
                    <div id="welcomeCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3500">
                        <!-- Indicators -->
                        <div class="carousel-indicators">
                             <?php foreach ($welcome_modal_images as $index => $img): ?>
                                 <button type="button" data-bs-target="#welcomeCarousel" data-bs-slide-to="<?= $index ?>" class="<?= $index === 0 ? 'active' : '' ?>" aria-current="<?= $index === 0 ? 'true' : 'false' ?>"></button>
                             <?php endforeach; ?>
                        </div>
                        
                        <!-- Slides -->
                        <div class="carousel-inner rounded-3">
                            <?php foreach ($welcome_modal_images as $index => $img): ?>
                                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                    <img src="<?php echo base_url('uploads/welcome/' . $img); ?>" class="d-block w-100 img-fluid" alt="ประกาศ <?= $index + 1 ?>">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <!-- Controls -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#welcomeCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#welcomeCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                <?php endif; ?>
            </div>
            <!-- Close Button Overlay -->
            <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close" style="z-index: 1055; filter: drop-shadow(0px 2px 5px rgba(0,0,0,0.5));"></button>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var welcomeModalEl = document.getElementById('welcomeModal');
        if (welcomeModalEl) {
            // ตรวจสอบว่าในวันนี้เคยแสดงป๊อปอัปไปแล้วหรือยัง
            var today = new Date().toDateString(); // ดึงวันที่ปัจจุบัน (เช่น "Sun Jun 14 2026")
            var lastShown = localStorage.getItem('welcome_modal_last_shown');
            
            if (lastShown !== today) {
                var welcomeModal = new bootstrap.Modal(welcomeModalEl, {
                    keyboard: false
                });
                welcomeModal.show();
                
                // บันทึกสถานะว่าแสดงในวันนี้แล้ว
                localStorage.setItem('welcome_modal_last_shown', today);
            }
        }
    });
</script>
<?php endif; ?>