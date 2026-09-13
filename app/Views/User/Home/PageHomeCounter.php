<style>
/* ==========================================================================
   COUNTER PARALLAX SECTION - LUXURY GLASS & STREAMLINED
   ดีไซน์ใหม่: กระชับ ได้สัดส่วน หรูหรา สไตล์ Frosted Crystal Glass
   ========================================================================== */
.counter-parallax-section {
    padding: 35px 0 45px 0;
    position: relative;
    background: transparent !important;
}

/* Floating Luxury Glass Island */
.counter-glass-card {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.78) 0%, rgba(255, 255, 255, 0.55) 100%);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.85);
    border-radius: 26px;
    padding: 28px 24px;
    box-shadow: 0 20px 45px -12px rgba(15, 23, 42, 0.08), 
                0 0 0 1px rgba(255, 255, 255, 0.6);
    position: relative;
    overflow: hidden;
}

/* Subtle top glow line */
.counter-glass-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 10%;
    right: 10%;
    height: 2px;
    background: linear-gradient(90deg, transparent, rgba(251, 126, 156, 0.5), rgba(36, 159, 253, 0.5), transparent);
}

.counter-stat-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 12px 14px;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    border-radius: 18px;
}

.counter-stat-item:hover {
    background: rgba(255, 255, 255, 0.65);
    transform: translateY(-3px);
}

/* Glowing Icon Squircles */
.counter-icon-wrap {
    width: 52px;
    height: 52px;
    flex-shrink: 0;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    color: #ffffff;
    box-shadow: 0 8px 18px -4px rgba(0, 0, 0, 0.15);
    transition: transform 0.3s ease;
}

.counter-stat-item:hover .counter-icon-wrap {
    transform: scale(1.08) rotate(3deg);
}

