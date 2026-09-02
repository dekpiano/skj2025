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
            'Admin/WelcomeModal' => 'ตั้งค่าป๊อปอัพต้อนรับหน้าแรก',
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
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-2">
        <h4 class="fw-bold py-2 py-sm-3 mb-0">
            <span class="text-muted fw-light">Admin /</span> บันทึกการใช้งาน (Log)
        </h4>
        <div>
            <a href="<?= base_url('Admin/Logs/Clean') ?>" id="btn-clean-logs" class="btn btn-outline-danger btn-sm py-2">
                <span class="spinner-border spinner-border-sm d-none me-1" role="status" aria-hidden="true"></span>
                <i class="bx bx-trash me-1"></i> ลบข้อมูลเก่า (>90 วัน)
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card bg-primary text-white shadow-sm border-0 h-100">
                <div class="card-body p-3 p-lg-4">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar flex-shrink-0 me-2 me-lg-3">
                            <span class="avatar-initial rounded bg-white text-primary"><i class="bx bx-trending-up fs-4"></i></span>
                        </div>
                        <h6 class="card-title mb-0 text-white small-mobile-title">Log ทั้งหมด</h6>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <h3 class="mb-0 text-white fw-bold"><?= number_format($stats['total']) ?></h3>
                        <span class="ms-1 small text-white-50">รายการ</span>
                    </div>
                    <small class="text-white-50 mt-1 d-block" style="font-size: 0.75rem;">ตรงกับกรอง: <?= number_format($pager->getTotal('logs')) ?></small>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card bg-info text-white shadow-sm border-0 h-100">
                <div class="card-body p-3 p-lg-4">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar flex-shrink-0 me-2 me-lg-3">
                            <span class="avatar-initial rounded bg-white text-info"><i class="bx bx-laptop fs-4"></i></span>
                        </div>
                        <h6 class="card-title mb-0 text-white small-mobile-title">IP ไม่ซ้ำกัน</h6>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <h3 class="mb-0 text-white fw-bold"><?= number_format($stats['unique_ips']) ?></h3>
                        <span class="ms-1 small text-white-50">IP</span>
                    </div>
                    <small class="text-white-50 mt-1 d-block" style="font-size: 0.75rem;">IP ทั้งหมดในระบบ</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card bg-warning text-white shadow-sm border-0 h-100">
                <div class="card-body p-3 p-lg-4">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar flex-shrink-0 me-2 me-lg-3">
                            <span class="avatar-initial rounded bg-white text-warning"><i class="bx bx-error fs-4"></i></span>
                        </div>
                        <h6 class="card-title mb-0 text-white small-mobile-title">IP ยอดนิยม</h6>
                    </div>
                    <div class="d-flex align-items-baseline text-truncate">
                        <h5 class="mb-0 text-white text-truncate fw-bold w-100" style="font-size: 0.95rem;" title="<?= esc($stats['top_ip']['log_ip_address'] ?? '-') ?>">
                            <?= esc($stats['top_ip']['log_ip_address'] ?? '-') ?>
                        </h5>
                    </div>
                    <small class="text-white-50 mt-1 d-block" style="font-size: 0.75rem;">เข้าใช้: <?= number_format($stats['top_ip']['count'] ?? 0) ?> ครั้ง</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card bg-success text-white shadow-sm border-0 h-100">
                <div class="card-body p-3 p-lg-4">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar flex-shrink-0 me-2 me-lg-3">
                            <span class="avatar-initial rounded bg-white text-success"><i class="bx bx-user-check fs-4"></i></span>
                        </div>
                        <h6 class="card-title mb-0 text-white small-mobile-title">ผู้ใช้งานหลัก</h6>
                    </div>
                    <div class="d-flex align-items-baseline text-truncate">
                        <h5 class="mb-0 text-white text-truncate fw-bold w-100" style="font-size: 0.95rem;" title="<?= esc($stats['top_user']['log_user_name'] ?? '-') ?>">
                            <?= esc($stats['top_user']['log_user_name'] ?? '-') ?>
                        </h5>
                    </div>
                    <small class="text-white-50 mt-1 d-block" style="font-size: 0.75rem;">เข้าใช้: <?= number_format($stats['top_user']['count'] ?? 0) ?> ครั้ง</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center d-lg-none" data-bs-toggle="collapse" href="#collapseFilters" role="button" aria-expanded="false" aria-controls="collapseFilters" style="cursor: pointer;">
            <h6 class="mb-0 text-primary fw-bold"><i class="bx bx-filter me-1"></i> ตัวกรองข้อมูล (กดแสดง/ซ่อน)</h6>
            <i class="bx bx-chevron-down"></i>
        </div>
        <div class="collapse d-lg-block" id="collapseFilters">
            <div class="card-body pt-3 pt-lg-4">
                <form id="filter-form" method="GET" action="<?= base_url('Admin/Logs') ?>">
                    <div class="row g-3">
                        <div class="col-12 col-md-4 col-lg-3">
                            <label class="form-label fw-bold small text-muted">ค้นหา</label>
                            <input type="text" name="search" class="form-control" placeholder="ค้นหา ชื่อผู้ใช้, IP, URL..." value="<?= esc($filters['search'] ?? '') ?>">
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label fw-bold small text-muted">Method</label>
                            <select name="method" class="form-select">
                                <option value="">ทั้งหมด</option>
                                <option value="GET" <?= ($filters['method'] ?? '') === 'GET' ? 'selected' : '' ?>>GET</option>
                                <option value="POST" <?= ($filters['method'] ?? '') === 'POST' ? 'selected' : '' ?>>POST</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label fw-bold small text-muted">ประเภทผู้ใช้</label>
                            <select name="user_type" class="form-select">
                                <option value="">ทั้งหมด</option>
                                <option value="member" <?= ($filters['user_type'] ?? '') === 'member' ? 'selected' : '' ?>>สมาชิก (Member)</option>
                                <option value="guest" <?= ($filters['user_type'] ?? '') === 'guest' ? 'selected' : '' ?>>ผู้เยี่ยมชม (Guest)</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-6 col-lg-2">
                            <label class="form-label fw-bold small text-muted">จากวันที่</label>
                            <input type="date" name="start_date" class="form-control" value="<?= esc($filters['start_date'] ?? '') ?>">
                        </div>
                        <div class="col-6 col-md-6 col-lg-2">
                            <label class="form-label fw-bold small text-muted">ถึงวันที่</label>
                            <input type="date" name="end_date" class="form-control" value="<?= esc($filters['end_date'] ?? '') ?>">
                        </div>
                        <div class="col-12 col-lg-1 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100"><i class="bx bx-search"></i> กรอง</button>
                        </div>
                    </div>
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mt-3 pt-3 border-top">
                        <div>
                            <a href="<?= base_url('Admin/Logs') ?>" class="btn btn-outline-secondary btn-sm w-100 w-sm-auto mb-1 mb-sm-0"><i class="bx bx-refresh"></i> รีเซ็ตตัวกรอง</a>
                        </div>
                        <div>
                            <a href="<?= base_url('Admin/Logs/Export') . '?' . http_build_query($filters) ?>" class="btn btn-success btn-sm w-100 w-sm-auto"><i class="bx bx-file me-1"></i> ส่งออกข้อมูล (CSV)</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Logs Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 text-primary fw-bold">รายการบันทึกข้อมูลล่าสุด</h5>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>วัน-เวลา</th>
                        <th>ผู้ใช้งาน</th>
                        <th class="d-none d-sm-table-cell">IP Address</th>
                        <th>Method</th>
                        <th>กิจกรรม / URL</th>
                        <th class="d-none d-lg-table-cell">Browser / Agent</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <?php if (!empty($logs)): ?>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <td>
                                    <span class="fw-medium" style="font-size: 0.85rem;"><?= formatThaiDate($log['log_created_at']) ?></span><br>
                                    <small class="text-muted" style="font-size: 0.75rem;"><?= date('H:i:s', strtotime($log['log_created_at'])) ?> น.</small>
                                </td>
                                <td>
                                    <?php if ($log['log_user_id']): ?>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-xs me-2 d-none d-sm-inline-block">
                                                <span class="avatar-initial rounded-circle bg-label-primary"><i class="bx bx-user"></i></span>
                                            </div>
                                            <div>
                                                <span class="fw-bold" style="font-size: 0.85rem;"><?= esc($log['log_user_name']) ?></span><br>
                                                <small class="text-muted" style="font-size: 0.75rem;">ID: <?= esc($log['log_user_id']) ?></small>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <span class="badge bg-label-secondary" style="font-size: 0.75rem;">Guest</span>
                                    <?php endif; ?>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <code style="font-size: 0.8rem;"><?= esc($log['log_ip_address']) ?></code>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $log['log_method'] == 'POST' ? 'success' : 'info' ?>" style="font-size: 0.7rem;"><?= $log['log_method'] ?></span>
                                </td>
                                <td>
                                    <span class="badge bg-label-info mb-1" style="font-size: 0.7rem; font-weight: normal;"><?= getFriendlyAction($log['log_url']) ?></span>
                                    <div class="text-truncate" style="max-width: 250px;" title="<?= esc($log['log_url']) ?>">
                                        <small class="text-muted" style="font-size: 0.75rem;"><?= esc($log['log_url']) ?></small>
                                    </div>
                                </td>
                                <td class="d-none d-lg-table-cell">
                                    <small class="text-muted d-inline-block text-truncate" style="max-width: 200px;" title="<?= esc($log['log_agent']) ?>">
                                        <?= esc($log['log_agent']) ?>
                                    </small>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">ไม่พบข้อมูล Log</div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white pt-4">
            <?= $pager->links('logs', 'default_full') ?>
        </div>
    </div>
</div>

<style>
    .card { border-radius: 1rem; overflow: hidden; }
    .table thead th { border-top: none; font-weight: 600; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; }
    .pagination { justify-content: center; }
    .avatar-initial { font-size: 1.2rem; }
    .bg-label-primary { background-color: #e7e7ff !important; color: #696cff !important; }
    .bg-label-info { background-color: #e5f8fc !important; color: #03c3ec !important; }
    .bg-label-secondary { background-color: #f1f2f4 !important; color: #8592a3 !important; }
    @media (max-width: 575.98px) {
        .small-mobile-title { font-size: 0.75rem !important; }
        .avatar-initial { font-size: 1rem; width: 30px; height: 30px; }
    }
</style>
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
            confirmButtonColor: '#ff3e1d',
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
