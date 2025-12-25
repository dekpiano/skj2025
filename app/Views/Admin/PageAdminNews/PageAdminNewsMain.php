<?= $this->extend('Admin/layout/AdminLayout') ?>

<?= $this->section('content') ?>
                <!-- Content -->
                <style>
                table td {
                    word-break: break-word;
                    vertical-align: top;
                    white-space: normal !important;
                }
                </style>
                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="row">
                        <div class="col-lg-12 mb-4 order-0">
                            <div class="card p-3">
                                <div class="d-flex justify-content-between align-content-center">
                                    <h5 class="">ตารางข่าวประชาสัมพันธ์</h5>
                                    <div>
                                        <button class="btn btn-primary" id="AddNews">+ เพิ่มข่าวด้วยตนเอง</button>
                                        <button class="btn btn-primary" id="AddFacebook">+ เพิ่มข่าวจาก
                                            Facebook</button>
                                    </div>

                                </div>

                                <div class="table-responsive text-nowrap">
                                    <table
                                        class="datatables-basic table border-top dataTable no-footer dtr-column collapsed"
                                        id="myTable">
                                        <colgroup>
                                            <col style="width: 50%;"> <!-- หัวข้อ -->
                                            <col style="width: 20%;"> <!-- ประเภทข่าว -->
                                            <col style="width: 20%;"> <!-- วันที่สร้าง -->
                                            <col style="width: 10%;"> <!-- คำสั่ง -->
                                        </colgroup>
                                        <thead>
                                            <tr>
                                                <th>หัวข้อ</th>
                                                <th>ประเภทข่าว</th>
                                                <th>วันที่สร้าง</th>
                                                <th>คำสั่ง</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            <?php foreach ($news as $key => $v_news) : ?>
                                            <tr id="<?=$v_news->news_id?>">
                                                <td>
                                                    <strong><?=$v_news->news_topic?></strong>
                                                </td>
                                                <td><?=$v_news->news_category?></td>
                                                <td><?=$v_news->news_date?></td>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="คำสั่ง">
                                                        <a class="btn btn-outline-primary btn-sm EditNews" href="javascript:void(0);"
                                                            key-newsid="<?=$v_news->news_id?>" title="แก้ไข">
                                                            <i class="bx bx-edit-alt"></i>
                                                        </a>
                                                        <a class="btn btn-outline-danger btn-sm DeleteNews" href="javascript:void(0);"
                                                            key-newsid="<?=$v_news->news_id?>" title="ลบ">
                                                            <i class="bx bx-trash"></i>
                                                        </a>
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




                </div>
                <!-- / Content -->
<?= $this->endSection() ?>

<?= $this->section('modals') ?>

<!-- Modal เพิ่มข่าว -->
<div class="modal fade" id="ModalAddNews" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-99"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">เพิ่มข่าว</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-news" method="post" action="<?=base_url('Admin/News/AddNews')?>"
                enctype="multipart/form-data" class="needs-validation" novalidate>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="news_topic" class="form-label">หัวข้อข่าว</label>
                                <input type="text" class="form-control" name="news_topic" id="news_topic"
                                    placeholder="ใส่หัวข้อข่าว..." required>
                                <div class="invalid-feedback">
                                    กรุณาใส่หัวข้อข่าว
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="news_content_editor" class="form-label">เนื้อหาข่าว</label>
                                <div id="news_content_editor" style="height: 300px;"></div>
                                <input type="hidden" name="news_content" id="news_content">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="news_category" class="form-label">ประเภทข่าว</label>
                                <select class="form-select" name="news_category" id="news_category" required>
                                    <option selected disabled value="">เลือกประเภทข่าว...</option>
                                    <option value="ข่าวประชาสัมพันธ์">ข่าวประชาสัมพันธ์</option>
                                    <option value="ข่าวกิจกรรม">ข่าวกิจกรรม</option>
                                    <option value="ข่าวรางวัล">ข่าวรางวัล</option>
                                </select>
                                <div class="invalid-feedback">
                                    กรุณาเลือกประเภทข่าว
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="news_date" class="form-label">วันที่ลง</label>
                                <input class="form-control" type="datetime-local"
                                    value="<?=date('Y-m-d H:i:s')?>" id="news_date" name="news_date" required>
                                <div class="invalid-feedback">
                                    กรุณาเลือกวันที่ลง
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="news_img" class="form-label">รูปภาพหน้าปก</label>
                                <input type="file" name="news_img" id="news_img">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary" id="submitAddNewsBtn">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        <span class="btn-text">บันทึก</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal แก้ไขข่าว -->
