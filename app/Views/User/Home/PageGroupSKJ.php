<style>
/* ==========================================================================
   SKJ GROUP SECTION - MODERN COMMUNITY HUB & FROSTED GLASS
   ดีไซน์ใหม่: โปร่งแสง สไตล์ Frosted Crystal Glass, ไอคอน Squircle สดใส
   ========================================================================== */
.skj-group-section {
    padding: 60px 0 75px 0;
    background: transparent !important;
    position: relative;
    overflow: hidden;
}

/* Header Area */
.group-header-wrap {
    position: relative;
    z-index: 1;
    max-width: 680px;
    margin: 0 auto 35px auto;
    text-align: center;
}

.group-sec-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, rgba(24, 119, 242, 0.12) 0%, rgba(36, 159, 253, 0.12) 100%);
    border: 1px solid rgba(24, 119, 242, 0.25);
    color: #1877F2;
    font-size: 0.82rem;
    font-weight: 700;
    padding: 6px 18px;
    border-radius: 50px;
    letter-spacing: 0.5px;
    margin-bottom: 12px;
    backdrop-filter: blur(10px);
}

.group-sec-title {
    font-size: clamp(2rem, 3.5vw, 2.6rem);
    font-weight: 900;
    color: #0f172a;
    font-family: 'K2D', sans-serif;
    margin-bottom: 8px;
    letter-spacing: -0.5px;
}

.group-sec-desc {
    color: #64748b;
    font-size: 0.95rem;
    font-weight: 400;
    margin-bottom: 0;
}

/* ==========================================================================
   FROSTED GLASS FACEBOOK CARDS
   ========================================================================== */
.skj-fb-card {
    background: linear-gradient(145deg, rgba(255, 255, 255, 0.84) 0%, rgba(255, 255, 255, 0.62) 100%);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid rgba(255, 255, 255, 0.9);
    border-radius: 20px;
    padding: 16px 18px;
    display: flex;
    align-items: center;
    gap: 14px;
    transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
    height: 100%;
    text-decoration: none !important;
    box-shadow: 0 10px 25px -4px rgba(15, 23, 42, 0.05), 
                0 0 0 1px rgba(0, 0, 0, 0.02);
}

.skj-fb-card:hover {
    transform: translateY(-5px);
    background: linear-gradient(145deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.80) 100%);
    border-color: rgba(24, 119, 242, 0.4);
    box-shadow: 0 16px 36px -6px rgba(24, 119, 242, 0.2), 
                0 0 0 1px rgba(24, 119, 242, 0.25);
}

/* Icon Squircles */
.skj-fb-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.35rem;
    color: #ffffff;
    flex-shrink: 0;
    box-shadow: 0 6px 16px -3px rgba(0, 0, 0, 0.15);
    transition: transform 0.3s ease;
}

.skj-fb-card:hover .skj-fb-icon {
    transform: scale(1.08) rotate(4deg);
}

/* Color Gradients for Icons */
.icon-thai {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    box-shadow: 0 6px 16px -3px rgba(217, 119, 6, 0.4);
}

