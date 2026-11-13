<?= $this->extend('Admin/layout/AdminLayout') ?>

<?= $this->section('content'); ?>
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-0">
            <span class="text-muted fw-light">แดชบอร์ด /</span> ข่าวประชาสัมพันธ์
        </h4>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-info" id="BtnOpenSyncModal" type="button" data-bs-toggle="modal" data-bs-target="#ModalSyncNewsImages" title="ซิงค์รูปภาพเก่าขึ้น Cloud Server">
                <i class="bx bx-cloud-upload me-1"></i> ซิงค์รูปขึ้น Cloud
            </button>
            <button class="btn btn-outline-danger" id="CleanImages" type="button" data-bs-toggle="tooltip" title="ลบรูปภาพที่ไม่ได้ใช้งาน">
                <i class="bx bx-trash me-1"></i> ล้างไฟล์ขยะ
            </button>
            <button class="btn btn-outline-primary" id="AddFacebook" type="button" data-bs-toggle="modal" data-bs-target="#ModalFacebook">
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
                                        <img data-src="<?= news_image_url($v_news->news_img, 'cover') ?>" 
                                             class="lozad rounded me-3" width="50" height="30" style="object-fit: cover; background: #f0f0f0;"
                                             onerror="this.onerror=null;this.src='https://placehold.co/100x60?text=No+Image';">
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
                <div class="modal-body p-0">
                    <ul class="nav nav-tabs nav-fill" role="tablist">
                        <li class="nav-item">
                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-news-info">
                                <i class="tf-icons bx bx-info-circle me-1"></i> ข้อมูลข่าวสาร
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-news-album" id="tab-album">
                                <i class="tf-icons bx bx-images me-1"></i> อัลบั้มรูปภาพ
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content border-0 shadow-none p-4">
                        <div class="tab-pane fade show active" id="navs-news-info" role="tabpanel">
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
                                
                                <!-- Preview Image Section -->
                                <div id="preview_container" class="mb-2 d-none text-center bg-light rounded p-2">
                                    <label class="small text-muted d-block mb-1 text-start">รูปภาพปัจจุบัน:</label>
                                    <img id="current_news_img_preview" src="" class="img-fluid rounded shadow-sm" style="max-height: 200px;">
                                </div>

                                <input type="file" name="news_img" id="news_img_pond">
                                <small class="text-muted mt-2 d-block">* ขนาดแนะนำ 1920x1080 px</small>
                            </div>
                        </div>
                            </div>
                        </div>
                        <!-- Album Tab -->
                        <div class="tab-pane fade" id="navs-news-album" role="tabpanel">
                            <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
                                <span class="badge badge-center rounded-pill bg-info me-3"><i class="bx bx-info-circle"></i></span>
                                <div>
                                    คุณสามารถเลือกอัปโหลดรูปภาพพร้อมกันได้หลายรูปภาพ เพื่อสร้างเป็นอัลบั้มแสดงท้ายข่าว
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-uppercase fw-bold small text-muted mb-2">อัปโหลดรูปภาพเข้าอัลบั้ม</label>
                                <input type="file" name="news_album[]" id="news_album_pond" multiple>
                            </div>
                            
                            <hr>
                            <h6 class="fw-bold mb-3">รายการรูปภาพในอัลบั้ม</h6>
                            <div id="album-preview-container" class="row g-3">
                                <!-- Existing album images will be loaded here -->
                                <div class="col-12 text-center py-4 text-muted" id="no-album-msg">
                                    <i class="bx bx-image-alt display-4 d-block mb-2"></i>
                                    ยังไม่มีรูปภาพในอัลบั้ม
                                </div>
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
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <form id="form-news-facebook" class="modal-content shadow-lg border-0" method="post" action="<?=base_url('Admin/News/Add/NewsFacebook')?>" style="border-radius: 18px; max-height: calc(100vh - 40px);">
            <input type="hidden" name="news_facebook_id" id="news_facebook_id">
            <input type="hidden" name="news_album_images_facebook" id="news_album_images_facebook">

            <div class="modal-header d-flex align-items-center justify-content-between flex-shrink-0">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-white shadow-sm p-2 d-inline-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                        <i class="bx bxl-facebook fs-3" style="color: #696cff !important;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title text-white fw-bold mb-0">ดึงข่าวสารและกิจกรรมจาก Facebook Page</h5>
                        <small class="text-white" style="opacity: 0.9;">นำเข้าเนื้อหาและรูปภาพทั้งหมดเข้าสู่ระบบคลาวด์โรงเรียนอัตโนมัติ</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4 bg-light bg-opacity-50" style="overflow-y: auto;">
                    <!-- Method Selector: Tabs for Direct URL vs Recent Page Posts -->
                    <div class="card fb-hero-card mb-4 border-0">
                        <div class="card-body p-3 p-md-4">
                            <ul class="nav nav-pills nav-fill mb-3 gap-2" id="fb-import-tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active fw-semibold py-2 px-3 d-flex align-items-center justify-content-center gap-2 rounded-pill shadow-xs" id="tab-fb-url" data-bs-toggle="pill" data-bs-target="#pills-fb-url" type="button" role="tab">
                                        <i class="bx bx-link-alt fs-5"></i> <span>1. วางลิงก์โพสต์ Facebook (แนะนำ)</span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fw-semibold py-2 px-3 d-flex align-items-center justify-content-center gap-2 rounded-pill shadow-xs" id="tab-fb-recent" data-bs-toggle="pill" data-bs-target="#pills-fb-recent" type="button" role="tab">
                                        <i class="bx bx-list-ul fs-5"></i> <span>2. เลือกจากโพสต์ล่าสุดของเพจ</span>
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content" id="fb-import-tabs-content">
                                <!-- Tab 1: By URL -->
                                <div class="tab-pane fade show active" id="pills-fb-url" role="tabpanel">
                                    <div class="input-group input-group-lg shadow-sm rounded-pill overflow-hidden border bg-white">
                                        <span class="input-group-text bg-white border-0 ps-3 text-primary"><i class="bx bx-globe fs-4"></i></span>
                                        <input type="url" class="form-control border-0 py-2 fs-6 shadow-none" id="fb_post_url" placeholder="วางลิงก์ เช่น https://www.facebook.com/.../posts/... หรือ https://facebook.com/share/p/..." autocomplete="off">
                                        <button class="btn btn-primary px-4 fw-semibold d-flex align-items-center gap-2" type="button" id="btn-fetch-fb-url">
                                            <span class="spinner-border spinner-border-sm d-none" id="fb_url_spinner" role="status"></span>
                                            <i class="bx bx-download fs-5" id="fb_url_icon"></i> <span>ดึงข้อมูลโพสต์</span>
                                        </button>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 text-muted mt-2 ps-2 small">
                                        <i class="bx bx-check-shield text-success"></i> รองรับลิงก์โพสต์เพจ, ลิงก์แชร์มือถือ (share/p) และลิงก์รูปภาพในอัลบั้ม
                                    </div>
                                </div>

                                <!-- Tab 2: Recent Posts Dropdown -->
                                <div class="tab-pane fade" id="pills-fb-recent" role="tabpanel">
                                    <div class="position-relative">
                                        <label class="form-label fw-bold text-dark mb-1"><i class="bx bx-collection text-primary me-1"></i> รายการโพสต์ล่าสุดจากเพจโรงเรียน</label>
                                        <div class="position-relative">
                                            <select class="form-select form-select-lg shadow-sm rounded-3 pe-5" name="sel_NewsFromFacebook" id="sel_NewsFromFacebook">
                                                <option value="">-- คลิกเพื่อเลือกโพสต์จากเพจ --</option>
                                            </select>
                                            <div id="fb_loading_spinner" class="position-absolute end-0 top-50 translate-middle-y me-4 d-none">
                                                <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Alert message when already saved -->
                    <div id="fb_already_saved_alert" class="alert alert-warning py-2 px-3 small d-none mb-3 rounded-3 shadow-xs">
                        <i class="bx bx-error-circle me-1"></i> <strong>แจ้งเตือน:</strong> โพสต์นี้เคยถูกบันทึกเข้าระบบแล้ว (คุณสามารถแก้ไขและบันทึกซ้ำได้)
                    </div>

                    <!-- Live Preview Area (Spacious 2 Columns) -->
                    <div id="fb_preview" class="d-none animate__animated animate__fadeIn">
                        <div class="row g-4">
                            <!-- Left Column: News Metadata & Editor (60%) -->
                            <div class="col-lg-7">
                                <div class="card border shadow-sm rounded-3 p-3 h-100" style="background-color: #ffffff; border-color: #e2e8f0;">
                                    <h6 class="fw-bold mb-3 d-flex align-items-center" style="color: #0f172a !important;">
                                        <i class="bx bx-file me-2 fs-5" style="color: #696cff !important;"></i> ข้อมูลข่าวสาร
                                    </h6>
                                    
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating form-floating-outline">
                                                <input class="form-control" type="datetime-local" id="news_date_facebook" name="news_date_facebook" required style="color: #0f172a; background: #ffffff;">
                                                <label style="color: #475569;">วันที่และเวลาโพสต์</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating form-floating-outline">
                                                <select class="form-select" name="news_category_facebook" id="news_category_facebook" style="color: #0f172a; background: #ffffff;">
                                                    <option value="ข่าวประชาสัมพันธ์">ข่าวประชาสัมพันธ์</option>
                                                    <option value="ข่าวกิจกรรม">ข่าวกิจกรรม</option>
                                                    <option value="ข่าวรางวัล">ข่าวรางวัล</option>
                                                </select>
                                                <label style="color: #475569;">ประเภทหมวดหมู่ข่าว</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-floating form-floating-outline mb-3">
                                        <input type="text" class="form-control" name="news_topic_facebook" id="news_topic_facebook" required placeholder="หัวข้อข่าว" style="color: #0f172a; background: #ffffff;">
                                        <label style="color: #475569;">หัวข้อข่าว</label>
                                    </div>

                                    <div class="mb-0">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="form-label small fw-bold mb-0" style="color: #334155;"><i class="bx bx-edit me-1" style="color: #696cff;"></i> เนื้อหาโพสต์ (แก้ไขเพิ่มเติมได้)</label>
                                            <small class="text-muted">สามารถปรับแต่งตัวหนา ลิงก์ และย่อหน้าได้</small>
                                        </div>
                                        <div id="editor_facebook" style="height: 250px; background-color: #ffffff; color: #0f172a;" class="border rounded-3"></div>
                                        <input type="hidden" name="news_content_facebook" id="news_content_facebook_val">
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Media, Cover Photo & Album Gallery (40%) -->
                            <div class="col-lg-5">
                                <div class="card border shadow-sm rounded-3 p-3 h-100" style="background-color: #ffffff; border-color: #e2e8f0;">
                                    <h6 class="fw-bold mb-3 d-flex align-items-center" style="color: #0f172a !important;">
                                        <i class="bx bx-images me-2 fs-5" style="color: #696cff !important;"></i> สื่อรูปภาพและอัลบั้ม
                                    </h6>

                                    <label class="form-label small fw-bold text-muted d-flex justify-content-between align-items-center mb-2">
                                        <span>ภาพหน้าปกหลัก (Cover Image)</span>
                                        <span class="badge bg-label-info font-monospace rounded-pill" style="font-size: 0.72rem;">ภาพเด่น</span>
                                    </label>
                                    <div class="fb-cover-container shadow-xs mb-3">
                                        <span class="fb-cover-badge"><i class="bx bx-star text-warning me-1"></i> รูปหน้าปกข่าว</span>
                                        <img src="" id="blah_facebook" referrerpolicy="no-referrer" onerror="this.onerror=null;this.src='https://placehold.co/600x400/1877F2/ffffff?text=Facebook+Photo';">
                                        <input type="hidden" name="news_img_facebook" id="news_img_facebook_url">
                                    </div>

                                    <div id="fb_album_preview_box" class="d-none">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-label small fw-bold text-dark mb-0">
                                                <i class="bx bx-photo-album text-primary me-1"></i> รูปภาพในอัลบั้มทั้งหมด
                                            </label>
                                            <span class="badge bg-primary rounded-pill px-2" id="fb_album_count">0 รูป</span>
                                        </div>
                                        <div class="fb-thumb-grid shadow-none mb-2" id="fb_album_thumbs">
                                        </div>
                                        <div class="alert alert-info py-2 px-3 mt-2 mb-0 d-flex align-items-center gap-2 border-0 bg-primary bg-opacity-10 text-primary small rounded-3">
                                            <i class="bx bx-info-circle fs-5 flex-shrink-0"></i>
                                            <span style="font-size: 0.8rem;">คลิกรูปย่อยใดก็ได้เพื่อตั้งเป็นรูปปก ระบบจะบันทึกรูปทั้งหมดขึ้นเซิร์ฟเวอร์ให้อัตโนมัติ</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top bg-white py-3 px-4 d-flex justify-content-between align-items-center flex-shrink-0">
                    <span class="text-muted small d-none d-md-inline"><i class="bx bx-shield-check text-success me-1"></i> รูปภาพจะถูกบีบอัดและอัปโหลดไปยังคลาวด์เซิร์ฟเวอร์ให้อัตโนมัติ</span>
                    <div class="d-flex gap-2 ms-auto">
                        <button type="button" class="btn btn-outline-secondary px-4 rounded-pill" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary px-4 rounded-pill d-none shadow-sm fw-semibold d-inline-flex align-items-center gap-2" id="btn-submit-news-facebook">
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            <i class="bx bx-cloud-upload fs-5"></i> <span>บันทึกข่าวลงเว็บไซต์</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Sync News Images to Cloud -->
<div class="modal fade" id="ModalSyncNewsImages" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg border-0" style="border-radius: 18px; overflow: hidden;">
            <div class="modal-header d-flex align-items-center justify-content-between" style="background: linear-gradient(135deg, #696cff 0%, #4f46e5 100%); color: #fff; padding: 1.25rem 1.75rem;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-white p-2 d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 44px; height: 44px;">
                        <i class="bx bx-cloud-upload fs-3 text-primary"></i>
                    </div>
                    <div>
                        <h5 class="modal-title text-white fw-bold mb-0">ซิงค์รูปภาพข่าวสารเก่าขึ้น Cloud Server</h5>
                        <small class="text-white text-opacity-85">ย้ายไฟล์ภาพจากเครื่องขึ้นระบบคลาวด์เพื่อลดพื้นที่ฮาร์ดดิสก์</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" id="btn-close-sync-modal"></button>
            </div>
            <div class="modal-body p-4 bg-light bg-opacity-50">
                <!-- Status Box -->
                <div class="row g-3 mb-4">
                    <div class="col-sm-6">
                        <div class="card border shadow-xs p-3 text-center bg-white rounded-3">
                            <span class="text-muted small fw-semibold">รูปภาพในเครื่องที่ต้องซิงค์</span>
                            <h3 class="fw-bold text-primary mb-0 mt-1" id="sync-stat-count"><span class="spinner-border spinner-border-sm"></span></h3>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card border shadow-xs p-3 text-center bg-white rounded-3">
                            <span class="text-muted small fw-semibold">ขนาดพื้นที่ในเครื่องที่ใช้</span>
                            <h3 class="fw-bold text-info mb-0 mt-1" id="sync-stat-size"><span class="spinner-border spinner-border-sm"></span></h3>
                        </div>
                    </div>
                </div>

                <!-- Option Checkbox -->
                <div class="form-check form-switch mb-4 p-3 bg-white rounded-3 border">
                    <input class="form-check-input ms-0 me-3" type="checkbox" id="sync-delete-local" checked>
                    <label class="form-check-label fw-semibold text-dark" for="sync-delete-local">
                        ลบไฟล์ในเครื่องออกทันทีหลังอัปโหลดขึ้น Cloud สำเร็จ (แนะนำเพื่อคืนพื้นที่ดิสก์)
                    </label>
                    <div class="text-muted small ps-5">รูปบนเว็บไซต์จะยังคงแสดงผลได้ตามปกติผ่านลิงก์ของ Cloud Server</div>
                </div>

                <!-- Progress Area -->
                <div id="sync-progress-container" class="d-none">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fw-bold text-dark small" id="sync-progress-text">กำลังซิงค์...</span>
                        <span class="fw-bold text-primary" id="sync-progress-percent">0%</span>
                    </div>
                    <div class="progress mb-3" style="height: 14px; border-radius: 7px; background-color: #e2e8f0;">
                        <div id="sync-progress-bar" class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 0%"></div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center text-muted small bg-white p-3 rounded-3 border">
                        <span id="sync-status-detail"><i class="bx bx-loader-alt bx-spin me-1"></i> เตรียมการส่งข้อมูล...</span>
                        <span id="sync-freed-size" class="badge bg-label-success">คืนพื้นที่ได้: 0 MB</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top bg-white py-3 px-4 d-flex justify-content-between align-items-center">
                <span class="text-muted small"><i class="bx bx-shield-check text-success me-1"></i> ส่งไฟล์ชุดละ 10 รูป ป้องกันเซิร์ฟเวอร์โหลดเกิน</span>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary px-4 rounded-pill" data-bs-dismiss="modal" id="btn-cancel-sync">ปิด</button>
                    <button type="button" class="btn btn-primary px-4 rounded-pill fw-semibold shadow-sm d-flex align-items-center gap-1" id="btn-start-sync">
                        <i class="bx bx-play-circle fs-5"></i> <span>เริ่มการซิงค์</span>
                    </button>
                    <button type="button" class="btn btn-warning px-4 rounded-pill fw-semibold shadow-sm d-none d-flex align-items-center gap-1" id="btn-pause-sync">
                        <i class="bx bx-pause-circle fs-5"></i> <span>พักชั่วคราว</span>
                    </button>
                </div>
            </div>
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
    let pondAlbum;
    let quill;
    let quillFB;
    const BASE_URL = "<?= base_url() ?>";

    $(document).ready(function() {
        const observer = lozad(); // Initialize Lozad
        
        const dataTable = $('#myTable').DataTable({
            order: [[2, 'desc']],
            processing: true, // เปิดใช้งานตัว Loading ของ DataTable เอง
            deferRender: true, // เพิ่มประสิทธิภาพ: โหลดเฉพาะหน้าที่แสดง
            language: {
                search: "_INPUT_",
                searchPlaceholder: "ค้นหาข่าว...",
                processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>', // ใส่ Spinner ในตัว Loading
            },
            drawCallback: function() {
                // ทำงานทุกครั้งที่เปลี่ยนหน้า หรือค้นหา เพื่อให้ Lozad ทำงานกับรูปใหม่ๆ
                observer.observe();
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

        $('#AddNews').click(function() {
            $('#ModalNewsTitle').text('เพิ่มข่าวสารใหม่');
            $('#form-news-manage').attr('action', '<?= base_url('Admin/News/AddNews') ?>').trigger('reset');
            $('#news_id').val('');
            quill.setContents([]);
            $('#news_date').val(new Date().toISOString().slice(0, 16));
            initFilePond();
            initFilePondAlbum();
            $('#album-preview-container').html('<div class="col-12 text-center py-4 text-muted" id="no-album-msg"><i class="bx bx-image-alt display-4 d-block mb-2"></i>ยังไม่มีรูปภาพในอัลบั้ม</div>');
            
            $('#preview_container').addClass('d-none'); // Hide preview for add mode
            
            // Switch to first tab
            const tabEl = document.querySelector('button[data-bs-target="#navs-news-info"]');
            const tab = bootstrap.Tab.getOrCreateInstance(tabEl);
            tab.show();
            new bootstrap.Modal(document.getElementById("ModalNews")).show();
        });

        $(document).on("click", ".EditNews", function() {
            const newsId = $(this).attr('key-newsid');
            $('#ModalNewsTitle').text('แก้ไขข้อมูลข่าวสาร');
            $('#form-news-manage').attr('action', '<?= base_url('Admin/News/UpdateNews') ?>');
            $('#preview_container').addClass('d-none'); // Reset first
            
            $.post('<?= base_url('Admin/News/EditNews') ?>', { KeyNewsid: newsId }, function(data) {
                if(data && data[0]) {
                    const news = data[0];
                    $('#news_id').val(news.news_id);
                    $('#news_topic').val(news.news_topic);
                    $('#news_category').val(news.news_category);
                    $('#news_date').val(news.news_date.replace(' ', 'T').slice(0, 16));
                    $('#original_news_img').val(news.news_img);
                    quill.root.innerHTML = news.news_content;
                    
                    // Show current image preview if exists
                    if(news.news_img) {
                        $('#current_news_img_preview').attr('src', news.news_img_url || `${BASE_URL}/uploads/news/${news.news_img}`);
                        $('#preview_container').removeClass('d-none');
                    }

                    initFilePond(null); // Initialize empty FilePond (user uses preview to see current img)
                    initFilePondAlbum();
                    loadAlbumImages(news.news_id);
                    // Switch to first tab
                    const tabEl = document.querySelector('button[data-bs-target="#navs-news-info"]');
                    const tab = bootstrap.Tab.getOrCreateInstance(tabEl);
                    tab.show();
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

            // Append Album Files
            if (pondAlbum) {
                const albumFiles = pondAlbum.getFiles();
                albumFiles.forEach(fileItem => {
                    formData.append('news_album[]', fileItem.file);
                });
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
                                row.find('td:nth-child(1) img').attr('src', response.data.news_img_url || `${BASE_URL}/uploads/news/${response.data.news_img}`);
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

        // Helper to get safe image URL
        function getFbImageUrl(url) {
            if (!url) return '';
            // Only proxy crawler lookaside URLs; direct CDN images (fbcdn.net) load directly and rapidly with referrerpolicy="no-referrer"
            if (url.includes('lookaside.fbsbx.com')) {
                return '<?= base_url('Admin/News/ImageProxy') ?>?url=' + encodeURIComponent(url);
            }
            return url;
        }

        // Facebook Import Helper: Render Preview
        function renderFacebookPreview(data) {
            $('#fb_preview').removeClass('d-none');
            $('#btn-submit-news-facebook').removeClass('d-none');
            
            $('#news_facebook_id').val(data.id || '');
            $('#news_topic_facebook').val(data.topic || (data.message ? data.message.substr(0, 100) : ''));
            
            let dateStr = data.created_time || '';
            if (dateStr) {
                $('#news_date_facebook').val(dateStr.replace(' ', 'T').slice(0, 16));
            }
            
            let coverImg = data.cover_image || data.full_picture || '';
            if (!coverImg && data.album_images && data.album_images.length > 0) {
                coverImg = data.album_images[0];
            }

            $('#news_img_facebook_url').val(coverImg);
            if (coverImg) {
                $('#blah_facebook').attr('src', getFbImageUrl(coverImg));
            } else {
                $('#blah_facebook').attr('src', 'https://placehold.co/600x400?text=No+Cover+Image');
            }
            
            quillFB.root.innerText = data.message || '';
            
            if (data.is_saved) {
                $('#fb_already_saved_alert').removeClass('d-none');
            } else {
                $('#fb_already_saved_alert').addClass('d-none');
            }
            
            // Handle album images
            let album = data.album_images || [];
            if (album.length > 0) {
                $('#fb_album_preview_box').removeClass('d-none');
                $('#fb_album_count').text(album.length + ' รูป');
                let thumbHtml = '';
                album.forEach(imgUrl => {
                    let proxyUrl = getFbImageUrl(imgUrl);
                    thumbHtml += `<img src="${proxyUrl}" referrerpolicy="no-referrer" class="rounded border shadow-xs fb-thumb-item" data-raw="${encodeURIComponent(imgUrl)}" data-proxy="${encodeURIComponent(proxyUrl)}" style="width: 50px; height: 50px; object-fit: cover; cursor: pointer;" title="คลิกเพื่อเลือกเป็นรูปปก">`;
                });
                $('#fb_album_thumbs').html(thumbHtml);
                $('#news_album_images_facebook').val(JSON.stringify(album));
            } else {
                $('#fb_album_preview_box').addClass('d-none');
                $('#fb_album_thumbs').empty();
                $('#news_album_images_facebook').val('');
            }
        }

        // Click thumbnail to set as cover photo with visual border feedback
        $(document).on('click', '.fb-thumb-item', function() {
            let proxy = decodeURIComponent($(this).data('proxy'));
            let raw = decodeURIComponent($(this).data('raw'));
            $('#blah_facebook').attr('src', proxy);
            $('#news_img_facebook_url').val(raw);
            $('.fb-thumb-item').removeClass('border-primary border-2');
            $(this).addClass('border-primary border-2');
        });

        // Facebook Import - Reset modal when shown
        $('#ModalFacebook').on('shown.bs.modal', function() {
            $('#fb_post_url').val('').focus();
            $('#fb_preview').addClass('d-none');
            $('#btn-submit-news-facebook').addClass('d-none');
            $('#fb_already_saved_alert').addClass('d-none');
            $('#fb_album_preview_box').addClass('d-none');
            $('#fb_album_thumbs').empty();
            $('#news_album_images_facebook').val('');
            $('#news_facebook_id').val('');
            const tabUrlEl = document.querySelector('#tab-fb-url');
            if (tabUrlEl && window.bootstrap && window.bootstrap.Tab) {
                bootstrap.Tab.getOrCreateInstance(tabUrlEl).show();
            }
        });

        // Trigger fetch Facebook post by URL
        $('#btn-fetch-fb-url').click(function() {
            const url = $('#fb_post_url').val().trim();
            if (!url) {
                Swal.fire('แจ้งเตือน', 'กรุณาวางลิงก์โพสต์ Facebook ที่ต้องการนำเข้า', 'warning');
                $('#fb_post_url').focus();
                return;
            }

            const $btn = $(this);
            $btn.prop('disabled', true);
            $('#fb_url_spinner').removeClass('d-none');
            $('#fb_url_icon').addClass('d-none');
            $('#fb_already_saved_alert').addClass('d-none');

            $.ajax({
                url: '<?= base_url('Admin/News/FetchFacebookByUrl') ?>',
                type: 'POST',
                data: { url: url },
                dataType: 'json',
                success: function(res) {
                    if (res.status && res.data) {
                        renderFacebookPreview(res.data);
                        Swal.fire({
                            icon: 'success',
                            title: 'ดึงข้อมูลสำเร็จ!',
                            text: 'กรุณาตรวจสอบหัวข้อ เนื้อหา และรูปภาพก่อนกดบันทึก',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire('ไม่สามารถดึงข้อมูลได้', res.message || 'เกิดข้อผิดพลาดในการดึงข้อมูลโพสต์', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Fetch FB URL error:', error);
                    Swal.fire('ข้อผิดพลาดของระบบ', 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้ กรุณาลองใหม่อีกครั้ง', 'error');
                },
                complete: function() {
                    $btn.prop('disabled', false);
                    $('#fb_url_spinner').addClass('d-none');
                    $('#fb_url_icon').removeClass('d-none');
                }
            });
        });

        $('#fb_post_url').keypress(function(e) {
            if (e.which === 13) {
                e.preventDefault();
                $('#btn-fetch-fb-url').click();
            }
        });

        // Load posts for dropdown on tab or collapse open
        let fbRecentPostsLoaded = false;
        function loadRecentFacebookPosts() {
            if (fbRecentPostsLoaded) return;
            $('#sel_NewsFromFacebook').prop('disabled', true).html('<option value="">-- กำลังโหลดข้อมูลจาก Facebook... --</option>');
            $('#fb_loading_spinner').removeClass('d-none');

            $.post('<?= base_url('Admin/News/View/Facebook') ?>', function(data) {
                if (typeof data === 'string') {
                    try { data = JSON.parse(data); } catch(e) {}
                }
                
                if (data.error) {
                    console.error('Facebook API Error:', data.error);
                    $('#sel_NewsFromFacebook').html(`<option value="">-- เกิดข้อผิดพลาด: ${data.error.message || data.error} --</option>`);
                    $('#fb_loading_spinner').addClass('d-none');
                    return;
                }

                let options = '<option value="">-- กรุณาเลือกโพสต์ที่ต้องการ --</option>';
                if (data && data.data) {
                    data.data.forEach(item => {
                        if(item.message) {
                            let savedText = item.is_saved ? ' (บันทึกแล้ว)' : '';
                            let disabled = item.is_saved ? ' disabled style="color: #ccc;"' : '';
                            options += `<option value="${item.id}"${disabled}>${item.message.substr(0, 80)}...${savedText}</option>`;
                        }
                    });
                    $('#sel_NewsFromFacebook').html(options).prop('disabled', false);
                    fbRecentPostsLoaded = true;
                } else {
                    $('#sel_NewsFromFacebook').html('<option value="">-- ไม่พบข้อมูลโพสต์ --</option>');
                }
                $('#fb_loading_spinner').addClass('d-none');
            }).fail(function(xhr, status, error) {
                console.error('AJAX Error:', error);
                $('#sel_NewsFromFacebook').html('<option value="">-- ไม่สามารถดึงข้อมูลได้ (Server Error) --</option>');
                $('#fb_loading_spinner').addClass('d-none');
            });
        }

        $('#collapseRecentPosts').on('show.bs.collapse', loadRecentFacebookPosts);
        $('#tab-fb-recent').on('shown.bs.tab', loadRecentFacebookPosts);

        $('#sel_NewsFromFacebook').change(function() {
            const val = $(this).val();
            if(!val) return;
            $.post('<?= base_url('Admin/News/Select/Facebook') ?>', { KeyNewsFB: val }, function(data) {
                if (typeof data === 'string') {
                    try { data = JSON.parse(data); } catch(e) {}
                }

                if(data.error) {
                    Swal.fire('Error', 'ไม่สามารถดึงข้อมูลโพสต์ได้: ' + (data.error.message || data.error), 'error');
                    return;
                }

                data.topic = data.message ? data.message.substr(0, 100) : '';
                data.cover_image = data.full_picture;
                renderFacebookPreview(data);
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
                    Swal.fire({ 
                        title: 'กำลังดาวน์โหลดรูปภาพและบันทึกข้อมูล...', 
                        text: 'กรุณารอสักครู่ ระบบกำลังจัดเก็บข้อมูลและรูปภาพทั้งหมด',
                        allowOutsideClick: false, 
                        didOpen: () => { Swal.showLoading(); } 
                    });
                },
                complete: function() {
                    $('#btn-submit-news-facebook').prop('disabled', false).find('.spinner-border').addClass('d-none');
                },
                success: function(response) {
                    if(response.status) {
                        $('#ModalFacebook').modal('hide');
                        Swal.fire({ icon: 'success', title: 'สำเร็จ!', text: response.message, timer: 1500 });
                        window.location.reload();
                    } else {
                        Swal.fire('บันทึกไม่สำเร็จ', response.message || 'เกิดข้อผิดพลาดในการบันทึกข่าว', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire('เกิดข้อผิดพลาด', 'ไม่สามารถบันทึกข้อมูลได้ กรุณาลองใหม่อีกครั้ง', 'error');
                }
            });
        });

        // Delete News
        $(document).on("click", ".DeleteNews", function() {
            const newsId = $(this).attr('key-newsid');
            const $row = $(`#${newsId}`);

            Swal.fire({
                title: 'ยืนยันการลบข่าว?',
                text: "รูปภาพและเนื้อหาจะถูกลบออกจากฐานข้อมูลและเซิร์ฟเวอร์อย่างถาวร!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff3e1d',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'ใช่, ลบข้อมูลเลย',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'กำลังลบข้อมูล...',
                        text: 'กรุณารอสักครู่ ระบบกำลังลบไฟล์ภาพและข้อมูล',
                        allowOutsideClick: false,
                        didOpen: () => { Swal.showLoading(); }
                    });

                    $.post('<?= base_url('Admin/News/DeleteNews') ?>', { KeyNewsid: newsId }, function(response) {
                        if (response.status) {
                            Swal.fire({ icon: 'success', title: 'ลบเรียบร้อย!', text: response.message, timer: 1200, showConfirmButton: false });
                            $row.fadeOut(400, function() {
                                if (typeof dataTable !== 'undefined') {
                                    dataTable.row($row).remove().draw(false);
                                } else {
                                    $row.remove();
                                }
                            });
                        } else {
                            Swal.fire('ลบไม่สำเร็จ', response.message || 'เกิดข้อผิดพลาดในการลบข้อมูล', 'error');
                        }
                    }, 'json').fail(function(xhr, status, error) {
                        Swal.fire('เกิดข้อผิดพลาด', 'ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์เพื่อลบข้อมูลได้', 'error');
                    });
                }
            });
        });

        function initFilePond(imgName = null) {
            const inputElement = document.querySelector('#news_img_pond');
            if (!inputElement) return; // ป้องกัน Error ถ้าหา element ไม่เจอ

            if (pond) {
                try {
                    pond.destroy();
                } catch (e) { console.error('Error destroying FilePond:', e); }
            }
            
            let options = {
                labelIdle: 'ลากไฟล์มาวาง หรือ <span class="filepond--label-action">คลิกเพื่ออัปโหลด</span>',
                imagePreviewHeight: 150,
                credits: false,
                storeAsFile: true, // สำคัญ: เพื่อให้ส่งไฟล์ไปเป็น File object ปกติ
            };
            if (imgName) {
                options.files = [{ source: `${BASE_URL}/uploads/news/${imgName}` }];
            }
            
            try {
                pond = FilePond.create(inputElement, options);
            } catch (e) {
                console.error('Error creating FilePond:', e);
            }
        }

        function initFilePondAlbum() {
            const inputElement = document.querySelector('#news_album_pond');
            if (!inputElement) return;

            if (pondAlbum) {
                try {
                    pondAlbum.destroy();
                } catch (e) { console.error('Error destroying Album FilePond:', e); }
            }
            
            try {
                pondAlbum = FilePond.create(inputElement, {
                    labelIdle: 'ลากรูปภาพอัลบั้มมาวาง หรือ <span class="filepond--label-action">คลิกเพื่ออัปโหลด</span>',
                    imagePreviewHeight: 120,
                    allowMultiple: true,
                    acceptedFileTypes: ['image/*'],
                    credits: false,
                    storeAsFile: true
                });
            } catch (e) {
                console.error('Error creating Album FilePond:', e);
            }
        }

        function loadAlbumImages(newsId) {
            $.post('<?= base_url('Admin/News/Album/Get') ?>', { news_id: newsId }, function(data) {
                const container = $('#album-preview-container');
                container.empty();
                if (data && data.length > 0) {
                    data.forEach(img => {
                        container.append(`
                            <div class="col-md-3 col-6 album-item" id="album-img-${img.news_img_id}">
                                <div class="position-relative">
                                    <img src="${img.img_url || ('<?= base_url('uploads/news/album/') ?>/' + img.news_img_name)}" class="img-fluid rounded shadow-sm" style="height: 120px; width: 100%; object-fit: cover;">
                                    <button type="button" class="btn btn-sm btn-icon btn-danger position-absolute top-0 end-0 m-1 delete-album-img" data-img-id="${img.news_img_id}">
                                        <i class="bx bx-x"></i>
                                    </button>
                                </div>
                            </div>
                        `);
                    });
                } else {
                    container.html('<div class="col-12 text-center py-4 text-muted" id="no-album-msg"><i class="bx bx-image-alt display-4 d-block mb-2"></i>ยังไม่มีรูปภาพในอัลบั้ม</div>');
                }
            }, 'json');
        }

        $(document).on('click', '.delete-album-img', function() {
            const imgId = $(this).data('img-id');
            const btn = $(this);
            
            Swal.fire({
                title: 'ลบรูปภาพ?',
                text: "รูปภาพนี้จะถูกลบออกจากอัลบั้มอย่างถาวร",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ลบ',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('<?= base_url('Admin/News/Album/Delete') ?>', { img_id: imgId }, function(res) {
                        if (res.status) {
                            $(`#album-img-${imgId}`).fadeOut(function() {
                                $(this).remove();
                                if ($('.album-item').length === 0) {
                                    $('#album-preview-container').html('<div class="col-12 text-center py-4 text-muted" id="no-album-msg"><i class="bx bx-image-alt display-4 d-block mb-2"></i>ยังไม่มีรูปภาพในอัลบั้ม</div>');
                                }
                            });
                        }
                    }, 'json');
                }
            });
        });

        // ล้างรูปภาพที่ไม่ได้ใช้งาน
        $(document).on('click', '#CleanImages', function() {
            Swal.fire({
                title: 'ยืนยันการล้างไฟล์ขยะ?',
                text: "ระบบจะลบรูปภาพทั้งหมดที่ไม่ได้ถูกใช้งานในข่าวสารจริงๆ การกระทำนี้ไม่สามารถย้อนกลับได้",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff3e1d',
                confirmButtonText: 'ยืนยัน ลบเลย!',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'กำลังทำงาน...',
                        text: 'กรุณารอสักครู่ ระบบกำลังตรวจสอบไฟล์',
                        allowOutsideClick: false,
                        didOpen: () => { Swal.showLoading(); }
                    });

                    $.post('<?= base_url('Admin/News/CleanUnusedImages') ?>', function(response) {
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'เสร็จสิ้น!',
                                text: response.message
                            });
                        } else {
                            Swal.fire('Error', 'เกิดข้อผิดพลาดในการลบไฟล์', 'error');
                        }
                    }, 'json').fail(function() {
                        Swal.fire('Error', 'การเชื่อมต่อเซิร์ฟเวอร์ผิดพลาด', 'error');
                    });
                }
            });
        });

        // ==========================================
        // Sync Legacy News Images to Remote Cloud
        // ==========================================
        let syncFilesQueue = [];
        let syncTotalInitial = 0;
        let syncProcessedCount = 0;
        let syncTotalFreedBytes = 0;
        let isSyncRunning = false;
        const SYNC_BATCH_SIZE = 10;

        function formatBytes(bytes) {
            if (bytes === 0) return '0 MB';
            return (bytes / (1024 * 1024)).toFixed(2) + ' MB';
        }

        function loadSyncStatus() {
            $('#sync-stat-count').html('<span class="spinner-border spinner-border-sm"></span>');
            $('#sync-stat-size').html('<span class="spinner-border spinner-border-sm"></span>');

            $.get('<?= base_url('Admin/News/SyncImagesStatus') ?>', function(res) {
                if (res.status) {
                    syncFilesQueue = res.files || [];
                    syncTotalInitial = syncFilesQueue.length;
                    syncProcessedCount = 0;
                    syncTotalFreedBytes = 0;

                    $('#sync-stat-count').text(syncTotalInitial.toLocaleString() + ' รูป');
                    $('#sync-stat-size').text(res.total_size_mb + ' MB');

                    if (syncTotalInitial === 0) {
                        $('#btn-start-sync').prop('disabled', true).html('<i class="bx bx-check-circle me-1"></i> ซิงค์ครบทั้งหมดแล้ว');
                        $('#sync-status-detail').html('<span class="text-success"><i class="bx bx-check-circle me-1"></i> ไฟล์ทั้งหมดถูกซิงค์ขึ้น Cloud เรียบร้อยแล้ว</span>');
                    } else {
                        $('#btn-start-sync').prop('disabled', false).html('<i class="bx bx-play-circle me-1"></i> เริ่มการซิงค์');
                    }
                }
            }, 'json').fail(function() {
                $('#sync-stat-count').text('Error');
                $('#sync-stat-size').text('Error');
            });
        }

        $('#ModalSyncNewsImages').on('show.bs.modal', function() {
            if (!isSyncRunning) {
                $('#sync-progress-container').addClass('d-none');
                $('#btn-start-sync').removeClass('d-none');
                $('#btn-pause-sync').addClass('d-none');
                loadSyncStatus();
            }
        });

        $('#btn-start-sync').on('click', function() {
            if (syncFilesQueue.length === 0) {
                Swal.fire('แจ้งเตือน', 'ไม่มีรูปภาพที่ต้องซิงค์', 'info');
                return;
            }

            isSyncRunning = true;
            $('#sync-progress-container').removeClass('d-none');
            $('#btn-start-sync').addClass('d-none');
            $('#btn-pause-sync').removeClass('d-none');
            $('#btn-close-sync-modal, #btn-cancel-sync').prop('disabled', true);
            $('#sync-delete-local').prop('disabled', true);

            processNextSyncBatch();
        });

        $('#btn-pause-sync').on('click', function() {
            isSyncRunning = false;
            $('#btn-pause-sync').addClass('d-none');
            $('#btn-start-sync').removeClass('d-none').html('<i class="bx bx-play-circle me-1"></i> ดำเนินการต่อ');
            $('#sync-status-detail').html('<span class="text-warning"><i class="bx bx-pause-circle me-1"></i> พักการซิงค์ชั่วคราว</span>');
            $('#btn-close-sync-modal, #btn-cancel-sync').prop('disabled', false);
            $('#sync-delete-local').prop('disabled', false);
        });

        function processNextSyncBatch() {
            if (!isSyncRunning) return;

            if (syncFilesQueue.length === 0) {
                isSyncRunning = false;
                $('#sync-progress-bar').css('width', '100%').removeClass('progress-bar-animated');
                $('#sync-progress-percent').text('100%');
                $('#sync-status-detail').html('<span class="text-success"><i class="bx bx-check-circle me-1"></i> การซิงค์เสร็จสมบูรณ์ 100%!</span>');
                $('#btn-pause-sync').addClass('d-none');
                $('#btn-start-sync').removeClass('d-none').prop('disabled', true).html('<i class="bx bx-check me-1"></i> เสร็จสิ้นแล้ว');
                $('#btn-close-sync-modal, #btn-cancel-sync').prop('disabled', false);
                $('#sync-delete-local').prop('disabled', false);

                Swal.fire({
                    icon: 'success',
                    title: 'ซิงค์สำเร็จทั้งหมด!',
                    text: `ดำเนินการย้ายรูปภาพ ${syncProcessedCount.toLocaleString()} ไฟล์ขึ้น Cloud Server เรียบร้อย คืนพื้นที่ได้ ${formatBytes(syncTotalFreedBytes)}`,
                    confirmButtonText: 'ตกลง'
                }).then(() => {
                    loadSyncStatus();
                });
                return;
            }

            const batch = syncFilesQueue.splice(0, SYNC_BATCH_SIZE);
            const deleteLocal = $('#sync-delete-local').is(':checked');

            $('#sync-status-detail').html(`<i class="bx bx-loader-alt bx-spin me-1"></i> กำลังอัปโหลดชุด ${syncProcessedCount + 1} - ${syncProcessedCount + batch.length} จาก ${syncTotalInitial}...`);

            $.post('<?= base_url('Admin/News/SyncImagesBatch') ?>', {
                files: batch,
                delete_local: deleteLocal ? 1 : 0
            }, function(res) {
                if (res.status) {
                    syncProcessedCount += batch.length;
                    syncTotalFreedBytes += (res.freed_bytes || 0);

                    const percent = Math.min(100, Math.round((syncProcessedCount / syncTotalInitial) * 100));
                    $('#sync-progress-bar').css('width', percent + '%');
                    $('#sync-progress-percent').text(percent + '%');
                    $('#sync-progress-text').text(`ซิงค์แล้ว ${syncProcessedCount.toLocaleString()} / ${syncTotalInitial.toLocaleString()} รูป`);
                    $('#sync-freed-size').text('คืนพื้นที่ได้: ' + formatBytes(syncTotalFreedBytes));
                    $('#sync-stat-count').text(res.remaining_files.toLocaleString() + ' รูป');

                    if (isSyncRunning) {
                        setTimeout(processNextSyncBatch, 150);
                    }
                } else {
                    $('#sync-status-detail').html(`<span class="text-danger"><i class="bx bx-error-circle me-1"></i> เกิดข้อผิดพลาดในบางไฟล์ กำลังทำต่อ...</span>`);
                    if (isSyncRunning) {
                        setTimeout(processNextSyncBatch, 1000);
                    }
                }
            }, 'json').fail(function() {
                $('#sync-status-detail').html(`<span class="text-danger"><i class="bx bx-wifi-off me-1"></i> การเชื่อมต่อขัดข้อง พักการทำงาน</span>`);
                $('#btn-pause-sync').click();
            });
        }

        $('#ModalNews').on('hidden.bs.modal', function() {
            if (pond) pond.destroy();
            if (pondAlbum) pondAlbum.destroy();
            pond = null;
            pondAlbum = null;
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

    /* Lozad Fade-in effect */
    .lozad {
        opacity: 0;
        transition: opacity 0.3s;
    }
    .lozad[data-loaded="true"] {
        opacity: 1;
    }

    /* ตกแต่งตัว Loading ของ DataTables */
    .dataTables_wrapper .dataTables_processing {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 100%;
        height: 100%;
        margin-left: -50%;
        margin-top: -25px;
        padding-top: 20px;
        text-align: center;
        background-color: rgba(255, 255, 255, 0.8);
        z-index: 999;
        border: none;
    }
</style>
<?= $this->endSection() ?>