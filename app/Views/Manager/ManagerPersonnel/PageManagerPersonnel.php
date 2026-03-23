<?= $this->extend('Manager/layout/ManagerLayout') ?>

<?= $this->section('content') ?>
<style>
    .stat-card {
        border: none;
        border-radius: 12px;
        transition: transform 0.2s ease;
    }
    .stat-card:hover {
        transform: translateY(-3px);
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    .chart-card {
        border: none;
        border-radius: 12px;
    }
    .person-card {
        border: none;
        border-radius: 10px;
        transition: all 0.2s ease;
        overflow: hidden;
    }
    .person-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08) !important;
    }
    .person-img {
        width: 100%;
        aspect-ratio: 1;
        object-fit: cover;
    }
    .person-info {
        padding: 12px;
        text-align: center;
    }
    .person-name {
        font-weight: 700;
        font-size: 0.85rem;
        color: #333;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .person-pos {
        font-size: 0.75rem;
        color: #697a8d;
    }
    .group-title {
        font-size: 1rem;
        font-weight: 700;
        color: #566a7f;
        border-left: 4px solid #696cff;
        padding-left: 12px;
        margin: 24px 0 16px;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0"><i class="bx bx-group text-primary me-2"></i>ภาพรวมบุคลากร</h4>
            <small class="text-muted">ภาพรวมและรายชื่อบุคลากรทั้งหมด</small>
        </div>
        <span class="badge bg-primary rounded-pill fs-6 px-3 py-2"><?= number_format($total_count) ?> ท่าน</span>
    </div>


    <!-- Charts Row -->
    <div class="row g-3 mb-4">
        <!-- Attendance Summary -->
        <div class="col-lg-5">
            <div class="card chart-card shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pb-1 d-flex flex-wrap justify-content-between align-items-center">
                    <h6 class="mb-2 fw-bold"><i class="bx bx-pie-chart-alt text-primary me-2"></i>สรุปการปฏิบัติงาน</h6>
                    <div class="d-flex align-items-center mb-2">
                        <input type="date" id="startDate" class="form-control form-control-sm me-1" value="<?= date('Y-m-d') ?>" style="width: auto;">
                        <span class="me-1">-</span>
                        <input type="date" id="endDate" class="form-control form-control-sm me-2" value="<?= date('Y-m-d') ?>" style="width: auto;">
                        <button class="btn btn-xs btn-label-primary" id="btnAnalysis">
                            <i class="bx bx-analyse me-1"></i>วิเคราะห์
                        </button>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div id="attendanceChart"></div>
                    <div class="text-center mt-n2">
                        <small class="text-muted" id="currentDateRange">ข้อมูลประจำวันที่: <?= date('d/m/Y') ?></small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Learning Group Proportion -->
        <div class="col-lg-7">
            <div class="card chart-card shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h6 class="mb-0 fw-bold"><i class="bx bx-bar-chart-alt-2 text-primary me-2"></i>สัดส่วนบุคลากรรายกลุ่มสาระ</h6>
                </div>
                <div class="card-body pt-2">
                    <div id="learningChart"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Personnel List Toggle -->
    <div class="d-grid mb-4">
        <button class="btn btn-outline-primary rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#personnelList" aria-expanded="false">
            <i class="bx bx-chevron-down me-2"></i>แสดงรายชื่อบุคลากรทั้งหมด
        </button>
    </div>

    <!-- Personnel List (Collapsed) -->
    <div class="collapse" id="personnelList">
        <?php if (isset($grouped_data['management'])): ?>
            <?php foreach ($grouped_data['management'] as $group): ?>
                <div class="group-title">
                    <i class="bx bx-crown me-1 text-warning"></i><?= $group['name'] ?> 
                    <span class="badge bg-warning rounded-pill ms-2"><?= count($group['members']) ?></span>
                </div>
                <div class="row g-3 mb-4">
                    <?php foreach ($group['members'] as $person): ?>
                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="card person-card shadow-sm h-100 border-warning border-top border-3" role="button" data-id="<?= $person['pers_id'] ?>">
                            <?php if (!empty($person['pers_img'])): ?>
                                <img src="https://personnel.skj.ac.th/uploads/admin/Personnal/<?= $person['pers_img'] ?>" class="person-img" onerror="this.src='<?= base_url('assets/admin/assets/img/avatars/1.png') ?>'" />
                            <?php else: ?>
                                <img src="<?= base_url('assets/admin/assets/img/avatars/1.png') ?>" class="person-img" />
                            <?php endif; ?>
                            <div class="person-info">
                                <div class="person-name" title="<?= $person['pers_prefix'] . $person['pers_firstname'] . ' ' . $person['pers_lastname'] ?>">
                                    <?= $person['pers_firstname'] ?> <?= mb_substr($person['pers_lastname'], 0, 1) ?>.
                                </div>
                                <div class="person-pos fw-bold text-primary"><?= $person['posi_name'] ?? '-' ?></div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (isset($grouped_data['learning'])): ?>
            <?php foreach ($grouped_data['learning'] as $group): ?>
                <div class="group-title">
                    <i class="bx bx-book-reader me-1"></i><?= $group['name'] ?> 
                    <span class="badge bg-primary rounded-pill ms-2"><?= count($group['members']) ?></span>
                </div>
                <div class="row g-3 mb-3">
                    <?php foreach ($group['members'] as $person): ?>
                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="card person-card shadow-sm h-100" role="button" data-id="<?= $person['pers_id'] ?>">
                            <?php if (!empty($person['pers_img'])): ?>
                                <img src="https://personnel.skj.ac.th/uploads/admin/Personnal/<?= $person['pers_img'] ?>" class="person-img" onerror="this.src='<?= base_url('assets/admin/assets/img/avatars/1.png') ?>'" />
                            <?php else: ?>
                                <img src="<?= base_url('assets/admin/assets/img/avatars/1.png') ?>" class="person-img" />
                            <?php endif; ?>
                            <div class="person-info">
                                <div class="person-name" title="<?= $person['pers_prefix'] . $person['pers_firstname'] . ' ' . $person['pers_lastname'] ?>">
                                    <?= $person['pers_firstname'] ?> <?= mb_substr($person['pers_lastname'], 0, 1) ?>.
                                </div>
                                <div class="person-pos"><?= $person['posi_name'] ?? '-' ?></div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (isset($grouped_data['support'])): ?>
            <div class="group-title">
                <i class="bx bx-support me-1"></i>บุคลากรสายสนับสนุน
                <span class="badge bg-secondary rounded-pill ms-2"><?= count($grouped_data['support'][0]['members']) ?></span>
            </div>
            <div class="row g-3 mb-3">
                <?php foreach ($grouped_data['support'][0]['members'] as $person): ?>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card person-card shadow-sm h-100" role="button" data-id="<?= $person['pers_id'] ?>">
                        <?php if (!empty($person['pers_img'])): ?>
                            <img src="https://personnel.skj.ac.th/uploads/admin/Personnal/<?= $person['pers_img'] ?>" class="person-img" onerror="this.src='<?= base_url('assets/admin/assets/img/avatars/1.png') ?>'" />
                        <?php else: ?>
                            <img src="<?= base_url('assets/admin/assets/img/avatars/1.png') ?>" class="person-img" />
                        <?php endif; ?>
                        <div class="person-info">
                            <div class="person-name"><?= $person['pers_firstname'] ?> <?= mb_substr($person['pers_lastname'], 0, 1) ?>.</div>
                            <div class="person-pos"><?= $person['posi_name'] ?? '-' ?></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

</div>

<!-- Personnel Detail Modal -->
<div class="modal fade" id="personnelModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white"><i class="bx bx-user me-2"></i>ข้อมูลประวัติบุคลากร</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0" id="modalContent">
                <div class="text-center p-5">
                    <div class="spinner-border text-primary" role="status"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Attendance Analysis Modal -->
<div class="modal fade" id="analysisModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white"><i class="bx bx-analyse me-2"></i>วิเคราะห์การปฏิบัติงานและสถิติการลา</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <ul class="nav nav-tabs nav-fill" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-stats"><i class="bx bx-stats me-1"></i>สถิติการลา</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-abnormal"><i class="bx bx-error-circle me-1"></i>ลาบ่อยผิดปกติ</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-late"><i class="bx bx-time me-1"></i>สาย/ขาด/ไม่ลงเวลา</button>
                    </li>
                </ul>
                <div class="tab-content p-4">
                    <div class="tab-pane fade show active" id="tab-stats">
                        <div id="analysisStatsContent"></div>
                    </div>
                    <div class="tab-pane fade" id="tab-abnormal">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ชื่อ-นามสกุล</th>
                                        <th class="text-center">ลาป่วย (วัน)</th>
                                        <th class="text-center">ลากิจ (วัน)</th>
                                        <th class="text-center">รวมทั้งหมด</th>
                                    </tr>
                                </thead>
                                <tbody id="abnormalTableBody"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-late">
                        <div class="row g-3" id="lateAbsentContent"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
(function() {
    // Stats Data
    const stats = <?= json_encode($stats) ?>;
    const leaveStats = <?= json_encode($leaveStats) ?>;

    // 1. Learning Chart
    new ApexCharts(document.querySelector("#learningChart"), {
        series: [{ name: 'จำนวน', data: stats.learning_counts }],
        chart: { type: 'bar', height: 280, toolbar: { show: false } },
        plotOptions: { bar: { borderRadius: 6, distributed: true, horizontal: false } },
        colors: ['#696cff', '#71dd37', '#03c3ec', '#ffab00', '#ff3e1d', '#8592a3', '#FB7E9C', '#249ffd'],
        dataLabels: { enabled: true, style: { fontSize: '12px' } },
        xaxis: { categories: stats.learning_labels, labels: { style: { fontSize: '10px' } } },
        legend: { show: false }
    }).render();

    // 2. Attendance Chart
    const attendanceChart = new ApexCharts(document.querySelector("#attendanceChart"), {
        series: leaveStats.data,
        labels: leaveStats.labels,
        chart: { type: 'donut', height: 280 },
        colors: ['#71dd37', '#ffab00', '#ff3e1d', '#03c3ec', '#696cff'],
        legend: { position: 'bottom', fontSize: '11px' },
        plotOptions: { pie: { donut: { size: '65%', labels: { show: true, total: { show: true, label: 'รวม' } } } } }
    });
    attendanceChart.render();

    // Re-fetch Chart Data when dates change (Optional but better for UX)
    const updateAttendanceSummary = () => {
        const start = document.getElementById('startDate').value;
        const end = document.getElementById('endDate').value;
        const rangeText = start === end ? `ข้อมูลประจำวันที่: ${start.split('-').reverse().join('/')}` : `ช่วงวันที่: ${start.split('-').reverse().join('/')} - ${end.split('-').reverse().join('/')}`;
        document.getElementById('currentDateRange').innerText = rangeText;

        fetch(`<?= base_url('Manager/Personnel/AttendanceAnalysis') ?>?startDate=${start}&endDate=${end}`)
            .then(r => r.json())
            .then(res => {
                if (res.status) {
                    attendanceChart.updateSeries(res.summary_data);
                }
            });
    };

    document.getElementById('startDate').addEventListener('change', updateAttendanceSummary);
    document.getElementById('endDate').addEventListener('change', updateAttendanceSummary);

    // Person Card Click
    document.querySelectorAll('.person-card').forEach(card => {
        card.addEventListener('click', function() {
            const id = this.dataset.id;
            const modal = new bootstrap.Modal(document.getElementById('personnelModal'));
            document.getElementById('modalContent').innerHTML = '<div class="spinner-border text-primary" role="status"></div>';
            modal.show();

            fetch(`<?= base_url('Manager/Personnel/Detail') ?>/${id}`)
                .then(r => r.json())
                .then(res => {
                    if (res.status) {
                        const p = res.data;
                        const imgSrc = p.pers_img ? `https://personnel.skj.ac.th/uploads/admin/Personnal/${p.pers_img}` : 'https://personnel.skj.ac.th/assets/img/avatars/1.png';
                        
                        let html = `
                            <div class="nav-align-top">
                                <ul class="nav nav-tabs nav-fill" role="tablist">
                                    <li class="nav-item">
                                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-profile"><i class="bx bx-info-circle me-1"></i>ทั่วไป</button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-edu"><i class="bx bx-graduation me-1"></i>การศึกษา</button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-work"><i class="bx bx-history me-1"></i>การทำงาน</button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-train"><i class="bx bx-award me-1"></i>การอบรม</button>
                                    </li>
                                </ul>
                                <div class="tab-content p-4">
                                    <!-- Profile -->
                                    <div class="tab-pane fade show active" id="tab-profile">
                                        <div class="row">
                                            <div class="col-md-4 text-center mb-4">
                                                <img src="${imgSrc}" class="rounded-3 shadow-sm mb-3" style="width:150px; height:180px; object-fit:cover;" onerror="this.src='https://academic.skj.ac.th/assets/img/avatars/1.png'">
                                                <h6 class="fw-bold mb-1">${p.pers_prefix}${p.pers_firstname} ${p.pers_lastname}</h6>
                                                <span class="badge bg-label-primary">${p.posi_name || '-'}</span>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="row g-3 text-start">
                                                    <div class="col-sm-6"><label class="small text-muted d-block">กลุ่มสาระ</label><span class="fw-bold">${p.learning_name || '-'}</span></div>
                                                    <div class="col-sm-6"><label class="small text-muted d-block">วิทยฐานะ</label><span class="fw-bold">${p.pers_academic || '-'}</span></div>
                                                    <div class="col-sm-6"><label class="small text-muted d-block">เบอร์โทรศัพท์</label><span class="fw-bold">${p.pers_phone || '-'}</span></div>
                                                    <div class="col-sm-6"><label class="small text-muted d-block">สถานะ</label><span class="fw-bold">${p.pers_status || '-'}</span></div>
                                                    <div class="col-sm-12"><label class="small text-muted d-block">ที่อยู่</label><span class="fw-bold">${p.pers_address || '-'}</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Education -->
                                    <div class="tab-pane fade" id="tab-edu">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-hover text-start">
                                                <thead><tr class="table-light"><th>วุฒิ</th><th>วิชาเอก</th><th>สถาบัน</th><th>ปีที่จบ</th></tr></thead>
                                                <tbody>
                                                    ${res.education.map(e => `<tr><td>${e.edu_level}${e.edu_degree}</td><td>${e.edu_major}</td><td>${e.edu_institute}</td><td>${e.edu_year}</td></tr>`).join('') || '<tr><td colspan="4" class="text-center">ไม่พบข้อมูล</td></tr>'}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- Work History -->
                                    <div class="tab-pane fade" id="tab-work">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-hover text-start">
                                                <thead><tr class="table-light"><th>วันที่</th><th>ตำแหน่ง</th><th>หน่วยงาน</th><th>เงินเดือน</th></tr></thead>
                                                <tbody>
                                                    ${res.work_history.map(w => `<tr><td>${w.work_date}</td><td>${w.work_position}</td><td>${w.work_location}</td><td>${w.work_salary}</td></tr>`).join('') || '<tr><td colspan="4" class="text-center">ไม่พบข้อมูล</td></tr>'}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- Training -->
                                    <div class="tab-pane fade" id="tab-train">
                                        <div class="list-group list-group-flush text-start">
                                            ${res.training.map(t => `<li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                <div><div class="fw-bold">${t.train_name}</div><small class="text-muted">${t.train_location} (${t.train_start_date})</small></div>
                                                <span class="badge bg-label-info">${t.train_hours} ชม.</span>
                                            </li>`).join('') || '<div class="text-center py-3">ไม่พบข้อมูล</div>'}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        document.getElementById('modalContent').innerHTML = html;
                    } else {
                        document.getElementById('modalContent').innerHTML = '<p class="text-danger">ไม่พบข้อมูล</p>';
                    }
                })
                .catch(() => {
                    document.getElementById('modalContent').innerHTML = '<p class="text-danger">เกิดข้อผิดพลาด</p>';
                });
        });
    });

    // Attendance Analysis
    document.getElementById('btnAnalysis').addEventListener('click', function() {
        const modal = new bootstrap.Modal(document.getElementById('analysisModal'));
        modal.show();
        
        const statsEl = document.getElementById('analysisStatsContent');
        const abnormalEl = document.getElementById('abnormalTableBody');
        const lateEl = document.getElementById('lateAbsentContent');

        statsEl.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary"></div></div>';
        abnormalEl.innerHTML = '';
        lateEl.innerHTML = '';

        const start = document.getElementById('startDate').value;
        const end = document.getElementById('endDate').value;

        fetch(`<?= base_url('Manager/Personnel/AttendanceAnalysis') ?>?startDate=${start}&endDate=${end}`)
            .then(r => r.json())
            .then(res => {
                if (res.status) {
                    // 1. Stats
                    let statsHtml = '<div class="row g-3">';
                    res.leave_details.forEach(item => {
                        statsHtml += `
                            <div class="col-6 col-md-3">
                                <div class="card bg-label-${item.color} border-0 text-center p-3">
                                    <i class="bx ${item.icon} fs-2 mb-2"></i>
                                    <h5 class="mb-0 fw-bold">${item.value}</h5>
                                    <small>${item.label}</small>
                                </div>
                            </div>
                        `;
                    });
                    statsHtml += '</div>';
                    statsEl.innerHTML = statsHtml;

                    // 2. Abnormal
                    let abnormalHtml = '';
                    res.abnormal.forEach(item => {
                        abnormalHtml += `
                            <tr>
                                <td>${item.name}</td>
                                <td class="text-center">${item.sick}</td>
                                <td class="text-center">${item.personal}</td>
                                <td class="text-center fw-bold text-danger">${item.total}</td>
                            </tr>
                        `;
                    });
                    abnormalEl.innerHTML = abnormalHtml;

                    // 3. Late/Absent
                    let lateHtml = '';
                    // Late
                    res.late_report.late.forEach(item => {
                        lateHtml += `
                            <div class="col-md-6">
                                <div class="d-flex align-items-center bg-light p-2 rounded">
                                    <div class="badge bg-warning me-2">สาย</div>
                                    <div class="flex-grow-1 small fw-bold">${item.name}</div>
                                    <div class="small text-muted">${item.time}</div>
                                </div>
                            </div>
                        `;
                    });
                    // Absent
                    res.late_report.absent.forEach(item => {
                        lateHtml += `
                            <div class="col-md-6">
                                <div class="d-flex align-items-center bg-light p-2 rounded">
                                    <div class="badge bg-danger me-2">ขาด</div>
                                    <div class="flex-grow-1 small fw-bold">${item.name}</div>
                                </div>
                            </div>
                        `;
                    });
                    // No clock in
                    res.late_report.no_clock_in.forEach(item => {
                        lateHtml += `
                            <div class="col-md-6">
                                <div class="d-flex align-items-center bg-light p-2 rounded">
                                    <div class="badge bg-secondary me-2">ไม่ลงเวลา</div>
                                    <div class="flex-grow-1 small fw-bold">${item.name}</div>
                                </div>
                            </div>
                        `;
                    });
                    lateEl.innerHTML = lateHtml || '<div class="col-12 text-center text-muted">ไม่พบข้อมูลความผิดปกติ</div>';
                }
            });
    });
})();
</script>
<?= $this->endSection() ?>