<div class="modal fade" id="ModalEditNews" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-99"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">แก้ไขข่าว</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-update-news" method="post" action="<?=base_url('Admin/News/UpdateNews')?>"
                enctype="multipart/form-data" class="needs-validation" novalidate>
                <input type="hidden" name="edit_news_id" id="edit_news_id">
                <input type="hidden" name="original_news_img" id="original_news_img">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="edit_news_topic" class="form-label">หัวข้อข่าว</label>
                                <input type="text" class="form-control" name="edit_news_topic" id="edit_news_topic"
                                    placeholder="ใส่หัวข้อข่าว..." required>
                                <div class="invalid-feedback">
                                    กรุณาใส่หัวข้อข่าว
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="edit_news_content_editor" class="form-label">เนื้อหาข่าว</label>
                                <div id="edit_news_content_editor" style="height: 300px;"></div>
                                <input type="hidden" name="edit_news_content" id="edit_news_content">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="edit_news_category" class="form-label">ประเภทข่าว</label>
                                <select class="form-select" name="edit_news_category" id="edit_news_category" required>
                                    <option selected disabled value="">เลือกประเภทข่าว...</option>
                                    <option value="ข่าวประชาสัมพันธ์">ข่าวประชาสัมพันธ์</option>
                                    <option value="ข่าวกิจกรรม">ข่าวกิจกรรม</option>
                                    <option value="ข่าวรางวัล">ข่าวรางวัล</option>
                                </select>
                                <div class="invalid-feedback">
                                    กรุณาเลือกประเภทข่าว
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="edit_news_date" class="form-label">วันที่ลง</label>
                                <input class="form-control" type="datetime-local" id="edit_news_date" name="edit_news_date" required>
                                <div class="invalid-feedback">
                                    กรุณาเลือกวันที่ลง
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="edit_news_img" class="form-label">รูปภาพหน้าปก</label>
                                <input type="file" name="edit_news_img" id="edit_news_img">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary" id="submitEditNewsBtn">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        <span class="btn-text">บันทึกการเปลี่ยนแปลง</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal เพิ่มข่าว -->
