/*
 Navicat Premium Data Transfer

 Source Server         : db
 Source Server Type    : MySQL
 Source Server Version : 50733
 Source Host           : localhost:3306
 Source Schema         : manage_users

 Target Server Type    : MySQL
 Target Server Version : 50733
 File Encoding         : 65001

 Date: 25/06/2023 14:33:49
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for emails_queue
-- ----------------------------
DROP TABLE IF EXISTS `emails_queue`;
CREATE TABLE `emails_queue`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `is_sent` tinyint(4) NULL DEFAULT 0,
  `created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 45 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of emails_queue
-- ----------------------------
INSERT INTO `emails_queue` VALUES (44, 'dthuy3319@gmail.com', 1, '2023-06-25 14:25:51', '2023-06-25 14:25:51');

-- ----------------------------
-- Table structure for login_tokens
-- ----------------------------
DROP TABLE IF EXISTS `login_tokens`;
CREATE TABLE `login_tokens`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NULL DEFAULT NULL,
  `token` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_login_tokens`(`user_id`) USING BTREE,
  CONSTRAINT `fk_login_tokens` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 44 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of login_tokens
-- ----------------------------
INSERT INTO `login_tokens` VALUES (16, 34, 'acf6f5840c7853131d54134595a017d39384ba1e', '2023-06-22 21:24:02');
INSERT INTO `login_tokens` VALUES (35, 11, '1ba1e734b30a25257b0e316c487322231baaccb1', '2023-06-24 11:13:39');
INSERT INTO `login_tokens` VALUES (36, 11, '150ead877e84054c48aedd324bc0a194aad94dcd', '2023-06-24 11:13:46');
INSERT INTO `login_tokens` VALUES (37, 11, 'd69462069dbfe5fe30831d36efb458d1e6244646', '2023-06-24 11:14:10');
INSERT INTO `login_tokens` VALUES (38, 11, '2639166100b6f8bfdf833658661db46ed9e77f38', '2023-06-24 11:16:02');
INSERT INTO `login_tokens` VALUES (39, 11, '9d69e6a252aa98b1cf5f76c458c84819cd9f5b1e', '2023-06-24 11:16:06');
INSERT INTO `login_tokens` VALUES (43, 11, 'd4643f0ce771678de0f225837b0430e8c7275611', '2023-06-24 11:21:47');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `fullname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `phone` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `forgot_token` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `active_token` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status` tinyint(4) NULL DEFAULT 0,
  `last_activity` datetime NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 81 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (11, 'dthuyhuynh90@gmail.com', 'Ben Huỳnh', '0961929399', '$2y$10$MikQunkbG9cGXNdKt0z5K.A8GVwpdywuhvunLz2DU9q1eL7OJ4t1S', NULL, NULL, 1, '2023-06-24 12:06:28', '2023-06-21 16:24:37', '2023-06-24 21:24:01');
INSERT INTO `users` VALUES (12, 'dthuy@gmail.com', 'Ben Huynh', '0963653808', '$2y$10$MikQunkbG9cGXNdKt0z5K.A8GVwpdywuhvunLz2DU9q1eL7OJ4t1S', NULL, NULL, 0, NULL, '2023-06-21 16:25:17', NULL);
INSERT INTO `users` VALUES (13, 'dthuy2@gmail.com', 'Trần An', '0961929402', '$2y$10$MikQunkbG9cGXNdKt0z5K.A8GVwpdywuhvunLz2DU9q1eL7OJ4t1S', NULL, NULL, 1, '2023-06-24 11:23:02', '2023-06-21 17:23:58', '2023-06-24 11:23:02');
INSERT INTO `users` VALUES (14, 'dthuy3@gmail.com', 'Trần B', '0961929403', '$2y$10$MikQunkbG9cGXNdKt0z5K.A8GVwpdywuhvunLz2DU9q1eL7OJ4t1S', NULL, NULL, 1, NULL, '2023-06-21 17:24:58', '2023-06-22 13:36:21');
INSERT INTO `users` VALUES (15, 'dthuy4@gmail.com', 'Minh Tâm', '0961929404', '$2y$10$MikQunkbG9cGXNdKt0z5K.A8GVwpdywuhvunLz2DU9q1eL7OJ4t1S', NULL, NULL, 1, NULL, '2023-06-21 17:25:58', '2023-06-22 13:36:24');
INSERT INTO `users` VALUES (16, 'dthuy5@gmail.com', 'Chi Lily', '0961929333', '$2y$10$MikQunkbG9cGXNdKt0z5K.A8GVwpdywuhvunLz2DU9q1eL7OJ4t1S', NULL, NULL, 1, NULL, '2023-06-21 17:26:58', '2023-06-24 11:45:08');
INSERT INTO `users` VALUES (17, 'dthuy6@gmail.com', 'Nhật Hạ', '0961922222', '$2y$10$MikQunkbG9cGXNdKt0z5K.A8GVwpdywuhvunLz2DU9q1eL7OJ4t1S', NULL, NULL, 1, NULL, '2023-06-21 17:27:58', '2023-06-24 11:45:13');
INSERT INTO `users` VALUES (18, 'dthuy7@gmail.com', 'Nguyễn Khánh An', '0961929401', '$2y$10$MikQunkbG9cGXNdKt0z5K.A8GVwpdywuhvunLz2DU9q1eL7OJ4t1S', NULL, NULL, 1, NULL, '2023-06-21 17:28:58', '2023-06-22 13:36:32');
INSERT INTO `users` VALUES (19, 'dthuy8@gmail.com', 'Hồng Phúc Lê', '0961927777', '$2y$10$MikQunkbG9cGXNdKt0z5K.A8GVwpdywuhvunLz2DU9q1eL7OJ4t1S', NULL, NULL, 1, NULL, '2023-06-21 17:29:58', '2023-06-24 11:45:19');
INSERT INTO `users` VALUES (20, 'dthuy9@gmail.com', 'Quốc Đạt', '0961923232', '$2y$10$MikQunkbG9cGXNdKt0z5K.A8GVwpdywuhvunLz2DU9q1eL7OJ4t1S', NULL, NULL, 1, NULL, '2023-06-21 17:30:58', '2023-06-24 11:45:24');
INSERT INTO `users` VALUES (21, 'dthuy10@gmail.com', 'Thu Duyên', '0961926776', '$2y$10$MikQunkbG9cGXNdKt0z5K.A8GVwpdywuhvunLz2DU9q1eL7OJ4t1S', NULL, NULL, 1, NULL, '2023-06-21 17:31:58', '2023-06-24 11:45:30');
INSERT INTO `users` VALUES (22, 'dthuy11@gmail.com', 'Bùi Thu', '0961929789', '$2y$10$MikQunkbG9cGXNdKt0z5K.A8GVwpdywuhvunLz2DU9q1eL7OJ4t1S', NULL, NULL, 1, NULL, '2023-06-21 17:32:58', '2023-06-24 11:45:34');
INSERT INTO `users` VALUES (23, 'dthuy12@gmail.com', 'Thanh Võ', '0961924346', '$2y$10$MikQunkbG9cGXNdKt0z5K.A8GVwpdywuhvunLz2DU9q1eL7OJ4t1S', NULL, NULL, 1, NULL, '2023-06-21 17:33:58', '2023-06-24 11:45:38');
INSERT INTO `users` VALUES (24, 'dthuy13@gmail.com', 'Minh Thư Huỳnh', '0961928904', '$2y$10$MikQunkbG9cGXNdKt0z5K.A8GVwpdywuhvunLz2DU9q1eL7OJ4t1S', NULL, NULL, 1, NULL, '2023-06-21 17:34:58', '2023-06-24 11:45:42');
INSERT INTO `users` VALUES (25, 'dthuy14@gmail.com', 'Sóc Nhí', '0961925321', '$2y$10$MikQunkbG9cGXNdKt0z5K.A8GVwpdywuhvunLz2DU9q1eL7OJ4t1S', NULL, NULL, 1, NULL, '2023-06-21 17:35:58', '2023-06-24 11:45:46');
INSERT INTO `users` VALUES (26, 'dthuy15@gmail.com', 'Bảo Anh', '0961929451', '$2y$10$MikQunkbG9cGXNdKt0z5K.A8GVwpdywuhvunLz2DU9q1eL7OJ4t1S', NULL, NULL, 1, NULL, '2023-06-21 17:36:58', '2023-06-24 11:45:48');
INSERT INTO `users` VALUES (27, 'dthuy16@gmail.com', 'Hồng Nhi', '0961929351', '$2y$10$MikQunkbG9cGXNdKt0z5K.A8GVwpdywuhvunLz2DU9q1eL7OJ4t1S', NULL, NULL, 1, NULL, '2023-06-21 17:37:58', '2023-06-24 11:45:52');
INSERT INTO `users` VALUES (28, 'dthuy17@gmail.com', 'Nhật Hạ', '0961926721', '$2y$10$MikQunkbG9cGXNdKt0z5K.A8GVwpdywuhvunLz2DU9q1eL7OJ4t1S', NULL, NULL, 1, NULL, '2023-06-21 17:38:58', '2023-06-24 11:45:56');
INSERT INTO `users` VALUES (29, 'dthuy18@gmail.com', 'Tâm Thy', '0961967211', '$2y$10$MikQunkbG9cGXNdKt0z5K.A8GVwpdywuhvunLz2DU9q1eL7OJ4t1S', NULL, NULL, 1, NULL, '2023-06-21 17:39:58', '2023-06-24 11:46:01');
INSERT INTO `users` VALUES (30, 'dthuy19@gmail.com', 'Lê Thị Bình Ly', '0961972215', '$2y$10$MikQunkbG9cGXNdKt0z5K.A8GVwpdywuhvunLz2DU9q1eL7OJ4t1S', NULL, NULL, 1, NULL, '2023-06-21 17:40:58', '2023-06-24 11:46:05');
INSERT INTO `users` VALUES (31, 'dthuy20@gmail.com', 'Anh Nhật', '0961926215', '$2y$10$MikQunkbG9cGXNdKt0z5K.A8GVwpdywuhvunLz2DU9q1eL7OJ4t1S', NULL, NULL, 1, NULL, '2023-06-21 17:41:59', '2023-06-24 11:46:30');
INSERT INTO `users` VALUES (32, 'dthuy33@gmail.com', 'Diem Thuy Huynh', '0981926215', '$2y$10$SVNYPCWSpyChS/3Ew9yo7OXCu8EzXRUxGeFxXDqukNFB5vC3zCDC6', NULL, NULL, 1, '2023-06-24 11:17:40', '2023-06-22 21:15:28', '2023-06-24 11:46:12');
INSERT INTO `users` VALUES (34, 'myosotic91@gmail.com', 'Khánh Nhi', '0961999262', '$2y$10$/NEha7km7UdZnrSbWDlZIOuzM8uVWdch8fJmYzQEI9iW141perffm', NULL, NULL, 1, NULL, '2023-06-22 21:18:50', '2023-06-24 11:59:48');
INSERT INTO `users` VALUES (35, 'myosotic9@gmail.com', 'Ngọc Châu', '0961999996', '$2y$10$TubMUc2BZ7/cAlu/49ViU.c8vCthBItmovLMbFACVJVCqmH1wzFF.', NULL, NULL, 0, NULL, '2023-06-23 17:46:33', '2023-06-24 11:59:58');
INSERT INTO `users` VALUES (36, 'myosotic90@gmail.com', 'Huyền My', '0961999925', '$2y$10$GwkC3iX4WonK.ymkkoWDt.TE7AA5FD0TR9PpTnZNlUFVuHkTmi9iy', NULL, NULL, 1, '2023-06-24 11:17:14', '2023-06-23 17:52:13', '2023-06-24 21:24:09');
INSERT INTO `users` VALUES (37, 'dthuy97@gmail.com', 'Nguyễn A', '0961922345', '$2y$10$R4NEo4gQNce6BMr7GSmAfulYKRHBRvpcfVAkQRtRg3Dqv/W8S0NzO', NULL, NULL, 1, NULL, '2023-06-24 12:19:54', NULL);
INSERT INTO `users` VALUES (38, 'dthuyhuynh1997@gmail.com', 'Diem Thuy 100', '0961929333', '$2y$10$b9IdVW/DaaqHaPeoaAvqa.OERLRBzYGtgeDTArefxkhYze5ynEQga', NULL, 'b545c3e35f6f519feda613cffbf552fd22900107', 0, NULL, '2023-06-24 19:42:16', NULL);
INSERT INTO `users` VALUES (80, 'dthuy3319@gmail.com', 'Diem Thuy 100', '0961929396', '$2y$10$JgcAu1IjQ3LDXOAsHhgR7.6j4f.ujDGNe/r4b2qc2H0VWHsCiriES', NULL, NULL, 1, NULL, '2023-06-25 14:25:48', '2023-06-25 14:26:35');

SET FOREIGN_KEY_CHECKS = 1;
