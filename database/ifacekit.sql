/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50733 (5.7.33)
 Source Host           : localhost:3306
 Source Schema         : ifacekit

 Target Server Type    : MySQL
 Target Server Version : 50733 (5.7.33)
 File Encoding         : 65001

 Date: 22/06/2023 16:09:21
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for c_mapping
-- ----------------------------
DROP TABLE IF EXISTS `c_mapping`;
CREATE TABLE `c_mapping`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NULL DEFAULT NULL,
  `source_schema_id` int(11) NULL DEFAULT NULL,
  `target_schema_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of c_mapping
-- ----------------------------
INSERT INTO `c_mapping` VALUES (1, 2, 2, 7);
INSERT INTO `c_mapping` VALUES (2, 2, 1, 8);
INSERT INTO `c_mapping` VALUES (3, 2, 3, 9);
INSERT INTO `c_mapping` VALUES (4, 2, 4, 10);
INSERT INTO `c_mapping` VALUES (5, 2, 5, 11);
INSERT INTO `c_mapping` VALUES (6, 2, 6, 12);

-- ----------------------------
-- Table structure for c_service_schemas
-- ----------------------------
DROP TABLE IF EXISTS `c_service_schemas`;
CREATE TABLE `c_service_schemas`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NULL DEFAULT NULL,
  `parent_id` int(11) NULL DEFAULT NULL,
  `field_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `field_type` enum('string','date','datetime','datetimezone','int','decimal','bool','header') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `field_length` int(3) NULL DEFAULT NULL,
  `date_format` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `thousand_sep` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `decimal_sep` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `bool_true` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `is_multiple` enum('Y','N') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'N',
  `is_required` enum('Y','N') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'N',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of c_service_schemas
-- ----------------------------
INSERT INTO `c_service_schemas` VALUES (1, 1, NULL, 'nama', 'string', 30, NULL, NULL, NULL, NULL, 'N', 'Y');
INSERT INTO `c_service_schemas` VALUES (2, 1, NULL, 'alamat', 'string', 100, NULL, NULL, NULL, NULL, 'N', 'Y');
INSERT INTO `c_service_schemas` VALUES (3, 1, NULL, 'tgl_lahir', 'date', NULL, 'DD-MM-YYYY', NULL, NULL, NULL, 'N', 'N');
INSERT INTO `c_service_schemas` VALUES (4, 1, NULL, 'items', 'header', NULL, NULL, NULL, NULL, NULL, 'Y', 'N');
INSERT INTO `c_service_schemas` VALUES (5, 1, 4, 'id_barang', 'int', NULL, NULL, NULL, NULL, NULL, 'N', 'N');
INSERT INTO `c_service_schemas` VALUES (6, 1, 4, 'nama_barang', 'string', 100, NULL, NULL, NULL, NULL, 'N', 'N');
INSERT INTO `c_service_schemas` VALUES (7, 2, NULL, 'nama', 'string', 30, NULL, NULL, NULL, NULL, 'N', 'Y');
INSERT INTO `c_service_schemas` VALUES (8, 2, NULL, 'alamat', 'string', 100, NULL, NULL, NULL, NULL, 'N', 'Y');
INSERT INTO `c_service_schemas` VALUES (9, 2, NULL, 'tgl_lahir', 'date', NULL, 'YYYY-MM-DD', NULL, NULL, NULL, 'N', 'N');
INSERT INTO `c_service_schemas` VALUES (10, 2, NULL, 'items', 'header', NULL, NULL, NULL, NULL, NULL, 'Y', 'N');
INSERT INTO `c_service_schemas` VALUES (11, 2, 10, 'id_barang', 'int', NULL, NULL, NULL, NULL, NULL, 'N', 'N');
INSERT INTO `c_service_schemas` VALUES (12, 2, 10, 'nama_barang', 'string', 100, NULL, NULL, NULL, NULL, 'N', 'N');
INSERT INTO `c_service_schemas` VALUES (13, 13, NULL, 'ID_BARANG', 'bool', 211, NULL, NULL, NULL, NULL, 'N', 'N');
INSERT INTO `c_service_schemas` VALUES (14, 13, NULL, 'NAMA', 'header', 233, NULL, NULL, NULL, NULL, 'N', 'N');
INSERT INTO `c_service_schemas` VALUES (15, 13, NULL, 'SPESIFIKASI', 'header', 233, NULL, NULL, NULL, NULL, 'Y', 'N');
INSERT INTO `c_service_schemas` VALUES (16, 13, 13, 'IMG', 'string', 30, NULL, NULL, NULL, NULL, 'N', 'N');

