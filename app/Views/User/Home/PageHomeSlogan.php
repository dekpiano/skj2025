<style>
    .slogan-section {
        position: relative;
        padding: 100px 0;
        background: linear-gradient(135deg, rgba(251, 126, 156, 0.9) 0%, rgba(36, 159, 253, 0.9) 100%), url('<?= base_url('uploads/background/bg-slogan.jpg') ?>');
        background-attachment: fixed;
        background-position: center;
        background-size: cover;
        overflow: hidden;
    }

    .slogan-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none"><path d="M0,50 Q250,0 500,50 T1000,50 L1000,100 L0,100 Z" fill="white" opacity="0.1"/></svg>');
        background-size: 1000px 50px;
        background-repeat: repeat-x;
        background-position: bottom;
        z-index: 1;
    }

    .slogan-container {
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .slogan-logo-wrapper {
        width: 120px;
        height: 120px;
        background: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.2);
        margin-bottom: 35px;
        animation: float-logo 5s infinite ease-in-out;
        border: 5px solid rgba(255, 255, 255, 0.3);
    }

    @keyframes float-logo {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-15px) rotate(5deg); }
    }

    .slogan-logo-wrapper img {
        width: 100%;
        height: auto;
    }

    .slogan-text-group {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px 40px;
        max-width: 1100px;
    }

    .slogan-item {
        color: #fff;
        font-family: 'K2D', sans-serif;
        font-weight: 800;
        font-size: clamp(1.4rem, 4vw, 2.5rem);
        text-shadow: 0 4px 10px rgba(0,0,0,0.3);
        white-space: nowrap;
        position: relative;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .slogan-item:hover {
        transform: scale(1.15);
        color: #fff;
        text-shadow: 0 10px 25px rgba(255, 255, 255, 0.5);
    }

    @media (max-width: 991px) {
        .slogan-section { padding: 60px 0; }
        .slogan-item { font-size: 1.6rem; }
        .slogan-logo-wrapper { width: 90px; height: 90px; padding: 15px; }
        .slogan-text-group { gap: 15px 25px; }
    }

    @media (max-width: 575px) {
        .slogan-text-group { gap: 10px 15px; }
        .slogan-item { font-size: 1.2rem; }
    }
</style>

<div class="slogan-section wow fadeIn">
    <div class="container">
        <div class="slogan-container">
            <div class="slogan-logo-wrapper wow zoomIn" data-wow-delay="0.2s">
                <img src="<?=base_url()?>/assets/img/logo/Logo-nav.png" alt="Logo" loading="lazy">
            </div>
            
            <div class="slogan-text-group">
                <span class="slogan-item wow fadeInUp" data-wow-delay="0.4s">เป็นผู้นำ</span>
                <span class="slogan-item wow fadeInUp" data-wow-delay="0.5s">รักเพื่อน</span>
                <span class="slogan-item wow fadeInUp" data-wow-delay="0.6s">นับถือพี่</span>
                <span class="slogan-item wow fadeInUp" data-wow-delay="0.7s">เคารพครู</span>
                <span class="slogan-item wow fadeInUp" data-wow-delay="0.8s">กตัญญูพ่อแม่</span>
                <span class="slogan-item wow fadeInUp" data-wow-delay="0.9s">ดูแลน้อง</span>
                <span class="slogan-item wow fadeInUp" data-wow-delay="1.0s">สนองคุณแผ่นดิน</span>
            </div>
        </div>
    </div>
</div>
