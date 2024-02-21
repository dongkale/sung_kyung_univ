
-- members

CREATE TABLE `members` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `ids` varchar(50) COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '유저 구분코드: 001, 002, ...',
    `email` varchar(255) COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '이메일',
    `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''  COMMENT '이름',    
    `sex` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '1:남성, 0:여성',
    `birth_date` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '생년월일(YYYYMMDD)',
    `mobile_phone` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '휴대폰번호',
    `login_flag` tinyint(1) DEFAULT '0' COMMENT '로그인 여부(1:로그인중, 0: 미로그인)',
    `last_login_at` datetime DEFAULT NULL COMMENT '마지막 로그인 날짜',
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),    
    INDEX `IX_members_ids`(`ids`) USING BTREE,
    INDEX `IX_members_name`(`name`) USING BTREE,
    INDEX `IX_members_sex`(`sex`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- CREATE TABLE `ids_pool` (
--     `id` bigint unsigned NOT NULL,
--     `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
--     `updated_at` timestamp NULL DEFAULT NULL,
--     PRIMARY KEY (`id`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;