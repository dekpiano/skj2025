<?= $this->extend('Admin/layout/AdminLayout') ?>

<?= $this->section('content') ?>
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-0">
            <span class="text-muted fw-light">แดชบอร์ด /</span> แบนเนอร์ประชาสัมพันธ์
        </h4>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-danger" id="CleanupBanner">
                <i class="bx bx-trash-alt me-1"></i> ล้างไฟล์ขยะ
            </button>
            <button class="btn btn-primary" id="AddBanner">
                <i class="bx bx-plus me-1"></i> เพิ่มแบนเนอร์ใหม่
            </button>
        </div>
    </div>

    <!-- Banner List Card -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between border-bottom">
            <h5 class="mb-0 text-primary fw-bold">รายการแบนเนอร์ทั้งหมด</h5>
            <small class="text-muted">รวมทั้งสิ้น <?= count($banner) ?> รายการ</small>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle mb-0" id="myTable">
                    <thead class="table-light">
                        <tr>
                            <th width="10%">การจัดการ</th>
                            <th width="10%">สถานะ</th>
                            <th width="30%">ข้อมูลแบนเนอร์</th>
                            <th width="20%">Desktop (21:9)</th>
                            <th width="15%">Mobile (9:16)</th>
                            <th width="15%">วันที่แสดงผล</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php foreach ($banner as $v_banner) : ?>
                        <tr id="<?= $v_banner->banner_id ?>">
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item Editbanner" href="javascript:void(0);" key-bannerid="<?= $v_banner->banner_id ?>">
                                            <i class="bx bx-edit-alt me-1 text-info"></i> แก้ไขข้อมูล
                                        </a>
                                        <a class="dropdown-item Deletebanner" href="javascript:void(0);" key-bannerid="<?= $v_banner->banner_id ?>">
                                            <i class="bx bx-trash me-1 text-danger"></i> ลบรายการ
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column align-items-center gap-2">
                                    <label class="switch-toggle" title="เปิด/ปิดการแสดงผล">
                                        <input type="checkbox" class="form-check-input-toggle" status-key="<?= $v_banner->banner_id ?>" 
                                            <?= $v_banner->banner_status == "on" ? "checked" : "" ?>>
                                        <span class="slider-toggle">
                                            <span class="label-on">เปิด</span>
                                            <span class="label-off">ปิด</span>
                                        </span>
                                    </label>
                                    <?php 
                                        $now = time();
                                        $startDate = strtotime($v_banner->banner_date);
                                        $endDate = $v_banner->banner_end_date ? strtotime($v_banner->banner_end_date . ' 23:59:59') : null;
                                        
                                        if ($v_banner->banner_status == 'off') {
                                            echo '<span class="badge bg-label-secondary small-badge">ถูกปิดไว้</span>';
                                        } elseif ($now < $startDate) {
                                            echo '<span class="badge bg-label-info small-badge">รอเริ่มแสดง</span>';
                                        } elseif ($endDate && $now > $endDate) {
                                            echo '<span class="badge bg-label-danger small-badge">หมดอายุ</span>';
                                        } else {
                                            echo '<span class="badge bg-label-success small-badge">กำลังแสดง</span>';
                                        }
                                    ?>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-heading text-truncate mb-1" style="max-width: 280px;" title="<?= $v_banner->banner_name ?>">
                                        <?= $v_banner->banner_name ?>
                                    </span>
                                    <?php if ($v_banner->banner_linkweb): ?>
                                        <a href="<?= $v_banner->banner_linkweb ?>" target="_blank" class="text-primary text-truncate small" style="max-width: 280px;">
                                            <i class="bx bx-link me-1"></i><?= $v_banner->banner_linkweb ?>
                                        </a>
                                    <?php else: ?>
                                        <small class="text-muted"><i class="bx bx-link-external me-1"></i>ไม่มีลิงก์เชื่อมโยง</small>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <?php
                                    $imageUrl = base_url('uploads/banner/all/' . $v_banner->banner_img);
                                    $imagePath = FCPATH . 'uploads/banner/all/' . $v_banner->banner_img;
                                    if (empty($v_banner->banner_img) || !file_exists($imagePath)) {
                                        $imageUrl = 'https://via.placeholder.com/600x200.png?text=No+Desktop+Image';
                                    }
                                ?>
                                <div class="banner-preview-container">
                                    <a href="<?= $imageUrl ?>" target="_blank" class="d-block">
                                        <div class="banner-preview rounded overflow-hidden shadow-sm">
                                            <img src="<?= $imageUrl ?>" class="img-fluid" alt="Desktop">
                                            <div class="banner-preview-overlay">
                                                <i class="bx bx-desktop"></i>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </td>
                            <td>
                                <?php
                                    $imageMobileUrl = base_url('uploads/banner/all/' . $v_banner->banner_img_mobile);
                                    $imageMobilePath = FCPATH . 'uploads/banner/all/' . $v_banner->banner_img_mobile;
                                    if (empty($v_banner->banner_img_mobile) || !file_exists($imageMobilePath)) {
                                        $imageMobileUrl = 'https://via.placeholder.com/200x400.png?text=No+Mobile+Image';
                                    }
                                ?>
                                <div class="banner-preview-container-mobile">
                                    <a href="<?= $imageMobileUrl ?>" target="_blank" class="d-block">
                                        <div class="banner-preview rounded overflow-hidden shadow-sm">
                                            <img src="<?= $imageMobileUrl ?>" class="img-fluid" alt="Mobile">
                                            <div class="banner-preview-overlay">
                                                <i class="bx bx-mobile"></i>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </td>
                             <td>
                                <div class="d-flex flex-column gap-1">
                                    <div class="d-flex align-items-center gap-1">
                                        <i class="bx bx-calendar-event text-info small"></i>
                                        <span class="small text-muted">เริ่ม:</span>
                                        <span class="fw-medium small"><?= date('d/m/Y H:i', strtotime($v_banner->banner_date)) ?></span>
                                    </div>
                                    <?php if ($v_banner->banner_end_date): ?>
                                        <div class="d-flex align-items-center gap-1">
                                            <i class="bx bx-calendar-x text-warning small"></i>
                                            <span class="small text-muted">สิ้นสุด:</span>
                                            <span class="fw-medium small"><?= date('d/m/Y', strtotime($v_banner->banner_end_date)) ?></span>
                                        </div>
                                    <?php else: ?>
                                        <div class="d-flex align-items-center gap-1">
                                            <i class="bx bx-infinite text-muted small"></i>
                                            <span class="small text-muted">ไม่มีกำหนด</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('modals') ?>
