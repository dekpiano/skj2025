<style>
    .welcome-section {
        padding: 100px 0;
        background-color: #fff;
        position: relative;
    }

    .welcome-img-wrapper {
        position: relative;
    }

    .welcome-img-card {
        position: relative;
        z-index: 2;
        border-radius: 30px;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        background: linear-gradient(135deg, rgba(251, 126, 156, 0.2) 0%, rgba(36, 159, 253, 0.2) 100%);
        display: flex;
        align-items: flex-end;
        justify-content: center;
        aspect-ratio: 4/5;
    }

    .welcome-img-card img {
        width: 100%;
        height: auto;
        object-fit: contain;
        transition: transform 0.5s ease;
    }

    .welcome-img-card:hover img {
        transform: scale(1.05);
    }

    .welcome-feature-item {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
        transition: all 0.3s ease;
    }

    .welcome-feature-item:hover {
        transform: translateX(10px);
    }

    .welcome-feature-icon {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .icon-pink { background: rgba(251, 126, 156, 0.1); color: var(--primary); }
    .icon-blue { background: rgba(36, 159, 253, 0.1); color: var(--secondary); }

    .welcome-feature-content h5 {
        font-weight: 800;
        color: #1a2a4d;
        margin-bottom: 8px;
    }

    .welcome-feature-content p {
        color: #666;
        margin: 0;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    @media (max-width: 991px) {
        .welcome-section { padding: 60px 0; }
        .welcome-img-wrapper { margin-bottom: 50px; padding-right: 0; }
        .welcome-badge { bottom: 20px; right: 20px; padding: 15px 20px; }
        .welcome-badge h2 { font-size: 1.8rem; }
    }
</style>

<section class="welcome-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 wow fadeInLeft" data-wow-delay="0.2s">
                <div class="welcome-img-wrapper">
                    <div class="welcome-img-card">
                        <img src="<?= base_url('uploads/director/pa.png') ?>" alt="Director SKJ">
                    </div>
                </div>
            </div>
            <div class="col-lg-7 ps-lg-5 wow fadeInRight" data-wow-delay="0.4s">
                <span class="section-subtitle">Welcome To SKJ School</span>
                <h1 class="display-5 mb-4" style="font-weight: 800; color: #1a2a4d;">ยินดีต้อนรับสู่รั้วชมพู-ฟ้า สวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</h1>
                <p class="mb-5 text-muted" style="font-size: 1.1rem; line-height: 1.8;">
                    สถาบันการศึกษาที่มุ่งเน้นการสร้าง "สุภาพบุรุษและสุภาพสตรีสวนกุหลาบ" ผู้มีคุณธรรม นำความรู้ และมีความเป็นเลิศในทุกด้านตามศักยภาพรายบุคคล ภายใต้สภาพแวดล้อมที่เอื้อต่อการเรียนรู้และเทคโนโลยีที่ทันสมัย
                </p>

                <div class="row">
                    <div class="col-md-6">
                        <div class="welcome-feature-item">
                            <div class="welcome-feature-icon icon-pink">
                                <i class="bi bi-mortarboard-fill"></i>
                            </div>
                            <div class="welcome-feature-content">
                                <h5>วิชาการเข้มแข็ง</h5>
                                <p>มุ่งเน้นความเป็นเลิศทางวิชาการและนวัตกรรมใหม่ๆ</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="welcome-feature-item">
                            <div class="welcome-feature-icon icon-blue">
                                <i class="bi bi-trophy-fill"></i>
                            </div>
                            <div class="welcome-feature-content">
                                <h5>กีฬาโดดเด่น</h5>
                                <p>สนับสนุนทุกศักยภาพด้านกีฬาด้วยโค้ชมืออาชีพ</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="welcome-feature-item">
                            <div class="welcome-feature-icon icon-blue">
                                <i class="bi bi-palette-fill"></i>
                            </div>
                            <div class="welcome-feature-content">
                                <h5>ศิลปะและการแสดง</h5>
                                <p>ส่งเสริมสุนทรียภาพและความกล้าแสดงออก</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="welcome-feature-item">
                            <div class="welcome-feature-icon icon-pink">
                                <i class="bi bi-heart-fill"></i>
                            </div>
                            <div class="welcome-feature-content">
                                <h5>คุณธรรมนำใจ</h5>
                                <p>บ่มเพาะความเป็นสวนกุหลาบผ่านคุณธรรมนับถือพี่เคารพครู</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
