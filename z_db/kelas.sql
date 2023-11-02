/*
 Navicat Premium Data Transfer

 Source Server         : Local
 Source Server Type    : MySQL
 Source Server Version : 80030
 Source Host           : localhost:3306
 Source Schema         : ketosin

 Target Server Type    : MySQL
 Target Server Version : 80030
 File Encoding         : 65001

 Date: 02/11/2023 13:06:41
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for kelas
-- ----------------------------
DROP TABLE IF EXISTS `kelas`;
CREATE TABLE `kelas`  (
  `id_kelas` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_kelas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_kelas`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kelas
-- ----------------------------
INSERT INTO `kelas` VALUES (1, 'MP 1', 1, '2023-10-25 21:12:27', '2023-10-25 21:12:27');
INSERT INTO `kelas` VALUES (2, 'MP 2', 1, '2023-10-25 21:12:27', '2023-10-25 21:12:27');
INSERT INTO `kelas` VALUES (3, 'AK 1', 1, '2023-10-25 21:12:27', '2023-10-25 21:12:27');
INSERT INTO `kelas` VALUES (4, 'AK 2', 1, '2023-10-25 21:12:27', '2023-10-25 21:12:27');
INSERT INTO `kelas` VALUES (5, 'LP 1', 1, '2023-10-25 21:12:27', '2023-10-25 21:12:27');
INSERT INTO `kelas` VALUES (6, 'BD 1', 1, '2023-10-25 21:12:27', '2023-10-25 21:12:27');
INSERT INTO `kelas` VALUES (7, 'BD 2', 1, '2023-10-25 21:12:27', '2023-10-25 21:12:27');
INSERT INTO `kelas` VALUES (8, 'TKJ 1', 1, '2023-10-25 21:12:27', '2023-10-25 21:12:27');
INSERT INTO `kelas` VALUES (9, 'TKJ 2', 1, '2023-10-25 21:12:27', '2023-10-25 21:12:27');
INSERT INTO `kelas` VALUES (10, 'DKV 1', 1, '2023-10-25 21:12:27', '2023-10-25 21:12:27');
INSERT INTO `kelas` VALUES (11, 'DKV 2', 1, '2023-10-25 21:12:27', '2023-10-25 21:12:27');
INSERT INTO `kelas` VALUES (12, 'RPL 1', 1, '2023-10-25 21:12:27', '2023-10-25 21:12:27');
INSERT INTO `kelas` VALUES (13, 'RPL 2', 1, '2023-10-25 21:12:27', '2023-10-25 21:12:27');
INSERT INTO `kelas` VALUES (14, 'PSPTv 1', 1, '2023-10-25 21:12:27', '2023-10-25 21:12:27');
INSERT INTO `kelas` VALUES (15, 'OTKP 1', 1, '2023-10-25 21:12:27', '2023-10-25 21:12:27');
INSERT INTO `kelas` VALUES (16, 'OTKP 2', 1, '2023-10-25 21:12:27', '2023-10-25 21:12:27');
INSERT INTO `kelas` VALUES (17, 'AKL 1', 1, '2023-10-25 21:12:27', '2023-10-25 21:12:27');
INSERT INTO `kelas` VALUES (18, 'AKL 2', 1, '2023-10-25 21:12:27', '2023-10-25 21:12:27');
INSERT INTO `kelas` VALUES (19, 'PKM 1', 1, '2023-10-25 21:12:27', '2023-10-25 21:12:27');
INSERT INTO `kelas` VALUES (20, 'PKM 2', 1, '2023-10-25 21:12:27', '2023-10-25 21:12:27');
INSERT INTO `kelas` VALUES (21, 'BDP 1', 1, '2023-10-25 21:12:27', '2023-10-25 21:12:27');
INSERT INTO `kelas` VALUES (22, 'BDP 2', 1, '2023-10-25 21:12:27', '2023-10-25 21:12:27');
INSERT INTO `kelas` VALUES (23, 'MM 1', 1, '2023-10-25 21:12:27', '2023-10-25 21:12:27');
INSERT INTO `kelas` VALUES (24, 'MM 2', 1, '2023-10-25 21:12:27', '2023-10-25 21:12:27');

SET FOREIGN_KEY_CHECKS = 1;
