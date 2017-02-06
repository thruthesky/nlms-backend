-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- 생성 시간: 17-02-06 18:59
-- 서버 버전: 10.1.21-MariaDB
-- PHP 버전: 5.6.27

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
  `domain` varchar(128) NOT NULL DEFAULT '',
  `id` varchar(128) DEFAULT NULL,
  `password` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(128) NOT NULL DEFAULT '',
  `nickname` varchar(128) NOT NULL DEFAULT '',
  `email` varchar(128) NOT NULL DEFAULT '',
  `mobile` varchar(128) NOT NULL DEFAULT '',
  `landline` varchar(128) NOT NULL DEFAULT '',
  `gender` char(1) NOT NULL DEFAULT '',
  `birthday` int(11) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `type` char(1) NOT NULL DEFAULT '',
  `point` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `stamp_registration` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `stamp_last_login` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `user`
--

INSERT INTO `user` (`idx`, `domain`, `id`, `password`, `name`, `nickname`, `email`, `mobile`, `landline`, `gender`, `birthday`, `comment`, `type`, `point`, `stamp_registration`, `stamp_last_login`) VALUES
(1, '', 'user1', 'pass1', '', '', 'email1', '', '', '', 0, '', '', 0, 0, 0),
(2, '', 'user2', '', '', '', 'email2@gmail.com', '', '', '', 0, '', '', 0, 0, 0),
(7, '', 'user3', '', '', '', 'email2@gmail.com', '', '', '', 0, '', '', 0, 0, 0);

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
  ADD KEY `point` (`point`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
