<?= $this->extend('Admin/layout/AdminLayout') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">ตั้งค่า /</span> ระบบเว็บไซต์</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header"><i class="bx bx-cog me-2"></i>การตั้งค่าเทศกาลและธีม</h5>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>รายการตั้งค่า</th>
                                    <th>รายละเอียด</th>
                                    <th>สถานะ/ค่าที่ตั้ง</th>
                                    <th>อัปเดตล่าสุด</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                <?php if (!empty($settings)): ?>
                                    <?php foreach ($settings as $setting): ?>
                                    <tr>
                                        <td><strong><?= $setting['setting_name'] ?></strong></td>
                                        <td><?= $setting['setting_description'] ?></td>
                                        <td>
                                            <?php if ($setting['setting_name'] == 'festival_theme'): ?>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input festival-toggle" type="checkbox" 
                                                        data-id="<?= $setting['setting_id'] ?>" 
                                                        <?= $setting['setting_value'] == 'on' ? 'checked' : '' ?>>
                                                    <label class="form-check-label"><?= $setting['setting_value'] == 'on' ? 'เปิดใช้งาน' : 'ปิดใช้งาน' ?></label>
                                                </div>
                                            <?php else: ?>
                                                <input type="text" class="form-control form-control-sm setting-input" 
                                                    data-id="<?= $setting['setting_id'] ?>" 
                                                    value="<?= $setting['setting_value'] ?>">
                                            <?php endif; ?>
                                        </td>
                                        <td><small class="text-muted"><?= date('d/m/Y H:i', strtotime($setting['updated_at'])) ?></small></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center">ไม่พบข้อมูลการตั้งค่า</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Future expansion section -->
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="bx bx-bulb me-2"></i>ข้อมูลเพิ่มเติม</h5>
                    <p class="card-text">
                        ระบบการตั้งค่านี้ถูกออกแบบมาเพื่อรองรับการขยายตัวในอนาคต คุณสามารถเพิ่มการตั้งค่าอื่นๆ เช่น 
                        ข้อความวิ่งหน้าเว็บ, การประกาศฉุกเฉิน หรือการเปลี่ยนสีธีมหลักของเว็บไซต์ได้จากหน้านี้
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Handle Toggle Switch
    $('.festival-toggle').on('change', function() {
        const isChecked = $(this).is(':checked');
        const status = isChecked ? 'on' : 'off';
        const label = $(this).next('label');

        $.ajax({
            url: '<?= base_url('Admin/toggleFestival') ?>',
            method: 'POST',
            data: { status: status },
            success: function(response) {
                if (response.status === 'success') {
                    label.text(isChecked ? 'เปิดใช้งาน' : 'ปิดใช้งาน');
                    Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ!',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'ผิดพลาด!', text: response.message });
                    $(this).prop('checked', !isChecked);
                }
            },
            error: function() {
                Swal.fire({ icon: 'error', title: 'ผิดพลาด!', text: 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์' });
                $(this).prop('checked', !isChecked);
            }
        });
    });

    // Handle Text Input Blur (Optional Auto-save for other settings)
    $('.setting-input').on('blur', function() {
        const val = $(this).val();
        const id = $(this).data('id');
        
        // Only save if value changed (you could add original value tracking here)
        $.ajax({
            url: '<?= base_url('Admin/Settings/Update') ?>',
            method: 'POST',
            data: { id: id, value: val },
            success: function(response) {
                if (response.status === 'success') {
                    // Success toast or subtle feedback
                }
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
