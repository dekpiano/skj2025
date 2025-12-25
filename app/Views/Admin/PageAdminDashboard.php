<?= $this->extend('Admin/layout/AdminLayout') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <!-- Congratulations Card -->
        <div class="col-lg-8 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">ยินดีต้อนรับคุณ <?= session('AdminFullname') ?>! 🎉</h5>
                            <p class="mb-4">
                                วันนี้มีการเข้าใช้งานระบบทั้งหมด <span class="fw-bold"><?= number_format($todayLogs) ?></span> รายการ 
                                และมีผู้เข้าชมเว็บไซต์รวม <span class="fw-bold"><?= number_format($visitorStats['visitAll']) ?></span> ครั้ง
                            </p>

                            <a href="<?= base_url('Admin/Logs') ?>" class="btn btn-sm btn-outline-primary">ดูประวัติการใช้งาน</a>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="<?= base_url() ?>/assets/admin/assets/img/illustrations/man-with-laptop-light.png" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="col-lg-4 col-md-4 order-1">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-news"></i></span>
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">ข่าวสาร</span>
                            <h3 class="card-title mb-2"><?= number_format($countNews) ?></h3>
                            <small class="text-success fw-semibold">รายการทั้งหมด</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <span class="avatar-initial rounded bg-label-info"><i class="bx bx-images"></i></span>
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">แบนเนอร์</span>
                            <h3 class="card-title mb-2"><?= number_format($countBanner) ?></h3>
                            <small class="text-info fw-semibold">รายการทั้งหมด</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Logs Table -->
        <div class="col-md-6 col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2 text-primary">การใช้งานล่าสุด (Recent Logs)</h5>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="transactionID" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                            <a class="dropdown-item" href="<?= base_url('Admin/Logs') ?>">ดูทั้งหมด</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover border-top">
                        <thead>
                            <tr>
                                <th>วัน-เวลา</th>
                                <th>ผู้ใช้งาน</th>
                                <th>กิจกรรม (URL)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentLogs as $log): ?>
                                <tr>
                                    <td><small><?= date('Y/m/d H:i', strtotime($log['log_created_at'])) ?></small></td>
                                    <td><span class="fw-bold"><?= $log['log_user_name'] ?></span></td>
                                    <td><small class="text-muted d-inline-block text-truncate" style="max-width: 200px;"><?= $log['log_url'] ?></small></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- System Management -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">จัดการข้อมูลระบบ</h5>
                </div>
                <div class="card-body">
                    <ul class="p-0 m-0">
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-shield-quarter"></i></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">จัดการสิทธิ์ผู้ใช้งาน</h6>
                                    <small class="text-muted">เฉพาะ Super Admin</small>
                                </div>
                                <div class="user-progress">
                                    <a href="<?= base_url('Admin/roles') ?>" class="btn btn-xs btn-outline-warning">เข้าสู่ระบบ</a>
                                </div>
                            </div>
                        </li>
                        <hr>
                        <h6 class="text-muted mb-3">เกี่ยวกับโรงเรียน</h6>
                        <?php if (!empty($AboutSchool)) : ?>
                            <?php foreach (array_slice($AboutSchool, 0, 4) as $v_AboutSchool) : ?>
                                <li class="d-flex mb-3 pb-1">
                                    <div class="avatar flex-shrink-0 me-3 avatar-xs">
                                        <span class="avatar-initial rounded-circle bg-label-secondary"><i class="bx bx-buildings"></i></span>
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0 small"><?= $v_AboutSchool->about_menu ?></h6>
                                        </div>
                                        <div class="user-progress">
                                            <a href="<?= base_url('Admin/AboutSchool/Detail/' . $v_AboutSchool->id) ?>" class="text-primary"><i class="bx bx-chevron-right"></i></a>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .avatar-initial { font-size: 1.2rem; }
</style>
<?= $this->endSection() ?>
