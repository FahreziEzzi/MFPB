-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Mar 2024 pada 15.41
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_perpustakaan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id` int(11) NOT NULL,
  `perpus_id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `cover` varchar(255) NOT NULL,
  `pdf` varchar(255) NOT NULL,
  `penulis` varchar(255) NOT NULL,
  `penerbit` varchar(255) NOT NULL,
  `tahun_terbit` int(11) NOT NULL,
  `stok` int(255) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id`, `perpus_id`, `judul`, `deskripsi`, `cover`, `pdf`, `penulis`, `penerbit`, `tahun_terbit`, `stok`, `kategori_id`, `created_at`) VALUES
(51, 1, '101 Kisah Tabiin', 'MasyaAllah', 'uploads/kisah tabiin.jpg', 'pdf/101 Kisah Tabi’in (Hepi Andi Bastoni) (z-lib.org).pdf', 'Nurkholis fudwan lr', 'PUSTAKAAI KAUTSAR', 2006, 10, 1, '2024-03-04 06:10:38'),
(52, 1, 'The Hunger Games', 'The Hunger Games menceritakan mengenai seorang gadis berusia 16 tahun bernama Katniss (Jennifer Lawrence) yang tinggal bersama ibu dan adiknya di Distrik 12\r\n', 'uploads/thehunger.jpg', 'pdf/The Hunger Games (Suzanne Collins) (Z-Library).pdf', 'Suzanne Collins', 'PT Gramedia', 2008, 2, 3, '2024-03-04 13:02:19'),
(53, 1, 'Red Rising', 'Darrow is given the chance to infiltrate the Society to bring it down from within. He is physically transformed by Mickey, a Violet ', 'uploads/ID_GPU2017MTH03KMR_B.jpg', 'pdf/Kebangkitan Merah (Red Rising) (Pierce Brown) (Z-Library).pdf', 'Pierce Brown', 'PT Gramedia', 2014, 5, 0, '2024-03-05 01:50:33'),
(54, 1, 'Analisis Big Data', 'Analitik big data memeriksa sejumlah besar data untuk mengungkap pola tersembunyi, korelasi, dan wawasan lainnya. ', 'uploads/data.jpg', 'pdf/Analisis Big Data (Dr. Joseph Teguh Santoso, S.Kom., M.Kom.) (Z-Library).pdf', 'Dr Joseph', 'Yayasan prima agus teknik', 2007, 4, 4, '2024-03-04 03:41:34'),
(55, 1, 'Nozomanu Fushi No Boukensha', 'Menceritakan seorang petualang yang mati oleh skeleton dragon di dungeon dia pikir dia mati di dungeon tapi ternyata dia hidup kembali menjadi undead. Ini adalah kisah seorang petualang yang terpaksa hidup sabagai undead', 'uploads/The-Unwanted-Undead-Adventurer.jpeg', 'pdf/[ Meganei ] Nozom.Fush.no.Bouken VOLUME 001.pdf', 'Yuu Okano', 'Shosetsuka ni naro', 2016, 10, 5, '2024-03-05 01:35:24'),
(56, 1, 'Dilan 1990', '\"Dilan 1990\" adalah sebuah novel yang menggambarkan kisah cinta yang penuh dengan kehangatan, kejujuran, dan kegembiraan pada era tahun 1990-an di Indonesia. Cerita ini membawa pembaca dalam perjalanan emosional yang menggugah, mengeksplorasi hubungan antara Dilan, seorang pemuda yang penuh keberanian dan penuh semangat, dengan Milea, seorang gadis yang penuh kecerdasan dan keanggunan.', 'uploads/Dilan_1990_(poster).jpg', 'pdf/pdf-dilan-1-shabrinabachtiarpdf_compress.pdf', 'Pidi Baiq', 'PT Gramedia', 2016, 7, 2, '2024-03-05 01:38:49'),
(57, 1, 'Laut Bercerita', 'Novel \"Laut Bercerita\" ditulis oleh Leila S. Chudori dan pertama kali diterbitkan pada tahun 2004. Novel ini menggambarkan kisah tentang tragedi politik di Indonesia pada tahun 1965, yang menyisakan duka mendalam bagi banyak orang. ', 'uploads/laut.jpg', 'pdf/pdfcoffee_com_sb-laut-bercerita-leila-s-chudoripdf-pdf-free.pdf', 'Leila S.Chudori', 'Kepustakaan populer gramedia', 2004, 7, 7, '2024-03-05 11:54:32'),
(58, 1, 'The Legeng Of The Rings', 'The Lord of the Rings mengikuti perjalanan sekelompok karakter yang berusaha untuk menghentikan kekuatan jahat Sauron dengan menghancurkan cincin kekuasaannya yang kuat. ', 'uploads/72.jpg', 'pdf/The Lord of the Rings 1.pdf', 'JRR Tolkien', 'Allen dan Unwin', 1954, 6, 8, '2024-03-05 01:47:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_buku`
--

