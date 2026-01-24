<!-- Add Quill CSS for proper content rendering -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<style>
    .about-header {
        position: relative;
        padding: 120px 0 100px;
        background: linear-gradient(rgba(26, 42, 77, 0.8), rgba(26, 42, 77, 0.8)), 
                    url(<?= base_url('uploads/background/bg-about.jpg') ?>) center center no-repeat;
        background-size: cover;
        background-attachment: fixed;
        border-radius: 0 0 60px 60px;
        text-align: center;
        margin-bottom: -50px;
    }

    .about-header h1 {
        font-weight: 900;
        letter-spacing: 1px;
        font-size: 3.5rem;
        margin-bottom: 20px;
        color: #fff;
    }

    .about-content-card {
        background: #fff;
        border-radius: 40px;
        padding: 60px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.02);
        position: relative;
        z-index: 10;
        margin-bottom: 50px;
    }

    .about-article-title {
        font-weight: 900;
        color: #1a2a4d;
        font-size: 2.5rem;
        margin-bottom: 30px;
        position: relative;
        display: inline-block;
    }

    .about-article-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 60px;
        height: 5px;
        background: #249ffd;
        border-radius: 10px;
    }

    .about-text-content {
        font-family: 'Sarabun', sans-serif;
        font-size: 1.15rem;
        line-height: 1.9;
        color: #444;
    }

    .about-text-content p {
        margin-bottom: 1.5rem;
        text-align: justify;
    }

    .sidebar-widget {
        background: #fff;
        border-radius: 30px;
        padding: 35px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.02);
        position: sticky;
        top: 100px;
    }

    .sidebar-widget-title {
        font-weight: 800;
        color: #1a2a4d;
        font-size: 1.4rem;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 3px solid #f8f9fa;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .sidebar-widget-title i {
        color: #249ffd;
    }

    .about-nav-link {
        padding: 12px 20px;
        border-radius: 15px;
        color: #666;
        text-decoration: none;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 8px;
        font-weight: 600;
        background: #f8f9fa;
    }

    .about-nav-link:hover, .about-nav-link.active {
        background: #249ffd;
        color: #fff;
        transform: translateX(8px);
        box-shadow: 0 5px 15px rgba(36, 159, 253, 0.2);
    }

    .about-nav-link i {
        opacity: 0;
        transition: all 0.3s ease;
    }

    .about-nav-link:hover i, .about-nav-link.active i {
        opacity: 1;
        transform: translateX(5px);
    }

    @media (max-width: 991px) {
        .about-content-card {
            padding: 40px 30px;
            border-radius: 30px;
        }
        .about-article-title {
            font-size: 2rem;
        }
    }

    @media (max-width: 767px) {
        .about-header {
            padding: 80px 20px;
            border-radius: 0 0 40px 40px;
        }
        .about-header h1 {
            font-size: 2.2rem;
        }
        .about-content-card {
            padding: 30px 20px;
            border-radius: 25px;
            margin-top: 0;
        }
        .about-article-title {
            font-size: 1.75rem;
        }
        .about-text-content {
            font-size: 1.05rem;
        }
    }
</style>

<div class="skj-page-header header-about wow fadeIn" data-wow-delay="0.1s">
    <div class="container">
        <h1 class="slideInDown mb-3"><?= esc($AboutDetail->about_menu) ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0 mt-4">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">หน้าแรก</a></li>
                <li class="breadcrumb-item active" aria-current="page">เกี่ยวกับเรา</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-xxl py-5 mt-lg-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                <article class="about-content-card wow fadeInUp" data-wow-delay="0.2s">
                    <h2 class="about-article-title"><?= esc($AboutDetail->about_menu) ?></h2>
                    <div class="about-text-content ql-snow mt-4">
                        <div class="ql-editor p-0">
                            <?= $AboutDetail->about_detail ?>
                        </div>
                    </div>
                </article>
            </div>

            <div class="col-lg-4">
                <aside class="sidebar-widget wow fadeInRight" data-wow-delay="0.3s">
                    <h5 class="sidebar-widget-title">
                        <i class="bi bi-info-circle-fill"></i> ข้อมูลโรงเรียน
                    </h5>
                    <nav class="about-nav-list">
                        <?php foreach ($AboutSchool as $key => $value) : ?>
                            <?php $isActive = ($AboutDetail->about_menu == $value->about_menu) ? 'active' : ''; ?>
                            <a class="about-nav-link <?= $isActive ?>" href="<?= base_url('About/'.$value->about_menu) ?>">
                                <span><?= esc($value->about_menu) ?></span>
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        <?php endforeach; ?>
                    </nav>

                    <div class="mt-5 p-4 rounded-4" style="background: linear-gradient(45deg, #1a2a4d, #249ffd); color: #fff;">
                        <h6 class="fw-bold mb-3"><i class="bi bi-telephone-outbound-fill me-2"></i> สอบถามข้อมูลเพิ่มเติม</h6>
                        <p class="small mb-0 opacity-75">โทร: 056-009-667</p>
                        <p class="small mb-0 opacity-75">จันทร์ - ศุกร์ | 08.00 - 16.30 น.</p>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</div>