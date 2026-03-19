<?= $this->extend('Manager/layout/ManagerLayout') ?>

<?= $this->section('content') ?>
<style>
    .stat-card {
        border: none;
        border-radius: 16px;
        transition: all 0.3s ease;
    }
    .evaluation-table img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 50%;
    }
    .status-badge {
        padding: 5px 12px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .bg-light-success { background: rgba(113, 221, 55, 0.1); color: #71dd37; }
    .bg-light-warning { background: rgba(255, 171, 0, 0.1); color: #ffab00; }
    .bg-light-primary { background: rgba(105, 108, 255, 0.1); color: #696cff; }
    .bg-light-info { background: rgba(3, 195, 236, 0.1); color: #03c3ec; }
</style>
<style>
    /* Executive Theme Overrides */
    .bg-primary { background-color: #2c3e50 !important; }
    .btn-primary { background-color: #003366 !important; border-color: #003366 !important; }
    .btn-primary:hover { background-color: #002244 !important; border-color: #002244 !important; }
    .text-primary { color: #003366 !important; }
    .bg-label-primary { background-color: #e3f2fd !important; color: #003366 !important; }
    .card-header-exec { border-left: 5px solid #003366 !important; }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <!-- Header -->
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h4 class="fw-bold mb-1"><i class="bx bx-check-shield text-primary me-2"></i><?= $title ?></h4>
                    <p class="text-muted mb-0"><?= $description ?></p>
                </div>
                <div class="d-flex gap-2 align-items-center">
                    <form action="" method="get" class="d-flex gap-2">
                        <select name="year" class="form-select form-select-sm" onchange="this.form.submit()">
                            <?php foreach($all_years as $y): ?>
                                <option value="<?= $y['eva_year'] ?>" <?= $year == $y['eva_year'] ? 'selected' : '' ?>>ปีงบประมาณ <?= $y['eva_year'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select name="round" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="1" <?= $round == 1 ? 'selected' : '' ?>>รอบที่ 1</option>
                            <option value="2" <?= $round == 2 ? 'selected' : '' ?>>รอบที่ 2</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>

        <!-- Summary Statistics -->
        <div class="col-md-3 mb-4">
            <div class="card stat-card shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="avatar bg-label-primary p-2 rounded mb-3 mx-auto" style="width: 50px; height: 50px;">
                        <i class="bx bx-group fs-2"></i>
                    </div>
                    <h4 class="fw-bold mb-1"><?= number_format($stats['total']) ?></h4>
                    <p class="text-muted mb-0">บุคลากรทั้งหมด</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card stat-card shadow-sm h-100">
                <div class="card-body text-center border-bottom border-3 border-success">
                    <div class="avatar bg-label-success p-2 rounded mb-3 mx-auto" style="width: 50px; height: 50px;">
                        <i class="bx bx-cloud-upload fs-2"></i>
                    </div>
                    <h4 class="fw-bold mb-1 text-success"><?= number_format($stats['submitted']) ?></h4>
                    <p class="text-muted mb-0">ส่งผลการประเมินแล้ว</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card stat-card shadow-sm h-100">
                <div class="card-body text-center border-bottom border-3 border-warning">
                    <div class="avatar bg-label-warning p-2 rounded mb-3 mx-auto" style="width: 50px; height: 50px;">
                        <i class="bx bx-time fs-2"></i>
                    </div>
                    <h4 class="fw-bold mb-1 text-warning"><?= number_format($stats['pending']) ?></h4>
                    <p class="text-muted mb-0">รอดำเนินการ</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card stat-card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold">ความคืบหน้า</span>
                        <span class="text-primary fw-bold"><?= $stats['percent'] ?>%</span>
                    </div>
                    <div class="progress rounded-pill" style="height: 12px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" style="width: <?= $stats['percent'] ?>%"></div>
                    </div>
                    <p class="small text-muted mt-2 mb-0 text-center">อัปเดตล่าสุด: <?= date('d/m/Y H:i') ?></p>
                </div>
            </div>
        </div>

        <!-- Evaluation List -->
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">รายการส่งผลการประเมิน ปีงบประมาณ <?= $year ?> รอบที่ <?= $round ?></h5>
                    <div class="input-group input-group-merge w-25">
                        <span class="input-group-text"><i class="bx bx-search"></i></span>
                        <input type="text" id="evalSearch" class="form-control" placeholder="ค้นหาชื่อครู...">
                    </div>
                </div>
                <div class="table-responsive evaluation-table">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>บุคลากร</th>
                                <th>กลุ่มสาระ / งาน</th>
                                <th class="text-center">รอบที่</th>
                                <th class="text-center">ไฟล์เอกสาร</th>
                                <th class="text-center">ลิงก์ Canva</th>
                                <th class="text-center">สถานะ</th>
                                <th class="text-center">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody id="evalTableBody">
                            <?php if (empty($evaluations)): ?>
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">ไม่พบข้อมูลการส่งผลการประเมินในรอบนี้</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($evaluations as $eva): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="<?= $eva['pers_img'] ? 'https://personnel.skj.ac.th/uploads/admin/Personnal/'.$eva['pers_img'] : base_url('assets/admin/assets/img/avatars/1.png') ?>" class="me-3" onerror="this.src='<?= base_url('assets/admin/assets/img/avatars/1.png') ?>'">
                                                <div>
                                                    <div class="fw-bold"><?= $eva['pers_prefix'].$eva['pers_firstname'].' '.$eva['pers_lastname'] ?></div>
                                                    <small class="text-muted">ID: <?= $eva['eva_teacher_id'] ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= ($eva['learning_name'] ?? ($eva['pers_learning'] ?? ($eva['pers_position'] ?? '-'))) ?></td>
                                        <td class="text-center"><span class="badge bg-label-info"><?= $eva['eva_round'] ?></span></td>
                                        <td class="text-center">
                                            <?php if ($eva['eva_file']): ?>
                                                <?php 
                                                    // Default Legacy URL
                                                    $fileUrl = 'https://skj.nsnpao.go.th/uploads/personnel/teacher/evaluation/'.$eva['eva_year'].'/'.$eva['eva_round'].'/'.$eva['eva_file'];
                                                    
                                                    // Check if it's a new file (from the remote server)
                                                    // Heuristic: if filename has underscores and starts with a number
                                                    if (strpos($eva['eva_file'], '_') !== false && is_numeric(substr($eva['eva_file'], 0, 1))) {
                                                        $fileUrl = 'https://skj.nsnpao.go.th/uploads/evaluation/'.$eva['eva_year'].'/'.$eva['eva_round'].'/'.$eva['eva_file'];
                                                    }
                                                ?>
                                                <a href="<?= $fileUrl ?>" target="_blank" class="btn btn-icon btn-label-danger btn-sm" title="ดูไฟล์ PDF">
                                                    <i class="bx bxs-file-pdf fs-4"></i>
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($eva['eva_canva_link']): ?>
                                                <a href="<?= $eva['eva_canva_link'] ?>" target="_blank" class="btn btn-icon btn-info btn-sm" title="ไปที่ Canva">
                                                    <i class="bx bx-link-external fs-4"></i>
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php 
                                                $statusClass = 'bg-light-primary';
                                                if ($eva['eva_status'] == 'ผ่านการตรวจสอบ') $statusClass = 'bg-light-success';
                                                elseif ($eva['eva_status'] == 'รอแก้ไข') $statusClass = 'bg-light-warning';
                                            ?>
                                            <span class="status-badge <?= $statusClass ?>"><?= $eva['eva_status'] ?></span>
                                        </td>
                                        <td class="text-center text-nowrap">
                                            <button type="button" class="btn btn-sm btn-label-secondary edit-btn" 
                                                data-id="<?= $eva['eva_id'] ?>" 
                                                data-name="<?= $eva['pers_firstname'] ?>"
                                                data-status="<?= $eva['eva_status'] ?>"
                                                data-comment="<?= $eva['eva_comment'] ?>">
                                                <i class="bx bx-edit-alt me-1"></i> ตรวจสอบ
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Status Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white"><i class="bx bx-check-double me-2"></i>ตรวจสอบผลการประเมิน</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm">
                <div class="modal-body">
                    <input type="hidden" name="eva_id" id="modal_eva_id">
                    <div class="mb-3">
                        <label class="form-label fw-bold">บุคลากร</label>
                        <input type="text" class="form-control bg-light" id="modal_teacher_name" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">สถานะการประเมิน</label>
                        <select name="eva_status" id="modal_eva_status" class="form-select">
                            <option value="ส่งแล้ว">ส่งแล้ว</option>
                            <option value="ผ่านการตรวจสอบ">ผ่านการตรวจสอบ</option>
                            <option value="รอแก้ไข">รอแก้ไข (ส่งกลับไปให้ครูแก้ไข)</option>
                        </select>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold">ความคิดเห็น / ข้อเสนอแนะ</label>
                        <textarea name="eva_comment" id="modal_eva_comment" class="form-control" rows="4" placeholder="กรอกเหตุผลที่ต้องแก้ไข หรือสิ่งที่ต้องการแนะนำ..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary px-4"><i class="bx bx-save me-1"></i> บันทึกข้อมูล</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search Functionality
    const searchInput = document.getElementById('evalSearch');
    const tableBody = id = 'evalTableBody';
    
    searchInput.addEventListener('keyup', function() {
        const value = this.value.toLowerCase();
        const rows = document.querySelectorAll('#evalTableBody tr');
        
        rows.forEach(row => {
            if (row.cells.length > 1) {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(value) ? '' : 'none';
            }
        });
    });

    // Edit Modal
    const editModal = new bootstrap.Modal(document.getElementById('editModal'));
    const editBtns = document.querySelectorAll('.edit-btn');
    
    editBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('modal_eva_id').value = this.dataset.id;
            document.getElementById('modal_teacher_name').value = this.dataset.name;
            document.getElementById('modal_eva_status').value = this.dataset.status;
            document.getElementById('modal_eva_comment').value = this.dataset.comment || '';
            editModal.show();
        });
    });

    // Submit Form
    document.getElementById('editForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        const btn = this.querySelector('button[type="submit"]');
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> กำลังบันทึก...';

        fetch('<?= base_url('Manager/Evaluation/UpdateStatus') ?>', {
            method: 'POST',
            body: formData
        })
        .then(r => r.json())
        .then(res => {
            if (res.status) {
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ',
                    text: res.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => location.reload());
            } else {
                Swal.fire('ข้อผิดพลาด', res.message, 'error');
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        })
        .catch(() => {
            Swal.fire('ข้อผิดพลาด', 'ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้', 'error');
            btn.disabled = false;
            btn.innerHTML = originalText;
        });
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?= $this->endSection() ?>
