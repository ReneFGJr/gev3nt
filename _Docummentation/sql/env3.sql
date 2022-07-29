-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 28-Jul-2022 às 17:11
-- Versão do servidor: 5.7.36
-- versão do PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `gev3env`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id_e` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `e_name` char(200) NOT NULL,
  `e_data_i` date NOT NULL,
  `e_data_f` date NOT NULL,
  `e_status` int(11) NOT NULL,
  `e_texto` text NOT NULL,
  `e_data` date NOT NULL,
  `e_ass_none_1` char(100) NOT NULL,
  `e_ass_cargo_1` char(100) NOT NULL,
  `e_ass_none_2` char(100) NOT NULL,
  `e_ass_cargo_2` char(100) NOT NULL,
  `e_ass_none_3` char(100) NOT NULL,
  `e_ass_cargo_3` char(100) NOT NULL,
  `e_cidade` char(50) NOT NULL,
  `e_ass_img` char(100) NOT NULL,
  `e_background` char(100) NOT NULL,
  `e_templat` int(11) NOT NULL DEFAULT '1',
  `e_location` text,
  UNIQUE KEY `id_e` (`id_e`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `events`
--

INSERT INTO `events` (`id_e`, `e_name`, `e_data_i`, `e_data_f`, `e_status`, `e_texto`, `e_data`, `e_ass_none_1`, `e_ass_cargo_1`, `e_ass_none_2`, `e_ass_cargo_2`, `e_ass_none_3`, `e_ass_cargo_3`, `e_cidade`, `e_ass_img`, `e_background`, `e_templat`, `e_location`) VALUES
(1, '8º EBBC - Ouvinte', '2022-07-20', '2022-07-22', 1, 'Declaro, para os devidos fins, que <b>$nome</b> participou do 8º Encontro Brasileiro de Bibliometria e Cientometria na qualidade de ouvinte. O evento ocorreu entre os dias 20 e 22 de julho de 2022, no Centro de Inovação de Jaraguá, na cidade de Maceió, AL, totalizando vinte e três horas e meia de evento.', '2022-07-25', '', '', '', '', '', '', 'Maceió, AL', '', 'img/certificado/cert_ebbc8.jpg', 5, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `events_inscritos`
--

DROP TABLE IF EXISTS `events_inscritos`;
CREATE TABLE IF NOT EXISTS `events_inscritos` (
  `id_i` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `i_evento` int(11) NOT NULL,
  `i_date_in` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `i_user` int(11) NOT NULL,
  `i_status` int(11) NOT NULL,
  `i_date_out` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `i_certificado` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `i_titulo_trabalho` text NOT NULL,
  `i_autores` text NOT NULL,
  UNIQUE KEY `id_i` (`id_i`)
) ENGINE=MyISAM AUTO_INCREMENT=98 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `events_inscritos`
--

INSERT INTO `events_inscritos` (`id_i`, `i_evento`, `i_date_in`, `i_user`, `i_status`, `i_date_out`, `i_certificado`, `i_titulo_trabalho`, `i_autores`) VALUES
(1, 1, '2022-07-28 15:34:45', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(2, 1, '2022-07-28 15:34:45', 2, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(3, 1, '2022-07-28 15:34:45', 3, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(4, 1, '2022-07-28 15:34:45', 4, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(5, 1, '2022-07-28 15:34:45', 5, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(6, 1, '2022-07-28 15:34:45', 6, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(7, 1, '2022-07-28 15:34:45', 7, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(8, 1, '2022-07-28 15:34:45', 8, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(9, 1, '2022-07-28 15:34:45', 9, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(10, 1, '2022-07-28 15:34:45', 10, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(11, 1, '2022-07-28 15:34:45', 11, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(12, 1, '2022-07-28 15:34:45', 12, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(13, 1, '2022-07-28 15:34:45', 13, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(14, 1, '2022-07-28 15:34:45', 14, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(15, 1, '2022-07-28 15:34:45', 15, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(16, 1, '2022-07-28 15:34:45', 16, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(17, 1, '2022-07-28 15:34:45', 17, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(18, 1, '2022-07-28 15:34:45', 18, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(19, 1, '2022-07-28 15:34:45', 19, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(20, 1, '2022-07-28 15:34:45', 20, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(21, 1, '2022-07-28 15:34:45', 21, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(22, 1, '2022-07-28 15:34:45', 22, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(23, 1, '2022-07-28 15:34:45', 23, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(24, 1, '2022-07-28 15:34:45', 24, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(25, 1, '2022-07-28 15:34:45', 25, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(26, 1, '2022-07-28 15:34:45', 26, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(27, 1, '2022-07-28 15:34:45', 27, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(28, 1, '2022-07-28 15:34:45', 28, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(29, 1, '2022-07-28 15:34:45', 29, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(30, 1, '2022-07-28 15:34:45', 30, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(31, 1, '2022-07-28 15:34:45', 31, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(32, 1, '2022-07-28 15:34:45', 32, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(33, 1, '2022-07-28 15:34:45', 33, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(34, 1, '2022-07-28 15:34:45', 34, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(35, 1, '2022-07-28 15:34:45', 35, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(36, 1, '2022-07-28 15:34:45', 36, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(37, 1, '2022-07-28 15:34:45', 37, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(38, 1, '2022-07-28 15:34:45', 38, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(39, 1, '2022-07-28 15:34:45', 39, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(40, 1, '2022-07-28 15:34:45', 40, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(41, 1, '2022-07-28 15:34:45', 41, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(42, 1, '2022-07-28 15:34:45', 42, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(43, 1, '2022-07-28 15:34:45', 43, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(44, 1, '2022-07-28 15:34:45', 44, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(45, 1, '2022-07-28 15:34:45', 45, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(46, 1, '2022-07-28 15:34:45', 46, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(47, 1, '2022-07-28 15:34:45', 47, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(48, 1, '2022-07-28 15:34:45', 48, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(49, 1, '2022-07-28 15:34:45', 49, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(50, 1, '2022-07-28 15:34:45', 50, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(51, 1, '2022-07-28 15:34:45', 51, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(52, 1, '2022-07-28 15:34:45', 52, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(53, 1, '2022-07-28 15:34:45', 53, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(54, 1, '2022-07-28 15:34:45', 54, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(55, 1, '2022-07-28 15:34:45', 55, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(56, 1, '2022-07-28 15:34:45', 56, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(57, 1, '2022-07-28 15:34:45', 57, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(58, 1, '2022-07-28 15:34:45', 58, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(59, 1, '2022-07-28 15:34:45', 59, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(60, 1, '2022-07-28 15:34:45', 60, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(61, 1, '2022-07-28 15:34:45', 61, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(62, 1, '2022-07-28 15:34:45', 62, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(63, 1, '2022-07-28 15:34:45', 63, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(64, 1, '2022-07-28 15:34:45', 64, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(65, 1, '2022-07-28 15:34:45', 65, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(66, 1, '2022-07-28 15:34:45', 66, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(67, 1, '2022-07-28 15:34:45', 67, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(68, 1, '2022-07-28 15:34:45', 68, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(69, 1, '2022-07-28 15:34:45', 69, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(70, 1, '2022-07-28 15:34:45', 70, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(71, 1, '2022-07-28 15:34:45', 71, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(72, 1, '2022-07-28 15:34:45', 72, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(73, 1, '2022-07-28 15:34:45', 73, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(74, 1, '2022-07-28 15:34:45', 74, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(75, 1, '2022-07-28 15:34:45', 75, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(76, 1, '2022-07-28 15:34:45', 76, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(77, 1, '2022-07-28 15:34:45', 77, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(78, 1, '2022-07-28 15:34:45', 78, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(79, 1, '2022-07-28 15:34:45', 79, 1, '0000-00-00 00:00:00', '2022-07-28 15:35:21', '', ''),
(80, 1, '2022-07-28 15:34:45', 80, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(81, 1, '2022-07-28 15:34:45', 81, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(82, 1, '2022-07-28 15:34:45', 82, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(83, 1, '2022-07-28 15:34:45', 83, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(84, 1, '2022-07-28 15:34:45', 84, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(85, 1, '2022-07-28 15:34:45', 85, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(86, 1, '2022-07-28 15:34:45', 86, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(87, 1, '2022-07-28 15:34:46', 87, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(88, 1, '2022-07-28 15:34:46', 88, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(89, 1, '2022-07-28 15:34:46', 89, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(90, 1, '2022-07-28 15:34:46', 90, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(91, 1, '2022-07-28 15:34:46', 91, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(92, 1, '2022-07-28 15:34:46', 92, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(93, 1, '2022-07-28 15:34:46', 93, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(94, 1, '2022-07-28 15:34:46', 94, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(95, 1, '2022-07-28 15:34:46', 95, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(96, 1, '2022-07-28 15:34:46', 96, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(97, 1, '2022-07-28 15:34:46', 97, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `events_login`
--

DROP TABLE IF EXISTS `events_login`;
CREATE TABLE IF NOT EXISTS `events_login` (
  `id_el` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `el_usca` char(100) NOT NULL,
  `el_dade` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `el_event` int(11) NOT NULL,
  UNIQUE KEY `id_el` (`id_el`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `events_names`
--

DROP TABLE IF EXISTS `events_names`;
CREATE TABLE IF NOT EXISTS `events_names` (
  `id_n` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `n_nome` char(100) NOT NULL,
  `n_cracha` char(15) NOT NULL,
  `n_email` char(100) NOT NULL,
  `n_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `id_n` (`id_n`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `events_names`
--

INSERT INTO `events_names` (`id_n`, `n_nome`, `n_cracha`, `n_email`, `n_created`) VALUES
(1, 'Alejandro Caballero Rivero', 'd96f14406ffdabe', 'caballero.alecaba@gmail.com', '2022-07-28 15:34:45'),
(2, 'Alejandro Uribe-Tirado', 'fb99e35726c192b', 'auribe.bibliotecologia.udea@gmail.com', '2022-07-28 15:34:45'),
(3, 'Aline Goneli de Lacerda', 'ea411f32f50181a', 'alinegoneli@id.uff.br', '2022-07-28 15:34:45'),
(4, 'Ana Paula Nogueira Nunes', '6b3318ef449a04a', 'anapaula.nunes@ufvjm.edu.br', '2022-07-28 15:34:45'),
(5, 'Ana Sara Pereira de Melo Sobral', '2b66ce51e8b461a', 'anasarap@hotmail.com', '2022-07-28 15:34:45'),
(6, 'Andrea Cristina Bogado', 'd2cec818f2b28da', 'and.bogado@gmail.com', '2022-07-28 15:34:45'),
(7, 'Arianna Becerril-Garcia', '6d9c320ece1c528', 'arianna.becerril@gmail.com', '2022-07-28 15:34:45'),
(8, 'Asa Fujino', 'e6a878ecb96fb27', 'asa.fujino@gmail.com', '2022-07-28 15:34:45'),
(9, 'Bianca Amaro', '9384da43510b8bb', 'bianca@ibict.br', '2022-07-28 15:34:45'),
(10, 'Bianca Savegnago de Mira', '7e0ef9e32d3d91a', 'bianca.mira@unesp.br', '2022-07-28 15:34:45'),
(11, 'Bruna de Paula Fonseca', 'ba64cfa0bfb4f1a', 'bruna.fonseca@fiocruz.br', '2022-07-28 15:34:45'),
(12, 'Bruna Lais Campos do Nascimento', '613ca931dc917ff', 'brunalaysbib@gmail.com', '2022-07-28 15:34:45'),
(13, 'Camila Goneli Passareli', 'e0652f8cee6479f', 'camilagoneli@gmail.com', '2022-07-28 15:34:45'),
(14, 'Carla Viganigo Rangel de Castilhos', '243c26844e4d655', 'carla.castilhos@gmail.com', '2022-07-28 15:34:45'),
(15, 'Caroline Gomes de Oliveira', 'fa0a847ebe90081', 'gomes.oliveira@unesp.br', '2022-07-28 15:34:45'),
(16, 'Catherine da Silva Cunha', 'dc1a0f9d9b9e2e3', 'catherinecunha@gmail.com', '2022-07-28 15:34:45'),
(17, 'Claudia Cabrini Gracio', '01a75ffbde24e17', 'cabrini.gracio@unesp.br', '2022-07-28 15:34:45'),
(18, 'Daiana Ellen Canato', '73925860e1cf561', 'daianaellencanato@gmail.com', '2022-07-28 15:34:45'),
(19, 'danielle pompeu noronha pontes', '148dca825412ede', 'danielle.pontes@aluno.unb.br', '2022-07-28 15:34:45'),
(20, 'Darllon Padua Santos', 'e72b849aadd5f9e', 'darllonpadua@gmail.com', '2022-07-28 15:34:45'),
(21, 'Denilson de Oliveira Sarvo', '39ba94816321903', 'denilson@ufscar.br', '2022-07-28 15:34:45'),
(22, 'Dirce Maria Santin', '7bf9ff3ef1504d2', 'dirce.santin@ufrgs.br', '2022-07-28 15:34:45'),
(23, 'Ediane Maria Gheno', '668fb3f90a352d5', 'ghenoediane@gmail.com', '2022-07-28 15:34:45'),
(24, 'Edla Barbosa de Santana', '9792277723618bd', 'edlabarbosaconsultoria@gmail.com', '2022-07-28 15:34:45'),
(25, 'Edna da Silva Angelo', '4862194f43d1163', 'ednasangelo@gmail.com', '2022-07-28 15:34:45'),
(26, 'Ely Francina Tannuri de Oliveira', 'b1831a3b2290c8d', 'etannuri@gmail.com', '2022-07-28 15:34:45'),
(27, 'Fábio Castro Gouveia', 'f714901f772a0ae', 'fgouveia@gmail.com', '2022-07-28 15:34:45'),
(28, 'Fábio Guedes Gomes', '207adccfc836876', 'fabio.guedes@fapeal.br', '2022-07-28 15:34:45'),
(29, 'Fábio Mascarenhas e Silva', 'eee60a61733bae3', 'fabio.mascarenhas@ufpe.br', '2022-07-28 15:34:45'),
(30, 'Francielle Franco', '74dd01a7ff00de7', 'franfranco.santos@gmail.com', '2022-07-28 15:34:45'),
(31, 'Geisa Fabiane Ferreira Cavalcante', '81adae5ebf1e271', 'geisa.cavalcante@ufpe.br', '2022-07-28 15:34:45'),
(32, 'Gerson Pech', 'aef9a1f92590a87', 'gerson@pech.com.br', '2022-07-28 15:34:45'),
(33, 'Girlaine da Silva Santos', '54ecac7da77f329', 'gir13santos1@gmail.com', '2022-07-28 15:34:45'),
(34, 'Giuliano Martins Porto de Souza', 'f7f559ca94b0194', 'giulianoporto@gmail.com', '2022-07-28 15:34:45'),
(35, 'Gonzalo Rubén Alvarez', '3cc2db14e9d04d3', 'gonzalorubenalvarez@gmail.com', '2022-07-28 15:34:45'),
(36, 'Higor Alexandre Duarte Mascarenhas', '4ed4cf3c220fde6', 'higoralexandre1996@gmail.com', '2022-07-28 15:34:45'),
(37, 'Ilaydiany Cristina Oliveira da Silva', '095bbce902e3843', 'ilaydiany18@hotmail.com', '2022-07-28 15:34:45'),
(38, 'Instituto Nacional da Mata Atlantica - participante Juliana Lazzarotto Freitas', 'f9f926a8b2d124e', 'dipge@inma.gov.br', '2022-07-28 15:34:45'),
(39, 'Jacqueline Leta', '4eb4f07d0bb8586', 'jleta@bioqmed.ufrj.br', '2022-07-28 15:34:45'),
(40, 'Jacques Marcovitch', 'bf434bad1b0a7dc', 'jmarcovi@usp.br', '2022-07-28 15:34:45'),
(41, 'Jéssyca Maria Santos da Silva', 'fa75c925ebf86c1', 'jms.silva@unesp.br', '2022-07-28 15:34:45'),
(42, 'Joana Coeli Ribeiro Garcia', '7649c18bcb76949', 'nacoeli@gmail.com', '2022-07-28 15:34:45'),
(43, 'João de Melo Maricato', 'ed4dda98dbf330c', 'jmmaricato@gmail.com', '2022-07-28 15:34:45'),
(44, 'Judith Sutz', 'd0e0783edfc88ef', 'jsutz@csic.edu.uy', '2022-07-28 15:34:45'),
(45, 'Juliana Freitas Lopes', 'be44db170110982', 'julianaflopes@fiocruz.br', '2022-07-28 15:34:45'),
(46, 'Kizi Mendonça de Araújo', '431cb305098efd9', 'kizi.araujo@icict.fiocruz.br', '2022-07-28 15:34:45'),
(47, 'Kleber de Oliveira da silva', '87837635b419ae4', 'kleber.silva@usp.br', '2022-07-28 15:34:45'),
(48, 'KLEISSON LAINNON NASCIMENTO DA SILVA', 'e92a3bd66636ab4', 'klns@academico.ufpb.br', '2022-07-28 15:34:45'),
(49, 'Laudiane Bispo dos Santos', 'f42d3c0154f548e', 'laudianebispo@gmail.com', '2022-07-28 15:34:45'),
(50, 'Leilah Santiago Bufrem', '1638608f1b68134', 'santiagobufrem@gmail.com', '2022-07-28 15:34:45'),
(51, 'Letícia Vitoria Rodrigues Lima de Souza', '00d67639e0b6449', 'leticiavrlsouza@gmail.com', '2022-07-28 15:34:45'),
(52, 'Leyde Klebia Rodrigues da Silva', '2e2b2f40ea20a17', 'leyklebia@gmail.com', '2022-07-28 15:34:45'),
(53, 'Lidyane Silva Lima', 'aea3f8e7cc0e80e', 'lidyane_slima@outlook.com', '2022-07-28 15:34:45'),
(54, 'LUCIANO PEREIRA DOS SANTOS CAVALCANTE', 'cdb0f6e5c013b63', 'lucianopdsc@hotmail.com', '2022-07-28 15:34:45'),
(55, 'Marcia Regina Silva', 'f6eab3635d788bf', 'marciaregina@usp.br', '2022-07-28 15:34:45'),
(56, 'MARCIO ADRIANO COSTA DOS SANTOS', 'f6e0b1455b7564b', 'marcioinforma@gmail.com', '2022-07-28 15:34:45'),
(57, 'Marcus Vinicius de Jesus Bomfim', 'db704502d5949ef', 'marcusbomfim@id.uff.br', '2022-07-28 15:34:45'),
(58, 'Marcus Vinícius Pereira da Silva', '5b08eb197ba80bf', 'marcus.silva@fiocruz.br', '2022-07-28 15:34:45'),
(59, 'Marisa Cubas Lozano', '1215d7e19f397e8', 'marisalozano@ufscar.br', '2022-07-28 15:34:45'),
(60, 'Michely Jabala Mamede Vogel', '25fb5435d026fb9', 'michelyvogel@id.uff.br', '2022-07-28 15:34:45'),
(61, 'Mônica Silveira', 'cd72ce54d5747e3', 'monica.silveira@clarivate.com', '2022-07-28 15:34:45'),
(62, 'Murilo Artur Araújo da Silveira', 'e8e33caf450544a', 'muriloas@gmail.com', '2022-07-28 15:34:45'),
(63, 'Nanci Oddone', 'dfbcca9a513440c', 'neoddone@gmail.com', '2022-07-28 15:34:45'),
(64, 'Nancy Sánchez Tarragó', '3ff697e2c67d876', 'nancy.sanchez@ufrn.br', '2022-07-28 15:34:45'),
(65, 'Natalia Rodrigues Delbianco', '23805c6b6ec2046', 'natalia.delbianco@unesp.br', '2022-07-28 15:34:45'),
(66, 'Natanael Vitor Sobral', 'c63b761f3111c23', 'natanvsobral@gmail.com', '2022-07-28 15:34:45'),
(67, 'Pablo Ferreira', '99284cd664cd07a', 'pablorjferreira@gmail.com', '2022-07-28 15:34:45'),
(68, 'Paola Gomes', 'd5388554f414784', 'paolannenberg@gmail.com', '2022-07-28 15:34:45'),
(69, 'Patricia da Silva Neubert', 'bded39bf6b06b08', 'patyneubert@hotmail.com', '2022-07-28 15:34:45'),
(70, 'Patricia de Souza dos Santos', '2ac10665fa7a641', 'patricia.rezende@ufpr.br', '2022-07-28 15:34:45'),
(71, 'Paula Carina de Araújo', '175522d89d92003', 'paula.carina.a@gmail.com', '2022-07-28 15:34:45'),
(72, 'PAULO RICARDO SILVA LIMA', 'db9e77a1bdae988', 'pauloricardo.silvalimma@gmail.com', '2022-07-28 15:34:45'),
(73, 'Priscila Costa Albuquerque', 'f4fe9ead848bf7d', 'priscila.costa@fiocruz.br', '2022-07-28 15:34:45'),
(74, 'Priscila Machado Borges Sena', 'ef96f7adfed0665', 'priscilasena@ibict.br', '2022-07-28 15:34:45'),
(75, 'Rafael Gutierres Castanha', 'bb695724eae1f30', 'r.castanha@gmail.com', '2022-07-28 15:34:45'),
(76, 'RAIMUNDO NONATO MACEDO DOS SANTOS', 'bd4c85ea0e3c690', 'raimundo.macedo@ufpe.br', '2022-07-28 15:34:45'),
(77, 'Raquel de Souza Leal', '43be55e2e3269d0', 'raquel.leal@bioqmed.ufrj.br', '2022-07-28 15:34:45'),
(78, 'Raulivan Rodrigo', 'a8f012177603ea1', 'raulivanrodrigo@yahoo.com.br', '2022-07-28 15:34:45'),
(79, 'RENE FAUSTINO GABRIEL JUNIOR', 'c4ecaf72ab616e5', 'renefgj@gmail.com', '2022-07-28 15:34:45'),
(80, 'Rogerio Mugnaini', 'dec5f71174e3710', 'rogerio.mugnaini@gmail.com', '2022-07-28 15:34:45'),
(81, 'Ronaldo Ferreira de Araujo', 'c9b6fa19f5ce705', 'ronaldfa@gmail.com', '2022-07-28 15:34:45'),
(82, 'Ronnie Fagundes de Brito', 'a61453c944de19b', 'ronniebrito@ibict.br', '2022-07-28 15:34:45'),
(83, 'ROSEMEIRE ROBERTA DE LIMA', 'a502a02e13939fb', 'rosemeirelimatdic@gmail.com', '2022-07-28 15:34:45'),
(84, 'Rosiane Pedro do Nascimento', '7cfc3fe4ff688af', 'rosianepn@id.uff.br', '2022-07-28 15:34:45'),
(85, 'Samile Andrea de Souza Vanz', '4cfcee50d67c340', 'samile.vanz@ufrgs.br', '2022-07-28 15:34:45'),
(86, 'Skrol Salustiano', 'dfa0e1c869a14ff', 'sallustiano@gmail.com', '2022-07-28 15:34:45'),
(87, 'Sonia Elisa Caregnato', 'd9389ca99f3399b', 'sonia.caregnato@ufrgs.br', '2022-07-28 15:34:46'),
(88, 'Sônia Oliveira Matos Moutinho', '911d6bbc842a78d', 'sonia.matos-moutinho@unesp.br', '2022-07-28 15:34:46'),
(89, 'Stephanie Treiber', 'a46123825ca85d0', 'stephanietreiber@gmail.com', '2022-07-28 15:34:46'),
(90, 'Tatyane Lúcia Cruz', '49144f5812d5527', 'tatyanelcruz@gmail.com', '2022-07-28 15:34:46'),
(91, 'Thaiane Moreira de Oliveira', '841baacf621c7c4', 'thaianeoliveira@id.uff.br', '2022-07-28 15:34:46'),
(92, 'Thiago Magela Rodrigues Dias', '4179609ddce319d', 'thiagomagela@gmail.com', '2022-07-28 15:34:46'),
(93, 'Thomas Hervé Mboa Nkoudou', '73528765d1f911f', 'thomasmboa@gmail.com', '2022-07-28 15:34:46'),
(94, 'Valeska Medeiros da Silva', '5e8cc9ca18868a2', 'valamedeiros@yahoo.com.br', '2022-07-28 15:34:46'),
(95, 'Vanusa Jardim Borges', 'e727460721cb41a', 'jardim.vanusa@gmail.com', '2022-07-28 15:34:46'),
(96, 'Vinícius Medina Kern', '23f5d4f0b1be238', 'vmkern@gmail.com', '2022-07-28 15:34:46'),
(97, 'Wellington Barbosa Rodrigues', 'd2170a385faca39', 'wellington.rodrigues@ufabc.edu.br', '2022-07-28 15:34:46');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_us` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `us_nome` char(80) NOT NULL,
  `us_email` char(80) NOT NULL,
  `us_login` char(20) NOT NULL,
  `us_password` char(40) NOT NULL,
  `us_badge` char(12) NOT NULL,
  `us_link` char(80) NOT NULL,
  `us_ativo` int(11) NOT NULL,
  `us_genero` char(1) NOT NULL,
  `us_verificado` char(1) NOT NULL,
  `us_autenticador` char(3) NOT NULL,
  `us_cadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `us_acessos` int(11) NOT NULL,
  `us_erros` int(11) NOT NULL,
  `us_last` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `us_perfil` text,
  `us_perfil_check` char(50) DEFAULT NULL,
  `us_com_nome` char(50) NOT NULL,
  `us_com_ass` char(50) NOT NULL,
  `us_image` char(100) NOT NULL,
  `us_nivel` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `id_us` (`id_us`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id_us`, `us_nome`, `us_email`, `us_login`, `us_password`, `us_badge`, `us_link`, `us_ativo`, `us_genero`, `us_verificado`, `us_autenticador`, `us_cadastro`, `us_acessos`, `us_erros`, `us_last`, `us_perfil`, `us_perfil_check`, `us_com_nome`, `us_com_ass`, `us_image`, `us_nivel`) VALUES
(1, 'Comgrad biblioteconomia', 'comgradbib@ufrgs.br', 'comgradbib', 'comgrad@thesa', '', '', 1, '', '', 'T', '2017-10-09 10:55:34', 0, 0, '0000-00-00 00:00:00', '#ADM', NULL, '', '', '', 0),
(2, 'Rene F. Gabriel Junior', 'rene.gabriel@ufrgs.br', 'rene', '448545ct', '', '', 1, '', '', 'T', '2018-08-24 14:05:18', 0, 0, '0000-00-00 00:00:00', '#ADM', NULL, '', '', '', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users_group`
--

DROP TABLE IF EXISTS `users_group`;
CREATE TABLE IF NOT EXISTS `users_group` (
  `id_gr` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `gr_name` char(50) NOT NULL,
  `gr_hash` char(4) NOT NULL,
  `gr_library` char(4) NOT NULL,
  `gr_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `id_gr` (`id_gr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users_group_members`
--

DROP TABLE IF EXISTS `users_group_members`;
CREATE TABLE IF NOT EXISTS `users_group_members` (
  `id_grm` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `grm_group` int(4) NOT NULL,
  `grm_user` int(4) NOT NULL,
  `grm_library` char(4) NOT NULL,
  `grm_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `id_grm` (`id_grm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
