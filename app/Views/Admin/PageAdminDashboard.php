<?= $this->extend('Admin/layout/AdminLayout') ?>

<?= $this->section('content') ?>
<?php
    $thai_months = [
        1 => 'มกราคม', 2 => 'กุมภาพันธ์', 3 => 'มีนาคม', 4 => 'เมษายน',
        5 => 'พฤษภาคม', 6 => 'มิถุนายน', 7 => 'กรกฎาคม', 8 => 'สิงหาคม',
        9 => 'กันยายน', 10 => 'ตุลาคม', 11 => 'พฤศจิกายน', 12 => 'ธันวาคม'
    ];
    $today_d = date('j');
    $today_m = $thai_months[(int)date('n')];
    $today_y = (int)date('Y') + 543;
    $thai_date_formatted = "$today_d $today_m $today_y";
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Top Header & Date Badge -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1 text-dark d-flex align-items-center gap-2">
                <span>แดชบอร์ดภาพรวม</span>
                <span class="badge bg-label-primary fs-tiny fw-semibold">Executive Dashboard</span>
            </h4>
            <p class="text-muted mb-0 small">ยินดีต้อนรับสู่ระบบบริหารจัดการข้อมูลสารสนเทศเว็บไซต์โรงเรียน</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <div class="d-flex align-items-center bg-white px-3 py-2 rounded-3 border shadow-xs">
                <i class="bx bx-calendar text-primary me-2 fs-5"></i>
                <span class="small fw-semibold text-dark"><?= $thai_date_formatted ?></span>
            </div>
            <span class="badge bg-label-success px-3 py-2 rounded-3 d-flex align-items-center gap-1">
                <span class="badge-dot bg-success me-1" style="width: 8px; height: 8px; border-radius: 50%; display: inline-block;"></span>
                <span>ระบบออนไลน์</span>
            </span>
        </div>
    </div>

    <!-- Hero Welcome Banner -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="luxury-welcome-banner p-4 p-md-5">
                <div class="row align-items-center position-relative" style="z-index: 2;">
                    <div class="col-lg-8">
                        <div class="badge bg-white text-primary px-3 py-1 rounded-pill mb-3 fw-bold shadow-sm" style="font-size: 0.78rem;">
                            <i class="bx bxs-badge-check me-1"></i> SKJ Management Portal
                        </div>
                        <h3 class="text-white fw-bolder mb-2" style="font-size: 1.85rem; letter-spacing: -0.02em;">
                            สวัสดีคุณ <?= session('AdminFullname') ?? 'ผู้ดูแลระบบ' ?> ✨
                        </h3>
                        <p class="text-white text-opacity-85 mb-4" style="max-width: 620px; font-size: 0.95rem; line-height: 1.6;">
                            ยินดีต้อนรับเข้าสู่ระบบจัดการเนื้อหาเว็บไซต์โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์ วันนี้มีผู้เข้าชมเว็บไซต์ <span class="text-warning fw-bold"><?= number_format($visitorStats['VisitToday'] ?? 0) ?></span> คน และมีการบันทึกการทำงานในระบบ <span class="text-info fw-bold"><?= number_format($todayLogs) ?></span> รายการ
                        </p>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="<?= base_url('Admin/Logs') ?>" class="btn btn-sm btn-light text-primary px-3 py-2 fw-semibold shadow-sm">
                                <i class="bx bx-history me-1"></i> ประวัติการใช้งานระบบ
                            </a>
                            <a href="<?= base_url('Admin/News') ?>" class="btn btn-sm btn-outline-light px-3 py-2 fw-semibold">
                                <i class="bx bx-plus-circle me-1"></i> จัดการข่าวสาร
                            </a>
                            <a href="<?= base_url('/') ?>" target="_blank" class="btn btn-sm btn-outline-light px-3 py-2 fw-semibold">
                                <i class="bx bx-link-external me-1"></i> หน้าเว็บไซต์หลัก
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 text-center d-none d-lg-block">
                        <img src="<?= base_url('assets/admin/assets/img/illustrations/man-with-laptop-light.png') ?>" 
                             alt="Admin Illustration" 
                             class="img-fluid" 
                             style="max-height: 180px; filter: drop-shadow(0 15px 25px rgba(0,0,0,0.3)); transform: translateY(10px);">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Row -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex flex-wrap gap-2 align-items-center">
                <span class="text-muted small fw-semibold me-2"><i class="bx bx-bolt-circle me-1 text-warning"></i>คำสั่งด่วน:</span>
                <a href="<?= base_url('Admin/News') ?>" class="quick-action-pill">
                    <i class="bx bx-news text-primary"></i>
                    <span>เขียนข่าวใหม่</span>
                </a>
                <a href="<?= base_url('Admin/Banner') ?>" class="quick-action-pill">
                    <i class="bx bx-images text-info"></i>
                    <span>เปลี่ยนแบนเนอร์</span>
                </a>
                <a href="<?= base_url('Admin/LiveChat') ?>" class="quick-action-pill">
                    <i class="bx bx-chat text-success"></i>
                    <span>ตอบแชทสด</span>
                </a>
                <a href="<?= base_url('Admin/WelcomeModal') ?>" class="quick-action-pill">
                    <i class="bx bx-bell text-danger"></i>
                    <span>ป๊อปอัปแจ้งเตือน</span>
                </a>
                <a href="<?= base_url('Admin/Student') ?>" class="quick-action-pill">
                    <i class="bx bx-wifi text-secondary"></i>
                    <span>ข้อมูลเน็ตนักเรียน</span>
                </a>
            </div>
        </div>
    </div>

    <!-- KPI Metric Cards Grid -->
    <div class="row g-4 mb-4">
        <!-- News Card -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card-luxury h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="stat-icon-wrapper stat-icon-indigo">
                            <i class="bx bx-news"></i>
                        </div>
                        <span class="badge bg-label-primary">เผยแพร่แล้ว</span>
                    </div>
                    <span class="text-muted small d-block mb-1">ข่าวประชาสัมพันธ์ทั้งหมด</span>
                    <div class="d-flex align-items-baseline gap-2">
                        <h3 class="fw-bolder mb-0 text-dark"><?= number_format($countNews) ?></h3>
                        <span class="text-muted small">รายการ</span>
                    </div>
                    <div class="mt-3 pt-2 border-top d-flex justify-content-between align-items-center">
                        <a href="<?= base_url('Admin/News') ?>" class="small fw-semibold text-primary d-flex align-items-center">
                            จัดการข่าวสาร <i class="bx bx-chevron-right ms-1"></i>
                        </a>
                        <span class="badge bg-label-secondary" style="font-size: 0.68rem;">News Hub</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Banner Card -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card-luxury h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="stat-icon-wrapper stat-icon-cyan">
                            <i class="bx bx-images"></i>
                        </div>
                        <span class="badge bg-label-info">หน้าแรก</span>
                    </div>
                    <span class="text-muted small d-block mb-1">แบนเนอร์สไลด์</span>
                    <div class="d-flex align-items-baseline gap-2">
                        <h3 class="fw-bolder mb-0 text-dark"><?= number_format($countBanner) ?></h3>
                        <span class="text-muted small">ภาพสไลด์</span>
                    </div>
                    <div class="mt-3 pt-2 border-top d-flex justify-content-between align-items-center">
                        <a href="<?= base_url('Admin/Banner') ?>" class="small fw-semibold text-info d-flex align-items-center">
                            จัดการแบนเนอร์ <i class="bx bx-chevron-right ms-1"></i>
                        </a>
                        <span class="badge bg-label-secondary" style="font-size: 0.68rem;">Slide Banner</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Visitors Card -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card-luxury h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="stat-icon-wrapper stat-icon-amber">
                            <i class="bx bx-user-check"></i>
                        </div>
                        <span class="badge bg-label-warning">วันนี้ <?= number_format($visitorStats['VisitToday'] ?? 0) ?></span>
                    </div>
                    <span class="text-muted small d-block mb-1">ผู้เข้าชมเว็บไซต์รวม</span>
                    <div class="d-flex align-items-baseline gap-2">
                        <h3 class="fw-bolder mb-0 text-dark"><?= number_format($visitorStats['visitAll'] ?? 0) ?></h3>
                        <span class="text-muted small">ครั้ง</span>
                    </div>
                    <div class="mt-3 pt-2 border-top d-flex justify-content-between align-items-center">
                        <span class="small text-muted">เดือนนี้: <strong class="text-dark"><?= number_format($visitorStats['visitMouth'] ?? 0) ?></strong></span>
                        <span class="badge bg-label-secondary" style="font-size: 0.68rem;">Analytics</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Logs Card -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card-luxury h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="stat-icon-wrapper stat-icon-emerald">
                            <i class="bx bx-pulse"></i>
                        </div>
                        <span class="badge bg-label-success">วันนี้ <?= number_format($todayLogs) ?></span>
                    </div>
                    <span class="text-muted small d-block mb-1">บันทึกกิจกรรมทั้งหมด</span>
                    <div class="d-flex align-items-baseline gap-2">
                        <h3 class="fw-bolder mb-0 text-dark"><?= number_format($countLogs) ?></h3>
                        <span class="text-muted small">บันทึก</span>
                    </div>
                    <div class="mt-3 pt-2 border-top d-flex justify-content-between align-items-center">
                        <a href="<?= base_url('Admin/Logs') ?>" class="small fw-semibold text-success d-flex align-items-center">
                            ดูบันทึกทั้งหมด <i class="bx bx-chevron-right ms-1"></i>
                        </a>
                        <span class="badge bg-label-secondary" style="font-size: 0.68rem;">System Logs</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid: Recent Activity & Quick Navigation -->
    <div class="row g-4">
        <!-- Left: Recent Logs Activity Feed -->
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title text-dark fw-bold mb-1">
                            <i class="bx bx-time-five me-2 text-primary"></i>ประวัติการใช้งานล่าสุด
                        </h5>
                        <small class="text-muted">บันทึกกิจกรรมล่าสุดของเจ้าหน้าที่และผู้ดูแลระบบ</small>
                    </div>
                    <a href="<?= base_url('Admin/Logs') ?>" class="btn btn-sm btn-outline-primary">
                        ดูทั้งหมด <i class="bx bx-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width: 25%;">วัน-เวลา</th>
                                <th style="width: 30%;">ผู้ใช้งาน</th>
                                <th style="width: 45%;">กิจกรรม / หน้าที่เข้าใช้งาน</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recentLogs)): ?>
                                <?php foreach ($recentLogs as $log): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="bx bx-calendar text-muted me-2 small"></i>
                                                <small class="text-dark fw-semibold"><?= date('d/m/Y H:i', strtotime($log['log_created_at'])) ?></small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-xs me-2">
                                                    <span class="avatar-initial rounded-circle bg-label-primary small fw-bold">
                                                        <?= mb_substr($log['log_user_name'] ?? 'A', 0, 1, 'UTF-8') ?>
                                                    </span>
                                                </div>
                                                <span class="fw-semibold text-dark small"><?= $log['log_user_name'] ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-label-secondary text-truncate d-inline-block" style="max-width: 280px;" title="<?= $log['log_url'] ?>">
                                                <?= $log['log_url'] ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">
                                        <i class="bx bx-info-circle me-1"></i> ยังไม่มีบันทึกการใช้งานในระบบ
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right: School Content & Settings Shortcuts -->
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title text-dark fw-bold mb-1">
                        <i class="bx bx-cog me-2 text-primary"></i>ควบคุมและจัดการระบบ
                    </h5>
                    <small class="text-muted">ทางลัดจัดการข้อมูลและโครงสร้างสำคัญ</small>
                </div>
                <div class="card-body">
                    <!-- Super Admin Control -->
                    <div class="p-3 rounded-3 bg-light border mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar avatar-xs">
                                    <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-shield-quarter"></i></span>
                                </div>
                                <span class="fw-bold text-dark small">จัดการสิทธิ์ผู้ใช้งาน</span>
                            </div>
                            <?php if (in_array('Super Admin', session('roles') ?? [])): ?>
                                <a href="<?= base_url('Admin/roles') ?>" class="btn btn-xs btn-primary">จัดการ</a>
                            <?php else: ?>
                                <span class="badge bg-label-secondary" style="font-size: 0.65rem;">Super Admin</span>
                            <?php endif; ?>
                        </div>
                        <p class="small text-muted mb-0" style="font-size: 0.78rem;">กำหนดบทบาทและสิทธิ์การเข้าถึงเมนูต่างๆ ของเจ้าหน้าที่</p>
                    </div>

                    <!-- Festival & Theme Setting -->
                    <div class="p-3 rounded-3 bg-light border mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar avatar-xs">
                                    <span class="avatar-initial rounded bg-label-success"><i class="bx bx-party"></i></span>
                                </div>
                                <span class="fw-bold text-dark small">ธีมเทศกาลเว็บไซต์</span>
                            </div>
                            <?php if (in_array('Super Admin', session('roles') ?? [])): ?>
                                <a href="<?= base_url('Admin/Settings') ?>" class="btn btn-xs btn-outline-success">ตั้งค่า</a>
                            <?php else: ?>
                                <span class="badge bg-label-secondary" style="font-size: 0.65rem;">Super Admin</span>
                            <?php endif; ?>
                        </div>
                        <p class="small text-muted mb-0" style="font-size: 0.78rem;">เปิด-ปิด เทศกาลพิเศษ เช่น หิมะตก หรือเอฟเฟกต์ตกแต่ง</p>
                    </div>

                    <hr class="my-3">

                    <!-- About School List -->
                    <h6 class="fw-bold text-dark mb-2 small d-flex align-items-center justify-content-between">
                        <span><i class="bx bx-buildings me-1 text-info"></i> เมนูเกี่ยวกับโรงเรียน</span>
                        <span class="badge bg-label-primary px-2" style="font-size: 0.68rem;">ข้อมูลทั่วไป</span>
                    </h6>
                    <ul class="list-unstyled mb-0">
                        <?php if (!empty($AboutSchool)) : ?>
                            <?php foreach (array_slice($AboutSchool, 0, 4) as $v_AboutSchool) : ?>
                                <li class="py-2 border-bottom d-flex align-items-center justify-content-between">
                                    <span class="small text-dark text-truncate me-2" style="max-width: 200px;">
                                        <i class="bx bx-check text-success me-1"></i><?= $v_AboutSchool->about_menu ?>
                                    </span>
                                    <a href="<?= base_url('Admin/AboutSchool/Detail/' . $v_AboutSchool->id) ?>" 
                                       class="btn btn-xs btn-icon btn-outline-primary" title="แก้ไข">
                                        <i class="bx bx-chevron-right"></i>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="small text-muted py-2">ไม่มีข้อมูลเมนูเกี่ยวกับโรงเรียน</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
