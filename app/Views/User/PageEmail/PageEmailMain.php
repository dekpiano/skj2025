<style>
    /* ==========================================================
       SKJ SCHOOL EMAIL & STUDENT PORTAL - HIGH CONTRAST ULTRA UI
       ========================================================== */
    .email-header {
        position: relative;
        padding: 120px 0 100px;
        background: linear-gradient(rgba(10, 25, 47, 0.88), rgba(15, 23, 42, 0.94)), 
                    url(<?= base_url('uploads/background/bg-contact.jpg') ?>) center center no-repeat;
        background-size: cover;
        border-radius: 0 0 60px 60px;
        text-align: center;
        margin-bottom: 40px;
    }

    .email-header h1 {
        font-weight: 900;
        letter-spacing: 1px;
        font-size: 3.5rem;
        margin-bottom: 15px;
        color: #ffffff;
        text-shadow: 0 4px 16px rgba(0, 0, 0, 0.4);
    }

    .email-header-subtitle {
        color: #f1f5f9;
        font-size: 1.25rem;
        font-weight: 500;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.4);
    }

    .email-breadcrumb .breadcrumb-item a {
        color: #93c5fd;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s ease;
    }
    .email-breadcrumb .breadcrumb-item a:hover {
        color: #ffffff;
        text-decoration: underline;
    }
    .email-breadcrumb .breadcrumb-item.active {
        color: #ffffff;
        font-weight: 700;
    }
    .email-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
        color: #94a3b8;
    }

    /* Fast Action Portal Cards */
    .portal-action-card {
        background: #ffffff;
        border-radius: 28px;
        padding: 35px 30px;
        box-shadow: 0 12px 35px rgba(15, 23, 42, 0.08);
        border: 2px solid #cbd5e1;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        text-align: center;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
    }

    .portal-action-card.highlight {
        border-color: #0284c7;
        background: linear-gradient(180deg, #ffffff 0%, #f0f9ff 100%);
        box-shadow: 0 20px 45px rgba(2, 132, 199, 0.18);
    }

    .portal-action-card.highlight::before {
        content: '🌟 แนะนำสำหรับนักเรียน';
        position: absolute;
        top: 16px;
        right: -34px;
        background: linear-gradient(135deg, #e11d48, #be123c);
        color: #ffffff;
        font-size: 0.74rem;
        font-weight: 800;
        padding: 5px 40px;
        transform: rotate(45deg);
        box-shadow: 0 2px 10px rgba(190, 18, 60, 0.35);
    }

    .portal-action-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px rgba(15, 23, 42, 0.16);
        border-color: #3b82f6;
    }

    .portal-icon-wrap {
        width: 76px;
        height: 76px;
        border-radius: 22px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        margin-bottom: 20px;
        transition: transform 0.3s ease;
    }

    .portal-action-card:hover .portal-icon-wrap {
        transform: scale(1.1);
    }

    .portal-icon-blue {
        background: #e0f2fe;
        color: #0369a1;
        border: 1.5px solid #bae6fd;
    }

    .portal-icon-google {
        background: #fee2e2;
        color: #b91c1c;
        border: 1.5px solid #fecaca;
    }

    .portal-icon-chat {
        background: #fce7f3;
        color: #be185d;
        border: 1.5px solid #fbcfe8;
    }

    .portal-card-title {
        font-size: 1.35rem;
        font-weight: 800;
        color: #0f172a;
    }

    .portal-card-desc {
        color: #334155;
        font-size: 0.88rem;
        line-height: 1.65;
        font-weight: 500;
    }

    /* Benefits Cards */
    .email-benefit-card {
        background: #ffffff;
        border-radius: 26px;
        padding: 35px 30px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
        border: 2px solid #e2e8f0;
        transition: all 0.35s ease;
        text-align: center;
        height: 100%;
    }

    .email-benefit-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 45px rgba(2, 132, 199, 0.16);
        border-color: #38bdf8;
    }

    .benefit-icon {
        width: 72px;
        height: 72px;
        border-radius: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin: 0 auto 20px;
        transition: all 0.3s ease;
    }

    .email-benefit-card:hover .benefit-icon {
        transform: scale(1.08);
    }

    .benefit-title {
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 12px;
        font-size: 1.25rem;
    }

    .benefit-desc {
        color: #334155;
        line-height: 1.7;
        font-size: 0.94rem;
        font-weight: 500;
    }

    /* High Contrast Badges */
    .badge-contrast-blue {
        background: #dbeafe !important;
        color: #1e40af !important;
        border: 1px solid #bfdbfe;
        font-weight: 700;
    }
    .badge-contrast-green {
        background: #d1fae5 !important;
        color: #065f46 !important;
        border: 1px solid #a7f3d0;
        font-weight: 700;
    }
    .badge-contrast-amber {
        background: #fef3c7 !important;
        color: #92400e !important;
        border: 1px solid #fde68a;
        font-weight: 700;
    }
    .badge-contrast-purple {
        background: #ede9fe !important;
        color: #5b21b6 !important;
        border: 1px solid #ddd6fe;
        font-weight: 700;
    }
    .badge-contrast-red {
        background: #fee2e2 !important;
        color: #991b1b !important;
        border: 1px solid #fecaca;
        font-weight: 700;
    }
    .badge-contrast-sky {
        background: #e0f2fe !important;
        color: #075985 !important;
        border: 1px solid #bae6fd;
        font-weight: 700;
    }
    .badge-contrast-pink {
        background: #fce7f3 !important;
        color: #9d174d !important;
        border: 1px solid #fbcfe8;
        font-weight: 700;
    }

    /* Request & Step Section */
    .request-section {
        background: linear-gradient(135deg, #0b1e3b 0%, #1e3a8a 50%, #0369a1 100%);
        border-radius: 36px;
        padding: 60px 45px;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        margin-top: 40px;
        box-shadow: 0 20px 50px rgba(11, 30, 59, 0.35);
        border: 2px solid rgba(255, 255, 255, 0.15);
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

    .step-pill-card {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(12px);
        border: 1.5px solid rgba(255, 255, 255, 0.28);
        border-radius: 20px;
        padding: 18px 22px;
        display: flex;
        align-items: center;
        gap: 18px;
        transition: all 0.25s ease;
    }
    .step-pill-card:hover {
        background: rgba(255, 255, 255, 0.24);
        transform: translateX(4px);
        border-color: rgba(255, 255, 255, 0.45);
    }

    .step-pill-card .step-num {
        background: #ffffff;
        color: #1e3a8a;
        font-weight: 900;
        font-size: 1.15rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: 42px;
        height: 42px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .info-box-email {
        background: rgba(10, 25, 47, 0.85);
        backdrop-filter: blur(14px);
        border: 2px solid rgba(255, 255, 255, 0.25);
        border-radius: 26px;
        padding: 32px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .info-item-email {
        display: flex;
        align-items: center;
        gap: 18px;
        margin-bottom: 20px;
    }

    .info-item-email:last-child {
        margin-bottom: 0;
    }

    .info-item-email i {
        font-size: 1.6rem;
        color: #38bdf8;
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
            padding: 40px 20px;
            border-radius: 26px;
        }
    }
</style>

<!-- Hero Header Section -->
<div class="email-header wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <h1 class="display-4 slideInDown mb-3">Google Workspace for Education</h1>
        <p class="email-header-subtitle mb-0">เปิดโลกแห่งการเรียนรู้ที่ไร้ขีดจำกัดด้วยอีเมล @skj.ac.th</p>
        <nav aria-label="breadcrumb" class="email-breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0 mt-4">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">หน้าแรก</a></li>
                <li class="breadcrumb-item active" aria-current="page">อีเมลโรงเรียน</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-xxl py-4">
    <div class="container">

        <!-- Quick Access Portals (Primary Actions) -->
        <div class="row g-4 mb-5 justify-content-center">
            
            <!-- Student Portal (Request / Forgot Password / Check Email) -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="portal-action-card highlight">
                    <div>
                        <div class="portal-icon-wrap portal-icon-blue">
                            <i class="bi bi-person-vcard-fill"></i>
                        </div>
                        <h4 class="portal-card-title mb-2">ระบบบริการนักเรียน</h4>
                        <div class="badge badge-contrast-blue rounded-pill px-3 py-1 mb-3">
                            <i class="bi bi-key-fill me-1"></i> ขออีเมลใหม่ / ลืมรหัสผ่าน
                        </div>
                        <p class="portal-card-desc mb-4">
                            สำหรับนักเรียนเข้าตรวจสอบชื่ออีเมลโรงเรียน (@skj.ac.th), ขอรับอีเมลใหม่, รหัสผ่าน WiFi และแจ้งลืมรหัสผ่าน
                        </p>
                    </div>
                    <a href="https://student.skj.ac.th/" target="_blank" class="btn btn-primary py-2 px-4 rounded-pill shadow-sm fw-bold d-flex align-items-center justify-content-center gap-2" style="background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%); border: none; font-size: 0.95rem;">
                        <span>เข้าสู่ระบบนักเรียน</span>
                        <i class="bi bi-box-arrow-up-right"></i>
                    </a>
                </div>
            </div>

            <!-- Google Workspace / Gmail Login -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                <div class="portal-action-card">
                    <div>
                        <div class="portal-icon-wrap portal-icon-google">
                            <i class="bi bi-google"></i>
                        </div>
                        <h4 class="portal-card-title mb-2">เข้าใช้งานอีเมลโรงเรียน</h4>
                        <div class="badge badge-contrast-red rounded-pill px-3 py-1 mb-3">
                            <i class="bi bi-envelope-check-fill me-1"></i> Google Workspace / Gmail
                        </div>
                        <p class="portal-card-desc mb-4">
                            เข้าสู่ระบบกล่องจดหมาย @skj.ac.th เพื่อรับ-ส่งอีเมล, ใช้งาน Google Classroom, Drive, Docs และ Meet
                        </p>
                    </div>
                    <a href="https://accounts.google.com/" target="_blank" class="btn btn-outline-danger py-2 px-4 rounded-pill fw-bold d-flex align-items-center justify-content-center gap-2" style="border-width: 2px; font-size: 0.95rem;">
                        <span>ล็อกอินเข้าสู่ระบบ Google</span>
                        <i class="bi bi-box-arrow-up-right"></i>
                    </a>
                </div>
            </div>

            <!-- Helpdesk & Live Chat -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="portal-action-card">
                    <div>
                        <div class="portal-icon-wrap portal-icon-chat">
                            <i class="bi bi-chat-dots-fill"></i>
                        </div>
                        <h4 class="portal-card-title mb-2">ติดต่อกลุ่มสารสนเทศ</h4>
                        <div class="badge badge-contrast-pink rounded-pill px-3 py-1 mb-3">
                            <i class="bi bi-headset me-1"></i> Live Chat ปรึกษาเจ้าหน้าที่
                        </div>
                        <p class="portal-card-desc mb-4">
                            ครู บุคลากร หรือนักเรียนที่มีปัญหาการใช้งาน สามารถทักสอบถามหรือขอความช่วยเหลือจากเจ้าหน้าที่ได้ทันที
                        </p>
                    </div>
                    <button type="button" class="btn btn-outline-danger py-2 px-4 rounded-pill fw-bold d-flex align-items-center justify-content-center gap-2" onclick="if(typeof toggleChatWindow==='function'){toggleChatWindow();}else{window.location.href='https://www.facebook.com/SKJNS160';}" style="border-color: #e11d48; color: #be123c; border-width: 2px; font-size: 0.95rem;">
                        <span>💬 ทักแชทสอบถามข้อมูล</span>
                    </button>
                </div>
            </div>

        </div>

        <!-- Benefits Section Header -->
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 840px;">
            <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill badge-contrast-blue small mb-3">
                <i class="bi bi-stars"></i> สิทธิประโยชน์สุดพิเศษระดับพรีเมียม
            </div>
            <h2 class="display-6 fw-bold mb-3" style="color: #0f172a;">ทำไมต้องใช้อีเมลโรงเรียน @skj.ac.th?</h2>
            <p class="fs-6" style="color: #334155; line-height: 1.75; font-weight: 500;">
                มากกว่าแค่บัญชีอีเมลธรรมดา — บัญชี <strong class="text-primary fw-bold">@skj.ac.th</strong> คือกุญแจสำคัญสู่โลกแห่งการเรียนรู้ระดับสากล พร้อมปลดล็อกเครื่องมือและสิทธิพิเศษทางการศึกษามูลค่ารวมกว่าหลักหมื่นบาทที่โรงเรียนมอบให้นักเรียนและบุคลากรทุกคน <strong class="text-dark fw-bold">ฟรี 100%!</strong>
            </p>
        </div>

        <!-- 6 Core Benefit Cards Grid -->
        <div class="row g-4 justify-content-center mb-5">
            
            <!-- Benefit 1: Google Classroom & Digital Learning -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.15s">
                <div class="email-benefit-card">
                    <div class="benefit-icon" style="background: #e0f2fe; color: #0369a1; border: 1.5px solid #bae6fd;">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>
                    <div class="badge badge-contrast-blue rounded-pill px-3 py-1 mb-2 small">
                        ห้องเรียนไร้ขีดจำกัด
                    </div>
                    <h4 class="benefit-title">Google Classroom & Meet</h4>
                    <p class="benefit-desc">
                        เข้าถึงห้องเรียนออนไลน์ทุกรายวิชา ส่งการบ้าน รับคะแนนและข้อเสนอแนะจากคุณครูแบบเรียลไทม์ พร้อมประชุมวิดีโอคอล Google Meet คมชัดระดับ HD ไม่จำกัดเวลา
                    </p>
                </div>
            </div>

            <!-- Benefit 2: Massive Cloud Storage -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.25s">
                <div class="email-benefit-card">
                    <div class="benefit-icon" style="background: #d1fae5; color: #065f46; border: 1.5px solid #a7f3d0;">
                        <i class="bi bi-cloud-arrow-up-fill"></i>
                    </div>
                    <div class="badge badge-contrast-green rounded-pill px-3 py-1 mb-2 small">
                        พื้นที่เก็บข้อมูลการศึกษา
                    </div>
                    <h4 class="benefit-title">Google Drive จุใจ ปลอดภัย</h4>
                    <p class="benefit-desc">
                        จัดเก็บไฟล์การบ้าน สไลด์นำเสนอ เอกสาร PDF คลิปวิดีโอ และโครงงานต่างๆ ได้ไม่อั้น ไม่ต้องกังวลเรื่องหน่วยความจำในมือถือเต็ม ไฟล์ซิงก์อัตโนมัติเปิดได้ทุกที่ทุกเวลา
                    </p>
                </div>
            </div>

            <!-- Benefit 3: Realtime Collaboration -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.35s">
                <div class="email-benefit-card">
                    <div class="benefit-icon" style="background: #fef3c7; color: #92400e; border: 1.5px solid #fde68a;">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="badge badge-contrast-amber rounded-pill px-3 py-1 mb-2 small">
                        ทำงานกลุ่มพร้อมกัน
                    </div>
                    <h4 class="benefit-title">Docs, Sheets & Slides สด</h4>
                    <p class="benefit-desc">
                        สร้างรายงาน ตารางข้อมูล และสไลด์พรีเซนต์งานกลุ่มร่วมกับเพื่อนๆ ในเวลาเดียวกัน พิมพ์แก้ไขและคอมเมนต์พร้อมกันได้ทันที ไม่ต้องส่งไฟล์สลับไปมาให้สับสน
                    </p>
                </div>
            </div>

            <!-- Benefit 4: Canva for Education Pro -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.45s">
                <div class="email-benefit-card">
                    <div class="benefit-icon" style="background: #ede9fe; color: #5b21b6; border: 1.5px solid #ddd6fe;">
                        <i class="bi bi-palette-fill"></i>
                    </div>
                    <div class="badge badge-contrast-purple rounded-pill px-3 py-1 mb-2 small">
                        ปลดล็อก Canva Pro ฟรี
                    </div>
                    <h4 class="benefit-title">Canva for Education ฟรี 100%</h4>
                    <p class="benefit-desc">
                        ใช้บัญชี @skj.ac.th ล็อกอิน Canva ปลดล็อกเทมเพลตระดับโปร ฟอนต์พรีเมียม สติกเกอร์ และเครื่องมือ Magic AI ทำพอร์ตโฟลิโอ (Portfolio) ส่งเข้ามหาวิทยาลัยได้สวยงามไร้ลายน้ำ
                    </p>
                </div>
            </div>

            <!-- Benefit 5: Student Perks & Software Discounts -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.55s">
                <div class="email-benefit-card">
                    <div class="benefit-icon" style="background: #fee2e2; color: #991b1b; border: 1.5px solid #fecaca;">
                        <i class="bi bi-gift-fill"></i>
                    </div>
                    <div class="badge badge-contrast-red rounded-pill px-3 py-1 mb-2 small">
                        สิทธิพิเศษนักเรียนสากล
                    </div>
                    <h4 class="benefit-title">ส่วนลด & สิทธิพิเศษระดับโลก</h4>
                    <p class="benefit-desc">
                        ยืนยันสถานะนักเรียนเพื่อรับสิทธิ์ฟรี/ส่วนลดราคาพิเศษ เช่น Notion Education Plus, GitHub Student Developer Pack, Microsoft Office 365, Spotify และ YouTube Premium สำหรับนักเรียน
                    </p>
                </div>
            </div>

            <!-- Benefit 6: Security & Official Credibility -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.65s">
                <div class="email-benefit-card">
                    <div class="benefit-icon" style="background: #e0f2fe; color: #075985; border: 1.5px solid #bae6fd;">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div class="badge badge-contrast-sky rounded-pill px-3 py-1 mb-2 small">
                        ปลอดภัย ไร้โฆษณา
                    </div>
                    <h4 class="benefit-title">น่าเชื่อถือ ปลอดภัย ไร้สแปม</h4>
                    <p class="benefit-desc">
                        ใช้เป็นอีเมลทางการในการสมัครสอบ TCAS, ยื่นขอทุนการศึกษา และแข่งขันทักษะวิชาการ พร้อมระบบป้องกันมัลแวร์ระดับองค์กรจาก Google ปลอดภัยและไม่มีโฆษณารบกวน
                    </p>
                </div>
            </div>

        </div>

        <!-- Student Perks Showcase Banner -->
        <div class="card border-0 rounded-4 shadow-sm mb-5 overflow-hidden wow fadeInUp" data-wow-delay="0.2s" style="background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%); border: 2px solid #cbd5e1 !important;">
            <div class="card-body p-4 p-md-5">
                <div class="row align-items-center g-4">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge bg-primary px-3 py-1 rounded-pill fw-bold text-white">🚀 Student Digital Passport</span>
                            <span class="fw-bold" style="color: #475569; font-size: 0.85rem;">บัญชีเดียว ครบทุกแอปการศึกษา</span>
                        </div>
                        <h3 class="fw-bold mb-3" style="color: #0f172a; font-size: 1.55rem;">ปลดล็อกโลกแห่งซอฟต์แวร์ชั้นนำฟรีทันที</h3>
                        <p class="mb-4" style="color: #334155; line-height: 1.7; font-size: 0.92rem; font-weight: 500;">
                            เพียงใช้อีเมล <strong class="text-primary fw-bold">@skj.ac.th</strong> ในการสมัครหรือล็อกอินเข้าใช้งานแพลตฟอร์มการเรียนรู้ระดับสากล ก็สามารถเข้าถึงฟีเจอร์พรีเมียมได้ฟรีโดยไม่มีค่าใช้จ่ายเพิ่มเติม
                        </p>
                        
                        <div class="row g-3">
                            <div class="col-sm-6 col-md-3">
                                <div class="bg-white p-3 rounded-3 shadow-sm border text-center h-100" style="border-color: #cbd5e1 !important;">
                                    <i class="bi bi-palette text-primary fs-3 mb-1 d-block"></i>
                                    <strong class="d-block small" style="color: #0f172a; font-weight: 700;">Canva Pro Edu</strong>
                                    <span class="d-block" style="color: #475569; font-size: 0.74rem; font-weight: 600;">ปลดล็อกทุกเทมเพลต</span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="bg-white p-3 rounded-3 shadow-sm border text-center h-100" style="border-color: #cbd5e1 !important;">
                                    <i class="bi bi-file-earmark-code text-success fs-3 mb-1 d-block"></i>
                                    <strong class="d-block small" style="color: #0f172a; font-weight: 700;">GitHub Student</strong>
                                    <span class="d-block" style="color: #475569; font-size: 0.74rem; font-weight: 600;">เครื่องมือ Dev ฟรี</span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="bg-white p-3 rounded-3 shadow-sm border text-center h-100" style="border-color: #cbd5e1 !important;">
                                    <i class="bi bi-journal-check text-warning fs-3 mb-1 d-block"></i>
                                    <strong class="d-block small" style="color: #0f172a; font-weight: 700;">Notion Plus</strong>
                                    <span class="d-block" style="color: #475569; font-size: 0.74rem; font-weight: 600;">จดเลกเชอร์ไม่อั้น</span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="bg-white p-3 rounded-3 shadow-xs border text-center h-100" style="border-color: #cbd5e1 !important;">
                                    <i class="bi bi-microsoft text-info fs-3 mb-1 d-block"></i>
                                    <strong class="d-block small" style="color: #0f172a; font-weight: 700;">Office 365</strong>
                                    <span class="d-block" style="color: #475569; font-size: 0.74rem; font-weight: 600;">Word, Excel ออนไลน์</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 text-center">
                        <div class="p-4 rounded-4 bg-white shadow-sm border text-center" style="border: 2px solid #bae6fd !important;">
                            <div class="text-primary mb-2">
                                <i class="bi bi-shield-fill-check display-4"></i>
                            </div>
                            <h5 class="fw-bold mb-1" style="color: #0f172a;">ยังไม่มีบัญชีหรือลืมรหัส?</h5>
                            <p class="mb-3 small" style="color: #334155; font-weight: 500;">ตรวจสอบหรือขอบัญชี @skj.ac.th ได้ทันทีผ่านระบบนักเรียน</p>
                            <a href="https://student.skj.ac.th/" target="_blank" class="btn btn-primary btn-sm rounded-pill px-4 py-2 fw-bold w-100 shadow-sm" style="background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%); border: none; font-size: 0.92rem;">
                                <i class="bi bi-arrow-right-circle me-1"></i> เข้าสู่ระบบนักเรียน
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Request & Reset Password Guide Section -->
        <div class="request-section wow fadeInUp" data-wow-delay="0.5s">
            <div class="row align-items-center g-4">
                <div class="col-lg-7">
                    <h2 class="text-white fw-bold mb-3" style="text-shadow: 0 2px 10px rgba(0,0,0,0.3);">ขั้นตอนการขอใช้งานอีเมล & ลืมรหัสผ่าน</h2>
                    <p class="mb-4 fs-6" style="color: #e2e8f0; font-weight: 400; line-height: 1.65;">สำหรับนักเรียนและบุคลากรที่ต้องการขอรับบัญชีใหม่ หรือลืมรหัสผ่าน สามารถดำเนินการได้ตามช่องทางด้านล่าง</p>
                    
                    <div class="d-flex flex-column gap-3">
                        <!-- Step 1 (Student System) -->
                        <div class="step-pill-card">
                            <div class="step-num">1</div>
                            <div class="flex-grow-1">
                                <h6 class="text-white fw-bold mb-1" style="font-size: 1.02rem;">สำหรับนักเรียน: ดำเนินการผ่านระบบนักเรียนได้ทันที</h6>
                                <p class="mb-0 small" style="color: #f1f5f9; line-height: 1.5;">
                                    เข้าสู่ระบบนักเรียนที่ <a href="https://student.skj.ac.th/" target="_blank" class="fw-bold" style="color: #93c5fd; text-decoration: underline;">student.skj.ac.th</a> เพื่อดูข้อมูลอีเมลและรหัสผ่านเริ่มต้น หรือกดยื่นขออีเมล/รีเซ็ตรหัสผ่าน
                                </p>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="step-pill-card">
                            <div class="step-num">2</div>
                            <div class="flex-grow-1">
                                <h6 class="text-white fw-bold mb-1" style="font-size: 1.02rem;">สำหรับคุณครูและบุคลากร</h6>
                                <p class="mb-0 small" style="color: #f1f5f9; line-height: 1.5;">ติดต่อเจ้าหน้าที่กลุ่มสารสนเทศเพื่อออกบัญชีผู้ใช้ หรือส่งข้อความผ่าน Live Chat บนหน้าเว็บไซต์</p>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="step-pill-card">
                            <div class="step-num">3</div>
                            <div class="flex-grow-1">
                                <h6 class="text-white fw-bold mb-1" style="font-size: 1.02rem;">เข้าสู่ระบบครั้งแรกและเปลี่ยนรหัสผ่าน</h6>
                                <p class="mb-0 small" style="color: #f1f5f9; line-height: 1.5;">ล็อกอินผ่าน accounts.google.com พร้อมตั้งรหัสผ่านใหม่เพื่อความปลอดภัยของบัญชี</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="info-box-email">
                        <h4 class="text-white mb-4 fw-bold"><i class="bi bi-geo-alt-fill text-warning me-2"></i>สถานที่ติดต่อ</h4>
                        <div class="info-item-email">
                            <i class="bi bi-building"></i>
                            <div>
                                <h6 class="text-white mb-0 fw-bold">กลุ่มบริหารงานสารสนเทศ</h6>
                                <small style="color: #cbd5e1; font-weight: 500;">อาคาร 4 ชั้น 3 ห้องปฏิบัติการคอมพิวเตอร์</small>
                            </div>
                        </div>
                        <div class="info-item-email">
                            <i class="bi bi-clock-fill"></i>
                            <div>
                                <h6 class="text-white mb-0 fw-bold">เวลาทำการ</h6>
                                <small style="color: #cbd5e1; font-weight: 500;">จันทร์ - ศุกร์ | 08.00 - 16.30 น.</small>
                            </div>
                        </div>
                        <div class="info-item-email">
                            <i class="bi bi-telephone-fill"></i>
                            <div>
                                <h6 class="text-white mb-0 fw-bold">เบอร์โทรศัพท์สำนักงาน</h6>
                                <small style="color: #cbd5e1; font-weight: 600;">056-009-667</small>
                            </div>
                        </div>
                        <div class="info-item-email">
                            <i class="bi bi-facebook"></i>
                            <div>
                                <h6 class="text-white mb-0 fw-bold">Facebook Page</h6>
                                <a href="https://www.facebook.com/SKJNS160" target="_blank" class="small fw-bold" style="color: #93c5fd; text-decoration: underline;">โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Big Call-to-action Action Buttons at Bottom -->
        <div class="mt-5 text-center wow fadeInUp" data-wow-delay="0.6s">
            <div class="d-flex flex-wrap justify-content-center gap-3">
                <a href="https://student.skj.ac.th/" target="_blank" class="btn btn-primary py-3 px-5 rounded-pill shadow-lg fw-bold overflow-hidden position-relative" style="background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%); border: none; font-size: 1.05rem;">
                    <i class="bi bi-person-badge-fill me-2"></i> ไปที่ระบบนักเรียน (ขออีเมล / ลืมรหัสผ่าน)
                </a>
                <a href="https://accounts.google.com/" target="_blank" class="btn btn-light py-3 px-5 rounded-pill shadow-sm fw-bold" style="border: 2px solid #cbd5e1; color: #0f172a; font-size: 1.05rem;">
                    <i class="bi bi-google me-2 text-danger"></i> เข้าสู่ระบบอีเมลโรงเรียน (Gmail)
                </a>
            </div>
        </div>

    </div>
</div>