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
            <h4 class="mb-1 fw-bold"><i class="bi bi-fingerprint me-2 text-primary"></i>ประวัติการสแกนนิ้วมือ & ข้อมูลวันลา</h4>
            <p class="text-muted mb-0">ข้อมูลสถิติจากระบบเครื่องสแกนนิ้วและสถานะการลาทางการของบุคลากร</p>
        </div>
    </div>

    <!-- Filter -->
    <div class="filter-card border">
        <form method="get" action="<?= base_url('Support/SupportAttendance/FingerprintHistory') ?>" class="row g-3 align-items-end">
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

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card summary-card border-start border-success border-3 h-100">
                <div class="card-body text-center p-3">
                    <div class="avatar bg-label-success rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-check-circle-fill fs-4"></i>
                    </div>
                    <h3 class="fw-bold mb-0 text-success"><?= $summary['ปกติ'] ?></h3>
                    <small class="text-muted fw-bold">มาทำงานปกติ (วัน)</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card summary-card border-start border-primary border-3 h-100">
                <div class="card-body text-center p-3">
                    <div class="avatar bg-label-primary rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-calendar2-range-fill fs-4"></i>
                    </div>
                    <h3 class="fw-bold mb-0 text-primary"><?= $summary['ลา'] ?></h3>
                    <small class="text-muted fw-bold">วันลา (วัน)</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card summary-card border-start border-warning border-3 h-100">
                <div class="card-body text-center p-3">
                    <div class="avatar bg-label-warning rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-exclamation-triangle-fill fs-4"></i>
                    </div>
                    <h3 class="fw-bold mb-0 text-warning"><?= $summary['มาสาย'] ?></h3>
                    <small class="text-muted fw-bold">มาสาย (วัน)</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card summary-card border-start border-danger border-3 h-100">
                <div class="card-body text-center p-3">
                    <div class="avatar bg-label-danger rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-x-circle-fill fs-4"></i>
                    </div>
                    <h3 class="fw-bold mb-0 text-danger"><?= $summary['ขาด'] ?></h3>
                    <small class="text-muted fw-bold">ขาดงาน (วัน)</small>
                </div>
            </div>
        </div>
    </div>

    <!-- History Table -->
    <div class="card shadow-sm border">
        <div class="card-header border-bottom bg-light py-3">
            <h5 class="card-title mb-0 fw-bold text-primary">
                <i class="bi bi-fingerprint me-1"></i> รายการสแกนนิ้วมือ & ข้อมูลวันลา
            </h5>
        </div>
        <div class="card-body pt-3">
            <?php if (empty($officialRecords)): ?>
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted"></i>
                    <p class="text-muted mt-2">ไม่พบข้อมูลสแกนนิ้วมือหรือใบลาในเดือนนี้</p>
                </div>
            <?php else: ?>
                <div class="table-responsive text-nowrap history-table">
                    <table class="table table-hover datatable">
                        <thead>
                            <tr class="table-primary" style="border-bottom: 2px solid #4f46e5;">
                                <th class="text-center" width="50">#</th>
                                <th>วันที่ (ระบบเครื่องสแกน)</th>
                                <th><i class="bi bi-fingerprint text-primary me-1"></i>เวลาเข้าสแกนนิ้ว</th>
                                <th><i class="bi bi-fingerprint text-success me-1"></i>เวลาออกสแกนนิ้ว</th>
                                <th class="text-center">สถานะทางการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $thDaysShort = ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'];
                            foreach ($officialRecords as $i => $r):
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
                                    <?php if (!empty($r['att_time']) && $r['att_time'] !== '00:00:00'): ?>
                                        <span class="fw-bold text-primary fs-6"><i class="bi bi-clock me-1"></i><?= date('H:i', strtotime($r['att_time'])) ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($r['att_checkout']) && $r['att_checkout'] !== '00:00:00'): ?>
                                        <span class="fw-bold text-success fs-6"><i class="bi bi-clock me-1"></i><?= date('H:i', strtotime($r['att_checkout'])) ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php
                                    $statusClass = [
                                        'มา'  => 'btn-outline-success',
                                        'มาปกติ' => 'btn-outline-success',
                                        'ปกติ'  => 'btn-outline-success',
                                        'สาย' => 'btn-outline-warning',
                                        'มาสาย' => 'btn-outline-warning',
                                        'ขาด'   => 'btn-outline-danger',
                                        'ลากิจ' => 'btn-outline-info',
                                        'ลาป่วย' => 'btn-outline-info',
                                        'ไปราชการ' => 'btn-outline-primary',
                                    ];
                                    $class = $statusClass[$r['att_status']] ?? 'btn-outline-secondary';
                                    ?>
                                    <span class="badge border <?= $class ?> fw-bold px-3 py-1.5"><i class="bi bi-shield-check me-1"></i><?= $r['att_status'] ?></span>
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
