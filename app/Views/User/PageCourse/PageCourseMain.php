<style>
    .course-header {
        background: linear-gradient(rgba(0, 50, 100, 0.7), rgba(0, 50, 100, 0.7)), url(<?= base_url('uploads/background/bg-contact.jpg') ?>) center no-repeat;
        background-size: cover;
        background-position: center;
        padding: 120px 0;
        border-radius: 0 0 100px 100px;
        margin-bottom: 60px;
        position: relative;
    }

    .course-section {
        padding: 80px 0;
        position: relative;
    }

    .course-section:nth-child(even) {
        background-color: #f8f9fa;
    }

    .excellence-card {
        background: #fff;
        border-radius: 30px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
        transition: all 0.5s ease;
        height: 100%;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .excellence-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.1);
    }

    .excellence-img-wrapper {
        position: relative;
        height: 400px;
        overflow: hidden;
        border-radius: 30px;
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    .excellence-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.8s ease;
    }

    .excellence-card:hover .excellence-img {
        transform: scale(1.1);
    }

    .excellence-title {
        font-weight: 800;
        color: #1a2a4d;
        margin-bottom: 20px;
        font-size: 2.5rem;
        position: relative;
        padding-bottom: 15px;
    }

    .excellence-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 80px;
        height: 4px;
        background: var(--primary);
        border-radius: 2px;
    }

    .title-accent {
        color: var(--primary);
        display: block;
        font-size: 1.2rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 10px;
    }

    .info-box {
        background: #f0f7ff;
        border-radius: 20px;
        padding: 25px;
        margin-top: 25px;
        border-left: 5px solid var(--primary);
    }

    .info-box h5 {
        color: #1a2a4d;
        font-weight: 700;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .info-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .info-list li {
        padding: 8px 0;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        color: #555;
    }

    .info-list li i {
        color: var(--primary);
        margin-top: 5px;
        font-size: 0.9rem;
    }

    .pathway-box {
        background: #fff5f7;
        border-radius: 20px;
        padding: 25px;
        margin-top: 20px;
        border-left: 5px solid #fb7e9c;
    }

    .pathway-box h5 {
        color: #d63384;
        font-weight: 700;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .pathway-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .pathway-list li {
        padding: 8px 0;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        color: #555;
    }

    .pathway-list li i {
        color: #fb7e9c;
        margin-top: 5px;
        font-size: 0.9rem;
    }

    .section-counter {
        font-size: 8rem;
        font-weight: 900;
        color: rgba(0, 0, 0, 0.03);
        position: absolute;
        top: 20px;
        right: 40px;
        line-height: 1;
        z-index: 0;
    }

    @media (max-width: 991px) {
        .excellence-img-wrapper {
            height: 300px;
            margin-bottom: 30px;
        }
        .excellence-title {
            font-size: 1.8rem;
        }
    }
</style>

<div class="course-header wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center">
        <h1 class="display-3 text-white slideInDown mb-3 fw-bold">หลักสูตรความเป็นเลิศ</h1>
        <p class="text-white-50 fs-5 mb-0">มุ่งเน้นพัฒนาศักยภาพนักเรียนสู่ความเป็นมืออาชีพในทุกด้าน</p>
        <nav aria-label="breadcrumb" class="mt-4">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="<?= base_url('/') ?>">หน้าแรก</a></li>
                <li class="breadcrumb-item text-white-50 active" aria-current="page">หลักสูตร</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-fluid p-0">
    
    <!-- 01 ACADEMIC -->
    <section class="course-section">
        <div class="section-counter">01</div>
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.1s">
                    <div class="excellence-img-wrapper">
                        <img src="<?= base_url('uploads/Excellence/sci.jpg') ?>" class="excellence-img" alt="Academic">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.2s">
                    <span class="title-accent">Academics</span>
                    <h2 class="excellence-title">ความเป็นเลิศทาง <br>ด้านวิชาการ (SMT)</h2>
                    <p class="text-muted fs-5">มุ่งเน้นพัฒนาส่งเสริมศักยภาพของนักเรียนให้มีความสามารถพิเศษทางด้านคณิตศาสตร์ วิทยาศาสตร์ และเทรนด์เทคโนโลยีแห่งอนาคต</p>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-box">
                                <h5><i class="bi bi-book"></i> การเรียนการสอน</h5>
                                <ul class="info-list">
                                    <li><i class="bi bi-check-circle-fill"></i> วิทยาศาสตร์/คณิตศาสตร์ขั้นสูง</li>
                                    <li><i class="bi bi-check-circle-fill"></i> Internet Of Thing (IoT)</li>
                                    <li><i class="bi bi-check-circle-fill"></i> ปัญญาประดิษฐ์ & หุ่นยนต์</li>
                                    <li><i class="bi bi-check-circle-fill"></i> One Classroom One Project</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pathway-box">
                                <h5><i class="bi bi-mortarboard"></i> แนวทางศึกษาต่อ</h5>
                                <ul class="pathway-list">
                                    <li><i class="bi bi-arrow-right-circle-fill"></i> คณะวิศวกรรมศาสตร์ทุกสาขา</li>
                                    <li><i class="bi bi-arrow-right-circle-fill"></i> คณะแพทยศาสตร์/พยาบาล</li>
                                    <li><i class="bi bi-arrow-right-circle-fill"></i> คณะวิทยาศาสตร์/เทคโนโลยี</li>
                                    <li><i class="bi bi-arrow-right-circle-fill"></i> ครุศาสตร์/ศึกษาศาสตร์</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 02 SPORT -->
    <section class="course-section">
        <div class="section-counter">02</div>
        <div class="container">
            <div class="row g-5 align-items-center flex-lg-row-reverse">
                <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.1s">
                    <div class="excellence-img-wrapper">
                        <img src="<?= base_url('uploads/Excellence/sport.jpg') ?>" class="excellence-img" alt="Sport">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2s">
                    <span class="title-accent">Athletics</span>
                    <h2 class="excellence-title">ความเป็นเลิศทาง <br>ด้านกีฬา</h2>
                    <p class="text-muted fs-5">มุ่งพัฒนาทักษะทางร่างกายและเทคนิคการเล่นกีฬาอย่างเป็นระบบ เตรียมพร้อมสู่การเป็นนักกึฬามืออาชีพหรือระดับชาติ</p>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-box">
                                <h5><i class="bi bi-trophy"></i> การเรียนการสอน</h5>
                                <ul class="info-list">
                                    <li><i class="bi bi-check-circle-fill"></i> วิทยาศาสตร์การกีฬา</li>
                                    <li><i class="bi bi-check-circle-fill"></i> ฟุตบอล / วอลเลย์บอล</li>
                                    <li><i class="bi bi-check-circle-fill"></i> แบดมินตัน / ว่ายน้ำ</li>
                                    <li><i class="bi bi-check-circle-fill"></i> ศิลปะการป้องกันตัว</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pathway-box">
                                <h5><i class="bi bi-flag"></i> แนวทางศึกษาต่อ</h5>
                                <ul class="pathway-list">
                                    <li><i class="bi bi-arrow-right-circle-fill"></i> โควตานักกีฬามหาวิทยาลัย</li>
                                    <li><i class="bi bi-arrow-right-circle-fill"></i> วิทยาศาสตร์การกีฬา (BS)</li>
                                    <li><i class="bi bi-arrow-right-circle-fill"></i> พลศึกษา / สุขศึกษา</li>
                                    <li><i class="bi bi-arrow-right-circle-fill"></i> นักกีฬาสังกัดสโมสร</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 03 ART & PERFORMANCE -->
    <section class="course-section">
        <div class="section-counter">03</div>
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.1s">
                    <div class="excellence-img-wrapper">
                        <img src="<?= base_url('uploads/Excellence/art.JPG') ?>" class="excellence-img" alt="Art">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.2s">
                    <span class="title-accent">Art & Creativity</span>
                    <h2 class="excellence-title">ความเป็นเลิศด้านศิลปะ <br>ดนตรี และการแสดง</h2>
                    <p class="text-muted fs-5">สร้างสรรค์จินตนาการอย่างไร้ขีดจำกัด ผ่านพื้นฐานศิลปะที่เข้มข้น ทั้งดนตรีไทย-สากล นาฏศิลป์ และทัศนศิลป์</p>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-box">
                                <h5><i class="bi bi-palette"></i> การเรียนการสอน</h5>
                                <ul class="info-list">
                                    <li><i class="bi bi-check-circle-fill"></i> ทฤษฎีและปฏิบัติศิลปะ</li>
                                    <li><i class="bi bi-check-circle-fill"></i> ดนตรี (สากล/ไทย)</li>
                                    <li><i class="bi bi-check-circle-fill"></i> การขับร้องและการแสดง</li>
                                    <li><i class="bi bi-check-circle-fill"></i> การออกแบบกราฟิก</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pathway-box">
                                <h5><i class="bi bi-brush"></i> แนวทางศึกษาต่อ</h5>
                                <ul class="pathway-list">
                                    <li><i class="bi bi-arrow-right-circle-fill"></i> คณะนิเทศศาสตร์/ศิลปกรรม</li>
                                    <li><i class="bi bi-arrow-right-circle-fill"></i> ดุริยางคศิลป์ / นาฏศิลป์</li>
                                    <li><i class="bi bi-arrow-right-circle-fill"></i> นักออกแบบ/Creative</li>
                                    <li><i class="bi bi-arrow-right-circle-fill"></i> ศิลปิน / กองดุริยางค์ทหาร</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 04 VOCATIONAL -->
    <section class="course-section">
        <div class="section-counter">04</div>
        <div class="container">
            <div class="row g-5 align-items-center flex-lg-row-reverse">
                <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.1s">
                    <div class="excellence-img-wrapper">
                        <img src="<?= base_url('uploads/Excellence/cree.jpg') ?>" class="excellence-img" alt="Vocational">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2s">
                    <span class="title-accent">Skills & Career</span>
                    <h2 class="excellence-title">ความเป็นเลิศทาง <br>ด้านวิชาชีพ</h2>
                    <p class="text-muted fs-5">เน้นทักษะการปฏิบัติงานจริงในสายงานช่างและอุตสาหกรรม สร้างทักษะพื้นฐานที่แข็งแกร่งสำหรับการเป็นผู้เชี่ยวชาญในอาชีพ</p>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-box">
                                <h5><i class="bi bi-tools"></i> การเรียนการสอน</h5>
                                <ul class="info-list">
                                    <li><i class="bi bi-check-circle-fill"></i> งานโครงสร้างและงานไม้</li>
                                    <li><i class="bi bi-check-circle-fill"></i> งานเชื่อมโลหะ</li>
                                    <li><i class="bi bi-check-circle-fill"></i> ไฟฟ้าและอิเล็กทรอนิกส์</li>
                                    <li><i class="bi bi-check-circle-fill"></i> ธุรกิจและการประกอบการ</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pathway-box">
                                <h5><i class="bi bi-hammer"></i> แนวทางศึกษาต่อ</h5>
                                <ul class="pathway-list">
                                    <li><i class="bi bi-arrow-right-circle-fill"></i> วิศวกรรมศาสตรบัณฑิต</li>
                                    <li><i class="bi bi-arrow-right-circle-fill"></i> ปวส. เทคนิคเฉพาะทาง</li>
                                    <li><i class="bi bi-arrow-right-circle-fill"></i> สถาปัตยกรรมศาสตร์</li>
                                    <li><i class="bi bi-arrow-right-circle-fill"></i> ผู้ประกอบการอิสระ</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 05 LANGUAGES -->
    <section class="course-section mb-5">
        <div class="section-counter">05</div>
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.1s">
                    <div class="excellence-img-wrapper">
                        <img src="<?= base_url('uploads/Excellence/lang.jpg') ?>" class="excellence-img" alt="Language">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.2s">
                    <span class="title-accent">Global Languages</span>
                    <h2 class="excellence-title">ความเป็นเลิศทาง <br>ด้านภาษา (IEP)</h2>
                    <p class="text-muted fs-5">เตรียมความพร้อมสู่สากลด้วยทักษะภาษาอังกฤษและภาษาจีนแบบเข้มข้น เน้นการสื่อสารจริงและพื้นฐานธุรกิจระหว่างประเทศ</p>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-box">
                                <h5><i class="bi bi-translate"></i> การเรียนการสอน</h5>
                                <ul class="info-list">
                                    <li><i class="bi bi-check-circle-fill"></i> ภาษาอังกฤษ/จีน (เข้มข้น)</li>
                                    <li><i class="bi bi-check-circle-fill"></i> ทักษะการท่องเที่ยว/โรงแรม</li>
                                    <li><i class="bi bi-check-circle-fill"></i> การพูดในที่สาธารณะ</li>
                                    <li><i class="bi bi-check-circle-fill"></i> ภาวะผู้นำระดับสากล</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pathway-box">
                                <h5><i class="bi bi-airplane"></i> แนวทางศึกษาต่อ</h5>
                                <ul class="pathway-list">
                                    <li><i class="bi bi-arrow-right-circle-fill"></i> อักษรศาสตร/มนุษยศาสตร์</li>
                                    <li><i class="bi bi-arrow-right-circle-fill"></i> การบริหารธุรกิจการบิน</li>
                                    <li><i class="bi bi-arrow-right-circle-fill"></i> ล่าม / มัคุเทศก์ / นักข่าว</li>
                                    <li><i class="bi bi-arrow-right-circle-fill"></i> การฑูตและความสัมพันธ์</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

<!-- Feature End -->