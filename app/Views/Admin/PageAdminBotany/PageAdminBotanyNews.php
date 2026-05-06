<?= $this->extend('Admin/PageAdminBotany/layout/BotanyAdminLayout') ?>

<?= $this->section('content') ?>
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-0">
            <span class="text-muted fw-light">จัดการสวนพฤกษศาสตร์ /</span> กิจกรรมและข่าวสาร
        </h4>
        <button class="btn btn-primary" id="AddNews">
            <i class="bx bx-plus me-1"></i> เพิ่มข่าวสารใหม่
        </button>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between border-bottom">
            <h5 class="mb-0 text-primary fw-bold">รายการกิจกรรมและข่าวสาร</h5>
            <small class="text-muted">ทั้งหมด <?= count($news) ?> รายการ</small>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle mb-0" id="newsTable">
                    <thead class="table-light">
                        <tr>
                            <th width="10%">จัดการ</th>
                            <th width="40%">หัวข้อข่าว</th>
                            <th width="20%">รูปหน้าปก</th>
                            <th width="15%">วันที่</th>
                            <th width="15%">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php foreach ($news as $v) : ?>
                        <tr id="news-<?= $v->news_id ?>">
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item EditNews" href="javascript:void(0);" key-newsid="<?= $v->news_id ?>">
                                            <i class="bx bx-edit-alt me-1 text-info"></i> แก้ไข
                                        </a>
                                        <a class="dropdown-item DeleteNews" href="javascript:void(0);" key-newsid="<?= $v->news_id ?>">
                                            <i class="bx bx-trash me-1 text-danger"></i> ลบ
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold text-dark text-truncate d-block" style="max-width: 400px;" title="<?= $v->news_title ?>">
                                    <?= $v->news_title ?>
                                </span>
                            </td>
                            <td>
                                <div class="rounded overflow-hidden shadow-sm border" style="width: 100px; height: 60px;">
                                    <?php if($v->news_img): ?>
                                        <img src="<?= base_url('uploads/botany/news/'.$v->news_img) ?>" class="w-100 h-100 object-fit-cover">
                                    <?php else: ?>
                                        <img src="https://via.placeholder.com/100x60?text=No+Img" class="w-100 h-100 object-fit-cover">
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td><?= date('d/m/Y', strtotime($v->news_date)) ?></td>
                            <td>
                                <label class="switch-toggle">
                                    <input type="checkbox" class="form-check-input-toggle-news" status-key="<?= $v->news_id ?>" 
                                        <?= $v->news_status == "active" ? "checked" : "" ?>>
                                    <span class="slider-toggle">
                                        <span class="label-on">เปิด</span>
                                        <span class="label-off">ปิด</span>
                                    </span>
                                </label>
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
<div class="modal fade" id="ModalNews" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header border-bottom">
                <h5 class="modal-title text-primary fw-bold" id="ModalTitle">จัดการข่าวสาร</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-news" method="post" enctype="multipart/form-data">
                <input type="hidden" name="news_id" id="news_id">
                <input type="hidden" name="original_news_img" id="original_news_img">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">หัวข้อข่าวสาร <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="news_title" id="news_title" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">วันที่ของข่าว</label>
                            <input type="date" class="form-control" name="news_date" id="news_date" value="<?= date('Y-m-d') ?>" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">เนื้อหาข่าว</label>
                            <textarea class="form-control" name="news_content" id="news_content" rows="6"></textarea>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">รูปภาพหน้าปก</label>
                            <input type="file" name="news_img" id="news_img">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">อัลบั้มรูปภาพกิจกรรม (หลายรูป)</label>
                            <input type="file" name="news_album[]" id="news_album" multiple>
                        </div>
                        <div class="col-12 mt-3" id="existing-album-container" style="display: none;">
                            <label class="form-label fw-bold">รูปภาพเดิมในอัลบั้ม</label>
                            <div class="d-flex flex-wrap gap-2" id="existing-album-images">
                                <!-- Images will be loaded here -->
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
    let pondAlbum;
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

        $('#newsTable').DataTable({
            order: [[3, 'desc']],
            language: { search: "_INPUT_", searchPlaceholder: "ค้นหาข่าว..." }
        });

        $('#form-news').on('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            const pondFile = pond ? pond.getFile() : null;
            if (pondFile) { formData.append('news_img', pondFile.file); }

            const albumFiles = pondAlbum ? pondAlbum.getFiles() : [];
            albumFiles.forEach(fileItem => {
                formData.append('news_album[]', fileItem.file);
            });
            
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
                        $('#ModalNews').modal('hide');
                        Swal.fire({ icon: 'success', title: 'สำเร็จ!', text: response.message, timer: 2000, showConfirmButton: false }).then(() => { window.location.reload(); });
                    } else {
                        Swal.fire({ icon: 'error', title: 'ไม่สำเร็จ', text: response.message });
                    }
                },
                error: function() {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'เกิดข้อผิดพลาดในการเชื่อมต่อ' });
                }
            });
        });

        $(document).on("click", "#AddNews", function() {
            $('#ModalTitle').text('เพิ่มข่าวสารใหม่');
            $('#form-news').attr('action', '<?=base_url('Admin/Botany/NewsAdd')?>').trigger('reset');
            $('#news_id').val('');
            $('#original_news_img').val('');
            $('#existing-album-container').hide();
            initFilePond();
            initFilePondAlbum();
            new bootstrap.Modal(document.getElementById("ModalNews")).show();
        });

        $(document).on("click", ".EditNews", function() {
            $('#ModalTitle').text('แก้ไขข่าวสาร');
            $('#form-news').attr('action', '<?=base_url('Admin/Botany/NewsUpdate')?>');
            let id = $(this).attr('key-newsid');
            let postData = getCsrfData();
            postData['KeyNewsid'] = id;

            $.post('<?=base_url('Admin/Botany/NewsEdit')?>', postData, function(data) {
                if(data && data.news) {
                    $('#news_id').val(data.news.news_id);
                    $('#news_title').val(data.news.news_title);
                    $('#news_date').val(data.news.news_date);
                    $('#news_content').val(data.news.news_content);
                    $('#original_news_img').val(data.news.news_img);
                    initFilePond(data.news.news_img);
                    initFilePondAlbum();

                    // Display Album Images
                    if(data.images && data.images.length > 0) {
                        $('#existing-album-container').show();
                        let html = '';
                        data.images.forEach(img => {
                            html += `
                                <div class="position-relative" id="album-img-${img.img_id}">
                                    <img src="${BASE_URL}/uploads/botany/news/album/${img.img_path}" class="rounded border" style="width: 100px; height: 75px; object-fit: cover;">
                                    <button type="button" class="btn btn-danger btn-xs position-absolute top-0 end-0 delete-album-img" key-imgid="${img.img_id}" style="padding: 2px 5px;">
                                        <i class="bx bx-x"></i>
                                    </button>
                                </div>
                            `;
                        });
                        $('#existing-album-images').html(html);
                    } else {
                        $('#existing-album-container').hide();
                    }

                    new bootstrap.Modal(document.getElementById("ModalNews")).show();
                }
            }, 'json');
        });

        $(document).on("click", ".delete-album-img", function() {
            let id = $(this).attr('key-imgid');
            let postData = getCsrfData();
            postData['KeyImgid'] = id;

            Swal.fire({ title: 'ลบรูปภาพ?', text: "รูปภาพนี้จะถูกลบออกจากอัลบั้ม!", icon: 'warning', showCancelButton: true, confirmButtonText: 'ลบ' }).then((result) => {
                if (result.isConfirmed) {
                    $.post('<?=base_url('Admin/Botany/NewsDeleteImage')?>', postData, function(res) {
                        if(res.status) {
                            $(`#album-img-${id}`).fadeOut(function() { $(this).remove(); });
                        }
                    }, 'json');
                }
            });
        });

        $(document).on("click", ".DeleteNews", function() {
            let id = $(this).attr('key-newsid');
            Swal.fire({ title: 'ยืนยันการลบข่าว?', text: "ข้อมูลนี้จะถูกลบถาวรพร้อมอัลบั้มรูป!", icon: 'warning', showCancelButton: true, confirmButtonColor: '#ff3e1d', confirmButtonText: 'ลบข้อมูล' }).then((result) => {
                if (result.isConfirmed) {
                    let postData = getCsrfData();
                    postData['KeyNewsid'] = id;
                    $.post('<?=base_url('Admin/Botany/NewsDelete')?>', postData, function(data) {
                        if (data == 1) {
                            $(`#news-${id}`).fadeOut(function() { $(this).remove(); });
                            Swal.fire({ icon: 'success', title: 'ลบสำเร็จ!', timer: 1500, showConfirmButton: false });
                        } else {
                            Swal.fire({ icon: 'error', title: 'Error', text: 'ไม่สามารถลบข้อมูลได้' });
                        }
                    });
                }
            });
        });

        $(document).on("change", ".form-check-input-toggle-news", function() {
            const status = $(this).is(":checked") ? "active" : "inactive";
            const key = $(this).attr('status-key');
            let postData = getCsrfData();
            postData['Onoffstatus'] = status;
            postData['Keystatus'] = key;

            $.post("<?=base_url('Admin/Botany/NewsOnoff')?>", postData, function() {
                Swal.fire({ position: 'top-end', icon: 'success', title: 'อัปเดตสถานะแล้ว', showConfirmButton: false, timer: 1500 });
            });
        });

        function initFilePond(imgName = null) {
            const inputElement = document.querySelector('#news_img');
            if (pond) { pond.destroy(); }
            let options = { labelIdle: 'คลิกเพื่อเลือกรูปหน้าปก', acceptedFileTypes: ['image/*'], credits: false };
            if (imgName && imgName !== "") { 
                options.files = [{ source: `${BASE_URL}/uploads/botany/news/${imgName}` }]; 
            }
            pond = FilePond.create(inputElement, options);
        }

        function initFilePondAlbum() {
            const inputElement = document.querySelector('#news_album');
            if (pondAlbum) { pondAlbum.destroy(); }
            pondAlbum = FilePond.create(inputElement, {
                labelIdle: 'ลากไฟล์อัลบั้มมาวาง หรือ <span class="filepond--label-action">คลิกเพื่อเลือกหลายรูป</span>',
                allowMultiple: true,
                acceptedFileTypes: ['image/*'],
                credits: false
            });
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
