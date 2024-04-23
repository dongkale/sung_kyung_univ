
-- members

CREATE TABLE `members` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `ids` varchar(50) COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '유저 구분코드: 001, 002, ...',
    `email` varchar(255) COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '이메일',
    `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''  COMMENT '이름',
    `sex` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '1:남성, 0:여성',
    `birth_date` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '생년월일(YYYYMMDD)',
    `mobile_phone` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '휴대폰번호',
    `play_seq_no` bigint unsigned DEFAULT '0' COMMENT '사용자 플레이 순서값',
    `login_flag` tinyint(1) DEFAULT '0' COMMENT '로그인 여부(1:로그인중, 0: 미로그인)',
    `try_login_at` datetime DEFAULT NULL COMMENT '로그인 시도 날짜',
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

-- plays

CREATE TABLE `plays` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,

    `member_id` bigint unsigned NOT NULL COMMENT 'members 테이블 id',
    `seq_no` bigint unsigned NOT NULL COMMENT 'members seq_id',

    `start_date` timestamp NULL DEFAULT NULL COMMENT '전체 시작 시간',
    `end_date` timestamp NULL DEFAULT NULL COMMENT '전체 종료 시간',
    `total_time` bigint unsigned NOT NULL DEFAULT 0 COMMENT '전체 플레이 시간',

    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NULL DEFAULT NULL,

    PRIMARY KEY (`id`),
    UNIQUE INDEX `UIX_plays_member_id_seq_no`(`member_id`, `seq_no`) USING BTREE,
    INDEX `IX_plays_seq_no`(`seq_no`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `play_details` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,

    `play_id` bigint unsigned NOT NULL,

    `ground` varchar(255) COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '장소',
    `step` bigint unsigned NOT NULL DEFAULT 0 COMMENT '스텝',
    `actual_play_time` bigint signed NOT NULL DEFAULT 0 COMMENT '실제 플레이 시간',
    `false_count` bigint unsigned NOT NULL DEFAULT 0 COMMENT '실패 횟수',
    `start_date` timestamp NULL DEFAULT NULL COMMENT '시작 시간',
    `end_date` timestamp NULL DEFAULT NULL COMMENT '종료 시간',

    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NULL DEFAULT NULL,

    PRIMARY KEY (`id`),
    INDEX `IX_play_details_play_id`(`play_id`) USING BTREE,
    INDEX `IX_play_details_ground`(`ground`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- play_logs
CREATE TABLE `play_logs` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,

    `member_id` bigint unsigned NOT NULL COMMENT 'members 테이블 id',
    `seq_no` bigint unsigned NOT NULL COMMENT 'members seq_id',

    `stat_data` JSON COMMENT '통계 데이터(JSON)',

    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),
    INDEX `IX_play_logs_member_id`(`member_id`) USING BTREE,
    INDEX `IX_play_logs_seq_no`(`seq_no`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
