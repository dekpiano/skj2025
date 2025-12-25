<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="<?=base_url('uploads/logoSchool/LogoSKJ_4.png');?>" alt="" style="width:36px">
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2" style="font-size: 1.0rem;
">ระบบงานสารสนเทศ<br>เว็บไซต์โรเรียน</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item <?=$uri->getSegment(2) == 'Dashboard'?"active":""?>">
            <a href="<?=base_url('Admin/Dashboard');?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">หน้าแรก</div>
            </a>
        </li>

        <li class="menu-item <?=$uri->getSegment(2) == 'News'?"active":""?>">
            <a href="<?=base_url('Admin/News');?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-news"></i>
                <div data-i18n="Analytics">ข่าวประชาสัมพันธ์</div>
            </a>
        </li>

        <li class="menu-item <?=$uri->getSegment(2) == 'Banner'?"active":""?>">
            <a href="<?=base_url('Admin/Banner');?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-images"></i>
                <div data-i18n="Analytics">แบนเนอร์ประชาสัมพันธ์</div>
            </a>
        </li>
      
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Pages</span>
        </li>
        <!-- Layouts -->
        <li class="menu-item <?=$uri->getSegment(2) == 'AboutSchool'?"active open":""?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-buildings"></i>
                <div data-i18n="Layouts">เกี่ยวกับโรงเรียน</div>
            </a>
            <ul class="menu-sub ">
                <?php
                if ($uri->getTotalSegments() >= 4) {
                        $active = $uri->getSegment(4);
                    } else {
                        $active = null;
                    }
                ?>
                <?php if (!empty($AboutSchool)) : ?>
                    <?php foreach ($AboutSchool as $key => $v_AboutSchool) : ?>
                    <li class="menu-item <?=$active == $v_AboutSchool->id?"active":""?>">
                        <a href="<?=base_url('Admin/AboutSchool/Detail/'.$v_AboutSchool->id)?>" class="menu-link">
                            <div data-i18n="Without menu"><?=$v_AboutSchool->about_menu?></div>
                        </a>
                    </li>         
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </li>

        <?php if (in_array('Super Admin', session('roles') ?? [])) : ?>
        <li class="menu-item <?=$uri->getSegment(2) == 'roles'?"active":""?>">
            <a href="<?=base_url('Admin/roles');?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-shield-quarter"></i>
                <div data-i18n="Analytics">จัดการสิทธิ์</div>
            </a>
        </li>
        <li class="menu-item <?=$uri->getSegment(2) == 'Logs'?"active":""?>">
            <a href="<?=base_url('Admin/Logs');?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-list-ul"></i>
                <div data-i18n="Analytics">บันทึกการใช้งาน (Log)</div>
            </a>
        </li>
        <?php endif; ?>

    </ul>
</aside>