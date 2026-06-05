-- MySQL dump 10.13  Distrib 9.2.0, for Win64 (x86_64)
--
-- Host: localhost    Database: worklance
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Dumping data for table `booking`
--

LOCK TABLES `booking` WRITE;
/*!40000 ALTER TABLE `booking` DISABLE KEYS */;
INSERT INTO `booking` VALUES (1,2,1,'2026-04-05','Surabaya','Butuh cepat','SELESAI'),(2,3,2,'2026-04-06','Surabaya','Untuk usaha saya','DIPROSES'),(3,2,3,'2026-04-07','Surabaya','Elektronik rusak','SELESAI'),(4,3,5,'2026-04-08','Surabaya','Prewedding','SELESAI'),(5,2,7,'2026-04-09','Surabaya','Website toko online','MENUNGGU'),(6,8,9,'2026-04-10','Surabaya','Untuk bisnis online','MENUNGGU'),(7,9,10,'2026-04-11','Malang','Butuh cepat','DIPROSES'),(8,2,11,'2026-04-12','Sidoarjo','Untuk acara keluarga','SELESAI'),(9,2,1,'2026-04-13','Jl. Cempaka putih, no 14, Sidoarjo','Saya ingin logo untuk usaha UMKM saya','MENUNGGU');
/*!40000 ALTER TABLE `booking` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `desa`
--

LOCK TABLES `desa` WRITE;
/*!40000 ALTER TABLE `desa` DISABLE KEYS */;
INSERT INTO `desa` VALUES (1,1,'Keputih'),(2,1,'Gebang Putih'),(3,2,'Rungkut Tengah'),(4,2,'Kedung Baruk'),(5,3,'Dr. Soetomo'),(6,3,'Wonorejo'),(7,4,'Dinoyo'),(8,4,'Tlogomas'),(9,5,'Purwodadi'),(10,5,'Polowijen'),(11,6,'Kauman'),(12,6,'Sukoharjo'),(13,7,'Wedoro'),(14,7,'Tambak Oso'),(15,8,'Gelam'),(16,8,'Bligo'),(17,9,'Sepanjang'),(18,9,'Kedungturi'),(19,10,'Manyarejo'),(20,10,'Suci'),(21,11,'Petiken'),(22,11,'Bambe'),(23,12,'Sawahan'),(24,12,'Mojosari'),(25,13,'Watesnegoro'),(26,13,'Lolawang'),(27,14,'Kebonsari'),(28,14,'Sempusari'),(29,15,'Jember Lor'),(30,15,'Patrang'),(31,16,'Campurejo'),(32,16,'Bandar Kidul'),(33,17,'Burengan'),(34,17,'Banjaran'),(35,18,'Karangtengah'),(36,18,'Kepanjen Lor'),(37,19,'Sananwetan'),(38,19,'Tanggung');
/*!40000 ALTER TABLE `desa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `gambar_portofolio`
--

LOCK TABLES `gambar_portofolio` WRITE;
/*!40000 ALTER TABLE `gambar_portofolio` DISABLE KEYS */;
/*!40000 ALTER TABLE `gambar_portofolio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `jasa`
--

LOCK TABLES `jasa` WRITE;
/*!40000 ALTER TABLE `jasa` DISABLE KEYS */;
INSERT INTO `jasa` VALUES (1,1,'Desain Logo'),(2,1,'Desain Poster / Banner'),(3,1,'Desain Konten Sosial Media'),(4,1,'Editing Foto'),(5,1,'Editing Video Sederhana'),(6,2,'Service Alat Elektronik'),(7,2,'Service AC'),(8,2,'Kelistrikan Rumah'),(9,3,'Foto Prewedding'),(10,3,'Dokumentasi Acara'),(11,3,'Foto Produk UMKM'),(12,3,'Video Shooting Event'),(13,4,'Les Matematika'),(14,4,'Les Bahasa Inggris'),(15,4,'Les SD/SMP/SMA'),(16,4,'Les Mengaji'),(17,5,'Pembuatan Website'),(18,5,'Pembuatan Aplikasi Desktop'),(19,5,'Pembuatan Aplikasi Mobile'),(20,5,'UI/UX Design'),(21,6,'Bersih-bersih Rumah'),(22,6,'Cuci Setrika'),(23,7,'Tukang Bangunan'),(24,7,'Tukang Cat Rumah'),(25,7,'Tukang Kayu'),(26,7,'Renovasi Kecil'),(27,8,'MC Acara'),(28,8,'Penyanyi / Band'),(29,8,'Dekorasi Acara'),(30,8,'Wedding Organizer');
/*!40000 ALTER TABLE `jasa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `kabupaten`
--

LOCK TABLES `kabupaten` WRITE;
/*!40000 ALTER TABLE `kabupaten` DISABLE KEYS */;
INSERT INTO `kabupaten` VALUES (1,1,'Surabaya'),(2,1,'Malang'),(3,1,'Sidoarjo'),(4,1,'Gresik'),(5,1,'Mojokerto'),(6,1,'Jember'),(7,1,'Kediri'),(8,1,'Blitar');
/*!40000 ALTER TABLE `kabupaten` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `kategori`
--

LOCK TABLES `kategori` WRITE;
/*!40000 ALTER TABLE `kategori` DISABLE KEYS */;
INSERT INTO `kategori` VALUES (1,'Desain & Kreatif'),(2,'Teknisi & Perbaikan'),(3,'Fotografi & Videografi'),(4,'Pendidikan & Les Privat'),(5,'IT & Digital'),(6,'Rumah Tangga'),(7,'Tukang & Konstruksi'),(8,'Event & Hiburan');
/*!40000 ALTER TABLE `kategori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `kecamatan`
--

LOCK TABLES `kecamatan` WRITE;
/*!40000 ALTER TABLE `kecamatan` DISABLE KEYS */;
INSERT INTO `kecamatan` VALUES (1,1,'Sukolilo'),(2,1,'Rungkut'),(3,1,'Tegalsari'),(4,2,'Lowokwaru'),(5,2,'Blimbing'),(6,2,'Klojen'),(7,3,'Waru'),(8,3,'Candi'),(9,3,'Taman'),(10,4,'Manyar'),(11,4,'Driyorejo'),(12,5,'Mojosari'),(13,5,'Ngoro'),(14,6,'Kaliwates'),(15,6,'Patrang'),(16,7,'Mojoroto'),(17,7,'Pesantren'),(18,8,'Sananwetan'),(19,8,'Kepanjenkidul');
/*!40000 ALTER TABLE `kecamatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `layanan`
--

LOCK TABLES `layanan` WRITE;
/*!40000 ALTER TABLE `layanan` DISABLE KEYS */;
INSERT INTO `layanan` VALUES (1,4,1,5,500000,'Desain logo profesional dan cepat'),(2,4,2,5,300000,'Desain banner menarik'),(3,5,6,1,150000,'Service elektronik panggilan'),(4,5,7,4,250000,'Service AC rumah'),(5,6,9,5,2000000,'Foto prewedding aesthetic'),(6,6,10,5,1500000,'Dokumentasi acara lengkap'),(7,7,18,5,3000000,'Pembuatan website fullstack'),(8,7,19,5,2500000,'Aplikasi desktop custom'),(9,4,20,5,700000,'UI UX modern'),(10,5,21,4,100000,'Bersih rumah harian'),(11,6,24,5,500000,'Tukang cat profesional'),(12,7,27,5,1000000,'MC acara formal & santai'),(13,10,3,5,400000,'Desain konten sosial media kreatif'),(14,10,4,5,250000,'Editing foto profesional'),(15,4,5,5,300000,'Editing video sederhana cepat'),(16,5,8,1,200000,'Jasa kelistrikan rumah'),(17,6,11,5,800000,'Foto produk untuk UMKM'),(18,7,28,5,2500000,'Penyanyi untuk acara wedding'),(19,1,1,1,150000,'Update testing'),(20,1,2,1,150000,'Update testing'),(21,5,22,4,100000,'Bersih rumah harian');
/*!40000 ALTER TABLE `layanan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `pengajuan_freelancer`
--

LOCK TABLES `pengajuan_freelancer` WRITE;
/*!40000 ALTER TABLE `pengajuan_freelancer` DISABLE KEYS */;
INSERT INTO `pengajuan_freelancer` VALUES (1,2,'6301234567891111',NULL,'MENUNGGU',NULL,'2026-04-03 14:39:24'),(2,3,'6301234567892222',NULL,'DITOLAK','Data kurang lengkap','2026-04-03 14:39:24'),(3,8,'6301234567893333',NULL,'MENUNGGU',NULL,'2026-04-03 21:30:10'),(4,9,'6301234567894444',NULL,'DITERIMA','Data valid','2026-04-03 21:30:10'),(5,3,'1111111111111111','tess','DITOLAK','NIK tidak valid','2026-04-03 21:59:55');
/*!40000 ALTER TABLE `pengajuan_freelancer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `pengguna`
--

LOCK TABLES `pengguna` WRITE;
/*!40000 ALTER TABLE `pengguna` DISABLE KEYS */;
INSERT INTO `pengguna` VALUES (1,1,'admin','Admin Worklance','2000-05-10','0821482734723','admin@gmail.com','123',NULL,NULL,NULL,1,'Surabaya',NULL),(2,2,'sitinurhaliza','Siti Nurhaliza','2001-07-21','08223234595','siti@gmail.com','123',1,1,2,3,'Rungkut tengah, Surabaya',NULL),(3,2,'ahmadfauzi','Ahmad Fauzi','1999-03-12','082333333333','ahmad@gmail.com','123',1,6,15,29,'Surabaya',NULL),(4,3,'andiwijaya','Andi Wijaya','1998-03-15','08885845116','andi@gmail.com','123',NULL,NULL,NULL,14,'Sidoarjo',NULL),(5,3,'rizkypratama','Rizky Pratama','1997-08-09','08145449383','rizky@gmail.com','123',NULL,NULL,NULL,15,'Sidoarjo',NULL),(6,3,'dewirahmawati','Dewi Rahmawati','1995-11-30','081259507317','dewi@gmail.com','123',NULL,NULL,NULL,21,'Gresik',NULL),(7,3,'ferdyansyah','Ferdy Ansyah','1996-06-18','082958332745','ferdy@gmail.com','123',NULL,NULL,NULL,29,'Mojokerto',NULL),(8,2,'lindaputri','Linda Putri','2002-02-14','082592418334','linda@gmail.com','123',NULL,NULL,NULL,2,'Surabaya',NULL),(9,2,'yogapratama','Yoga Pratama','2001-09-09','082129342553','yoga@gmail.com','123',NULL,NULL,NULL,4,'Malang',NULL),(10,3,'bagussetiawan','Bagus Setiawan','1996-12-01','08193857235','bagus@gmail.com','123',NULL,NULL,NULL,7,'Sidoarjo',NULL);
/*!40000 ALTER TABLE `pengguna` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `provinsi`
--

LOCK TABLES `provinsi` WRITE;
/*!40000 ALTER TABLE `provinsi` DISABLE KEYS */;
INSERT INTO `provinsi` VALUES (1,'Jawa Timur');
/*!40000 ALTER TABLE `provinsi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (1,'Admin'),(2,'User'),(3,'Freelancer');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `satuan`
--

LOCK TABLES `satuan` WRITE;
/*!40000 ALTER TABLE `satuan` DISABLE KEYS */;
INSERT INTO `satuan` VALUES (1,'Unit'),(2,'Jam'),(3,'Paket'),(4,'Hari'),(5,'Project');
/*!40000 ALTER TABLE `satuan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `ulasan`
--

LOCK TABLES `ulasan` WRITE;
/*!40000 ALTER TABLE `ulasan` DISABLE KEYS */;
INSERT INTO `ulasan` VALUES (1,3,2,5,'Sangat memuaskan!','2026-04-07'),(2,4,3,4,'Bagus tapi agak lama','2026-04-08'),(3,2,3,5,'Pelayanan cepat!','2026-04-06'),(4,6,8,5,'Desainnya keren banget!','2026-04-10'),(5,7,9,4,'Lumayan bagus','2026-04-11');
/*!40000 ALTER TABLE `ulasan` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-05  8:04:26
