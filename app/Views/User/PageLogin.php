<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ - สารสนเทศผู้บริหาร EIS</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=K2D:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body {
            font-family: 'K2D', sans-serif;
            background: linear-gradient(135deg, #fce4ec 0%, #e3f2fd 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            padding: 40px;
            text-align: center;
        }
        .logo-img {
            width: 100px;
            margin-bottom: 20px;
        }
        .login-title {
            background: linear-gradient(135deg, #003366 0%, #4f46e5 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .login-subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 0.9rem;
        }
        .btn-google {
            background: linear-gradient(135deg, #4285F4 0%, #357ae8 100%);
            color: #ffffff !important;
            border: none;
            padding: 14px 24px;
            border-radius: 30px;
            font-weight: 700;
            font-size: 1.05rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-decoration: none;
            width: 100%;
            box-shadow: 0 8px 25px rgba(66, 133, 244, 0.35);
            position: relative;
            overflow: hidden;
        }
        .btn-google::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.25) 50%, rgba(255,255,255,0) 100%);
            transform: translateX(-100%);
            transition: all 0.6s ease;
        }
        .btn-google:hover::before {
            transform: translateX(100%);
        }
        .btn-google:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 12px 30px rgba(66, 133, 244, 0.5);
            color: #ffffff !important;
        }
        .btn-google:active {
            transform: translateY(-1px);
        }
        .btn-google img {
            width: 24px;
            height: 24px;
            background: white;
            padding: 3px;
            border-radius: 50%;
        }
        .back-home {
            margin-top: 20px;
            display: block;
            color: #999;
            text-decoration: none;
            font-size: 0.85rem;
        }
        .back-home:hover {
            color: #4f46e5;
        }
    </style>
</head>
<body>

<div class="login-card">
    <img src="<?= base_url('assets/img/logo/Logo-nav.png') ?>" alt="Logo" class="logo-img">
    <h3 class="login-title">ระบบสารสนเทศ EIS</h3>
    <p class="login-subtitle">Suankularb Wittayalai (Jiraprawat) Nakhon Sawan</p>
    
    <div class="mb-4">
        <!-- Target Audience Banner -->
        <div class="card border-0 mb-3 p-3 text-start" style="background: rgba(79, 70, 229, 0.06); border-radius: 12px; border: 1px solid rgba(79, 70, 229, 0.15) !important;">
            <div class="d-flex align-items-center mb-2">
                <div class="text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 28px; height: 28px; background: linear-gradient(135deg, #003366 0%, #4f46e5 100%);">
                    <i class="bi bi-shield-lock" style="font-size: 0.9rem;"></i>
                </div>
                <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.9rem; letter-spacing: 0.3px;">เข้าใช้งานเฉพาะกลุ่มบุคคล</h6>
            </div>
            <p class="text-secondary mb-1 small" style="font-size: 0.8rem; line-height: 1.4;">
                <i class="bi bi-check-circle-fill text-success me-1"></i> <strong>ผู้บริหารสถานศึกษา</strong> (ผู้บริหาร / รักษาการ)
            </p>
            <p class="text-secondary mb-0 small" style="font-size: 0.8rem; line-height: 1.4;">
                <i class="bi bi-check-circle-fill text-success me-1"></i> <strong>บุคลากรฝ่ายสนับสนุน</strong> (ธุรการ, พนักงาน, เจ้าหน้าที่)
            </p>
        </div>

        <!-- Teacher Warning Banner -->
        <div class="alert alert-warning border-0 p-3 text-start mb-0" style="background: rgba(255, 193, 7, 0.08); border-radius: 12px; border: 1px solid rgba(255, 193, 7, 0.25) !important;">
            <div class="d-flex align-items-center mb-1">
                <i class="bi bi-exclamation-triangle-fill text-warning me-2" style="font-size: 1.1rem;"></i>
                <h6 class="alert-heading mb-0 fw-bold text-dark" style="font-size: 0.85rem;">คำชี้แจงสำหรับครูผู้สอน!</h6>
            </div>
            <p class="mb-0 text-muted small" style="font-size: 0.78rem; line-height: 1.4;">
                ระบบนี้<strong>ไม่ใช่สำหรับครูผู้สอน</strong> หากท่านเป็นครูผู้สอน กรุณาลงชื่อเข้าใช้งานที่ 
                <a href="https://teacher.skj.ac.th/" target="_blank" class="fw-bold text-primary text-decoration-underline">ระบบครูผู้สอน (Teacher)</a>
            </p>
        </div>
    </div>

    <!-- ปุ่ม Google แบบ Redirect Flow (Legacy + Safe for your current Client ID) -->
    <a href="<?= base_url('SkjMain/googleLogin') ?>" class="btn-google">
        <img src="https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png" alt="Google">
        เข้าสู่ระบบด้วย อีเมล @skj.ac.th
    </a>

    <?php if (session()->getFlashdata('msg')) : ?>
        <div class="alert alert-danger mt-4 py-2 small" role="alert">
            <?= session()->getFlashdata('msg') ?>
        </div>
    <?php endif; ?>

    <a href="<?= base_url('/') ?>" class="back-home">
        <i class="bi bi-arrow-left"></i> กลับสู่หน้าหลัก
    </a>
</div>

</body>
</html>
