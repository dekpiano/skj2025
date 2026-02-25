<?php if (!empty($spotlights)) : ?>
<style>
/* กำหนดความสูงของพื้นที่ข่าวเด่น (สำคัญมาก) */
.spotlight-carousel {
    height: 500px;
    background-color: #f8f9fa;
}

/* ตั้งค่าให้ Slide ซ้อนทับกันทั้งหมด และซ่อนตัวที่ไม่ได้ Active */
.spotlight-slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.8s ease-in-out, visibility 0.8s ease-in-out;
    z-index: 1;
}

.spotlight-slide.active {
    opacity: 1;
    visibility: visible;
    z-index: 5; /* ให้อยู่ด้านบนสุดตอนแสดงผล */
}

/* ========================================= */
/* แอนิเมชันสำหรับ รูปภาพ และ ข้อความ ข้างใน Slide */
/* ========================================= */

.spotlight-slide .spotlight-img {
    transform: scale(1.1);
    opacity: 0;
    transition: transform 1.5s cubic-bezier(0.2, 0.8, 0.2, 1), opacity 1s ease;
}

.spotlight-slide .spotlight-content-col > * {
    transform: translateY(30px);
    opacity: 0;
    transition: transform 1s cubic-bezier(0.2, 0.8, 0.2, 1), opacity 0.8s ease;
}

.spotlight-slide.active .spotlight-img {
    transform: scale(1);
    opacity: 1;
}

.spotlight-slide.active .spotlight-content-col > * {
    transform: translateY(0);
    opacity: 1;
}

.spotlight-slide.active .spotlight-content-col .badge { transition-delay: 0.3s; }
.spotlight-slide.active .spotlight-content-col h2 { transition-delay: 0.4s; }
.spotlight-slide.active .spotlight-content-col p { transition-delay: 0.5s; }
.spotlight-slide.active .spotlight-content-col .btn { transition-delay: 0.6s; }

