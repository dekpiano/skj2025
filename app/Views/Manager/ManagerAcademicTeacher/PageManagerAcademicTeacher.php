<?= $this->extend('Manager/layout/ManagerLayout') ?>

<?= $this->section('content') ?>
<style>
    .stat-card { border: none; border-radius: 12px; transition: transform 0.2s; }
    .stat-card:hover { transform: translateY(-3px); }
    .stat-icon { width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; }
    .chart-card { border: none; border-radius: 12px; }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 g-3">
        <div>
            <h4 class="fw-bold mb-0"><i class="bx bx-id-card text-primary me-2"></i>ภาพรวมครูผู้สอน</h4>
            <small class="text-muted">ปีการศึกษา <?= $schoolyear['schyear_year'] ?? $current_year ?> | ปีงบประมาณ <?= $schoolyear['schyear_fiscal'] ?? '-' ?></small>
        </div>
        <div class="d-flex flex-wrap align-items-center gap-2">
            <div class="input-group input-group-sm" style="width: auto;">
                <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                <input type="date" id="startDate" class="form-control" value="<?= $schoolyear['schyear_start_date'] ?? date('Y-m-d') ?>">
                <span class="input-group-text">ถึง</span>
                <input type="date" id="endDate" class="form-control" value="<?= $schoolyear['schyear_end_date'] ?? date('Y-m-d') ?>">
            </div>
            <button class="btn btn-sm btn-primary" id="btnRefresh"><i class="bx bx-refresh"></i> คำนวณ</button>
            <div class="badge bg-label-primary fs-6 px-3 py-2">
                ครูผู้สอนทั้งหมด <?= number_format($total_teachers ?? 0) ?> คน
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card stat-card shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <div class="stat-icon bg-label-info me-2"><i class="bx bx-book-open"></i></div>
                        <h6 class="mb-0">วิชาที่เปิดสอน</h6>
                    </div>
                    <h4 class="mb-0 fw-bold"><?= number_format($total_subjects ?? 0) ?></h4>
                    <small class="text-muted">รายวิชา</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <div class="stat-icon bg-label-primary me-2"><i class="bx bx-chalkboard"></i></div>
                        <h6 class="mb-0">ห้องเรียน</h6>
                    </div>
                    <h4 class="mb-0 fw-bold"><?= number_format($total_classes ?? 0) ?></h4>
                    <small class="text-muted">ห้อง</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <div class="stat-icon bg-label-success me-2"><i class="bx bx-check-circle"></i></div>
                        <h6 class="mb-0">ผ่านเกณฑ์</h6>
                    </div>
                    <h4 class="mb-0 fw-bold text-success"><?= number_format($total_pass ?? 0) ?></h4>
                    <small class="text-muted">รายการ</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card shadow-sm border-start border-danger border-4">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <div class="stat-icon bg-label-danger me-2"><i class="bx bx-error-alt"></i></div>
                        <h6 class="mb-0">ติด 0/ร/มส</h6>
                    </div>
                    <h4 class="mb-0 fw-bold text-danger"><?= number_format($total_fail ?? 0) ?></h4>
                    <small class="text-muted">รายการ</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-3 mb-4">
        <!-- Teaching Load Chart -->
        <div class="col-lg-6">
            <div class="card chart-card shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="mb-0 fw-bold"><i class="bx bx-bar-chart-alt-2 text-info me-2"></i>ภาระงานสอน (Top 10)</h6>
                        <small class="text-muted">จำนวนวิชา/ห้องเรียนที่รับผิดชอบ</small>
                    </div>
                    <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#modalLoadAll">
                        <i class="bx bx-expand-alt me-1"></i>ดูทั้งหมด
                    </button>
                </div>
                <div class="card-body">
                    <div id="loadChart"></div>
                </div>
            </div>
        </div>
        <!-- Teaching Performance Chart -->
        <div class="col-lg-6">
            <div class="card chart-card shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="mb-0 fw-bold"><i class="bx bx-pie-chart-alt text-danger me-2"></i>อัตราติด 0/ร/มส (Top 10)</h6>
                        <small class="text-muted">เรียงจากมากไปน้อย</small>
                    </div>
                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalFailAll">
                        <i class="bx bx-expand-alt me-1"></i>ดูทั้งหมด
                    </button>
                </div>
                <div class="card-body">
                    <div id="performanceChart"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Teaching Load All -->
    <div class="modal fade" id="modalLoadAll" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bx bx-bar-chart-alt-2 text-info me-2"></i>ภาระงานสอนทั้งหมด</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-sm table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>ครูผู้สอน</th>
                                <th class="text-center">วิชา</th>
                                <th class="text-center">ห้อง</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach ($teacher_stats as $t): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $t['name'] ?></td>
                                    <td class="text-center fw-bold text-primary"><?= $t['subjects'] ?></td>
                                    <td class="text-center fw-bold text-info"><?= $t['classes'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Fail Rate All -->
    <div class="modal fade" id="modalFailAll" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bx bx-error-alt text-danger me-2"></i>อัตราติด 0/ร/มส ทั้งหมด</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-sm table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>ครูผู้สอน</th>
                                <th class="text-center">ไม่ผ่าน</th>
                                <th class="text-center">ทั้งหมด</th>
                                <th class="text-center">อัตรา</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach ($performance_stats as $t): ?>
                                <?php $rate = $t['total'] > 0 ? round(($t['fail'] / $t['total']) * 100, 1) : 0; ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $t['name'] ?></td>
                                    <td class="text-center text-danger fw-bold"><?= number_format($t['fail']) ?></td>
                                    <td class="text-center"><?= number_format($t['total']) ?></td>
                                    <td class="text-center">
                                        <span class="badge <?= $rate > 10 ? 'bg-danger' : ($rate > 5 ? 'bg-warning' : 'bg-success') ?>">
                                            <?= $rate ?>%
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Teaching Load Table -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-transparent d-flex flex-wrap justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="bx bx-table me-2"></i>ภาระงานสอนรายบุคคล</h5>
            <div class="d-flex align-items-center">
                <label class="me-2 small fw-bold">เลือกกลุ่มสาระ:</label>
                <select id="learningSelector" class="form-select form-select-sm" style="width: auto;">
                    <option value="all">ทั้งหมด (<?= count($teacher_stats) ?> คน)</option>
                    <?php foreach ($grouped_by_learning as $groupName => $members): ?>
                        <option value="group-<?= array_search($groupName, array_keys($grouped_by_learning)) ?>"><?= $groupName ?> (<?= count($members) ?> คน)</option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="card-body">
            <!-- All Teachers Table -->
            <div class="learning-table-container" id="group-all">
                <div class="table-responsive">
                    <table class="table table-hover" id="table-load-all">
                        <thead>
                            <tr class="table-light">
                                <th>ครูผู้สอน</th>
                                <th>กลุ่มสาระ</th>
                                <th class="text-center">วิชา</th>
                                <th class="text-center">ห้อง</th>
                                <th class="text-center">ผ่าน</th>
                                <th class="text-center">ไม่ผ่าน</th>
                                <th class="text-center">อัตรา</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($teacher_stats as $t): ?>
                                <tr>
                                    <td><strong><?= $t['name'] ?></strong></td>
                                    <td><span class="badge bg-label-info"><?= $t['learning_name'] ?></span></td>
                                    <td class="text-center"><?= $t['subjects'] ?></td>
                                    <td class="text-center"><?= $t['classes'] ?></td>
                                    <td class="text-center text-success"><?= number_format($t['pass']) ?></td>
                                    <td class="text-center text-danger"><?= number_format($t['fail']) ?></td>
                                    <td class="text-center">
                                        <?php $rate = $t['total'] > 0 ? round(($t['fail'] / $t['total']) * 100, 1) : 0; ?>
                                        <span class="badge <?= $rate > 10 ? 'bg-danger' : ($rate > 5 ? 'bg-warning' : 'bg-success') ?>">
                                            <?= $rate ?>%
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Grouped Tables -->
            <?php $groupIndex = 0; foreach ($grouped_by_learning as $groupName => $members): ?>
                <div class="learning-table-container d-none" id="group-<?= $groupIndex ?>">
                    <div class="alert alert-info mb-3">
                        <i class="bx bx-book-reader me-2"></i><strong><?= $groupName ?></strong> - <?= count($members) ?> คน
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr class="table-light">
                                    <th>ครูผู้สอน</th>
                                    <th class="text-center">วิชา</th>
                                    <th class="text-center">ห้อง</th>
                                    <th class="text-center">ผ่าน</th>
                                    <th class="text-center">ไม่ผ่าน</th>
                                    <th class="text-center">อัตรา</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($members as $t): ?>
                                    <tr>
                                        <td><strong><?= $t['name'] ?></strong></td>
                                        <td class="text-center"><?= $t['subjects'] ?></td>
                                        <td class="text-center"><?= $t['classes'] ?></td>
                                        <td class="text-center text-success"><?= number_format($t['pass']) ?></td>
                                        <td class="text-center text-danger"><?= number_format($t['fail']) ?></td>
                                        <td class="text-center">
                                            <?php $rate = $t['total'] > 0 ? round(($t['fail'] / $t['total']) * 100, 1) : 0; ?>
                                            <span class="badge <?= $rate > 10 ? 'bg-danger' : ($rate > 5 ? 'bg-warning' : 'bg-success') ?>">
                                                <?= $rate ?>%
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php $groupIndex++; endforeach; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Teaching Load Chart (Bar)
    const loadLabels = [<?php foreach(array_slice($teacher_stats, 0, 10) as $t) echo '"'.addslashes($t['name']).'",'; ?>];
    const loadSubjects = [<?php foreach(array_slice($teacher_stats, 0, 10) as $t) echo $t['subjects'].','; ?>];
    const loadClasses = [<?php foreach(array_slice($teacher_stats, 0, 10) as $t) echo $t['classes'].','; ?>];

    new ApexCharts(document.querySelector("#loadChart"), {
        series: [
            { name: 'วิชา', data: loadSubjects },
            { name: 'ห้อง', data: loadClasses }
        ],
        chart: { type: 'bar', height: 350, toolbar: {show: false} },
        plotOptions: { bar: { horizontal: true, borderRadius: 4, dataLabels: { position: 'top' } } },
        colors: ['#696cff', '#03c3ec'],
        dataLabels: { enabled: true, offsetX: -6, style: { fontSize: '11px', colors: ['#fff'] } },
        xaxis: { categories: loadLabels },
        legend: { position: 'top' }
    }).render();

    // Teaching Performance Chart (Fail Rate)
    const perfLabels = [<?php foreach(array_slice($performance_stats, 0, 10) as $t) echo '"'.addslashes($t['name']).'",'; ?>];
    const perfRates = [<?php foreach(array_slice($performance_stats, 0, 10) as $t) echo round(($t['fail'] / max($t['total'], 1)) * 100, 1).','; ?>];

    const perfChart = new ApexCharts(document.querySelector("#performanceChart"), {
        series: [{ name: 'อัตราไม่ผ่าน (%)', data: perfRates }],
        chart: { type: 'bar', height: 350, toolbar: {show: false} },
        plotOptions: { bar: { horizontal: true, borderRadius: 4, distributed: true } },
        colors: ['#ff3e1d', '#ff6384', '#ff9f43', '#ffab00', '#ffc107', '#71dd37', '#28c76f', '#03c3ec', '#696cff', '#8592a3'],
        dataLabels: { enabled: true, formatter: (val) => val + '%', style: { fontSize: '11px' } },
        xaxis: { categories: perfLabels, labels: { formatter: (val) => val + '%' } },
        legend: { show: false }
    });
    perfChart.render();

    // Learning Group Selector
    $('#learningSelector').on('change', function() {
        const targetId = $(this).val();
        $('.learning-table-container').addClass('d-none');
        if (targetId === 'all') {
            $('#group-all').removeClass('d-none');
        } else {
            $('#' + targetId).removeClass('d-none');
        }
    });

    // Date Range Filtering
    const updateTeacherData = () => {
        const start = document.getElementById('startDate').value;
        const end = document.getElementById('endDate').value;
        
        fetch(`<?= base_url('Manager/Academic/TeacherAnalysis') ?>?startDate=${start}&endDate=${end}`)
            .then(r => r.json())
            .then(res => {
                if (res.status) {
                    // Update performance chart
                    const newLabels = res.performance.map(p => p.name);
                    const newRates = res.performance.map(p => p.rate);
                    
                    perfChart.updateOptions({ xaxis: { categories: newLabels } });
                    perfChart.updateSeries([{ name: 'อัตราไม่ผ่าน (%)', data: newRates }]);
                    
                    // Update stat cards
                    const passCard = document.querySelector('.stat-icon.bg-label-success')?.closest('.card')?.querySelector('h4');
                    const failCard = document.querySelector('.stat-icon.bg-label-danger')?.closest('.card')?.querySelector('h4');
                    if (passCard) passCard.textContent = res.total_pass.toLocaleString();
                    if (failCard) failCard.textContent = res.total_fail.toLocaleString();
                }
            });
    };

    document.getElementById('btnRefresh').addEventListener('click', updateTeacherData);
});
</script>
<?= $this->endSection() ?>
