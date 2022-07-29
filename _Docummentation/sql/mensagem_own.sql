-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: bdlivre.ufrgs.br
-- Tempo de geração: 28/07/2022 às 14:24
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
-- Estrutura para tabela `mensagem_own`
--

CREATE TABLE `mensagem_own` (
  `id_m` bigint(20) UNSIGNED NOT NULL,
  `m_descricao` char(150) NOT NULL,
  `m_header` text NOT NULL,
  `m_foot` text NOT NULL,
  `m_ativo` tinyint(4) NOT NULL,
  `m_email` char(100) NOT NULL,
  `m_own_cod` char(10) NOT NULL,
  `smtp_host` char(80) NOT NULL,
  `smtp_user` char(80) NOT NULL,
  `smtp_pass` char(80) NOT NULL,
  `smtp_protocol` char(5) NOT NULL,
  `smtp_port` char(3) NOT NULL,
  `mailtype` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `mensagem_own`
--

INSERT INTO `mensagem_own` (`id_m`, `m_descricao`, `m_header`, `m_foot`, `m_ativo`, `m_email`, `m_own_cod`, `smtp_host`, `smtp_user`, `smtp_pass`, `smtp_protocol`, `smtp_port`, `mailtype`) VALUES
(1, 'Comgrad de Biblioteconomia - UFRGS', '', '', 1, 'comgradbib@ufrgs.br', '', 'ssl://smtp.gmail.com', 'comgradbib@ufrgs.br', 'comgrad@thesa', 'smtp', '465', 'smtp'),
(2, '[PPGCIN] Ciencia da Informacao - UFRGS', '', '', 1, 'ppgcin@ufrgs.br', '', 'smtp.ufrgs.br', 'ppgcin@ufrgs.br', 'Pesquisa@2020', 'mail', '465', 'smtp'),
(3, 'Comgrad de Arquivologia - UFRGS', '', '', 1, 'comgradaql@ufrgs.br', '', 'ssl://smtp.gmail.com', 'comgradbib@ufrgs.br', 'comgrad@thesa', 'smtp', '465', 'smtp'),
(4, 'Comgrad de Museologia - UFRGS', '', '', 0, 'museologia@ufrgs.br', '', 'ssl://smtp.gmail.com', 'comgradbib@ufrgs.br', 'comgrad@thesa', 'SMPT', '465', 'smtp'),
(5, 'Comgrad de Museologia - UFRGS', '', '', 1, 'museologia@ufrgs.br', '', 'ssl://smtp.gmail.com', 'comgradbib@ufrgs.br', 'comgrad@thesa', 'SMPT', '465', 'smtp'),
(6, 'Comgrad de Biblioteconomia EAD', 'img/header/bibead_header.png', '', 1, 'bibead@ufrgs.br', '', 'smtp.ufrgs.br', 'bibead@ufrgs.br', 'Bibead@2021', 'MAIL', '', 'HTML');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `mensagem_own`
--
ALTER TABLE `mensagem_own`
  ADD UNIQUE KEY `id_m` (`id_m`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `mensagem_own`
--
ALTER TABLE `mensagem_own`
  MODIFY `id_m` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
