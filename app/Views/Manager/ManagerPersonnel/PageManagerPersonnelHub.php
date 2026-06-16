<?= $this->extend('Manager/layout/ManagerLayout') ?>

<?= $this->section('content') ?>
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #696cff, #4044ee);
        --warning-gradient: linear-gradient(135deg, #ffab00, #ffc233);
        --success-gradient: linear-gradient(135deg, #71dd37, #8ee85c);
        
        --card-bg-light: #ffffff;
        --card-border-color: rgba(67, 89, 113, 0.08);
        --text-muted-color: #8e9ba5;
    }

    /* Hub Header Styling */
    .hub-header {
        position: relative;
        background: #fff;
        border-radius: 16px;
        border: 1px solid var(--card-border-color);
        overflow: hidden;
    }
    
    .hub-header::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 300px;
        height: 100%;
        background: radial-gradient(circle, rgba(105, 108, 255, 0.08) 0%, rgba(255, 255, 255, 0) 70%);
        pointer-events: none;
    }

    .page-header-icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        background: var(--primary-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.8rem;
        box-shadow: 0 8px 20px rgba(105, 108, 255, 0.25);
    }

    /* Hub Card Styling */
    .hub-card {
        border: 1px solid var(--card-border-color);
        border-radius: 24px;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        overflow: hidden;
        position: relative;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        height: 100%;
        background: #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
    }

    .hub-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 24px 48px rgba(105, 108, 255, 0.08) !important;
        border-color: rgba(105, 108, 255, 0.2);
        color: inherit;
    }

    /* Card Glow Spot */
    .hub-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        filter: blur(50px);
        opacity: 0;
        transition: opacity 0.4s ease;
        pointer-events: none;
    }
    .hub-card.card-personnel:hover::before {
        background: rgba(105, 108, 255, 0.12);
        opacity: 1;
    }
    .hub-card.card-attendance:hover::before {
        background: rgba(255, 171, 0, 0.12);
        opacity: 1;
    }
    .hub-card.card-evaluation:hover::before {
        background: rgba(113, 221, 55, 0.12);
        opacity: 1;
    }

    /* Dynamic Border Indicator */
    .hub-card::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        transform: scaleX(0);
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        transform-origin: left;
    }
    .hub-card.card-personnel::after { background: var(--primary-gradient); }
    .hub-card.card-attendance::after { background: var(--warning-gradient); }
    .hub-card.card-evaluation::after { background: var(--success-gradient); }

    .hub-card:hover::after {
        transform: scaleX(1);
    }

    /* Icon Section */
    .hub-icon-wrapper {
        position: relative;
        display: inline-block;
        margin-bottom: 1.5rem;
    }

    .hub-icon {
        width: 76px;
        height: 76px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .hub-card.card-personnel .hub-icon { background: rgba(105, 108, 255, 0.07); color: #696cff; }
    .hub-card.card-attendance .hub-icon { background: rgba(255, 171, 0, 0.07); color: #ffab00; }
    .hub-card.card-evaluation .hub-icon { background: rgba(113, 221, 55, 0.07); color: #71dd37; }

    .hub-card:hover .hub-icon {
        transform: scale(1.08) rotate(3deg);
    }
    .hub-card.card-personnel:hover .hub-icon { background: var(--primary-gradient); color: #fff; box-shadow: 0 8px 20px rgba(105, 108, 255, 0.2); }
    .hub-card.card-attendance:hover .hub-icon { background: var(--warning-gradient); color: #fff; box-shadow: 0 8px 20px rgba(255, 171, 0, 0.2); }
    .hub-card.card-evaluation:hover .hub-icon { background: var(--success-gradient); color: #fff; box-shadow: 0 8px 20px rgba(113, 221, 55, 0.2); }

    /* Title & Desc */
    .hub-title {
        font-size: 1.35rem;
        font-weight: 700;
        color: #435971;
        margin-bottom: 0.6rem;
        transition: color 0.3s;
    }
    .hub-card:hover .hub-title {
        color: #2b3a4a;
    }

    .hub-desc {
        font-size: 0.9rem;
        color: #697a8d;
        margin-bottom: 1.8rem;
        line-height: 1.6;
    }

    /* Badges & Statistics */
    .hub-stat {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 30px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 1.2rem;
        width: fit-content;
        transition: all 0.3s;
        border: 1px solid transparent;
    }
    .hub-card.card-personnel .hub-stat { background: rgba(105, 108, 255, 0.06); color: #696cff; border-color: rgba(105, 108, 255, 0.1); }
    .hub-card.card-attendance .hub-stat { background: rgba(255, 171, 0, 0.06); color: #ffab00; border-color: rgba(255, 171, 0, 0.1); }
    .hub-card.card-evaluation .hub-stat { background: rgba(113, 221, 55, 0.06); color: #71dd37; border-color: rgba(113, 221, 55, 0.1); }

    .hub-card:hover .hub-stat {
        transform: scale(1.02);
    }

    /* Footer Action Area */
    .hub-footer {
        border-top: 1px dashed rgba(67, 89, 113, 0.08);
        padding-top: 1.25rem;
        margin-top: auto;
    }

    .sub-links {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    
    .sub-link {
        font-size: 0.8rem;
        font-weight: 500;
        padding: 6px 14px;
        border-radius: 10px;
        background: #f5f5f9;
        color: #566a7f;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: 1px solid transparent;
    }
    
    .sub-link:hover {
        background: #e7e7ff;
        color: #696cff;
        border-color: rgba(105, 108, 255, 0.15);
        transform: translateY(-2px);
    }

    .hub-arrow {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        border: 1px solid transparent;
    }
    
    .hub-card.card-personnel .hub-arrow { background: rgba(105, 108, 255, 0.06); color: #696cff; }
    .hub-card.card-attendance .hub-arrow { background: rgba(255, 171, 0, 0.06); color: #ffab00; }
    .hub-card.card-evaluation .hub-arrow { background: rgba(113, 221, 55, 0.06); color: #71dd37; }

    .hub-card:hover .hub-arrow {
        transform: translateX(4px);
    }
    .hub-card.card-personnel:hover .hub-arrow { background: #696cff; color: #fff; }
    .hub-card.card-attendance:hover .hub-arrow { background: #ffab00; color: #fff; }
    .hub-card.card-evaluation:hover .hub-arrow { background: #71dd37; color: #fff; }
</style>

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Page Header -->
    <div class="hub-header p-4 mb-4 shadow-sm">
        <div class="row align-items-center">
            <div class="col-12 col-md-8 d-flex align-items-center">
                <div class="page-header-icon me-3">
                    <i class="bx bx-group"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-1" style="color: #435971;">งานบุคลากร</h4>
                    <p class="text-muted mb-0">ระบบบริหารจัดการและประเมินผลสัมฤทธิ์ของบุคลากรภายในสถานศึกษา</p>
                </div>
            </div>
            <div class="col-12 col-md-4 text-md-end mt-3 mt-md-0">
                <span class="badge bg-label-primary p-2 px-3 rounded-pill">
                    <i class="bx bx-shield-quarter me-1"></i> ผู้บริหารสถานศึกษา
                </span>
            </div>
        </div>
    </div>

    <!-- Hub Cards -->
    <div class="row g-4">

        <!-- 1. Personnel Overview -->
        <div class="col-md-4">
            <a href="<?= base_url('Manager/Personnel/Overview') ?>" class="hub-card card-personnel p-4">
                <div class="hub-icon-wrapper">
                    <div class="hub-icon">
                        <i class="bx bx-user-pin"></i>
                    </div>
                </div>
                <h5 class="hub-title">ภาพรวมบุคลากร</h5>
                <div class="hub-stat">
                    <i class="bx bx-group"></i>
                    บุคลากรทั้งหมด <?= number_format($total_count) ?> ท่าน
                </div>
                <p class="hub-desc">ทำเนียบบุคลากร รายชื่อ ข้อมูลส่วนบุคคล สถิติบุคลากรแยกตามกลุ่มสาระ และวิเคราะห์สัดส่วนอัตรากำลัง</p>
                
                <div class="hub-footer d-flex justify-content-between align-items-center">
                    <div class="sub-links">
                        <span class="sub-link"><i class="bx bx-list-ul"></i> ทำเนียบ</span>
                        <span class="sub-link"><i class="bx bx-bar-chart"></i> สถิติ</span>
                    </div>
                    <div class="hub-arrow">
                        <i class="bx bx-right-arrow-alt"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- 2. Executive Attendance -->
        <div class="col-md-4">
            <a href="<?= base_url('Manager/ManagerAttendance') ?>" class="hub-card card-attendance p-4">
                <div class="hub-icon-wrapper">
                    <div class="hub-icon">
                        <i class="bx bx-time-five"></i>
                    </div>
                </div>
                <h5 class="hub-title">ลงเวลางานผู้บริหาร</h5>
                <div class="hub-stat">
                    <i class="bx bx-calendar-check"></i>
                    วันนี้: <?= date('d/m/Y') ?>
                </div>
                <p class="hub-desc">ระบบลงเวลาเข้า-ออกปฏิบัติราชการสำหรับคณะผู้บริหาร พร้อมประวัติบันทึกเวลางานรายเดือน</p>
                
                <div class="hub-footer d-flex justify-content-between align-items-center">
                    <div class="sub-links">
                        <object>
                            <a href="<?= base_url('Manager/ManagerAttendance') ?>" class="sub-link" onclick="event.stopPropagation()"><i class="bx bx-log-in"></i> เช็คอิน</a>
                        </object>
                        <object>
                            <a href="<?= base_url('Manager/ManagerAttendance/History') ?>" class="sub-link" onclick="event.stopPropagation()"><i class="bx bx-history"></i> ประวัติ</a>
                        </object>
                    </div>
                    <div class="hub-arrow">
                        <i class="bx bx-right-arrow-alt"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- 3. Performance Evaluation -->
        <div class="col-md-4">
            <a href="<?= base_url('Manager/Evaluation') ?>" class="hub-card card-evaluation p-4">
                <div class="hub-icon-wrapper">
                    <div class="hub-icon">
                        <i class="bx bx-check-shield"></i>
                    </div>
                </div>
                <h5 class="hub-title">ประเมินผลการปฏิบัติงาน</h5>
                <div class="hub-stat">
                    <i class="bx bx-check-circle"></i>
                    รอบการประเมินปัจจุบัน
                </div>
                <p class="hub-desc">การประเมินประสิทธิภาพประสิทธิผลการปฏิบัติงาน ตรวจสอบเอกสาร และสรุปผลคะแนนแบบออนไลน์</p>
                
                <div class="hub-footer d-flex justify-content-between align-items-center">
                    <div class="sub-links">
                        <object>
                            <a href="<?= base_url('Manager/Evaluation') ?>" class="sub-link" onclick="event.stopPropagation()"><i class="bx bx-search-alt"></i> ตรวจสอบ</a>
                        </object>
                        <object>
                            <a href="<?= base_url('Manager/Evaluation/Submit') ?>" class="sub-link" onclick="event.stopPropagation()"><i class="bx bx-upload"></i> ส่งผล</a>
                        </object>
                    </div>
                    <div class="hub-arrow">
                        <i class="bx bx-right-arrow-alt"></i>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
