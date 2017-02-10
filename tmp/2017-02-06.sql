-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- 생성 시간: 17-02-10 18:36
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
-- 테이블 구조 `meta`
--

CREATE TABLE `meta` (
  `idx` int(10) UNSIGNED NOT NULL,
  `model` varchar(32) NOT NULL DEFAULT '',
  `model_idx` int(10) UNSIGNED NOT NULL,
  `code` varchar(64) NOT NULL DEFAULT '',
  `data` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `meta`
--

INSERT INTO `meta` (`idx`, `model`, `model_idx`, `code`, `data`) VALUES
(1, 'user', 99, '', ''),
(2, 'user', 100, '', ''),
(3, 'user', 101, '', ''),
(4, 'user', 102, '', ''),
(5, 'user', 104, 'type', 'T'),
(6, 'user', 104, 'classid', 'my-skype-id'),
(7, 'user', 105, 'type', 'T'),
(8, 'user', 105, 'classid', 'my-skype-id'),
(9, 'user', 106, 'type', 'T'),
(10, 'user', 106, 'classid', 'my-skype-id'),
(11, 'user', 107, 'type', 'T'),
(12, 'user', 107, 'classid', 'my-skype-id'),
(13, 'user', 109, 'type', 'T'),
(14, 'user', 109, 'classid', 'my-skype-id'),
(15, 'user', 0, 'abc', ''),
(16, 'user', 109, 'abc', ''),
(17, 'user', 109, 'abc', '1234'),
(18, 'user', 110, 'type', 'T'),
(19, 'user', 110, 'classid', 'my-skype-id');

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
  `country` varchar(64) NOT NULL DEFAULT '',
  `province` varchar(128) NOT NULL DEFAULT '',
  `city` varchar(128) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `zipcode` varchar(32) NOT NULL DEFAULT '',
  `stamp_registration` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `stamp_last_login` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `session_id` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `user`
--

INSERT INTO `user` (`idx`, `id`, `password`, `name`, `nickname`, `email`, `mobile`, `landline`, `gender`, `birthday`, `country`, `province`, `city`, `address`, `zipcode`, `stamp_registration`, `stamp_last_login`, `session_id`) VALUES
(1, 'user1', 'pass1', '', '', 'email4@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, '1-cf20905c24016e997201545904a1c342'),
(2, 'user2', '', '', '', 'email2@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, ''),
(7, 'user3', '', '', '', 'email2@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, ''),
(8, 'user4', '', '', '', 'email2@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, ''),
(9, 'user5', '', '', '', 'email2@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, ''),
(10, ':id', '', ':name', ':nickname', ':email', '', '', '', 0, '', '', '', '', '', 0, 0, ''),
(30, ':user8', '', ':jaeho', ':J', ':email2@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, ''),
(31, 'user8', '', 'jaeho', 'J', 'email2@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, ''),
(35, 'user9', '', 'jaeho', 'J', 'email2@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, ''),
(37, '`user9`', '', '`jaeho`', '`J`', '`email2@gmail`.`com`', '', '', '', 0, '', '', '', '', '', 0, 0, ''),
(40, '`user10`', '', '`jaeho`', '`J`', '`email2@gmail`.`com`', '', '', '', 0, '', '', '', '', '', 0, 0, ''),
(41, '`user11`', '', '`jaeho`', '`J`', '`email2@gmail`.`com`', '', '', '', 0, '', '', '', '', '', 0, 0, ''),
(44, 'user11', '', 'jaeho', 'Nick', 'email2@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, ''),
(45, 'user14', '', '', '', 'email2@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, ''),
(53, 'user15', '', '', '', 'email2@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, ''),
(71, 'user16', '', '', '', 'email2@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, ''),
(73, 'u1', '', '', '', 'email2@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, '-dcb717ab3b05d80a45f312fe2344079f'),
(75, 'u2', '', '', '', 'email2@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, '75-1d769dd4791423ceb4243c9e70c9afac'),
(77, 'u3', '', '', '', 'email2@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, '77-21d0981e9844f4b0e71bacc028c3156f'),
(81, 'u4', '', 'myname', '', 'email4@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, '81-521c950280895f32fe39ed146630d161'),
(82, 'xxxx', 'fb0e22c79ac75679e9881e6ba183b354', 'myname', '', '', '', '', '', 0, '', '', '', '', '', 0, 0, '82-0c33cdf010102c582d18a51a4e0ef3f2'),
(84, 'u15', '81dc9bdb52d04dc20036dbd8313ed055', 'myN', '', '', '', '', '', 0, '', '', '', '', '', 0, 0, ''),
(85, 'test-1486712110', '7713fb3a5d0cfdc2c1d5ba4edb45b1a3', 'test-1486712110', 'undefined', 'test-1486712110@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, '85-91e2a81a06710e35f7bb0ffe120f34d9'),
(86, 'test-1486712142', '6d43baaee2f13f748a3601e66e0b3e02', 'test-1486712142', 'undefined', 'test-1486712142@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, '86-f795fcf02ee5c6428c71c61561d4f319'),
(87, 'test-1486712177', '600691f8d9719779a2e0d00e678f9894', 'test-1486712177', 'undefined', 'test-1486712177@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, '87-97ca282a52952b516df9859f0712c897'),
(88, 'test-1486712182', '965c4a2fd17d7f41a734594a6ee1291c', 'test-1486712182', 'undefined', 'test-1486712182@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, '88-f0c0331167b3bb438a5d6149b9182ee1'),
(89, 'test-1486712187', 'c26dbc8f89c969df4e0cb2ccc0403d6a', 'test-1486712187', 'undefined', 'test-1486712187@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, '89-ccb4b36c8abe5f32edd1d8712c35cb04'),
(90, 'test-1486712261', 'f17d0d2d89543d8cdec867f39b950011', 'test-1486712261', 'undefined', 'test-1486712261@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, '90-2f5476c641743892b49dfcf74ce0044d'),
(91, 'test-1486712268', 'd99d13617af25d7e75c5244f3832de16', 'test-1486712268', 'undefined', 'test-1486712268@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, '91-13e918ccbc451096300db5f941426477'),
(92, 'test-1486712273', '05cdca08773ec13976f130c255976668', 'test-1486712273', 'undefined', 'test-1486712273@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, '92-8cb2228a542d78614bd7e97a0f2ebc57'),
(93, 'test-1486712288', '3706fe29bb7f7fd769ae0abfc54c72b2', 'test-1486712288', 'undefined', 'test-1486712288@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, '93-f2e2729c514ca7393a2e637ba2091ef2'),
(94, 'test-1486712315', '78dd737d0d90d22f2086034e2eb8649f', 'test-1486712315', 'undefined', 'test-1486712315@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, '94-04b754f49212492e8e0b9ac74e29daab'),
(95, 'test-1486712331', '5078f563fad4bff7648ad1645653d006', 'test-1486712331', 'undefined', 'test-1486712331@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, '95-96d92875e7c4e74524c0d4c4f574a7e6'),
(97, 'test-1486713753', '229fd71ab8120a495bb857ca6c89ab86', 'test-1486713753', 'undefined', 'test-1486713753@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, '97-338a08b97f67b1bd0a13651fa6fc06c7'),
(98, 'test-1486713790', '035b51e5380c9cf7a193cad499811cce', 'test-1486713790', 'undefined', 'test-1486713790@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, '98-0474f55cf4bdb00edc2f50528ff924b6'),
(99, 'test-1486714933', 'a2d9b79588922ab80506723c330760e2', 'test-1486714933', 'undefined', 'test-1486714933@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, '99-40be2b92dea2d5340d303d874970f416'),
(100, 'test-1486715087', '1d8159a7e66f0c070378a64833929d83', 'test-1486715087', 'undefined', 'test-1486715087@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, '100-a4c03f3a76dfc4f02eb9e686e885003b'),
(101, 'test-1486715103', 'ba196b0efb4f9ff473b64094b27fbff8', 'test-1486715103', 'undefined', 'test-1486715103@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, '101-5c5fcbf11b9bf8fb8d4de99c88035e70'),
(102, 'test-1486715123', '97e3573bb51091adc43491aeb9b19570', 'test-1486715123', 'undefined', 'test-1486715123@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, '102-f3b0bd99192f888eefa04ced2dd00ca6'),
(104, 'test-1486715247', 'e3d6ca520029ed0a7c3cee3858a07ed8', 'test-1486715247', 'undefined', 'test-1486715247@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, '104-900386859af2ae97d2e293ae31924b7d'),
(105, 'test-1486715258', '86ebeba8f61a7fd975d0d7521d1f12c9', 'test-1486715258', 'undefined', 'test-1486715258@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, '105-186c02af1e7fe360afdb843fdb96cd4e'),
(106, 'test-1486715294', '2a95546a41f6c023db2d352121104c03', 'test-1486715294', 'undefined', 'test-1486715294@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, '106-61f6e9b83cfe41792605769d057a68cd'),
(107, 'test-1486715337', 'd4eef11f093c28b3570499b31d4b8db1', 'test-1486715337', 'undefined', 'test-1486715337@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, '107-ee500d8bd9070ab119ba816d435321f4'),
(109, 'test-1486716427', 'cb51a06647c437d2fe5ecf771bf7bf4d', 'test-1486716427', 'undefined', 'test-1486716427@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, '109-821aca27b85169bfd3d33e4d02cc97d5'),
(110, 'test-1486717447', '3486f142b374015dd5af5444cd95d23c', 'test-1486717447', 'undefined', 'test-1486717447@gmail.com', '', '', '', 0, '', '', '', '', '', 0, 0, '110-e3c9341272bfc2bad6adf8aa55214064');

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `meta`
--
ALTER TABLE `meta`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `model` (`model`,`model_idx`,`code`);

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
-- 테이블의 AUTO_INCREMENT `meta`
--
ALTER TABLE `meta`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- 테이블의 AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
