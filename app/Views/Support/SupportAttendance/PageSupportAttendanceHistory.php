<?= $this->extend('Support/layout/SupportLayout') ?>

<?= $this->section('content') ?>
<!-- Load Bootstrap Icons dynamically for gorgeous modern icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    .filter-card {
        background: #fff;
        border-radius: 1.25rem;
        padding: 1.25rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        margin-bottom: 1.5rem;
    }
    .history-table img.selfie-thumb {
        width: 45px;
        height: 45px;
        object-fit: cover;
        border-radius: 0.5rem;
        cursor: pointer;
        transition: transform 0.2s;
    }
    .history-table img.selfie-thumb:hover {
        transform: scale(1.1);
    }
    /* Summary card overrides */
    .summary-card {
        border-radius: 1rem;
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.04);
        transition: transform 0.2s;
    }
    .summary-card:hover {
        transform: translateY(-2px);
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 fw-bold"><i class="bi bi-clock-history me-2 text-primary"></i>ประวัติการเช็คชื่อฝ่ายสนับสนุน</h4>
            <p class="text-muted mb-0">ดูสถิติและประวัติการเช็คชื่อเข้า-ออกงานของฝ่ายสนับสนุน</p>
        </div>
    </div>

    <!-- Filter -->
    <div class="filter-card border">
        <form method="get" action="<?= base_url('Support/SupportAttendance/History') ?>" class="row g-3 align-items-end">
            <div class="col-md-3 col-6 text-dark">
                <label class="form-label fw-bold">เลือกเดือน</label>
                <select name="month" class="form-select">
                    <?php foreach ($months as $num => $name): ?>
                        <option value="<?= $num ?>" <?= $month == $num ? 'selected' : '' ?>><?= $name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3 col-6 text-dark">
                <label class="form-label fw-bold">เลือกปี (พ.ศ.)</label>
                <select name="year" class="form-select">
                    <?php for ($y = date('Y') + 543; $y >= date('Y') + 540; $y--): ?>
                        <?php $actualYear = $y - 543; ?>
                        <option value="<?= $actualYear ?>" <?= $year == $actualYear ? 'selected' : '' ?>><?= $y ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search me-1"></i> ค้นหาข้อมูล
                </button>
            </div>
            <div class="col-md-3">
                <a href="<?= base_url('Support/SupportAttendance') ?>" class="btn btn-outline-primary w-100">
                    <i class="bi bi-clock-history me-1"></i> เช็คชื่อวันนี้
                </a>
            </div>
        </form>
    </div>

    <!-- History Table -->
    <div class="card shadow-sm border">
        <div class="card-header border-bottom bg-light py-3">
            <h5 class="card-title mb-0 fw-bold text-primary">
                <i class="bi bi-phone me-1"></i> รายการประวัติลงเวลางานผ่านแอป
            </h5>
        </div>
        <div class="card-body pt-3">
            <?php if (empty($records)): ?>
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted"></i>
                    <p class="text-muted mt-2">ไม่พบข้อมูลการเช็คชื่อผ่านแอปในเดือนนี้</p>
                </div>
            <?php else: ?>
                <div class="table-responsive text-nowrap history-table">
                    <table class="table table-hover datatable">
                        <thead>
                            <tr class="table-light">
                                <th class="text-center" width="50">#</th>
                                <th>วันที่</th>
                                <th>เวลาเข้า</th>
                                <th>เวลาออก</th>
                                <th>รูปสแกนเข้า</th>
                                <th>รูปสแกนออก</th>
                                <th class="text-center">สถานะ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $thDaysShort = ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'];
                            foreach ($records as $i => $r):
                                $d = new DateTime($r['att_date']);
                                $dayName = $thDaysShort[$d->format('w')];
                                $dateDisplay = $d->format('d/m/') . ($d->format('Y') + 543);
                            ?>
                            <tr>
                                <td class="text-center fw-bold"><?= $i + 1 ?></td>
                                <td>
                                    <div class="fw-bold text-dark"><?= $dateDisplay ?></div>
                                    <small class="text-muted">วัน<?= $dayName ?></small>
                                </td>
                                <td>
                                    <?php if ($r['check_in']): ?>
                                        <span class="fw-bold text-primary fs-6"><?= date('H:i', strtotime($r['check_in'])) ?></span>
                                        <?php if ($r['check_in_lat']): ?>
                                            <br><small class="text-muted">
                                                <i class="bi bi-geo-alt"></i>
                                                <?= number_format($r['check_in_lat'], 4) ?>, <?= number_format($r['check_in_lng'], 4) ?>
                                            </small>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($r['check_out']): ?>
                                        <span class="fw-bold text-success fs-6"><?= date('H:i', strtotime($r['check_out'])) ?></span>
                                        <?php if ($r['check_out_lat']): ?>
                                            <br><small class="text-muted">
                                                <i class="bi bi-geo-alt"></i>
                                                <?= number_format($r['check_out_lat'], 4) ?>, <?= number_format($r['check_out_lng'], 4) ?>
                                            </small>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($r['check_in_photo']): ?>
                                        <img src="<?= esc($r['check_in_photo']) ?>"
                                             class="selfie-thumb shadow-sm border"
                                             onclick="showSelfieModal('<?= esc($r['check_in_photo']) ?>', 'รูปสแกนเข้า - <?= $dateDisplay ?>')"
                                             alt="Selfie Check-in">
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($r['check_out_photo']): ?>
                                        <img src="<?= esc($r['check_out_photo']) ?>"
                                             class="selfie-thumb shadow-sm border"
                                             onclick="showSelfieModal('<?= esc($r['check_out_photo']) ?>', 'รูปสแกนออก - <?= $dateDisplay ?>')"
                                             alt="Selfie Check-out">
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php
                                    $statusClass = [
                                        'ปกติ'  => 'bg-label-success',
                                        'มาสาย' => 'bg-label-warning',
                                        'ขาด'   => 'bg-label-danger',
                                    ];
                                    $class = $statusClass[$r['status']] ?? 'bg-label-secondary';
                                    ?>
                                    <span class="badge <?= $class ?> fw-bold"><?= $r['status'] ?></span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // แสดงรูป selfie แบบ modal
    function showSelfieModal(src, title) {
        Swal.fire({
            title: title,
            imageUrl: src,
            imageWidth: 400,
            imageHeight: 300,
            imageAlt: 'Selfie',
            confirmButtonColor: '#4f46e5',
            confirmButtonText: 'ปิดหน้านี้',
        });
    }
</script>
<?= $this->endSection() ?>
