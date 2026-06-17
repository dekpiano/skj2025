<?php
    $userImg = session('AdminImage') ?? '';
    $userName = session('AdminFullname') ?? 'Support Staff';
    // Create initials from first character of firstname
    $initials = mb_substr($userName, 0, 1);
    $hasImage = !empty($userImg);
    $imgUrl = 'https://personnel.skj.ac.th/uploads/admin/Personnal/' . $userImg;

    // Fetch official position name
    $personnel = session('personnel');
    $positionName = 'บุคลากรสายสนับสนุน';
    if ($personnel && !empty($personnel['pers_position'])) {
        $db = \Config\Database::connect('default');
        $posRow = $db->table('tb_position')
                     ->where('posi_id', $personnel['pers_position'])
                     ->get()
                     ->getRowArray();
        if ($posRow) {
            $positionName = $posRow['posi_name'];
        }
    }
?>
<nav
    class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar"
>
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <div class="navbar-nav align-items-center">
            <span class="fw-bold text-primary fs-5 d-none d-md-inline">ระบบสารสนเทศฝ่ายสนับสนุน (EIS - Support View)</span>
        </div>

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- User Dropdown -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow d-flex align-items-center" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="text-end me-2 d-none d-sm-block">
                        <span class="fw-semibold d-block text-dark lh-1 mb-1"><?= $userName ?></span>
                        <small class="text-muted" style="font-size: 0.75rem;"><?= $positionName ?></small>
                    </div>
                    <div class="avatar avatar-online">
                        <?php if ($hasImage): ?>
                            <img src="<?= $imgUrl ?>" alt class="w-px-40 h-auto rounded-circle" style="object-fit: cover;" onerror="this.src='<?= base_url('assets/admin/assets/img/avatars/1.png') ?>'" />
                        <?php else: ?>
                            <span class="avatar-initial rounded-circle bg-label-primary"><?= $initials ?></span>
                        <?php endif; ?>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <?php if ($hasImage): ?>
                                            <img src="<?= $imgUrl ?>" alt class="w-px-40 h-auto rounded-circle" style="object-fit: cover;" onerror="this.src='<?= base_url('assets/admin/assets/img/avatars/1.png') ?>'" />
                                        <?php else: ?>
                                            <span class="avatar-initial rounded-circle bg-label-primary"><?= $initials ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block"><?= $userName ?></span>
                                    <small class="text-muted"><?= $positionName ?></small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?= base_url('logout') ?>">
                            <i class="bx bx-power-off me-2"></i>
                            <span class="align-middle">ออกจากระบบ</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--/ User Dropdown -->
        </ul>
    </div>
</nav>
