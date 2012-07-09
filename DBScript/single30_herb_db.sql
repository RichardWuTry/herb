-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 07 月 09 日 11:16
-- 服务器版本: 5.5.8
-- PHP 版本: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `single30_herb_db`
--

-- --------------------------------------------------------

--
-- 表的结构 `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(20) NOT NULL,
  `surname` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `create_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `create_by` varchar(40) NOT NULL,
  `modify_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modify_by` varchar(40) NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `customer`
--

INSERT INTO `customer` (`customer_id`, `firstname`, `surname`, `phone`, `email`, `is_active`, `create_at`, `create_by`, `modify_at`, `modify_by`) VALUES
(2, 'Eric123', 'Chen1', '123456', '', 1, '2012-07-01 09:39:11', 'Richard', '2012-07-07 22:00:00', 'Richard'),
(3, 'Brian', 'Bao', '2345678', 'Bao@test.com', 0, '2012-07-01 22:20:02', 'Richard', '2012-07-03 21:29:25', 'Richard'),
(4, 'Brian', 'Bao', '123456', 'Brian@163.com', 1, '2012-07-07 22:38:14', 'Richard', '2012-07-07 22:38:14', 'Richard');

-- --------------------------------------------------------

--
-- 表的结构 `recipe`
--

CREATE TABLE IF NOT EXISTS `recipe` (
  `recipe_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `contents` varchar(1000) NOT NULL,
  `is_issued` tinyint(1) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `issue_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `issue_by` varchar(40) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `create_by` varchar(40) NOT NULL,
  `modify_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modify_by` varchar(40) NOT NULL,
  PRIMARY KEY (`recipe_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `recipe`
--

INSERT INTO `recipe` (`recipe_id`, `customer_id`, `contents`, `is_issued`, `is_active`, `issue_at`, `issue_by`, `create_at`, `create_by`, `modify_at`, `modify_by`) VALUES
(2, 2, 'Issued by: [Richard]  on: [07/07/2012]\n---------------------------------------\n\nabc def\nThank You\nTest Save', 1, 1, '2012-07-07 17:30:25', 'Richard', '2012-07-06 22:07:56', 'Richard', '2012-07-07 17:30:25', 'Richard'),
(3, 2, 'Issued by: [Richard]  on: [06/07/2012]\r\n---------------------------------------\r\n\r\nLet''s issue this recipe.', 1, 0, '2012-07-06 10:11:46', 'Richard', '2012-07-06 22:11:46', 'Richard', '2012-07-07 21:47:48', 'Richard'),
(4, 2, 'Issued by: [Richard]  on: [07/07/2012]\r\n---------------------------------------\r\n\r\nTest Issue', 1, 1, '2012-07-07 04:11:42', 'Richard', '2012-07-07 16:11:42', 'Richard', '2012-07-07 16:11:42', 'Richard'),
(5, 2, 'Issued by: [Richard]  on: [08/07/2012]\n---------------------------------------\n\nGreat\n<\n>%&*', 1, 1, '2012-07-08 09:02:03', 'Richard', '2012-07-07 22:23:40', 'Richard', '2012-07-08 09:02:03', 'Richard'),
(6, 4, 'Issued by: [Richard]  on: [07/07/2012]\r\n---------------------------------------\r\n\r\nFirst Recipe', 1, 1, '2012-07-07 10:42:34', 'Richard', '2012-07-07 22:42:34', 'Richard', '2012-07-07 22:42:34', 'Richard');

-- --------------------------------------------------------

--
-- 表的结构 `recipe_comment`
--

CREATE TABLE IF NOT EXISTS `recipe_comment` (
  `recipe_comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `recipe_id` int(11) NOT NULL,
  `comment` varchar(1000) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `create_by` varchar(40) NOT NULL,
  `modify_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modify_by` varchar(40) NOT NULL,
  PRIMARY KEY (`recipe_comment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `recipe_comment`
--

INSERT INTO `recipe_comment` (`recipe_comment_id`, `recipe_id`, `comment`, `create_at`, `create_by`, `modify_at`, `modify_by`) VALUES
(7, 2, 'add\nupdate\nupdate again\n111 222 333 444 555', '2012-07-07 17:28:20', 'Richard', '2012-07-07 17:34:10', 'Richard'),
(8, 3, 'asfds', '2012-07-07 22:36:47', 'Richard', '2012-07-07 22:36:47', 'Richard');

-- --------------------------------------------------------

--
-- 表的结构 `staff`
--

CREATE TABLE IF NOT EXISTS `staff` (
  `staff_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_name` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`staff_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `staff`
--

INSERT INTO `staff` (`staff_id`, `staff_name`, `password`, `is_active`) VALUES
(1, 'Richard', '123456', 1);
