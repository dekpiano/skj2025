<!-- Lawa Centered Header Layout — SKJ Pink-Blue Theme with ALL Original Menus -->
<header class="main-header">

    <!-- Header Top Bar -->
    <div class="header-top d-none d-lg-block">
        <div class="container-fluid px-4 px-xl-5">
            <div class="row align-items-center">
                <div class="col-md-6 text-start">
                    <div class="top-text">
                        <i class="bi bi-clock me-2"></i>เวลาทำการ: จันทร์ - ศุกร์, 08:30 - 16:30
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <ul class="top-right-list">
                        <li><a href="mailto:skjns160@skj.ac.th"><i class="bi bi-envelope me-1"></i>
                                skjns160@skj.ac.th</a></li>
                        <li class="separator">/</li>
                        <li><a href="tel:056-200-765"><i class="bi bi-telephone me-1"></i> 056-200-765</a></li>
                        <li class="separator">/</li>
                        <li><a href="https://www.facebook.com/SKJNS160" target="_blank"><i
                                    class="bi bi-facebook"></i></a></li>
                        <li><a href="https://youtube.com/channel/UC7p4cQQuIFLyrF68p7JbWDw?si=qOHoQSymoleB3ntP"
                                target="_blank"><i class="bi bi-youtube"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Upper (Main Navigation Bar) -->
    <div class="header-upper">
        <div class="container-fluid px-0">

            <!-- Desktop Navigation: 3-column flex (LEFT | LOGO CENTER | RIGHT) -->
            <div class="header-nav-row d-none d-lg-flex">

                <!-- LEFT COLUMN -->
                <div class="nav-col nav-col-left">
                    <div class="social-icons-left">
                        <a href="https://www.facebook.com/SKJNS160" target="_blank"><i class="bi bi-facebook"></i></a>
                        <a href="https://youtube.com/channel/UC7p4cQQuIFLyrF68p7JbWDw?si=qOHoQSymoleB3ntP"
                            target="_blank"><i class="bi bi-youtube"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                    </div>
                    <ul class="nav-menu-lawa">
                        <li class="has-dropdown">
                            <a href="#"><i class="bi bi-bank me-1"></i>เกี่ยวกับ สกจ</a>
                            <ul class="sub-menu">
                                <?php foreach ($AboutSchool as $key => $v_AboutSchool): ?>
                                    <li><a href="<?= base_url('About/' . urlencode($v_AboutSchool->about_menu)) ?>"><i
                                                class="bi bi-info-circle me-2"></i><?= $v_AboutSchool->about_menu ?></a>
                                    </li>
                                <?php endforeach; ?>
                                <li><a href="<?= base_url('Board') ?>"><i
                                            class="bi bi-person-lines-fill me-2"></i>คณะกรรมการสถานศึกษา</a></li>
                                <li><a href="https://botany.skj.ac.th/"><i
                                            class="bi bi-flower1 me-2"></i>งานสวนพฤกษศาสตร์</a></li>
                            </ul>
                        </li>
                        <li class="has-dropdown has-mega">
                            <a href="#"><i class="bi bi-diagram-3-fill me-1"></i>หน่วยงานภายใน</a>
                            <div class="mega-menu">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <h6 class="mega-title"><i class="bi bi-briefcase-fill me-2"></i>ฝ่ายบริหารงาน
                                        </h6>
                                        <a href="https://academic.skj.ac.th/"><i
                                                class="bi bi-journal-bookmark-fill me-2"></i>งานวิชาการ</a>
                                        <a href="https://general.skj.ac.th/"><i
                                                class="bi bi-gear-wide-connected me-2"></i>งานทั่วไป</a>
                                        <a href="https://personnel.skj.ac.th/"><i
                                                class="bi bi-person-vcard me-2"></i>งานบุคคล</a>
                                        <a href="https://budgetplan.skj.ac.th/"><i
                                                class="bi bi-graph-up-arrow me-2"></i>งานงบประมาณและแผน</a>
                                    </div>
                                    <div class="col-lg-3">
                                        <h6 class="mega-title"><i class="bi bi-person-workspace me-2"></i>คณะผู้บริหาร
                                        </h6>
                                        <a href="<?= base_url('Personnal/Executive') ?>"><i
                                                class="bi bi-person-check-fill me-2"></i>ผู้บริหารสถานศึกษา</a>
                                    </div>
                                    <div class="col-lg-3">
                                        <h6 class="mega-title"><i
                                                class="bi bi-mortarboard-fill me-2"></i>บุคลากรสายการสอน</h6>
                                        <a href="https://personnel.skj.ac.th/directory"><b><i
                                                    class="bi bi-people-fill me-2"></i>บุคลากรทั้งหมด</b></a>
                                        <?php foreach ($Lear as $key => $v_Lear): ?>
                                            <a
                                                href="<?= base_url('Personnal/' . urlencode("สายการสอน") . '/' . str_replace(" ", "-", urlencode($v_Lear->lear_namethai))) ?>"><i
                                                    class="bi bi-book-half me-1 small"></i><?= $v_Lear->lear_namethai; ?></a>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="col-lg-3">
                                        <h6 class="mega-title"><i
                                                class="bi bi-wrench-adjustable-circle me-2"></i>สายสนับสนุน</h6>
                                        <a href="<?= base_url('Personnal/' . urlencode("สายสนับสนุน")) ?>"><b><i
                                                    class="bi bi-person-gear me-2"></i>สายสนับสนุนทั้งหมด</b></a>
                                        <?php foreach ($PosiOther as $key => $v_PosiOther): ?>
                                            <a
                                                href="<?= base_url('Personnal/' . urlencode("สายสนับสนุน") . '/' . str_replace(" ", "-", urlencode($v_PosiOther->posi_name))) ?>"><i
                                                    class="bi bi-shield-check me-1 small"></i><?= $v_PosiOther->posi_name; ?></a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- CENTER COLUMN (Logo Banner) -->
                <div class="nav-col nav-col-center">
                    <a href="<?= base_url('/'); ?>" class="logo-banner-link">
                        <div class="logo-banner-shape">
                            <img src="<?= base_url() ?>/assets/img/logo/Logo-nav.png" alt="SKJ Logo">
                            <div class="logo-banner-name">สวนกุหลาบวิทยาลัย</div>
                            <div class="logo-banner-sub">(จิรประวัติ) นครสวรรค์</div>
                        </div>
                    </a>
                </div>

                <!-- RIGHT COLUMN -->
                <div class="nav-col nav-col-right">
                    <ul class="nav-menu-lawa">
                        <li><a href="<?= base_url('News') ?>"><i class="bi bi-newspaper me-1"></i>ประชาสัมพันธ์</a></li>
                        <li><a href="<?= base_url('Course') ?>"><i class="bi bi-mortarboard-fill me-1"></i>หลักสูตร</a>
                        </li>
                        <li class="has-dropdown has-mega">
                            <a href="#"><i class="bi bi-grid-3x3-gap me-1"></i>SKJ บริการ</a>
                            <div class="mega-menu mega-menu-right">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <h6 class="mega-title"><i class="bi bi-book-half me-2"></i>นักเรียน & การเรียน
                                        </h6>
                                        <a href="https://admission.skj.ac.th/"><i
                                                class="bi bi-person-plus me-2"></i>รับสมัครนักเรียน</a>
                                        <a href="https://academic.skj.ac.th/LearningOnline"><i
                                                class="bi bi-globe me-2"></i>ห้องเรียนออนไลน์</a>
                                        <a href="https://learnsuan.skj.ac.th/"><i
                                                class="bi bi-journal-text me-2"></i>สวนกุหลาบศึกษา</a>
                                        <a href="<?= base_url('guidance') ?>"><i
                                                class="bi bi-mortarboard me-2"></i>ทุนการศึกษา</a>
                                    </div>
                                    <div class="col-lg-3">
                                        <h6 class="mega-title"><i class="bi bi-wrench-adjustable me-2"></i>ระบบจอง &
                                            แจ้งซ่อม</h6>
                                        <a href="https://general.skj.ac.th/Booking"><i
                                                class="bi bi-building-up me-2"></i>จองอาคารสถานที่</a>
                                        <a href="https://general.skj.ac.th/CarBooking"><i
                                                class="bi bi-car-front me-2"></i>จองยานพาหนะ</a>
                                        <a href="https://general.skj.ac.th/Repair"><i
                                                class="bi bi-tools me-2"></i>แจ้งซ่อมออนไลน์</a>
                                        <a href="https://general.skj.ac.th/FoodReport"><i
                                                class="bi bi-pie-chart me-2"></i>รายงานอาหาร</a>
                                    </div>
                                    <div class="col-lg-3">
                                        <h6 class="mega-title"><i class="bi bi-folder2-open me-2"></i>ข้อมูล & เอกสาร
                                        </h6>
                                        <a href="<?= base_url('Yearbook') ?>"><i
                                                class="bi bi-book me-2"></i>หนังสือรุ่นดิจิทัล</a>
                                        <a href="<?= base_url('PageGroup') ?>"><i
                                                class="bi bi-facebook me-2"></i>Facebook กลุ่ม</a>
                                        <a href="<?= base_url('Email') ?>"><i
                                                class="bi bi-envelope-at me-2"></i>อีเมลโรงเรียน</a>
                                        <a href="https://documentcenter.skj.ac.th/"><i
                                                class="bi bi-file-earmark-arrow-down me-2"></i>โหลดเอกสาร</a>
                                        <a href="https://botany.skj.ac.th/"><i
                                                class="bi bi-tree-fill me-2"></i>งานสวนพฤกษศาสตร์</a>
                                    </div>
                                    <div class="col-lg-3">
                                        <h6 class="mega-title"><i class="bi bi-trophy me-2"></i>กีฬา & อื่นๆ</h6>
                                        <a href="<?= base_url('Procurements') ?>"><i
                                                class="bi bi-cart-check me-2"></i>จัดซื้อจัดจ้าง</a>
                                        <a href="https://sites.google.com/skj.ac.th/skj68/home"><i
                                                class="bi bi-shield-check me-2"></i>ประกันคุณภาพฯ</a>
                                        <a href="https://sportbase.skj.ac.th/User/Match"><i
                                                class="bi bi-calendar-event me-2"></i>ตารางแข่งขันกีฬา</a>
                                        <a href="https://sportbase.skj.ac.th/User/Athlete"><i
                                                class="bi bi-people me-2"></i>ทำเนียบนักกีฬา</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="login-btn-wrap">
                        <div class="has-dropdown">
                            <a href="#" class="btn-login">
                                <i class="bi bi-box-arrow-in-right me-2"></i>เข้าสู่ระบบ
                            </a>
                            <ul class="sub-menu sub-menu-right">
                                <li><a href="https://student.skj.ac.th/"><i
                                            class="bi bi-person-fill me-2"></i>สำหรับนักเรียน</a></li>
                                <li><a href="https://teacher.skj.ac.th/"><i
                                            class="bi bi-person-workspace me-2"></i>สำหรับครูผู้สอน</a></li>
                                <li><a href="<?= base_url('Manager/Dashboard') ?>"><i
                                            class="bi bi-bar-chart-line-fill me-2"></i>สำหรับผู้บริหาร</a></li>
                                <li><a href="<?= base_url('Support/SupportAttendance') ?>"><i
                                            class="bi bi-person-gear me-2"></i>สำหรับฝ่ายสนับสนุน</a></li>
                                <li><a href="<?= base_url('SkjMain/googleLogin') ?>"><img
                                            src="https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png"
                                            alt="Google" width="15" height="15" class="me-2">สำหรับผู้ดูแลระบบ
                                        (Admin)</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div><!-- end header-nav-row -->

            <!-- Mobile Header (Modern App Bar) -->
            <div class="mobile-header d-flex d-lg-none align-items-center justify-content-between py-2 px-3">
                <a href="<?= base_url('/'); ?>" class="mobile-brand d-flex align-items-center text-decoration-none">
                    <img src="<?= base_url() ?>/assets/img/logo/Logo-nav.png" alt="SKJ Logo" class="mobile-logo-img">
                    <div class="ms-2 brand-text-wrap">
                        <div class="mobile-brand-text">สวนกุหลาบวิทยาลัย (จิรประวัติ)</div>
                        <div class="mobile-brand-sub">SUANKULARB WITTAYALAI NAKHON SAWAN</div>
                    </div>
                </a>

                <div class="d-flex align-items-center gap-2">
                    <!-- Quick Contact Button on Header -->
                    <a href="<?= base_url('Contact') ?>" class="btn-mobile-quick-action" title="ติดต่อเรา">
                        <i class="bi bi-telephone-fill"></i>
                    </a>

                    <!-- Drawer Menu Button -->
                    <button class="navbar-toggler-lawa" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#mobileMenuOffcanvas" aria-controls="mobileMenuOffcanvas"
                        aria-label="Toggle navigation">
                        <i class="bi bi-list fs-2 text-white"></i>
                    </button>
                </div>
            </div>

        </div>

    </div>
