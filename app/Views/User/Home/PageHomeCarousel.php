<style>
    .hero-carousel-wrapper {
        padding: 40px 0;
        background: #fff;
        overflow: hidden;
    }

    /* Peek-a-boo Slider Effect */
    .main-slider .slider-item {
        padding: 0 5px; /* Narrower Gap */
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        opacity: 0.4;
        transform: scale(0.96); /* Larger side images */
        outline: none;
    }

    .main-slider .slick-center.slider-item {
        opacity: 1;
        transform: scale(1);
    }

    .slider-img-container {
        border-radius: 40px;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(0,0,0,0.08);
        border: 1px solid rgba(0,0,0,0.02);
    }

    #main-banner-slick img {
        width: 100%;
        height: auto;
        display: block;
    }

    /* Slick Custom Arrows */
    #main-banner-slick .slick-prev, #main-banner-slick .slick-next {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.6) !important;
        backdrop-filter: blur(10px);
        border-radius: 50%;
        z-index: 10;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    #main-banner-slick .slick-prev { left: 6%; } /* Adjusted for wider image */
    #main-banner-slick .slick-next { right: 6%; }

    #main-banner-slick .slick-prev:before, #main-banner-slick .slick-next:before {
        font-family: 'bootstrap-icons';
        font-size: 22px;
        color: #333;
        opacity: 0.8;
    }

    #main-banner-slick .slick-prev:before { content: "\f12c"; }
    #main-banner-slick .slick-next:before { content: "\f135"; }

    #main-banner-slick .slick-dots {
        bottom: -45px; /* Move below the image */
    }

    #main-banner-slick .slick-dots li button:before {
        color: var(--secondary); /* Brand color for dots on white background */
        opacity: 0.3;
        font-size: 8px;
    }

    #main-banner-slick .slick-dots li.slick-active button:before {
        color: var(--primary); /* Active dot in primary color */
        opacity: 1;
        transform: scale(1.4);
    }

    @media screen and (max-width: 991px) {
        .hero-carousel-wrapper { padding: 110px 0 40px; } /* Increased top padding from 80px */
        .slider-img-container { border-radius: 30px; }
        .main-slider .slider-item { padding: 0 8px; }
        #main-banner-slick .slick-prev { left: 20px; }
        #main-banner-slick .slick-next { right: 20px; }
        #main-banner-slick .slick-dots { bottom: -35px; }
    }

    @media screen and (max-width: 768px) {
        .slider-img-container { border-radius: 20px; }
    }

    /* Tablet View Adjustments (Portrait & Landscape) */
    @media screen and (min-width: 577px) and (max-width: 1199px) {
        #main-banner-slick img {
            height: 380px; /* เพิ่มความสูงขึ้นจาก 300px เป็น 380px เพื่อให้ดูเต็มและสมดุล */
            object-fit: cover;
        }
        .hero-carousel-wrapper {
            padding: 115px 0 35px; /* เพิ่มระยะห่างด้านบนเพื่อให้เลื่อนลงมา ไม่ติด Navbar */
        }
    }

    /* Smartphone View Adjustments */
    @media screen and (max-width: 576px) {
        #main-banner-slick img {
            height: 150px; /* ทำให้รูปสูงขึ้นมากและดูเต็มพื้นที่ในมือถือ */
            object-fit: cover;
        }
        .slider-img-container {
            border-radius: 15px;
        }
        .hero-carousel-wrapper {
            padding: 100px 0 30px; /* ปรับ Padding ให้พอดีกับจอเล็ก */
        }
    }
</style>

<section class="hero-carousel-wrapper">
    <div class="container-fluid px-0"> <!-- Expanded for peek effect -->
        <div class="wow fadeIn" data-wow-delay="0.1s">
            <div id="main-banner-slick" class="main-slider">
                <?php foreach ($banner as $key => $v_banner): ?>
                <div class="slider-item">
                    <?php if($v_banner['banner_linkweb'] != ""): ?>
                    <a href="<?=$v_banner['banner_linkweb']?>" target="_blank">
                    <?php endif; ?>
                        <div class="slider-img-container">
                            <img class="w-100" src="<?=base_url()?>/uploads/banner/all/<?php echo $v_banner['banner_img'];?>"
                                alt="Banner Image" loading="lazy"
                                onerror="this.onerror=null;this.src='https://placehold.co/1920x600/fb7e9c/white?text=SKJ+Banner+Placeholder';">
                        </div>
                    <?php if($v_banner['banner_linkweb'] != ""): ?>
                    </a>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>