<div class="modal fade" id="ModalAddNewsFromFacebook" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-99"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">เพิ่มข่าวจาก Facebook</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="form-news-feacbook" method="post" action="<?=base_url('Admin/News/Add/NewsFeacbook')?>"
                enctype="multipart/form-data" class="needs-validation" novalidate>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="news_topic" class="form-label">เลือกข่าวจาก Facebook</label>
                        <select class="form-select form-select" name="sel_NewsFromFacebook" id="sel_NewsFromFacebook">
                            <option value="">กรุณาเลือกข่าว</option>
                        </select>
                    </div>
                    <hr>

                    <div class="mb-3">
                        <label for="news_topic" class="form-label">หัวห้อข่าว</label>
                        <input type="text" class="form-control mb-3" name="news_topic_facebook" id="news_topic_facebook"
                            placeholder="ใส่หัวข้อข่าว..." aria-describedby="floatingInputHelp" required>
                        <div class="invalid-feedback">
                            ใส่หัวข้อข่าว
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="news_category" class="form-label">ประเภทข่าว</label>
                        <select id="largeSelect" class="form-select form-select" name="news_category_facebook"
                            id="news_category_facebook" required>
                            <option value="ข่าวประชาสัมพันธ์">ข่าวประชาสัมพันธ์</option>
                            <option value="ข่าวกิจกรรม">ข่าวกิจกรรม</option>
                            <option value="ข่าวรางวัล">ข่าวรางวัล</option>
                        </select>
                        <div class="invalid-feedback">
                            เลือกประเภทข่าว
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">วันที่ลง</label>
                        <input class="form-control" type="datetime-local" value="" id="news_date_facebook"
                            name="news_date_facebook">
                        <div class="invalid-feedback">
                            เลือกวันที่ลง
                        </div>
                    </div>

                    <!-- Create the editor container -->
                    <div id="editor_facebook" class="mb-3">
                        <p>ใส่เนื้อหาข่าวที่นี่....</p>
                    </div>
                    <div class="mb-3">
                        <label for="news_img" class="form-label">รูปภาหน้าปก</label>

                        <img src="" alt="" id="blah_facebook" class="img-fluid">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn-submit-news-facebook">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        <span class="btn-text">บันทึก</span>
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    // Register the FilePond plugin
    FilePond.registerPlugin(FilePondPluginImagePreview);
