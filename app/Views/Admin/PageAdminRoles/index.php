<?= $this->extend('Admin/layout/AdminLayout') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">แดชบอร์ด /</span> จัดการสิทธิ์ผู้ดูแลระบบ
    </h4>

    <div class="row">
        <!-- Add New Admin User Card -->
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header border-bottom py-3">
                    <h5 class="card-title mb-0 text-primary fw-bold">เพิ่มผู้ดูแลระบบใหม่</h5>
                </div>
                <div class="card-body pt-4">
                    <form id="form-add-admin" action="<?= base_url('Admin/roles/addUser') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="mb-4">
                            <label for="pers_id" class="form-label fw-bold">เลือกบุคลากร</label>
                            <select class="form-select select2" id="pers_id" name="pers_id" required>
                                <option value="">-- ค้นหาชื่อบุคลากร --</option>
                                <?php foreach ($personnel as $person) : ?>
                                    <option value="<?= $person['pers_id'] ?>" data-email="<?= $person['pers_username'] ?>">
                                        <?= $person['pers_prefix'].$person['pers_firstname'] . ' ' . $person['pers_lastname'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="admin_username" class="form-label fw-bold">Username (Email)</label>
                            <input type="email" class="form-control bg-light" id="admin_username" name="admin_username" placeholder="อีเมลจะแสดงที่นี่" readonly required>
                        </div>

                        <div class="mb-4">
                            <label for="role_id" class="form-label fw-bold">กำหนดสิทธิ์การใช้งาน</label>
                            <select class="form-select" id="role_id" name="role_id" required>
                                <option value="">-- เลือกสิทธิ์ --</option>
                                <?php foreach ($roles as $role) : ?>
                                    <option value="<?= $role['role_id'] ?>"><?= $role['role_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg" id="btn-submit-user">
                                <span class="spinner-border spinner-border-sm d-none me-1" role="status" aria-hidden="true"></span>
                                <i class="bx bx-user-plus me-1"></i> เพิ่มผู้ดูแลระบบ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- List Admin Users Card -->
        <div class="col-md-7 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header border-bottom py-3">
                    <h5 class="card-title mb-0 text-primary fw-bold">รายชื่อผู้ดูแลระบบในปัจจุบัน</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover align-middle mb-0" id="roleTable">
                            <thead class="table-light">
                                <tr>
                                    <th style="display:none;">ID</th>
                                    <th>รายชื่อผู้ดูแลระบบ</th>
                                    <th>สิทธิ์การใช้งาน</th>
                                    <th width="10%">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($admin_users)) : ?>
                                    <?php foreach ($admin_users as $user) : ?>
                                        <tr id="user-row-<?= $user['admin_id'] ?>">
                                            <td style="display:none;"><?= $user['admin_id'] ?></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm me-3">
                                                        <span class="avatar-initial rounded-circle bg-label-primary">
                                                            <?= mb_substr($user['pers_firstname'], 0, 1) ?>
                                                        </span>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <span class="fw-bold text-dark"><?= $user['pers_firstname'] . ' ' . $user['pers_lastname'] ?></span>
                                                        <small class="text-muted"><?= $user['admin_username'] ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-label-<?= $user['role_name'] == 'Super Admin' ? 'danger' : 'primary' ?> px-3">
                                                    <?= $user['role_name'] ?>
                                                </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-icon btn-outline-danger delete-user" data-id="<?= $user['admin_id'] ?>" title="ลบ">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    const personnelSelect = $('#pers_id');
    const usernameInput = $('#admin_username');

    // Function to format Select2 options with images
    function formatPersonnel(person) {
        if (!person.id) return person.text;
        
        const email = $(person.element).data('email') || '';
        const img = email ? `https://personnel.skj.ac.th/uploads/admin/Personnal/${email}.jpg` : '';
        
        return $(`
            <div class="d-flex align-items-center py-1">
                <div class="avatar avatar-xs me-2">
                    <img src="${img}" onerror="this.src='<?= base_url('assets/admin/assets/img/avatars/1.png') ?>'" class="rounded-circle shadow-sm" style="width: 28px; height: 28px; object-fit: cover;">
                </div>
                <div class="d-flex flex-column">
                    <div class="fw-bold text-dark" style="font-size: 0.9rem; line-height: 1.2;">${person.text}</div>
                    <small class="text-muted" style="font-size: 0.75rem;">${email}</small>
                </div>
            </div>
        `);
    }

    function formatPersonnelSelection(person) {
        if (!person.id) return person.text;
        return person.text;
    }

    // Initialize Select2 with Standard Look
    if ($.fn.select2) {
        personnelSelect.select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: "-- ค้นหาชื่อบุคลากร --",
            allowClear: true,
            templateResult: formatPersonnel,
            templateSelection: formatPersonnelSelection,
            escapeMarkup: function(m) { return m; }
        });

        personnelSelect.on('change', function() {
            const selectedOption = $(this).find('option:selected');
            const email = selectedOption.data('email');
            usernameInput.val(email || '');
        });
    }

    // Initialize DataTable
    if ($.fn.DataTable) {
        $('#roleTable').DataTable({
            order: [[0, 'desc']],
            columnDefs: [
                { targets: 0, visible: false, searchable: false }
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "รหัส/ชื่อผู้ใช้...",
                lengthMenu: "_MENU_",
                zeroRecords: "ไม่พบข้อมูลที่ค้นหา",
                paginate: {
                    next: '<i class="bx bx-chevron-right"></i>',
                    previous: '<i class="bx bx-chevron-left"></i>'
                }
            }
        });
    }

    // Handle Form Submit with AJAX
    $('#form-add-admin').on('submit', function(e) {
        e.preventDefault();
        const $form = $(this);
        const $btn = $('#btn-submit-user');
        
        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: $form.serialize(),
            dataType: 'json',
            beforeSend: function() {
                $btn.prop('disabled', true).find('.spinner-border').removeClass('d-none');
            },
            complete: function() {
                $btn.prop('disabled', false).find('.spinner-border').addClass('d-none');
            },
            success: function(response) {
                if(response.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ!',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'ผิดพลาด',
                        text: response.message
                    });
                }
            }
        });
    });

    // Handle Delete User with AJAX
    $(document).on('click', '.delete-user', function() {
        const adminId = $(this).data('id');

        Swal.fire({
            title: 'ยืนยันการลบสิทธิ์?',
            text: "ผู้ใช้นี้เข้าถึงระบบแอดมินไม่ได้อีกต่อไป!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff3e1d',
            confirmButtonText: 'ยืนยันการลบ',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('Admin/roles/deleteUser') ?>/' + adminId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if(response.status) {
                            $(`#user-row-${adminId}`).fadeOut(function() {
                                $(this).remove();
                            });
                            Swal.fire({
                                icon: 'success',
                                title: 'ลบสำเร็จ!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'ผิดพลาด',
                                text: response.message
                            });
                        }
                    }
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>

<style>
    .card { border-radius: 0.75rem; }
    .table thead th { font-weight: 600; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; }
    .btn-icon { width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 0.375rem; }
    
    /* Standard Label Style */
    .form-label { color: #566a7f; font-size: 0.85rem; margin-bottom: 0.5rem; }
    
    /* Clean Select2 Style */
    .select2-container--bootstrap-5 .select2-selection {
        border: 1px solid #d9dee3;
        min-height: 40px;
        border-radius: 0.375rem;
    }
    .select2-container--bootstrap-5.select2-container--focus .select2-selection {
        border-color: #696cff;
        box-shadow: 0 0 0 0.2rem rgba(105, 108, 255, 0.25);
    }
    .select2-dropdown {
        border: 1px solid #d9dee3 !important;
        border-radius: 0.375rem !important;
        box-shadow: 0 0.25rem 1rem rgba(161, 172, 184, 0.45) !important;
    }
</style>

<?= $this->endSection() ?>

