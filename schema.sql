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
-- Table structure for table `booking`
--

DROP TABLE IF EXISTS `booking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking` (
  `id_booking` int(11) NOT NULL AUTO_INCREMENT,
  `id_pengguna` int(11) DEFAULT NULL,
  `id_layanan` int(11) DEFAULT NULL,
  `tanggal_booking` date DEFAULT NULL,
  `alamat_booking` text DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `status_booking` enum('MENUNGGU','DIPROSES','SELESAI','DIBATALKAN') DEFAULT NULL,
  PRIMARY KEY (`id_booking`),
  KEY `id_pengguna` (`id_pengguna`),
  KEY `id_layanan` (`id_layanan`),
  CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`),
  CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`id_layanan`) REFERENCES `layanan` (`id_layanan`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `desa`
--

DROP TABLE IF EXISTS `desa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `desa` (
  `id_desa` int(11) NOT NULL AUTO_INCREMENT,
  `id_kecamatan` int(11) DEFAULT NULL,
  `nama_desa` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_desa`),
  KEY `id_kecamatan` (`id_kecamatan`),
  CONSTRAINT `desa_ibfk_1` FOREIGN KEY (`id_kecamatan`) REFERENCES `kecamatan` (`id_kecamatan`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gambar_portofolio`
--

DROP TABLE IF EXISTS `gambar_portofolio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gambar_portofolio` (
  `id_gambar` int(11) NOT NULL AUTO_INCREMENT,
  `id_layanan` int(11) DEFAULT NULL,
  `file_gambar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_gambar`),
  KEY `id_layanan` (`id_layanan`),
  CONSTRAINT `gambar_portofolio_ibfk_1` FOREIGN KEY (`id_layanan`) REFERENCES `layanan` (`id_layanan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jasa`
--

DROP TABLE IF EXISTS `jasa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jasa` (
  `id_jasa` int(11) NOT NULL AUTO_INCREMENT,
  `id_kategori` int(11) DEFAULT NULL,
  `nama_jasa` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_jasa`),
  KEY `id_kategori` (`id_kategori`),
  CONSTRAINT `jasa_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kabupaten`
--

DROP TABLE IF EXISTS `kabupaten`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kabupaten` (
  `id_kabupaten` int(11) NOT NULL AUTO_INCREMENT,
  `id_provinsi` int(11) DEFAULT NULL,
  `nama_kabupaten` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_kabupaten`),
  KEY `id_provinsi` (`id_provinsi`),
  CONSTRAINT `kabupaten_ibfk_1` FOREIGN KEY (`id_provinsi`) REFERENCES `provinsi` (`id_provinsi`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kategori`
--

DROP TABLE IF EXISTS `kategori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kecamatan`
--

DROP TABLE IF EXISTS `kecamatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kecamatan` (
  `id_kecamatan` int(11) NOT NULL AUTO_INCREMENT,
  `id_kabupaten` int(11) DEFAULT NULL,
  `nama_kecamatan` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_kecamatan`),
  KEY `id_kabupaten` (`id_kabupaten`),
  CONSTRAINT `kecamatan_ibfk_1` FOREIGN KEY (`id_kabupaten`) REFERENCES `kabupaten` (`id_kabupaten`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `layanan`
--

DROP TABLE IF EXISTS `layanan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `layanan` (
  `id_layanan` int(11) NOT NULL AUTO_INCREMENT,
  `id_pengguna` int(11) DEFAULT NULL,
  `id_jasa` int(11) DEFAULT NULL,
  `id_satuan` int(11) DEFAULT NULL,
  `tarif` int(11) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  PRIMARY KEY (`id_layanan`),
  KEY `id_pengguna` (`id_pengguna`),
  KEY `id_jasa` (`id_jasa`),
  KEY `id_satuan` (`id_satuan`),
  CONSTRAINT `layanan_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`),
  CONSTRAINT `layanan_ibfk_2` FOREIGN KEY (`id_jasa`) REFERENCES `jasa` (`id_jasa`),
  CONSTRAINT `layanan_ibfk_3` FOREIGN KEY (`id_satuan`) REFERENCES `satuan` (`id_satuan`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pengajuan_freelancer`
--

DROP TABLE IF EXISTS `pengajuan_freelancer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengajuan_freelancer` (
  `id_pengajuan` int(11) NOT NULL AUTO_INCREMENT,
  `id_pengguna` int(11) DEFAULT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `status` enum('MENUNGGU','DITERIMA','DITOLAK') DEFAULT 'MENUNGGU',
  `catatan_admin` text DEFAULT NULL,
  `tanggal_pengajuan` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_pengajuan`),
  KEY `id_pengguna` (`id_pengguna`),
  CONSTRAINT `pengajuan_freelancer_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pengguna`
--

DROP TABLE IF EXISTS `pengguna`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL AUTO_INCREMENT,
  `id_role` int(11) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `nama_pengguna` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `id_provinsi` int(11) DEFAULT NULL,
  `id_kabupaten` int(11) DEFAULT NULL,
  `id_kecamatan` int(11) DEFAULT NULL,
  `id_desa` int(11) DEFAULT NULL,
  `alamat_lengkap` text DEFAULT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_pengguna`),
  UNIQUE KEY `username` (`username`),
  KEY `id_role` (`id_role`),
  KEY `id_desa` (`id_desa`),
  CONSTRAINT `pengguna_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`),
  CONSTRAINT `pengguna_ibfk_2` FOREIGN KEY (`id_desa`) REFERENCES `desa` (`id_desa`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `provinsi`
--

DROP TABLE IF EXISTS `provinsi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `provinsi` (
  `id_provinsi` int(11) NOT NULL AUTO_INCREMENT,
  `nama_provinsi` varchar(50) NOT NULL,
  PRIMARY KEY (`id_provinsi`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role` (
  `id_role` int(11) NOT NULL AUTO_INCREMENT,
  `nama_role` varchar(20) NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `satuan`
--

DROP TABLE IF EXISTS `satuan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `satuan` (
  `id_satuan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_satuan` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_satuan`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ulasan`
--

DROP TABLE IF EXISTS `ulasan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ulasan` (
  `id_ulasan` int(11) NOT NULL AUTO_INCREMENT,
  `id_booking` int(11) DEFAULT NULL,
  `id_pengguna` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `komentar` text DEFAULT NULL,
  `tanggal_ulasan` date DEFAULT NULL,
  PRIMARY KEY (`id_ulasan`),
  KEY `id_booking` (`id_booking`),
  KEY `id_pengguna` (`id_pengguna`),
  CONSTRAINT `ulasan_ibfk_1` FOREIGN KEY (`id_booking`) REFERENCES `booking` (`id_booking`),
  CONSTRAINT `ulasan_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-05  7:57:57
