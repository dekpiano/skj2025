<?= $this->extend('Manager/layout/ManagerLayout') ?>

<?= $this->section('content') ?>
<style>
    .welcome-card {
        background: linear-gradient(135deg, #696cff 0%, #4044ee 100%);
        color: #fff;
        border: none;
        border-radius: 20px;
        position: relative;
        overflow: hidden;
    }
    .welcome-card::after {
        content: '';
        position: absolute;
        right: -50px;
        top: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    .profile-section-img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid rgba(255, 255, 255, 0.3);
    }
    .stat-card {
        border: none;
        border-radius: 16px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .stat-card:hover {
        transform: translateY(-5px);
    }
    .icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }
    .module-header {
        font-weight: 700;
        color: #566a7f;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .module-header::before {
        content: '';
        width: 4px;
        height: 24px;
        background: #696cff;
        border-radius: 10px;
    }
    .bg-light-primary { background: rgba(105, 108, 255, 0.1); color: #696cff; }
    .bg-light-success { background: rgba(113, 221, 55, 0.1); color: #71dd37; }
    .bg-light-info { background: rgba(3, 195, 236, 0.1); color: #03c3ec; }
    .bg-light-warning { background: rgba(255, 171, 0, 0.1); color: #ffab00; }
    .bg-light-danger { background: rgba(255, 62, 29, 0.1); color: #ff3e1d; }

    .progress-compact { height: 8px; border-radius: 10px; margin: 10px 0; }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <!-- Welcome Section -->
        <div class="col-12 mb-4">
            <div class="card welcome-card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <?php 
                            $userImg = session('AdminImage') ?? '';
                            $userName = session('AdminFullname') ?? 'Executive';
                            $initials = mb_substr($userName, 0, 1);
                            $hasImg = !empty($userImg);
                            $imgUrl = 'https://personnel.skj.ac.th/uploads/admin/Personnal/' . $userImg;
                        ?>
                        <div class="col-md-1 d-none d-md-block">
                            <?php if ($hasImg): ?>
                                <img src="<?= $imgUrl ?>" class="profile-section-img" onerror="this.src='<?= base_url('assets/admin/assets/img/avatars/1.png') ?>'">
                            <?php else: ?>
                                <div class="avatar avatar-xl">
                                    <span class="avatar-initial rounded-circle bg-white text-primary fw-bold fs-2"><?= $initials ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-8 ps-md-4">
                            <h4 class="text-white fw-bold mb-1">สวัสดีครับ, <?= session('AdminFullname') ?> 👋</h4>
                            <p class="mb-0 opacity-75">ยินดีต้อนรับสู่แดชบอร์ดผู้บริหาร ข้อมูลสรุปประจำวันที่ <?= date('d/m/Y') ?></p>
                            <span class="badge bg-white text-primary mt-2">ปีการศึกษา <?= $schoolyear['schyear_year'] ?? '-' ?></span>
                        </div>
                        <div class="col-md-3 text-end d-none d-md-block">
                             <a href="<?= base_url('logout') ?>" class="btn btn-outline-white btn-sm text-white border-white">
                                 <i class="bx bx-power-off me-1"></i> ออกจากระบบ
                             </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 1: Human Resources -->
        <div class="col-12">
            <h5 class="module-header">งานบุคลากร</h5>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card stat-card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="d-block mb-1 text-muted">บุคลากรทั้งหมด</span>
                            <h3 class="card-title mb-2 fw-bold text-primary"><?= number_format($countPersonnel) ?> <small class="fs-6 fw-normal">ท่าน</small></h3>
                        </div>
                        <div class="icon-box bg-light-primary"><i class="bx bx-group fs-3"></i></div>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="text-muted">ปฏิบัติงานปกติ</small>
                            <small class="fw-bold">100%</small>
                        </div>
                        <div class="progress progress-compact">
                            <div class="progress-bar bg-primary" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 mb-4">
            <div class="card stat-card shadow-sm h-100">
                <div class="card-body p-0">
                    <div class="row g-0 h-100">
                        <div class="col-md-4 p-4 border-end">
                            <h6 class="fw-bold mb-3">สรุปวันทำงาน</h6>
                            <div class="d-flex align-items-center mb-2">
                                <div class="badge bg-label-success p-2 me-2"><i class="bx bx-check"></i></div>
                                <div><small class="d-block text-muted">มาปกติ</small><span class="fw-bold"><?= $countPersonnel ?> ท่าน</span></div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div class="badge bg-label-warning p-2 me-2"><i class="bx bx-time"></i></div>
                                <div><small class="d-block text-muted">สาย/แจ้งลา</small><span class="fw-bold">0 ท่าน</span></div>
                            </div>
                        </div>
                        <div class="col-md-8 p-3">
                            <div id="learningSummaryChart" style="min-height: 150px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Academic & Students -->
        <div class="col-12">
            <h5 class="module-header">งานวิชาการและนักเรียน</h5>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card stat-card shadow-sm h-100">
                <div class="card-body">
                    <div class="icon-box bg-light-success"><i class="bx bx-user fs-3"></i></div>
                    <span class="d-block mb-1 text-muted">นักเรียนทั้งหมด</span>
                    <h3 class="card-title mb-1 fw-bold text-success"><?= number_format($student_stats['total']) ?> คน</h3>
                    <div class="mt-2 pt-1 border-top">
                        <div class="d-flex justify-content-between small">
                            <span>มัธยมต้น</span><span class="fw-bold"><?= number_format($student_stats['junior']) ?></span>
                        </div>
                        <div class="d-flex justify-content-between small">
                            <span>มัธยมปลาย</span><span class="fw-bold"><?= number_format($student_stats['senior']) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card stat-card shadow-sm h-100">
                <div class="card-body">
                    <div class="icon-box bg-light-danger"><i class="bx bx-book-content fs-3"></i></div>
                    <span class="d-block mb-1 text-muted">คุณภาพการสอน (0/ร/มส)</span>
                    <h3 class="card-title mb-1 fw-bold text-danger"><?= number_format($grade_summary['fail']) ?> รายการ</h3>
                    <div class="mt-2 pt-1 border-top">
                        <div class="d-flex justify-content-between small text-success">
                            <span>ผ่านเกณฑ์</span><span class="fw-bold"><?= number_format($grade_summary['pass']) ?></span>
                        </div>
                        <div class="progress progress-compact" style="height: 4px;">
                            <div class="progress-bar bg-success" style="width: <?= $grade_summary['pass'] > 0 ? round(($grade_summary['pass']/($grade_summary['pass']+$grade_summary['fail']))*100) : 0 ?>%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card stat-card shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h6 class="mb-0 fw-bold">ประสิทธิภาพบุคลากรสายผู้สอน</h6>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <div class="display-6 fw-bold text-primary"><?= $teacher_count ?></div>
                            <p class="text-muted mb-0">ครูผู้สอนประจำการ</p>
                        </div>
                        <div class="col-6 text-end">
                            <a href="<?= base_url('Manager/Academic/Teacher') ?>" class="btn btn-sm btn-label-primary">ดูรายละเอียดภาพรวม <i class="bx bx-right-arrow-alt"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 3: General Administration -->
        <div class="col-12">
            <h5 class="module-header">งานบริหารทั่วไป</h5>
        </div>
        <div class="row g-3 px-3 mb-4">
            <div class="col-md-3">
                <div class="card stat-card border h-100">
                    <div class="card-body text-center p-3">
                        <div class="avatar bg-label-warning rounded mb-3 mx-auto" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                            <i class="bx bx-calendar-event fs-3"></i>
                        </div>
                        <h4 class="fw-bold mb-1"><?= $general_stats['booking_pending'] ?></h4>
                        <p class="text-muted mb-0 small">จองห้องรออนุมัติ</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card border h-100">
                    <div class="card-body text-center p-3">
                        <div class="avatar bg-label-info rounded mb-3 mx-auto" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                            <i class="bx bx-car fs-3"></i>
                        </div>
                        <h4 class="fw-bold mb-1"><?= $general_stats['car_pending'] ?></h4>
                        <p class="text-muted mb-0 small">จองรถรออนุมัติ</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card border h-100">
                    <div class="card-body text-center p-3">
                        <div class="avatar bg-label-danger rounded mb-3 mx-auto" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                            <i class="bx bx-wrench fs-3"></i>
                        </div>
                        <h4 class="fw-bold mb-1"><?= $general_stats['repair_pending'] ?></h4>
                        <p class="text-muted mb-0 small">แจ้งซ่อมรอดำเนินการ</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <a href="<?= base_url('Manager/General') ?>" class="btn btn-primary h-100 w-100 d-flex flex-column justify-content-center align-items-center rounded-3">
                    <i class="bx bx-plus-circle fs-2 mb-2"></i>
                    <span>จัดการทั้งหมด</span>
                </a>
            </div>
        </div>

        <!-- Section 4: News & Website -->
        <div class="col-12">
            <h5 class="module-header">เว็บไซต์และข่าวประชาสัมพันธ์</h5>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card stat-card shadow-sm h-100 bg-dark">
                <div class="card-body text-white">
                    <h6 class="text-white-50">เข้าชมเว็บไซต์วันนี้</h6>
                    <h2 class="text-white fw-bold mb-4"><?= number_format($visitStats['VisitToday']) ?> <small class="fs-6 fw-normal">ครั้ง</small></h2>
                    <div class="d-flex justify-content-between mb-2">
                        <span>เดือนนี้</span><span class="fw-bold"><?= number_format($visitStats['visitMouth']) ?></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>ปีนี้</span><span class="fw-bold"><?= number_format($visitStats['visitYear']) ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 mb-4">
            <div class="card stat-card shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="fw-bold mb-1">ข่าวสารในระบบ</h5>
                        <p class="text-muted mb-3">ปัจจุบันมีข่าวประชาสัมพันธ์และประกาศทั้งหมด</p>
                        <h3 class="fw-bold text-warning"><?= number_format($countNews) ?> <small class="fs-6 fw-normal">รายการ</small></h3>
                    </div>
                    <div class="text-end ps-3">
                        <img src="<?= base_url('assets/admin/assets/img/illustrations/man-with-laptop-light.png') ?>" height="100">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const learningData = <?= json_encode($chart_learning) ?>;

    // 1. Personnel Learning Group Summary (Mini Bar)
    new ApexCharts(document.querySelector("#learningSummaryChart"), {
        series: [{ name: 'จำนวน', data: learningData.data }],
        chart: { type: 'bar', height: 160, toolbar: { show: false } },
        plotOptions: { 
            bar: { 
                borderRadius: 4, 
                distributed: true,
                columnWidth: '50%'
            } 
        },
        colors: ['#696cff', '#71dd37', '#03c3ec', '#ffab00', '#ff3e1d'],
        dataLabels: { enabled: false },
        xaxis: { 
            categories: learningData.labels,
            labels: { show: false }
        },
        yaxis: { show: false },
        tooltip: { y: { formatter: val => val + " ท่าน" } }
    }).render();
});
</script>
<?= $this->endSection() ?>
