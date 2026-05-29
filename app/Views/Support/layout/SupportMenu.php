<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="<?= base_url('Support/Dashboard') ?>" class="app-brand-link">
            <span class="app-brand-logo demo">
                 <img src="<?= base_url('uploads/logoSchool/LogoSKJ_4.png') ?>" width="40" alt="Logo">
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2" style="text-transform: capitalize;">ฝ่ายสนับสนุน</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item <?= ($uri->getSegment(2) == 'Dashboard') ? 'active' : '' ?>">
            <a href="<?= base_url('Support/Dashboard') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>หน้าแรก (Dashboard)</div>
            </a>
        </li>

        <!-- Support Attendance -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">ระบบลงเวลาปฏิบัติงาน</span></li>
        <li class="menu-item <?= ($uri->getSegment(2) == 'SupportAttendance') ? 'active open' : '' ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-time-five"></i>
                <div>ลงเวลางานฝ่ายสนับสนุน</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= ($uri->getSegment(2) == 'SupportAttendance' && $uri->getTotalSegments() == 2) ? 'active' : '' ?>">
                    <a href="<?= base_url('Support/SupportAttendance') ?>" class="menu-link">
                        <div>เช็คชื่อเข้างาน</div>
                    </a>
                </li>
                <li class="menu-item <?= ($uri->getSegment(2) == 'SupportAttendance' && $uri->getSegment(3) == 'History') ? 'active' : '' ?>">
                    <a href="<?= base_url('Support/SupportAttendance/History') ?>" class="menu-link">
                        <div>ประวัติลงเวลา</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
