-- -----------------------------
-- MySQL Data Transfer 
-- 
-- servername     : localhost
-- Database       : shopping
-- 
-- Date : 2020-12-03 23:41:37
-- -----------------------------

SET FOREIGN_KEY_CHECKS = 0;

-- -----------------------------
-- Table structure for `category`
-- -----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- -----------------------------
-- Records of `category`
-- -----------------------------
INSERT INTO `category`(`id`,`name`) VALUES('4','Buckets');
INSERT INTO `category`(`id`,`name`) VALUES('1','Classical');
INSERT INTO `category`(`id`,`name`) VALUES('3','Straw');
INSERT INTO `category`(`id`,`name`) VALUES('2','Wools');

-- -----------------------------
-- Table structure for `item`
-- -----------------------------
DROP TABLE IF EXISTS `item`;
CREATE TABLE `item` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `categoryID` int NOT NULL,
  `price` double NOT NULL DEFAULT '129',
  `stock` int NOT NULL DEFAULT '20',
  `img` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '1.jpg',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `categoryID` (`categoryID`),
  CONSTRAINT `categoryID` FOREIGN KEY (`categoryID`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- -----------------------------
-- Records of `item`
-- -----------------------------
INSERT INTO `item`(`id`,`name`,`categoryID`,`price`,`stock`,`img`) VALUES('1','Pendants','3','129','17','1606953577.jpg');
INSERT INTO `item`(`id`,`name`,`categoryID`,`price`,`stock`,`img`) VALUES('12','The Beverly','1','129','20','1606953618.jpg');
INSERT INTO `item`(`id`,`name`,`categoryID`,`price`,`stock`,`img`) VALUES('13','Val Diamond','1','250','20','1606953675.jpg');
INSERT INTO `item`(`id`,`name`,`categoryID`,`price`,`stock`,`img`) VALUES('14','Ivory Rancher','1','129','18','1606953730.jpg');
INSERT INTO `item`(`id`,`name`,`categoryID`,`price`,`stock`,`img`) VALUES('17','Zulu Rancher','1','129','19','1606953766.jpg');
INSERT INTO `item`(`id`,`name`,`categoryID`,`price`,`stock`,`img`) VALUES('19','Inca Bucket','3','219','19','1606953796.jpg');
INSERT INTO `item`(`id`,`name`,`categoryID`,`price`,`stock`,`img`) VALUES('20','Noir Rancher','4','129','20','1606953833.jpeg');
INSERT INTO `item`(`id`,`name`,`categoryID`,`price`,`stock`,`img`) VALUES('21','Carlo Rancher','2','129','20','1606953888.jpeg');
INSERT INTO `item`(`id`,`name`,`categoryID`,`price`,`stock`,`img`) VALUES('22','The Sierra','2','129','20','1606953924.jpeg');
INSERT INTO `item`(`id`,`name`,`categoryID`,`price`,`stock`,`img`) VALUES('23','Celestial Boater','4','129','20','1606953947.jpeg');
INSERT INTO `item`(`id`,`name`,`categoryID`,`price`,`stock`,`img`) VALUES('24','Seaside Boater','1','219','20','1606953986.jpeg');
INSERT INTO `item`(`id`,`name`,`categoryID`,`price`,`stock`,`img`) VALUES('25','Tri - Beige','4','129','20','1606961264.jpg');

-- -----------------------------
-- Table structure for `orderdetail`
-- -----------------------------
DROP TABLE IF EXISTS `orderdetail`;
CREATE TABLE `orderdetail` (
  `orderID` int NOT NULL,
  `itemID` int NOT NULL,
  `quantity` int NOT NULL,
  KEY `orderID` (`orderID`),
  KEY `itemID` (`itemID`),
  CONSTRAINT `itemID` FOREIGN KEY (`itemID`) REFERENCES `item` (`id`),
  CONSTRAINT `orderID` FOREIGN KEY (`orderID`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- -----------------------------
-- Records of `orderdetail`
-- -----------------------------
INSERT INTO `orderdetail`(`orderID`,`itemID`,`quantity`) VALUES('23','1','1');
INSERT INTO `orderdetail`(`orderID`,`itemID`,`quantity`) VALUES('24','13','3');
INSERT INTO `orderdetail`(`orderID`,`itemID`,`quantity`) VALUES('25','1','3');
INSERT INTO `orderdetail`(`orderID`,`itemID`,`quantity`) VALUES('26','1','2');
INSERT INTO `orderdetail`(`orderID`,`itemID`,`quantity`) VALUES('27','13','2');
INSERT INTO `orderdetail`(`orderID`,`itemID`,`quantity`) VALUES('28','17','1');
INSERT INTO `orderdetail`(`orderID`,`itemID`,`quantity`) VALUES('28','14','1');
INSERT INTO `orderdetail`(`orderID`,`itemID`,`quantity`) VALUES('29','12','18');
INSERT INTO `orderdetail`(`orderID`,`itemID`,`quantity`) VALUES('30','12','3');
INSERT INTO `orderdetail`(`orderID`,`itemID`,`quantity`) VALUES('31','12','19');
INSERT INTO `orderdetail`(`orderID`,`itemID`,`quantity`) VALUES('32','12','20');
INSERT INTO `orderdetail`(`orderID`,`itemID`,`quantity`) VALUES('35','14','1');
INSERT INTO `orderdetail`(`orderID`,`itemID`,`quantity`) VALUES('36','19','1');

-- -----------------------------
-- Table structure for `orders`
-- -----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `orderTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'Waiting fo',
  `total` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`),
  CONSTRAINT `userID` FOREIGN KEY (`userID`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

-- -----------------------------
-- Records of `orders`
-- -----------------------------
INSERT INTO `orders`(`id`,`userID`,`orderTime`,`status`,`total`) VALUES('23','11','2020-12-02 00:22:30','Waiting fo','900');
INSERT INTO `orders`(`id`,`userID`,`orderTime`,`status`,`total`) VALUES('24','11','2020-12-02 00:22:56','Waiting fo','290.25');
INSERT INTO `orders`(`id`,`userID`,`orderTime`,`status`,`total`) VALUES('25','11','2020-12-02 00:29:46','Waiting fo','2700');
INSERT INTO `orders`(`id`,`userID`,`orderTime`,`status`,`total`) VALUES('26','11','2020-12-02 00:32:12','Waiting fo','1800');
INSERT INTO `orders`(`id`,`userID`,`orderTime`,`status`,`total`) VALUES('27','11','2020-12-02 02:50:23','Waiting fo','375');
INSERT INTO `orders`(`id`,`userID`,`orderTime`,`status`,`total`) VALUES('28','11','2020-12-02 02:50:56','Waiting fo','193.5');
INSERT INTO `orders`(`id`,`userID`,`orderTime`,`status`,`total`) VALUES('29','11','2020-12-02 02:51:33','Waiting fo','1741.5');
INSERT INTO `orders`(`id`,`userID`,`orderTime`,`status`,`total`) VALUES('30','11','2020-12-02 02:51:54','Waiting fo','290.25');
INSERT INTO `orders`(`id`,`userID`,`orderTime`,`status`,`total`) VALUES('31','11','2020-12-02 02:56:41','Delivered','1838.25');
INSERT INTO `orders`(`id`,`userID`,`orderTime`,`status`,`total`) VALUES('32','11','2020-12-02 03:14:21','Waiting for shipment','1935');
INSERT INTO `orders`(`id`,`userID`,`orderTime`,`status`,`total`) VALUES('35','11','2020-12-02 10:09:52','Waiting fo','96.75');
INSERT INTO `orders`(`id`,`userID`,`orderTime`,`status`,`total`) VALUES('36','11','2020-12-02 10:09:56','Waiting fo','96.75');

-- -----------------------------
-- Table structure for `user`
-- -----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'sophieSu@mail.com',
  `phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '8130000000',
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '13123 thomasville circle',
  `type` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'user',
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'enabled',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

-- -----------------------------
-- Records of `user`
-- -----------------------------
INSERT INTO `user`(`id`,`name`,`password`,`email`,`phone`,`address`,`type`,`status`) VALUES('1','admin','admin','adminzhang@mail.com','8134532896','13123 thomasville circle','admin','enabled');
INSERT INTO `user`(`id`,`name`,`password`,`email`,`phone`,`address`,`type`,`status`) VALUES('11','eve','123456','evezhang111@mail.com','8130034007','13123 thomasville circle','user','enabled');
INSERT INTO `user`(`id`,`name`,`password`,`email`,`phone`,`address`,`type`,`status`) VALUES('12','adamwu','adam123','adamwu@mail.com','7548629000','13123 thomasville circle','user','enabled');
INSERT INTO `user`(`id`,`name`,`password`,`email`,`phone`,`address`,`type`,`status`) VALUES('13','yiwe','Qiusdhu7hsdu','jimmyLi@mail.com','8130000000','13123 thomasville circle','user','disabled');
INSERT INTO `user`(`id`,`name`,`password`,`email`,`phone`,`address`,`type`,`status`) VALUES('14','Lucy','We1654','jimmyLi@mail.com','8130000000','13123 thomasville circle','user','enabled');
INSERT INTO `user`(`id`,`name`,`password`,`email`,`phone`,`address`,`type`,`status`) VALUES('15','AUdray','Jdos265416','sophieSu@mail.com','8130000000','13123 thomasville circle','user','enabled');
INSERT INTO `user`(`id`,`name`,`password`,`email`,`phone`,`address`,`type`,`status`) VALUES('16','Ling','Afsf235165','sophieSu@mail.com','8130000000','13123 thomasville circle','user','enabled');
INSERT INTO `user`(`id`,`name`,`password`,`email`,`phone`,`address`,`type`,`status`) VALUES('17','Jim','fsdjiU5','sophieSu@mail.com','8130000000','13123 thomasville circle','user','enabled');
INSERT INTO `user`(`id`,`name`,`password`,`email`,`phone`,`address`,`type`,`status`) VALUES('18','Tdso','afwrE15','sophieSu@mail.com','8130000000','13123 thomasville circle','user','enabled');
INSERT INTO `user`(`id`,`name`,`password`,`email`,`phone`,`address`,`type`,`status`) VALUES('19','qiang','seji98E','jimmyLi@mail.com','8130000000','13123 thomasville circle','user','enabled');
INSERT INTO `user`(`id`,`name`,`password`,`email`,`phone`,`address`,`type`,`status`) VALUES('24','daqiang00','Dadmoif5846','jimmyLi@mail.com','8130000000','13123 thomasville circle','user','enabled');
INSERT INTO `user`(`id`,`name`,`password`,`email`,`phone`,`address`,`type`,`status`) VALUES('36','rewre','Aa456456','jimmyLi@mail.com','8130000000','13123 thomasville circle','user','enabled');
