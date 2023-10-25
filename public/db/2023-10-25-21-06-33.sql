-- MySQL dump 10.13  Distrib 8.1.0, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: versa
-- ------------------------------------------------------
-- Server version	8.1.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin_cate`
--

DROP TABLE IF EXISTS `admin_cate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_cate` (
  `id` bigint NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `pid` bigint NOT NULL DEFAULT '0' COMMENT '上级ID',
  `level` tinyint(1) NOT NULL DEFAULT '1' COMMENT '级别',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '名称',
  `type` enum('分类','页面') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '分类' COMMENT '类型',
  `path` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '路由',
  `view` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'vue文件路径',
  `icon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '图标',
  `sort` int NOT NULL DEFAULT '100' COMMENT '排序',
  `state` enum('开启','关闭') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '开启' COMMENT '状态',
  `show` enum('是','否') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '是' COMMENT '是否显示',
  `active` bigint DEFAULT NULL COMMENT '选中状态的栏目，空表示使用自身作为选中状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='后台栏目';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_cate`
--

LOCK TABLES `admin_cate` WRITE;
/*!40000 ALTER TABLE `admin_cate` DISABLE KEYS */;
INSERT INTO `admin_cate` VALUES (1,0,1,'系统设置','分类','','','Setting',100,'开启','是',NULL),(2,1,2,'后台栏目','页面','setting/adminCate/index','../views/setting/adminCate/index.vue','',100,'开启','是',NULL),(7,0,1,'角色管理','分类','','','User',100,'开启','是',NULL),(8,7,2,'管理员','页面','role/admin/index','../views/role/admin/index.vue','',100,'开启','是',NULL),(9,7,2,'管理员组','页面','role/group/index','../views/role/group/index.vue','',100,'开启','是',NULL),(10,7,2,'权限','页面','role/auth/index','../views/role/auth/index.vue','',100,'开启','是',NULL),(13,1,2,'数据表','页面','setting/table/index','../views/setting/table/index.vue','',100,'开启','是',NULL),(16,13,3,'数据表字段','页面','setting/table/field','../views/setting/table/field.vue',NULL,100,'开启','否',13),(17,1,2,'系统配置','页面','setting/config/index','../views/setting/config/index.vue','',99,'开启','是',0);
/*!40000 ALTER TABLE `admin_cate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `config`
--

DROP TABLE IF EXISTS `config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `config` (
  `id` bigint NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '名称',
  `val` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '值',
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '分类',
  `field_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '单行文本' COMMENT '数据类型：单行文本、单行数字、多行文本、单选项、多选项、下拉菜单、上传图片、上传视频、上传文件、编辑器、',
  `vals` text COLLATE utf8mb4_general_ci COMMENT '可选值，'',''隔开',
  `sort` int NOT NULL DEFAULT '100' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='系统配置';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config`
--

LOCK TABLES `config` WRITE;
/*!40000 ALTER TABLE `config` DISABLE KEYS */;
INSERT INTO `config` VALUES (1,'网站名称','测试网站','site','单行文本','',100),(2,'单行数字','333','site','单行数字','',100),(3,'多行文本','fsdf','site','多行文本','',100),(4,'单选项','关闭','site','单选项','开启,关闭',100),(5,'下拉菜单','b','site','下拉菜单','a,b,c',100),(6,'上传文件','<p>fdf</p>','site','编辑器','',100),(7,'编辑器','[{\"mime\":\"image\\/jpeg\",\"size\":317954,\"extension\":\"jpg\",\"name\":\"R-C (1).jpg\",\"type\":\"image\",\"path\":\"\\/static\\/image\\/2023-10-25\\/R-C (1).jpg\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/static\\/image\\/2023-10-25\\/R-C (1).jpg\"},{\"mime\":\"image\\/jpeg\",\"size\":207443,\"extension\":\"jpg\",\"name\":\"R-C.jpg\",\"type\":\"image\",\"path\":\"\\/static\\/image\\/2023-10-25\\/R-C.jpg\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/static\\/image\\/2023-10-25\\/R-C.jpg\"}]','site','上传文件','',100);
/*!40000 ALTER TABLE `config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='用户';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,1,'管理员','admin','$2y$10$4vGK0H44LOiLanBkodhw8ejnBWhAYWy8DGFI4yd0anOsJWVfdop5S','[{\"mime\":\"image\\/jpeg\",\"size\":207443,\"extension\":\"jpg\",\"name\":\"R-C.jpg\",\"type\":\"image\",\"path\":\"\\/static\\/image\\/2023-10-25\\/R-C.jpg\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/static\\/image\\/2023-10-25\\/R-C.jpg\"}]',0,'开启','2023-10-10 06:14:16','2023-10-25 09:30:16'),(2,1,'管理员','gmood','$2y$10$vU24rhzYiHaqv5sWp8nB/OSh0fCMWr6UFdXrWlEG8hDLVvwFpS8Ui','',100,'开启','2023-10-24 22:03:50',NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_auth`
--

DROP TABLE IF EXISTS `user_auth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_auth` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `pid` bigint NOT NULL DEFAULT '0' COMMENT '父ID',
  `level` int NOT NULL DEFAULT '1' COMMENT '级别',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '权限名',
  `route` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '路由',
  `sort` int NOT NULL DEFAULT '100' COMMENT '排序',
  `state` enum('开启','关闭') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '开启' COMMENT '状态',
  `type` enum('管理员') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '管理员' COMMENT '类型',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC COMMENT='用户权限';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_auth`
--

LOCK TABLES `user_auth` WRITE;
/*!40000 ALTER TABLE `user_auth` DISABLE KEYS */;
INSERT INTO `user_auth` VALUES (1,0,1,'角色管理',NULL,100,'开启','管理员'),(3,0,1,'admin',NULL,100,'开启','管理员'),(9,1,2,'管理员','',100,'开启','管理员'),(10,3,2,'gsg','rewr',100,'开启','管理员'),(11,10,3,'fdsf','fdsf',100,'开启','管理员'),(12,0,1,'das','das',100,'开启','管理员'),(13,9,3,'管理员信息','admin/user.User/Me',100,'开启','管理员');
/*!40000 ALTER TABLE `user_auth` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_group`
--

DROP TABLE IF EXISTS `user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_group` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_group`
--

LOCK TABLES `user_group` WRITE;
/*!40000 ALTER TABLE `user_group` DISABLE KEYS */;
INSERT INTO `user_group` VALUES (1,'超级管理员',',1,9,13,3,10,11',100,'开启','2023-10-24 20:53:53','2023-10-24 22:18:19','管理员');
/*!40000 ALTER TABLE `user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_token`
--

DROP TABLE IF EXISTS `user_token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_token` (
  `user_id` bigint NOT NULL COMMENT '用户ID',
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'token',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_token`
--

LOCK TABLES `user_token` WRITE;
/*!40000 ALTER TABLE `user_token` DISABLE KEYS */;
INSERT INTO `user_token` VALUES (2,'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MiwidGltZSI6MTY5ODE4NTA1NH0.xpkK4MTHd4L5xfWoq_yvvXE34YyyOxIzw3ZzU-3uUaw','2023-10-24 22:04:14',NULL),(1,'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MSwidGltZSI6MTY5ODE4Njg0N30.v--TnsqXvlhTkwJYEiNU5iHDPKHivwQO4KLuRja0aqg','2023-10-24 22:34:07',NULL),(1,'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MSwidGltZSI6MTY5ODIzMDU1M30.oqRApue2sfvULZhNRymJuMLiB2SKXQFaQ9OJPLcFayo','2023-10-25 10:42:33',NULL);
/*!40000 ALTER TABLE `user_token` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-10-25 21:06:34
