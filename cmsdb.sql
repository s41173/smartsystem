-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 08, 2016 at 07:43 
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cmsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_menu`
--

CREATE TABLE `admin_menu` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `icon` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `parent_id` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `modul` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `url` varchar(100) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `menu_order` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `class_style` varchar(25) COLLATE latin1_general_ci DEFAULT NULL,
  `id_style` varchar(25) COLLATE latin1_general_ci DEFAULT NULL,
  `target` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '_parent',
  `parent_status` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `admin_menu`
--

INSERT INTO `admin_menu` (`id`, `icon`, `parent_id`, `name`, `modul`, `url`, `menu_order`, `class_style`, `id_style`, `target`, `parent_status`, `created`, `updated`, `deleted`) VALUES
(41, NULL, 0, 'Home', 'main', 'main/', 0, 'fa fa-home', '', '_parent', 1, NULL, '2016-11-24 15:42:01', NULL),
(42, NULL, 0, 'Dashboard', 'main', 'main/', 1, 'fa fa-home', '', '_parent', 1, NULL, '2016-11-24 15:42:45', NULL),
(106, NULL, 54, 'Language', 'language', 'language/', 4, '', '', '_parent', 0, NULL, NULL, NULL),
(54, NULL, 0, 'Article', 'main', 'main/', 5, 'fa fa-book', '', '_parent', 1, NULL, '2016-11-24 15:45:29', NULL),
(55, NULL, 54, 'New Article', 'article', 'article/add', 0, '', '', '_parent', 0, NULL, NULL, NULL),
(56, NULL, 54, 'Article List', 'article', 'article/', 1, '', '', '_parent', 0, NULL, NULL, NULL),
(72, NULL, 54, 'News Category', 'newscategory', 'newscategory/', 2, '', '', '_parent', 0, NULL, NULL, NULL),
(163, NULL, 41, 'Coba Lagi', 'login', 'login/', 2, '', '', '_parent', 0, NULL, NULL, NULL),
(165, NULL, 0, 'Product', 'main', 'main/', 4, 'fa fa-dropbox', '', '_parent', 1, NULL, '2016-11-24 15:44:02', NULL),
(166, NULL, 165, 'Product List', 'product', 'product/', 1, '', '', '_parent', 0, NULL, NULL, NULL),
(167, NULL, 165, 'Category', 'category', 'category/', 0, '', '', '_parent', 0, NULL, NULL, NULL),
(168, NULL, 165, 'Image slider', 'slider', 'slider/', 2, '', '', '_parent', 0, NULL, NULL, NULL),
(169, NULL, 165, 'Banner', 'banner', 'banner/', 3, '', '', '_parent', 0, NULL, NULL, NULL),
(170, NULL, 165, 'Event', 'project', 'project/', 4, '', '', '_parent', 0, NULL, NULL, NULL),
(171, NULL, 54, 'Newsbox', 'newsbox', 'newsbox/', 4, '', '', '_parent', 0, NULL, NULL, NULL),
(172, NULL, 165, 'Testimonial', 'testimonial', 'testimonial/', 5, '', '', '_parent', 0, NULL, NULL, NULL),
(173, NULL, 165, 'Manufactures', 'manufacture', 'manufacture/', 1, '', '', '_parent', 0, '2016-11-24 17:01:03', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `id` int(5) NOT NULL,
  `category_id` int(5) NOT NULL,
  `user` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `lang` varchar(15) COLLATE latin1_general_ci NOT NULL,
  `permalink` varchar(25) COLLATE latin1_general_ci NOT NULL DEFAULT 'unvalue',
  `title` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `text` text COLLATE latin1_general_ci NOT NULL,
  `image` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `dates` date DEFAULT NULL,
  `time` time NOT NULL,
  `counter` smallint(5) NOT NULL DEFAULT '1',
  `comment` smallint(1) NOT NULL DEFAULT '0',
  `front` smallint(1) NOT NULL DEFAULT '0',
  `publish` int(1) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id`, `category_id`, `user`, `lang`, `permalink`, `title`, `text`, `image`, `dates`, `time`, `counter`, `comment`, `front`, `publish`, `created`, `deleted`, `updated`) VALUES
