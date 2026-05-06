<style>
    .news-detail-header {
        padding: 60px 0;
        background: #f8faf8;
    }

    .news-breadcrumb {
        margin-bottom: 30px;
    }

    .news-breadcrumb a {
        color: #fb7e9c;
        text-decoration: none;
        font-weight: 600;
    }

    .news-detail-title {
        font-size: clamp(2rem, 5vw, 3rem);
        font-weight: 800;
        color: #252525;
        line-height: 1.2;
        margin-bottom: 25px;
    }

    .news-meta {
        display: flex;
        gap: 25px;
        color: #666;
        font-weight: 500;
    }

    .news-meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .news-content-wrapper {
        padding: 60px 0;
    }

    .main-img-wrapper {
        border-radius: 40px;
        overflow: hidden;
        box-shadow: 0 25px 60px rgba(0,0,0,0.1);
        margin-bottom: 50px;
    }

    .main-img {
        width: 100%;
        max-height: 600px;
        object-fit: cover;
    }

    .news-article-content {
        font-size: 1.15rem;
        line-height: 1.9;
        color: #333;
    }

    .news-article-content p {
        margin-bottom: 25px;
    }

    /* Sidebar Recent News */
    .recent-news-card {
        background: white;
        border-radius: 30px;
        padding: 35px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.04);
        border: 1px solid rgba(0,0,0,0.03);
    }

    .recent-news-title {
        font-weight: 800;
        color: #fb7e9c;
        margin-bottom: 25px;
        font-size: 1.4rem;
        padding-bottom: 15px;
        border-bottom: 3px solid #249ffd;
        display: inline-block;
    }

    .recent-item {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px dashed #eee;
        text-decoration: none;
        color: inherit;
    }

    .recent-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .recent-item-img {
        width: 80px;
        height: 80px;
        border-radius: 15px;
        object-fit: cover;
    }

    .recent-item-info h4 {
        font-size: 0.95rem;
        font-weight: 700;
        color: #252525;
        margin-bottom: 5px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .recent-item-info small {
        color: #888;
        font-size: 0.8rem;
    }

    @media (max-width: 768px) {
        .news-detail-title { font-size: 1.8rem; }
    }
</style>

<section class="news-detail-header animate__animated animate__fadeIn">
    <div class="container">
        <div class="news-breadcrumb">
            <a href="<?= base_url('botany') ?>">หน้าแรก</a>
            <span class="mx-2 text-muted">/</span>
            <a href="<?= base_url('botany/news') ?>">กิจกรรมและข่าวสาร</a>
            <span class="mx-2 text-muted">/</span>
            <span class="text-muted">รายละเอียด</span>
        </div>
        <h1 class="news-detail-title"><?= $news->news_title ?></h1>
        <div class="news-meta">
            <div class="news-meta-item">
                <i class="bi bi-calendar3 text-primary" style="color: #fb7e9c !important;"></i>
                <?= date('d F Y', strtotime($news->news_date)) ?>
            </div>
            <div class="news-meta-item">
                <i class="bi bi-person text-info" style="color: #249ffd !important;"></i>
                งานสวนพฤกษศาสตร์โรงเรียน
            </div>
        </div>
    </div>
</section>

<div class="news-content-wrapper">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8 animate__animated animate__fadeInLeft">
                <div class="main-img-wrapper">
                    <?php if($news->news_img): ?>
                        <img src="<?= base_url('uploads/botany/news/'.$news->news_img) ?>" alt="<?= $news->news_title ?>" class="main-img">
                    <?php else: ?>
                        <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=1200&auto=format&fit=crop" alt="Default News" class="main-img">
                    <?php endif; ?>
                </div>

                <div class="news-article-content">
                    <?= nl2br($news->news_content) ?>
                </div>

                <?php if(!empty($album)): ?>
                <div class="news-album-section mt-5">
                    <h3 class="recent-news-title mb-4">อัลบั้มรูปภาพกิจกรรม</h3>
                    <div class="row g-3">
                        <?php foreach($album as $img): ?>
                        <div class="col-md-4 col-6">
                            <a href="<?= base_url('uploads/botany/news/album/'.$img->img_path) ?>" data-lightbox="news-album" data-title="<?= $news->news_title ?>" class="album-item">
                                <img src="<?= base_url('uploads/botany/news/album/'.$img->img_path) ?>" alt="Album Image" class="img-fluid rounded-4 shadow-sm album-img">
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <style>
                    .album-item {
                        display: block;
                        overflow: hidden;
                        border-radius: 15px;
                        transition: transform 0.3s ease;
                    }
                    .album-item:hover {
                        transform: scale(1.03);
                    }
                    .album-img {
                        width: 100%;
                        height: 200px;
                        object-fit: cover;
                    }
                    @media (max-width: 576px) {
                        .album-img { height: 150px; }
                    }
                </style>

                <div class="mt-5 pt-5 border-top">
                    <button class="btn btn-outline-primary rounded-pill px-4" style="color: #fb7e9c; border-color: #fb7e9c;" onclick="window.history.back()">
                        <i class="bi bi-arrow-left me-2"></i> ย้อนกลับ
                    </button>
                    <button class="btn btn-primary rounded-pill px-4 ms-2" style="background-color: #fb7e9c; border-color: #fb7e9c;" onclick="window.print()">
                        <i class="bi bi-printer me-2"></i> พิมพ์ข่าวนี้
                    </button>
                </div>
            </div>

            <div class="col-lg-4 animate__animated animate__fadeInRight">
                <div class="recent-news-card sticky-top" style="top: 100px; z-index: 10;">
                    <h3 class="recent-news-title">ข่าวสารล่าสุด</h3>
                    <div class="recent-list">
                        <?php foreach($recent_news as $r): ?>
                        <a href="<?= base_url('botany/newsdetail/'.$r->news_id) ?>" class="recent-item">
                            <?php if($r->news_img): ?>
                                <img src="<?= base_url('uploads/botany/news/'.$r->news_img) ?>" alt="<?= $r->news_title ?>" class="recent-item-img">
                            <?php else: ?>
                                <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=200&auto=format&fit=crop" alt="Recent News" class="recent-item-img">
                            <?php endif; ?>
                            <div class="recent-item-info">
                                <h4><?= $r->news_title ?></h4>
                                <small><i class="bi bi-calendar-event me-1"></i><?= date('d M Y', strtotime($r->news_date)) ?></small>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
