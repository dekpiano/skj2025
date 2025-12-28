<style>
    .guidance-header {
        position: relative;
        padding: 120px 0 100px;
        background: linear-gradient(rgba(26, 42, 77, 0.8), rgba(26, 42, 77, 0.8)), 
                    url(<?= base_url('uploads/background/bg-news.jpg') ?>) center center no-repeat;
        background-size: cover;
        border-radius: 0 0 60px 60px;
        text-align: center;
        margin-bottom: 50px;
    }

    .guidance-header h1 {
        font-weight: 900;
        letter-spacing: 1px;
        font-size: 3.5rem;
        margin-bottom: 15px;
    }

    .guidance-card {
        background: #fff;
        border-radius: 25px;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.02);
        position: relative;
    }

    .guidance-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(36, 159, 253, 0.15);
        border-color: rgba(36, 159, 253, 0.2);
    }

    .guidance-card-body {
        padding: 35px;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .guidance-icon {
        width: 60px;
        height: 60px;
        background: rgba(36, 159, 253, 0.1);
        color: #249ffd;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin-bottom: 25px;
        transition: all 0.3s ease;
    }

    .guidance-card:hover .guidance-icon {
        background: #249ffd;
        color: #fff;
        transform: rotate(-10deg) scale(1.1);
    }

    .guidance-title {
        font-weight: 800;
        color: #1a2a4d;
        font-size: 1.25rem;
        line-height: 1.5;
        margin-bottom: 15px;
        flex-grow: 1;
    }

    .guidance-date {
        font-size: 0.9rem;
        color: #888;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 25px;
    }

    .guidance-date i {
        color: #ff69b4;
    }

    .guidance-btn-group {
        display: flex;
        gap: 10px;
        margin-top: auto;
    }

    .btn-guidance {
        border-radius: 15px;
        padding: 12px 20px;
        font-weight: 700;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-guidance-primary {
        background: #249ffd;
        color: #fff;
        border: none;
    }

    .btn-guidance-primary:hover {
        background: #1a7fce;
        color: #fff;
        box-shadow: 0 5px 15px rgba(36, 159, 253, 0.3);
    }

    .btn-guidance-info {
        background: rgba(255, 105, 180, 0.1);
        color: #ff69b4;
        border: 1px solid rgba(255, 105, 180, 0.2);
    }

    .btn-guidance-info:hover {
        background: #ff69b4;
        color: #fff;
        box-shadow: 0 5px 15px rgba(255, 105, 180, 0.3);
    }

    @media (max-width: 767px) {
        .guidance-header {
            padding: 80px 20px;
            border-radius: 0 0 40px 40px;
        }
        .guidance-header h1 {
            font-size: 2.2rem;
        }
        .guidance-card-body {
            padding: 25px;
        }
    }
</style>

<div class="guidance-header wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <h1 class="display-4 text-white slideInDown mb-3">งานแนะแนว</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0 mt-4">
                <li class="breadcrumb-item"><a class="text-white-50" href="<?= base_url('/') ?>">หน้าแรก</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">งานแนะแนว</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 700px;">
            <h6 class="section-title bg-white text-center text-primary px-3 mb-4">ทุนการศึกษาและกิจกรรม</h6>
            <p class="text-muted">รวบรวมข้อมูลทุนการศึกษา โครงการเรียนร่วม และประกาศสำคัญต่างๆ ของงานแนะแนว โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</p>
        </div>

        <div class="row g-4">
            <!-- Item 1 -->
            <div class="col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.2s">
                <div class="guidance-card">
                    <div class="guidance-card-body">
                        <div class="guidance-icon">
                            <i class="bi bi-mortarboard-fill"></i>
                        </div>
                        <h4 class="guidance-title">คัดเลิอกนักเรียนเรียนร่วมชั้น ม.4 เครือข่ายโรงเรียนสวนกุหลาบวิทยาลัย 2568</h4>
                        <div class="guidance-date">
                            <i class="bi bi-calendar3"></i> สมัครวันที่ 1 - 20 กุมภาพันธ์ 2568
                        </div>
                        <div class="guidance-btn-group">
                            <a target="_blank" href="https://drive.google.com/drive/folders/1lKrwIQnxcIoSFNlg_kmz8FmgnzohOeIR?usp=sharing" class="btn-guidance btn-guidance-primary">
                                <i class="bi bi-file-earmark-text"></i> อ่านประกาศ
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.3s">
                <div class="guidance-card">
                    <div class="guidance-card-body">
                        <div class="guidance-icon">
                            <i class="bi bi-award-fill"></i>
                        </div>
                        <h4 class="guidance-title">นักเรียนทุนราชสกุลจิรประวัติ ประจำปีการศึกษา 2567</h4>
                        <div class="guidance-date">
                            <i class="bi bi-calendar3"></i> สมัครวันที่ 1 - 25 พฤศจิกายน 2567
                        </div>
                        <div class="guidance-btn-group">
                            <a target="_blank" href="https://drive.google.com/drive/folders/1hd1LvTLUAhwiibxr8NCcdsSnaeKNxavR?usp=sharing" class="btn-guidance btn-guidance-primary">
                                <i class="bi bi-file-earmark-text"></i> อ่านประกาศ
                            </a>
                            <a target="_blank" href="https://forms.gle/5FFQpZfUCkLgUhe4A" class="btn-guidance btn-guidance-info">
                                <i class="bi bi-pencil-square"></i> สมัครทุน
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.4s">
                <div class="guidance-card">
                    <div class="guidance-card-body">
                        <div class="guidance-icon">
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <h4 class="guidance-title">นักเรียนทุนราชสกุลจิรประวัติ ประจำปีการศึกษา 2566</h4>
                        <div class="guidance-date">
                            <i class="bi bi-calendar3"></i> สมัครวันที่ 1 - 27 พฤศจิกายน 2566
                        </div>
                        <div class="guidance-btn-group">
                            <a target="_blank" href="https://drive.google.com/file/d/1PWf5TIsvkGoU-dMQa_681-1YgfY_wx9G/view?usp=sharing" class="btn-guidance btn-guidance-primary">
                                <i class="bi bi-file-earmark-text"></i> อ่านประกาศ
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item 4 -->
            <div class="col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.5s">
                <div class="guidance-card">
                    <div class="guidance-card-body">
                        <div class="guidance-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h4 class="guidance-title">คัดเลิอกนักเรียนเรียนร่วมชั้น ม.4 เครือข่ายสวนกุหลาบฯ 2567</h4>
                        <div class="guidance-date">
                            <i class="bi bi-calendar3"></i> สมัครวันที่ 1 - 31 มกราคม 2567
                        </div>
                        <div class="guidance-btn-group">
                            <a target="_blank" href="https://drive.google.com/file/d/1WY3Dk7oHY2Q2tCoMHIxrlEMS9CwI0r9G/view?usp=sharing" class="btn-guidance btn-guidance-primary">
                                <i class="bi bi-file-earmark-text"></i> อ่านประกาศ
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item 5 -->
            <div class="col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.6s">
                <div class="guidance-card">
                    <div class="guidance-card-body">
                        <div class="guidance-icon">
                            <i class="bi bi-award"></i>
                        </div>
                        <h4 class="guidance-title">นักเรียนทุนราชสกุลจิรประวัติ ประจำปีการศึกษา 2565</h4>
                        <div class="guidance-date">
                            <i class="bi bi-calendar3"></i> สมัครวันที่ 1 พ.ย. - 15 ธ.ค. 2565
                        </div>
                        <div class="guidance-btn-group">
                            <a target="_blank" href="https://drive.google.com/file/d/1-wIm3K5vTIVLZu6xR1qix5NZx-Vr-PR4/view?usp=share_link" class="btn-guidance btn-guidance-primary">
                                <i class="bi bi-file-earmark-text"></i> อ่านประกาศ
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item 6 -->
            <div class="col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.7s">
                <div class="guidance-card">
                    <div class="guidance-card-body">
                        <div class="guidance-icon">
                            <i class="bi bi-bookmark-check-fill"></i>
                        </div>
                        <h4 class="guidance-title">โครงการนักเรียนร่วม เครือข่ายสวนกุหลาบ ประจำปีการศึกษา 2566</h4>
                        <div class="guidance-date">
                            <i class="bi bi-calendar3"></i> สมัครวันที่ 1 - 30 มกราคม 2566
                        </div>
                        <div class="guidance-btn-group">
                            <a target="_blank" href="https://drive.google.com/file/d/1yPoPNpcNVr3RYTvdlc5bOMwMsdufZ1Rh/view?usp=share_link" class="btn-guidance btn-guidance-primary">
                                <i class="bi bi-file-earmark-text"></i> อ่านประกาศ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>