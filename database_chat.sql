-- ==========================================================
-- SKJ LIVE CHAT SYSTEM - DATABASE SCHEMA (FOR skj2025)
-- ==========================================================

-- 1. Chat Sessions Table (ตารางห้องสนทนา)
CREATE TABLE IF NOT EXISTS `tb_chat_sessions` (
  `session_id` int(11) NOT NULL AUTO_INCREMENT,
  `session_token` varchar(64) NOT NULL UNIQUE,
  `user_name` varchar(150) NOT NULL,
  `user_tel` varchar(50) DEFAULT NULL,
  `user_ip` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `telegram_last_msg_id` varchar(50) DEFAULT NULL,
  `status` enum('active','closed') DEFAULT 'active',
  `unread_user_count` int(11) DEFAULT 0,
  `unread_admin_count` int(11) DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `idx_token` (`session_token`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Chat Messages Table (ตารางข้อความสนทนา)
CREATE TABLE IF NOT EXISTS `tb_chat_messages` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` int(11) NOT NULL,
  `sender_type` enum('user','admin','system') NOT NULL,
  `sender_name` varchar(150) DEFAULT NULL,
  `message` text NOT NULL,
  `attachment_url` varchar(255) DEFAULT NULL,
  `attachment_type` varchar(50) DEFAULT NULL,
  `is_bot` tinyint(1) DEFAULT 0,
  `telegram_msg_id` varchar(50) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`message_id`),
  KEY `idx_session` (`session_id`),
  KEY `idx_sender` (`sender_type`),
  KEY `idx_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Telegram Config Table (ตารางตั้งค่าบอท Telegram สำหรับแจ้งเตือนและตอบกลับ 2 ทาง)
CREATE TABLE IF NOT EXISTS `tb_telegram_config` (
  `telegram_id` int(11) NOT NULL AUTO_INCREMENT,
  `telegram_bot_token` varchar(255) DEFAULT NULL,
  `telegram_chat_id` varchar(100) DEFAULT NULL,
  `telegram_chat_title` varchar(255) DEFAULT NULL,
  `telegram_status` enum('on','off') DEFAULT 'on',
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`telegram_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ข้อมูลตั้งค่าเริ่มต้น (หากมี Bot Token เดิม สามารถแทนที่ได้)
INSERT INTO `tb_telegram_config` (`telegram_id`, `telegram_bot_token`, `telegram_chat_id`, `telegram_chat_title`, `telegram_status`, `updated_at`)
VALUES (1, '', '', 'SKJ Live Chat Group', 'on', NOW())
ON DUPLICATE KEY UPDATE `updated_at` = NOW();
