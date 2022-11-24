-- MySQL dump 10.13  Distrib 8.0.24, for Linux (x86_64)
--
-- Host: localhost    Database: yitea
-- ------------------------------------------------------
-- Server version	8.0.24

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
-- Table structure for table `luck_activity`
--

DROP TABLE IF EXISTS `luck_activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_activity` (
  `ID` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `CateID` int NOT NULL DEFAULT '0' COMMENT '类别',
  `Title` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `Description` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '描述',
  `Pic` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '图片',
  `Picture` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '轮播图',
  `StartTime` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '开始时间',
  `EndTime` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '结束时间',
  `Content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '活动内容',
  `Hits` int NOT NULL DEFAULT '0' COMMENT '查看次数',
  `IsOriginal` tinyint(1) NOT NULL DEFAULT '1' COMMENT '原创',
  `SourceUrl` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '引用地址',
  `IsComment` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启评论',
  `Comments` int NOT NULL DEFAULT '0' COMMENT '评论数',
  `AuthorID` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '作者',
  `Sort` int NOT NULL DEFAULT '1' COMMENT '排序',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `CreateIP` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '创建IP',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  `CheckUser` bigint NOT NULL DEFAULT '0' COMMENT '审核者',
  `CheckTime` bigint NOT NULL DEFAULT '0' COMMENT '审核时间',
  `IsDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除',
  PRIMARY KEY (`ID`) USING BTREE,
  KEY `idx_activity_cate_id` (`CateID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='活动';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_activity`
--

LOCK TABLES `luck_activity` WRITE;
/*!40000 ALTER TABLE `luck_activity` DISABLE KEYS */;
INSERT INTO `luck_activity` VALUES (1,1,'拉新活动','拉新活动','https://img.huanrang.art/hr/78fd07b694140b103b9ed19dd3f6f2a7.jpg','https://img.huanrang.art/hr/78fd07b694140b103b9ed19dd3f6f2a7.jpg','2022-08-26 16:07:00','2022-09-01 00:00:00','拉新活动',0,0,'',0,0,'',1,1661501134,'43.224.44.142',1661501134,0,0,0);
/*!40000 ALTER TABLE `luck_activity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_activity_cate`
--

DROP TABLE IF EXISTS `luck_activity_cate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_activity_cate` (
  `ID` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Title` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '类别名称',
  `Pic` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '图片',
  `Level` int NOT NULL DEFAULT '1' COMMENT '级别',
  `PID` int NOT NULL DEFAULT '0' COMMENT '父级',
  `Number` int NOT NULL DEFAULT '0' COMMENT '子数目',
  `Sort` int NOT NULL DEFAULT '1' COMMENT '排序',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `CreateIP` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '创建IP',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  `IsDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除',
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='活动类别';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_activity_cate`
--

LOCK TABLES `luck_activity_cate` WRITE;
/*!40000 ALTER TABLE `luck_activity_cate` DISABLE KEYS */;
INSERT INTO `luck_activity_cate` VALUES (1,'拉新','',1,0,0,1,1661083954,'180.117.175.108',1661083954,0),(2,'投票','',1,0,0,1,1661707097,'180.117.175.108',1661707097,0);
/*!40000 ALTER TABLE `luck_activity_cate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_article`
--

DROP TABLE IF EXISTS `luck_article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_article` (
  `ID` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `CateID` int NOT NULL DEFAULT '0' COMMENT '类别',
  `Title` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `Description` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '描述',
  `Pic` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '图片',
  `Content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '文章内容',
  `Hits` int NOT NULL DEFAULT '0' COMMENT '查看次数',
  `IsOriginal` tinyint(1) NOT NULL DEFAULT '1' COMMENT '原创',
  `SourceUrl` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '引用地址',
  `IsComment` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启评论',
  `Comments` int NOT NULL DEFAULT '0' COMMENT '评论数',
  `AuthorID` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '作者',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `CreateIP` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '创建IP',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  `CheckUser` bigint NOT NULL DEFAULT '0' COMMENT '审核者',
  `CheckTime` bigint NOT NULL DEFAULT '0' COMMENT '审核时间',
  `IsDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除',
  PRIMARY KEY (`ID`) USING BTREE,
  KEY `idx_article_cate_id` (`CateID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='文章';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_article`
--

LOCK TABLES `luck_article` WRITE;
/*!40000 ALTER TABLE `luck_article` DISABLE KEYS */;
INSERT INTO `luck_article` VALUES (1,1,'asdfasdf','','','',0,0,'',0,0,'83176150',1661084324,'180.117.175.108',1661084324,0,0,0);
/*!40000 ALTER TABLE `luck_article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_article_cate`
--

DROP TABLE IF EXISTS `luck_article_cate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_article_cate` (
  `ID` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Title` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '类别名称',
  `Pic` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '图片',
  `Level` int NOT NULL DEFAULT '1' COMMENT '级别',
  `PID` int NOT NULL DEFAULT '0' COMMENT '父级',
  `Number` int NOT NULL DEFAULT '0' COMMENT '子数目',
  `Sort` int NOT NULL DEFAULT '1' COMMENT '排序',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `CreateIP` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '创建IP',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  `IsDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除',
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='文章类别';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_article_cate`
--

LOCK TABLES `luck_article_cate` WRITE;
/*!40000 ALTER TABLE `luck_article_cate` DISABLE KEYS */;
INSERT INTO `luck_article_cate` VALUES (1,'asdf','',1,0,0,1,1661084193,'180.117.175.108',1661084193,0);
/*!40000 ALTER TABLE `luck_article_cate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_bank`
--

DROP TABLE IF EXISTS `luck_bank`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_bank` (
  `ID` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Title` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `FullName` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '全称',
  `BankEnName` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '英文名称',
  `BankCode` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '银行编码',
  `Website` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '官网',
  `Hotline` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '客服电话',
  `Number` int NOT NULL DEFAULT '0' COMMENT '子数目',
  `Sort` int NOT NULL DEFAULT '1' COMMENT '排序',
  `Level` int NOT NULL DEFAULT '1' COMMENT '级别',
  `PID` int NOT NULL DEFAULT '0' COMMENT '父级',
  `IsPopular` tinyint(1) NOT NULL DEFAULT '0' COMMENT '常用',
  `IsValid` tinyint(1) NOT NULL DEFAULT '1' COMMENT '有效',
  KEY `ID` (`ID`,`Title`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='银行';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_bank`
--

LOCK TABLES `luck_bank` WRITE;
/*!40000 ALTER TABLE `luck_bank` DISABLE KEYS */;
INSERT INTO `luck_bank` VALUES (1,'中国银行','中国银行股份有限公司','BANK OF CHINA','','https://www.bank-of-china.com/','95566',0,1,1,0,0,1),(2,'中国工商银行','中国工商银行股份有限公司','ICBC','','http://www.icbc.com.cn/icbc/','95588',0,1,1,0,0,1),(3,'中国建设银行','中国建设银行股份有限公司','China Construction Bank','','http://www.ccb.com','95533',0,1,1,0,0,1),(4,'中国农业银行','中国农业银行股份有限公司','AGRICULTURAL BANK OF CHINA','','https://www.abchina.com/cn/','95599',0,1,1,0,0,1),(5,'交通银行','交通银行股份有限公司','BANK OF COMMUNICATIONS','','http://www.bankcomm.com/','95559',0,1,1,0,0,1),(6,'招商银行','招商银行股份有限公司','China Merchants Bank','','https://www.cmbchina.com/','95555',0,1,1,0,1,1),(7,'中国邮政储蓄银行','国邮政储蓄银行股份有限公司','POSTAL SAVINGS BANK OF CHINA','','https://www.psbc.com/cn/','95580',0,1,1,0,0,1),(8,'中信银行','中信银行股份有限公司','CHINA CITIC BANK','','https://www.citicbank.com/','95558',0,1,1,0,0,1),(9,'中国民生银行','中国民生银行股份有限公司','CMBC','','http://www.cmbc.com.cn/','95568',0,1,1,0,0,1),(10,'上海浦东发展银行','上海浦东发展银行股份有限公司','Shanghai Pudong Development Bank','','https://www.spdb.com.cn/','95528',0,1,1,0,0,1),(11,'兴业银行','兴业银行股份有限公司','INDUSTRIAL BANK CO.,LTD','','https://www.cib.com.cn/cn/index.html','95561',0,1,1,0,0,1),(12,'中国光大银行','中国光大银行股份有限公司','CHINA EVERBRIGHT BANK CO','','https://www.cebbank.com/','95595',0,1,1,0,0,1),(13,'平安银行','平安银行股份有限公司','Ping An Bank Co','','https://bank.pingan.com/','95511',0,1,1,0,0,1),(14,'华夏银行','华夏银行股份有限公司','Hua Xia Bank Co','','https://www.hxb.com.cn/index.shtml','95577',0,1,1,0,0,1),(15,'北京银行','北京银行股份有限公司','Bank of Beijing Co','','http://www.bankofbeijing.com.cn/','95526',0,1,1,0,0,1),(16,'上海银行','上海银行股份有限公司','Bank of Shanghai','','https://www.bosc.cn/zh/','95594',0,1,1,0,0,1),(17,'广发银行','广发银行股份有限公司','China Guangfa Bank','','http://www.cgbchina.com.cn/','400-830-8003',0,1,1,0,0,1),(18,'江苏银行','江苏银行股份有限公司','BANK OF JIANGSU','','http://www.jsbchina.cn/','95319',0,1,1,0,0,1),(19,'浙商银行','浙商银行股份有限公司','CHINA ZHESHANG BANK CO','','http://www.czbank.com/cn/index.shtml','95527',0,1,1,0,0,1),(20,'恒丰银行','恒丰银行股份有限公司','Evergrowing Bank Co','','https://www.hfbank.com.cn/','95395',0,1,1,0,0,1),(21,'重庆农村商业银行','重庆农村商业银行股份有限公司','CHONGQING RURAL COMMERCIAL BANK','','https://www.cqrcb.com/','95389',0,1,1,0,0,1),(22,'南京银行','南京银行是股份制商业银行','Bank of Nanjing','','https://www.njcb.com.cn/','95302',0,1,1,0,0,1),(23,'徽商银行','徽商银行股份有限公司','HUISHANG BANK','','http://www.hsbank.com.cn/','40088-96588',0,1,1,0,0,1),(24,'盛京银行','盛京银行股份有限公司','Shengjing Bank','','http://www.shengjingbank.com.cn/','95337',0,1,1,0,0,1),(25,'宁波银行','宁波银行股份有限公司','BENK OF NINBO','','http://www.nbcb.com.cn/','95574',0,1,1,0,0,1),(26,'上海农商银行','上海农村商业银行','Shanghai Rural Commercial Bank','','http://www.srcb.com/html/index.html','021-962999',0,1,1,0,0,1),(27,'天津银行','天津银行股份有限公司','Bank of Tianjin','','http://www.bank-of-tianjin.com.cn/','956056',0,1,1,0,0,1),(28,'渤海银行','渤海银行股份有限公司','China Bohai Bank Co','','http://www.cbhb.com.cn/','95541',0,1,1,0,0,1),(29,'锦州银行','锦州银行股份有限公司','BANK OF JINZHOU','','https://www.jinzhoubank.com/','96178',0,1,1,0,0,1),(30,'北京农商银行','北京农村商业银行股份有限公司','BEIJING RURAL COMMERCIAL BANK','','https://www.bjrcb.com/','96198',0,1,1,0,0,1),(31,'厦门国际银行','厦门国际银行股份有限公司','Xiamen International Bank Co','','https://www.xib.com.cn/','400-1623-623',0,1,1,0,0,1),(32,'杭州银行','杭州银行股份有限公司','Bank of Hangzhou','','http://www.hzbank.com.cn/','400-888-8508',0,1,1,0,0,1),(33,'哈尔滨银行','哈尔滨市商业银行','HARBIN BANK','','https://www.hrbb.com.cn/','95537',0,1,1,0,0,1),(34,'广州农商银行','广州农村商业银行','GRCB','','https://www.grcbank.com/','95313',0,1,1,0,0,1),(35,'中原银行','中原银行股份有限公司','ZHONGYUAN BANK CO.LTD','','http://www.zybank.com.cn/','95186',0,1,1,0,0,1),(36,'成都农商银行','成都市农村信用合作联社股份有限公司','Chengdu Rural Commercial Bank','','https://www.cdrcb.com/index/','95392',0,1,1,0,0,1),(37,'包商银行','包商银行股份有限公司','Baoshang Bank Limited','','http://www.bsb.com.cn/','95352',0,1,1,0,0,1),(38,'昆仑银行','昆仑银行股份有限公司','Bank of Kunlun（klb）','','http://www.klb.cn/','95379',0,1,1,0,0,1),(39,'重庆银行','重庆银行股份有限公司','Bank of Chongqing','','http://www.cqcbank.com/','956023',0,1,1,0,0,1),(40,'顺德农商银行','广东顺德农村商业银行股份有限公司','SDEBANK','','http://www.sdebank.com/','0757-22223388',0,1,1,0,0,1),(41,'大连银行','大连银行股份有限公司','Bank Of Dalian','','http://www.bankofdl.com/home/pc/index.shtml','4006640099',0,1,1,0,0,1),(42,'东莞农商银行','东莞农村商业银行','DRC Bank','','https://www.drcbank.com/','(0769) 961122',0,1,1,0,0,1),(43,'成都银行','成都银行股份有限公司','Bank of Chengdu','','https://www.bocd.com.cn/','95507',0,1,1,0,0,1),(44,'贵阳银行','贵阳银行股份有限公司','BANK OF GUIYANG','','https://www.bankgy.cn/portal/zh_CN/home/index.html','40011-96033',0,1,1,0,0,1),(45,'广州银行','广州银行股份有限公司','Bank of Guangzhou','','http://www.gzcb.com.cn/','96699',0,1,1,0,0,1),(46,'天津农商银行',' 天津农村商业银行','Tianjin Rural Commercial Bank','','http://www.trcbank.com.cn/','022-96155',0,1,1,0,0,1),(47,'郑州银行','郑州银行股份有限公司','Bank of Zhengzhou','','http://www.zzbank.cn/','95097',0,1,1,0,0,1),(48,'吉林银行','吉林银行股份有限公司','BANK OF JILIN','','http://www.jlbank.com.cn/','400-88-96666',0,1,1,0,0,1),(49,'深圳农村商业银行','深圳农村商业银行股份有限公司','SZRCB','','http://www.4001961200.com/','961200',0,1,1,0,0,1),(50,'江西银行','江西银行股份有限公司','JIANGXI BANK','','http://www.jx-bank.com/nccbank/zh_CN/home/index.html','956055',0,1,1,0,0,1),(51,'苏州银行','苏州银行股份有限公司','BENKE OF SUZHOU','','http://www.suzhoubank.com/','96067',0,1,1,0,0,1),(52,'长沙银行','长沙银行股份有限公司','BANK OF CHANGSHA','','http://www.cscb.cn/','073196511',0,1,1,0,0,1),(53,'河北银行','河北银行股份有限公司','BANK OF HEBEI CO., LTD','','http://www.hebbank.com/','4006129999',0,1,1,0,0,1),(54,'青岛银行','青岛银行股份有限公司','BANK OF QINGDAO(BQD)','','http://www.qdccb.com/','96588',0,1,1,0,0,1),(55,'汉口银行','汉口银行股份有限公司','Hankou Bank','','http://www.hkbchina.com/portal/zh_CN/home/index.html','96558',0,1,1,0,0,1),(56,'武汉农村商业银行','武汉农村商业银行股份有限公司','Wuhan Rural Commercial Bank','','http://www.whrcbank.com/','95367',0,1,1,0,0,1),(57,'东莞银行','东莞银行股份有限公司','Bank of DongGuan Co.,Ltd','','http://www.dongguanbank.cn/','956033',0,1,1,0,0,1),(58,'贵州银行','贵州银行股份有限公司','Bank of GuiZhou','','https://www.bgzchina.com/','96655',0,1,1,0,0,1),(59,'兰州银行','兰州银行股份有限公司','BENK OF LANZHOU','','https://www.lzbank.com/','96799',0,1,1,0,0,1),(60,'西安银行','西安银行股份有限公司','Bank of Xi\'an','','https://www.xacbank.com/','96779',0,1,1,0,0,1),(61,'asdf','','','','','',1,2,1,0,0,1),(62,'asdf','','','','','',0,1,2,61,0,1);
/*!40000 ALTER TABLE `luck_bank` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_brand`
--

DROP TABLE IF EXISTS `luck_brand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_brand` (
  `ID` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `BrandName` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '品牌名称',
  `Logo` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Logo',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  `DeleteTime` int NOT NULL DEFAULT '0' COMMENT '删除时间',
  `IsDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除',
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='品牌';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_brand`
--

LOCK TABLES `luck_brand` WRITE;
/*!40000 ALTER TABLE `luck_brand` DISABLE KEYS */;
INSERT INTO `luck_brand` VALUES (1,'无','',1657467284,1657467284,0,0),(2,'pp','',1658730847,1658730847,0,0),(3,'asdf','https://img.huanrang.art/hr/842dd8c5a9c355b8fe5cdb02965d6a0d.png',1666837998,1666837998,1666839030,1);
/*!40000 ALTER TABLE `luck_brand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_carousel`
--

DROP TABLE IF EXISTS `luck_carousel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_carousel` (
  `ID` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Title` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `Pic` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '图片',
  `Level` tinyint(1) NOT NULL DEFAULT '1' COMMENT '层级',
  `PID` int NOT NULL DEFAULT '0' COMMENT '父级',
  `Width` int NOT NULL DEFAULT '0' COMMENT '宽度',
  `Height` int NOT NULL DEFAULT '0' COMMENT '高度',
  `Radius` int NOT NULL DEFAULT '0' COMMENT '圆角',
  `Spacing` int NOT NULL DEFAULT '0' COMMENT '外间距',
  `Padding` int NOT NULL DEFAULT '0' COMMENT '内间距',
  `Number` int NOT NULL DEFAULT '0' COMMENT '图片',
  `LinkUrl` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '链接',
  `OpenType` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '打开方式',
  `Sort` int NOT NULL DEFAULT '1' COMMENT '排序',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  `DeleteTime` int NOT NULL DEFAULT '0' COMMENT '删除时间',
  `IsDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除',
  PRIMARY KEY (`ID`) USING BTREE,
  KEY `idx_carousel_level` (`Level`) USING BTREE,
  KEY `idx_carousel_pid` (`PID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='轮播图';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_carousel`
--

LOCK TABLES `luck_carousel` WRITE;
/*!40000 ALTER TABLE `luck_carousel` DISABLE KEYS */;
INSERT INTO `luck_carousel` VALUES (1,'拉新','https://img.huanrang.art/hr/e9eb03b5fc1a9f12b6f1b8932a1c2aca.jpeg',1,0,0,0,0,0,0,0,'/pages/news/detail?id=1','navigate',1,1661491705,1661491705,0,0),(2,'幻DAO','https://img.huanrang.art/hr/1b3b3f915b9577449fa78dfc682dbd09.jpeg',1,0,0,0,0,0,0,0,'/pages/news/detail?id=2','navigate',1,1661499615,1661499615,0,0);
/*!40000 ALTER TABLE `luck_carousel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_charset`
--

DROP TABLE IF EXISTS `luck_charset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_charset` (
  `ID` bigint NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `IsDefault` tinyint(1) NOT NULL DEFAULT '0' COMMENT '默认',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  `IsDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除',
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='字符编码';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_charset`
--

LOCK TABLES `luck_charset` WRITE;
/*!40000 ALTER TABLE `luck_charset` DISABLE KEYS */;
INSERT INTO `luck_charset` VALUES (1,'asdf',0,1657982768,1657982768,0);
/*!40000 ALTER TABLE `luck_charset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_city`
--

DROP TABLE IF EXISTS `luck_city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_city` (
  `ID` bigint NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Code` int NOT NULL DEFAULT '0' COMMENT '编码',
  `Title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '简称',
  `Level` tinyint(1) NOT NULL DEFAULT '1' COMMENT '级别',
  `PID` bigint NOT NULL DEFAULT '0' COMMENT '父级',
  `TelCode` int NOT NULL DEFAULT '0' COMMENT '区号',
  `ZipCode` int NOT NULL DEFAULT '0' COMMENT '邮政编码',
  `Spell` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '拼英',
  `EnName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '英文名',
  `ShortEnName` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '英文简写',
  `Longitude` double NOT NULL DEFAULT '0' COMMENT '经度',
  `Latitude` double NOT NULL DEFAULT '0' COMMENT '纬度',
  `Number` int NOT NULL DEFAULT '0' COMMENT '子数目',
  `Sort` int NOT NULL DEFAULT '1' COMMENT '排序',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  `IsDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除',
  PRIMARY KEY (`ID`) USING BTREE,
  KEY `idx_city_pid` (`PID`) USING BTREE,
  KEY `idx_city_level` (`Level`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=460400500001 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='城市';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_city`
--

LOCK TABLES `luck_city` WRITE;
/*!40000 ALTER TABLE `luck_city` DISABLE KEYS */;
INSERT INTO `luck_city` VALUES (11,11,'北京市',1,0,0,0,'','','',0,0,1,1,0,0,0),(12,12,'天津市',1,0,0,0,'','','',0,0,1,2,0,0,0),(13,13,'河北省',1,0,0,0,'','','',0,0,11,3,0,0,0),(14,14,'山西省',1,0,0,0,'','','',0,0,11,4,0,0,0),(15,15,'内蒙古自治区',1,0,0,0,'','','',0,0,12,5,0,0,0),(21,21,'辽宁省',1,0,0,0,'','','',0,0,14,6,0,0,0),(22,22,'吉林省',1,0,0,0,'','','',0,0,9,7,0,0,0),(23,23,'黑龙江省',1,0,0,0,'','','',0,0,13,8,0,0,0),(31,31,'上海市',1,0,0,0,'','','',0,0,1,9,0,0,0),(32,32,'江苏省',1,0,0,0,'','','',0,0,13,10,0,0,0),(33,33,'浙江省',1,0,0,0,'','','',0,0,11,11,0,0,0),(34,34,'安徽省',1,0,0,0,'','','',0,0,16,12,0,0,0),(35,35,'福建省',1,0,0,0,'','','',0,0,9,13,0,0,0),(36,36,'江西省',1,0,0,0,'','','',0,0,11,14,0,0,0),(37,37,'山东省',1,0,0,0,'','','',0,0,16,15,0,0,0),(41,41,'河南省',1,0,0,0,'','','',0,0,18,16,0,0,0),(42,42,'湖北省',1,0,0,0,'','','',0,0,14,17,0,0,0),(43,43,'湖南省',1,0,0,0,'','','',0,0,14,18,0,0,0),(44,44,'广东省',1,0,0,0,'','','',0,0,21,19,0,0,0),(45,45,'广西壮族自治区',1,0,0,0,'','','',0,0,14,20,0,0,0),(46,46,'海南省',1,0,0,0,'','','',0,0,5,21,0,0,0),(50,50,'重庆市',1,0,0,0,'','','',0,0,2,22,0,0,0),(51,51,'四川省',1,0,0,0,'','','',0,0,21,23,0,0,0),(52,52,'贵州省',1,0,0,0,'','','',0,0,9,24,0,0,0),(53,53,'云南省',1,0,0,0,'','','',0,0,16,25,0,0,0),(54,54,'西藏自治区',1,0,0,0,'','','',0,0,7,26,0,0,0),(61,61,'陕西省',1,0,0,0,'','','',0,0,10,27,0,0,0),(62,62,'甘肃省',1,0,0,0,'','','',0,0,14,28,0,0,0),(63,63,'青海省',1,0,0,0,'','','',0,0,8,29,0,0,0),(64,64,'宁夏回族自治区',1,0,0,0,'','','',0,0,5,30,0,0,0),(65,65,'新疆维吾尔自治区',1,0,0,0,'','','',0,0,15,31,0,0,0),(71,71,'台湾',1,0,0,0,'','','',0,0,0,32,0,0,0),(81,81,'香港',1,0,0,0,'','','',0,0,0,33,0,0,0),(82,82,'澳门',1,0,0,0,'','','',0,0,0,34,0,0,0),(110100,0,'市辖区',2,11,0,0,'','','',0,0,16,1,0,0,0),(110101,0,'东城区',3,110100,0,0,'','','',0,0,0,1,0,0,0),(110102,0,'西城区',3,110100,0,0,'','','',0,0,0,2,0,0,0),(110105,0,'朝阳区',3,110100,0,0,'','','',0,0,0,3,0,0,0),(110106,0,'丰台区',3,110100,0,0,'','','',0,0,0,4,0,0,0),(110107,0,'石景山区',3,110100,0,0,'','','',0,0,0,5,0,0,0),(110108,0,'海淀区',3,110100,0,0,'','','',0,0,0,6,0,0,0),(110109,0,'门头沟区',3,110100,0,0,'','','',0,0,0,7,0,0,0),(110111,0,'房山区',3,110100,0,0,'','','',0,0,0,8,0,0,0),(110112,0,'通州区',3,110100,0,0,'','','',0,0,0,9,0,0,0),(110113,0,'顺义区',3,110100,0,0,'','','',0,0,0,10,0,0,0),(110114,0,'昌平区',3,110100,0,0,'','','',0,0,0,11,0,0,0),(110115,0,'大兴区',3,110100,0,0,'','','',0,0,0,12,0,0,0),(110116,0,'怀柔区',3,110100,0,0,'','','',0,0,0,13,0,0,0),(110117,0,'平谷区',3,110100,0,0,'','','',0,0,0,14,0,0,0),(110118,0,'密云区',3,110100,0,0,'','','',0,0,0,15,0,0,0),(110119,0,'延庆区',3,110100,0,0,'','','',0,0,0,16,0,0,0),(120100,0,'市辖区',2,12,0,0,'','','',0,0,16,1,0,0,0),(120101,0,'和平区',3,120100,0,0,'','','',0,0,0,1,0,0,0),(120102,0,'河东区',3,120100,0,0,'','','',0,0,0,2,0,0,0),(120103,0,'河西区',3,120100,0,0,'','','',0,0,0,3,0,0,0),(120104,0,'南开区',3,120100,0,0,'','','',0,0,0,4,0,0,0),(120105,0,'河北区',3,120100,0,0,'','','',0,0,0,5,0,0,0),(120106,0,'红桥区',3,120100,0,0,'','','',0,0,0,6,0,0,0),(120110,0,'东丽区',3,120100,0,0,'','','',0,0,0,7,0,0,0),(120111,0,'西青区',3,120100,0,0,'','','',0,0,0,8,0,0,0),(120112,0,'津南区',3,120100,0,0,'','','',0,0,0,9,0,0,0),(120113,0,'北辰区',3,120100,0,0,'','','',0,0,0,10,0,0,0),(120114,0,'武清区',3,120100,0,0,'','','',0,0,0,11,0,0,0),(120115,0,'宝坻区',3,120100,0,0,'','','',0,0,0,12,0,0,0),(120116,0,'滨海新区',3,120100,0,0,'','','',0,0,0,13,0,0,0),(120117,0,'宁河区',3,120100,0,0,'','','',0,0,0,14,0,0,0),(120118,0,'静海区',3,120100,0,0,'','','',0,0,0,15,0,0,0),(120119,0,'蓟州区',3,120100,0,0,'','','',0,0,0,16,0,0,0),(130100,0,'石家庄市',2,13,0,0,'','','',0,0,25,1,0,0,0),(130101,0,'市辖区',3,130100,0,0,'','','',0,0,0,1,0,0,0),(130102,0,'长安区',3,130100,0,0,'','','',0,0,0,2,0,0,0),(130104,0,'桥西区',3,130100,0,0,'','','',0,0,0,3,0,0,0),(130105,0,'新华区',3,130100,0,0,'','','',0,0,0,4,0,0,0),(130107,0,'井陉矿区',3,130100,0,0,'','','',0,0,0,5,0,0,0),(130108,0,'裕华区',3,130100,0,0,'','','',0,0,0,6,0,0,0),(130109,0,'藁城区',3,130100,0,0,'','','',0,0,0,7,0,0,0),(130110,0,'鹿泉区',3,130100,0,0,'','','',0,0,0,8,0,0,0),(130111,0,'栾城区',3,130100,0,0,'','','',0,0,0,9,0,0,0),(130121,0,'井陉县',3,130100,0,0,'','','',0,0,0,10,0,0,0),(130123,0,'正定县',3,130100,0,0,'','','',0,0,0,11,0,0,0),(130125,0,'行唐县',3,130100,0,0,'','','',0,0,0,12,0,0,0),(130126,0,'灵寿县',3,130100,0,0,'','','',0,0,0,13,0,0,0),(130127,0,'高邑县',3,130100,0,0,'','','',0,0,0,14,0,0,0),(130128,0,'深泽县',3,130100,0,0,'','','',0,0,0,15,0,0,0),(130129,0,'赞皇县',3,130100,0,0,'','','',0,0,0,16,0,0,0),(130130,0,'无极县',3,130100,0,0,'','','',0,0,0,17,0,0,0),(130131,0,'平山县',3,130100,0,0,'','','',0,0,0,18,0,0,0),(130132,0,'元氏县',3,130100,0,0,'','','',0,0,0,19,0,0,0),(130133,0,'赵县',3,130100,0,0,'','','',0,0,0,20,0,0,0),(130171,0,'石家庄高新技术产业开发区',3,130100,0,0,'','','',0,0,0,21,0,0,0),(130172,0,'石家庄循环化工园区',3,130100,0,0,'','','',0,0,0,22,0,0,0),(130181,0,'辛集市',3,130100,0,0,'','','',0,0,0,23,0,0,0),(130183,0,'晋州市',3,130100,0,0,'','','',0,0,0,24,0,0,0),(130184,0,'新乐市',3,130100,0,0,'','','',0,0,0,25,0,0,0),(130200,0,'唐山市',2,13,0,0,'','','',0,0,19,2,0,0,0),(130201,0,'市辖区',3,130200,0,0,'','','',0,0,0,1,0,0,0),(130202,0,'路南区',3,130200,0,0,'','','',0,0,0,2,0,0,0),(130203,0,'路北区',3,130200,0,0,'','','',0,0,0,3,0,0,0),(130204,0,'古冶区',3,130200,0,0,'','','',0,0,0,4,0,0,0),(130205,0,'开平区',3,130200,0,0,'','','',0,0,0,5,0,0,0),(130207,0,'丰南区',3,130200,0,0,'','','',0,0,0,6,0,0,0),(130208,0,'丰润区',3,130200,0,0,'','','',0,0,0,7,0,0,0),(130209,0,'曹妃甸区',3,130200,0,0,'','','',0,0,0,8,0,0,0),(130224,0,'滦南县',3,130200,0,0,'','','',0,0,0,9,0,0,0),(130225,0,'乐亭县',3,130200,0,0,'','','',0,0,0,10,0,0,0),(130227,0,'迁西县',3,130200,0,0,'','','',0,0,0,11,0,0,0),(130229,0,'玉田县',3,130200,0,0,'','','',0,0,0,12,0,0,0),(130271,0,'河北唐山芦台经济开发区',3,130200,0,0,'','','',0,0,0,13,0,0,0),(130272,0,'唐山市汉沽管理区',3,130200,0,0,'','','',0,0,0,14,0,0,0),(130273,0,'唐山高新技术产业开发区',3,130200,0,0,'','','',0,0,0,15,0,0,0),(130274,0,'河北唐山海港经济开发区',3,130200,0,0,'','','',0,0,0,16,0,0,0),(130281,0,'遵化市',3,130200,0,0,'','','',0,0,0,17,0,0,0),(130283,0,'迁安市',3,130200,0,0,'','','',0,0,0,18,0,0,0),(130284,0,'滦州市',3,130200,0,0,'','','',0,0,0,19,0,0,0),(130300,0,'秦皇岛市',2,13,0,0,'','','',0,0,10,3,0,0,0),(130301,0,'市辖区',3,130300,0,0,'','','',0,0,0,1,0,0,0),(130302,0,'海港区',3,130300,0,0,'','','',0,0,0,2,0,0,0),(130303,0,'山海关区',3,130300,0,0,'','','',0,0,0,3,0,0,0),(130304,0,'北戴河区',3,130300,0,0,'','','',0,0,0,4,0,0,0),(130306,0,'抚宁区',3,130300,0,0,'','','',0,0,0,5,0,0,0),(130321,0,'青龙满族自治县',3,130300,0,0,'','','',0,0,0,6,0,0,0),(130322,0,'昌黎县',3,130300,0,0,'','','',0,0,0,7,0,0,0),(130324,0,'卢龙县',3,130300,0,0,'','','',0,0,0,8,0,0,0),(130371,0,'秦皇岛市经济技术开发区',3,130300,0,0,'','','',0,0,0,9,0,0,0),(130372,0,'北戴河新区',3,130300,0,0,'','','',0,0,0,10,0,0,0),(130400,0,'邯郸市',2,13,0,0,'','','',0,0,21,4,0,0,0),(130401,0,'市辖区',3,130400,0,0,'','','',0,0,0,1,0,0,0),(130402,0,'邯山区',3,130400,0,0,'','','',0,0,0,2,0,0,0),(130403,0,'丛台区',3,130400,0,0,'','','',0,0,0,3,0,0,0),(130404,0,'复兴区',3,130400,0,0,'','','',0,0,0,4,0,0,0),(130406,0,'峰峰矿区',3,130400,0,0,'','','',0,0,0,5,0,0,0),(130407,0,'肥乡区',3,130400,0,0,'','','',0,0,0,6,0,0,0),(130408,0,'永年区',3,130400,0,0,'','','',0,0,0,7,0,0,0),(130423,0,'临漳县',3,130400,0,0,'','','',0,0,0,8,0,0,0),(130424,0,'成安县',3,130400,0,0,'','','',0,0,0,9,0,0,0),(130425,0,'大名县',3,130400,0,0,'','','',0,0,0,10,0,0,0),(130426,0,'涉县',3,130400,0,0,'','','',0,0,0,11,0,0,0),(130427,0,'磁县',3,130400,0,0,'','','',0,0,0,12,0,0,0),(130430,0,'邱县',3,130400,0,0,'','','',0,0,0,13,0,0,0),(130431,0,'鸡泽县',3,130400,0,0,'','','',0,0,0,14,0,0,0),(130432,0,'广平县',3,130400,0,0,'','','',0,0,0,15,0,0,0),(130433,0,'馆陶县',3,130400,0,0,'','','',0,0,0,16,0,0,0),(130434,0,'魏县',3,130400,0,0,'','','',0,0,0,17,0,0,0),(130435,0,'曲周县',3,130400,0,0,'','','',0,0,0,18,0,0,0),(130471,0,'邯郸经济技术开发区',3,130400,0,0,'','','',0,0,0,19,0,0,0),(130473,0,'邯郸冀南新区',3,130400,0,0,'','','',0,0,0,20,0,0,0),(130481,0,'武安市',3,130400,0,0,'','','',0,0,0,21,0,0,0),(130500,0,'邢台市',2,13,0,0,'','','',0,0,21,5,0,0,0),(130501,0,'市辖区',3,130500,0,0,'','','',0,0,0,1,0,0,0),(130502,0,'桥东区',3,130500,0,0,'','','',0,0,0,2,0,0,0),(130503,0,'桥西区',3,130500,0,0,'','','',0,0,0,3,0,0,0),(130521,0,'邢台县',3,130500,0,0,'','','',0,0,0,4,0,0,0),(130522,0,'临城县',3,130500,0,0,'','','',0,0,0,5,0,0,0),(130523,0,'内丘县',3,130500,0,0,'','','',0,0,0,6,0,0,0),(130524,0,'柏乡县',3,130500,0,0,'','','',0,0,0,7,0,0,0),(130525,0,'隆尧县',3,130500,0,0,'','','',0,0,0,8,0,0,0),(130526,0,'任县',3,130500,0,0,'','','',0,0,0,9,0,0,0),(130527,0,'南和县',3,130500,0,0,'','','',0,0,0,10,0,0,0),(130528,0,'宁晋县',3,130500,0,0,'','','',0,0,0,11,0,0,0),(130529,0,'巨鹿县',3,130500,0,0,'','','',0,0,0,12,0,0,0),(130530,0,'新河县',3,130500,0,0,'','','',0,0,0,13,0,0,0),(130531,0,'广宗县',3,130500,0,0,'','','',0,0,0,14,0,0,0),(130532,0,'平乡县',3,130500,0,0,'','','',0,0,0,15,0,0,0),(130533,0,'威县',3,130500,0,0,'','','',0,0,0,16,0,0,0),(130534,0,'清河县',3,130500,0,0,'','','',0,0,0,17,0,0,0),(130535,0,'临西县',3,130500,0,0,'','','',0,0,0,18,0,0,0),(130571,0,'河北邢台经济开发区',3,130500,0,0,'','','',0,0,0,19,0,0,0),(130581,0,'南宫市',3,130500,0,0,'','','',0,0,0,20,0,0,0),(130582,0,'沙河市',3,130500,0,0,'','','',0,0,0,21,0,0,0),(130600,0,'保定市',2,13,0,0,'','','',0,0,27,6,0,0,0),(130601,0,'市辖区',3,130600,0,0,'','','',0,0,0,1,0,0,0),(130602,0,'竞秀区',3,130600,0,0,'','','',0,0,0,2,0,0,0),(130606,0,'莲池区',3,130600,0,0,'','','',0,0,0,3,0,0,0),(130607,0,'满城区',3,130600,0,0,'','','',0,0,0,4,0,0,0),(130608,0,'清苑区',3,130600,0,0,'','','',0,0,0,5,0,0,0),(130609,0,'徐水区',3,130600,0,0,'','','',0,0,0,6,0,0,0),(130623,0,'涞水县',3,130600,0,0,'','','',0,0,0,7,0,0,0),(130624,0,'阜平县',3,130600,0,0,'','','',0,0,0,8,0,0,0),(130626,0,'定兴县',3,130600,0,0,'','','',0,0,0,9,0,0,0),(130627,0,'唐县',3,130600,0,0,'','','',0,0,0,10,0,0,0),(130628,0,'高阳县',3,130600,0,0,'','','',0,0,0,11,0,0,0),(130629,0,'容城县',3,130600,0,0,'','','',0,0,0,12,0,0,0),(130630,0,'涞源县',3,130600,0,0,'','','',0,0,0,13,0,0,0),(130631,0,'望都县',3,130600,0,0,'','','',0,0,0,14,0,0,0),(130632,0,'安新县',3,130600,0,0,'','','',0,0,0,15,0,0,0),(130633,0,'易县',3,130600,0,0,'','','',0,0,0,16,0,0,0),(130634,0,'曲阳县',3,130600,0,0,'','','',0,0,0,17,0,0,0),(130635,0,'蠡县',3,130600,0,0,'','','',0,0,0,18,0,0,0),(130636,0,'顺平县',3,130600,0,0,'','','',0,0,0,19,0,0,0),(130637,0,'博野县',3,130600,0,0,'','','',0,0,0,20,0,0,0),(130638,0,'雄县',3,130600,0,0,'','','',0,0,0,21,0,0,0),(130671,0,'保定高新技术产业开发区',3,130600,0,0,'','','',0,0,0,22,0,0,0),(130672,0,'保定白沟新城',3,130600,0,0,'','','',0,0,0,23,0,0,0),(130681,0,'涿州市',3,130600,0,0,'','','',0,0,0,24,0,0,0),(130682,0,'定州市',3,130600,0,0,'','','',0,0,0,25,0,0,0),(130683,0,'安国市',3,130600,0,0,'','','',0,0,0,26,0,0,0),(130684,0,'高碑店市',3,130600,0,0,'','','',0,0,0,27,0,0,0),(130700,0,'张家口市',2,13,0,0,'','','',0,0,20,7,0,0,0),(130701,0,'市辖区',3,130700,0,0,'','','',0,0,0,1,0,0,0),(130702,0,'桥东区',3,130700,0,0,'','','',0,0,0,2,0,0,0),(130703,0,'桥西区',3,130700,0,0,'','','',0,0,0,3,0,0,0),(130705,0,'宣化区',3,130700,0,0,'','','',0,0,0,4,0,0,0),(130706,0,'下花园区',3,130700,0,0,'','','',0,0,0,5,0,0,0),(130708,0,'万全区',3,130700,0,0,'','','',0,0,0,6,0,0,0),(130709,0,'崇礼区',3,130700,0,0,'','','',0,0,0,7,0,0,0),(130722,0,'张北县',3,130700,0,0,'','','',0,0,0,8,0,0,0),(130723,0,'康保县',3,130700,0,0,'','','',0,0,0,9,0,0,0),(130724,0,'沽源县',3,130700,0,0,'','','',0,0,0,10,0,0,0),(130725,0,'尚义县',3,130700,0,0,'','','',0,0,0,11,0,0,0),(130726,0,'蔚县',3,130700,0,0,'','','',0,0,0,12,0,0,0),(130727,0,'阳原县',3,130700,0,0,'','','',0,0,0,13,0,0,0),(130728,0,'怀安县',3,130700,0,0,'','','',0,0,0,14,0,0,0),(130730,0,'怀来县',3,130700,0,0,'','','',0,0,0,15,0,0,0),(130731,0,'涿鹿县',3,130700,0,0,'','','',0,0,0,16,0,0,0),(130732,0,'赤城县',3,130700,0,0,'','','',0,0,0,17,0,0,0),(130771,0,'张家口经济开发区',3,130700,0,0,'','','',0,0,0,18,0,0,0),(130772,0,'张家口市察北管理区',3,130700,0,0,'','','',0,0,0,19,0,0,0),(130773,0,'张家口市塞北管理区',3,130700,0,0,'','','',0,0,0,20,0,0,0),(130800,0,'承德市',2,13,0,0,'','','',0,0,13,8,0,0,0),(130801,0,'市辖区',3,130800,0,0,'','','',0,0,0,1,0,0,0),(130802,0,'双桥区',3,130800,0,0,'','','',0,0,0,2,0,0,0),(130803,0,'双滦区',3,130800,0,0,'','','',0,0,0,3,0,0,0),(130804,0,'鹰手营子矿区',3,130800,0,0,'','','',0,0,0,4,0,0,0),(130821,0,'承德县',3,130800,0,0,'','','',0,0,0,5,0,0,0),(130822,0,'兴隆县',3,130800,0,0,'','','',0,0,0,6,0,0,0),(130824,0,'滦平县',3,130800,0,0,'','','',0,0,0,7,0,0,0),(130825,0,'隆化县',3,130800,0,0,'','','',0,0,0,8,0,0,0),(130826,0,'丰宁满族自治县',3,130800,0,0,'','','',0,0,0,9,0,0,0),(130827,0,'宽城满族自治县',3,130800,0,0,'','','',0,0,0,10,0,0,0),(130828,0,'围场满族蒙古族自治县',3,130800,0,0,'','','',0,0,0,11,0,0,0),(130871,0,'承德高新技术产业开发区',3,130800,0,0,'','','',0,0,0,12,0,0,0),(130881,0,'平泉市',3,130800,0,0,'','','',0,0,0,13,0,0,0),(130900,0,'沧州市',2,13,0,0,'','','',0,0,20,9,0,0,0),(130901,0,'市辖区',3,130900,0,0,'','','',0,0,0,1,0,0,0),(130902,0,'新华区',3,130900,0,0,'','','',0,0,0,2,0,0,0),(130903,0,'运河区',3,130900,0,0,'','','',0,0,0,3,0,0,0),(130921,0,'沧县',3,130900,0,0,'','','',0,0,0,4,0,0,0),(130922,0,'青县',3,130900,0,0,'','','',0,0,0,5,0,0,0),(130923,0,'东光县',3,130900,0,0,'','','',0,0,0,6,0,0,0),(130924,0,'海兴县',3,130900,0,0,'','','',0,0,0,7,0,0,0),(130925,0,'盐山县',3,130900,0,0,'','','',0,0,0,8,0,0,0),(130926,0,'肃宁县',3,130900,0,0,'','','',0,0,0,9,0,0,0),(130927,0,'南皮县',3,130900,0,0,'','','',0,0,0,10,0,0,0),(130928,0,'吴桥县',3,130900,0,0,'','','',0,0,0,11,0,0,0),(130929,0,'献县',3,130900,0,0,'','','',0,0,0,12,0,0,0),(130930,0,'孟村回族自治县',3,130900,0,0,'','','',0,0,0,13,0,0,0),(130971,0,'河北沧州经济开发区',3,130900,0,0,'','','',0,0,0,14,0,0,0),(130972,0,'沧州高新技术产业开发区',3,130900,0,0,'','','',0,0,0,15,0,0,0),(130973,0,'沧州渤海新区',3,130900,0,0,'','','',0,0,0,16,0,0,0),(130981,0,'泊头市',3,130900,0,0,'','','',0,0,0,17,0,0,0),(130982,0,'任丘市',3,130900,0,0,'','','',0,0,0,18,0,0,0),(130983,0,'黄骅市',3,130900,0,0,'','','',0,0,0,19,0,0,0),(130984,0,'河间市',3,130900,0,0,'','','',0,0,0,20,0,0,0),(131000,0,'廊坊市',2,13,0,0,'','','',0,0,12,10,0,0,0),(131001,0,'市辖区',3,131000,0,0,'','','',0,0,0,1,0,0,0),(131002,0,'安次区',3,131000,0,0,'','','',0,0,0,2,0,0,0),(131003,0,'广阳区',3,131000,0,0,'','','',0,0,0,3,0,0,0),(131022,0,'固安县',3,131000,0,0,'','','',0,0,0,4,0,0,0),(131023,0,'永清县',3,131000,0,0,'','','',0,0,0,5,0,0,0),(131024,0,'香河县',3,131000,0,0,'','','',0,0,0,6,0,0,0),(131025,0,'大城县',3,131000,0,0,'','','',0,0,0,7,0,0,0),(131026,0,'文安县',3,131000,0,0,'','','',0,0,0,8,0,0,0),(131028,0,'大厂回族自治县',3,131000,0,0,'','','',0,0,0,9,0,0,0),(131071,0,'廊坊经济技术开发区',3,131000,0,0,'','','',0,0,0,10,0,0,0),(131081,0,'霸州市',3,131000,0,0,'','','',0,0,0,11,0,0,0),(131082,0,'三河市',3,131000,0,0,'','','',0,0,0,12,0,0,0),(131100,0,'衡水市',2,13,0,0,'','','',0,0,14,11,0,0,0),(131101,0,'市辖区',3,131100,0,0,'','','',0,0,0,1,0,0,0),(131102,0,'桃城区',3,131100,0,0,'','','',0,0,0,2,0,0,0),(131103,0,'冀州区',3,131100,0,0,'','','',0,0,0,3,0,0,0),(131121,0,'枣强县',3,131100,0,0,'','','',0,0,0,4,0,0,0),(131122,0,'武邑县',3,131100,0,0,'','','',0,0,0,5,0,0,0),(131123,0,'武强县',3,131100,0,0,'','','',0,0,0,6,0,0,0),(131124,0,'饶阳县',3,131100,0,0,'','','',0,0,0,7,0,0,0),(131125,0,'安平县',3,131100,0,0,'','','',0,0,0,8,0,0,0),(131126,0,'故城县',3,131100,0,0,'','','',0,0,0,9,0,0,0),(131127,0,'景县',3,131100,0,0,'','','',0,0,0,10,0,0,0),(131128,0,'阜城县',3,131100,0,0,'','','',0,0,0,11,0,0,0),(131171,0,'河北衡水高新技术产业开发区',3,131100,0,0,'','','',0,0,0,12,0,0,0),(131172,0,'衡水滨湖新区',3,131100,0,0,'','','',0,0,0,13,0,0,0),(131182,0,'深州市',3,131100,0,0,'','','',0,0,0,14,0,0,0),(140100,0,'太原市',2,14,0,0,'','','',0,0,12,1,0,0,0),(140101,0,'市辖区',3,140100,0,0,'','','',0,0,0,1,0,0,0),(140105,0,'小店区',3,140100,0,0,'','','',0,0,0,2,0,0,0),(140106,0,'迎泽区',3,140100,0,0,'','','',0,0,0,3,0,0,0),(140107,0,'杏花岭区',3,140100,0,0,'','','',0,0,0,4,0,0,0),(140108,0,'尖草坪区',3,140100,0,0,'','','',0,0,0,5,0,0,0),(140109,0,'万柏林区',3,140100,0,0,'','','',0,0,0,6,0,0,0),(140110,0,'晋源区',3,140100,0,0,'','','',0,0,0,7,0,0,0),(140121,0,'清徐县',3,140100,0,0,'','','',0,0,0,8,0,0,0),(140122,0,'阳曲县',3,140100,0,0,'','','',0,0,0,9,0,0,0),(140123,0,'娄烦县',3,140100,0,0,'','','',0,0,0,10,0,0,0),(140171,0,'山西转型综合改革示范区',3,140100,0,0,'','','',0,0,0,11,0,0,0),(140181,0,'古交市',3,140100,0,0,'','','',0,0,0,12,0,0,0),(140200,0,'大同市',2,14,0,0,'','','',0,0,12,2,0,0,0),(140201,0,'市辖区',3,140200,0,0,'','','',0,0,0,1,0,0,0),(140212,0,'新荣区',3,140200,0,0,'','','',0,0,0,2,0,0,0),(140213,0,'平城区',3,140200,0,0,'','','',0,0,0,3,0,0,0),(140214,0,'云冈区',3,140200,0,0,'','','',0,0,0,4,0,0,0),(140215,0,'云州区',3,140200,0,0,'','','',0,0,0,5,0,0,0),(140221,0,'阳高县',3,140200,0,0,'','','',0,0,0,6,0,0,0),(140222,0,'天镇县',3,140200,0,0,'','','',0,0,0,7,0,0,0),(140223,0,'广灵县',3,140200,0,0,'','','',0,0,0,8,0,0,0),(140224,0,'灵丘县',3,140200,0,0,'','','',0,0,0,9,0,0,0),(140225,0,'浑源县',3,140200,0,0,'','','',0,0,0,10,0,0,0),(140226,0,'左云县',3,140200,0,0,'','','',0,0,0,11,0,0,0),(140271,0,'山西大同经济开发区',3,140200,0,0,'','','',0,0,0,12,0,0,0),(140300,0,'阳泉市',2,14,0,0,'','','',0,0,6,3,0,0,0),(140301,0,'市辖区',3,140300,0,0,'','','',0,0,0,1,0,0,0),(140302,0,'城区',3,140300,0,0,'','','',0,0,0,2,0,0,0),(140303,0,'矿区',3,140300,0,0,'','','',0,0,0,3,0,0,0),(140311,0,'郊区',3,140300,0,0,'','','',0,0,0,4,0,0,0),(140321,0,'平定县',3,140300,0,0,'','','',0,0,0,5,0,0,0),(140322,0,'盂县',3,140300,0,0,'','','',0,0,0,6,0,0,0),(140400,0,'长治市',2,14,0,0,'','','',0,0,14,4,0,0,0),(140401,0,'市辖区',3,140400,0,0,'','','',0,0,0,1,0,0,0),(140403,0,'潞州区',3,140400,0,0,'','','',0,0,0,2,0,0,0),(140404,0,'上党区',3,140400,0,0,'','','',0,0,0,3,0,0,0),(140405,0,'屯留区',3,140400,0,0,'','','',0,0,0,4,0,0,0),(140406,0,'潞城区',3,140400,0,0,'','','',0,0,0,5,0,0,0),(140423,0,'襄垣县',3,140400,0,0,'','','',0,0,0,6,0,0,0),(140425,0,'平顺县',3,140400,0,0,'','','',0,0,0,7,0,0,0),(140426,0,'黎城县',3,140400,0,0,'','','',0,0,0,8,0,0,0),(140427,0,'壶关县',3,140400,0,0,'','','',0,0,0,9,0,0,0),(140428,0,'长子县',3,140400,0,0,'','','',0,0,0,10,0,0,0),(140429,0,'武乡县',3,140400,0,0,'','','',0,0,0,11,0,0,0),(140430,0,'沁县',3,140400,0,0,'','','',0,0,0,12,0,0,0),(140431,0,'沁源县',3,140400,0,0,'','','',0,0,0,13,0,0,0),(140471,0,'山西长治高新技术产业园区',3,140400,0,0,'','','',0,0,0,14,0,0,0),(140500,0,'晋城市',2,14,0,0,'','','',0,0,7,5,0,0,0),(140501,0,'市辖区',3,140500,0,0,'','','',0,0,0,1,0,0,0),(140502,0,'城区',3,140500,0,0,'','','',0,0,0,2,0,0,0),(140521,0,'沁水县',3,140500,0,0,'','','',0,0,0,3,0,0,0),(140522,0,'阳城县',3,140500,0,0,'','','',0,0,0,4,0,0,0),(140524,0,'陵川县',3,140500,0,0,'','','',0,0,0,5,0,0,0),(140525,0,'泽州县',3,140500,0,0,'','','',0,0,0,6,0,0,0),(140581,0,'高平市',3,140500,0,0,'','','',0,0,0,7,0,0,0),(140600,0,'朔州市',2,14,0,0,'','','',0,0,8,6,0,0,0),(140601,0,'市辖区',3,140600,0,0,'','','',0,0,0,1,0,0,0),(140602,0,'朔城区',3,140600,0,0,'','','',0,0,0,2,0,0,0),(140603,0,'平鲁区',3,140600,0,0,'','','',0,0,0,3,0,0,0),(140621,0,'山阴县',3,140600,0,0,'','','',0,0,0,4,0,0,0),(140622,0,'应县',3,140600,0,0,'','','',0,0,0,5,0,0,0),(140623,0,'右玉县',3,140600,0,0,'','','',0,0,0,6,0,0,0),(140671,0,'山西朔州经济开发区',3,140600,0,0,'','','',0,0,0,7,0,0,0),(140681,0,'怀仁市',3,140600,0,0,'','','',0,0,0,8,0,0,0),(140700,0,'晋中市',2,14,0,0,'','','',0,0,12,7,0,0,0),(140701,0,'市辖区',3,140700,0,0,'','','',0,0,0,1,0,0,0),(140702,0,'榆次区',3,140700,0,0,'','','',0,0,0,2,0,0,0),(140721,0,'榆社县',3,140700,0,0,'','','',0,0,0,3,0,0,0),(140722,0,'左权县',3,140700,0,0,'','','',0,0,0,4,0,0,0),(140723,0,'和顺县',3,140700,0,0,'','','',0,0,0,5,0,0,0),(140724,0,'昔阳县',3,140700,0,0,'','','',0,0,0,6,0,0,0),(140725,0,'寿阳县',3,140700,0,0,'','','',0,0,0,7,0,0,0),(140726,0,'太谷县',3,140700,0,0,'','','',0,0,0,8,0,0,0),(140727,0,'祁县',3,140700,0,0,'','','',0,0,0,9,0,0,0),(140728,0,'平遥县',3,140700,0,0,'','','',0,0,0,10,0,0,0),(140729,0,'灵石县',3,140700,0,0,'','','',0,0,0,11,0,0,0),(140781,0,'介休市',3,140700,0,0,'','','',0,0,0,12,0,0,0),(140800,0,'运城市',2,14,0,0,'','','',0,0,14,8,0,0,0),(140801,0,'市辖区',3,140800,0,0,'','','',0,0,0,1,0,0,0),(140802,0,'盐湖区',3,140800,0,0,'','','',0,0,0,2,0,0,0),(140821,0,'临猗县',3,140800,0,0,'','','',0,0,0,3,0,0,0),(140822,0,'万荣县',3,140800,0,0,'','','',0,0,0,4,0,0,0),(140823,0,'闻喜县',3,140800,0,0,'','','',0,0,0,5,0,0,0),(140824,0,'稷山县',3,140800,0,0,'','','',0,0,0,6,0,0,0),(140825,0,'新绛县',3,140800,0,0,'','','',0,0,0,7,0,0,0),(140826,0,'绛县',3,140800,0,0,'','','',0,0,0,8,0,0,0),(140827,0,'垣曲县',3,140800,0,0,'','','',0,0,0,9,0,0,0),(140828,0,'夏县',3,140800,0,0,'','','',0,0,0,10,0,0,0),(140829,0,'平陆县',3,140800,0,0,'','','',0,0,0,11,0,0,0),(140830,0,'芮城县',3,140800,0,0,'','','',0,0,0,12,0,0,0),(140881,0,'永济市',3,140800,0,0,'','','',0,0,0,13,0,0,0),(140882,0,'河津市',3,140800,0,0,'','','',0,0,0,14,0,0,0),(140900,0,'忻州市',2,14,0,0,'','','',0,0,16,9,0,0,0),(140901,0,'市辖区',3,140900,0,0,'','','',0,0,0,1,0,0,0),(140902,0,'忻府区',3,140900,0,0,'','','',0,0,0,2,0,0,0),(140921,0,'定襄县',3,140900,0,0,'','','',0,0,0,3,0,0,0),(140922,0,'五台县',3,140900,0,0,'','','',0,0,0,4,0,0,0),(140923,0,'代县',3,140900,0,0,'','','',0,0,0,5,0,0,0),(140924,0,'繁峙县',3,140900,0,0,'','','',0,0,0,6,0,0,0),(140925,0,'宁武县',3,140900,0,0,'','','',0,0,0,7,0,0,0),(140926,0,'静乐县',3,140900,0,0,'','','',0,0,0,8,0,0,0),(140927,0,'神池县',3,140900,0,0,'','','',0,0,0,9,0,0,0),(140928,0,'五寨县',3,140900,0,0,'','','',0,0,0,10,0,0,0),(140929,0,'岢岚县',3,140900,0,0,'','','',0,0,0,11,0,0,0),(140930,0,'河曲县',3,140900,0,0,'','','',0,0,0,12,0,0,0),(140931,0,'保德县',3,140900,0,0,'','','',0,0,0,13,0,0,0),(140932,0,'偏关县',3,140900,0,0,'','','',0,0,0,14,0,0,0),(140971,0,'五台山风景名胜区',3,140900,0,0,'','','',0,0,0,15,0,0,0),(140981,0,'原平市',3,140900,0,0,'','','',0,0,0,16,0,0,0),(141000,0,'临汾市',2,14,0,0,'','','',0,0,18,10,0,0,0),(141001,0,'市辖区',3,141000,0,0,'','','',0,0,0,1,0,0,0),(141002,0,'尧都区',3,141000,0,0,'','','',0,0,0,2,0,0,0),(141021,0,'曲沃县',3,141000,0,0,'','','',0,0,0,3,0,0,0),(141022,0,'翼城县',3,141000,0,0,'','','',0,0,0,4,0,0,0),(141023,0,'襄汾县',3,141000,0,0,'','','',0,0,0,5,0,0,0),(141024,0,'洪洞县',3,141000,0,0,'','','',0,0,0,6,0,0,0),(141025,0,'古县',3,141000,0,0,'','','',0,0,0,7,0,0,0),(141026,0,'安泽县',3,141000,0,0,'','','',0,0,0,8,0,0,0),(141027,0,'浮山县',3,141000,0,0,'','','',0,0,0,9,0,0,0),(141028,0,'吉县',3,141000,0,0,'','','',0,0,0,10,0,0,0),(141029,0,'乡宁县',3,141000,0,0,'','','',0,0,0,11,0,0,0),(141030,0,'大宁县',3,141000,0,0,'','','',0,0,0,12,0,0,0),(141031,0,'隰县',3,141000,0,0,'','','',0,0,0,13,0,0,0),(141032,0,'永和县',3,141000,0,0,'','','',0,0,0,14,0,0,0),(141033,0,'蒲县',3,141000,0,0,'','','',0,0,0,15,0,0,0),(141034,0,'汾西县',3,141000,0,0,'','','',0,0,0,16,0,0,0),(141081,0,'侯马市',3,141000,0,0,'','','',0,0,0,17,0,0,0),(141082,0,'霍州市',3,141000,0,0,'','','',0,0,0,18,0,0,0),(141100,0,'吕梁市',2,14,0,0,'','','',0,0,14,11,0,0,0),(141101,0,'市辖区',3,141100,0,0,'','','',0,0,0,1,0,0,0),(141102,0,'离石区',3,141100,0,0,'','','',0,0,0,2,0,0,0),(141121,0,'文水县',3,141100,0,0,'','','',0,0,0,3,0,0,0),(141122,0,'交城县',3,141100,0,0,'','','',0,0,0,4,0,0,0),(141123,0,'兴县',3,141100,0,0,'','','',0,0,0,5,0,0,0),(141124,0,'临县',3,141100,0,0,'','','',0,0,0,6,0,0,0),(141125,0,'柳林县',3,141100,0,0,'','','',0,0,0,7,0,0,0),(141126,0,'石楼县',3,141100,0,0,'','','',0,0,0,8,0,0,0),(141127,0,'岚县',3,141100,0,0,'','','',0,0,0,9,0,0,0),(141128,0,'方山县',3,141100,0,0,'','','',0,0,0,10,0,0,0),(141129,0,'中阳县',3,141100,0,0,'','','',0,0,0,11,0,0,0),(141130,0,'交口县',3,141100,0,0,'','','',0,0,0,12,0,0,0),(141181,0,'孝义市',3,141100,0,0,'','','',0,0,0,13,0,0,0),(141182,0,'汾阳市',3,141100,0,0,'','','',0,0,0,14,0,0,0),(150100,0,'呼和浩特市',2,15,0,0,'','','',0,0,12,1,0,0,0),(150101,0,'市辖区',3,150100,0,0,'','','',0,0,0,1,0,0,0),(150102,0,'新城区',3,150100,0,0,'','','',0,0,0,2,0,0,0),(150103,0,'回民区',3,150100,0,0,'','','',0,0,0,3,0,0,0),(150104,0,'玉泉区',3,150100,0,0,'','','',0,0,0,4,0,0,0),(150105,0,'赛罕区',3,150100,0,0,'','','',0,0,0,5,0,0,0),(150121,0,'土默特左旗',3,150100,0,0,'','','',0,0,0,6,0,0,0),(150122,0,'托克托县',3,150100,0,0,'','','',0,0,0,7,0,0,0),(150123,0,'和林格尔县',3,150100,0,0,'','','',0,0,0,8,0,0,0),(150124,0,'清水河县',3,150100,0,0,'','','',0,0,0,9,0,0,0),(150125,0,'武川县',3,150100,0,0,'','','',0,0,0,10,0,0,0),(150171,0,'呼和浩特金海工业园区',3,150100,0,0,'','','',0,0,0,11,0,0,0),(150172,0,'呼和浩特经济技术开发区',3,150100,0,0,'','','',0,0,0,12,0,0,0),(150200,0,'包头市',2,15,0,0,'','','',0,0,11,2,0,0,0),(150201,0,'市辖区',3,150200,0,0,'','','',0,0,0,1,0,0,0),(150202,0,'东河区',3,150200,0,0,'','','',0,0,0,2,0,0,0),(150203,0,'昆都仑区',3,150200,0,0,'','','',0,0,0,3,0,0,0),(150204,0,'青山区',3,150200,0,0,'','','',0,0,0,4,0,0,0),(150205,0,'石拐区',3,150200,0,0,'','','',0,0,0,5,0,0,0),(150206,0,'白云鄂博矿区',3,150200,0,0,'','','',0,0,0,6,0,0,0),(150207,0,'九原区',3,150200,0,0,'','','',0,0,0,7,0,0,0),(150221,0,'土默特右旗',3,150200,0,0,'','','',0,0,0,8,0,0,0),(150222,0,'固阳县',3,150200,0,0,'','','',0,0,0,9,0,0,0),(150223,0,'达尔罕茂明安联合旗',3,150200,0,0,'','','',0,0,0,10,0,0,0),(150271,0,'包头稀土高新技术产业开发区',3,150200,0,0,'','','',0,0,0,11,0,0,0),(150300,0,'乌海市',2,15,0,0,'','','',0,0,4,3,0,0,0),(150301,0,'市辖区',3,150300,0,0,'','','',0,0,0,1,0,0,0),(150302,0,'海勃湾区',3,150300,0,0,'','','',0,0,0,2,0,0,0),(150303,0,'海南区',3,150300,0,0,'','','',0,0,0,3,0,0,0),(150304,0,'乌达区',3,150300,0,0,'','','',0,0,0,4,0,0,0),(150400,0,'赤峰市',2,15,0,0,'','','',0,0,13,4,0,0,0),(150401,0,'市辖区',3,150400,0,0,'','','',0,0,0,1,0,0,0),(150402,0,'红山区',3,150400,0,0,'','','',0,0,0,2,0,0,0),(150403,0,'元宝山区',3,150400,0,0,'','','',0,0,0,3,0,0,0),(150404,0,'松山区',3,150400,0,0,'','','',0,0,0,4,0,0,0),(150421,0,'阿鲁科尔沁旗',3,150400,0,0,'','','',0,0,0,5,0,0,0),(150422,0,'巴林左旗',3,150400,0,0,'','','',0,0,0,6,0,0,0),(150423,0,'巴林右旗',3,150400,0,0,'','','',0,0,0,7,0,0,0),(150424,0,'林西县',3,150400,0,0,'','','',0,0,0,8,0,0,0),(150425,0,'克什克腾旗',3,150400,0,0,'','','',0,0,0,9,0,0,0),(150426,0,'翁牛特旗',3,150400,0,0,'','','',0,0,0,10,0,0,0),(150428,0,'喀喇沁旗',3,150400,0,0,'','','',0,0,0,11,0,0,0),(150429,0,'宁城县',3,150400,0,0,'','','',0,0,0,12,0,0,0),(150430,0,'敖汉旗',3,150400,0,0,'','','',0,0,0,13,0,0,0),(150500,0,'通辽市',2,15,0,0,'','','',0,0,10,5,0,0,0),(150501,0,'市辖区',3,150500,0,0,'','','',0,0,0,1,0,0,0),(150502,0,'科尔沁区',3,150500,0,0,'','','',0,0,0,2,0,0,0),(150521,0,'科尔沁左翼中旗',3,150500,0,0,'','','',0,0,0,3,0,0,0),(150522,0,'科尔沁左翼后旗',3,150500,0,0,'','','',0,0,0,4,0,0,0),(150523,0,'开鲁县',3,150500,0,0,'','','',0,0,0,5,0,0,0),(150524,0,'库伦旗',3,150500,0,0,'','','',0,0,0,6,0,0,0),(150525,0,'奈曼旗',3,150500,0,0,'','','',0,0,0,7,0,0,0),(150526,0,'扎鲁特旗',3,150500,0,0,'','','',0,0,0,8,0,0,0),(150571,0,'通辽经济技术开发区',3,150500,0,0,'','','',0,0,0,9,0,0,0),(150581,0,'霍林郭勒市',3,150500,0,0,'','','',0,0,0,10,0,0,0),(150600,0,'鄂尔多斯市',2,15,0,0,'','','',0,0,10,6,0,0,0),(150601,0,'市辖区',3,150600,0,0,'','','',0,0,0,1,0,0,0),(150602,0,'东胜区',3,150600,0,0,'','','',0,0,0,2,0,0,0),(150603,0,'康巴什区',3,150600,0,0,'','','',0,0,0,3,0,0,0),(150621,0,'达拉特旗',3,150600,0,0,'','','',0,0,0,4,0,0,0),(150622,0,'准格尔旗',3,150600,0,0,'','','',0,0,0,5,0,0,0),(150623,0,'鄂托克前旗',3,150600,0,0,'','','',0,0,0,6,0,0,0),(150624,0,'鄂托克旗',3,150600,0,0,'','','',0,0,0,7,0,0,0),(150625,0,'杭锦旗',3,150600,0,0,'','','',0,0,0,8,0,0,0),(150626,0,'乌审旗',3,150600,0,0,'','','',0,0,0,9,0,0,0),(150627,0,'伊金霍洛旗',3,150600,0,0,'','','',0,0,0,10,0,0,0),(150700,0,'呼伦贝尔市',2,15,0,0,'','','',0,0,15,7,0,0,0),(150701,0,'市辖区',3,150700,0,0,'','','',0,0,0,1,0,0,0),(150702,0,'海拉尔区',3,150700,0,0,'','','',0,0,0,2,0,0,0),(150703,0,'扎赉诺尔区',3,150700,0,0,'','','',0,0,0,3,0,0,0),(150721,0,'阿荣旗',3,150700,0,0,'','','',0,0,0,4,0,0,0),(150722,0,'莫力达瓦达斡尔族自治旗',3,150700,0,0,'','','',0,0,0,5,0,0,0),(150723,0,'鄂伦春自治旗',3,150700,0,0,'','','',0,0,0,6,0,0,0),(150724,0,'鄂温克族自治旗',3,150700,0,0,'','','',0,0,0,7,0,0,0),(150725,0,'陈巴尔虎旗',3,150700,0,0,'','','',0,0,0,8,0,0,0),(150726,0,'新巴尔虎左旗',3,150700,0,0,'','','',0,0,0,9,0,0,0),(150727,0,'新巴尔虎右旗',3,150700,0,0,'','','',0,0,0,10,0,0,0),(150781,0,'满洲里市',3,150700,0,0,'','','',0,0,0,11,0,0,0),(150782,0,'牙克石市',3,150700,0,0,'','','',0,0,0,12,0,0,0),(150783,0,'扎兰屯市',3,150700,0,0,'','','',0,0,0,13,0,0,0),(150784,0,'额尔古纳市',3,150700,0,0,'','','',0,0,0,14,0,0,0),(150785,0,'根河市',3,150700,0,0,'','','',0,0,0,15,0,0,0),(150800,0,'巴彦淖尔市',2,15,0,0,'','','',0,0,8,8,0,0,0),(150801,0,'市辖区',3,150800,0,0,'','','',0,0,0,1,0,0,0),(150802,0,'临河区',3,150800,0,0,'','','',0,0,0,2,0,0,0),(150821,0,'五原县',3,150800,0,0,'','','',0,0,0,3,0,0,0),(150822,0,'磴口县',3,150800,0,0,'','','',0,0,0,4,0,0,0),(150823,0,'乌拉特前旗',3,150800,0,0,'','','',0,0,0,5,0,0,0),(150824,0,'乌拉特中旗',3,150800,0,0,'','','',0,0,0,6,0,0,0),(150825,0,'乌拉特后旗',3,150800,0,0,'','','',0,0,0,7,0,0,0),(150826,0,'杭锦后旗',3,150800,0,0,'','','',0,0,0,8,0,0,0),(150900,0,'乌兰察布市',2,15,0,0,'','','',0,0,12,9,0,0,0),(150901,0,'市辖区',3,150900,0,0,'','','',0,0,0,1,0,0,0),(150902,0,'集宁区',3,150900,0,0,'','','',0,0,0,2,0,0,0),(150921,0,'卓资县',3,150900,0,0,'','','',0,0,0,3,0,0,0),(150922,0,'化德县',3,150900,0,0,'','','',0,0,0,4,0,0,0),(150923,0,'商都县',3,150900,0,0,'','','',0,0,0,5,0,0,0),(150924,0,'兴和县',3,150900,0,0,'','','',0,0,0,6,0,0,0),(150925,0,'凉城县',3,150900,0,0,'','','',0,0,0,7,0,0,0),(150926,0,'察哈尔右翼前旗',3,150900,0,0,'','','',0,0,0,8,0,0,0),(150927,0,'察哈尔右翼中旗',3,150900,0,0,'','','',0,0,0,9,0,0,0),(150928,0,'察哈尔右翼后旗',3,150900,0,0,'','','',0,0,0,10,0,0,0),(150929,0,'四子王旗',3,150900,0,0,'','','',0,0,0,11,0,0,0),(150981,0,'丰镇市',3,150900,0,0,'','','',0,0,0,12,0,0,0),(152200,0,'兴安盟',2,15,0,0,'','','',0,0,6,10,0,0,0),(152201,0,'乌兰浩特市',3,152200,0,0,'','','',0,0,0,1,0,0,0),(152202,0,'阿尔山市',3,152200,0,0,'','','',0,0,0,2,0,0,0),(152221,0,'科尔沁右翼前旗',3,152200,0,0,'','','',0,0,0,3,0,0,0),(152222,0,'科尔沁右翼中旗',3,152200,0,0,'','','',0,0,0,4,0,0,0),(152223,0,'扎赉特旗',3,152200,0,0,'','','',0,0,0,5,0,0,0),(152224,0,'突泉县',3,152200,0,0,'','','',0,0,0,6,0,0,0),(152500,0,'锡林郭勒盟',2,15,0,0,'','','',0,0,13,11,0,0,0),(152501,0,'二连浩特市',3,152500,0,0,'','','',0,0,0,1,0,0,0),(152502,0,'锡林浩特市',3,152500,0,0,'','','',0,0,0,2,0,0,0),(152522,0,'阿巴嘎旗',3,152500,0,0,'','','',0,0,0,3,0,0,0),(152523,0,'苏尼特左旗',3,152500,0,0,'','','',0,0,0,4,0,0,0),(152524,0,'苏尼特右旗',3,152500,0,0,'','','',0,0,0,5,0,0,0),(152525,0,'东乌珠穆沁旗',3,152500,0,0,'','','',0,0,0,6,0,0,0),(152526,0,'西乌珠穆沁旗',3,152500,0,0,'','','',0,0,0,7,0,0,0),(152527,0,'太仆寺旗',3,152500,0,0,'','','',0,0,0,8,0,0,0),(152528,0,'镶黄旗',3,152500,0,0,'','','',0,0,0,9,0,0,0),(152529,0,'正镶白旗',3,152500,0,0,'','','',0,0,0,10,0,0,0),(152530,0,'正蓝旗',3,152500,0,0,'','','',0,0,0,11,0,0,0),(152531,0,'多伦县',3,152500,0,0,'','','',0,0,0,12,0,0,0),(152571,0,'乌拉盖管委会',3,152500,0,0,'','','',0,0,0,13,0,0,0),(152900,0,'阿拉善盟',2,15,0,0,'','','',0,0,4,12,0,0,0),(152921,0,'阿拉善左旗',3,152900,0,0,'','','',0,0,0,1,0,0,0),(152922,0,'阿拉善右旗',3,152900,0,0,'','','',0,0,0,2,0,0,0),(152923,0,'额济纳旗',3,152900,0,0,'','','',0,0,0,3,0,0,0),(152971,0,'内蒙古阿拉善经济开发区',3,152900,0,0,'','','',0,0,0,4,0,0,0),(210100,0,'沈阳市',2,21,0,0,'','','',0,0,14,1,0,0,0),(210101,0,'市辖区',3,210100,0,0,'','','',0,0,0,1,0,0,0),(210102,0,'和平区',3,210100,0,0,'','','',0,0,0,2,0,0,0),(210103,0,'沈河区',3,210100,0,0,'','','',0,0,0,3,0,0,0),(210104,0,'大东区',3,210100,0,0,'','','',0,0,0,4,0,0,0),(210105,0,'皇姑区',3,210100,0,0,'','','',0,0,0,5,0,0,0),(210106,0,'铁西区',3,210100,0,0,'','','',0,0,0,6,0,0,0),(210111,0,'苏家屯区',3,210100,0,0,'','','',0,0,0,7,0,0,0),(210112,0,'浑南区',3,210100,0,0,'','','',0,0,0,8,0,0,0),(210113,0,'沈北新区',3,210100,0,0,'','','',0,0,0,9,0,0,0),(210114,0,'于洪区',3,210100,0,0,'','','',0,0,0,10,0,0,0),(210115,0,'辽中区',3,210100,0,0,'','','',0,0,0,11,0,0,0),(210123,0,'康平县',3,210100,0,0,'','','',0,0,0,12,0,0,0),(210124,0,'法库县',3,210100,0,0,'','','',0,0,0,13,0,0,0),(210181,0,'新民市',3,210100,0,0,'','','',0,0,0,14,0,0,0),(210200,0,'大连市',2,21,0,0,'','','',0,0,11,2,0,0,0),(210201,0,'市辖区',3,210200,0,0,'','','',0,0,0,1,0,0,0),(210202,0,'中山区',3,210200,0,0,'','','',0,0,0,2,0,0,0),(210203,0,'西岗区',3,210200,0,0,'','','',0,0,0,3,0,0,0),(210204,0,'沙河口区',3,210200,0,0,'','','',0,0,0,4,0,0,0),(210211,0,'甘井子区',3,210200,0,0,'','','',0,0,0,5,0,0,0),(210212,0,'旅顺口区',3,210200,0,0,'','','',0,0,0,6,0,0,0),(210213,0,'金州区',3,210200,0,0,'','','',0,0,0,7,0,0,0),(210214,0,'普兰店区',3,210200,0,0,'','','',0,0,0,8,0,0,0),(210224,0,'长海县',3,210200,0,0,'','','',0,0,0,9,0,0,0),(210281,0,'瓦房店市',3,210200,0,0,'','','',0,0,0,10,0,0,0),(210283,0,'庄河市',3,210200,0,0,'','','',0,0,0,11,0,0,0),(210300,0,'鞍山市',2,21,0,0,'','','',0,0,8,3,0,0,0),(210301,0,'市辖区',3,210300,0,0,'','','',0,0,0,1,0,0,0),(210302,0,'铁东区',3,210300,0,0,'','','',0,0,0,2,0,0,0),(210303,0,'铁西区',3,210300,0,0,'','','',0,0,0,3,0,0,0),(210304,0,'立山区',3,210300,0,0,'','','',0,0,0,4,0,0,0),(210311,0,'千山区',3,210300,0,0,'','','',0,0,0,5,0,0,0),(210321,0,'台安县',3,210300,0,0,'','','',0,0,0,6,0,0,0),(210323,0,'岫岩满族自治县',3,210300,0,0,'','','',0,0,0,7,0,0,0),(210381,0,'海城市',3,210300,0,0,'','','',0,0,0,8,0,0,0),(210400,0,'抚顺市',2,21,0,0,'','','',0,0,8,4,0,0,0),(210401,0,'市辖区',3,210400,0,0,'','','',0,0,0,1,0,0,0),(210402,0,'新抚区',3,210400,0,0,'','','',0,0,0,2,0,0,0),(210403,0,'东洲区',3,210400,0,0,'','','',0,0,0,3,0,0,0),(210404,0,'望花区',3,210400,0,0,'','','',0,0,0,4,0,0,0),(210411,0,'顺城区',3,210400,0,0,'','','',0,0,0,5,0,0,0),(210421,0,'抚顺县',3,210400,0,0,'','','',0,0,0,6,0,0,0),(210422,0,'新宾满族自治县',3,210400,0,0,'','','',0,0,0,7,0,0,0),(210423,0,'清原满族自治县',3,210400,0,0,'','','',0,0,0,8,0,0,0),(210500,0,'本溪市',2,21,0,0,'','','',0,0,7,5,0,0,0),(210501,0,'市辖区',3,210500,0,0,'','','',0,0,0,1,0,0,0),(210502,0,'平山区',3,210500,0,0,'','','',0,0,0,2,0,0,0),(210503,0,'溪湖区',3,210500,0,0,'','','',0,0,0,3,0,0,0),(210504,0,'明山区',3,210500,0,0,'','','',0,0,0,4,0,0,0),(210505,0,'南芬区',3,210500,0,0,'','','',0,0,0,5,0,0,0),(210521,0,'本溪满族自治县',3,210500,0,0,'','','',0,0,0,6,0,0,0),(210522,0,'桓仁满族自治县',3,210500,0,0,'','','',0,0,0,7,0,0,0),(210600,0,'丹东市',2,21,0,0,'','','',0,0,7,6,0,0,0),(210601,0,'市辖区',3,210600,0,0,'','','',0,0,0,1,0,0,0),(210602,0,'元宝区',3,210600,0,0,'','','',0,0,0,2,0,0,0),(210603,0,'振兴区',3,210600,0,0,'','','',0,0,0,3,0,0,0),(210604,0,'振安区',3,210600,0,0,'','','',0,0,0,4,0,0,0),(210624,0,'宽甸满族自治县',3,210600,0,0,'','','',0,0,0,5,0,0,0),(210681,0,'东港市',3,210600,0,0,'','','',0,0,0,6,0,0,0),(210682,0,'凤城市',3,210600,0,0,'','','',0,0,0,7,0,0,0),(210700,0,'锦州市',2,21,0,0,'','','',0,0,8,7,0,0,0),(210701,0,'市辖区',3,210700,0,0,'','','',0,0,0,1,0,0,0),(210702,0,'古塔区',3,210700,0,0,'','','',0,0,0,2,0,0,0),(210703,0,'凌河区',3,210700,0,0,'','','',0,0,0,3,0,0,0),(210711,0,'太和区',3,210700,0,0,'','','',0,0,0,4,0,0,0),(210726,0,'黑山县',3,210700,0,0,'','','',0,0,0,5,0,0,0),(210727,0,'义县',3,210700,0,0,'','','',0,0,0,6,0,0,0),(210781,0,'凌海市',3,210700,0,0,'','','',0,0,0,7,0,0,0),(210782,0,'北镇市',3,210700,0,0,'','','',0,0,0,8,0,0,0),(210800,0,'营口市',2,21,0,0,'','','',0,0,7,8,0,0,0),(210801,0,'市辖区',3,210800,0,0,'','','',0,0,0,1,0,0,0),(210802,0,'站前区',3,210800,0,0,'','','',0,0,0,2,0,0,0),(210803,0,'西市区',3,210800,0,0,'','','',0,0,0,3,0,0,0),(210804,0,'鲅鱼圈区',3,210800,0,0,'','','',0,0,0,4,0,0,0),(210811,0,'老边区',3,210800,0,0,'','','',0,0,0,5,0,0,0),(210881,0,'盖州市',3,210800,0,0,'','','',0,0,0,6,0,0,0),(210882,0,'大石桥市',3,210800,0,0,'','','',0,0,0,7,0,0,0),(210900,0,'阜新市',2,21,0,0,'','','',0,0,8,9,0,0,0),(210901,0,'市辖区',3,210900,0,0,'','','',0,0,0,1,0,0,0),(210902,0,'海州区',3,210900,0,0,'','','',0,0,0,2,0,0,0),(210903,0,'新邱区',3,210900,0,0,'','','',0,0,0,3,0,0,0),(210904,0,'太平区',3,210900,0,0,'','','',0,0,0,4,0,0,0),(210905,0,'清河门区',3,210900,0,0,'','','',0,0,0,5,0,0,0),(210911,0,'细河区',3,210900,0,0,'','','',0,0,0,6,0,0,0),(210921,0,'阜新蒙古族自治县',3,210900,0,0,'','','',0,0,0,7,0,0,0),(210922,0,'彰武县',3,210900,0,0,'','','',0,0,0,8,0,0,0),(211000,0,'辽阳市',2,21,0,0,'','','',0,0,8,10,0,0,0),(211001,0,'市辖区',3,211000,0,0,'','','',0,0,0,1,0,0,0),(211002,0,'白塔区',3,211000,0,0,'','','',0,0,0,2,0,0,0),(211003,0,'文圣区',3,211000,0,0,'','','',0,0,0,3,0,0,0),(211004,0,'宏伟区',3,211000,0,0,'','','',0,0,0,4,0,0,0),(211005,0,'弓长岭区',3,211000,0,0,'','','',0,0,0,5,0,0,0),(211011,0,'太子河区',3,211000,0,0,'','','',0,0,0,6,0,0,0),(211021,0,'辽阳县',3,211000,0,0,'','','',0,0,0,7,0,0,0),(211081,0,'灯塔市',3,211000,0,0,'','','',0,0,0,8,0,0,0),(211100,0,'盘锦市',2,21,0,0,'','','',0,0,5,11,0,0,0),(211101,0,'市辖区',3,211100,0,0,'','','',0,0,0,1,0,0,0),(211102,0,'双台子区',3,211100,0,0,'','','',0,0,0,2,0,0,0),(211103,0,'兴隆台区',3,211100,0,0,'','','',0,0,0,3,0,0,0),(211104,0,'大洼区',3,211100,0,0,'','','',0,0,0,4,0,0,0),(211122,0,'盘山县',3,211100,0,0,'','','',0,0,0,5,0,0,0),(211200,0,'铁岭市',2,21,0,0,'','','',0,0,8,12,0,0,0),(211201,0,'市辖区',3,211200,0,0,'','','',0,0,0,1,0,0,0),(211202,0,'银州区',3,211200,0,0,'','','',0,0,0,2,0,0,0),(211204,0,'清河区',3,211200,0,0,'','','',0,0,0,3,0,0,0),(211221,0,'铁岭县',3,211200,0,0,'','','',0,0,0,4,0,0,0),(211223,0,'西丰县',3,211200,0,0,'','','',0,0,0,5,0,0,0),(211224,0,'昌图县',3,211200,0,0,'','','',0,0,0,6,0,0,0),(211281,0,'调兵山市',3,211200,0,0,'','','',0,0,0,7,0,0,0),(211282,0,'开原市',3,211200,0,0,'','','',0,0,0,8,0,0,0),(211300,0,'朝阳市',2,21,0,0,'','','',0,0,8,13,0,0,0),(211301,0,'市辖区',3,211300,0,0,'','','',0,0,0,1,0,0,0),(211302,0,'双塔区',3,211300,0,0,'','','',0,0,0,2,0,0,0),(211303,0,'龙城区',3,211300,0,0,'','','',0,0,0,3,0,0,0),(211321,0,'朝阳县',3,211300,0,0,'','','',0,0,0,4,0,0,0),(211322,0,'建平县',3,211300,0,0,'','','',0,0,0,5,0,0,0),(211324,0,'喀喇沁左翼蒙古族自治县',3,211300,0,0,'','','',0,0,0,6,0,0,0),(211381,0,'北票市',3,211300,0,0,'','','',0,0,0,7,0,0,0),(211382,0,'凌源市',3,211300,0,0,'','','',0,0,0,8,0,0,0),(211400,0,'葫芦岛市',2,21,0,0,'','','',0,0,7,14,0,0,0),(211401,0,'市辖区',3,211400,0,0,'','','',0,0,0,1,0,0,0),(211402,0,'连山区',3,211400,0,0,'','','',0,0,0,2,0,0,0),(211403,0,'龙港区',3,211400,0,0,'','','',0,0,0,3,0,0,0),(211404,0,'南票区',3,211400,0,0,'','','',0,0,0,4,0,0,0),(211421,0,'绥中县',3,211400,0,0,'','','',0,0,0,5,0,0,0),(211422,0,'建昌县',3,211400,0,0,'','','',0,0,0,6,0,0,0),(211481,0,'兴城市',3,211400,0,0,'','','',0,0,0,7,0,0,0),(220100,0,'长春市',2,22,0,0,'','','',0,0,15,1,0,0,0),(220101,0,'市辖区',3,220100,0,0,'','','',0,0,0,1,0,0,0),(220102,0,'南关区',3,220100,0,0,'','','',0,0,0,2,0,0,0),(220103,0,'宽城区',3,220100,0,0,'','','',0,0,0,3,0,0,0),(220104,0,'朝阳区',3,220100,0,0,'','','',0,0,0,4,0,0,0),(220105,0,'二道区',3,220100,0,0,'','','',0,0,0,5,0,0,0),(220106,0,'绿园区',3,220100,0,0,'','','',0,0,0,6,0,0,0),(220112,0,'双阳区',3,220100,0,0,'','','',0,0,0,7,0,0,0),(220113,0,'九台区',3,220100,0,0,'','','',0,0,0,8,0,0,0),(220122,0,'农安县',3,220100,0,0,'','','',0,0,0,9,0,0,0),(220171,0,'长春经济技术开发区',3,220100,0,0,'','','',0,0,0,10,0,0,0),(220172,0,'长春净月高新技术产业开发区',3,220100,0,0,'','','',0,0,0,11,0,0,0),(220173,0,'长春高新技术产业开发区',3,220100,0,0,'','','',0,0,0,12,0,0,0),(220174,0,'长春汽车经济技术开发区',3,220100,0,0,'','','',0,0,0,13,0,0,0),(220182,0,'榆树市',3,220100,0,0,'','','',0,0,0,14,0,0,0),(220183,0,'德惠市',3,220100,0,0,'','','',0,0,0,15,0,0,0),(220200,0,'吉林市',2,22,0,0,'','','',0,0,13,2,0,0,0),(220201,0,'市辖区',3,220200,0,0,'','','',0,0,0,1,0,0,0),(220202,0,'昌邑区',3,220200,0,0,'','','',0,0,0,2,0,0,0),(220203,0,'龙潭区',3,220200,0,0,'','','',0,0,0,3,0,0,0),(220204,0,'船营区',3,220200,0,0,'','','',0,0,0,4,0,0,0),(220211,0,'丰满区',3,220200,0,0,'','','',0,0,0,5,0,0,0),(220221,0,'永吉县',3,220200,0,0,'','','',0,0,0,6,0,0,0),(220271,0,'吉林经济开发区',3,220200,0,0,'','','',0,0,0,7,0,0,0),(220272,0,'吉林高新技术产业开发区',3,220200,0,0,'','','',0,0,0,8,0,0,0),(220273,0,'吉林中国新加坡食品区',3,220200,0,0,'','','',0,0,0,9,0,0,0),(220281,0,'蛟河市',3,220200,0,0,'','','',0,0,0,10,0,0,0),(220282,0,'桦甸市',3,220200,0,0,'','','',0,0,0,11,0,0,0),(220283,0,'舒兰市',3,220200,0,0,'','','',0,0,0,12,0,0,0),(220284,0,'磐石市',3,220200,0,0,'','','',0,0,0,13,0,0,0),(220300,0,'四平市',2,22,0,0,'','','',0,0,7,3,0,0,0),(220301,0,'市辖区',3,220300,0,0,'','','',0,0,0,1,0,0,0),(220302,0,'铁西区',3,220300,0,0,'','','',0,0,0,2,0,0,0),(220303,0,'铁东区',3,220300,0,0,'','','',0,0,0,3,0,0,0),(220322,0,'梨树县',3,220300,0,0,'','','',0,0,0,4,0,0,0),(220323,0,'伊通满族自治县',3,220300,0,0,'','','',0,0,0,5,0,0,0),(220381,0,'公主岭市',3,220300,0,0,'','','',0,0,0,6,0,0,0),(220382,0,'双辽市',3,220300,0,0,'','','',0,0,0,7,0,0,0),(220400,0,'辽源市',2,22,0,0,'','','',0,0,5,4,0,0,0),(220401,0,'市辖区',3,220400,0,0,'','','',0,0,0,1,0,0,0),(220402,0,'龙山区',3,220400,0,0,'','','',0,0,0,2,0,0,0),(220403,0,'西安区',3,220400,0,0,'','','',0,0,0,3,0,0,0),(220421,0,'东丰县',3,220400,0,0,'','','',0,0,0,4,0,0,0),(220422,0,'东辽县',3,220400,0,0,'','','',0,0,0,5,0,0,0),(220500,0,'通化市',2,22,0,0,'','','',0,0,8,5,0,0,0),(220501,0,'市辖区',3,220500,0,0,'','','',0,0,0,1,0,0,0),(220502,0,'东昌区',3,220500,0,0,'','','',0,0,0,2,0,0,0),(220503,0,'二道江区',3,220500,0,0,'','','',0,0,0,3,0,0,0),(220521,0,'通化县',3,220500,0,0,'','','',0,0,0,4,0,0,0),(220523,0,'辉南县',3,220500,0,0,'','','',0,0,0,5,0,0,0),(220524,0,'柳河县',3,220500,0,0,'','','',0,0,0,6,0,0,0),(220581,0,'梅河口市',3,220500,0,0,'','','',0,0,0,7,0,0,0),(220582,0,'集安市',3,220500,0,0,'','','',0,0,0,8,0,0,0),(220600,0,'白山市',2,22,0,0,'','','',0,0,7,6,0,0,0),(220601,0,'市辖区',3,220600,0,0,'','','',0,0,0,1,0,0,0),(220602,0,'浑江区',3,220600,0,0,'','','',0,0,0,2,0,0,0),(220605,0,'江源区',3,220600,0,0,'','','',0,0,0,3,0,0,0),(220621,0,'抚松县',3,220600,0,0,'','','',0,0,0,4,0,0,0),(220622,0,'靖宇县',3,220600,0,0,'','','',0,0,0,5,0,0,0),(220623,0,'长白朝鲜族自治县',3,220600,0,0,'','','',0,0,0,6,0,0,0),(220681,0,'临江市',3,220600,0,0,'','','',0,0,0,7,0,0,0),(220700,0,'松原市',2,22,0,0,'','','',0,0,7,7,0,0,0),(220701,0,'市辖区',3,220700,0,0,'','','',0,0,0,1,0,0,0),(220702,0,'宁江区',3,220700,0,0,'','','',0,0,0,2,0,0,0),(220721,0,'前郭尔罗斯蒙古族自治县',3,220700,0,0,'','','',0,0,0,3,0,0,0),(220722,0,'长岭县',3,220700,0,0,'','','',0,0,0,4,0,0,0),(220723,0,'乾安县',3,220700,0,0,'','','',0,0,0,5,0,0,0),(220771,0,'吉林松原经济开发区',3,220700,0,0,'','','',0,0,0,6,0,0,0),(220781,0,'扶余市',3,220700,0,0,'','','',0,0,0,7,0,0,0),(220800,0,'白城市',2,22,0,0,'','','',0,0,7,8,0,0,0),(220801,0,'市辖区',3,220800,0,0,'','','',0,0,0,1,0,0,0),(220802,0,'洮北区',3,220800,0,0,'','','',0,0,0,2,0,0,0),(220821,0,'镇赉县',3,220800,0,0,'','','',0,0,0,3,0,0,0),(220822,0,'通榆县',3,220800,0,0,'','','',0,0,0,4,0,0,0),(220871,0,'吉林白城经济开发区',3,220800,0,0,'','','',0,0,0,5,0,0,0),(220881,0,'洮南市',3,220800,0,0,'','','',0,0,0,6,0,0,0),(220882,0,'大安市',3,220800,0,0,'','','',0,0,0,7,0,0,0),(222400,0,'延边朝鲜族自治州',2,22,0,0,'','','',0,0,8,9,0,0,0),(222401,0,'延吉市',3,222400,0,0,'','','',0,0,0,1,0,0,0),(222402,0,'图们市',3,222400,0,0,'','','',0,0,0,2,0,0,0),(222403,0,'敦化市',3,222400,0,0,'','','',0,0,0,3,0,0,0),(222404,0,'珲春市',3,222400,0,0,'','','',0,0,0,4,0,0,0),(222405,0,'龙井市',3,222400,0,0,'','','',0,0,0,5,0,0,0),(222406,0,'和龙市',3,222400,0,0,'','','',0,0,0,6,0,0,0),(222424,0,'汪清县',3,222400,0,0,'','','',0,0,0,7,0,0,0),(222426,0,'安图县',3,222400,0,0,'','','',0,0,0,8,0,0,0),(230100,0,'哈尔滨市',2,23,0,0,'','','',0,0,19,1,0,0,0),(230101,0,'市辖区',3,230100,0,0,'','','',0,0,0,1,0,0,0),(230102,0,'道里区',3,230100,0,0,'','','',0,0,0,2,0,0,0),(230103,0,'南岗区',3,230100,0,0,'','','',0,0,0,3,0,0,0),(230104,0,'道外区',3,230100,0,0,'','','',0,0,0,4,0,0,0),(230108,0,'平房区',3,230100,0,0,'','','',0,0,0,5,0,0,0),(230109,0,'松北区',3,230100,0,0,'','','',0,0,0,6,0,0,0),(230110,0,'香坊区',3,230100,0,0,'','','',0,0,0,7,0,0,0),(230111,0,'呼兰区',3,230100,0,0,'','','',0,0,0,8,0,0,0),(230112,0,'阿城区',3,230100,0,0,'','','',0,0,0,9,0,0,0),(230113,0,'双城区',3,230100,0,0,'','','',0,0,0,10,0,0,0),(230123,0,'依兰县',3,230100,0,0,'','','',0,0,0,11,0,0,0),(230124,0,'方正县',3,230100,0,0,'','','',0,0,0,12,0,0,0),(230125,0,'宾县',3,230100,0,0,'','','',0,0,0,13,0,0,0),(230126,0,'巴彦县',3,230100,0,0,'','','',0,0,0,14,0,0,0),(230127,0,'木兰县',3,230100,0,0,'','','',0,0,0,15,0,0,0),(230128,0,'通河县',3,230100,0,0,'','','',0,0,0,16,0,0,0),(230129,0,'延寿县',3,230100,0,0,'','','',0,0,0,17,0,0,0),(230183,0,'尚志市',3,230100,0,0,'','','',0,0,0,18,0,0,0),(230184,0,'五常市',3,230100,0,0,'','','',0,0,0,19,0,0,0),(230200,0,'齐齐哈尔市',2,23,0,0,'','','',0,0,17,2,0,0,0),(230201,0,'市辖区',3,230200,0,0,'','','',0,0,0,1,0,0,0),(230202,0,'龙沙区',3,230200,0,0,'','','',0,0,0,2,0,0,0),(230203,0,'建华区',3,230200,0,0,'','','',0,0,0,3,0,0,0),(230204,0,'铁锋区',3,230200,0,0,'','','',0,0,0,4,0,0,0),(230205,0,'昂昂溪区',3,230200,0,0,'','','',0,0,0,5,0,0,0),(230206,0,'富拉尔基区',3,230200,0,0,'','','',0,0,0,6,0,0,0),(230207,0,'碾子山区',3,230200,0,0,'','','',0,0,0,7,0,0,0),(230208,0,'梅里斯达斡尔族区',3,230200,0,0,'','','',0,0,0,8,0,0,0),(230221,0,'龙江县',3,230200,0,0,'','','',0,0,0,9,0,0,0),(230223,0,'依安县',3,230200,0,0,'','','',0,0,0,10,0,0,0),(230224,0,'泰来县',3,230200,0,0,'','','',0,0,0,11,0,0,0),(230225,0,'甘南县',3,230200,0,0,'','','',0,0,0,12,0,0,0),(230227,0,'富裕县',3,230200,0,0,'','','',0,0,0,13,0,0,0),(230229,0,'克山县',3,230200,0,0,'','','',0,0,0,14,0,0,0),(230230,0,'克东县',3,230200,0,0,'','','',0,0,0,15,0,0,0),(230231,0,'拜泉县',3,230200,0,0,'','','',0,0,0,16,0,0,0),(230281,0,'讷河市',3,230200,0,0,'','','',0,0,0,17,0,0,0),(230300,0,'鸡西市',2,23,0,0,'','','',0,0,10,3,0,0,0),(230301,0,'市辖区',3,230300,0,0,'','','',0,0,0,1,0,0,0),(230302,0,'鸡冠区',3,230300,0,0,'','','',0,0,0,2,0,0,0),(230303,0,'恒山区',3,230300,0,0,'','','',0,0,0,3,0,0,0),(230304,0,'滴道区',3,230300,0,0,'','','',0,0,0,4,0,0,0),(230305,0,'梨树区',3,230300,0,0,'','','',0,0,0,5,0,0,0),(230306,0,'城子河区',3,230300,0,0,'','','',0,0,0,6,0,0,0),(230307,0,'麻山区',3,230300,0,0,'','','',0,0,0,7,0,0,0),(230321,0,'鸡东县',3,230300,0,0,'','','',0,0,0,8,0,0,0),(230381,0,'虎林市',3,230300,0,0,'','','',0,0,0,9,0,0,0),(230382,0,'密山市',3,230300,0,0,'','','',0,0,0,10,0,0,0),(230400,0,'鹤岗市',2,23,0,0,'','','',0,0,9,4,0,0,0),(230401,0,'市辖区',3,230400,0,0,'','','',0,0,0,1,0,0,0),(230402,0,'向阳区',3,230400,0,0,'','','',0,0,0,2,0,0,0),(230403,0,'工农区',3,230400,0,0,'','','',0,0,0,3,0,0,0),(230404,0,'南山区',3,230400,0,0,'','','',0,0,0,4,0,0,0),(230405,0,'兴安区',3,230400,0,0,'','','',0,0,0,5,0,0,0),(230406,0,'东山区',3,230400,0,0,'','','',0,0,0,6,0,0,0),(230407,0,'兴山区',3,230400,0,0,'','','',0,0,0,7,0,0,0),(230421,0,'萝北县',3,230400,0,0,'','','',0,0,0,8,0,0,0),(230422,0,'绥滨县',3,230400,0,0,'','','',0,0,0,9,0,0,0),(230500,0,'双鸭山市',2,23,0,0,'','','',0,0,9,5,0,0,0),(230501,0,'市辖区',3,230500,0,0,'','','',0,0,0,1,0,0,0),(230502,0,'尖山区',3,230500,0,0,'','','',0,0,0,2,0,0,0),(230503,0,'岭东区',3,230500,0,0,'','','',0,0,0,3,0,0,0),(230505,0,'四方台区',3,230500,0,0,'','','',0,0,0,4,0,0,0),(230506,0,'宝山区',3,230500,0,0,'','','',0,0,0,5,0,0,0),(230521,0,'集贤县',3,230500,0,0,'','','',0,0,0,6,0,0,0),(230522,0,'友谊县',3,230500,0,0,'','','',0,0,0,7,0,0,0),(230523,0,'宝清县',3,230500,0,0,'','','',0,0,0,8,0,0,0),(230524,0,'饶河县',3,230500,0,0,'','','',0,0,0,9,0,0,0),(230600,0,'大庆市',2,23,0,0,'','','',0,0,11,6,0,0,0),(230601,0,'市辖区',3,230600,0,0,'','','',0,0,0,1,0,0,0),(230602,0,'萨尔图区',3,230600,0,0,'','','',0,0,0,2,0,0,0),(230603,0,'龙凤区',3,230600,0,0,'','','',0,0,0,3,0,0,0),(230604,0,'让胡路区',3,230600,0,0,'','','',0,0,0,4,0,0,0),(230605,0,'红岗区',3,230600,0,0,'','','',0,0,0,5,0,0,0),(230606,0,'大同区',3,230600,0,0,'','','',0,0,0,6,0,0,0),(230621,0,'肇州县',3,230600,0,0,'','','',0,0,0,7,0,0,0),(230622,0,'肇源县',3,230600,0,0,'','','',0,0,0,8,0,0,0),(230623,0,'林甸县',3,230600,0,0,'','','',0,0,0,9,0,0,0),(230624,0,'杜尔伯特蒙古族自治县',3,230600,0,0,'','','',0,0,0,10,0,0,0),(230671,0,'大庆高新技术产业开发区',3,230600,0,0,'','','',0,0,0,11,0,0,0),(230700,0,'伊春市',2,23,0,0,'','','',0,0,11,7,0,0,0),(230701,0,'市辖区',3,230700,0,0,'','','',0,0,0,1,0,0,0),(230717,0,'伊美区',3,230700,0,0,'','','',0,0,0,2,0,0,0),(230718,0,'乌翠区',3,230700,0,0,'','','',0,0,0,3,0,0,0),(230719,0,'友好区',3,230700,0,0,'','','',0,0,0,4,0,0,0),(230722,0,'嘉荫县',3,230700,0,0,'','','',0,0,0,5,0,0,0),(230723,0,'汤旺县',3,230700,0,0,'','','',0,0,0,6,0,0,0),(230724,0,'丰林县',3,230700,0,0,'','','',0,0,0,7,0,0,0),(230725,0,'大箐山县',3,230700,0,0,'','','',0,0,0,8,0,0,0),(230726,0,'南岔县',3,230700,0,0,'','','',0,0,0,9,0,0,0),(230751,0,'金林区',3,230700,0,0,'','','',0,0,0,10,0,0,0),(230781,0,'铁力市',3,230700,0,0,'','','',0,0,0,11,0,0,0),(230800,0,'佳木斯市',2,23,0,0,'','','',0,0,11,8,0,0,0),(230801,0,'市辖区',3,230800,0,0,'','','',0,0,0,1,0,0,0),(230803,0,'向阳区',3,230800,0,0,'','','',0,0,0,2,0,0,0),(230804,0,'前进区',3,230800,0,0,'','','',0,0,0,3,0,0,0),(230805,0,'东风区',3,230800,0,0,'','','',0,0,0,4,0,0,0),(230811,0,'郊区',3,230800,0,0,'','','',0,0,0,5,0,0,0),(230822,0,'桦南县',3,230800,0,0,'','','',0,0,0,6,0,0,0),(230826,0,'桦川县',3,230800,0,0,'','','',0,0,0,7,0,0,0),(230828,0,'汤原县',3,230800,0,0,'','','',0,0,0,8,0,0,0),(230881,0,'同江市',3,230800,0,0,'','','',0,0,0,9,0,0,0),(230882,0,'富锦市',3,230800,0,0,'','','',0,0,0,10,0,0,0),(230883,0,'抚远市',3,230800,0,0,'','','',0,0,0,11,0,0,0),(230900,0,'七台河市',2,23,0,0,'','','',0,0,5,9,0,0,0),(230901,0,'市辖区',3,230900,0,0,'','','',0,0,0,1,0,0,0),(230902,0,'新兴区',3,230900,0,0,'','','',0,0,0,2,0,0,0),(230903,0,'桃山区',3,230900,0,0,'','','',0,0,0,3,0,0,0),(230904,0,'茄子河区',3,230900,0,0,'','','',0,0,0,4,0,0,0),(230921,0,'勃利县',3,230900,0,0,'','','',0,0,0,5,0,0,0),(231000,0,'牡丹江市',2,23,0,0,'','','',0,0,12,10,0,0,0),(231001,0,'市辖区',3,231000,0,0,'','','',0,0,0,1,0,0,0),(231002,0,'东安区',3,231000,0,0,'','','',0,0,0,2,0,0,0),(231003,0,'阳明区',3,231000,0,0,'','','',0,0,0,3,0,0,0),(231004,0,'爱民区',3,231000,0,0,'','','',0,0,0,4,0,0,0),(231005,0,'西安区',3,231000,0,0,'','','',0,0,0,5,0,0,0),(231025,0,'林口县',3,231000,0,0,'','','',0,0,0,6,0,0,0),(231071,0,'牡丹江经济技术开发区',3,231000,0,0,'','','',0,0,0,7,0,0,0),(231081,0,'绥芬河市',3,231000,0,0,'','','',0,0,0,8,0,0,0),(231083,0,'海林市',3,231000,0,0,'','','',0,0,0,9,0,0,0),(231084,0,'宁安市',3,231000,0,0,'','','',0,0,0,10,0,0,0),(231085,0,'穆棱市',3,231000,0,0,'','','',0,0,0,11,0,0,0),(231086,0,'东宁市',3,231000,0,0,'','','',0,0,0,12,0,0,0),(231100,0,'黑河市',2,23,0,0,'','','',0,0,7,11,0,0,0),(231101,0,'市辖区',3,231100,0,0,'','','',0,0,0,1,0,0,0),(231102,0,'爱辉区',3,231100,0,0,'','','',0,0,0,2,0,0,0),(231123,0,'逊克县',3,231100,0,0,'','','',0,0,0,3,0,0,0),(231124,0,'孙吴县',3,231100,0,0,'','','',0,0,0,4,0,0,0),(231181,0,'北安市',3,231100,0,0,'','','',0,0,0,5,0,0,0),(231182,0,'五大连池市',3,231100,0,0,'','','',0,0,0,6,0,0,0),(231183,0,'嫩江市',3,231100,0,0,'','','',0,0,0,7,0,0,0),(231200,0,'绥化市',2,23,0,0,'','','',0,0,11,12,0,0,0),(231201,0,'市辖区',3,231200,0,0,'','','',0,0,0,1,0,0,0),(231202,0,'北林区',3,231200,0,0,'','','',0,0,0,2,0,0,0),(231221,0,'望奎县',3,231200,0,0,'','','',0,0,0,3,0,0,0),(231222,0,'兰西县',3,231200,0,0,'','','',0,0,0,4,0,0,0),(231223,0,'青冈县',3,231200,0,0,'','','',0,0,0,5,0,0,0),(231224,0,'庆安县',3,231200,0,0,'','','',0,0,0,6,0,0,0),(231225,0,'明水县',3,231200,0,0,'','','',0,0,0,7,0,0,0),(231226,0,'绥棱县',3,231200,0,0,'','','',0,0,0,8,0,0,0),(231281,0,'安达市',3,231200,0,0,'','','',0,0,0,9,0,0,0),(231282,0,'肇东市',3,231200,0,0,'','','',0,0,0,10,0,0,0),(231283,0,'海伦市',3,231200,0,0,'','','',0,0,0,11,0,0,0),(232700,0,'大兴安岭地区',2,23,0,0,'','','',0,0,7,13,0,0,0),(232701,0,'漠河市',3,232700,0,0,'','','',0,0,0,1,0,0,0),(232721,0,'呼玛县',3,232700,0,0,'','','',0,0,0,2,0,0,0),(232722,0,'塔河县',3,232700,0,0,'','','',0,0,0,3,0,0,0),(232761,0,'加格达奇区',3,232700,0,0,'','','',0,0,0,4,0,0,0),(232762,0,'松岭区',3,232700,0,0,'','','',0,0,0,5,0,0,0),(232763,0,'新林区',3,232700,0,0,'','','',0,0,0,6,0,0,0),(232764,0,'呼中区',3,232700,0,0,'','','',0,0,0,7,0,0,0),(310100,0,'市辖区',2,31,0,0,'','','',0,0,16,1,0,0,0),(310101,0,'黄浦区',3,310100,0,0,'','','',0,0,0,1,0,0,0),(310104,0,'徐汇区',3,310100,0,0,'','','',0,0,0,2,0,0,0),(310105,0,'长宁区',3,310100,0,0,'','','',0,0,0,3,0,0,0),(310106,0,'静安区',3,310100,0,0,'','','',0,0,0,4,0,0,0),(310107,0,'普陀区',3,310100,0,0,'','','',0,0,0,5,0,0,0),(310109,0,'虹口区',3,310100,0,0,'','','',0,0,0,6,0,0,0),(310110,0,'杨浦区',3,310100,0,0,'','','',0,0,0,7,0,0,0),(310112,0,'闵行区',3,310100,0,0,'','','',0,0,0,8,0,0,0),(310113,0,'宝山区',3,310100,0,0,'','','',0,0,0,9,0,0,0),(310114,0,'嘉定区',3,310100,0,0,'','','',0,0,0,10,0,0,0),(310115,0,'浦东新区',3,310100,0,0,'','','',0,0,0,11,0,0,0),(310116,0,'金山区',3,310100,0,0,'','','',0,0,0,12,0,0,0),(310117,0,'松江区',3,310100,0,0,'','','',0,0,0,13,0,0,0),(310118,0,'青浦区',3,310100,0,0,'','','',0,0,0,14,0,0,0),(310120,0,'奉贤区',3,310100,0,0,'','','',0,0,0,15,0,0,0),(310151,0,'崇明区',3,310100,0,0,'','','',0,0,0,16,0,0,0),(320100,0,'南京市',2,32,0,0,'','','',0,0,12,1,0,0,0),(320101,0,'市辖区',3,320100,0,0,'','','',0,0,0,1,0,0,0),(320102,0,'玄武区',3,320100,0,0,'','','',0,0,0,2,0,0,0),(320104,0,'秦淮区',3,320100,0,0,'','','',0,0,0,3,0,0,0),(320105,0,'建邺区',3,320100,0,0,'','','',0,0,0,4,0,0,0),(320106,0,'鼓楼区',3,320100,0,0,'','','',0,0,0,5,0,0,0),(320111,0,'浦口区',3,320100,0,0,'','','',0,0,0,6,0,0,0),(320113,0,'栖霞区',3,320100,0,0,'','','',0,0,0,7,0,0,0),(320114,0,'雨花台区',3,320100,0,0,'','','',0,0,0,8,0,0,0),(320115,0,'江宁区',3,320100,0,0,'','','',0,0,0,9,0,0,0),(320116,0,'六合区',3,320100,0,0,'','','',0,0,0,10,0,0,0),(320117,0,'溧水区',3,320100,0,0,'','','',0,0,0,11,0,0,0),(320118,0,'高淳区',3,320100,0,0,'','','',0,0,0,12,0,0,0),(320200,0,'无锡市',2,32,0,0,'','','',0,0,8,2,0,0,0),(320201,0,'市辖区',3,320200,0,0,'','','',0,0,0,1,0,0,0),(320205,0,'锡山区',3,320200,0,0,'','','',0,0,0,2,0,0,0),(320206,0,'惠山区',3,320200,0,0,'','','',0,0,0,3,0,0,0),(320211,0,'滨湖区',3,320200,0,0,'','','',0,0,0,4,0,0,0),(320213,0,'梁溪区',3,320200,0,0,'','','',0,0,0,5,0,0,0),(320214,0,'新吴区',3,320200,0,0,'','','',0,0,0,6,0,0,0),(320281,0,'江阴市',3,320200,0,0,'','','',0,0,0,7,0,0,0),(320282,0,'宜兴市',3,320200,0,0,'','','',0,0,0,8,0,0,0),(320300,0,'徐州市',2,32,0,0,'','','',0,0,12,3,0,0,0),(320301,0,'市辖区',3,320300,0,0,'','','',0,0,0,1,0,0,0),(320302,0,'鼓楼区',3,320300,0,0,'','','',0,0,0,2,0,0,0),(320303,0,'云龙区',3,320300,0,0,'','','',0,0,0,3,0,0,0),(320305,0,'贾汪区',3,320300,0,0,'','','',0,0,0,4,0,0,0),(320311,0,'泉山区',3,320300,0,0,'','','',0,0,0,5,0,0,0),(320312,0,'铜山区',3,320300,0,0,'','','',0,0,0,6,0,0,0),(320321,0,'丰县',3,320300,0,0,'','','',0,0,0,7,0,0,0),(320322,0,'沛县',3,320300,0,0,'','','',0,0,0,8,0,0,0),(320324,0,'睢宁县',3,320300,0,0,'','','',0,0,0,9,0,0,0),(320371,0,'徐州经济技术开发区',3,320300,0,0,'','','',0,0,0,10,0,0,0),(320381,0,'新沂市',3,320300,0,0,'','','',0,0,0,11,0,0,0),(320382,0,'邳州市',3,320300,0,0,'','','',0,0,0,12,0,0,0),(320400,0,'常州市',2,32,0,0,'','','',0,0,7,4,0,0,0),(320401,0,'市辖区',3,320400,0,0,'','','',0,0,0,1,0,0,0),(320402,0,'天宁区',3,320400,0,0,'','','',0,0,0,2,0,0,0),(320404,0,'钟楼区',3,320400,0,0,'','','',0,0,0,3,0,0,0),(320411,0,'新北区',3,320400,0,0,'','','',0,0,0,4,0,0,0),(320412,0,'武进区',3,320400,0,0,'','','',0,0,0,5,0,0,0),(320413,0,'金坛区',3,320400,0,0,'','','',0,0,0,6,0,0,0),(320481,0,'溧阳市',3,320400,0,0,'','','',0,0,0,7,0,0,0),(320500,0,'苏州市',2,32,0,0,'','','',0,0,11,5,0,0,0),(320501,0,'市辖区',3,320500,0,0,'','','',0,0,0,1,0,0,0),(320505,0,'虎丘区',3,320500,0,0,'','','',0,0,0,2,0,0,0),(320506,0,'吴中区',3,320500,0,0,'','','',0,0,0,3,0,0,0),(320507,0,'相城区',3,320500,0,0,'','','',0,0,0,4,0,0,0),(320508,0,'姑苏区',3,320500,0,0,'','','',0,0,0,5,0,0,0),(320509,0,'吴江区',3,320500,0,0,'','','',0,0,0,6,0,0,0),(320571,0,'苏州工业园区',3,320500,0,0,'','','',0,0,0,7,0,0,0),(320581,0,'常熟市',3,320500,0,0,'','','',0,0,0,8,0,0,0),(320582,0,'张家港市',3,320500,0,0,'','','',0,0,0,9,0,0,0),(320583,0,'昆山市',3,320500,0,0,'','','',0,0,0,10,0,0,0),(320585,0,'太仓市',3,320500,0,0,'','','',0,0,0,11,0,0,0),(320600,0,'南通市',2,32,0,0,'','','',0,0,10,6,0,0,0),(320601,0,'市辖区',3,320600,0,0,'','','',0,0,0,1,0,0,0),(320602,0,'崇川区',3,320600,0,0,'','','',0,0,0,2,0,0,0),(320611,0,'港闸区',3,320600,0,0,'','','',0,0,0,3,0,0,0),(320612,0,'通州区',3,320600,0,0,'','','',0,0,0,4,0,0,0),(320623,0,'如东县',3,320600,0,0,'','','',0,0,0,5,0,0,0),(320671,0,'南通经济技术开发区',3,320600,0,0,'','','',0,0,0,6,0,0,0),(320681,0,'启东市',3,320600,0,0,'','','',0,0,0,7,0,0,0),(320682,0,'如皋市',3,320600,0,0,'','','',0,0,0,8,0,0,0),(320684,0,'海门市',3,320600,0,0,'','','',0,0,0,9,0,0,0),(320685,0,'海安市',3,320600,0,0,'','','',0,0,0,10,0,0,0),(320700,0,'连云港市',2,32,0,0,'','','',0,0,9,7,0,0,0),(320701,0,'市辖区',3,320700,0,0,'','','',0,0,0,1,0,0,0),(320703,0,'连云区',3,320700,0,0,'','','',0,0,0,2,0,0,0),(320706,0,'海州区',3,320700,0,0,'','','',0,0,0,3,0,0,0),(320707,0,'赣榆区',3,320700,0,0,'','','',0,0,0,4,0,0,0),(320722,0,'东海县',3,320700,0,0,'','','',0,0,0,5,0,0,0),(320723,0,'灌云县',3,320700,0,0,'','','',0,0,0,6,0,0,0),(320724,0,'灌南县',3,320700,0,0,'','','',0,0,0,7,0,0,0),(320771,0,'连云港经济技术开发区',3,320700,0,0,'','','',0,0,0,8,0,0,0),(320772,0,'连云港高新技术产业开发区',3,320700,0,0,'','','',0,0,0,9,0,0,0),(320800,0,'淮安市',2,32,0,0,'','','',0,0,9,8,0,0,0),(320801,0,'市辖区',3,320800,0,0,'','','',0,0,0,1,0,0,0),(320803,0,'淮安区',3,320800,0,0,'','','',0,0,0,2,0,0,0),(320804,0,'淮阴区',3,320800,0,0,'','','',0,0,0,3,0,0,0),(320812,0,'清江浦区',3,320800,0,0,'','','',0,0,0,4,0,0,0),(320813,0,'洪泽区',3,320800,0,0,'','','',0,0,0,5,0,0,0),(320826,0,'涟水县',3,320800,0,0,'','','',0,0,0,6,0,0,0),(320830,0,'盱眙县',3,320800,0,0,'','','',0,0,0,7,0,0,0),(320831,0,'金湖县',3,320800,0,0,'','','',0,0,0,8,0,0,0),(320871,0,'淮安经济技术开发区',3,320800,0,0,'','','',0,0,0,9,0,0,0),(320900,0,'盐城市',2,32,0,0,'','','',0,0,11,9,0,0,0),(320901,0,'市辖区',3,320900,0,0,'','','',0,0,0,1,0,0,0),(320902,0,'亭湖区',3,320900,0,0,'','','',0,0,0,2,0,0,0),(320903,0,'盐都区',3,320900,0,0,'','','',0,0,0,3,0,0,0),(320904,0,'大丰区',3,320900,0,0,'','','',0,0,0,4,0,0,0),(320921,0,'响水县',3,320900,0,0,'','','',0,0,0,5,0,0,0),(320922,0,'滨海县',3,320900,0,0,'','','',0,0,0,6,0,0,0),(320923,0,'阜宁县',3,320900,0,0,'','','',0,0,0,7,0,0,0),(320924,0,'射阳县',3,320900,0,0,'','','',0,0,0,8,0,0,0),(320925,0,'建湖县',3,320900,0,0,'','','',0,0,0,9,0,0,0),(320971,0,'盐城经济技术开发区',3,320900,0,0,'','','',0,0,0,10,0,0,0),(320981,0,'东台市',3,320900,0,0,'','','',0,0,0,11,0,0,0),(321000,0,'扬州市',2,32,0,0,'','','',0,0,8,10,0,0,0),(321001,0,'市辖区',3,321000,0,0,'','','',0,0,0,1,0,0,0),(321002,0,'广陵区',3,321000,0,0,'','','',0,0,0,2,0,0,0),(321003,0,'邗江区',3,321000,0,0,'','','',0,0,0,3,0,0,0),(321012,0,'江都区',3,321000,0,0,'','','',0,0,0,4,0,0,0),(321023,0,'宝应县',3,321000,0,0,'','','',0,0,0,5,0,0,0),(321071,0,'扬州经济技术开发区',3,321000,0,0,'','','',0,0,0,6,0,0,0),(321081,0,'仪征市',3,321000,0,0,'','','',0,0,0,7,0,0,0),(321084,0,'高邮市',3,321000,0,0,'','','',0,0,0,8,0,0,0),(321100,0,'镇江市',2,32,0,0,'','','',0,0,8,11,0,0,0),(321101,0,'市辖区',3,321100,0,0,'','','',0,0,0,1,0,0,0),(321102,0,'京口区',3,321100,0,0,'','','',0,0,0,2,0,0,0),(321111,0,'润州区',3,321100,0,0,'','','',0,0,0,3,0,0,0),(321112,0,'丹徒区',3,321100,0,0,'','','',0,0,0,4,0,0,0),(321171,0,'镇江新区',3,321100,0,0,'','','',0,0,0,5,0,0,0),(321181,0,'丹阳市',3,321100,0,0,'','','',0,0,0,6,0,0,0),(321182,0,'扬中市',3,321100,0,0,'','','',0,0,0,7,0,0,0),(321183,0,'句容市',3,321100,0,0,'','','',0,0,0,8,0,0,0),(321200,0,'泰州市',2,32,0,0,'','','',0,0,8,12,0,0,0),(321201,0,'市辖区',3,321200,0,0,'','','',0,0,0,1,0,0,0),(321202,0,'海陵区',3,321200,0,0,'','','',0,0,0,2,0,0,0),(321203,0,'高港区',3,321200,0,0,'','','',0,0,0,3,0,0,0),(321204,0,'姜堰区',3,321200,0,0,'','','',0,0,0,4,0,0,0),(321271,0,'泰州医药高新技术产业开发区',3,321200,0,0,'','','',0,0,0,5,0,0,0),(321281,0,'兴化市',3,321200,0,0,'','','',0,0,0,6,0,0,0),(321282,0,'靖江市',3,321200,0,0,'','','',0,0,0,7,0,0,0),(321283,0,'泰兴市',3,321200,0,0,'','','',0,0,0,8,0,0,0),(321300,0,'宿迁市',2,32,0,0,'','','',0,0,7,13,0,0,0),(321301,0,'市辖区',3,321300,0,0,'','','',0,0,0,1,0,0,0),(321302,0,'宿城区',3,321300,0,0,'','','',0,0,0,2,0,0,0),(321311,0,'宿豫区',3,321300,0,0,'','','',0,0,0,3,0,0,0),(321322,0,'沭阳县',3,321300,0,0,'','','',0,0,0,4,0,0,0),(321323,0,'泗阳县',3,321300,0,0,'','','',0,0,0,5,0,0,0),(321324,0,'泗洪县',3,321300,0,0,'','','',0,0,0,6,0,0,0),(321371,0,'宿迁经济技术开发区',3,321300,0,0,'','','',0,0,0,7,0,0,0),(330100,0,'杭州市',2,33,0,0,'','','',0,0,14,1,0,0,0),(330101,0,'市辖区',3,330100,0,0,'','','',0,0,0,1,0,0,0),(330102,0,'上城区',3,330100,0,0,'','','',0,0,0,2,0,0,0),(330103,0,'下城区',3,330100,0,0,'','','',0,0,0,3,0,0,0),(330104,0,'江干区',3,330100,0,0,'','','',0,0,0,4,0,0,0),(330105,0,'拱墅区',3,330100,0,0,'','','',0,0,0,5,0,0,0),(330106,0,'西湖区',3,330100,0,0,'','','',0,0,0,6,0,0,0),(330108,0,'滨江区',3,330100,0,0,'','','',0,0,0,7,0,0,0),(330109,0,'萧山区',3,330100,0,0,'','','',0,0,0,8,0,0,0),(330110,0,'余杭区',3,330100,0,0,'','','',0,0,0,9,0,0,0),(330111,0,'富阳区',3,330100,0,0,'','','',0,0,0,10,0,0,0),(330112,0,'临安区',3,330100,0,0,'','','',0,0,0,11,0,0,0),(330122,0,'桐庐县',3,330100,0,0,'','','',0,0,0,12,0,0,0),(330127,0,'淳安县',3,330100,0,0,'','','',0,0,0,13,0,0,0),(330182,0,'建德市',3,330100,0,0,'','','',0,0,0,14,0,0,0),(330200,0,'宁波市',2,33,0,0,'','','',0,0,11,2,0,0,0),(330201,0,'市辖区',3,330200,0,0,'','','',0,0,0,1,0,0,0),(330203,0,'海曙区',3,330200,0,0,'','','',0,0,0,2,0,0,0),(330205,0,'江北区',3,330200,0,0,'','','',0,0,0,3,0,0,0),(330206,0,'北仑区',3,330200,0,0,'','','',0,0,0,4,0,0,0),(330211,0,'镇海区',3,330200,0,0,'','','',0,0,0,5,0,0,0),(330212,0,'鄞州区',3,330200,0,0,'','','',0,0,0,6,0,0,0),(330213,0,'奉化区',3,330200,0,0,'','','',0,0,0,7,0,0,0),(330225,0,'象山县',3,330200,0,0,'','','',0,0,0,8,0,0,0),(330226,0,'宁海县',3,330200,0,0,'','','',0,0,0,9,0,0,0),(330281,0,'余姚市',3,330200,0,0,'','','',0,0,0,10,0,0,0),(330282,0,'慈溪市',3,330200,0,0,'','','',0,0,0,11,0,0,0),(330300,0,'温州市',2,33,0,0,'','','',0,0,14,3,0,0,0),(330301,0,'市辖区',3,330300,0,0,'','','',0,0,0,1,0,0,0),(330302,0,'鹿城区',3,330300,0,0,'','','',0,0,0,2,0,0,0),(330303,0,'龙湾区',3,330300,0,0,'','','',0,0,0,3,0,0,0),(330304,0,'瓯海区',3,330300,0,0,'','','',0,0,0,4,0,0,0),(330305,0,'洞头区',3,330300,0,0,'','','',0,0,0,5,0,0,0),(330324,0,'永嘉县',3,330300,0,0,'','','',0,0,0,6,0,0,0),(330326,0,'平阳县',3,330300,0,0,'','','',0,0,0,7,0,0,0),(330327,0,'苍南县',3,330300,0,0,'','','',0,0,0,8,0,0,0),(330328,0,'文成县',3,330300,0,0,'','','',0,0,0,9,0,0,0),(330329,0,'泰顺县',3,330300,0,0,'','','',0,0,0,10,0,0,0),(330371,0,'温州经济技术开发区',3,330300,0,0,'','','',0,0,0,11,0,0,0),(330381,0,'瑞安市',3,330300,0,0,'','','',0,0,0,12,0,0,0),(330382,0,'乐清市',3,330300,0,0,'','','',0,0,0,13,0,0,0),(330383,0,'龙港市',3,330300,0,0,'','','',0,0,0,14,0,0,0),(330400,0,'嘉兴市',2,33,0,0,'','','',0,0,8,4,0,0,0),(330401,0,'市辖区',3,330400,0,0,'','','',0,0,0,1,0,0,0),(330402,0,'南湖区',3,330400,0,0,'','','',0,0,0,2,0,0,0),(330411,0,'秀洲区',3,330400,0,0,'','','',0,0,0,3,0,0,0),(330421,0,'嘉善县',3,330400,0,0,'','','',0,0,0,4,0,0,0),(330424,0,'海盐县',3,330400,0,0,'','','',0,0,0,5,0,0,0),(330481,0,'海宁市',3,330400,0,0,'','','',0,0,0,6,0,0,0),(330482,0,'平湖市',3,330400,0,0,'','','',0,0,0,7,0,0,0),(330483,0,'桐乡市',3,330400,0,0,'','','',0,0,0,8,0,0,0),(330500,0,'湖州市',2,33,0,0,'','','',0,0,6,5,0,0,0),(330501,0,'市辖区',3,330500,0,0,'','','',0,0,0,1,0,0,0),(330502,0,'吴兴区',3,330500,0,0,'','','',0,0,0,2,0,0,0),(330503,0,'南浔区',3,330500,0,0,'','','',0,0,0,3,0,0,0),(330521,0,'德清县',3,330500,0,0,'','','',0,0,0,4,0,0,0),(330522,0,'长兴县',3,330500,0,0,'','','',0,0,0,5,0,0,0),(330523,0,'安吉县',3,330500,0,0,'','','',0,0,0,6,0,0,0),(330600,0,'绍兴市',2,33,0,0,'','','',0,0,7,6,0,0,0),(330601,0,'市辖区',3,330600,0,0,'','','',0,0,0,1,0,0,0),(330602,0,'越城区',3,330600,0,0,'','','',0,0,0,2,0,0,0),(330603,0,'柯桥区',3,330600,0,0,'','','',0,0,0,3,0,0,0),(330604,0,'上虞区',3,330600,0,0,'','','',0,0,0,4,0,0,0),(330624,0,'新昌县',3,330600,0,0,'','','',0,0,0,5,0,0,0),(330681,0,'诸暨市',3,330600,0,0,'','','',0,0,0,6,0,0,0),(330683,0,'嵊州市',3,330600,0,0,'','','',0,0,0,7,0,0,0),(330700,0,'金华市',2,33,0,0,'','','',0,0,10,7,0,0,0),(330701,0,'市辖区',3,330700,0,0,'','','',0,0,0,1,0,0,0),(330702,0,'婺城区',3,330700,0,0,'','','',0,0,0,2,0,0,0),(330703,0,'金东区',3,330700,0,0,'','','',0,0,0,3,0,0,0),(330723,0,'武义县',3,330700,0,0,'','','',0,0,0,4,0,0,0),(330726,0,'浦江县',3,330700,0,0,'','','',0,0,0,5,0,0,0),(330727,0,'磐安县',3,330700,0,0,'','','',0,0,0,6,0,0,0),(330781,0,'兰溪市',3,330700,0,0,'','','',0,0,0,7,0,0,0),(330782,0,'义乌市',3,330700,0,0,'','','',0,0,0,8,0,0,0),(330783,0,'东阳市',3,330700,0,0,'','','',0,0,0,9,0,0,0),(330784,0,'永康市',3,330700,0,0,'','','',0,0,0,10,0,0,0),(330800,0,'衢州市',2,33,0,0,'','','',0,0,7,8,0,0,0),(330801,0,'市辖区',3,330800,0,0,'','','',0,0,0,1,0,0,0),(330802,0,'柯城区',3,330800,0,0,'','','',0,0,0,2,0,0,0),(330803,0,'衢江区',3,330800,0,0,'','','',0,0,0,3,0,0,0),(330822,0,'常山县',3,330800,0,0,'','','',0,0,0,4,0,0,0),(330824,0,'开化县',3,330800,0,0,'','','',0,0,0,5,0,0,0),(330825,0,'龙游县',3,330800,0,0,'','','',0,0,0,6,0,0,0),(330881,0,'江山市',3,330800,0,0,'','','',0,0,0,7,0,0,0),(330900,0,'舟山市',2,33,0,0,'','','',0,0,5,9,0,0,0),(330901,0,'市辖区',3,330900,0,0,'','','',0,0,0,1,0,0,0),(330902,0,'定海区',3,330900,0,0,'','','',0,0,0,2,0,0,0),(330903,0,'普陀区',3,330900,0,0,'','','',0,0,0,3,0,0,0),(330921,0,'岱山县',3,330900,0,0,'','','',0,0,0,4,0,0,0),(330922,0,'嵊泗县',3,330900,0,0,'','','',0,0,0,5,0,0,0),(331000,0,'台州市',2,33,0,0,'','','',0,0,10,10,0,0,0),(331001,0,'市辖区',3,331000,0,0,'','','',0,0,0,1,0,0,0),(331002,0,'椒江区',3,331000,0,0,'','','',0,0,0,2,0,0,0),(331003,0,'黄岩区',3,331000,0,0,'','','',0,0,0,3,0,0,0),(331004,0,'路桥区',3,331000,0,0,'','','',0,0,0,4,0,0,0),(331022,0,'三门县',3,331000,0,0,'','','',0,0,0,5,0,0,0),(331023,0,'天台县',3,331000,0,0,'','','',0,0,0,6,0,0,0),(331024,0,'仙居县',3,331000,0,0,'','','',0,0,0,7,0,0,0),(331081,0,'温岭市',3,331000,0,0,'','','',0,0,0,8,0,0,0),(331082,0,'临海市',3,331000,0,0,'','','',0,0,0,9,0,0,0),(331083,0,'玉环市',3,331000,0,0,'','','',0,0,0,10,0,0,0),(331100,0,'丽水市',2,33,0,0,'','','',0,0,10,11,0,0,0),(331101,0,'市辖区',3,331100,0,0,'','','',0,0,0,1,0,0,0),(331102,0,'莲都区',3,331100,0,0,'','','',0,0,0,2,0,0,0),(331121,0,'青田县',3,331100,0,0,'','','',0,0,0,3,0,0,0),(331122,0,'缙云县',3,331100,0,0,'','','',0,0,0,4,0,0,0),(331123,0,'遂昌县',3,331100,0,0,'','','',0,0,0,5,0,0,0),(331124,0,'松阳县',3,331100,0,0,'','','',0,0,0,6,0,0,0),(331125,0,'云和县',3,331100,0,0,'','','',0,0,0,7,0,0,0),(331126,0,'庆元县',3,331100,0,0,'','','',0,0,0,8,0,0,0),(331127,0,'景宁畲族自治县',3,331100,0,0,'','','',0,0,0,9,0,0,0),(331181,0,'龙泉市',3,331100,0,0,'','','',0,0,0,10,0,0,0),(340100,0,'合肥市',2,34,0,0,'','','',0,0,13,1,0,0,0),(340101,0,'市辖区',3,340100,0,0,'','','',0,0,0,1,0,0,0),(340102,0,'瑶海区',3,340100,0,0,'','','',0,0,0,2,0,0,0),(340103,0,'庐阳区',3,340100,0,0,'','','',0,0,0,3,0,0,0),(340104,0,'蜀山区',3,340100,0,0,'','','',0,0,0,4,0,0,0),(340111,0,'包河区',3,340100,0,0,'','','',0,0,0,5,0,0,0),(340121,0,'长丰县',3,340100,0,0,'','','',0,0,0,6,0,0,0),(340122,0,'肥东县',3,340100,0,0,'','','',0,0,0,7,0,0,0),(340123,0,'肥西县',3,340100,0,0,'','','',0,0,0,8,0,0,0),(340124,0,'庐江县',3,340100,0,0,'','','',0,0,0,9,0,0,0),(340171,0,'合肥高新技术产业开发区',3,340100,0,0,'','','',0,0,0,10,0,0,0),(340172,0,'合肥经济技术开发区',3,340100,0,0,'','','',0,0,0,11,0,0,0),(340173,0,'合肥新站高新技术产业开发区',3,340100,0,0,'','','',0,0,0,12,0,0,0),(340181,0,'巢湖市',3,340100,0,0,'','','',0,0,0,13,0,0,0),(340200,0,'芜湖市',2,34,0,0,'','','',0,0,11,2,0,0,0),(340201,0,'市辖区',3,340200,0,0,'','','',0,0,0,1,0,0,0),(340202,0,'镜湖区',3,340200,0,0,'','','',0,0,0,2,0,0,0),(340203,0,'弋江区',3,340200,0,0,'','','',0,0,0,3,0,0,0),(340207,0,'鸠江区',3,340200,0,0,'','','',0,0,0,4,0,0,0),(340208,0,'三山区',3,340200,0,0,'','','',0,0,0,5,0,0,0),(340221,0,'芜湖县',3,340200,0,0,'','','',0,0,0,6,0,0,0),(340222,0,'繁昌县',3,340200,0,0,'','','',0,0,0,7,0,0,0),(340223,0,'南陵县',3,340200,0,0,'','','',0,0,0,8,0,0,0),(340225,0,'无为县',3,340200,0,0,'','','',0,0,0,9,0,0,0),(340271,0,'芜湖经济技术开发区',3,340200,0,0,'','','',0,0,0,10,0,0,0),(340272,0,'安徽芜湖长江大桥经济开发区',3,340200,0,0,'','','',0,0,0,11,0,0,0),(340300,0,'蚌埠市',2,34,0,0,'','','',0,0,10,3,0,0,0),(340301,0,'市辖区',3,340300,0,0,'','','',0,0,0,1,0,0,0),(340302,0,'龙子湖区',3,340300,0,0,'','','',0,0,0,2,0,0,0),(340303,0,'蚌山区',3,340300,0,0,'','','',0,0,0,3,0,0,0),(340304,0,'禹会区',3,340300,0,0,'','','',0,0,0,4,0,0,0),(340311,0,'淮上区',3,340300,0,0,'','','',0,0,0,5,0,0,0),(340321,0,'怀远县',3,340300,0,0,'','','',0,0,0,6,0,0,0),(340322,0,'五河县',3,340300,0,0,'','','',0,0,0,7,0,0,0),(340323,0,'固镇县',3,340300,0,0,'','','',0,0,0,8,0,0,0),(340371,0,'蚌埠市高新技术开发区',3,340300,0,0,'','','',0,0,0,9,0,0,0),(340372,0,'蚌埠市经济开发区',3,340300,0,0,'','','',0,0,0,10,0,0,0),(340400,0,'淮南市',2,34,0,0,'','','',0,0,8,4,0,0,0),(340401,0,'市辖区',3,340400,0,0,'','','',0,0,0,1,0,0,0),(340402,0,'大通区',3,340400,0,0,'','','',0,0,0,2,0,0,0),(340403,0,'田家庵区',3,340400,0,0,'','','',0,0,0,3,0,0,0),(340404,0,'谢家集区',3,340400,0,0,'','','',0,0,0,4,0,0,0),(340405,0,'八公山区',3,340400,0,0,'','','',0,0,0,5,0,0,0),(340406,0,'潘集区',3,340400,0,0,'','','',0,0,0,6,0,0,0),(340421,0,'凤台县',3,340400,0,0,'','','',0,0,0,7,0,0,0),(340422,0,'寿县',3,340400,0,0,'','','',0,0,0,8,0,0,0),(340500,0,'马鞍山市',2,34,0,0,'','','',0,0,7,5,0,0,0),(340501,0,'市辖区',3,340500,0,0,'','','',0,0,0,1,0,0,0),(340503,0,'花山区',3,340500,0,0,'','','',0,0,0,2,0,0,0),(340504,0,'雨山区',3,340500,0,0,'','','',0,0,0,3,0,0,0),(340506,0,'博望区',3,340500,0,0,'','','',0,0,0,4,0,0,0),(340521,0,'当涂县',3,340500,0,0,'','','',0,0,0,5,0,0,0),(340522,0,'含山县',3,340500,0,0,'','','',0,0,0,6,0,0,0),(340523,0,'和县',3,340500,0,0,'','','',0,0,0,7,0,0,0),(340600,0,'淮北市',2,34,0,0,'','','',0,0,5,6,0,0,0),(340601,0,'市辖区',3,340600,0,0,'','','',0,0,0,1,0,0,0),(340602,0,'杜集区',3,340600,0,0,'','','',0,0,0,2,0,0,0),(340603,0,'相山区',3,340600,0,0,'','','',0,0,0,3,0,0,0),(340604,0,'烈山区',3,340600,0,0,'','','',0,0,0,4,0,0,0),(340621,0,'濉溪县',3,340600,0,0,'','','',0,0,0,5,0,0,0),(340700,0,'铜陵市',2,34,0,0,'','','',0,0,5,7,0,0,0),(340701,0,'市辖区',3,340700,0,0,'','','',0,0,0,1,0,0,0),(340705,0,'铜官区',3,340700,0,0,'','','',0,0,0,2,0,0,0),(340706,0,'义安区',3,340700,0,0,'','','',0,0,0,3,0,0,0),(340711,0,'郊区',3,340700,0,0,'','','',0,0,0,4,0,0,0),(340722,0,'枞阳县',3,340700,0,0,'','','',0,0,0,5,0,0,0),(340800,0,'安庆市',2,34,0,0,'','','',0,0,12,8,0,0,0),(340801,0,'市辖区',3,340800,0,0,'','','',0,0,0,1,0,0,0),(340802,0,'迎江区',3,340800,0,0,'','','',0,0,0,2,0,0,0),(340803,0,'大观区',3,340800,0,0,'','','',0,0,0,3,0,0,0),(340811,0,'宜秀区',3,340800,0,0,'','','',0,0,0,4,0,0,0),(340822,0,'怀宁县',3,340800,0,0,'','','',0,0,0,5,0,0,0),(340825,0,'太湖县',3,340800,0,0,'','','',0,0,0,6,0,0,0),(340826,0,'宿松县',3,340800,0,0,'','','',0,0,0,7,0,0,0),(340827,0,'望江县',3,340800,0,0,'','','',0,0,0,8,0,0,0),(340828,0,'岳西县',3,340800,0,0,'','','',0,0,0,9,0,0,0),(340871,0,'安徽安庆经济开发区',3,340800,0,0,'','','',0,0,0,10,0,0,0),(340881,0,'桐城市',3,340800,0,0,'','','',0,0,0,11,0,0,0),(340882,0,'潜山市',3,340800,0,0,'','','',0,0,0,12,0,0,0),(341000,0,'黄山市',2,34,0,0,'','','',0,0,8,9,0,0,0),(341001,0,'市辖区',3,341000,0,0,'','','',0,0,0,1,0,0,0),(341002,0,'屯溪区',3,341000,0,0,'','','',0,0,0,2,0,0,0),(341003,0,'黄山区',3,341000,0,0,'','','',0,0,0,3,0,0,0),(341004,0,'徽州区',3,341000,0,0,'','','',0,0,0,4,0,0,0),(341021,0,'歙县',3,341000,0,0,'','','',0,0,0,5,0,0,0),(341022,0,'休宁县',3,341000,0,0,'','','',0,0,0,6,0,0,0),(341023,0,'黟县',3,341000,0,0,'','','',0,0,0,7,0,0,0),(341024,0,'祁门县',3,341000,0,0,'','','',0,0,0,8,0,0,0),(341100,0,'滁州市',2,34,0,0,'','','',0,0,11,10,0,0,0),(341101,0,'市辖区',3,341100,0,0,'','','',0,0,0,1,0,0,0),(341102,0,'琅琊区',3,341100,0,0,'','','',0,0,0,2,0,0,0),(341103,0,'南谯区',3,341100,0,0,'','','',0,0,0,3,0,0,0),(341122,0,'来安县',3,341100,0,0,'','','',0,0,0,4,0,0,0),(341124,0,'全椒县',3,341100,0,0,'','','',0,0,0,5,0,0,0),(341125,0,'定远县',3,341100,0,0,'','','',0,0,0,6,0,0,0),(341126,0,'凤阳县',3,341100,0,0,'','','',0,0,0,7,0,0,0),(341171,0,'苏滁现代产业园',3,341100,0,0,'','','',0,0,0,8,0,0,0),(341172,0,'滁州经济技术开发区',3,341100,0,0,'','','',0,0,0,9,0,0,0),(341181,0,'天长市',3,341100,0,0,'','','',0,0,0,10,0,0,0),(341182,0,'明光市',3,341100,0,0,'','','',0,0,0,11,0,0,0),(341200,0,'阜阳市',2,34,0,0,'','','',0,0,11,11,0,0,0),(341201,0,'市辖区',3,341200,0,0,'','','',0,0,0,1,0,0,0),(341202,0,'颍州区',3,341200,0,0,'','','',0,0,0,2,0,0,0),(341203,0,'颍东区',3,341200,0,0,'','','',0,0,0,3,0,0,0),(341204,0,'颍泉区',3,341200,0,0,'','','',0,0,0,4,0,0,0),(341221,0,'临泉县',3,341200,0,0,'','','',0,0,0,5,0,0,0),(341222,0,'太和县',3,341200,0,0,'','','',0,0,0,6,0,0,0),(341225,0,'阜南县',3,341200,0,0,'','','',0,0,0,7,0,0,0),(341226,0,'颍上县',3,341200,0,0,'','','',0,0,0,8,0,0,0),(341271,0,'阜阳合肥现代产业园区',3,341200,0,0,'','','',0,0,0,9,0,0,0),(341272,0,'阜阳经济技术开发区',3,341200,0,0,'','','',0,0,0,10,0,0,0),(341282,0,'界首市',3,341200,0,0,'','','',0,0,0,11,0,0,0),(341300,0,'宿州市',2,34,0,0,'','','',0,0,8,12,0,0,0),(341301,0,'市辖区',3,341300,0,0,'','','',0,0,0,1,0,0,0),(341302,0,'埇桥区',3,341300,0,0,'','','',0,0,0,2,0,0,0),(341321,0,'砀山县',3,341300,0,0,'','','',0,0,0,3,0,0,0),(341322,0,'萧县',3,341300,0,0,'','','',0,0,0,4,0,0,0),(341323,0,'灵璧县',3,341300,0,0,'','','',0,0,0,5,0,0,0),(341324,0,'泗县',3,341300,0,0,'','','',0,0,0,6,0,0,0),(341371,0,'宿州马鞍山现代产业园区',3,341300,0,0,'','','',0,0,0,7,0,0,0),(341372,0,'宿州经济技术开发区',3,341300,0,0,'','','',0,0,0,8,0,0,0),(341500,0,'六安市',2,34,0,0,'','','',0,0,8,13,0,0,0),(341501,0,'市辖区',3,341500,0,0,'','','',0,0,0,1,0,0,0),(341502,0,'金安区',3,341500,0,0,'','','',0,0,0,2,0,0,0),(341503,0,'裕安区',3,341500,0,0,'','','',0,0,0,3,0,0,0),(341504,0,'叶集区',3,341500,0,0,'','','',0,0,0,4,0,0,0),(341522,0,'霍邱县',3,341500,0,0,'','','',0,0,0,5,0,0,0),(341523,0,'舒城县',3,341500,0,0,'','','',0,0,0,6,0,0,0),(341524,0,'金寨县',3,341500,0,0,'','','',0,0,0,7,0,0,0),(341525,0,'霍山县',3,341500,0,0,'','','',0,0,0,8,0,0,0),(341600,0,'亳州市',2,34,0,0,'','','',0,0,5,14,0,0,0),(341601,0,'市辖区',3,341600,0,0,'','','',0,0,0,1,0,0,0),(341602,0,'谯城区',3,341600,0,0,'','','',0,0,0,2,0,0,0),(341621,0,'涡阳县',3,341600,0,0,'','','',0,0,0,3,0,0,0),(341622,0,'蒙城县',3,341600,0,0,'','','',0,0,0,4,0,0,0),(341623,0,'利辛县',3,341600,0,0,'','','',0,0,0,5,0,0,0),(341700,0,'池州市',2,34,0,0,'','','',0,0,5,15,0,0,0),(341701,0,'市辖区',3,341700,0,0,'','','',0,0,0,1,0,0,0),(341702,0,'贵池区',3,341700,0,0,'','','',0,0,0,2,0,0,0),(341721,0,'东至县',3,341700,0,0,'','','',0,0,0,3,0,0,0),(341722,0,'石台县',3,341700,0,0,'','','',0,0,0,4,0,0,0),(341723,0,'青阳县',3,341700,0,0,'','','',0,0,0,5,0,0,0),(341800,0,'宣城市',2,34,0,0,'','','',0,0,9,16,0,0,0),(341801,0,'市辖区',3,341800,0,0,'','','',0,0,0,1,0,0,0),(341802,0,'宣州区',3,341800,0,0,'','','',0,0,0,2,0,0,0),(341821,0,'郎溪县',3,341800,0,0,'','','',0,0,0,3,0,0,0),(341823,0,'泾县',3,341800,0,0,'','','',0,0,0,4,0,0,0),(341824,0,'绩溪县',3,341800,0,0,'','','',0,0,0,5,0,0,0),(341825,0,'旌德县',3,341800,0,0,'','','',0,0,0,6,0,0,0),(341871,0,'宣城市经济开发区',3,341800,0,0,'','','',0,0,0,7,0,0,0),(341881,0,'宁国市',3,341800,0,0,'','','',0,0,0,8,0,0,0),(341882,0,'广德市',3,341800,0,0,'','','',0,0,0,9,0,0,0),(350100,0,'福州市',2,35,0,0,'','','',0,0,14,1,0,0,0),(350101,0,'市辖区',3,350100,0,0,'','','',0,0,0,1,0,0,0),(350102,0,'鼓楼区',3,350100,0,0,'','','',0,0,0,2,0,0,0),(350103,0,'台江区',3,350100,0,0,'','','',0,0,0,3,0,0,0),(350104,0,'仓山区',3,350100,0,0,'','','',0,0,0,4,0,0,0),(350105,0,'马尾区',3,350100,0,0,'','','',0,0,0,5,0,0,0),(350111,0,'晋安区',3,350100,0,0,'','','',0,0,0,6,0,0,0),(350112,0,'长乐区',3,350100,0,0,'','','',0,0,0,7,0,0,0),(350121,0,'闽侯县',3,350100,0,0,'','','',0,0,0,8,0,0,0),(350122,0,'连江县',3,350100,0,0,'','','',0,0,0,9,0,0,0),(350123,0,'罗源县',3,350100,0,0,'','','',0,0,0,10,0,0,0),(350124,0,'闽清县',3,350100,0,0,'','','',0,0,0,11,0,0,0),(350125,0,'永泰县',3,350100,0,0,'','','',0,0,0,12,0,0,0),(350128,0,'平潭县',3,350100,0,0,'','','',0,0,0,13,0,0,0),(350181,0,'福清市',3,350100,0,0,'','','',0,0,0,14,0,0,0),(350200,0,'厦门市',2,35,0,0,'','','',0,0,7,2,0,0,0),(350201,0,'市辖区',3,350200,0,0,'','','',0,0,0,1,0,0,0),(350203,0,'思明区',3,350200,0,0,'','','',0,0,0,2,0,0,0),(350205,0,'海沧区',3,350200,0,0,'','','',0,0,0,3,0,0,0),(350206,0,'湖里区',3,350200,0,0,'','','',0,0,0,4,0,0,0),(350211,0,'集美区',3,350200,0,0,'','','',0,0,0,5,0,0,0),(350212,0,'同安区',3,350200,0,0,'','','',0,0,0,6,0,0,0),(350213,0,'翔安区',3,350200,0,0,'','','',0,0,0,7,0,0,0),(350300,0,'莆田市',2,35,0,0,'','','',0,0,6,3,0,0,0),(350301,0,'市辖区',3,350300,0,0,'','','',0,0,0,1,0,0,0),(350302,0,'城厢区',3,350300,0,0,'','','',0,0,0,2,0,0,0),(350303,0,'涵江区',3,350300,0,0,'','','',0,0,0,3,0,0,0),(350304,0,'荔城区',3,350300,0,0,'','','',0,0,0,4,0,0,0),(350305,0,'秀屿区',3,350300,0,0,'','','',0,0,0,5,0,0,0),(350322,0,'仙游县',3,350300,0,0,'','','',0,0,0,6,0,0,0),(350400,0,'三明市',2,35,0,0,'','','',0,0,13,4,0,0,0),(350401,0,'市辖区',3,350400,0,0,'','','',0,0,0,1,0,0,0),(350402,0,'梅列区',3,350400,0,0,'','','',0,0,0,2,0,0,0),(350403,0,'三元区',3,350400,0,0,'','','',0,0,0,3,0,0,0),(350421,0,'明溪县',3,350400,0,0,'','','',0,0,0,4,0,0,0),(350423,0,'清流县',3,350400,0,0,'','','',0,0,0,5,0,0,0),(350424,0,'宁化县',3,350400,0,0,'','','',0,0,0,6,0,0,0),(350425,0,'大田县',3,350400,0,0,'','','',0,0,0,7,0,0,0),(350426,0,'尤溪县',3,350400,0,0,'','','',0,0,0,8,0,0,0),(350427,0,'沙县',3,350400,0,0,'','','',0,0,0,9,0,0,0),(350428,0,'将乐县',3,350400,0,0,'','','',0,0,0,10,0,0,0),(350429,0,'泰宁县',3,350400,0,0,'','','',0,0,0,11,0,0,0),(350430,0,'建宁县',3,350400,0,0,'','','',0,0,0,12,0,0,0),(350481,0,'永安市',3,350400,0,0,'','','',0,0,0,13,0,0,0),(350500,0,'泉州市',2,35,0,0,'','','',0,0,13,5,0,0,0),(350501,0,'市辖区',3,350500,0,0,'','','',0,0,0,1,0,0,0),(350502,0,'鲤城区',3,350500,0,0,'','','',0,0,0,2,0,0,0),(350503,0,'丰泽区',3,350500,0,0,'','','',0,0,0,3,0,0,0),(350504,0,'洛江区',3,350500,0,0,'','','',0,0,0,4,0,0,0),(350505,0,'泉港区',3,350500,0,0,'','','',0,0,0,5,0,0,0),(350521,0,'惠安县',3,350500,0,0,'','','',0,0,0,6,0,0,0),(350524,0,'安溪县',3,350500,0,0,'','','',0,0,0,7,0,0,0),(350525,0,'永春县',3,350500,0,0,'','','',0,0,0,8,0,0,0),(350526,0,'德化县',3,350500,0,0,'','','',0,0,0,9,0,0,0),(350527,0,'金门县',3,350500,0,0,'','','',0,0,0,10,0,0,0),(350581,0,'石狮市',3,350500,0,0,'','','',0,0,0,11,0,0,0),(350582,0,'晋江市',3,350500,0,0,'','','',0,0,0,12,0,0,0),(350583,0,'南安市',3,350500,0,0,'','','',0,0,0,13,0,0,0),(350600,0,'漳州市',2,35,0,0,'','','',0,0,12,6,0,0,0),(350601,0,'市辖区',3,350600,0,0,'','','',0,0,0,1,0,0,0),(350602,0,'芗城区',3,350600,0,0,'','','',0,0,0,2,0,0,0),(350603,0,'龙文区',3,350600,0,0,'','','',0,0,0,3,0,0,0),(350622,0,'云霄县',3,350600,0,0,'','','',0,0,0,4,0,0,0),(350623,0,'漳浦县',3,350600,0,0,'','','',0,0,0,5,0,0,0),(350624,0,'诏安县',3,350600,0,0,'','','',0,0,0,6,0,0,0),(350625,0,'长泰县',3,350600,0,0,'','','',0,0,0,7,0,0,0),(350626,0,'东山县',3,350600,0,0,'','','',0,0,0,8,0,0,0),(350627,0,'南靖县',3,350600,0,0,'','','',0,0,0,9,0,0,0),(350628,0,'平和县',3,350600,0,0,'','','',0,0,0,10,0,0,0),(350629,0,'华安县',3,350600,0,0,'','','',0,0,0,11,0,0,0),(350681,0,'龙海市',3,350600,0,0,'','','',0,0,0,12,0,0,0),(350700,0,'南平市',2,35,0,0,'','','',0,0,11,7,0,0,0),(350701,0,'市辖区',3,350700,0,0,'','','',0,0,0,1,0,0,0),(350702,0,'延平区',3,350700,0,0,'','','',0,0,0,2,0,0,0),(350703,0,'建阳区',3,350700,0,0,'','','',0,0,0,3,0,0,0),(350721,0,'顺昌县',3,350700,0,0,'','','',0,0,0,4,0,0,0),(350722,0,'浦城县',3,350700,0,0,'','','',0,0,0,5,0,0,0),(350723,0,'光泽县',3,350700,0,0,'','','',0,0,0,6,0,0,0),(350724,0,'松溪县',3,350700,0,0,'','','',0,0,0,7,0,0,0),(350725,0,'政和县',3,350700,0,0,'','','',0,0,0,8,0,0,0),(350781,0,'邵武市',3,350700,0,0,'','','',0,0,0,9,0,0,0),(350782,0,'武夷山市',3,350700,0,0,'','','',0,0,0,10,0,0,0),(350783,0,'建瓯市',3,350700,0,0,'','','',0,0,0,11,0,0,0),(350800,0,'龙岩市',2,35,0,0,'','','',0,0,8,8,0,0,0),(350801,0,'市辖区',3,350800,0,0,'','','',0,0,0,1,0,0,0),(350802,0,'新罗区',3,350800,0,0,'','','',0,0,0,2,0,0,0),(350803,0,'永定区',3,350800,0,0,'','','',0,0,0,3,0,0,0),(350821,0,'长汀县',3,350800,0,0,'','','',0,0,0,4,0,0,0),(350823,0,'上杭县',3,350800,0,0,'','','',0,0,0,5,0,0,0),(350824,0,'武平县',3,350800,0,0,'','','',0,0,0,6,0,0,0),(350825,0,'连城县',3,350800,0,0,'','','',0,0,0,7,0,0,0),(350881,0,'漳平市',3,350800,0,0,'','','',0,0,0,8,0,0,0),(350900,0,'宁德市',2,35,0,0,'','','',0,0,10,9,0,0,0),(350901,0,'市辖区',3,350900,0,0,'','','',0,0,0,1,0,0,0),(350902,0,'蕉城区',3,350900,0,0,'','','',0,0,0,2,0,0,0),(350921,0,'霞浦县',3,350900,0,0,'','','',0,0,0,3,0,0,0),(350922,0,'古田县',3,350900,0,0,'','','',0,0,0,4,0,0,0),(350923,0,'屏南县',3,350900,0,0,'','','',0,0,0,5,0,0,0),(350924,0,'寿宁县',3,350900,0,0,'','','',0,0,0,6,0,0,0),(350925,0,'周宁县',3,350900,0,0,'','','',0,0,0,7,0,0,0),(350926,0,'柘荣县',3,350900,0,0,'','','',0,0,0,8,0,0,0),(350981,0,'福安市',3,350900,0,0,'','','',0,0,0,9,0,0,0),(350982,0,'福鼎市',3,350900,0,0,'','','',0,0,0,10,0,0,0),(360100,0,'南昌市',2,36,0,0,'','','',0,0,10,1,0,0,0),(360101,0,'市辖区',3,360100,0,0,'','','',0,0,0,1,0,0,0),(360102,0,'东湖区',3,360100,0,0,'','','',0,0,0,2,0,0,0),(360103,0,'西湖区',3,360100,0,0,'','','',0,0,0,3,0,0,0),(360104,0,'青云谱区',3,360100,0,0,'','','',0,0,0,4,0,0,0),(360105,0,'湾里区',3,360100,0,0,'','','',0,0,0,5,0,0,0),(360111,0,'青山湖区',3,360100,0,0,'','','',0,0,0,6,0,0,0),(360112,0,'新建区',3,360100,0,0,'','','',0,0,0,7,0,0,0),(360121,0,'南昌县',3,360100,0,0,'','','',0,0,0,8,0,0,0),(360123,0,'安义县',3,360100,0,0,'','','',0,0,0,9,0,0,0),(360124,0,'进贤县',3,360100,0,0,'','','',0,0,0,10,0,0,0),(360200,0,'景德镇市',2,36,0,0,'','','',0,0,5,2,0,0,0),(360201,0,'市辖区',3,360200,0,0,'','','',0,0,0,1,0,0,0),(360202,0,'昌江区',3,360200,0,0,'','','',0,0,0,2,0,0,0),(360203,0,'珠山区',3,360200,0,0,'','','',0,0,0,3,0,0,0),(360222,0,'浮梁县',3,360200,0,0,'','','',0,0,0,4,0,0,0),(360281,0,'乐平市',3,360200,0,0,'','','',0,0,0,5,0,0,0),(360300,0,'萍乡市',2,36,0,0,'','','',0,0,6,3,0,0,0),(360301,0,'市辖区',3,360300,0,0,'','','',0,0,0,1,0,0,0),(360302,0,'安源区',3,360300,0,0,'','','',0,0,0,2,0,0,0),(360313,0,'湘东区',3,360300,0,0,'','','',0,0,0,3,0,0,0),(360321,0,'莲花县',3,360300,0,0,'','','',0,0,0,4,0,0,0),(360322,0,'上栗县',3,360300,0,0,'','','',0,0,0,5,0,0,0),(360323,0,'芦溪县',3,360300,0,0,'','','',0,0,0,6,0,0,0),(360400,0,'九江市',2,36,0,0,'','','',0,0,14,4,0,0,0),(360401,0,'市辖区',3,360400,0,0,'','','',0,0,0,1,0,0,0),(360402,0,'濂溪区',3,360400,0,0,'','','',0,0,0,2,0,0,0),(360403,0,'浔阳区',3,360400,0,0,'','','',0,0,0,3,0,0,0),(360404,0,'柴桑区',3,360400,0,0,'','','',0,0,0,4,0,0,0),(360423,0,'武宁县',3,360400,0,0,'','','',0,0,0,5,0,0,0),(360424,0,'修水县',3,360400,0,0,'','','',0,0,0,6,0,0,0),(360425,0,'永修县',3,360400,0,0,'','','',0,0,0,7,0,0,0),(360426,0,'德安县',3,360400,0,0,'','','',0,0,0,8,0,0,0),(360428,0,'都昌县',3,360400,0,0,'','','',0,0,0,9,0,0,0),(360429,0,'湖口县',3,360400,0,0,'','','',0,0,0,10,0,0,0),(360430,0,'彭泽县',3,360400,0,0,'','','',0,0,0,11,0,0,0),(360481,0,'瑞昌市',3,360400,0,0,'','','',0,0,0,12,0,0,0),(360482,0,'共青城市',3,360400,0,0,'','','',0,0,0,13,0,0,0),(360483,0,'庐山市',3,360400,0,0,'','','',0,0,0,14,0,0,0),(360500,0,'新余市',2,36,0,0,'','','',0,0,3,5,0,0,0),(360501,0,'市辖区',3,360500,0,0,'','','',0,0,0,1,0,0,0),(360502,0,'渝水区',3,360500,0,0,'','','',0,0,0,2,0,0,0),(360521,0,'分宜县',3,360500,0,0,'','','',0,0,0,3,0,0,0),(360600,0,'鹰潭市',2,36,0,0,'','','',0,0,4,6,0,0,0),(360601,0,'市辖区',3,360600,0,0,'','','',0,0,0,1,0,0,0),(360602,0,'月湖区',3,360600,0,0,'','','',0,0,0,2,0,0,0),(360603,0,'余江区',3,360600,0,0,'','','',0,0,0,3,0,0,0),(360681,0,'贵溪市',3,360600,0,0,'','','',0,0,0,4,0,0,0),(360700,0,'赣州市',2,36,0,0,'','','',0,0,19,7,0,0,0),(360701,0,'市辖区',3,360700,0,0,'','','',0,0,0,1,0,0,0),(360702,0,'章贡区',3,360700,0,0,'','','',0,0,0,2,0,0,0),(360703,0,'南康区',3,360700,0,0,'','','',0,0,0,3,0,0,0),(360704,0,'赣县区',3,360700,0,0,'','','',0,0,0,4,0,0,0),(360722,0,'信丰县',3,360700,0,0,'','','',0,0,0,5,0,0,0),(360723,0,'大余县',3,360700,0,0,'','','',0,0,0,6,0,0,0),(360724,0,'上犹县',3,360700,0,0,'','','',0,0,0,7,0,0,0),(360725,0,'崇义县',3,360700,0,0,'','','',0,0,0,8,0,0,0),(360726,0,'安远县',3,360700,0,0,'','','',0,0,0,9,0,0,0),(360727,0,'龙南县',3,360700,0,0,'','','',0,0,0,10,0,0,0),(360728,0,'定南县',3,360700,0,0,'','','',0,0,0,11,0,0,0),(360729,0,'全南县',3,360700,0,0,'','','',0,0,0,12,0,0,0),(360730,0,'宁都县',3,360700,0,0,'','','',0,0,0,13,0,0,0),(360731,0,'于都县',3,360700,0,0,'','','',0,0,0,14,0,0,0),(360732,0,'兴国县',3,360700,0,0,'','','',0,0,0,15,0,0,0),(360733,0,'会昌县',3,360700,0,0,'','','',0,0,0,16,0,0,0),(360734,0,'寻乌县',3,360700,0,0,'','','',0,0,0,17,0,0,0),(360735,0,'石城县',3,360700,0,0,'','','',0,0,0,18,0,0,0),(360781,0,'瑞金市',3,360700,0,0,'','','',0,0,0,19,0,0,0),(360800,0,'吉安市',2,36,0,0,'','','',0,0,14,8,0,0,0),(360801,0,'市辖区',3,360800,0,0,'','','',0,0,0,1,0,0,0),(360802,0,'吉州区',3,360800,0,0,'','','',0,0,0,2,0,0,0),(360803,0,'青原区',3,360800,0,0,'','','',0,0,0,3,0,0,0),(360821,0,'吉安县',3,360800,0,0,'','','',0,0,0,4,0,0,0),(360822,0,'吉水县',3,360800,0,0,'','','',0,0,0,5,0,0,0),(360823,0,'峡江县',3,360800,0,0,'','','',0,0,0,6,0,0,0),(360824,0,'新干县',3,360800,0,0,'','','',0,0,0,7,0,0,0),(360825,0,'永丰县',3,360800,0,0,'','','',0,0,0,8,0,0,0),(360826,0,'泰和县',3,360800,0,0,'','','',0,0,0,9,0,0,0),(360827,0,'遂川县',3,360800,0,0,'','','',0,0,0,10,0,0,0),(360828,0,'万安县',3,360800,0,0,'','','',0,0,0,11,0,0,0),(360829,0,'安福县',3,360800,0,0,'','','',0,0,0,12,0,0,0),(360830,0,'永新县',3,360800,0,0,'','','',0,0,0,13,0,0,0),(360881,0,'井冈山市',3,360800,0,0,'','','',0,0,0,14,0,0,0),(360900,0,'宜春市',2,36,0,0,'','','',0,0,11,9,0,0,0),(360901,0,'市辖区',3,360900,0,0,'','','',0,0,0,1,0,0,0),(360902,0,'袁州区',3,360900,0,0,'','','',0,0,0,2,0,0,0),(360921,0,'奉新县',3,360900,0,0,'','','',0,0,0,3,0,0,0),(360922,0,'万载县',3,360900,0,0,'','','',0,0,0,4,0,0,0),(360923,0,'上高县',3,360900,0,0,'','','',0,0,0,5,0,0,0),(360924,0,'宜丰县',3,360900,0,0,'','','',0,0,0,6,0,0,0),(360925,0,'靖安县',3,360900,0,0,'','','',0,0,0,7,0,0,0),(360926,0,'铜鼓县',3,360900,0,0,'','','',0,0,0,8,0,0,0),(360981,0,'丰城市',3,360900,0,0,'','','',0,0,0,9,0,0,0),(360982,0,'樟树市',3,360900,0,0,'','','',0,0,0,10,0,0,0),(360983,0,'高安市',3,360900,0,0,'','','',0,0,0,11,0,0,0),(361000,0,'抚州市',2,36,0,0,'','','',0,0,12,10,0,0,0),(361001,0,'市辖区',3,361000,0,0,'','','',0,0,0,1,0,0,0),(361002,0,'临川区',3,361000,0,0,'','','',0,0,0,2,0,0,0),(361003,0,'东乡区',3,361000,0,0,'','','',0,0,0,3,0,0,0),(361021,0,'南城县',3,361000,0,0,'','','',0,0,0,4,0,0,0),(361022,0,'黎川县',3,361000,0,0,'','','',0,0,0,5,0,0,0),(361023,0,'南丰县',3,361000,0,0,'','','',0,0,0,6,0,0,0),(361024,0,'崇仁县',3,361000,0,0,'','','',0,0,0,7,0,0,0),(361025,0,'乐安县',3,361000,0,0,'','','',0,0,0,8,0,0,0),(361026,0,'宜黄县',3,361000,0,0,'','','',0,0,0,9,0,0,0),(361027,0,'金溪县',3,361000,0,0,'','','',0,0,0,10,0,0,0),(361028,0,'资溪县',3,361000,0,0,'','','',0,0,0,11,0,0,0),(361030,0,'广昌县',3,361000,0,0,'','','',0,0,0,12,0,0,0),(361100,0,'上饶市',2,36,0,0,'','','',0,0,13,11,0,0,0),(361101,0,'市辖区',3,361100,0,0,'','','',0,0,0,1,0,0,0),(361102,0,'信州区',3,361100,0,0,'','','',0,0,0,2,0,0,0),(361103,0,'广丰区',3,361100,0,0,'','','',0,0,0,3,0,0,0),(361104,0,'广信区',3,361100,0,0,'','','',0,0,0,4,0,0,0),(361123,0,'玉山县',3,361100,0,0,'','','',0,0,0,5,0,0,0),(361124,0,'铅山县',3,361100,0,0,'','','',0,0,0,6,0,0,0),(361125,0,'横峰县',3,361100,0,0,'','','',0,0,0,7,0,0,0),(361126,0,'弋阳县',3,361100,0,0,'','','',0,0,0,8,0,0,0),(361127,0,'余干县',3,361100,0,0,'','','',0,0,0,9,0,0,0),(361128,0,'鄱阳县',3,361100,0,0,'','','',0,0,0,10,0,0,0),(361129,0,'万年县',3,361100,0,0,'','','',0,0,0,11,0,0,0),(361130,0,'婺源县',3,361100,0,0,'','','',0,0,0,12,0,0,0),(361181,0,'德兴市',3,361100,0,0,'','','',0,0,0,13,0,0,0),(370100,0,'济南市',2,37,0,0,'','','',0,0,14,1,0,0,0),(370101,0,'市辖区',3,370100,0,0,'','','',0,0,0,1,0,0,0),(370102,0,'历下区',3,370100,0,0,'','','',0,0,0,2,0,0,0),(370103,0,'市中区',3,370100,0,0,'','','',0,0,0,3,0,0,0),(370104,0,'槐荫区',3,370100,0,0,'','','',0,0,0,4,0,0,0),(370105,0,'天桥区',3,370100,0,0,'','','',0,0,0,5,0,0,0),(370112,0,'历城区',3,370100,0,0,'','','',0,0,0,6,0,0,0),(370113,0,'长清区',3,370100,0,0,'','','',0,0,0,7,0,0,0),(370114,0,'章丘区',3,370100,0,0,'','','',0,0,0,8,0,0,0),(370115,0,'济阳区',3,370100,0,0,'','','',0,0,0,9,0,0,0),(370116,0,'莱芜区',3,370100,0,0,'','','',0,0,0,10,0,0,0),(370117,0,'钢城区',3,370100,0,0,'','','',0,0,0,11,0,0,0),(370124,0,'平阴县',3,370100,0,0,'','','',0,0,0,12,0,0,0),(370126,0,'商河县',3,370100,0,0,'','','',0,0,0,13,0,0,0),(370171,0,'济南高新技术产业开发区',3,370100,0,0,'','','',0,0,0,14,0,0,0),(370200,0,'青岛市',2,37,0,0,'','','',0,0,12,2,0,0,0),(370201,0,'市辖区',3,370200,0,0,'','','',0,0,0,1,0,0,0),(370202,0,'市南区',3,370200,0,0,'','','',0,0,0,2,0,0,0),(370203,0,'市北区',3,370200,0,0,'','','',0,0,0,3,0,0,0),(370211,0,'黄岛区',3,370200,0,0,'','','',0,0,0,4,0,0,0),(370212,0,'崂山区',3,370200,0,0,'','','',0,0,0,5,0,0,0),(370213,0,'李沧区',3,370200,0,0,'','','',0,0,0,6,0,0,0),(370214,0,'城阳区',3,370200,0,0,'','','',0,0,0,7,0,0,0),(370215,0,'即墨区',3,370200,0,0,'','','',0,0,0,8,0,0,0),(370271,0,'青岛高新技术产业开发区',3,370200,0,0,'','','',0,0,0,9,0,0,0),(370281,0,'胶州市',3,370200,0,0,'','','',0,0,0,10,0,0,0),(370283,0,'平度市',3,370200,0,0,'','','',0,0,0,11,0,0,0),(370285,0,'莱西市',3,370200,0,0,'','','',0,0,0,12,0,0,0),(370300,0,'淄博市',2,37,0,0,'','','',0,0,9,3,0,0,0),(370301,0,'市辖区',3,370300,0,0,'','','',0,0,0,1,0,0,0),(370302,0,'淄川区',3,370300,0,0,'','','',0,0,0,2,0,0,0),(370303,0,'张店区',3,370300,0,0,'','','',0,0,0,3,0,0,0),(370304,0,'博山区',3,370300,0,0,'','','',0,0,0,4,0,0,0),(370305,0,'临淄区',3,370300,0,0,'','','',0,0,0,5,0,0,0),(370306,0,'周村区',3,370300,0,0,'','','',0,0,0,6,0,0,0),(370321,0,'桓台县',3,370300,0,0,'','','',0,0,0,7,0,0,0),(370322,0,'高青县',3,370300,0,0,'','','',0,0,0,8,0,0,0),(370323,0,'沂源县',3,370300,0,0,'','','',0,0,0,9,0,0,0),(370400,0,'枣庄市',2,37,0,0,'','','',0,0,7,4,0,0,0),(370401,0,'市辖区',3,370400,0,0,'','','',0,0,0,1,0,0,0),(370402,0,'市中区',3,370400,0,0,'','','',0,0,0,2,0,0,0),(370403,0,'薛城区',3,370400,0,0,'','','',0,0,0,3,0,0,0),(370404,0,'峄城区',3,370400,0,0,'','','',0,0,0,4,0,0,0),(370405,0,'台儿庄区',3,370400,0,0,'','','',0,0,0,5,0,0,0),(370406,0,'山亭区',3,370400,0,0,'','','',0,0,0,6,0,0,0),(370481,0,'滕州市',3,370400,0,0,'','','',0,0,0,7,0,0,0),(370500,0,'东营市',2,37,0,0,'','','',0,0,8,5,0,0,0),(370501,0,'市辖区',3,370500,0,0,'','','',0,0,0,1,0,0,0),(370502,0,'东营区',3,370500,0,0,'','','',0,0,0,2,0,0,0),(370503,0,'河口区',3,370500,0,0,'','','',0,0,0,3,0,0,0),(370505,0,'垦利区',3,370500,0,0,'','','',0,0,0,4,0,0,0),(370522,0,'利津县',3,370500,0,0,'','','',0,0,0,5,0,0,0),(370523,0,'广饶县',3,370500,0,0,'','','',0,0,0,6,0,0,0),(370571,0,'东营经济技术开发区',3,370500,0,0,'','','',0,0,0,7,0,0,0),(370572,0,'东营港经济开发区',3,370500,0,0,'','','',0,0,0,8,0,0,0),(370600,0,'烟台市',2,37,0,0,'','','',0,0,15,6,0,0,0),(370601,0,'市辖区',3,370600,0,0,'','','',0,0,0,1,0,0,0),(370602,0,'芝罘区',3,370600,0,0,'','','',0,0,0,2,0,0,0),(370611,0,'福山区',3,370600,0,0,'','','',0,0,0,3,0,0,0),(370612,0,'牟平区',3,370600,0,0,'','','',0,0,0,4,0,0,0),(370613,0,'莱山区',3,370600,0,0,'','','',0,0,0,5,0,0,0),(370634,0,'长岛县',3,370600,0,0,'','','',0,0,0,6,0,0,0),(370671,0,'烟台高新技术产业开发区',3,370600,0,0,'','','',0,0,0,7,0,0,0),(370672,0,'烟台经济技术开发区',3,370600,0,0,'','','',0,0,0,8,0,0,0),(370681,0,'龙口市',3,370600,0,0,'','','',0,0,0,9,0,0,0),(370682,0,'莱阳市',3,370600,0,0,'','','',0,0,0,10,0,0,0),(370683,0,'莱州市',3,370600,0,0,'','','',0,0,0,11,0,0,0),(370684,0,'蓬莱市',3,370600,0,0,'','','',0,0,0,12,0,0,0),(370685,0,'招远市',3,370600,0,0,'','','',0,0,0,13,0,0,0),(370686,0,'栖霞市',3,370600,0,0,'','','',0,0,0,14,0,0,0),(370687,0,'海阳市',3,370600,0,0,'','','',0,0,0,15,0,0,0),(370700,0,'潍坊市',2,37,0,0,'','','',0,0,14,7,0,0,0),(370701,0,'市辖区',3,370700,0,0,'','','',0,0,0,1,0,0,0),(370702,0,'潍城区',3,370700,0,0,'','','',0,0,0,2,0,0,0),(370703,0,'寒亭区',3,370700,0,0,'','','',0,0,0,3,0,0,0),(370704,0,'坊子区',3,370700,0,0,'','','',0,0,0,4,0,0,0),(370705,0,'奎文区',3,370700,0,0,'','','',0,0,0,5,0,0,0),(370724,0,'临朐县',3,370700,0,0,'','','',0,0,0,6,0,0,0),(370725,0,'昌乐县',3,370700,0,0,'','','',0,0,0,7,0,0,0),(370772,0,'潍坊滨海经济技术开发区',3,370700,0,0,'','','',0,0,0,8,0,0,0),(370781,0,'青州市',3,370700,0,0,'','','',0,0,0,9,0,0,0),(370782,0,'诸城市',3,370700,0,0,'','','',0,0,0,10,0,0,0),(370783,0,'寿光市',3,370700,0,0,'','','',0,0,0,11,0,0,0),(370784,0,'安丘市',3,370700,0,0,'','','',0,0,0,12,0,0,0),(370785,0,'高密市',3,370700,0,0,'','','',0,0,0,13,0,0,0),(370786,0,'昌邑市',3,370700,0,0,'','','',0,0,0,14,0,0,0),(370800,0,'济宁市',2,37,0,0,'','','',0,0,13,8,0,0,0),(370801,0,'市辖区',3,370800,0,0,'','','',0,0,0,1,0,0,0),(370811,0,'任城区',3,370800,0,0,'','','',0,0,0,2,0,0,0),(370812,0,'兖州区',3,370800,0,0,'','','',0,0,0,3,0,0,0),(370826,0,'微山县',3,370800,0,0,'','','',0,0,0,4,0,0,0),(370827,0,'鱼台县',3,370800,0,0,'','','',0,0,0,5,0,0,0),(370828,0,'金乡县',3,370800,0,0,'','','',0,0,0,6,0,0,0),(370829,0,'嘉祥县',3,370800,0,0,'','','',0,0,0,7,0,0,0),(370830,0,'汶上县',3,370800,0,0,'','','',0,0,0,8,0,0,0),(370831,0,'泗水县',3,370800,0,0,'','','',0,0,0,9,0,0,0),(370832,0,'梁山县',3,370800,0,0,'','','',0,0,0,10,0,0,0),(370871,0,'济宁高新技术产业开发区',3,370800,0,0,'','','',0,0,0,11,0,0,0),(370881,0,'曲阜市',3,370800,0,0,'','','',0,0,0,12,0,0,0),(370883,0,'邹城市',3,370800,0,0,'','','',0,0,0,13,0,0,0),(370900,0,'泰安市',2,37,0,0,'','','',0,0,7,9,0,0,0),(370901,0,'市辖区',3,370900,0,0,'','','',0,0,0,1,0,0,0),(370902,0,'泰山区',3,370900,0,0,'','','',0,0,0,2,0,0,0),(370911,0,'岱岳区',3,370900,0,0,'','','',0,0,0,3,0,0,0),(370921,0,'宁阳县',3,370900,0,0,'','','',0,0,0,4,0,0,0),(370923,0,'东平县',3,370900,0,0,'','','',0,0,0,5,0,0,0),(370982,0,'新泰市',3,370900,0,0,'','','',0,0,0,6,0,0,0),(370983,0,'肥城市',3,370900,0,0,'','','',0,0,0,7,0,0,0),(371000,0,'威海市',2,37,0,0,'','','',0,0,8,10,0,0,0),(371001,0,'市辖区',3,371000,0,0,'','','',0,0,0,1,0,0,0),(371002,0,'环翠区',3,371000,0,0,'','','',0,0,0,2,0,0,0),(371003,0,'文登区',3,371000,0,0,'','','',0,0,0,3,0,0,0),(371071,0,'威海火炬高技术产业开发区',3,371000,0,0,'','','',0,0,0,4,0,0,0),(371072,0,'威海经济技术开发区',3,371000,0,0,'','','',0,0,0,5,0,0,0),(371073,0,'威海临港经济技术开发区',3,371000,0,0,'','','',0,0,0,6,0,0,0),(371082,0,'荣成市',3,371000,0,0,'','','',0,0,0,7,0,0,0),(371083,0,'乳山市',3,371000,0,0,'','','',0,0,0,8,0,0,0),(371100,0,'日照市',2,37,0,0,'','','',0,0,6,11,0,0,0),(371101,0,'市辖区',3,371100,0,0,'','','',0,0,0,1,0,0,0),(371102,0,'东港区',3,371100,0,0,'','','',0,0,0,2,0,0,0),(371103,0,'岚山区',3,371100,0,0,'','','',0,0,0,3,0,0,0),(371121,0,'五莲县',3,371100,0,0,'','','',0,0,0,4,0,0,0),(371122,0,'莒县',3,371100,0,0,'','','',0,0,0,5,0,0,0),(371171,0,'日照经济技术开发区',3,371100,0,0,'','','',0,0,0,6,0,0,0),(371300,0,'临沂市',2,37,0,0,'','','',0,0,16,12,0,0,0),(371301,0,'市辖区',3,371300,0,0,'','','',0,0,0,1,0,0,0),(371302,0,'兰山区',3,371300,0,0,'','','',0,0,0,2,0,0,0),(371311,0,'罗庄区',3,371300,0,0,'','','',0,0,0,3,0,0,0),(371312,0,'河东区',3,371300,0,0,'','','',0,0,0,4,0,0,0),(371321,0,'沂南县',3,371300,0,0,'','','',0,0,0,5,0,0,0),(371322,0,'郯城县',3,371300,0,0,'','','',0,0,0,6,0,0,0),(371323,0,'沂水县',3,371300,0,0,'','','',0,0,0,7,0,0,0),(371324,0,'兰陵县',3,371300,0,0,'','','',0,0,0,8,0,0,0),(371325,0,'费县',3,371300,0,0,'','','',0,0,0,9,0,0,0),(371326,0,'平邑县',3,371300,0,0,'','','',0,0,0,10,0,0,0),(371327,0,'莒南县',3,371300,0,0,'','','',0,0,0,11,0,0,0),(371328,0,'蒙阴县',3,371300,0,0,'','','',0,0,0,12,0,0,0),(371329,0,'临沭县',3,371300,0,0,'','','',0,0,0,13,0,0,0),(371371,0,'临沂高新技术产业开发区',3,371300,0,0,'','','',0,0,0,14,0,0,0),(371372,0,'临沂经济技术开发区',3,371300,0,0,'','','',0,0,0,15,0,0,0),(371373,0,'临沂临港经济开发区',3,371300,0,0,'','','',0,0,0,16,0,0,0),(371400,0,'德州市',2,37,0,0,'','','',0,0,14,13,0,0,0),(371401,0,'市辖区',3,371400,0,0,'','','',0,0,0,1,0,0,0),(371402,0,'德城区',3,371400,0,0,'','','',0,0,0,2,0,0,0),(371403,0,'陵城区',3,371400,0,0,'','','',0,0,0,3,0,0,0),(371422,0,'宁津县',3,371400,0,0,'','','',0,0,0,4,0,0,0),(371423,0,'庆云县',3,371400,0,0,'','','',0,0,0,5,0,0,0),(371424,0,'临邑县',3,371400,0,0,'','','',0,0,0,6,0,0,0),(371425,0,'齐河县',3,371400,0,0,'','','',0,0,0,7,0,0,0),(371426,0,'平原县',3,371400,0,0,'','','',0,0,0,8,0,0,0),(371427,0,'夏津县',3,371400,0,0,'','','',0,0,0,9,0,0,0),(371428,0,'武城县',3,371400,0,0,'','','',0,0,0,10,0,0,0),(371471,0,'德州经济技术开发区',3,371400,0,0,'','','',0,0,0,11,0,0,0),(371472,0,'德州运河经济开发区',3,371400,0,0,'','','',0,0,0,12,0,0,0),(371481,0,'乐陵市',3,371400,0,0,'','','',0,0,0,13,0,0,0),(371482,0,'禹城市',3,371400,0,0,'','','',0,0,0,14,0,0,0),(371500,0,'聊城市',2,37,0,0,'','','',0,0,9,14,0,0,0),(371501,0,'市辖区',3,371500,0,0,'','','',0,0,0,1,0,0,0),(371502,0,'东昌府区',3,371500,0,0,'','','',0,0,0,2,0,0,0),(371503,0,'茌平区',3,371500,0,0,'','','',0,0,0,3,0,0,0),(371521,0,'阳谷县',3,371500,0,0,'','','',0,0,0,4,0,0,0),(371522,0,'莘县',3,371500,0,0,'','','',0,0,0,5,0,0,0),(371524,0,'东阿县',3,371500,0,0,'','','',0,0,0,6,0,0,0),(371525,0,'冠县',3,371500,0,0,'','','',0,0,0,7,0,0,0),(371526,0,'高唐县',3,371500,0,0,'','','',0,0,0,8,0,0,0),(371581,0,'临清市',3,371500,0,0,'','','',0,0,0,9,0,0,0),(371600,0,'滨州市',2,37,0,0,'','','',0,0,8,15,0,0,0),(371601,0,'市辖区',3,371600,0,0,'','','',0,0,0,1,0,0,0),(371602,0,'滨城区',3,371600,0,0,'','','',0,0,0,2,0,0,0),(371603,0,'沾化区',3,371600,0,0,'','','',0,0,0,3,0,0,0),(371621,0,'惠民县',3,371600,0,0,'','','',0,0,0,4,0,0,0),(371622,0,'阳信县',3,371600,0,0,'','','',0,0,0,5,0,0,0),(371623,0,'无棣县',3,371600,0,0,'','','',0,0,0,6,0,0,0),(371625,0,'博兴县',3,371600,0,0,'','','',0,0,0,7,0,0,0),(371681,0,'邹平市',3,371600,0,0,'','','',0,0,0,8,0,0,0),(371700,0,'菏泽市',2,37,0,0,'','','',0,0,12,16,0,0,0),(371701,0,'市辖区',3,371700,0,0,'','','',0,0,0,1,0,0,0),(371702,0,'牡丹区',3,371700,0,0,'','','',0,0,0,2,0,0,0),(371703,0,'定陶区',3,371700,0,0,'','','',0,0,0,3,0,0,0),(371721,0,'曹县',3,371700,0,0,'','','',0,0,0,4,0,0,0),(371722,0,'单县',3,371700,0,0,'','','',0,0,0,5,0,0,0),(371723,0,'成武县',3,371700,0,0,'','','',0,0,0,6,0,0,0),(371724,0,'巨野县',3,371700,0,0,'','','',0,0,0,7,0,0,0),(371725,0,'郓城县',3,371700,0,0,'','','',0,0,0,8,0,0,0),(371726,0,'鄄城县',3,371700,0,0,'','','',0,0,0,9,0,0,0),(371728,0,'东明县',3,371700,0,0,'','','',0,0,0,10,0,0,0),(371771,0,'菏泽经济技术开发区',3,371700,0,0,'','','',0,0,0,11,0,0,0),(371772,0,'菏泽高新技术开发区',3,371700,0,0,'','','',0,0,0,12,0,0,0),(410100,0,'郑州市',2,41,0,0,'','','',0,0,16,1,0,0,0),(410101,0,'市辖区',3,410100,0,0,'','','',0,0,0,1,0,0,0),(410102,0,'中原区',3,410100,0,0,'','','',0,0,0,2,0,0,0),(410103,0,'二七区',3,410100,0,0,'','','',0,0,0,3,0,0,0),(410104,0,'管城回族区',3,410100,0,0,'','','',0,0,0,4,0,0,0),(410105,0,'金水区',3,410100,0,0,'','','',0,0,0,5,0,0,0),(410106,0,'上街区',3,410100,0,0,'','','',0,0,0,6,0,0,0),(410108,0,'惠济区',3,410100,0,0,'','','',0,0,0,7,0,0,0),(410122,0,'中牟县',3,410100,0,0,'','','',0,0,0,8,0,0,0),(410171,0,'郑州经济技术开发区',3,410100,0,0,'','','',0,0,0,9,0,0,0),(410172,0,'郑州高新技术产业开发区',3,410100,0,0,'','','',0,0,0,10,0,0,0),(410173,0,'郑州航空港经济综合实验区',3,410100,0,0,'','','',0,0,0,11,0,0,0),(410181,0,'巩义市',3,410100,0,0,'','','',0,0,0,12,0,0,0),(410182,0,'荥阳市',3,410100,0,0,'','','',0,0,0,13,0,0,0),(410183,0,'新密市',3,410100,0,0,'','','',0,0,0,14,0,0,0),(410184,0,'新郑市',3,410100,0,0,'','','',0,0,0,15,0,0,0),(410185,0,'登封市',3,410100,0,0,'','','',0,0,0,16,0,0,0),(410200,0,'开封市',2,41,0,0,'','','',0,0,10,2,0,0,0),(410201,0,'市辖区',3,410200,0,0,'','','',0,0,0,1,0,0,0),(410202,0,'龙亭区',3,410200,0,0,'','','',0,0,0,2,0,0,0),(410203,0,'顺河回族区',3,410200,0,0,'','','',0,0,0,3,0,0,0),(410204,0,'鼓楼区',3,410200,0,0,'','','',0,0,0,4,0,0,0),(410205,0,'禹王台区',3,410200,0,0,'','','',0,0,0,5,0,0,0),(410212,0,'祥符区',3,410200,0,0,'','','',0,0,0,6,0,0,0),(410221,0,'杞县',3,410200,0,0,'','','',0,0,0,7,0,0,0),(410222,0,'通许县',3,410200,0,0,'','','',0,0,0,8,0,0,0),(410223,0,'尉氏县',3,410200,0,0,'','','',0,0,0,9,0,0,0),(410225,0,'兰考县',3,410200,0,0,'','','',0,0,0,10,0,0,0),(410300,0,'洛阳市',2,41,0,0,'','','',0,0,17,3,0,0,0),(410301,0,'市辖区',3,410300,0,0,'','','',0,0,0,1,0,0,0),(410302,0,'老城区',3,410300,0,0,'','','',0,0,0,2,0,0,0),(410303,0,'西工区',3,410300,0,0,'','','',0,0,0,3,0,0,0),(410304,0,'瀍河回族区',3,410300,0,0,'','','',0,0,0,4,0,0,0),(410305,0,'涧西区',3,410300,0,0,'','','',0,0,0,5,0,0,0),(410306,0,'吉利区',3,410300,0,0,'','','',0,0,0,6,0,0,0),(410311,0,'洛龙区',3,410300,0,0,'','','',0,0,0,7,0,0,0),(410322,0,'孟津县',3,410300,0,0,'','','',0,0,0,8,0,0,0),(410323,0,'新安县',3,410300,0,0,'','','',0,0,0,9,0,0,0),(410324,0,'栾川县',3,410300,0,0,'','','',0,0,0,10,0,0,0),(410325,0,'嵩县',3,410300,0,0,'','','',0,0,0,11,0,0,0),(410326,0,'汝阳县',3,410300,0,0,'','','',0,0,0,12,0,0,0),(410327,0,'宜阳县',3,410300,0,0,'','','',0,0,0,13,0,0,0),(410328,0,'洛宁县',3,410300,0,0,'','','',0,0,0,14,0,0,0),(410329,0,'伊川县',3,410300,0,0,'','','',0,0,0,15,0,0,0),(410371,0,'洛阳高新技术产业开发区',3,410300,0,0,'','','',0,0,0,16,0,0,0),(410381,0,'偃师市',3,410300,0,0,'','','',0,0,0,17,0,0,0),(410400,0,'平顶山市',2,41,0,0,'','','',0,0,13,4,0,0,0),(410401,0,'市辖区',3,410400,0,0,'','','',0,0,0,1,0,0,0),(410402,0,'新华区',3,410400,0,0,'','','',0,0,0,2,0,0,0),(410403,0,'卫东区',3,410400,0,0,'','','',0,0,0,3,0,0,0),(410404,0,'石龙区',3,410400,0,0,'','','',0,0,0,4,0,0,0),(410411,0,'湛河区',3,410400,0,0,'','','',0,0,0,5,0,0,0),(410421,0,'宝丰县',3,410400,0,0,'','','',0,0,0,6,0,0,0),(410422,0,'叶县',3,410400,0,0,'','','',0,0,0,7,0,0,0),(410423,0,'鲁山县',3,410400,0,0,'','','',0,0,0,8,0,0,0),(410425,0,'郏县',3,410400,0,0,'','','',0,0,0,9,0,0,0),(410471,0,'平顶山高新技术产业开发区',3,410400,0,0,'','','',0,0,0,10,0,0,0),(410472,0,'平顶山市城乡一体化示范区',3,410400,0,0,'','','',0,0,0,11,0,0,0),(410481,0,'舞钢市',3,410400,0,0,'','','',0,0,0,12,0,0,0),(410482,0,'汝州市',3,410400,0,0,'','','',0,0,0,13,0,0,0),(410500,0,'安阳市',2,41,0,0,'','','',0,0,11,5,0,0,0),(410501,0,'市辖区',3,410500,0,0,'','','',0,0,0,1,0,0,0),(410502,0,'文峰区',3,410500,0,0,'','','',0,0,0,2,0,0,0),(410503,0,'北关区',3,410500,0,0,'','','',0,0,0,3,0,0,0),(410505,0,'殷都区',3,410500,0,0,'','','',0,0,0,4,0,0,0),(410506,0,'龙安区',3,410500,0,0,'','','',0,0,0,5,0,0,0),(410522,0,'安阳县',3,410500,0,0,'','','',0,0,0,6,0,0,0),(410523,0,'汤阴县',3,410500,0,0,'','','',0,0,0,7,0,0,0),(410526,0,'滑县',3,410500,0,0,'','','',0,0,0,8,0,0,0),(410527,0,'内黄县',3,410500,0,0,'','','',0,0,0,9,0,0,0),(410571,0,'安阳高新技术产业开发区',3,410500,0,0,'','','',0,0,0,10,0,0,0),(410581,0,'林州市',3,410500,0,0,'','','',0,0,0,11,0,0,0),(410600,0,'鹤壁市',2,41,0,0,'','','',0,0,7,6,0,0,0),(410601,0,'市辖区',3,410600,0,0,'','','',0,0,0,1,0,0,0),(410602,0,'鹤山区',3,410600,0,0,'','','',0,0,0,2,0,0,0),(410603,0,'山城区',3,410600,0,0,'','','',0,0,0,3,0,0,0),(410611,0,'淇滨区',3,410600,0,0,'','','',0,0,0,4,0,0,0),(410621,0,'浚县',3,410600,0,0,'','','',0,0,0,5,0,0,0),(410622,0,'淇县',3,410600,0,0,'','','',0,0,0,6,0,0,0),(410671,0,'鹤壁经济技术开发区',3,410600,0,0,'','','',0,0,0,7,0,0,0),(410700,0,'新乡市',2,41,0,0,'','','',0,0,16,7,0,0,0),(410701,0,'市辖区',3,410700,0,0,'','','',0,0,0,1,0,0,0),(410702,0,'红旗区',3,410700,0,0,'','','',0,0,0,2,0,0,0),(410703,0,'卫滨区',3,410700,0,0,'','','',0,0,0,3,0,0,0),(410704,0,'凤泉区',3,410700,0,0,'','','',0,0,0,4,0,0,0),(410711,0,'牧野区',3,410700,0,0,'','','',0,0,0,5,0,0,0),(410721,0,'新乡县',3,410700,0,0,'','','',0,0,0,6,0,0,0),(410724,0,'获嘉县',3,410700,0,0,'','','',0,0,0,7,0,0,0),(410725,0,'原阳县',3,410700,0,0,'','','',0,0,0,8,0,0,0),(410726,0,'延津县',3,410700,0,0,'','','',0,0,0,9,0,0,0),(410727,0,'封丘县',3,410700,0,0,'','','',0,0,0,10,0,0,0),(410771,0,'新乡高新技术产业开发区',3,410700,0,0,'','','',0,0,0,11,0,0,0),(410772,0,'新乡经济技术开发区',3,410700,0,0,'','','',0,0,0,12,0,0,0),(410773,0,'新乡市平原城乡一体化示范区',3,410700,0,0,'','','',0,0,0,13,0,0,0),(410781,0,'卫辉市',3,410700,0,0,'','','',0,0,0,14,0,0,0),(410782,0,'辉县市',3,410700,0,0,'','','',0,0,0,15,0,0,0),(410783,0,'长垣市',3,410700,0,0,'','','',0,0,0,16,0,0,0),(410800,0,'焦作市',2,41,0,0,'','','',0,0,12,8,0,0,0),(410801,0,'市辖区',3,410800,0,0,'','','',0,0,0,1,0,0,0),(410802,0,'解放区',3,410800,0,0,'','','',0,0,0,2,0,0,0),(410803,0,'中站区',3,410800,0,0,'','','',0,0,0,3,0,0,0),(410804,0,'马村区',3,410800,0,0,'','','',0,0,0,4,0,0,0),(410811,0,'山阳区',3,410800,0,0,'','','',0,0,0,5,0,0,0),(410821,0,'修武县',3,410800,0,0,'','','',0,0,0,6,0,0,0),(410822,0,'博爱县',3,410800,0,0,'','','',0,0,0,7,0,0,0),(410823,0,'武陟县',3,410800,0,0,'','','',0,0,0,8,0,0,0),(410825,0,'温县',3,410800,0,0,'','','',0,0,0,9,0,0,0),(410871,0,'焦作城乡一体化示范区',3,410800,0,0,'','','',0,0,0,10,0,0,0),(410882,0,'沁阳市',3,410800,0,0,'','','',0,0,0,11,0,0,0),(410883,0,'孟州市',3,410800,0,0,'','','',0,0,0,12,0,0,0),(410900,0,'濮阳市',2,41,0,0,'','','',0,0,9,9,0,0,0),(410901,0,'市辖区',3,410900,0,0,'','','',0,0,0,1,0,0,0),(410902,0,'华龙区',3,410900,0,0,'','','',0,0,0,2,0,0,0),(410922,0,'清丰县',3,410900,0,0,'','','',0,0,0,3,0,0,0),(410923,0,'南乐县',3,410900,0,0,'','','',0,0,0,4,0,0,0),(410926,0,'范县',3,410900,0,0,'','','',0,0,0,5,0,0,0),(410927,0,'台前县',3,410900,0,0,'','','',0,0,0,6,0,0,0),(410928,0,'濮阳县',3,410900,0,0,'','','',0,0,0,7,0,0,0),(410971,0,'河南濮阳工业园区',3,410900,0,0,'','','',0,0,0,8,0,0,0),(410972,0,'濮阳经济技术开发区',3,410900,0,0,'','','',0,0,0,9,0,0,0),(411000,0,'许昌市',2,41,0,0,'','','',0,0,8,10,0,0,0),(411001,0,'市辖区',3,411000,0,0,'','','',0,0,0,1,0,0,0),(411002,0,'魏都区',3,411000,0,0,'','','',0,0,0,2,0,0,0),(411003,0,'建安区',3,411000,0,0,'','','',0,0,0,3,0,0,0),(411024,0,'鄢陵县',3,411000,0,0,'','','',0,0,0,4,0,0,0),(411025,0,'襄城县',3,411000,0,0,'','','',0,0,0,5,0,0,0),(411071,0,'许昌经济技术开发区',3,411000,0,0,'','','',0,0,0,6,0,0,0),(411081,0,'禹州市',3,411000,0,0,'','','',0,0,0,7,0,0,0),(411082,0,'长葛市',3,411000,0,0,'','','',0,0,0,8,0,0,0),(411100,0,'漯河市',2,41,0,0,'','','',0,0,7,11,0,0,0),(411101,0,'市辖区',3,411100,0,0,'','','',0,0,0,1,0,0,0),(411102,0,'源汇区',3,411100,0,0,'','','',0,0,0,2,0,0,0),(411103,0,'郾城区',3,411100,0,0,'','','',0,0,0,3,0,0,0),(411104,0,'召陵区',3,411100,0,0,'','','',0,0,0,4,0,0,0),(411121,0,'舞阳县',3,411100,0,0,'','','',0,0,0,5,0,0,0),(411122,0,'临颍县',3,411100,0,0,'','','',0,0,0,6,0,0,0),(411171,0,'漯河经济技术开发区',3,411100,0,0,'','','',0,0,0,7,0,0,0),(411200,0,'三门峡市',2,41,0,0,'','','',0,0,8,12,0,0,0),(411201,0,'市辖区',3,411200,0,0,'','','',0,0,0,1,0,0,0),(411202,0,'湖滨区',3,411200,0,0,'','','',0,0,0,2,0,0,0),(411203,0,'陕州区',3,411200,0,0,'','','',0,0,0,3,0,0,0),(411221,0,'渑池县',3,411200,0,0,'','','',0,0,0,4,0,0,0),(411224,0,'卢氏县',3,411200,0,0,'','','',0,0,0,5,0,0,0),(411271,0,'河南三门峡经济开发区',3,411200,0,0,'','','',0,0,0,6,0,0,0),(411281,0,'义马市',3,411200,0,0,'','','',0,0,0,7,0,0,0),(411282,0,'灵宝市',3,411200,0,0,'','','',0,0,0,8,0,0,0),(411300,0,'南阳市',2,41,0,0,'','','',0,0,16,13,0,0,0),(411301,0,'市辖区',3,411300,0,0,'','','',0,0,0,1,0,0,0),(411302,0,'宛城区',3,411300,0,0,'','','',0,0,0,2,0,0,0),(411303,0,'卧龙区',3,411300,0,0,'','','',0,0,0,3,0,0,0),(411321,0,'南召县',3,411300,0,0,'','','',0,0,0,4,0,0,0),(411322,0,'方城县',3,411300,0,0,'','','',0,0,0,5,0,0,0),(411323,0,'西峡县',3,411300,0,0,'','','',0,0,0,6,0,0,0),(411324,0,'镇平县',3,411300,0,0,'','','',0,0,0,7,0,0,0),(411325,0,'内乡县',3,411300,0,0,'','','',0,0,0,8,0,0,0),(411326,0,'淅川县',3,411300,0,0,'','','',0,0,0,9,0,0,0),(411327,0,'社旗县',3,411300,0,0,'','','',0,0,0,10,0,0,0),(411328,0,'唐河县',3,411300,0,0,'','','',0,0,0,11,0,0,0),(411329,0,'新野县',3,411300,0,0,'','','',0,0,0,12,0,0,0),(411330,0,'桐柏县',3,411300,0,0,'','','',0,0,0,13,0,0,0),(411371,0,'南阳高新技术产业开发区',3,411300,0,0,'','','',0,0,0,14,0,0,0),(411372,0,'南阳市城乡一体化示范区',3,411300,0,0,'','','',0,0,0,15,0,0,0),(411381,0,'邓州市',3,411300,0,0,'','','',0,0,0,16,0,0,0),(411400,0,'商丘市',2,41,0,0,'','','',0,0,12,14,0,0,0),(411401,0,'市辖区',3,411400,0,0,'','','',0,0,0,1,0,0,0),(411402,0,'梁园区',3,411400,0,0,'','','',0,0,0,2,0,0,0),(411403,0,'睢阳区',3,411400,0,0,'','','',0,0,0,3,0,0,0),(411421,0,'民权县',3,411400,0,0,'','','',0,0,0,4,0,0,0),(411422,0,'睢县',3,411400,0,0,'','','',0,0,0,5,0,0,0),(411423,0,'宁陵县',3,411400,0,0,'','','',0,0,0,6,0,0,0),(411424,0,'柘城县',3,411400,0,0,'','','',0,0,0,7,0,0,0),(411425,0,'虞城县',3,411400,0,0,'','','',0,0,0,8,0,0,0),(411426,0,'夏邑县',3,411400,0,0,'','','',0,0,0,9,0,0,0),(411471,0,'豫东综合物流产业聚集区',3,411400,0,0,'','','',0,0,0,10,0,0,0),(411472,0,'河南商丘经济开发区',3,411400,0,0,'','','',0,0,0,11,0,0,0),(411481,0,'永城市',3,411400,0,0,'','','',0,0,0,12,0,0,0),(411500,0,'信阳市',2,41,0,0,'','','',0,0,12,15,0,0,0),(411501,0,'市辖区',3,411500,0,0,'','','',0,0,0,1,0,0,0),(411502,0,'浉河区',3,411500,0,0,'','','',0,0,0,2,0,0,0),(411503,0,'平桥区',3,411500,0,0,'','','',0,0,0,3,0,0,0),(411521,0,'罗山县',3,411500,0,0,'','','',0,0,0,4,0,0,0),(411522,0,'光山县',3,411500,0,0,'','','',0,0,0,5,0,0,0),(411523,0,'新县',3,411500,0,0,'','','',0,0,0,6,0,0,0),(411524,0,'商城县',3,411500,0,0,'','','',0,0,0,7,0,0,0),(411525,0,'固始县',3,411500,0,0,'','','',0,0,0,8,0,0,0),(411526,0,'潢川县',3,411500,0,0,'','','',0,0,0,9,0,0,0),(411527,0,'淮滨县',3,411500,0,0,'','','',0,0,0,10,0,0,0),(411528,0,'息县',3,411500,0,0,'','','',0,0,0,11,0,0,0),(411571,0,'信阳高新技术产业开发区',3,411500,0,0,'','','',0,0,0,12,0,0,0),(411600,0,'周口市',2,41,0,0,'','','',0,0,12,16,0,0,0),(411601,0,'市辖区',3,411600,0,0,'','','',0,0,0,1,0,0,0),(411602,0,'川汇区',3,411600,0,0,'','','',0,0,0,2,0,0,0),(411603,0,'淮阳区',3,411600,0,0,'','','',0,0,0,3,0,0,0),(411621,0,'扶沟县',3,411600,0,0,'','','',0,0,0,4,0,0,0),(411622,0,'西华县',3,411600,0,0,'','','',0,0,0,5,0,0,0),(411623,0,'商水县',3,411600,0,0,'','','',0,0,0,6,0,0,0),(411624,0,'沈丘县',3,411600,0,0,'','','',0,0,0,7,0,0,0),(411625,0,'郸城县',3,411600,0,0,'','','',0,0,0,8,0,0,0),(411627,0,'太康县',3,411600,0,0,'','','',0,0,0,9,0,0,0),(411628,0,'鹿邑县',3,411600,0,0,'','','',0,0,0,10,0,0,0),(411671,0,'河南周口经济开发区',3,411600,0,0,'','','',0,0,0,11,0,0,0),(411681,0,'项城市',3,411600,0,0,'','','',0,0,0,12,0,0,0),(411700,0,'驻马店市',2,41,0,0,'','','',0,0,12,17,0,0,0),(411701,0,'市辖区',3,411700,0,0,'','','',0,0,0,1,0,0,0),(411702,0,'驿城区',3,411700,0,0,'','','',0,0,0,2,0,0,0),(411721,0,'西平县',3,411700,0,0,'','','',0,0,0,3,0,0,0),(411722,0,'上蔡县',3,411700,0,0,'','','',0,0,0,4,0,0,0),(411723,0,'平舆县',3,411700,0,0,'','','',0,0,0,5,0,0,0),(411724,0,'正阳县',3,411700,0,0,'','','',0,0,0,6,0,0,0),(411725,0,'确山县',3,411700,0,0,'','','',0,0,0,7,0,0,0),(411726,0,'泌阳县',3,411700,0,0,'','','',0,0,0,8,0,0,0),(411727,0,'汝南县',3,411700,0,0,'','','',0,0,0,9,0,0,0),(411728,0,'遂平县',3,411700,0,0,'','','',0,0,0,10,0,0,0),(411729,0,'新蔡县',3,411700,0,0,'','','',0,0,0,11,0,0,0),(411771,0,'河南驻马店经济开发区',3,411700,0,0,'','','',0,0,0,12,0,0,0),(419000,0,'省直辖县级行政区划',2,41,0,0,'','','',0,0,1,18,0,0,0),(419001,0,'济源市',3,419000,0,0,'','','',0,0,0,1,0,0,0),(420100,0,'武汉市',2,42,0,0,'','','',0,0,14,1,0,0,0),(420101,0,'市辖区',3,420100,0,0,'','','',0,0,0,1,0,0,0),(420102,0,'江岸区',3,420100,0,0,'','','',0,0,0,2,0,0,0),(420103,0,'江汉区',3,420100,0,0,'','','',0,0,0,3,0,0,0),(420104,0,'硚口区',3,420100,0,0,'','','',0,0,0,4,0,0,0),(420105,0,'汉阳区',3,420100,0,0,'','','',0,0,0,5,0,0,0),(420106,0,'武昌区',3,420100,0,0,'','','',0,0,0,6,0,0,0),(420107,0,'青山区',3,420100,0,0,'','','',0,0,0,7,0,0,0),(420111,0,'洪山区',3,420100,0,0,'','','',0,0,0,8,0,0,0),(420112,0,'东西湖区',3,420100,0,0,'','','',0,0,0,9,0,0,0),(420113,0,'汉南区',3,420100,0,0,'','','',0,0,0,10,0,0,0),(420114,0,'蔡甸区',3,420100,0,0,'','','',0,0,0,11,0,0,0),(420115,0,'江夏区',3,420100,0,0,'','','',0,0,0,12,0,0,0),(420116,0,'黄陂区',3,420100,0,0,'','','',0,0,0,13,0,0,0),(420117,0,'新洲区',3,420100,0,0,'','','',0,0,0,14,0,0,0),(420200,0,'黄石市',2,42,0,0,'','','',0,0,7,2,0,0,0),(420201,0,'市辖区',3,420200,0,0,'','','',0,0,0,1,0,0,0),(420202,0,'黄石港区',3,420200,0,0,'','','',0,0,0,2,0,0,0),(420203,0,'西塞山区',3,420200,0,0,'','','',0,0,0,3,0,0,0),(420204,0,'下陆区',3,420200,0,0,'','','',0,0,0,4,0,0,0),(420205,0,'铁山区',3,420200,0,0,'','','',0,0,0,5,0,0,0),(420222,0,'阳新县',3,420200,0,0,'','','',0,0,0,6,0,0,0),(420281,0,'大冶市',3,420200,0,0,'','','',0,0,0,7,0,0,0),(420300,0,'十堰市',2,42,0,0,'','','',0,0,9,3,0,0,0),(420301,0,'市辖区',3,420300,0,0,'','','',0,0,0,1,0,0,0),(420302,0,'茅箭区',3,420300,0,0,'','','',0,0,0,2,0,0,0),(420303,0,'张湾区',3,420300,0,0,'','','',0,0,0,3,0,0,0),(420304,0,'郧阳区',3,420300,0,0,'','','',0,0,0,4,0,0,0),(420322,0,'郧西县',3,420300,0,0,'','','',0,0,0,5,0,0,0),(420323,0,'竹山县',3,420300,0,0,'','','',0,0,0,6,0,0,0),(420324,0,'竹溪县',3,420300,0,0,'','','',0,0,0,7,0,0,0),(420325,0,'房县',3,420300,0,0,'','','',0,0,0,8,0,0,0),(420381,0,'丹江口市',3,420300,0,0,'','','',0,0,0,9,0,0,0),(420500,0,'宜昌市',2,42,0,0,'','','',0,0,14,4,0,0,0),(420501,0,'市辖区',3,420500,0,0,'','','',0,0,0,1,0,0,0),(420502,0,'西陵区',3,420500,0,0,'','','',0,0,0,2,0,0,0),(420503,0,'伍家岗区',3,420500,0,0,'','','',0,0,0,3,0,0,0),(420504,0,'点军区',3,420500,0,0,'','','',0,0,0,4,0,0,0),(420505,0,'猇亭区',3,420500,0,0,'','','',0,0,0,5,0,0,0),(420506,0,'夷陵区',3,420500,0,0,'','','',0,0,0,6,0,0,0),(420525,0,'远安县',3,420500,0,0,'','','',0,0,0,7,0,0,0),(420526,0,'兴山县',3,420500,0,0,'','','',0,0,0,8,0,0,0),(420527,0,'秭归县',3,420500,0,0,'','','',0,0,0,9,0,0,0),(420528,0,'长阳土家族自治县',3,420500,0,0,'','','',0,0,0,10,0,0,0),(420529,0,'五峰土家族自治县',3,420500,0,0,'','','',0,0,0,11,0,0,0),(420581,0,'宜都市',3,420500,0,0,'','','',0,0,0,12,0,0,0),(420582,0,'当阳市',3,420500,0,0,'','','',0,0,0,13,0,0,0),(420583,0,'枝江市',3,420500,0,0,'','','',0,0,0,14,0,0,0),(420600,0,'襄阳市',2,42,0,0,'','','',0,0,10,5,0,0,0),(420601,0,'市辖区',3,420600,0,0,'','','',0,0,0,1,0,0,0),(420602,0,'襄城区',3,420600,0,0,'','','',0,0,0,2,0,0,0),(420606,0,'樊城区',3,420600,0,0,'','','',0,0,0,3,0,0,0),(420607,0,'襄州区',3,420600,0,0,'','','',0,0,0,4,0,0,0),(420624,0,'南漳县',3,420600,0,0,'','','',0,0,0,5,0,0,0),(420625,0,'谷城县',3,420600,0,0,'','','',0,0,0,6,0,0,0),(420626,0,'保康县',3,420600,0,0,'','','',0,0,0,7,0,0,0),(420682,0,'老河口市',3,420600,0,0,'','','',0,0,0,8,0,0,0),(420683,0,'枣阳市',3,420600,0,0,'','','',0,0,0,9,0,0,0),(420684,0,'宜城市',3,420600,0,0,'','','',0,0,0,10,0,0,0),(420700,0,'鄂州市',2,42,0,0,'','','',0,0,4,6,0,0,0),(420701,0,'市辖区',3,420700,0,0,'','','',0,0,0,1,0,0,0),(420702,0,'梁子湖区',3,420700,0,0,'','','',0,0,0,2,0,0,0),(420703,0,'华容区',3,420700,0,0,'','','',0,0,0,3,0,0,0),(420704,0,'鄂城区',3,420700,0,0,'','','',0,0,0,4,0,0,0),(420800,0,'荆门市',2,42,0,0,'','','',0,0,6,7,0,0,0),(420801,0,'市辖区',3,420800,0,0,'','','',0,0,0,1,0,0,0),(420802,0,'东宝区',3,420800,0,0,'','','',0,0,0,2,0,0,0),(420804,0,'掇刀区',3,420800,0,0,'','','',0,0,0,3,0,0,0),(420822,0,'沙洋县',3,420800,0,0,'','','',0,0,0,4,0,0,0),(420881,0,'钟祥市',3,420800,0,0,'','','',0,0,0,5,0,0,0),(420882,0,'京山市',3,420800,0,0,'','','',0,0,0,6,0,0,0),(420900,0,'孝感市',2,42,0,0,'','','',0,0,8,8,0,0,0),(420901,0,'市辖区',3,420900,0,0,'','','',0,0,0,1,0,0,0),(420902,0,'孝南区',3,420900,0,0,'','','',0,0,0,2,0,0,0),(420921,0,'孝昌县',3,420900,0,0,'','','',0,0,0,3,0,0,0),(420922,0,'大悟县',3,420900,0,0,'','','',0,0,0,4,0,0,0),(420923,0,'云梦县',3,420900,0,0,'','','',0,0,0,5,0,0,0),(420981,0,'应城市',3,420900,0,0,'','','',0,0,0,6,0,0,0),(420982,0,'安陆市',3,420900,0,0,'','','',0,0,0,7,0,0,0),(420984,0,'汉川市',3,420900,0,0,'','','',0,0,0,8,0,0,0),(421000,0,'荆州市',2,42,0,0,'','','',0,0,10,9,0,0,0),(421001,0,'市辖区',3,421000,0,0,'','','',0,0,0,1,0,0,0),(421002,0,'沙市区',3,421000,0,0,'','','',0,0,0,2,0,0,0),(421003,0,'荆州区',3,421000,0,0,'','','',0,0,0,3,0,0,0),(421022,0,'公安县',3,421000,0,0,'','','',0,0,0,4,0,0,0),(421023,0,'监利县',3,421000,0,0,'','','',0,0,0,5,0,0,0),(421024,0,'江陵县',3,421000,0,0,'','','',0,0,0,6,0,0,0),(421071,0,'荆州经济技术开发区',3,421000,0,0,'','','',0,0,0,7,0,0,0),(421081,0,'石首市',3,421000,0,0,'','','',0,0,0,8,0,0,0),(421083,0,'洪湖市',3,421000,0,0,'','','',0,0,0,9,0,0,0),(421087,0,'松滋市',3,421000,0,0,'','','',0,0,0,10,0,0,0),(421100,0,'黄冈市',2,42,0,0,'','','',0,0,12,10,0,0,0),(421101,0,'市辖区',3,421100,0,0,'','','',0,0,0,1,0,0,0),(421102,0,'黄州区',3,421100,0,0,'','','',0,0,0,2,0,0,0),(421121,0,'团风县',3,421100,0,0,'','','',0,0,0,3,0,0,0),(421122,0,'红安县',3,421100,0,0,'','','',0,0,0,4,0,0,0),(421123,0,'罗田县',3,421100,0,0,'','','',0,0,0,5,0,0,0),(421124,0,'英山县',3,421100,0,0,'','','',0,0,0,6,0,0,0),(421125,0,'浠水县',3,421100,0,0,'','','',0,0,0,7,0,0,0),(421126,0,'蕲春县',3,421100,0,0,'','','',0,0,0,8,0,0,0),(421127,0,'黄梅县',3,421100,0,0,'','','',0,0,0,9,0,0,0),(421171,0,'龙感湖管理区',3,421100,0,0,'','','',0,0,0,10,0,0,0),(421181,0,'麻城市',3,421100,0,0,'','','',0,0,0,11,0,0,0),(421182,0,'武穴市',3,421100,0,0,'','','',0,0,0,12,0,0,0),(421200,0,'咸宁市',2,42,0,0,'','','',0,0,7,11,0,0,0),(421201,0,'市辖区',3,421200,0,0,'','','',0,0,0,1,0,0,0),(421202,0,'咸安区',3,421200,0,0,'','','',0,0,0,2,0,0,0),(421221,0,'嘉鱼县',3,421200,0,0,'','','',0,0,0,3,0,0,0),(421222,0,'通城县',3,421200,0,0,'','','',0,0,0,4,0,0,0),(421223,0,'崇阳县',3,421200,0,0,'','','',0,0,0,5,0,0,0),(421224,0,'通山县',3,421200,0,0,'','','',0,0,0,6,0,0,0),(421281,0,'赤壁市',3,421200,0,0,'','','',0,0,0,7,0,0,0),(421300,0,'随州市',2,42,0,0,'','','',0,0,4,12,0,0,0),(421301,0,'市辖区',3,421300,0,0,'','','',0,0,0,1,0,0,0),(421303,0,'曾都区',3,421300,0,0,'','','',0,0,0,2,0,0,0),(421321,0,'随县',3,421300,0,0,'','','',0,0,0,3,0,0,0),(421381,0,'广水市',3,421300,0,0,'','','',0,0,0,4,0,0,0),(422800,0,'恩施土家族苗族自治州',2,42,0,0,'','','',0,0,8,13,0,0,0),(422801,0,'恩施市',3,422800,0,0,'','','',0,0,0,1,0,0,0),(422802,0,'利川市',3,422800,0,0,'','','',0,0,0,2,0,0,0),(422822,0,'建始县',3,422800,0,0,'','','',0,0,0,3,0,0,0),(422823,0,'巴东县',3,422800,0,0,'','','',0,0,0,4,0,0,0),(422825,0,'宣恩县',3,422800,0,0,'','','',0,0,0,5,0,0,0),(422826,0,'咸丰县',3,422800,0,0,'','','',0,0,0,6,0,0,0),(422827,0,'来凤县',3,422800,0,0,'','','',0,0,0,7,0,0,0),(422828,0,'鹤峰县',3,422800,0,0,'','','',0,0,0,8,0,0,0),(429000,0,'省直辖县级行政区划',2,42,0,0,'','','',0,0,4,14,0,0,0),(429004,0,'仙桃市',3,429000,0,0,'','','',0,0,0,1,0,0,0),(429005,0,'潜江市',3,429000,0,0,'','','',0,0,0,2,0,0,0),(429006,0,'天门市',3,429000,0,0,'','','',0,0,0,3,0,0,0),(429021,0,'神农架林区',3,429000,0,0,'','','',0,0,0,4,0,0,0),(430100,0,'长沙市',2,43,0,0,'','','',0,0,10,1,0,0,0),(430101,0,'市辖区',3,430100,0,0,'','','',0,0,0,1,0,0,0),(430102,0,'芙蓉区',3,430100,0,0,'','','',0,0,0,2,0,0,0),(430103,0,'天心区',3,430100,0,0,'','','',0,0,0,3,0,0,0),(430104,0,'岳麓区',3,430100,0,0,'','','',0,0,0,4,0,0,0),(430105,0,'开福区',3,430100,0,0,'','','',0,0,0,5,0,0,0),(430111,0,'雨花区',3,430100,0,0,'','','',0,0,0,6,0,0,0),(430112,0,'望城区',3,430100,0,0,'','','',0,0,0,7,0,0,0),(430121,0,'长沙县',3,430100,0,0,'','','',0,0,0,8,0,0,0),(430181,0,'浏阳市',3,430100,0,0,'','','',0,0,0,9,0,0,0),(430182,0,'宁乡市',3,430100,0,0,'','','',0,0,0,10,0,0,0),(430200,0,'株洲市',2,43,0,0,'','','',0,0,11,2,0,0,0),(430201,0,'市辖区',3,430200,0,0,'','','',0,0,0,1,0,0,0),(430202,0,'荷塘区',3,430200,0,0,'','','',0,0,0,2,0,0,0),(430203,0,'芦淞区',3,430200,0,0,'','','',0,0,0,3,0,0,0),(430204,0,'石峰区',3,430200,0,0,'','','',0,0,0,4,0,0,0),(430211,0,'天元区',3,430200,0,0,'','','',0,0,0,5,0,0,0),(430212,0,'渌口区',3,430200,0,0,'','','',0,0,0,6,0,0,0),(430223,0,'攸县',3,430200,0,0,'','','',0,0,0,7,0,0,0),(430224,0,'茶陵县',3,430200,0,0,'','','',0,0,0,8,0,0,0),(430225,0,'炎陵县',3,430200,0,0,'','','',0,0,0,9,0,0,0),(430271,0,'云龙示范区',3,430200,0,0,'','','',0,0,0,10,0,0,0),(430281,0,'醴陵市',3,430200,0,0,'','','',0,0,0,11,0,0,0),(430300,0,'湘潭市',2,43,0,0,'','','',0,0,9,3,0,0,0),(430301,0,'市辖区',3,430300,0,0,'','','',0,0,0,1,0,0,0),(430302,0,'雨湖区',3,430300,0,0,'','','',0,0,0,2,0,0,0),(430304,0,'岳塘区',3,430300,0,0,'','','',0,0,0,3,0,0,0),(430321,0,'湘潭县',3,430300,0,0,'','','',0,0,0,4,0,0,0),(430371,0,'湖南湘潭高新技术产业园区',3,430300,0,0,'','','',0,0,0,5,0,0,0),(430372,0,'湘潭昭山示范区',3,430300,0,0,'','','',0,0,0,6,0,0,0),(430373,0,'湘潭九华示范区',3,430300,0,0,'','','',0,0,0,7,0,0,0),(430381,0,'湘乡市',3,430300,0,0,'','','',0,0,0,8,0,0,0),(430382,0,'韶山市',3,430300,0,0,'','','',0,0,0,9,0,0,0),(430400,0,'衡阳市',2,43,0,0,'','','',0,0,16,4,0,0,0),(430401,0,'市辖区',3,430400,0,0,'','','',0,0,0,1,0,0,0),(430405,0,'珠晖区',3,430400,0,0,'','','',0,0,0,2,0,0,0),(430406,0,'雁峰区',3,430400,0,0,'','','',0,0,0,3,0,0,0),(430407,0,'石鼓区',3,430400,0,0,'','','',0,0,0,4,0,0,0),(430408,0,'蒸湘区',3,430400,0,0,'','','',0,0,0,5,0,0,0),(430412,0,'南岳区',3,430400,0,0,'','','',0,0,0,6,0,0,0),(430421,0,'衡阳县',3,430400,0,0,'','','',0,0,0,7,0,0,0),(430422,0,'衡南县',3,430400,0,0,'','','',0,0,0,8,0,0,0),(430423,0,'衡山县',3,430400,0,0,'','','',0,0,0,9,0,0,0),(430424,0,'衡东县',3,430400,0,0,'','','',0,0,0,10,0,0,0),(430426,0,'祁东县',3,430400,0,0,'','','',0,0,0,11,0,0,0),(430471,0,'衡阳综合保税区',3,430400,0,0,'','','',0,0,0,12,0,0,0),(430472,0,'湖南衡阳高新技术产业园区',3,430400,0,0,'','','',0,0,0,13,0,0,0),(430473,0,'湖南衡阳松木经济开发区',3,430400,0,0,'','','',0,0,0,14,0,0,0),(430481,0,'耒阳市',3,430400,0,0,'','','',0,0,0,15,0,0,0),(430482,0,'常宁市',3,430400,0,0,'','','',0,0,0,16,0,0,0),(430500,0,'邵阳市',2,43,0,0,'','','',0,0,13,5,0,0,0),(430501,0,'市辖区',3,430500,0,0,'','','',0,0,0,1,0,0,0),(430502,0,'双清区',3,430500,0,0,'','','',0,0,0,2,0,0,0),(430503,0,'大祥区',3,430500,0,0,'','','',0,0,0,3,0,0,0),(430511,0,'北塔区',3,430500,0,0,'','','',0,0,0,4,0,0,0),(430522,0,'新邵县',3,430500,0,0,'','','',0,0,0,5,0,0,0),(430523,0,'邵阳县',3,430500,0,0,'','','',0,0,0,6,0,0,0),(430524,0,'隆回县',3,430500,0,0,'','','',0,0,0,7,0,0,0),(430525,0,'洞口县',3,430500,0,0,'','','',0,0,0,8,0,0,0),(430527,0,'绥宁县',3,430500,0,0,'','','',0,0,0,9,0,0,0),(430528,0,'新宁县',3,430500,0,0,'','','',0,0,0,10,0,0,0),(430529,0,'城步苗族自治县',3,430500,0,0,'','','',0,0,0,11,0,0,0),(430581,0,'武冈市',3,430500,0,0,'','','',0,0,0,12,0,0,0),(430582,0,'邵东市',3,430500,0,0,'','','',0,0,0,13,0,0,0),(430600,0,'岳阳市',2,43,0,0,'','','',0,0,11,6,0,0,0),(430601,0,'市辖区',3,430600,0,0,'','','',0,0,0,1,0,0,0),(430602,0,'岳阳楼区',3,430600,0,0,'','','',0,0,0,2,0,0,0),(430603,0,'云溪区',3,430600,0,0,'','','',0,0,0,3,0,0,0),(430611,0,'君山区',3,430600,0,0,'','','',0,0,0,4,0,0,0),(430621,0,'岳阳县',3,430600,0,0,'','','',0,0,0,5,0,0,0),(430623,0,'华容县',3,430600,0,0,'','','',0,0,0,6,0,0,0),(430624,0,'湘阴县',3,430600,0,0,'','','',0,0,0,7,0,0,0),(430626,0,'平江县',3,430600,0,0,'','','',0,0,0,8,0,0,0),(430671,0,'岳阳市屈原管理区',3,430600,0,0,'','','',0,0,0,9,0,0,0),(430681,0,'汨罗市',3,430600,0,0,'','','',0,0,0,10,0,0,0),(430682,0,'临湘市',3,430600,0,0,'','','',0,0,0,11,0,0,0),(430700,0,'常德市',2,43,0,0,'','','',0,0,11,7,0,0,0),(430701,0,'市辖区',3,430700,0,0,'','','',0,0,0,1,0,0,0),(430702,0,'武陵区',3,430700,0,0,'','','',0,0,0,2,0,0,0),(430703,0,'鼎城区',3,430700,0,0,'','','',0,0,0,3,0,0,0),(430721,0,'安乡县',3,430700,0,0,'','','',0,0,0,4,0,0,0),(430722,0,'汉寿县',3,430700,0,0,'','','',0,0,0,5,0,0,0),(430723,0,'澧县',3,430700,0,0,'','','',0,0,0,6,0,0,0),(430724,0,'临澧县',3,430700,0,0,'','','',0,0,0,7,0,0,0),(430725,0,'桃源县',3,430700,0,0,'','','',0,0,0,8,0,0,0),(430726,0,'石门县',3,430700,0,0,'','','',0,0,0,9,0,0,0),(430771,0,'常德市西洞庭管理区',3,430700,0,0,'','','',0,0,0,10,0,0,0),(430781,0,'津市市',3,430700,0,0,'','','',0,0,0,11,0,0,0),(430800,0,'张家界市',2,43,0,0,'','','',0,0,5,8,0,0,0),(430801,0,'市辖区',3,430800,0,0,'','','',0,0,0,1,0,0,0),(430802,0,'永定区',3,430800,0,0,'','','',0,0,0,2,0,0,0),(430811,0,'武陵源区',3,430800,0,0,'','','',0,0,0,3,0,0,0),(430821,0,'慈利县',3,430800,0,0,'','','',0,0,0,4,0,0,0),(430822,0,'桑植县',3,430800,0,0,'','','',0,0,0,5,0,0,0),(430900,0,'益阳市',2,43,0,0,'','','',0,0,9,9,0,0,0),(430901,0,'市辖区',3,430900,0,0,'','','',0,0,0,1,0,0,0),(430902,0,'资阳区',3,430900,0,0,'','','',0,0,0,2,0,0,0),(430903,0,'赫山区',3,430900,0,0,'','','',0,0,0,3,0,0,0),(430921,0,'南县',3,430900,0,0,'','','',0,0,0,4,0,0,0),(430922,0,'桃江县',3,430900,0,0,'','','',0,0,0,5,0,0,0),(430923,0,'安化县',3,430900,0,0,'','','',0,0,0,6,0,0,0),(430971,0,'益阳市大通湖管理区',3,430900,0,0,'','','',0,0,0,7,0,0,0),(430972,0,'湖南益阳高新技术产业园区',3,430900,0,0,'','','',0,0,0,8,0,0,0),(430981,0,'沅江市',3,430900,0,0,'','','',0,0,0,9,0,0,0),(431000,0,'郴州市',2,43,0,0,'','','',0,0,12,10,0,0,0),(431001,0,'市辖区',3,431000,0,0,'','','',0,0,0,1,0,0,0),(431002,0,'北湖区',3,431000,0,0,'','','',0,0,0,2,0,0,0),(431003,0,'苏仙区',3,431000,0,0,'','','',0,0,0,3,0,0,0),(431021,0,'桂阳县',3,431000,0,0,'','','',0,0,0,4,0,0,0),(431022,0,'宜章县',3,431000,0,0,'','','',0,0,0,5,0,0,0),(431023,0,'永兴县',3,431000,0,0,'','','',0,0,0,6,0,0,0),(431024,0,'嘉禾县',3,431000,0,0,'','','',0,0,0,7,0,0,0),(431025,0,'临武县',3,431000,0,0,'','','',0,0,0,8,0,0,0),(431026,0,'汝城县',3,431000,0,0,'','','',0,0,0,9,0,0,0),(431027,0,'桂东县',3,431000,0,0,'','','',0,0,0,10,0,0,0),(431028,0,'安仁县',3,431000,0,0,'','','',0,0,0,11,0,0,0),(431081,0,'资兴市',3,431000,0,0,'','','',0,0,0,12,0,0,0),(431100,0,'永州市',2,43,0,0,'','','',0,0,15,11,0,0,0),(431101,0,'市辖区',3,431100,0,0,'','','',0,0,0,1,0,0,0),(431102,0,'零陵区',3,431100,0,0,'','','',0,0,0,2,0,0,0),(431103,0,'冷水滩区',3,431100,0,0,'','','',0,0,0,3,0,0,0),(431121,0,'祁阳县',3,431100,0,0,'','','',0,0,0,4,0,0,0),(431122,0,'东安县',3,431100,0,0,'','','',0,0,0,5,0,0,0),(431123,0,'双牌县',3,431100,0,0,'','','',0,0,0,6,0,0,0),(431124,0,'道县',3,431100,0,0,'','','',0,0,0,7,0,0,0),(431125,0,'江永县',3,431100,0,0,'','','',0,0,0,8,0,0,0),(431126,0,'宁远县',3,431100,0,0,'','','',0,0,0,9,0,0,0),(431127,0,'蓝山县',3,431100,0,0,'','','',0,0,0,10,0,0,0),(431128,0,'新田县',3,431100,0,0,'','','',0,0,0,11,0,0,0),(431129,0,'江华瑶族自治县',3,431100,0,0,'','','',0,0,0,12,0,0,0),(431171,0,'永州经济技术开发区',3,431100,0,0,'','','',0,0,0,13,0,0,0),(431172,0,'永州市金洞管理区',3,431100,0,0,'','','',0,0,0,14,0,0,0),(431173,0,'永州市回龙圩管理区',3,431100,0,0,'','','',0,0,0,15,0,0,0),(431200,0,'怀化市',2,43,0,0,'','','',0,0,14,12,0,0,0),(431201,0,'市辖区',3,431200,0,0,'','','',0,0,0,1,0,0,0),(431202,0,'鹤城区',3,431200,0,0,'','','',0,0,0,2,0,0,0),(431221,0,'中方县',3,431200,0,0,'','','',0,0,0,3,0,0,0),(431222,0,'沅陵县',3,431200,0,0,'','','',0,0,0,4,0,0,0),(431223,0,'辰溪县',3,431200,0,0,'','','',0,0,0,5,0,0,0),(431224,0,'溆浦县',3,431200,0,0,'','','',0,0,0,6,0,0,0),(431225,0,'会同县',3,431200,0,0,'','','',0,0,0,7,0,0,0),(431226,0,'麻阳苗族自治县',3,431200,0,0,'','','',0,0,0,8,0,0,0),(431227,0,'新晃侗族自治县',3,431200,0,0,'','','',0,0,0,9,0,0,0),(431228,0,'芷江侗族自治县',3,431200,0,0,'','','',0,0,0,10,0,0,0),(431229,0,'靖州苗族侗族自治县',3,431200,0,0,'','','',0,0,0,11,0,0,0),(431230,0,'通道侗族自治县',3,431200,0,0,'','','',0,0,0,12,0,0,0),(431271,0,'怀化市洪江管理区',3,431200,0,0,'','','',0,0,0,13,0,0,0),(431281,0,'洪江市',3,431200,0,0,'','','',0,0,0,14,0,0,0),(431300,0,'娄底市',2,43,0,0,'','','',0,0,6,13,0,0,0),(431301,0,'市辖区',3,431300,0,0,'','','',0,0,0,1,0,0,0),(431302,0,'娄星区',3,431300,0,0,'','','',0,0,0,2,0,0,0),(431321,0,'双峰县',3,431300,0,0,'','','',0,0,0,3,0,0,0),(431322,0,'新化县',3,431300,0,0,'','','',0,0,0,4,0,0,0),(431381,0,'冷水江市',3,431300,0,0,'','','',0,0,0,5,0,0,0),(431382,0,'涟源市',3,431300,0,0,'','','',0,0,0,6,0,0,0),(433100,0,'湘西土家族苗族自治州',2,43,0,0,'','','',0,0,9,14,0,0,0),(433101,0,'吉首市',3,433100,0,0,'','','',0,0,0,1,0,0,0),(433122,0,'泸溪县',3,433100,0,0,'','','',0,0,0,2,0,0,0),(433123,0,'凤凰县',3,433100,0,0,'','','',0,0,0,3,0,0,0),(433124,0,'花垣县',3,433100,0,0,'','','',0,0,0,4,0,0,0),(433125,0,'保靖县',3,433100,0,0,'','','',0,0,0,5,0,0,0),(433126,0,'古丈县',3,433100,0,0,'','','',0,0,0,6,0,0,0),(433127,0,'永顺县',3,433100,0,0,'','','',0,0,0,7,0,0,0),(433130,0,'龙山县',3,433100,0,0,'','','',0,0,0,8,0,0,0),(433173,0,'湖南永顺经济开发区',3,433100,0,0,'','','',0,0,0,9,0,0,0),(440100,0,'广州市',2,44,0,0,'','','',0,0,12,1,0,0,0),(440101,0,'市辖区',3,440100,0,0,'','','',0,0,0,1,0,0,0),(440103,0,'荔湾区',3,440100,0,0,'','','',0,0,0,2,0,0,0),(440104,0,'越秀区',3,440100,0,0,'','','',0,0,0,3,0,0,0),(440105,0,'海珠区',3,440100,0,0,'','','',0,0,0,4,0,0,0),(440106,0,'天河区',3,440100,0,0,'','','',0,0,0,5,0,0,0),(440111,0,'白云区',3,440100,0,0,'','','',0,0,0,6,0,0,0),(440112,0,'黄埔区',3,440100,0,0,'','','',0,0,0,7,0,0,0),(440113,0,'番禺区',3,440100,0,0,'','','',0,0,0,8,0,0,0),(440114,0,'花都区',3,440100,0,0,'','','',0,0,0,9,0,0,0),(440115,0,'南沙区',3,440100,0,0,'','','',0,0,0,10,0,0,0),(440117,0,'从化区',3,440100,0,0,'','','',0,0,0,11,0,0,0),(440118,0,'增城区',3,440100,0,0,'','','',0,0,0,12,0,0,0),(440200,0,'韶关市',2,44,0,0,'','','',0,0,11,2,0,0,0),(440201,0,'市辖区',3,440200,0,0,'','','',0,0,0,1,0,0,0),(440203,0,'武江区',3,440200,0,0,'','','',0,0,0,2,0,0,0),(440204,0,'浈江区',3,440200,0,0,'','','',0,0,0,3,0,0,0),(440205,0,'曲江区',3,440200,0,0,'','','',0,0,0,4,0,0,0),(440222,0,'始兴县',3,440200,0,0,'','','',0,0,0,5,0,0,0),(440224,0,'仁化县',3,440200,0,0,'','','',0,0,0,6,0,0,0),(440229,0,'翁源县',3,440200,0,0,'','','',0,0,0,7,0,0,0),(440232,0,'乳源瑶族自治县',3,440200,0,0,'','','',0,0,0,8,0,0,0),(440233,0,'新丰县',3,440200,0,0,'','','',0,0,0,9,0,0,0),(440281,0,'乐昌市',3,440200,0,0,'','','',0,0,0,10,0,0,0),(440282,0,'南雄市',3,440200,0,0,'','','',0,0,0,11,0,0,0),(440300,0,'深圳市',2,44,0,0,'','','',0,0,10,3,0,0,0),(440301,0,'市辖区',3,440300,0,0,'','','',0,0,0,1,0,0,0),(440303,0,'罗湖区',3,440300,0,0,'','','',0,0,0,2,0,0,0),(440304,0,'福田区',3,440300,0,0,'','','',0,0,0,3,0,0,0),(440305,0,'南山区',3,440300,0,0,'','','',0,0,0,4,0,0,0),(440306,0,'宝安区',3,440300,0,0,'','','',0,0,0,5,0,0,0),(440307,0,'龙岗区',3,440300,0,0,'','','',0,0,0,6,0,0,0),(440308,0,'盐田区',3,440300,0,0,'','','',0,0,0,7,0,0,0),(440309,0,'龙华区',3,440300,0,0,'','','',0,0,0,8,0,0,0),(440310,0,'坪山区',3,440300,0,0,'','','',0,0,0,9,0,0,0),(440311,0,'光明区',3,440300,0,0,'','','',0,0,0,10,0,0,0),(440400,0,'珠海市',2,44,0,0,'','','',0,0,4,4,0,0,0),(440401,0,'市辖区',3,440400,0,0,'','','',0,0,0,1,0,0,0),(440402,0,'香洲区',3,440400,0,0,'','','',0,0,0,2,0,0,0),(440403,0,'斗门区',3,440400,0,0,'','','',0,0,0,3,0,0,0),(440404,0,'金湾区',3,440400,0,0,'','','',0,0,0,4,0,0,0),(440500,0,'汕头市',2,44,0,0,'','','',0,0,8,5,0,0,0),(440501,0,'市辖区',3,440500,0,0,'','','',0,0,0,1,0,0,0),(440507,0,'龙湖区',3,440500,0,0,'','','',0,0,0,2,0,0,0),(440511,0,'金平区',3,440500,0,0,'','','',0,0,0,3,0,0,0),(440512,0,'濠江区',3,440500,0,0,'','','',0,0,0,4,0,0,0),(440513,0,'潮阳区',3,440500,0,0,'','','',0,0,0,5,0,0,0),(440514,0,'潮南区',3,440500,0,0,'','','',0,0,0,6,0,0,0),(440515,0,'澄海区',3,440500,0,0,'','','',0,0,0,7,0,0,0),(440523,0,'南澳县',3,440500,0,0,'','','',0,0,0,8,0,0,0),(440600,0,'佛山市',2,44,0,0,'','','',0,0,6,6,0,0,0),(440601,0,'市辖区',3,440600,0,0,'','','',0,0,0,1,0,0,0),(440604,0,'禅城区',3,440600,0,0,'','','',0,0,0,2,0,0,0),(440605,0,'南海区',3,440600,0,0,'','','',0,0,0,3,0,0,0),(440606,0,'顺德区',3,440600,0,0,'','','',0,0,0,4,0,0,0),(440607,0,'三水区',3,440600,0,0,'','','',0,0,0,5,0,0,0),(440608,0,'高明区',3,440600,0,0,'','','',0,0,0,6,0,0,0),(440700,0,'江门市',2,44,0,0,'','','',0,0,8,7,0,0,0),(440701,0,'市辖区',3,440700,0,0,'','','',0,0,0,1,0,0,0),(440703,0,'蓬江区',3,440700,0,0,'','','',0,0,0,2,0,0,0),(440704,0,'江海区',3,440700,0,0,'','','',0,0,0,3,0,0,0),(440705,0,'新会区',3,440700,0,0,'','','',0,0,0,4,0,0,0),(440781,0,'台山市',3,440700,0,0,'','','',0,0,0,5,0,0,0),(440783,0,'开平市',3,440700,0,0,'','','',0,0,0,6,0,0,0),(440784,0,'鹤山市',3,440700,0,0,'','','',0,0,0,7,0,0,0),(440785,0,'恩平市',3,440700,0,0,'','','',0,0,0,8,0,0,0),(440800,0,'湛江市',2,44,0,0,'','','',0,0,10,8,0,0,0),(440801,0,'市辖区',3,440800,0,0,'','','',0,0,0,1,0,0,0),(440802,0,'赤坎区',3,440800,0,0,'','','',0,0,0,2,0,0,0),(440803,0,'霞山区',3,440800,0,0,'','','',0,0,0,3,0,0,0),(440804,0,'坡头区',3,440800,0,0,'','','',0,0,0,4,0,0,0),(440811,0,'麻章区',3,440800,0,0,'','','',0,0,0,5,0,0,0),(440823,0,'遂溪县',3,440800,0,0,'','','',0,0,0,6,0,0,0),(440825,0,'徐闻县',3,440800,0,0,'','','',0,0,0,7,0,0,0),(440881,0,'廉江市',3,440800,0,0,'','','',0,0,0,8,0,0,0),(440882,0,'雷州市',3,440800,0,0,'','','',0,0,0,9,0,0,0),(440883,0,'吴川市',3,440800,0,0,'','','',0,0,0,10,0,0,0),(440900,0,'茂名市',2,44,0,0,'','','',0,0,6,9,0,0,0),(440901,0,'市辖区',3,440900,0,0,'','','',0,0,0,1,0,0,0),(440902,0,'茂南区',3,440900,0,0,'','','',0,0,0,2,0,0,0),(440904,0,'电白区',3,440900,0,0,'','','',0,0,0,3,0,0,0),(440981,0,'高州市',3,440900,0,0,'','','',0,0,0,4,0,0,0),(440982,0,'化州市',3,440900,0,0,'','','',0,0,0,5,0,0,0),(440983,0,'信宜市',3,440900,0,0,'','','',0,0,0,6,0,0,0),(441200,0,'肇庆市',2,44,0,0,'','','',0,0,9,10,0,0,0),(441201,0,'市辖区',3,441200,0,0,'','','',0,0,0,1,0,0,0),(441202,0,'端州区',3,441200,0,0,'','','',0,0,0,2,0,0,0),(441203,0,'鼎湖区',3,441200,0,0,'','','',0,0,0,3,0,0,0),(441204,0,'高要区',3,441200,0,0,'','','',0,0,0,4,0,0,0),(441223,0,'广宁县',3,441200,0,0,'','','',0,0,0,5,0,0,0),(441224,0,'怀集县',3,441200,0,0,'','','',0,0,0,6,0,0,0),(441225,0,'封开县',3,441200,0,0,'','','',0,0,0,7,0,0,0),(441226,0,'德庆县',3,441200,0,0,'','','',0,0,0,8,0,0,0),(441284,0,'四会市',3,441200,0,0,'','','',0,0,0,9,0,0,0),(441300,0,'惠州市',2,44,0,0,'','','',0,0,6,11,0,0,0),(441301,0,'市辖区',3,441300,0,0,'','','',0,0,0,1,0,0,0),(441302,0,'惠城区',3,441300,0,0,'','','',0,0,0,2,0,0,0),(441303,0,'惠阳区',3,441300,0,0,'','','',0,0,0,3,0,0,0),(441322,0,'博罗县',3,441300,0,0,'','','',0,0,0,4,0,0,0),(441323,0,'惠东县',3,441300,0,0,'','','',0,0,0,5,0,0,0),(441324,0,'龙门县',3,441300,0,0,'','','',0,0,0,6,0,0,0),(441400,0,'梅州市',2,44,0,0,'','','',0,0,9,12,0,0,0),(441401,0,'市辖区',3,441400,0,0,'','','',0,0,0,1,0,0,0),(441402,0,'梅江区',3,441400,0,0,'','','',0,0,0,2,0,0,0),(441403,0,'梅县区',3,441400,0,0,'','','',0,0,0,3,0,0,0),(441422,0,'大埔县',3,441400,0,0,'','','',0,0,0,4,0,0,0),(441423,0,'丰顺县',3,441400,0,0,'','','',0,0,0,5,0,0,0),(441424,0,'五华县',3,441400,0,0,'','','',0,0,0,6,0,0,0),(441426,0,'平远县',3,441400,0,0,'','','',0,0,0,7,0,0,0),(441427,0,'蕉岭县',3,441400,0,0,'','','',0,0,0,8,0,0,0),(441481,0,'兴宁市',3,441400,0,0,'','','',0,0,0,9,0,0,0),(441500,0,'汕尾市',2,44,0,0,'','','',0,0,5,13,0,0,0),(441501,0,'市辖区',3,441500,0,0,'','','',0,0,0,1,0,0,0),(441502,0,'城区',3,441500,0,0,'','','',0,0,0,2,0,0,0),(441521,0,'海丰县',3,441500,0,0,'','','',0,0,0,3,0,0,0),(441523,0,'陆河县',3,441500,0,0,'','','',0,0,0,4,0,0,0),(441581,0,'陆丰市',3,441500,0,0,'','','',0,0,0,5,0,0,0),(441600,0,'河源市',2,44,0,0,'','','',0,0,7,14,0,0,0),(441601,0,'市辖区',3,441600,0,0,'','','',0,0,0,1,0,0,0),(441602,0,'源城区',3,441600,0,0,'','','',0,0,0,2,0,0,0),(441621,0,'紫金县',3,441600,0,0,'','','',0,0,0,3,0,0,0),(441622,0,'龙川县',3,441600,0,0,'','','',0,0,0,4,0,0,0),(441623,0,'连平县',3,441600,0,0,'','','',0,0,0,5,0,0,0),(441624,0,'和平县',3,441600,0,0,'','','',0,0,0,6,0,0,0),(441625,0,'东源县',3,441600,0,0,'','','',0,0,0,7,0,0,0),(441700,0,'阳江市',2,44,0,0,'','','',0,0,5,15,0,0,0),(441701,0,'市辖区',3,441700,0,0,'','','',0,0,0,1,0,0,0),(441702,0,'江城区',3,441700,0,0,'','','',0,0,0,2,0,0,0),(441704,0,'阳东区',3,441700,0,0,'','','',0,0,0,3,0,0,0),(441721,0,'阳西县',3,441700,0,0,'','','',0,0,0,4,0,0,0),(441781,0,'阳春市',3,441700,0,0,'','','',0,0,0,5,0,0,0),(441800,0,'清远市',2,44,0,0,'','','',0,0,9,16,0,0,0),(441801,0,'市辖区',3,441800,0,0,'','','',0,0,0,1,0,0,0),(441802,0,'清城区',3,441800,0,0,'','','',0,0,0,2,0,0,0),(441803,0,'清新区',3,441800,0,0,'','','',0,0,0,3,0,0,0),(441821,0,'佛冈县',3,441800,0,0,'','','',0,0,0,4,0,0,0),(441823,0,'阳山县',3,441800,0,0,'','','',0,0,0,5,0,0,0),(441825,0,'连山壮族瑶族自治县',3,441800,0,0,'','','',0,0,0,6,0,0,0),(441826,0,'连南瑶族自治县',3,441800,0,0,'','','',0,0,0,7,0,0,0),(441881,0,'英德市',3,441800,0,0,'','','',0,0,0,8,0,0,0),(441882,0,'连州市',3,441800,0,0,'','','',0,0,0,9,0,0,0),(441900,0,'东莞市',2,44,0,0,'','','',0,0,35,17,0,0,0),(442000,0,'中山市',2,44,0,0,'','','',0,0,24,18,0,0,0),(445100,0,'潮州市',2,44,0,0,'','','',0,0,4,19,0,0,0),(445101,0,'市辖区',3,445100,0,0,'','','',0,0,0,1,0,0,0),(445102,0,'湘桥区',3,445100,0,0,'','','',0,0,0,2,0,0,0),(445103,0,'潮安区',3,445100,0,0,'','','',0,0,0,3,0,0,0),(445122,0,'饶平县',3,445100,0,0,'','','',0,0,0,4,0,0,0),(445200,0,'揭阳市',2,44,0,0,'','','',0,0,6,20,0,0,0),(445201,0,'市辖区',3,445200,0,0,'','','',0,0,0,1,0,0,0),(445202,0,'榕城区',3,445200,0,0,'','','',0,0,0,2,0,0,0),(445203,0,'揭东区',3,445200,0,0,'','','',0,0,0,3,0,0,0),(445222,0,'揭西县',3,445200,0,0,'','','',0,0,0,4,0,0,0),(445224,0,'惠来县',3,445200,0,0,'','','',0,0,0,5,0,0,0),(445281,0,'普宁市',3,445200,0,0,'','','',0,0,0,6,0,0,0),(445300,0,'云浮市',2,44,0,0,'','','',0,0,6,21,0,0,0),(445301,0,'市辖区',3,445300,0,0,'','','',0,0,0,1,0,0,0),(445302,0,'云城区',3,445300,0,0,'','','',0,0,0,2,0,0,0),(445303,0,'云安区',3,445300,0,0,'','','',0,0,0,3,0,0,0),(445321,0,'新兴县',3,445300,0,0,'','','',0,0,0,4,0,0,0),(445322,0,'郁南县',3,445300,0,0,'','','',0,0,0,5,0,0,0),(445381,0,'罗定市',3,445300,0,0,'','','',0,0,0,6,0,0,0),(450100,0,'南宁市',2,45,0,0,'','','',0,0,13,1,0,0,0),(450101,0,'市辖区',3,450100,0,0,'','','',0,0,0,1,0,0,0),(450102,0,'兴宁区',3,450100,0,0,'','','',0,0,0,2,0,0,0),(450103,0,'青秀区',3,450100,0,0,'','','',0,0,0,3,0,0,0),(450105,0,'江南区',3,450100,0,0,'','','',0,0,0,4,0,0,0),(450107,0,'西乡塘区',3,450100,0,0,'','','',0,0,0,5,0,0,0),(450108,0,'良庆区',3,450100,0,0,'','','',0,0,0,6,0,0,0),(450109,0,'邕宁区',3,450100,0,0,'','','',0,0,0,7,0,0,0),(450110,0,'武鸣区',3,450100,0,0,'','','',0,0,0,8,0,0,0),(450123,0,'隆安县',3,450100,0,0,'','','',0,0,0,9,0,0,0),(450124,0,'马山县',3,450100,0,0,'','','',0,0,0,10,0,0,0),(450125,0,'上林县',3,450100,0,0,'','','',0,0,0,11,0,0,0),(450126,0,'宾阳县',3,450100,0,0,'','','',0,0,0,12,0,0,0),(450127,0,'横县',3,450100,0,0,'','','',0,0,0,13,0,0,0),(450200,0,'柳州市',2,45,0,0,'','','',0,0,11,2,0,0,0),(450201,0,'市辖区',3,450200,0,0,'','','',0,0,0,1,0,0,0),(450202,0,'城中区',3,450200,0,0,'','','',0,0,0,2,0,0,0),(450203,0,'鱼峰区',3,450200,0,0,'','','',0,0,0,3,0,0,0),(450204,0,'柳南区',3,450200,0,0,'','','',0,0,0,4,0,0,0),(450205,0,'柳北区',3,450200,0,0,'','','',0,0,0,5,0,0,0),(450206,0,'柳江区',3,450200,0,0,'','','',0,0,0,6,0,0,0),(450222,0,'柳城县',3,450200,0,0,'','','',0,0,0,7,0,0,0),(450223,0,'鹿寨县',3,450200,0,0,'','','',0,0,0,8,0,0,0),(450224,0,'融安县',3,450200,0,0,'','','',0,0,0,9,0,0,0),(450225,0,'融水苗族自治县',3,450200,0,0,'','','',0,0,0,10,0,0,0),(450226,0,'三江侗族自治县',3,450200,0,0,'','','',0,0,0,11,0,0,0),(450300,0,'桂林市',2,45,0,0,'','','',0,0,18,3,0,0,0),(450301,0,'市辖区',3,450300,0,0,'','','',0,0,0,1,0,0,0),(450302,0,'秀峰区',3,450300,0,0,'','','',0,0,0,2,0,0,0),(450303,0,'叠彩区',3,450300,0,0,'','','',0,0,0,3,0,0,0),(450304,0,'象山区',3,450300,0,0,'','','',0,0,0,4,0,0,0),(450305,0,'七星区',3,450300,0,0,'','','',0,0,0,5,0,0,0),(450311,0,'雁山区',3,450300,0,0,'','','',0,0,0,6,0,0,0),(450312,0,'临桂区',3,450300,0,0,'','','',0,0,0,7,0,0,0),(450321,0,'阳朔县',3,450300,0,0,'','','',0,0,0,8,0,0,0),(450323,0,'灵川县',3,450300,0,0,'','','',0,0,0,9,0,0,0),(450324,0,'全州县',3,450300,0,0,'','','',0,0,0,10,0,0,0),(450325,0,'兴安县',3,450300,0,0,'','','',0,0,0,11,0,0,0),(450326,0,'永福县',3,450300,0,0,'','','',0,0,0,12,0,0,0),(450327,0,'灌阳县',3,450300,0,0,'','','',0,0,0,13,0,0,0),(450328,0,'龙胜各族自治县',3,450300,0,0,'','','',0,0,0,14,0,0,0),(450329,0,'资源县',3,450300,0,0,'','','',0,0,0,15,0,0,0),(450330,0,'平乐县',3,450300,0,0,'','','',0,0,0,16,0,0,0),(450332,0,'恭城瑶族自治县',3,450300,0,0,'','','',0,0,0,17,0,0,0),(450381,0,'荔浦市',3,450300,0,0,'','','',0,0,0,18,0,0,0),(450400,0,'梧州市',2,45,0,0,'','','',0,0,8,4,0,0,0),(450401,0,'市辖区',3,450400,0,0,'','','',0,0,0,1,0,0,0),(450403,0,'万秀区',3,450400,0,0,'','','',0,0,0,2,0,0,0),(450405,0,'长洲区',3,450400,0,0,'','','',0,0,0,3,0,0,0),(450406,0,'龙圩区',3,450400,0,0,'','','',0,0,0,4,0,0,0),(450421,0,'苍梧县',3,450400,0,0,'','','',0,0,0,5,0,0,0),(450422,0,'藤县',3,450400,0,0,'','','',0,0,0,6,0,0,0),(450423,0,'蒙山县',3,450400,0,0,'','','',0,0,0,7,0,0,0),(450481,0,'岑溪市',3,450400,0,0,'','','',0,0,0,8,0,0,0),(450500,0,'北海市',2,45,0,0,'','','',0,0,5,5,0,0,0),(450501,0,'市辖区',3,450500,0,0,'','','',0,0,0,1,0,0,0),(450502,0,'海城区',3,450500,0,0,'','','',0,0,0,2,0,0,0),(450503,0,'银海区',3,450500,0,0,'','','',0,0,0,3,0,0,0),(450512,0,'铁山港区',3,450500,0,0,'','','',0,0,0,4,0,0,0),(450521,0,'合浦县',3,450500,0,0,'','','',0,0,0,5,0,0,0),(450600,0,'防城港市',2,45,0,0,'','','',0,0,5,6,0,0,0),(450601,0,'市辖区',3,450600,0,0,'','','',0,0,0,1,0,0,0),(450602,0,'港口区',3,450600,0,0,'','','',0,0,0,2,0,0,0),(450603,0,'防城区',3,450600,0,0,'','','',0,0,0,3,0,0,0),(450621,0,'上思县',3,450600,0,0,'','','',0,0,0,4,0,0,0),(450681,0,'东兴市',3,450600,0,0,'','','',0,0,0,5,0,0,0),(450700,0,'钦州市',2,45,0,0,'','','',0,0,5,7,0,0,0),(450701,0,'市辖区',3,450700,0,0,'','','',0,0,0,1,0,0,0),(450702,0,'钦南区',3,450700,0,0,'','','',0,0,0,2,0,0,0),(450703,0,'钦北区',3,450700,0,0,'','','',0,0,0,3,0,0,0),(450721,0,'灵山县',3,450700,0,0,'','','',0,0,0,4,0,0,0),(450722,0,'浦北县',3,450700,0,0,'','','',0,0,0,5,0,0,0),(450800,0,'贵港市',2,45,0,0,'','','',0,0,6,8,0,0,0),(450801,0,'市辖区',3,450800,0,0,'','','',0,0,0,1,0,0,0),(450802,0,'港北区',3,450800,0,0,'','','',0,0,0,2,0,0,0),(450803,0,'港南区',3,450800,0,0,'','','',0,0,0,3,0,0,0),(450804,0,'覃塘区',3,450800,0,0,'','','',0,0,0,4,0,0,0),(450821,0,'平南县',3,450800,0,0,'','','',0,0,0,5,0,0,0),(450881,0,'桂平市',3,450800,0,0,'','','',0,0,0,6,0,0,0),(450900,0,'玉林市',2,45,0,0,'','','',0,0,8,9,0,0,0),(450901,0,'市辖区',3,450900,0,0,'','','',0,0,0,1,0,0,0),(450902,0,'玉州区',3,450900,0,0,'','','',0,0,0,2,0,0,0),(450903,0,'福绵区',3,450900,0,0,'','','',0,0,0,3,0,0,0),(450921,0,'容县',3,450900,0,0,'','','',0,0,0,4,0,0,0),(450922,0,'陆川县',3,450900,0,0,'','','',0,0,0,5,0,0,0),(450923,0,'博白县',3,450900,0,0,'','','',0,0,0,6,0,0,0),(450924,0,'兴业县',3,450900,0,0,'','','',0,0,0,7,0,0,0),(450981,0,'北流市',3,450900,0,0,'','','',0,0,0,8,0,0,0),(451000,0,'百色市',2,45,0,0,'','','',0,0,13,10,0,0,0),(451001,0,'市辖区',3,451000,0,0,'','','',0,0,0,1,0,0,0),(451002,0,'右江区',3,451000,0,0,'','','',0,0,0,2,0,0,0),(451003,0,'田阳区',3,451000,0,0,'','','',0,0,0,3,0,0,0),(451022,0,'田东县',3,451000,0,0,'','','',0,0,0,4,0,0,0),(451023,0,'平果县',3,451000,0,0,'','','',0,0,0,5,0,0,0),(451024,0,'德保县',3,451000,0,0,'','','',0,0,0,6,0,0,0),(451026,0,'那坡县',3,451000,0,0,'','','',0,0,0,7,0,0,0),(451027,0,'凌云县',3,451000,0,0,'','','',0,0,0,8,0,0,0),(451028,0,'乐业县',3,451000,0,0,'','','',0,0,0,9,0,0,0),(451029,0,'田林县',3,451000,0,0,'','','',0,0,0,10,0,0,0),(451030,0,'西林县',3,451000,0,0,'','','',0,0,0,11,0,0,0),(451031,0,'隆林各族自治县',3,451000,0,0,'','','',0,0,0,12,0,0,0),(451081,0,'靖西市',3,451000,0,0,'','','',0,0,0,13,0,0,0),(451100,0,'贺州市',2,45,0,0,'','','',0,0,6,11,0,0,0),(451101,0,'市辖区',3,451100,0,0,'','','',0,0,0,1,0,0,0),(451102,0,'八步区',3,451100,0,0,'','','',0,0,0,2,0,0,0),(451103,0,'平桂区',3,451100,0,0,'','','',0,0,0,3,0,0,0),(451121,0,'昭平县',3,451100,0,0,'','','',0,0,0,4,0,0,0),(451122,0,'钟山县',3,451100,0,0,'','','',0,0,0,5,0,0,0),(451123,0,'富川瑶族自治县',3,451100,0,0,'','','',0,0,0,6,0,0,0),(451200,0,'河池市',2,45,0,0,'','','',0,0,12,12,0,0,0),(451201,0,'市辖区',3,451200,0,0,'','','',0,0,0,1,0,0,0),(451202,0,'金城江区',3,451200,0,0,'','','',0,0,0,2,0,0,0),(451203,0,'宜州区',3,451200,0,0,'','','',0,0,0,3,0,0,0),(451221,0,'南丹县',3,451200,0,0,'','','',0,0,0,4,0,0,0),(451222,0,'天峨县',3,451200,0,0,'','','',0,0,0,5,0,0,0),(451223,0,'凤山县',3,451200,0,0,'','','',0,0,0,6,0,0,0),(451224,0,'东兰县',3,451200,0,0,'','','',0,0,0,7,0,0,0),(451225,0,'罗城仫佬族自治县',3,451200,0,0,'','','',0,0,0,8,0,0,0),(451226,0,'环江毛南族自治县',3,451200,0,0,'','','',0,0,0,9,0,0,0),(451227,0,'巴马瑶族自治县',3,451200,0,0,'','','',0,0,0,10,0,0,0),(451228,0,'都安瑶族自治县',3,451200,0,0,'','','',0,0,0,11,0,0,0),(451229,0,'大化瑶族自治县',3,451200,0,0,'','','',0,0,0,12,0,0,0),(451300,0,'来宾市',2,45,0,0,'','','',0,0,7,13,0,0,0),(451301,0,'市辖区',3,451300,0,0,'','','',0,0,0,1,0,0,0),(451302,0,'兴宾区',3,451300,0,0,'','','',0,0,0,2,0,0,0),(451321,0,'忻城县',3,451300,0,0,'','','',0,0,0,3,0,0,0),(451322,0,'象州县',3,451300,0,0,'','','',0,0,0,4,0,0,0),(451323,0,'武宣县',3,451300,0,0,'','','',0,0,0,5,0,0,0),(451324,0,'金秀瑶族自治县',3,451300,0,0,'','','',0,0,0,6,0,0,0),(451381,0,'合山市',3,451300,0,0,'','','',0,0,0,7,0,0,0),(451400,0,'崇左市',2,45,0,0,'','','',0,0,8,14,0,0,0),(451401,0,'市辖区',3,451400,0,0,'','','',0,0,0,1,0,0,0),(451402,0,'江州区',3,451400,0,0,'','','',0,0,0,2,0,0,0),(451421,0,'扶绥县',3,451400,0,0,'','','',0,0,0,3,0,0,0),(451422,0,'宁明县',3,451400,0,0,'','','',0,0,0,4,0,0,0),(451423,0,'龙州县',3,451400,0,0,'','','',0,0,0,5,0,0,0),(451424,0,'大新县',3,451400,0,0,'','','',0,0,0,6,0,0,0),(451425,0,'天等县',3,451400,0,0,'','','',0,0,0,7,0,0,0),(451481,0,'凭祥市',3,451400,0,0,'','','',0,0,0,8,0,0,0),(460100,0,'海口市',2,46,0,0,'','','',0,0,5,1,0,0,0),(460101,0,'市辖区',3,460100,0,0,'','','',0,0,0,1,0,0,0),(460105,0,'秀英区',3,460100,0,0,'','','',0,0,0,2,0,0,0),(460106,0,'龙华区',3,460100,0,0,'','','',0,0,0,3,0,0,0),(460107,0,'琼山区',3,460100,0,0,'','','',0,0,0,4,0,0,0),(460108,0,'美兰区',3,460100,0,0,'','','',0,0,0,5,0,0,0),(460200,0,'三亚市',2,46,0,0,'','','',0,0,5,2,0,0,0),(460201,0,'市辖区',3,460200,0,0,'','','',0,0,0,1,0,0,0),(460202,0,'海棠区',3,460200,0,0,'','','',0,0,0,2,0,0,0),(460203,0,'吉阳区',3,460200,0,0,'','','',0,0,0,3,0,0,0),(460204,0,'天涯区',3,460200,0,0,'','','',0,0,0,4,0,0,0),(460205,0,'崖州区',3,460200,0,0,'','','',0,0,0,5,0,0,0),(460300,0,'三沙市',2,46,0,0,'','','',0,0,3,3,0,0,0),(460321,0,'西沙群岛',3,460300,0,0,'','','',0,0,0,1,0,0,0),(460322,0,'南沙群岛',3,460300,0,0,'','','',0,0,0,2,0,0,0),(460323,0,'中沙群岛的岛礁及其海域',3,460300,0,0,'','','',0,0,0,3,0,0,0),(460400,0,'儋州市',2,46,0,0,'','','',0,0,18,4,0,0,0),(469000,0,'省直辖县级行政区划',2,46,0,0,'','','',0,0,15,5,0,0,0),(469001,0,'五指山市',3,469000,0,0,'','','',0,0,0,1,0,0,0),(469002,0,'琼海市',3,469000,0,0,'','','',0,0,0,2,0,0,0),(469005,0,'文昌市',3,469000,0,0,'','','',0,0,0,3,0,0,0),(469006,0,'万宁市',3,469000,0,0,'','','',0,0,0,4,0,0,0),(469007,0,'东方市',3,469000,0,0,'','','',0,0,0,5,0,0,0),(469021,0,'定安县',3,469000,0,0,'','','',0,0,0,6,0,0,0),(469022,0,'屯昌县',3,469000,0,0,'','','',0,0,0,7,0,0,0),(469023,0,'澄迈县',3,469000,0,0,'','','',0,0,0,8,0,0,0),(469024,0,'临高县',3,469000,0,0,'','','',0,0,0,9,0,0,0),(469025,0,'白沙黎族自治县',3,469000,0,0,'','','',0,0,0,10,0,0,0),(469026,0,'昌江黎族自治县',3,469000,0,0,'','','',0,0,0,11,0,0,0),(469027,0,'乐东黎族自治县',3,469000,0,0,'','','',0,0,0,12,0,0,0),(469028,0,'陵水黎族自治县',3,469000,0,0,'','','',0,0,0,13,0,0,0),(469029,0,'保亭黎族苗族自治县',3,469000,0,0,'','','',0,0,0,14,0,0,0),(469030,0,'琼中黎族苗族自治县',3,469000,0,0,'','','',0,0,0,15,0,0,0),(500100,0,'市辖区',2,50,0,0,'','','',0,0,26,1,0,0,0),(500101,0,'万州区',3,500100,0,0,'','','',0,0,0,1,0,0,0),(500102,0,'涪陵区',3,500100,0,0,'','','',0,0,0,2,0,0,0),(500103,0,'渝中区',3,500100,0,0,'','','',0,0,0,3,0,0,0),(500104,0,'大渡口区',3,500100,0,0,'','','',0,0,0,4,0,0,0),(500105,0,'江北区',3,500100,0,0,'','','',0,0,0,5,0,0,0),(500106,0,'沙坪坝区',3,500100,0,0,'','','',0,0,0,6,0,0,0),(500107,0,'九龙坡区',3,500100,0,0,'','','',0,0,0,7,0,0,0),(500108,0,'南岸区',3,500100,0,0,'','','',0,0,0,8,0,0,0),(500109,0,'北碚区',3,500100,0,0,'','','',0,0,0,9,0,0,0),(500110,0,'綦江区',3,500100,0,0,'','','',0,0,0,10,0,0,0),(500111,0,'大足区',3,500100,0,0,'','','',0,0,0,11,0,0,0),(500112,0,'渝北区',3,500100,0,0,'','','',0,0,0,12,0,0,0),(500113,0,'巴南区',3,500100,0,0,'','','',0,0,0,13,0,0,0),(500114,0,'黔江区',3,500100,0,0,'','','',0,0,0,14,0,0,0),(500115,0,'长寿区',3,500100,0,0,'','','',0,0,0,15,0,0,0),(500116,0,'江津区',3,500100,0,0,'','','',0,0,0,16,0,0,0),(500117,0,'合川区',3,500100,0,0,'','','',0,0,0,17,0,0,0),(500118,0,'永川区',3,500100,0,0,'','','',0,0,0,18,0,0,0),(500119,0,'南川区',3,500100,0,0,'','','',0,0,0,19,0,0,0),(500120,0,'璧山区',3,500100,0,0,'','','',0,0,0,20,0,0,0),(500151,0,'铜梁区',3,500100,0,0,'','','',0,0,0,21,0,0,0),(500152,0,'潼南区',3,500100,0,0,'','','',0,0,0,22,0,0,0),(500153,0,'荣昌区',3,500100,0,0,'','','',0,0,0,23,0,0,0),(500154,0,'开州区',3,500100,0,0,'','','',0,0,0,24,0,0,0),(500155,0,'梁平区',3,500100,0,0,'','','',0,0,0,25,0,0,0),(500156,0,'武隆区',3,500100,0,0,'','','',0,0,0,26,0,0,0),(500200,0,'县',2,50,0,0,'','','',0,0,12,2,0,0,0),(500229,0,'城口县',3,500200,0,0,'','','',0,0,0,1,0,0,0),(500230,0,'丰都县',3,500200,0,0,'','','',0,0,0,2,0,0,0),(500231,0,'垫江县',3,500200,0,0,'','','',0,0,0,3,0,0,0),(500233,0,'忠县',3,500200,0,0,'','','',0,0,0,4,0,0,0),(500235,0,'云阳县',3,500200,0,0,'','','',0,0,0,5,0,0,0),(500236,0,'奉节县',3,500200,0,0,'','','',0,0,0,6,0,0,0),(500237,0,'巫山县',3,500200,0,0,'','','',0,0,0,7,0,0,0),(500238,0,'巫溪县',3,500200,0,0,'','','',0,0,0,8,0,0,0),(500240,0,'石柱土家族自治县',3,500200,0,0,'','','',0,0,0,9,0,0,0),(500241,0,'秀山土家族苗族自治县',3,500200,0,0,'','','',0,0,0,10,0,0,0),(500242,0,'酉阳土家族苗族自治县',3,500200,0,0,'','','',0,0,0,11,0,0,0),(500243,0,'彭水苗族土家族自治县',3,500200,0,0,'','','',0,0,0,12,0,0,0),(510100,0,'成都市',2,51,0,0,'','','',0,0,21,1,0,0,0),(510101,0,'市辖区',3,510100,0,0,'','','',0,0,0,1,0,0,0),(510104,0,'锦江区',3,510100,0,0,'','','',0,0,0,2,0,0,0),(510105,0,'青羊区',3,510100,0,0,'','','',0,0,0,3,0,0,0),(510106,0,'金牛区',3,510100,0,0,'','','',0,0,0,4,0,0,0),(510107,0,'武侯区',3,510100,0,0,'','','',0,0,0,5,0,0,0),(510108,0,'成华区',3,510100,0,0,'','','',0,0,0,6,0,0,0),(510112,0,'龙泉驿区',3,510100,0,0,'','','',0,0,0,7,0,0,0),(510113,0,'青白江区',3,510100,0,0,'','','',0,0,0,8,0,0,0),(510114,0,'新都区',3,510100,0,0,'','','',0,0,0,9,0,0,0),(510115,0,'温江区',3,510100,0,0,'','','',0,0,0,10,0,0,0),(510116,0,'双流区',3,510100,0,0,'','','',0,0,0,11,0,0,0),(510117,0,'郫都区',3,510100,0,0,'','','',0,0,0,12,0,0,0),(510121,0,'金堂县',3,510100,0,0,'','','',0,0,0,13,0,0,0),(510129,0,'大邑县',3,510100,0,0,'','','',0,0,0,14,0,0,0),(510131,0,'蒲江县',3,510100,0,0,'','','',0,0,0,15,0,0,0),(510132,0,'新津县',3,510100,0,0,'','','',0,0,0,16,0,0,0),(510181,0,'都江堰市',3,510100,0,0,'','','',0,0,0,17,0,0,0),(510182,0,'彭州市',3,510100,0,0,'','','',0,0,0,18,0,0,0),(510183,0,'邛崃市',3,510100,0,0,'','','',0,0,0,19,0,0,0),(510184,0,'崇州市',3,510100,0,0,'','','',0,0,0,20,0,0,0),(510185,0,'简阳市',3,510100,0,0,'','','',0,0,0,21,0,0,0),(510300,0,'自贡市',2,51,0,0,'','','',0,0,7,2,0,0,0),(510301,0,'市辖区',3,510300,0,0,'','','',0,0,0,1,0,0,0),(510302,0,'自流井区',3,510300,0,0,'','','',0,0,0,2,0,0,0),(510303,0,'贡井区',3,510300,0,0,'','','',0,0,0,3,0,0,0),(510304,0,'大安区',3,510300,0,0,'','','',0,0,0,4,0,0,0),(510311,0,'沿滩区',3,510300,0,0,'','','',0,0,0,5,0,0,0),(510321,0,'荣县',3,510300,0,0,'','','',0,0,0,6,0,0,0),(510322,0,'富顺县',3,510300,0,0,'','','',0,0,0,7,0,0,0),(510400,0,'攀枝花市',2,51,0,0,'','','',0,0,6,3,0,0,0),(510401,0,'市辖区',3,510400,0,0,'','','',0,0,0,1,0,0,0),(510402,0,'东区',3,510400,0,0,'','','',0,0,0,2,0,0,0),(510403,0,'西区',3,510400,0,0,'','','',0,0,0,3,0,0,0),(510411,0,'仁和区',3,510400,0,0,'','','',0,0,0,4,0,0,0),(510421,0,'米易县',3,510400,0,0,'','','',0,0,0,5,0,0,0),(510422,0,'盐边县',3,510400,0,0,'','','',0,0,0,6,0,0,0),(510500,0,'泸州市',2,51,0,0,'','','',0,0,8,4,0,0,0),(510501,0,'市辖区',3,510500,0,0,'','','',0,0,0,1,0,0,0),(510502,0,'江阳区',3,510500,0,0,'','','',0,0,0,2,0,0,0),(510503,0,'纳溪区',3,510500,0,0,'','','',0,0,0,3,0,0,0),(510504,0,'龙马潭区',3,510500,0,0,'','','',0,0,0,4,0,0,0),(510521,0,'泸县',3,510500,0,0,'','','',0,0,0,5,0,0,0),(510522,0,'合江县',3,510500,0,0,'','','',0,0,0,6,0,0,0),(510524,0,'叙永县',3,510500,0,0,'','','',0,0,0,7,0,0,0),(510525,0,'古蔺县',3,510500,0,0,'','','',0,0,0,8,0,0,0),(510600,0,'德阳市',2,51,0,0,'','','',0,0,7,5,0,0,0),(510601,0,'市辖区',3,510600,0,0,'','','',0,0,0,1,0,0,0),(510603,0,'旌阳区',3,510600,0,0,'','','',0,0,0,2,0,0,0),(510604,0,'罗江区',3,510600,0,0,'','','',0,0,0,3,0,0,0),(510623,0,'中江县',3,510600,0,0,'','','',0,0,0,4,0,0,0),(510681,0,'广汉市',3,510600,0,0,'','','',0,0,0,5,0,0,0),(510682,0,'什邡市',3,510600,0,0,'','','',0,0,0,6,0,0,0),(510683,0,'绵竹市',3,510600,0,0,'','','',0,0,0,7,0,0,0),(510700,0,'绵阳市',2,51,0,0,'','','',0,0,10,6,0,0,0),(510701,0,'市辖区',3,510700,0,0,'','','',0,0,0,1,0,0,0),(510703,0,'涪城区',3,510700,0,0,'','','',0,0,0,2,0,0,0),(510704,0,'游仙区',3,510700,0,0,'','','',0,0,0,3,0,0,0),(510705,0,'安州区',3,510700,0,0,'','','',0,0,0,4,0,0,0),(510722,0,'三台县',3,510700,0,0,'','','',0,0,0,5,0,0,0),(510723,0,'盐亭县',3,510700,0,0,'','','',0,0,0,6,0,0,0),(510725,0,'梓潼县',3,510700,0,0,'','','',0,0,0,7,0,0,0),(510726,0,'北川羌族自治县',3,510700,0,0,'','','',0,0,0,8,0,0,0),(510727,0,'平武县',3,510700,0,0,'','','',0,0,0,9,0,0,0),(510781,0,'江油市',3,510700,0,0,'','','',0,0,0,10,0,0,0),(510800,0,'广元市',2,51,0,0,'','','',0,0,8,7,0,0,0),(510801,0,'市辖区',3,510800,0,0,'','','',0,0,0,1,0,0,0),(510802,0,'利州区',3,510800,0,0,'','','',0,0,0,2,0,0,0),(510811,0,'昭化区',3,510800,0,0,'','','',0,0,0,3,0,0,0),(510812,0,'朝天区',3,510800,0,0,'','','',0,0,0,4,0,0,0),(510821,0,'旺苍县',3,510800,0,0,'','','',0,0,0,5,0,0,0),(510822,0,'青川县',3,510800,0,0,'','','',0,0,0,6,0,0,0),(510823,0,'剑阁县',3,510800,0,0,'','','',0,0,0,7,0,0,0),(510824,0,'苍溪县',3,510800,0,0,'','','',0,0,0,8,0,0,0),(510900,0,'遂宁市',2,51,0,0,'','','',0,0,6,8,0,0,0),(510901,0,'市辖区',3,510900,0,0,'','','',0,0,0,1,0,0,0),(510903,0,'船山区',3,510900,0,0,'','','',0,0,0,2,0,0,0),(510904,0,'安居区',3,510900,0,0,'','','',0,0,0,3,0,0,0),(510921,0,'蓬溪县',3,510900,0,0,'','','',0,0,0,4,0,0,0),(510923,0,'大英县',3,510900,0,0,'','','',0,0,0,5,0,0,0),(510981,0,'射洪市',3,510900,0,0,'','','',0,0,0,6,0,0,0),(511000,0,'内江市',2,51,0,0,'','','',0,0,7,9,0,0,0),(511001,0,'市辖区',3,511000,0,0,'','','',0,0,0,1,0,0,0),(511002,0,'市中区',3,511000,0,0,'','','',0,0,0,2,0,0,0),(511011,0,'东兴区',3,511000,0,0,'','','',0,0,0,3,0,0,0),(511024,0,'威远县',3,511000,0,0,'','','',0,0,0,4,0,0,0),(511025,0,'资中县',3,511000,0,0,'','','',0,0,0,5,0,0,0),(511071,0,'内江经济开发区',3,511000,0,0,'','','',0,0,0,6,0,0,0),(511083,0,'隆昌市',3,511000,0,0,'','','',0,0,0,7,0,0,0),(511100,0,'乐山市',2,51,0,0,'','','',0,0,12,10,0,0,0),(511101,0,'市辖区',3,511100,0,0,'','','',0,0,0,1,0,0,0),(511102,0,'市中区',3,511100,0,0,'','','',0,0,0,2,0,0,0),(511111,0,'沙湾区',3,511100,0,0,'','','',0,0,0,3,0,0,0),(511112,0,'五通桥区',3,511100,0,0,'','','',0,0,0,4,0,0,0),(511113,0,'金口河区',3,511100,0,0,'','','',0,0,0,5,0,0,0),(511123,0,'犍为县',3,511100,0,0,'','','',0,0,0,6,0,0,0),(511124,0,'井研县',3,511100,0,0,'','','',0,0,0,7,0,0,0),(511126,0,'夹江县',3,511100,0,0,'','','',0,0,0,8,0,0,0),(511129,0,'沐川县',3,511100,0,0,'','','',0,0,0,9,0,0,0),(511132,0,'峨边彝族自治县',3,511100,0,0,'','','',0,0,0,10,0,0,0),(511133,0,'马边彝族自治县',3,511100,0,0,'','','',0,0,0,11,0,0,0),(511181,0,'峨眉山市',3,511100,0,0,'','','',0,0,0,12,0,0,0),(511300,0,'南充市',2,51,0,0,'','','',0,0,10,11,0,0,0),(511301,0,'市辖区',3,511300,0,0,'','','',0,0,0,1,0,0,0),(511302,0,'顺庆区',3,511300,0,0,'','','',0,0,0,2,0,0,0),(511303,0,'高坪区',3,511300,0,0,'','','',0,0,0,3,0,0,0),(511304,0,'嘉陵区',3,511300,0,0,'','','',0,0,0,4,0,0,0),(511321,0,'南部县',3,511300,0,0,'','','',0,0,0,5,0,0,0),(511322,0,'营山县',3,511300,0,0,'','','',0,0,0,6,0,0,0),(511323,0,'蓬安县',3,511300,0,0,'','','',0,0,0,7,0,0,0),(511324,0,'仪陇县',3,511300,0,0,'','','',0,0,0,8,0,0,0),(511325,0,'西充县',3,511300,0,0,'','','',0,0,0,9,0,0,0),(511381,0,'阆中市',3,511300,0,0,'','','',0,0,0,10,0,0,0),(511400,0,'眉山市',2,51,0,0,'','','',0,0,7,12,0,0,0),(511401,0,'市辖区',3,511400,0,0,'','','',0,0,0,1,0,0,0),(511402,0,'东坡区',3,511400,0,0,'','','',0,0,0,2,0,0,0),(511403,0,'彭山区',3,511400,0,0,'','','',0,0,0,3,0,0,0),(511421,0,'仁寿县',3,511400,0,0,'','','',0,0,0,4,0,0,0),(511423,0,'洪雅县',3,511400,0,0,'','','',0,0,0,5,0,0,0),(511424,0,'丹棱县',3,511400,0,0,'','','',0,0,0,6,0,0,0),(511425,0,'青神县',3,511400,0,0,'','','',0,0,0,7,0,0,0),(511500,0,'宜宾市',2,51,0,0,'','','',0,0,11,13,0,0,0),(511501,0,'市辖区',3,511500,0,0,'','','',0,0,0,1,0,0,0),(511502,0,'翠屏区',3,511500,0,0,'','','',0,0,0,2,0,0,0),(511503,0,'南溪区',3,511500,0,0,'','','',0,0,0,3,0,0,0),(511504,0,'叙州区',3,511500,0,0,'','','',0,0,0,4,0,0,0),(511523,0,'江安县',3,511500,0,0,'','','',0,0,0,5,0,0,0),(511524,0,'长宁县',3,511500,0,0,'','','',0,0,0,6,0,0,0),(511525,0,'高县',3,511500,0,0,'','','',0,0,0,7,0,0,0),(511526,0,'珙县',3,511500,0,0,'','','',0,0,0,8,0,0,0),(511527,0,'筠连县',3,511500,0,0,'','','',0,0,0,9,0,0,0),(511528,0,'兴文县',3,511500,0,0,'','','',0,0,0,10,0,0,0),(511529,0,'屏山县',3,511500,0,0,'','','',0,0,0,11,0,0,0),(511600,0,'广安市',2,51,0,0,'','','',0,0,7,14,0,0,0),(511601,0,'市辖区',3,511600,0,0,'','','',0,0,0,1,0,0,0),(511602,0,'广安区',3,511600,0,0,'','','',0,0,0,2,0,0,0),(511603,0,'前锋区',3,511600,0,0,'','','',0,0,0,3,0,0,0),(511621,0,'岳池县',3,511600,0,0,'','','',0,0,0,4,0,0,0),(511622,0,'武胜县',3,511600,0,0,'','','',0,0,0,5,0,0,0),(511623,0,'邻水县',3,511600,0,0,'','','',0,0,0,6,0,0,0),(511681,0,'华蓥市',3,511600,0,0,'','','',0,0,0,7,0,0,0),(511700,0,'达州市',2,51,0,0,'','','',0,0,9,15,0,0,0),(511701,0,'市辖区',3,511700,0,0,'','','',0,0,0,1,0,0,0),(511702,0,'通川区',3,511700,0,0,'','','',0,0,0,2,0,0,0),(511703,0,'达川区',3,511700,0,0,'','','',0,0,0,3,0,0,0),(511722,0,'宣汉县',3,511700,0,0,'','','',0,0,0,4,0,0,0),(511723,0,'开江县',3,511700,0,0,'','','',0,0,0,5,0,0,0),(511724,0,'大竹县',3,511700,0,0,'','','',0,0,0,6,0,0,0),(511725,0,'渠县',3,511700,0,0,'','','',0,0,0,7,0,0,0),(511771,0,'达州经济开发区',3,511700,0,0,'','','',0,0,0,8,0,0,0),(511781,0,'万源市',3,511700,0,0,'','','',0,0,0,9,0,0,0),(511800,0,'雅安市',2,51,0,0,'','','',0,0,9,16,0,0,0),(511801,0,'市辖区',3,511800,0,0,'','','',0,0,0,1,0,0,0),(511802,0,'雨城区',3,511800,0,0,'','','',0,0,0,2,0,0,0),(511803,0,'名山区',3,511800,0,0,'','','',0,0,0,3,0,0,0),(511822,0,'荥经县',3,511800,0,0,'','','',0,0,0,4,0,0,0),(511823,0,'汉源县',3,511800,0,0,'','','',0,0,0,5,0,0,0),(511824,0,'石棉县',3,511800,0,0,'','','',0,0,0,6,0,0,0),(511825,0,'天全县',3,511800,0,0,'','','',0,0,0,7,0,0,0),(511826,0,'芦山县',3,511800,0,0,'','','',0,0,0,8,0,0,0),(511827,0,'宝兴县',3,511800,0,0,'','','',0,0,0,9,0,0,0),(511900,0,'巴中市',2,51,0,0,'','','',0,0,7,17,0,0,0),(511901,0,'市辖区',3,511900,0,0,'','','',0,0,0,1,0,0,0),(511902,0,'巴州区',3,511900,0,0,'','','',0,0,0,2,0,0,0),(511903,0,'恩阳区',3,511900,0,0,'','','',0,0,0,3,0,0,0),(511921,0,'通江县',3,511900,0,0,'','','',0,0,0,4,0,0,0),(511922,0,'南江县',3,511900,0,0,'','','',0,0,0,5,0,0,0),(511923,0,'平昌县',3,511900,0,0,'','','',0,0,0,6,0,0,0),(511971,0,'巴中经济开发区',3,511900,0,0,'','','',0,0,0,7,0,0,0),(512000,0,'资阳市',2,51,0,0,'','','',0,0,4,18,0,0,0),(512001,0,'市辖区',3,512000,0,0,'','','',0,0,0,1,0,0,0),(512002,0,'雁江区',3,512000,0,0,'','','',0,0,0,2,0,0,0),(512021,0,'安岳县',3,512000,0,0,'','','',0,0,0,3,0,0,0),(512022,0,'乐至县',3,512000,0,0,'','','',0,0,0,4,0,0,0),(513200,0,'阿坝藏族羌族自治州',2,51,0,0,'','','',0,0,13,19,0,0,0),(513201,0,'马尔康市',3,513200,0,0,'','','',0,0,0,1,0,0,0),(513221,0,'汶川县',3,513200,0,0,'','','',0,0,0,2,0,0,0),(513222,0,'理县',3,513200,0,0,'','','',0,0,0,3,0,0,0),(513223,0,'茂县',3,513200,0,0,'','','',0,0,0,4,0,0,0),(513224,0,'松潘县',3,513200,0,0,'','','',0,0,0,5,0,0,0),(513225,0,'九寨沟县',3,513200,0,0,'','','',0,0,0,6,0,0,0),(513226,0,'金川县',3,513200,0,0,'','','',0,0,0,7,0,0,0),(513227,0,'小金县',3,513200,0,0,'','','',0,0,0,8,0,0,0),(513228,0,'黑水县',3,513200,0,0,'','','',0,0,0,9,0,0,0),(513230,0,'壤塘县',3,513200,0,0,'','','',0,0,0,10,0,0,0),(513231,0,'阿坝县',3,513200,0,0,'','','',0,0,0,11,0,0,0),(513232,0,'若尔盖县',3,513200,0,0,'','','',0,0,0,12,0,0,0),(513233,0,'红原县',3,513200,0,0,'','','',0,0,0,13,0,0,0),(513300,0,'甘孜藏族自治州',2,51,0,0,'','','',0,0,18,20,0,0,0),(513301,0,'康定市',3,513300,0,0,'','','',0,0,0,1,0,0,0),(513322,0,'泸定县',3,513300,0,0,'','','',0,0,0,2,0,0,0),(513323,0,'丹巴县',3,513300,0,0,'','','',0,0,0,3,0,0,0),(513324,0,'九龙县',3,513300,0,0,'','','',0,0,0,4,0,0,0),(513325,0,'雅江县',3,513300,0,0,'','','',0,0,0,5,0,0,0),(513326,0,'道孚县',3,513300,0,0,'','','',0,0,0,6,0,0,0),(513327,0,'炉霍县',3,513300,0,0,'','','',0,0,0,7,0,0,0),(513328,0,'甘孜县',3,513300,0,0,'','','',0,0,0,8,0,0,0),(513329,0,'新龙县',3,513300,0,0,'','','',0,0,0,9,0,0,0),(513330,0,'德格县',3,513300,0,0,'','','',0,0,0,10,0,0,0),(513331,0,'白玉县',3,513300,0,0,'','','',0,0,0,11,0,0,0),(513332,0,'石渠县',3,513300,0,0,'','','',0,0,0,12,0,0,0),(513333,0,'色达县',3,513300,0,0,'','','',0,0,0,13,0,0,0),(513334,0,'理塘县',3,513300,0,0,'','','',0,0,0,14,0,0,0),(513335,0,'巴塘县',3,513300,0,0,'','','',0,0,0,15,0,0,0),(513336,0,'乡城县',3,513300,0,0,'','','',0,0,0,16,0,0,0),(513337,0,'稻城县',3,513300,0,0,'','','',0,0,0,17,0,0,0),(513338,0,'得荣县',3,513300,0,0,'','','',0,0,0,18,0,0,0),(513400,0,'凉山彝族自治州',2,51,0,0,'','','',0,0,17,21,0,0,0),(513401,0,'西昌市',3,513400,0,0,'','','',0,0,0,1,0,0,0),(513422,0,'木里藏族自治县',3,513400,0,0,'','','',0,0,0,2,0,0,0),(513423,0,'盐源县',3,513400,0,0,'','','',0,0,0,3,0,0,0),(513424,0,'德昌县',3,513400,0,0,'','','',0,0,0,4,0,0,0),(513425,0,'会理县',3,513400,0,0,'','','',0,0,0,5,0,0,0),(513426,0,'会东县',3,513400,0,0,'','','',0,0,0,6,0,0,0),(513427,0,'宁南县',3,513400,0,0,'','','',0,0,0,7,0,0,0),(513428,0,'普格县',3,513400,0,0,'','','',0,0,0,8,0,0,0),(513429,0,'布拖县',3,513400,0,0,'','','',0,0,0,9,0,0,0),(513430,0,'金阳县',3,513400,0,0,'','','',0,0,0,10,0,0,0),(513431,0,'昭觉县',3,513400,0,0,'','','',0,0,0,11,0,0,0),(513432,0,'喜德县',3,513400,0,0,'','','',0,0,0,12,0,0,0),(513433,0,'冕宁县',3,513400,0,0,'','','',0,0,0,13,0,0,0),(513434,0,'越西县',3,513400,0,0,'','','',0,0,0,14,0,0,0),(513435,0,'甘洛县',3,513400,0,0,'','','',0,0,0,15,0,0,0),(513436,0,'美姑县',3,513400,0,0,'','','',0,0,0,16,0,0,0),(513437,0,'雷波县',3,513400,0,0,'','','',0,0,0,17,0,0,0),(520100,0,'贵阳市',2,52,0,0,'','','',0,0,11,1,0,0,0),(520101,0,'市辖区',3,520100,0,0,'','','',0,0,0,1,0,0,0),(520102,0,'南明区',3,520100,0,0,'','','',0,0,0,2,0,0,0),(520103,0,'云岩区',3,520100,0,0,'','','',0,0,0,3,0,0,0),(520111,0,'花溪区',3,520100,0,0,'','','',0,0,0,4,0,0,0),(520112,0,'乌当区',3,520100,0,0,'','','',0,0,0,5,0,0,0),(520113,0,'白云区',3,520100,0,0,'','','',0,0,0,6,0,0,0),(520115,0,'观山湖区',3,520100,0,0,'','','',0,0,0,7,0,0,0),(520121,0,'开阳县',3,520100,0,0,'','','',0,0,0,8,0,0,0),(520122,0,'息烽县',3,520100,0,0,'','','',0,0,0,9,0,0,0),(520123,0,'修文县',3,520100,0,0,'','','',0,0,0,10,0,0,0),(520181,0,'清镇市',3,520100,0,0,'','','',0,0,0,11,0,0,0),(520200,0,'六盘水市',2,52,0,0,'','','',0,0,4,2,0,0,0),(520201,0,'钟山区',3,520200,0,0,'','','',0,0,0,1,0,0,0),(520203,0,'六枝特区',3,520200,0,0,'','','',0,0,0,2,0,0,0),(520221,0,'水城县',3,520200,0,0,'','','',0,0,0,3,0,0,0),(520281,0,'盘州市',3,520200,0,0,'','','',0,0,0,4,0,0,0),(520300,0,'遵义市',2,52,0,0,'','','',0,0,15,3,0,0,0),(520301,0,'市辖区',3,520300,0,0,'','','',0,0,0,1,0,0,0),(520302,0,'红花岗区',3,520300,0,0,'','','',0,0,0,2,0,0,0),(520303,0,'汇川区',3,520300,0,0,'','','',0,0,0,3,0,0,0),(520304,0,'播州区',3,520300,0,0,'','','',0,0,0,4,0,0,0),(520322,0,'桐梓县',3,520300,0,0,'','','',0,0,0,5,0,0,0),(520323,0,'绥阳县',3,520300,0,0,'','','',0,0,0,6,0,0,0),(520324,0,'正安县',3,520300,0,0,'','','',0,0,0,7,0,0,0),(520325,0,'道真仡佬族苗族自治县',3,520300,0,0,'','','',0,0,0,8,0,0,0),(520326,0,'务川仡佬族苗族自治县',3,520300,0,0,'','','',0,0,0,9,0,0,0),(520327,0,'凤冈县',3,520300,0,0,'','','',0,0,0,10,0,0,0),(520328,0,'湄潭县',3,520300,0,0,'','','',0,0,0,11,0,0,0),(520329,0,'余庆县',3,520300,0,0,'','','',0,0,0,12,0,0,0),(520330,0,'习水县',3,520300,0,0,'','','',0,0,0,13,0,0,0),(520381,0,'赤水市',3,520300,0,0,'','','',0,0,0,14,0,0,0),(520382,0,'仁怀市',3,520300,0,0,'','','',0,0,0,15,0,0,0),(520400,0,'安顺市',2,52,0,0,'','','',0,0,7,4,0,0,0),(520401,0,'市辖区',3,520400,0,0,'','','',0,0,0,1,0,0,0),(520402,0,'西秀区',3,520400,0,0,'','','',0,0,0,2,0,0,0),(520403,0,'平坝区',3,520400,0,0,'','','',0,0,0,3,0,0,0),(520422,0,'普定县',3,520400,0,0,'','','',0,0,0,4,0,0,0),(520423,0,'镇宁布依族苗族自治县',3,520400,0,0,'','','',0,0,0,5,0,0,0),(520424,0,'关岭布依族苗族自治县',3,520400,0,0,'','','',0,0,0,6,0,0,0),(520425,0,'紫云苗族布依族自治县',3,520400,0,0,'','','',0,0,0,7,0,0,0),(520500,0,'毕节市',2,52,0,0,'','','',0,0,9,5,0,0,0),(520501,0,'市辖区',3,520500,0,0,'','','',0,0,0,1,0,0,0),(520502,0,'七星关区',3,520500,0,0,'','','',0,0,0,2,0,0,0),(520521,0,'大方县',3,520500,0,0,'','','',0,0,0,3,0,0,0),(520522,0,'黔西县',3,520500,0,0,'','','',0,0,0,4,0,0,0),(520523,0,'金沙县',3,520500,0,0,'','','',0,0,0,5,0,0,0),(520524,0,'织金县',3,520500,0,0,'','','',0,0,0,6,0,0,0),(520525,0,'纳雍县',3,520500,0,0,'','','',0,0,0,7,0,0,0),(520526,0,'威宁彝族回族苗族自治县',3,520500,0,0,'','','',0,0,0,8,0,0,0),(520527,0,'赫章县',3,520500,0,0,'','','',0,0,0,9,0,0,0),(520600,0,'铜仁市',2,52,0,0,'','','',0,0,11,6,0,0,0),(520601,0,'市辖区',3,520600,0,0,'','','',0,0,0,1,0,0,0),(520602,0,'碧江区',3,520600,0,0,'','','',0,0,0,2,0,0,0),(520603,0,'万山区',3,520600,0,0,'','','',0,0,0,3,0,0,0),(520621,0,'江口县',3,520600,0,0,'','','',0,0,0,4,0,0,0),(520622,0,'玉屏侗族自治县',3,520600,0,0,'','','',0,0,0,5,0,0,0),(520623,0,'石阡县',3,520600,0,0,'','','',0,0,0,6,0,0,0),(520624,0,'思南县',3,520600,0,0,'','','',0,0,0,7,0,0,0),(520625,0,'印江土家族苗族自治县',3,520600,0,0,'','','',0,0,0,8,0,0,0),(520626,0,'德江县',3,520600,0,0,'','','',0,0,0,9,0,0,0),(520627,0,'沿河土家族自治县',3,520600,0,0,'','','',0,0,0,10,0,0,0),(520628,0,'松桃苗族自治县',3,520600,0,0,'','','',0,0,0,11,0,0,0),(522300,0,'黔西南布依族苗族自治州',2,52,0,0,'','','',0,0,8,7,0,0,0),(522301,0,'兴义市',3,522300,0,0,'','','',0,0,0,1,0,0,0),(522302,0,'兴仁市',3,522300,0,0,'','','',0,0,0,2,0,0,0),(522323,0,'普安县',3,522300,0,0,'','','',0,0,0,3,0,0,0),(522324,0,'晴隆县',3,522300,0,0,'','','',0,0,0,4,0,0,0),(522325,0,'贞丰县',3,522300,0,0,'','','',0,0,0,5,0,0,0),(522326,0,'望谟县',3,522300,0,0,'','','',0,0,0,6,0,0,0),(522327,0,'册亨县',3,522300,0,0,'','','',0,0,0,7,0,0,0),(522328,0,'安龙县',3,522300,0,0,'','','',0,0,0,8,0,0,0),(522600,0,'黔东南苗族侗族自治州',2,52,0,0,'','','',0,0,16,8,0,0,0),(522601,0,'凯里市',3,522600,0,0,'','','',0,0,0,1,0,0,0),(522622,0,'黄平县',3,522600,0,0,'','','',0,0,0,2,0,0,0),(522623,0,'施秉县',3,522600,0,0,'','','',0,0,0,3,0,0,0),(522624,0,'三穗县',3,522600,0,0,'','','',0,0,0,4,0,0,0),(522625,0,'镇远县',3,522600,0,0,'','','',0,0,0,5,0,0,0),(522626,0,'岑巩县',3,522600,0,0,'','','',0,0,0,6,0,0,0),(522627,0,'天柱县',3,522600,0,0,'','','',0,0,0,7,0,0,0),(522628,0,'锦屏县',3,522600,0,0,'','','',0,0,0,8,0,0,0),(522629,0,'剑河县',3,522600,0,0,'','','',0,0,0,9,0,0,0),(522630,0,'台江县',3,522600,0,0,'','','',0,0,0,10,0,0,0),(522631,0,'黎平县',3,522600,0,0,'','','',0,0,0,11,0,0,0),(522632,0,'榕江县',3,522600,0,0,'','','',0,0,0,12,0,0,0),(522633,0,'从江县',3,522600,0,0,'','','',0,0,0,13,0,0,0),(522634,0,'雷山县',3,522600,0,0,'','','',0,0,0,14,0,0,0),(522635,0,'麻江县',3,522600,0,0,'','','',0,0,0,15,0,0,0),(522636,0,'丹寨县',3,522600,0,0,'','','',0,0,0,16,0,0,0),(522700,0,'黔南布依族苗族自治州',2,52,0,0,'','','',0,0,12,9,0,0,0),(522701,0,'都匀市',3,522700,0,0,'','','',0,0,0,1,0,0,0),(522702,0,'福泉市',3,522700,0,0,'','','',0,0,0,2,0,0,0),(522722,0,'荔波县',3,522700,0,0,'','','',0,0,0,3,0,0,0),(522723,0,'贵定县',3,522700,0,0,'','','',0,0,0,4,0,0,0),(522725,0,'瓮安县',3,522700,0,0,'','','',0,0,0,5,0,0,0),(522726,0,'独山县',3,522700,0,0,'','','',0,0,0,6,0,0,0),(522727,0,'平塘县',3,522700,0,0,'','','',0,0,0,7,0,0,0),(522728,0,'罗甸县',3,522700,0,0,'','','',0,0,0,8,0,0,0),(522729,0,'长顺县',3,522700,0,0,'','','',0,0,0,9,0,0,0),(522730,0,'龙里县',3,522700,0,0,'','','',0,0,0,10,0,0,0),(522731,0,'惠水县',3,522700,0,0,'','','',0,0,0,11,0,0,0),(522732,0,'三都水族自治县',3,522700,0,0,'','','',0,0,0,12,0,0,0),(530100,0,'昆明市',2,53,0,0,'','','',0,0,15,1,0,0,0),(530101,0,'市辖区',3,530100,0,0,'','','',0,0,0,1,0,0,0),(530102,0,'五华区',3,530100,0,0,'','','',0,0,0,2,0,0,0),(530103,0,'盘龙区',3,530100,0,0,'','','',0,0,0,3,0,0,0),(530111,0,'官渡区',3,530100,0,0,'','','',0,0,0,4,0,0,0),(530112,0,'西山区',3,530100,0,0,'','','',0,0,0,5,0,0,0),(530113,0,'东川区',3,530100,0,0,'','','',0,0,0,6,0,0,0),(530114,0,'呈贡区',3,530100,0,0,'','','',0,0,0,7,0,0,0),(530115,0,'晋宁区',3,530100,0,0,'','','',0,0,0,8,0,0,0),(530124,0,'富民县',3,530100,0,0,'','','',0,0,0,9,0,0,0),(530125,0,'宜良县',3,530100,0,0,'','','',0,0,0,10,0,0,0),(530126,0,'石林彝族自治县',3,530100,0,0,'','','',0,0,0,11,0,0,0),(530127,0,'嵩明县',3,530100,0,0,'','','',0,0,0,12,0,0,0),(530128,0,'禄劝彝族苗族自治县',3,530100,0,0,'','','',0,0,0,13,0,0,0),(530129,0,'寻甸回族彝族自治县',3,530100,0,0,'','','',0,0,0,14,0,0,0),(530181,0,'安宁市',3,530100,0,0,'','','',0,0,0,15,0,0,0),(530300,0,'曲靖市',2,53,0,0,'','','',0,0,10,2,0,0,0),(530301,0,'市辖区',3,530300,0,0,'','','',0,0,0,1,0,0,0),(530302,0,'麒麟区',3,530300,0,0,'','','',0,0,0,2,0,0,0),(530303,0,'沾益区',3,530300,0,0,'','','',0,0,0,3,0,0,0),(530304,0,'马龙区',3,530300,0,0,'','','',0,0,0,4,0,0,0),(530322,0,'陆良县',3,530300,0,0,'','','',0,0,0,5,0,0,0),(530323,0,'师宗县',3,530300,0,0,'','','',0,0,0,6,0,0,0),(530324,0,'罗平县',3,530300,0,0,'','','',0,0,0,7,0,0,0),(530325,0,'富源县',3,530300,0,0,'','','',0,0,0,8,0,0,0),(530326,0,'会泽县',3,530300,0,0,'','','',0,0,0,9,0,0,0),(530381,0,'宣威市',3,530300,0,0,'','','',0,0,0,10,0,0,0),(530400,0,'玉溪市',2,53,0,0,'','','',0,0,10,3,0,0,0),(530401,0,'市辖区',3,530400,0,0,'','','',0,0,0,1,0,0,0),(530402,0,'红塔区',3,530400,0,0,'','','',0,0,0,2,0,0,0),(530403,0,'江川区',3,530400,0,0,'','','',0,0,0,3,0,0,0),(530422,0,'澄江县',3,530400,0,0,'','','',0,0,0,4,0,0,0),(530423,0,'通海县',3,530400,0,0,'','','',0,0,0,5,0,0,0),(530424,0,'华宁县',3,530400,0,0,'','','',0,0,0,6,0,0,0),(530425,0,'易门县',3,530400,0,0,'','','',0,0,0,7,0,0,0),(530426,0,'峨山彝族自治县',3,530400,0,0,'','','',0,0,0,8,0,0,0),(530427,0,'新平彝族傣族自治县',3,530400,0,0,'','','',0,0,0,9,0,0,0),(530428,0,'元江哈尼族彝族傣族自治县',3,530400,0,0,'','','',0,0,0,10,0,0,0),(530500,0,'保山市',2,53,0,0,'','','',0,0,6,4,0,0,0),(530501,0,'市辖区',3,530500,0,0,'','','',0,0,0,1,0,0,0),(530502,0,'隆阳区',3,530500,0,0,'','','',0,0,0,2,0,0,0),(530521,0,'施甸县',3,530500,0,0,'','','',0,0,0,3,0,0,0),(530523,0,'龙陵县',3,530500,0,0,'','','',0,0,0,4,0,0,0),(530524,0,'昌宁县',3,530500,0,0,'','','',0,0,0,5,0,0,0),(530581,0,'腾冲市',3,530500,0,0,'','','',0,0,0,6,0,0,0),(530600,0,'昭通市',2,53,0,0,'','','',0,0,12,5,0,0,0),(530601,0,'市辖区',3,530600,0,0,'','','',0,0,0,1,0,0,0),(530602,0,'昭阳区',3,530600,0,0,'','','',0,0,0,2,0,0,0),(530621,0,'鲁甸县',3,530600,0,0,'','','',0,0,0,3,0,0,0),(530622,0,'巧家县',3,530600,0,0,'','','',0,0,0,4,0,0,0),(530623,0,'盐津县',3,530600,0,0,'','','',0,0,0,5,0,0,0),(530624,0,'大关县',3,530600,0,0,'','','',0,0,0,6,0,0,0),(530625,0,'永善县',3,530600,0,0,'','','',0,0,0,7,0,0,0),(530626,0,'绥江县',3,530600,0,0,'','','',0,0,0,8,0,0,0),(530627,0,'镇雄县',3,530600,0,0,'','','',0,0,0,9,0,0,0),(530628,0,'彝良县',3,530600,0,0,'','','',0,0,0,10,0,0,0),(530629,0,'威信县',3,530600,0,0,'','','',0,0,0,11,0,0,0),(530681,0,'水富市',3,530600,0,0,'','','',0,0,0,12,0,0,0),(530700,0,'丽江市',2,53,0,0,'','','',0,0,6,6,0,0,0),(530701,0,'市辖区',3,530700,0,0,'','','',0,0,0,1,0,0,0),(530702,0,'古城区',3,530700,0,0,'','','',0,0,0,2,0,0,0),(530721,0,'玉龙纳西族自治县',3,530700,0,0,'','','',0,0,0,3,0,0,0),(530722,0,'永胜县',3,530700,0,0,'','','',0,0,0,4,0,0,0),(530723,0,'华坪县',3,530700,0,0,'','','',0,0,0,5,0,0,0),(530724,0,'宁蒗彝族自治县',3,530700,0,0,'','','',0,0,0,6,0,0,0),(530800,0,'普洱市',2,53,0,0,'','','',0,0,11,7,0,0,0),(530801,0,'市辖区',3,530800,0,0,'','','',0,0,0,1,0,0,0),(530802,0,'思茅区',3,530800,0,0,'','','',0,0,0,2,0,0,0),(530821,0,'宁洱哈尼族彝族自治县',3,530800,0,0,'','','',0,0,0,3,0,0,0),(530822,0,'墨江哈尼族自治县',3,530800,0,0,'','','',0,0,0,4,0,0,0),(530823,0,'景东彝族自治县',3,530800,0,0,'','','',0,0,0,5,0,0,0),(530824,0,'景谷傣族彝族自治县',3,530800,0,0,'','','',0,0,0,6,0,0,0),(530825,0,'镇沅彝族哈尼族拉祜族自治县',3,530800,0,0,'','','',0,0,0,7,0,0,0),(530826,0,'江城哈尼族彝族自治县',3,530800,0,0,'','','',0,0,0,8,0,0,0),(530827,0,'孟连傣族拉祜族佤族自治县',3,530800,0,0,'','','',0,0,0,9,0,0,0),(530828,0,'澜沧拉祜族自治县',3,530800,0,0,'','','',0,0,0,10,0,0,0),(530829,0,'西盟佤族自治县',3,530800,0,0,'','','',0,0,0,11,0,0,0),(530900,0,'临沧市',2,53,0,0,'','','',0,0,9,8,0,0,0),(530901,0,'市辖区',3,530900,0,0,'','','',0,0,0,1,0,0,0),(530902,0,'临翔区',3,530900,0,0,'','','',0,0,0,2,0,0,0),(530921,0,'凤庆县',3,530900,0,0,'','','',0,0,0,3,0,0,0),(530922,0,'云县',3,530900,0,0,'','','',0,0,0,4,0,0,0),(530923,0,'永德县',3,530900,0,0,'','','',0,0,0,5,0,0,0),(530924,0,'镇康县',3,530900,0,0,'','','',0,0,0,6,0,0,0),(530925,0,'双江拉祜族佤族布朗族傣族自治县',3,530900,0,0,'','','',0,0,0,7,0,0,0),(530926,0,'耿马傣族佤族自治县',3,530900,0,0,'','','',0,0,0,8,0,0,0),(530927,0,'沧源佤族自治县',3,530900,0,0,'','','',0,0,0,9,0,0,0),(532300,0,'楚雄彝族自治州',2,53,0,0,'','','',0,0,10,9,0,0,0),(532301,0,'楚雄市',3,532300,0,0,'','','',0,0,0,1,0,0,0),(532322,0,'双柏县',3,532300,0,0,'','','',0,0,0,2,0,0,0),(532323,0,'牟定县',3,532300,0,0,'','','',0,0,0,3,0,0,0),(532324,0,'南华县',3,532300,0,0,'','','',0,0,0,4,0,0,0),(532325,0,'姚安县',3,532300,0,0,'','','',0,0,0,5,0,0,0),(532326,0,'大姚县',3,532300,0,0,'','','',0,0,0,6,0,0,0),(532327,0,'永仁县',3,532300,0,0,'','','',0,0,0,7,0,0,0),(532328,0,'元谋县',3,532300,0,0,'','','',0,0,0,8,0,0,0),(532329,0,'武定县',3,532300,0,0,'','','',0,0,0,9,0,0,0),(532331,0,'禄丰县',3,532300,0,0,'','','',0,0,0,10,0,0,0),(532500,0,'红河哈尼族彝族自治州',2,53,0,0,'','','',0,0,13,10,0,0,0),(532501,0,'个旧市',3,532500,0,0,'','','',0,0,0,1,0,0,0),(532502,0,'开远市',3,532500,0,0,'','','',0,0,0,2,0,0,0),(532503,0,'蒙自市',3,532500,0,0,'','','',0,0,0,3,0,0,0),(532504,0,'弥勒市',3,532500,0,0,'','','',0,0,0,4,0,0,0),(532523,0,'屏边苗族自治县',3,532500,0,0,'','','',0,0,0,5,0,0,0),(532524,0,'建水县',3,532500,0,0,'','','',0,0,0,6,0,0,0),(532525,0,'石屏县',3,532500,0,0,'','','',0,0,0,7,0,0,0),(532527,0,'泸西县',3,532500,0,0,'','','',0,0,0,8,0,0,0),(532528,0,'元阳县',3,532500,0,0,'','','',0,0,0,9,0,0,0),(532529,0,'红河县',3,532500,0,0,'','','',0,0,0,10,0,0,0),(532530,0,'金平苗族瑶族傣族自治县',3,532500,0,0,'','','',0,0,0,11,0,0,0),(532531,0,'绿春县',3,532500,0,0,'','','',0,0,0,12,0,0,0),(532532,0,'河口瑶族自治县',3,532500,0,0,'','','',0,0,0,13,0,0,0),(532600,0,'文山壮族苗族自治州',2,53,0,0,'','','',0,0,8,11,0,0,0),(532601,0,'文山市',3,532600,0,0,'','','',0,0,0,1,0,0,0),(532622,0,'砚山县',3,532600,0,0,'','','',0,0,0,2,0,0,0),(532623,0,'西畴县',3,532600,0,0,'','','',0,0,0,3,0,0,0),(532624,0,'麻栗坡县',3,532600,0,0,'','','',0,0,0,4,0,0,0),(532625,0,'马关县',3,532600,0,0,'','','',0,0,0,5,0,0,0),(532626,0,'丘北县',3,532600,0,0,'','','',0,0,0,6,0,0,0),(532627,0,'广南县',3,532600,0,0,'','','',0,0,0,7,0,0,0),(532628,0,'富宁县',3,532600,0,0,'','','',0,0,0,8,0,0,0),(532800,0,'西双版纳傣族自治州',2,53,0,0,'','','',0,0,3,12,0,0,0),(532801,0,'景洪市',3,532800,0,0,'','','',0,0,0,1,0,0,0),(532822,0,'勐海县',3,532800,0,0,'','','',0,0,0,2,0,0,0),(532823,0,'勐腊县',3,532800,0,0,'','','',0,0,0,3,0,0,0),(532900,0,'大理白族自治州',2,53,0,0,'','','',0,0,12,13,0,0,0),(532901,0,'大理市',3,532900,0,0,'','','',0,0,0,1,0,0,0),(532922,0,'漾濞彝族自治县',3,532900,0,0,'','','',0,0,0,2,0,0,0),(532923,0,'祥云县',3,532900,0,0,'','','',0,0,0,3,0,0,0),(532924,0,'宾川县',3,532900,0,0,'','','',0,0,0,4,0,0,0),(532925,0,'弥渡县',3,532900,0,0,'','','',0,0,0,5,0,0,0),(532926,0,'南涧彝族自治县',3,532900,0,0,'','','',0,0,0,6,0,0,0),(532927,0,'巍山彝族回族自治县',3,532900,0,0,'','','',0,0,0,7,0,0,0),(532928,0,'永平县',3,532900,0,0,'','','',0,0,0,8,0,0,0),(532929,0,'云龙县',3,532900,0,0,'','','',0,0,0,9,0,0,0),(532930,0,'洱源县',3,532900,0,0,'','','',0,0,0,10,0,0,0),(532931,0,'剑川县',3,532900,0,0,'','','',0,0,0,11,0,0,0),(532932,0,'鹤庆县',3,532900,0,0,'','','',0,0,0,12,0,0,0),(533100,0,'德宏傣族景颇族自治州',2,53,0,0,'','','',0,0,5,14,0,0,0),(533102,0,'瑞丽市',3,533100,0,0,'','','',0,0,0,1,0,0,0),(533103,0,'芒市',3,533100,0,0,'','','',0,0,0,2,0,0,0),(533122,0,'梁河县',3,533100,0,0,'','','',0,0,0,3,0,0,0),(533123,0,'盈江县',3,533100,0,0,'','','',0,0,0,4,0,0,0),(533124,0,'陇川县',3,533100,0,0,'','','',0,0,0,5,0,0,0),(533300,0,'怒江傈僳族自治州',2,53,0,0,'','','',0,0,4,15,0,0,0),(533301,0,'泸水市',3,533300,0,0,'','','',0,0,0,1,0,0,0),(533323,0,'福贡县',3,533300,0,0,'','','',0,0,0,2,0,0,0),(533324,0,'贡山独龙族怒族自治县',3,533300,0,0,'','','',0,0,0,3,0,0,0),(533325,0,'兰坪白族普米族自治县',3,533300,0,0,'','','',0,0,0,4,0,0,0),(533400,0,'迪庆藏族自治州',2,53,0,0,'','','',0,0,3,16,0,0,0),(533401,0,'香格里拉市',3,533400,0,0,'','','',0,0,0,1,0,0,0),(533422,0,'德钦县',3,533400,0,0,'','','',0,0,0,2,0,0,0),(533423,0,'维西傈僳族自治县',3,533400,0,0,'','','',0,0,0,3,0,0,0),(540100,0,'拉萨市',2,54,0,0,'','','',0,0,13,1,0,0,0),(540101,0,'市辖区',3,540100,0,0,'','','',0,0,0,1,0,0,0),(540102,0,'城关区',3,540100,0,0,'','','',0,0,0,2,0,0,0),(540103,0,'堆龙德庆区',3,540100,0,0,'','','',0,0,0,3,0,0,0),(540104,0,'达孜区',3,540100,0,0,'','','',0,0,0,4,0,0,0),(540121,0,'林周县',3,540100,0,0,'','','',0,0,0,5,0,0,0),(540122,0,'当雄县',3,540100,0,0,'','','',0,0,0,6,0,0,0),(540123,0,'尼木县',3,540100,0,0,'','','',0,0,0,7,0,0,0),(540124,0,'曲水县',3,540100,0,0,'','','',0,0,0,8,0,0,0),(540127,0,'墨竹工卡县',3,540100,0,0,'','','',0,0,0,9,0,0,0),(540171,0,'格尔木藏青工业园区',3,540100,0,0,'','','',0,0,0,10,0,0,0),(540172,0,'拉萨经济技术开发区',3,540100,0,0,'','','',0,0,0,11,0,0,0),(540173,0,'西藏文化旅游创意园区',3,540100,0,0,'','','',0,0,0,12,0,0,0),(540174,0,'达孜工业园区',3,540100,0,0,'','','',0,0,0,13,0,0,0),(540200,0,'日喀则市',2,54,0,0,'','','',0,0,18,2,0,0,0),(540202,0,'桑珠孜区',3,540200,0,0,'','','',0,0,0,1,0,0,0),(540221,0,'南木林县',3,540200,0,0,'','','',0,0,0,2,0,0,0),(540222,0,'江孜县',3,540200,0,0,'','','',0,0,0,3,0,0,0),(540223,0,'定日县',3,540200,0,0,'','','',0,0,0,4,0,0,0),(540224,0,'萨迦县',3,540200,0,0,'','','',0,0,0,5,0,0,0),(540225,0,'拉孜县',3,540200,0,0,'','','',0,0,0,6,0,0,0),(540226,0,'昂仁县',3,540200,0,0,'','','',0,0,0,7,0,0,0),(540227,0,'谢通门县',3,540200,0,0,'','','',0,0,0,8,0,0,0),(540228,0,'白朗县',3,540200,0,0,'','','',0,0,0,9,0,0,0),(540229,0,'仁布县',3,540200,0,0,'','','',0,0,0,10,0,0,0),(540230,0,'康马县',3,540200,0,0,'','','',0,0,0,11,0,0,0),(540231,0,'定结县',3,540200,0,0,'','','',0,0,0,12,0,0,0),(540232,0,'仲巴县',3,540200,0,0,'','','',0,0,0,13,0,0,0),(540233,0,'亚东县',3,540200,0,0,'','','',0,0,0,14,0,0,0),(540234,0,'吉隆县',3,540200,0,0,'','','',0,0,0,15,0,0,0),(540235,0,'聂拉木县',3,540200,0,0,'','','',0,0,0,16,0,0,0),(540236,0,'萨嘎县',3,540200,0,0,'','','',0,0,0,17,0,0,0),(540237,0,'岗巴县',3,540200,0,0,'','','',0,0,0,18,0,0,0),(540300,0,'昌都市',2,54,0,0,'','','',0,0,11,3,0,0,0),(540302,0,'卡若区',3,540300,0,0,'','','',0,0,0,1,0,0,0),(540321,0,'江达县',3,540300,0,0,'','','',0,0,0,2,0,0,0),(540322,0,'贡觉县',3,540300,0,0,'','','',0,0,0,3,0,0,0),(540323,0,'类乌齐县',3,540300,0,0,'','','',0,0,0,4,0,0,0),(540324,0,'丁青县',3,540300,0,0,'','','',0,0,0,5,0,0,0),(540325,0,'察雅县',3,540300,0,0,'','','',0,0,0,6,0,0,0),(540326,0,'八宿县',3,540300,0,0,'','','',0,0,0,7,0,0,0),(540327,0,'左贡县',3,540300,0,0,'','','',0,0,0,8,0,0,0),(540328,0,'芒康县',3,540300,0,0,'','','',0,0,0,9,0,0,0),(540329,0,'洛隆县',3,540300,0,0,'','','',0,0,0,10,0,0,0),(540330,0,'边坝县',3,540300,0,0,'','','',0,0,0,11,0,0,0),(540400,0,'林芝市',2,54,0,0,'','','',0,0,7,4,0,0,0),(540402,0,'巴宜区',3,540400,0,0,'','','',0,0,0,1,0,0,0),(540421,0,'工布江达县',3,540400,0,0,'','','',0,0,0,2,0,0,0),(540422,0,'米林县',3,540400,0,0,'','','',0,0,0,3,0,0,0),(540423,0,'墨脱县',3,540400,0,0,'','','',0,0,0,4,0,0,0),(540424,0,'波密县',3,540400,0,0,'','','',0,0,0,5,0,0,0),(540425,0,'察隅县',3,540400,0,0,'','','',0,0,0,6,0,0,0),(540426,0,'朗县',3,540400,0,0,'','','',0,0,0,7,0,0,0),(540500,0,'山南市',2,54,0,0,'','','',0,0,13,5,0,0,0),(540501,0,'市辖区',3,540500,0,0,'','','',0,0,0,1,0,0,0),(540502,0,'乃东区',3,540500,0,0,'','','',0,0,0,2,0,0,0),(540521,0,'扎囊县',3,540500,0,0,'','','',0,0,0,3,0,0,0),(540522,0,'贡嘎县',3,540500,0,0,'','','',0,0,0,4,0,0,0),(540523,0,'桑日县',3,540500,0,0,'','','',0,0,0,5,0,0,0),(540524,0,'琼结县',3,540500,0,0,'','','',0,0,0,6,0,0,0),(540525,0,'曲松县',3,540500,0,0,'','','',0,0,0,7,0,0,0),(540526,0,'措美县',3,540500,0,0,'','','',0,0,0,8,0,0,0),(540527,0,'洛扎县',3,540500,0,0,'','','',0,0,0,9,0,0,0),(540528,0,'加查县',3,540500,0,0,'','','',0,0,0,10,0,0,0),(540529,0,'隆子县',3,540500,0,0,'','','',0,0,0,11,0,0,0),(540530,0,'错那县',3,540500,0,0,'','','',0,0,0,12,0,0,0),(540531,0,'浪卡子县',3,540500,0,0,'','','',0,0,0,13,0,0,0),(540600,0,'那曲市',2,54,0,0,'','','',0,0,11,6,0,0,0),(540602,0,'色尼区',3,540600,0,0,'','','',0,0,0,1,0,0,0),(540621,0,'嘉黎县',3,540600,0,0,'','','',0,0,0,2,0,0,0),(540622,0,'比如县',3,540600,0,0,'','','',0,0,0,3,0,0,0),(540623,0,'聂荣县',3,540600,0,0,'','','',0,0,0,4,0,0,0),(540624,0,'安多县',3,540600,0,0,'','','',0,0,0,5,0,0,0),(540625,0,'申扎县',3,540600,0,0,'','','',0,0,0,6,0,0,0),(540626,0,'索县',3,540600,0,0,'','','',0,0,0,7,0,0,0),(540627,0,'班戈县',3,540600,0,0,'','','',0,0,0,8,0,0,0),(540628,0,'巴青县',3,540600,0,0,'','','',0,0,0,9,0,0,0),(540629,0,'尼玛县',3,540600,0,0,'','','',0,0,0,10,0,0,0),(540630,0,'双湖县',3,540600,0,0,'','','',0,0,0,11,0,0,0),(542500,0,'阿里地区',2,54,0,0,'','','',0,0,7,7,0,0,0),(542521,0,'普兰县',3,542500,0,0,'','','',0,0,0,1,0,0,0),(542522,0,'札达县',3,542500,0,0,'','','',0,0,0,2,0,0,0),(542523,0,'噶尔县',3,542500,0,0,'','','',0,0,0,3,0,0,0),(542524,0,'日土县',3,542500,0,0,'','','',0,0,0,4,0,0,0),(542525,0,'革吉县',3,542500,0,0,'','','',0,0,0,5,0,0,0),(542526,0,'改则县',3,542500,0,0,'','','',0,0,0,6,0,0,0),(542527,0,'措勤县',3,542500,0,0,'','','',0,0,0,7,0,0,0),(610100,0,'西安市',2,61,0,0,'','','',0,0,14,1,0,0,0),(610101,0,'市辖区',3,610100,0,0,'','','',0,0,0,1,0,0,0),(610102,0,'新城区',3,610100,0,0,'','','',0,0,0,2,0,0,0),(610103,0,'碑林区',3,610100,0,0,'','','',0,0,0,3,0,0,0),(610104,0,'莲湖区',3,610100,0,0,'','','',0,0,0,4,0,0,0),(610111,0,'灞桥区',3,610100,0,0,'','','',0,0,0,5,0,0,0),(610112,0,'未央区',3,610100,0,0,'','','',0,0,0,6,0,0,0),(610113,0,'雁塔区',3,610100,0,0,'','','',0,0,0,7,0,0,0),(610114,0,'阎良区',3,610100,0,0,'','','',0,0,0,8,0,0,0),(610115,0,'临潼区',3,610100,0,0,'','','',0,0,0,9,0,0,0),(610116,0,'长安区',3,610100,0,0,'','','',0,0,0,10,0,0,0),(610117,0,'高陵区',3,610100,0,0,'','','',0,0,0,11,0,0,0),(610118,0,'鄠邑区',3,610100,0,0,'','','',0,0,0,12,0,0,0),(610122,0,'蓝田县',3,610100,0,0,'','','',0,0,0,13,0,0,0),(610124,0,'周至县',3,610100,0,0,'','','',0,0,0,14,0,0,0),(610200,0,'铜川市',2,61,0,0,'','','',0,0,5,2,0,0,0),(610201,0,'市辖区',3,610200,0,0,'','','',0,0,0,1,0,0,0),(610202,0,'王益区',3,610200,0,0,'','','',0,0,0,2,0,0,0),(610203,0,'印台区',3,610200,0,0,'','','',0,0,0,3,0,0,0),(610204,0,'耀州区',3,610200,0,0,'','','',0,0,0,4,0,0,0),(610222,0,'宜君县',3,610200,0,0,'','','',0,0,0,5,0,0,0),(610300,0,'宝鸡市',2,61,0,0,'','','',0,0,13,3,0,0,0),(610301,0,'市辖区',3,610300,0,0,'','','',0,0,0,1,0,0,0),(610302,0,'渭滨区',3,610300,0,0,'','','',0,0,0,2,0,0,0),(610303,0,'金台区',3,610300,0,0,'','','',0,0,0,3,0,0,0),(610304,0,'陈仓区',3,610300,0,0,'','','',0,0,0,4,0,0,0),(610322,0,'凤翔县',3,610300,0,0,'','','',0,0,0,5,0,0,0),(610323,0,'岐山县',3,610300,0,0,'','','',0,0,0,6,0,0,0),(610324,0,'扶风县',3,610300,0,0,'','','',0,0,0,7,0,0,0),(610326,0,'眉县',3,610300,0,0,'','','',0,0,0,8,0,0,0),(610327,0,'陇县',3,610300,0,0,'','','',0,0,0,9,0,0,0),(610328,0,'千阳县',3,610300,0,0,'','','',0,0,0,10,0,0,0),(610329,0,'麟游县',3,610300,0,0,'','','',0,0,0,11,0,0,0),(610330,0,'凤县',3,610300,0,0,'','','',0,0,0,12,0,0,0),(610331,0,'太白县',3,610300,0,0,'','','',0,0,0,13,0,0,0),(610400,0,'咸阳市',2,61,0,0,'','','',0,0,15,4,0,0,0),(610401,0,'市辖区',3,610400,0,0,'','','',0,0,0,1,0,0,0),(610402,0,'秦都区',3,610400,0,0,'','','',0,0,0,2,0,0,0),(610403,0,'杨陵区',3,610400,0,0,'','','',0,0,0,3,0,0,0),(610404,0,'渭城区',3,610400,0,0,'','','',0,0,0,4,0,0,0),(610422,0,'三原县',3,610400,0,0,'','','',0,0,0,5,0,0,0),(610423,0,'泾阳县',3,610400,0,0,'','','',0,0,0,6,0,0,0),(610424,0,'乾县',3,610400,0,0,'','','',0,0,0,7,0,0,0),(610425,0,'礼泉县',3,610400,0,0,'','','',0,0,0,8,0,0,0),(610426,0,'永寿县',3,610400,0,0,'','','',0,0,0,9,0,0,0),(610428,0,'长武县',3,610400,0,0,'','','',0,0,0,10,0,0,0),(610429,0,'旬邑县',3,610400,0,0,'','','',0,0,0,11,0,0,0),(610430,0,'淳化县',3,610400,0,0,'','','',0,0,0,12,0,0,0),(610431,0,'武功县',3,610400,0,0,'','','',0,0,0,13,0,0,0),(610481,0,'兴平市',3,610400,0,0,'','','',0,0,0,14,0,0,0),(610482,0,'彬州市',3,610400,0,0,'','','',0,0,0,15,0,0,0),(610500,0,'渭南市',2,61,0,0,'','','',0,0,12,5,0,0,0),(610501,0,'市辖区',3,610500,0,0,'','','',0,0,0,1,0,0,0),(610502,0,'临渭区',3,610500,0,0,'','','',0,0,0,2,0,0,0),(610503,0,'华州区',3,610500,0,0,'','','',0,0,0,3,0,0,0),(610522,0,'潼关县',3,610500,0,0,'','','',0,0,0,4,0,0,0),(610523,0,'大荔县',3,610500,0,0,'','','',0,0,0,5,0,0,0),(610524,0,'合阳县',3,610500,0,0,'','','',0,0,0,6,0,0,0),(610525,0,'澄城县',3,610500,0,0,'','','',0,0,0,7,0,0,0),(610526,0,'蒲城县',3,610500,0,0,'','','',0,0,0,8,0,0,0),(610527,0,'白水县',3,610500,0,0,'','','',0,0,0,9,0,0,0),(610528,0,'富平县',3,610500,0,0,'','','',0,0,0,10,0,0,0),(610581,0,'韩城市',3,610500,0,0,'','','',0,0,0,11,0,0,0),(610582,0,'华阴市',3,610500,0,0,'','','',0,0,0,12,0,0,0),(610600,0,'延安市',2,61,0,0,'','','',0,0,14,6,0,0,0),(610601,0,'市辖区',3,610600,0,0,'','','',0,0,0,1,0,0,0),(610602,0,'宝塔区',3,610600,0,0,'','','',0,0,0,2,0,0,0),(610603,0,'安塞区',3,610600,0,0,'','','',0,0,0,3,0,0,0),(610621,0,'延长县',3,610600,0,0,'','','',0,0,0,4,0,0,0),(610622,0,'延川县',3,610600,0,0,'','','',0,0,0,5,0,0,0),(610625,0,'志丹县',3,610600,0,0,'','','',0,0,0,6,0,0,0),(610626,0,'吴起县',3,610600,0,0,'','','',0,0,0,7,0,0,0),(610627,0,'甘泉县',3,610600,0,0,'','','',0,0,0,8,0,0,0),(610628,0,'富县',3,610600,0,0,'','','',0,0,0,9,0,0,0),(610629,0,'洛川县',3,610600,0,0,'','','',0,0,0,10,0,0,0),(610630,0,'宜川县',3,610600,0,0,'','','',0,0,0,11,0,0,0),(610631,0,'黄龙县',3,610600,0,0,'','','',0,0,0,12,0,0,0),(610632,0,'黄陵县',3,610600,0,0,'','','',0,0,0,13,0,0,0),(610681,0,'子长市',3,610600,0,0,'','','',0,0,0,14,0,0,0),(610700,0,'汉中市',2,61,0,0,'','','',0,0,12,7,0,0,0),(610701,0,'市辖区',3,610700,0,0,'','','',0,0,0,1,0,0,0),(610702,0,'汉台区',3,610700,0,0,'','','',0,0,0,2,0,0,0),(610703,0,'南郑区',3,610700,0,0,'','','',0,0,0,3,0,0,0),(610722,0,'城固县',3,610700,0,0,'','','',0,0,0,4,0,0,0),(610723,0,'洋县',3,610700,0,0,'','','',0,0,0,5,0,0,0),(610724,0,'西乡县',3,610700,0,0,'','','',0,0,0,6,0,0,0),(610725,0,'勉县',3,610700,0,0,'','','',0,0,0,7,0,0,0),(610726,0,'宁强县',3,610700,0,0,'','','',0,0,0,8,0,0,0),(610727,0,'略阳县',3,610700,0,0,'','','',0,0,0,9,0,0,0),(610728,0,'镇巴县',3,610700,0,0,'','','',0,0,0,10,0,0,0),(610729,0,'留坝县',3,610700,0,0,'','','',0,0,0,11,0,0,0),(610730,0,'佛坪县',3,610700,0,0,'','','',0,0,0,12,0,0,0),(610800,0,'榆林市',2,61,0,0,'','','',0,0,13,8,0,0,0),(610801,0,'市辖区',3,610800,0,0,'','','',0,0,0,1,0,0,0),(610802,0,'榆阳区',3,610800,0,0,'','','',0,0,0,2,0,0,0),(610803,0,'横山区',3,610800,0,0,'','','',0,0,0,3,0,0,0),(610822,0,'府谷县',3,610800,0,0,'','','',0,0,0,4,0,0,0),(610824,0,'靖边县',3,610800,0,0,'','','',0,0,0,5,0,0,0),(610825,0,'定边县',3,610800,0,0,'','','',0,0,0,6,0,0,0),(610826,0,'绥德县',3,610800,0,0,'','','',0,0,0,7,0,0,0),(610827,0,'米脂县',3,610800,0,0,'','','',0,0,0,8,0,0,0),(610828,0,'佳县',3,610800,0,0,'','','',0,0,0,9,0,0,0),(610829,0,'吴堡县',3,610800,0,0,'','','',0,0,0,10,0,0,0),(610830,0,'清涧县',3,610800,0,0,'','','',0,0,0,11,0,0,0),(610831,0,'子洲县',3,610800,0,0,'','','',0,0,0,12,0,0,0),(610881,0,'神木市',3,610800,0,0,'','','',0,0,0,13,0,0,0),(610900,0,'安康市',2,61,0,0,'','','',0,0,11,9,0,0,0),(610901,0,'市辖区',3,610900,0,0,'','','',0,0,0,1,0,0,0),(610902,0,'汉滨区',3,610900,0,0,'','','',0,0,0,2,0,0,0),(610921,0,'汉阴县',3,610900,0,0,'','','',0,0,0,3,0,0,0),(610922,0,'石泉县',3,610900,0,0,'','','',0,0,0,4,0,0,0),(610923,0,'宁陕县',3,610900,0,0,'','','',0,0,0,5,0,0,0),(610924,0,'紫阳县',3,610900,0,0,'','','',0,0,0,6,0,0,0),(610925,0,'岚皋县',3,610900,0,0,'','','',0,0,0,7,0,0,0),(610926,0,'平利县',3,610900,0,0,'','','',0,0,0,8,0,0,0),(610927,0,'镇坪县',3,610900,0,0,'','','',0,0,0,9,0,0,0),(610928,0,'旬阳县',3,610900,0,0,'','','',0,0,0,10,0,0,0),(610929,0,'白河县',3,610900,0,0,'','','',0,0,0,11,0,0,0),(611000,0,'商洛市',2,61,0,0,'','','',0,0,8,10,0,0,0),(611001,0,'市辖区',3,611000,0,0,'','','',0,0,0,1,0,0,0),(611002,0,'商州区',3,611000,0,0,'','','',0,0,0,2,0,0,0),(611021,0,'洛南县',3,611000,0,0,'','','',0,0,0,3,0,0,0),(611022,0,'丹凤县',3,611000,0,0,'','','',0,0,0,4,0,0,0),(611023,0,'商南县',3,611000,0,0,'','','',0,0,0,5,0,0,0),(611024,0,'山阳县',3,611000,0,0,'','','',0,0,0,6,0,0,0),(611025,0,'镇安县',3,611000,0,0,'','','',0,0,0,7,0,0,0),(611026,0,'柞水县',3,611000,0,0,'','','',0,0,0,8,0,0,0),(620100,0,'兰州市',2,62,0,0,'','','',0,0,10,1,0,0,0),(620101,0,'市辖区',3,620100,0,0,'','','',0,0,0,1,0,0,0),(620102,0,'城关区',3,620100,0,0,'','','',0,0,0,2,0,0,0),(620103,0,'七里河区',3,620100,0,0,'','','',0,0,0,3,0,0,0),(620104,0,'西固区',3,620100,0,0,'','','',0,0,0,4,0,0,0),(620105,0,'安宁区',3,620100,0,0,'','','',0,0,0,5,0,0,0),(620111,0,'红古区',3,620100,0,0,'','','',0,0,0,6,0,0,0),(620121,0,'永登县',3,620100,0,0,'','','',0,0,0,7,0,0,0),(620122,0,'皋兰县',3,620100,0,0,'','','',0,0,0,8,0,0,0),(620123,0,'榆中县',3,620100,0,0,'','','',0,0,0,9,0,0,0),(620171,0,'兰州新区',3,620100,0,0,'','','',0,0,0,10,0,0,0),(620200,0,'嘉峪关市',2,62,0,0,'','','',0,0,1,2,0,0,0),(620201,0,'市辖区',3,620200,0,0,'','','',0,0,0,1,0,0,0),(620300,0,'金昌市',2,62,0,0,'','','',0,0,3,3,0,0,0),(620301,0,'市辖区',3,620300,0,0,'','','',0,0,0,1,0,0,0),(620302,0,'金川区',3,620300,0,0,'','','',0,0,0,2,0,0,0),(620321,0,'永昌县',3,620300,0,0,'','','',0,0,0,3,0,0,0),(620400,0,'白银市',2,62,0,0,'','','',0,0,6,4,0,0,0),(620401,0,'市辖区',3,620400,0,0,'','','',0,0,0,1,0,0,0),(620402,0,'白银区',3,620400,0,0,'','','',0,0,0,2,0,0,0),(620403,0,'平川区',3,620400,0,0,'','','',0,0,0,3,0,0,0),(620421,0,'靖远县',3,620400,0,0,'','','',0,0,0,4,0,0,0),(620422,0,'会宁县',3,620400,0,0,'','','',0,0,0,5,0,0,0),(620423,0,'景泰县',3,620400,0,0,'','','',0,0,0,6,0,0,0),(620500,0,'天水市',2,62,0,0,'','','',0,0,8,5,0,0,0),(620501,0,'市辖区',3,620500,0,0,'','','',0,0,0,1,0,0,0),(620502,0,'秦州区',3,620500,0,0,'','','',0,0,0,2,0,0,0),(620503,0,'麦积区',3,620500,0,0,'','','',0,0,0,3,0,0,0),(620521,0,'清水县',3,620500,0,0,'','','',0,0,0,4,0,0,0),(620522,0,'秦安县',3,620500,0,0,'','','',0,0,0,5,0,0,0),(620523,0,'甘谷县',3,620500,0,0,'','','',0,0,0,6,0,0,0),(620524,0,'武山县',3,620500,0,0,'','','',0,0,0,7,0,0,0),(620525,0,'张家川回族自治县',3,620500,0,0,'','','',0,0,0,8,0,0,0),(620600,0,'武威市',2,62,0,0,'','','',0,0,5,6,0,0,0),(620601,0,'市辖区',3,620600,0,0,'','','',0,0,0,1,0,0,0),(620602,0,'凉州区',3,620600,0,0,'','','',0,0,0,2,0,0,0),(620621,0,'民勤县',3,620600,0,0,'','','',0,0,0,3,0,0,0),(620622,0,'古浪县',3,620600,0,0,'','','',0,0,0,4,0,0,0),(620623,0,'天祝藏族自治县',3,620600,0,0,'','','',0,0,0,5,0,0,0),(620700,0,'张掖市',2,62,0,0,'','','',0,0,7,7,0,0,0),(620701,0,'市辖区',3,620700,0,0,'','','',0,0,0,1,0,0,0),(620702,0,'甘州区',3,620700,0,0,'','','',0,0,0,2,0,0,0),(620721,0,'肃南裕固族自治县',3,620700,0,0,'','','',0,0,0,3,0,0,0),(620722,0,'民乐县',3,620700,0,0,'','','',0,0,0,4,0,0,0),(620723,0,'临泽县',3,620700,0,0,'','','',0,0,0,5,0,0,0),(620724,0,'高台县',3,620700,0,0,'','','',0,0,0,6,0,0,0),(620725,0,'山丹县',3,620700,0,0,'','','',0,0,0,7,0,0,0),(620800,0,'平凉市',2,62,0,0,'','','',0,0,8,8,0,0,0),(620801,0,'市辖区',3,620800,0,0,'','','',0,0,0,1,0,0,0),(620802,0,'崆峒区',3,620800,0,0,'','','',0,0,0,2,0,0,0),(620821,0,'泾川县',3,620800,0,0,'','','',0,0,0,3,0,0,0),(620822,0,'灵台县',3,620800,0,0,'','','',0,0,0,4,0,0,0),(620823,0,'崇信县',3,620800,0,0,'','','',0,0,0,5,0,0,0),(620825,0,'庄浪县',3,620800,0,0,'','','',0,0,0,6,0,0,0),(620826,0,'静宁县',3,620800,0,0,'','','',0,0,0,7,0,0,0),(620881,0,'华亭市',3,620800,0,0,'','','',0,0,0,8,0,0,0),(620900,0,'酒泉市',2,62,0,0,'','','',0,0,8,9,0,0,0),(620901,0,'市辖区',3,620900,0,0,'','','',0,0,0,1,0,0,0),(620902,0,'肃州区',3,620900,0,0,'','','',0,0,0,2,0,0,0),(620921,0,'金塔县',3,620900,0,0,'','','',0,0,0,3,0,0,0),(620922,0,'瓜州县',3,620900,0,0,'','','',0,0,0,4,0,0,0),(620923,0,'肃北蒙古族自治县',3,620900,0,0,'','','',0,0,0,5,0,0,0),(620924,0,'阿克塞哈萨克族自治县',3,620900,0,0,'','','',0,0,0,6,0,0,0),(620981,0,'玉门市',3,620900,0,0,'','','',0,0,0,7,0,0,0),(620982,0,'敦煌市',3,620900,0,0,'','','',0,0,0,8,0,0,0),(621000,0,'庆阳市',2,62,0,0,'','','',0,0,9,10,0,0,0),(621001,0,'市辖区',3,621000,0,0,'','','',0,0,0,1,0,0,0),(621002,0,'西峰区',3,621000,0,0,'','','',0,0,0,2,0,0,0),(621021,0,'庆城县',3,621000,0,0,'','','',0,0,0,3,0,0,0),(621022,0,'环县',3,621000,0,0,'','','',0,0,0,4,0,0,0),(621023,0,'华池县',3,621000,0,0,'','','',0,0,0,5,0,0,0),(621024,0,'合水县',3,621000,0,0,'','','',0,0,0,6,0,0,0),(621025,0,'正宁县',3,621000,0,0,'','','',0,0,0,7,0,0,0),(621026,0,'宁县',3,621000,0,0,'','','',0,0,0,8,0,0,0),(621027,0,'镇原县',3,621000,0,0,'','','',0,0,0,9,0,0,0),(621100,0,'定西市',2,62,0,0,'','','',0,0,8,11,0,0,0),(621101,0,'市辖区',3,621100,0,0,'','','',0,0,0,1,0,0,0),(621102,0,'安定区',3,621100,0,0,'','','',0,0,0,2,0,0,0),(621121,0,'通渭县',3,621100,0,0,'','','',0,0,0,3,0,0,0),(621122,0,'陇西县',3,621100,0,0,'','','',0,0,0,4,0,0,0),(621123,0,'渭源县',3,621100,0,0,'','','',0,0,0,5,0,0,0),(621124,0,'临洮县',3,621100,0,0,'','','',0,0,0,6,0,0,0),(621125,0,'漳县',3,621100,0,0,'','','',0,0,0,7,0,0,0),(621126,0,'岷县',3,621100,0,0,'','','',0,0,0,8,0,0,0),(621200,0,'陇南市',2,62,0,0,'','','',0,0,10,12,0,0,0),(621201,0,'市辖区',3,621200,0,0,'','','',0,0,0,1,0,0,0),(621202,0,'武都区',3,621200,0,0,'','','',0,0,0,2,0,0,0),(621221,0,'成县',3,621200,0,0,'','','',0,0,0,3,0,0,0),(621222,0,'文县',3,621200,0,0,'','','',0,0,0,4,0,0,0),(621223,0,'宕昌县',3,621200,0,0,'','','',0,0,0,5,0,0,0),(621224,0,'康县',3,621200,0,0,'','','',0,0,0,6,0,0,0),(621225,0,'西和县',3,621200,0,0,'','','',0,0,0,7,0,0,0),(621226,0,'礼县',3,621200,0,0,'','','',0,0,0,8,0,0,0),(621227,0,'徽县',3,621200,0,0,'','','',0,0,0,9,0,0,0),(621228,0,'两当县',3,621200,0,0,'','','',0,0,0,10,0,0,0),(622900,0,'临夏回族自治州',2,62,0,0,'','','',0,0,8,13,0,0,0),(622901,0,'临夏市',3,622900,0,0,'','','',0,0,0,1,0,0,0),(622921,0,'临夏县',3,622900,0,0,'','','',0,0,0,2,0,0,0),(622922,0,'康乐县',3,622900,0,0,'','','',0,0,0,3,0,0,0),(622923,0,'永靖县',3,622900,0,0,'','','',0,0,0,4,0,0,0),(622924,0,'广河县',3,622900,0,0,'','','',0,0,0,5,0,0,0),(622925,0,'和政县',3,622900,0,0,'','','',0,0,0,6,0,0,0),(622926,0,'东乡族自治县',3,622900,0,0,'','','',0,0,0,7,0,0,0),(622927,0,'积石山保安族东乡族撒拉族自治县',3,622900,0,0,'','','',0,0,0,8,0,0,0),(623000,0,'甘南藏族自治州',2,62,0,0,'','','',0,0,8,14,0,0,0),(623001,0,'合作市',3,623000,0,0,'','','',0,0,0,1,0,0,0),(623021,0,'临潭县',3,623000,0,0,'','','',0,0,0,2,0,0,0),(623022,0,'卓尼县',3,623000,0,0,'','','',0,0,0,3,0,0,0),(623023,0,'舟曲县',3,623000,0,0,'','','',0,0,0,4,0,0,0),(623024,0,'迭部县',3,623000,0,0,'','','',0,0,0,5,0,0,0),(623025,0,'玛曲县',3,623000,0,0,'','','',0,0,0,6,0,0,0),(623026,0,'碌曲县',3,623000,0,0,'','','',0,0,0,7,0,0,0),(623027,0,'夏河县',3,623000,0,0,'','','',0,0,0,8,0,0,0),(630100,0,'西宁市',2,63,0,0,'','','',0,0,8,1,0,0,0),(630101,0,'市辖区',3,630100,0,0,'','','',0,0,0,1,0,0,0),(630102,0,'城东区',3,630100,0,0,'','','',0,0,0,2,0,0,0),(630103,0,'城中区',3,630100,0,0,'','','',0,0,0,3,0,0,0),(630104,0,'城西区',3,630100,0,0,'','','',0,0,0,4,0,0,0),(630105,0,'城北区',3,630100,0,0,'','','',0,0,0,5,0,0,0),(630121,0,'大通回族土族自治县',3,630100,0,0,'','','',0,0,0,6,0,0,0),(630122,0,'湟中县',3,630100,0,0,'','','',0,0,0,7,0,0,0),(630123,0,'湟源县',3,630100,0,0,'','','',0,0,0,8,0,0,0),(630200,0,'海东市',2,63,0,0,'','','',0,0,6,2,0,0,0),(630202,0,'乐都区',3,630200,0,0,'','','',0,0,0,1,0,0,0),(630203,0,'平安区',3,630200,0,0,'','','',0,0,0,2,0,0,0),(630222,0,'民和回族土族自治县',3,630200,0,0,'','','',0,0,0,3,0,0,0),(630223,0,'互助土族自治县',3,630200,0,0,'','','',0,0,0,4,0,0,0),(630224,0,'化隆回族自治县',3,630200,0,0,'','','',0,0,0,5,0,0,0),(630225,0,'循化撒拉族自治县',3,630200,0,0,'','','',0,0,0,6,0,0,0),(632200,0,'海北藏族自治州',2,63,0,0,'','','',0,0,4,3,0,0,0),(632221,0,'门源回族自治县',3,632200,0,0,'','','',0,0,0,1,0,0,0),(632222,0,'祁连县',3,632200,0,0,'','','',0,0,0,2,0,0,0),(632223,0,'海晏县',3,632200,0,0,'','','',0,0,0,3,0,0,0),(632224,0,'刚察县',3,632200,0,0,'','','',0,0,0,4,0,0,0),(632300,0,'黄南藏族自治州',2,63,0,0,'','','',0,0,4,4,0,0,0),(632321,0,'同仁县',3,632300,0,0,'','','',0,0,0,1,0,0,0),(632322,0,'尖扎县',3,632300,0,0,'','','',0,0,0,2,0,0,0),(632323,0,'泽库县',3,632300,0,0,'','','',0,0,0,3,0,0,0),(632324,0,'河南蒙古族自治县',3,632300,0,0,'','','',0,0,0,4,0,0,0),(632500,0,'海南藏族自治州',2,63,0,0,'','','',0,0,5,5,0,0,0),(632521,0,'共和县',3,632500,0,0,'','','',0,0,0,1,0,0,0),(632522,0,'同德县',3,632500,0,0,'','','',0,0,0,2,0,0,0),(632523,0,'贵德县',3,632500,0,0,'','','',0,0,0,3,0,0,0),(632524,0,'兴海县',3,632500,0,0,'','','',0,0,0,4,0,0,0),(632525,0,'贵南县',3,632500,0,0,'','','',0,0,0,5,0,0,0),(632600,0,'果洛藏族自治州',2,63,0,0,'','','',0,0,6,6,0,0,0),(632621,0,'玛沁县',3,632600,0,0,'','','',0,0,0,1,0,0,0),(632622,0,'班玛县',3,632600,0,0,'','','',0,0,0,2,0,0,0),(632623,0,'甘德县',3,632600,0,0,'','','',0,0,0,3,0,0,0),(632624,0,'达日县',3,632600,0,0,'','','',0,0,0,4,0,0,0),(632625,0,'久治县',3,632600,0,0,'','','',0,0,0,5,0,0,0),(632626,0,'玛多县',3,632600,0,0,'','','',0,0,0,6,0,0,0),(632700,0,'玉树藏族自治州',2,63,0,0,'','','',0,0,6,7,0,0,0),(632701,0,'玉树市',3,632700,0,0,'','','',0,0,0,1,0,0,0),(632722,0,'杂多县',3,632700,0,0,'','','',0,0,0,2,0,0,0),(632723,0,'称多县',3,632700,0,0,'','','',0,0,0,3,0,0,0),(632724,0,'治多县',3,632700,0,0,'','','',0,0,0,4,0,0,0),(632725,0,'囊谦县',3,632700,0,0,'','','',0,0,0,5,0,0,0),(632726,0,'曲麻莱县',3,632700,0,0,'','','',0,0,0,6,0,0,0),(632800,0,'海西蒙古族藏族自治州',2,63,0,0,'','','',0,0,7,8,0,0,0),(632801,0,'格尔木市',3,632800,0,0,'','','',0,0,0,1,0,0,0),(632802,0,'德令哈市',3,632800,0,0,'','','',0,0,0,2,0,0,0),(632803,0,'茫崖市',3,632800,0,0,'','','',0,0,0,3,0,0,0),(632821,0,'乌兰县',3,632800,0,0,'','','',0,0,0,4,0,0,0),(632822,0,'都兰县',3,632800,0,0,'','','',0,0,0,5,0,0,0),(632823,0,'天峻县',3,632800,0,0,'','','',0,0,0,6,0,0,0),(632857,0,'大柴旦行政委员会',3,632800,0,0,'','','',0,0,0,7,0,0,0),(640100,0,'银川市',2,64,0,0,'','','',0,0,7,1,0,0,0),(640101,0,'市辖区',3,640100,0,0,'','','',0,0,0,1,0,0,0),(640104,0,'兴庆区',3,640100,0,0,'','','',0,0,0,2,0,0,0),(640105,0,'西夏区',3,640100,0,0,'','','',0,0,0,3,0,0,0),(640106,0,'金凤区',3,640100,0,0,'','','',0,0,0,4,0,0,0),(640121,0,'永宁县',3,640100,0,0,'','','',0,0,0,5,0,0,0),(640122,0,'贺兰县',3,640100,0,0,'','','',0,0,0,6,0,0,0),(640181,0,'灵武市',3,640100,0,0,'','','',0,0,0,7,0,0,0),(640200,0,'石嘴山市',2,64,0,0,'','','',0,0,4,2,0,0,0),(640201,0,'市辖区',3,640200,0,0,'','','',0,0,0,1,0,0,0),(640202,0,'大武口区',3,640200,0,0,'','','',0,0,0,2,0,0,0),(640205,0,'惠农区',3,640200,0,0,'','','',0,0,0,3,0,0,0),(640221,0,'平罗县',3,640200,0,0,'','','',0,0,0,4,0,0,0),(640300,0,'吴忠市',2,64,0,0,'','','',0,0,6,3,0,0,0),(640301,0,'市辖区',3,640300,0,0,'','','',0,0,0,1,0,0,0),(640302,0,'利通区',3,640300,0,0,'','','',0,0,0,2,0,0,0),(640303,0,'红寺堡区',3,640300,0,0,'','','',0,0,0,3,0,0,0),(640323,0,'盐池县',3,640300,0,0,'','','',0,0,0,4,0,0,0),(640324,0,'同心县',3,640300,0,0,'','','',0,0,0,5,0,0,0),(640381,0,'青铜峡市',3,640300,0,0,'','','',0,0,0,6,0,0,0),(640400,0,'固原市',2,64,0,0,'','','',0,0,6,4,0,0,0),(640401,0,'市辖区',3,640400,0,0,'','','',0,0,0,1,0,0,0),(640402,0,'原州区',3,640400,0,0,'','','',0,0,0,2,0,0,0),(640422,0,'西吉县',3,640400,0,0,'','','',0,0,0,3,0,0,0),(640423,0,'隆德县',3,640400,0,0,'','','',0,0,0,4,0,0,0),(640424,0,'泾源县',3,640400,0,0,'','','',0,0,0,5,0,0,0),(640425,0,'彭阳县',3,640400,0,0,'','','',0,0,0,6,0,0,0),(640500,0,'中卫市',2,64,0,0,'','','',0,0,4,5,0,0,0),(640501,0,'市辖区',3,640500,0,0,'','','',0,0,0,1,0,0,0),(640502,0,'沙坡头区',3,640500,0,0,'','','',0,0,0,2,0,0,0),(640521,0,'中宁县',3,640500,0,0,'','','',0,0,0,3,0,0,0),(640522,0,'海原县',3,640500,0,0,'','','',0,0,0,4,0,0,0),(650100,0,'乌鲁木齐市',2,65,0,0,'','','',0,0,9,1,0,0,0),(650101,0,'市辖区',3,650100,0,0,'','','',0,0,0,1,0,0,0),(650102,0,'天山区',3,650100,0,0,'','','',0,0,0,2,0,0,0),(650103,0,'沙依巴克区',3,650100,0,0,'','','',0,0,0,3,0,0,0),(650104,0,'新市区',3,650100,0,0,'','','',0,0,0,4,0,0,0),(650105,0,'水磨沟区',3,650100,0,0,'','','',0,0,0,5,0,0,0),(650106,0,'头屯河区',3,650100,0,0,'','','',0,0,0,6,0,0,0),(650107,0,'达坂城区',3,650100,0,0,'','','',0,0,0,7,0,0,0),(650109,0,'米东区',3,650100,0,0,'','','',0,0,0,8,0,0,0),(650121,0,'乌鲁木齐县',3,650100,0,0,'','','',0,0,0,9,0,0,0),(650200,0,'克拉玛依市',2,65,0,0,'','','',0,0,5,2,0,0,0),(650201,0,'市辖区',3,650200,0,0,'','','',0,0,0,1,0,0,0),(650202,0,'独山子区',3,650200,0,0,'','','',0,0,0,2,0,0,0),(650203,0,'克拉玛依区',3,650200,0,0,'','','',0,0,0,3,0,0,0),(650204,0,'白碱滩区',3,650200,0,0,'','','',0,0,0,4,0,0,0),(650205,0,'乌尔禾区',3,650200,0,0,'','','',0,0,0,5,0,0,0),(650400,0,'吐鲁番市',2,65,0,0,'','','',0,0,3,3,0,0,0),(650402,0,'高昌区',3,650400,0,0,'','','',0,0,0,1,0,0,0),(650421,0,'鄯善县',3,650400,0,0,'','','',0,0,0,2,0,0,0),(650422,0,'托克逊县',3,650400,0,0,'','','',0,0,0,3,0,0,0),(650500,0,'哈密市',2,65,0,0,'','','',0,0,3,4,0,0,0),(650502,0,'伊州区',3,650500,0,0,'','','',0,0,0,1,0,0,0),(650521,0,'巴里坤哈萨克自治县',3,650500,0,0,'','','',0,0,0,2,0,0,0),(650522,0,'伊吾县',3,650500,0,0,'','','',0,0,0,3,0,0,0),(652300,0,'昌吉回族自治州',2,65,0,0,'','','',0,0,7,5,0,0,0),(652301,0,'昌吉市',3,652300,0,0,'','','',0,0,0,1,0,0,0),(652302,0,'阜康市',3,652300,0,0,'','','',0,0,0,2,0,0,0),(652323,0,'呼图壁县',3,652300,0,0,'','','',0,0,0,3,0,0,0),(652324,0,'玛纳斯县',3,652300,0,0,'','','',0,0,0,4,0,0,0),(652325,0,'奇台县',3,652300,0,0,'','','',0,0,0,5,0,0,0),(652327,0,'吉木萨尔县',3,652300,0,0,'','','',0,0,0,6,0,0,0),(652328,0,'木垒哈萨克自治县',3,652300,0,0,'','','',0,0,0,7,0,0,0),(652700,0,'博尔塔拉蒙古自治州',2,65,0,0,'','','',0,0,4,6,0,0,0),(652701,0,'博乐市',3,652700,0,0,'','','',0,0,0,1,0,0,0),(652702,0,'阿拉山口市',3,652700,0,0,'','','',0,0,0,2,0,0,0),(652722,0,'精河县',3,652700,0,0,'','','',0,0,0,3,0,0,0),(652723,0,'温泉县',3,652700,0,0,'','','',0,0,0,4,0,0,0),(652800,0,'巴音郭楞蒙古自治州',2,65,0,0,'','','',0,0,10,7,0,0,0),(652801,0,'库尔勒市',3,652800,0,0,'','','',0,0,0,1,0,0,0),(652822,0,'轮台县',3,652800,0,0,'','','',0,0,0,2,0,0,0),(652823,0,'尉犁县',3,652800,0,0,'','','',0,0,0,3,0,0,0),(652824,0,'若羌县',3,652800,0,0,'','','',0,0,0,4,0,0,0),(652825,0,'且末县',3,652800,0,0,'','','',0,0,0,5,0,0,0),(652826,0,'焉耆回族自治县',3,652800,0,0,'','','',0,0,0,6,0,0,0),(652827,0,'和静县',3,652800,0,0,'','','',0,0,0,7,0,0,0),(652828,0,'和硕县',3,652800,0,0,'','','',0,0,0,8,0,0,0),(652829,0,'博湖县',3,652800,0,0,'','','',0,0,0,9,0,0,0),(652871,0,'库尔勒经济技术开发区',3,652800,0,0,'','','',0,0,0,10,0,0,0),(652900,0,'阿克苏地区',2,65,0,0,'','','',0,0,9,8,0,0,0),(652901,0,'阿克苏市',3,652900,0,0,'','','',0,0,0,1,0,0,0),(652922,0,'温宿县',3,652900,0,0,'','','',0,0,0,2,0,0,0),(652923,0,'库车县',3,652900,0,0,'','','',0,0,0,3,0,0,0),(652924,0,'沙雅县',3,652900,0,0,'','','',0,0,0,4,0,0,0),(652925,0,'新和县',3,652900,0,0,'','','',0,0,0,5,0,0,0),(652926,0,'拜城县',3,652900,0,0,'','','',0,0,0,6,0,0,0),(652927,0,'乌什县',3,652900,0,0,'','','',0,0,0,7,0,0,0),(652928,0,'阿瓦提县',3,652900,0,0,'','','',0,0,0,8,0,0,0),(652929,0,'柯坪县',3,652900,0,0,'','','',0,0,0,9,0,0,0),(653000,0,'克孜勒苏柯尔克孜自治州',2,65,0,0,'','','',0,0,4,9,0,0,0),(653001,0,'阿图什市',3,653000,0,0,'','','',0,0,0,1,0,0,0),(653022,0,'阿克陶县',3,653000,0,0,'','','',0,0,0,2,0,0,0),(653023,0,'阿合奇县',3,653000,0,0,'','','',0,0,0,3,0,0,0),(653024,0,'乌恰县',3,653000,0,0,'','','',0,0,0,4,0,0,0),(653100,0,'喀什地区',2,65,0,0,'','','',0,0,12,10,0,0,0),(653101,0,'喀什市',3,653100,0,0,'','','',0,0,0,1,0,0,0),(653121,0,'疏附县',3,653100,0,0,'','','',0,0,0,2,0,0,0),(653122,0,'疏勒县',3,653100,0,0,'','','',0,0,0,3,0,0,0),(653123,0,'英吉沙县',3,653100,0,0,'','','',0,0,0,4,0,0,0),(653124,0,'泽普县',3,653100,0,0,'','','',0,0,0,5,0,0,0),(653125,0,'莎车县',3,653100,0,0,'','','',0,0,0,6,0,0,0),(653126,0,'叶城县',3,653100,0,0,'','','',0,0,0,7,0,0,0),(653127,0,'麦盖提县',3,653100,0,0,'','','',0,0,0,8,0,0,0),(653128,0,'岳普湖县',3,653100,0,0,'','','',0,0,0,9,0,0,0),(653129,0,'伽师县',3,653100,0,0,'','','',0,0,0,10,0,0,0),(653130,0,'巴楚县',3,653100,0,0,'','','',0,0,0,11,0,0,0),(653131,0,'塔什库尔干塔吉克自治县',3,653100,0,0,'','','',0,0,0,12,0,0,0),(653200,0,'和田地区',2,65,0,0,'','','',0,0,8,11,0,0,0),(653201,0,'和田市',3,653200,0,0,'','','',0,0,0,1,0,0,0),(653221,0,'和田县',3,653200,0,0,'','','',0,0,0,2,0,0,0),(653222,0,'墨玉县',3,653200,0,0,'','','',0,0,0,3,0,0,0),(653223,0,'皮山县',3,653200,0,0,'','','',0,0,0,4,0,0,0),(653224,0,'洛浦县',3,653200,0,0,'','','',0,0,0,5,0,0,0),(653225,0,'策勒县',3,653200,0,0,'','','',0,0,0,6,0,0,0),(653226,0,'于田县',3,653200,0,0,'','','',0,0,0,7,0,0,0),(653227,0,'民丰县',3,653200,0,0,'','','',0,0,0,8,0,0,0),(654000,0,'伊犁哈萨克自治州',2,65,0,0,'','','',0,0,11,12,0,0,0),(654002,0,'伊宁市',3,654000,0,0,'','','',0,0,0,1,0,0,0),(654003,0,'奎屯市',3,654000,0,0,'','','',0,0,0,2,0,0,0),(654004,0,'霍尔果斯市',3,654000,0,0,'','','',0,0,0,3,0,0,0),(654021,0,'伊宁县',3,654000,0,0,'','','',0,0,0,4,0,0,0),(654022,0,'察布查尔锡伯自治县',3,654000,0,0,'','','',0,0,0,5,0,0,0),(654023,0,'霍城县',3,654000,0,0,'','','',0,0,0,6,0,0,0),(654024,0,'巩留县',3,654000,0,0,'','','',0,0,0,7,0,0,0),(654025,0,'新源县',3,654000,0,0,'','','',0,0,0,8,0,0,0),(654026,0,'昭苏县',3,654000,0,0,'','','',0,0,0,9,0,0,0),(654027,0,'特克斯县',3,654000,0,0,'','','',0,0,0,10,0,0,0),(654028,0,'尼勒克县',3,654000,0,0,'','','',0,0,0,11,0,0,0),(654200,0,'塔城地区',2,65,0,0,'','','',0,0,7,13,0,0,0),(654201,0,'塔城市',3,654200,0,0,'','','',0,0,0,1,0,0,0),(654202,0,'乌苏市',3,654200,0,0,'','','',0,0,0,2,0,0,0),(654221,0,'额敏县',3,654200,0,0,'','','',0,0,0,3,0,0,0),(654223,0,'沙湾县',3,654200,0,0,'','','',0,0,0,4,0,0,0),(654224,0,'托里县',3,654200,0,0,'','','',0,0,0,5,0,0,0),(654225,0,'裕民县',3,654200,0,0,'','','',0,0,0,6,0,0,0),(654226,0,'和布克赛尔蒙古自治县',3,654200,0,0,'','','',0,0,0,7,0,0,0),(654300,0,'阿勒泰地区',2,65,0,0,'','','',0,0,7,14,0,0,0),(654301,0,'阿勒泰市',3,654300,0,0,'','','',0,0,0,1,0,0,0),(654321,0,'布尔津县',3,654300,0,0,'','','',0,0,0,2,0,0,0),(654322,0,'富蕴县',3,654300,0,0,'','','',0,0,0,3,0,0,0),(654323,0,'福海县',3,654300,0,0,'','','',0,0,0,4,0,0,0),(654324,0,'哈巴河县',3,654300,0,0,'','','',0,0,0,5,0,0,0),(654325,0,'青河县',3,654300,0,0,'','','',0,0,0,6,0,0,0),(654326,0,'吉木乃县',3,654300,0,0,'','','',0,0,0,7,0,0,0),(659000,0,'自治区直辖县级行政区划',2,65,0,0,'','','',0,0,5,15,0,0,0),(659001,0,'石河子市',3,659000,0,0,'','','',0,0,0,1,0,0,0),(659002,0,'阿拉尔市',3,659000,0,0,'','','',0,0,0,2,0,0,0),(659003,0,'图木舒克市',3,659000,0,0,'','','',0,0,0,3,0,0,0),(659004,0,'五家渠市',3,659000,0,0,'','','',0,0,0,4,0,0,0),(659006,0,'铁门关市',3,659000,0,0,'','','',0,0,0,5,0,0,0),(660100,0,'台北',2,66,0,0,'','','',0,0,0,1,0,0,0),(660200,0,'高雄',2,66,0,0,'','','',0,0,0,2,0,0,0),(660300,0,'基隆',2,66,0,0,'','','',0,0,0,3,0,0,0),(660400,0,'台中',2,66,0,0,'','','',0,0,0,4,0,0,0),(660500,0,'台南',2,66,0,0,'','','',0,0,0,5,0,0,0),(660600,0,'新竹',2,66,0,0,'','','',0,0,0,6,0,0,0),(660700,0,'嘉义',2,66,0,0,'','','',0,0,0,7,0,0,0),(660800,0,'宜兰',2,66,0,0,'','','',0,0,0,8,0,0,0),(660900,0,'桃园',2,66,0,0,'','','',0,0,0,9,0,0,0),(661000,0,'苗栗',2,66,0,0,'','','',0,0,0,10,0,0,0),(661100,0,'彰化',2,66,0,0,'','','',0,0,0,11,0,0,0),(661200,0,'南投',2,66,0,0,'','','',0,0,0,12,0,0,0),(661300,0,'云林',2,66,0,0,'','','',0,0,0,13,0,0,0),(661400,0,'屏东',2,66,0,0,'','','',0,0,0,14,0,0,0),(661500,0,'台东',2,66,0,0,'','','',0,0,0,15,0,0,0),(661600,0,'花莲',2,66,0,0,'','','',0,0,0,16,0,0,0),(661700,0,'澎湖',2,66,0,0,'','','',0,0,0,17,0,0,0),(670100,0,'香港岛',2,67,0,0,'','','',0,0,0,1,0,0,0),(670200,0,'九龙',2,67,0,0,'','','',0,0,0,2,0,0,0),(670300,0,'新界',2,67,0,0,'','','',0,0,0,3,0,0,0),(680100,0,'澳门半岛',2,68,0,0,'','','',0,0,0,1,0,0,0),(680200,0,'氹仔岛',2,68,0,0,'','','',0,0,0,2,0,0,0),(680300,0,'路环岛',2,68,0,0,'','','',0,0,0,3,0,0,0),(680400,0,'路氹城',2,68,0,0,'','','',0,0,0,4,0,0,0),(441900003000,0,'东城街道',3,441900,0,0,'','','',0,0,0,1,0,0,0),(441900004000,0,'南城街道',3,441900,0,0,'','','',0,0,0,2,0,0,0),(441900005000,0,'万江街道',3,441900,0,0,'','','',0,0,0,3,0,0,0),(441900006000,0,'莞城街道',3,441900,0,0,'','','',0,0,0,4,0,0,0),(441900101000,0,'石碣镇',3,441900,0,0,'','','',0,0,0,5,0,0,0),(441900102000,0,'石龙镇',3,441900,0,0,'','','',0,0,0,6,0,0,0),(441900103000,0,'茶山镇',3,441900,0,0,'','','',0,0,0,7,0,0,0),(441900104000,0,'石排镇',3,441900,0,0,'','','',0,0,0,8,0,0,0),(441900105000,0,'企石镇',3,441900,0,0,'','','',0,0,0,9,0,0,0),(441900106000,0,'横沥镇',3,441900,0,0,'','','',0,0,0,10,0,0,0),(441900107000,0,'桥头镇',3,441900,0,0,'','','',0,0,0,11,0,0,0),(441900108000,0,'谢岗镇',3,441900,0,0,'','','',0,0,0,12,0,0,0),(441900109000,0,'东坑镇',3,441900,0,0,'','','',0,0,0,13,0,0,0),(441900110000,0,'常平镇',3,441900,0,0,'','','',0,0,0,14,0,0,0),(441900111000,0,'寮步镇',3,441900,0,0,'','','',0,0,0,15,0,0,0),(441900112000,0,'樟木头镇',3,441900,0,0,'','','',0,0,0,16,0,0,0),(441900113000,0,'大朗镇',3,441900,0,0,'','','',0,0,0,17,0,0,0),(441900114000,0,'黄江镇',3,441900,0,0,'','','',0,0,0,18,0,0,0),(441900115000,0,'清溪镇',3,441900,0,0,'','','',0,0,0,19,0,0,0),(441900116000,0,'塘厦镇',3,441900,0,0,'','','',0,0,0,20,0,0,0),(441900117000,0,'凤岗镇',3,441900,0,0,'','','',0,0,0,21,0,0,0),(441900118000,0,'大岭山镇',3,441900,0,0,'','','',0,0,0,22,0,0,0),(441900119000,0,'长安镇',3,441900,0,0,'','','',0,0,0,23,0,0,0),(441900121000,0,'虎门镇',3,441900,0,0,'','','',0,0,0,24,0,0,0),(441900122000,0,'厚街镇',3,441900,0,0,'','','',0,0,0,25,0,0,0),(441900123000,0,'沙田镇',3,441900,0,0,'','','',0,0,0,26,0,0,0),(441900124000,0,'道滘镇',3,441900,0,0,'','','',0,0,0,27,0,0,0),(441900125000,0,'洪梅镇',3,441900,0,0,'','','',0,0,0,28,0,0,0),(441900126000,0,'麻涌镇',3,441900,0,0,'','','',0,0,0,29,0,0,0),(441900127000,0,'望牛墩镇',3,441900,0,0,'','','',0,0,0,30,0,0,0),(441900128000,0,'中堂镇',3,441900,0,0,'','','',0,0,0,31,0,0,0),(441900129000,0,'高埗镇',3,441900,0,0,'','','',0,0,0,32,0,0,0),(441900401000,0,'松山湖',3,441900,0,0,'','','',0,0,0,33,0,0,0),(441900402000,0,'东莞港',3,441900,0,0,'','','',0,0,0,34,0,0,0),(441900403000,0,'东莞生态园',3,441900,0,0,'','','',0,0,0,35,0,0,0),(442000001000,0,'石岐街道',3,442000,0,0,'','','',0,0,0,1,0,0,0),(442000002000,0,'东区街道',3,442000,0,0,'','','',0,0,0,2,0,0,0),(442000003000,0,'中山港街道',3,442000,0,0,'','','',0,0,0,3,0,0,0),(442000004000,0,'西区街道',3,442000,0,0,'','','',0,0,0,4,0,0,0),(442000005000,0,'南区街道',3,442000,0,0,'','','',0,0,0,5,0,0,0),(442000006000,0,'五桂山街道',3,442000,0,0,'','','',0,0,0,6,0,0,0),(442000100000,0,'小榄镇',3,442000,0,0,'','','',0,0,0,7,0,0,0),(442000101000,0,'黄圃镇',3,442000,0,0,'','','',0,0,0,8,0,0,0),(442000102000,0,'民众镇',3,442000,0,0,'','','',0,0,0,9,0,0,0),(442000103000,0,'东凤镇',3,442000,0,0,'','','',0,0,0,10,0,0,0),(442000104000,0,'东升镇',3,442000,0,0,'','','',0,0,0,11,0,0,0),(442000105000,0,'古镇镇',3,442000,0,0,'','','',0,0,0,12,0,0,0),(442000106000,0,'沙溪镇',3,442000,0,0,'','','',0,0,0,13,0,0,0),(442000107000,0,'坦洲镇',3,442000,0,0,'','','',0,0,0,14,0,0,0),(442000108000,0,'港口镇',3,442000,0,0,'','','',0,0,0,15,0,0,0),(442000109000,0,'三角镇',3,442000,0,0,'','','',0,0,0,16,0,0,0),(442000110000,0,'横栏镇',3,442000,0,0,'','','',0,0,0,17,0,0,0),(442000111000,0,'南头镇',3,442000,0,0,'','','',0,0,0,18,0,0,0),(442000112000,0,'阜沙镇',3,442000,0,0,'','','',0,0,0,19,0,0,0),(442000113000,0,'南朗镇',3,442000,0,0,'','','',0,0,0,20,0,0,0),(442000114000,0,'三乡镇',3,442000,0,0,'','','',0,0,0,21,0,0,0),(442000115000,0,'板芙镇',3,442000,0,0,'','','',0,0,0,22,0,0,0),(442000116000,0,'大涌镇',3,442000,0,0,'','','',0,0,0,23,0,0,0),(442000117000,0,'神湾镇',3,442000,0,0,'','','',0,0,0,24,0,0,0),(460400100000,0,'那大镇',3,460400,0,0,'','','',0,0,0,1,0,0,0),(460400101000,0,'和庆镇',3,460400,0,0,'','','',0,0,0,2,0,0,0),(460400102000,0,'南丰镇',3,460400,0,0,'','','',0,0,0,3,0,0,0),(460400103000,0,'大成镇',3,460400,0,0,'','','',0,0,0,4,0,0,0),(460400104000,0,'雅星镇',3,460400,0,0,'','','',0,0,0,5,0,0,0),(460400105000,0,'兰洋镇',3,460400,0,0,'','','',0,0,0,6,0,0,0),(460400106000,0,'光村镇',3,460400,0,0,'','','',0,0,0,7,0,0,0),(460400107000,0,'木棠镇',3,460400,0,0,'','','',0,0,0,8,0,0,0),(460400108000,0,'海头镇',3,460400,0,0,'','','',0,0,0,9,0,0,0),(460400109000,0,'峨蔓镇',3,460400,0,0,'','','',0,0,0,10,0,0,0),(460400111000,0,'王五镇',3,460400,0,0,'','','',0,0,0,11,0,0,0),(460400112000,0,'白马井镇',3,460400,0,0,'','','',0,0,0,12,0,0,0),(460400113000,0,'中和镇',3,460400,0,0,'','','',0,0,0,13,0,0,0),(460400114000,0,'排浦镇',3,460400,0,0,'','','',0,0,0,14,0,0,0),(460400115000,0,'东成镇',3,460400,0,0,'','','',0,0,0,15,0,0,0),(460400116000,0,'新州镇',3,460400,0,0,'','','',0,0,0,16,0,0,0),(460400499000,0,'洋浦经济开发区',3,460400,0,0,'','','',0,0,0,17,0,0,0),(460400500000,0,'华南热作学院',3,460400,0,0,'','','',0,0,0,18,0,0,0);
/*!40000 ALTER TABLE `luck_city` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_collate`
--

DROP TABLE IF EXISTS `luck_collate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_collate` (
  `ID` bigint NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `IsDefault` tinyint(1) NOT NULL DEFAULT '0' COMMENT '默认',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  `IsDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除',
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='排序规则';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_collate`
--

LOCK TABLES `luck_collate` WRITE;
/*!40000 ALTER TABLE `luck_collate` DISABLE KEYS */;
INSERT INTO `luck_collate` VALUES (1,'asdfasf',0,1657982784,1657982784,0);
/*!40000 ALTER TABLE `luck_collate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_config_aliyun`
--

DROP TABLE IF EXISTS `luck_config_aliyun`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_config_aliyun` (
  `ID` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `AppKey` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'AppKey',
  `AppSecret` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'AppSecret',
  `SignName` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '短信签名',
  `TemplateCode` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '模板ID',
  `CreateType` tinyint(1) NOT NULL DEFAULT '1' COMMENT '创建方式',
  `Length` tinyint(1) NOT NULL DEFAULT '6' COMMENT '短信长度',
  `IsLog` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启日志',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_config_aliyun`
--

LOCK TABLES `luck_config_aliyun` WRITE;
/*!40000 ALTER TABLE `luck_config_aliyun` DISABLE KEYS */;
INSERT INTO `luck_config_aliyun` VALUES (1,'asdf','','','',1,6,0,0,0);
/*!40000 ALTER TABLE `luck_config_aliyun` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_config_order`
--

DROP TABLE IF EXISTS `luck_config_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_config_order` (
  `ID` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `IsOrder` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启订单(总开关)',
  `IsMustAuth` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启实名下单',
  `IsShare` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启分享(总开关)',
  `IsIntegral` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启积分(总开关)',
  `IsCommission` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启分佣(总开关)',
  `ShowOrderLength` int NOT NULL DEFAULT '1' COMMENT '订单显示长度',
  `CommissionValue` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '分佣值',
  `IsCollection` tinyint(1) NOT NULL DEFAULT '0' COMMENT '藏品集',
  `IsBlind` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启盲盒(总开关)',
  `IsAirdrop` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启空投(总开关)',
  `IsPriority` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启优先购(总开关)',
  `IsTransfer` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启转赠(总开关)',
  `IsCompose` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启合成(总开关)',
  `IsSecMarket` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启二级市场(总开关)',
  `IsResale` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启转售',
  `IsSingle` tinyint(1) NOT NULL DEFAULT '0' COMMENT '单商品模式',
  `OrderLength` int NOT NULL DEFAULT '12' COMMENT '订单长度(除日期)',
  `IsPay` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启支付(总开关)',
  `IsBalancePay` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启余额支付(总开关)',
  `IsWechatPay` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启微信支付(总开关)',
  `IsAliPay` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启支付宝支付(总开关)',
  `IsSandePay` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启杉德支付(总开关)',
  `IsPlatformPay` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启平台支付(总开关)',
  `IsCentMall` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启积分商城(总开关)',
  `IsTestPay` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启测试支付',
  `TestPayFee` float(5,2) NOT NULL DEFAULT '0.01' COMMENT '测试支付金额',
  `WaitTime` int NOT NULL DEFAULT '5' COMMENT '订单超时时间(分)',
  `OrderLocked` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启未支付库存锁',
  `AutoConfirmTime` int NOT NULL DEFAULT '15' COMMENT '订单自动确认时间(天)',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  `BuyMessage` varchar(2048) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='订单设置';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_config_order`
--

LOCK TABLES `luck_config_order` WRITE;
/*!40000 ALTER TABLE `luck_config_order` DISABLE KEYS */;
INSERT INTO `luck_config_order` VALUES (1,1,0,0,0,0,1,'',0,0,0,0,1,0,1,1,0,12,0,0,0,0,0,0,0,0,0.01,30,0,15,0,0,'');
/*!40000 ALTER TABLE `luck_config_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_config_qiniu`
--

DROP TABLE IF EXISTS `luck_config_qiniu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_config_qiniu` (
  `ID` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `AccessKey` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'AccessKey',
  `SecretKey` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'SecretKey',
  `Bucket` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Bucket',
  `Dirname` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Dirname',
  `Domain` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Domain',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_config_qiniu`
--

LOCK TABLES `luck_config_qiniu` WRITE;
/*!40000 ALTER TABLE `luck_config_qiniu` DISABLE KEYS */;
INSERT INTO `luck_config_qiniu` VALUES (1,'asdf','asdf','asdf','asdf','asdf',0,0);
/*!40000 ALTER TABLE `luck_config_qiniu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_config_sande`
--

DROP TABLE IF EXISTS `luck_config_sande`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_config_sande` (
  `ID` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `MerchantName` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '商户名称',
  `MerchantID` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '商户ID',
  `MerKey` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'MerKey',
  `Md5Key` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Md5Key',
  `MerchantCer` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '商户cer',
  `MerchantPfx` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '商户pfx',
  `Prikey` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Prikey',
  `SandeCer` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '杉德cer',
  `SandeProCer` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '杉德procer',
  `NotifyUrl` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '支付回调地址',
  `AccountUrl` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '开户回调地址',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_config_sande`
--

LOCK TABLES `luck_config_sande` WRITE;
/*!40000 ALTER TABLE `luck_config_sande` DISABLE KEYS */;
/*!40000 ALTER TABLE `luck_config_sande` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_config_system`
--

DROP TABLE IF EXISTS `luck_config_system`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_config_system` (
  `ID` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `WebName` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '网站名称',
  `EnName` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '网站英文名称',
  `Logo` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Logo',
  `Domain` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Domain',
  `Icp` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'ICP',
  `Psr` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'PSR',
  `CopyRight` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '版权所有',
  `Support` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '技术支持',
  `WebStatus` tinyint(1) NOT NULL DEFAULT '1' COMMENT '网站状态',
  `WebMsg` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '网站信息',
  `CoName` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '企业名称',
  `CoEnName` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '企业英文名称',
  `Legaler` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '法人代表',
  `CoNumber` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '注册号',
  `License` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '营业执照',
  `Contact` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '联系人',
  `Telphone` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '座机号码',
  `Fax` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '传真',
  `Mobile` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '手机号码',
  `Hotline` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '400客服',
  `Email` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Email',
  `Address` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '地址',
  `Miit` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '工信备案网址',
  `Pagesize` int NOT NULL DEFAULT '10' COMMENT '显示条数',
  `Keywords` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '关键词',
  `Description` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '描述',
  `Webcode` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '统计代码',
  `UserAgreement` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '用户协议',
  `WebAgreement` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '平台协议',
  `Privacy` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '隐私政策',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  `About` text COLLATE utf8mb4_unicode_ci COMMENT '关于我们',
  KEY `ID` (`ID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='系统设置';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_config_system`
--

LOCK TABLES `luck_config_system` WRITE;
/*!40000 ALTER TABLE `luck_config_system` DISABLE KEYS */;
INSERT INTO `luck_config_system` VALUES (1,'逸间茶','yijiantea','','www.yijiantea.cn','','','','',1,'','','','','','','','','','','','','','',10,'','','','逸间茶','','逸间茶',0,0,'');
/*!40000 ALTER TABLE `luck_config_system` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_config_tencent`
--

DROP TABLE IF EXISTS `luck_config_tencent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_config_tencent` (
  `ID` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `SecretId` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'SecretId',
  `SecretKey` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'SecretKey',
  `AppId` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'AppId',
  `SignName` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '短信签名',
  `TemplateCode` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '模板ID',
  `CreateType` tinyint(1) NOT NULL DEFAULT '1' COMMENT '创建方式',
  `Length` tinyint(1) NOT NULL DEFAULT '6' COMMENT '短信长度',
  `IsLog` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启日志',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_config_tencent`
--

LOCK TABLES `luck_config_tencent` WRITE;
/*!40000 ALTER TABLE `luck_config_tencent` DISABLE KEYS */;
INSERT INTO `luck_config_tencent` VALUES (1,'','','','','',1,6,0,0,0);
/*!40000 ALTER TABLE `luck_config_tencent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_config_user`
--

DROP TABLE IF EXISTS `luck_config_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_config_user` (
  `ID` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `IsReg` tinyint(1) NOT NULL DEFAULT '1' COMMENT '开启前端注册',
  `IsLoginReg` tinyint(1) NOT NULL DEFAULT '1' COMMENT '开启后端注册',
  `IsLogin` tinyint(1) NOT NULL DEFAULT '1' COMMENT '开启前端登录',
  `IsLoginLogin` tinyint(1) NOT NULL DEFAULT '1' COMMENT '开启后端登录',
  `IsAutoGetMobile` tinyint(1) NOT NULL DEFAULT '1' COMMENT '自动抓取手机号',
  `IsRegUsername` tinyint(1) NOT NULL DEFAULT '1' COMMENT '注册用户名必填',
  `IsRegNickname` tinyint(1) NOT NULL DEFAULT '1' COMMENT '注册昵称必填',
  `IsRegRealname` tinyint(1) NOT NULL DEFAULT '1' COMMENT '注册真实姓名必填',
  `IsEnRealname` tinyint(1) NOT NULL DEFAULT '1' COMMENT '允许英文姓名',
  `IsRegGender` tinyint(1) NOT NULL DEFAULT '1' COMMENT '注册性别必填',
  `IsRegPassword` tinyint(1) NOT NULL DEFAULT '1' COMMENT '注册密码必填',
  `IsRegCheckpwd` tinyint(1) NOT NULL DEFAULT '1' COMMENT '注册确认密码必填',
  `IsRegMobile` tinyint(1) NOT NULL DEFAULT '1' COMMENT '注册手机号必填',
  `IsRegEmail` tinyint(1) NOT NULL DEFAULT '1' COMMENT '注册Email必填',
  `IsRegRole` tinyint(1) NOT NULL DEFAULT '1' COMMENT '注册角色必填',
  `IsRegInvite` tinyint(1) NOT NULL DEFAULT '0' COMMENT '注册邀请码必填',
  `IsRegNumcode` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启注册图形验证码',
  `IsRegSmscode` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启注册短信验证码',
  `IsRegEmailcode` tinyint(1) NOT NULL DEFAULT '0' COMMENT '注册邮箱验证码必填',
  `IsRegSlider` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启注册滑块验证码',
  `UsernameMinLength` int NOT NULL DEFAULT '6' COMMENT '用户名最小长度',
  `UsernameMaxLength` int NOT NULL DEFAULT '30' COMMENT '用户名最大长度',
  `UsernameSpecialCharacter` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '_' COMMENT '用户名允许特殊字符',
  `IsUsernameLetter` tinyint(1) NOT NULL DEFAULT '1' COMMENT '字母',
  `IsUsernameNumeral` tinyint(1) NOT NULL DEFAULT '0' COMMENT '数字',
  `IsUsernameChinese` tinyint(1) NOT NULL DEFAULT '0' COMMENT '中文',
  `IsUsernameSpecial` tinyint(1) NOT NULL DEFAULT '0' COMMENT '特殊字符',
  `PregUsername` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名正则',
  `AuthMinAge` int NOT NULL DEFAULT '0' COMMENT '最小认证年龄',
  `AuthMaxAge` int NOT NULL DEFAULT '0' COMMENT '最大认证年龄',
  `RegActivateType` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户注册激活方式',
  `IdcardLength` tinyint(1) NOT NULL DEFAULT '6' COMMENT '身份证后位数',
  `PasswordMinLength` int NOT NULL DEFAULT '6' COMMENT '密码最小长度',
  `PasswordMaxLength` int NOT NULL DEFAULT '30' COMMENT '密码最大长度',
  `PasswordSpecialCharacter` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '_.#$%&*' COMMENT '允许特殊字符',
  `IsPasswordUpper` tinyint(1) NOT NULL DEFAULT '0' COMMENT '大写字母',
  `IsPasswordLower` tinyint(1) NOT NULL DEFAULT '0' COMMENT '小写字母',
  `IsPasswordNumeral` tinyint(1) NOT NULL DEFAULT '0' COMMENT '数字',
  `IsPasswordSpecial` tinyint(1) NOT NULL DEFAULT '0' COMMENT '包含特殊字符',
  `PregPassword` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '密码正则',
  `IsLoginUsername` tinyint(1) NOT NULL DEFAULT '0' COMMENT '允许用户名登录',
  `IsLoginMobile` tinyint(1) NOT NULL DEFAULT '0' COMMENT '允许手机登录',
  `IsAutoRegMobile` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启手机自动注册',
  `IsLoginEmail` tinyint(1) NOT NULL DEFAULT '0' COMMENT '允许Email登录',
  `IsLoginIdcard` tinyint(1) NOT NULL DEFAULT '0' COMMENT '允许身份证登录',
  `IsLoginNumcode` tinyint(1) NOT NULL DEFAULT '1' COMMENT '开启登录验证码',
  `IsLoginSmscode` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启登录短信验证码',
  `IsLoginSlider` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启登录滑块验证码',
  `IsTestSmscode` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启测试短信验证码',
  `TestSmscode` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '123456' COMMENT '测试短信验证码',
  `TestMobile` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '测试手机号码',
  `IsThirdWechat` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启微信登录',
  `IsThirdQq` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启QQ登录',
  `IsThirdWeibo` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启微博登录',
  `IsThirdAlipay` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启支付宝登录',
  `IsThirdTaobao` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启淘宝登录',
  `MaxIdcardRegCount` tinyint(1) NOT NULL DEFAULT '1' COMMENT '身份证最大注册用户数',
  `MaxMobileRegCount` tinyint(1) NOT NULL DEFAULT '1' COMMENT '手机最大注册用户数',
  `MaxEmailRegCount` tinyint(1) NOT NULL DEFAULT '1' COMMENT '邮箱最大注册用户数',
  `AccountLength` int NOT NULL DEFAULT '8' COMMENT 'AccountID长度',
  `InviteLen` int NOT NULL DEFAULT '6' COMMENT '邀请码长度',
  `InviteType` tinyint(1) NOT NULL DEFAULT '1' COMMENT '生成邀请码方式',
  `EncrypType` tinyint(1) NOT NULL DEFAULT '1' COMMENT '密码加密方式',
  `IsEvercookie` tinyint(1) NOT NULL DEFAULT '1' COMMENT '开启永久cookie',
  `MultipleLogin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '用户多开登录',
  `ForceLastLogin` tinyint(1) NOT NULL DEFAULT '1' COMMENT '强制后登录',
  `TokenExpireTime` int NOT NULL DEFAULT '3600' COMMENT 'Token过期时间(秒)',
  `DefaultPassword` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'S123456' COMMENT '默认密码',
  `RegSendScore` int NOT NULL DEFAULT '0' COMMENT '注册赠送积分',
  `SignSendScore` int NOT NULL DEFAULT '0' COMMENT '签到赠送积分',
  `ShareSendScore` int NOT NULL DEFAULT '0' COMMENT '分享赠送积分',
  `RegSendCoin` int NOT NULL DEFAULT '0' COMMENT '注册送金币',
  `SignSendCoin` int NOT NULL DEFAULT '0' COMMENT '签到送金币',
  `ShareSendCoin` int NOT NULL DEFAULT '0' COMMENT '分享送金币',
  `RegSendBalance` int NOT NULL DEFAULT '0' COMMENT '注册赠送余额',
  `SignSendBalancee` int NOT NULL DEFAULT '0' COMMENT '签到赠送余额',
  `ShareSendBalancee` int NOT NULL DEFAULT '0' COMMENT '分享赠送余额',
  `IsRegLog` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启注册日志',
  `IsLoginLog` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启登录日志',
  `WebInterval` int NOT NULL DEFAULT '30' COMMENT '网页操作间隔',
  `LoginInterval` int NOT NULL DEFAULT '180' COMMENT '注册登录操作间隔',
  `LoginNumber` tinyint(1) NOT NULL DEFAULT '5' COMMENT '开启登录错误次数',
  `IsBlack` tinyint(1) NOT NULL DEFAULT '1' COMMENT '开启IP黑名单',
  `BlackIp` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '黑名单列表',
  `IsWhite` tinyint(1) NOT NULL DEFAULT '1' COMMENT '开启IP白名单',
  `WhiteIp` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '白名单列表',
  `DefaultRegRoleid` int NOT NULL DEFAULT '0' COMMENT '用户默认注册角色',
  `DisableKeyword` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '禁用关键词',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  KEY `ID` (`ID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户设置';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_config_user`
--

LOCK TABLES `luck_config_user` WRITE;
/*!40000 ALTER TABLE `luck_config_user` DISABLE KEYS */;
INSERT INTO `luck_config_user` VALUES (1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,0,0,0,0,6,30,'_',1,0,0,0,'',0,0,1,6,6,30,'_.#$%&*',0,0,0,0,'',1,1,0,0,0,1,1,0,0,'0','',0,0,0,0,0,1,1,1,8,7,1,1,1,0,1,3600,'S123456',10,0,0,5,0,0,3,0,0,0,0,30,180,5,1,'',1,'',0,'',0,0);
/*!40000 ALTER TABLE `luck_config_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_config_wechat`
--

DROP TABLE IF EXISTS `luck_config_wechat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_config_wechat` (
  `ID` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `WechatName` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '公众号名称',
  `AppId` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'AppId',
  `AppSecret` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'AppSecret',
  `ServerUrl` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '服务器地址',
  `Token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Token',
  `WxQrcode` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '公众号二维码',
  `MiniWechatName` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '小程序名称',
  `MiniOriginalId` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '小程序原始id',
  `MiniAppId` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '小程序AppId',
  `MiniAppSecret` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '小程序AppSecret',
  `MiniQrcode` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '小程序二维码',
  `AppWechatName` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '移动应用名称',
  `AppAppId` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '移动应用AppId',
  `AppAppSecret` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '移动应用AppSecret',
  `WebWechatName` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '网站应用名称',
  `WebAppId` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '网站应用AppId',
  `WebAppSecret` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '网站应用AppSecret',
  `MchId` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '商户号ID',
  `SerialNumber` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'API证书序列号',
  `ApiKey` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Api私钥',
  `Apiv3Key` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Apiv3私钥',
  `Apicert` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Apicert证书',
  `Apikeys` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Apikeys证书',
  `NotifyUrl` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '回调地址',
  `ReturnUrl` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '返回地址',
  `ServiceQrcode` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '客服二维码',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='订单设置';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_config_wechat`
--

LOCK TABLES `luck_config_wechat` WRITE;
/*!40000 ALTER TABLE `luck_config_wechat` DISABLE KEYS */;
INSERT INTO `luck_config_wechat` VALUES (1,'asdvfasdf','asdfasd','asdf','','','','','','','','','','','','','','','','','','','','','','','',0,0);
/*!40000 ALTER TABLE `luck_config_wechat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_currency`
--

DROP TABLE IF EXISTS `luck_currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_currency` (
  `ID` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `CurrencyName` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '币种名称',
  `Symbol` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标识符',
  `IsDefault` tinyint(1) NOT NULL DEFAULT '0' COMMENT '默认',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  `DeleteTime` int NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='币种';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_currency`
--

LOCK TABLES `luck_currency` WRITE;
/*!40000 ALTER TABLE `luck_currency` DISABLE KEYS */;
INSERT INTO `luck_currency` VALUES (1,'人民币','¥',0,1657999264,1657999264,0),(2,'sadf','sddd',0,1666836964,1666836964,0);
/*!40000 ALTER TABLE `luck_currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_engine`
--

DROP TABLE IF EXISTS `luck_engine`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_engine` (
  `ID` bigint NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `IsDefault` tinyint(1) NOT NULL DEFAULT '0' COMMENT '默认',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  `IsDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除',
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='存储引擎';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_engine`
--

LOCK TABLES `luck_engine` WRITE;
/*!40000 ALTER TABLE `luck_engine` DISABLE KEYS */;
INSERT INTO `luck_engine` VALUES (1,'asdfs',0,1657980803,1657980803,0);
/*!40000 ALTER TABLE `luck_engine` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_goods`
--

DROP TABLE IF EXISTS `luck_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_goods` (
  `ID` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `CategoryID` int NOT NULL DEFAULT '0' COMMENT '类别',
  `GoodsTitle` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '商品标题',
  `Keyword` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '关键词',
  `Description` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '商品描述',
  `IsVirtual` tinyint(1) NOT NULL DEFAULT '0' COMMENT '虚拟商品',
  `GoodsCode` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '商品编码',
  `Pic` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '图片',
  `Picture` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '轮播图',
  `ShowType` tinyint(1) NOT NULL DEFAULT '1' COMMENT '展示方式',
  `LinkUrl` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '外链地址',
  `BrandID` int NOT NULL DEFAULT '1' COMMENT '品牌',
  `Tags` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标签',
  `Price` int NOT NULL DEFAULT '0' COMMENT '价格',
  `OriginalPrice` int NOT NULL DEFAULT '0' COMMENT '原价',
  `CostPrice` int NOT NULL DEFAULT '0' COMMENT '成本价',
  `CurrencyID` int NOT NULL DEFAULT '0' COMMENT '币种',
  `UnitID` int NOT NULL DEFAULT '0' COMMENT '单位',
  `Stock` int NOT NULL DEFAULT '0' COMMENT '库存',
  `AlarmStock` int NOT NULL DEFAULT '0' COMMENT '预警库存',
  `GoodsNumber` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '商品货号',
  `BatchCode` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '批次号',
  `Barcode` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '条形码',
  `LimitCount` int NOT NULL DEFAULT '0' COMMENT '商品限购',
  `LimitOrder` int NOT NULL DEFAULT '0' COMMENT '订单限购',
  `LimitBalance` int NOT NULL DEFAULT '0' COMMENT '余额限购',
  `LimitCoin` int NOT NULL DEFAULT '0' COMMENT '平台币限购',
  `IsAllowShare` tinyint(1) NOT NULL DEFAULT '0' COMMENT '允许分享',
  `GiveCent` int NOT NULL DEFAULT '0' COMMENT '赠送积分',
  `ShareTitle` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '分享标题',
  `SharePic` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '分享图片',
  `IsCommission` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启分佣',
  `ShareCommissionValue` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '分享佣金值',
  `Hits` int NOT NULL DEFAULT '0' COMMENT '点击量',
  `Collects` int NOT NULL DEFAULT '0' COMMENT '收藏次数',
  `Sales` int NOT NULL DEFAULT '0' COMMENT '销量',
  `IsTop` tinyint(1) NOT NULL DEFAULT '0' COMMENT '置顶',
  `Sort` int NOT NULL DEFAULT '0' COMMENT '排序',
  `StartTime` int NOT NULL DEFAULT '0' COMMENT '开始时间',
  `EndTime` int NOT NULL DEFAULT '0' COMMENT '结束时间',
  `Content` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '商品详情',
  `Status` tinyint(1) NOT NULL DEFAULT '-1' COMMENT '状态',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  `DeleteTime` int NOT NULL DEFAULT '0' COMMENT '删除时间',
  `IsDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除',
  PRIMARY KEY (`ID`) USING BTREE,
  KEY `idx_goods_category_id` (`CategoryID`) USING BTREE,
  KEY `idx_goods_code` (`GoodsCode`) USING BTREE,
  KEY `idx_goods_brand_id` (`BrandID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='商品';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_goods`
--

LOCK TABLES `luck_goods` WRITE;
/*!40000 ALTER TABLE `luck_goods` DISABLE KEYS */;
INSERT INTO `luck_goods` VALUES (1,1,'asdfasdfasdfasdf','','asdf',0,'290141913001','https://img.huanrang.art/hr/9b30dcbe3c3cdf49569f7cc877e8833d.jpg','[{\"name\":\"https:\\/\\/img.huanrang.art\\/hr\\/9b30dcbe3c3cdf49569f7cc877e8833d.jpg\",\"url\":\"https:\\/\\/img.huanrang.art\\/hr\\/9b30dcbe3c3cdf49569f7cc877e8833d.jpg\"},{\"name\":\"https:\\/\\/img.huanrang.art\\/hr\\/842dd8c5a9c355b8fe5cdb02965d6a0d.png\",\"url\":\"https:\\/\\/img.huanrang.art\\/hr\\/842dd8c5a9c355b8fe5cdb02965d6a0d.png\"}]',1,'',1,'\"\"',10000,10000,10000,2,1,100,0,'asdf','asdf','asdf',0,0,0,0,0,0,'','',0,'',0,0,0,0,1,0,0,'<p>asdfasdf</p>',-1,1666873666,0,0,0);
/*!40000 ALTER TABLE `luck_goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_goods_cate`
--

DROP TABLE IF EXISTS `luck_goods_cate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_goods_cate` (
  `ID` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Title` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '类别名称',
  `Sign` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标识符',
  `Pic` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '图片',
  `Level` int NOT NULL DEFAULT '1' COMMENT '层级',
  `PID` int NOT NULL DEFAULT '0' COMMENT '父级',
  `Number` int NOT NULL DEFAULT '0' COMMENT '子数目',
  `Sort` int NOT NULL DEFAULT '1' COMMENT '排序',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  `DeleteTime` int NOT NULL DEFAULT '0' COMMENT '删除时间',
  `IsDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除',
  PRIMARY KEY (`ID`) USING BTREE,
  KEY `idx_goods_cate_pid` (`PID`) USING BTREE,
  KEY `idx_goods_cate_level` (`Level`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='商品分类';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_goods_cate`
--

LOCK TABLES `luck_goods_cate` WRITE;
/*!40000 ALTER TABLE `luck_goods_cate` DISABLE KEYS */;
INSERT INTO `luck_goods_cate` VALUES (1,'类别一','T1','https://img.huanrang.art/hr/9b30dcbe3c3cdf49569f7cc877e8833d.jpg',1,0,0,1,1666871185,1666871185,0,0);
/*!40000 ALTER TABLE `luck_goods_cate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_goods_tags`
--

DROP TABLE IF EXISTS `luck_goods_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_goods_tags` (
  `ID` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `TagName` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标签名称',
  `Pic` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标签图片',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  `DeleteTime` int NOT NULL DEFAULT '0' COMMENT '删除时间',
  `IsDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除',
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='商品标签';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_goods_tags`
--

LOCK TABLES `luck_goods_tags` WRITE;
/*!40000 ALTER TABLE `luck_goods_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `luck_goods_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_grant`
--

DROP TABLE IF EXISTS `luck_grant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_grant` (
  `ID` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `RoleID` int NOT NULL DEFAULT '0' COMMENT '角色',
  `MenuID` int NOT NULL DEFAULT '0' COMMENT '菜单',
  `IsShow` tinyint(1) NOT NULL DEFAULT '0' COMMENT '显示',
  `Handle` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'handle',
  PRIMARY KEY (`ID`) USING BTREE,
  KEY `idx_grant_role_id` (`RoleID`) USING BTREE,
  KEY `idx_grant_menu_id` (`MenuID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='授权';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_grant`
--

LOCK TABLES `luck_grant` WRITE;
/*!40000 ALTER TABLE `luck_grant` DISABLE KEYS */;
INSERT INTO `luck_grant` VALUES (1,6,5,1,'1,2,3,4,5,6'),(2,6,6,1,'1,2,3,4,5,6'),(3,6,7,1,'1,2,3,4,5,6'),(4,6,8,1,'1,2,3,4,5,6'),(5,6,9,1,'1,2,3,4,5,6'),(6,6,10,1,'1,2,3,4,5,6'),(7,6,11,1,'1,2,3,4,5,6'),(8,6,12,1,'1,2,3,4,5,6');
/*!40000 ALTER TABLE `luck_grant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_handle`
--

DROP TABLE IF EXISTS `luck_handle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_handle` (
  `ID` bigint NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Title` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '行为说明',
  `HandleName` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '行为标识',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  `IsDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除',
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='行为';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_handle`
--

LOCK TABLES `luck_handle` WRITE;
/*!40000 ALTER TABLE `luck_handle` DISABLE KEYS */;
INSERT INTO `luck_handle` VALUES (1,'刷新','IsRefresh',0,0,0),(2,'新增','IsAdd',0,0,0),(3,'修改','IsModify',0,0,0),(4,'保存','IsSave',0,0,0),(5,'选择','IsSelect',0,0,0),(6,'查询','IsSearch',0,0,0),(7,'标识删除','IsSignDel',0,0,0),(8,'批量标识删除','IsMassSignDel',0,0,0),(9,'真实删除','IsRealDel',0,0,0),(10,'批量真实删除','IsMassRealDel',0,0,0),(11,'导入','IsImport',0,0,0),(12,'导出','IsExport',0,0,0),(13,'审核','IsChecked',0,0,0),(14,'核准','IsApproved',0,0,0),(15,'驳回','IsReject',0,0,0),(16,'指派','IsAssign',0,0,0),(17,'执行','IsExecute',0,0,0),(18,'自动结算','IsSettle',0,0,0),(19,'测试','IsTest',0,0,0),(20,'打印','IsPrint',0,0,0),(21,'分配业务员','IsAssign',0,0,0),(22,'显示ID','IsShowID',0,0,0),(23,'恢复默认','IsRestore',0,0,0),(24,'清空表','IsTruncate',0,0,0),(25,'返回','IsBack',0,0,0),(26,'','',1666840847,1666840847,0);
/*!40000 ALTER TABLE `luck_handle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_menu`
--

DROP TABLE IF EXISTS `luck_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_menu` (
  `ID` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Title` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单名称',
  `Pic` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '图标',
  `Level` int NOT NULL DEFAULT '1' COMMENT '级别',
  `PID` int NOT NULL DEFAULT '0' COMMENT '父级',
  `IsOpen` tinyint(1) NOT NULL DEFAULT '0' COMMENT '展开',
  `ModuleID` int NOT NULL DEFAULT '0' COMMENT '模块',
  `Pvalue` int NOT NULL DEFAULT '0' COMMENT '父级id',
  `Cvalue` int NOT NULL DEFAULT '0' COMMENT '类别id',
  `Svalue` int NOT NULL DEFAULT '0' COMMENT '状态id',
  `Router` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '链接值',
  `Number` int NOT NULL DEFAULT '0' COMMENT '子数目',
  `Sort` int NOT NULL DEFAULT '1' COMMENT '排序',
  `IsDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  `DeleteTime` int NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`ID`) USING BTREE,
  KEY `idx_menu_pid` (`PID`) USING BTREE,
  KEY `idx_menu_level` (`Level`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='菜单';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_menu`
--

LOCK TABLES `luck_menu` WRITE;
/*!40000 ALTER TABLE `luck_menu` DISABLE KEYS */;
INSERT INTO `luck_menu` VALUES (1,'控制台','',1,0,0,0,0,0,0,'',3,1,0,1655450739,1655450739,0),(2,'系统管理','',2,1,0,0,0,0,0,'',2,1,0,1655450739,1655450739,0),(3,'模块管理','',2,1,0,0,0,0,0,'',5,2,0,1655450739,1655450739,0),(4,'菜单管理','',2,1,0,0,0,0,0,'',1,3,0,1655450739,1655450739,0),(5,'系统设置','',3,2,0,0,0,0,0,'config/system',0,1,0,1655450739,1655450739,0),(6,'用户设置','',3,2,0,0,0,0,0,'config/user',0,2,0,1655450739,1655450739,0),(7,'模块管理','',3,3,0,0,0,0,0,'module',0,1,0,1655450739,1655450739,0),(8,'行为管理','',3,3,0,0,0,0,0,'handle',0,2,0,1655450739,1655450739,0),(9,'字符编码','',3,3,0,0,0,0,0,'charset',0,3,0,1655450739,1655450739,0),(10,'存储引擎','',3,3,0,0,0,0,0,'engine',0,4,0,1655450739,1655450739,0),(11,'排序规则','',3,3,0,0,0,0,0,'collate',0,5,0,1655450739,1655450739,0),(12,'菜单设置','',3,4,0,0,0,0,0,'menu',0,1,0,1655450739,1655450739,0),(13,'基础','d',1,0,0,0,0,0,0,'',3,2,0,1656859575,1656859575,0),(14,'基础设置','d',2,13,0,0,0,0,0,'',9,1,0,1656859610,1656859610,0),(15,'单位管理','adds',3,14,0,109,0,0,0,'unit',0,1,0,1656859627,1656859627,0),(16,'币种管理','d',3,14,0,151,0,0,0,'currency',0,2,0,1666782981,1666782981,0),(17,'品牌管理','f',3,14,0,154,0,0,0,'brand',0,3,0,1666783040,1666783040,0),(18,'城市管理','d',3,14,0,152,0,0,0,'city',0,4,0,1666784187,1666784187,0),(19,'银行管理','d',3,14,0,153,0,0,0,'bank',0,5,0,1666784262,1666784262,0),(20,'用户','f',1,0,0,0,0,0,0,'',3,3,0,1666788618,1666788618,0),(21,'管理员','f',2,20,0,180,1,0,0,'',2,1,0,1666788681,1666788681,0),(22,'企业员工','fa',2,20,0,180,2,0,0,'',1,2,0,1666788709,1666788709,0),(23,'会员管理','f',2,20,0,180,3,0,0,'',1,3,0,1666788735,1666788735,0),(24,'超级管理员','f',3,21,0,180,0,0,0,'user',0,1,0,1666788774,1666788774,0),(25,'管理员','f',3,21,0,180,0,0,0,'user',0,2,0,1666788801,1666788801,0),(26,'员工管理','f',3,22,0,180,0,0,0,'user',0,1,0,1666788824,1666788824,0),(27,'会员管理','f',3,23,0,180,0,0,0,'user',0,1,0,1666788841,1666788841,0),(28,'商品','fa',1,0,0,0,0,0,0,'',2,4,0,1666792230,1666792230,0),(29,'订单','f',1,0,0,0,0,0,0,'',2,5,0,1666792244,1666792244,0),(30,'小程序','f',1,0,0,0,0,0,0,'',0,6,0,1666792261,1666792261,0),(31,'商品设置','fa',2,28,0,0,0,0,0,'',3,1,0,1666792324,1666792324,0),(32,'商品管理','fa',2,28,0,0,0,0,0,'',1,2,0,1666792362,1666792362,0),(33,'商品类别','f',3,31,0,150,0,0,0,'goods/cate',0,1,0,1666792429,1666792429,0),(34,'属性设置','fa',3,31,0,150,0,0,0,'goods/attribute',0,2,0,1666792472,1666792472,0),(35,'规格设置','fa',3,31,0,150,0,0,0,'goods/spec',0,3,0,1666792496,1666792496,0),(36,'商品管理','fa',3,32,0,150,0,0,0,'goods',0,1,0,1666792550,1666792550,0),(37,'订单设置','f',2,29,0,0,0,0,0,'',1,1,0,1666793934,1666793934,0),(38,'订单管理','f',2,29,0,0,0,0,0,'',1,2,0,1666793951,1666793951,0),(39,'订单设置','f',3,37,0,150,0,0,0,'config/order',0,1,0,1666794017,1666794017,0),(40,'订单管理','fa',3,38,0,150,0,0,0,'order',0,1,0,1666794039,1666794039,0),(41,'系统设置','f',2,13,0,0,0,0,0,'',5,2,0,1666794809,1666794809,0),(42,'短信设置','f',3,41,0,111,0,0,0,'config/sms',0,1,0,1666794869,1666794869,0),(43,'微信设置','f',3,41,0,115,0,0,0,'config/wechat',0,2,0,1666794922,1666794922,0),(44,'七牛设置','f',3,41,0,117,0,0,0,'config/qiniu',0,3,0,1666794959,1666794959,0),(45,'用户设置','f',3,41,0,110,0,0,0,'config/user',0,4,0,1666795005,1666795005,0),(46,'订单设置','f',3,41,0,114,0,0,0,'config/order',0,5,0,1666795035,1666795035,0),(47,'权限','f',1,0,0,0,0,0,0,'',0,7,0,1666795122,1666795122,0);
/*!40000 ALTER TABLE `luck_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_message`
--

DROP TABLE IF EXISTS `luck_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_message` (
  `ID` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Title` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `Content` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '公告内容',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `CreateIP` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '创建IP',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  `IsDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除',
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='消息';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_message`
--

LOCK TABLES `luck_message` WRITE;
/*!40000 ALTER TABLE `luck_message` DISABLE KEYS */;
/*!40000 ALTER TABLE `luck_message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_module`
--

DROP TABLE IF EXISTS `luck_module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_module` (
  `ID` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Title` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '模块名称',
  `Tabname` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '表名',
  `Pic` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '图标',
  `Level` int NOT NULL DEFAULT '1' COMMENT '级别',
  `PID` int NOT NULL DEFAULT '0' COMMENT '父级',
  `Layer` tinyint(1) NOT NULL DEFAULT '1' COMMENT '表层级',
  `EngineID` int NOT NULL DEFAULT '0' COMMENT '引擎类型',
  `CharsetID` int NOT NULL DEFAULT '0' COMMENT '字符编码',
  `CollateID` int NOT NULL DEFAULT '0' COMMENT '排序规则',
  `IncrementValue` int NOT NULL DEFAULT '1' COMMENT '自增长起始值',
  `ParentTable` int NOT NULL DEFAULT '0' COMMENT '父级表',
  `CateTable` int NOT NULL DEFAULT '0' COMMENT '类别表',
  `StatusTable` int NOT NULL DEFAULT '0' COMMENT '状态表',
  `Number` int NOT NULL DEFAULT '0' COMMENT '子数目',
  `TagID` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标签',
  `HandleList` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '权限列表',
  `Comment` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '描述',
  `Sort` int NOT NULL DEFAULT '1' COMMENT '排序',
  `IsDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  `DeleteTime` int NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`ID`) USING BTREE,
  KEY `idx_module_pid` (`PID`) USING BTREE,
  KEY `idx_module_level` (`Level`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=222 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='模块';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_module`
--

LOCK TABLES `luck_module` WRITE;
/*!40000 ALTER TABLE `luck_module` DISABLE KEYS */;
INSERT INTO `luck_module` VALUES (1,'控制台','','',1,0,1,0,0,0,1,0,0,0,1,'','','',1,0,0,0,0),(2,'模型模块','','',1,0,1,0,0,0,1,0,0,0,5,'','','',2,0,0,0,0),(3,'菜单模块','','',1,0,1,0,0,0,1,0,0,0,1,'','','',3,0,0,0,0),(4,'设置模块','','',1,0,1,0,0,0,1,0,0,0,11,'','','',4,0,0,0,0),(5,'基础模块','','',1,0,1,0,0,0,1,0,0,0,6,'','','',5,0,0,0,0),(6,'会员模块','','',1,0,1,0,0,0,1,0,0,0,1,'','','',6,0,0,0,0),(7,'供应商模块','','',1,0,1,0,0,0,1,0,0,0,2,'','','',7,0,0,0,0),(8,'代理商模块','','',1,0,1,0,0,0,1,0,0,0,2,'','','',8,0,0,0,0),(9,'客户模块','','',1,0,1,0,0,0,1,0,0,0,2,'','','',9,0,0,0,0),(10,'网站模块','','',1,0,1,0,0,0,1,0,0,0,1,'','','',10,0,0,0,0),(11,'新闻模块','','',1,0,1,0,0,0,1,0,0,0,1,'','','',11,0,0,0,0),(12,'文章模块','','',1,0,1,0,0,0,1,0,0,0,1,'','','',12,0,0,0,0),(13,'素材模块','','',1,0,1,0,0,0,1,0,0,0,1,'','','',13,0,0,0,0),(14,'商城模块','','',1,0,1,0,0,0,1,0,0,0,1,'','','',14,0,0,0,0),(15,'营销模块','','',1,0,1,0,0,0,1,0,0,0,1,'','','',15,0,0,0,0),(16,'项目模块','','',1,0,1,0,0,0,1,0,0,0,1,'','','',16,0,0,0,0),(17,'招投标模块','','',1,0,1,0,0,0,1,0,0,0,1,'','','',17,0,0,0,0),(18,'采购模块','','',1,0,1,0,0,0,1,0,0,0,1,'','','',18,0,0,0,0),(19,'销售模块','','',1,0,1,0,0,0,1,0,0,0,1,'','','',19,0,0,0,0),(20,'仓储模块','','',1,0,1,0,0,0,1,0,0,0,1,'','','',20,0,0,0,0),(21,'订单模块','','',1,0,1,0,0,0,1,0,0,0,1,'','','',21,0,0,0,0),(22,'办公模块','','',1,0,1,0,0,0,1,0,0,0,1,'','','',22,0,0,0,0),(23,'研发模块','','',1,0,1,0,0,0,1,0,0,0,1,'','','',23,0,0,0,0),(24,'生产模块','','',1,0,1,0,0,0,1,0,0,0,1,'','','',24,0,0,0,0),(25,'财务模块','','',1,0,1,0,0,0,1,0,0,0,1,'','','',25,0,0,0,0),(26,'报表模块','','',1,0,1,0,0,0,1,0,0,0,1,'','','',26,0,0,0,0),(27,'日志模块','','',1,0,1,0,0,0,1,0,0,0,1,'','','',27,0,0,0,0),(28,'权限模块','','',1,0,1,0,0,0,1,0,0,0,1,'','','',28,0,0,0,0),(101,'控制台','console','',2,1,1,0,0,0,1,0,0,0,1,'','','',1,0,0,0,0),(102,'模块管理','module','',2,2,2,0,0,0,1,0,0,0,1,'','','',1,0,0,0,0),(103,'行为管理','handle','',2,2,1,0,0,0,1,0,0,0,1,'','','',2,0,0,0,0),(104,'字符编码','charset','',2,2,1,0,0,0,1,0,0,0,1,'','','',3,0,0,0,0),(105,'存储引擎','engine','',2,2,1,0,0,0,1,0,0,0,1,'','','',4,0,0,0,0),(106,'排序规则','collate','',2,2,1,0,0,0,1,0,0,0,1,'','','',5,0,0,0,0),(107,'菜单管理','menu','',2,3,3,0,0,0,1,0,0,0,1,'','','',1,0,0,0,0),(108,'系统设置','configSystem','',2,4,1,0,0,0,1,0,0,0,1,'','','',1,0,0,0,0),(109,'基础设置','configBase','',2,4,1,0,0,0,1,0,0,0,1,'','','',2,0,0,0,0),(110,'用户设置','configUser','',2,4,1,0,0,0,1,0,0,0,1,'','','',3,0,0,0,0),(111,'短信设置','configUser','',2,4,1,0,0,0,1,0,0,0,1,'','','',4,0,0,0,0),(112,'邮件设置','configUser','',2,4,1,0,0,0,1,0,0,0,1,'','','',5,0,0,0,0),(113,'商品设置','configGoods','',2,4,1,0,0,0,1,0,0,0,1,'','','',6,0,0,0,0),(114,'订单设置','configOrder','',2,4,1,0,0,0,1,0,0,0,1,'','','',7,0,0,0,0),(115,'公众号设置','configWechat','',2,4,1,0,0,0,1,0,0,0,1,'','','',8,0,0,0,0),(116,'腾讯云设置','configTencent','',2,4,1,0,0,0,1,0,0,0,1,'','','',9,0,0,0,0),(117,'七牛云设置','configQiniu','',2,4,1,0,0,0,1,0,0,0,1,'','','',10,0,0,0,0),(118,'登录设置','configLogin','',2,4,1,0,0,0,1,0,0,0,1,'','','',11,0,0,0,0),(150,'单位管理','unit','',2,5,1,0,0,0,1,0,0,0,1,'','','',1,0,0,0,0),(151,'币种管理','currency','',2,5,1,0,0,0,1,0,0,0,1,'','','',2,0,0,0,0),(152,'城市管理','city','',2,5,1,0,0,0,1,0,0,0,1,'','','',3,0,0,0,0),(153,'银行管理','bank','',2,5,1,0,0,0,1,0,0,0,1,'','','',4,0,0,0,0),(154,'快递管理','express','',2,5,1,0,0,0,1,0,0,0,1,'','','',5,0,0,0,0),(155,'文档类型','docment','',2,5,1,0,0,0,1,0,0,0,1,'','','',6,0,0,0,0),(180,'用户管理','user','',2,6,1,0,0,0,1,0,0,0,1,'','','',1,0,0,0,0),(200,'供应商管理','supplier','',2,7,1,0,0,0,1,0,0,0,1,'','','',1,0,0,0,0),(201,'供应商类别','supplierCate','',2,7,1,0,0,0,1,0,0,0,1,'','','',1,0,0,0,0),(210,'代理商管理','angle','',2,8,1,0,0,0,1,0,0,0,1,'','','',1,0,0,0,0),(211,'代理商类别','angleCate','',2,8,1,0,0,0,1,0,0,0,1,'','','',1,0,0,0,0),(220,'客户管理','customer','',2,9,1,0,0,0,1,0,0,0,1,'','','',1,0,0,0,0),(221,'客户类别','customerCate','',2,9,1,0,0,0,1,0,0,0,1,'','','',1,0,0,0,0);
/*!40000 ALTER TABLE `luck_module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_notice`
--

DROP TABLE IF EXISTS `luck_notice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_notice` (
  `ID` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Title` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `Content` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '公告内容',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `CreateIP` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '创建IP',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  `IsDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除',
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='公告';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_notice`
--

LOCK TABLES `luck_notice` WRITE;
/*!40000 ALTER TABLE `luck_notice` DISABLE KEYS */;
/*!40000 ALTER TABLE `luck_notice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_order`
--

DROP TABLE IF EXISTS `luck_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_order` (
  `ID` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `CategoryID` int NOT NULL DEFAULT '0' COMMENT '类别',
  `IssuerID` int NOT NULL DEFAULT '0' COMMENT '发行方',
  `CreatorID` int NOT NULL DEFAULT '0' COMMENT '创作者',
  `CollectionID` int NOT NULL DEFAULT '0' COMMENT '系列集',
  `IsBlind` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否盲盒',
  `GoodsID` int NOT NULL DEFAULT '0' COMMENT '商品ID',
  `StockCode` int NOT NULL DEFAULT '0' COMMENT '库存编号',
  `OrderType` tinyint(1) NOT NULL DEFAULT '0' COMMENT '订单类型',
  `OrderCode` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '订单编号',
  `UserID` int NOT NULL DEFAULT '0' COMMENT '下单人',
  `Mobile` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '手机号码',
  `RealName` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '真实姓名',
  `Idcard` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '身份证号',
  `OpenID` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'OpenID',
  `TotalCount` int NOT NULL DEFAULT '0' COMMENT '总数量',
  `TotalFee` int NOT NULL DEFAULT '0' COMMENT '总金额',
  `Payment` int NOT NULL DEFAULT '0' COMMENT '已支付',
  `Receivable` int NOT NULL DEFAULT '0' COMMENT '未支付',
  `IsBill` tinyint(1) NOT NULL DEFAULT '0' COMMENT '发票需求',
  `Platform` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '支付平台',
  `PayType` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '支付方式',
  `PlatformOrder` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '支付订单号',
  `PayTime` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '支付时间',
  `PayStatus` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '支付状态',
  `DeliveryType` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '送货方式',
  `IsConfirm` tinyint(1) NOT NULL DEFAULT '0' COMMENT '需要确认',
  `UserAddressID` int NOT NULL DEFAULT '0' COMMENT '邮寄地址',
  `ExpressID` int NOT NULL DEFAULT '0' COMMENT '物流公司',
  `ExpressCode` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '物流单号',
  `Remark` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  `OrderToken` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Token',
  `OrderHash` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '链地址',
  `Goods` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '商品列表',
  `ExpireTime` int NOT NULL DEFAULT '0' COMMENT '超时时间',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `CreateIP` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '创建IP',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  `DeleteTime` int NOT NULL DEFAULT '0' COMMENT '删除时间',
  `LockedTime` int NOT NULL DEFAULT '0' COMMENT '锁定时间',
  `LockedReason` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '锁定原因',
  `UnLockedTime` int NOT NULL DEFAULT '0' COMMENT '解锁时间',
  `UnLockedReason` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '解锁原因',
  `Status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `State` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'State',
  PRIMARY KEY (`ID`) USING BTREE,
  KEY `idx_order_code` (`OrderCode`) USING BTREE,
  KEY `idx_order_type` (`OrderType`) USING BTREE,
  KEY `idx_order_cate_id` (`CategoryID`) USING BTREE,
  KEY `idx_order_issuer_id` (`IssuerID`) USING BTREE,
  KEY `idx_order_creator_id` (`CreatorID`) USING BTREE,
  KEY `idx_order_collection_id` (`CollectionID`) USING BTREE,
  KEY `idx_order_goods_id` (`GoodsID`) USING BTREE,
  KEY `idx_order_user_id` (`UserID`) USING BTREE,
  KEY `idx_order_user_mobile` (`Mobile`) USING BTREE,
  KEY `idx_order_user_idcard` (`Idcard`) USING BTREE,
  KEY `idx_order_platform` (`Platform`) USING BTREE,
  KEY `idx_order_paytype` (`PayType`) USING BTREE,
  KEY `idx_order_status` (`Status`) USING BTREE,
  KEY `idx_order_state` (`State`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='订单';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_order`
--

LOCK TABLES `luck_order` WRITE;
/*!40000 ALTER TABLE `luck_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `luck_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_order_detail`
--

DROP TABLE IF EXISTS `luck_order_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_order_detail` (
  `ID` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `CategoryID` int NOT NULL DEFAULT '0' COMMENT '类别',
  `IssuerID` int NOT NULL DEFAULT '0' COMMENT '发行方',
  `CreatorID` int NOT NULL DEFAULT '0' COMMENT '创作者',
  `CollectionID` int NOT NULL DEFAULT '0' COMMENT '系列集',
  `OrderType` tinyint(1) NOT NULL DEFAULT '0' COMMENT '订单类型',
  `OrderCode` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '订单编号',
  `UserID` int NOT NULL DEFAULT '0' COMMENT '用户',
  `Mobile` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '手机号码',
  `RealName` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '姓名',
  `Idcard` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '身份证号',
  `GoodsID` int NOT NULL DEFAULT '0' COMMENT '商品',
  `StockCode` int NOT NULL DEFAULT '0' COMMENT '库存编号',
  `SpecID` int NOT NULL DEFAULT '0' COMMENT '商品规格',
  `SpecTitle` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '规格标题',
  `SpecCode` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '规格编号',
  `Quantity` int NOT NULL DEFAULT '0' COMMENT '数量',
  `Price` int NOT NULL DEFAULT '0' COMMENT '单价',
  `Amount` int NOT NULL DEFAULT '0' COMMENT '金额',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  `ExpireTime` int NOT NULL DEFAULT '0' COMMENT '过期时间',
  `State` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`ID`) USING BTREE,
  KEY `idx_order_detail_code` (`OrderCode`) USING BTREE,
  KEY `idx_order_detail_type` (`OrderType`) USING BTREE,
  KEY `idx_order_detail_cate_id` (`CategoryID`) USING BTREE,
  KEY `idx_order_detail_issuer_id` (`IssuerID`) USING BTREE,
  KEY `idx_order_detail_creator_id` (`CreatorID`) USING BTREE,
  KEY `idx_order_detail_collection_id` (`CollectionID`) USING BTREE,
  KEY `idx_order_detail_goods_id` (`GoodsID`) USING BTREE,
  KEY `idx_order_detail_user_id` (`UserID`) USING BTREE,
  KEY `idx_order_detail_user_mobile` (`Mobile`) USING BTREE,
  KEY `idx_order_detail_user_idcard` (`Idcard`) USING BTREE,
  KEY `idx_order_detail_state` (`State`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='订单详情';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_order_detail`
--

LOCK TABLES `luck_order_detail` WRITE;
/*!40000 ALTER TABLE `luck_order_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `luck_order_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_poster`
--

DROP TABLE IF EXISTS `luck_poster`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_poster` (
  `ID` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Title` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `Pic` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '背景图',
  `Url` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '链接地址',
  `Width` int NOT NULL DEFAULT '0' COMMENT '二维码宽度',
  `Height` int NOT NULL DEFAULT '0' COMMENT '二维码高度',
  `Axisx` int NOT NULL DEFAULT '0' COMMENT '二维码X轴',
  `Axisy` int NOT NULL DEFAULT '0' COMMENT '二维码Y轴',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `CreateIP` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '创建IP',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  `IsDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除',
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='海报';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_poster`
--

LOCK TABLES `luck_poster` WRITE;
/*!40000 ALTER TABLE `luck_poster` DISABLE KEYS */;
/*!40000 ALTER TABLE `luck_poster` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_record_sign`
--

DROP TABLE IF EXISTS `luck_record_sign`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_record_sign` (
  `ID` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `UserID` int NOT NULL DEFAULT '0' COMMENT '用户',
  `SendScore` int NOT NULL DEFAULT '0' COMMENT '赠送积分',
  `Visitorid` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'visitorid',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '签到时间',
  `CreateIP` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '签到IP',
  PRIMARY KEY (`ID`) USING BTREE,
  KEY `idx_record_sign_uid` (`UserID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='签到';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_record_sign`
--

LOCK TABLES `luck_record_sign` WRITE;
/*!40000 ALTER TABLE `luck_record_sign` DISABLE KEYS */;
/*!40000 ALTER TABLE `luck_record_sign` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_record_sms`
--

DROP TABLE IF EXISTS `luck_record_sms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_record_sms` (
  `ID` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `UserID` int NOT NULL DEFAULT '0' COMMENT '用户',
  `SmsType` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '发送类型',
  `TemplateID` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '模板id',
  `Mobile` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '手机号码',
  `Smscode` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '验证码',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `CreateIP` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '创建IP',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  `ExpireTime` int NOT NULL DEFAULT '0' COMMENT '过期时间',
  `State` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `IsDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除',
  PRIMARY KEY (`ID`) USING BTREE,
  KEY `idx_record_sms_uid` (`UserID`) USING BTREE,
  KEY `idx_record_sms_mobile` (`Mobile`) USING BTREE,
  KEY `idx_record_sms_type` (`SmsType`) USING BTREE,
  KEY `idx_record_sms_template` (`TemplateID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='短信记录';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_record_sms`
--

LOCK TABLES `luck_record_sms` WRITE;
/*!40000 ALTER TABLE `luck_record_sms` DISABLE KEYS */;
/*!40000 ALTER TABLE `luck_record_sms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_role`
--

DROP TABLE IF EXISTS `luck_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_role` (
  `ID` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Title` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '角色名称',
  `Sign` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标识',
  `Pic` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '图标',
  `Level` int NOT NULL DEFAULT '1' COMMENT '级别',
  `PID` int NOT NULL DEFAULT '0' COMMENT '父级',
  `IsDefault` tinyint(1) NOT NULL DEFAULT '0' COMMENT '默认',
  `IsAllowLogin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '允许登录',
  `IsAdmin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '管理员',
  `Number` int NOT NULL DEFAULT '0' COMMENT '子数目',
  `Sort` int NOT NULL DEFAULT '1' COMMENT '排序',
  `IsDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  `DeleteTime` int NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`ID`) USING BTREE,
  KEY `idx_role_pid` (`PID`) USING BTREE,
  KEY `idx_role_level` (`Level`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='角色';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_role`
--

LOCK TABLES `luck_role` WRITE;
/*!40000 ALTER TABLE `luck_role` DISABLE KEYS */;
INSERT INTO `luck_role` VALUES (1,'超级管理员组','857bf09113be0c95de9b44f24ba072c1','',1,0,0,1,0,1,1,0,0,0,0),(2,'管理员组','cbf5c75dbaf835eb3a123b4322336512','',1,0,0,1,0,2,2,0,0,0,0),(3,'接口组','d35151d886ed16c8fb97fc6a16e4ec44','',1,0,0,1,0,1,3,0,0,0,0),(4,'企业组','a3e51b6596a15cbcaeb6ae17703b9b35','',1,0,0,1,0,9,4,0,0,0,0),(5,'会员组','43812db925f4cdee6dc162090b6bec5d','',1,0,0,1,0,6,5,0,0,0,0),(6,'超级管理员','e66b6fe74fc7e7f0519aeb4872e9d7be','',2,1,0,1,0,0,1,0,0,0,0),(7,'超级管理员','3ef969e295dece53ea785cc8d049f047','',2,2,0,1,0,0,1,0,0,0,0),(8,'管理员','44369a7c6c130a96eb71f277f74d10e9','',2,2,0,1,0,0,2,0,0,0,0),(9,'API','b729295370d5ee9382672cad203fd68d','',2,3,0,1,0,0,1,0,0,0,0),(10,'总经理','e23f12f60cd8777a923e51bd3af48e64','',2,4,0,0,0,0,1,0,0,0,0),(11,'总助','ac4ff0526816a93f49c0a5c6b579ada5','',2,4,0,0,0,0,2,0,0,0,0),(12,'技术','b2f1321ea3a7148d2eea7053b3ac0e5c','',2,4,0,0,0,0,3,0,0,0,0),(13,'项目经理','36f50414ec9bf9bb02e796740a2b033a','',2,4,0,0,0,0,4,0,0,0,0),(14,'销售经理','f7dcf8b6530294f19625dcf3b0241731','',2,4,0,0,0,0,5,0,0,0,0),(15,'销售员','c329bf2f7ad55843947678dc1bf14cd5','',2,4,0,0,0,0,6,0,0,0,0),(16,'业务经理','7925aaeeb4414c0d09f1974bb0f09103','',2,4,0,0,0,0,7,0,0,0,0),(17,'业务员','579e33dccf742086c0f7121f915c7dfb','',2,4,0,0,0,0,8,0,0,0,0),(18,'客服','31e2965444fc61347c4e766e3cab0355','',2,4,0,0,0,0,9,0,0,0,0),(19,'VIP0','37c392610b9c031eeeb9ac7bf6f09d2d','',2,5,1,1,0,0,1,0,0,0,0),(20,'VIP1','c58a2231cbed2f75e507790de390a599','',2,5,0,0,0,0,2,0,0,0,0),(21,'VIP2','715fc037c5806c4a9675e2fb30bd52cf','',2,5,0,0,0,0,3,0,0,0,0),(22,'VIP3','ac1b98e0fe9238c59a255661aec91690','',2,5,0,0,0,0,4,0,0,0,0),(23,'VIP4','c00bc1d541d5657d7a5b1276da1ab209','',2,5,0,0,0,0,5,0,0,0,0),(24,'VIP5','9e2ca05ea0284c580b7f1c39f7b50267','',2,5,0,0,0,0,6,0,0,0,0),(25,'项目中心','58dddf06729e63fd1a2b0f1219a07557','',2,2,0,0,0,0,1,0,1658732377,0,0);
/*!40000 ALTER TABLE `luck_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_tabbar`
--

DROP TABLE IF EXISTS `luck_tabbar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_tabbar` (
  `ID` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Title` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `Pic` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '图片',
  `ActivePic` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '激活图片',
  `LinkType` tinyint(1) NOT NULL DEFAULT '0' COMMENT '链接方式',
  `AppId` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'AppId',
  `LinkUrl` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '链接地址',
  `IsValid` tinyint(1) NOT NULL DEFAULT '1' COMMENT '有效',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  `DeleteTime` int NOT NULL DEFAULT '0' COMMENT '删除时间',
  `IsDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除',
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='导航栏';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_tabbar`
--

LOCK TABLES `luck_tabbar` WRITE;
/*!40000 ALTER TABLE `luck_tabbar` DISABLE KEYS */;
/*!40000 ALTER TABLE `luck_tabbar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_unit`
--

DROP TABLE IF EXISTS `luck_unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_unit` (
  `ID` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `UnitName` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '单位名称',
  `Symbol` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标识符',
  `IsDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  `DeleteTime` int NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='单位';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_unit`
--

LOCK TABLES `luck_unit` WRITE;
/*!40000 ALTER TABLE `luck_unit` DISABLE KEYS */;
INSERT INTO `luck_unit` VALUES (1,'张','pic',0,1657999264,1657999264,0),(2,'asdfasd','d',1,1666666989,1666666989,1666702558),(3,'asdf','asdf',1,1666702824,1666702824,1666702831);
/*!40000 ALTER TABLE `luck_unit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_user`
--

DROP TABLE IF EXISTS `luck_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_user` (
  `ID` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Uuid` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'uuid',
  `AccountID` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '账号ID',
  `Token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'token',
  `UserName` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `NickName` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '昵称',
  `RealName` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '真实姓名',
  `Face` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '头像',
  `SandeID` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '杉德ID',
  `SandeBalance` int NOT NULL DEFAULT '0' COMMENT '杉德余额',
  `ChainAddress` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '链地址',
  `QQ` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Qq',
  `OpenidQq` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'openid_qq',
  `OpenidWechat` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'openidWechat',
  `UnionidWechat` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'unionidWechat',
  `OpenidWeibo` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'openidWeibo',
  `OpenidAlipay` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'openidAlipay',
  `OpenidTaobao` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'openidTaobao',
  `Authentication` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '密码',
  `PayPassWord` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '支付密码',
  `SecurityPassWord` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '安全密码',
  `Email` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '邮箱',
  `IsValidEmail` tinyint(1) NOT NULL DEFAULT '0' COMMENT '邮箱验证',
  `Mobile` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '手机号码',
  `IsValidMobile` tinyint(1) NOT NULL DEFAULT '0' COMMENT '手机验证',
  `Gender` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别',
  `Idcard` varchar(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '身份证号',
  `Birth` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '出生日期',
  `IdcardFont` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '身份证正面',
  `IdcardBack` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '身份证背面',
  `NativePID` int NOT NULL DEFAULT '0' COMMENT '籍贯省份',
  `NativeCID` int NOT NULL DEFAULT '0' COMMENT '籍贯城市',
  `NativeDID` int NOT NULL DEFAULT '0' COMMENT '籍贯区县',
  `NativeAdddress` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '籍贯地址',
  `Hobby` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '兴趣爱好',
  `ParentID` int NOT NULL DEFAULT '0' COMMENT '上级',
  `DirectShare` int NOT NULL DEFAULT '0' COMMENT '直推人数',
  `TotalShare` int NOT NULL DEFAULT '0' COMMENT '分享总数',
  `RankLevel` int NOT NULL DEFAULT '0' COMMENT '层级',
  `SubRank` int NOT NULL DEFAULT '0' COMMENT '下层级别数',
  `RoleID` int NOT NULL DEFAULT '0' COMMENT '角色',
  `IsAuth` tinyint(1) NOT NULL DEFAULT '0' COMMENT '认证',
  `AuthTime` int NOT NULL DEFAULT '0',
  `AuthCode` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '认证代码',
  `TotalScore` int NOT NULL DEFAULT '0' COMMENT '总积分',
  `Score` int NOT NULL DEFAULT '0' COMMENT '可用积分',
  `TotalCoin` int NOT NULL DEFAULT '0' COMMENT '总平台币',
  `Coin` int NOT NULL DEFAULT '0' COMMENT '可用平台币',
  `TotalBalance` int NOT NULL DEFAULT '0' COMMENT '总余额',
  `Balance` int NOT NULL DEFAULT '0' COMMENT '可用余额',
  `BuyGoodsCount` int NOT NULL DEFAULT '0' COMMENT '购买藏品数',
  `AirdropGoodsCount` int NOT NULL DEFAULT '0' COMMENT '空投藏品数',
  `TransferGoodsCount` int NOT NULL DEFAULT '0' COMMENT '转赠藏品数',
  `ComposeGoodsCount` int NOT NULL DEFAULT '0' COMMENT '合成藏品数',
  `BuyBlindCount` int NOT NULL DEFAULT '0' COMMENT '购买盲盒数',
  `AirdropBlindCount` int NOT NULL DEFAULT '0' COMMENT '空投盲盒数',
  `TransferBlindCount` int NOT NULL DEFAULT '0' COMMENT '转赠盲盒数',
  `OpenBlindCount` int NOT NULL DEFAULT '0' COMMENT '已开盲盒数',
  `BuyTotalCount` int NOT NULL DEFAULT '0' COMMENT '购买总数',
  `AirdropTotalCount` int NOT NULL DEFAULT '0' COMMENT '空投总数',
  `TransferTotalCount` int NOT NULL DEFAULT '0' COMMENT '转赠总数',
  `IsTransferTotalCount` int NOT NULL DEFAULT '0' COMMENT '已转赠总数',
  `BuyGoodsNumber` int NOT NULL DEFAULT '0' COMMENT '市场购买藏品数',
  `BuyBlindNumber` int NOT NULL DEFAULT '0' COMMENT '市场购买盲盒数',
  `BuyTotalNumber` int NOT NULL DEFAULT '0' COMMENT '市场购买总数',
  `OrderCount` int NOT NULL DEFAULT '0' COMMENT '订单总数',
  `OrderNumber` int NOT NULL DEFAULT '0' COMMENT '市场订单总数',
  `OrderTotal` int NOT NULL DEFAULT '0' COMMENT '购买订单总数',
  `OrderTotalAmount` int NOT NULL DEFAULT '0' COMMENT '支付总额',
  `InviteCode` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '邀请码',
  `Invite` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '邀请者',
  `Regip` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '注册IP',
  `IpAddress` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'IP地址',
  `RegOs` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '操作系统',
  `RegOsVersion` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '系统版本',
  `RegAgent` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '注册引擎',
  `RegAgentVersion` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '引擎版本',
  `RegDevice` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '设备名称',
  `IsMobileReg` tinyint(1) NOT NULL DEFAULT '0' COMMENT '移动端注册',
  `RegSource` int NOT NULL DEFAULT '0' COMMENT '注册来源',
  `Visitorid` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'visitorid',
  `LastLoginTime` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '最后登录时间',
  `LastLoginIp` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '最后登录IP',
  `LoginCount` int NOT NULL DEFAULT '0' COMMENT '登录次数',
  `IsOnline` tinyint(1) NOT NULL DEFAULT '0' COMMENT '当前在线',
  `OnlineTime` bigint NOT NULL DEFAULT '0' COMMENT '在线总时长',
  `IsValid` tinyint(1) NOT NULL DEFAULT '0' COMMENT '激活',
  `IsLocked` tinyint(1) NOT NULL DEFAULT '0' COMMENT '锁定',
  `LockedTime` int NOT NULL DEFAULT '0' COMMENT '锁定时长',
  `IsDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  `DeleteTime` int NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`ID`) USING BTREE,
  UNIQUE KEY `idx_uid` (`AccountID`) USING BTREE,
  KEY `idx_email` (`Email`) USING BTREE,
  KEY `idx_mobile` (`Mobile`) USING BTREE,
  KEY `idx_username` (`UserName`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1001 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_user`
--

LOCK TABLES `luck_user` WRITE;
/*!40000 ALTER TABLE `luck_user` DISABLE KEYS */;
INSERT INTO `luck_user` VALUES (100,'2ba0995c-294a-f571-12f9-6d59430f2ff2','69850792','CXX9gzCVW7Ge0b6qOWONB2Xs08A','Root_admins','master','Root_admins','unkown.png','',0,'','','','','','','','','$2y$12$kdnPTWlBEJOVNZNU1vBnIeNF/IxHe6Bq28pL1rL3Gaxb1PaJfZ4Me','','','',0,'13988888888',0,0,'','1986-09-01','','',0,0,0,'','',0,0,0,0,0,6,1,0,'',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'994L9','','114.220.249.133','湖南省长沙市','','','','','',0,0,'f7ad96ac3c01fcfa0453f835aae47b04','','',0,0,0,1,0,0,0,1655445011,0,0),(101,'706a79ce-075e-fcf7-a67a-edce1d4bc798','25702783','6o9r9c7D5lvPZKn8SElAUgcDu7Q','admins','admins','admins','unkown.png','',0,'','','','','','','','','$2y$12$fgzo6BNQrJTKB8XzdmZM..CAzQuk1qe2tW.kzXSsntu9iePqCM75y','','','',0,'13900000000',0,0,'','1986-09-01','','',0,0,0,'','',0,0,0,0,0,7,1,0,'',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'UCA0F','','114.220.249.133','湖南省长沙市','','','','','',0,0,'f7ad96ac3c01fcfa0453f835aae47b04','','',0,0,0,1,0,0,0,1655445067,0,0),(102,'c19dfbb9-8a89-a481-b668-1314bcca62a0','30503760','9m6qZ3PZucJrcVNo3OAK3EjRToE','admin','admin','admin','unkown.png','',0,'','','','','','','','','$2y$12$1NyfOfZoqLAuGnqDwCUvG.PQVrTNldZalnxoy9G.8rW/VsEMYXMXO','','','',0,'13999999999',0,0,'','1986-09-01','','',0,0,0,'','',0,0,0,0,0,8,1,0,'',0,0,0,0,200,200,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'C36F9','','114.220.249.133','湖南省长沙市','','','','','',0,0,'f7ad96ac3c01fcfa0453f835aae47b04','','',0,0,0,1,0,0,0,1655445117,0,0),(103,'f4311286-5929-5d0c-061f-777fe7a8c742','83176150','yFS0RH5GX296IonQhoBUEkPy3Rw','developer','developer','developer','unkown.png','',0,'','','','','','','','','$2y$12$qbjUd62VN1VKSzIm8cb5d.FM593vDLLtZu1yha94pdD5xRFbf0dfq','','','',0,'13897989798',0,0,'','1986-09-01','','',0,0,0,'','',0,0,0,0,0,9,1,0,'',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'U277C','','119.39.101.32','湖南省长沙市','','','','','',0,0,'','','',0,0,0,1,0,0,0,1656054279,0,0);
/*!40000 ALTER TABLE `luck_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luck_user_token`
--

DROP TABLE IF EXISTS `luck_user_token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `luck_user_token` (
  `ID` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `UserID` bigint NOT NULL DEFAULT '0' COMMENT '用户',
  `Token` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Token',
  `CreateTime` int NOT NULL DEFAULT '0' COMMENT '创建时间',
  `CreateIP` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '创建IP',
  `UpdateTime` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  `ExpireTime` int NOT NULL DEFAULT '0' COMMENT '过期时间',
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户Token';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luck_user_token`
--

LOCK TABLES `luck_user_token` WRITE;
/*!40000 ALTER TABLE `luck_user_token` DISABLE KEYS */;
/*!40000 ALTER TABLE `luck_user_token` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-10-27 21:01:47
