<style>
    .counter-parallax-section {
        background: linear-gradient(rgba(1, 33, 67, 0.8), rgba(1, 33, 67, 0.85)), url('<?= base_url('uploads/background/bg-video1.jpg') ?>');
        background-attachment: fixed;
        background-position: center;
        background-size: cover;
        padding: 120px 0;
        color: #fff;
        position: relative;
    }

    .stat-box-modern {
        text-align: center;
        padding: 30px 20px;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(5px);
        border-radius: 30px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .stat-box-modern:hover {
        transform: translateY(-10px);
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.3);
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }

    .stat-icon-modern {
        font-size: 2.5rem;
        margin-bottom: 20px;
        display: block;
        color: var(--secondary);
        filter: drop-shadow(0 0 10px rgba(36, 159, 253, 0.5));
    }

    .stat-num-modern {
        font-size: 4rem;
        font-weight: 900;
        display: block;
        line-height: 1;
        margin-bottom: 10px;
        font-family: 'K2D', sans-serif;
    }

    .stat-label-modern {
        font-size: 1rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: rgba(255, 255, 255, 0.8);
    }

    .stat-divider {
        width: 30px;
        height: 4px;
        background: var(--primary);
        margin: 15px auto;
        border-radius: 10px;
    }

    @media (max-width: 991px) {
        .stat-num-modern { font-size: 2.22rem; }
        .stat-label-modern { font-size: 0.75rem; letter-spacing: 1px; }
        .counter-parallax-section { padding: 80px 0; }
        .stat-box-modern { padding: 15px 5px; border-radius: 15px; }
        .stat-icon-modern { font-size: 1.8rem; margin-bottom: 10px; }
        .stat-divider { margin: 8px auto; height: 2px; width: 20px; }
    }

    @media (max-width: 575px) {
        .stat-num-modern { font-size: 1.5rem; }
        .stat-label-modern { font-size: 0.65rem; }
    }
</style>

<div class="counter-parallax-section">
    <div class="container">
        <div class="row g-2 g-md-4">
            <!-- นักเรียน -->
            <div class="col-3 col-md-3 wow fadeInUp" data-wow-delay="0.1s">
                <div class="stat-box-modern">
                    <i class="bi bi-person-check-fill stat-icon-modern"></i>
                    <span class="stat-num-modern" data-toggle="counter-up"><?= $ConutStudent[0]->C_ALL_Stu; ?></span>
                    <div class="stat-divider"></div>
                    <p class="stat-label-modern">นักเรียน</p>
                </div>
            </div>

            <!-- บุคลากร -->
            <div class="col-3 col-md-3 wow fadeInUp" data-wow-delay="0.2s">
                <div class="stat-box-modern">
                    <i class="bi bi-award-fill stat-icon-modern"></i>
                    <span class="stat-num-modern" data-toggle="counter-up"><?= $count_personnel ?></span>
                    <div class="stat-divider"></div>
                    <p class="stat-label-modern">บุคลากร</p>
                </div>
            </div>

            <!-- อาคาร -->
            <div class="col-3 col-md-3 wow fadeInUp" data-wow-delay="0.3s">
                <div class="stat-box-modern">
                    <i class="bi bi-building-fill stat-icon-modern"></i>
                    <span class="stat-num-modern" data-toggle="counter-up">15</span>
                    <div class="stat-divider"></div>
                    <p class="stat-label-modern">อาคาร</p>
                </div>
            </div>

            <!-- กลุ่มสาระฯ -->
            <div class="col-3 col-md-3 wow fadeInUp" data-wow-delay="0.4s">
                <div class="stat-box-modern">
                    <i class="bi bi-book-half stat-icon-modern"></i>
                    <span class="stat-num-modern" data-toggle="counter-up"><?= $count_learning ?></span>
                    <div class="stat-divider"></div>
                    <p class="stat-label-modern">กลุ่มสาระ</p>
                </div>
            </div>
        </div>
    </div>
</div>

