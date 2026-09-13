<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo d-flex align-items-center justify-content-between">
        <a href="<?= base_url('Admin/Dashboard'); ?>" class="app-brand-link d-flex align-items-center text-decoration-none">
            <span class="app-brand-logo demo">
                <img src="<?= base_url('uploads/logoSchool/LogoSKJ_4.png'); ?>" alt="SKJ Logo" style="width:32px; height:auto;">
            </span>
            <div class="app-brand-text ms-3 d-flex flex-column">
                <span class="fw-bold text-dark lh-1" style="font-size: 1.05rem;">ระบบหลังบ้าน</span>
                <span class="text-muted fw-semibold" style="font-size: 0.75rem; letter-spacing: 0.04em;">SKJ PORTAL</span>
            </div>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none text-muted">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-2">
        
        <!-- ==================== หมวดหมู่: ภาพรวม ==================== -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">ภาพรวม & บริการ</span>
        </li>

        <!-- Dashboard -->
        <li class="menu-item <?= $uri->getSegment(2) == 'Dashboard' ? "active" : "" ?>">
            <a href="<?= base_url('Admin/Dashboard'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-grid-alt"></i>
                <div data-i18n="Analytics">แดชบอร์ด (Dashboard)</div>
            </a>
        </li>

        <!-- Live Chat -->
        <li class="menu-item <?= in_array(strtolower($uri->getSegment(2) ?? ''), ['livechat', 'live-chat']) ? "active" : "" ?>">
            <a href="<?= base_url('Admin/LiveChat'); ?>" class="menu-link d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="menu-icon tf-icons bx bx-chat"></i>
                    <div data-i18n="Analytics">ศูนย์สนทนาสด</div>
                </div>
                <span class="badge bg-label-info rounded-pill px-2 py-1 ms-auto" style="font-size: 0.68rem;">Live</span>
            </a>
        </li>


        <!-- ==================== หมวดหมู่: จัดการเนื้อหาเว็บไซต์ ==================== -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">จัดการเนื้อหาเว็บไซต์</span>
        </li>

        <!-- News -->
        <li class="menu-item <?= $uri->getSegment(2) == 'News' ? "active" : "" ?>">
            <a href="<?= base_url('Admin/News'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-news"></i>
                <div data-i18n="Analytics">ข่าวประชาสัมพันธ์</div>
            </a>
        </li>

        <!-- Banner -->
        <li class="menu-item <?= $uri->getSegment(2) == 'Banner' ? "active" : "" ?>">
            <a href="<?= base_url('Admin/Banner'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-images"></i>
                <div data-i18n="Analytics">แบนเนอร์สไลด์</div>
            </a>
        </li>

        <!-- Spotlight -->
        <li class="menu-item <?= $uri->getSegment(2) == 'Spotlight' ? "active" : "" ?>">
            <a href="<?= base_url('Admin/Spotlight'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-star"></i>
                <div data-i18n="Analytics">ผลงานเด่น (Spotlight)</div>
            </a>
        </li>

        <!-- Welcome Modal -->
        <li class="menu-item <?= $uri->getSegment(2) == 'WelcomeModal' ? "active" : "" ?>">
            <a href="<?= base_url('Admin/WelcomeModal'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-bell"></i>
                <div data-i18n="Analytics">ป๊อปอัปแจ้งเตือน</div>
            </a>
        </li>

        <!-- About School Dropdown -->
        <li class="menu-item <?= $uri->getSegment(2) == 'AboutSchool' ? "active open" : "" ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-buildings"></i>
                <div data-i18n="Layouts">เกี่ยวกับโรงเรียน</div>
            </a>
            <ul class="menu-sub">
                <?php
                if ($uri->getTotalSegments() >= 4) {
                    $active = $uri->getSegment(4);
                } else {
                    $active = null;
                }
                ?>
                <?php if (!empty($AboutSchool)): ?>
                    <?php foreach ($AboutSchool as $key => $v_AboutSchool): ?>
                        <li class="menu-item <?= $active == $v_AboutSchool->id ? "active" : "" ?>">
                            <a href="<?= base_url('Admin/AboutSchool/Detail/' . $v_AboutSchool->id) ?>" class="menu-link">
                                <div data-i18n="Without menu"><?= $v_AboutSchool->about_menu ?></div>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </li>


        <!-- ==================== หมวดหมู่: บริการนักเรียน & ไอที ==================== -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">งานสารสนเทศ & ไอที</span>
        </li>
        <li class="menu-item <?= $uri->getSegment(2) == 'Student' ? "active" : "" ?>">
            <a href="<?= base_url('Admin/Student'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-wifi"></i>
                <div data-i18n="Analytics">ข้อมูลนักเรียน (Wifi / Email)</div>
            </a>
        </li>


        <!-- ==================== หมวดหมู่: ดูแลระบบ (Super Admin) ==================== -->
        <?php if (in_array('Super Admin', session('roles') ?? [])): ?>
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">ตั้งค่า & ผู้ดูแลระบบ</span>
            </li>
            <li class="menu-item <?= $uri->getSegment(2) == 'roles' ? "active" : "" ?>">
                <a href="<?= base_url('Admin/roles'); ?>" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-shield-quarter"></i>
                    <div data-i18n="Analytics">จัดการสิทธิ์ผู้ใช้งาน</div>
                </a>
            </li>
            <li class="menu-item <?= $uri->getSegment(2) == 'Logs' ? "active" : "" ?>">
                <a href="<?= base_url('Admin/Logs'); ?>" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-history"></i>
                    <div data-i18n="Analytics">บันทึกการใช้งาน (Log)</div>
                </a>
            </li>
            <li class="menu-item <?= $uri->getSegment(2) == 'Settings' ? "active" : "" ?>">
                <a href="<?= base_url('Admin/Settings'); ?>" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-cog"></i>
                    <div data-i18n="Analytics">ตั้งค่าระบบทั่วไป</div>
                </a>
            </li>
        <?php endif; ?>

        <!-- Quick View Main Site -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">หน้าเว็บไซต์หลัก</span>
        </li>
        <li class="menu-item">
            <a href="<?= base_url('/'); ?>" class="menu-link" target="_blank">
                <i class="menu-icon tf-icons bx bx-link-external text-primary"></i>
                <div data-i18n="Analytics">เปิดดูหน้าเว็บไซต์</div>
            </a>
        </li>

    </ul>
</aside>
