<!-- Add Quill CSS for proper content rendering -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<style>
    .detail-header {
        position: relative;
        padding: 120px 0 160px;
        background: linear-gradient(rgba(26, 42, 77, 0.85), rgba(26, 42, 77, 0.85)), url(<?= base_url('uploads/news/'.$news->news_img) ?>) center center no-repeat;
        background-size: cover;
        background-attachment: fixed;
        border-radius: 0 0 80px 80px;
        text-align: center;
        margin-bottom: -60px;
    }

    .news-article-card {
        background: #fff;
        border-radius: 40px;
        padding: 50px;
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.03);
        position: relative;
        z-index: 10;
    }

    .main-news-img-wrapper {
        position: relative;
        z-index: 20;
        border-radius: 30px;
        overflow: hidden;
        box-shadow: 0 25px 50px rgba(0,0,0,0.2);
        margin-bottom: 40px;
        margin-top: -120px;
        border: 2px solid rgba(255, 255, 255, 0.5);
    }

    .main-news-img {
        width: 100%;
        height: auto;
        object-fit: cover;
        max-height: 600px;
    }

    .news-detail-meta {
        display: flex;
        gap: 25px;
        margin-bottom: 30px;
        padding-bottom: 25px;
        border-bottom: 1px solid #f0f0f0;
        color: #777;
    }

    .news-detail-meta i {
        color: var(--primary);
        font-size: 1.1rem;
    }

    .news-content-wrapper {
        font-family: 'Sarabun', sans-serif;
        font-size: 1.15rem;
        line-height: 1.8;
        color: #444;
    }

    .news-content-wrapper p {
        margin-bottom: 1.5rem;
        text-align: justify;
    }

    .album-title {
        font-weight: 800;
        color: #1a2a4d;
        margin: 60px 0 30px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .album-title::after {
        content: '';
        flex-grow: 1;
        height: 2px;
        background: #f0f0f0;
    }

    .album-item {
        border-radius: 20px;
        overflow: hidden;
        height: 220px;
        position: relative;
        transition: all 0.4s ease;
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }

    .album-item:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0,0,0,0.12);
    }

    .sidebar-widget {
        background: #fff;
        border-radius: 30px;
        padding: 30px;
        border: 1px solid rgba(0,0,0,0.03);
        box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        margin-bottom: 40px;
    }

    .sidebar-title {
        font-weight: 800;
        color: #1a2a4d;
        font-size: 1.4rem;
        margin-bottom: 25px;
        position: relative;
        padding-bottom: 12px;
    }

    .sidebar-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 4px;
        background: var(--primary);
        border-radius: 2px;
    }

    .recent-news-item {
        display: flex;
        gap: 15px;
        padding-bottom: 20px;
        margin-bottom: 20px;
        border-bottom: 1px solid #f8f9fa;
        transition: all 0.3s ease;
    }

    .recent-news-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .recent-news-img {
        width: 85px;
        height: 85px;
        border-radius: 15px;
        object-fit: cover;
        flex-shrink: 0;
    }

    .recent-news-info h6 {
        font-weight: 700;
        font-size: 0.95rem;
        line-height: 1.4;
        margin-bottom: 8px;
        color: #1a2a4d;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .recent-news-info a {
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .recent-news-info a:hover h6 {
        color: var(--primary);
    }

    .glass-search-sidebar {
        background: #f8f9fa;
        border: none;
        border-radius: 20px;
        padding: 15px 25px;
        font-size: 0.95rem;
    }

    .sidebar-search-btn {
        background: var(--primary);
        color: #fff;
        border: none;
        border-radius: 15px;
        padding: 0 20px;
        margin-left: 10px;
    }

    @media (max-width: 991px) {
        .news-article-card {
            padding: 30px;
            border-radius: 30px;
        }
        .main-news-img-wrapper {
            margin-top: -80px;
        }
    }
</style>

<div class="detail-header wow fadeIn" data-wow-delay="0.1s">
    <div class="container pb-5">
        <h1 class="display-5 text-white fw-bold slideInDown mb-4"><?= esc($news->news_topic) ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0 mt-4">
                <li class="breadcrumb-item"><a class="text-white-50" href="<?= base_url('/') ?>">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a class="text-white-50" href="<?= base_url('News') ?>">ข่าวประชาสัมพันธ์</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">รายละเอียดข่าว</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-5">
        <div class="col-lg-8">
            <div class="main-news-img-wrapper wow fadeInUp" data-wow-delay="0.2s">
                <img class="main-news-img" src="<?= base_url('uploads/news/'.$news->news_img) ?>" 
                     onerror="this.onerror=null;this.src='https://placehold.co/1200x600?text=SKJ+NEWS'; this.classList.add('d-none');" 
                     alt="<?= esc($news->news_topic) ?>">
            </div>

            <article class="news-article-card wow fadeInUp" data-wow-delay="0.3s">
                <div class="news-detail-meta">
                    <span><i class="bi bi-calendar3 me-2"></i> <?= $dateThai->thai_date_fullmonth(strtotime($news->news_date)) ?></span>
                    <span><i class="bi bi-eye me-2"></i> <?= number_format($news->news_view) ?> ครั้ง</span>
                    <span><i class="bi bi-person me-2"></i> Admin</span>
                </div>

                <div class="news-content-wrapper ql-snow">
                    <div class="ql-editor p-0">
                        <?php 
                            $content = $news->news_content;
                            $content = str_replace("\t", '&nbsp;&nbsp;&nbsp;&nbsp;', $content);
                            $content = str_replace("  ", "&nbsp;&nbsp;", $content);
                            echo $content;
                        ?>
                    </div>
                </div>

                <?php if (!empty($NewsAlbum)): ?>
                    <h4 class="album-title"><i class="bi bi-images text-primary me-2"></i> อัลบั้มรูปภาพ</h4>
                    <div class="row g-3">
                        <?php foreach ($NewsAlbum as $img): ?>
                            <div class="col-md-4 col-6">
                                <a href="<?= base_url('uploads/news/album/'.$img['news_img_name']) ?>" 
                                   data-lightbox="news-album" 
                                   data-title="<?= esc($news->news_topic) ?>">
                                    <div class="album-item">
                                        <img src="<?= base_url('uploads/news/album/'.$img['news_img_name']) ?>" 
                                             class="img-fluid w-100 h-100 object-fit-cover" 
                                             style="object-fit:cover"
                                             loading="lazy"
                                             alt="<?= esc($news->news_topic) ?>">
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </article>
        </div>

        <div class="col-lg-4">
            <div class="sidebar-widget wow fadeInUp" data-wow-delay="0.4s">
                <h5 class="sidebar-title">ค้นหาข่าวสาร</h5>
                <form method="get" action="<?= base_url('News') ?>" id="sidebarSearchForm" autocomplete="off">
                    <div class="d-flex position-relative">
                        <input type="text" class="form-control glass-search-sidebar" id="sidebarSearchInput" name="search" placeholder="พิมพ์คำค้นหา...">
                        <button type="submit" class="sidebar-search-btn"><i class="bi bi-search"></i></button>
                        <div id="sidebar-suggestions-list" class="list-group position-absolute w-100"></div>
                    </div>
                </form>
            </div>

            <div class="sidebar-widget wow fadeInUp" data-wow-delay="0.5s">
                <h5 class="sidebar-title">ข่าวประชาสัมพันธ์ล่าสุด</h5>
                <div class="recent-news-list">
                    <?php foreach ($NewsLatest as $v_NewsLatest):?>
                        <div class="recent-news-item">
                            <img class="recent-news-img" src="<?= base_url('uploads/news/'.$v_NewsLatest->news_img) ?>" alt="">
                            <div class="recent-news-info">
                                <a href="<?= base_url('News/Detail/'.$v_NewsLatest->news_id);?>" class="CountReadNews" data_view="<?=$v_NewsLatest->news_view?>" news_id="<?=$v_NewsLatest->news_id?>">
                                    <h6><?= mb_strimwidth(esc($v_NewsLatest->news_topic), 0, 60, "..."); ?></h6>
                                </a>
                                <div class="text-muted small">
                                    <i class="bi bi-calendar3 me-1"></i> <?= $dateThai->thai_date_fullmonth(strtotime($v_NewsLatest->news_date)) ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <a href="<?= base_url('News') ?>" class="btn btn-outline-primary w-100 mt-4 py-2 rounded-pill font-weight-bold">ดูข่าวทั้งหมด</a>
            </div>
        </div>
    </div>
</div>
