<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="<?= base_url('Botany') ?>" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="<?=base_url('uploads/logoSchool/LogoSKJ_4.png');?>" alt="" style="width:36px">
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2" style="font-size: 1.0rem;">งานสวนพฤกษศาสตร์<br>โรงเรียน</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <?php $seg2 = service('uri')->getSegment(3); ?>
        
        <li class="menu-item <?= $seg2 == '' ? 'active' : '' ?>">
            <a href="<?=base_url('admin/botany');?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">หน้าแรก / แดชบอร์ด</div>
            </a>
        </li>

        <li class="menu-item <?= strtolower($seg2) == 'list' ? 'active' : '' ?>">
            <a href="<?=base_url('admin/botany/list');?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-leaf"></i>
                <div data-i18n="Analytics">จัดการพรรณไม้</div>
            </a>
        </li>

        <li class="menu-item <?= strtolower($seg2) == 'news' ? 'active' : '' ?>">
            <a href="<?=base_url('admin/botany/news');?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-news"></i>
                <div data-i18n="Analytics">จัดการกิจกรรม/ข่าว</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">เว็บไซต์</span>
        </li>
        <li class="menu-item">
            <a href="<?=base_url('botany');?>" class="menu-link" target="_blank">
                <i class="menu-icon tf-icons bx bx-globe"></i>
                <div data-i18n="Analytics">ดูหน้าเว็บไซต์หลัก</div>
            </a>
        </li>
    </ul>
</aside>
