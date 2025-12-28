<style>
    .slogan-section {
        position: relative;
        padding: 60px 0;
        background: linear-gradient(135deg, #FB7E9C 0%, #249ffd 100%);
        overflow: hidden;
        margin: 0px 0;
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
        width: 100px;
        height: 100px;
        background: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        margin-bottom: 25px;
        animation: float-logo 4s infinite ease-in-out;
    }

    @keyframes float-logo {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .slogan-logo-wrapper img {
        width: 100%;
        height: auto;
    }

    .slogan-text-group {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 15px 30px;
        max-width: 1000px;
    }

    .slogan-item {
        color: #fff;
        font-family: 'K2D', sans-serif;
        font-weight: 800;
        font-size: clamp(1.2rem, 3vw, 2.22rem);
        text-shadow: 2px 3px 5px rgba(0,0,0,0.2);
        white-space: nowrap;
        position: relative;
        transition: all 0.3s ease;
    }

    .slogan-item:hover {
        transform: scale(1.1);
        text-shadow: 0 0 20px rgba(255,255,255,0.6);
    }

    @media (max-width: 991px) {
        .slogan-section {
            padding: 40px 0;
        }
        .slogan-item {
            font-size: 1.4rem;
            gap: 10px 20px;
        }
        .slogan-logo-wrapper {
            width: 80px;
            height: 80px;
        }
    }

    @media (max-width: 575px) {
        .slogan-text-group {
            gap: 10px 15px;
        }
        .slogan-item {
            font-size: 1.1rem;
        }
    }
</style>

<div class="slogan-section wow fadeIn" data-wow-delay="0.1s">
    <div class="container">
        <div class="slogan-container">
            <div class="slogan-logo-wrapper wow zoomIn" data-wow-delay="0.3s">
                <img src="<?=base_url()?>/assets/img/logo/Logo-nav.png" alt="Logo" loading="lazy">
            </div>
            
            <div class="slogan-text-group">
                <span class="slogan-item wow fadeInUp" data-wow-delay="0.5s">เป็นผู้นำ</span>
                <span class="slogan-item wow fadeInUp" data-wow-delay="0.6s">รักเพื่อน</span>
                <span class="slogan-item wow fadeInUp" data-wow-delay="0.7s">นับถือพี่</span>
                <span class="slogan-item wow fadeInUp" data-wow-delay="0.8s">เคารพครู</span>
                <span class="slogan-item wow fadeInUp" data-wow-delay="0.9s">กตัญญูพ่อแม่</span>
                <span class="slogan-item wow fadeInUp" data-wow-delay="1.0s">ดูแลน้อง</span>
                <span class="slogan-item wow fadeInUp" data-wow-delay="1.1s">สนองคุณแผ่นดิน</span>
            </div>
        </div>
    </div>
</div>
