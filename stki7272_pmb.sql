-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 29, 2024 at 03:17 PM
-- Server version: 10.11.6-MariaDB-cll-lve
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stki7272_pmb`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`stki7272`@`localhost` PROCEDURE `update_sisa_kuota` ()   BEGIN
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

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`id`, `nama_pemilik`, `nomor_rekening`, `nama_bank`, `created_at`, `updated_at`) VALUES
(5, 'STKIP PGRI BANGKALAN', '000601001005304', 'BANK BRI', '2024-04-24 03:22:05', '2024-04-24 03:22:05');

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
  `doc_pend_jalur_masuk` text DEFAULT NULL,
  `doc_pend_jalur_masuk_file` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `berkas_pendaftars`
--

INSERT INTO `berkas_pendaftars` (`id`, `user_id`, `ijazah_skl`, `ijazah_skl_file`, `skhun`, `skhun_file`, `kk`, `kk_file`, `ktp`, `ktp_file`, `akta`, `akta_file`, `pas_foto`, `pas_foto_file`, `doc_pend_jalur_masuk`, `doc_pend_jalur_masuk_file`, `created_at`, `updated_at`) VALUES
(4, 10, 'ijazah_skl_TES_20240402_115235.jpg', 'berkas/nGOrXFRVzHKZPxUSZrVhoexlzaUT6r7Q3WaFcqfK.jpg', 'skhun_TES_20240402_115235.jpg', 'berkas/Z8kZ5z1gGLssZmZMIrXakameLDyNILku2W3Yofmw.jpg', 'kk_TES_20240402_115235.jpg', 'berkas/oUhWwYH9UonuKeRNRSrHh0eRxWT4i6gpW8jfuy8p.jpg', 'ktp_TES_20240402_115235.jpg', 'berkas/1V4UdodQGh61RzPFCWzzK2gsrdNMb0ZTt4PdwVgm.jpg', 'akta_TES_20240402_115235.jpg', 'berkas/m6s0Hx76gzMVDKIE8Hv5RkurvwiXAUefejNWXa1V.jpg', 'pas_foto_TES_20240402_115235.jpg', 'berkas/kqBQkR5ymMTtwaktUPacXNWrUWjm3XwI9BACZ0Me.jpg', NULL, NULL, '2024-04-02 04:52:35', '2024-04-02 04:52:35'),
(5, 11, 'ijazah_skl_abc_20240424_093726.pdf', 'berkas/7MjkcqbP1sFYbYMjeIMTUYcBQ21QlR1S94n4UFfl.pdf', NULL, NULL, 'kk_abc_20240424_093727.pdf', 'berkas/SNKP2A2RAxXLMss1bkioJsnCw58rHgzCOvj7z179.pdf', 'ktp_abc_20240424_093727.pdf', 'berkas/1GlzEdkHnopCQAptzMZyFcz42EEDfDrlvTBSnNpO.pdf', 'akta_abc_20240424_093727.pdf', 'berkas/qBvt1mFE77ZwXINKQbdaTR4MHIAsw0zM7hDuMDCX.pdf', 'pas_foto_abc_20240424_093726.pdf', 'berkas/4UTpWzVHOyppZNjGQfC69Kdm48AQjOdDWonFMQtE.pdf', 'doc_pend_jalur_masuk_abc_20240424_093727.jpg', 'berkas/XuU5IqURkl7NPE6mVOcX0eOHhgpxusDWtcu5N5Ju.jpg', '2024-04-24 02:37:26', '2024-04-24 02:37:27'),
(6, 12, 'ijazah_skl_jhgghf_20240424_113717.pdf', 'berkas/pJOio0lJ2DMY92P43oj8mIJLHiadxSCTbjNyPfsk.pdf', NULL, NULL, 'kk_jhgghf_20240424_113717.pdf', 'berkas/D0zuIDDN2gDl16X1YYr2zoJkoZRB3F4035bSRlmg.pdf', 'ktp_jhgghf_20240424_113718.pdf', 'berkas/dnfkSTLuwohj57VxrwK0feTbgj8DvYQrXoctXL9F.pdf', 'akta_jhgghf_20240424_113718.pdf', 'berkas/IovVg4MIqRIx1PMCdMHKUWF34fxkphxIlyAku2au.pdf', 'pas_foto_jhgghf_20240424_113717.pdf', 'berkas/4dXarj7CG0tZjb3KamD3jOEX7u0KofyPEvLzJ0pw.pdf', 'doc_pend_jalur_masuk_jhgghf_20240424_113719.pdf', 'berkas/jJut1UegpAnpthG3Jg3uS3w9E9AXdgkybvkWSWCJ.pdf', '2024-04-24 04:37:17', '2024-04-24 04:37:20'),
(7, 13, 'ijazah_skl_jhgghf_20240424_114839.pdf', 'berkas/5CpkRXvjMkpCY1y2xskQlRSVoFQf0XzWwDAI5GFH.pdf', NULL, NULL, 'kk_jhgghf_20240424_114839.pdf', 'berkas/r2z6gWY7yYcSLSfkdCrOuCIe00Bv59NQi6ZtZem3.pdf', 'ktp_jhgghf_20240424_114840.pdf', 'berkas/wVR5DiqWkF8wx9kBKcMg6JanhAACsBUpmlClPhwu.pdf', 'akta_jhgghf_20240424_114840.pdf', 'berkas/SieUoClVRZhEfDGHor4IgMtNunHD8ef9WnU4ONUo.pdf', 'pas_foto_jhgghf_20240424_114839.pdf', 'berkas/ay5s9pd0rlrxjCF0UqEOA9Vi2XWAJbsQQzaPQJzT.pdf', 'doc_pend_jalur_masuk_jhgghf_20240424_114840.pdf', 'berkas/zpar8Btt58QPBaGXCh4jSR3Ni8DVYRoDywJMi90R.pdf', '2024-04-24 04:48:39', '2024-04-24 04:48:40'),
(8, 14, 'ijazah_skl_JOYA NUR PRIYANTI GUNAWAN_20240424_122016.pdf', 'berkas/7ApiqVnnP8wXWnGHHQa1WGaYxZgcaRBHDpS5JouY.pdf', NULL, NULL, 'kk_JOYA NUR PRIYANTI GUNAWAN_20240424_122016.pdf', 'berkas/FKFLNorbxOthCMjCFPjZbmRgJ8eVh6MnJCfddwJA.pdf', 'ktp_JOYA NUR PRIYANTI GUNAWAN_20240424_122016.pdf', 'berkas/NFOvAWHlQMrNZxO17ORHvYpNmWNY0RBAjku1bmcl.pdf', 'akta_JOYA NUR PRIYANTI GUNAWAN_20240424_122016.pdf', 'berkas/MrckP1y4KUskoL74uVNygtV9TBnJen4v4JnruLA9.pdf', 'pas_foto_JOYA NUR PRIYANTI GUNAWAN_20240424_122016.pdf', 'berkas/jGqUcDILRvsuUx3J7wmqEmAJAbQTfkNDId7SenBo.pdf', 'doc_pend_jalur_masuk_JOYA NUR PRIYANTI GUNAWAN_20240424_122016.pdf', 'berkas/BM43TDe1Hfwn6jFWCbGVLhWz0grZUbnIPX7ExkE4.pdf', '2024-04-24 05:20:16', '2024-04-24 05:20:16'),
(9, 15, 'ijazah_skl_jhgghf_20240426_140845.jpg', 'berkas/foBEIXkkwdPUfGjStNLTxk9bYQdIzNjDdhWK6etF.jpg', NULL, NULL, 'kk_jhgghf_20240426_140845.jpeg', 'berkas/OK9gDya7FCoy7MdXJ51iQDFqCH0rSY5YJbTL8zwH.jpg', 'ktp_jhgghf_20240426_140845.jpeg', 'berkas/OZucFItM4uBP8iw6UCZA7tdzX3UOj4zE4a0UWnSO.jpg', 'akta_jhgghf_20240426_140845.jpeg', 'berkas/LnkJvc1lYMK2ocSK3SOts18J1iKTtdU58jwyAUpZ.jpg', 'pas_foto_jhgghf_20240426_140845.jpeg', 'berkas/dRiBGeS0opExQO8eaB8AucyDhzX7mVWX7iZmo3ED.jpg', 'doc_pend_jalur_masuk_jhgghf_20240426_140845.jpeg', 'berkas/r5la7q9SWnFYfxzr5QDJJm1kjzhjMbJ0SU8pL1am.jpg', '2024-04-26 07:08:45', '2024-04-26 07:08:45'),
(10, 16, 'ijazah_skl_ALFIN MUBAROK_20240429_115146.pdf', 'berkas/3cQeeAIIrxMCOxXWqEaoZiq8Nxh8dXxeLtaVZJQr.pdf', NULL, NULL, 'kk_ALFIN MUBAROK_20240429_115146.pdf', 'berkas/R6iuST2hdMijXfAWLC2yd9OKMvKODVV0BNY7EMrK.pdf', 'ktp_ALFIN MUBAROK_20240429_115146.pdf', 'berkas/XC55tyHnDIEnxAr34GEFlIviSSZORbo3aadFIxY3.pdf', 'akta_ALFIN MUBAROK_20240429_115147.pdf', 'berkas/7tCuRWfOMbCFcZiHaeryjzlugXUVPJ2nUTuQRMWF.pdf', 'pas_foto_ALFIN MUBAROK_20240429_115146.JPG', 'berkas/xZ504ysN4tmY00EBYcml9l3885IMPJZrNlntFAzE.jpg', NULL, NULL, '2024-04-29 04:51:46', '2024-04-29 04:51:47'),
(11, 17, 'ijazah_skl_HOIRUL ANAM_20240429_115735.pdf', 'berkas/JTPmJrJ3T06IP8CZZOJPU125OylaSkBopZsFbDlP.pdf', NULL, NULL, 'kk_HOIRUL ANAM_20240429_115735.pdf', 'berkas/leCB5r3yzDLzQfjoZ8j6a1fQSAkVIEcExMf45sih.pdf', 'ktp_HOIRUL ANAM_20240429_115735.pdf', 'berkas/CDNh0HVO1eCf0JYy4Jk6bNBmOqrQ0UOxQ0wngt3W.pdf', 'akta_HOIRUL ANAM_20240429_115735.pdf', 'berkas/seUXABAAOa6v6TMUXdwj45ucElVNoHFZV8puuMq9.pdf', 'pas_foto_HOIRUL ANAM_20240429_115735.JPG', 'berkas/KWNTnILD3IaagVJprRTKFE2VmAerkGkS6bZ2d2BY.jpg', NULL, NULL, '2024-04-29 04:57:35', '2024-04-29 04:57:35'),
(12, 18, 'ijazah_skl_SHUFHAN JAMIL_20240429_120606.jpg', 'berkas/cUN7wOFMvfbKejrmcFTiGaEvLW3LtfE0hZZw5BfV.jpg', NULL, NULL, 'kk_SHUFHAN JAMIL_20240429_120606.jpg', 'berkas/DOo0ZUeMWeA1w3EHkDyo3Nb9yzrAX2w0LwbC92A9.jpg', 'ktp_SHUFHAN JAMIL_20240429_120606.jpg', 'berkas/vqKCg4Op5GZNW1rRvjpp3s04rc8J75zcn6h639U7.jpg', 'akta_SHUFHAN JAMIL_20240429_120606.jpg', 'berkas/1ZFwA1B1KKTMpkOZBZgtGlQ0Ga02XU6Cfx6Ep2SK.jpg', 'pas_foto_SHUFHAN JAMIL_20240429_120606.jpg', 'berkas/rzGScnn0zouK6inuf16lAo6BHl2fnPMS7JTryDPJ.jpg', NULL, NULL, '2024-04-29 05:06:06', '2024-04-29 05:06:06'),
(13, 19, 'ijazah_skl_RIZKY BAHTIAR_20240429_123332.jpeg', 'berkas/TjLVBLy3cdQQGcbYtRx0NUnE1SyfiUvfaS4WBR6G.jpg', NULL, NULL, 'kk_RIZKY BAHTIAR_20240429_123332.jpg', 'berkas/f1uJZjLjX1HqSLMC2AmLVJ5NHjudgtMNJfYFMlNR.jpg', 'ktp_RIZKY BAHTIAR_20240429_123332.jpg', 'berkas/gVIRMSX1SuboiBYulI0A3yTKKBhr9nFtlUOOFih1.jpg', 'akta_RIZKY BAHTIAR_20240429_123332.jpg', 'berkas/C6AJeyVcRToMcTD98EQUyYt7w8ozF6FmOu6KKzOm.jpg', 'pas_foto_RIZKY BAHTIAR_20240429_123332.jpg', 'berkas/mVnoBjJn6HZ3PJ7uL2iR8rsGIH6s7Dfax3qv0gUB.jpg', NULL, NULL, '2024-04-29 05:33:32', '2024-04-29 05:33:32'),
(14, 20, 'ijazah_skl_MOH. HUSNIL MA\'ARIF_20240429_124200.pdf', 'berkas/rsJ0U9b1qHhs4lGttgk9Vd9PahPLDGpnO4xyPf0O.pdf', NULL, NULL, 'kk_MOH. HUSNIL MA\'ARIF_20240429_124200.jpeg', 'berkas/LajCWaXZj9zlu2wo59Fhzi4mzBfmybJsUA6Zc8fV.jpg', 'ktp_MOH. HUSNIL MA\'ARIF_20240429_124200.jpeg', 'berkas/WyNDc4ajQLG6DRszVCWA1fuqoSmwVSXCzcNRHxQP.jpg', 'akta_MOH. HUSNIL MA\'ARIF_20240429_124200.jpeg', 'berkas/t2bf1BDEqAawlOfJdLsMA5iOu15aI1lfEM3iqqS2.jpg', 'pas_foto_MOH. HUSNIL MA\'ARIF_20240429_124200.png', 'berkas/NZhFIZegi5cfgs7WVnKzvpgrJCPC0FHIpBhmdM1I.png', 'doc_pend_jalur_masuk_MOH. HUSNIL MA\'ARIF_20240429_124200.jpeg', 'berkas/OleGfKRJ8ILzKl3gfPt9VwRvYR29rL9ANbTN1D7A.jpg', '2024-04-29 05:42:00', '2024-04-29 05:42:00'),
(15, 21, 'ijazah_skl_SITI ROFIAH_20240429_125049.pdf', 'berkas/dBEMq69Hz8hhehByt6yGYq8RLWzjfzeYd4XHr3NV.pdf', NULL, NULL, 'kk_SITI ROFIAH_20240429_125049.pdf', 'berkas/XV5ougGko36Ha4rd0mx9JzItEejbstblCm6NFOpA.pdf', 'ktp_SITI ROFIAH_20240429_125049.jpg', 'berkas/MV6dD4YcKulK97FbeeaCpsEUKtPQKHh088sGHq8B.jpg', 'akta_SITI ROFIAH_20240429_125049.jpg', 'berkas/XW5vPM3QU9fbUfrXNBFjJP9nUK6CQlzoOxqlclhj.jpg', 'pas_foto_SITI ROFIAH_20240429_125049.jpg', 'berkas/mFIkcW6KlxQJhOGyWMenI0DkDnWMY4Vtb5AB4bX8.jpg', 'doc_pend_jalur_masuk_SITI ROFIAH_20240429_125049.jpg', 'berkas/crKOyoPGUU3viJBNG514EREsaruzbROpoMSRfLdF.jpg', '2024-04-29 05:50:49', '2024-04-29 05:50:49'),
(16, 22, 'ijazah_skl_Andika dwi anggara_20240430_134014.pdf', 'berkas/cgIo0iD9POZlKTBDivE2b6zNJe4ZnvijkD9tTUIO.pdf', NULL, NULL, 'kk_Andika dwi anggara_20240430_134014.pdf', 'berkas/rtlKy91kGzJAug7Ue8YQuxjQQKpu4JY4aE5p2hlV.pdf', 'ktp_Andika dwi anggara_20240430_134014.pdf', 'berkas/RkFrDNiZZBBbdbodVRFy9UeN59Jhk8yZUQ8obec6.pdf', 'akta_Andika dwi anggara_20240430_134014.pdf', 'berkas/i7b9bge3YZOOogWopfyvidec22BzeHCxnRvc8hlZ.pdf', 'pas_foto_Andika dwi anggara_20240430_134014.jpeg', 'berkas/PCvqHtJzqolvO9uepTr1whOqft2CpUbXicBAMe42.jpg', NULL, NULL, '2024-04-30 06:40:14', '2024-04-30 06:40:15'),
(17, 23, 'ijazah_skl_Aynia Ramadani_20240430_202118.pdf', 'berkas/JXDo1E4llX0ba0VZhi1j39wjZlWICwDR980rYC8M.pdf', NULL, NULL, 'kk_Aynia Ramadani_20240430_202118.pdf', 'berkas/GBTUGORcOcVS0wFMzonHVeFCb4E8VByUKO8fbUaR.pdf', 'ktp_Aynia Ramadani_20240430_202118.pdf', 'berkas/EYbNWb8RU64kjQVvfZA1YoXSqcv0cLJcKBHxpNNl.pdf', 'akta_Aynia Ramadani_20240430_202118.pdf', 'berkas/PuAMXlVdSEMCCpWCSejUKCpV7EVfuugrz2qUUBY2.pdf', 'pas_foto_Aynia Ramadani_20240430_202118.pdf', 'berkas/REZ8G99lXO64i6kJnQPaksKzshchlbSqOx9QNz4X.pdf', 'doc_pend_jalur_masuk_Aynia Ramadani_20240430_202118.pdf', 'berkas/9OKf70jiDPSeThyxyxNTaeggSqMqROVXnmwvFNtF.pdf', '2024-04-30 13:21:18', '2024-04-30 13:21:18'),
(18, 24, 'ijazah_skl_Aynia Ramadani_20240430_205024.pdf', 'berkas/dHTE43mwRiEGlYMbz1GFPEkLnbN1kwUVC093Anuv.pdf', NULL, NULL, 'kk_Aynia Ramadani_20240430_205024.pdf', 'berkas/rneEZXSFOhedcQKCLFXfsc1kGSbxPRiMWSIWmskb.pdf', 'ktp_Aynia Ramadani_20240430_205024.pdf', 'berkas/KNfteiil785xI9mWc7eH4dm9UzCK6DeQDqSoXpB6.pdf', 'akta_Aynia Ramadani_20240430_205024.pdf', 'berkas/hgQFH2X3JeDfN7FIaIEOQF3EONlPCXiPHgJ10v8J.pdf', 'pas_foto_Aynia Ramadani_20240430_205024.pdf', 'berkas/d9wJ3lbUA69JxA8FjVnj0x9Xy42B34v4MPLfOe4T.pdf', 'doc_pend_jalur_masuk_Aynia Ramadani_20240430_205024.pdf', 'berkas/tmbOdX6lqUz78AhJISgFxeIL5KyLqH4ypy2RM0qO.pdf', '2024-04-30 13:50:24', '2024-04-30 13:50:24'),
(19, 25, 'ijazah_skl_ROSUL MUHAMMAD DANI_20240503_134029.jpeg', 'berkas/D5Juz5dHMCO41AAUIlY6T4WiZShCULZ3Swz9PFYe.jpg', NULL, NULL, 'kk_ROSUL MUHAMMAD DANI_20240503_134029.jpeg', 'berkas/I8yr7h2SX7E7PEKJKe0Q7YDxofK9yhf8q482kRiG.jpg', 'ktp_ROSUL MUHAMMAD DANI_20240503_134030.jpeg', 'berkas/oeJMP7eDuZDbIZQZWLmyLQ646jeffLJlMC64Icsl.jpg', 'akta_ROSUL MUHAMMAD DANI_20240503_134030.jpeg', 'berkas/B2RTyjoMzdJT2PK76YW0IiQtEhp7KgAJlIXVVT1c.jpg', 'pas_foto_ROSUL MUHAMMAD DANI_20240503_134029.jpeg', 'berkas/DZSMCYlmV3QvYcBDkXAr30TLIH1tXTngdbeXn3xs.jpg', 'doc_pend_jalur_masuk_ROSUL MUHAMMAD DANI_20240503_134030.jpeg', 'berkas/hRbQouMXG5UauTG9B8beKolZPbE74EasZQ2HQjCr.jpg', '2024-05-03 06:40:29', '2024-05-03 06:40:30'),
(20, 26, 'ijazah_skl_MIFTAHUL ANSHORI_20240503_134841.pdf', 'berkas/uusCEkWUoQvkRyYA7CAVvd5HmYoL12mZIuxUj0AY.pdf', NULL, NULL, 'kk_MIFTAHUL ANSHORI_20240503_134841.pdf', 'berkas/Hy5HyoL5x7BPbETPmQ8CORF518SS5npLOg3RhoFC.pdf', 'ktp_MIFTAHUL ANSHORI_20240503_134841.jpg', 'berkas/xTToMAnS3P8NR2gu2MhBMiwZouYYEnDF4i9iafks.jpg', 'akta_MIFTAHUL ANSHORI_20240503_134841.pdf', 'berkas/UX4datII8Uf2HV9Pk8q1KapUOimRPqqWxZcNa3Zz.pdf', 'pas_foto_MIFTAHUL ANSHORI_20240503_134841.jpg', 'berkas/tYbh6MPD5y6w0vCCS3yskgzjoXE14nrBzsPgo0a5.jpg', NULL, NULL, '2024-05-03 06:48:41', '2024-05-03 06:48:41'),
(21, 27, 'ijazah_skl_MOH. RAIHAN_20240503_135822.jpg', 'berkas/8kdosUtU8PyWmgdTf9NTHuXOMNtLE1pGhEUQm4j7.jpg', NULL, NULL, 'kk_MOH. RAIHAN_20240503_135822.jpg', 'berkas/ZT8vCblhCtscVP991dndAjV01IZ16H7Wlp31Zdu1.jpg', 'ktp_MOH. RAIHAN_20240503_135822.jpg', 'berkas/KvOJD38v5oypaBBKLRgRjfH2nazJwb60dM6G4OEX.jpg', 'akta_MOH. RAIHAN_20240503_135822.jpg', 'berkas/ng33nYZN5APbUCvH1xAAw20YTOjHwHpT3uXadQ4y.jpg', 'pas_foto_MOH. RAIHAN_20240503_135822.png', 'berkas/aF5HSQzyw9LodLDjXqQPJBjfRvpt8m2PJfRAJUCP.png', NULL, NULL, '2024-05-03 06:58:22', '2024-05-03 06:58:22'),
(22, 28, 'ijazah_skl_SITI ALIYAH_20240503_140637.jpg', 'berkas/FZzuaufBshBnbIhRnt7MHL10Dpgqrd3HWsuGhyiz.jpg', NULL, NULL, 'kk_SITI ALIYAH_20240503_140637.jpg', 'berkas/BtLtAKVp34yKvCzR84DkiivoA0SaIB9DFBP2p8Ez.jpg', 'ktp_SITI ALIYAH_20240503_140637.jpg', 'berkas/dSCycWMOSe3lf3W8tMRF1KtUwMs2imnoc9lFgpDy.jpg', 'akta_SITI ALIYAH_20240503_140637.jpg', 'berkas/DVAugvBirAbkQTleXymiBwqovmZyD6BNOM7KEYZh.jpg', 'pas_foto_SITI ALIYAH_20240503_140637.jpg', 'berkas/Hq05NyJyKK3ijZjYtxAfliNsuNtIuFJvH1biwHUg.jpg', NULL, NULL, '2024-05-03 07:06:37', '2024-05-03 07:06:38'),
(23, 29, 'ijazah_skl_MUHLIS_20240503_143902.pdf', 'berkas/k8zzEuGYsqTV3IovHvlMN6UJVMlXPWPak1YdTFlj.pdf', NULL, NULL, 'kk_MUHLIS_20240503_143902.pdf', 'berkas/SXwjfbPj7AGvyQhIs2Wv9Y7S5vyjTUQf5g02hRqz.pdf', 'ktp_MUHLIS_20240503_143902.pdf', 'berkas/qWuYhPoC2X94i8P1JpbNrtnt4y6BvkfXDy6nG35h.pdf', 'akta_MUHLIS_20240503_143902.pdf', 'berkas/atNIeLJW8fvqJM4gFHYkY3ZiIVFiJ0Edh9wJkCrU.pdf', 'pas_foto_MUHLIS_20240503_143902.pdf', 'berkas/Coc9foEH9wbdJby2pytcmupv5y03bwJNWOhrG0PQ.pdf', 'doc_pend_jalur_masuk_MUHLIS_20240503_143902.pdf', 'berkas/pj3nB1YcuRCN3nWHZ4t4QOihOrEdEqt1asIqLIsm.pdf', '2024-05-03 07:39:02', '2024-05-03 07:39:02'),
(24, 30, 'ijazah_skl_SALIMATUS SAKDIYAH_20240503_154128.jpg', 'berkas/u8weH6kNmVBA9lXb7oBQz9DqSxm2pcykgUo8p8iD.jpg', NULL, NULL, 'kk_SALIMATUS SAKDIYAH_20240503_154128.jpg', 'berkas/vXHPYXXzzgi16CdGHR4oNf2CdHavzSiaMc5FP430.jpg', 'ktp_SALIMATUS SAKDIYAH_20240503_154128.jpg', 'berkas/p9Tkfq5XVEcdnDuEzAmntRkdCE5eTzNllyWBIZv6.jpg', 'akta_SALIMATUS SAKDIYAH_20240503_154128.jpg', 'berkas/5tc7PPZ0q1eGZan6BB49VDLgaPiDTjKkYy2G3wlM.jpg', 'pas_foto_SALIMATUS SAKDIYAH_20240503_154128.jpg', 'berkas/jaSE57vlznz7RVcSiAeUAf0aMw4JlOnmVXglKQos.jpg', 'doc_pend_jalur_masuk_SALIMATUS SAKDIYAH_20240503_154128.jpg', 'berkas/jxqpbKBrbegjqhLPyFZddJ8hZVQln0QI7QmVWsZy.jpg', '2024-05-03 08:41:28', '2024-05-03 08:41:28'),
(25, 31, 'ijazah_skl_LATIFATUL SOFIYAH_20240506_085519.pdf', 'berkas/yYwz0nMiqXGkrJQAByz0e3OMrXb9lfP8JX5H0Ipy.pdf', NULL, NULL, 'kk_LATIFATUL SOFIYAH_20240506_085519.pdf', 'berkas/00VmXVHihwouo1rUsS2iUkqhP6vWvkGbkO9gN1ND.pdf', 'ktp_LATIFATUL SOFIYAH_20240506_085519.pdf', 'berkas/CLkJfMTzBwxC9cwN53zMRCFKc4suIHJJwNdJxmeD.pdf', 'akta_LATIFATUL SOFIYAH_20240506_085519.pdf', 'berkas/2ZfDwWhhLaWejyTZVSUsfKM7vH6JKCUsGyaIlFoL.pdf', 'pas_foto_LATIFATUL SOFIYAH_20240506_085519.JPG', 'berkas/2Ta82Ma0T5I9WrgRMd0XWXQDlvl632qvO2QJlaRZ.jpg', NULL, NULL, '2024-05-06 01:55:19', '2024-05-06 01:55:19'),
(26, 32, 'ijazah_skl_ABDUL MUIN_20240507_095319.pdf', 'berkas/2mvBCpRy7tHBpot5saJblRhX9Q8SgkgWsh5KR6nB.pdf', NULL, NULL, 'kk_ABDUL MUIN_20240507_095319.pdf', 'berkas/Z4YKP9dZgkCBw6snoeQf54vMjFcATC6aIpeU3KhH.pdf', 'ktp_ABDUL MUIN_20240507_095319.pdf', 'berkas/r9A2A7kPopSiyqCtehxM8nY3QLCkxlSkBj6xbL1p.pdf', 'akta_ABDUL MUIN_20240507_095319.pdf', 'berkas/UlOCf32YU0oF9PkAr4yNhEGfdnWIUCdTDmvLLGto.pdf', 'pas_foto_ABDUL MUIN_20240507_095319.jpg', 'berkas/jwjrHN1bCXLiOXfsPdirwj1GinNujS1NugVcgOxn.jpg', 'doc_pend_jalur_masuk_ABDUL MUIN_20240507_095319.pdf', 'berkas/5swIx2uRBrrjNjMZl6PLrC9xEIc99LkuEV64FiqZ.pdf', '2024-05-07 02:53:19', '2024-05-07 02:53:19'),
(27, 33, 'ijazah_skl_Marsuli_20240507_104136.pdf', 'berkas/4zAKq9KHSjYVvtw3bxg5q8jLf0atB1VvOaWz8Vem.pdf', NULL, NULL, 'kk_Marsuli_20240507_104136.pdf', 'berkas/GFsSMuYnMnywS5WXo0rWEoOhNKpxEyyXM9E0vi0e.pdf', 'ktp_Marsuli_20240507_104137.pdf', 'berkas/BYDx1Dj3HYmevhHr4BB3cZ0Z8adub0LkdJr6wm3f.pdf', 'akta_Marsuli_20240507_104137.pdf', 'berkas/2omeOgDatA5H92A6UwYTLlIsINPdvrhoN0ik7IZ1.pdf', 'pas_foto_Marsuli_20240507_104136.png', 'berkas/U2scnwuGdAoJXzA1piQt69IXTyWITF53Ocj7OhmZ.png', 'doc_pend_jalur_masuk_Marsuli_20240507_104137.pdf', 'berkas/9OpOcNjjQOcQEAfySTxOCASKX610pGMfPy61Gs3r.pdf', '2024-05-07 03:41:36', '2024-05-07 03:41:37'),
(28, 34, 'ijazah_skl_MUHAMMAD MAMLU\'UL HIKAM_20240507_114550.pdf', 'berkas/b3b8b4EEWKZtrdApL23vM7HqkmmD9SDLxzoRJlyb.pdf', NULL, NULL, 'kk_MUHAMMAD MAMLU\'UL HIKAM_20240507_114551.pdf', 'berkas/abiXALrHoO3sUamJUOVBkscls3AJObb3dpwWp2oU.pdf', 'ktp_MUHAMMAD MAMLU\'UL HIKAM_20240507_114551.pdf', 'berkas/1EQi4WDg1u94cOPI5nhQyRNEKj2VWOMfqp9umWJi.pdf', 'akta_MUHAMMAD MAMLU\'UL HIKAM_20240507_114551.pdf', 'berkas/Jk3BvfxJvEKYc8x68HJZesG09iLZzeoEyfge0QO9.pdf', 'pas_foto_MUHAMMAD MAMLU\'UL HIKAM_20240507_114550.JPG', 'berkas/ioyFo66YP1j8T7CV4XuAcnaKQs7F92CARbgfQESH.jpg', NULL, NULL, '2024-05-07 04:45:50', '2024-05-07 04:45:51'),
(29, 35, 'ijazah_skl_AFIFATUN NISA\'_20240507_115651.pdf', 'berkas/tMQ4kAG4NoBKgRgMrfdTe0VGnVJoWZN9zyzlzH7T.pdf', NULL, NULL, 'kk_AFIFATUN NISA\'_20240507_115651.jpg', 'berkas/QSd4HGUBMmKq8RDCJNv2YuCo5aYtaj5igS5UKMCw.jpg', 'ktp_AFIFATUN NISA\'_20240507_115651.jpg', 'berkas/09JM3WCJSsOXYWDZJW3Jr1WX0tPGI1lkG6cqq0iW.jpg', 'akta_AFIFATUN NISA\'_20240507_115651.jpg', 'berkas/4HOhbnlA6QC1R6Pdt6js2IfH0uuzw5nRGYKCYKHq.jpg', 'pas_foto_AFIFATUN NISA\'_20240507_115651.png', 'berkas/DNEHu3RqRw4H0Q8R7YjjfNYBNCI0j7VImYaGfB8V.png', 'doc_pend_jalur_masuk_AFIFATUN NISA\'_20240507_115651.jpg', 'berkas/cW13SbS9FbiEeJZcy3JkLuJj8RisTLaNTnomHXPw.jpg', '2024-05-07 04:56:51', '2024-05-07 04:56:51'),
(30, 36, 'ijazah_skl_RINA SULIS TIANA_20240508_143201.jpg', 'berkas/hblgBx1k2zFpSD8knp8iG0VnhwR8BG0waKjboBVX.jpg', NULL, NULL, 'kk_RINA SULIS TIANA_20240508_143201.jpg', 'berkas/LDBQSWPb7OEMbUFuwVg44Im6XiZ9ibLrNapgvgA6.jpg', 'ktp_RINA SULIS TIANA_20240508_143201.jpg', 'berkas/C8EBWjEOcMcE4WBBYRX1ZUt3DPilgnjKvHTFEIcc.jpg', 'akta_RINA SULIS TIANA_20240508_143201.jpg', 'berkas/6KbLaVPfabe62TdQnf6V4Dp6abH8PoUOQzhAXDc4.jpg', 'pas_foto_RINA SULIS TIANA_20240508_143201.jpg', 'berkas/stCeu0oAHGd8Il2wyqZGeODhNWP9aMavIvswIyWE.jpg', 'doc_pend_jalur_masuk_RINA SULIS TIANA_20240508_143201.jpg', 'berkas/vaAwmtQsoEDulTIKCyR3S7BtXiIaV8XPvP0Fd6Pf.jpg', '2024-05-08 07:32:01', '2024-05-08 07:32:01'),
(31, 37, 'ijazah_skl_ALIVIATUL MAHYU_20240508_144211.pdf', 'berkas/pQNudUW9zWz7z3z2KZuVWRjtyavdVdMgJnjAeNC1.pdf', NULL, NULL, 'kk_ALIVIATUL MAHYU_20240508_144211.jpg', 'berkas/oU0y71xjqzSQXIsYdXiAzCpU9CCWJjYFTKiMdZUf.jpg', 'ktp_ALIVIATUL MAHYU_20240508_144211.jpg', 'berkas/hGoG9YR8hsHuusyjqgqgli5m5cAqyQ1H5pdRWKQv.jpg', 'akta_ALIVIATUL MAHYU_20240508_144211.jpg', 'berkas/4oZmQWdH1lVR02oTsQBnLG06w3Qnad6q9oTYvBpP.jpg', 'pas_foto_ALIVIATUL MAHYU_20240508_144211.jpg', 'berkas/td7jB1KE2Ltq2L8FPa4pF6yDNnEebWo1wqhv8HKU.jpg', NULL, NULL, '2024-05-08 07:42:11', '2024-05-08 07:42:11'),
(32, 38, 'ijazah_skl_LAILA MASRUROH_20240508_154936.pdf', 'berkas/rdjK5kluXbcgrpzW3ifEkQ6QrFPTt1HoXeelRBwX.pdf', NULL, NULL, 'kk_LAILA MASRUROH_20240508_154936.pdf', 'berkas/QPtJPDYg8P0y9Pp73eFCWSz2V5jOe3K5mSeIM394.pdf', 'ktp_LAILA MASRUROH_20240508_154936.jpg', 'berkas/RySNvspxwJzkEYtQSafhovwzjywX78LXpGzT31kX.jpg', 'akta_LAILA MASRUROH_20240508_154937.pdf', 'berkas/qgNsoc14Z7yuswJ0EmtV8cn31xbMNuvQ6jRvhG5Y.pdf', 'pas_foto_LAILA MASRUROH_20240508_154936.jpg', 'berkas/id2tUU0NKkKE2g6hHbRr29cx1nQQglZSNVIdFMFV.jpg', 'doc_pend_jalur_masuk_LAILA MASRUROH_20240508_154937.jpg', 'berkas/S3vzOSl4YqB7p5EtO4qnWGjGAKRzrkXAPbAmp2fv.jpg', '2024-05-08 08:49:36', '2024-05-08 08:49:37'),
(33, 39, 'ijazah_skl_Siti Sholehah_20240508_174854.jpg', 'berkas/PEXAI4dyVjYKXBFFBl0hurujxsyVS6SO3G2gZ17e.jpg', NULL, NULL, 'kk_Siti Sholehah_20240508_174854.jpg', 'berkas/kP4IJVq84ONhOUJn0TJh2aGIyywkS1ZE62gKtB9h.jpg', 'ktp_Siti Sholehah_20240508_174854.jpg', 'berkas/rl6cbBJrZ7Hhlse2H6yuyzsLNfPw0YMI2TCDs2PW.jpg', 'akta_Siti Sholehah_20240508_174854.jpg', 'berkas/x3ifLmB69nfgKEjZF1B6ZH79jidRu4dHC7nTRxZe.jpg', 'pas_foto_Siti Sholehah_20240508_174854.jpg', 'berkas/6YLHGpjje6abYLhzJFjA3UOXCVmY648VvcOF0mfH.jpg', 'doc_pend_jalur_masuk_Siti Sholehah_20240508_174854.jpg', 'berkas/Rq9DBybjewrfuGng4NTG6cwdJRI9MPVJGsCrRdK1.jpg', '2024-05-08 10:48:54', '2024-05-08 10:48:54'),
(34, 40, 'ijazah_skl_RUSTIANAWATI_20240508_191249.jpg', 'berkas/jwdy7VvCJHMtwol526N7oO3Mz2nSu0cLhRxlGPoY.jpg', NULL, NULL, 'kk_RUSTIANAWATI_20240508_191249.jpg', 'berkas/FIFRCTaYmhz11bi0c7lhrmeZ1XAkMwHFLpprsa22.jpg', 'ktp_RUSTIANAWATI_20240508_191249.jpg', 'berkas/x9VSDIK97novf4ySQYPpQkKtFyI8qIIX5jYTjI6g.jpg', 'akta_RUSTIANAWATI_20240508_191249.jpg', 'berkas/54owLldvqFQ46Dj0MrFPFSbv9heN0CbW6eMrQ3qS.jpg', 'pas_foto_RUSTIANAWATI_20240508_191249.jpg', 'berkas/yGeS2X9ToyoZzmeFdPK0GmdhlqPQk4tUTOaRyrb0.jpg', 'doc_pend_jalur_masuk_RUSTIANAWATI_20240508_191249.jpg', 'berkas/tInwHfi2C03jwXMdzCSvSW7s1bLzbLH0L6CQuMEn.jpg', '2024-05-08 12:12:49', '2024-05-08 12:12:50'),
(35, 41, 'ijazah_skl_RUSTIANAWATI_20240508_192643.jpg', 'berkas/E7mKtgPHHC4k5gbYM3fe2BUKvwd9gl8RABRubsip.jpg', NULL, NULL, 'kk_RUSTIANAWATI_20240508_192643.jpg', 'berkas/K7zjwBU4K0qOF45EagRvPf53fIarj7yRP37GmjER.jpg', 'ktp_RUSTIANAWATI_20240508_192643.jpg', 'berkas/7I4t1xuC06hJeJg9hCjpJcCmIrK5qAAHsQ4qLLy1.jpg', 'akta_RUSTIANAWATI_20240508_192643.jpg', 'berkas/65JSUl9JpHS6NWgnHzIbfIt95qm4O73Dsfl1T5fP.jpg', 'pas_foto_RUSTIANAWATI_20240508_192643.jpg', 'berkas/Wdyze5hQRnbooFnMDcWQQ8TN5k2RfTxaJeDuKvNy.jpg', 'doc_pend_jalur_masuk_RUSTIANAWATI_20240508_192643.jpg', 'berkas/jlj85HSq0zUJXw394K6MXtfBAB286RWmhfqiIYyN.jpg', '2024-05-08 12:26:43', '2024-05-08 12:26:44'),
(36, 42, 'ijazah_skl_NUR KHOLIS AKBAR_20240508_223420.pdf', 'berkas/9BazD7VJIejU6BcelNZK7zuIRG9yb3TuZSyGj9wD.pdf', NULL, NULL, 'kk_NUR KHOLIS AKBAR_20240508_223420.pdf', 'berkas/KkvRlVxxzwGwvvMgydomBXX1CJyT8HpN8FkoI4Jo.pdf', 'ktp_NUR KHOLIS AKBAR_20240508_223420.jpeg', 'berkas/Nv2yeHJ7lEHF6SvNDDIi5FTsjtn6FsQdzP0v8ymL.jpg', 'akta_NUR KHOLIS AKBAR_20240508_223420.pdf', 'berkas/jUHvXZgQCPFPQ8nhUeo1Ek1pM6LD7LKtJhbd1gTb.pdf', 'pas_foto_NUR KHOLIS AKBAR_20240508_223420.jpg', 'berkas/eKUIcynVfhIfdiiPwjw6yGysWzv13RY4fsFgRT9g.jpg', 'doc_pend_jalur_masuk_NUR KHOLIS AKBAR_20240508_223420.pdf', 'berkas/hp786Kl21RKZgkOmke25bOIkO8IOJlYvEhiuObxO.pdf', '2024-05-08 15:34:20', '2024-05-08 15:34:21'),
(37, 43, 'ijazah_skl_YESSIROH_20240509_114858.jpeg', 'berkas/7bNizXwP2aZZ7W5flL93meXN2lIXjAzAxxAJSKIP.jpg', NULL, NULL, 'kk_YESSIROH_20240509_114858.jpeg', 'berkas/bJB8xTVUsIHdwmGvFO3ykYGEoL8SOcLjuBsmG07H.jpg', 'ktp_YESSIROH_20240509_114858.jpeg', 'berkas/98uNhDHxSUxlr2g8COs2cXNELj61NEq49ouncGaL.jpg', 'akta_YESSIROH_20240509_114858.jpeg', 'berkas/2wIHncNOMiBql0tJWrggESIowZpUoASPDg0RYYHf.jpg', 'pas_foto_YESSIROH_20240509_114858.jpeg', 'berkas/vIPts5YhP5reWRTYmUh56YPze8u2K5ZzMvC6gvtV.jpg', 'doc_pend_jalur_masuk_YESSIROH_20240509_114858.jpeg', 'berkas/wMZzjffpI9sflEvxk0rHRgNusnZYOCxNnMQGGV61.jpg', '2024-05-09 04:48:58', '2024-05-09 04:48:58'),
(38, 44, 'ijazah_skl_RYAN YUZRIZAL ABDILLAH PRATAMA_20240510_200008.pdf', 'berkas/5Vq4L8kvno66CP4g70vkD2OoMh80wSWY8FiWbwJb.pdf', NULL, NULL, 'kk_RYAN YUZRIZAL ABDILLAH PRATAMA_20240510_200008.jpg', 'berkas/nTEcDMSfEiR9RksaEzhOzV2aNIgVIwwwEqzP6eoS.jpg', 'ktp_RYAN YUZRIZAL ABDILLAH PRATAMA_20240510_200008.jpg', 'berkas/ZALq55MXr7e7G1klWultZZmjPKuSmjwkTjLEXw2S.jpg', 'akta_RYAN YUZRIZAL ABDILLAH PRATAMA_20240510_200008.jpg', 'berkas/WuLp1PjbLHnHNcGJEq29u0Xw3iS4vKnfh971t9d6.jpg', 'pas_foto_RYAN YUZRIZAL ABDILLAH PRATAMA_20240510_200008.jpg', 'berkas/dxWGThL5qDXruwp0IavNxg8qh7bC449uNAskq1Np.jpg', 'doc_pend_jalur_masuk_RYAN YUZRIZAL ABDILLAH PRATAMA_20240510_200008.pdf', 'berkas/UYccKYLpRIykncKkXXnxXggJyWaJwRR2zXb3h6Qs.pdf', '2024-05-10 13:00:08', '2024-05-10 13:00:08'),
(39, 45, 'ijazah_skl_Shofia.farohatul.jannah_20240512_094941.png', 'berkas/lItXqc4PbSIGBy1OupblfjrMYAPmfoLkBjrcA5j9.png', NULL, NULL, 'kk_Shofia.farohatul.jannah_20240512_094941.jpg', 'berkas/5WMEdRVVFFhqxA05zfymcYOzMahznHKTxxEu2X2y.jpg', 'ktp_Shofia.farohatul.jannah_20240512_094941.JPG', 'berkas/XdCjFOK5kjCSTAhsHXLVvpROvolB4ekif9NK1BCr.jpg', 'akta_Shofia.farohatul.jannah_20240512_094941.jpg', 'berkas/zKd8y3CeQaHOi9q6p8oMd4gRl6v5C5SW5pnNBzsN.jpg', 'pas_foto_Shofia.farohatul.jannah_20240512_094941.JPG', 'berkas/6JEErV7xVVdZmySYwLlRaMY0imC8jmLaS54SYQ8u.jpg', NULL, NULL, '2024-05-12 02:49:41', '2024-05-12 02:49:41'),
(40, 46, 'ijazah_skl_Dewi wulan safitri_20240513_104721.jpg', 'berkas/C2VK2OnVw8oLd8rF5jUUY9MNHQiyMVZmCBp8DoFg.jpg', NULL, NULL, 'kk_Dewi wulan safitri_20240513_104721.jpg', 'berkas/vHZwMSSA3RqpZO46ppBXyMAYLcUGm0d5eDjuSZfn.jpg', 'ktp_Dewi wulan safitri_20240513_104721.jpg', 'berkas/3JfSgepDZ9QuzxF3XZOyBUuteC7QdUsLmpbFR7vW.jpg', 'akta_Dewi wulan safitri_20240513_104721.jpg', 'berkas/XfDUF5KSYnI6vnM9tL1W72IgxK7i0E5Wxjb0nkdy.jpg', 'pas_foto_Dewi wulan safitri_20240513_104721.jpg', 'berkas/8qfQsGo5xc8HNVVDSKFOmAh4S0YkRd0Yhqiu6fow.jpg', 'doc_pend_jalur_masuk_Dewi wulan safitri_20240513_104721.jpg', 'berkas/JioCkwHvfRl9hGQoNa1FgW8S1gCI0lyg8Yd5y4bW.jpg', '2024-05-13 03:47:21', '2024-05-13 03:47:21'),
(41, 47, 'ijazah_skl_Dewi Wulan Safitri_20240513_114815.jpg', 'berkas/98eeGCfTXIPk3Gy2Si0CVQnbLjS6mL8Yb2CEYnTl.jpg', NULL, NULL, 'kk_Dewi Wulan Safitri_20240513_114815.jpg', 'berkas/d7WNAZuPicYsYlG1LeHMzuGCFMTghqtn8b4SsnTr.jpg', 'ktp_Dewi Wulan Safitri_20240513_114815.jpg', 'berkas/gIf6zs8P7uorq8rAQDb5H6zASnbkiiMwy8DFwfHY.jpg', 'akta_Dewi Wulan Safitri_20240513_114815.jpg', 'berkas/v72lB9DxokRffM0DuxcR1yRo2gqOLs5Ut69M6sPw.jpg', 'pas_foto_Dewi Wulan Safitri_20240513_114815.jpg', 'berkas/fgcTIOT65VxnH7fvnFawxTzUW3k9pHLlcDRN5jcY.jpg', 'doc_pend_jalur_masuk_Dewi Wulan Safitri_20240513_114815.jpg', 'berkas/KtdbAMv7MJJd9DFv74xvU8oVysPFpEO1QQYVpY8i.jpg', '2024-05-13 04:48:15', '2024-05-13 04:48:15'),
(42, 48, 'ijazah_skl_Lia Kamaliah_20240514_054443.jpg', 'berkas/GG3Iq3qttSFTChREI1UespXdicdbSg0hgJMB0mVn.jpg', NULL, NULL, 'kk_Lia Kamaliah_20240514_054443.jpg', 'berkas/rOKHqR8iUeyAOYODKSwLjS6vf0LyAGVgiU6t0F2v.jpg', 'ktp_Lia Kamaliah_20240514_054443.jpg', 'berkas/15bLci0LCiuFz2X9PrZdAectYw5baHCYBNh3dAtZ.jpg', 'akta_Lia Kamaliah_20240514_054444.jpg', 'berkas/D6A6ms1mKUQzdwC3A4FLFU9HcOJmnE7t89HRftbH.jpg', 'pas_foto_Lia Kamaliah_20240514_054443.jpg', 'berkas/PTqrCdx2qJtIlDzw1WPbkdhC7UeKpOFgX6RDyo0d.jpg', 'doc_pend_jalur_masuk_Lia Kamaliah_20240514_054444.jpg', 'berkas/Sxbp5qYfkwGRtD4Oz1jRZy25kznCQqavzRXz594r.jpg', '2024-05-13 22:44:43', '2024-05-13 22:44:44'),
(43, 49, 'ijazah_skl_AIDHATUL LAILA SULFITRIAH_20240514_092923.jpg', 'berkas/O3VcMqfeOJEJpAZo3J5srXeAAwE06wjV6LayRZDI.jpg', NULL, NULL, 'kk_AIDHATUL LAILA SULFITRIAH_20240514_092923.jpg', 'berkas/6wQDMe9XfskJmQozgBHbUj7IRQZML7LAlDND41gN.jpg', 'ktp_AIDHATUL LAILA SULFITRIAH_20240514_092924.jpg', 'berkas/B1M7Q09jY7yioATczZidQ0x7eLtzxmKoiOfDeNwv.jpg', 'akta_AIDHATUL LAILA SULFITRIAH_20240514_092924.jpg', 'berkas/LZr3zPXg9oeUGOyz6Wat1obfJIVTwIRbTA67dkSY.jpg', 'pas_foto_AIDHATUL LAILA SULFITRIAH_20240514_092923.jpg', 'berkas/R9vb2LMaNqrpIxqJfhDbCub180a1Z09SsjgNjeT6.jpg', NULL, NULL, '2024-05-14 02:29:23', '2024-05-14 02:29:24'),
(44, 50, 'ijazah_skl_SALDY HIDAYAT_20240514_093845.jpg', 'berkas/H8I579APF1TO135Af3f3MMp4aiiRs7FUJGvDjN9M.jpg', NULL, NULL, 'kk_SALDY HIDAYAT_20240514_093845.jpg', 'berkas/CgOhFNIiRmIj2klTclj5HigHfjlJ3FnJghUa1Gix.jpg', 'ktp_SALDY HIDAYAT_20240514_093845.jpg', 'berkas/e4ZCakUyPtCizsda2vwZjumyFsPEl1t1W426MIt4.jpg', 'akta_SALDY HIDAYAT_20240514_093845.jpg', 'berkas/p4LD9cs2rK4zxnyDdSvUvoU1qTrhVNNC9TDUVDcS.jpg', 'pas_foto_SALDY HIDAYAT_20240514_093845.png', 'berkas/KFu3Du6XuwqWm5Xf04ao8Zru5dZag8VxdWyk5Tvv.png', NULL, NULL, '2024-05-14 02:38:45', '2024-05-14 02:38:45'),
(45, 51, 'ijazah_skl_AHMAD NAHRU ZAMZAMY_20240514_164312.jpeg', 'berkas/NDJIBYmkPlPmLlwh63iDx6dlW5nsYT36jT6c2HgT.jpg', NULL, NULL, 'kk_AHMAD NAHRU ZAMZAMY_20240514_164312.jpeg', 'berkas/oRcTszVR0tCh1QJwH2AeZAtaT2yR7QDyGRKRcYpn.jpg', 'ktp_AHMAD NAHRU ZAMZAMY_20240514_164312.jpeg', 'berkas/jP1VDIKjlTsC79wOCf3uzYllluw14L4GIGdctAdQ.jpg', 'akta_AHMAD NAHRU ZAMZAMY_20240514_164312.jpeg', 'berkas/tj2wt8c1q47U7qVOFxuaVONNIy71nHJSPq0cnjDR.jpg', 'pas_foto_AHMAD NAHRU ZAMZAMY_20240514_164312.jpeg', 'berkas/pyzZwbSzlFK4Nlrh2CSFXuw6wQoYJc3qhxF9Z3dO.jpg', 'doc_pend_jalur_masuk_AHMAD NAHRU ZAMZAMY_20240514_164312.jpeg', 'berkas/BRU5nulAD0OKPvuuPbqLnDmjIwsEnEw1vyHqS4LY.jpg', '2024-05-14 09:43:12', '2024-05-14 09:43:12'),
(46, 52, 'ijazah_skl_AHMAD NAHRU ZAMZAMY_20240514_171739.jpeg', 'berkas/pQqrTw6MdBHN3umduNdWDHLlP88Vf46wiBivjHKj.jpg', NULL, NULL, 'kk_AHMAD NAHRU ZAMZAMY_20240514_171739.jpeg', 'berkas/1RUWxS5XS9txTMHhOIKBFgm1sb25Q6Ab18taktUf.jpg', 'ktp_AHMAD NAHRU ZAMZAMY_20240514_171739.jpeg', 'berkas/J1GRkysPoBoPO5lC4rEy2gZYhPz7LhBq6VM5YCxp.jpg', 'akta_AHMAD NAHRU ZAMZAMY_20240514_171739.jpeg', 'berkas/Wzkq3FQiXFJgSrb7mD4QCqUSl5o6EgzvQ4HuqXDM.jpg', 'pas_foto_AHMAD NAHRU ZAMZAMY_20240514_171739.jpeg', 'berkas/NB5zn77u8ZQRj8r9TWI7bJduJMyneIprUuO4jwvP.jpg', 'doc_pend_jalur_masuk_AHMAD NAHRU ZAMZAMY_20240514_171739.jpeg', 'berkas/YkR1Qx2uytt3jqjRGCzL46xOQgDprVCrTyy97EHi.jpg', '2024-05-14 10:17:39', '2024-05-14 10:17:39'),
(47, 53, 'ijazah_skl_ARINDA CITRA ARYANI_20240514_213205.jpg', 'berkas/A2sfxz0GbrjSyGFqDhMdspkfFInr3aoAeJIdcTGs.jpg', NULL, NULL, 'kk_ARINDA CITRA ARYANI_20240514_213205.pdf', 'berkas/tB9GVqnshjZR2xFuRVx0w0ZiGdQ8KwayKnFRecxB.pdf', 'ktp_ARINDA CITRA ARYANI_20240514_213206.jpg', 'berkas/CIVuuld8P01Kqy91VNDhsQIA6dUieueC8EeF1Xmz.jpg', 'akta_ARINDA CITRA ARYANI_20240514_213206.jpg', 'berkas/V8licF1Yy5Xx4LdTDvkzQSOnyfRs0979SLgS7b6V.jpg', 'pas_foto_ARINDA CITRA ARYANI_20240514_213205.png', 'berkas/NXLJg03Nx3yXuhsBaBvaUJsvK1ENGQodyOVSftrI.png', NULL, NULL, '2024-05-14 14:32:05', '2024-05-14 14:32:06'),
(48, 54, 'ijazah_skl_HABIB RIZQI JAMAL_20240515_131353.pdf', 'berkas/J5BCz8LxlAsNQeH8XaaQ8Z0EZFCr7lWZjZ6IdA5C.pdf', NULL, NULL, 'kk_HABIB RIZQI JAMAL_20240515_131353.pdf', 'berkas/LJd0bNHudTL2KGQ93zZfoPmvHpXrPupZRw1csihO.pdf', 'ktp_HABIB RIZQI JAMAL_20240515_131353.pdf', 'berkas/qOCFNuwUAgYlFFCHjugsxGOlTS42fZ3vdOjpy7sE.pdf', 'akta_HABIB RIZQI JAMAL_20240515_131353.pdf', 'berkas/itCKdNRtYfwFC8YkgwRAvfZ84FIoRschpkHToHxP.pdf', 'pas_foto_HABIB RIZQI JAMAL_20240515_131353.pdf', 'berkas/N6AY2eJozWECH0xe4QaW6XyaYlzYzhwZNZAJe1W0.pdf', 'doc_pend_jalur_masuk_HABIB RIZQI JAMAL_20240515_131353.pdf', 'berkas/JsIf4v2RtivBOuDzv95dvWdaT9TnVqBv3wVcifS2.pdf', '2024-05-15 06:13:53', '2024-05-15 06:13:53'),
(49, 55, 'ijazah_skl_Mahendra aditya abil_20240516_092048.jpg', 'berkas/bYj4IRNOU1ZeJopgtyuwmAjd3UrR5L6fz796as4C.jpg', NULL, NULL, 'kk_Mahendra aditya abil_20240516_092048.jpg', 'berkas/PIpjOoBqDc7UIRlEjW6kM6sYmi14QZo7Yqz4JFod.jpg', 'ktp_Mahendra aditya abil_20240516_092048.jpg', 'berkas/PMBvKO9JmOEiTShAHLboxt0nePrmw6pzMVb0HX1G.jpg', 'akta_Mahendra aditya abil_20240516_092049.jpg', 'berkas/u7h2FSR2Oz9yFkeFbtjw0S0tAibE0o3V4NAQPYEm.jpg', 'pas_foto_Mahendra aditya abil_20240516_092048.JPG', 'berkas/H7GMUrfhALLnmiEYvuQjvHFyGX6QtvByxZvaxeeJ.jpg', 'doc_pend_jalur_masuk_Mahendra aditya abil_20240516_092049.pdf', 'berkas/Cq3ERSaDJhP8Hhkv7lQsdbCYI1nC2aPSdGUACKlv.pdf', '2024-05-16 02:20:48', '2024-05-16 02:20:50'),
(50, 56, 'ijazah_skl_ISSETUL MUNAWWARAH_20240516_093432.jpeg', 'berkas/ldlADT5CfnXcrXO8ktvXxQGTdcTztUDj0UCuDvIA.jpg', NULL, NULL, 'kk_ISSETUL MUNAWWARAH_20240516_093432.jpeg', 'berkas/VUCFnhRC8ao7oR2arDzaHkil64WOXM5NZpHDNEHX.jpg', 'ktp_ISSETUL MUNAWWARAH_20240516_093432.jpeg', 'berkas/vwIVSSBnmrC9wTTPOfVvzDRTZtE6wlEQXumeY1B9.jpg', 'akta_ISSETUL MUNAWWARAH_20240516_093432.jpeg', 'berkas/6f7XOQT71T9Cq64dK443wmF9wb6Y2GYEGYUPPvcj.jpg', 'pas_foto_ISSETUL MUNAWWARAH_20240516_093432.jpeg', 'berkas/ugXaIyWJk9Sw7MuXqzzDXIPyKn0LVFGVinFJLGHw.jpg', 'doc_pend_jalur_masuk_ISSETUL MUNAWWARAH_20240516_093432.jpeg', 'berkas/EaUp3L7DrrWaEa1R9wxi67tco3xiKfd2ZCdu6v7P.jpg', '2024-05-16 02:34:32', '2024-05-16 02:34:32'),
(51, 57, 'ijazah_skl_GAFID ROHMAN_20240516_110247.pdf', 'berkas/sYeui1WdCBQBLHRBCinCwCjv9xOPVlbMiFoEbFmm.pdf', NULL, NULL, 'kk_GAFID ROHMAN_20240516_110247.pdf', 'berkas/sxzacOOLwhwKBuObhcoLt0hcsO0V0idKVG7EYfWW.pdf', 'ktp_GAFID ROHMAN_20240516_110247.pdf', 'berkas/1yBntmdJ7TiBwhG0T3dJ4cSGjxXOgio85LWwQM9H.pdf', 'akta_GAFID ROHMAN_20240516_110247.pdf', 'berkas/sxNsbLgqaWjWmmVZWhkveIPW3PWz5tydjoGBtxi9.pdf', 'pas_foto_GAFID ROHMAN_20240516_110247.pdf', 'berkas/0vksG7Je96XfqHuomhAdaXXcoIiW4qgnL9XXJAki.pdf', 'doc_pend_jalur_masuk_GAFID ROHMAN_20240516_110247.pdf', 'berkas/4epXATPbLrlw8tse33U3S1rTxVqBqOrwl4tuOpr3.pdf', '2024-05-16 04:02:47', '2024-05-16 04:02:47'),
(52, 58, 'ijazah_skl_Ayu Nindyawati_20240517_185437.pdf', 'berkas/comTXRLMlrF5H2FAvPcIk8I1l1gomW39R3mGI8Eq.pdf', NULL, NULL, 'kk_Ayu Nindyawati_20240517_185437.pdf', 'berkas/a9aUt86l2R7Wj1NYkzZkluDNHUba0KdqVnxSLKnA.pdf', 'ktp_Ayu Nindyawati_20240517_185438.pdf', 'berkas/C8pVi0lg22HzOd10FEQiJfyCkMLFuDmNVmRS95tV.pdf', 'akta_Ayu Nindyawati_20240517_185438.pdf', 'berkas/TJrzoyG23R4djfqLse2WlLEcTFU2eKSlpj5Cz8dD.pdf', 'pas_foto_Ayu Nindyawati_20240517_185437.JPG', 'berkas/vFspdzH5yoNlz8ni9O38auwbynEpLsuUK1J8bFeX.jpg', 'doc_pend_jalur_masuk_Ayu Nindyawati_20240517_185438.pdf', 'berkas/x54vWPPircKjl4cYJcm43ibWUR2BA5lhRpkDfWho.pdf', '2024-05-17 11:54:37', '2024-05-17 11:54:38'),
(53, 59, 'ijazah_skl_Saiful_20240518_105304.pdf', 'berkas/F84zmtvRiY4E2OHxrgOFiQKIcRmLRT9rG25xzb3z.pdf', NULL, NULL, 'kk_Saiful_20240518_105304.jpeg', 'berkas/2QY58X9BnUlkMLhpqrr1r422bAYbvOZ20Bpn9brk.jpg', 'ktp_Saiful_20240518_105304.jpeg', 'berkas/e0j2PkMKBUS7AIbqthmwFkmajn17L4HiI5Xevy6L.jpg', 'akta_Saiful_20240518_105304.jpeg', 'berkas/uwMJO4tW8z1OCrG0NsPIiCFXSUbjzWaFLf7aGjFD.jpg', 'pas_foto_Saiful_20240518_105304.jpeg', 'berkas/11JU4sGwBDkZ8DDlkxzHgS71euDAYRQo8onIsfII.jpg', 'doc_pend_jalur_masuk_Saiful_20240518_105304.png', 'berkas/XFZzllJKByqwZ59whFqBsHCzpLE7h5srMNvoBeVf.png', '2024-05-18 03:53:04', '2024-05-18 03:53:05'),
(54, 60, 'ijazah_skl_Sugianto Purnomo Mainaki_20240518_193509.jpg', 'berkas/H39LtHhWHZfItFbmlzO7PHaYM2pfulLbD92Nxptr.jpg', NULL, NULL, 'kk_Sugianto Purnomo Mainaki_20240518_193509.jpg', 'berkas/A8k03VfYp3hCaiupJK15g81OGw17ATLRD4tUndfD.jpg', 'ktp_Sugianto Purnomo Mainaki_20240518_193509.jpg', 'berkas/MdTNHT6fEQbrplew6JREXh7J4vX9FTmelcg6c16U.jpg', 'akta_Sugianto Purnomo Mainaki_20240518_193509.jpg', 'berkas/EAUEq9cMikT3SHiqNw4aob88RcNRuMeWJHEv1obo.jpg', 'pas_foto_Sugianto Purnomo Mainaki_20240518_193509.jpg', 'berkas/dyBFvxuRZIUHJR6JyPpcBYL1T1zgfVRqVmmKi6qd.jpg', 'doc_pend_jalur_masuk_Sugianto Purnomo Mainaki_20240518_193509.jpg', 'berkas/pUBLoYNMXzBEM9xtDIbibAkkTDHeinaF9hfqxLMt.jpg', '2024-05-18 12:35:09', '2024-05-18 12:35:09'),
(55, 61, 'ijazah_skl_RIZAL ARISANDI_20240519_171326.pdf', 'berkas/Qrx5pAYxQptJ23sn0KNfpdB2lmHl60D3wQATlm8e.pdf', NULL, NULL, 'kk_RIZAL ARISANDI_20240519_171326.pdf', 'berkas/iXtSxTDszehUikQP5BRJLaDDnzdIJWEyvLhwxiuB.pdf', 'ktp_RIZAL ARISANDI_20240519_171326.jpg', 'berkas/Z6weTc3IzTAglaNb6xaeJ6czYqK41DpoHGhjysaM.jpg', 'akta_RIZAL ARISANDI_20240519_171326.pdf', 'berkas/TXeGfXo62UHDUwXALz1Jb2rEAqqk1T99ao5IyVbU.pdf', 'pas_foto_RIZAL ARISANDI_20240519_171326.jpg', 'berkas/Id5QFsI6F1pLbbVqCcPMQABK8C9PmHcjHrulsiKy.jpg', 'doc_pend_jalur_masuk_RIZAL ARISANDI_20240519_171326.pdf', 'berkas/zzzq9o6Zy7GfNWewrQUmgUka5PoXSosNODXGWhCL.pdf', '2024-05-19 10:13:26', '2024-05-19 10:13:27'),
(56, 62, 'ijazah_skl_DHURRIYATUS SHOLIHAH_20240521_083041.jpg', 'berkas/evqS56C0KgV38vddfA8CeClDpj2cRGPpelXoqwnv.jpg', NULL, NULL, 'kk_DHURRIYATUS SHOLIHAH_20240521_083041.jpg', 'berkas/n74ttggwYfY3wSJvEXv0L0lhkBefCIcnHeUMH93u.jpg', 'ktp_DHURRIYATUS SHOLIHAH_20240521_083041.jpg', 'berkas/2JnjFUp0clz23LMj18tpjUvu1v3izkTpB4LKFYyb.jpg', 'akta_DHURRIYATUS SHOLIHAH_20240521_083041.jpg', 'berkas/NgAkYG5UNRXyrE0cQzp7NPGpxm4f7Uvq6L0F2TOi.jpg', 'pas_foto_DHURRIYATUS SHOLIHAH_20240521_083041.jpg', 'berkas/xGp92AoplqUVK7bq3T0BaJQRUSb4dOHKTKqsShdS.jpg', 'doc_pend_jalur_masuk_DHURRIYATUS SHOLIHAH_20240521_083041.jpg', 'berkas/kvQaWxcw4IS2aJxd2zhFDC2CqIMvdIljm6XUpWrM.jpg', '2024-05-21 01:30:41', '2024-05-21 01:30:41'),
(57, 63, 'ijazah_skl_Rosik_20240521_105020.jpg', 'berkas/JGrrbLxGpWolS2b9iSitXExHdDTHbDAafle3BlT7.jpg', NULL, NULL, 'kk_Rosik_20240521_105020.jpg', 'berkas/K4YvROZbEdDwSg19ejh4Si1BsTrdaNpYFEsqvabc.jpg', 'ktp_Rosik_20240521_105020.jpg', 'berkas/X99Hag4MhGhREsNIqlvdHu3fMbx1UTRiWh9LwNwI.jpg', 'akta_Rosik_20240521_105021.jpg', 'berkas/JNGizgb7XxIsYDzvJl9NAwmkSyLzraooCXSpf8nO.jpg', 'pas_foto_Rosik_20240521_105020.jpg', 'berkas/eVl3fvocLAukXpUx07MT3ibqB2iZzTfUNGNyUy9r.jpg', 'doc_pend_jalur_masuk_Rosik_20240521_105021.jpg', 'berkas/0FUJeyokjAwHuqaUtaCGtPAmPEroAIVymSdQkNZI.jpg', '2024-05-21 03:50:20', '2024-05-21 03:50:21'),
(58, 64, 'ijazah_skl_MOH. FATHOR ROHMAN_20240522_052238.pdf', 'berkas/54bdkywOxfe51eDKsMQ4hfgHfApqSjxbQjNIemjc.pdf', NULL, NULL, 'kk_MOH. FATHOR ROHMAN_20240522_052238.jpeg', 'berkas/XPCeIvnUzSek5pBOqtjUuZBH5CxCY4qE2XA8p43A.jpg', 'ktp_MOH. FATHOR ROHMAN_20240522_052238.jpeg', 'berkas/9INF6M1j2WEPmjYuY8fiuVOj3JBiKGAYKu2wP4Nh.jpg', 'akta_MOH. FATHOR ROHMAN_20240522_052238.jpeg', 'berkas/ajrRUdwUDyY33HDh5kLoPzGEeWYVbhByrltmffa8.jpg', 'pas_foto_MOH. FATHOR ROHMAN_20240522_052238.jpeg', 'berkas/71xh8JDOy5qiezjsGsvL2A19XduquNGjksMa8wyW.jpg', 'doc_pend_jalur_masuk_MOH. FATHOR ROHMAN_20240522_052238.pdf', 'berkas/ambOncY0EcZjdv4TNaR8ts1oF5MnzN1pmymzhZ1d.pdf', '2024-05-21 22:22:38', '2024-05-21 22:22:38'),
(59, 65, 'ijazah_skl_Nova Yasmin Putri_20240522_103301.jpg', 'berkas/A3ub8o7MEmNvh4TQdQeVSmeBjL5jnuNJ3btnPV7d.jpg', NULL, NULL, 'kk_Nova Yasmin Putri_20240522_103301.jpg', 'berkas/qLgk0nHFUWg32QA8hfJY0nxVydzQV1tvY0zIBo37.jpg', 'ktp_Nova Yasmin Putri_20240522_103302.jpg', 'berkas/qrB40L9ydtgIzzVOtsslTm9NSXJcP2ZOulQ3AtrB.jpg', 'akta_Nova Yasmin Putri_20240522_103302.jpg', 'berkas/bkoxfEMMzubg0MDsCd9AL6i7d2RfSg5fLC0kgA6P.jpg', 'pas_foto_Nova Yasmin Putri_20240522_103301.jpg', 'berkas/452xGXCopnLQ150O26UPxdEUGy0DCf61IC3vH8w9.jpg', 'doc_pend_jalur_masuk_Nova Yasmin Putri_20240522_103302.jpg', 'berkas/RQNIAIWtyju7FQgNEWdpHojCFtdxVgB87BDS2NC4.jpg', '2024-05-22 03:33:01', '2024-05-22 03:33:02'),
(60, 66, 'ijazah_skl_MOCH FAISAL_20240522_142601.jpg', 'berkas/YSSHyzLWL4MHUNOLB3lzXbtFakmekZQxN7Xnj6Ti.jpg', NULL, NULL, 'kk_MOCH FAISAL_20240522_142601.jpg', 'berkas/qpTKHsrLgkvlfZHcuidJu9cR6Fptu7kxs3y4XXQa.jpg', 'ktp_MOCH FAISAL_20240522_142601.jpg', 'berkas/hVRUVat4Rza8ryzuRpXbWwQRBUr97E4KBHFE51EY.jpg', 'akta_MOCH FAISAL_20240522_142601.jpg', 'berkas/uu6asROKTZM9Wpy1eAgDAFMZEor8cpthtJUEIuNg.jpg', 'pas_foto_MOCH FAISAL_20240522_142601.jpeg', 'berkas/SDitiw93euN608RzDkpMDoGB53p3Dck6M2VGIw8g.jpg', 'doc_pend_jalur_masuk_MOCH FAISAL_20240522_142601.jpg', 'berkas/biRS5vshxcokHrzfZAZCjUkV4qtxqPqXHphjSDHI.jpg', '2024-05-22 07:26:01', '2024-05-22 07:26:02'),
(61, 67, 'ijazah_skl_MOCH FAISAL_20240522_144153.jpg', 'berkas/fPluMSXdlxnEJlnUqSZa3yMIBstcI4pmiRFwUVj7.jpg', NULL, NULL, 'kk_MOCH FAISAL_20240522_144153.jpg', 'berkas/F6fW42AKHOyTDOOuID6iVKDs4KbfegOUJOcrBws5.jpg', 'ktp_MOCH FAISAL_20240522_144153.jpg', 'berkas/jMZ5y9vgCI2Ls7hoTNJWfQJD1J3gi0ZLe5EcIoFz.jpg', 'akta_MOCH FAISAL_20240522_144154.jpg', 'berkas/2q7IcnJD900NC54dUiTZlT5P2jl7bTGA8PmdheJK.jpg', 'pas_foto_MOCH FAISAL_20240522_144153.jpeg', 'berkas/Y7OiFnY9TsaKfT47Uzy8IFDXyY8i7BRBiFBcSr6K.jpg', 'doc_pend_jalur_masuk_MOCH FAISAL_20240522_144154.jpg', 'berkas/kpQoCSR5B92jT9OIjlNxIVzAXFh5GBRSFD6Jd7Uf.jpg', '2024-05-22 07:41:53', '2024-05-22 07:41:54'),
(62, 68, 'ijazah_skl_KAYLA ANDINI ANSORI_20240523_182145.pdf', 'berkas/i3jpQdj8RXtnx8YTdGzX36P0fVfrfJnkvohtm1yr.pdf', NULL, NULL, 'kk_KAYLA ANDINI ANSORI_20240523_182146.pdf', 'berkas/1xObSteLyYJp5mKTlqtj5EI3Al6kB5HDEPChdYMn.pdf', 'ktp_KAYLA ANDINI ANSORI_20240523_182146.jpeg', 'berkas/jhtWq6ov7mGn1AmPcl3MwfpEcJbAkRIanRtl0Xxa.jpg', 'akta_KAYLA ANDINI ANSORI_20240523_182146.pdf', 'berkas/lAuPPgftj6uDx4QmKV8x4tCP92ttlvCB4uKgaEzC.pdf', 'pas_foto_KAYLA ANDINI ANSORI_20240523_182145.jpg', 'berkas/QkPFCT9qmHPaz8aPgJNGYuyu3XYSixZYKvcFUO52.jpg', NULL, NULL, '2024-05-23 11:21:45', '2024-05-23 11:21:46'),
(63, 69, 'ijazah_skl_THEO SYAPUTRA_20240524_090212.pdf', 'berkas/Hislou6Uv1Y8qei7awXuItk8VPcrWKarsD1520KO.pdf', NULL, NULL, 'kk_THEO SYAPUTRA_20240524_090212.pdf', 'berkas/BsLGgFXP6HzzJa6TROimU5SUNZoakNyqud1cis6N.pdf', 'ktp_THEO SYAPUTRA_20240524_090212.jpeg', 'berkas/70zUoxcCbceSt1e2vAYDrxlMFFMgDXsEAbeBYCcI.jpg', 'akta_THEO SYAPUTRA_20240524_090212.pdf', 'berkas/RDXTo8fixC6ETguK94PUncjDiBdopOIECl08HeN9.pdf', 'pas_foto_THEO SYAPUTRA_20240524_090212.jpeg', 'berkas/f96Iprp9en3cJpVcdoubsusFigrRHN2bz5c9Adwt.jpg', NULL, NULL, '2024-05-24 02:02:12', '2024-05-24 02:02:12'),
(64, 70, 'ijazah_skl_IKHTIATUS SHOLIHAH_20240524_201414.pdf', 'berkas/2ySVA64JdN6qthaZuQUOgCEUj2A8uNkhoK5wD8Eb.pdf', NULL, NULL, 'kk_IKHTIATUS SHOLIHAH_20240524_201414.pdf', 'berkas/uMAt645nBf6b9xK9AcjGH0lQOvSl6SzmUUrn6C6u.pdf', 'ktp_IKHTIATUS SHOLIHAH_20240524_201414.jpg', 'berkas/dmyQPMrNyBaObEjYbBCD1CaaQt8Gm1eXXPPOpmqO.jpg', 'akta_IKHTIATUS SHOLIHAH_20240524_201414.pdf', 'berkas/9Fpq8LPuuodUirMSOLEzH85bFYnkgfTfJdoGkzBs.pdf', 'pas_foto_IKHTIATUS SHOLIHAH_20240524_201414.png', 'berkas/jqOWJsd6WxGqtrc23DuqTh6ZKM2IFi8IxuSQ0ktJ.png', 'doc_pend_jalur_masuk_IKHTIATUS SHOLIHAH_20240524_201415.jpg', 'berkas/zkv1ESuDedlMgVpAnAaOfy7BJG7F6vADaWIiSaPk.jpg', '2024-05-24 13:14:14', '2024-05-24 13:14:15'),
(65, 71, 'ijazah_skl_SARAFAH ABADIYAH_20240525_151312.jpg', 'berkas/WGXbQU61MVfPeTM79FMjfPXnXghYMYqBrhP9JNL8.jpg', NULL, NULL, 'kk_SARAFAH ABADIYAH_20240525_151312.jpg', 'berkas/XnDER9GfKTOq4lDP0sessIqMyKgtBDWaYL2h3aIC.jpg', 'ktp_SARAFAH ABADIYAH_20240525_151312.jpg', 'berkas/inz9QchNAL7Imsuxtrecc6aIfL7cD5LoCAWJ8PYj.jpg', 'akta_SARAFAH ABADIYAH_20240525_151312.jpg', 'berkas/qeb9cxfkN7Vho56CMUhXX74JpUytqsXlAmH6QC8F.jpg', 'pas_foto_SARAFAH ABADIYAH_20240525_151312.jpg', 'berkas/HDnuZwdQDKL7Il70Fl8h7FJBGhHpy6zcJSpuQlPQ.jpg', 'doc_pend_jalur_masuk_SARAFAH ABADIYAH_20240525_151312.pdf', 'berkas/gmQy8kUUm4EZ1LsIHvSuUyp2sDEpnA7rT9pYtTW0.pdf', '2024-05-25 08:13:12', '2024-05-25 08:13:12'),
(66, 72, 'ijazah_skl_SARAFAH ABADIYAH_20240525_171959.jpg', 'berkas/3TiovSNTZdfdgSErHbceIAaY7hTf4ifT0eKkn3gu.jpg', NULL, NULL, 'kk_SARAFAH ABADIYAH_20240525_171959.jpg', 'berkas/PAFuj9dXH2NMhpArFwzeyW8nsTTG2lB1Y4zUUekT.jpg', 'ktp_SARAFAH ABADIYAH_20240525_171959.jpg', 'berkas/rrLdkmTEgr3WCldiOUEvcHLHiH9ccAX1RhGp0BFM.jpg', 'akta_SARAFAH ABADIYAH_20240525_171959.jpg', 'berkas/VdKFv5XGluZJA5nCXMr6koiy7cTX5oymF3eyskSR.jpg', 'pas_foto_SARAFAH ABADIYAH_20240525_171959.jpg', 'berkas/pcHnLmwSj89SaTmScrc9lXp2qNQSV5TRbpAImc9y.jpg', 'doc_pend_jalur_masuk_SARAFAH ABADIYAH_20240525_171959.pdf', 'berkas/RuXkrkNedpivOgNtZR007TiVLDnxA4BTpUFhXa4Y.pdf', '2024-05-25 10:19:59', '2024-05-25 10:19:59'),
(67, 73, 'ijazah_skl_MAS\'UDI_20240527_160552.pdf', 'berkas/xpfebCDzRNhKcBegcMPzWgLto3xQPVxkY4mMspfg.pdf', NULL, NULL, 'kk_MAS\'UDI_20240527_160552.pdf', 'berkas/PhGte4CVI3BNkupAY0Ox7I5bbesZ7jVdq7oNT8ea.pdf', 'ktp_MAS\'UDI_20240527_160552.pdf', 'berkas/s6BT4wdfHyWMSh0ZftGjSV1nBBNSV1YZuaLJXcmd.pdf', 'akta_MAS\'UDI_20240527_160552.pdf', 'berkas/OB32RnpAXkN3N5BS4k4zx0LoS3HocIXWsCgY6eQ8.pdf', 'pas_foto_MAS\'UDI_20240527_160552.jpeg', 'berkas/QUnhO8C4iYh6TFSFAbJo7427ZgQ6wSqm2AgkCapw.jpg', 'doc_pend_jalur_masuk_MAS\'UDI_20240527_160552.pdf', 'berkas/8kKROw2xbEOkHENiMUGju0gFMcGRqqEajKBUMy80.pdf', '2024-05-27 09:05:52', '2024-05-27 09:05:53'),
(68, 74, 'ijazah_skl_AHMAD MUSLEH_20240528_110207.jpeg', 'berkas/DS2I7TDMNejyEgLzz8WjpyZTE4iHujfZcYq9VMgF.jpg', NULL, NULL, 'kk_AHMAD MUSLEH_20240528_110207.jpeg', 'berkas/qtvcUgDcEMvQwmLpOnnJQQ6gRgp7COr3CIAwZJQP.jpg', 'ktp_AHMAD MUSLEH_20240528_110207.jpeg', 'berkas/idgqDF6P5JLiyBYAu9teJ5By6BNSM7ENhepuUgYu.jpg', 'akta_AHMAD MUSLEH_20240528_110207.jpeg', 'berkas/N2GTHQ4VuxnPtws1tWB4eYYg7Cg68jKRpq9fFF8T.jpg', 'pas_foto_AHMAD MUSLEH_20240528_110207.jpeg', 'berkas/KC7VNfeZndoDkvpj9e0DbpZA4c1PZaHezH3men1H.jpg', 'doc_pend_jalur_masuk_AHMAD MUSLEH_20240528_110207.pdf', 'berkas/KKntLemKKOewD2KX3HlOFBY63XmWrAau5nVh57Xj.pdf', '2024-05-28 04:02:07', '2024-05-28 04:02:07'),
(69, 75, 'ijazah_skl_ISTI QOMARIAH_20240529_092431.jpg', 'berkas/paLrWSj5TiCsZTrcVx2fAWHcG53k483LcijMm780.jpg', NULL, NULL, 'kk_ISTI QOMARIAH_20240529_092431.jpg', 'berkas/42uBYGLluSuOypmRpeosgkyqeLMYq550GXoo7qWp.jpg', 'ktp_ISTI QOMARIAH_20240529_092431.pdf', 'berkas/z1I3EUKKCph16LJ9ZaBRU2hzMrL13zOeQBU2Dt2L.pdf', 'akta_ISTI QOMARIAH_20240529_092431.jpg', 'berkas/pqQVUCvcKx9Efpoa8Na6pMr6jXDG7C59XfJytC5y.jpg', 'pas_foto_ISTI QOMARIAH_20240529_092431.jpg', 'berkas/JmNR3YPwtbqsrWMt2hzpV6Y9md3tqJ2RQ1YOgMn0.jpg', 'doc_pend_jalur_masuk_ISTI QOMARIAH_20240529_092431.jpg', 'berkas/21ySkL7N9jLaXSRknKwwoOpVpjodbY9ronE8hqhM.jpg', '2024-05-29 02:24:31', '2024-05-29 02:24:31'),
(70, 76, 'ijazah_skl_ABDEL HAQQ PAHLEVY_20240529_114052.pdf', 'berkas/hGrVINT3vrrucaaOj7ZXYPSsnH4BqaSq0iblZZIu.pdf', NULL, NULL, 'kk_ABDEL HAQQ PAHLEVY_20240529_114052.pdf', 'berkas/nhalAz77mdJ1VYJjvbtOpUweRbaYqqeYzmxdNr8v.pdf', 'ktp_ABDEL HAQQ PAHLEVY_20240529_114052.pdf', 'berkas/r4sQQqFMpPThZROa3mNDCj0oLkpU7qQJye6YGIXk.pdf', 'akta_ABDEL HAQQ PAHLEVY_20240529_114052.pdf', 'berkas/5gUoOJvxGLoVR4s24kZMl0CDo14lafkogVvJ8mAO.pdf', 'pas_foto_ABDEL HAQQ PAHLEVY_20240529_114052.jpg', 'berkas/K3Ta33Xab4GKHsvC8qXWouCJSys7BNSK7DzIzDUW.jpg', 'doc_pend_jalur_masuk_ABDEL HAQQ PAHLEVY_20240529_114052.pdf', 'berkas/vMF7SWLdW6XMgepRUulAyXYnuIlcuUIcukyKElxg.pdf', '2024-05-29 04:40:52', '2024-05-29 04:40:52'),
(71, 77, 'ijazah_skl_SYAIFUL BAHRI_20240529_123701.pdf', 'berkas/h1Zzvm7pr122E7QyTimSt3OmkVXWZNMbYZhBGzBF.pdf', NULL, NULL, 'kk_SYAIFUL BAHRI_20240529_123701.pdf', 'berkas/FdBI3CRGvU1DtEVaTxOr5ZwrVhcbXj0mSjb2MYlW.pdf', 'ktp_SYAIFUL BAHRI_20240529_123701.pdf', 'berkas/0naAKu00OiUCU7IQmGPhoIGCWM6kcFSMnKuDKZgC.pdf', 'akta_SYAIFUL BAHRI_20240529_123701.pdf', 'berkas/zFmCiIu4itZTmqL3tYawNTcMQoStxgBsaLs75yej.pdf', 'pas_foto_SYAIFUL BAHRI_20240529_123701.pdf', 'berkas/8Kd1GaMYITvO73yuVfdbLoBy4UM21wNp2tsPtGmB.pdf', 'doc_pend_jalur_masuk_SYAIFUL BAHRI_20240529_123701.pdf', 'berkas/izVgfUB19tLIFKxGZ4TcsxhGXWgRgBXFHCTKtmpt.pdf', '2024-05-29 05:37:01', '2024-05-29 05:37:02'),
(72, 78, 'ijazah_skl_HAIRUL_20240529_132234.jpg', 'berkas/jEUDBp1tiAXevzD4XBZoYmYIj8dLGDodeyssDl49.jpg', NULL, NULL, 'kk_HAIRUL_20240529_132234.jpg', 'berkas/gApV5h1u8T1RDHfmnZeAq57z65ZWwVh8aCZqXTzU.jpg', 'ktp_HAIRUL_20240529_132234.jpg', 'berkas/kW23z4SegeMCIyxST6wwGcEtE05OZTfymROu81Dz.jpg', 'akta_HAIRUL_20240529_132234.jpg', 'berkas/iJbOe6I0GciPHgIRoDqTboyMG8nknPvwJLbau3nv.jpg', 'pas_foto_HAIRUL_20240529_132234.jpg', 'berkas/8jSLJ6thqPt7a0w4uz8e6ot4TLLx0GMR4G7NsUTz.jpg', NULL, NULL, '2024-05-29 06:22:34', '2024-05-29 06:22:34');

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

--
-- Dumping data for table `informasis`
--

INSERT INTO `informasis` (`id`, `title`, `slug`, `content`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Pendaftaran Mahasiswa Baru 2024', 'pendaftaran-mahasiswa-baru-2024', '<p>Telah di buka Pendaftaran Mahasiswa Baru 2024</p>', 'pengumuman/loJTCKUHuXhEX3PFtsaQytu1KH0SrEELD7ExYlZr.jpg', '2024-04-23 03:33:13', '2024-04-23 03:33:13'),
(2, 'Pendaftaran Mahasiswa Baru Jalur RPL 2024', 'pendaftaran-mahasiswa-baru-jalur-rpl-2024', '<p>Telah dibuka Pendaftaran Mahasiswa Baru 2024 Jalur RPL</p>', 'pengumuman/OaGtMoBuzpyW21mS8fk5mngbHa5Klqm5BLiGsSjD.jpg', '2024-04-23 03:34:12', '2024-04-23 03:34:12');

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
(1, 'STKIP PGRI Bangkalan', 'Jl. Soekarno Hatta No.52, Wr 07, Mlajah, Kec. Bangkalan, Kabupaten Bangkalan, Jawa Timur 69116', 'admin@stkippgri-bkl.ac.id', '03199301078', NULL, '2024-04-02 04:45:44');

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
(5, 'Jalur TES', '<p>Jalur Tes Mandiri di STKIP PGRI Bangkalan</p>', 250000, 9, 100, 'aktif', NULL, '2024-04-24 03:24:52'),
(7, 'Jalur Prestasi - Non Tes', '<p>Jalur ini dikhususkan untuk Calon Mahasiswa yang memiliki prestasi baik dibidang Akademik maupun Non Akademik yang dibuktikan dengan mengupload <strong>Serifikat Prestasi.</strong></p>\r\n\r\n<p>Benefit yang diperoleh :</p>\r\n\r\n<p>- Untuk Prestasi Tingkat Lokal Diskon 25% Biaya Komponen</p>\r\n\r\n<p>- Untuk Prestasi Tingkat Nasional Diskon 50% Biaya Komponen</p>\r\n\r\n<p>- Untuk Prestasi Tingkat Internasional Gratis Biaya Komponen</p>', 250000, 2, 35, 'aktif', '2024-04-24 03:20:58', '2024-04-24 03:41:10'),
(8, 'Jalur Registrasi Utama - Non Tes', '<p>Jalur ini diperuntukkan bagi Calon Mahasiswa yang <strong>Wajib</strong> melakukan Registrasi Ualng lebih awal yaitu dengan waktu 1 minggu setelah pengumuman hasil seleksi Calon Mahasiswa Baru diumumkan.</p>\r\n\r\n<p>Jalur ini mempunyai Benefit yaitu mendapatkan <strong>Gratis <em>Notebook</em></strong><strong>.</strong></p>\r\n\r\n<p>&nbsp;</p>', 250000, 4, 35, 'aktif', '2024-04-24 03:22:32', '2024-04-24 04:21:02'),
(9, 'Jalur Putra/putri PGRI - Non Tes', '<p>Jalur ini diperuntukkan bagi Calon Mahasiswa yang orangtuanya berprofesi sebagai Guru yang beranggotakan PGRI, yang dibuktikan dengan mengupload <strong>Kartu PGRI</strong> milik orangtuanya.</p>\r\n\r\n<p>Jalur ini mempunyai Benefit yaitu <strong>Diskon 30% SPP Selama 8 Semester.</strong></p>', 250000, 4, 70, 'aktif', '2024-04-24 03:23:04', '2024-04-24 03:47:39'),
(10, 'Jalur Putra/putri Guru - Non Tes', '<p>Jalur ini diperuntukkan bagi Calon Mahasiswa yang orangtuanya berprofesi sebagai Guru, yang dibuktikan dengan mengupload <strong>SK Kerja</strong>&nbsp;milik orangtuanya.</p>\r\n\r\n<p>Jalur ini mempunyai Benefit yaitu <strong>Diskon 10% SPP Selama 8 Semester.</strong></p>', 250000, 1, 35, 'aktif', '2024-04-24 03:23:33', '2024-04-24 03:50:20'),
(11, 'Jalur Santri dan Santriwati - Non Tes', '<p>Jalur ini diperuntukkan bagi Calon Mahasiswa yang berstatus sebagai Santri / Santriwati di pondok pesantren, yang dibuktikan dengan mengupload <strong>Kartu Santri</strong>&nbsp;atau <strong>Surat Keternagan dari pondok</strong>.</p>\r\n\r\n<p>Jalur ini mempunyai Benefit yaitu <strong>Diskon 50% SPP 1 Semester.</strong></p>', 250000, 9, 70, 'aktif', '2024-04-24 03:24:07', '2024-04-24 03:52:48'),
(12, 'Jalur SNPMB - Non Tes', '<p>Jalur ini diperuntukkan bagi Calon Mahasiswa yang gagal mengikuti seleksi kampus Negeri / SNPMB, yang dibuktikan dengan mengupload <strong>Kartu Peserta SNPMB</strong>.</p>\r\n\r\n<p>Jalur ini mempunyai Benefit yaitu <strong>Diskon 25% DPP.</strong></p>', 250000, 1, 140, 'aktif', '2024-04-24 03:24:41', '2024-04-24 03:55:13'),
(13, 'Jalur MOU - Non Tes', '<p>Jalur ini diperuntukkan bagi Calon Mahasiswa yang sekolahnya telah melakukan kerjasama / MOU dengan kampus kami STKIP PGRI Bangkalan, yang dibuktikan dengan mengupload <strong>Scan Berkas MOU.</strong></p>\r\n\r\n<p>Jalur ini mempunyai Benefit yaitu <strong>Diskon 50% DPP.</strong></p>', 250000, 1, 35, 'aktif', '2024-04-24 03:26:19', '2024-04-24 03:57:35'),
(14, 'Jalur KIP - Non Tes', NULL, 250000, 19, 100, 'aktif', '2024-04-24 03:27:18', '2024-04-24 03:27:18'),
(15, 'Program S1 Rekognisi Pembelajaran Lampau (RPL)', '<p>Program percepatan kuliah dengan persyaratan wajib yaitu ijazah SMA/Sederajat dan dengan Pengalaman Kerja minimal 2 tahun, yang dibuktikan dengan mengupload&nbsp;<strong>SK Kerja.</strong></p>', 250000, 9, 100, 'aktif', '2024-04-24 03:31:20', '2024-04-24 04:18:24');

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
(2, 'S1 REGULER', '2023-11-29 00:23:56', '2024-04-24 03:14:38'),
(3, 'S1 Program Rekognisi Pembelajaran Lampau (RPL)', '2024-04-02 01:51:53', '2024-04-24 03:15:20');

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
(5, 'S1 Pendidikan Pancasila & Kewarganegaraan', NULL, 200, 199, '2023-11-29 01:20:49', '2024-04-24 03:29:32'),
(6, 'S1 Pendidikan Ekonomi', NULL, 200, 191, '2023-11-29 01:22:15', '2024-04-02 04:40:10'),
(7, 'S1 Pendidikan Bahasa & Sastra Indonesia', NULL, 200, 198, NULL, '2024-04-02 04:41:33'),
(8, 'S1 Pendidikan Bahasa Inggris', NULL, 200, 197, '2024-04-02 04:41:22', '2024-04-02 04:41:22'),
(9, 'S1 Pendidikan Matematika', NULL, 200, 198, '2024-04-02 04:41:52', '2024-04-02 04:41:52'),
(10, 'S1 Pendidikan Olahraga', NULL, 200, 186, '2024-04-02 04:42:10', '2024-04-02 04:42:10'),
(11, 'S1 Pendidikan Sekolah Dasar (PGSD)', NULL, 200, 177, '2024-04-02 04:42:32', '2024-04-02 04:42:32');

-- --------------------------------------------------------

--
-- Table structure for table `registers`
--

CREATE TABLE `registers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL DEFAULT '',
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
-- Dumping data for table `registers`
--

