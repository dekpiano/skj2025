<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <!-- Favicon -->
    <link href="<?= base_url() ?>/assets/img/logo/Logo-nav.png" rel="icon">
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Libraries Stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    
    <style>
        body {
            background: #f0f7f0;
            background-image: 
                radial-gradient(at 0% 0%, rgba(40, 167, 69, 0.1) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(255, 193, 7, 0.1) 0px, transparent 50%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'K2D', sans-serif;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 30px;
            padding: 50px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            border: 1px solid rgba(255, 255, 255, 0.5);
            text-align: center;
        }

        .login-logo {
            width: 100px;
            margin-bottom: 30px;
            filter: drop-shadow(0 5px 15px rgba(45, 106, 79, 0.2));
        }

        .login-title {
            font-weight: 800;
            color: #1b4332;
            margin-bottom: 10px;
            font-size: 1.8rem;
        }

        .login-subtitle {
            color: #666;
            margin-bottom: 40px;
            font-size: 0.95rem;
        }

        .form-floating > .form-control {
            border-radius: 15px;
            border: 1px solid rgba(0,0,0,0.05);
            background: rgba(255,255,255,0.9);
        }

        .form-floating > .form-control:focus {
            border-color: #52b788;
            box-shadow: 0 0 0 0.25rem rgba(82, 183, 136, 0.1);
        }

        .btn-login {
            background: linear-gradient(45deg, #2d6a4f, #52b788);
            border: none;
            border-radius: 15px;
            padding: 15px;
            font-weight: 700;
            color: white;
            width: 100%;
            margin-top: 20px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(45, 106, 79, 0.2);
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(45, 106, 79, 0.3);
            background: linear-gradient(45deg, #1b4332, #2d6a4f);
            color: white;
        }

        .back-to-site {
            margin-top: 30px;
            display: block;
            color: #52b788;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .alert {
            border-radius: 15px;
            font-size: 0.9rem;
            margin-bottom: 25px;
        }

        @media (max-width: 576px) {
            body { height: auto; min-height: 100vh; padding: 40px 0; }
            .login-card {
                padding: 35px 20px;
                margin: 0 20px;
                border-radius: 25px;
            }
            .login-title { font-size: 1.6rem; }
            .login-logo { width: 80px; margin-bottom: 20px; }
        }
    </style>
</head>
<body>

    <div class="login-card animate__animated animate__fadeIn">
        <img src="<?= base_url('assets/img/logo/Logo-nav.png') ?>" alt="Logo" class="login-logo">
        <h1 class="login-title">Admin Botany</h1>
        <p class="login-subtitle">ระบบจัดการงานสวนพฤกษศาสตร์โรงเรียน</p>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle-fill me-2"></i><?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('Botany/Login/Auth') ?>" method="post">
            <?= csrf_field() ?>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
                <label for="username">ชื่อผู้ใช้งาน</label>
            </div>
            <div class="form-floating mb-4">
                <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                <label for="password">รหัสผ่าน</label>
            </div>
            
            <button type="submit" class="btn btn-login">เข้าสู่ระบบ</button>
        </form>

        <a href="<?= base_url('Botany') ?>" class="back-to-site">
            <i class="bi bi-arrow-left me-1"></i> กลับสู่หน้าหลักสวนพฤกษศาสตร์
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
