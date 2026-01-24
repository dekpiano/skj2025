<style>
    .recommend-section {
        padding: 100px 0;
        background: linear-gradient(rgba(255, 255, 255, 0.92), rgba(255, 255, 255, 0.95)), url('<?= base_url('uploads/background/campus_view_16.jpg') ?>');
        background-attachment: fixed;
        background-position: center;
        background-size: cover;
        position: relative;
        overflow: hidden;
    }

    .recommend-header {
        max-width: 800px;
        margin: 0 auto 60px;
        text-align: center;
        position: relative;
        z-index: 1;
    }

    /* Category Specific Colors */
    .cat-smt { --accent: #249ffd; --accent-light: rgba(36, 159, 253, 0.1); }
    .cat-sport { --accent: #ff4757; --accent-light: rgba(255, 71, 87, 0.1); }
    .cat-art { --accent: #FB7E9C; --accent-light: rgba(251, 126, 156, 0.1); }
    .cat-career { --accent: #2ed573; --accent-light: rgba(46, 213, 115, 0.1); }
    .cat-lang { --accent: #ffa502; --accent-light: rgba(255, 165, 2, 0.1); }

    /* Custom Icon Tabs */
    .recommend-nav {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-bottom: 50px;
        border: none;
        flex-wrap: wrap;
        position: relative;
        z-index: 1;
    }

    .recommend-nav .nav-link {
        border: none !important;
        background: rgba(248, 250, 255, 0.8) !important;
        backdrop-filter: blur(10px);
        color: #6c7a91 !important;
        padding: 18px 25px !important;
        border-radius: 20px !important;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        min-width: 120px;
        border: 1px solid rgba(255, 255, 255, 0.5) !important;
    }

    .recommend-nav .nav-link i { font-size: 1.6rem; }
    .recommend-nav .nav-link span { font-weight: 700; font-size: 0.9rem; }

    .recommend-nav .nav-link:hover { transform: translateY(-3px); background: #fff !important; color: var(--accent) !important; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
    .recommend-nav .nav-link.active {
        background: #fff !important;
        color: var(--accent) !important;
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        transform: translateY(-5px);
        border-color: var(--accent) !important;
    }

    /* Premium Feature Card */
    .premium-feature-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(15px);
        border-radius: 40px;
        padding: 60px;
        box-shadow: 0 30px 60px rgba(0,0,0,0.05);
        border-top: 8px solid var(--accent);
        display: flex;
        align-items: center;
        gap: 50px;
        position: relative;
        border: 1px solid rgba(255, 255, 255, 0.4);
    }

    .feature-content { flex: 1; }

    .feature-tag {
        display: inline-block;
        padding: 6px 18px;
        background: var(--accent-light);
        color: var(--accent);
        border-radius: 50px;
        font-weight: 800;
        font-size: 0.85rem;
        margin-bottom: 20px;
    }

    .feature-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: #1a2a4d;
        margin-bottom: 15px;
    }

    .feature-desc {
        font-size: 1.2rem;
        color: #555;
        margin-bottom: 35px;
        line-height: 1.7;
    }

    .feature-checklist {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .check-item {
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 700;
        color: #333;
        font-size: 1rem;
    }

    .check-item i { color: var(--accent); font-size: 1.2rem; }

    /* Image Wrapper - VERY PROMINENT */
    .feature-img-wrapper {
        flex: 0 0 320px;
        text-align: center;
        position: relative;
    }

    .feature-img-wrapper::before {
        content: '';
        position: absolute;
        width: 120%;
        height: 120%;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: var(--accent-light);
        border-radius: 50%;
        filter: blur(40px);
        z-index: 0;
    }

    .feature-img-wrapper img {
        width: 100%;
        height: auto;
        position: relative;
        z-index: 1;
        filter: drop-shadow(0 20px 40px rgba(0,0,0,0.15));
        transition: transform 0.5s ease;
    }

    .tab-pane.active .feature-img-wrapper img {
        animation: float-img 6s infinite ease-in-out;
    }

    @keyframes float-img {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    @media (max-width: 991px) {
        .premium-feature-card { flex-direction: column-reverse; text-align: center; padding: 50px 30px; }
        .feature-img-wrapper { flex: 0 0 auto; width: 100%; max-width: 250px; margin-bottom: 30px; }
        .feature-title { font-size: 2rem; }
        .feature-checklist { grid-template-columns: 1fr; text-align: left; max-width: 320px; margin: 0 auto; }
        .recommend-nav .nav-link { min-width: calc(33.33% - 10px); padding: 15px !important; }
    }
</style>

<section class="recommend-section">
    <div class="container">
        <div class="recommend-header wow fadeInUp">
            <span class="section-subtitle">SKJ Excellence</span>
            <h1 class="display-6 mb-3" style="font-weight: 800; color: #1a2a4d;">เลือกสิ่งที่ใช่ เพื่ออนาคตที่ชอบ</h1>
            <p class="text-muted">พัฒนา 5 ด้านความเป็นเลิศ สู่ความสำเร็จที่ยั่งยืน</p>
        </div>

        <ul class="nav nav-tabs recommend-nav wow fadeInUp" role="tablist">
            <li class="nav-item">
                <a class="nav-link active cat-smt" data-bs-toggle="tab" data-bs-target="#tab-smt" role="tab">
                    <i class="bi bi-mortarboard-fill"></i><span>วิชาการเข้ม</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link cat-sport" data-bs-toggle="tab" data-bs-target="#tab-sp" role="tab">
                    <i class="bi bi-trophy-fill"></i><span>กีฬาเด่น</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link cat-art" data-bs-toggle="tab" data-bs-target="#tab-pap" role="tab">
                    <i class="bi bi-palette-fill"></i><span>ศิลป์ล้ำเลิศ</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link cat-career" data-bs-toggle="tab" data-bs-target="#tab-cp" role="tab">
                    <i class="bi bi-tools"></i><span>ทักษะอาชีพ</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link cat-lang" data-bs-toggle="tab" data-bs-target="#tab-cep" role="tab">
                    <i class="bi bi-translate"></i><span>ภาษาเลิศ</span>
                </a>
            </li>
        </ul>

        <div class="tab-content wow fadeInUp">
            <!-- วิชาการ -->
            <div class="tab-pane fade show active" id="tab-smt" role="tabpanel">
                <div class="premium-feature-card cat-smt">
                    <div class="feature-content">
                        <span class="feature-tag">หลักสูตร SMT</span>
                        <h3 class="feature-title">เป็นเลิศวิชาการและเทคโนโลยี</h3>
                        <p class="feature-desc">เน้นวิทยาศาสตร์และนวัตกรรม เพื่อก้าวสู่มหาวิทยาลัยชั้นนำ</p>
                        <div class="feature-checklist">
                            <div class="check-item"><i class="bi bi-check-lg"></i> <span>วิทย์-คณิต เข้มข้น</span></div>
                            <div class="check-item"><i class="bi bi-check-lg"></i> <span>เทคโนโลยีล้ำสมัย</span></div>
                            <div class="check-item"><i class="bi bi-check-lg"></i> <span>ห้องเรียนอัจฉริยะ</span></div>
                            <div class="check-item"><i class="bi bi-check-lg"></i> <span>ฝึกปฏิบัติเชิงวิจัย</span></div>
                        </div>
                    </div>
                    <div class="feature-img-wrapper">
                        <img src="<?= base_url() ?>/uploads/Excellent/science.svg" alt="Academic">
                    </div>
                </div>
            </div>

            <!-- กีฬา -->
            <div class="tab-pane fade" id="tab-sp" role="tabpanel">
                <div class="premium-feature-card cat-sport">
                    <div class="feature-content">
                        <span class="feature-tag">หลักสูตรกีฬา</span>
                        <h3 class="feature-title">ฝึกทักษะ สู่ระดับมืออาชีพ</h3>
                        <p class="feature-desc">พัฒนาสมรรถภาพทางกาย และส่งเสริมทุกประเภทกีฬา</p>
                        <div class="feature-checklist">
                            <div class="check-item"><i class="bi bi-check-lg"></i> <span>ฟุตบอล & ฟุตซอล</span></div>
                            <div class="check-item"><i class="bi bi-check-lg"></i> <span>วอลเลย์บอลคลินิก</span></div>
                            <div class="check-item"><i class="bi bi-check-lg"></i> <span>บาสเกตบอลชูตติ้ง</span></div>
                            <div class="check-item"><i class="bi bi-check-lg"></i> <span>กรีฑาสู่ความเป็นเลิศ</span></div>
                        </div>
                    </div>
                    <div class="feature-img-wrapper">
                        <img src="<?= base_url() ?>/uploads/Excellent/sport.svg" alt="Sports">
                    </div>
                </div>
            </div>

            <!-- ศิลปะ -->
            <div class="tab-pane fade" id="tab-pap" role="tabpanel">
                <div class="premium-feature-card cat-art">
                    <div class="feature-content">
                        <span class="feature-tag">หลักสูตรศิลปะ</span>
                        <h3 class="feature-title">สร้างสรรค์ศิลปะและการแสดง</h3>
                        <p class="feature-desc">ปูพื้นฐานดนตรีและนาฏศิลป์ สู่เวทีระดับนานาชาติ</p>
                        <div class="feature-checklist">
                            <div class="check-item"><i class="bi bi-check-lg"></i> <span>ดนตรีไทย-สากล</span></div>
                            <div class="check-item"><i class="bi bi-check-lg"></i> <span>นาฏศิลป์ประยุกต์</span></div>
                            <div class="check-item"><i class="bi bi-check-lg"></i> <span>การออกแบบสมัยใหม่</span></div>
                            <div class="check-item"><i class="bi bi-check-lg"></i> <span>การแสดงและขับร้อง</span></div>
                        </div>
                    </div>
                    <div class="feature-img-wrapper">
                        <img src="<?= base_url() ?>/uploads/Excellent/music.svg" alt="Arts">
                    </div>
                </div>
            </div>

            <!-- วิชาชีพ -->
            <div class="tab-pane fade" id="tab-cp" role="tabpanel">
                <div class="premium-feature-card cat-career">
                    <div class="feature-content">
                        <span class="feature-tag">หลักสูตรวิชาชีพ</span>
                        <h3 class="feature-title">ฝึกจริง ทำจริง พร้อมทำงาน</h3>
                        <p class="feature-desc">เรียนรู้งานจากประสบการณ์ตรง ตอบโจทย์ตลาดแรงงาน</p>
                        <div class="feature-checklist">
                            <div class="check-item"><i class="bi bi-check-lg"></i> <span>การโรงแรมมืออาชีพ</span></div>
                            <div class="check-item"><i class="bi bi-check-lg"></i> <span>คหกรรมและการอาหาร</span></div>
                            <div class="check-item"><i class="bi bi-check-lg"></i> <span>ธุรกิจและการค้า</span></div>
                            <div class="check-item"><i class="bi bi-check-lg"></i> <span>ทักษะงานช่างพื้นฐาน</span></div>
                        </div>
                    </div>
                    <div class="feature-img-wrapper">
                        <img src="<?= base_url() ?>/uploads/Excellent/career.svg" alt="Vocational">
                    </div>
                </div>
            </div>

            <!-- ภาษา -->
            <div class="tab-pane fade" id="tab-cep" role="tabpanel">
                <div class="premium-feature-card cat-lang">
                    <div class="feature-content">
                        <span class="feature-tag">หลักสูตรภาษา</span>
                        <h3 class="feature-title">เก่งภาษา ก้าวสู่สากล</h3>
                        <p class="feature-desc">เรียนกับเจ้าของภาษาโดยตรง สื่อสารคล่องทั้งอังกฤษ-จีน</p>
                        <div class="feature-checklist">
                            <div class="check-item"><i class="bi bi-check-lg"></i> <span>ภาษาอังกฤษเพื่อการสื่อสาร</span></div>
                            <div class="check-item"><i class="bi bi-check-lg"></i> <span>ภาษาจีนเน้นความเข้าใจ</span></div>
                            <div class="check-item"><i class="bi bi-check-lg"></i> <span>ค่ายแลกเปลี่ยนวัฒนธรรม</span></div>
                            <div class="check-item"><i class="bi bi-check-lg"></i> <span>ทุนเรียนต่อต่างประเทศ</span></div>
                        </div>
                    </div>
                    <div class="feature-img-wrapper">
                        <img src="<?= base_url() ?>/uploads/Excellent/language.svg" alt="Languages">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
