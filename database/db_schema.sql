
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


CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- sung_kyung_univ.password_reset_tokens definition

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- sung_kyung_univ.password_resets definition

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- sung_kyung_univ.personal_access_tokens definition

CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- sung_kyung_univ.users definition

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

show tables

select * from `users`

select * from `users` where `id` = 6 limit 1

INSERT INTO sung_kyung_univ.users (name,email,email_verified_at,password,remember_token,created_at,updated_at) VALUES
	 ('이동관','dongkale@naver.com',NULL,'$2y$12$kcDNZxsaEWj9LtD.cmRUOeBTByg7FBcZHs7ZX6eXgOc4perP4.QJS','l824SjuqdMeAFeC6OEBtCMKLFrAGQcxvKsGRV1CQVFxIJjuqfiUP7n4BwfPQ','2024-02-21 14:27:39','2024-02-21 14:27:39'),
	 ('최현동','hdchoi@lennon.co.kr',NULL,'$2y$12$4yvfJ0m/.kzN9HjAW8wXbeR3VOXcnWyIN06yKck.ze6MZkFfm9M5.','4IBASfzMi7G8Uq6gXXp2jBnDdWBObIOzxKCAOzVACj4Ozf1Z8fmcp1eDr13L','2024-03-06 19:08:22','2024-03-06 19:08:22'),
	 ('김주아','jooa04@bible.ac.kr',NULL,'$2y$12$pZ/i/QBkPwkZjgqSNBOnYe7ZAnYt.4dg95CBkFhO0Dpxih0wgEgFK','nJA7YVhSmMInjb4wzfNQjnqv8PkkkqejVTuo7KaKluFUYY1hLOJxe6GIRE0x','2024-03-29 16:01:17','2024-03-29 16:01:17'),
	 ('이동관2','test2@naver.com',NULL,'$2y$12$Nxl.nLQTXOZN8kUYtpb9EuNRJA3nKv6zGKET6b4ztcFNvIH2NC8mS',NULL,'2024-03-29 17:01:24','2024-03-29 22:34:27'),
	 ('한동현','dhhan@lennon.co.kr',NULL,'$2y$12$6mqBK.7hSRP9F4nYdgTtneEz6yszCsqeKNhTrYDvoXD3NDm6YwnMi',NULL,'2024-04-23 17:57:48','2024-04-23 17:57:48'),
	 ('이동관3','dongkale@exp.com',NULL,'$2y$12$cFs.rk.RRSf248H3E0O4FOQz00wigl/vHaifxNQXJNMlXTDPuDeS2',NULL,'2024-05-31 12:27:13','2024-05-31 12:27:13');

INSERT INTO sung_kyung_univ.members (ids,email,name,sex,birth_date,mobile_phone,play_seq_no,login_flag,try_login_at,last_login_at,created_at,updated_at) VALUES
	 ('016','DA5F6D315B7DC6C36B8D330F1EC4CDC3','16번유저','F','19600101','40EEBD74DD26D436172B4F0D7E75316D',383,1,'2024-06-21 18:47:27','2024-06-21 13:06:41','2024-02-23 11:58:45','2024-06-21 18:47:27');
