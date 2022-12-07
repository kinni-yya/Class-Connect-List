-- MySQL dump 10.13  Distrib 8.0.31, for Win64 (x86_64)
--
-- Host: localhost    Database: list
-- ------------------------------------------------------
-- Server version	8.0.31

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `archive_class`
--

DROP TABLE IF EXISTS `archive_class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `archive_class` (
  `archive_class_id` int NOT NULL AUTO_INCREMENT,
  `class_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`archive_class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `archive_class`
--

LOCK TABLES `archive_class` WRITE;
/*!40000 ALTER TABLE `archive_class` DISABLE KEYS */;
/*!40000 ALTER TABLE `archive_class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `archive_note`
--

DROP TABLE IF EXISTS `archive_note`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `archive_note` (
  `archive_note_id` int NOT NULL AUTO_INCREMENT,
  `note_id` int NOT NULL,
  `member_id` int NOT NULL,
  PRIMARY KEY (`archive_note_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `archive_note`
--

LOCK TABLES `archive_note` WRITE;
/*!40000 ALTER TABLE `archive_note` DISABLE KEYS */;
INSERT INTO `archive_note` VALUES (13,26,2);
/*!40000 ALTER TABLE `archive_note` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calendar`
--

DROP TABLE IF EXISTS `calendar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `calendar` (
  `event_id` int NOT NULL AUTO_INCREMENT,
  `event_title` varchar(500) NOT NULL,
  `event_details` varchar(5000) DEFAULT NULL,
  `event_from_date` datetime NOT NULL,
  `event_to_date` datetime NOT NULL,
  `event_type` int NOT NULL,
  `class_id` int NOT NULL,
  `subject_id` int DEFAULT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calendar`
--

LOCK TABLES `calendar` WRITE;
/*!40000 ALTER TABLE `calendar` DISABLE KEYS */;
/*!40000 ALTER TABLE `calendar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `class`
--

DROP TABLE IF EXISTS `class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `class` (
  `class_id` int NOT NULL AUTO_INCREMENT,
  `class_name` varchar(250) NOT NULL,
  `class_code` varchar(15) NOT NULL,
  `creator_id` int NOT NULL,
  `school_year` date NOT NULL,
  PRIMARY KEY (`class_id`),
  KEY `class_creator_idx` (`creator_id`),
  CONSTRAINT `class_creator` FOREIGN KEY (`creator_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class`
--

LOCK TABLES `class` WRITE;
/*!40000 ALTER TABLE `class` DISABLE KEYS */;
INSERT INTO `class` VALUES (1,'BSIT 4-2','abcdefhijk',2,'2020-01-01');
/*!40000 ALTER TABLE `class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `duplicate_note`
--

DROP TABLE IF EXISTS `duplicate_note`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `duplicate_note` (
  `duplicate_id` int NOT NULL AUTO_INCREMENT,
  `note_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`duplicate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `duplicate_note`
--

LOCK TABLES `duplicate_note` WRITE;
/*!40000 ALTER TABLE `duplicate_note` DISABLE KEYS */;
/*!40000 ALTER TABLE `duplicate_note` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enrollee`
--

DROP TABLE IF EXISTS `enrollee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `enrollee` (
  `enrollee_id` int NOT NULL AUTO_INCREMENT,
  `member_id` int NOT NULL,
  `subject_id` int DEFAULT NULL,
  PRIMARY KEY (`enrollee_id`),
  KEY `subject_members_idx` (`member_id`),
  KEY `class_subjects_idx` (`subject_id`),
  CONSTRAINT `enrolled_member` FOREIGN KEY (`member_id`) REFERENCES `member` (`member_id`),
  CONSTRAINT `enrolled_subject` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enrollee`
--

LOCK TABLES `enrollee` WRITE;
/*!40000 ALTER TABLE `enrollee` DISABLE KEYS */;
INSERT INTO `enrollee` VALUES (1,2,1),(2,2,2),(3,2,3),(4,2,4),(5,1,1),(6,1,2),(7,1,3),(8,1,4),(9,3,2),(10,3,3);
/*!40000 ALTER TABLE `enrollee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member`
--

DROP TABLE IF EXISTS `member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `member` (
  `member_id` int NOT NULL AUTO_INCREMENT,
  `member_type` int NOT NULL,
  `class_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`member_id`),
  KEY `class_members_idx` (`class_id`),
  KEY `class_members_idx1` (`user_id`),
  CONSTRAINT `class_members` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  CONSTRAINT `joined_class` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member`
--

LOCK TABLES `member` WRITE;
/*!40000 ALTER TABLE `member` DISABLE KEYS */;
INSERT INTO `member` VALUES (1,1,1,2),(2,0,1,1),(3,0,1,3);
/*!40000 ALTER TABLE `member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `note`
--

DROP TABLE IF EXISTS `note`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `note` (
  `note_id` int NOT NULL AUTO_INCREMENT,
  `class_id` int NOT NULL,
  `subject_id` int DEFAULT NULL,
  `post_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `due_time` time DEFAULT NULL,
  `note_title` varchar(500) NOT NULL,
  `description` varchar(5000) DEFAULT NULL,
  PRIMARY KEY (`note_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `note`
--

LOCK TABLES `note` WRITE;
/*!40000 ALTER TABLE `note` DISABLE KEYS */;
INSERT INTO `note` VALUES (23,1,NULL,'2022-11-14',NULL,NULL,'Orientation','Good morning! On behalf of President Brown and Provost Morrison, it is my great pleasure to welcome you all to Boston University. I’m delighted to see you here so early in the morning. A special welcome to those of you who are on campus for the first time. I hope you will discover over the next two days, what I have discovered in my six short years at BU: that you have entered a lively, challenging, diverse, and warm community.<br />\r\n<br />\r\nTo you parents here, I look forward to getting to know the exceptional young people you have raised, and to helping provide a rich array of opportunities for them to learn, to grow, to discover who they are, and how they want to make a difference in the world.'),(24,1,NULL,'2022-11-14','2022-11-18',NULL,'Funds','Collecting funds for all classmates'),(25,1,NULL,'2022-11-14','2022-11-15','08:00:00','Collecting of GWA','Hi Guys,<br />\r\n<br />\r\nPlease send over your GWA from the last semester so we can report to the dean.<br />\r\n<br />\r\nThank you!'),(26,1,1,'2022-11-14','2022-11-14',NULL,'Interview IT professional','Interview any IT professional that you know and ask regarding his hardships or issues in his or her work environment'),(27,1,NULL,'2022-11-14','2022-11-18',NULL,'Accept this correction','This is to see what happens when you correct a note'),(28,1,1,'2022-12-05','2022-12-15','06:00:00','Sample','This is a sample announcement with a deadline.');
/*!40000 ALTER TABLE `note` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `note_history`
--

DROP TABLE IF EXISTS `note_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `note_history` (
  `history_id` int NOT NULL AUTO_INCREMENT,
  `note_id` int NOT NULL,
  `pending_note_id` int NOT NULL,
  `prev_subject_id` int DEFAULT NULL,
  `prev_due_date` date DEFAULT NULL,
  `prev_due_time` time DEFAULT NULL,
  `prev_note_title` varchar(500) NOT NULL,
  `prev_description` varchar(5000) DEFAULT NULL,
  `change_date` datetime NOT NULL,
  PRIMARY KEY (`history_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `note_history`
--

LOCK TABLES `note_history` WRITE;
/*!40000 ALTER TABLE `note_history` DISABLE KEYS */;
INSERT INTO `note_history` VALUES (13,27,19,NULL,NULL,NULL,'Accept this approval','','2022-11-14 00:00:00');
/*!40000 ALTER TABLE `note_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pending_note`
--

DROP TABLE IF EXISTS `pending_note`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pending_note` (
  `pending_note_id` int NOT NULL AUTO_INCREMENT,
  `note_id` int DEFAULT NULL,
  `subject_id` int DEFAULT NULL,
  `post_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `due_time` time DEFAULT NULL,
  `note_title` varchar(500) NOT NULL,
  `description` varchar(5000) DEFAULT NULL,
  `pending_date` date NOT NULL,
  `status` int NOT NULL,
  `member_id` int NOT NULL,
  `class_id` int NOT NULL,
  PRIMARY KEY (`pending_note_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pending_note`
--

LOCK TABLES `pending_note` WRITE;
/*!40000 ALTER TABLE `pending_note` DISABLE KEYS */;
INSERT INTO `pending_note` VALUES (16,NULL,2,NULL,NULL,NULL,'Review Republic Act 1425 ','Review the contents of the Rizal Law','2022-11-14',0,3,1),(17,24,NULL,'2022-11-14','2022-11-18',NULL,'Funds','Collecting funds for all classmates, should only be 20 pessos.','2022-11-14',0,3,1),(18,27,NULL,NULL,NULL,NULL,'Accept this approval','','2022-11-14',2,3,1),(19,27,NULL,'2022-11-14','2022-11-18',NULL,'Accept this correction','This is to see what happens when you correct a note','2022-11-14',2,3,1),(20,27,NULL,'2022-11-14','2022-11-18',NULL,'Reject this correction','This is to see what happens when you correct a note','2022-11-14',1,2,1),(21,NULL,NULL,NULL,NULL,NULL,'Reject this note','','2022-11-14',1,2,1);
/*!40000 ALTER TABLE `pending_note` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subject`
--

DROP TABLE IF EXISTS `subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subject` (
  `subject_id` int NOT NULL AUTO_INCREMENT,
  `subject_name` varchar(150) NOT NULL,
  `subject_code` varchar(15) DEFAULT NULL,
  `subject_details` varchar(2000) DEFAULT NULL,
  `professor` varchar(200) DEFAULT NULL,
  `class_id` int NOT NULL,
  PRIMARY KEY (`subject_id`),
  KEY `class_subjects_idx` (`class_id`),
  CONSTRAINT `class_subjects` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subject`
--

LOCK TABLES `subject` WRITE;
/*!40000 ALTER TABLE `subject` DISABLE KEYS */;
INSERT INTO `subject` VALUES (1,'Social and Professional Issues in IT','1234567890','COMP 20333','MICLAT, SEGUNDINA',1),(2,'Buhay at Mga Sinulat ni Rizal','2134567890','GEED 10013','SEVILLA, MARIA ANGELIC',1),(3,'Science, Technology and Society','3124567890','GEED 10083','MASBATE, JULIUS MARK',1),(4,'Information Assurance and Security 2','4123567890','INTE 30073','AGOS JR., CELSO',1);
/*!40000 ALTER TABLE `subject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subject_schedule`
--

DROP TABLE IF EXISTS `subject_schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subject_schedule` (
  `subject_schedule_id` int NOT NULL AUTO_INCREMENT,
  `subject_id` int NOT NULL,
  `from_time` datetime NOT NULL,
  `to_time` datetime NOT NULL,
  `day` varchar(15) NOT NULL,
  PRIMARY KEY (`subject_schedule_id`),
  KEY `subject_schedules_idx` (`subject_id`),
  CONSTRAINT `subject_schedules` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subject_schedule`
--

LOCK TABLES `subject_schedule` WRITE;
/*!40000 ALTER TABLE `subject_schedule` DISABLE KEYS */;
/*!40000 ALTER TABLE `subject_schedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `password` varchar(128) NOT NULL,
  `contact_no` varchar(12) NOT NULL,
  `f_name` varchar(100) NOT NULL,
  `m_name` varchar(50) DEFAULT NULL,
  `l_name` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'jimlozada05@gmail.com','$2y$10$vXzifJG0dUKY/gzbxOy8fuuAvblEp3UOSCQ2SatP.SucXOfPjNYHa','09093256705','Jim',NULL,'Lozada'),(2,'brian@gmail.com','$2y$10$vXzifJG0dUKY/gzbxOy8fuuAvblEp3UOSCQ2SatP.SucXOfPjNYHa','09093256705','Brian','M','Albao'),(3,'kinni@gmail.com','$2y$10$vXzifJG0dUKY/gzbxOy8fuuAvblEp3UOSCQ2SatP.SucXOfPjNYHa','09093256705','Kinni Yya','A','Lopez');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_calendar`
--

DROP TABLE IF EXISTS `user_calendar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_calendar` (
  `event_id` int NOT NULL AUTO_INCREMENT,
  `event_title` varchar(500) NOT NULL,
  `event_details` varchar(5000) DEFAULT NULL,
  `event_from_date` datetime NOT NULL,
  `event_to_date` datetime NOT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_calendar`
--

LOCK TABLES `user_calendar` WRITE;
/*!40000 ALTER TABLE `user_calendar` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_calendar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_note`
--

DROP TABLE IF EXISTS `user_note`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_note` (
  `note_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `post_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `due_time` time DEFAULT NULL,
  `note_title` varchar(500) NOT NULL,
  `description` varchar(5000) DEFAULT NULL,
  PRIMARY KEY (`note_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_note`
--

LOCK TABLES `user_note` WRITE;
/*!40000 ALTER TABLE `user_note` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_note` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-12-07 12:38:06
