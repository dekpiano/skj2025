<?= $this->extend('Admin/layout/AdminLayout') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">แดชบอร์ด /</span> รายชื่อนักเรียนทั้งหมด (สถานะปกติ)
    </h4>

    <!-- Filter Card -->
    <div class="card mb-4">
        <div class="card-header border-bottom py-3 d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0 text-primary fw-bold"><i class="bx bx-filter-alt me-2"></i>ตัวกรองข้อมูล</h5>
        </div>
        <div class="card-body pt-4">
            <form id="filterForm" method="GET" action="<?= base_url('Admin/Student') ?>">
                <div class="row g-3 align-items-end">
                    <div class="col-md-6 col-lg-4">
                        <label for="classFilter" class="form-label fw-bold">เลือกชั้นเรียน</label>
                        <select class="form-select select2" id="classFilter" name="class">
                            <option value="">-- แสดงทุกชั้นเรียน --</option>
                            <?php foreach ($classes as $class): ?>
                                <option value="<?= $class ?>" <?= $selectedClass == $class ? 'selected' : '' ?>>
                                    ชั้น <?= $class ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bx bx-search-alt-2 me-1"></i> ค้นหา
                        </button>
                    </div>
                    <?php if (!empty($selectedClass)): ?>
                        <div class="col-md-6 col-lg-2">
                            <a href="<?= base_url('Admin/Student') ?>" class="btn btn-outline-secondary w-100">
                                ล้างค่าตัวกรอง
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card shadow-sm border-0">
        <div class="card-header border-bottom py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="card-title mb-0 text-primary fw-bold">
                <i class="bx bx-user me-2"></i>นักเรียนที่มีสถานะปกติทั้งหมด
                <span class="badge bg-label-primary ms-1"><?= count($students) ?> คน</span>
            </h5>
            <div class="d-flex gap-2 flex-wrap">
                <button type="button" class="btn btn-success" id="btnExportCSV">
                    <i class="bx bx-export me-1"></i> ดาวน์โหลด CSV (Excel ทั่วไป)
                </button>
                <button type="button" class="btn btn-info text-white" id="btnExportGoogleCSV">
                    <i class="bx bxl-google me-1"></i> ดาวน์โหลด CSV (Google Workspace)
                </button>
                <button type="button" class="btn btn-primary" id="btnExportTXT">
                    <i class="bx bx-file me-1"></i> ดาวน์โหลดสำหรับทำ Wifi โรงเรียน
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle mb-0" id="studentTable">
                    <thead class="table-light">
                        <tr>
                            <th>ลำดับ</th>
                            <th>รหัสประจำตัว</th>
                            <th>ระดับชั้น</th>
                            <th>เลขที่</th>
                            <th>คำนำหน้า</th>
                            <th>ชื่อ</th>
                            <th>นามสกุล</th>
                            <th>แผนการเรียน</th>
                            <th>สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($students)): ?>
                            <?php $i = 1;
                            foreach ($students as $student): ?>
                                <tr data-code="<?= htmlspecialchars($student['StudentCode']) ?>"
                                    data-birth="<?= htmlspecialchars($student['StudentDateBirth']) ?>"
                                    data-prefix="<?= htmlspecialchars($student['StudentPrefix']) ?>"
                                    data-firstname="<?= htmlspecialchars($student['StudentFirstName']) ?>"
                                    data-lastname="<?= htmlspecialchars($student['StudentLastName']) ?>"
                                    data-class="<?= htmlspecialchars($student['StudentClass']) ?>"
                                    data-number="<?= htmlspecialchars($student['StudentNumber']) ?>">
                                    <td><?= $i++ ?></td>
                                    <td><span class="fw-bold text-dark"><?= $student['StudentCode'] ?></span></td>
                                    <td><span class="badge bg-label-info"><?= $student['StudentClass'] ?></span></td>
                                    <td><?= $student['StudentNumber'] ?></td>
                                    <td><?= $student['StudentPrefix'] ?></td>
                                    <td><?= $student['StudentFirstName'] ?></td>
                                    <td><?= $student['StudentLastName'] ?></td>
                                    <td><?= !empty($student['StudentStudyLine']) ? $student['StudentStudyLine'] : '-' ?></td>
                                    <td><span class="badge bg-label-success">ปกติ</span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">ไม่พบข้อมูลนักเรียนที่มีสถานะปกติ</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->section('scripts') ?>
<script>
window.yearTwoDigits = "<?= $yearTwoDigits ?>";

