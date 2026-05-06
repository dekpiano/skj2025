<?= $this->extend('Admin/PageAdminBotany/layout/BotanyAdminLayout') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Welcome Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-label-success border-0 shadow-none">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="avatar avatar-xl me-3 bg-white rounded p-2">
                        <i class="bx bx-leaf fs-1 text-success"></i>
                    </div>
                    <div>
                        <h4 class="mb-1 fw-bold text-success">ยินดีต้อนรับเข้าสู่ระบบจัดการสวนพฤกษศาสตร์!</h4>
                        <p class="mb-0 opacity-75">คุณสามารถจัดการข้อมูลพรรณไม้ และติดตามความคืบหน้าของโครงการ อพ.สธ. ได้ที่นี่</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4 mb-4 mb-md-0">
            <div class="card shadow-sm h-100 border-0 border-bottom border-4 border-primary">
                <div class="card-body text-center p-4">
                    <div class="badge bg-label-primary p-3 rounded-circle mb-3">
                        <i class="bx bx-list-ul fs-3"></i>
                    </div>
                    <h2 class="fw-bold mb-1"><?= $total_plants ?></h2>
                    <p class="text-muted mb-0">พรรณไม้ทั้งหมด</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4 mb-md-0">
            <div class="card shadow-sm h-100 border-0 border-bottom border-4 border-success">
                <div class="card-body text-center p-4">
                    <div class="badge bg-label-success p-3 rounded-circle mb-3">
                        <i class="bx bx-check-circle fs-3"></i>
                    </div>
                    <h2 class="fw-bold mb-1 text-success"><?= $active_plants ?></h2>
                    <p class="text-muted mb-0">กำลังแสดงผลบนเว็บ</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100 border-0 border-bottom border-4 border-warning">
                <div class="card-body text-center p-4">
                    <div class="badge bg-label-warning p-3 rounded-circle mb-3">
                        <i class="bx bx-hide fs-3"></i>
                    </div>
                    <h2 class="fw-bold mb-1 text-warning"><?= $inactive_plants ?></h2>
                    <p class="text-muted mb-0">ปิดการแสดงผล</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Access & Info -->
    <div class="row">
        <!-- Quick Links -->
        <div class="col-lg-7 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <h5 class="card-title mb-0 fw-bold">เมนูจัดการด่วน</h5>
                </div>
                <div class="card-body pt-4">
                    <div class="row g-3">
                        <div class="col-6">
                            <a href="<?= base_url('admin/botany/list') ?>" class="d-block p-4 rounded-4 bg-light text-center text-decoration-none transition-hover border">
                                <i class="bx bx-plus-circle fs-1 text-primary mb-2"></i>
                                <h6 class="mb-0 fw-bold text-dark">เพิ่มพรรณไม้</h6>
                                <small class="text-muted">จัดการคลังข้อมูลพรรณไม้</small>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="#" class="d-block p-4 rounded-4 bg-light text-center text-decoration-none transition-hover border opacity-50">
                                <i class="bx bx-diagram-3 fs-1 text-success mb-2"></i>
                                <h6 class="mb-0 fw-bold text-dark">5 องค์ประกอบ</h6>
                                <small class="text-muted">ยังไม่เปิดใช้งาน</small>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="<?= base_url('admin/botany/news') ?>" class="d-block p-4 rounded-4 bg-light text-center text-decoration-none transition-hover border">
                                <i class="bx bx-news fs-1 text-warning mb-2"></i>
                                <h6 class="mb-0 fw-bold text-dark">กิจกรรม/ข่าว</h6>
                                <small class="text-muted">จัดการกิจกรรมสวนพฤกษศาสตร์</small>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="<?= base_url('botany') ?>" target="_blank" class="d-block p-4 rounded-4 bg-light text-center text-decoration-none transition-hover border">
                                <i class="bx bx-world fs-1 text-info mb-2"></i>
                                <h6 class="mb-0 fw-bold text-dark">ดูหน้าเว็บไซต์</h6>
                                <small class="text-muted">เปิดชมหน้า Landing Page</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Latest Update / Info -->
        <div class="col-lg-5 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header pb-0">
                    <h5 class="card-title mb-0 fw-bold">สถานะระบบ</h5>
                </div>
                <div class="card-body pt-4">
                    <ul class="p-0 m-0">
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-info"><i class="bx bx-user"></i></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0 fw-bold">ผู้เข้าใช้งานขณะนี้</h6>
                                    <small class="text-muted"><?= session('botany_fullname') ?></small>
                                </div>
                                <div class="user-progress">
                                    <span class="badge bg-label-success">Online</span>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-secondary"><i class="bx bx-time"></i></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0 fw-bold">เวลาเซิร์ฟเวอร์</h6>
                                    <small class="text-muted"><?= date('d F Y H:i') ?></small>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="alert alert-warning border-0 d-flex align-items-center" role="alert">
                        <i class="bx bx-info-circle me-2 fs-4"></i>
                        <div>
                            อย่าลืมตรวจสอบข้อมูลชื่อวิทยาศาสตร์ให้ถูกต้องตามมาตรฐาน อพ.สธ.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .transition-hover {
        transition: all 0.3s ease;
    }
    .transition-hover:hover {
        transform: translateY(-5px);
        background: #fff !important;
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        border-color: #52b788 !important;
    }
    .bg-label-success {
        background-color: #e8fadf !important;
        color: #71dd37 !important;
    }
</style>
<?= $this->endSection() ?>