/* Luxury Color Gradients for Icons */
.icon-grad-blue {
    background: linear-gradient(135deg, #38bdf8 0%, #0284c7 100%);
    box-shadow: 0 8px 20px -4px rgba(2, 132, 199, 0.35);
}
.icon-grad-pink {
    background: linear-gradient(135deg, #fb7185 0%, #e11d48 100%);
    box-shadow: 0 8px 20px -4px rgba(225, 29, 72, 0.35);
}
.icon-grad-purple {
    background: linear-gradient(135deg, #c084fc 0%, #7c3aed 100%);
    box-shadow: 0 8px 20px -4px rgba(124, 58, 237, 0.35);
}
.icon-grad-teal {
    background: linear-gradient(135deg, #2dd4bf 0%, #0d9488 100%);
    box-shadow: 0 8px 20px -4px rgba(13, 148, 136, 0.35);
}

/* Counter Numbers & Labels */
.counter-info {
    display: flex;
    flex-direction: column;
}

.counter-num-wrap {
    display: flex;
    align-items: baseline;
    gap: 4px;
    line-height: 1;
}

.stat-num-val {
    font-size: 2.15rem;
    font-weight: 900;
    color: #0f172a;
    font-family: 'K2D', sans-serif;
    letter-spacing: -0.5px;
}

.stat-unit {
    font-size: 0.8rem;
    font-weight: 700;
    color: #64748b;
}

.stat-label-title {
    font-size: 0.92rem;
    font-weight: 700;
    color: #1e293b;
    margin-top: 4px;
    margin-bottom: 0;
    line-height: 1.2;
}

.stat-label-sub {
    font-size: 0.72rem;
    color: #94a3b8;
    margin-bottom: 0;
}

/* Desktop Separator Lines */
@media (min-width: 992px) {
    .counter-col-divider {
        border-right: 1px solid rgba(226, 232, 240, 0.8);
    }
    .counter-col-divider:last-child {
        border-right: none;
    }
}

/* Tablet & iPad Adjustments */
@media (max-width: 991px) {
    .counter-glass-card {
        padding: 20px 16px;
        border-radius: 20px;
    }
    .counter-stat-item {
        padding: 10px 8px;
        gap: 12px;
    }
    .counter-icon-wrap {
        width: 46px;
        height: 46px;
        font-size: 1.25rem;
        border-radius: 13px;
    }
    .stat-num-val {
        font-size: 1.85rem;
    }
    .stat-label-title {
        font-size: 0.85rem;
    }
}

/* Smartphone Adjustments */
@media (max-width: 575px) {
    .counter-parallax-section {
        padding: 20px 0 30px 0;
    }
    .counter-glass-card {
        padding: 16px 10px;
        border-radius: 18px;
    }
    .counter-stat-item {
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 10px 4px;
        gap: 6px;
    }
    .counter-info {
        align-items: center;
    }
    .counter-icon-wrap {
        width: 42px;
        height: 42px;
        font-size: 1.15rem;
    }
    .stat-num-val {
        font-size: 1.55rem;
    }
    .stat-label-title {
        font-size: 0.78rem;
    }
}
</style>

<div class="counter-parallax-section">
    <div class="container">
        <!-- Floating Glass Card -->
        <div class="counter-glass-card">
            <div class="row g-2 g-lg-0 align-items-center">
                <!-- 1. นักเรียน -->
                <div class="col-6 col-lg-3 counter-col-divider wow fadeInUp" data-wow-delay="0.1s">
                    <div class="counter-stat-item">
                        <div class="counter-icon-wrap icon-grad-blue">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="counter-info">
                            <div class="counter-num-wrap">
                                <span class="stat-num-val" data-toggle="counter-up"><?= $ConutStudent[0]->C_ALL_Stu ?? '0'; ?></span>
                                <span class="stat-unit">คน</span>
                            </div>
                            <h6 class="stat-label-title">นักเรียนทั้งหมด</h6>
                            <span class="stat-label-sub">ทุกระดับชั้นปีการศึกษา</span>
                        </div>
                    </div>
                </div>

                <!-- 2. บุคลากร -->
                <div class="col-6 col-lg-3 counter-col-divider wow fadeInUp" data-wow-delay="0.2s">
                    <div class="counter-stat-item">
                        <div class="counter-icon-wrap icon-grad-pink">
                            <i class="bi bi-person-badge-fill"></i>
                        </div>
                        <div class="counter-info">
                            <div class="counter-num-wrap">
                                <span class="stat-num-val" data-toggle="counter-up"><?= $count_personnel ?? '0' ?></span>
                                <span class="stat-unit">คน</span>
                            </div>
                            <h6 class="stat-label-title">ครูและบุคลากร</h6>
                            <span class="stat-label-sub">ผู้บริหารและสายสนับสนุน</span>
                        </div>
                    </div>
                </div>

                <!-- 3. อาคารสถานที่ -->
                <div class="col-6 col-lg-3 counter-col-divider wow fadeInUp" data-wow-delay="0.3s">
                    <div class="counter-stat-item">
                        <div class="counter-icon-wrap icon-grad-purple">
                            <i class="bi bi-buildings-fill"></i>
                        </div>
                        <div class="counter-info">
                            <div class="counter-num-wrap">
                                <span class="stat-num-val" data-toggle="counter-up">15</span>
                                <span class="stat-unit">หลัง</span>
                            </div>
                            <h6 class="stat-label-title">อาคารสถานที่</h6>
                            <span class="stat-label-sub">พร้อมสิ่งอำนวยความสะดวก</span>
                        </div>
                    </div>
                </div>

                <!-- 4. กลุ่มสาระการเรียนรู้ -->
                <div class="col-6 col-lg-3 counter-col-divider wow fadeInUp" data-wow-delay="0.4s">
                    <div class="counter-stat-item">
                        <div class="counter-icon-wrap icon-grad-teal">
                            <i class="bi bi-journal-bookmark-fill"></i>
                        </div>
                        <div class="counter-info">
                            <div class="counter-num-wrap">
                                <span class="stat-num-val" data-toggle="counter-up"><?= $count_learning ?? '8' ?></span>
                                <span class="stat-unit">กลุ่ม</span>
                            </div>
                            <h6 class="stat-label-title">กลุ่มสาระการเรียนรู้</h6>
                            <span class="stat-label-sub">หลักสูตรมาตรฐานสากล</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
