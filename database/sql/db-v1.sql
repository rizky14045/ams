-- MySQL dump 10.16  Distrib 10.1.26-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: db_ams_pjb_2
-- ------------------------------------------------------
-- Server version	10.1.26-MariaDB-1~trusty

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `adjustment_aktiva_tetap`
--

DROP TABLE IF EXISTS `adjustment_aktiva_tetap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adjustment_aktiva_tetap` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kd_adjustment` varchar(12) NOT NULL,
  `tanggal` date NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `note` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kd_adjustment` (`kd_adjustment`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adjustment_aktiva_tetap`
--

LOCK TABLES `adjustment_aktiva_tetap` WRITE;
/*!40000 ALTER TABLE `adjustment_aktiva_tetap` DISABLE KEYS */;
INSERT INTO `adjustment_aktiva_tetap` VALUES (1,'AA170913001','2017-09-13','pluit','abcde','2017-09-12 20:49:41','2017-09-13 03:49:41',NULL),(2,'AA170913002','2017-09-13','muara karang','qwerty','2017-09-12 20:52:59','2017-09-13 03:52:59',NULL),(3,'AA170913003','2017-09-13','Depok','blabla','2017-09-12 20:54:36','2017-09-13 03:54:36',NULL),(4,'AA170916001','2017-09-16','kalimalang','abcde','2017-09-16 03:33:59','2017-09-16 10:33:59',NULL);
/*!40000 ALTER TABLE `adjustment_aktiva_tetap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adjustment_extracomptable`
--

DROP TABLE IF EXISTS `adjustment_extracomptable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adjustment_extracomptable` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kd_adjustment` varchar(12) NOT NULL,
  `tanggal` date NOT NULL,
  `id_gedung` int(10) unsigned NOT NULL,
  `lantai` int(10) NOT NULL,
  `id_ruang` int(10) unsigned NOT NULL,
  `note` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kd_adjustment` (`kd_adjustment`),
  KEY `id_gedung` (`id_gedung`),
  KEY `id_ruang` (`id_ruang`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adjustment_extracomptable`
--

LOCK TABLES `adjustment_extracomptable` WRITE;
/*!40000 ALTER TABLE `adjustment_extracomptable` DISABLE KEYS */;
INSERT INTO `adjustment_extracomptable` VALUES (1,'AE170913002','2017-09-13',1,1,2,'','2017-09-12 19:17:45','2017-09-13 02:17:45',NULL),(2,'AE170913003','2017-09-13',1,1,2,'qweqwe','2017-09-12 19:23:53','2017-09-13 02:23:53',NULL),(3,'AE170916001','2017-09-16',1,1,2,'abcde','2017-09-16 03:25:41','2017-09-16 10:25:41',NULL);
/*!40000 ALTER TABLE `adjustment_extracomptable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adjustment_inventory`
--

DROP TABLE IF EXISTS `adjustment_inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adjustment_inventory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kd_adjustment` varchar(12) NOT NULL,
  `tanggal` date NOT NULL,
  `id_gedung` int(10) unsigned NOT NULL,
  `lantai` int(10) NOT NULL,
  `id_ruang` int(10) unsigned NOT NULL,
  `note` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kd_adjustment` (`kd_adjustment`),
  KEY `id_gedung` (`id_gedung`),
  KEY `id_ruang` (`id_ruang`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adjustment_inventory`
--

LOCK TABLES `adjustment_inventory` WRITE;
/*!40000 ALTER TABLE `adjustment_inventory` DISABLE KEYS */;
INSERT INTO `adjustment_inventory` VALUES (1,'AI170913001','2017-09-13',1,1,2,'blabla','2017-09-12 20:01:34','2017-09-13 03:01:34',NULL),(2,'AI170916001','2017-09-16',1,1,2,'abcde','2017-09-16 03:40:59','2017-09-16 10:40:59',NULL);
/*!40000 ALTER TABLE `adjustment_inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asset_aktiva_tetap`
--

DROP TABLE IF EXISTS `asset_aktiva_tetap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asset_aktiva_tetap` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kd_asset` varchar(32) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `id_model` int(10) unsigned NOT NULL,
  `nama_asset` varchar(120) NOT NULL,
  `tgl_masuk` date NOT NULL,
  `status` varchar(60) NOT NULL,
  `gambar` varchar(120) NOT NULL,
  `ref_id_request` int(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kd_asset` (`kd_asset`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asset_aktiva_tetap`
--

LOCK TABLES `asset_aktiva_tetap` WRITE;
/*!40000 ALTER TABLE `asset_aktiva_tetap` DISABLE KEYS */;
INSERT INTO `asset_aktiva_tetap` VALUES (1,'01.0001','Pluit',1,'Bus PJB','2017-09-11','digunakan','58f2b4bc4934ee9ff7c3e7687505f87b-170911-59b6986874646.png',NULL,'2017-09-11 14:10:15','2017-09-11 14:06:32','2017-09-11 14:10:15'),(2,'02.0001','kalimalang',2,'Gedung Kampus PJB','2017-09-11','digunakan','13cb403b5867729637bcae859d21f745-170911-59b6989681bff.png',NULL,'2017-09-12 16:30:09','2017-09-12 16:30:09',NULL),(3,'02.0002','kalimalang',2,'Gudang Batu Baraa','2017-09-05','digunakan','f0542a6048926064748aa2da2a92f0e7-170911-59b6993f65f02.png',NULL,'2017-09-12 16:30:09','2017-09-12 16:30:09',NULL);
/*!40000 ALTER TABLE `asset_aktiva_tetap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asset_extracomptable`
--

DROP TABLE IF EXISTS `asset_extracomptable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asset_extracomptable` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kd_asset` varchar(32) NOT NULL,
  `id_gedung` int(10) unsigned NOT NULL,
  `lantai` int(10) NOT NULL,
  `id_ruang` int(10) unsigned NOT NULL,
  `id_jenis` int(10) unsigned NOT NULL,
  `id_subjenis` int(10) unsigned NOT NULL,
  `nama_asset` varchar(120) NOT NULL,
  `tgl_masuk` date NOT NULL,
  `status` varchar(60) NOT NULL,
  `gambar` varchar(120) NOT NULL,
  `ref_id_request` int(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kd_asset` (`kd_asset`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asset_extracomptable`
--

LOCK TABLES `asset_extracomptable` WRITE;
/*!40000 ALTER TABLE `asset_extracomptable` DISABLE KEYS */;
INSERT INTO `asset_extracomptable` VALUES (1,'01.1.02.01.02.0001',1,1,2,1,4,'Meja Bulet','2017-09-11','digunakan','da49854a0c31e770a5b4be9e136831d8-170911-59b688522752b.png',NULL,'2017-09-12 15:16:35','2017-09-12 15:16:35',NULL),(2,'01.1.02.01.02.0002',1,1,2,1,4,'Meja Bulet','2017-09-11','digunakan','9bb309e8d7bc385d8687264bae5bee8a-170911-59b689df8cf72.png',NULL,'2017-09-13 04:38:01','2017-09-13 04:38:01',NULL),(3,'01.1.02.01.02.0003',1,1,2,1,4,'Meja Bulet','2017-09-12','digunakan','c028723fcb5351d0e395801ac6c68119-170911-59b68e84b03fa.png',NULL,'2017-09-11 06:24:20','2017-09-11 13:24:20',NULL),(4,'01.1.02.02.02.0001',1,1,2,2,2,'Kursi Lipat','2017-09-11','digunakan','01c27d869263c9d1eb7908c99ae72448-170911-59b68ed132757.png',NULL,'2017-09-12 15:16:35','2017-09-12 15:16:35',NULL),(5,'01.1.02.02.02.0002',1,1,2,2,2,'Kursi Lipat Bos','2017-09-11','digunakan','3203dabb72033973cb1e99422be3bf6e-170911-59b690487bf6e.png',NULL,'2017-09-12 15:16:35','2017-09-12 15:16:35','2017-09-11 13:32:19');
/*!40000 ALTER TABLE `asset_extracomptable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asset_inventory`
--

DROP TABLE IF EXISTS `asset_inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asset_inventory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kd_asset` varchar(32) NOT NULL,
  `id_gedung` int(10) unsigned NOT NULL,
  `lantai` int(10) NOT NULL,
  `id_ruang` int(10) unsigned NOT NULL,
  `id_kategori` int(10) unsigned NOT NULL,
  `nama_asset` varchar(120) NOT NULL,
  `jumlah` int(10) NOT NULL,
  `jumlah_minimum` int(10) NOT NULL,
  `gambar` varchar(120) NOT NULL,
  `ref_id_request` int(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kd_asset` (`kd_asset`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asset_inventory`
--

LOCK TABLES `asset_inventory` WRITE;
/*!40000 ALTER TABLE `asset_inventory` DISABLE KEYS */;
INSERT INTO `asset_inventory` VALUES (1,'01.1.02.01.0001',1,1,2,1,'Kertas A4',50,20,'c267b1ab80af084c5e32058d4a4aaca5-170911-59b6b757b0c09.png',NULL,'2017-09-15 02:07:08','2017-09-15 02:07:08',NULL),(2,'01.1.02.01.0002',1,1,2,1,'Kertas Folio',60,200,'6dab4088d57b9a1fa6ae2c522e3a8379-170911-59b6b76db1acd.png',NULL,'2017-09-15 02:00:57','2017-09-15 02:00:57',NULL),(3,'02.1.03.01.0001',2,1,3,1,'Kertas Folio',100,200,'6dab4088d57b9a1fa6ae2c522e3a8379-170911-59b6b76db1acd.png',NULL,'2017-09-15 02:07:08','2017-09-15 02:07:08','2017-09-15 02:01:56'),(4,'02.1.03.01.0002',2,1,3,1,'Kertas Folio',100,200,'6dab4088d57b9a1fa6ae2c522e3a8379-170911-59b6b76db1acd.png',NULL,'2017-09-15 02:01:50','2017-09-15 02:00:57','2017-09-15 02:01:50'),(5,'02.1.03.01.0003',2,1,3,1,'Kertas A4',20,20,'c267b1ab80af084c5e32058d4a4aaca5-170911-59b6b757b0c09.png',NULL,'2017-09-15 02:02:33','2017-09-15 02:02:33',NULL),(6,'02.1.03.01.0004',2,1,3,1,'Kertas A4',50,20,'c267b1ab80af084c5e32058d4a4aaca5-170911-59b6b757b0c09.png',NULL,'2017-09-15 02:05:20','2017-09-15 02:03:04','2017-09-15 02:05:20');
/*!40000 ALTER TABLE `asset_inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `checkout_aktiva_tetap`
--

DROP TABLE IF EXISTS `checkout_aktiva_tetap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `checkout_aktiva_tetap` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kd_checkout` varchar(12) NOT NULL,
  `tanggal` date NOT NULL,
  `note` text NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `nik_karyawan` varchar(32) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kd_checkout` (`kd_checkout`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `checkout_aktiva_tetap`
--

LOCK TABLES `checkout_aktiva_tetap` WRITE;
/*!40000 ALTER TABLE `checkout_aktiva_tetap` DISABLE KEYS */;
INSERT INTO `checkout_aktiva_tetap` VALUES (1,'CA170912001','2017-09-12','blablaba','kalimalang','8305020JA','2017-09-12 16:30:09','2017-09-12 16:30:09',NULL);
/*!40000 ALTER TABLE `checkout_aktiva_tetap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `checkout_extracomptable`
--

DROP TABLE IF EXISTS `checkout_extracomptable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `checkout_extracomptable` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kd_checkout` varchar(12) NOT NULL,
  `tanggal` date NOT NULL,
  `note` text NOT NULL,
  `id_gedung` int(10) unsigned NOT NULL,
  `lantai` int(10) NOT NULL,
  `id_ruang` int(10) unsigned NOT NULL,
  `nik_karyawan` varchar(32) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kd_checkout` (`kd_checkout`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `checkout_extracomptable`
--

LOCK TABLES `checkout_extracomptable` WRITE;
/*!40000 ALTER TABLE `checkout_extracomptable` DISABLE KEYS */;
INSERT INTO `checkout_extracomptable` VALUES (1,'CE170912001','2017-09-12','asdasasd',1,1,2,'8614082ZJY','2017-09-12 07:40:27','2017-09-12 14:40:27',NULL),(2,'CE170912002','2017-09-12','qweqweqwe',2,1,3,'8614082ZJY','2017-09-12 07:56:06','2017-09-12 14:56:06',NULL),(3,'CE170912003','2017-09-12','asdasd',2,1,3,'8614082ZJY','2017-09-12 07:57:03','2017-09-12 14:57:03',NULL),(4,'CE170912004','2017-09-12','abcd',2,1,3,'8305021JA','2017-09-12 07:57:57','2017-09-12 14:57:57',NULL),(5,'CE170912005','2017-09-12','avcde',2,1,3,'8305020JA','2017-09-12 07:58:27','2017-09-12 14:58:27',NULL),(6,'CE170912006','2017-09-12','abcde',1,1,2,'8305020JA','2017-09-12 15:16:35','2017-09-12 15:16:35',NULL);
/*!40000 ALTER TABLE `checkout_extracomptable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `checkout_inventory`
--

DROP TABLE IF EXISTS `checkout_inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `checkout_inventory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kd_checkout` varchar(12) NOT NULL,
  `tanggal` date NOT NULL,
  `id_gedung` int(10) unsigned NOT NULL,
  `lantai` int(10) NOT NULL,
  `id_ruang` int(10) unsigned NOT NULL,
  `note` text NOT NULL,
  `nik_karyawan` varchar(32) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kd_checkout` (`kd_checkout`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `checkout_inventory`
--

LOCK TABLES `checkout_inventory` WRITE;
/*!40000 ALTER TABLE `checkout_inventory` DISABLE KEYS */;
INSERT INTO `checkout_inventory` VALUES (1,'CE170912001','2017-09-12',2,1,3,'asdasd','9316062ZJY','2017-09-12 08:44:04','2017-09-12 15:44:04',NULL),(2,'CE170912002','2017-09-12',2,1,3,'asdasasd','9316062ZJY','2017-09-12 09:03:16','2017-09-12 16:03:16',NULL),(3,'CE170915001','2017-09-14',2,1,3,'asdasd','8305021JA','2017-09-14 18:58:01','2017-09-15 01:58:01',NULL),(4,'CE170915002','2017-09-16',2,1,3,'abcde','8305021JA','2017-09-14 18:59:44','2017-09-15 01:59:44',NULL),(5,'CE170915003','2017-09-15',2,1,3,'abcde','8915211ZJY','2017-09-14 19:00:57','2017-09-15 02:00:57',NULL),(6,'CE170915004','2017-09-15',2,1,3,'abcde','8305021JA','2017-09-14 19:02:33','2017-09-15 02:02:33',NULL);
/*!40000 ALTER TABLE `checkout_inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_apicustom`
--

DROP TABLE IF EXISTS `cms_apicustom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_apicustom` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `permalink` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tabel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aksi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kolom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orderby` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_query_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sql_where` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `method_type` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameters` longtext COLLATE utf8mb4_unicode_ci,
  `responses` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_apicustom`
--

LOCK TABLES `cms_apicustom` WRITE;
/*!40000 ALTER TABLE `cms_apicustom` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_apicustom` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_apikey`
--

DROP TABLE IF EXISTS `cms_apikey`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_apikey` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `screetkey` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hit` int(11) DEFAULT NULL,
  `status` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_apikey`
--

LOCK TABLES `cms_apikey` WRITE;
/*!40000 ALTER TABLE `cms_apikey` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_apikey` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_dashboard`
--

DROP TABLE IF EXISTS `cms_dashboard`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_dashboard` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_cms_privileges` int(11) DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_dashboard`
--

LOCK TABLES `cms_dashboard` WRITE;
/*!40000 ALTER TABLE `cms_dashboard` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_dashboard` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_email_queues`
--

DROP TABLE IF EXISTS `cms_email_queues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_email_queues` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `send_at` datetime DEFAULT NULL,
  `email_recipient` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_from_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_from_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_cc_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_content` text COLLATE utf8mb4_unicode_ci,
  `email_attachments` text COLLATE utf8mb4_unicode_ci,
  `is_sent` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_email_queues`
--

LOCK TABLES `cms_email_queues` WRITE;
/*!40000 ALTER TABLE `cms_email_queues` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_email_queues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_email_templates`
--

DROP TABLE IF EXISTS `cms_email_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_email_templates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cc_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_email_templates`
--

LOCK TABLES `cms_email_templates` WRITE;
/*!40000 ALTER TABLE `cms_email_templates` DISABLE KEYS */;
INSERT INTO `cms_email_templates` VALUES (1,'Email Template Forgot Password Backend','forgot_password_backend',NULL,'<p>Hi,</p><p>Someone requested forgot password, here is your new password : </p><p>[password]</p><p><br></p><p>--</p><p>Regards,</p><p>Admin</p>','[password]','System','system@crudbooster.com',NULL,'2017-09-05 21:19:17',NULL);
/*!40000 ALTER TABLE `cms_email_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_logs`
--

DROP TABLE IF EXISTS `cms_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ipaddress` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `useragent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` text COLLATE utf8mb4_unicode_ci,
  `id_cms_users` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_logs`
--

LOCK TABLES `cms_logs` WRITE;
/*!40000 ALTER TABLE `cms_logs` DISABLE KEYS */;
INSERT INTO `cms_logs` VALUES (1,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/users/edit-save/1','Update data Super Admin at Users Management','<table class=\"table table-striped\"><thead><tr><th>Key</th><th>Old Value</th><th>New Value</th></thead><tbody><tr><td>photo</td><td></td><td>uploads/1/2017-09/17903981_661614980688663_878796449812844549_n.png</td></tr><tr><td>email</td><td>admin@crudbooster.com</td><td>admin@ditamadigital.co.id</td></tr><tr><td>password</td><td>$2y$10$MrmWEsAlFfN47J9q.aHSWOTMrWXMiQQ0s8HLP7G4RlSTmXnfWndZG</td><td>$2y$10$ecNjEVO4XRvOvcYb6nlGMOwmoDFdOZOcW.R3lpkKZLTpjCcvFQNdS</td></tr><tr><td>id_cms_privileges</td><td>1</td><td></td></tr><tr><td>status</td><td>Active</td><td></td></tr></tbody></table>',1,'2017-09-05 21:20:12',NULL),(2,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/logout','admin@ditamadigital.co.id logout','',1,'2017-09-05 21:21:02',NULL),(3,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/login','admin@ditamadigital.co.id login with IP Address 127.0.0.1','',1,'2017-09-05 21:21:10',NULL),(4,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/gedung/add-save','Add New Data Oscar Sharpe at Gedung','',1,'2017-09-05 21:22:25',NULL),(5,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/jenis_extracomptable/add-save','Add New Data Meja at Jenis Extracomptable','',1,'2017-09-05 21:26:40',NULL),(6,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/jenis_extracomptable/edit-save/1','Update data Meja at Jenis Extracomptable','<table class=\"table table-striped\"><thead><tr><th>Key</th><th>Old Value</th><th>New Value</th></thead><tbody><tr><td>kd_jenis</td><td>01</td><td>02</td></tr><tr><td>deleted_at</td><td></td><td></td></tr></tbody></table>',1,'2017-09-05 21:26:48',NULL),(7,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/subjenis_extracomptable/add-save','Add New Data Meja Bulet at Sub Jenis Extracomptable','',1,'2017-09-05 21:27:18',NULL),(8,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/menu_management/add-save','Add New Data Data Master at Menu Management','',1,'2017-09-05 21:35:35',NULL),(9,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/menu_management/add-save','Add New Data Asset Extracomptable at Menu Management','',1,'2017-09-05 21:36:09',NULL),(10,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/menu_management/add-save','Add New Data Asset Aktiva Tetap at Menu Management','',1,'2017-09-05 21:38:13',NULL),(11,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/menu_management/edit-save/12','Update data Asset Extracomptable at Menu Management','<table class=\"table table-striped\"><thead><tr><th>Key</th><th>Old Value</th><th>New Value</th></thead><tbody><tr><td>icon</td><td>fa fa-building</td><td>fa fa-desktop</td></tr><tr><td>sorting</td><td>2</td><td></td></tr></tbody></table>',1,'2017-09-05 21:39:03',NULL),(12,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/menu_management/add-save','Add New Data Asset Inventory at Menu Management','',1,'2017-09-05 21:39:28',NULL),(13,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/gedung/edit-save/1','Update data Oscar Sharpe at Gedung','<table class=\"table table-striped\"><thead><tr><th>Key</th><th>Old Value</th><th>New Value</th></thead><tbody><tr><td>jumlah_lantai</td><td>47</td><td>4</td></tr><tr><td>deleted_at</td><td></td><td></td></tr></tbody></table>',1,'2017-09-05 21:43:21',NULL),(14,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/menu_management/edit-save/15','Update data Checkout Extracomptable at Menu Management','<table class=\"table table-striped\"><thead><tr><th>Key</th><th>Old Value</th><th>New Value</th></thead><tbody><tr><td>color</td><td></td><td>normal</td></tr><tr><td>icon</td><td>fa fa-glass</td><td>fa fa-sign-out</td></tr><tr><td>parent_id</td><td>12</td><td></td></tr><tr><td>sorting</td><td>7</td><td></td></tr></tbody></table>',1,'2017-09-05 21:48:09',NULL),(15,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/login','admin@ditamadigital.co.id login with IP Address 127.0.0.1','',1,'2017-09-10 04:52:44',NULL),(16,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/login','admin@ditamadigital.co.id login with IP Address 127.0.0.1','',1,'2017-09-10 17:28:17',NULL),(17,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/gedung/edit-save/1','Update data Gedung A Pluit at Gedung','<table class=\"table table-striped\"><thead><tr><th>Key</th><th>Old Value</th><th>New Value</th></thead><tbody><tr><td>nama</td><td>Oscar Sharpe</td><td>Gedung A Pluit</td></tr><tr><td>lokasi</td><td>Omnis quia alias culpa eu eu sed alias aut pariatur Ut voluptas</td><td>Pluit</td></tr><tr><td>deleted_at</td><td></td><td></td></tr></tbody></table>',1,'2017-09-10 17:28:46',NULL),(18,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/gedung/add-save','Add New Data Gudang Muara Karang at Gedung','',1,'2017-09-10 17:29:14',NULL),(19,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/ruang/add-save','Add New Data Ruang A at Ruang','',1,'2017-09-10 17:34:08',NULL),(20,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/ruang/add-save','Add New Data Ruang 1A at Ruang','',1,'2017-09-10 17:34:31',NULL),(21,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/ruang/edit-save/1','Update data Ruang 2A at Ruang','<table class=\"table table-striped\"><thead><tr><th>Key</th><th>Old Value</th><th>New Value</th></thead><tbody><tr><td>nama_ruang</td><td>Ruang A</td><td>Ruang 2A</td></tr><tr><td>deleted_at</td><td></td><td></td></tr></tbody></table>',1,'2017-09-10 17:34:44',NULL),(22,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/ruang/add-save','Add New Data Ruang 3A at Ruang','',1,'2017-09-10 17:35:03',NULL),(23,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/module_generator/delete/27','Delete data Adjustment Aktiva Tetap at Module Generator','',1,'2017-09-10 19:50:34',NULL),(24,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/module_generator/delete/24','Delete data Adjustment Extracomptable at Module Generator','',1,'2017-09-10 19:50:38',NULL),(25,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/module_generator/delete/32','Delete data Adjustment Inventory at Module Generator','',1,'2017-09-10 19:50:40',NULL),(26,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/module_generator/delete/20','Delete data Asset Aktiva Tetap at Module Generator','',1,'2017-09-10 19:50:42',NULL),(27,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/module_generator/delete/19','Delete data Asset Extracomptable at Module Generator','',1,'2017-09-10 19:50:46',NULL),(28,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/module_generator/delete/21','Delete data Asset Inventory at Module Generator','',1,'2017-09-10 19:50:50',NULL),(29,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/module_generator/delete/29','Delete data Checkout Aktiva Tetap at Module Generator','',1,'2017-09-10 19:50:53',NULL),(30,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/module_generator/delete/22','Delete data Checkout Extracomptable at Module Generator','',1,'2017-09-10 19:50:55',NULL),(31,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/module_generator/delete/31','Delete data Checkout Inventory at Module Generator','',1,'2017-09-10 19:50:58',NULL),(32,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/module_generator/delete/12','Delete data Gedung at Module Generator','',1,'2017-09-10 19:51:00',NULL),(33,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/module_generator/delete/13','Delete data Jenis Extracomptable at Module Generator','',1,'2017-09-10 19:51:03',NULL),(34,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/module_generator/delete/18','Delete data Karyawan at Module Generator','',1,'2017-09-10 19:51:07',NULL),(35,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/module_generator/delete/16','Delete data Kategori Inventory at Module Generator','',1,'2017-09-10 19:51:09',NULL),(36,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/module_generator/delete/15','Delete data Model Aktiva Tetap at Module Generator','',1,'2017-09-10 19:51:12',NULL),(37,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/module_generator/delete/26','Delete data Pemeliharaan Aktiva Tetap at Module Generator','',1,'2017-09-10 19:51:15',NULL),(38,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/module_generator/delete/23','Delete data Pemeliharaan Extracomptable at Module Generator','',1,'2017-09-10 19:51:18',NULL),(39,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/module_generator/delete/28','Delete data Request Aktiva Tetap at Module Generator','',1,'2017-09-10 19:51:21',NULL),(40,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/module_generator/delete/25','Delete data Request Extracomptable at Module Generator','',1,'2017-09-10 19:51:24',NULL),(41,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/module_generator/delete/30','Delete data Request Inventory at Module Generator','',1,'2017-09-10 19:51:27',NULL),(42,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/module_generator/delete/17','Delete data Ruang at Module Generator','',1,'2017-09-10 19:51:30',NULL),(43,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/module_generator/delete/14','Delete data Sub Jenis Extracomptable at Module Generator','',1,'2017-09-10 19:51:33',NULL),(44,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/gedung/add-save','Add New Data Pluit at Gedung','',1,'2017-09-10 19:54:31',NULL),(45,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/gedung/add-save','Add New Data Muara Karang at Gedung','',1,'2017-09-10 19:54:41',NULL),(46,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/ruang/add-save','Add New Data P31 at Ruang','',1,'2017-09-10 19:55:11',NULL),(47,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/ruang/add-save','Add New Data P11 at Ruang','',1,'2017-09-10 19:55:24',NULL),(48,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/ruang/add-save','Add New Data M11 at Ruang','',1,'2017-09-10 19:55:54',NULL),(49,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/module_generator/delete/33','Delete data Gedung at Module Generator','',1,'2017-09-10 19:57:43',NULL),(50,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/module_generator/delete/35','Delete data Jenis Extracomptable at Module Generator','',1,'2017-09-10 19:57:46',NULL),(51,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/module_generator/delete/34','Delete data Ruang at Module Generator','',1,'2017-09-10 19:57:49',NULL),(52,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/jenis_extracomptable/add-save','Add New Data Meja at Jenis Extracomptable','',1,'2017-09-10 20:03:26',NULL),(53,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/jenis_extracomptable/add-save','Add New Data Kursi at Jenis Extracomptable','',1,'2017-09-10 20:03:41',NULL),(54,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/jenis_extracomptable/edit-save/1','Update data Meja at Jenis Extracomptable','<table class=\"table table-striped\"><thead><tr><th>Key</th><th>Old Value</th><th>New Value</th></thead><tbody><tr><td>description</td><td>Meja Besar</td><td>Meja kerja</td></tr><tr><td>deleted_at</td><td></td><td></td></tr></tbody></table>',1,'2017-09-10 20:04:01',NULL),(55,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/subjenis_extracomptable/add-save','Add New Data Kursi Putar at Sub Jenis Extracomptable','',1,'2017-09-10 22:31:35',NULL),(56,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/subjenis_extracomptable/add-save','Add New Data Kursi Lipat at Sub Jenis Extracomptable','',1,'2017-09-10 22:31:51',NULL),(57,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/subjenis_extracomptable/add-save','Add New Data Meja Karyawan at Sub Jenis Extracomptable','',1,'2017-09-10 22:32:25',NULL),(58,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/subjenis_extracomptable/add-save','Add New Data Meja Bulet at Sub Jenis Extracomptable','',1,'2017-09-10 22:32:37',NULL),(59,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/asset_extracomptable/delete/5','Delete data Kursi Lipat Bos at Asset Extracomptable','',1,'2017-09-11 06:32:19',NULL),(60,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/model_aktiva_tetap/add-save','Add New Data Kendaraan at Model Aktiva Tetap','',1,'2017-09-11 06:49:01',NULL),(61,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/model_aktiva_tetap/add-save','Add New Data Bangunan at Model Aktiva Tetap','',1,'2017-09-11 06:49:12',NULL),(62,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/model_aktiva_tetap/add-save','Add New Data Tanah at Model Aktiva Tetap','',1,'2017-09-11 06:49:22',NULL),(63,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/asset_aktiva_tetap/delete/1','Delete data Bus PJB at Asset Aktiva Tetap','',1,'2017-09-11 07:10:15',NULL),(64,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/kategori_inventory/add-save','Add New Data Kertas at Kategori Inventory','',1,'2017-09-11 09:13:24',NULL),(65,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/kategori_inventory/add-save','Add New Data Pulpen at Kategori Inventory','',1,'2017-09-11 09:13:32',NULL),(66,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/login','admin@ditamadigital.co.id login with IP Address 127.0.0.1','',1,'2017-09-11 13:40:48',NULL),(67,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/module_generator/delete/21','Delete data Request Aktiva Tetap at Module Generator','',1,'2017-09-11 13:43:06',NULL),(68,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/login','admin@ditamadigital.co.id login with IP Address 127.0.0.1','',1,'2017-09-12 05:12:41',NULL),(69,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/login','admin@ditamadigital.co.id login with IP Address 127.0.0.1','',1,'2017-09-12 17:55:18',NULL),(70,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/menu_management/edit-save/49','Update data Pemeliharaan Aktiva Tetap at Menu Management','<table class=\"table table-striped\"><thead><tr><th>Key</th><th>Old Value</th><th>New Value</th></thead><tbody><tr><td>color</td><td></td><td>normal</td></tr><tr><td>icon</td><td>fa fa-glass</td><td>fa fa-gears</td></tr><tr><td>parent_id</td><td>13</td><td></td></tr><tr><td>sorting</td><td>4</td><td></td></tr></tbody></table>',1,'2017-09-12 21:19:51',NULL),(71,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/login','admin@ditamadigital.co.id login with IP Address 127.0.0.1','',1,'2017-09-13 21:50:19',NULL),(72,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/login','admin@ditamadigital.co.id login with IP Address 127.0.0.1','',1,'2017-09-14 18:56:58',NULL),(73,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/asset_inventory/delete/4','Delete data Kertas Folio at Asset Inventory','',1,'2017-09-14 19:01:49',NULL),(74,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/asset_inventory/delete/3','Delete data Kertas Folio at Asset Inventory','',1,'2017-09-14 19:01:56',NULL),(75,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36','http://localhost:8000/admin/asset_inventory/delete/6','Delete data Kertas A4 at Asset Inventory','',1,'2017-09-14 19:05:20',NULL),(76,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.91 Safari/537.36','http://localhost:8000/admin/login','admin@ditamadigital.co.id login with IP Address 127.0.0.1','',1,'2017-09-16 03:24:20',NULL);
/*!40000 ALTER TABLE `cms_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_menus`
--

DROP TABLE IF EXISTS `cms_menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'url',
  `path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_dashboard` tinyint(1) NOT NULL DEFAULT '0',
  `id_cms_privileges` int(11) DEFAULT NULL,
  `sorting` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_menus`
--

LOCK TABLES `cms_menus` WRITE;
/*!40000 ALTER TABLE `cms_menus` DISABLE KEYS */;
INSERT INTO `cms_menus` VALUES (11,'Data Master','URL','#','normal','fa fa-table',0,1,0,1,4,'2017-09-05 21:35:35',NULL),(12,'Asset Extracomptable','URL','#','normal','fa fa-desktop',0,1,0,1,1,'2017-09-05 21:36:09','2017-09-05 21:39:03'),(13,'Asset Aktiva Tetap','URL','#','normal','fa fa-building',0,1,0,1,2,'2017-09-05 21:38:13',NULL),(14,'Asset Inventory','URL','#','normal','fa fa-file-text',0,1,0,1,3,'2017-09-05 21:39:27',NULL),(29,'Gedung','Route','AdminGedungControllerGetIndex',NULL,'fa fa-building',11,1,0,1,1,'2017-09-10 19:59:12',NULL),(30,'Ruang','Route','AdminRuangControllerGetIndex',NULL,'fa fa-th-large',11,1,0,1,2,'2017-09-10 19:59:53',NULL),(31,'Jenis Extracomptable','Route','AdminJenisExtracomptableControllerGetIndex',NULL,'fa fa-tags',12,1,0,1,6,'2017-09-10 20:00:19',NULL),(32,'Sub Jenis Extracomptable','Route','AdminSubjenisExtracomptableControllerGetIndex',NULL,'fa fa-tags',12,1,0,1,7,'2017-09-10 20:00:50',NULL),(33,'Model Aktiva Tetap','Route','AdminModelAktivaTetapControllerGetIndex',NULL,'fa fa-tags',13,1,0,1,6,'2017-09-10 20:01:16',NULL),(34,'Kategori Inventory','Route','AdminKategoriInventoryControllerGetIndex',NULL,'fa fa-tags',14,1,0,1,5,'2017-09-10 20:01:40',NULL),(35,'Asset Extracomptable','Route','AdminAssetExtracomptableControllerGetIndex',NULL,'fa fa-th-list',12,1,0,1,1,'2017-09-10 20:05:49',NULL),(36,'Asset Aktiva Tetap','Route','AdminAssetAktivaTetapControllerGetIndex',NULL,'fa fa-th-list',13,1,0,1,1,'2017-09-10 20:07:09',NULL),(37,'Asset Inventory','Route','AdminAssetInventoryControllerGetIndex',NULL,'fa fa-th-list',14,1,0,1,1,'2017-09-10 20:07:57',NULL),(39,'Request Aktiva Tetap','Route','AdminRequestAktivaTetapControllerGetIndex',NULL,'fa fa-sign-in',13,1,0,1,2,'2017-09-11 13:47:07',NULL),(40,'Request Extracomptable','Route','AdminRequestExtracomptableControllerGetIndex',NULL,'fa fa-sign-in',12,1,0,1,2,'2017-09-11 13:47:50',NULL),(41,'Request Inventory','Route','AdminRequestInventoryControllerGetIndex',NULL,'fa fa-sign-in',14,1,0,1,2,'2017-09-11 13:48:23',NULL),(42,'Checkout Extracomptable','Route','AdminCheckoutExtracomptableControllerGetIndex',NULL,'fa fa-sign-out',12,1,0,1,3,'2017-09-12 05:13:20',NULL),(43,'Checkout Aktiva Tetap','Route','AdminCheckoutAktivaTetapControllerGetIndex',NULL,'fa fa-sign-out',13,1,0,1,3,'2017-09-12 05:14:04',NULL),(44,'Checkout Inventory','Route','AdminCheckoutInventoryControllerGetIndex',NULL,'fa fa-sign-out',14,1,0,1,3,'2017-09-12 05:14:44',NULL),(45,'Adjustment Aktiva Tetap','Route','AdminAdjustmentAktivaTetapControllerGetIndex',NULL,'fa fa-adjust',13,1,0,1,5,'2017-09-12 17:55:39',NULL),(46,'Adjustment Extracomptable','Route','AdminAdjustmentExtracomptableControllerGetIndex',NULL,'fa fa-adjust',12,1,0,1,4,'2017-09-12 17:56:12',NULL),(47,'Adjustment Inventory','Route','AdminAdjustmentInventoryControllerGetIndex',NULL,'fa fa-adjust',14,1,0,1,4,'2017-09-12 17:56:43',NULL),(48,'Pemeliharaan Extracomptable','Route','AdminPemeliharaanExtracomptableControllerGetIndex',NULL,'fa fa-gears',12,1,0,1,5,'2017-09-12 21:18:07',NULL),(49,'Pemeliharaan Aktiva Tetap','Route','AdminPemeliharaanAktivaTetapControllerGetIndex','normal','fa fa-gears',13,1,0,1,4,'2017-09-12 21:18:48','2017-09-12 21:19:51');
/*!40000 ALTER TABLE `cms_menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_menus_privileges`
--

DROP TABLE IF EXISTS `cms_menus_privileges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_menus_privileges` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_cms_menus` int(11) DEFAULT NULL,
  `id_cms_privileges` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_menus_privileges`
--

LOCK TABLES `cms_menus_privileges` WRITE;
/*!40000 ALTER TABLE `cms_menus_privileges` DISABLE KEYS */;
INSERT INTO `cms_menus_privileges` VALUES (1,1,1),(2,2,1),(3,3,1),(4,4,1),(5,5,1),(6,6,1),(7,7,1),(8,8,1),(9,9,1),(10,10,1),(11,11,1),(13,13,1),(14,12,1),(15,14,1),(17,16,1),(18,17,1),(19,18,1),(20,19,1),(21,20,1),(22,21,1),(23,22,1),(24,23,1),(25,24,1),(26,25,1),(27,15,1),(28,26,1),(29,27,1),(30,28,1),(31,29,1),(32,30,1),(33,31,1),(34,32,1),(35,33,1),(36,34,1),(37,35,1),(38,36,1),(39,37,1),(40,38,1),(41,39,1),(42,40,1),(43,41,1),(44,42,1),(45,43,1),(46,44,1),(47,45,1),(48,46,1),(49,47,1),(50,48,1),(51,49,1);
/*!40000 ALTER TABLE `cms_menus_privileges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_moduls`
--

DROP TABLE IF EXISTS `cms_moduls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_moduls` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `table_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `controller` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_protected` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_moduls`
--

LOCK TABLES `cms_moduls` WRITE;
/*!40000 ALTER TABLE `cms_moduls` DISABLE KEYS */;
INSERT INTO `cms_moduls` VALUES (1,'Notifications','fa fa-cog','notifications','cms_notifications','NotificationsController',1,1,'2017-09-05 21:19:16',NULL,NULL),(2,'Privileges','fa fa-cog','privileges','cms_privileges','PrivilegesController',1,1,'2017-09-05 21:19:16',NULL,NULL),(3,'Privileges Roles','fa fa-cog','privileges_roles','cms_privileges_roles','PrivilegesRolesController',1,1,'2017-09-05 21:19:16',NULL,NULL),(4,'Users Management','fa fa-users','users','cms_users','AdminCmsUsersController',0,1,'2017-09-05 21:19:16',NULL,NULL),(5,'Settings','fa fa-cog','settings','cms_settings','SettingsController',1,1,'2017-09-05 21:19:16',NULL,NULL),(6,'Module Generator','fa fa-database','module_generator','cms_moduls','ModulsController',1,1,'2017-09-05 21:19:16',NULL,NULL),(7,'Menu Management','fa fa-bars','menu_management','cms_menus','MenusController',1,1,'2017-09-05 21:19:16',NULL,NULL),(8,'Email Templates','fa fa-envelope-o','email_templates','cms_email_templates','EmailTemplatesController',1,1,'2017-09-05 21:19:16',NULL,NULL),(9,'Statistic Builder','fa fa-dashboard','statistic_builder','cms_statistics','StatisticBuilderController',1,1,'2017-09-05 21:19:16',NULL,NULL),(10,'API Generator','fa fa-cloud-download','api_generator','','ApiCustomController',1,1,'2017-09-05 21:19:16',NULL,NULL),(11,'Log User Access','fa fa-flag-o','logs','cms_logs','LogsController',1,1,'2017-09-05 21:19:16',NULL,NULL),(12,'Gedung','fa fa-building','gedung','gedung','AdminGedungController',0,0,'2017-09-10 19:59:12',NULL,NULL),(13,'Ruang','fa fa-th-large','ruang','ruang','AdminRuangController',0,0,'2017-09-10 19:59:53',NULL,NULL),(14,'Jenis Extracomptable','fa fa-tags','jenis_extracomptable','jenis_extracomptable','AdminJenisExtracomptableController',0,0,'2017-09-10 20:00:19',NULL,NULL),(15,'Sub Jenis Extracomptable','fa fa-tags','subjenis_extracomptable','subjenis_extracomptable','AdminSubjenisExtracomptableController',0,0,'2017-09-10 20:00:50',NULL,NULL),(16,'Model Aktiva Tetap','fa fa-tags','model_aktiva_tetap','model_aktiva_tetap','AdminModelAktivaTetapController',0,0,'2017-09-10 20:01:16',NULL,NULL),(17,'Kategori Inventory','fa fa-tags','kategori_inventory','kategori_inventory','AdminKategoriInventoryController',0,0,'2017-09-10 20:01:40',NULL,NULL),(18,'Asset Extracomptable','fa fa-th-list','asset_extracomptable','asset_extracomptable','AdminAssetExtracomptableController',0,0,'2017-09-10 20:05:48',NULL,NULL),(19,'Asset Aktiva Tetap','fa fa-th-list','asset_aktiva_tetap','asset_aktiva_tetap','AdminAssetAktivaTetapController',0,0,'2017-09-10 20:07:09',NULL,NULL),(20,'Asset Inventory','fa fa-th-list','asset_inventory','asset_inventory','AdminAssetInventoryController',0,0,'2017-09-10 20:07:57',NULL,NULL),(21,'Request Aktiva Tetap','fa fa-sign-in','request_aktiva_tetap','request_aktiva_tetap','AdminRequestAktivaTetapController',0,0,'2017-09-11 13:47:07',NULL,NULL),(22,'Request Extracomptable','fa fa-sign-in','request_extracomptable','request_extracomptable','AdminRequestExtracomptableController',0,0,'2017-09-11 13:47:50',NULL,NULL),(23,'Request Inventory','fa fa-sign-in','request_inventory','request_inventory','AdminRequestInventoryController',0,0,'2017-09-11 13:48:23',NULL,NULL),(24,'Checkout Extracomptable','fa fa-sign-out','checkout_extracomptable','checkout_extracomptable','AdminCheckoutExtracomptableController',0,0,'2017-09-12 05:13:20',NULL,NULL),(25,'Checkout Aktiva Tetap','fa fa-sign-out','checkout_aktiva_tetap','checkout_aktiva_tetap','AdminCheckoutAktivaTetapController',0,0,'2017-09-12 05:14:04',NULL,NULL),(26,'Checkout Inventory','fa fa-sign-out','checkout_inventory','checkout_inventory','AdminCheckoutInventoryController',0,0,'2017-09-12 05:14:44',NULL,NULL),(27,'Adjustment Aktiva Tetap','fa fa-adjust','adjustment_aktiva_tetap','adjustment_aktiva_tetap','AdminAdjustmentAktivaTetapController',0,0,'2017-09-12 17:55:39',NULL,NULL),(28,'Adjustment Extracomptable','fa fa-adjust','adjustment_extracomptable','adjustment_extracomptable','AdminAdjustmentExtracomptableController',0,0,'2017-09-12 17:56:12',NULL,NULL),(29,'Adjustment Inventory','fa fa-adjust','adjustment_inventory','adjustment_inventory','AdminAdjustmentInventoryController',0,0,'2017-09-12 17:56:43',NULL,NULL),(30,'Pemeliharaan Extracomptable','fa fa-gears','pemeliharaan_extracomptable','pemeliharaan_extracomptable','AdminPemeliharaanExtracomptableController',0,0,'2017-09-12 21:18:07',NULL,NULL),(31,'Pemeliharaan Aktiva Tetap','fa fa-gears','pemeliharaan_aktiva_tetap','pemeliharaan_aktiva_tetap','AdminPemeliharaanAktivaTetapController',0,0,'2017-09-12 21:18:48',NULL,NULL);
/*!40000 ALTER TABLE `cms_moduls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_notifications`
--

DROP TABLE IF EXISTS `cms_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_cms_users` int(11) DEFAULT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_notifications`
--

LOCK TABLES `cms_notifications` WRITE;
/*!40000 ALTER TABLE `cms_notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_privileges`
--

DROP TABLE IF EXISTS `cms_privileges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_privileges` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_superadmin` tinyint(1) DEFAULT NULL,
  `theme_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_privileges`
--

LOCK TABLES `cms_privileges` WRITE;
/*!40000 ALTER TABLE `cms_privileges` DISABLE KEYS */;
INSERT INTO `cms_privileges` VALUES (1,'Super Administrator',1,'skin-black-light','2017-09-05 21:19:16',NULL);
/*!40000 ALTER TABLE `cms_privileges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_privileges_roles`
--

DROP TABLE IF EXISTS `cms_privileges_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_privileges_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `is_visible` tinyint(1) DEFAULT NULL,
  `is_create` tinyint(1) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT NULL,
  `is_edit` tinyint(1) DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT NULL,
  `id_cms_privileges` int(11) DEFAULT NULL,
  `id_cms_moduls` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_privileges_roles`
--

LOCK TABLES `cms_privileges_roles` WRITE;
/*!40000 ALTER TABLE `cms_privileges_roles` DISABLE KEYS */;
INSERT INTO `cms_privileges_roles` VALUES (1,1,0,0,0,0,1,1,'2017-09-05 21:19:16',NULL),(2,1,1,1,1,1,1,2,'2017-09-05 21:19:16',NULL),(3,0,1,1,1,1,1,3,'2017-09-05 21:19:16',NULL),(4,1,1,1,1,1,1,4,'2017-09-05 21:19:16',NULL),(5,1,1,1,1,1,1,5,'2017-09-05 21:19:16',NULL),(6,1,1,1,1,1,1,6,'2017-09-05 21:19:16',NULL),(7,1,1,1,1,1,1,7,'2017-09-05 21:19:16',NULL),(8,1,1,1,1,1,1,8,'2017-09-05 21:19:16',NULL),(9,1,1,1,1,1,1,9,'2017-09-05 21:19:16',NULL),(10,1,1,1,1,1,1,10,'2017-09-05 21:19:16',NULL),(11,1,0,1,0,1,1,11,'2017-09-05 21:19:16',NULL),(12,1,1,1,1,1,1,12,NULL,NULL),(13,1,1,1,1,1,1,13,NULL,NULL),(14,1,1,1,1,1,1,14,NULL,NULL),(15,1,1,1,1,1,1,15,NULL,NULL),(16,1,1,1,1,1,1,16,NULL,NULL),(17,1,1,1,1,1,1,17,NULL,NULL),(18,1,1,1,1,1,1,18,NULL,NULL),(19,1,1,1,1,1,1,19,NULL,NULL),(20,1,1,1,1,1,1,20,NULL,NULL),(21,1,1,1,1,1,1,21,NULL,NULL),(22,1,1,1,1,1,1,22,NULL,NULL),(23,1,1,1,1,1,1,23,NULL,NULL),(24,1,1,1,1,1,1,24,NULL,NULL),(25,1,1,1,1,1,1,25,NULL,NULL),(26,1,1,1,1,1,1,26,NULL,NULL),(27,1,1,1,1,1,1,27,NULL,NULL),(28,1,1,1,1,1,1,28,NULL,NULL),(29,1,1,1,1,1,1,29,NULL,NULL),(30,1,1,1,1,1,1,30,NULL,NULL),(31,1,1,1,1,1,1,31,NULL,NULL),(32,1,1,1,1,1,1,32,NULL,NULL),(33,1,1,1,1,1,1,33,NULL,NULL),(34,1,1,1,1,1,1,34,NULL,NULL),(35,1,1,1,1,1,1,35,NULL,NULL),(36,1,1,1,1,1,1,12,NULL,NULL),(37,1,1,1,1,1,1,13,NULL,NULL),(38,1,1,1,1,1,1,14,NULL,NULL),(39,1,1,1,1,1,1,15,NULL,NULL),(40,1,1,1,1,1,1,16,NULL,NULL),(41,1,1,1,1,1,1,17,NULL,NULL),(42,1,1,1,1,1,1,18,NULL,NULL),(43,1,1,1,1,1,1,19,NULL,NULL),(44,1,1,1,1,1,1,20,NULL,NULL),(45,1,1,1,1,1,1,21,NULL,NULL),(46,1,1,1,1,1,1,21,NULL,NULL),(47,1,1,1,1,1,1,22,NULL,NULL),(48,1,1,1,1,1,1,23,NULL,NULL),(49,1,1,1,1,1,1,24,NULL,NULL),(50,1,1,1,1,1,1,25,NULL,NULL),(51,1,1,1,1,1,1,26,NULL,NULL),(52,1,1,1,1,1,1,27,NULL,NULL),(53,1,1,1,1,1,1,28,NULL,NULL),(54,1,1,1,1,1,1,29,NULL,NULL),(55,1,1,1,1,1,1,30,NULL,NULL),(56,1,1,1,1,1,1,31,NULL,NULL);
/*!40000 ALTER TABLE `cms_privileges_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_settings`
--

DROP TABLE IF EXISTS `cms_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `content_input_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dataenum` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `helper` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `group_setting` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_settings`
--

LOCK TABLES `cms_settings` WRITE;
/*!40000 ALTER TABLE `cms_settings` DISABLE KEYS */;
INSERT INTO `cms_settings` VALUES (1,'login_background_color',NULL,'text',NULL,'Input hexacode','2017-09-05 21:19:16',NULL,'Login Register Style','Login Background Color'),(2,'login_font_color',NULL,'text',NULL,'Input hexacode','2017-09-05 21:19:16',NULL,'Login Register Style','Login Font Color'),(3,'login_background_image',NULL,'upload_image',NULL,NULL,'2017-09-05 21:19:16',NULL,'Login Register Style','Login Background Image'),(4,'email_sender','support@crudbooster.com','text',NULL,NULL,'2017-09-05 21:19:16',NULL,'Email Setting','Email Sender'),(5,'smtp_driver','mail','select','smtp,mail,sendmail',NULL,'2017-09-05 21:19:16',NULL,'Email Setting','Mail Driver'),(6,'smtp_host','','text',NULL,NULL,'2017-09-05 21:19:16',NULL,'Email Setting','SMTP Host'),(7,'smtp_port','25','text',NULL,'default 25','2017-09-05 21:19:16',NULL,'Email Setting','SMTP Port'),(8,'smtp_username','','text',NULL,NULL,'2017-09-05 21:19:16',NULL,'Email Setting','SMTP Username'),(9,'smtp_password','','text',NULL,NULL,'2017-09-05 21:19:16',NULL,'Email Setting','SMTP Password'),(10,'appname','PJB AMS','text',NULL,NULL,'2017-09-05 21:19:16',NULL,'Application Setting','Application Name'),(11,'default_paper_size','Legal','text',NULL,'Paper size, ex : A4, Legal, etc','2017-09-05 21:19:16',NULL,'Application Setting','Default Paper Print Size'),(12,'logo',NULL,'upload_image',NULL,NULL,'2017-09-05 21:19:16',NULL,'Application Setting','Logo'),(13,'favicon',NULL,'upload_image',NULL,NULL,'2017-09-05 21:19:16',NULL,'Application Setting','Favicon'),(14,'api_debug_mode','true','select','true,false',NULL,'2017-09-05 21:19:16',NULL,'Application Setting','API Debug Mode'),(15,'google_api_key',NULL,'text',NULL,NULL,'2017-09-05 21:19:16',NULL,'Application Setting','Google API Key'),(16,'google_fcm_key',NULL,'text',NULL,NULL,'2017-09-05 21:19:16',NULL,'Application Setting','Google FCM Key');
/*!40000 ALTER TABLE `cms_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_statistic_components`
--

DROP TABLE IF EXISTS `cms_statistic_components`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_statistic_components` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_cms_statistics` int(11) DEFAULT NULL,
  `componentID` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `component_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area_name` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sorting` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `config` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_statistic_components`
--

LOCK TABLES `cms_statistic_components` WRITE;
/*!40000 ALTER TABLE `cms_statistic_components` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_statistic_components` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_statistics`
--

DROP TABLE IF EXISTS `cms_statistics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_statistics` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_statistics`
--

LOCK TABLES `cms_statistics` WRITE;
/*!40000 ALTER TABLE `cms_statistics` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_statistics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_users`
--

DROP TABLE IF EXISTS `cms_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_cms_privileges` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_users`
--

LOCK TABLES `cms_users` WRITE;
/*!40000 ALTER TABLE `cms_users` DISABLE KEYS */;
INSERT INTO `cms_users` VALUES (1,'Super Admin','uploads/1/2017-09/17903981_661614980688663_878796449812844549_n.png','admin@ditamadigital.co.id','$2y$10$ecNjEVO4XRvOvcYb6nlGMOwmoDFdOZOcW.R3lpkKZLTpjCcvFQNdS',1,'2017-09-05 21:19:16','2017-09-05 21:20:12','Active');
/*!40000 ALTER TABLE `cms_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gedung`
--

DROP TABLE IF EXISTS `gedung`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gedung` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kd_gedung` varchar(3) NOT NULL,
  `nama` varchar(120) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `jumlah_lantai` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kd_gedung` (`kd_gedung`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gedung`
--

LOCK TABLES `gedung` WRITE;
/*!40000 ALTER TABLE `gedung` DISABLE KEYS */;
INSERT INTO `gedung` VALUES (1,'01','Pluit','Pluit',4,'2017-09-10 19:54:30',NULL,NULL),(2,'02','Muara Karang','Muara Karang',3,'2017-09-10 19:54:41',NULL,NULL);
/*!40000 ALTER TABLE `gedung` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_adjustment_aktiva_tetap`
--

DROP TABLE IF EXISTS `item_adjustment_aktiva_tetap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_adjustment_aktiva_tetap` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_adjustment` int(10) unsigned NOT NULL,
  `id_model` int(10) unsigned NOT NULL,
  `description` text NOT NULL,
  `current_qty` int(10) NOT NULL,
  `new_qty` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_adjustment_aktiva_tetap`
--

LOCK TABLES `item_adjustment_aktiva_tetap` WRITE;
/*!40000 ALTER TABLE `item_adjustment_aktiva_tetap` DISABLE KEYS */;
INSERT INTO `item_adjustment_aktiva_tetap` VALUES (5,1,1,'a,b,c,d,e',5,5,'2017-09-13 03:52:36',NULL,NULL),(7,2,1,'blablah',10,10,'2017-09-13 03:54:04',NULL,NULL),(8,3,1,'entah',0,2,'2017-09-13 03:54:36',NULL,NULL),(10,4,1,'foobar',0,5,'2017-09-16 10:34:32',NULL,NULL);
/*!40000 ALTER TABLE `item_adjustment_aktiva_tetap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_adjustment_extracomptable`
--

DROP TABLE IF EXISTS `item_adjustment_extracomptable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_adjustment_extracomptable` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_adjustment` int(10) unsigned NOT NULL,
  `id_subjenis` int(10) unsigned NOT NULL,
  `description` text NOT NULL,
  `current_qty` int(10) NOT NULL,
  `new_qty` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_adjustment_extracomptable`
--

LOCK TABLES `item_adjustment_extracomptable` WRITE;
/*!40000 ALTER TABLE `item_adjustment_extracomptable` DISABLE KEYS */;
INSERT INTO `item_adjustment_extracomptable` VALUES (3,1,2,'',2,10,'2017-09-13 02:23:04',NULL,NULL),(4,1,4,'qwerty',2,2,'2017-09-13 02:23:04',NULL,NULL),(6,2,2,'1 rusak',2,2,'2017-09-13 02:24:00',NULL,NULL),(8,3,2,'blabla',2,10,'2017-09-16 10:26:55',NULL,NULL);
/*!40000 ALTER TABLE `item_adjustment_extracomptable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_adjustment_inventory`
--

DROP TABLE IF EXISTS `item_adjustment_inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_adjustment_inventory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_adjustment` int(10) unsigned NOT NULL,
  `id_asset` int(10) unsigned NOT NULL,
  `description` text NOT NULL,
  `current_qty` int(10) NOT NULL,
  `new_qty` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_adjustment_inventory`
--

LOCK TABLES `item_adjustment_inventory` WRITE;
/*!40000 ALTER TABLE `item_adjustment_inventory` DISABLE KEYS */;
INSERT INTO `item_adjustment_inventory` VALUES (2,1,1,'',100,5,'2017-09-13 03:03:03',NULL,NULL),(3,1,2,'test',80,10,'2017-09-13 03:03:03',NULL,NULL),(5,2,2,'',60,12,'2017-09-16 10:41:19',NULL,NULL);
/*!40000 ALTER TABLE `item_adjustment_inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_checkout_aktiva_tetap`
--

DROP TABLE IF EXISTS `item_checkout_aktiva_tetap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_checkout_aktiva_tetap` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_checkout` int(10) unsigned NOT NULL,
  `id_asset` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_checkout_aktiva_tetap`
--

LOCK TABLES `item_checkout_aktiva_tetap` WRITE;
/*!40000 ALTER TABLE `item_checkout_aktiva_tetap` DISABLE KEYS */;
INSERT INTO `item_checkout_aktiva_tetap` VALUES (1,1,2,'2017-09-12 09:29:41','2017-09-12 16:29:41',NULL),(2,1,3,'2017-09-12 09:30:09','2017-09-12 16:30:09',NULL);
/*!40000 ALTER TABLE `item_checkout_aktiva_tetap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_checkout_extracomptable`
--

DROP TABLE IF EXISTS `item_checkout_extracomptable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_checkout_extracomptable` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_checkout` int(10) unsigned NOT NULL,
  `id_asset` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_checkout_extracomptable`
--

LOCK TABLES `item_checkout_extracomptable` WRITE;
/*!40000 ALTER TABLE `item_checkout_extracomptable` DISABLE KEYS */;
INSERT INTO `item_checkout_extracomptable` VALUES (1,1,2,'2017-09-12 07:40:27','2017-09-12 14:40:27',NULL),(2,1,1,'2017-09-12 07:40:27','2017-09-12 14:40:27',NULL),(3,2,1,'2017-09-12 07:56:06','2017-09-12 14:56:06',NULL),(4,3,4,'2017-09-12 07:57:03','2017-09-12 14:57:03',NULL),(5,4,4,'2017-09-12 07:57:57','2017-09-12 14:57:57',NULL),(6,5,4,'2017-09-12 07:58:28','2017-09-12 14:58:28',NULL),(51,6,4,'2017-09-12 08:22:02','2017-09-12 15:22:02',NULL),(52,6,5,'2017-09-12 08:22:02','2017-09-12 15:22:02',NULL),(53,6,1,'2017-09-12 08:22:02','2017-09-12 15:22:02',NULL);
/*!40000 ALTER TABLE `item_checkout_extracomptable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_checkout_inventory`
--

DROP TABLE IF EXISTS `item_checkout_inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_checkout_inventory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_checkout` int(10) unsigned NOT NULL,
  `id_asset` int(10) unsigned NOT NULL,
  `jumlah` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_checkout_inventory`
--

LOCK TABLES `item_checkout_inventory` WRITE;
/*!40000 ALTER TABLE `item_checkout_inventory` DISABLE KEYS */;
INSERT INTO `item_checkout_inventory` VALUES (1,1,2,20,'2017-09-12 08:44:04','2017-09-12 15:44:04',NULL),(2,1,1,50,'2017-09-12 08:44:04','2017-09-12 15:44:04',NULL),(3,2,2,50,'2017-09-12 16:06:01','2017-09-12 16:06:01',NULL),(4,3,2,20,'2017-09-14 18:58:01','2017-09-15 01:58:01',NULL),(5,4,2,20,'2017-09-14 18:59:44','2017-09-15 01:59:44',NULL),(6,5,2,20,'2017-09-14 19:00:57','2017-09-15 02:00:57',NULL),(7,6,1,50,'2017-09-15 02:07:08','2017-09-15 02:07:08',NULL);
/*!40000 ALTER TABLE `item_checkout_inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_pemeliharaan_aktiva_tetap`
--

DROP TABLE IF EXISTS `item_pemeliharaan_aktiva_tetap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_pemeliharaan_aktiva_tetap` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_pemeliharaan` int(10) unsigned NOT NULL,
  `id_asset` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_pemeliharaan_aktiva_tetap`
--

LOCK TABLES `item_pemeliharaan_aktiva_tetap` WRITE;
/*!40000 ALTER TABLE `item_pemeliharaan_aktiva_tetap` DISABLE KEYS */;
INSERT INTO `item_pemeliharaan_aktiva_tetap` VALUES (2,1,2,'2017-09-12 21:48:58','2017-09-13 04:48:58',NULL),(3,1,3,'2017-09-12 21:48:58','2017-09-13 04:48:58',NULL);
/*!40000 ALTER TABLE `item_pemeliharaan_aktiva_tetap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_pemeliharaan_extracomptable`
--

DROP TABLE IF EXISTS `item_pemeliharaan_extracomptable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_pemeliharaan_extracomptable` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_pemeliharaan` int(10) unsigned NOT NULL,
  `id_asset` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_pemeliharaan_extracomptable`
--

LOCK TABLES `item_pemeliharaan_extracomptable` WRITE;
/*!40000 ALTER TABLE `item_pemeliharaan_extracomptable` DISABLE KEYS */;
INSERT INTO `item_pemeliharaan_extracomptable` VALUES (2,1,2,'2017-09-12 21:38:25','2017-09-13 04:38:25',NULL);
/*!40000 ALTER TABLE `item_pemeliharaan_extracomptable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_request_aktiva_tetap`
--

DROP TABLE IF EXISTS `item_request_aktiva_tetap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_request_aktiva_tetap` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_request` int(10) unsigned NOT NULL,
  `id_model` int(10) unsigned NOT NULL,
  `note` text NOT NULL,
  `jumlah` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_request_aktiva_tetap`
--

LOCK TABLES `item_request_aktiva_tetap` WRITE;
/*!40000 ALTER TABLE `item_request_aktiva_tetap` DISABLE KEYS */;
INSERT INTO `item_request_aktiva_tetap` VALUES (3,1,2,'Gudang',1),(4,1,1,'Truk Besi',5);
/*!40000 ALTER TABLE `item_request_aktiva_tetap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_request_extracomptable`
--

DROP TABLE IF EXISTS `item_request_extracomptable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_request_extracomptable` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_request` int(10) unsigned NOT NULL,
  `id_jenis` int(10) unsigned NOT NULL,
  `id_subjenis` int(10) unsigned NOT NULL,
  `jumlah` int(10) NOT NULL,
  `note` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_request_extracomptable`
--

LOCK TABLES `item_request_extracomptable` WRITE;
/*!40000 ALTER TABLE `item_request_extracomptable` DISABLE KEYS */;
INSERT INTO `item_request_extracomptable` VALUES (1,1,2,2,12,'asd'),(2,1,1,3,12,'asdqwe'),(3,1,2,2,12,'asd'),(4,1,1,3,12,'asdqwe'),(13,2,2,2,11,'qwe'),(14,2,1,4,5,'122');
/*!40000 ALTER TABLE `item_request_extracomptable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_request_inventory`
--

DROP TABLE IF EXISTS `item_request_inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_request_inventory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_request` int(10) unsigned NOT NULL,
  `id_kategori` int(10) unsigned NOT NULL,
  `note` text NOT NULL,
  `jumlah` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_request_inventory`
--

LOCK TABLES `item_request_inventory` WRITE;
/*!40000 ALTER TABLE `item_request_inventory` DISABLE KEYS */;
INSERT INTO `item_request_inventory` VALUES (7,1,1,'qweqwe',12),(8,1,2,'qweqwe',12);
/*!40000 ALTER TABLE `item_request_inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jenis_extracomptable`
--

DROP TABLE IF EXISTS `jenis_extracomptable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jenis_extracomptable` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kd_jenis` varchar(3) NOT NULL,
  `nama` varchar(120) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kd_jenis` (`kd_jenis`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jenis_extracomptable`
--

LOCK TABLES `jenis_extracomptable` WRITE;
/*!40000 ALTER TABLE `jenis_extracomptable` DISABLE KEYS */;
INSERT INTO `jenis_extracomptable` VALUES (1,'01','Meja','Meja kerja','2017-09-11 03:04:01','2017-09-11 03:04:01',NULL),(2,'02','Kursi','Semua jenis kursi','2017-09-10 20:03:41',NULL,NULL);
/*!40000 ALTER TABLE `jenis_extracomptable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `karyawan`
--

DROP TABLE IF EXISTS `karyawan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `karyawan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nik` varchar(32) NOT NULL,
  `nama` varchar(120) NOT NULL,
  `jabatan` varchar(120) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=328 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `karyawan`
--

LOCK TABLES `karyawan` WRITE;
/*!40000 ALTER TABLE `karyawan` DISABLE KEYS */;
INSERT INTO `karyawan` VALUES (1,'6792113Z','Ir. RACHMAT AZWIN, MM.','GENERAL MANAGER UP MUARA KARANG','2017-09-12 14:26:04',NULL,NULL),(2,'7603023JA','TEDDY SUTENDI, ST','MANAJER ENJINIRING & QUALITY ASSURANCE','2017-09-12 14:26:04',NULL,NULL),(3,'6181047K3','BAKTI PRAPDANU','SENIOR ENGINEER II ENJINIRING & QUALITY ASSURANCE','2017-09-12 14:26:04',NULL,NULL),(4,'8108052JA','ULIL AZMI, ST.','PJS SUPERVISOR SENIOR SYSTEM OWNER','2017-09-12 14:26:04',NULL,NULL),(5,'6384316K3','SUTARYAT','ENGINEER SYSTEM OWNER','2017-09-12 14:26:04',NULL,NULL),(6,'6584313K3','SUKONO','ENGINEER SYSTEM OWNER','2017-09-12 14:26:04',NULL,NULL),(7,'7192118K3','DWIJO KARTIKO, S.KOM.','ENGINEER TEKNOLOGI & INFORMASI','2017-09-12 14:26:04',NULL,NULL),(8,'8109043JA','HAYAT PUJIATMOKO, ST.','ASSISTANT ENGINEER SYSTEM OWNER','2017-09-12 14:26:04',NULL,NULL),(9,'8410075JA','HARYO GUSMEDI SUDARMO, ST','ASSISTANT ENGINEER SYSTEM OWNER','2017-09-12 14:26:04',NULL,NULL),(10,'8610074JA','ROBY FIRMANSYAH, ST, M.A.B','ASSISTANT ENGINEER SYSTEM OWNER','2017-09-12 14:26:04',NULL,NULL),(11,'8915124ZJY','BERNANDEZ NOVERSON LUPY, ST.','ASSISTANT ENGINEER SYSTEM OWNER','2017-09-12 14:26:04',NULL,NULL),(12,'9015089ZJY','QAASIM, S.KOM.','ASSISTANT ENGINEER TEKNOLOGI & INFORMASI','2017-09-12 14:26:04',NULL,NULL),(13,'8713031ZJY','DICKY SURYAMAN PUTRA','JUNIOR ENGINEER SYSTEM OWNER','2017-09-12 14:26:04',NULL,NULL),(14,'8007057JA','FAJAR BUDIMAN, ST.','SUPERVISOR SENIOR TECHNOLOGY OWNER','2017-09-12 14:26:04',NULL,NULL),(15,'8007058JA','ANTONIUS DONI RINTOKO, ST.','ASSISTANT ENGINEER TECHNOLOGY OWNER','2017-09-12 14:26:04',NULL,NULL),(16,'9115297ZJY','GREAT ANUGRAH HAMONANGAN SAMOSIR, ST.','ASSISTANT ENGINEER TECHNOLOGY OWNER','2017-09-12 14:26:04',NULL,NULL),(17,'9115298ZJY','GUSTI PRYANDARU, ST.','ASSISTANT ENGINEER TECHNOLOGY OWNER','2017-09-12 14:26:04',NULL,NULL),(18,'8305006JA','INSAP ANGGORO','JUNIOR ENGINEER TECHNOLOGY OWNER','2017-09-12 14:26:04',NULL,NULL),(19,'8405003JA','DEDY KURNIAWAN','JUNIOR ENGINEER TECHNOLOGY OWNER','2017-09-12 14:26:04',NULL,NULL),(20,'8308051JA','FITRIANA WURI HANDAYU, ST.','PJS SUPERVISOR SENIOR MANAJEMEN MUTU, RISIKO & KEPATUHAN','2017-09-12 14:26:04',NULL,NULL),(21,'8510078JA','NILUH GEDE SRI PUSPITA YUDHANTI, ST','ASSISTANT ANALYST MANAJEMEN MUTU, RISIKO & KEPATUHAN','2017-09-12 14:26:04',NULL,NULL),(22,'8814079ZJY','DIDIK SULISTIANTO, S.KOM.','ASSISTANT ANALYST MANAJEMEN MUTU, RISIKO & KEPATUHAN','2017-09-12 14:26:04',NULL,NULL),(23,'6184476K3','EDI SUDONO, ST','MANAJER OPERASI','2017-09-12 14:26:05',NULL,NULL),(24,'6384314K3','Ir. AMIRUDDIN','SENIOR ENGINEER II OPERASI ','2017-09-12 14:26:05',NULL,NULL),(25,'8007003JA','REZZA EKO PRASETYO, ST.','SUPERVISOR SENIOR RENDAL OPERASI PLTU 4-5','2017-09-12 14:26:05',NULL,NULL),(26,'8610069JA','MUHAMMAD DENI INDRAWAN, ST','ASSISTANT ANALYST RENDAL OPERASI PLTU 4-5','2017-09-12 14:26:05',NULL,NULL),(27,'8811025JA','ARIS SULTON','ASSISTANT ANALYST RENDAL OPERASI PLTU 4-5','2017-09-12 14:26:05',NULL,NULL),(28,'9215222ZJY','RIO AFRIANDA, ST.','ASSISTANT ANALYST RENDAL OPERASI PLTU 4-5','2017-09-12 14:26:05',NULL,NULL),(29,'6284064K3','SUTIRTO','SUPERVISOR SENIOR RENDAL OPERASI PLTGU BLOK I ','2017-09-12 14:26:05',NULL,NULL),(30,'8611006JA','ROFIQ WAHYU KURNIAWAN','ASSISTANT ANALYST RENDAL OPERASI PLTGU BLOK I','2017-09-12 14:26:05',NULL,NULL),(31,'8915283ZJY','SETIANTO RAMAPUTRA, ST.','ASSISTANT ANALYST RENDAL OPERASI PLTGU BLOK I','2017-09-12 14:26:05',NULL,NULL),(32,'9111191JA','NANDA FATRIANSYAH, ST','JUNIOR ANALYST RENDAL OPERASI PLTGU BLOK I','2017-09-12 14:26:05',NULL,NULL),(33,'8308095JA','DHIDHIK KRIDHO LAKSONO, ST.','SUPERVISOR SENIOR RENDAL OPERASI PLTGU BLOK II','2017-09-12 14:26:05',NULL,NULL),(34,'8711021JA','INDRA NUR HARIJADI','ASSISTANT ANALYST RENDAL OPERASI PLTGU BLOK II','2017-09-12 14:26:05',NULL,NULL),(35,'8814102ZJY','TONI SUKMAWAN','ASSISTANT ANALYST RENDAL OPERASI PLTGU BLOK II','2017-09-12 14:26:05',NULL,NULL),(36,'9015296ZJY','EMANUEL PAKPAHAN, ST.','ASSISTANT ANALYST RENDAL OPERASI PLTGU BLOK II','2017-09-12 14:26:05',NULL,NULL),(37,'8107009JA','BENI ALANSJAH, ST.','SUPERVISOR SENIOR PRODUKSI PLTU 4-5 A','2017-09-12 14:26:05',NULL,NULL),(38,'7193123K3','SUMARNA','OPERATOR PRODUKSI PLTU 4-5 A','2017-09-12 14:26:05',NULL,NULL),(39,'8614086ZJY','ARISTA ELASAR, ST.','ASSISTANT OPERATOR PRODUKSI PLTU 4-5 A','2017-09-12 14:26:05',NULL,NULL),(40,'8711024JA','SAHANA','ASSISTANT OPERATOR PRODUKSI PLTU 4-5 A','2017-09-12 14:26:05',NULL,NULL),(41,'9016206ZJY','MUHAMAD NUR RAKHMAN, ST','ASSISTANT OPERATOR PRODUKSI PLTU 4-5 A','2017-09-12 14:26:05',NULL,NULL),(42,'8505097JA','SAIFUL ANWAR','JUNIOR OPERATOR PRODUKSI PLTU 4-5 A','2017-09-12 14:26:05',NULL,NULL),(43,'8505099JA','TRI WAHYUDI','JUNIOR OPERATOR PRODUKSI PLTU 4-5 A','2017-09-12 14:26:05',NULL,NULL),(44,'9315359ZJY','MUHAMMAD DAIROTUS SUHUD, A.Md.','JUNIOR OPERATOR PRODUKSI PLTU 4-5 A','2017-09-12 14:26:05',NULL,NULL),(45,'8106068JA','ARIE HARIYANTO, ST.','SUPERVISOR SENIOR PRODUKSI PLTU 4-5 B','2017-09-12 14:26:05',NULL,NULL),(46,'9014092ZJY','ROVIE MARTHA SUTEJO, ST.','ASSISTANT OPERATOR PRODUKSI PLTU 4-5 B','2017-09-12 14:26:05',NULL,NULL),(47,'8305005JA','ARIFIN MAHSUN, ST','JUNIOR OPERATOR PRODUKSI PLTU 4-5 B','2017-09-12 14:26:05',NULL,NULL),(48,'8505098JA','SURYONO','JUNIOR OPERATOR PRODUKSI PLTU 4-5 B','2017-09-12 14:26:05',NULL,NULL),(49,'9013025ZJY','JEFFRY CIPTA SAHA','JUNIOR OPERATOR PRODUKSI PLTU 4-5 B','2017-09-12 14:26:05',NULL,NULL),(50,'9111161JA','ZULFIQRI ACHMAD','JUNIOR OPERATOR PRODUKSI PLTU 4-5 B','2017-09-12 14:26:05',NULL,NULL),(51,'9215347ZJY','FURQONI NURHAKIM, A.Md.','JUNIOR OPERATOR PRODUKSI PLTU 4-5 B','2017-09-12 14:26:05',NULL,NULL),(52,'6584385K3','SUBUR','SUPERVISOR SENIOR PRODUKSI PLTU 4-5 C','2017-09-12 14:26:06',NULL,NULL),(53,'7293130K3','AGUS JAMIL','OPERATOR PRODUKSI PLTU 4-5 C','2017-09-12 14:26:06',NULL,NULL),(54,'7392102K3','EKA TRIMANTA','OPERATOR PRODUKSI PLTU 4-5 C','2017-09-12 14:26:06',NULL,NULL),(55,'8611027JA','SURAJI','ASSISTANT OPERATOR PRODUKSI PLTU 4-5 C','2017-09-12 14:26:06',NULL,NULL),(56,'9015221ZJY','NUZUL LUTHFIHADI, ST.','ASSISTANT OPERATOR PRODUKSI PLTU 4-5 C','2017-09-12 14:26:06',NULL,NULL),(57,'9215282ZJY','MOHAMMAD RIZALDO ADI GURASTO, ST.','ASSISTANT OPERATOR PRODUKSI PLTU 4-5 C','2017-09-12 14:26:06',NULL,NULL),(58,'8305017JA','SIGID DWI WIDODO','JUNIOR OPERATOR PRODUKSI PLTU 4-5 C','2017-09-12 14:26:06',NULL,NULL),(59,'8305021JA','ABDUL HARIS','JUNIOR OPERATOR PRODUKSI PLTU 4-5 C','2017-09-12 14:26:06',NULL,NULL),(60,'8913024ZJY','WAWAN SETYAWAN, MT','JUNIOR OPERATOR PRODUKSI PLTU 4-5 C','2017-09-12 14:26:06',NULL,NULL),(61,'9316062ZJY','ACHMAD SYARIF HIDAYATULLAH, A.Md.','JUNIOR OPERATOR PRODUKSI PLTU 4-5 C','2017-09-12 14:26:06',NULL,NULL),(62,'8007004JA','ERI ANDIKA YUWONO, ST.','SUPERVISOR SENIOR PRODUKSI PLTU 4-5 D','2017-09-12 14:26:06',NULL,NULL),(63,'7592105K3','SIGIT MUARAWAN (LULUS SSE 3/5/13)','OPERATOR PRODUKSI PLTU 4-5 D','2017-09-12 14:26:06',NULL,NULL),(64,'8711028JA','BAGUS RAMADHAN','ASSISTANT OPERATOR PRODUKSI PLTU 4-5 D','2017-09-12 14:26:06',NULL,NULL),(65,'8914101ZJY','RIZAL MAHENDRA PRATAMA','ASSISTANT OPERATOR PRODUKSI PLTU 4-5 D','2017-09-12 14:26:06',NULL,NULL),(66,'8305007JA','PRIYO WIJANARKO','JUNIOR OPERATOR PRODUKSI PLTU 4-5 D','2017-09-12 14:26:06',NULL,NULL),(67,'8911029JA','MUHAMAD NOVAN INDRA ATMOKO','JUNIOR OPERATOR PRODUKSI PLTU 4-5 D','2017-09-12 14:26:06',NULL,NULL),(68,'9315332ZJY','ALFAN ALI FAHMI, A.Md.','JUNIOR OPERATOR PRODUKSI PLTU 4-5 D','2017-09-12 14:26:06',NULL,NULL),(69,'9416076ZJY','SINAR ILHAM HARI SAPUTRA, A.Md.','JUNIOR OPERATOR PRODUKSI PLTU 4-5 D','2017-09-12 14:26:06',NULL,NULL),(70,'7092132K3','SANTOSA','SUPERVISOR SENIOR PRODUKSI PLTU 4-5 E','2017-09-12 14:26:06',NULL,NULL),(71,'7293120K3','ERWIN','OPERATOR PRODUKSI PLTU 4-5 E','2017-09-12 14:26:06',NULL,NULL),(72,'8711026JA','FATKHUR RAKHMAN, ST','ASSISTANT OPERATOR PRODUKSI PLTU 4-5 E','2017-09-12 14:26:06',NULL,NULL),(73,'9014097ZJY','ADHI GUNA PERSADA','ASSISTANT OPERATOR PRODUKSI PLTU 4-5 E','2017-09-12 14:26:06',NULL,NULL),(74,'9115224ZJY','WAHYU HANALDI, ST.','ASSISTANT OPERATOR PRODUKSI PLTU 4-5 E','2017-09-12 14:26:06',NULL,NULL),(75,'8405100JA','YULIANTO','JUNIOR OPERATOR PRODUKSI PLTU 4-5 E','2017-09-12 14:26:06',NULL,NULL),(76,'9013113ZJY','M. FARID TAUFIQ','JUNIOR OPERATOR PRODUKSI PLTU 4-5 E','2017-09-12 14:26:06',NULL,NULL),(77,'9111152JA','ESTU PRAYOGA, A.Md.','JUNIOR OPERATOR PRODUKSI PLTU 4-5 E','2017-09-12 14:26:06',NULL,NULL),(78,'9316072ZJY','MOHAMAD ZAENURI, A.Md.','JUNIOR OPERATOR PRODUKSI PLTU 4-5 E','2017-09-12 14:26:07',NULL,NULL),(79,'9415363ZJY','MUHAMAD HUSEN RAMADHAN, A.Md.','JUNIOR OPERATOR PRODUKSI PLTU 4-5 E','2017-09-12 14:26:07',NULL,NULL),(80,'6992119K3','SUGENG HARIJANTO  (LULUS SSE 07/11/13)','SUPERVISOR SENIOR PRODUKSI PLTGU BLOK I A','2017-09-12 14:26:07',NULL,NULL),(81,'6992086K3','ASEP DJUANDA (LULUS SSE 3/5/13)','OPERATOR PRODUKSI PLTGU BLOK I A','2017-09-12 14:26:07',NULL,NULL),(82,'8710019JA','DANARJAYA BAYU WIDYAWAN','ASSISTANT OPERATOR PRODUKSI PLTGU BLOK I A','2017-09-12 14:26:07',NULL,NULL),(83,'8915211ZJY','ADAM SEPTIAN SABARUDIN, ST.','ASSISTANT OPERATOR PRODUKSI PLTGU BLOK I A','2017-09-12 14:26:07',NULL,NULL),(84,'8305084JA','AGUS SUPRIANTO','JUNIOR OPERATOR PRODUKSI PLTGU BLOK I A','2017-09-12 14:26:07',NULL,NULL),(85,'8405091JA','ARIF YUWONO, S.Kom.','JUNIOR OPERATOR PRODUKSI PLTGU BLOK I A','2017-09-12 14:26:07',NULL,NULL),(86,'8913028ZJY','ANGGA RISMANSYAH','JUNIOR OPERATOR PRODUKSI PLTGU BLOK I A','2017-09-12 14:26:07',NULL,NULL),(87,'8914072ZJY','ARDIAN OKTAKAISAR, ST','JUNIOR OPERATOR PRODUKSI PLTGU BLOK I A','2017-09-12 14:26:07',NULL,NULL),(88,'7192230K3','M. FIRMAN JAZULI','SUPERVISOR SENIOR PRODUKSI PLTGU BLOK I B','2017-09-12 14:26:07',NULL,NULL),(89,'6692108K3','BASWARDI','OPERATOR PRODUKSI PLTGU BLOK I B','2017-09-12 14:26:07',NULL,NULL),(90,'8811003JA','RISKY ARIYO','ASSISTANT OPERATOR PRODUKSI PLTGU BLOK I B','2017-09-12 14:26:07',NULL,NULL),(91,'9015295ZJY','ANDREAS BURMANS, ST.','ASSISTANT OPERATOR PRODUKSI PLTGU BLOK I B','2017-09-12 14:26:07',NULL,NULL),(92,'8205092JA','DIDIN HARYADI','JUNIOR OPERATOR PRODUKSI PLTGU BLOK I B','2017-09-12 14:26:07',NULL,NULL),(93,'8405014JA','MUHAMMAD ARIF ISKANDAR','JUNIOR OPERATOR PRODUKSI PLTGU BLOK I B','2017-09-12 14:26:07',NULL,NULL),(94,'9013026ZJY','ARDHANY AGUNG SAPUTRO','JUNIOR OPERATOR PRODUKSI PLTGU BLOK I B','2017-09-12 14:26:07',NULL,NULL),(95,'9114073ZJY','HERIAN ARISTIANTO','JUNIOR OPERATOR PRODUKSI PLTGU BLOK I B','2017-09-12 14:26:07',NULL,NULL),(96,'9416063ZJY','WAHYU ANDI MARYADI, A.Md.','JUNIOR OPERATOR PRODUKSI PLTGU BLOK I B','2017-09-12 14:26:07',NULL,NULL),(97,'7392111K3','MUJITO (LULUS SSE 3/5/13)','SUPERVISOR SENIOR PRODUKSI PLTGU BLOK I C','2017-09-12 14:26:07',NULL,NULL),(98,'9014090ZJY','PRADANA PUTRADEWA JAYAWARDANA, ST.','ASSISTANT OPERATOR PRODUKSI PLTGU BLOK I C','2017-09-12 14:26:07',NULL,NULL),(99,'9115299ZJY','INDRAWAN WIBISONO, ST.','ASSISTANT OPERATOR PRODUKSI PLTGU BLOK I C','2017-09-12 14:26:07',NULL,NULL),(100,'8405088JA','RAHMAN SYUPANGAT, ST','JUNIOR OPERATOR PRODUKSI PLTGU BLOK I C','2017-09-12 14:26:07',NULL,NULL),(101,'8913027ZJY','AGUS JAMALUDIN','JUNIOR OPERATOR PRODUKSI PLTGU BLOK I C','2017-09-12 14:26:07',NULL,NULL),(102,'8914219ZJY','M. FATHONI','JUNIOR OPERATOR PRODUKSI PLTGU BLOK I C','2017-09-12 14:26:07',NULL,NULL),(103,'9014074ZJY','IQBAL FASYA','JUNIOR OPERATOR PRODUKSI PLTGU BLOK I C','2017-09-12 14:26:07',NULL,NULL),(104,'9217052ZJY','MUHAMMAD WAHYU ADEFANZAH, A.Md.','JUNIOR OPERATOR PRODUKSI PLTGU BLOK I C','2017-09-12 14:26:07',NULL,NULL),(105,'7092133K3','EKO PRIHUTOMO, ST','SUPERVISOR SENIOR PRODUKSI PLTGU BLOK I D','2017-09-12 14:26:08',NULL,NULL),(106,'8610020JA','PREMADI SETYOKO','ASSISTANT OPERATOR PRODUKSI PLTGU BLOK I D','2017-09-12 14:26:08',NULL,NULL),(107,'8811004JA','MOCH ZAINUDIN','ASSISTANT OPERATOR PRODUKSI PLTGU BLOK I D','2017-09-12 14:26:08',NULL,NULL),(108,'8505090JA','TARYONO','JUNIOR OPERATOR PRODUKSI PLTGU BLOK I D','2017-09-12 14:26:08',NULL,NULL),(109,'8914075ZJY','RANDY TIRTA PRADANA','JUNIOR OPERATOR PRODUKSI PLTGU BLOK I D','2017-09-12 14:26:08',NULL,NULL),(110,'9315382ZJY','DES HARIANGGA TRIHANTORO, A.Md.','JUNIOR OPERATOR PRODUKSI PLTGU BLOK I D','2017-09-12 14:26:08',NULL,NULL),(111,'7192121K3','SAFRIZAR, ST','SUPERVISOR SENIOR PRODUKSI PLTGU BLOK I E','2017-09-12 14:26:08',NULL,NULL),(112,'6892110K3','JOKO SUSILO  (LULUS SSE 07/11/13)','OPERATOR PRODUKSI PLTGU BLOK I E','2017-09-12 14:26:08',NULL,NULL),(113,'7392095K3','SUKIRMAN','OPERATOR PRODUKSI PLTGU BLOK I E','2017-09-12 14:26:08',NULL,NULL),(114,'8914100ZJY','DIMAS PRAMESTI','ASSISTANT OPERATOR PRODUKSI PLTGU BLOK I E','2017-09-12 14:26:08',NULL,NULL),(115,'9016215ZJY','YOGI ARIF ROKHMAN, ST','ASSISTANT OPERATOR PRODUKSI PLTGU BLOK I E','2017-09-12 14:26:08',NULL,NULL),(116,'8605086JA','R. PANDU WIRA ATMAJA','JUNIOR OPERATOR PRODUKSI PLTGU BLOK I E','2017-09-12 14:26:08',NULL,NULL),(117,'8810024JA','RAHMAD JAINUL ABIDIN','JUNIOR OPERATOR PRODUKSI PLTGU BLOK I E','2017-09-12 14:26:08',NULL,NULL),(118,'8911007JA','IBNU ARIF WIBOWO','JUNIOR OPERATOR PRODUKSI PLTGU BLOK I E','2017-09-12 14:26:08',NULL,NULL),(119,'9014218ZJY','HARDIANSYAH','JUNIOR OPERATOR PRODUKSI PLTGU BLOK I E','2017-09-12 14:26:08',NULL,NULL),(120,'9216034ZJY','RUMIJO, A.Md.','JUNIOR OPERATOR PRODUKSI PLTGU BLOK I E','2017-09-12 14:26:08',NULL,NULL),(121,'7292107K3','SUDIYONO, ST.','SUPERVISOR SENIOR PRODUKSI PLTGU BLOK II A','2017-09-12 14:26:08',NULL,NULL),(122,'7092113K3','NASRIP HIDAYAT (LULUS SSE 3/5/13)','OPERATOR PRODUKSI PLTGU BLOK II A','2017-09-12 14:26:08',NULL,NULL),(123,'8811014JA','ZULFIKAR AMRULLOH','ASSISTANT OPERATOR PRODUKSI PLTGU BLOK II A','2017-09-12 14:26:08',NULL,NULL),(124,'9015120ZJY','REZON ARIF BUDIMAN, ST.','ASSISTANT OPERATOR PRODUKSI PLTGU BLOK II A','2017-09-12 14:26:08',NULL,NULL),(125,'9115300ZJY','MUHAMMAD IRSYAD KHOLILUDDIN, ST.','ASSISTANT OPERATOR PRODUKSI PLTGU BLOK II A','2017-09-12 14:26:08',NULL,NULL),(126,'8405094JA','JOKO WICAKSONO, ST','JUNIOR OPERATOR PRODUKSI PLTGU BLOK II A','2017-09-12 14:26:08',NULL,NULL),(127,'8914071ZJY','ANDRY SETYO NURCAHYO','JUNIOR OPERATOR PRODUKSI PLTGU BLOK II A','2017-09-12 14:26:08',NULL,NULL),(128,'9115348ZJY','RIFONDA MONANDIKA, ST','JUNIOR OPERATOR PRODUKSI PLTGU BLOK II A','2017-09-12 14:26:08',NULL,NULL),(129,'9216079ZJY','GINANJAR WIDIYATMOKO, A.Md.','JUNIOR OPERATOR PRODUKSI PLTGU BLOK II A','2017-09-12 14:26:08',NULL,NULL),(130,'6992096K3','TARYANA','SUPERVISOR SENIOR PRODUKSI PLTGU BLOK II B','2017-09-12 14:26:08',NULL,NULL),(131,'6792101K3','DENDI SUHERMAN (LULUS SSE 3/5/13)','OPERATOR PRODUKSI PLTGU BLOK II B','2017-09-12 14:26:08',NULL,NULL),(132,'8711083JA','HENDRI SETIAWAN','ASSISTANT OPERATOR PRODUKSI PLTGU BLOK II B','2017-09-12 14:26:08',NULL,NULL),(133,'8814089ZJY','NIKO LASTARDA','ASSISTANT OPERATOR PRODUKSI PLTGU BLOK II B','2017-09-12 14:26:08',NULL,NULL),(134,'9015213ZJY','ADITYA TEGUH SISWANTO, ST.','ASSISTANT OPERATOR PRODUKSI PLTGU BLOK II B','2017-09-12 14:26:09',NULL,NULL),(135,'9216228ZJY','HAFIZD FATHURAHMAN, ST','ASSISTANT OPERATOR PRODUKSI PLTGU BLOK II B','2017-09-12 14:26:09',NULL,NULL),(136,'8505093JA','FANDRI SUHENDI, A.Md','JUNIOR OPERATOR PRODUKSI PLTGU BLOK II B','2017-09-12 14:26:09',NULL,NULL),(137,'8811015JA','LULUK YUGO NUGROHO, ST','JUNIOR OPERATOR PRODUKSI PLTGU BLOK II B','2017-09-12 14:26:09',NULL,NULL),(138,'7392082K3','WIDIYANTO, ST.','SUPERVISOR SENIOR PRODUKSI PLTGU BLOK II C ','2017-09-12 14:26:09',NULL,NULL),(139,'8711017JA','SUPRAPTO, ST','ASSISTANT OPERATOR PRODUKSI PLTGU BLOK II C','2017-09-12 14:26:09',NULL,NULL),(140,'8811018JA','MUHAMMAD ABDULLAH','ASSISTANT OPERATOR PRODUKSI PLTGU BLOK II C','2017-09-12 14:26:09',NULL,NULL),(141,'8814093ZJY','SURYA DWI FACHREZA, ST.','ASSISTANT OPERATOR PRODUKSI PLTGU BLOK II C','2017-09-12 14:26:09',NULL,NULL),(142,'9115169ZJY','ANANDA VERDI SANTOSO, SST.','ASSISTANT OPERATOR PRODUKSI PLTGU BLOK II C','2017-09-12 14:26:09',NULL,NULL),(143,'8405085JA','MUHAMMAD SAIFUL MUJAB','JUNIOR OPERATOR PRODUKSI PLTGU BLOK II C','2017-09-12 14:26:09',NULL,NULL),(144,'8505087JA','FAJAR IRMANSYAH, ST','JUNIOR OPERATOR PRODUKSI PLTGU BLOK II C','2017-09-12 14:26:09',NULL,NULL),(145,'9115334ZJY','ASY SYAUKANI, ST','JUNIOR OPERATOR PRODUKSI PLTGU BLOK II C','2017-09-12 14:26:09',NULL,NULL),(146,'9416039ZJY','MUHAMMAD RIFKI ARDIANSYAH, A.Md.','JUNIOR OPERATOR PRODUKSI PLTGU BLOK II C','2017-09-12 14:26:09',NULL,NULL),(147,'6384310K3','SANTOSA','SUPERVISOR SENIOR PRODUKSI PLTGU BLOK II D','2017-09-12 14:26:09',NULL,NULL),(148,'6892090K3','SUTISNA','OPERATOR PRODUKSI PLTGU BLOK II D','2017-09-12 14:26:09',NULL,NULL),(149,'8614094ZJY','WILDAN MUJAHID, ST.','ASSISTANT OPERATOR PRODUKSI PLTGU BLOK II D','2017-09-12 14:26:09',NULL,NULL),(150,'8915216ZJY','DATU SETYANTO, ST.','ASSISTANT OPERATOR PRODUKSI PLTGU BLOK II D','2017-09-12 14:26:09',NULL,NULL),(151,'8405096JA','RUDIYANTO','JUNIOR OPERATOR PRODUKSI PLTGU BLOK II D','2017-09-12 14:26:09',NULL,NULL),(152,'8605095JA','KUKUH BASUKI','JUNIOR OPERATOR PRODUKSI PLTGU BLOK II D','2017-09-12 14:26:09',NULL,NULL),(153,'8711132JA','JONI SYAIFUL OKTAVIA','JUNIOR OPERATOR PRODUKSI PLTGU BLOK II D','2017-09-12 14:26:09',NULL,NULL),(154,'9115371ZJY','RINALDI AL KAUTSAR, A.Md.','JUNIOR OPERATOR PRODUKSI PLTGU BLOK II D','2017-09-12 14:26:09',NULL,NULL),(155,'9416075ZJY','DWI JUNIANDRI, A.Md.','JUNIOR OPERATOR PRODUKSI PLTGU BLOK II D','2017-09-12 14:26:09',NULL,NULL),(156,'6892094K3','AGUS SUPRIYANTO (LULUS SSE 3/5/13)','SUPERVISOR SENIOR PRODUKSI PLTGU BLOK II E','2017-09-12 14:26:09',NULL,NULL),(157,'6892089K3','WAGITO','OPERATOR PRODUKSI PLTGU BLOK II E','2017-09-12 14:26:09',NULL,NULL),(158,'8611019JA','RAHMA KHARISMA','ASSISTANT OPERATOR PRODUKSI PLTGU BLOK II E','2017-09-12 14:26:09',NULL,NULL),(159,'8811013JA','MUHAMMAD REZA PRABUDI','ASSISTANT OPERATOR PRODUKSI PLTGU BLOK II E','2017-09-12 14:26:09',NULL,NULL),(160,'8911009JA','ADITYA HIMAWAN PURBA, ST','ASSISTANT OPERATOR PRODUKSI PLTGU BLOK II E','2017-09-12 14:26:09',NULL,NULL),(161,'9115170ZJY','ENGGIK DWI PAMUNGKAS, SST.','ASSISTANT OPERATOR PRODUKSI PLTGU BLOK II E','2017-09-12 14:26:09',NULL,NULL),(162,'8405001JA','AGUS SETYONO','JUNIOR OPERATOR PRODUKSI PLTGU BLOK II E','2017-09-12 14:26:10',NULL,NULL),(163,'8911169JA','JOKO SUSANTO','JUNIOR OPERATOR PRODUKSI PLTGU BLOK II E','2017-09-12 14:26:10',NULL,NULL),(164,'9215370ZJY','HENDI SANTOSO SOLIKHIN, A.Md.','JUNIOR OPERATOR PRODUKSI PLTGU BLOK II E','2017-09-12 14:26:10',NULL,NULL),(165,'9416037ZJY','ALIF GIGAH PRIYATNA, A.Md.','JUNIOR OPERATOR PRODUKSI PLTGU BLOK II E','2017-09-12 14:26:10',NULL,NULL),(166,'8108024JA','FRANS ERICSON, ST.','SUPERVISOR SENIOR NIAGA & BAHAN BAKAR','2017-09-12 14:26:10',NULL,NULL),(167,'7192091K3','SUGIYANTO (LULUS SSE 3/5/13)','ANALYST NIAGA','2017-09-12 14:26:10',NULL,NULL),(168,'8310071JA','RENOLD GUNAWAN SIRAIT, ST','ASSISTANT ANALYST NIAGA','2017-09-12 14:26:10',NULL,NULL),(169,'9115087ZJY','FEBRI MUHAMMAD RACHADIAN, ST.','ASSISTANT OFFICER BAHAN BAKAR','2017-09-12 14:26:10',NULL,NULL),(170,'9315220ZJY','LILY RIZKI AULIA, ST.','ASSISTANT OFFICER BAHAN BAKAR','2017-09-12 14:26:10',NULL,NULL),(171,'7292120K3','RUSMANTO','SUPERVISOR SENIOR KIMIA & LABORATORIUM','2017-09-12 14:26:10',NULL,NULL),(172,'8108060JA','MUHAMAD BUDI DARMAWAN, ST.','ASSISTANT ANALYST KIMIA & LABORATORIUM','2017-09-12 14:26:10',NULL,NULL),(173,'8710018JA','SAIFUL HADI CHUDERI, ST','ASSISTANT ANALYST KIMIA & LABORATORIUM','2017-09-12 14:26:10',NULL,NULL),(174,'8915025ZJY','ZULFIKAR MURIADIPUTRA, ST','ASSISTANT ANALYST KIMIA & LABORATORIUM','2017-09-12 14:26:10',NULL,NULL),(175,'9117070ZJY','ARIF NOVIZA UR RAHMAN, ST','ASSISTANT ANALYST KIMIA & LABORATORIUM','2017-09-12 14:26:10',NULL,NULL),(176,'9216105ZJY','MUHAMAD WISNU NUGROHO, ST','ASSISTANT ANALYST KIMIA & LABORATORIUM','2017-09-12 14:26:10',NULL,NULL),(177,'9216122ZJY','PERMANA JAYA HIKMAT, ST','ASSISTANT ANALYST KIMIA & LABORATORIUM','2017-09-12 14:26:10',NULL,NULL),(178,'8810023JA','DIDIT PRIYANTORO','JUNIOR ANALYST KIMIA & LABORATORIUM','2017-09-12 14:26:10',NULL,NULL),(179,'8813029ZJY','MIRZA HADI KHUSYAIRI','JUNIOR ANALYST KIMIA & LABORATORIUM','2017-09-12 14:26:10',NULL,NULL),(180,'9014070ZJY','WAHYU JUNAEDI','JUNIOR ANALYST KIMIA & LABORATORIUM','2017-09-12 14:26:10',NULL,NULL),(181,'9215333ZJY','ALFATH MAULID, ST','JUNIOR ANALYST KIMIA & LABORATORIUM','2017-09-12 14:26:10',NULL,NULL),(182,'7603019JA','JUNAIDI ABDI, ST','MANAJER PEMELIHARAAN','2017-09-12 14:26:10',NULL,NULL),(183,'6181099K3','KECO KARSAI','SENIOR ENGINEER II PEMELIHARAAN','2017-09-12 14:26:10',NULL,NULL),(184,'6584380K3','PADMONO','SENIOR ENGINEER II PEMELIHARAAN','2017-09-12 14:26:10',NULL,NULL),(185,'8510076JA','JUNAEDI SETIO HANUROGO, ST','SUPERVISOR SENIOR RENDAL PEMELIHARAAN PLTU 4-5','2017-09-12 14:26:10',NULL,NULL),(186,'8614076ZJY','OKTA VARID SAKTIAWAN','ASSISTANT ANALYST RENDAL PEMELIHARAAN PLTU 4-5','2017-09-12 14:26:10',NULL,NULL),(187,'8714084ZJY','ARIEF PONTIADARMA, ST.','ASSISTANT ANALYST RENDAL PEMELIHARAAN PLTU 4-5','2017-09-12 14:26:10',NULL,NULL),(188,'9115024ZJY','ARFINNA CAHYANI, ST','ASSISTANT ANALYST RENDAL PEMELIHARAAN PLTU 4-5','2017-09-12 14:26:10',NULL,NULL),(189,'9215223ZJY','TEDDY FEBRIANTO, ST.','ASSISTANT ANALYST RENDAL PEMELIHARAAN PLTU 4-5','2017-09-12 14:26:10',NULL,NULL),(190,'8006070JA','I GUSTI PUTU YUDIASTAWAN, ST, M.Si.','SUPERVISOR SENIOR RENDAL PEMELIHARAAN PLTGU BLOK I','2017-09-12 14:26:11',NULL,NULL),(191,'9115215ZJY','ANGGUN MAYASARI, ST.','ASSISTANT ANALYST RENDAL PEMELIHARAAN PLTGU BLOK I','2017-09-12 14:26:11',NULL,NULL),(192,'9215121ZJY','MAXIMILIANUS, ST.','ASSISTANT ANALYST RENDAL PEMELIHARAAN PLTGU BLOK I','2017-09-12 14:26:11',NULL,NULL),(193,'9215212ZJY','ADITYA PRATAMA, ST.','ASSISTANT ANALYST RENDAL PEMELIHARAAN PLTGU BLOK I','2017-09-12 14:26:11',NULL,NULL),(194,'8505089JA','RULLYANTO KURNIAWAN, ST','JUNIOR ANALYST RENDAL PEMELIHARAAN PLTGU BLOK I','2017-09-12 14:26:11',NULL,NULL),(195,'8207060JA','OKWALDU PURBA, ST, MT','SUPERVISOR SENIOR RENDAL PEMELIHARAAN PLTGU BLOK II','2017-09-12 14:26:11',NULL,NULL),(196,'8210070JA','RULLY GUMILAR MUSTARI, ST','ASSISTANT ANALYST RENDAL PEMELIHARAAN PLTGU BLOK II','2017-09-12 14:26:11',NULL,NULL),(197,'8405066JA','AGUS PURWANTO','JUNIOR ANALYST RENDAL PEMELIHARAAN PLTGU BLOK II','2017-09-12 14:26:11',NULL,NULL),(198,'9517054ZJY','PARAMITA ANGGRAENI, A.Md.','JUNIOR ANALYST RENDAL PEMELIHARAAN PLTGU BLOK II','2017-09-12 14:26:11',NULL,NULL),(199,'9617053ZJY','AMELIA FATHIN, A.Md.','JUNIOR ANALYST RENDAL PEMELIHARAAN PLTGU BLOK II','2017-09-12 14:26:11',NULL,NULL),(200,'6484365K3','HENRIKUS HATMANTO','SUPERVISOR SENIOR PEMELIHARAAN MESIN PLTU 4-5','2017-09-12 14:26:11',NULL,NULL),(201,'6784325K3','MUHTAR','ASSISTANT ENGINEER PEMELIHARAAN MESIN PLTU 4-5','2017-09-12 14:26:11',NULL,NULL),(202,'7292087K3','KRISYANTO','ASSISTANT ENGINEER PEMELIHARAAN MESIN PLTU 4-5','2017-09-12 14:26:11',NULL,NULL),(203,'8108054JA','ARIF DWI SETIAWAN, ST.','ASSISTANT ENGINEER PEMELIHARAAN MESIN PLTU 4-5','2017-09-12 14:26:11',NULL,NULL),(204,'8614099ZJY','DIMAS DWISANTOSO','ASSISTANT ENGINEER PEMELIHARAAN MESIN PLTU 4-5','2017-09-12 14:26:11',NULL,NULL),(205,'9117017ZJY','SIDIK FEBRI PRASETYA, ST','ASSISTANT ENGINEER PEMELIHARAAN MESIN PLTU 4-5','2017-09-12 14:26:11',NULL,NULL),(206,'9216200ZJY','MUCHAMAD HAWIDHI SUKARNA, ST','ASSISTANT ENGINEER PEMELIHARAAN MESIN PLTU 4-5','2017-09-12 14:26:11',NULL,NULL),(207,'9217018ZJY','YUSUF SATRIA PRIHARDANA, ST','ASSISTANT ENGINEER PEMELIHARAAN MESIN PLTU 4-5','2017-09-12 14:26:11',NULL,NULL),(208,'9215335ZJY','SAMUEL SIHOTANG, A.Md.','JUNIOR ENGINEER PEMELIHARAAN MESIN PLTU 4-5','2017-09-12 14:26:11',NULL,NULL),(209,'7906009JA','ERRYAWAN KUSUMA, ST.','SUPERVISOR SENIOR PEMELIHARAAN MESIN PLTGU BLOK I','2017-09-12 14:26:11',NULL,NULL),(210,'8914098ZJY','DICKY WICAKSONO','ASSISTANT ENGINEER PEMELIHARAAN MESIN PLTGU BLOK I','2017-09-12 14:26:11',NULL,NULL),(211,'8915026ZJY','INDRA ALKADRI, ST','ASSISTANT ENGINEER PEMELIHARAAN MESIN PLTGU BLOK I','2017-09-12 14:26:11',NULL,NULL),(212,'9116218ZJY','AHMAD GHOZI ARIJUDDIN, ST','ASSISTANT ENGINEER PEMELIHARAAN MESIN PLTGU BLOK I','2017-09-12 14:26:11',NULL,NULL),(213,'9216191ZJY','YOGIE ARISANDI TRISNAWAN, ST','ASSISTANT ENGINEER PEMELIHARAAN MESIN PLTGU BLOK I','2017-09-12 14:26:11',NULL,NULL),(214,'8305018JA','IRPAN KRISNAWANTO','JUNIOR ENGINEER PEMELIHARAAN MESIN PLTGU BLOK I','2017-09-12 14:26:11',NULL,NULL),(215,'8405015JA','WINARKO','JUNIOR ENGINEER PEMELIHARAAN MESIN PLTGU BLOK I','2017-09-12 14:26:11',NULL,NULL),(216,'9013030ZJY','AGUNG WANNA PRATOMO, ST','JUNIOR ENGINEER PEMELIHARAAN MESIN PLTGU BLOK I','2017-09-12 14:26:11',NULL,NULL),(217,'6284379K3','RAMDANI','SUPERVISOR SENIOR PEMELIHARAAN MESIN PLTGU BLOK II','2017-09-12 14:26:11',NULL,NULL),(218,'6181029K3','HARMANTO','ENGINEER PEMELIHARAAN MESIN PLTGU BLOK II','2017-09-12 14:26:11',NULL,NULL),(219,'8509045JA','ARIS KURNIAWAN, ST.','ASSISTANT ENGINEER PEMELIHARAAN MESIN PLTGU BLOK II','2017-09-12 14:26:12',NULL,NULL),(220,'9015144ZJY','YERSON, ST.','ASSISTANT ENGINEER PEMELIHARAAN MESIN PLTGU BLOK II','2017-09-12 14:26:12',NULL,NULL),(221,'9216226ZJY','EVAN SATRIA, ST','ASSISTANT ENGINEER PEMELIHARAAN MESIN PLTGU BLOK II','2017-09-12 14:26:12',NULL,NULL),(222,'8914221ZJY','EBSAN SIMAMORA','JUNIOR ENGINEER PEMELIHARAAN MESIN PLTGU BLOK II','2017-09-12 14:26:12',NULL,NULL),(223,'9214220ZJY','RIZA KURNIAWAN','JUNIOR ENGINEER PEMELIHARAAN MESIN PLTGU BLOK II','2017-09-12 14:26:12',NULL,NULL),(224,'9315369ZJY','DWI GILANG RIDHO AKBAR, A.Md.','JUNIOR ENGINEER PEMELIHARAAN MESIN PLTGU BLOK II','2017-09-12 14:26:12',NULL,NULL),(225,'6584371K3','SUYADI','SUPERVISOR SENIOR PEMELIHARAAN LISTRIK PLTU 4-5','2017-09-12 14:26:12',NULL,NULL),(226,'8916130ZJY','WAKHID ALHABSHI LUKMAN, ST','ASSISTANT ENGINEER PEMELIHARAAN LISTRIK PLTU 4-5','2017-09-12 14:26:12',NULL,NULL),(227,'9015166ZJY','RIDWAN IRWANSYAH, SST.','ASSISTANT ENGINEER PEMELIHARAAN LISTRIK PLTU 4-5','2017-09-12 14:26:12',NULL,NULL),(228,'8305002JA','HERMAWAN ARDIAMSYAH, A.Md','JUNIOR ENGINEER PEMELIHARAAN LISTRIK PLTU 4-5','2017-09-12 14:26:12',NULL,NULL),(229,'8305010JA','EKO YUNI NUGROHO, ST.','JUNIOR ENGINEER PEMELIHARAAN LISTRIK PLTU 4-5','2017-09-12 14:26:12',NULL,NULL),(230,'8308058JA','ADIMAS PRADITYO, ST.','SUPERVISOR SENIOR PEMELIHARAAN LISTRIK PLTGU BLOK I','2017-09-12 14:26:12',NULL,NULL),(231,'8714088ZJY','KUNCORO ADI DEWANTO, ST.','ASSISTANT ENGINEER PEMELIHARAAN LISTRIK PLTGU BLOK I','2017-09-12 14:26:12',NULL,NULL),(232,'9017016ZJY','FAZARI ABDILLAH, ST','ASSISTANT ENGINEER PEMELIHARAAN LISTRIK PLTGU BLOK I','2017-09-12 14:26:12',NULL,NULL),(233,'9215123ZJY','DEWANTO RAHMAN HARTONO, ST.','ASSISTANT ENGINEER PEMELIHARAAN LISTRIK PLTGU BLOK I','2017-09-12 14:26:12',NULL,NULL),(234,'9216147ZJY','DONI PRASSETYO, ST','ASSISTANT ENGINEER PEMELIHARAAN LISTRIK PLTGU BLOK I','2017-09-12 14:26:12',NULL,NULL),(235,'8305008JA','SUGENG RIYANTO, ST','JUNIOR ENGINEER PEMELIHARAAN LISTRIK PLTGU BLOK I','2017-09-12 14:26:12',NULL,NULL),(236,'8609064JA','HELMY NUR EFENDI YUSUF, ST','PJS SUPERVISOR SENIOR PEMELIHARAAN LISTRIK PLTGU BLOK II','2017-09-12 14:26:12',NULL,NULL),(237,'6384388K3','NANA SUKARNA','ENGINEER PEMELIHARAAN LISTRIK PLTGU BLOK II','2017-09-12 14:26:12',NULL,NULL),(238,'8815218ZJY','EDY SOFIAN, ST.','ASSISTANT ENGINEER PEMELIHARAAN LISTRIK PLTGU BLOK II','2017-09-12 14:26:12',NULL,NULL),(239,'9014091ZJY','ROBBY FIERDAUS, ST.','ASSISTANT ENGINEER PEMELIHARAAN LISTRIK PLTGU BLOK II','2017-09-12 14:26:12',NULL,NULL),(240,'9216125ZJY','JANUAR HAMIDY, ST','ASSISTANT ENGINEER PEMELIHARAAN LISTRIK PLTGU BLOK II','2017-09-12 14:26:12',NULL,NULL),(241,'8205013JA','YUDI SETIAWAN','JUNIOR ENGINEER PEMELIHARAAN LISTRIK PLTGU BLOK II','2017-09-12 14:26:12',NULL,NULL),(242,'8305009JA','ADI GREFIAWAN','JUNIOR ENGINEER PEMELIHARAAN LISTRIK PLTGU BLOK II','2017-09-12 14:26:12',NULL,NULL),(243,'9111165JA','NURSYAHID SUHARTO','JUNIOR ENGINEER PEMELIHARAAN LISTRIK PLTGU BLOK II','2017-09-12 14:26:12',NULL,NULL),(244,'8409028JA','TONNY HERNANTO WIBOWO, ST.','PJS SUPERVISOR SENIOR PEMELIHARAAN KONTROL & INSTRUMEN PLTU 4-5','2017-09-12 14:26:13',NULL,NULL),(245,'8914085ZJY','ARIS PURWANTO WIBOWO, ST.','ASSISTANT ENGINEER PEMELIHARAAN KONTROL & INSTRUMEN PLTU 4-5','2017-09-12 14:26:13',NULL,NULL),(246,'9015217ZJY','DIDI WAHYUDI, ST.','ASSISTANT ENGINEER PEMELIHARAAN KONTROL & INSTRUMEN PLTU 4-5','2017-09-12 14:26:13',NULL,NULL),(247,'9216159ZJY','RAZDRIZAL RIZKI, ST','ASSISTANT ENGINEER PEMELIHARAAN KONTROL & INSTRUMEN PLTU 4-5','2017-09-12 14:26:13',NULL,NULL),(248,'8305011JA','HENDIK HIDAYATULLAH, ST','JUNIOR ENGINEER PEMELIHARAAN KONTROL & INSTRUMEN PLTU 4-5','2017-09-12 14:26:13',NULL,NULL),(249,'9011158JA','HENDRA FAUZAN AKBAR','JUNIOR ENGINEER PEMELIHARAAN KONTROL & INSTRUMEN PLTU 4-5','2017-09-12 14:26:13',NULL,NULL),(250,'7092131K3','MUJIYONO, ST','SUPERVISOR SENIOR PEMELIHARAAN KONTROL & INSTRUMEN PLTGU BLOK I','2017-09-12 14:26:13',NULL,NULL),(251,'8308091JA','SUHARDIMAN NURKHOLIQ, ST.','ASSISTANT ENGINEER PEMELIHARAAN KONTROL & INSTRUMEN PLTGU BLOK I','2017-09-12 14:26:13',NULL,NULL),(252,'8614082ZJY','A. JAMIL JUFNI, ST,','ASSISTANT ENGINEER PEMELIHARAAN KONTROL & INSTRUMEN PLTGU BLOK I','2017-09-12 14:26:13',NULL,NULL),(253,'8811008JA','RAKHMAD HIDAYATULLAH, ST','ASSISTANT ENGINEER PEMELIHARAAN KONTROL & INSTRUMEN PLTGU BLOK I','2017-09-12 14:26:13',NULL,NULL),(254,'9015214ZJY','ADITYA YUDA PRATAMA, ST.','ASSISTANT ENGINEER PEMELIHARAAN KONTROL & INSTRUMEN PLTGU BLOK I','2017-09-12 14:26:13',NULL,NULL),(255,'9316156ZJY','RENDY KRISNANTA PUTRA, ST','ASSISTANT ENGINEER PEMELIHARAAN KONTROL & INSTRUMEN PLTGU BLOK I','2017-09-12 14:26:13',NULL,NULL),(256,'8305012JA','RIGO PURWANTO, ST','JUNIOR ENGINEER PEMELIHARAAN KONTROL & INSTRUMEN PLTGU BLOK I','2017-09-12 14:26:13',NULL,NULL),(257,'8305020JA','ACHMAD KHUMAIDI, ST','JUNIOR ENGINEER PEMELIHARAAN KONTROL & INSTRUMEN PLTGU BLOK I','2017-09-12 14:26:13',NULL,NULL),(258,'8108092JA','MUH. NURDINSIDIQ, ST.','SUPERVISOR SENIOR PEMELIHARAAN KONTROL & INSTRUMEN PLTGU BLOK II','2017-09-12 14:26:13',NULL,NULL),(259,'8814083ZJY','ALDO GAUS CIPUTRA','ASSISTANT ENGINEER PEMELIHARAAN KONTROL & INSTRUMEN PLTGU BLOK II','2017-09-12 14:26:13',NULL,NULL),(260,'8915122ZJY','IRWAN FIRDAUS, SST.','ASSISTANT ENGINEER PEMELIHARAAN KONTROL & INSTRUMEN PLTGU BLOK II','2017-09-12 14:26:13',NULL,NULL),(261,'9215219ZJY','I WAYAN ARYADI, ST.','ASSISTANT ENGINEER PEMELIHARAAN KONTROL & INSTRUMEN PLTGU BLOK II','2017-09-12 14:26:13',NULL,NULL),(262,'9316162ZJY','MUHAMAD ARIF PRATAMA, ST','ASSISTANT ENGINEER PEMELIHARAAN KONTROL & INSTRUMEN PLTGU BLOK II','2017-09-12 14:26:13',NULL,NULL),(263,'9011157JA','DANI FATUR RAHMAN','JUNIOR ENGINEER PEMELIHARAAN KONTROL & INSTRUMEN PLTGU BLOK II','2017-09-12 14:26:13',NULL,NULL),(264,'9111154JA','TOMY KURNIAWAN','JUNIOR ENGINEER PEMELIHARAAN KONTROL & INSTRUMEN PLTGU BLOK II','2017-09-12 14:26:13',NULL,NULL),(265,'8108056JA','JAYADI, ST, MM','SUPERVISOR SENIOR OUTAGE MANAGEMENT','2017-09-12 14:26:13',NULL,NULL),(266,'8108057JA','MOHAMAD ABDUL WAHAB, ST.','ASSISTANT ANALYST OUTAGE MANAGEMENT','2017-09-12 14:26:13',NULL,NULL),(267,'8814078ZJY','ERTHA APTALIA, ST.','ASSISTANT ANALYST OUTAGE MANAGEMENT','2017-09-12 14:26:13',NULL,NULL),(268,'8911010JA','EGI SUTRISNO','ASSISTANT ANALYST OUTAGE MANAGEMENT','2017-09-12 14:26:13',NULL,NULL),(269,'9115301ZJY','YAYANG RUSDIANA, ST.','ASSISTANT ANALYST OUTAGE MANAGEMENT','2017-09-12 14:26:13',NULL,NULL),(270,'6584377K3','KAMIRAN','SUPERVISOR SENIOR SARANA','2017-09-12 14:26:14',NULL,NULL),(271,'6284078K3','PARNUJI','OFFICER SARANA','2017-09-12 14:26:14',NULL,NULL),(272,'6584386K3','SURYANA','OFFICER SARANA','2017-09-12 14:26:14',NULL,NULL),(273,'9116238ZJY','ANGGA YUGOSWARA, ST','ASSISTANT OFFICER SARANA','2017-09-12 14:26:14',NULL,NULL),(274,'9116241ZJY','KOKO APRIYANTO, ST','ASSISTANT OFFICER SARANA','2017-09-12 14:26:14',NULL,NULL),(275,'9115108ZJY','DIMAS HANANTA MULYAWAN','JUNIOR OFFICER SARANA','2017-09-12 14:26:14',NULL,NULL),(276,'8208025JA','FAUZI LEILAN, ST.','SUPERVISOR SENIOR  LINGKUNGAN','2017-09-12 14:26:14',NULL,NULL),(277,'6284326K3','ALPA ALMINO','ANALYST LINGKUNGAN','2017-09-12 14:26:14',NULL,NULL),(278,'6384389K3','IWAN IRAWAN','ANALYST LINGKUNGAN','2017-09-12 14:26:14',NULL,NULL),(279,'8710068JA','TANIA REVINA YASIN, ST','ASSISTANT ANALYST LINGKUNGAN','2017-09-12 14:26:14',NULL,NULL),(280,'9316186ZJY','IMAN DIMASSETYA YANUAR YUSUF, ST','ASSISTANT ANALYST LINGKUNGAN','2017-09-12 14:26:14',NULL,NULL),(281,'8910022JA','ZAKIYYAH RAHMAWATI','JUNIOR ANALYST LINGKUNGAN','2017-09-12 14:26:14',NULL,NULL),(282,'7292081K3','CHORIB','SUPERVISOR SENIOR K3','2017-09-12 14:26:14',NULL,NULL),(283,'6584387K3','ADANG SURYANA','OFFICER K3','2017-09-12 14:26:14',NULL,NULL),(284,'6893128K3','GUNADI (LULUS SSE 07/11/13)','OFFICER K3','2017-09-12 14:26:14',NULL,NULL),(285,'7092139K3','ISEP MULYAHADI, SH.','OFFICER K3','2017-09-12 14:26:14',NULL,NULL),(286,'8208059JA','MARIA SHOFA, ST.','ASSISTANT OFFICER K3','2017-09-12 14:26:14',NULL,NULL),(287,'7906030JA','SATRIO ADHIKUSUMO, ST, MM.','MANAJER LOGISTIK','2017-09-12 14:26:14',NULL,NULL),(288,'8710098JA','ISTI PUTRI RIZQIAH, SH','PJS SUPERVISOR SENIOR INVENTORI KONTROL & KATALOGER','2017-09-12 14:26:14',NULL,NULL),(289,'8814095ZJY','MUHAMMAD IRSYAD RUSDIN, ST.','ASSISTANT OFFICER INVENTORI KONTROL & KATALOGER','2017-09-12 14:26:14',NULL,NULL),(290,'9015086ZJY','CATUR SIWI HANDAYANINGTYAS, ST.','ASSISTANT OFFICER INVENTORI KONTROL & KATALOGER','2017-09-12 14:26:14',NULL,NULL),(291,'9114096ZJY','NIA PUSPITA SARI, ST.','ASSISTANT OFFICER INVENTORI KONTROL & KATALOGER','2017-09-12 14:26:14',NULL,NULL),(292,'9416149ZJY','FERONICA FATIMAH, ST','ASSISTANT OFFICER INVENTORI KONTROL & KATALOGER','2017-09-12 14:26:14',NULL,NULL),(293,'6893329K3','HENI LISTIANINGSIH','SUPERVISOR SENIOR PENGADAAN','2017-09-12 14:26:14',NULL,NULL),(294,'7292115K3','SUNARTO (LULUS SSE 3/5/13)','OFFICER PENGADAAN','2017-09-12 14:26:14',NULL,NULL),(295,'7193121K3','HISMAN','ASSISTANT OFFICER PENGADAAN','2017-09-12 14:26:15',NULL,NULL),(296,'8309027JA','PRASASTI DIAN SANJAYA, SE.','ASSISTANT OFFICER PENGADAAN','2017-09-12 14:26:15',NULL,NULL),(297,'8714077ZJY','RAMA ANDHIKA SAPUTRA, SE.','ASSISTANT OFFICER PENGADAAN','2017-09-12 14:26:15',NULL,NULL),(298,'9015165ZJY','GRASTIKA SELVYA SETYO DAMAYANTI, ST.','ASSISTANT OFFICER PENGADAAN','2017-09-12 14:26:15',NULL,NULL),(299,'9316115ZJY','TITAH SHANTY SARASWATI, SH','ASSISTANT OFFICER PENGADAAN','2017-09-12 14:26:15',NULL,NULL),(300,'9013032ZJY','RESTI MORTIKA, A.Md.','JUNIOR OFFICER PENGADAAN','2017-09-12 14:26:15',NULL,NULL),(301,'9215022ZJY','MUHAMMAD IMRAN MITRANINGJEKTI, A.Md.','JUNIOR OFFICER PENGADAAN','2017-09-12 14:26:15',NULL,NULL),(302,'6588063K3','HERIYANTO','SUPERVISOR SENIOR ADMINISTRASI GUDANG','2017-09-12 14:26:15',NULL,NULL),(303,'6184797K3','PRAYITNO, SE.','OFFICER ADMINISTRASI GUDANG','2017-09-12 14:26:15',NULL,NULL),(304,'6284384K3','MARKUS BAMBANG IRIANTO','OFFICER ADMINISTRASI GUDANG','2017-09-12 14:26:15',NULL,NULL),(305,'6893122K3','DEDI EKA PUTRA','ASSISTANT OFFICER ADMINISTRASI GUDANG','2017-09-12 14:26:15',NULL,NULL),(306,'8305019JA','SUBROTO MULIAR WAHYONO, A.Md','JUNIOR OFFICER ADMINISTRASI GUDANG','2017-09-12 14:26:15',NULL,NULL),(307,'6484081K3','MARYONO','MANAJER KEUANGAN & ADMINISTRASI','2017-09-12 14:26:15',NULL,NULL),(308,'8308019JA','NENSSY SORAYA DHELVI, SE.','SUPERVISOR SENIOR SDM','2017-09-12 14:26:15',NULL,NULL),(309,'8408111JA','ERVINA WAHYU MAULINA, S. Psi.','ASSISTANT OFFICER PELATIHAN','2017-09-12 14:26:15',NULL,NULL),(310,'8814006ZJY','I GUSTI NGURAH BARTHA PRADNYA P, ST','ASSISTANT OFFICER ADMINISTRASI SDM ','2017-09-12 14:26:15',NULL,NULL),(311,'9215090ZJY','RITA MONICA, S.MB.','ASSISTANT OFFICER ADMINISTRASI SDM ','2017-09-12 14:26:15',NULL,NULL),(312,'8815151ZJY','ALDY ZULYANECHA SP, SE.','ASSISTANT OFFICER PELATIHAN SDM ','2017-09-12 14:26:15',NULL,NULL),(313,'9011166JA','SEPTIADI WANTORO','JUNIOR OFFICER PELATIHAN SDM','2017-09-12 14:26:15',NULL,NULL),(314,'6384374K3','IDA SUHIAT','SUPERVISOR SENIOR UMUM & CSR','2017-09-12 14:26:15',NULL,NULL),(315,'6284172K3','R. DEWI ROSFITASARI','OFFICER UMUM','2017-09-12 14:26:15',NULL,NULL),(316,'6584372K3','M. AGUS BUDIANSYAH','OFFICER UMUM','2017-09-12 14:26:15',NULL,NULL),(317,'6893131K3','SUKIYO','ASSISTANT OFFICER KEAMANAN','2017-09-12 14:26:15',NULL,NULL),(318,'8915023ZJY','SARIKA APRIYENI GOPAR, S.IKOM','ASSISTANT OFFICER HUMAS & CSR','2017-09-12 14:26:15',NULL,NULL),(319,'9017067ZJY','DITYAN SATYAYONI, S.IKOM','ASSISTANT OFFICER HUMAS & CSR','2017-09-12 14:26:15',NULL,NULL),(320,'9115091ZJY','SAURIN APRILIAWAN, S.Sos.','ASSISTANT OFFICER HUMAS & CSR','2017-09-12 14:26:15',NULL,NULL),(321,'8915149ZJY','MOCHAMAD RIDHO ALDHILLA, SE.','ASSISTANT OFFICER UMUM','2017-09-12 14:26:15',NULL,NULL),(322,'8208018JA','HETTY ROSITA WIDYASTUTIE, SE.','SUPERVISOR SENIOR KEUANGAN','2017-09-12 14:26:15',NULL,NULL),(323,'6182107K3','HASANUDIN','OFFICER KEUANGAN & ANGGARAN','2017-09-12 14:26:16',NULL,NULL),(324,'7393126K3','WARNOTO','OFFICER KEUANGAN & ANGGARAN','2017-09-12 14:26:16',NULL,NULL),(325,'9115088ZJY','REVITA DWI UTARI, SE.','ASSISTANT OFFICER AKUNTANSI','2017-09-12 14:26:16',NULL,NULL),(326,'8913034ZJY','EGA KUSUMA DWI PUTRI, A.Md.','JUNIOR OFFICER KEUANGAN & ANGGARAN','2017-09-12 14:26:16',NULL,NULL),(327,'9114069ZJY','SUHESTIKA AJENG YOLANDA, A.Md.','JUNIOR OFFICER AKUNTANSI','2017-09-12 14:26:16',NULL,NULL);
/*!40000 ALTER TABLE `karyawan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategori_inventory`
--

DROP TABLE IF EXISTS `kategori_inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kategori_inventory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kd_kategori` varchar(3) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kd_kategori` (`kd_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori_inventory`
--

LOCK TABLES `kategori_inventory` WRITE;
/*!40000 ALTER TABLE `kategori_inventory` DISABLE KEYS */;
INSERT INTO `kategori_inventory` VALUES (1,'01','Kertas','2017-09-11 09:13:24',NULL,NULL),(2,'02','Pulpen','2017-09-11 09:13:32',NULL,NULL);
/*!40000 ALTER TABLE `kategori_inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2016_08_07_145904_add_table_cms_apicustom',1),(2,'2016_08_07_150834_add_table_cms_dashboard',1),(3,'2016_08_07_151210_add_table_cms_logs',1),(4,'2016_08_07_151211_add_details_cms_logs',1),(5,'2016_08_07_152014_add_table_cms_privileges',1),(6,'2016_08_07_152214_add_table_cms_privileges_roles',1),(7,'2016_08_07_152320_add_table_cms_settings',1),(8,'2016_08_07_152421_add_table_cms_users',1),(9,'2016_08_07_154624_add_table_cms_menus_privileges',1),(10,'2016_08_07_154624_add_table_cms_moduls',1),(11,'2016_08_17_225409_add_status_cms_users',1),(12,'2016_08_20_125418_add_table_cms_notifications',1),(13,'2016_09_04_033706_add_table_cms_email_queues',1),(14,'2016_09_16_035347_add_group_setting',1),(15,'2016_09_16_045425_add_label_setting',1),(16,'2016_09_17_104728_create_nullable_cms_apicustom',1),(17,'2016_10_01_141740_add_method_type_apicustom',1),(18,'2016_10_01_141846_add_parameters_apicustom',1),(19,'2016_10_01_141934_add_responses_apicustom',1),(20,'2016_10_01_144826_add_table_apikey',1),(21,'2016_11_14_141657_create_cms_menus',1),(22,'2016_11_15_132350_create_cms_email_templates',1),(23,'2016_11_15_190410_create_cms_statistics',1),(24,'2016_11_17_102740_create_cms_statistic_components',1),(25,'2017_06_06_164501_add_deleted_at_cms_moduls',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_aktiva_tetap`
--

DROP TABLE IF EXISTS `model_aktiva_tetap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_aktiva_tetap` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kd_model` varchar(3) NOT NULL,
  `nama_model` varchar(120) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kd_model` (`kd_model`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_aktiva_tetap`
--

LOCK TABLES `model_aktiva_tetap` WRITE;
/*!40000 ALTER TABLE `model_aktiva_tetap` DISABLE KEYS */;
INSERT INTO `model_aktiva_tetap` VALUES (1,'01','Kendaraan','Mobil, motor, etc','2017-09-11 06:49:01',NULL,NULL),(2,'02','Bangunan','Gedung, gudang, dsb','2017-09-11 06:49:12',NULL,NULL),(3,'03','Tanah','tanah','2017-09-11 06:49:22',NULL,NULL);
/*!40000 ALTER TABLE `model_aktiva_tetap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pemeliharaan_aktiva_tetap`
--

DROP TABLE IF EXISTS `pemeliharaan_aktiva_tetap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pemeliharaan_aktiva_tetap` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kd_pemeliharaan` varchar(12) NOT NULL,
  `nik_karyawan` varchar(32) NOT NULL,
  `jenis_pemeliharaan` varchar(120) NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `note` text NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kd_pemeliharaan` (`kd_pemeliharaan`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pemeliharaan_aktiva_tetap`
--

LOCK TABLES `pemeliharaan_aktiva_tetap` WRITE;
/*!40000 ALTER TABLE `pemeliharaan_aktiva_tetap` DISABLE KEYS */;
INSERT INTO `pemeliharaan_aktiva_tetap` VALUES (1,'PA170913001','9015214ZJY','x','2017-09-13','2017-09-13','qwery','depok','2017-09-13 04:48:58','2017-09-13 04:48:58',NULL);
/*!40000 ALTER TABLE `pemeliharaan_aktiva_tetap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pemeliharaan_extracomptable`
--

DROP TABLE IF EXISTS `pemeliharaan_extracomptable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pemeliharaan_extracomptable` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kd_pemeliharaan` varchar(12) NOT NULL,
  `nik_karyawan` varchar(32) NOT NULL,
  `jenis_pemeliharaan` varchar(120) NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `note` text NOT NULL,
  `id_gedung` int(10) unsigned NOT NULL,
  `lantai` int(10) NOT NULL,
  `id_ruang` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kd_pemeliharaan` (`kd_pemeliharaan`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pemeliharaan_extracomptable`
--

LOCK TABLES `pemeliharaan_extracomptable` WRITE;
/*!40000 ALTER TABLE `pemeliharaan_extracomptable` DISABLE KEYS */;
INSERT INTO `pemeliharaan_extracomptable` VALUES (1,'PE170913001','9316062ZJY','b','2017-09-13','2017-09-13','xyz',1,1,2,'2017-09-13 04:38:25','2017-09-13 04:38:25',NULL);
/*!40000 ALTER TABLE `pemeliharaan_extracomptable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `request_aktiva_tetap`
--

DROP TABLE IF EXISTS `request_aktiva_tetap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `request_aktiva_tetap` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kd_request` varchar(12) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `status` varchar(60) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `request_aktiva_tetap`
--

LOCK TABLES `request_aktiva_tetap` WRITE;
/*!40000 ALTER TABLE `request_aktiva_tetap` DISABLE KEYS */;
INSERT INTO `request_aktiva_tetap` VALUES (1,'RA170912001','Pluit','pending','2017-09-11 21:26:14','2017-09-12 04:26:14',NULL);
/*!40000 ALTER TABLE `request_aktiva_tetap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `request_extracomptable`
--

DROP TABLE IF EXISTS `request_extracomptable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `request_extracomptable` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kd_request` varchar(12) NOT NULL,
  `id_gedung` int(10) unsigned NOT NULL,
  `lantai` int(10) NOT NULL,
  `id_ruang` int(10) unsigned NOT NULL,
  `status` varchar(60) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `request_extracomptable`
--

LOCK TABLES `request_extracomptable` WRITE;
/*!40000 ALTER TABLE `request_extracomptable` DISABLE KEYS */;
INSERT INTO `request_extracomptable` VALUES (1,'RE170912001',2,1,3,'pending','2017-09-12 03:20:24','2017-09-12 03:20:24',NULL),(2,'RE170912002',1,1,2,'pending','2017-09-12 04:07:16','2017-09-12 04:07:16',NULL);
/*!40000 ALTER TABLE `request_extracomptable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `request_inventory`
--

DROP TABLE IF EXISTS `request_inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `request_inventory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kd_request` varchar(12) NOT NULL,
  `id_gedung` int(10) unsigned NOT NULL,
  `lantai` int(10) NOT NULL,
  `id_ruang` int(10) unsigned NOT NULL,
  `status` varchar(60) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `request_inventory`
--

LOCK TABLES `request_inventory` WRITE;
/*!40000 ALTER TABLE `request_inventory` DISABLE KEYS */;
INSERT INTO `request_inventory` VALUES (1,'RI170912001',1,1,2,'pending','2017-09-11 21:00:44','2017-09-12 04:00:44',NULL);
/*!40000 ALTER TABLE `request_inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ruang`
--

DROP TABLE IF EXISTS `ruang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ruang` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_gedung` int(10) unsigned NOT NULL,
  `lantai` int(10) NOT NULL,
  `kd_ruang` varchar(3) NOT NULL,
  `nama_ruang` varchar(120) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ruang`
--

LOCK TABLES `ruang` WRITE;
/*!40000 ALTER TABLE `ruang` DISABLE KEYS */;
INSERT INTO `ruang` VALUES (1,1,3,'01','P31','2017-09-10 19:55:10',NULL,NULL),(2,1,1,'02','P11','2017-09-10 19:55:24',NULL,NULL),(3,2,1,'03','M11','2017-09-10 19:55:54',NULL,NULL);
/*!40000 ALTER TABLE `ruang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subjenis_extracomptable`
--

DROP TABLE IF EXISTS `subjenis_extracomptable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subjenis_extracomptable` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_jenis` int(10) unsigned NOT NULL,
  `kd_subjenis` varchar(3) NOT NULL,
  `nama` varchar(120) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subjenis_extracomptable`
--

LOCK TABLES `subjenis_extracomptable` WRITE;
/*!40000 ALTER TABLE `subjenis_extracomptable` DISABLE KEYS */;
INSERT INTO `subjenis_extracomptable` VALUES (1,2,'01','Kursi Putar','abcdefg','2017-09-10 22:31:35',NULL,NULL),(2,2,'02','Kursi Lipat','qwerty','2017-09-10 22:31:51',NULL,NULL),(3,1,'01','Meja Karyawan','qwerty','2017-09-10 22:32:25',NULL,NULL),(4,1,'02','Meja Bulet','qwerty','2017-09-10 22:32:37',NULL,NULL);
/*!40000 ALTER TABLE `subjenis_extracomptable` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-09-16 18:25:31
