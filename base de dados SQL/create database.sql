-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.4.24-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para certificados
DROP DATABASE IF EXISTS `certificados`;
CREATE DATABASE IF NOT EXISTS `certificados` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `certificados`;

-- Copiando estrutura para tabela certificados.acl_privileges
CREATE TABLE IF NOT EXISTS `acl_privileges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `role_id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_acl_privileges_acl_roles1_idx` (`role_id`),
  KEY `fk_acl_privileges_acl_resources1_idx` (`resource_id`),
  CONSTRAINT `fk_acl_privileges_acl_resources1` FOREIGN KEY (`resource_id`) REFERENCES `acl_resources` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_acl_privileges_acl_roles1` FOREIGN KEY (`role_id`) REFERENCES `acl_roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela certificados.acl_resources
CREATE TABLE IF NOT EXISTS `acl_resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela certificados.acl_roles
CREATE TABLE IF NOT EXISTS `acl_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_acl_roles_acl_roles1_idx` (`parent_id`),
  CONSTRAINT `fk_acl_roles_acl_roles1` FOREIGN KEY (`parent_id`) REFERENCES `acl_roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela certificados.atividade
CREATE TABLE IF NOT EXISTS `atividade` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `evento_id` smallint(5) unsigned NOT NULL,
  `tipo_atividade_id` tinyint(3) unsigned NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `data_inicio` datetime NOT NULL,
  `data_fim` datetime NOT NULL,
  `carga_horaria` float unsigned NOT NULL,
  `cadastrado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `FK_atividade_evento` (`evento_id`),
  KEY `FK_atividade_tipo_atividade` (`tipo_atividade_id`),
  CONSTRAINT `FK_atividade_evento` FOREIGN KEY (`evento_id`) REFERENCES `evento` (`id`),
  CONSTRAINT `FK_atividade_tipo_atividade` FOREIGN KEY (`tipo_atividade_id`) REFERENCES `tipo_atividade` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela certificados.certificado_tipo_funcao_evento
CREATE TABLE IF NOT EXISTS `certificado_tipo_funcao_evento` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `evento_id` smallint(5) unsigned NOT NULL,
  `tipo_atividade_id` tinyint(3) unsigned NOT NULL,
  `funcao_id` tinyint(3) unsigned NOT NULL,
  `modelo_certificado_id` int(10) unsigned NOT NULL,
  `cadastrado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`evento_id`,`tipo_atividade_id`,`funcao_id`),
  UNIQUE KEY `id` (`id`),
  KEY `tipo_atividade_id` (`tipo_atividade_id`),
  KEY `funcao_id` (`funcao_id`),
  KEY `modelo_certificado_id` (`modelo_certificado_id`),
  CONSTRAINT `certificado_tipo_funcao_evento_ibfk_1` FOREIGN KEY (`evento_id`) REFERENCES `evento` (`id`),
  CONSTRAINT `certificado_tipo_funcao_evento_ibfk_2` FOREIGN KEY (`tipo_atividade_id`) REFERENCES `tipo_atividade` (`id`),
  CONSTRAINT `certificado_tipo_funcao_evento_ibfk_3` FOREIGN KEY (`funcao_id`) REFERENCES `funcao` (`id`),
  CONSTRAINT `certificado_tipo_funcao_evento_ibfk_4` FOREIGN KEY (`modelo_certificado_id`) REFERENCES `modelo_certificado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela certificados.evento
CREATE TABLE IF NOT EXISTS `evento` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `sigla` varchar(15) DEFAULT NULL,
  `ano` year(4) NOT NULL,
  `numero_edicao` varchar(10) NOT NULL,
  `data_inicial` date NOT NULL,
  `data_final` date NOT NULL,
  `cadastrado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_id` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `evento_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela certificados.funcao
CREATE TABLE IF NOT EXISTS `funcao` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(120) NOT NULL,
  `cadastrado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela certificados.modelo_certificado
CREATE TABLE IF NOT EXISTS `modelo_certificado` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `texto_frente` longtext NOT NULL,
  `texto_verso` longtext DEFAULT NULL,
  `descricao_frente` varchar(45) DEFAULT NULL,
  `descricao_verso` varchar(45) DEFAULT NULL,
  `bg_frente` varchar(255) DEFAULT NULL,
  `bg_verso` varchar(255) DEFAULT NULL,
  `estilo_container_texto_frente` text DEFAULT NULL,
  `estilo_container_texto_verso` text DEFAULT NULL,
  `tipo` enum('frente_verso','frente') NOT NULL DEFAULT 'frente',
  `cadastrado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela certificados.participacao
CREATE TABLE IF NOT EXISTS `participacao` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `evento_id` smallint(5) unsigned NOT NULL,
  `tipo_atividade_id` tinyint(3) unsigned NOT NULL,
  `atividade_id` smallint(5) unsigned NOT NULL,
  `participante_id` smallint(5) unsigned NOT NULL,
  `funcao_id` tinyint(3) unsigned DEFAULT NULL,
  `data_inicio` datetime NOT NULL,
  `data_fim` datetime NOT NULL,
  `carga_horaria` float unsigned NOT NULL,
  `data_ultima_emissao` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `chave_validacao` varchar(255) NOT NULL,
  `qtd_bolsista` tinyint(3) unsigned DEFAULT NULL,
  `email_enviado_em` datetime DEFAULT NULL,
  `ordem_autoria` tinyint(3) unsigned DEFAULT NULL,
  `cadastrado_em` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`evento_id`,`tipo_atividade_id`,`atividade_id`,`participante_id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `chave_validacao` (`chave_validacao`),
  KEY `participante_id` (`participante_id`),
  KEY `funcao_id` (`funcao_id`),
  KEY `FK_participacao_atividade` (`atividade_id`),
  KEY `FK_participacao_tipo_atividade` (`tipo_atividade_id`),
  CONSTRAINT `FK_participacao_evento` FOREIGN KEY (`evento_id`) REFERENCES `evento` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_participacao_funcao` FOREIGN KEY (`funcao_id`) REFERENCES `funcao` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_participacao_participante` FOREIGN KEY (`participante_id`) REFERENCES `participante` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_participacao_tipo_atividade` FOREIGN KEY (`tipo_atividade_id`) REFERENCES `tipo_atividade` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela certificados.participante
CREATE TABLE IF NOT EXISTS `participante` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `CPF` char(11) NOT NULL,
  `nome_completo` varchar(150) NOT NULL,
  `data_nascimento` date NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `email_valido` tinyint(3) unsigned DEFAULT NULL,
  `instituicao_ifba_vca` enum('Sim','Não') NOT NULL DEFAULT 'Sim',
  `cadastrado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `CPF` (`CPF`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela certificados.tipo_atividade
CREATE TABLE IF NOT EXISTS `tipo_atividade` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(120) NOT NULL,
  `cadastrado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela certificados.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `tipo` enum('Administrador','Coordenador do Evento') NOT NULL DEFAULT 'Coordenador do Evento',
  `cadastrado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para trigger certificados.T_CHAVE_VALIDACAO
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='';
DELIMITER //
CREATE TRIGGER `T_CHAVE_VALIDACAO` BEFORE INSERT ON `participacao` FOR EACH ROW BEGIN
SET NEW.chave_validacao = UPPER(SUBSTR(MD5(CONCAT(NEW.evento_id, NEW.tipo_atividade_id, NEW.atividade_id, NEW.participante_id, UNIX_TIMESTAMP())), 5, 16));
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
