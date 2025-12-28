<style>
    .email-header {
        position: relative;
        padding: 120px 0 100px;
        background: linear-gradient(rgba(26, 42, 77, 0.8), rgba(26, 42, 77, 0.8)), 
                    url(<?= base_url('uploads/background/bg-contact.jpg') ?>) center center no-repeat;
        background-size: cover;
        border-radius: 0 0 60px 60px;
        text-align: center;
        margin-bottom: 50px;
    }

    .email-header h1 {
        font-weight: 900;
        letter-spacing: 1px;
        font-size: 3.5rem;
        margin-bottom: 15px;
        color: #fff;
    }

    .email-benefit-card {
        background: #fff;
        border-radius: 30px;
        padding: 40px;
        box-shadow: 0 15px 45px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.02);
        transition: all 0.4s ease;
        text-align: center;
        height: 100%;
    }

    .email-benefit-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 50px rgba(36, 159, 253, 0.15);
        border-color: rgba(36, 159, 253, 0.2);
    }

    .benefit-icon {
        width: 80px;
        height: 80px;
        background: rgba(36, 159, 253, 0.1);
        color: #249ffd;
        border-radius: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        margin: 0 auto 30px;
        transition: all 0.3s ease;
    }

    .email-benefit-card:hover .benefit-icon {
        background: #249ffd;
        color: #fff;
        transform: scale(1.1);
    }

    .benefit-title {
        font-weight: 800;
        color: #1a2a4d;
        margin-bottom: 20px;
        font-size: 1.4rem;
    }

    .benefit-desc {
        color: #666;
        line-height: 1.7;
        font-size: 1rem;
    }

    .request-section {
        background: linear-gradient(135deg, #1a2a4d 0%, #249ffd 100%);
        border-radius: 40px;
        padding: 80px 40px;
        color: #fff;
        position: relative;
        overflow: hidden;
        margin-top: 50px;
    }

    .request-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .info-box-email {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 25px;
        padding: 30px;
        margin-top: 30px;
    }

    .info-item-email {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 20px;
    }

    .info-item-email:last-child {
        margin-bottom: 0;
    }

    .info-item-email i {
        font-size: 1.5rem;
        color: #ff69b4;
    }

    @media (max-width: 767px) {
        .email-header {
            padding: 80px 20px;
            border-radius: 0 0 40px 40px;
        }
        .email-header h1 {
            font-size: 2.2rem;
        }
        .request-section {
            padding: 50px 25px;
            border-radius: 30px;
        }
    }
</style>

<div class="email-header wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <h1 class="display-4 slideInDown mb-3">Google Workspace for Education</h1>
        <p class="text-white-50 fs-5 mb-0">เปิดโลกแห่งการเรียนรู้ที่ไร้ขีดจำกัดด้วยอีเมล @skj.ac.th</p>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0 mt-4">
                <li class="breadcrumb-item"><a class="text-white-50" href="<?= base_url('/') ?>">หน้าแรก</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">อีเมลโรงเรียน</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 700px;">
            <h6 class="section-title bg-white text-center text-primary px-3 mb-4">สิทธิประโยชน์</h6>
            <h2 class="display-6 mb-4">ทำไมต้องใช้อีเมลโรงเรียน?</h2>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.2s">
                <div class="email-benefit-card">
                    <div class="benefit-icon">
                        <i class="bi bi-cloud-check-fill"></i>
                    </div>
                    <h4 class="benefit-title">พื้นที่เก็บข้อมูลไม่จำกัด</h4>
                    <p class="benefit-desc">จัดเก็บไฟล์งาน การบ้าน และสื่อการสอนต่างๆ บน Google Drive ได้พื้นที่มากกว่าอีเมลทั่วไป</p>
                </div>
            </div>

            <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                <div class="email-benefit-card">
                    <div class="benefit-icon">
                        <i class="bi bi-laptop-fill"></i>
                    </div>
                    <h4 class="benefit-title">Google Classroom</h4>
                    <p class="benefit-desc">เข้าถึงห้องเรียนออนไลน์ ส่งงาน และรับเอกสารประกอบการเรียนได้ง่ายเพียงปลายนิ้ว</p>
                </div>
            </div>

            <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.4s">
                <div class="email-benefit-card">
                    <div class="benefit-icon">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>
                    <h4 class="benefit-title">ความปลอดภัยสูงสุด</h4>
                    <p class="benefit-desc">ระบบคัดกรองสแปมและไวรัสที่มีประสิทธิภาพ พร้อมการดูแลจากผู้ดูแลระบบของโรงเรียน</p>
                </div>
            </div>
        </div>

        <div class="request-section wow fadeInUp" data-wow-delay="0.5s">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h2 class="text-white fw-bold mb-4">ขั้นตอนการขอใช้งานอีเมล</h2>
                    <p class="text-white-50 mb-5 fs-5">สำหรับนักเรียนและบุคลากรที่ยังไม่มีบัญชีใช้งาน หรือต้องการรีเซ็ตรหัสผ่าน สามารถดำเนินการได้ตามขั้นตอนดังนี้</p>
                    
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex align-items-start gap-4 mb-3">
                            <div class="bg-white text-primary fw-bold rounded-circle d-flex align-items-center justify-content-center" style="min-width: 35px; height: 35px;">1</div>
                            <p class="mb-0 fs-5 text-white">เตรียมบัตรประจำตัวนักเรียน หรือบัตรประชาชน</p>
                        </div>
                        <div class="d-flex align-items-start gap-4 mb-3">
                            <div class="bg-white text-primary fw-bold rounded-circle d-flex align-items-center justify-content-center" style="min-width: 35px; height: 35px;">2</div>
                            <p class="mb-0 fs-5 text-white">ติดต่อเจ้าหน้าที่ ณ กลุ่มบริหารงานสารสนเทศ</p>
                        </div>
                        <div class="d-flex align-items-start gap-4">
                            <div class="bg-white text-primary fw-bold rounded-circle d-flex align-items-center justify-content-center" style="min-width: 35px; height: 35px;">3</div>
                            <p class="mb-0 fs-5 text-white">รอรับชื่อผู้ใช้ (Username) และรหัสผ่านเริ่มต้น</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="info-box-email">
                        <h4 class="text-white mb-4 fw-bold">สถานที่ติดต่อ</h4>
                        <div class="info-item-email">
                            <i class="bi bi-building"></i>
                            <div>
                                <h6 class="text-white mb-0">กลุ่มบริหารงานสารสนเทศ</h6>
                                <small class="text-white-50">ตึก 4 ชั้น 3 ห้องคอมพิวเตอร์</small>
                            </div>
                        </div>
                        <div class="info-item-email">
                            <i class="bi bi-clock-fill"></i>
                            <div>
                                <h6 class="text-white mb-0">เวลาทำการ</h6>
                                <small class="text-white-50">จันทร์ - ศุกร์ | 08.00 - 16.30 น.</small>
                            </div>
                        </div>
                        <div class="info-item-email">
                            <i class="bi bi-facebook"></i>
                            <div>
                                <h6 class="text-white mb-0">Facebook Page</h6>
                                <small class="text-white-50">S.K.J. Information Technology</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5 text-center wow fadeInUp" data-wow-delay="0.6s">
             <a href="https://accounts.google.com/" target="_blank" class="btn btn-primary py-3 px-5 rounded-pill shadow-lg fw-bold overflow-hidden position-relative" style="background: #249ffd; border: none;">
                <i class="bi bi-google me-2"></i> เข้าสู่ระบบอีเมลโรงเรียน
             </a>
        </div>
    </div>
</div>