<?= $this->extend('Manager/layout/ManagerLayout') ?>

<?= $this->section('content') ?>
<style>
    .stat-card { border: none; border-radius: 12px; transition: transform 0.2s; }
    .stat-card:hover { transform: translateY(-3px); }
    .stat-icon { width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; }
    .chart-card { border: none; border-radius: 12px; }
    .pending-item { border-left: 3px solid #696cff; padding-left: 10px; margin-bottom: 10px; }
    .pending-item.warning { border-left-color: #ffab00; }
    .pending-item.danger { border-left-color: #ff3e1d; }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 g-3">
        <div>
            <h4 class="fw-bold mb-0"><i class="bx bx-cog text-primary me-2"></i>งานบริหารทั่วไป</h4>
            <small class="text-muted">ปีการศึกษา <?= $schoolyear['schyear_year'] ?? '-' ?> | ปีงบประมาณ <?= $schoolyear['schyear_fiscal'] ?? '-' ?></small>
        </div>
        <div class="d-flex flex-wrap align-items-center gap-2">
            <div class="input-group input-group-sm" style="width: auto;">
                <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                <input type="date" id="startDate" class="form-control" value="<?= $schoolyear['schyear_start_date'] ?? date('Y-m-d') ?>">
                <span class="input-group-text">ถึง</span>
                <input type="date" id="endDate" class="form-control" value="<?= $schoolyear['schyear_end_date'] ?? date('Y-m-d') ?>">
            </div>
            <button class="btn btn-sm btn-primary" id="btnRefresh"><i class="bx bx-refresh"></i> คำนวณ</button>
            <div class="badge bg-label-info fs-6 px-3 py-2">
                <i class="bx bx-calendar me-1"></i>ข้อมูล ณ วันที่ <?= date('d/m/Y') ?>
            </div>
        </div>
    </div>

    <!-- Quick Stats Row 1: Booking & Car -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card stat-card shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <div class="stat-icon bg-label-primary me-2"><i class="bx bx-calendar-event"></i></div>
                        <h6 class="mb-0">จองห้องวันนี้</h6>
                    </div>
                    <h4 class="mb-0 fw-bold text-primary"><?= number_format($booking_today) ?></h4>
                    <small class="text-muted">รายการ</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card stat-card shadow-sm border-start border-warning border-4">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <div class="stat-icon bg-label-warning me-2"><i class="bx bx-time-five"></i></div>
                        <h6 class="mb-0">รออนุมัติ (ห้อง)</h6>
                    </div>
                    <h4 class="mb-0 fw-bold text-warning"><?= number_format($booking_pending) ?></h4>
                    <small class="text-muted">รายการ</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card stat-card shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <div class="stat-icon bg-label-info me-2"><i class="bx bx-car"></i></div>
                        <h6 class="mb-0">จองรถวันนี้</h6>
                    </div>
                    <h4 class="mb-0 fw-bold text-info"><?= number_format($car_today) ?></h4>
                    <small class="text-muted">รายการ</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card stat-card shadow-sm border-start border-warning border-4">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <div class="stat-icon bg-label-warning me-2"><i class="bx bx-timer"></i></div>
                        <h6 class="mb-0">รออนุมัติ (รถ)</h6>
                    </div>
                    <h4 class="mb-0 fw-bold text-warning"><?= number_format($car_pending) ?></h4>
                    <small class="text-muted">รายการ</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Row 2: Repair & Food -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card stat-card shadow-sm border-start border-danger border-4">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <div class="stat-icon bg-label-danger me-2"><i class="bx bx-wrench"></i></div>
                        <h6 class="mb-0">แจ้งซ่อมค้าง</h6>
                    </div>
                    <h4 class="mb-0 fw-bold text-danger"><?= number_format($repair_pending) ?></h4>
                    <small class="text-muted">รายการ</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card stat-card shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <div class="stat-icon bg-label-success me-2"><i class="bx bx-check-circle"></i></div>
                        <h6 class="mb-0">ซ่อมเสร็จแล้ว</h6>
                    </div>
                    <h4 class="mb-0 fw-bold text-success"><?= number_format($repair_done) ?></h4>
                    <small class="text-muted">รายการ (<?= $repair_total > 0 ? round(($repair_done / $repair_total) * 100) : 0 ?>%)</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card stat-card shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <div class="stat-icon bg-label-secondary me-2"><i class="bx bx-food-menu"></i></div>
                        <h6 class="mb-0">รายงานอาหาร</h6>
                    </div>
                    <h4 class="mb-0 fw-bold"><?= number_format($food_month) ?></h4>
                    <small class="text-muted">เดือนนี้</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card stat-card shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <div class="stat-icon bg-label-primary me-2"><i class="bx bx-calendar-check"></i></div>
                        <h6 class="mb-0">จองห้องเดือนนี้</h6>
                    </div>
                    <h4 class="mb-0 fw-bold"><?= number_format($booking_month) ?></h4>
                    <small class="text-muted">รายการ</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-3 mb-4">
        <div class="col-lg-4">
            <div class="card chart-card shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h6 class="mb-0 fw-bold"><i class="bx bx-calendar text-primary me-2"></i>สถิติจองห้อง 6 เดือน</h6>
                </div>
                <div class="card-body">
                    <div id="bookingChart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card chart-card shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h6 class="mb-0 fw-bold"><i class="bx bx-car text-info me-2"></i>สถิติจองรถ 6 เดือน</h6>
                </div>
                <div class="card-body">
                    <div id="carChart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card chart-card shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h6 class="mb-0 fw-bold"><i class="bx bx-wrench text-danger me-2"></i>สถานะการแจ้งซ่อม</h6>
                </div>
                <div class="card-body">
                    <div id="repairChart"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Tables Row -->
    <div class="row g-3">
        <!-- Pending Bookings -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold"><i class="bx bx-calendar-event text-warning me-2"></i>รออนุมัติ - ห้อง</h6>
                    <span class="badge bg-warning"><?= count($pending_bookings) ?></span>
                </div>
                <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                    <?php if (empty($pending_bookings)): ?>
                        <div class="text-center text-muted py-4"><i class="bx bx-check-circle fs-1"></i><br>ไม่มีรายการรออนุมัติ</div>
                    <?php else: ?>
                        <?php foreach ($pending_bookings as $b): ?>
                            <div class="pending-item warning">
                                <strong><?= $b['booking_title'] ?></strong><br>
                                <small class="text-muted"><i class="bx bx-calendar"></i> <?= $b['booking_dateStart'] ?> <?= $b['booking_timeStart'] ?></small>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Pending Cars -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold"><i class="bx bx-car text-warning me-2"></i>รออนุมัติ - รถ</h6>
                    <span class="badge bg-warning"><?= count($pending_cars) ?></span>
                </div>
                <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                    <?php if (empty($pending_cars)): ?>
                        <div class="text-center text-muted py-4"><i class="bx bx-check-circle fs-1"></i><br>ไม่มีรายการรออนุมัติ</div>
                    <?php else: ?>
                        <?php foreach ($pending_cars as $c): ?>
                            <div class="pending-item warning">
                                <strong><?= $c['car_reserv_location'] ?></strong><br>
                                <small class="text-muted"><i class="bx bx-calendar"></i> <?= $c['car_reserv_StartDate'] ?> <?= $c['car_reserv_StartTime'] ?></small>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Pending Repairs -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold"><i class="bx bx-wrench text-danger me-2"></i>แจ้งซ่อมที่ยังไม่เสร็จ</h6>
                    <span class="badge bg-danger"><?= count($pending_repairs) ?></span>
                </div>
                <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                    <?php if (empty($pending_repairs)): ?>
                        <div class="text-center text-muted py-4"><i class="bx bx-check-circle fs-1"></i><br>ไม่มีรายการค้าง</div>
                    <?php else: ?>
                        <?php foreach ($pending_repairs as $r): ?>
                            <div class="pending-item danger">
                                <strong><?= $r['repair_room'] ?></strong> - <?= $r['repair_caselist'] ?><br>
                                <small class="text-muted"><i class="bx bx-info-circle"></i> <?= $r['repair_status'] ?></small>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Booking Chart
    const bookingMonths = [<?php foreach($booking_by_month as $b) echo '"'.$b['month'].'",'; ?>];
    const bookingData = [<?php foreach($booking_by_month as $b) echo $b['count'].','; ?>];
    
    new ApexCharts(document.querySelector("#bookingChart"), {
        series: [{ name: 'จำนวน', data: bookingData }],
        chart: { type: 'area', height: 250, toolbar: {show: false} },
        colors: ['#696cff'],
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.5, opacityTo: 0.1 } },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 2 },
        xaxis: { categories: bookingMonths }
    }).render();

    // Car Chart
    const carMonths = [<?php foreach($car_by_month as $c) echo '"'.$c['month'].'",'; ?>];
    const carData = [<?php foreach($car_by_month as $c) echo $c['count'].','; ?>];
    
    new ApexCharts(document.querySelector("#carChart"), {
        series: [{ name: 'จำนวน', data: carData }],
        chart: { type: 'area', height: 250, toolbar: {show: false} },
        colors: ['#03c3ec'],
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.5, opacityTo: 0.1 } },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 2 },
        xaxis: { categories: carMonths }
    }).render();

    // Repair Status Chart
    const repairLabels = [<?php foreach($repair_by_status as $r) echo '"'.($r['repair_status'] ?: 'ไม่ระบุ').'",'; ?>];
    const repairData = [<?php foreach($repair_by_status as $r) echo $r['count'].','; ?>];
    
    new ApexCharts(document.querySelector("#repairChart"), {
        series: repairData,
        labels: repairLabels,
        chart: { type: 'donut', height: 250 },
        colors: ['#ffab00', '#696cff', '#71dd37', '#ff3e1d', '#8592a3'],
        legend: { position: 'bottom' }
    }).render();

    // Date Range Filtering
    const updateGeneralData = () => {
        const start = document.getElementById('startDate').value;
        const end = document.getElementById('endDate').value;
        
        fetch(`<?= base_url('Manager/General/Analysis') ?>?startDate=${start}&endDate=${end}`)
            .then(r => r.json())
            .then(res => {
                if (res.status) {
                    // Update stat cards - find by icon class
                    const cards = document.querySelectorAll('.stat-card .card-body');
                    cards.forEach(card => {
                        const icon = card.querySelector('.stat-icon i');
                        const h4 = card.querySelector('h4');
                        if (icon && h4) {
                            if (icon.classList.contains('bx-calendar-check')) h4.textContent = res.booking_total.toLocaleString();
                            if (icon.classList.contains('bx-time-five')) h4.textContent = res.booking_pending.toLocaleString();
                            if (icon.classList.contains('bx-car')) h4.textContent = res.car_total.toLocaleString();
                            if (icon.classList.contains('bx-timer')) h4.textContent = res.car_pending.toLocaleString();
                            if (icon.classList.contains('bx-wrench')) h4.textContent = res.repair_pending.toLocaleString();
                            if (icon.classList.contains('bx-check-circle')) {
                                h4.textContent = res.repair_done.toLocaleString();
                                const small = card.querySelector('small');
                                if (small && res.repair_total > 0) {
                                    small.textContent = `รายการ (${Math.round((res.repair_done / res.repair_total) * 100)}%)`;
                                }
                            }
                            if (icon.classList.contains('bx-food-menu')) h4.textContent = res.food_total.toLocaleString();
                        }
                    });
                }
            });
    };

    document.getElementById('btnRefresh').addEventListener('click', updateGeneralData);
});
</script>
<?= $this->endSection() ?>
