<style>
    .botany-container {
        background-color: #fffafb;
        background-image: 
            radial-gradient(at 0% 0%, rgba(251, 126, 156, 0.05) 0px, transparent 50%),
            radial-gradient(at 100% 0%, rgba(36, 159, 253, 0.05) 0px, transparent 50%);
        padding: 80px 0;
        min-height: 100vh;
    }

    .botany-header {
        margin-bottom: 60px;
        text-align: center;
    }

    .botany-header h1 {
        font-weight: 800;
        color: #252525;
        font-size: 2.8rem;
        margin-bottom: 15px;
        background: linear-gradient(45deg, #fb7e9c, #249ffd);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .botany-header .divider {
        width: 100px;
        height: 5px;
        background: linear-gradient(90deg, #fb7e9c, #249ffd);
        margin: 0 auto;
        border-radius: 10px;
    }

    .botany-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 25px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        height: 100%;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }

    .botany-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(251, 126, 156, 0.15);
        border-color: #fb7e9c;
    }

    .botany-img-wrapper {
        height: 220px;
        position: relative;
        overflow: hidden;
    }

    .botany-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .botany-card:hover .botany-img-wrapper img {
        transform: scale(1.1);
    }

    .botany-type-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(255, 255, 255, 0.9);
        color: #fb7e9c;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .botany-content {
        padding: 25px;
    }

    .botany-name-th {
        font-weight: 700;
        font-size: 1.4rem;
        color: #fb7e9c;
        margin-bottom: 5px;
    }

    .botany-name-en {
        font-style: italic;
        color: #249ffd;
        font-size: 0.9rem;
        margin-bottom: 15px;
        display: block;
    }

    .botany-info {
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 20px;
    }

    .botany-info i {
        color: #249ffd;
        margin-right: 5px;
    }

    .btn-botany {
        background: linear-gradient(45deg, #fb7e9c, #ff9aaf);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 10px 20px;
        font-weight: 600;
        width: 100%;
        transition: all 0.3s ease;
    }

    .btn-botany:hover {
        background: linear-gradient(45deg, #ff9aaf, #fb7e9c);
        color: white;
        box-shadow: 0 5px 15px rgba(251, 126, 156, 0.3);
    }

    .search-box {
        max-width: 600px;
        margin: 0 auto 50px;
    }

    .search-box .form-control {
        border-radius: 15px;
        padding: 15px 25px;
        border: 2px solid rgba(251, 126, 156, 0.2);
        background: rgba(255, 255, 255, 0.9);
        box-shadow: 0 5px 15px rgba(0,0,0,0.02);
    }

    .search-box .form-control:focus {
        border-color: #fb7e9c;
        box-shadow: 0 5px 20px rgba(251, 126, 156, 0.15);
    }

    @media (max-width: 768px) {
        .botany-header h1 { font-size: 2rem; }
    }
</style>

<div class="botany-container">
    <div class="container">
        <div class="botany-header animate__animated animate__fadeIn">
            <h1>คลังข้อมูลพรรณไม้</h1>
            <div class="divider"></div>
            <p class="mt-3 text-muted">ฐานข้อมูลทรัพยากรท้องถิ่น งานสวนพฤกษศาสตร์โรงเรียน</p>
        </div>

        <div class="search-box animate__animated animate__fadeInUp">
            <div class="input-group">
                <input type="text" id="plantSearch" class="form-control" placeholder="ค้นหาชื่อพรรณไม้..." aria-label="Search">
                <span class="input-group-text bg-white border-0" style="border-radius: 0 15px 15px 0;">
                    <i class="bi bi-search text-success"></i>
                </span>
            </div>
        </div>

        <div class="row g-4" id="plantContainer">
            <?php foreach ($plants as $plant) : ?>
                <div class="col-lg-4 col-md-6 plant-item animate__animated animate__zoomIn">
                    <div class="botany-card">
                        <div class="botany-img-wrapper">
                            <?php 
                                $img_path = base_url('uploads/botany/' . ($plant->botany_image ?: 'default-plant.jpg'));
                            ?>
                            <img src="<?= $img_path ?>" alt="<?= $plant->botany_name_th ?>" onerror="this.src='https://images.unsplash.com/photo-1545239351-ef056c0b011a?q=80&w=800&auto=format&fit=crop'">
                            <?php if ($plant->botany_type) : ?>
                                <span class="botany-type-badge"><?= $plant->botany_type ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="botany-content">
                            <h3 class="botany-name-th"><?= $plant->botany_name_th ?></h3>
                            <span class="botany-name-en"><?= $plant->botany_name_en ?></span>
                            
                            <div class="botany-info">
                                <div class="mb-1">
                                    <i class="bi bi-tag-fill"></i> <strong>วงศ์:</strong> <?= $plant->botany_family ?: 'ไม่ระบุ' ?>
                                </div>
                                <div>
                                    <i class="bi bi-geo-alt-fill"></i> <strong>ที่ตั้ง:</strong> <?= $plant->botany_location ?: 'ในโรงเรียน' ?>
                                </div>
                            </div>

                            <a href="<?= base_url('botany/detail/' . $plant->botany_id) ?>" class="btn btn-botany">
                                <i class="bi bi-info-circle me-2"></i>ดูรายละเอียด
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (empty($plants)) : ?>
            <div class="text-center py-5">
                <i class="bi bi-tree-fill display-1 text-muted opacity-25"></i>
                <p class="mt-3 text-muted">ยังไม่มีข้อมูลพรรณไม้ในระบบ</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    document.getElementById('plantSearch').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const items = document.querySelectorAll('.plant-item');
        
        items.forEach(item => {
            const nameTh = item.querySelector('.botany-name-th').textContent.toLowerCase();
            const nameEn = item.querySelector('.botany-name-en').textContent.toLowerCase();
            
            if (nameTh.includes(searchTerm) || nameEn.includes(searchTerm)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });
</script>
