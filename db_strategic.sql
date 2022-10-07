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
  `budget_specify_status` enum('active','inactive') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_budget`
--

LOCK TABLES `tbl_budget` WRITE;
/*!40000 ALTER TABLE `tbl_budget` DISABLE KEYS */;
INSERT INTO `tbl_budget` VALUES (2,'งบประมาณแผ่นดิน','inactive','2022-10-05 02:00:19','2022-10-06 04:18:34'),(3,'งบประมาณรายได้มหาวิทยาลัย','inactive','2022-10-06 04:10:16','2022-10-06 04:18:31'),(4,'งบประมาณสนับสนุนอื่น ๆ','active','2022-10-06 04:10:28','2022-10-06 04:18:38');
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_faculty`
--

LOCK TABLES `tbl_faculty` WRITE;
/*!40000 ALTER TABLE `tbl_faculty` DISABLE KEYS */;
INSERT INTO `tbl_faculty` VALUES (3,'คณะวิทยาศาสตร์เละเทคโนโลยี','2022-10-04 04:37:36','2022-10-06 04:09:20'),(4,'คณะครุศาสตร์','2022-10-06 04:09:10','2022-10-06 04:09:10');
/*!40000 ALTER TABLE `tbl_faculty` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_project`
--

DROP TABLE IF EXISTS `tbl_project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_project` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_name` varchar(255) DEFAULT '',
  `project_budget` decimal(10,2) DEFAULT NULL,
  `project_target_group` text DEFAULT NULL,
  `project_problem` text DEFAULT NULL,
  `project_solotion_problem` text DEFAULT NULL,
  `project_period_start` date DEFAULT NULL,
  `project_period_end` date DEFAULT NULL,
  `project_quantitative_indicators` text DEFAULT NULL,
  `project_qualitative_indicators` text DEFAULT NULL,
  `project_output` text DEFAULT NULL,
  `project_outcome` text DEFAULT NULL,
  `project_status` enum('draff','pending','publish','unpublish') DEFAULT NULL,
  `year_id` int(11) DEFAULT NULL,
  `year_strategic_id` varchar(11) DEFAULT NULL,
  `year_strategic_detail_id` varchar(11) DEFAULT NULL,
  `budget_id` varchar(11) DEFAULT NULL,
  `budget_specify_other` varchar(255) DEFAULT '',
  `project_type_id` varchar(11) DEFAULT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_project`
--

LOCK TABLES `tbl_project` WRITE;
/*!40000 ALTER TABLE `tbl_project` DISABLE KEYS */;
INSERT INTO `tbl_project` VALUES (2,'5555',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'draff',1,NULL,NULL,NULL,NULL,NULL,NULL,'2022-10-06 06:43:07','2022-10-06 06:50:30'),(3,'666',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'draff',1,NULL,NULL,NULL,NULL,NULL,NULL,'2022-10-06 06:50:35','2022-10-06 06:50:35'),(4,'dasds',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'draff',1,NULL,NULL,NULL,NULL,NULL,NULL,'2022-10-06 06:54:52','2022-10-06 06:54:52');
/*!40000 ALTER TABLE `tbl_project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_project_impact`
--

DROP TABLE IF EXISTS `tbl_project_impact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_project_impact` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_impact_detail` varchar(255) DEFAULT '',
  `project_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_project_impact`
--

LOCK TABLES `tbl_project_impact` WRITE;
/*!40000 ALTER TABLE `tbl_project_impact` DISABLE KEYS */;
INSERT INTO `tbl_project_impact` VALUES (14,'/878787',2,'2022-10-07 07:01:04','2022-10-07 07:01:04');
/*!40000 ALTER TABLE `tbl_project_impact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_project_outcome`
--

DROP TABLE IF EXISTS `tbl_project_outcome`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_project_outcome` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_outcome_detail` varchar(255) DEFAULT '',
  `project_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_project_outcome`
--

LOCK TABLES `tbl_project_outcome` WRITE;
/*!40000 ALTER TABLE `tbl_project_outcome` DISABLE KEYS */;
INSERT INTO `tbl_project_outcome` VALUES (9,'ฟกฟห',2,'2022-10-07 04:00:55','2022-10-07 04:00:55'),(11,'565656',2,'2022-10-07 06:51:04','2022-10-07 06:51:04');
/*!40000 ALTER TABLE `tbl_project_outcome` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_project_output`
--

DROP TABLE IF EXISTS `tbl_project_output`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_project_output` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_output_detail` varchar(255) DEFAULT '',
  `project_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_project_output`
--

LOCK TABLES `tbl_project_output` WRITE;
/*!40000 ALTER TABLE `tbl_project_output` DISABLE KEYS */;
INSERT INTO `tbl_project_output` VALUES (9,'ฟกฟห',2,'2022-10-07 04:00:55','2022-10-07 04:00:55'),(11,'565656',2,'2022-10-07 06:51:04','2022-10-07 06:51:04');
/*!40000 ALTER TABLE `tbl_project_output` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_project_output_gallery`
--

DROP TABLE IF EXISTS `tbl_project_output_gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_project_output_gallery` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_output_gallery_path` varchar(255) DEFAULT '',
  `project_output_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_project_output_gallery`
--

LOCK TABLES `tbl_project_output_gallery` WRITE;
/*!40000 ALTER TABLE `tbl_project_output_gallery` DISABLE KEYS */;
INSERT INTO `tbl_project_output_gallery` VALUES (1,'asdasd',11,'2022-10-07 09:16:18','2022-10-07 09:16:18'),(2,'file-project-output/x4FXbn0yjAfX77yYA0TEYQkJMCA9wRSYtD0UQibG.png',11,'2022-10-07 09:23:35','2022-10-07 09:23:35'),(3,'file-project-output/ffps7QCyH0L6sH4mOhr1iB7dClUEKRYDuj4ns5wF.jpg',11,'2022-10-07 09:23:35','2022-10-07 09:23:35'),(4,'file-project-output/huvOrXdMTyjz3B9Tz4LN4dwm20WUY49lrNv4fAai.png',11,'2022-10-07 09:27:14','2022-10-07 09:27:14'),(5,'file-project-output/stH45LcY8hNlmhsB71j9hmYy1Um3fq7WqsKb3oqV.jpg',11,'2022-10-07 09:27:14','2022-10-07 09:27:14'),(6,'file-project-output/aV6KFIMTFBkTrxn4G2rmunlo87EqBdEhJ9hzLHQv.jpg',11,'2022-10-07 09:28:21','2022-10-07 09:28:21'),(7,'file-project-output/VAVkUyCwThux0XV4u9Kf7RyfBT1vvETEmmxCkkUf.jpg',11,'2022-10-07 09:28:21','2022-10-07 09:28:21'),(8,'file-project-output/pJWz1EuPPPARHDBEHSGHAnetYMkAWE4rol9j9vIV.jpg',11,'2022-10-07 09:28:21','2022-10-07 09:28:21'),(9,'file-project-output/2iYtSm83OlHOQllGatxYqVFimB2oa49EAP3uUvy7.jpg',11,'2022-10-07 09:36:15','2022-10-07 09:36:15'),(10,'file-project-output/Arrz48DUuSeSqmc9jKmqZpdUKRLmL0wBpmgqQtHt.jpg',11,'2022-10-07 09:36:15','2022-10-07 09:36:15'),(11,'file-project-output/47nS910sKgyZTm098hlTHjtgD93AZbKFOcByDzfP.jpg',11,'2022-10-07 09:36:15','2022-10-07 09:36:15'),(12,'file-project-output/cDrRtZO9Fcnzo2xuvhwri9kOyvjZ46j5bAS3fRQy.jpg',11,'2022-10-07 09:39:32','2022-10-07 09:39:32');
/*!40000 ALTER TABLE `tbl_project_output_gallery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_project_problem`
--

DROP TABLE IF EXISTS `tbl_project_problem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_project_problem` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_problem_detail` varchar(255) DEFAULT '',
  `project_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_project_problem`
--

LOCK TABLES `tbl_project_problem` WRITE;
/*!40000 ALTER TABLE `tbl_project_problem` DISABLE KEYS */;
INSERT INTO `tbl_project_problem` VALUES (8,'กกกกกdssdsdsd',2,'2022-10-07 04:00:52','2022-10-07 04:08:05'),(9,'ฟกฟห',2,'2022-10-07 04:00:55','2022-10-07 04:00:55');
/*!40000 ALTER TABLE `tbl_project_problem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_project_problem_solution`
--

DROP TABLE IF EXISTS `tbl_project_problem_solution`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_project_problem_solution` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_problem_solution_detail` varchar(255) DEFAULT '',
  `project_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_project_problem_solution`
--

LOCK TABLES `tbl_project_problem_solution` WRITE;
/*!40000 ALTER TABLE `tbl_project_problem_solution` DISABLE KEYS */;
INSERT INTO `tbl_project_problem_solution` VALUES (9,'ฟกฟห',2,'2022-10-07 04:00:55','2022-10-07 04:00:55'),(11,'asdasd9999',2,'2022-10-07 04:30:00','2022-10-07 04:37:08'),(12,'5555',2,'2022-10-07 04:31:39','2022-10-07 04:31:39'),(14,'sfdsdf',2,'2022-10-07 04:35:27','2022-10-07 04:35:27'),(15,'33333',2,'2022-10-07 04:35:56','2022-10-07 04:35:56'),(16,'22156454',2,'2022-10-07 04:36:20','2022-10-07 04:36:20');
/*!40000 ALTER TABLE `tbl_project_problem_solution` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_project_qualitative_indicators`
--

DROP TABLE IF EXISTS `tbl_project_qualitative_indicators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_project_qualitative_indicators` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_qualitative_indicators_value` varchar(100) DEFAULT '',
  `project_qualitative_indicators_unit` varchar(50) DEFAULT '',
  `project_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_project_qualitative_indicators`
--

LOCK TABLES `tbl_project_qualitative_indicators` WRITE;
/*!40000 ALTER TABLE `tbl_project_qualitative_indicators` DISABLE KEYS */;
INSERT INTO `tbl_project_qualitative_indicators` VALUES (13,'50','ร้อยละ',2,'2022-10-07 06:31:30','2022-10-07 06:31:30');
/*!40000 ALTER TABLE `tbl_project_qualitative_indicators` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_project_quantitative_indicators`
--

DROP TABLE IF EXISTS `tbl_project_quantitative_indicators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_project_quantitative_indicators` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_quantitative_indicators_value` varchar(100) DEFAULT '',
  `project_quantitative_indicators_unit` varchar(50) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_project_quantitative_indicators`
--

LOCK TABLES `tbl_project_quantitative_indicators` WRITE;
/*!40000 ALTER TABLE `tbl_project_quantitative_indicators` DISABLE KEYS */;
INSERT INTO `tbl_project_quantitative_indicators` VALUES (13,'50','ร้อยละ',2,'2022-10-07 06:31:30','2022-10-07 06:31:30');
/*!40000 ALTER TABLE `tbl_project_quantitative_indicators` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_project_responsible_person`
--

DROP TABLE IF EXISTS `tbl_project_responsible_person`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_project_responsible_person` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_responsible_person_name` varchar(255) DEFAULT NULL,
  `project_responsible_person_tel` varchar(10) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_project_responsible_person`
--

LOCK TABLES `tbl_project_responsible_person` WRITE;
/*!40000 ALTER TABLE `tbl_project_responsible_person` DISABLE KEYS */;
INSERT INTO `tbl_project_responsible_person` VALUES (1,'นายหรรษธร ขวัญหอม','0956341741',2,'2022-10-07 02:40:56','2022-10-07 04:02:03'),(2,'นายไพบูลย์ กันยา','0956633224',2,'2022-10-07 03:04:00','2022-10-07 03:05:43'),(7,'นางวรรณภัสร์ ปราบพาลา','0956633227',2,'2022-10-07 07:06:28','2022-10-07 07:06:28');
/*!40000 ALTER TABLE `tbl_project_responsible_person` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_project_target_group`
--

DROP TABLE IF EXISTS `tbl_project_target_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_project_target_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_target_group_detail` varchar(255) DEFAULT '',
  `project_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_project_target_group`
--

LOCK TABLES `tbl_project_target_group` WRITE;
/*!40000 ALTER TABLE `tbl_project_target_group` DISABLE KEYS */;
INSERT INTO `tbl_project_target_group` VALUES (7,'นฟหกฟหกฟหกกหกหก',2,'2022-10-07 04:00:36','2022-10-07 04:00:43'),(8,'กกกกก',2,'2022-10-07 04:00:52','2022-10-07 04:00:52'),(9,'ฟกฟห5454',2,'2022-10-07 04:00:55','2022-10-07 04:54:25'),(10,'123123123123',2,'2022-10-07 04:02:13','2022-10-07 04:02:13'),(11,'5454',2,'2022-10-07 04:54:14','2022-10-07 04:54:14'),(12,'1545',2,'2022-10-07 04:54:17','2022-10-07 04:54:17');
/*!40000 ALTER TABLE `tbl_project_target_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_project_type`
--

DROP TABLE IF EXISTS `tbl_project_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_project_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_type_name` varchar(255) DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_project_type`
--

LOCK TABLES `tbl_project_type` WRITE;
/*!40000 ALTER TABLE `tbl_project_type` DISABLE KEYS */;
INSERT INTO `tbl_project_type` VALUES (2,'กิจกรรมการพัฒนา','2022-10-05 07:13:37','2022-10-06 04:42:15'),(3,'กิจกรรมการวิจัย','2022-10-06 04:42:23','2022-10-06 04:42:23'),(4,'กิจกรรมการอบรม','2022-10-06 04:42:39','2022-10-06 04:42:39'),(5,'กิจกรรมบริการวิชาการ','2022-10-06 04:42:54','2022-10-06 04:42:54'),(6,'กิจกรรมสัมพันธ์','2022-10-06 04:43:03','2022-10-06 04:43:03');
/*!40000 ALTER TABLE `tbl_project_type` ENABLE KEYS */;
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
  `faculty_id` varchar(11) DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_user`
--

LOCK TABLES `tbl_user` WRITE;
/*!40000 ALTER TABLE `tbl_user` DISABLE KEYS */;
INSERT INTO `tbl_user` VALUES (1,'นาย','หรรษธร','ขวัญหอม','admin','$2y$10$AbBm6g9B0D3.HthveoJWO.L0jALRBlS4P7uRnslJOI9zKLdkjruu.','admin','other','2022-10-04 04:38:45','2022-10-06 06:15:32'),(3,'ผศ.','เจษฎาภรณ์','ปาคำวัง','user1','$2y$10$1PN53rZSYd8rkm4A4O8uc./mBiBQ.SVoh9f9C.6v8fkUbQYtX.m7W','user','3','2022-10-06 04:45:02','2022-10-06 04:45:55');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_year`
--

