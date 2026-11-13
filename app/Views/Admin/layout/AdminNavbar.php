<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-2 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-2 me-xl-4 text-primary d-flex align-items-center justify-content-center rounded-3" href="javascript:void(0)" style="min-width: 44px; min-height: 44px;" aria-label="เปิดเมนู">
            <i class="bx bx-menu fs-4"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search Input with Modern Pill -->
        <div class="navbar-nav align-items-center">
            <div class="nav-item d-flex align-items-center">
                <div class="search-wrapper">
                    <i class="bx bx-search text-muted me-1.5" style="font-size: 1.05rem;"></i>
                    <input type="text" placeholder="ค้นหาเมนูหรือฟังก์ชัน..." aria-label="Search..." />
                    <span class="badge bg-white text-muted border px-1.5 py-0.5 rounded d-none d-md-inline ms-1 shadow-2xs font-monospace" style="font-size: 0.62rem; letter-spacing: 0.02em;">Ctrl K</span>
                </div>
            </div>
        </div>
        <!-- /Search -->

        <ul class="navbar-nav flex-row align-items-center ms-auto gap-2">
            <!-- Quick Link: Visit Public Website -->
            <li class="nav-item d-none d-md-block">
                <a href="<?= base_url('/'); ?>" target="_blank" class="nav-quick-btn" title="เปิดดูหน้าเว็บไซต์หลัก">
                    <i class="bx bx-globe text-primary"></i>
                    <span>หน้าเว็บไซต์</span>
                    <i class="bx bx-link-external small text-muted"></i>
                </a>
            </li>

            <div class="vr mx-2 text-muted opacity-25 d-none d-sm-block" style="height: 24px;"></div>

            <!-- User Menu -->
            <?php 
                $user_img = session('personnel')['pers_img'] ?? null; 
                $avatar_src = $user_img ? "https://personnel.skj.ac.th/uploads/admin/Personnal/".$user_img: base_url('assets/admin/assets/img/avatars/1.png'); 
                $user_role = session('roles')[0] ?? 'Admin';
            ?>
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="user-chip-btn">
                        <div class="avatar avatar-online">
                            <img src="<?= $avatar_src ?>" alt="Avatar" class="w-px-38 h-px-38 rounded-circle" style="object-fit: cover;" />
                        </div>
                        <div class="d-none d-lg-block text-start me-1">
                            <span class="fw-semibold d-block text-dark lh-1" style="font-size: 0.88rem;"><?= session('AdminFullname') ?? 'Admin User' ?></span>
                            <small class="badge bg-label-primary px-2 py-0 mt-1" style="font-size: 0.7rem;"><?= $user_role ?></small>
                        </div>
                        <i class="bx bx-chevron-down text-muted d-none d-lg-block small"></i>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg mt-2 border-0 rounded-3" style="min-width: 230px; max-width: calc(100vw - 30px);">
                    <li>
                        <div class="dropdown-item py-2 px-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-online me-3">
                                    <img src="<?= $avatar_src ?>" alt="Avatar" class="w-px-40 h-px-40 rounded-circle" style="object-fit: cover;" />
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-bold d-block text-dark"><?= session('AdminFullname') ?></span>
                                    <span class="badge bg-label-primary"><?= $user_role ?></span>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="dropdown-divider my-1"></div>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="<?= base_url('Admin/Dashboard'); ?>">
                            <i class="bx bx-home-circle me-2 text-primary"></i>
                            <span>หน้าแรกแดชบอร์ด</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="<?= base_url('Admin/Logs'); ?>">
                            <i class="bx bx-history me-2 text-info"></i>
                            <span>บันทึกการใช้งาน (Logs)</span>
                        </a>
                    </li>
                    <?php if (in_array('Super Admin', session('roles') ?? [])): ?>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="<?= base_url('Admin/Settings'); ?>">
                            <i class="bx bx-cog me-2 text-secondary"></i>
                            <span>ตั้งค่าระบบ</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <li>
                        <div class="dropdown-divider my-1"></div>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center text-danger" href="<?= base_url('logout'); ?>">
                            <i class="bx bx-power-off me-2"></i>
                            <span class="fw-semibold">ออกจากระบบ (Log Out)</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--/ User Menu -->
        </ul>
    </div>
</nav>