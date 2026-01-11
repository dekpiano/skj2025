<?= $this->extend('Manager/layout/ManagerLayout') ?>

<?= $this->section('content') ?>
<style>
    .welcome-card {
        background: linear-gradient(135deg, #FB7E9C 0%, #ffacbe 100%);
        color: #fff;
        border: none;
        border-radius: 20px;
        overflow: hidden;
    }
    .profile-section-img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 15px;
        border: 4px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .stat-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 15px;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
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
    .bg-light-primary { background: rgba(105, 108, 255, 0.1); color: #696cff; }
    .bg-light-success { background: rgba(113, 221, 55, 0.1); color: #71dd37; }
    .bg-light-info { background: rgba(3, 195, 236, 0.1); color: #03c3ec; }
    .bg-light-warning { background: rgba(255, 171, 0, 0.1); color: #ffab00; }
    .bg-light-danger { background: rgba(255, 62, 29, 0.1); color: #ff3e1d; }

    .user-greeting {
        font-size: 1.5rem;
        font-weight: 800;
        margin-bottom: 5px;
    }
    .user-subtitle {
        opacity: 0.9;
        font-size: 0.9rem;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <?php 
        $user = session('personnel');
        $fullname = session('AdminFullname');
        $img = $user['pers_img'] ? "https://personnel.skj.ac.th/uploads/admin/Personnal/".$user['pers_img'] : base_url('assets/admin/assets/img/avatars/1.png');
    ?>

    <div class="row">
        <!-- Personalized Welcome Card -->
        <div class="col-12 mb-4">
            <div class="card welcome-card shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center text-md-start mb-3 mb-md-0">
                            <img src="<?= $img ?>" class="profile-section-img" onerror="this.src='<?= base_url('assets/admin/assets/img/avatars/1.png') ?>'">
                        </div>
                        <div class="col-md-7 text-center text-md-start">
                            <div class="user-greeting">สวัสดีครับ, <?= $fullname ?> 👋</div>
                            <div class="user-subtitle">ยินดีต้อนรับเข้าใช้งานระบบรายงานข้อมูลสารสนเทศสำหรับผู้บริหาร</div>
                            <div class="mt-3">
                                <span class="badge bg-white text-primary rounded-pill px-3 py-2 fw-bold">
                                    <i class="bx bx-shield-check me-1"></i> ผู้บริหารสถานศึกษา
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3 text-center d-none d-md-block">
                             <img src="<?= base_url() ?>/assets/admin/assets/img/illustrations/man-with-laptop-light.png" height="150" alt="Executive Illustration" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Stats Group -->
        <div class="col-md-3 mb-4">
            <div class="card stat-card shadow-sm h-100">
                <div class="card-body">
                    <div class="icon-box bg-light-primary">
                        <i class="bx bx-group fs-3"></i>
                    </div>
                    <span class="fw-semibold d-block mb-1 text-muted">บุคลากรทั้งหมด</span>
                    <h3 class="card-title mb-2 fw-bold"><?= number_format($countPersonnel) ?></h3>
                    <small class="text-success fw-semibold"><i class="bx bx-check-circle"></i> ปฏิบัติงานปกติ</small>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card stat-card shadow-sm h-100">
                <div class="card-body">
                    <div class="icon-box bg-light-success">
                        <i class="bx bx-user fs-3"></i>
                    </div>
                    <span class="fw-semibold d-block mb-1 text-muted">นักเรียนทั้งหมด</span>
                    <h3 class="card-title mb-2 fw-bold"><?= number_format($countStudents) ?></h3>
                    <small class="text-success fw-semibold"><i class="bx bx-door-open"></i> กำลังศึกษา</small>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card stat-card shadow-sm h-100">
                <div class="card-body">
                    <div class="icon-box bg-light-info">
                        <i class="bx bx-globe fs-3"></i>
                    </div>
                    <span class="fw-semibold d-block mb-1 text-muted">ผู้ชมเว็บไซต์วันนี้</span>
                    <h3 class="card-title mb-2 fw-bold"><?= number_format($visitStats['VisitToday']) ?></h3>
                    <small class="text-info fw-semibold"><i class="bx bx-trending-up"></i> ยอดเข้าชมจริง</small>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card stat-card shadow-sm h-100">
                <div class="card-body">
                    <div class="icon-box bg-light-warning">
                        <i class="bx bx-news fs-3"></i>
                    </div>
                    <span class="fw-semibold d-block mb-1 text-muted">ข่าวประชาสัมพันธ์</span>
                    <h3 class="card-title mb-2 fw-bold"><?= number_format($countNews) ?></h3>
                    <small class="text-warning fw-semibold"><i class="bx bx-edit"></i> รายการทั้งหมด</small>
                </div>
            </div>
        </div>

        <!-- Distribution Charts -->
        <div class="col-md-7 mb-4">
            <div class="card stat-card shadow-sm h-100 border-0">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 fw-bold"><i class="bx bx-bar-chart-alt-2 me-2"></i>เปรียบเทียบสัดส่วนบุคลากรรายกลุ่มสาระ</h5>
                </div>
                <div class="card-body">
                    <div id="personnelGroupChart"></div>
                </div>
            </div>
        </div>

        <div class="col-md-5 mb-4">
            <div class="card stat-card shadow-sm h-100 border-0">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 fw-bold"><i class="bx bx-pie-chart-alt me-2"></i>สรุปการปฏิบัติงานวันนี้</h5>
                </div>
                <div class="card-body">
                    <div id="attendanceChart"></div>
                </div>
            </div>
        </div>

        <!-- Detailed Website Access Card -->
        <div class="col-md-8 mb-4">
            <div class="card stat-card shadow-sm shadow-none border">
                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2 fw-bold">สถิติการเข้าใช้งานเว็บไซต์</h5>
                        <small class="text-muted">ข้อมูลผู้ชมเว็บไซต์แยกตามช่วงเวลา</small>
                    </div>
                </div>
                <div class="card-body mt-4">
                    <div class="row g-3">
                        <div class="col-md-3 col-6 text-center border-end">
                            <h4 class="fw-bold mb-1"><?= number_format($visitStats['VisitToday']) ?></h4>
                            <small class="text-muted">วันนี้</small>
                        </div>
                        <div class="col-md-3 col-6 text-center border-end">
                            <h4 class="fw-bold mb-1"><?= number_format($visitStats['visitMouth']) ?></h4>
                            <small class="text-muted">เดือนนี้</small>
                        </div>
                        <div class="col-md-3 col-6 text-center border-end text-sm-center">
                            <h4 class="fw-bold mb-1"><?= number_format($visitStats['visitYear']) ?></h4>
                            <small class="text-muted">ปีนี้</small>
                        </div>
                        <div class="col-md-3 col-6 text-center">
                            <h4 class="fw-bold mb-1"><?= number_format($visitStats['visitAll']) ?></h4>
                            <small class="text-muted">ทั้งหมด</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Status or Quick Links -->
        <div class="col-md-4 mb-4">
            <div class="card stat-card shadow-sm bg-label-secondary border-0 h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-3"><i class="bx bx-link-external me-2"></i>ทางลัดส่วนตัว</h5>
                    <div class="d-grid gap-2">
                        <a href="<?= base_url('Manager/Personnel') ?>" class="btn btn-white shadow-sm text-start">
                            <i class="bx bx-user-pin me-2 text-primary"></i> ภาพรวมบุคลากร
                        </a>
                        <a href="<?= base_url('Manager/Academic') ?>" class="btn btn-white shadow-sm text-start">
                            <i class="bx bx-book-open me-2 text-success"></i> ข้อมูลวิชาการ
                        </a>
                        <a href="<?= base_url('/') ?>" target="_blank" class="btn btn-white shadow-sm text-start">
                            <i class="bx bx-globe me-2 text-info"></i> ไปหน้าเว็บไซต์
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const learningData = <?= json_encode($chart_learning) ?>;
    const leaveData = <?= json_encode($leaveStats) ?>;

    // 1. Personnel Learning Group Chart
    const personnelOptions = {
        series: [{
            name: 'จำนวนบุคลากร',
            data: learningData.data
        }],
        chart: {
            type: 'bar',
            height: 350,
            toolbar: { show: false }
        },
        plotOptions: {
            bar: {
                borderRadius: 4,
                distributed: true,
                horizontal: false,
            }
        },
        colors: ['#696cff', '#71dd37', '#03c3ec', '#ffab00', '#ff3e1d', '#8592a3', '#FB7E9C', '#249ffd'],
        dataLabels: { enabled: true },
        xaxis: {
            categories: learningData.labels,
            labels: {
                style: { fontSize: '12px' }
            }
        },
        legend: { show: false }
    };

    const personnelChart = new ApexCharts(document.querySelector("#personnelGroupChart"), personnelOptions);
    personnelChart.render();

    // 2. Attendance Summary Chart
    const attendanceOptions = {
        series: leaveData.data,
        labels: leaveData.labels,
        chart: {
            type: 'donut',
            height: 350
        },
        colors: ['#71dd37', '#ffab00', '#ff3e1d', '#03c3ec', '#696cff'],
        legend: {
            position: 'bottom'
        },
        dataLabels: { enabled: false },
        plotOptions: {
            pie: {
                donut: {
                    size: '70%',
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'ทั้งหมด',
                            formatter: function (w) {
                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                            }
                        }
                    }
                }
            }
        }
    };

    const attendanceChart = new ApexCharts(document.querySelector("#attendanceChart"), attendanceOptions);
    attendanceChart.render();
});
</script>
<?= $this->endSection() ?>
