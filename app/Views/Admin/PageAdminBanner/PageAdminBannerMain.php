<?= $this->extend('Admin/layout/AdminLayout') ?>

<?= $this->section('content') ?>
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
                <!-- Content -->
                <style>
                table td {
                    word-break: break-word;
                    vertical-align: top;
                    white-space: normal !important;
                }

                table.dataTable .form-check-input {
                    width: 30px;
                    height: 18px;
                }
                .filepond--root {
                    margin-bottom: 0;
                }
                </style>
                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="row">
                        <div class="col-lg-12 mb-4 order-0">
                            <div class="card p-3">
                                <div class="d-flex justify-content-between align-content-center">
                                    <h5 class="">ตารางแบนเนอร์ประชาสัมพันธ์</h5>
                                    <button class="btn btn-primary" id="AddBanner">+ เพิ่มแบนเนอร์</button>
                                </div>

                                <div class="table-responsive text-nowrap">
                                    <table
                                        class="datatables-basic table border-top dataTable no-footer dtr-column collapsed"
                                        id="myTable">
                                        <thead>
                                            <tr>
                                                <th>คำสั่ง</th>
                                                <th>แสดงหน้าเว็บ</th>
                                                <th>หัวข้อ</th>
                                                <th>ตัวอย่าง</th>
                                                <th>วันที่สร้าง</th>

                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            <?php foreach ($banner as $key => $v_banner) : ?>
                                            <tr id="<?=$v_banner->banner_id?>">
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                            data-bs-toggle="dropdown">
                                                            <i class="bx bx-dots-vertical-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item Editbanner"
                                                                href="javascript:void(0);"
                                                                key-bannerid="<?=$v_banner->banner_id?>"><i
                                                                    class="bx bx-edit-alt me-1"></i> Edit</a>
                                                            <a class="dropdown-item Deletebanner"
                                                                href="javascript:void(0);"
                                                                key-bannerid="<?=$v_banner->banner_id?>"><i
                                                                    class="bx bx-trash me-1"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>                                                   
                                                    <div class="form-check form-switch mb-2">
                                                        <input class="form-check-input" type="checkbox" status-key="<?=$v_banner->banner_id?>"
                                                            id="flexSwitchCheckChecked" <?=$v_banner->banner_status == "on"?"checked":""?> >  
                                                    </div>
                                                </td>
                                                <td>
                                                    <strong><?=$v_banner->banner_name?></strong>
                                                </td>
                                                <td>
                                                    <?php
                                                        $imageUrl = base_url('uploads/banner/all/'.$v_banner->banner_img);
                                                        $imagePath = FCPATH . 'uploads/banner/all/' . $v_banner->banner_img;
                                                        if (empty($v_banner->banner_img) || !file_exists($imagePath)) {
                                                            $imageUrl = 'https://via.placeholder.com/300x120.png?text=Image+Not+Found';
                                                        }
                                                    ?>
                                                    <img src="<?= $imageUrl ?>" class="img-fluid" alt="<?=$v_banner->banner_name?>">
                                                </td>
                                                <td><?=$v_banner->banner_date?></td>

                                            </tr>
                                            <?php endforeach; ?>



                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>




                </div>
                <!-- / Content -->
<?= $this->endSection() ?>

<?= $this->section('modals') ?>

