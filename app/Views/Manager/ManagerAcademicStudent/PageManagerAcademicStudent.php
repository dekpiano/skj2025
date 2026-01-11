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
            <h4 class="fw-bold mb-0"><i class="bx bx-book-reader text-primary me-2"></i>ภาพรวมนักเรียน/ผลการเรียน</h4>
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
                นักเรียนทั้งหมด <?= number_format($student_stats['total'] ?? 0) ?> คน
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card stat-card shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <div class="stat-icon bg-label-info me-2"><i class="bx bx-book"></i></div>
                        <h6 class="mb-0">ม.ต้น</h6>
                    </div>
                    <h4 class="mb-0 fw-bold"><?= number_format($student_stats['junior'] ?? 0) ?></h4>
                    <small class="text-muted">คน</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <div class="stat-icon bg-label-primary me-2"><i class="bx bx-book-content"></i></div>
                        <h6 class="mb-0">ม.ปลาย</h6>
                    </div>
                    <h4 class="mb-0 fw-bold"><?= number_format($student_stats['senior'] ?? 0) ?></h4>
                    <small class="text-muted">คน</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <div class="stat-icon bg-label-success me-2"><i class="bx bx-male-female"></i></div>
                        <h6 class="mb-0">ชาย / หญิง</h6>
                    </div>
                    <h4 class="mb-0 fw-bold"><?= number_format($student_stats['male'] ?? 0) ?> / <?= number_format($student_stats['female'] ?? 0) ?></h4>
                    <small class="text-muted">สัดส่วนเพศ</small>
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
                    <h4 class="mb-0 fw-bold text-danger"><?= number_format($grade_summary['fail'] ?? 0) ?></h4>
                    <small class="text-muted">รายการ (ปี <?= $current_year ?>)</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-3 mb-4">
        <div class="col-lg-6">
            <div class="card chart-card shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h6 class="mb-0 fw-bold"><i class="bx bxs-user-detail text-info me-2"></i>โครงสร้างนักเรียน</h6>
                </div>
                <div class="card-body">
                    <div id="studentChart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card chart-card shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h6 class="mb-0 fw-bold"><i class="bx bx-pie-chart-alt text-success me-2"></i>คุณภาพการเรียน</h6>
                </div>
                <div class="card-body">
                    <div id="gradeChart"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Student List Toggle -->
    <div class="d-grid mb-4">
        <button class="btn btn-outline-primary rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#studentTableCollapse">
            <i class="bx bx-list-ul me-2"></i>แสดงรายชื่อนักเรียนแยกตามห้องเรียน
        </button>
    </div>

    <!-- Student Table (Collapsed) -->
    <div class="collapse" id="studentTableCollapse">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent d-flex flex-wrap justify-content-between align-items-center">
                <h5 class="mb-2 fw-bold">บัญชีรายชื่อนักเรียน</h5>
                <div class="d-flex align-items-center mb-2">
                    <label class="me-2 small fw-bold">เลือกห้องเรียน:</label>
                    <select id="classSelector" class="form-select form-select-sm" style="width: auto;">
                        <?php foreach (array_keys($grouped_students) as $index => $className): ?>
                            <option value="class-<?= $index ?>"><?= $className ?> (<?= count($grouped_students[$className]) ?> คน)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <?php foreach ($grouped_students as $classKey => $members): ?>
                    <?php $classIndex = array_search($classKey, array_keys($grouped_students)); ?>
                    <div class="class-table-container <?= $classKey !== array_key_first($grouped_students) ? 'd-none' : '' ?>" id="class-<?= $classIndex ?>">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-hover w-100 student-datatable">
                                <thead>
                                    <tr class="table-light">
                                        <th>เลขที่</th>
                                        <th>รหัสนักเรียน</th>
                                        <th>ชื่อ-นามสกุล</th>
                                        <th>ระดับชั้น</th>
                                        <th>สถานะ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($members as $student): ?>
                                        <tr>
                                            <td><?= $student->StudentNumber ?></td>
                                            <td><?= $student->StudentID ?></td>
                                            <td><strong><?= $student->StudentPrefix . $student->StudentFirstName . ' ' . $student->StudentLastName ?></strong></td>
                                            <td><span class="badge bg-label-primary"><?= $student->StudentClass ?></span></td>
                                            <td><span class="badge bg-label-success">ปกติ</span></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- DataTables JS CDN -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize DataTables for all class tables
    $('.student-datatable').DataTable({
        responsive: true,
        language: { url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/th.json' },
        pageLength: 10,
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
    });

    // Class Selector Logic
    $('#classSelector').on('change', function() {
        const targetId = $(this).val();
        $('.class-table-container').addClass('d-none');
        $('#' + targetId).removeClass('d-none');
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    });

    $('#studentTableCollapse').on('shown.bs.collapse', function () {
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    });

    // 1. Student Gender Chart
    new ApexCharts(document.querySelector("#studentChart"), {
        series: [<?= (int)$student_stats['male'] ?>, <?= (int)$student_stats['female'] ?>],
        labels: ['ชาย', 'หญิง'],
        chart: { type: 'pie', height: 300 },
        colors: ['#03c3ec', '#ff6384'],
        legend: { position: 'bottom' }
    }).render();

    // 2. Grade Distribution Chart
    const gradeChart = new ApexCharts(document.querySelector("#gradeChart"), {
        series: [<?= (int)$grade_summary['good'] ?>, <?= (int)$grade_summary['pass'] ?>, <?= (int)$grade_summary['fail'] ?>],
        labels: ['ดีเยี่ยม (3.5-4)', 'ผ่าน (1-3)', 'ไม่ผ่าน (0/ร/มส)'],
        chart: { type: 'donut', height: 300 },
        colors: ['#71dd37', '#696cff', '#ff3e1d'],
        legend: { position: 'bottom' }
    });
    gradeChart.render();

    // Date Range Filtering
    const updateGradeData = () => {
        const start = document.getElementById('startDate').value;
        const end = document.getElementById('endDate').value;
        
        fetch(`<?= base_url('Manager/Academic/StudentAnalysis') ?>?startDate=${start}&endDate=${end}`)
            .then(r => r.json())
            .then(res => {
                if (res.status) {
                    gradeChart.updateSeries([res.grade_summary.good, res.grade_summary.pass, res.grade_summary.fail]);
                    
                    // Update fail count card
                    const failCard = document.querySelector('.text-danger.fw-bold');
                    if (failCard) failCard.textContent = res.grade_summary.fail.toLocaleString();
                }
            });
    };

    document.getElementById('btnRefresh').addEventListener('click', updateGradeData);
});
</script>
<?= $this->endSection() ?>
