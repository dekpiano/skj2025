<style>
    .group-header {
        position: relative;
        padding: 120px 0 100px;
        background: linear-gradient(rgba(26, 42, 77, 0.8), rgba(26, 42, 77, 0.8)), 
                    url(<?= base_url('uploads/background/bg-contact.jpg') ?>) center center no-repeat;
        background-size: cover;
        border-radius: 0 0 60px 60px;
        text-align: center;
        margin-bottom: 50px;
    }

    .group-header h1 {
        font-weight: 900;
        letter-spacing: 1px;
        font-size: 3.5rem;
        margin-bottom: 15px;
        color: #fff;
    }

    .group-card {
        background: #fff;
        border-radius: 25px;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.02);
        height: 100%;
        text-decoration: none !important;
    }

    .group-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(36, 159, 253, 0.15);
        border-color: rgba(36, 159, 253, 0.2);
    }

    .group-card-body {
        padding: 30px;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .group-icon-wrapper {
        width: 70px;
        height: 70px;
        background: #1877F2; /* Facebook Blue */
        color: #fff;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .group-card:hover .group-icon-wrapper {
        transform: rotate(-10deg) scale(1.1);
        box-shadow: 0 10px 20px rgba(24, 119, 242, 0.3);
    }

    .group-info h4 {
        font-weight: 800;
        color: #1a2a4d;
        margin-bottom: 5px;
        font-size: 1.25rem;
        transition: all 0.3s ease;
    }

    .group-card:hover .group-info h4 {
        color: #249ffd;
    }

    .group-tag {
        display: inline-block;
        padding: 4px 12px;
        background: #f0f2f5;
        color: #65676b;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .group-card:hover .group-tag {
        background: rgba(36, 159, 253, 0.1);
        color: #249ffd;
    }

    @media (max-width: 767px) {
        .group-header {
            padding: 80px 20px;
            border-radius: 0 0 40px 40px;
        }
        .group-header h1 {
            font-size: 2.2rem;
        }
        .group-card-body {
            padding: 20px;
        }
        .group-icon-wrapper {
            width: 60px;
            height: 60px;
            font-size: 1.75rem;
        }
    }
</style>

<div class="group-header wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <h1 class="display-4 slideInDown mb-3"><?= esc($title) ?></h1>
        <p class="text-white-50 fs-5 mb-0">ช่องทางการติดตามกลุ่มสาระและความเคลื่อนไหวภายในโรงเรียน</p>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0 mt-4">
                <li class="breadcrumb-item"><a class="text-white-50" href="<?= base_url('/') ?>">หน้าแรก</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page"><?= esc($title) ?></li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 700px;">
            <h6 class="section-title bg-white text-center text-primary px-3 mb-4">Community</h6>
            <h2 class="display-6 mb-4">ติดตามข่าวสารผ่านกลุ่ม Facebook</h2>
        </div>

        <div class="row g-4">
            <!-- Item 1 -->
            <div class="col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.1s">
                <a class="group-card d-block" href="https://www.facebook.com/%E0%B8%A0%E0%B8%B2%E0%B8%A9%E0%B8%B2%E0%B9%84%E0%B8%97%E0%B8%A2-%E0%B8%AA%E0%B8%81%E0%B8%88-1866513180276025" target="_blank">
                    <div class="group-card-body">
                        <div class="group-icon-wrapper">
                            <i class="fab fa-facebook-f"></i>
                        </div>
                        <div class="group-info">
                            <h4>ภาษาไทย สกจ.</h4>
                            <span class="group-tag">กลุ่มสาระการเรียนรู้</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Item 2 -->
            <div class="col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.2s">
                <a class="group-card d-block" href="https://www.facebook.com/SKJSCITECH" target="_blank">
                    <div class="group-card-body">
                        <div class="group-icon-wrapper">
                            <i class="fab fa-facebook-f"></i>
                        </div>
                        <div class="group-info">
                            <h4>Science Technology SKJ</h4>
                            <span class="group-tag">กลุ่มสาระการเรียนรู้</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Item 3 -->
            <div class="col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.3s">
                <a class="group-card d-block" href="https://www.facebook.com/profile.php?id=100057093924087" target="_blank">
                    <div class="group-card-body">
                        <div class="group-icon-wrapper">
                            <i class="fab fa-facebook-f"></i>
                        </div>
                        <div class="group-info">
                            <h4>Math SKJ</h4>
                            <span class="group-tag">กลุ่มสาระการเรียนรู้</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Item 4 -->
            <div class="col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.4s">
                <a class="group-card d-block" href="https://www.facebook.com/SKJ.social/" target="_blank">
                    <div class="group-card-body">
                        <div class="group-icon-wrapper">
                            <i class="fab fa-facebook-f"></i>
                        </div>
                        <div class="group-info">
                            <h4>สังคมศึกษา สกจ.นว</h4>
                            <span class="group-tag">กลุ่มสาระการเรียนรู้</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Item 5 -->
            <div class="col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.5s">
                <a class="group-card d-block" href="https://www.facebook.com/skjcommittee" target="_blank">
                    <div class="group-card-body">
                        <div class="group-icon-wrapper">
                            <i class="fab fa-facebook-f"></i>
                        </div>
                        <div class="group-info">
                            <h4>คณะกรรมการนักเรียน</h4>
                            <span class="group-tag">กิจกรรมนักเรียน</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Item 6 -->
            <div class="col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.6s">
                <a class="group-card d-block" href="https://www.facebook.com/profile.php?id=100069532533076" target="_blank">
                    <div class="group-card-body">
                        <div class="group-icon-wrapper">
                            <i class="fab fa-facebook-f"></i>
                        </div>
                        <div class="group-info">
                            <h4>CHEER CLUB SKJ</h4>
                            <span class="group-tag">ชมรม/กิจกรรม</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
