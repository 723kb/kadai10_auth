-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost
-- 生成日時: 2024 年 7 月 11 日 15:25
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
-- テーブルの構造 `kadai10_msg_table`
--

CREATE TABLE `kadai10_msg_table` (
  `id` int(12) NOT NULL,
  `name` varchar(64) NOT NULL,
  `message` varchar(140) NOT NULL,
  `date` datetime NOT NULL,
  `picture` mediumblob DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `picture_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `kadai10_msg_table`
--

INSERT INTO `kadai10_msg_table` (`id`, `name`, `message`, `date`, `picture`, `updated_at`, `picture_path`) VALUES
(32, 'てすと', 'ほげ', '2024-07-09 15:32:21', NULL, NULL, NULL),
(33, 'てすと', 'ほげ２', '2024-07-09 15:32:25', NULL, NULL, NULL),
(68, 'テスト１管理者', 'てすと', '2024-07-11 15:10:52', NULL, '2024-07-11 06:11:02', 'img/upload/48d74769827adfde24a4d8551f431670.png');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `kadai10_msg_table`
--
ALTER TABLE `kadai10_msg_table`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `kadai10_msg_table`
--
ALTER TABLE `kadai10_msg_table`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
