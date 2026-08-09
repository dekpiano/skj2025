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
                            <a href="#">เกี่ยวกับ สกจ</a>
                            <ul class="sub-menu">
                                <?php foreach ($AboutSchool as $key => $v_AboutSchool): ?>
                                    <li><a href="<?= base_url('About/' . urlencode($v_AboutSchool->about_menu)) ?>"><i
                                                class="bi bi-info-circle me-2"></i><?= $v_AboutSchool->about_menu ?></a>
                                    </li>
                                <?php endforeach; ?>
                                <li><a href="<?= base_url('Board') ?>"><i
                                            class="bi bi-people-fill me-2"></i>คณะกรรมการสถานศึกษา</a></li>
                                <li><a href="<?= base_url('Botany') ?>"><i
                                            class="bi bi-tree-fill me-2"></i>งานสวนพฤกษศาสตร์</a></li>
                            </ul>
                        </li>
                        <li class="has-dropdown has-mega">
                            <a href="#">หน่วยงานภายใน</a>
                            <div class="mega-menu">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <h6 class="mega-title">ฝ่ายบริหารงาน</h6>
                                        <a href="https://academic.skj.ac.th/"><i
                                                class="bi bi-book me-2"></i>งานวิชาการ</a>
                                        <a href="https://general.skj.ac.th/"><i
                                                class="bi bi-gear me-2"></i>งานทั่วไป</a>
                                        <a href="https://personnel.skj.ac.th/"><i
                                                class="bi bi-person-badge me-2"></i>งานบุคคล</a>
                                        <a href="https://budgetplan.skj.ac.th/"><i
                                                class="bi bi-bar-chart-line me-2"></i>งานงบประมาณและแผน</a>
                                    </div>
                                    <div class="col-lg-3">
                                        <h6 class="mega-title">คณะผู้บริหาร</h6>
                                        <a href="<?= base_url('Personnal/Executive') ?>"><i
                                                class="bi bi-person-video2 me-2"></i>ผู้บริหารสถานศึกษา</a>
                                    </div>
                                    <div class="col-lg-3">
                                        <h6 class="mega-title">บุคลากรสายการสอน</h6>
                                        <a href="https://personnel.skj.ac.th/directory"><b><i
                                                    class="bi bi-people-fill me-2"></i>บุคลากรทั้งหมด</b></a>
                                        <?php foreach ($Lear as $key => $v_Lear): ?>
                                            <a
                                                href="<?= base_url('Personnal/' . urlencode("สายการสอน") . '/' . str_replace(" ", "-", urlencode($v_Lear->lear_namethai))) ?>"><?= $v_Lear->lear_namethai; ?></a>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="col-lg-3">
                                        <h6 class="mega-title">สายสนับสนุน</h6>
                                        <a href="<?= base_url('Personnal/' . urlencode("สายสนับสนุน")) ?>"><b><i
                                                    class="bi bi-person-gear me-2"></i>สายสนับสนุนทั้งหมด</b></a>
                                        <?php foreach ($PosiOther as $key => $v_PosiOther): ?>
                                            <a
                                                href="<?= base_url('Personnal/' . urlencode("สายสนับสนุน") . '/' . str_replace(" ", "-", urlencode($v_PosiOther->posi_name))) ?>"><?= $v_PosiOther->posi_name; ?></a>
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
                        <li><a href="<?= base_url('News') ?>">ประชาสัมพันธ์</a></li>
                        <li><a href="<?= base_url('Course') ?>">หลักสูตร</a></li>
                        <li class="has-dropdown has-mega">
                            <a href="#">SKJ บริการ</a>
                            <div class="mega-menu mega-menu-right">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <h6 class="mega-title">นักเรียน & การเรียน</h6>
                                        <a href="https://admission.skj.ac.th/">รับสมัครนักเรียน</a>
                                        <a href="https://academic.skj.ac.th/LearningOnline">ห้องเรียนออนไลน์</a>
                                        <a href="https://learnsuan.skj.ac.th/">สวนกุหลาบศึกษา</a>
                                        <a href="<?= base_url('guidance') ?>">ทุนการศึกษา</a>
                                    </div>
                                    <div class="col-lg-3">
                                        <h6 class="mega-title">ระบบจอง & แจ้งซ่อม</h6>
                                        <a href="https://general.skj.ac.th/Booking">จองอาคารสถานที่</a>
                                        <a href="https://general.skj.ac.th/CarBooking">จองยานพาหนะ</a>
                                        <a href="https://general.skj.ac.th/Repair">แจ้งซ่อมออนไลน์</a>
                                        <a href="https://general.skj.ac.th/FoodReport">รายงานอาหาร</a>
                                    </div>
                                    <div class="col-lg-3">
                                        <h6 class="mega-title">ข้อมูล & เอกสาร</h6>
                                        <a href="<?= base_url('Yearbook') ?>">หนังสือรุ่นดิจิทัล</a>
                                        <a href="<?= base_url('PageGroup') ?>">Facebook กลุ่ม</a>
                                        <a href="<?= base_url('Email') ?>">อีเมลโรงเรียน</a>
                                        <a href="https://documentcenter.skj.ac.th/">โหลดเอกสาร</a>
                                        <a href="<?= base_url('Botany') ?>">งานสวนพฤกษศาสตร์</a>
                                    </div>
                                    <div class="col-lg-3">
                                        <h6 class="mega-title">กีฬา & อื่นๆ</h6>
                                        <a href="<?= base_url('Procurements') ?>">จัดซื้อจัดจ้าง</a>
                                        <a href="https://sites.google.com/skj.ac.th/skj68/home">ประกันคุณภาพฯ</a>
                                        <a href="https://sportbase.skj.ac.th/User/Match">ตารางแข่งขันกีฬา</a>
                                        <a href="https://sportbase.skj.ac.th/User/Athlete">ทำเนียบนักกีฬา</a>
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
                            </ul>
                        </div>
                    </div>
                </div>

            </div><!-- end header-nav-row -->

            <!-- Mobile Header -->
            <div class="mobile-header d-flex d-lg-none align-items-center justify-content-between py-3 px-3">
                <a href="<?= base_url('/'); ?>" class="mobile-brand d-flex align-items-center text-decoration-none">
                    <img src="<?= base_url() ?>/assets/img/logo/Logo-nav.png" alt="SKJ Logo">
                    <div class="ms-2">
                        <div class="mobile-brand-text">สวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</div>
                        <div class="mobile-brand-sub">SUANKULARB WITTAYALAI (JIRAPRAWAT) NAKHON SAWAN</div>
                    </div>
                </a>
                <button class="navbar-toggler-lawa" type="button" data-bs-toggle="collapse"
                    data-bs-target="#mobileMenu">
                    <i class="bi bi-list fs-2 text-white"></i>
                </button>
            </div>

        </div>

        <!-- Mobile Menu Collapse -->
        <div class="collapse d-lg-none" id="mobileMenu">
            <div class="container-fluid px-3">
                <ul class="mobile-nav-menu">
                    <li><a href="<?= base_url('/') ?>"><i class="bi bi-house me-2"></i>หน้าแรก</a></li>
                    
                    <!-- เกี่ยวกับ สกจ -->
                    <li class="mob-dropdown">
                        <a href="#" class="mob-toggle"><i class="bi bi-info-circle me-2"></i>เกี่ยวกับ สกจ</a>
                        <ul class="mob-sub">
                            <?php foreach ($AboutSchool as $key => $v_AboutSchool): ?>
                                <li><a
                                        href="<?= base_url('About/' . urlencode($v_AboutSchool->about_menu)) ?>"><?= $v_AboutSchool->about_menu ?></a>
                                </li>
                            <?php endforeach; ?>
                            <li><a href="<?= base_url('Board') ?>"><i
                                        class="bi bi-people-fill me-2"></i>คณะกรรมการสถานศึกษา</a></li>
                            <li><a href="<?= base_url('Botany') ?>"><i
                                        class="bi bi-tree-fill me-2"></i>งานสวนพฤกษศาสตร์</a></li>
                        </ul>
                    </li>

                    <!-- หน่วยงานภายใน -->
                    <li class="mob-dropdown">
                        <a href="#" class="mob-toggle"><i class="bi bi-building me-2"></i>หน่วยงานภายใน</a>
                        <ul class="mob-sub">
                            <li class="mob-sub-header">ฝ่ายบริหารงาน</li>
                            <li><a href="https://academic.skj.ac.th/"><i class="bi bi-book me-2"></i>งานวิชาการ</a></li>
                            <li><a href="https://general.skj.ac.th/"><i class="bi bi-gear me-2"></i>งานทั่วไป</a></li>
                            <li><a href="https://personnel.skj.ac.th/"><i class="bi bi-person-badge me-2"></i>งานบุคคล</a></li>
                            <li><a href="https://budgetplan.skj.ac.th/"><i class="bi bi-bar-chart-line me-2"></i>งานงบประมาณและแผน</a></li>

                            <li class="mob-sub-header">คณะผู้บริหาร</li>
                            <li><a href="<?= base_url('Personnal/Executive') ?>"><i class="bi bi-person-video2 me-2"></i>ผู้บริหารสถานศึกษา</a></li>

                            <!-- บุคลากรสายการสอน (Sub-Dropdown) -->
                            <li class="mob-dropdown mob-sub-dropdown">
                                <a href="#" class="mob-toggle"><i class="bi bi-people-fill me-2"></i>บุคลากรสายการสอน</a>
                                <ul class="mob-sub">
                                    <li><a href="https://personnel.skj.ac.th/directory"><b><i class="bi bi-people-fill me-2"></i>บุคลากรทั้งหมด</b></a></li>
                                    <?php foreach ($Lear as $key => $v_Lear): ?>
                                        <li><a href="<?= base_url('Personnal/' . urlencode("สายการสอน") . '/' . str_replace(" ", "-", urlencode($v_Lear->lear_namethai))) ?>"><?= $v_Lear->lear_namethai; ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>

                            <!-- สายสนับสนุน (Sub-Dropdown) -->
                            <li class="mob-dropdown mob-sub-dropdown">
                                <a href="#" class="mob-toggle"><i class="bi bi-person-gear me-2"></i>สายสนับสนุน</a>
                                <ul class="mob-sub">
                                    <li><a href="<?= base_url('Personnal/' . urlencode("สายสนับสนุน")) ?>"><b><i class="bi bi-person-gear me-2"></i>สายสนับสนุนทั้งหมด</b></a></li>
                                    <?php foreach ($PosiOther as $key => $v_PosiOther): ?>
                                        <li><a href="<?= base_url('Personnal/' . urlencode("สายสนับสนุน") . '/' . str_replace(" ", "-", urlencode($v_PosiOther->posi_name))) ?>"><?= $v_PosiOther->posi_name; ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li><a href="<?= base_url('News') ?>"><i class="bi bi-newspaper me-2"></i>ประชาสัมพันธ์</a></li>
                    <li><a href="<?= base_url('Course') ?>"><i
                                class="bi bi-mortarboard me-2"></i>หลักสูตร</a></li>

                    <!-- SKJ บริการ -->
                    <li class="mob-dropdown">
                        <a href="#" class="mob-toggle"><i class="bi bi-grid me-2"></i>SKJ บริการ</a>
                        <ul class="mob-sub">
                            <li class="mob-sub-header">นักเรียน & การเรียน</li>
                            <li><a href="https://admission.skj.ac.th/">รับสมัครนักเรียน</a></li>
                            <li><a href="https://academic.skj.ac.th/LearningOnline">ห้องเรียนออนไลน์</a></li>
                            <li><a href="https://learnsuan.skj.ac.th/">สวนกุหลาบศึกษา</a></li>
                            <li><a href="<?= base_url('guidance') ?>">ทุนการศึกษา</a></li>

                            <li class="mob-sub-header">ระบบจอง & แจ้งซ่อม</li>
                            <li><a href="https://general.skj.ac.th/Booking">จองอาคารสถานที่</a></li>
                            <li><a href="https://general.skj.ac.th/CarBooking">จองยานพาหนะ</a></li>
                            <li><a href="https://general.skj.ac.th/Repair">แจ้งซ่อมออนไลน์</a></li>
                            <li><a href="https://general.skj.ac.th/FoodReport">รายงานอาหาร</a></li>

                            <li class="mob-sub-header">ข้อมูล & เอกสาร</li>
                            <li><a href="<?= base_url('Yearbook') ?>">หนังสือรุ่นดิจิทัล</a></li>
                            <li><a href="<?= base_url('PageGroup') ?>">Facebook กลุ่ม</a></li>
                            <li><a href="<?= base_url('Email') ?>">อีเมลโรงเรียน</a></li>
                            <li><a href="https://documentcenter.skj.ac.th/">โหลดเอกสาร</a></li>
                            <li><a href="<?= base_url('Botany') ?>">งานสวนพฤกษศาสตร์</a></li>

                            <li class="mob-sub-header">กีฬา & อื่นๆ</li>
                            <li><a href="<?= base_url('Procurements') ?>">จัดซื้อจัดจ้าง</a></li>
                            <li><a href="https://sites.google.com/skj.ac.th/skj68/home">ประกันคุณภาพฯ</a></li>
                            <li><a href="https://sportbase.skj.ac.th/User/Match">ตารางแข่งขันกีฬา</a></li>
                            <li><a href="https://sportbase.skj.ac.th/User/Athlete">ทำเนียบนักกีฬา</a></li>
                        </ul>
                    </li>

                    <!-- เข้าสู่ระบบ -->
                    <li class="mob-dropdown">
                        <a href="#" class="mob-toggle"><i class="bi bi-box-arrow-in-right me-2"></i>เข้าสู่ระบบ</a>
                        <ul class="mob-sub">
                            <li><a href="https://student.skj.ac.th/"><i
                                        class="bi bi-person-fill me-2"></i>สำหรับนักเรียน</a></li>
                            <li><a href="https://teacher.skj.ac.th/"><i
                                        class="bi bi-person-workspace me-2"></i>สำหรับครูผู้สอน</a></li>
                            <li><a href="<?= base_url('Manager/Dashboard') ?>"><i
                                        class="bi bi-bar-chart-line-fill me-2"></i>สำหรับผู้บริหาร</a></li>
                            <li><a href="<?= base_url('Support/SupportAttendance') ?>"><i
                                        class="bi bi-person-gear me-2"></i>สำหรับฝ่ายสนับสนุน</a></li>
                        </ul>
                    </li>

                    <!-- Mobile Contact Info & Social -->
                    <li class="mt-3 pt-3 border-top border-white-15">
                        <div class="text-white-50 small mb-2 text-center" style="font-size: 12px; color: rgba(255, 255, 255, 0.75) !important;">
                            <div class="mb-1"><i class="bi bi-clock me-1"></i> เวลาทำการ: จันทร์ - ศุกร์, 08:30 - 16:30</div>
                            <div><i class="bi bi-envelope me-1"></i> skjns160@skj.ac.th <span class="mx-1">|</span> <i class="bi bi-telephone me-1"></i> 056-200-765</div>
                        </div>
                        <div class="social-icons-left mobile-social mt-2">
                            <a href="https://www.facebook.com/SKJNS160" target="_blank"><i
                                    class="bi bi-facebook"></i></a>
                            <a href="https://youtube.com/channel/UC7p4cQQuIFLyrF68p7JbWDw?si=qOHoQSymoleB3ntP"
                                target="_blank"><i class="bi bi-youtube"></i></a>
                            <a href="#"><i class="bi bi-instagram"></i></a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>

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
        left: 0;
        min-width: 250px;
        background: #fff;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        border-top: 3px solid #fb7e9c;
        border-radius: 0 0 8px 8px;
        padding: 8px 0;
        list-style: none;
        margin: 0;
        visibility: hidden;
        opacity: 0;
        transform: translateY(15px);
        transition: all 0.3s ease;
        z-index: 1060;
    }

    .sub-menu-right {
        left: auto;
        right: 0;
    }

    .has-dropdown:hover>.sub-menu {
        visibility: visible;
        opacity: 1;
        transform: translateY(0);
    }

    .sub-menu li a {
        display: block;
        padding: 10px 20px;
        color: #444;
        font-weight: 500;
        font-size: 13px;
        text-decoration: none;
        transition: all 0.3s;
        border-bottom: 1px solid #f0f0f0;
    }

    .sub-menu li:last-child a {
        border-bottom: none;
    }

    .sub-menu li a:hover {
        color: #fb7e9c;
        background: #fff5f7;
        padding-left: 25px;
    }

    /* ---- Mega Menu ---- */
    .mega-menu {
        position: absolute;
        top: 100%;
        left: 0;
        min-width: 800px;
        max-width: calc(100vw - 40px);
        background: #fff;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        border-top: 3px solid #ec4899;
        border-radius: 0 0 8px 8px;
        padding: 25px 30px;
        visibility: hidden;
        opacity: 0;
        transform: translateY(15px);
        transition: all 0.3s ease;
        z-index: 1060;
    }

    .mega-menu-right {
        left: auto;
        right: 0;
    }

    .has-mega:hover>.mega-menu {
        visibility: visible;
        opacity: 1;
        transform: translateY(0);
    }

    .mega-title {
        font-weight: 700;
        color: #1e293b;
        font-size: 14px;
        margin-bottom: 12px;
        padding-bottom: 8px;
        border-bottom: 2px solid #fb7e9c;
        display: inline-block;
    }

    .mega-menu a {
        display: block;
        padding: 7px 0;
        color: #555;
        font-weight: 500;
        font-size: 13px;
        text-decoration: none;
        transition: all 0.2s;
    }

    .mega-menu a:hover {
        color: #fb7e9c;
        padding-left: 5px;
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

    @media (max-width: 991px) {
        .header-upper {
            padding: 0;
            margin: 10px 15px; /* ลดขอบตอนไม่เลื่อนให้เหมาะกับมือถือ */
        }

        /* เมื่อเลื่อนจอ (Sticky) ให้ Navbar มือถือเล็กลง */
        .header-upper.is-sticky {
            top: 5px;
            left: 10px;
            width: calc(100% - 20px);
        }
        .header-upper.is-sticky .mobile-header {
            padding-top: 6px !important;
            padding-bottom: 6px !important;
        }
        .header-upper.is-sticky .mobile-brand img {
            height: 28px; /* ย่อโลโก้ลง */
        }
        .header-upper.is-sticky .mobile-brand-text {
            font-size: 11px; /* ย่อชื่อโรงเรียน */
        }
        .header-upper.is-sticky .mobile-brand-sub {
            font-size: 6px;
        }
        .header-upper.is-sticky .navbar-toggler-lawa {
            padding: 2px 8px; /* ย่อปุ่มเมนู */
        }
        .header-upper.is-sticky .navbar-toggler-lawa i {
            font-size: 1.5rem !important;
        }

        /* Enable vertical scrolling for mobile menu when expanded */
        #mobileMenu {
            max-height: calc(85vh - 65px);
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 20px;
        }

        #mobileMenu::-webkit-scrollbar {
            width: 5px;
        }

        #mobileMenu::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }

        #mobileMenu::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }

        .mobile-nav-menu {
            list-style: none;
            padding: 15px 0;
            margin: 0;
        }

        .mobile-nav-menu>li>a,
        .mobile-nav-menu>li>.mob-toggle {
            display: block;
            position: relative;
            color: rgba(255, 255, 255, 0.9);
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
        }

        .mob-dropdown > .mob-toggle {
            padding-right: 35px; /* เว้นพื้นที่ให้ปุ่ม + / - ด้านขวาขอบสุด */
        }

        .mobile-nav-menu>li>a:hover,
        .mobile-nav-menu>li>.mob-toggle:hover {
            color: #fff;
        }

        /* + and - Indicator Badges on Absolute Far Right */
        .mob-dropdown > .mob-toggle::after {
            content: '+';
            font-family: system-ui, -apple-system, sans-serif;
            font-size: 16px;
            font-weight: 700;
            line-height: 1;
            width: 26px;
            height: 26px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
        }

        .mob-dropdown.open > .mob-toggle::after {
            content: '−';
            background: rgba(255, 255, 255, 0.35);
            color: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
            transform: translateY(-50%) rotate(180deg);
        }

        /* Smooth Animated Sub-Menu */
        .mob-sub {
            list-style: none;
            padding: 0;
            margin: 0;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 6px;
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            transition: max-height 0.35s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease, margin 0.3s ease;
        }

        .mob-sub-header {
            font-weight: 700;
            color: #ffd6e0;
            font-size: 11px;
            padding: 10px 15px 4px 15px;
            margin-top: 4px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        }

        /* 2nd Level Sub-Dropdown Styling */
        .mob-sub .mob-sub-dropdown > .mob-toggle {
            padding: 10px 35px 10px 15px;
            color: rgba(255, 255, 255, 0.9);
            font-size: 13px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            background: rgba(255, 255, 255, 0.04);
            position: relative;
        }

        .mob-sub .mob-sub-dropdown > .mob-toggle::after {
            width: 22px;
            height: 22px;
            font-size: 14px;
            right: 10px;
            background: rgba(255, 255, 255, 0.12);
        }

        .mob-sub .mob-sub-dropdown.open > .mob-sub {
            background: rgba(0, 0, 0, 0.18);
            border-radius: 6px;
        }

        .mob-sub li a {
            display: block;
            color: rgba(255, 255, 255, 0.75);
            padding: 10px 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            text-decoration: none;
            font-size: 13px;
            transition: all 0.2s;
        }

        .mob-sub li:last-child a {
            border-bottom: none;
        }

        .mob-sub li a:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
            padding-left: 20px;
        }

        .mobile-social {
            justify-content: center;
            margin: 0;
        }

        .mobile-social a {
            color: rgba(255, 255, 255, 0.7);
        }

        .mobile-social a:hover {
            color: #fff;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Helper: Open Submenu with smooth slide transition
        function openSubMenu(menu) {
            if (!menu) return;
            menu.style.marginTop = '5px';
            menu.style.marginBottom = '8px';
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
            // Force reflow
            menu.offsetHeight;
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

        // Mobile dropdown toggle (+ / - accordion with smooth slide animation)
        document.querySelectorAll('.mob-toggle').forEach(function (btn) {
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
                if (window.scrollY > 120) {
                    headerUpper.classList.add('is-sticky');
                } else {
                    headerUpper.classList.remove('is-sticky');
                }
            });
        }

        // Desktop: Smart Mega Menu Positioning
        if (window.innerWidth >= 992) {
            document.querySelectorAll('.has-mega').forEach(function (item) {
                item.addEventListener('mouseenter', function () {
                    var menu = item.querySelector('.mega-menu');
                    if (!menu) return;
                    // Reset
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