CREATE TABLE `kategori_buku` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kategori_buku`
--

INSERT INTO `kategori_buku` (`id`, `nama_kategori`, `created_at`) VALUES
(2, 'comedy', '2024-03-05 14:37:27'),
(3, 'horor', '2024-02-20 15:13:45'),
(4, 'Pemograman\r\n', '2024-03-04 01:54:23'),
(5, 'Action', '2024-03-04 01:55:02'),
(7, 'fiksi ', '2024-03-05 01:41:50'),
(8, 'Fantasy\r\n', '2024-03-05 01:45:41'),
(9, 'Romance', '2024-03-05 01:45:58'),
(10, 'Religi', '2024-03-05 13:23:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `koleksi_pribadi`
--

CREATE TABLE `koleksi_pribadi` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `buku` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `koleksi_pribadi`
--

INSERT INTO `koleksi_pribadi` (`id`, `user`, `buku`, `created_at`) VALUES
(79, 5, 11, '2024-02-12 06:19:35'),
(93, 5, 12, '2024-02-16 06:34:08'),
(105, 23, 17, '2024-02-29 02:55:06'),
(107, 23, 15, '2024-02-29 04:47:03'),
(121, 23, 53, '2024-03-05 01:22:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `buku` int(11) NOT NULL,
  `tanggal_peminjaman` date NOT NULL,
  `tanggal_pengembalian` date NOT NULL,
  `status_peminjaman` enum('Dipinjam','Dikembalikan','','') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `user`, `buku`, `tanggal_peminjaman`, `tanggal_pengembalian`, `status_peminjaman`, `created_at`) VALUES
(129, 23, 51, '2024-03-04', '2024-03-04', 'Dikembalikan', '2024-03-04 02:48:04'),
(130, 23, 51, '2024-03-04', '2024-03-04', 'Dikembalikan', '2024-03-04 02:48:09'),
(131, 23, 51, '2024-03-04', '2024-03-04', 'Dikembalikan', '2024-03-04 02:48:20'),
(132, 23, 51, '2024-03-04', '2024-03-04', 'Dikembalikan', '2024-03-04 02:48:54'),
(133, 23, 51, '2024-03-04', '2024-03-04', 'Dikembalikan', '2024-03-04 03:34:05'),
(134, 23, 53, '2024-03-04', '2024-03-04', 'Dikembalikan', '2024-03-04 03:34:05'),
(135, 23, 54, '2024-03-04', '2024-03-04', 'Dikembalikan', '2024-03-04 03:34:05'),
(136, 31, 54, '2024-03-04', '2024-03-04', 'Dikembalikan', '2024-03-04 03:37:49'),
(137, 31, 54, '2024-03-04', '2024-03-04', 'Dikembalikan', '2024-03-04 03:41:34'),
(138, 31, 51, '2024-03-04', '2024-03-04', 'Dikembalikan', '2024-03-04 03:41:31'),
(139, 31, 52, '2024-03-04', '2024-03-04', 'Dikembalikan', '2024-03-04 03:41:32'),
(140, 31, 53, '2024-03-04', '2024-03-04', 'Dikembalikan', '2024-03-04 03:43:18'),
(141, 23, 53, '2024-03-04', '2024-03-05', 'Dikembalikan', '2024-03-05 00:31:23'),
(142, 5, 53, '2024-03-04', '2024-03-04', 'Dikembalikan', '2024-03-04 04:41:23'),
(143, 5, 53, '2024-03-04', '2024-03-09', 'Dipinjam', '2024-03-04 04:41:25'),
(144, 23, 52, '2024-03-04', '2024-03-04', 'Dikembalikan', '2024-03-04 06:09:54'),
(145, 23, 51, '2024-03-04', '2024-03-04', 'Dikembalikan', '2024-03-04 06:10:38'),
(146, 23, 52, '2024-03-04', '2024-03-04', 'Dikembalikan', '2024-03-04 06:21:50'),
(147, 23, 52, '2024-03-04', '2024-03-04', 'Dikembalikan', '2024-03-04 12:03:47'),
(148, 23, 52, '2024-03-04', '2024-03-04', 'Dikembalikan', '2024-03-04 12:03:47'),
(149, 23, 52, '2024-03-04', '2024-03-04', 'Dikembalikan', '2024-03-04 13:02:19'),
(150, 23, 53, '2024-03-05', '2024-03-10', 'Dipinjam', '2024-03-05 00:31:29'),
(151, 23, 57, '2024-03-05', '2024-03-05', 'Dikembalikan', '2024-03-05 11:54:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `perpustakaan`
--

CREATE TABLE `perpustakaan` (
  `id` int(11) NOT NULL,
  `nama_perpus` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_tlp` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `perpustakaan`
