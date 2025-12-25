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
        <button class="btn btn-primary" id="AddBanner">
            <i class="bx bx-plus me-1"></i> เพิ่มแบนเนอร์ใหม่
        </button>
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
                            <th width="40%">ข้อมูลแบนเนอร์</th>
                            <th width="30%">ตัวอย่างภาพ</th>
                            <th width="10%">วันที่ลง</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php foreach ($banner as $v_banner) : ?>
                        <tr id="<?= $v_banner->banner_id ?>">
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
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
                                <div class="form-check form-switch custom-switch">
                                    <input class="form-check-input" type="checkbox" status-key="<?= $v_banner->banner_id ?>" 
                                        <?= $v_banner->banner_status == "on" ? "checked" : "" ?>>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-dark text-truncate" style="max-width: 250px;" title="<?= $v_banner->banner_name ?>">
                                        <?= $v_banner->banner_name ?>
                                    </span>
                                    <?php if ($v_banner->banner_linkweb): ?>
                                        <small class="text-primary text-truncate" style="max-width: 250px;" title="<?= $v_banner->banner_linkweb ?>">
                                            <i class="bx bx-link me-1"></i><?= $v_banner->banner_linkweb ?>
                                        </small>
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
                                        $imageUrl = 'https://via.placeholder.com/600x200.png?text=Image+Not+Found';
                                    }
                                ?>
                                <div class="banner-preview rounded border overflow-hidden shadow-sm" style="max-width: 250px;">
                                    <img src="<?= $imageUrl ?>" class="img-fluid" alt="<?= $v_banner->banner_name ?>">
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-label-secondary"><?= date('Y/m/d', strtotime($v_banner->banner_date)) ?></span>
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
                <input type="hidden" name="original_banner_img" id="original_banner_img">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="banner_name" id="banner_name" placeholder="ใส่หัวข้อแบนเนอร์..." required>
                                <label for="banner_name">หัวข้อแบนเนอร์</label>
                            </div>
                        </div>
                        <div class="col-md-12 mb-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="banner_linkweb" id="banner_linkweb" placeholder="Ex. https://google.com">
                                <label for="banner_linkweb">ลิงก์ตัวช่วยเชื่อมโยง (Link URL)</label>
                            </div>
                        </div>
                        <div class="col-md-12 mb-4">
                            <div class="form-floating form-floating-outline">
                                <input class="form-control" type="datetime-local" value="<?= date('Y-m-d H:i') ?>" id="banner_date" name="banner_date" required>
                                <label for="banner_date">วันที่ประกาศใช้งาน</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label text-uppercase fw-bold small text-muted mb-2">รูปภาพแบนเนอร์ (ขนาดแนะนำ 1920x720 px)</label>
                            <input type="file" name="banner_img" id="banner_img">
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
    let pond;
    const BASE_URL = "<?= base_url() ?>";

    $(document).ready(function() {
        const dataTable = $('#myTable').DataTable({
            order: [[4, 'desc']],
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
            const isUpdate = $(this).attr('action').includes('Updatebanner');

            if (pondFile) {
                formData.append('banner_img', pondFile.file);
            }

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

                        if (isUpdate) {
                            // Update the row dynamically without reload
                            const bannerId = $('#banner_id').val();
                            const row = $(`#${bannerId}`);
                            const data = response.data;
                            
                            // Update Name and Link
                            row.find('td:nth-child(3) .fw-bold').text(data.banner_name);
                            if (data.banner_linkweb) {
                                row.find('td:nth-child(3) small').html(`<i class="bx bx-link me-1"></i>${data.banner_linkweb}`).removeClass('text-muted').addClass('text-primary');
                            } else {
                                row.find('td:nth-child(3) small').html(`<i class="bx bx-link-external me-1"></i>ไม่มีลิงก์เชื่อมโยง`).removeClass('text-primary').addClass('text-muted');
                            }

                            // Update Image Preview
                            if (data.banner_img) {
                                row.find('.banner-preview img').attr('src', `${BASE_URL}/uploads/banner/all/${data.banner_img}`);
                            }
                        } else {
                            // For Add, reload is safest to get the new row with all buttons/logic, 
                            // OR we could stay here. Let's JUST stay here if they really want no refresh.
                            // But usually Add requires a reload to see the new item in correct sort order.
                            // If the user insists on NO REFRESH EVER:
                            window.location.reload(); 
                        }
                    } else {
                        Swal.fire({ icon: 'error', title: 'ไม่สำเร็จ', text: response.message });
                    }
                }
            });
        });

        $(document).on("click", "#AddBanner", function() {
            $('#ModalTitle').text('เพิ่มแบนเนอร์ใหม่');
            $('#form-banner').attr('action', '<?=base_url('Admin/Banner/Addbanner')?>').trigger('reset');
            initFilePond();
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
                    
                    let date = new Date(data.banner_date);
                    let formattedDate = date.getFullYear() + '-' + 
                                    ('0' + (date.getMonth() + 1)).slice(-2) + '-' + 
                                    ('0' + date.getDate()).slice(-2) + 'T' + 
                                    ('0' + date.getHours()).slice(-2) + ':' + 
                                    ('0' + date.getMinutes()).slice(-2);
                    $('#banner_date').val(formattedDate);

                    initFilePond(data.banner_img);
                    new bootstrap.Modal(document.getElementById("ModalAddBanner")).show();
                }
            }, 'json');
        });

        $(document).on("change", ".form-check-input", function() {
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
            $('#form-banner').trigger('reset');
        });

        function initFilePond(imgName = null) {
            const inputElement = document.querySelector('#banner_img');
            if (pond) { pond.destroy(); }
            
            let options = {
                labelIdle: 'ลากไฟล์มาวาง หรือ <span class="filepond--label-action">คลิกเพื่ออัปโหลด</span>',
                imagePreviewHeight: 200,
                acceptedFileTypes: ['image/*'],
                credits: false
            };

            if (imgName) {
                options.files = [{ source: `${BASE_URL}/uploads/banner/all/${imgName}` }];
            }

            pond = FilePond.create(inputElement, options);
        }
    });
</script>

<style>
    .card { border-radius: 0.75rem; }
    .table thead th { font-weight: 600; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; }
    .custom-switch .form-check-input { width: 3rem; height: 1.5rem; cursor: pointer; }
    .banner-preview { transition: transform 0.2s; cursor: pointer; }
    .banner-preview:hover { transform: scale(1.05); }
    .dataTables_wrapper .dataTables_filter input { border: 1px solid #d9dee3; border-radius: 0.375rem; padding: 0.422rem 0.875rem; }
    .dataTables_wrapper .dataTables_paginate .paginate_button { padding: 0.3rem 0.5rem; }
</style>
<?= $this->endSection() ?>
