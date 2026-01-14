<!-- Brand & Contact Start -->
<div class="container-fluid py-3 px-4 wow fadeIn d-none d-lg-block top-bar-premium" data-wow-delay="0.1s">
    <div class="row align-items-center">
        <div class="col-lg-6">
            <a href="<?= base_url('/'); ?>" class="navbar-brand-premium">
                <div class="d-flex align-items-center">
                    <div class="logo-wrapper-nav">
                        <img src="<?= base_url() ?>/assets/img/logo/Logo-nav.png" alt="SKJ Logo" class="img-fluid">
                    </div>
                    <div class="brand-text-nav ms-3">
                        <div class="text-thai-nav">สวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</div>
                        <div class="text-eng-nav">Suankularb Wittayalai (Jiraprawat) Nakhon Sawan</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-6">
            <div class="row g-0 justify-content-end top-info-wrapper">
                <div class="col-auto px-4 border-end border-light-subtle">
                    <div class="d-flex align-items-center">
                        <div class="info-icon-nav pink"><i class="bi bi-clock"></i></div>
                        <div class="ms-3">
                            <div class="info-label-nav">เวลาทำการ</div>
                            <div class="info-value-nav">จันทร์ - ศุกร์, 08:30 - 16:30</div>
                        </div>
                    </div>
                </div>
                <div class="col-auto px-4 border-end border-light-subtle">
                    <div class="d-flex align-items-center">
                        <div class="info-icon-nav blue"><i class="bi bi-telephone"></i></div>
                        <div class="ms-3">
                            <div class="info-label-nav">ติดต่อเรา</div>
                            <div class="info-value-nav">056-009-667</div>
                        </div>
                    </div>
                </div>
                <div class="col-auto ps-4">
                    <div class="d-flex align-items-center">
                        <div class="info-icon-nav pink"><i class="bi bi-envelope"></i></div>
                        <div class="ms-3">
                            <div class="info-label-nav">อีเมล</div>
                            <div class="info-value-nav">skjns160@skj.ac.th</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Brand & Contact End -->

