
CREATE TABLE IF NOT EXISTS `codici_auth` (
  `id` bigint(10) unsigned NOT NULL auto_increment,
  `codice` varchar(255) NOT NULL,
  `codadmin` varchar(255) NOT NULL,
  `nome_tabella` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `codice` (`codice`),
  UNIQUE KEY `codadmin` (`codadmin`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dump dei dati per la tabella `codici_auth`
--

INSERT INTO `codici_auth` (`id`, `codice`, `codadmin`, `nome_tabella`) VALUES
(1, 'vico2020*', 'Fgm172826#', 'dati');

-- --------------------------------------------------------

--
-- Struttura della tabella `dati`
--

CREATE TABLE IF NOT EXISTS `dati` (
  `id` bigint(10) unsigned NOT NULL auto_increment,
  `data` datetime NOT NULL,
  `email_organizzatore` varchar(255) NOT NULL,
  `durata` bigint(12) NOT NULL,
  `nome_partecipante` varchar(255) NOT NULL,
  `esterno` tinyint(1) NOT NULL,
  `codice_riunione` varchar(20) NOT NULL,
  `client` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `data` (`data`),
  KEY `email_organizzatore` (`email_organizzatore`),
  KEY `nome_partecipante` (`nome_partecipante`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;



