<style>
/* ==========================================================================
   NEWS SECTION - MODERN GLASS & STREAMLINED CARDS
   ดีไซน์ใหม่: สไตล์ Frosted Crystal Glass, ขอบโค้งมน, การ์ดมีมิติหรูหรา
   ========================================================================== */
.news-section {
    padding: 70px 0 80px 0;
    background: transparent !important;
    position: relative;
    overflow: hidden;
}

/* Header Area */
.news-header-wrap {
    position: relative;
    z-index: 1;
    max-width: 720px;
    margin: 0 auto 35px auto;
    text-align: center;
}

.news-sec-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, rgba(251, 126, 156, 0.12) 0%, rgba(36, 159, 253, 0.12) 100%);
    border: 1px solid rgba(36, 159, 253, 0.25);
    color: #1b68b3;
    font-size: 0.82rem;
    font-weight: 700;
    padding: 6px 18px;
    border-radius: 50px;
    letter-spacing: 0.5px;
    margin-bottom: 12px;
    backdrop-filter: blur(10px);
}

.news-sec-title {
    font-size: clamp(2rem, 3.5vw, 2.75rem);
    font-weight: 900;
    color: #0f172a;
    font-family: 'K2D', sans-serif;
    margin-bottom: 10px;
    letter-spacing: -0.5px;
}

.news-sec-desc {
    color: #64748b;
    font-size: 0.95rem;
    font-weight: 400;
    margin-bottom: 0;
}

/* Slider Track */
.news-slider-wrapper {
    padding: 10px 0 20px 0;
    position: relative;
}

.news-slider .slick-track {
    display: flex !important;
    padding: 25px 0 35px 0;
}

.news-slider .slick-slide {
    height: auto !important;
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    outline: none !important;
}

/* ==========================================================================
   MODERN NEWS CARD (Frosted Glass & Depth)
   ========================================================================== */
.skj-news-card {
    background: linear-gradient(160deg, rgba(255, 255, 255, 0.88) 0%, rgba(255, 255, 255, 0.70) 100%);
    backdrop-filter: blur(18px);
    -webkit-backdrop-filter: blur(18px);
    border: 1px solid rgba(255, 255, 255, 0.9);
    border-radius: 22px;
    overflow: hidden;
    margin: 8px;
    height: 100%;
    display: flex !important;
    flex-direction: column;
    box-shadow: 0 12px 30px -6px rgba(15, 23, 42, 0.08), 
                0 0 0 1px rgba(0, 0, 0, 0.03);
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
}

/* Center Highlight Slide */
.news-slider .slick-center .skj-news-card {
    transform: scale(1.05);
    background: linear-gradient(160deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.82) 100%);
    border: 1px solid rgba(36, 159, 253, 0.4);
    box-shadow: 0 22px 48px -10px rgba(36, 159, 253, 0.22), 
                0 0 0 1px rgba(36, 159, 253, 0.2);
    z-index: 5;
}

.skj-news-card:hover {
    transform: translateY(-6px);
    border-color: rgba(251, 126, 156, 0.4);
    box-shadow: 0 20px 40px -8px rgba(251, 126, 156, 0.2), 
                0 0 0 1px rgba(251, 126, 156, 0.25);
}

/* Thumbnail Area */
.skj-news-card .post-img {
    position: relative;
    height: 175px;
    overflow: hidden;
    background: #f1f5f9;
}

.skj-news-card .post-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.65s cubic-bezier(0.16, 1, 0.3, 1);
    display: block;
}

.skj-news-card:hover .post-img img {
    transform: scale(1.08);
}

/* Image Bottom Gradient Fade */
.post-img-fade {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(15, 23, 42, 0.4) 0%, transparent 60%);
    pointer-events: none;
}

/* News Tags on Image */
.news-tag-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    background: linear-gradient(135deg, #fb7e9c 0%, #e11d48 100%);
    color: #ffffff;
    font-size: 0.72rem;
    font-weight: 700;
    padding: 4px 11px;
    border-radius: 30px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    box-shadow: 0 4px 12px rgba(225, 29, 72, 0.3);
    z-index: 2;
}

.news-views-pill {
    position: absolute;
    top: 12px;
    right: 12px;
    background: rgba(15, 23, 42, 0.65);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.72rem;
    font-weight: 600;
    padding: 3px 9px;
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    display: inline-flex;
    align-items: center;
    gap: 5px;
    z-index: 2;
}