-- ----------------------------
-- Table structure for c_services
-- ----------------------------
DROP TABLE IF EXISTS `c_services`;
CREATE TABLE `c_services`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `service_type` enum('R','S') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `service_adapter` enum('rest','web-service','file') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `tcq_source` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Berisi tabel tcq_*_r, ',
  `tcq_target` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Berisi tabel tcq_*_s',
  `endpoint` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `endpoint_method` enum('POST','GET','PUT','DELETE') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `created_by` int(11) NULL DEFAULT NULL,
  `created_ip` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `created_ua` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int(11) NULL DEFAULT NULL,
  `updated_ip` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `updated_ua` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `loop_interval` int(11) NULL DEFAULT 2000,
  `set` int(5) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of c_services
-- ----------------------------
INSERT INTO `c_services` VALUES (1, 'test', 'R', 'rest', 'N', NULL, 'tcq_test_r', 'http://localhost:3000/rec', 'POST', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2000, NULL);
INSERT INTO `c_services` VALUES (2, 'test-s', 'S', 'rest', 'N', 'tcq_test_r', 'tcq_test_s', 'http://localhost:3000/rec', 'POST', '2023-06-22 11:06:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5000, 1);
INSERT INTO `c_services` VALUES (3, 'billing', 'R', 'rest', 'Y', NULL, 'tcq_billing_r', 'view-source:file:///E:/laragon/www/template/dist/material/tables-datatables.html', 'POST', '2023-06-21 13:24:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 122222, NULL);
INSERT INTO `c_services` VALUES (4, 'billing000', 'S', 'rest', 'Y', NULL, 'tcq_billing000_s', 'https://developer.chrome.com/blog/removing-document-write/', 'POST', '2023-06-21 13:47:55', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 20000, NULL);
INSERT INTO `c_services` VALUES (5, 'test_tabel', 'S', 'rest', 'Y', 'Select--', 'tcq_test_tabel_s', 'view-source:file:///E:/laragon/www/template/dist/material/tables-datatables.html', 'POST', '2023-06-21 13:53:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 23232, NULL);
INSERT INTO `c_services` VALUES (6, 'ur', 'S', 'rest', 'Y', 'tcq_billing_r', 'tcq_ur_s', 'https://developer.chrome.com/blog/removing-document-write/', 'POST', '2023-06-21 13:54:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 222222, NULL);
INSERT INTO `c_services` VALUES (7, 'eerrererer', 'R', 'rest', 'Y', NULL, 'tcq_eerrererer_r', 'https://developer.chrome.com/blog/removing-document-write/', 'POST', '2023-06-21 14:24:13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 222, 1);
INSERT INTO `c_services` VALUES (8, 'weewewee', 'R', 'rest', 'Y', NULL, 'tcq_weewewee_r', 'view-source:file:///E:/laragon/www/template/dist/material/tables-datatables.html', 'POST', '2023-06-21 14:24:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2222, 1);
INSERT INTO `c_services` VALUES (9, 'billing232323232', 'R', 'rest', 'Y', NULL, 'tcq_billing232323232_r', 'https://developer.chrome.com/blog/removing-document-write/', 'POST', '2023-06-21 14:43:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3333, 1);
INSERT INTO `c_services` VALUES (10, '443tttttt', 'R', 'rest', 'Y', NULL, 'tcq_443tttttt_r', 'https://developer.chrome.com/blog/removing-document-write/', 'GET', '2023-06-21 14:44:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 22222, 1);
INSERT INTO `c_services` VALUES (11, 'billing0001', 'R', 'rest', 'Y', NULL, 'tcq_billing0001_r', 'https://developer.chrome.com/blog/removing-document-write/', 'POST', '2023-06-21 14:47:25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 222, 1);
INSERT INTO `c_services` VALUES (12, 'billing1212', 'R', 'rest', 'Y', NULL, 'tcq_billing1212_r', 'https://developer.chrome.com/blog/removing-document-write/', 'POST', '2023-06-21 14:48:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 222, 1);
INSERT INTO `c_services` VALUES (13, 'test_tabel11', 'R', 'rest', 'Y', NULL, 'tcq_test_tabel11_r', 'https://developer.chrome.com/blog/removing-document-write/', 'POST', '2023-06-21 14:48:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2222, 1);

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for m_type_field
-- ----------------------------
DROP TABLE IF EXISTS `m_type_field`;
CREATE TABLE `m_type_field`  (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `field` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_type_field
-- ----------------------------
INSERT INTO `m_type_field` VALUES (1, 'string');
INSERT INTO `m_type_field` VALUES (2, 'date');
INSERT INTO `m_type_field` VALUES (3, 'datetime');
INSERT INTO `m_type_field` VALUES (4, 'int');
INSERT INTO `m_type_field` VALUES (5, 'decimal');
INSERT INTO `m_type_field` VALUES (6, 'bool');
INSERT INTO `m_type_field` VALUES (7, 'header');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (3, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (4, '2019_12_14_000001_create_personal_access_tokens_table', 2);

-- ----------------------------
-- Table structure for myguests
-- ----------------------------
DROP TABLE IF EXISTS `myguests`;
CREATE TABLE `myguests`  (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `firstname` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `lastname` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `reg_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of myguests
-- ----------------------------

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  INDEX `password_resets_email_index`(`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token`) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type`, `tokenable_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for tcq_443tttttt_r
-- ----------------------------
DROP TABLE IF EXISTS `tcq_443tttttt_r`;
CREATE TABLE `tcq_443tttttt_r`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `receive_at` datetime NULL DEFAULT NULL,
  `processed_at` datetime NULL DEFAULT NULL,
  `status` enum('1','2','3') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `error_message` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `response_message` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `payload` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tcq_443tttttt_r
-- ----------------------------

-- ----------------------------
-- Table structure for tcq_billing0001_r
-- ----------------------------
DROP TABLE IF EXISTS `tcq_billing0001_r`;
CREATE TABLE `tcq_billing0001_r`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `receive_at` datetime NULL DEFAULT NULL,
  `processed_at` datetime NULL DEFAULT NULL,
  `status` enum('1','2','3') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `error_message` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `response_message` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `payload` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tcq_billing0001_r
-- ----------------------------

-- ----------------------------
-- Table structure for tcq_billing000_s
-- ----------------------------
DROP TABLE IF EXISTS `tcq_billing000_s`;
CREATE TABLE `tcq_billing000_s`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `receive_at` datetime NULL DEFAULT NULL,
  `processed_at` datetime NULL DEFAULT NULL,
  `status` enum('1','2','3') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `error_message` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `response_message` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `payload` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tcq_billing000_s
-- ----------------------------

-- ----------------------------
-- Table structure for tcq_billing1212_r
-- ----------------------------
DROP TABLE IF EXISTS `tcq_billing1212_r`;
CREATE TABLE `tcq_billing1212_r`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `receive_at` datetime NULL DEFAULT NULL,
  `processed_at` datetime NULL DEFAULT NULL,
  `status` enum('1','2','3') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `error_message` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `response_message` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `payload` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tcq_billing1212_r
-- ----------------------------

-- ----------------------------
-- Table structure for tcq_billing232323232_r
-- ----------------------------
DROP TABLE IF EXISTS `tcq_billing232323232_r`;
CREATE TABLE `tcq_billing232323232_r`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `receive_at` datetime NULL DEFAULT NULL,
  `processed_at` datetime NULL DEFAULT NULL,
  `status` enum('1','2','3') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `error_message` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `response_message` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `payload` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tcq_billing232323232_r
-- ----------------------------

-- ----------------------------
-- Table structure for tcq_billing_r
-- ----------------------------
DROP TABLE IF EXISTS `tcq_billing_r`;
CREATE TABLE `tcq_billing_r`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `receive_at` datetime NULL DEFAULT NULL,
  `processed_at` datetime NULL DEFAULT NULL,
  `status` enum('1','2','3') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `error_message` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `response_message` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `payload` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tcq_billing_r
-- ----------------------------

-- ----------------------------
-- Table structure for tcq_eerrererer_r
-- ----------------------------
DROP TABLE IF EXISTS `tcq_eerrererer_r`;
CREATE TABLE `tcq_eerrererer_r`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `receive_at` datetime NULL DEFAULT NULL,
  `processed_at` datetime NULL DEFAULT NULL,
  `status` enum('1','2','3') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `error_message` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `response_message` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `payload` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tcq_eerrererer_r
-- ----------------------------

-- ----------------------------
-- Table structure for tcq_test_r
-- ----------------------------
DROP TABLE IF EXISTS `tcq_test_r`;
CREATE TABLE `tcq_test_r`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `receive_at` datetime NULL DEFAULT NULL,
  `processed_at` datetime NULL DEFAULT NULL,
  `status` enum('1','2','3') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `error_message` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `response_message` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `payload` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tcq_test_r
-- ----------------------------
INSERT INTO `tcq_test_r` VALUES (1, '2023-06-14 15:01:27', NULL, '2', NULL, NULL, '{\"nama\":\"Dida Nurwandssa\",\"alamat\":\"Pandeglang\",\"tgl_lahir\":\"15-07-1993\",\"items\":[{\"id_barang\":2,\"nama_barang\":\"Pepsodent\"},{\"id_barang\":2,\"nama_barang\":\"Masako\"}]}');
INSERT INTO `tcq_test_r` VALUES (2, '2023-06-14 15:02:07', NULL, '2', NULL, NULL, '{\"nama\":\"Dida Nurwandssa\",\"alamat\":\"Pandeglang\",\"tgl_lahir\":\"15-07-1993\",\"items\":[{\"id_barang\":2,\"nama_barang\":\"Pepsodent\"},{\"id_barang\":2,\"nama_barang\":\"Masako\"}]}');
INSERT INTO `tcq_test_r` VALUES (3, '2023-06-14 15:35:40', NULL, '2', NULL, NULL, '{\"nama\":\"Dida Nurwandssa\",\"alamat\":\"Pandeglang\",\"tgl_lahir\":\"15-07-1993\",\"items\":[{\"id_barang\":2,\"nama_barang\":\"Pepsodent\"},{\"id_barang\":2,\"nama_barang\":\"Masako\"}]}');
INSERT INTO `tcq_test_r` VALUES (4, '2023-06-14 15:36:00', NULL, '2', NULL, NULL, '{\"nama\":\"Dida Nurwandssa\",\"alamat\":\"Pandeglang\",\"tgl_lahir\":\"15-07-1993\",\"items\":[{\"id_barang\":2,\"nama_barang\":\"Pepsodent\"},{\"id_barang\":2,\"nama_barang\":\"Masako\"}]}');
INSERT INTO `tcq_test_r` VALUES (5, '2023-06-14 15:36:06', NULL, '2', NULL, NULL, '{\"nama\":\"Dida Nurwandssa\",\"alamat\":\"Pandeglang\",\"tgl_lahir\":\"15-07-1993\",\"items\":[{\"id_barang\":2,\"nama_barang\":\"Pepsodent\"},{\"id_barang\":2,\"nama_barang\":\"Masako\"}]}');
INSERT INTO `tcq_test_r` VALUES (6, '2023-06-14 15:36:39', NULL, '2', NULL, NULL, '{\"nama\":\"Dida Nurwandssa\",\"alamat\":\"Pandeglang\",\"tgl_lahir\":\"15-07-1993\",\"items\":[{\"id_barang\":2,\"nama_barang\":\"Pepsodent\"},{\"id_barang\":2,\"nama_barang\":\"Masako\"}]}');
INSERT INTO `tcq_test_r` VALUES (7, '2023-06-14 15:40:45', NULL, '2', NULL, NULL, '{\"nama\":\"Dida Nurwandssa\",\"alamat\":\"Pandeglang\",\"tgl_lahir\":\"15-07-1993\",\"items\":[{\"id_barang\":2,\"nama_barang\":\"Pepsodent\"},{\"id_barang\":2,\"nama_barang\":\"Masako\"}]}');

-- ----------------------------
-- Table structure for tcq_test_s
-- ----------------------------
DROP TABLE IF EXISTS `tcq_test_s`;
CREATE TABLE `tcq_test_s`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `receive_at` datetime NULL DEFAULT NULL,
  `processed_at` datetime NULL DEFAULT NULL,
  `status` enum('1','2','3') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `error_message` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `response_message` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `payload` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tcq_test_s
-- ----------------------------
INSERT INTO `tcq_test_s` VALUES (3, '2023-06-19 09:15:51', NULL, '2', NULL, NULL, '{\"nama\":\"Pandeglang\",\"alamat\":\"Dida Nurwandssa\",\"tgl_lahir\":\"1993-07-15\",\"items\":[{\"id_barang\":2,\"nama_barang\":\"Pepsodent\"},{\"id_barang\":2,\"nama_barang\":\"Masako\"}]}');
INSERT INTO `tcq_test_s` VALUES (4, '2023-06-19 09:15:53', NULL, '2', NULL, '\"hehe\"', '{\"nama\":\"Pandeglang\",\"alamat\":\"Dida Nurwandssa\",\"tgl_lahir\":\"1993-07-15\",\"items\":[{\"id_barang\":2,\"nama_barang\":\"Pepsodent\"},{\"id_barang\":2,\"nama_barang\":\"Masako\"}]}');
INSERT INTO `tcq_test_s` VALUES (5, '2023-06-19 09:21:04', NULL, '2', NULL, '\"hehe\"', '{\"nama\":\"Pandeglang\",\"alamat\":\"Dida Nurwandssa\",\"tgl_lahir\":\"1993-07-15\",\"items\":[{\"id_barang\":2,\"nama_barang\":\"Pepsodent\"},{\"id_barang\":2,\"nama_barang\":\"Masako\"}]}');
INSERT INTO `tcq_test_s` VALUES (6, '2023-06-19 09:21:26', NULL, '2', NULL, 'hehe', '{\"nama\":\"Pandeglang\",\"alamat\":\"Dida Nurwandssa\",\"tgl_lahir\":\"1993-07-15\",\"items\":[{\"id_barang\":2,\"nama_barang\":\"Pepsodent\"},{\"id_barang\":2,\"nama_barang\":\"Masako\"}]}');
INSERT INTO `tcq_test_s` VALUES (7, '2023-06-19 09:21:31', NULL, '2', 'AxiosError: Request failed with status code 404', 'hehe', '{\"nama\":\"Pandeglang\",\"alamat\":\"Dida Nurwandssa\",\"tgl_lahir\":\"1993-07-15\",\"items\":[{\"id_barang\":2,\"nama_barang\":\"Pepsodent\"},{\"id_barang\":2,\"nama_barang\":\"Masako\"}]}');
INSERT INTO `tcq_test_s` VALUES (8, '2023-06-19 09:21:36', NULL, '2', NULL, 'hehe', '{\"nama\":\"Pandeglang\",\"alamat\":\"Dida Nurwandssa\",\"tgl_lahir\":\"1993-07-15\",\"items\":[{\"id_barang\":2,\"nama_barang\":\"Pepsodent\"},{\"id_barang\":2,\"nama_barang\":\"Masako\"}]}');
INSERT INTO `tcq_test_s` VALUES (9, '2023-06-19 09:21:41', NULL, '2', NULL, 'hehe', '{\"nama\":\"Pandeglang\",\"alamat\":\"Dida Nurwandssa\",\"tgl_lahir\":\"1993-07-15\",\"items\":[{\"id_barang\":2,\"nama_barang\":\"Pepsodent\"},{\"id_barang\":2,\"nama_barang\":\"Masako\"}]}');

-- ----------------------------
-- Table structure for tcq_test_tabel11_r
-- ----------------------------
DROP TABLE IF EXISTS `tcq_test_tabel11_r`;
CREATE TABLE `tcq_test_tabel11_r`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `receive_at` datetime NULL DEFAULT NULL,
  `processed_at` datetime NULL DEFAULT NULL,
  `status` enum('1','2','3') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `error_message` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `response_message` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `payload` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tcq_test_tabel11_r
-- ----------------------------

-- ----------------------------
-- Table structure for tcq_test_tabel_s
-- ----------------------------
DROP TABLE IF EXISTS `tcq_test_tabel_s`;
CREATE TABLE `tcq_test_tabel_s`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `receive_at` datetime NULL DEFAULT NULL,
  `processed_at` datetime NULL DEFAULT NULL,
  `status` enum('1','2','3') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `error_message` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `response_message` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `payload` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tcq_test_tabel_s
-- ----------------------------

-- ----------------------------
-- Table structure for tcq_ur_s
-- ----------------------------
DROP TABLE IF EXISTS `tcq_ur_s`;
CREATE TABLE `tcq_ur_s`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `receive_at` datetime NULL DEFAULT NULL,
  `processed_at` datetime NULL DEFAULT NULL,
  `status` enum('1','2','3') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `error_message` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `response_message` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `payload` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tcq_ur_s
-- ----------------------------

-- ----------------------------
-- Table structure for tcq_weewewee_r
-- ----------------------------
DROP TABLE IF EXISTS `tcq_weewewee_r`;
CREATE TABLE `tcq_weewewee_r`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `receive_at` datetime NULL DEFAULT NULL,
  `processed_at` datetime NULL DEFAULT NULL,
  `status` enum('1','2','3') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `error_message` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `response_message` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `payload` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tcq_weewewee_r
-- ----------------------------

-- ----------------------------
-- Table structure for ucon
-- ----------------------------
DROP TABLE IF EXISTS `ucon`;
CREATE TABLE `ucon`  (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `firstname` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `lastname` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `reg_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ucon
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` int(5) NULL DEFAULT NULL,
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `password_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `active` int(5) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Gugum', 'furkonfajri1991@gmail.com', NULL, '$2y$10$s/0L09U323obmRpdRC9j5uu/FfftkX4U.ep9NbQjHS7idRf7zR5Nu', NULL, '2023-06-22 10:22:17', '2023-06-22 10:39:16', 1, 'admin_123', 'WVdSdGFXNHhNak09', 1);
INSERT INTO `users` VALUES (2, 'Furkon Fajri', 'uconpremium@gmail.com', NULL, '$2y$10$odBKoov91e6MWooisIIufuPFKrRlmktQUVFO./5ahAP.PHEUrS62a', NULL, '2023-06-22 10:35:36', '2023-06-22 10:45:26', 2, 'furkonfajri1990', 'WVdSdGFXNHhNak09', 1);

SET FOREIGN_KEY_CHECKS = 1;
