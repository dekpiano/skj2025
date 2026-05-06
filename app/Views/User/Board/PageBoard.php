<style>
    .board-container {
        background-color: #f8faff;
        background-image: 
            radial-gradient(at 0% 0%, rgba(251, 126, 156, 0.05) 0px, transparent 50%),
            radial-gradient(at 100% 0%, rgba(36, 159, 253, 0.05) 0px, transparent 50%);
        padding: 80px 0;
        min-height: 100vh;
    }

    .board-header {
        margin-bottom: 60px;
        text-align: center;
    }

    .board-header h1 {
        font-weight: 800;
        color: #1a2a4d;
        font-size: 2.8rem;
        margin-bottom: 15px;
        background: linear-gradient(45deg, #1a2a4d, #249ffd);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .board-header .divider {
        width: 100px;
        height: 5px;
        background: linear-gradient(90deg, #FB7E9C, #249ffd);
        margin: 0 auto;
        border-radius: 10px;
    }

    .board-row-title {
        font-weight: 700;
        color: #444;
        text-align: center;
        margin: 40px 0 30px;
        position: relative;
        padding-bottom: 15px;
    }

    .board-row-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 50px;
        height: 2px;
        background: rgba(0,0,0,0.1);
    }

    .board-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 20px;
        padding: 20px;
        text-align: center;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        width: 100%;
        height: 100%;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        display: flex; 
        flex-direction: column;
        align-items: center;
    }

    .board-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        background: rgba(255, 255, 255, 0.95);
        border-color: #FB7E9C;
    }

    .board-img-wrapper {
        /* width: 160px; */
        height: 160px;
        margin: 0 auto 15px;
        border-radius: 50%;
        padding: 6px;
        background: linear-gradient(135deg, #FB7E9C 0%, #249ffd 100%);
        position: relative;
        box-shadow: 0 8px 15px rgba(0,0,0,0.08);
    }

    .board-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #fff;
    }

    .board-name {
        font-weight: 700;
        font-size: 1.15rem;
        color: #1a2a4d;
        margin-bottom: 4px;
        white-space: nowrap; /* ห้ามขึ้นบรรทัดใหม่ */
        overflow: hidden;    /* ซ่อนส่วนที่เกิน */
        display: block;      /* ให้เป็น block เพื่อคำนวณความกว้าง */
        transition: font-size 0.2s ease;
    }

    .board-position {
        font-weight: 600;
        color: #FB7E9C;
        font-size: 1rem;
        margin-bottom: 15px;
        display: block;
    }

    .board-type {
        display: inline-block;
        padding: 5px 15px;
        background: rgba(36, 159, 253, 0.1);
        color: #249ffd;
        border-radius: 30px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    /* จำกัดหน้ากว้างประธาน */
    .row-cols-1 .col {
        max-width: 450px;
    }

    @media (max-width: 991px) {
        .board-header h1 { font-size: 2.2rem; }
    }

    @media (max-width: 575px) {
        .col-member { width: 100% !important; }
        .board-img-wrapper { width: 150px; height: 150px; }
    }
</style>

<div class="board-container">
    <div class="container">
        <div class="board-header animate__animated animate__fadeIn">
            <h1>ทำเนียบคณะกรรมการสถานศึกษา</h1>
            <div class="divider"></div>
        </div>

        <?php foreach ($board_rows as $row) : ?>
            <?php if (!empty($row->members)) : ?>
                <div class="board-section mb-4">

                    <div class="row g-4 justify-content-center row-cols-1 row-cols-sm-2 row-cols-md-<?= $row->row_cols ?>">
                        <?php foreach ($row->members as $member) : ?>
                            <div class="col d-flex justify-content-center">
                                <div class="board-card animate__animated animate__zoomIn">
                                    <div class="board-img-wrapper">
                                        <?php 
                                            $img_path = "https://personnel.skj.ac.th/uploads/admin/Board/" . ($member->board_img ?: 'default.png');
                                        ?>
                                        <img src="<?= $img_path ?>" alt="<?= $member->board_firstname ?>" onerror="this.src='<?= base_url('assets/img/logo/Logo-nav.png') ?>'">
                                    </div>
                                    <h4 class="board-name"><?= $member->board_prefix . $member->board_firstname . ' ' . $member->board_lastname ?></h4>
                                    <span class="board-position"><?= $member->board_position ?></span>
                                    <?php if ($member->board_type) : ?>
                                        <span class="board-type"><?= $member->board_type ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>

        <?php if (empty($board_rows)) : ?>
            <div class="text-center py-5">
                <i class="bi bi-people-fill display-1 text-muted opacity-25"></i>
                <p class="mt-3 text-muted">ไม่พบข้อมูลคณะกรรมการสถานศึกษาในขณะนี้</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    function autoShrinkText() {
        const names = document.querySelectorAll('.board-name');
        
        names.forEach(name => {
            const container = name.closest('.board-card');
            if (!container) return;
            
            // คืนค่าขนาดเดิมก่อนคำนวณ
            name.style.fontSize = '1.15rem';
            
            // คำนวณความกว้างที่ใช้ได้ (ความกว้างการ์ด - padding)
            // Padding ของการ์ดคือ 20px ซ้าย-ขวา
            const padding = 40; 
            const maxWidth = container.offsetWidth - padding;
            
            let currentSize = 1.15; // rem
            
            // วนลูปลดขนาดจนกว่าจะพอดี หรือจนถึงขนาดขั้นต่ำ (0.7rem)
            // ใช้ scrollWidth เพื่อดูความกว้างจริงของเนื้อหาข้างใน
            while (name.scrollWidth > (maxWidth + 5) && currentSize > 0.7) {
                currentSize -= 0.05;
                name.style.fontSize = currentSize + 'rem';
            }
        });
    }

    // ทำงานเมื่อโหลดหน้าเว็บ
    window.addEventListener('load', autoShrinkText);
    // ทำงานเมื่อมีการขยายขนาดหน้าจอ
    window.addEventListener('resize', autoShrinkText);
    
    // เรียกทำงานทันทีเผื่อกรณีรูปภาพโหลดช้า
    setTimeout(autoShrinkText, 500);
</script>
