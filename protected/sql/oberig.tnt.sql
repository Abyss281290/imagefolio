-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Мар 21 2012 г., 10:58
-- Версия сервера: 5.5.16
-- Версия PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `oberig.tnt`
--

-- --------------------------------------------------------

--
-- Структура таблицы `models_requests`
--

CREATE TABLE IF NOT EXISTS `models_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agency_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `type_id` int(11) NOT NULL,
  `type2_id` int(11) NOT NULL,
  `type_values` text NOT NULL,
  `type2_values` text NOT NULL,
  `birthday` date NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `telephone2` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `about` text NOT NULL,
  `image_head_shot` varchar(255) NOT NULL,
  `image_mid_length` varchar(255) NOT NULL,
  `image_full_length` varchar(255) NOT NULL,
  `created_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `agency_id` (`agency_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Дамп данных таблицы `models_requests`
--

INSERT INTO `models_requests` (`id`, `agency_id`, `name`, `email`, `type_id`, `type2_id`, `type_values`, `type2_values`, `birthday`, `telephone`, `telephone2`, `address`, `about`, `image_head_shot`, `image_mid_length`, `image_full_length`, `created_time`) VALUES
(9, 4, '123', 'sleepw@ukr.net', 3, 3, '', '', '2012-03-29', '3', '3', '3', '3', '1332286546_image_head_shot.jpg', '1332286467_image_mid_length.jpg', '1332286468_image_full_length.jpg', '1970-01-01 03:00:00'),
(10, 4, '123', 'sleepw@ukr.net', 312, 3, '', '', '2012-03-07', '312', '31231', '231', '2312', '1332313825_image_head_shot.jpg', '1332313826_image_mid_length.jpg', '1332313826_image_full_length.jpg', '1970-01-01 03:00:00'),
(11, 3, '123xa', 'sleepw@ukr.net', 32, 3, '', '', '2012-03-08', '312', '3', '3', '3', '1332313940_image_head_shot.jpg', '1332313940_image_mid_length.jpg', '1332313941_image_full_length.jpg', '1970-01-01 03:00:00'),
(12, 3, 'xxxx', 'sleepw@ukr.net', 123, 3, '', '', '2012-03-21', '3', '3', '3', '3', '1332313978_image_head_shot.jpg', '1332313978_image_mid_length.jpg', '1332313979_image_full_length.jpg', '1970-01-01 03:00:00'),
(13, 4, '123', 'sleepw@ukr.net2', 3, 2, 'a:3:{i:1;s:3:"123";i:2;s:78:"\r\n<p>About HTML <span class="required">*222333333333333333333333333</span></p>";i:3;s:1:"3";}', 'a:1:{i:6;s:31:"text field test *44444444444444";}', '2012-03-27', '123', '3', '3', '3', '1332314256_image_head_shot.jpg', '1332314257_image_mid_length.jpg', '1332314258_image_full_length.jpg', '1970-01-01 03:00:00'),
(15, 1, '222222Andrew Matveenko', 'sleepw@ukr.net', 3, 2, 'a:3:{i:1;s:3:"231";i:2;s:61:"\r\n<p><span style="font-weight: bold;">123123131cdd</span></p>";i:3;s:1:"4";}', 'a:1:{i:6;s:2:"12";}', '2012-03-28', '32', '3', '3', '3', '1332318998_image_head_shot.jpg', '1332318998_image_mid_length.jpg', '1332318999_image_full_length.jpg', '1970-01-01 03:00:00');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `models_requests`
--
ALTER TABLE `models_requests`
  ADD CONSTRAINT `models_requests_ibfk_1` FOREIGN KEY (`agency_id`) REFERENCES `agencies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