LOCK TABLES `tbl_year` WRITE;
/*!40000 ALTER TABLE `tbl_year` DISABLE KEYS */;
INSERT INTO `tbl_year` VALUES (1,'2565','active','2022-10-06 04:02:50','2022-10-06 04:08:43');
/*!40000 ALTER TABLE `tbl_year` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `delete_year_strategic` BEFORE DELETE ON `tbl_year`
FOR EACH ROW DELETE FROM  tbl_year_strategic WHERE tbl_year_strategic.id = id */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
INSERT INTO `tbl_year_strategic` VALUES (1,1,2,'2022-10-06 04:05:10','2022-10-06 04:05:10'),(2,1,3,'2022-10-06 04:05:55','2022-10-06 04:05:55'),(3,1,4,'2022-10-06 04:06:05','2022-10-06 04:06:05'),(4,1,5,'2022-10-06 04:06:13','2022-10-06 04:06:13');
/*!40000 ALTER TABLE `tbl_year_strategic` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `delete_year_strategic_detail` BEFORE DELETE ON `tbl_year_strategic`
FOR EACH ROW DELETE FROM tbl_year_strategic_detail
WHERE tbl_year_strategic_detail.id = id */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `tbl_year_strategic_detail`
--

DROP TABLE IF EXISTS `tbl_year_strategic_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_year_strategic_detail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `year_strategic_detail_detail` varchar(255) DEFAULT NULL,
  `year_strategic_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_year_strategic_detail`
--

LOCK TABLES `tbl_year_strategic_detail` WRITE;
/*!40000 ALTER TABLE `tbl_year_strategic_detail` DISABLE KEYS */;
INSERT INTO `tbl_year_strategic_detail` VALUES (1,'ด้านเศรษฐกิจ',1,'2022-10-06 04:05:10','2022-10-06 04:05:10'),(2,'ด้านสังคม',1,'2022-10-06 04:05:10','2022-10-06 04:05:10'),(3,'ด้านสิ่งแวดล้อม',1,'2022-10-06 04:05:10','2022-10-06 04:05:10'),(4,'ด้านการศึกษา',1,'2022-10-06 04:05:10','2022-10-06 04:05:10'),(5,'การผลิตครู',2,'2022-10-06 04:05:55','2022-10-06 04:05:55'),(6,'การพัฒนาครู (บัณฑิต มรภ.)',2,'2022-10-06 04:05:55','2022-10-06 04:05:55');
/*!40000 ALTER TABLE `tbl_year_strategic_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `view_project`
--

