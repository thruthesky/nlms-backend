CREATE TABLE `meta` (
  `idx` int(10) UNSIGNED NOT NULL,
  `model` varchar(32) NOT NULL DEFAULT '',
  `model_idx` int(10) UNSIGNED NOT NULL,
  `code` varchar(64) NOT NULL DEFAULT '',
  `data` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



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

