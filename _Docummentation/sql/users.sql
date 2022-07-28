-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: bdlivre.ufrgs.br
-- Tempo de geração: 28/07/2022 às 12:17
-- Versão do servidor: 5.5.31
-- Versão do PHP: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `comgradbib`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id_us` bigint(20) UNSIGNED NOT NULL,
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
  `us_nivel` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id_us`, `us_nome`, `us_email`, `us_login`, `us_password`, `us_badge`, `us_link`, `us_ativo`, `us_genero`, `us_verificado`, `us_autenticador`, `us_cadastro`, `us_acessos`, `us_erros`, `us_last`, `us_perfil`, `us_perfil_check`, `us_com_nome`, `us_com_ass`, `us_image`, `us_nivel`) VALUES
(1, 'Comgrad biblioteconomia', 'comgradbib@ufrgs.br', 'comgradbib', 'comgrad@thesa', '', '', 1, '', '', 'T', '2017-10-09 10:55:34', 0, 0, '0000-00-00 00:00:00', '#ADM', NULL, '', '', '', 0),
(2, 'Rene F. Gabriel Junior', 'rene.gabriel@ufrgs.br', 'rene', '448545ct', '', '', 1, '', '', 'T', '2018-08-24 14:05:18', 0, 0, '0000-00-00 00:00:00', '#ADM', NULL, '', '', '', 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `id_us` (`id_us`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id_us` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