DROP TABLE IF EXISTS `view_project`;
/*!50001 DROP VIEW IF EXISTS `view_project`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `view_project` (
  `id` tinyint NOT NULL,
  `project_name` tinyint NOT NULL,
  `project_budget` tinyint NOT NULL,
  `project_target_group` tinyint NOT NULL,
  `project_problem` tinyint NOT NULL,
  `project_solotion_problem` tinyint NOT NULL,
  `project_period_start` tinyint NOT NULL,
  `project_period_end` tinyint NOT NULL,
  `project_quantitative_indicators` tinyint NOT NULL,
  `project_qualitative_indicators` tinyint NOT NULL,
  `project_output` tinyint NOT NULL,
  `project_outcome` tinyint NOT NULL,
  `project_status` tinyint NOT NULL,
  `year_id` tinyint NOT NULL,
  `year_strategic_id` tinyint NOT NULL,
  `year_strategic_detail_id` tinyint NOT NULL,
  `budget_id` tinyint NOT NULL,
  `project_type_id` tinyint NOT NULL,
  `created_at` tinyint NOT NULL,
  `updated_at` tinyint NOT NULL,
  `year_name` tinyint NOT NULL,
  `strategic_name` tinyint NOT NULL,
  `budget_specify_other` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

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
  `strategic_name` tinyint NOT NULL,
  `count_year_strategic_detail` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `view_project`
--

/*!50001 DROP TABLE IF EXISTS `view_project`*/;
/*!50001 DROP VIEW IF EXISTS `view_project`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_project` AS select `tbl_project`.`id` AS `id`,`tbl_project`.`project_name` AS `project_name`,`tbl_project`.`project_budget` AS `project_budget`,`tbl_project`.`project_target_group` AS `project_target_group`,`tbl_project`.`project_problem` AS `project_problem`,`tbl_project`.`project_solotion_problem` AS `project_solotion_problem`,`tbl_project`.`project_period_start` AS `project_period_start`,`tbl_project`.`project_period_end` AS `project_period_end`,`tbl_project`.`project_quantitative_indicators` AS `project_quantitative_indicators`,`tbl_project`.`project_qualitative_indicators` AS `project_qualitative_indicators`,`tbl_project`.`project_output` AS `project_output`,`tbl_project`.`project_outcome` AS `project_outcome`,`tbl_project`.`project_status` AS `project_status`,`tbl_project`.`year_id` AS `year_id`,`tbl_project`.`year_strategic_id` AS `year_strategic_id`,`tbl_project`.`year_strategic_detail_id` AS `year_strategic_detail_id`,`tbl_project`.`budget_id` AS `budget_id`,`tbl_project`.`project_type_id` AS `project_type_id`,`tbl_project`.`created_at` AS `created_at`,`tbl_project`.`updated_at` AS `updated_at`,`tbl_year`.`year_name` AS `year_name`,`tbl_strategic`.`strategic_name` AS `strategic_name`,`tbl_project`.`budget_specify_other` AS `budget_specify_other` from (((`tbl_project` left join `tbl_year` on(`tbl_project`.`year_id` = `tbl_year`.`id`)) left join `tbl_year_strategic` on(`tbl_project`.`year_strategic_id` = `tbl_year_strategic`.`id`)) left join `tbl_strategic` on(`tbl_year_strategic`.`strategic_id` = `tbl_strategic`.`id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

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
/*!50001 VIEW `view_user` AS select `tbl_user`.`id` AS `id`,`tbl_user`.`user_prefix` AS `user_prefix`,`tbl_user`.`user_name` AS `user_name`,`tbl_user`.`user_last` AS `user_last`,concat(`tbl_user`.`user_prefix`,`tbl_user`.`user_name`,' ',`tbl_user`.`user_last`) AS `full_name`,`tbl_user`.`username` AS `username`,`tbl_user`.`password` AS `password`,`tbl_user`.`user_role` AS `user_role`,`tbl_user`.`faculty_id` AS `faculty_id`,if(`tbl_user`.`faculty_id` = 'other','ผู้ดูแลระบบมหาวิทยาลัย',`tbl_faculty`.`faculty_name`) AS `faculty_name`,`tbl_user`.`created_at` AS `created_at`,`tbl_user`.`updated_at` AS `updated_at` from (`tbl_user` left join `tbl_faculty` on(`tbl_user`.`faculty_id` = `tbl_faculty`.`id`)) */;
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
/*!50001 VIEW `view_year_strategic` AS select `tbl_year_strategic`.`id` AS `id`,`tbl_year_strategic`.`year_id` AS `year_id`,`tbl_year_strategic`.`strategic_id` AS `strategic_id`,`tbl_year_strategic`.`created_at` AS `created_at`,`tbl_year_strategic`.`updated_at` AS `updated_at`,`tbl_year`.`year_name` AS `year_name`,`tbl_strategic`.`strategic_name` AS `strategic_name`,ifnull((select count(`tbl_year_strategic_detail`.`id`) from `tbl_year_strategic_detail` where `tbl_year_strategic_detail`.`year_strategic_id` = `tbl_year_strategic`.`id`),0) AS `count_year_strategic_detail` from ((`tbl_year_strategic` left join `tbl_year` on(`tbl_year_strategic`.`year_id` = `tbl_year`.`id`)) left join `tbl_strategic` on(`tbl_year_strategic`.`strategic_id` = `tbl_strategic`.`id`)) */;
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

-- Dump completed on 2022-10-07 16:43:00
