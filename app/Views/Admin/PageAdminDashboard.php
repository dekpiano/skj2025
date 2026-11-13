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

    $user_img = session('personnel')['pers_img'] ?? null; 
    $avatar_src = $user_img ? "https://personnel.skj.ac.th/uploads/admin/Personnal/".$user_img : base_url('assets/admin/assets/img/avatars/1.png');
    $user_role = session('roles')[0] ?? 'Admin';
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Compact Modern Executive Header Bar -->
    <div class="card border-0 shadow-xs mb-3 bg-white" style="border-radius: 16px;">
        <div class="card-body p-3 p-md-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                <!-- User Greeting & Status -->
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md avatar-online position-relative">
                        <img src="<?= $avatar_src ?>" alt="Avatar" class="w-px-42 h-px-42 rounded-circle" style="object-fit: cover; border: 2px solid var(--skj-primary-soft, #e0e7ff);" />
                    </div>
                    <div>
                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <h5 class="fw-bold mb-0 text-dark" style="letter-spacing: -0.01em;">
                                สวัสดีคุณ <?= session('AdminFullname') ?? 'ผู้ดูแลระบบ' ?>
                            </h5>
                            <span class="badge bg-label-primary px-2 py-0.5 rounded-pill" style="font-size: 0.7rem; font-weight: 600;"><?= $user_role ?></span>
                        </div>
                        <p class="text-muted mb-0 small" style="font-size: 0.78rem;">
                            ผู้ดูแลระบบ SKJ Management Portal • โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ)
                        </p>
                    </div>
                </div>

                <!-- Live Date & Actions -->
                <div class="d-flex flex-wrap align-items-center gap-2 ms-auto ms-md-0">
                    <div class="d-flex align-items-center bg-light px-2.5 py-1.5 rounded-pill border">
                        <i class="bx bx-calendar text-primary me-1.5" style="font-size: 0.95rem;"></i>
                        <span class="small fw-semibold text-dark" style="font-size: 0.78rem;"><?= $thai_date_formatted ?></span>
                    </div>
                    <span class="badge bg-label-success px-2.5 py-1.5 rounded-pill d-flex align-items-center gap-1.5" style="font-size: 0.74rem;">
                        <span class="badge-dot bg-success" style="width: 7px; height: 7px; border-radius: 50%;"></span>
                        <span>ระบบออนไลน์</span>
                    </span>
                    <a href="<?= base_url('/') ?>" target="_blank" class="btn btn-xs btn-outline-primary rounded-pill px-2.5 py-1.5 d-flex align-items-center gap-1" title="เปิดหน้าเว็บไซต์หลัก">
                        <i class="bx bx-globe"></i>
                        <span class="d-none d-sm-inline">หน้าเว็บหลัก</span>
                        <i class="bx bx-link-external" style="font-size: 0.75rem;"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Action Chips Bar (Streamlined & Compact) -->
    <div class="d-flex flex-nowrap overflow-auto pb-2 mb-3 gap-2 quick-chips-container" style="-webkit-overflow-scrolling: touch;">
        <span class="d-flex align-items-center text-muted fw-semibold small text-nowrap px-1" style="font-size: 0.75rem;">
            <i class="bx bx-bolt-circle me-1 text-warning fs-6"></i> คำสั่งด่วน:
        </span>
        <a href="<?= base_url('Admin/News') ?>" class="quick-chip">
            <i class="bx bx-edit text-primary"></i>
            <span>เขียนข่าวใหม่</span>
        </a>
        <a href="<?= base_url('Admin/News#facebook') ?>" class="quick-chip">
            <i class="bx bxl-facebook-circle text-info"></i>
            <span>ดึงข่าว Facebook</span>
        </a>
        <a href="<?= base_url('Admin/Banner') ?>" class="quick-chip">
            <i class="bx bx-images text-warning"></i>
            <span>เปลี่ยนแบนเนอร์</span>
        </a>
        <a href="<?= base_url('Admin/WelcomeModal') ?>" class="quick-chip">
            <i class="bx bx-bell text-danger"></i>
            <span>ป๊อปอัปแจ้งเตือน</span>
        </a>
        <a href="<?= base_url('Admin/Logs') ?>" class="quick-chip">
            <i class="bx bx-history text-secondary"></i>
            <span>บันทึก Logs</span>
        </a>
    </div>

    <!-- KPI Metric Cards Grid (Compact, Sleek, 4 Cards) -->
    <div class="row g-3 mb-4">
        <!-- 1. News Card -->
        <div class="col-6 col-lg-3">
            <div class="card stat-card-luxury h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="stat-icon-wrapper stat-icon-indigo">
                            <i class="bx bx-news"></i>
                        </div>
                        <span class="badge bg-label-primary rounded-pill px-2" style="font-size: 0.68rem;">ข่าวสาร</span>
                    </div>
                    <span class="text-muted small d-block" style="font-size: 0.78rem;">ข่าวประชาสัมพันธ์</span>
                    <div class="d-flex align-items-baseline gap-1.5 my-1">
                        <h4 class="fw-bolder mb-0 text-dark" style="letter-spacing: -0.02em; font-size: 1.5rem;"><?= number_format($countNews) ?></h4>
                        <span class="text-muted" style="font-size: 0.72rem;">รายการ</span>
                    </div>
                    <div class="pt-2 border-top d-flex justify-content-between align-items-center mt-2">
                        <a href="<?= base_url('Admin/News') ?>" class="small fw-semibold text-primary d-flex align-items-center" style="font-size: 0.75rem;">
                            จัดการข่าว <i class="bx bx-chevron-right ms-0.5"></i>
                        </a>
                        <span class="text-muted" style="font-size: 0.68rem;">News Hub</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Banner Card -->
        <div class="col-6 col-lg-3">
            <div class="card stat-card-luxury h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="stat-icon-wrapper stat-icon-cyan">
                            <i class="bx bx-images"></i>
                        </div>
                        <span class="badge bg-label-info rounded-pill px-2" style="font-size: 0.68rem;">หน้าแรก</span>
                    </div>
                    <span class="text-muted small d-block" style="font-size: 0.78rem;">ภาพสไลด์แบนเนอร์</span>
                    <div class="d-flex align-items-baseline gap-1.5 my-1">
                        <h4 class="fw-bolder mb-0 text-dark" style="letter-spacing: -0.02em; font-size: 1.5rem;"><?= number_format($countBanner) ?></h4>
                        <span class="text-muted" style="font-size: 0.72rem;">ภาพ</span>
                    </div>
                    <div class="pt-2 border-top d-flex justify-content-between align-items-center mt-2">
                        <a href="<?= base_url('Admin/Banner') ?>" class="small fw-semibold text-info d-flex align-items-center" style="font-size: 0.75rem;">
                            จัดการแบนเนอร์ <i class="bx bx-chevron-right ms-0.5"></i>
                        </a>
                        <span class="text-muted" style="font-size: 0.68rem;">Carousel</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Visitors Card -->
        <div class="col-6 col-lg-3">
            <div class="card stat-card-luxury h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="stat-icon-wrapper stat-icon-amber">
                            <i class="bx bx-user-check"></i>
                        </div>
                        <span class="badge bg-label-warning rounded-pill px-2" style="font-size: 0.68rem;">วันนี้ <?= number_format($visitorStats['VisitToday'] ?? 0) ?></span>
                    </div>
                    <span class="text-muted small d-block" style="font-size: 0.78rem;">ผู้เข้าชมเว็บไซต์รวม</span>
                    <div class="d-flex align-items-baseline gap-1.5 my-1">
                        <h4 class="fw-bolder mb-0 text-dark" style="letter-spacing: -0.02em; font-size: 1.5rem;"><?= number_format($visitorStats['visitAll'] ?? 0) ?></h4>
                        <span class="text-muted" style="font-size: 0.72rem;">ครั้ง</span>
                    </div>
                    <div class="pt-2 border-top d-flex justify-content-between align-items-center mt-2">
                        <span class="text-muted" style="font-size: 0.72rem;">เดือนนี้: <strong class="text-dark"><?= number_format($visitorStats['visitMouth'] ?? 0) ?></strong></span>
                        <span class="text-muted" style="font-size: 0.68rem;">Traffic</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. System Logs Card -->
        <div class="col-6 col-lg-3">
            <div class="card stat-card-luxury h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="stat-icon-wrapper stat-icon-emerald">
                            <i class="bx bx-pulse"></i>
                        </div>
                        <span class="badge bg-label-success rounded-pill px-2" style="font-size: 0.68rem;">วันนี้ <?= number_format($todayLogs) ?></span>
                    </div>
                    <span class="text-muted small d-block" style="font-size: 0.78rem;">บันทึกการทำงาน (Logs)</span>
                    <div class="d-flex align-items-baseline gap-1.5 my-1">
                        <h4 class="fw-bolder mb-0 text-dark" style="letter-spacing: -0.02em; font-size: 1.5rem;"><?= number_format($countLogs) ?></h4>
                        <span class="text-muted" style="font-size: 0.72rem;">รายการ</span>
                    </div>
                    <div class="pt-2 border-top d-flex justify-content-between align-items-center mt-2">
                        <a href="<?= base_url('Admin/Logs') ?>" class="small fw-semibold text-success d-flex align-items-center" style="font-size: 0.75rem;">
                            ดูบันทึก <i class="bx bx-chevron-right ms-0.5"></i>
                        </a>
                        <span class="text-muted" style="font-size: 0.68rem;">Security</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid: Recent Activity & Quick Navigation -->
    <div class="row g-3">
        <!-- Left: Recent Logs Activity Feed -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-xs h-100" style="border-radius: 16px;">
                <div class="card-header bg-white py-3 px-3 px-md-4 d-flex align-items-center justify-content-between border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <div class="avatar avatar-xs">
                            <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-history"></i></span>
                        </div>
                        <div>
                            <h6 class="card-title text-dark fw-bold mb-0" style="font-size: 0.95rem;">
                                ประวัติการใช้งานล่าสุด
                            </h6>
                            <small class="text-muted" style="font-size: 0.75rem;">การเข้าถึงและแก้ไขข้อมูลในระบบ</small>
                        </div>
                    </div>
                    <a href="<?= base_url('Admin/Logs') ?>" class="btn btn-xs btn-outline-primary rounded-pill px-2.5">
                        ดูทั้งหมด <i class="bx bx-chevron-right ms-0.5"></i>
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 0.82rem;">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 25%; font-size: 0.72rem;" class="text-uppercase text-muted py-2">วัน-เวลา</th>
                                <th style="width: 30%; font-size: 0.72rem;" class="text-uppercase text-muted py-2">ผู้ใช้งาน</th>
                                <th style="width: 45%; font-size: 0.72rem;" class="text-uppercase text-muted py-2">กิจกรรม / หน้าที่เข้าใช้งาน</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recentLogs)): ?>
                                <?php foreach ($recentLogs as $log): ?>
                                    <tr>
                                        <td class="py-2.5">
                                            <div class="d-flex align-items-center text-muted">
                                                <i class="bx bx-time-five me-1.5 small text-primary"></i>
                                                <span class="text-dark fw-medium" style="font-size: 0.78rem;"><?= date('d/m/Y H:i', strtotime($log['log_created_at'])) ?></span>
                                            </div>
                                        </td>
                                        <td class="py-2.5">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-xs me-2" style="width: 26px; height: 26px;">
                                                    <span class="avatar-initial rounded-circle bg-label-primary" style="font-size: 0.7rem; font-weight: 600;">
                                                        <?= mb_substr($log['log_user_name'] ?? 'A', 0, 1, 'UTF-8') ?>
                                                    </span>
                                                </div>
                                                <span class="fw-semibold text-dark text-truncate" style="max-width: 130px; font-size: 0.8rem;"><?= $log['log_user_name'] ?></span>
                                            </div>
                                        </td>
                                        <td class="py-2.5">
                                            <span class="badge bg-label-secondary text-truncate d-inline-block font-monospace" style="max-width: 240px; font-size: 0.72rem; padding: 4px 8px;" title="<?= $log['log_url'] ?>">
                                                <?= $log['log_url'] ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted small">
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
            <div class="card border-0 shadow-xs h-100" style="border-radius: 16px;">
                <div class="card-header bg-white py-3 px-3 px-md-4 border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <div class="avatar avatar-xs">
                            <span class="avatar-initial rounded bg-label-info"><i class="bx bx-slider-alt"></i></span>
                        </div>
                        <div>
                            <h6 class="card-title text-dark fw-bold mb-0" style="font-size: 0.95rem;">
                                ควบคุมและจัดการระบบ
                            </h6>
                            <small class="text-muted" style="font-size: 0.75rem;">ทางลัดตั้งค่าและโครงสร้างสำคัญ</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3">
                    <!-- Super Admin Control -->
                    <div class="p-2.5 rounded-3 bg-light border mb-2.5">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar avatar-xs" style="width: 28px; height: 28px;">
                                    <span class="avatar-initial rounded bg-label-warning" style="font-size: 0.8rem;"><i class="bx bx-shield-quarter"></i></span>
                                </div>
                                <div>
                                    <span class="fw-bold text-dark d-block" style="font-size: 0.82rem;">สิทธิ์ผู้ใช้งาน</span>
                                    <small class="text-muted" style="font-size: 0.7rem;">จัดการบทบาทของเจ้าหน้าที่</small>
                                </div>
                            </div>
                            <?php if (in_array('Super Admin', session('roles') ?? [])): ?>
                                <a href="<?= base_url('Admin/roles') ?>" class="btn btn-xs btn-primary rounded-pill px-2.5">จัดการ</a>
                            <?php else: ?>
                                <span class="badge bg-label-secondary" style="font-size: 0.65rem;">Super Admin</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Festival & Theme Setting -->
                    <div class="p-2.5 rounded-3 bg-light border mb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar avatar-xs" style="width: 28px; height: 28px;">
                                    <span class="avatar-initial rounded bg-label-success" style="font-size: 0.8rem;"><i class="bx bx-party"></i></span>
                                </div>
                                <div>
                                    <span class="fw-bold text-dark d-block" style="font-size: 0.82rem;">ธีมเทศกาลเว็บ</span>
                                    <small class="text-muted" style="font-size: 0.7rem;">เปิด-ปิด หิมะตก / สเปเชียลเอฟเฟกต์</small>
                                </div>
                            </div>
                            <?php if (in_array('Super Admin', session('roles') ?? [])): ?>
                                <a href="<?= base_url('Admin/Settings') ?>" class="btn btn-xs btn-outline-success rounded-pill px-2.5">ตั้งค่า</a>
                            <?php else: ?>
                                <span class="badge bg-label-secondary" style="font-size: 0.65rem;">Super Admin</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- About School List -->
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="fw-bold text-dark small" style="font-size: 0.8rem;">
                            <i class="bx bx-buildings me-1 text-info"></i> เมนูเกี่ยวกับโรงเรียน
                        </span>
                        <span class="badge bg-label-primary px-2 rounded-pill" style="font-size: 0.65rem;">ข้อมูลโรงเรียน</span>
                    </div>
                    <ul class="list-unstyled mb-0">
                        <?php if (!empty($AboutSchool)) : ?>
                            <?php foreach (array_slice($AboutSchool, 0, 4) as $v_AboutSchool) : ?>
                                <li class="py-1.5 border-bottom d-flex align-items-center justify-content-between">
                                    <span class="text-dark text-truncate me-2" style="font-size: 0.78rem; max-width: 190px;">
                                        <i class="bx bx-check-circle text-primary me-1" style="font-size: 0.85rem;"></i><?= $v_AboutSchool->about_menu ?>
                                    </span>
                                    <a href="<?= base_url('Admin/AboutSchool/Detail/' . $v_AboutSchool->id) ?>" 
                                       class="btn btn-xs btn-icon btn-outline-primary rounded-circle" style="width: 24px; height: 24px;" title="แก้ไข">
                                        <i class="bx bx-chevron-right" style="font-size: 0.85rem;"></i>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="small text-muted py-2" style="font-size: 0.78rem;">ไม่มีข้อมูลเมนูเกี่ยวกับโรงเรียน</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
