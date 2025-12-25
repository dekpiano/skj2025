<!-- Page Header Start -->
<div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s"
    style="background: linear-gradient(rgba(0, 0, 0, .5), rgba(0, 0, 0, .5)), url(<?= base_url('uploads/news/'.$news->news_img) ?>) center center no-repeat; background-size: cover;">
    <div class="container text-center py-5">
        <h1 class="display-4 text-white animated slideInDown mb-3"><?= esc($news->news_topic) ?></h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="<?= base_url('/') ?>">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a class="text-white" href="<?= base_url('News') ?>">ประชาสัมพันธ์</a></li>
                <li class="breadcrumb-item text-primary active" aria-current="page">รายละเอียด</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- News Detail Start -->
<div class="">
    <div class="container">
        <div class="row g-5">
            <!-- Main News Content -->
            <div class="col-lg-8">
                <article class="news-article">
                    <!-- News Image -->
                    <div class="mb-4">
                        <img class="img-fluid rounded w-100" src="<?= base_url('../../uploads/news/'.$news->news_img) ?>" alt="<?= esc($news->news_topic) ?>">
                    </div>

                    <!-- News Meta -->
                    <div class="d-flex justify-content-between align-items-center text-muted mb-4">
                        <span><i class="fa fa-calendar-alt me-2"></i><?= $dateThai->thai_date_fullmonth(strtotime($news->news_date)) ?></span>
                        <span><i class="fa fa-eye me-2"></i><?= $news->news_view ?> Views</span>
                    </div>

                    <!-- News Content -->
                    <div class="news-content">
                        <?= $news->news_content; ?>
                    </div>
                </article>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Search Form -->
                <div class="bg-light rounded p-4 mb-5 wow fadeInUp" data-wow-delay="0.1s">
                    <form method="get" action="<?= base_url('News') ?>" id="sidebarSearchForm" autocomplete="off">
                        <div class="input-group position-relative">
                            <input type="text" class="form-control p-3" id="sidebarSearchInput" name="search" placeholder="ค้นหาข่าว...">
                            <button type="submit" class="btn btn-primary px-4"><i class="bi bi-search"></i></button>
                            <div id="sidebar-suggestions-list" class="list-group position-absolute w-100"></div>
                        </div>
                    </form>
                </div>

                <!-- Recent & Popular News -->
                <div class="bg-light rounded p-4 mb-5 wow fadeInUp" data-wow-delay="0.1s">
                    <h3 class="mb-4">ข่าวอื่นๆ</h3>
                    <ul class="nav nav-pills d-flex justify-content-between border-bottom mb-3">
                        <li class="nav-item">
                            <a class="d-flex align-items-center text-start active" data-bs-toggle="pill" href="#tab-1">
                                <h5 class="mb-0">ล่าสุด</h5>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="d-flex align-items-center text-start" data-bs-toggle="pill" href="#tab-2">
                                <h5 class="mb-0">ยอดนิยม</h5>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane fade show p-0 active">
                            <?php foreach ($NewsLatest as $key => $v_NewsLatest):?>
                            <div class="d-flex align-items-center border-bottom py-3">
                                <img class="img-fluid rounded-circle flex-shrink-0" src="<?= base_url('../../uploads/news/'.$v_NewsLatest->news_img) ?>" style="width: 60px; height: 60px; object-fit: cover;" alt="">
                                <div class="ps-3">
                                    <a href="<?= base_url('News/Detail/'.$v_NewsLatest->news_id);?>" class="d-block h6 mb-2 CountReadNews" data_view="<?=$v_NewsLatest->news_view?>" news_id="<?=$v_NewsLatest->news_id?>">
                                        <?= mb_strimwidth(esc($v_NewsLatest->news_topic), 0, 50, "..."); ?>
                                    </a>
                                    <span class="text-muted small"><i class="fa fa-eye me-2"></i><?= $v_NewsLatest->news_view ?> ครั้ง</span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div id="tab-2" class="tab-pane fade p-0">
                            <!-- Popular news content would go here. You might need to fetch this data from your controller. -->
                            <p class="text-center pt-3">ยังไม่มีข้อมูล</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- News Detail End -->

<style>
    .news-article {
        background-color: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    .news-content {
        font-family: 'Sarabun', sans-serif; 
        font-size: 1.1rem; 
        line-height: 1.8; 
        color: #333; 
    }

    .news-content h1, .news-content h2, .news-content h3 {
        margin-top: 1.5em;
        margin-bottom: 0.8em;
        color: #111;
    }

    .news-content p {
        margin-bottom: 1.2em;
    }

    .news-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin-top: 1em;
        margin-bottom: 1em;
    }

    /* Sidebar Search Suggestions */
    #sidebar-suggestions-list {
        z-index: 999;
        top: 100%;
        background-color: #ffffff;
        border: 1px solid #ced4da;
        border-top: none;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .highlight {
        background-color: #fff3cd;
        font-weight: bold;
    }
</style>