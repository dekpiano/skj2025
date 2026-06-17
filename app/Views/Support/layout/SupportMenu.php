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

        <!-- App Check-in -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">ลงเวลางานผ่านแอป</span></li>
        <li class="menu-item <?= ($uri->getSegment(2) == 'SupportAttendance' && ($uri->getTotalSegments() == 2 || ($uri->getSegment(3) == 'History' && \Config\Services::request()->getGet('type') !== 'official'))) ? 'active open' : '' ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-mobile"></i>
                <div>ลงเวลางานผ่านแอป</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= ($uri->getSegment(2) == 'SupportAttendance' && $uri->getTotalSegments() == 2) ? 'active' : '' ?>">
                    <a href="<?= base_url('Support/SupportAttendance') ?>" class="menu-link">
                        <div>เช็คชื่อเข้างาน</div>
                    </a>
                </li>
                <li class="menu-item <?= ($uri->getSegment(2) == 'SupportAttendance' && $uri->getSegment(3) == 'History' && \Config\Services::request()->getGet('type') !== 'official') ? 'active' : '' ?>">
                    <a href="<?= base_url('Support/SupportAttendance/History') ?>" class="menu-link">
                        <div>ประวัติลงเวลาผ่านแอป</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Fingerprint / Official Stats -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">ข้อมูลสแกนนิ้ว & วันลา</span></li>
        <li class="menu-item <?= ($uri->getSegment(2) == 'SupportAttendance' && ($uri->getSegment(3) == 'Report' || $uri->getSegment(3) == 'FingerprintHistory')) ? 'active open' : '' ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-fingerprint"></i>
                <div>ประวัติงานบุคลากร</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= ($uri->getSegment(2) == 'SupportAttendance' && $uri->getSegment(3) == 'FingerprintHistory') ? 'active' : '' ?>">
                    <a href="<?= base_url('Support/SupportAttendance/FingerprintHistory') ?>" class="menu-link">
                        <div>ประวัติสแกนนิ้ว & ลา</div>
                    </a>
                </li>
                <li class="menu-item <?= ($uri->getSegment(2) == 'SupportAttendance' && $uri->getSegment(3) == 'Report') ? 'active' : '' ?>">
                    <a href="<?= base_url('Support/SupportAttendance/Report') ?>" class="menu-link">
                        <div>รายงานสรุปรายเดือน</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
