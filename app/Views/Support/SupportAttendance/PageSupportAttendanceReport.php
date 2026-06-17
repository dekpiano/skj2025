<?= $this->extend('Support/layout/SupportLayout') ?>

<?= $this->section('content') ?>
<!-- Load Bootstrap Icons dynamically for gorgeous modern icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    .stat-card {
        background: #fff;
        border-radius: 1.25rem;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        text-align: center;
        transition: transform 0.2s;
    }
    .stat-card:hover { transform: translateY(-3px); }
    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
    }
    .stat-label {
        font-size: 0.9rem;
        color: #677788;
        margin-top: 0.25rem;
    }
    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        margin: 0 auto 0.75rem;
    }
    .chart-card {
        background: #fff;
        border-radius: 1.25rem;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="mb-1 fw-bold"><i class="bi bi-graph-up me-2 text-primary"></i>รายงานสรุปรายเดือนฝ่ายสนับสนุน</h4>
            <p class="text-muted mb-0">สถิติและภาพรวมการเช็คชื่อเข้า-ออกงานในเดือนนี้</p>
        </div>
    </div>

    <!-- Filter -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border">
                <div class="card-body">
                    <form method="get" action="<?= base_url('Support/SupportAttendance/Report') ?>" class="row g-3 align-items-end">
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
                            <button type="submit" class="btn btn-primary w-100 text-white">
                                <i class="bi bi-search me-1"></i> ดูรายงาน
                            </button>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= base_url('Support/SupportAttendance/History?month=' . $month . '&year=' . $year) ?>" class="btn btn-outline-info w-100">
                                <i class="bi bi-table me-1"></i> ดูรายละเอียดประวัติ
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Title -->
    <div class="alert alert-primary d-flex align-items-center mb-4 border-0" role="alert" style="background-color: rgba(79, 70, 229, 0.1); color: #4f46e5;">
        <i class="bi bi-person-badge me-2 fs-4"></i>
        <div>
            <strong class="fs-6"><?= esc($fullname) ?></strong> —
            รายงานสรุปการเช็คชื่อ เดือน <?= $months[$month] ?? '' ?> พ.ศ. <?= $year + 543 ?>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-4 mb-4">
        <div class="col-lg col-md-4 col-6">
            <div class="stat-card border">
                <div class="stat-icon bg-label-primary text-primary"><i class="bi bi-calendar-check"></i></div>
                <div class="stat-number text-primary"><?= array_sum($summary) ?></div>
                <div class="stat-label fw-bold">จำนวนวันที่มีประวัติ</div>
            </div>
        </div>
        <div class="col-lg col-md-4 col-6">
            <div class="stat-card border">
                <div class="stat-icon bg-label-success text-success"><i class="bi bi-check-circle-fill"></i></div>
                <div class="stat-number text-success"><?= $summary['ปกติ'] ?></div>
                <div class="stat-label fw-bold">มาปกติ (วัน)</div>
            </div>
        </div>
        <div class="col-lg col-md-4 col-6">
            <div class="stat-card border">
                <div class="stat-icon bg-label-info text-info" style="background-color: rgba(13, 110, 253, 0.1); color: #0d6efd;"><i class="bi bi-calendar2-range-fill"></i></div>
                <div class="stat-number" style="color: #0d6efd;"><?= $summary['ลา'] ?></div>
                <div class="stat-label fw-bold">วันลา (วัน)</div>
            </div>
        </div>
        <div class="col-lg col-md-4 col-6">
            <div class="stat-card border">
                <div class="stat-icon bg-label-warning text-warning"><i class="bi bi-exclamation-triangle-fill"></i></div>
                <div class="stat-number text-warning"><?= $summary['มาสาย'] ?></div>
                <div class="stat-label fw-bold">มาสาย (วัน)</div>
            </div>
        </div>
        <div class="col-lg col-md-4 col-6">
            <div class="stat-card border">
                <div class="stat-icon bg-label-danger text-danger"><i class="bi bi-x-circle-fill"></i></div>
                <div class="stat-number text-danger"><?= $summary['ขาด'] ?></div>
                <div class="stat-label fw-bold">ขาดงาน (วัน)</div>
            </div>
        </div>
    </div>

    <!-- Chart -->
    <div class="chart-card mb-4 border">
        <h5 class="mb-3 fw-bold"><i class="bi bi-pie-chart me-2 text-primary"></i>กราฟสรุปสัดส่วนการปฏิบัติงาน</h5>
        <div id="chart-summary" style="height: 350px;"></div>
    </div>

    <!-- Attendance Record Table -->
    <div class="chart-card border p-0 overflow-hidden">
        <div class="card-header border-bottom bg-light px-4 py-3">
            <ul class="nav nav-tabs card-header-tabs m-0" id="reportTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-bold text-primary" id="app-report-tab" data-bs-toggle="tab" data-bs-target="#app-report-content" type="button" role="tab" aria-controls="app-report-content" aria-selected="true">
                        <i class="bi bi-phone me-1"></i> รายละเอียดจากแอป
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold text-primary" id="official-report-tab" data-bs-toggle="tab" data-bs-target="#official-report-content" type="button" role="tab" aria-controls="official-report-content" aria-selected="false">
                        <i class="bi bi-fingerprint me-1"></i> รายละเอียดจากเครื่องสแกนนิ้ว/ใบลา
                    </button>
                </li>
            </ul>
        </div>
        <div class="tab-content p-4" id="reportTabsContent">
            <!-- Tab 1: App Records -->
            <div class="tab-pane fade show active" id="app-report-content" role="tabpanel" aria-labelledby="app-report-tab">
                <?php if (empty($records)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-inbox fs-1 text-muted"></i>
                        <p class="text-muted mt-2">ไม่พบข้อมูลการลงเวลางานจากแอปประจำเดือนนี้</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr class="table-light">
                                    <th class="text-center" width="50">#</th>
                                    <th>วันที่</th>
                                    <th>เวลาเข้า</th>
                                    <th>เวลาออก</th>
                                    <th>ระยะเวลาปฏิบัติงาน</th>
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

                                    // คำนวณระยะเวลาทำงาน
                                    $workHours = '-';
                                    if ($r['check_in'] && $r['check_out']) {
                                        $t1 = strtotime($r['check_in']);
                                        $t2 = strtotime($r['check_out']);
                                        $diff = $t2 - $t1;
                                        $h = floor($diff / 3600);
                                        $m = floor(($diff % 3600) / 60);
                                        $workHours = "{$h} ชม. {$m} น.";
                                    }
                                ?>
                                <tr>
                                    <td class="text-center fw-bold"><?= $i + 1 ?></td>
                                    <td>
                                        <div class="fw-bold text-dark"><?= $dateDisplay ?></div>
                                        <small class="text-muted">วัน<?= $dayName ?></small>
                                    </td>
                                    <td>
                                        <?php if ($r['check_in']): ?>
                                            <span class="badge bg-label-primary fs-6"><?= date('H:i', strtotime($r['check_in'])) ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($r['check_out']): ?>
                                            <span class="badge bg-label-success fs-6"><?= date('H:i', strtotime($r['check_out'])) ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($r['check_in'] && $r['check_out']): ?>
                                            <span class="fw-bold text-dark fs-6"><?= $workHours ?></span>
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

            <!-- Tab 2: Official Records -->
            <div class="tab-pane fade" id="official-report-content" role="tabpanel" aria-labelledby="official-report-tab">
                <?php if (empty($officialRecords)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-inbox fs-1 text-muted"></i>
                        <p class="text-muted mt-2">ไม่พบข้อมูลการสแกนนิ้วหรือใบลาในเดือนนี้</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr class="table-primary" style="border-bottom: 2px solid #4f46e5;">
                                    <th class="text-center" width="50">#</th>
                                    <th>วันที่ (ระบบเครื่องสแกน)</th>
                                    <th><i class="bi bi-fingerprint text-primary me-1"></i>เวลาเข้าสแกนนิ้ว</th>
                                    <th><i class="bi bi-fingerprint text-success me-1"></i>เวลาออกสแกนนิ้ว</th>
                                    <th>ระยะเวลา</th>
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

                                    // คำนวณระยะเวลาทำงาน
                                    $workHours = '-';
                                    if (!empty($r['att_time']) && $r['att_time'] !== '00:00:00' && !empty($r['att_checkout']) && $r['att_checkout'] !== '00:00:00') {
                                        $t1 = strtotime($r['att_time']);
                                        $t2 = strtotime($r['att_checkout']);
                                        $diff = $t2 - $t1;
                                        $h = floor($diff / 3600);
                                        $m = floor(($diff % 3600) / 60);
                                        $workHours = "{$h} ชม. {$m} น.";
                                    }
                                ?>
                                <tr>
                                    <td class="text-center fw-bold"><?= $i + 1 ?></td>
                                    <td>
                                        <div class="fw-bold text-dark"><?= $dateDisplay ?></div>
                                        <small class="text-muted">วัน<?= $dayName ?></small>
                                    </td>
                                    <td>
                                        <?php if (!empty($r['att_time']) && $r['att_time'] !== '00:00:00'): ?>
                                            <span class="badge bg-label-primary fs-6"><i class="bi bi-clock me-1"></i><?= date('H:i', strtotime($r['att_time'])) ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($r['att_checkout']) && $r['att_checkout'] !== '00:00:00'): ?>
                                            <span class="badge bg-label-success fs-6"><i class="bi bi-clock me-1"></i><?= date('H:i', strtotime($r['att_checkout'])) ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($workHours !== '-'): ?>
                                            <span class="fw-bold text-dark fs-6"><?= $workHours ?></span>
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
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    // Pie Chart with ApexCharts
    document.addEventListener('DOMContentLoaded', function () {
        var options = {
            series: [<?= $summary['ปกติ'] ?>, <?= $summary['ลา'] ?>, <?= $summary['มาสาย'] ?>, <?= $summary['ขาด'] ?>],
            chart: {
                type: 'donut',
                height: 350,
            },
            labels: ['มาปกติ', 'วันลา', 'มาสาย', 'ขาดงาน'],
            colors: ['#28a745', '#0d6efd', '#ffc107', '#dc3545'],
            legend: {
                position: 'bottom',
                fontFamily: 'Sarabun, sans-serif',
            },
            dataLabels: {
                enabled: true,
                formatter: function (val) {
                    return Math.round(val) + '%';
                },
                style: {
                    fontFamily: 'Sarabun, sans-serif',
                },
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'รวมทั้งสิ้น',
                                fontFamily: 'Sarabun, sans-serif',
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0) + ' วัน';
                                },
                            },
                            value: {
                                fontFamily: 'Sarabun, sans-serif',
                            },
                        },
                    },
                },
            },
        };

        var chart = new ApexCharts(document.querySelector('#chart-summary'), options);
        chart.render();
    });
</script>
<?= $this->endSection() ?>
