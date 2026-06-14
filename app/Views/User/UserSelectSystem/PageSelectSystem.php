<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> | SKJ School</title>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/admin/assets/vendor/fonts/boxicons.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/assets/vendor/css/core.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/assets/vendor/css/theme-default.css') ?>">
    <style>
        body {
            font-family: 'Sarabun', sans-serif;
            background-color: #f5f7ff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .select-container {
            width: 100%;
            max-width: 800px;
            padding: 20px;
        }
        .welcome-text {
            color: #333 !important;
            text-align: center;
            margin-bottom: 50px;
            text-shadow: none;
        }
        .welcome-text h1 { 
            font-size: 2.5rem; 
            font-weight: 800; 
            margin-bottom: 12px;
            letter-spacing: -0.5px;
            color: #444;
        }
        .welcome-text p { 
            font-size: 1.1rem;
            opacity: 0.7 !important;
            font-weight: 500;
            color: #666;
        }
        
        .system-cards { display: flex; gap: 30px; justify-content: center; flex-wrap: wrap; }
        
        .system-card {
            background: white;
            border-radius: 20px;
            padding: 40px 30px;
            width: 280px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
        }
        .system-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 30px 80px rgba(0,0,0,0.3);
        }
        .system-card .icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2.5rem;
            color: white;
        }
        .system-card.admin .icon { background: linear-gradient(135deg, #696cff 0%, #5a5fc9 100%); }
        .system-card.manager .icon { background: linear-gradient(135deg, #ff9f43 0%, #e88e2e 100%); }
        .system-card.support .icon { background: linear-gradient(135deg, #03c3ec 0%, #00b0d6 100%); }
        
        .system-card h3 { font-size: 1.3rem; font-weight: 700; margin-bottom: 10px; color: #333 !important; }
        .system-card p { color: #697a8d !important; font-size: 0.9rem; margin-bottom: 20px; }
        
        .system-card .btn-enter {
            display: inline-block;
            padding: 10px 30px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.2s;
        }
        .system-card.admin .btn-enter { background: #696cff; color: white; }
        .system-card.admin .btn-enter:hover { background: #5a5fc9; }
        .system-card.manager .btn-enter { background: #ff9f43; color: white; }
        .system-card.manager .btn-enter:hover { background: #e88e2e; }
        .system-card.support .btn-enter { background: #03c3ec; color: white; }
        .system-card.support .btn-enter:hover { background: #00b0d6; }

        .logout-link {
            text-align: center;
            margin-top: 30px;
        }
        .logout-link a {
            color: #697a8d;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 500;
        }
        .logout-link a:hover { color: #696cff; }
    </style>
</head>
<body>
    <div class="select-container">
        <div class="welcome-text">
            <h1>ยินดีต้อนรับ, <?= $userName ?></h1>
            <p>กรุณาเลือกระบบที่ต้องการเข้าใช้งาน</p>
        </div>

        <div class="system-cards">
            <!-- Admin System -->
            <a href="<?= base_url('Admin/Dashboard') ?>" class="system-card admin">
                <div class="icon"><i class="bx bx-cog"></i></div>
                <h3>ระบบผู้ดูแล</h3>
                <p>จัดการข้อมูลโรงเรียน ข่าวสาร บุคลากร และระบบต่างๆ</p>
                <span class="btn-enter">เข้าสู่ระบบ <i class="bx bx-right-arrow-alt"></i></span>
            </a>

            <!-- Manager System -->
            <a href="<?= base_url('Manager/Dashboard') ?>" class="system-card manager">
                <div class="icon"><i class="bx bx-bar-chart-alt-2"></i></div>
                <h3>ระบบผู้บริหาร</h3>
                <p>ดูภาพรวมบุคลากร วิชาการ และงานบริหารทั่วไป</p>
                <span class="btn-enter">เข้าสู่ระบบ <i class="bx bx-right-arrow-alt"></i></span>
            </a>

            <!-- Support System -->
            <a href="<?= base_url('Support/Dashboard') ?>" class="system-card support">
                <div class="icon"><i class="bx bx-support"></i></div>
                <h3>ระบบฝ่ายสนับสนุน</h3>
                <p>จัดการข้อมูลงานฝ่ายสนับสนุนและภาระหน้าที่ต่างๆ</p>
                <span class="btn-enter">เข้าสู่ระบบ <i class="bx bx-right-arrow-alt"></i></span>
            </a>
        </div>

        <div class="logout-link">
            <a href="<?= base_url('logout') ?>"><i class="bx bx-log-out"></i> ออกจากระบบ</a>
        </div>
    </div>
</body>
</html>
