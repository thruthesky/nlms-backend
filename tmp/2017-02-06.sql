-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- 생성 시간: 17-02-08 17:53
-- 서버 버전: 10.1.21-MariaDB
-- PHP 버전: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `nlms`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `user`
--

CREATE TABLE `user` (
  `idx` int(10) UNSIGNED NOT NULL,
  `id` varchar(128) DEFAULT NULL,
  `password` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(128) NOT NULL DEFAULT '',
  `nickname` varchar(128) NOT NULL DEFAULT '',
  `email` varchar(128) NOT NULL DEFAULT '',
  `mobile` varchar(128) NOT NULL DEFAULT '',
  `landline` varchar(128) NOT NULL DEFAULT '',
  `gender` char(1) NOT NULL DEFAULT '',
  `birthday` int(11) NOT NULL DEFAULT '0',
  `stamp_registration` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `stamp_last_login` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `session_id` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `user`
--

INSERT INTO `user` (`idx`, `id`, `password`, `name`, `nickname`, `email`, `mobile`, `landline`, `gender`, `birthday`, `stamp_registration`, `stamp_last_login`, `session_id`) VALUES
(1, 'user1', 'pass1', '', '', 'email4@gmail.com', '', '', '', 0, 0, 0, '1-cf20905c24016e997201545904a1c342'),
(2, 'user2', '', '', '', 'email2@gmail.com', '', '', '', 0, 0, 0, ''),
(7, 'user3', '', '', '', 'email2@gmail.com', '', '', '', 0, 0, 0, ''),
(8, 'user4', '', '', '', 'email2@gmail.com', '', '', '', 0, 0, 0, ''),
(9, 'user5', '', '', '', 'email2@gmail.com', '', '', '', 0, 0, 0, ''),
(10, ':id', '', ':name', ':nickname', ':email', '', '', '', 0, 0, 0, ''),
(30, ':user8', '', ':jaeho', ':J', ':email2@gmail.com', '', '', '', 0, 0, 0, ''),
(31, 'user8', '', 'jaeho', 'J', 'email2@gmail.com', '', '', '', 0, 0, 0, ''),
(35, 'user9', '', 'jaeho', 'J', 'email2@gmail.com', '', '', '', 0, 0, 0, ''),
(37, '`user9`', '', '`jaeho`', '`J`', '`email2@gmail`.`com`', '', '', '', 0, 0, 0, ''),
(40, '`user10`', '', '`jaeho`', '`J`', '`email2@gmail`.`com`', '', '', '', 0, 0, 0, ''),
(41, '`user11`', '', '`jaeho`', '`J`', '`email2@gmail`.`com`', '', '', '', 0, 0, 0, ''),
(44, 'user11', '', 'jaeho', 'Nick', 'email2@gmail.com', '', '', '', 0, 0, 0, ''),
(45, 'user14', '', '', '', 'email2@gmail.com', '', '', '', 0, 0, 0, ''),
(53, 'user15', '', '', '', 'email2@gmail.com', '', '', '', 0, 0, 0, ''),
(71, 'user16', '', '', '', 'email2@gmail.com', '', '', '', 0, 0, 0, ''),
(73, 'u1', '', '', '', 'email2@gmail.com', '', '', '', 0, 0, 0, '-dcb717ab3b05d80a45f312fe2344079f'),
(75, 'u2', '', '', '', 'email2@gmail.com', '', '', '', 0, 0, 0, '75-1d769dd4791423ceb4243c9e70c9afac'),
(77, 'u3', '', '', '', 'email2@gmail.com', '', '', '', 0, 0, 0, '77-21d0981e9844f4b0e71bacc028c3156f'),
(81, 'u4', '', 'myname', '', 'email4@gmail.com', '', '', '', 0, 0, 0, '81-521c950280895f32fe39ed146630d161');

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idx`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `nickname` (`nickname`),
  ADD KEY `email` (`email`),
  ADD KEY `stamp_registration` (`stamp_registration`),
  ADD KEY `stamp_last_login` (`stamp_last_login`),
  ADD KEY `session_id` (`session_id`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
