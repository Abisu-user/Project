-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2024-08-06 16:27:38
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `ibeacon`
--

-- --------------------------------------------------------

--
-- 資料表結構 `member_data`
--

CREATE TABLE `member_data` (
  `actor` varchar(5) NOT NULL COMMENT '職位',
  `account` varchar(10) NOT NULL COMMENT '帳號',
  `name` varchar(20) NOT NULL COMMENT '名稱',
  `sex` enum('M','F','O') NOT NULL COMMENT '性別',
  `gmail` varchar(50) NOT NULL COMMENT '電子郵箱',
  `phone` int(10) NOT NULL COMMENT '電話',
  `address` varchar(100) NOT NULL COMMENT '地址',
  `birthday` date NOT NULL COMMENT '生日',
  `password` varchar(255) NOT NULL COMMENT '密碼'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `member_data`
--

INSERT INTO `member_data` (`actor`, `account`, `name`, `sex`, `gmail`, `phone`, `address`, `birthday`, `password`) VALUES
('管理員', 'Admin', 'Abisu', 'M', 'Abisu@gmail.com', 1234567890, '台中市太平區', '2024-08-06', '$2y$10$JpnC6LA9bpDfeIVIzu4Sqex5XrIq7Gwij0y7tY1nZj5ZS5QnLgBYK');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `member_data`
--
ALTER TABLE `member_data`
  ADD PRIMARY KEY (`account`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
