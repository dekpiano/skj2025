<?= $this->extend('Admin/PageAdminBotany/layout/BotanyAdminLayout') ?>

<?= $this->section('content') ?>
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-0">
            <span class="text-muted fw-light">แดชบอร์ด /</span> จัดการข้อมูลพรรณไม้
        </h4>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" id="AddBotany">
                <i class="bx bx-plus me-1"></i> เพิ่มพรรณไม้ใหม่
            </button>
        </div>
    </div>

    <!-- Botany List Card -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between border-bottom">
            <h5 class="mb-0 text-primary fw-bold">รายการพรรณไม้ทั้งหมด</h5>
            <small class="text-muted">รวมทั้งสิ้น <?= count($botany) ?> รายการ</small>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle mb-0" id="botanyTable">
                    <thead class="table-light">
                        <tr>
                            <th width="10%">การจัดการ</th>
                            <th width="10%">สถานะ</th>
                            <th width="25%">ชื่อพรรณไม้</th>
                            <th width="20%">ชื่อวิทยาศาสตร์/วงศ์</th>
                            <th width="20%">รูปภาพ</th>
                            <th width="15%">ประเภท/ที่ตั้ง</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php foreach ($botany as $v) : ?>
                        <tr id="row-<?= $v->botany_id ?>">
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item EditBotany" href="javascript:void(0);" key-botanyid="<?= $v->botany_id ?>">
                                            <i class="bx bx-edit-alt me-1 text-info"></i> แก้ไขข้อมูล
                                        </a>
                                        <a class="dropdown-item DeleteBotany" href="javascript:void(0);" key-botanyid="<?= $v->botany_id ?>">
                                            <i class="bx bx-trash me-1 text-danger"></i> ลบรายการ
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <label class="switch-toggle">
                                    <input type="checkbox" class="form-check-input-toggle" status-key="<?= $v->botany_id ?>" 
                                        <?= $v->botany_status == "active" ? "checked" : "" ?>>
                                    <span class="slider-toggle">
                                        <span class="label-on">เปิด</span>
                                        <span class="label-off">ปิด</span>
                                    </span>
                                </label>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-dark"><?= $v->botany_name_th ?></span>
                                    <small class="text-muted italic"><?= $v->botany_name_en ?></small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <small class="text-primary italic"><?= $v->botany_science_name ?></small>
                                    <small class="text-secondary"><?= $v->botany_family ?></small>
                                </div>
                            </td>
                            <td>
                                <?php
                                    $imageUrl = base_url('uploads/botany/' . ($v->botany_image ?: 'default-plant.jpg'));
                                ?>
                                <div class="rounded border overflow-hidden shadow-sm" style="width: 80px; height: 60px;">
                                    <img src="<?= $imageUrl ?>" class="w-100 h-100 object-fit-cover" alt="<?= $v->botany_name_th ?>" onerror="this.src='https://via.placeholder.com/80x60?text=No+Img'">
                                </div>
                            </td>
                             <td>
                                <div class="d-flex flex-column">
                                    <span class="badge bg-label-success mb-1"><?= $v->botany_type ?></span>
                                    <small class="text-muted"><i class="bx bx-map-pin me-1"></i><?= $v->botany_location ?></small>
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
<div class="modal fade" id="ModalBotany" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header border-bottom">
                <h5 class="modal-title text-primary fw-bold" id="ModalTitle">จัดการข้อมูลพรรณไม้</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-botany" method="post" enctype="multipart/form-data">
                <input type="hidden" name="botany_id" id="botany_id">
                <input type="hidden" name="original_botany_image" id="original_botany_image">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="row">
                        <!-- Left Side: Basic Info -->
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">ชื่อไทย <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="botany_name_th" id="botany_name_th" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">ชื่อสามัญ (ภาษาอังกฤษ)</label>
                                    <input type="text" class="form-control" name="botany_name_en" id="botany_name_en">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">ชื่อวิทยาศาสตร์</label>
                                    <input type="text" class="form-control" name="botany_science_name" id="botany_science_name">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">วงศ์ (Family)</label>
                                    <input type="text" class="form-control" name="botany_family" id="botany_family">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">ประเภทพรรณไม้</label>
                                    <select class="form-select" name="botany_type" id="botany_type">
                                        <option value="ไม้ยืนต้น">ไม้ยืนต้น</option>
                                        <option value="ไม้พุ่ม">ไม้พุ่ม</option>
                                        <option value="ไม้ล้มลุก">ไม้ล้มลุก</option>
                                        <option value="ไม้เลื้อย">ไม้เลื้อย</option>
                                        <option value="ไม้น้ำ">ไม้น้ำ</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">ที่ตั้งภายในโรงเรียน</label>
                                    <input type="text" class="form-control" name="botany_location" id="botany_location">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">ลักษณะทางพฤกษศาสตร์</label>
                                    <textarea class="form-control" name="botany_description" id="botany_description" rows="4"></textarea>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">สรรพคุณ / ประโยชน์</label>
                                    <textarea class="form-control" name="botany_benefit" id="botany_benefit" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- Right Side: Image -->
                        <div class="col-lg-4">
                            <label class="form-label">รูปภาพพรรณไม้</label>
                            <input type="file" name="botany_image" id="botany_image">
                            <div class="alert alert-info mt-3 small">
                                <i class="bx bx-info-circle me-1"></i> แนะนำขนาดภาพ 800x600 px หรืออัตราส่วน 4:3
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
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
        // CSRF Token Setup
        const csrfName = '<?= csrf_token() ?>';
        let csrfHash = '<?= csrf_hash() ?>';

        function getCsrfData() {
            let data = {};
            data[csrfName] = csrfHash;
            return data;
        }

        const dataTable = $('#botanyTable').DataTable({
            language: {
                search: "_INPUT_",
                searchPlaceholder: "ค้นหา...",
                lengthMenu: "_MENU_",
                paginate: {
                    next: '<i class="bx bx-chevron-right"></i>',
                    previous: '<i class="bx bx-chevron-left"></i>'
                }
            }
        });

        $('#form-botany').on('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const pondFile = pond ? pond.getFile() : null;

            if (pondFile) {
                formData.append('botany_image', pondFile.file);
            }
            
            // Add CSRF to FormData
            formData.append(csrfName, csrfHash);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                beforeSend: function() {
                    $('#submitBtn').prop('disabled', true).find('.spinner-border').removeClass('d-none');
                    Swal.fire({ title: 'กำลังบันทึก...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
                },
                complete: function() {
                    $('#submitBtn').prop('disabled', false).find('.spinner-border').addClass('d-none');
                },
                success: function(response) {
                    if (response.csrf) { csrfHash = response.csrf; }
                    if (response.status) {
                        $('#ModalBotany').modal('hide');
                        Swal.fire({ icon: 'success', title: 'สำเร็จ!', text: response.message, timer: 2000, showConfirmButton: false })
                        .then(() => { window.location.reload(); });
                    } else {
                        Swal.fire({ icon: 'error', title: 'ไม่สำเร็จ', text: response.message });
                    }
                },
                error: function() {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'เกิดข้อผิดพลาดในการเชื่อมต่อ' });
                }
            });
        });

        $(document).on("click", "#AddBotany", function() {
            $('#ModalTitle').text('เพิ่มพรรณไม้ใหม่');
            $('#form-botany').attr('action', '<?=base_url('Admin/Botany/Add')?>').trigger('reset');
            $('#botany_id').val('');
            $('#original_botany_image').val('');
            initFilePond();
            new bootstrap.Modal(document.getElementById("ModalBotany")).show();
        });

        $(document).on("click", ".EditBotany", function() {
            $('#ModalTitle').text('แก้ไขข้อมูลพรรณไม้');
            $('#form-botany').attr('action', '<?=base_url('Admin/Botany/Update')?>');
            let botanyId = $(this).attr('key-botanyid');
            let postData = getCsrfData();
            postData['KeyBotanyid'] = botanyId;

            $.post('<?=base_url('Admin/Botany/Edit')?>', postData, function(data) {
                if(data) {
                    $('#botany_id').val(data.botany_id);
                    $('#botany_name_th').val(data.botany_name_th);
                    $('#botany_name_en').val(data.botany_name_en);
                    $('#botany_science_name').val(data.botany_science_name);
                    $('#botany_family').val(data.botany_family);
                    $('#botany_type').val(data.botany_type);
                    $('#botany_location').val(data.botany_location);
                    $('#botany_description').val(data.botany_description);
                    $('#botany_benefit').val(data.botany_benefit);
                    $('#original_botany_image').val(data.botany_image);
                    
                    initFilePond(data.botany_image);
                    new bootstrap.Modal(document.getElementById("ModalBotany")).show();
                }
            }, 'json');
        });

        $(document).on("change", ".form-check-input-toggle", function() {
            const status = $(this).is(":checked") ? "active" : "inactive";
            const key = $(this).attr('status-key');
            let postData = getCsrfData();
            postData['Onoffstatus'] = status;
            postData['Keystatus'] = key;

            $.post("<?=base_url('Admin/Botany/BotanyOnoff')?>", postData, function() {
                Swal.fire({ position: 'top-end', icon: 'success', title: 'อัปเดตสถานะแล้ว', showConfirmButton: false, timer: 1500 });
            });
        });

        $(document).on("click", ".DeleteBotany", function() {
            let botanyId = $(this).attr('key-botanyid');
            Swal.fire({
                title: 'ยืนยันการลบ?',
                text: "ข้อมูลนี้จะถูกลบออกจากระบบอย่างถาวร!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff3e1d',
                confirmButtonText: 'ลบข้อมูล'
            }).then((result) => {
                if (result.isConfirmed) {
                    let postData = getCsrfData();
                    postData['KeyBotanyid'] = botanyId;
                    $.post('<?=base_url('Admin/Botany/Delete')?>', postData, function(data) {
                        if (data == 1) {
                            $(`#row-${botanyId}`).fadeOut(function() { $(this).remove(); });
                            Swal.fire({ icon: 'success', title: 'ลบสำเร็จ!', timer: 1500, showConfirmButton: false });
                        }
                    });
                }
            });
        });

        function initFilePond(imgName = null) {
            const inputElement = document.querySelector('#botany_image');
            if (pond) { pond.destroy(); }
            let options = {
                labelIdle: 'ลากไฟล์มาวาง หรือ <span class="filepond--label-action">คลิกเพื่ออัปโหลด</span>',
                imagePreviewHeight: 250,
                acceptedFileTypes: ['image/*'],
                credits: false
            };
            if (imgName && imgName != '') {
                options.files = [{ source: `${BASE_URL}/uploads/botany/${imgName}` }];
            }
            pond = FilePond.create(inputElement, options);
        }
    });
</script>

<style>
    .switch-toggle { position: relative; display: inline-block; width: 65px; height: 32px; margin: 0; }
    .switch-toggle input { opacity: 0; width: 0; height: 0; }
    .slider-toggle { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ff3e1d; transition: .4s; border-radius: 34px; }
    .slider-toggle:before { position: absolute; content: ""; height: 24px; width: 24px; left: 4px; bottom: 4px; background-color: white; transition: .4s; border-radius: 50%; z-index: 2; }
    .switch-toggle input:checked + .slider-toggle { background-color: #71dd37; }
    .switch-toggle input:checked + .slider-toggle:before { transform: translateX(33px); }
    .slider-toggle .label-on, .slider-toggle .label-off { position: absolute; top: 50%; transform: translateY(-50%); color: white; font-size: 11px; font-weight: bold; z-index: 1; transition: opacity 0.3s; }
    .slider-toggle .label-on { left: 8px; opacity: 0; }
    .slider-toggle .label-off { right: 10px; opacity: 1; }
    .switch-toggle input:checked + .slider-toggle .label-on { opacity: 1; }
    .switch-toggle input:checked + .slider-toggle .label-off { opacity: 0; }
</style>
<?= $this->endSection() ?>
