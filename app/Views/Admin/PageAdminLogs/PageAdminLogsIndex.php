<?= $this->extend('Admin/layout/AdminLayout') ?>

<?php
if (!function_exists('getFriendlyAction')) {
    function getFriendlyAction($url) {
        $urlPath = parse_url($url, PHP_URL_PATH);
        $urlPath = trim($urlPath, '/');
        
        // Mapping of admin URLs to friendly descriptions
        $mappings = [
            'Admin/Dashboard' => 'ดูหน้าหลักแดชบอร์ด',
            'Admin/Logs/Clean' => 'ลบข้อมูล Log เก่า (>90 วัน)',
            'Admin/Logs/Export' => 'ส่งออกข้อมูล Log เป็น CSV',
            'Admin/Logs' => 'ดูบันทึกการใช้งานระบบ (Log)',
            'Admin/News/AddNews' => 'เพิ่มข่าวประชาสัมพันธ์',
            'Admin/News/Add/NewsFacebook' => 'เพิ่มข่าวจาก Facebook',
            'Admin/News/EditNews' => 'แก้ไขข่าวประชาสัมพันธ์',
            'Admin/News/UpdateNews' => 'บันทึกการแก้ไขข่าวประชาสัมพันธ์',
            'Admin/News/DeleteNews' => 'ลบข่าวประชาสัมพันธ์',
            'Admin/News/CleanUnusedImages' => 'ล้างรูปภาพข่าวที่ไม่ได้ใช้',
            'Admin/News' => 'จัดการข่าวประชาสัมพันธ์',
            'Admin/Banner/Addbanner' => 'เพิ่มภาพสไลด์แบนเนอร์',
            'Admin/Banner/EditBanner' => 'แก้ไขภาพสไลด์แบนเนอร์',
            'Admin/Banner/Updatebanner' => 'บันทึกการแก้ไขแบนเนอร์',
            'Admin/Banner/DeleteBanner' => 'ลบภาพสไลด์แบนเนอร์',
            'Admin/Banner' => 'จัดการภาพสไลด์แบนเนอร์',
            'Admin/Spotlight/AddSpotlight' => 'เพิ่มข่าวด่วน/Spotlight',
            'Admin/Spotlight/EditSpotlight' => 'แก้ไขข่าวด่วน/Spotlight',
            'Admin/Spotlight' => 'จัดการข่าวด่วน/Spotlight',
            'Admin/AboutSchool/Detail' => 'ดูรายละเอียดข้อมูลโรงเรียน',
            'Admin/AboutSchool/Edit' => 'แก้ไขข้อมูลโรงเรียน',
            'Admin/AboutSchool/Add' => 'เพิ่มข้อมูลโรงเรียน',
            'Admin/roles/addUser' => 'เพิ่มสิทธิ์ผู้ใช้งานใหม่',
            'Admin/roles/deleteUser' => 'ลบสิทธิ์ผู้ใช้งาน',
            'Admin/roles' => 'จัดการบทบาทและสิทธิ์ผู้ใช้งาน',
            'Admin/Settings' => 'ตั้งค่าระบบทั่วไป',
            'Admin/WelcomeModal' => 'ตั้งค่าป๊อปอัปต้อนรับหน้าแรก',
            'Login/LoginAdmin' => 'เข้าสู่ระบบ (หน้าแอดมิน)',
            'SkjMain/googleLogin' => 'เข้าสู่ระบบผ่าน Google',
            'SkjMain/googleCallback' => 'Callback เข้าสู่ระบบ Google',
            'logout' => 'ออกจากระบบ',
        ];

        foreach ($mappings as $route => $desc) {
            if (strpos($urlPath, $route) !== false) {
                return $desc;
            }
        }

        return 'เข้าชมหน้าทั่วไป / เรียกข้อมูล';
    }
}

