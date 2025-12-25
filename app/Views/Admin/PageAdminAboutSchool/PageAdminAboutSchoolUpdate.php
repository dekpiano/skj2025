<?= $this->extend('Admin/layout/AdminLayout') ?>

<?= $this->section('content') ?>
                <!-- Content -->

                <div class="container-xxl flex-grow-1 container-p-y">

                    <div class="row">
                        <div class="col-lg-12 mb-4 order-0">
                            <div class="card p-3">
                                <div class="d-flex justify-content-between align-content-center">
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalAddAboutSchool">+ เพิ่มเกี่ยวกับโรงเรียน</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="">แก้ไขข้อมูลเกี่ยวกับโรงเรียน</h5>
                    <div class="card">
                        <input type="hidden" id="AboutKey" value="<?=$uri->getSegment(4);?>">
                        <form id="form-AboutSchool" action="<?=base_url('Admin/AboutSchool/Update/'.$uri->getSegment(4))?>" method="post">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="update_about_menu" class="form-label">หัวข้อ</label>
                                <input type="text" class="form-control" id="update_about_menu" name="about_menu" placeholder="ใส่หัวข้อ..." required>
                            </div>
                            <label class="form-label">เนื้อหา</label>
                            <div id="editor_AboutSchool" class="mb-3">
                               
                            </div>
                            <button type="submit" class="btn btn-primary w-100">บันทึก</button>
                        </div>     
                        </form>                   
                    </div>
                    
                </div>
                <!-- / Content -->
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // All page-specific JS is now inlined
    $(document).ready(function() {
        // Register the image resize module
        Quill.register('modules/imageResize', ImageResize.default);

        const toolbarOptions = [
            ['bold', 'italic', 'underline', 'strike'],
            ['blockquote', 'code-block'],
            [{ 'header': 1 }, { 'header': 2 }],
            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
            [{ 'script': 'sub' }, { 'script': 'super' }],
            [{ 'indent': '-1' }, { 'indent': '+1' }],
            [{ 'direction': 'rtl' }],
            [{ 'size': ['small', false, 'large', 'huge'] }],
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'font': [] }],
            [{ 'align': [] }],
            ['clean'],
            ['link', 'image']
        ];

        // Define the modules configuration with image resize
        const editorModules = {
            toolbar: toolbarOptions,
            imageResize: {
                modules: [ 'Resize', 'DisplaySize', 'Toolbar' ]
            }
        };

        // Ensure the editor divs exist before initializing
        if ($('#editor_AboutSchool').length && $('#editor_add_about').length) {
            // Editor for the Update form
            const updateEditor = new Quill('#editor_AboutSchool', {
                modules: editorModules,
                theme: 'snow'
            });

            // Editor for the Add modal
            const addEditor = new Quill('#editor_add_about', {
                modules: editorModules,
                theme: 'snow'
            });

            // Fetch and load data for the update form
            const AboutKey = $("#AboutKey").val();
            if (AboutKey) {
                $.post(BASE_URL + "/Admin/AboutSchool/Edit/" + AboutKey, {}, function(data, status) {
                    if (data) {
                        $('#update_about_menu').val(data.about_menu);
                        if (data.about_detail) {
                            const delta = updateEditor.clipboard.convert(data.about_detail);
                            updateEditor.setContents(delta, 'silent');
                        }
                    }
                }, 'json');
            }

            // Handle Update Form Submission
            $(document).on("submit", "#form-AboutSchool", function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const editorContent = $('#editor_AboutSchool .ql-editor').html();
                formData.set("About_content", editorContent);
                
                $.ajax({
                    url: $(this).attr('action'),
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data == 1) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'บันทึกข้อมูลสำเร็จ',
                                showConfirmButton: false,
                                timer: 1500
                            }).then((result) => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'อัปเดตข้อมูลไม่สำเร็จ',
                                text: 'เกิดข้อผิดพลาดบางอย่าง กรุณาลองใหม่อีกครั้ง',
                            });
                        }
                    }
                });
            });

            // Handle Add Form Submission
            $(document).on("submit", "#form-add-about-school", function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                // Use .set() to ensure there is only one 'About_content' field
                formData.set("About_content", addEditor.root.innerHTML);

                // Also check if the title is empty
                if (!formData.get('about_menu').trim()) {
                    Swal.fire({
                        icon: 'error',
                        title: 'ผิดพลาด',
                        text: 'กรุณาใส่หัวข้อ',
                    });
                    return; // Stop submission
                }

                $.ajax({
                    url: $(this).attr('action'),
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'เพิ่มข้อมูลสำเร็จ',
                                showConfirmButton: false,
                                timer: 1500
                            }).then((result) => {
                                window.location.href = BASE_URL + '/Admin/AboutSchool/Detail/' + data;
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'เพิ่มข้อมูลไม่สำเร็จ',
                                text: 'เกิดข้อผิดพลาดบางอย่าง กรุณาลองใหม่อีกครั้ง',
                            });
                        }
                    }
                });
            });
        }
    });
</script>

<?= $this->endSection() ?>

<?= $this->section('modals') ?>
<!-- Modal เพิ่มเกี่ยวกับโรงเรียน -->
<div class="modal fade" id="ModalAddAboutSchool" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ModalAddAboutSchoolLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalAddAboutSchoolLabel">เพิ่มข้อมูลเกี่ยวกับโรงเรียน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-add-about-school" method="post" action="<?=base_url('Admin/AboutSchool/Add')?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="about_menu" class="form-label">หัวข้อ</label>
                        <input type="text" class="form-control mb-3" name="about_menu" id="about_menu" placeholder="ใส่หัวข้อ..." required>
                    </div>

                    <label class="form-label">เนื้อหา</label>
                    <div id="editor_add_about" class="mb-3">
                        <!-- Editor will be initialized here -->
                    </div>
                    <!-- Hidden input that will be populated by the editor's content -->
                    <input type="hidden" name="About_content" id="add_about_content">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>