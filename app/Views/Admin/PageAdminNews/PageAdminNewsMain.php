<?= $this->extend('Admin/layout/AdminLayout') ?>

<?= $this->section('content') ?>
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-0">
            <span class="text-muted fw-light">แดชบอร์ด /</span> ข่าวประชาสัมพันธ์
        </h4>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary" id="AddFacebook">
                <i class="bx bxl-facebook-circle me-1"></i> ดึงข่าวจาก Facebook
            </button>
            <button class="btn btn-primary" id="AddNews">
                <i class="bx bx-plus me-1"></i> เพิ่มข่าวสารใหม่
            </button>
        </div>
    </div>

    <!-- News List Card -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between border-bottom">
            <h5 class="mb-0 text-primary fw-bold">ตารางข่าวประชาสัมพันธ์</h5>
            <small class="text-muted">รายการข่าวทั้งหมดที่แสดงบนเว็บไซต์</small>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle mb-0" id="myTable">
                    <thead class="table-light">
                        <tr>
                            <th width="45%">หัวข้อข่าว</th>
                            <th width="20%">ประเภทข่าว</th>
                            <th width="20%">วันที่สร้าง</th>
                            <th width="15%">การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php foreach ($news as $v_news) : ?>
                        <tr id="<?= $v_news->news_id ?>">
                            <td>
                                <div class="d-flex align-items-center">
                                    <?php if($v_news->news_img): ?>
                                        <img src="<?= base_url('uploads/news/'.$v_news->news_img) ?>" class="rounded me-3" width="50" height="30" style="object-fit: cover;">
                                    <?php else: ?>
                                        <div class="rounded bg-label-secondary me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 30px;">
                                            <i class="bx bx-image-alt small"></i>
                                        </div>
                                    <?php endif; ?>
                                    <span class="fw-bold text-dark text-truncate" style="max-width: 350px;" title="<?= $v_news->news_topic ?>">
                                        <?= $v_news->news_topic ?>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <span class="badge <?= $v_news->news_category == 'ข่าวรางวัล' ? 'bg-label-success' : ($v_news->news_category == 'ข่าวกิจกรรม' ? 'bg-label-info' : 'bg-label-primary') ?>">
                                    <?= $v_news->news_category ?>
                                </span>
                            </td>
                            <td>
                                <small class="text-muted"><i class="bx bx-calendar me-1"></i><?= date('Y/m/d H:i', strtotime($v_news->news_date)) ?></small>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-icon btn-outline-info EditNews" key-newsid="<?= $v_news->news_id ?>" title="แก้ไข">
                                        <i class="bx bx-edit-alt"></i>
                                    </button>
                                    <button class="btn btn-sm btn-icon btn-outline-danger DeleteNews" key-newsid="<?= $v_news->news_id ?>" title="ลบ">
                                        <i class="bx bx-trash"></i>
                                    </button>
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
<!-- Modal Manage News (Add/Edit) -->
<div class="modal fade" id="ModalNews" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header border-bottom">
                <h5 class="modal-title text-primary fw-bold" id="ModalNewsTitle">จัดการข่าวสาร</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-news-manage" method="post" enctype="multipart/form-data">
                <input type="hidden" name="edit_news_id" id="news_id">
                <input type="hidden" name="original_news_img" id="original_news_img">
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-lg-8 border-end">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" class="form-control" name="news_topic" id="news_topic" placeholder="ใส่หัวข้อข่าว..." required>
                                <label for="news_topic">หัวข้อข่าวประชาสัมพันธ์</label>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-uppercase fw-bold small text-muted mb-2">เนื้อหาข่าวละเอียด</label>
                                <div id="editor_wrapper" class="rounded border overflow-hidden">
                                    <div id="news_editor" style="height: 450px; border: none;"></div>
                                </div>
                                <input type="hidden" name="news_content" id="news_content_val">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select" name="news_category" id="news_category" required>
                                    <option value="ข่าวประชาสัมพันธ์">ข่าวประชาสัมพันธ์</option>
                                    <option value="ข่าวกิจกรรม">ข่าวกิจกรรม</option>
                                    <option value="ข่าวรางวัล">ข่าวรางวัล</option>
                                </select>
                                <label for="news_category">ประเภทข่าว</label>
                            </div>

                            <div class="form-floating form-floating-outline mb-4">
                                <input class="form-control" type="datetime-local" id="news_date" name="news_date" required>
                                <label for="news_date">วันที่ประกาศ</label>
                            </div>

                            <div class="mb-0">
                                <label class="form-label text-uppercase fw-bold small text-muted mb-2">รูปภาพหน้าปกข่าว</label>
                                <input type="file" name="news_img" id="news_img_pond">
                                <small class="text-muted mt-2 d-block">* ขนาดแนะนำ 1920x1080 px</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary px-4" id="submitNewsBtn">
                        <span class="spinner-border spinner-border-sm d-none me-1" role="status" aria-hidden="true"></span>
                        <i class="bx bx-save me-1"></i> บันทึกข้อมูล
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Facebook Import -->
<div class="modal fade" id="ModalFacebook" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header border-bottom">
                <h5 class="modal-title text-primary fw-bold"><i class="bx bxl-facebook-square me-1"></i> ดึงข่าวจาก Facebook Page</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-news-facebook" method="post" action="<?=base_url('Admin/News/Add/NewsFeacbook')?>">
                <div class="modal-body p-4">
                    <div class="form-floating form-floating-outline mb-4">
                        <select class="form-select" name="sel_NewsFromFacebook" id="sel_NewsFromFacebook">
                            <option value="">-- กำลังโหลดข้อมูลจาก Facebook... --</option>
                        </select>
                        <label for="sel_NewsFromFacebook">เลือกโพสต์ที่ต้องการ</label>
                    </div>

                    <div id="fb_preview" class="d-none animate__animated animate__fadeIn">
                        <div class="row">
                            <div class="col-md-7 border-end">
                                <div class="form-floating form-floating-outline mb-3">
                                    <input type="text" class="form-control" name="news_topic_facebook" id="news_topic_facebook" required>
                                    <label>หัวข้อข่าว</label>
                                </div>
                                <div class="form-floating form-floating-outline mb-3">
                                    <input class="form-control" type="datetime-local" id="news_date_facebook" name="news_date_facebook" required>
                                    <label>วันที่โพสต์</label>
                                </div>
                                <div class="form-floating form-floating-outline mb-3">
                                    <select class="form-select" name="news_category_facebook" id="news_category_facebook">
                                        <option value="ข่าวประชาสัมพันธ์">ข่าวประชาสัมพันธ์</option>
                                        <option value="ข่าวกิจกรรม">ข่าวกิจกรรม</option>
                                        <option value="ข่าวรางวัล">ข่าวรางวัล</option>
                                    </select>
                                    <label>ประเภทข่าว</label>
                                </div>
                                <div class="mb-0">
                                    <label class="form-label small fw-bold text-muted">เนื้อหาโพสต์</label>
                                    <div id="editor_facebook" style="height: 200px;" class="border rounded"></div>
                                    <input type="hidden" name="news_content_facebook" id="news_content_facebook_val">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label small fw-bold text-muted d-block">รูปภาพจากโพสต์</label>
                                <img src="" id="blah_facebook" class="img-fluid rounded shadow-sm border">
                                <input type="hidden" name="news_img_facebook" id="news_img_facebook_url">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary px-4 d-none" id="btn-submit-news-facebook">
                        <span class="spinner-border spinner-border-sm d-none me-1" role="status" aria-hidden="true"></span>
                        <i class="bx bx-import me-1"></i> ดึงข้อมูลข่าว
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
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script src="https://unpkg.com/quill-image-resize-module@3.0.0/image-resize.min.js"></script>

