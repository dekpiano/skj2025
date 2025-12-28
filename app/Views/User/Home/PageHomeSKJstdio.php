<style>
    .stdio-section {
        padding: 100px 0;
        background: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .stdio-section::before {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background: url('<?= base_url('uploads/background/bg-video1.jpg') ?>') center center no-repeat;
        background-size: cover;
        opacity: 0.03; /* Much lower for white background */
        filter: grayscale(100%);
    }

    .stdio-container {
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .stdio-subtitle {
        color: #249ffd; /* Blue for visibility on white */
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 4px;
        margin-bottom: 15px;
        display: block;
        font-size: 0.9rem;
    }

    .stdio-title {
        font-size: clamp(2.5rem, 5vw, 4rem);
        font-weight: 900;
        color: #1a2a4d; /* Dark Navy for white background */
        margin-bottom: 20px;
        font-family: 'K2D', sans-serif;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .stdio-desc {
        color: #555555; /* Dark gray for white background */
        font-size: 1.2rem;
        max-width: 600px;
        margin: 0 auto 40px;
    }

    .stdio-video-wrapper {
        position: relative;
        max-width: 900px;
        margin: 0 auto;
        padding: 15px;
        background: #fff;
        border-radius: 30px;
        border: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
    }

    .stdio-video-frame {
        width: 100%;
        aspect-ratio: 16 / 9;
        border-radius: 20px;
        overflow: hidden;
        border: 2px solid #249ffd;
        box-shadow: 0 0 30px rgba(36, 159, 253, 0.3);
    }

    .youtube-btn {
        margin-top: 50px;
        padding: 15px 40px;
        border-radius: 50px;
        background: #ff0000; /* YouTube Red */
        color: #fff;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(255, 0, 0, 0.3);
    }

    .youtube-btn:hover {
        background: #cc0000;
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(255, 0, 0, 0.5);
        color: #fff;
    }

    .youtube-btn i {
        font-size: 1.5rem;
    }

    @media (max-width: 768px) {
        .stdio-section { padding: 60px 0; }
        .stdio-title { font-size: 2rem; }
        .stdio-desc { font-size: 1rem; }
        .stdio-video-wrapper { padding: 8px; border-radius: 20px; }
    }
</style>

<div class="stdio-section wow fadeIn" data-wow-delay="0.1s">
    <div class="container stdio-container">
        <div class="row">
            <div class="col-12">
                <span class="stdio-subtitle wow fadeInUp" data-wow-delay="0.2s">| งานโสต สวนจิ</span>
                <h2 class="stdio-title wow fadeInUp" data-wow-delay="0.3s">SKJ STUDIOS</h2>
                <p class="stdio-desc wow fadeInUp" data-wow-delay="0.4s">ศูนย์กลางงานประชาสัมพันธ์และมัลติมีเดียที่ทันสมัย ผลิตผลงานสร้างสรรค์โดยทีมงานคุณภาพ</p>
                
                <div class="stdio-video-wrapper wow zoomIn" data-wow-delay="0.5s">
                    <div class="stdio-video-frame">
                        <iframe width="100%" height="100%" 
                                src="https://www.youtube.com/embed/RxdQ2-0scEQ" 
                                frameborder="0" loading="lazy"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen="">
                        </iframe>
                    </div>
                </div>

                <a href="https://www.youtube.com/@user-qb9js9ed6v" target="_blank" class="youtube-btn wow fadeInUp" data-wow-delay="0.6s">
                    <i class="bi bi-youtube"></i> ติดตามช่อง YouTube
                </a>
            </div>
        </div>
    </div>
</div>
