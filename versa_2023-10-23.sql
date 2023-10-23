-- --------------------------------------------------------
-- 主机:                           127.0.0.1
-- 服务器版本:                        8.1.0 - MySQL Community Server - GPL
-- 服务器操作系统:                      Win64
-- HeidiSQL 版本:                  12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- 导出  表 versa.admin_cate 结构
CREATE TABLE IF NOT EXISTS `admin_cate` (
  `id` bigint NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `pid` bigint NOT NULL DEFAULT '0' COMMENT '上级ID',
  `level` tinyint(1) NOT NULL DEFAULT '1' COMMENT '级别',
  `name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL COMMENT '名称',
  `type` enum('分类','页面') COLLATE utf8mb4_general_ci NOT NULL DEFAULT '分类' COMMENT '类型',
  `path` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '路由',
  `view` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'vue文件路径',
  `icon` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '图标',
  `sort` int NOT NULL DEFAULT '100' COMMENT '排序',
  `state` enum('开启','关闭') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '开启' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='后台栏目';

-- 正在导出表  versa.admin_cate 的数据：~9 rows (大约)
DELETE FROM `admin_cate`;
INSERT INTO `admin_cate` (`id`, `pid`, `level`, `name`, `type`, `path`, `view`, `icon`, `sort`, `state`) VALUES
	(1, 0, 1, '系统设置', '分类', '', '', 'Setting', 100, '开启'),
	(2, 1, 2, '后台栏目', '页面', 'setting/adminCate/index', '../views/setting/adminCate/index.vue', '', 100, '开启'),
	(7, 0, 1, '角色管理', '分类', '', '', 'User', 100, '开启'),
	(8, 7, 2, '管理员', '页面', 'role/admin/index', '../role/admin/index.vue', '', 100, '开启'),
	(9, 7, 2, '管理员组', '页面', 'role/group/index', '../role/group/index.vue', '', 100, '开启'),
	(10, 7, 2, '权限', '页面', 'd', 'd', '', 100, '开启'),
	(11, 0, 1, '测试', '分类', '', '', '的', 100, '开启'),
	(12, 7, 2, '测', '分类', '', '', '', 100, '开启'),
	(13, 1, 2, '数据表', '页面', 'setting/table/index', '../views/setting/table/index.vue', '', 100, '开启');

-- 导出  表 versa.user 结构
CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `user_group_id` int DEFAULT NULL COMMENT '用户所属组',
  `type` enum('管理员') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '管理员' COMMENT '账号类型',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户名',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '密码',
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '头像',
  `sort` int NOT NULL DEFAULT '100' COMMENT '排序',
  `state` enum('开启','关闭') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '开启' COMMENT '状态',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='用户';

-- 正在导出表  versa.user 的数据：~0 rows (大约)
DELETE FROM `user`;
INSERT INTO `user` (`id`, `user_group_id`, `type`, `name`, `password`, `avatar`, `sort`, `state`, `created_at`, `updated_at`) VALUES
	(1, 0, '管理员', 'admin', '$2y$10$19lIOBSbphg1J64OUTHEQ..vfYqQka10EQH9dICD5C2YHVfb4EL2S', '', 0, '开启', '2023-10-10 06:14:16', NULL);

-- 导出  表 versa.user_auth 结构
CREATE TABLE IF NOT EXISTS `user_auth` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `pid` bigint NOT NULL DEFAULT '0' COMMENT '父ID',
  `level` int NOT NULL DEFAULT '1' COMMENT '级别',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '权限名',
  `route` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '路由',
  `sort` int NOT NULL DEFAULT '100' COMMENT '排序',
  `state` enum('开启','关闭') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '开启' COMMENT '状态',
  `type` enum('管理员') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '管理员' COMMENT '类型',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC COMMENT='用户权限';

-- 正在导出表  versa.user_auth 的数据：~7 rows (大约)
DELETE FROM `user_auth`;
INSERT INTO `user_auth` (`id`, `pid`, `level`, `name`, `route`, `sort`, `state`, `type`) VALUES
	(1, 0, 1, 'admin', NULL, 100, '开启', '管理员'),
	(2, 0, 1, 'admin', NULL, 100, '开启', '管理员'),
	(3, 0, 1, 'admin', NULL, 100, '开启', '管理员'),
	(4, 0, 1, 'admin', NULL, 100, '开启', '管理员'),
	(5, 0, 1, 'd', NULL, 100, '开启', '管理员'),
	(6, 1, 1, 'test', NULL, 100, '开启', '管理员'),
	(7, 1, 2, 'test', NULL, 100, '开启', '管理员');

-- 导出  表 versa.user_group 结构
CREATE TABLE IF NOT EXISTS `user_group` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '用户组名',
  `auth_ids` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '权限集合',
  `sort` int NOT NULL DEFAULT '100' COMMENT '排序',
  `state` enum('开启','关闭') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '开启' COMMENT '状态',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `type` enum('管理员') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '管理员' COMMENT '类型',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC COMMENT='用户组';

-- 正在导出表  versa.user_group 的数据：~0 rows (大约)
DELETE FROM `user_group`;

-- 导出  表 versa.user_token 结构
CREATE TABLE IF NOT EXISTS `user_token` (
  `user_id` bigint NOT NULL COMMENT '用户ID',
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'token',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 正在导出表  versa.user_token 的数据：~0 rows (大约)
DELETE FROM `user_token`;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
