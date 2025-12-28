<style>
    .skj-group-section {
        padding: 60px 0;
        background-color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    @media (max-width: 768px) {
        .skj-group-section {
            padding: 40px 0;
        }
    }

    .skj-group-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at 20% 30%, rgba(251, 126, 156, 0.03) 0%, transparent 50%),
                    radial-gradient(circle at 80% 70%, rgba(36, 159, 253, 0.03) 0%, transparent 50%);
        pointer-events: none;
    }

    .skj-fb-card {
        background: #fff;
        border-radius: 20px;
        padding: 25px 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(0,0,0,0.04);
        position: relative;
        height: 100%;
        text-decoration: none !important;
        box-shadow: 0 5px 15px rgba(0,0,0,0.02);
    }

    .skj-fb-card:hover {
        transform: scale(1.05);
        box-shadow: 0 15px 35px rgba(0,0,0,0.08);
        border-color: #249ffd;
    }

    .skj-fb-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
        transition: all 0.3s ease;
    }

    .skj-fb-card:hover .skj-fb-icon {
        transform: rotate(-10deg);
    }

    .skj-fb-text {
        font-size: 1rem;
        font-weight: 700;
        color: #1a2a4d;
        line-height: 1.3;
        margin: 0;
        transition: color 0.3s ease;
    }

    .skj-fb-card:hover .skj-fb-text {
        color: #249ffd;
    }

    .skj-fb-badge {
        position: absolute;
        top: -10px;
        right: 15px;
        background: #1877F2; /* Facebook Blue */
        color: #fff;
        font-size: 0.65rem;
        padding: 2px 8px;
        border-radius: 10px;
        font-weight: 800;
        text-transform: uppercase;
        box-shadow: 0 4px 8px rgba(24, 119, 242, 0.3);
    }

    @media (max-width: 768px) {
        .skj-fb-card {
            padding: 10px 12px;
            border-radius: 15px;
            gap: 10px;
        }
        .skj-fb-icon {
            width: 35px;
            height: 35px;
            font-size: 1.1rem;
            border-radius: 8px;
        }
        .skj-fb-text {
            font-size: 0.85rem;
        }
        .skj-fb-badge {
            font-size: 0.55rem;
            padding: 1px 6px;
            top: -8px;
            right: 10px;
        }
    }
</style>

<section class="skj-group-section">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h6 class="section-title bg-white text-center px-3" style="color: #249ffd;">Community Hub</h6>
            <h1 class="display-6 mb-4" style="font-weight: 800; color: #1a2a4d;">Facebook Fanpage</h1>
            <p class="text-muted">รวมกลุ่มสาระและกิจกรรม แลกเปลี่ยนข่าวสารในรั้วโรงเรียน</p>
        </div>

        <div class="row g-4 justify-content-center">
            <!-- ภาษาไทย -->
            <div class="col-lg-3 col-md-6 col-6 wow fadeInUp" data-wow-delay="0.1s">
                <a href="https://www.facebook.com/%E0%B8%A0%E0%B8%B2%E0%B8%A9%E0%B8%B2%E0%B9%84%E0%B8%97%E0%B8%A2-%E0%B8%AA%E0%B8%81%E0%B8%88-1866513180276025" target="_blank" class="skj-fb-card">
                    <span class="skj-fb-badge">Follow</span>
                    <div class="skj-fb-icon" style="background: rgba(255, 187, 44, 0.15); color: #ffbb2c;">
                        <i class="bi bi-textarea-t"></i>
                    </div>
                    <h3 class="skj-fb-text">ภาษาไทย สกจ.</h3>
                </a>
            </div>

            <!-- Science -->
            <div class="col-lg-3 col-md-6 col-6 wow fadeInUp" data-wow-delay="0.2s">
                <a href="https://www.facebook.com/Science-SKJ-1956424297925810" target="_blank" class="skj-fb-card">
                    <span class="skj-fb-badge">Follow</span>
                    <div class="skj-fb-icon" style="background: rgba(227, 97, 255, 0.15); color: #e361ff;">
                        <i class="bi bi-thermometer"></i>
                    </div>
                    <h3 class="skj-fb-text">Science Tech SKJ</h3>
                </a>
            </div>

            <!-- Math -->
            <div class="col-lg-3 col-md-6 col-6 wow fadeInUp" data-wow-delay="0.3s">
                <a href="https://www.facebook.com/Math-SKJ-291631241382312" target="_blank" class="skj-fb-card">
                    <span class="skj-fb-badge">Follow</span>
                    <div class="skj-fb-icon" style="background: rgba(71, 174, 255, 0.15); color: #47aeff;">
                        <i class="bi bi-calculator"></i>
                    </div>
                    <h3 class="skj-fb-text">Math SKJ</h3>
                </a>
            </div>

            <!-- Social -->
            <div class="col-lg-3 col-md-6 col-6 wow fadeInUp" data-wow-delay="0.4s">
                <a href="https://www.facebook.com/SKJ.social/" target="_blank" class="skj-fb-card">
                    <span class="skj-fb-badge">Follow</span>
                    <div class="skj-fb-icon" style="background: rgba(255, 167, 110, 0.15); color: #ffa76e;">
                        <i class="bi bi-globe2"></i>
                    </div>
                    <h3 class="skj-fb-text">สังคมศึกษา สกจ.นว</h3>
                </a>
            </div>

            <!-- Art -->
            <div class="col-lg-3 col-md-6 col-6 wow fadeInUp" data-wow-delay="0.5s">
                <a href="https://www.facebook.com/profile.php?id=100088994113102" target="_blank" class="skj-fb-card">
                    <span class="skj-fb-badge">Follow</span>
                    <div class="skj-fb-icon" style="background: rgba(17, 219, 207, 0.15); color: #11dbcf;">
                        <i class="bi bi-brush"></i>
                    </div>
                    <h3 class="skj-fb-text">ศิลปะ สกจ.</h3>
                </a>
            </div>

            <!-- Committee -->
            <div class="col-lg-3 col-md-6 col-6 wow fadeInUp" data-wow-delay="0.6s">
                <a href="https://www.facebook.com/skjcommittee" target="_blank" class="skj-fb-card">
                    <span class="skj-fb-badge">Follow</span>
                    <div class="skj-fb-icon" style="background: rgba(17, 219, 207, 0.15); color: #11dbcf;">
                        <i class="bi bi-people"></i>
                    </div>
                    <h3 class="skj-fb-text">คณะกรรมการนักเรียน</h3>
                </a>
            </div>

            <!-- Cheer -->
            <div class="col-lg-3 col-md-6 col-6 wow fadeInUp" data-wow-delay="0.7s">
                <a href="https://www.facebook.com/CHEER-CLUB-SKJ-444486202632885" target="_blank" class="skj-fb-card">
                    <span class="skj-fb-badge">Follow</span>
                    <div class="skj-fb-icon" style="background: rgba(66, 51, 255, 0.15); color: #4233ff;">
                        <i class="bi bi-camera-video"></i>
                    </div>
                    <h3 class="skj-fb-text">CHEER CLUB SKJ</h3>
                </a>
            </div>
        </div>
    </div>
</section>