/*
SQLyog Ultimate v8.55 
MySQL - 5.1.41 : Database - seetha
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`seetha` /*!40100 DEFAULT CHARACTER SET latin1 */;

/*Table structure for table `m_account` */

DROP TABLE IF EXISTS `m_account`;

CREATE TABLE `m_account` (
  `Type` varchar(10) DEFAULT NULL,
  `Code` varchar(10) NOT NULL,
  `Description` varchar(100) DEFAULT NULL,
  `Control_Acc` varchar(10) DEFAULT NULL,
  `Is_Control_Acc` tinyint(4) DEFAULT '0',
  `Is_Bank_Acc` tinyint(4) DEFAULT '0',
  `Category` varchar(10) DEFAULT NULL,
  `Order_No` tinyint(4) DEFAULT NULL,
  `Display_Text` varchar(100) DEFAULT NULL,
  `Oc` varchar(20) DEFAULT NULL,
  `Action_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Is_Sys_Acc` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`Code`),
  CONSTRAINT `FK_m_account` FOREIGN KEY (`Code`) REFERENCES `t_account_trans` (`Acc_Code`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_account` */

/*Table structure for table `m_account_category` */

DROP TABLE IF EXISTS `m_account_category`;

CREATE TABLE `m_account_category` (
  `Code` varchar(10) NOT NULL,
  `Description` varchar(100) NOT NULL,
  `oc` varchar(20) DEFAULT NULL,
  `Action_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `m_account_category` */

/*Table structure for table `m_account_type` */

DROP TABLE IF EXISTS `m_account_type`;

CREATE TABLE `m_account_type` (
  `Code` varchar(10) NOT NULL,
  `Heading` varchar(50) DEFAULT NULL,
  `Report` smallint(6) DEFAULT NULL,
  `RType` varchar(50) DEFAULT NULL,
  `Action_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Code`),
  CONSTRAINT `FK_m_account_type` FOREIGN KEY (`Code`) REFERENCES `m_account` (`Code`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_account_type` */

/*Table structure for table `m_authorization` */

DROP TABLE IF EXISTS `m_authorization`;

CREATE TABLE `m_authorization` (
  `Form_Id` varchar(20) NOT NULL,
  `Level` int(11) NOT NULL,
  `User_Role` varchar(20) DEFAULT NULL,
  `OC` varchar(20) DEFAULT NULL,
  `Action_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Form_Id`,`Level`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `m_authorization` */

/*Table structure for table `m_bank` */

DROP TABLE IF EXISTS `m_bank`;

CREATE TABLE `m_bank` (
  `Code` varchar(4) NOT NULL,
  `Description` varchar(50) NOT NULL,
  `oc` varchar(20) DEFAULT NULL,
  `Action_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_bank` */

/*Table structure for table `m_bank_branch` */

DROP TABLE IF EXISTS `m_bank_branch`;

CREATE TABLE `m_bank_branch` (
  `Bank` varchar(4) NOT NULL,
  `Code` varchar(4) NOT NULL,
  `Description` varchar(50) DEFAULT NULL,
  `Oc` varchar(20) DEFAULT NULL,
  `Action_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Bank`,`Code`),
  CONSTRAINT `FK_m_bank_branch` FOREIGN KEY (`Bank`) REFERENCES `m_bank` (`Code`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_bank_branch` */

/*Table structure for table `m_branch` */

DROP TABLE IF EXISTS `m_branch`;

CREATE TABLE `m_branch` (
  `CL` varchar(2) NOT NULL,
  `BC` varchar(3) NOT NULL,
  `Name` varchar(50) DEFAULT NULL,
  `Address` varchar(100) DEFAULT NULL,
  `TP` varchar(20) DEFAULT NULL,
  `Fax` varchar(20) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Oc` varchar(20) DEFAULT NULL,
  `Action_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`CL`,`BC`),
  CONSTRAINT `FK_m_branch` FOREIGN KEY (`CL`) REFERENCES `m_cluster` (`Code`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_branch` */

/*Table structure for table `m_cluster` */

DROP TABLE IF EXISTS `m_cluster`;

CREATE TABLE `m_cluster` (
  `Code` varchar(2) NOT NULL,
  `Description` varchar(50) NOT NULL,
  `oc` varchar(20) DEFAULT NULL,
  `Action_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_cluster` */

/*Table structure for table `m_customer` */

DROP TABLE IF EXISTS `m_customer`;

CREATE TABLE `m_customer` (
  `Code` varchar(10) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Company_Name` varchar(100) DEFAULT NULL,
  `Address1` varchar(100) DEFAULT NULL,
  `Address2` varchar(100) DEFAULT NULL,
  `Address3` varchar(100) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `DOJ` date DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `Category` varchar(4) DEFAULT NULL,
  `Area` varchar(4) DEFAULT NULL,
  `Control_Acc` varchar(10) DEFAULT NULL,
  `Credit_Limit` decimal(12,2) DEFAULT NULL,
  `Credit_Period` double DEFAULT NULL,
  `is_Tax` tinyint(4) DEFAULT '0',
  `Tax_Reg_No` varchar(20) DEFAULT NULL,
  `Inactive` tinyint(4) DEFAULT '0',
  `TP` varchar(15) DEFAULT NULL,
  `Mobile` varchar(15) DEFAULT NULL,
  `BL` tinyint(4) DEFAULT '0' COMMENT 'Black List',
  `BL_Reason` varchar(100) DEFAULT NULL,
  `BL_Officer` varchar(20) DEFAULT NULL,
  `BL_Date` date DEFAULT NULL,
  `Occupation` varchar(20) DEFAULT NULL,
  `Salary` decimal(12,2) DEFAULT NULL,
  `Nationality` varchar(20) DEFAULT NULL,
  `OC` varchar(10) DEFAULT NULL,
  `Action_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CL` varchar(2) DEFAULT NULL,
  `BC` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_customer` */

/*Table structure for table `m_customer_events` */

DROP TABLE IF EXISTS `m_customer_events`;

CREATE TABLE `m_customer_events` (
  `code` varchar(10) DEFAULT NULL,
  `Type` varchar(15) DEFAULT NULL,
  `dDate` date DEFAULT NULL,
  `Comments` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_customer_events` */

/*Table structure for table `m_employee` */

DROP TABLE IF EXISTS `m_employee`;

CREATE TABLE `m_employee` (
  `Code` varchar(10) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Address1` varchar(100) DEFAULT NULL,
  `Address2` varchar(100) DEFAULT NULL,
  `Address3` varchar(100) DEFAULT NULL,
  `TP1` varchar(15) DEFAULT NULL,
  `TP2` varchar(15) DEFAULT NULL,
  `TP3` varchar(15) DEFAULT NULL,
  `DOJ` date DEFAULT NULL,
  `Designation` varchar(10) DEFAULT NULL,
  `Oc` varchar(20) DEFAULT NULL,
  `Action_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Code`),
  KEY `FK_m_employee` (`Designation`),
  CONSTRAINT `FK_m_employee` FOREIGN KEY (`Designation`) REFERENCES `r_designation` (`Code`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_employee` */

/*Table structure for table `m_item` */

DROP TABLE IF EXISTS `m_item`;

CREATE TABLE `m_item` (
  `Code` varchar(15) NOT NULL,
  `Description` varchar(100) DEFAULT NULL,
  `Department` varchar(4) DEFAULT NULL,
  `Main_Category` varchar(4) DEFAULT NULL,
  `Category` varchar(4) DEFAULT NULL,
  `Ivactive` tinyint(4) DEFAULT '0',
  `Serial_No` tinyint(4) DEFAULT '0',
  `Batch_Item` tinyint(4) DEFAULT '0',
  `Unit` varchar(10) DEFAULT NULL,
  `Brand` varchar(10) DEFAULT NULL,
  `Model` varchar(20) DEFAULT NULL,
  `ROL` double DEFAULT '0',
  `ROQ` double DEFAULT '0',
  `Supplier` varchar(10) DEFAULT NULL,
  `Barcode` varchar(20) DEFAULT NULL,
  `Purchase_Price` decimal(12,2) DEFAULT NULL,
  `Min_Price` decimal(12,2) DEFAULT NULL,
  `Max_Price` decimal(12,2) DEFAULT NULL,
  `oc` varchar(20) DEFAULT NULL,
  `Action_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_item` */

/*Table structure for table `m_item_picture` */

DROP TABLE IF EXISTS `m_item_picture`;

CREATE TABLE `m_item_picture` (
  `Item_Code` varchar(15) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Picture` blob,
  PRIMARY KEY (`Item_Code`,`Name`),
  CONSTRAINT `FK_m_item_picture` FOREIGN KEY (`Item_Code`) REFERENCES `m_item` (`Code`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_item_picture` */

/*Table structure for table `m_item_sub` */

DROP TABLE IF EXISTS `m_item_sub`;

CREATE TABLE `m_item_sub` (
  `Item_Code` varchar(15) NOT NULL,
  `Sub_Item` varchar(4) NOT NULL,
  PRIMARY KEY (`Item_Code`,`Sub_Item`),
  CONSTRAINT `FK_m_item_sub` FOREIGN KEY (`Item_Code`) REFERENCES `m_item` (`Code`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_item_sub` */

/*Table structure for table `m_stores` */

DROP TABLE IF EXISTS `m_stores`;

CREATE TABLE `m_stores` (
  `CL` varchar(2) NOT NULL,
  `BC` varchar(3) NOT NULL,
  `Code` varchar(10) NOT NULL,
  `Description` varchar(100) DEFAULT NULL,
  `Purchase` tinyint(4) DEFAULT '0',
  `Sales` tinyint(4) DEFAULT '0',
  `Oc` varchar(20) DEFAULT NULL,
  `Action_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`CL`,`BC`,`Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_stores` */

/*Table structure for table `m_supplier` */

DROP TABLE IF EXISTS `m_supplier`;

CREATE TABLE `m_supplier` (
  `Code` varchar(10) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Contact_Name` varchar(100) DEFAULT NULL,
  `Payee_Name` varchar(100) DEFAULT NULL,
  `Category` varchar(10) DEFAULT NULL,
  `Address1` varchar(100) DEFAULT NULL,
  `Address2` varchar(100) DEFAULT NULL,
  `Address3` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `DOJ` date DEFAULT NULL,
  `Control_Acc` varchar(100) DEFAULT NULL,
  `Credit_Limit` decimal(12,2) DEFAULT NULL,
  `Credit_Period` int(11) DEFAULT NULL,
  `Is_Tax` tinyint(4) DEFAULT '0',
  `Tax_Reg_No` varchar(20) DEFAULT NULL,
  `Oc` varchar(20) DEFAULT NULL,
  `Action_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Code`),
  KEY `FK_m_supplier` (`Category`),
  CONSTRAINT `FK_m_supplier` FOREIGN KEY (`Category`) REFERENCES `r_sup_category` (`Code`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_supplier` */

/*Table structure for table `m_supplier_comment` */

DROP TABLE IF EXISTS `m_supplier_comment`;

CREATE TABLE `m_supplier_comment` (
  `Code` varchar(10) DEFAULT NULL,
  `dDate` date DEFAULT NULL,
  `Comment` varchar(100) DEFAULT NULL,
  KEY `FK_m_supplier_comment` (`Code`),
  CONSTRAINT `FK_m_supplier_comment` FOREIGN KEY (`Code`) REFERENCES `m_supplier` (`Code`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_supplier_comment` */

/*Table structure for table `m_supplier_contact` */

DROP TABLE IF EXISTS `m_supplier_contact`;

CREATE TABLE `m_supplier_contact` (
  `Code` varchar(10) NOT NULL,
  `Type` varchar(15) NOT NULL,
  `TP` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`Code`,`Type`),
  CONSTRAINT `FK_m_supplier_contact` FOREIGN KEY (`Code`) REFERENCES `m_supplier` (`Code`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_supplier_contact` */

/*Table structure for table `r_additional_item` */

DROP TABLE IF EXISTS `r_additional_item`;

CREATE TABLE `r_additional_item` (
  `Code` varchar(5) NOT NULL,
  `Description` varchar(50) DEFAULT NULL,
  `Rate` double DEFAULT NULL,
  `is_Add` bit(1) DEFAULT NULL,
  `Oc` varchar(20) DEFAULT NULL,
  `Action_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `r_additional_item` */

/*Table structure for table `r_area` */

DROP TABLE IF EXISTS `r_area`;

CREATE TABLE `r_area` (
  `Code` varchar(4) NOT NULL,
  `Description` varchar(50) NOT NULL,
  `oc` varchar(20) DEFAULT NULL,
  `Action_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `r_area` */

/*Table structure for table `r_brand` */

DROP TABLE IF EXISTS `r_brand`;

CREATE TABLE `r_brand` (
  `Code` varchar(4) NOT NULL,
  `Description` varchar(50) NOT NULL,
  `oc` varchar(20) DEFAULT NULL,
  `Action_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `r_brand` */

/*Table structure for table `r_category` */

DROP TABLE IF EXISTS `r_category`;

CREATE TABLE `r_category` (
  `Code` varchar(4) NOT NULL,
  `Description` varchar(50) NOT NULL,
  `oc` varchar(20) DEFAULT NULL,
  `Action_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Code`),
  CONSTRAINT `FK_r_category` FOREIGN KEY (`Code`) REFERENCES `m_item` (`Code`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `r_category` */

/*Table structure for table `r_cus_category` */

DROP TABLE IF EXISTS `r_cus_category`;

CREATE TABLE `r_cus_category` (
  `Code` varchar(4) NOT NULL,
  `Description` varchar(50) NOT NULL,
  `oc` varchar(20) DEFAULT NULL,
  `Action_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `r_cus_category` */

/*Table structure for table `r_department` */

DROP TABLE IF EXISTS `r_department`;

CREATE TABLE `r_department` (
  `Code` varchar(4) NOT NULL,
  `Description` varchar(50) DEFAULT NULL,
  `Pv_Card_Rate` double DEFAULT NULL,
  `oc` varchar(20) DEFAULT NULL,
  `Action_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Code`),
  CONSTRAINT `FK_r_department` FOREIGN KEY (`Code`) REFERENCES `m_item` (`Code`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `r_department` */

/*Table structure for table `r_designation` */

DROP TABLE IF EXISTS `r_designation`;

CREATE TABLE `r_designation` (
  `Code` varchar(10) NOT NULL,
  `Description` varchar(100) NOT NULL,
  `oc` varchar(20) DEFAULT NULL,
  `Action_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `r_designation` */

/*Table structure for table `r_groups` */

DROP TABLE IF EXISTS `r_groups`;

CREATE TABLE `r_groups` (
  `Code` varchar(10) NOT NULL,
  `Name` varchar(50) DEFAULT NULL,
  `dDate` date DEFAULT NULL,
  `Officer` varchar(50) DEFAULT NULL,
  `Oc` varchar(20) DEFAULT NULL,
  `Action_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `r_groups` */

/*Table structure for table `r_sub_category` */

DROP TABLE IF EXISTS `r_sub_category`;

CREATE TABLE `r_sub_category` (
  `Main_Category` varchar(4) NOT NULL,
  `Code` varchar(4) NOT NULL,
  `Description` varchar(50) NOT NULL,
  `oc` varchar(20) DEFAULT NULL,
  `Action_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `r_sub_category` */

/*Table structure for table `r_sub_item` */

DROP TABLE IF EXISTS `r_sub_item`;

CREATE TABLE `r_sub_item` (
  `Code` varchar(4) NOT NULL,
  `Description` varchar(50) NOT NULL,
  `oc` varchar(20) DEFAULT NULL,
  `Action_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `r_sub_item` */

/*Table structure for table `r_sup_category` */

DROP TABLE IF EXISTS `r_sup_category`;

CREATE TABLE `r_sup_category` (
  `Code` varchar(4) NOT NULL,
  `Description` varchar(50) NOT NULL,
  `oc` varchar(20) DEFAULT NULL,
  `Action_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `r_sup_category` */

/*Table structure for table `r_unit` */

DROP TABLE IF EXISTS `r_unit`;

CREATE TABLE `r_unit` (
  `Code` varchar(4) NOT NULL,
  `Description` varchar(50) NOT NULL,
  `oc` varchar(20) DEFAULT NULL,
  `Action_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `r_unit` */

/*Table structure for table `t_account_trans` */

DROP TABLE IF EXISTS `t_account_trans`;

CREATE TABLE `t_account_trans` (
  `CL` varchar(2) DEFAULT NULL,
  `BC` varchar(3) DEFAULT NULL,
  `dDate` date DEFAULT NULL,
  `Trans_Code` varchar(10) DEFAULT NULL,
  `Trans_No` decimal(12,0) DEFAULT NULL,
  `Acc_Code` varchar(10) DEFAULT NULL,
  `Description` varchar(100) DEFAULT NULL,
  `Dr_Amount` decimal(12,2) DEFAULT NULL,
  `Cr_Amount` decimal(12,2) DEFAULT NULL,
  `Op_Acc` varchar(10) DEFAULT NULL,
  `Reconcile` tinyint(4) DEFAULT '0',
  `oc` varchar(20) DEFAULT NULL,
  `Action_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Ref_No` varchar(10) DEFAULT NULL,
  `Cheque_No` varchar(100) DEFAULT NULL,
  `is_Control_Acc` tinyint(4) DEFAULT '0',
  `Narration` varchar(100) DEFAULT NULL,
  KEY `NewIndex1` (`Acc_Code`),
  KEY `my_Acc_Index_Branch` (`CL`,`BC`,`Acc_Code`,`dDate`),
  CONSTRAINT `FK_t_account_trans` FOREIGN KEY (`CL`, `BC`) REFERENCES `m_branch` (`CL`, `BC`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_account_trans` */

/*Table structure for table `t_authorization` */

DROP TABLE IF EXISTS `t_authorization`;

CREATE TABLE `t_authorization` (
  `CL` varchar(2) NOT NULL,
  `BC` varchar(3) NOT NULL,
  `Form_Id` varchar(20) DEFAULT NULL,
  `Trans_Code` varchar(20) DEFAULT NULL,
  `Trans_No` decimal(10,0) DEFAULT NULL,
  `Level` int(11) DEFAULT NULL,
  `User_Role` varchar(20) DEFAULT NULL,
  `OC` varchar(20) DEFAULT NULL,
  `Action_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `User_Id` varchar(20) DEFAULT NULL,
  `Approve` tinyint(4) DEFAULT '0',
  `Reject` tinyint(4) DEFAULT '0',
  `Approve_Time` datetime DEFAULT NULL,
  `Memo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_authorization` */

/*Table structure for table `t_reg_sum` */

DROP TABLE IF EXISTS `t_reg_sum`;

CREATE TABLE `t_reg_sum` (
  `CL` varchar(2) NOT NULL,
  `BC` varchar(3) NOT NULL,
  `nNo` decimal(10,0) NOT NULL,
  `dDate` date DEFAULT NULL,
  `Ref_No` varchar(20) DEFAULT NULL,
  `Supplier` varchar(10) NOT NULL,
  `Comment` varchar(100) DEFAULT NULL,
  `OC` varchar(10) DEFAULT NULL,
  `Action_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Approved` tinyint(4) DEFAULT '0',
  `Approved_By` varchar(20) DEFAULT NULL,
  `Approved_Date` datetime DEFAULT NULL,
  `Orderd` tinyint(4) DEFAULT '0',
  `Orderd_No` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`CL`,`BC`,`nNo`),
  KEY `FK_t_reg_sum` (`Supplier`),
  CONSTRAINT `FK_t_reg_sum` FOREIGN KEY (`Supplier`) REFERENCES `m_supplier` (`Code`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_reg_sum` */

/*Table structure for table `t_req_det` */

DROP TABLE IF EXISTS `t_req_det`;

CREATE TABLE `t_req_det` (
  `CL` varchar(2) DEFAULT NULL,
  `BC` varchar(3) DEFAULT NULL,
  `nNo` decimal(10,0) DEFAULT NULL,
  `Item` varchar(15) DEFAULT NULL,
  `Cur_Qty` decimal(12,2) DEFAULT NULL,
  `ROL` decimal(10,0) DEFAULT NULL,
  `ROQ` decimal(10,0) DEFAULT NULL,
  `Week1` decimal(10,0) DEFAULT NULL,
  `Week2` decimal(10,0) DEFAULT NULL,
  `Week3` decimal(10,0) DEFAULT NULL,
  `Week4` decimal(10,0) DEFAULT NULL,
  `Approve_Qty` decimal(10,0) DEFAULT NULL,
  `Supplier` varchar(10) DEFAULT NULL,
  `Comment` varchar(100) DEFAULT NULL,
  KEY `FK_t_req_det` (`CL`,`BC`,`nNo`),
  CONSTRAINT `FK_t_req_det` FOREIGN KEY (`CL`, `BC`, `nNo`) REFERENCES `t_reg_sum` (`CL`, `BC`, `nNo`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_req_det` */

/*Table structure for table `u_add_role` */

DROP TABLE IF EXISTS `u_add_role`;

CREATE TABLE `u_add_role` (
  `user_code` smallint(6) NOT NULL,
  `role_code` varchar(15) NOT NULL,
  `from_date` date DEFAULT '0000-00-00',
  `to_date` date DEFAULT '0000-00-00',
  PRIMARY KEY (`user_code`,`role_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `u_add_role` */

/*Table structure for table `u_module` */

DROP TABLE IF EXISTS `u_module`;

CREATE TABLE `u_module` (
  `code` varchar(50) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `type` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `u_module` */

/*Table structure for table `u_permission` */

DROP TABLE IF EXISTS `u_permission`;

CREATE TABLE `u_permission` (
  `user_code` varchar(15) NOT NULL,
  `module_code` varchar(50) NOT NULL,
  `is_view` tinyint(1) DEFAULT '0',
  `is_add` tinyint(1) DEFAULT '0',
  `is_edit` tinyint(1) DEFAULT '0',
  `is_delete` tinyint(1) DEFAULT '0',
  `is_print` tinyint(1) DEFAULT '0',
  `is_re_print` tinyint(1) DEFAULT '0',
  `is_back_date` tinyint(1) DEFAULT '0',
  `is_auth` tinyint(1) DEFAULT '0',
  `is_accept` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`user_code`,`module_code`),
  KEY `module_code` (`module_code`)
) ENGINE=MEMORY DEFAULT CHARSET=latin1;

/*Data for the table `u_permission` */

/*Table structure for table `u_role` */

DROP TABLE IF EXISTS `u_role`;

CREATE TABLE `u_role` (
  `code` varchar(15) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `u_role` */

/*Table structure for table `u_role_permission` */

DROP TABLE IF EXISTS `u_role_permission`;

CREATE TABLE `u_role_permission` (
  `role_code` varchar(15) NOT NULL,
  `module_code` varchar(50) NOT NULL,
  `is_view` tinyint(1) DEFAULT '0',
  `is_add` tinyint(1) DEFAULT '0',
  `is_edit` tinyint(1) DEFAULT '0',
  `is_delete` tinyint(1) DEFAULT '0',
  `is_print` tinyint(1) DEFAULT '0',
  `is_re_print` tinyint(1) DEFAULT '0',
  `is_back_date` tinyint(1) DEFAULT '0',
  `is_auth` tinyint(1) DEFAULT '0',
  `is_accept` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`role_code`,`module_code`),
  KEY `module_code` (`module_code`),
  CONSTRAINT `u_role_permission_ibfk_1` FOREIGN KEY (`role_code`) REFERENCES `u_role` (`code`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `u_role_permission_ibfk_3` FOREIGN KEY (`module_code`) REFERENCES `u_module` (`code`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `u_role_permission` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