/* ========================================= */
/* ปุ่มกดและจุด Indicators ด้านล่าง */
/* ========================================= */
.spotlight-btn-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, 0.8);
    border: none;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    font-size: 1.5rem;
    color: #333;
    z-index: 10;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
    display: flex;
    justify-content: center;
    align-items: center;
    backdrop-filter: blur(5px);
}
.spotlight-btn-nav:hover { background: #fff; transform: translateY(-50%) scale(1.1); }
.spotlight-btn-nav.btn-prev { left: 20px; }
.spotlight-btn-nav.btn-next { right: 20px; }

.spotlight-indicators {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 10;
    display: flex;
    gap: 10px;
}
.spotlight-nav-dot {
    width: 30px;
    height: 4px;
    background-color: rgba(0, 0, 0, 0.2);
    border-radius: 2px;
    cursor: pointer;
    transition: background-color 0.3s ease, width 0.3s ease;
}

.spotlight-slide.active .row.bg-dark ~ .spotlight-indicators .spotlight-nav-dot { background-color: rgba(255,255,255,0.4); }
.spotlight-slide.active .row.bg-dark ~ .spotlight-indicators .spotlight-nav-dot.active { background-color: #fff; }

.spotlight-img-col { height: 100%; transition: all 0.3s ease; }
.spotlight-content-col { height: 100%; transition: all 0.3s ease; }

/* สำหรับแท็บเล็ต / iPad แนวตั้ง (max-width: 991px) */
@media (max-width: 991px) {
    .spotlight-carousel { height: 450px; }
    .spotlight-img-col { height: 50%; padding: 1.5rem 1.5rem 0.5rem 1.5rem !important; }
    .spotlight-content-col { height: 50%; padding: 0.5rem 2rem 2.5rem 2rem !important; text-align: center; justify-content: flex-start !important; }
    .spotlight-content-col .badge { align-self: center !important; margin-bottom: 0.5rem !important; }
    .spotlight-content-col h3 { font-size: 1.75rem; margin-bottom: 0.5rem !important; }
    .spotlight-content-col p { font-size: 1rem !important; margin-bottom: 1.5rem !important; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    .spotlight-content-col .btn { align-self: center !important; }
    .spotlight-img-col .spotlight-img { max-height: 100%; max-width: 100%; object-fit: contain; }
}

/* สำหรับมือถือขนาดเล็ก (max-width: 768px - ทับซ้อนกับจุดไข่ปลาด้านบน) */
@media (max-width: 768px) {
    .skj-spotlight-section { padding-top: 1rem !important; padding-bottom: 2rem !important; }
    .spotlight-carousel { height: 500px; }
    .spotlight-img-col { height: 45%; padding: 0.5rem 1rem 0 1rem !important; } /* reduced top padding even more */
    .spotlight-content-col { height: 55%; padding: 0 1.5rem 2rem 1.5rem !important; text-align: center; justify-content: flex-start !important; } /* reduced top padding */
    .spotlight-content-col .badge { align-self: center !important; margin-bottom: 0.5rem !important; }
    .spotlight-content-col h3 { font-size: 1.3rem; margin-bottom: 0.5rem !important; }
    .spotlight-content-col p { font-size: 0.9rem !important; margin-bottom: 1rem !important; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    .spotlight-content-col .btn { align-self: center !important; font-size: 0.9rem; padding: 0.5rem 1rem !important; }
    .spotlight-btn-nav { display: none; } /* ซ่อนลูกศรในมือถือ กดจุดวงกลม หรือปัดเอา */
}
</style>

<section class="skj-spotlight-section py-5">
    <div class="container">
        <!-- Slider Container โค้งมน มีเงา ดูเป็น Card ลอยขึ้นมา -->
        <div class="spotlight-carousel position-relative overflow-hidden rounded-4" id="skjSpotlight">
            
            <?php foreach ($spotlights as $index => $spot) : 
                $activeClass = ($index == 0) ? 'active' : '';
                $themeClass = ($spot['spotlight_theme'] == 'dark') ? 'bg-dark text-white' : 'text-dark';
                $layoutClass = ($spot['spotlight_layout'] == 'right') ? 'flex-md-row-reverse' : '';
                
                $imageUrl = '';
                if (!empty($spot['spotlight_img']) && file_exists(FCPATH . 'uploads/spotlight/' . $spot['spotlight_img'])) {
                    $imageUrl = base_url('uploads/spotlight/' . $spot['spotlight_img']);
                } else if (empty($spot['spotlight_facebook_embed'])) {
                    $imageUrl = 'https://via.placeholder.com/1000x800.png?text=Image+Not+Found';
                }
            ?>
            <!-- ====== Slide ====== -->
            <div class="spotlight-slide <?= $activeClass ?>">
                <div class="row g-0 h-100 align-items-center <?= $layoutClass ?> <?= $themeClass ?>">
                    <div class="col-lg-7 col-md-12 spotlight-img-col d-flex align-items-center justify-content-center p-md-4 p-3">
                        <?php if (!empty($spot['spotlight_facebook_embed'])): ?>
                            <div class="w-100 h-100 d-flex justify-content-center align-items-center spotlight-img" style="overflow:hidden;">
                                <?= $spot['spotlight_facebook_embed'] ?>
                            </div>
                        <?php else: ?>
                            <img src="<?= $imageUrl ?>" class="w-100 object-fit-contain spotlight-img" style="max-height: 100%;" alt="<?= $spot['spotlight_topic'] ?>">
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-5 col-md-12 d-flex flex-column justify-content-center spotlight-content-col p-lg-5 p-4">
                        <?php if(!empty($spot['spotlight_badge'])): ?>
                            <span class="badge <?= $spot['spotlight_badge_color'] ?> rounded-pill align-self-start py-2 px-3 mb-3 fw-normal" style="letter-spacing: 1px;">
                                <?= $spot['spotlight_badge'] ?>
                            </span>
                        <?php endif; ?>
                        
                        <h3 class="fw-bold mb-3" style="line-height: 1.4;">
                            <?= $spot['spotlight_topic'] ?> <br>
                            <span class="text-primary"><?= $spot['spotlight_topic_highlight'] ?></span>
                        </h3>
                        
                        <p class="mb-4 <?= ($spot['spotlight_theme'] == 'dark') ? 'text-light opacity-75' : 'text-muted opacity-75' ?>" style="font-size: 1rem;">
                            <?= nl2br(esc($spot['spotlight_content'])) ?>
                        </p>
                        
                        <?php if(!empty($spot['spotlight_btn_link'])): ?>
                            <a href="<?= $spot['spotlight_btn_link'] ?>" class="btn <?= $spot['spotlight_btn_color'] ?> btn-lg align-self-start px-4 rounded-pill">
                                <?= !empty($spot['spotlight_btn_text']) ? $spot['spotlight_btn_text'] : 'อ่านรายละเอียดเพิ่มเติม' ?> <i class="bi bi-arrow-right ms-2"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

            <?php if (count($spotlights) > 1): ?>
                <!-- Controls (ปุ่มเลื่อนซ้าย-ขวา) -->
                <button class="spotlight-btn-nav btn-prev"><i class="bi bi-chevron-left"></i></button>
                <button class="spotlight-btn-nav btn-next"><i class="bi bi-chevron-right"></i></button>

                <!-- Indicators (จุดไข่ปลาด้านล่าง) -->
                <div class="spotlight-indicators">
                    <?php foreach ($spotlights as $index => $spot) : ?>
                        <span class="spotlight-nav-dot <?= ($index == 0) ? 'active' : '' ?>" data-slide="<?= $index ?>"></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php if (count($spotlights) > 1): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.spotlight-slide');
    const dots = document.querySelectorAll('.spotlight-nav-dot');
    const nextBtn = document.querySelector('.btn-next');
    const prevBtn = document.querySelector('.btn-prev');
    let currentSlide = 0;
    const slideCount = slides.length;
    let autoPlayInterval;

    // ฟังก์ชันเปลี่ยนสไลด์
    function goToSlide(n) {
        slides.forEach(slide => slide.classList.remove('active'));
        if (dots.length > 0) {
            dots.forEach(dot => dot.classList.remove('active'));
        }

        currentSlide = (n + slideCount) % slideCount; 
        slides[currentSlide].classList.add('active');
        if (dots.length > 0) {
            dots[currentSlide].classList.add('active');
        }
    }

    function nextSlide() { goToSlide(currentSlide + 1); }
    function prevSlide() { goToSlide(currentSlide - 1); }

    if(nextBtn) nextBtn.addEventListener('click', () => { nextSlide(); resetAutoplay(); });
    if(prevBtn) prevBtn.addEventListener('click', () => { prevSlide(); resetAutoplay(); });
    
    if (dots.length > 0) {
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                goToSlide(index);
                resetAutoplay();
            });
        });
    }

    function startAutoplay() {
        autoPlayInterval = setInterval(nextSlide, 7000);
    }
    function resetAutoplay() {
        clearInterval(autoPlayInterval);
        startAutoplay();
    }

    startAutoplay();
});
</script>
<?php endif; ?>

<?php endif; ?>