<div class="modal fade" id="ModalAddBanner" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header border-bottom">
                <h5 class="modal-title text-primary fw-bold" id="ModalTitle">จัดการแบนเนอร์</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-banner" method="post" enctype="multipart/form-data">
                <input type="hidden" name="banner_id" id="banner_id">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <!-- Section: General Info -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar avatar-sm bg-label-primary me-2">
                                <span class="avatar-initial rounded"><i class="bx bx-info-circle"></i></span>
                            </div>
                            <h6 class="mb-0 text-primary fw-bold">ข้อมูลพื้นฐาน</h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" name="banner_name" id="banner_name" placeholder="ใส่หัวข้อแบนเนอร์..." required>
                                    <label for="banner_name">หัวข้อแบนเนอร์ / ชื่อกิจกรรม</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" name="banner_linkweb" id="banner_linkweb" placeholder="Ex. https://google.com">
                                    <label for="banner_linkweb">ลิงก์เชื่อมโยง (Link URL)</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" type="datetime-local" value="<?= date('Y-m-d H:i') ?>" id="banner_date" name="banner_date" required>
                                    <label for="banner_date">วันที่เริ่มแสดงผล</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" type="date" id="banner_end_date" name="banner_end_date">
                                    <label for="banner_end_date">แสดงผลจนถึงวันที่ (ถ้ามี)</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Section: Media Upload -->
                    <div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar avatar-sm bg-label-info me-2">
                                <span class="avatar-initial rounded"><i class="bx bx-image-alt"></i></span>
                            </div>
                            <h6 class="mb-0 text-info fw-bold">สื่อประชาสัมพันธ์ (Responsive Images)</h6>
                        </div>
                        <div class="row g-4">
                            <!-- Desktop Version -->
                            <div class="col-md-7">
                                <div class="upload-label mb-2">
                                    <span class="badge bg-label-dark">Desktop Version</span>
                                    <small class="text-muted ms-2">แนะนำ 1920x822 (21:9)</small>
                                </div>
                                <div class="filepond-wrapper desktop-pond">
                                    <input type="file" name="banner_img" id="banner_img">
                                    <input type="hidden" name="original_banner_img" id="original_banner_img">
                                </div>
                            </div>
                            <!-- Mobile Version -->
                            <div class="col-md-5">
                                <div class="upload-label mb-2">
                                    <span class="badge bg-label-info">Mobile Version</span>
                                    <small class="text-muted ms-2">แนะนำ 1080x1920 (9:16)</small>
                                </div>
                                <div class="filepond-wrapper mobile-pond">
                                    <input type="file" name="banner_img_mobile" id="banner_img_mobile">
                                    <input type="hidden" name="original_banner_img_mobile" id="original_banner_img_mobile">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary" id="submitBannerBtn">
                        <span class="spinner-border spinner-border-sm d-none me-1" role="status" aria-hidden="true"></span>
                        <i class="bx bx-save me-1"></i> บันทึกข้อมูล
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
<script>
    FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginFileValidateType);
    let pond, pondMobile;
    const BASE_URL = "<?= base_url() ?>";

    $(document).ready(function() {
        const dataTable = $('#myTable').DataTable({
            order: [],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "ค้นหาแบนเนอร์...",
                lengthMenu: "_MENU_",
                paginate: {
                    first: "แรกสุด",
                    last: "ท้ายสุด",
                    next: '<i class="bx bx-chevron-right"></i>',
                    previous: '<i class="bx bx-chevron-left"></i>'
                }
            }
        });

        $('#form-banner').on('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const pondFile = pond ? pond.getFile() : null;
            const pondMobileFile = pondMobile ? pondMobile.getFile() : null;

            if (pondFile) formData.append('banner_img', pondFile.file);
            if (pondMobileFile) formData.append('banner_img_mobile', pondMobileFile.file);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                beforeSend: function() {
                    $('#submitBannerBtn').prop('disabled', true).find('.spinner-border').removeClass('d-none');
                    Swal.fire({
                        title: 'กำลังบันทึก...',
                        allowOutsideClick: false,
                        didOpen: () => { Swal.showLoading(); }
                    });
                },
                complete: function() {
                    $('#submitBannerBtn').prop('disabled', false).find('.spinner-border').addClass('d-none');
                },
                success: function(response) {
                    if (response.status) {
                        $('#ModalAddBanner').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'สำเร็จ!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });

                        window.location.reload(); 
                    } else {
                        Swal.fire({ icon: 'error', title: 'ไม่สำเร็จ', text: response.message });
                    }
                }
            });
        });

        $(document).on("click", "#CleanupBanner", function() {
            Swal.fire({
                title: 'ยืนยันการล้างไฟล์ขยะ?',
                text: "ระบบจะทำการตรวจสอบและลบไฟล์รูปภาพที่ไม่ได้ใช้งานออกจากเซิร์ฟเวอร์",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff3e1d',
                cancelButtonColor: '#8592a3',
                confirmButtonText: 'ยืนยันการลบ',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'กำลังประมวลผล...',
                        html: 'กรุณารอสักครู่ ระบบกำลังตรวจสอบไฟล์...',
                        allowOutsideClick: false,
                        didOpen: () => { Swal.showLoading(); }
                    });

                    $.post('<?=base_url('Admin/Banner/CleanupImages')?>', function(response) {
                        Swal.close();
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'เสร็จสิ้น!',
                                text: response.message,
                                timer: 3000
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด',
                                text: response.message
                            });
                        }
                    }, 'json').fail(function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้'
                        });
                    });
                }
            });
        });

        $(document).on("click", "#AddBanner", function() {
            $('#ModalTitle').text('เพิ่มแบนเนอร์ใหม่');
            $('#form-banner').attr('action', '<?=base_url('Admin/Banner/Addbanner')?>').trigger('reset');
            $('#banner_id').val('');
            $('#original_banner_img').val('');
            $('#original_banner_img_mobile').val('');
            
            initFilePond(null, 'desktop');
            initFilePond(null, 'mobile');
            new bootstrap.Modal(document.getElementById("ModalAddBanner")).show();
        });

        $(document).on("click", ".Editbanner", function() {
            $('#ModalTitle').text('แก้ไขข้อมูลแบนเนอร์');
            $('#form-banner').attr('action', '<?=base_url('Admin/Banner/Updatebanner')?>');
            let bannerId = $(this).attr('key-bannerid');

            $.post('<?=base_url('Admin/Banner/EditBanner')?>', { KeyBannerid: bannerId }, function(data) {
                if(data) {
                    $('#banner_id').val(data.banner_id);
                    $('#banner_name').val(data.banner_name);
                    $('#banner_linkweb').val(data.banner_linkweb);
                    $('#original_banner_img').val(data.banner_img);
                    $('#original_banner_img_mobile').val(data.banner_img_mobile);
                    
                    let date = new Date(data.banner_date);
                    let formattedDate = date.getFullYear() + '-' + 
                                     ('0' + (date.getMonth() + 1)).slice(-2) + '-' + 
                                     ('0' + date.getDate()).slice(-2) + 'T' + 
                                     ('0' + date.getHours()).slice(-2) + ':' + 
                                     ('0' + date.getMinutes()).slice(-2);
                    $('#banner_date').val(formattedDate);

                    if (data.banner_end_date) {
                        $('#banner_end_date').val(data.banner_end_date);
                    } else {
                        $('#banner_end_date').val('');
                    }

                    initFilePond(data.banner_img, 'desktop');
                    initFilePond(data.banner_img_mobile, 'mobile');
                    new bootstrap.Modal(document.getElementById("ModalAddBanner")).show();
                }
            }, 'json');
        });

        $(document).on("change", ".form-check-input-toggle", function() {
            const status = $(this).is(":checked") ? "on" : "off";
            const key = $(this).attr('status-key');

            $.post("<?=base_url('Admin/Banner/BannerOnoff')?>", { Onoffstatus: status, Keystatus: key }, function() {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'อัปเดตสถานะการแสดงผลแล้ว',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        });

        $(document).on("click", ".Deletebanner", function() {
            let bannerID = $(this).attr('key-bannerid');
            Swal.fire({
                title: 'ยืนยันการลบแบนเนอร์?',
                text: "ข้อมูลนี้ไม่สามารถกู้คืนได้!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff3e1d',
                cancelButtonColor: '#8592a3',
                confirmButtonText: 'ลบข้อมูล'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('<?=base_url('Admin/Banner/DeleteBanner')?>', { KeyBannerid: bannerID }, function(data) {
                        if (data == 1) {
                            $(`#${bannerID}`).fadeOut(function() { $(this).remove(); });
                            Swal.fire({ icon: 'success', title: 'ลบสำเร็จ!', timer: 1500, showConfirmButton: false });
                        }
                    });
                }
            });
        });

        $('#ModalAddBanner').on('hidden.bs.modal', function () {
            if (pond) { pond.destroy(); pond = null; }
            if (pondMobile) { pondMobile.destroy(); pondMobile = null; }
            $('#form-banner').trigger('reset');
        });

        function initFilePond(imgName = null, type = 'desktop') {
            const selector = type === 'desktop' ? '#banner_img' : '#banner_img_mobile';
            const inputElement = document.querySelector(selector);
            
            if (type === 'desktop' && pond) { pond.destroy(); }
            if (type === 'mobile' && pondMobile) { pondMobile.destroy(); }
            
            let options = {
                labelIdle: type === 'desktop' 
                    ? '<i class="bx bx-cloud-upload d-block fs-2 mb-2"></i> Desktop Version (21:9)<br><span class="filepond--label-action">เลือกไฟล์</span> หรือ ลากมาวาง'
                    : '<i class="bx bx-mobile-vibration d-block fs-2 mb-2"></i> Mobile (9:16)<br><span class="filepond--label-action">เลือกไฟล์</span> หรือ ลากวาง',
                imagePreviewHeight: type === 'desktop' ? 180 : 250,
                acceptedFileTypes: ['image/*'],
                credits: false,
                styleButtonProcessItemPosition: 'right',
                styleLoadIndicatorPosition: 'right',
                styleProgressIndicatorPosition: 'right',
                styleButtonRemoveItemPosition: 'left',
            };

            if (imgName) {
                options.files = [{ source: `${BASE_URL}/uploads/banner/all/${imgName}` }];
            }

            if (type === 'desktop') {
                pond = FilePond.create(inputElement, options);
            } else {
                pondMobile = FilePond.create(inputElement, options);
            }
        }
    });
