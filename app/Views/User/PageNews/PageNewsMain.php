<div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s"
    style="visibility: visible; animation-delay: 0.1s; animation-name: fadeIn;background: linear-gradient(rgba(0, 0, 0, .5), rgba(0, 0, 0, .5)),url(uploads/background/bg-news.jpg), center no-repeat; background-size: cover;background-position: bottom;">
    <div class="container text-center py-5">
        <h1 class="display-4 text-white  slideInDown mb-3">สกจ. ประชาสัมพันธ์</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                <li class="breadcrumb-item text-primary active" aria-current="page">สกจ. ประชาสัมพันธ์</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-xxl py-5">
    <div class="container">

        <form method='get' action="<?=base_url('News')?>" id="searchForm" autocomplete="off">
            <div class="input-group mb-3 position-relative">
                <input type="text" class="form-control form-control-lg" id="searchInput" name='search' value='<?= $search ?>'
                    placeholder="ค้นหาข่าวที่นี่...">
                <button type="submit" class="input-group-text btn-success"><i class="bi bi-search me-2"></i>
                    ค้นหา</button>
                <div id="suggestions-list" class="list-group position-absolute w-100"></div>
            </div>
        </form>

        <style>
            /*
                เพื่อให้การ์ดข่าวมีความสูงเท่ากันในแต่ละแถว
                JavaScript ที่โหลดข่าวควรสร้าง HTML ที่มีโครงสร้างแบบ Bootstrap Card
                และเพิ่มคลาส `h-100` ให้กับ .card
                ตัวอย่าง:
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100">
                        <img class="card-img-top" src="..." alt="...">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">...</h5>
                            <p class="card-text">...</p>
                            <a href="#" class="btn btn-primary mt-auto">Read More</a>
                        </div>
                    </div>
                </div>
            */
            #suggestions-list {
                z-index: 1000;
                top: 100%; /* Position it right below the input */
                background-color: #ffffff; /* White background */
                border: 1px solid #ced4da; /* Standard bootstrap border */
                border-top: none; /* Remove top border to connect with input */
                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            }
            .list-group-item-action {
                cursor: pointer;
            }
            .highlight {
                background-color: #fff3cd; /* A light yellow highlight */
                font-weight: bold;
            }
            .card-img-top {
                width: 100%;
                height: 200px;
                object-fit: cover;
            }
            .card {
                border: none; 
                border-radius: 15px; 
                background-color: #eef7ff; /* สีฟ้าพาสเทลที่เข้ากับธีม */
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15); 
                transition: all 0.35s cubic-bezier(.25,.8,.25,1);
                outline: 0px solid rgba(13, 110, 253, 0);
            }
            .card:hover {
                transform: translateY(-12px);
                background-color: #ffffff; /* เปลี่ยนเป็นสีขาวเมื่อชี้ */
                box-shadow: 0 20px 45px rgba(0, 0, 0, 0.25), 0 0 30px rgba(13, 110, 253, 0.35);
                outline: 3px solid rgba(13, 110, 253, 0.5);
                z-index: 10;
            }
            .card-title a {
                color: inherit; /* ให้ลิงก์ใน card-title ใช้สีเดียวกับ parent */
                text-decoration: none; /* เอาขีดเส้นใต้ออก */
            }
            .card-title a:hover {
                text-decoration: underline; /* เพิ่มขีดเส้นใต้เมื่อชี้ */
            }
            .load-more {
                cursor: pointer;
                margin: 20px auto;
                padding: 10px 20px;
                background-color: #007bff;
                color: white;
                text-align: center;
                border-radius: 0.25rem;
                display: table;
            }
        </style>

        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h6 class="section-title bg-white text-center text-primary px-3">ข่าวประชาสัมพันธ์</h6>
            <h1 class="display-6 mb-4">ข่าวสารและกิจกรรม</h1>
        </div>

        <!-- The #grid div will be populated by JavaScript.
             It should be a bootstrap row to layout the news cards correctly. -->
        <div class="row g-4" id="grid">
            <!-- News items will be loaded here -->
        </div>

        <div id="loading-spinner" class="text-center mt-4" style="display: none;">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

    </div>
</div>