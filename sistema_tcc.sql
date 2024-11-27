-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27/11/2024 às 05:28
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sistema_tcc`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `classificacao`
--

CREATE TABLE `classificacao` (
  `id` int(11) NOT NULL,
  `id_equipe` int(11) NOT NULL,
  `jogos` int(11) DEFAULT 0,
  `pontos` int(11) DEFAULT 0,
  `vitorias` int(11) DEFAULT 0,
  `empates` int(11) DEFAULT 0,
  `derrotas` int(11) DEFAULT 0,
  `gols_marcados` int(11) DEFAULT 0,
  `gols_sofridos` int(11) DEFAULT 0,
  `saldo_gols` int(11) GENERATED ALWAYS AS (`gols_marcados` - `gols_sofridos`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `equipes`
--

CREATE TABLE `equipes` (
  `id` int(11) NOT NULL,
  `nome_equipe` varchar(100) NOT NULL,
  `treinador` varchar(100) DEFAULT NULL,
  `contato` varchar(50) DEFAULT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `equipes`
--

INSERT INTO `equipes` (`id`, `nome_equipe`, `treinador`, `contato`, `data_criacao`) VALUES
(1, 'Time A', 'Treinador A', '111-1111', '2024-11-27 02:17:00'),
(2, 'Time B', 'Treinador B', '222-2222', '2024-11-27 02:17:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `gols`
--

CREATE TABLE `gols` (
  `id` int(11) NOT NULL,
  `id_partida` int(11) NOT NULL,
  `id_jogador` int(11) NOT NULL,
  `tempo` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `jogadores`
--

CREATE TABLE `jogadores` (
  `id` int(11) NOT NULL,
  `id_equipe` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `posicao` varchar(50) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `contato` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `jogadores`
--

INSERT INTO `jogadores` (`id`, `id_equipe`, `nome`, `posicao`, `numero`, `contato`) VALUES
(1, 1, 'Jogador 1', 'Atacante', 9, '333-3333'),
(2, 1, 'Jogador 2', 'Defensor', 4, '444-4444'),
(3, 2, 'Jogador 3', 'Meio-campo', 8, '555-5555'),
(4, 2, 'Jogador 4', 'Goleiro', 1, '666-6666');

-- --------------------------------------------------------

--
-- Estrutura para tabela `partidas`
--

CREATE TABLE `partidas` (
  `id` int(11) NOT NULL,
  `id_torneio` int(11) NOT NULL,
  `id_equipe_casa` int(11) NOT NULL,
  `id_equipe_fora` int(11) NOT NULL,
  `data_partida` date NOT NULL,
  `hora_partida` time NOT NULL,
  `local_torneio` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `partidas`
--

INSERT INTO `partidas` (`id`, `id_torneio`, `id_equipe_casa`, `id_equipe_fora`, `data_partida`, `hora_partida`, `local_torneio`) VALUES
(1, 1, 1, 2, '2024-12-01', '18:00:00', 'Ginásio IFPR');

-- --------------------------------------------------------

--
-- Estrutura para tabela `resultados`
--

CREATE TABLE `resultados` (
  `id` int(11) NOT NULL,
  `id_partida` int(11) NOT NULL,
  `gols_equipe_casa` int(11) DEFAULT 0,
  `gols_equipe_fora` int(11) DEFAULT 0,
  `observacoes` text DEFAULT NULL,
  `detalhes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `torneios`
--

CREATE TABLE `torneios` (
  `id` int(11) NOT NULL,
  `nome_torneio` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL,
  `local_torneio` varchar(255) NOT NULL,
  `regras` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `torneios`
--

INSERT INTO `torneios` (`id`, `nome_torneio`, `descricao`, `data_inicio`, `data_fim`, `local_torneio`, `regras`) VALUES
(1, 'Copa IFPR', 'Torneio anual do IFPR', '2024-12-01', '2024-12-10', 'Ginásio IFPR', 'Regras oficiais de futsal.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo` enum('admin','usuario') NOT NULL DEFAULT 'usuario',
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `tipo`, `data_criacao`) VALUES
(1, 'Administrador', 'admin@ifpr.com', '0192023a7bbd73250516f069df18b500', 'admin', '2024-11-27 02:17:00'),
(2, 'josmar', 'josmar@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'usuario', '2024-11-27 03:14:09');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `classificacao`
--
ALTER TABLE `classificacao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_equipe` (`id_equipe`);

--
-- Índices de tabela `equipes`
--
ALTER TABLE `equipes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `gols`
--
ALTER TABLE `gols`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_partida` (`id_partida`),
  ADD KEY `id_jogador` (`id_jogador`);

--
-- Índices de tabela `jogadores`
--
ALTER TABLE `jogadores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_equipe` (`id_equipe`);

--
-- Índices de tabela `partidas`
--
ALTER TABLE `partidas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_torneio` (`id_torneio`),
  ADD KEY `id_equipe_casa` (`id_equipe_casa`),
  ADD KEY `id_equipe_fora` (`id_equipe_fora`);

--
-- Índices de tabela `resultados`
--
ALTER TABLE `resultados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_partida` (`id_partida`);

--
-- Índices de tabela `torneios`
--
ALTER TABLE `torneios`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `classificacao`
--
ALTER TABLE `classificacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `equipes`
--
ALTER TABLE `equipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `gols`
--
ALTER TABLE `gols`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `jogadores`
--
ALTER TABLE `jogadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `partidas`
--
ALTER TABLE `partidas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `resultados`
--
ALTER TABLE `resultados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `torneios`
--
ALTER TABLE `torneios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `classificacao`
--
ALTER TABLE `classificacao`
  ADD CONSTRAINT `classificacao_ibfk_1` FOREIGN KEY (`id_equipe`) REFERENCES `equipes` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `gols`
--
ALTER TABLE `gols`
  ADD CONSTRAINT `gols_ibfk_1` FOREIGN KEY (`id_partida`) REFERENCES `partidas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `gols_ibfk_2` FOREIGN KEY (`id_jogador`) REFERENCES `jogadores` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `jogadores`
--
ALTER TABLE `jogadores`
  ADD CONSTRAINT `jogadores_ibfk_1` FOREIGN KEY (`id_equipe`) REFERENCES `equipes` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `partidas`
--
ALTER TABLE `partidas`
  ADD CONSTRAINT `partidas_ibfk_1` FOREIGN KEY (`id_torneio`) REFERENCES `torneios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `partidas_ibfk_2` FOREIGN KEY (`id_equipe_casa`) REFERENCES `equipes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `partidas_ibfk_3` FOREIGN KEY (`id_equipe_fora`) REFERENCES `equipes` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `resultados`
--
ALTER TABLE `resultados`
  ADD CONSTRAINT `resultados_ibfk_1` FOREIGN KEY (`id_partida`) REFERENCES `partidas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
