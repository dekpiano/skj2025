<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title><?= $title ?> | SKJ</title>
    <meta name="description" content="<?= $description ?? 'งานสวนพฤกษศาสตร์โรงเรียน สวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์' ?>" />
    <meta
        content="โรงเรียนสวนกุหลาบวิทยาลัย,โรงเรียน,สวนกุหลาบ,จิรประวัติ,นครสวรรค์,สวนกุหลาบจิรประวัติ,โรงเรียนสวนกุหลาบ"
        name="keywords">
    <meta http-equiv="content-language" content="th" />
    <meta name="robots" content="index, follow" />
    <meta name="revisit-after" content="1 day" />
    <meta name="author" content="Dekpiano" />
    <meta property="og:url" content="<?= $full_url ?>" />
    <meta property="og:title" content="<?= $title ?> | SKJ" />
    <meta property="og:description" content="<?= $description ?? 'งานสวนพฤกษศาสตร์โรงเรียน สวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์' ?>" />
    <meta property="og:type" content="website" />
    <?php if ($uri->getSegment(1) == "News" && $uri->getSegment(2) == "Detail") : ?>
    <meta property="og:image" content="<?= $banner; ?>" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <?php else: ?>
    <meta property="og:image" content="<?= base_url('uploads/banner/Banner-skj-main.png') ?>" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <?php endif; ?>

    <!-- Favicon -->
    <link href="<?=base_url()?>/uploads/logoSchool/LogoSKJ_4.png" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=K2D:wght@400;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="<?=base_url()?>/assets/lib/animate/animate.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css" rel="stylesheet">
    <link href="<?=base_url()?>/assets/lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?=base_url()?>/assets/css/bootstrap.min.css?v=4" rel="stylesheet">

    <!-- Slick Carousel -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>

    <link href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <!-- Template Stylesheet -->
    <link href="<?=base_url()?>/assets/css/style.css?v=10" rel="stylesheet">
    <link href="<?=base_url()?>/assets/css/media.css?v=5" rel="stylesheet">
    
    <?php if(isset($festival_status) && $festival_status == 'on'): ?>
    <!-- New Year Theme -->
    <link href="<?=base_url()?>/assets/css/newyear_snow.css" rel="stylesheet">
    <script src="<?=base_url()?>/assets/js/newyear_snow.js" defer></script>
    <?php endif; ?>

    <!-- Cookie Consent by https://www.cookiewow.com -->
    <!-- <script type="text/javascript" src="https://cookiecdn.com/cwc.js"></script>
    <script id="cookieWow" type="text/javascript" src="https://cookiecdn.com/configs/npYemaQ118ypmUfmagcae3jg" data-cwcid="npYemaQ118ypmUfmagcae3jg"></script> -->
   
</head>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-4XVY09LWJ8"></script>
<script>
window.dataLayer = window.dataLayer || [];

function gtag() {
    dataLayer.push(arguments);
}
gtag('js', new Date());

gtag('config', 'G-4XVY09LWJ8');
</script>


