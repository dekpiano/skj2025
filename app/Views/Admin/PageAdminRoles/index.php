<?= $this->extend('Admin/layout/AdminLayout') ?>

<?= $this->section('content') ?>
<div class="container-fluid mt-4">

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Add New Admin User Card -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">เพิ่มผู้ดูแลระบบใหม่</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('Admin/roles/addUser') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="pers_id" class="form-label">เลือกบุคลากร</label>
                            <select class="form-select" id="pers_id" name="pers_id" required>
                                <option value="">-- เลือกบุคลากร --</option>
                                <?php foreach ($personnel as $person) : ?>
                                    <option value="<?= $person['pers_id'] ?>" data-email="<?= $person['pers_username'] ?>"><?= $person['pers_prefix'].$person['pers_firstname'] . ' ' . $person['pers_lastname'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="admin_username" class="form-label">Username (Email)</label>
                            <input type="email" class="form-control" id="admin_username" name="admin_username" readonly required>
                        </div>
                        <div class="mb-3">
                            <label for="role_id" class="form-label">กำหนดสิทธิ์</label>
                            <select class="form-select" id="role_id" name="role_id" required>
                                <option value="">-- เลือกสิทธิ์ --</option>
                                <?php foreach ($roles as $role) : ?>
                                    <option value="<?= $role['role_id'] ?>"><?= $role['role_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">เพิ่มผู้ดูแลระบบ</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- List Admin Users Card -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">รายชื่อผู้ดูแลระบบ</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ชื่อ-สกุล</th>
                                <th>Username</th>
                                <th>สิทธิ์</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($admin_users)) : ?>
                                <?php foreach ($admin_users as $user) : ?>
                                    <tr>
                                        <td><?= $user['pers_firstname'] . ' ' . $user['pers_lastname'] ?></td>
                                        <td><?= $user['admin_username'] ?></td>
                                        <td><span class="badge bg-primary"><?= $user['role_name'] ?></span></td>
                                        <td>
                                            <a href="<?= base_url('Admin/roles/deleteUser/' . $user['admin_id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('คุณต้องการลบผู้ใช้นี้ใช่หรือไม่?')">
                                                <i class="bi bi-trash"></i> ลบ
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="4" class="text-center">ไม่มีข้อมูลผู้ดูแลระบบ</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const personnelSelect = $('#pers_id');
    const usernameInput = $('#admin_username');

    // Initialize Select2
    personnelSelect.select2({
        theme: 'bootstrap-5',
        placeholder: "-- เลือกบุคลากร --",
        allowClear: true,
        width: '100%'
    });

    // Listen for Select2 change event
    personnelSelect.on('change', function() {
        const selectedOption = $(this).find('option:selected');
        const email = selectedOption.data('email');
        usernameInput.val(email || '');
    });
});
</script>

<?= $this->endSection() ?>