<script>
    FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginFileValidateType);
    Quill.register('modules/imageResize', ImageResize.default);

    let pond;
    let quill;
    let quillFB;
    const BASE_URL = "<?= base_url() ?>";

    $(document).ready(function() {
        const dataTable = $('#myTable').DataTable({
            order: [[2, 'desc']],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "ค้นหาข่าว...",
            }
        });

        // Initialize Quill Editor
        const toolbarOptions = [
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'align': [] }],
            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
            ['link', 'image', 'video'],
            ['clean']
        ];

        quill = new Quill('#news_editor', {
            modules: {
                toolbar: {
                    container: toolbarOptions,
                    handlers: { image: quillImageHandler }
                },
                imageResize: { modules: ['Resize', 'DisplaySize', 'Toolbar'] }
            },
            theme: 'snow',
            placeholder: 'เขียนข่าวของคุณที่นี่...'
        });

        quillFB = new Quill('#editor_facebook', { theme: 'snow', placeholder: 'เนื้อหาจาก Facebook...' });

        // Image Handler for Quill (Upload to server)
        function quillImageHandler() {
            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.click();
            input.onchange = async () => {
                const file = input.files[0];
                const formData = new FormData();
                formData.append('image', file);
                
                try {
                    const response = await fetch(`${BASE_URL}/Admin/News/uploadImage`, { method: 'POST', body: formData });
                    const result = await response.json();
                    if (result.url) {
                        const range = quill.getSelection();
                        quill.insertEmbed(range.index, 'image', result.url);
                    }
                } catch (error) {
                    console.error('Upload failed:', error);
                }
            };
        }

        // Manage News (Add/Edit)
        $('#AddNews').click(function() {
            $('#ModalNewsTitle').text('เพิ่มข่าวสารใหม่');
            $('#form-news-manage').attr('action', '<?= base_url('Admin/News/AddNews') ?>').trigger('reset');
            $('#news_id').val('');
            quill.setContents([]);
            $('#news_date').val(new Date().toISOString().slice(0, 16));
            initFilePond();
            new bootstrap.Modal(document.getElementById("ModalNews")).show();
        });

        $(document).on("click", ".EditNews", function() {
            const newsId = $(this).attr('key-newsid');
            $('#ModalNewsTitle').text('แก้ไขข้อมูลข่าวสาร');
            $('#form-news-manage').attr('action', '<?= base_url('Admin/News/UpdateNews') ?>');
            
            $.post('<?= base_url('Admin/News/EditNews') ?>', { KeyNewsid: newsId }, function(data) {
                if(data && data[0]) {
                    const news = data[0];
                    $('#news_id').val(news.news_id);
                    $('#news_topic').val(news.news_topic);
                    $('#news_category').val(news.news_category);
                    $('#news_date').val(news.news_date.replace(' ', 'T').slice(0, 16));
                    $('#original_news_img').val(news.news_img);
                    quill.root.innerHTML = news.news_content;
                    initFilePond(news.news_img);
                    new bootstrap.Modal(document.getElementById("ModalNews")).show();
                }
            }, 'json');
        });

        $('#form-news-manage').submit(function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const isUpdate = $('#news_id').val() !== '';
            
            // Set value for Add and Update fields specifically due to old controller structure
            if(isUpdate) {
                formData.set('edit_news_topic', $('#news_topic').val());
                formData.set('edit_news_content', quill.root.innerHTML);
                formData.set('edit_news_date', $('#news_date').val());
                formData.set('edit_news_category', $('#news_category').val());
                formData.set('edit_news_id', $('#news_id').val());
            } else {
                formData.set("news_content", quill.root.innerHTML);
            }

            const pondFile = pond ? pond.getFile() : null;
            if (pondFile) {
                formData.append(isUpdate ? 'edit_news_img' : 'news_img', pondFile.file);
            }

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#submitNewsBtn').prop('disabled', true).find('.spinner-border').removeClass('d-none');
                    Swal.fire({ title: 'กำลังประมวลผล...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
                },
                complete: function() {
                    $('#submitNewsBtn').prop('disabled', false).find('.spinner-border').addClass('d-none');
                },
                success: function(response) {
                    if (response.status) {
                        $('#ModalNews').modal('hide');
                        Swal.fire({ icon: 'success', title: 'สำเร็จ!', text: response.message, timer: 1500, showConfirmButton: false });
                        
                        // Dynamically update UI or stay
                        if (isUpdate) {
                            const newsId = response.data.news_id;
                            const row = $(`#${newsId}`);
                            row.find('td:nth-child(1) .fw-bold').text(response.data.news_topic);
                            if(response.data.news_img) {
                                row.find('td:nth-child(1) img').attr('src', `${BASE_URL}/uploads/news/${response.data.news_img}`);
                            }
                            const catBadge = row.find('td:nth-child(2) .badge');
                            catBadge.text(response.data.news_category);
                            // Update badge color
                            catBadge.removeClass().addClass('badge ' + (response.data.news_category == 'ข่าวรางวัล' ? 'bg-label-success' : (response.data.news_category == 'ข่าวกิจกรรม' ? 'bg-label-info' : 'bg-label-primary')));
                        } else {
                            // Stay but reload is easier for complex datatables
                            window.location.reload();
                        }
                    }
                }
            });
        });

        // Facebook Import
        $('#AddFacebook').click(function() {
            new bootstrap.Modal(document.getElementById("ModalFacebook")).show();
            $('#sel_NewsFromFacebook').html('<option value="">-- กำลังโหลดข้อมูล... --</option>');
            $.post('<?= base_url('Admin/News/View/Facebook') ?>', function(data) {
                data = JSON.parse(data);
                let options = '<option value="">-- กรุณาเลือกโพสต์ที่ต้องการ --</option>';
                data.data.forEach(item => {
                    if(item.message) options += `<option value="${item.id}">${item.message.substr(0, 80)}...</option>`;
                });
                $('#sel_NewsFromFacebook').html(options);
            }, 'json');
        });

        $('#sel_NewsFromFacebook').change(function() {
            const val = $(this).val();
            if(!val) return;
            $.post('<?= base_url('Admin/News/Select/Facebook') ?>', { KeyNewsFB: val }, function(data) {
                data = JSON.parse(data);
                $('#fb_preview').removeClass('d-none');
                $('#btn-submit-news-facebook').removeClass('d-none');
                $('#news_topic_facebook').val(data.message.substr(0, 100));
                $('#news_date_facebook').val(data.created_time.replace(' ', 'T').slice(0, 16));
                $('#blah_facebook').attr('src', data.full_picture);
                $('#news_img_facebook_url').val(data.full_picture);
                quillFB.root.innerText = data.message;
            }, 'json');
        });

        $('#form-news-facebook').submit(function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.set("news_content_facebook", quillFB.root.innerHTML);
            
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#btn-submit-news-facebook').prop('disabled', true).find('.spinner-border').removeClass('d-none');
                    Swal.fire({ title: 'กำลังดึงข้อมูล...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
                },
                complete: function() {
                    $('#btn-submit-news-facebook').prop('disabled', false).find('.spinner-border').addClass('d-none');
                },
                success: function(response) {
                    if(response.status) {
                        $('#ModalFacebook').modal('hide');
                        Swal.fire({ icon: 'success', title: 'สำเร็จ!', text: response.message, timer: 1500 });
                        window.location.reload();
                    }
                }
            });
        });

        // Delete News
        $(document).on("click", ".DeleteNews", function() {
            const newsId = $(this).attr('key-newsid');
            Swal.fire({
                title: 'ยืนยันการลบข่าว?',
                text: "รูปภาพและเนื้อหาจะถูกลบออกอย่างถาวร!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff3e1d',
                confirmButtonText: 'ลบข้อมูล'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('<?= base_url('Admin/News/DeleteNews') ?>', { KeyNewsid: newsId }, function(response) {
                        if (response.status) {
                            $(`#${newsId}`).fadeOut(function() { $(this).remove(); });
                            Swal.fire({ icon: 'success', title: 'ลบเรียบร้อย!', timer: 1000, showConfirmButton: false });
                        }
                    }, 'json');
                }
            });
        });

        function initFilePond(imgName = null) {
            const inputElement = document.querySelector('#news_img_pond');
            if (pond) pond.destroy();
            let options = {
                labelIdle: 'ลากไฟล์มาวาง หรือ <span class="filepond--label-action">คลิกเพื่ออัปโหลด</span>',
                imagePreviewHeight: 150,
                credits: false
            };
            if (imgName) {
                options.files = [{ source: `${BASE_URL}/uploads/news/${imgName}` }];
            }
            pond = FilePond.create(inputElement, options);
        }

        $('#ModalNews').on('hidden.bs.modal', function() {
            if (pond) pond.destroy();
            pond = null;
        });
    });
</script>

<style>
    .card { border-radius: 0.75rem; }
    .table thead th { font-weight: 600; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; }
    .btn-icon { width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 0.375rem; }
    .ql-toolbar.ql-snow { border: none !important; border-bottom: 1px solid #d9dee3 !important; padding: 10px 15px !important; background: #f8f9fa; }
    .ql-container.ql-snow { border: none !important; font-family: 'Sarabun', sans-serif; font-size: 1rem; }
    .form-floating-outline .form-control:focus ~ label { color: #696cff; }
</style>
<?= $this->endSection() ?>