.icon-sci {
    background: linear-gradient(135deg, #d946ef 0%, #a21caf 100%);
    box-shadow: 0 6px 16px -3px rgba(162, 28, 175, 0.4);
}

.icon-math {
    background: linear-gradient(135deg, #38bdf8 0%, #0284c7 100%);
    box-shadow: 0 6px 16px -3px rgba(2, 132, 199, 0.4);
}

.icon-social {
    background: linear-gradient(135deg, #34d399 0%, #059669 100%);
    box-shadow: 0 6px 16px -3px rgba(5, 150, 105, 0.4);
}

.icon-art {
    background: linear-gradient(135deg, #fb7185 0%, #e11d48 100%);
    box-shadow: 0 6px 16px -3px rgba(225, 29, 72, 0.4);
}

.icon-committee {
    background: linear-gradient(135deg, #a855f7 0%, #7c3aed 100%);
    box-shadow: 0 6px 16px -3px rgba(124, 58, 237, 0.4);
}

.icon-cheer {
    background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
    box-shadow: 0 6px 16px -3px rgba(234, 88, 12, 0.4);
}

/* Card Content Area */
.skj-fb-info {
    flex-grow: 1;
    min-width: 0;
}

.skj-fb-category {
    font-size: 0.72rem;
    font-weight: 600;
    color: #64748b;
    margin-bottom: 2px;
    display: block;
}

.skj-fb-text {
    font-size: 0.95rem;
    font-weight: 700;
    color: #0f172a;
    line-height: 1.25;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    transition: color 0.25s ease;
}

.skj-fb-card:hover .skj-fb-text {
    color: #1877F2;
}

/* Arrow / Facebook Badge */
.skj-fb-action {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: rgba(24, 119, 242, 0.08);
    color: #1877F2;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
    flex-shrink: 0;
    transition: all 0.25s ease;
}

.skj-fb-card:hover .skj-fb-action {
    background: #1877F2;
    color: #ffffff;
    transform: rotate(45deg);
}

/* Responsive adjustments */
@media (max-width: 991px) {
    .skj-group-section { padding: 45px 0 60px 0; }
    .skj-fb-card { padding: 14px 14px; gap: 12px; }
    .skj-fb-icon { width: 42px; height: 42px; font-size: 1.2rem; }
    .skj-fb-text { font-size: 0.88rem; }
}

@media (max-width: 575px) {
    .skj-group-section { padding: 35px 0 45px 0; }
    .skj-fb-card { padding: 12px 10px; border-radius: 16px; gap: 10px; }
    .skj-fb-icon { width: 38px; height: 38px; font-size: 1.1rem; border-radius: 12px; }
    .skj-fb-category { font-size: 0.65rem; }
    .skj-fb-text { font-size: 0.8rem; }
    .skj-fb-action { width: 26px; height: 26px; font-size: 0.75rem; }
}
</style>

<section class="skj-group-section">
    <div class="container">
        <!-- Header -->
        <div class="group-header-wrap wow fadeInUp" data-wow-delay="0.1s">
            <div class="group-sec-badge">
                <i class="bi bi-facebook"></i> SKJ Social Communities
            </div>
            <h2 class="group-sec-title">ศูนย์รวมชุมชนและเพจกิจกรรม</h2>
            <p class="group-sec-desc">ติดตามข่าวสาร กิจกรรมสร้างสรรค์ และแลกเปลี่ยนการเรียนรู้ในรั้วโรงเรียน</p>
        </div>

        <!-- Cards Grid -->
        <div class="row g-3 g-md-4 justify-content-center">
            <!-- ภาษาไทย -->
            <div class="col-lg-3 col-md-6 col-6 wow fadeInUp" data-wow-delay="0.1s">
                <a href="https://www.facebook.com/%E0%B8%A0%E0%B8%B2%E0%B8%A9%E0%B8%B2%E0%B9%84%E0%B8%97%E0%B8%A2-%E0%B8%AA%E0%B8%81%E0%B8%88-1866513180276025" target="_blank" class="skj-fb-card">
                    <div class="skj-fb-icon icon-thai">
                        <i class="bi bi-journal-richtext"></i>
                    </div>
                    <div class="skj-fb-info">
                        <span class="skj-fb-category">กลุ่มสาระฯ</span>
                        <h3 class="skj-fb-text">ภาษาไทย สกจ.</h3>
                    </div>
                    <div class="skj-fb-action">
                        <i class="bi bi-arrow-up-right"></i>
                    </div>
                </a>
            </div>

            <!-- Science -->
            <div class="col-lg-3 col-md-6 col-6 wow fadeInUp" data-wow-delay="0.2s">
                <a href="https://www.facebook.com/Science-SKJ-1956424297925810" target="_blank" class="skj-fb-card">
                    <div class="skj-fb-icon icon-sci">
                        <i class="fa-solid fa-atom"></i>
                    </div>
                    <div class="skj-fb-info">
                        <span class="skj-fb-category">กลุ่มสาระฯ</span>
                        <h3 class="skj-fb-text">Science Tech SKJ</h3>
                    </div>
                    <div class="skj-fb-action">
                        <i class="bi bi-arrow-up-right"></i>
                    </div>
                </a>
            </div>

            <!-- Math -->
            <div class="col-lg-3 col-md-6 col-6 wow fadeInUp" data-wow-delay="0.3s">
                <a href="https://www.facebook.com/Math-SKJ-291631241382312" target="_blank" class="skj-fb-card">
                    <div class="skj-fb-icon icon-math">
                        <i class="bi bi-calculator-fill"></i>
                    </div>
                    <div class="skj-fb-info">
                        <span class="skj-fb-category">กลุ่มสาระฯ</span>
                        <h3 class="skj-fb-text">Math SKJ</h3>
                    </div>
                    <div class="skj-fb-action">
                        <i class="bi bi-arrow-up-right"></i>
                    </div>
                </a>
            </div>

            <!-- Social -->
            <div class="col-lg-3 col-md-6 col-6 wow fadeInUp" data-wow-delay="0.4s">
                <a href="https://www.facebook.com/SKJ.social/" target="_blank" class="skj-fb-card">
                    <div class="skj-fb-icon icon-social">
                        <i class="bi bi-globe-americas"></i>
                    </div>
                    <div class="skj-fb-info">
                        <span class="skj-fb-category">กลุ่มสาระฯ</span>
                        <h3 class="skj-fb-text">สังคมศึกษา สกจ.</h3>
                    </div>
                    <div class="skj-fb-action">
                        <i class="bi bi-arrow-up-right"></i>
                    </div>
                </a>
            </div>

            <!-- Art -->
            <div class="col-lg-3 col-md-6 col-6 wow fadeInUp" data-wow-delay="0.5s">
                <a href="https://www.facebook.com/profile.php?id=100088994113102" target="_blank" class="skj-fb-card">
                    <div class="skj-fb-icon icon-art">
                        <i class="bi bi-palette-fill"></i>
                    </div>
                    <div class="skj-fb-info">
                        <span class="skj-fb-category">กลุ่มสาระฯ</span>
                        <h3 class="skj-fb-text">ศิลปะ สกจ.</h3>
                    </div>
                    <div class="skj-fb-action">
                        <i class="bi bi-arrow-up-right"></i>
                    </div>
                </a>
            </div>

            <!-- Committee -->
            <div class="col-lg-3 col-md-6 col-6 wow fadeInUp" data-wow-delay="0.6s">
                <a href="https://www.facebook.com/skjcommittee" target="_blank" class="skj-fb-card">
                    <div class="skj-fb-icon icon-committee">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="skj-fb-info">
                        <span class="skj-fb-category">งานกิจกรรม</span>
                        <h3 class="skj-fb-text">สภานักเรียน</h3>
                    </div>
                    <div class="skj-fb-action">
                        <i class="bi bi-arrow-up-right"></i>
                    </div>
                </a>
            </div>

            <!-- Cheer -->
            <div class="col-lg-3 col-md-6 col-6 wow fadeInUp" data-wow-delay="0.7s">
                <a href="https://www.facebook.com/CHEER-CLUB-SKJ-444486202632885" target="_blank" class="skj-fb-card">
                    <div class="skj-fb-icon icon-cheer">
                        <i class="bi bi-megaphone-fill"></i>
                    </div>
                    <div class="skj-fb-info">
                        <span class="skj-fb-category">ชมรมกิจกรรม</span>
                        <h3 class="skj-fb-text">CHEER CLUB SKJ</h3>
                    </div>
                    <div class="skj-fb-action">
                        <i class="bi bi-arrow-up-right"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>