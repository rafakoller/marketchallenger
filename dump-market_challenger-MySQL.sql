-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: market_challenger
-- ------------------------------------------------------
-- Server version	8.0.31

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb3 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb3 */;
CREATE TABLE `order` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `created_at` datetime NOT NULL,
  UNIQUE KEY `order_id_IDX` (`id`) USING BTREE,
  KEY `order_user_id_IDX` (`user_id`) USING BTREE,
  CONSTRAINT `order_FK` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` VALUES (44,8,'2023-05-05 22:05:37'),(45,9,'2023-05-05 23:16:42'),(46,8,'2023-05-12 23:41:26'),(47,10,'2023-05-15 23:44:20'),(48,8,'2023-05-15 23:46:32'),(49,8,'2023-05-15 23:46:45'),(50,9,'2023-05-20 23:47:07'),(51,8,'2023-05-20 23:47:20'),(52,10,'2023-05-25 23:47:40'),(53,8,'2023-05-25 23:48:04'),(54,8,'2023-05-29 23:53:57'),(55,8,'2023-05-29 23:54:14'),(56,8,'2023-05-29 23:55:12');
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_products`
--

DROP TABLE IF EXISTS `order_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb3 */;
CREATE TABLE `order_products` (
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `qnt` int NOT NULL,
  `valprod` decimal(10,4) NOT NULL,
  `valtax` decimal(10,4) NOT NULL,
  KEY `order_products_order_id_IDX` (`order_id`) USING BTREE,
  KEY `order_products_product_id_IDX` (`product_id`) USING BTREE,
  CONSTRAINT `order_products_FK` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `order_products_FK_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_products`
--

LOCK TABLES `order_products` WRITE;
/*!40000 ALTER TABLE `order_products` DISABLE KEYS */;
INSERT INTO `order_products` VALUES (44,15,1,3.2929,0.2605),(44,9,2,5.4456,0.4307),(44,8,1,7.6362,0.6040),(44,7,2,5.3534,0.4235),(44,24,1,92.4984,20.7474),(44,26,1,128.2245,28.7608),(44,28,2,3.1048,0.2027),(44,21,1,70.0191,12.7785),(44,19,2,836.7850,52.2991),(44,34,1,113.2396,25.7620),(44,33,2,57.7529,13.1388),(45,17,1,2.7125,0.2146),(45,12,2,3.3036,0.2613),(45,8,1,7.6362,0.6040),(45,23,1,58.8634,13.2031),(45,27,2,66.8096,14.9854),(45,26,1,128.2245,28.7608),(45,29,1,9.1241,0.5958),(45,5,2,0.9182,0.0600),(45,28,1,3.1048,0.2027),(46,34,1,113.2396,25.7620),(46,32,2,93.7188,21.3210),(46,31,1,19.6105,4.4614),(47,18,1,3.7102,0.2935),(47,12,1,3.3036,0.2613),(47,26,3,128.2245,28.7608),(47,24,1,92.4984,20.7474),(47,28,1,3.1048,0.2027),(47,5,1,0.9182,0.0600),(47,22,1,3.0397,0.5547),(47,35,1,1.9383,0.4410),(47,30,1,3.3649,0.7655),(47,19,1,836.7850,52.2991),(47,1,1,15.1325,1.9476),(47,2,1,11.3914,1.4661),(48,15,1,3.2929,0.2605),(48,7,1,5.3534,0.4235),(48,9,1,5.4456,0.4307),(49,23,3,58.8634,13.2031),(49,27,1,66.8096,14.9854),(50,28,1,3.1048,0.2027),(50,29,1,9.1241,0.5958),(50,21,2,70.0191,12.7785),(51,34,1,113.2396,25.7620),(51,33,1,57.7529,13.1388),(51,32,1,93.7188,21.3210),(52,31,1,19.6105,4.4614),(52,35,1,1.9383,0.4410),(52,30,1,3.3649,0.7655),(52,34,1,113.2396,25.7620),(53,1,1,15.1325,1.9476),(53,32,1,93.7188,21.3210),(54,26,1,128.2245,28.7608),(54,23,1,58.8634,13.2031),(54,33,1,57.7529,13.1388),(55,17,1,2.7125,0.2146),(55,11,1,3.2828,0.2597),(55,10,1,3.5886,0.2839),(56,19,1,836.7850,52.2991),(56,32,1,93.7188,21.3210),(56,34,2,113.2396,25.7620),(56,21,2,70.0191,12.7785);
/*!40000 ALTER TABLE `order_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb3 */;
CREATE TABLE `product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `type_id` int NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `profit` decimal(10,2) NOT NULL,
  `img` varchar(200) NOT NULL,
  UNIQUE KEY `product_id_IDX` (`id`) USING BTREE,
  KEY `product_type_id_IDX` (`type_id`) USING BTREE,
  CONSTRAINT `product_FK` FOREIGN KEY (`type_id`) REFERENCES `product_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,'Apple',14,12.35,22.53,'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT0Qbaf8fLd0hdRA2cwJXIQf2MbbaZTVeSORg&usqp=CAU'),(2,'Potato',14,8.42,35.29,'https://static1.conquistesuavida.com.br/ingredients/5/54/52/05/@/24682--ingredient_detail_ingredient-2.png'),(4,'Banana',14,18.23,22.95,'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ3DCCRo2Zt6k2Z2FqWBd68DBg4-yyGIdnULQ&usqp=CAU'),(5,'Peas',37,0.79,16.23,'https://2.wlimg.com/product_images/bc-full/2022/8/9665825/canned-green-peas-1659335688-6471469.jpeg'),(6,'Sliced Bread',33,1.48,6.52,'https://api.time.com/wp-content/uploads/2015/07/bread.jpeg'),(7,'White Bread',33,5.23,2.36,'https://hips.hearstapps.com/hmg-prod/images/types-of-bread-white-1666288634.jpg?crop=0.670xw:1.00xh;0.320xw,0&resize=980:*'),(8,'Whole Wheat Bread',33,7.32,4.32,'https://hips.hearstapps.com/hmg-prod/images/types-of-bread-whole-wheat-1666288669.jpg?crop=0.684xw:1.00xh;0.0397xw,0&resize=980:*'),(9,'Multigrain Bread',33,5.32,2.36,'https://hips.hearstapps.com/hmg-prod/images/types-of-bread-multigrain-1666288726.jpg?crop=0.668xw:1.00xh;0.219xw,0&resize=980:*'),(10,'Rye Bread',33,3.52,1.95,'https://hips.hearstapps.com/hmg-prod/images/types-of-bread-rye-1666288764.jpg?crop=0.668xw:1.00xh;0.0587xw,0&resize=980:*'),(11,'Sourdough Bread',33,3.24,1.32,'https://hips.hearstapps.com/hmg-prod/images/types-of-bread-sourdough-1666288865.jpg?crop=0.667xw:1.00xh;0.155xw,0&resize=980:*'),(12,'Pumpernickel Bread',33,3.25,1.65,'https://hips.hearstapps.com/hmg-prod/images/types-of-bread-pumpernickel-1666309745.jpg?crop=0.668xw:1.00xh;0.223xw,0&resize=980:*'),(13,'Baguette',33,3.54,0.52,'https://hips.hearstapps.com/hmg-prod/images/types-of-bread-baguette-1666309790.jpg?crop=0.668xw:1.00xh;0.168xw,0&resize=980:*'),(14,'Boule',33,5.32,0.52,'https://hips.hearstapps.com/hmg-prod/images/types-of-bread-boule-1666309830.jpg?crop=0.6672958942897593xw:1xh;center,top&resize=980:*'),(15,'Ciabatta',33,3.25,1.32,'https://hips.hearstapps.com/hmg-prod/images/types-of-bread-ciabatta-1666309870.jpg?crop=0.668xw:1.00xh;0.0950xw,0&resize=980:*'),(16,'Challah',33,6.25,2.36,'https://hips.hearstapps.com/hmg-prod/images/types-of-bread-challah-1666309910.jpg?crop=0.642xw:1.00xh;0.164xw,0&resize=980:*'),(17,'Brioche',33,2.65,2.36,'https://hips.hearstapps.com/hmg-prod/images/types-of-bread-brioche-1666309955.jpg?crop=0.668xw:1.00xh;0.154xw,0&resize=980:*'),(18,'Flatbread',33,3.65,1.65,'https://hips.hearstapps.com/hmg-prod/images/types-of-bread-flatbreads-1666309992.jpg?crop=0.71435546875xw:1xh;center,top&resize=980:*'),(19,'Lawn mower',35,725.62,15.32,'https://mobileimages.lowes.com/productimages/aa4f51ce-2442-4dd0-a066-56f556421e54/11470444.jpg'),(20,'Veja Heavy Clean',31,4.32,22.00,'https://images-reppos.ifcshop.com.br/produto/1047_1_20220209104752.jpg'),(21,'Caustic Acid',31,62.35,12.30,'https://cdn.awsli.com.br/800x800/1224/1224967/produto/1062550096cbb1fdf21.jpg'),(22,'Detergent',31,2.35,29.35,'https://diadistribuicao.agilecdn.com.br/10702_1.jpg'),(23,'Rib Steak',36,49.32,19.35,'https://media.cotabest.com.br/media/sku/rib-steak-resfriada-por-kg-chef-meat-kg.jfif'),(24,'Porterhouse',36,75.62,22.32,'https://media.istockphoto.com/id/855287610/photo/porterhouse-steak.jpg?s=170667a&w=0&k=20&c=5U9AHZyLydj8CEMD3uu8Y7Tg95s9gRSRBthjqEol8CA='),(25,'Short Loin',36,45.68,42.32,'https://cdn.shopify.com/s/files/1/0378/4858/0234/products/ShortLoin_1024x.png?v=1634319719'),(26,'Tenderloin',36,95.32,34.52,'https://www.kroger.com/product/images/large/front/0021220300000'),(27,'Strip Steak',36,45.35,47.32,'https://embed.widencdn.net/img/beef/sospeur0gf/exact/Strip%20Loin%20Steak_Bone%20In.jpg?keep=c&u=7fueml'),(28,'Peaches',37,2.35,32.12,'https://walkingonsunshinerecipes.com/wp-content/uploads/2021/03/FEATURED-Desserts-made-with-Canned-Peaches-Recipe-photo.jpg'),(29,'Beans',37,5.62,62.35,'https://i2-prod.mylondon.news/incoming/article21579755.ece/ALTERNATES/s1200b/1_Baked-beans-spilling-out-of-a-tin-can.jpg'),(30,'Kingfisher Lager Beer',29,2.75,22.36,'https://www.spencers.in/media/catalog/product/1/1/1193105.jpg'),(31,'Lone Star 6-pack',29,15.95,22.95,'https://www.colonialspirits.com/wp-content/uploads/2016/01/Lone-Star-Beer-6-bottles.jpg'),(32,'Jack Daniel`s',29,78.61,19.22,'https://dkolopwjqarcp.cloudfront.net/Custom/Content/Products/06/84/0684_jack-daniels-old-n-7-whisky-1l_z1_637659327154111569.jpg'),(33,'Old Parr',29,49.65,16.32,'https://www.focomix.com.br/media/catalog/product/5/0/5000281003160_1.jpg?quality=80&bg-color=255,255,255&fit=bounds&height=700&width=700&canvas=700:700'),(34,'Absolut Vodka',29,92.35,22.62,'https://superadega.vteximg.com.br/arquivos/ids/170982-1000-1000/Vodka-Absolut-Natural-1L.jpg?v=637775923203930000'),(35,'Coca Cola Ks',29,1.62,19.65,'https://www.bistek.com.br/media/catalog/product/cache/3d8b1eb10e2235e6c16b8d8d169667e5/1/9/1924427.jpg');
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_type`
--

DROP TABLE IF EXISTS `product_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb3 */;
CREATE TABLE `product_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(100) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `img` varchar(200) DEFAULT NULL,
  UNIQUE KEY `product_type_id_IDX` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_type`
