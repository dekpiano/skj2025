<style>
    .news-reward-section {
        padding: 80px 0;
        background-color: #f0f7ff; /* Subtle blue */
        overflow: hidden;
    }

    /* Reuse the same stable card design */
    .news-reward-section .skj-news-card {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        margin: 8px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.05);
        transition: all 0.4s ease;
        border: 1px solid rgba(0,0,0,0.03);
        height: 100%;
        display: flex !important;
        flex-direction: column;
    }

    .news-reward-section .slick-track {
        display: flex !important;
    }

    .news-reward-section .slick-slide {
        height: auto !important;
    }

    .news-reward-section .slick-center .skj-news-card {
        transform: scale(1.05);
        box-shadow: 0 15px 40px rgba(0,0,0,0.1);
        border-color: rgba(36, 159, 253, 0.2);
        z-index: 5;
    }

    .news-reward-section .skj-news-card .post-img {
        position: relative;
        height: 160px;
        overflow: hidden;
        background-color: #eee;
    }

    .news-reward-section .skj-news-card .post-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .news-reward-section .slick-center .skj-news-card:hover .post-img img {
        transform: scale(1.1);
    }

    .news-reward-section .skj-news-card .post-content {
        padding: 15px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .news-reward-section .skj-news-card .post-title {
        font-size: 1rem;
        font-weight: 800;
        margin-bottom: 12px;
        color: #1a2a4d;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 2.8rem;
        line-height: 1.4;
    }

    .news-reward-section .skj-news-card .post-title a {
        color: inherit;
        text-decoration: none;
    }

    .news-reward-section .skj-news-card .post-meta {
        margin-bottom: 10px;
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--secondary);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .news-reward-section .skj-news-card .read-more {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: var(--primary);
        font-weight: 800;
        text-decoration: none;
        font-size: 0.8rem;
        transition: all 0.3s ease;
        margin-top: auto;
    }

    @media (max-width: 768px) {
        .news-reward-section .skj-news-card .post-img { height: 140px; }
        .news-reward-section .skj-news-card .post-content { padding: 12px; }
    }
</style>

<section class="news-reward-section">
    <div class="container-fluid px-0">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 700px;">
            <span class="section-subtitle">SKJ Proud & Rewards</span>
            <h1 class="display-5 mb-4" style="font-weight: 800; color: #1a2a4d;">รางวัลและความภูมิใจ</h1>
            <div class="mx-auto" style="width: 100px; height: 5px; background: linear-gradient(to right, var(--primary), var(--secondary)); border-radius: 5px;"></div>
        </div>
        
        <div class="news-slider-wrapper">
            <div id="news-reward-slick-slider" class="news-slider wow fadeInUp" data-wow-delay="0.2s">
                <?php foreach ($NewsReward as $key => $v_newsReward ) : ?>
                <div>
                    <div class="skj-news-card">
                        <div class="post-img">
                            <img src="<?=base_url('uploads/news/'.$v_newsReward->news_img)?>" alt="<?= $v_newsReward->news_topic ?>" loading="lazy">
                        </div>
                        <div class="post-content">
                            <div class="post-meta">
                                <i class="bi bi-trophy-fill"></i>
                                <span><?= $dateThai->thai_date_fullmonth(strtotime($v_newsReward->news_date)) ?></span>
                                <span class="ms-auto"><i class="bi bi-eye"></i> <?= number_format($v_newsReward->news_view) ?></span>
                            </div>
                            <h3 class="post-title">
                                <a href="<?=base_url('News/Detail/'.$v_newsReward->news_id);?>"><?= $v_newsReward->news_topic ?></a>
                            </h3>
                            <a href="<?=base_url('News/Detail/'.$v_newsReward->news_id);?>" class="read-more">รายละเอียดรางวัล <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>                
            </div>
        </div>

        <div class="text-center mt-4">
            <a class="btn btn-outline-primary rounded-pill py-3 px-5 fw-bold" href="<?=base_url('News')?>">
                <i class="bi bi-trophy me-2"></i> ดูผลงานและรางวัลทั้งหมด
            </a>
        </div>
    </div>
</section>