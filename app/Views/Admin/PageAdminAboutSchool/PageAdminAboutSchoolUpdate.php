<?= $this->extend('Admin/layout/AdminLayout') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-0">
            <span class="text-muted fw-light">เกี่ยวกับโรงเรียน /</span> <?= $AboutSchoolDetail->about_menu ?? 'รายละเอียด' ?>
        </h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalAddAboutSchool">
            <i class="bx bx-plus me-1"></i> เพิ่มหัวข้อใหม่
        </button>
    </div>

    <div class="row">
        <!-- Main Edit Form -->
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex align-items-center justify-content-between border-bottom py-3">
                    <h5 class="card-title mb-0 text-primary">
                        <i class="bx bx-edit-alt me-2"></i>แก้ไขเนื้อหา
                    </h5>
                    <small class="text-muted">อัปเดตล่าสุด: <?= !empty($AboutSchoolDetail->about_date) ? date('d/m/Y H:i', strtotime($AboutSchoolDetail->about_date)) : '-' ?></small>
                </div>
                <form id="form-AboutSchool" action="<?= base_url('Admin/AboutSchool/Update/' . $uri->getSegment(4)) ?>" method="post">
                    <input type="hidden" id="AboutKey" value="<?= $uri->getSegment(4); ?>">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="update_about_menu" name="about_menu" placeholder="เช่น ประวัติโรงเรียน, วิสัยทัศน์" value="<?= $AboutSchoolDetail->about_menu ?? '' ?>" required>
                                    <label for="update_about_menu">หัวข้อเมนู</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-uppercase fw-bold small text-muted mb-2">เนื้อหาละเอียด</label>
                            <div id="editor_wrapper" class="rounded border overflow-hidden">
                                <div id="editor_AboutSchool" style="height: 500px; border: none;">
                                    <!-- Quill Editor -->
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="reset" class="btn btn-outline-secondary me-md-2">ล้างข้อมูล</button>
                            <button type="submit" class="btn btn-primary px-5" id="btn-submit-about">
                                <span class="spinner-border spinner-border-sm d-none me-1" role="status" aria-hidden="true"></span>
                                <i class="bx bx-save me-1"></i> บันทึกข้อมูล
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://unpkg.com/quill-image-resize-module@3.0.0/image-resize.min.js"></script>
<script>
    $(document).ready(function() {
        // Register the image resize module
        if (typeof ImageResize !== 'undefined') {
            Quill.register('modules/imageResize', ImageResize.default);
        }

        const toolbarOptions = [
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'align': [] }],
            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
            ['link', 'image', 'video'],
            ['clean']
        ];

        const editorModules = {
            toolbar: toolbarOptions,
            imageResize: {
                modules: [ 'Resize', 'DisplaySize', 'Toolbar' ]
            }
        };

        // Initialize Update Editor
        const updateEditor = new Quill('#editor_AboutSchool', {
            modules: editorModules,
            theme: 'snow',
            placeholder: 'พิมพ์เนื้อหาที่นี่...'
        });

        // Initialize Add Editor (Modal)
        const addEditor = new Quill('#editor_add_about', {
            modules: editorModules,
            theme: 'snow',
            placeholder: 'พิมพ์เนื้อหาที่นี่...'
        });

        // Fetch data and populate update editor
        const AboutKey = $("#AboutKey").val();
        if (AboutKey) {
            $.post(BASE_URL + "/Admin/AboutSchool/Edit/" + AboutKey, {}, function(data, status) {
                if (data && data.about_detail) {
                    $('#update_about_menu').val(data.about_menu);
                    updateEditor.root.innerHTML = data.about_detail;
                }
            }, 'json');
        }

        // Handle Update Form Submission
        $("#form-AboutSchool").on("submit", function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.set("About_content", updateEditor.root.innerHTML);
            
            $.ajax({
                url: $(this).attr('action'),
                type: "post",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#btn-submit-about').prop('disabled', true).find('.spinner-border').removeClass('d-none');
                    Swal.fire({
                        title: 'กำลังบันทึก...',
                        allowOutsideClick: false,
                        didOpen: () => { Swal.showLoading(); }
                    });
                },
                complete: function() {
                    $('#btn-submit-about').prop('disabled', false).find('.spinner-border').addClass('d-none');
                },
                success: function(data) {
                    if (data == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'สำเร็จ!',
                            text: 'บันทึกข้อมูลเรียบร้อยแล้ว',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        // Update the breadcrumb title dynamically
                        $('.fw-bold.py-3.mb-0').contents().last()[0].textContent = ' ' + $('#update_about_menu').val();
                    } else {
                        Swal.fire({ icon: 'error', title: 'ผิดพลาด', text: 'ไม่สามารถบันทึกข้อมูลได้' });
                    }
                }
            });
        });

        // Handle Add Form Submission
        $("#form-add-about-school").on("submit", function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.set("About_content", addEditor.root.innerHTML);

            if (!formData.get('about_menu').trim()) {
                Swal.fire({ icon: 'warning', title: 'คำเตือน', text: 'กรุณากรอกหัวข้อเมนู' });
                return;
            }

            $.ajax({
                url: $(this).attr('action'),
                type: "post",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#btn-submit-add-about').prop('disabled', true).find('.spinner-border').removeClass('d-none');
                    Swal.fire({
                        title: 'กำลังเพิ่มข้อมูล...',
                        allowOutsideClick: false,
                        didOpen: () => { Swal.showLoading(); }
                    });
                },
                complete: function() {
                    $('#btn-submit-add-about').prop('disabled', false).find('.spinner-border').addClass('d-none');
                },
                success: function(data) {
                    if (data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'เพิ่มข้อมูลสำเร็จ',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = BASE_URL + '/Admin/AboutSchool/Detail/' + data;
                        });
                    }
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>

<?= $this->section('modals') ?>
<div class="modal fade" id="ModalAddAboutSchool" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header border-bottom">
                <h5 class="modal-title text-primary"><i class="bx bx-plus-circle me-1"></i> เพิ่มข้อมูลเกี่ยวกับโรงเรียน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-add-about-school" method="post" action="<?= base_url('Admin/AboutSchool/Add') ?>">
                <div class="modal-body p-4">
                    <div class="form-floating form-floating-outline mb-4">
                        <input type="text" class="form-control" name="about_menu" id="about_menu" placeholder="เช่น วิสัยทัศน์" required>
                        <label for="about_menu">หัวข้อเมนู</label>
                    </div>

                    <label class="form-label text-uppercase fw-bold small text-muted mb-2">เนื้อหาละเอียด</label>
                    <div class="rounded border overflow-hidden">
                        <div id="editor_add_about" style="height: 400px; border: none;"></div>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary px-4" id="btn-submit-add-about">
                        <span class="spinner-border spinner-border-sm d-none me-1" role="status" aria-hidden="true"></span>
                        บันทึกข้อมูล
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .card { border-radius: 0.75rem; }
    .ql-toolbar.ql-snow { border: none !important; border-bottom: 1px solid #d9dee3 !important; padding: 10px 15px !important; background: #f8f9fa; }
    .ql-container.ql-snow { border: none !important; font-family: 'Sarabun', sans-serif; font-size: 1rem; }
    .form-floating-outline .form-control:focus ~ label { color: #696cff; }
</style>
<?= $this->endSection() ?>