</header>

<!-- =========================================================================
     MOBILE FIRST: SLIDE-OVER OFFCANVAS DRAWER MENU (Smartphone Experience)
     ========================================================================= -->
<div class="offcanvas offcanvas-end mobile-offcanvas d-lg-none" tabindex="-1" id="mobileMenuOffcanvas"
    aria-labelledby="mobileMenuOffcanvasLabel">
    <!-- Offcanvas Header -->
    <div class="offcanvas-header mobile-offcanvas-header">
        <div class="d-flex align-items-center gap-2">
            <img src="<?= base_url() ?>/assets/img/logo/Logo-nav.png" alt="SKJ" height="38">
            <div>
                <h6 class="offcanvas-title fw-bold text-white mb-0" id="mobileMenuOffcanvasLabel">เมนูหลัก (SKJ Menu)
                </h6>
                <small class="text-white-50" style="font-size: 11px;">โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ)</small>
            </div>
        </div>
        <button type="button" class="btn-close-custom" data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <!-- Offcanvas Body -->
    <div class="offcanvas-body mobile-offcanvas-body px-3 py-2">
        <!-- Quick Action Short Pills on Mobile -->
        <div class="mobile-quick-shortcuts mb-3">
            <a href="https://admission.skj.ac.th/" target="_blank" class="quick-pill">
                <i class="bi bi-person-plus-fill text-pink"></i>
                <span>รับสมัคร</span>
            </a>
            <a href="https://academic.skj.ac.th/LearningOnline" target="_blank" class="quick-pill">
                <i class="bi bi-globe text-info"></i>
                <span>ห้องเรียน</span>
            </a>
            <a href="<?= base_url('News') ?>" class="quick-pill">
                <i class="bi bi-newspaper text-warning"></i>
                <span>ข่าวสาร</span>
            </a>
            <a href="<?= base_url('Contact') ?>" class="quick-pill">
                <i class="bi bi-geo-alt-fill text-success"></i>
                <span>ติดต่อเรา</span>
            </a>
        </div>

        <ul class="mobile-nav-menu">
            <li>
                <a href="<?= base_url('/') ?>" class="mob-menu-link">
                    <span class="icon-wrap bg-primary-soft"><i class="bi bi-house-door-fill"></i></span>
                    <span>หน้าแรก</span>
                </a>
            </li>

            <!-- เกี่ยวกับ สกจ -->
            <li class="mob-dropdown">
                <a href="#" class="mob-toggle mob-menu-link">
                    <span class="icon-wrap bg-pink-soft"><i class="bi bi-bank2"></i></span>
                    <span>เกี่ยวกับ สกจ</span>
                </a>
                <ul class="mob-sub">
                    <?php foreach ($AboutSchool as $key => $v_AboutSchool): ?>
                        <li><a href="<?= base_url('About/' . urlencode($v_AboutSchool->about_menu)) ?>">
                                <i class="bi bi-info-circle me-2"></i><?= $v_AboutSchool->about_menu ?></a>
                        </li>
                    <?php endforeach; ?>
                    <li><a href="<?= base_url('Board') ?>"><i
                                class="bi bi-person-lines-fill me-2"></i>คณะกรรมการสถานศึกษา</a></li>
                    <li><a href="https://botany.skj.ac.th/"><i class="bi bi-flower1 me-2"></i>งานสวนพฤกษศาสตร์</a></li>
                </ul>
            </li>

            <!-- หน่วยงานภายใน -->
            <li class="mob-dropdown">
                <a href="#" class="mob-toggle mob-menu-link">
                    <span class="icon-wrap bg-blue-soft"><i class="bi bi-diagram-3-fill"></i></span>
                    <span>หน่วยงานภายใน</span>
                </a>
                <ul class="mob-sub">
                    <li class="mob-sub-header"><i class="bi bi-briefcase-fill me-2"></i>ฝ่ายบริหารงาน</li>
                    <li><a href="https://academic.skj.ac.th/"><i
                                class="bi bi-journal-bookmark-fill me-2"></i>งานวิชาการ</a></li>
                    <li><a href="https://general.skj.ac.th/"><i class="bi bi-gear-wide-connected me-2"></i>งานทั่วไป</a>
                    </li>
                    <li><a href="https://personnel.skj.ac.th/"><i class="bi bi-person-vcard me-2"></i>งานบุคคล</a></li>
                    <li><a href="https://budgetplan.skj.ac.th/"><i
                                class="bi bi-graph-up-arrow me-2"></i>งานงบประมาณและแผน</a></li>

                    <li class="mob-sub-header"><i class="bi bi-person-workspace me-2"></i>คณะผู้บริหาร</li>
                    <li><a href="<?= base_url('Personnal/Executive') ?>"><i
                                class="bi bi-person-check-fill me-2"></i>ผู้บริหารสถานศึกษา</a></li>

                    <!-- บุคลากรสายการสอน (Sub-Dropdown) -->
                    <li class="mob-dropdown mob-sub-dropdown">
                        <a href="#" class="mob-toggle"><i class="bi bi-mortarboard-fill me-2"></i>บุคลากรสายการสอน</a>
                        <ul class="mob-sub">
                            <li><a href="https://personnel.skj.ac.th/directory"><b><i
                                            class="bi bi-people-fill me-2"></i>บุคลากรทั้งหมด</b></a></li>
                            <?php foreach ($Lear as $key => $v_Lear): ?>
                                <li><a
                                        href="<?= base_url('Personnal/' . urlencode("สายการสอน") . '/' . str_replace(" ", "-", urlencode($v_Lear->lear_namethai))) ?>"><i
                                            class="bi bi-book-half me-1 small"></i><?= $v_Lear->lear_namethai; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>

                    <!-- สายสนับสนุน (Sub-Dropdown) -->
                    <li class="mob-dropdown mob-sub-dropdown">
                        <a href="#" class="mob-toggle"><i
                                class="bi bi-wrench-adjustable-circle me-2"></i>สายสนับสนุน</a>
                        <ul class="mob-sub">
                            <li><a href="<?= base_url('Personnal/' . urlencode("สายสนับสนุน")) ?>"><b><i
                                            class="bi bi-person-gear me-2"></i>สายสนับสนุนทั้งหมด</b></a></li>
                            <?php foreach ($PosiOther as $key => $v_PosiOther): ?>
                                <li><a
                                        href="<?= base_url('Personnal/' . urlencode("สายสนับสนุน") . '/' . str_replace(" ", "-", urlencode($v_PosiOther->posi_name))) ?>"><i
                                            class="bi bi-shield-check me-1 small"></i><?= $v_PosiOther->posi_name; ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                </ul>
            </li>

            <li>
                <a href="<?= base_url('News') ?>" class="mob-menu-link">
                    <span class="icon-wrap bg-warning-soft"><i class="bi bi-newspaper"></i></span>
                    <span>ประชาสัมพันธ์ & ข่าวสาร</span>
                </a>
            </li>

            <li>
                <a href="<?= base_url('Course') ?>" class="mob-menu-link">
                    <span class="icon-wrap bg-purple-soft"><i class="bi bi-mortarboard-fill"></i></span>
                    <span>หลักสูตรสถานศึกษา</span>
                </a>
            </li>

            <!-- SKJ บริการ -->
            <li class="mob-dropdown">
                <a href="#" class="mob-toggle mob-menu-link">
                    <span class="icon-wrap bg-teal-soft"><i class="bi bi-grid-3x3-gap-fill"></i></span>
                    <span>SKJ บริการออนไลน์</span>
                </a>
                <ul class="mob-sub">
                    <li class="mob-sub-header"><i class="bi bi-book-half me-2"></i>นักเรียน & การเรียน</li>
                    <li><a href="https://admission.skj.ac.th/"><i
                                class="bi bi-person-plus me-2"></i>รับสมัครนักเรียน</a></li>
                    <li><a href="https://academic.skj.ac.th/LearningOnline"><i
                                class="bi bi-globe me-2"></i>ห้องเรียนออนไลน์</a></li>
                    <li><a href="https://learnsuan.skj.ac.th/"><i class="bi bi-journal-text me-2"></i>สวนกุหลาบศึกษา</a>
                    </li>
                    <li><a href="<?= base_url('guidance') ?>"><i class="bi bi-mortarboard me-2"></i>ทุนการศึกษา</a></li>

                    <li class="mob-sub-header"><i class="bi bi-wrench-adjustable me-2"></i>ระบบจอง & แจ้งซ่อม</li>
                    <li><a href="https://general.skj.ac.th/Booking"><i
                                class="bi bi-building-up me-2"></i>จองอาคารสถานที่</a></li>
                    <li><a href="https://general.skj.ac.th/CarBooking"><i
                                class="bi bi-car-front me-2"></i>จองยานพาหนะ</a></li>
                    <li><a href="https://general.skj.ac.th/Repair"><i class="bi bi-tools me-2"></i>แจ้งซ่อมออนไลน์</a>
                    </li>
                    <li><a href="https://general.skj.ac.th/FoodReport"><i
                                class="bi bi-pie-chart me-2"></i>รายงานอาหาร</a></li>

                    <li class="mob-sub-header"><i class="bi bi-folder2-open me-2"></i>ข้อมูล & เอกสาร</li>
                    <li><a href="<?= base_url('Yearbook') ?>"><i class="bi bi-book me-2"></i>หนังสือรุ่นดิจิทัล</a></li>
                    <li><a href="<?= base_url('PageGroup') ?>"><i class="bi bi-facebook me-2"></i>Facebook กลุ่ม</a>
                    </li>
                    <li><a href="<?= base_url('Email') ?>"><i class="bi bi-envelope-at me-2"></i>อีเมลโรงเรียน</a></li>
                    <li><a href="https://documentcenter.skj.ac.th/"><i
                                class="bi bi-file-earmark-arrow-down me-2"></i>โหลดเอกสาร</a></li>
                    <li><a href="https://botany.skj.ac.th/"><i class="bi bi-tree-fill me-2"></i>งานสวนพฤกษศาสตร์</a>
                    </li>

                    <li class="mob-sub-header"><i class="bi bi-trophy me-2"></i>กีฬา & อื่นๆ</li>
                    <li><a href="<?= base_url('Procurements') ?>"><i
                                class="bi bi-cart-check me-2"></i>จัดซื้อจัดจ้าง</a></li>
                    <li><a href="https://sites.google.com/skj.ac.th/skj68/home"><i
                                class="bi bi-shield-check me-2"></i>ประกันคุณภาพฯ</a></li>
                    <li><a href="https://sportbase.skj.ac.th/User/Match"><i
                                class="bi bi-calendar-event me-2"></i>ตารางแข่งขันกีฬา</a></li>
                    <li><a href="https://sportbase.skj.ac.th/User/Athlete"><i
                                class="bi bi-people me-2"></i>ทำเนียบนักกีฬา</a></li>
                </ul>
            </li>

            <!-- เข้าสู่ระบบ -->
            <li class="mob-dropdown">
                <a href="#" class="mob-toggle mob-menu-link">
                    <span class="icon-wrap bg-danger-soft"><i class="bi bi-box-arrow-in-right"></i></span>
                    <span>เข้าสู่ระบบ (Portals)</span>
                </a>
                <ul class="mob-sub">
                    <li><a href="https://student.skj.ac.th/"><i class="bi bi-person-fill me-2"></i>สำหรับนักเรียน</a>
                    </li>
                    <li><a href="https://teacher.skj.ac.th/"><i
                                class="bi bi-person-workspace me-2"></i>สำหรับครูผู้สอน</a></li>
                    <li><a href="<?= base_url('Manager/Dashboard') ?>"><i
                                class="bi bi-bar-chart-line-fill me-2"></i>สำหรับผู้บริหาร</a></li>
                    <li><a href="<?= base_url('Support/SupportAttendance') ?>"><i
                                class="bi bi-person-gear me-2"></i>สำหรับฝ่ายสนับสนุน</a></li>
                </ul>
            </li>

            <li>
                <a href="<?= base_url('Contact') ?>" class="mob-menu-link">
                    <span class="icon-wrap bg-success-soft"><i class="bi bi-telephone-inbound-fill"></i></span>
                    <span>ติดต่อโรงเรียน</span>
                </a>
            </li>

            <!-- Mobile Contact Info & Social -->
            <li class="mt-4 pt-3 border-top border-white-15">
                <div class="text-white-50 small mb-2 text-center"
                    style="font-size: 12px; color: rgba(255, 255, 255, 0.75) !important;">
                    <div class="mb-1"><i class="bi bi-clock me-1"></i> เวลาทำการ: จันทร์ - ศุกร์, 08:30 - 16:30</div>
                    <div><i class="bi bi-envelope me-1"></i> skjns160@skj.ac.th <span class="mx-1">|</span> <i
                            class="bi bi-telephone me-1"></i> 056-200-765</div>
                </div>
                <div class="social-icons-left mobile-social mt-2">
                    <a href="https://www.facebook.com/SKJNS160" target="_blank"><i class="bi bi-facebook"></i></a>
                    <a href="https://youtube.com/channel/UC7p4cQQuIFLyrF68p7JbWDw?si=qOHoQSymoleB3ntP"
                        target="_blank"><i class="bi bi-youtube"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                </div>

                <!-- Discreet Admin Google Login at the very bottom -->
                <div class="text-center mt-4 pt-2 border-top border-white-10">
                    <a href="<?= base_url('SkjMain/googleLogin') ?>"
                        class="text-decoration-none d-inline-flex align-items-center gap-2 py-1 px-2 rounded"
                        style="font-size: 11px; color: rgba(255, 255, 255, 0.45); background: rgba(0, 0, 0, 0.15); transition: all 0.2s;"
                        onmouseover="this.style.color='rgba(255,255,255,0.95)'; this.style.background='rgba(0,0,0,0.3)';"
                        onmouseout="this.style.color='rgba(255,255,255,0.45)'; this.style.background='rgba(0,0,0,0.15)';">
                        <img src="https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png" alt="Google"
                            width="13" height="13">
                        <span>เข้าสู่ระบบ Admin ด้วย Google</span>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</div>

