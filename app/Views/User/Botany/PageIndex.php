<style>
    .botany-landing {
        min-height: 100vh;
        overflow: hidden;
    }

    /* Hero Section */
    .hero-section {
        position: relative;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-align: center;
        background: #1b4332; /* Fallback */
    }

    .hero-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: linear-gradient(rgba(251, 126, 156, 0.6), rgba(36, 159, 253, 0.6)), url('https://images.unsplash.com/photo-1585320806297-9794b3e4eeae?q=80&w=2000&auto=format&fit=crop');
        background-size: cover;
        background-position: center;
        z-index: 0;
    }

    .hero-content {
        position: relative;
        z-index: 1;
        max-width: 1000px;
        padding: 60px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-radius: 50px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 25px 50px rgba(0,0,0,0.3);
    }

    .royal-logo {
        width: 180px;
        height: auto;
        margin-bottom: 35px;
        filter: drop-shadow(0 10px 20px rgba(0,0,0,0.4));
        transition: transform 0.3s ease;
    }

    .royal-logo:hover {
        transform: scale(1.05);
    }

    .hero-title {
        font-size: clamp(3rem, 10vw, 5.5rem);
        font-weight: 900;
        margin-bottom: 25px;
        line-height: 1.1;
        letter-spacing: -1px;
        background: linear-gradient(to bottom, #ffffff 60%, #ffc4d6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        filter: drop-shadow(0 0 30px rgba(251, 126, 156, 0.5));
    }

    .hero-subtitle {
        font-size: 1.4rem;
        margin-bottom: 40px;
        opacity: 0.9;
        font-weight: 400;
    }

    .scroll-down {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        animation: bounce 2s infinite;
        cursor: pointer;
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {transform: translateY(0) translateX(-50%);}
        40% {transform: translateY(-10px) translateX(-50%);}
        60% {transform: translateY(-5px) translateX(-50%);}
    }

    /* Menu Grid Section */
    .menu-section {
        background: #f8faf8;
        padding: 100px 0;
    }

    .section-header {
        text-align: center;
        margin-bottom: 70px;
    }

    .section-header h2 {
        font-weight: 800;
        color: #1b4332;
        font-size: 2.5rem;
    }

    .section-header .line {
        width: 80px;
        height: 4px;
        background: #fb7e9c;
        margin: 20px auto;
        border-radius: 2px;
    }

    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
    }

    .menu-card {
        background: white;
        border-radius: 30px;
        padding: 40px;
        text-align: center;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border: 1px solid rgba(0,0,0,0.03);
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .menu-card:hover {
        transform: translateY(-15px);
        box-shadow: 0 30px 60px rgba(251, 126, 156, 0.12);
        border-color: #fb7e9c;
    }

    .menu-icon-wrapper {
        width: 100px;
        height: 100px;
        background: #fff0f3;
        border-radius: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 25px;
        font-size: 2.5rem;
        color: #fb7e9c;
        transition: all 0.3s ease;
    }

    .menu-card:hover .menu-icon-wrapper {
        background: #fb7e9c;
        color: white;
        transform: rotate(10deg);
    }

    .menu-card:nth-child(2):hover .menu-icon-wrapper {
        background: #249ffd;
    }

    .menu-card h3 {
        font-weight: 700;
        color: #fb7e9c;
        margin-bottom: 15px;
    }

    .menu-card:nth-child(2) h3 {
        color: #249ffd;
    }

    .menu-card p {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    /* Info Section */
    .info-section {
        padding: 100px 0;
        background: white;
    }

    .info-img {
        width: 100%;
        border-radius: 40px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.1);
    }

    .tag-line {
        color: #fb7e9c;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 15px;
        display: block;
    }

    .info-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: #252525;
        margin-bottom: 25px;
    }

    .info-text {
        font-size: 1.1rem;
        line-height: 1.9;
        color: #555;
        margin-bottom: 30px;
    }

    @media (max-width: 768px) {
        .hero-title { font-size: 2.8rem; }
        .hero-subtitle { font-size: 1.1rem; }
        .info-title { font-size: 1.8rem; }
    }
</style>

