-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2023 at 08:09 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pmb`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_sisa_kuota` ()   BEGIN
                DECLARE prodi_id INT;
                DECLARE total_registers INT;
            
                -- Loop through each prodi
                DECLARE prodi_cursor CURSOR FOR SELECT id FROM prodis;
                DECLARE CONTINUE HANDLER FOR NOT FOUND SET prodi_id = NULL;
            
                OPEN prodi_cursor;
            
                prodi_loop: LOOP
                    FETCH prodi_cursor INTO prodi_id;
                    IF prodi_id IS NULL THEN
                        LEAVE prodi_loop;
                    END IF;
            
                    -- Calculate total registers for the current prodi
                    SET total_registers = (
                        SELECT COUNT(*)
                        FROM registers
                        WHERE diterima_di = prodi_id
                    );
            
                    -- Update sisa_kuota for the current prodi
                    UPDATE prodis
                    SET sisa_kuota = kuota - total_registers
                    WHERE id = prodi_id;
                END LOOP;
            
                CLOSE prodi_cursor;
            END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_pemilik` varchar(255) NOT NULL,
  `nomor_rekening` varchar(255) DEFAULT NULL,
  `nama_bank` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `berkas_pendaftars`
--

CREATE TABLE `berkas_pendaftars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `ijazah_skl` text DEFAULT NULL,
  `ijazah_skl_file` text DEFAULT NULL,
  `skhun` text DEFAULT NULL,
  `skhun_file` text DEFAULT NULL,
  `kk` text DEFAULT NULL,
  `kk_file` text DEFAULT NULL,
  `ktp` text DEFAULT NULL,
  `ktp_file` text DEFAULT NULL,
  `akta` text DEFAULT NULL,
  `akta_file` text DEFAULT NULL,
  `pas_foto` text DEFAULT NULL,
  `pas_foto_file` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `informasis`
--

CREATE TABLE `informasis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `informasi_kampuses`
--

CREATE TABLE `informasi_kampuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `noTelp` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `informasi_kampuses`
--

