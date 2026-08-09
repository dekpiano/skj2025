<?= $this->extend('Admin/layout/AdminLayout') ?>

<?= $this->section('content') ?>
<!-- Mock the config object to prevent dashboards-analytics.js ReferenceError -->
<script>
    if (typeof config === 'undefined') {
        var config = {
            colors: {
                primary: '#696cff',
                secondary: '#8592a3',
                success: '#71dd37',
                info: '#03c3ec',
                warning: '#ffab00',
                danger: '#ff3e1d',
                dark: '#233446',
                black: '#000',
                white: '#fff',
                cardColor: '#fff',
                bodyBg: '#f5f5f9',
                borderColor: '#eceef1',
                hoverBorderColor: '#e1e4e8',
                axisColor: '#a1acb8',
                textMuted: '#b4bdc6'
            }
        };
    }
</script>

<!-- Load Boxicons from CDN to fix missing local font files -->
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">ตั้งค่า /</span> ป๊อปอัปแจ้งเตือน</h4>

    <form id="welcomeModalForm" enctype="multipart/form-data">
        <div class="row g-4">
            <!-- Left Side: General Switch & Add New Uploads -->
            <div class="col-12 col-md-4">
                <div class="card mb-4 shadow-sm">
                    <h5 class="card-header"><i class="bx bx-cog me-2 text-primary"></i>สวิตช์ควบคุมหลัก</h5>
                    <div class="card-body">
                        <!-- Toggle Status Mode -->
                        <div class="mb-4">
                            <label class="form-label d-block fw-semibold text-dark mb-2">เปิด/ปิด ระบบป๊อปอัปหลัก</label>
                            
                            <div class="form-check form-switch form-switch-lg mb-2">
                                <input class="form-check-input" type="checkbox" id="welcomeModalStatus" name="status" value="on" <?= $status == 'on' ? 'checked' : '' ?> style="width: 50px; height: 25px; cursor: pointer;">
                                <label class="form-check-label ms-2 fw-semibold" for="welcomeModalStatus" id="statusLabel"><?= $status == 'on' ? 'เปิดใช้งาน' : 'ปิดใช้งาน' ?></label>
                            </div>
                            <small class="text-muted d-block lh-base mb-3">หากปิดสวิตช์นี้ ป๊อปอัปทั้งหมดจะไม่แสดงผลในหน้าแรกของเว็บไซต์</small>
                        </div>

                        <!-- Button to Trigger Modal Form for Adding New Announcement -->
                        <button type="button" class="btn btn-outline-primary w-100 py-2 fw-semibold mb-3" data-bs-toggle="modal" data-bs-target="#addNewAnnouncementModal">
                            <i class="bx bx-plus-circle me-1"></i> เพิ่มรูปภาพประกาศใหม่
                        </button>

                        <!-- Temp Previews & Setting Inputs for New Files -->
                        <div id="newFilesList" class="mb-4 d-none">
                            <label class="form-label text-primary fw-semibold mb-2"><i class="bx bx-check-circle me-1"></i>รูปภาพใหม่เตรียมอัปโหลด:</label>
                            <div id="tempNewFiles" class="d-flex flex-column gap-3"></div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold" id="btnSave">
                            <i class="bx bx-save me-1"></i> บันทึกการตั้งค่าทั้งหมด
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right Side: Image List with Independent Title & Schedule Settings -->
            <div class="col-12 col-md-8">
                <div class="card mb-4 shadow-sm">
                    <h5 class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div>
                            <i class="bx bx-image me-2 text-primary"></i>รายการรูปภาพประกาศและการตั้งค่าเวลาประจำรูป
                            <span class="badge bg-label-primary fs-tiny ms-1" id="itemCountBadge"><?= count($items ?? []) ?> ประกาศ</span>
                        </div>
                        <button type="submit" class="btn btn-sm btn-success fw-semibold btn-save-top">
                            <i class="bx bx-save me-1"></i> บันทึกการแก้ไขทั้งหมด
                        </button>
                    </h5>
                    <div class="card-body">
                        <p class="text-muted small mb-3"><i class="bx bx-info-circle me-1 text-info"></i>แต่ละรูปภาพสามารถ <strong>ตั้งชื่อประกาศ</strong> และ <strong>กำหนดช่วงเวลาแสดงผลแยกกันเฉพาะรูปนั้นๆ</strong> ได้ เมื่อแก้ไขเสร็จแล้วสามารถกดปุ่ม <strong>"บันทึกรูปนี้"</strong> หรือ <strong>"บันทึกการแก้ไขทั้งหมด"</strong> ได้ทันที</p>
                        
                        <div id="imageListContainer">
                            <?php if (!empty($items) && is_array($items)): ?>
                                <?php foreach ($items as $index => $item): 
                                    $imgFile = is_array($item) ? ($item['file'] ?? '') : $item;
                                    $imgTitle = is_array($item) ? ($item['title'] ?? '') : '';
                                    $startDt = is_array($item) ? ($item['start_datetime'] ?? '') : '';
                                    $endDt = is_array($item) ? ($item['end_datetime'] ?? '') : '';
                                ?>
                                    <div class="image-item border rounded p-3 mb-3 bg-white shadow-sm" data-filename="<?= esc($imgFile) ?>">
                                        <input type="hidden" name="item_file[]" value="<?= esc($imgFile) ?>">
                                        
                                        <div class="d-flex flex-column flex-sm-row align-items-start justify-content-between gap-3 mb-3 border-bottom pb-2">
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-primary rounded-circle me-2 order-num" style="width: 26px; height: 26px; display: inline-flex; align-items: center; justify-content: center;"><?= $index + 1 ?></span>
                                                <div>
                                                    <strong class="text-dark d-block item-display-title"><?= esc($imgTitle ?: 'ประกาศที่ ' . ($index + 1)) ?></strong>
                                                    <small class="text-muted fs-tiny"><i class="bx bx-file me-1"></i><?= esc($imgFile) ?></small>
                                                </div>
                                            </div>
                                            
                                            <div class="btn-group btn-group-sm w-100 w-sm-auto justify-content-end">
                                                <button type="button" class="btn btn-outline-primary btn-edit-item" data-bs-toggle="collapse" data-bs-target="#editItemCollapse_<?= $index ?>" aria-expanded="true">
                                                    <i class="bx bx-edit-alt me-1"></i> แก้ไข
                                                </button>
                                                <button type="button" class="btn btn-outline-secondary btn-move-up" title="เลื่อนขึ้น"><i class="bx bx-chevron-up"></i></button>
                                                <button type="button" class="btn btn-outline-secondary btn-move-down" title="เลื่อนลง"><i class="bx bx-chevron-down"></i></button>
                                                <button type="button" class="btn btn-outline-danger btn-delete-img" title="ลบ"><i class="bx bx-trash"></i></button>
                                            </div>
                                        </div>

                                        <!-- Collapsible Edit Section for this item -->
                                        <div class="collapse show" id="editItemCollapse_<?= $index ?>">
                                            <div class="row g-3 align-items-center bg-light rounded p-3 border">
                                                <!-- Preview Image -->
                                                <div class="col-12 col-sm-3 text-center">
                                                    <img src="<?= base_url('uploads/welcome/' . $imgFile) ?>" class="rounded border img-thumbnail bg-white" style="max-height: 110px; width: 100%; object-fit: contain;" alt="รูปภาพประกาศ">
                                                </div>

                                                <!-- Form Inputs for this specific item -->
                                                <div class="col-12 col-sm-9">
                                                    <div class="mb-2">
                                                        <label class="form-label small fw-semibold text-dark mb-1"><i class="bx bx-rename text-primary me-1"></i>หัวข้อ/ชื่อประกาศ (แสดงกำกับ):</label>
                                                        <input type="text" class="form-control form-control-sm item-title-input" name="item_title[]" placeholder="เช่น กิจกรรมเปิดบ้าน SKJ Open House" value="<?= esc($imgTitle) ?>">
                                                    </div>

                                                    <div class="row g-2 mb-2">
                                                        <div class="col-12 col-md-6">
                                                            <label class="form-label fs-tiny fw-semibold text-muted mb-1"><i class="bx bx-play-circle text-success me-1"></i>เริ่มแสดง (วันที่-เวลา):</label>
                                                            <input type="datetime-local" class="form-control form-control-sm" name="item_start_datetime[]" value="<?= esc($startDt) ?>">
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <label class="form-label fs-tiny fw-semibold text-muted mb-1"><i class="bx bx-stop-circle text-danger me-1"></i>สิ้นสุดการแสดง (วันที่-เวลา):</label>
                                                            <input type="datetime-local" class="form-control form-control-sm" name="item_end_datetime[]" value="<?= esc($endDt) ?>">
                                                        </div>
                                                    </div>

                                                    <div class="d-flex justify-content-between align-items-center pt-1">
                                                        <small class="text-muted fs-tiny">* ไม่ระบุ = แสดงตลอด</small>
                                                        <button type="submit" class="btn btn-sm btn-success fw-semibold">
                                                            <i class="bx bx-save me-1"></i> บันทึกรูปนี้
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="p-5 border border-dashed rounded text-center text-muted no-images-placeholder">
                                    <i class="bx bx-image-alt fs-1 d-block mb-2"></i>
                                    ยังไม่มีรูปภาพประกาศในระบบ
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Modal for Adding New Announcement Image with Form Settings -->
<div class="modal fade" id="addNewAnnouncementModal" tabindex="-1" aria-labelledby="addNewAnnouncementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-header-title text-white m-0" id="addNewAnnouncementModalLabel"><i class="bx bx-plus-circle me-1"></i> เพิ่มรูปภาพประกาศใหม่</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label for="modal_upload_file" class="form-label fw-semibold text-dark">1. เลือกรูปภาพประกาศ <span class="text-danger">*</span></label>
                    <input class="form-control" type="file" id="modal_upload_file" accept="image/*">
                    <small class="text-muted fs-tiny d-block mt-1">แนะนำรูปภาพแนวตั้งหรือแนวนอน ขนาดความกว้างไม่เกิน 800-1000px</small>
                </div>

                <div class="mb-3">
                    <label for="modal_item_title" class="form-label fw-semibold text-dark">2. หัวข้อ/ชื่อประกาศ (ไม่บังคับ):</label>
                    <input type="text" class="form-control" id="modal_item_title" placeholder="เช่น แจ้งหยุดเรียนกรณีพิเศษ / รับสมัครนักเรียน">
                </div>

                <div class="row g-3 mb-2">
                    <div class="col-12 col-md-6">
                        <label for="modal_item_start" class="form-label small fw-semibold text-dark"><i class="bx bx-play-circle text-success me-1"></i>เริ่มแสดง (วันที่-เวลา):</label>
                        <input type="datetime-local" class="form-control" id="modal_item_start">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="modal_item_end" class="form-label small fw-semibold text-dark"><i class="bx bx-stop-circle text-danger me-1"></i>สิ้นสุดแสดง (วันที่-เวลา):</label>
                        <input type="datetime-local" class="form-control" id="modal_item_end">
                    </div>
                </div>
                <small class="text-muted fs-tiny d-block">* หากไม่ระบุวันที่และเวลา รูปประกาศนี้จะแสดงผลตลอดเวลาเมื่อสวิตช์หลักเปิดอยู่</small>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary" id="btnConfirmAddModal">
                    <i class="bx bx-check me-1"></i> ตกลงเพิ่มประกาศ
                </button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
