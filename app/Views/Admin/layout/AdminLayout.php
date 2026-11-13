<?= $this->include('Admin/layout/AdminHeader') ?>

<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->
        <?= $this->include('Admin/layout/AdminMenu', ['uri' => $uri]) ?>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->
            <?= $this->include('Admin/layout/AdminNavbar') ?>
            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <?= $this->renderSection('content') ?>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->

<?= $this->renderSection('modals') ?>

<!-- Mobile Bottom Navigation Bar (Visible only on mobile / tablet < 768px) -->
<?php 
    $activeSeg = $uri->getSegment(2) ?? '';
?>
<nav class="mobile-bottom-nav d-md-none" id="mobile-bottom-nav" aria-label="Mobile Bottom Navigation">
    <a href="<?= base_url('Admin/Dashboard') ?>" class="nav-item-mobile <?= ($activeSeg == 'Dashboard' || $activeSeg == '') ? 'active' : '' ?>">
        <i class="bx <?= ($activeSeg == 'Dashboard' || $activeSeg == '') ? 'bxs-dashboard' : 'bx-home-circle' ?>"></i>
        <span>แดชบอร์ด</span>
    </a>
    <a href="<?= base_url('Admin/News') ?>" class="nav-item-mobile <?= ($activeSeg == 'News') ? 'active' : '' ?>">
        <i class="bx <?= ($activeSeg == 'News') ? 'bxs-news' : 'bx-news' ?>"></i>
        <span>ข่าวสาร</span>
    </a>
    <div class="nav-item-mobile fab-center">
        <button type="button" class="btn-fab-action" data-bs-toggle="modal" data-bs-target="#quickActionModal" aria-label="เมนูด่วน">
            <i class="bx bx-plus"></i>
        </button>
    </div>
    <a href="<?= base_url('/') ?>" target="_blank" class="nav-item-mobile">
        <i class="bx bx-globe"></i>
        <span>หน้าเว็บ</span>
    </a>
    <a href="javascript:void(0);" class="nav-item-mobile" id="btn-toggle-mobile-menu">
        <i class="bx bx-grid-alt"></i>
        <span>เมนู</span>
    </a>
</nav>

<!-- Quick Action Sheet Modal (Mobile Bottom-Sheet) -->
<div class="modal fade modal-bottom-sheet" id="quickActionModal" tabindex="-1" aria-labelledby="quickActionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-1">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-label-primary p-2 rounded-circle">
                        <i class="bx bx-zap fs-5"></i>
                    </span>
                    <div>
                        <h6 class="modal-title fw-bold mb-0 text-dark" id="quickActionModalLabel">เมนูด่วน (Quick Actions)</h6>
                        <small class="text-muted">เข้าถึงฟังก์ชันที่ใช้งานบ่อยได้ทันที</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-3 pb-4">
                <div class="row g-3">
                    <div class="col-6">
                        <a href="<?= ($activeSeg == 'News') ? 'javascript:void(0);' : base_url('Admin/News#add') ?>" 
                           <?= ($activeSeg == 'News') ? 'data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#ModalNews"' : '' ?>
                           class="quick-action-tile">
                            <div class="icon-wrap bg-primary-soft text-primary">
                                <i class="bx bx-edit-alt"></i>
                            </div>
                            <span class="fw-bold text-dark">เพิ่มข่าวใหม่</span>
                            <small class="text-muted">เขียนข่าวประชาสัมพันธ์</small>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?= ($activeSeg == 'News') ? 'javascript:void(0);' : base_url('Admin/News#facebook') ?>"
                           <?= ($activeSeg == 'News') ? 'data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#ModalFacebook"' : '' ?>
                           class="quick-action-tile">
                            <div class="icon-wrap bg-info-soft text-info">
                                <i class="bx bxl-facebook-circle"></i>
                            </div>
                            <span class="fw-bold text-dark">ดึงข่าว Facebook</span>
                            <small class="text-muted">นำเข้าผ่านลิงก์โพสต์</small>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?= base_url('Admin/Banner') ?>" class="quick-action-tile">
                            <div class="icon-wrap bg-warning-soft text-warning">
                                <i class="bx bx-images"></i>
                            </div>
                            <span class="fw-bold text-dark">จัดการแบนเนอร์</span>
                            <small class="text-muted">ภาพสไลด์หน้าแรก</small>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?= base_url('Admin/Logs') ?>" class="quick-action-tile">
                            <div class="icon-wrap bg-secondary-soft text-secondary">
                                <i class="bx bx-history"></i>
                            </div>
                            <span class="fw-bold text-dark">บันทึกการใช้งาน</span>
                            <small class="text-muted">ตรวจสอบประวัติ Logs</small>
                        </a>
                    </div>
                </div>

                <div class="mt-3 pt-3 border-top">
                    <a href="<?= base_url('/') ?>" target="_blank" class="btn btn-outline-primary w-100 py-2 d-flex align-items-center justify-content-center gap-2 rounded-pill">
                        <i class="bx bx-globe"></i>
                        <span>เปิดดูหน้าเว็บไซต์หลัก</span>
                        <i class="bx bx-link-external small"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('Admin/layout/AdminFooter') ?>
