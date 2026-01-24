<div class="skj-page-header header-news wow fadeIn" data-wow-delay="0.1s">
    <div class="container">
        <h1 class="slideInDown mb-3">ข่าวประชาสัมพันธ์</h1>
        <p class="text-white-50 fs-5 mb-0">เกาะติดข่าวสารและกิจกรรมล่าสุดจาก สวนกุหลาบวิทยาลัย (จิรประวัติ)</p>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0 mt-4">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">หน้าแรก</a></li>
                <li class="breadcrumb-item active" aria-current="page">ข่าวสาร</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-xxl py-5">
    <div class="container">

        <style>
            .news-header {
                background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url(<?= base_url('uploads/background/bg-news.jpg') ?>) center no-repeat;
                background-size: cover;
                background-position: center;
                padding: 100px 0;
                border-radius: 0 0 50px 50px;
                margin-bottom: -30px;
            }

            .news-search-container {
                max-width: 800px;
                margin: -40px auto 60px;
                position: relative;
                z-index: 100;
            }

            .news-search-box {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(15px);
                border-radius: 50px;
                padding: 5px 10px 5px 30px;
                box-shadow: 0 15px 45px rgba(0, 0, 0, 0.2);
                display: flex;
                align-items: center;
                transition: all 0.4s ease;
                border: 1px solid rgba(255, 255, 255, 0.3);
            }

            .news-search-box:focus-within {
                transform: translateY(-5px);
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
            }

            .news-search-box input {
                border: none;
                background: transparent;
                width: 100%;
                padding: 15px 0;
                outline: none;
                font-size: 1.1rem;
                color: #333;
            }

            .news-search-box button {
                background: var(--primary);
                color: #fff;
                border: none;
                border-radius: 40px;
                padding: 12px 35px;
                font-weight: 600;
                transition: all 0.3s ease;
            }

            .news-search-box button:hover {
                background: #38b8f5;
                transform: scale(1.05);
            }

            .news-card {
                background: #fff;
                border-radius: 25px;
                overflow: hidden;
                border: 1px solid rgba(0, 0, 0, 0.05);
                transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
                height: 100%;
                display: flex;
                flex-direction: column;
                box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            }

            .news-card:hover {
                transform: translateY(-15px);
                box-shadow: 0 30px 60px rgba(0, 0, 0, 0.12);
            }

            .news-card-img-wrapper {
                position: relative;
                height: 240px;
                overflow: hidden;
            }

            .news-card-img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.6s ease;
            }

            .news-card:hover .news-card-img {
                transform: scale(1.1);
            }

            .news-card-badge {
                position: absolute;
                top: 20px;
                left: 20px;
                background: var(--primary);
                color: #fff;
                padding: 6px 15px;
                border-radius: 12px;
                font-size: 0.75rem;
                font-weight: 700;
                z-index: 2;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            }

            .news-card-body {
                padding: 25px;
                flex-grow: 1;
                display: flex;
                flex-direction: column;
            }

            .news-meta {
                display: flex;
                gap: 15px;
                margin-bottom: 15px;
                color: #999;
                font-size: 0.85rem;
            }

            .news-meta i {
                color: var(--primary);
            }

            .news-card-title {
                font-size: 1.25rem;
                font-weight: 800;
                line-height: 1.5;
                margin-bottom: 20px;
                color: #1a2a4d;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
                transition: color 0.3s ease;
                text-decoration: none;
            }

            .news-card:hover .news-card-title {
                color: var(--primary);
            }

            .news-card-footer {
                margin-top: auto;
                padding-top: 20px;
                border-top: 1px solid #f0f0f0;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .read-more-link {
                font-weight: 700;
                color: var(--primary);
                text-decoration: none;
                display: flex;
                align-items: center;
                gap: 8px;
                transition: gap 0.3s ease;
            }

            .read-more-link:hover {
                gap: 12px;
                color: #1a2a4d;
            }

            #suggestions-list {
                z-index: 1000;
                top: 100%;
                background: #fff;
                border-radius: 20px;
                margin-top: 10px;
                box-shadow: 0 15px 40px rgba(0,0,0,0.1);
                overflow: hidden;
                border: none;
            }

            .list-group-item {
                padding: 15px 25px;
                border: none;
                transition: background 0.3s ease;
            }

            .list-group-item:hover {
                background: #f8f9fa;
            }

            .highlight {
                color: var(--primary);
                font-weight: 800;
                background: transparent;
            }
        </style>

        <!-- Glassmorphism Search Bar -->
        <div class="news-search-container wow fadeInUp" data-wow-delay="0.2s">
            <form method='get' action="<?= base_url('News') ?>" id="searchForm" autocomplete="off">
                <div class="news-search-box position-relative">
                    <i class="bi bi-search text-primary fs-5 me-3"></i>
                    <input type="text" id="searchInput" name='search' value='<?= $search ?>' placeholder="ค้นหาประกาศ ข่าวสาร กิจกรรม...">
                    <button type="submit">ค้นหาข่าว</button>
                    <div id="suggestions-list" class="list-group position-absolute w-100"></div>
                </div>
            </form>
        </div>

        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
            <h6 class="section-title bg-white text-center text-primary px-3">Latest Updates</h6>
            <h1 class="display-5 fw-bold mb-4">ข่าวสารและกิจกรรมที่น่าสนใจ</h1>
            <div style="height: 4px; width: 80px; background: var(--primary); margin: 0 auto; border-radius: 2px;"></div>
        </div>

        <div class="row g-4" id="grid">
            <!-- News items will be loaded here via News.js -->
        </div>

        <div id="loading-spinner" class="text-center py-5" style="display: none;">
            <div class="spinner-grow text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="text-muted mt-3">กำลังโหลดข่าวสารเพิ่มเติม...</p>
        </div>

    </div>
</div>