<body style="font-family: 'K2D', sans-serif;">

    <!-- <div class="ribbon">
        <img src="<?=base_url()?>/uploads/ari/black_ribbon_top_right.png" alt="ริบบิ้น" />
    </div> -->


    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border position-relative text-primary" style="width: 6rem; height: 6rem;" role="status">
        </div>
        <img data-src="<?=base_url('uploads/logoSchool/LogoSKJ_4.png')?>" style="width: 5rem; height: 5rem;" alt=""
            class="position-absolute top-50 start-50 translate-middle">

    </div>
    <!-- Spinner End -->
    <style>
    /* html, body {
        max-width: 100%;
        overflow-x: hidden;
        position: relative;
    } */
    /* body {
  -webkit-filter: grayscale(100%); /* Chrome, Safari, Opera */
    /* filter: grayscale(100%);

    } */

    .ribbon {
        position: absolute;
        top: 0px;
        right: 0px;
        /* transform: rotate(45deg); */
        z-index: 1000;
    }

    */

    /* // Extra small devices (portrait phones, less than 576px) */
    @media (max-width: 575px) {

        .blog-item .blog-text {
            padding: 10px;
        }

        .blog-item .blog-text a {
            font-size: 14px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .small {
            font-size: .4em !important;
        }
    }

    /* // Small devices (landscape phones, 576px and up) */
    @media (min-width: 576px) and (max-width: 767px) {}

    /* // Medium devices (tablets, 768px and up) */
    @media (min-width: 768px) and (max-width: 991px) {

        .blog-item .blog-text {
            padding: 10px;
        }

        .blog-item .blog-text a {
            font-size: 25px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .small {
            font-size: .8em !important;
        }
    }

    /* // Large devices (desktops, 992px and up) */
    @media (min-width: 992px) and (max-width: 1199px) {

        .blog-item .blog-text {
            padding: 10px;
        }

        .blog-item .blog-text a {
            font-size: 20px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .small {
            font-size: .8em !important;
        }
    }

    /* // Extra large devices (large desktops, 1200px and up) */
    @media (min-width: 1200px) {

        .blog-item .blog-text {
            padding: 10px;
        }

        .blog-item .blog-text a {
            font-size: 25px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .small {
            font-size: .875em !important;
        }
    }
    /* Global SKJ Page Headers */
    .skj-page-header {
        position: relative;
        padding: 120px 0 100px;
        background-attachment: fixed;
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
        border-radius: 0 0 60px 60px;
        text-align: center;
        margin-bottom: 50px;
        color: #fff;
        overflow: hidden;
        z-index: 1;
    }

    .skj-page-header::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(rgba(26, 42, 77, 0.75), rgba(26, 42, 77, 0.85));
        z-index: -1;
    }

    .skj-page-header h1 {
        font-weight: 900 !important;
        letter-spacing: 1px;
        font-size: clamp(2.2rem, 5vw, 3.5rem);
        margin-bottom: 20px;
        color: #fff !important;
        text-shadow: 0 4px 15px rgba(0,0,0,0.3);
    }

    .skj-page-header .breadcrumb-item {
        font-weight: 600;
        font-size: 0.95rem;
    }

    .skj-page-header .breadcrumb-item a { color: rgba(255,255,255,0.7) !important; }
    .skj-page-header .breadcrumb-item.active { color: #fff !important; }

    /* Specific Backgrounds for Sections */
    .header-about { background-image: url('<?= base_url('uploads/background/bg-about.jpg') ?>'); }
    .header-news { background-image: url('<?= base_url('uploads/background/bg-news.jpg') ?>'); }
    .header-personnel { background-image: url('<?= base_url('uploads/background/bg-personnal.jpg') ?>'); }
    .header-guidance { background-image: url('<?= base_url('uploads/background/bg-guidance.jpg') ?>'); }
    .header-academic { background-image: url('<?= base_url('uploads/background/bg-academic.jpg') ?>'); }

    /* Unified Subpage Spacing overrides for Fixed Navbar on Tablet & Mobile (viewports < 1200px) */
    @media (max-width: 1199px) {
        /* Tablet & iPad View */
        .skj-page-header {
            padding: 110px 20px 70px !important;
        }
        .skj-page-header.detail-header {
            margin-bottom: 0 !important;
            padding-bottom: 80px !important;
        }
        .main-news-img-wrapper {
            margin-top: 0 !important;
        }
        .container-fluid.page-header.py-5 {
            padding-top: 110px !important;
            padding-bottom: 60px !important;
        }
        .board-container, 
        .botany-container, 
        .botany-detail-container {
            padding-top: 120px !important;
            padding-bottom: 80px !important;
        }
        .news-header, 
        .course-header, 
        .group-header {
            padding-top: 125px !important;
            padding-bottom: 80px !important;
        }
        .news-detail-header {
            padding-top: 120px !important;
            padding-bottom: 40px !important;
        }
    }

    @media (max-width: 767px) {
        /* Smartphone View */
        .skj-page-header {
            padding: 100px 20px 60px !important;
            border-radius: 0 0 40px 40px;
            background-attachment: scroll;
        }
        .skj-page-header.detail-header {
            margin-bottom: 0 !important;
            padding-bottom: 50px !important;
        }
        .main-news-img-wrapper {
            margin-top: 0 !important;
        }
        .container-fluid.page-header.py-5 {
            padding-top: 95px !important;
            padding-bottom: 50px !important;
        }
        .board-container, 
        .botany-container, 
        .botany-detail-container {
            padding-top: 100px !important;
            padding-bottom: 60px !important;
        }
        .news-header, 
        .course-header, 
        .group-header {
            padding-top: 105px !important;
            padding-bottom: 60px !important;
        }
        .news-detail-header {
            padding-top: 100px !important;
            padding-bottom: 30px !important;
        }
    }
    </style>