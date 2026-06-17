<?= $this->extend('Support/layout/SupportLayout') ?>

<?= $this->section('content') ?>
<!-- Load Bootstrap Icons dynamically for gorgeous modern icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    :root {
        --support-primary: #4f46e5;
        --support-primary-light: #e0e7ff;
        --support-success: #10b981;
        --support-success-light: #d1fae5;
        --support-warning: #f59e0b;
        --support-warning-light: #fef3c7;
        --support-danger: #ef4444;
        --support-danger-light: #fee2e2;
    }

    .welcome-card {
        background: linear-gradient(135deg, #4f46e5 0%, #312e81 100%) !important;
        color: #ffffff !important;
        border-radius: 1.5rem;
        border: none;
        overflow: hidden;
        position: relative;
        box-shadow: 0 10px 30px rgba(79, 70, 229, 0.15);
    }
    .welcome-card h2,
    .welcome-card p {
        color: #ffffff !important;
    }
    .welcome-card::before {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.03);
        top: -100px;
        right: -100px;
        pointer-events: none;
    }
    .welcome-card::after {
        content: '';
        position: absolute;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.05);
        bottom: -50px;
        right: 100px;
        pointer-events: none;
    }

    .stat-card {
        border-radius: 1.25rem;
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.08);
    }

    .quick-action-btn {
        border-radius: 1rem;
        transition: all 0.2s ease-in-out;
    }
    .quick-action-btn:hover {
        transform: translateY(-2px);
    }

    .history-item {
        border-left: 3px solid #e2e8f0;
        padding-left: 1.25rem;
        position: relative;
        padding-bottom: 1.25rem;
    }
    .history-item:last-child {
        padding-bottom: 0;
    }
    .history-item::before {
        content: '';
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #cbd5e1;
        position: absolute;
        left: -7.5px;
        top: 4px;
        border: 2px solid #fff;
        transition: all 0.2s;
    }
    .history-item.status-normal::before {
        background: var(--support-success);
    }
    .history-item.status-late::before {
        background: var(--support-warning);
    }
    .history-item.status-absent::before {
        background: var(--support-danger);
    }
    .history-item.status-normal {
        border-left-color: var(--support-success);
    }
    .history-item.status-late {
        border-left-color: var(--support-warning);
    }
    .history-item.status-absent {
        border-left-color: var(--support-danger);
    }

    .time-badge {
        font-family: 'Outfit', 'Inter', sans-serif;
        font-weight: 700;
        font-size: 0.95rem;
    }

    .selfie-preview {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 0.5rem;
        cursor: pointer;
        transition: transform 0.2s;
    }
    .selfie-preview:hover {
        transform: scale(1.15);
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Welcome Header Card -->
    <div class="card welcome-card p-4 mb-4">
        <div>
            <span class="badge fw-bold mb-2 px-3 py-2" style="background-color: #ffffff !important; color: #4f46e5 !important; font-weight: 700 !important; display: inline-block;">
                <i class="bi bi-shield-check me-1"></i> บุคลากรฝ่ายสนับสนุน
            </span>
            <h2 class="fw-bold mb-2" style="color: #ffffff !important; font-weight: 700 !important;">สวัสดีครับ, คุณ<?= session('AdminFullname') ?> 👋</h2>
            <p class="mb-3" style="color: #f1f5f9 !important; font-size: 1.05rem;">
                ยินดีต้อนรับสู่ระบบบริหารจัดการการลงเวลางานออนไลน์ของฝ่ายสนับสนุน โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์
            </p>
            <div class="d-inline-flex align-items-center px-3 py-2 rounded-pill" style="background-color: rgba(255, 255, 255, 0.15) !important; border: 1px solid rgba(255, 255, 255, 0.25) !important;">
                <i class="bi bi-calendar3 me-2" style="color: #ffffff !important;"></i>
                <span class="fw-bold small" id="live-date" style="color: #ffffff !important;">...</span>
            </div>
        </div>
    </div>


    <!-- Monthly Stats Summary Dashboard -->
    <h5 class="fw-bold text-dark mb-3"><i class="bi bi-graph-up-arrow me-2 text-primary"></i>สรุปผลการปฏิบัติงานของเดือนนี้ (เดือน<?= date('m') ?>)</h5>
    <div class="row g-3 mb-4">
        <!-- Present Days -->
        <div class="col-md-3">
            <div class="card stat-card border-start border-success border-4">
                <div class="card-body p-4 text-center">
                    <div class="avatar bg-label-success rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-check-circle-fill fs-3 text-success"></i>
                    </div>
                    <h2 class="fw-black mb-1 text-success"><?= $summary['ปกติ'] ?></h2>
                    <div class="fw-bold text-muted small">ลงเวลาปฏิบัติงานปกติ (วัน)</div>
                </div>
            </div>
        </div>

        <!-- Leave Days -->
        <div class="col-md-3">
            <div class="card stat-card border-start border-primary border-4">
                <div class="card-body p-4 text-center">
                    <div class="avatar bg-label-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-calendar2-range-fill fs-3 text-primary"></i>
                    </div>
                    <h2 class="fw-black mb-1 text-primary"><?= $summary['ลา'] ?></h2>
                    <div class="fw-bold text-muted small">วันลา (วัน)</div>
                </div>
            </div>
        </div>

        <!-- Late Days -->
        <div class="col-md-3">
            <div class="card stat-card border-start border-warning border-4">
                <div class="card-body p-4 text-center">
                    <div class="avatar bg-label-warning rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-clock-history fs-3 text-warning"></i>
                    </div>
                    <h2 class="fw-black mb-1 text-warning"><?= $summary['มาสาย'] ?></h2>
                    <div class="fw-bold text-muted small">ลงเวลาสาย (วัน)</div>
                </div>
            </div>
        </div>

        <!-- Absences -->
        <div class="col-md-3">
            <div class="card stat-card border-start border-danger border-4">
                <div class="card-body p-4 text-center">
                    <div class="avatar bg-label-danger rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-exclamation-octagon-fill fs-3 text-danger"></i>
                    </div>
                    <h2 class="fw-black mb-1 text-danger"><?= $summary['ขาด'] ?></h2>
                    <div class="fw-bold text-muted small">ขาดงาน/ไม่พบบันทึก (วัน)</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent History Log Preview -->
    <div class="card border shadow-sm">
        <div class="card-header border-bottom d-flex align-items-center justify-content-between bg-light">
            <h5 class="mb-0 fw-bold"><i class="bi bi-list-check me-2 text-primary"></i>บันทึกล่าสุดย้อนหลัง 5 วัน</h5>
            <a href="<?= base_url('Support/SupportAttendance/History') ?>" class="btn btn-sm btn-outline-primary fw-bold">
                ดูประวัติทั้งหมด <i class="bi bi-arrow-right-short ms-1"></i>
            </a>
        </div>
        <div class="card-body pt-4">
            <?php if (empty($recentHistory)): ?>
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted"></i>
                    <p class="text-muted mt-2">ไม่พบประวัติการลงเวลางานก่อนหน้านี้</p>
                </div>
            <?php else: ?>
                <div class="history-timeline">
                    <?php
                    $thDays = ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'];
                    $thMonths = [
                        '01' => 'ม.ค.', '02' => 'ก.พ.', '03' => 'มี.ค.', '04' => 'เม.ย.',
                        '05' => 'พ.ค.', '06' => 'มิ.ย.', '07' => 'ก.ค.', '08' => 'ส.ค.',
                        '09' => 'ก.ย.', '10' => 'ต.ค.', '11' => 'พ.ย.', '12' => 'ธ.ค.'
                    ];
                    foreach ($recentHistory as $h):
                        $dateObj = new DateTime($h['att_date']);
                        $dayStr = $thDays[$dateObj->format('w')];
                        $dateStr = $dateObj->format('d') . ' ' . $thMonths[$dateObj->format('m')] . ' ' . ($dateObj->format('Y') + 543);
                        
                        $statusClass = 'status-normal';
                        $badgeClass = 'bg-label-success';
                        if ($h['status'] === 'มาสาย') {
                            $statusClass = 'status-late';
                            $badgeClass = 'bg-label-warning';
                        } elseif ($h['status'] === 'ขาด') {
                            $statusClass = 'status-absent';
                            $badgeClass = 'bg-label-danger';
                        }
                    ?>
                        <div class="history-item <?= $statusClass ?>">
                            <div class="row align-items-center">
                                <div class="col-md-3 col-6">
                                    <div class="fw-bold text-dark fs-6"><?= $dateStr ?></div>
                                    <small class="text-muted">วัน<?= $dayStr ?></small>
                                </div>
                                <div class="col-md-3 col-6">
                                    <span class="badge <?= $badgeClass ?> fw-bold px-2.5 py-1"><?= $h['status'] ?></span>
                                </div>
                                <div class="col-md-4 col-8 mt-2 mt-md-0">
                                    <div class="small">
                                        <i class="bi bi-box-arrow-in-right text-success me-1"></i> เข้า: 
                                        <span class="fw-bold time-badge text-dark"><?= $h['check_in'] ? date('H:i', strtotime($h['check_in'])) : '-' ?></span>
                                        <span class="mx-2 text-muted">|</span>
                                        <i class="bi bi-box-arrow-left text-danger me-1"></i> ออก: 
                                        <span class="fw-bold time-badge text-dark"><?= $h['check_out'] ? date('H:i', strtotime($h['check_out'])) : '-' ?></span>
                                    </div>
                                </div>
                                <div class="col-md-2 col-4 mt-2 mt-md-0 text-end">
                                    <?php if ($h['check_in_photo']): ?>
                                        <img src="<?= esc($h['check_in_photo']) ?>" 
                                             class="selfie-preview border shadow-sm" 
                                             onclick="showSelfieModal('<?= esc($h['check_in_photo']) ?>', 'ภาพเข้างาน - <?= $dateStr ?>')" 
                                             alt="Selfie Preview">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // วันภาษาไทย
        const thDays = ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'];
        const thMonths = [
            'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
            'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
        ];
        
        function updateLiveDate() {
            const now = new Date();
            const dayName = thDays[now.getDay()];
            const date = now.getDate();
            const monthName = thMonths[now.getMonth()];
            const year = now.getFullYear() + 543;
            
            const dateStr = `วัน${dayName}ที่ ${date} ${monthName} พ.ศ. ${year}`;
            const element = document.getElementById('live-date');
            if (element) {
                element.innerHTML = dateStr;
            }
        }
        
        updateLiveDate();
    });

    // แสดงรูปภาพเซลฟี่
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
