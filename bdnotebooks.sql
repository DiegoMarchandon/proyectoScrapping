CREATE DATABASE bdnotebooks;

CREATE TABLE `notebook` (
  `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Fullname` varchar(180) NOT NULL,
  `Marca` varchar(30) NOT NULL,
  `Procesador` varchar(25) NOT NULL,
  `URL` varchar(140) NOT NULL,
  `Precio` int(140) NOT NULL,
  PRIMARY KEY  (`id`)
)