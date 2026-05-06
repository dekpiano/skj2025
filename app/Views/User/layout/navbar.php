<!-- Brand & Contact Start -->
<div class="container-fluid py-3 px-4 wow fadeIn d-none d-xl-block top-bar-premium" data-wow-delay="0.1s">
    <div class="row align-items-center">
        <div class="col-lg-5">
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
        <div class="col-lg-7">
            <div class="d-flex justify-content-end align-items-center top-info-container">
                <div class="top-info-wrapper d-flex align-items-center me-4">
                    <div class="info-item-nav">
                        <div class="info-icon-nav email-grad"><i class="bi bi-clock"></i></div>
                        <div class="ms-3">
                            <div class="info-label-nav">เวลาทำการ</div>
                            <div class="info-value-nav">จันทร์ - ศุกร์, 08:30 - 16:30</div>
                        </div>
                    </div>
                    <div class="info-item-nav">
                        <div class="info-icon-nav phone-grad"><i class="bi bi-telephone"></i></div>
                        <div class="ms-3">
                            <div class="info-label-nav">ติดต่อเรา</div>
                            <div class="info-value-nav">056-009-667</div>
                        </div>
                    </div>
                    <div class="info-item-nav border-0">
                        <div class="info-icon-nav email-grad"><i class="bi bi-envelope"></i></div>
                        <div class="ms-3">
                            <div class="info-label-nav">อีเมล</div>
                            <div class="info-value-nav">skjns160@skj.ac.th</div>
                        </div>
                    </div>
                </div>
                <!-- Social Links -->
                <div class="social-links-nav d-flex gap-2">
                    <a href="https://www.facebook.com/SKJNS160" target="_blank" class="social-btn-nav fb" title="Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="https://youtube.com/channel/UC7p4cQQuIFLyrF68p7JbWDw?si=qOHoQSymoleB3ntP" target="_blank" class="social-btn-nav yt" title="YouTube"><i class="bi bi-youtube"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Brand & Contact End -->

