<style>
    .robot-honor-section {
        padding: 80px 0;
        background: #ffffff;
        position: relative;
        overflow: hidden;
    }

    /* Abstract Tech Background Elements */
    .robot-honor-section::before {
        content: 'ROBOTICS';
        position: absolute;
        top: 20px;
        right: -50px;
        font-size: 10rem;
        font-weight: 900;
        color: rgba(36, 159, 253, 0.03);
        z-index: 0;
        letter-spacing: 15px;
    }

    .robot-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border-radius: 40px;
        padding: 50px;
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.05);
        position: relative;
        z-index: 2;
    }

    .robot-title-badge {
        display: inline-block;
        padding: 8px 20px;
        background: rgba(251, 126, 156, 0.1);
        color: #FB7E9C;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.9rem;
        margin-bottom: 20px;
        border: 1px solid rgba(251, 126, 156, 0.2);
    }

    .robot-main-title {
        font-size: 2.8rem;
        font-weight: 900;
        color: #1a2a4d;
        line-height: 1.2;
        margin-bottom: 25px;
    }

    .robot-main-title span {
        color: #249ffd;
        position: relative;
        display: inline-block;
    }

    .robot-main-title span::after {
        content: '';
        position: absolute;
        bottom: 5px;
        left: 0;
        width: 100%;
        height: 8px;
        background: rgba(36, 159, 253, 0.15);
        z-index: -1;
    }

    .robot-description {
        font-size: 1.15rem;
        color: #555;
        line-height: 1.8;
        margin-bottom: 30px;
    }

    .robot-read-more {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: #FB7E9C;
        font-weight: 700;
        text-decoration: none;
        padding: 12px 28px;
        background: #fff;
        border-radius: 50px;
        box-shadow: 0 10px 20px rgba(251, 126, 156, 0.15);
        transition: all 0.3s ease;
    }

    .robot-read-more:hover {
        background: #FB7E9C;
        color: #fff;
        transform: translateX(5px);
        box-shadow: 0 15px 30px rgba(251, 126, 156, 0.3);
    }

    .robot-award-logos {
        margin-top: 40px;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .robot-award-logos img {
        height: 100px;
        object-fit: contain;
        filter: drop-shadow(0 10px 15px rgba(0,0,0,0.1));
        transition: transform 0.3s ease;
    }

    .robot-award-logos img:hover {
        transform: scale(1.1);
    }

    .robot-hero-img-wrapper {
        position: relative;
        text-align: center;
    }

    .robot-hero-img {
        max-width: 100%;
        height: auto;
        filter: drop-shadow(0 30px 60px rgba(36, 159, 253, 0.2));
        animation: float-robot-img 8s infinite ease-in-out;
    }

    @keyframes float-robot-img {
        0%, 100% { transform: translateY(0) rotate(0); }
        50% { transform: translateY(-30px) rotate(2deg); }
    }

    .tech-dots {
        position: absolute;
        width: 200px;
        height: 200px;
        background-image: radial-gradient(#249ffd 2px, transparent 2px);
        background-size: 20px 20px;
        opacity: 0.1;
        z-index: 1;
    }

    @media (max-width: 991px) {
        .robot-card { padding: 30px; border-radius: 30px; }
        .robot-main-title { font-size: 2rem; }
        .robot-description { font-size: 1rem; }
        .robot-award-logos img { height: 70px; }
        .robot-honor-section { padding: 60px 0; }
    }
</style>

<section class="robot-honor-section">
    <div class="tech-dots" style="top: 10%; left: 5%;"></div>
    <div class="tech-dots" style="bottom: 10%; right: 5%;"></div>
    
    <div class="container">
        <div class="row g-5 align-items-center">
            <!-- Content Area -->
            <div class="col-lg-7 col-md-12 wow fadeInLeft" data-wow-delay="0.1s">
                <div class="robot-card">
                    <span class="robot-title-badge">
                        <i class="bi bi-trophy-fill me-2"></i> สวน ฯ สร้างชื่อคืออัตลักษณ์
                    </span>
                    <h1 class="robot-main-title">
                        ขอแสดงความยินดีกับ <br>
                        <span>ทีม SKJRobot</span>
                    </h1>
                    <p class="robot-description">
                        ตัวแทนประเทศไทยที่สร้างชื่อเสียงในระดับโลก คว้า 2 รางวัลอันทรงเกียรติจากการแข่งขันหุ่นยนต์นานาชาติ 
                        รายการ <strong>Robochallenge 2022 (13th Edition)</strong> ณ Politehnica University of Bucharest ประเทศโรมาเนีย
                    </p>
                    
                    <a href="https://www.facebook.com/SKJSCITECH/videos/864283951688387" target="_blank" class="robot-read-more">
                        ชมความสำเร็จของทีม <i class="bi bi-arrow-right-circle-fill"></i>
                    </a>

                    <div class="robot-award-logos">
                        <img src="<?=base_url()?>/uploads/robot/logo_langone.png" alt="Award Logo" class="wow zoomIn" data-wow-delay="0.5s">
                        <!-- Add more logos if available -->
                    </div>
                </div>
            </div>

            <!-- Image Area -->
            <div class="col-lg-5 col-md-12 text-center wow fadeInRight" data-wow-delay="0.3s">
                <div class="robot-hero-img-wrapper">
                    <img src="<?=base_url()?>/uploads/robot/logo_robot.png" alt="SKJ Robot" class="robot-hero-img">
                </div>
            </div>
        </div>
    </div>
</section>