/* Card Content */
.skj-news-card .post-content {
    padding: 18px 18px 16px 18px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

/* Date Meta */
.skj-news-card .post-meta {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.76rem;
    font-weight: 600;
    color: #249ffd;
    margin-bottom: 8px;
}

/* Title */
.skj-news-card .post-title {
    font-size: 1.02rem;
    font-weight: 700;
    line-height: 1.45;
    margin-bottom: 14px;
    color: #0f172a;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    font-family: 'K2D', sans-serif;
}

.skj-news-card .post-title a {
    color: #0f172a;
    text-decoration: none;
    transition: color 0.25s ease;
}

.skj-news-card .post-title a:hover {
    color: #249ffd;
}

/* Action Button */
.news-read-btn {
    margin-top: auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    padding: 8px 14px;
    border-radius: 12px;
    background: rgba(36, 159, 253, 0.08);
    border: 1px solid rgba(36, 159, 253, 0.15);
    color: #1b68b3;
    font-size: 0.8rem;
    font-weight: 700;
    text-decoration: none !important;
    transition: all 0.3s ease;
}

.news-read-btn i {
    transition: transform 0.25s ease;
}

.news-read-btn:hover {
    background: linear-gradient(135deg, #fb7e9c 0%, #249ffd 100%);
    border-color: transparent;
    color: #ffffff;
    box-shadow: 0 6px 18px rgba(36, 159, 253, 0.3);
}

.news-read-btn:hover i {
    transform: translateX(4px);
}

/* Bottom CTA Button */
.btn-news-all {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: linear-gradient(135deg, #1b68b3 0%, #15518c 100%);
    color: #ffffff !important;
    font-weight: 700;
    font-size: 0.95rem;
    padding: 13px 34px;
    border-radius: 50px;
    text-decoration: none !important;
    box-shadow: 0 10px 25px -4px rgba(27, 104, 179, 0.35);
    transition: all 0.35s ease;
}

.btn-news-all:hover {
    background: linear-gradient(135deg, #fb7e9c 0%, #249ffd 100%);
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(36, 159, 253, 0.4);
}

/* Responsive adjustments */
@media (max-width: 991px) {
    .news-section { padding: 55px 0 65px 0; }
    .skj-news-card .post-img { height: 155px; }
    .skj-news-card .post-content { padding: 15px 14px 12px 14px; }
    .skj-news-card .post-title { font-size: 0.95rem; }
}

@media (max-width: 575px) {
    .news-section { padding: 45px 0 55px 0; }
    .skj-news-card { margin: 6px 4px; border-radius: 18px; }
    .skj-news-card .post-img { height: 140px; }
    .news-tag-badge { font-size: 0.68rem; padding: 3px 8px; }
    .news-views-pill { font-size: 0.68rem; padding: 2px 7px; }
    .skj-news-card .post-content { padding: 12px 10px 10px 10px; }
    .skj-news-card .post-title { font-size: 0.88rem; margin-bottom: 10px; }
    .news-read-btn { font-size: 0.75rem; padding: 6px 10px; }
}
</style>

<section class="news-section">
    <div class="container-fluid px-0">
        <!-- Header -->
        <div class="news-header-wrap wow fadeInUp" data-wow-delay="0.1s">
            <div class="news-sec-badge">
                <i class="bi bi-newspaper"></i> SKJ News & Announcements
            </div>
            <h2 class="news-sec-title">ข่าวสารและประชาสัมพันธ์</h2>
            <p class="news-sec-desc">เกาะติดทุกกิจกรรม ข่าวสารการศึกษา และการประกาศสำคัญของโรงเรียน</p>
        </div>
        
        <!-- Slick Slider -->
        <div class="news-slider-wrapper">
            <div id="news-slick-slider" class="news-slider wow fadeInUp" data-wow-delay="0.2s">
                <?php foreach ($news as $key => $v_news) : ?>
                <div>
                    <div class="skj-news-card">
                        <!-- Image Container with Badges -->
                        <div class="post-img">
                            <img src="<?=base_url('uploads/news/'.$v_news->news_img)?>" alt="<?= $v_news->news_topic ?>" loading="lazy"
                                onerror="this.onerror=null;this.src='https://placehold.co/400x250/fb7e9c/white?text=SKJ+News';">
                            <div class="post-img-fade"></div>
                            
                            <!-- News Tag Badge -->
                            <span class="news-tag-badge">
                                <i class="bi bi-megaphone-fill"></i> ประชาสัมพันธ์
                            </span>
                            
                            <!-- Views Pill -->
                            <span class="news-views-pill">
                                <i class="bi bi-eye"></i> <?= number_format($v_news->news_view) ?>
                            </span>
                        </div>

                        <!-- Content Body -->
                        <div class="post-content">
                            <!-- Date Meta -->
                            <div class="post-meta">
                                <i class="bi bi-calendar3"></i>
                                <span><?= $dateThai->thai_date_fullmonth(strtotime($v_news->news_date)) ?></span>
                            </div>

                            <!-- Title -->
                            <h4 class="post-title">
                                <a href="<?=base_url('News/Detail/'.$v_news->news_id);?>">
                                    <?= $v_news->news_topic ?>
                                </a>
                            </h4>

                            <!-- Action Button -->
                            <a href="<?=base_url('News/Detail/'.$v_news->news_id);?>" class="news-read-btn">
                                <span>อ่านต่อ</span>
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
            <a class="btn-news-all" href="<?=base_url('News')?>">
                <i class="bi bi-grid-fill"></i> ดูข่าวสารทั้งหมดของโรงเรียน <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</section>
