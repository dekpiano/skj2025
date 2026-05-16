<style>
    .welcome-section {
        padding: 100px 0;
        background-color: #fff;
        position: relative;
        overflow: hidden;
    }

    /* Decorative Background Blobs */
    .welcome-section::before {
        content: '';
        position: absolute;
        top: -10%;
        right: -5%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(251, 126, 156, 0.05) 0%, rgba(255, 255, 255, 0) 70%);
        z-index: 1;
        border-radius: 50%;
    }

    .section-subtitle {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: var(--primary);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 0.9rem;
        margin-bottom: 15px;
    }

    .section-subtitle::before {
        content: '';
        width: 30px;
        height: 2px;
        background: var(--primary);
        display: block;
    }

    .welcome-heading {
        margin-bottom: 2rem;
        font-weight: 800;
        line-height: 1.2;
        color: #333;
    }

    .welcome-heading .line-1 {
        font-size: clamp(2rem, 5vw, 3.5rem);
        display: block;
        margin-bottom: 8px;
    }

    .welcome-heading .line-2 {
        font-size: clamp(1.4rem, 3.5vw, 2.2rem);
        display: block;
        font-weight: 700;
        opacity: 0.9;
    }

    .text-pink { color: var(--primary); }
    .text-blue { color: var(--secondary); }

    .welcome-img-card {
        position: relative;
        z-index: 2;
        border-radius: 40px;
        overflow: hidden;
        box-shadow: 0 30px 60px rgba(0,0,0,0.12);
        background: linear-gradient(135deg, rgba(251, 126, 156, 0.1) 0%, rgba(36, 159, 253, 0.1) 100%);
        display: flex;
        align-items: flex-end;
        justify-content: center;
        aspect-ratio: 4/5;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .welcome-img-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: top;
        transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .excellence-card {
        background: #fff;
        padding: 20px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        height: 100%;
        transition: all 0.3s ease;
        border: 1px solid #f0f0f0;
        box-shadow: 0 5px 15px rgba(0,0,0,0.02);
    }

    .excellence-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.08);
        border-color: var(--primary);
    }

    .excellence-icon {
        width: 60px;
        height: 60px;
        min-width: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
    }

    .bg-pink-light { background: rgba(251, 126, 156, 0.1); color: var(--primary); }
    .bg-blue-light { background: rgba(36, 159, 253, 0.1); color: var(--secondary); }

    .excellence-content h6 {
        font-weight: 700;
        margin-bottom: 5px;
        color: #333;
    }

    .excellence-content p {
        margin: 0;
        font-size: 0.9rem;
        color: #777;
    }

    @media (max-width: 991px) {
        .welcome-section {
            padding: 80px 0 60px;
            text-align: center;
        }
        .section-subtitle {
            justify-content: center;
            margin-bottom: 20px;
        }
        .welcome-heading .line-1 {
            font-size: 2.2rem;
        }
        .welcome-heading .line-2 {
            font-size: 1.3rem;
        }
        .welcome-img-card {
            margin: 0 auto 20px;
            max-width: 280px;
            aspect-ratio: 1/1;
            border-radius: 30px;
        }
        .direct-line-card {
            margin-top: 15px;
            margin-bottom: 45px;
            padding: 18px;
        }
        .excellence-grid-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        .excellence-grid-item {
            width: 100% !important;
        }
        .excellence-card {
            flex-direction: column;
            text-align: center;
            padding: 20px 15px;
            gap: 12px;
            border-radius: 24px;
        }
        .excellence-icon {
            margin: 0 auto;
            width: 50px;
            height: 50px;
            font-size: 1.4rem;
        }
        .excellence-content h6 {
            font-size: 1rem;
            margin-bottom: 4px;
        }
        .excellence-content p {
            font-size: 0.8rem;
            line-height: 1.4;
        }
    }

    @media (max-width: 480px) {
        .excellence-grid-row {
            grid-template-columns: 1fr;
        }
        .excellence-card {
            flex-direction: row;
            text-align: left;
            padding: 15px;
        }
        .excellence-icon {
            margin: 0;
            width: 45px;
            height: 45px;
        }
    }

    @media (min-width: 992px) {
        .excellence-grid-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .excellence-grid-item {
            width: calc(50% - 10px);
        }
    }
    
    @media (min-width: 1200px) {
        .excellence-grid-item {
            width: calc(33.333% - 14px);
        }
    }

    /* Direct Line to Director Styles */
    .direct-line-card {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        padding: 20px 25px;
        border-radius: 25px;
        display: flex;
        align-items: center;
        gap: 20px;
        margin-top: 25px; /* Added top margin instead of bottom */
        color: white;
        box-shadow: 0 15px 35px rgba(251, 126, 156, 0.25);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        text-decoration: none !important;
        border: 1px solid rgba(255, 255, 255, 0.2);
        width: 100%;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }

    .direct-line-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 30px 60px rgba(30, 60, 114, 0.3);
        color: white;
    }

    .direct-line-icon {
        width: 70px;
        height: 70px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(5px);
        border-radius: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        position: relative;
    }

    .direct-line-icon::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 22px;
        border: 2px solid rgba(255, 255, 255, 0.5);
        animation: pulse-border 2s infinite;
    }

    @keyframes pulse-border {
        0% { transform: scale(1); opacity: 1; }
        100% { transform: scale(1.5); opacity: 0; }
    }

    .direct-line-content .direct-label {
        display: block;
        font-size: 0.95rem;
        font-weight: 500;
        opacity: 0.9;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .direct-line-content .direct-number {
        display: block;
        font-size: 1.8rem;
        font-weight: 800;
        margin: 0;
        letter-spacing: 1.5px;
        text-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    @media (max-width: 576px) {
        .direct-line-card {
            padding: 20px;
            gap: 15px;
            max-width: 100%;
        }
        .direct-line-icon {
            width: 55px;
            height: 55px;
            font-size: 1.6rem;
        }
        .direct-line-content .direct-number {
            font-size: 1.4rem;
        }
    }
</style>

<section class="welcome-section">
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center">
            <!-- Desktop Image Column -->
            <div class="col-lg-5 d-none d-lg-block wow fadeInLeft" data-wow-delay="0.2s">
                <div class="welcome-img-wrapper">
                    <div class="welcome-img-card">
                        <img src="<?= base_url('uploads/director/pa.png') ?>" alt="Director SKJ">
                    </div>
                    
                    <!-- Direct Line (Desktop) -->
                    <a href="tel:0989789705" class="direct-line-card wow fadeInUp" data-wow-delay="0.5s">
                        <div class="direct-line-icon">
                            <i class="bi bi-telephone-outbound-fill"></i>
                        </div>
                        <div class="direct-line-content">
                            <span class="direct-label">สายตรงถึงผู้บริหารสถานศึกษา</span>
                            <h3 class="direct-number">098-978-9705</h3>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Content Column -->
            <div class="col-lg-7 ps-lg-5 wow fadeInRight" data-wow-delay="0.4s">
                <span class="section-subtitle">Welcome To SKJ School</span>
                <h1 class="welcome-heading">
                    <span class="line-1">ยินดีต้อนรับสู่รั้ว<span class="text-pink"> ชมพู</span>-<span class="text-blue">ฟ้า</span></span>
                    <span class="line-2">สวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</span>
                </h1>
                <p class="mb-5 text-muted" style="font-size: 1.1rem; line-height: 1.8;">
                    สถาบันการศึกษาที่มุ่งเน้นการสร้าง "สุภาพบุรุษและสุภาพสตรีสวนกุหลาบ" ผู้มีคุณธรรม นำความรู้ และมีความเป็นเลิศในทุกด้านตามศักยภาพรายบุคคล
                </p>

                <!-- Responsive Wrapper for Image and Grid -->
                <div class="mobile-excellence-wrapper">
                    <!-- Mobile-only Image -->
                    <div class="mobile-img-col d-lg-none">
                        <div class="welcome-img-card">
                            <img src="<?= base_url('uploads/director/pa.png') ?>" alt="Director SKJ">
                        </div>

                        <!-- Direct Line (Mobile) -->
                        <a href="tel:0989789705" class="direct-line-card wow fadeInUp" data-wow-delay="0.5s" style="margin-bottom: 35px;">
                            <div class="direct-line-icon">
                                <i class="bi bi-telephone-outbound-fill"></i>
                            </div>
                            <div class="direct-line-content">
                                <span class="direct-label">สายตรงถึงผู้บริหารสถานศึกษา</span>
                                <h3 class="direct-number">098-978-9705</h3>
                            </div>
                        </a>
                    </div>

                    <!-- Excellence Grid -->
                    <div class="mobile-grid-col w-lg-100">
                        <div class="excellence-grid-row">
                            <div class="excellence-grid-item wow fadeInUp" data-wow-delay="0.1s">
                                <div class="excellence-card">
                                    <div class="excellence-icon bg-pink-light">
                                        <i class="bi bi-mortarboard-fill"></i>
                                    </div>
                                    <div class="excellence-content">
                                        <h6>วิชาการเข้ม</h6>
                                        <p>หลักสูตรทันสมัย สู่มหาวิทยาลัยชั้นนำ</p>
                                    </div>
                                </div>
                            </div>
                            <div class="excellence-grid-item wow fadeInUp" data-wow-delay="0.2s">
                                <div class="excellence-card">
                                    <div class="excellence-icon bg-blue-light">
                                        <i class="bi bi-trophy-fill"></i>
                                    </div>
                                    <div class="excellence-content">
                                        <h6>กีฬาเด่น</h6>
                                        <p>ศักยภาพสู่มืออาชีพ ทุกประเภทกีฬา</p>
                                    </div>
                                </div>
                            </div>
                            <div class="excellence-grid-item wow fadeInUp" data-wow-delay="0.3s">
                                <div class="excellence-card">
                                    <div class="excellence-icon bg-blue-light">
                                        <i class="bi bi-palette-fill"></i>
                                    </div>
                                    <div class="excellence-content">
                                        <h6>ศิลป์เด่น</h6>
                                        <p>ดนตรี นาฏศิลป์ สร้างสรรค์จินตนาการ</p>
                                    </div>
                                </div>
                            </div>
                            <div class="excellence-grid-item wow fadeInUp" data-wow-delay="0.4s">
                                <div class="excellence-card">
                                    <div class="excellence-icon bg-pink-light">
                                        <i class="bi bi-tools"></i>
                                    </div>
                                    <div class="excellence-content">
                                        <h6>ทักษะอาชีพ</h6>
                                        <p>ฝึกปฎิบัติจริง สร้างพื้นฐานอาชีพที่มั่นคง</p>
                                    </div>
                                </div>
                            </div>
                            <div class="excellence-grid-item wow fadeInUp" data-wow-delay="0.5s">
                                <div class="excellence-card">
                                    <div class="excellence-icon bg-blue-light">
                                        <i class="bi bi-translate"></i>
                                    </div>
                                    <div class="excellence-content">
                                        <h6>ภาษาเลิศ</h6>
                                        <p>อังกฤษ-จีน ก้าวสู่ระดับสากล</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
