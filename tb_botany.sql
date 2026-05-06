CREATE TABLE IF NOT EXISTS tb_botany (
    botany_id INT AUTO_INCREMENT PRIMARY KEY,
    botany_name_th VARCHAR(255) NOT NULL,
    botany_name_en VARCHAR(255),
    botany_science_name VARCHAR(255),
    botany_family VARCHAR(255),
    botany_description TEXT,
    botany_benefit TEXT,
    botany_image VARCHAR(255),
    botany_type VARCHAR(100),
    botany_location VARCHAR(255),
    botany_status ENUM('active', 'inactive') DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO tb_botany (botany_name_th, botany_name_en, botany_science_name, botany_family, botany_description, botany_benefit, botany_type, botany_location) VALUES
('ราชพฤกษ์', 'Golden Shower Tree', 'Cassia fistula L.', 'FABACEAE', 'เป็นไม้ยืนต้นขนาดกลาง มีดอกสีเหลืองอร่ามเป็นช่อห้อยระย้า', 'รากใช้ถ่ายพยาธิ เนื้อในฝักระบายท้อง', 'ไม้ยืนต้น', 'หน้าอาคารเรียน 1'),
('บัวหลวง', 'Sacred Lotus', 'Nelumbo nucifera Gaertn.', 'NELUMBONACEAE', 'พรรณไม้น้ำที่มีความสำคัญในทางศาสนาและวัฒนธรรมไทย', 'รากและเมล็ดช่วยบำรุงหัวใจ', 'ไม้น้ำ', 'สระน้ำหน้าอาคาร'),
('กุหลาบ', 'Rose', 'Rosa spp.', 'ROSACEAE', 'ไม้พุ่มขนาดเล็ก มีหนามตามลำต้น ดอกมีกลิ่นหอมและมีหลายสี', 'ดอกสดช่วยบำรุงหัวใจและให้กลิ่นหอม', 'ไม้พุ่ม', 'สวนหย่อมข้างห้องสมุด');
