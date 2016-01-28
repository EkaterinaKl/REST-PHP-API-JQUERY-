SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `katalog` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `katalog`;


CREATE TABLE IF NOT EXISTS `building` (
  `id_b` int(11) NOT NULL AUTO_INCREMENT,
  `adress` varchar(255) NOT NULL,
  `x` double NOT NULL,
  `y` double NOT NULL,
  PRIMARY KEY (`id_b`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

INSERT INTO `building` (`id_b`, `adress`, `x`, `y`) VALUES
(1, 'Дарасунская, 15', 5, 10),
(2, 'Дальневосточная, 10', 3, 5),
(3, 'Дальневосточная, 6', 2, 22),
(4, 'Даурская, 8Б', 22, 2),
(5, 'Дачная, 8/2', 1, 5),
(6, 'Дарасунская, 4', 7, 6),
(7, 'Дачная, 8/1', 7, 77),
(8, 'Даурская, 2', 4, 5);

CREATE TABLE IF NOT EXISTS `catalog` (
  `id_ca` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `id_parent` int(11) NOT NULL,
  `id_right_key` int(11) NOT NULL,
  `id_left_key` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY (`id_ca`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

INSERT INTO `catalog` (`id_ca`, `name`, `id_parent`, `id_right_key`, `id_left_key`, `level`) VALUES
(1, 'Все категории', 0, 20, 1, 0),
(2, 'Еда\r\n', 1, 7, 2, 1),
(3, 'Автомобили', 1, 17, 8, 1),
(4, 'Спорт', 1, 19, 18, 1),
(5, 'Полуфабрикаты оптом', 2, 4, 3, 2),
(6, 'Мясная продукция', 2, 6, 5, 2),
(7, 'Легковые', 3, 14, 9, 2),
(8, 'Грузовые\r\n', 3, 16, 15, 2),
(9, 'Шины/Диски', 7, 13, 12, 3),
(10, 'Запчасти для подвески', 7, 11, 10, 3);

CREATE TABLE IF NOT EXISTS `catalog_company` (
  `id_ca` int(11) NOT NULL,
  `id_c` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `catalog_company` (`id_ca`, `id_c`) VALUES
(1, 1),
(1, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(4, 7),
(10, 7),
(9, 7),
(8, 4),
(2, 1);

CREATE TABLE IF NOT EXISTS `company` (
  `id_c` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `id_b` int(11) NOT NULL,
  PRIMARY KEY (`id_c`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

INSERT INTO `company` (`id_c`, `name`, `id_b`) VALUES
(1, 'ООО Ретейл Гранд Систем', 1),
(2, 'ООО &quot;ЮрЭкспо&quot;', 2),
(3, 'ООО &quot;Системы управления&quot;', 6),
(4, 'ООО ДизельТехКомплект', 5),
(5, 'ООО &quot;Рога и копыта&quot;', 2),
(6, 'ООО AOS', 4),
(7, 'ООО &quot;Спецтехника Китая&quot;', 5);

CREATE TABLE IF NOT EXISTS `company_phone` (
  `id_ph` int(11) NOT NULL,
  `id_c` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `company_phone` (`id_ph`, `id_c`) VALUES
(9, 1),
(2, 3),
(3, 4),
(4, 7),
(5, 5),
(6, 6),
(7, 6),
(8, 7);

CREATE TABLE IF NOT EXISTS `phone` (
  `id_ph` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(15) NOT NULL,
  PRIMARY KEY (`id_ph`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

INSERT INTO `phone` (`id_ph`, `name`) VALUES
(2, '8-35-24-84'),
(3, '8-35-24-83'),
(4, '35-24-44'),
(5, '8-926-123-45-44'),
(6, '8-926-123-45-77'),
(7, '8-914-123-45-65'),
(8, '8-924-123-45-88'),
(9, '3-333-333');



ALTER TABLE `building`
  ADD PRIMARY KEY (`id_b`);

ALTER TABLE `catalog`
  ADD PRIMARY KEY (`id_ca`);

ALTER TABLE `company`
  ADD PRIMARY KEY (`id_c`);

ALTER TABLE `phone`
  ADD PRIMARY KEY (`id_ph`);


ALTER TABLE `building`
  MODIFY `id_b` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
ALTER TABLE `catalog`
  MODIFY `id_ca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
ALTER TABLE `company`
  MODIFY `id_c` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
ALTER TABLE `phone`
  MODIFY `id_ph` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


/*
ALTER TABLE `company`
  ADD CONSTRAINT `fk_company_building` FOREIGN KEY (`id_c`) REFERENCES `building` (`id_b`)
  ON DELETE CASCADE
    ON UPDATE CASCADE;
	*/

  