<!-- =========================================================================
     MOBILE FIRST: FLOATING BOTTOM NAVIGATION BAR (Smartphones only)
     ========================================================================= -->
<?php
$uriObj = service('uri');
$curSeg = $uriObj->getSegment(1);
?>
<nav class="mobile-bottom-nav d-flex d-lg-none" aria-label="แถบเมนูล่าง">
    <a href="<?= base_url('/') ?>" class="bottom-nav-item <?= ($curSeg == '' || $curSeg == 'Home') ? 'active' : '' ?>">
        <div class="nav-icon-box">
            <i class="bi bi-house-door-fill"></i>
        </div>
        <span>หน้าแรก</span>
    </a>

    <a href="<?= base_url('News') ?>" class="bottom-nav-item <?= ($curSeg == 'News') ? 'active' : '' ?>">
        <div class="nav-icon-box">
            <i class="bi bi-newspaper"></i>
        </div>
        <span>ข่าวสาร</span>
    </a>

    <!-- Center Highlight Button: Services Sheet -->
    <a href="javascript:void(0);" class="bottom-nav-item bottom-nav-highlight" data-bs-toggle="offcanvas"
        data-bs-target="#mobileServicesSheet" aria-controls="mobileServicesSheet">
        <div class="nav-icon-box-highlight">
            <i class="bi bi-grid-fill"></i>
        </div>
        <span>บริการ</span>
    </a>

    <a href="javascript:void(0);" class="bottom-nav-item"
        onclick="if(typeof toggleChatWindow === 'function'){toggleChatWindow();}else{window.location.href='<?= base_url('Contact') ?>';}"
        title="ช่องแชท">
        <div class="nav-icon-box">
            <i class="bi bi-chat-dots-fill"></i>
        </div>
        <span>ช่องแชท</span>
    </a>

    <a href="javascript:void(0);" class="bottom-nav-item" data-bs-toggle="offcanvas"
        data-bs-target="#mobileMenuOffcanvas" aria-controls="mobileMenuOffcanvas">
        <div class="nav-icon-box">
            <i class="bi bi-list"></i>
        </div>
        <span>เมนู</span>
    </a>