</script>
<script src="https://unpkg.com/quill-image-resize-module@3.0.0/image-resize.min.js"></script>
<script>
    Quill.register('modules/imageResize', ImageResize.default);
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
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
            { width: '300px' },
            { width: '50px' },
            { width: '50px' }
        ]
    });
    let editPond;
    let addPond; // Declare addPond here

    $(document).on("click", "#AddNews", function() {
        var myModal = new bootstrap.Modal(document.getElementById("ModalAddNews"), {});
        myModal.show();

        // Initialize FilePond for add form
        const addInputElement = document.querySelector('input[name="news_img"]');
        addPond = FilePond.create(addInputElement, {
            labelIdle: `ลากและวางไฟล์ หรือ <span class="filepond--label-action">เลือกไฟล์</span>`,
            imagePreviewHeight: 170,
        });
    });

    // Destroy FilePond instance when Add modal is hidden
    $('#ModalAddNews').on('hidden.bs.modal', function () {
        if (addPond) {
            addPond.destroy();
            addPond = null;
        }
    });

    $(document).on("submit", "#form-news", function(e) {
        e.preventDefault();

        const form = $(this);
        const submitBtn = $('#submitAddNewsBtn');
        const spinner = submitBtn.find('.spinner-border');
        const btnText = submitBtn.find('.btn-text');

        // Show spinner and disable button
        spinner.removeClass('d-none');
        btnText.text('กำลังบันทึก...');
        submitBtn.prop('disabled', true);

        // Get the first file from FilePond (using addPond for the add form)
        const file = addPond.getFile();

        const formData = new FormData(this);
        formData.append("news_content", quill.root.innerHTML);

        // Add the file to the form data if it exists
        if (file) {
            formData.append('news_img', file.file);
        }

        $.ajax({
            url: form.attr('action'),
            type: "post",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            async: true, // Changed to async: true for better UX with spinner
            success: function(data) {
                // Hide spinner and enable button
                spinner.addClass('d-none');
                btnText.text('บันทึก');
                submitBtn.prop('disabled', false);

                $('#ModalAddNews').modal('hide');
                if (data == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'บันทึกข้อมูลสำเร็จ',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire(
                        'แจ้งเตือน!',
                        data + '!',
                        'error'
                    );
                }
            },
            error: function(xhr, status, error) {
                // Hide spinner and enable button
                spinner.addClass('d-none');
                btnText.text('บันทึก');
                submitBtn.prop('disabled', false);

                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด!',
                    text: 'ไม่สามารถบันทึกข้อมูลได้: ' + error,
                });
            }
        });
    });

    $(document).on("click", ".EditNews", function() {
        var myModal = new bootstrap.Modal(document.getElementById("ModalEditNews"), {});
        myModal.show();

        const editInputElement = document.querySelector('#edit_news_img');

        $.post("../Admin/News/EditNews", {
            KeyNewsid: $(this).attr('key-newsid')
        }, function(data, status) {
            const news = data[0];
            
            // Populate form fields
            $('#edit_news_id').val(news.news_id);
            $('#edit_news_topic').val(news.news_topic);
            $('#edit_news_date').val(news.news_date.slice(0, 16)); // Format for datetime-local
            $('#edit_news_category').val(news.news_category);
            $('#original_news_img').val(news.news_img);

            // Set content for Quill editor
            const delta = Editquill.clipboard.convert(news.news_content);
            Editquill.setContents(delta, 'silent');

            // Initialize FilePond with the existing image
            let filePondOptions = {
                labelIdle: `ลากไฟล์มาเพื่อเปลี่ยน หรือ <span class="filepond--label-action">คลิกเพื่อเปลี่ยนรูปภาพ</span>`,
                imagePreviewHeight: 170,
            };

            if (news.news_img) {
                filePondOptions.files = [{
                    source: `${BASE_URL}/uploads/news/${news.news_img}`,
                }];
            }

            editPond = FilePond.create(editInputElement, filePondOptions);

        }, 'json');
    });

    // Destroy FilePond instance when Edit modal is hidden
    $('#ModalEditNews').on('hidden.bs.modal', function () {
        if (editPond) {
            editPond.destroy();
            editPond = null;
        }
    });

    $(document).on("submit", "#form-update-news", function(e) {
        e.preventDefault();

        const form = $(this);
        const submitBtn = $('#submitEditNewsBtn');
        const spinner = submitBtn.find('.spinner-border');
        const btnText = submitBtn.find('.btn-text');

        // Show spinner and disable button
        spinner.removeClass('d-none');
        btnText.text('กำลังบันทึก...');
        submitBtn.prop('disabled', true);

        const formData = new FormData(this);
        formData.append("edit_news_content", Editquill.root.innerHTML);

        // Get file from FilePond instance for the edit form
        const file = editPond.getFile();
        if (file) {
            formData.append('edit_news_img', file.file);
        }

        $.ajax({
            url: form.attr('action'),
            type: "post",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            async: true, // Changed to async: true for better UX with spinner
            success: function(data) {
                // Hide spinner and enable button
                spinner.addClass('d-none');
                btnText.text('บันทึกการเปลี่ยนแปลง');
                submitBtn.prop('disabled', false);

                $('#ModalEditNews').modal('hide');
                if (data == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'บันทึกการเปลี่ยนแปลงสำเร็จ',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire(
                        'แจ้งเตือน!',
                        data + '!',
                        'error'
                    );
                }
            },
            error: function(xhr, status, error) {
                // Hide spinner and enable button
                spinner.addClass('d-none');
                btnText.text('บันทึกการเปลี่ยนแปลง');
                submitBtn.prop('disabled', false);

                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด!',
                    text: 'ไม่สามารถบันทึกข้อมูลได้: ' + error,
                });
            }
        });
    });

    $(document).on("click", ".DeleteNews", function() {
        let newsid = $(this).attr('key-newsid');
        Swal.fire({
            title: 'แจ้งเตือน?',
            text: "ต้องการลบข้อมูลข่าวหรือไม่!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("../Admin/News/DeleteNews", {
                    KeyNewsid: $(this).attr('key-newsid')
                }, function(data, status) {
                    console.log(data);
                    if (data == 1) {
                        $('#' + newsid).remove();
                    }
                });
            }
        })

    });

    $(document).on("click", "#AddFacebook", function() {
        var myModal = new bootstrap.Modal(document.getElementById("ModalAddNewsFromFacebook"), {});
        myModal.show();
        
        $.post('../Admin/News/View/Facebook',function(data){
            data = JSON.parse( data );

            $.each(data['data'], function (i, item) {
                if(item.message){
                    $('#sel_NewsFromFacebook').append($('<option>', { 
                        value: item.id,
                        text : item.message.substr(0, 50)
                    }));
                }
                
            });
                
        },'json');
    });

    $(document).on("change", "#sel_NewsFromFacebook", function() {

        $.post('../Admin/News/Select/Facebook',{KeyNewsFB:$(this).val()},function(data){
            data = JSON.parse( data );
            var formattedDateTime = convertISOToDateTimeInput(data.created_time);
            $('#news_topic_facebook').val(data.message.substr(0, 100));
            $('#news_date_facebook').val(formattedDateTime);
            $('#blah_facebook').attr('src',data.full_picture)
            const delta = quill.clipboard.convert(data.message);
            quillFacebook.setContents(delta, 'silent');

           // console.log(data);

        },'json');
    });

    $(document).on("submit", "#form-news-feacbook", function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append("news_content_facebook", quillFacebook.root.innerHTML);
        formData.append("news_img_facebook", $('#blah_facebook').attr('src'));

         // ปุ่ม submit
        const $btn = $('#btn-submit-news-facebook');
        $btn.prop('disabled', true);
        $btn.find('.spinner-border').removeClass('d-none');
        $btn.find('.btn-text').text('กำลังบันทึก...');

        $.ajax({
            url: $('#form-news-feacbook').attr('action'),
            type: "post",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            success: function(data) {
                console.log(data);
                $('#ModalAddNewsFromFacebook').hide();
                $('.modal-backdrop').remove();
                if (data) {
                    // คืนปุ่มเป็นปกติ
                $btn.prop('disabled', false);
                $btn.find('.spinner-border').addClass('d-none');
                $btn.find('.btn-text').text('บันทึก');

                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'บันทึกข้อมูลสำเร็จ',
                        showConfirmButton: false,
                        timer: 3000
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {
                            window.location.reload();
                        }
                    })
                } else {
                    Swal.fire(
                        'แจ้งเตือน!',
                        (data && data.message) ? data.message : 'บันทึกข้อมูลไม่สำเร็จ!',
                        'error'
                    );
                }
            },
            error: function (jqXHR, exception) {
                $btn.prop('disabled', false);
                $btn.find('.spinner-border').addClass('d-none');
                $btn.find('.btn-text').text('บันทึก');

                Swal.fire(
                    'เกิดข้อผิดพลาด!',
                    jqXHR.responseText || 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้',
                    'error'
                );
            }
        });
    });


    function convertISOToDateTimeInput(isoDate) {
        var date = new Date(isoDate);

        // ดึงค่า ปี, เดือน, วัน
        var year = date.getFullYear();
        var month = date.getMonth() + 1; // เดือนใน JavaScript เริ่มจาก 0
        var day = date.getDate();

        // ดึงค่า ชั่วโมง และ นาที
        var hours = date.getHours();
        var minutes = date.getMinutes();

        // ตรวจสอบให้เดือน, วัน, ชั่วโมง, นาทีมี 2 หลักเสมอ
        if (month < 10) month = '0' + month;
        if (day < 10) day = '0' + day;
        if (hours < 10) hours = '0' + hours;
        if (minutes < 10) minutes = '0' + minutes;

        // คืนค่าที่เป็น 'ปี-เดือน-วันTHH:MM'
        return year + '-' + month + '-' + day + 'T' + hours + ':' + minutes;
    }
