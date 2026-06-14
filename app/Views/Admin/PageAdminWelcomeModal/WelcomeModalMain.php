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

    <div class="row g-4">
        <!-- Settings Form (Takes full width on mobile, 5 cols on medium and above) -->
        <div class="col-12 col-md-5">
            <div class="card mb-4 shadow-sm">
                <h5 class="card-header"><i class="bx bx-cog me-2 text-primary"></i>จัดการป๊อปอัปแจ้งเตือน</h5>
                <div class="card-body">
                    <form id="welcomeModalForm" enctype="multipart/form-data">
                        <!-- Toggle Status -->
                        <div class="mb-4">
                            <label class="form-label d-block fw-semibold text-dark">สถานะการแสดงป๊อปอัป</label>
                            <div class="form-check form-switch form-switch-lg mb-2">
                                <input class="form-check-input" type="checkbox" id="welcomeModalStatus" name="status" value="on" <?= $status == 'on' ? 'checked' : '' ?> style="width: 50px; height: 25px; cursor: pointer;">
                                <label class="form-check-label ms-2 fw-semibold" for="welcomeModalStatus" id="statusLabel"><?= $status == 'on' ? 'เปิดใช้งาน' : 'ปิดใช้งาน' ?></label>
                            </div>
                            <small class="text-muted d-block lh-base">เปิด/ปิด ป๊อปอัปแจ้งเตือนที่จะเด้งแสดงผลขึ้นมาในหน้าแรกเมื่อมีคนเข้าชมเว็บไซต์</small>
                        </div>

                        <!-- Image File Upload -->
                        <div class="mb-4">
                            <label for="welcome_modal_imgs" class="form-label fw-semibold text-dark">อัปโหลดรูปภาพประกาศเพิ่ม (อัปโหลดได้หลายรูปพร้อมกัน)</label>
                            <input class="form-control" type="file" id="welcome_modal_imgs" name="welcome_modal_imgs[]" accept="image/*" multiple>
                            <small class="text-muted d-block mt-1 lh-base">แนะนำขนาดความกว้างไม่เกิน 800px - 1000px เป็นไฟล์รูปภาพ PNG, JPG หรือ WEBP</small>
                        </div>

                        <!-- Temp Previews for New Files -->
                        <div id="newFilesList" class="mb-4 d-none">
                            <label class="form-label text-primary fw-semibold"><i class="bx bx-plus-circle me-1"></i>รูปภาพใหม่เตรียมอัปโหลด:</label>
                            <ul class="list-group list-group-flush border rounded p-2" id="tempNewFiles"></ul>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold" id="btnSave">
                            <i class="bx bx-save me-1"></i> บันทึกข้อมูลตั้งค่า
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Image Sorting List (Takes full width on mobile, 7 cols on medium and above) -->
        <div class="col-12 col-md-7">
            <div class="card mb-4 shadow-sm">
                <h5 class="card-header"><i class="bx bx-image me-2 text-primary"></i>รูปภาพประกาศและการเรียงลำดับ</h5>
                <div class="card-body">
                    <p class="text-muted small mb-3"><i class="bx bx-info-circle me-1 text-info"></i>ใช้ปุ่มควบคุมด้านขวาของแต่ละรูปภาพเพื่อ <strong>จัดเรียงลำดับ</strong> หรือ <strong>ลบรูปภาพ</strong></p>
                    
                    <div id="imageListContainer">
                        <?php if (!empty($images) && is_array($images)): ?>
                            <?php foreach ($images as $index => $img): ?>
                                <div class="image-item border rounded p-3 mb-2 d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between bg-light gap-3" data-filename="<?= $img ?>">
                                    <div class="d-flex align-items-center w-100 w-sm-auto">
                                        <div class="me-3 text-secondary fw-bold order-num" style="min-width: 20px;"><?= $index + 1 ?></div>
                                        <img src="<?= base_url('uploads/welcome/' . $img) ?>" class="rounded border bg-white" style="width: 70px; height: auto; max-height: 70px; object-fit: contain;" alt="รูปภาพประกาศ">
                                        <div class="ms-3 text-truncate text-muted small flex-grow-1" style="max-width: 180px;"><?= esc($img) ?></div>
                                    </div>
                                    <div class="btn-group btn-group-sm w-100 w-sm-auto justify-content-end" role="group">
                                        <button type="button" class="btn btn-outline-secondary btn-move-up" title="เลื่อนขึ้น"><i class="bx bx-chevron-up"></i> เลื่อนขึ้น</button>
                                        <button type="button" class="btn btn-outline-secondary btn-move-down" title="เลื่อนลง"><i class="bx bx-chevron-down"></i> เลื่อนลง</button>
                                        <button type="button" class="btn btn-outline-danger btn-delete-img" title="ลบ"><i class="bx bx-trash"></i></button>
                                    </div>
                                    <input type="hidden" name="existing_images[]" value="<?= esc($img) ?>">
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="p-5 border border-dashed rounded text-center text-muted no-images-placeholder">
                                <i class="bx bx-image-alt fs-1 d-block mb-2"></i>
                                ยังไม่มีรูปภาพประกาศ
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
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

    // Label toggle state text change
    $('#welcomeModalStatus').on('change', function() {
        const isChecked = $(this).is(':checked');
        $('#statusLabel').text(isChecked ? 'เปิดใช้งาน' : 'ปิดใช้งาน');
    });

    // Helper to update display numbers in sorted list
    function updateOrderNumbers() {
        $('#imageListContainer .image-item').each(function(index) {
            $(this).find('.order-num').text(index + 1);
        });
        
        // Show placeholder if empty
        if ($('#imageListContainer .image-item').length === 0) {
            if ($('.no-images-placeholder').length === 0) {
                $('#imageListContainer').html(
                    '<div class="p-5 border border-dashed rounded text-center text-muted no-images-placeholder">' +
                    '<i class="bx bx-image-alt fs-1 d-block mb-2"></i>' +
                    'ยังไม่มีรูปภาพประกาศ' +
                    '</div>'
                );
            }
        } else {
            $('.no-images-placeholder').remove();
        }
    }

    // Move item Up — use direct delegation on #imageListContainer
    $('#imageListContainer').on('click', '.btn-move-up', function(e) {
        e.preventDefault();
        e.stopPropagation();
        console.log('[WelcomeModal] btn-move-up clicked');
        var $item = $(this).closest('.image-item');
        var $prev = $item.prev('.image-item');
        if ($prev.length) {
            $item.css('background-color', '#e7f3ff');
            $item.insertBefore($prev);
            updateOrderNumbers();
            setTimeout(function() { $item.css('background-color', ''); }, 400);
        }
    });

    // Move item Down — use direct delegation on #imageListContainer
    $('#imageListContainer').on('click', '.btn-move-down', function(e) {
        e.preventDefault();
        e.stopPropagation();
        console.log('[WelcomeModal] btn-move-down clicked');
        var $item = $(this).closest('.image-item');
        var $next = $item.next('.image-item');
        if ($next.length) {
            $item.css('background-color', '#e7f3ff');
            $item.insertAfter($next);
            updateOrderNumbers();
            setTimeout(function() { $item.css('background-color', ''); }, 400);
        }
    });

    // Delete image item
    $('#imageListContainer').on('click', '.btn-delete-img', function(e) {
        e.preventDefault();
        e.stopPropagation();
        console.log('[WelcomeModal] btn-delete-img clicked');
        var $item = $(this).closest('.image-item');
        Swal.fire({
            title: 'ต้องการลบรูปภาพนี้หรือไม่?',
            text: "รูปภาพจะถูกลบออกจากระบบเมื่อกดบันทึกข้อมูลตั้งค่า",
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

    // Show temporary list of newly selected files
    $('#welcome_modal_imgs').on('change', function() {
        var files = this.files;
        $('#tempNewFiles').empty();
        
        if (files.length > 0) {
            $('#newFilesList').removeClass('d-none');
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                $('#tempNewFiles').append(
                    '<li class="list-group-item d-flex align-items-center py-2 text-secondary small">' +
                    '<i class="bx bx-file me-2 text-primary"></i>' +
                    '<span class="text-truncate" style="max-width: 80%;">' + file.name + '</span>' +
                    '<span class="badge bg-label-primary ms-auto">' + (file.size / 1024).toFixed(1) + ' KB</span>' +
                    '</li>'
                );
            }
        } else {
            $('#newFilesList').addClass('d-none');
        }
    });

    // Submit form using AJAX
    $('#welcomeModalForm').on('submit', function(e) {
        e.preventDefault();
        
        // Build FormData manually to avoid duplicate hidden input values
        var formData = new FormData();
        
        // 1. Status
        formData.append('status', $('#welcomeModalStatus').is(':checked') ? 'on' : 'off');

        // 2. Existing images in current DOM order (single source of truth)
        $('#imageListContainer .image-item').each(function() {
            var filename = $(this).attr('data-filename') || $(this).find('input[name="existing_images[]"]').val();
            if (filename) {
                console.log('[WelcomeModal] Appending image:', filename);
                formData.append('existing_images[]', filename);
            }
        });

        // 3. New file uploads
        var fileInput = document.getElementById('welcome_modal_imgs');
        if (fileInput && fileInput.files.length > 0) {
            for (var i = 0; i < fileInput.files.length; i++) {
                formData.append('welcome_modal_imgs[]', fileInput.files[i]);
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
                $('#btnSave').prop('disabled', false).html('<i class="bx bx-save me-1"></i> บันทึกข้อมูลตั้งค่า');
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ!',
                        text: response.message,
                        timer: 2000,
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
                $('#btnSave').prop('disabled', false).html('<i class="bx bx-save me-1"></i> บันทึกข้อมูลตั้งค่า');
                console.error('AJAX Error:', status, error, xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'ผิดพลาด!',
                    text: 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์: ' + (xhr.status || '') + ' ' + (error || '')
                });
            }
        });
    });

    console.log('[WelcomeModal] All event handlers bound successfully. Image items found:', $('#imageListContainer .image-item').length);
});
</script>
<?= $this->endSection() ?>