$(document).ready(function () {
    // Initialize Select2 if available
    if ($.fn.select2) {
        $('.select2').select2({
            theme: 'bootstrap-5',
            width: '100%'
        });
    }

    // Initialize DataTable
    var table = null;
    if ($.fn.DataTable) {
        table = $('#studentTable').DataTable({
            order: [[2, 'asc'], [3, 'asc']], // Order by Class then by Number
            pageLength: 50,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "ทั้งหมด"]],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "ค้นหารหัส/ชื่อ-สกุล...",
                lengthMenu: "แสดง _MENU_ รายการ",
                zeroRecords: "ไม่พบข้อมูลที่ค้นหา",
                info: "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                infoEmpty: "ไม่มีข้อมูลที่แสดง",
                paginate: {
                    next: '<i class="bx bx-chevron-right"></i>',
                    previous: '<i class="bx bx-chevron-left"></i>'
                }
            }
        });
    }

    // Handle CSV Export
    $('#btnExportCSV').on('click', function () {
        var csvData = [];
        // Header
        var headers = ["ลำดับ", "รหัสประจำตัว", "ระดับชั้น", "เลขที่", "คำนำหน้า", "ชื่อ", "นามสกุล", "แผนการเรียน", "สถานะ"];
        csvData.push(headers.join(","));

        // If DataTable exists, get all rows (both visible and paginated/filtered)
        var rowsData = [];
        if (table) {
            // Get all data currently in the table (respects active filters)
            var filteredRows = table.rows({ search: 'applied' }).nodes();
            $(filteredRows).each(function (idx, tr) {
                var rowClean = [];
                $(tr).find('td').each(function (c, td) {
                    var cellText = $(td).text().trim();
                    cellText = cellText.replace(/"/g, '""');
                    rowClean.push('"' + cellText + '"');
                });
                rowsData.push(rowClean.join(","));
            });
        } else {
            // Fallback to table body DOM if DataTable is not loaded
            $('#studentTable tbody tr').each(function (idx, tr) {
                var rowClean = [];
                $(tr).find('td').each(function (c, td) {
                    var cellText = $(td).text().trim();
                    cellText = cellText.replace(/"/g, '""');
                    rowClean.push('"' + cellText + '"');
                });
                if (rowClean.length > 1) {
                    rowsData.push(rowClean.join(","));
                }
            });
        }

        if (rowsData.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'คำเตือน',
                text: 'ไม่มีข้อมูลสำหรับดาวน์โหลด'
            });
            return;
        }

        csvData = csvData.concat(rowsData);
        var csvContent = csvData.join("\n");

        // Add UTF-8 BOM so Excel opens it correctly with Thai characters
        var bom = new Uint8Array([0xEF, 0xBB, 0xBF]);
        var blob = new Blob([bom, csvContent], { type: 'text/csv;charset=utf-8;' });
        
        var link = document.createElement("a");
        if (link.download !== undefined) {
            var url = URL.createObjectURL(blob);
            var filename = "รายชื่อนักเรียน_สถานะปกติ";
            var selectedClass = $('#classFilter').val();
            if (selectedClass) {
                filename += "_" + selectedClass.replace(/\//g, "-");
            }
            filename += "_" + new Date().toISOString().slice(0, 10) + ".csv";
            
            link.setAttribute("href", url);
            link.setAttribute("download", filename);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    });

    // Handle Google Workspace CSV Export
    $('#btnExportGoogleCSV').on('click', function () {
        var csvData = [];
        // Header
        var headers = ["First name", "Last name", "Email address", "Password", "Org Unit Path"];
        csvData.push(headers.join(","));

        var rows = [];
        if (table) {
            var filteredRows = table.rows({ search: 'applied' }).nodes();
            $(filteredRows).each(function (idx, tr) {
                rows.push(tr);
            });
        } else {
            $('#studentTable tbody tr').each(function (idx, tr) {
                rows.push(tr);
            });
        }

        var year2Digits = window.yearTwoDigits || '66';

        $(rows).each(function (idx, tr) {
            var code = $(tr).data('code') || '';
            var birth = $(tr).data('birth') || '';
            var prefix = $(tr).data('prefix') || '';
            var firstname = $(tr).data('firstname') || '';
            var lastname = $(tr).data('lastname') || '';
            var classStr = $(tr).data('class') || '';
            var number = ($(tr).data('number') || '').toString().trim();
            if (number.length === 1) {
                number = '0' + number;
            }

            if (code) {
                // Extract class level and room. e.g., "ม.5/2" -> level: "5", room: "2" -> "52"
                var match = classStr.match(/ม\.(\d+)\/(\d+)/);
                var level = match ? match[1] : '';
                var room = match ? match[2] : '';
                var classCode = level + room;

                // First name format: 6652_20_นางสาวศิรินทิพย์
                var firstNameFormatted = year2Digits + classCode + '_' + number + '_' + prefix + firstname;
                
                // Construct clean CSV row
                var rowClean = [
                    '"' + firstNameFormatted.replace(/"/g, '""') + '"',
                    '"' + lastname.replace(/"/g, '""') + '"',
                    '"skj' + code + '@skj.ac.th"',
                    '"skj@' + code + '"',
                    '"/นักเรียน"'
                ];
                
                csvData.push(rowClean.join(","));
            }
        });

        if (csvData.length <= 1) {
            Swal.fire({
                icon: 'warning',
                title: 'คำเตือน',
                text: 'ไม่มีข้อมูลสำหรับดาวน์โหลด'
            });
            return;
        }

        var csvContent = csvData.join("\n");

        // Add UTF-8 BOM so Excel opens it correctly with Thai characters
        var bom = new Uint8Array([0xEF, 0xBB, 0xBF]);
        var blob = new Blob([bom, csvContent], { type: 'text/csv;charset=utf-8;' });
        
        var link = document.createElement("a");
        if (link.download !== undefined) {
            var url = URL.createObjectURL(blob);
            var filename = "google_workspace_students";
            var selectedClass = $('#classFilter').val();
            if (selectedClass) {
                filename += "_" + selectedClass.replace(/\//g, "-");
            }
            filename += "_" + new Date().toISOString().slice(0, 10) + ".csv";
            
            link.setAttribute("href", url);
            link.setAttribute("download", filename);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    });

    // Handle TXT Export
    $('#btnExportTXT').on('click', function () {
        var lines = [];
        var rows = [];

        if (table) {
            // Get all table rows matching current filter/search
            var filteredRows = table.rows({ search: 'applied' }).nodes();
            $(filteredRows).each(function (idx, tr) {
                rows.push(tr);
            });
        } else {
            $('#studentTable tbody tr').each(function (idx, tr) {
                rows.push(tr);
            });
        }

        $(rows).each(function (idx, tr) {
            var code = $(tr).data('code') || '';
            var birth = $(tr).data('birth') || '';
            var prefix = $(tr).data('prefix') || '';
            var firstname = $(tr).data('firstname') || '';
            var lastname = $(tr).data('lastname') || '';

            if (code) {
                // Remove slashes from birthdate (e.g., "13/11/2549" -> "13112549")
                var pass = birth.replace(/\//g, '');
                var user = 'skj' + code;
                var fullName = prefix + firstname + ' ' + lastname;

                lines.push(user + ',' + pass + ',' + fullName);
            }
        });

        if (lines.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'คำเตือน',
                text: 'ไม่มีข้อมูลสำหรับดาวน์โหลด'
            });
            return;
        }

        var txtContent = lines.join("\n");
        // UTF-8 BOM for plain text Thai language file compatibility
        var bom = new Uint8Array([0xEF, 0xBB, 0xBF]);
        var blob = new Blob([bom, txtContent], { type: 'text/plain;charset=utf-8;' });
        
        var link = document.createElement("a");
        if (link.download !== undefined) {
            var url = URL.createObjectURL(blob);
            var filename = "credentials_students";
            var selectedClass = $('#classFilter').val();
            if (selectedClass) {
                filename += "_" + selectedClass.replace(/\//g, "-");
            }
            filename += "_" + new Date().toISOString().slice(0, 10) + ".txt";
            
            link.setAttribute("href", url);
            link.setAttribute("download", filename);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    });
});
</script>
<?= $this->endSection() ?>

<style>
    .card {
        border-radius: 0.75rem;
    }

    .table thead th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }

    .form-label {
        color: #566a7f;
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
    }

    /* Clean styles for search input */
    .dataTables_filter input {
        border: 1px solid #d9dee3;
        border-radius: 0.375rem;
        padding: 0.422rem 0.875rem;
        font-size: 0.9375rem;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .dataTables_filter input:focus {
        border-color: #696cff;
        outline: 0;
        box-shadow: 0 0 0.25rem 0.05rem rgba(105, 108, 255, 0.1);
    }

    .dataTables_length select {
        border: 1px solid #d9dee3;
        border-radius: 0.375rem;
        padding: 0.375rem 1.75rem 0.375rem 0.75rem;
    }
</style>
<?= $this->endSection() ?>