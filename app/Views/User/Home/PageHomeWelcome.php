<style>
    /* ==========================================================================
       WELCOME SECTION - MODERN & BALANCED UX/UI
       ========================================================================== */
    .welcome-section {
        padding: 90px 0;
        background: #ffffff;
        position: relative;
        overflow: hidden;
    }

    /* Ambient Background Glows */
    .welcome-section .ambient-glow {
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        pointer-events: none;
        z-index: 1;
    }
    .welcome-section .glow-pink {
        top: -60px;
        right: -60px;
        width: 380px;
        height: 380px;
        background: radial-gradient(circle, rgba(251, 126, 156, 0.12) 0%, rgba(251, 126, 156, 0) 70%);
    }
    .welcome-section .glow-blue {
        bottom: -80px;
        left: -80px;
        width: 420px;
        height: 420px;
        background: radial-gradient(circle, rgba(36, 159, 253, 0.10) 0%, rgba(36, 159, 253, 0) 70%);
    }

    /* Subtle Geometric Grid Overlay */
    .welcome-section::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(36, 159, 253, 0.04) 1px, transparent 1px),
                          radial-gradient(rgba(251, 126, 156, 0.04) 1px, transparent 1px);
        background-size: 32px 32px;
        background-position: 0 0, 16px 16px;
        pointer-events: none;
        z-index: 1;
    }

    /* Subtitle Badge */
    .welcome-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, rgba(251, 126, 156, 0.1) 0%, rgba(36, 159, 253, 0.1) 100%);
        border: 1px solid rgba(251, 126, 156, 0.25);
        color: #d44369;
        font-weight: 700;
        font-size: 0.85rem;
        letter-spacing: 1px;
        text-transform: uppercase;
        padding: 6px 16px;
        border-radius: 50px;
        margin-bottom: 18px;
        box-shadow: 0 2px 8px rgba(251, 126, 156, 0.08);
    }
    .welcome-badge i {
        font-size: 1rem;
        color: var(--secondary);
    }

    /* Main Heading */
    .welcome-heading {
        margin-bottom: 1.25rem;
        font-weight: 800;
        line-height: 1.25;
        color: #1e293b;
    }
    .welcome-heading .line-1 {
        font-size: clamp(1.85rem, 3.8vw, 2.75rem);
        display: block;
        margin-bottom: 6px;
    }
    .welcome-heading .line-2 {
        font-size: clamp(1.25rem, 2.6vw, 1.85rem);
        display: block;
        font-weight: 600;
        color: #475569;
    }

    .badge-skj-pink {
        color: #e91e63;
        position: relative;
        font-weight: 800;
    }
    .badge-skj-blue {
        color: #0288d1;
        position: relative;
        font-weight: 800;
    }

    /* Mission Description */
    .welcome-desc {
        font-size: 1.05rem;
        line-height: 1.85;
        color: #64748b;
        margin-bottom: 2rem;
        position: relative;
        padding-left: 18px;
        border-left: 3px solid var(--primary);
    }
    .welcome-desc strong {
        color: #1e293b;
        font-weight: 600;
    }

    /* ==========================================================================
       DIRECTOR SHOWCASE (LEFT COLUMN)
       ========================================================================== */
    .director-showcase-card {
        background: linear-gradient(165deg, #ffffff 0%, #fff7f9 60%, #f0f7ff 100%);
        border: 1px solid rgba(251, 126, 156, 0.2);
        border-radius: 32px;
        padding: 24px 20px 20px;
        box-shadow: 0 20px 45px -10px rgba(36, 159, 253, 0.12),
                    0 10px 25px -5px rgba(251, 126, 156, 0.1);
        position: relative;
        overflow: hidden;
        transition: transform 0.4s ease, box-shadow 0.4s ease;
    }

    .director-showcase-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 25px 50px -10px rgba(36, 159, 253, 0.18),
                    0 15px 30px -5px rgba(251, 126, 156, 0.15);
    }

    /* Decorative Halo inside Director Card */
    .director-showcase-card::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        width: 260px;
        height: 260px;
        background: radial-gradient(circle, rgba(251, 126, 156, 0.18) 0%, rgba(36, 159, 253, 0.12) 50%, transparent 70%);
        border-radius: 50%;
        z-index: 1;
        pointer-events: none;
    }

    .director-img-wrap {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        min-height: 380px;
        padding-bottom: 10px;
    }

    .director-img-wrap img {
        width: 100%;
        max-width: 360px;
        height: auto;
        max-height: 420px;
        object-fit: contain;
        filter: drop-shadow(0 14px 20px rgba(0, 0, 0, 0.08));
        transition: transform 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
        position: relative;
        z-index: 2;
    }

    .director-showcase-card:hover .director-img-wrap img {
        transform: scale(1.02);
    }

    /* Direct Line Card */
    .director-hotline-btn {
        position: relative;
        z-index: 3;
        background: linear-gradient(135deg, #fb7e9c 0%, #e05377 45%, #249ffd 100%);
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 20px;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        color: #ffffff !important;
        text-decoration: none !important;
        box-shadow: 0 10px 25px rgba(224, 83, 119, 0.35);
        transition: all 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        margin-top: 10px;
    }

    .director-hotline-btn:hover {
        transform: translateY(-3px) scale(1.01);
        box-shadow: 0 16px 32px rgba(36, 159, 253, 0.35);
        color: #ffffff !important;
    }

    .hotline-icon-wrap {
        position: relative;
        width: 48px;
        height: 48px;
        min-width: 48px;
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.22);
        backdrop-filter: blur(6px);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        color: #ffffff;
    }

    .hotline-icon-wrap::after {
        content: '';
        position: absolute;
        inset: -3px;
        border-radius: 16px;
        border: 2px solid rgba(255, 255, 255, 0.5);
        animation: hotline-pulse 2s infinite ease-out;
    }

    @keyframes hotline-pulse {
        0% { transform: scale(1); opacity: 0.8; }
        100% { transform: scale(1.35); opacity: 0; }
    }

    .hotline-info {
        flex: 1;
        line-height: 1.2;
    }

    .hotline-info .hotline-label {
        font-size: 0.78rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        opacity: 0.92;
        display: block;
        margin-bottom: 3px;
    }

    .hotline-info .hotline-number {
        font-size: 1.35rem;
        font-weight: 800;
        letter-spacing: 1px;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.12);
    }

    .hotline-action-badge {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(4px);
        padding: 6px 12px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
        border: 1px solid rgba(255, 255, 255, 0.35);
        transition: background 0.3s;
    }

    .director-hotline-btn:hover .hotline-action-badge {
        background: rgba(255, 255, 255, 0.38);
    }

    /* ==========================================================================
       THE 5 PILLARS GRID (BALANCED 3-OVER-2 SYMMETRICAL LAYOUT)
       ========================================================================== */
    .pillars-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 16px;
    }

    /* Row 1: 3 cards (2 cols each = 6) */
    .pillar-item:nth-child(1),
    .pillar-item:nth-child(2),
    .pillar-item:nth-child(3) {
        grid-column: span 2;
    }

    /* Row 2: 2 cards (3 cols each = 6, perfectly balanced & filled!) */
    .pillar-item:nth-child(4),
    .pillar-item:nth-child(5) {
        grid-column: span 3;
    }

    .pillar-card {
        background: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 20px;
        padding: 18px 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        height: 100%;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        position: relative;
        overflow: hidden;
    }

    .pillar-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: transparent;
        transition: background 0.3s ease;
    }

    .pillar-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 25px rgba(36, 159, 253, 0.08);
        border-color: rgba(251, 126, 156, 0.35);
    }

    .pillar-card.theme-pink:hover::before {
        background: var(--primary);
    }
    .pillar-card.theme-blue:hover::before {
        background: var(--secondary);
    }

    .pillar-icon {
        width: 50px;
        height: 50px;
        min-width: 50px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.45rem;
        transition: transform 0.3s ease;
    }

    .pillar-card:hover .pillar-icon {
        transform: scale(1.1) rotate(3deg);
    }

    .icon-pink {
        background: linear-gradient(135deg, rgba(251, 126, 156, 0.16) 0%, rgba(251, 126, 156, 0.06) 100%);
        color: #e04b73;
        border: 1px solid rgba(251, 126, 156, 0.25);
    }
    .icon-blue {
        background: linear-gradient(135deg, rgba(36, 159, 253, 0.16) 0%, rgba(36, 159, 253, 0.06) 100%);
        color: #1688db;
        border: 1px solid rgba(36, 159, 253, 0.25);
    }

    .pillar-body {
        flex: 1;
        min-width: 0;
    }

    .pillar-body h6 {
        font-size: 1.02rem;
        font-weight: 700;
        margin-bottom: 3px;
        color: #1e293b;
        letter-spacing: -0.2px;
    }

    .pillar-body p {
        font-size: 0.84rem;
        color: #64748b;
        margin: 0;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* ==========================================================================
       RESPONSIVE BREAKPOINTS
       ========================================================================== */
    @media (max-width: 1199px) and (min-width: 992px) {
        .welcome-section {
            padding: 80px 0;
        }
        .pillars-grid {
            gap: 12px;
        }
        .pillar-card {
            padding: 14px;
            gap: 10px;
        }
        .pillar-icon {
            width: 44px;
            height: 44px;
            min-width: 44px;
            font-size: 1.25rem;
        }
        .pillar-body h6 {
            font-size: 0.95rem;
        }
        .pillar-body p {
            font-size: 0.78rem;
        }
        .director-img-wrap {
            min-height: 340px;
        }
    }

    @media (max-width: 991px) {
        .welcome-section {
            padding: 60px 0;
        }
        .welcome-heading {
            text-align: center;
        }
        .welcome-badge-wrap {
            text-align: center;
        }
        .welcome-desc {
            text-align: center;
            border-left: none;
            padding-left: 0;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        .director-showcase-card {
            max-width: 420px;
            margin: 0 auto 35px;
            padding: 20px 16px 16px;
        }
        .director-img-wrap {
            min-height: 320px;
        }
        .director-img-wrap img {
            max-height: 360px;
        }
        .pillars-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        .pillar-item:nth-child(1),
        .pillar-item:nth-child(2),
        .pillar-item:nth-child(3),
        .pillar-item:nth-child(4) {
            grid-column: span 1;
        }
        .pillar-item:nth-child(5) {
            grid-column: span 2;
        }
    }

    @media (max-width: 576px) {
        .welcome-section {
            padding: 45px 0;
        }
        .welcome-heading .line-1 {
            font-size: 1.65rem;
        }
        .welcome-heading .line-2 {
            font-size: 1.15rem;
        }
        .welcome-desc {
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
        }
        .director-showcase-card {
            border-radius: 26px;
            padding: 16px 14px 14px;
        }
        .director-img-wrap {
            min-height: 280px;
        }
        .director-img-wrap img {
            max-height: 320px;
        }
        .director-hotline-btn {
            padding: 12px 14px;
            border-radius: 16px;
        }
        .hotline-icon-wrap {
            width: 42px;
            height: 42px;
            min-width: 42px;
            font-size: 1.2rem;
        }
        .hotline-info .hotline-number {
            font-size: 1.15rem;
        }
        .hotline-action-badge {
            display: none;
        }
        .pillars-grid {
            grid-template-columns: 1fr;
            gap: 10px;
        }
        .pillar-item:nth-child(n) {
            grid-column: span 1 !important;
        }
        .pillar-card {
            padding: 14px 16px;
            border-radius: 16px;
        }
    }
</style>

<section class="welcome-section">
    <!-- Ambient Background Lighting -->
    <div class="ambient-glow glow-pink"></div>
    <div class="ambient-glow glow-blue"></div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center g-4 g-xl-5">

            <!-- Director Column (Left on Desktop) -->
            <div class="col-lg-5 order-2 order-lg-1 wow fadeInLeft" data-wow-delay="0.2s">
                <div class="director-showcase-card">
                    <!-- Director Photo with Signature & Badge -->
                    <div class="director-img-wrap">
                        <img src="<?= base_url('uploads/director/pa.png') ?>" 
                             alt="ผู้อำนวยการโรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์" 
                             loading="lazy">
                    </div>

                    <!-- Direct Line Hotline Button -->
                    <a href="tel:0989789705" class="director-hotline-btn" title="โทรสายตรงถึงผู้บริหารสถานศึกษา">
                        <div class="hotline-icon-wrap">
                            <i class="bi bi-telephone-outbound-fill"></i>
                        </div>
                        <div class="hotline-info">
                            <span class="hotline-label">สายตรงถึงผู้บริหารสถานศึกษา</span>
                            <h3 class="hotline-number">098-978-9705</h3>
                        </div>
                        <span class="hotline-action-badge">
                            <i class="bi bi-arrow-up-right-circle-fill"></i> โทรทันที
                        </span>
                    </a>
                </div>
            </div>

            <!-- Content Column (Right on Desktop) -->
            <div class="col-lg-7 order-1 order-lg-2 ps-lg-4 ps-xl-5 wow fadeInRight" data-wow-delay="0.3s">
                <!-- Subtitle Badge -->
                <div class="welcome-badge-wrap">
                    <div class="welcome-badge">
                        <i class="bi bi-award-fill"></i>
                        <span>Welcome To SKJ School</span>
                    </div>
                </div>

                <!-- Main Heading -->
                <h1 class="welcome-heading">
                    <span class="line-1">ยินดีต้อนรับสู่รั้ว <span class="badge-skj-pink">ชมพู</span> - <span class="badge-skj-blue">ฟ้า</span></span>
                    <span class="line-2">สวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</span>
                </h1>

                <!-- Mission Description -->
                <p class="welcome-desc">
                    สถาบันการศึกษาที่มุ่งเน้นการสร้าง <strong>"สุภาพบุรุษและสุภาพสตรีสวนกุหลาบ"</strong> ผู้มีคุณธรรม นำความรู้ และมีความเป็นเลิศในทุกด้านตามศักยภาพรายบุคคล
                </p>

                <!-- 5 Pillars of Excellence (Balanced Symmetrical Grid) -->
                <div class="pillars-grid">
                    <!-- Item 1: วิชาการเข้ม -->
                    <div class="pillar-item wow fadeInUp" data-wow-delay="0.1s">
                        <div class="pillar-card theme-pink">
                            <div class="pillar-icon icon-pink">
                                <i class="bi bi-mortarboard-fill"></i>
                            </div>
                            <div class="pillar-body">
                                <h6>วิชาการเข้ม</h6>
                                <p>หลักสูตรทันสมัย สู่มหาวิทยาลัยชั้นนำ</p>
                            </div>
                        </div>
                    </div>

                    <!-- Item 2: กีฬาเด่น -->
                    <div class="pillar-item wow fadeInUp" data-wow-delay="0.2s">
                        <div class="pillar-card theme-blue">
                            <div class="pillar-icon icon-blue">
                                <i class="bi bi-trophy-fill"></i>
                            </div>
                            <div class="pillar-body">
                                <h6>กีฬาเด่น</h6>
                                <p>ศักยภาพสู่มืออาชีพ ทุกประเภทกีฬา</p>
                            </div>
                        </div>
                    </div>

                    <!-- Item 3: ภาษาเลิศ -->
                    <div class="pillar-item wow fadeInUp" data-wow-delay="0.3s">
                        <div class="pillar-card theme-blue">
                            <div class="pillar-icon icon-blue">
                                <i class="bi bi-translate"></i>
                            </div>
                            <div class="pillar-body">
                                <h6>ภาษาเลิศ</h6>
                                <p>อังกฤษ-จีน ก้าวสู่ระดับสากล</p>
                            </div>
                        </div>
                    </div>

                    <!-- Item 4: ศิลป์เด่น -->
                    <div class="pillar-item wow fadeInUp" data-wow-delay="0.4s">
                        <div class="pillar-card theme-pink">
                            <div class="pillar-icon icon-pink">
                                <i class="bi bi-palette-fill"></i>
                            </div>
                            <div class="pillar-body">
                                <h6>ศิลป์เด่น</h6>
                                <p>ดนตรี นาฏศิลป์ สร้างสรรค์จินตนาการ</p>
                            </div>
                        </div>
                    </div>

                    <!-- Item 5: ทักษะอาชีพ -->
                    <div class="pillar-item wow fadeInUp" data-wow-delay="0.5s">
                        <div class="pillar-card theme-pink">
                            <div class="pillar-icon icon-pink">
                                <i class="bi bi-tools"></i>
                            </div>
                            <div class="pillar-body">
                                <h6>ทักษะอาชีพ</h6>
                                <p>ฝึกปฎิบัติจริง สร้างพื้นฐานอาชีพที่มั่นคง</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>
