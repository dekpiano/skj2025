<style>
/* ==========================================================================
   NEWS REWARD SECTION - LUXURY HALL OF FAME & PRESTIGE CARDS
   ดีไซน์ใหม่: หรูหรา ทรงคุณค่า สไตล์ Frosted Obsidian Glass & Gold Halo
   ========================================================================== */
.news-reward-section {
    padding: 75px 0 85px 0;
    background: linear-gradient(180deg, rgba(7, 18, 38, 0.88) 0%, rgba(13, 29, 60, 0.92) 100%), 
                url('<?= base_url('uploads/background/campus_view_55.jpg') ?>');
    background-attachment: fixed;
    background-position: center;
    background-size: cover;
    overflow: hidden;
    position: relative;
}

/* Ambient Prestige Light Orbs */
.news-reward-section::before {
    content: '';
    position: absolute;
    top: -100px;
    left: 50%;
    transform: translateX(-50%);
    width: 600px;
    height: 350px;
    background: radial-gradient(ellipse, rgba(245, 158, 11, 0.15) 0%, rgba(251, 126, 156, 0.08) 40%, transparent 70%);
    filter: blur(70px);
    pointer-events: none;
    z-index: 0;
}

/* Header Area */
.reward-header-wrap {
    position: relative;
    z-index: 1;
    max-width: 720px;
    margin: 0 auto 40px auto;
    text-align: center;
}

.reward-sec-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(245, 158, 11, 0.12);
    border: 1px solid rgba(245, 158, 11, 0.35);
    color: #fbbf24;
    font-size: 0.82rem;
    font-weight: 700;
    padding: 6px 18px;
    border-radius: 50px;
    letter-spacing: 0.5px;
    margin-bottom: 14px;
    backdrop-filter: blur(10px);
}

.reward-sec-title {
    font-size: clamp(2rem, 3.5vw, 2.75rem);
    font-weight: 900;
    color: #ffffff;
    font-family: 'K2D', sans-serif;
    margin-bottom: 10px;
    letter-spacing: -0.5px;
}

.reward-sec-desc {
    color: rgba(255, 255, 255, 0.75);
    font-size: 0.95rem;
    font-weight: 400;
    margin-bottom: 0;
}

/* Slick Slider Track */
.news-reward-section .slick-track {
    display: flex !important;
    padding: 30px 0 45px 0;
}

.news-reward-section .slick-slide {
    height: auto !important;
    transition: all 0.45s cubic-bezier(0.16, 1, 0.3, 1);
    outline: none !important;
}

/* ==========================================================================
   PRESTIGE REWARD CARD (Frosted Glass & Gold Glow)
   ========================================================================== */
.reward-glass-card {
    background: linear-gradient(150deg, rgba(255, 255, 255, 0.10) 0%, rgba(255, 255, 255, 0.03) 100%);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 22px;
    overflow: hidden;
    margin: 10px 8px;
    height: 100%;
    display: flex !important;
    flex-direction: column;
    box-shadow: 0 16px 36px -6px rgba(0, 0, 0, 0.35);
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
}

/* Center Highlight Slide (Golden Halo) */
.news-reward-section .slick-center .reward-glass-card {
    transform: scale(1.06);
    background: linear-gradient(150deg, rgba(255, 255, 255, 0.16) 0%, rgba(255, 255, 255, 0.05) 100%);
    border: 1px solid rgba(245, 158, 11, 0.55);
    box-shadow: 0 24px 50px -10px rgba(0, 0, 0, 0.5), 
                0 0 35px -5px rgba(245, 158, 11, 0.28);
    z-index: 5;
}

.reward-glass-card:hover {
    transform: translateY(-6px);
    border-color: rgba(245, 158, 11, 0.45);
    box-shadow: 0 20px 45px -8px rgba(0, 0, 0, 0.45), 
                0 0 25px -4px rgba(245, 158, 11, 0.25);
}

/* Image Thumbnail Container */
.reward-img-wrap {
    position: relative;
    height: 180px;
    overflow: hidden;
    background: #0f172a;
}

.reward-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.65s cubic-bezier(0.16, 1, 0.3, 1);
    display: block;
}

.reward-glass-card:hover .reward-img-wrap img {
    transform: scale(1.08);
}

/* Image Bottom Gradient Fade */
.reward-img-fade {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(10, 22, 45, 0.85) 0%, rgba(10, 22, 45, 0.2) 50%, transparent 100%);
    pointer-events: none;
}

/* Badges on Image */
.reward-badge-gold {
    position: absolute;
    top: 12px;
    left: 12px;
    background: linear-gradient(135deg, #f59e0b 0%, #b45309 100%);
    color: #ffffff;
    font-size: 0.72rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 30px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    box-shadow: 0 4px 12px rgba(180, 83, 9, 0.4);
    letter-spacing: 0.3px;
    z-index: 2;
}

.reward-views-pill {
    position: absolute;
    top: 12px;
    right: 12px;
    background: rgba(10, 20, 40, 0.7);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    color: rgba(255, 255, 255, 0.85);
    font-size: 0.72rem;
    font-weight: 600;
    padding: 3px 9px;
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.15);
    display: inline-flex;
    align-items: center;
    gap: 5px;
    z-index: 2;
}