INSERT INTO `registers` (`id`, `user_id`, `nama`, `nama_ibu`, `jk`, `hp`, `email`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kewarganegaraan`, `identitas_kewarganegaraan`, `jenjang_pendidikan_id`, `sistem_kuliah_id`, `jalur_masuk_id`, `nama_sekolah`, `jenis_sekolah`, `jurusan_sekolah`, `tahun_lulus`, `nisn`, `alamat_sekolah`, `pilihan1`, `pilihan2`, `pilihan3`, `pembayaran`, `bukti_pembayaran`, `status_diterima`, `diterima_di`, `created_at`, `updated_at`) VALUES
(12, 14, 'JOYA NUR PRIYANTI GUNAWAN', 'DWI YANI RAHMAWATI', 'P', '085748156621', 'joyanurp@gmail.com', 'BANGKALAN', '2005-09-20', 'DSN. KARANGASEM, KEL. TANJUNG JATI', 'INDONESIA', '3526046009050002', 2, 2, 12, 'SMAN 1 KAMAL', 'SMA', 'IPA', '2024', '0056103043', 'KAMAL', 10, 11, 7, 'sudah', 'bukti-pembayaran/jjk4ZMQv0HVyCf7WYPmFqMULslE1PYvqQ9SzhCiT.jpg', 'diterima', 10, '2024-04-24 05:20:16', '2024-04-24 05:27:30'),
(14, 16, 'ALFIN MUBAROK', 'MUATI', 'L', '081359103938', 'Alfinmubarokk2005@gmail.com', 'bangkalan', '2005-05-24', 'Mrecah Tanah Merah', 'Indonesia', '3526132405050001', 2, 2, 14, 'MANBAUL HIKAM', 'MAS', 'IPS', '2024', '0057372561', 'JL. RAYA KETENGAN NO 62', 10, 7, 6, 'sudah', 'bukti-pembayaran/3YeS031F6NWyDGsdIyl8i9oBFYfUROIp4ZN7aNXZ.jpg', 'diterima', 10, '2024-04-29 04:51:46', '2024-04-29 08:13:27'),
(15, 17, 'HOIRUL ANAM', 'MUTIYAH', 'L', '082131713198', 'hoirulanam7656@gmail.com', 'Bangkalan', '2005-07-27', 'Galis Barat Galis Bangkalan', 'Indonesia', '3526162707050002', 2, 2, 14, 'MANBAUL HIKAM', 'MAS', 'IPA', '2024', '0054841799', 'JL. RAYA KETENGAN NO 62', 10, 7, 6, 'sudah', 'bukti-pembayaran/jjmhz49A8fjNsijmROJHJB3bpkVCjwtQ7U0B1a9i.jpg', 'diterima', 10, '2024-04-29 04:57:35', '2024-04-29 08:13:53'),
(16, 18, 'SHUFHAN JAMIL', 'JUMA\'ATI', 'L', '081999109501', 'jamilbangkalan6@gmail.com', 'BANGKALAN', '2004-08-04', 'Dsn. Petaonan Utara, Kel. Petaonan, Kec. Socah', 'INDONESIA', '3526020408040003', 2, 2, 14, 'SMK Al-Mujtama\'', 'SMK', 'Rekayasa Perangkat Lunak', '2022', '0047003855', 'Pamekasan', 11, 8, 10, 'sudah', 'bukti-pembayaran/BcYWbKSDpANivAj6ncghzTxz7Z2IX5YcpoX3IMYC.jpg', 'diterima', 11, '2024-04-29 05:06:06', '2024-04-29 08:14:12'),
(17, 19, 'RIZKY BAHTIAR', 'ST. FAUZAH', 'L', '085785474822', 'riskyfira51@gmail.com', 'BANGKALAN', '2005-09-17', 'Dsn. Seddang, Desa Paka\'an Dajah, Kec. Galis', 'INDONESIA', '3526181709050003', 2, 2, 14, 'MAS Al - Ibrohimy', 'MAS', 'IPS', '2024', '3065735732', 'Galis', 10, 11, 7, 'sudah', 'bukti-pembayaran/fHvbxUuJQaYuUW7xuIwvGdtkF406yO4YKfhyhZ9w.jpg', 'diterima', 10, '2024-04-29 05:33:32', '2024-04-29 08:14:43'),
(18, 20, 'MOH. HUSNIL MA\'ARIF', 'KHOIRIYAH', 'L', '087774818718', 'maarifjanuary6111@gmail.com', 'SAMPANG', '2006-01-11', 'Dsn. Trebung, Kel. Taman, Kec. Sreseh', 'INDONESIA', '3527011101060005', 2, 2, 9, 'SMAS AL KHOTIBIYAH', 'SMAS', 'IPA', '2024', '0061661603', 'SAMPANG', 11, 7, 9, 'sudah', 'bukti-pembayaran/FQSh3DBSwyG625Fh84G5kUTIsg4QvPqEdAJv2UbB.jpg', 'diterima', 11, '2024-04-29 05:42:00', '2024-04-29 08:15:02'),
(19, 21, 'SITI ROFIAH', 'SUMIATI', 'P', '081918158401', 'rofiaah31@gmail.com', 'BANGKALAN', '2005-08-31', 'Dsn. Longkak, Kel. Kelbung, Kec. Sepulu', 'INDONESIA', '3526087108050002', 2, 2, 11, 'SMKS Al Muhajirin', 'SMKS', 'Teknik Komputer dan Jaringan', '2023', '0057772676', 'Bangkalan', 11, 6, 8, 'sudah', 'bukti-pembayaran/yQFLtlrJrmcx1pCrCfB81uNxqWSTm3r6zdMiMPJn.jpg', 'diterima', 11, '2024-04-29 05:50:49', '2024-04-29 08:15:17'),
(20, 22, 'Andika dwi anggara', 'Rukayyah', 'L', '087898320355', 'andikadwia1@gmail.com', 'Bangkalan', '1996-10-04', 'Jl Teuku Umar rt003 rw003 kaskel Kemayoran bangkalan', 'Indonesia', '3526010410960001', 2, 2, 15, 'SMA Negeri 03 Bangkalan', 'SMA', 'IPS', '2015', '9968070713', 'Jl. RE. Marthadinata No. 7 Rw 05 Mlajah Bangkalan 69116', 11, 6, 8, 'sudah', 'bukti-pembayaran/lNFWdFCHKv1DnZsD47dp2dqOQnQdwltRzeJayG4q.png', 'diterima', 11, '2024-04-30 06:40:14', '2024-05-03 02:16:35'),
(21, 23, 'Aynia Ramadani', 'Sari\'ah', 'P', '081997971417', 'slametriadi@gmail.com', 'Bangkalan', '2006-09-29', 'Dsn Prengkenek Desa Bumianyar Kec Tanjung Bumi', 'Indonesia', '3526096909060001', 2, 2, 8, 'Pendidikan Diniyah Formal Ulya Al Fitrah', 'lainya', 'Lainnya', '2023', '0068986332', 'Jalan Kedinding Lor 99 surabaya', 6, 7, 5, 'belum', 'bukti-pembayaran/bGNRjhelyqI2vMXOfTzbqybSkVmeyQMlR3jdyq7z.jpg', 'tidak diterima', NULL, '2024-04-30 13:21:18', '2024-04-30 13:21:18'),
(22, 24, 'Aynia Ramadani', 'Sari\'ah', 'P', '081997971417', 'ayniaramadani29@gmail.com', 'Bangkalan', '2006-09-29', 'Dsn Perreng kenek, desa bumi anyar, kec.Tanjung Bumi', 'Indonesia', '3526096909060001', 2, 2, 8, 'Pendidikan Diniyah Formal Ulya Al Fitrah', 'lainya', 'Lainnya', '2023', '0068986332', 'Jalan Kedinding Lor 99 surabaya', 6, 7, 5, 'sudah', 'bukti-pembayaran/aAkfsECuNQIr5flGnMxJ7lQlkLHWZMIOX2aOXSRM.jpg', 'diterima', 6, '2024-04-30 13:50:24', '2024-05-03 02:24:12'),
(23, 25, 'ROSUL MUHAMMAD DANI', 'Yumrosiyeh', 'L', '085174133441', 'rmuhdani2@gmail.com', 'Bangkalan', '2005-11-07', 'Kp. Tanah Tinggi, Desa Semanan, Kec. Kalideres', 'Indonesia', '3526080711050002', 2, 2, 7, 'SMKS Al Muhajirin', 'SMKS', 'TKJ', '2023', '0055234952', 'Buduran, Arosbaya', 8, 7, 6, 'sudah', 'bukti-pembayaran/s86lnzEskzAh1V8y2AnUQ7KsBzTq7kYHPQGJ9lbN.jpg', 'diterima', 8, '2024-05-03 06:40:29', '2024-05-03 07:08:08'),
(24, 26, 'MIFTAHUL ANSHORI', 'Siti Fatima', 'L', '085607795984', 'miftahulanshoriii@gmail.com', 'Bangkalan', '2003-12-26', 'Dsn. Demangan, Kel. Tunjung, Kec. Burneh', 'Indonesia', '3526032612030001', 2, 2, 14, 'SMK An Nur Fuadi', 'SMK', 'TKJ', '2022', '0039154525', 'Bangkalan', 11, 8, 5, 'sudah', 'bukti-pembayaran/XZmV0x6uiSkmA4KBqqnNl3OziklVfGzNu34lTMSM.jpg', 'diterima', 11, '2024-05-03 06:48:41', '2024-05-03 07:07:49'),
(25, 27, 'MOH. RAIHAN', 'Makkiyah', 'L', '087758558217', 'reeihan19@gmail.com', 'Bangkalan', '2005-02-19', 'Ds. Pangeran Gedungan, Kel. Pangeran Gadungan, Kec. Blega', 'Indonesia', '3526151902050001', 2, 2, 5, 'SMK Negeri 1 Blega', 'SMK', 'Akuntansi', '2023', '0067804489', 'Blega', 10, 7, 9, 'sudah', 'bukti-pembayaran/6kV6wvsHVjxybJGRqzP30uUEoeOYuP3oh5KPmvxJ.jpg', 'diterima', 10, '2024-05-03 06:58:22', '2024-05-03 07:07:34'),
(26, 28, 'SITI ALIYAH', 'Nasiyah', 'P', '085648072375', 'salya2752@gmail.com', 'Bangkalan', '2005-09-14', 'Kmp. Barat Embong, Ds. Sabiyan, Kec. Bangkalan', 'Indonesia', '3526015409050002', 2, 2, 5, 'SMA Negeri 2 Bangkalan', 'SMA', 'IPA', '2024', '0058295619', 'Bangkalan', 6, 9, 8, 'sudah', 'bukti-pembayaran/iYIArsfYrUCahq5auPJhwIoqHKNXct38q2QJJOdk.jpg', 'diterima', 6, '2024-05-03 07:06:37', '2024-05-03 07:07:12'),
(27, 29, 'MUHLIS', 'HORRIYEH', 'L', '085959153075', 'mukhlisfadil28@gmail.com', 'SAMPANG', '2005-11-09', 'MONGGING, ROBATAL', 'INDONESIA', '3527101206050003', 2, 2, 5, 'SMK Darul Amin', 'SMK', 'TKJ', '2023', '0051690549', 'Sumber telor, Pandiyangan, Robatal', 6, 11, 7, 'sudah', 'bukti-pembayaran/mCBhYJmioDwfJ1ZJHXGgpoQaMhflWbxDHZtIl0dd.jpg', 'diterima', 6, '2024-05-03 07:39:02', '2024-05-03 07:45:57'),
(28, 30, 'SALIMATUS SAKDIYAH', 'MISRANI', 'P', '085231466664', 'salimatussakdiyah98@gmail.com', 'Bangkalan', '1998-05-30', 'Dusun Glepa Desa Dupok', 'Indonesia', '3526107005980001', 2, 3, 5, 'Madrasah Aliyah Darul Amin', 'MA', 'IPA', '2016', '9988846943', 'Kecamatan Waru Kabupaten Pamekasan', 11, 10, 5, 'belum', 'bukti-pembayaran/bnaBj9LW1SCjZo2Yja5VPxoK7btmTDwQYphWvIjf.jpg', 'tidak diterima', NULL, '2024-05-03 08:41:28', '2024-05-03 08:41:28'),
(29, 31, 'LATIFATUL SOFIYAH', 'SITI HOTIJAH', 'P', '085955322249', 'asadfhieas12345@gmail.com', 'Bangkalan', '2006-07-03', 'DSN. MORAGUNG SANGGRA AGUNG SOCAH BANGKALAN', 'Indonesia', '3526024307060002', 2, 2, 14, 'MANBAUL HIKAM', 'MAS', 'IPS', '2024', '3066658008', 'JL. RAYA KETENGAN NO 62', 6, 11, 7, 'sudah', 'bukti-pembayaran/0lIYn1oDYFuiJC4pLmyw5f0aqwqQEAxURzcjse67.jpg', 'diterima', 6, '2024-05-06 01:55:19', '2024-05-06 02:29:40'),
(30, 32, 'ABDUL MUIN', 'Senima', 'L', '081933055339', 'abdmuin041086@gmail.com', 'Bangkalan', '1986-10-04', 'Dsn. Bruwas, Ds. Kampao, Kec. Blega', 'WNI', '3526150410860003', 3, 3, 15, 'MA  AL MUKHLISIN KAMPAO', 'MA', 'IPS', '2005', '0', 'Dsn. Dajah Lorong, Ds. Kampao, Kec. Blega', 11, 5, 7, 'sudah', 'bukti-pembayaran/pi32wN3w3wW0KktZMWMngqc5bJvTEgps2KNfDme0.png', 'diterima', 11, '2024-05-07 02:53:19', '2024-05-07 03:49:01'),
(31, 33, 'Marsuli', 'St.Rahmah', 'L', '085257661438', 'suli.ajadech@gmail.com', 'Bangkalan', '1985-07-12', 'Kmp. Dajah Lorong, RT/RW 000/000', 'Indonesia', '3526151207850011', 3, 3, 15, 'MA Al Mukhlisin', 'MA', 'IPA', '2005', '0', 'Dusun dajah lorong.desa kampao', 11, 5, 7, 'sudah', 'bukti-pembayaran/yq1Gh64cFCb6Tw1JcIlYtaNESil2JyPi3fKa5Ln5.jpg', 'diterima', 11, '2024-05-07 03:41:36', '2024-05-07 03:51:24'),
(32, 34, 'MUHAMMAD MAMLU\'UL HIKAM', 'Nur Khozinatul Asroriyah', 'L', '08985499804', 'usaifuddin732@gmail.com', 'Bangkalan', '2005-09-08', 'Jl. Pemuda Kaffa No. 98, Kel. Tunjung, Kec. Burneh', 'Indonesia', '3526030809050001', 2, 2, 14, 'MAS Manbaul Hikam', 'MAS', 'IPS', '2024', '0051320388', 'Bangkalan', 7, 10, 8, 'sudah', 'bukti-pembayaran/IzAxUZ6nQ7TiwqXVJ6yyKi0xke83eiX8r0z0aE9C.jpg', 'diterima', 7, '2024-05-07 04:45:50', '2024-05-07 05:13:24'),
(33, 35, 'AFIFATUN NISA\'', 'Sunarah', 'P', '087814382937', 'safinatulummah@gmail.com', 'Bangkalan', '2006-07-10', 'Dsn. Terem, Desa Kelapayan, Kec. Sepulu', 'Indonesia', '3526085012050001', 2, 2, 11, 'SMA Ar Raudhah', 'SMAS', 'IPA', '2024', '0053585129', 'Sbaneh, Bancaran, Bangkalan', 11, 9, 7, 'sudah', 'bukti-pembayaran/sh7Z91LWKEo3ucJG58h8kukcxRLbRu5HJUskTaVy.jpg', 'diterima', 11, '2024-05-07 04:56:51', '2024-05-07 05:14:02'),
(34, 36, 'RINA SULIS TIANA', 'Tohira', 'P', '085859718362', 'sitifadilah.sf5991@gmail.com', 'Bangkalan', '2004-03-24', 'Ds. Jambu, Burneh', 'Indonesia', '3526036403040001', 2, 2, 11, 'SMK Ifadah', 'SMKS', 'TKJ', '2023', '0045494051', 'Bangkalan', 11, 7, 8, 'sudah', 'bukti-pembayaran/vENnK8wYzFNlEZ0Y6UhYng3r4xOhozhXyaju4yzf.jpg', 'diterima', 11, '2024-05-08 07:32:01', '2024-05-08 07:42:41'),
(35, 37, 'ALIVIATUL MAHYU', 'Siti Sumiati', 'P', '083852957589', 'aliviatulmahyu@gmail.com', 'Bangkalan', '2005-05-11', 'Dsn. Langkap Barat, Kel. Langkap, Kec. Burneh', 'Indonesia', '3526035105050002', 2, 2, 14, 'SMAN 04 Bangkalan', 'SMA', 'IPS', '2024', '0056726214', 'Bangkalan', 9, 11, 6, 'sudah', 'bukti-pembayaran/ujsVMmjmYwUfAedh0tW2zxz7tIT66ms0MhOh0Bji.jpg', 'diterima', 9, '2024-05-08 07:42:11', '2024-05-08 07:42:50'),
(36, 38, 'LAILA MASRUROH', 'Dewi Nurhayati', 'P', '087714587910', 'lailamasruroh259@gmail.com', 'Bangkalan', '2004-11-16', 'KMP. Modung Timur Desa Modung Kec. Modung Kan. Bangkalan', 'Indonesia', '3526165611040001', 2, 2, 11, 'SMA AT-THOLHAWIYAH', 'SMA', 'IPA', '2023', '0044025353', 'Sumurnangka Desa Suwa\'an Modung Bangkalan', 11, 8, 6, 'sudah', 'bukti-pembayaran/K1rC5wVy6EyGPI6WraYIFZiDymIijHGV1lexLPSn.jpg', 'diterima', 11, '2024-05-08 08:49:36', '2024-05-13 01:36:01'),
(37, 39, 'Siti Sholehah', 'Musyrifah', 'P', '082312098050', 'sholehahs785@gmail.com', 'BANGKALAN', '2001-10-01', 'Sepuran, Sukolilo Timur, Labang-Bangkalan', 'Indonesia', '3526124110010002', 2, 2, 11, 'MA Nurul Iman', 'MA', 'IPA', '2019', '0018740595', 'Jl. KH. Dimyathi No.128 Sukolilo Barat, Labang, Bangkalan', 8, 9, 11, 'sudah', 'bukti-pembayaran/X0VtYzsL6QWMsgvosT1Smd4n61xlgQPMiqsCvs8n.jpg', 'diterima', 8, '2024-05-08 10:48:54', '2024-05-13 01:44:17'),
(38, 40, 'RUSTIANAWATI', 'Sulaimah', 'P', '087740445599', 'rustianaismail@gmail.com', 'Bangkalan', '1983-11-20', 'Dsn. Tanggungan Ds. Bragang Klampis Bangkalan', 'Indonesia', '3526076011830006', 3, 3, 15, 'DARUL ULUM 3 PETERONGAN JOMBANG', 'SMU', 'Ipa', '2003', '000000', 'Kompleks PP Darul \'Ulum,, Jl. K.H. Moh. As\'ad, Jl. KH. Umar Tamim, Wonokerto Selatan, Peterongan, Kec. Peterongan, Kabupaten Jombang, Jawa Timur 61481', 11, 7, 5, 'sudah', 'bukti-pembayaran/hWg3hW242AxSRQaNKseyn6yZ0iUQdT7VzOuF9aCr.jpg', 'diterima', 11, '2024-05-08 12:12:49', '2024-05-13 02:41:35'),
(40, 42, 'NUR KHOLIS AKBAR', 'SURATIK', 'L', '081515151791', 'denakbar567@gmail.com', 'BANGKALAN', '1994-05-14', 'JL. OLAH RAGA PEKADAN RT/RW: 002/003 DESA BLEGA KECAMATAN BLEGA', 'INDONESIA', '3526151405940001', 3, 3, 15, 'SMA NEGERI 1 BLEGA', 'SMA', 'IPA', '2013', '9948678768', 'JL. RAYA BLEGA KECAMATAN BLEGA KABUPATEN BANGKALAN', 10, 11, 5, 'sudah', 'bukti-pembayaran/UuU12Nq5z1q32mEMLuMMTikLx5nCMmToMsfYjObR.jpg', 'diterima', 10, '2024-05-08 15:34:20', '2024-05-13 03:26:59'),
(41, 43, 'YESSIROH', 'Jumliyah', 'P', '0', 'yessisiroh@gmail.com', 'Bangkalan', '2004-12-23', 'Dsn. judabung , Banyoning Dajah Geger Bangkalan', 'Indonesia', '3526066312040001', 2, 2, 14, 'SMA AR RAUDHAH', 'SMA', 'IIS', '2023', '0045581436', 'Sebaneh Bancaran Bangkalan', 11, 6, 10, 'sudah', 'bukti-pembayaran/3pnD9AaKwskJSvABZQMPtPRVHgwYuqrXuCR917rX.jpg', 'tidak diterima', NULL, '2024-05-09 04:48:58', '2024-05-13 02:14:53'),
(42, 44, 'RYAN YUZRIZAL ABDILLAH PRATAMA', 'YUHANITA PRIMAYANTI', 'L', '0881027196726', 'syamsul.gunawan@trunojoyo.ac.id', 'jember', '2006-02-24', 'Jln. Laut Arafuru 2 No.15 Blok 1B Perumnas Bumi Tunjung Permai Burneh BANGKALAN', 'INDONESIA', '3526032402060001', 2, 2, 14, 'SMA NEGERI OLAHRAGA JAWA TIMUR', 'SMA', 'IPS', '2024', '0067586936', 'Dukuh, Pagerwojo, Kec. Buduran, Kabupaten Sidoarjo, Jawa Timur 61252', 10, 6, 11, 'sudah', 'bukti-pembayaran/lQNsrXpyYlBdQm4gHTM3DVRLTaGK25tgndak2Y1t.jpg', 'diterima', 10, '2024-05-10 13:00:08', '2024-05-13 02:25:28'),
(43, 45, 'Shofia.farohatul.jannah', 'Hanisah', 'P', '087743262522', 'shofiafj669@gmail.com', '04092005', '2005-09-04', 'Klampis.barat', 'indonesia', '3526074409050001', 2, 2, 5, 'Smk alhikam', 'smk', 'tkj', '2024', '0059479768', 'Tunjung.burneh', 11, 6, 9, 'sudah', 'bukti-pembayaran/6O8ohc5dlb9w9t5gnp1bQpUK2pyo5eU9VEJ8nix2.png', 'diterima', 11, '2024-05-12 02:49:41', '2024-05-13 02:30:04'),
(44, 46, 'Dewi wulan safitri', 'Fina Yulia', 'P', '082132983309', 'safitriiwulan686@gmail.com', '19/07/2005', '2005-07-19', 'Dan. Asem', 'Indonesia', '3526045907050001', 2, 2, 11, 'Pendidikan diniyah formal ulyah Al fithrah', 'SMA', 'Lainnya', '2024', '3059605445', 'Jalan ke dinding lor 99 Surabaya', 6, 11, 8, 'sudah', 'bukti-pembayaran/zNWGX3kwGShm6GgdqF4fTcsQngekhbL0OMoy3eRb.jpg', 'diterima', 6, '2024-05-13 03:47:21', '2024-05-13 08:31:11'),
(46, 48, 'Lia Kamaliah', 'Chodijah', 'P', '081333187008', 'liakamaliah2052@gmail.com', 'Bangkalan 20 mei 2002', '2002-05-20', 'DSN Lar-Lar', 'Indonesia', '3526186005020001', 2, 2, 5, 'MA Salafiyah bangil', 'MA', 'IPS', '2023', '0022123356', 'Bangil Pasuruan', 6, 7, 5, 'sudah', 'bukti-pembayaran/BbTIEmMMn3UsSc5usOQ8wMmsf8A2YeFyRa7g8NGn.jpg', 'diterima', 6, '2024-05-13 22:44:43', '2024-05-14 01:59:32'),
(47, 49, 'AIDHATUL LAILA SULFITRIAH', 'Ummi Saodah', 'P', '082332734294', 'vivijhuteks@gmail.com', 'SAMPANG', '2006-09-18', 'Dsn. Labuhan Tengah, Kel. Labuhan, Kec. Sreseh, Kab. Sampang', 'Indonesia', '3527015809060001', 2, 2, 8, 'SMAS Al Khatibiyah', 'SMAS', 'IPA', '2024', '0069253185', 'Jl. Kh. Achmad Dahlan No. 374 Modung, Bangkalan', 11, 8, 9, 'sudah', 'bukti-pembayaran/N7vXL3wrNnCJNel6li9EON2usNXJFKVfCAgIcSwQ.jpg', 'diterima', 11, '2024-05-14 02:29:23', '2024-05-14 02:39:26'),
(48, 50, 'SALDY HIDAYAT', 'Lailik Solehatin', 'L', '089671033331', 'saldyhidayat2005@gmail.com', 'PAMEKASAN', '2005-11-26', 'Dsn. Bicabbi I, Kel. Larangan Luar, Kec. Larangan, Kab. Pamekasan', 'Indonesia', '6402162611050002', 2, 2, 5, 'SMK Negeri 2 Pamekasan', 'SMKN', 'TKJ', '2024', '0055648603', 'Jl. Proppo 161 Pamekasan', 10, 6, 5, 'sudah', 'bukti-pembayaran/klynlf6c9YWMRFGqeyY3zXSKIXWfujxq5nQCAehA.jpg', 'diterima', 10, '2024-05-14 02:38:45', '2024-05-14 02:39:38'),
(49, 51, 'AHMAD NAHRU ZAMZAMY', 'ENNY NURHARIYANI', 'L', '082334300364', 'nahruzamzamy@gmail.com', 'Bojonegoro', '2006-04-28', 'KMP. KEDUNGDUNG RT. 003/ RW.006 Ds. PATEREMAN Kec. MODUNG BANGKALAN', 'INDONESIA', '3526162804060003', 2, 2, 11, 'SMA AL-KHATIBIYAH', 'SMA', 'IPA', '2024', '0063885570', 'Jl. KH Achmad Dahlan No. 374 Modung Bangkalan', 10, 11, 5, 'sudah', 'bukti-pembayaran/76AvTEjwSMHsXw8MWyKA3IYfKryrLFK8zVrjITLz.jpg', 'diterima', 10, '2024-05-14 09:43:12', '2024-05-15 01:42:23'),
(51, 53, 'ARINDA CITRA ARYANI', 'RUMYAH', 'P', '088228551367', 'arindacitra124@gmail.com', 'BANGKALAN 24 JANUARI 2005', '2005-01-24', 'dsn keleyan ds keleyan kec socah kab bangkalan', 'indonesia', '3526026401050003', 2, 2, 5, 'SMAN 3 BANGKALAN', 'SMA', 'IPA', '2023', '0054949263', 'JL. R.E MARTADINATA NO.54', 11, 7, 6, 'sudah', 'bukti-pembayaran/VtqsU5IuHdgdKeiWXlEdG3ultuHBSQlNIEO9n1O7.jpg', 'diterima', 11, '2024-05-14 14:32:05', '2024-05-15 01:51:15'),
(52, 54, 'HABIB RIZQI JAMAL', 'Musriyati', 'L', '088991997169', 'habibbriski460@gmail.com', 'Bangkalan', '2006-10-08', 'JL. KH MOCH CHOLIL GANG 3 DEMANGAN BARAT BANGKALAN MADURA', 'INDONESIA', '3520010010000005', 2, 2, 14, 'SMAN 1 BANGKALAN', 'SMA', 'IPA', '2024', '0062601183', 'JL. PEMUDA KAFFA NO. 10 BANGKALAN MADURA', 8, 7, 10, 'sudah', 'bukti-pembayaran/nejYtjIYEH7O5qUvZIieyESWBuxu5wE0hl9ruDXl.jpg', 'diterima', 8, '2024-05-15 06:13:53', '2024-05-15 08:28:09'),
(53, 55, 'Mahendra aditya abil', 'Surati', 'L', '085236270792', 'adityaabil122@gmail.com', 'Bangkalan', '2005-03-05', 'Jl colibri 1/AD 13', 'Indonesia', '13634', 2, 2, 13, 'SMA 1 Bangkalan', 'SMA', 'IPS', '2024', '0056142256', 'Jl. Pemuda Kaffa No.10, Rw. 05, Keraton, Kec. Bangkalan,', 11, 5, 7, 'sudah', 'bukti-pembayaran/D5i50L3wIkVAB4cl9lqAOmkD0jLGf0Ca0kLtaP7L.jpg', 'diterima', 11, '2024-05-16 02:20:48', '2024-05-16 03:20:58'),
(54, 56, 'ISSETUL MUNAWWARAH', 'Sutirah', 'P', '082333486337', 'Issahmunawaroh@gmail.com', 'Bangkalan', '2006-05-05', 'Dsn..Lonbillah Banyoning Dajah, Geger, Bangkalan', 'Indonesia', '3526064506060002', 2, 2, 14, 'SMA AR RAUDHAH', 'SMA', 'MIPA', '2023', '0065102075', 'Sebaneh Bancaran Bangkalan', 11, 10, 5, 'sudah', 'bukti-pembayaran/XFK0T5TnvCvaM655KFgMsuwg03ondijB4NzBtlHS.jpg', 'diterima', 11, '2024-05-16 02:34:32', '2024-05-16 03:34:49'),
(55, 57, 'GAFID ROHMAN', 'HOLIDEH', 'L', '087795080627', 'rohmangafid@gmail.com', '05 07 2006', '2024-05-15', 'Katol barat geger bangkalan madura', 'Indonesia', '3526066002800003', 2, 2, 14, 'SMA AD DAMANHURI', 'SMA', 'IPS', '2024', '0049423333', 'Doro agung Kompol geger bangkalan', 5, 7, 10, 'sudah', 'bukti-pembayaran/gNYLzYM4B3ANV80YkbCWo1W2AWZScfdWbtFJOV8I.jpg', 'diterima', 5, '2024-05-16 04:02:47', '2024-05-16 05:50:33'),
(56, 58, 'Ayu Nindyawati', 'Nur Komariyah', 'P', '085780485273', 'nindyawatiayu27@gmail.com', 'Bangkalan', '2005-12-27', 'Telang permai', 'Indonesia', '3526046712050003', 2, 2, 9, 'SMAN 1 KAMAL', 'SMA', 'IPS', '2024', '0053631763', 'Jl. Raya Telang No. 02  perumahan Telang indah, Telang, kec.kamal, kabupaten bangkalan, Jawa Timur', 11, 7, 5, 'sudah', 'bukti-pembayaran/uOtPGJdTdoBNRH7lNPtq0cypzuK4h8REgSFRWfux.png', 'diterima', 11, '2024-05-17 11:54:37', '2024-05-20 02:40:40'),
(57, 59, 'Saiful', 'SOLEHA', 'L', '085815211220', 'fexno01@gmail.com', 'BANGKALAN', '2005-01-28', 'KMP. MELATEH BARAT DS. KARANG NANGKAH', 'INDONESIA', '3526152801050001', 2, 2, 14, 'SMK SYAIFUL JAMIL BLEGA', 'SMK', 'Otomatisasi dan Tata Kelola Perkantoran (OTKP)', '2024', '9991188573', 'Dsn. Jinginjing Ds. Alas Rajah', 10, 7, 5, 'sudah', 'bukti-pembayaran/RcaFXpfeTxND2KT7nNKNMHxq4GTa3vgvM51sRR3e.jpg', 'diterima', 10, '2024-05-18 03:53:04', '2024-05-20 02:43:40'),
(58, 60, 'Sugianto Purnomo Mainaki', 'Catur Setyo Sunaryati', 'L', '081906663866', 'sugi29.5@gmail.com', 'Bangkalan', '1999-05-29', 'Jl Nusa Indah 26 Bangkalan', 'Indonesia', '3526012905990003', 3, 3, 15, 'SMAN 2 BANGKALAN', 'SMA', 'IPA', '2016', '000', 'Jl. Soekarno-hatta Bangkalan', 10, 11, 6, 'sudah', 'bukti-pembayaran/IdmMyHjFyxhoceR5uxxwAf8bODmaccFxxI50XoQc.png', 'tidak diterima', NULL, '2024-05-18 12:35:09', '2024-05-20 01:55:13'),
(59, 61, 'RIZAL ARISANDI', 'JUBAIDAH', 'L', '087750140088', 'risalarisandi.ra@gmail.com', 'Bangkalan', '1994-06-25', 'Jl. Hos Cokro Aminoto Rt.002/Rw.006 Kel. Pangeranan Kec. Bangkalan', 'Indonesia', '3526012506940002', 3, 3, 15, 'SMA NEGERI 3 BANGKALAN', 'SMA', 'IPA', '2013', '5658', 'Jl. R.E. Marthadinata No.7, Wr 05, Mlajah, Kec. Bangkalan, Kabupaten Bangkalan, Jawa Timur', 11, 7, 5, 'sudah', 'bukti-pembayaran/ubZhfLr1remqghMBhFlIFi9S6DV5E3tvuYgbqzmi.jpg', 'diterima', 11, '2024-05-19 10:13:26', '2024-05-20 02:32:47'),
(60, 62, 'DHURRIYATUS SHOLIHAH', 'SITI KUTSIYAH', 'P', '081999524708', 'dhurriatuslilik@gmail.com', 'BANGKALAN', '2006-01-18', 'Jl. Raya Ketengan, Kel. Tunjung, Kec. Burneh', 'INDONESIA', '3526035801060001', 2, 2, 9, 'SMAN 4 Bangkalan', 'SMA', 'IPA', '2024', '0064562701', 'Jl. Raya Pertahanan 4, Bangkalan', 11, 7, 9, 'sudah', 'bukti-pembayaran/f2piGDQav6Sbg1De0hw7xRjaxfIVaSEv4cF0LVCp.jpg', 'diterima', 11, '2024-05-21 01:30:41', '2024-05-21 01:35:02'),
(61, 63, 'Rosik', 'Wakiah', 'L', '085945429425', 'rosikvern@gmail.com', 'Bangkalan', '2001-12-22', 'Besalak, Katol Barat, Kec. Geger, Kab. Bangkalan', 'Indonesia', '3526062212010003', 2, 3, 14, 'YPI DARUT TAUHID', 'SMA', 'IPS', '2023', '0015383159', 'Desa Katol barat, Kec. Geger Kab. Bangkalan', 7, 8, 6, 'sudah', 'bukti-pembayaran/pMGHvYX68Zujlm6G0hiZPIJ9neDdL2MKL1HBknQ4.jpg', 'diterima', 7, '2024-05-21 03:50:20', '2024-05-21 04:46:01'),
(62, 64, 'MOH. FATHOR ROHMAN', 'NUR HASANAH', 'L', '082333926975', 'zains.habibi2014@gmail.com', 'Bangkalan', '2006-08-18', 'Dusun Mandala Desa Tlangoh', 'Indonesia', '3526091808060001', 2, 2, 14, 'SMA Negeri 1 Tanjungbumi', 'SMA', 'IPA', '2024', '0065259108', 'Jl Raya Desa Macajah', 10, 11, 5, 'sudah', 'bukti-pembayaran/1KVl4f7nK1QF8qF5LYIDFk5Y9DWmd5jx7OlnZUca.jpg', 'diterima', 10, '2024-05-21 22:22:38', '2024-05-22 03:30:30'),
(63, 65, 'Nova Yasmin Putri', 'Ratna Dewi', 'P', '082330883260', 'novayasminputrii@gmail.com', 'Sampang', '2006-02-11', 'Dusun Timur Banyusangkah Tanjungbumi', 'Indonesia', '3526095102060001', 2, 2, 9, 'SMA Negeri 1 Tanjungbumi', 'SMA', 'IPS', '2024', '0068225687', 'Jl. Raya Macajah No 22 Tanjungbumi', 11, 6, 7, 'sudah', 'bukti-pembayaran/BNbX2XyoaF8AD6cgn1DYREW78ChWf1ytoo7HoOcy.jpg', 'diterima', 11, '2024-05-22 03:33:01', '2024-05-22 03:54:25'),
(65, 67, 'MOCH FAISAL', 'TIRUMLAH', 'L', '085784797493', 'mohfaisal2968@gmail.com', 'Bangkalan', '2004-02-11', 'Dsn. Gibugan Banyoneng Laok', 'Indonesia', '3526061102040001', 2, 2, 14, 'SMKS ROUDLOTUT THOLIBIN', 'SMK', 'TKJ', '2023', '0047875722', 'Jl. Pasar Anyar kombangan', 6, 5, 7, 'sudah', 'bukti-pembayaran/7UbpraVjnB1eSZihFQS77BJZsjXD1b77Imh1sCXb.jpg', 'diterima', 6, '2024-05-22 07:41:53', '2024-05-22 08:34:01'),
(66, 68, 'KAYLA ANDINI ANSORI', 'MERSI', 'P', '085646422763', 'akaylaandini@gmail.com', 'BANGKALAN', '2005-07-31', 'Dsn. Wak Duwak Desa Paseseh Kec. Tanjung Bumi Kab. Bangkalan', 'WNI', '3526097107050002', 2, 2, 5, 'MA AL - JAUHARIYAH', 'MA', 'IPS', '2023', '0051138177', 'JL. KH Ahmad Djauhari Sembung Jatra Timur Kec. Banyuates Kab. Bangkalan 69263', 11, 7, 6, 'sudah', 'bukti-pembayaran/dUO621cJBFgGxlgJ8w7yP6Hj00lYcDQ7mSvja5H2.jpg', 'diterima', 11, '2024-05-23 11:21:45', '2024-05-27 01:32:54'),
(67, 69, 'THEO SYAPUTRA', 'PATMI ANDARI', 'L', '085232919020', 'syaputratheo98@gmail.com', 'BANGKALAN', '2006-03-03', 'JL KH ACH MUNIF NO 22 BURNEH', 'ISLAM', '3526030303060001', 2, 2, 8, 'SMA NEGERI 2 BANGKALAN', 'SMA', 'IPS', '2024', '0069186643', 'JL SOEKARNO HATTA BANGKALAN', 10, 6, 11, 'sudah', 'bukti-pembayaran/atmB7iZRzCkcIvjwmqy4rlAZK7Wyh8mxfdHQiyzu.jpg', 'diterima', 10, '2024-05-24 02:02:12', '2024-05-27 01:38:59'),
(68, 70, 'IKHTIATUS SHOLIHAH', 'SUPIYAH', 'P', '082336600593', 'tia.sholihah.01@gmail.com', 'Bangkalan', '2006-02-01', 'Dsn. Modung Timur Desa Modung, Kec. Modung Kab. bangkalan', 'Indonesia', '3526164102060008', 2, 2, 11, 'SMA AL-KHATIBIYAH', 'SMA', 'IPA', '2024', '0063215326', 'Jl. Kh. Achmad Dahlan No. 374 Modung Bangkalan 69166', 11, 7, 9, 'sudah', 'bukti-pembayaran/Xs8Hm5go6g9ImbIGdeZCI59R1yuUmUuFMlL5fgJn.jpg', 'diterima', 11, '2024-05-24 13:14:14', '2024-05-27 01:42:36'),
(69, 71, 'SARAFAH ABADIYAH', 'Yuyun Naini', 'P', '085234366168', 'sarafahabadiyah176@gmail.com', 'Sumenep', '2006-02-16', 'Jl. Cempaka No 25, RT 005 RW 003, kel. Mlajah, Kec & Kab Bangkalan Provinsi Jawa Timur Kode Pos 69116', 'Indonesia', '3526015602060003', 2, 2, 7, 'SMAN 2 BANGKALAN', 'SMA', 'IPA', '2024', '0065233968', 'Jl. Soekarno Hatta No.18 Bangkalan', 10, 11, 6, 'sudah', 'bukti-pembayaran/JZkjKAiEuHdaOQuapmzXH1N6DQoPAkaRqPgRMoPO.jpg', 'diterima', 10, '2024-05-25 08:13:12', '2024-05-27 01:47:03'),
(71, 73, 'MAS\'UDI', 'SATIYAH', 'L', '082334580611', 'masudi441570@gmail.com', 'BANGKALAN', '2004-05-01', 'DSN. LAR-LAR DESA DUPOK KEC KOKOP KAB. BANGKALAN', 'INDONESIA', '3526100105040003', 2, 2, 14, 'SMA AN-NUR BULULAWANG', 'SMA', 'IPS', '2024', '0044700130', 'JL. RAYA BULULAWANG KEC. BULULAWANG 65171 KABUPATEN MALANG', 6, 5, 7, 'sudah', 'bukti-pembayaran/ILLlrMSicqMpRhjTjBanCxb3IM5ijPwreS8SYZaC.png', 'diterima', 6, '2024-05-27 09:05:52', '2024-05-28 01:32:34'),
(72, 74, 'AHMAD MUSLEH', 'SATI', 'L', '0856233721900', 'ahmadmuslehbinsai@gmail.com', 'Bangkalan', '1987-04-02', 'Dusun Nempapak Desa moarah Kec. Klampis', 'Indonesia', '3526070204870002', 3, 3, 15, 'UNIVERSITAS TERBUKA', 'UNIVERSITAS', 'PENDIDIKAN OLAH RAGA', '2008', '0', 'Kampus C Universitas Airlangga, Jl. Mulyorejo, Surabaya 60115', 9, 10, 11, 'sudah', 'bukti-pembayaran/kz1YFfyFcIa0VQ1OwuZpZNOblTX2IaQq8d2mLTf9.jpg', 'diterima', 9, '2024-05-28 04:02:07', '2024-05-28 06:59:09'),
(73, 75, 'ISTI QOMARIAH', 'Swati', 'P', '085955211016', 'caturgroupadvertisement@yahoo.com', 'bangkalan', '2005-07-28', 'Jl. Manggis kec. Teweh Tengah Kab. barito utara provinsi Kalimantan Tengah', 'Indonesia', '6205056807050005', 2, 2, 11, 'sma ar raudhah', 'sma', 'ipa', '2024', '0057312358', 'sebaneh bancaran', 11, 8, 7, 'sudah', 'bukti-pembayaran/twGOm8UGj3hWJBUghtKFPV7gL2ZLylJ9Jnzfgve2.jpg', 'diterima', 11, '2024-05-29 02:24:31', '2024-05-29 02:38:20'),
(74, 76, 'ABDEL HAQQ PAHLEVY', 'HERMI', 'L', '087857445951', 'uf09530@gmail.com', 'Bangkalan', '2005-01-16', 'DSN. BUNALAS AROSBAYA', 'Indonesia', '3526051601050001', 2, 2, 10, 'ASSALAFI ALFITHRAH', 'PONDOK PESANTREN', 'Lainnya', '2024', '0054505164', 'Jl. Kedinding Lor 99 Surabaya', 10, 11, 7, 'sudah', 'bukti-pembayaran/dU2N9eTEmZiNGiHFOePkfckdDHOqnhqDMjNhLZi0.jpg', 'diterima', 10, '2024-05-29 04:40:52', '2024-05-29 05:50:39'),
(75, 77, 'SYAIFUL BAHRI', 'SATUPAH', 'L', '082244654654', 'devilinu11@gmail.com', 'BANGKALAN', '1993-02-11', 'Jl pelabuhan  RT:004 / RW: 010 KEL.PANGERANAN KEC.BANGKALAN', 'INDONESIA', '3526011102930006', 3, 3, 15, 'SMA NEGERI 2 BANGKALAN', 'SMA', 'IPS', '2011', '8420', 'Jl. Soekarno Hatta 18 Bangkalan, Wr 04, Mlajah, Kec. Bangkalan', 6, 11, 7, 'sudah', 'bukti-pembayaran/JOyqer2jqNtgcctvbN8PykHDU7XtJSuue8pT21ZQ.jpg', 'diterima', 6, '2024-05-29 05:37:01', '2024-05-29 05:54:32'),
(76, 78, 'HAIRUL', 'HATIMAH', 'L', '087754755809', 'herulnisam682@gmail.com', 'SAMPANG,01 Januari 2005', '2005-01-01', 'DSN. PONGKEREP Sokobanah daya Sampang', 'Indonesia', '3527112101970005', 2, 2, 14, 'SMA AL-ARIFIN CANGAK', 'SMA', 'IPS', '2024', '0055283662', 'Jln. Raya Tamberu Barat Kec. Sokobanah Kab. Sampang', 5, 6, 9, 'belum', 'bukti-pembayaran/iWPHvr6EGr6nsPP5d8NJFZOJxvvsPUwlAA9aZxOP.jpg', 'tidak diterima', NULL, '2024-05-29 06:22:34', '2024-05-29 06:22:34');

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
(2, 'Luring (REGULER)', NULL, '2024-04-24 03:32:49'),
(3, 'Luring & Daring (RPL)', '2024-04-24 03:16:47', '2024-04-24 03:32:30');

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
  `name` varchar(255) NOT NULL DEFAULT '',
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
(4, 'admin1', 'admin1', NULL, '$2y$10$HAa4h8jXlA2tm3xgOm6HiO0q7ArsG2rUz4nTvCcgr1IWjrnOLYlOm', 'belum', 'admin', NULL, '2023-10-01 21:56:16', '2023-10-01 21:56:16'),
(10, 'TES', 'A@a.co', NULL, '$2y$10$qLd/5J6Yij0FfCAivaUoNOK7MTmePdfWXm/Teh66pA05jvDral9u6', 'sudah', 'camaba', NULL, '2024-04-02 04:52:35', '2024-04-02 04:54:03'),
(11, 'abc', 'A@c.co', NULL, '$2y$10$LAsM.RDu7/2xM6HdFJlUIuNNWbrL3SF9o3Z78kVjYqQhFOGig6Tze', 'belum', 'camaba', NULL, '2024-04-24 02:37:26', '2024-04-24 02:37:26'),
(12, 'jhgghf', 'pmb@gmail.com', NULL, '$2y$10$p2gV9cE.pxKHmXn5rcRYv.cjSs/cFChg/rx2mEfrh/icj7mcusfmK', 'belum', 'camaba', NULL, '2024-04-24 04:37:17', '2024-04-24 04:37:17'),
(13, 'jhgghf', 'auliabalqis220198@gmail.com', NULL, '$2y$10$ywvFNT2dFEzdDjk4qu2Qv.qLAOdS2HIWLiFT2SSypOhqsyd5NFMQy', 'belum', 'camaba', NULL, '2024-04-24 04:48:39', '2024-04-24 04:48:39'),
(14, 'JOYA NUR PRIYANTI GUNAWAN', 'joyanurp@gmail.com', NULL, '$2y$10$jX9SAkGqs7S7KTD6pt68I.Jcc3EGzZ3CXh0mkvXzWC227DRQfVLr6', 'belum', 'camaba', NULL, '2024-04-24 05:20:16', '2024-04-24 05:20:16'),
(15, 'jhgghf', 'auliabalqis344@gmail.com', NULL, '$2y$10$mjY8sUyUWl8ww3gAuxN/WOU3ybOJTguUefnHXWdSbTRBZuv2CKCbi', 'belum', 'camaba', NULL, '2024-04-26 07:08:45', '2024-04-26 07:08:45'),
(16, 'ALFIN MUBAROK', 'Alfinmubarokk2005@gmail.com', NULL, '$2y$10$/BEEwSGsYQaXNhVf.ktYOOUDLCPsGr/N17n2Az28hgiIfRRTfFOuO', 'belum', 'camaba', NULL, '2024-04-29 04:51:46', '2024-04-29 04:51:46'),
(17, 'HOIRUL ANAM', 'hoirulanam7656@gmail.com', NULL, '$2y$10$PbYQC9gEun9BnoVFq.71ZeDd0zvuTrsKJKj855j5BI4sjXiHFUH6u', 'belum', 'camaba', NULL, '2024-04-29 04:57:35', '2024-04-29 04:57:35'),
(18, 'SHUFHAN JAMIL', 'jamilbangkalan6@gmail.com', NULL, '$2y$10$fMlLHk762jlYgYuv/AhL6u6RAOxqiQpl.A5IWvZdKYkUNAeLSS952', 'belum', 'camaba', NULL, '2024-04-29 05:06:06', '2024-04-29 05:06:06'),
(19, 'RIZKY BAHTIAR', 'riskyfira51@gmail.com', NULL, '$2y$10$X3nuEG3ItaAZQxspexdVferK6hvhwerETXjGLYgGbcoCBxfImi/kG', 'belum', 'camaba', NULL, '2024-04-29 05:33:32', '2024-04-29 05:33:32'),
(20, 'MOH. HUSNIL MA\'ARIF', 'maarifjanuary6111@gmail.com', NULL, '$2y$10$oCvRJ/YZM7q3crUdSvMVYuHMw7CfpRJnXugWgJzGMJ78QPV/jtpi.', 'belum', 'camaba', NULL, '2024-04-29 05:42:00', '2024-04-29 05:42:00'),
(21, 'SITI ROFIAH', 'rofiaah31@gmail.com', NULL, '$2y$10$BIVFkPy2cQ3Meda0IaIa.OnuHu8eyYCQIFAVpZMljn.NsdR7z2UDK', 'belum', 'camaba', NULL, '2024-04-29 05:50:49', '2024-04-29 05:50:49'),
(22, 'Andika dwi anggara', 'andikadwia1@gmail.com', NULL, '$2y$10$SBMTkj7idlIsUstO66WQS.cCYEZ4sF7VUbKNYHkS0bP0KovgIB.Ma', 'belum', 'camaba', NULL, '2024-04-30 06:40:14', '2024-04-30 06:40:14'),
(23, 'Aynia Ramadani', 'slametriadi@gmail.com', NULL, '$2y$10$TBZ3Y1rKv27ZeAEbyXGRWu6rmEfr1Orfz1BMagp222oEjq1YcuMbW', 'belum', 'camaba', NULL, '2024-04-30 13:21:18', '2024-04-30 13:21:18'),
(24, 'Aynia Ramadani', 'ayniaramadani29@gmail.com', NULL, '$2y$10$u1LKMgZvMoxCDMP2AXgx7OaMgEtMDnWuBvFJSuuVAhEin5PiVrm3i', 'belum', 'camaba', NULL, '2024-04-30 13:50:24', '2024-04-30 13:50:24'),
(25, 'ROSUL MUHAMMAD DANI', 'rmuhdani2@gmail.com', NULL, '$2y$10$R4qxYc.xqHlxx7aEQpUDQOOZ.YAzY2ex48KwcwtdaEoV363/GTX3W', 'belum', 'camaba', NULL, '2024-05-03 06:40:29', '2024-05-03 06:40:29'),
(26, 'MIFTAHUL ANSHORI', 'miftahulanshoriii@gmail.com', NULL, '$2y$10$5qUEOBh59qLiAH/jcLE6gOSlRRQ/LKRWB7BLOqbsIRIfR.ukDA.pe', 'belum', 'camaba', NULL, '2024-05-03 06:48:41', '2024-05-03 06:48:41'),
(27, 'MOH. RAIHAN', 'reeihan19@gmail.com', NULL, '$2y$10$rdEMg46tm9NATxyFhbpwaeXZFpOzuRnammsqUUC5u34zVfIkLYyUu', 'belum', 'camaba', NULL, '2024-05-03 06:58:22', '2024-05-03 06:58:22'),
(28, 'SITI ALIYAH', 'salya2752@gmail.com', NULL, '$2y$10$0kiQXYzEgn9HaEg0lDe6uOtppBXVIxaBicaHngrQpEu22VEcfJQaK', 'belum', 'camaba', NULL, '2024-05-03 07:06:37', '2024-05-03 07:06:37'),
(29, 'MUHLIS', 'mukhlisfadil28@gmail.com', NULL, '$2y$10$kv5kkPU9BUsHaud1kNRTQeYQ9MAhRhP7HzXEb8drU0VACvneIjxem', 'belum', 'camaba', NULL, '2024-05-03 07:39:02', '2024-05-03 07:39:02'),
(30, 'SALIMATUS SAKDIYAH', 'salimatussakdiyah98@gmail.com', NULL, '$2y$10$LDEAoHijiX3yhoYfwLrvb.LnR7J0fjbGvNocoAjkFVhc7mN51h50a', 'belum', 'camaba', NULL, '2024-05-03 08:41:28', '2024-05-03 08:41:28'),
(31, 'LATIFATUL SOFIYAH', 'asadfhieas12345@gmail.com', NULL, '$2y$10$E2QzIlTyGOoh8HVeo76fVusQLrFYyG9YdKg/zPlR7gfggeDxq1Y/W', 'belum', 'camaba', NULL, '2024-05-06 01:55:19', '2024-05-06 01:55:19'),
(32, 'ABDUL MUIN', 'abdmuin041086@gmail.com', NULL, '$2y$10$5DnksRPvz0PRXnPHQy0Cxulqx4T7vo440RmgIfOB.IJ6xaCKtoRPq', 'belum', 'camaba', NULL, '2024-05-07 02:53:19', '2024-05-07 02:53:19'),
(33, 'Marsuli', 'suli.ajadech@gmail.com', NULL, '$2y$10$Mh7sTW57Bo6blfI2xCHereGxA2e9pQd512jHEc140xzRVqJ8GVWSe', 'belum', 'camaba', NULL, '2024-05-07 03:41:36', '2024-05-07 03:41:36'),
(34, 'MUHAMMAD MAMLU\'UL HIKAM', 'usaifuddin732@gmail.com', NULL, '$2y$10$KMR.i0y6v3vpfb613vQZl.6/9.ns5fCSjBmvugwC6QXag9EFKHKmO', 'belum', 'camaba', NULL, '2024-05-07 04:45:50', '2024-05-07 04:45:50'),
(35, 'AFIFATUN NISA\'', 'safinatulummah@gmail.com', NULL, '$2y$10$RScvV8aVdyslAVUZCbkFZ.hwupuIlAqr9j8k6Fn5e9XjG97e0DbIC', 'belum', 'camaba', NULL, '2024-05-07 04:56:51', '2024-05-07 04:56:51'),
(36, 'RINA SULIS TIANA', 'sitifadilah.sf5991@gmail.com', NULL, '$2y$10$Cza/KhGSjp/FC3O7dd08muCP.aEYHi/dhVsXB/6s5DEaObLVM7s52', 'belum', 'camaba', NULL, '2024-05-08 07:32:01', '2024-05-08 07:32:01'),
(37, 'ALIVIATUL MAHYU', 'aliviatulmahyu@gmail.com', NULL, '$2y$10$uvtKqrg2dggC2khHL9dObun6infzDPCwZBTiWfqVkPkZEZY3M8c1K', 'belum', 'camaba', NULL, '2024-05-08 07:42:11', '2024-05-08 07:42:11'),
(38, 'LAILA MASRUROH', 'lailamasruroh259@gmail.com', NULL, '$2y$10$XMsVlwrRzP..wqUkubOu..hrg9.8zSl5Yv/hHQaTohJDhUQl7ppmi', 'belum', 'camaba', NULL, '2024-05-08 08:49:36', '2024-05-08 08:49:36'),
(39, 'Siti Sholehah', 'sholehahs785@gmail.com', NULL, '$2y$10$hvPP4TbifPmDTLOHS5bbMemzksNbUTc6vNLjFW9dDyTco7GTrIve6', 'belum', 'camaba', NULL, '2024-05-08 10:48:54', '2024-05-08 10:48:54'),
(40, 'RUSTIANAWATI', 'rustianaismail@gmail.com', NULL, '$2y$10$4pt2TXzjnn1Gw2Ohv3v0yudk5UGggBm8aSfuCiFsTnZ0Fcs8vLb5G', 'belum', 'camaba', NULL, '2024-05-08 12:12:49', '2024-05-08 12:12:49'),
(41, 'RUSTIANAWATI', 'amishasholehah@gmail.com', NULL, '$2y$10$.FjC5MzxJE4hzFKWdAXZ1esyqMLL6.wu00ZX42K5QpCiZT8ExLBEG', 'belum', 'camaba', NULL, '2024-05-08 12:26:43', '2024-05-08 12:26:43'),
(42, 'NUR KHOLIS AKBAR', 'denakbar567@gmail.com', NULL, '$2y$10$6p4ZtA8Jn2GvEBsnrZDwLe4ssvtR7zo0/x1TUExHA9ARSZU185xLm', 'belum', 'camaba', NULL, '2024-05-08 15:34:20', '2024-05-08 15:34:20'),
(43, 'YESSIROH', 'yessisiroh@gmail.com', NULL, '$2y$10$.0RMQXm5rqe3cj1TWtt.9OaVx4BE8Sfu9eDgnhT5m8/opQdLLiTuC', 'belum', 'camaba', NULL, '2024-05-09 04:48:58', '2024-05-09 04:48:58'),
(44, 'RYAN YUZRIZAL ABDILLAH PRATAMA', 'syamsul.gunawan@trunojoyo.ac.id', NULL, '$2y$10$X1h/UoPCa4.HIPNHJi4X5e.th.uR6ldoYnDHlVUPpup5k3prSnRdS', 'belum', 'camaba', NULL, '2024-05-10 13:00:08', '2024-05-10 13:00:08'),
(45, 'Shofia.farohatul.jannah', 'shofiafj669@gmail.com', NULL, '$2y$10$zGzuxiQVTVsNW2RCMOxGNuCMhwHfAcne09fHQY.tm.qIomfM2sfRm', 'belum', 'camaba', NULL, '2024-05-12 02:49:41', '2024-05-12 02:49:41'),
(46, 'Dewi wulan safitri', 'safitriiwulan686@gmail.com', NULL, '$2y$10$DUVay.qp/vc4SEzpOPUOvuvGADjsGWwhfGDrBuqU1SMQLyso5SCgW', 'belum', 'camaba', NULL, '2024-05-13 03:47:21', '2024-05-13 03:47:21'),
(47, 'Dewi Wulan Safitri', 'dinasyafatul2539@gmail.com', NULL, '$2y$10$ojbDEwWZUxOZQ9c0vUoJyu638O5nPD7ChfyVxhgmYIOsh4MWIrBHm', 'belum', 'camaba', NULL, '2024-05-13 04:48:15', '2024-05-13 04:48:15'),
(48, 'Lia Kamaliah', 'liakamaliah2052@gmail.com', NULL, '$2y$10$yUruQ4.eclinRsoM/iAnFeNW9qVJ.xwzdgTKuRUOh2JncLo0WgKDO', 'belum', 'camaba', NULL, '2024-05-13 22:44:43', '2024-05-13 22:44:43'),
(49, 'AIDHATUL LAILA SULFITRIAH', 'vivijhuteks@gmail.com', NULL, '$2y$10$mPsr2nPf5ag4/pOKHR6ZLeKADYYqh8RpKpLp6xguMbr9LY2Lejuc2', 'belum', 'camaba', NULL, '2024-05-14 02:29:23', '2024-05-14 02:29:23'),
(50, 'SALDY HIDAYAT', 'saldyhidayat2005@gmail.com', NULL, '$2y$10$WsQYhmZFvlxGKmq0qAPiqefznu0twaIMASHzIA02nVTaDiL6LGCkq', 'belum', 'camaba', NULL, '2024-05-14 02:38:45', '2024-05-14 02:38:45'),
(51, 'AHMAD NAHRU ZAMZAMY', 'nahruzamzamy@gmail.com', NULL, '$2y$10$V6kNN38ADuPBjGdtrTQKHOo.agqJ7Qv9aKcYRIJYDVRf/J.UGvdqm', 'belum', 'camaba', NULL, '2024-05-14 09:43:12', '2024-05-14 09:43:12'),
(52, 'AHMAD NAHRU ZAMZAMY', 'zamzamynahru@gmail.com', NULL, '$2y$10$2JdYyOBGmNDBeDhPd30CCuZ33mLZhGniIhnMc.K1loZq//lqkxuBS', 'belum', 'camaba', NULL, '2024-05-14 10:17:39', '2024-05-14 10:17:39'),
(53, 'ARINDA CITRA ARYANI', 'arindacitra124@gmail.com', NULL, '$2y$10$O1DJsoAXo6ujrmp3oINqLONLpDciVroBD39.kZGuiXPbopn.jEe.a', 'belum', 'camaba', NULL, '2024-05-14 14:32:05', '2024-05-14 14:32:05'),
(54, 'HABIB RIZQI JAMAL', 'habibbriski460@gmail.com', NULL, '$2y$10$BI3jUUNBoC/jHCUN0muxM.mUoMNHY.tg0wHYIIZV767yUc1jBmgQi', 'belum', 'camaba', NULL, '2024-05-15 06:13:53', '2024-05-15 06:13:53'),
(55, 'Mahendra aditya abil', 'adityaabil122@gmail.com', NULL, '$2y$10$r/ehr1GB/tibn2hTdzx3BeBvf/ra7FYYKLTFLgCwTfQPer.JkBfuG', 'belum', 'camaba', NULL, '2024-05-16 02:20:48', '2024-05-16 02:20:48'),
(56, 'ISSETUL MUNAWWARAH', 'Issahmunawaroh@gmail.com', NULL, '$2y$10$Se6euzbyCchHIxzT2oUcI.2xewsPmLTrVuoOw1ASVCBb1l4u4JVcC', 'belum', 'camaba', NULL, '2024-05-16 02:34:32', '2024-05-16 02:34:32'),
(57, 'GAFID ROHMAN', 'rohmangafid@gmail.com', NULL, '$2y$10$R5Vq6BxGu4phnWo4iyWQ8OLW0mqETKlYst4pV7bwY6.UXjU.2yMKC', 'belum', 'camaba', NULL, '2024-05-16 04:02:47', '2024-05-16 04:02:47'),
(58, 'Ayu Nindyawati', 'nindyawatiayu27@gmail.com', NULL, '$2y$10$fgkcEge1nq/7tsw0xztPUekgpG9bL5.WocllIMAywraNSwTVFrpHu', 'belum', 'camaba', NULL, '2024-05-17 11:54:37', '2024-05-17 11:54:37'),
(59, 'Saiful', 'fexno01@gmail.com', NULL, '$2y$10$WlXGEV6XJcA5/E.7isfrL.zAfY6byMazek.EG7EONQCLQFlnM49ty', 'belum', 'camaba', NULL, '2024-05-18 03:53:04', '2024-05-18 03:53:04'),
(60, 'Sugianto Purnomo Mainaki', 'sugi29.5@gmail.com', NULL, '$2y$10$ThUDtGzgbBCOrXsJpS.eqehsBFwLHJS3bhxK8YS/vNWFJNI8.xT8e', 'belum', 'camaba', NULL, '2024-05-18 12:35:09', '2024-05-18 12:35:09'),
(61, 'RIZAL ARISANDI', 'risalarisandi.ra@gmail.com', NULL, '$2y$10$IHbkEoeH6f/RceBcuoNpROsKC2gZDNV5zVUJ.V9e.ImOMAX6B7KoO', 'belum', 'camaba', NULL, '2024-05-19 10:13:26', '2024-05-19 10:13:26'),
(62, 'DHURRIYATUS SHOLIHAH', 'dhurriatuslilik@gmail.com', NULL, '$2y$10$BWhrXPsmoR7s1mnwRVP.sezZ20/miVN1Ls6Ly6IGQrSl3rkEgl6y2', 'belum', 'camaba', NULL, '2024-05-21 01:30:41', '2024-05-21 01:30:41'),
(63, 'Rosik', 'rosikvern@gmail.com', NULL, '$2y$10$ZTenwAKy5fMJ5LGtnvbBeOltKLmGu7hHXPHZJ3IvlzZUa8ePk/EqO', 'belum', 'camaba', NULL, '2024-05-21 03:50:20', '2024-05-21 03:50:20'),
(64, 'MOH. FATHOR ROHMAN', 'zains.habibi2014@gmail.com', NULL, '$2y$10$Mb8ruuJVwPbVN73teTqGLuFaFAFH2sZ0mquFDYQ4RviSRQIjZ.eWO', 'belum', 'camaba', NULL, '2024-05-21 22:22:38', '2024-05-21 22:22:38'),
(65, 'Nova Yasmin Putri', 'novayasminputrii@gmail.com', NULL, '$2y$10$SSOIZOT/uZNkZzkgkRCxNuu8RdzZC9P39f7PcMNwy4uUNX62526wq', 'belum', 'camaba', NULL, '2024-05-22 03:33:01', '2024-05-22 03:33:01'),
(66, 'MOCH FAISAL', 'mochfaisal0186@gmail.com', NULL, '$2y$10$lOulRuDE8QerbW2/jJ47cOS9yutMQiJdjKSmqD7Lgcj1HoEk7pFn6', 'belum', 'camaba', NULL, '2024-05-22 07:26:01', '2024-05-22 07:26:01'),
(67, 'MOCH FAISAL', 'mohfaisal2968@gmail.com', NULL, '$2y$10$jEwU73uO33lE8MGCQS0JJOQwzkBFTSmq947IdcQjUD71IZq1f0vIG', 'belum', 'camaba', NULL, '2024-05-22 07:41:53', '2024-05-22 07:41:53'),
(68, 'KAYLA ANDINI ANSORI', 'akaylaandini@gmail.com', NULL, '$2y$10$S29958ySawILYEJetkgH.eNR6UYZCBxd6xDoE21wdgP7X4Enqw0Z.', 'belum', 'camaba', NULL, '2024-05-23 11:21:45', '2024-05-23 11:21:45'),
(69, 'THEO SYAPUTRA', 'syaputratheo98@gmail.com', NULL, '$2y$10$zhCYiOMQPQ9n9LqOe8LnY.z3.5DNZ49soeiND3qg3GAahCivuDz5S', 'belum', 'camaba', NULL, '2024-05-24 02:02:12', '2024-05-24 02:02:12'),
(70, 'IKHTIATUS SHOLIHAH', 'tia.sholihah.01@gmail.com', NULL, '$2y$10$L0Szct3j.lJrWZ5mgxhsiu7vIhcLc7ztDpBfOaLyAeuaLzQ3kOw9G', 'belum', 'camaba', NULL, '2024-05-24 13:14:14', '2024-05-24 13:14:14'),
(71, 'SARAFAH ABADIYAH', 'sarafahabadiyah176@gmail.com', NULL, '$2y$10$84/MB0PR4SFlOM2ciu/SfOXf.ORRBn5D8zPEtpUB6S1NKRGfD1Niy', 'belum', 'camaba', NULL, '2024-05-25 08:13:12', '2024-05-25 08:13:12'),
(72, 'SARAFAH ABADIYAH', 'divaratnaindah048@gmail.com', NULL, '$2y$10$t2OIH1Wckcn0AaFNfj5nH..GqA1.eoTt9tll3sMVvs0xYIM5K6p92', 'belum', 'camaba', NULL, '2024-05-25 10:19:59', '2024-05-25 10:19:59'),
(73, 'MAS\'UDI', 'masudi441570@gmail.com', NULL, '$2y$10$BKrzEy4OPzPxgiT3fUnXHeD37vkVnnRe7u.EkT8It9mYpAlpgoNEq', 'belum', 'camaba', NULL, '2024-05-27 09:05:52', '2024-05-27 09:05:52'),
(74, 'AHMAD MUSLEH', 'ahmadmuslehbinsai@gmail.com', NULL, '$2y$10$pLRtdieCGmeUTDYk0f8HZuXYHXNRrzVCpjp9gtiCoJUgMAJghu0mC', 'belum', 'camaba', NULL, '2024-05-28 04:02:07', '2024-05-28 04:02:07'),
(75, 'ISTI QOMARIAH', 'caturgroupadvertisement@yahoo.com', NULL, '$2y$10$vjJi2Ozyh5h0Xhj3ZEYrY.2i.3pigUNyfmaBquYxVDlssTfGTrTGa', 'belum', 'camaba', NULL, '2024-05-29 02:24:31', '2024-05-29 02:24:31'),
(76, 'ABDEL HAQQ PAHLEVY', 'uf09530@gmail.com', NULL, '$2y$10$dF0hHpOLdX76DpNB/BA8/.h82.X//UWo9RiFYe7vM7d6P650OLwr2', 'belum', 'camaba', NULL, '2024-05-29 04:40:52', '2024-05-29 04:40:52'),
(77, 'SYAIFUL BAHRI', 'devilinu11@gmail.com', NULL, '$2y$10$xVt.51F9m639mUxVdT9NLuQt6Y2jvX3ThosSb6cS/u58YzwDB38F6', 'belum', 'camaba', NULL, '2024-05-29 05:37:01', '2024-05-29 05:37:01'),
(78, 'HAIRUL', 'herulnisam682@gmail.com', NULL, '$2y$10$alW5/cOqKS6d6eIoEIhSSuZs8fvrJwGIelHI0bsTD6L1OPt7s/OBa', 'belum', 'camaba', NULL, '2024-05-29 06:22:34', '2024-05-29 06:22:34');

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `berkas_pendaftars`
--
ALTER TABLE `berkas_pendaftars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `informasis`
--
ALTER TABLE `informasis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `informasi_kampuses`
--
ALTER TABLE `informasi_kampuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jalur_masuks`
--
ALTER TABLE `jalur_masuks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `jenjang_pendidikans`
--
ALTER TABLE `jenjang_pendidikans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `registers`
--
ALTER TABLE `registers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `sistem_kuliahs`
--
ALTER TABLE `sistem_kuliahs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sosmeds`
--
ALTER TABLE `sosmeds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

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
