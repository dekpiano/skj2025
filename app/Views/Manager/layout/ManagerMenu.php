<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="<?= base_url('Manager/Dashboard') ?>" class="app-brand-link">
            <span class="app-brand-logo demo">
                <!-- SVG Logo or Image -->
                 <img src="<?= base_url('uploads/logoSchool/LogoSKJ_4.png') ?>" width="40" alt="Logo">
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2" style="text-transform: capitalize;">ผู้บริหาร</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item <?= ($uri->getSegment(2) == 'Dashboard') ? 'active' : '' ?>">
            <a href="<?= base_url('Manager/Dashboard') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">ภาพรวม (Dashboard)</div>
            </a>
        </li>

        <!-- Executive Attendance -->
        <li class="menu-item <?= ($uri->getSegment(2) == 'ManagerAttendance') ? 'active open' : '' ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-time-five"></i>
                <div data-i18n="Attendance">ลงเวลางานผู้บริหาร</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= ($uri->getSegment(2) == 'ManagerAttendance' && $uri->getTotalSegments() == 2) ? 'active' : '' ?>">
                    <a href="<?= base_url('Manager/ManagerAttendance') ?>" class="menu-link">
                        <div data-i18n="CheckIn">เช็คชื่อเข้างาน</div>
                    </a>
                </li>
                <li class="menu-item <?= ($uri->getSegment(2) == 'ManagerAttendance' && $uri->getSegment(3) == 'History') ? 'active' : '' ?>">
                    <a href="<?= base_url('Manager/ManagerAttendance/History') ?>" class="menu-link">
                        <div data-i18n="AttendanceHistory">ประวัติลงเวลา</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Personnel -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">งานบุคลากร</span></li>
        <li class="menu-item <?= ($uri->getSegment(2) == 'Personnel') ? 'active' : '' ?>">
            <a href="<?= base_url('Manager/Personnel') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-pin"></i>
                <div data-i18n="Personnel">ภาพรวมบุคลากร</div>
            </a>
        </li>
        <li class="menu-item <?= ($uri->getSegment(2) == 'Evaluation') ? 'active open' : '' ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-check-shield"></i>
                <div data-i18n="Evaluation">ประเมินผลการปฏิบัติงาน</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= ($uri->getSegment(2) == 'Evaluation' && $uri->getTotalSegments() == 2) ? 'active' : '' ?>">
                    <a href="<?= base_url('Manager/Evaluation') ?>" class="menu-link">
                        <div data-i18n="EvaluationReview">ตรวจสอบผลการประเมิน</div>
                    </a>
                </li>
                <li class="menu-item <?= ($uri->getSegment(2) == 'Evaluation' && $uri->getSegment(3) == 'Submit') ? 'active' : '' ?>">
                    <a href="<?= base_url('Manager/Evaluation/Submit') ?>" class="menu-link">
                        <div data-i18n="EvaluationSubmit">ส่งผลการปฏิบัติงาน (สำหรับรองฯ)</div>
                    </a>
                </li>
            </ul>
        </li>

         <!-- Academic -->
         <li class="menu-header small text-uppercase"><span class="menu-header-text">งานวิชาการ</span></li>
        <li class="menu-item <?= ($uri->getSegment(2) == 'Academic' && $uri->getSegment(3) == 'student') ? 'active' : '' ?>">
            <a href="<?= base_url('Manager/Academic/student') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-book-reader"></i>
                <div data-i18n="AcademicStudent">ภาพรวมนักเรียน</div>
            </a>
        </li>
        <li class="menu-item <?= ($uri->getSegment(2) == 'Academic' && $uri->getSegment(3) == 'Teacher') ? 'active' : '' ?>">
            <a href="<?= base_url('Manager/Academic/Teacher') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-id-card"></i>
                <div data-i18n="AcademicTeacher">ภาพรวมครู</div>
            </a>
        </li>

        <!-- Admin General -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">งานบริหารทั่วไป</span></li>
        <li class="menu-item <?= ($uri->getSegment(2) == 'General') ? 'active' : '' ?>">
            <a href="<?= base_url('Manager/General') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div data-i18n="General">ภาพรวมงานบริหารทั่วไป</div>
            </a>
        </li>

    </ul>
</aside>