</script>

<style>
    .card { border-radius: 0.75rem; }
    .table thead th { font-weight: 600; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; }

    /* Custom Switch ON/OFF */
    .switch-toggle { position: relative; display: inline-block; width: 65px; height: 32px; margin: 0; }
    .switch-toggle input { opacity: 0; width: 0; height: 0; }
    .slider-toggle { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ff3e1d; transition: .4s; border-radius: 34px; box-shadow: inset 0 2px 4px rgba(0,0,0,0.1); }
    .slider-toggle:before { position: absolute; content: ""; height: 24px; width: 24px; left: 4px; bottom: 4px; background-color: white; transition: .4s; border-radius: 50%; box-shadow: 0 2px 5px rgba(0,0,0,0.2); z-index: 2; }
    .switch-toggle input:checked + .slider-toggle { background-color: #71dd37; }
    .switch-toggle input:checked + .slider-toggle:before { transform: translateX(33px); }
    .slider-toggle .label-on, .slider-toggle .label-off { position: absolute; top: 50%; transform: translateY(-50%); color: white; font-size: 11px; font-weight: bold; z-index: 1; transition: opacity 0.3s; }
    .slider-toggle .label-on { left: 8px; opacity: 0; }
    .slider-toggle .label-off { right: 10px; opacity: 1; }
    .switch-toggle input:checked + .slider-toggle .label-on { opacity: 1; }
    .switch-toggle input:checked + .slider-toggle .label-off { opacity: 0; }
    
    .small-badge { font-size: 0.65rem; padding: 0.2rem 0.5rem; text-transform: none; }
    .banner-preview-container { max-width: 180px; }
    .banner-preview-container-mobile { max-width: 80px; }
    .banner-preview { position: relative; transition: all 0.3s ease; border: 1px solid rgba(0,0,0,0.05); background: #f8f9fa; }
    .banner-preview img { display: block; width: 100%; transition: transform 0.3s ease; }
    .banner-preview-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); display: flex; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.3s ease; }
    .banner-preview-overlay i { color: white; font-size: 1.5rem; }
    .banner-preview:hover { transform: translateY(-3px); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1) !important; }
    .banner-preview:hover img { transform: scale(1.05); }
    .banner-preview:hover .banner-preview-overlay { opacity: 1; }

    /* Mobile Specific Admin UI */
    @media screen and (max-width: 991px) {
        .banner-preview-container { max-width: 120px; }
        .banner-preview-container-mobile { max-width: 60px; }
        .table-responsive { border: 0; }
    }
    
    .dataTables_wrapper .dataTables_filter input { border: 1px solid #d9dee3; border-radius: 0.375rem; padding: 0.422rem 0.875rem; width: 250px; }
    .dataTables_wrapper .dataTables_paginate .paginate_button { padding: 0.3rem 0.5rem; }
    
    /* Table row hover effect */
    .table-hover tbody tr:hover { background-color: rgba(105, 108, 255, 0.04); }

    /* FilePond Custom Styling */
    .filepond--panel-root { background-color: #f8f9fa; border: 2px dashed #d9dee3; }
    .desktop-pond .filepond--root { min-height: 200px; }
    .mobile-pond .filepond--root { min-height: 200px; }
    .filepond--label-action { text-decoration-color: var(--primary); color: var(--primary); }
    .filepond--drop-label { color: #566a71; }
    
    .avatar-sm { width: 32px; height: 32px; }
    .bg-label-primary { background-color: #e7e7ff !important; color: #696cff !important; }
    .bg-label-info { background-color: #d7f5fc !important; color: #03c3ec !important; }
    .upload-label .badge { font-size: 0.7rem; }
</style>
<?= $this->endSection() ?>
