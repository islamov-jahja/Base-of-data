-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 04 2018 г., 22:46
-- Версия сервера: 5.7.19
-- Версия PHP: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `project_cinema`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cinema`
--

DROP TABLE IF EXISTS `cinema`;
CREATE TABLE IF NOT EXISTS `cinema` (
  `id_cinema` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `adress` varchar(255) DEFAULT NULL,
  `id_city` int(11) NOT NULL,
  PRIMARY KEY (`id_cinema`),
  KEY `cinema_ibfk_1` (`id_city`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cinema`
--

INSERT INTO `cinema` (`id_cinema`, `name`, `adress`, `id_city`) VALUES
(1, 'Октябрь', 'Ул. Кремлевская 21', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `city`
--

DROP TABLE IF EXISTS `city`;
CREATE TABLE IF NOT EXISTS `city` (
  `id_city` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id_city`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `city`
--

INSERT INTO `city` (`id_city`, `name`) VALUES
(4, 'Йошкар-Ола'),
(5, 'Чебоксары'),
(6, 'Казань'),
(7, 'Рязань'),
(8, 'Новгород'),
(14, 'Петрозаводск'),
(15, 'Красноярск'),
(18, 'Санкт-Петербург'),
(19, 'Воронеж'),
(20, 'Уфа');

-- --------------------------------------------------------

--
-- Структура таблицы `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id_client` int(11) NOT NULL AUTO_INCREMENT,
  `is_client` tinyint(1) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `client`
--

INSERT INTO `client` (`id_client`, `is_client`, `name`, `surname`, `phone_number`, `date_of_birth`, `login`, `password`) VALUES
(17, 0, 'Яхья', 'Исламов', '+79278812515', '1998-09-15', 'yahya111', '$2y$10$F7eEGd5RnN.YtPK0xiA/s..oWwhgB86N.GStp.8Zx/Kbfifk1WgMC'),
(18, 1, 'Павел', 'Якушев', '+79278812515', '1998-08-07', 'pasha111', '$2y$10$RpRePGGufrglDNJl2Bn/WuEtYp9x95DDlhzndpBqU4ZlVK6O6emKu'),
(19, 1, 'Федя', 'Рыбаков', '+79278812515', '1998-06-25', 'fedya111', '$2y$10$XHCengr.cWS7g/GM0TP2NuS.ji3zrJjAooP0It0YZt0f1RdQyOVAK'),
(20, 1, 'Александр', 'Савельев', '+79278812515', '2005-08-31', 'savel_111', '$2y$10$Wbf3vEcosO61CFkAFlinwuRNaMiCn/IHgLJZWSACJjMU0T7ulpLe6'),
(21, 1, 'Антон', 'Гайдуков', '+79278812515', '1998-02-18', 'antonio', '$2y$10$wFe/AdLoKjgwul47ZSBpb.2HXnV7/JfS2cm33V5pKdvVKz1sj9XxO'),
(22, 0, 'Зоба', 'Иванов', '+79278812515', '2007-07-07', 'zoba111', '$2y$10$J2wvieNl0iJDQ4fXPXdKqetcfldobH2fzcWzO1k0pzQ5j/ub3cqom'),
(23, 1, 'Эльвин', 'Байрамов', '+79278812515', '2007-07-21', 'elvin123', '$2y$10$0NOBWeztGZRaXxNenQxw4.lp43jSOjz3vtl0wmwCwxCyVlID6reLy');

-- --------------------------------------------------------

--
-- Структура таблицы `event`
--

DROP TABLE IF EXISTS `event`;
CREATE TABLE IF NOT EXISTS `event` (
  `id_event` int(11) NOT NULL AUTO_INCREMENT,
  `id_session` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `event_date` datetime NOT NULL,
  PRIMARY KEY (`id_event`),
  KEY `id_client` (`id_client`),
  KEY `id_session` (`id_session`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `film`
--

DROP TABLE IF EXISTS `film`;
CREATE TABLE IF NOT EXISTS `film` (
  `id_film` int(11) NOT NULL AUTO_INCREMENT,
  `release_date` date NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_film`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `film`
--

INSERT INTO `film` (`id_film`, `release_date`, `name`, `description`, `image`) VALUES
(9, '2018-10-04', 'Веном', 'Ве́ном — американский фильм 2018 года режиссёра Рубена Флейшера с Томом Харди в главной роли. Сценарий Скотта Розенберга, Джеффа Пинкнера и Келли Марсел основан на комиксах издательства Marvel Comics о персонаже Эдди Броке. Является первой картиной в рамках вселенной Marvel от Sony.', '../templates/image/01c485f3-1ce3-43fe-9453-39adeb2bfa90.jpg'),
(10, '2018-02-22', 'Черная пантера', 'С первого взгляда можно решить, что Ваканда — обычная территория дикой Африки, но это не так. Здесь, в недрах пустынных земель, скрываются залежи уникального металла, способного поглощать вибрацию. Многие пытались добраться до него, разоряя всё на своём пути и принося смерть аборигенам, но каждый раз таинственный дух саванны — Чёрная Пантера — вставал на защиту угнетённых.', '../templates/image/756cc483-d1cb-4441-897c-b6fcf007b93f.jpg'),
(11, '2018-05-17', 'Дэдпул 2', 'Единственный и неповторимый болтливый наемник — вернулся! Ещё более масштабный, ещё более разрушительный и даже ещё более голозадый, чем прежде! Когда в его жизнь врывается суперсолдат с убийственной миссией, Дэдпул вынужден задуматься о дружбе, семье и о том, что на самом деле значит быть героем, попутно надирая 50 оттенков задниц. Потому что иногда чтобы делать хорошие вещи, нужно использовать грязные приёмчики.', '../templates/image/images.jpg'),
(12, '2018-06-05', 'Человек-Муравей и Оса', 'Скотт Лэнг, известный также, как Человек-Муравей уже заслужил право оказаться в команде Мстителей, но желание быть ближе к собственной дочке удерживает его в родном Сан-Франциско — до тех пор, пока доктор Хэнк Пим, создавший когда-то изменяющий размеры своего владельца чудо-костюм, не призывает Скотта присоединиться к новой, опасной миссии. А помогать в противостоянии с коварным врагом Человеку-Муравью будет новая напарница — Оса.', '../templates/image/images (1).jpg'),
(13, '2018-04-20', 'Непрощённый', '«Непрощённый» — российский драматический фильм режиссёра Сарика Андреасяна об авиакатастрофе над Боденским озером. Главную роль сыграл Дмитрий Нагиев. Премьера фильма в России состоялась 27 сентября 2018 года.', NULL),
(14, '2018-07-26', 'Миссия невыполнима: Последствия', 'Итан Хант и его команда, а также недавно примкнувшие к ним союзники, вынуждены действовать наперегонки со временем, когда новая миссия идет не по плану.', '../templates/image/miss.jpg'),
(15, '2018-10-04', 'Звезда родилась', '«Звезда родилась» — американский фильм-мюзикл 2018 года, режиссёрский дебют Брэдли Купера, ремейк одноимённого фильма 1937 года. В главных ролях снялись Брэдли Купер, Сэм Эллиотт и Леди Гага.', '../templates/image/im2.jpg'),
(16, '2018-06-07', 'Мир юрского периода 2', 'Основатели парка Юрского периода решают восстановить его работу, пренебрегая действующим вулканом, который находится в центре острова. Огнедышащий исполин пробуждается и грозит утопить всё в лаве. Клэр Дэринг вынуждена снова обратиться за помощью к дрессировщику Оуэну Грэди, чтобы спасти животных от верной смерти.', '../templates/image/mir_ur_per.jpg'),
(17, '2011-10-07', 'Живая сталь', 'События фильма происходят в будущем, где бокс запрещен за негуманностью и заменен боями 2000-фунтовых роботов, управляемых людьми. Бывший боксер, а теперь промоутер, переметнувшийся в Робобокс, решает, что наконец нашел своего чемпиона, когда ему попадается выбракованный, но очень способный робот. Одновременно на жизненном пути героя возникает 11-летний пацан, оказывающийся его сыном. И по мере того, как машина пробивает свой путь к вершине, обретшие друг друга отец и сын учатся дружить.', '../templates/image/Real_Steel1.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `genre`
--

DROP TABLE IF EXISTS `genre`;
CREATE TABLE IF NOT EXISTS `genre` (
  `id_genre` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id_genre`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `genre`
--

INSERT INTO `genre` (`id_genre`, `name`) VALUES
(1, 'Боевик'),
(2, 'Вестерн'),
(3, 'Дедектив'),
(5, 'Комедия'),
(7, 'Ужасы'),
(8, 'Триллеры'),
(9, 'Фантастика');

-- --------------------------------------------------------

--
-- Структура таблицы `genre_in_film`
--

DROP TABLE IF EXISTS `genre_in_film`;
CREATE TABLE IF NOT EXISTS `genre_in_film` (
  `id_genre_in_film` int(11) NOT NULL AUTO_INCREMENT,
  `id_genre` int(11) NOT NULL,
  `id_film` int(11) NOT NULL,
  PRIMARY KEY (`id_genre_in_film`),
  KEY `genre_in_film_ibfk_1` (`id_genre`),
  KEY `genre_in_film_ibfk_2` (`id_film`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `genre_in_film`
--

INSERT INTO `genre_in_film` (`id_genre_in_film`, `id_genre`, `id_film`) VALUES
(14, 7, 9),
(15, 8, 9),
(16, 1, 9),
(17, 9, 10),
(18, 1, 10),
(19, 8, 10),
(20, 9, 11),
(21, 1, 11),
(22, 9, 12),
(23, 5, 12),
(24, 1, 12),
(26, 9, 13),
(27, 1, 13),
(28, 1, 14),
(30, 2, 14),
(33, 3, 15),
(34, 1, 16),
(35, 9, 16),
(36, 8, 16),
(37, 1, 17),
(38, 2, 17),
(39, 9, 17),
(40, 8, 17);

-- --------------------------------------------------------

--
-- Структура таблицы `hall`
--

DROP TABLE IF EXISTS `hall`;
CREATE TABLE IF NOT EXISTS `hall` (
  `id_hall` int(11) NOT NULL AUTO_INCREMENT,
  `number_of_hall` int(10) UNSIGNED NOT NULL,
  `id_cinema` int(11) NOT NULL,
  `amount_of_place` int(11) NOT NULL,
  PRIMARY KEY (`id_hall`),
  KEY `hall_ibfk_1` (`id_cinema`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `session`
--

DROP TABLE IF EXISTS `session`;
CREATE TABLE IF NOT EXISTS `session` (
  `id_session` int(11) NOT NULL AUTO_INCREMENT,
  `id_film` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `age_limit` tinyint(4) NOT NULL,
  `id_hall` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id_session`),
  KEY `session_ibfk_1` (`id_film`),
  KEY `session_ibfk_2` (`id_hall`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cinema`
--
ALTER TABLE `cinema`
  ADD CONSTRAINT `cinema_ibfk_1` FOREIGN KEY (`id_city`) REFERENCES `city` (`id_city`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_ibfk_2` FOREIGN KEY (`id_session`) REFERENCES `session` (`id_session`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `genre_in_film`
--
ALTER TABLE `genre_in_film`
  ADD CONSTRAINT `genre_in_film_ibfk_1` FOREIGN KEY (`id_genre`) REFERENCES `genre` (`id_genre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `genre_in_film_ibfk_2` FOREIGN KEY (`id_film`) REFERENCES `film` (`id_film`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `hall`
--
ALTER TABLE `hall`
  ADD CONSTRAINT `hall_ibfk_1` FOREIGN KEY (`id_cinema`) REFERENCES `cinema` (`id_cinema`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `session`
--
ALTER TABLE `session`
  ADD CONSTRAINT `session_ibfk_1` FOREIGN KEY (`id_film`) REFERENCES `film` (`id_film`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `session_ibfk_2` FOREIGN KEY (`id_hall`) REFERENCES `hall` (`id_hall`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
