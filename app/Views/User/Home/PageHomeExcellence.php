<style>
    .excellence-section {
        padding: 80px 0;
        background: linear-gradient(135deg, #fff5f7 0%, #fff 100%);
        position: relative;
    }

    .excellence-card {
        background: #fff;
        border-radius: 30px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: all 0.4s ease;
        height: 100%;
        border: 1px solid rgba(0,0,0,0.03);
        display: flex;
        flex-direction: column;
    }

    .excellence-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }

    .excellence-img-wrapper {
        position: relative;
        height: 240px;
        overflow: hidden;
    }

    .excellence-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .excellence-card:hover .excellence-img-wrapper img {
        transform: scale(1.1);
    }

    .excellence-badge {
        position: absolute;
        top: 20px;
        left: 20px;
        padding: 6px 15px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        z-index: 2;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .excellence-card.blue .excellence-badge { background: #249ffd; color: #fff; }
    .excellence-card.pink .excellence-badge { background: #FB7E9C; color: #fff; }

    .excellence-content {
        padding: 30px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .excellence-title {
        font-size: 1.4rem;
        font-weight: 800;
        color: #1a2a4d;
        margin-bottom: 15px;
        line-height: 1.3;
    }

    .excellence-desc {
        font-size: 0.95rem;
        color: #666;
        line-height: 1.6;
        margin-bottom: 20px;
        flex-grow: 1;
    }

    .excellence-footer {
        padding-top: 20px;
        border-top: 1px dashed #eee;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .excellence-btn {
        font-size: 0.9rem;
        font-weight: 700;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: gap 0.3s ease;
    }

    .excellence-card.blue .excellence-btn { color: #249ffd; }
    .excellence-card.pink .excellence-btn { color: #FB7E9C; }

    .excellence-btn:hover {
        gap: 12px;
    }

    .excellence-card.blue { border-bottom: 5px solid #249ffd; }
    .excellence-card.pink { border-bottom: 5px solid #FB7E9C; }

    @media (max-width: 991px) {
        .excellence-img-wrapper { height: 200px; }
        .excellence-title { font-size: 1.2rem; }
    }
</style>

<div class="excellence-section">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 700px;">
            <h6 class="section-title px-3" style="color: #FB7E9C; background: rgba(255, 255, 255, 0.5); backdrop-filter: blur(5px);">หลักสูตรที่เปิดสอน</h6>
            <h1 class="display-6 mb-4" style="font-weight: 800; color: #1a2a4d;">หลักสูตรพัฒนาผู้เรียนสู่ความเป็นเลิศ</h1>
            <p class="text-muted">มุ่งเน้นการพัฒนา เพื่อส่งเสริมศักยภาพของนักเรียนตามความถนัดและความสนใจ</p>
        </div>

        <div class="row g-4">
            <!-- วิชาการ -->
            <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                <div class="excellence-card blue">
                    <div class="excellence-img-wrapper">
                        <span class="excellence-badge">Academic</span>
                        <img class="lazyload" data-src="<?= base_url() ?>/uploads/Excellence/sci.jpg" alt="วิชาการ">
                    </div>
                    <div class="excellence-content">
                        <h3 class="excellence-title">ความเป็นเลิศทางด้านวิชาการ</h3>
                        <p class="excellence-desc">มุ่งเน้นการส่งเสริมศักยภาพของนักเรียนที่มีความสามารถพิเศษทางด้านคณิตศาสตร์ วิทยาศาสตร์และเทคโนโลยี</p>
                        <div class="excellence-footer">
                            <span class="excellence-btn">ดูรายละเอียด <i class="bi bi-arrow-right"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- กีฬา -->
            <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.2s">
                <div class="excellence-card pink">
                    <div class="excellence-img-wrapper">
                        <span class="excellence-badge">Sports</span>
                        <img class="lazyload" data-src="<?= base_url() ?>/uploads/Excellence/sport.jpg" alt="กีฬา">
                    </div>
                    <div class="excellence-content">
                        <h3 class="excellence-title">ความเป็นเลิศทางด้านกีฬา</h3>
                        <p class="excellence-desc">มุ่งเน้นการพัฒนาทักษะ ความสามารถด้านกีฬา เช่น ฟุตบอล วอลเลย์บอล แบดมินตัน และกีฬาอื่นๆ สำคัญ</p>
                        <div class="excellence-footer">
                            <span class="excellence-btn">ดูรายละเอียด <i class="bi bi-arrow-right"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ศิลปะ -->
            <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                <div class="excellence-card blue">
                    <div class="excellence-img-wrapper">
                        <span class="excellence-badge">Arts & Music</span>
                        <img class="lazyload" data-src="<?= base_url() ?>/uploads/Excellence/art.JPG" alt="ศิลปะ">
                    </div>
                    <div class="excellence-content">
                        <h3 class="excellence-title">ความเป็นเลิศทางด้านศิลปะ ดนตรี</h3>
                        <p class="excellence-desc">พัฒนารูปแบบการแสดง เช่น ดนตรีไทย ดนตรีสากล การขับร้อง ศิลปะการแสดง และวิจิตรศิลป์</p>
                        <div class="excellence-footer">
                            <span class="excellence-btn">ดูรายละเอียด <i class="bi bi-arrow-right"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- วิชาชีพ -->
            <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.4s">
                <div class="excellence-card pink">
                    <div class="excellence-img-wrapper">
                        <span class="excellence-badge">Vocational</span>
                        <img class="lazyload" data-src="<?= base_url() ?>/uploads/Excellence/cree.jpg" alt="วิชาชีพ">
                    </div>
                    <div class="excellence-content">
                        <h3 class="excellence-title">ความเป็นเลิศทางด้านวิชาชีพ</h3>
                        <p class="excellence-desc">มุ่งเน้นการพัฒนาทักษะในการประกอบอาชีพ ได้แก่ การโรงแรม การอาหารคหกรรม ธุรกิจและการประกอบการ</p>
                        <div class="excellence-footer">
                            <span class="excellence-btn">ดูรายละเอียด <i class="bi bi-arrow-right"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ภาษา -->
            <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                <div class="excellence-card blue">
                    <div class="excellence-img-wrapper">
                        <span class="excellence-badge">Languages</span>
                        <img class="lazyload" data-src="<?= base_url() ?>/uploads/Excellence/lang.jpg" alt="ภาษา">
                    </div>
                    <div class="excellence-content">
                        <h3 class="excellence-title">ความเป็นเลิศทางด้านภาษา</h3>
                        <p class="excellence-desc">ส่งเสริมศักยภาพของนักเรียนที่มีความสามารถพิเศษทางด้านภาษาต่างประเทศ เช่น ภาษาอังกฤษ และภาษาจีน</p>
                        <div class="excellence-footer">
                            <span class="excellence-btn">ดูรายละเอียด <i class="bi bi-arrow-right"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>