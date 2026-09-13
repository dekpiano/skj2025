<style>
    /* ปรับความกว้าง Carousel ให้เท่ากับแถบ Navbar (.header-upper) ด้านบนเป๊ะทุกอุปกรณ์ */
    .hero-carousel-wrapper {
        padding: 0 25px 35px 25px; /* ซ้าย-ขวา 25px เท่ากับ margin ของ Navbar บน Desktop */
        background: transparent;
        overflow: hidden;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    /* Slick Slider Custom Styles */
    .main-slider .slider-item {
        padding: 0 !important; /* ปลด padding ขอบสไลด์ออก เพื่อให้กว้างแนบสนิทเท่า Navbar */
        outline: none;
        transition: opacity 0.4s ease;
    }

    .slider-img-container {
        border-radius: 20px; /* ขอบมน 20px เท่ากับขอบของ Navbar บน Desktop */
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(36, 159, 253, 0.18);
        background: #f8f9fa;
        width: 100%;
    }

    #main-banner-slick img {
        width: 100%;
        display: block;
        height: auto;
    }

    /* --- Desktop View (Default) --- */
    @media screen and (min-width: 768px) {
        #main-banner-slick img {
            aspect-ratio: 21 / 9; /* ปรับเป็น 21:9 */
            object-fit: cover;
        }
    }

    /* --- Tablet / iPad View (768px to 1199px) --- */
    @media screen and (min-width: 768px) and (max-width: 1199px) {
        .hero-carousel-wrapper {
            padding: 0 15px 30px 15px; /* เท่ากับ margin: 10px 15px ของ Navbar บน iPad/Tablet */
        }
        .slider-img-container {
            border-radius: 20px;
        }
    }

    /* ป้องกันการกระตุกหรือขยายล้นจอก่อนที่ Slick Slider จะถูกเรียกทำงาน (Prevent FOUC / Layout Shift) */
    #main-banner-slick:not(.slick-initialized) {
        display: flex;
        overflow: hidden;
        width: 100%;
        max-width: 100%;
    }
    #main-banner-slick:not(.slick-initialized) .slider-item:not(:first-child) {
        display: none;
    }
    #main-banner-slick:not(.slick-initialized) .slider-item {
        width: 100%;
        flex: 0 0 100%;
    }

    /* --- Smartphone View (สัดส่วน 9:16 ตามความต้องการ) --- */
    @media screen and (max-width: 767px) {
        .hero-carousel-wrapper {
            padding: 0 12px 25px 12px; /* เท่ากับ margin: 8px 12px ของ Navbar บนสมาร์ตโฟน */
            overflow: hidden;
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
        }
        .main-slider .slider-item {
            padding: 0 !important;
            transform: none !important;
            opacity: 1 !important;
        }
        .slider-img-container {
            border-radius: 16px; /* ขอบมน 16px เท่ากับ Navbar บนมือถือ */
            margin: 0;
            box-shadow: 0 8px 22px rgba(0,0,0,0.1);
            overflow: hidden;
            width: 100%;
            background: #f1f5f9;
        }
        /* กำหนดสัดส่วนภาพแบนเนอร์บนสมาร์ตโฟนเป็น 9:16 แน่นอน */
        #main-banner-slick img,
        #main-banner-slick .slider-img-container img {
            aspect-ratio: 9 / 16 !important;
            object-fit: cover !important;
            width: 100% !important;
            height: auto !important;
            display: block !important;
        }
        /* Slick dots on mobile */
        #main-banner-slick .slick-dots { 
            bottom: -20px; 
        }
        #main-banner-slick .slick-prev, #main-banner-slick .slick-next { 
            display: none !important; 
        }
    }

    /* Slick Arrows & Dots Styling */
    #main-banner-slick .slick-prev, #main-banner-slick .slick-next {
        width: 44px;
        height: 44px;
        background: rgba(255, 255, 255, 0.88) !important;
        border-radius: 50%;
        z-index: 10;
        box-shadow: 0 4px 15px rgba(0,0,0,0.18);
        backdrop-filter: blur(6px);
        transition: all 0.25s ease;
    }
    #main-banner-slick .slick-prev:hover, #main-banner-slick .slick-next:hover {
        background: #ffffff !important;
        transform: scale(1.08);
    }
    #main-banner-slick .slick-prev { left: 20px; }
    #main-banner-slick .slick-next { right: 20px; }
    #main-banner-slick .slick-prev:before, #main-banner-slick .slick-next:before {
        font-family: 'bootstrap-icons';
        color: #1e293b;
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
                    <div class="slider-img-container <?= !empty($v_banner['banner_img_mobile']) ? 'has-mobile-img' : 'no-mobile-img' ?>">
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
