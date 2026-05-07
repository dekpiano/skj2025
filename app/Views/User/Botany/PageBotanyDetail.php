<style>
    .botany-detail-container {
        background-color: #f8faf8;
        padding: 80px 0;
        min-height: 100vh;
    }

    .back-btn {
        margin-bottom: 30px;
        display: inline-block;
        color: #fb7e9c;
        text-decoration: none;
        font-weight: 600;
        transition: transform 0.2s ease;
    }

    .back-btn:hover {
        transform: translateX(-5px);
        color: #249ffd;
    }

    .plant-profile-card {
        background: white;
        border-radius: 30px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.05);
        border: 1px solid rgba(0,0,0,0.02);
    }

    .plant-hero-img {
        width: 100%;
        height: 450px;
        object-fit: cover;
    }

    .plant-main-content {
        padding: 50px;
    }

    .plant-title-section {
        margin-bottom: 40px;
        border-bottom: 1px solid #eee;
        padding-bottom: 30px;
    }

    .plant-title-th {
        font-size: 3rem;
        font-weight: 800;
        color: #252525;
        margin-bottom: 5px;
    }

    .plant-title-en {
        font-size: 1.5rem;
        font-style: italic;
        color: #fb7e9c;
        margin-bottom: 20px;
        display: block;
    }

    .plant-meta-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .meta-item {
        background: #fff0f3;
        padding: 20px;
        border-radius: 20px;
        border-left: 5px solid #fb7e9c;
    }

    .meta-label {
        font-size: 0.8rem;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: block;
        margin-bottom: 5px;
    }

    .meta-value {
        font-weight: 700;
        color: #252525;
        font-size: 1.1rem;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #fb7e9c;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
    }

    .section-title i {
        margin-right: 15px;
        color: #249ffd;
    }

    .content-text {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #444;
        margin-bottom: 40px;
        white-space: pre-line;
    }

    .qr-section {
        background: linear-gradient(135deg, #fb7e9c, #249ffd);
        color: white;
        padding: 40px;
        border-radius: 25px;
        margin-top: 40px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .qr-text h4 {
        font-weight: 700;
        margin-bottom: 10px;
    }

    .qr-code-placeholder {
        width: 120px;
        height: 120px;
        background: white;
        padding: 10px;
        border-radius: 15px;
    }

    @media (max-width: 991px) {
        .plant-hero-img { height: 300px; }
        .plant-main-content { padding: 30px; }
        .plant-title-th { font-size: 2.2rem; }
        .qr-section { flex-direction: column; text-align: center; }
        .qr-code-placeholder { margin-top: 20px; }
    }

    @media (max-width: 768px) {
        .botany-detail-container { padding: 40px 0; }
        .plant-title-th { font-size: 1.8rem; }
        .plant-title-en { font-size: 1.1rem; }
        .plant-main-content { padding: 25px; }
        .plant-hero-img { height: 250px; }
        .meta-item { padding: 15px; }
        .content-text { font-size: 1rem; }
        .section-title { font-size: 1.3rem; }
    }
</style>

<div class="botany-detail-container">
    <div class="container">
        <a href="<?= base_url('Botany/Plants') ?>" class="back-btn">
            <i class="bi bi-arrow-left me-2"></i>กลับสู่คลังข้อมูลพรรณไม้
        </a>

        <div class="plant-profile-card animate__animated animate__fadeIn">
            <img src="<?= base_url('uploads/botany/' . ($plant->botany_image ?: 'default-plant.jpg')) ?>" 
                 class="plant-hero-img" alt="<?= $plant->botany_name_th ?>"
                 onerror="this.src='https://images.unsplash.com/photo-1545239351-ef056c0b011a?q=80&w=1200&auto=format&fit=crop'">
            
            <div class="plant-main-content">
                <div class="plant-title-section">
                    <h1 class="plant-title-th"><?= $plant->botany_name_th ?></h1>
                    <span class="plant-title-en"><?= $plant->botany_name_en ?></span>
                    <div class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill" style="color: #fb7e9c !important; background-color: rgba(251,126,156,0.1) !important;">
                        <?= $plant->botany_type ?>
                    </div>
                </div>

                <div class="plant-meta-grid">
                    <div class="meta-item">
                        <span class="meta-label">ชื่อวิทยาศาสตร์</span>
                        <span class="meta-value"><i><?= $plant->botany_science_name ?: '-' ?></i></span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">วงศ์ (Family)</span>
                        <span class="meta-value"><?= $plant->botany_family ?: '-' ?></span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">สถานที่ตั้ง</span>
                        <span class="meta-value"><?= $plant->botany_location ?: 'ในโรงเรียน' ?></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="section-title">
                            <i class="bi bi-card-text"></i>ลักษณะทางพฤกษศาสตร์
                        </div>
                        <div class="content-text">
                            <?= $plant->botany_description ?: 'ยังไม่มีข้อมูลลักษณะทางพฤกษศาสตร์' ?>
                        </div>

                        <div class="section-title">
                            <i class="bi bi-stars"></i>สรรพคุณ / ประโยชน์
                        </div>
                        <div class="content-text">
                            <?= $plant->botany_benefit ?: 'ยังไม่มีข้อมูลสรรพคุณหรือประโยชน์' ?>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="qr-section">
                            <div class="qr-text">
                                <h4>สแกนข้อมูล</h4>
                                <p class="mb-0 small">ใช้สำหรับดูข้อมูลออนไลน์<br>ผ่านสมาร์ทโฟน</p>
                            </div>
                            <div class="qr-code-placeholder">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?= current_url() ?>" alt="QR Code" class="img-fluid">
                            </div>
                        </div>

                        <div class="mt-4 p-4 rounded-4 bg-light border border-dashed border-primary text-center" style="border-color: #fb7e9c !important;">
                            <i class="bi bi-journal-check fs-1 text-primary opacity-50" style="color: #fb7e9c !important;"></i>
                            <h5 class="mt-3 fw-bold">ข้อมูลพฤกษศาสตร์</h5>
                            <p class="small text-muted">จัดทำโดย งานสวนพฤกษศาสตร์โรงเรียน<br>โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
