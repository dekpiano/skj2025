<style>
    #header-carousel {
        position: relative;
    }

    #header-carousel .carousel-item {
        height: 700px;
        min-height: 400px;
    }

    #header-carousel .carousel-item img {
        height: 100%;
        object-fit: cover;
    }

    /* Floating Info Boxes */
    .hero-info-wrapper {
        margin-top: -100px;
        position: relative;
        z-index: 20;
    }

    .hero-info-card {
        background: #fff;
        padding: 40px;
        border-radius: 24px;
        box-shadow: 0 15px 45px rgba(0,0,0,0.1);
        height: 100%;
        transition: all 0.4s ease;
        border-bottom: 5px solid transparent;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .hero-info-card.color-1 { border-bottom-color: var(--primary); }
    .hero-info-card.color-2 { border-bottom-color: var(--secondary); }
    .hero-info-card.color-3 { border-bottom-color: var(--primary); }
    .hero-info-card.color-4 { border-bottom-color: var(--secondary); }
    .hero-info-card.color-5 { border-bottom-color: var(--primary); }

    .hero-info-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 60px rgba(0,0,0,0.15);
    }

    .hero-info-icon {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        margin-bottom: 25px;
        transition: all 0.4s ease;
    }

    .color-1 .hero-info-icon { background: rgba(251, 126, 156, 0.1); color: var(--primary); }
    .color-2 .hero-info-icon { background: rgba(36, 159, 253, 0.1); color: var(--secondary); }
    .color-3 .hero-info-icon { background: rgba(251, 126, 156, 0.1); color: var(--primary); }
    .color-4 .hero-info-icon { background: rgba(36, 159, 253, 0.1); color: var(--secondary); }
    .color-5 .hero-info-icon { background: rgba(251, 126, 156, 0.1); color: var(--primary); }

    .hero-info-card:hover .hero-info-icon {
        transform: rotateY(180deg);
    }

    .hero-info-card h4 {
        font-weight: 800;
        margin-bottom: 15px;
        color: #1a2a4d;
    }

    .hero-info-card p {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 0;
    }

    @media screen and (max-width: 991px) {
        #header-carousel .carousel-item {
            height: 400px;
        }
        .hero-info-wrapper {
            margin-top: -50px;
            padding: 0 15px;
        }
        .hero-info-card {
            padding: 25px;
            margin-bottom: 20px;
        }
    }

    @media screen and (max-width: 768px) {
        #header-carousel .carousel-item {
            height: 250px;
        }
    }
</style>

<div class="wow fadeIn" data-wow-delay="0.1s">
    <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php foreach ($banner as $key => $v_banner): 
                    if($v_banner['banner_linkweb'] == ""):
            ?>
            <div class="carousel-item <?=$key==0?'active':''?>">
                <img class="w-100" src="<?=base_url()?>/uploads/banner/all/<?php echo $v_banner['banner_img'];?>"
                    alt="Image" loading="lazy">
            </div>
            <?php else: ?>
            <a href="<?=$v_banner['banner_linkweb']?>" target="_blank">
                <div class="carousel-item <?=$key==0?'active':''?>">
                    <img class="w-100" src="<?=base_url()?>/uploads/banner/all/<?php echo $v_banner['banner_img'];?>"
                        alt="Image" loading="lazy">
                </div>
            </a>
            <?php endif; endforeach; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<style>
    /* ... previous styles ... */
    @media (min-width: 1200px) {
        .col-custom-5 {
            flex: 0 0 20%;
            max-width: 20%;
        }
    }
</style>

<!-- Floating Features Section -->
<div class="container-fluid px-md-5 px-2 hero-info-wrapper">
    <div class="row g-2 justify-content-center">
        <div class="col-custom-5 col-lg-4 col-md-6 col-4 wow fadeInUp" data-wow-delay="0.1s">
            <div class="hero-info-card color-1 p-2">
                <div class="hero-info-icon mb-2" style="width: 50px; height: 50px; font-size: 1.5rem;">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <h6 class="fw-bold mb-0" style="font-size: 0.85rem;">วิชาการเข้ม</h6>
                <p class="d-none d-sm-block mt-2">หลักสูตรทันสมัย เน้นความเป็นเลิศ สู่มหาวิทยาลัยชั้นนำ</p>
            </div>
        </div>
        <div class="col-custom-5 col-lg-4 col-md-6 col-4 wow fadeInUp" data-wow-delay="0.2s">
            <div class="hero-info-card color-2 p-2">
                <div class="hero-info-icon mb-2" style="width: 50px; height: 50px; font-size: 1.5rem;">
                    <i class="bi bi-trophy-fill"></i>
                </div>
                <h6 class="fw-bold mb-0" style="font-size: 0.85rem;">กีฬาเด่น</h6>
                <p class="d-none d-sm-block mt-2">พัฒนาศักยภาพสู่มืออาชีพ พร้อมส่งเสริมทุกประเภทกีฬา</p>
            </div>
        </div>
        <div class="col-custom-5 col-lg-4 col-md-6 col-4 wow fadeInUp" data-wow-delay="0.3s">
            <div class="hero-info-card color-3 p-2">
                <div class="hero-info-icon mb-2" style="width: 50px; height: 50px; font-size: 1.5rem;">
                    <i class="bi bi-palette-fill"></i>
                </div>
                <h6 class="fw-bold mb-0" style="font-size: 0.85rem;">ศิลป์เด่น</h6>
                <p class="d-none d-sm-block mt-2">สร้างสรรค์จินตนาการ ครบวงจรทั้งดนตรีและนาฏศิลป์</p>
            </div>
        </div>
        <div class="col-custom-5 col-lg-4 col-md-6 col-4 wow fadeInUp" data-wow-delay="0.4s">
            <div class="hero-info-card color-4 p-2">
                <div class="hero-info-icon mb-2" style="width: 50px; height: 50px; font-size: 1.5rem;">
                    <i class="bi bi-tools"></i>
                </div>
                <h6 class="fw-bold mb-0" style="font-size: 0.85rem;">ทักษะอาชีพ</h6>
                <p class="d-none d-sm-block mt-2">ฝึกปฎิบัติจริง สร้างรายได้ และพื้นฐานอาชีพที่มั่นคง</p>
            </div>
        </div>
        <div class="col-custom-5 col-lg-4 col-md-6 col-4 wow fadeInUp" data-wow-delay="0.5s">
            <div class="hero-info-card color-5 p-2">
                <div class="hero-info-icon mb-2" style="width: 50px; height: 50px; font-size: 1.5rem;">
                    <i class="bi bi-translate"></i>
                </div>
                <h6 class="fw-bold mb-0" style="font-size: 0.85rem;">ภาษาเลิศ</h6>
                <p class="d-none d-sm-block mt-2">สื่อสารคล่องแคล่ว ทั้งอังกฤษ-จีน ก้าวสู่ระดับสากล</p>
            </div>
        </div>
    </div>
</div>

