-- MariaDB dump 10.19  Distrib 10.6.4-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: db_strategic
-- ------------------------------------------------------
-- Server version	10.6.4-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tbl_budget`
--

DROP TABLE IF EXISTS `tbl_budget`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_budget` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `budget_name` varchar(255) DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_budget`
--

LOCK TABLES `tbl_budget` WRITE;
/*!40000 ALTER TABLE `tbl_budget` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_budget` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_faculty`
--

DROP TABLE IF EXISTS `tbl_faculty`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_faculty` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `faculty_name` varchar(255) DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_faculty`
--

LOCK TABLES `tbl_faculty` WRITE;
/*!40000 ALTER TABLE `tbl_faculty` DISABLE KEYS */;
INSERT INTO `tbl_faculty` VALUES (3,'คณะวิทยาศาสตร์','2022-10-04 04:37:36','2022-10-04 04:37:36');
/*!40000 ALTER TABLE `tbl_faculty` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_result_analysis`
--

DROP TABLE IF EXISTS `tbl_result_analysis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_result_analysis` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `swot_strength` longtext DEFAULT NULL,
  `swot_weakness` longtext DEFAULT NULL,
  `swot_opportunity` longtext DEFAULT NULL,
  `swot_threat` longtext DEFAULT NULL,
  `tow_so` longtext DEFAULT NULL,
  `tow_wo` longtext DEFAULT NULL,
  `tow_st` longtext DEFAULT NULL,
  `tow_wt` longtext DEFAULT NULL,
  `year_strategic_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_result_analysis`
--