<div class="botany-landing">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-bg"></div>
        <div class="hero-content animate__animated animate__fadeIn">
            <!-- <img src="<?= base_url('assets/img/botany/logo_botany.png') ?>" alt="อพ.สธ." class="royal-logo"> -->
            <h1 class="hero-title">งานสวนพฤกษศาสตร์<br>โรงเรียน</h1>
            <p class="hero-subtitle">โครงการอนุรักษ์พันธุกรรมพืชอันเนื่องมาจากพระราชดำริ<br>สมเด็จพระเทพรัตนราชสุดาฯ สยามบรมราชกุมารี (อพ.สธ.)</p>
            <div class="d-flex flex-wrap justify-content-center gap-3">
                <a href="#explore" class="btn btn-primary btn-lg rounded-pill px-5 py-3 fw-bold shadow-lg" style="background-color: #fb7e9c; border-color: #fb7e9c;">เริ่มต้นเรียนรู้ <i class="bi bi-arrow-right ms-2"></i></a>
            </div>
        </div>
        <div class="scroll-down" onclick="document.getElementById('explore').scrollIntoView({behavior: 'smooth'})">
            <i class="bi bi-chevron-down fs-1"></i>
        </div>
    </section>

    <!-- Menu Section -->
    <section class="menu-section" id="explore">
        <div class="container">
            <div class="section-header">
                <h2>ระบบสารสนเทศงานสวนพฤกษศาสตร์</h2>
                <div class="line"></div>
                <p class="text-muted">รวบรวมข้อมูลและการดำเนินงานสวนพฤกษศาสตร์โรงเรียนไว้อย่างเป็นระบบ</p>
            </div>

            <div class="menu-grid">
                <a href="<?= base_url('botany/plants') ?>" class="menu-card animate__animated animate__fadeInUp">
                    <div class="menu-icon-wrapper">
                        <i class="bi bi-search"></i>
                    </div>
                    <h3>คลังข้อมูลพรรณไม้</h3>
                    <p>รวบรวมรายชื่อพรรณไม้ทั้งหมดภายในโรงเรียน พร้อมข้อมูลทางพฤกษศาสตร์ที่ครบถ้วนและทันสมัย</p>
                </a>

                <a href="#" class="menu-card animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
                    <div class="menu-icon-wrapper">
                        <i class="bi bi-diagram-3"></i>
                    </div>
                    <h3>การดำเนินงาน 5 องค์ประกอบ</h3>
                    <p>สรุปขั้นตอนการดำเนินงานตามมาตรฐานโครงการสวนพฤกษศาสตร์โรงเรียน 5 องค์ประกอบหลัก</p>
                </a>

                <a href="<?= base_url('botany/news') ?>" class="menu-card animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                    <div class="menu-icon-wrapper">
                        <i class="bi bi-camera-reels"></i>
                    </div>
                    <h3>กิจกรรมและข่าวสาร</h3>
                    <p>ภาพกิจกรรมการเรียนรู้ของนักเรียน และข่าวประชาสัมพันธ์การอบรมหรืองานนิทรรศการต่างๆ</p>
                </a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="info-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0 animate__animated animate__fadeInLeft">
                    <img src="https://images.unsplash.com/photo-1518531933037-91b2f5f229cc?q=80&w=1200&auto=format&fit=crop" alt="Nature" class="info-img">
                </div>
                <div class="col-lg-6 ps-lg-5 animate__animated animate__fadeInRight">
                    <span class="tag-line">สวนกุหลาบวิทยาลัย (จิรประวัติ)</span>
                    <h2 class="info-title">สร้างจิตสำนึกในการอนุรักษ์<br>ผ่านการเรียนรู้ธรรมชาติ</h2>
                    <p class="info-text">
                        งานสวนพฤกษศาสตร์โรงเรียนไม่ได้เป็นเพียงการปลูกต้นไม้ แต่คือกระบวนการเรียนรู้ที่ให้นักเรียนได้ใกล้ชิดกับธรรมชาติ ฝึกการสังเกต วิเคราะห์ และรวบรวมข้อมูลอย่างเป็นระบบ เพื่อปลูกฝังจิตสำนึกในการรักษาสิ่งแวดล้อมและทรัพยากรท้องถิ่นอย่างยั่งยืน
                    </p>
                    <div class="d-flex gap-3">
                        <div class="p-3 bg-light rounded-4 flex-grow-1 text-center border-bottom border-4 border-success">
                            <h4 class="fw-bold text-success mb-1">300+</h4>
                            <small class="text-muted">พันธุ์ไม้ในโรงเรียน</small>
                        </div>
                        <div class="p-3 bg-light rounded-4 flex-grow-1 text-center border-bottom border-4 border-warning">
                            <h4 class="fw-bold text-warning mb-1">100%</h4>
                            <small class="text-muted">การมีส่วนร่วมของนักเรียน</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Admin Access Link (Bottom) -->
    <div class="container pb-5 text-center">
        <hr class="mb-4 opacity-10">
        <button type="button" class="btn btn-link text-muted text-decoration-none small" data-bs-toggle="modal" data-bs-target="#loginModal">
            <i class="bi bi-shield-lock me-1"></i> สำหรับผู้ดูแลระบบ (Admin Login)
        </button>
    </div>
</div>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 30px; overflow: hidden;">
            <div class="modal-header border-0 pb-0 pe-4 pt-4">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5 pt-0 text-center">
                <img src="<?= base_url('assets/img/logo/Logo-nav.png') ?>" alt="Logo" style="width: 80px;" class="mb-4">
                <h3 class="fw-bold text-dark mb-1">Admin Botany</h3>
                <p class="text-muted mb-4 small">ระบบจัดการงานสวนพฤกษศาสตร์โรงเรียน</p>

                <div id="loginAlert" class="alert alert-danger d-none" style="border-radius: 15px;"></div>

                <form id="loginForm">
                    <?= csrf_field() ?>
                    <div class="form-floating mb-3 text-start">
                        <input type="text" class="form-control rounded-4" name="username" id="botany_username" placeholder="Username" required>
                        <label for="botany_username">ชื่อผู้ใช้งาน</label>
                    </div>
                    <div class="form-floating mb-4 text-start">
                        <input type="password" class="form-control rounded-4" name="password" id="botany_password" placeholder="Password" required>
                        <label for="botany_password">รหัสผ่าน</label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill py-3 fw-bold shadow-sm" id="loginSubmitBtn" style="background-color: #fb7e9c; border-color: #fb7e9c;">
                        เข้าสู่ระบบ <i class="bi bi-door-open ms-2"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = document.getElementById('loginSubmitBtn');
        const alert = document.getElementById('loginAlert');
        const formData = new FormData(this);

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>กำลังตรวจสอบ...';
        alert.classList.add('d-none');

        fetch('<?= base_url('botany/login/auth') ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ!',
                    text: 'กำลังพาท่านไปหน้าจัดการ...',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = '<?= base_url('admin/botany') ?>';
                });
            } else {
                alert.textContent = data.message;
                alert.classList.remove('d-none');
                btn.disabled = false;
                btn.innerHTML = 'เข้าสู่ระบบ <i class="bi bi-door-open ms-2"></i>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            btn.disabled = false;
            btn.innerHTML = 'เข้าสู่ระบบ <i class="bi bi-door-open ms-2"></i>';
        });
    });
</script>
