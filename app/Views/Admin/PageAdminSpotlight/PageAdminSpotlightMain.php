<?= $this->extend('Admin/layout/AdminLayout') ?>

<?= $this->section('content') ?>
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-0">
            <span class="text-muted fw-light">แดชบอร์ด /</span> Spotlight ประชาสัมพันธ์พิเศษ
        </h4>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" id="AddSpotlight">
                <i class="bx bx-plus me-1"></i> เพิ่ม Spotlight ใหม่
            </button>
        </div>
    </div>

    <!-- Banner List Card -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between border-bottom">
            <h5 class="mb-0 text-primary fw-bold">รายการ Spotlight ทั้งหมด</h5>
            <small class="text-muted">รวมทั้งสิ้น <?= count($spotlights) ?> รายการ</small>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle mb-0" id="myTable">
                    <thead class="table-light">
                        <tr>
                            <th width="10%">การจัดการ</th>
                            <th width="10%">สถานะ</th>
                            <th width="40%">ข้อมูล Spotlight</th>
                            <th width="30%">ตัวอย่างภาพ</th>
                            <th width="10%">วันที่ลง</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php foreach ($spotlights as $v_spot) : ?>
                        <tr id="<?= $v_spot['spotlight_id'] ?>">
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item EditSpotlight" href="javascript:void(0);" key-spotlightid="<?= $v_spot['spotlight_id'] ?>">
                                            <i class="bx bx-edit-alt me-1 text-info"></i> แก้ไขข้อมูล
                                        </a>
                                        <a class="dropdown-item DeleteSpotlight" href="javascript:void(0);" key-spotlightid="<?= $v_spot['spotlight_id'] ?>">
                                            <i class="bx bx-trash me-1 text-danger"></i> ลบรายการ
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <label class="switch-toggle" title="ล็อก/ปลดล็อก">
                                    <input type="checkbox" class="form-check-input-toggle" status-key="<?= $v_spot['spotlight_id'] ?>" 
                                        <?= $v_spot['spotlight_status'] == "on" ? "checked" : "" ?>>
                                    <span class="slider-toggle">
                                        <span class="label-on">เปิด</span>
                                        <span class="label-off">ปิด</span>
                                    </span>
                                </label>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="badge <?= $v_spot['spotlight_badge_color'] ?> rounded-pill align-self-start py-1 px-2 mb-1 fw-normal" style="font-size: 0.7rem;"><?= $v_spot['spotlight_badge'] ?></span>
                                    <span class="fw-bold text-dark text-wrap" style="max-width: 250px;">
                                        <?= $v_spot['spotlight_topic'] ?> <span class="text-primary"><?= $v_spot['spotlight_topic_highlight'] ?></span>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <?php
                                    $imageUrl = base_url('uploads/spotlight/' . $v_spot['spotlight_img']);
                                    $imagePath = FCPATH . 'uploads/spotlight/' . $v_spot['spotlight_img'];
                                    if (empty($v_spot['spotlight_img']) || !file_exists($imagePath)) {
                                        $imageUrl = 'https://via.placeholder.com/600x200.png?text=Image+Not+Found';
                                    }
                                ?>
                                <div class="spotlight-preview rounded border overflow-hidden shadow-sm" style="max-width: 150px;">
                                    <img src="<?= $imageUrl ?>" class="img-fluid" alt="<?= $v_spot['spotlight_topic'] ?>">
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-label-secondary"><?= date('Y/m/d', strtotime($v_spot['spotlight_date'])) ?></span>
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
<div class="modal fade" id="ModalAddSpotlight" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header border-bottom">
                <h5 class="modal-title text-primary fw-bold" id="ModalTitle">จัดการ Spotlight</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-spotlight" method="post" enctype="multipart/form-data">
                <input type="hidden" name="spotlight_id" id="spotlight_id">
                <input type="hidden" name="original_spotlight_img" id="original_spotlight_img">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="row mb-4 bg-light p-3 rounded mx-1 shadow-none border">
                        <div class="col-md-12">
                            <h6 class="text-primary fw-bold mb-2"><i class="bx bxl-facebook-square"></i> ดึงเนื้อหาจาก Facebook (อัตโนมัติ)</h6>
                            <div class="input-group">
                                <button class="btn btn-outline-primary" type="button" id="btn_load_fb">
                                    <i class="bx bx-cloud-download"></i> โหลดโพสต์ล่าสุด
                                </button>
                                <select class="form-select" id="sel_SpotlightFromFacebook">
                                    <option value="">-- กรุณากดปุ่มเพื่อโหลดโพสต์ล่าสุดจาก Facebook เพจ --</option>
                                </select>
                            </div>
                            <small class="text-muted mt-1 d-block"><i class="bx bx-info-circle"></i> เลือกโพสต์ที่ต้องการ ระบบจะนำข้อความและรูปภาพมาใส่ในฟอร์มด้านล่างให้อัตโนมัติ</small>
                            <img src="" id="facebook_preview_img" class="mt-2 d-none rounded border" style="max-height: 150px;">
                            <input type="hidden" name="spotlight_facebook_img_url" id="spotlight_facebook_img_url">
                        </div>
                    </div>
                    <div class="row">

                        <!-- Left Column: Image -->
                        <div class="col-md-5 mb-4 border-end pe-4">
                            <label class="form-label fw-bold text-primary mb-2"> <i class="bx bx-image"></i> รูปภาพปก Spotlight (แนะนำ 1:1 หรือแนวนอน)</label>
                            <input type="file" name="spotlight_img" id="spotlight_img">
                        </div>

                        <!-- Right Column: Content -->
                        <div class="col-md-7 mb-4 ps-4">
                            <div class="row">
                                <h6 class="text-primary fw-bold"><i class="bx bx-text"></i> ข้อความหลัก</h6>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" name="spotlight_badge" id="spotlight_badge" placeholder="เช่น ข่าวด่วน" required>
                                        <label for="spotlight_badge">ป้ายกำกับ (Badge)</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <select class="form-select" id="spotlight_badge_color" name="spotlight_badge_color">
                                            <option value="bg-danger">แดง (Danger)</option>
                                            <option value="bg-warning">เหลือง (Warning)</option>
                                            <option value="bg-primary">น้ำเงิน (Primary)</option>
                                            <option value="bg-info">ฟ้า (Info)</option>
                                            <option value="bg-success">เขียว (Success)</option>
                                        </select>
                                        <label for="spotlight_badge_color">สีป้ายกำกับ</label>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" name="spotlight_topic" id="spotlight_topic" placeholder="บรรทัดแรก" required>
                                        <label for="spotlight_topic">หัวข้อบรรทัดแรก</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" name="spotlight_topic_highlight" id="spotlight_topic_highlight" placeholder="บรรทัดไฮไลท์">
                                        <label for="spotlight_topic_highlight">หัวข้อบรรทัดไฮไลท์ (สีน้ำเงิน)</label>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <textarea class="form-control h-px-100" name="spotlight_content" id="spotlight_content" placeholder="รายละเอียดแบบย่อ" required></textarea>
                                        <label for="spotlight_content">รายละเอียด (Description)</label>
                                    </div>
                                </div>

                                <hr class="mt-2 mb-3 text-muted">

                                <h6 class="text-primary fw-bold"><i class="bx bx-link"></i> ปุ่มและลิงก์</h6>
                                <div class="col-md-4 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" name="spotlight_btn_text" id="spotlight_btn_text" placeholder="อ่านต่อ...">
                                        <label for="spotlight_btn_text">ข้อความปุ่ม</label>
                                    </div>
                                </div>
                                <div class="col-md-5 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" name="spotlight_btn_link" id="spotlight_btn_link" placeholder="https://...">
                                        <label for="spotlight_btn_link">ลิงก์ URL</label>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <select class="form-select" id="spotlight_btn_color" name="spotlight_btn_color">
                                            <option value="btn-outline-primary">กรอบน้ำเงิน</option>
                                            <option value="btn-primary">พื้นน้ำเงิน</option>
                                            <option value="btn-outline-info">กรอบฟ้า</option>
                                            <option value="btn-info text-white">พื้นฟ้า</option>
                                            <option value="btn-warning text-dark">พื้นเหลือง</option>
                                        </select>
                                        <label for="spotlight_btn_color">สไตล์ปุ่ม</label>
                                    </div>
                                </div>



                                <hr class="mt-2 mb-3 text-muted">

                                <h6 class="text-primary fw-bold"><i class="bx bx-layout"></i> การแสดงผล (Layout)</h6>
                                <div class="col-md-4 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <select class="form-select" id="spotlight_layout" name="spotlight_layout">
                                            <option value="left">รูปภาพอยู่ซ้าย</option>
                                            <option value="right">รูปภาพอยู่ขวา</option>
                                        </select>
                                        <label for="spotlight_layout">ตำแหน่งรูปภาพ</label>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <select class="form-select" id="spotlight_theme" name="spotlight_theme">
                                            <option value="light">สว่าง (Light)</option>
                                            <option value="dark">มืด (Dark)</option>
                                        </select>
                                        <label for="spotlight_theme">ธีมสีพื้นหลัง</label>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <input class="form-control" type="datetime-local" value="<?= date('Y-m-d H:i') ?>" id="spotlight_date" name="spotlight_date" required>
                                        <label for="spotlight_date">วันที่ประกาศ</label>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer border-top bg-light pt-3">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary" id="submitSpotlightBtn">
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
    let pond;
    const BASE_URL = "<?= base_url() ?>";

    $(document).ready(function() {
        const dataTable = $('#myTable').DataTable({
            order: [[4, 'desc']],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "ค้นหา...",
                lengthMenu: "_MENU_",
                paginate: {
                    first: "แรกสุด",
                    last: "ท้ายสุด",
                    next: '<i class="bx bx-chevron-right"></i>',
                    previous: '<i class="bx bx-chevron-left"></i>'
                }
            }
        });

        $('#form-spotlight').on('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const pondFile = pond ? pond.getFile() : null;
            const isUpdate = $(this).attr('action').includes('UpdateSpotlight');

            if (pondFile) {
                formData.append('spotlight_img', pondFile.file);
            }

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                beforeSend: function() {
                    $('#submitSpotlightBtn').prop('disabled', true).find('.spinner-border').removeClass('d-none');
                    Swal.fire({ title: 'กำลังบันทึก...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); }});
                },
                complete: function() {
                    $('#submitSpotlightBtn').prop('disabled', false).find('.spinner-border').addClass('d-none');
                },
                success: function(response) {
                    if (response.status) {
                        $('#ModalAddSpotlight').modal('hide');
                        Swal.fire({
                            icon: 'success', title: 'สำเร็จ!', text: response.message, timer: 2000, showConfirmButton: false
                        }).then(() => {
                            window.location.reload(); 
                        });
                    } else {
                        Swal.fire({ icon: 'error', title: 'ไม่สำเร็จ', text: response.message });
                    }
                }
            });
        });

        $('#ModalAddSpotlight').on('hidden.bs.modal', function () {
            if (pond) { pond.destroy(); pond = null; }
            $('#form-spotlight').trigger('reset');
            $('#facebook_preview_img').addClass('d-none').attr('src', '');
            $('#spotlight_facebook_img_url').val('');
            $('#sel_SpotlightFromFacebook').html('<option value="">-- กรุณากดปุ่มเพื่อโหลดโพสต์ล่าสุดจาก Facebook เพจ --</option>');
        });

        $('#btn_load_fb').click(function() {
            let selectBox = $('#sel_SpotlightFromFacebook');
            selectBox.prop('disabled', true).html('<option value="">-- กำลังโหลดข้อมูล... --</option>');
            $(this).prop('disabled', true);
            
            $.post('<?= base_url('Admin/News/View/Facebook') ?>', function(data) {
                if(data.error) {
                    selectBox.html(`<option value="">-- เกิดข้อผิดพลาด: ${data.error.message || data.error} --</option>`);
                } else if(data.data && data.data.length > 0) {
                    let options = '<option value="">-- เลือกโพสต์ที่ต้องการ... --</option>';
                    data.data.forEach(function(post) {
                        if(post.message) {
                            let preview = post.message.substr(0, 100).replace(/\n/g, ' ') + '...';
                            let date = new Date(post.created_time).toLocaleDateString('th-TH');
                            options += `<option value="${post.id}">${date} - ${preview}</option>`;
                        }
                    });
                    selectBox.html(options).prop('disabled', false);
                } else {
                    selectBox.html('<option value="">-- ไม่พบข้อมูลโพสต์ --</option>');
                }
                $('#btn_load_fb').prop('disabled', false);
            }, 'json').fail(function() {
                selectBox.html('<option value="">-- ไม่สามารถดึงข้อมูลได้ (Server Error) --</option>');
                $('#btn_load_fb').prop('disabled', false);
            });
        });

        $('#sel_SpotlightFromFacebook').change(function() {
            let val = $(this).val();
            if(!val) return;
            
            Swal.fire({ title: 'กำลังดึงข้อมูล...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); }});
            
            $.post('<?= base_url('Admin/News/Select/Facebook') ?>', { KeyNewsFB: val }, function(data) {
                Swal.close();
                if(data.message) {
                    $('#spotlight_topic').val(data.message.substr(0, 60));
                    $('#spotlight_topic_highlight').val('');
                    $('#spotlight_content').val(data.message);
                }
                if(data.created_time) {
                    $('#spotlight_date').val(data.created_time.replace(' ', 'T').slice(0, 16));
                }
                if(data.full_picture) {
                    $('#spotlight_facebook_img_url').val(data.full_picture);
                    $('#facebook_preview_img').attr('src', data.full_picture).removeClass('d-none');
                }
            }, 'json');
        });

        $(document).on("click", "#AddSpotlight", function() {
            $('#ModalTitle').text('เพิ่ม Spotlight ใหม่');
            $('#form-spotlight').attr('action', '<?=base_url('Admin/Spotlight/AddSpotlight')?>').trigger('reset');
            initFilePond();
            new bootstrap.Modal(document.getElementById("ModalAddSpotlight")).show();
        });

        $(document).on("click", ".EditSpotlight", function() {
            $('#ModalTitle').text('แก้ไขข้อมูล Spotlight');
            $('#form-spotlight').attr('action', '<?=base_url('Admin/Spotlight/UpdateSpotlight')?>');
            let id = $(this).attr('key-spotlightid');

            $.post('<?=base_url('Admin/Spotlight/EditSpotlight')?>', { KeySpotlightid: id }, function(data) {
                if(data) {
                    $('#spotlight_id').val(data.spotlight_id);
                    $('#spotlight_badge').val(data.spotlight_badge);
                    $('#spotlight_badge_color').val(data.spotlight_badge_color);
                    $('#spotlight_topic').val(data.spotlight_topic);
                    $('#spotlight_topic_highlight').val(data.spotlight_topic_highlight);
                    $('#spotlight_content').val(data.spotlight_content);
                    $('#spotlight_btn_text').val(data.spotlight_btn_text);
                    $('#spotlight_btn_link').val(data.spotlight_btn_link);
                    $('#spotlight_btn_color').val(data.spotlight_btn_color);
                    $('#spotlight_layout').val(data.spotlight_layout);
                    $('#spotlight_theme').val(data.spotlight_theme);
                    $('#original_spotlight_img').val(data.spotlight_img);
                    
                    let date = new Date(data.spotlight_date);
                    let formattedDate = date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2) + 'T' + ('0' + date.getHours()).slice(-2) + ':' + ('0' + date.getMinutes()).slice(-2);
                    $('#spotlight_date').val(formattedDate);

                    initFilePond(data.spotlight_img);
                    new bootstrap.Modal(document.getElementById("ModalAddSpotlight")).show();
                }
            }, 'json');
        });

        $(document).on("change", ".form-check-input-toggle", function() {
            const status = $(this).is(":checked") ? "on" : "off";
            const key = $(this).attr('status-key');

            $.post("<?=base_url('Admin/Spotlight/SpotlightOnoff')?>", { Onoffstatus: status, Keystatus: key }, function() {
                Swal.fire({ position: 'top-end', icon: 'success', title: 'อัปเดตสถานะการแสดงผลแล้ว', showConfirmButton: false, timer: 1500 });
            });
        });

        $(document).on("click", ".DeleteSpotlight", function() {
            let ID = $(this).attr('key-spotlightid');
            Swal.fire({
                title: 'ยืนยันการลบ?', text: "ข้อมูลนี้ไม่สามารถกู้คืนได้!", icon: 'warning', showCancelButton: true, confirmButtonColor: '#ff3e1d', cancelButtonColor: '#8592a3', confirmButtonText: 'ลบข้อมูล'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('<?=base_url('Admin/Spotlight/DeleteSpotlight')?>', { KeySpotlightid: ID }, function(data) {
                        if (data == 1) {
                            $(`#${ID}`).fadeOut(function() { $(this).remove(); });
                            Swal.fire({ icon: 'success', title: 'ลบสำเร็จ!', timer: 1500, showConfirmButton: false });
                        }
                    });
                }
            });
        });

        $('#ModalAddSpotlight').on('hidden.bs.modal', function () {
            if (pond) { pond.destroy(); pond = null; }
            $('#form-spotlight').trigger('reset');
        });

        function initFilePond(imgName = null) {
            const inputElement = document.querySelector('#spotlight_img');
            if (pond) { pond.destroy(); }
            let options = { labelIdle: 'ลากไฟล์มาวาง หรือ <span class="filepond--label-action">คลิกเพื่ออัปโหลด</span>', imagePreviewHeight: 200, acceptedFileTypes: ['image/*'], credits: false };
            if (imgName) { options.files = [{ source: `${BASE_URL}/uploads/spotlight/${imgName}` }]; }
            pond = FilePond.create(inputElement, options);
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

    .spotlight-preview { transition: transform 0.2s; cursor: pointer; }
    .spotlight-preview:hover { transform: scale(1.05); }
    .dataTables_wrapper .dataTables_filter input { border: 1px solid #d9dee3; border-radius: 0.375rem; padding: 0.422rem 0.875rem; }
    .dataTables_wrapper .dataTables_paginate .paginate_button { padding: 0.3rem 0.5rem; }
</style>
<?= $this->endSection() ?>
