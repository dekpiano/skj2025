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
            background: #fff;
            color: #444;
            border: 1px solid #ddd;
            padding: 12px 20px;
            border-radius: 30px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
            text-decoration: none;
            width: 100%;
        }
        .btn-google:hover {
            background: #f8f9fa;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            border-color: #4f46e5;
            color: #4f46e5;
        }
        .btn-google img {
            width: 20px;
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
    
    <div class="py-3 border-top border-bottom mb-4">
        <p class="text-secondary small mb-2 fw-semibold"><i class="bi bi-shield-check text-primary"></i> ยินดีต้อนรับสู่ระบบ EIS</p>
        <p class="text-muted extra-small" style="font-size: 0.75rem; line-height: 1.4;">(สำหรับผู้บริหารสถานศึกษา และบุคลากรสายสนับสนุน)</p>
    </div>

    <!-- ปุ่ม Google แบบ Redirect Flow (Legacy + Safe for your current Client ID) -->
    <a href="<?= base_url('SkjMain/googleLogin') ?>" class="btn-google">
        <img src="https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png" alt="Google">
        เข้าสู่ระบบด้วย Google
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