</script>


<script>
    // This script block is now local to the News admin page.
    const uploadedImageUrls = new Map(); 

    function imageHandler() {
        const input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');
        input.click();

        input.onchange = () => {
            const file = input.files[0];
            if (/^image\//.test(file.type)) {
                const formData = new FormData();
                formData.append('image', file);

                const quillInstance = this.quill;

                fetch(`${BASE_URL}/Admin/News/uploadImage`, {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { 
                            throw new Error(err.error || `HTTP error! status: ${response.status}`);
                        });
                    }
                    return response.json();
                })
                .then(result => {
                    if (result.url) {
                        const range = quillInstance.getSelection();
                        quillInstance.insertEmbed(range.index, 'image', result.url);

                        if (!uploadedImageUrls.has(quillInstance)) {
                            uploadedImageUrls.set(quillInstance, new Set());
                        }
                        uploadedImageUrls.get(quillInstance).add(result.url);
                    } else if (result.error) {
                        throw new Error(result.error);
                    }
                })
                .catch(error => {
                    console.error('Error uploading image:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'อัปโหลดรูปภาพไม่สำเร็จ',
                        text: 'เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ: ' + error.message,
                    });
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'ไฟล์ไม่ถูกต้อง',
                    text: 'กรุณาเลือกไฟล์รูปภาพเท่านั้น',
                });
            }
        };
    }

    var toolbarOptions = [
        ['bold', 'italic', 'underline', 'strike'],
        ['blockquote', 'code-block'],
        [{'header': 1}, {'header': 2}],
        [{'list': 'ordered'}, {'list': 'bullet'}],
        [{'script': 'sub'}, {'script': 'super'}],
        [{'indent': '-1'}, {'indent': '+1'}],
        [{'direction': 'rtl'}],
        [{'size': ['small', false, 'large', 'huge']}],
        [{'header': [1, 2, 3, 4, 5, 6, false]}],
        [{'color': []}, {'background': []}],
        [{'font': []}],
        [{'align': []}],
        ['clean'],
        ['link', 'image']
    ];

    function addQuillDeleteListener(quillInstance) {
        quillInstance.on('text-change', (delta, oldDelta, source) => {
            if (source === 'user') {
                const currentContent = quillInstance.getContents();
                const currentImageUrls = new Set();
                currentContent.ops.forEach(op => {
                    if (op.insert && op.insert.image) {
                        currentImageUrls.add(op.insert.image);
                    }
                });

                const uploadedUrlsForThisQuill = uploadedImageUrls.get(quillInstance) || new Set();

                uploadedUrlsForThisQuill.forEach(url => {
                    if (!currentImageUrls.has(url)) {
                        console.log('Image deleted from editor:', url);
                        fetch(`${BASE_URL}/Admin/News/deleteImage`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ imageUrl: url }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                console.log('Image deleted from server:', url);
                                uploadedUrlsForThisQuill.delete(url);
                            } else {
                                console.error('Failed to delete image from server:', data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error deleting image from server:', error);
                        });
                    }
                });
            }
        });
    }

    function handleImageClick(event) {
        const img = event.target;
        const quill = Quill.find(img); 

        if (quill && img.tagName === 'IMG' && img.classList.contains('ql-image')) {
            // Deselect any other selected image
            const currentlySelected = document.querySelector('.ql-image-selected');
            if (currentlySelected) {
                currentlySelected.classList.remove('ql-image-selected');
            }
            // Select the clicked image
            img.classList.add('ql-image-selected');

            // --- Delete Button ---
            let deleteButton = document.querySelector('.ql-image-delete-button');
            if (!deleteButton) {
                deleteButton = document.createElement('button');
                deleteButton.className = 'ql-image-delete-button';
                deleteButton.innerHTML = '&#128465;'; // Trash can icon
                Object.assign(deleteButton.style, {
                    position: 'absolute',
                    background: '#d9534f',
                    color: 'white',
                    border: 'none', borderRadius: '50%',
                    width: '24px', height: '24px',
                    cursor: 'pointer', zIndex: '1001',
                    display: 'none', lineHeight: '24px', textAlign: 'center'
                });
                document.body.appendChild(deleteButton);

                deleteButton.onclick = () => {
                    const imageToDelete = document.querySelector('.ql-image-selected');
                    if (imageToDelete) {
                        const blot = Quill.find(imageToDelete);
                        if (blot) {
                            const index = quill.getIndex(blot);
                            quill.deleteText(index, 1);
                        }
                    }
                    deleteButton.style.display = 'none';
                    document.querySelector('.ql-image-rotate-button').style.display = 'none';
                };
            }

            // --- Rotate Button ---
            let rotateButton = document.querySelector('.ql-image-rotate-button');
            if (!rotateButton) {
                rotateButton = document.createElement('button');
                rotateButton.className = 'ql-image-rotate-button';
                rotateButton.innerHTML = '&#8635;'; // Rotate icon
                Object.assign(rotateButton.style, {
                    position: 'absolute',
                    background: '#5bc0de',
                    color: 'white',
                    border: 'none', borderRadius: '50%',
                    width: '24px', height: '24px',
                    cursor: 'pointer', zIndex: '1001',
                    display: 'none', lineHeight: '24px', textAlign: 'center', fontWeight: 'bold'
                });
                document.body.appendChild(rotateButton);

                rotateButton.onclick = () => {
                    const imageToRotate = document.querySelector('.ql-image-selected');
                    if (imageToRotate) {
                        let currentRotation = imageToRotate.style.transform.match(/rotate\((\d+)deg\)/);
                        currentRotation = currentRotation ? parseInt(currentRotation[1], 10) : 0;
                        const newRotation = (currentRotation + 90) % 360;
                        imageToRotate.style.transform = `rotate(${newRotation}deg)`;
                    }
                };
            }

            // Position and show buttons
            const imgRect = img.getBoundingClientRect();
            deleteButton.style.top = `${imgRect.top + window.scrollY}px`;
            deleteButton.style.left = `${imgRect.right + window.scrollX - 24}px`;
            deleteButton.style.display = 'block';

            rotateButton.style.top = `${imgRect.top + window.scrollY}px`;
            rotateButton.style.left = `${imgRect.right + window.scrollX - 52}px`;
            rotateButton.style.display = 'block';

            // Hide buttons when clicking elsewhere
            document.addEventListener('click', (e) => {
                if (e.target !== img && e.target !== deleteButton && e.target !== rotateButton) {
                    deleteButton.style.display = 'none';
                    rotateButton.style.display = 'none';
                    img.classList.remove('ql-image-selected');
                }
            }, { once: true });
        }
    }
