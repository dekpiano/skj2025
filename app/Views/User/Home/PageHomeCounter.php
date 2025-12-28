<style>
    .counter-wrapper {
        padding: 40px 0;
        background: #ffffff;
    }

    .stat-box {
        position: relative;
        padding: 20px 15px;
        text-align: center;
        border-radius: 20px;
        background: #fff;
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        height: 100%;
    }

    .stat-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    }

    .stat-box.pink { border-bottom: 4px solid #FB7E9C; }
    .stat-box.blue { border-bottom: 4px solid #249ffd; }

    .stat-icon {
        font-size: 1.8rem;
        margin-bottom: 10px;
        display: block;
    }

    .stat-box.pink .stat-icon { color: #FB7E9C; }
    .stat-box.blue .stat-icon { color: #249ffd; }

    .stat-box .count-num {
        font-size: 2rem;
        font-weight: 800;
        color: #1a2a4d;
        display: block;
        margin-bottom: 2px;
        line-height: 1.2;
    }

    .stat-box .count-label {
        font-size: 0.9rem;
        color: #777;
        font-weight: 600;
        margin: 0;
    }

    @media (max-width: 991px) {
        .counter-wrapper {
            padding: 30px 0;
        }
        .stat-box .count-num {
            font-size: 1.5rem;
        }
        .stat-box .count-label {
            font-size: 0.8rem;
        }
        .stat-icon {
            font-size: 1.4rem;
        }
    }
</style>

<div class="counter-wrapper wow fadeIn" data-wow-delay="0.1s">
    <div class="container">
        <div class="row g-3 justify-content-center">
            <!-- นักเรียน -->
            <div class="col-6 col-lg-3">
                <div class="stat-box blue">
                    <i class="bi bi-people-fill stat-icon"></i>
                    <span class="count-num" data-toggle="counter-up"><?= $ConutStudent[0]->C_ALL_Stu; ?></span>
                    <p class="count-label">นักเรียน</p>
                </div>
            </div>

            <!-- บุคลากร -->
            <div class="col-6 col-lg-3">
                <div class="stat-box pink">
                    <i class="bi bi-person-badge-fill stat-icon"></i>
                    <span class="count-num" data-toggle="counter-up"><?= $count_personnel ?></span>
                    <p class="count-label">บุคลากร</p>
                </div>
            </div>

            <!-- อาคาร -->
            <div class="col-6 col-lg-3">
                <div class="stat-box blue">
                    <i class="bi bi-building-fill stat-icon"></i>
                    <span class="count-num" data-toggle="counter-up">15</span>
                    <p class="count-label">อาคาร</p>
                </div>
            </div>

            <!-- สาระการเรียนรู้ -->
            <div class="col-6 col-lg-3">
                <div class="stat-box pink">
                    <i class="bi bi-layers-fill stat-icon"></i>
                    <span class="count-num" data-toggle="counter-up"><?= $count_learning ?></span>
                    <p class="count-label">กลุ่มสาระฯ</p>
                </div>
            </div>
        </div>
    </div>
</div>