</nav>

<!-- =========================================================================
     MOBILE FIRST: SERVICES BOTTOM SHEET (Quick App-like Grid)
     ========================================================================= -->
<div class="offcanvas offcanvas-bottom mobile-sheet-services d-lg-none" tabindex="-1" id="mobileServicesSheet"
    aria-labelledby="mobileServicesSheetLabel">
    <div class="sheet-drag-handle"></div>
    <div class="offcanvas-header pb-2 pt-2 px-3 border-bottom">
        <div class="d-flex align-items-center gap-2">
            <div class="services-header-icon"><i class="bi bi-grid-3x3-gap-fill text-primary"></i></div>
            <div>
                <h6 class="offcanvas-title fw-bold mb-0" id="mobileServicesSheetLabel" style="font-size: 15px;">
                    บริการออนไลน์ (SKJ Services)</h6>
                <small class="text-muted" style="font-size: 11px;">ระบบบริการและสารสนเทศโรงเรียน</small>
            </div>
        </div>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body px-3 py-3" style="overflow-y: auto;">

        <!-- หมวด 1: นักเรียน & การเรียน -->
        <div class="sheet-category-title"><i class="bi bi-mortarboard-fill text-primary me-1"></i> นักเรียน & การเรียน
        </div>
        <div class="services-app-grid mb-3">
            <a href="https://admission.skj.ac.th/" target="_blank" class="service-app-card">
                <div class="service-icon-circle bg-pink-grad"><i class="bi bi-person-plus-fill"></i></div>
                <div class="service-label">รับสมัครนักเรียน</div>
            </a>
            <a href="https://academic.skj.ac.th/LearningOnline" target="_blank" class="service-app-card">
                <div class="service-icon-circle bg-blue-grad"><i class="bi bi-globe"></i></div>
                <div class="service-label">ห้องเรียนออนไลน์</div>
            </a>
            <a href="https://learnsuan.skj.ac.th/" target="_blank" class="service-app-card">
                <div class="service-icon-circle bg-teal-grad"><i class="bi bi-journal-text"></i></div>
                <div class="service-label">สวนกุหลาบศึกษา</div>
            </a>
            <a href="<?= base_url('guidance') ?>" class="service-app-card">
                <div class="service-icon-circle bg-indigo-grad"><i class="bi bi-mortarboard"></i></div>
                <div class="service-label">ทุนการศึกษา</div>
            </a>
        </div>

        <!-- หมวด 2: ระบบจอง & แจ้งซ่อม -->
        <div class="sheet-category-title"><i class="bi bi-wrench-adjustable text-warning me-1"></i> ระบบจอง & แจ้งซ่อม
        </div>
        <div class="services-app-grid mb-3">
            <a href="https://general.skj.ac.th/Booking" target="_blank" class="service-app-card">
                <div class="service-icon-circle bg-purple-grad"><i class="bi bi-building-up"></i></div>
                <div class="service-label">จองอาคารสถานที่</div>
            </a>
            <a href="https://general.skj.ac.th/CarBooking" target="_blank" class="service-app-card">
                <div class="service-icon-circle bg-amber-grad"><i class="bi bi-car-front"></i></div>
                <div class="service-label">จองยานพาหนะ</div>
            </a>
            <a href="https://general.skj.ac.th/Repair" target="_blank" class="service-app-card">
                <div class="service-icon-circle bg-rose-grad"><i class="bi bi-tools"></i></div>
                <div class="service-label">แจ้งซ่อมออนไลน์</div>
            </a>
            <a href="https://general.skj.ac.th/FoodReport" target="_blank" class="service-app-card">
                <div class="service-icon-circle bg-emerald-grad"><i class="bi bi-pie-chart-fill"></i></div>
                <div class="service-label">รายงานอาหาร</div>
            </a>
        </div>

        <!-- หมวด 3: ข้อมูล & เอกสาร -->
        <div class="sheet-category-title"><i class="bi bi-folder2-open text-info me-1"></i> ข้อมูล & เอกสาร</div>
        <div class="services-app-grid mb-3">
            <a href="<?= base_url('Yearbook') ?>" class="service-app-card">
                <div class="service-icon-circle bg-blue-grad"><i class="bi bi-book-half"></i></div>
                <div class="service-label">หนังสือรุ่นดิจิทัล</div>
            </a>
            <a href="<?= base_url('PageGroup') ?>" class="service-app-card">
                <div class="service-icon-circle bg-indigo-grad"><i class="bi bi-facebook"></i></div>
                <div class="service-label">Facebook กลุ่ม</div>
            </a>
            <a href="<?= base_url('Email') ?>" class="service-app-card">
                <div class="service-icon-circle bg-pink-grad"><i class="bi bi-envelope-at-fill"></i></div>
                <div class="service-label">อีเมลโรงเรียน</div>
            </a>
            <a href="https://documentcenter.skj.ac.th/" target="_blank" class="service-app-card">
                <div class="service-icon-circle bg-rose-grad"><i class="bi bi-file-earmark-arrow-down-fill"></i></div>
                <div class="service-label">โหลดเอกสาร</div>
            </a>
            <a href="https://botany.skj.ac.th/" class="service-app-card">
                <div class="service-icon-circle bg-emerald-grad"><i class="bi bi-tree-fill"></i></div>
                <div class="service-label">สวนพฤกษศาสตร์</div>
            </a>
        </div>

        <!-- หมวด 4: กีฬา & งานบริการอื่นๆ -->
        <div class="sheet-category-title"><i class="bi bi-trophy-fill text-danger me-1"></i> กีฬา & บริการอื่นๆ</div>
        <div class="services-app-grid">
            <a href="<?= base_url('Procurements') ?>" class="service-app-card">
                <div class="service-icon-circle bg-amber-grad"><i class="bi bi-cart-check-fill"></i></div>
                <div class="service-label">จัดซื้อจัดจ้าง</div>
            </a>
            <a href="https://sites.google.com/skj.ac.th/skj68/home" target="_blank" class="service-app-card">
                <div class="service-icon-circle bg-teal-grad"><i class="bi bi-shield-check"></i></div>
                <div class="service-label">ประกันคุณภาพฯ</div>
            </a>
            <a href="https://sportbase.skj.ac.th/User/Match" target="_blank" class="service-app-card">
                <div class="service-icon-circle bg-purple-grad"><i class="bi bi-calendar-event"></i></div>
                <div class="service-label">ตารางแข่งขันกีฬา</div>
            </a>
            <a href="https://sportbase.skj.ac.th/User/Athlete" target="_blank" class="service-app-card">
                <div class="service-icon-circle bg-blue-grad"><i class="bi bi-people-fill"></i></div>
                <div class="service-label">ทำเนียบนักกีฬา</div>
            </a>
        </div>

    </div>