/* Card Body Content */
.reward-card-body {
    padding: 20px 20px 18px 20px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

/* Date Meta */
.reward-date-meta {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.76rem;
    font-weight: 600;
    color: #38bdf8;
    margin-bottom: 10px;
}

/* Card Title */
.reward-card-title {
    font-size: 1.05rem;
    font-weight: 700;
    line-height: 1.45;
    margin-bottom: 16px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    color: #ffffff;
    font-family: 'K2D', sans-serif;
}

.reward-card-title a {
    color: #ffffff;
    text-decoration: none;
    transition: color 0.25s ease;
}

.reward-card-title a:hover {
    color: #fbbf24;
}

/* Action Button */
.reward-action-btn {
    margin-top: auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    padding: 8px 14px;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.12);
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.8rem;
    font-weight: 700;
    text-decoration: none !important;
    transition: all 0.3s ease;
}

.reward-action-btn i {
    transition: transform 0.25s ease;
}

.reward-action-btn:hover {
    background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%);
    border-color: transparent;
    color: #ffffff;
    box-shadow: 0 6px 18px rgba(245, 158, 11, 0.35);
}

.reward-action-btn:hover i {
    transform: translateX(4px);
}

/* Bottom CTA Button */
.btn-luxury-reward {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.12) 0%, rgba(255, 255, 255, 0.05) 100%);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(245, 158, 11, 0.4);
    color: #ffffff !important;
    font-weight: 700;
    font-size: 0.95rem;
    padding: 13px 32px;
    border-radius: 50px;
    text-decoration: none !important;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
    transition: all 0.35s ease;
}

.btn-luxury-reward:hover {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    border-color: transparent;
    color: #ffffff !important;
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(245, 158, 11, 0.4);
}

/* Responsive adjustments */
@media (max-width: 991px) {
    .news-reward-section { padding: 60px 0 70px 0; }
    .reward-img-wrap { height: 160px; }
    .reward-card-body { padding: 16px 16px 14px 16px; }
    .reward-card-title { font-size: 0.98rem; }
}

@media (max-width: 575px) {
    .news-reward-section { padding: 50px 0 60px 0; }
    .reward-glass-card { margin: 6px 4px; border-radius: 18px; }
    .reward-img-wrap { height: 145px; }
    .reward-badge-gold { font-size: 0.68rem; padding: 3px 8px; }
    .reward-views-pill { font-size: 0.68rem; padding: 2px 7px; }
    .reward-card-body { padding: 14px 12px 12px 12px; }
    .reward-card-title { font-size: 0.92rem; margin-bottom: 12px; }
    .reward-action-btn { font-size: 0.76rem; padding: 7px 12px; }
}
</style>

<section class="news-reward-section">
    <div class="container-fluid px-0">
        <!-- Header -->
        <div class="reward-header-wrap wow fadeInUp" data-wow-delay="0.1s">
            <div class="reward-sec-badge">
                <i class="bi bi-award-fill text-warning"></i> SKJ Hall of Fame & Achievements
            </div>
            <h2 class="reward-sec-title">รางวัลและความภาคภูมิใจ</h2>
            <p class="reward-sec-desc">ผลงานเกียรติยศแห่งความสำเร็จของนักเรียนและบุคลากรโรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ)</p>
        </div>
        
        <!-- Slick Slider -->
        <div class="news-slider-wrapper">
            <div id="news-reward-slick-slider" class="news-slider wow fadeInUp" data-wow-delay="0.2s">
                <?php foreach ($NewsReward as $key => $v_newsReward ) : ?>
                <div>
                    <div class="reward-glass-card">
                        <!-- Image Container with Badges -->
                        <div class="reward-img-wrap">
                            <img src="<?=base_url('uploads/news/'.$v_newsReward->news_img)?>" alt="<?= $v_newsReward->news_topic ?>" loading="lazy">
                            <div class="reward-img-fade"></div>
                            
                            <!-- Trophy Badge -->
                            <span class="reward-badge-gold">
                                <i class="bi bi-trophy-fill"></i> เกียรติยศ
                            </span>
                            
                            <!-- Views Pill -->
                            <span class="reward-views-pill">
                                <i class="bi bi-eye"></i> <?= number_format($v_newsReward->news_view) ?>
                            </span>
                        </div>

                        <!-- Card Body -->
                        <div class="reward-card-body">
                            <!-- Date Meta -->
                            <div class="reward-date-meta">
                                <i class="bi bi-calendar3"></i>
                                <span><?= $dateThai->thai_date_fullmonth(strtotime($v_newsReward->news_date)) ?></span>
                            </div>

                            <!-- Title -->
                            <h4 class="reward-card-title">
                                <a href="<?=base_url('News/Detail/'.$v_newsReward->news_id);?>">
                                    <?= $v_newsReward->news_topic ?>
                                </a>
                            </h4>

                            <!-- Action Button -->
                            <a href="<?=base_url('News/Detail/'.$v_newsReward->news_id);?>" class="reward-action-btn">
                                <span>อ่านรายละเอียด</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>                
            </div>
        </div>

        <!-- Bottom CTA Button -->
        <div class="text-center mt-3">
            <a class="btn-luxury-reward" href="<?=base_url('News')?>">
                <i class="bi bi-trophy-fill text-warning"></i> ดูผลงานและรางวัลทั้งหมด <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</section>