console.log('[WelcomeModal] Scripts section loaded. jQuery version:', $.fn.jquery);

$(function() {
    console.log('[WelcomeModal] Document ready fired');

    $('#welcomeModalStatus').on('change', function() {
        const isChecked = $(this).is(':checked');
        $('#statusLabel').text(isChecked ? 'เปิดใช้งาน' : 'ปิดใช้งาน');
    });

    // Helper to update display numbers in sorted list
    function updateOrderNumbers() {
        const count = $('#imageListContainer .image-item').length;
        $('#itemCountBadge').text(count + ' ประกาศ');

        $('#imageListContainer .image-item').each(function(index) {
            $(this).find('.order-num').text(index + 1);
        });
        
        if (count === 0) {
            if ($('.no-images-placeholder').length === 0) {
                $('#imageListContainer').html(
                    '<div class="p-5 border border-dashed rounded text-center text-muted no-images-placeholder">' +
                    '<i class="bx bx-image-alt fs-1 d-block mb-2"></i>' +
                    'ยังไม่มีรูปภาพประกาศในระบบ' +
                    '</div>'
                );
            }
        } else {
            $('.no-images-placeholder').remove();
        }
    }

    // Move item Up
    $('#imageListContainer').on('click', '.btn-move-up', function(e) {
        e.preventDefault();
        var $item = $(this).closest('.image-item');
        var $prev = $item.prev('.image-item');
        if ($prev.length) {
            $item.insertBefore($prev);
            updateOrderNumbers();
        }
    });

    // Move item Down
    $('#imageListContainer').on('click', '.btn-move-down', function(e) {
        e.preventDefault();
        var $item = $(this).closest('.image-item');
        var $next = $item.next('.image-item');
        if ($next.length) {
            $item.insertAfter($next);
            updateOrderNumbers();
        }
    });

    // Delete image item
    $('#imageListContainer').on('click', '.btn-delete-img', function(e) {
        e.preventDefault();
        var $item = $(this).closest('.image-item');
        Swal.fire({
            title: 'ต้องการลบรูปภาพนี้หรือไม่?',
            text: "รูปภาพนี้จะถูกลบเมื่อกดบันทึกข้อมูล",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff3e1d',
            cancelButtonColor: '#8592a3',
            confirmButtonText: 'ใช่, ต้องการลบ',
            cancelButtonText: 'ยกเลิก'
        }).then(function(result) {
            if (result.isConfirmed) {
                $item.fadeOut(300, function() {
                    $(this).remove();
                    updateOrderNumbers();
                });
            }
        });
    });

    // Handle modal confirmation for adding a new announcement
    var pendingUploadFiles = [];

    $('#btnConfirmAddModal').on('click', function() {
        var fileInput = document.getElementById('modal_upload_file');
        if (!fileInput.files || fileInput.files.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'กรุณาเลือกไฟล์รูปภาพ',
                text: 'โปรดเลือกไฟล์รูปภาพประกาศก่อนทำการตกลง'
            });
            return;
        }

        var file = fileInput.files[0];
        var title = $('#modal_item_title').val() || '';
        var startDt = $('#modal_item_start').val() || '';
        var endDt = $('#modal_item_end').val() || '';

        var fileIdx = pendingUploadFiles.length;
        pendingUploadFiles.push({
            file: file,
            title: title,
            start_datetime: startDt,
            end_datetime: endDt
        });

        $('#newFilesList').removeClass('d-none');
        $('#tempNewFiles').append(
            '<div class="p-3 border rounded bg-light small shadow-sm temp-file-card" data-idx="' + fileIdx + '">' +
                '<div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom">' +
                    '<span class="fw-bold text-dark text-truncate" style="max-width: 75%;">' +
                        '<i class="bx bx-image me-1 text-primary"></i>' + (title ? esc(title) : file.name) + 
                    '</span>' +
                    '<button type="button" class="btn btn-sm btn-label-danger btn-remove-temp-file p-1 px-2"><i class="bx bx-x"></i> ลบ</button>' +
                '</div>' +
                '<div class="mb-1"><strong class="text-secondary">ชื่อไฟล์:</strong> ' + esc(file.name) + ' (' + (file.size / 1024).toFixed(1) + ' KB)</div>' +
                '<div class="row g-2 text-muted fs-tiny">' +
                    '<div class="col-6"><strong>เริ่ม:</strong> ' + (startDt ? startDt.replace('T', ' ') : 'ไม่ระบุ') + '</div>' +
                    '<div class="col-6"><strong>สิ้นสุด:</strong> ' + (endDt ? endDt.replace('T', ' ') : 'ไม่ระบุ') + '</div>' +
                '</div>' +
                '<input type="hidden" class="temp-title" value="' + esc(title) + '">' +
                '<input type="hidden" class="temp-start" value="' + esc(startDt) + '">' +
                '<input type="hidden" class="temp-end" value="' + esc(endDt) + '">' +
            '</div>'
        );

        // Reset modal fields and hide modal
        $('#modal_upload_file').val('');
        $('#modal_item_title').val('');
        $('#modal_item_start').val('');
        $('#modal_item_end').val('');
        
        var modalEl = document.getElementById('addNewAnnouncementModal');
        var modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) modalInstance.hide();
    });

    // Remove pending temp file item
    $('#tempNewFiles').on('click', '.btn-remove-temp-file', function() {
        var $card = $(this).closest('.temp-file-card');
        var idx = $card.attr('data-idx');
        if (pendingUploadFiles[idx]) {
            pendingUploadFiles[idx] = null;
        }
        $card.fadeOut(250, function() {
            $(this).remove();
            if ($('#tempNewFiles .temp-file-card').length === 0) {
                $('#newFilesList').addClass('d-none');
            }
        });
    });

    // Helper for HTML escaping
    function esc(str) {
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    // Submit form using AJAX
    $('#welcomeModalForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);

        // Append pending upload files with their configured metadata
        if (pendingUploadFiles.length > 0) {
            for (var i = 0; i < pendingUploadFiles.length; i++) {
                var item = pendingUploadFiles[i];
                if (item && item.file) {
                    formData.append('welcome_modal_imgs[]', item.file);
                    formData.append('new_item_title[]', item.title || '');
                    formData.append('new_item_start_datetime[]', item.start_datetime || '');
                    formData.append('new_item_end_datetime[]', item.end_datetime || '');
                }
            }
        }

        $('#btnSave').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> กำลังบันทึก...');

        $.ajax({
            url: '<?= base_url('Admin/WelcomeModal/Update') ?>',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#btnSave').prop('disabled', false).html('<i class="bx bx-save me-1"></i> บันทึกข้อมูลทั้งหมด');
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ!',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'ผิดพลาด!',
                        text: response.message || 'ไม่สามารถบันทึกได้'
                    });
                }
            },
            error: function(xhr, status, error) {
                $('#btnSave').prop('disabled', false).html('<i class="bx bx-save me-1"></i> บันทึกข้อมูลทั้งหมด');
                console.error('AJAX Error:', status, error, xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'ผิดพลาด!',
                    text: 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์: ' + (xhr.status || '') + ' ' + (error || '')
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
