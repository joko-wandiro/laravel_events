-- MySQL dump 10.16  Distrib 10.1.21-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: localhost
-- ------------------------------------------------------
-- Server version	10.1.21-MariaDB

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
-- Table structure for table `event_tags`
--

DROP TABLE IF EXISTS `event_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_tags` (
  `event_id` bigint(20) unsigned NOT NULL,
  `tag_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`event_id`,`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_tags`
--

LOCK TABLES `event_tags` WRITE;
/*!40000 ALTER TABLE `event_tags` DISABLE KEYS */;
INSERT INTO `event_tags` VALUES (14,1),(15,3),(16,3),(17,1),(17,4),(18,3),(19,3),(20,3),(21,3),(22,3),(23,3);
/*!40000 ALTER TABLE `event_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_organizer` bigint(20) unsigned NOT NULL,
  `title` varchar(191) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `location` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title_UNIQUE` (`title`),
  KEY `FK_Products_Categories_idx` (`id_organizer`),
  CONSTRAINT `FK_Events_Organizers` FOREIGN KEY (`id_organizer`) REFERENCES `organizers` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (14,5,'Bromo Private Adventure','<p>Harga bawang bombay di pasar melesat dari Rp20 ribu-Rp30 ribu menjadi Rp180 ribu per kg. Salah satu pedagang di Pasar Mencos, Karet, Yani (40) bilang kenaikan harga bawang bombay disebabkan kelangkaan pasokan di pasar.</p>','1589649787P5hcZgjc.jpg','2020-03-14','2020-03-15','13:00:00','16:00:00','Ruko Darmo Galery Blok A3, No 75, Jl. Mayjen Sungkono, Gn. Sari, Dukuh Pakis, Kota SBY, Jawa Timur 60189, Indonesia','2020-03-11 08:50:47','2020-05-16 17:23:07'),(15,5,'World Of Wonders Themepark','<p>world of wonders theme park merupakan wahana permainan dan edukasi keluarga terlengkap dengan 35 wahana permainan segala usia. world of wonders memiliki bangunan 7 keajaiban dunia dan hanya satu - satunya theme park di ndonesia yang memiliki wahana edukasi yang sangat lengkap.</p>','1589649712KqJCxR9T.jpg','2018-12-22','2020-12-31','09:00:00','17:00:00','Kawasan Mardigras Cikupa Jalan Citraraya Boulevard','2020-03-12 06:51:05','2020-05-16 17:21:52'),(16,5,'JUNGLELAND','<p>Lagi nyari harga tiket Jungleland? Promo Jungleland terbaru? Hingga ada wahana apa saja di Jungleland?</p>\r\n<p>Temukan event page Jungleland di Loket.com. Terletak di Kawasan Sentul Nirwana, Sentul City - Bogor, Jungleland Adventure Theme Park memiliki luas area 35 ha dengan lebih dari 33 wahana dan atraksi seru.</p>','1589649815wy3sM5zg.jpg','2018-12-22','2021-01-31','10:00:00','18:00:00','Kawasan Sentul Nirwana, Jl. Jungle Land No.1, Karang Tengah, Babakan Madang, Bogor, Jawa Barat','2020-03-12 08:53:23','2020-05-16 17:23:35'),(17,5,'Travel Malang Juanda','<p>Kami berangkat setiap hari mulai pukul 01.00 wib</p>\r\n<p>Harga sudah termsuk</p>\r\n<p>1.Mobil+Driver</p>\r\n<p>2.Bensin</p>\r\n<p>3.Parkir</p>','1589649765FBDGod0D.jpg','2019-03-23','2021-10-31','16:00:00','19:00:00','Jl. Raya kepuharjo No.61, Kepuh Utara, Kepuharjo, Karangploso, Malang, Jawa Timur 65152, Indonesia','2020-03-12 08:56:24','2020-05-16 17:22:45'),(18,5,'Splash Water park','<p>Finns Recreation Club is Balis Premier Sports and Recreation Venue.Set on a 4 hectare estate amongst the rice fields of Canggu yet only 15 minutes from Seminyak.After a renovation and expansion program in 2014 facilities now include Splash Water Park Bounce Trampoline Centre Strike 10 Pin Bowling fully equipped Fitness Centre Tennis Centre with 3 flood light flexi pave courts Sports Field Cubby House Kids Club Body Temple Spa and Salon Bistro C Dining Sports Bar plus more.</p>','1589649632WqQQ0nn1.jpg','2019-04-01','2020-03-31','06:00:00','23:00:00','Jalan Pantai Berawa Canggu, Tibubeneng','2020-03-12 08:58:09','2020-05-16 17:20:32'),(19,5,'Finns Bali Day Pass','<p>Finns Recreation Club is Balis Premier Sports and Recreation Venue.Set on a 4 hectare estate amongst the rice fields of Canggu yet only 15 minutes from Seminyak.After a renovation and expansion program in 2014 facilities now include Splash Water Park Bounce Trampoline Centre Strike 10 Pin Bowling fully equipped Fitness Centre Tennis Centre with 3 flood light flexi pave courts Sports Field Cubby House Kids Club Body Temple Spa and Salon Bistro C Dining Sports Bar plus more.</p>','1589649820xLGFUEMB.jpg','2019-04-01','2020-03-31','06:00:00','23:00:00','Jalan Pantai Berawa Canggu','2020-03-12 09:00:06','2020-05-16 17:23:40'),(20,5,'Secret Garden Village','<p>Secret Garden Village is a complex of tourism destinations that combines education and vacation for its concept. Built on approximately 35.000 square meters of land this place is a good choice for those of you who seek beautiful green views. On top of that you can also bring your kids to join exciting and educational classes like cooking or soap making. Dont miss out on an incredible Eduvacation journey with Secret Garden Village!</p>','15896497165XIwk7EN.jpg','2019-04-01','2020-03-31','08:00:00','20:00:00','Jl. Raya Denpasar Bedugul km. 36','2020-03-12 09:01:42','2020-05-16 17:21:56'),(21,5,'Finns Bali Super Fun Pass','<p>Finns Recreation Club is Balis Premier Sports and Recreation Venue.Set on a 4 hectare estate amongst the rice fields of Canggu yet only 15 minutes from Seminyak.After a renovation and expansion program in 2014 facilities now include Splash Water Park Bounce Trampoline Centre Strike 10 Pin Bowling fully equipped Fitness Centre Tennis Centre with 3 flood light flexi pave courts Sports Field Cubby House Kids Club Body Temple Spa and Salon Bistro C Dining Sports Bar plus more.</p>','158964964913bW0ANK.jpg','2019-04-01','2020-03-31','09:00:00','23:00:00','JL Pantai Berawa Canggu, Tibubeneng','2020-03-12 09:02:59','2020-05-16 17:20:49'),(22,5,'I am Bali 3D Museum and Upside Down Zone','<p>Hadir dengan tema yang berbeda I AM BALI (Interactive Art Museum) yang terletak dilantai dasar Monumen Bajra Sandhi merupakan museum modern yang berisikan 102 lukisan-lukisan 3 Dimensi (3D) yang menjadi tren saat ini. Lukisan-lukisan bertemakan Interaktif, Kreatif, dan Edukatif tentang budaya Indonesia terutama bertemakan budaya Bali seperti mengarak Ogoh-Ogoh yang biasa masyarakat Bali laksanakan sehari sebelum Hari Raya Nyepi, lukisan tentang kehidupan sosial masyarakat di pedesaan Bali seperti metajen. Lukisan Candi Borobudur juga di hadirkan serta Komodo yang langka juga bisa ditemui.</p>','1589649604UejwbMlu.jpg','2020-01-01','2020-03-31','09:00:00','20:00:00','Bajra Sandhi Monument Ground Floor, Jl. Raya Puputan, Panjer','2020-03-12 09:05:02','2020-05-16 17:20:05'),(23,5,'Hugo City Food Centrum','<p>Role-Play Indoor Playground yang bertema profesi. Selain bermain anak-anak juga bisa belajar. Kami mengajarkan edukasi diluar pendidikan sekolah. Terdapat juga cooking class di tiap sesi.</p>','1589629352avPJaI9e.jpg','2019-04-04','2020-04-05','10:00:00','21:00:00','Ruko Puri Mutiara, Jl. Griya Utama Blok BA-BB-BC, RT.2/RW.5, Sunter Agung','2020-03-12 09:06:35','2020-05-16 11:42:32');
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `organizers`
--

DROP TABLE IF EXISTS `organizers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `organizers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `image` varchar(255) CHARACTER SET utf8 NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organizers`
--

LOCK TABLES `organizers` WRITE;
/*!40000 ALTER TABLE `organizers` DISABLE KEYS */;
INSERT INTO `organizers` VALUES (5,'Kursus IT','Komunitas IT di Indonesia','1583834130TfglJ3e4.jpg','2020-03-10 09:53:00','2020-03-10 09:55:30');
/*!40000 ALTER TABLE `organizers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `value` text CHARACTER SET utf8 NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'name','text','Event Indonesia','2019-12-26 07:37:11','2020-05-15 13:02:01'),(2,'logo','file','1589547721t2KH6Jwf.png','2019-12-26 07:37:11','2020-05-15 13:02:01'),(3,'address','textarea','Toko Utama\r\nJakarta','2019-12-26 07:37:11','2020-05-15 13:02:01'),(4,'phone','text','021100100','2019-12-26 07:37:11','2020-05-15 13:02:01'),(6,'image_size_small_width','text','200','2020-05-14 13:52:38','2020-05-15 13:02:01'),(7,'image_size_small_height','text','200','2020-05-14 13:52:38','2020-05-15 13:02:01'),(8,'image_size_medium_width','text','500','2020-05-14 13:52:38','2020-05-15 13:02:01'),(9,'image_size_medium_height','text','500','2020-05-14 13:52:38','2020-05-15 13:02:01');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES (1,'transportation','2019-12-23 04:15:59','2020-03-10 09:59:19'),(2,'workshop','2019-12-23 04:16:29','2020-03-10 09:59:08'),(3,'attraction','2020-03-12 06:47:14','2020-03-12 06:47:24'),(4,'accommodation','2020-03-12 08:54:10','2020-03-12 08:54:10');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrator','admin@demo.com','$2y$10$XsqXzDJHyqCRXNWvXzWa7.9EsKddUmiZd51aP.A9WoRfX8l5RekYW','2019-12-23 03:43:42','2019-12-23 03:44:02'),(2,'Yusuf','yusuf@demo.com','$2y$10$RYo1HJYGFBMfglWZg9emTOBOXU8laWIRUu1KI9O4/hdip7qGlhgr6','2020-05-15 12:44:21','2020-05-15 12:44:21');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-05-17  0:38:41