--

LOCK TABLES `product_type` WRITE;
/*!40000 ALTER TABLE `product_type` DISABLE KEYS */;
INSERT INTO `product_type` VALUES (14,'Vegetables',12.87,'https://guardian.ng/wp-content/uploads/2019/05/Fruit-Mix-by-LIKE-TOPIC.png'),(15,'Utensils',9.18,'https://m.media-amazon.com/images/S/aplus-media/sota/9e576fcb-8b64-45e5-994a-d3d0aa96e756.__CR0,0,700,700_PT0_SX300_V1___.jpg'),(29,'Drinks',22.75,'https://coca-colafemsa.com/wp-content/uploads/2019/12/reflejo_pag1-1024x794.png'),(30,'Portion',8.23,'https://www.stumpsandrumps.com/wp-content/uploads/2021/08/Properly-Feed-Dog-2.jpg'),(31,'Cleaning',18.25,'https://www.chalcot.com/wp-content/uploads/2019/02/House-Cleaning-Services.jpg'),(32,'Hygiene',6.42,'https://cdn.cdnparenting.com/articles/2018/02/18113745/Article-4-Good-Hygiene-Habits.jpg'),(33,'Bakery',7.91,'https://popmenucloud.com/cdn-cgi/image/width%3D1200%2Cheight%3D1200%2Cfit%3Dscale-down%2Cformat%3Dauto%2Cquality%3D60/fcqtnvdk/200861c9-6e86-46a2-b4c4-d97dd32e96e7.jpg'),(34,'Tools',5.68,'https://cdn.shopify.com/s/files/1/0438/5642/9219/articles/IM0021485-removebg-preview_1_1024x1024.png?v=1636970011'),(35,'Gardening',6.25,'https://i.guim.co.uk/img/media/ef96c1f2495b60ec83379962d4aec38bfb1ce039/0_187_5600_3363/master/5600.jpg?width=1200&height=900&quality=85&auto=format&fit=crop&s=a96e7cb435ac3a89558b8315d39c068d'),(36,'Butcher`s',22.43,'https://samsclub.vtexassets.com/arquivos/ids/164301/20218300000.jpg?v=1771319333'),(37,'Canned',6.53,'https://www.tastingtable.com/img/gallery/why-its-a-bad-idea-to-store-leftover-canned-food-in-the-original-can/l-intro-1652126138.jpg');
/*!40000 ALTER TABLE `product_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase`
--

DROP TABLE IF EXISTS `purchase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb3 */;
CREATE TABLE `purchase` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `qnt` int NOT NULL,
  `supplier` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  UNIQUE KEY `purchase_id_IDX` (`id`) USING BTREE,
  KEY `purchase_product_id_IDX` (`product_id`) USING BTREE,
  KEY `purchase_user_id_IDX` (`user_id`) USING BTREE,
  CONSTRAINT `purchase_FK` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `purchase_FK_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase`