if (!function_exists('formatThaiDate')) {
    function formatThaiDate($dateStr) {
        $timestamp = strtotime($dateStr);
        $thai_months = [
            1 => 'ม.ค.', 2 => 'ก.พ.', 3 => 'มี.ค.', 4 => 'เม.ย.', 5 => 'พ.ค.', 6 => 'มิ.ย.',
            7 => 'ก.ค.', 8 => 'ส.ค.', 9 => 'ก.ย.', 10 => 'ต.ค.', 11 => 'พ.ย.', 12 => 'ธ.ค.'
        ];
        
        $day = date('j', $timestamp);
        $month = $thai_months[(int)date('n', $timestamp)];
        $year = (int)date('Y', $timestamp) + 543;
        
        return "{$day} {$month} " . substr($year, 2);
    }
}
?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1 text-dark d-flex align-items-center gap-2">
                <span>บันทึกการใช้งาน (Audit Logs)</span>
                <span class="badge bg-label-primary fs-tiny fw-semibold">Security & History</span>
            </h4>
            <p class="text-muted mb-0 small">ติดตามและตรวจสอบประวัติการเข้าใช้งานและกิจกรรมต่างๆ ในระบบหลังบ้าน</p>
        </div>
        <div>
            <a href="<?= base_url('Admin/Logs/Clean') ?>" id="btn-clean-logs" class="btn btn-outline-danger btn-sm py-2 px-3 fw-semibold">
                <span class="spinner-border spinner-border-sm d-none me-1" role="status" aria-hidden="true"></span>
                <i class="bx bx-trash me-1"></i> ลบข้อมูลเก่า (>90 วัน)
            </a>
        </div>
    </div>

    <!-- Stats Cards Grid -->
    <div class="row g-3 mb-4">
        <!-- Card 1: Total Logs -->
        <div class="col-6 col-lg-3">
            <div class="card stat-card-luxury h-100">
                <div class="card-body p-3 p-lg-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="small fw-semibold text-muted">Log ทั้งหมด</span>
                        <div class="stat-icon-wrapper stat-icon-indigo" style="width: 42px; height: 42px; font-size: 1.3rem;">
                            <i class="bx bx-trending-up"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline gap-1">
                        <h3 class="mb-0 fw-bolder text-dark"><?= number_format($stats['total']) ?></h3>
                        <span class="small text-muted">รายการ</span>
                    </div>
                    <div class="mt-2 pt-2 border-top d-flex justify-content-between align-items-center">
                        <small class="text-muted" style="font-size: 0.75rem;">ตรงกับตัวกรอง:</small>
                        <span class="badge bg-label-primary px-2" style="font-size: 0.72rem;"><?= number_format($pager->getTotal('logs')) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Unique IPs -->
        <div class="col-6 col-lg-3">
            <div class="card stat-card-luxury h-100">
                <div class="card-body p-3 p-lg-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="small fw-semibold text-muted">IP ไม่ซ้ำกัน</span>
                        <div class="stat-icon-wrapper stat-icon-cyan" style="width: 42px; height: 42px; font-size: 1.3rem;">
                            <i class="bx bx-laptop"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline gap-1">
                        <h3 class="mb-0 fw-bolder text-dark"><?= number_format($stats['unique_ips']) ?></h3>
                        <span class="small text-muted">IPs</span>
                    </div>
                    <div class="mt-2 pt-2 border-top d-flex justify-content-between align-items-center">
                        <small class="text-muted" style="font-size: 0.75rem;">IP ทั้งหมดในระบบ</small>
                        <span class="badge bg-label-info px-2" style="font-size: 0.72rem;">Network</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Top IP -->
        <div class="col-6 col-lg-3">
            <div class="card stat-card-luxury h-100">
                <div class="card-body p-3 p-lg-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="small fw-semibold text-muted">IP ยอดนิยม</span>
                        <div class="stat-icon-wrapper stat-icon-amber" style="width: 42px; height: 42px; font-size: 1.3rem;">
                            <i class="bx bx-broadcast"></i>
                        </div>
                    </div>
                    <div class="text-truncate">
                        <h5 class="mb-0 fw-bold text-dark text-truncate" style="font-size: 1rem;" title="<?= esc($stats['top_ip']['log_ip_address'] ?? '-') ?>">
                            <?= esc($stats['top_ip']['log_ip_address'] ?? '-') ?>
                        </h5>
                    </div>
                    <div class="mt-2 pt-2 border-top d-flex justify-content-between align-items-center">
                        <small class="text-muted" style="font-size: 0.75rem;">เข้าใช้บ่อยสุด:</small>
                        <span class="badge bg-label-warning px-2" style="font-size: 0.72rem;"><?= number_format($stats['top_ip']['count'] ?? 0) ?> ครั้ง</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4: Top User -->
        <div class="col-6 col-lg-3">
            <div class="card stat-card-luxury h-100">
                <div class="card-body p-3 p-lg-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="small fw-semibold text-muted">ผู้ใช้งานหลัก</span>
                        <div class="stat-icon-wrapper stat-icon-emerald" style="width: 42px; height: 42px; font-size: 1.3rem;">
                            <i class="bx bx-user-check"></i>
                        </div>
                    </div>
                    <div class="text-truncate">
                        <h5 class="mb-0 fw-bold text-dark text-truncate" style="font-size: 1rem;" title="<?= esc($stats['top_user']['log_user_name'] ?? '-') ?>">
                            <?= esc($stats['top_user']['log_user_name'] ?? '-') ?>
                        </h5>
                    </div>
                    <div class="mt-2 pt-2 border-top d-flex justify-content-between align-items-center">
                        <small class="text-muted" style="font-size: 0.75rem;">ทำกิจกรรม:</small>
                        <span class="badge bg-label-success px-2" style="font-size: 0.72rem;"><?= number_format($stats['top_user']['count'] ?? 0) ?> ครั้ง</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="card mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#collapseFilters" role="button" aria-expanded="true" aria-controls="collapseFilters" style="cursor: pointer;">
            <div class="d-flex align-items-center gap-2">
                <i class="bx bx-filter-alt text-primary fs-5"></i>
                <h6 class="mb-0 text-dark fw-bold">ค้นหาและตัวกรองข้อมูล</h6>
            </div>
            <i class="bx bx-chevron-down text-muted"></i>
        </div>
        <div class="collapse show" id="collapseFilters">
            <div class="card-body pt-3">
                <form id="filter-form" method="GET" action="<?= base_url('Admin/Logs') ?>">
                    <div class="row g-3">
                        <div class="col-12 col-md-4 col-lg-3">
                            <label class="form-label text-dark fw-semibold small">ค้นหาคำสำคัญ</label>
                            <input type="text" name="search" class="form-control" placeholder="ชื่อผู้ใช้, IP, URL..." value="<?= esc($filters['search'] ?? '') ?>">
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label text-dark fw-semibold small">Method</label>
                            <select name="method" class="form-select">
                                <option value="">ทั้งหมด</option>
                                <option value="GET" <?= ($filters['method'] ?? '') === 'GET' ? 'selected' : '' ?>>GET</option>
                                <option value="POST" <?= ($filters['method'] ?? '') === 'POST' ? 'selected' : '' ?>>POST</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label text-dark fw-semibold small">ประเภทผู้ใช้</label>
                            <select name="user_type" class="form-select">
                                <option value="">ทั้งหมด</option>
                                <option value="member" <?= ($filters['user_type'] ?? '') === 'member' ? 'selected' : '' ?>>สมาชิก (Member)</option>
                                <option value="guest" <?= ($filters['user_type'] ?? '') === 'guest' ? 'selected' : '' ?>>ผู้เยี่ยมชม (Guest)</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-6 col-lg-2">
                            <label class="form-label text-dark fw-semibold small">จากวันที่</label>
                            <input type="date" name="start_date" class="form-control" value="<?= esc($filters['start_date'] ?? '') ?>">
                        </div>
                        <div class="col-6 col-md-6 col-lg-2">
                            <label class="form-label text-dark fw-semibold small">ถึงวันที่</label>
                            <input type="date" name="end_date" class="form-control" value="<?= esc($filters['end_date'] ?? '') ?>">
                        </div>
                        <div class="col-12 col-lg-1 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100"><i class="bx bx-search"></i> กรอง</button>
                        </div>
                    </div>
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mt-3 pt-3 border-top">
                        <div>
                            <a href="<?= base_url('Admin/Logs') ?>" class="btn btn-outline-secondary btn-sm px-3"><i class="bx bx-refresh me-1"></i> ล้างตัวกรอง</a>
                        </div>
                        <div>
                            <a href="<?= base_url('Admin/Logs/Export') . '?' . http_build_query($filters) ?>" class="btn btn-success btn-sm px-3"><i class="bx bx-file me-1"></i> ส่งออกข้อมูล (CSV)</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Logs Table Card -->
    <div class="card">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <i class="bx bx-history text-primary fs-5"></i>
                <h5 class="mb-0 text-dark fw-bold">รายการบันทึกการใช้งานล่าสุด</h5>
            </div>
            <span class="badge bg-label-secondary">แสดง <?= count($logs) ?> รายการ</span>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width: 18%;">วัน-เวลา</th>
                        <th style="width: 20%;">ผู้ใช้งาน</th>
                        <th style="width: 15%;" class="d-none d-sm-table-cell">IP Address</th>
                        <th style="width: 10%;">Method</th>
                        <th style="width: 25%;">กิจกรรม / URL</th>
                        <th style="width: 12%;" class="d-none d-lg-table-cell">Browser / Agent</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($logs)): ?>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-dark" style="font-size: 0.88rem;"><?= formatThaiDate($log['log_created_at']) ?></span>
                                        <small class="text-muted" style="font-size: 0.75rem;"><i class="bx bx-time-five me-1"></i><?= date('H:i:s', strtotime($log['log_created_at'])) ?> น.</small>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($log['log_user_id']): ?>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-xs me-2 d-none d-sm-inline-block">
                                                <span class="avatar-initial rounded-circle bg-label-primary fw-bold" style="font-size: 0.75rem;">
                                                    <?= mb_substr($log['log_user_name'] ?? 'U', 0, 1, 'UTF-8') ?>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="fw-bold text-dark d-block" style="font-size: 0.88rem;"><?= esc($log['log_user_name']) ?></span>
                                                <small class="badge bg-label-secondary px-1" style="font-size: 0.68rem;">ID: <?= esc($log['log_user_id']) ?></small>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <span class="badge bg-label-secondary px-2 py-1" style="font-size: 0.75rem;">Guest (ผู้เยี่ยมชม)</span>
                                    <?php endif; ?>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <span class="badge bg-label-secondary font-monospace" style="font-size: 0.8rem;"><?= esc($log['log_ip_address']) ?></span>
                                </td>
                                <td>
                                    <?php if ($log['log_method'] == 'POST'): ?>
                                        <span class="badge bg-label-success fw-bold px-2" style="font-size: 0.72rem;">POST</span>
                                    <?php elseif ($log['log_method'] == 'GET'): ?>
                                        <span class="badge bg-label-info fw-bold px-2" style="font-size: 0.72rem;">GET</span>
                                    <?php else: ?>
                                        <span class="badge bg-label-warning fw-bold px-2" style="font-size: 0.72rem;"><?= esc($log['log_method']) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex flex-column gap-1">
                                        <div>
                                            <span class="badge bg-label-primary px-2" style="font-size: 0.72rem; font-weight: 600;">
                                                <?= getFriendlyAction($log['log_url']) ?>
                                            </span>
                                        </div>
                                        <div class="text-truncate text-muted" style="max-width: 260px; font-size: 0.78rem;" title="<?= esc($log['log_url']) ?>">
                                            <code><?= esc($log['log_url']) ?></code>
                                        </div>
                                    </div>
                                </td>
                                <td class="d-none d-lg-table-cell">
                                    <small class="text-muted d-inline-block text-truncate" style="max-width: 180px;" title="<?= esc($log['log_agent']) ?>">
                                        <?= esc($log['log_agent']) ?>
                                    </small>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted d-flex flex-column align-items-center gap-2">
                                    <i class="bx bx-info-circle fs-2 text-primary"></i>
                                    <span>ไม่พบข้อมูลบันทึกการใช้งานตามเงื่อนไขที่เลือก</span>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer py-3 d-flex justify-content-center">
            <?= $pager->links('logs', 'default_full') ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $('#btn-clean-logs').on('click', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        const $btn = $(this);

        Swal.fire({
            title: 'ยืนยันการลบ?',
            text: "ระบบจะลบ Log ที่เก่ากว่า 90 วันออกอย่างถาวร!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            confirmButtonText: 'ยืนยันลบข้อมูล',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $btn.addClass('disabled').find('.spinner-border').removeClass('d-none');
                window.location.href = url;
            }
        });
    });
</script>
<?= $this->endSection() ?>
