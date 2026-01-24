<style>
    .news-reward-section {
        padding: 120px 0;
        background: linear-gradient(rgba(1, 33, 67, 0.85), rgba(1, 33, 67, 0.9)), url('<?= base_url('uploads/background/campus_view_55.jpg') ?>');
        background-attachment: fixed;
        background-position: center;
        background-size: cover;
        overflow: hidden;
        position: relative;
    }

    /* Glassmorphism News Card */
    .news-reward-section .skj-news-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border-radius: 25px;
        overflow: hidden;
        margin: 15px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
        border: 1px solid rgba(255, 255, 255, 0.1);
        height: 100%;
        display: flex !important;
        flex-direction: column;
    }

    .news-reward-section .slick-track {
        display: flex !important;
        padding: 40px 0;
    }

    .news-reward-section .slick-slide {
        height: auto !important;
        transition: all 0.5s ease;
    }

    .news-reward-section .slick-center .skj-news-card {
        transform: scale(1.1);
        background: rgba(255, 255, 255, 0.1);
        border-color: var(--secondary);
        box-shadow: 0 30px 60px rgba(0,0,0,0.4);
        z-index: 5;
    }

    .news-reward-section .skj-news-card .post-img {
        position: relative;
        height: 180px;
        overflow: hidden;
    }

    .news-reward-section .skj-news-card .post-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .news-reward-section .skj-news-card .post-content {
        padding: 25px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .news-reward-section .skj-news-card .post-title {
        font-size: 1.1rem;
        font-weight: 800;
        margin-bottom: 15px;
        color: #fff;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.5;
    }

    .news-reward-section .skj-news-card .post-title a {
        color: #fff;
        text-decoration: none;
    }

    .news-reward-section .skj-news-card .post-meta {
        margin-bottom: 12px;
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--secondary);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .news-reward-section .skj-news-card .read-more {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--primary);
        font-weight: 800;
        text-decoration: none;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        margin-top: auto;
    }

    .news-reward-section .skj-news-card .read-more:hover {
        gap: 12px;
        color: #fff;
    }

    @media (max-width: 768px) {
        .news-reward-section { padding: 80px 0; }
        .news-reward-section .skj-news-card { margin: 10px; }
        .news-reward-section .skj-news-card .post-img { height: 150px; }
        .news-reward-section .skj-news-card .post-content { padding: 15px; }
    }
</style>

<section class="news-reward-section">
    <div class="container-fluid px-0">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 700px; position: relative; z-index: 1;">
            <span class="section-subtitle text-white opacity-75">SKJ Proud & Rewards</span>
            <h1 class="display-5 mb-4" style="font-weight: 800; color: #ffffff;">รางวัลและความภูมิใจ</h1>
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