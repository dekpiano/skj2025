<?= $this->extend('Manager/layout/ManagerLayout') ?>

<?= $this->section('content') ?>
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #696cff, #4044ee);
        --warning-gradient: linear-gradient(135deg, #ffab00, #ffc233);
        --success-gradient: linear-gradient(135deg, #71dd37, #8ee85c);
        --card-border-color: rgba(67, 89, 113, 0.08);
    }

    /* Modern Chart Cards */
    .chart-card {
        border: 1px solid var(--card-border-color);
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.02);
        background: #fff;
    }

    /* Navigation Sidebar / Pills */
    .group-nav-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 16px;
        border-radius: 12px;
        color: #566a7f;
        text-decoration: none;
        transition: all 0.25s ease;
        margin-bottom: 6px;
        background: transparent;
        border: 1px solid transparent;
        font-weight: 500;
    }
    .group-nav-link:hover {
        background: rgba(105, 108, 255, 0.04);
        color: #696cff;
    }
    .group-nav-link.active {
        background: #e7e7ff;
        color: #696cff;
        font-weight: 600;
        border-color: rgba(105, 108, 255, 0.15);
    }
    .group-nav-link .badge {
        font-size: 0.75rem;
        padding: 5px 10px;
    }

    /* Personnel Cards */
    .person-card {
        border: 1px solid var(--card-border-color);
        border-radius: 16px;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        overflow: hidden;
        cursor: pointer;
        background: #fff;
        height: 100%;
        position: relative;
    }
    .person-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 32px rgba(105, 108, 255, 0.08) !important;
        border-color: rgba(105, 108, 255, 0.2);
    }
    
    .person-img-wrapper {
        position: relative;
        width: 100%;
        padding-top: 115%; /* aspect ratio */
        background: #f5f5f9;
        overflow: hidden;
    }

    .person-img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .person-card:hover .person-img {
        transform: scale(1.06);
    }

    .person-info {
        padding: 16px;
        text-align: center;
        background: #fff;
    }
    .person-name {
        font-weight: 700;
        font-size: 0.9rem;
        color: #435971;
        margin-bottom: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .person-pos {
        font-size: 0.76rem;
        color: #8e9ba5;
        font-weight: 500;
    }

    /* Custom Scrollbar for group menu */
    .group-menu-scroll {
        max-height: 480px;
        overflow-y: auto;
        padding-right: 4px;
    }
    .group-menu-scroll::-webkit-scrollbar {
        width: 5px;
    }
    .group-menu-scroll::-webkit-scrollbar-thumb {
        background: rgba(67, 89, 113, 0.1);
        border-radius: 4px;
    }

    .search-wrapper {
        position: relative;
    }
    .search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #a1b0cb;
        font-size: 1.2rem;
    }
    .search-input {
        padding-left: 42px;
        border-radius: 12px;
        border: 1px solid var(--card-border-color);
        transition: all 0.3s;
    }
    .search-input:focus {
        border-color: #696cff;
        box-shadow: 0 0 0 0.2rem rgba(105, 108, 255, 0.15);
    }

    .nav-tabs .nav-link {
        border: none;
        color: #566a7f;
        font-weight: 500;
        padding: 12px 20px;
        border-bottom: 2px solid transparent;
    }
    .nav-tabs .nav-link.active {
        color: #696cff;
        border-bottom-color: #696cff;
        font-weight: 600;
        background: transparent;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div class="d-flex align-items-center">
            <a href="<?= base_url('Manager/Personnel') ?>" class="btn btn-outline-secondary btn-icon rounded-circle me-3">
                <i class="bx bx-left-arrow-alt"></i>
            </a>
            <div>
                <h4 class="fw-bold mb-1" style="color: #435971;">ทำเนียบบุคลากร</h4>
                <p class="text-muted mb-0">ระบบจัดหมวดหมู่ วิเคราะห์สถิติ และค้นหาประวัติรายบุคคล</p>
            </div>
        </div>
        <div>
            <span class="badge bg-label-primary p-2 px-3 rounded-pill fs-6">
                <i class="bx bx-group me-1"></i> บุคลากรทั้งหมด <?= number_format($total_count) ?> ท่าน
            </span>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <!-- Attendance Summary -->
        <div class="col-lg-5">
            <div class="card chart-card h-100">
                <div class="card-header bg-transparent border-0 pb-1 d-flex flex-wrap justify-content-between align-items-center">
                    <h6 class="mb-2 fw-bold" style="color: #435971;"><i class="bx bx-pie-chart-alt text-primary me-2"></i>สรุปการปฏิบัติงาน</h6>
                    <div class="d-flex align-items-center mb-2 gap-1">
                        <input type="date" id="startDate" class="form-control form-control-sm" value="<?= date('Y-m-d') ?>" style="width: auto; border-radius: 8px;">
                        <span class="text-muted">-</span>
                        <input type="date" id="endDate" class="form-control form-control-sm" value="<?= date('Y-m-d') ?>" style="width: auto; border-radius: 8px;">
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div id="attendanceChart"></div>
                    <div class="text-center mt-n2 mb-3">
                        <small class="text-muted" id="currentDateRange">ข้อมูลประจำวันที่: <?= date('d/m/Y') ?></small>
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-primary" id="btnAnalysis" style="border-radius: 12px; padding: 12px; font-weight: 600; background: var(--primary-gradient); border: none; box-shadow: 0 4px 12px rgba(105, 108, 255, 0.25);">
                            <i class="bx bx-list-check me-2 fs-5"></i>ดูรายละเอียดการลงเวลางาน & สถิติ
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Learning Group Proportion -->
        <div class="col-lg-7">
            <div class="card chart-card h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h6 class="mb-0 fw-bold" style="color: #435971;"><i class="bx bx-bar-chart-alt-2 text-primary me-2"></i>สัดส่วนบุคลากรรายกลุ่มสาระ</h6>
                </div>
                <div class="card-body pt-2">
                    <div id="learningChart"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Directory Layout -->
    <div class="row g-4">
        <!-- Left Side Navigation: Learning Groups -->
        <div class="col-md-4 col-lg-3">
            <div class="card chart-card p-3">
                <div class="mb-3 search-wrapper">
                    <i class="bx bx-search search-icon"></i>
                    <input type="text" id="searchPersonnel" class="form-control search-input" placeholder="ค้นหาชื่อ, ตำแหน่ง...">
                </div>
                <hr class="my-2 opacity-50">
                <div class="group-menu-scroll">
                    <!-- Default: All -->
                    <a href="javascript:void(0);" class="group-nav-link active" data-target="all">
                        <span><i class="bx bx-grid-alt me-2 text-primary"></i>ทั้งหมด</span>
                        <span class="badge bg-label-primary rounded-pill"><?= $total_count ?></span>
                    </a>
                    
                    <?php if (isset($grouped_data['management'])): ?>
                        <?php foreach ($grouped_data['management'] as $group): ?>
                            <a href="javascript:void(0);" class="group-nav-link" data-target="management-group">
                                <span><i class="bx bx-crown me-2 text-warning"></i><?= $group['name'] ?></span>
                                <span class="badge bg-label-warning rounded-pill"><?= count($group['members']) ?></span>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <?php if (isset($grouped_data['learning'])): ?>
                        <?php foreach ($grouped_data['learning'] as $group): ?>
                            <a href="javascript:void(0);" class="group-nav-link" data-target="learning-<?= $group['id'] ?>">
                                <span><i class="bx bx-book-reader me-2 text-info"></i><?= $group['name'] ?></span>
                                <span class="badge bg-label-info rounded-pill"><?= count($group['members']) ?></span>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <?php if (isset($grouped_data['support'])): ?>
                        <a href="javascript:void(0);" class="group-nav-link" data-target="support-group">
                            <span><i class="bx bx-support me-2 text-secondary"></i>บุคลากรสายสนับสนุน</span>
                            <span class="badge bg-label-secondary rounded-pill"><?= count($grouped_data['support'][0]['members']) ?></span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Right Side Content: Cards Display -->
        <div class="col-md-8 col-lg-9">
            <div class="card chart-card p-4">
                <!-- Current Selected Title -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0" id="currentGroupTitle" style="color: #435971;">บุคลากรทั้งหมด</h5>
                    <small class="text-muted" id="searchResultText"></small>
                </div>

                <!-- Cards Grid -->
                <div class="row g-3" id="personnelGrid">
                    
                    <!-- Management -->
                    <?php if (isset($grouped_data['management'])): ?>
                        <?php foreach ($grouped_data['management'] as $group): ?>
                            <?php foreach ($group['members'] as $person): ?>
                            <div class="col-6 col-sm-4 col-md-4 col-lg-3 personnel-item-card" 
                                 data-group="management-group"
                                 data-name="<?= mb_strtolower($person['pers_firstname'] . ' ' . $person['pers_lastname'] . ' ' . ($person['posi_name'] ?? '')) ?>">
                                <div class="card person-card border-warning border-top border-3" role="button" data-id="<?= $person['pers_id'] ?>">
                                    <div class="person-img-wrapper">
                                        <?php if (!empty($person['pers_img'])): ?>
                                            <img src="https://personnel.skj.ac.th/uploads/admin/Personnal/<?= $person['pers_img'] ?>" class="person-img" onerror="this.src='<?= base_url('assets/admin/assets/img/avatars/1.png') ?>'" />
                                        <?php else: ?>
                                            <img src="<?= base_url('assets/admin/assets/img/avatars/1.png') ?>" class="person-img" />
                                        <?php endif; ?>
                                    </div>
                                    <div class="person-info">
                                        <div class="person-name" title="<?= $person['pers_prefix'] . $person['pers_firstname'] . ' ' . $person['pers_lastname'] ?>">
                                            <?= $person['pers_prefix'] ?><?= $person['pers_firstname'] ?> <?= mb_substr($person['pers_lastname'], 0, 1) ?>.
                                        </div>
                                        <div class="person-pos text-warning"><?= $person['posi_name'] ?? '-' ?></div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <!-- Learning Groups -->
                    <?php if (isset($grouped_data['learning'])): ?>
                        <?php foreach ($grouped_data['learning'] as $group): ?>
                            <?php foreach ($group['members'] as $person): ?>
                            <div class="col-6 col-sm-4 col-md-4 col-lg-3 personnel-item-card" 
                                 data-group="learning-<?= $group['id'] ?>"
                                 data-name="<?= mb_strtolower($person['pers_firstname'] . ' ' . $person['pers_lastname'] . ' ' . ($person['posi_name'] ?? '')) ?>">
                                <div class="card person-card" role="button" data-id="<?= $person['pers_id'] ?>">
                                    <div class="person-img-wrapper">
                                        <?php if (!empty($person['pers_img'])): ?>
                                            <img src="https://personnel.skj.ac.th/uploads/admin/Personnal/<?= $person['pers_img'] ?>" class="person-img" onerror="this.src='<?= base_url('assets/admin/assets/img/avatars/1.png') ?>'" />
                                        <?php else: ?>
                                            <img src="<?= base_url('assets/admin/assets/img/avatars/1.png') ?>" class="person-img" />
                                        <?php endif; ?>
                                    </div>
                                    <div class="person-info">
                                        <div class="person-name" title="<?= $person['pers_prefix'] . $person['pers_firstname'] . ' ' . $person['pers_lastname'] ?>">
                                            <?= $person['pers_prefix'] ?><?= $person['pers_firstname'] ?> <?= mb_substr($person['pers_lastname'], 0, 1) ?>.
                                        </div>
                                        <div class="person-pos"><?= $person['posi_name'] ?? '-' ?></div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <!-- Support -->
                    <?php if (isset($grouped_data['support'])): ?>
                        <?php foreach ($grouped_data['support'][0]['members'] as $person): ?>
                        <div class="col-6 col-sm-4 col-md-4 col-lg-3 personnel-item-card" 
                             data-group="support-group"
                             data-name="<?= mb_strtolower($person['pers_firstname'] . ' ' . $person['pers_lastname'] . ' ' . ($person['posi_name'] ?? '')) ?>">
                            <div class="card person-card" role="button" data-id="<?= $person['pers_id'] ?>">
                                <div class="person-img-wrapper">
                                    <?php if (!empty($person['pers_img'])): ?>
                                        <img src="https://personnel.skj.ac.th/uploads/admin/Personnal/<?= $person['pers_img'] ?>" class="person-img" onerror="this.src='<?= base_url('assets/admin/assets/img/avatars/1.png') ?>'" />
                                    <?php else: ?>
                                        <img src="<?= base_url('assets/admin/assets/img/avatars/1.png') ?>" class="person-img" />
                                    <?php endif; ?>
                                </div>
                                <div class="person-info">
                                    <div class="person-name" title="<?= $person['pers_prefix'] . $person['pers_firstname'] . ' ' . $person['pers_lastname'] ?>">
                                        <?= $person['pers_prefix'] ?><?= $person['pers_firstname'] ?> <?= mb_substr($person['pers_lastname'], 0, 1) ?>.
                                    </div>
                                    <div class="person-pos"><?= $person['posi_name'] ?? '-' ?></div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

</div>

<!-- Personnel Detail Modal -->
<div class="modal fade" id="personnelModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header bg-primary py-3">
                <h5 class="modal-title text-white mb-0"><i class="bx bx-user me-2"></i>ข้อมูลประวัติบุคลากร</h5>
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
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header bg-dark py-3">
                <h5 class="modal-title text-white mb-0"><i class="bx bx-analyse me-2"></i>วิเคราะห์การปฏิบัติงานและสถิติการลา</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <ul class="nav nav-tabs nav-fill" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-all-attendance"><i class="bx bx-list-check me-1"></i>รายละเอียดการลงเวลา</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-stats"><i class="bx bx-stats me-1"></i>สถิติการลา</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-abnormal"><i class="bx bx-error-circle me-1"></i>ลาบ่อยผิดปกติ</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-late"><i class="bx bx-time me-1"></i>สาย/ขาด/ไม่ลงเวลา</button>
                    </li>
                </ul>
                <div class="tab-content p-4">
                    <div class="tab-pane fade show active" id="tab-all-attendance">
                        <div class="mb-3 d-flex gap-2">
                            <input type="text" id="searchAttTable" class="form-control form-control-sm" placeholder="ค้นหาชื่อ, กลุ่มสาระ, ตำแหน่ง...">
                            <select id="filterAttStatus" class="form-select form-select-sm" style="width: auto;">
                                <option value="all">สถานะทั้งหมด</option>
                                <option value="ปกติ">มาปกติ</option>
                                <option value="สาย">มาสาย</option>
                                <option value="ขาด">ขาด</option>
                                <option value="ลา">ลา</option>
                                <option value="ไม่ลงเวลา">ไม่ลงเวลา</option>
                            </select>
                        </div>
                        <div class="table-responsive" style="max-height: 350px;">
                            <table class="table table-sm table-hover align-middle">
                                <thead class="table-light sticky-top">
                                    <tr>
                                        <th>ชื่อ-นามสกุล</th>
                                        <th>ตำแหน่ง</th>
                                        <th>กลุ่มสาระ</th>
                                        <th>วันที่</th>
                                        <th class="text-center">เวลาเข้า</th>
                                        <th class="text-center">เวลาออก</th>
                                        <th class="text-center">สถานะ</th>
                                    </tr>
                                </thead>
                                <tbody id="allAttendanceTableBody">
                                    <!-- Rendered dynamically -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-stats">
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

    // Re-fetch Chart Data when dates change
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

    // Dynamic Filter & Search Logic
    const groupLinks = document.querySelectorAll('.group-nav-link');
    const searchInput = document.getElementById('searchPersonnel');
    const cards = document.querySelectorAll('.personnel-item-card');
    const titleEl = document.getElementById('currentGroupTitle');
    const resultTextEl = document.getElementById('searchResultText');

    let currentGroup = 'all';

    const filterPersonnel = () => {
        const query = searchInput.value.trim().toLowerCase();
        let visibleCount = 0;

        cards.forEach(card => {
            const cardGroup = card.dataset.group;
            const cardName = card.dataset.name;

            const matchesGroup = (currentGroup === 'all' || cardGroup === currentGroup);
            const matchesQuery = (!query || cardName.includes(query));

            if (matchesGroup && matchesQuery) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (query) {
            resultTextEl.innerText = `พบผลลัพธ์ ${visibleCount} รายการ`;
        } else {
            resultTextEl.innerText = '';
        }
    };

    groupLinks.forEach(link => {
        link.addEventListener('click', function() {
            groupLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');

            currentGroup = this.dataset.target;
            const groupText = this.querySelector('span').innerText.trim();
            titleEl.innerText = groupText;

            filterPersonnel();
        });
    });

    searchInput.addEventListener('input', filterPersonnel);

    // Person Card Click Detail fetching
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

    // Attendance Analysis Modal Logic
    document.getElementById('btnAnalysis').addEventListener('click', function() {
        const modal = new bootstrap.Modal(document.getElementById('analysisModal'));
        modal.show();
        
        const statsEl = document.getElementById('analysisStatsContent');
        const abnormalEl = document.getElementById('abnormalTableBody');
        const lateEl = document.getElementById('lateAbsentContent');
        const allAttTableBody = document.getElementById('allAttendanceTableBody');

        statsEl.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary"></div></div>';
        abnormalEl.innerHTML = '';
        lateEl.innerHTML = '';
        allAttTableBody.innerHTML = '<tr><td colspan="5" class="text-center py-4"><div class="spinner-border spinner-border-sm text-primary"></div> กําลังโหลด...</td></tr>';

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
                    res.late_report.late.forEach(item => {
                        lateHtml += `
                            <div class="col-md-6">
                                <div class="d-flex align-items-center bg-light p-2 rounded">
                                    <div class="badge bg-warning me-2">สาย</div>
                                    <div class="flex-grow-1 small fw-bold">${item.name}</div>
                                </div>
                            </div>
                        `;
                    });
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

                    // 4. All Attendance Table
                    window.currentAttendanceData = res.all_attendance;
                    renderAttendanceRows(res.all_attendance);
                }
            });
    });

    const renderAttendanceRows = (data) => {
        let html = '';
        data.forEach(item => {
            let statusBadge = '';
            if (item.status.includes('มา') || item.status.includes('ปกติ')) {
                statusBadge = '<span class="badge bg-label-success">มาปกติ</span>';
            } else if (item.status.includes('สาย')) {
                statusBadge = '<span class="badge bg-label-warning">สาย</span>';
            } else if (item.status.includes('ขาด')) {
                statusBadge = '<span class="badge bg-label-danger">ขาด</span>';
            } else if (item.status.includes('ลา')) {
                statusBadge = '<span class="badge bg-label-info">ลา</span>';
            } else {
                statusBadge = '<span class="badge bg-label-secondary">ไม่ลงเวลา</span>';
            }

            html += `
                <tr>
                    <td><strong>${item.name}</strong></td>
                    <td><span class="small">${item.position || '-'}</span></td>
                    <td><span class="small">${item.learning_group || '-'}</span></td>
                    <td>${item.date.split('-').reverse().join('/')}</td>
                    <td class="text-center font-monospace">${item.check_in || '-'}</td>
                    <td class="text-center font-monospace">${item.check_out || '-'}</td>
                    <td class="text-center">${statusBadge}</td>
                </tr>
            `;
        });
        document.getElementById('allAttendanceTableBody').innerHTML = html || '<tr><td colspan="7" class="text-center text-muted">ไม่พบข้อมูลการลงเวลา</td></tr>';
    };

    // Table Search & Filter logic
    const attSearch = document.getElementById('searchAttTable');
    const attFilter = document.getElementById('filterAttStatus');

    const applyTableFilter = () => {
        if (!window.currentAttendanceData) return;
        const query = attSearch.value.trim().toLowerCase();
        const status = attFilter.value;

        const filtered = window.currentAttendanceData.filter(item => {
            const matchesQuery = item.name.toLowerCase().includes(query) ||
                                 (item.position && item.position.toLowerCase().includes(query)) ||
                                 (item.learning_group && item.learning_group.toLowerCase().includes(query));
            let matchesStatus = true;

            if (status === 'ปกติ') {
                matchesStatus = item.status.includes('มา') || item.status.includes('ปกติ');
            } else if (status === 'สาย') {
                matchesStatus = item.status.includes('สาย');
            } else if (status === 'ขาด') {
                matchesStatus = item.status.includes('ขาด');
            } else if (status === 'ลา') {
                matchesStatus = item.status.includes('ลา');
            } else if (status === 'ไม่ลงเวลา') {
                matchesStatus = item.status.includes('ไม่ลงเวลา') || (!item.check_in && !item.status);
            }

            return matchesQuery && matchesStatus;
        });

        renderAttendanceRows(filtered);
    };

    attSearch.addEventListener('input', applyTableFilter);
    attFilter.addEventListener('change', applyTableFilter);

})();
</script>
<?= $this->endSection() ?>
