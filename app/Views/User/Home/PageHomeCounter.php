<style>
    .counter-parallax-section {
        background: linear-gradient(rgba(36, 159, 253, 0.85), rgba(36, 159, 253, 0.95)), url('<?= base_url('uploads/background/parallax-bg.jpg') ?>');
        background-attachment: fixed;
        background-position: center;
        background-size: cover;
        padding: 100px 0;
        color: #fff;
    }

    .stat-box-modern {
        text-align: center;
        padding: 20px;
        transition: all 0.3s ease;
    }

    .stat-box-modern:hover {
        transform: translateY(-10px);
    }

    .stat-icon-modern {
        font-size: 3rem;
        margin-bottom: 20px;
        display: block;
        color: #fff;
        opacity: 0.9;
    }

    .stat-num-modern {
        font-size: 3.5rem;
        font-weight: 800;
        display: block;
        line-height: 1;
        margin-bottom: 10px;
        font-family: 'Outfit', sans-serif;
    }

    .stat-label-modern {
        font-size: 1.1rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        opacity: 0.8;
    }

    .stat-divider {
        width: 50px;
        height: 3px;
        background: #FB7E9C;
        margin: 15px auto;
        border-radius: 2px;
    }

    @media (max-width: 991px) {
        .stat-num-modern { font-size: 2.5rem; }
        .stat-label-modern { font-size: 0.9rem; }
        .counter-parallax-section { padding: 60px 0; }
    }
</style>

<div class="counter-parallax-section wow fadeIn" data-wow-delay="0.2s">
    <div class="container">
        <div class="row g-4">
            <!-- นักเรียน -->
            <div class="col-6 col-md-3 wow fadeInUp" data-wow-delay="0.1s">
                <div class="stat-box-modern">
                    <i class="bi bi-people stat-icon-modern"></i>
                    <span class="stat-num-modern" data-toggle="counter-up"><?= $ConutStudent[0]->C_ALL_Stu; ?></span>
                    <div class="stat-divider"></div>
                    <p class="stat-label-modern">นักเรียนทั้งหมด</p>
                </div>
            </div>

            <!-- บุคลากร -->
            <div class="col-6 col-md-3 wow fadeInUp" data-wow-delay="0.2s">
                <div class="stat-box-modern">
                    <i class="bi bi-person-badge stat-icon-modern"></i>
                    <span class="stat-num-modern" data-toggle="counter-up"><?= $count_personnel ?></span>
                    <div class="stat-divider"></div>
                    <p class="stat-label-modern">บุคลากรสายวิชาการ</p>
                </div>
            </div>

            <!-- อาคาร -->
            <div class="col-6 col-md-3 wow fadeInUp" data-wow-delay="0.3s">
                <div class="stat-box-modern">
                    <i class="bi bi-building stat-icon-modern"></i>
                    <span class="stat-num-modern" data-toggle="counter-up">15</span>
                    <div class="stat-divider"></div>
                    <p class="stat-label-modern">อาคารสิ่งก่อสร้าง</p>
                </div>
            </div>

            <!-- กลุ่มสาระฯ -->
            <div class="col-6 col-md-3 wow fadeInUp" data-wow-delay="0.4s">
                <div class="stat-box-modern">
                    <i class="bi bi-journal-check stat-icon-modern"></i>
                    <span class="stat-num-modern" data-toggle="counter-up"><?= $count_learning ?></span>
                    <div class="stat-divider"></div>
                    <p class="stat-label-modern">กลุ่มสาระการเรียนรู้</p>
                </div>
            </div>
        </div>
    </div>
</div>