<style>
    /* Premium Top Bar Styles - Meteor Shower Line Art */
    .top-bar-premium {
        background-color: #ffffff;
        background-image: 
            url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='200' viewBox='0 0 400 200'%3E%3Cg stroke='%23249ffd' stroke-width='1.5' stroke-opacity='0.15' stroke-linecap='round'%3E%3Cline x1='350' y1='-20' x2='300' y2='80' /%3E%3Cline x1='150' y1='20' x2='100' y2='120' /%3E%3Cline x1='420' y1='50' x2='380' y2='130' /%3E%3C/g%3E%3Cg stroke='%23000000' stroke-width='1' stroke-opacity='0.1' stroke-linecap='round'%3E%3Cline x1='250' y1='10' x2='220' y2='70' /%3E%3Cline x1='50' y1='100' x2='20' y2='160' /%3E%3Cline x1='380' y1='150' x2='360' y2='190' /%3E%3Cline x1='120' y1='-10' x2='100' y2='30' /%3E%3C/g%3E%3C/svg%3E"),
            linear-gradient(135deg, rgba(251, 126, 156, 0.05) 0%, rgba(36, 159, 253, 0.05) 100%);
        background-size: 400px 200px, cover;
        background-attachment: fixed;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        position: relative;
        overflow: hidden;
    }
        background-attachment: fixed;
        border-bottom: 1px solid rgba(251, 126, 156, 0.1);
        position: relative;
        overflow: hidden;
    }

    /* Decorative background blobs */
    .top-bar-premium::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 150px;
        height: 150px;
        background: radial-gradient(circle, rgba(251, 126, 156, 0.05) 0%, transparent 70%);
        z-index: 0;
    }

    .top-bar-premium .row {
        position: relative;
        z-index: 1;
    }

    .logo-wrapper-nav {
        background: #fff;
        padding: 8px;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(251, 126, 156, 0.1);
        transition: all 0.3s ease;
    }

    .logo-wrapper-nav img {
        height: 60px;
        transition: transform 0.3s ease;
    }

    .navbar-brand-premium:hover .logo-wrapper-nav {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(251, 126, 156, 0.2);
    }
    
    .navbar-brand-premium:hover .logo-wrapper-nav img {
        transform: scale(1.05);
    }

    .brand-text-nav {
        font-family: 'K2D', sans-serif;
    }

    .text-thai-nav {
        color: #1a2a4d; /* Darker for better contrast on colorful bg */
        font-weight: 800;
        font-size: 1.35rem;
        line-height: 1.1;
        background: linear-gradient(45deg, #FB7E9C, #d44d6e);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .text-eng-nav {
        color: #249ffd;
        font-size: 0.85rem;
        font-weight: 700;
        letter-spacing: 0.8px;
        margin-top: 2px;
    }

    .top-info-container {
        gap: 1.5rem;
    }

    .info-item-nav {
        display: flex;
        align-items: center;
        padding: 0 20px;
        border-right: 1px solid rgba(0,0,0,0.08);
    }

    .info-icon-nav {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .info-item-nav:hover .info-icon-nav {
        transform: scale(1.1) rotate(5deg);
    }

    .time-grad { background: linear-gradient(135deg, #249ffd 0%, #1a2a4d 100%); }
    .phone-grad { background: linear-gradient(135deg, #FB7E9C 0%, #ff5e62 100%); }
    .email-grad { background: linear-gradient(135deg, #3ab5ff 0%, #249ffd 100%); }

    .info-label-nav {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #777;
        font-weight: 800;
        margin-bottom: 0px;
    }

    .info-value-nav {
        font-size: 0.95rem;
        color: #1a2a4d;
        font-weight: 700;
    }

    /* Social Buttons */
    .social-btn-nav {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        color: #fff;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .social-btn-nav.fb { background: #1877F2; box-shadow: 0 4px 10px rgba(24, 119, 242, 0.3); }
    .social-btn-nav.yt { background: #FF0000; box-shadow: 0 4px 10px rgba(255, 0, 0, 0.3); }
    .social-btn-nav.line { background: #06C755; box-shadow: 0 4px 10px rgba(6, 199, 85, 0.3); }

    .social-btn-nav:hover {
        transform: translateY(-3px);
        color: #fff;
        filter: brightness(1.1);
    }

    /* Responsive Top Bar Info Adjustments */
    @media (min-width: 1200px) and (max-width: 1400px) {
        .info-item-nav { padding: 0 10px; }
        .text-thai-nav { font-size: 1.1rem; }
        .text-eng-nav { font-size: 0.7rem; }
        .logo-wrapper-nav img { height: 45px; }
        .logo-wrapper-nav { padding: 5px; }
        .info-icon-nav { width: 32px; height: 32px; font-size: 0.9rem; border-radius: 10px; }
        .info-value-nav { font-size: 0.75rem; }
        .info-label-nav { font-size: 0.6rem; letter-spacing: 0.5px; }
        .top-info-container { gap: 0.8rem; }
        /* Add Nav link compression here - EXTRA COMPACT */
        .navbar-skj .nav-link {
            padding: 8px 6px !important; /* บีบระยะห่างให้เหลือเท่าที่จำเป็น */
            font-size: 0.85rem !important; /* ลดขนาดเล็กลงเพื่อให้พอดีแนวนอน (iPad Pro Landscape) */
            gap: 4px; /* ช่องไฟระหว่างไอคอนกับตัวอักษร */
            margin: 0 1px;
            white-space: nowrap !important; /* บังคับให้อยู่บรรทัดเดียว ห้ามตกลงมาทับกัน */
            letter-spacing: -0.2px; /* บีบช่องไฟของตัวอักษรเล็กน้อย */
        }
        .navbar-skj .navbar-nav {
            flex-wrap: nowrap !important; /* ห้ามเมนูร่วงมาบรรทัดใหม่ */
        }
        .navbar-skj {
            margin: 10px 15px; 
            padding: 2px 15px !important; /* ลดความหนาของตัวแถบเพื่อให้หน้าเว็บดูโปร่งขึ้น */
        }
    }

    @media (max-width: 1250px) {
        .social-links-nav { display: none !important; }
    }


    /* Header Style: Large & Floating */
    .navbar-skj {
        background: rgba(251, 126, 156, 0.85) !important;
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        margin: 15px 25px;
        padding: 12px 30px !important;
        border-radius: 60px;
        box-shadow: 0 15px 35px rgba(251, 126, 156, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.3);
        z-index: 1030;
        transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
        position: sticky !important;
        top: 15px !important;
    }

    .navbar-skj .nav-link {
        color: #fff !important;
        font-weight: 700;
        padding: 12px 20px !important;
        border-radius: 50px;
        margin: 0 4px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 1.05rem;
    }

    /* Scrolled Style: Compact & High Tech */
    .navbar-skj.navbar-scrolled {
        margin: 8px 15px;
        padding: 5px 25px !important;
        background: rgba(251, 126, 156, 0.98) !important;
        box-shadow: 
            0 10px 30px rgba(0, 0, 0, 0.1),
            0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        top: 8px !important;
        transform: scale(0.995);
    }
    
    .navbar-skj.navbar-scrolled .nav-link {
        padding: 8px 15px !important;
        font-size: 0.92rem;
    }

    /* Shrink Mobile Brand proportionally */
    .navbar-skj.navbar-scrolled .navbar-brand-mobile img {
        height: 28px;
    }

    .navbar-skj.navbar-scrolled .brand-text-mobile {
        transform: scale(0.9);
        transform-origin: left center;
    }

    /* --- Mobile Specific Minimal Look (Always Compact) --- */
    @media (max-width: 1199px) {
        .navbar-skj {
            margin: 5px 5px !important;
            border-radius: 20px !important;
            padding: 5px 8px !important; /* Reduced padding to push items outward */
            top: 5px !important;
            position: fixed !important;
            width: calc(100% - 10px);
        }

        .navbar-skj .container-fluid {
            padding-left: 2px !important;
            padding-right: 2px !important;
        }

        .navbar-skj .nav-link {
            padding: 10px 15px !important; /* Compact by default for mobile */
            font-size: 0.9rem !important;
            border-radius: 0;
            margin: 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
    }

    /* Tablet Specific breathing room */
    @media (min-width: 768px) and (max-width: 1199px) {
        .navbar-skj {
            /* margin: 10px 15px !important; */
            padding: 10px 20px !important;
        }
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
    @media (min-width: 1200px) {
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

    @media (max-width: 1199px) {
        .navbar-skj .navbar-brand {
            flex: 1;
            min-width: 0;
            margin-right: 10px;
        }

        .navbar-collapse {
            flex-basis: 100%; /* Force collapse menu to take full width and wrap to next line */
            margin-top: 10px;
        }
    }

    .navbar-brand-mobile {
        display: flex;
        align-items: center;
        gap: 8px; /* Balanced gap */
        text-decoration: none;
        min-width: 0;
    }

    .navbar-brand-mobile img {
        height: 45px; /* Increased from 32px */
        flex-shrink: 0;
        transition: all 0.3s ease;
    }

    @media (max-width: 375px) {
        .navbar-brand-mobile img {
            height: 40px; /* Slightly smaller on very narrow screens but still large */
        }
    }

    .brand-text-mobile {
        color: #fff;
        font-weight: 700;
        font-size: clamp(0.5rem, 3.9vw, 0.95rem); /* Default mobile scaling */
        line-height: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-width: 0;
        flex: 1;
    }

    /* Tablet Specific: Adjust size to prevent text overflow */
    @media (min-width: 768px) and (max-width: 1199px) {
        .brand-text-mobile {
            font-size: 1.15rem; /* ขยับขึ้นมานิดนึงเพื่อให้สมดุลกับจอแท็บเล็ตที่กว้างขึ้น */
        }
    }

    .brand-text-mobile .thai-name {
        display: block;
        margin-bottom: 1px;
        white-space: nowrap;
        overflow: visible;
    }

    .brand-text-mobile .eng-name {
        display: block;
        font-size: 0.55em;
        font-weight: 500;
        opacity: 0.9;
        letter-spacing: 0.1px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .navbar-toggler-skj {
        border: none;
        padding: 5px;
        outline: none !important;
        box-shadow: none !important;
        flex-shrink: 0; /* Keep toggler from shrinking */
    }

    .toggler-icon-premium {
        width: 35px; /* Increased from 30px */
        height: 3px; /* Slightly thicker */
        background: #fff;
        display: block;
        margin: 7px 0; /* More spacing */
        transition: all 0.3s ease;
        border-radius: 3px;
    }

    @media (max-width: 1199px) {
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

    @media (max-width: 1199px) {
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
    @media (min-width: 1200px) {
        /* --- Absolute Fix for Login Dropdown --- */
    .login-container-nav .dropdown-menu-skj {
        display: none; 
        opacity: 1 !important;
        visibility: visible !important;
        transform: none !important;
        z-index: 9999 !important;
        margin-top: 5px !important;
        background: #ffffff !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important;
        pointer-events: auto !important;
    }

    .login-container-nav .dropdown.show .dropdown-menu-skj,
    .login-container-nav .dropdown-menu-skj.show,
    .login-container-nav .dropdown:hover > .dropdown-menu-skj {
        display: block !important;
    }

    /* Keep other dropdowns with premium effect */
    @media (min-width: 1200px) {
        .navbar-nav .nav-item.dropdown:hover > .dropdown-menu-skj {
            display: block !important;
            opacity: 1 !important;
            visibility: visible !important;
            transform: translateY(0) !important;
            margin-top: 5px !important;
        }
        
        .navbar-nav .dropdown-menu-skj {
            transform: translateY(10px);
            transition: all 0.3s ease;
            display: block;
            visibility: hidden;
            opacity: 0;
        }
    }

    .login-container-nav {
        position: relative;
        z-index: 1080 !important;
    }
    .dropdown-menu-skj::before {
            content: '';
            position: absolute;
            top: -15px;
            left: 0;
            right: 0;
            height: 15px;
            background: transparent;
            z-index: -1;
        }
    }

    /* Ensure navbar internal clicks work and nothing blocks them */
    .login-container-nav {
        position: relative;
        z-index: 1060 !important; /* Extremely high to be on top */
        pointer-events: auto !important;
        cursor: pointer;
    }

    .login-container-nav button {
        cursor: pointer !important;
    }
</style>

<!-- Navbar Start -->
<nav class="navbar navbar-expand-xl navbar-skj sticky-top">
    <div class="container-fluid px-2 px-xl-5">
        <a href="<?= base_url('/'); ?>" class="navbar-brand d-xl-none">
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
                        <a href="<?= base_url('Board') ?>" class="dropdown-item dropdown-item-skj">
                            <i class="bi bi-people-fill"></i> คณะกรรมการสถานศึกษา
                        </a>
                        <a href="<?= base_url('Botany') ?>" class="dropdown-item dropdown-item-skj">
                            <i class="bi bi-tree-fill"></i> งานสวนพฤกษศาสตร์
                        </a>
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
                                <a href="<?= base_url('Botany') ?>" class="dropdown-item dropdown-item-skj"><i class="bi bi-tree-fill"></i> งานสวนพฤกษศาสตร์</a>
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

        <!-- Moved Outside Collapse to ensure clickable/hoverable -->
        <div class="d-flex align-items-center gap-2 py-3 py-xl-0 login-container-nav ms-xl-3">
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

        // Sticky Effects on Scroll
        const navbar = document.querySelector('.navbar-skj');
        if (navbar) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    navbar.classList.add('navbar-scrolled');
                } else {
                    navbar.classList.remove('navbar-scrolled');
                }
            });
        }
    });
</script>