(60, 20, 'admin', 'ID', 'companyprofile', 'Company Profile', '<h3>\r\n	PT. ABC</h3>\r\n<p>\r\n	Perusahaan jasa konstruksi dan manufaktur yang bergerak dalam bidang usaha aluminium. Varian produk yaitu aluminium dengan merek Delica ( Windows, Doors &amp; Curtain Wall) dan<br />\r\n	Delibond <a href="#">(Aluminium composite panel )</a></p>\r\n<p>\r\n	Dilengkapi dengan peralatan dan mesin-mesin import terbaru serta didukung oleh teknisi dan sumberdaya yang handal, kami terus berinovasi dan mengembangkan usaha guna memenuhi permintaan pangsa pasar yang terus berkembang.</p>\r\n<p>\r\n	Dengan kebijakan bisnis &quot;Kualitas Premium, Layanan handal, Harga kompetitif,&quot; didukung pengalaman dan peralatan canggih, kami memiliki keyakinan bahwa Anda akan puas dengan kualitas produk dan layanan,dan kami berharap akan membangun hubungan bisnis dengan semua orang.</p>\r\n<p>\r\n	Dilengkapi dengan peralatan dan mesin-mesin import terbaru serta didukung oleh teknisi dan sumberdaya yang handal, kami terus berinovasi dan mengembangkan usaha guna memenuhi permintaan pangsa pasar yang terus berkembang.</p>\r\n<p>\r\n	Dengan kebijakan bisnis &quot;Kualitas Premium, Layanan handal, Harga kompetitif,&quot; didukung pengalaman dan peralatan canggih, kami memiliki keyakinan bahwa Anda akan puas dengan kualitas produk dan layanan, dan kami berharap akan membangun hubungan bisnis dengan semua orang.</p>\r\n', 'Company_Profile.jpg', '2013-05-30', '00:00:00', 1, 0, 0, 0, NULL, NULL, NULL),
(68, 0, 'admin', 'ID', 'visionmision', 'Vision Mision', '<p>\n	Pengembangan dan Pergerakan roda bisnis PT.DELICA INDONESIA selalu mengacu kepada visi dan misi, membantu &nbsp;perusahaan tetap fokus guna mencapai idealisme untuk mengingatkan manajemen serta karyawan bahwa mereka berkerja sama demi tujuan-tujuan yang sama, yang akan menjadi sumbangan &nbsp;dalam keberhasilan jangka panjang Perusahaan.</p>\n<p>\n	<span style="font-size:20px;"><span style="background-color:#d3d3d3;">Visi&nbsp; </span><span style="color:#ffffff;"><span style="background-color:#800000;">Perusahaan</span></span></span></p>\n<p>\n	Kwalitas Prima handal dan kompetitif dengan posisi financial yang kuat, memimpin pasar Sumatera Utara dan Indonesia, dan menjadi perusahaan produsen Aluminium Windows &amp; Door dan Aluminium Composite Panel yang berkualitas dengan reputasi global.</p>\n<p>\n	<span style="font-size:20px;"><span style="background-color:#d3d3d3;">Misi </span><span style="color:#ffffff;"><span style="background-color:#800000;">Perusahaan</span></span></span></p>\n<p>\n	Menjadi produsen terpercaya dengan harga yang kompetitif disertai kualitas produk yang handal, melaksanakan tanggung jawab sosial, dan memberikan profitabilitas serta nilai tambah untuk semua stakeholder perusahaan.</p>\n', 'Vision_Mision.jpg', '2013-05-30', '00:00:00', 1, 0, 0, 0, NULL, NULL, NULL),
(70, 21, 'admin', 'ID', 'tipscontoh2', 'Tips Contoh 2', '<div>\r\n	Agar tetap awet, semua barang tentu butuh perawatan.? Tak terkecuali dengan kusen pintu dan kusen jendela rumah. Apalagi, lokasi kusen jendela aluminium yang kebanyakan ada di luar ruangan menyebabkan kusen pintu aluminium&nbsp;kerap tertimpa panas matahari, debu, dan tampias hujan.</div>\r\n<p>\r\n	#readmore#</p>\r\n<div>\r\n	&nbsp;</div>\r\n<div>\r\n	Kusen alumunium adalah kusen pintu yang tidak membutuhkan perawatan rutin. Sebab, kusen jendela jenis ini tidak akan berkarat dalam jangka waktu yang lama. Selain itu, kusen jendela alumunium juga kuat menahan sinar matahari dan siraman air hujan sekaligus. Makanya, kusen pintu jenis ini hanya butuh perawatan yang minimal, hanya dengan mengelapnya secara rutin. Untuk membersihkan kusen alumunium cukup menggunakan lap basah.</div>\r\n<div>\r\n	&nbsp;</div>\r\n<div>\r\n	Setali tiga uang, kusen cor juga tidak membutuhkan perawatan secara khusus. Yang penting adalah, daun pintu atau jendela yang tergantung pada saat pengecoran harus benar-benar kering. Kusen cor hanya membutuhkan perawatan dari pewarnaan saja. &quot;Kalau cat nya pudar, ya? tinggal cat ulang lagi,&quot; paparnya. Meski begitu, Kami menganjurkan agar kusen cor tak kena benturan keras yang dapat merusaknya. <strong>&quot;Sebab memperbaiki kusen cor cukup sulit,&quot;</strong>.</div>\r\n<div>\r\n	&nbsp;</div>\r\n<div>\r\n	Kusen alumunium sebaiknya jangan sampai terkena benturan apapun agar tak merusak bentuknya. <strong>&quot;Jangan terkena benturan agar tidak pecah&quot;</strong>. Ini tentu berbeda dengan kusen jenis kayu, Kami menyarankan, sebelum dipasang, kayu tersebut harus berlapis antirayap. Selain itu, kayu juga harus di-coating alias diberi lapisan tahan jamur. Kalau warna kayunya mulai kusam, maka tinggal dilakukan pengecatan ulang. Tapi cat yang digunakan bukan sembarangan cat. Pilihlah cat kayu yang tahan terhadap segala cuaca.</div>\r\n<div>\r\n	&nbsp;</div>\r\n<div>\r\n	Perawatan kusen kayu sejatinya tergantung dari jenis kayu. Ada dua jenis kayu yang biasa digunakan di rumah. Untuk kelas atas, kayu kamper Samarinda dan kayu jati bisa menjadi pilihan. Di pasar kelas bawah? ada kayu kamper Medan, Kamper Singkil, Meranti.</div>\r\n<div>\r\n	&nbsp;</div>\r\n<div>\r\n	Agar tidak merusak inti kayu kelas atas, Anda sebaiknya menggunakan cat duco yang tahan lama. Setelah kusen terpasang, jangan lupa membubuhkan lapisan anti rayap. Sedangkan perawatan untuk kusen berbahan kayu kelas bawah lebih sulit karena minimal memerlukan pelitur. Pengecekan rutin juga harus dilakukan untuk mencari retak yang terjadi di kayu. Jika retak, Anda bisa menambalnya dengan dempul.</div>\r\n', 'Perawatan_Kusen.jpg', '2013-05-31', '00:00:00', 1, 0, 0, 0, NULL, NULL, NULL),
(69, 0, 'admin', 'ID', 'strukturorganization', 'Struktur Organization', '<p>\n	<img alt="" src="http://i1262.photobucket.com/albums/ii609/s41173/delica/so.jpg" style="width: 800px; height: 644px;" /></p>\n', 'Struktur_Organization.jpg', '2013-05-30', '00:00:00', 1, 0, 0, 0, NULL, NULL, NULL),
(71, 21, 'admin', 'ID', 'tipscontoh3', 'Tips Contoh 3', '<p>\r\n	<b style="text-align: justify;">Kusen pintu aluminium</b><span style="text-align: justify;"> merupakan alternatif pilihan yang sangat cocok untuk </span><span style="text-align: justify;">rumah minimalis</span><span style="text-align: justify;"> Anda. Kini banyak orang yang sudah mulai menggunakan </span><span style="text-align: justify;">kusen aluminium</span><span style="text-align: justify;"> untuk rumah sebagai hunian pribadi. &nbsp;</span>#readmore#</p>\r\n<p>\r\n	<span style="text-align: justify;">Beberapa waktu yang lalu penggunaan kusen ini memang banyak digunakana oleh toko, ruko dan gedung perkantoran. Dengan alasan bahwa kusen ini mudah dipadukan dengan kaca dan bahan lainnya, selain itu untuk proses pembongkarannya juga mudah jika sewaktu-waktu masa kontrak ruko atau gedung perkantoran habis.</span></p>\r\n<p>\r\n	<span style="text-align: justify;"><img alt="" src="http://2.bp.blogspot.com/-9otcagkywuI/UV9bWWFEs5I/AAAAAAAAFyU/UCffYBzsLr0/s320/Kusen+Pintu+Aluminium.JPG" style="width: 320px; height: 240px;" /></span></p>\r\n<div dir="ltr" trbidi="on">\r\n	<div style="text-align: justify;">\r\n		&nbsp;</div>\r\n	<div style="text-align: justify;">\r\n		Namun pada perkembangannya banyak rumah modern berkonsep minimalis yang beralih menggunakan kusen aluminium. Bahan kayu dinilai mempunyai banyak kekurangan diantaranya rawan terhadap rayap, tidak tahan air, suatu saat dapat rapuh dan tidak tahan lama terhadap cuaca. Sedangkan kusen aluminium memiliki sifat yang berlawanan dengan kayu tersebut sehingga banyak yang beralih memakai kusen tersebut.</div>\r\n</div>\r\n<p>\r\n	&nbsp;</p>\r\n', 'Kusen_Aluminium.jpg', '2013-05-31', '00:00:00', 1, 0, 0, 0, NULL, NULL, NULL),
(78, 21, 'admin', 'ID', 'tipscontoh1', 'Tips Contoh 1', '<p>\r\n	Jendela Aluminium kini semakin banyak bermunculan di kawasan perumahan elit. Ini menandai bahwa konsumen semakin sadar akan peran dan funsgi atas Jendela Aluminium.</p>\r\n<p>\r\n	#readmore#</p>\r\n<p>\r\n	Sebagaimana kita ketahui bahwa peran jendela dalam bagian komponen bangunan rumah sangatlah penting untuk sirkulasi udara. Jumlah jendela serta ukuran jendela sangat menentukan suhu udara ruang dalam rumah. Oleh sebab itu bisa saya katakan jendela menjadi salah satu komponen dalam menentukan tingkat kesejukan udara sekaligus kesehatan penghuninya.</p>\r\n<div>\r\n	<strong><span style="color:#0000cd;"><span style="font-size:16px;">Jendela Aluminium Pilihan Terbaik</span></span></strong><br />\r\n	&nbsp;</div>\r\n<div>\r\n	Kenapa saya berani bilang Jendela aluminium itu opsi terbaik ? Dalam menentukan desain rumah, biasanya orang akan melihat seberapa besar budget tersedia, dan juga akan mempertimbangkan masa pemakaian bahan jendela. JIka anda setuju dengan saya, maka pilihan pada Jendela Aluminium sangatlah tepat. Karena selain harga nya relatif murah, pun sangat bisa diandalkan untuk masa pakainya.Bisa dibilang jendela aluminium ini jendela seumur hidup.</div>\r\n<div>\r\n	&nbsp;</div>\r\n<div>\r\n	<span style="font-size:14px;"><strong>Beberapa hal terbaik Tentang Jendela Aluminium:</strong></span></div>\r\n<div>\r\n	&nbsp;</div>\r\n<div>\r\n	<div>\r\n		<strong>Pilihan Warna Yang banyak</strong></div>\r\n	<div>\r\n		Sama seperti kusen aluminium , jendela aluminium juga tersedia dalam banyak warna finishing, Misalnya silver,coklat,hitam dan warna coating :Putih,Merah,Hijau,Biru dll.Juga tersedia dalam warna coting urat kayu atau serat kayu.</div>\r\n</div>\r\n<div>\r\n	&nbsp;</div>\r\n<div>\r\n	<img alt="" src="http://i1262.photobucket.com/albums/ii609/s41173/delica/product/patio_door_aluminium_foldin.jpg" style="width: 300px; height: 252px;" /></div>\r\n<div>\r\n	&nbsp;</div>\r\n<div>\r\n	&nbsp;</div>\r\n<div>\r\n	<div>\r\n		<strong>Rangka Yang kuat tahan Api</strong></div>\r\n	<div>\r\n		Karena terbuat dari bahan logam, maka jendela aluminium lebih tahan api dibandingkan dari bahan yang lain.</div>\r\n	<div>\r\n		&nbsp;</div>\r\n	<div>\r\n		<div>\r\n			<strong>Jendela Tahan Cuaca dan Rayap</strong></div>\r\n		<div>\r\n			Aluminium sebagai logam yang ringan dan tahan terhadapa gangguan cuaca. Jadi jendela aluminium ini tak akan rapuh dimakan rayap atau rusak di hantam karat.</div>\r\n		<div>\r\n			&nbsp;</div>\r\n		<div>\r\n			<div>\r\n				<strong>Jendela Aluminium itu Minim Perawatan nya</strong></div>\r\n			<div>\r\n				Karena Jendela ALuminium terbuat dari bahan logam yang anti karat, anti korosi , maka perawatannya sangatlah minim. Cukup dengan di lap dengan detergen ringan.Tidak perlu di cat ulang karena finsihing warnanya kuat melekat.</div>\r\n			<div>\r\n				&nbsp;</div>\r\n			<div>\r\n				<div>\r\n					<strong>Aneka Bentuk Jendela di desain untuk aneka permintaan konsumen</strong></div>\r\n				<div>\r\n					Saking banyaknya permintaan konsumen...maka ahli desainer aluminium berlomba memberikan desain dan profil aluminium yang dapat mengikuti selera konsumen. Yang mudah nya saja saya sebutkan yaitu jendela aluminium geser dan jendela aluminium swing / Jendela cassement.</div>\r\n			</div>\r\n		</div>\r\n	</div>\r\n	<div>\r\n		&nbsp;</div>\r\n</div>\r\n<p>\r\n	&nbsp;</p>\r\n', 'Jendela_Aluminium_Pilihan_Terbaik_Untuk_Rumah_Anda.jpg', '2013-06-12', '00:00:00', 1, 0, 0, 0, NULL, NULL, NULL),
(80, 24, 'admin', 'ID', 'eventacaracocacola', 'Event Acara CocaCola', '<p>\r\n	<span style="font-family: Arial, Helvetica, sans; font-size: 11px; line-height: 14px; text-align: justify;">ontrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &quot;de Finibus Bonorum et Malorum&quot; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &quot;Lorem ipsum dolor sit amet..&quot;, comes from a line in section 1.10.32.</span></p>\r\n', 'Event_Acara_CocaCola.jpg', '2015-08-21', '00:00:00', 1, 0, 0, 0, NULL, NULL, '2016-11-24 15:59:59'),
(79, 24, 'admin', 'ID', 'eventacara17', 'Event Acara 17', '<p>\r\n	Acara 17 Agustus Sangat menggembirakan&nbsp;</p>\r\n<p>\r\n	&quot;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&quot;</p>\r\n<p>\r\n	&nbsp;</p>\r\n', 'Event_Acara_17.jpg', '2015-08-18', '00:00:00', 1, 0, 0, 0, NULL, NULL, NULL),
(81, 24, 'admin', 'ID', 'eventcaralainnya', 'Event Cara Lainnya', '<p>\r\n	<span style="color: rgb(0, 0, 0); font-family: Arial, Helvetica, sans; font-size: 11px; line-height: 14px; text-align: justify;">ontrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &quot;de Finibus Bonorum et Malorum&quot; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &quot;Lorem ipsum dolor sit amet..&quot;, comes from a line in section 1.10.32.</span></p>\r\n', 'Event_Cara_Lainnya.jpg', '2015-08-21', '00:00:00', 1, 0, 0, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `attribute`
--

CREATE TABLE `attribute` (
  `id` int(11) NOT NULL,
  `category_id` int(5) NOT NULL,
  `attribute_list_id` int(5) NOT NULL,
  `orders` int(2) NOT NULL,
  `created` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_list`
--

CREATE TABLE `attribute_list` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_product`
--

CREATE TABLE `attribute_product` (
  `id` int(11) NOT NULL,
  `product_id` int(5) NOT NULL,
  `attribute_id` int(5) NOT NULL,
  `value` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `position` char(10) NOT NULL,
  `url` varchar(100) DEFAULT NULL,
  `publish` smallint(1) NOT NULL,
  `image` varchar(100) NOT NULL,
  `width` int(4) NOT NULL DEFAULT '0',
  `height` int(4) NOT NULL DEFAULT '0',
  `menu` text NOT NULL,
  `created` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `name`, `position`, `url`, `publish`, `image`, `width`, `height`, `menu`, `created`, `deleted`, `updated`) VALUES
(7, 'Banner 1', 'user1', 'http://delicaindonesia.com/administrator/images/banner/Banner_1.jpg', 1, 'Banner_1.jpg', 260, 213, '100,109', NULL, NULL, NULL),
(3, 'Download', 'user2', 'http://delicaindonesia.com/administrator/brochure/Company_Profile.pdf', 1, 'Download.jpg', 260, 71, '100', NULL, NULL, NULL),
(4, 'Banner 2', 'user3', '#', 1, 'Banner_2.jpg', 240, 250, '111,100,113,109,112', NULL, NULL, '2016-11-24 15:54:38'),
(5, 'banner 4', 'user4', 'http://delicaindonesia.com/administrator/brochure/Banner_3.jpg', 1, 'banner_4.jpg', 240, 213, '109,112', NULL, NULL, NULL),
(6, 'banner5', 'user5', 'http://delicaindonesia.com/administrator/brochure/Banner_2.jpg', 1, 'banner5.jpg', 240, 213, '111,113', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `captcha`
--

CREATE TABLE `captcha` (
  `id` int(2) NOT NULL,
  `question` varchar(30) NOT NULL,
  `answer` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `captcha`
--

INSERT INTO `captcha` (`id`, `question`, `answer`) VALUES
(1, '1 + 1 = ', '2'),
(2, '2 x 3 = ', '6'),
(3, '5 + 4 =', '9'),
(4, '6 x 3 =', '18'),
(5, '4 x 6 =', '24'),
(6, '1 + 7 =', '8'),
(7, '4 + 3 = ', '7'),
(8, '6 + 6 =', '12');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(6) NOT NULL,
  `name` varchar(100) NOT NULL,
  `parent_id` int(3) NOT NULL,
  `publish` int(1) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `parent_id`, `publish`, `image`, `created`, `deleted`, `updated`) VALUES
(5, 'Curtain Wall Series', 0, 1, NULL, NULL, NULL, '2016-11-24 18:33:45'),
(6, 'Windows Series', 0, 1, NULL, NULL, '2016-11-24 18:34:10', '2016-11-24 18:33:39'),
(7, 'Door Series', 0, 1, NULL, NULL, NULL, '2016-11-24 18:33:41'),
(8, 'Accessories', 0, 0, NULL, NULL, NULL, NULL),
(9, 'curtain wall', 7, 0, 'Curtain_Wall.jpg', NULL, NULL, '2016-11-24 18:34:01'),
(10, 'casement windows', 0, 0, 'Casement_Windows.jpg', NULL, NULL, '2016-11-24 18:33:30'),
(11, 'Sliding Window Series', 6, 1, 'Sliding_Window_Series.jpg', NULL, NULL, '2016-11-24 18:33:40'),
(12, 'Sliding Door Series', 7, 0, 'Sliding_Door_Series.jpg', NULL, NULL, NULL),
(13, 'Swing Door Series', 7, 0, 'Swing_Door_Series.jpg', NULL, NULL, NULL),
(14, 'Folding Door Series', 7, 0, 'Folding_Door_Series.jpg', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `id` int(3) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `name`) VALUES
(14, 'medan'),
(2, 'bandung'),
(3, 'surabaya'),
(4, 'jakarta'),
(7, 'jambi'),
(8, 'lampung'),
(19, 'bogor'),
(21, 'jawa'),
(22, 'dodol'),
(23, 'batam');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `session_id` varchar(100) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_data` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('885f9f9ba22aab178159a8d9c51cc6be', '0.0.0.0', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (K', 1464691531, 'a:3:{s:4:"lang";s:2:"ID";s:12:"refered_from";s:37:"http://localhost/dswip/index.php/home";s:4:"menu";s:1:"1";}'),
('d58b0e60b442a5f41ec802344d2174c1', '0.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 1470982648, 'a:3:{s:4:"lang";s:2:"ID";s:12:"refered_from";s:37:"http://localhost/dswip/index.php/home";s:4:"menu";s:1:"1";}');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(5) NOT NULL,
  `article_id` int(6) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `dates` date DEFAULT NULL,
  `text` text NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int(2) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `code`) VALUES
(1, 'IDR', 'IDR'),
(2, 'Us Dollar', 'USD');

-- --------------------------------------------------------

--
-- Table structure for table `installation`
--

CREATE TABLE `installation` (
  `database_type` varchar(100) NOT NULL,
  `database_name` varchar(100) NOT NULL,
  `user` varchar(100) NOT NULL DEFAULT 'root',
  `pass` varchar(100) NOT NULL,
  `host` varchar(100) NOT NULL DEFAULT 'localhost',
  `status` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE `language` (
  `id` int(2) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(15) NOT NULL,
  `primary` int(1) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`id`, `name`, `code`, `primary`, `created`, `updated`, `deleted`) VALUES
(2, 'English', 'EN', 0, NULL, '2016-11-24 16:00:50', NULL),
(6, 'Indonesia', 'ID', 0, NULL, '2016-11-24 16:00:49', NULL),
(8, 'America', 'USA', 1, NULL, '2016-11-24 16:00:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id` int(10) NOT NULL,
  `userid` int(3) NOT NULL,
  `date` date NOT NULL,
  `time` varchar(30) CHARACTER SET latin1 NOT NULL,
  `component_id` int(5) NOT NULL,
  `activity` varchar(100) NOT NULL,
  `description` text,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`id`, `userid`, `date`, `time`, `component_id`, `activity`, `description`, `created`, `updated`, `deleted`) VALUES
(34, 1, '2012-09-17', '10:24:02', 0, 'login', NULL, NULL, NULL, NULL),
(33, 1, '2012-09-12', '12:48:58', 0, 'logout', NULL, NULL, NULL, NULL),
(32, 1, '2012-09-12', '12:47:13', 0, 'login', NULL, NULL, NULL, NULL),
(31, 1, '2012-09-12', '12:47:09', 0, 'logout', NULL, NULL, NULL, NULL),
(30, 1, '2012-09-12', '10:32:47', 0, 'login', NULL, NULL, NULL, NULL),
(29, 1, '2012-09-12', '10:32:38', 0, 'logout', NULL, NULL, NULL, NULL),
(28, 1, '2012-09-12', '09:13:48', 0, 'login', NULL, NULL, NULL, NULL),
(27, 1, '2012-09-11', '12:15:41', 0, 'logout', NULL, NULL, NULL, NULL),
(26, 1, '2012-09-11', '11:43:58', 0, 'login', NULL, NULL, NULL, NULL),
(25, 9, '2012-09-11', '11:43:54', 0, 'logout', NULL, NULL, NULL, NULL),
(24, 9, '2012-09-11', '11:39:25', 0, 'login', NULL, NULL, NULL, NULL),
(23, 1, '2012-09-11', '11:39:20', 0, 'logout', NULL, NULL, NULL, NULL),
(22, 1, '2012-09-11', '11:36:25', 0, 'login', NULL, NULL, NULL, NULL),
(21, 9, '2012-09-11', '11:36:21', 0, 'logout', NULL, NULL, NULL, NULL),
(20, 9, '2012-09-11', '11:34:23', 0, 'login', NULL, NULL, NULL, NULL),
(19, 9, '2012-09-11', '11:34:19', 0, 'logout', NULL, NULL, NULL, NULL),
(35, 1, '2012-09-17', '10:25:12', 0, 'logout', NULL, NULL, NULL, NULL),
(36, 1, '2012-10-11', '14:03:22', 0, 'login', NULL, NULL, NULL, NULL),
(37, 1, '2012-10-11', '14:05:49', 0, 'logout', NULL, NULL, NULL, NULL),
(38, 1, '2012-10-11', '14:05:57', 0, 'login', NULL, NULL, NULL, NULL),
(39, 1, '2012-10-11', '14:07:02', 0, 'logout', NULL, NULL, NULL, NULL),
(40, 9, '2012-10-17', '11:16:05', 0, 'login', NULL, NULL, NULL, NULL),
(41, 9, '2012-10-17', '11:18:24', 0, 'logout', NULL, NULL, NULL, NULL),
(42, 9, '2012-10-17', '11:18:37', 0, 'login', NULL, NULL, NULL, NULL),
(43, 9, '2012-10-17', '11:18:41', 0, 'logout', NULL, NULL, NULL, NULL),
(66, 1, '2012-10-25', '11:25:33', 0, 'login', NULL, NULL, NULL, NULL),
(65, 1, '2012-10-25', '08:46:20', 0, 'login', NULL, NULL, NULL, NULL),
(64, 1, '2012-10-24', '16:11:18', 0, 'logout', NULL, NULL, NULL, NULL),
(63, 1, '2012-10-24', '15:58:40', 0, 'login', NULL, NULL, NULL, NULL),
(62, 1, '2012-10-24', '15:58:08', 0, 'login', NULL, NULL, NULL, NULL),
(61, 1, '2012-10-24', '15:57:58', 0, 'login', NULL, NULL, NULL, NULL),
(60, 1, '2012-10-24', '12:54:50', 0, 'login', NULL, NULL, NULL, NULL),
(59, 1, '2012-10-23', '15:35:35', 0, 'logout', NULL, NULL, NULL, NULL),
(87, 1, '2012-10-31', '21:37:18', 0, 'login', NULL, NULL, NULL, NULL),
(70, 1, '2012-10-25', '13:09:54', 0, 'logout', NULL, NULL, NULL, NULL),
(69, 1, '2012-10-25', '12:51:21', 0, 'login', NULL, NULL, NULL, NULL),
(68, 1, '2012-10-25', '12:51:14', 0, 'login', NULL, NULL, NULL, NULL),
(67, 1, '2012-10-25', '11:25:59', 0, 'logout', NULL, NULL, NULL, NULL),
(58, 1, '2012-10-23', '11:32:08', 0, 'login', NULL, NULL, NULL, NULL),
(86, 1, '2012-10-31', '14:36:47', 0, 'logout', NULL, NULL, NULL, NULL),
(85, 1, '2012-10-31', '10:17:51', 0, 'login', NULL, NULL, NULL, NULL),
(84, 1, '2012-10-27', '19:05:45', 0, 'logout', NULL, NULL, NULL, NULL),
(83, 1, '2012-10-27', '18:22:20', 0, 'login', NULL, NULL, NULL, NULL),
(82, 1, '2012-10-27', '14:57:34', 0, 'logout', NULL, NULL, NULL, NULL),
(77, 1, '2012-10-27', '08:02:31', 0, 'login', NULL, NULL, NULL, NULL),
(78, 1, '2012-10-27', '12:09:37', 0, 'logout', NULL, NULL, NULL, NULL),
(79, 1, '2012-10-27', '13:55:56', 0, 'login', NULL, NULL, NULL, NULL),
(80, 1, '2012-10-27', '14:55:52', 0, 'logout', NULL, NULL, NULL, NULL),
(81, 1, '2012-10-27', '14:56:35', 0, 'login', NULL, NULL, NULL, NULL),
(88, 1, '2012-10-31', '22:05:59', 0, 'logout', NULL, NULL, NULL, NULL),
(89, 1, '2012-11-01', '08:11:35', 0, 'login', NULL, NULL, NULL, NULL),
(90, 1, '2012-12-10', '08:12:51', 0, 'login', NULL, NULL, NULL, NULL),
(91, 1, '2012-12-25', '10:28:45', 0, 'login', NULL, NULL, NULL, NULL),
(92, 1, '2012-12-25', '11:44:29', 0, 'login', NULL, NULL, NULL, NULL),
(93, 1, '2012-12-26', '09:06:58', 0, 'login', NULL, NULL, NULL, NULL),
(94, 1, '2012-12-26', '09:46:18', 0, 'logout', NULL, NULL, NULL, NULL),
(95, 1, '2013-05-06', '07:58:04', 0, 'login', NULL, NULL, NULL, NULL),
(96, 1, '2013-05-07', '17:12:08', 0, 'login', NULL, NULL, NULL, NULL),
(97, 1, '2013-05-07', '18:09:09', 0, 'login', NULL, NULL, NULL, NULL),
(98, 1, '2013-05-08', '08:50:11', 0, 'login', NULL, NULL, NULL, NULL),
(99, 1, '2013-05-08', '09:31:50', 0, 'login', NULL, NULL, NULL, NULL),
(100, 1, '2013-05-08', '11:22:45', 0, 'logout', NULL, NULL, NULL, NULL),
(101, 1, '2013-05-09', '10:32:04', 0, 'login', NULL, NULL, NULL, NULL),
(102, 1, '2013-05-09', '13:49:33', 0, 'login', NULL, NULL, NULL, NULL),
(103, 1, '2013-05-09', '15:47:45', 0, 'logout', NULL, NULL, NULL, NULL),
(104, 1, '2013-05-10', '08:23:42', 0, 'login', NULL, NULL, NULL, NULL),
(105, 1, '2013-05-10', '09:40:38', 0, 'login', NULL, NULL, NULL, NULL),
(106, 1, '2013-05-10', '11:07:02', 0, 'login', NULL, NULL, NULL, NULL),
(107, 1, '2013-05-11', '09:22:42', 0, 'login', NULL, NULL, NULL, NULL),
(108, 1, '2013-05-11', '10:39:31', 0, 'login', NULL, NULL, NULL, NULL),
(109, 1, '2013-05-11', '12:02:08', 0, 'logout', NULL, NULL, NULL, NULL),
(110, 1, '2013-05-11', '16:33:52', 0, 'login', NULL, NULL, NULL, NULL),
(111, 1, '2013-05-11', '19:31:04', 0, 'logout', NULL, NULL, NULL, NULL),
(112, 1, '2013-05-12', '09:20:47', 0, 'login', NULL, NULL, NULL, NULL),
(113, 1, '2013-05-12', '11:53:37', 0, 'logout', NULL, NULL, NULL, NULL),
(114, 1, '2013-05-12', '21:21:52', 0, 'login', NULL, NULL, NULL, NULL),
(115, 1, '2013-05-13', '08:58:55', 0, 'login', NULL, NULL, NULL, NULL),
(116, 1, '2013-05-13', '10:36:09', 0, 'logout', NULL, NULL, NULL, NULL),
(117, 1, '2013-05-21', '10:06:18', 0, 'login', NULL, NULL, NULL, NULL),
(118, 1, '2013-05-21', '10:11:56', 0, 'login', NULL, NULL, NULL, NULL),
(119, 1, '2013-05-21', '11:52:53', 0, 'login', NULL, NULL, NULL, NULL),
(120, 1, '2013-05-21', '11:57:12', 0, 'logout', NULL, NULL, NULL, NULL),
(121, 1, '2013-05-21', '12:13:23', 0, 'login', NULL, NULL, NULL, NULL),
(122, 1, '2013-05-21', '12:15:34', 0, 'logout', NULL, NULL, NULL, NULL),
(123, 1, '2013-05-23', '14:28:50', 0, 'login', NULL, NULL, NULL, NULL),
(124, 1, '2013-05-23', '14:36:11', 0, 'logout', NULL, NULL, NULL, NULL),
(125, 1, '2013-05-23', '14:36:39', 0, 'login', NULL, NULL, NULL, NULL),
(126, 1, '2013-05-23', '15:36:51', 0, 'login', NULL, NULL, NULL, NULL),
(127, 1, '2013-05-23', '21:23:56', 0, 'login', NULL, NULL, NULL, NULL),
(128, 1, '2013-05-23', '22:03:57', 0, 'logout', NULL, NULL, NULL, NULL),
(129, 1, '2013-05-24', '08:58:08', 0, 'login', NULL, NULL, NULL, NULL),
(130, 1, '2013-05-24', '10:29:22', 0, 'login', NULL, NULL, NULL, NULL),
(131, 1, '2013-05-24', '11:27:25', 0, 'logout', NULL, NULL, NULL, NULL),
(132, 1, '2013-05-25', '11:11:56', 0, 'login', NULL, NULL, NULL, NULL),
(133, 1, '2013-05-25', '14:38:28', 0, 'logout', NULL, NULL, NULL, NULL),
(134, 1, '2013-05-25', '23:22:10', 0, 'login', NULL, NULL, NULL, NULL),
(135, 1, '2013-05-26', '10:43:48', 0, 'login', NULL, NULL, NULL, NULL),
(136, 1, '2013-05-27', '20:17:43', 0, 'login', NULL, NULL, NULL, NULL),
(137, 1, '2013-05-28', '09:03:35', 0, 'login', NULL, NULL, NULL, NULL),
(138, 1, '2013-05-28', '19:57:44', 0, 'login', NULL, NULL, NULL, NULL),
(139, 1, '2013-05-28', '20:38:46', 0, 'logout', NULL, NULL, NULL, NULL),
(140, 1, '2013-05-29', '07:20:11', 0, 'login', NULL, NULL, NULL, NULL),
(141, 1, '2013-05-29', '07:21:41', 0, 'logout', NULL, NULL, NULL, NULL),
(142, 1, '2013-05-29', '08:43:17', 0, 'login', NULL, NULL, NULL, NULL),
(143, 1, '2013-05-29', '18:55:04', 0, 'login', NULL, NULL, NULL, NULL),
(144, 1, '2013-05-29', '20:53:49', 0, 'logout', NULL, NULL, NULL, NULL),
(145, 1, '2013-05-30', '08:28:15', 0, 'login', NULL, NULL, NULL, NULL),
(146, 1, '2013-05-31', '10:22:08', 0, 'login', NULL, NULL, NULL, NULL),
(147, 1, '2013-05-31', '10:28:39', 0, 'logout', NULL, NULL, NULL, NULL),
(148, 1, '2013-05-31', '10:28:46', 0, 'login', NULL, NULL, NULL, NULL),
(149, 1, '2013-05-31', '10:41:45', 0, 'logout', NULL, NULL, NULL, NULL),
(150, 1, '2013-05-31', '10:42:21', 0, 'login', NULL, NULL, NULL, NULL),
(151, 1, '2013-05-31', '14:38:51', 0, 'login', NULL, NULL, NULL, NULL),
(152, 1, '2013-05-31', '15:49:10', 0, 'logout', NULL, NULL, NULL, NULL),
(153, 1, '2013-05-31', '18:26:44', 0, 'login', NULL, NULL, NULL, NULL),
(154, 1, '2013-05-31', '18:35:47', 0, 'logout', NULL, NULL, NULL, NULL),
(155, 1, '2013-06-04', '19:30:09', 0, 'login', NULL, NULL, NULL, NULL),
(156, 1, '2013-06-04', '20:31:03', 0, 'logout', NULL, NULL, NULL, NULL),
(157, 1, '2013-06-10', '10:27:43', 0, 'login', NULL, NULL, NULL, NULL),
(158, 1, '2013-06-10', '10:34:40', 0, 'logout', NULL, NULL, NULL, NULL),
(159, 1, '2013-06-11', '09:14:46', 0, 'login', NULL, NULL, NULL, NULL),
(160, 1, '2013-06-11', '09:51:08', 0, 'login', NULL, NULL, NULL, NULL),
(161, 1, '2013-06-11', '11:42:20', 0, 'login', NULL, NULL, NULL, NULL),
(162, 1, '2013-06-11', '12:42:32', 0, 'logout', NULL, NULL, NULL, NULL),
(163, 1, '2013-06-12', '09:05:08', 0, 'login', NULL, NULL, NULL, NULL),
(164, 1, '2013-06-12', '13:52:32', 0, 'logout', NULL, NULL, NULL, NULL),
(165, 1, '2014-03-25', '12:23:36', 0, 'login', NULL, NULL, NULL, NULL),
(166, 1, '2014-03-25', '12:27:44', 0, 'logout', NULL, NULL, NULL, NULL),
(167, 1, '2014-03-25', '16:10:14', 0, 'login', NULL, NULL, NULL, NULL),
(168, 1, '2014-03-25', '16:11:30', 0, 'login', NULL, NULL, NULL, NULL),
(169, 1, '2014-03-25', '16:15:34', 0, 'login', NULL, NULL, NULL, NULL),
(170, 1, '2014-03-25', '16:21:45', 0, 'login', NULL, NULL, NULL, NULL),
(171, 1, '2014-03-25', '16:25:15', 0, 'login', NULL, NULL, NULL, NULL),
(172, 1, '2014-03-25', '16:30:06', 0, 'logout', NULL, NULL, NULL, NULL),
(173, 1, '2015-08-08', '16:20:08', 0, 'login', NULL, NULL, NULL, NULL),
(174, 1, '2015-08-08', '16:35:47', 0, 'logout', NULL, NULL, NULL, NULL),
(175, 1, '2015-08-16', '08:46:10', 0, 'login', NULL, NULL, NULL, NULL),
(176, 1, '2015-08-18', '14:14:36', 0, 'login', NULL, NULL, NULL, NULL),
(177, 1, '2015-08-18', '19:41:16', 0, 'login', NULL, NULL, NULL, NULL),
(178, 1, '2015-08-19', '07:02:54', 0, 'login', NULL, NULL, NULL, NULL),
(179, 1, '2015-08-19', '08:35:10', 0, 'login', NULL, NULL, NULL, NULL),
(180, 1, '2015-08-19', '11:22:18', 0, 'logout', NULL, NULL, NULL, NULL),
(181, 1, '2015-08-19', '12:48:47', 0, 'login', NULL, NULL, NULL, NULL),
(182, 1, '2015-08-20', '06:38:57', 0, 'login', NULL, NULL, NULL, NULL),
(183, 1, '2015-08-20', '12:25:43', 0, 'login', NULL, NULL, NULL, NULL),
(184, 1, '2015-08-21', '07:26:26', 0, 'login', NULL, NULL, NULL, NULL),
(185, 1, '2015-08-21', '13:21:10', 0, 'login', NULL, NULL, NULL, NULL),
(186, 1, '2015-08-21', '15:20:26', 0, 'login', NULL, NULL, NULL, NULL),
(187, 1, '2015-08-21', '15:31:14', 0, 'logout', NULL, NULL, NULL, NULL),
(188, 1, '2015-09-10', '08:29:25', 0, 'login', NULL, NULL, NULL, NULL),
(189, 1, '2015-09-10', '08:29:33', 0, 'logout', NULL, NULL, NULL, NULL),
(190, 1, '2015-09-10', '08:32:07', 0, 'login', NULL, NULL, NULL, NULL),
(191, 1, '2015-09-10', '08:34:49', 0, 'logout', NULL, NULL, NULL, NULL),
(192, 1, '2015-09-10', '08:34:55', 0, 'login', NULL, NULL, NULL, NULL),
(193, 1, '2015-09-10', '08:41:06', 0, 'logout', NULL, NULL, NULL, NULL),
(194, 1, '2015-12-24', '12:51:33', 0, 'login', NULL, NULL, NULL, NULL),
(195, 1, '2016-11-24', '12:45:50', 0, 'login', '', NULL, NULL, NULL),
(196, 1, '2016-11-24', '12:55:13', 0, 'login', '', NULL, NULL, NULL),
(197, 1, '2016-11-24', '12:55:17', 0, 'login', '', NULL, NULL, NULL),
(198, 1, '2016-11-24', '13:18:12', 0, 'login', '', NULL, NULL, NULL),
(199, 1, '2016-11-24', '13:19:37', 0, 'logout', '', NULL, NULL, NULL),
(200, 1, '2016-11-24', '13:20:27', 0, 'login', '', NULL, NULL, NULL),
(201, 1, '2016-11-24', '13:20:30', 0, 'login', '', NULL, NULL, NULL),
(202, 1, '2016-11-24', '13:20:40', 0, 'login', '', NULL, NULL, NULL),
(203, 1, '2016-11-24', '13:20:40', 0, 'login', '', NULL, NULL, NULL),
(204, 1, '2016-11-24', '13:20:40', 0, 'login', '', NULL, NULL, NULL),
(205, 1, '2016-11-24', '13:20:40', 0, 'login', '', NULL, NULL, NULL),
(206, 1, '2016-11-24', '13:20:40', 0, 'login', '', NULL, NULL, NULL),
(207, 1, '2016-11-24', '13:20:40', 0, 'login', '', NULL, NULL, NULL),
(208, 1, '2016-11-24', '13:20:40', 0, 'login', '', NULL, NULL, NULL),
(209, 1, '2016-11-24', '13:20:40', 0, 'login', '', NULL, NULL, NULL),
(210, 1, '2016-11-24', '13:21:11', 0, 'login', '', NULL, NULL, NULL),
(211, 1, '2016-11-24', '13:34:58', 0, 'logout', '', NULL, NULL, NULL),
(212, 1, '2016-11-24', '13:35:02', 0, 'login', '', NULL, NULL, NULL),
(213, 1, '2016-11-24', '15:30:41', 0, 'login', '', NULL, NULL, NULL),
(214, 1, '2016-11-24', '15:34:50', 0, 'login', '', NULL, NULL, NULL),
(215, 1, '2016-11-24', '15:37:17', 92, 'update', '', NULL, NULL, NULL),
(216, 1, '2016-11-24', '15:41:45', 132, 'update', '', NULL, NULL, NULL),
(217, 1, '2016-11-24', '15:42:01', 132, 'update', '', NULL, NULL, NULL),
(218, 1, '2016-11-24', '15:42:45', 132, 'update', '', NULL, NULL, NULL),
(219, 1, '2016-11-24', '15:44:02', 132, 'update', '', NULL, NULL, NULL),
(220, 1, '2016-11-24', '15:44:29', 92, 'update', '', NULL, NULL, NULL),
(221, 1, '2016-11-24', '15:45:01', 132, 'update', '', NULL, NULL, NULL),
(222, 1, '2016-11-24', '15:45:15', 92, 'update', '', NULL, NULL, NULL),
(223, 1, '2016-11-24', '15:45:29', 132, 'update', '', NULL, NULL, NULL),
(224, 1, '2016-11-24', '15:51:27', 139, 'update', '', NULL, NULL, NULL),
(225, 1, '2016-11-24', '15:51:28', 139, 'update', '', NULL, NULL, NULL),
(226, 1, '2016-11-24', '15:51:29', 139, 'update', '', NULL, NULL, NULL),
(227, 1, '2016-11-24', '15:51:31', 139, 'update', '', NULL, NULL, NULL),
(228, 1, '2016-11-24', '15:54:37', 141, 'update', '', NULL, NULL, NULL),
(229, 1, '2016-11-24', '15:54:38', 141, 'update', '', NULL, NULL, NULL),
(230, 1, '2016-11-24', '15:59:57', 130, 'update', '', NULL, NULL, NULL),
(231, 1, '2016-11-24', '15:59:59', 130, 'update', '', NULL, NULL, NULL),
(232, 1, '2016-11-24', '16:00:49', 77, 'update', '', NULL, NULL, NULL),
(233, 1, '2016-11-24', '16:00:49', 77, 'update', '', NULL, NULL, NULL),
(234, 1, '2016-11-24', '16:00:50', 77, 'update', '', NULL, NULL, NULL),
(235, 1, '2016-11-24', '16:00:51', 77, 'update', '', NULL, NULL, NULL),
(236, 1, '2016-11-24', '16:02:48', 40, 'update', '', NULL, NULL, NULL),
(237, 1, '2016-11-24', '16:02:58', 40, 'update', '', NULL, NULL, NULL),
(238, 1, '2016-11-24', '16:03:32', 40, 'update', '', NULL, NULL, NULL),
(239, 1, '2016-11-24', '16:04:12', 40, 'update', '', NULL, NULL, NULL),
(240, 1, '2016-11-24', '16:05:09', 40, 'update', '', NULL, NULL, NULL),
(241, 1, '2016-11-24', '17:00:17', 0, 'create', '', NULL, NULL, NULL),
(242, 1, '2016-11-24', '17:01:03', 132, 'create', '', NULL, NULL, NULL),
(243, 1, '2016-11-24', '18:13:57', 0, 'update', '', NULL, NULL, NULL),
(244, 1, '2016-11-24', '18:14:25', 40, 'update', '', NULL, NULL, NULL),
(245, 1, '2016-11-24', '18:15:21', 147, 'create', '', NULL, NULL, NULL),
(246, 1, '2016-11-24', '18:15:45', 147, 'create', '', NULL, NULL, NULL),
(247, 1, '2016-11-24', '18:33:30', 139, 'update', '', NULL, NULL, NULL),
(248, 1, '2016-11-24', '18:33:39', 139, 'update', '', NULL, NULL, NULL),
(249, 1, '2016-11-24', '18:33:40', 139, 'update', '', NULL, NULL, NULL),
(250, 1, '2016-11-24', '18:33:41', 139, 'update', '', NULL, NULL, NULL),
(251, 1, '2016-11-24', '18:33:45', 139, 'update', '', NULL, NULL, NULL),
(252, 1, '2016-11-24', '18:34:01', 139, 'update', '', NULL, NULL, NULL),
(253, 1, '2016-11-24', '18:34:10', 139, 'delete', '', NULL, NULL, NULL),
(254, 1, '2016-11-24', '18:47:04', 136, 'update', '', NULL, NULL, NULL),
(255, 1, '2016-11-24', '18:47:05', 136, 'update', '', NULL, NULL, NULL),
(256, 1, '2016-11-24', '19:07:09', 0, 'logout', '', NULL, NULL, NULL),
(257, 1, '2016-11-29', '09:20:41', 0, 'login', '', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `login_status`
--

CREATE TABLE `login_status` (
  `userid` int(5) NOT NULL,
  `log` int(9) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_status`
--

INSERT INTO `login_status` (`userid`, `log`) VALUES
(1, 256);

-- --------------------------------------------------------

--
-- Table structure for table `manufacture`
--

CREATE TABLE `manufacture` (
  `id` int(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `orders` int(2) NOT NULL,
  `created` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `manufacture`
--

INSERT INTO `manufacture` (`id`, `name`, `image`, `orders`, `created`, `deleted`, `updated`) VALUES
(1, 'bentely', NULL, 1, '2016-11-24 18:15:21', NULL, NULL),
(2, 'bmw', NULL, 2, '2016-11-24 18:15:45', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `parent_id` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `position` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `name` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `type` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `url` varchar(100) COLLATE latin1_general_ci NOT NULL DEFAULT '#',
  `menu_order` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `class_style` varchar(25) COLLATE latin1_general_ci DEFAULT NULL,
  `id_style` varchar(25) COLLATE latin1_general_ci DEFAULT NULL,
  `default` int(1) NOT NULL DEFAULT '0',
  `limit` int(3) NOT NULL DEFAULT '5',
  `icon` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `target` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '_parent'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `parent_id`, `position`, `name`, `type`, `url`, `menu_order`, `class_style`, `id_style`, `default`, `limit`, `icon`, `target`) VALUES
(128, 0, '', 'Top', '', '#', 0, NULL, NULL, 0, 0, NULL, '_parent'),
(111, 0, 'top', 'Event & Gallery', 'modul', 'project/', 3, '', '', 0, 6, NULL, '_parent'),
(94, 0, 'top', 'Home', 'modul', 'home/', 0, '', 'selected', 0, 0, NULL, '_parent'),
(100, 0, 'top', 'About Us', 'article', 'article/get_article/companyprofile/', 1, '', '', 0, 5, 'Dodols.png', '_blank'),
(113, 0, 'top', 'Contact', 'modul', 'contactus/', 5, '', '', 0, 10, NULL, '_parent'),
(108, 100, 'middle', 'Our Profile', 'article', 'article/get_article/companyprofile/', 0, '', '', 0, 5, NULL, '_parent'),
(109, 0, 'top', 'Our Method', 'article', 'article/get_article/eventacara17/', 2, '', '', 0, 6, NULL, '_parent'),
(112, 0, 'top', 'Tips & Article', 'articlelist', 'article/get_category/tips/', 4, '', '', 0, 2, NULL, '_parent'),
(114, 112, 'middle', 'Tips', 'articlelist', 'article/get_category/tips/', 0, '', '', 0, 5, NULL, '_parent'),
(115, 112, 'middle', 'Carrier', 'article', 'article/get_article/coba/', 1, '', '', 0, 0, NULL, '_parent'),
(116, 100, 'middle', 'Visi & Misi', 'article', 'article/get_article/visionmision/', 1, '', '', 0, 5, NULL, '_parent'),
(117, 100, 'middle', 'Struktur Organization', 'article', 'article/get_article/strukturorganization/', 2, '', '', 0, 5, NULL, '_parent'),
(126, 100, 'bottom', 'Alumunium Composite Panel', 'article', 'article/get_article/apc/true/', 0, '', '', 0, 5, NULL, '_parent'),
(119, 100, 'bottom', 'Application & Feature', 'article', 'article/get_article/applicationandfeature/true/', 1, '', '', 0, 5, NULL, '_parent'),
(121, 100, 'bottom', 'High Glossy Series', 'article', 'article/get_article/highglossyseries/', 3, '', '', 0, 5, NULL, '_parent'),
(122, 100, 'bottom', 'Solid & Metallic Series', 'article', 'article/get_article/solidandmetallicseries/', 4, '', '', 0, 5, NULL, '_parent'),
(127, 100, 'bottom', 'Processing Method', 'article', 'article/get_article/processingmethod/', 2, '', '', 0, 5, NULL, '_parent'),
(125, 100, 'bottom', 'Certificated', 'article', 'article/get_article/certificated/', 7, '', '', 0, 5, NULL, '_parent');

-- --------------------------------------------------------

--
-- Table structure for table `modul`
--

CREATE TABLE `modul` (
  `id` int(5) NOT NULL,
  `name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `title` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `limit` int(3) NOT NULL DEFAULT '10',
  `publish` enum('Y','N') COLLATE latin1_general_ci NOT NULL,
  `status` enum('user','admin') COLLATE latin1_general_ci NOT NULL,
  `aktif` enum('Y','N') COLLATE latin1_general_ci NOT NULL,
  `role` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `icon` varchar(50) COLLATE latin1_general_ci DEFAULT 'default.png',
  `order` int(5) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `modul`
--

INSERT INTO `modul` (`id`, `name`, `title`, `limit`, `publish`, `status`, `aktif`, `role`, `icon`, `order`, `created`, `updated`, `deleted`) VALUES
(34, 'main', '', 10, 'N', 'admin', 'Y', 'admin,officer,staff', '', 0, NULL, NULL, NULL),
(39, 'log', 'Log History', 25, 'N', 'admin', 'Y', 'admin', 'log.png', 0, NULL, NULL, NULL),
(40, 'admin', 'User Login', 15, 'N', 'admin', 'Y', 'admin', 'admin.png', 0, NULL, NULL, NULL),
(41, 'login', '', 10, 'N', 'admin', 'Y', 'admin', '', 0, NULL, NULL, NULL),
(66, 'home', '', 10, 'Y', 'user', 'Y', 'admin,officer,staff', '', 0, NULL, NULL, NULL),
(130, 'article', 'Article', 25, 'Y', 'admin', 'Y', 'officer,admin,staff,marketing', 'news.png', 0, NULL, NULL, NULL),
(44, 'newscategory', 'Article Category', 10, 'N', 'admin', 'Y', 'officer,admin,staff', '', 0, NULL, NULL, NULL),
(47, 'configuration', 'Configuration', 10, 'N', 'admin', 'Y', 'admin', 'configuration.png', 0, NULL, NULL, NULL),
(131, 'widget', 'Widget', 25, 'Y', 'admin', 'Y', 'officer,admin', 'widget.png', 1, NULL, NULL, NULL),
(92, 'roles', 'Role  & Privileges', 15, 'N', 'admin', 'Y', 'admin', '', 0, NULL, NULL, NULL),
(77, 'language', 'Language', 10, 'Y', 'admin', 'Y', 'officer,admin,staff', '', 0, NULL, NULL, NULL),
(132, 'adminmenu', 'Menu Administrator', 25, 'Y', 'admin', 'Y', 'officer,admin', 'adminmenu.png', 2, NULL, NULL, NULL),
(134, 'frontmenu', 'Front Page Menu', 20, 'Y', 'admin', 'Y', 'officer,admin', 'menu.png', 3, NULL, NULL, NULL),
(135, 'city', 'City', 10, 'Y', 'admin', 'Y', 'officer,admin,staff,marketing', 'default.png', 5, NULL, NULL, NULL),
(136, 'product', 'Product', 15, 'Y', 'admin', 'Y', 'officer,admin', 'default.png', 5, NULL, NULL, NULL),
(137, 'prodesc', 'Product Description', 50, 'Y', 'admin', 'Y', 'officer,admin', 'default.png', 5, NULL, NULL, NULL),
(138, 'progallery', 'Product Gallery', 50, 'Y', 'admin', 'Y', 'officer,admin', 'default.png', 5, NULL, NULL, NULL),
(139, 'category', 'Product Category', 25, 'Y', 'admin', 'Y', 'officer,admin', 'default.png', 0, NULL, NULL, NULL),
(140, 'slider', 'Image Slider', 10, 'Y', 'admin', 'Y', 'officer,admin', 'default.png', 5, NULL, NULL, NULL),
(141, 'banner', 'Banner', 10, 'Y', 'admin', 'Y', 'officer,admin', 'default.png', 5, NULL, NULL, NULL),
(142, 'contactus', 'Contact Us', 15, 'Y', 'admin', 'Y', 'officer,admin,staff,marketing', 'default.png', 5, NULL, NULL, NULL),
(143, 'project', 'Project Portfolio', 9, 'Y', 'admin', 'Y', 'officer,admin', 'default.png', 5, NULL, NULL, NULL),
(144, 'newsbox', 'News Box', 1, 'Y', 'admin', 'Y', 'officer,admin', 'default.png', 5, NULL, NULL, NULL),
(145, 'testimonial', 'Testimonial', 9, 'Y', 'user', 'Y', 'officer,admin,staff,marketing', 'default.png', 5, NULL, NULL, NULL),
(146, 'menugal', 'Menu Gallery', 30, 'Y', 'admin', 'Y', 'officer,admin,staff', 'default.png', 5, NULL, NULL, NULL),
(147, 'manufacture', 'Manufactures', 1000, 'Y', 'admin', 'Y', 'officer,admin', 'default.png', 5, '2016-11-24 17:00:17', '2016-11-24 18:13:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `news_category`
--

CREATE TABLE `news_category` (
  `id` int(5) NOT NULL,
  `parent_id` int(3) NOT NULL,
  `name` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `desc` text COLLATE latin1_general_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `news_category`
--

INSERT INTO `news_category` (`id`, `parent_id`, `name`, `desc`, `created`, `deleted`, `updated`) VALUES
(20, 0, 'General', '', NULL, NULL, NULL),
(25, 0, 'Top', 'Root category', NULL, NULL, NULL),
(21, 0, 'Tips', 'Tips', NULL, NULL, NULL),
(22, 0, 'Carrer', 'Carrer', NULL, NULL, NULL),
(23, 0, 'delibond', 'delibond', NULL, NULL, NULL),
(24, 0, 'Event', 'Event Category Article', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(5) NOT NULL,
  `sku` varchar(100) NOT NULL,
  `category` int(3) NOT NULL,
  `manufacture` int(4) NOT NULL,
  `name` varchar(100) NOT NULL,
  `model` text NOT NULL,
  `permalink` varchar(300) NOT NULL,
  `currency` varchar(25) NOT NULL,
  `description` text,
  `shortdesc` text NOT NULL,
  `spesification` int(11) DEFAULT NULL,
  `meta_keywords` text,
  `meta_title` text,
  `meta_desc` text,
  `price` decimal(9,0) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `url_upload` int(1) NOT NULL,
  `url1` text,
  `url2` text,
  `url3` text,
  `url4` text,
  `url5` text,
  `publish` int(1) NOT NULL DEFAULT '0',
  `dimension` varchar(25) NOT NULL,
  `dimension_class` varchar(25) NOT NULL,
  `weight` varchar(10) NOT NULL,
  `related` text,
  `discount` decimal(6,0) NOT NULL,
  `qty` int(5) NOT NULL,
  `min_order` int(3) NOT NULL,
  `created` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `sku`, `category`, `manufacture`, `name`, `model`, `permalink`, `currency`, `description`, `shortdesc`, `spesification`, `meta_keywords`, `meta_title`, `meta_desc`, `price`, `image`, `url_upload`, `url1`, `url2`, `url3`, `url4`, `url5`, `publish`, `dimension`, `dimension_class`, `weight`, `related`, `discount`, `qty`, `min_order`, `created`, `deleted`, `updated`) VALUES
(6, '', 10, 0, 'Casement Window', '', '', '', '<ul>\r\n	<li>\r\n		Jendela dengan System Knock-down</li>\r\n	<li>\r\n		Pilihan Berbagai macam jenis bentuk Profile &amp; Model</li>\r\n	<li>\r\n		Pilihan Single dan Double Glaze</li>\r\n</ul>\r\n', 'Jendela dengan System Knock-down, Pilihan Berbagai macam jenis bentuk Profile & Model', NULL, NULL, NULL, NULL, '0', 'Casement_Window.jpg', 0, 'http://i1262.photobucket.com/albums/ii609/s41173/delica/product/C.jpg', 'http://i1262.photobucket.com/albums/ii609/s41173/delica/product/B.jpg', 'http://i1262.photobucket.com/albums/ii609/s41173/delica/product/A.jpg', NULL, NULL, 1, '', '', '', '', '0', 0, 0, NULL, NULL, NULL),
(7, '', 11, 0, 'Sliding Window', '', '', '', '<ul>\r\n	<li>\r\n		Jendela dengan System Knock-down</li>\r\n	<li>\r\n		System kendali, rel dan roda standar Internasional</li>\r\n	<li>\r\n		Dapat dirancang hingga 6 (enam) panel</li>\r\n</ul>\r\n', 'Jendela dengan System Knock-down, System kendali, rel dan roda standar Internasional', NULL, NULL, NULL, NULL, '0', 'Sliding_Window.jpg', 0, 'http://i1262.photobucket.com/albums/ii609/s41173/delica/product/url-1.jpg', 'http://i1262.photobucket.com/albums/ii609/s41173/delica/product/comm_windows_sliding.jpg', 'http://i1262.photobucket.com/albums/ii609/s41173/delica/product/1.jpg', NULL, NULL, 1, '', '', '', '', '0', 0, 0, NULL, NULL, NULL),
(8, '', 12, 0, 'Sliding Door', '', '', '', '<ul>\r\n	<li>\r\n		Pintu dengan System Knock-down</li>\r\n	<li>\r\n		System kendali, rel dan roda standar Internasional</li>\r\n	<li>\r\n		Dapat dirancang hingga 8 (delapan) panel dan System kasa nyamuk menyatu dengan panel</li>\r\n	<li>\r\n		Ultra High Permonfance Design</li>\r\n	<li>\r\n		Penguncian dengan System Multi-Lock</li>\r\n</ul>\r\n', 'System kendali, rel dan roda standar Internasional, Ultra High Permonfance Design', NULL, NULL, NULL, NULL, '0', 'Sliding_Door.jpg', 0, 'http://i1262.photobucket.com/albums/ii609/s41173/delica/product/wm_Aluminium-sliding-doors-.jpg', 'http://i1262.photobucket.com/albums/ii609/s41173/delica/product/PLATINUM-SLIDNG-DOOR-1.jpg', 'http://i1262.photobucket.com/albums/ii609/s41173/delica/product/aluminium-and-glass-sliding.jpg', NULL, NULL, 1, '', '', '', '', '0', 0, 0, NULL, NULL, NULL),
(9, '', 13, 0, 'Swing Door', '', '', '', '<ul>\r\n	<li>\r\n		Pintu dengan System Knock-down</li>\r\n	<li>\r\n		Presisi, Engsel dan kunci system double-lock</li>\r\n	<li>\r\n		Pilihan Single dan Double Glaze</li>\r\n</ul>\r\n', 'Presisi, Engsel dan kunci system double-lock, Pilihan Single dan Double Glaze', NULL, NULL, NULL, NULL, '0', 'Swing_Door.jpg', 0, 'http://i1262.photobucket.com/albums/ii609/s41173/delica/product/sliding-door-800x800.jpg', 'http://i1262.photobucket.com/albums/ii609/s41173/delica/product/Aluminium_Swing_Door.jpg', 'http://i1262.photobucket.com/albums/ii609/s41173/delica/product/AAD_8168.jpg', NULL, NULL, 1, '', '', '', '', '0', 0, 0, NULL, NULL, NULL),
(10, '', 14, 0, 'Folding Door', '', '', '', '<ul>\r\n	<li>\r\n		Pintu dengan System Knock-down</li>\r\n	<li>\r\n		System kendali, rel, roda, engsel dirancang menyatu dengan pintu hingga tingkat presisi 100%</li>\r\n	<li>\r\n		Pilihan panel terbuka ke dalam keluar, berlawanan, dan sebaliknya</li>\r\n	<li>\r\n		Pilihan Double dan Triple Glaze</li>\r\n	<li>\r\n		Berbahan Aluminium Alloy tebal dan kuat serta system multi-lock menjamin system keamanan</li>\r\n</ul>\r\n', 'System kendali, rel, roda, engsel dirancang menyatu dengan pintu hingga tingkat presisi 100%, Pintu dengan System Knock-down', NULL, NULL, NULL, NULL, '0', 'Folding_Door.jpg', 0, 'http://i1262.photobucket.com/albums/ii609/s41173/delica/product/203Aluminum-Bi-Folding-Door.jpg', 'http://i1262.photobucket.com/albums/ii609/s41173/delica/product/patio_door_aluminium_foldin.jpg', 'http://i1262.photobucket.com/albums/ii609/s41173/delica/product/url.jpg', NULL, NULL, 1, '', '', '', '', '0', 0, 0, NULL, NULL, NULL),
(11, '', 9, 0, 'Curtain Wall', '', '', '', '<ul>\r\n	<li>\r\n		Invisible Series Curtain Wall dengan Double / Triple Glass Insulation</li>\r\n	<li>\r\n		Visible Series Curtain Wall dengan Double / Triple Glass Insulation</li>\r\n	<li>\r\n		Mencegah panas terik matahari yang langsung menyinari ruangan</li>\r\n</ul>\r\n', 'Invisible Series Curtain Wall dengan Double / Triple Glass Insulation', NULL, NULL, NULL, NULL, '0', 'Curtain_Wall.jpg', 0, 'http://i1262.photobucket.com/albums/ii609/s41173/delica/product/curtain-wall.jpg', 'http://i1262.photobucket.com/albums/ii609/s41173/delica/product/curtain_walling_4_large.jpg', 'http://i1262.photobucket.com/albums/ii609/s41173/delica/product/9adbe0baaed6902b7f20921837f.jpg', NULL, NULL, 1, '', '', '', '', '0', 0, 0, NULL, NULL, '2016-11-24 18:47:05');

-- --------------------------------------------------------

--
-- Table structure for table `property`
--

CREATE TABLE `property` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `phone1` varchar(100) NOT NULL,
  `phone2` varchar(100) NOT NULL,
  `fax` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `billing_email` varchar(100) NOT NULL,
  `technical_email` varchar(100) DEFAULT NULL,
  `cc_email` varchar(100) NOT NULL,
  `zip` int(10) NOT NULL,
  `city` char(30) NOT NULL,
  `account_name` varchar(100) NOT NULL,
  `account_no` varchar(100) NOT NULL,
  `bank` text NOT NULL,
  `site_name` varchar(100) NOT NULL,
  `logo` text,
  `meta_description` text NOT NULL,
  `meta_keyword` text NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `property`
--

INSERT INTO `property` (`id`, `name`, `address`, `phone1`, `phone2`, `fax`, `email`, `billing_email`, `technical_email`, `cc_email`, `zip`, `city`, `account_name`, `account_no`, `bank`, `site_name`, `logo`, `meta_description`, `meta_keyword`, `created`, `updated`, `deleted`) VALUES
(1, 'Dswip Kreasindo', 'JL. Ayahanda\n', '0', '0-0', '061-4522712', 'info@dswip.com', 'info@dswip.com', 'info@dswip.com', 'info@dswip.com', 0, 'Medan', 'GP', '105-000-000000-0', 'Unknow', 'Dswip Kreasindo', 'logo.png', 'Dswip Kreasindo', 'Dswip Kreasindo', NULL, '2016-11-24 16:05:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(2) NOT NULL,
  `name` varchar(100) NOT NULL,
  `desc` text NOT NULL,
  `rules` int(1) NOT NULL DEFAULT '1',
  `granted_menu` text,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `desc`, `rules`, `granted_menu`, `created`, `updated`, `deleted`) VALUES
(2, 'officer', 'Manage allsss', 2, NULL, NULL, NULL, NULL),
(4, 'admin', 'Administrator', 3, '54,165', NULL, '2016-11-24 15:45:15', NULL),
(7, 'staff', 'general staff', 1, NULL, NULL, NULL, NULL),
(8, 'marketing', 'marketing', 4, '', NULL, '2016-11-24 15:37:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) DEFAULT NULL,
  `site_offline` tinyint(4) DEFAULT '0',
  `offline_reason` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `id` int(2) NOT NULL,
  `name` varchar(50) NOT NULL,
  `image` text,
  `url` text NOT NULL,
  `created` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`id`, `name`, `image`, `url`, `created`, `deleted`, `updated`) VALUES
(16, 'Slider 2', 'Slider_2.jpg', 'www.done.com', NULL, NULL, NULL),
(15, 'Test Slider 1', 'Test_Slider_1.jpg', 'bla bla', NULL, NULL, NULL),
(17, 'Slider 3', 'Slider_3.jpg', 'www.slider.com', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `testimonial`
--

CREATE TABLE `testimonial` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `dates` date NOT NULL,
  `desc` text NOT NULL,
  `image` varchar(100) NOT NULL,
  `url` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `testimonial`
--

INSERT INTO `testimonial` (`id`, `name`, `dates`, `desc`, `image`, `url`, `status`) VALUES
(4, 'Steve Jobs', '2015-08-19', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Steve_Jobs.jpg', 'www.apple.com', 0),
(5, 'Tom Cruise', '2015-08-20', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Tom_Cruise.jpg', 'www.missionimpossible.com', 0),
(6, 'Oprah Winfley', '2015-08-20', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Oprah_Winfley.jpeg', 'desc', 0),
(7, 'Bill Gates', '2015-08-20', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five ', 'Bill_Gates.jpeg', 'www.microsoft.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(3) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `phone1` varchar(15) NOT NULL,
  `phone2` varchar(13) NOT NULL,
  `city` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `yahooid` varchar(100) DEFAULT NULL,
  `role` char(20) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `lastlogin` varchar(10) NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `name`, `address`, `phone1`, `phone2`, `city`, `email`, `yahooid`, `role`, `status`, `lastlogin`, `created`, `updated`, `deleted`) VALUES
(1, 'admin', 'admin', 'Administrator', 'desc', '0618218907', '', '3', 'sanjaya.kiran@gmail.com', '1', 'admin', 1, '', NULL, '2016-11-24 18:14:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `widget`
--

CREATE TABLE `widget` (
  `id` int(2) NOT NULL,
  `name` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `position` char(10) NOT NULL,
  `order` int(2) NOT NULL DEFAULT '0',
  `publish` int(1) NOT NULL,
  `menu` text NOT NULL,
  `moremenu` int(5) NOT NULL,
  `limit` int(3) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `widget`
--

INSERT INTO `widget` (`id`, `name`, `title`, `position`, `order`, `publish`, `menu`, `moremenu`, `limit`, `created`, `updated`, `deleted`) VALUES
(12, 'wow', 'Wow Slider', 'user3', 0, 1, '0', 0, 0, NULL, NULL, NULL),
(32, 'midmenu', 'Middle Menu', 'user13', 0, 1, '71,73,72', 78, 0, NULL, NULL, NULL),
(45, 'latestnews', 'latestnews', 'user8', 0, 1, '1,74', 73, 5, NULL, NULL, NULL),
(39, 'contact', 'contact', 'user12', 0, 1, '81,76,77,75,1,74,73,71,72,79,80', 76, 0, NULL, NULL, NULL),
(44, 'latestarticle', 'latestarticle', 'user10', 0, 1, '94', 0, 5, NULL, NULL, NULL),
(47, 'catmenu', 'catmenu', 'user15', 0, 1, '75', 75, 5, NULL, NULL, NULL),
(48, 'Test', 'Test aja Ah', 'user1', 2, 1, '100', 94, 6, NULL, NULL, NULL),
(49, 'event_list', 'event_list', 'user2', 0, 1, '111', 0, 20, NULL, NULL, NULL),
(50, 'Test', 'Test aja Ah', 'user1', 2, 1, '100', 94, 5, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_menu`
--
ALTER TABLE `admin_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `attribute`
--
ALTER TABLE `attribute`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attribute_list`
--
ALTER TABLE `attribute_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attribute_product`
--
ALTER TABLE `attribute_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `captcha`
--
ALTER TABLE `captcha`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `last_activity_idx` (`last_activity`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_id` (`article_id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `manufacture`
--
ALTER TABLE `manufacture`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modul`
--
ALTER TABLE `modul`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news_category`
--
ALTER TABLE `news_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property`
--
ALTER TABLE `property`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonial`
--
ALTER TABLE `testimonial`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `widget`
--
ALTER TABLE `widget`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_menu`
--
ALTER TABLE `admin_menu`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;
--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;
--
-- AUTO_INCREMENT for table `attribute`
--
ALTER TABLE `attribute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `attribute_list`
--
ALTER TABLE `attribute_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `attribute_product`
--
ALTER TABLE `attribute_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `captcha`
--
ALTER TABLE `captcha`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `language`
--
ALTER TABLE `language`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=258;
--
-- AUTO_INCREMENT for table `manufacture`
--
ALTER TABLE `manufacture`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;
--
-- AUTO_INCREMENT for table `modul`
--
ALTER TABLE `modul`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;
--
-- AUTO_INCREMENT for table `news_category`
--
ALTER TABLE `news_category`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `testimonial`
--
ALTER TABLE `testimonial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `widget`
--
ALTER TABLE `widget`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