</div>

<style>
    /* ================================================================
   SKJ LAWA HEADER — PINK-BLUE GRADIENT — CENTERED LOGO
   ================================================================ */

    .main-header {
        position: relative;
        z-index: 1040;
        font-family: 'K2D', 'Sarabun', sans-serif;
    }

    /* ---- Top Bar ---- */
    .header-top {
        background: #ffffff;
        padding: 10px 0;
        font-size: 13px;
        color: #249ffd;
        border-bottom: 1px solid rgba(251, 126, 156, 0.15);
    }

    .header-top .top-text {
        font-weight: 600;
        color: #fb7e9c;
    }

    .header-top .top-text i {
        color: #249ffd;
    }

    .header-top .top-right-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
    }

    .header-top .top-right-list a {
        color: #249ffd;
        text-decoration: none;
        transition: color 0.3s;
        font-weight: 500;
    }

    .header-top .top-right-list a:hover {
        color: #fb7e9c;
    }

    .header-top .separator {
        color: rgba(36, 159, 253, 0.3);
    }

    /* ---- Header Upper (Gradient Bar) ---- */
    .header-upper {
        background: linear-gradient(135deg, #fb7e9c 0%, #c98ddb 40%, #7db5f0 70%, #249ffd 100%);
        position: relative;
        transition: all 0.3s ease;
        border-radius: 20px;
        /* ขอบมน */
        box-shadow: 0 15px 35px rgba(36, 159, 253, 0.25);
        /* เงา */
        margin: 15px 25px;
        /* ลอยขึ้นมานิดหน่อยจากขอบ */
    }

    /* Sticky Header Scroll Effect */
    @keyframes headerSlideDown {
        0% {
            transform: translateY(-100%);
        }

        100% {
            transform: translateY(0);
        }
    }

    .header-upper.is-sticky {
        position: fixed;
        top: 10px;
        /* ห่างจากขอบบนเวลาม้วนลง */
        left: 25px;
        width: calc(100% - 50px);
        z-index: 1060;
        background: linear-gradient(135deg, #fb7e9c 0%, #c98ddb 50%, #249ffd 100%);
        box-shadow: 0 15px 40px rgba(36, 159, 253, 0.35);
        /* เงาเข้มขึ้นตอน sticky */
        animation: headerSlideDown 0.4s ease forwards;
        border-radius: 20px;
        margin: 0;
        /* reset margin เพราะใช้ top/left แล้ว */
    }

    .header-upper.is-sticky .header-nav-row {
        min-height: 70px;
        /* Reduce total navbar row height on scroll */
    }

    .header-upper.is-sticky .logo-banner-shape {
        width: 140px;
        /* Make banner narrower on scroll */
        height: 110px;
        /* Shrink logo banner height on scroll */
        padding-top: 8px;
    }

    .header-upper.is-sticky .logo-banner-shape img {
        height: 35px;
        /* Shrink logo image */
        margin-bottom: 2px;
    }

    .header-upper.is-sticky .logo-banner-name {
        font-size: 10px;
        /* Smaller text on scroll */
    }

    .header-upper.is-sticky .logo-banner-sub {
        font-size: 8px;
        /* ย่อขนาดแต่ยังแสดงอยู่ */
    }

    .header-upper.is-sticky .nav-menu-lawa>li>a {
        padding: 22px 14px;
        /* Shorter padding on scroll */
        font-size: 15px;
        /* Slightly smaller text on scroll */
    }

    .header-upper.is-sticky .btn-login {
        padding: 6px 14px;
        /* Smaller button on scroll */
        font-size: 12px;
    }

    .header-upper.is-sticky .social-icons-left a {
        font-size: 15px;
        /* Smaller icons on scroll */
    }

    /* ---- 3-Column Flex Layout: LEFT | CENTER-LOGO | RIGHT ---- */
    .header-nav-row {
        display: flex;
        align-items: stretch;
        /* all columns same height */
        justify-content: center;
        min-height: 80px;
        /* Reduced default height */
    }

    .nav-col {
        display: flex;
        align-items: center;
    }

    /* Left and Right columns take equal width, pushing logo to exact center */
    .nav-col-left {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        /* Align menus towards center logo */
        padding-left: 25px;
    }

    .nav-col-right {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        /* Align menus towards center logo */
        padding-right: 25px;
    }

    /* Center column: fixed width for the logo banner */
    .nav-col-center {
        flex: 0 0 180px;
        justify-content: center;
        position: relative;
    }

    /* ---- Logo Banner (Pentagon shape) ---- */
    .logo-banner-link {
        text-decoration: none;
        display: block;
    }

    .logo-banner-shape {
        width: 180px;
        height: 170px;
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.25) 0%, rgba(255, 255, 255, 0.05) 100%);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        clip-path: polygon(0 0, 100% 0, 100% 75%, 50% 100%, 0 75%);
        /* ปรับทรงให้สวยขึ้นนิดหน่อย */
        display: flex;
        flex-direction: column;
        align-items: center;
        padding-top: 15px;
        transition: all 0.3s ease;
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        z-index: 10;
    }

    .logo-banner-shape img {
        height: 60px;
        margin-bottom: 5px;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.15));
    }

    .logo-banner-name {
        color: #fb7e9c;
        /* Pink (ชมพู) */
        font-size: 15px;
        font-weight: 800;
        letter-spacing: 0.5px;
        text-align: center;
        line-height: 1.3;
        /* สร้างขอบขาวและรัศมีแสงสีขาว (Halo) เพื่อดันตัวหนังสือให้ลอยออกจากพื้นหลังโปร่งใส */
        text-shadow:
            -1.5px -1.5px 0 #fff,
            1.5px -1.5px 0 #fff,
            -1.5px 1.5px 0 #fff,
            1.5px 1.5px 0 #fff,
            0 0 10px #fff,
            0 0 20px #fff;
    }

    .logo-banner-sub {
        color: #249ffd;
        /* Blue (ฟ้า) */
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.5px;
        text-align: center;
        margin-top: 2px;
        text-shadow:
            -1px -1px 0 #fff,
            1px -1px 0 #fff,
            -1px 1px 0 #fff,
            1px 1px 0 #fff,
            0 0 8px #fff,
            0 0 15px #fff;
    }

    /* ---- Social Icons ---- */
    .social-icons-left {
        display: flex;
        gap: 18px;
        flex-shrink: 0;
        margin-right: auto;
        /* Push social icons to the far left */
    }

    .social-icons-left a {
        color: rgba(255, 255, 255, 0.8);
        font-size: 18px;
        /* Larger icons */
        transition: all 0.3s;
    }

    .social-icons-left a:hover {
        color: #fff;
        transform: scale(1.15);
    }

    /* ---- Nav Menu Items ---- */
    .nav-menu-lawa {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        gap: 15px;
        /* More gap between items */
    }

    .nav-menu-lawa>li {
        position: relative;
    }

    .nav-menu-lawa>li.has-mega {
        position: static;
    }

    .nav-menu-lawa>li>a {
        color: rgba(255, 255, 255, 0.9);
        font-weight: 700;
        /* Bolder font */
        font-size: 16px;
        /* Increased font-size from 14px */
        text-decoration: none;
        transition: all 0.3s;
        padding: 30px 16px;
        /* Reduced height/padding */
        display: block;
        white-space: nowrap;
        position: relative;
    }

    .nav-menu-lawa>li>a::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 16px;
        right: 16px;
        height: 3px;
        background: #fff;
        border-radius: 3px 3px 0 0;
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .nav-menu-lawa>li:hover>a {
        color: #fff;
    }

    .nav-menu-lawa>li:hover>a::after {
        transform: scaleX(1);
    }

    /* ---- Standard Sub-Menu Dropdown ---- */
    .sub-menu {
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%) translateY(15px);
        min-width: 280px;
        background: #fff;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        border-top: 3px solid #fb7e9c;
        border-radius: 0 0 10px 10px;
        padding: 10px 0;
        list-style: none;
        margin: 0;
        visibility: hidden;
        opacity: 0;
        transition: all 0.3s ease;
        z-index: 1060;
    }

    .sub-menu-right {
        left: auto;
        right: 0;
        transform: translateY(15px);
    }

    .has-dropdown:hover>.sub-menu {
        visibility: visible;
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }

    .has-dropdown:hover>.sub-menu-right {
        transform: translateY(0);
    }

    .sub-menu li a {
        display: flex;
        align-items: center;
        padding: 11px 22px;
        color: #334155;
        font-weight: 600;
        font-size: 15px;
        text-decoration: none;
        transition: all 0.3s;
        border-bottom: 1px solid #f1f5f9;
        white-space: nowrap;
    }

    .sub-menu li a i {
        font-size: 17px;
    }

    .sub-menu li:last-child a {
        border-bottom: none;
    }

    .sub-menu li a:hover {
        color: #fb7e9c;
        background: #fff5f7;
        padding-left: 28px;
    }

    /* ---- Mega Menu (Positioned dead-center of the entire navbar container) ---- */
    .mega-menu {
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%) translateY(15px);
        width: calc(100% - 40px);
        max-width: 1200px;
        min-width: 800px;
        background: #fff;
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.18);
        border-top: 3px solid #ec4899;
        border-radius: 0 0 16px 16px;
        padding: 28px 35px;
        visibility: hidden;
        opacity: 0;
        transition: all 0.3s ease;
        z-index: 1060;
    }

    .has-mega:hover>.mega-menu {
        visibility: visible;
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }

    .mega-title {
        font-weight: 800;
        color: #0f172a;
        font-size: 15.5px;
        margin-bottom: 14px;
        padding-bottom: 8px;
        border-bottom: 2.5px solid #fb7e9c;
        display: inline-flex;
        align-items: center;
    }

    .mega-title i {
        font-size: 17px;
        color: #fb7e9c;
    }

    .mega-menu a {
        display: flex;
        align-items: center;
        padding: 8px 0;
        color: #475569;
        font-weight: 600;
        font-size: 14.5px;
        text-decoration: none;
        transition: all 0.2s;
    }

    .mega-menu a i {
        font-size: 16px;
    }

    .mega-menu a:hover {
        color: #fb7e9c;
        padding-left: 6px;
    }

    /* ---- Login Button ---- */
    .login-btn-wrap {
        flex-shrink: 0;
        margin-left: auto;
        /* Push login button to the far right */
        padding-left: 20px;
    }

    .login-btn-wrap .has-dropdown {
        position: relative;
    }

    .btn-login {
        background: rgba(255, 255, 255, 0.2);
        color: #fff !important;
        padding: 8px 18px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s;
        border: 1.5px solid rgba(255, 255, 255, 0.4);
        display: inline-flex;
        align-items: center;
        text-decoration: none !important;
        white-space: nowrap;
        backdrop-filter: blur(5px);
    }

    .btn-login:hover {
        background: #fff;
        color: #fb7e9c !important;
        border-color: #fff;
    }

    /* ================================================================
   MOBILE STYLES
   ================================================================ */
    .mobile-brand img {
        height: 40px;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
    }

    .mobile-brand-text {
        color: #ffffff;
        font-weight: 800;
        font-size: 13px;
        line-height: 1.2;
    }

    .mobile-brand-sub {
        color: #ffffff;
        font-size: 7px;
        font-weight: 700;
        letter-spacing: 0.2px;
    }

    .navbar-toggler-lawa {
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.3);
        padding: 5px 10px;
        border-radius: 6px;
    }

    /* ---- Tablet / iPad Specific Responsive Rules ---- */
    @media (min-width: 992px) and (max-width: 1199px) {
        .header-upper {
            margin: 10px 15px;
        }

        .header-upper.is-sticky {
            left: 15px;
            width: calc(100% - 30px);
        }

        .nav-col-left {
            padding-left: 10px;
        }

        .nav-col-right {
            padding-right: 10px;
        }

        .social-icons-left {
            gap: 10px;
        }

        .social-icons-left a {
            font-size: 15px;
        }

        .nav-menu-lawa {
            gap: 6px;
        }

        .nav-menu-lawa>li>a {
            font-size: 13.5px;
            padding: 24px 8px;
        }

        .nav-col-center {
            flex: 0 0 140px;
        }

        .logo-banner-shape {
            width: 140px;
            height: 135px;
            padding-top: 10px;
        }

        .logo-banner-shape img {
            height: 45px;
        }

        .logo-banner-name {
            font-size: 12px;
        }

        .logo-banner-sub {
            font-size: 9px;
        }

        .btn-login {
            padding: 6px 12px;
            font-size: 12px;
        }

        .login-btn-wrap {
            padding-left: 8px;
        }

        /* Mega menu for iPad Landscape */
        .mega-menu {
            width: calc(100% - 20px);
            min-width: 0;
            padding: 20px;
            left: 50%;
            transform: translateX(-50%) translateY(15px);
        }

        .mega-title {
            font-size: 13.5px;
            margin-bottom: 8px;
        }

        .mega-menu a {
            font-size: 12.5px;
            padding: 5px 0;
        }

        .sub-menu {
            min-width: 240px;
        }

        .sub-menu li a {
            font-size: 13.5px;
            padding: 9px 16px;
        }
    }

    /* ================================================================
       MOBILE FIRST STYLES (Smartphones & Tablets < 992px)
       ================================================================ */
    @media (max-width: 991px) {
        .header-upper {
            padding: 0;
            margin: 8px 12px;
            border-radius: 16px;
        }

        /* Sticky Mobile Header */
        .header-upper.is-sticky {
            top: 4px;
            left: 8px;
            width: calc(100% - 16px);
            border-radius: 16px;
        }

        .header-upper.is-sticky .mobile-header {
            padding-top: 6px !important;
            padding-bottom: 6px !important;
        }

        .header-upper.is-sticky .mobile-logo-img {
            height: 32px;
        }

        .header-upper.is-sticky .mobile-brand-text {
            font-size: 11px;
        }

        .header-upper.is-sticky .mobile-brand-sub {
            font-size: 7px;
        }

        .mobile-logo-img {
            height: 38px;
            transition: all 0.2s ease;
        }

        .brand-text-wrap {
            line-height: 1.2;
        }

        .mobile-brand-text {
            font-size: 13px;
            font-weight: 700;
            color: #ffffff;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
        }

        .mobile-brand-sub {
            font-size: 8px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.85);
            letter-spacing: 0.3px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
        }

        /* Quick Action Header Button */
        .btn-mobile-quick-action {
            width: 38px;
            height: 38px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #ffffff !important;
            font-size: 1rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-mobile-quick-action:active {
            transform: scale(0.92);
            background: rgba(255, 255, 255, 0.35);
        }

        .navbar-toggler-lawa {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .navbar-toggler-lawa:active {
            transform: scale(0.92);
            background: rgba(255, 255, 255, 0.35);
        }

        .navbar-toggler-lawa i {
            font-size: 1.4rem !important;
        }
    }

    /* ================================================================
       OFFCANVAS DRAWER MENU (Modern Mobile First)
       ================================================================ */
    .mobile-offcanvas {
        background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%) !important;
        color: #ffffff;
        width: 320px !important;
        border-left: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: -10px 0 30px rgba(0, 0, 0, 0.4);
    }

    .mobile-offcanvas-header {
        background: linear-gradient(135deg, #fb7e9c 0%, #249ffd 100%);
        padding: 16px 18px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.15);
    }

    .btn-close-custom {
        background: rgba(0, 0, 0, 0.2);
        border: none;
        color: #ffffff;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-close-custom:hover,
    .btn-close-custom:active {
        background: rgba(0, 0, 0, 0.4);
        transform: rotate(90deg);
    }

    .mobile-offcanvas-body {
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 90px;
    }

    .mobile-offcanvas-body::-webkit-scrollbar {
        width: 4px;
    }

    .mobile-offcanvas-body::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 4px;
    }

    /* Quick Shortcut Pills in Drawer */
    .mobile-quick-shortcuts {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 6px;
        background: rgba(255, 255, 255, 0.05);
        padding: 10px 8px;
        border-radius: 14px;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .quick-pill {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 4px;
        text-decoration: none;
        padding: 6px 2px;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .quick-pill:hover,
    .quick-pill:active {
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-2px);
    }

    .quick-pill i {
        font-size: 1.25rem;
    }

    .quick-pill span {
        font-size: 10.5px;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.85);
    }

    /* Mobile Nav Menu inside Drawer */
    .mobile-nav-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .mob-menu-link {
        display: flex !important;
        align-items: center;
        gap: 12px;
        color: rgba(255, 255, 255, 0.9) !important;
        padding: 11px 10px !important;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        font-size: 13.5px;
        transition: all 0.2s ease;
        margin-bottom: 3px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
    }

    .mob-menu-link:hover,
    .mob-menu-link:active {
        background: rgba(255, 255, 255, 0.08);
        color: #ffffff !important;
        padding-left: 14px !important;
    }

    .icon-wrap {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
    }

    .bg-primary-soft {
        background: rgba(36, 159, 253, 0.2);
        color: #56ccf2;
    }

    .bg-pink-soft {
        background: rgba(251, 126, 156, 0.2);
        color: #fb7e9c;
    }

    .bg-blue-soft {
        background: rgba(2, 132, 199, 0.2);
        color: #38bdf8;
    }

    .bg-warning-soft {
        background: rgba(245, 158, 11, 0.2);
        color: #fbbf24;
    }

    .bg-purple-soft {
        background: rgba(168, 85, 247, 0.2);
        color: #c084fc;
    }

    .bg-teal-soft {
        background: rgba(20, 184, 166, 0.2);
        color: #2dd4bf;
    }

    .bg-danger-soft {
        background: rgba(239, 68, 68, 0.2);
        color: #f87171;
    }

    .bg-success-soft {
        background: rgba(34, 197, 94, 0.2);
        color: #4ade80;
    }

    /* + and - Indicator Badges */
    .mob-dropdown {
        position: relative;
    }

    .mob-dropdown>.mob-toggle {
        position: relative;
        padding-right: 36px !important;
        cursor: pointer;
    }

    .mob-dropdown>.mob-toggle::after {
        content: '+';
        font-family: system-ui, -apple-system, sans-serif;
        font-size: 15px;
        font-weight: 700;
        line-height: 1;
        width: 22px;
        height: 22px;
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
        color: #ffffff;
    }

    .mob-dropdown.open>.mob-toggle::after {
        content: '−';
        background: rgba(251, 126, 156, 0.4);
        border-color: rgba(251, 126, 156, 0.6);
        transform: translateY(-50%) rotate(180deg);
    }

    /* Sub-menu styling inside Drawer */
    .mob-sub {
        list-style: none;
        padding: 0;
        margin: 0;
        background: rgba(0, 0, 0, 0.25);
        border-radius: 10px;
        max-height: 0;
        opacity: 0;
        overflow: hidden;
        transition: max-height 0.35s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease, margin 0.3s ease;
    }

    .mob-sub-header {
        font-weight: 700;
        color: #fb7e9c;
        font-size: 12px;
        padding: 10px 14px 4px 14px;
        margin-top: 4px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        align-items: center;
    }

    .mob-sub li a {
        display: flex;
        align-items: center;
        color: rgba(255, 255, 255, 0.85);
        padding: 9px 14px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .mob-sub li a:hover,
    .mob-sub li a:active {
        color: #fff;
        background: rgba(255, 255, 255, 0.08);
        padding-left: 18px;
    }

    .mob-sub li:last-child a {
        border-bottom: none;
    }

    .mob-sub .mob-sub-dropdown>.mob-toggle {
        padding: 10px 32px 10px 14px;
        color: rgba(255, 255, 255, 0.9);
        font-size: 13px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        background: rgba(255, 255, 255, 0.03);
    }

    .mob-sub .mob-sub-dropdown>.mob-toggle::after {
        width: 20px;
        height: 20px;
        font-size: 13px;
        right: 8px;
    }

    .mob-sub .mob-sub-dropdown.open>.mob-sub {
        background: rgba(0, 0, 0, 0.35);
    }

    /* Social icons in drawer */
    .mobile-social {
        display: flex;
        justify-content: center;
        gap: 14px;
    }

    .mobile-social a {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: rgba(255, 255, 255, 0.85);
        font-size: 16px;
        transition: all 0.2s;
    }

    .mobile-social a:hover,
    .mobile-social a:active {
        background: #249ffd;
        color: #fff;
        transform: scale(1.1);
    }

    /* ================================================================
       FLOATING MOBILE BOTTOM NAVIGATION BAR (Smartphones only)
       ================================================================ */
    .mobile-bottom-nav {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        min-height: 56px;
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-top: 1px solid rgba(0, 0, 0, 0.08);
        box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.08);
        z-index: 1045;
        display: flex;
        align-items: center;
        justify-content: space-around;
        padding-top: 6px;
        padding-bottom: max(6px, env(safe-area-inset-bottom, 0px));
        padding-left: 2px;
        padding-right: 2px;
        box-sizing: border-box;
        transform: translate3d(0, 0, 0);
        -webkit-transform: translate3d(0, 0, 0);
        backface-visibility: hidden;
        -webkit-backface-visibility: hidden;
    }

    .bottom-nav-item {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-decoration: none !important;
        color: #64748b !important;
        font-size: 10px;
        font-weight: 600;
        padding: 2px 0;
        transition: all 0.2s ease;
        position: relative;
    }

    .bottom-nav-item .nav-icon-box {
        font-size: 1.25rem;
        line-height: 1;
        margin-bottom: 2px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .bottom-nav-item:active .nav-icon-box {
        transform: scale(0.85);
    }

    .bottom-nav-item.active {
        color: #fb7e9c !important;
    }

    .bottom-nav-item.active .nav-icon-box {
        color: #fb7e9c;
    }

    .bottom-nav-item.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        width: 14px;
        height: 3px;
        background: linear-gradient(90deg, #fb7e9c, #249ffd);
        border-radius: 3px;
    }

    /* Center Highlight Button */
    .bottom-nav-highlight {
        margin-top: -16px;
    }

    .bottom-nav-highlight .nav-icon-box-highlight {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #fb7e9c 0%, #249ffd 100%);
        box-shadow: 0 6px 16px rgba(36, 159, 253, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 1.3rem;
        transition: all 0.25s ease;
        border: 3px solid #ffffff;
        margin-bottom: 2px;
    }

    .bottom-nav-highlight:active .nav-icon-box-highlight {
        transform: scale(0.92);
        box-shadow: 0 2px 8px rgba(36, 159, 253, 0.4);
    }

    .bottom-nav-highlight span {
        font-weight: 700;
        color: #249ffd;
    }

    /* ================================================================
       MOBILE SERVICES BOTTOM SHEET (Quick App-like Grid)
       ================================================================ */
    .mobile-sheet-services {
        height: auto !important;
        max-height: 80vh !important;
        border-top-left-radius: 24px !important;
        border-top-right-radius: 24px !important;
        box-shadow: 0 -10px 40px rgba(0, 0, 0, 0.15) !important;
        padding-bottom: max(20px, env(safe-area-inset-bottom)) !important;
    }

    .sheet-drag-handle {
        width: 40px;
        height: 4px;
        background: #cbd5e1;
        border-radius: 4px;
        margin: 8px auto 0 auto;
    }

    .services-header-icon {
        width: 30px;
        height: 30px;
        background: rgba(36, 159, 253, 0.12);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }

    .sheet-category-title {
        font-size: 11.5px;
        font-weight: 700;
        color: #64748b;
        margin-top: 14px;
        margin-bottom: 10px;
        padding-bottom: 4px;
        border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        display: flex;
        align-items: center;
    }

    .sheet-category-title:first-child {
        margin-top: 0;
    }

    .services-app-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px 8px;
        text-align: center;
    }

    .service-app-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-decoration: none !important;
        color: #334155;
        transition: transform 0.2s ease;
    }

    .service-app-card:active {
        transform: scale(0.92);
    }

    .service-icon-circle {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 1.45rem;
        margin-bottom: 6px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.2s ease;
    }

    .service-label {
        font-size: 10.5px;
        font-weight: 600;
        line-height: 1.2;
        color: #334155;
        word-break: break-word;
    }

    .bg-pink-grad {
        background: linear-gradient(135deg, #ff6b8b, #e11d48);
    }

    .bg-blue-grad {
        background: linear-gradient(135deg, #38bdf8, #0284c7);
    }

    .bg-teal-grad {
        background: linear-gradient(135deg, #2dd4bf, #0f766e);
    }

    .bg-purple-grad {
        background: linear-gradient(135deg, #c084fc, #7e22ce);
    }

    .bg-amber-grad {
        background: linear-gradient(135deg, #fbbf24, #d97706);
    }

    .bg-emerald-grad {
        background: linear-gradient(135deg, #34d399, #059669);
    }

    .bg-indigo-grad {
        background: linear-gradient(135deg, #818cf8, #4338ca);
    }

    .bg-rose-grad {
        background: linear-gradient(135deg, #fb7185, #be123c);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Helper: Open Submenu with smooth slide transition
        function openSubMenu(menu) {
            if (!menu) return;
            menu.style.marginTop = '4px';
            menu.style.marginBottom = '6px';
            menu.style.maxHeight = menu.scrollHeight + 'px';
            menu.style.opacity = '1';
            // Allow nested sub-dropdowns to expand beyond original scrollHeight
            setTimeout(function () {
                if (menu.parentElement && menu.parentElement.classList.contains('open')) {
                    menu.style.maxHeight = 'none';
                }
            }, 350);
        }

        // Helper: Close Submenu with smooth slide transition
        function closeSubMenu(menu) {
            if (!menu) return;
            menu.style.maxHeight = menu.scrollHeight + 'px';
            menu.offsetHeight; // Force reflow
            menu.style.maxHeight = '0px';
            menu.style.opacity = '0';
            menu.style.marginTop = '0px';
            menu.style.marginBottom = '0px';
            // Close any nested open sub-dropdowns inside
            menu.querySelectorAll('.mob-dropdown.open').forEach(function (nested) {
                nested.classList.remove('open');
                var nestedSub = nested.querySelector(':scope > .mob-sub');
                if (nestedSub) closeSubMenu(nestedSub);
            });
        }

        // Mobile dropdown toggle inside Drawer (+ / - accordion)
        document.querySelectorAll('.mobile-offcanvas .mob-toggle').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                var parent = this.parentElement; // li.mob-dropdown
                if (!parent) return;

                var subMenu = parent.querySelector(':scope > .mob-sub');
                var isOpen = parent.classList.contains('open');

                // Close sibling dropdowns at the same level smoothly
                var siblings = parent.parentElement ? parent.parentElement.children : [];
                Array.from(siblings).forEach(function (sibling) {
                    if (sibling !== parent && sibling.classList && sibling.classList.contains('mob-dropdown')) {
                        sibling.classList.remove('open');
                        var sibSub = sibling.querySelector(':scope > .mob-sub');
                        if (sibSub) closeSubMenu(sibSub);
                    }
                });

                // Toggle current dropdown
                if (isOpen) {
                    parent.classList.remove('open');
                    if (subMenu) closeSubMenu(subMenu);
                } else {
                    parent.classList.add('open');
                    if (subMenu) openSubMenu(subMenu);
                }
            });
        });

        // Sticky Header Scroll Event Listener
        var headerUpper = document.querySelector('.header-upper');
        if (headerUpper) {
            window.addEventListener('scroll', function () {
                if (window.scrollY > 100) {
                    headerUpper.classList.add('is-sticky');
                } else {
                    headerUpper.classList.remove('is-sticky');
                }
            });
        }

        // Desktop: Smart Mega Menu Positioning (Only on Desktop >= 992px)
        if (window.innerWidth >= 992) {
            document.querySelectorAll('.has-mega').forEach(function (item) {
                item.addEventListener('mouseenter', function () {
                    var menu = item.querySelector('.mega-menu');
                    if (!menu) return;
                    menu.classList.remove('mega-menu-right');
                    requestAnimationFrame(function () {
                        var rect = menu.getBoundingClientRect();
                        if (rect.right > window.innerWidth - 10) {
                            menu.classList.add('mega-menu-right');
                        }
                    });
                });
            });
        }
    });
</script>