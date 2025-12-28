<style>
    .counter-wrapper {
        padding: 30px 0;
        background: linear-gradient(135deg, #f8faff 0%, #fff 100%);
        position: relative;
        overflow: hidden;
    }

    .counter-wrapper::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 150px;
        height: 150px;
        background: rgba(36, 159, 253, 0.03);
        border-radius: 50%;
    }

    .counter-wrapper::after {
        content: '';
        position: absolute;
        bottom: -30px;
        left: -30px;
        width: 100px;
        height: 100px;
        background: rgba(251, 126, 156, 0.03);
        border-radius: 50%;
    }

    .stat-card-premium {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.8);
        border-radius: 24px;
        padding: 15px 10px;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        height: 100%;
        position: relative;
    }

    .stat-card-premium:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
        background: #fff;
    }

    .stat-icon-wrap {
        width: 48px;
        height: 48px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
        transition: all 0.3s ease;
    }

    .stat-card-premium:hover .stat-icon-wrap {
        transform: scale(1.1) rotate(-5deg);
    }

    /* Blue Theme */
    .theme-blue .stat-icon-wrap {
        background: linear-gradient(135deg, #249ffd, #0a7ed6);
        color: #fff;
        box-shadow: 0 8px 15px rgba(36, 159, 253, 0.2);
    }
    
    /* Pink Theme */
    .theme-pink .stat-icon-wrap {
        background: linear-gradient(135deg, #FB7E9C, #e65c7d);
        color: #fff;
        box-shadow: 0 8px 15px rgba(251, 126, 156, 0.2);
    }

    .stat-content {
        flex-grow: 1;
    }

    .count-num {
        display: block;
        font-size: 1.5rem;
        font-weight: 800;
        color: #1a2a4d;
        line-height: 1;
        margin-bottom: 2px;
        font-family: 'Outfit', sans-serif;
    }

    .count-label {
        display: block;
        font-size: 0.75rem;
        color: #666;
        font-weight: 700;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    @media (max-width: 991px) {
        .stat-card-premium {
            padding: 12px 10px;
            gap: 10px;
        }
        .stat-icon-wrap {
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
            border-radius: 12px;
        }
        .count-num {
            font-size: 1.25rem;
        }
        .count-label {
            font-size: 0.7rem;
        }
    }

    @media (max-width: 575px) {
        .counter-wrapper {
            padding: 20px 0;
        }
        .stat-card-premium {
            margin-bottom: 8px;
            border-radius: 18px;
        }
    }
</style>

<div class="counter-wrapper">
    <div class="container">
        <div class="row g-3 g-lg-4 justify-content-center">
            <!-- นักเรียน -->
            <div class="col-6 col-md-3 wow fadeInUp" data-wow-delay="0.1s">
                <div class="stat-card-premium theme-blue">
                    <div class="stat-icon-wrap">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="stat-content">
                        <span class="count-num" data-toggle="counter-up"><?= $ConutStudent[0]->C_ALL_Stu; ?></span>
                        <p class="count-label">นักเรียน</p>
                    </div>
                </div>
            </div>

            <!-- บุคลากร -->
            <div class="col-6 col-md-3 wow fadeInUp" data-wow-delay="0.2s">
                <div class="stat-card-premium theme-pink">
                    <div class="stat-icon-wrap">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <div class="stat-content">
                        <span class="count-num" data-toggle="counter-up"><?= $count_personnel ?></span>
                        <p class="count-label">บุคลากร</p>
                    </div>
                </div>
            </div>

            <!-- อาคาร -->
            <div class="col-6 col-md-3 wow fadeInUp" data-wow-delay="0.3s">
                <div class="stat-card-premium theme-blue">
                    <div class="stat-icon-wrap">
                        <i class="bi bi-building"></i>
                    </div>
                    <div class="stat-content">
                        <span class="count-num" data-toggle="counter-up">15</span>
                        <p class="count-label">อาคาร</p>
                    </div>
                </div>
            </div>

            <!-- กลุ่มสาระฯ -->
            <div class="col-6 col-md-3 wow fadeInUp" data-wow-delay="0.4s">
                <div class="stat-card-premium theme-pink">
                    <div class="stat-icon-wrap">
                        <i class="bi bi-journal-check"></i>
                    </div>
                    <div class="stat-content">
                        <span class="count-num" data-toggle="counter-up"><?= $count_learning ?></span>
                        <p class="count-label">กลุ่มสาระฯ</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
