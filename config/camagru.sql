-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Июл 10 2017 г., 00:06
-- Версия сервера: 10.1.21-MariaDB
-- Версия PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Удаление старой базы данных
--

DROP DATABASE IF EXISTS `camagru`;

--
-- База данных: `camagru`
--
CREATE DATABASE IF NOT EXISTS `camagru` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `camagru`;

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `cid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`cid`, `pid`, `uid`, `text`) VALUES
(1, 49, 22, 'adsfasdfasdfasdfasdf'),
(2, 49, 19, 'atexas privet '),
(3, 49, 19, 'dsfgsdfg'),
(4, 78, 22, 'sdf'),
(5, 78, 22, '%3Cscript%3Ealert(\'dfgsdfg\');%3C/script%3E'),
(6, 78, 22, '&lt;script&gt;alert(\'asdf\');&lt;/script&gt;'),
(7, 78, 22, 'safasdf'),
(8, 78, 22, 'safasdf'),
(9, 78, 22, 'safasdf'),
(10, 78, 22, 'safasdf'),
(11, 78, 22, 'safasdf'),
(12, 78, 22, 'safasdf'),
(13, 78, 22, 'safasdf'),
(14, 78, 22, 'safasdf'),
(15, 78, 22, 'safasdf'),
(16, 78, 22, 'safasdf'),
(17, 78, 22, 'safasdf'),
(18, 78, 22, 'safasdf'),
(19, 78, 22, 'safasdf'),
(20, 78, 22, 'safasdf'),
(21, 78, 22, 'dfasdf'),
(22, 78, 22, 'adf'),
(23, 78, 22, 'asdf'),
(24, 78, 22, '1245'),
(25, 77, 22, 'Ñ€ÑƒÑ€Ñƒ'),
(26, 76, 22, 'fgs'),
(27, 76, 22, 'sdfg'),
(28, 76, 22, '123'),
(29, 76, 22, '4'),
(30, 76, 22, '5'),
(31, 78, 22, 'ÐµÐµÐµ'),
(32, 78, 23, 'hello'),
(33, 68, 23, 'what is going on there?'),
(34, 78, 22, 'hello'),
(35, 64, 23, 'U CAN\'T SEE ME MY TIME IS NOW'),
(36, 55, 23, 'zzz...'),
(37, 49, 23, 'so many photos wow'),
(38, 56, 23, 'high five'),
(39, 53, 23, 'zzz... [2]'),
(40, 80, 23, 'it\'s my soul'),
(41, 80, 22, 'nice'),
(43, 80, 23, 'I know'),
(44, 78, 22, 'lol'),
(45, 78, 22, '&lt;script&gt;alert(&quot;hello&quot;);&lt;/script&gt;'),
(49, 111, 23, 'Was ist das?'),
(50, 101, 23, 'So sweet'),
(51, 99, 23, 'Chicken god?'),
(52, 115, 23, 'Why so serious?'),
(53, 87, 23, 'Don\'t break your neck!!1!1!'),
(54, 111, 22, 'eskimo callboy album cover'),
(55, 116, 23, 'So fat'),
(56, 99, 22, 'chics gold'),
(57, 111, 23, 'Baba so-so kanesh'),
(58, 103, 23, 'nice comments'),
(59, 129, 22, 'axaxax'),
(62, 131, 22, '#like_for_like'),
(64, 131, 23, 'thanx'),
(65, 130, 23, 'nice'),
(69, 140, 23, 'nooooooo...'),
(70, 141, 23, 'after long day working on project'),
(71, 141, 23, '/imaginary friends/'),
(74, 141, 22, 'Hehe'),
(76, 138, 22, 'sdf'),
(77, 141, 22, 'comment from smartfone');

-- --------------------------------------------------------

--
-- Структура таблицы `likes`
--

CREATE TABLE `likes` (
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `cid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `likes`
--