<!-- Modal เพิ่มแบนเนอร์ -->
<div class="modal fade" id="ModalAddBanner" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-99"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-banner" method="post"
                enctype="multipart/form-data" class="needs-validation" novalidate>
                <input type="hidden" name="banner_id" id="banner_id">
                <input type="hidden" name="original_banner_img" id="original_banner_img">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="banner_name" class="form-label">หัวห้อแบนเนอร์</label>
                        <input type="text" class="form-control mb-3" name="banner_name" id="banner_name"
                            placeholder="ใส่หัวข้อแบนเนอร์..." aria-describedby="floatingInputHelp" required>
                        <div class="invalid-feedback">
                            ใส่หัวข้อแบนเนอร์
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="banner_linkweb" class="form-label">ลิ้งก์เชื่อมโยงแบนเนอร์</label>
                        <input type="text" class="form-control mb-3" name="banner_linkweb" id="banner_linkweb"
                            placeholder="ใส่ลิ้งก์เชื่อมโยงแบนเนอร์ Ex.https://academic.skj.ac.th/LearningOnline" >
                        <div class="invalid-feedback">
                            ลิ้งก์เชื่อมโยง
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="banner_date" class="form-label">วันที่ลง</label>
                        <input class="form-control" type="datetime-local" value="<?=date('Y-m-d H:i:s')?>"
                            id="banner_date" name="banner_date" required>
                        <div class="invalid-feedback">
                            เลือกวันที่ลง
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="banner_img" class="form-label">รูปภาหน้าปก</label>
                         <input type="file" name="banner_img" id="banner_img">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="submitBannerBtn">บันทึก</button>
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
    // Register the FilePond plugin
    FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginFileValidateType);

    let pond; // To hold the FilePond instance
    const BASE_URL = "<?= base_url() ?>";

    // All page-specific JS is now inlined
    $('#myTable').DataTable({
        "columnDefs": [{
            "width": "20%",
            "targets": 0
        }],
        order: [
            [3, 'desc']
        ],
        autoWidth: false,
        columns: [
            { width: '5px' },
            { width: '5px' },
            { width: '200px' },
            { width: '300px' },
            { width: '50px' }
        ]
    });

    $('#form-banner').on('submit', function(e) {
        e.preventDefault();
        
        if (!$('#banner_name').val().trim() || !$('#banner_date').val().trim()) {
            Swal.fire({ icon: 'error', title: 'ผิดพลาด', text: 'กรุณากรอกข้อมูลให้ครบถ้วน' });
            return;
        }

        const formData = new FormData(this);
        const pondFile = pond ? pond.getFile() : null;
        const isUpdate = $(this).attr('action').includes('Updatebanner');

        if (pondFile) {
            formData.append('banner_img', pondFile.file);
        }

        // For updates, we need to pass the banner_id
        if (isUpdate) {
             formData.append('banner_id', $('#banner_id').val());
        }


        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    $('#ModalAddBanner').modal('hide');
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'บันทึกไม่สำเร็จ', text: response.message || 'กรุณาลองใหม่อีกครั้ง' });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire({ icon: 'error', title: 'เกิดข้อผิดพลาด', text: 'AJAX request failed: ' + textStatus });
            }
        });
    });

    // Add Banner button click
    $(document).on("click", "#AddBanner", function() {
        $('#ModalTitle').text('เพิ่มแบนเนอร์');
        $('#form-banner').attr('action', '<?=base_url('Admin/Banner/Addbanner')?>').trigger('reset');
        
        const inputElement = document.querySelector('#banner_img');
        pond = FilePond.create(inputElement, {
            labelIdle: `ลากและวางไฟล์ หรือ <span class="filepond--label-action">เลือกไฟล์</span>`,
            imagePreviewHeight: 200,
            acceptedFileTypes: ['image/*'],
            credits: false
        });
        
        var myModal = new bootstrap.Modal(document.getElementById("ModalAddBanner"), {});
        myModal.show();
    });

    // Edit Banner button click
    $(document).on("click", ".Editbanner", function() {
        $('#ModalTitle').text('แก้ไขแบนเนอร์');
        $('#form-banner').attr('action', '<?=base_url('Admin/Banner/Updatebanner')?>');
        
        let bannerId = $(this).attr('key-bannerid');
        const inputElement = document.querySelector('#banner_img');

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

                let filePondOptions = {
                    labelIdle: 'ลากไฟล์มาเพื่อเปลี่ยน หรือ <span class="filepond--label-action">คลิกเพื่อเปลี่ยนรูปภาพ</span>',
                    imagePreviewHeight: 200,
                    acceptedFileTypes: ['image/*'],
                    credits: false
                };

                if (data.banner_img) {
                    filePondOptions.files = [{
                        source: `${BASE_URL}/uploads/banner/all/${data.banner_img}`,
                    }];
                }

                pond = FilePond.create(inputElement, filePondOptions);

                var myModal = new bootstrap.Modal(document.getElementById("ModalAddBanner"), {});
                myModal.show();
            } else {
                Swal.fire({ icon: 'error', title: 'เกิดข้อผิดพลาด', text: 'ไม่พบข้อมูลแบนเนอร์' });
            }
        }, 'json').fail(function(jqXHR, textStatus, errorThrown) {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด (' + jqXHR.status + ')',
                text: 'ไม่สามารถดึงข้อมูลแบนเนอร์ได้: ' + textStatus + '. ' + errorThrown,
            });
        });
    });

    $(document).on("click", 'input[type="checkbox"]', function() {
        var status;
        if ($(this).is(":checked")) {
            status = "on";
        } else if ($(this).is(":not(:checked)")) {
            status = "off";
        }

        $.ajax({
            type: "POST",
            url: "<?=base_url('Admin/Banner/BannerOnoff')?>",
            data: {
                Onoffstatus: status,
                Keystatus: $(this).attr('status-key')
            },
            success: function(msg) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'เปลี่ยนแปลงข้อมูลเรียบร้อย',
                    showConfirmButton: false,
                    timer: 1500
                })
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert(XMLHttpRequest.responseText);
            }
        });

    });

    $(document).on("click", ".Deletebanner", function() {
        let bannerID = $(this).attr('key-bannerid');
        Swal.fire({
            title: 'คุณต้องการลบข้อมูลหรือไม่?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ลบเลย!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('<?=base_url('Admin/Banner/DeleteBanner')?>', {
                        KeyBannerid: bannerID
                    },
                    function(data) {
                        $('#myTable tr#' + bannerID).remove();
                        if (data == 1) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'ลบรูปภาพสำเร็จ',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    }
                );

            }
        })
    });

    // When modal is hidden, clear the filepond input and form
    $('#ModalAddBanner').on('hidden.bs.modal', function () {
        if (pond) {
            pond.destroy();
            pond = null;
        }
        $('#form-banner').trigger('reset');
    });
</script>
<?= $this->endSection() ?>
