-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost
-- 生成日時: 2024 年 7 月 09 日 15:42
-- サーバのバージョン： 10.4.28-MariaDB
-- PHP のバージョン: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `gs_board`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `kadai10_user_table`
--

CREATE TABLE `kadai10_user_table` (
  `id` int(12) NOT NULL,
  `lid` varchar(50) NOT NULL,
  `username` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `kanri_flg` int(1) NOT NULL,
  `life_flg` int(1) NOT NULL,
  `indate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `kadai10_user_table`
--

INSERT INTO `kadai10_user_table` (`id`, `lid`, `username`, `email`, `password`, `kanri_flg`, `life_flg`, `indate`) VALUES
(19, 'test1', 'てすと', 'test@test.com', '$2y$10$X7yEci6lqjz5xmt0mwc6B.SNqXx0o4EMoXJh6tvdAcwLNQdVLRSVy', 0, 1, '2024-07-09 06:00:15'),
(21, 'admin1', 'テスト１管理者', 'admin@test.com', '$2y$10$Uu9Rj9X4vgIijauYtQw3UuNtpuLqdaNONhEllEMwNM1y7nAE6pX/K', 1, 1, '2024-07-09 06:00:15');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `kadai10_user_table`
--
ALTER TABLE `kadai10_user_table`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `kadai10_user_table`
--
ALTER TABLE `kadai10_user_table`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
