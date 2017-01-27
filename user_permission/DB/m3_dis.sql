/*
SQLyog Ultimate v9.63 
MySQL - 5.1.41 : Database - m3_dis
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`m3_dis` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `m3_dis`;

/*Table structure for table `a_com_reg` */

DROP TABLE IF EXISTS `a_com_reg`;

CREATE TABLE `a_com_reg` (
  `id` int(11) DEFAULT NULL,
  `com_id` varchar(40) NOT NULL,
  `current_id` varchar(40) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '0',
  `req_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `req_by` varchar(10) DEFAULT NULL,
  `app_on` timestamp NULL DEFAULT NULL,
  `app_by` varchar(10) DEFAULT NULL,
  `des` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`com_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `a_com_reg` */

/*Table structure for table `a_log_users` */

DROP TABLE IF EXISTS `a_log_users`;

CREATE TABLE `a_log_users` (
  `oc` smallint(5) unsigned NOT NULL,
  `last_login` int(11) DEFAULT NULL,
  `last_active` int(11) DEFAULT NULL,
  PRIMARY KEY (`oc`)
) ENGINE=MEMORY DEFAULT CHARSET=latin1;

/*Data for the table `a_log_users` */

/*Table structure for table `advance_pay_trance` */

DROP TABLE IF EXISTS `advance_pay_trance`;

CREATE TABLE `advance_pay_trance` (
  `id` bigint(20) DEFAULT NULL,
  `customer` varchar(20) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `dr_trance_code` varchar(25) DEFAULT NULL,
  `dr_trance_no` bigint(20) DEFAULT NULL,
  `dr_trance_amount` decimal(10,2) DEFAULT NULL,
  `cr_trance_code` varchar(25) DEFAULT NULL,
  `cr_trance_no` bigint(20) DEFAULT NULL,
  `cr_amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `advance_pay_trance` */

/*Table structure for table `bank_acc` */

DROP TABLE IF EXISTS `bank_acc`;

CREATE TABLE `bank_acc` (
  `accCode` varchar(15) DEFAULT NULL,
  `schoolBranchId` varchar(10) DEFAULT NULL,
  `bc` varchar(10) DEFAULT NULL,
  `oc` varchar(10) DEFAULT NULL,
  `actionDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `bank_acc` */

/*Table structure for table `bank_details` */

DROP TABLE IF EXISTS `bank_details`;

CREATE TABLE `bank_details` (
  `nNo` bigint(20) NOT NULL,
  `accountNo` varchar(15) NOT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `dDate` date DEFAULT NULL,
  `slipNo` varchar(10) DEFAULT NULL,
  `oc` varchar(10) DEFAULT NULL,
  `bc` varchar(10) NOT NULL,
  `actionDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `FK_cheque` (`nNo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `bank_details` */

/*Table structure for table `bank_entry` */

DROP TABLE IF EXISTS `bank_entry`;

CREATE TABLE `bank_entry` (
  `bNo` int(4) DEFAULT NULL,
  `dDate` date DEFAULT NULL,
  `Description` varchar(50) DEFAULT NULL,
  `Amount` decimal(10,2) DEFAULT NULL,
  `DrAccId` varchar(10) DEFAULT NULL,
  `CrAccId` varchar(10) DEFAULT NULL,
  `Type` varchar(15) DEFAULT NULL,
  `bc` varchar(10) DEFAULT NULL,
  `oc` varchar(10) DEFAULT NULL,
  `actionDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `entry_code` varchar(10) DEFAULT NULL,
  `narration` varchar(150) DEFAULT NULL,
  `refno` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `bank_entry` */

/*Table structure for table `branches` */

DROP TABLE IF EXISTS `branches`;

CREATE TABLE `branches` (
  `cCode` varchar(5) NOT NULL,
  `branchName` varchar(200) NOT NULL,
  `bAddress` varchar(200) DEFAULT NULL,
  `TelNo` varchar(50) DEFAULT NULL,
  `FaxNo` varchar(50) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `br_id` varchar(3) NOT NULL,
  PRIMARY KEY (`cCode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `branches` */

insert  into `branches`(`cCode`,`branchName`,`bAddress`,`TelNo`,`FaxNo`,`Email`,`br_id`) values ('001','MAIN BRANCH','','','','','K');

/*Table structure for table `cheque_history` */

DROP TABLE IF EXISTS `cheque_history`;

CREATE TABLE `cheque_history` (
  `dDate` date DEFAULT NULL,
  `transType` varchar(20) DEFAULT NULL,
  `transNo` varchar(15) DEFAULT NULL,
  `drAmount` decimal(12,2) DEFAULT NULL,
  `crAmount` decimal(12,2) DEFAULT NULL,
  `bank` varchar(30) DEFAULT NULL,
  `branch` varchar(30) DEFAULT NULL,
  `chequeNo` varchar(15) DEFAULT NULL,
  `accountNo` varchar(15) DEFAULT NULL,
  KEY `FK_cheque_history` (`chequeNo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cheque_history` */

/*Table structure for table `com_auth` */

DROP TABLE IF EXISTS `com_auth`;

CREATE TABLE `com_auth` (
  `rec_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT '',
  `bc` varchar(5) DEFAULT '',
  `com_id` varchar(255) DEFAULT '',
  `is_auth` tinyint(3) unsigned DEFAULT '0',
  PRIMARY KEY (`rec_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

/*Data for the table `com_auth` */

insert  into `com_auth`(`rec_id`,`description`,`bc`,`com_id`,`is_auth`) values (29,'PUTTALAM KUG','001','njlvri1d762qb01bj93t33t360',1),(30,'hirantha','001','in9pem3k5cgonep3t3bdfe6gm4',1),(31,'nadeeeeee','001','edqogdkagdk6hob5iso6biqti7',1),(32,'nadeeka','001','edqogdkagdk6hob5iso6biqti7',1),(33,'Mahanama','001','nhpj51tgtnc8m178b258g2iqp6',1),(34,'nadeeka','001','g5l123raamokrcmersheohbf61',1),(35,'jjjj','001','g5l123raamokrcmersheohbf61',1),(36,'nadeeka','001','nc8hhig6i605d040i2o4k6see1',1),(37,'5555','001','4d3944p3jkun9jk69iqsedbt81',1),(38,'888','001','4d3944p3jkun9jk69iqsedbt81',1),(39,'nadeeka','001','p9qm95n5ggju93e2iiqm242sv7',1),(40,'nnnnn','001','p9qm95n5ggju93e2iiqm242sv7',1),(41,'test','001','cmce7jm66bqn49p2i1n6in1l55',1);

/*Table structure for table `db` */

DROP TABLE IF EXISTS `db`;

CREATE TABLE `db` (
  `code` int(2) DEFAULT NULL,
  `db_name` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `db` */

insert  into `db`(`code`,`db_name`) values (1,'m3_dis'),(2,'mthreeacc');

/*Table structure for table `m_accounts` */

DROP TABLE IF EXISTS `m_accounts`;

CREATE TABLE `m_accounts` (
  `type_Code` varchar(10) DEFAULT NULL,
  `code` varchar(10) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `control_Acc` varchar(10) DEFAULT NULL,
  `is_Controll_acc` tinyint(1) DEFAULT '0',
  `is_Bank_acc` tinyint(1) DEFAULT '0',
  `category` varchar(10) DEFAULT NULL,
  `order_no` tinyint(4) DEFAULT NULL,
  `Display_Text` varchar(100) DEFAULT NULL,
  `oc` varchar(50) DEFAULT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`code`),
  KEY `FK_m_accounts` (`type_Code`),
  KEY `FK_m_accounts2` (`category`),
  CONSTRAINT `FK_m_accounts` FOREIGN KEY (`type_Code`) REFERENCES `m_accounts_type` (`code`),
  CONSTRAINT `FK_m_accounts2` FOREIGN KEY (`category`) REFERENCES `m_accounts_category` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `m_accounts` */

/*Table structure for table `m_accounts_category` */

DROP TABLE IF EXISTS `m_accounts_category`;

CREATE TABLE `m_accounts_category` (
  `code` varchar(10) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `action_Date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `oc` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_accounts_category` */

/*Table structure for table `m_accounts_type` */

DROP TABLE IF EXISTS `m_accounts_type`;

CREATE TABLE `m_accounts_type` (
  `code` varchar(10) NOT NULL,
  `heading` varchar(50) NOT NULL,
  `report` smallint(6) NOT NULL,
  `rtype` varchar(50) DEFAULT NULL,
  `action_Date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_accounts_type` */

/*Table structure for table `m_age_analyze_2` */

DROP TABLE IF EXISTS `m_age_analyze_2`;

CREATE TABLE `m_age_analyze_2` (
  `description` varchar(255) DEFAULT NULL,
  `range` smallint(6) DEFAULT NULL,
  `type` tinyint(4) DEFAULT '1',
  `oc` smallint(6) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_age_analyze_2` */

insert  into `m_age_analyze_2`(`description`,`range`,`type`,`oc`,`date`) values ('Below 90',3,2,1,'2013-01-10 14:00:26'),('90 To 100',4,2,1,'2013-01-10 14:00:28'),('100 To 120',5,2,1,'2013-01-10 14:00:31'),('Over 120',6,2,1,'2013-01-10 14:00:35');

/*Table structure for table `m_age_analyze_setup` */

DROP TABLE IF EXISTS `m_age_analyze_setup`;

CREATE TABLE `m_age_analyze_setup` (
  `description` varchar(255) DEFAULT NULL,
  `range` smallint(6) DEFAULT NULL,
  `type` tinyint(4) DEFAULT '1',
  `oc` smallint(6) DEFAULT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_age_analyze_setup` */

insert  into `m_age_analyze_setup`(`description`,`range`,`type`,`oc`,`action_date`) values ('Below 30',0,1,1,'2013-11-15 16:25:40'),('30 To 60',30,1,1,'2013-11-15 16:25:40'),('60 To 90',60,1,1,'2013-11-15 16:25:40'),('Over 90',90,1,1,'2013-11-15 16:25:40');

/*Table structure for table `m_agency` */

DROP TABLE IF EXISTS `m_agency`;

CREATE TABLE `m_agency` (
  `code` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address01` varchar(255) NOT NULL,
  `address02` varchar(255) NOT NULL,
  `address03` varchar(255) NOT NULL,
  `phone01` varchar(10) NOT NULL,
  `phone02` varchar(10) NOT NULL,
  `phone03` varchar(10) NOT NULL,
  `agent` varchar(10) NOT NULL,
  `area` varchar(10) NOT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`code`),
  KEY `agent_code` (`agent`),
  KEY `sales_man_code` (`area`),
  CONSTRAINT `m_agency_ibfk_1` FOREIGN KEY (`agent`) REFERENCES `m_agent` (`code`),
  CONSTRAINT `m_agency_ibfk_2` FOREIGN KEY (`area`) REFERENCES `m_area` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_agency` */

/*Table structure for table `m_agent` */

DROP TABLE IF EXISTS `m_agent`;

CREATE TABLE `m_agent` (
  `code` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `address01` varchar(255) NOT NULL,
  `address02` varchar(255) NOT NULL,
  `address03` varchar(255) NOT NULL,
  `phone01` varchar(10) NOT NULL,
  `phone02` varchar(10) NOT NULL,
  `phone03` varchar(10) NOT NULL,
  `nic` varchar(20) NOT NULL,
  `credit_limit` decimal(10,2) NOT NULL,
  `credit_days` int(11) NOT NULL,
  `br_no` varchar(10) NOT NULL,
  `bank_guarantee_code` varchar(20) NOT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_agent` */

/*Table structure for table `m_area` */

DROP TABLE IF EXISTS `m_area`;

CREATE TABLE `m_area` (
  `code` varchar(10) NOT NULL,
  `description` varchar(255) NOT NULL,
  `region` varchar(10) NOT NULL,
  `sales_ref` varchar(10) DEFAULT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`code`),
  KEY `region` (`region`),
  KEY `sales_ref` (`sales_ref`),
  CONSTRAINT `m_area_ibfk_1` FOREIGN KEY (`region`) REFERENCES `m_sub_regon` (`code`),
  CONSTRAINT `m_area_ibfk_2` FOREIGN KEY (`sales_ref`) REFERENCES `m_sales_ref` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_area` */

insert  into `m_area`(`code`,`description`,`region`,`sales_ref`,`action_date`) values ('NWPKUTO','Kurunegala Town Area','KURU-TOWN','839335888V','2013-11-04 22:00:53');

/*Table structure for table `m_bank` */

DROP TABLE IF EXISTS `m_bank`;

CREATE TABLE `m_bank` (
  `bID` varchar(10) NOT NULL,
  `Description` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`bID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_bank` */

insert  into `m_bank`(`bID`,`Description`) values ('001','NSB');

/*Table structure for table `m_bank_branch` */

DROP TABLE IF EXISTS `m_bank_branch`;

CREATE TABLE `m_bank_branch` (
  `Bank` varchar(10) NOT NULL,
  `BranchID` varchar(10) NOT NULL,
  `Description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Bank`,`BranchID`),
  CONSTRAINT `FK_m_bank_branch` FOREIGN KEY (`Bank`) REFERENCES `m_bank` (`bID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_bank_branch` */

insert  into `m_bank_branch`(`Bank`,`BranchID`,`Description`) values ('7010','588','Peradeniya'),('7010','7010-001','Bank Of Ceylon - City Office'),('7010','7010-002','Bank Of Ceylon - Kandy'),('7010','7010-003','Bank Of Ceylon - Galle'),('7010','7010-004','Bank Of Ceylon - Pettah'),('7010','7010-005','Bank Of Ceylon - Jaffna'),('7010','7010-006','Bank Of Ceylon - Trincomalee'),('7010','7010-007','Bank Of Ceylon - Panadaura'),('7010','7010-009','Bank Of Ceylon - Kurunegala'),('7010','7010-010','Bank Of Ceylon - Savings Department'),('7010','7010-011','Bank Of Ceylon - Badulla'),('7010','7010-012','Bank Of Ceylon - Batticalioa'),('7010','7010-015','Bank Of Ceylon - Central Office'),('7010','7010-016','Bank Of Ceylon - Kalutara'),('7010','7010-018','Bank Of Ceylon - Negambo'),('7010','7010-020','Bank Of Ceylon - Chilaw'),('7010','7010-021','Bank Of Ceylon - Ampara'),('7010','7010-022','Bank Of Ceylon - Anuradhapura'),('7010','7010-023','Bank Of Ceylon - Wellawatte'),('7010','7010-024','Bank Of Ceylon - Matara'),('7010','7010-025','Bank Of Ceylon - Prince Street'),('7010','7010-026','Bank Of Ceylon - Main Street'),('7010','7010-027','Bank Of Ceylon - Kegalle'),('7010','7010-028','Bank Of Ceylon - Point Pedro'),('7010','7010-029','Bank Of Ceylon - Nuwara Eliya'),('7010','7010-030','Bank Of Ceylon - Katubedde'),('7010','7010-031','Bank Of Ceylon - Ratnapura'),('7010','7010-032','Bank Of Ceylon - Hulfsdrop'),('7010','7010-034','Bank Of Ceylon - Kollupitiya'),('7010','7010-035','Bank Of Ceylon - Haputale'),('7010','7010-037','Bank Of Ceylon - Bambalapitiya'),('7010','7010-038','Bank Of Ceylon - Borella'),('7010','7010-039','Bank Of Ceylon - Ja-Ela'),('7010','7010-040','Bank Of Ceylon - Hatton'),('7010','7010-041','Bank Of Ceylon - Maradana'),('7010','7010-042','Bank Of Ceylon - Peliyagoda'),('7010','7010-043','Bank Of Ceylon - Union Place'),('7010','7010-044','Bank Of Ceylon - Vavuniya'),('7010','7010-045','Bank Of Ceylon - Gampaha'),('7010','7010-046','Bank Of Ceylon - Mannar'),('7010','7010-047','Bank Of Ceylon - Ambalangoda'),('7010','7010-048','Bank Of Ceylon - Puttalam'),('7010','7010-049','Bank Of Ceylon - Nugegoda'),('7010','7010-050','Bank Of Ceylon - Nattandiya'),('7010','7010-051','Bank Of Ceylon - Dehiwela'),('7010','7010-052','Bank Of Ceylon - Kuliyapitiya'),('7010','7010-053','Bank Of Ceylon - Chunnakam'),('7010','7010-054','Bank Of Ceylon - Horana'),('7010','7010-055','Bank Of Ceylon - Maharagama'),('7010','7010-056','Bank Of Ceylon - Tangalle'),('7010','7010-057','Bank Of Ceylon - Eheliyagoda'),('7010','7010-058','Bank Of Ceylon - Beruwela'),('7010','7010-059','Bank Of Ceylon - Kadawatha'),('7010','7010-060','Bank Of Ceylon - Fifth City'),('7010','7010-061','Bank Of Ceylon - Idama - Moratuwa'),('7010','7010-063','Bank Of Ceylon - Kayts'),('7010','7010-068','Bank Of Ceylon - Matale'),('7010','7010-082','Bank Of Ceylon - Moneragala'),('7010','7010-083','Bank Of Ceylon - Polonnaruwa, New Town'),('7010','7010-085','Bank Of Ceylon - Hambantota'),('7010','7010-087','Bank Of Ceylon - International Division'),('7010','7010-088','Bank Of Ceylon - Mirigama'),('7010','7010-089','Bank Of Ceylon - Galle Bazzar'),('7010','7010-092','Bank Of Ceylon - Naula'),('7010','7010-093','Bank Of Ceylon - Kilinochchi'),('7010','7010-097','Bank Of Ceylon - Rajanganaya'),('7010','7010-098','Bank Of Ceylon - New Town Anuradhapura'),('7010','7010-099','Bank Of Ceylon - Primary Dealer Unit'),('7010','7010-100','Bank Of Ceylon - Oruwala'),('7010','7010-101','Bank Of Ceylon - Galaha'),('7010','7010-102','Bank Of Ceylon - Bentota'),('7010','7010-104','Bank Of Ceylon - Welpalla'),('7010','7010-118','Bank Of Ceylon - Mutur'),('7010','7010-122','Bank Of Ceylon - Galenbindunuwewa'),('7010','7010-127','Bank Of Ceylon - Padavi Parakramapura'),('7010','7010-135','Bank Of Ceylon - Imaduwa'),('7010','7010-139','Bank Of Ceylon - Weeraketiya'),('7010','7010-144','Bank Of Ceylon - Yatawatte'),('7010','7010-146','Bank Of Ceylon -'),('7010','7010-152','Bank Of Ceylon - Pemaduwa'),('7010','7010-157','Bank Of Ceylon - Tirappane'),('7010','7010-162','Bank Of Ceylon - Medawachchiya'),('7010','7010-167','Bank Of Ceylon - Rikillagaskada'),('7010','7010-172','Bank Of Ceylon - Kobeigane'),('7010','7010-183','Bank Of Ceylon - Sewagama'),('7010','7010-217','Bank Of Ceylon - Horowpothana'),('7010','7010-236','Bank Of Ceylon - Ipalogama'),('7010','7010-238','Bank Of Ceylon - Medagama'),('7010','7010-250','Bank Of Ceylon - Tawalama'),('7010','7010-257','Bank Of Ceylon - Mawathagama'),('7010','7010-260','Bank Of Ceylon - Diyatalawa'),('7010','7010-273','Bank Of Ceylon - Digana'),('7010','7010-281','Bank Of Ceylon - Manipay'),('7010','7010-293','Bank Of Ceylon - Dodangoda'),('7010','7010-298','Bank Of Ceylon - Urubokka'),('7010','7010-318','Bank Of Ceylon - Potuvil'),('7010','7010-320','Bank Of Ceylon - Ballakatuwa'),('7010','7010-322','Bank Of Ceylon - Tanamalwila'),('7010','7010-325','Bank Of Ceylon - Kuruwita'),('7010','7010-335','Bank Of Ceylon - Mihintale'),('7010','7010-337','Bank Of Ceylon - Pussellawa'),('7010','7010-340','Bank Of Ceylon - Wattegama'),('7010','7010-342','Bank Of Ceylon - Pambahinna'),('7010','7010-343','Bank Of Ceylon - Uva Paranagama'),('7010','7010-348','Bank Of Ceylon - Padiyatalawa'),('7010','7010-365','Bank Of Ceylon - Hasalaka'),('7010','7010-379','Bank Of Ceylon - Wariyapola'),('7010','7010-384','Bank Of Ceylon - Karametiya'),('7010','7010-401','Bank Of Ceylon - Ayagama'),('7010','7010-416','Bank Of Ceylon - Siyambalanduwa'),('7010','7010-421','Bank Of Ceylon - Seeduwa'),('7010','7010-425','Bank Of Ceylon - Pundaluoya'),('7010','7010-432','Bank Of Ceylon - Galewela'),('7010','7010-433','Bank Of Ceylon - Divulapitiya'),('7010','7010-434','Bank Of Ceylon - Wellawaya'),('7010','7010-440','Bank Of Ceylon - Sammanthurai'),('7010','7010-453','Bank Of Ceylon - Torrington Square'),('7010','7010-463','Bank Of Ceylon - Haldummulla'),('7010','7010-476','Bank Of Ceylon - Ettampitiya'),('7010','7010-477','Bank Of Ceylon - Yatiyantota'),('7010','7010-492','Bank Of Ceylon - Padiyapelella'),('7010','7010-494','Bank Of Ceylon - Andiambalama'),('7010','7010-497','Bank Of Ceylon - Dankotuwa'),('7010','7010-498','Bank Of Ceylon - Alawwa'),('7010','7010-500','Bank Of Ceylon - Jaffna Second Branch'),('7010','7010-501','Bank Of Ceylon - Chavakachcheri'),('7010','7010-502','Bank Of Ceylon - Kaduruwela'),('7010','7010-503','Bank Of Ceylon - Passara'),('7010','7010-504','Bank Of Ceylon - Devinuwara'),('7010','7010-505','Bank Of Ceylon - Wattala'),('7010','7010-506','Bank Of Ceylon - Maskeliya'),('7010','7010-507','Bank Of Ceylon - Kahawatte'),('7010','7010-508','Bank Of Ceylon - Wennappuwa'),('7010','7010-509','Bank Of Ceylon - Hingurana'),('7010','7010-510','Bank Of Ceylon - Kalmunai'),('7010','7010-511','Bank Of Ceylon - Mullaitivu'),('7010','7010-512','Bank Of Ceylon - Thimbirigasyaya'),('7010','7010-513','Bank Of Ceylon - Kurunegala Bazzar'),('7010','7010-514','Bank Of Ceylon - Galnewa'),('7010','7010-515','Bank Of Ceylon - Bandarawela'),('7010','7010-517','Bank Of Ceylon - Walasmulla'),('7010','7010-518','Bank Of Ceylon - Middeniya'),('7010','7010-521','Bank Of Ceylon - Hyde Park'),('7010','7010-522','Bank Of Ceylon - Batapola'),('7010','7010-524','Bank Of Ceylon - Geli Oya'),('7010','7010-525','Bank Of Ceylon - Baddegama'),('7010','7010-526','Bank Of Ceylon - Polgahawela'),('7010','7010-527','Bank Of Ceylon - Welisara'),('7010','7010-528','Bank Of Ceylon - Deniyaya'),('7010','7010-529','Bank Of Ceylon - Kamburupitiya'),('7010','7010-530','Bank Of Ceylon - Avissawella'),('7010','7010-531','Bank Of Ceylon - Talawakelle'),('7010','7010-532','Bank Of Ceylon - Ridigama'),('7010','7010-534','Bank Of Ceylon - Narammala'),('7010','7010-535','Bank Of Ceylon - Embilipitiya'),('7010','7010-536','Bank Of Ceylon - Kegalle Bazzar'),('7010','7010-537','Bank Of Ceylon - Ambalantota'),('7010','7010-538','Bank Of Ceylon - Tissamaharama'),('7010','7010-539','Bank Of Ceylon - Beliatta'),('7010','7010-540','Bank Of Ceylon - Badalkumbura'),('7010','7010-542','Bank Of Ceylon - Mahiyangana'),('7010','7010-543','Bank Of Ceylon - Kiribathgoda'),('7010','7010-544','Bank Of Ceylon - Madampe'),('7010','7010-545','Bank Of Ceylon - Minuwangoda'),('7010','7010-546','Bank Of Ceylon - Pannala'),('7010','7010-547','Bank Of Ceylon - Nikaweratiya'),('7010','7010-548','Bank Of Ceylon - Anamaduwa'),('7010','7010-549','Bank Of Ceylon - Galgamuwa'),('7010','7010-550','Bank Of Ceylon - Weligama'),('7010','7010-551','Bank Of Ceylon - Anuradhapura Bazaar'),('7010','7010-553','Bank Of Ceylon - Giriulla'),('7010','7010-554','Bank Of Ceylon - Bingiriya'),('7010','7010-555','Bank Of Ceylon - Melsiripura'),('7010','7010-556','Bank Of Ceylon - Matugama'),('7010','7010-558','Bank Of Ceylon - Waikkal'),('7010','7010-559','Bank Of Ceylon - Mawanella'),('7010','7010-560','Bank Of Ceylon - Buttala'),('7010','7010-561','Bank Of Ceylon - Dematagoda'),('7010','7010-562','Bank Of Ceylon - Warakapola'),('7010','7010-563','Bank Of Ceylon - Dharga Town'),('7010','7010-564','Bank Of Ceylon - Maho'),('7010','7010-565','Bank Of Ceylon - Madurankuliya'),('7010','7010-566','Bank Of Ceylon - Aranayake'),('7010','7010-568','Bank Of Ceylon - Homagama'),('7010','7010-569','Bank Of Ceylon - Hiripitiya'),('7010','7010-570','Bank Of Ceylon - Hettipola'),('7010','7010-571','Bank Of Ceylon - Kirindiwela'),('7010','7010-572','Bank Of Ceylon - Negambo Bazzar'),('7010','7010-573','Bank Of Ceylon - Central Bus Stand'),('7010','7010-574','Bank Of Ceylon - Mankulam'),('7010','7010-575','Bank Of Ceylon - Gampola'),('7010','7010-576','Bank Of Ceylon - Dambulla'),('7010','7010-577','Bank Of Ceylon - Lunugala'),('7010','7010-578','Bank Of Ceylon - Yakkalamulla'),('7010','7010-579','Bank Of Ceylon - Bibila'),('7010','7010-580','Bank Of Ceylon - Dummalasuriya'),('7010','7010-581','Bank Of Ceylon - Madawala'),('7010','7010-582','Bank Of Ceylon - Rambukkana'),('7010','7010-583','Bank Of Ceylon - Pelmadulla'),('7010','7010-584','Bank Of Ceylon - Wadduwa'),('7010','7010-585','Bank Of Ceylon - Ruwanwella'),('7010','7010-587','Bank Of Ceylon - Pilimatalawa'),('7010','7010-588','Bank Of Ceylon - Peradeniya'),('7010','7010-589','Bank Of Ceylon - Kalpitiya'),('7010','7010-590','Bank Of Ceylon - Akkaraipattu'),('7010','7010-591','Bank Of Ceylon - Nintavur'),('7010','7010-592','Bank Of Ceylon - Dickwella'),('7010','7010-593','Bank Of Ceylon - Milagiriya'),('7010','7010-594','Bank Of Ceylon - Rakwana'),('7010','7010-595','Bank Of Ceylon - Kolonnawa'),('7010','7010-596','Bank Of Ceylon - Talgaswela'),('7010','7010-597','Bank Of Ceylon - Nivitigala'),('7010','7010-598','Bank Of Ceylon - Nawalapitiya'),('7010','7010-599','Bank Of Ceylon - Aralaganwila'),('7010','7010-600','Bank Of Ceylon - Jayanthipura'),('7010','7010-601','Bank Of Ceylon - Hingurakgoda'),('7010','7010-604','Bank Of Ceylon - Ingiriya'),('7010','7010-605','Bank Of Ceylon - Kankasanthurai'),('7010','7010-606','Bank Of Ceylon - Udu Dumbara'),('7010','7010-607','Bank Of Ceylon - Panadura Bazzar'),('7010','7010-608','Bank Of Ceylon - Kaduwela'),('7010','7010-609','Bank Of Ceylon - Hikkaduwa'),('7010','7010-610','Bank Of Ceylon - Pitigala'),('7010','7010-611','Bank Of Ceylon - Kaluwanchikudy'),('7010','7010-612','Bank Of Ceylon - Lake View Branch'),('7010','7010-613','Bank Of Ceylon - Akuressa'),('7010','7010-614','Bank Of Ceylon - Matara Bazzar'),('7010','7010-615','Bank Of Ceylon - Galagedera'),('7010','7010-616','Bank Of Ceylon - Kataragama'),('7010','7010-617','Bank Of Ceylon - Metropolitan Br. (York St.)'),('7010','7010-618','Bank Of Ceylon - Metropolitan Br. (York St.)'),('7010','7010-619','Bank Of Ceylon - Elpitiya'),('7010','7010-621','Bank Of Ceylon - Kebithigollawa'),('7010','7010-622','Bank Of Ceylon - Khatagasdigiliya'),('7010','7010-623','Bank Of Ceylon - Kantalai Bazzar'),('7010','7010-624','Bank Of Ceylon - Trincomalee Bazzar'),('7010','7010-626','Bank Of Ceylon - Valachchenai'),('7010','7010-627','Bank Of Ceylon - Regent Street'),('7010','7010-628','Bank Of Ceylon - Grandpass'),('7010','7010-629','Bank Of Ceylon - Koslanda'),('7010','7010-630','Bank Of Ceylon - Chenkalady'),('7010','7010-633','Bank Of Ceylon - Kandapola'),('7010','7010-634','Bank Of Ceylon - Dehiowita'),('7010','7010-636','Bank Of Ceylon - Lake House Branch'),('7010','7010-638','Bank Of Ceylon - Nelliady'),('7010','7010-639','Bank Of Ceylon - Rattota'),('7010','7010-640','Bank Of Ceylon - Palepola'),('7010','7010-641','Bank Of Ceylon - Medirigiriya'),('7010','7010-642','Bank Of Ceylon - Deraniyagala'),('7010','7010-644','Bank Of Ceylon - Parliamentary Complex'),('7010','7010-645','Bank Of Ceylon - Kalawana'),('7010','7010-646','Bank Of Ceylon - Ginigathhena'),('7010','7010-647','Bank Of Ceylon - Lunuwatte'),('7010','7010-648','Bank Of Ceylon - Kattankudy'),('7010','7010-649','Bank Of Ceylon - Kandy 2nd City'),('7010','7010-650','Bank Of Ceylon - Talatuoya'),('7010','7010-652','Bank Of Ceylon - Bakamuna'),('7010','7010-653','Bank Of Ceylon - Galkiriyagama'),('7010','7010-654','Bank Of Ceylon - Madatugama'),('7010','7010-655','Bank Of Ceylon - Tambuttegama'),('7010','7010-656','Bank Of Ceylon - Nochchiyagama'),('7010','7010-657','Bank Of Ceylon - Agalawatta'),('7010','7010-658','Bank Of Ceylon - Katunayake Investment Br.'),('7010','7010-660','Bank Of Ceylon - Corporate Branch'),('7010','7010-663','Bank Of Ceylon - Kotahena'),('7010','7010-664','Bank Of Ceylon - Pothuhera'),('7010','7010-665','Bank Of Ceylon - Bandaragama'),('7010','7010-666','Bank Of Ceylon - Katugastota'),('7010','7010-667','Bank Of Ceylon - Neluwa'),('7010','7010-668','Bank Of Ceylon - Borella 2nd Branch'),('7010','7010-669','Bank Of Ceylon - Girandurukotte'),('7010','7010-670','Bank Of Ceylon - Kollupitiya 2nd Branch'),('7010','7010-672','Bank Of Ceylon - Central Super Market Branch'),('7010','7010-673','Bank Of Ceylon - Bulathsinhala'),('7010','7010-675','Bank Of Ceylon - Nittambuwa'),('7010','7010-676','Bank Of Ceylon - Kekirawa'),('7010','7010-678','Bank Of Ceylon - Padukka'),('7010','7010-679','Bank Of Ceylon - Battaramulla'),('7010','7010-680','Bank Of Ceylon - Aluthgama'),('7010','7010-681','Bank Of Ceylon - Personal Br., New HQ Bldg.'),('7010','7010-682','Bank Of Ceylon - Veyangoda'),('7010','7010-683','Bank Of Ceylon - Pelmadulla'),('7010','7010-684','Bank Of Ceylon - Ratnapura Bazzar'),('7010','7010-686','Bank Of Ceylon - Dehiattakandiya'),('7010','7010-688','Bank Of Ceylon - Balangoda'),('7010','7010-689','Bank Of Ceylon - Ratmalana'),('7010','7010-690','Bank Of Ceylon - Pelawatta'),('7010','7010-691','Bank Of Ceylon - Hakmana'),('7010','7010-692','Bank Of Ceylon - Eppawala'),('7010','7010-693','Bank Of Ceylon - Ruhunu Campus Branch'),('7010','7010-728','Bank Of Ceylon - Meegallewa'),('7010','7010-730','Bank Of Ceylon - Welimada'),('7010','7010-731','Bank Of Ceylon - CEYBANK Credit Card Centre'),('7010','7010-732','Bank Of Ceylon - Biyagama'),('7010','7010-735','Bank Of Ceylon - Kinniya'),('7010','7010-736','Bank Of Ceylon - Piliyandala'),('7010','7010-741','Bank Of Ceylon - Hanwella'),('7010','7010-743','Bank Of Ceylon - Walapone'),('7010','7010-745','Bank Of Ceylon - Kotiyakumbura'),('7010','7010-746','Bank Of Ceylon - Rajagiriya'),('7010','7010-747','Bank Of Ceylon - Taprobane Branch'),('7010','7010-749','Bank Of Ceylon - Karainagar'),('7010','7010-750','Bank Of Ceylon - Koggala EPZ'),('7010','7010-754','Bank Of Ceylon - Ahungalla'),('7010','7010-757','Bank Of Ceylon - Athurugiriya'),('7010','7010-760','Bank Of Ceylon - Treasury Division'),('7010','7010-761','Bank Of Ceylon - Thirunelvely'),('7010','7010-762','Bank Of Ceylon - Narahenpita'),('7010','7010-763','Bank Of Ceylon - Malabe'),('7010','7010-764','Bank Of Ceylon - Ragama'),('7010','7010-765','Bank Of Ceylon - Pugoda'),('7010','7010-766','Bank Of Ceylon - Mt.Lavinia'),('7010','7010-768','Bank Of Ceylon - Alawattugoda'),('7010','7010-769','Bank Of Ceylon - Yakkala'),('7010','7010-770','Bank Of Ceylon - Ibbagamuwa'),('7010','7010-771','Bank Of Ceylon - Kandana'),('7010','7010-772','Bank Of Ceylon - Hemmathagama'),('7010','7010-773','Bank Of Ceylon - Kottawa Branch'),('7010','7010-774','Bank Of Ceylon - Angunaklapelessa'),('7010','7010-776','Bank Of Ceylon - Islamic Banking'),('7010','7010-779','Bank Of Ceylon - Nuraicholai'),('7010','7010-822','Bank Of Ceylon - Corporate 2nd Branch'),('7038','7038-001','Standard Chartered Bank - Head Office'),('7038','7038-002','Standard Chartered Bank - Bambalapitiya'),('7038','7038-003','Standard Chartered Bank - Wellawatte'),('7038','7038-004','Standard Chartered Bank - Kiribathgoda'),('7038','7038-005','Standard Chartered Bank - Kirullapone'),('7038','7038-006','Standard Chartered Bank - Moratuwa'),('7038','7038-007','Standard Chartered Bank - Rajagiriya'),('7038','7038-008','Standard Chartered Bank - Kollupitiya'),('7038','7038-010','Standard Chartered Bank - Petta'),('7038','7038-011','Standard Chartered Bank - Union Place'),('7038','7038-012','Standard Chartered Bank - Negombo'),('7047','7047-001','City Bank - Colombo 7'),('7056','7056-','Commercial Bank - Puttalam'),('7056','7056-001','Commercial Bank - Head Office'),('7056','7056-002','Commercial Bank - City Office'),('7056','7056-003','Commercial Bank - Foreign Branch'),('7056','7056-004','Commercial Bank - Kandy'),('7056','7056-005','Commercial Bank - Galle'),('7056','7056-006','Commercial Bank - Juffna'),('7056','7056-007','Commercial Bank - Matara'),('7056','7056-008','Commercial Bank - Matale'),('7056','7056-009','Commercial Bank - Galewela'),('7056','7056-010','Commercial Bank - Wellawatte'),('7056','7056-011','Commercial Bank - Kollupitiya'),('7056','7056-012','Commercial Bank - Kotahena'),('7056','7056-013','Commercial Bank - Negombo'),('7056','7056-014','Commercial Bank - Hikkaduwa'),('7056','7056-015','Commercial Bank - Hingurakgoda'),('7056','7056-016','Commercial Bank - Kurunegala'),('7056','7056-017','Commercial Bank - Old Moor Street'),('7056','7056-018','Commercial Bank - Maharagama'),('7056','7056-019','Commercial Bank - Borella'),('7056','7056-020','Commercial Bank - Nugegoda'),('7056','7056-021','Commercial Bank - Kegalle'),('7056','7056-022','Commercial Bank - Narahenpita'),('7056','7056-023','Commercial Bank - Mutuwal'),('7056','7056-024','Commercial Bank - Pettah'),('7056','7056-025','Commercial Bank - Katunayake FTZ'),('7056','7056-026','Commercial Bank - Wennappuwa'),('7056','7056-027','Commercial Bank - Galle Sub Branch'),('7056','7056-028','Commercial Bank - Koggala'),('7056','7056-029','Commercial Bank - Battaramulla'),('7056','7056-030','Commercial Bank - Embilipitiya'),('7056','7056-031','Commercial Bank - Kandana'),('7056','7056-032','Commercial Bank - Maradana'),('7056','7056-033','Commercial Bank - Minuwangoda'),('7056','7056-034','Commercial Bank - Nuwara Eliya'),('7056','7056-035','Commercial Bank - Akuressa'),('7056','7056-036','Commercial Bank - Kalutara'),('7056','7056-037','Commercial Bank - Trincomalee'),('7056','7056-038','Commercial Bank - Panchikawatte'),('7056','7056-039','Commercial Bank - Keyzer Street'),('7056','7056-040','Commercial Bank - Aluthgama'),('7056','7056-041','Commercial Bank - Panadura'),('7056','7056-042','Commercial Bank - Kaduwela'),('7056','7056-043','Commercial Bank - Chilaw'),('7056','7056-044','Commercial Bank - Gampaha'),('7056','7056-045','Commercial Bank - Katugastota'),('7056','7056-046','Commercial Bank - Ratmalana'),('7056','7056-047','Commercial Bank - Kirulapana'),('7056','7056-048','Commercial Bank - Union Place'),('7056','7056-049','Commercial Bank - Ratnapura'),('7056','7056-050','Commercial Bank - Colombo 07'),('7056','7056-051','Commercial Bank - Kuliyapitiya'),('7056','7056-052','Commercial Bank - Badulla'),('7056','7056-053','Commercial Bank - Anuradhapura'),('7056','7056-054','Commercial Bank - Dambulla'),('7056','7056-055','Commercial Bank - Nattandiya'),('7056','7056-056','Commercial Bank - Wattala'),('7056','7056-057','Commercial Bank - Grandpass'),('7056','7056-058','Commercial Bank - Dehiwala'),('7056','7056-059','Commercial Bank - Moratuwa'),('7056','7056-060','Commercial Bank - Narammala'),('7056','7056-061','Commercial Bank - Vavuniya'),('7056','7056-062','Commercial Bank - Rajagiriya'),('7056','7056-063','Commercial Bank - Ambalanthota'),('7056','7056-064','Commercial Bank - Seeduwa'),('7056','7056-065','Commercial Bank - Nittambuwa'),('7056','7056-066','Commercial Bank - Mirigama'),('7056','7056-067','Commercial Bank - Kadawatha'),('7056','7056-068','Commercial Bank - Duplication Road'),('7056','7056-069','Commercial Bank - Kiribathgoda'),('7056','7056-070','Commercial Bank - Avissawella'),('7056','7056-071','Commercial Bank - Ekala'),('7056','7056-072','Commercial Bank - Pettah Main Street'),('7056','7056-073','Commercial Bank - Peradeniya'),('7056','7056-074','Commercial Bank - Kochchikade (C.S.P)'),('7056','7056-075','Commercial Bank - Homagama'),('7056','7056-076','Commercial Bank - Horana'),('7056','7056-077','Commercial Bank - Piliyandala'),('7056','7056-078','Commercial Bank - Thalawathugoda'),('7056','7056-079','Commercial Bank - Mawanella'),('7056','7056-080','Commercial Bank - Bandarawela'),('7056','7056-081','Commercial Bank - Ja-Ela'),('7056','7056-082','Commercial Bank - Balangoda'),('7056','7056-083','Commercial Bank - Nikaweratiya'),('7056','7056-084','Commercial Bank - Bandaragama'),('7056','7056-085','Commercial Bank - Yakkala'),('7056','7056-086','Commercial Bank - Malabe'),('7056','7056-087','Commercial Bank - Kohuwala'),('7056','7056-088','Commercial Bank - Kaduruwela'),('7056','7056-089','Commercial Bank - Nawalapitiya'),('7056','7056-093','Commercial Bank - Mt.Lavinia'),('7056','7056-096','Commercial Bank - Mathugama'),('7056','7056-097','Commercial Bank - Ambalangoda'),('7056','7056-098','Commercial Bank - Baddegama'),('7056','7056-100','Commercial Bank - Ampara'),('7056','7056-101','Commercial Bank - Nawala'),('7056','7056-102','Commercial Bank - Gampola'),('7056','7056-103','Commercial Bank - Elpitiya'),('7056','7056-104','Commercial Bank - Kamburupitiya'),('7056','7056-105','Commercial Bank - Batticaloa'),('7056','7056-106','Commercial Bank - Bambalapitiya'),('7056','7056-107','Commercial Bank - Chunakkam'),('7056','7056-108','Commercial Bank - Nelliady'),('7056','7056-109','Commercial Bank - Pilimathalawa'),('7056','7056-110','Commercial Bank - Kekirawa'),('7056','7056-111','Commercial Bank - Deniyaya'),('7056','7056-112','Commercial Bank - Weligama'),('7056','7056-113','Commercial Bank - Baseline Road (CSP)'),('7056','7056-114','Commercial Bank - Katubedda'),('7056','7056-115','Commercial Bank - Hatton'),('7056','7056-116','Commercial Bank - Reid Avenue'),('7056','7056-117','Commercial Bank - Pitakotte (CSP)'),('7056','7056-118','Commercial Bank - Negombo'),('7056','7056-119','Commercial Bank - Kotikawatta'),('7056','7056-120','Commercial Bank - Monaragala'),('7056','7056-121','Commercial Bank - Galle'),('7056','7056-122','Commercial Bank - Kurunagala (C.S.P)'),('7056','7056-123','Commercial Bank - Tangalle'),('7056','7056-124','Commercial Bank - Tissamaharama'),('7056','7056-125','Commercial Bank - Neluwa'),('7056','7056-126','Commercial Bank - Chavakachcheri'),('7056','7056-127','Commercial Bank - Jaffa (C.S.P)'),('7056','7056-128','Commercial Bank - Warakapola'),('7056','7056-129','Commercial Bank - Udugama'),('7056','7056-130','Commercial Bank - Athurugiriya'),('7056','7056-131','Commercial Bank - Raddolugama (C.S.P)'),('7056','7056-132','Commercial Bank - Boralesgamuwa (CSP)'),('7056','7056-133','Commercial Bank - Kahawatte'),('7056','7056-134','Commercial Bank - Delkanda (C.S.P)'),('7056','7056-135','Commercial Bank - Karapitiya'),('7056','7056-136','Commercial Bank - Welimada'),('7056','7056-137','Commercial Bank - Mahiyanganaya'),('7056','7056-138','Commercial Bank - Kalawana'),('7056','7056-140','Commercial Bank - Digana'),('7056','7056-142','Commercial Bank - Boralesgamuwa'),('7056','7056-146','Commercial Bank - Wadduwa'),('7056','7056-147','Commercial Bank - Biyagama'),('7056','7056-148','Commercial Bank - Puttalam'),('7056','7056-149','Commercial Bank - Pelmadulla'),('7056','7056-150','Commercial Bank - Kandy City Office'),('7056','7056-151','Commercial Bank - Matara City'),('7056','7056-152','Commercial Bank - Kalmunai'),('7056','7056-159','Commercial Bank - Valachcheni'),('7056','7056-160','Commercial Bank - Wellawaya'),('7056','7056-162','Commercial Bank - Thambuththegama'),('7056','7056-163','Commercial Bank - Ruwanwella'),('7056','7056-164','Commercial Bank - Colombo'),('7056','7056-172','Commercial Bank - akkaraipattu'),('7056','7056-206','Commercial Bank - Palavi (C.S.P)'),('7056','7056-216','Commercial Bank - Ramanayake Mawatha'),('7056','7056-220','Commercial Bank - Beruwala Minicom'),('7056','7056-254','Commercial Bank - Anniwatte (C.S.P)'),('7056','7056-255','Commercial Bank - Kundasale (C.S.P)'),('7074','7074-003','HBL - Kalmunai'),('7083','7083-','HNB -'),('7083','7083-001','HNB - Aluth Kade'),('7083','7083-002','HNB - City Office'),('7083','7083-003','HNB - Head Office Branch'),('7083','7083-004','HNB - Head Office'),('7083','7083-005','HNB - Main Branch'),('7083','7083-006','HNB - Maligawatte'),('7083','7083-007','HNB - Pettah'),('7083','7083-008','HNB - Suduwella'),('7083','7083-009','HNB - Wellawatte'),('7083','7083-010','HNB - Anuradhapura'),('7083','7083-011','HNB - Badulla'),('7083','7083-012','HNB - Bandarawela'),('7083','7083-013','HNB - Galle'),('7083','7083-014','HNB - Gampola'),('7083','7083-015','HNB - Hatton'),('7083','7083-016','HNB - Jaffna'),('7083','7083-017','HNB - Kahawatte'),('7083','7083-018','HNB - KAndy'),('7083','7083-019','HNB - Kurunegala'),('7083','7083-020','HNB - Mannar'),('7083','7083-021','HNB - Maskeliya'),('7083','7083-022','HNB - Moratuwa'),('7083','7083-023','HNB - Nawalapitiya'),('7083','7083-024','HNB - Negombo'),('7083','7083-025','HNB - Nittambuwa'),('7083','7083-026','HNB - Nochchiyagama'),('7083','7083-027','HNB - Nugegoda'),('7083','7083-028','HNB - Nuwara Eliya'),('7083','7083-029','HNB - Pusellawa'),('7083','7083-030','HNB - Ratnapura'),('7083','7083-031','HNB - Trincomalee'),('7083','7083-032','HNB - Vavuniya'),('7083','7083-033','HNB - Welimada'),('7083','7083-034','HNB - Kalutara'),('7083','7083-035','HNB - Wattala'),('7083','7083-036','HNB - Sri Jayawardanapura'),('7083','7083-038','HNB - Piliyandala'),('7083','7083-039','HNB - Bambalapitiya'),('7083','7083-040','HNB - Chilaw'),('7083','7083-041','HNB - Kegalle'),('7083','7083-042','HNB - Matara'),('7083','7083-043','HNB - Kirulapone'),('7083','7083-044','HNB - Polonnaruwa'),('7083','7083-045','HNB - Ambalantota'),('7083','7083-046','HNB - Grandpass'),('7083','7083-047','HNB - Biyagama'),('7083','7083-048','HNB - Dambulla'),('7083','7083-049','HNB - Air Cargo Village'),('7083','7083-050','HNB - Embilipitiya'),('7083','7083-051','HNB - Gampaha'),('7083','7083-052','HNB - Horana'),('7083','7083-053','HNB - Monaragala'),('7083','7083-055','HNB - Borella'),('7083','7083-056','HNB - Kiribathgoda'),('7083','7083-057','HNB - Batticaloa'),('7083','7083-058','HNB - Ampara'),('7083','7083-059','HNB - Panchikawatta'),('7083','7083-060','HNB - Bogawanthalawa'),('7083','7083-061','HNB - Mt.Lavinia'),('7083','7083-062','HNB - Kollupitiya'),('7083','7083-063','HNB - Hulftsdrop'),('7083','7083-064','HNB - Maharagama'),('7083','7083-065','HNB - MAtale'),('7083','7083-066','HNB - Pinnawala'),('7083','7083-067','HNB - Suriyawewa'),('7083','7083-068','HNB - Hambantota'),('7083','7083-069','HNB - Panadura'),('7083','7083-070','HNB - Dankotuwa'),('7083','7083-071','HNB - Balangoda'),('7083','7083-072','HNB - Sea Street'),('7083','7083-073','HNB - Moratumulla'),('7083','7083-074','HNB - Kuliyapitiya'),('7083','7083-075','HNB - Buttala'),('7083','7083-076','HNB - Cinnamon Gardens'),('7083','7083-077','HNB - Homagama'),('7083','7083-078','HNB - Akkaraipathhtu'),('7083','7083-079','HNB - Maradagahamula'),('7083','7083-080','HNB - Marawila'),('7083','7083-081','HNB - ambalangoda'),('7083','7083-082','HNB - Kaduwela'),('7083','7083-083','HNB - Puttalam'),('7083','7083-084','HNB - Kadawatha'),('7083','7083-085','HNB - Thalangama'),('7083','7083-086','HNB - Thangalle'),('7083','7083-087','HNB - Ja Ela'),('7083','7083-088','HNB - Thambuttegama'),('7083','7083-089','HNB - Mawanella'),('7083','7083-090','HNB - Thissamaharama'),('7083','7083-091','HNB - Kalmunai'),('7083','7083-092','HNB - Thimbirigasyaya'),('7083','7083-093','HNB - Dehiwala'),('7083','7083-094','HNB - Minuwangoda'),('7083','7083-095','HNB - Kanthali'),('7083','7083-096','HNB - Kotahena'),('7083','7083-097','HNB - Mutwal'),('7083','7083-098','HNB - Kottawa'),('7083','7083-099','HNB - Kirindiwela'),('7083','7083-100','HNB - Katugastota'),('7083','7083-101','HNB - Pelmadulla'),('7083','7083-102','HNB - Ragama'),('7083','7083-103','HNB - Dematagoda'),('7083','7083-104','HNB - Narahenpitiya'),('7083','7083-106','HNB - Wellawaya'),('7083','7083-107','HNB - Elpitiya'),('7083','7083-108','HNB - Maradana'),('7083','7083-109','HNB - Aluthgama'),('7083','7083-110','HNB - Wennappuwa'),('7083','7083-111','HNB - Avissawella'),('7083','7083-112','HNB - Boralesgamuwa'),('7083','7083-114','HNB - Central Colombo Branch'),('7083','7083-115','HNB - Kollupitiya'),('7083','7083-116','HNB - Colombo South Branch'),('7083','7083-117','HNB - Chunnakam'),('7083','7083-118','HNB - Nelliady'),('7083','7083-120','HNB - Deniyaya'),('7083','7083-121','HNB - Nikaweratiya'),('7083','7083-122','HNB - Delgoda'),('7083','7083-123','HNB - Alawwa'),('7083','7083-124','HNB - Mahiyangana'),('7083','7083-125','HNB - Mathugama'),('7083','7083-126','HNB - Warakapola'),('7083','7083-127','HNB - Middeniya'),('7083','7083-128','HNB - Galgamuwa'),('7083','7083-130','HNB - Weliweriya'),('7083','7083-135','HNB - Chenkaladi'),('7083','7083-136','HNB - Ganemulla'),('7083','7083-138','HNB - Kelaniya'),('7083','7083-139','HNB - HANWELLA'),('7083','7083-141','HNB - Pilimatalawa'),('7083','7083-143','HNB - Madawachchiya'),('7083','7083-149','HNB - Galewela'),('7083','7083-151','HNB - Akuressa'),('7083','7083-153','HNB - Wariyapola'),('7083','7083-158','HNB - Pottuvil'),('7083','7083-159','HNB - Nintavur'),('7083','7083-162','HNB - Rikilla'),('7083','7083-165','HNB - Kaluwanchikudy'),('7083','7083-167','HNB - Valachenai'),('7083','7083-176','HNB - Digana'),('7083','7083-178','HNB - Dikwella'),('7092','7092-001','HSBC - Colombo'),('7092','7092-002','HSBC - Kandy'),('7135','7135-001','Peoples Bank - Duke Street'),('7135','7135-002','Peoples Bank - Matale'),('7135','7135-003','Peoples Bank - Kandy'),('7135','7135-004','Peoples Bank - International Div.'),('7135','7135-005','Peoples Bank - Polonnaruwa'),('7135','7135-006','Peoples Bank - Hingurakgoda'),('7135','7135-007','Peoples Bank - Hambantota'),('7135','7135-008','Peoples Bank - Anuradhapura'),('7135','7135-009','Peoples Bank - Puttalam'),('7135','7135-011','Peoples Bank - Bibila'),('7135','7135-012','Peoples Bank - Kurunegala'),('7135','7135-013','Peoples Bank - Galle-Fort'),('7135','7135-014','Peoples Bank - Union Place'),('7135','7135-015','Peoples Bank - Ampara'),('7135','7135-016','Peoples Bank - Welimada'),('7135','7135-017','Peoples Bank - Balangoda'),('7135','7135-018','Peoples Bank - Gampola'),('7135','7135-019','Peoples Bank - Dehiwala'),('7135','7135-020','Peoples Bank - Mullaitivu'),('7135','7135-021','Peoples Bank - Minuwangoda'),('7135','7135-022','Peoples Bank - Hanguranketha'),('7135','7135-023','Peoples Bank - Kalmunai'),('7135','7135-024','Peoples Bank - Chalaw'),('7135','7135-025','Peoples Bank - Hyde Park Corner'),('7135','7135-026','Peoples Bank - Gampaha'),('7135','7135-027','Peoples Bank - Kegalle'),('7135','7135-028','Peoples Bank - Kuliyapitiya'),('7135','7135-029','Peoples Bank - Avissawella'),('7135','7135-030','Peoples Bank - Jaffna Stanley Road'),('7135','7135-031','Peoples Bank - Kankasanthurai'),('7135','7135-032','Peoples Bank - Matara Uyanwatte'),('7135','7135-033','Peoples Bank - Queen Street'),('7135','7135-034','Peoples Bank - Negambo'),('7135','7135-035','Peoples Bank - Ambalangoda'),('7135','7135-036','Peoples Bank - Ragala'),('7135','7135-037','Peoples Bank - Bandarawela'),('7135','7135-038','Peoples Bank - Talawakelle'),('7135','7135-039','Peoples Bank - Kalutara'),('7135','7135-040','Peoples Bank - Vavuniya'),('7135','7135-041','Peoples Bank - Horana'),('7135','7135-042','Peoples Bank - Kekirawa'),('7135','7135-043','Peoples Bank - Padaviya'),('7135','7135-044','Peoples Bank - Mannar'),('7135','7135-045','Peoples Bank - Embilipitiya'),('7135','7135-046','Peoples Bank - First City Branch'),('7135','7135-047','Peoples Bank - Yatiyantota'),('7135','7135-048','Peoples Bank - Kilinochci'),('7135','7135-049','Peoples Bank - Homagama'),('7135','7135-050','Peoples Bank - MAin Street,Colombo'),('7135','7135-051','Peoples Bank - Kahatagasdigitiya'),('7135','7135-052','Peoples Bank - Maho'),('7135','7135-053','Peoples Bank - Nawalapitiya'),('7135','7135-054','Peoples Bank - Warakapola'),('7135','7135-055','Peoples Bank - Kelaniya'),('7135','7135-056','Peoples Bank - Sri Sangaraja Mw.'),('7135','7135-057','Peoples Bank - Peradeniya'),('7135','7135-058','Peoples Bank - Mahiyanganaya'),('7135','7135-059','Peoples Bank - Polgahawela'),('7135','7135-060','Peoples Bank - Morawaka'),('7135','7135-061','Peoples Bank - Tissamaharama'),('7135','7135-062','Peoples Bank - Wellawaya'),('7135','7135-063','Peoples Bank - Akkareipattu'),('7135','7135-064','Peoples Bank - Sammanturai'),('7135','7135-065','Peoples Bank - Kattankudy'),('7135','7135-066','Peoples Bank - Trincomalee'),('7135','7135-067','Peoples Bank - Tangalle'),('7135','7135-068','Peoples Bank - Monaragala'),('7135','7135-069','Peoples Bank - Mawanella'),('7135','7135-070','Peoples Bank - Matugama'),('7135','7135-071','Peoples Bank - Dematagoda'),('7135','7135-072','Peoples Bank - Ambalantota'),('7135','7135-073','Peoples Bank - Elpitiya'),('7135','7135-074','Peoples Bank - Wattegama'),('7135','7135-075','Peoples Bank - Batticaloa'),('7135','7135-076','Peoples Bank - Wennappuwa'),('7135','7135-077','Peoples Bank - Weligama'),('7135','7135-078','Peoples Bank - Borella'),('7135','7135-079','Peoples Bank - Veyangoda'),('7135','7135-080','Peoples Bank - Ratmalana'),('7135','7135-081','Peoples Bank - Ruwanwella'),('7135','7135-082','Peoples Bank - Narammala'),('7135','7135-083','Peoples Bank - Nattandiya'),('7135','7135-084','Peoples Bank - Aluthgama'),('7135','7135-085','Peoples Bank - Eheliyagoda'),('7135','7135-086','Peoples Bank - Thimbirigasyaya'),('7135','7135-087','Peoples Bank - Baddegama'),('7135','7135-088','Peoples Bank - Ratnapura'),('7135','7135-089','Peoples Bank - Katugastota'),('7135','7135-090','Peoples Bank - Kantalai'),('7135','7135-091','Peoples Bank - Moratuwa'),('7135','7135-092','Peoples Bank - Giriulla'),('7135','7135-093','Peoples Bank - Pugoda'),('7135','7135-094','Peoples Bank - Kinniya'),('7135','7135-095','Peoples Bank - Mutur'),('7135','7135-096','Peoples Bank - Medawachchiya'),('7135','7135-097','Peoples Bank - Gangodawila'),('7135','7135-098','Peoples Bank - Kotikawatte'),('7135','7135-100','Peoples Bank - Marandagahamula'),('7135','7135-101','Peoples Bank - Rambukkana'),('7135','7135-102','Peoples Bank - Valachchenei'),('7135','7135-103','Peoples Bank - Piliyandala'),('7135','7135-104','Peoples Bank - Jaffna Main Street'),('7135','7135-105','Peoples Bank - Keyts'),('7135','7135-106','Peoples Bank - Nelliady'),('7135','7135-107','Peoples Bank - Atchuvely'),('7135','7135-108','Peoples Bank - Chankanai'),('7135','7135-109','Peoples Bank - Chunnakam'),('7135','7135-110','Peoples Bank - Chavakachcheri'),('7135','7135-111','Peoples Bank - Paranthan'),('7135','7135-112','Peoples Bank - Teldeniya'),('7135','7135-113','Peoples Bank - Batticaloa'),('7135','7135-114','Peoples Bank - Galagedara'),('7135','7135-115','Peoples Bank - Galewela'),('7135','7135-116','Peoples Bank - Passara'),('7135','7135-117','Peoples Bank - Akuressa'),('7135','7135-118','Peoples Bank - delgoda'),('7135','7135-119','Peoples Bank - Narahenpita'),('7135','7135-120','Peoples Bank - Walasmulla'),('7135','7135-121','Peoples Bank - Bandaragama'),('7135','7135-122','Peoples Bank - Wilgamuwa'),('7135','7135-123','Peoples Bank - Eravur'),('7135','7135-124','Peoples Bank - Nikaweratiya'),('7135','7135-125','Peoples Bank - Kalpitiya'),('7135','7135-126','Peoples Bank - Grandpass'),('7135','7135-127','Peoples Bank - Nildandahinna'),('7135','7135-128','Peoples Bank - Rattota'),('7135','7135-129','Peoples Bank - Rakwana'),('7135','7135-130','Peoples Bank - Hakmana'),('7135','7135-131','Peoples Bank - Udugama'),('7135','7135-132','Peoples Bank - Deniyaya'),('7135','7135-133','Peoples Bank - Kamburupitiya'),('7135','7135-134','Peoples Bank - Nuwara Eliya'),('7135','7135-135','Peoples Bank - Dickwella'),('7135','7135-136','Peoples Bank - Hikkaduwa'),('7135','7135-137','Peoples Bank - Makandura'),('7135','7135-138','Peoples Bank - Dambulla'),('7135','7135-139','Peoples Bank - Pettah'),('7135','7135-140','Peoples Bank - HAsalaka'),('7135','7135-141','Peoples Bank - Velivetiturai'),('7135','7135-142','Peoples Bank - Kochchikade'),('7135','7135-143','Peoples Bank - Suduwella'),('7135','7135-144','Peoples Bank - Hettipola'),('7135','7135-145','Peoples Bank - Wellawatte'),('7135','7135-146','Peoples Bank - Naula'),('7135','7135-147','Peoples Bank - Buttala'),('7135','7135-148','Peoples Bank - Panadura'),('7135','7135-149','Peoples Bank - Alawwa'),('7135','7135-150','Peoples Bank - Kebithigollewa'),('7135','7135-151','Peoples Bank - Diyatalawa'),('7135','7135-152','Peoples Bank - Matara Dharmapala Mw'),('7135','7135-153','Peoples Bank - Akurana'),('7135','7135-154','Peoples Bank - Balapitiya'),('7135','7135-155','Peoples Bank - Kahawatte'),('7135','7135-156','Peoples Bank - Uva Paranagama'),('7135','7135-157','Peoples Bank - Manikhinna'),('7135','7135-158','Peoples Bank - Senkadagala'),('7135','7135-159','Peoples Bank - Kadugannawa'),('7135','7135-160','Peoples Bank - Pelmadulla'),('7135','7135-161','Peoples Bank - Bulathsinhala'),('7135','7135-162','Peoples Bank - Jaffna University'),('7135','7135-163','Peoples Bank - Wariyapola'),('7135','7135-164','Peoples Bank - Pottuvil'),('7135','7135-165','Peoples Bank - Mankulam'),('7135','7135-166','Peoples Bank - Murunkan'),('7135','7135-167','Peoples Bank - Town Hall,Colombo'),('7135','7135-168','Peoples Bank - Kataragama'),('7135','7135-169','Peoples Bank - Galle Main Street'),('7135','7135-170','Peoples Bank - Eppawela'),('7135','7135-171','Peoples Bank - Nochchiyagama'),('7135','7135-172','Peoples Bank - Bingiriya'),('7135','7135-173','Peoples Bank - Pundaluoya'),('7135','7135-174','Peoples Bank - Nugegoda'),('7135','7135-175','Peoples Bank - Kandana'),('7135','7135-176','Peoples Bank - Mid City Branch'),('7135','7135-177','Peoples Bank - Galenbindunuwewa'),('7135','7135-178','Peoples Bank - Maskeliya'),('7135','7135-179','Peoples Bank - Galnewa'),('7135','7135-180','Peoples Bank - Deraniyagala'),('7135','7135-181','Peoples Bank - Maha Oya'),('7135','7135-183','Peoples Bank - Ankumbura'),('7135','7135-184','Peoples Bank - Galgamuwa'),('7135','7135-185','Peoples Bank - Galigamuwa/Kegalle'),('7135','7135-186','Peoples Bank - Hatton'),('7135','7135-188','Peoples Bank - Ahangama'),('7135','7135-189','Peoples Bank - Uhana'),('7135','7135-190','Peoples Bank - Kaluwanchikudy'),('7135','7135-191','Peoples Bank - MAlwana'),('7135','7135-192','Peoples Bank - Nivithigala'),('7135','7135-193','Peoples Bank - Ridigama'),('7135','7135-194','Peoples Bank - Kolonnawa'),('7135','7135-195','Peoples Bank - Haldummulla'),('7135','7135-196','Peoples Bank - Kaduwela'),('7135','7135-197','Peoples Bank - Uragasmanhandiya'),('7135','7135-198','Peoples Bank - Mirigama'),('7135','7135-199','Peoples Bank - Mawathagama'),('7135','7135-200','Peoples Bank - Majestic City'),('7135','7135-201','Peoples Bank - Ukuwela'),('7135','7135-202','Peoples Bank - Kirindiwela'),('7135','7135-203','Peoples Bank - Habarana'),('7135','7135-204','Peoples Bank - Head quarters Branch'),('7135','7135-205','Peoples Bank - Angunakolapalessa'),('7135','7135-206','Peoples Bank - Davulagala'),('7135','7135-207','Peoples Bank - Ibbagamuwa'),('7135','7135-208','Peoples Bank - Battaramulla'),('7135','7135-209','Peoples Bank - Boralanda'),('7135','7135-210','Peoples Bank - Kollupi.Co-op House'),('7135','7135-211','Peoples Bank - Pnwila'),('7135','7135-214','Peoples Bank - Mutuwal'),('7135','7135-215','Peoples Bank - Madampe'),('7135','7135-216','Peoples Bank - Haputale'),('7135','7135-217','Peoples Bank - Mahara'),('7135','7135-218','Peoples Bank - Horowpathana'),('7135','7135-219','Peoples Bank - Thambuttegama'),('7135','7135-220','Peoples Bank - Anuradhapura,Nuwarawewa'),('7135','7135-221','Peoples Bank - Hemmathagama'),('7135','7135-222','Peoples Bank - Wattala'),('7135','7135-223','Peoples Bank - Karaitivu'),('7135','7135-224','Peoples Bank - Thirukkovil'),('7135','7135-225','Peoples Bank - Haliela'),('7135','7135-226','Peoples Bank - Kurune.Maliyadeva Br'),('7135','7135-227','Peoples Bank - Chenkalady'),('7135','7135-228','Peoples Bank - Addalachena'),('7135','7135-229','Peoples Bank - Hanwella'),('7135','7135-230','Peoples Bank - Thanamalwila'),('7135','7135-231','Peoples Bank - Medirigiriya'),('7135','7135-232','Peoples Bank - Polonnaruwa Town'),('7135','7135-233','Peoples Bank - Serunuwara'),('7135','7135-234','Peoples Bank - Batapola'),('7135','7135-235','Peoples Bank - kalawana'),('7135','7135-236','Peoples Bank - Maradana'),('7135','7135-237','Peoples Bank - Kiribathgoda'),('7135','7135-238','Peoples Bank - Gonagaldeniya'),('7135','7135-239','Peoples Bank - Ja-Ela'),('7135','7135-240','Peoples Bank - Keppetipola'),('7135','7135-241','Peoples Bank - Pallepola'),('7135','7135-242','Peoples Bank -Bakamuna'),('7135','7135-243','Peoples Bank - Devinueara'),('7135','7135-244','Peoples Bank - Beliatta'),('7135','7135-245','Peoples Bank - Godakawela'),('7135','7135-246','Peoples Bank - Meegalewa'),('7135','7135-247','Peoples Bank - Imaduwa'),('7135','7135-248','Peoples Bank - Aranayaka'),('7135','7135-249','Peoples Bank - Neboda'),('7135','7135-250','Peoples Bank - kandeketiya'),('7135','7135-251','Peoples Bank - Lunugala'),('7135','7135-252','Peoples Bank - Bulathkohupitiya'),('7135','7135-253','Peoples Bank - Aralaganwila'),('7135','7135-254','Peoples Bank - Welikanda'),('7135','7135-255','Peoples Bank - Trincomalee Town'),('7135','7135-256','Peoples Bank - Pilimatalawa'),('7135','7135-257','Peoples Bank - Deltota'),('7135','7135-258','Peoples Bank - Medagama'),('7135','7135-259','Peoples Bank - Kehelwatte'),('7135','7135-260','Peoples Bank - Koslanda'),('7135','7135-261','Peoples Bank - Pelawatte'),('7135','7135-262','Peoples Bank - Wadduwa'),('7135','7135-263','Peoples Bank - Kuruvita'),('7135','7135-264','Peoples Bank - Suriyawewa'),('7135','7135-265','Peoples Bank - Middeniya'),('7135','7135-266','Peoples Bank - Kiriella'),('7135','7135-267','Peoples Bank - Anamaduwa'),('7135','7135-268','Peoples Bank - Girandurukotte'),('7135','7135-269','Peoples Bank - Badulla-Muthiyangana'),('7135','7135-270','Peoples Bank - Thulhiriya'),('7135','7135-271','Peoples Bank - Urubokka'),('7135','7135-272','Peoples Bank - Talgaswala'),('7135','7135-273','Peoples Bank - Kadawata'),('7135','7135-274','Peoples Bank - pussellawa'),('7135','7135-275','Peoples Bank - Olcott Mawatha'),('7135','7135-276','Peoples Bank - Katunayaka'),('7135','7135-277','Peoples Bank - Sea Street'),('7135','7135-278','Peoples Bank - Nittambuwa'),('7135','7135-279','Peoples Bank - Pitakotte'),('7135','7135-280','Peoples Bank - Pothuhera'),('7135','7135-281','Peoples Bank - Kobeigane'),('7135','7135-282','Peoples Bank - Maggona'),('7135','7135-283','Peoples Bank - Badureliya'),('7135','7135-284','Peoples Bank - Jaffna Kannathiddy'),('7135','7135-285','Peoples Bank - Point Pedro'),('7135','7135-286','Peoples Bank - International Div.'),('7135','7135-288','Peoples Bank - Kudawella'),('7135','7135-289','Peoples Bank - Kaltota'),('7135','7135-290','Peoples Bank - Moratumulla'),('7135','7135-291','Peoples Bank - Dankotuwa'),('7135','7135-292','Peoples Bank - Udapussellawa'),('7135','7135-293','Peoples Bank - Dehiovita'),('7135','7135-294','Peoples Bank - Alawatugoda'),('7135','7135-295','Peoples Bank - Udawalawe'),('7135','7135-296','Peoples Bank - Nintavur'),('7135','7135-297','Peoples Bank - Dam Street'),('7135','7135-298','Peoples Bank - Ginthupitiya'),('7135','7135-299','Peoples Bank - Kegalle Bazzar'),('7135','7135-300','Peoples Bank - Ingiriya'),('7135','7135-301','Peoples Bank - Galkiriyagama'),('7135','7135-302','Peoples Bank - Ginigathhena'),('7135','7135-303','Peoples Bank - Mahawewa'),('7135','7135-304','Peoples Bank - Urugamuwa'),('7135','7135-305','Peoples Bank - Trinco Inner Harbour'),('7135','7135-306','Peoples Bank - Maharagama'),('7135','7135-307','Peoples Bank - Gandara'),('7135','7135-308','Peoples Bank - Kotahena'),('7135','7135-309','Peoples Bank - Liberty Plaza'),('7135','7135-310','Peoples Bank - Bambalapitiya'),('7135','7135-311','Peoples Bank - Beruwala'),('7135','7135-312','Peoples Bank - Malwatta Road'),('7135','7135-313','Peoples Bank - Katubedda'),('7135','7135-315','Peoples Bank - Talawa'),('7135','7135-316','Peoples Bank - Ragama'),('7135','7135-317','Peoples Bank - Ratnapura Town'),('7135','7135-318','Peoples Bank - Pamunugama'),('7135','7135-319','Peoples Bank - Kirulapana'),('7135','7135-320','Peoples Bank - Borella Cotta Road'),('7135','7135-321','Peoples Bank - Panadura Town'),('7135','7135-322','Peoples Bank - Marawila'),('7135','7135-323','Peoples Bank - Corporate Branch'),('7135','7135-324','Peoples Bank - Seeduwa'),('7135','7135-325','Peoples Bank - Wandurambe'),('7135','7135-326','Peoples Bank - Capricon Branch'),('7135','7135-327','Peoples Bank - Kesbewa'),('7135','7135-328','Peoples Bank - kottawa'),('7135','7135-329','Peoples Bank - Koggala'),('7135','7135-330','Peoples Bank - Dehiattakandiya'),('7135','7135-331','Peoples Bank - Lucky Plaza'),('7135','7135-332','Peoples Bank - Ganemulla'),('7135','7135-333','Peoples Bank - Ykkala'),('7135','7135-334','Peoples Bank - Kgala-Ethugalpura'),('7135','7135-335','Peoples Bank - Nugegoda City'),('7135','7135-336','Peoples Bank - Mt.Lavinia'),('7135','7135-337','Peoples Bank - Dehiwala'),('7135','7135-338','Peoples Bank - Sainthamaruthu'),('7135','7135-339','Peoples Bank - Kallar'),('7135','7135-340','Peoples Bank - Oddamawady'),('7135','7135-666','Peoples Bank - Poojapitiya'),('7135','7135-796','Peoples Bank - OCU'),('7162','7162-','Nation Trust - Colombo'),('7162','7162-001','Nation Trust - Colombo'),('7162','7162-004','Nation Trust - Colombo 2'),('7162','7162-007','Nation Trust - Colombo2'),('7162','7162-012','Nation Trust - Kurunegala'),('7162','7162-017','Nation Trust - Colombo'),('7162','7162-025','Nation Trust - Union Place'),('7162','7162-026','Nation Trust -'),('7162','7162-028','Nation Trust - Colombo 2'),('7162','7162-029','Nation Trust - Colombo 2'),('7162','7162-031','Nation Trust - Colombo 2'),('7162','7162-034','Nation Trust - Colombo'),('7214','7214-000','NDB - Head Office'),('7214','7214-001','NDB - Nawam Mawatha'),('7214','7214-002','NDB - Kandy'),('7214','7214-003','NDB - Jawatta'),('7214','7214-004','NDB - Nugegoda'),('7214','7214-005','NDB - Rajagiriya'),('7214','7214-006','NDB - Matara'),('7214','7214-007','NDB - Kurunegala'),('7214','7214-008','NDB - Wellawatta'),('7214','7214-009','NDB - Negombo'),('7214','7214-010','NDB - Chilaw'),('7214','7214-011','NDB - Wattala'),('7214','7214-012','NDB - Maharagama'),('7214','7214-013','NDB - Ratnapura'),('7214','7214-014','NDB - Colombo 03'),('7214','7214-015','NDB - Moratuwa'),('7214','7214-016','NDB - Kalutara'),('7214','7214-017','NDB - Kegalle'),('7214','7214-018','NDB - Badulla'),('7214','7214-019','NDB - Anuradhapura'),('7214','7214-020','NDB - Mt.Lavinia'),('7214','7214-021','NDB - Galle'),('7214','7214-022','NDB - Pelawatta'),('7214','7214-023','NDB - Piliyandala'),('7214','7214-024','NDB - Kotahena'),('7214','7214-025','NDB - Kiribathgoda'),('7214','7214-026','NDB - Kadawatha'),('7214','7214-027','NDB - Horana'),('7214','7214-028','NDB - Kandana'),('7214','7214-029','NDB - Gampaha'),('7214','7214-030','NDB - Homagama'),('7214','7214-031','NDB - Malabe'),('7214','7214-033','NDB - Puttalam'),('7214','7214-038','NDB - Trincomalee'),('7214','7214-039','NDB - Colombo'),('7214','7214-040','NDB - Colombo'),('7214','7214-100','NDB - Head Office (Retail)'),('7214','7214-21','NDB - Galle'),('7214','7214-900','NDB - Head Office (CO-op)'),('7269','7269-','Islamic Bank -'),('7269','7269-004','Islamic Bank - Colombo'),('7269','7269-006','Islamic Bank - Colombo'),('7278','7278-','Sampath Bank - Batticoloa'),('7278','7278-001','Sampath Bank - City Office'),('7278','7278-002','Sampath Bank - Pettah'),('7278','7278-003','Sampath Bank - Nugegoda'),('7278','7278-004','Sampath Bank - Borella'),('7278','7278-005','Sampath Bank - Kiribathgoda'),('7278','7278-006','Sampath Bank - Kurunegala'),('7278','7278-007','Sampath Bank - Kandy'),('7278','7278-008','Sampath Bank - Wattala'),('7278','7278-009','Sampath Bank - Navam Mawatha'),('7278','7278-010','Sampath Bank - Matara'),('7278','7278-011','Sampath Bank - Bambalapitiya'),('7278','7278-012','Sampath Bank - Fort'),('7278','7278-013','Sampath Bank - Maharagama'),('7278','7278-014','Sampath Bank - Deniyaya'),('7278','7278-015','Sampath Bank - Morawaka'),('7278','7278-016','Sampath Bank - Gampaha'),('7278','7278-017','Sampath Bank - Dehiwala'),('7278','7278-018','Sampath Bank - Ratmalana'),('7278','7278-019','Sampath Bank - Piliyandala'),('7278','7278-020','Sampath Bank - Eheliyagoda'),('7278','7278-021','Sampath Bank - Anuradhapura'),('7278','7278-022','Sampath Bank - Avissawella'),('7278','7278-023','Sampath Bank - Kuliyapitiya'),('7278','7278-024','Sampath Bank - Negombo'),('7278','7278-025','Sampath Bank - Matale'),('7278','7278-026','Sampath Bank - Panadura'),('7278','7278-027','Sampath Bank - Old Moor Street'),('7278','7278-028','Sampath Bank - Thissamaharama'),('7278','7278-029','Sampath Bank - Head Quarters'),('7278','7278-030','Sampath Bank - Wennappuwa'),('7278','7278-031','Sampath Bank - Moratuwa'),('7278','7278-032','Sampath Bank - Katugasthota'),('7278','7278-033','Sampath Bank - Rathnapura'),('7278','7278-034','Sampath Bank - Thimbirigasyaya'),('7278','7278-035','Sampath Bank - Galle'),('7278','7278-036','Sampath Bank - Wellawatta'),('7278','7278-037','Sampath Bank - Kotahena'),('7278','7278-038','Sampath Bank - Kaduruwela'),('7278','7278-039','Sampath Bank - Malabe'),('7278','7278-040','Sampath Bank - Narahenpita'),('7278','7278-041','Sampath Bank - Lakawana'),('7278','7278-042','Sampath Bank - Main Street'),('7278','7278-043','Sampath Bank - Embilipitiya'),('7278','7278-044','Sampath Bank - Wariyapola'),('7278','7278-045','Sampath Bank - Wellampitiya'),('7278','7278-046','Sampath Bank - Bandarawela'),('7278','7278-047','Sampath Bank - Unichela'),('7278','7278-048','Sampath Bank - Thambuttegama (SPU)'),('7278','7278-049','Sampath Bank - Deraniyagala'),('7278','7278-050','Sampath Bank - Kalutara'),('7278','7278-051','Sampath Bank - Peradeniya'),('7278','7278-052','Sampath Bank - Kottawa'),('7278','7278-053','Sampath Bank - Alawwe'),('7278','7278-054','Sampath Bank - Neluwa'),('7278','7278-055','Sampath Bank - Vavuniya'),('7278','7278-056','Sampath Bank - Mahiyanganaya'),('7278','7278-057','Sampath Bank - Horana'),('7278','7278-058','Sampath Bank - Harbour-View'),('7278','7278-059','Sampath Bank - Bandaragama'),('7278','7278-060','Sampath Bank - Kadawatha'),('7278','7278-061','Sampath Bank - Battaramulla'),('7278','7278-062','Sampath Bank - Ampara'),('7278','7278-063','Sampath Bank - Pelawatta (SPU)'),('7278','7278-064','Sampath Bank - Kegalle'),('7278','7278-065','Sampath Bank - Minuwangoda'),('7278','7278-066','Sampath Bank - Trincomalee'),('7278','7278-067','Sampath Bank - Athurugiriya (SPU)'),('7278','7278-068','Sampath Bank - Yakkala'),('7278','7278-069','Sampath Bank - Homagama'),('7278','7278-070','Sampath Bank - Gregorys Road'),('7278','7278-071','Sampath Bank - Nittambuwa'),('7278','7278-072','Sampath Bank - Ambalangoada'),('7278','7278-073','Sampath Bank - Ragama'),('7278','7278-074','Sampath Bank - Monaragala'),('7278','7278-075','Sampath Bank - Wadduwa'),('7278','7278-076','Sampath Bank - Kandana'),('7278','7278-077','Sampath Bank - Veyangoda'),('7278','7278-078','Sampath Bank - Ganemulla'),('7278','7278-079','Sampath Bank - Aluthgama'),('7278','7278-080','Sampath Bank - Hatton'),('7278','7278-081','Sampath Bank - Welimada'),('7278','7278-082','Sampath Bank - Singer Mega-Nugegoda'),('7278','7278-083','Sampath Bank - Kirindiwela'),('7278','7278-084','Sampath Bank - Nuwara Eliya'),('7278','7278-085','Sampath Bank - Digana'),('7278','7278-086','Sampath Bank - Mirigama'),('7278','7278-087','Sampath Bank - Laugfs Super Market'),('7278','7278-088','Sampath Bank - Singer Mega - Negombo'),('7278','7278-089','Sampath Bank - Attidiya'),('7278','7278-090','Sampath Bank - Dambulla'),('7278','7278-091','Sampath Bank - Pitakotte'),('7278','7278-092','Sampath Bank - Singer Mega-Maharagama'),('7278','7278-093','Sampath Bank - Badulla'),('7278','7278-094','Sampath Bank - Kohuwala'),('7278','7278-095','Sampath Bank - Girulla'),('7278','7278-096','Sampath Bank - Singer Mega-Wattala'),('7278','7278-097','Sampath Bank - Balangoda'),('7278','7278-098','Sampath Bank - JA-Ela'),('7278','7278-099','Sampath Bank - Narammala'),('7278','7278-100','Sampath Bank - Corporate Branch-Kandy'),('7278','7278-102','Sampath Bank -'),('7278','7278-103','Sampath Bank - Pelmadulla'),('7278','7278-104','Sampath Bank - Ambalantota'),('7278','7278-106','Sampath Bank - Mathugama'),('7278','7278-107','Sampath Bank - Batticoloa'),('7278','7278-109','Sampath Bank - Mawathagama'),('7278','7278-110','Sampath Bank - Hingurakgoda'),('7278','7278-111','Sampath Bank - Akkaraipattu'),('7278','7278-112','Sampath Bank - Kalmunai'),('7278','7278-114','Sampath Bank - Embuldeniya'),('7278','7278-115','Sampath Bank - Kattankudy'),('7278','7278-118','Sampath Bank - Baddegama'),('7278','7278-121','Sampath Bank - Chenkalady'),('7278','7278-124','Sampath Bank - Oddamavady'),('7278','7278-125','Sampath Bank - Kattankudy'),('7278','7278-126','Sampath Bank - Sainthamaruthu'),('7278','7278-130','Sampath Bank - Pottuvil'),('7278','7278-135','Sampath Bank - Gangodawila'),('7278','7278-138','Sampath Bank - Nocchiyagama'),('7278','7278-140','Sampath Bank - Ingiriya'),('7278','7278-143','Anamaduwa'),('7278','7278-145','Sampath Bank - buttala'),('7278','7278-149','Sampath Bank - Kekirawa'),('7278','7278-150','Sampath Bank - Pilimatalawa'),('7278','7278-152','Sampath Bank - Pussellawa'),('7278','7278-153','Sampath Bank - Matara Bazar'),('7278','7278-154','Sampath Bank - Aralaganwila'),('7278','7278-156','Sampath Bank - Puttalam'),('7278','7278-157','Sampath Bank - Sooriyawewa'),('7278','7278-159','Sampath Bank - Galle Bazaar'),('7278','7278-160','Sampath Bank -'),('7278','7278-161','Sampath Bank - Bibile'),('7278','7278-167','Sampath Bank - Sandunpura'),('7278','7278-168','Sampath Bank -'),('7278','7278-187','Sampath Bank - Hettipola'),('7278','7278-188','Sampath Bank - Rambukkana'),('7278','7278-920','Sampath Bank - Trade Services Dept.'),('7278','7278-993','Sampath Bank - Central Clearing Dept'),('7278','7278-996','Sampath Bank - Card Centre'),('7287','7287-001','Seylan Bank - City Office'),('7287','7287-002','Seylan Bank - Matara'),('7287','7287-003','Seylan Bank - Mount Lavinia'),('7287','7287-004','Seylan Bank - Maharagama'),('7287','7287-005','Seylan Bank - Panadura'),('7287','7287-006','Seylan Bank - Kiribathgoda'),('7287','7287-007','Seylan Bank - Ratnapura'),('7287','7287-008','Seylan Bank - Kollupitiya'),('7287','7287-009','Seylan Bank - Moratuwa'),('7287','7287-010','Seylan Bank - Kegalle'),('7287','7287-011','Seylan Bank - Gampaha'),('7287','7287-012','Seylan Bank - Nugegoda'),('7287','7287-013','Seylan Bank - Negombo'),('7287','7287-014','Seylan Bank - Dehiwala'),('7287','7287-015','Seylan Bank - Chilaw'),('7287','7287-016','Seylan Bank - Galle'),('7287','7287-017','Seylan Bank - Kandy'),('7287','7287-018','Seylan Bank - Kurunegala'),('7287','7287-019','Seylan Bank - Nuwara Eliya'),('7287','7287-020','Seylan Bank - Balangoda'),('7287','7287-021','Seylan Bank - Anuradhapura'),('7287','7287-022','Seylan Bank - Grandpass'),('7287','7287-023','Seylan Bank - Horana'),('7287','7287-024','Seylan Bank - Ambalangoda'),('7287','7287-025','Seylan Bank - Gampola'),('7287','7287-026','Seylan Bank - Badulla'),('7287','7287-027','Seylan Bank - Ja-Ela'),('7287','7287-028','Seylan Bank - Kadawatha'),('7287','7287-029','Seylan Bank - Dehiattakandiya'),('7287','7287-030','Seylan Bank - (BCCI) U. Chatam St. Br'),('7287','7287-031','Seylan Bank - (BCCI) Free Trade Zone'),('7287','7287-032','Seylan Bank - Cinnamon Gardens'),('7287','7287-033','Seylan Bank - Kottawa'),('7287','7287-034','Seylan Bank - Boralesgamuwa'),('7287','7287-035','Seylan Bank - Yakkala'),('7287','7287-036','Seylan Bank - Kalutara'),('7287','7287-037','Seylan Bank - Thissamaharama'),('7287','7287-038','Seylan Bank - Matale'),('7287','7287-039','Seylan Bank - Hatton'),('7287','7287-040','Seylan Bank - Sarikkamulla'),('7287','7287-041','Seylan Bank - Attidiya'),('7287','7287-042','Seylan Bank - Kalubowila'),('7287','7287-043','Seylan Bank - Homagama'),('7287','7287-044','Seylan Bank - Kuliyapitiya'),('7287','7287-045','Seylan Bank - Embilipitiya'),('7287','7287-046','Seylan Bank - Bandarawela'),('7287','7287-047','Seylan Bank - Maradana'),('7287','7287-048','Seylan Bank - Mawanella'),('7287','7287-049','Seylan Bank - Puttalam'),('7287','7287-050','Seylan Bank - Old Moor Street'),('7287','7287-051','Seylan Bank - Higurakgoda'),('7287','7287-052','Seylan Bank - Nawalla'),('7287','7287-053','Seylan Bank - Manampitiya'),('7287','7287-054','Seylan Bank - Bandaragama'),('7287','7287-055','Seylan Bank - Katuneriya'),('7287','7287-056','Seylan Bank - Kaggala'),('7287','7287-057','Seylan Bank - Welimada'),('7287','7287-058','Seylan Bank - Kochchikade'),('7287','7287-059','Seylan Bank - Bogawanthalawa'),('7287','7287-060','Seylan Bank - Ganemulla'),('7287','7287-061','Seylan Bank - Thalawakele'),('7287','7287-062','Seylan Bank - Raddolugama'),('7287','7287-063','Seylan Bank - Weliveriya'),('7287','7287-064','Seylan Bank - Pettah'),('7287','7287-065','Seylan Bank - Baliatta'),('7287','7287-066','Seylan Bank - Mathugama'),('7287','7287-067','Seylan Bank - Malabe'),('7287','7287-068','Seylan Bank - Colombo South'),('7287','7287-070','Seylan Bank - Warakapola'),('7287','7287-071','Seylan Bank - Wattala'),('7287','7287-072','Seylan Bank - Vavuniya'),('7287','7287-073','Seylan Bank - Batticaloa'),('7287','7287-074','Seylan Bank - Kaththankudy'),('7287','7287-075','Seylan Bank - Avissawella'),('7287','7287-076','Seylan Bank - Nawalapitiya'),('7287','7287-077','Seylan Bank - Kekirawa'),('7287','7287-078','Seylan Bank - Mirigama'),('7287','7287-079','Seylan Bank - Soysapura'),('7287','7287-080','Seylan Bank - Ruwanwella'),('7287','7287-081','Seylan Bank - Hambantota'),('7287','7287-082','Seylan Bank - Borella'),('7287','7287-083','Seylan Bank - Havelock Town'),('7287','7287-084','Seylan Bank - Marandagahamulla'),('7287','7287-085','Seylan Bank - Jaffna'),('7287','7287-086','Seylan Bank - Millenium'),('7287','7287-087','Seylan Bank - Nittambuwa'),('7287','7287-088','Seylan Bank - Trincomalee'),('7287','7287-089','Seylan Bank - Meegoda'),('7287','7287-090','Seylan Bank - Pelmadulla'),('7287','7287-091','Seylan Bank - Ampara'),('7287','7287-999','Seylan Bank - Other Branches'),('7302','7302-001','Union Bank - Colombo'),('7311','7311-001','PABC - Metro'),('7311','7311-002','PABC - Panchikawatta'),('7311','7311-003','PABC - Lollupitiya'),('7311','7311-004','PABC - Pettah'),('7311','7311-005','PABC - Kandy'),('7311','7311-006','PABC - Rajagiriya'),('7311','7311-007','PABC - Ratnapura'),('7311','7311-008','PABC - Nugegoda'),('7311','7311-009','PABC - Bambalapitiya'),('7311','7311-010','PABC - Negombo'),('7311','7311-011','PABC - Gampaha'),('7311','7311-012','PABC - Kurunegala'),('7311','7311-013','PABC - Matara'),('7311','7311-014','PABC - Kotahena'),('7311','7311-015','PABC - Dehiwala'),('7311','7311-016','PABC - Wattala'),('7311','7311-017','PABC - Panadura'),('7311','7311-018','PABC - Old Moor Street'),('7311','7311-019','PABC - Dam Street'),('7311','7311-020','PABC - Katugastota'),('7311','7311-021','PABC - Narahenpita'),('7311','7311-022','PABC - Kirulapone'),('7311','7311-023','PABC - Maharagama'),('7311','7311-024','PABC - Moratuwa'),('7311','7311-025','PABC - Galle'),('7311','7311-027','PABC - Kegalle'),('7311','7311-029','PABC - Wallawatta'),('7311','7311-032','PABC - Anuradhapura'),('7311','7311-033','PABC - Kalutara'),('7311','7311-035','PABC - Malabe'),('7311','7311-036','PABC - Chilaw'),('7311','7311-038','PABC - Embilipitiya'),('7311','7311-039','PABC - Matale'),('7311','7311-040','PABC - Batti'),('7311','7311-041','PABC - Ambalangoda'),('7311','7311-042','PABC - Kalmunai'),('7311','7311-043','PABC - Ambalangoda'),('7311','7311-045','PABC - Badulla'),('7384','7384-001','ICICI Bank - Colombo'),('7454','7454-001','DFCC Bank - Head Office'),('7454','7454-002','DFCC Bank - Gangodawila'),('7454','7454-003','DFCC Bank - Malabe'),('7454','7454-004','DFCC Bank - Matara'),('7454','7454-005','DFCC Bank - Kurunegala'),('7454','7454-006','DFCC Bank - Kandy'),('7454','7454-007','DFCC Bank - City Office'),('7454','7454-008','DFCC Bank - Ratnapura'),('7454','7454-009','DFCC Bank - Anuradhapura'),('7454','7454-010','DFCC Bank - Gampaha'),('7454','7454-011','DFCC Bank - Badulla'),('7454','7454-012','DFCC Bank - Borella'),('7454','7454-014','DFCC Bank - Kaduruwela'),('7454','7454-015','DFCC Bank - Kotahena'),('7454','7454-016','DFCC Bank - Maharagama'),('7454','7454-017','DFCC Bank - Bandarawela'),('7454','7454-018','DFCC Bank - Negombo'),('7454','7454-019','DFCC Bank - Kottawa'),('7454','7454-020','DFCC Bank - Dambulla'),('7454','7454-021','DFCC Bank - Wattala'),('7454','7454-022','DFCC Bank - Kuliyapitiya'),('7454','7454-023','DFCC Bank - Panadura'),('7454','7454-024','DFCC Bank - Piliyandala'),('7454','7454-025','DFCC Bank - Deniyaya'),('7454','7454-026','DFCC Bank - Lalutara'),('7454','7454-028','DFCC Bank - Nawala'),('7454','7454-031','DFCC Bank - Matale'),('7454','7454-032','DFCC Bank - Chilaw'),('7454','7454-034','DFCC Bank - Horana'),('7454','7454-035','DFCC Bank - Galle'),('7454','7454-036','DFCC Bank - Nuwaraeliya'),('7454','7454-037','DFCC Bank - KALAWANA'),('7454','7454-038','DFCC Bank - NAWALA'),('7454','7454-040','DFCC Bank - Batticaloa'),('7454','7454-041','DFCC Bank - Ampara'),('7454','7454-042','DFCC Bank - Jafna'),('7454','7454-044','DFCC Bank - Trinco'),('7454','7454-045','DFCC Bank - Embilipitiya'),('PV85220','001,002','Kandy Main School'),('PV85220','003','Kandy Hospital School'),('PV85220','004','Peradeniya Hospital School'),('PV85220','005','Ampitiya School');

/*Table structure for table `m_banks` */

DROP TABLE IF EXISTS `m_banks`;

CREATE TABLE `m_banks` (
  `code` varchar(10) NOT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_banks` */

insert  into `m_banks`(`code`,`bank_name`,`action_date`) values ('7010','Bank Of Ceylon','2012-02-17 09:24:52'),('7038','Standard Chartered Bank','2012-02-17 09:24:52'),('7047','City Bank','2012-02-17 09:24:52'),('7056','Commercial Bank','2012-02-17 09:24:52'),('7074','HBL','2012-02-17 09:24:52'),('7083','HNB','2012-02-17 09:24:52'),('7092','HSBC','2012-02-17 09:24:52'),('7135','Peoples Bank','2012-02-17 09:24:52'),('7162','Nation Trust','2012-02-17 09:24:52'),('7214','NDB','2012-02-17 09:24:52'),('7269','Islamic Bank','2012-02-17 09:24:52'),('7278','Sampath Bank','2012-02-17 09:24:52'),('7287','Seylan Bank','2012-02-17 09:24:52'),('7302','Union Bank','2012-02-17 09:24:52'),('7311','PABC','2012-02-17 09:24:52'),('7384','ICICI Bank','2012-02-17 09:24:52'),('7454','DFCC Bank','2012-02-17 09:24:52');

/*Table structure for table `m_company` */

DROP TABLE IF EXISTS `m_company`;

CREATE TABLE `m_company` (
  `Name` varchar(50) NOT NULL,
  `Address` varchar(200) NOT NULL,
  `TelNos` varchar(50) DEFAULT NULL,
  `FaxNos` varchar(50) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Actiondate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_company` */

insert  into `m_company`(`Name`,`Address`,`TelNos`,`FaxNos`,`Email`,`Actiondate`) values ('M3-ACCOUNT','','','','','2010-10-15 10:25:12');

/*Table structure for table `m_customer` */

DROP TABLE IF EXISTS `m_customer`;

CREATE TABLE `m_customer` (
  `code` varchar(15) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address01` varchar(255) NOT NULL,
  `address02` varchar(255) NOT NULL,
  `address03` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `outlet_name` varchar(255) NOT NULL,
  `phone01` varchar(10) NOT NULL,
  `phone02` varchar(10) NOT NULL,
  `phone03` varchar(10) NOT NULL,
  `root` varchar(10) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `b` int(11) DEFAULT NULL,
  `d` int(11) DEFAULT NULL,
  `g` int(11) DEFAULT NULL,
  `officer` decimal(10,2) DEFAULT '0.00',
  `company` decimal(10,2) DEFAULT '0.00',
  `margin` decimal(10,2) DEFAULT '0.00',
  `tx_r` tinyint(4) DEFAULT '0',
  `tx_no` varchar(25) DEFAULT NULL,
  `period` smallint(6) DEFAULT '0',
  `l1` decimal(10,2) DEFAULT '0.00',
  `l2` decimal(10,2) DEFAULT '0.00',
  `l3` decimal(10,2) DEFAULT '0.00',
  `sr_comment` text,
  `fc_comment` text,
  `ceo_comment` text,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`code`),
  KEY `root` (`root`),
  CONSTRAINT `m_customer_ibfk_1` FOREIGN KEY (`root`) REFERENCES `m_root` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_customer` */

insert  into `m_customer`(`code`,`name`,`address01`,`address02`,`address03`,`dob`,`outlet_name`,`phone01`,`phone02`,`phone03`,`root`,`email`,`b`,`d`,`g`,`officer`,`company`,`margin`,`tx_r`,`tx_no`,`period`,`l1`,`l2`,`l3`,`sr_comment`,`fc_comment`,`ceo_comment`,`action_date`) values ('ABC001','ABC','Puttalam Rd','Kurunegala','','2013-11-28','ABC Company','012112122','','','KURU-01','Email',NULL,NULL,NULL,'0.00','0.00','0.00',0,'0',30,'150000.00','250000.00','500000.00','','','','2013-11-28 03:39:59'),('CASH - 001','Mr.R.A.R.Premalal ','Sendiripitiya','Yanthampalawa','Kurunegala','2013-11-04','R A R Enterprises','0750651622','0375555666','','KURU-01','rarpremalal@gmail.com',NULL,NULL,NULL,'0.00','0.00','0.00',0,'0',7,'50000.00','75000.00','95000.00','Credit for more Than 10,000 Thousand  need MD approval.','OK','','2013-11-04 22:26:58'),('CASH002','Mrs. Dilrukshi Wijerathne','Pallepoththa','Aswedduma','Kurunegala','2013-11-13','Dilrukshi Wijerathne','0724408910','','','KURU-01','Email',NULL,NULL,NULL,'0.00','0.00','0.00',0,'0',30,'50000.00','85000.00','100000.00','','','','2013-11-13 02:22:28'),('CASH003','Mr.Punnyasiri','Kandy Road','Kurunegala','','2013-11-13','Punnyasiri','222222222','','','KURU-01','Email',NULL,NULL,NULL,'0.00','0.00','0.00',0,'0',30,'15000.00','25000.00','50000.00','','','','2013-11-13 03:39:58'),('CASH004','W A I H Deshapriya','75','Samanpura','Yaggapitiya','2013-11-13','W A I H Deshapriya','0718250811','','','KURU-01','Email',NULL,NULL,NULL,'0.00','0.00','0.00',0,'0',30,'15000.00','25000.00','50000.00','','','','2013-11-13 03:42:24'),('CASH005','T.H.Widanaarachchi','Hichchi Stores','Yanthampalawa','Kurunegala','2013-11-13','T.H.Widanaarachchi','0775320546','','','KURU-01','Email',NULL,NULL,NULL,'0.00','0.00','0.00',0,'0',30,'15000.00','25000.00','50000.00','','','','2013-11-13 03:45:26'),('CASH006','A S P Bandara','Ipalawa','Maspotha','','2013-11-13','A S P Bandara','0374908450','','','KURU-01','Email',NULL,NULL,NULL,'0.00','0.00','0.00',0,'0',30,'15000.00','25000.00','50000.00','','','','2013-11-13 03:47:11'),('CASH007','W G Amarasinghe','Pellandeniya','Demataluwa','Kurunegala','2013-11-13','W G Amarasinghe','02222222','','','KURU-01','Email',NULL,NULL,NULL,'0.00','0.00','0.00',0,'0',30,'15000.00','25000.00','50000.00','','','','2013-11-13 03:50:01'),('CASH008','S A Chamara Madusha','Saragama Stores','Saragama','Kurunegala','2013-11-13','S A Chamara Madusha','02222222','','','KURU-01','Email',NULL,NULL,NULL,'0.00','0.00','0.00',0,'0',30,'15000.00','25000.00','50000.00','','','','2013-11-13 03:57:35'),('CASH009','Sujeewa','Ilupitiya Wattha','Aswedduma','Kurunegala','2013-11-13','Sujeewa','022222222','','','KURU-01','Email',NULL,NULL,NULL,'0.00','0.00','0.00',0,'0',30,'15000.00','25000.00','50000.00','','','','2013-11-13 04:00:33'),('CASH010','A D M Thennakoon','No.40','Maspotha','Kurunegala','2013-11-20','A D M Thennakoon','0777242207','','','KURU-01','Email',NULL,NULL,NULL,'0.00','0.00','0.00',0,'0',30,'10000.00','50000.00','100000.00','','','','2013-11-20 20:58:49'),('CASH011','Mohinda Lal','Walpola','Banunapola','Kurunegala','2013-11-20','Mohinda Lal','077777777','','','KURU-01','Email',NULL,NULL,NULL,'0.00','0.00','0.00',0,'0',30,'10000.00','50000.00','100000.00','','','','2013-11-20 20:59:59'),('DINAPALA','Dinapala (Pvt) Ltd','Puttalam Road,','Kurunegala','','2013-04-01','Dinapala (Pvt) Ltd','02222222','','','KURU-01','Email',NULL,NULL,NULL,'0.00','0.00','0.00',0,'0',60,'150000.00','200000.00','250000.00','','','','2013-11-13 21:38:05');

/*Table structure for table `m_customer_contacts` */

DROP TABLE IF EXISTS `m_customer_contacts`;

CREATE TABLE `m_customer_contacts` (
  `code` varchar(15) DEFAULT NULL,
  `post` varchar(150) DEFAULT NULL,
  `number` varchar(15) DEFAULT NULL,
  KEY `code` (`code`),
  CONSTRAINT `m_customer_contacts_ibfk_1` FOREIGN KEY (`code`) REFERENCES `m_customer` (`code`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_customer_contacts` */

insert  into `m_customer_contacts`(`code`,`post`,`number`) values ('CASH - 001','R A R Premalal','0750651622');

/*Table structure for table `m_defult_account` */

DROP TABLE IF EXISTS `m_defult_account`;

CREATE TABLE `m_defult_account` (
  `cash_in_hand` varchar(200) DEFAULT NULL,
  `cheque_in_hand` varchar(200) DEFAULT NULL,
  `issued_cheque` varchar(200) DEFAULT NULL,
  `debtor_control` varchar(200) DEFAULT NULL,
  `creditor_control` varchar(200) DEFAULT NULL,
  `sales` varchar(200) DEFAULT NULL,
  `purchase` varchar(200) DEFAULT NULL,
  `discount` varchar(200) DEFAULT NULL,
  `purchase_return` varchar(200) DEFAULT NULL,
  `sales_return` varchar(200) DEFAULT NULL,
  `stock` varchar(100) DEFAULT '',
  `vat` varchar(100) DEFAULT NULL,
  `good_in_transist` varchar(100) DEFAULT NULL,
  `cost_of_sales` varchar(100) DEFAULT NULL,
  `customer_discount` varchar(100) DEFAULT NULL,
  `suspend` varchar(100) DEFAULT NULL,
  `advance` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_defult_account` */

insert  into `m_defult_account`(`cash_in_hand`,`cheque_in_hand`,`issued_cheque`,`debtor_control`,`creditor_control`,`sales`,`purchase`,`discount`,`purchase_return`,`sales_return`,`stock`,`vat`,`good_in_transist`,`cost_of_sales`,`customer_discount`,`suspend`,`advance`) values ('1300','1250','3815','1210','3810','4010','4510','5125','4520','4015','1200','','','6000','','7000','3870');

/*Table structure for table `m_defult_account_` */

DROP TABLE IF EXISTS `m_defult_account_`;

CREATE TABLE `m_defult_account_` (
  `cash_in_hand` varchar(200) DEFAULT NULL,
  `cheque_in_hand` varchar(200) DEFAULT NULL,
  `issued_cheque` varchar(200) DEFAULT NULL,
  `debtor_control` varchar(200) DEFAULT NULL,
  `creditor_control` varchar(200) DEFAULT NULL,
  `sales` varchar(200) DEFAULT NULL,
  `purchase` varchar(200) DEFAULT NULL,
  `discount` varchar(200) DEFAULT NULL,
  `purchase_return` varchar(200) DEFAULT NULL,
  `sales_return` varchar(200) DEFAULT NULL,
  `stock` varchar(100) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_defult_account_` */

insert  into `m_defult_account_`(`cash_in_hand`,`cheque_in_hand`,`issued_cheque`,`debtor_control`,`creditor_control`,`sales`,`purchase`,`discount`,`purchase_return`,`sales_return`,`stock`) values ('1300','1250','3815','1210','3810','4010','4510','','','4015','');

/*Table structure for table `m_department` */

DROP TABLE IF EXISTS `m_department`;

CREATE TABLE `m_department` (
  `code` varchar(10) NOT NULL,
  `description` varchar(255) NOT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_department` */

insert  into `m_department`(`code`,`description`,`action_date`) values ('FURN','Furniture','2013-11-04 22:27:40');

/*Table structure for table `m_desc_setup` */

DROP TABLE IF EXISTS `m_desc_setup`;

CREATE TABLE `m_desc_setup` (
  `code` varchar(15) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `oc` varchar(10) DEFAULT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `m_desc_setup` */

/*Table structure for table `m_email` */

DROP TABLE IF EXISTS `m_email`;

CREATE TABLE `m_email` (
  `femail` varchar(255) DEFAULT NULL,
  `email` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_email` */

/*Table structure for table `m_items` */

DROP TABLE IF EXISTS `m_items`;

CREATE TABLE `m_items` (
  `department` varchar(10) NOT NULL,
  `main_cat` varchar(10) NOT NULL,
  `sub_cat` varchar(10) NOT NULL,
  `code` varchar(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  `units` varchar(10) NOT NULL,
  `purchase_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cost_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `max_sales` decimal(10,2) DEFAULT '0.00',
  `re_order_level` decimal(10,2) DEFAULT '0.00',
  `re_order_quantity` decimal(10,2) DEFAULT '0.00',
  `is_measure` tinyint(4) DEFAULT '0',
  `is_active` tinyint(4) DEFAULT '0',
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `supplier` varchar(10) DEFAULT '',
  `is_ser_no` tinyint(4) DEFAULT '0',
  `is_main_item` tinyint(4) DEFAULT '0',
  `model` varchar(10) DEFAULT '',
  `brand` varchar(10) DEFAULT '',
  `iscons` tinyint(4) DEFAULT '0',
  `avg_price` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`code`),
  KEY `units_code` (`units`),
  KEY `main_category_code` (`main_cat`),
  KEY `sub_category_code` (`sub_cat`),
  KEY `department_code` (`department`),
  CONSTRAINT `m_items_ibfk_1` FOREIGN KEY (`department`) REFERENCES `m_department` (`code`),
  CONSTRAINT `m_items_ibfk_2` FOREIGN KEY (`main_cat`) REFERENCES `m_main_category` (`code`),
  CONSTRAINT `m_items_ibfk_3` FOREIGN KEY (`sub_cat`) REFERENCES `m_sub_category` (`code`),
  CONSTRAINT `m_items_ibfk_4` FOREIGN KEY (`units`) REFERENCES `m_units` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_items` */

insert  into `m_items`(`department`,`main_cat`,`sub_cat`,`code`,`description`,`units`,`purchase_price`,`cost_price`,`max_sales`,`re_order_level`,`re_order_quantity`,`is_measure`,`is_active`,`action_date`,`supplier`,`is_ser_no`,`is_main_item`,`model`,`brand`,`iscons`,`avg_price`) values ('FURN','PLA','COT','COTNO','Nova Coffee Table','001','0.00','0.00','0.00','6.00','6.00',0,1,'2013-11-04 23:32:44','ROYALDIS',0,0,'Nova','Nilkamal',0,'50.00'),('FURN','GLA','DIT','LATADI001','Dining Table (C-15) (1+6)','001','21750.00','30000.00','39500.00','10.00','10.00',0,1,'2013-11-27 23:35:07','LANIK',0,0,'','',0,'21750.00'),('FURN','GLA','DIT','LATADI002','Dining Table (C-10)(1+6)','001','21750.00','30000.00','41000.00','10.00','10.00',0,1,'2013-11-27 23:37:05','LANIK',0,0,'','',0,'19250.00'),('FURN','GLA','DIT','LATADI003','Dining Table (C-13)(1+6)','001','14500.00','20000.00','27500.00','10.00','10.00',0,1,'2013-11-27 23:38:34','LANIK',0,0,'','',0,'11000.00'),('FURN','SOFA','PVE','M3SOPVEINO311','Ino Sofa 3 + 1 + 1 ','001','29500.00','35500.00','45500.00','0.00','0.00',0,1,'2013-11-21 00:40:56','OSLMA',0,0,'','M3',0,'29500.00'),('FURN','WOOD','SOF','M3SOPVEKAN211','Kano Sofa 2 + 1 + 1','001','26800.00','29500.00','38750.00','2.00','2.00',0,1,'2013-11-05 00:03:53','OSLMA',0,0,'','',0,'26800.00'),('FURN','WOOD','SOF','M3SOPVEONM311','Onmo Sofa 3 + 1 + 1','001','32900.00','35400.00','54500.00','2.00','2.00',0,1,'2013-11-05 00:01:49','OSLMA',0,0,'','',0,'29365.82'),('FURN','WOOD','SOF','M3SOPVSSAT311','Satra Sofa 3 + 1 + 1 ','001','43900.00','49500.00','59750.00','2.00','2.00',0,1,'2013-11-04 23:59:03','OSLMA',0,0,'','',0,'35120.00'),('FURN','PLA','COT','PHONCOTA001','Phoenix Coffee Table','001','150.00','0.00','0.00','0.00','0.00',0,1,'2013-12-01 22:21:44','KPKOM',0,0,'','',0,'0.00'),('FURN','PLA','CHAIR','PHPLCH0006','Phoenix Vision Chair','001','960.00','1050.00','1750.00','24.00','24.00',0,1,'2013-11-13 04:16:00','KPKOM',0,0,'','Phoenix',0,'960.00'),('FURN','PLA','CHAIR','PHPLCH001','Phoenix Dainty Chair','001','670.00','770.00','970.00','24.00','24.00',0,1,'2013-11-20 20:03:27','KPKOM',0,0,'','Nilkamal',0,'812.00'),('FURN','PLA','CHAIR','PHPLCH005','Phoenix Milano Chair','001','787.00','1050.00','1450.00','24.00','24.00',0,1,'2013-11-27 23:20:37','KPKOM',0,0,'','Phoenix',0,'1250.00'),('FURN','PLA','CHAIR','RDPLCH001','Nilkamal Passion Chair','001','1262.80','1350.00','1750.00','24.00','24.00',0,1,'2013-11-20 20:05:52','ROYALDIS',0,0,'','Nilkamal',0,'1600.00'),('FURN','PLA','CHAIR','VICT','Nilkamal - Victor Chair','001','1262.80','1300.00','1650.00','30.00','36.00',0,1,'2013-11-04 23:30:18','ROYALDIS',0,0,'Victor','Nilkamal',0,'1450.00');

/*Table structure for table `m_main_category` */

DROP TABLE IF EXISTS `m_main_category`;

CREATE TABLE `m_main_category` (
  `code` varchar(10) NOT NULL,
  `description` varchar(255) NOT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_main_category` */

insert  into `m_main_category`(`code`,`description`,`action_date`) values ('GLA','Glass','2013-11-06 21:54:07'),('IRN','Iron','2013-11-06 21:56:53'),('MDF','MDF Products','2013-11-06 21:54:40'),('PLA','Plastic','2013-11-04 23:25:52'),('SOFA','Sofa Products','2013-11-06 21:56:03'),('STE','Steel','2013-11-06 21:56:20'),('WOOD','Wooden','2013-11-04 23:54:25');

/*Table structure for table `m_main_regon` */

DROP TABLE IF EXISTS `m_main_regon`;

CREATE TABLE `m_main_regon` (
  `code` varchar(10) NOT NULL,
  `description` varchar(255) NOT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_main_regon` */

insert  into `m_main_regon`(`code`,`description`,`action_date`) values ('01','COMMON','2012-10-27 04:56:14'),('NWP-KU-001','Kurunegala District','2013-11-04 21:56:47');

/*Table structure for table `m_payable_type` */

DROP TABLE IF EXISTS `m_payable_type`;

CREATE TABLE `m_payable_type` (
  `c_code` varchar(12) NOT NULL,
  `des` varchar(50) DEFAULT NULL,
  `payable_acc` varchar(10) DEFAULT NULL,
  `expe_acc` varchar(10) DEFAULT NULL,
  `type` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`c_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_payable_type` */

/*Table structure for table `m_payable_type_expenses` */

DROP TABLE IF EXISTS `m_payable_type_expenses`;

CREATE TABLE `m_payable_type_expenses` (
  `payable_type_code` varchar(12) NOT NULL,
  `acc_code` varchar(20) NOT NULL,
  `bc` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`payable_type_code`,`acc_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_payable_type_expenses` */

/*Table structure for table `m_person` */

DROP TABLE IF EXISTS `m_person`;

CREATE TABLE `m_person` (
  `code` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address01` varchar(255) NOT NULL,
  `address02` varchar(255) NOT NULL,
  `address03` varchar(255) NOT NULL,
  `phone01` varchar(10) NOT NULL,
  `phone02` varchar(10) NOT NULL,
  `phone03` varchar(10) NOT NULL,
  `type` int(11) NOT NULL,
  `dateOfJoin` date DEFAULT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`code`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_person` */

insert  into `m_person`(`code`,`name`,`address01`,`address02`,`address03`,`phone01`,`phone02`,`phone03`,`type`,`dateOfJoin`,`action_date`) values ('D-001','wr','ewr','ertet','ret','453','345','345',2,'2013-01-01','2013-01-24 15:40:22'),('MC-001','sfde','erter','ert','ert','43543','345','435',3,'2013-01-24','2013-01-24 15:38:51'),('TC-001','dfgdf','dfgdf','fdg','dfg','ret','rey','try',1,'2013-01-27','2013-01-28 10:53:37');

/*Table structure for table `m_root` */

DROP TABLE IF EXISTS `m_root`;

CREATE TABLE `m_root` (
  `code` varchar(10) NOT NULL,
  `description` varchar(255) NOT NULL,
  `area` varchar(10) NOT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`code`),
  KEY `area` (`area`),
  CONSTRAINT `m_root_ibfk_1` FOREIGN KEY (`area`) REFERENCES `m_area` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_root` */

insert  into `m_root`(`code`,`description`,`area`,`action_date`) values ('KURU-01','Kurunegala City  ','NWPKUTO','2013-11-04 22:02:04');

/*Table structure for table `m_sales_ref` */

DROP TABLE IF EXISTS `m_sales_ref`;

CREATE TABLE `m_sales_ref` (
  `code` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address01` varchar(255) NOT NULL,
  `address02` varchar(255) NOT NULL,
  `address03` varchar(255) NOT NULL,
  `phone01` varchar(10) NOT NULL,
  `phone02` varchar(10) NOT NULL,
  `phone03` varchar(10) NOT NULL,
  `type` int(11) NOT NULL,
  `dateOfJoin` date DEFAULT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`code`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_sales_ref` */

insert  into `m_sales_ref`(`code`,`name`,`address01`,`address02`,`address03`,`phone01`,`phone02`,`phone03`,`type`,`dateOfJoin`,`action_date`) values ('839335888V','Mr.Suresh','Wellawa','Kurunegala','','0770112305','','',0,'2013-04-01','2013-11-04 21:59:25');

/*Table structure for table `m_stores` */

DROP TABLE IF EXISTS `m_stores`;

CREATE TABLE `m_stores` (
  `code` varchar(10) NOT NULL,
  `description` varchar(255) NOT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_stores` */

insert  into `m_stores`(`code`,`description`,`action_date`) values ('KURU001','Show Room - Puttalam Road','2013-11-04 22:33:52');

/*Table structure for table `m_sub_category` */

DROP TABLE IF EXISTS `m_sub_category`;

CREATE TABLE `m_sub_category` (
  `main_cat` varchar(10) NOT NULL,
  `code` varchar(10) NOT NULL,
  `description` varchar(255) NOT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`code`),
  KEY `main_category_code` (`main_cat`),
  CONSTRAINT `m_sub_category_ibfk_1` FOREIGN KEY (`main_cat`) REFERENCES `m_main_category` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_sub_category` */

insert  into `m_sub_category`(`main_cat`,`code`,`description`,`action_date`) values ('PLA','CHAIR','Plastic Chair','2013-11-04 23:26:28'),('SOFA','CHFS','Standard Fabric Chaise','2013-11-06 22:06:54'),('MDF','CMT','Computer Table','2013-11-06 21:59:17'),('PLA','COT','Coffee Table ','2013-11-04 23:31:24'),('MDF','CSD','Corner Stand','2013-11-06 22:01:36'),('GLA','DIT','Dining Table','2013-11-06 21:57:45'),('MDF','IRT','Iron Table','2013-11-06 22:01:00'),('SOFA','LCS','Lather Cloth Sofa ','2013-11-06 22:07:58'),('MDF','OFC','Office Cupboard','2013-11-06 22:00:28'),('SOFA','PVE','Economy PVC Sofa','2013-11-06 22:03:18'),('SOFA','PVS','Standard PVC Sofa','2013-11-06 22:04:34'),('STE','SCMT','Steel Computer Table','2013-11-06 22:14:25'),('WOOD','SOF','Sofa ','2013-11-04 23:55:12'),('MDF','TSD','Telephone Stand','2013-11-06 22:02:12'),('MDF','WRT','Writing Table','2013-11-06 21:59:59');

/*Table structure for table `m_sub_item_list` */

DROP TABLE IF EXISTS `m_sub_item_list`;

CREATE TABLE `m_sub_item_list` (
  `main_item` varchar(10) NOT NULL,
  `sub_item_code` varchar(10) NOT NULL,
  `qty` decimal(12,2) DEFAULT NULL,
  `qty_carton` decimal(12,2) DEFAULT NULL,
  `foc` tinyint(1) DEFAULT '0',
  `action_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`main_item`,`sub_item_code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `m_sub_item_list` */

insert  into `m_sub_item_list`(`main_item`,`sub_item_code`,`qty`,`qty_carton`,`foc`,`action_date`) values ('LAGLCO 001','M3MFCS 001','1.00','6.00',1,'2013-02-22 12:44:46'),('LAGLCO 002','asd002','1.00','1.00',0,'2013-02-22 11:04:39'),('LAGLCO 001','LAGLCO 001','2.00','4.00',0,'2013-02-22 12:44:46'),('LAGLCO 001','LAGLCO 003','3.00','8.00',0,'2013-02-22 12:44:46'),('LAGLCO 001','LAGLCO 004','4.00','2.00',0,'2013-02-22 12:44:46'),('VICT','COTNO','1.00','0.00',1,'2013-11-04 23:36:42'),('PHPLCH0006','PHONCOTA00','4.00','0.00',1,'2013-12-01 22:22:29');

/*Table structure for table `m_sub_regon` */

DROP TABLE IF EXISTS `m_sub_regon`;

CREATE TABLE `m_sub_regon` (
  `code` varchar(10) NOT NULL,
  `description` varchar(255) NOT NULL,
  `main_region` varchar(10) NOT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`code`),
  KEY `main_region` (`main_region`),
  CONSTRAINT `m_sub_regon_ibfk_3` FOREIGN KEY (`main_region`) REFERENCES `m_main_regon` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_sub_regon` */

insert  into `m_sub_regon`(`code`,`description`,`main_region`,`action_date`) values ('01','COMMON','01','2012-10-27 04:56:54'),('KURU-TOWN','Kurunegala Town ','NWP-KU-001','2013-11-04 21:57:49');

/*Table structure for table `m_supplier` */

DROP TABLE IF EXISTS `m_supplier`;

CREATE TABLE `m_supplier` (
  `code` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `address01` varchar(255) NOT NULL,
  `address02` varchar(255) NOT NULL,
  `address03` varchar(255) NOT NULL,
  `phone01` varchar(10) NOT NULL,
  `phone02` varchar(10) NOT NULL,
  `phone03` varchar(10) NOT NULL,
  `sr_comment` text,
  `fc_comment` text,
  `ceo_comment` text,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_supplier` */

insert  into `m_supplier`(`code`,`name`,`full_name`,`address01`,`address02`,`address03`,`phone01`,`phone02`,`phone03`,`sr_comment`,`fc_comment`,`ceo_comment`,`action_date`) values ('KPKOM','K P K Oil Mils','K P K Oil Mils','Madawa Road','Pilessa','Kurunegala','0374926427','','','','','','2013-11-13 04:12:37'),('LANIK','Lanik Imports (Pvt) Ltd','Lanik Imports (Pvt) Ltd','Valagane ','Maspotha','Kurunegala','037000000','','','','','','2013-11-27 23:27:33'),('OSLMA','Oslo Marketing (Pvt) Ltd','Oslo Marketing (Pvt) Ltd','Valagane','Maspotha','Kurunegala','0377390690','0377390691','0377390691','Sofa Supplier','','','2013-11-04 23:53:30'),('ROYALDIS','Nilkamal Eswarn Plastics (Pvt) Ltd','Royal  Distributors','Kurunegala','','Kurunegala','0714414214','0372234115','0372234115','Supplier of Nilkamal Plastics','','','2013-11-04 22:11:52');

/*Table structure for table `m_supplier_contacts` */

DROP TABLE IF EXISTS `m_supplier_contacts`;

CREATE TABLE `m_supplier_contacts` (
  `code` varchar(15) DEFAULT NULL,
  `post` varchar(150) DEFAULT NULL,
  `number` varchar(15) DEFAULT NULL,
  KEY `code` (`code`),
  CONSTRAINT `m_supplier_contacts_ibfk_1` FOREIGN KEY (`code`) REFERENCES `m_supplier` (`code`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_supplier_contacts` */

insert  into `m_supplier_contacts`(`code`,`post`,`number`) values ('ROYALDIS','Sanjaya','0714414214'),('OSLMA','Mr.Mahendra','0744447700');

/*Table structure for table `m_transaction_entry` */

DROP TABLE IF EXISTS `m_transaction_entry`;

CREATE TABLE `m_transaction_entry` (
  `code` varchar(10) NOT NULL,
  `description` varchar(80) DEFAULT NULL,
  `category` varchar(10) NOT NULL,
  PRIMARY KEY (`code`,`category`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `m_transaction_entry` */

insert  into `m_transaction_entry`(`code`,`description`,`category`) values ('JOU ','Journal','CHQ_RE'),('SRV','Booking Services','P_INV'),('CRN','Credit Notes','CR_NOTE'),('DREC','Receipts to Bank (Direct)','GL_REC'),('DBN','Debit Notes','DR_NOTE'),('REC','Receipts (Normal)','GL_REC'),('DPAY','Payments by Bank (Direct)','GL_VOU'),('INV','Sale of Goods','R_INV'),('CON','Contra entry','JE'),('GRN','Goods Received Notes','P_INV'),('JOU ','Journal','JE'),('PAY','Payments by Us','GL_VOU'),('DPAY','Payments by Bank (Direct)','JE'),('DREC','Receipts to Bank (Direct)','JE'),('DJOU','Journal','CHQ_RE'),('DCON','Contra entry','JE'),('CON','Contra entry','GL_REC');

/*Table structure for table `m_transe_code` */

DROP TABLE IF EXISTS `m_transe_code`;

CREATE TABLE `m_transe_code` (
  `code` varchar(10) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `m_transe_code` */

insert  into `m_transe_code`(`code`,`description`) values ('CHQ_DEP','Cheque Deposit'),('CHQ_WR','Cheque Withdraw'),('CR','Cheque Return'),('GL_VOU','Voucher'),('GL_REC','Receipt'),('JE','Journal Entry'),('DR_NOTE','Debit Note'),('P_INV','Payable Invoice'),('R_INV','Recivable Invoice'),('CHQ_RE','Cheque Return'),('CR_NOTE','Credit Note');

/*Table structure for table `m_units` */

DROP TABLE IF EXISTS `m_units`;

CREATE TABLE `m_units` (
  `code` varchar(10) NOT NULL,
  `description` varchar(255) NOT NULL,
  `base_unit` varchar(10) DEFAULT NULL,
  `base_nos` int(11) DEFAULT NULL,
  `nos` int(11) DEFAULT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_units` */

insert  into `m_units`(`code`,`description`,`base_unit`,`base_nos`,`nos`,`action_date`) values ('001','NOS',NULL,NULL,NULL,'2012-10-25 04:34:28');

/*Table structure for table `options` */

DROP TABLE IF EXISTS `options`;

CREATE TABLE `options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auto_print` tinyint(1) DEFAULT '0',
  `autofill_receivable` tinyint(1) DEFAULT '0',
  `autofill_payable` tinyint(1) DEFAULT '0',
  `bc` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `options` */

/*Table structure for table `s_branches` */

DROP TABLE IF EXISTS `s_branches`;

CREATE TABLE `s_branches` (
  `code` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address01` varchar(255) DEFAULT NULL,
  `address02` varchar(255) DEFAULT NULL,
  `address03` varchar(255) DEFAULT NULL,
  `phone01` varchar(12) DEFAULT NULL,
  `phone02` varchar(12) DEFAULT NULL,
  `phone03` varchar(12) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `s_branches` */

insert  into `s_branches`(`code`,`name`,`address01`,`address02`,`address03`,`phone01`,`phone02`,`phone03`,`email`,`action_date`) values ('001','Kandy Main','BAMUNUPOLAWATTA','KUNDASALE','','081-4472555-','081-242022','081-2420435','soorya@slt.lk','0000-00-00 00:00:00'),('002','M3 Kurunegala','Kurunegala','','','037-225984','','','Email','2012-10-17 04:54:27');

/*Table structure for table `s_company` */

DROP TABLE IF EXISTS `s_company`;

CREATE TABLE `s_company` (
  `name` varchar(200) DEFAULT NULL,
  `address01` varchar(100) DEFAULT NULL,
  `address02` varchar(100) DEFAULT NULL,
  `address03` varchar(100) DEFAULT NULL,
  `phone01` varchar(12) DEFAULT NULL,
  `phone02` varchar(12) DEFAULT NULL,
  `phone03` varchar(12) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `s_company` */

insert  into `s_company`(`name`,`address01`,`address02`,`address03`,`phone01`,`phone02`,`phone03`,`email`) values ('M 3 Marketing (Pvt)Ltd','Kurunegala','','','0377451050','037-451305','037-xxxxxx','m3@sltnet.lk');

/*Table structure for table `s_reg` */

DROP TABLE IF EXISTS `s_reg`;

CREATE TABLE `s_reg` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `com_id` varchar(40) NOT NULL,
  `current_id` varchar(40) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '0',
  `req_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `req_by` varchar(10) DEFAULT NULL,
  `app_on` timestamp NULL DEFAULT NULL,
  `app_by` varchar(10) DEFAULT NULL,
  `des` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `s_reg` */

/*Table structure for table `s_tabs` */

DROP TABLE IF EXISTS `s_tabs`;

CREATE TABLE `s_tabs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(20) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `oc` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3527 DEFAULT CHARSET=latin1;

/*Data for the table `s_tabs` */

insert  into `s_tabs`(`id`,`ip`,`time`,`oc`) values (1,'127.0.0.1',1383277541,'1'),(2,'127.0.0.1',1383277548,'1'),(3,'127.0.0.1',1383277557,'1'),(4,'127.0.0.1',1383277560,'1'),(5,'127.0.0.1',1383277570,'1'),(6,'127.0.0.1',1383279428,'1'),(7,'127.0.0.1',1383279435,'1'),(8,'127.0.0.1',1383281018,'1'),(9,'127.0.0.1',1383281029,'1'),(10,'127.0.0.1',1383281190,'1'),(11,'127.0.0.1',1383281229,'1'),(12,'127.0.0.1',1383281399,'1'),(13,'127.0.0.1',1383281446,'1'),(14,'127.0.0.1',1383281486,'1'),(15,'127.0.0.1',1383281490,'1'),(16,'127.0.0.1',1383281510,'1'),(17,'127.0.0.1',1383281556,'1'),(18,'127.0.0.1',1383281955,'1'),(19,'127.0.0.1',1383281968,'1'),(20,'127.0.0.1',1383281974,'1'),(21,'127.0.0.1',1383281992,'1'),(22,'127.0.0.1',1383282017,'1'),(23,'127.0.0.1',1383282020,'1'),(24,'127.0.0.1',1383282024,'1'),(25,'127.0.0.1',1383282039,'1'),(26,'127.0.0.1',1383282043,'1'),(27,'127.0.0.1',1383283090,'1'),(28,'127.0.0.1',1383283843,'1'),(29,'124.43.17.58',1383284305,'1'),(30,'124.43.17.58',1383284365,'1'),(31,'124.43.17.58',1383284400,'1'),(32,'124.43.17.58',1383284539,'1'),(33,'124.43.17.58',1383284543,'1'),(34,'124.43.17.58',1383284570,'1'),(35,'124.43.17.58',1383284702,'1'),(36,'124.43.17.58',1383285770,'1'),(37,'124.43.17.58',1383285915,'1'),(38,'124.43.17.58',1383286021,'1'),(39,'124.43.17.58',1383286414,'1'),(40,'124.43.17.58',1383286438,'1'),(41,'124.43.17.58',1383286449,'1'),(42,'124.43.17.58',1383286466,'1'),(43,'124.43.17.58',1383286468,'1'),(44,'124.43.17.58',1383286470,'1'),(45,'124.43.17.58',1383286471,'1'),(46,'124.43.17.58',1383286475,'1'),(47,'124.43.17.58',1383286506,'1'),(48,'124.43.17.58',1383286647,'1'),(49,'124.43.17.58',1383286673,'1'),(50,'123.231.90.180',1383287775,'m3'),(51,'123.231.90.180',1383287844,'m3'),(52,'123.231.90.180',1383287874,'m3'),(53,'123.231.90.180',1383287896,'m3'),(54,'123.231.90.180',1383288035,'m3'),(55,'123.231.90.180',1383288214,'m3'),(56,'123.231.90.180',1383288358,'m3'),(57,'123.231.90.180',1383288565,'m3'),(58,'124.43.17.58',1383289817,'1'),(59,'123.231.90.180',1383288618,'m3'),(60,'123.231.90.180',1383288717,'m3'),(61,'123.231.90.180',1383288758,'m3'),(62,'123.231.90.180',1383288778,'m3'),(63,'123.231.90.180',1383288803,'m3'),(64,'123.231.90.180',1383288826,'m3'),(65,'123.231.90.180',1383289571,'m3'),(66,'123.231.90.180',1383289690,'m3'),(67,'123.231.90.180',1383290160,'m3'),(68,'124.43.17.58',1383293641,'1'),(69,'123.231.90.180',1383290359,'m3'),(70,'123.231.90.180',1383290387,'m3'),(71,'123.231.90.180',1383290394,'m3'),(72,'123.231.90.180',1383290403,'m3'),(73,'123.231.90.180',1383290425,'m3'),(74,'123.231.90.180',1383290732,'m3'),(75,'123.231.90.180',1383291025,'m3'),(76,'123.231.90.180',1383291286,'m3'),(77,'123.231.90.180',1383291310,'m3'),(78,'123.231.90.180',1383291325,'m3'),(79,'123.231.90.180',1383291462,'m3'),(80,'123.231.90.180',1383291687,'m3'),(81,'123.231.90.180',1383291724,'m3'),(82,'123.231.90.180',1383292044,'m3'),(83,'123.231.90.180',1383292060,'m3'),(84,'123.231.90.180',1383292083,'m3'),(85,'123.231.90.180',1383292162,'m3'),(86,'123.231.90.180',1383292251,'m3'),(87,'123.231.90.180',1383292329,'m3'),(88,'123.231.90.180',1383292426,'m3'),(89,'123.231.90.180',1383292441,'m3'),(90,'123.231.90.180',1383292542,'m3'),(91,'123.231.90.180',1383292550,'m3'),(92,'123.231.90.180',1383292763,'m3'),(93,'124.43.17.58',1383293731,'1'),(94,'124.43.17.58',1383293799,'1'),(95,'124.43.17.58',1383293847,'1'),(96,'124.43.17.58',1383294131,'1'),(97,'124.43.17.58',1383294407,'1'),(98,'124.43.17.58',1383294479,'1'),(99,'124.43.17.58',1383294532,'1'),(100,'124.43.17.58',1383294600,'1'),(101,'124.43.17.58',1383294694,'1'),(102,'123.231.90.180',1383294631,'m3'),(103,'123.231.90.180',1383294638,'m3'),(104,'124.43.17.58',1383294718,'1'),(105,'124.43.17.58',1383294822,'1'),(106,'124.43.17.58',1383294830,'1'),(107,'124.43.17.58',1383294905,'1'),(108,'124.43.17.58',1383295119,'1'),(109,'124.43.17.58',1383295070,'1'),(110,'124.43.17.58',1383295095,'1'),(111,'124.43.17.58',1383295162,'1'),(112,'124.43.17.58',1383295259,'1'),(113,'124.43.17.58',1383295320,'1'),(114,'124.43.17.58',1383296275,'1'),(115,'123.231.90.180',1383295965,'m3'),(116,'123.231.90.180',1383296578,'m3'),(117,'124.43.17.58',1383297035,'1'),(118,'123.231.90.180',1383297874,'m3'),(119,'124.43.17.58',1383297053,'1'),(120,'124.43.17.58',1383297062,'1'),(121,'124.43.17.58',1383297191,'1'),(122,'124.43.17.58',1383297548,'1'),(123,'124.43.17.58',1383297431,'1'),(124,'124.43.17.58',1383297574,'1'),(125,'124.43.17.58',1383297838,'1'),(126,'124.43.17.58',1383297952,'1'),(127,'124.43.17.58',1383297969,'1'),(128,'124.43.17.58',1383297975,'1'),(129,'124.43.17.58',1383298013,'1'),(130,'124.43.17.58',1383298028,'1'),(131,'124.43.17.58',1383298241,'1'),(132,'124.43.17.58',1383298349,'1'),(133,'124.43.17.58',1383298353,'1'),(134,'124.43.17.58',1383298357,'1'),(135,'124.43.17.58',1383299808,'1'),(136,'123.231.90.180',1383299804,'m3'),(137,'124.43.17.58',1383299832,'1'),(138,'123.231.90.180',1383300489,'m3'),(139,'124.43.17.58',1383299853,'1'),(140,'124.43.17.58',1383299885,'1'),(141,'124.43.17.58',1383299898,'1'),(142,'124.43.17.58',1383299942,'1'),(143,'124.43.17.58',1383305401,'1'),(144,'123.231.90.180',1383300499,'m3'),(145,'123.231.90.180',1383300515,'m3'),(146,'123.231.90.180',1383300551,'m3'),(147,'123.231.90.180',1383301091,'m3'),(148,'123.231.90.180',1383305308,'m3'),(149,'124.43.16.239',1383361565,'1'),(150,'124.43.16.239',1383361620,'1'),(151,'124.43.16.239',1383361659,'1'),(152,'124.43.16.239',1383361664,'1'),(153,'124.43.16.239',1383361677,'1'),(154,'124.43.16.239',1383361707,'1'),(155,'124.43.16.239',1383361752,'1'),(156,'124.43.16.239',1383361774,'1'),(157,'124.43.16.239',1383361800,'1'),(158,'124.43.16.239',1383361804,'1'),(159,'124.43.16.239',1383361816,'1'),(160,'124.43.16.239',1383378455,'1'),(161,'124.43.16.239',1383362864,'1'),(162,'124.43.16.239',1383362817,'1'),(163,'124.43.16.239',1383362827,'1'),(164,'124.43.16.239',1383362882,'1'),(165,'124.43.16.239',1383362885,'1'),(166,'124.43.16.239',1383363258,'1'),(167,'124.43.16.239',1383365537,'1'),(168,'124.43.16.239',1383372294,'1'),(169,'124.43.16.239',1383372951,'1'),(170,'123.231.82.4',1383372662,'1'),(171,'123.231.82.4',1383372753,'1'),(172,'123.231.82.4',1383372795,'1'),(173,'123.231.82.4',1383372802,'1'),(174,'123.231.82.4',1383372850,'1'),(175,'123.231.82.4',1383372856,'1'),(176,'123.231.82.4',1383372877,'1'),(177,'123.231.82.4',1383372979,'m3'),(178,'123.231.82.4',1383373009,'m3'),(179,'123.231.82.4',1383373071,'m3'),(180,'123.231.82.4',1383373091,'m3'),(181,'123.231.82.4',1383373098,'m3'),(182,'123.231.82.4',1383373148,'m3'),(183,'123.231.82.4',1383373160,'m3'),(184,'123.231.82.4',1383373412,'m3'),(185,'123.231.82.4',1383373428,'m3'),(186,'123.231.82.4',1383373433,'m3'),(187,'123.231.82.4',1383373690,'m3'),(188,'123.231.82.4',1383373723,'m3'),(189,'123.231.82.4',1383373728,'m3'),(190,'123.231.82.4',1383373901,'m3'),(191,'123.231.82.4',1383373999,'m3'),(192,'123.231.82.4',1383374014,'m3'),(193,'123.231.82.4',1383374030,'m3'),(194,'123.231.82.4',1383374053,'m3'),(195,'123.231.82.4',1383374103,'m3'),(196,'123.231.82.4',1383374170,'m3'),(197,'123.231.82.4',1383374174,'m3'),(198,'123.231.82.4',1383374181,'m3'),(199,'123.231.82.4',1383374190,'m3'),(200,'123.231.82.4',1383374371,'m3'),(201,'123.231.82.4',1383374439,'m3'),(202,'123.231.82.4',1383374457,'m3'),(203,'123.231.82.4',1383374461,'m3'),(204,'123.231.82.4',1383374677,'m3'),(205,'123.231.82.4',1383374718,'m3'),(206,'123.231.82.4',1383374781,'m3'),(207,'123.231.82.4',1383374818,'m3'),(208,'123.231.82.4',1383374840,'m3'),(209,'123.231.82.4',1383374871,'m3'),(210,'123.231.82.4',1383374920,'m3'),(211,'123.231.82.4',1383374961,'m3'),(212,'123.231.82.4',1383375138,'m3'),(213,'123.231.82.4',1383375160,'m3'),(214,'123.231.82.4',1383375167,'m3'),(215,'123.231.82.4',1383375183,'m3'),(216,'123.231.82.4',1383375219,'m3'),(217,'123.231.82.4',1383375251,'m3'),(218,'123.231.82.4',1383375255,'m3'),(219,'123.231.82.4',1383375383,'m3'),(220,'123.231.82.4',1383375394,'m3'),(221,'123.231.82.4',1383375513,'m3'),(222,'123.231.82.4',1383375544,'m3'),(223,'123.231.82.4',1383375592,'m3'),(224,'123.231.82.4',1383375703,'m3'),(225,'123.231.82.4',1383375724,'m3'),(226,'123.231.82.4',1383375766,'m3'),(227,'123.231.82.4',1383375771,'m3'),(228,'123.231.82.4',1383375817,'m3'),(229,'123.231.82.4',1383375840,'m3'),(230,'123.231.82.4',1383375938,'m3'),(231,'123.231.82.4',1383375950,'m3'),(232,'123.231.82.4',1383376044,'m3'),(233,'123.231.82.4',1383376138,'m3'),(234,'123.231.82.4',1383376183,'m3'),(235,'123.231.82.4',1383376250,'m3'),(236,'123.231.82.4',1383376292,'m3'),(237,'123.231.82.4',1383376366,'m3'),(238,'123.231.82.4',1383376450,'m3'),(239,'123.231.82.4',1383376471,'m3'),(240,'123.231.82.4',1383376479,'m3'),(241,'123.231.82.4',1383376518,'m3'),(242,'123.231.82.4',1383376522,'m3'),(243,'123.231.82.4',1383376531,'m3'),(244,'123.231.82.4',1383376538,'m3'),(245,'123.231.82.4',1383376588,'m3'),(246,'123.231.82.4',1383376623,'m3'),(247,'123.231.82.4',1383376632,'m3'),(248,'123.231.82.4',1383376739,'m3'),(249,'123.231.82.4',1383376784,'m3'),(250,'123.231.82.4',1383376792,'m3'),(251,'123.231.82.4',1383376835,'m3'),(252,'123.231.82.4',1383376896,'m3'),(253,'123.231.82.4',1383376914,'m3'),(254,'123.231.82.4',1383376984,'m3'),(255,'123.231.82.4',1383377008,'m3'),(256,'123.231.82.4',1383377057,'m3'),(257,'123.231.82.4',1383377063,'m3'),(258,'123.231.82.4',1383377156,'m3'),(259,'123.231.82.4',1383377178,'m3'),(260,'123.231.82.4',1383377360,'m3'),(261,'123.231.82.4',1383377483,'m3'),(262,'123.231.82.4',1383377487,'m3'),(263,'123.231.82.4',1383377541,'m3'),(264,'123.231.82.4',1383377548,'m3'),(265,'123.231.82.4',1383377555,'m3'),(266,'123.231.82.4',1383377586,'m3'),(267,'123.231.82.4',1383377590,'m3'),(268,'123.231.82.4',1383377676,'m3'),(269,'123.231.82.4',1383377681,'m3'),(270,'123.231.82.4',1383377848,'m3'),(271,'123.231.82.4',1383378011,'m3'),(272,'123.231.82.4',1383378035,'m3'),(273,'123.231.82.4',1383378065,'m3'),(274,'123.231.82.4',1383378087,'m3'),(275,'123.231.82.4',1383378113,'m3'),(276,'123.231.82.4',1383378133,'m3'),(277,'123.231.82.4',1383378174,'m3'),(278,'123.231.82.4',1383378198,'m3'),(279,'123.231.82.4',1383378469,'m3'),(280,'123.231.82.4',1383379767,'m3'),(281,'124.43.17.27',1383539212,'1'),(282,'127.0.0.1',1383540031,'1'),(283,'127.0.0.1',1383540172,'1'),(284,'127.0.0.1',1383540434,'1'),(285,'127.0.0.1',1383540279,'1'),(286,'127.0.0.1',1383540299,'1'),(287,'127.0.0.1',1383540347,'1'),(288,'127.0.0.1',1383540400,'1'),(289,'127.0.0.1',1383542114,'1'),(290,'127.0.0.1',1383541065,'1'),(291,'127.0.0.1',1383541089,'1'),(292,'127.0.0.1',1383542147,'1'),(293,'127.0.0.1',1383553924,'1'),(294,'127.0.0.1',1383553956,'1'),(295,'127.0.0.1',1383554046,'1'),(296,'127.0.0.1',1383554066,'1'),(297,'127.0.0.1',1383554109,'1'),(298,'127.0.0.1',1383554144,'1'),(299,'127.0.0.1',1383554147,'1'),(300,'127.0.0.1',1383554166,'1'),(301,'127.0.0.1',1383554169,'1'),(302,'127.0.0.1',1383554190,'1'),(303,'127.0.0.1',1383554193,'1'),(304,'127.0.0.1',1383554209,'1'),(305,'127.0.0.1',1383554216,'1'),(306,'127.0.0.1',1383554219,'1'),(307,'127.0.0.1',1383554243,'1'),(308,'127.0.0.1',1383554526,'1'),(309,'127.0.0.1',1383554593,'1'),(310,'127.0.0.1',1383554621,'1'),(311,'127.0.0.1',1383554647,'1'),(312,'127.0.0.1',1383554650,'1'),(313,'127.0.0.1',1383554657,'1'),(314,'127.0.0.1',1383554699,'1'),(315,'127.0.0.1',1383554721,'1'),(316,'127.0.0.1',1383554724,'1'),(317,'127.0.0.1',1383554744,'1'),(318,'127.0.0.1',1383554752,'1'),(319,'127.0.0.1',1383555317,'1'),(320,'127.0.0.1',1383555338,'1'),(321,'127.0.0.1',1383555350,'1'),(322,'127.0.0.1',1383555875,'1'),(323,'127.0.0.1',1383555949,'1'),(324,'127.0.0.1',1383555972,'1'),(325,'127.0.0.1',1383555998,'1'),(326,'127.0.0.1',1383556004,'1'),(327,'127.0.0.1',1383556007,'1'),(328,'127.0.0.1',1383556028,'1'),(329,'127.0.0.1',1383556035,'1'),(330,'127.0.0.1',1383556038,'1'),(331,'127.0.0.1',1383556051,'1'),(332,'127.0.0.1',1383556058,'1'),(333,'127.0.0.1',1383556061,'1'),(334,'127.0.0.1',1383556093,'1'),(335,'127.0.0.1',1383556352,'1'),(336,'127.0.0.1',1383556597,'1'),(337,'127.0.0.1',1383556604,'1'),(338,'127.0.0.1',1383556611,'1'),(339,'127.0.0.1',1383556694,'1'),(340,'127.0.0.1',1383556704,'1'),(341,'127.0.0.1',1383556720,'1'),(342,'127.0.0.1',1383556723,'1'),(343,'127.0.0.1',1383556773,'1'),(344,'127.0.0.1',1383556806,'1'),(345,'127.0.0.1',1383556890,'1'),(346,'127.0.0.1',1383556956,'1'),(347,'127.0.0.1',1383557164,'1'),(348,'127.0.0.1',1383557185,'1'),(349,'127.0.0.1',1383557205,'1'),(350,'127.0.0.1',1383557208,'1'),(351,'127.0.0.1',1383557216,'1'),(352,'127.0.0.1',1383557330,'1'),(353,'127.0.0.1',1383557495,'1'),(354,'127.0.0.1',1383557510,'1'),(355,'127.0.0.1',1383557633,'1'),(356,'127.0.0.1',1383557680,'1'),(357,'127.0.0.1',1383557919,'1'),(358,'127.0.0.1',1383557965,'1'),(359,'127.0.0.1',1383558069,'1'),(360,'127.0.0.1',1383558082,'1'),(361,'127.0.0.1',1383558091,'1'),(362,'127.0.0.1',1383558093,'1'),(363,'127.0.0.1',1383558747,'1'),(364,'127.0.0.1',1383558758,'1'),(365,'127.0.0.1',1383558761,'1'),(366,'127.0.0.1',1383558768,'1'),(367,'127.0.0.1',1383558972,'1'),(368,'127.0.0.1',1383559048,'1'),(369,'127.0.0.1',1383559459,'1'),(370,'127.0.0.1',1383559726,'1'),(371,'127.0.0.1',1383559729,'1'),(372,'127.0.0.1',1383559742,'1'),(373,'127.0.0.1',1383559745,'1'),(374,'127.0.0.1',1383559785,'1'),(375,'127.0.0.1',1383559787,'1'),(376,'127.0.0.1',1383559850,'1'),(377,'127.0.0.1',1383559868,'1'),(378,'127.0.0.1',1383559878,'1'),(379,'127.0.0.1',1383559881,'1'),(380,'127.0.0.1',1383559888,'1'),(381,'127.0.0.1',1383559890,'1'),(382,'127.0.0.1',1383561225,'1'),(383,'127.0.0.1',1383561280,'1'),(384,'127.0.0.1',1383565254,'1'),(385,'127.0.0.1',1383624190,'1'),(386,'127.0.0.1',1383626758,'1'),(387,'127.0.0.1',1383626795,'1'),(388,'127.0.0.1',1383628982,'1'),(389,'127.0.0.1',1383629518,'1'),(390,'127.0.0.1',1383629635,'1'),(391,'127.0.0.1',1383630253,'1'),(392,'127.0.0.1',1383630280,'1'),(393,'127.0.0.1',1383633222,'1'),(394,'127.0.0.1',1383633248,'1'),(395,'127.0.0.1',1383636065,'1'),(396,'127.0.0.1',1383636092,'1'),(397,'127.0.0.1',1383637021,'1'),(398,'127.0.0.1',1383637103,'1'),(399,'127.0.0.1',1383637472,'1'),(400,'127.0.0.1',1383637507,'1'),(401,'127.0.0.1',1383637494,'1'),(402,'127.0.0.1',1383637670,'1'),(403,'127.0.0.1',1383637679,'1'),(404,'127.0.0.1',1383637698,'1'),(405,'127.0.0.1',1383637864,'1'),(406,'127.0.0.1',1383637935,'1'),(407,'127.0.0.1',1383638107,'1'),(408,'127.0.0.1',1383638178,'1'),(409,'127.0.0.1',1383638237,'1'),(410,'127.0.0.1',1383638261,'1'),(411,'127.0.0.1',1383638473,'1'),(412,'127.0.0.1',1383638627,'1'),(413,'127.0.0.1',1383639654,'1'),(414,'127.0.0.1',1383640102,'1'),(415,'127.0.0.1',1383640165,'1'),(416,'127.0.0.1',1383640152,'1'),(417,'127.0.0.1',1383640574,'1'),(418,'127.0.0.1',1383640578,'1'),(419,'127.0.0.1',1383640605,'1'),(420,'127.0.0.1',1383640751,'1'),(421,'127.0.0.1',1383640789,'1'),(422,'127.0.0.1',1383640812,'1'),(423,'127.0.0.1',1383640869,'1'),(424,'127.0.0.1',1383640889,'1'),(425,'127.0.0.1',1383640976,'1'),(426,'127.0.0.1',1383641062,'1'),(427,'127.0.0.1',1383641075,'1'),(428,'127.0.0.1',1383641167,'1'),(429,'127.0.0.1',1383641207,'1'),(430,'127.0.0.1',1383641215,'1'),(431,'127.0.0.1',1383641230,'1'),(432,'127.0.0.1',1383641278,'1'),(433,'127.0.0.1',1383641284,'1'),(434,'127.0.0.1',1383641309,'1'),(435,'127.0.0.1',1383641342,'1'),(436,'127.0.0.1',1383641355,'1'),(437,'127.0.0.1',1383641389,'1'),(438,'127.0.0.1',1383641429,'1'),(439,'127.0.0.1',1383641463,'1'),(440,'127.0.0.1',1383641993,'1'),(441,'127.0.0.1',1383644890,'1'),(442,'127.0.0.1',1383644902,'1'),(443,'127.0.0.1',1383644986,'1'),(444,'127.0.0.1',1383645297,'1'),(445,'127.0.0.1',1383645300,'1'),(446,'127.0.0.1',1383645348,'1'),(447,'127.0.0.1',1383645393,'1'),(448,'127.0.0.1',1383646063,'1'),(449,'127.0.0.1',1383646111,'1'),(450,'127.0.0.1',1383646185,'1'),(451,'127.0.0.1',1383646370,'1'),(452,'127.0.0.1',1383646384,'1'),(453,'127.0.0.1',1383646441,'1'),(454,'127.0.0.1',1383646697,'1'),(455,'127.0.0.1',1383646820,'1'),(456,'127.0.0.1',1383646866,'1'),(457,'127.0.0.1',1383646902,'1'),(458,'127.0.0.1',1383646979,'1'),(459,'127.0.0.1',1383647038,'1'),(460,'127.0.0.1',1383647169,'1'),(461,'127.0.0.1',1383647290,'1'),(462,'127.0.0.1',1383647397,'1'),(463,'127.0.0.1',1383647510,'1'),(464,'127.0.0.1',1383647514,'1'),(465,'127.0.0.1',1383647624,'1'),(466,'127.0.0.1',1383647966,'1'),(467,'127.0.0.1',1383648271,'1'),(468,'127.0.0.1',1383648375,'1'),(469,'127.0.0.1',1383648469,'1'),(470,'127.0.0.1',1383648561,'1'),(471,'127.0.0.1',1383648816,'1'),(472,'127.0.0.1',1383648820,'1'),(473,'127.0.0.1',1383648850,'1'),(474,'127.0.0.1',1383648856,'1'),(475,'127.0.0.1',1383648895,'1'),(476,'127.0.0.1',1383650064,'1'),(477,'127.0.0.1',1383709911,'1'),(478,'127.0.0.1',1383710072,'1'),(479,'127.0.0.1',1383710191,'1'),(480,'127.0.0.1',1383710443,'1'),(481,'127.0.0.1',1383710925,'1'),(482,'127.0.0.1',1383711080,'1'),(483,'127.0.0.1',1383711231,'1'),(484,'127.0.0.1',1383711249,'1'),(485,'127.0.0.1',1383712714,'1'),(486,'127.0.0.1',1383713081,'1'),(487,'127.0.0.1',1383713128,'1'),(488,'127.0.0.1',1383713139,'1'),(489,'127.0.0.1',1383713146,'1'),(490,'127.0.0.1',1383713210,'1'),(491,'127.0.0.1',1383713508,'1'),(492,'127.0.0.1',1383713536,'1'),(493,'127.0.0.1',1383713717,'1'),(494,'127.0.0.1',1383713739,'1'),(495,'127.0.0.1',1383713762,'1'),(496,'127.0.0.1',1383713767,'1'),(497,'127.0.0.1',1383713772,'1'),(498,'127.0.0.1',1383713795,'1'),(499,'127.0.0.1',1383713845,'1'),(500,'127.0.0.1',1383713873,'1'),(501,'127.0.0.1',1383713876,'1'),(502,'127.0.0.1',1383713886,'1'),(503,'127.0.0.1',1383713954,'1'),(504,'127.0.0.1',1383714533,'1'),(505,'127.0.0.1',1383714598,'1'),(506,'127.0.0.1',1383715065,'1'),(507,'127.0.0.1',1383715080,'1'),(508,'127.0.0.1',1383715092,'1'),(509,'127.0.0.1',1383715923,'1'),(510,'127.0.0.1',1383796961,'1'),(511,'127.0.0.1',1383797128,'1'),(512,'127.0.0.1',1383797288,'1'),(513,'127.0.0.1',1383797293,'1'),(514,'127.0.0.1',1383797329,'1'),(515,'127.0.0.1',1383797412,'1'),(516,'127.0.0.1',1383797547,'1'),(517,'127.0.0.1',1383797584,'1'),(518,'127.0.0.1',1383797813,'1'),(519,'127.0.0.1',1383797882,'1'),(520,'127.0.0.1',1383797885,'1'),(521,'127.0.0.1',1383797956,'1'),(522,'127.0.0.1',1383798197,'1'),(523,'127.0.0.1',1383798348,'1'),(524,'127.0.0.1',1383798358,'1'),(525,'127.0.0.1',1383798378,'1'),(526,'127.0.0.1',1383798663,'1'),(527,'127.0.0.1',1383798711,'1'),(528,'127.0.0.1',1383798752,'1'),(529,'127.0.0.1',1383798774,'1'),(530,'127.0.0.1',1383798776,'1'),(531,'127.0.0.1',1383798804,'1'),(532,'127.0.0.1',1383798810,'1'),(533,'127.0.0.1',1383798824,'1'),(534,'127.0.0.1',1383798908,'1'),(535,'127.0.0.1',1383798944,'1'),(536,'127.0.0.1',1383798958,'1'),(537,'127.0.0.1',1383798961,'1'),(538,'127.0.0.1',1383799184,'1'),(539,'127.0.0.1',1383799289,'1'),(540,'127.0.0.1',1383799358,'1'),(541,'127.0.0.1',1383799382,'1'),(542,'127.0.0.1',1383799385,'1'),(543,'127.0.0.1',1383799452,'1'),(544,'127.0.0.1',1383799466,'1'),(545,'127.0.0.1',1383799469,'1'),(546,'127.0.0.1',1383799490,'1'),(547,'127.0.0.1',1383799493,'1'),(548,'127.0.0.1',1383799530,'1'),(549,'127.0.0.1',1383799532,'1'),(550,'127.0.0.1',1383799554,'1'),(551,'127.0.0.1',1383799838,'1'),(552,'127.0.0.1',1383799915,'1'),(553,'127.0.0.1',1383800911,'1'),(554,'127.0.0.1',1383801000,'1'),(555,'127.0.0.1',1383801033,'1'),(556,'127.0.0.1',1383801055,'1'),(557,'127.0.0.1',1383802585,'1'),(558,'127.0.0.1',1383803271,'1'),(559,'127.0.0.1',1383803523,'1'),(560,'127.0.0.1',1383803687,'1'),(561,'127.0.0.1',1383803712,'1'),(562,'127.0.0.1',1383803839,'1'),(563,'127.0.0.1',1383803951,'1'),(564,'127.0.0.1',1383804122,'1'),(565,'127.0.0.1',1383818526,'1'),(566,'127.0.0.1',1383818713,'1'),(567,'127.0.0.1',1383818980,'1'),(568,'127.0.0.1',1383818989,'1'),(569,'127.0.0.1',1384230078,'1'),(570,'127.0.0.1',1384230101,'1'),(571,'127.0.0.1',1384230268,'1'),(572,'127.0.0.1',1384230368,'1'),(573,'127.0.0.1',1384230378,'1'),(574,'127.0.0.1',1384230454,'1'),(575,'127.0.0.1',1384230592,'1'),(576,'127.0.0.1',1384230609,'1'),(577,'127.0.0.1',1384230615,'1'),(578,'127.0.0.1',1384230660,'1'),(579,'127.0.0.1',1384230724,'1'),(580,'127.0.0.1',1384230742,'1'),(581,'127.0.0.1',1384230783,'1'),(582,'127.0.0.1',1384230794,'1'),(583,'127.0.0.1',1384230807,'1'),(584,'127.0.0.1',1384230810,'1'),(585,'127.0.0.1',1384230816,'1'),(586,'127.0.0.1',1384231108,'1'),(587,'127.0.0.1',1384231240,'1'),(588,'127.0.0.1',1384231274,'1'),(589,'127.0.0.1',1384231407,'1'),(590,'127.0.0.1',1384231446,'1'),(591,'127.0.0.1',1384231455,'1'),(592,'127.0.0.1',1384231477,'1'),(593,'127.0.0.1',1384231520,'1'),(594,'127.0.0.1',1384231552,'1'),(595,'127.0.0.1',1384231720,'1'),(596,'127.0.0.1',1384231862,'1'),(597,'127.0.0.1',1384231929,'1'),(598,'127.0.0.1',1384231976,'1'),(599,'127.0.0.1',1384232111,'1'),(600,'127.0.0.1',1384232214,'1'),(601,'127.0.0.1',1384232240,'1'),(602,'127.0.0.1',1384232244,'1'),(603,'127.0.0.1',1384232288,'1'),(604,'127.0.0.1',1384232453,'1'),(605,'127.0.0.1',1384232472,'1'),(606,'127.0.0.1',1384232523,'1'),(607,'127.0.0.1',1384232647,'1'),(608,'127.0.0.1',1384232658,'1'),(609,'127.0.0.1',1384232671,'1'),(610,'127.0.0.1',1384232674,'1'),(611,'127.0.0.1',1384232679,'1'),(612,'127.0.0.1',1384232763,'1'),(613,'127.0.0.1',1384232774,'1'),(614,'127.0.0.1',1384232816,'1'),(615,'127.0.0.1',1384232825,'1'),(616,'127.0.0.1',1384232842,'1'),(617,'127.0.0.1',1384232845,'1'),(618,'127.0.0.1',1384232890,'1'),(619,'127.0.0.1',1384232982,'1'),(620,'127.0.0.1',1384232979,'1'),(621,'127.0.0.1',1384232967,'1'),(622,'127.0.0.1',1384233046,'1'),(623,'127.0.0.1',1384233056,'1'),(624,'127.0.0.1',1384233066,'1'),(625,'127.0.0.1',1384233430,'1'),(626,'127.0.0.1',1384233449,'1'),(627,'127.0.0.1',1384233487,'1'),(628,'127.0.0.1',1384233509,'1'),(629,'127.0.0.1',1384233511,'1'),(630,'127.0.0.1',1384233518,'1'),(631,'127.0.0.1',1384233749,'1'),(632,'127.0.0.1',1384234144,'1'),(633,'127.0.0.1',1384233991,'1'),(634,'127.0.0.1',1384234205,'1'),(635,'127.0.0.1',1384234735,'1'),(636,'127.0.0.1',1384234231,'1'),(637,'127.0.0.1',1384234243,'1'),(638,'127.0.0.1',1384234246,'1'),(639,'127.0.0.1',1384234256,'1'),(640,'127.0.0.1',1384234292,'1'),(641,'127.0.0.1',1384234308,'1'),(642,'127.0.0.1',1384234312,'1'),(643,'127.0.0.1',1384234327,'1'),(644,'127.0.0.1',1384234330,'1'),(645,'127.0.0.1',1384234363,'1'),(646,'127.0.0.1',1384234647,'1'),(647,'127.0.0.1',1384234681,'1'),(648,'127.0.0.1',1384234725,'1'),(649,'127.0.0.1',1384234848,'1'),(650,'127.0.0.1',1384234995,'1'),(651,'127.0.0.1',1384235004,'1'),(652,'127.0.0.1',1384235007,'1'),(653,'127.0.0.1',1384235047,'1'),(654,'127.0.0.1',1384235090,'1'),(655,'127.0.0.1',1384235194,'1'),(656,'127.0.0.1',1384235219,'1'),(657,'127.0.0.1',1384235254,'1'),(658,'127.0.0.1',1384235298,'1'),(659,'127.0.0.1',1384235553,'1'),(660,'127.0.0.1',1384235564,'1'),(661,'127.0.0.1',1384235580,'1'),(662,'127.0.0.1',1384240924,'1'),(663,'127.0.0.1',1384235831,'1'),(664,'127.0.0.1',1384236209,'1'),(665,'127.0.0.1',1384236346,'1'),(666,'127.0.0.1',1384236411,'1'),(667,'127.0.0.1',1384236420,'1'),(668,'127.0.0.1',1384236500,'1'),(669,'127.0.0.1',1384236519,'1'),(670,'127.0.0.1',1384236973,'1'),(671,'127.0.0.1',1384240598,'1'),(672,'127.0.0.1',1384240674,'1'),(673,'127.0.0.1',1384240795,'1'),(674,'127.0.0.1',1384240839,'1'),(675,'127.0.0.1',1384240896,'1'),(676,'127.0.0.1',1384240970,'1'),(677,'127.0.0.1',1384240950,'1'),(678,'127.0.0.1',1384240973,'1'),(679,'127.0.0.1',1384243184,'1'),(680,'127.0.0.1',1384241061,'1'),(681,'127.0.0.1',1384241206,'1'),(682,'127.0.0.1',1384245033,'1'),(683,'127.0.0.1',1384243303,'1'),(684,'127.0.0.1',1384243429,'1'),(685,'127.0.0.1',1384243476,'1'),(686,'127.0.0.1',1384243586,'1'),(687,'127.0.0.1',1384243665,'1'),(688,'127.0.0.1',1384243673,'1'),(689,'127.0.0.1',1384243700,'1'),(690,'127.0.0.1',1384243703,'1'),(691,'127.0.0.1',1384243708,'1'),(692,'127.0.0.1',1384243736,'1'),(693,'127.0.0.1',1384243812,'1'),(694,'127.0.0.1',1384244037,'1'),(695,'127.0.0.1',1384246360,'1'),(696,'127.0.0.1',1384245045,'1'),(697,'127.0.0.1',1384245124,'1'),(698,'127.0.0.1',1384245207,'1'),(699,'127.0.0.1',1384245230,'1'),(700,'127.0.0.1',1384245379,'1'),(701,'127.0.0.1',1384245391,'1'),(702,'127.0.0.1',1384245410,'1'),(703,'127.0.0.1',1384245557,'1'),(704,'127.0.0.1',1384245575,'1'),(705,'127.0.0.1',1384246486,'1'),(706,'127.0.0.1',1384246977,'1'),(707,'127.0.0.1',1384250385,'1'),(708,'127.0.0.1',1384254249,'1'),(709,'127.0.0.1',1384254363,'1'),(710,'127.0.0.1',1384254419,'1'),(711,'127.0.0.1',1384254432,'1'),(712,'127.0.0.1',1384254441,'1'),(713,'127.0.0.1',1384254454,'1'),(714,'127.0.0.1',1384254457,'1'),(715,'127.0.0.1',1384254462,'1'),(716,'127.0.0.1',1384254509,'1'),(717,'127.0.0.1',1384254527,'1'),(718,'127.0.0.1',1384254537,'1'),(719,'127.0.0.1',1384314828,'1'),(720,'127.0.0.1',1384314835,'1'),(721,'127.0.0.1',1384314959,'1'),(722,'127.0.0.1',1384315093,'1'),(723,'127.0.0.1',1384315235,'1'),(724,'127.0.0.1',1384315272,'1'),(725,'127.0.0.1',1384315404,'1'),(726,'127.0.0.1',1384315495,'1'),(727,'127.0.0.1',1384315560,'1'),(728,'127.0.0.1',1384315926,'1'),(729,'127.0.0.1',1384316447,'1'),(730,'127.0.0.1',1384316566,'1'),(731,'127.0.0.1',1384316670,'1'),(732,'127.0.0.1',1384316677,'1'),(733,'127.0.0.1',1384316797,'1'),(734,'127.0.0.1',1384316800,'1'),(735,'127.0.0.1',1384316811,'1'),(736,'127.0.0.1',1384316822,'1'),(737,'127.0.0.1',1384316825,'1'),(738,'127.0.0.1',1384316967,'1'),(739,'127.0.0.1',1384317444,'1'),(740,'127.0.0.1',1384317445,'1'),(741,'127.0.0.1',1384317469,'1'),(742,'127.0.0.1',1384317527,'1'),(743,'127.0.0.1',1384317575,'1'),(744,'127.0.0.1',1384317615,'1'),(745,'127.0.0.1',1384317802,'1'),(746,'127.0.0.1',1384317900,'1'),(747,'127.0.0.1',1384317871,'1'),(748,'127.0.0.1',1384319466,'1'),(749,'127.0.0.1',1384317951,'1'),(750,'127.0.0.1',1384318292,'1'),(751,'127.0.0.1',1384318307,'1'),(752,'127.0.0.1',1384318328,'1'),(753,'127.0.0.1',1384318384,'1'),(754,'127.0.0.1',1384318387,'1'),(755,'127.0.0.1',1384318399,'1'),(756,'127.0.0.1',1384318621,'1'),(757,'127.0.0.1',1384318662,'1'),(758,'127.0.0.1',1384318674,'1'),(759,'127.0.0.1',1384318687,'1'),(760,'127.0.0.1',1384318714,'1'),(761,'127.0.0.1',1384319364,'1'),(762,'127.0.0.1',1384320351,'1'),(763,'127.0.0.1',1384331183,'1'),(764,'127.0.0.1',1384331560,'1'),(765,'127.0.0.1',1384331566,'1'),(766,'127.0.0.1',1384331589,'1'),(767,'127.0.0.1',1384331600,'1'),(768,'127.0.0.1',1384333050,'1'),(769,'127.0.0.1',1384341596,'1'),(770,'127.0.0.1',1384397525,'1'),(771,'127.0.0.1',1384400188,'1'),(772,'127.0.0.1',1384400200,'1'),(773,'127.0.0.1',1384400297,'1'),(774,'127.0.0.1',1384401068,'1'),(775,'127.0.0.1',1384403913,'1'),(776,'127.0.0.1',1384404693,'1'),(777,'127.0.0.1',1384405061,'1'),(778,'127.0.0.1',1384405069,'1'),(779,'127.0.0.1',1384405808,'1'),(780,'127.0.0.1',1384407067,'1'),(781,'127.0.0.1',1384407176,'1'),(782,'127.0.0.1',1384407196,'1'),(783,'127.0.0.1',1384407243,'1'),(784,'127.0.0.1',1384407402,'1'),(785,'127.0.0.1',1384407556,'1'),(786,'127.0.0.1',1384407586,'1'),(787,'127.0.0.1',1384407593,'1'),(788,'127.0.0.1',1384407609,'1'),(789,'127.0.0.1',1384407642,'1'),(790,'127.0.0.1',1384407650,'1'),(791,'127.0.0.1',1384407820,'1'),(792,'127.0.0.1',1384408053,'1'),(793,'127.0.0.1',1384408083,'1'),(794,'127.0.0.1',1384408104,'1'),(795,'127.0.0.1',1384408126,'1'),(796,'127.0.0.1',1384408144,'1'),(797,'127.0.0.1',1384408311,'1'),(798,'127.0.0.1',1384408322,'1'),(799,'127.0.0.1',1384408383,'1'),(800,'127.0.0.1',1384408394,'1'),(801,'127.0.0.1',1384408425,'1'),(802,'127.0.0.1',1384408431,'1'),(803,'127.0.0.1',1384408489,'1'),(804,'127.0.0.1',1384408492,'1'),(805,'127.0.0.1',1384408512,'1'),(806,'127.0.0.1',1384408898,'1'),(807,'127.0.0.1',1384408962,'1'),(808,'127.0.0.1',1384409088,'1'),(809,'127.0.0.1',1384409148,'1'),(810,'127.0.0.1',1384409192,'1'),(811,'127.0.0.1',1384409196,'1'),(812,'127.0.0.1',1384409471,'1'),(813,'127.0.0.1',1384409510,'1'),(814,'127.0.0.1',1384409620,'1'),(815,'127.0.0.1',1384409633,'1'),(816,'127.0.0.1',1384415139,'1'),(817,'127.0.0.1',1384409756,'1'),(818,'127.0.0.1',1384409817,'1'),(819,'127.0.0.1',1384409885,'1'),(820,'127.0.0.1',1384409890,'1'),(821,'127.0.0.1',1384409905,'1'),(822,'127.0.0.1',1384409909,'1'),(823,'127.0.0.1',1384409998,'1'),(824,'127.0.0.1',1384410121,'1'),(825,'127.0.0.1',1384410143,'1'),(826,'127.0.0.1',1384410185,'1'),(827,'127.0.0.1',1384410224,'1'),(828,'127.0.0.1',1384410267,'1'),(829,'127.0.0.1',1384410326,'1'),(830,'127.0.0.1',1384410335,'1'),(831,'127.0.0.1',1384410375,'1'),(832,'127.0.0.1',1384415397,'1'),(833,'127.0.0.1',1384415430,'1'),(834,'127.0.0.1',1384415446,'1'),(835,'127.0.0.1',1384415530,'1'),(836,'127.0.0.1',1384415560,'1'),(837,'127.0.0.1',1384415572,'1'),(838,'127.0.0.1',1384415655,'1'),(839,'127.0.0.1',1384415666,'1'),(840,'127.0.0.1',1384415681,'1'),(841,'127.0.0.1',1384415965,'1'),(842,'127.0.0.1',1384415996,'1'),(843,'127.0.0.1',1384415998,'1'),(844,'127.0.0.1',1384416028,'1'),(845,'127.0.0.1',1384416030,'1'),(846,'127.0.0.1',1384416062,'1'),(847,'127.0.0.1',1384416065,'1'),(848,'127.0.0.1',1384416097,'1'),(849,'127.0.0.1',1384416220,'1'),(850,'127.0.0.1',1384416225,'1'),(851,'127.0.0.1',1384416230,'1'),(852,'127.0.0.1',1384416353,'1'),(853,'127.0.0.1',1384416383,'1'),(854,'127.0.0.1',1384416413,'1'),(855,'127.0.0.1',1384416455,'1'),(856,'127.0.0.1',1384416461,'1'),(857,'127.0.0.1',1384416704,'1'),(858,'127.0.0.1',1384416785,'1'),(859,'127.0.0.1',1384416762,'1'),(860,'127.0.0.1',1384426274,'1'),(861,'127.0.0.1',1384416788,'1'),(862,'127.0.0.1',1384416809,'1'),(863,'127.0.0.1',1384416820,'1'),(864,'127.0.0.1',1384416829,'1'),(865,'127.0.0.1',1384416856,'1'),(866,'127.0.0.1',1384416899,'1'),(867,'127.0.0.1',1384416934,'1'),(868,'127.0.0.1',1384417258,'1'),(869,'127.0.0.1',1384417273,'1'),(870,'127.0.0.1',1384417276,'1'),(871,'127.0.0.1',1384418916,'1'),(872,'127.0.0.1',1384418930,'1'),(873,'127.0.0.1',1384418947,'1'),(874,'127.0.0.1',1384419110,'1'),(875,'127.0.0.1',1384419155,'1'),(876,'127.0.0.1',1384419188,'1'),(877,'127.0.0.1',1384419197,'1'),(878,'127.0.0.1',1384420083,'1'),(879,'127.0.0.1',1384420118,'1'),(880,'127.0.0.1',1384420125,'1'),(881,'127.0.0.1',1384420128,'1'),(882,'127.0.0.1',1384420167,'1'),(883,'127.0.0.1',1384420173,'1'),(884,'127.0.0.1',1384420257,'1'),(885,'127.0.0.1',1384420270,'1'),(886,'127.0.0.1',1384420273,'1'),(887,'127.0.0.1',1384420286,'1'),(888,'127.0.0.1',1384420325,'1'),(889,'127.0.0.1',1384420409,'1'),(890,'127.0.0.1',1384420445,'1'),(891,'127.0.0.1',1384420454,'1'),(892,'127.0.0.1',1384421309,'1'),(893,'127.0.0.1',1384421319,'1'),(894,'127.0.0.1',1384421343,'1'),(895,'127.0.0.1',1384421372,'1'),(896,'127.0.0.1',1384421379,'1'),(897,'127.0.0.1',1384421422,'1'),(898,'127.0.0.1',1384421439,'1'),(899,'127.0.0.1',1384421462,'1'),(900,'127.0.0.1',1384421464,'1'),(901,'127.0.0.1',1384421502,'1'),(902,'127.0.0.1',1384421505,'1'),(903,'127.0.0.1',1384421522,'1'),(904,'127.0.0.1',1384421565,'1'),(905,'127.0.0.1',1384421576,'1'),(906,'127.0.0.1',1384421694,'1'),(907,'127.0.0.1',1384421798,'1'),(908,'127.0.0.1',1384421830,'1'),(909,'127.0.0.1',1384421854,'1'),(910,'127.0.0.1',1384421876,'1'),(911,'127.0.0.1',1384421884,'1'),(912,'127.0.0.1',1384422087,'1'),(913,'127.0.0.1',1384422106,'1'),(914,'127.0.0.1',1384422117,'1'),(915,'127.0.0.1',1384422127,'1'),(916,'127.0.0.1',1384422135,'1'),(917,'127.0.0.1',1384422338,'1'),(918,'127.0.0.1',1384422407,'1'),(919,'127.0.0.1',1384422511,'1'),(920,'127.0.0.1',1384422527,'1'),(921,'127.0.0.1',1384422535,'1'),(922,'127.0.0.1',1384422578,'1'),(923,'127.0.0.1',1384422587,'1'),(924,'127.0.0.1',1384422599,'1'),(925,'127.0.0.1',1384422649,'1'),(926,'127.0.0.1',1384422802,'1'),(927,'127.0.0.1',1384426274,'1'),(928,'127.0.0.1',1384427354,'1'),(929,'127.0.0.1',1384428322,'1'),(930,'127.0.0.1',1384487984,'1'),(931,'127.0.0.1',1384488023,'1'),(932,'127.0.0.1',1384488048,'1'),(933,'127.0.0.1',1384488531,'1'),(934,'127.0.0.1',1384488055,'1'),(935,'127.0.0.1',1384488063,'1'),(936,'127.0.0.1',1384488071,'1'),(937,'127.0.0.1',1384488074,'1'),(938,'127.0.0.1',1384488091,'1'),(939,'127.0.0.1',1384488133,'1'),(940,'127.0.0.1',1384488155,'1'),(941,'127.0.0.1',1384488197,'1'),(942,'127.0.0.1',1384488202,'1'),(943,'127.0.0.1',1384488224,'1'),(944,'127.0.0.1',1384488232,'1'),(945,'127.0.0.1',1384488234,'1'),(946,'127.0.0.1',1384488242,'1'),(947,'127.0.0.1',1384488285,'1'),(948,'127.0.0.1',1384488306,'1'),(949,'127.0.0.1',1384488327,'1'),(950,'127.0.0.1',1384488449,'1'),(951,'127.0.0.1',1384488567,'1'),(952,'127.0.0.1',1384488572,NULL),(953,'127.0.0.1',1384488620,'1'),(954,'127.0.0.1',1384489108,'1'),(955,'127.0.0.1',1384489117,'1'),(956,'127.0.0.1',1384489160,'1'),(957,'127.0.0.1',1384489370,'1'),(958,'127.0.0.1',1384489400,'1'),(959,'127.0.0.1',1384489405,'1'),(960,'127.0.0.1',1384489419,'1'),(961,'127.0.0.1',1384489442,'1'),(962,'127.0.0.1',1384490119,'1'),(963,'127.0.0.1',1384490163,'1'),(964,'127.0.0.1',1384490226,'1'),(965,'127.0.0.1',1384490228,'1'),(966,'127.0.0.1',1384490312,'1'),(967,'127.0.0.1',1384490447,'1'),(968,'127.0.0.1',1384490451,'1'),(969,'127.0.0.1',1384490601,'1'),(970,'127.0.0.1',1384490634,'1'),(971,'127.0.0.1',1384490680,'1'),(972,'127.0.0.1',1384490707,'1'),(973,'127.0.0.1',1384490736,'1'),(974,'127.0.0.1',1384490756,'1'),(975,'127.0.0.1',1384490774,'1'),(976,'127.0.0.1',1384490778,'1'),(977,'127.0.0.1',1384490844,'1'),(978,'127.0.0.1',1384490924,'1'),(979,'127.0.0.1',1384490955,'1'),(980,'127.0.0.1',1384490968,'1'),(981,'127.0.0.1',1384491132,'1'),(982,'127.0.0.1',1384491242,'1'),(983,'127.0.0.1',1384491245,'1'),(984,'127.0.0.1',1384491267,'1'),(985,'127.0.0.1',1384491269,'1'),(986,'127.0.0.1',1384491295,'1'),(987,'127.0.0.1',1384491304,'1'),(988,'127.0.0.1',1384491307,'1'),(989,'127.0.0.1',1384491332,'1'),(990,'127.0.0.1',1384491341,'1'),(991,'127.0.0.1',1384491465,'1'),(992,'127.0.0.1',1384491506,'1'),(993,'127.0.0.1',1384491550,'1'),(994,'127.0.0.1',1384491661,'1'),(995,'127.0.0.1',1384491704,'1'),(996,'127.0.0.1',1384491716,'1'),(997,'127.0.0.1',1384491723,'1'),(998,'127.0.0.1',1384491812,'1'),(999,'127.0.0.1',1384491816,'1'),(1000,'127.0.0.1',1384491858,'1'),(1001,'127.0.0.1',1384491915,'1'),(1002,'127.0.0.1',1384491928,'1'),(1003,'127.0.0.1',1384491973,'1'),(1004,'127.0.0.1',1384491995,'1'),(1005,'127.0.0.1',1384492079,'1'),(1006,'127.0.0.1',1384492115,'1'),(1007,'127.0.0.1',1384492118,'1'),(1008,'127.0.0.1',1384492142,'1'),(1009,'127.0.0.1',1384492151,'1'),(1010,'127.0.0.1',1384492154,'1'),(1011,'127.0.0.1',1384492176,'1'),(1012,'127.0.0.1',1384492179,'1'),(1013,'127.0.0.1',1384492216,'1'),(1014,'127.0.0.1',1384492580,'1'),(1015,'127.0.0.1',1384492614,'1'),(1016,'127.0.0.1',1384492697,'1'),(1017,'127.0.0.1',1384492734,'1'),(1018,'127.0.0.1',1384492746,'1'),(1019,'127.0.0.1',1384492789,'1'),(1020,'127.0.0.1',1384492821,'1'),(1021,'127.0.0.1',1384492905,'1'),(1022,'127.0.0.1',1384492945,'1'),(1023,'127.0.0.1',1384492958,'1'),(1024,'127.0.0.1',1384492961,'1'),(1025,'127.0.0.1',1384493000,'1'),(1026,'127.0.0.1',1384493014,'1'),(1027,'127.0.0.1',1384493178,'1'),(1028,'127.0.0.1',1384493215,'1'),(1029,'127.0.0.1',1384493232,'1'),(1030,'127.0.0.1',1384493242,'1'),(1031,'127.0.0.1',1384493285,'1'),(1032,'127.0.0.1',1384493296,'1'),(1033,'127.0.0.1',1384493312,'1'),(1034,'127.0.0.1',1384493321,'1'),(1035,'127.0.0.1',1384493404,'1'),(1036,'127.0.0.1',1384493435,'1'),(1037,'127.0.0.1',1384493446,'1'),(1038,'127.0.0.1',1384493449,'1'),(1039,'127.0.0.1',1384494097,'1'),(1040,'127.0.0.1',1384494113,'1'),(1041,'127.0.0.1',1384494128,'1'),(1042,'127.0.0.1',1384494572,'1'),(1043,'127.0.0.1',1384494768,'1'),(1044,'127.0.0.1',1384494770,'1'),(1045,'127.0.0.1',1384494775,'1'),(1046,'127.0.0.1',1384494808,'1'),(1047,'127.0.0.1',1384494931,'1'),(1048,'127.0.0.1',1384494971,'1'),(1049,'127.0.0.1',1384495014,'1'),(1050,'127.0.0.1',1384495036,'1'),(1051,'127.0.0.1',1384495079,'1'),(1052,'127.0.0.1',1384495115,'1'),(1053,'127.0.0.1',1384495224,'1'),(1054,'127.0.0.1',1384495275,'1'),(1055,'127.0.0.1',1384495359,'1'),(1056,'127.0.0.1',1384495395,'1'),(1057,'127.0.0.1',1384495507,'1'),(1058,'127.0.0.1',1384496704,'1'),(1059,'127.0.0.1',1384495528,'1'),(1060,'127.0.0.1',1384495624,'1'),(1061,'127.0.0.1',1384495629,'1'),(1062,'127.0.0.1',1384495639,'1'),(1063,'127.0.0.1',1384495843,'1'),(1064,'127.0.0.1',1384495881,'1'),(1065,'127.0.0.1',1384495964,'1'),(1066,'127.0.0.1',1384495968,'1'),(1067,'127.0.0.1',1384495978,'1'),(1068,'127.0.0.1',1384496021,'1'),(1069,'127.0.0.1',1384496027,'1'),(1070,'127.0.0.1',1384496311,'1'),(1071,'127.0.0.1',1384496367,'1'),(1072,'127.0.0.1',1384496833,'1'),(1073,'127.0.0.1',1384496720,'1'),(1074,'127.0.0.1',1384496729,'1'),(1075,'127.0.0.1',1384496933,'1'),(1076,'127.0.0.1',1384496858,'1'),(1077,'127.0.0.1',1384496866,'1'),(1078,'127.0.0.1',1384499494,'1'),(1079,'127.0.0.1',1384496936,'1'),(1080,'127.0.0.1',1384496953,'1'),(1081,'127.0.0.1',1384496982,'1'),(1082,'127.0.0.1',1384499164,'1'),(1083,'127.0.0.1',1384499424,'1'),(1084,'127.0.0.1',1384499449,'1'),(1085,'127.0.0.1',1384499467,'1'),(1086,'127.0.0.1',1384499549,'1'),(1087,'127.0.0.1',1384499515,'1'),(1088,'127.0.0.1',1384499526,'1'),(1089,'127.0.0.1',1384499537,'1'),(1090,'127.0.0.1',1384499548,'1'),(1091,'127.0.0.1',1384499552,'1'),(1092,'127.0.0.1',1384499562,'1'),(1093,'127.0.0.1',1384501493,'1'),(1094,'127.0.0.1',1384499570,'1'),(1095,'127.0.0.1',1384499745,'1'),(1096,'127.0.0.1',1384499785,'1'),(1097,'127.0.0.1',1384499805,'1'),(1098,'127.0.0.1',1384499846,'1'),(1099,'127.0.0.1',1384499862,'1'),(1100,'127.0.0.1',1384499875,'1'),(1101,'127.0.0.1',1384500018,'1'),(1102,'127.0.0.1',1384500186,'1'),(1103,'127.0.0.1',1384500248,'1'),(1104,'127.0.0.1',1384500286,'1'),(1105,'127.0.0.1',1384500395,'1'),(1106,'127.0.0.1',1384500554,'1'),(1107,'127.0.0.1',1384500963,'1'),(1108,'127.0.0.1',1384500970,'1'),(1109,'127.0.0.1',1384500986,'1'),(1110,'127.0.0.1',1384501607,'1'),(1111,'127.0.0.1',1384501626,'1'),(1112,'127.0.0.1',1384501629,'1'),(1113,'127.0.0.1',1384501633,'1'),(1114,'127.0.0.1',1384501678,'1'),(1115,'127.0.0.1',1384501896,'1'),(1116,'127.0.0.1',1384502955,'1'),(1117,'127.0.0.1',1384502966,'1'),(1118,'127.0.0.1',1384502972,'1'),(1119,'127.0.0.1',1384502985,'1'),(1120,'127.0.0.1',1384503028,'1'),(1121,'127.0.0.1',1384512053,'1'),(1122,'127.0.0.1',1384503052,'1'),(1123,'127.0.0.1',1384503070,'1'),(1124,'127.0.0.1',1384510634,'1'),(1125,'127.0.0.1',1384511062,'1'),(1126,'127.0.0.1',1384511529,'1'),(1127,'127.0.0.1',1384511751,'1'),(1128,'127.0.0.1',1384512547,'1'),(1129,'127.0.0.1',1384514226,'1'),(1130,'127.0.0.1',1384512705,'1'),(1131,'127.0.0.1',1384512878,'1'),(1132,'127.0.0.1',1384512881,'1'),(1133,'127.0.0.1',1384512898,'1'),(1134,'127.0.0.1',1384512901,'1'),(1135,'127.0.0.1',1384512932,'1'),(1136,'127.0.0.1',1384513182,'1'),(1137,'127.0.0.1',1384513433,'1'),(1138,'127.0.0.1',1384514239,'1'),(1139,'127.0.0.1',1384743847,'1'),(1140,'127.0.0.1',1384743871,'1'),(1141,'127.0.0.1',1384743940,'1'),(1142,'127.0.0.1',1384743950,'1'),(1143,'127.0.0.1',1384744837,'1'),(1144,'127.0.0.1',1384745544,'1'),(1145,'127.0.0.1',1384745582,'1'),(1146,'127.0.0.1',1384745594,'1'),(1147,'127.0.0.1',1384745596,'1'),(1148,'127.0.0.1',1384745622,'1'),(1149,'127.0.0.1',1384746066,'1'),(1150,'127.0.0.1',1384747054,'1'),(1151,'127.0.0.1',1384747084,'1'),(1152,'127.0.0.1',1384747102,'1'),(1153,'127.0.0.1',1384747998,'1'),(1154,'127.0.0.1',1384748047,'1'),(1155,'127.0.0.1',1384748120,'1'),(1156,'127.0.0.1',1384748141,'1'),(1157,'127.0.0.1',1384748151,'1'),(1158,'127.0.0.1',1384748155,'1'),(1159,'127.0.0.1',1384748202,'1'),(1160,'127.0.0.1',1384748378,'1'),(1161,'127.0.0.1',1384749035,'1'),(1162,'127.0.0.1',1384748638,'1'),(1163,'127.0.0.1',1384748687,'1'),(1164,'127.0.0.1',1384748731,'1'),(1165,'127.0.0.1',1384748818,'1'),(1166,'127.0.0.1',1384748868,'1'),(1167,'127.0.0.1',1384748873,'1'),(1168,'127.0.0.1',1384748904,'1'),(1169,'127.0.0.1',1384749056,'1'),(1170,'127.0.0.1',1384750879,'1'),(1171,'127.0.0.1',1384749121,'1'),(1172,'127.0.0.1',1384749348,'1'),(1173,'127.0.0.1',1384749515,'1'),(1174,'127.0.0.1',1384749736,'1'),(1175,'127.0.0.1',1384750033,'1'),(1176,'127.0.0.1',1384750042,'1'),(1177,'127.0.0.1',1384750199,'1'),(1178,'127.0.0.1',1384750230,'1'),(1179,'127.0.0.1',1384751989,'1'),(1180,'127.0.0.1',1384750881,'1'),(1181,'127.0.0.1',1384750883,'1'),(1182,'127.0.0.1',1384750898,'1'),(1183,'127.0.0.1',1384750981,'1'),(1184,'127.0.0.1',1384751040,'1'),(1185,'127.0.0.1',1384751070,'1'),(1186,'127.0.0.1',1384751081,'1'),(1187,'127.0.0.1',1384751084,'1'),(1188,'127.0.0.1',1384751105,'1'),(1189,'127.0.0.1',1384751108,'1'),(1190,'127.0.0.1',1384751120,'1'),(1191,'127.0.0.1',1384751123,'1'),(1192,'127.0.0.1',1384751151,'1'),(1193,'127.0.0.1',1384751395,'1'),(1194,'127.0.0.1',1384751435,'1'),(1195,'127.0.0.1',1384751920,'1'),(1196,'127.0.0.1',1384758127,'1'),(1197,'127.0.0.1',1384752082,'1'),(1198,'127.0.0.1',1384752094,'1'),(1199,'127.0.0.1',1384752106,'1'),(1200,'127.0.0.1',1384752141,'1'),(1201,'127.0.0.1',1384752189,'1'),(1202,'127.0.0.1',1384752272,'1'),(1203,'127.0.0.1',1384752381,'1'),(1204,'127.0.0.1',1384752385,'1'),(1205,'127.0.0.1',1384752421,'1'),(1206,'127.0.0.1',1384752467,'1'),(1207,'127.0.0.1',1384752551,'1'),(1208,'127.0.0.1',1384752556,'1'),(1209,'127.0.0.1',1384752576,'1'),(1210,'127.0.0.1',1384752613,'1'),(1211,'127.0.0.1',1384752686,'1'),(1212,'127.0.0.1',1384752692,'1'),(1213,'127.0.0.1',1384752761,'1'),(1214,'127.0.0.1',1384752875,'1'),(1215,'127.0.0.1',1384753064,'1'),(1216,'127.0.0.1',1384753070,'1'),(1217,'127.0.0.1',1384753079,'1'),(1218,'127.0.0.1',1384753096,'1'),(1219,'127.0.0.1',1384753143,'1'),(1220,'127.0.0.1',1384753148,'1'),(1221,'127.0.0.1',1384753260,'1'),(1222,'127.0.0.1',1384753303,'1'),(1223,'127.0.0.1',1384753307,'1'),(1224,'127.0.0.1',1384753332,'1'),(1225,'127.0.0.1',1384753722,'1'),(1226,'127.0.0.1',1384753733,'1'),(1227,'127.0.0.1',1384753818,'1'),(1228,'127.0.0.1',1384753843,'1'),(1229,'127.0.0.1',1384754141,'1'),(1230,'127.0.0.1',1384754186,'1'),(1231,'127.0.0.1',1384754304,'1'),(1232,'127.0.0.1',1384754308,'1'),(1233,'127.0.0.1',1384754322,'1'),(1234,'127.0.0.1',1384757950,'1'),(1235,'127.0.0.1',1384757964,'1'),(1236,'127.0.0.1',1384757973,'1'),(1237,'127.0.0.1',1384757976,'1'),(1238,'127.0.0.1',1384757991,'1'),(1239,'127.0.0.1',1384758093,'1'),(1240,'127.0.0.1',1384758150,'1'),(1241,'127.0.0.1',1384758156,'1'),(1242,'127.0.0.1',1384758174,'1'),(1243,'127.0.0.1',1384758185,'1'),(1244,'127.0.0.1',1384758232,'1'),(1245,'127.0.0.1',1384758279,'1'),(1246,'127.0.0.1',1384758297,'1'),(1247,'127.0.0.1',1384758358,'1'),(1248,'127.0.0.1',1384758437,'1'),(1249,'127.0.0.1',1384758472,'1'),(1250,'127.0.0.1',1384758676,'1'),(1251,'127.0.0.1',1384758871,'1'),(1252,'127.0.0.1',1384759245,'1'),(1253,'127.0.0.1',1384759266,'1'),(1254,'127.0.0.1',1384759303,'1'),(1255,'127.0.0.1',1384759312,'1'),(1256,'127.0.0.1',1384759381,'1'),(1257,'127.0.0.1',1384759431,'1'),(1258,'127.0.0.1',1384759542,'1'),(1259,'127.0.0.1',1384759563,'1'),(1260,'127.0.0.1',1384759573,'1'),(1261,'127.0.0.1',1384759582,'1'),(1262,'127.0.0.1',1384759632,'1'),(1263,'127.0.0.1',1384759665,'1'),(1264,'127.0.0.1',1384759703,'1'),(1265,'127.0.0.1',1384759716,'1'),(1266,'127.0.0.1',1384759723,'1'),(1267,'127.0.0.1',1384759754,'1'),(1268,'127.0.0.1',1384759764,'1'),(1269,'127.0.0.1',1384759824,'1'),(1270,'127.0.0.1',1384759904,'1'),(1271,'127.0.0.1',1384759924,'1'),(1272,'127.0.0.1',1384760015,'1'),(1273,'127.0.0.1',1384760022,'1'),(1274,'127.0.0.1',1384760698,'1'),(1275,'127.0.0.1',1384763419,'1'),(1276,'127.0.0.1',1384763549,'1'),(1277,'127.0.0.1',1384831080,'1'),(1278,'127.0.0.1',1384831108,'1'),(1279,'127.0.0.1',1384831221,'1'),(1280,'127.0.0.1',1384831476,'1'),(1281,'127.0.0.1',1384832017,'1'),(1282,'127.0.0.1',1384832279,'1'),(1283,'127.0.0.1',1384832294,'1'),(1284,'127.0.0.1',1384832353,'1'),(1285,'127.0.0.1',1384832484,'1'),(1286,'127.0.0.1',1384832501,'1'),(1287,'127.0.0.1',1384832929,'1'),(1288,'127.0.0.1',1384832960,'1'),(1289,'127.0.0.1',1384833042,'1'),(1290,'127.0.0.1',1384833170,'1'),(1291,'127.0.0.1',1384833202,'1'),(1292,'127.0.0.1',1384833373,'1'),(1293,'127.0.0.1',1384833472,'1'),(1294,'127.0.0.1',1384833514,'1'),(1295,'127.0.0.1',1384833559,'1'),(1296,'127.0.0.1',1384833592,'1'),(1297,'127.0.0.1',1384833710,'1'),(1298,'127.0.0.1',1384833753,'1'),(1299,'127.0.0.1',1384833939,'1'),(1300,'127.0.0.1',1384833961,'1'),(1301,'127.0.0.1',1384833965,'1'),(1302,'127.0.0.1',1384834159,'1'),(1303,'127.0.0.1',1384834268,'1'),(1304,'127.0.0.1',1384834397,'1'),(1305,'127.0.0.1',1384834430,'1'),(1306,'127.0.0.1',1384834552,'1'),(1307,'127.0.0.1',1384834653,'1'),(1308,'127.0.0.1',1384834719,'1'),(1309,'127.0.0.1',1384834737,'1'),(1310,'127.0.0.1',1384834805,'1'),(1311,'127.0.0.1',1384834922,'1'),(1312,'127.0.0.1',1384834973,'1'),(1313,'127.0.0.1',1384835009,'1'),(1314,'127.0.0.1',1384835068,'1'),(1315,'127.0.0.1',1384835126,'1'),(1316,'127.0.0.1',1384835148,'1'),(1317,'127.0.0.1',1384835206,'1'),(1318,'127.0.0.1',1384835213,'1'),(1319,'127.0.0.1',1384835253,'1'),(1320,'127.0.0.1',1384835362,'1'),(1321,'127.0.0.1',1384835392,'1'),(1322,'127.0.0.1',1384835490,'1'),(1323,'127.0.0.1',1384835563,'1'),(1324,'127.0.0.1',1384835724,'1'),(1325,'127.0.0.1',1384835772,'1'),(1326,'127.0.0.1',1384835832,'1'),(1327,'127.0.0.1',1384835896,'1'),(1328,'127.0.0.1',1384835978,'1'),(1329,'127.0.0.1',1384836010,'1'),(1330,'127.0.0.1',1384836093,'1'),(1331,'127.0.0.1',1384836175,'1'),(1332,'127.0.0.1',1384836465,'1'),(1333,'127.0.0.1',1384836471,'1'),(1334,'127.0.0.1',1384836604,'1'),(1335,'127.0.0.1',1384836633,'1'),(1336,'127.0.0.1',1384836704,'1'),(1337,'127.0.0.1',1384836759,'1'),(1338,'127.0.0.1',1384837389,'1'),(1339,'127.0.0.1',1384837449,'1'),(1340,'127.0.0.1',1384837462,'1'),(1341,'127.0.0.1',1384837481,'1'),(1342,'127.0.0.1',1384837516,'1'),(1343,'127.0.0.1',1384837586,'1'),(1344,'127.0.0.1',1384837633,'1'),(1345,'127.0.0.1',1384837679,'1'),(1346,'127.0.0.1',1384837696,'1'),(1347,'127.0.0.1',1384837754,'1'),(1348,'127.0.0.1',1384837785,'1'),(1349,'127.0.0.1',1384837844,'1'),(1350,'127.0.0.1',1384837882,'1'),(1351,'127.0.0.1',1384837903,'1'),(1352,'127.0.0.1',1384837908,'1'),(1353,'127.0.0.1',1384838184,'1'),(1354,'127.0.0.1',1384838291,'1'),(1355,'127.0.0.1',1384838470,'1'),(1356,'127.0.0.1',1384838490,'1'),(1357,'127.0.0.1',1384838613,'1'),(1358,'127.0.0.1',1384838622,'1'),(1359,'127.0.0.1',1384838673,'1'),(1360,'127.0.0.1',1384838696,'1'),(1361,'127.0.0.1',1384838759,'1'),(1362,'127.0.0.1',1384838787,'1'),(1363,'127.0.0.1',1384838800,'1'),(1364,'127.0.0.1',1384838803,'1'),(1365,'127.0.0.1',1384838842,'1'),(1366,'127.0.0.1',1384838892,'1'),(1367,'127.0.0.1',1384838992,'1'),(1368,'127.0.0.1',1384839009,'1'),(1369,'127.0.0.1',1384839141,'1'),(1370,'127.0.0.1',1384839154,'1'),(1371,'127.0.0.1',1384839182,'1'),(1372,'127.0.0.1',1384839186,'1'),(1373,'127.0.0.1',1384839224,'1'),(1374,'127.0.0.1',1384839253,'1'),(1375,'127.0.0.1',1384839337,'1'),(1376,'127.0.0.1',1384839477,'1'),(1377,'127.0.0.1',1384839549,'1'),(1378,'127.0.0.1',1384839594,'1'),(1379,'127.0.0.1',1384839619,'1'),(1380,'127.0.0.1',1384839663,'1'),(1381,'127.0.0.1',1384839728,'1'),(1382,'127.0.0.1',1384839732,'1'),(1383,'127.0.0.1',1384839768,'1'),(1384,'127.0.0.1',1384840574,'1'),(1385,'127.0.0.1',1384841146,'1'),(1386,'127.0.0.1',1384841177,'1'),(1387,'127.0.0.1',1384841191,'1'),(1388,'127.0.0.1',1384841276,'1'),(1389,'127.0.0.1',1384841278,'1'),(1390,'127.0.0.1',1384841288,'1'),(1391,'127.0.0.1',1384842053,'1'),(1392,'127.0.0.1',1384842072,'1'),(1393,'127.0.0.1',1384842096,'1'),(1394,'127.0.0.1',1384842689,'1'),(1395,'127.0.0.1',1384842731,'1'),(1396,'127.0.0.1',1384842746,'1'),(1397,'127.0.0.1',1384842870,'1'),(1398,'127.0.0.1',1384843705,'1'),(1399,'127.0.0.1',1384843718,'1'),(1400,'127.0.0.1',1384843809,'1'),(1401,'127.0.0.1',1384843948,'1'),(1402,'127.0.0.1',1384843956,'1'),(1403,'127.0.0.1',1384846166,'1'),(1404,'127.0.0.1',1384846200,'1'),(1405,'127.0.0.1',1384846324,'1'),(1406,'127.0.0.1',1384846417,'1'),(1407,'127.0.0.1',1384846505,'1'),(1408,'127.0.0.1',1384846766,'1'),(1409,'127.0.0.1',1384846809,'1'),(1410,'127.0.0.1',1384847000,'1'),(1411,'127.0.0.1',1384847086,'1'),(1412,'127.0.0.1',1384847185,'1'),(1413,'127.0.0.1',1384847228,'1'),(1414,'127.0.0.1',1384847289,'1'),(1415,'127.0.0.1',1384847677,'1'),(1416,'127.0.0.1',1384847748,'1'),(1417,'127.0.0.1',1384847795,'1'),(1418,'127.0.0.1',1384847864,'1'),(1419,'127.0.0.1',1384847894,'1'),(1420,'127.0.0.1',1384847920,'1'),(1421,'127.0.0.1',1384848084,'1'),(1422,'127.0.0.1',1384848112,'1'),(1423,'127.0.0.1',1384848133,'1'),(1424,'127.0.0.1',1384848169,'1'),(1425,'127.0.0.1',1384848195,'1'),(1426,'127.0.0.1',1384848234,'1'),(1427,'127.0.0.1',1384848238,'1'),(1428,'127.0.0.1',1384848589,'1'),(1429,'127.0.0.1',1384848648,'1'),(1430,'127.0.0.1',1384848733,'1'),(1431,'127.0.0.1',1384848768,'1'),(1432,'127.0.0.1',1384848786,'1'),(1433,'127.0.0.1',1384848789,'1'),(1434,'127.0.0.1',1384849051,'1'),(1435,'127.0.0.1',1384849994,'1'),(1436,'127.0.0.1',1384849071,'1'),(1437,'127.0.0.1',1384849137,'1'),(1438,'127.0.0.1',1384849268,'1'),(1439,'127.0.0.1',1384849308,'1'),(1440,'127.0.0.1',1384849649,'1'),(1441,'127.0.0.1',1384849687,'1'),(1442,'127.0.0.1',1384849844,'1'),(1443,'127.0.0.1',1384849860,'1'),(1444,'127.0.0.1',1384849903,'1'),(1445,'127.0.0.1',1384849925,'1'),(1446,'127.0.0.1',1384850017,'1'),(1447,'127.0.0.1',1384854295,'1'),(1448,'127.0.0.1',1384854369,'1'),(1449,'127.0.0.1',1384854441,'1'),(1450,'127.0.0.1',1384854493,'1'),(1451,'127.0.0.1',1384854504,'1'),(1452,'127.0.0.1',1384855089,'1'),(1453,'127.0.0.1',1384855120,'1'),(1454,'127.0.0.1',1384855193,'1'),(1455,'127.0.0.1',1384855256,'1'),(1456,'127.0.0.1',1384855336,'1'),(1457,'127.0.0.1',1384855374,'1'),(1458,'127.0.0.1',1384855405,'1'),(1459,'127.0.0.1',1384855410,'1'),(1460,'127.0.0.1',1384915445,'1'),(1461,'127.0.0.1',1384915626,'1'),(1462,'127.0.0.1',1384916493,'1'),(1463,'127.0.0.1',1384916548,'1'),(1464,'127.0.0.1',1384916553,'1'),(1465,'127.0.0.1',1384916606,'1'),(1466,'127.0.0.1',1384916965,'1'),(1467,'127.0.0.1',1384916980,'1'),(1468,'127.0.0.1',1384916982,'1'),(1469,'127.0.0.1',1384916989,'1'),(1470,'127.0.0.1',1384917513,'1'),(1471,'127.0.0.1',1384917539,'1'),(1472,'127.0.0.1',1384917577,'1'),(1473,'127.0.0.1',1384917593,'1'),(1474,'127.0.0.1',1384917610,'1'),(1475,'127.0.0.1',1384917620,'1'),(1476,'127.0.0.1',1384917623,'1'),(1477,'127.0.0.1',1384918917,'1'),(1478,'127.0.0.1',1384918922,'1'),(1479,'127.0.0.1',1384918938,'1'),(1480,'127.0.0.1',1384919303,'1'),(1481,'127.0.0.1',1384919316,'1'),(1482,'127.0.0.1',1384919325,'1'),(1483,'127.0.0.1',1384919329,'1'),(1484,'127.0.0.1',1384919390,'1'),(1485,'127.0.0.1',1384919905,'1'),(1486,'127.0.0.1',1384920194,'1'),(1487,'127.0.0.1',1384920242,'1'),(1488,'127.0.0.1',1384920249,'1'),(1489,'127.0.0.1',1384921135,'1'),(1490,'127.0.0.1',1384921143,'1'),(1491,'127.0.0.1',1384921152,'1'),(1492,'127.0.0.1',1384921155,'1'),(1493,'127.0.0.1',1384921190,'1'),(1494,'127.0.0.1',1384921198,'1'),(1495,'127.0.0.1',1384921643,'1'),(1496,'127.0.0.1',1384921670,'1'),(1497,'127.0.0.1',1384921678,'1'),(1498,'127.0.0.1',1384921762,'1'),(1499,'127.0.0.1',1384921743,'1'),(1500,'127.0.0.1',1384921801,'1'),(1501,'127.0.0.1',1384921810,'1'),(1502,'127.0.0.1',1384921825,'1'),(1503,'127.0.0.1',1384921838,'1'),(1504,'127.0.0.1',1384921845,'1'),(1505,'127.0.0.1',1384921868,'1'),(1506,'127.0.0.1',1384921870,'1'),(1507,'127.0.0.1',1384921928,'1'),(1508,'127.0.0.1',1384921961,'1'),(1509,'127.0.0.1',1384922002,'1'),(1510,'127.0.0.1',1384922049,'1'),(1511,'127.0.0.1',1384922141,'1'),(1512,'127.0.0.1',1384922192,'1'),(1513,'127.0.0.1',1384922200,'1'),(1514,'127.0.0.1',1384922206,'1'),(1515,'127.0.0.1',1384922230,'1'),(1516,'127.0.0.1',1384922266,'1'),(1517,'127.0.0.1',1384922291,'1'),(1518,'127.0.0.1',1384922341,'1'),(1519,'127.0.0.1',1384922604,'1'),(1520,'127.0.0.1',1384922678,'1'),(1521,'127.0.0.1',1384923139,'1'),(1522,'127.0.0.1',1384923273,'1'),(1523,'127.0.0.1',1384923303,'1'),(1524,'127.0.0.1',1384923668,'1'),(1525,'127.0.0.1',1384923773,'1'),(1526,'127.0.0.1',1384923780,'1'),(1527,'127.0.0.1',1384923798,'1'),(1528,'127.0.0.1',1384923801,'1'),(1529,'127.0.0.1',1384923996,'1'),(1530,'127.0.0.1',1384923954,'1'),(1531,'127.0.0.1',1384924031,'1'),(1532,'127.0.0.1',1384924074,'1'),(1533,'127.0.0.1',1384924207,'1'),(1534,'127.0.0.1',1384924252,'1'),(1535,'127.0.0.1',1384924271,'1'),(1536,'127.0.0.1',1384924356,'1'),(1537,'127.0.0.1',1384924395,'1'),(1538,'127.0.0.1',1384924680,'1'),(1539,'127.0.0.1',1384924829,'1'),(1540,'127.0.0.1',1384924839,'1'),(1541,'127.0.0.1',1384924857,'1'),(1542,'127.0.0.1',1384924860,'1'),(1543,'127.0.0.1',1384924942,'1'),(1544,'127.0.0.1',1384925227,'1'),(1545,'127.0.0.1',1384925275,'1'),(1546,'127.0.0.1',1384925280,'1'),(1547,'127.0.0.1',1384925310,'1'),(1548,'127.0.0.1',1384925320,'1'),(1549,'127.0.0.1',1384925355,'1'),(1550,'127.0.0.1',1384925373,'1'),(1551,'127.0.0.1',1384925377,'1'),(1552,'127.0.0.1',1384925393,'1'),(1553,'127.0.0.1',1384925407,'1'),(1554,'127.0.0.1',1384925705,'1'),(1555,'127.0.0.1',1384925743,'1'),(1556,'127.0.0.1',1384925872,'1'),(1557,'127.0.0.1',1384925919,'1'),(1558,'127.0.0.1',1384925985,'1'),(1559,'127.0.0.1',1384926064,'1'),(1560,'127.0.0.1',1384926073,'1'),(1561,'127.0.0.1',1384926112,'1'),(1562,'127.0.0.1',1384926264,'1'),(1563,'127.0.0.1',1384926712,'1'),(1564,'127.0.0.1',1384926780,'1'),(1565,'127.0.0.1',1384926840,'1'),(1566,'127.0.0.1',1384926845,'1'),(1567,'127.0.0.1',1384926855,'1'),(1568,'127.0.0.1',1384926859,'1'),(1569,'127.0.0.1',1384927030,'1'),(1570,'127.0.0.1',1384927033,'1'),(1571,'127.0.0.1',1384927039,'1'),(1572,'127.0.0.1',1384934616,'1'),(1573,'127.0.0.1',1384934652,'1'),(1574,'127.0.0.1',1384934658,'1'),(1575,'127.0.0.1',1384934667,'1'),(1576,'127.0.0.1',1384935128,'1'),(1577,'127.0.0.1',1384935638,'1'),(1578,'127.0.0.1',1384935666,'1'),(1579,'127.0.0.1',1384935669,'1'),(1580,'127.0.0.1',1384935823,'1'),(1581,'127.0.0.1',1384935838,'1'),(1582,'127.0.0.1',1384935970,'1'),(1583,'127.0.0.1',1384935978,'1'),(1584,'127.0.0.1',1384935980,'1'),(1585,'127.0.0.1',1384935997,'1'),(1586,'127.0.0.1',1384936339,'1'),(1587,'127.0.0.1',1384936348,'1'),(1588,'127.0.0.1',1384936360,'1'),(1589,'127.0.0.1',1384936385,'1'),(1590,'127.0.0.1',1384936672,'1'),(1591,'127.0.0.1',1384936694,'1'),(1592,'127.0.0.1',1384936706,'1'),(1593,'127.0.0.1',1384936709,'1'),(1594,'127.0.0.1',1384936729,'1'),(1595,'127.0.0.1',1384936740,'1'),(1596,'127.0.0.1',1384936863,'1'),(1597,'127.0.0.1',1384938040,'1'),(1598,'127.0.0.1',1384938076,'1'),(1599,'127.0.0.1',1384938091,'1'),(1600,'127.0.0.1',1384938094,'1'),(1601,'127.0.0.1',1384938117,'1'),(1602,'127.0.0.1',1384938171,'1'),(1603,'127.0.0.1',1384938354,'1'),(1604,'127.0.0.1',1384938632,'1'),(1605,'127.0.0.1',1384938655,'1'),(1606,'127.0.0.1',1384941163,'1'),(1607,'127.0.0.1',1385017950,'1'),(1608,'127.0.0.1',1385018574,'1'),(1609,'127.0.0.1',1385018610,'1'),(1610,'127.0.0.1',1385018694,'1'),(1611,'127.0.0.1',1385018702,'1'),(1612,'127.0.0.1',1385018785,'1'),(1613,'127.0.0.1',1385018803,'1'),(1614,'127.0.0.1',1385018821,'1'),(1615,'127.0.0.1',1385018865,'1'),(1616,'127.0.0.1',1385018946,'1'),(1617,'127.0.0.1',1385018966,'1'),(1618,'127.0.0.1',1385018969,'1'),(1619,'127.0.0.1',1385019183,'1'),(1620,'127.0.0.1',1385019197,'1'),(1621,'127.0.0.1',1385019224,'1'),(1622,'127.0.0.1',1385019252,'1'),(1623,'127.0.0.1',1385019536,'1'),(1624,'127.0.0.1',1385025427,'1'),(1625,'127.0.0.1',1385089612,'1'),(1626,'127.0.0.1',1385089838,'1'),(1627,'127.0.0.1',1385090769,'1'),(1628,'127.0.0.1',1385091145,'1'),(1629,'127.0.0.1',1385091289,'1'),(1630,'127.0.0.1',1385091795,'1'),(1631,'127.0.0.1',1385091874,'1'),(1632,'127.0.0.1',1385091962,'1'),(1633,'127.0.0.1',1385092017,'1'),(1634,'127.0.0.1',1385092047,'1'),(1635,'127.0.0.1',1385092083,'1'),(1636,'127.0.0.1',1385092136,'1'),(1637,'127.0.0.1',1385092281,'1'),(1638,'127.0.0.1',1385092407,'1'),(1639,'127.0.0.1',1385092460,'1'),(1640,'127.0.0.1',1385092472,'1'),(1641,'127.0.0.1',1385092494,'1'),(1642,'127.0.0.1',1385092657,'1'),(1643,'127.0.0.1',1385093229,'1'),(1644,'127.0.0.1',1385093379,'1'),(1645,'127.0.0.1',1385093421,'1'),(1646,'127.0.0.1',1385093482,'1'),(1647,'127.0.0.1',1385093485,'1'),(1648,'127.0.0.1',1385093523,'1'),(1649,'127.0.0.1',1385093577,'1'),(1650,'127.0.0.1',1385093651,'1'),(1651,'127.0.0.1',1385093703,'1'),(1652,'127.0.0.1',1385093706,'1'),(1653,'127.0.0.1',1385093734,'1'),(1654,'127.0.0.1',1385093804,'1'),(1655,'127.0.0.1',1385093807,'1'),(1656,'127.0.0.1',1385094411,'1'),(1657,'127.0.0.1',1385094019,'1'),(1658,'127.0.0.1',1385094873,'1'),(1659,'127.0.0.1',1385094414,'1'),(1660,'127.0.0.1',1385094822,'1'),(1661,'127.0.0.1',1385094829,'1'),(1662,'127.0.0.1',1385094837,'1'),(1663,'127.0.0.1',1385094866,'1'),(1664,'127.0.0.1',1385095190,'1'),(1665,'127.0.0.1',1385094879,'1'),(1666,'127.0.0.1',1385094889,'1'),(1667,'127.0.0.1',1385094962,'1'),(1668,'127.0.0.1',1385094966,'1'),(1669,'127.0.0.1',1385094973,'1'),(1670,'127.0.0.1',1385094981,'1'),(1671,'127.0.0.1',1385094985,'1'),(1672,'127.0.0.1',1385094996,'1'),(1673,'127.0.0.1',1385095009,'1'),(1674,'127.0.0.1',1385095072,'1'),(1675,'127.0.0.1',1385095084,'1'),(1676,'127.0.0.1',1385095203,'1'),(1677,'127.0.0.1',1385095228,'1'),(1678,'127.0.0.1',1385095231,'1'),(1679,'127.0.0.1',1385095391,'1'),(1680,'127.0.0.1',1385095425,'1'),(1681,'127.0.0.1',1385095447,'1'),(1682,'127.0.0.1',1385095466,'1'),(1683,'127.0.0.1',1385095469,'1'),(1684,'127.0.0.1',1385095480,'1'),(1685,'127.0.0.1',1385096051,'1'),(1686,'127.0.0.1',1385096086,'1'),(1687,'127.0.0.1',1385096145,'1'),(1688,'127.0.0.1',1385096155,'1'),(1689,'127.0.0.1',1385096646,'1'),(1690,'127.0.0.1',1385096650,'1'),(1691,'127.0.0.1',1385096724,'1'),(1692,'127.0.0.1',1385096783,'1'),(1693,'127.0.0.1',1385096792,'1'),(1694,'127.0.0.1',1385096868,'1'),(1695,'127.0.0.1',1385096953,'1'),(1696,'127.0.0.1',1385096956,'1'),(1697,'127.0.0.1',1385097092,'1'),(1698,'127.0.0.1',1385097132,'1'),(1699,'127.0.0.1',1385097169,'1'),(1700,'127.0.0.1',1385097529,'1'),(1701,'127.0.0.1',1385098510,'1'),(1702,'127.0.0.1',1385098582,'1'),(1703,'127.0.0.1',1385098585,'1'),(1704,'127.0.0.1',1385098679,'1'),(1705,'127.0.0.1',1385098685,'1'),(1706,'127.0.0.1',1385098716,'1'),(1707,'127.0.0.1',1385098749,'1'),(1708,'127.0.0.1',1385098785,'1'),(1709,'127.0.0.1',1385098795,'1'),(1710,'127.0.0.1',1385098798,'1'),(1711,'127.0.0.1',1385098978,'1'),(1712,'127.0.0.1',1385099151,'1'),(1713,'127.0.0.1',1385099223,'1'),(1714,'127.0.0.1',1385099306,'1'),(1715,'127.0.0.1',1385099378,'1'),(1716,'127.0.0.1',1385099449,'1'),(1717,'127.0.0.1',1385099457,'1'),(1718,'127.0.0.1',1385099538,'1'),(1719,'127.0.0.1',1385099592,'1'),(1720,'127.0.0.1',1385100439,'1'),(1721,'127.0.0.1',1385100464,'1'),(1722,'127.0.0.1',1385100497,'1'),(1723,'127.0.0.1',1385100510,'1'),(1724,'127.0.0.1',1385100577,'1'),(1725,'127.0.0.1',1385350485,'1'),(1726,'127.0.0.1',1385352314,'1'),(1727,'127.0.0.1',1385352291,'1'),(1728,'127.0.0.1',1385352535,'1'),(1729,'127.0.0.1',1385352549,'1'),(1730,'127.0.0.1',1385352662,'1'),(1731,'127.0.0.1',1385352704,'1'),(1732,'127.0.0.1',1385353056,'1'),(1733,'127.0.0.1',1385353380,'1'),(1734,'127.0.0.1',1385353512,'1'),(1735,'127.0.0.1',1385353521,'1'),(1736,'127.0.0.1',1385353549,'1'),(1737,'127.0.0.1',1385353755,'1'),(1738,'127.0.0.1',1385353834,'1'),(1739,'127.0.0.1',1385354297,'1'),(1740,'127.0.0.1',1385354320,'1'),(1741,'127.0.0.1',1385354484,'1'),(1742,'127.0.0.1',1385354536,'1'),(1743,'127.0.0.1',1385354539,'1'),(1744,'127.0.0.1',1385354555,'1'),(1745,'127.0.0.1',1385354559,'1'),(1746,'127.0.0.1',1385354586,'1'),(1747,'127.0.0.1',1385354598,'1'),(1748,'127.0.0.1',1385354642,'1'),(1749,'127.0.0.1',1385354670,'1'),(1750,'127.0.0.1',1385354794,'1'),(1751,'127.0.0.1',1385354807,'1'),(1752,'127.0.0.1',1385354822,'1'),(1753,'127.0.0.1',1385355109,'1'),(1754,'127.0.0.1',1385355130,'1'),(1755,'127.0.0.1',1385355143,'1'),(1756,'127.0.0.1',1385355146,'1'),(1757,'127.0.0.1',1385355166,'1'),(1758,'127.0.0.1',1385355177,'1'),(1759,'127.0.0.1',1385355181,'1'),(1760,'127.0.0.1',1385355216,'1'),(1761,'127.0.0.1',1385356104,'1'),(1762,'127.0.0.1',1385439054,'1'),(1763,'127.0.0.1',1385439079,'1'),(1764,'127.0.0.1',1385439469,'1'),(1765,'127.0.0.1',1385607558,'1'),(1766,'127.0.0.1',1385607584,'1'),(1767,'127.0.0.1',1385607685,'1'),(1768,'127.0.0.1',1385607708,'1'),(1769,'127.0.0.1',1385607722,'1'),(1770,'127.0.0.1',1385607725,'1'),(1771,'127.0.0.1',1385607790,'1'),(1772,'127.0.0.1',1385609169,'1'),(1773,'127.0.0.1',1385609204,'1'),(1774,'127.0.0.1',1385609232,'1'),(1775,'127.0.0.1',1385609233,'1'),(1776,'127.0.0.1',1385609263,'1'),(1777,'127.0.0.1',1385609272,'1'),(1778,'127.0.0.1',1385609321,'1'),(1779,'127.0.0.1',1385610169,'1'),(1780,'127.0.0.1',1385610418,'1'),(1781,'127.0.0.1',1385610481,'1'),(1782,'127.0.0.1',1385610488,'1'),(1783,'127.0.0.1',1385610493,'1'),(1784,'127.0.0.1',1385610507,'1'),(1785,'127.0.0.1',1385610510,'1'),(1786,'127.0.0.1',1385610523,'1'),(1787,'127.0.0.1',1385610589,'1'),(1788,'127.0.0.1',1385610893,'1'),(1789,'127.0.0.1',1385611064,'1'),(1790,'127.0.0.1',1385611072,'1'),(1791,'127.0.0.1',1385611297,'1'),(1792,'127.0.0.1',1385611538,'1'),(1793,'127.0.0.1',1385611555,'1'),(1794,'127.0.0.1',1385611562,'1'),(1795,'127.0.0.1',1385611646,'1'),(1796,'127.0.0.1',1385612474,'1'),(1797,'127.0.0.1',1385612943,'1'),(1798,'127.0.0.1',1385612949,'1'),(1799,'127.0.0.1',1385613044,'1'),(1800,'127.0.0.1',1385613072,'1'),(1801,'127.0.0.1',1385613082,'1'),(1802,'127.0.0.1',1385613085,'1'),(1803,'127.0.0.1',1385613104,'1'),(1804,'127.0.0.1',1385613188,'1'),(1805,'127.0.0.1',1385613242,'1'),(1806,'127.0.0.1',1385613552,'1'),(1807,'127.0.0.1',1385614021,'1'),(1808,'127.0.0.1',1385613559,'1'),(1809,'127.0.0.1',1385613573,'1'),(1810,'127.0.0.1',1385615744,'1'),(1811,'127.0.0.1',1385614197,'1'),(1812,'127.0.0.1',1385614229,'1'),(1813,'127.0.0.1',1385614370,'1'),(1814,'127.0.0.1',1385614405,'1'),(1815,'127.0.0.1',1385614438,'1'),(1816,'127.0.0.1',1385614442,'1'),(1817,'127.0.0.1',1385614461,'1'),(1818,'127.0.0.1',1385615147,'1'),(1819,'127.0.0.1',1385615185,'1'),(1820,'127.0.0.1',1385615411,'1'),(1821,'127.0.0.1',1385615455,'1'),(1822,'127.0.0.1',1385615742,'1'),(1823,'127.0.0.1',1385615753,'1'),(1824,'127.0.0.1',1385615772,'1'),(1825,'127.0.0.1',1385616636,'1'),(1826,'127.0.0.1',1385623705,'1'),(1827,'127.0.0.1',1385623846,'1'),(1828,'127.0.0.1',1385623915,'1'),(1829,'127.0.0.1',1385623949,'1'),(1830,'127.0.0.1',1385624104,'1'),(1831,'127.0.0.1',1385624162,'1'),(1832,'127.0.0.1',1385624228,'1'),(1833,'127.0.0.1',1385624347,'1'),(1834,'127.0.0.1',1385624412,'1'),(1835,'127.0.0.1',1385624553,'1'),(1836,'127.0.0.1',1385624626,'1'),(1837,'127.0.0.1',1385624679,'1'),(1838,'127.0.0.1',1385624755,'1'),(1839,'127.0.0.1',1385624857,'1'),(1840,'127.0.0.1',1385625130,'1'),(1841,'127.0.0.1',1385625345,'1'),(1842,'127.0.0.1',1385625414,'1'),(1843,'127.0.0.1',1385626637,'1'),(1844,'127.0.0.1',1385628902,'1'),(1845,'127.0.0.1',1385628915,'1'),(1846,'127.0.0.1',1385628932,'1'),(1847,'127.0.0.1',1385628939,'1'),(1848,'127.0.0.1',1385628953,'1'),(1849,'127.0.0.1',1385629529,'1'),(1850,'127.0.0.1',1385629694,'1'),(1851,'127.0.0.1',1385629709,'1'),(1852,'127.0.0.1',1385629734,'1'),(1853,'127.0.0.1',1385629758,'1'),(1854,'127.0.0.1',1385629793,'1'),(1855,'127.0.0.1',1385629796,'1'),(1856,'127.0.0.1',1385629828,'1'),(1857,'127.0.0.1',1385629840,'1'),(1858,'127.0.0.1',1385629845,'1'),(1859,'127.0.0.1',1385629850,'1'),(1860,'127.0.0.1',1385629855,'1'),(1861,'127.0.0.1',1385629865,'1'),(1862,'127.0.0.1',1385630240,'1'),(1863,'127.0.0.1',1385630305,'1'),(1864,'127.0.0.1',1385630438,'1'),(1865,'127.0.0.1',1385630455,'1'),(1866,'127.0.0.1',1385630495,'1'),(1867,'127.0.0.1',1385630499,'1'),(1868,'127.0.0.1',1385630536,'1'),(1869,'127.0.0.1',1385630539,'1'),(1870,'127.0.0.1',1385630580,'1'),(1871,'127.0.0.1',1385630634,'1'),(1872,'127.0.0.1',1385630668,'1'),(1873,'127.0.0.1',1385630678,'1'),(1874,'127.0.0.1',1385630802,'1'),(1875,'127.0.0.1',1385630804,'1'),(1876,'127.0.0.1',1385630822,'1'),(1877,'127.0.0.1',1385630843,'1'),(1878,'127.0.0.1',1385630892,'1'),(1879,'127.0.0.1',1385631010,'1'),(1880,'127.0.0.1',1385631092,'1'),(1881,'127.0.0.1',1385631154,'1'),(1882,'127.0.0.1',1385631251,'1'),(1883,'127.0.0.1',1385631259,'1'),(1884,'127.0.0.1',1385631286,'1'),(1885,'127.0.0.1',1385631370,'1'),(1886,'127.0.0.1',1385631392,'1'),(1887,'127.0.0.1',1385631421,'1'),(1888,'127.0.0.1',1385631506,'1'),(1889,'127.0.0.1',1385631525,'1'),(1890,'127.0.0.1',1385631588,'1'),(1891,'127.0.0.1',1385631605,'1'),(1892,'127.0.0.1',1385631702,'1'),(1893,'127.0.0.1',1385631792,'1'),(1894,'127.0.0.1',1385631960,'1'),(1895,'127.0.0.1',1385631994,'1'),(1896,'127.0.0.1',1385632076,'1'),(1897,'127.0.0.1',1385632098,'1'),(1898,'127.0.0.1',1385632515,'1'),(1899,'127.0.0.1',1385632532,'1'),(1900,'127.0.0.1',1385632542,'1'),(1901,'127.0.0.1',1385632561,'1'),(1902,'127.0.0.1',1385632622,'1'),(1903,'127.0.0.1',1385632625,'1'),(1904,'127.0.0.1',1385632763,'1'),(1905,'127.0.0.1',1385632904,'1'),(1906,'127.0.0.1',1385632962,'1'),(1907,'127.0.0.1',1385633030,'1'),(1908,'127.0.0.1',1385633111,'1'),(1909,'127.0.0.1',1385633840,'1'),(1910,'127.0.0.1',1385633880,'1'),(1911,'127.0.0.1',1385633893,'1'),(1912,'127.0.0.1',1385633897,'1'),(1913,'127.0.0.1',1385633921,'1'),(1914,'127.0.0.1',1385633924,'1'),(1915,'127.0.0.1',1385633961,'1'),(1916,'127.0.0.1',1385634125,'1'),(1917,'127.0.0.1',1385634191,'1'),(1918,'127.0.0.1',1385634275,'1'),(1919,'127.0.0.1',1385634313,'1'),(1920,'127.0.0.1',1385634327,'1'),(1921,'127.0.0.1',1385634342,'1'),(1922,'127.0.0.1',1385634345,'1'),(1923,'127.0.0.1',1385634362,'1'),(1924,'127.0.0.1',1385634373,'1'),(1925,'127.0.0.1',1385634699,'1'),(1926,'127.0.0.1',1385634796,'1'),(1927,'127.0.0.1',1385634836,'1'),(1928,'127.0.0.1',1385634854,'1'),(1929,'127.0.0.1',1385634871,'1'),(1930,'127.0.0.1',1385634874,'1'),(1931,'127.0.0.1',1385634892,'1'),(1932,'127.0.0.1',1385634908,'1'),(1933,'127.0.0.1',1385634911,'1'),(1934,'127.0.0.1',1385634918,'1'),(1935,'127.0.0.1',1385634990,'1'),(1936,'127.0.0.1',1385635045,'1'),(1937,'127.0.0.1',1385635048,'1'),(1938,'127.0.0.1',1385635061,'1'),(1939,'127.0.0.1',1385635314,'1'),(1940,'127.0.0.1',1385635443,'1'),(1941,'127.0.0.1',1385636034,'1'),(1942,'127.0.0.1',1385636223,'1'),(1943,'127.0.0.1',1385636053,'1'),(1944,'127.0.0.1',1385636102,'1'),(1945,'127.0.0.1',1385636138,'1'),(1946,'127.0.0.1',1385636166,'1'),(1947,'127.0.0.1',1385638015,'1'),(1948,'127.0.0.1',1385637029,'1'),(1949,'127.0.0.1',1385636252,'1'),(1950,'127.0.0.1',1385636336,'1'),(1951,'127.0.0.1',1385636361,'1'),(1952,'127.0.0.1',1385636371,'1'),(1953,'127.0.0.1',1385636402,'1'),(1954,'127.0.0.1',1385636427,'1'),(1955,'127.0.0.1',1385637995,'1'),(1956,'127.0.0.1',1385638014,'1'),(1957,'127.0.0.1',1385693857,'1'),(1958,'127.0.0.1',1385694598,'1'),(1959,'127.0.0.1',1385694988,'1'),(1960,'127.0.0.1',1385695080,'1'),(1961,'127.0.0.1',1385695153,'1'),(1962,'127.0.0.1',1385695159,'1'),(1963,'127.0.0.1',1385695258,'1'),(1964,'127.0.0.1',1385695421,'1'),(1965,'127.0.0.1',1385695559,'1'),(1966,'127.0.0.1',1385697074,'1'),(1967,'127.0.0.1',1385697515,'1'),(1968,'127.0.0.1',1385697556,'1'),(1969,'127.0.0.1',1385697561,'1'),(1970,'127.0.0.1',1385697570,'1'),(1971,'127.0.0.1',1385697583,'1'),(1972,'127.0.0.1',1385698207,'1'),(1973,'127.0.0.1',1385700413,'1'),(1974,'127.0.0.1',1385698675,'1'),(1975,'127.0.0.1',1385698565,'1'),(1976,'127.0.0.1',1385700408,'1'),(1977,'127.0.0.1',1385698881,'1'),(1978,'127.0.0.1',1385698944,'1'),(1979,'127.0.0.1',1385699674,'1'),(1980,'127.0.0.1',1385699965,'1'),(1981,'127.0.0.1',1385699995,'1'),(1982,'127.0.0.1',1385700023,'1'),(1983,'127.0.0.1',1385700401,'1'),(1984,'127.0.0.1',1385709484,'1'),(1985,'127.0.0.1',1385709677,'1'),(1986,'127.0.0.1',1385709759,'1'),(1987,'127.0.0.1',1385709769,'1'),(1988,'127.0.0.1',1385712837,'1'),(1989,'127.0.0.1',1385709808,'1'),(1990,'127.0.0.1',1385709837,'1'),(1991,'127.0.0.1',1385709848,'1'),(1992,'127.0.0.1',1385709851,'1'),(1993,'127.0.0.1',1385709860,'1'),(1994,'127.0.0.1',1385709883,'1'),(1995,'127.0.0.1',1385709885,'1'),(1996,'127.0.0.1',1385710187,'1'),(1997,'127.0.0.1',1385710237,'1'),(1998,'127.0.0.1',1385710279,'1'),(1999,'127.0.0.1',1385710362,'1'),(2000,'127.0.0.1',1385710383,'1'),(2001,'127.0.0.1',1385710546,'1'),(2002,'127.0.0.1',1385710556,'1'),(2003,'127.0.0.1',1385711112,'1'),(2004,'127.0.0.1',1385711182,'1'),(2005,'127.0.0.1',1385711190,'1'),(2006,'127.0.0.1',1385711434,'1'),(2007,'127.0.0.1',1385711457,'1'),(2008,'127.0.0.1',1385711632,'1'),(2009,'127.0.0.1',1385711904,'1'),(2010,'127.0.0.1',1385711930,'1'),(2011,'127.0.0.1',1385712094,'1'),(2012,'127.0.0.1',1385712153,'1'),(2013,'127.0.0.1',1385712264,'1'),(2014,'127.0.0.1',1385712388,'1'),(2015,'127.0.0.1',1385712540,'1'),(2016,'127.0.0.1',1385712558,'1'),(2017,'127.0.0.1',1385712660,'1'),(2018,'127.0.0.1',1385712747,'1'),(2019,'127.0.0.1',1385712878,'1'),(2020,'127.0.0.1',1385712966,'1'),(2021,'127.0.0.1',1385713045,'1'),(2022,'127.0.0.1',1385713209,'1'),(2023,'127.0.0.1',1385713246,'1'),(2024,'127.0.0.1',1385713285,'1'),(2025,'127.0.0.1',1385713731,'1'),(2026,'127.0.0.1',1385713746,'1'),(2027,'127.0.0.1',1385714151,'1'),(2028,'127.0.0.1',1385714715,'1'),(2029,'127.0.0.1',1385714811,'1'),(2030,'127.0.0.1',1385714866,'1'),(2031,'127.0.0.1',1385714876,'1'),(2032,'127.0.0.1',1385715156,'1'),(2033,'127.0.0.1',1385715188,'1'),(2034,'127.0.0.1',1385715532,'1'),(2035,'127.0.0.1',1385715627,'1'),(2036,'127.0.0.1',1385715743,'1'),(2037,'127.0.0.1',1385715761,'1'),(2038,'127.0.0.1',1385715820,'1'),(2039,'127.0.0.1',1385716591,'1'),(2040,'127.0.0.1',1385717014,'1'),(2041,'127.0.0.1',1385717063,'1'),(2042,'127.0.0.1',1385717078,'1'),(2043,'127.0.0.1',1385717423,'1'),(2044,'127.0.0.1',1385717381,'1'),(2045,'127.0.0.1',1385717384,'1'),(2046,'127.0.0.1',1385717873,'1'),(2047,'127.0.0.1',1385718190,'1'),(2048,'127.0.0.1',1385718590,'1'),(2049,'127.0.0.1',1385718906,'1'),(2050,'127.0.0.1',1385718688,'1'),(2051,'127.0.0.1',1385718693,'1'),(2052,'127.0.0.1',1385718883,'1'),(2053,'127.0.0.1',1385719007,'1'),(2054,'127.0.0.1',1385719021,'1'),(2055,'127.0.0.1',1385719091,'1'),(2056,'127.0.0.1',1385719291,'1'),(2057,'127.0.0.1',1385719355,'1'),(2058,'127.0.0.1',1385719372,'1'),(2059,'127.0.0.1',1385719387,'1'),(2060,'127.0.0.1',1385719469,'1'),(2061,'127.0.0.1',1385719515,'1'),(2062,'127.0.0.1',1385719529,'1'),(2063,'127.0.0.1',1385719556,'1'),(2064,'127.0.0.1',1385719598,'1'),(2065,'127.0.0.1',1385719831,'1'),(2066,'127.0.0.1',1385719898,'1'),(2067,'127.0.0.1',1385719906,'1'),(2068,'127.0.0.1',1385719908,'1'),(2069,'127.0.0.1',1385719936,'1'),(2070,'127.0.0.1',1385719949,'1'),(2071,'127.0.0.1',1385719984,'1'),(2072,'127.0.0.1',1385720066,'1'),(2073,'127.0.0.1',1385720086,'1'),(2074,'127.0.0.1',1385720169,'1'),(2075,'127.0.0.1',1385720362,'1'),(2076,'127.0.0.1',1385720367,'1'),(2077,'127.0.0.1',1385720409,'1'),(2078,'127.0.0.1',1385720535,'1'),(2079,'127.0.0.1',1385720554,'1'),(2080,'127.0.0.1',1385720998,'1'),(2081,'127.0.0.1',1385721433,'1'),(2082,'127.0.0.1',1385721449,'1'),(2083,'127.0.0.1',1385721694,'1'),(2084,'127.0.0.1',1385721728,'1'),(2085,'127.0.0.1',1385722133,'1'),(2086,'127.0.0.1',1385722168,'1'),(2087,'127.0.0.1',1385722211,'1'),(2088,'127.0.0.1',1385722247,'1'),(2089,'127.0.0.1',1385722250,'1'),(2090,'127.0.0.1',1385722289,'1'),(2091,'127.0.0.1',1385722333,'1'),(2092,'127.0.0.1',1385722565,'1'),(2093,'127.0.0.1',1385722594,'1'),(2094,'127.0.0.1',1385722624,'1'),(2095,'127.0.0.1',1385722667,'1'),(2096,'127.0.0.1',1385722731,'1'),(2097,'127.0.0.1',1385722846,'1'),(2098,'127.0.0.1',1385722885,'1'),(2099,'127.0.0.1',1385722909,'1'),(2100,'127.0.0.1',1385722952,'1'),(2101,'127.0.0.1',1385722969,'1'),(2102,'127.0.0.1',1385723173,'1'),(2103,'127.0.0.1',1385723277,'1'),(2104,'127.0.0.1',1385724283,'1'),(2105,'127.0.0.1',1385779374,'1'),(2106,'127.0.0.1',1385780146,'1'),(2107,'127.0.0.1',1385780858,'1'),(2108,'127.0.0.1',1385780862,'1'),(2109,'127.0.0.1',1385780880,'1'),(2110,'127.0.0.1',1385781439,'1'),(2111,'127.0.0.1',1385781450,'1'),(2112,'127.0.0.1',1385781462,'1'),(2113,'127.0.0.1',1385781586,'1'),(2114,'127.0.0.1',1385782013,'1'),(2115,'127.0.0.1',1385782021,'1'),(2116,'127.0.0.1',1385782055,'1'),(2117,'127.0.0.1',1385782098,'1'),(2118,'127.0.0.1',1385782158,'1'),(2119,'127.0.0.1',1385782166,'1'),(2120,'127.0.0.1',1385782209,'1'),(2121,'127.0.0.1',1385782978,'1'),(2122,'127.0.0.1',1385783070,'1'),(2123,'127.0.0.1',1385783117,'1'),(2124,'127.0.0.1',1385783177,'1'),(2125,'127.0.0.1',1385783235,'1'),(2126,'127.0.0.1',1385783613,'1'),(2127,'127.0.0.1',1385783617,'1'),(2128,'127.0.0.1',1385783717,'1'),(2129,'127.0.0.1',1385783738,'1'),(2130,'127.0.0.1',1385783764,'1'),(2131,'127.0.0.1',1385783807,'1'),(2132,'127.0.0.1',1385783820,'1'),(2133,'127.0.0.1',1385783863,'1'),(2134,'127.0.0.1',1385783979,'1'),(2135,'127.0.0.1',1385783982,'1'),(2136,'127.0.0.1',1385784114,'1'),(2137,'127.0.0.1',1385784134,'1'),(2138,'127.0.0.1',1385784177,'1'),(2139,'127.0.0.1',1385784195,'1'),(2140,'127.0.0.1',1385784238,'1'),(2141,'127.0.0.1',1385784381,'1'),(2142,'127.0.0.1',1385784420,'1'),(2143,'127.0.0.1',1385784604,'1'),(2144,'127.0.0.1',1385784633,'1'),(2145,'127.0.0.1',1385784677,'1'),(2146,'127.0.0.1',1385784709,'1'),(2147,'127.0.0.1',1385784720,'1'),(2148,'127.0.0.1',1385784802,'1'),(2149,'127.0.0.1',1385784864,'1'),(2150,'127.0.0.1',1385785176,'1'),(2151,'127.0.0.1',1385785207,'1'),(2152,'127.0.0.1',1385785209,'1'),(2153,'127.0.0.1',1385785242,'1'),(2154,'127.0.0.1',1385785284,'1'),(2155,'127.0.0.1',1385785298,'1'),(2156,'127.0.0.1',1385785340,'1'),(2157,'127.0.0.1',1385785362,'1'),(2158,'127.0.0.1',1385785584,'1'),(2159,'127.0.0.1',1385785591,'1'),(2160,'127.0.0.1',1385785600,'1'),(2161,'127.0.0.1',1385785603,'1'),(2162,'127.0.0.1',1385785611,'1'),(2163,'127.0.0.1',1385785617,'1'),(2164,'127.0.0.1',1385785700,'1'),(2165,'127.0.0.1',1385785705,'1'),(2166,'127.0.0.1',1385785778,'1'),(2167,'127.0.0.1',1385785786,'1'),(2168,'127.0.0.1',1385785791,'1'),(2169,'127.0.0.1',1385786236,'1'),(2170,'127.0.0.1',1385786262,'1'),(2171,'127.0.0.1',1385786271,'1'),(2172,'127.0.0.1',1385786273,'1'),(2173,'127.0.0.1',1385786293,'1'),(2174,'127.0.0.1',1385786296,'1'),(2175,'127.0.0.1',1385786307,'1'),(2176,'127.0.0.1',1385786311,'1'),(2177,'127.0.0.1',1385786353,'1'),(2178,'127.0.0.1',1385786372,'1'),(2179,'127.0.0.1',1385786426,'1'),(2180,'127.0.0.1',1385786437,'1'),(2181,'127.0.0.1',1385786439,'1'),(2182,'127.0.0.1',1385786453,'1'),(2183,'127.0.0.1',1385786455,'1'),(2184,'127.0.0.1',1385786495,'1'),(2185,'127.0.0.1',1385786499,'1'),(2186,'127.0.0.1',1385786629,'1'),(2187,'127.0.0.1',1385786655,'1'),(2188,'127.0.0.1',1385786679,'1'),(2189,'127.0.0.1',1385786785,'1'),(2190,'127.0.0.1',1385786821,'1'),(2191,'127.0.0.1',1385786830,'1'),(2192,'127.0.0.1',1385786857,'1'),(2193,'127.0.0.1',1385786873,'1'),(2194,'127.0.0.1',1385786876,'1'),(2195,'127.0.0.1',1385786935,'1'),(2196,'127.0.0.1',1385787379,'1'),(2197,'127.0.0.1',1385788150,'1'),(2198,'127.0.0.1',1385788172,'1'),(2199,'127.0.0.1',1385788436,'1'),(2200,'127.0.0.1',1385788451,'1'),(2201,'127.0.0.1',1385788575,'1'),(2202,'127.0.0.1',1385788601,'1'),(2203,'127.0.0.1',1385788685,'1'),(2204,'127.0.0.1',1385788694,'1'),(2205,'127.0.0.1',1385789299,'1'),(2206,'127.0.0.1',1385789308,'1'),(2207,'127.0.0.1',1385789344,'1'),(2208,'127.0.0.1',1385789789,'1'),(2209,'127.0.0.1',1385789795,'1'),(2210,'127.0.0.1',1385789825,'1'),(2211,'127.0.0.1',1385789839,'1'),(2212,'127.0.0.1',1385789883,'1'),(2213,'127.0.0.1',1385789894,'1'),(2214,'127.0.0.1',1385789937,'1'),(2215,'127.0.0.1',1385790036,'1'),(2216,'127.0.0.1',1385790039,'1'),(2217,'127.0.0.1',1385790084,'1'),(2218,'127.0.0.1',1385790148,'1'),(2219,'127.0.0.1',1385790253,'1'),(2220,'127.0.0.1',1385790260,'1'),(2221,'127.0.0.1',1385791203,'1'),(2222,'127.0.0.1',1385791316,'1'),(2223,'127.0.0.1',1385791351,'1'),(2224,'127.0.0.1',1385791368,'1'),(2225,'127.0.0.1',1385791372,'1'),(2226,'127.0.0.1',1385791387,'1'),(2227,'127.0.0.1',1385791453,'1'),(2228,'127.0.0.1',1385791460,'1'),(2229,'127.0.0.1',1385791785,'1'),(2230,'127.0.0.1',1385791806,'1'),(2231,'127.0.0.1',1385791817,'1'),(2232,'127.0.0.1',1385791901,'1'),(2233,'127.0.0.1',1385791966,'1'),(2234,'127.0.0.1',1385791973,'1'),(2235,'127.0.0.1',1385792013,'1'),(2236,'127.0.0.1',1385792037,'1'),(2237,'127.0.0.1',1385792151,'1'),(2238,'127.0.0.1',1385792254,'1'),(2239,'127.0.0.1',1385792263,'1'),(2240,'127.0.0.1',1385792279,'1'),(2241,'127.0.0.1',1385792283,'1'),(2242,'127.0.0.1',1385792678,'1'),(2243,'127.0.0.1',1385792717,'1'),(2244,'127.0.0.1',1385792755,'1'),(2245,'127.0.0.1',1385792814,'1'),(2246,'127.0.0.1',1385792817,'1'),(2247,'127.0.0.1',1385792856,'1'),(2248,'127.0.0.1',1385792914,'1'),(2249,'127.0.0.1',1385792932,'1'),(2250,'127.0.0.1',1385792991,'1'),(2251,'127.0.0.1',1385794521,'1'),(2252,'127.0.0.1',1385794535,'1'),(2253,'127.0.0.1',1385794667,'1'),(2254,'127.0.0.1',1385794696,'1'),(2255,'127.0.0.1',1385794739,'1'),(2256,'127.0.0.1',1385794843,'1'),(2257,'127.0.0.1',1385795105,'1'),(2258,'127.0.0.1',1385795392,'1'),(2259,'127.0.0.1',1385796323,'1'),(2260,'127.0.0.1',1385796331,'1'),(2261,'127.0.0.1',1385796358,'1'),(2262,'127.0.0.1',1385796368,'1'),(2263,'127.0.0.1',1385796372,'1'),(2264,'127.0.0.1',1385796418,'1'),(2265,'127.0.0.1',1385796426,'1'),(2266,'127.0.0.1',1385796549,'1'),(2267,'127.0.0.1',1385796789,'1'),(2268,'127.0.0.1',1385796915,'1'),(2269,'127.0.0.1',1385797073,'1'),(2270,'127.0.0.1',1385797119,'1'),(2271,'127.0.0.1',1385797127,'1'),(2272,'127.0.0.1',1385797250,'1'),(2273,'127.0.0.1',1385797273,'1'),(2274,'127.0.0.1',1385797286,'1'),(2275,'127.0.0.1',1385797611,'1'),(2276,'127.0.0.1',1385797623,'1'),(2277,'127.0.0.1',1385797770,'1'),(2278,'127.0.0.1',1385797776,'1'),(2279,'127.0.0.1',1385797868,'1'),(2280,'127.0.0.1',1385797932,'1'),(2281,'127.0.0.1',1385797989,'1'),(2282,'127.0.0.1',1385798043,'1'),(2283,'127.0.0.1',1385798070,'1'),(2284,'127.0.0.1',1385798175,'1'),(2285,'127.0.0.1',1385798387,'1'),(2286,'127.0.0.1',1385798406,'1'),(2287,'127.0.0.1',1385798423,'1'),(2288,'127.0.0.1',1385798678,'1'),(2289,'127.0.0.1',1385952778,'1'),(2290,'127.0.0.1',1385952815,'1'),(2291,'127.0.0.1',1385952818,'1'),(2292,'127.0.0.1',1385953425,'1'),(2293,'127.0.0.1',1385954620,'1'),(2294,'127.0.0.1',1385954696,'1'),(2295,'127.0.0.1',1385954807,'1'),(2296,'127.0.0.1',1385955270,'1'),(2297,'127.0.0.1',1385955461,'1'),(2298,'127.0.0.1',1385956007,'1'),(2299,'127.0.0.1',1385956024,'1'),(2300,'127.0.0.1',1385956160,'1'),(2301,'127.0.0.1',1385956185,'1'),(2302,'127.0.0.1',1385956328,'1'),(2303,'127.0.0.1',1385956390,'1'),(2304,'127.0.0.1',1385956403,'1'),(2305,'127.0.0.1',1385956475,'1'),(2306,'127.0.0.1',1385956473,'1'),(2307,'127.0.0.1',1385956523,'1'),(2308,'127.0.0.1',1385956538,'1'),(2309,'127.0.0.1',1385956565,'1'),(2310,'127.0.0.1',1385956665,'1'),(2311,'127.0.0.1',1385956778,'1'),(2312,'127.0.0.1',1385956847,'1'),(2313,'127.0.0.1',1385957031,'1'),(2314,'127.0.0.1',1385957131,'1'),(2315,'127.0.0.1',1385957162,'1'),(2316,'127.0.0.1',1385957193,'1'),(2317,'127.0.0.1',1385957227,'1'),(2318,'127.0.0.1',1385957792,'1'),(2319,'127.0.0.1',1385957834,'1'),(2320,'127.0.0.1',1385957868,'1'),(2321,'127.0.0.1',1385958071,'1'),(2322,'127.0.0.1',1385958177,'1'),(2323,'127.0.0.1',1385958181,'1'),(2324,'127.0.0.1',1385958198,'1'),(2325,'127.0.0.1',1385958203,'1'),(2326,'127.0.0.1',1385958207,'1'),(2327,'127.0.0.1',1385958215,'1'),(2328,'127.0.0.1',1385958254,'1'),(2329,'127.0.0.1',1385958378,'1'),(2330,'127.0.0.1',1385958405,'1'),(2331,'127.0.0.1',1385958437,'1'),(2332,'127.0.0.1',1385958681,'1'),(2333,'127.0.0.1',1385958905,'1'),(2334,'127.0.0.1',1385958932,'1'),(2335,'127.0.0.1',1385959006,'1'),(2336,'127.0.0.1',1385959045,'1'),(2337,'127.0.0.1',1385959075,'1'),(2338,'127.0.0.1',1385959100,'1'),(2339,'127.0.0.1',1385959144,'1'),(2340,'127.0.0.1',1385959177,'1'),(2341,'127.0.0.1',1385959345,'1'),(2342,'127.0.0.1',1385959356,'1'),(2343,'127.0.0.1',1385959374,'1'),(2344,'127.0.0.1',1385959403,'1'),(2345,'127.0.0.1',1385959551,'1'),(2346,'127.0.0.1',1385959568,'1'),(2347,'127.0.0.1',1385959572,'1'),(2348,'127.0.0.1',1385959609,'1'),(2349,'127.0.0.1',1385960030,'1'),(2350,'127.0.0.1',1385960051,'1'),(2351,'127.0.0.1',1385960162,'1'),(2352,'127.0.0.1',1385960167,'1'),(2353,'127.0.0.1',1385960179,'1'),(2354,'127.0.0.1',1385960182,'1'),(2355,'127.0.0.1',1385960242,'1'),(2356,'127.0.0.1',1385960311,'1'),(2357,'127.0.0.1',1385960322,'1'),(2358,'127.0.0.1',1385960440,'1'),(2359,'127.0.0.1',1385960483,'1'),(2360,'127.0.0.1',1385960499,'1'),(2361,'127.0.0.1',1385960525,'1'),(2362,'127.0.0.1',1385960559,'1'),(2363,'127.0.0.1',1385960812,'1'),(2364,'127.0.0.1',1385962235,'1'),(2365,'127.0.0.1',1385962258,'1'),(2366,'127.0.0.1',1385962278,'1'),(2367,'127.0.0.1',1385962295,'1'),(2368,'127.0.0.1',1385962306,'1'),(2369,'127.0.0.1',1385963834,'1'),(2370,'127.0.0.1',1385964905,'1'),(2371,'127.0.0.1',1385965016,'1'),(2372,'127.0.0.1',1385965108,'1'),(2373,'127.0.0.1',1385965116,'1'),(2374,'127.0.0.1',1385965121,'1'),(2375,'127.0.0.1',1385965170,'1'),(2376,'127.0.0.1',1385965184,'1'),(2377,'127.0.0.1',1385965263,'1'),(2378,'127.0.0.1',1385967883,'1'),(2379,'192.168.1.138',1385966636,'1'),(2380,'192.168.1.138',1385966649,'1'),(2381,'192.168.1.138',1385966675,'1'),(2382,'192.168.1.138',1385966681,'1'),(2383,'192.168.1.138',1385966686,'1'),(2384,'192.168.1.138',1385966697,'1'),(2385,'192.168.1.138',1385966715,'1'),(2386,'192.168.1.138',1385966725,'1'),(2387,'192.168.1.138',1385967091,'1'),(2388,'192.168.1.138',1385967116,'1'),(2389,'192.168.1.138',1385967525,'1'),(2390,'192.168.1.138',1385967536,'1'),(2391,'192.168.1.138',1385967562,'1'),(2392,'192.168.1.138',1385967580,'1'),(2393,'192.168.1.138',1385967597,'1'),(2394,'192.168.1.138',1385967608,'1'),(2395,'192.168.1.138',1385967609,'1'),(2396,'192.168.1.138',1385967708,'1'),(2397,'192.168.1.138',1385967711,'1'),(2398,'192.168.1.138',1385967773,'1'),(2399,'192.168.1.138',1385967807,'1'),(2400,'192.168.1.138',1385967870,'1'),(2401,'127.0.0.1',1385967900,'1'),(2402,'192.168.1.138',1385967905,'1'),(2403,'127.0.0.1',1385968069,'1'),(2404,'192.168.1.138',1385967915,'1'),(2405,'192.168.1.138',1385967974,'1'),(2406,'192.168.1.138',1385967976,'1'),(2407,'192.168.1.138',1385968074,'1'),(2408,'127.0.0.1',1385968754,'1'),(2409,'192.168.1.138',1385968089,'1'),(2410,'192.168.1.138',1385968357,'1'),(2411,'192.168.1.138',1385968403,'1'),(2412,'192.168.1.138',1385968648,'1'),(2413,'192.168.1.138',1385968730,'1'),(2414,'192.168.1.138',1385968755,'1'),(2415,'127.0.0.1',1385968786,'1'),(2416,'192.168.1.138',1385968792,'1'),(2417,'127.0.0.1',1385968877,'1'),(2418,'192.168.1.138',1385969374,'1'),(2419,'127.0.0.1',1385968826,'1'),(2420,'127.0.0.1',1385968988,'1'),(2421,'127.0.0.1',1385968939,'1'),(2422,'127.0.0.1',1385969621,'1'),(2423,'127.0.0.1',1385970065,'1'),(2424,'192.168.1.138',1385969404,'1'),(2425,'192.168.1.138',1385972111,'1'),(2426,'127.0.0.1',1385969627,'1'),(2427,'127.0.0.1',1385969656,'1'),(2428,'127.0.0.1',1385969683,'1'),(2429,'127.0.0.1',1385969735,'1'),(2430,'127.0.0.1',1385969756,'1'),(2431,'127.0.0.1',1385969856,'1'),(2432,'127.0.0.1',1385969887,'1'),(2433,'127.0.0.1',1385969904,'1'),(2434,'127.0.0.1',1385969915,'1'),(2435,'127.0.0.1',1385972578,'1'),(2436,'127.0.0.1',1385971742,'1'),(2437,'192.168.1.138',1385971040,'1'),(2438,'127.0.0.1',1385972108,'1'),(2439,'192.168.1.138',1385972124,'1'),(2440,'127.0.0.1',1385972187,'1'),(2441,'192.168.1.138',1385972160,'1'),(2442,'192.168.1.138',1385972208,'1'),(2443,'192.168.1.138',1385972241,'1'),(2444,'192.168.1.138',1385972255,'1'),(2445,'127.0.0.1',1385972376,'1'),(2446,'192.168.1.138',1385972281,'1'),(2447,'192.168.1.138',1385972332,'1'),(2448,'192.168.1.138',1385972353,'1'),(2449,'127.0.0.1',1385972383,'1'),(2450,'192.168.1.138',1385972386,'1'),(2451,'127.0.0.1',1385972390,'1'),(2452,'192.168.1.138',1385972394,'1'),(2453,'127.0.0.1',1385972398,'1'),(2454,'127.0.0.1',1385972403,'1'),(2455,'127.0.0.1',1385983724,'1'),(2456,'192.168.1.138',1385972430,'1'),(2457,'192.168.1.138',1385972440,'1'),(2458,'192.168.1.138',1385972509,'1'),(2459,'192.168.1.138',1385972515,'1'),(2460,'192.168.1.138',1385972531,'1'),(2461,'192.168.1.138',1385972581,'1'),(2462,'192.168.1.138',1385972584,'1'),(2463,'127.0.0.1',1385972596,'1'),(2464,'192.168.1.138',1385976242,'1'),(2465,'127.0.0.1',1385978868,'1'),(2466,'127.0.0.1',1385980381,'1'),(2467,'192.168.1.138',1385979096,'1'),(2468,'192.168.1.138',1385979122,'1'),(2469,'192.168.1.138',1385979150,'1'),(2470,'192.168.1.138',1385979185,'1'),(2471,'192.168.1.138',1385979191,'1'),(2472,'192.168.1.138',1385979197,'1'),(2473,'192.168.1.138',1385979223,'1'),(2474,'192.168.1.138',1385979228,'1'),(2475,'192.168.1.138',1385979248,'1'),(2476,'192.168.1.138',1385979325,'1'),(2477,'192.168.1.138',1385979394,'1'),(2478,'192.168.1.138',1385979399,'1'),(2479,'192.168.1.138',1385979411,'1'),(2480,'192.168.1.138',1385979469,'1'),(2481,'192.168.1.138',1385979498,'1'),(2482,'192.168.1.138',1385979528,'1'),(2483,'192.168.1.138',1385979553,'1'),(2484,'192.168.1.138',1385979576,'1'),(2485,'192.168.1.138',1385979601,'1'),(2486,'192.168.1.138',1385979633,'1'),(2487,'192.168.1.138',1385979712,'1'),(2488,'192.168.1.138',1385979722,'1'),(2489,'192.168.1.138',1385979747,'1'),(2490,'192.168.1.138',1385979769,'1'),(2491,'192.168.1.138',1385979778,'1'),(2492,'192.168.1.138',1385979803,'1'),(2493,'192.168.1.138',1385979823,'1'),(2494,'192.168.1.138',1385979881,'1'),(2495,'192.168.1.138',1385979972,'1'),(2496,'192.168.1.138',1385979991,'1'),(2497,'192.168.1.138',1385979995,'1'),(2498,'192.168.1.138',1385980056,'1'),(2499,'192.168.1.138',1385980077,'1'),(2500,'192.168.1.138',1385980082,'1'),(2501,'192.168.1.138',1385980109,'1'),(2502,'192.168.1.138',1385980126,'1'),(2503,'192.168.1.138',1385980137,'1'),(2504,'192.168.1.138',1385980161,'1'),(2505,'192.168.1.138',1385980178,'1'),(2506,'192.168.1.138',1385980197,'1'),(2507,'192.168.1.138',1385980284,'1'),(2508,'192.168.1.138',1385980393,'1'),(2509,'127.0.0.1',1385980597,'1'),(2510,'192.168.1.138',1385980397,'1'),(2511,'192.168.1.138',1385980404,'1'),(2512,'192.168.1.138',1385980473,'1'),(2513,'192.168.1.138',1385980497,'1'),(2514,'192.168.1.138',1385980513,'1'),(2515,'192.168.1.138',1385980543,'1'),(2516,'192.168.1.138',1385981103,'1'),(2517,'127.0.0.1',1385980624,'1'),(2518,'127.0.0.1',1385980715,'1'),(2519,'127.0.0.1',1385980929,'1'),(2520,'192.168.1.138',1385981117,'1'),(2521,'192.168.1.138',1385981177,'1'),(2522,'127.0.0.1',1385981143,'1'),(2523,'192.168.1.138',1385981180,'1'),(2524,'192.168.1.138',1385981189,'1'),(2525,'127.0.0.1',1385981189,'1'),(2526,'192.168.1.138',1385981207,'1'),(2527,'192.168.1.138',1385981279,'1'),(2528,'192.168.1.138',1385981306,'1'),(2529,'192.168.1.138',1385981344,'1'),(2530,'192.168.1.138',1385981378,'1'),(2531,'192.168.1.138',1385981405,'1'),(2532,'192.168.1.138',1385981450,'1'),(2533,'192.168.1.138',1385981470,'1'),(2534,'192.168.1.138',1385981477,'1'),(2535,'192.168.1.138',1385981543,'1'),(2536,'127.0.0.1',1385981561,'1'),(2537,'192.168.1.138',1385981558,'1'),(2538,'192.168.1.138',1385981605,'1'),(2539,'192.168.1.138',1385981608,'1'),(2540,'192.168.1.138',1385981680,'1'),(2541,'192.168.1.138',1385981697,'1'),(2542,'192.168.1.138',1385981712,'1'),(2543,'192.168.1.138',1385981717,'1'),(2544,'192.168.1.138',1385981743,'1'),(2545,'192.168.1.138',1385981752,'1'),(2546,'192.168.1.138',1385981785,'1'),(2547,'192.168.1.138',1385981799,'1'),(2548,'192.168.1.138',1385981816,'1'),(2549,'192.168.1.138',1385981865,'1'),(2550,'192.168.1.138',1385981875,'1'),(2551,'192.168.1.138',1385981882,'1'),(2552,'192.168.1.138',1385981911,'1'),(2553,'127.0.0.1',1385982119,'1'),(2554,'192.168.1.138',1385981940,'1'),(2555,'192.168.1.138',1385981987,'1'),(2556,'192.168.1.138',1385982006,'1'),(2557,'192.168.1.138',1385982036,'1'),(2558,'192.168.1.138',1385982045,'1'),(2559,'192.168.1.138',1385982080,'1'),(2560,'192.168.1.138',1385982095,'1'),(2561,'192.168.1.138',1385982102,'1'),(2562,'192.168.1.138',1385982151,'1'),(2563,'192.168.1.138',1385982226,'1'),(2564,'127.0.0.1',1385982211,'1'),(2565,'192.168.1.138',1385982230,'1'),(2566,'127.0.0.1',1385982482,'1'),(2567,'192.168.1.138',1385982254,'1'),(2568,'192.168.1.138',1385982272,'1'),(2569,'192.168.1.138',1385982280,'1'),(2570,'192.168.1.138',1385982312,'1'),(2571,'192.168.1.138',1385982327,'1'),(2572,'192.168.1.138',1385982335,'1'),(2573,'192.168.1.138',1385982360,'1'),(2574,'192.168.1.138',1385982415,'1'),(2575,'192.168.1.138',1385982425,'1'),(2576,'192.168.1.138',1385982462,'1'),(2577,'192.168.1.138',1385982479,'1'),(2578,'192.168.1.138',1385982490,'1'),(2579,'127.0.0.1',1385982705,'1'),(2580,'192.168.1.138',1385982517,'1'),(2581,'192.168.1.138',1385982532,'1'),(2582,'192.168.1.138',1385982539,'1'),(2583,'192.168.1.138',1385982576,'1'),(2584,'192.168.1.138',1385982593,'1'),(2585,'192.168.1.138',1385982602,'1'),(2586,'192.168.1.138',1385982634,'1'),(2587,'192.168.1.138',1385982692,'1'),(2588,'192.168.1.138',1385982697,'1'),(2589,'192.168.1.138',1385982705,'1'),(2590,'192.168.1.138',1385982725,'1'),(2591,'192.168.1.138',1385982737,'1'),(2592,'127.0.0.1',1385982859,'1'),(2593,'192.168.1.138',1385982753,'1'),(2594,'192.168.1.138',1385982764,'1'),(2595,'192.168.1.138',1385982787,'1'),(2596,'192.168.1.138',1385982802,'1'),(2597,'192.168.1.138',1385982819,'1'),(2598,'192.168.1.138',1385982844,'1'),(2599,'192.168.1.138',1385982853,'1'),(2600,'127.0.0.1',1385983505,'1'),(2601,'192.168.1.138',1385982876,'1'),(2602,'192.168.1.138',1385982891,'1'),(2603,'192.168.1.138',1385982900,'1'),(2604,'192.168.1.138',1385982915,'1'),(2605,'192.168.1.138',1385982949,'1'),(2606,'192.168.1.138',1385982967,'1'),(2607,'192.168.1.138',1385982996,'1'),(2608,'192.168.1.138',1385983087,'1'),(2609,'192.168.1.138',1385983150,'1'),(2610,'192.168.1.138',1385983154,'1'),(2611,'192.168.1.138',1385983180,'1'),(2612,'192.168.1.138',1385983195,'1'),(2613,'192.168.1.138',1385983204,'1'),(2614,'192.168.1.138',1385983224,'1'),(2615,'192.168.1.138',1385983241,'1'),(2616,'192.168.1.138',1385983265,'1'),(2617,'192.168.1.138',1385983267,'1'),(2618,'192.168.1.138',1385983273,'1'),(2619,'192.168.1.138',1385983300,'1'),(2620,'192.168.1.138',1385983319,'1'),(2621,'192.168.1.138',1385983326,'1'),(2622,'192.168.1.138',1385983368,'1'),(2623,'192.168.1.138',1385983398,'1'),(2624,'192.168.1.138',1385983402,'1'),(2625,'192.168.1.138',1385983424,'1'),(2626,'192.168.1.138',1385983436,'1'),(2627,'192.168.1.138',1385983439,'1'),(2628,'192.168.1.138',1385983465,'1'),(2629,'192.168.1.138',1385983483,'1'),(2630,'192.168.1.138',1385983494,'1'),(2631,'127.0.0.1',1385983557,'1'),(2632,'192.168.1.138',1385983523,'1'),(2633,'192.168.1.138',1385983535,'1'),(2634,'192.168.1.138',1385983557,'1'),(2635,'127.0.0.1',1385983561,'1'),(2636,'192.168.1.138',1385983571,'1'),(2637,'127.0.0.1',1385983592,'1'),(2638,'127.0.0.1',1385983683,'1'),(2639,'192.168.1.138',1385983603,'1'),(2640,'192.168.1.138',1385983659,'1'),(2641,'192.168.1.138',1385983765,'1'),(2642,'127.0.0.1',1385983749,'1'),(2643,'192.168.1.138',1386038912,'1'),(2644,'192.168.1.138',1386039590,'1'),(2645,'127.0.0.1',1386040166,'1'),(2646,'127.0.0.1',1386040698,'1'),(2647,'127.0.0.1',1386043106,'1'),(2648,'192.168.1.138',1386040709,'1'),(2649,'127.0.0.1',1386041109,'1'),(2650,'127.0.0.1',1386041339,'1'),(2651,'127.0.0.1',1386041487,'1'),(2652,'127.0.0.1',1386041787,'1'),(2653,'127.0.0.1',1386041872,'1'),(2654,'127.0.0.1',1386042052,'1'),(2655,'127.0.0.1',1386042246,'1'),(2656,'127.0.0.1',1386042309,'1'),(2657,'192.168.1.138',1386042729,'1'),(2658,'127.0.0.1',1386042315,'1'),(2659,'127.0.0.1',1386042330,'1'),(2660,'127.0.0.1',1386042401,'1'),(2661,'127.0.0.1',1386042815,'1'),(2662,'127.0.0.1',1386042408,'1'),(2663,'127.0.0.1',1386042529,'1'),(2664,'127.0.0.1',1386042563,'1'),(2665,'127.0.0.1',1386042670,'1'),(2666,'127.0.0.1',1386045506,'1'),(2667,'127.0.0.1',1386042722,'1'),(2668,'127.0.0.1',1386045541,'1'),(2669,'192.168.1.138',1386058069,'1'),(2670,'127.0.0.1',1386042960,'1'),(2671,'127.0.0.1',1386043053,'1'),(2672,'127.0.0.1',1386043162,'1'),(2673,'127.0.0.1',1386043200,'1'),(2674,'127.0.0.1',1386045602,'1'),(2675,'127.0.0.1',1386046317,'1'),(2676,'127.0.0.1',1386048311,'1'),(2677,'127.0.0.1',1386045957,'1'),(2678,'127.0.0.1',1386046109,'1'),(2679,'127.0.0.1',1386046128,'1'),(2680,'127.0.0.1',1386051496,'1'),(2681,'127.0.0.1',1386046621,'1'),(2682,'127.0.0.1',1386047411,'1'),(2683,'127.0.0.1',1386047431,'1'),(2684,'127.0.0.1',1386047440,'1'),(2685,'127.0.0.1',1386047511,'1'),(2686,'127.0.0.1',1386047587,'1'),(2687,'127.0.0.1',1386047599,'1'),(2688,'127.0.0.1',1386047625,'1'),(2689,'127.0.0.1',1386047654,'1'),(2690,'127.0.0.1',1386047668,'1'),(2691,'127.0.0.1',1386047841,'1'),(2692,'127.0.0.1',1386047869,'1'),(2693,'127.0.0.1',1386047919,'1'),(2694,'127.0.0.1',1386047958,'1'),(2695,'127.0.0.1',1386048056,'1'),(2696,'127.0.0.1',1386048059,'1'),(2697,'127.0.0.1',1386048132,'1'),(2698,'127.0.0.1',1386050864,'1'),(2699,'127.0.0.1',1386051518,'1'),(2700,'127.0.0.1',1386048387,'1'),(2701,'127.0.0.1',1386048398,'1'),(2702,'127.0.0.1',1386048710,'1'),(2703,'127.0.0.1',1386048763,'1'),(2704,'127.0.0.1',1386049040,'1'),(2705,'127.0.0.1',1386051514,'1'),(2706,'127.0.0.1',1386051510,'1'),(2707,'127.0.0.1',1386051536,NULL),(2708,'127.0.0.1',1386051593,'1'),(2709,'127.0.0.1',1386051642,'1'),(2710,'127.0.0.1',1386051647,'1'),(2711,'127.0.0.1',1386051695,'1'),(2712,'127.0.0.1',1386051698,'1'),(2713,'127.0.0.1',1386051755,'1'),(2714,'127.0.0.1',1386061626,'1'),(2715,'127.0.0.1',1386061749,'1'),(2716,'127.0.0.1',1386062556,'1'),(2717,'127.0.0.1',1386062706,'1'),(2718,'127.0.0.1',1386062710,'1'),(2719,'127.0.0.1',1386062777,'1'),(2720,'127.0.0.1',1386062784,'1'),(2721,'127.0.0.1',1386063322,'1'),(2722,'127.0.0.1',1386065252,'1'),(2723,'127.0.0.1',1386065331,'1'),(2724,'127.0.0.1',1386065435,'1'),(2725,'127.0.0.1',1386065450,'1'),(2726,'127.0.0.1',1386065798,'1'),(2727,'127.0.0.1',1386065893,'1'),(2728,'127.0.0.1',1386066871,'1'),(2729,'127.0.0.1',1386066871,'1'),(2730,'127.0.0.1',1386066940,'1'),(2731,'127.0.0.1',1386066941,'1'),(2732,'127.0.0.1',1386066978,'1'),(2733,'127.0.0.1',1386066978,'1'),(2734,'127.0.0.1',1386066993,'1'),(2735,'127.0.0.1',1386066993,'1'),(2736,'127.0.0.1',1386067415,'1'),(2737,'127.0.0.1',1386067415,'1'),(2738,'127.0.0.1',1386067490,'1'),(2739,'127.0.0.1',1386067490,'1'),(2740,'127.0.0.1',1386067533,'1'),(2741,'127.0.0.1',1386067533,'1'),(2742,'127.0.0.1',1386067538,'1'),(2743,'127.0.0.1',1386067558,'1'),(2744,'127.0.0.1',1386067599,'1'),(2745,'127.0.0.1',1386067617,'1'),(2746,'127.0.0.1',1386067617,'1'),(2747,'127.0.0.1',1386067624,'1'),(2748,'127.0.0.1',1386067624,'1'),(2749,'127.0.0.1',1386067628,'1'),(2750,'127.0.0.1',1386067657,'1'),(2751,'127.0.0.1',1386067675,'1'),(2752,'127.0.0.1',1386067703,'1'),(2753,'127.0.0.1',1386067705,'1'),(2754,'127.0.0.1',1386067706,'1'),(2755,'127.0.0.1',1386067748,'1'),(2756,'127.0.0.1',1386067748,'1'),(2757,'127.0.0.1',1386067761,'1'),(2758,'127.0.0.1',1386067761,'1'),(2759,'127.0.0.1',1386068986,'1'),(2760,'192.168.1.138',1386068136,'1'),(2761,'192.168.1.138',1386068262,'1'),(2762,'192.168.1.138',1386068367,'1'),(2763,'192.168.1.138',1386068525,'1'),(2764,'192.168.1.138',1386068535,'1'),(2765,'192.168.1.138',1386068734,'1'),(2766,'192.168.1.138',1386068865,'1'),(2767,'192.168.1.138',1386068868,'1'),(2768,'192.168.1.138',1386068875,'1'),(2769,'192.168.1.138',1386069119,'1'),(2770,'127.0.0.1',1386069051,'1'),(2771,'192.168.1.138',1386069140,'1'),(2772,'192.168.1.138',1386069328,'1'),(2773,'127.0.0.1',1386069180,'1'),(2774,'127.0.0.1',1386069255,'1'),(2775,'127.0.0.1',1386069311,'1'),(2776,'127.0.0.1',1386069442,'1'),(2777,'192.168.1.138',1386069456,'1'),(2778,'127.0.0.1',1386070080,'1'),(2779,'192.168.1.138',1386069612,'1'),(2780,'192.168.1.138',1386069636,'1'),(2781,'192.168.1.138',1386069824,'1'),(2782,'192.168.1.138',1386069837,'1'),(2783,'192.168.1.138',1386069845,'1'),(2784,'192.168.1.138',1386070181,'1'),(2785,'127.0.0.1',1386070129,'1'),(2786,'127.0.0.1',1386070135,'1'),(2787,'127.0.0.1',1386070143,'1'),(2788,'192.168.1.138',1386140082,'1'),(2789,'192.168.1.138',1386140083,'1'),(2790,'192.168.1.138',1386140086,'1'),(2791,'192.168.1.138',1386140172,'1'),(2792,'192.168.1.138',1386140208,'1'),(2793,'192.168.1.138',1386140397,'1'),(2794,'192.168.1.138',1386140650,'1'),(2795,'192.168.1.138',1386140761,'1'),(2796,'192.168.1.138',1386140862,'1'),(2797,'192.168.1.138',1386140863,'1'),(2798,'192.168.1.138',1386140896,'1'),(2799,'192.168.1.138',1386140987,'1'),(2800,'192.168.1.138',1386140993,'1'),(2801,'192.168.1.138',1386141241,'1'),(2802,'192.168.1.138',1386141359,'1'),(2803,'192.168.1.138',1386141382,'1'),(2804,'192.168.1.138',1386141424,'1'),(2805,'192.168.1.138',1386141497,'1'),(2806,'192.168.1.138',1386141547,'1'),(2807,'192.168.1.138',1386143516,'1'),(2808,'192.168.1.138',1386143632,'1'),(2809,'192.168.1.138',1386143724,'1'),(2810,'192.168.1.138',1386143830,'1'),(2811,'192.168.1.138',1386143853,'1'),(2812,'192.168.1.138',1386143939,'1'),(2813,'192.168.1.138',1386144116,'1'),(2814,'192.168.1.138',1386144272,'1'),(2815,'192.168.1.138',1386144285,'1'),(2816,'192.168.1.138',1386144452,'1'),(2817,'192.168.1.138',1386144490,'1'),(2818,'192.168.1.138',1386144697,'1'),(2819,'192.168.1.138',1386144802,'1'),(2820,'192.168.1.138',1386144823,'1'),(2821,'192.168.1.138',1386144874,'1'),(2822,'192.168.1.138',1386145144,'1'),(2823,'192.168.1.138',1386145155,'1'),(2824,'192.168.1.138',1386145280,'1'),(2825,'192.168.1.138',1386145430,'1'),(2826,'192.168.1.138',1386145438,'1'),(2827,'192.168.1.138',1386145529,'1'),(2828,'192.168.1.138',1386145575,'1'),(2829,'192.168.1.138',1386145586,'1'),(2830,'192.168.1.138',1386145914,'1'),(2831,'192.168.1.138',1386146037,'1'),(2832,'192.168.1.138',1386146047,'1'),(2833,'192.168.1.138',1386146079,'1'),(2834,'192.168.1.138',1386146123,'1'),(2835,'192.168.1.138',1386146150,'1'),(2836,'192.168.1.138',1386146318,'1'),(2837,'192.168.1.138',1386146334,'1'),(2838,'192.168.1.138',1386146396,'1'),(2839,'192.168.1.138',1386146386,'1'),(2840,'192.168.1.138',1386146387,'1'),(2841,'192.168.1.138',1386146390,'1'),(2842,'192.168.1.138',1386146476,'1'),(2843,'192.168.1.138',1386146427,'1'),(2844,'192.168.1.138',1386146470,'1'),(2845,'192.168.1.138',1386147820,'1'),(2846,'192.168.1.138',1386147821,'1'),(2847,'192.168.1.138',1386147825,'1'),(2848,'192.168.1.138',1386148191,'1'),(2849,'192.168.1.138',1386147838,'1'),(2850,'192.168.1.138',1386148280,'1'),(2851,'192.168.1.138',1386148346,'1'),(2852,'192.168.1.138',1386148308,'1'),(2853,'192.168.1.138',1386148442,'1'),(2854,'192.168.1.138',1386150569,'1'),(2855,'192.168.1.138',1386149145,'1'),(2856,'192.168.1.138',1386151137,'1'),(2857,'192.168.1.138',1386150985,'1'),(2858,'192.168.1.138',1386151141,'1'),(2859,'192.168.1.138',1386151148,'1'),(2860,'192.168.1.138',1386152034,'1'),(2861,'192.168.1.138',1386151340,'1'),(2862,'192.168.1.138',1386151867,'1'),(2863,'192.168.1.138',1386152026,'1'),(2864,'192.168.1.138',1386212902,'1'),(2865,'192.168.1.138',1386212942,'1'),(2866,'192.168.1.138',1386212986,'1'),(2867,'192.168.1.138',1386217325,'1'),(2868,'127.0.0.1',1386214224,'1'),(2869,'127.0.0.1',1386221955,'1'),(2870,'192.168.1.138',1386217850,'1'),(2871,'192.168.1.138',1386217915,'1'),(2872,'192.168.1.138',1386217919,'1'),(2873,'192.168.1.138',1386217925,'1'),(2874,'192.168.1.138',1386217977,'1'),(2875,'192.168.1.138',1386221971,'1'),(2876,'192.168.1.138',1386217989,'1'),(2877,'192.168.1.138',1386221989,'1'),(2878,'192.168.1.138',1386224142,'1'),(2879,'192.168.1.138',1386224305,'1'),(2880,'192.168.1.138',1386224231,'1'),(2881,'192.168.1.138',1386224415,'1'),(2882,'192.168.1.138',1386224717,'1'),(2883,'192.168.1.138',1386224521,'1'),(2884,'192.168.1.138',1386225316,'1'),(2885,'192.168.1.138',1386224735,'1'),(2886,'192.168.1.138',1386228639,'1'),(2887,'192.168.1.138',1386229296,'1'),(2888,'192.168.1.138',1386228667,'1'),(2889,'192.168.1.138',1386228679,'1'),(2890,'192.168.1.138',1386228681,'1'),(2891,'192.168.1.138',1386228688,'1'),(2892,'192.168.1.138',1386228695,'1'),(2893,'192.168.1.138',1386230458,'1'),(2894,'192.168.1.138',1386230305,'1'),(2895,'192.168.1.138',1386230458,'1'),(2896,'192.168.1.138',1386230484,'1'),(2897,'192.168.1.138',1386230498,NULL),(2898,'192.168.1.138',1386230514,'1'),(2899,'192.168.1.138',1386235693,'1'),(2900,'192.168.1.138',1386234915,'1'),(2901,'192.168.1.138',1386237417,'1'),(2902,'192.168.1.138',1386235721,'1'),(2903,'192.168.1.138',1386235962,'1'),(2904,'192.168.1.138',1386237099,'1'),(2905,'192.168.1.138',1386238588,'1'),(2906,'192.168.1.138',1386238574,'1'),(2907,'127.0.0.1',1386298690,'1'),(2908,'127.0.0.1',1386298691,'1'),(2909,'127.0.0.1',1386298698,'1'),(2910,'127.0.0.1',1386298713,'1'),(2911,'127.0.0.1',1386298715,'1'),(2912,'127.0.0.1',1386298725,'1'),(2913,'127.0.0.1',1386308635,'1'),(2914,'127.0.0.1',1386309893,'1'),(2915,'127.0.0.1',1386310021,'1'),(2916,'127.0.0.1',1386310041,'1'),(2917,'127.0.0.1',1386314746,'1'),(2918,'127.0.0.1',1386314752,'1'),(2919,'127.0.0.1',1386314853,'1'),(2920,'127.0.0.1',1386315409,'1'),(2921,'127.0.0.1',1386315634,'1'),(2922,'127.0.0.1',1386315701,'1'),(2923,'127.0.0.1',1386315732,'1'),(2924,'127.0.0.1',1386315733,'1'),(2925,'127.0.0.1',1386315762,'1'),(2926,'127.0.0.1',1386315762,'1'),(2927,'127.0.0.1',1386315879,'1'),(2928,'127.0.0.1',1386315879,'1'),(2929,'127.0.0.1',1386315885,'1'),(2930,'127.0.0.1',1386315915,'1'),(2931,'127.0.0.1',1386315989,'1'),(2932,'127.0.0.1',1386315997,'1'),(2933,'127.0.0.1',1386316137,'1'),(2934,'127.0.0.1',1386316142,'1'),(2935,'127.0.0.1',1386316146,'1'),(2936,'127.0.0.1',1386316197,'1'),(2937,'127.0.0.1',1386316224,'1'),(2938,'127.0.0.1',1386316225,'1'),(2939,'127.0.0.1',1386316412,'1'),(2940,'127.0.0.1',1386316654,'1'),(2941,'127.0.0.1',1386317244,'1'),(2942,'127.0.0.1',1386317329,'1'),(2943,'127.0.0.1',1386317332,'1'),(2944,'127.0.0.1',1386317347,'1'),(2945,'127.0.0.1',1386317347,'1'),(2946,'127.0.0.1',1386317379,'1'),(2947,'127.0.0.1',1386317760,'1'),(2948,'127.0.0.1',1386317830,'1'),(2949,'127.0.0.1',1386317844,'1'),(2950,'127.0.0.1',1386317858,'1'),(2951,'127.0.0.1',1386317874,'1'),(2952,'127.0.0.1',1386317910,'1'),(2953,'127.0.0.1',1386317916,'1'),(2954,'127.0.0.1',1386318244,'1'),(2955,'127.0.0.1',1386318380,'1'),(2956,'127.0.0.1',1386318388,'1'),(2957,'127.0.0.1',1386318547,'1'),(2958,'127.0.0.1',1386318631,'1'),(2959,'127.0.0.1',1386318651,'1'),(2960,'127.0.0.1',1386318699,'1'),(2961,'127.0.0.1',1386318861,'1'),(2962,'127.0.0.1',1386318893,'1'),(2963,'127.0.0.1',1386318966,'1'),(2964,'127.0.0.1',1386319171,'1'),(2965,'127.0.0.1',1386319255,'1'),(2966,'127.0.0.1',1386319259,'1'),(2967,'127.0.0.1',1386319278,'1'),(2968,'127.0.0.1',1386319337,'1'),(2969,'127.0.0.1',1386319382,'1'),(2970,'127.0.0.1',1386319512,'1'),(2971,'127.0.0.1',1386319515,'1'),(2972,'127.0.0.1',1386319531,'1'),(2973,'127.0.0.1',1386319564,'1'),(2974,'127.0.0.1',1386319570,'1'),(2975,'127.0.0.1',1386319921,'1'),(2976,'127.0.0.1',1386320684,'1'),(2977,'127.0.0.1',1386320793,'1'),(2978,'127.0.0.1',1386320855,'1'),(2979,'127.0.0.1',1386321010,'1'),(2980,'127.0.0.1',1386321075,'1'),(2981,'127.0.0.1',1386321083,'1'),(2982,'127.0.0.1',1386321095,'1'),(2983,'127.0.0.1',1386321361,'1'),(2984,'127.0.0.1',1386321365,'1'),(2985,'127.0.0.1',1386321383,'1'),(2986,'127.0.0.1',1386321404,'1'),(2987,'127.0.0.1',1386321430,'1'),(2988,'127.0.0.1',1386321487,'1'),(2989,'127.0.0.1',1386321510,'1'),(2990,'127.0.0.1',1386321531,'1'),(2991,'127.0.0.1',1386321744,'1'),(2992,'127.0.0.1',1386321750,'1'),(2993,'127.0.0.1',1386321765,'1'),(2994,'127.0.0.1',1386321777,'1'),(2995,'127.0.0.1',1386321785,'1'),(2996,'127.0.0.1',1386321833,'1'),(2997,'127.0.0.1',1386321923,'1'),(2998,'127.0.0.1',1386321951,'1'),(2999,'127.0.0.1',1386321973,'1'),(3000,'127.0.0.1',1386322129,'1'),(3001,'127.0.0.1',1386322205,'1'),(3002,'127.0.0.1',1386322222,'1'),(3003,'127.0.0.1',1386322256,'1'),(3004,'127.0.0.1',1386322375,'1'),(3005,'127.0.0.1',1386322405,'1'),(3006,'127.0.0.1',1386322666,'1'),(3007,'127.0.0.1',1386322674,'1'),(3008,'127.0.0.1',1386322689,'1'),(3009,'127.0.0.1',1386324146,'1'),(3010,'127.0.0.1',1386324177,'1'),(3011,'127.0.0.1',1386324920,'1'),(3012,'127.0.0.1',1386324988,'1'),(3013,'127.0.0.1',1386324993,'1'),(3014,'127.0.0.1',1386325058,'1'),(3015,'127.0.0.1',1386325201,'1'),(3016,'127.0.0.1',1386325285,'1'),(3017,'127.0.0.1',1386325386,'1'),(3018,'127.0.0.1',1386325544,'1'),(3019,'127.0.0.1',1386325594,'1'),(3020,'127.0.0.1',1386325637,'1'),(3021,'127.0.0.1',1386325769,'1'),(3022,'127.0.0.1',1386325778,'1'),(3023,'127.0.0.1',1386325813,'1'),(3024,'127.0.0.1',1386325840,'1'),(3025,'127.0.0.1',1386325961,'1'),(3026,'127.0.0.1',1386326066,'1'),(3027,'127.0.0.1',1386326087,'1'),(3028,'127.0.0.1',1386326158,'1'),(3029,'127.0.0.1',1386326182,'1'),(3030,'127.0.0.1',1386326204,'1'),(3031,'127.0.0.1',1386326232,'1'),(3032,'127.0.0.1',1386326247,'1'),(3033,'127.0.0.1',1386326408,'1'),(3034,'127.0.0.1',1386326414,'1'),(3035,'127.0.0.1',1386326511,'1'),(3036,'127.0.0.1',1386326540,'1'),(3037,'127.0.0.1',1386326644,'1'),(3038,'127.0.0.1',1386326651,'1'),(3039,'127.0.0.1',1386326712,'1'),(3040,'127.0.0.1',1386326733,'1'),(3041,'127.0.0.1',1386326837,'1'),(3042,'127.0.0.1',1386326867,'1'),(3043,'127.0.0.1',1386326969,'1'),(3044,'127.0.0.1',1386326990,'1'),(3045,'127.0.0.1',1386327023,'1'),(3046,'127.0.0.1',1386327215,'1'),(3047,'127.0.0.1',1386327229,'1'),(3048,'127.0.0.1',1386327253,'1'),(3049,'127.0.0.1',1386327332,'1'),(3050,'127.0.0.1',1386327457,'1'),(3051,'127.0.0.1',1386327529,'1'),(3052,'127.0.0.1',1386327607,'1'),(3053,'127.0.0.1',1386327760,'1'),(3054,'127.0.0.1',1386327839,'1'),(3055,'127.0.0.1',1386327854,'1'),(3056,'127.0.0.1',1386328299,'1'),(3057,'127.0.0.1',1386328310,'1'),(3058,'127.0.0.1',1386328354,'1'),(3059,'127.0.0.1',1386328393,'1'),(3060,'127.0.0.1',1386328654,'1'),(3061,'127.0.0.1',1386328810,'1'),(3062,'127.0.0.1',1386328814,'1'),(3063,'127.0.0.1',1386328834,'1'),(3064,'127.0.0.1',1386328918,'1'),(3065,'127.0.0.1',1386328945,'1'),(3066,'127.0.0.1',1386328968,'1'),(3067,'127.0.0.1',1386329171,'1'),(3068,'127.0.0.1',1386329195,'1'),(3069,'127.0.0.1',1386329319,'1'),(3070,'127.0.0.1',1386384351,'1'),(3071,'127.0.0.1',1386384352,'1'),(3072,'127.0.0.1',1386386291,'1'),(3073,'127.0.0.1',1386386316,'1'),(3074,'127.0.0.1',1386386720,'1'),(3075,'127.0.0.1',1386386751,'1'),(3076,'127.0.0.1',1386386783,'1'),(3077,'127.0.0.1',1386387067,'1'),(3078,'127.0.0.1',1386387225,'1'),(3079,'127.0.0.1',1386387230,'1'),(3080,'127.0.0.1',1386388017,'1'),(3081,'127.0.0.1',1386388026,'1'),(3082,'127.0.0.1',1386388046,'1'),(3083,'127.0.0.1',1386388063,'1'),(3084,'127.0.0.1',1386388095,'1'),(3085,'127.0.0.1',1386388219,'1'),(3086,'127.0.0.1',1386388401,'1'),(3087,'127.0.0.1',1386388454,'1'),(3088,'127.0.0.1',1386388525,'1'),(3089,'127.0.0.1',1386388708,'1'),(3090,'127.0.0.1',1386388788,'1'),(3091,'127.0.0.1',1386388833,'1'),(3092,'127.0.0.1',1386388885,'1'),(3093,'127.0.0.1',1386388895,'1'),(3094,'127.0.0.1',1386388906,'1'),(3095,'127.0.0.1',1386388910,'1'),(3096,'127.0.0.1',1386388919,'1'),(3097,'127.0.0.1',1386388931,'1'),(3098,'127.0.0.1',1386388950,'1'),(3099,'127.0.0.1',1386388967,'1'),(3100,'127.0.0.1',1386389016,'1'),(3101,'127.0.0.1',1386389056,'1'),(3102,'127.0.0.1',1386389066,'1'),(3103,'127.0.0.1',1386389195,'1'),(3104,'127.0.0.1',1386389201,'1'),(3105,'127.0.0.1',1386389215,'1'),(3106,'127.0.0.1',1386389248,'1'),(3107,'127.0.0.1',1386389260,'1'),(3108,'127.0.0.1',1386389301,'1'),(3109,'127.0.0.1',1386389306,'1'),(3110,'127.0.0.1',1386389335,'1'),(3111,'127.0.0.1',1386389340,'1'),(3112,'127.0.0.1',1386389482,'1'),(3113,'127.0.0.1',1386390215,'1'),(3114,'127.0.0.1',1386390242,'1'),(3115,'127.0.0.1',1386390524,'1'),(3116,'127.0.0.1',1386391134,'1'),(3117,'127.0.0.1',1386390586,'1'),(3118,'127.0.0.1',1386390672,'1'),(3119,'127.0.0.1',1386390740,'1'),(3120,'127.0.0.1',1386390773,'1'),(3121,'127.0.0.1',1386390836,'1'),(3122,'127.0.0.1',1386390848,'1'),(3123,'127.0.0.1',1386390954,'1'),(3124,'127.0.0.1',1386391057,'1'),(3125,'127.0.0.1',1386390988,'1'),(3126,'127.0.0.1',1386391318,'1'),(3127,'127.0.0.1',1386391074,'1'),(3128,'127.0.0.1',1386391105,'1'),(3129,'127.0.0.1',1386394201,'1'),(3130,'127.0.0.1',1386391320,'1'),(3131,'127.0.0.1',1386391344,'1'),(3132,'127.0.0.1',1386391469,'1'),(3133,'127.0.0.1',1386391476,'1'),(3134,'127.0.0.1',1386391489,'1'),(3135,'127.0.0.1',1386391532,'1'),(3136,'127.0.0.1',1386391704,'1'),(3137,'127.0.0.1',1386391736,'1'),(3138,'127.0.0.1',1386391740,'1'),(3139,'127.0.0.1',1386391840,'1'),(3140,'127.0.0.1',1386391856,'1'),(3141,'127.0.0.1',1386391872,'1'),(3142,'127.0.0.1',1386391876,'1'),(3143,'127.0.0.1',1386392989,'1'),(3144,'127.0.0.1',1386393157,'1'),(3145,'127.0.0.1',1386393350,'1'),(3146,'127.0.0.1',1386394167,'1'),(3147,'127.0.0.1',1386394446,'1'),(3148,'127.0.0.1',1386394466,'1'),(3149,'127.0.0.1',1386394476,'1'),(3150,'127.0.0.1',1386394479,'1'),(3151,'127.0.0.1',1386394491,'1'),(3152,'127.0.0.1',1386394655,'1'),(3153,'127.0.0.1',1386394666,'1'),(3154,'127.0.0.1',1386394675,'1'),(3155,'127.0.0.1',1386394678,'1'),(3156,'127.0.0.1',1386394729,'1'),(3157,'127.0.0.1',1386394904,'1'),(3158,'127.0.0.1',1386394919,'1'),(3159,'127.0.0.1',1386394962,'1'),(3160,'127.0.0.1',1386394991,'1'),(3161,'127.0.0.1',1386394994,'1'),(3162,'127.0.0.1',1386395029,'1'),(3163,'127.0.0.1',1386395073,'1'),(3164,'127.0.0.1',1386395163,'1'),(3165,'127.0.0.1',1386395181,'1'),(3166,'127.0.0.1',1386395186,'1'),(3167,'127.0.0.1',1386396531,'1'),(3168,'127.0.0.1',1386397854,'1'),(3169,'127.0.0.1',1386396540,'1'),(3170,'127.0.0.1',1386396587,'1'),(3171,'127.0.0.1',1386396611,'1'),(3172,'127.0.0.1',1386397015,'1'),(3173,'127.0.0.1',1386397230,'1'),(3174,'127.0.0.1',1386397037,'1'),(3175,'127.0.0.1',1386397063,'1'),(3176,'127.0.0.1',1386397227,'1'),(3177,'127.0.0.1',1386397531,'1'),(3178,'127.0.0.1',1386397580,'1'),(3179,'127.0.0.1',1386397539,'1'),(3180,'127.0.0.1',1386397558,'1'),(3181,'127.0.0.1',1386397885,'1'),(3182,'127.0.0.1',1386397844,'1'),(3183,'127.0.0.1',1386400071,'1'),(3184,'127.0.0.1',1386401142,'1'),(3185,'127.0.0.1',1386401383,'1'),(3186,'127.0.0.1',1386401395,'1'),(3187,'127.0.0.1',1386401448,'1'),(3188,'127.0.0.1',1386401480,'1'),(3189,'127.0.0.1',1386401643,'1'),(3190,'127.0.0.1',1386401660,'1'),(3191,'127.0.0.1',1386401871,'1'),(3192,'127.0.0.1',1386402014,'1'),(3193,'127.0.0.1',1386403251,'1'),(3194,'127.0.0.1',1386403601,'1'),(3195,'127.0.0.1',1386404199,'1'),(3196,'127.0.0.1',1386404331,'1'),(3197,'127.0.0.1',1386404780,'1'),(3198,'127.0.0.1',1386404843,'1'),(3199,'127.0.0.1',1386404854,'1'),(3200,'127.0.0.1',1386404870,'1'),(3201,'127.0.0.1',1386404942,'1'),(3202,'127.0.0.1',1386404949,'1'),(3203,'127.0.0.1',1386405188,'1'),(3204,'127.0.0.1',1386405425,'1'),(3205,'127.0.0.1',1386405496,'1'),(3206,'127.0.0.1',1386405606,'1'),(3207,'127.0.0.1',1386405532,'1'),(3208,'127.0.0.1',1386406007,'1'),(3209,'127.0.0.1',1386406030,'1'),(3210,'127.0.0.1',1386558850,'1'),(3211,'127.0.0.1',1386558850,'1'),(3212,'127.0.0.1',1386558992,'1'),(3213,'127.0.0.1',1386559199,'1'),(3214,'127.0.0.1',1386559242,'1'),(3215,'127.0.0.1',1386559283,'1'),(3216,'127.0.0.1',1386559300,'1'),(3217,'127.0.0.1',1386559301,'1'),(3218,'127.0.0.1',1386559377,'1'),(3219,'127.0.0.1',1386559378,'1'),(3220,'127.0.0.1',1386559417,'1'),(3221,'127.0.0.1',1386559418,'1'),(3222,'127.0.0.1',1386559447,'1'),(3223,'127.0.0.1',1386559448,'1'),(3224,'127.0.0.1',1386559599,'1'),(3225,'127.0.0.1',1386559615,'1'),(3226,'127.0.0.1',1386559615,'1'),(3227,'127.0.0.1',1386559641,'1'),(3228,'127.0.0.1',1386560043,'1'),(3229,'127.0.0.1',1386562395,'1'),(3230,'127.0.0.1',1386562395,'1'),(3231,'127.0.0.1',1386562409,'1'),(3232,'127.0.0.1',1386562409,'1'),(3233,'127.0.0.1',1386562575,'1'),(3234,'127.0.0.1',1386562592,'1'),(3235,'127.0.0.1',1386562599,'1'),(3236,'127.0.0.1',1386562683,'1'),(3237,'127.0.0.1',1386562783,'1'),(3238,'127.0.0.1',1386562785,'1'),(3239,'127.0.0.1',1386562917,'1'),(3240,'127.0.0.1',1386569146,'1'),(3241,'127.0.0.1',1386563089,'1'),(3242,'127.0.0.1',1386563116,'1'),(3243,'127.0.0.1',1386564809,'1'),(3244,'127.0.0.1',1386564811,'1'),(3245,'127.0.0.1',1386564819,'1'),(3246,'127.0.0.1',1386564932,'1'),(3247,'127.0.0.1',1386564947,'1'),(3248,'127.0.0.1',1386565103,'1'),(3249,'127.0.0.1',1386565117,'1'),(3250,'127.0.0.1',1386565122,'1'),(3251,'127.0.0.1',1386565176,'1'),(3252,'127.0.0.1',1386565228,'1'),(3253,'127.0.0.1',1386566818,'1'),(3254,'127.0.0.1',1386566857,'1'),(3255,'127.0.0.1',1386566882,'1'),(3256,'127.0.0.1',1386566909,'1'),(3257,'127.0.0.1',1386567351,'1'),(3258,'127.0.0.1',1386567361,'1'),(3259,'127.0.0.1',1386567380,'1'),(3260,'127.0.0.1',1386567806,'1'),(3261,'127.0.0.1',1386567843,'1'),(3262,'127.0.0.1',1386568128,'1'),(3263,'127.0.0.1',1386568145,'1'),(3264,'127.0.0.1',1386568154,'1'),(3265,'127.0.0.1',1386568160,'1'),(3266,'127.0.0.1',1386568244,'1'),(3267,'127.0.0.1',1386568409,'1'),(3268,'127.0.0.1',1386568569,'1'),(3269,'127.0.0.1',1386568844,'1'),(3270,'127.0.0.1',1386568889,'1'),(3271,'127.0.0.1',1386568897,'1'),(3272,'127.0.0.1',1386568902,'1'),(3273,'127.0.0.1',1386568920,'1'),(3274,'127.0.0.1',1386568927,'1'),(3275,'127.0.0.1',1386568945,'1'),(3276,'127.0.0.1',1386568951,'1'),(3277,'127.0.0.1',1386568983,'1'),(3278,'127.0.0.1',1386569022,'1'),(3279,'127.0.0.1',1386569044,'1'),(3280,'127.0.0.1',1386569068,'1'),(3281,'127.0.0.1',1386569650,'1'),(3282,'127.0.0.1',1386577122,'1'),(3283,'127.0.0.1',1386569997,'1'),(3284,'127.0.0.1',1386570036,'1'),(3285,'127.0.0.1',1386570053,'1'),(3286,'127.0.0.1',1386570195,'1'),(3287,'127.0.0.1',1386572375,'1'),(3288,'127.0.0.1',1386572425,'1'),(3289,'127.0.0.1',1386573915,'1'),(3290,'127.0.0.1',1386574017,'1'),(3291,'127.0.0.1',1386574173,'1'),(3292,'127.0.0.1',1386574287,'1'),(3293,'127.0.0.1',1386574721,'1'),(3294,'127.0.0.1',1386577115,'1'),(3295,'127.0.0.1',1386574884,'1'),(3296,'127.0.0.1',1386574893,'1'),(3297,'127.0.0.1',1386577086,'1'),(3298,'127.0.0.1',1386905514,'1'),(3299,'127.0.0.1',1386905514,'1'),(3300,'127.0.0.1',1386905646,'1'),(3301,'127.0.0.1',1386905658,'1'),(3302,'127.0.0.1',1386906024,'2'),(3303,'127.0.0.1',1386906024,'2'),(3304,'127.0.0.1',1386906071,'2'),(3305,'127.0.0.1',1386906087,'2'),(3306,'127.0.0.1',1386906183,'2'),(3307,'127.0.0.1',1386906196,'2'),(3308,'127.0.0.1',1386906223,'2'),(3309,'127.0.0.1',1386906563,'2'),(3310,'127.0.0.1',1386906612,'2'),(3311,'127.0.0.1',1386906698,'2'),(3312,'127.0.0.1',1386906732,'2'),(3313,'127.0.0.1',1386907568,'2'),(3314,'127.0.0.1',1386907592,'2'),(3315,'127.0.0.1',1386907617,'2'),(3316,'127.0.0.1',1386907859,'2'),(3317,'127.0.0.1',1386908294,'2'),(3318,'127.0.0.1',1386908413,'2'),(3319,'127.0.0.1',1386908319,'2'),(3320,'127.0.0.1',1386908418,'2'),(3321,'127.0.0.1',1386908879,'2'),(3322,'127.0.0.1',1386908944,'2'),(3323,'127.0.0.1',1386909418,'2'),(3324,'127.0.0.1',1386909440,'2'),(3325,'127.0.0.1',1386909526,'2'),(3326,'127.0.0.1',1386909545,'2'),(3327,'127.0.0.1',1386909725,'2'),(3328,'127.0.0.1',1386909745,'2'),(3329,'127.0.0.1',1386909840,'2'),(3330,'127.0.0.1',1386910594,'2'),(3331,'127.0.0.1',1386920781,'1'),(3332,'127.0.0.1',1386920781,'1'),(3333,'127.0.0.1',1386921468,'1'),(3334,'127.0.0.1',1386921519,'1'),(3335,'127.0.0.1',1386921571,'1'),(3336,'127.0.0.1',1386922795,'1'),(3337,'127.0.0.1',1385887740,'1'),(3338,'127.0.0.1',1385887741,'1'),(3339,'127.0.0.1',1385887834,'1'),(3340,'127.0.0.1',1385887836,'1'),(3341,'127.0.0.1',1385887839,'1'),(3342,'127.0.0.1',1385887983,'1'),(3343,'127.0.0.1',1385888015,'1'),(3344,'127.0.0.1',1385888029,'1'),(3345,'127.0.0.1',1385888034,'1'),(3346,'127.0.0.1',1385888054,'1'),(3347,'127.0.0.1',1385888098,'1'),(3348,'127.0.0.1',1385888273,'1'),(3349,'127.0.0.1',1385888315,'1'),(3350,'127.0.0.1',1385888456,'1'),(3351,'127.0.0.1',1385888593,'1'),(3352,'127.0.0.1',1385888763,'1'),(3353,'127.0.0.1',1385889072,'1'),(3354,'127.0.0.1',1385889080,'1'),(3355,'127.0.0.1',1385889167,'1'),(3356,'127.0.0.1',1385889240,'1'),(3357,'127.0.0.1',1385889363,'1'),(3358,'127.0.0.1',1385889384,'1'),(3359,'127.0.0.1',1385889425,'1'),(3360,'127.0.0.1',1385889451,'1'),(3361,'127.0.0.1',1385889470,'1'),(3362,'127.0.0.1',1385889541,'1'),(3363,'127.0.0.1',1385889544,'1'),(3364,'127.0.0.1',1385889600,'1'),(3365,'127.0.0.1',1385889620,'1'),(3366,'127.0.0.1',1385889627,'1'),(3367,'127.0.0.1',1385889634,'1'),(3368,'127.0.0.1',1385889640,'1'),(3369,'127.0.0.1',1385889646,'1'),(3370,'127.0.0.1',1385889696,'1'),(3371,'127.0.0.1',1385889765,'1'),(3372,'127.0.0.1',1385889844,'1'),(3373,'127.0.0.1',1385889951,'1'),(3374,'127.0.0.1',1385889978,'1'),(3375,'127.0.0.1',1385890019,'1'),(3376,'127.0.0.1',1385890162,'1'),(3377,'127.0.0.1',1385890241,'1'),(3378,'127.0.0.1',1385890269,'1'),(3379,'127.0.0.1',1385890270,'1'),(3380,'127.0.0.1',1385890313,'1'),(3381,'127.0.0.1',1385890317,'1'),(3382,'127.0.0.1',1385890339,'1'),(3383,'127.0.0.1',1385890400,'1'),(3384,'127.0.0.1',1385890486,'1'),(3385,'127.0.0.1',1385890546,'1'),(3386,'127.0.0.1',1385890560,'1'),(3387,'127.0.0.1',1385890594,'1'),(3388,'127.0.0.1',1385890618,'1'),(3389,'127.0.0.1',1385890733,'1'),(3390,'127.0.0.1',1385890839,'1'),(3391,'127.0.0.1',1385890954,'1'),(3392,'127.0.0.1',1385890970,'1'),(3393,'127.0.0.1',1385890982,'1'),(3394,'127.0.0.1',1385890985,'1'),(3395,'127.0.0.1',1385890998,'1'),(3396,'127.0.0.1',1385891016,'1'),(3397,'127.0.0.1',1385891019,'1'),(3398,'127.0.0.1',1385891054,'1'),(3399,'127.0.0.1',1385891072,'1'),(3400,'127.0.0.1',1385891076,'1'),(3401,'127.0.0.1',1385891080,'1'),(3402,'127.0.0.1',1385891098,'1'),(3403,'127.0.0.1',1385891105,'1'),(3404,'127.0.0.1',1385891229,'1'),(3405,'127.0.0.1',1385891234,'1'),(3406,'127.0.0.1',1385891244,'1'),(3407,'127.0.0.1',1385891800,'1'),(3408,'127.0.0.1',1385891836,'1'),(3409,'127.0.0.1',1385891852,'1'),(3410,'127.0.0.1',1385891855,'1'),(3411,'127.0.0.1',1385891861,'1'),(3412,'127.0.0.1',1385891864,'1'),(3413,'127.0.0.1',1385891901,'1'),(3414,'127.0.0.1',1385891927,'1'),(3415,'127.0.0.1',1385891965,'1'),(3416,'127.0.0.1',1385891973,'1'),(3417,'127.0.0.1',1385891976,'1'),(3418,'127.0.0.1',1385892008,'1'),(3419,'127.0.0.1',1385892093,'1'),(3420,'127.0.0.1',1385892098,'1'),(3421,'127.0.0.1',1385892115,'1'),(3422,'127.0.0.1',1385892130,'1'),(3423,'127.0.0.1',1385892213,'1'),(3424,'127.0.0.1',1385892219,'1'),(3425,'127.0.0.1',1385892248,'1'),(3426,'127.0.0.1',1385892272,'1'),(3427,'127.0.0.1',1385892324,'1'),(3428,'127.0.0.1',1385892597,'1'),(3429,'127.0.0.1',1385892639,'1'),(3430,'127.0.0.1',1385892661,'1'),(3431,'127.0.0.1',1385893151,'1'),(3432,'127.0.0.1',1385894424,'1'),(3433,'127.0.0.1',1385894561,'1'),(3434,'127.0.0.1',1385894562,'1'),(3435,'127.0.0.1',1387250254,'1'),(3436,'127.0.0.1',1387250254,'1'),(3437,'127.0.0.1',1387532394,'1'),(3438,'127.0.0.1',1387532395,'1'),(3439,'127.0.0.1',1387532473,'1'),(3440,'127.0.0.1',1387532490,'1'),(3441,'127.0.0.1',1387532571,'1'),(3442,'127.0.0.1',1387532571,'1'),(3443,'127.0.0.1',1387532709,'1'),(3444,'127.0.0.1',1387532720,'1'),(3445,'127.0.0.1',1387532728,'1'),(3446,'127.0.0.1',1387532773,'1'),(3447,'127.0.0.1',1387532789,'1'),(3448,'127.0.0.1',1387532789,'1'),(3449,'127.0.0.1',1387532993,'1'),(3450,'127.0.0.1',1387533160,'1'),(3451,'127.0.0.1',1387533224,'1'),(3452,'127.0.0.1',1387533428,'1'),(3453,'127.0.0.1',1387533454,'1'),(3454,'127.0.0.1',1387533454,'1'),(3455,'127.0.0.1',1387533457,'1'),(3456,'127.0.0.1',1387533560,'1'),(3457,'127.0.0.1',1387533654,'1'),(3458,'127.0.0.1',1387533800,'1'),(3459,'127.0.0.1',1387533804,'1'),(3460,'127.0.0.1',1387533947,'1'),(3461,'127.0.0.1',1387534019,'1'),(3462,'127.0.0.1',1387534025,'1'),(3463,'127.0.0.1',1387534105,'1'),(3464,'127.0.0.1',1387534303,'1'),(3465,'127.0.0.1',1387598351,'1'),(3466,'127.0.0.1',1387598351,'1'),(3467,'127.0.0.1',1387598583,'1'),(3468,'127.0.0.1',1387598396,'1'),(3469,'127.0.0.1',1387599804,'1'),(3470,'127.0.0.1',1387598642,'1'),(3471,'127.0.0.1',1387598774,'1'),(3472,'127.0.0.1',1387598964,'1'),(3473,'127.0.0.1',1387599194,'1'),(3474,'127.0.0.1',1387599644,'1'),(3475,'127.0.0.1',1387599703,'1'),(3476,'127.0.0.1',1387599715,'1'),(3477,'127.0.0.1',1387599900,'1'),(3478,'127.0.0.1',1387855160,'1'),(3479,'127.0.0.1',1387855401,'1'),(3480,'127.0.0.1',1387859060,'1'),(3481,'127.0.0.1',1387859060,'1'),(3482,'127.0.0.1',1387861525,'1'),(3483,'127.0.0.1',1387861525,'1'),(3484,'127.0.0.1',1387861542,'1'),(3485,'127.0.0.1',1387861543,'1'),(3486,'127.0.0.1',1387862592,'1'),(3487,'127.0.0.1',1387861624,'1'),(3488,'127.0.0.1',1387861828,'1'),(3489,'127.0.0.1',1387861837,'1'),(3490,'127.0.0.1',1387862037,'1'),(3491,'127.0.0.1',1387862061,'1'),(3492,'127.0.0.1',1387862137,'1'),(3493,'127.0.0.1',1387862156,'1'),(3494,'127.0.0.1',1387862534,'1'),(3495,'127.0.0.1',1387862557,'1'),(3496,'127.0.0.1',1387863028,'1'),(3497,'127.0.0.1',1387863298,'1'),(3498,'127.0.0.1',1387863124,'1'),(3499,'127.0.0.1',1387865112,'1'),(3500,'127.0.0.1',1387865125,'1'),(3501,'127.0.0.1',1387863330,'1'),(3502,'127.0.0.1',1387865821,'1'),(3503,'127.0.0.1',1387870187,'1'),(3504,'127.0.0.1',1387866250,'1'),(3505,'127.0.0.1',1387865985,'1'),(3506,'127.0.0.1',1387866916,'1'),(3507,'127.0.0.1',1387870209,'1'),(3508,'127.0.0.1',1387867026,'1'),(3509,'127.0.0.1',1387867028,'1'),(3510,'127.0.0.1',1387867042,'1'),(3511,'127.0.0.1',1387870191,'1'),(3512,'127.0.0.1',1388026019,'1'),(3513,'127.0.0.1',1388026019,'1'),(3514,'127.0.0.1',1388026072,'1'),(3515,'127.0.0.1',1388026252,'1'),(3516,'127.0.0.1',1388026252,'1'),(3517,'127.0.0.1',1388026377,'1'),(3518,'127.0.0.1',1388026406,'1'),(3519,'127.0.0.1',1388026410,'1'),(3520,'127.0.0.1',1388051016,'1'),(3521,'127.0.0.1',1388051016,'1'),(3522,'127.0.0.1',1388051061,'1'),(3523,'127.0.0.1',1388051039,'1'),(3524,'127.0.0.1',1388051089,'1'),(3525,'127.0.0.1',1388051108,'1'),(3526,'127.0.0.1',1388051113,'1');

/*Table structure for table `s_users` */

DROP TABLE IF EXISTS `s_users`;

CREATE TABLE `s_users` (
  `cCode` varchar(10) NOT NULL DEFAULT '',
  `loginName` varchar(50) NOT NULL,
  `discription` varchar(50) DEFAULT NULL,
  `userPassword` varchar(50) DEFAULT NULL,
  `isAdmin` tinyint(1) unsigned DEFAULT NULL,
  `bc` varchar(5) DEFAULT NULL,
  `permission` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`cCode`,`loginName`),
  KEY `bc` (`bc`),
  CONSTRAINT `s_users_ibfk_1` FOREIGN KEY (`bc`) REFERENCES `s_branches` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `s_users` */

insert  into `s_users`(`cCode`,`loginName`,`discription`,`userPassword`,`isAdmin`,`bc`,`permission`) values ('1','developer','Soft Master Developer','e8912bf8c7ef369038190ef88cefbce4',1,'001',3),('2','m3','M 3 Marketing','9678f7a7939f457fa0d9353761e189c7',1,'001',1),('3','level02','level 02 p user','202cb962ac59075b964b07152d234b70',1,'001',2),('4','level03','level 03 p user','202cb962ac59075b964b07152d234b70',1,'001',3),('5','NALIN','level01','f78b792231bb76036798bd6ad8f22cba',1,'002',3),('6','THANUJA','THANUJA ','2cfa1b0ec902b41a59a4e47bf8309856',1,'002',3),('7','chinthaka','accountant','202cb962ac59075b964b07152d234b70',0,'002',1),('8','test','test','202cb962ac59075b964b07152d234b70',1,'001',1),('9','Test1','Test1','81dc9bdb52d04dc20036dbd8313ed055',1,'001',2);

/*Table structure for table `t_advance` */

DROP TABLE IF EXISTS `t_advance`;

CREATE TABLE `t_advance` (
  `id` int(10) DEFAULT NULL,
  `trans_code` varchar(20) DEFAULT NULL,
  `receipt_no` int(10) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT '0.00',
  `balance` decimal(10,2) DEFAULT '0.00',
  `settle_amount` decimal(10,2) DEFAULT '0.00',
  `is_cancel` tinyint(1) DEFAULT '0',
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_advance` */

/*Table structure for table `t_advance_pay_det` */

DROP TABLE IF EXISTS `t_advance_pay_det`;

CREATE TABLE `t_advance_pay_det` (
  `id` bigint(20) unsigned NOT NULL,
  `b_branch` varchar(200) DEFAULT NULL,
  `cheque_no` varchar(200) DEFAULT NULL,
  `acc_no` varchar(100) DEFAULT NULL,
  `cheque_amount` decimal(10,2) DEFAULT NULL,
  `r_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_advance_pay_det` */

insert  into `t_advance_pay_det`(`id`,`b_branch`,`cheque_no`,`acc_no`,`cheque_amount`,`r_date`) values (1,'Bank Of Ceylon - Pettah','45435','543545','500.00','2013-12-11');

/*Table structure for table `t_advance_pay_history` */

DROP TABLE IF EXISTS `t_advance_pay_history`;

CREATE TABLE `t_advance_pay_history` (
  `adv_rec_no` bigint(20) DEFAULT NULL,
  `adv_total` decimal(10,2) DEFAULT NULL,
  `adv_balance` decimal(10,2) DEFAULT NULL,
  `adv_settlement` decimal(10,2) DEFAULT NULL,
  `trance_no` bigint(20) DEFAULT NULL,
  `trance_type` varchar(25) DEFAULT NULL,
  `action_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `oc` varchar(10) DEFAULT NULL,
  `bc` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_advance_pay_history` */

/*Table structure for table `t_advance_pay_sum` */

DROP TABLE IF EXISTS `t_advance_pay_sum`;

CREATE TABLE `t_advance_pay_sum` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `no` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `ref_no` varchar(100) DEFAULT NULL,
  `customer` varchar(100) DEFAULT NULL,
  `cheque_amount` decimal(10,2) DEFAULT '0.00',
  `cash_amount` decimal(10,2) DEFAULT '0.00',
  `bc` varchar(10) DEFAULT NULL,
  `oc` varchar(10) DEFAULT NULL,
  `action_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_refund` tinyint(6) DEFAULT '0',
  `is_cancel` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`,`no`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `t_advance_pay_sum` */

insert  into `t_advance_pay_sum`(`id`,`no`,`date`,`ref_no`,`customer`,`cheque_amount`,`cash_amount`,`bc`,`oc`,`action_date`,`is_refund`,`is_cancel`) values (1,1,'2013-12-07','Reference No','CASH - 001','500.00','1000.00','001','1','2013-12-07 13:01:18',0,0);

/*Table structure for table `t_advance_pay_trance` */

DROP TABLE IF EXISTS `t_advance_pay_trance`;

CREATE TABLE `t_advance_pay_trance` (
  `id` int(10) DEFAULT NULL,
  `module` varchar(10) DEFAULT NULL,
  `customer` varchar(20) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `dr_trance_code` varchar(25) DEFAULT NULL,
  `dr_trance_no` bigint(20) DEFAULT NULL,
  `dr_trance_amount` decimal(10,2) DEFAULT NULL,
  `cr_trance_code` varchar(25) DEFAULT NULL,
  `cr_trance_no` bigint(20) DEFAULT NULL,
  `cr_trance_amount` decimal(10,2) DEFAULT NULL,
  `is_refund` smallint(6) DEFAULT '0',
  `bc` varchar(10) DEFAULT NULL,
  `oc` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_advance_pay_trance` */

insert  into `t_advance_pay_trance`(`id`,`module`,`customer`,`date`,`dr_trance_code`,`dr_trance_no`,`dr_trance_amount`,`cr_trance_code`,`cr_trance_no`,`cr_trance_amount`,`is_refund`,`bc`,`oc`) values (NULL,NULL,'CASH - 001','2013-12-07','AD_REFUND',1,'1500.00','ADPAY',1,'0.00',0,'001','1'),(1,'ADPAY','CASH - 001','2013-12-07','ADPAY',1,'0.00','ADPAY',1,'1500.00',0,'001','1');

/*Table structure for table `t_advance_refund` */

DROP TABLE IF EXISTS `t_advance_refund`;

CREATE TABLE `t_advance_refund` (
  `no` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `ref_no` varchar(20) DEFAULT NULL,
  `customer` varchar(100) DEFAULT NULL,
  `advance_pay_no` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT NULL,
  `bc` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_advance_refund` */

insert  into `t_advance_refund`(`no`,`date`,`ref_no`,`customer`,`advance_pay_no`,`amount`,`balance`,`bc`) values (1,'2013-12-07','Reference No','CASH - 001',1,'1500.00','1500.00','001');

/*Table structure for table `t_batch` */

DROP TABLE IF EXISTS `t_batch`;

CREATE TABLE `t_batch` (
  `id` int(10) DEFAULT NULL,
  `trans_code` varchar(10) DEFAULT NULL,
  `item_code` varchar(20) DEFAULT NULL,
  `batch_code` int(10) DEFAULT '0',
  `pur_price` decimal(10,2) DEFAULT '0.00',
  `bc` varchar(10) DEFAULT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_sub_item` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_batch` */

insert  into `t_batch`(`id`,`trans_code`,`item_code`,`batch_code`,`pur_price`,`bc`,`action_date`,`is_sub_item`) values (6,'PUR','LATADI001',1,'21250.00','001','2013-12-07 11:40:09',0),(6,'PUR','LATADI002',1,'20750.00','001','2013-12-07 11:40:09',0),(1,'OPEN','COTNO',1,'540.00','001','2013-12-01 15:13:34',0),(2,'OPEN','LATADI001',2,'21750.00','001','2013-12-01 15:15:03',0);

/*Table structure for table `t_cash_sales_det` */

DROP TABLE IF EXISTS `t_cash_sales_det`;

CREATE TABLE `t_cash_sales_det` (
  `id` bigint(20) unsigned NOT NULL,
  `item_code` varchar(20) NOT NULL,
  `cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quantity` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(10,2) DEFAULT '0.00',
  `discount_pre` decimal(10,2) DEFAULT '0.00',
  `foc` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`,`item_code`),
  CONSTRAINT `FK_t_cash_sales_det` FOREIGN KEY (`id`) REFERENCES `t_cash_sales_sum` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_cash_sales_det` */

insert  into `t_cash_sales_det`(`id`,`item_code`,`cost`,`quantity`,`discount`,`discount_pre`,`foc`) values (8,'LATADI001','30000.00','1.00','0.00','0.00','0.00'),(8,'LATADI002','30000.00','2.00','0.00','0.00','0.00'),(9,'LATADI002','30000.00','1.00','0.00','0.00','0.00'),(10,'COTNO','10.00','1.00','0.00','0.00','0.00');

/*Table structure for table `t_cash_sales_sum` */

DROP TABLE IF EXISTS `t_cash_sales_sum`;

CREATE TABLE `t_cash_sales_sum` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `no` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `ref_no` varchar(25) NOT NULL,
  `memo` varchar(255) DEFAULT NULL,
  `customer` varchar(15) DEFAULT NULL,
  `sales_ref` varchar(10) DEFAULT NULL,
  `discount` decimal(10,4) DEFAULT NULL,
  `balance` decimal(10,4) DEFAULT NULL,
  `stores` varchar(15) DEFAULT NULL,
  `pay_amount` decimal(10,2) DEFAULT '0.00',
  `cash` decimal(10,2) DEFAULT '0.00',
  `cheque` decimal(10,2) DEFAULT '0.00',
  `advance` decimal(10,2) DEFAULT '0.00',
  `so_no` int(11) DEFAULT '0',
  `r_margin` decimal(10,2) DEFAULT NULL,
  `c_margin` decimal(10,2) DEFAULT NULL,
  `bc` varchar(10) NOT NULL,
  `oc` varchar(10) NOT NULL,
  `posting` smallint(6) DEFAULT '0',
  `is_cancel` smallint(6) DEFAULT '0',
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pay_method` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`,`no`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `t_cash_sales_sum` */

insert  into `t_cash_sales_sum`(`id`,`no`,`date`,`ref_no`,`memo`,`customer`,`sales_ref`,`discount`,`balance`,`stores`,`pay_amount`,`cash`,`cheque`,`advance`,`so_no`,`r_margin`,`c_margin`,`bc`,`oc`,`posting`,`is_cancel`,`action_date`,`pay_method`) values (8,1,'2013-12-07','Reference No','Memo','CASH - 001','839335888V','0.0000','0.0000','KURU001','90000.00','90000.00','0.00','0.00',0,NULL,NULL,'001','1',0,0,'2013-12-07 11:47:40',1),(9,2,'2013-12-09','Reference No','Memo','CASH - 001','839335888V','0.0000','-60000.0000','KURU001','30000.00','30000.00','0.00','0.00',0,NULL,NULL,'001','1',0,0,'2013-12-09 09:55:13',1),(10,3,'2013-12-01','Reference No','Memo','ABC001','839335888V','0.0000','0.0000','KURU001','10.00','10.00','0.00','0.00',0,NULL,NULL,'001','1',0,0,'2013-12-01 15:14:30',1);

/*Table structure for table `t_cost_log` */

DROP TABLE IF EXISTS `t_cost_log`;

CREATE TABLE `t_cost_log` (
  `auto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id` int(10) unsigned NOT NULL,
  `item_code` varchar(50) DEFAULT NULL,
  `module` varchar(25) DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`auto_id`),
  KEY `item_code` (`item_code`),
  CONSTRAINT `t_cost_log_ibfk_1` FOREIGN KEY (`item_code`) REFERENCES `m_items` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_cost_log` */

/*Table structure for table `t_credit_sales_det` */

DROP TABLE IF EXISTS `t_credit_sales_det`;

CREATE TABLE `t_credit_sales_det` (
  `id` bigint(20) unsigned NOT NULL,
  `item_code` varchar(20) NOT NULL,
  `cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quantity` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(10,2) DEFAULT '0.00',
  `discount_pre` decimal(10,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_credit_sales_det` */

/*Table structure for table `t_credit_sales_sum` */

DROP TABLE IF EXISTS `t_credit_sales_sum`;

CREATE TABLE `t_credit_sales_sum` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `no` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `ref_no` varchar(25) NOT NULL,
  `memo` varchar(255) DEFAULT NULL,
  `customer` varchar(15) DEFAULT NULL,
  `sales_ref` varchar(10) DEFAULT NULL,
  `discount` decimal(10,4) DEFAULT NULL,
  `balance` decimal(10,4) DEFAULT NULL,
  `stores` varchar(15) DEFAULT NULL,
  `cash` decimal(10,2) DEFAULT '0.00',
  `credit` decimal(10,2) DEFAULT '0.00',
  `cheque` decimal(10,2) DEFAULT '0.00',
  `so_no` int(11) DEFAULT '0',
  `r_margin` decimal(10,2) DEFAULT NULL,
  `c_margin` decimal(10,2) DEFAULT NULL,
  `bc` varchar(10) NOT NULL,
  `oc` varchar(10) NOT NULL,
  `posting` smallint(6) DEFAULT '0',
  `is_cancel` smallint(6) DEFAULT '0',
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pay_method` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_credit_sales_sum` */

/*Table structure for table `t_customer_acc_trance` */

DROP TABLE IF EXISTS `t_customer_acc_trance`;

CREATE TABLE `t_customer_acc_trance` (
  `id` bigint(20) DEFAULT NULL,
  `module` varchar(25) DEFAULT NULL,
  `customer` varchar(20) NOT NULL,
  `dr_trnce_code` varchar(25) DEFAULT NULL,
  `dr_trnce_no` bigint(20) DEFAULT NULL,
  `cr_trnce_code` varchar(25) DEFAULT NULL,
  `cr_trnce_no` bigint(20) DEFAULT NULL,
  `dr_amount` decimal(10,2) DEFAULT '0.00',
  `cr_amount` decimal(10,2) DEFAULT '0.00',
  `bc` varchar(10) DEFAULT NULL,
  `oc` varchar(10) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `description` varchar(100) DEFAULT '',
  KEY `customer` (`customer`),
  KEY `bc` (`bc`),
  KEY `oc` (`oc`),
  CONSTRAINT `t_customer_acc_trance_ibfk_1` FOREIGN KEY (`customer`) REFERENCES `m_customer` (`code`),
  CONSTRAINT `t_customer_acc_trance_ibfk_2` FOREIGN KEY (`bc`) REFERENCES `s_branches` (`code`),
  CONSTRAINT `t_customer_acc_trance_ibfk_3` FOREIGN KEY (`oc`) REFERENCES `s_users` (`cCode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_customer_acc_trance` */

insert  into `t_customer_acc_trance`(`id`,`module`,`customer`,`dr_trnce_code`,`dr_trnce_no`,`cr_trnce_code`,`cr_trnce_no`,`dr_amount`,`cr_amount`,`bc`,`oc`,`date`,`action_date`,`description`) values (8,'SALES','CASH - 001','SALES',1,'SALES',1,'90000.00','0.00','001','1','2013-12-07','2013-12-07 11:47:40',''),(8,'SALES','CASH - 001','SALES',1,'SALES',1,'0.00','90000.00','001','1','2013-12-07','2013-12-07 11:47:40',''),(1,'SALES_RET','CASH - 001','SALES',1,'SALES_RET',1,'0.00','60000.00','001','1','2013-12-07','2013-12-07 11:55:55',''),(9,'SALES','CASH - 001','SALES',2,'SALES',2,'30000.00','0.00','001','1','2013-12-09','2013-12-09 09:55:13',''),(9,'SALES','CASH - 001','SALES',2,'SALES',2,'0.00','30000.00','001','1','2013-12-09','2013-12-09 09:55:13',''),(10,'SALES','ABC001','SALES',3,'SALES',3,'10.00','0.00','001','1','2013-12-01','2013-12-01 15:14:30',''),(10,'SALES','ABC001','SALES',3,'SALES',3,'0.00','10.00','001','1','2013-12-01','2013-12-01 15:14:30',''),(1,'CR_SALES','ABC001','CR_SALES',1,'CR_SALES',1,'10.00','0.00','001','1','2013-12-26','2013-12-26 15:13:59',''),(2,'CR_SALES','ABC001','CR_SALES',2,'CR_SALES',2,'10.00','0.00','001','1','2013-12-26','2013-12-26 15:14:10','');

/*Table structure for table `t_customer_acc_trance_temp` */

DROP TABLE IF EXISTS `t_customer_acc_trance_temp`;

CREATE TABLE `t_customer_acc_trance_temp` (
  `id` bigint(20) DEFAULT NULL,
  `module` varchar(25) DEFAULT NULL,
  `customer` varchar(20) NOT NULL,
  `dr_trnce_code` varchar(25) DEFAULT NULL,
  `dr_trnce_no` bigint(20) DEFAULT NULL,
  `cr_trnce_code` varchar(25) DEFAULT NULL,
  `cr_trnce_no` bigint(20) DEFAULT NULL,
  `dr_amount` decimal(10,2) DEFAULT '0.00',
  `cr_amount` decimal(10,2) DEFAULT '0.00',
  `bc` varchar(10) DEFAULT NULL,
  `oc` varchar(10) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `description` varchar(100) DEFAULT '',
  KEY `customer` (`customer`),
  KEY `bc` (`bc`),
  KEY `oc` (`oc`),
  CONSTRAINT `t_customer_acc_trance_temp_ibfk_1` FOREIGN KEY (`customer`) REFERENCES `m_customer` (`code`),
  CONSTRAINT `t_customer_acc_trance_temp_ibfk_2` FOREIGN KEY (`bc`) REFERENCES `s_branches` (`code`),
  CONSTRAINT `t_customer_acc_trance_temp_ibfk_3` FOREIGN KEY (`oc`) REFERENCES `s_users` (`cCode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_customer_acc_trance_temp` */

/*Table structure for table `t_customer_cheques` */

DROP TABLE IF EXISTS `t_customer_cheques`;

CREATE TABLE `t_customer_cheques` (
  `id` int(10) unsigned DEFAULT NULL,
  `module` varchar(25) DEFAULT NULL,
  `cheque_no` varchar(30) DEFAULT NULL,
  `account_no` varchar(30) DEFAULT NULL,
  `cheque_amount` decimal(10,2) DEFAULT NULL,
  `state` tinyint(4) DEFAULT '0',
  `bank` varchar(15) DEFAULT NULL,
  `bank_branch` varchar(15) DEFAULT NULL,
  `realize_date` date DEFAULT NULL,
  `is_cancel` smallint(6) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_customer_cheques` */

insert  into `t_customer_cheques`(`id`,`module`,`cheque_no`,`account_no`,`cheque_amount`,`state`,`bank`,`bank_branch`,`realize_date`,`is_cancel`) values (1,'ADPAY','45435','543545','500.00',0,'7010-004','7010','2013-12-11',0);

/*Table structure for table `t_customer_credit_note` */

DROP TABLE IF EXISTS `t_customer_credit_note`;

CREATE TABLE `t_customer_credit_note` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `no` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `custmer` varchar(25) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `cr_account` varchar(25) DEFAULT NULL,
  `cr_account_des` varchar(200) DEFAULT NULL,
  `dr_account` varchar(25) DEFAULT NULL,
  `dr_account_des` varchar(200) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `bc` varchar(25) DEFAULT NULL,
  `oc` varchar(25) DEFAULT NULL,
  `is_cancel` tinyint(4) DEFAULT '0',
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `bc` (`bc`),
  KEY `oc` (`oc`),
  KEY `custmer` (`custmer`),
  CONSTRAINT `t_customer_credit_note_ibfk_1` FOREIGN KEY (`custmer`) REFERENCES `m_customer` (`code`),
  CONSTRAINT `t_customer_credit_note_ibfk_2` FOREIGN KEY (`bc`) REFERENCES `s_branches` (`code`),
  CONSTRAINT `t_customer_credit_note_ibfk_3` FOREIGN KEY (`oc`) REFERENCES `s_users` (`cCode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_customer_credit_note` */

/*Table structure for table `t_customer_credit_permission` */

DROP TABLE IF EXISTS `t_customer_credit_permission`;

CREATE TABLE `t_customer_credit_permission` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer` varchar(25) DEFAULT NULL,
  `oc` smallint(5) unsigned DEFAULT NULL,
  `l1` decimal(10,2) DEFAULT NULL,
  `l2` decimal(10,2) DEFAULT NULL,
  `l3` decimal(10,2) DEFAULT NULL,
  `request_balance` decimal(10,2) DEFAULT NULL,
  `conform` tinyint(4) DEFAULT '0',
  `conform_by` smallint(5) unsigned DEFAULT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `customer` (`customer`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_customer_credit_permission` */

/*Table structure for table `t_customer_credit_permission_senders` */

DROP TABLE IF EXISTS `t_customer_credit_permission_senders`;

CREATE TABLE `t_customer_credit_permission_senders` (
  `request_id` bigint(20) unsigned NOT NULL,
  `oc` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`request_id`,`oc`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_customer_credit_permission_senders` */

/*Table structure for table `t_customer_debit_credit_note` */

DROP TABLE IF EXISTS `t_customer_debit_credit_note`;

CREATE TABLE `t_customer_debit_credit_note` (
  `no` int(10) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `amount` double(10,2) DEFAULT NULL,
  `custmer` varchar(10) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `bc` varchar(10) DEFAULT NULL,
  `oc` varchar(10) DEFAULT NULL,
  `is_cancel` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_customer_debit_credit_note` */

/*Table structure for table `t_customer_debit_note` */

DROP TABLE IF EXISTS `t_customer_debit_note`;

CREATE TABLE `t_customer_debit_note` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `no` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `custmer` varchar(25) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `cr_account` varchar(25) DEFAULT NULL,
  `cr_account_des` varchar(200) DEFAULT NULL,
  `dr_account` varchar(25) DEFAULT NULL,
  `dr_account_des` varchar(200) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `bc` varchar(25) DEFAULT NULL,
  `oc` varchar(25) DEFAULT NULL,
  `is_cancel` tinyint(4) DEFAULT '0',
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `bc` (`bc`),
  KEY `oc` (`oc`),
  KEY `custmer` (`custmer`),
  CONSTRAINT `t_customer_debit_note_ibfk_1` FOREIGN KEY (`custmer`) REFERENCES `m_customer` (`code`),
  CONSTRAINT `t_customer_debit_note_ibfk_2` FOREIGN KEY (`bc`) REFERENCES `s_branches` (`code`),
  CONSTRAINT `t_customer_debit_note_ibfk_3` FOREIGN KEY (`oc`) REFERENCES `s_users` (`cCode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_customer_debit_note` */

/*Table structure for table `t_customer_receipt_det` */

DROP TABLE IF EXISTS `t_customer_receipt_det`;

CREATE TABLE `t_customer_receipt_det` (
  `id` int(10) unsigned DEFAULT NULL,
  `receipt_no` int(11) DEFAULT NULL,
  `trance_code` varchar(25) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT NULL,
  `paid` decimal(10,2) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  KEY `id` (`id`),
  CONSTRAINT `t_customer_receipt_det_ibfk_1` FOREIGN KEY (`id`) REFERENCES `t_customer_receipt_sum` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_customer_receipt_det` */

/*Table structure for table `t_customer_receipt_sum` */

DROP TABLE IF EXISTS `t_customer_receipt_sum`;

CREATE TABLE `t_customer_receipt_sum` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `no` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `ref_no` varchar(100) DEFAULT NULL,
  `memo` varchar(255) DEFAULT NULL,
  `cheque_amount` decimal(10,2) DEFAULT '0.00',
  `cash_amount` decimal(10,2) DEFAULT '0.00',
  `advance_settlement` decimal(10,2) DEFAULT '0.00',
  `balance` decimal(10,2) DEFAULT NULL,
  `customer` varchar(15) DEFAULT NULL,
  `cheque_no` varchar(200) DEFAULT NULL,
  `cheque_date` varchar(200) DEFAULT NULL,
  `posting` smallint(6) DEFAULT '0',
  `stores` varchar(25) DEFAULT NULL,
  `over_payment` decimal(10,2) DEFAULT '0.00',
  `is_cancel` smallint(6) DEFAULT '0',
  `bc` varchar(10) DEFAULT NULL,
  `oc` varchar(10) DEFAULT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sale_recipt` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `customer` (`customer`),
  KEY `oc` (`oc`),
  KEY `bc` (`bc`),
  KEY `id` (`id`),
  CONSTRAINT `t_customer_receipt_sum_ibfk_1` FOREIGN KEY (`customer`) REFERENCES `m_customer` (`code`),
  CONSTRAINT `t_customer_receipt_sum_ibfk_2` FOREIGN KEY (`bc`) REFERENCES `s_branches` (`code`),
  CONSTRAINT `t_customer_receipt_sum_ibfk_3` FOREIGN KEY (`oc`) REFERENCES `s_users` (`cCode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_customer_receipt_sum` */

/*Table structure for table `t_customer_settle_det` */

DROP TABLE IF EXISTS `t_customer_settle_det`;

CREATE TABLE `t_customer_settle_det` (
  `id` int(10) unsigned DEFAULT NULL,
  `trance_type` varchar(25) DEFAULT NULL,
  `trance_no` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `paid` decimal(10,2) DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT NULL,
  `settle` decimal(10,2) DEFAULT NULL,
  KEY `id` (`id`),
  CONSTRAINT `t_customer_settle_det_ibfk_1` FOREIGN KEY (`id`) REFERENCES `t_customer_settle_sum` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_customer_settle_det` */

/*Table structure for table `t_customer_settle_sum` */

DROP TABLE IF EXISTS `t_customer_settle_sum`;

CREATE TABLE `t_customer_settle_sum` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `no` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `ref_no` varchar(100) DEFAULT NULL,
  `memo` varchar(255) DEFAULT NULL,
  `dbalance` decimal(10,2) DEFAULT '0.00',
  `cbalance` decimal(10,2) DEFAULT '0.00',
  `customer` varchar(15) DEFAULT NULL,
  `type_pay` varchar(25) DEFAULT NULL,
  `no_pay` int(11) DEFAULT NULL,
  `total_pay` decimal(10,2) DEFAULT NULL,
  `paid_pay` decimal(10,2) DEFAULT NULL,
  `balance_pay` decimal(10,2) DEFAULT NULL,
  `sett_pay` decimal(10,2) DEFAULT NULL,
  `posting` smallint(6) DEFAULT '0',
  `is_cancel` smallint(6) DEFAULT '0',
  `bc` varchar(10) DEFAULT NULL,
  `oc` varchar(10) DEFAULT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `customer` (`customer`),
  KEY `bc` (`bc`),
  KEY `oc` (`oc`),
  CONSTRAINT `t_customer_settle_sum_ibfk_1` FOREIGN KEY (`customer`) REFERENCES `m_customer` (`code`),
  CONSTRAINT `t_customer_settle_sum_ibfk_2` FOREIGN KEY (`bc`) REFERENCES `s_branches` (`code`),
  CONSTRAINT `t_customer_settle_sum_ibfk_3` FOREIGN KEY (`oc`) REFERENCES `s_users` (`cCode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_customer_settle_sum` */

/*Table structure for table `t_customer_supplier_note` */

DROP TABLE IF EXISTS `t_customer_supplier_note`;

CREATE TABLE `t_customer_supplier_note` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `no` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `custmer` varchar(25) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `cr_account` varchar(25) DEFAULT NULL,
  `cr_account_des` varchar(200) DEFAULT NULL,
  `dr_account` varchar(25) DEFAULT NULL,
  `dr_account_des` varchar(200) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `bc` varchar(25) DEFAULT NULL,
  `oc` varchar(25) DEFAULT NULL,
  `is_cancel` tinyint(4) DEFAULT '0',
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `bc` (`bc`),
  KEY `oc` (`oc`),
  KEY `custmer` (`custmer`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_customer_supplier_note` */

/*Table structure for table `t_customer_transaction` */

DROP TABLE IF EXISTS `t_customer_transaction`;

CREATE TABLE `t_customer_transaction` (
  `id` bigint(20) DEFAULT NULL,
  `module` varchar(25) DEFAULT NULL,
  `customer` varchar(20) NOT NULL,
  `dr_trnce_code` varchar(25) DEFAULT NULL,
  `dr_trnce_no` bigint(20) DEFAULT NULL,
  `cr_trnce_code` varchar(25) DEFAULT NULL,
  `cr_trnce_no` bigint(20) DEFAULT NULL,
  `dr_amount` decimal(10,2) DEFAULT '0.00',
  `cr_amount` decimal(10,2) DEFAULT '0.00',
  `bc` varchar(10) DEFAULT NULL,
  `oc` varchar(10) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `description` varchar(100) DEFAULT '',
  KEY `customer` (`customer`),
  KEY `bc` (`bc`),
  KEY `oc` (`oc`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_customer_transaction` */

/*Table structure for table `t_damage_free_issu_det` */

DROP TABLE IF EXISTS `t_damage_free_issu_det`;

CREATE TABLE `t_damage_free_issu_det` (
  `id` bigint(20) unsigned NOT NULL,
  `item_code` varchar(20) NOT NULL,
  `cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quantity` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`,`item_code`),
  KEY `item_code` (`item_code`),
  CONSTRAINT `t_damage_free_issu_det_ibfk_1` FOREIGN KEY (`id`) REFERENCES `t_damage_free_issu_sum` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `t_damage_free_issu_det_ibfk_2` FOREIGN KEY (`item_code`) REFERENCES `m_items` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_damage_free_issu_det` */

/*Table structure for table `t_damage_free_issu_sum` */

DROP TABLE IF EXISTS `t_damage_free_issu_sum`;

CREATE TABLE `t_damage_free_issu_sum` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `no` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `ref_no` varchar(25) NOT NULL,
  `memo` varchar(255) DEFAULT NULL,
  `stores` varchar(15) DEFAULT NULL,
  `posting` tinyint(4) DEFAULT '0',
  `bc` varchar(10) NOT NULL,
  `oc` varchar(10) NOT NULL,
  `is_cancel` smallint(6) DEFAULT '0',
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`no`,`bc`),
  KEY `oc` (`oc`),
  KEY `bc` (`bc`),
  KEY `stores` (`stores`),
  CONSTRAINT `t_damage_free_issu_sum_ibfk_1` FOREIGN KEY (`stores`) REFERENCES `m_stores` (`code`),
  CONSTRAINT `t_damage_free_issu_sum_ibfk_2` FOREIGN KEY (`bc`) REFERENCES `s_branches` (`code`),
  CONSTRAINT `t_damage_free_issu_sum_ibfk_3` FOREIGN KEY (`oc`) REFERENCES `s_users` (`cCode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_damage_free_issu_sum` */

/*Table structure for table `t_dispatch_det` */

DROP TABLE IF EXISTS `t_dispatch_det`;

CREATE TABLE `t_dispatch_det` (
  `id` bigint(20) unsigned NOT NULL,
  `item_code` varchar(20) NOT NULL,
  `current_stock` decimal(10,2) DEFAULT NULL,
  `qty` decimal(10,2) DEFAULT NULL,
  `qtyc` decimal(10,2) DEFAULT NULL,
  `cartoon` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`,`item_code`),
  KEY `item_code` (`item_code`),
  CONSTRAINT `t_dispatch_det_ibfk_1` FOREIGN KEY (`id`) REFERENCES `t_dispatch_sum` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_dispatch_det` */

/*Table structure for table `t_dispatch_return_det` */

DROP TABLE IF EXISTS `t_dispatch_return_det`;

CREATE TABLE `t_dispatch_return_det` (
  `id` bigint(20) unsigned NOT NULL,
  `item_code` varchar(20) NOT NULL,
  `current_stock` decimal(10,2) DEFAULT NULL,
  `qty` decimal(10,2) DEFAULT NULL,
  `qtyc` decimal(10,2) DEFAULT NULL,
  `cartoon` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`,`item_code`),
  KEY `item_code` (`item_code`),
  CONSTRAINT `t_dispatch_return_det_ibfk_1gdf` FOREIGN KEY (`id`) REFERENCES `t_dispatch_return_sum` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_dispatch_return_det` */

/*Table structure for table `t_dispatch_return_sum` */

DROP TABLE IF EXISTS `t_dispatch_return_sum`;

CREATE TABLE `t_dispatch_return_sum` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `no` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `ref_no` varchar(25) NOT NULL,
  `customer` varchar(15) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `reson` varchar(255) DEFAULT NULL,
  `stores` varchar(15) DEFAULT NULL,
  `bc` varchar(10) NOT NULL,
  `oc` varchar(10) NOT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `marketing_codi` varchar(20) DEFAULT NULL,
  `transport_codi` varchar(20) DEFAULT NULL,
  `driver` varchar(20) DEFAULT NULL,
  `dispatch_no` int(10) DEFAULT NULL,
  `is_cancel` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`,`no`,`bc`),
  KEY `oc` (`oc`),
  KEY `bc` (`bc`),
  KEY `supplier` (`customer`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_dispatch_return_sum` */

/*Table structure for table `t_dispatch_sum` */

DROP TABLE IF EXISTS `t_dispatch_sum`;

CREATE TABLE `t_dispatch_sum` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `no` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `ref_no` varchar(25) NOT NULL,
  `customer` varchar(15) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `reson` varchar(255) DEFAULT NULL,
  `stores` varchar(15) DEFAULT NULL,
  `bc` varchar(10) NOT NULL,
  `oc` varchar(10) NOT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `marketing_codi` varchar(20) DEFAULT NULL,
  `transport_codi` varchar(20) DEFAULT NULL,
  `driver` varchar(20) DEFAULT NULL,
  `is_cancel` tinyint(1) DEFAULT '0',
  `invoice_no` int(10) DEFAULT '0',
  PRIMARY KEY (`id`,`no`,`bc`),
  KEY `oc` (`oc`),
  KEY `bc` (`bc`),
  KEY `supplier` (`customer`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_dispatch_sum` */

/*Table structure for table `t_dispatch_trance` */

DROP TABLE IF EXISTS `t_dispatch_trance`;

CREATE TABLE `t_dispatch_trance` (
  `cus_id` varchar(20) NOT NULL,
  `date` date DEFAULT NULL,
  `item_code` varchar(20) NOT NULL,
  `in_no` int(10) DEFAULT NULL,
  `in_qty` decimal(10,2) DEFAULT NULL,
  `out_no` int(10) DEFAULT NULL,
  `out_qty` decimal(10,2) DEFAULT NULL,
  `trance_code` varchar(15) NOT NULL,
  `trance_no` int(10) NOT NULL,
  `bc` varchar(10) NOT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`cus_id`,`item_code`,`trance_code`,`trance_no`,`bc`),
  KEY `item_code` (`item_code`),
  CONSTRAINT `t_dispatch_trance_ibfk_1` FOREIGN KEY (`item_code`) REFERENCES `m_items` (`code`),
  CONSTRAINT `t_dispatch_trance_ibfk_1o` FOREIGN KEY (`cus_id`) REFERENCES `t_dispatch_sum` (`customer`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_dispatch_trance` */

/*Table structure for table `t_item_movement` */

DROP TABLE IF EXISTS `t_item_movement`;

CREATE TABLE `t_item_movement` (
  `id` bigint(20) NOT NULL,
  `trance_id` bigint(20) NOT NULL,
  `trance_type` varchar(25) NOT NULL,
  `item_code` varchar(20) NOT NULL,
  `in_quantity` decimal(10,2) NOT NULL DEFAULT '0.00',
  `out_quantity` decimal(10,2) NOT NULL DEFAULT '0.00',
  `date` date NOT NULL,
  `stores` varchar(15) DEFAULT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `bc` varchar(10) NOT NULL,
  `pur_price` decimal(12,2) DEFAULT '0.00',
  `sal_price` decimal(12,2) DEFAULT '0.00',
  `ref_no` varchar(25) DEFAULT NULL,
  `avg_price` decimal(10,2) DEFAULT '0.00',
  `is_subitem` tinyint(1) DEFAULT '0',
  `batch_no` int(10) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  KEY `id` (`id`),
  KEY `item_code` (`item_code`),
  KEY `bc` (`bc`),
  KEY `stores` (`stores`),
  CONSTRAINT `t_item_movement_ibfk_1` FOREIGN KEY (`item_code`) REFERENCES `m_items` (`code`),
  CONSTRAINT `t_item_movement_ibfk_2` FOREIGN KEY (`stores`) REFERENCES `m_stores` (`code`),
  CONSTRAINT `t_item_movement_ibfk_3` FOREIGN KEY (`bc`) REFERENCES `s_branches` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_item_movement` */

insert  into `t_item_movement`(`id`,`trance_id`,`trance_type`,`item_code`,`in_quantity`,`out_quantity`,`date`,`stores`,`action_date`,`bc`,`pur_price`,`sal_price`,`ref_no`,`avg_price`,`is_subitem`,`batch_no`,`description`) values (1,1,'OPEN','COTNO','12.00','0.00','2013-12-01','KURU001','2013-12-01 15:13:34','001','540.00','0.00','Reference No','50.00',0,1,NULL),(10,3,'SALES','COTNO','0.00','1.00','2013-12-01','KURU001','2013-12-01 15:14:30','001','540.00','0.00','Reference No','50.00',0,1,'ABC001'),(2,2,'OPEN','LATADI001','10.00','0.00','2013-12-01','KURU001','2013-12-01 15:15:03','001','21750.00','0.00','Reference No','21750.00',0,2,NULL),(1,1,'CR_SALES','COTNO','0.00','1.00','2013-12-26','KURU001','2013-12-26 15:13:59','001','540.00','0.00','Reference No','50.00',0,1,'ABC001'),(2,2,'CR_SALES','COTNO','0.00','1.00','2013-12-26','KURU001','2013-12-26 15:14:10','001','540.00','0.00','Reference No','50.00',0,1,'ABC001');

/*Table structure for table `t_open_stock_det` */

DROP TABLE IF EXISTS `t_open_stock_det`;

CREATE TABLE `t_open_stock_det` (
  `id` bigint(20) unsigned NOT NULL,
  `item_code` varchar(20) NOT NULL,
  `cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quantity` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`,`item_code`),
  KEY `item_code` (`item_code`),
  CONSTRAINT `t_open_stock_det_ibfk_4` FOREIGN KEY (`id`) REFERENCES `t_open_stock_sum` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `t_open_stock_det_ibfk_5` FOREIGN KEY (`item_code`) REFERENCES `m_items` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_open_stock_det` */

insert  into `t_open_stock_det`(`id`,`item_code`,`cost`,`quantity`) values (1,'COTNO','540.00','12.00'),(2,'LATADI001','21750.00','10.00');

/*Table structure for table `t_open_stock_sum` */

DROP TABLE IF EXISTS `t_open_stock_sum`;

CREATE TABLE `t_open_stock_sum` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `no` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `ref_no` varchar(25) NOT NULL,
  `memo` varchar(255) DEFAULT NULL,
  `stores` varchar(15) DEFAULT NULL,
  `posting` tinyint(4) DEFAULT '0',
  `bc` varchar(10) NOT NULL,
  `oc` varchar(10) NOT NULL,
  `is_cancel` smallint(6) DEFAULT '0',
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`no`,`bc`),
  KEY `oc` (`oc`),
  KEY `bc` (`bc`),
  KEY `stores` (`stores`),
  CONSTRAINT `t_open_stock_sum_ibfk_1` FOREIGN KEY (`stores`) REFERENCES `m_stores` (`code`),
  CONSTRAINT `t_open_stock_sum_ibfk_2` FOREIGN KEY (`bc`) REFERENCES `s_branches` (`code`),
  CONSTRAINT `t_open_stock_sum_ibfk_3` FOREIGN KEY (`oc`) REFERENCES `s_users` (`cCode`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `t_open_stock_sum` */

insert  into `t_open_stock_sum`(`id`,`no`,`date`,`ref_no`,`memo`,`stores`,`posting`,`bc`,`oc`,`is_cancel`,`action_date`) values (1,1,'2013-12-01','Reference No','rtyry','KURU001',0,'001','1',0,'2013-12-01 15:13:00'),(2,2,'2013-12-01','Reference No','retre','KURU001',0,'001','1',0,'2013-12-01 15:15:03');

/*Table structure for table `t_price_change` */

DROP TABLE IF EXISTS `t_price_change`;

CREATE TABLE `t_price_change` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `main_cat` varchar(25) DEFAULT NULL,
  `sub_cat` varchar(25) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `value` decimal(10,2) DEFAULT NULL,
  `oc` varchar(25) DEFAULT NULL,
  `bc` varchar(25) DEFAULT NULL,
  `action_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `main_cat` (`main_cat`),
  KEY `sub_cat` (`sub_cat`),
  KEY `oc` (`oc`),
  KEY `bc` (`bc`),
  CONSTRAINT `t_price_change_ibfk_1` FOREIGN KEY (`main_cat`) REFERENCES `m_main_category` (`code`),
  CONSTRAINT `t_price_change_ibfk_2` FOREIGN KEY (`sub_cat`) REFERENCES `m_sub_category` (`code`),
  CONSTRAINT `t_price_change_ibfk_3` FOREIGN KEY (`oc`) REFERENCES `s_users` (`cCode`),
  CONSTRAINT `t_price_change_ibfk_4` FOREIGN KEY (`bc`) REFERENCES `s_branches` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_price_change` */

/*Table structure for table `t_purchse_det` */

DROP TABLE IF EXISTS `t_purchse_det`;

CREATE TABLE `t_purchse_det` (
  `id` bigint(20) unsigned NOT NULL,
  `item_code` varchar(20) NOT NULL,
  `cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quantity` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(10,2) DEFAULT '0.00',
  `discount_pre` decimal(10,2) DEFAULT '0.00',
  `foc` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`,`item_code`),
  KEY `item_code` (`item_code`),
  CONSTRAINT `t_purchse_det_ibfk_2` FOREIGN KEY (`item_code`) REFERENCES `m_items` (`code`),
  CONSTRAINT `t_purchse_det_ibfk_3` FOREIGN KEY (`id`) REFERENCES `t_purchse_sum` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_purchse_det` */

insert  into `t_purchse_det`(`id`,`item_code`,`cost`,`quantity`,`discount`,`discount_pre`,`foc`) values (6,'LATADI001','21750.00','2.00','1000.00','2.30','0.00'),(6,'LATADI002','21750.00','2.00','2000.00','4.60','0.00');

/*Table structure for table `t_purchse_order_det` */

DROP TABLE IF EXISTS `t_purchse_order_det`;

CREATE TABLE `t_purchse_order_det` (
  `id` bigint(20) unsigned NOT NULL,
  `item_code` varchar(20) NOT NULL,
  `cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quantity` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`,`item_code`),
  KEY `item_code` (`item_code`),
  CONSTRAINT `t_purchse_order_det_ibfk_3` FOREIGN KEY (`id`) REFERENCES `t_purchse_order_sum` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `t_purchse_order_det_ibfk_6` FOREIGN KEY (`item_code`) REFERENCES `m_items` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_purchse_order_det` */

insert  into `t_purchse_order_det`(`id`,`item_code`,`cost`,`quantity`) values (1,'COTNO','500.00','10.00'),(5,'COTNO','10.00','1222.00');

/*Table structure for table `t_purchse_order_sum` */

DROP TABLE IF EXISTS `t_purchse_order_sum`;

CREATE TABLE `t_purchse_order_sum` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `no` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `ref_no` varchar(25) NOT NULL,
  `memo` varchar(255) DEFAULT NULL,
  `supplier` varchar(10) DEFAULT NULL,
  `bc` varchar(10) NOT NULL,
  `oc` varchar(10) NOT NULL,
  `posting` smallint(6) DEFAULT '0',
  `is_cancel` smallint(6) DEFAULT '0',
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`no`,`bc`),
  KEY `oc` (`oc`),
  KEY `bc` (`bc`),
  KEY `supplier` (`supplier`),
  CONSTRAINT `t_purchse_order_sum_ibfk_1` FOREIGN KEY (`supplier`) REFERENCES `m_supplier` (`code`),
  CONSTRAINT `t_purchse_order_sum_ibfk_2` FOREIGN KEY (`bc`) REFERENCES `s_branches` (`code`),
  CONSTRAINT `t_purchse_order_sum_ibfk_3` FOREIGN KEY (`oc`) REFERENCES `s_users` (`cCode`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `t_purchse_order_sum` */

insert  into `t_purchse_order_sum`(`id`,`no`,`date`,`ref_no`,`memo`,`supplier`,`bc`,`oc`,`posting`,`is_cancel`,`action_date`) values (1,1,'2013-12-01','Reference No','435345','KPKOM','001','1',0,0,'2013-12-01 15:27:30'),(5,2,'2013-12-01','Reference No','setwe','KPKOM','001','1',0,0,'2013-12-01 15:32:08');

/*Table structure for table `t_purchse_order_trance` */

DROP TABLE IF EXISTS `t_purchse_order_trance`;

CREATE TABLE `t_purchse_order_trance` (
  `trance_id` bigint(20) unsigned NOT NULL,
  `trance_type` varchar(25) NOT NULL,
  `item_code` varchar(20) NOT NULL DEFAULT '',
  `in_no` int(10) DEFAULT NULL,
  `in_quantity` decimal(10,2) DEFAULT '0.00',
  `out_no` int(10) DEFAULT NULL,
  `out_quantity` decimal(10,2) DEFAULT '0.00',
  `date` date DEFAULT NULL,
  `ad` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`trance_id`,`trance_type`,`item_code`),
  KEY `item_code` (`item_code`),
  CONSTRAINT `t_purchse_order_trance_ibfk_1` FOREIGN KEY (`item_code`) REFERENCES `m_items` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_purchse_order_trance` */

insert  into `t_purchse_order_trance`(`trance_id`,`trance_type`,`item_code`,`in_no`,`in_quantity`,`out_no`,`out_quantity`,`date`,`ad`) values (1,'PO','COTNO',1,'10.00',1,'0.00','2013-12-01','2013-12-01 15:30:07'),(5,'PO','COTNO',2,'1222.00',2,'0.00','2013-12-01','2013-12-01 15:32:08'),(6,'PUR','LATADI001',0,'0.00',1,'2.00','2013-12-07','2013-12-07 11:40:09'),(6,'PUR','LATADI002',0,'0.00',1,'2.00','2013-12-07','2013-12-07 11:40:09');

/*Table structure for table `t_purchse_return_det` */

DROP TABLE IF EXISTS `t_purchse_return_det`;

CREATE TABLE `t_purchse_return_det` (
  `id` bigint(20) unsigned NOT NULL,
  `item_code` varchar(20) NOT NULL,
  `cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quantity` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`,`item_code`),
  KEY `item_code` (`item_code`),
  CONSTRAINT `t_purchse_return_det_ibfk_1` FOREIGN KEY (`id`) REFERENCES `t_purchse_return_sum` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `t_purchse_return_det_ibfk_2` FOREIGN KEY (`item_code`) REFERENCES `m_items` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_purchse_return_det` */

/*Table structure for table `t_purchse_return_sum` */

DROP TABLE IF EXISTS `t_purchse_return_sum`;

CREATE TABLE `t_purchse_return_sum` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `no` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `ref_no` varchar(25) NOT NULL,
  `memo` varchar(255) DEFAULT NULL,
  `supplier` varchar(10) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `purchase_no` int(11) DEFAULT '0',
  `stores` varchar(15) DEFAULT NULL,
  `bc` varchar(10) NOT NULL,
  `oc` varchar(10) NOT NULL,
  `posting` smallint(6) DEFAULT '0',
  `is_cancel` smallint(6) DEFAULT '0',
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`no`,`bc`),
  KEY `oc` (`oc`),
  KEY `bc` (`bc`),
  KEY `supplier` (`supplier`),
  CONSTRAINT `t_purchse_return_sum_ibfk_1` FOREIGN KEY (`supplier`) REFERENCES `m_supplier` (`code`),
  CONSTRAINT `t_purchse_return_sum_ibfk_2` FOREIGN KEY (`bc`) REFERENCES `s_branches` (`code`),
  CONSTRAINT `t_purchse_return_sum_ibfk_3` FOREIGN KEY (`oc`) REFERENCES `s_users` (`cCode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_purchse_return_sum` */

/*Table structure for table `t_purchse_sum` */

DROP TABLE IF EXISTS `t_purchse_sum`;

CREATE TABLE `t_purchse_sum` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `no` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `ref_no` varchar(25) NOT NULL,
  `memo` varchar(255) DEFAULT NULL,
  `supplier` varchar(10) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `stores` varchar(15) DEFAULT NULL,
  `invoice_no` varchar(25) DEFAULT NULL,
  `po_no` int(11) DEFAULT '0',
  `posting` tinyint(4) DEFAULT '0',
  `bc` varchar(10) NOT NULL,
  `oc` varchar(10) NOT NULL,
  `is_cancel` smallint(6) DEFAULT '0',
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`no`,`bc`),
  KEY `oc` (`oc`),
  KEY `bc` (`bc`),
  KEY `supplier` (`supplier`),
  CONSTRAINT `t_purchse_sum_ibfk_1` FOREIGN KEY (`supplier`) REFERENCES `m_supplier` (`code`),
  CONSTRAINT `t_purchse_sum_ibfk_2` FOREIGN KEY (`bc`) REFERENCES `s_branches` (`code`),
  CONSTRAINT `t_purchse_sum_ibfk_3` FOREIGN KEY (`oc`) REFERENCES `s_users` (`cCode`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `t_purchse_sum` */

insert  into `t_purchse_sum`(`id`,`no`,`date`,`ref_no`,`memo`,`supplier`,`discount`,`stores`,`invoice_no`,`po_no`,`posting`,`bc`,`oc`,`is_cancel`,`action_date`) values (6,1,'2013-12-07','Reference No','Memo','LANIK','4000.00','KURU001','Invoice No',0,0,'001','1',0,'2013-12-07 11:40:09');

/*Table structure for table `t_purchse_trance` */

DROP TABLE IF EXISTS `t_purchse_trance`;

CREATE TABLE `t_purchse_trance` (
  `trance_id` bigint(20) unsigned NOT NULL,
  `trance_type` varchar(25) NOT NULL,
  `item_code` varchar(20) NOT NULL DEFAULT '',
  `in_no` int(10) DEFAULT NULL,
  `in_quantity` decimal(10,2) DEFAULT '0.00',
  `out_no` int(10) DEFAULT NULL,
  `out_quantity` decimal(10,2) DEFAULT '0.00',
  `date` date DEFAULT NULL,
  `ad` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`trance_id`,`trance_type`,`item_code`),
  KEY `item_code` (`item_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_purchse_trance` */

insert  into `t_purchse_trance`(`trance_id`,`trance_type`,`item_code`,`in_no`,`in_quantity`,`out_no`,`out_quantity`,`date`,`ad`) values (6,'PUR','LATADI001',1,'2.00',1,'0.00','2013-12-07','2013-12-07 11:40:09'),(6,'PUR','LATADI002',1,'2.00',1,'0.00','2013-12-07','2013-12-07 11:40:09');

/*Table structure for table `t_sales_det` */

DROP TABLE IF EXISTS `t_sales_det`;

CREATE TABLE `t_sales_det` (
  `id` bigint(20) unsigned NOT NULL,
  `item_code` varchar(20) NOT NULL,
  `cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quantity` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(10,2) DEFAULT '0.00',
  `discount_pre` decimal(10,2) DEFAULT '0.00',
  `foc` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`,`item_code`),
  KEY `item_code` (`item_code`),
  CONSTRAINT `t_sales_det_ibfk_1` FOREIGN KEY (`id`) REFERENCES `t_sales_sum` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `t_sales_det_ibfk_2` FOREIGN KEY (`item_code`) REFERENCES `m_items` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_sales_det` */

insert  into `t_sales_det`(`id`,`item_code`,`cost`,`quantity`,`discount`,`discount_pre`,`foc`) values (1,'COTNO','10.00','1.00','0.00','0.00','0.00'),(2,'COTNO','10.00','1.00','0.00','0.00','0.00');

/*Table structure for table `t_sales_return_det` */

DROP TABLE IF EXISTS `t_sales_return_det`;

CREATE TABLE `t_sales_return_det` (
  `id` bigint(20) unsigned NOT NULL,
  `item_code` varchar(20) NOT NULL,
  `cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quantity` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`,`item_code`),
  KEY `item_code` (`item_code`),
  CONSTRAINT `t_sales_return_det_ibfk_1` FOREIGN KEY (`id`) REFERENCES `t_sales_return_sum` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `t_sales_return_det_ibfk_2` FOREIGN KEY (`item_code`) REFERENCES `m_items` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_sales_return_det` */

insert  into `t_sales_return_det`(`id`,`item_code`,`cost`,`quantity`) values (1,'LATADI002','30000.00','2.00');

/*Table structure for table `t_sales_return_sum` */

DROP TABLE IF EXISTS `t_sales_return_sum`;

CREATE TABLE `t_sales_return_sum` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `no` bigint(20) NOT NULL,
  `reason` varchar(100) DEFAULT NULL,
  `date` date NOT NULL,
  `ref_no` varchar(25) NOT NULL,
  `customer` varchar(15) DEFAULT NULL,
  `stores` varchar(15) DEFAULT NULL,
  `trance_type` tinyint(1) DEFAULT '0',
  `invoice_no` bigint(20) NOT NULL DEFAULT '0',
  `bc` varchar(10) NOT NULL,
  `oc` varchar(10) NOT NULL,
  `posting` smallint(6) DEFAULT '0',
  `is_cancel` smallint(6) DEFAULT '0',
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sales_ref` varchar(15) DEFAULT '',
  PRIMARY KEY (`id`,`no`,`invoice_no`,`bc`),
  KEY `oc` (`oc`),
  KEY `bc` (`bc`),
  KEY `supplier` (`customer`),
  CONSTRAINT `t_sales_return_sum_ibfk_1` FOREIGN KEY (`customer`) REFERENCES `m_customer` (`code`),
  CONSTRAINT `t_sales_return_sum_ibfk_2` FOREIGN KEY (`bc`) REFERENCES `s_branches` (`code`),
  CONSTRAINT `t_sales_return_sum_ibfk_3` FOREIGN KEY (`oc`) REFERENCES `s_users` (`cCode`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `t_sales_return_sum` */

insert  into `t_sales_return_sum`(`id`,`no`,`reason`,`date`,`ref_no`,`customer`,`stores`,`trance_type`,`invoice_no`,`bc`,`oc`,`posting`,`is_cancel`,`action_date`,`sales_ref`) values (1,1,NULL,'2013-12-07','Reference No','CASH - 001','KURU001',0,1,'001','1',0,0,'2013-12-07 11:55:55','839335888V');

/*Table structure for table `t_sales_sum` */

DROP TABLE IF EXISTS `t_sales_sum`;

CREATE TABLE `t_sales_sum` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `no` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `ref_no` varchar(25) NOT NULL,
  `memo` varchar(255) DEFAULT NULL,
  `customer` varchar(15) DEFAULT NULL,
  `sales_ref` varchar(10) DEFAULT NULL,
  `discount` decimal(10,4) DEFAULT NULL,
  `balance` decimal(10,4) DEFAULT NULL,
  `pay_amount` decimal(10,2) DEFAULT '0.00',
  `advance` decimal(10,2) DEFAULT '0.00',
  `stores` varchar(15) DEFAULT NULL,
  `credit` decimal(10,2) DEFAULT '0.00',
  `cheque` decimal(10,2) DEFAULT '0.00',
  `so_no` int(11) DEFAULT '0',
  `r_margin` decimal(10,2) DEFAULT NULL,
  `c_margin` decimal(10,2) DEFAULT NULL,
  `bc` varchar(10) NOT NULL,
  `oc` varchar(10) NOT NULL,
  `posting` smallint(6) DEFAULT '0',
  `is_cancel` smallint(6) DEFAULT '0',
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`no`,`bc`),
  KEY `oc` (`oc`),
  KEY `bc` (`bc`),
  KEY `supplier` (`customer`),
  CONSTRAINT `t_sales_sum_ibfk_1` FOREIGN KEY (`customer`) REFERENCES `m_customer` (`code`),
  CONSTRAINT `t_sales_sum_ibfk_2` FOREIGN KEY (`bc`) REFERENCES `s_branches` (`code`),
  CONSTRAINT `t_sales_sum_ibfk_3` FOREIGN KEY (`oc`) REFERENCES `s_users` (`cCode`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `t_sales_sum` */

insert  into `t_sales_sum`(`id`,`no`,`date`,`ref_no`,`memo`,`customer`,`sales_ref`,`discount`,`balance`,`pay_amount`,`advance`,`stores`,`credit`,`cheque`,`so_no`,`r_margin`,`c_margin`,`bc`,`oc`,`posting`,`is_cancel`,`action_date`) values (1,1,'2013-12-26','Reference No','Memo','ABC001','839335888V','0.0000','0.0000','10.00','0.00','KURU001','10.00','0.00',0,NULL,NULL,'001','1',0,0,'2013-12-26 15:13:59'),(2,2,'2013-12-26','Reference No','Memo','ABC001','839335888V','0.0000','0.0000','10.00','0.00','KURU001','10.00','0.00',0,NULL,NULL,'001','1',0,0,'2013-12-26 15:14:10');

/*Table structure for table `t_sales_trance` */

DROP TABLE IF EXISTS `t_sales_trance`;

CREATE TABLE `t_sales_trance` (
  `cus_id` varchar(20) NOT NULL,
  `date` date DEFAULT NULL,
  `item_code` varchar(20) NOT NULL,
  `in_no` int(10) DEFAULT NULL,
  `in_qty` decimal(10,2) DEFAULT NULL,
  `out_no` int(10) DEFAULT NULL,
  `out_qty` decimal(10,2) DEFAULT NULL,
  `trance_code` varchar(15) DEFAULT NULL,
  `trance_no` int(10) NOT NULL,
  `pay_type` varchar(20) NOT NULL,
  `bc` varchar(10) NOT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`cus_id`,`item_code`,`trance_no`,`pay_type`,`bc`),
  KEY `item_code` (`item_code`),
  CONSTRAINT `t_sales_trance_ibfk_1` FOREIGN KEY (`cus_id`) REFERENCES `m_customer` (`code`),
  CONSTRAINT `t_sales_trance_ibfk_2` FOREIGN KEY (`item_code`) REFERENCES `m_items` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_sales_trance` */

insert  into `t_sales_trance`(`cus_id`,`date`,`item_code`,`in_no`,`in_qty`,`out_no`,`out_qty`,`trance_code`,`trance_no`,`pay_type`,`bc`,`action_date`) values ('ABC001','2013-12-26','COTNO',1,'1.00',0,'0.00','CR_SALE',1,'1','001','2013-12-26 15:13:59'),('ABC001','2013-12-26','COTNO',2,'1.00',0,'0.00','CR_SALE',2,'1','001','2013-12-26 15:14:10'),('ABC001','2013-12-01','COTNO',3,'1.00',0,'0.00','SALE',10,'0','001','2013-12-01 15:14:30'),('CASH - 001','2013-12-07','LATADI001',1,'1.00',0,'0.00','SALE',8,'0','001','2013-12-07 11:47:40'),('CASH - 001','2013-12-07','LATADI002',1,'0.00',1,'2.00','SALE_RET',1,'0','001','2013-12-07 11:55:55'),('CASH - 001','2013-12-07','LATADI002',1,'2.00',0,'0.00','SALE',8,'0','001','2013-12-07 11:47:40'),('CASH - 001','2013-12-09','LATADI002',2,'1.00',0,'0.00','SALE',9,'0','001','2013-12-09 09:55:13');

/*Table structure for table `t_serial_movement` */

DROP TABLE IF EXISTS `t_serial_movement`;

CREATE TABLE `t_serial_movement` (
  `type` varchar(25) DEFAULT NULL,
  `no` int(11) DEFAULT NULL,
  `item_code` varchar(25) DEFAULT NULL,
  `serial_no` varchar(25) DEFAULT NULL,
  `in` int(11) DEFAULT '0',
  `out` int(11) DEFAULT '0',
  `store_code` varchar(25) DEFAULT NULL,
  `is_temp` int(11) DEFAULT '0',
  `is_selected` int(11) DEFAULT '0',
  `is_avalable` tinyint(4) DEFAULT '1',
  `oc` smallint(6) DEFAULT NULL,
  `action_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_serial_movement` */

/*Table structure for table `t_stock_adj_det` */

DROP TABLE IF EXISTS `t_stock_adj_det`;

CREATE TABLE `t_stock_adj_det` (
  `id` bigint(20) unsigned NOT NULL,
  `item_code` varchar(20) NOT NULL,
  `system` decimal(10,2) NOT NULL DEFAULT '0.00',
  `actual` decimal(10,2) NOT NULL DEFAULT '0.00',
  `balance` decimal(10,2) DEFAULT '0.00',
  `purchase` decimal(10,2) DEFAULT '0.00',
  `value` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`,`item_code`),
  KEY `item_code` (`item_code`),
  CONSTRAINT `t_stock_adj_det_ibfk_1` FOREIGN KEY (`id`) REFERENCES `t_stock_adj_sum` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `t_stock_adj_det_ibfk_2` FOREIGN KEY (`item_code`) REFERENCES `m_items` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_stock_adj_det` */

/*Table structure for table `t_stock_adj_sum` */

DROP TABLE IF EXISTS `t_stock_adj_sum`;

CREATE TABLE `t_stock_adj_sum` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `no` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `ref_no` varchar(25) NOT NULL,
  `memo` varchar(255) DEFAULT NULL,
  `stores` varchar(15) DEFAULT NULL,
  `posting` tinyint(4) DEFAULT '0',
  `bc` varchar(10) NOT NULL,
  `oc` varchar(10) NOT NULL,
  `is_cancel` smallint(6) DEFAULT '0',
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`no`,`bc`),
  KEY `oc` (`oc`),
  KEY `bc` (`bc`),
  KEY `stores` (`stores`),
  CONSTRAINT `t_stock_adj_sum_ibfk_1` FOREIGN KEY (`stores`) REFERENCES `m_stores` (`code`),
  CONSTRAINT `t_stock_adj_sum_ibfk_2` FOREIGN KEY (`bc`) REFERENCES `s_branches` (`code`),
  CONSTRAINT `t_stock_adj_sum_ibfk_3` FOREIGN KEY (`oc`) REFERENCES `s_users` (`cCode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_stock_adj_sum` */

/*Table structure for table `t_supplier_acc_trance` */

DROP TABLE IF EXISTS `t_supplier_acc_trance`;

CREATE TABLE `t_supplier_acc_trance` (
  `id` bigint(20) DEFAULT NULL,
  `module` varchar(25) DEFAULT NULL,
  `supplier` varchar(20) NOT NULL,
  `dr_trnce_code` varchar(15) DEFAULT NULL,
  `dr_trnce_no` bigint(20) DEFAULT NULL,
  `cr_trnce_code` varchar(15) DEFAULT NULL,
  `cr_trnce_no` bigint(20) DEFAULT NULL,
  `dr_amount` decimal(10,2) DEFAULT '0.00',
  `cr_amount` decimal(10,2) DEFAULT '0.00',
  `bc` varchar(10) DEFAULT NULL,
  `oc` varchar(10) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `bc` (`bc`),
  KEY `oc` (`oc`),
  KEY `supplier` (`supplier`),
  CONSTRAINT `t_supplier_acc_trance_ibfk_1` FOREIGN KEY (`supplier`) REFERENCES `m_supplier` (`code`),
  CONSTRAINT `t_supplier_acc_trance_ibfk_2` FOREIGN KEY (`bc`) REFERENCES `s_branches` (`code`),
  CONSTRAINT `t_supplier_acc_trance_ibfk_3` FOREIGN KEY (`oc`) REFERENCES `s_users` (`cCode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_supplier_acc_trance` */

insert  into `t_supplier_acc_trance`(`id`,`module`,`supplier`,`dr_trnce_code`,`dr_trnce_no`,`cr_trnce_code`,`cr_trnce_no`,`dr_amount`,`cr_amount`,`bc`,`oc`,`date`,`action_date`) values (6,'PUR','LANIK','PURCHASE',1,'PURCHASE',1,'84000.00','0.00','001','1','2013-12-07','2013-12-07 11:40:09');

/*Table structure for table `t_supplier_cheques` */

DROP TABLE IF EXISTS `t_supplier_cheques`;

CREATE TABLE `t_supplier_cheques` (
  `id` int(10) unsigned DEFAULT NULL,
  `module` varchar(25) DEFAULT NULL,
  `cheque_no` varchar(30) DEFAULT NULL,
  `account_no` varchar(30) DEFAULT NULL,
  `cheque_amount` decimal(10,2) DEFAULT NULL,
  `state` tinyint(4) DEFAULT '0',
  `bank` varchar(15) DEFAULT NULL,
  `bank_branch` varchar(15) DEFAULT NULL,
  `realize_date` date DEFAULT NULL,
  `is_cancel` smallint(6) DEFAULT '0',
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_supplier_cheques` */

/*Table structure for table `t_supplier_credit_note` */

DROP TABLE IF EXISTS `t_supplier_credit_note`;

CREATE TABLE `t_supplier_credit_note` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `no` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `supplier` varchar(25) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `cr_account` varchar(25) DEFAULT NULL,
  `cr_account_des` varchar(200) DEFAULT NULL,
  `dr_account` varchar(25) DEFAULT NULL,
  `dr_account_des` varchar(200) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `bc` varchar(25) DEFAULT NULL,
  `oc` varchar(25) DEFAULT NULL,
  `is_cancel` tinyint(4) DEFAULT '0',
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `bc` (`bc`),
  KEY `oc` (`oc`),
  KEY `custmer` (`supplier`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_supplier_credit_note` */

/*Table structure for table `t_supplier_debit_credit_note` */

DROP TABLE IF EXISTS `t_supplier_debit_credit_note`;

CREATE TABLE `t_supplier_debit_credit_note` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `no` int(10) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `amount` double(10,2) DEFAULT NULL,
  `supplier` varchar(10) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `bc` varchar(10) DEFAULT NULL,
  `oc` varchar(10) DEFAULT NULL,
  `is_cancel` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_supplier_debit_credit_note` */

/*Table structure for table `t_supplier_debit_note` */

DROP TABLE IF EXISTS `t_supplier_debit_note`;

CREATE TABLE `t_supplier_debit_note` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `no` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `supplier` varchar(25) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `cr_account` varchar(25) DEFAULT NULL,
  `cr_account_des` varchar(200) DEFAULT NULL,
  `dr_account` varchar(25) DEFAULT NULL,
  `dr_account_des` varchar(200) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `bc` varchar(25) DEFAULT NULL,
  `oc` varchar(25) DEFAULT NULL,
  `is_cancel` tinyint(4) DEFAULT '0',
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `bc` (`bc`),
  KEY `oc` (`oc`),
  KEY `custmer` (`supplier`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_supplier_debit_note` */

/*Table structure for table `t_supplier_receipt_det` */

DROP TABLE IF EXISTS `t_supplier_receipt_det`;

CREATE TABLE `t_supplier_receipt_det` (
  `id` int(10) unsigned DEFAULT NULL,
  `purchase_no` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT NULL,
  `paid` decimal(10,2) DEFAULT NULL,
  KEY `id` (`id`),
  CONSTRAINT `t_supplier_receipt_det_ibfk_1` FOREIGN KEY (`id`) REFERENCES `t_supplier_receipt_sum` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_supplier_receipt_det` */

/*Table structure for table `t_supplier_receipt_sum` */

DROP TABLE IF EXISTS `t_supplier_receipt_sum`;

CREATE TABLE `t_supplier_receipt_sum` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `no` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `ref_no` varchar(100) DEFAULT NULL,
  `memo` varchar(255) DEFAULT NULL,
  `cheque_amount` decimal(10,2) DEFAULT '0.00',
  `cash_amount` decimal(10,2) DEFAULT '0.00',
  `balance` decimal(10,2) DEFAULT NULL,
  `supplier` varchar(15) DEFAULT NULL,
  `posting` smallint(6) DEFAULT NULL,
  `is_cancel` smallint(6) DEFAULT '0',
  `bc` varchar(10) DEFAULT NULL,
  `oc` varchar(10) DEFAULT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `supplier` (`supplier`),
  KEY `bc` (`bc`),
  KEY `oc` (`oc`),
  CONSTRAINT `t_supplier_receipt_sum_ibfk_1` FOREIGN KEY (`supplier`) REFERENCES `m_supplier` (`code`),
  CONSTRAINT `t_supplier_receipt_sum_ibfk_2` FOREIGN KEY (`bc`) REFERENCES `s_branches` (`code`),
  CONSTRAINT `t_supplier_receipt_sum_ibfk_3` FOREIGN KEY (`oc`) REFERENCES `s_users` (`cCode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_supplier_receipt_sum` */

/*Table structure for table `t_supplier_settle_det` */

DROP TABLE IF EXISTS `t_supplier_settle_det`;

CREATE TABLE `t_supplier_settle_det` (
  `id` int(10) unsigned DEFAULT NULL,
  `trance_type` varchar(25) DEFAULT NULL,
  `trance_no` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `paid` decimal(10,2) DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT NULL,
  `settle` decimal(10,2) DEFAULT NULL,
  KEY `id` (`id`),
  CONSTRAINT `t_supplier_settle_det_ibfk_1` FOREIGN KEY (`id`) REFERENCES `t_supplier_settle_sum` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_supplier_settle_det` */

/*Table structure for table `t_supplier_settle_sum` */

DROP TABLE IF EXISTS `t_supplier_settle_sum`;

CREATE TABLE `t_supplier_settle_sum` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `no` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `ref_no` varchar(100) DEFAULT NULL,
  `memo` varchar(255) DEFAULT NULL,
  `dbalance` decimal(10,2) DEFAULT '0.00',
  `cbalance` decimal(10,2) DEFAULT '0.00',
  `supplier` varchar(15) DEFAULT NULL,
  `type_pay` varchar(25) DEFAULT NULL,
  `no_pay` int(11) DEFAULT NULL,
  `total_pay` decimal(10,2) DEFAULT NULL,
  `paid_pay` decimal(10,2) DEFAULT NULL,
  `balance_pay` decimal(10,2) DEFAULT NULL,
  `sett_pay` decimal(10,2) DEFAULT NULL,
  `posting` smallint(6) DEFAULT '0',
  `is_cancel` smallint(6) DEFAULT '0',
  `bc` varchar(10) DEFAULT NULL,
  `oc` varchar(10) DEFAULT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `oc` (`oc`),
  KEY `bc` (`bc`),
  KEY `supplier` (`supplier`),
  CONSTRAINT `t_supplier_settle_sum_ibfk_1` FOREIGN KEY (`supplier`) REFERENCES `m_supplier` (`code`),
  CONSTRAINT `t_supplier_settle_sum_ibfk_2` FOREIGN KEY (`bc`) REFERENCES `s_branches` (`code`),
  CONSTRAINT `t_supplier_settle_sum_ibfk_3` FOREIGN KEY (`oc`) REFERENCES `s_users` (`cCode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_supplier_settle_sum` */

/*Table structure for table `t_supplier_transaction` */

DROP TABLE IF EXISTS `t_supplier_transaction`;

CREATE TABLE `t_supplier_transaction` (
  `id` bigint(20) DEFAULT NULL,
  `module` varchar(25) DEFAULT NULL,
  `supplier` varchar(20) NOT NULL,
  `dr_trnce_code` varchar(15) DEFAULT NULL,
  `dr_trnce_no` bigint(20) DEFAULT NULL,
  `cr_trnce_code` varchar(15) DEFAULT NULL,
  `cr_trnce_no` bigint(20) DEFAULT NULL,
  `dr_amount` decimal(10,2) DEFAULT '0.00',
  `cr_amount` decimal(10,2) DEFAULT '0.00',
  `bc` varchar(10) DEFAULT NULL,
  `oc` varchar(10) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `bc` (`bc`),
  KEY `oc` (`oc`),
  KEY `supplier` (`supplier`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_supplier_transaction` */

/*Table structure for table `u_add_user_role` */

DROP TABLE IF EXISTS `u_add_user_role`;

CREATE TABLE `u_add_user_role` (
  `user_id` varchar(20) COLLATE utf8_bin NOT NULL,
  `date_from` date DEFAULT NULL,
  `date_to` date DEFAULT NULL,
  `role_id` varchar(20) COLLATE utf8_bin NOT NULL,
  `bc` varchar(20) COLLATE utf8_bin NOT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ci` int(1) DEFAULT NULL,
  PRIMARY KEY (`user_id`,`role_id`,`bc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `u_add_user_role` */

insert  into `u_add_user_role`(`user_id`,`date_from`,`date_to`,`role_id`,`bc`,`action_date`,`ci`) values ('1','0000-00-00','0000-00-00','001','002','2012-12-19 20:25:49',NULL),('10','0000-00-00','0000-00-00','MS-Admin','001','2013-04-27 21:53:57',NULL),('11','0000-00-00','0000-00-00','HO-ADM','001','2013-08-11 22:29:00',NULL),('2','0000-00-00','0000-00-00','001','001','2013-12-13 09:04:17',NULL),('3','0000-00-00','0000-00-00','001','001','2013-02-07 20:26:55',NULL),('4','0000-00-00','0000-00-00','001','001','2013-02-07 20:28:09',NULL),('5','0000-00-00','0000-00-00','001','001','2013-08-16 03:39:23',NULL),('5','0000-00-00','0000-00-00','HO-ADM','001','2013-08-16 03:39:23',NULL),('6','0000-00-00','0000-00-00','001','001','2013-06-25 05:11:31',NULL),('7','0000-00-00','0000-00-00','MS-Admin','001','2013-06-26 22:37:20',NULL),('9','0000-00-00','0000-00-00','001','001','2013-09-14 00:59:39',NULL),('DRP','0000-00-00','0000-00-00','MS-Admin','001','2013-06-26 22:32:53',NULL),('HO-5','0000-00-00','0000-00-00','001','001','2013-07-13 01:49:20',NULL);

/*Table structure for table `u_add_user_role_log` */

DROP TABLE IF EXISTS `u_add_user_role_log`;

CREATE TABLE `u_add_user_role_log` (
  `user_id` varchar(20) COLLATE utf8_bin NOT NULL,
  `date_from` date DEFAULT NULL,
  `date_to` date DEFAULT NULL,
  `role_id` varchar(20) COLLATE utf8_bin NOT NULL,
  `bc` varchar(20) COLLATE utf8_bin NOT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `u_add_user_role_log` */

insert  into `u_add_user_role_log`(`user_id`,`date_from`,`date_to`,`role_id`,`bc`,`action_date`) values ('1','0000-00-00','0000-00-00','001','002','2012-12-17 19:57:53'),('1','0000-00-00','0000-00-00','001','002','2012-12-19 20:25:49'),('10','0000-00-00','0000-00-00','001','001','2013-02-07 20:26:32'),('2','0000-00-00','0000-00-00','001','001','2013-02-07 20:26:42'),('3','0000-00-00','0000-00-00','001','001','2013-02-07 20:26:55'),('4','0000-00-00','0000-00-00','001','001','2013-02-07 20:27:10'),('4','0000-00-00','0000-00-00','001','001','2013-02-07 20:28:09'),('5','0000-00-00','0000-00-00','001','001','2013-02-07 20:28:18'),('6','0000-00-00','0000-00-00','001','001','2013-02-07 20:28:26'),('7','0000-00-00','0000-00-00','001','001','2013-02-07 20:28:37'),('10','0000-00-00','0000-00-00','001','001','2013-02-21 03:35:43'),('10','0000-00-00','0000-00-00','ST-ADM','001','2013-04-22 00:27:42'),('7','0000-00-00','0000-00-00','ST-ADM','001','2013-04-22 00:28:45'),('5','0000-00-00','0000-00-00','HO-ADM','001','2013-04-22 00:59:12'),('7','0000-00-00','0000-00-00','MS-Admin','001','2013-04-27 04:28:01'),('10','0000-00-00','0000-00-00','MS-Admin','001','2013-04-27 21:53:57'),('7','0000-00-00','0000-00-00','HO-ADM','001','2013-04-27 22:02:04'),('7','0000-00-00','0000-00-00','MS-Admin','001','2013-04-27 22:10:23'),('7','0000-00-00','0000-00-00','HO-ADM','001','2013-05-17 02:06:30'),('7','0000-00-00','0000-00-00','MS-Admin','001','2013-05-22 22:52:25'),('7','0000-00-00','0000-00-00','HO-ADM','001','2013-05-27 21:47:19'),('7','0000-00-00','0000-00-00','MS-Admin','001','2013-06-20 02:28:19'),('5','0000-00-00','0000-00-00','HO-ADM','001','2013-06-21 02:37:05'),('5','0000-00-00','0000-00-00','001','001','2013-06-21 02:37:05'),('5','0000-00-00','0000-00-00','HO-ADM','001','2013-06-22 11:02:52'),('7','0000-00-00','0000-00-00','HO-ADM','001','2013-06-22 11:12:00'),('6','0000-00-00','0000-00-00','001','001','2013-06-25 05:05:29'),('6','0000-00-00','0000-00-00','MS-Admin','001','2013-06-25 05:05:29'),('6','0000-00-00','0000-00-00','HO-ADM','001','2013-06-25 05:05:29'),('6','0000-00-00','0000-00-00','001','001','2013-06-25 05:11:31'),('7','0000-00-00','0000-00-00','MS-Admin','001','2013-06-26 00:12:55'),('7','0000-00-00','0000-00-00','HO-ADM','001','2013-06-26 00:12:55'),('7','0000-00-00','0000-00-00','MS-Admin','001','2013-06-26 00:15:07'),('5','0000-00-00','0000-00-00','001','001','2013-06-26 02:46:26'),('5','0000-00-00','0000-00-00','HO-ADM','001','2013-06-26 02:46:26'),('DRP','0000-00-00','0000-00-00','MS-Admin','001','2013-06-26 22:32:53'),('7','0000-00-00','0000-00-00','MS-Admin','001','2013-06-26 22:37:20'),('HO-5','0000-00-00','0000-00-00','HO-ADM','001','2013-07-01 04:38:23'),('HO-5','0000-00-00','0000-00-00','MS-Admin','001','2013-07-04 21:50:54'),('HO-5','0000-00-00','0000-00-00','HO-ADM','001','2013-07-04 21:50:54'),('HO-5','0000-00-00','0000-00-00','001','001','2013-07-04 21:53:26'),('HO-5','0000-00-00','0000-00-00','HO-ADM','001','2013-07-04 21:53:26'),('HO-5','0000-00-00','0000-00-00','001','001','2013-07-13 01:49:20'),('11','0000-00-00','0000-00-00','HO-ADM','001','2013-08-11 22:29:00'),('5','0000-00-00','0000-00-00','001','001','2013-08-14 22:00:57'),('5','0000-00-00','0000-00-00','001','001','2013-08-16 03:39:23'),('5','0000-00-00','0000-00-00','HO-ADM','001','2013-08-16 03:39:23'),('9','0000-00-00','0000-00-00','001','001','2013-09-14 00:59:39'),('2','0000-00-00','0000-00-00','001','001','2013-12-13 09:04:17');

/*Table structure for table `u_modules` */

DROP TABLE IF EXISTS `u_modules`;

CREATE TABLE `u_modules` (
  `m_code` varchar(15) COLLATE utf8_bin NOT NULL,
  `m_description` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`m_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `u_modules` */

insert  into `u_modules`(`m_code`,`m_description`,`action_date`) values ('001','MASTER-MAIN REGION','2013-12-02 11:51:36'),('002','MASTER SUB REGION','2013-12-02 12:28:55'),('003','MASTER SALES REF','2013-12-02 12:29:21'),('004','MASTER AREA','2013-12-02 12:29:39'),('005','MASTER ROUTE','2013-12-02 12:29:56'),('006','MASTER SUPPLIER','2013-12-02 12:30:27'),('007','MASTER CUSTOMER ENTER/EDIT','2013-12-02 12:32:12'),('008','MASTER CUSTOMER IMPORT','2013-12-02 12:31:50'),('009','MASTER DEPARTMENT','2013-12-02 12:33:26'),('010','MASTER STORES','2013-12-02 12:33:49'),('011','MASTER MAIN CATEGORY','2013-12-02 12:35:04'),('012','MASTER SUB CATEGORY','2013-12-02 12:35:15'),('013','MASTER UNITS','2013-12-02 12:35:33'),('014','MASTER ITEMS ADD/EDIT','2013-12-02 12:36:15'),('015','MASTER ITEMS IMPORT','2013-12-02 12:36:33'),('016','MASTER AGE ANALYZE SETUP','2013-12-02 12:38:08'),('017','MASTER DEFAULT ACCOUNT','2013-12-02 12:38:35'),('018','TRAS PURCHASE ORDER','2013-12-02 12:43:26'),('019','TRAS OPENING STOCK','2013-12-02 12:42:42'),('020','TRAS-SUP-PURCHASE','2013-12-02 12:47:28'),('021','TRAS-SUP-PURCHASE RETURN','2013-12-02 12:49:14'),('022','TRAS-SUP-SUPPLIER VOUCHER','2013-12-02 12:49:51'),('023','TRAS-SUP-SUPPLIER SETTLEMENT','2013-12-02 12:50:12'),('024','CUS-SALES-CREDIT','2013-12-02 15:42:01'),('025','CUS OPENING CHEQUES','2012-12-10 20:45:24'),('026','CUS-SALES','2013-12-02 13:00:04'),('027','CUS-SALES RETURN','2013-12-02 13:00:23'),('028','CUS-RECEIPT','2013-12-02 13:53:03'),('029','CUS-CREDIT NOTE','2013-12-02 13:53:19'),('030','CUS-SALES-ADVANCE','2013-12-02 15:44:06'),('031','CUS-SALES-ADVANCE REFUND','2013-12-02 15:44:44'),('032','CUS-SALES-EASY PAYMENT','2013-12-02 15:45:53'),('033','CUS-DEBIT NOTE','2013-12-02 15:46:38'),('034','CUS-CUSTOMER  SETTLEMENT','2013-12-02 15:48:17'),('035','CUS-POSTING','2013-12-02 15:49:35'),('036','CUS-STOCK  ADJUSTMENT','2013-12-02 15:51:11'),('037','CUS-DAMAGES  FREE  ISSUES','2013-12-02 15:52:48'),('038','CUS-PRICE  CHANGE','2013-12-02 15:53:42'),('039','CUS-CHEQUE BOOK','2013-12-02 15:54:51'),('040','REPORT-SALE ANALYZE','2013-12-02 15:56:30'),('041','REPORT-ITEM  LIST/PRICE LIST','2013-12-02 15:57:56'),('042','REPORT-BIN  CARD','2013-12-02 15:58:45'),('043','REPORT-PURCHASE ORDER','2013-12-02 15:59:37'),('044','REPORT-STORCK-SORCK REPORT(VLUATION)','2013-12-02 16:01:51'),('045','REPORT-STORCK REPORT(VERIFICATION)','2013-12-02 16:03:16'),('046','REPORT-STOCK  IN  HAND REPORT','2013-12-02 16:04:56'),('047','REPORT-VOUCHER-VOUCHER DETAILS','2013-12-02 16:06:20'),('048','REPORT-VOUCHER-VOUCHER  SUMMARY','2013-12-02 16:16:27'),('049','REPORT-DISPATCH-','2013-12-02 16:19:03'),('050','REPORTR-DISPATCH-DISPATCH STATUS REPORT','2013-12-02 16:21:09'),('051','REPORT-DISPATCH- DISPATCH PENDING REPORT','2013-12-02 16:22:37'),('052','REPORT-RECEIPT-RECEIPT LIST','2013-12-02 16:25:11'),('053','REPORT-RECEIPT- CREDIT COLLECTION','2013-12-02 16:25:52'),('054','REPORT-RECEIPT- COLLECTION ALL','2013-12-02 16:26:38'),('055','REPORT- SUPPLIER  SUPPLIER-LIST','2013-12-02 16:27:54'),('056','REPORT- SUPPLIER  PURCHASE','2013-12-02 16:28:59'),('057','REPORT- SUPPLIER  GRN ITEMWISE ','2013-12-02 16:30:35'),('058','REPORT- SUPPLIER  FREE ISSUE','2013-12-02 16:31:34'),('059','REPORT- SUPPLIER  PURCHASE RETURN','2013-12-02 16:33:05'),('060','REPORT- SUPPLIER  SUPPLIER BALANCE','2013-12-02 16:34:31'),('061','REPORT- SUPPLIER  AGE ANALYZE SUPPLIER','2013-12-02 16:35:26'),('062','REPORT- SUPPLIER  SUPPLIER HISTORY','2013-12-02 16:36:14'),('063','REPORT- CUSTOMER- CUSTOMER -LIST','2013-12-02 16:37:58'),('064','REPORT- CUSTOMER- SALES','2013-12-02 16:38:51'),('065','REPORT- CUSTOMER- SALES ADVANCE','2013-12-02 16:39:52'),('066','REPORT- CUSTOMER- ADVANCE REFUND','2013-12-02 16:42:32'),('067','REPORT- CUSTOMER- SALES RETURN','2013-12-02 16:43:21'),('068','REPORT- CUSTOMER- CUSTOMER BALANCE','2013-12-02 16:44:03'),('069','REPORT- CUSTOMER- CUSTOMER OUTSTAND','2013-12-02 16:44:50'),('070','REPORT- CUSTOMER- AGE ANALYZE REPORT 1','2013-12-02 16:48:29'),('071','REPORT- DAMAGES FREE ISSUES','2013-12-02 16:46:46'),('072','REPORT- DISCOUNT LIST REPORT','2013-12-02 16:49:55'),('073','REPORT- QUANTITY LIST REPORT','2013-12-02 16:50:40'),('074','SYSTEM- COMPANY','2013-12-02 16:53:17'),('075','SYSTEM- BRANCHES','2013-12-02 16:53:55'),('076','SYSTEM- USERS','2013-12-02 16:54:42'),('077','SYSTEM- MODULE','2013-12-02 16:55:22'),('078','SYSTEM- USER ROLE','2013-12-02 16:56:11'),('079','SYSTEM- ADD ROLE','2013-12-02 16:56:58'),('080','SYSTEM- BACKUP','2013-12-02 16:58:03'),('091','UNPOST','2013-09-12 04:32:06'),('092','MASTER SUB ITEM','2013-12-02 13:45:23'),('093','DISPATCH  RETURN','2013-12-02 13:48:11'),('094','CUSTOMER  RECEIPT','2013-12-02 13:50:29'),('095','CUS-CREDIT NOTE','2013-12-02 13:51:54'),('93','DISPATCH NOTE','2013-12-02 13:47:21');

/*Table structure for table `u_user_role` */

DROP TABLE IF EXISTS `u_user_role`;

CREATE TABLE `u_user_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` varchar(20) COLLATE utf8_bin NOT NULL,
  `description` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `bc` varchar(10) COLLATE utf8_bin NOT NULL,
  `oc` varchar(15) COLLATE utf8_bin DEFAULT NULL,
  `action_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`role_id`,`bc`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `u_user_role` */

insert  into `u_user_role`(`id`,`role_id`,`description`,`bc`,`oc`,`action_date`) values (88,'001','Administrator','001','1','2013-09-12 04:32:27');

/*Table structure for table `u_user_role_detail` */

DROP TABLE IF EXISTS `u_user_role_detail`;

CREATE TABLE `u_user_role_detail` (
  `id` int(10) unsigned NOT NULL,
  `role_id` varchar(20) COLLATE utf8_bin NOT NULL,
  `module_id` varchar(20) COLLATE utf8_bin NOT NULL,
  `is_view` tinyint(1) DEFAULT NULL,
  `is_add` tinyint(1) DEFAULT NULL,
  `is_edit` tinyint(1) DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT NULL,
  `is_print` tinyint(1) DEFAULT NULL,
  `is_re_print` tinyint(1) DEFAULT NULL,
  `is_back_date` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`,`role_id`,`module_id`),
  CONSTRAINT `u_user_role_detail_ibfk_1` FOREIGN KEY (`id`) REFERENCES `u_user_role` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `u_user_role_detail` */

insert  into `u_user_role_detail`(`id`,`role_id`,`module_id`,`is_view`,`is_add`,`is_edit`,`is_delete`,`is_print`,`is_re_print`,`is_back_date`) values (88,'001','001',1,1,1,1,1,1,1),(88,'001','002',1,1,1,1,1,1,1),(88,'001','003',1,1,1,1,1,1,1),(88,'001','004',1,1,1,1,1,1,1),(88,'001','005',1,1,1,1,1,1,1),(88,'001','006',1,1,1,1,1,1,1),(88,'001','007',1,1,1,1,1,1,1),(88,'001','008',1,1,1,1,1,1,1),(88,'001','009',1,1,1,1,1,1,1),(88,'001','010',1,1,1,1,1,1,1),(88,'001','011',1,1,1,1,1,1,1),(88,'001','012',1,1,1,1,1,1,1),(88,'001','013',1,1,1,1,1,1,1),(88,'001','014',1,1,1,1,1,1,1),(88,'001','015',1,1,1,1,1,1,1),(88,'001','016',1,1,1,1,1,1,1),(88,'001','017',1,1,1,1,1,1,1),(88,'001','018',1,1,1,1,1,1,1),(88,'001','019',1,1,1,1,1,1,1),(88,'001','020',1,1,1,1,1,1,1),(88,'001','021',1,1,1,1,1,1,1),(88,'001','022',1,1,1,1,1,1,1),(88,'001','023',1,1,1,1,1,1,1),(88,'001','024',1,1,1,1,1,1,1),(88,'001','025',1,1,1,1,1,1,1),(88,'001','026',1,1,1,1,1,1,1),(88,'001','027',1,1,1,1,1,1,1),(88,'001','028',1,1,1,1,1,1,1),(88,'001','029',1,1,1,1,1,1,1),(88,'001','030',1,1,1,1,1,1,1),(88,'001','031',1,1,1,1,1,1,1),(88,'001','032',1,1,1,1,1,1,1),(88,'001','033',1,1,1,1,1,1,1),(88,'001','034',1,1,1,1,1,1,1),(88,'001','035',1,1,1,1,1,1,1),(88,'001','036',1,1,1,1,1,1,1),(88,'001','037',1,1,1,1,1,1,1),(88,'001','038',1,1,1,1,1,1,1),(88,'001','039',1,1,1,1,1,1,1),(88,'001','040',1,1,1,1,1,1,1),(88,'001','041',1,1,1,1,1,1,1),(88,'001','042',1,1,1,1,1,1,1),(88,'001','043',1,1,1,1,1,1,1),(88,'001','044',1,1,1,1,1,1,1),(88,'001','045',1,1,1,1,1,1,1),(88,'001','046',1,1,1,1,1,1,1),(88,'001','047',1,1,1,1,1,1,1),(88,'001','048',1,1,1,1,1,1,1),(88,'001','049',1,1,1,1,1,1,1),(88,'001','050',1,1,1,1,1,1,1),(88,'001','051',1,1,1,1,1,1,1),(88,'001','052',1,1,1,1,1,1,1),(88,'001','053',1,1,1,1,1,1,1),(88,'001','054',1,1,1,1,1,1,1),(88,'001','055',1,1,1,1,1,1,1),(88,'001','056',1,1,1,1,1,1,1),(88,'001','057',1,1,1,1,1,1,1),(88,'001','058',1,1,1,1,1,1,1),(88,'001','059',1,1,1,1,1,1,1),(88,'001','060',1,1,1,1,1,1,1),(88,'001','061',1,1,1,1,1,1,1),(88,'001','062',1,1,1,1,1,1,1),(88,'001','063',1,1,1,1,1,1,1),(88,'001','064',1,1,1,1,1,1,1),(88,'001','065',1,1,1,1,1,1,1),(88,'001','066',1,1,1,1,1,1,1),(88,'001','067',1,1,1,1,1,1,1),(88,'001','068',1,1,1,1,1,1,1),(88,'001','069',1,1,1,1,1,1,1),(88,'001','070',1,1,1,1,1,1,1),(88,'001','071',1,1,1,1,1,1,1),(88,'001','072',1,1,1,1,1,1,1),(88,'001','073',1,1,1,1,1,1,1),(88,'001','074',1,1,1,1,1,1,1),(88,'001','075',1,1,1,1,1,1,1),(88,'001','076',1,1,1,1,1,1,1),(88,'001','077',1,1,1,1,1,1,1),(88,'001','078',1,1,1,1,1,1,1),(88,'001','079',1,1,1,1,1,1,1),(88,'001','080',1,1,1,1,1,1,1),(88,'001','081',1,1,1,1,1,1,1),(88,'001','082',1,1,1,1,1,1,1),(88,'001','083',1,1,1,1,1,1,1),(88,'001','084',1,1,1,1,1,1,1),(88,'001','085',1,1,1,1,1,1,1),(88,'001','086',0,1,1,1,1,1,1),(88,'001','087',0,0,0,0,0,0,0),(88,'001','088',1,1,1,1,1,1,1),(88,'001','089',1,0,0,0,1,0,0),(88,'001','090',1,0,0,0,1,0,0),(88,'001','091',1,1,0,0,0,0,0);

/*Table structure for table `u_user_role_permition` */

DROP TABLE IF EXISTS `u_user_role_permition`;

CREATE TABLE `u_user_role_permition` (
  `user_id` varchar(20) COLLATE utf8_bin NOT NULL,
  `module_id` varchar(20) COLLATE utf8_bin NOT NULL,
  `is_view` tinyint(1) DEFAULT NULL,
  `is_add` tinyint(1) DEFAULT NULL,
  `is_edit` tinyint(1) DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT NULL,
  `is_print` tinyint(1) DEFAULT NULL,
  `is_re_print` tinyint(1) DEFAULT NULL,
  `bc` varchar(10) COLLATE utf8_bin NOT NULL,
  `ci` int(11) NOT NULL,
  `action_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`,`module_id`,`bc`,`ci`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `u_user_role_permition` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `cCode` varchar(20) NOT NULL,
  `loginName` varchar(50) NOT NULL,
  `discription` varchar(50) DEFAULT NULL,
  `userPassword` varchar(50) DEFAULT NULL,
  `isAdmin` tinyint(1) unsigned DEFAULT NULL,
  `bc` varchar(5) NOT NULL,
  PRIMARY KEY (`cCode`,`bc`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `users` */

/*Table structure for table `advance_balance` */

DROP TABLE IF EXISTS `advance_balance`;

/*!50001 DROP VIEW IF EXISTS `advance_balance` */;
/*!50001 DROP TABLE IF EXISTS `advance_balance` */;

/*!50001 CREATE TABLE  `advance_balance`(
 `cr_trance_no` bigint(20) ,
 `customer` varchar(20) ,
 `AdvanceBalance` decimal(33,2) 
)*/;

/*Table structure for table `qry_cur_stock` */

DROP TABLE IF EXISTS `qry_cur_stock`;

/*!50001 DROP VIEW IF EXISTS `qry_cur_stock` */;
/*!50001 DROP TABLE IF EXISTS `qry_cur_stock` */;

/*!50001 CREATE TABLE  `qry_cur_stock`(
 `Item_Code` varchar(20) ,
 `Item_Name` varchar(255) ,
 `Current_Stock` decimal(33,2) 
)*/;

/*View structure for view advance_balance */

/*!50001 DROP TABLE IF EXISTS `advance_balance` */;
/*!50001 DROP VIEW IF EXISTS `advance_balance` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `advance_balance` AS select `t_advance_pay_trance`.`cr_trance_no` AS `cr_trance_no`,`t_advance_pay_trance`.`customer` AS `customer`,(sum(`t_advance_pay_trance`.`cr_trance_amount`) - sum(`t_advance_pay_trance`.`dr_trance_amount`)) AS `AdvanceBalance` from `t_advance_pay_trance` group by `t_advance_pay_trance`.`cr_trance_no` */;

/*View structure for view qry_cur_stock */

/*!50001 DROP TABLE IF EXISTS `qry_cur_stock` */;
/*!50001 DROP VIEW IF EXISTS `qry_cur_stock` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `qry_cur_stock` AS select `m_items`.`code` AS `Item_Code`,`m_items`.`description` AS `Item_Name`,ifnull((sum(`t_item_movement`.`in_quantity`) - sum(`t_item_movement`.`out_quantity`)),0) AS `Current_Stock` from (`m_items` left join `t_item_movement` on((`m_items`.`code` = `t_item_movement`.`item_code`))) group by `m_items`.`code` order by `m_items`.`code` */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
