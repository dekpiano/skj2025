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
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .bg-pink-light { background: rgba(251, 126, 156, 0.1); color: var(--primary); }
    .bg-blue-light { background: rgba(36, 159, 253, 0.1); color: var(--secondary); }

    .excellence-content h6 {
        font-weight: 800;
        color: #1a2a4d;
        margin-bottom: 4px;
        font-size: 1.05rem;
    }

    .excellence-content p {
        color: #777;
        margin: 0;
        font-size: 0.85rem;
        line-height: 1.4;
    }

    @media (max-width: 991px) {
        .welcome-section { padding: 40px 0; }
        .welcome-heading { margin-bottom: 1.5rem; }
        
        .mobile-excellence-wrapper {
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }
        
        .mobile-img-col {
            flex: 0 0 40%;
            max-width: 40%;
        }
        
        .mobile-grid-col {
            flex: 0 0 60%;
            max-width: 60%;
        }

        .welcome-img-card {
            border-radius: 25px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .excellence-grid-row {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .excellence-card {
            padding: 12px;
            gap: 10px;
            border-radius: 15px;
        }

        .excellence-icon {
            width: 35px;
            height: 35px;
            font-size: 1rem;
            border-radius: 8px;
        }

        .excellence-content h6 {
            font-size: 0.9rem;
            margin-bottom: 0;
        }

        .excellence-content p {
            display: none;
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
