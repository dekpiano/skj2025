<?= $this->extend('Admin/layout/AdminLayout') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-0">
            <span class="text-muted fw-light">Admin /</span> บันทึกการใช้งาน (Log)
        </h4>
        <div class="d-flex gap-2">
            <a href="<?= base_url('Admin/Logs/Clean') ?>" id="btn-clean-logs" class="btn btn-outline-danger">
                <span class="spinner-border spinner-border-sm d-none me-1" role="status" aria-hidden="true"></span>
                <i class="bi bi-trash me-1"></i> ลบข้อมูลเก่า (>90 วัน)
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-white text-primary"><i class="bi bi-graph-up"></i></span>
                        </div>
                        <h5 class="card-title mb-0 text-white">ทั้งหมด</h5>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <h2 class="mb-0 text-white"><?= number_format($pager->getTotal('logs')) ?></h2>
                        <span class="ms-2">รายการ</span>
                    </div>
                </div>
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
                        <th>IP Address</th>
                        <th>Method</th>
                        <th>URL</th>
                        <th>Browser / Agent</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <?php if (!empty($logs)): ?>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <td>
                                    <span class="fw-medium"><?= date('Y/m/d', strtotime($log['log_created_at'])) ?></span><br>
                                    <small class="text-muted"><?= date('H:i:s', strtotime($log['log_created_at'])) ?></small>
                                </td>
                                <td>
                                    <?php if ($log['log_user_id']): ?>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-xs me-2">
                                                <span class="avatar-initial rounded-circle bg-label-primary"><i class="bi bi-person"></i></span>
                                            </div>
                                            <div>
                                                <span class="fw-bold"><?= $log['log_user_name'] ?></span><br>
                                                <small class="text-muted">ID: <?= $log['log_user_id'] ?></small>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <span class="badge bg-label-secondary">Guest (ไม่ได้เข้าระบบ)</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <code><?= $log['log_ip_address'] ?></code>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $log['log_method'] == 'POST' ? 'success' : 'info' ?>"><?= $log['log_method'] ?></span>
                                </td>
                                <td>
                                    <div class="text-truncate" style="max-width: 250px;" title="<?= $log['log_url'] ?>">
                                        <?= $log['log_url'] ?>
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted d-inline-block text-truncate" style="max-width: 200px;" title="<?= $log['log_agent'] ?>">
                                        <?= $log['log_agent'] ?>
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