INSERT INTO `informasi_kampuses` (`id`, `name`, `alamat`, `email`, `noTelp`, `created_at`, `updated_at`) VALUES
(1, 'STKIP PGRI Bangkalan', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jalur_masuks`
--

CREATE TABLE `jalur_masuks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `biaya` bigint(20) NOT NULL DEFAULT 0,
  `jumlah_pendaftar` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `jumlah_maks_pendaftar` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `status` enum('aktif','tidak aktif') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jalur_masuks`
--

INSERT INTO `jalur_masuks` (`id`, `nama`, `deskripsi`, `biaya`, `jumlah_pendaftar`, `jumlah_maks_pendaftar`, `status`, `created_at`, `updated_at`) VALUES
(5, 'yrtyrt ', 'tyry', 100000, 0, 50, 'aktif', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jenjang_pendidikans`
--

CREATE TABLE `jenjang_pendidikans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenjang_pendidikans`
--

INSERT INTO `jenjang_pendidikans` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(2, 's1 PKN', '2023-11-29 00:23:56', '2023-11-29 00:23:56');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(5, '2023_04_06_034731_create_jenjang_pendidikan_table', 2),
(6, '2023_04_06_034846_create_sistem_kuliah_table', 3),
(7, '2023_04_06_034932_create_jalur_masuk_table', 4),
(8, '2023_04_06_034955_create_prodi_table', 5),
(9, '2023_04_06_031535_create_registers_table', 6),
(10, '2014_10_12_100000_create_password_reset_tokens_table', 7),
(11, '2019_08_19_000000_create_failed_jobs_table', 7),
(12, '2019_12_14_000001_create_personal_access_tokens_table', 7),
(13, '2023_04_17_072210_update_registers_table', 7),
(14, '2023_04_18_014746_update_users_table', 7),
(15, '2023_04_18_054742_add_bukti_pembayaran_to_registers_table', 7),
(16, '2023_04_28_145459_create_banks_table', 7),
(17, '2023_04_28_165446_create_informasi_kampuses_table', 7),
(18, '2023_04_29_020213_create_sosmeds_table', 7),
(19, '2023_04_29_163329_add_biaya_to_jalur_masuk_table', 7),
(20, '2023_04_30_020837_add_columns_and_triggers_to_jalur_masuks_table', 7),
(21, '2023_05_04_082653_create_informasis_table', 7),
(22, '2023_05_05_092452_create_slug_to_informasis_table', 7),
(23, '2023_05_08_054903_create_deskripsi_to_prodis_table', 7),
(24, '2023_05_08_055034_create_deskripsi_to_jalur_masuks_table', 7),
(25, '2023_07_31_032503_add_status_diterima_to_registers_table', 8),
(26, '2023_08_01_051157_create_berkas_pendaftar_table', 8),
(27, '2023_08_03_021644_create_name_on_pemberkasan_table', 8),
(28, '2023_08_24_034357_create_diterima_di_at_registers_table', 9),
(29, '2023_11_09_002635_create_kuota_to_prodis_table', 10),
(30, '2023_11_09_005615_add_sisa_kuota_column_and_trigger_to_prodis_table', 11),
(31, '2023_11_29_084001_insert_columns_to_registers_table', 12);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prodis`
--

CREATE TABLE `prodis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `kuota` int(11) NOT NULL DEFAULT 0,
  `sisa_kuota` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prodis`
--

INSERT INTO `prodis` (`id`, `nama`, `deskripsi`, `kuota`, `sisa_kuota`, `created_at`, `updated_at`) VALUES
(5, 'Teknik Informatika', NULL, 10, 0, '2023-11-29 01:20:49', '2023-11-29 01:20:49'),
(6, 'tempo dulu', NULL, 200, 200, '2023-11-29 01:22:15', '2023-11-29 01:22:15');

-- --------------------------------------------------------

--
-- Table structure for table `registers`
--

CREATE TABLE `registers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nama_ibu` varchar(255) DEFAULT NULL,
  `jk` enum('L','P') NOT NULL,
  `hp` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `kewarganegaraan` varchar(255) NOT NULL,
  `identitas_kewarganegaraan` varchar(255) NOT NULL,
  `jenjang_pendidikan_id` bigint(20) UNSIGNED NOT NULL,
  `sistem_kuliah_id` bigint(20) UNSIGNED NOT NULL,
  `jalur_masuk_id` bigint(20) UNSIGNED NOT NULL,
  `nama_sekolah` varchar(255) NOT NULL,
  `jenis_sekolah` varchar(255) NOT NULL,
  `jurusan_sekolah` varchar(255) NOT NULL,
  `tahun_lulus` year(4) NOT NULL,
  `nisn` varchar(255) DEFAULT NULL,
  `alamat_sekolah` text NOT NULL,
  `pilihan1` bigint(20) UNSIGNED NOT NULL,
  `pilihan2` bigint(20) UNSIGNED NOT NULL,
  `pilihan3` bigint(20) UNSIGNED NOT NULL,
  `pembayaran` enum('sudah','belum') NOT NULL DEFAULT 'belum',
  `bukti_pembayaran` text DEFAULT NULL,
  `status_diterima` enum('diterima','tidak diterima') NOT NULL DEFAULT 'tidak diterima',
  `diterima_di` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Triggers `registers`
--
DELIMITER $$
CREATE TRIGGER `after_registers_change_delete` AFTER DELETE ON `registers` FOR EACH ROW BEGIN
                CALL update_sisa_kuota();
            END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_registers_change_insert` AFTER INSERT ON `registers` FOR EACH ROW BEGIN
                CALL update_sisa_kuota();
            END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_registers_change_update` AFTER UPDATE ON `registers` FOR EACH ROW BEGIN
                CALL update_sisa_kuota();
            END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `jalur_masuks_jumlah_pendaftar_trigger` AFTER INSERT ON `registers` FOR EACH ROW BEGIN
            UPDATE jalur_masuks
            SET jumlah_pendaftar = (SELECT COUNT(*) FROM registers WHERE jalur_masuk_id = NEW.jalur_masuk_id)
            WHERE id = NEW.jalur_masuk_id;
        END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_delete_register` AFTER DELETE ON `registers` FOR EACH ROW BEGIN
                UPDATE jalur_masuks
                SET jumlah_pendaftar = (SELECT COUNT(*) FROM registers WHERE jalur_masuk_id = OLD.jalur_masuk_id)
                WHERE id = OLD.jalur_masuk_id;
            END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_update_register` AFTER UPDATE ON `registers` FOR EACH ROW BEGIN
            UPDATE jalur_masuks
            SET jumlah_pendaftar = (SELECT COUNT(*) FROM registers WHERE jalur_masuk_id = NEW.jalur_masuk_id)
            WHERE id = NEW.jalur_masuk_id;
            UPDATE jalur_masuks
            SET jumlah_pendaftar = (SELECT COUNT(*) FROM registers WHERE jalur_masuk_id = OLD.jalur_masuk_id)
            WHERE id = OLD.jalur_masuk_id;
        END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `sistem_kuliahs`
--

CREATE TABLE `sistem_kuliahs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sistem_kuliahs`
--

INSERT INTO `sistem_kuliahs` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(2, 'eytte', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sosmeds`
--

CREATE TABLE `sosmeds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_platform` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `change_pw` enum('sudah','belum') NOT NULL DEFAULT 'belum',
  `level` enum('camaba','superadmin','admin') NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `change_pw`, `level`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', 'superadmin', NULL, '$2y$10$z7FTrO4KsLMPU10KKsnVIuFf7v03LNyk/v6yneL8AHm2bQfZqrNZi', 'belum', 'superadmin', NULL, NULL, '2023-05-14 19:35:33'),
(4, 'admin1', 'admin1', NULL, '$2y$10$HAa4h8jXlA2tm3xgOm6HiO0q7ArsG2rUz4nTvCcgr1IWjrnOLYlOm', 'belum', 'admin', NULL, '2023-10-01 21:56:16', '2023-10-01 21:56:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `berkas_pendaftars`
--
ALTER TABLE `berkas_pendaftars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `berkas_pendaftars_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `informasis`
--
ALTER TABLE `informasis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `informasis_slug_unique` (`slug`);

--
-- Indexes for table `informasi_kampuses`
--
ALTER TABLE `informasi_kampuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jalur_masuks`
--
ALTER TABLE `jalur_masuks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenjang_pendidikans`
--
ALTER TABLE `jenjang_pendidikans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `prodis`
--
ALTER TABLE `prodis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registers`
--
ALTER TABLE `registers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `registers_email_unique` (`email`),
  ADD KEY `registers_user_id_foreign` (`user_id`),
  ADD KEY `registers_jenjang_pendidikan_id_foreign` (`jenjang_pendidikan_id`),
  ADD KEY `registers_sistem_kuliah_id_foreign` (`sistem_kuliah_id`),
  ADD KEY `registers_jalur_masuk_id_foreign` (`jalur_masuk_id`),
  ADD KEY `registers_pilihan1_foreign` (`pilihan1`),
  ADD KEY `registers_pilihan2_foreign` (`pilihan2`),
  ADD KEY `registers_pilihan3_foreign` (`pilihan3`),
  ADD KEY `registers_diterima_di_foreign` (`diterima_di`);

--
-- Indexes for table `sistem_kuliahs`
--
ALTER TABLE `sistem_kuliahs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sosmeds`
--
ALTER TABLE `sosmeds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `berkas_pendaftars`
--
ALTER TABLE `berkas_pendaftars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `informasis`
--
ALTER TABLE `informasis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `informasi_kampuses`
--
ALTER TABLE `informasi_kampuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jalur_masuks`
--
ALTER TABLE `jalur_masuks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jenjang_pendidikans`
--
ALTER TABLE `jenjang_pendidikans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prodis`
--
ALTER TABLE `prodis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `registers`
--
ALTER TABLE `registers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sistem_kuliahs`
--
ALTER TABLE `sistem_kuliahs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sosmeds`
--
ALTER TABLE `sosmeds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `berkas_pendaftars`
--
ALTER TABLE `berkas_pendaftars`
  ADD CONSTRAINT `berkas_pendaftars_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `registers`
--
ALTER TABLE `registers`
  ADD CONSTRAINT `registers_diterima_di_foreign` FOREIGN KEY (`diterima_di`) REFERENCES `prodis` (`id`),
  ADD CONSTRAINT `registers_jalur_masuk_id_foreign` FOREIGN KEY (`jalur_masuk_id`) REFERENCES `jalur_masuks` (`id`),
  ADD CONSTRAINT `registers_jenjang_pendidikan_id_foreign` FOREIGN KEY (`jenjang_pendidikan_id`) REFERENCES `jenjang_pendidikans` (`id`),
  ADD CONSTRAINT `registers_pilihan1_foreign` FOREIGN KEY (`pilihan1`) REFERENCES `prodis` (`id`),
  ADD CONSTRAINT `registers_pilihan2_foreign` FOREIGN KEY (`pilihan2`) REFERENCES `prodis` (`id`),
  ADD CONSTRAINT `registers_pilihan3_foreign` FOREIGN KEY (`pilihan3`) REFERENCES `prodis` (`id`),
  ADD CONSTRAINT `registers_sistem_kuliah_id_foreign` FOREIGN KEY (`sistem_kuliah_id`) REFERENCES `sistem_kuliahs` (`id`),
  ADD CONSTRAINT `registers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
