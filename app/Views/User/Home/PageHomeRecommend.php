<style>
    .recommend-section {
        padding: 80px 0;
        background: linear-gradient(135deg, rgba(36, 159, 253, 0.02) 0%, rgba(36, 159, 253, 0.08) 100%);
    }

    .recommend-tabs {
        border-bottom: none;
        justify-content: center;
        gap: 15px;
        margin-bottom: 50px;
    }

    .recommend-tabs .nav-link {
        border: 2px solid #eee !important;
        background: #fff !important;
        border-radius: 50px !important;
        padding: 12px 25px !important;
        color: #666 !important;
        font-weight: 700;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .recommend-tabs .nav-link.active {
        background: #249ffd !important;
        border-color: #249ffd !important;
        color: #fff !important;
        box-shadow: 0 10px 20px rgba(36, 159, 253, 0.3);
    }

    .recommend-tabs .nav-link:hover:not(.active) {
        border-color: #FB7E9C !important;
        color: #FB7E9C !important;
    }

    .recommend-card {
        background: #fff;
        border-radius: 40px;
        padding: 50px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.05);
        border: 1px solid rgba(0,0,0,0.02);
    }

    .recommend-title {
        font-size: 2rem;
        font-weight: 800;
        color: #1a2a4d;
        margin-bottom: 25px;
        position: relative;
        padding-left: 20px;
    }

    .recommend-title::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 6px;
        background: #FB7E9C;
        border-radius: 10px;
    }

    .recommend-desc {
        font-size: 1.1rem;
        color: #666;
        line-height: 1.8;
        margin-bottom: 30px;
    }

    .recommend-list {
        list-style: none;
        padding: 0;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .recommend-list li {
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 600;
        color: #444;
    }

    .recommend-list li i {
        color: #249ffd;
        font-size: 1.25rem;
    }

    .recommend-img {
        max-width: 100%;
        height: auto;
        transition: transform 0.5s ease;
    }

    .tab-pane.active .recommend-img {
        animation: float-img 6s infinite ease-in-out;
    }

    @keyframes float-img {
        0%, 100% { transform: translateY(0) rotate(0); }
        50% { transform: translateY(-15px) rotate(2deg); }
    }

    @media (max-width: 991px) {
        .recommend-card { padding: 30px; border-radius: 30px; }
        .recommend-title { font-size: 1.5rem; }
        .recommend-list { grid-template-columns: 1fr; }
        .recommend-tabs { gap: 8px; }
        .recommend-tabs .nav-link { padding: 8px 18px !important; font-size: 0.9rem; }
    }
</style>

<section class="recommend-section">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 700px;">
            <h6 class="section-title bg-white text-center px-3" style="color: #249ffd;">SKJ Excellence</h6>
            <h1 class="display-6 mb-4" style="font-weight: 800; color: #1a2a4d;">คัดสรรสิ่งที่ดีที่สุดเพื่ออนาคตของนักเรียน</h1>
        </div>

        <ul class="nav nav-tabs recommend-tabs wow fadeInUp" data-wow-delay="0.2s" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-smt" role="tab">วิชาการ SMT</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-sp" role="tab">กีฬา (SP)</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-pap" role="tab">ศิลปะ-การแสดง</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-cp" role="tab">วิชาชีพ (CP)</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-cep" role="tab">ภาษา (CEP)</a>
            </li>
        </ul>

        <div class="tab-content wow fadeInUp" data-wow-delay="0.3s">
            <!-- วิชาการ -->
            <div class="tab-pane fade show active" id="tab-smt" role="tabpanel">
                <div class="recommend-card">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <h3 class="recommend-title">ด้านวิชาการ SMT(S) , SMT(T)</h3>
                            <p class="recommend-desc">มุ่งเน้นการส่งเสริมศักยภาพของนักเรียนที่มีความสามารถพิเศษทางด้านคณิตศาสตร์ วิทยาศาสตร์ และเทคโนโลยี เพื่อความเป็นเลิศในระดับสากล</p>
                            <ul class="recommend-list">
                                <li><i class="bi bi-check-circle-fill"></i> แผนการเรียนวิทย์ - คณิต</li>
                                <li><i class="bi bi-check-circle-fill"></i> แผนการเรียนเทคโนโลยี</li>
                                <li><i class="bi bi-check-circle-fill"></i> ห้องเรียนอัจฉริยะ</li>
                                <li><i class="bi bi-check-circle-fill"></i> หลักสูตรเน้นการทดลอง</li>
                            </ul>
                        </div>
                        <div class="col-lg-6 text-center">
                            <img src="<?= base_url() ?>/uploads/Excellent/science.svg" class="recommend-img" alt="Academic">
                        </div>
                    </div>
                </div>
            </div>

            <!-- กีฬา -->
            <div class="tab-pane fade" id="tab-sp" role="tabpanel">
                <div class="recommend-card">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <h3 class="recommend-title">ด้านกีฬา (SP)</h3>
                            <p class="recommend-desc">เน้นการพัฒนาทักษะและความสามารถด้านกีฬาอย่างเป็นระบบ พร้อมส่งเสริมสุขภาพพลานามัยที่ดีสู่การเป็นนักกึ่งอาชีพและอาชีพ</p>
                            <ul class="recommend-list">
                                <li><i class="bi bi-check-circle-fill"></i> ฟุตบอล & ฟุตซอล</li>
                                <li><i class="bi bi-check-circle-fill"></i> วอลเลย์บอล</li>
                                <li><i class="bi bi-check-circle-fill"></i> บาสเกตบอล</li>
                                <li><i class="bi bi-check-circle-fill"></i> ตะกร้อ & กรีฑา</li>
                            </ul>
                        </div>
                        <div class="col-lg-6 text-center">
                            <img src="<?= base_url() ?>/uploads/Excellent/sport.svg" class="recommend-img" alt="Sports">
                        </div>
                    </div>
                </div>
            </div>

            <!-- ศิลปะ -->
            <div class="tab-pane fade" id="tab-pap" role="tabpanel">
                <div class="recommend-card">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <h3 class="recommend-title">ด้านศิลปะ-การแสดง (PAP)</h3>
                            <p class="recommend-desc">พัฒนารูปแบบการแสดงที่ครบวงจร ตั้งแต่ทฤษฎีจนถึงการปฏิบัติจริงในเวทีระดับประเทศ</p>
                            <ul class="recommend-list">
                                <li><i class="bi bi-check-circle-fill"></i> ดนตรีไทย & สากล</li>
                                <li><i class="bi bi-check-circle-fill"></i> นาฏศิลป์ไทย</li>
                                <li><i class="bi bi-check-circle-fill"></i> ศิลปะและการออกแบบ</li>
                                <li><i class="bi bi-check-circle-fill"></i> การขับร้อง</li>
                            </ul>
                        </div>
                        <div class="col-lg-6 text-center">
                            <img src="<?= base_url() ?>/uploads/Excellent/music.svg" class="recommend-img" alt="Arts">
                        </div>
                    </div>
                </div>
            </div>

            <!-- วิชาชีพ -->
            <div class="tab-pane fade" id="tab-cp" role="tabpanel">
                <div class="recommend-card">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <h3 class="recommend-title">ด้านวิชาชีพ (CP)</h3>
                            <p class="recommend-desc">สร้างทักษะอาชีพที่พร้อมทำงานจริง ตอบโจทย์ความต้องการของตลาดงานในปัจจุบัน</p>
                            <ul class="recommend-list">
                                <li><i class="bi bi-check-circle-fill"></i> การโรงแรม</li>
                                <li><i class="bi bi-check-circle-fill"></i> การอาหาร & คหกรรม</li>
                                <li><i class="bi bi-check-circle-fill"></i> ธุรกิจและการประกอบการ</li>
                                <li><i class="bi bi-check-circle-fill"></i> ทักษะงานช่างพื้นฐาน</li>
                            </ul>
                        </div>
                        <div class="col-lg-6 text-center">
                            <img src="<?= base_url() ?>/uploads/Excellent/career.svg" class="recommend-img" alt="Vocational">
                        </div>
                    </div>
                </div>
            </div>

            <!-- ภาษา -->
            <div class="tab-pane fade" id="tab-cep" role="tabpanel">
                <div class="recommend-card">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <h3 class="recommend-title">ด้านภาษา (CEP)</h3>
                            <p class="recommend-desc">พัฒนาทักษะการสื่อสารภาษาต่างประเทศ เพื่อก้าวสู่อนาคตในสังคมโลกอย่างไร้พรมแดน</p>
                            <ul class="recommend-list">
                                <li><i class="bi bi-check-circle-fill"></i> ภาษาอังกฤษเข้มข้น</li>
                                <li><i class="bi bi-check-circle-fill"></i> ภาษาจีนสื่อสาร</li>
                                <li><i class="bi bi-check-circle-fill"></i> เจ้าของภาษาโดยตรง</li>
                                <li><i class="bi bi-check-circle-fill"></i> แลกเปลี่ยนวัฒนธรรม</li>
                            </ul>
                        </div>
                        <div class="col-lg-6 text-center">
                            <img src="<?= base_url() ?>/uploads/Excellent/language.svg" class="recommend-img" alt="Languages">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
