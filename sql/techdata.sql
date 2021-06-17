/* date 07-01-2018 */
ALTER TABLE apct_web_firm RENAME TO mgsr_user;

ALTER TABLE mgsr_user ADD column `Value` `Name` varchar(255) AFTER `ID`;
ALTER TABLE mgsr_user ADD column `ContactPersonName` `FatherName` varchar(255) AFTER `Name`;



ALTER TABLE mgsr_user DROP FOREIGN KEY `apct_web_firm_PaymentMethodID_ibfk_12`;
ALTER TABLE mgsr_user DROP FOREIGN KEY `apct_web_firm_PriorityID_ibfk_11`;

ALTER TABLE mgsr_user DROP KEY `apct_web_firm_PaymentMethodID_index12`;
ALTER TABLE mgsr_user DROP KEY `apct_web_firm_PriorityID_index11`;

ALTER TABLE mgsr_user DROP COLUMN `PaymentMethodID`;
ALTER TABLE mgsr_user DROP COLUMN `PriorityID`;


CREATE TABLE `mgsr_status` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `StatusName` varchar(50) DEFAULT NULL,
  `CreatedAt` datetime NOT NULL,
  `CreatedBy` int(11) unsigned NOT NULL,
  `UpdatedAt` datetime NOT NULL,
  `UpdatedBy` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `mgsr_status_CreatedBy_index_1` (`CreatedBy`) USING BTREE,
  KEY `mgsr_status_UpdatedBy_index_2` (`UpdatedBy`) USING BTREE,
  CONSTRAINT `mgsr_status_CreatedBy_ibfk_1` FOREIGN KEY (`CreatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_status_UpdatedBy_ibfk_2` FOREIGN KEY (`UpdatedBy`) REFERENCES `admin_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into `mgsr_status` values(1, 'Active', now(), 1, now(), 1);
insert into `mgsr_status` values(2, 'In-Active', now(), 1, now(), 1);


CREATE TABLE `mgsr_donation_status` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `StatusName` varchar(50) DEFAULT NULL,
  `StatusID` int(11) unsigned DEFAULT NULL,
  `CreatedAt` datetime NOT NULL,
  `CreatedBy` int(11) unsigned NOT NULL,
  `UpdatedAt` datetime NOT NULL,
  `UpdatedBy` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `mgsr_donation_status_CreatedBy_index_1` (`CreatedBy`) USING BTREE,
  KEY `mgsr_donation_status_UpdatedBy_index_2` (`UpdatedBy`) USING BTREE,
  KEY `mgsr_donation_status_StatusID_index_3` (`StatusID`) USING BTREE,
  CONSTRAINT `mgsr_donation_status_CreatedBy_ibfk_1` FOREIGN KEY (`CreatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_donation_status_UpdatedBy_ibfk_2` FOREIGN KEY (`UpdatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_donation_status_StatusID_ibfk_3` FOREIGN KEY (`StatusID`) REFERENCES `mgsr_status` (`ID`)  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into `mgsr_donation_status` values (1, 'Paid', 1, now(), 1, now(), 1);
insert into `mgsr_donation_status` values (2, 'UnPaid', 1, now(), 1, now(), 1);


CREATE TABLE `mgsr_donation_type` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `TypeName` varchar(50) DEFAULT NULL,
  `TypeImage` varchar(100) DEFAULT NULL,
  `StatusID` int(11) unsigned DEFAULT NULL,
  `CreatedAt` datetime NOT NULL,
  `CreatedBy` int(11) unsigned NOT NULL,
  `UpdatedAt` datetime NOT NULL,
  `UpdatedBy` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `mgsr_donation_type_CreatedBy_index_1` (`CreatedBy`) USING BTREE,
  KEY `mgsr_donation_type_UpdatedBy_index_2` (`UpdatedBy`) USING BTREE,
  KEY `mgsr_donation_type_StatusID_index_3` (`StatusID`) USING BTREE,
  CONSTRAINT `mgsr_donation_type_CreatedBy_ibfk_1` FOREIGN KEY (`CreatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_donation_type_UpdatedBy_ibfk_2` FOREIGN KEY (`UpdatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_donation_type_StatusID_ibfk_3` FOREIGN KEY (`StatusID`) REFERENCES `mgsr_status` (`ID`)  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


insert into `mgsr_donation_type` values (1, 'Cash With Receipt', 'mgsr/common/images/donationtype/cash_with_receipt.png', 1, now(), 1, now(), 1);
insert into `mgsr_donation_type` values (2, 'Cash Without Receipt', 'mgsr/common/images/donationtype/cash_without_receipt.png', 1, now(), 1, now(), 1);
insert into `mgsr_donation_type` values (3, 'Gas Cylinder', 'mgsr/common/images/donationtype/gas_cylinder.png', 1, now(), 1, now(), 1);
insert into `mgsr_donation_type` values (4, 'Sound System', 'mgsr/common/images/donationtype/sound_system.png', 1, now(), 1, now(), 1);
insert into `mgsr_donation_type` values (5, 'Flour', 'mgsr/common/images/donationtype/flour.png', 1, now(), 1, now(), 1);
insert into `mgsr_donation_type` values (6, 'Pulse', 'mgsr/common/images/donationtype/pulse.png', 1, now(), 1, now(), 1);
insert into `mgsr_donation_type` values (7, 'Vegetable', 'mgsr/common/images/donationtype/vegetable.png', 1, now(), 1, now(), 1);
insert into `mgsr_donation_type` values (8, 'Spices', 'mgsr/common/images/donationtype/spices.png', 1, now(), 1, now(), 1);
insert into `mgsr_donation_type` values (9, 'Water Camper', 'mgsr/common/images/donationtype/water_camper.png', 1, now(), 1, now(), 1);
insert into `mgsr_donation_type` values (10, 'Tea', 'mgsr/common/images/donationtype/tea.png', 1, now(), 1, now(), 1);
insert into `mgsr_donation_type` values (11, 'Butter', 'mgsr/common/images/donationtype/butter.png', 1, now(), 1, now(), 1);
insert into `mgsr_donation_type` values (12, 'Media', 'mgsr/common/images/donationtype/media.png', 1, now(), 1, now(), 1);



CREATE TABLE `mgsr_receipt_book_status` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `StatusName` varchar(50) DEFAULT NULL,
  `StatusID` int(11) unsigned DEFAULT NULL,
  `CreatedAt` datetime NOT NULL,
  `CreatedBy` int(11) unsigned NOT NULL,
  `UpdatedAt` datetime NOT NULL,
  `UpdatedBy` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `mgsr_receipt_book_status_CreatedBy_index_1` (`CreatedBy`) USING BTREE,
  KEY `mgsr_receipt_book_status_UpdatedBy_index_2` (`UpdatedBy`) USING BTREE,
  KEY `mgsr_receipt_book_status_StatusID_index_3` (`StatusID`) USING BTREE,
  CONSTRAINT `mgsr_receipt_book_status_CreatedBy_ibfk_1` FOREIGN KEY (`CreatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_receipt_book_status_UpdatedBy_ibfk_2` FOREIGN KEY (`UpdatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_receipt_book_status_StatusID_ibfk_3` FOREIGN KEY (`StatusID`) REFERENCES `mgsr_status` (`ID`)  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


insert into `mgsr_receipt_book_status` values (1, 'Open', 1, now(), 1, now(), 1);
insert into `mgsr_receipt_book_status` values (2, 'Close', 1, now(), 1, now(), 1);


CREATE TABLE `mgsr_receipt_book` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `BookName` varchar(50) DEFAULT NULL,
  `TotalAmount` decimal(12,2) DEFAULT NULL,
  `Description` varchar(200) DEFAULT NULL,
  `StatusID` int(11) unsigned DEFAULT NULL,
  `CreatedAt` datetime NOT NULL,
  `CreatedBy` int(11) unsigned NOT NULL,
  `UpdatedAt` datetime NOT NULL,
  `UpdatedBy` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `mgsr_receipt_book_CreatedBy_index_1` (`CreatedBy`) USING BTREE,
  KEY `mgsr_receipt_book_UpdatedBy_index_2` (`UpdatedBy`) USING BTREE,
  KEY `mgsr_receipt_book_StatusID_index_3` (`StatusID`) USING BTREE,
  CONSTRAINT `mgsr_receipt_book_CreatedBy_ibfk_1` FOREIGN KEY (`CreatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_receipt_book_UpdatedBy_ibfk_2` FOREIGN KEY (`UpdatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_receipt_book_StatusID_ibfk_3` FOREIGN KEY (`StatusID`) REFERENCES `mgsr_receipt_book_status` (`ID`)  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


insert into `mgsr_receipt_book` values (1, '3201-3300', null, null, 1, now(), 1, now(), 1);
insert into `mgsr_receipt_book` values (2, '3601-3700', null, null, 1, now(), 1, now(), 1);
insert into `mgsr_receipt_book` values (3, '3701-3800', null, null, 1, now(), 1, now(), 1);
insert into `mgsr_receipt_book` values (4, '3801-3900', null, null, 1, now(), 1, now(), 1);
insert into `mgsr_receipt_book` values (5, '4101-4200', null, null, 1, now(), 1, now(), 1);
insert into `mgsr_receipt_book` values (6, '4201-4300', null, null, 1, now(), 1, now(), 1);
insert into `mgsr_receipt_book` values (7, '4301-4400', null, null, 1, now(), 1, now(), 1);
insert into `mgsr_receipt_book` values (8, '4401-4500', null, null, 1, now(), 1, now(), 1);
insert into `mgsr_receipt_book` values (9, '4501-4600', null, null, 1, now(), 1, now(), 1);
insert into `mgsr_receipt_book` values (10, '4601-4700', null, null, 1, now(), 1, now(), 1);



CREATE TABLE `mgsr_donation` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `UserID` int(11) unsigned NOT NULL,
  `DonationTypeID` int(11) unsigned NOT NULL,
  `ReceiptBookID` int(11) unsigned DEFAULT NULL,
  `ReceiptNumber` varchar(50) DEFAULT NULL,
  `DonatedAmount` decimal(12,2) DEFAULT NULL,
  `DonationYear` int(11) DEFAULT NULL,
  `DonationDate` date DEFAULT NULL,
  `DonationTime` time DEFAULT NULL,
  `Description` varchar(200) DEFAULT NULL,
  `StatusID` int(11) unsigned DEFAULT NULL,
  `CreatedAt` datetime NOT NULL,
  `CreatedBy` int(11) unsigned NOT NULL,
  `UpdatedAt` datetime NOT NULL,
  `UpdatedBy` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `mgsr_donation_CreatedBy_index_1` (`CreatedBy`) USING BTREE,
  KEY `mgsr_donation_UpdatedBy_index_2` (`UpdatedBy`) USING BTREE,
  KEY `mgsr_donation_StatusID_index_3` (`StatusID`) USING BTREE,
  KEY `mgsr_donation_DonationTypeID_index_4` (`DonationTypeID`) USING BTREE,
  KEY `mgsr_donation_ReceiptBookID_index_5` (`ReceiptBookID`) USING BTREE,
  CONSTRAINT `mgsr_donation_CreatedBy_ibfk_1` FOREIGN KEY (`CreatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_donation_UpdatedBy_ibfk_2` FOREIGN KEY (`UpdatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_donation_StatusID_ibfk_3` FOREIGN KEY (`StatusID`) REFERENCES `mgsr_donation_status` (`ID`),
  CONSTRAINT `mgsr_donation_DonationTypeID_ibfk_4` FOREIGN KEY (`DonationTypeID`) REFERENCES `mgsr_donation_type` (`ID`),
  CONSTRAINT `mgsr_donation_ReceiptBookID_ibfk_5` FOREIGN KEY (`ReceiptBookID`) REFERENCES `mgsr_receipt_book` (`ID`)  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into mgsr_donation values(1, 14, 3, null, null, null, 2018, '2018-12-30', null, 'provide gas cylinder for lunch', 1, now(), 1, now(), 1);
insert into mgsr_donation values(2, 15, 4, null, null, null, 2018, '2018-12-30', null, 'pay 1000 rs rent for sound system', 1, now(), 1, now(), 1);
insert into mgsr_donation values(3, 10, 5, null, null, null, 2018, '2018-12-30', null, 'provide flour for lunch', 1, now(), 1, now(), 1);
insert into mgsr_donation values(4, 4, 6, null, null, null, 2018, '2018-12-30', null, 'provide flour for lunch', 1, now(), 1, now(), 1);
insert into mgsr_donation values(5, 12, 7, null, null, null, 2018, '2018-12-30', null, 'provide vegetable for lunch', 1, now(), 1, now(), 1);
insert into mgsr_donation values(6, 6, 8, null, null, null, 2018, '2018-12-30', null, 'provide spices for lunch', 1, now(), 1, now(), 1);
insert into mgsr_donation values(7, 16, 9, null, null, null, 2018, '2018-12-30', null, 'provide water camper for lunch', 1, now(), 1, now(), 1);
insert into mgsr_donation values(8, 24, 10, null, null, null, 2018, '2018-12-30', null, 'pay 500 rs for tea', 1, now(), 1, now(), 1);
insert into mgsr_donation values(9, 25, 11, null, null, null, 2018, '2018-12-30', null, 'provide butter camper for lunch', 1, now(), 1, now(), 1);
insert into mgsr_donation values(10, 26, 2, null, null, null, 2018, '2018-12-30', null, 'cash', 1, now(), 1, now(), 1);
insert into mgsr_donation values(11, 5, 2, null, null, null, 2018, '2018-12-30', null, '1000 rs cash', 1, now(), 1, now(), 1);
insert into mgsr_donation values(12, 27, 2, null, null, null, 2018, '2018-12-30', null, '2100 rs cash', 1, now(), 1, now(), 1);
insert into mgsr_donation values(13, 28, 2, null, null, 1000, 2018, '2018-12-30', null, '1000 rs cash', 1, now(), 1, now(), 1);
insert into mgsr_donation values(14, 4, 2, null, null, 3000, 2018, '2018-12-30', null, '3000 rs cash', 1, now(), 1, now(), 1);
insert into mgsr_donation values(15, 1, 12, null, null, 3000, 2018, '2018-12-30', null, 'media partner', 1, now(), 1, now(), 1);
insert into mgsr_donation values(29, 29, 12, null, null, 3000, 2018, '2018-12-30', null, 'media partner', 1, now(), 1, now(), 1);

ALTER TABLE mgsr_user ADD column `UserImageURL` varchar(255) AFTER `FatherName`;

update mgsr_user set userimageurl = 'mgsr/common/images/user/01.png' where id = 1;
update mgsr_user set userimageurl = 'mgsr/common/images/user/5.png' where id = 5;
update mgsr_user set userimageurl = 'mgsr/common/images/user/26.png' where id = 26;
update mgsr_user set userimageurl = 'mgsr/common/images/user/16.png' where id = 16;
update mgsr_user set userimageurl = 'mgsr/common/images/user/10.png' where id = 10;





CREATE TABLE `mgsr_country_list` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Code` varchar(100) NOT NULL,
  `Value` varchar(100) NOT NULL,
  `StatusID` int(11) unsigned NOT NULL,
  `CreatedAt` datetime NOT NULL,
  `CreatedBy` int(11) unsigned NOT NULL,
  `UpdatedAt` datetime NOT NULL,
  `UpdatedBy` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `mgsr_country_list_StatusID_index1` (`StatusID`) USING BTREE,
  KEY `mgsr_country_list_CreatedBy_index2` (`CreatedBy`) USING BTREE,
  KEY `mgsr_country_list_UpdatedBy_index3` (`UpdatedBy`) USING BTREE,
  CONSTRAINT `mgsr_country_list_CreatedBy_ibfk_2` FOREIGN KEY (`CreatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_country_list_StatusID_ibfk_1` FOREIGN KEY (`StatusID`) REFERENCES `mgsr_status` (`ID`),
  CONSTRAINT `mgsr_country_list_UpdatedBy_ibfk_3` FOREIGN KEY (`UpdatedBy`) REFERENCES `admin_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
insert into `mgsr_country_list` values (1, 'IN', 'INDIA', 1, now(), 1, now(), 1);


CREATE TABLE `mgsr_state_list` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Code` varchar(100) NOT NULL,
  `Value` varchar(100) NOT NULL,
  `CountryID` int(11) unsigned NOT NULL,
  `StatusID` int(11) unsigned NOT NULL,
  `CreatedAt` datetime NOT NULL,
  `CreatedBy` int(11) unsigned NOT NULL,
  `UpdatedAt` datetime NOT NULL,
  `UpdatedBy` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `mgsr_state_list_CountryID_index1` (`CountryID`) USING BTREE,
  KEY `mgsr_state_list_StatusID_index2` (`StatusID`) USING BTREE,
  KEY `mgsr_state_list_CreatedBy_index3` (`CreatedBy`) USING BTREE,
  KEY `mgsr_state_list_UpdatedBy_index4` (`UpdatedBy`) USING BTREE,
  CONSTRAINT `mgsr_state_list_CountryID_ibfk_1` FOREIGN KEY (`CountryID`) REFERENCES `mgsr_country_list` (`ID`),
  CONSTRAINT `mgsr_state_list_CreatedBy_ibfk_3` FOREIGN KEY (`CreatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_state_list_StatusID_ibfk_2` FOREIGN KEY (`StatusID`) REFERENCES `mgsr_status` (`ID`),
  CONSTRAINT `mgsr_state_list_UpdatedBy_ibfk_4` FOREIGN KEY (`UpdatedBy`) REFERENCES `admin_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
insert into `mgsr_state_list` values (29, 'RJ', 'RAJASTHAN', 1, 1, now(), 1, now(), 1);



CREATE TABLE `mgsr_district_list` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Code` varchar(100) NOT NULL,
  `Value` varchar(100) NOT NULL,
  `StateID` int(11) unsigned NOT NULL,
  `StatusID` int(11) unsigned NOT NULL,
  `CreatedAt` datetime NOT NULL,
  `CreatedBy` int(11) unsigned NOT NULL,
  `UpdatedAt` datetime NOT NULL,
  `UpdatedBy` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `mgsr_district_list_StateID_index1` (`StateID`) USING BTREE,
  KEY `mgsr_district_list_StatusID_index2` (`StatusID`) USING BTREE,
  KEY `mgsr_district_list_CreatedBy_index3` (`CreatedBy`) USING BTREE,
  KEY `mgsr_district_list_UpdatedBy_index4` (`UpdatedBy`) USING BTREE,
  CONSTRAINT `mgsr_district_list_CreatedBy_ibfk_3` FOREIGN KEY (`CreatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_district_list_StateID_ibfk_1` FOREIGN KEY (`StateID`) REFERENCES `mgsr_state_list` (`ID`),
  CONSTRAINT `mgsr_district_list_StatusID_ibfk_2` FOREIGN KEY (`StatusID`) REFERENCES `mgsr_status` (`ID`),
  CONSTRAINT `mgsr_district_list_UpdatedBy_ibfk_4` FOREIGN KEY (`UpdatedBy`) REFERENCES `admin_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
insert into `mgsr_district_list` values (31, 'SGNR', 'Sri Ganganagar', 29, 1, now(), 1, now(), 1);


CREATE TABLE `mgsr_city_list` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Code` varchar(100) DEFAULT NULL,
  `Value` varchar(100) NOT NULL,
  `DistrictID` int(11) unsigned NOT NULL,
  `StatusID` int(11) unsigned NOT NULL,
  `CreatedAt` datetime NOT NULL,
  `CreatedBy` int(11) unsigned NOT NULL,
  `UpdatedAt` datetime NOT NULL,
  `UpdatedBy` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `mgsr_city_list_DistrictID_index1` (`DistrictID`) USING BTREE,
  KEY `mgsr_city_list_StatusID_index2` (`StatusID`) USING BTREE,
  KEY `mgsr_city_list_CreatedBy_index3` (`CreatedBy`) USING BTREE,
  KEY `mgsr_city_list_UpdatedBy_index4` (`UpdatedBy`) USING BTREE,
  CONSTRAINT `mgsr_city_list_CreatedBy_ibfk_3` FOREIGN KEY (`CreatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_city_list_DistrictID_ibfk_1` FOREIGN KEY (`DistrictID`) REFERENCES `mgsr_district_list` (`ID`),
  CONSTRAINT `mgsr_city_list_StatusID_ibfk_2` FOREIGN KEY (`StatusID`) REFERENCES `mgsr_status` (`ID`),
  CONSTRAINT `mgsr_city_list_UpdatedBy_ibfk_4` FOREIGN KEY (`UpdatedBy`) REFERENCES `admin_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
insert into `mgsr_city_list` values (1, 'SGNR', 'Ganganagar', 31, 1, now(), 1, now(), 1);

CREATE TABLE `mgsr_area_list` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Code` varchar(100) DEFAULT NULL,
  `Value` varchar(100) NOT NULL,
  `CityID` int(11) unsigned NOT NULL,
  `StatusID` int(11) unsigned NOT NULL,
  `CreatedAt` datetime NOT NULL,
  `CreatedBy` int(11) unsigned NOT NULL,
  `UpdatedAt` datetime NOT NULL,
  `UpdatedBy` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `mgsr_area_list_CityID_index1` (`CityID`) USING BTREE,
  KEY `mgsr_area_list_StatusID_index2` (`StatusID`) USING BTREE,
  KEY `mgsr_area_list_CreatedBy_index3` (`CreatedBy`) USING BTREE,
  KEY `mgsr_area_list_UpdatedBy_index4` (`UpdatedBy`) USING BTREE,
  CONSTRAINT `mgsr_area_list_CityID_ibfk_1` FOREIGN KEY (`CityID`) REFERENCES `mgsr_city_list` (`ID`),
  CONSTRAINT `mgsr_area_list_CreatedBy_ibfk_3` FOREIGN KEY (`CreatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_area_list_StatusID_ibfk_2` FOREIGN KEY (`StatusID`) REFERENCES `mgsr_status` (`ID`),
  CONSTRAINT `mgsr_area_list_UpdatedBy_ibfk_4` FOREIGN KEY (`UpdatedBy`) REFERENCES `admin_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into `mgsr_area_list` values (1, '6e', '6 E Chhoti - Nehra Nagar', 1, 1, now(), 1, now(), 1);
insert into `mgsr_area_list` values (2, '3e', '3 E Chhoti - Shiv Nagar', 1, 1, now(), 1, now(), 1);
insert into `mgsr_area_list` values (3, '2e', '2 E Chhoti', 1, 1, now(), 1, now(), 1);
insert into `mgsr_area_list` values (4, '17ml', '17 ML - Bhatta Colony', 1, 1, now(), 1, now(), 1);




/* date 16 jan 2019 */
CREATE TABLE `mgsr_programme_type` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `TypeName` varchar(50) DEFAULT NULL,
  `StatusID` int(11) unsigned DEFAULT NULL,
  `CreatedAt` datetime NOT NULL,
  `CreatedBy` int(11) unsigned NOT NULL,
  `UpdatedAt` datetime NOT NULL,
  `UpdatedBy` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `mgsr_programme_type_CreatedBy_index_1` (`CreatedBy`) USING BTREE,
  KEY `mgsr_programme_type_UpdatedBy_index_2` (`UpdatedBy`) USING BTREE,
  KEY `mgsr_programme_type_StatusID_index_3` (`StatusID`) USING BTREE,
  CONSTRAINT `mgsr_programme_type_CreatedBy_ibfk_1` FOREIGN KEY (`CreatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_programme_type_UpdatedBy_ibfk_2` FOREIGN KEY (`UpdatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_programme_type_StatusID_ibfk_3` FOREIGN KEY (`StatusID`) REFERENCES `mgsr_status` (`ID`)  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


insert into `mgsr_programme_type` values (1, 'Buddh Purnima', 1, now(), 1, now(), 1);
insert into `mgsr_programme_type` values (2, 'Saneh Milan', 1, now(), 1, now(), 1);
insert into `mgsr_programme_type` values (3, 'Pratibha Samman', 1, now(), 1, now(), 1);


CREATE TABLE `mgsr_programme` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ProgrammeName` varchar(100) DEFAULT NULL,
  `TypeID` int(11) unsigned DEFAULT NULL,
  `CreatedAt` datetime NOT NULL,
  `CreatedBy` int(11) unsigned NOT NULL,
  `UpdatedAt` datetime NOT NULL,
  `UpdatedBy` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `mgsr_programme_CreatedBy_index_1` (`CreatedBy`) USING BTREE,
  KEY `mgsr_programme_UpdatedBy_index_2` (`UpdatedBy`) USING BTREE,
  KEY `mgsr_programme_TypeID_index_3` (`TypeID`) USING BTREE,
  CONSTRAINT `mgsr_programme_CreatedBy_ibfk_1` FOREIGN KEY (`CreatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_programme_UpdatedBy_ibfk_2` FOREIGN KEY (`UpdatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_programme_TypeID_ibfk_3` FOREIGN KEY (`TypeID`) REFERENCES `mgsr_programme_type` (`ID`)  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE mgsr_donation ADD column `ProgrammeID` int(11) unsigned DEFAULT NULL AFTER `ReceiptBookID`;
ALTER TABLE mgsr_donation ADD KEY `mgsr_donation_ProgrammeID_index_6` (`ProgrammeID`) USING BTREE;
ALTER TABLE mgsr_donation ADD FOREIGN KEY `mgsr_donation_ProgrammeID_ibfk_6` (`ProgrammeID`) REFERENCES `mgsr_programme` (`ID`);

insert into `mgsr_area_list` values (5, '7z', '7 Z - ', 1, 1, now(), 1, now(), 1);
insert into `mgsr_area_list` values (6, 'Devnagar', 'Devnagar', 1, 1, now(), 1, now(), 1);
insert into `mgsr_area_list` values (7, 'bharat_nagar', 'Bharat Nagar', 1, 1, now(), 1, now(), 1);
insert into `mgsr_area_list` values (8, 'purani_aabaadee', 'Purani Aabaadee', 1, 1, now(), 1, now(), 1);
insert into `mgsr_area_list` values (9, 'karanpur_road', 'Karanpur Road', 1, 1, now(), 1, now(), 1);
insert into `mgsr_area_list` values (10, '13z', '13 Z -', 1, 1, now(), 1, now(), 1);
insert into `mgsr_area_list` values (11, 'indra_colony', 'Indra Colony', 1, 1, now(), 1, now(), 1);
insert into `mgsr_area_list` values (12, 'nathawala_mamraj_colony', 'Nathawala Mamraj Colony', 1, 1, now(), 1, now(), 1);
insert into `mgsr_area_list` values (13, 'pathanwala', 'Pathanwala', 1, 1, now(), 1, now(), 1);
insert into `mgsr_area_list` values (14, 'thakarawali_baba_colony', 'Thakarawali - Baba Colony', 1, 1, now(), 1, now(), 1);
insert into `mgsr_area_list` values (15, 'khayaliwala', 'Khayaliwala', 1, 1, now(), 1, now(), 1);

http://localhost/mgsr/index.php/common/Frontend_Donor_Donor/showPratibhaSammanDonorList
 

/* date 26 jan 2019 */
ALTER TABLE mgsr_donation ADD column `DonorName` varchar(100) DEFAULT NULL AFTER `ID`;
ALTER TABLE mgsr_donation ADD column `ContactNumber` varchar(20) DEFAULT NULL AFTER `DonorName`;
ALTER TABLE mgsr_donation ADD column `Address` varchar(200) DEFAULT NULL AFTER `ContactNumber`;


ALTER TABLE mgsr_donation MODIFY column `UserID` int(11) unsigned DEFAULT NULL;


/* date 29 jan 2019 */
insert into mgsr_programme values(1, 'Pratibha Samman Samaroh 2018', 3, now(), 1, now(), 1);


/* date 25 april 2019 */
alter table mgsr_donation add column `FatherName` varchar (100) Default NULL after `DonorName`;
insert into mgsr_donation_type values (13, 'Membership Receipt', null, 1, now(), 1, now(), 1);

update mgsr_receipt_book set StatusID = 2 where id in (1,2,3,4);

insert into mgsr_receipt_book values (11, "4701-4800", null , null, 2, now(), 1, now(), 1);
insert into mgsr_receipt_book values (12, "4801-4900", null , null, 1, now(), 1, now(), 1);
insert into mgsr_receipt_book values (13, "4901-5000", null , null, 1, now(), 1, now(), 1);
insert into mgsr_receipt_book values (14, "5001-5100", null , null, 1, now(), 1, now(), 1);
insert into mgsr_receipt_book values (15, "5101-5200", null , null, 1, now(), 1, now(), 1);
insert into mgsr_receipt_book values (16, "5201-5300", null , null, 1, now(), 1, now(), 1);
insert into mgsr_receipt_book values (17, "5301-5400", null , null, 1, now(), 1, now(), 1);
insert into mgsr_receipt_book values (18, "5401-5500", null , null, 1, now(), 1, now(), 1);
insert into mgsr_receipt_book values (19, "5501-5600", null , null, 1, now(), 1, now(), 1);
insert into mgsr_receipt_book values (20, "5601-5700", null , null, 1, now(), 1, now(), 1);
insert into mgsr_receipt_book values (21, "5701-5800", null , null, 1, now(), 1, now(), 1);
insert into mgsr_receipt_book values (22, "5801-5900", null , null, 1, now(), 1, now(), 1);
insert into mgsr_receipt_book values (23, "5901-6000", null , null, 1, now(), 1, now(), 1);

 
/* date 29 april 2019 */
insert into mgsr_programme_type values (4, 'Help', 1, now(), 1, now(), 1);
insert into mgsr_programme values (2, 'For Devraj Health', 4, now(), 1, now(), 1);


insert into mgsr_donation (`DonorName`, `FatherName`, `ContactNumber`, `Address`, `DonationTypeID`, `ProgrammeID`, `DonatedAmount`, `DonationYear`, `DonationDate`, `Description`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`, `UpdatedBy`) values ('Sukhveer Shakya', null, '9983464605', 'Jaitsar Mandi Sri Ganganagar', 1, 2, 300, 2019, '2019-04-29', null, 1, now(), 1, now(), 1);


insert into mgsr_donation (`DonorName`, `FatherName`, `ContactNumber`, `Address`, `DonationTypeID`, `ProgrammeID`, `DonatedAmount`, `DonationYear`, `DonationDate`, `Description`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`, `UpdatedBy`) values ('Mukesh Shakya', null, '', '3e Chhoti Sri Ganganagar', 1, 2, 500, 2019, '2019-04-29', null, 1, now(), 1, now(), 1);


insert into mgsr_donation (`DonorName`, `FatherName`, `ContactNumber`, `Address`, `DonationTypeID`, `ProgrammeID`, `DonatedAmount`, `DonationYear`, `DonationDate`, `Description`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`, `UpdatedBy`) values ('Virender Shakya', null, '', 'Nathawala Sri Ganganagar', 1, 2, 1100, 2019, '2019-04-29', null, 1, now(), 1, now(), 1);

insert into mgsr_donation (`DonorName`, `FatherName`, `ContactNumber`, `Address`, `DonationTypeID`, `ProgrammeID`, `DonatedAmount`, `DonationYear`, `DonationDate`, `Description`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`, `UpdatedBy`) values ('Anil Shakya', null, '', 'Bhatta Colony Sri Ganganagar', 1, 2, 500, 2019, '2019-04-29', null, 1, now(), 1, now(), 1);

insert into mgsr_donation (`DonorName`, `FatherName`, `ContactNumber`, `Address`, `DonationTypeID`, `ProgrammeID`, `DonatedAmount`, `DonationYear`, `DonationDate`, `Description`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`, `UpdatedBy`) values ('Dhushyant Shakya', null, '', '3e Chhoti Colony Sri Ganganagar', 1, 2, 500, 2019, '2019-04-29', null, 1, now(), 1, now(), 1);

insert into mgsr_donation (`DonorName`, `FatherName`, `ContactNumber`, `Address`, `DonationTypeID`, `ProgrammeID`, `DonatedAmount`, `DonationYear`, `DonationDate`, `Description`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`, `UpdatedBy`) values ('Raguveer Singh Shakya', null, '', 'Bharat Nagar Sri Ganganagar', 1, 2, 2100, 2019, '2019-04-29', null, 1, now(), 1, now(), 1);


insert into mgsr_donation (`DonorName`, `FatherName`, `ContactNumber`, `Address`, `DonationTypeID`, `ProgrammeID`, `DonatedAmount`, `DonationYear`, `DonationDate`, `Description`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`, `UpdatedBy`) values ('Sheela Shakya', null, '', '7z Sri Ganganagar', 1, 2, 1000, 2019, '2019-04-29', null, 1, now(), 1, now(), 1);




insert into mgsr_donation (`DonorName`, `FatherName`, `ContactNumber`, `Address`, `DonationTypeID`, `ProgrammeID`, `DonatedAmount`, `DonationYear`, `DonationDate`, `Description`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`, `UpdatedBy`) values ('Prahlad Shakya', null, '', 'Nathawala Sri Ganganagar', 1, 2, 500, 2019, '2019-04-29', null, 1, now(), 1, now(), 1);

insert into mgsr_donation (`DonorName`, `FatherName`, `ContactNumber`, `Address`, `DonationTypeID`, `ProgrammeID`, `DonatedAmount`, `DonationYear`, `DonationDate`, `Description`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`, `UpdatedBy`) values ('Kirat Shakya', null, '', 'Sri Ganganagar', 1, 2, 1100, 2019, '2019-04-29', null, 1, now(), 1, now(), 1);

insert into mgsr_donation (`DonorName`, `FatherName`, `ContactNumber`, `Address`, `DonationTypeID`, `ProgrammeID`, `DonatedAmount`, `DonationYear`, `DonationDate`, `Description`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`, `UpdatedBy`) values ('Subhash Shakya', null, '', 'Abohar', 1, 2, 500, 2019, '2019-04-29', null, 1, now(), 1, now(), 1);

insert into mgsr_donation (`DonorName`, `FatherName`, `ContactNumber`, `Address`, `DonationTypeID`, `ProgrammeID`, `DonatedAmount`, `DonationYear`, `DonationDate`, `Description`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`, `UpdatedBy`) values ('Sunil Shakya', null, '', 'Hanumangarh', 1, 2, 500, 2019, '2019-04-29', null, 1, now(), 1, now(), 1);

insert into mgsr_donation (`DonorName`, `FatherName`, `ContactNumber`, `Address`, `DonationTypeID`, `ProgrammeID`, `DonatedAmount`, `DonationYear`, `DonationDate`, `Description`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`, `UpdatedBy`) values ('Pratap Singh Shakya', null, '', 'Kalian Sri Ganganagar', 1, 2, 500, 2019, '2019-04-29', null, 1, now(), 1, now(), 1);

insert into mgsr_donation (`DonorName`, `FatherName`, `ContactNumber`, `Address`, `DonationTypeID`, `ProgrammeID`, `DonatedAmount`, `DonationYear`, `DonationDate`, `Description`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`, `UpdatedBy`) values ('Anil Shakya', null, '', 'Bharat Nagar Sri Ganganagar', 2, 2, 2100, 2019, '2019-04-29', null, 1, now(), 1, now(), 1);

insert into mgsr_donation (`DonorName`, `FatherName`, `ContactNumber`, `Address`, `DonationTypeID`, `ProgrammeID`, `DonatedAmount`, `DonationYear`, `DonationDate`, `Description`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`, `UpdatedBy`) values ('Swetvaran Singh', null, '', 'Shakya Chemicals Bhatinda', 2, 2, 2100, 2019, '2019-04-29', null, 1, now(), 1, now(), 1);


update mgsr_donation set donationamount = 2000 where id = 421



update mgsr_donation set DonationDate = '2019-04-28' where ReceiptBookID = 21;
update mgsr_donation set DonationDate = '2019-04-27' where id between 485 and 529;




update mgsr_user set UserImageURL = 'mgsr/common/images/user/58.png' where ID = 58;
update mgsr_user set UserImageURL = 'mgsr/common/images/user/68.png' where ID = 68;
update mgsr_user set UserImageURL = 'mgsr/common/images/user/15.png' where ID = 15; 






insert into mgsr_receipt_book values (24, "6001-6100", null , null, 1, now(), 1, now(), 1);
insert into mgsr_receipt_book values (25, "6101-6200", null , null, 1, now(), 1, now(), 1);
insert into mgsr_receipt_book values (26, "6201-6300", null , null, 1, now(), 1, now(), 1);
insert into mgsr_receipt_book values (27, "6301-6400", null , null, 1, now(), 1, now(), 1);
insert into mgsr_receipt_book values (28, "6401-6500", null , null, 1, now(), 1, now(), 1);
insert into mgsr_receipt_book values (29, "6501-6600", null , null, 1, now(), 1, now(), 1);
insert into mgsr_receipt_book values (30, "6601-6700", null , null, 1, now(), 1, now(), 1);
insert into mgsr_receipt_book values (31, "6701-6800", null , null, 1, now(), 1, now(), 1);
insert into mgsr_receipt_book values (32, "6801-6900", null , null, 1, now(), 1, now(), 1);
insert into mgsr_receipt_book values (33, "6901-7000", null , null, 1, now(), 1, now(), 1);


insert into mgsr_donation_type values (27, 'Flag', 'mgsr/common/images/donationtype/flag.png', 1, now(), 1, now(), 1);

update mgsr_user set UserImageURL = 'mgsr/common/images/user/70.png' where ID = 70;
update mgsr_user set UserImageURL = 'mgsr/common/images/user/12.png' where ID = 12;
update mgsr_user set UserImageURL = 'mgsr/common/images/user/66.png' where ID = 66;
update mgsr_user set UserImageURL = 'mgsr/common/images/user/64.png' where ID = 64;
update mgsr_user set UserImageURL = 'mgsr/common/images/user/42.png' where ID = 42;
update mgsr_user set UserImageURL = 'mgsr/common/images/user/65.png' where ID = 65;
update mgsr_user set UserImageURL = 'mgsr/common/images/user/04.png' where ID = 04;
update mgsr_user set UserImageURL = 'mgsr/common/images/user/39.png' where ID = 39;
update mgsr_user set UserImageURL = 'mgsr/common/images/user/57.png' where ID = 57;
update mgsr_user set UserImageURL = 'mgsr/common/images/user/60.png' where ID = 60;
update mgsr_user set UserImageURL = 'mgsr/common/images/user/13.png' where ID = 13;
update mgsr_user set UserImageURL = 'mgsr/common/images/user/28.png' where ID = 28;
update mgsr_user set UserImageURL = 'mgsr/common/images/user/71.png' where ID = 71;
update mgsr_user set UserImageURL = 'mgsr/common/images/user/72.png' where ID = 72;

update mgsr_user set UserImageURL = 'mgsr/common/images/user/09.png' where ID = 09;
update mgsr_user set UserImageURL = 'mgsr/common/images/user/27.png' where ID = 27;
update mgsr_user set UserImageURL = 'mgsr/common/images/user/61.png' where ID = 61;


/* 6 june 2019 */
CREATE TABLE `mgsr_emitra_service` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Code` varchar(100) NOT NULL,
  `Value` varchar(100) NOT NULL,
  `StatusID` int(11) unsigned NOT NULL,
  `CreatedAt` datetime NOT NULL,
  `CreatedBy` int(11) unsigned NOT NULL,
  `UpdatedAt` datetime NOT NULL,
  `UpdatedBy` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `mgsr_emitra_service_StatusID_index2` (`StatusID`) USING BTREE,
  KEY `mgsr_emitra_service_CreatedBy_index3` (`CreatedBy`) USING BTREE,
  KEY `mgsr_emitra_service_UpdatedBy_index4` (`UpdatedBy`) USING BTREE,
  CONSTRAINT `mgsr_emitra_service_CreatedBy_ibfk_3` FOREIGN KEY (`CreatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_emitra_service_StatusID_ibfk_2` FOREIGN KEY (`StatusID`) REFERENCES `mgsr_status` (`ID`),
  CONSTRAINT `mgsr_emitra_service_UpdatedBy_ibfk_4` FOREIGN KEY (`UpdatedBy`) REFERENCES `admin_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `mgsr_designation` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Code` varchar(100) NOT NULL,
  `Value` varchar(100) NOT NULL,
  `StatusID` int(11) unsigned NOT NULL,
  `CreatedAt` datetime NOT NULL,
  `CreatedBy` int(11) unsigned NOT NULL,
  `UpdatedAt` datetime NOT NULL,
  `UpdatedBy` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `mgsr_designation_StatusID_index2` (`StatusID`) USING BTREE,
  KEY `mgsr_designation_CreatedBy_index3` (`CreatedBy`) USING BTREE,
  KEY `mgsr_designation_UpdatedBy_index4` (`UpdatedBy`) USING BTREE,
  CONSTRAINT `mgsr_designation_CreatedBy_ibfk_3` FOREIGN KEY (`CreatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_designation_StatusID_ibfk_2` FOREIGN KEY (`StatusID`) REFERENCES `mgsr_status` (`ID`),
  CONSTRAINT `mgsr_designation_UpdatedBy_ibfk_4` FOREIGN KEY (`UpdatedBy`) REFERENCES `admin_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
insert into mgsr_designation values(1, "guardian", "Guardian", 1, now(), 1, now(), 1);
insert into mgsr_designation values(2, "president", "President", 1, now(), 1, now(), 1);
insert into mgsr_designation values(3, "deputy_president", "Deputy President", 1, now(), 1, now(), 1);
insert into mgsr_designation values(4, "general_secretary", "General Secretary", 1, now(), 1, now(), 1);
insert into mgsr_designation values(5, "assisstant_secretary", "Assisstant Secretary", 1, now(), 1, now(), 1);
insert into mgsr_designation values(6, "treasurer", "Treasurer", 1, now(), 1, now(), 1);
insert into mgsr_designation values(7, "publicity_secretary", "Publicity Secretary", 1, now(), 1, now(), 1);
insert into mgsr_designation values(8, "assisstant_publicity_secretary", "Assisstant Publicity Secretary", 1, now(), 1, now(), 1);
insert into mgsr_designation values(9, "superintendent", "Superintendent", 1, now(), 1, now(), 1);
insert into mgsr_designation values(10, "store_secretary", "Store Secretary", 1, now(), 1, now(), 1);
insert into mgsr_designation values(11, "team_member", "Team Member", 1, now(), 1, now(), 1);


CREATE TABLE `mgsr_member` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `UserID` int(11) unsigned NOT NULL,
  `DesignationID` int(11) unsigned NOT NULL,
  `MemberShipDate` date DEFAULT NULL,
  `IsExecutive` tinyint DEFAULT 0,
  `DisplayOrder` int(11) DEFAULT NULL,
  `StatusID` int(11) unsigned DEFAULT NULL,
  `CreatedAt` datetime NOT NULL,
  `CreatedBy` int(11) unsigned NOT NULL,
  `UpdatedAt` datetime NOT NULL,
  `UpdatedBy` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `mgsr_member_CreatedBy_index_1` (`CreatedBy`) USING BTREE,
  KEY `mgsr_member_UpdatedBy_index_2` (`UpdatedBy`) USING BTREE,
  KEY `mgsr_member_StatusID_index_3` (`StatusID`) USING BTREE,
  KEY `mgsr_member_UserID_index_4` (`UserID`) USING BTREE,
  KEY `mgsr_member_DesignationID_index_5` (`DesignationID`) USING BTREE,
  CONSTRAINT `mgsr_member_CreatedBy_ibfk_1` FOREIGN KEY (`CreatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_member_UpdatedBy_ibfk_2` FOREIGN KEY (`UpdatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_member_StatusID_ibfk_3` FOREIGN KEY (`StatusID`) REFERENCES `mgsr_status` (`ID`),
  CONSTRAINT `mgsr_member_UserID_ibfk_4` FOREIGN KEY (`UserID`) REFERENCES `mgsr_user` (`ID`),
  CONSTRAINT `mgsr_member_DesignationID_ibfk_5` FOREIGN KEY (`DesignationID`) REFERENCES `mgsr_designation` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into mgsr_member values (1, 4, 1, '2019-05-12', 1, 1, 1, now(), 1, now(), 1);
insert into mgsr_member values (2, 5, 1, '2019-05-12', 1, 2, 1, now(), 1, now(), 1); 
insert into mgsr_member values (3, 74, 3, '2019-05-12', 1, 4, 1, now(), 1, now(), 1); 
insert into mgsr_member values (4, 73, 3, '2019-05-12', 1, 5, 1, now(), 1, now(), 1);
insert into mgsr_member values (5, 15, 2, '2019-05-12', 1, 3, 1, now(), 1, now(), 1); 
insert into mgsr_member values (6, 1, 4, '2019-05-12', 1, 6, 1, now(), 1, now(), 1);  
insert into mgsr_member values (7, 9, 5, '2019-05-12', 1, 7, 1, now(), 1, now(), 1);  
insert into mgsr_member values (8, 10, 6, '2019-05-12', 1, 8, 1, now(), 1, now(), 1);  
insert into mgsr_member values (9, 12, 7, '2019-05-12', 1, 9, 1, now(), 1, now(), 1);  
insert into mgsr_member values (10, 26, 8, '2019-05-12', 1, 10, 1, now(), 1, now(), 1);  
insert into mgsr_member values (11, 13, 9, '2019-05-12', 1, 11, 1, now(), 1, now(), 1);  
insert into mgsr_member values (12, 14, 10, '2019-05-12', 1, 12, 1, now(), 1, now(), 1);


insert into mgsr_member values (13, 72, 11, '2019-05-12', 1, 13, 1, now(), 1, now(), 1);
insert into mgsr_member values (14, 75, 11, '2019-05-12', 1, 14, 1, now(), 1, now(), 1);
insert into mgsr_member values (15, 58, 11, '2019-05-12', 1, 15, 1, now(), 1, now(), 1);
insert into mgsr_member values (16, 18, 11, '2019-05-12', 1, 16, 1, now(), 1, now(), 1);
insert into mgsr_member values (17, 62, 11, '2019-05-12', 1, 17, 1, now(), 1, now(), 1);
insert into mgsr_member values (18, 76, 11, '2019-05-12', 1, 18, 1, now(), 1, now(), 1);
insert into mgsr_member values (19, 77, 11, '2019-05-12', 1, 19, 1, now(), 1, now(), 1);
insert into mgsr_member values (20, 60, 11, '2019-05-12', 1, 20, 1, now(), 1, now(), 1);
insert into mgsr_member values (21, 78, 11, '2019-05-12', 1, 21, 1, now(), 1, now(), 1);  




CREATE TABLE `mgsr_membership_duration` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Duration` varchar(50) DEFAULT NULL,
  `StatusID` int(11) unsigned DEFAULT NULL,
  `CreatedAt` datetime NOT NULL,
  `CreatedBy` int(11) unsigned NOT NULL,
  `UpdatedAt` datetime NOT NULL,
  `UpdatedBy` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `mgsr_membership_period_CreatedBy_index_1` (`CreatedBy`) USING BTREE,
  KEY `mgsr_membership_period_UpdatedBy_index_2` (`UpdatedBy`) USING BTREE,
  KEY `mgsr_membership_period_StatusID_index_3` (`StatusID`) USING BTREE,
  CONSTRAINT `mgsr_membership_period_CreatedBy_ibfk_1` FOREIGN KEY (`CreatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_membership_period_UpdatedBy_ibfk_2` FOREIGN KEY (`UpdatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_membership_period_StatusID_ibfk_3` FOREIGN KEY (`StatusID`) REFERENCES `mgsr_status` (`ID`)  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






/* Transport Start */

/* Date 25-09-2019 By Vipin */


CREATE TABLE `mgsr_vahicale_type` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Code` varchar(100) NOT NULL,
  `Value` varchar(100) NOT NULL,
  `StatusID` int(11) unsigned NOT NULL,
  `CreatedAt` datetime NOT NULL,
  `CreatedBy` int(11) unsigned NOT NULL,
  `UpdatedAt` datetime NOT NULL,
  `UpdatedBy` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `mgsr_vahicale_type_StatusID_index2` (`StatusID`) USING BTREE,
  KEY `mgsr_vahicale_type_CreatedBy_index3` (`CreatedBy`) USING BTREE,
  KEY `mgsr_vahicale_type_UpdatedBy_index4` (`UpdatedBy`) USING BTREE,
  CONSTRAINT `mgsr_vahicale_type_CreatedBy_ibfk_3` FOREIGN KEY (`CreatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_vahicale_type_StatusID_ibfk_2` FOREIGN KEY (`StatusID`) REFERENCES `mgsr_status` (`ID`),
  CONSTRAINT `mgsr_vahicale_type_UpdatedBy_ibfk_4` FOREIGN KEY (`UpdatedBy`) REFERENCES `admin_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `mgsr_vahicale_owner` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `MobileNo` varchar(20) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `PANNo` varchar(20) DEFAULT NULL,
  `AadharNo` varchar(20) DEFAULT NULL,
  `StatusID` int(11) unsigned NOT NULL,
  `CreatedAt` datetime NOT NULL,
  `CreatedBy` int(11) unsigned NOT NULL,
  `UpdatedAt` datetime NOT NULL,
  `UpdatedBy` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `mgsr_vahicale_owner_StatusID_index1` (`StatusID`) USING BTREE,
  KEY `mgsr_vahicale_owner_CreatedBy_index2` (`CreatedBy`) USING BTREE,
  KEY `mgsr_vahicale_owner_UpdatedBy_index3` (`UpdatedBy`) USING BTREE,
  CONSTRAINT `mgsr_vahicale_owner_StatusID_ibfk_1` FOREIGN KEY (`StatusID`) REFERENCES `mgsr_status` (`ID`),
  CONSTRAINT `mgsr_vahicale_owner_CreatedBy_ibfk_2` FOREIGN KEY (`CreatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_vahicale_owner_UpdatedBy_ibfk_3` FOREIGN KEY (`UpdatedBy`) REFERENCES `admin_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `mgsr_vahicale_driver` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `MobileNo` varchar(20) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `DLNo` varchar(20) DEFAULT NULL,
  `AadharNo` varchar(20) DEFAULT NULL,
  `StatusID` int(11) unsigned NOT NULL,
  `CreatedAt` datetime NOT NULL,
  `CreatedBy` int(11) unsigned NOT NULL,
  `UpdatedAt` datetime NOT NULL,
  `UpdatedBy` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `mgsr_vahicale_driver_StatusID_index1` (`StatusID`) USING BTREE,
  KEY `mgsr_vahicale_driver_CreatedBy_index2` (`CreatedBy`) USING BTREE,
  KEY `mgsr_vahicale_driver_UpdatedBy_index3` (`UpdatedBy`) USING BTREE,
  CONSTRAINT `mgsr_vahicale_driver_StatusID_ibfk_1` FOREIGN KEY (`StatusID`) REFERENCES `mgsr_status` (`ID`),
  CONSTRAINT `mgsr_vahicale_driver_CreatedBy_ibfk_2` FOREIGN KEY (`CreatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_vahicale_driver_UpdatedBy_ibfk_3` FOREIGN KEY (`UpdatedBy`) REFERENCES `admin_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mgsr_vahicale` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `VahicaleNumber` varchar(100) NOT NULL,
  `ChasisNumber` varchar(100) DEFAULT NULL,
  `EngineNumber` varchar(100) DEFAULT NULL,
  `WeightCapacity` varchar(100) DEFAULT NULL,
  `VahicaleSizeID` int(11) DEFAULT NULL,
  `TypeID` int(11) unsigned DEFAULT NULL,
  `OwnerID` int(11) unsigned DEFAULT NULL,
  `StatusID` int(11) unsigned DEFAULT NULL,
  `CreatedAt` datetime NOT NULL,
  `CreatedBy` int(11) unsigned NOT NULL,
  `UpdatedAt` datetime NOT NULL,
  `UpdatedBy` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `mgsr_vahicale_CreatedBy_index_1` (`CreatedBy`) USING BTREE,
  KEY `mgsr_vahicale_UpdatedBy_index_2` (`UpdatedBy`) USING BTREE,
  KEY `mgsr_vahicale_StatusID_index_3` (`StatusID`) USING BTREE,
  KEY `mgsr_vahicale_TypeID_index_4` (`TypeID`) USING BTREE,
  KEY `mgsr_vahicale_OwnerID_index_5` (`OwnerID`) USING BTREE,
  CONSTRAINT `mgsr_vahicale_CreatedBy_ibfk_1` FOREIGN KEY (`CreatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_vahicale_UpdatedBy_ibfk_2` FOREIGN KEY (`UpdatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_vahicale_StatusID_ibfk_3` FOREIGN KEY (`StatusID`) REFERENCES `mgsr_status` (`ID`),
  CONSTRAINT `mgsr_vahicale_TypeID_ibfk_4` FOREIGN KEY (`TypeID`) REFERENCES `mgsr_vahicale_type` (`ID`),
  CONSTRAINT `mgsr_vahicale_OwnerID_ibfk_5` FOREIGN KEY (`OwnerID`) REFERENCES `mgsr_vahicale_owner` (`ID`)      
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `mgsr_transport_consignment_note` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ConsignmentNo` varchar(255) NOT NULL,
  `ConsignorName` varchar(100) NOT NULL,
  `ConsignorAddress` varchar(255) DEFAULT NULL,
  `ConsignorGstinNo` varchar(50) DEFAULT NULL,
  `ConsignorMobileNo` varchar(20) DEFAULT NULL,
  `ConsignorCityID` int(11) unsigned DEFAULT NULL,
  `ConsigneeName` varchar(100) DEFAULT NULL,
  `ConsigneeAddress` varchar(255) DEFAULT NULL,
  `ConsigneeGstinNo` varchar(50) DEFAULT NULL,
  `ConsigneeMobileNo` varchar(20) DEFAULT NULL,
  `ConsigneeCityID` int(11) unsigned DEFAULT NULL,
  `SourceCityID` int(11) unsigned DEFAULT NULL,
  `DestinationCityID` int(11) unsigned DEFAULT NULL,
  `TotalWeight` decimal(12,3) DEFAULT NULL,
  `UnitTypeID` int(11) unsigned DEFAULT NULL,
  `TotalAmount` decimal(12,3) DEFAULT NULL,
  `Freight` decimal(12,3) DEFAULT NULL,
  `ToPaid` decimal(12,3) DEFAULT NULL,
  `ToPay` decimal(12,3) DEFAULT NULL,
  `Balance` decimal(12,3) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `VahicaleID` int(11) unsigned NOT NULL,
  `DriverID` int(11) unsigned NOT NULL,
  `VahicaleOwnerID` int(11) unsigned NOT NULL,
  `StatusID` int(11) unsigned NOT NULL,
  `CreatedAt` datetime NOT NULL,
  `CreatedBy` int(11) unsigned NOT NULL,
  `UpdatedAt` datetime NOT NULL,
  `UpdatedBy` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `mgsr_transport_consignment_note_CreatedBy_index_1` (`CreatedBy`) USING BTREE,
  KEY `mgsr_transport_consignment_note_UpdatedBy_index_2` (`UpdatedBy`) USING BTREE,
  KEY `mgsr_transport_consignment_note_ConsignorCityID_index_3` (`ConsignorCityID`) USING BTREE,
  KEY `mgsr_transport_consignment_note_ConsigneeCityID_index_4` (`ConsigneeCityID`) USING BTREE,
  KEY `mgsr_transport_consignment_note_VahicaleID_index_5` (`VahicaleID`) USING BTREE,
  KEY `mgsr_transport_consignment_note_DriverID_index_6` (`DriverID`) USING BTREE,
  KEY `mgsr_transport_consignment_note_VahicaleOwnerID_index_7` (`VahicaleOwnerID`) USING BTREE,  
  KEY `mgsr_transport_consignment_note_SourceCityID_index_8` (`SourceCityID`) USING BTREE,
  KEY `mgsr_transport_consignment_note_DestinationCityID_index_9` (`DestinationCityID`) USING BTREE,
  CONSTRAINT `mgsr_transport_consignment_note_CreatedBy_ibfk_1` FOREIGN KEY (`CreatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_transport_consignment_note_UpdatedBy_ibfk_2` FOREIGN KEY (`UpdatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_transport_consignment_note_ConsignorCityID_ibfk_3` FOREIGN KEY (`ConsignorCityID`) REFERENCES `mgsr_city_list` (`ID`),
  CONSTRAINT `mgsr_transport_consignment_note_ConsigneeCityID_ibfk_4` FOREIGN KEY (`ConsigneeCityID`) REFERENCES `mgsr_city_list` (`ID`),
  CONSTRAINT `mgsr_transport_consignment_note_VahicaleID_ibfk_5` FOREIGN KEY (`VahicaleID`) REFERENCES `mgsr_vahicale` (`ID`),
  CONSTRAINT `mgsr_transport_consignment_note_DriverID_ibfk_6` FOREIGN KEY (`DriverID`) REFERENCES `mgsr_vahicale_driver` (`ID`),
  CONSTRAINT `mgsr_transport_consignment_note_VahicaleOwnerID_ibfk_7` FOREIGN KEY (`VahicaleOwnerID`) REFERENCES `mgsr_vahicale_owner` (`ID`)      
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* Transport End */

/* date (12-03-2020) */
insert into mgsr_district_list values (15, 'HMH', 'Hanumangarh', 29, 1, now(), 1, now(), 1);
insert into mgsr_city_list values (2, 'HMH', 'Hanumangarh', 15, 1, now(), 1, now(), 1);




/* date (26-03-2020) */
insert into mgsr_programme values (4, 'Go Corona', 4, now(), 1, now(), 1);


insert into mgsr_area_list values (18, 'bhattacolony', 'Bhatta Colony', 1, 1, now(), 1, now(), 1);
insert into mgsr_area_list values (19, 'sadhuwali', 'Sadhuwali', 1, 1, now(), 1, now(), 1);
insert into mgsr_area_list values (20, '4z-1st', '4Z - 1st', 1, 1, now(), 1, now(), 1);
insert into mgsr_area_list values (21, 'nathawala', 'Nathawala', 1, 1, now(), 1, now(), 1);

insert into mgsr_area_list values (22, 'rsnr_dakka_basti', 'Dakka Basti', 6, 1, now(), 1, now(), 1);

/* transport date (26-03-2020) */
="insert into mgsr_vahicale_owner (`Name`, `MobileNo`, `Address`, `PANNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('"&A2&"','"&B2&"','address', null, null, 1, now(), 1, now(), 1);"


 
insert into mgsr_vahicale_owner (`Name`, `MobileNo`, `Address`, `PANNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('VIRENDER KUMAR','9416793836','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_owner (`Name`, `MobileNo`, `Address`, `PANNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('BALWAN SHARMA JIND ROAD KAITHAL','9215775601','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_owner (`Name`, `MobileNo`, `Address`, `PANNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('SANDEEP G AGARWAL','9992890953','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_owner (`Name`, `MobileNo`, `Address`, `PANNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RAMESH CHABRA','9417079215','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_owner (`Name`, `MobileNo`, `Address`, `PANNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('DEELIP CHAND SIRSA','9728233148','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_owner (`Name`, `MobileNo`, `Address`, `PANNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('BHART KUMAR SIRSA','7027128871','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_owner (`Name`, `MobileNo`, `Address`, `PANNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('GAGA RAM ELLNABAD','9355018778','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_owner (`Name`, `MobileNo`, `Address`, `PANNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('DAYAL HUSAN','7056062860','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_owner (`Name`, `MobileNo`, `Address`, `PANNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('SURENDER KUMAR THIRPALI BADI','7740804047','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_owner (`Name`, `MobileNo`, `Address`, `PANNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('BHUPANDER S/O RAJENDER GE','9887871513','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_owner (`Name`, `MobileNo`, `Address`, `PANNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('SAHJAD MUJAFANAGAR','9610891886','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_owner (`Name`, `MobileNo`, `Address`, `PANNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('SACHIN G YADAV','9828419511','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_owner (`Name`, `MobileNo`, `Address`, `PANNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('SURENDER KUMAR THIRPALI BADI','7740804047','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_owner (`Name`, `MobileNo`, `Address`, `PANNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('BHUPANDER S/O RAJENDER GE','9887871513','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_owner (`Name`, `MobileNo`, `Address`, `PANNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('EKBAAL SINGH S/O KULWINDER SINGH','9050355501','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_owner (`Name`, `MobileNo`, `Address`, `PANNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('ATUL GE SGNR','9413377059','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_owner (`Name`, `MobileNo`, `Address`, `PANNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('BHUPENDER KUMARS/O RAJENDER G','9887871513','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_owner (`Name`, `MobileNo`, `Address`, `PANNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HANUMAN MISTRI','9004835909','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_owner (`Name`, `MobileNo`, `Address`, `PANNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RAJKUMAR S/O DIWAN CHAND','9996574640','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_owner (`Name`, `MobileNo`, `Address`, `PANNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('MANJEET SINGH','9416726362','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_owner (`Name`, `MobileNo`, `Address`, `PANNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RAGUBEER SINGH','8607782941','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_owner (`Name`, `MobileNo`, `Address`, `PANNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('VIRAT CARGO','9413362111','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_owner (`Name`, `MobileNo`, `Address`, `PANNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('SURENDER KUMAR THIRPALI BADI','9636621414','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_owner (`Name`, `MobileNo`, `Address`, `PANNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('BHUPANDER S/O RAJENDER GE','9887871513','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_owner (`Name`, `MobileNo`, `Address`, `PANNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RAJENDER KUMAR SIRSA ','9466179111','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_owner (`Name`, `MobileNo`, `Address`, `PANNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('PARKESH G ROTHAK ','7678839914','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_owner (`Name`, `MobileNo`, `Address`, `PANNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('SURESH KUMAR','9992012400','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_owner (`Name`, `MobileNo`, `Address`, `PANNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('SUBASH KUMAR ','9636621414','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_owner (`Name`, `MobileNo`, `Address`, `PANNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('SUBASH KUMAR ','9636621414','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_owner (`Name`, `MobileNo`, `Address`, `PANNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RAMKISHAN S/O RAMDAT JI','9813075066','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_owner (`Name`, `MobileNo`, `Address`, `PANNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('GURUMEET CHAND ','9416607023','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_owner (`Name`, `MobileNo`, `Address`, `PANNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('CHIMANLAL ABHOR','9814016407','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_owner (`Name`, `MobileNo`, `Address`, `PANNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('CHAGANLAL VADHERA','9888399081','address', null, null, 1, now(), 1, now(), 1);



="insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('"&A2&"','"&B2&"','address', null, null, 1, now(), 1, now(), 1);"


insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('BABURAMG','8815382217','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('VIRENDER KUMAR S/O CHARAN SINGH','8059253956','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HEMRAJ JI S/O JAMADAR GONOT KHAS KAITHAL','8571036256','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HASAN ALI','9215775601','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('VIMLESH ','9466480720','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('KRISHAN KUMAR','7210022788','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('VED PARKESH HISSAR','8901420402','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('SUKWINDER SINGH','7056020456','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('VEERU SINGH','9799638108','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('SURESH KUMAR','9929732358','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('SUNIL KUMAR S/O PREM GE','9992615014','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('SURESH NARNOD','9050401258','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('GARNAL SINGH','8769217993','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('BHART KUMAR','7027128871','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('KALA SINGH','9461841137','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('DALVEER SINGH S/O CHOTURAM','8239195361','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('SATNAM SINGH','8059413464','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('BHAGWANT S/O GAGTARSINGH','9467022066','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('SUBASH KUMAR S/O BABULAL GE','9636621414','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('GAGRAM S/O BHIKHARAM GE','8107332710','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('MANIRAM S/O BIRBAL GE','8442096319','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('SUBA SINGH GE','9416445297','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('PUNIT GE','9759731617','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('SURJEET SINGH','9728727315','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('CHAMKOR SINGH','9417677792','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RAJNESH KUMAR S/O SAHAB SINGH LIC 1065','9050298970','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('PRAB DAYAL ABHOR','9592476112','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('KALA MUZFARNAGAR','9997231845','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('SATISH KUMAR S/O MAHINDER SINGH','9466918516','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('NARENDER PAL SINGH','9466669070','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('LAXMAN SINGH','9034119492','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('SUBASH KUMAR S/O BABULAL GE','9636621414','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('GAGRAM S/O BHIKHARAM GE','8107332710','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('MANIRAM S/O BIRBAL GE','8442096319','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('DALBIR SINGH S/O SAMPURAN SINGH ABHOR LI NO M95425','9780100856','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('SADHURAM','9416625422','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('MOHAN','8107189905','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('KASMEER SINGHS/O MAHINDER SINGH LIC. NO  UP 78 20120073920','9050230414','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('KHAZAN SINGH S/O PANJAB SINGH ABHOR','9478459155','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('SADHU SINGHS/O KARNEL SINGH VILL BAJAKHANA LIC NO.RJ2519800004439 FARIDCOAT','9463831382','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('OOMAD','9672682500','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RAMESH KUMAR','9416323199','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('JAGMOHAN SINGH S/O BHUPSINGH','9992045063','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HARIMOHAN SINGH','9888705966','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('PRAB DAYAL ABHOR','9463339841','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('SUNIL KUMAR SGNR','9950907192','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('SADEEK KHAN','9462657358','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('SUBASH KUMAR S/O BABULAL GE','9636621414','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('JAGMOHAN SINGH S/O BHUPSINGH','8107332710','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('MANIRAM S/O BIRBAL GE','8442096319','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('VEERU SINGH','7820824233','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('TFC','7597461053','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HANUMANGARH','9680632400','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HANUMANGARH','9991966143','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RAJU','9988947203','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('LOKESH KUMAR','9205521841','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('GURUTEJ SINGH','9784675190','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('KHAN CHAND S/O DIWAN CHAND','9416548693','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('MANJEET SINGH S/O AMARJEET SINGH','9728727803','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('SUBASH KUMAR ','9467724711','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RAGUBEER SINGH S/O BADULU RAM JI','9416786845','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('BAGA SINGH','9462976248','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('DESRAJ ','9461226286','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('DEEPU','9413518565','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('VED PARKESH SGNR','9928500335','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RAMPAL S/O LADHU RAM  83328 HMO ','9467881570','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HARBHAJAN SINGH','7733983280','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('SUBASH KUMAR','9467724711','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('JAGMAAN S/O BHIKARAM JI','8107332710','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('GAGRAM S/O BHIKHARAM GE','8107332710','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('MANIRAM S/O BIRBAL GE','8442096319','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('CHUNNIRAM S/O BHAGWAN DASS LIC.NO RJ31003567','8607425887','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('SURENDER SINGH ','8239600103','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('BAKSHA RAM','9466055298','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('KRISHAN KUMARS/O PARKESH MADINA VILL. MEHAM','8929228361','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('SURESH KUMAR S/O BASAOO RAM LIC.NO.199503','1257-233395','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('VEERU SINGH','7820824233','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HARBHAJAN SINGH','7733983280','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('TONI G ABHOR','8427113099','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('BABURAMG','8853822175','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('KRISHAN LAL ','9799833504','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('JAGMAAL S/O BHIKA RAM LIC.NO 129809 BIKANER LUNKARANSAR','8107332710','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('SHAH ALI ','9413592686','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('BABLU','8764374357','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('SHER SINGH','8745099802','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('SANDEEP ','9992179832','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('DARSHAN','9041130274','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('VIRENDER SINGH','8764374357','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('SURENDER SINGH ','8239600103','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('SUNIL KUMAR S/O AJIT SINGH LIC NO HR61/7755','9813728946','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('GURUMEET CHAND S/O LALCHAND VPO NATAR SIRSA','8683907023','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('GURUSEVAK SINGH','9929757611','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('SURENDER SINGH ','8239600103','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('SURESH KUMAR S/O PRAHLAAD RAM LIC NO.54550 SIKER','9799561948','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('CHATEN','9680011855','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('KRISHAN','9414600195','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RAGU ','8694065965','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('MAHINDER KUMAR','964693035','address', null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale_driver (`Name`, `MobileNo`, `Address`, `DLNo`, `AadharNo`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('MAHINDER KUMAR','9521480777','address', null, null, 1, now(), 1, now(), 1);




="insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('"&A2&"', null, null, null, null, null, 1, now(), 1, now(), 1);"



insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR629378', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR637902', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR56B0077', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('UP12T3125', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR39C2636', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ13GB6133', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ07G8514', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR613574', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR55E4020', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ13GB3112', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ13GA2096', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ13GB2312', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR61A6101', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR47A8706', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR46C7164', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ131G0917', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ191G3332', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR46D8111', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR46B6501', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ13GA4991', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ19GC1117', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR47C9925', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR57A5730', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ10GA1246', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ10GA0815', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ18GA1691', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR66B7018', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('UP12AT4545', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ07GAA2010', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR55J6303', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('PB11BN7747', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ02GA5638', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ21GA1855', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('UP12AT2171', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR616419', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR57A8986', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR642015', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ10GA1246', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ10GA0815', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ18GA1691', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ19GB7860', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR39C3779', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ131G0023', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR573927', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('PB13M3146', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ20G4147', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ49GA1513', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR39A6762', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR57 3865', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ10GA3085', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ31GA3072', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ10GA7400', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('PB02AR9848', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR46B7489', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ13G8313', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ21GA1855', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ13GB2751', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ13GA4101', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ10GA1246', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ10GA0815', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ18GA1691', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR39D9499', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ13GA2346', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR55K2932', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ13GA2096', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR63B4247', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ19GB1116', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ14GB6261', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ31GA5305', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR63A2254', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ09GA1635', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ07GA1784', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR55K9023', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ07GB9451', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR566592', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ31GA1357', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ31GA4533', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR46C5353', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR578621', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ07GA9251', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ07GA4507', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ13GB3112', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ131G1017', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR39B7032', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ07GA8747', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ31GA4533', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ10GA1246', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ10GA0815', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ18GA1691', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR55G3384', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ31GA2669', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('PB10FF5749', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR61B4171', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ13GA4101', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ13GB2312', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('UP12T5358', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR56C0063', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR15G0142', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ13GA2096', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ07GA8747', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ191G2968', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR629378', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ13GA2346', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ10GA0815', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ10GA1246', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ07G6636', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ31GA1737', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ13GA3368', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR617087', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ31GA3537', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ31GA1737', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('PB10FF5749', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR61C8713', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR567023', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR55N5972', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ191G9565', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR579982', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ131G0417', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ31GA4072', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ13GA6229', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ07GA2108', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ07G8647', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('UP12T4545', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR61A4885', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('PB10BF5749', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ10GA1246', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ10GA0815', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ02GA3304', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ18GA1691', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR63A7539', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ22GA1024', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR39B7032', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR576186', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ13GA1735', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR579882', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ13GA2096', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ31GA0621', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ31G6229', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('RJ13GB0033', null, null, null, null, null, 1, now(), 1, now(), 1);
insert into mgsr_vahicale (`VahicaleNumber`, `ChasisNumber`, `EngineNumber`, `WeightCapacity`, `VahicaleSizeID`, `OwnerID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`,`UpdatedBy`) values ('HR61 2616', null, null, null, null, null, 1, now(), 1, now(), 1);


/* date 9 april 2020 */
CREATE TABLE `mgsr_name_prefix` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Value` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into `mgsr_name_prefix` values(1, 'Mr.');
insert into `mgsr_name_prefix` values(2, 'Ms.');
insert into `mgsr_name_prefix` values(3, 'Mrs.');
insert into `mgsr_name_prefix` values(4, 'S/O Mr.');
insert into `mgsr_name_prefix` values(5, 'S/O Mrs.');
insert into `mgsr_name_prefix` values(6, 'D/O Mr.');
insert into `mgsr_name_prefix` values(7, 'D/O Mrs.');
insert into `mgsr_name_prefix` values(8, 'W/O Mr.');
insert into `mgsr_name_prefix` values(9, 'H/O Mrs.');
insert into `mgsr_name_prefix` values(10, 'C/O Mr.');
insert into `mgsr_name_prefix` values(11, 'C/O Mrs.');
insert into `mgsr_name_prefix` values(12, 'Late Mr.');
insert into `mgsr_name_prefix` values(13, 'Late Ms.');
insert into `mgsr_name_prefix` values(14, 'Late Mrs.');
insert into `mgsr_name_prefix` values(15, 'S/O Late Mr.');
insert into `mgsr_name_prefix` values(16, 'S/O Late Mrs.');
insert into `mgsr_name_prefix` values(17, 'D/O Late Mr.');
insert into `mgsr_name_prefix` values(18, 'D/O Late Mrs.');
insert into `mgsr_name_prefix` values(19, 'W/O Late Mr.');
insert into `mgsr_name_prefix` values(20, 'H/O Late Mrs.');
insert into `mgsr_name_prefix` values(21, 'C/O Late Mr.');
insert into `mgsr_name_prefix` values(22, 'C/O Late Mrs.');

Alter table `mgsr_user` add column `NamePrefixID` int(11) unsigned DEFAULT NULL after `ID`;
Alter table `mgsr_user` add column `ParentID` int(11) unsigned DEFAULT NULL after `Name`;


CREATE TABLE `mgsr_gender` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Value` varchar(50) DEFAULT NULL,
  `StatusID` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `mgsr_gender_StatusID_index_1` (`StatusID`) USING BTREE,
  CONSTRAINT `mgsr_gender_StatusID_ibfk_1` FOREIGN KEY (`StatusID`) REFERENCES `mgsr_status` (`ID`)  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into mgsr_gender values(1, 'Male', 1);
insert into mgsr_gender values(2, 'FeMale', 1);
insert into mgsr_gender values(3, 'Transgender', 1);

alter table `mgsr_user` add column `GenderID` int(11) unsigned Default null after `UserImageURL`;
update `mgsr_user` set GenderID = 1;

select donation.id from mgsr_user `usr` inner join mgsr_donation `donation` on usr.name = donation.donorname  where donation.userid is null and donation.donatedamount = '10.00' and donation.donationtypeid = 13;

select donation.id donationid, donation.donorname, donation.contactnumber, donation.Address, usr.id userid, usr.name username, usr.mobilenumber1, usr.address address from mgsr_user `usr` inner join mgsr_donation `donation` on usr.name = donation.donorname  where donation.userid is null and donation.donatedamount = '10.00' and donation.donationtypeid = 13;


select donation.id donationid, donation.donorname, donation.contactnumber, usr.id userid, usr.name username, usr.mobilenumber1 from mgsr_user `usr` inner join mgsr_donation `donation` on usr.name = donation.donorname and usr.mobilenumber1 = donation.contactnumber where donation.userid is null and donation.donatedamount = '10.00' and donation.donationtypeid = 13;


select donation.id donationid, donation.donorname, donation.contactnumber, donation.Address, usr.id userid, usr.name username, usr.mobilenumber1, usr.address address from mgsr_user `usr` inner join mgsr_donation `donation` on usr.name = donation.donorname and usr.address = donation.address  where donation.userid is null and donation.donatedamount = '10.00' and donation.donationtypeid = 13;


(case when donation.Address = 'V.P.O. KALIYAN, SRI GANGANAGAR' then 18
case when donation.Address = '3 PULI' then 39
case when donation.Address = '4 Z' then 20
case when donation.Address = '7z Ajay Colony Sri Ganganagar' then 5
case when donation.Address = '17 ml Bhattha Colony Ganganagar' then 4
case when donation.Address = '17 ML Bhattha colony sri ganganagar' then 4
case when donation.Address = '17 ml Bhattha Colony Ganganagar 9' then 4
case when donation.Address = '4 Z Sri Ganganagar' then 20
case when donation.Address = '4 Z Sri Ganganagar' then 20
case when donation.Address = '17 ml patanwala Sri Ganganagar' then 40
case when donation.Address = '17 ml Pathan wala Ganganagar' then 40
case when donation.Address = '17 ml Pathan wala Sri Ganganagar' then 40



) areaid,

insert into mgsr_user (`NamePrefixID`, `Name`, `FatherName`, `GenderID`, `MobileNumber1`, `Address`, `StatusID`, `CountryID`, `StateID`, `DistrictID`, `CityID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`, `UpdatedBy`, `Category1Value`)
( select 1 NamePrefixID,
donation.donorname Name, 
donation.fathername FatherName, 
case when donation.description = 'Male' then 1 else 2 end GenderID,
donation.contactnumber MobileNumber1, 
donation.Address Address,
1 `StatusID`,
1 `CountryID`,
29 `StateID`,
1 `DistrictID`,
1 `CityID`,
now(),
1,
now(),
1,
donation.id Category1Value
from mgsr_donation donation where donation.userid is null and donation.donatedamount = '10.00' and donation.donationtypeid = 13 and donation.id not in (447, 449, 464, 469, 473, 473, 476, 491, 544, 652, 655, 700, 743, 764, 824, 854, 854, 899, 899, 901, 901, 901, 902, 924, 1017, 1023, 1039, 1049, 1083, 1206, 1228, 1267, 1273, 1273, 1293, 1321, 1350, 1368, 1374, 1382, 1419, 1461, 1511, 1557, 1563, 1569, 1593, 1599, 1601, 1601, 1638, 1647, 1670, 1694, 1715));

update `mgsr_donation` as donation,
 ( select ID, Category1Value  from `mgsr_user` where id > 108 and date(createdat) = '2020-04-14') as usr 
set donation.UserID = usr.ID
where donation.id = usr.Category1Value;


select donation.id donationid, donation.donorname, donation.contactnumber, donation.Address, usr.id userid, usr.name username, usr.mobilenumber1, usr.address address from mgsr_user `usr` inner join mgsr_donation `donation` on usr.name = donation.donorname and usr.address = donation.address  where donation.userid is null and donation.donationtypeid != 13;


select count(*) from mgsr_donation  where userid is null;





CREATE TABLE `mgsr_programme_status` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `StatusName` varchar(50) DEFAULT NULL,
  `CreatedAt` datetime NOT NULL,
  `CreatedBy` int(11) unsigned NOT NULL,
  `UpdatedAt` datetime NOT NULL,
  `UpdatedBy` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `mgsr_programme_status_CreatedBy_index_1` (`CreatedBy`) USING BTREE,
  KEY `mgsr_programme_status_UpdatedBy_index_2` (`UpdatedBy`) USING BTREE,
  CONSTRAINT `mgsr_programme_status_CreatedBy_ibfk_1` FOREIGN KEY (`CreatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_programme_status_UpdatedBy_ibfk_2` FOREIGN KEY (`UpdatedBy`) REFERENCES `admin_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


insert into `mgsr_programme_status` values (1, 'Upcomming', now(), 1, now(), 1);
insert into `mgsr_programme_status` values (2, 'Running', now(), 1, now(), 1);
insert into `mgsr_programme_status` values (3, 'Postponed', now(), 1, now(), 1);
insert into `mgsr_programme_status` values (4, 'Completed', now(), 1, now(), 1);
insert into `mgsr_programme_status` values (5, 'Canceled', now(), 1, now(), 1);


alter table `mgsr_programme` add column `ProgrammeDate` datetime default NULL after `ProgrammeName`;
alter table `mgsr_programme` add column `ProgrammeYear` int(11) default NULL after `ProgrammeDate`;
alter table `mgsr_programme` add column `StatusID` int(11) unsigned default NULL after `TypeID`, add KEY `mgsr_programme_StatusID_index_4` (`StatusID`) USING BTREE, add CONSTRAINT `mgsr_programme_StatusID_ibfk_4` FOREIGN KEY (`StatusID`) REFERENCES `mgsr_programme_status` (`ID`);



CREATE TABLE `mgsr_society` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Code` varchar(100) DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `RegistrationNo` varchar(255) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `AreaID` varchar(255) DEFAULT NULL,
  `StatusID` int(11) unsigned DEFAULT NULL,
  `CreatedAt` datetime NOT NULL,
  `CreatedBy` int(11) unsigned NOT NULL,
  `UpdatedAt` datetime NOT NULL,
  `UpdatedBy` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `mgsr_society_CreatedBy_index_1` (`CreatedBy`) USING BTREE,
  KEY `mgsr_society_UpdatedBy_index_2` (`UpdatedBy`) USING BTREE,
  KEY `mgsr_society_StatusID_index_3` (`StatusID`) USING BTREE,
  KEY `mgsr_society_AreaID_index_4` (`AreaID`) USING BTREE,
  CONSTRAINT `mgsr_society_CreatedBy_ibfk_1` FOREIGN KEY (`CreatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_society_UpdatedBy_ibfk_2` FOREIGN KEY (`UpdatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_society_StatusID_ibfk_3` FOREIGN KEY (`StatusID`) REFERENCES `mgsr_status` (`ID`),
  CONSTRAINT `mgsr_society_AreaID_ibfk_4` FOREIGN KEY (`StatusID`) REFERENCES `mgsr_area_list` (`ID`)  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/* date 19 may 2020 */







update mgsr_user set areaid=15 where address = '11 lnp khayali wala Sri Ganganagar';
update mgsr_user set areaid=15 where address = '11 LNP khayali wala sriganganagar';
update mgsr_user set areaid=15 where address = '11 LNP ख्यालीवाला ';
update mgsr_user set areaid=15 where address = '11 LNP भट्टा कॉलोनी';
update mgsr_user set areaid=4 where address ='17 ml  भट्टा कॉलोनी ';
update mgsr_user set areaid=4 where address ='17 ml bhatta colony';
update mgsr_user set areaid=4 where address ='17 ml Bhatta Colony Ganganagar';
update mgsr_user set areaid=4 where address ='17 ML Bhatta Colony Sri Ganganagar';
update mgsr_user set areaid=4 where address ='17 ml Bhattha Colony Ganganagar';
update mgsr_user set areaid=4 where address ='17 ml Bhattha Colony Ganganagar 9';
update mgsr_user set areaid=4 where address ='17 ML Bhattha colony sri ganganagar';
update mgsr_user set areaid=40 where address ='17 ml patanwala Sri Ganganagar';
update mgsr_user set areaid=40 where address ='17 ml Pathan wala Ganganagar';
update mgsr_user set areaid=4 where address ='17 ML भट्टा कॉलोनी ';
update mgsr_user set areaid=4 where address ='17 ML भट्टा कॉलोनी रीको ';
update mgsr_user set areaid=4 where address ='17 MLभट्टा कॉलोनी';
update mgsr_user set areaid=4 where address ='17ml भट्टा कॉलोनी';
update mgsr_user set areaid=3 where address ='2 e chhoti';
update mgsr_user set areaid=3 where address ='2 e chhoti  Nehru nagar 2nd';
update mgsr_user set areaid=3 where address ='2 e chhoti friends 3rd';
update mgsr_user set areaid=3 where address ='2 e chhoti friends vihar 2nd';
update mgsr_user set areaid=3 where address ='2 e chhoti friends vihar 3rd';
update mgsr_user set areaid=3 where address ='2 e chhoti nahru nagar 2nd';
update mgsr_user set areaid=3 where address ='2 e chhoti Nehru colony 2nd rj resort';
update mgsr_user set areaid=3 where address ='2 e chhoti Nehru nagar';
update mgsr_user set areaid=3 where address ='2 e chhoti Nehru nagar 2nd';
update mgsr_user set areaid=3 where address ='2 e chhoti Nehru nagar 2nd RJ resort';
update mgsr_user set areaid=3 where address ='2 E छोटी ';
update mgsr_user set areaid=86 where address ='2 M L Nehru Colony Sri Ganganagar';
update mgsr_user set areaid=61 where address ='2 Y';
update mgsr_user set areaid=7 where address ='230-A, BHARAT NAGAR, SRI GANGANAGAR';
update mgsr_user set areaid=3 where address ='2e chhoti sri ganganagar';
update mgsr_user set areaid=72 where address ='2ml Nathawali Dev Colony Sri Ganganagar';
update mgsr_user set areaid=73 where address ='2ml Nathawali Sri Ganganagar';
update mgsr_user set areaid=61 where address ='2y Sri Ganganagar';
update mgsr_user set areaid=2 where address ='3 choti Shiv Nagar Sri Ganganaga';
update mgsr_user set areaid=2 where address ='3 E Chhoti';
update mgsr_user set areaid=2 where address ='3 E Chhoti ,SGNR';
update mgsr_user set areaid=2 where address ='3 E Chhoti ,SGNRfd';
update mgsr_user set areaid=2 where address ='3 e chhoti Gail no 4';
update mgsr_user set areaid=2 where address ='3 e chhoti shiv nagar gali no 4 sri ganganagar';
update mgsr_user set areaid=2 where address ='3 E Chhoti, SGNR';
update mgsr_user set areaid=2 where address ='3 e choti Shiv Nagar Sri Ganganagar';
update mgsr_user set areaid=39 where address ='3 PULI';
update mgsr_user set areaid=3 where address ='3e Chhoti Gali No 1 Sri Ganganagar';
update mgsr_user set areaid=59 where address ='3e Chhoti Nagouri Colony Gali No 5 Sri Ganganagar';
update mgsr_user set areaid=51 where address ='3e chhoti ramlal colony gali no 5 sri ganganagar';
update mgsr_user set areaid=51 where address ='3e Chhoti Ramlal Colony Sri Ganganagar';
update mgsr_user set areaid=3 where address ='3e chhoti shiv nagar gali no 4 Sri Ganganagar';
update mgsr_user set areaid=3 where address ='3e chhoti shiv nagar gali no 5 sri ganganagar';
update mgsr_user set areaid=3 where address ='3e chhoti shiv nagar gali no 8 sri ganganagar';



update mgsr_user set areaid=70 where address='4 e chhoti sahul city';
update mgsr_user set areaid=70 where address='4 E Chhoti Sri Ganganagar';
update mgsr_user set areaid=70 where address='4 E chhoti, SGNR';
update mgsr_user set areaid=70 where address='4 e Choti Sri Ganganagar';
update mgsr_user set areaid=70 where address='4 EChoti Sri Ganganagar';
update mgsr_user set areaid=20 where address='4 Z';
update mgsr_user set areaid=20 where address='4 Z Sri Ganganagar';
update mgsr_user set areaid=96 where address='41 गांधी नगर श्रीगंगानगर ';
update mgsr_user set areaid=96 where address='41 गांधीनगर श्री गंगानगर ';
update mgsr_user set areaid=70 where address='4E chhoti Ganganagar';
update mgsr_user set areaid=70 where address='4E chhoti Sri Ganganagar';
update mgsr_user set areaid=70 where address='4E Choti Sri Ganganagar';
update mgsr_user set areaid=20 where address='4z First Sri Ganganagar';
update mgsr_user set areaid=11 where address='Durga Vihar indra colony gali no 4 sri gangangar';
update mgsr_user set areaid=8 where address='Kedar Chowk ward number 4 Sri Ganganagar';
update mgsr_user set areaid=8 where address='Kedare chowk ward number 4 purani abadi Sri Ganganagar';
update mgsr_user set areaid=8 where address='W N 4 purani abadi Kedar chowk Sri Ganganagar';
update mgsr_user set areaid=8 where address='W number 4 Kedar chowk purani abadi Sri Ganganagar';
update mgsr_user set areaid=91 where address='ward no 45 ravidas nagar sri ganganagar';
update mgsr_user set areaid=8 where address='Ward number 4 Kedar Chowk  purani Abadi Sri Ganganagar';
update mgsr_user set areaid=8 where address='Ward number 4 Kedar chowk purani abadi Ganganagar';
update mgsr_user set areaid=8 where address='Ward number 4 Kedar chowk purani abadi Sri Ganganagar';
update mgsr_user set areaid=8 where address='Ward number 4 purani abadi Kedar chowk Sri Ganganagar';
update mgsr_user set areaid=8 where address='Wn 4 Kedar chowk purani abadi Sri Ganganagar';


update mgsr_user set areaid=7 where address='111-B, BHARAT NAGAR,WARD NO. 2, SRI GANGANAGAR';
update mgsr_user set areaid=97 where address='11LNP भट्ट कॉलोनी ';
update mgsr_user set areaid=97 where address='11LNP भट्टा कॉलोनी';
update mgsr_user set areaid=23 where address='120-121 Bhanbhu Colony Sri Ganganagar';
update mgsr_user set areaid=7 where address='136-A, BHARAT NAGAR,WARD NO. 2, SRI GANGANAGAR';
update mgsr_user set areaid=77 where address='15 ml Sri Ganganagar';
update mgsr_user set areaid=87 where address='15 Z, SRI GANGANAGAR';
update mgsr_user set areaid=98 where address='16 ML ख्यालीवाला ';
update mgsr_user set areaid=98 where address='16 ML ढाणी ';
update mgsr_user set areaid=98 where address='16 MLख्यालीवाला ';
update mgsr_user set areaid=98 where address='16 MLढाणी ';
update mgsr_user set areaid=99 where address='17 ML इंद्रलोक सिटी ';
update mgsr_user set areaid=99 where address='17 MLइंद्रलोक सिटी ';
update mgsr_user set areaid=23 where address='187 Bhanbhu Colony Sri Ganganagar';
update mgsr_user set areaid=100 where address='1z Sri Ganganagar';
update mgsr_user set areaid=7 where address='230-A, BHARAT NAGAR, SRI GANGANAGAR';
update mgsr_user set areaid=63 where address='33 Ganga Colony Sri Ganganagar';
update mgsr_user set areaid=101 where address='3ML, SGNR';

update mgsr_user set areaid=7 where address='55-B, BHARAT NAGAR,WARD NO. 2, SRI GANGANAGAR';
update mgsr_user set areaid=105 where address='6 Z ढाणी ';
update mgsr_user set areaid=5 where address='7 Z Sri Ganganagar';
update mgsr_user set areaid=102 where address='7e Chhoti Satya Colony Sri Ganganagar';
update mgsr_user set areaid=5 where address='7z Ajay Colony Sri Ganganagar';
update mgsr_user set areaid=5 where address='7z Ajay Colony Sri Ganganagare';
update mgsr_user set areaid=5 where address='7Z Sri Ganganagar';
update mgsr_user set areaid=16 where address='86-B Block';
update mgsr_user set areaid=103 where address='9 LNP';
update mgsr_user set areaid=104 where address='9 Z श्रीगंगानगर';
update mgsr_user set areaid=104 where address='9 Zश्रीगंगानगर ';
update mgsr_user set areaid=23 where address='91 bhanbhu colony gali no 2 ward no 18';
update mgsr_user set areaid=58 where address='Ambe Bihar, Sri Ganganagar';
update mgsr_user set areaid=53 where address='Arjun Nagar Sri Ganganagar';
update mgsr_user set areaid=78 where address='Balaji Bihar , Sri Ganganagar';
update mgsr_user set areaid=78 where address='Balaji Bihar, Sri Ganganagar';
update mgsr_user set areaid=23 where address='Bhanbhu Colony Sri Ganganagar';
update mgsr_user set areaid=7 where address='Bharat Nagar Sri Ganganagar';
update mgsr_user set areaid=7 where address='BHARAT NAGAR, SRI GANGANAGAR';



update mgsr_user set areaid=74 where address='C HEAD SRI GANGANAGAR';
update mgsr_user set areaid=74 where address='C HEAD, SR GANGANAGAR';
update mgsr_user set areaid=74 where address='C HEAD, SRI GANGANAGAR';
update mgsr_user set areaid=74 where address='C HEAD,SRI GANGANAGAR';
update mgsr_user set areaid=81 where address='Chak 1E chhoti , Sri Ganganagar';
update mgsr_user set areaid=72 where address='Dev Colony 2ml Nathawali Sri Ganganagar';
update mgsr_user set areaid=72 where address='dev colony nathawala';
update mgsr_user set areaid=72 where address='Dev Colony nathawala 2 ml Sri Ganganagar';
update mgsr_user set areaid=72 where address='Dev Colony Sri Ganganagar';
update mgsr_user set areaid=72 where address='Dev Nagar House No 6 Sri Ganganagar';
update mgsr_user set areaid=72 where address='Dev Nagar Sri Ganganagar';
update mgsr_user set areaid=57 where address='DHILLON COLONY, SRI GANGANAGAR';
update mgsr_user set areaid=85 where address='G 58 Civil Lines Sri Ganganagar';
update mgsr_user set areaid=85 where address='G58 Civil Lines Sri Ganganagar';
update mgsr_user set areaid=42 where address='Ganpati Nagar, Sri Ganganagar';
update mgsr_user set areaid=75 where address='Govind Nagar Sri Ganganagar';
update mgsr_user set areaid=37 where address='House No 26 Master Colony Sri Ganganagar';
update mgsr_user set areaid=11 where address='indra colony gali no 11 sri gangangar';
update mgsr_user set areaid=11 where address='indra colony gali no 6 sri gangangar';


update mgsr_user set areaid=9 where address='Kanpur Road Sri Ganganagar';
update mgsr_user set areaid=82 where address='Karni Marg Sri Ganganagar';
update mgsr_user set areaid=8 where address='Kedar chowk purani abadi Sri Ganganagar';
update mgsr_user set areaid=8 where address='Kedar chowk ward no 5';
update mgsr_user set areaid=12 where address='mamraj colony nathawala';
update mgsr_user set areaid=37 where address='Master Colony';
update mgsr_user set areaid=37 where address='Master Colony Gali no 1 Sri Ganganagar';
update mgsr_user set areaid=37 where address='master colony gali no 7';
update mgsr_user set areaid=37 where address='Master Colony Sri Ganganagar';
update mgsr_user set areaid=8 where address='Mohar Singh Chowk purani Abadi Sri Ganganagar';
update mgsr_user set areaid=73 where address='nathawala';
update mgsr_user set areaid=73 where address='nathawala 2ml';
update mgsr_user set areaid=72 where address='nathawala dev colony';
update mgsr_user set areaid=73 where address='nathawala sriganganagar';
update mgsr_user set areaid=73 where address='Nathawali Sri Ganganagar';
update mgsr_user set areaid=1 where address='nehra nagar sri ganganagar';
update mgsr_user set areaid=1 where address='Nehra Nagar,  Sri Ganganagar';
update mgsr_user set areaid=1 where address='Nehra Nagar, SGNR';
update mgsr_user set areaid=86 where address='Nehru Colony Nathawali Sri Ganganagar';

update mgsr_user set areaid=52 where address='Netewala Sri Ganganagar';
update mgsr_user set areaid=36 where address='Pooja colony ,SGNR';
update mgsr_user set areaid=36 where address='Pooja colony,SGNR';
update mgsr_user set areaid=9 where address='RCS  trailers Kanpur Road Sri Ganganagar';
update mgsr_user set areaid=9 where address='RCS trailers Kanpur Road Sri Ganganagar';
update mgsr_user set areaid=19 where address='Saduwali Sri Ganganagar';
update mgsr_user set areaid=107 where address='Satguru Colony';
update mgsr_user set areaid=107 where address='Satguru colony, Sri Ganganagar';
update mgsr_user set areaid=17 where address='Satia Farm Sri Ganganagar';
update mgsr_user set areaid=17 where address='Setia Colony Sri Ganganagar';
update mgsr_user set areaid=106 where address='Shakti Nagar Sri Ganganagar';
update mgsr_user set areaid=106 where address='Shakti Nagar ward number 3 Sri Ganganagar';
update mgsr_user set areaid=76 where address='SHYAM NAGAR, SRI GANGANAGAR';
update mgsr_user set areaid=76 where address='SHYAM NAGAR,SRI GANGANAGAR';
update mgsr_user set areaid=18 where address='V.P.O. KALIYAN, SRI GANGANAGAR';
update mgsr_user set areaid=44 where address='Village 7o Colony Sri Karanpur';
update mgsr_user set areaid=8 where address='Ward number 3 purani Abadi Sri Ganganagar';
update mgsr_user set areaid=52 where address='नेतेवाला';


update mgsr_user set areaid=108 where address='पटवारी कॉलोनी(ठाकरांवाली)';
update mgsr_user set areaid=13 where address='बख्तावाली ';
update mgsr_user set areaid=19 where address='साधुवाली श्री गंगानगर';
update mgsr_user set areaid=19 where address='साधुवाली श्रीगंगानगर ';

update mgsr_user set areaid=73 where id in (75,   82,   93,  668,  682,  686, 2183, 2203, 2204, 2205, 2206, 2218, 2261, 2290, 2291, 2292, 2293, 2294, 2295, 2296);



="update mgsr_user set areaid="&C2&" where address='"&B2&"';"
="update mgsr_user set genderid="&C2&" where id="&A2&";"


insert into mgsr_area_list values (96, 'sgnr_gandi_nagar', 'Gandi Nagar', 1, 1, now(), 1, now(), 1);
insert into mgsr_area_list values (97, 'sgnr_11lnp_bhatta_colony', '11 LNP - Bhatta Colony', 1, 1, now(), 1, now(), 1);
insert into mgsr_area_list values (98, 'sgnr_16ml_khayaliwala', '16 ML - Khayaliwala', 1, 1, now(), 1, now(), 1);
insert into mgsr_area_list values (99, 'sgnr_17ml_inderlok_city', '17 ML - Inderlok City', 1, 1, now(), 1, now(), 1);
insert into mgsr_area_list values (100, 'sgnr_1ml', '1 ML', 1, 1, now(), 1, now(), 1);
insert into mgsr_area_list values (101, 'sgnr_3z', '3 Z', 1, 1, now(), 1, now(), 1);
insert into mgsr_area_list values (102, 'sgnr_7e', '7 E', 1, 1, now(), 1, now(), 1);
insert into mgsr_area_list values (103, 'sgnr_9lnp', '9 LNP', 1, 1, now(), 1, now(), 1);
insert into mgsr_area_list values (104, 'sgnr_9z', '9 Z', 1, 1, now(), 1, now(), 1);
insert into mgsr_area_list values (105, 'sgnr_6z', '6 Z', 1, 1, now(), 1, now(), 1);
insert into mgsr_area_list values (106, 'sgnr_shakti_nagar', 'Shakti Nagar', 1, 1, now(), 1, now(), 1);
insert into mgsr_area_list values (107, 'sgnr_satguru_colony', 'Satguru Colony', 1, 1, now(), 1, now(), 1);
insert into mgsr_area_list values (108, 'sgnr_patwari_colony', 'Patwari Colony', 1, 1, now(), 1, now(), 1);


update mgsr_area_list set code = 'sgnr_bakatawali', value='Bakatawali' where id = 13;
update mgsr_area_list set code = 'sgnr_2ml_nathawala_nahru_colony', value='2ml - Nathawala - Nahru Colony' where id = 86;





update mgsr_user set mobilenumber1='9999999999' where mobilenumber1 is null;

update mgsr_user set genderid=2 where id=2;
update mgsr_user set genderid=1 where id=4;
update mgsr_user set genderid=1 where id=5;
update mgsr_user set genderid=1 where id=8;
update mgsr_user set genderid=1 where id=9;
update mgsr_user set genderid=1 where id=11;
update mgsr_user set genderid=1 where id=14;
update mgsr_user set genderid=1 where id=15;
update mgsr_user set genderid=1 where id=16;
update mgsr_user set genderid=1 where id=18;
update mgsr_user set genderid=1 where id=19;
update mgsr_user set genderid=1 where id=20;
update mgsr_user set genderid=1 where id=21;
update mgsr_user set genderid=1 where id=22;
update mgsr_user set genderid=1 where id=24;
update mgsr_user set genderid=1 where id=25;
update mgsr_user set genderid=1 where id=26;
update mgsr_user set genderid=1 where id=27;
update mgsr_user set genderid=1 where id=28;
update mgsr_user set genderid=1 where id=29;
update mgsr_user set genderid=1 where id=30;
update mgsr_user set genderid=1 where id=33;
update mgsr_user set genderid=1 where id=34;
update mgsr_user set genderid=1 where id=35;
update mgsr_user set genderid=1 where id=36;
update mgsr_user set genderid=1 where id=37;
update mgsr_user set genderid=1 where id=38;
update mgsr_user set genderid=1 where id=39;
update mgsr_user set genderid=1 where id=42;
update mgsr_user set genderid=1 where id=47;
update mgsr_user set genderid=1 where id=48;
update mgsr_user set genderid=1 where id=49;
update mgsr_user set genderid=1 where id=50;
update mgsr_user set genderid=1 where id=51;
update mgsr_user set genderid=1 where id=52;
update mgsr_user set genderid=1 where id=59;
update mgsr_user set genderid=1 where id=60;
update mgsr_user set genderid=1 where id=61;
update mgsr_user set genderid=1 where id=62;
update mgsr_user set genderid=1 where id=63;
update mgsr_user set genderid=1 where id=64;
update mgsr_user set genderid=1 where id=65;
update mgsr_user set genderid=1 where id=66;
update mgsr_user set genderid=1 where id=67;
update mgsr_user set genderid=1 where id=70;
update mgsr_user set genderid=1 where id=71;
update mgsr_user set genderid=1 where id=72;
update mgsr_user set genderid=1 where id=75;
update mgsr_user set genderid=1 where id=77;
update mgsr_user set genderid=1 where id=78;
update mgsr_user set genderid=1 where id=80;
update mgsr_user set genderid=1 where id=82;
update mgsr_user set genderid=1 where id=83;
update mgsr_user set genderid=1 where id=84;
update mgsr_user set genderid=1 where id=85;
update mgsr_user set genderid=1 where id=86;
update mgsr_user set genderid=1 where id=87;
update mgsr_user set genderid=1 where id=89;
update mgsr_user set genderid=1 where id=90;
update mgsr_user set genderid=1 where id=93;
update mgsr_user set genderid=1 where id=94;
update mgsr_user set genderid=1 where id=95;
update mgsr_user set genderid=1 where id=97;
update mgsr_user set genderid=1 where id=100;
update mgsr_user set genderid=2 where id=102;
update mgsr_user set genderid=1 where id=103;
update mgsr_user set genderid=1 where id=104;
update mgsr_user set genderid=1 where id=105;
update mgsr_user set genderid=1 where id=106;
update mgsr_user set genderid=1 where id=2156;
update mgsr_user set genderid=1 where id=2157;
update mgsr_user set genderid=1 where id=2158;
update mgsr_user set genderid=1 where id=2159;
update mgsr_user set genderid=1 where id=2160;
update mgsr_user set genderid=1 where id=2161;
update mgsr_user set genderid=1 where id=2162;
update mgsr_user set genderid=1 where id=2163;
update mgsr_user set genderid=1 where id=2164;
update mgsr_user set genderid=1 where id=2165;
update mgsr_user set genderid=1 where id=2166;
update mgsr_user set genderid=1 where id=2167;
update mgsr_user set genderid=1 where id=2168;
update mgsr_user set genderid=1 where id=2169;
update mgsr_user set genderid=1 where id=2171;
update mgsr_user set genderid=1 where id=2172;
update mgsr_user set genderid=1 where id=2173;
update mgsr_user set genderid=1 where id=2174;
update mgsr_user set genderid=1 where id=2175;
update mgsr_user set genderid=1 where id=2176;
update mgsr_user set genderid=1 where id=2177;
update mgsr_user set genderid=1 where id=2179;
update mgsr_user set genderid=1 where id=2184;
update mgsr_user set genderid=1 where id=2185;
update mgsr_user set genderid=1 where id=2187;
update mgsr_user set genderid=1 where id=2188;
update mgsr_user set genderid=1 where id=2189;
update mgsr_user set genderid=1 where id=2190;
update mgsr_user set genderid=1 where id=2191;
update mgsr_user set genderid=1 where id=2192;
update mgsr_user set genderid=1 where id=2193;
update mgsr_user set genderid=1 where id=2194;
update mgsr_user set genderid=2 where id=2195;
update mgsr_user set genderid=1 where id=2196;
update mgsr_user set genderid=1 where id=2197;
update mgsr_user set genderid=1 where id=2198;
update mgsr_user set genderid=1 where id=2199;
update mgsr_user set genderid=1 where id=2200;
update mgsr_user set genderid=1 where id=2201;
update mgsr_user set genderid=1 where id=2202;
update mgsr_user set genderid=1 where id=2203;
update mgsr_user set genderid=1 where id=2204;
update mgsr_user set genderid=1 where id=2205;
update mgsr_user set genderid=1 where id=2206;
update mgsr_user set genderid=2 where id=2207;
update mgsr_user set genderid=1 where id=2208;
update mgsr_user set genderid=1 where id=2210;
update mgsr_user set genderid=1 where id=2211;
update mgsr_user set genderid=1 where id=2212;
update mgsr_user set genderid=1 where id=2213;
update mgsr_user set genderid=1 where id=2214;


/* date (2 june 2020) */
CREATE TABLE `mgsr_vahicale_common` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `VahicaleID` int(11) unsigned NOT NULL,
  `OwnerID` int(11) unsigned DEFAULT NULL,
  `DriverID` int(11) unsigned DEFAULT NULL,
  `StatusID` int(11) unsigned DEFAULT NULL,
  `CreatedAt` datetime NOT NULL,
  `CreatedBy` int(11) unsigned NOT NULL,
  `UpdatedAt` datetime NOT NULL,
  `UpdatedBy` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `mgsr_vahicale_common_CreatedBy_index_1` (`CreatedBy`) USING BTREE,
  KEY `mgsr_vahicale_common_UpdatedBy_index_2` (`UpdatedBy`) USING BTREE,
  KEY `mgsr_vahicale_common_StatusID_index_3` (`StatusID`) USING BTREE,
  KEY `mgsr_vahicale_common_VahicaleID_index_4` (`VahicaleID`) USING BTREE,
  KEY `mgsr_vahicale_common_OwnerID_index_5` (`OwnerID`) USING BTREE,
  KEY `mgsr_vahicale_common_DriverID_index_6` (`DriverID`) USING BTREE,
  CONSTRAINT `mgsr_vahicale_common_CreatedBy_ibfk_1` FOREIGN KEY (`CreatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_vahicale_common_UpdatedBy_ibfk_2` FOREIGN KEY (`UpdatedBy`) REFERENCES `admin_user` (`user_id`),
  CONSTRAINT `mgsr_vahicale_common_StatusID_ibfk_3` FOREIGN KEY (`StatusID`) REFERENCES `mgsr_status` (`ID`),
  CONSTRAINT `mgsr_vahicale_common_VahicaleID_ibfk_4` FOREIGN KEY (`VahicaleID`) REFERENCES `mgsr_vahicale` (`ID`),
  CONSTRAINT `mgsr_vahicale_common_OwnerID_ibfk_5` FOREIGN KEY (`OwnerID`) REFERENCES `mgsr_vahicale_owner` (`ID`),
  CONSTRAINT `mgsr_vahicale_common_DriverID_ibfk_6` FOREIGN KEY (`DriverID`) REFERENCES `mgsr_vahicale_driver` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;





alter table `mgsr_transport_consignment_note` add column `CommonID` int(11) unsigned default NULL after `Description`, add KEY `mgsr_transport_consignment_note_CommonID_index_10` (`CommonID`) USING BTREE, add CONSTRAINT `mgsr_transport_consignment_note_VahicaleOwnerID_ibfk_8` FOREIGN KEY (`CommonID`) REFERENCES `mgsr_vahicale_common` (`ID`);

alter table `mgsr_transport_consignment_note` add column `Advance` decimal(12,3) DEFAULT NULL after `ToPay`;

alter table `mgsr_transport_consignment_note` MODIFY `ToPaid` int(11) DEFAULT 0;
alter table `mgsr_transport_consignment_note` MODIFY `ToPay` int(11) DEFAULT 0;

insert into mgsr_vahicale_common (`ID`, `VahicaleID`, `OwnerID`, `DriverID`, `StatusID`, `CreatedAt`, `CreatedBy`, `UpdatedAt`, `UpdatedBy`) select id, id, null, null, 1, now(), 1, now(), 1 from mgsr_vahicale;


insert into `mgsr_vahicale_type` values(1, 'kanter14feet', 'Kanter 14 Feet', 1, now(), 1, now(), 1);
insert into `mgsr_vahicale_type` values(2, 'kanter17feet', 'Kanter 17 Feet', 1, now(), 1, now(), 1);
insert into `mgsr_vahicale_type` values(3, 'kanter19feet', 'Kanter 19 Feet', 1, now(), 1, now(), 1);
insert into `mgsr_vahicale_type` values(4, 'kanter22feet', 'Kanter 22 Feet', 1, now(), 1, now(), 1);
insert into `mgsr_vahicale_type` values(5, 'truck10tyre', 'Truck 10 Tyre', 1, now(), 1, now(), 1);
insert into `mgsr_vahicale_type` values(6, 'truck12tyre', 'Truck 12 Tyre', 1, now(), 1, now(), 1);
insert into `mgsr_vahicale_type` values(7, 'truck14tyre', 'Truck 14 Tyre', 1, now(), 1, now(), 1);
insert into `mgsr_vahicale_type` values(8, 'truck16tyre', 'Truck 16 Tyre', 1, now(), 1, now(), 1);
insert into `mgsr_vahicale_type` values(9, 'godha4018', 'Godha 4018', 1, now(), 1, now(), 1);
insert into `mgsr_vahicale_type` values(10, 'godha4923', 'Godha 4923', 1, now(), 1, now(), 1);


alter table `mgsr_transport_consignment_note` add column `Rate` decimal(12,3) DEFAULT NULL after `TotalWeight`;


alter table `mgsr_transport_consignment_note` add column `OwnerName` varchar(100) DEFAULT NULL after `VahicaleOwnerID`;
alter table `mgsr_transport_consignment_note` add column `OwnerMobileNo` varchar(20) DEFAULT NULL after `OwnerName`;
alter table `mgsr_transport_consignment_note` add column `DriverName` varchar(100) DEFAULT NULL after `OwnerMobileNo`;
alter table `mgsr_transport_consignment_note` add column `DriverMobileNo` varchar(20) DEFAULT NULL after `DriverName`; 
    
       

alter table `mgsr_transport_consignment_note` add column `ConsignmentDate` datetime NOT NULL after `ConsignmentNo`, add KEY `mgsr_transport_consignment_note_ConsignmentDate_index_11` (`ConsignmentDate`) USING BTREE;



alter table `mgsr_transport_consignment_note` add column `InvoiceNo` varchar(100) DEFAULT NULL after `StatusID`;
alter table `mgsr_transport_consignment_note` add column `HsnCode` varchar(100) DEFAULT NULL after `InvoiceNo`;
alter table `mgsr_transport_consignment_note` add column `HsnValue` varchar(100) DEFAULT NULL after `HsnCode`;
alter table `mgsr_transport_consignment_note` add column `EwayBillNo` varchar(100) DEFAULT NULL after `HsnValue`;
alter table `mgsr_transport_consignment_note` add column `EwayBillExpiryDate` datetime DEFAULT NULL after `EwayBillNo`;
alter table `mgsr_transport_consignment_note` add column `DeliveryAt` varchar(100) DEFAULT NULL after `EwayBillExpiryDate`;
alter table `mgsr_transport_consignment_note` add column `GrNo` varchar(100) DEFAULT NULL after `DeliveryAt`;



alter table `mgsr_transport_consignment_note` drop column `GrNo`;
alter table `mgsr_transport_consignment_note` drop column `HsnValue`;



alter table `mgsr_transport_consignment_note` add column `Remarks` text DEFAULT NULL after `Description`;
alter table `mgsr_transport_consignment_note` add column `SourceCityName`  varchar(100) DEFAULT NULL after `SourceCityID`;
alter table `mgsr_transport_consignment_note` add column `DestinationCityName` varchar(100) DEFAULT NULL after `DestinationCityID`;
alter table `mgsr_transport_consignment_note` add column `ValueOfGoods` decimal(12,3) DEFAULT NULL after `Balance`;
alter table `mgsr_transport_consignment_note` add column `BillingStation`  varchar(100) DEFAULT NULL after `SourceCityName`;


alter table `mgsr_transport_consignment_note` add column `TBB` int(11) DEFAULT 0 after `ToPay`;

/* DATE 03-11-2020 */
CREATE TABLE `mgsr_blood_group` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Value` varchar(50) DEFAULT NULL,
  `Code` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into `mgsr_blood_group` values (1, 'A+', 'A+');
insert into `mgsr_blood_group` values (2, 'A-', 'A-');
insert into `mgsr_blood_group` values (3, 'B+', 'B+');
insert into `mgsr_blood_group` values (4, 'B-', 'B-');
insert into `mgsr_blood_group` values (5, 'AB+', 'AB+');
insert into `mgsr_blood_group` values (6, 'AB-', 'AB-');
insert into `mgsr_blood_group` values (7, 'O+', 'O+');
insert into `mgsr_blood_group` values (8, 'O-', 'O-');


alter table `mgsr_user` add column `BloodGroupID` int(11) unsigned DEFAULT NULL after `GenderID`;
alter table `mgsr_user` add KEY `mgsr_user_BloodGroupID_index_01` (`BloodGroupID`) USING BTREE;
alter table `mgsr_user` add CONSTRAINT `mgsr_user_BloodGroupID_ibfk_01` FOREIGN KEY (`BloodGroupID`) REFERENCES `mgsr_blood_group` (`ID`);
alter table `mgsr_user` add column `IsStpEligible` int(11) DEFAULT 0 after `BloodGroupID`; 

insert into mgsr_donation_type values (30, 'Blood', 'mgsr/common/images/donationtype/blood.png', 1, now(), 1, now(), 1);
insert into mgsr_donation_type values (31, 'Blood STP', 'mgsr/common/images/donationtype/blood.png', 1, now(), 1, now(), 1);

update mgsr_donation_type set value = 'Blood SDP' where id = 31;


/* DATE 16-01-2021 */
alter table `student_registration` add column `ProgrammeID` int(11) unsigned DEFAULT NULL, add KEY `mgsr_student_registration_ProgrammeID_index_01` (`ProgrammeID`) USING BTREE, add CONSTRAINT `mgsr_student_registration_ProgrammeID_ibfk_01` FOREIGN KEY (`ProgrammeID`) REFERENCES `mgsr_programme` (`ID`);


alter table `student_registration` add column `UserID` int(11) unsigned DEFAULT NULL, add KEY `mgsr_student_registration_UserID_index_02` (`UserID`) USING BTREE, add CONSTRAINT `mgsr_student_registration_UserID_ibfk_02` FOREIGN KEY (`UserID`) REFERENCES `mgsr_user` (`ID`);


update student_registration set programmeid = 11 where date(CreatedAt) > '2020-12-01';


scp aapnicuc@96.125.162.36:/home2/aapnicuc/public_html/mgsr/app/code/local/Margshri/WebPortal/Block/Backend/Registration/Registration/
