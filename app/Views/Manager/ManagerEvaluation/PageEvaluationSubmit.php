<?= $this->extend('Manager/layout/ManagerLayout') ?>

<?= $this->section('content') ?>
<style>
    /* Executive Theme Overrides */
    .bg-primary { background-color: #2c3e50 !important; }
    .btn-primary { background-color: #003366 !important; border-color: #003366 !important; }
    .btn-primary:hover { background-color: #002244 !important; border-color: #002244 !important; }
    .text-primary { color: #003366 !important; }
    .bg-label-primary { background-color: #e3f2fd !important; color: #003366 !important; }
    .profile-card-exec {
        background: linear-gradient(135deg, #1a237e 0%, #2c3e50 100%) !important;
    }
</style>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12 mb-4">
            <h4 class="fw-bold mb-1"><i class="bx bx-upload text-primary me-2"></i><?= $title ?></h4>
            <p class="text-muted mb-0"><?= $description ?></p>
        </div>

        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent border-bottom">
                    <h5 class="mb-0 fw-bold text-primary">ข้อมูลการส่งผลการปฏิบัติงาน</h5>
                </div>
                <div class="card-body pt-4">
                    <form id="evaluationForm" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label fw-bold">ปีงบประมาณ</label>
                            <select name="eva_year" id="eva_year" class="form-select">
                                <?php for($y = date('Y')+543; $y >= 2566; $y--): ?>
                                    <option value="<?= $y ?>" <?= $year == $y ? 'selected' : '' ?>>ปีงบประมาณ <?= $y ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">รอบที่</label>
                            <div class="d-flex gap-3 mt-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="eva_round" id="round1" value="1" <?= $round == 1 ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="round1">รอบที่ 1</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="eva_round" id="round2" value="2" <?= $round == 2 ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="round2">รอบที่ 2</label>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="mb-3">
                            <label class="form-label fw-bold" for="eva_file">
                                ไฟล์รายงาน PDF (ถ้ามี)
                                <?php if($evaluation && $evaluation['eva_file']): ?>
                                    <span class="badge bg-light-success ms-2">ส่งแล้ว: <?= $evaluation['eva_file'] ?></span>
                                <?php endif; ?>
                            </label>
                            <input type="file" name="eva_file" id="eva_file" class="form-control" accept=".pdf">
                            <div class="form-text">อัปโหลดไฟล์สรุปผลการปฏิบัติงานในรูปแบบ PDF</div>
                        </div>

                        <!-- Progress Bar -->
                        <div id="uploadProgress" class="mb-3 d-none">
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                            </div>
                            <small class="text-muted mt-1 d-block text-center">กำลังส่งข้อมูลไปยังเซิร์ฟเวอร์สำรอง...</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold" for="eva_canva_link">ลิงก์ Canva / ลิงก์ตกแต่งอื่น ๆ (ถ้ามี)</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-link"></i></span>
                                <input type="url" name="eva_canva_link" id="eva_canva_link" class="form-control" 
                                    placeholder="https://www.canva.com/design/..." 
                                    value="<?= $evaluation ? $evaluation['eva_canva_link'] : '' ?>">
                            </div>
                        </div>

                        <?php if($evaluation && $evaluation['eva_status']): ?>
                            <div class="alert alert-<?= $evaluation['eva_status'] == 'ผ่านการตรวจสอบ' ? 'success' : ($evaluation['eva_status'] == 'รอแก้ไข' ? 'warning' : 'info') ?> d-flex align-items-center mb-4" role="alert">
                                <i class="bx bx-info-circle me-2 fs-4"></i>
                                <div>
                                    สถานะปัจจุบัน: <strong><?= $evaluation['eva_status'] ?></strong>
                                    <?php if($evaluation['eva_comment']): ?>
                                        <br><small>ข้อความจาก ผอ.: <?= $evaluation['eva_comment'] ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                                <i class="bx bx-save me-1"></i> บันทึกข้อมูลการส่งงาน
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 profile-card-exec text-white">
                <div class="card-body text-center py-5">
                    <img src="<?= $personnel['pers_img'] ? 'https://personnel.skj.ac.th/uploads/admin/Personnal/'.$personnel['pers_img'] : base_url('assets/admin/assets/img/avatars/1.png') ?>" 
                        class="rounded-circle mb-3 border border-3 border-white shadow" style="width: 100px; height: 100px; object-fit: cover;">
                    <h5 class="text-white fw-bold mb-1"><?= $personnel['pers_prefix'].$personnel['pers_firstname'].' '.$personnel['pers_lastname'] ?></h5>
                    <p class="mb-0 opacity-75"><?= session('roles')[0] ?></p>
                </div>
            </div>
            
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="bx bx-help-circle me-2"></i>คำแนะนำการใช้งาน</h6>
                    <ul class="list-unstyled small mb-0">
                        <li class="mb-2"><i class="bx bx-check-circle text-success me-2"></i>เลือกปีงบประมาณและรอบที่ต้องการส่งให้ถูกต้อง</li>
                        <li class="mb-2"><i class="bx bx-check-circle text-success me-2"></i>อัปโหลดไฟล์ PDF หรือใส่ลิงก์ผลงาน</li>
                        <li class="mb-2"><i class="bx bx-check-circle text-success me-2"></i>เมื่อกดบันทึกแล้ว สถานะจะเปลี่ยนเป็น "ส่งแล้ว"</li>
                        <li><i class="bx bx-check-circle text-success me-2"></i>รอผู้อำนวยการตรวจสอบและให้ข้อเสนอแนะ</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- History Table -->
        <div class="col-12 mt-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent border-bottom">
                    <h5 class="mb-0 fw-bold"><i class="bx bx-history me-1"></i> ประวัติการส่งงาน</h5>
                </div>
                <div class="card-body p-0 pb-5">
                    <div class="table-responsive">
                        <table class="table table-hover mb-5">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4 text-center" style="width: 80px;">จัดการ</th>
                                    <th>ปีงบประมาณ</th>
                                    <th>รอบที่</th>
                                    <th>ไฟล์แนบ</th>
                                    <th>สถานะ</th>
                                    <th>วันที่ส่ง</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($history)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">ยังไม่มีประวัติการส่งงาน</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach($history as $h): ?>
                                        <tr>
                                            <td class="ps-4 text-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-icon btn-label-secondary dropdown-toggle hide-arrow" data-bs-toggle="dropdown" data-bs-boundary="viewport">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="<?= base_url('Manager/Evaluation/Submit?year='.$h['eva_year'].'&round='.$h['eva_round']) ?>"><i class="bx bx-edit-alt me-1"></i> แก้ไข</a></li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li><a class="dropdown-item text-danger btn-delete" href="javascript:void(0);" data-id="<?= $h['eva_id'] ?>"><i class="bx bx-trash me-1"></i> ลบ</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td>ปีงบประมาณ <?= $h['eva_year'] ?></td>
                                            <td>รอบที่ <?= $h['eva_round'] ?></td>
                                            <td>
                                                <?php if($h['eva_file']): ?>
                                                    <a href="https://skj.nsnpao.go.th/uploads/evaluation/<?= $h['eva_year'] ?>/<?= $h['eva_round'] ?>/<?= $h['eva_file'] ?>" target="_blank" class="text-danger">
                                                        <i class="bx bxs-file-pdf fs-4"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if($h['eva_canva_link']): ?>
                                                    <a href="<?= $h['eva_canva_link'] ?>" target="_blank" class="text-info ms-2">
                                                        <i class="bx bx-link-alt fs-4"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-label-<?= $h['eva_status'] == 'ผ่านการตรวจสอบ' ? 'success' : ($h['eva_status'] == 'รอแก้ไข' ? 'warning' : 'info') ?>">
                                                    <?= $h['eva_status'] ?>
                                                </span>
                                            </td>
                                            <td>
                                                <small class="text-muted"><?= date('d/m/Y H:i', strtotime($h['eva_updated_at'])) ?></small>
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
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('evaluationForm');
    const remoteUrl = '<?= base_url('Manager/Evaluation/UploadChunk') ?>';
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const fileInput = document.getElementById('eva_file');
        const file = fileInput.files[0];
        const year = document.getElementById('eva_year').value;
        const round = document.querySelector('input[name="eva_round"]:checked').value;
        const pers_id = '<?= str_replace('P', '', session('AdminID')) ?>';
        
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> กำลังดำเนินการ...';

        let fileName = '<?= $evaluation ? $evaluation['eva_file'] : "" ?>';

        try {
            if (file) {
                // Determine Folder Path on remote server
                const path = `evaluation/${year}/${round}`;
                fileName = `${pers_id}_${year}_${round}_${Date.now()}.pdf`;
                
                // Chunked Upload
                await uploadInChunks(file, remoteUrl, path, fileName);
            }

            // After Upload (or if no file change), Save Metadata to Local DB
            const formData = new FormData();
            formData.append('eva_year', year);
            formData.append('eva_round', round);
            formData.append('eva_canva_link', document.getElementById('eva_canva_link').value);
            formData.append('eva_file_name', fileName); // ส่งชื่อไฟล์ที่ประมวลผลแล้ว
            
            const res = await fetch('<?= base_url('Manager/Evaluation/Save') ?>', {
                method: 'POST',
                body: formData
            }).then(r => r.json());

            if (res.status) {
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ',
                    text: res.message,
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => location.reload());
            } else {
                throw new Error(res.message);
            }

        } catch (err) {
            console.error(err);
            Swal.fire('ข้อผิดพลาด', err.message || 'ไม่สามารถส่งข้อมูลได้', 'error');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    });

    async function uploadInChunks(file, targetUrl, path, filename) {
        const chunkSize = 256 * 1024; // 256KB chunks
        const totalChunks = Math.ceil(file.size / chunkSize);
        const progressArea = document.getElementById('uploadProgress');
        const progressBar = progressArea.querySelector('.progress-bar');
        
        progressArea.classList.remove('d-none');
        
        for (let i = 0; i < totalChunks; i++) {
            const start = i * chunkSize;
            const end = Math.min(start + chunkSize, file.size);
            const chunk = file.slice(start, end);
            
            const formData = new FormData();
            formData.append('file', new Blob([chunk], {type: 'application/pdf'}), filename);
            formData.append('filename', filename);
            formData.append('chunk', i.toString());
            formData.append('chunks', totalChunks.toString());
            formData.append('path', path);
            formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
            
            const response = await fetch(targetUrl, {
                method: 'POST',
                body: formData
            });
            
            if (!response.ok) {
                const responseText = await response.text();
                let errMsg = `อัปโหลดไฟล์ล้มเหลวที่ส่วนที่ ${i+1} (HTTP ${response.status})`;
                try {
                    const errData = JSON.parse(responseText);
                    if (errData.message) errMsg = errData.message;
                } catch(e) {}
                throw new Error(errMsg);
            }
            
            const p = Math.round(((i + 1) / totalChunks) * 100);
            progressBar.style.width = p + '%';
            progressBar.innerHTML = p + '%';
        }
    }

    // Auto load data when year or round changes
    const yearSelect = document.getElementById('eva_year');
    const rounds = document.querySelectorAll('input[name="eva_round"]');

    function reloadWithParams() {
        const year = yearSelect.value;
        let round = 1;
        rounds.forEach(r => { if(r.checked) round = r.value; });
        window.location.href = `<?= base_url('Manager/Evaluation/Submit') ?>?year=${year}&round=${round}`;
    }

    yearSelect.addEventListener('change', reloadWithParams);
    rounds.forEach(r => r.addEventListener('change', reloadWithParams));

    // Delete submission
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            Swal.fire({
                title: 'ยืนยันการลบ?',
                text: "ข้อมูลและไฟล์ที่อัปโหลดจะถูกลบออกจากระบบ! (และลบจากเซิร์ฟเวอร์สำรองด้วย)",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'ใช่, ลบเลย!',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`<?= base_url('Manager/Evaluation/Delete') ?>/${id}`)
                        .then(r => r.json())
                        .then(res => {
                            if (res.status) {
                                Swal.fire('สำเร็จ', 'ลบข้อมูลเรียบร้อยแล้ว', 'success').then(() => location.reload());
                            } else {
                                Swal.fire('ข้อผิดพลาด', res.message, 'error');
                            }
                        });
                }
            });
        });
    });
});
</script>
<?= $this->endSection() ?>