--

LOCK TABLES `purchase` WRITE;
/*!40000 ALTER TABLE `purchase` DISABLE KEYS */;
INSERT INTO `purchase` VALUES (6,8,6,58,'NF-0342 - Fresh Bread Bakery LTDA','2023-05-26 01:16:45'),(7,8,7,52,'NF-0342 - Fresh Bread Bakery LTDA','2023-05-26 01:25:12'),(8,8,11,23,'NF-0342 - Fresh Bread Bakery LTDA','2023-05-26 01:25:27'),(9,8,10,32,'NF-0342 - Fresh Bread Bakery LTDA','2023-05-26 01:25:40'),(10,8,12,54,'NF-0342 - Fresh Bread Bakery LTDA','2023-05-26 01:25:53'),(11,8,8,43,'NF-0342 - Fresh Bread Bakery LTDA','2023-05-26 01:26:11'),(12,8,5,15,'NF-0342 - Fresh Bread Bakery LTDA','2023-05-26 01:32:18'),(13,8,9,62,'NF-0342 - Fresh Bread Bakery LTDA','2023-05-26 01:32:30'),(14,8,17,75,'NF-0342 - Fresh Bread Bakery LTDA','2023-05-26 01:32:50'),(15,8,15,34,'NF-0342 - Fresh Bread Bakery LTDA','2023-05-26 01:34:19'),(16,8,18,22,'NF-0342 - Fresh Bread Bakery LTDA','2023-05-26 01:34:31'),(17,8,19,52,'NF 342 - Garden e Cia','2023-05-28 14:30:35'),(18,8,21,432,'Quimic and Nature ','2023-05-28 21:35:55'),(19,8,26,75,'NF345 - Seu Chico Farm','2023-05-29 11:45:59'),(20,8,25,65,'NF345 - Seu Chico Farm','2023-05-29 11:46:24'),(21,8,23,87,'NF345 - Seu Chico Farm','2023-05-29 11:46:50'),(22,8,24,52,'NF345 - Seu Chico Farm','2023-05-29 11:47:55'),(23,8,27,65,'NF345 - Seu Chico Farm','2023-05-29 12:53:18'),(24,8,28,75,'NF532 - Sonia Farm','2023-05-29 12:57:46'),(25,8,29,65,'NF532 - Sonia Farm','2023-05-29 13:00:51'),(26,8,22,76,'NF943 - Big Wholesale','2023-05-29 13:02:40'),(27,8,33,34,'NF512 - Drops and Drinks Corp','2023-05-29 19:34:57'),(28,8,34,75,'NF512 - Drops and Drinks Corp','2023-05-29 19:35:11'),(29,8,35,400,'NF512 - Drops and Drinks Corp','2023-05-29 19:35:39'),(30,8,32,23,'NF512 - Drops and Drinks Corp','2023-05-29 19:35:58'),(31,8,30,18,'NF512 - Drops and Drinks Corp','2023-05-29 19:36:16'),(32,8,31,45,'NF512 - Drops and Drinks Corp','2023-05-29 19:36:49');
/*!40000 ALTER TABLE `purchase` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock`
--

DROP TABLE IF EXISTS `stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb3 */;
CREATE TABLE `stock` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `stock` int NOT NULL,
  KEY `stock_product_id_IDX` (`product_id`) USING BTREE,
  KEY `stock_id_IDX` (`id`) USING BTREE,
  CONSTRAINT `stock_FK` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock`
--

LOCK TABLES `stock` WRITE;
/*!40000 ALTER TABLE `stock` DISABLE KEYS */;
INSERT INTO `stock` VALUES (1,2,4991),(2,1,3485),(3,4,0),(4,5,0),(5,6,0),(6,7,47),(7,8,38),(8,9,59),(9,10,28),(10,11,21),(11,12,48),(12,13,0),(13,14,0),(14,15,27),(15,16,0),(16,17,64),(17,18,9),(18,19,38),(19,20,0),(20,21,423),(21,22,72),(22,23,80),(23,24,49),(24,25,61),(25,26,63),(26,27,58),(27,28,61),(28,29,62),(29,30,6),(30,31,43),(31,32,17),(32,33,28),(33,34,68),(34,35,396);
/*!40000 ALTER TABLE `stock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb3 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb3 NOT NULL,
  `status` int NOT NULL,
  UNIQUE KEY `tb_user_id_IDX` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (8,'Rafael Henrique Koller','rafakoller','rafakoller@gmail.com','$2y$08$vS6KLtcjjpOZBJ35s1ND0uEpyNhFm3u77AztIH.2/1sMqRx.rIvVe',1),(9,'Fulano','fulano','fulano@dasilva.com.br','$2y$08$6j3pd9j2g6h0IdsPK0j./uQuaM9mvLk.F68DrQyzx/VcdWDu5cAga',0),(10,'Administrator','admin','admin@xip7.com.br','$2y$08$Jb6hyMCKIHVp7ZSfqpXtkOcLeDcp0skzY4V05P20wdwMTc7HbOm1i',1);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'market_challenger'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-05-30  0:34:29