<style>
    /* Premium Top Bar Styles */
    .top-bar-premium {
        background: #fff;
        /* border-bottom removed - navbar border-top provides the accent */
    }

    .logo-wrapper-nav img {
        height: 65px;
        transition: transform 0.3s ease;
    }

    .navbar-brand-premium:hover .logo-wrapper-nav img {
        transform: scale(1.05);
    }

    .brand-text-nav {
        font-family: 'K2D', sans-serif;
    }

    .text-thai-nav {
        color: #FB7E9C;
        font-weight: 800;
        font-size: 1.25rem;
        line-height: 1.2;
    }

    .text-eng-nav {
        color: #249ffd;
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .info-icon-nav {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    .info-icon-nav.blue { background: rgba(251, 126, 156, 0.1); color: #FB7E9C; }
    .info-icon-nav.pink { background: rgba(36, 159, 253, 0.1); color: #249ffd; }

    .info-label-nav {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #888;
        font-weight: 700;
        margin-bottom: 2px;
    }

    .info-value-nav {
        font-size: 0.9rem;
        color: #FB7E9C;
        font-weight: 700;
    }

    /* Responsive Top Bar Info for Medium Screens */
    @media (min-width: 992px) and (max-width: 1500px) {
        .top-info-wrapper .col-auto {
            padding-left: 10px !important;
            padding-right: 10px !important;
        }
        .info-icon-nav {
            width: 32px;
            height: 32px;
            font-size: 0.9rem;
        }
        .info-label-nav {
            font-size: 0.65rem;
            letter-spacing: 0.5px;
        }
        .info-value-nav {
            font-size: 0.75rem;
        }
        .logo-wrapper-nav img {
            height: 50px;
        }
        .text-thai-nav {
            font-size: 1rem;
        }
        .text-eng-nav {
            font-size: 0.7rem;
        }
    }

    @media (min-width: 992px) and (max-width: 1200px) {
        .top-info-wrapper .col-auto {
            padding-left: 6px !important;
            padding-right: 6px !important;
        }
        .info-icon-nav {
            width: 28px;
            height: 28px;
            font-size: 0.8rem;
            border-radius: 8px;
        }
        .info-label-nav {
            font-size: 0.55rem;
        }
        .info-value-nav {
            font-size: 0.68rem;
        }
        .logo-wrapper-nav img {
            height: 45px;
        }
        .text-thai-nav {
            font-size: 0.9rem;
        }
        .text-eng-nav {
            font-size: 0.65rem;
        }
    }

    /* Navbar Modern Styles */
    .navbar-skj {
        background: #FB7E9C !important;
        padding: 0;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        border-top: 4px solid #249ffd;
        margin-top: 0;
        z-index: 1030; 
        top: 0 !important;
        position: sticky !important;
    }

    @media (max-width: 991px) {
        .navbar-skj {
            padding: 10px 0;
            border-top: none;
        }
    }

    .navbar-skj .nav-link {
        color: rgba(255,255,255,0.8) !important;
        font-weight: 600;
        padding: 25px 12px !important; /* Reduced padding */
        position: relative;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap; /* Prevent text wrap */
    }

    /* Screen size specific adjustments to prevent wrapping */
    @media (min-width: 992px) and (max-width: 1600px) {
        .navbar-skj .nav-link {
            padding: 25px 8px !important;
            font-size: 0.85rem;
        }
        .navbar-skj .nav-link i {
            font-size: 0.9rem;
        }
    }

    @media (min-width: 992px) and (max-width: 1300px) {
        .navbar-skj .nav-link {
            padding: 25px 5px !important;
            font-size: 0.78rem;
            gap: 4px;
        }
        .navbar-skj .nav-link i {
            font-size: 0.8rem;
        }
    }

    @media (min-width: 992px) and (max-width: 1100px) {
        .navbar-skj .nav-link {
            padding: 20px 4px !important;
            font-size: 0.72rem;
            gap: 3px;
        }
        .navbar-skj .nav-link i {
            font-size: 0.75rem;
        }
    }

    .navbar-skj .nav-link i {
        font-size: 1rem;
        transition: transform 0.3s ease;
    }

    .navbar-skj .nav-link:hover {
        color: #fff !important;
    }

    .navbar-skj .nav-link:hover i {
        transform: translateY(-2px);
        color: #249ffd;
    }

    .navbar-skj .nav-link::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 3px;
        background: #249ffd;
        transition: all 0.3s ease;
        transform: translateX(-50%);
    }

    .navbar-skj .nav-link:hover::after,
    .navbar-skj .nav-link.active::after {
        width: 100%;
    }

    /* Dropdown Premium */
    .dropdown-menu-skj {
        border: none;
        border-radius: 15px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        padding: 15px;
        margin-top: 0;
        background: #fff;
        animation: fadeInDown 0.3s ease;
    }

    .dropdown-item-skj {
        border-radius: 10px;
        padding: 10px 15px;
        font-weight: 600;
        color: #444;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 5px;
    }

    .dropdown-item-skj:last-child { margin-bottom: 0; }

    .dropdown-item-skj:hover {
        background: rgba(251, 126, 156, 0.1);
        color: #FB7E9C;
        transform: translateX(5px);
    }

    .dropdown-item-skj i {
        font-size: 1.1rem;
        color: #FB7E9C;
    }

    /* Mega Menu Premium - Desktop Specific */
    @media (min-width: 992px) {
        .navbar-skj .nav-item.dropdown {
            position: relative; 
        }

        .mega-menu-premium {
            width: max-content;
            min-width: 800px;
            max-width: calc(100vw - 40px);
            padding: 35px !important;
            left: 0; /* Default alignment */
            transform: none;
            border-radius: 0 20px 20px 20px !important;
            margin-top: 0 !important;
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        /* Class to shift menu if it overflows to the right */
        .mega-menu-premium.shift-left {
            left: auto !important;
            right: 0 !important;
            border-radius: 20px 0 20px 20px !important;
        }

        /* Class to shift menu if it overflows to the left */
        .mega-menu-premium.shift-right {
            left: 0 !important;
            right: auto !important;
            border-radius: 0 20px 20px 20px !important;
        }
    }

    .mega-column-title {
        font-weight: 800;
        color: #1a2a4d;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f8f9fa;
    }

    .mega-column-title i { color: #249ffd; }

    /* Mobile Brand & Menu */
    .navbar-skj .container-fluid {
        display: flex !important;
        flex-wrap: wrap !important; /* Allow wrapping for the collapse menu */
        align-items: center;
        justify-content: space-between;
    }

    @media (max-width: 991px) {
        .navbar-skj .navbar-brand {
            flex-grow: 1;
            min-width: 0;
            max-width: calc(100% - 60px); /* Ensure space for toggler on the same line */
            margin-right: 0;
        }

        .navbar-collapse {
            flex-basis: 100%; /* Force collapse menu to take full width and wrap to next line */
            margin-top: 10px;
        }
    }

    .navbar-brand-mobile {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        min-width: 0;
    }

    .navbar-brand-mobile img {
        height: 45px;
        flex-shrink: 0;
    }

    @media (max-width: 375px) {
        .navbar-brand-mobile img {
            height: 30px; /* Further reduced */
        }
    }

    .brand-text-mobile {
        color: #fff;
        font-weight: 700;
        font-size: clamp(0.6rem, 3.5vw, 0.9rem);
        line-height: 1;
        white-space: normal;
        display: block;
    }

    .brand-text-mobile .thai-name {
        display: block;
        margin-bottom: 1px;
    }

    .brand-text-mobile .eng-name {
        display: block;
        font-size: 0.6em;
        font-weight: 500;
        opacity: 0.8;
        letter-spacing: 0.3px;
        text-transform: uppercase;
    }

    .navbar-toggler-skj {
        border: none;
        padding: 5px;
        outline: none !important;
        box-shadow: none !important;
        flex-shrink: 0; /* Keep toggler from shrinking */
    }

    .toggler-icon-premium {
        width: 30px;
        height: 2px;
        background: #fff;
        display: block;
        margin: 6px 0;
        transition: all 0.3s ease;
        border-radius: 2px;
    }

    @media (max-width: 991px) {
        .navbar-collapse {
            background: #249ffd !important; /* Changed from navy to theme blue */
            margin-top: 15px;
            border-radius: 20px;
            padding: 20px;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .navbar-skj .nav-link {
            padding: 15px 10px !important;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            color: #fff !important;
        }

        .navbar-skj .nav-link::after { display: none; }

        .dropdown-menu-skj,
        .mega-menu-premium {
            min-width: 100%;
            left: 0 !important;
            transform: none !important;
            background: transparent !important;
            box-shadow: none !important;
            padding: 0 !important;
            position: static !important; /* Stack normally on mobile */
            animation: none !important; /* Disable animations on mobile for better performance and visibility */
            margin-top: 0 !important;
        }

        .mega-column-title {
            color: #fff !important; /* Changed from blue to white for visibility */
            margin-top: 20px;
            border-bottom-color: rgba(255,255,255,0.2);
            font-size: 1.1rem;
        }

        .mega-column-title i {
            color: #fff !important;
        }

        .dropdown-item-skj {
            color: rgba(255,255,255,0.9);
        }

        .dropdown-item-skj:hover {
            background: rgba(255,255,255,0.2);
            color: #fff;
        }

        .dropdown-item-skj i {
            color: #fff;
        }
    }

    /* Countdown Styling - Using styles from newyear_snow.css */
    #nav-countdown {
        flex-shrink: 0; /* Prevent countdown from shrinking or taking too much space */
    }

    @media (max-width: 991px) {
        #nav-countdown {
            margin: 20px 0;
            justify-content: center;
        }
    }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Desktop Hover Fix */
    @media (min-width: 992px) {
        .navbar-skj .nav-item.dropdown:hover > .dropdown-menu-skj {
            display: block !important;
            margin-top: 0 !important;
            opacity: 1 !important;
            visibility: visible !important;
        }

        /* Bridge the gap to prevent menu closing - ENHANCED for local alignment */
        .dropdown-menu-skj::before {
            content: '';
            position: absolute;
            top: -30px; 
            left: 0; 
            right: 0;
            height: 40px;
            background: transparent;
            z-index: -1;
        }
    }

    /* Sticky Shrink Effect */
    .navbar-skj {
        transition: all 0.3s ease;
    }

    .navbar-skj.navbar-shrink {
        padding: 0 !important;
        box-shadow: 0 2px 10px rgba(0,0,0,0.15);
    }

    .navbar-skj.navbar-shrink .nav-link {
        padding: 15px 10px !important;
        font-size: 0.9rem; /* Slightly smaller text when shrunk */
    }

    /* Shrink mobile brand */
    .navbar-skj.navbar-shrink .navbar-brand-mobile img {
        height: 35px;
        transition: all 0.3s ease;
    }

    .navbar-skj.navbar-shrink .brand-text-mobile {
        font-size: clamp(0.5rem, 3vw, 0.8rem);
    }

    @media (min-width: 992px) and (max-width: 1600px) {
        .navbar-skj.navbar-shrink .nav-link {
            padding: 15px 6px !important;
            font-size: 0.8rem;
        }
    }

    @media (min-width: 992px) and (max-width: 1300px) {
        .navbar-skj.navbar-shrink .nav-link {
            padding: 12px 4px !important;
            font-size: 0.75rem;
        }
    }
</style>

<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg navbar-skj sticky-top">
    <div class="container-fluid px-4 px-lg-5">
        <a href="<?= base_url('/'); ?>" class="navbar-brand d-lg-none">
            <div class="navbar-brand-mobile">
                <img src="<?= base_url() ?>/assets/img/logo/Logo-nav.png" alt="Logo">
                <div class="brand-text-mobile">
                    <span class="thai-name">สวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</span>
                    <span class="eng-name">Suankularb Wittayalai (Jiraprawat) Nakhon Sawan</span>
                </div>
            </div>
        </a>

        <button type="button" class="navbar-toggler navbar-toggler-skj" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="toggler-icon-premium"></span>
            <span class="toggler-icon-premium" style="width: 20px;"></span>
            <span class="toggler-icon-premium"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav me-auto py-0">
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-house-door"></i> เกี่ยวกับ สกจ
                    </a>
                    <div class="dropdown-menu dropdown-menu-skj">
                        <?php foreach ($AboutSchool as $key => $v_AboutSchool) : ?>
                        <a href="<?= base_url('About/' . urlencode($v_AboutSchool->about_menu)) ?>" class="dropdown-item dropdown-item-skj">
                            <i class="bi bi-info-circle"></i> <?= $v_AboutSchool->about_menu ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-people"></i> หน่วยงานภายใน
                    </a>
                    <div class="dropdown-menu dropdown-menu-skj mega-menu-premium">
                        <div class="row">
                            <div class="col-lg-3">
                                <h6 class="mega-column-title"><i class="bi bi-briefcase"></i> ฝ่ายบริหารงาน</h6>
                                <a href="https://academic.skj.ac.th/" class="dropdown-item dropdown-item-skj"><i class="bi bi-book"></i> งานวิชาการ</a>
                                <a href="https://general.skj.ac.th/" class="dropdown-item dropdown-item-skj"><i class="bi bi-gear"></i> งานทั่วไป</a>
                                <a href="https://personnel.skj.ac.th/" class="dropdown-item dropdown-item-skj"><i class="bi bi-person-badge"></i> งานบุคคล</a>
                                <a href="https://budgetplan.skj.ac.th/" class="dropdown-item dropdown-item-skj"><i class="bi bi-bar-chart-line"></i> งานงบประมาณและแผน</a>
                            </div>
                            <div class="col-lg-3">
                                <h6 class="mega-column-title"><i class="bi bi-person-badge"></i> คณะผู้บริหาร</h6>
                                <a href="<?= base_url('Personnal/Executive') ?>" class="dropdown-item dropdown-item-skj"><i class="bi bi-person-video2"></i> ผู้บริหารสถานศึกษา</a>
                            </div>
                            <div class="col-lg-3">
                                <h6 class="mega-column-title"><i class="bi bi-mortarboard"></i> บุคลากรสายการสอน</h6>
                                <a href="https://personnel.skj.ac.th/directory" class="dropdown-item dropdown-item-skj"><b><i class="bi bi-people-fill"></i> บุคลากรทั้งหมด</b></a>
                                <?php foreach ($Lear as $key => $v_Lear) : ?>
                                    <a href="<?= base_url('Personnal/' . urlencode("สายการสอน") . '/' . str_replace(" ", "-", urlencode($v_Lear->lear_namethai))) ?>" class="dropdown-item dropdown-item-skj">
                                        <i class="bi bi-chevron-right small"></i> <?= $v_Lear->lear_namethai; ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                            <div class="col-lg-3">
                                <h6 class="mega-column-title"><i class="bi bi-tools"></i> สายสนับสนุน</h6>
                                <a href="<?= base_url('Personnal/' . urlencode("สายสนับสนุน")) ?>" class="dropdown-item dropdown-item-skj"><b><i class="bi bi-person-gear"></i> สายสนับสนุนทั้งหมด</b></a>
                                <?php foreach ($PosiOther as $key => $v_PosiOther) : ?>
                                    <a href="<?= base_url('Personnal/' . urlencode("สายสนับสนุน") . '/' . str_replace(" ", "-", urlencode($v_PosiOther->posi_name))) ?>" class="dropdown-item dropdown-item-skj">
                                        <i class="bi bi-chevron-right small"></i> <?= $v_PosiOther->posi_name; ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="<?= base_url('News') ?>" class="nav-item nav-link">
                    <i class="bi bi-newspaper"></i> ประชาสัมพันธ์
                </a>

                <a href="<?= base_url('Course') ?>" class="nav-item nav-link">
                    <i class="bi bi-mortarboard-fill"></i> หลักสูตรความเป็นเลิศ
                </a>

                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-grid-3x3-gap"></i> SKJ บริการ
                    </a>
                    <div class="dropdown-menu dropdown-menu-skj mega-menu-premium">
                        <div class="row">
                            <div class="col-lg-3">
                                <h6 class="mega-column-title">นักเรียน & การเรียน</h6>
                                <a href="https://admission.skj.ac.th/" class="dropdown-item dropdown-item-skj"><i class="bi bi-person-plus"></i> รับสมัครนักเรียน</a>
                                <a href="https://academic.skj.ac.th/LearningOnline" class="dropdown-item dropdown-item-skj"><i class="bi bi-globe"></i> ห้องเรียนออนไลน์</a>
                                <a href="https://learnsuan.skj.ac.th/" class="dropdown-item dropdown-item-skj"><i class="bi bi-journal-text"></i> สวนกุหลาบศึกษา</a>
                                <a href="<?= base_url('guidance') ?>" class="dropdown-item dropdown-item-skj"><i class="bi bi-mortarboard"></i> ทุนการศึกษา</a>
                            </div>
                            <div class="col-lg-3">
                                <h6 class="mega-column-title">ระบบจอง & แจ้งซ่อม</h6>
                                <a href="https://general.skj.ac.th/Booking" class="dropdown-item dropdown-item-skj"><i class="bi bi-building-up"></i> จองอาคารสถานที่</a>
                                <a href="https://general.skj.ac.th/CarBooking" class="dropdown-item dropdown-item-skj"><i class="bi bi-car-front"></i> จองยานพาหนะ</a>
                                <a href="https://general.skj.ac.th/Repair" class="dropdown-item dropdown-item-skj"><i class="bi bi-tools"></i> แจ้งซ่อมออนไลน์</a>
                                <a href="https://general.skj.ac.th/FoodReport" class="dropdown-item dropdown-item-skj"><i class="bi bi-pie-chart"></i> รายงานอาหาร</a>
                            </div>
                            <div class="col-lg-3">
                                <h6 class="mega-column-title">ข้อมูล & เอกสาร</h6>
                                <a href="<?= base_url('Yearbook') ?>" class="dropdown-item dropdown-item-skj"><i class="bi bi-book"></i> หนังสือรุ่นดิจิทัล</a>
                                <a href="<?= base_url('PageGroup') ?>" class="dropdown-item dropdown-item-skj"><i class="bi bi-facebook"></i> Facebook กลุ่ม</a>
                                <a href="<?= base_url('Email') ?>" class="dropdown-item dropdown-item-skj"><i class="bi bi-envelope-at"></i> อีเมลโรงเรียน</a>
                                <a href="https://documentcenter.skj.ac.th/" class="dropdown-item dropdown-item-skj"><i class="bi bi-file-earmark-arrow-down"></i> โหลดเอกสาร</a>
                            </div>
                            <div class="col-lg-3">
                                <h6 class="mega-column-title">อื่นๆ</h6>
                                <a href="<?= base_url('Procurements') ?>" class="dropdown-item dropdown-item-skj"><i class="bi bi-cart-check"></i> จัดซื้อจัดจ้าง</a>
                                <a href="https://sites.google.com/skj.ac.th/skj68/home" class="dropdown-item dropdown-item-skj"><i class="bi bi-shield-check"></i> ประกันคุณภาพฯ</a>
                            </div>
                        </div>
                         <div class="row mt-3">
                            <div class="col-lg-3">
                                <h6 class="mega-column-title">กีฬา</h6>
                                <a href="https://sportbase.skj.ac.th/User/Match" class="dropdown-item dropdown-item-skj"><i class="bi bi-calendar-event"></i> ตารางแข่งขัน</a>
                                <a href="https://sportbase.skj.ac.th/User/Athlete" class="dropdown-item dropdown-item-skj"><i class="bi bi-people"></i> ทำเนียบนักกีฬา</a>
                                <a href="https://sportbase.skj.ac.th/User/Attendance" class="dropdown-item dropdown-item-skj"><i class="bi bi-clipboard-check"></i> สถานะภาพนักกีฬาประจำวัน</a>
                            </div>
                            </div>
                    </div>
                </div>
            </div>

            <!-- New Year Countdown -->
            <?php if (isset($festival_status) && $festival_status == 'on') : ?>
            <div id="nav-countdown" class="d-none d-xl-flex">
                <span class="cd-label">Countdown to 2026:</span>
                <div class="cd-time-box"><span class="cd-number" id="cd-days">00</span><span class="cd-unit">Days</span></div>
                <span class="cd-sep">:</span>
                <div class="cd-time-box"><span class="cd-number" id="cd-hours">00</span><span class="cd-unit">Hours</span></div>
                <span class="cd-sep">:</span>
                <div class="cd-time-box"><span class="cd-number" id="cd-mins">00</span><span class="cd-unit">Mins</span></div>
                <span class="cd-sep">:</span>
                <div class="cd-time-box"><span class="cd-number" id="cd-secs">00</span><span class="cd-unit">Secs</span></div>
            </div>
            <?php endif; ?>

            <div class="d-flex align-items-center gap-2 py-3 py-lg-0">

                <div class="dropdown">
                    <button class="btn btn-outline-light btn-sm rounded-pill px-4 dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-box-arrow-in-right"></i> เข้าสู่ระบบ
                    </button>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-skj mt-2">
                        <a href="https://student.skj.ac.th/" class="dropdown-item dropdown-item-skj"><i class="bi bi-person-fill"></i> สำหรับนักเรียน</a>
                        <a href="https://teacher.skj.ac.th/" class="dropdown-item dropdown-item-skj"><i class="bi bi-person-workspace"></i> สำหรับครูผู้สอน</a>
                        <a href="<?= base_url('Manager/Dashboard') ?>" class="dropdown-item dropdown-item-skj"><i class="bi bi-bar-chart-line-fill"></i> สำหรับผู้บริหาร</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
<!-- Navbar End -->

<script>


    // Smart Mega Menu Positioning
    document.addEventListener('DOMContentLoaded', () => {
        const megaMenus = document.querySelectorAll('.mega-menu-premium');
        const navItems = document.querySelectorAll('.nav-item.dropdown');

        const adjustPosition = (menu) => {
            // Reset positions first
            menu.classList.remove('shift-left', 'shift-right');
            
            const rect = menu.getBoundingClientRect();
            const viewportWidth = window.innerWidth;

            if (rect.right > viewportWidth) {
                // Overflowing right side
                menu.classList.add('shift-left');
            } else if (rect.left < 0) {
                // Overflowing left side
                menu.classList.add('shift-right');
            }
        };

        navItems.forEach(item => {
            item.addEventListener('mouseenter', () => {
                const menu = item.querySelector('.mega-menu-premium');
                if (menu) {
                    requestAnimationFrame(() => adjustPosition(menu));
                }
            });
        });

        window.addEventListener('resize', () => {
            megaMenus.forEach(menu => {
                if (window.getComputedStyle(menu).display !== 'none') {
                    adjustPosition(menu);
                }
            });
        });

        // Sticky Shrink Navbar on Scroll
        const navbar = document.querySelector('.navbar-skj');
        if (navbar) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 100) {
                    navbar.classList.add('navbar-shrink');
                } else {
                    navbar.classList.remove('navbar-shrink');
                }
            });
        }
    });
</script>