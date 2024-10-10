CREATE DATABASE bdnotebooks;

CREATE TABLE `notebook` (
  `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Fullname` varchar(180) NOT NULL,
  `Marca` varchar(40) NOT NULL,
  `Procesador` varchar(40) NOT NULL,
  `Sitio` varchar(40) NOT NULL,
  `Precio` int(140) NOT NULL,
  PRIMARY KEY  (`id`)
)