INSERT INTO `likes` (`uid`, `pid`, `cid`) VALUES
(23, 78, 0),
(22, 49, 0),
(23, 80, 0),
(22, 80, 0),
(22, 77, 0),
(22, 78, 0),
(22, 101, 0),
(22, 103, 0),
(22, 100, 0),
(22, 125, 0),
(23, 98, 0),
(22, 127, 0),
(22, 129, 0),
(22, 131, 0),
(22, 132, 0),
(23, 129, 0),
(23, 130, 0),
(23, 115, 0),
(23, 137, 0),
(22, 138, 0),
(23, 141, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `photos`
--

CREATE TABLE `photos` (
  `pid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `path` varchar(256) COLLATE utf8_bin NOT NULL,
  `caption` text COLLATE utf8_bin NOT NULL,
  `likes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `photos`
--

INSERT INTO `photos` (`pid`, `uid`, `path`, `caption`, `likes`) VALUES
(49, 22, '/user_data/view/5960bb17ad336.png', 'here comments', 0),
(50, 22, '/user_data/view/5960bb18271e1.png', 'Unnamed', 0),
(51, 22, '/user_data/view/5960bb18658e5.png', 'Unnamed', 0),
(52, 22, '/user_data/view/5960bb18d4f23.png', 'Unnamed', 0),
(53, 22, '/user_data/view/5960bb1941f39.png', 'Unnamed', 0),
(54, 22, '/user_data/view/5960bb19bc569.png', 'Unnamed', 0),
(55, 22, '/user_data/view/5960bb1a339fc.png', 'Unnamed', 0),
(56, 22, '/user_data/view/5960bb1e50d35.png', 'Unnamed', 0),
(57, 22, '/user_data/view/5960bb1e97697.png', 'Unnamed', 0),
(58, 22, '/user_data/view/5960bb1ef23ca.png', 'Unnamed', 0),
(59, 22, '/user_data/view/5960bb1f246ad.png', 'Unnamed', 0),
(60, 22, '/user_data/view/5960bb1f85207.png', 'Unnamed', 0),
(61, 22, '/user_data/view/5960bb1faf6ab.png', 'Unnamed', 0),
(62, 22, '/user_data/view/5960bb2007847.png', 'Unnamed', 0),
(63, 22, '/user_data/view/5960bb202d4cf.png', 'Unnamed', 0),
(64, 22, '/user_data/view/5960bb208d761.png', 'Unnamed', 0),
(65, 22, '/user_data/view/5960bb20b5180.png', 'Unnamed', 0),
(66, 22, '/user_data/view/5960bb2116172.png', 'Unnamed', 0),
(67, 22, '/user_data/view/5960bb213ee47.png', 'Unnamed', 0),
(68, 22, '/user_data/view/5960bb2198621.png', 'Unnamed', 0),
(70, 22, '/user_data/view/5960bb222aafb.png', 'Unnamed', 0),
(71, 22, '/user_data/view/5960bb22509ca.png', 'Unnamed', 0),
(72, 22, '/user_data/view/5960bb22be7f2.png', 'Unnamed', 0),
(73, 22, '/user_data/view/5960bb22e830f.png', 'Unnamed', 0),
(75, 22, '/user_data/view/5960bb235faa5.png', 'Unnamed', 0),
(76, 22, '/user_data/view/5960bb2393f50.png', 'Unnamed', 0),
(77, 22, '/user_data/view/5960bb509b294.png', 'top photo', 0),
(78, 22, '/user_data/view/5960e6ef302e4.png', '&lt;script&gt;alert(&quot;hello&quot;);&lt;/script&gt;', 0),
(80, 23, '/user_data/view/596135882dfc5.png', 'Unnamed', 0),
(87, 22, '/user_data/view/59614fcee33aa.png', 'Unnamed', 0),
(96, 22, '/user_data/view/5961f502486df.png', 'Unnamed', 0),
(97, 22, '/user_data/view/5961f5387d070.png', 'Peppa', 0),
(98, 22, '/user_data/view/5961f5c5ab520.png', 'Parrot', 0),
(99, 22, '/user_data/view/5961f66dd65ce.png', 'Unnamed', 0),
(100, 22, '/user_data/view/5961f6a29da43.png', 'picture', 0),
(101, 22, '/user_data/view/5961f6e23f606.png', 'Unnamed', 0),
(103, 22, '/user_data/view/5962061762ae7.png', 'Unnamed', 0),
(109, 22, '/user_data/view/5962205d0c3e9.png', 'booooring', 0),
(111, 22, '/user_data/view/596238b92ebbc.png', 'Unnamed', 0),
(113, 22, '/user_data/view/59623abb55091.png', 'Unnamed', 0),
(114, 22, '/user_data/view/59623ad0b346e.png', 'Unnamed', 0),
(115, 22, '/user_data/view/59623b671a119.png', 'Unnamed', 0),
(116, 22, '/user_data/view/5962491d3bb47.png', 'Unnamed', 0),
(122, 22, '/user_data/view/59626b867b34a.png', 'Unnamed', 0),
(123, 22, '/user_data/view/59626c09e5850.png', 'Unnamed', 0),
(124, 22, '/user_data/view/59626c5fc8a1e.png', 'Unnamed', 0),
(127, 23, '/user_data/view/59626e712b689.png', 'Hot tatooed girl', 0),
(128, 22, '/user_data/view/596270e93f47d.png', 'Unnamed', 0),
(129, 23, '/user_data/view/5962714ad38c3.png', 'THE CREATOR!', 0),
(130, 23, '/user_data/view/596271764bff1.png', 'Hot tattooed girl again', 0),
(131, 23, '/user_data/view/596271d854e8a.png', 'My new haircut', 0),
(132, 23, '/user_data/view/59627204c50bd.png', 'Beautiful morning', 0),
(133, 23, '/user_data/view/596272295cf2d.png', 'Beautiful evening', 0),
(136, 22, '/user_data/view/596289c237538.png', 'Unnamed', 0),
(137, 22, '/user_data/view/59629096b557e.png', 'Unnamed', 0),
(138, 23, '/user_data/view/596292816de89.png', 'Unnamed', 0),
(140, 22, '/user_data/view/5962967f51105.png', 'Unnamed', 0),
(141, 22, '/user_data/view/596297fbe4d6c.png', 'peppa', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `login` varchar(64) COLLATE utf8_bin NOT NULL,
  `mail` varchar(128) COLLATE utf8_bin NOT NULL,
  `pass` varchar(256) COLLATE utf8_bin NOT NULL,
  `active` int(11) NOT NULL,
  `token` varchar(256) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`uid`, `login`, `mail`, `pass`, `active`, `token`) VALUES
(19, 'asff', 'sdfa@asdf', 'd88b750a503c2110df3db65cccc4ee049ca0a5688cee36f9bdee88dfe537ef2c', 1, '48463e46c30f1d64f15ad67a4337fbf7b2d25a7fbd79db9271cf478b6149de35'),
(22, 'test', 'a@a.gd', 'a3a9161c4bd3946d8a197dd7ca92be87df510a942e3cbef746b68203620089c3', 1, '03eb9031a88f84c87047ac69d3ac9b619d5ec8fa2ce7e7a5d06824cee352f7ed'),
(23, 'the_first_one', 'g@g.com', '92ac43845b7432f6eebfe29b51b896bca761e35c2d60160cc8de34d3917b93af', 1, '9989777bac2fc60f76e448c434aee3056825d5f48c872ff9c96eda356e26ca49'),
(24, 'adf', 'test@activation', '37087595a807b034fa5ae96fac588af274eb059cdee035ff66d9fecef53bbae1', 0, '7a0aad7ea6f99c621a3037eeffcb3f9f1a3a384e15875a248a9c155314612afc');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`cid`);

--
-- Индексы таблицы `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`pid`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;
--
-- AUTO_INCREMENT для таблицы `photos`
--
ALTER TABLE `photos`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
