<style>
    .hero-carousel-wrapper {
        padding: 40px 0;
        background: #fff;
        overflow: hidden;
    }

    /* Slick Slider Custom Styles */
    .main-slider .slider-item {
        padding: 0 5px;
        transition: all 0.5s ease;
        opacity: 0.5;
        transform: scale(0.95);
        outline: none;
    }

    .main-slider .slick-center.slider-item {
        opacity: 1;
        transform: scale(1);
    }

    .slider-img-container {
        border-radius: 30px;
        overflow: hidden;
        box-shadow: 0 15px 40px rgba(0,0,0,0.1);
        background: #f8f9fa;
    }

    #main-banner-slick img {
        width: 100%;
        display: block;
        height: auto;
    }

    /* --- Desktop View (Default) --- */
    @media screen and (min-width: 768px) {
        #main-banner-slick img {
            aspect-ratio: 21 / 9; /* ปรับเป็น 21:9 ตามที่คุณต้องการ */
            object-fit: cover;
            /* max-height: 550px; จำกัดความสูงไว้ที่ 450px เพื่อความลงตัว */
        }
    }

    /* --- Tablet / iPad View (768px to 1199px) --- */
    @media screen and (min-width: 768px) and (max-width: 1199px) {
        .hero-carousel-wrapper {
            padding: 110px 0 30px;
        }
    }

    /* --- Smartphone View --- */
    @media screen and (max-width: 767px) {
        .hero-carousel-wrapper {
            padding: 90px 0 20px;
        }
        .slider-img-container {
            border-radius: 15px;
            margin: 0 5px;
        }
        #main-banner-slick img {
            aspect-ratio: 9 / 16;
            object-fit: cover;
            max-height: 80vh;
        }
        /* Fallback if no mobile image is provided */
        .slider-img-container.no-mobile-img img {
            aspect-ratio: 21 / 9;
            object-fit: contain;
            background: #000; /* Black bars for horizontal image in vertical space if needed */
        }
        /* Hide dots and arrows on very small screens for cleaner look */
        #main-banner-slick .slick-dots { bottom: -30px; }
        #main-banner-slick .slick-prev, #main-banner-slick .slick-next { display: none !important; }
    }

    /* Slick Arrows & Dots Styling */
    #main-banner-slick .slick-prev, #main-banner-slick .slick-next {
        width: 45px;
        height: 45px;
        background: rgba(255, 255, 255, 0.8) !important;
        border-radius: 50%;
        z-index: 10;
    }
    #main-banner-slick .slick-prev { left: 50px; }
    #main-banner-slick .slick-next { right: 50px; }
    #main-banner-slick .slick-prev:before, #main-banner-slick .slick-next:before {
        font-family: 'bootstrap-icons';
        color: #000;
        font-size: 20px;
    }
    #main-banner-slick .slick-prev:before { content: "\f12c"; }
    #main-banner-slick .slick-next:before { content: "\f135"; }
</style>

<section class="hero-carousel-wrapper">
    <div class="container-fluid px-0">
        <div id="main-banner-slick" class="main-slider">
            <?php foreach ($banner as $key => $v_banner): ?>
            <div class="slider-item">
                <?php if($v_banner['banner_linkweb'] != ""): ?>
                <a href="<?=$v_banner['banner_linkweb']?>" target="_blank">
                <?php endif; ?>
                    <div class="slider-img-container <?= empty($v_banner['banner_img_mobile']) ? 'no-mobile-img' : '' ?>">
                        <picture>
                            <?php if(!empty($v_banner['banner_img_mobile'])): ?>
                                <!-- Smartphone Version (767px and below) -->
                                <source media="(max-width: 767px)" 
                                        srcset="<?=base_url('uploads/banner/all/' . $v_banner['banner_img_mobile'])?>">
                            <?php endif; ?>
                            
                            <!-- Desktop & Tablet Version (Above 767px) -->
                            <img src="<?=base_url('uploads/banner/all/' . $v_banner['banner_img'])?>"
                                alt="Banner Image" 
                                class="w-100"
                                <?= $key === 0 ? 'fetchpriority="high"' : 'loading="lazy"' ?>
                                onerror="this.onerror=null;this.src='https://placehold.co/1920x822/fb7e9c/white?text=SKJ+Banner';">
                        </picture>
                    </div>
                <?php if($v_banner['banner_linkweb'] != ""): ?>
                </a>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