</script>

<script>
    // โค้ด Quill instance สำหรับ news_content_editor
    if (document.getElementById('news_content_editor') && !Quill.find(document.getElementById('news_content_editor'))) {
        window.quill = new Quill('#news_content_editor', {
            modules: {
                toolbar: {
                    container: toolbarOptions,
                    handlers: {
                        'image': imageHandler
                    }
                },
                imageResize: {
                    modules: [ 'Resize', 'DisplaySize', 'Toolbar' ]
                }
            },
            theme: 'snow'
        });
        addQuillDeleteListener(window.quill);
        window.quill.root.addEventListener('click', handleImageClick);
    }

    // โค้ด Quill instance สำหรับ edit_news_content_editor
    if (document.getElementById('edit_news_content_editor') && !Quill.find(document.getElementById('edit_news_content_editor'))) {
        window.Editquill = new Quill('#edit_news_content_editor', {
            modules: {
                toolbar: {
                    container: toolbarOptions,
                    handlers: {
                        'image': imageHandler
                    }
                },
                imageResize: {
                    modules: [ 'Resize', 'DisplaySize', 'Toolbar' ]
                }
            },
            theme: 'snow'
        });
        addQuillDeleteListener(window.Editquill);
        window.Editquill.root.addEventListener('click', handleImageClick);
    }

    // โค้ด Quill instance สำหรับ editor_facebook
    if (document.getElementById('editor_facebook') && !Quill.find(document.getElementById('editor_facebook'))) {
        var quillFacebook = new Quill('#editor_facebook', {
            modules: { toolbar: toolbarOptions },
            theme: 'snow'
        });
    }
</script>
<?= $this->endSection() ?>