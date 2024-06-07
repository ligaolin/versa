-- --------------------------------------------------------
-- 主机:                           8.134.145.254
-- 服务器版本:                        8.2.0 - MySQL Community Server - GPL
-- 服务器操作系统:                      Linux
-- HeidiSQL 版本:                  12.3.0.6589
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

use `versa`;

-- 导出  表 versa.admin_cate 结构
DROP TABLE IF EXISTS `admin_cate`;
CREATE TABLE IF NOT EXISTS `admin_cate` (
  `id` bigint NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `pid` bigint NOT NULL DEFAULT '0' COMMENT '上级ID',
  `level` tinyint(1) NOT NULL DEFAULT '1' COMMENT '级别',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '英文名称',
  `type` enum('分类','页面') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '分类' COMMENT '类型',
  `path` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '路由',
  `view` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'vue文件路径',
  `icon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '图标',
  `sort` int NOT NULL DEFAULT '100' COMMENT '排序',
  `state` enum('开启','关闭') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '开启' COMMENT '状态',
  `show` enum('是','否') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '是' COMMENT '是否显示',
  `active` bigint DEFAULT NULL COMMENT '选中状态的栏目，空表示使用自身作为选中状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='后台栏目';

-- 正在导出表  versa.admin_cate 的数据：~10 rows (大约)
DELETE FROM `admin_cate`;
INSERT INTO `admin_cate` (`id`, `pid`, `level`, `name`, `type`, `path`, `view`, `icon`, `sort`, `state`, `show`, `active`) VALUES
	(1, 0, 1, '系统设置', '分类', '', '', 'Setting', 100, '开启', '是', NULL),
	(2, 1, 2, '系统配置', '页面', 'setting/config/index', '../views/setting/config/index.vue', '', 100, '开启', '是', NULL),
	(3, 1, 2, '后台栏目', '页面', 'setting/adminCate/index', '../views/setting/adminCate/index.vue', '', 100, '开启', '是', NULL),
	(4, 0, 1, '角色管理', '分类', '', '', 'User', 100, '开启', '是', NULL),
	(5, 4, 2, '管理员', '页面', 'role/admin/index', '../views/role/admin/index.vue', '', 100, '开启', '是', NULL),
	(6, 4, 2, '管理员组', '页面', 'role/group/index', '../views/role/group/index.vue', '', 100, '开启', '是', NULL),
	(7, 4, 2, '管理员权限', '页面', 'role/auth/index', '../views/role/auth/index.vue', '', 100, '开启', '是', NULL),
	(8, 1, 2, '数据表', '页面', 'setting/table/index', '../views/setting/table/index.vue', '', 100, '开启', '是', NULL),
	(9, 8, 3, '数据表字段', '页面', 'setting/table/field', '../views/setting/table/field.vue', NULL, 100, '开启', '否', 8),
	(10, 1, 2, '上传文件管理', '页面', 'setting/file/index', '../views/setting/file/index.vue', '', 100, '开启', '是', NULL);

-- 导出  表 versa.config 结构
DROP TABLE IF EXISTS `config`;
CREATE TABLE IF NOT EXISTS `config` (
  `id` bigint NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '名称',
  `val` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '值',
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '分类',
  `field_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '单行文本' COMMENT '数据类型：单行文本、单行数字、多行文本、单选项、多选项、下拉菜单、上传图片、上传视频、上传文件、编辑器、',
  `vals` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '可选值，'',''隔开',
  `sort` int NOT NULL DEFAULT '100' COMMENT '排序',
  `edit` enum('是','否') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '是' COMMENT '可否编辑，修改、删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='系统配置';

-- 正在导出表  versa.config 的数据：~5 rows (大约)
DELETE FROM `config`;
INSERT INTO `config` (`id`, `name`, `val`, `type`, `field_type`, `vals`, `sort`, `edit`) VALUES
	(1, '网站名称', 'versa', 'site', '单行文本', '', 100, '否'),
	(2, '图片最大限制（M）', '10', 'upload', '单行数字', '', 100, '否'),
	(3, '视频最大限制（M）', '10', 'upload', '单行数字', '', 100, '否'),
	(4, '其他最大限制（M）', '10', 'upload', '单行数字', '', 100, '否'),
	(5, '可上传类型', 'jpg,gif,mp4,png,jpeg,svg,webp,mov,txtmpeg,avi,navi,asf,3gp,wmv,divx,xvid,rm,rmvb,flv/f4v,txt', 'upload', '多行文本', '', 100, '否');

-- 导出  表 versa.config_type 结构
DROP TABLE IF EXISTS `config_type`;
CREATE TABLE IF NOT EXISTS `config_type` (
  `id` bigint NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '类型名称',
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '类型值',
  `edit` enum('是','否') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '是' COMMENT '可否编辑，修改、删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='配置类型';

-- 正在导出表  versa.config_type 的数据：~2 rows (大约)
DELETE FROM `config_type`;
INSERT INTO `config_type` (`id`, `name`, `type`, `edit`) VALUES
	(1, '网站配置', 'site', '否'),
	(2, '上传配置', 'upload', '否');

-- 导出  表 versa.user 结构
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `user_group_id` int DEFAULT NULL COMMENT '用户所属组',
  `type` enum('管理员') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '管理员' COMMENT '账号类型',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户名',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '密码',
  `avatar` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '头像',
  `sort` int NOT NULL DEFAULT '100' COMMENT '排序',
  `state` enum('开启','关闭') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '开启' COMMENT '状态',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='用户';

-- 正在导出表  versa.user 的数据：~2 rows (大约)
DELETE FROM `user`;
INSERT INTO `user` (`id`, `user_group_id`, `type`, `name`, `password`, `avatar`, `sort`, `state`, `created_at`, `updated_at`) VALUES
	(1, 1, '管理员', 'admin', '$2y$10$4vGK0H44LOiLanBkodhw8ejnBWhAYWy8DGFI4yd0anOsJWVfdop5S', NULL, 0, '开启', '2023-10-10 06:14:16', '2023-12-11 06:39:06');

-- 导出  表 versa.user_auth 结构
DROP TABLE IF EXISTS `user_auth`;
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
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC COMMENT='用户权限';

-- 正在导出表  versa.user_auth 的数据：~47 rows (大约)
DELETE FROM `user_auth`;
INSERT INTO `user_auth` (`id`, `pid`, `level`, `name`, `route`, `sort`, `state`, `type`) VALUES
	(1, 0, 1, '系统设置', '', 100, '开启', '管理员'),
	(2, 1, 2, '系统配置', '', 100, '开启', '管理员'),
	(3, 1, 2, '后台栏目', '', 100, '开启', '管理员'),
	(4, 1, 2, '数据表', '', 100, '开启', '管理员'),
	(5, 1, 2, '数据表字段', '', 100, '开启', '管理员'),
	(6, 0, 1, '角色管理', '', 100, '开启', '管理员'),
	(7, 6, 2, '管理员', '', 100, '开启', '管理员'),
	(8, 6, 2, '管理员组', '', 100, '开启', '管理员'),
	(9, 6, 2, '权限', '', 100, '开启', '管理员'),
	(10, 0, 1, '其他', '', 100, '开启', '管理员'),
	(11, 2, 3, '查看', 'admin/setting.Config/List', 100, '开启', '管理员'),
	(12, 2, 3, '获取', 'admin/setting.Config/Get', 100, '开启', '管理员'),
	(13, 2, 3, '添加', 'admin/setting.Config/Edit', 100, '开启', '管理员'),
	(14, 2, 3, '修改', 'admin/setting.Config/Change', 100, '开启', '管理员'),
	(15, 2, 3, '删除', 'admin/setting.Config/Del', 100, '开启', '管理员'),
	(16, 3, 3, '查看', 'admin/setting.AdminCate/List', 100, '开启', '管理员'),
	(17, 3, 3, '获取', 'admin/setting.AdminCate/Get', 100, '开启', '管理员'),
	(18, 3, 3, '编辑', 'admin/setting.AdminCate/Edit', 100, '开启', '管理员'),
	(19, 3, 3, '修改', 'admin/setting.AdminCate/Change', 100, '开启', '管理员'),
	(20, 3, 3, '删除', 'admin/setting.AdminCate/Del', 100, '开启', '管理员'),
	(21, 2, 3, '提交所有修改', 'admin/setting.Config/ForEditVal', 100, '开启', '管理员'),
	(22, 4, 3, '查看', 'admin/db.Table/List', 100, '开启', '管理员'),
	(23, 4, 3, '备份', 'admin/db.Table/Backups', 100, '开启', '管理员'),
	(24, 4, 3, '编辑', 'admin/db.Table/Edit', 100, '开启', '管理员'),
	(25, 4, 3, '添加', 'admin/db.Table/Add', 100, '开启', '管理员'),
	(26, 4, 3, '删除', 'admin/db.Table/Del', 100, '开启', '管理员'),
	(27, 5, 3, '查看', 'admin/db.Field/List', 100, '开启', '管理员'),
	(28, 5, 3, '编辑', 'admin/db.Field/Edit', 100, '开启', '管理员'),
	(29, 5, 3, '添加', 'admin/db.Field/Add', 100, '开启', '管理员'),
	(30, 5, 3, '删除', 'admin/db.Field/Del', 100, '开启', '管理员'),
	(31, 7, 3, '查看', 'admin/user.User/List', 100, '开启', '管理员'),
	(32, 7, 3, '获取', 'admin/user.User/Get', 100, '开启', '管理员'),
	(33, 7, 3, '编辑', 'admin/user.User/AdminEdit', 100, '开启', '管理员'),
	(34, 7, 3, '修改', 'admin/user.User/AdminChange', 100, '开启', '管理员'),
	(35, 7, 3, '删除', 'admin/user.User/AdminDel', 100, '开启', '管理员'),
	(36, 8, 3, '查看', 'admin/user.UserGroup/List', 100, '开启', '管理员'),
	(37, 8, 3, '获取', 'admin/user.UserGroup/Get', 100, '开启', '管理员'),
	(38, 8, 3, '编辑', 'admin/user.UserGroup/AdminEdit', 100, '开启', '管理员'),
	(39, 8, 3, '修改', 'admin/user.UserGroup/AdminChange', 100, '开启', '管理员'),
	(40, 8, 3, '删除', 'admin/user.UserGroup/AdminDel', 100, '开启', '管理员'),
	(41, 8, 3, '获取权限', 'admin/user.UserAuth/GetListByPid', 100, '开启', '管理员'),
	(42, 9, 3, '查看', 'admin/user.UserAuth/List', 100, '开启', '管理员'),
	(43, 9, 3, '获取', 'admin/user.UserAuth/Get', 100, '开启', '管理员'),
	(44, 9, 3, '编辑', 'admin/user.UserAuth/AdminEdit', 100, '开启', '管理员'),
	(45, 9, 3, '修改', 'admin/user.UserAuth/AdminChange', 100, '开启', '管理员'),
	(46, 9, 3, '删除', 'admin/user.UserAuth/AdminDel', 100, '开启', '管理员'),
	(47, 10, 3, '上传文件', 'admin/other.File/Upload', 100, '开启', '管理员');

-- 导出  表 versa.user_group 结构
DROP TABLE IF EXISTS `user_group`;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC COMMENT='用户组';

-- 正在导出表  versa.user_group 的数据：~0 rows (大约)
DELETE FROM `user_group`;
INSERT INTO `user_group` (`id`, `name`, `auth_ids`, `sort`, `state`, `created_at`, `updated_at`, `type`) VALUES
	(1, '超级管理员', '', 100, '开启', '2023-10-24 20:53:53', '2023-10-26 07:34:46', '管理员');

-- 导出  表 versa.user_token 结构
DROP TABLE IF EXISTS `user_token`;
CREATE TABLE IF NOT EXISTS `user_token` (
  `user_id` bigint NOT NULL COMMENT '用户ID',
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'token',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 正在导出表  versa.user_token 的数据：~2 rows (大约)
DELETE FROM `user_token`;
INSERT INTO `user_token` (`user_id`, `token`, `created_at`, `updated_at`) VALUES
	(1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MSwidGltZSI6MTcwOTIxNDM0OX0.rhpLfaqZJu5udxQFv9KETSCtLHT7DOPaIIpNQx_Jsko', '2024-02-29 13:45:49', NULL),
	(1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MSwidGltZSI6MTcwOTIzNTU5Nn0.aXahH578mmPQHOpKWxA5RpmZQ8pfKSDVNGLli41Bwfk', '2024-02-29 19:39:56', NULL),
	(1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MSwidGltZSI6MTcwOTIzNjI4MX0.ovJjOG8c2UfBvhV7Hmsi_4_B4qLEmf_a_GZiwXM4ljw', '2024-02-29 19:51:21', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
