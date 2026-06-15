-- Data Wilayah Indonesia (Provinsi, Kabupaten, Kecamatan, Desa)
-- File ini dipisahkan dari seeder Laravel karena volume data yang besar.

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

--
-- Data untuk tabel `provinsi`
--

INSERT INTO `provinsi` VALUES (1,'Jawa Timur');

--
-- Data untuk tabel `kabupaten`
--

INSERT INTO `kabupaten` VALUES (1,1,'Surabaya'),(2,1,'Malang'),(3,1,'Sidoarjo'),(4,1,'Gresik'),(5,1,'Mojokerto'),(6,1,'Jember'),(7,1,'Kediri'),(8,1,'Blitar');

--
-- Data untuk tabel `kecamatan`
--

INSERT INTO `kecamatan` VALUES (1,1,'Sukolilo'),(2,1,'Rungkut'),(3,1,'Tegalsari'),(4,2,'Lowokwaru'),(5,2,'Blimbing'),(6,2,'Klojen'),(7,3,'Waru'),(8,3,'Candi'),(9,3,'Taman'),(10,4,'Manyar'),(11,4,'Driyorejo'),(12,5,'Mojosari'),(13,5,'Ngoro'),(14,6,'Kaliwates'),(15,6,'Patrang'),(16,7,'Mojoroto'),(17,7,'Pesantren'),(18,8,'Sananwetan'),(19,8,'Kepanjenkidul');

--
-- Data untuk tabel `desa`
--

INSERT INTO `desa` VALUES (1,1,'Keputih'),(2,1,'Gebang Putih'),(3,2,'Rungkut Tengah'),(4,2,'Kedung Baruk'),(5,3,'Dr. Soetomo'),(6,3,'Wonorejo'),(7,4,'Dinoyo'),(8,4,'Tlogomas'),(9,5,'Purwodadi'),(10,5,'Polowijen'),(11,6,'Kauman'),(12,6,'Sukoharjo'),(13,7,'Wedoro'),(14,7,'Tambak Oso'),(15,8,'Gelam'),(16,8,'Bligo'),(17,9,'Sepanjang'),(18,9,'Kedungturi'),(19,10,'Manyarejo'),(20,10,'Suci'),(21,11,'Petiken'),(22,11,'Bambe'),(23,12,'Sawahan'),(24,12,'Mojosari'),(25,13,'Watesnegoro'),(26,13,'Lolawang'),(27,14,'Kebonsari'),(28,14,'Sempusari'),(29,15,'Jember Lor'),(30,15,'Patrang'),(31,16,'Campurejo'),(32,16,'Bandar Kidul'),(33,17,'Burengan'),(34,17,'Banjaran'),(35,18,'Karangtengah'),(36,18,'Kepanjen Lor'),(37,19,'Sananwetan'),(38,19,'Tanggung');

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
