<?= $this->extend('Admin/layout/AdminLayout') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">เมนูการใช้งาน /</span> <?= $title ?>
    </h4>

    <div class="row">
        <!-- News Card -->
        <div class="col-md-6 col-lg-4 mb-4">
            <a href="<?= base_url('Admin/News') ?>">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="bx bx-news bx-lg text-primary mb-3"></i>
                        <h5 class="card-title">ข่าวประชาสัมพันธ์</h5>
                        <p class="card-text">จัดการข่าวสารและกิจกรรม</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Banner Card -->
        <div class="col-md-6 col-lg-4 mb-4">
            <a href="<?= base_url('Admin/Banner') ?>">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="bx bx-images bx-lg text-info mb-3"></i>
                        <h5 class="card-title">แบนเนอร์</h5>
                        <p class="card-text">จัดการแบนเนอร์ประชาสัมพันธ์</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Role Management Card (Super Admin only) -->
        <?php if (in_array('Super Admin', session('roles') ?? [])) : ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <a href="<?= base_url('Admin/roles') ?>">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="bx bx-shield-quarter bx-lg text-danger mb-3"></i>
                            <h5 class="card-title">จัดการสิทธิ์</h5>
                            <p class="card-text">จัดการผู้ดูแลระบบและสิทธิ์</p>
                        </div>
                    </div>
                </a>
            </div>
        <?php endif; ?>
    </div>

    <h5 class="fw-bold py-3 my-4">
        <span class="text-muted fw-light">จัดการข้อมูล /</span> เกี่ยวกับโรงเรียน
    </h5>

    <div class="row">
        <!-- About School Submenu Cards -->
        <?php if (!empty($AboutSchool)) : ?>
            <?php foreach ($AboutSchool as $key => $v_AboutSchool) : ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <a href="<?= base_url('Admin/AboutSchool/Detail/' . $v_AboutSchool->id) ?>">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <i class="bx bx-buildings bx-md text-success"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="card-title mb-0"><?= $v_AboutSchool->about_menu ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>
<?= $this->endSection() ?>