LOCK TABLES `tbl_result_analysis` WRITE;
/*!40000 ALTER TABLE `tbl_result_analysis` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_result_analysis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_strategic`
--

DROP TABLE IF EXISTS `tbl_strategic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_strategic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `strategic_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_strategic`
--

LOCK TABLES `tbl_strategic` WRITE;
/*!40000 ALTER TABLE `tbl_strategic` DISABLE KEYS */;
INSERT INTO `tbl_strategic` VALUES (2,'ยุทธศาสตร์การพัฒนาท้องถิ่น','2022-10-04 04:01:29','2022-10-04 06:26:13'),(3,'ยุทธศาสตร์การผลิดและพัฒนาครู','2022-10-04 06:26:31','2022-10-04 06:26:31'),(4,'ยุทธศาสตร์การยกระดับคุณภาพการศึกษา','2022-10-04 06:26:53','2022-10-04 06:27:00'),(5,'ยุทธศาสตร์การพัฒนาระบบบริหารจัดการ','2022-10-04 06:27:18','2022-10-04 06:27:18');
/*!40000 ALTER TABLE `tbl_strategic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_user`
--

DROP TABLE IF EXISTS `tbl_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_prefix` varchar(30) DEFAULT '',
  `user_name` varchar(50) DEFAULT '',
  `user_last` varchar(70) DEFAULT '',
  `username` varchar(50) DEFAULT '',
  `password` varchar(100) DEFAULT '',
  `user_role` enum('admin','user') DEFAULT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_user`
--

LOCK TABLES `tbl_user` WRITE;
/*!40000 ALTER TABLE `tbl_user` DISABLE KEYS */;
INSERT INTO `tbl_user` VALUES (1,'นาย','หรรษธร','ขวัญหอม','admin','$2y$10$AbBm6g9B0D3.HthveoJWO.L0jALRBlS4P7uRnslJOI9zKLdkjruu.','admin',99,'2022-10-04 04:38:45','2022-10-04 06:28:47');
/*!40000 ALTER TABLE `tbl_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_year`
--

DROP TABLE IF EXISTS `tbl_year`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_year` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `year_name` varchar(4) NOT NULL,
  `year_status` enum('active','inactive') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_year`
--

LOCK TABLES `tbl_year` WRITE;
/*!40000 ALTER TABLE `tbl_year` DISABLE KEYS */;
INSERT INTO `tbl_year` VALUES (4,'2565','active','2022-10-04 07:32:32','2022-10-04 09:37:46'),(5,'2566','inactive','2022-10-04 09:36:42','2022-10-04 09:37:46');
/*!40000 ALTER TABLE `tbl_year` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_year_strategic`
--

DROP TABLE IF EXISTS `tbl_year_strategic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_year_strategic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `year_id` int(11) DEFAULT NULL,
  `strategic_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_year_strategic`
--

LOCK TABLES `tbl_year_strategic` WRITE;
/*!40000 ALTER TABLE `tbl_year_strategic` DISABLE KEYS */;
INSERT INTO `tbl_year_strategic` VALUES (1,4,2,'2022-10-04 09:37:46','2022-10-04 09:37:46'),(2,4,3,'2022-10-04 09:37:46','2022-10-04 09:37:46'),(3,4,4,'2022-10-04 09:37:46','2022-10-04 09:37:46'),(4,4,5,'2022-10-04 09:37:46','2022-10-04 09:37:46');
/*!40000 ALTER TABLE `tbl_year_strategic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `view_user`
--

DROP TABLE IF EXISTS `view_user`;
/*!50001 DROP VIEW IF EXISTS `view_user`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `view_user` (
  `id` tinyint NOT NULL,
  `user_prefix` tinyint NOT NULL,
  `user_name` tinyint NOT NULL,
  `user_last` tinyint NOT NULL,
  `full_name` tinyint NOT NULL,
  `username` tinyint NOT NULL,
  `password` tinyint NOT NULL,
  `user_role` tinyint NOT NULL,
  `faculty_id` tinyint NOT NULL,
  `faculty_name` tinyint NOT NULL,
  `created_at` tinyint NOT NULL,
  `updated_at` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_year_strategic`
--

DROP TABLE IF EXISTS `view_year_strategic`;
/*!50001 DROP VIEW IF EXISTS `view_year_strategic`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `view_year_strategic` (
  `id` tinyint NOT NULL,
  `year_id` tinyint NOT NULL,
  `strategic_id` tinyint NOT NULL,
  `created_at` tinyint NOT NULL,
  `updated_at` tinyint NOT NULL,
  `year_name` tinyint NOT NULL,
  `strategic_name` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `view_user`
--

/*!50001 DROP TABLE IF EXISTS `view_user`*/;
/*!50001 DROP VIEW IF EXISTS `view_user`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_user` AS select `tbl_user`.`id` AS `id`,`tbl_user`.`user_prefix` AS `user_prefix`,`tbl_user`.`user_name` AS `user_name`,`tbl_user`.`user_last` AS `user_last`,concat(`tbl_user`.`user_prefix`,`tbl_user`.`user_name`,' ',`tbl_user`.`user_last`) AS `full_name`,`tbl_user`.`username` AS `username`,`tbl_user`.`password` AS `password`,`tbl_user`.`user_role` AS `user_role`,`tbl_user`.`faculty_id` AS `faculty_id`,if(`tbl_user`.`faculty_id` = '99','ผู้ดูแลระบบมหาวิทยาลัย',`tbl_faculty`.`faculty_name`) AS `faculty_name`,`tbl_user`.`created_at` AS `created_at`,`tbl_user`.`updated_at` AS `updated_at` from (`tbl_user` left join `tbl_faculty` on(`tbl_user`.`faculty_id` = `tbl_faculty`.`id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_year_strategic`
--

/*!50001 DROP TABLE IF EXISTS `view_year_strategic`*/;
/*!50001 DROP VIEW IF EXISTS `view_year_strategic`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_year_strategic` AS select `tbl_year_strategic`.`id` AS `id`,`tbl_year_strategic`.`year_id` AS `year_id`,`tbl_year_strategic`.`strategic_id` AS `strategic_id`,`tbl_year_strategic`.`created_at` AS `created_at`,`tbl_year_strategic`.`updated_at` AS `updated_at`,`tbl_year`.`year_name` AS `year_name`,`tbl_strategic`.`strategic_name` AS `strategic_name` from ((`tbl_year_strategic` left join `tbl_year` on(`tbl_year_strategic`.`year_id` = `tbl_year`.`id`)) left join `tbl_strategic` on(`tbl_year_strategic`.`strategic_id` = `tbl_strategic`.`id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-10-04 16:40:21
