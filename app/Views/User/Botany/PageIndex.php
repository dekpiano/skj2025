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
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: white;
        text-align: center;
        background: #2e004d; /* Fallback */
    }

    .hero-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: linear-gradient(rgba(85, 26, 139, 0.7), rgba(46, 0, 77, 0.8)), url('<?= base_url('assets/img/botany/hero_bg_eggplant.png') ?>');
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
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border-radius: 50px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 25px 50px rgba(0,0,0,0.3);
    }

    .logo-spotlight {
        position: relative;
        display: inline-block;
        padding: 30px;
        margin-bottom: 15px;
        z-index: 20;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.35) 0%, rgba(255, 255, 255, 0) 70%);
        border-radius: 50%;
    }

    .royal-logo {
        width: 180px;
        height: auto;
        filter: drop-shadow(0 0 30px rgba(255, 255, 255, 0.8)) 
                drop-shadow(0 5px 20px rgba(0, 0, 0, 0.4))
                brightness(1.1) saturate(1.2);
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .royal-logo:hover {
        transform: scale(1.05);
    }

    .hero-title {
        font-size: clamp(2.5rem, 6vw, 4.5rem);
        font-weight: 900;
        margin-bottom: 25px;
        line-height: 1.1;
        letter-spacing: -0.5px;
        color: #ffffff;
        text-shadow: 0 10px 30px rgba(0,0,0,0.5), 0 0 20px rgba(255,255,255,0.2);
        filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.1));
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
        box-shadow: 0 30px 60px rgba(85, 26, 139, 0.12);
        border-color: #8b2e8b;
    }

    .menu-icon-wrapper {
        width: 100px;
        height: 100px;
        background: #f8f4ff;
        border-radius: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 25px;
        font-size: 2.5rem;
        color: #8b2e8b;
        transition: all 0.3s ease;
    }

    .menu-card:hover .menu-icon-wrapper {
        background: #8b2e8b;
        color: white;
        transform: rotate(10deg);
    }

    .menu-card:nth-child(2):hover .menu-icon-wrapper {
        background: #551a8b;
    }

    .menu-card h3 {
        font-weight: 700;
        color: #8b2e8b;
        margin-bottom: 15px;
    }

    .menu-card:nth-child(2) h3 {
        color: #551a8b;
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
        color: #8b2e8b;
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

        <!-- Logo above card -->
        <div class="logo-spotlight">
            <img src="<?= base_url('assets/img/botany/rspg_logo.png') ?>" alt="อพ.สธ." class="royal-logo">
        </div>

        <div class="hero-content animate__animated animate__fadeIn" style="animation-duration: 2s;">
            <!-- Main Title -->
            <h1 class="hero-title mb-4" style="font-size: clamp(2.5rem, 6vw, 4.2rem);">
                งานสวนพฤกษศาสตร์โรงเรียน<br>
                <span style="font-size: 0.67em; font-weight: 700;">สวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</span>
            </h1>
            
            <!-- Subtitle -->
            <p class="hero-subtitle mb-5" style="max-width: 850px; margin-left: auto; margin-right: auto; line-height: 1.6; opacity: 0.85;">
                โครงการอนุรักษ์พันธุกรรมพืชอันเนื่องมาจากพระราชดำริ<br>
                สมเด็จพระกนิษฐาธิราชเจ้า กรมสมเด็จพระเทพรัตนราชสุดาฯ สยามบรมราชกุมารี (อพ.สธ.)
            </p>

            <!-- CTA Button -->
            <div class="mt-4">
                <a href="#explore" class="btn btn-hero btn-lg rounded-pill px-5 py-3 fw-bold shadow-lg">
                    เริ่มต้นเรียนรู้พรรณไม้ <i class="bi bi-chevron-right ms-2"></i>
                </a>
            </div>
        </div>
        <div class="scroll-down" onclick="document.getElementById('explore').scrollIntoView({behavior: 'smooth'})">
            <i class="bi bi-chevron-down fs-1"></i>
        </div>
    </section>

    <!-- Royal Tribute Section -->
    <link href="https://fonts.googleapis.com/css2?family=Maitree:wght@300;400;700&display=swap" rel="stylesheet">
    <section class="royal-tribute-section py-5 animate__animated animate__fadeIn" style="background-image: linear-gradient(rgba(85, 26, 139, 0.9), rgba(85, 26, 139, 0.9)), url('<?= base_url('assets/img/botany/royal_tribute_bg.png') ?>'); background-size: cover; background-position: center; position: relative; min-height: 500px; display: flex; align-items: center;">
        <div class="container position-relative" style="z-index: 2;">
            <div class="row align-items-center">
                <!-- Text Column (Left) -->
                <div class="col-lg-7 text-start pe-lg-5 mb-5 mb-lg-0">
                    <div class="quote-container animate__animated animate__fadeInLeft" style="color: #fff;">
                        <i class="bi bi-quote fs-1 opacity-50 mb-2 d-block" style="color: #ffd700;"></i>
                        <h3 class="mb-4" style="line-height: 1.8; font-family: 'Maitree', serif; font-weight: 400; font-size: 1.6rem; text-shadow: 0 2px 4px rgba(14, 14, 14, 0.27);color: #fff;">
                            “การสอนและอบรมให้เด็กมีจิตสำนึกในการอนุรักษ์พืชพรรณนั้น ควรใช้วิธีการปลูกฝังให้เด็กเห็นความงดงาม ความน่าสนใจ และเกิดความปีติที่จะทำการศึกษาและอนุรักษ์พืชพรรณต่อไป การใช้วิธีการสอนการอบรมที่ให้เกิดความรู้สึกกลัวว่าหากไม่อนุรักษ์แล้วจะเกิดผลเสียเกิดอันตรายแก่ตนเอง จะทำให้เด็กเกิดความเครียด ซึ่งจะเป็นผลเสียแก่ประเทศในระยะยาว”
                        </h3>
                        <div class="line mb-4" style="width: 80px; height: 2px; background: #ffd700; opacity: 0.6;"></div>
                        <div class="tribute-author" style="font-family: 'Maitree', serif;">
                            <h4 class="fw-bold mb-1" style="color: #ffd700; letter-spacing: 1px;">สมเด็จพระกนิษฐาธิราชเจ้า</h4>
                            <p class="mb-0 opacity-85" style="font-size: 1.1rem;">กรมสมเด็จพระเทพรัตนราชสุดาฯ สยามบรมราชกุมารี</p>
                        </div>
                    </div>
                </div>
                <!-- Image Column (Right) -->
                <div class="col-lg-5 text-center">
                    <div class="portrait-wrapper animate__animated animate__zoomIn">
                        <div class="portrait-frame" style="display: inline-block; padding: 12px; background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(15px); border-radius: 35px; border: 1px solid rgba(255, 255, 255, 0.3); box-shadow: 0 40px 80px rgba(0,0,0,0.5);">
                            <img src="<?= base_url('assets/img/botany/royal_portrait.png') ?>" alt="พระฉายาลักษณ์" 
                                 class="img-fluid" 
                                 style="max-width: 100%; height: auto; border-radius: 25px; filter: contrast(1.05);">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest News Section -->
    <?php if(!empty($latest_news)): ?>
    <section class="latest-news-section py-5" style="background: #f8f4ff;">
        <div class="container">
            <div class="section-header text-center mb-5">
                <span class="tag-line" style="color: #551a8b;">อัปเดตล่าสุด</span>
                <h2 class="fw-bold" style="color: #551a8b;">กิจกรรมและข่าวสารล่าสุด</h2>
                <div class="line mx-auto" style="width: 80px; height: 4px; background: #ffd700; border-radius: 2px; margin-top: 15px;"></div>
            </div>

            <div class="row g-4">
                <?php foreach($latest_news as $news): ?>
                <div class="col-lg-4 col-md-6 animate__animated animate__fadeInUp">
                    <a href="<?= base_url('botany/newsdetail/'.$news->news_id) ?>" class="text-decoration-none">
                        <div class="news-home-card h-100 shadow-sm border-0 rounded-4 overflow-hidden bg-white transition-hover">
                            <div class="news-img-container" style="height: 200px; overflow: hidden;">
                                <?php if($news->news_img): ?>
                                    <img src="<?= base_url('uploads/botany/news/'.$news->news_img) ?>" class="w-100 h-100 object-fit-cover" alt="<?= $news->news_title ?>">
                                <?php else: ?>
                                    <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=600&auto=format&fit=crop" class="w-100 h-100 object-fit-cover" alt="Default News">
                                <?php endif; ?>
                            </div>
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge bg-label-primary me-2" style="background: #f0e6ff; color: #551a8b; font-size: 0.75rem;">
                                        <?= date('d M Y', strtotime($news->news_date)) ?>
                                    </span>
                                </div>
                                <h5 class="fw-bold text-dark line-clamp-2 mb-2" style="line-height: 1.4;"><?= $news->news_title ?></h5>
                                <p class="text-muted small line-clamp-3 mb-0">
                                    <?= strip_tags($news->news_content) ?>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="text-center mt-5">
                <a href="<?= base_url('botany/news') ?>" class="btn btn-outline-primary rounded-pill px-4 fw-bold" style="color: #551a8b; border-color: #551a8b;">ดูข่าวสารทั้งหมด <i class="bi bi-arrow-right ms-2"></i></a>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <style>
        .news-home-card {
            border: 1px solid rgba(0,0,0,0.05) !important;
            transition: all 0.3s ease;
        }
        .news-home-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(85, 26, 139, 0.1) !important;
            border-color: rgba(85, 26, 139, 0.2) !important;
        }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        .object-fit-cover { object-fit: cover; }
    </style>

    <!-- Menu Section -->
    <section class="menu-section" id="explore">
        <div class="container">
            <div class="section-header">
                <h2>งานสวนพฤกษศาสตร์โรงเรียน</h2>
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
            </div>
        </div>
    </section>

    <!-- Info Cards Section -->
    <section class="info-cards-section py-5" style="background: white;">
        <div class="container">
            <div class="section-header text-center mb-5">
                <span class="tag-line" style="color: #551a8b;">สาระน่ารู้</span>
                <h2 class="fw-bold" style="color: #551a8b;">ความรู้เบื้องต้นงานสวนพฤกษศาสตร์</h2>
                <div class="line mx-auto" style="width: 80px; height: 4px; background: #ffd700; border-radius: 2px; margin-top: 15px;"></div>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 animate__animated animate__fadeInLeft">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-body p-4 border-top border-4" style="border-color: #8b2e8b !important;">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-label-pink p-2 rounded-3 me-3" style="background: #f8f4ff; color: #8b2e8b;">
                                    <i class="bi bi-tree fs-3"></i>
                                </div>
                                <h4 class="card-title mb-0 fw-bold" style="color: #333;">สวนพฤกษศาสตร์ คือ</h4>
                            </div>
                            <p class="card-text text-muted" style="line-height: 1.8;">
                                สถาบันทางวิชาการที่รวบรวมและปลูกพรรณไม้ชนิดต่างๆ ทั้งที่มีชีวิตและตัวอย่างแห้ง โดยจัดหมวดหมู่ตามหลักพฤกษศาสตร์ เพื่อการอนุรักษ์ความหลากหลายทางชีวภาพ การศึกษาวิจัย และเผยแพร่ความรู้แก่สาธารณะ
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 animate__animated animate__fadeInUp">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-body p-4 border-top border-4" style="border-color: #551a8b !important;">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-label-blue p-2 rounded-3 me-3" style="background: #f8f4ff; color: #551a8b;">
                                    <i class="bi bi-book fs-3"></i>
                                </div>
                                <h4 class="card-title mb-0 fw-bold" style="color: #333;">สวนพฤกษศาสตร์โรงเรียน คือ</h4>
                            </div>
                            <p class="card-text text-muted" style="line-height: 1.8;">
                                ทุกสิ่งทุกอย่างที่มีอยู่ในโรงเรียนที่ใช้เพื่อการเรียนรู้ โดยมี <strong>"พืช"</strong> เป็นปัจจัยหลัก ประกอบด้วยปัจจัยทางชีวภาพ สภาพแวดล้อมทางกายภาพ และวัสดุอุปกรณ์ที่ใช้ในการดำเนินงานเพื่อการเรียนรู้ของเยาวชน
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 animate__animated animate__fadeInRight">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-body p-4 border-top border-4" style="border-color: #52b788 !important;">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-label-green p-2 rounded-3 me-3" style="background: #e9f7ef; color: #52b788;">
                                    <i class="bi bi-heart-pulse fs-3"></i>
                                </div>
                                <h4 class="card-title mb-0 fw-bold" style="color: #333;">งานสวนพฤกษศาสตร์โรงเรียน คือ</h4>
                            </div>
                            <p class="card-text text-muted" style="line-height: 1.8;">
                                การดำเนินงานเพื่อสร้างจิตสำนึกในการอนุรักษ์พันธุกรรมพืชและทรัพยากรธรรมชาติ เน้นให้นักเรียนได้สัมผัสและเรียนรู้ธรรมชาติจริง เพื่อปลูกฝังคุณธรรม ความตระหนักในคุณค่า และความงดงามของสรรพสิ่ง
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="info-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0 animate__animated animate__fadeInLeft">
                    <img src="<?= base_url('assets/img/botany/info_eggplant.png') ?>" alt="มะเขือเจ้าพระยา" class="info-img">
                </div>
                <div class="col-lg-6 ps-lg-5 animate__animated animate__fadeInRight">
                    <span class="tag-line" style="color: #8b2e8b;">พรรณไม้เด่นของโรงเรียน</span>
                    <h2 class="info-title" style="color: #551a8b; font-weight: 800;">มะเขือเจ้าพระยา<br><span style="font-size: 0.7em; color: #8b2e8b; font-weight: 600;">(Thai Eggplant)</span></h2>
                    <p class="info-text" style="text-align: justify; line-height: 1.8;">
                        มีถิ่นกำเนิดดั้งเดิมในประเทศอินเดีย เป็นพืชล้มลุกในวงศ์ Solanaceae ที่แพร่กระจายและนิยมปลูกแพร่หลายในเขตร้อน รวมถึงไทย นิยมนำมาประกอบอาหาร เช่น แกงเผ็ด จิ้มน้ำพริก หรือกินสด มีสรรพคุณทางยา เช่น ช่วยลดไข้ แก้ร้อนใน และบำรุงหัวใจ
                    </p>
                    
                    <div class="insight-info mt-4">
                        <h5 class="fw-bold mb-3" style="color: #551a8b;"><i class="bi bi-info-circle-fill me-2"></i> ข้อมูลเชิงลึกมะเขือเจ้าพระยา:</h5>
                        <ul class="list-unstyled">
                            <li class="mb-3 d-flex align-items-start">
                                <i class="bi bi-geo-alt-fill text-purple me-3 mt-1" style="color: #8b2e8b;"></i>
                                <span><strong>ที่มาและการแพร่กระจาย:</strong> ต้นกำเนิดจากประเทศอินเดียและกระจายพันธุ์มายังเอเชียตะวันออกเฉียงใต้ เช่น ไทย บังคลาเทศ พม่า และลาว</span>
                            </li>
                            <li class="mb-3 d-flex align-items-start">
                                <i class="bi bi-flower1 text-purple me-3 mt-1" style="color: #8b2e8b;"></i>
                                <span><strong>ลักษณะเด่น:</strong> เป็นไม้พุ่มสูง 2-4 ฟุต ดอกสีม่วงหรือขาว ผลทรงกลมแบนหรือรูปไข่ ผิวเรียบ สีขาว เขียว หรือม่วง ลายริ้วสีขาว</span>
                            </li>
                            <li class="mb-3 d-flex align-items-start">
                                <i class="bi bi-shield-plus text-purple me-3 mt-1" style="color: #8b2e8b;"></i>
                                <span><strong>คุณค่าและสรรพคุณ:</strong> รสชาติกรอบ หวานปนขมเล็กน้อย ช่วยบำรุงหัวใจ และมีฤทธิ์ต้านเซลล์มะเร็งลำไส้ใหญ่/ตับ</span>
                            </li>
                        </ul>
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
