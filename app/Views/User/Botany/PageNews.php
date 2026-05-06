<style>
    .news-header {
        background: linear-gradient(135deg, #fb7e9c 0%, #249ffd 100%);
        padding: 100px 0 150px;
        color: white;
        text-align: center;
        border-radius: 0 0 50px 50px;
    }

    .news-container {
        margin-top: -80px;
        padding-bottom: 100px;
    }

    .news-card {
        background: white;
        border-radius: 25px;
        overflow: hidden;
        border: none;
        box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .news-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 50px rgba(251, 126, 156, 0.15);
    }

    .news-img-wrapper {
        position: relative;
        height: 220px;
        overflow: hidden;
    }

    .news-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .news-card:hover .news-img-wrapper img {
        transform: scale(1.1);
    }

    .news-date-badge {
        position: absolute;
        top: 20px;
        left: 20px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(5px);
        padding: 8px 15px;
        border-radius: 12px;
        font-weight: 700;
        color: #fb7e9c;
        font-size: 0.85rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .news-body {
        padding: 30px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .news-title {
        font-weight: 700;
        color: #252525;
        font-size: 1.25rem;
        margin-bottom: 15px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .news-excerpt {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 20px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .read-more {
        margin-top: auto;
        color: #fb7e9c;
        text-decoration: none;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: gap 0.3s ease;
    }

    .news-card:hover .read-more {
        gap: 12px;
    }
</style>

<div class="news-header animate__animated animate__fadeIn">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3">กิจกรรมและข่าวสาร</h1>
        <p class="lead opacity-75">ติดตามความเคลื่อนไหวและกิจกรรมต่างๆ ของงานสวนพฤกษศาสตร์โรงเรียน</p>
    </div>
</div>

<div class="news-container">
    <div class="container">
        <?php if(empty($news)): ?>
            <div class="card border-0 shadow-sm rounded-4 p-5 text-center">
                <i class="bi bi- megaphone fs-1 text-muted mb-3"></i>
                <h4 class="text-muted">ยังไม่มีข้อมูลข่าวสารในขณะนี้</h4>
                <p class="mb-0">โปรดติดตามอัปเดตจากเราได้เร็วๆ นี้</p>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach($news as $v): ?>
                <div class="col-lg-4 col-md-6 animate__animated animate__fadeInUp">
                    <a href="<?= base_url('botany/newsdetail/'.$v->news_id) ?>" class="text-decoration-none h-100 d-block">
                        <article class="news-card">
                            <div class="news-img-wrapper">
                                <?php if($v->news_img): ?>
                                    <img src="<?= base_url('uploads/botany/news/'.$v->news_img) ?>" alt="<?= $v->news_title ?>">
                                <?php else: ?>
                                    <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=1000&auto=format&fit=crop" alt="Default News">
                                <?php endif; ?>
                                <div class="news-date-badge">
                                    <i class="bi bi-calendar3 me-1"></i> <?= date('d M Y', strtotime($v->news_date)) ?>
                                </div>
                            </div>
                            <div class="news-body">
                                <h3 class="news-title"><?= $v->news_title ?></h3>
                                <p class="news-excerpt"><?= strip_tags($v->news_content) ?></p>
                                <span class="read-more">
                                    อ่านรายละเอียดเพิ่มเติม <i class="bi bi-arrow-right"></i>
                                </span>
                            </div>
                        </article>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