--

INSERT INTO `perpustakaan` (`id`, `nama_perpus`, `alamat`, `no_tlp`, `created_at`) VALUES
(1, 'Perpustakaan Banjar', 'Depan Terminal', '0999022332', '2024-01-17 02:50:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `reset_password`
--

CREATE TABLE `reset_password` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `reset_code` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `reset_password`
--

INSERT INTO `reset_password` (`id`, `email`, `reset_code`) VALUES
(1, 'albiafabiansya@gmail.com', '889594'),
(2, 'albiafabiansya@gmail.com', '264570'),
(3, 'albiafabiansya@gmail.com', '766805'),
(4, 'albiafabiansya@gmail.com', '105329'),
(5, 'albiafabiansya@gmail.com', '457586'),
(6, 'albiafabiansya@gmail.com', '421650'),
(7, 'albiafabiansya@gmail.com', '694060'),
(8, 'albiafabiansya@gmail.com', '472467'),
(9, 'albiafabiansya@gmail.com', '907203'),
(10, 'fahrezireziw1054@gmail.com', '334751'),
(11, 'albiafabiansya@gmail.com', '834896'),
(12, 'albiafabiansya@gmail.com', '654478'),
(13, 'fahrezireziw1054@gmail.com', '032327');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ulasan_buku`
--

CREATE TABLE `ulasan_buku` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `buku` int(11) NOT NULL,
  `ulasan` text NOT NULL,
  `rating` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `ulasan_buku`
--

INSERT INTO `ulasan_buku` (`id`, `user`, `buku`, `ulasan`, `rating`, `created_at`) VALUES
(29, 29, 15, 'haha', 2, '2024-02-25 03:23:14'),
(30, 23, 15, 'mantappp', 4, '2024-02-26 03:16:39'),
(31, 23, 17, 'Buku Bahasa Inggris ini Sangat bermanfaat untuk orang yang ingin mencari ilmu bahasa inggris', 3, '2024-02-29 00:54:33'),
(32, 5, 13, 'Manhwa ini sangat bagus\r\n', 5, '2024-02-29 06:47:53'),
(33, 5, 36, 'Keren', 3, '2024-02-29 06:50:02'),
(34, 23, 37, 'Buku tentang kisah tabiin ini sangat saya sukai', 5, '2024-02-29 12:09:56'),
(35, 29, 37, 'MasyaAllah', 5, '2024-02-29 12:10:32'),
(36, 23, 39, 'MasyaAllah', 5, '2024-02-29 15:46:55'),
(37, 30, 39, 'MasyaAllah sangat menginspirasi', 4, '2024-02-29 15:48:43'),
(38, 23, 48, 'sangat keren saya sangat suka', 5, '2024-03-01 10:08:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `perpus_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verification_code` varchar(10) NOT NULL,
  `verified` tinyint(1) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `role` enum('admin','petugas','peminjam','') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `perpus_id`, `username`, `password`, `verification_code`, `verified`, `email`, `nama_lengkap`, `alamat`, `role`, `created_at`) VALUES
(5, 12, 'ezi', '$2y$10$GI79jJnqIOxBzhofvHJP8unGmVFEeLG9GU4WCsnvTnsm880XhRuSC', '', 0, 'ezi@gmail.com', 'fahrezi', 'banjar', 'admin', '2024-01-23 10:22:03'),
(21, 1, 'lorem', '$2y$10$8/NlW5HxrPeioAZqYTKOi.hIIjb6xQ0x59B0hwN6ovIjYEkT2v3rq', '', 0, 'lorem@gmail.com', 'mas lorem', 'test', 'petugas', '2024-02-03 10:07:50'),
(23, 1, 'albia sukma', '$2y$10$imQeN5dyfPfEQm3Zw31Owe3qTb8iI.OQYRBpgYku1z7vNqMzk7D8K', '', 0, 'albia@gmail.com', 'alcoy', 'g.bawang', 'peminjam', '2024-02-06 02:29:45'),
(24, 1, 'sas', '$2y$10$z9W0P0OPe3Fjn2qitDU.U.sUVsyLwafG3YToJu5FtTC.KxY9f7PRi', '', 0, 'lorem@gmail.com', 'fahrezi', 'asd', 'peminjam', '2024-02-13 01:52:28'),
(26, 1, 'Fahrezi', '$2y$10$drkzAVCFQl0qXC1VxH/wnuIxwerIxpFr5fb0PfX0QTkKAYU4iipee', '', 0, 'fahrezireziw1054@gmail.com', 'ezi', 'banjar', 'admin', '2024-02-19 14:06:06'),
(27, 1, 'aal', '$2y$10$i5v.iEBcVcfj8/H0DCpO0etpGOHi3FAc9az3NvGw3M1dAOZo4KUMC', '', 0, 'albiafabiansya@gmail.com', 'test', 'ADKL', 'peminjam', '2024-02-20 02:43:44'),
(28, 1, 'zahwan', '$2y$10$GJNsmupJd6V8UyPckkux4eL53IodWAqGT2vvu3AftiJqUPKe36WMS', '', 0, 'thewanes316@gmail.com', 'wan', 'ciktim', 'peminjam', '2024-02-20 00:42:51'),
(29, 1, 'test', '$2y$10$XgXe9DOkvKlhDfKlPwPoEu91LTgn8EnHobvoUZ4DEVBlbKYG.2rYO', '', 0, 'peminjam@gmail.com', 'tester', 'test', 'peminjam', '2024-02-21 09:18:55'),
(30, 1, 'Ezzi', '$2y$10$ct6cdgtN129LqELN0.tKCesqQ/QFgTWRu7jacJBJl9T.lZpJC99bK', '', 0, 'mfp@gmail.com', 'fahrezi', 'banjar', 'peminjam', '2024-02-29 15:48:18'),
(31, 1, 'didaarfiana', '$2y$10$5YZt93DDre2XFl65oCBA2uZM4Q1UPtvk9NPmyr6uqQYnwH1ixGmnG', '', 0, 'dida@gmail.com', 'dida arfiana', 'jalan cikapundung\r\n', 'peminjam', '2024-03-04 03:37:19');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kategori_buku`
--
ALTER TABLE `kategori_buku`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `koleksi_pribadi`
--
ALTER TABLE `koleksi_pribadi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `perpustakaan`
--
ALTER TABLE `perpustakaan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `reset_password`
--
ALTER TABLE `reset_password`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ulasan_buku`
--
ALTER TABLE `ulasan_buku`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT untuk tabel `kategori_buku`
--
ALTER TABLE `kategori_buku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `koleksi_pribadi`
--
ALTER TABLE `koleksi_pribadi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT untuk tabel `perpustakaan`
--
ALTER TABLE `perpustakaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `reset_password`
--
ALTER TABLE `reset_password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `ulasan_buku`
--
ALTER TABLE `ulasan_buku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
