<!-- Add Quill CSS for proper content rendering -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

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
                        <img class="img-fluid rounded w-100" src="<?= base_url('uploads/news/'.$news->news_img) ?>" 
                             onerror="this.onerror=null;this.src='https://placehold.co/800x450?text=No+Image';this.classList.add('d-none');" 
                             alt="<?= esc($news->news_topic) ?>">
                    </div>

                    <!-- News Meta -->
                    <div class="d-flex justify-content-between align-items-center text-muted mb-4">
                        <span><i class="fa fa-calendar-alt me-2"></i><?= $dateThai->thai_date_fullmonth(strtotime($news->news_date)) ?></span>
                        <span><i class="fa fa-eye me-2"></i><?= $news->news_view ?> Views</span>
                    </div>

                    <!-- News Content - Wrapped in ql-editor/ql-snow class for Quill styles -->
                    <div class="news-content ql-snow">
                        <div class="ql-editor" style="padding: 0; white-space: normal;">
                            <?php 
                                // แปลงเว้นวรรค 2 ตัวขึ้นไป ให้เป็น &nbsp; เพื่อรักษาย่อหน้า
                                $content = $news->news_content;
                                // แทนที่ Tab (\t) ด้วย &nbsp; 4 ตัว
                                $content = str_replace("\t", '&nbsp;&nbsp;&nbsp;&nbsp;', $content);
                                // แทนที่ Space 2 ตัวติดกัน ด้วย &nbsp; 2 ตัว (ทำซ้ำเผื่อมีหลายอัน)
                                $content = str_replace("  ", "&nbsp;&nbsp;", $content);
                                
                                echo $content;
                            ?>
                        </div>
                    </div>

                    <?php if (!empty($NewsAlbum)): ?>
                        <div class="mt-5 pt-4 border-top">
                            <h4 class="mb-4"><i class="fa fa-images text-primary me-2"></i> อัลบั้มรูปภาพ</h4>
                            <div class="row g-3">
                                <?php foreach ($NewsAlbum as $img): ?>
                                    <div class="col-md-4 col-6">
                                        <a href="<?= base_url('uploads/news/album/'.$img['news_img_name']) ?>" 
                                           data-lightbox="news-album" 
                                           data-title="<?= esc($news->news_topic) ?>">
                                            <div class="album-img-wrapper rounded overflow-hidden shadow-sm">
                                                <img src="<?= base_url('uploads/news/album/'.$img['news_img_name']) ?>" 
                                                     class="img-fluid w-100 h-100" 
                                                     style="object-fit: cover; min-height: 180px;"
                                                     loading="lazy"
                                                     alt="<?= esc($news->news_topic) ?>">
                                            </div>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
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
        line-height: 1.5; /* ลดลงจาก 1.8 */
        color: #333; 
    }

    .news-content h1, .news-content h2, .news-content h3 {
        margin-top: 1em;
        margin-bottom: 0.5em;
        color: #111;
    }

    .news-content p {
        margin-top: 0;
        margin-bottom: 0.5em; /* ลดลงจาก 1.2em ให้กระชับขึ้น */
        
        /* จัดข้อความให้ชิดซ้ายขวาพอดีกัน (Justify) */
        text-align: justify;
        text-justify: inter-word;
    }

    /* แก้ปัญหากด Enter รัวๆ แล้วมันห่างเกินไป */
    .news-content p:empty {
        display: none;
    }
    
    /* Responsive Video Embeds */
    .ql-editor iframe {
        width: 100%;
        min-height: 350px;
        border: none;
        border-radius: 8px;
        margin: 1rem 0;
    }
    
    /* Quill Alignment & Indentation Classes */
    .ql-align-center { text-align: center; }
    .ql-align-right { text-align: right; }
    .ql-align-justify { text-align: justify; }
    
    /* Force Quill Indent styles */
    .ql-editor .ql-indent-1 { padding-left: 3em !important; }
    .ql-editor .ql-indent-2 { padding-left: 6em !important; }
    .ql-editor .ql-indent-3 { padding-left: 9em !important; }
    .ql-editor .ql-indent-4 { padding-left: 12em !important; }
    .ql-editor .ql-indent-5 { padding-left: 15em !important; }
    .ql-editor .ql-indent-6 { padding-left: 18em !important; }
    .ql-editor .ql-indent-7 { padding-left: 21em !important; }
    .ql-editor .ql-indent-8 { padding-left: 24em !important; }
    
    /* ถ้าต้องการให้ย่อหน้าแรกของทุก p ขยับ (แบบหนังสือไทย) */
    /* .news-content p { text-indent: 2.5em; } */
    
    .ql-editor blockquote {
        border-left: 4px solid #ccc;
        margin-bottom: 5px;
        margin-top: 5px;
        padding-left: 16px;
        font-style: italic;
        background: #f9f9f9;
        padding: 1rem;
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

    .album-img-wrapper {
        position: relative;
        transition: 0.3s;
        cursor: pointer;
    }
    .album-img-wrapper:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
        z-index: 1;
    }
</style>