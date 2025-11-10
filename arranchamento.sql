
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `arranchamento` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `arranchamento`;

-- --------------------------------------------------------
-- Estrutura para tabela `arranchamento`
-- --------------------------------------------------------

CREATE TABLE `arranchamento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cpf` varchar(12) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `cafe` varchar(1) DEFAULT NULL,
  `almoco` varchar(1) DEFAULT NULL,
  `jantar` varchar(1) DEFAULT NULL,
  `justificativa_sexta` varchar(150) DEFAULT NULL,
  `hierarquia` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `arranchamento` (`id`, `cpf`, `data`, `cafe`, `almoco`, `jantar`, `justificativa_sexta`, `hierarquia`) VALUES
(412, '59282258068', '2017-02-16', 'S', 'S', 'N', NULL, 6);

-- --------------------------------------------------------
-- Estrutura para tabela `avaliacao_app`
-- --------------------------------------------------------

CREATE TABLE `avaliacao_app` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `posto` varchar(10) DEFAULT NULL,
  `nome_guerra` varchar(50) DEFAULT NULL,
  `avaliacao_0a5` int(11) DEFAULT NULL,
  `sugestoes` varchar(255) DEFAULT NULL,
  `data_avaliacao` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `avaliacao_app` (`id`, `posto`, `nome_guerra`, `avaliacao_0a5`, `sugestoes`, `data_avaliacao`) VALUES
(156, 'SD', 'SILVA', 5, 'Fácil e ágil! Muito rápido o funcionamento!', '2017-01-31')
-- --------------------------------------------------------
-- Estrutura para tabela `bloqueia_arranchamento`
-- --------------------------------------------------------

CREATE TABLE `bloqueia_arranchamento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `motivobloqueio` varchar(50) DEFAULT NULL,
  `databloqueio` date DEFAULT NULL,
  `bloqueiacafe` varchar(1) DEFAULT NULL,
  `bloqueiaalmoco` varchar(1) DEFAULT NULL,
  `bloqueiajantar` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Estrutura para tabela `configuracoes`
-- --------------------------------------------------------

CREATE TABLE `configuracoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `versaoatual_app` varchar(10) DEFAULT NULL,
  `url_relatorios` varchar(150) DEFAULT NULL,
  `url_novaversao` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `configuracoes` (`id`, `versaoatual_app`, `url_relatorios`, `url_novaversao`) VALUES
(1, '1.1.1', 'http://177.36.41.122/arranchamentonovo/relatorio/index.php', 'https://drive.google.com/open?id=0B6vTQH0oxl49UEhhM0drVVZJZUU');

-- --------------------------------------------------------
-- Estrutura para tabela `datahora_server`
-- --------------------------------------------------------

CREATE TABLE `datahora_server` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Estrutura para tabela `expedientes_diferenciados`
-- --------------------------------------------------------

CREATE TABLE `expedientes_diferenciados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `motivo` varchar(50) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `horalimite` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Estrutura para tabela `limite_arranchamento`
-- --------------------------------------------------------

CREATE TABLE `limite_arranchamento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `horalimite` time DEFAULT NULL,
  `diasemana` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `limite_arranchamento` (`id`, `horalimite`, `diasemana`) VALUES
(5, '10:00:00', 'seg'),
(6, '14:00:00', 'ter'),
(7, '14:00:00', 'qua'),
(8, '14:00:00', 'qui'),
(9, '14:00:00', 'sex'),
(10, '10:00:00', 'sáb'),
(11, '10:00:00', 'dom');

-- --------------------------------------------------------
-- Estrutura para tabela `militares`
-- --------------------------------------------------------

CREATE TABLE `militares` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomeguerra` varchar(20) DEFAULT NULL,
  `nomecompleto` varchar(80) DEFAULT NULL,
  `numero` int(5) DEFAULT NULL,
  `arma` varchar(30) DEFAULT NULL,
  `turma` char(10) DEFAULT NULL,
  `ativo` char(1) DEFAULT NULL,
  `cpf` varchar(12) DEFAULT NULL,
  `senha` varchar(32) DEFAULT NULL,
  `tipo_acesso` varchar(30) DEFAULT NULL,
  `datacadastro` date DEFAULT NULL,
  `usuario_novo` char(1) DEFAULT NULL,
  `funcao` varchar(60) DEFAULT NULL,
  `posto` varchar(10) DEFAULT NULL,
  `hierarquia` int(2) DEFAULT NULL,
  `ultimoacesso` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Estrutura para tabela `msgerros`
-- --------------------------------------------------------

CREATE TABLE `msgerros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `mensagem` varchar(150) DEFAULT NULL,
  `dataerro` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `msgerros` (`id`, `id_usuario`, `mensagem`, `dataerro`) VALUES
(10, 165, 'Lost connection to MySQL server during query', '2017-02-04'),
(11, 0, 'Lost connection to MySQL server during query', '1899-12-30'),
(12, 0, 'no such table: CONFIG', '1899-12-30'),
(20, 165, 'Lost connection to MySQL server during query', '2017-02-21');

-- --------------------------------------------------------
-- Estrutura para tabela `cardapio`
-- --------------------------------------------------------

CREATE TABLE `cardapio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` date NOT NULL,
  `refeicao` enum('cafe','almoco','jantar') NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
