-- https://dba.stackexchange.com/questions/76788/create-a-mysql-database-with-charset-utf-8
CREATE DATABASE IF NOT EXISTS vino
	CHARACTER SET utf8mb4
	COLLATE utf8mb4_unicode_ci;

USE vino;


DROP TABLE IF EXISTS vino_cellier__bouteille;
DROP TABLE IF EXISTS vino_cellier__usager;
DROP TABLE IF EXISTS vino_role_description;
DROP TABLE IF EXISTS vino_role;
DROP TABLE IF EXISTS vino_cellier;
DROP TABLE IF EXISTS vino_bouteille;
DROP TABLE IF EXISTS vino_usager;
DROP TABLE IF EXISTS vino_format;
DROP TABLE IF EXISTS vino_couleur_description;
DROP TABLE IF EXISTS vino_couleur;
DROP TABLE IF EXISTS vino_region_description;
DROP TABLE IF EXISTS vino_region;
DROP TABLE IF EXISTS vino_pays_description;
DROP TABLE IF EXISTS vino_pays;
DROP TABLE IF EXISTS vino_millesime;
DROP TABLE IF EXISTS vino_langue;


CREATE TABLE vino_langue (
	id INT NOT NULL AUTO_INCREMENT,
	libelle VARCHAR(30) NOT NULL,
	code CHAR(2) NOT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE vino_millesime (
	id INT NOT NULL AUTO_INCREMENT,
	libelle CHAR(4) NOT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE vino_pays (
	id INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE vino_pays_description (
	id INT NOT NULL AUTO_INCREMENT,
	id_pays INT NOT NULL,
	id_langue INT NOT NULL,
	libelle VARCHAR(30) NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id_pays) REFERENCES vino_pays(id),
	FOREIGN KEY (id_langue) REFERENCES vino_langue(id)
) ENGINE=InnoDB;

CREATE TABLE vino_region (
	id INT NOT NULL AUTO_INCREMENT,
	id_pays INT NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id_pays) REFERENCES vino_pays(id)
) ENGINE=InnoDB;

CREATE TABLE vino_region_description (
	id INT NOT NULL AUTO_INCREMENT,
	id_region INT NOT NULL,
	id_langue INT NOT NULL,
	libelle VARCHAR(50) NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id_region) REFERENCES vino_region(id),
	FOREIGN KEY (id_langue) REFERENCES vino_langue(id)
) ENGINE=InnoDB;

CREATE TABLE vino_couleur (
	id INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE vino_couleur_description (
	id INT NOT NULL AUTO_INCREMENT,
	id_couleur INT NOT NULL,
	id_langue INT NOT NULL,
	libelle VARCHAR(20) NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id_couleur) REFERENCES vino_couleur(id),
	FOREIGN KEY (id_langue) REFERENCES vino_langue(id)
) ENGINE=InnoDB;

CREATE TABLE vino_format (
	id INT NOT NULL AUTO_INCREMENT,
	quantite FLOAT NOT NULL,
	unite VARCHAR(10) NOT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE vino_usager (
	id INT NOT NULL AUTO_INCREMENT,
	id_langue INT NOT NULL,
	admin  BOOLEAN NOT NULL,
	nom VARCHAR(30) NOT NULL,
	courriel VARCHAR(255) NOT NULL,
	hash CHAR(128) NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id_langue) REFERENCES vino_langue(id),
	UNIQUE (courriel)
) ENGINE=InnoDB;

-- https://stackoverflow.com/questions/219569/best-database-field-type-for-a-url
-- https://s7d9.scene7.com/is/image/SAQ/10324623_is
-- url_img VARCHAR(2083) DEFAULT NULL,
-- https://www.saq.com/page/en/saqcom/x/x/12216562
CREATE TABLE vino_bouteille (
	id INT NOT NULL AUTO_INCREMENT,
	code_saq VARCHAR(20) DEFAULT NULL,
	id_usager INT DEFAULT NULL,
	prix FLOAT DEFAULT NULL,
	id_couleur INT DEFAULT NULL,
	id_format INT DEFAULT NULL,
	id_pays INT DEFAULT NULL,
	id_region INT DEFAULT NULL,
	id_millesime INT DEFAULT NULL,
	libelle VARCHAR(200) NOT NULL,
	note TEXT DEFAULT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id_usager) REFERENCES vino_usager(id),
	FOREIGN KEY (id_couleur) REFERENCES vino_couleur(id),
	FOREIGN KEY (id_format) REFERENCES vino_format(id),
	FOREIGN KEY (id_pays) REFERENCES vino_pays(id),
	FOREIGN KEY (id_region) REFERENCES vino_region(id),
	FOREIGN KEY (id_millesime) REFERENCES vino_millesime(id)
) ENGINE=InnoDB;

CREATE TABLE vino_cellier (
	id INT NOT NULL AUTO_INCREMENT,
	nom VARCHAR(30) NOT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE vino_role (
	id INT NOT NULL AUTO_INCREMENT,
	modifier BOOLEAN NOT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE vino_role_description (
	id INT NOT NULL AUTO_INCREMENT,
	id_role INT NOT NULL,
	id_langue INT NOT NULL,
	libelle VARCHAR(30) NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id_role) REFERENCES vino_role(id),
	FOREIGN KEY (id_langue) REFERENCES vino_langue(id)
) ENGINE=InnoDB;

CREATE TABLE vino_cellier__usager (
	id INT NOT NULL AUTO_INCREMENT,
	id_cellier INT NOT NULL,
	id_usager INT NOT NULL,
	id_role INT NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id_cellier) REFERENCES vino_cellier(id),
	FOREIGN KEY (id_usager) REFERENCES vino_usager(id),
	FOREIGN KEY (id_role) REFERENCES vino_role(id)
) ENGINE=InnoDB;

CREATE TABLE vino_cellier__bouteille (
	id INT NOT NULL AUTO_INCREMENT,
	id_cellier  INT NOT NULL,
	id_bouteille  INT NOT NULL,
	quantite INT NOT NULL,
	date_achat DATE DEFAULT NULL,
	date_peremption DATE DEFAULT NULL,
	note TEXT DEFAULT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id_bouteille) REFERENCES vino_bouteille(id),
	FOREIGN KEY (id_cellier) REFERENCES vino_cellier(id)
) ENGINE=InnoDB;

INSERT INTO vino_langue VALUES(1, 'Français', 'fr');
INSERT INTO vino_langue VALUES(2, 'English', 'en');

INSERT INTO vino_millesime VALUES(1, '1951');
INSERT INTO vino_millesime VALUES(2, '1964');
INSERT INTO vino_millesime VALUES(3, '1966');
INSERT INTO vino_millesime VALUES(4, '1982');
INSERT INTO vino_millesime VALUES(5, '1985');
INSERT INTO vino_millesime VALUES(6, '1986');
INSERT INTO vino_millesime VALUES(7, '1988');
INSERT INTO vino_millesime VALUES(8, '1989');
INSERT INTO vino_millesime VALUES(9, '1990');
INSERT INTO vino_millesime VALUES(10, '1994');
INSERT INTO vino_millesime VALUES(11, '1995');
INSERT INTO vino_millesime VALUES(12, '1996');
INSERT INTO vino_millesime VALUES(13, '1997');
INSERT INTO vino_millesime VALUES(14, '1998');
INSERT INTO vino_millesime VALUES(15, '1999');
INSERT INTO vino_millesime VALUES(16, '2000');
INSERT INTO vino_millesime VALUES(17, '2001');
INSERT INTO vino_millesime VALUES(18, '2002');
INSERT INTO vino_millesime VALUES(19, '2003');
INSERT INTO vino_millesime VALUES(20, '2004');
INSERT INTO vino_millesime VALUES(21, '2005');
INSERT INTO vino_millesime VALUES(22, '2006');
INSERT INTO vino_millesime VALUES(23, '2007');
INSERT INTO vino_millesime VALUES(24, '2008');
INSERT INTO vino_millesime VALUES(25, '2009');
INSERT INTO vino_millesime VALUES(26, '2010');
INSERT INTO vino_millesime VALUES(27, '2011');
INSERT INTO vino_millesime VALUES(28, '2012');
INSERT INTO vino_millesime VALUES(29, '2013');
INSERT INTO vino_millesime VALUES(30, '2014');
INSERT INTO vino_millesime VALUES(31, '2015');
INSERT INTO vino_millesime VALUES(32, '2016');
INSERT INTO vino_millesime VALUES(33, '2017');
INSERT INTO vino_millesime VALUES(34, '2018');

INSERT INTO vino_pays VALUES(1);
INSERT INTO vino_pays VALUES(2);
INSERT INTO vino_pays VALUES(3);
INSERT INTO vino_pays VALUES(4);
INSERT INTO vino_pays VALUES(5);
INSERT INTO vino_pays VALUES(6);
INSERT INTO vino_pays VALUES(7);
INSERT INTO vino_pays VALUES(8);
INSERT INTO vino_pays VALUES(9);
INSERT INTO vino_pays VALUES(10);
INSERT INTO vino_pays VALUES(11);
INSERT INTO vino_pays VALUES(12);
INSERT INTO vino_pays VALUES(13);
INSERT INTO vino_pays VALUES(14);
INSERT INTO vino_pays VALUES(15);
INSERT INTO vino_pays VALUES(16);
INSERT INTO vino_pays VALUES(17);
INSERT INTO vino_pays VALUES(18);
INSERT INTO vino_pays VALUES(19);
INSERT INTO vino_pays VALUES(20);
INSERT INTO vino_pays VALUES(21);
INSERT INTO vino_pays VALUES(22);
INSERT INTO vino_pays VALUES(23);
INSERT INTO vino_pays VALUES(24);
INSERT INTO vino_pays VALUES(25);
INSERT INTO vino_pays VALUES(26);
INSERT INTO vino_pays VALUES(27);
INSERT INTO vino_pays VALUES(28);
INSERT INTO vino_pays VALUES(29);
INSERT INTO vino_pays VALUES(30);
INSERT INTO vino_pays VALUES(31);
INSERT INTO vino_pays VALUES(32);
INSERT INTO vino_pays VALUES(33);
INSERT INTO vino_pays VALUES(34);
INSERT INTO vino_pays VALUES(35);
INSERT INTO vino_pays VALUES(36);
INSERT INTO vino_pays VALUES(37);
INSERT INTO vino_pays VALUES(38);

INSERT INTO vino_pays_description VALUES(1, 1, 1, 'Afrique du Sud');
INSERT INTO vino_pays_description VALUES(2, 2, 1, 'Algérie');
INSERT INTO vino_pays_description VALUES(3, 3, 1, 'Allemagne');
INSERT INTO vino_pays_description VALUES(4, 4, 1, 'Argentine');
INSERT INTO vino_pays_description VALUES(5, 5, 1, 'Arménie (République d’)');
INSERT INTO vino_pays_description VALUES(6, 6, 1, 'Australie');
INSERT INTO vino_pays_description VALUES(7, 7, 1, 'Autriche');
INSERT INTO vino_pays_description VALUES(8, 8, 1, 'Brésil');
INSERT INTO vino_pays_description VALUES(9, 9, 1, 'Bulgarie');
INSERT INTO vino_pays_description VALUES(10, 10, 1, 'Canada');
INSERT INTO vino_pays_description VALUES(11, 11, 1, 'Chili');
INSERT INTO vino_pays_description VALUES(12, 12, 1, 'Croatie');
INSERT INTO vino_pays_description VALUES(13, 13, 1, 'Espagne');
INSERT INTO vino_pays_description VALUES(14, 14, 1, 'États-Unis');
INSERT INTO vino_pays_description VALUES(15, 15, 1, 'France');
INSERT INTO vino_pays_description VALUES(16, 16, 1, 'Géorgie');
INSERT INTO vino_pays_description VALUES(17, 17, 1, 'Grèce');
INSERT INTO vino_pays_description VALUES(18, 18, 1, 'Hongrie');
INSERT INTO vino_pays_description VALUES(19, 19, 1, 'Inde');
INSERT INTO vino_pays_description VALUES(20, 20, 1, 'Israël');
INSERT INTO vino_pays_description VALUES(21, 21, 1, 'Italie');
INSERT INTO vino_pays_description VALUES(22, 22, 1, 'Liban');
INSERT INTO vino_pays_description VALUES(23, 23, 1, 'Luxembourg');
INSERT INTO vino_pays_description VALUES(24, 24, 1, 'Macédoine');
INSERT INTO vino_pays_description VALUES(25, 25, 1, 'Maroc');
INSERT INTO vino_pays_description VALUES(26, 26, 1, 'Mexique');
INSERT INTO vino_pays_description VALUES(27, 27, 1, 'Moldavie');
INSERT INTO vino_pays_description VALUES(28, 28, 1, 'Nouvelle-Zélande');
INSERT INTO vino_pays_description VALUES(29, 29, 1, 'Pérou');
INSERT INTO vino_pays_description VALUES(30, 30, 1, 'Portugal');
INSERT INTO vino_pays_description VALUES(31, 31, 1, 'République Tchèque');
INSERT INTO vino_pays_description VALUES(32, 32, 1, 'Roumanie');
INSERT INTO vino_pays_description VALUES(33, 33, 1, 'Royaume Uni');
INSERT INTO vino_pays_description VALUES(34, 34, 1, 'Slovaquie');
INSERT INTO vino_pays_description VALUES(35, 35, 1, 'Suisse');
INSERT INTO vino_pays_description VALUES(36, 36, 1, 'Tunisie');
INSERT INTO vino_pays_description VALUES(37, 37, 1, 'Turquie');
INSERT INTO vino_pays_description VALUES(38, 38, 1, 'Uruguay');
INSERT INTO vino_pays_description VALUES(39, 1, 2, 'South Africa');
INSERT INTO vino_pays_description VALUES(40, 2, 2, 'Algeria');
INSERT INTO vino_pays_description VALUES(41, 3, 2, 'Germany');
INSERT INTO vino_pays_description VALUES(42, 4, 2, 'Argentina');
INSERT INTO vino_pays_description VALUES(43, 5, 2, 'Armenia (Republic of');
INSERT INTO vino_pays_description VALUES(44, 6, 2, 'Australia');
INSERT INTO vino_pays_description VALUES(45, 7, 2, 'Austria');
INSERT INTO vino_pays_description VALUES(46, 8, 2, 'Brazil');
INSERT INTO vino_pays_description VALUES(47, 9, 2, 'Bulgaria');
INSERT INTO vino_pays_description VALUES(48, 10, 2, 'Canada');
INSERT INTO vino_pays_description VALUES(49, 11, 2, 'Chile');
INSERT INTO vino_pays_description VALUES(50, 12, 2, 'Croatia');
INSERT INTO vino_pays_description VALUES(51, 13, 2, 'Spain');
INSERT INTO vino_pays_description VALUES(52, 14, 2, 'United States');
INSERT INTO vino_pays_description VALUES(53, 15, 2, 'France');
INSERT INTO vino_pays_description VALUES(54, 16, 2, 'Georgia');
INSERT INTO vino_pays_description VALUES(55, 17, 2, 'Greece');
INSERT INTO vino_pays_description VALUES(56, 18, 2, 'Hungary');
INSERT INTO vino_pays_description VALUES(57, 19, 2, 'India');
INSERT INTO vino_pays_description VALUES(58, 20, 2, 'Israel');
INSERT INTO vino_pays_description VALUES(59, 21, 2, 'Italy');
INSERT INTO vino_pays_description VALUES(60, 22, 2, 'Lebanon');
INSERT INTO vino_pays_description VALUES(61, 23, 2, 'Luxembourg ');
INSERT INTO vino_pays_description VALUES(62, 24, 2, 'Macedonia');
INSERT INTO vino_pays_description VALUES(63, 25, 2, 'Morocco');
INSERT INTO vino_pays_description VALUES(64, 26, 2, 'Mexico');
INSERT INTO vino_pays_description VALUES(65, 27, 2, 'Moldova ');
INSERT INTO vino_pays_description VALUES(66, 28, 2, 'New Zealand');
INSERT INTO vino_pays_description VALUES(67, 29, 2, 'Peru');
INSERT INTO vino_pays_description VALUES(68, 30, 2, 'Portugal');
INSERT INTO vino_pays_description VALUES(69, 31, 2, 'Czech republic');
INSERT INTO vino_pays_description VALUES(70, 32, 2, 'Romania');
INSERT INTO vino_pays_description VALUES(71, 33, 2, 'United Kingdom');
INSERT INTO vino_pays_description VALUES(72, 34, 2, 'Slovakia');
INSERT INTO vino_pays_description VALUES(73, 35, 2, 'Swiss');
INSERT INTO vino_pays_description VALUES(74, 36, 2, 'Tunisia ');
INSERT INTO vino_pays_description VALUES(75, 37, 2, 'Turkey');
INSERT INTO vino_pays_description VALUES(76, 38, 2, 'Uruguay');

INSERT INTO vino_region VALUES(1, 1);
INSERT INTO vino_region VALUES(2, 3);
INSERT INTO vino_region VALUES(3, 3);
INSERT INTO vino_region VALUES(4, 3);
INSERT INTO vino_region VALUES(5, 3);
INSERT INTO vino_region VALUES(6, 3);
INSERT INTO vino_region VALUES(7, 3);
INSERT INTO vino_region VALUES(8, 3);
INSERT INTO vino_region VALUES(9, 3);
INSERT INTO vino_region VALUES(10, 3);
INSERT INTO vino_region VALUES(11, 4);
INSERT INTO vino_region VALUES(12, 4);
INSERT INTO vino_region VALUES(13, 4);
INSERT INTO vino_region VALUES(14, 4);
INSERT INTO vino_region VALUES(15, 4);
INSERT INTO vino_region VALUES(16, 4);
INSERT INTO vino_region VALUES(17, 4);
INSERT INTO vino_region VALUES(18, 4);
INSERT INTO vino_region VALUES(19, 6);
INSERT INTO vino_region VALUES(20, 6);
INSERT INTO vino_region VALUES(21, 6);
INSERT INTO vino_region VALUES(22, 6);
INSERT INTO vino_region VALUES(23, 6);
INSERT INTO vino_region VALUES(24, 6);
INSERT INTO vino_region VALUES(25, 7);
INSERT INTO vino_region VALUES(26, 7);
INSERT INTO vino_region VALUES(27, 7);
INSERT INTO vino_region VALUES(28, 8);
INSERT INTO vino_region VALUES(29, 8);
INSERT INTO vino_region VALUES(30, 9);
INSERT INTO vino_region VALUES(31, 9);
INSERT INTO vino_region VALUES(32, 10);
INSERT INTO vino_region VALUES(33, 10);
INSERT INTO vino_region VALUES(34, 10);
INSERT INTO vino_region VALUES(35, 10);
INSERT INTO vino_region VALUES(36, 10);
INSERT INTO vino_region VALUES(37, 10);
INSERT INTO vino_region VALUES(38, 10);
INSERT INTO vino_region VALUES(39, 11);
INSERT INTO vino_region VALUES(40, 11);
INSERT INTO vino_region VALUES(41, 11);
INSERT INTO vino_region VALUES(42, 11);
INSERT INTO vino_region VALUES(43, 11);
INSERT INTO vino_region VALUES(44, 12);
INSERT INTO vino_region VALUES(45, 13);
INSERT INTO vino_region VALUES(46, 13);
INSERT INTO vino_region VALUES(47, 13);
INSERT INTO vino_region VALUES(48, 13);
INSERT INTO vino_region VALUES(49, 13);
INSERT INTO vino_region VALUES(50, 13);
INSERT INTO vino_region VALUES(51, 13);
INSERT INTO vino_region VALUES(52, 14);
INSERT INTO vino_region VALUES(53, 14);
INSERT INTO vino_region VALUES(54, 14);
INSERT INTO vino_region VALUES(55, 14);
INSERT INTO vino_region VALUES(56, 14);
INSERT INTO vino_region VALUES(57, 14);
INSERT INTO vino_region VALUES(58, 14);
INSERT INTO vino_region VALUES(59, 14);
INSERT INTO vino_region VALUES(60, 14);
INSERT INTO vino_region VALUES(61, 14);
INSERT INTO vino_region VALUES(62, 14);
INSERT INTO vino_region VALUES(63, 14);
INSERT INTO vino_region VALUES(64, 14);
INSERT INTO vino_region VALUES(65, 14);
INSERT INTO vino_region VALUES(66, 14);
INSERT INTO vino_region VALUES(67, 14);
INSERT INTO vino_region VALUES(68, 14);
INSERT INTO vino_region VALUES(69, 14);
INSERT INTO vino_region VALUES(70, 14);
INSERT INTO vino_region VALUES(71, 14);
INSERT INTO vino_region VALUES(72, 14);
INSERT INTO vino_region VALUES(73, 14);
INSERT INTO vino_region VALUES(74, 14);
INSERT INTO vino_region VALUES(75, 14);
INSERT INTO vino_region VALUES(76, 15);
INSERT INTO vino_region VALUES(77, 15);
INSERT INTO vino_region VALUES(78, 15);
INSERT INTO vino_region VALUES(79, 15);
INSERT INTO vino_region VALUES(80, 15);
INSERT INTO vino_region VALUES(81, 15);
INSERT INTO vino_region VALUES(82, 15);
INSERT INTO vino_region VALUES(83, 15);
INSERT INTO vino_region VALUES(84, 15);
INSERT INTO vino_region VALUES(85, 15);
INSERT INTO vino_region VALUES(86, 15);
INSERT INTO vino_region VALUES(87, 15);
INSERT INTO vino_region VALUES(88, 15);
INSERT INTO vino_region VALUES(89, 15);
INSERT INTO vino_region VALUES(90, 15);
INSERT INTO vino_region VALUES(91, 15);
INSERT INTO vino_region VALUES(92, 15);
INSERT INTO vino_region VALUES(93, 15);
INSERT INTO vino_region VALUES(94, 15);
INSERT INTO vino_region VALUES(95, 17);
INSERT INTO vino_region VALUES(96, 17);
INSERT INTO vino_region VALUES(97, 17);
INSERT INTO vino_region VALUES(98, 17);
INSERT INTO vino_region VALUES(99, 17);
INSERT INTO vino_region VALUES(100, 17);
INSERT INTO vino_region VALUES(101, 17);
INSERT INTO vino_region VALUES(102, 17);
INSERT INTO vino_region VALUES(103, 18);
INSERT INTO vino_region VALUES(104, 18);
INSERT INTO vino_region VALUES(105, 19);
INSERT INTO vino_region VALUES(106, 20);
INSERT INTO vino_region VALUES(107, 20);
INSERT INTO vino_region VALUES(108, 20);
INSERT INTO vino_region VALUES(109, 20);
INSERT INTO vino_region VALUES(110, 21);
INSERT INTO vino_region VALUES(111, 21);
INSERT INTO vino_region VALUES(112, 21);
INSERT INTO vino_region VALUES(113, 21);
INSERT INTO vino_region VALUES(114, 21);
INSERT INTO vino_region VALUES(115, 21);
INSERT INTO vino_region VALUES(116, 21);
INSERT INTO vino_region VALUES(117, 21);
INSERT INTO vino_region VALUES(118, 21);
INSERT INTO vino_region VALUES(119, 21);
INSERT INTO vino_region VALUES(120, 21);
INSERT INTO vino_region VALUES(121, 21);
INSERT INTO vino_region VALUES(122, 21);
INSERT INTO vino_region VALUES(123, 21);
INSERT INTO vino_region VALUES(124, 21);
INSERT INTO vino_region VALUES(125, 21);
INSERT INTO vino_region VALUES(126, 21);
INSERT INTO vino_region VALUES(127, 21);
INSERT INTO vino_region VALUES(128, 21);
INSERT INTO vino_region VALUES(129, 22);
INSERT INTO vino_region VALUES(130, 23);
INSERT INTO vino_region VALUES(131, 28);
INSERT INTO vino_region VALUES(132, 28);
INSERT INTO vino_region VALUES(133, 30);
INSERT INTO vino_region VALUES(134, 30);
INSERT INTO vino_region VALUES(135, 30);
INSERT INTO vino_region VALUES(136, 30);
INSERT INTO vino_region VALUES(137, 30);
INSERT INTO vino_region VALUES(138, 30);
INSERT INTO vino_region VALUES(139, 30);
INSERT INTO vino_region VALUES(140, 30);
INSERT INTO vino_region VALUES(141, 30);
INSERT INTO vino_region VALUES(142, 30);
INSERT INTO vino_region VALUES(143, 30);
INSERT INTO vino_region VALUES(144, 32);
INSERT INTO vino_region VALUES(145, 32);
INSERT INTO vino_region VALUES(146, 33);
INSERT INTO vino_region VALUES(147, 33);
INSERT INTO vino_region VALUES(148, 33);
INSERT INTO vino_region VALUES(149, 33);
INSERT INTO vino_region VALUES(150, 34);
INSERT INTO vino_region VALUES(151, 35);
INSERT INTO vino_region VALUES(152, 38);
INSERT INTO vino_region VALUES(153, 38);
INSERT INTO vino_region VALUES(154, 38);
INSERT INTO vino_region VALUES(155, 38);

INSERT INTO vino_region_description VALUES(1, 1, 1, 'Western Cape');
INSERT INTO vino_region_description VALUES(2, 2, 1, 'Baden');
INSERT INTO vino_region_description VALUES(3, 3, 1, 'Franken');
INSERT INTO vino_region_description VALUES(4, 4, 1, 'Mosel');
INSERT INTO vino_region_description VALUES(5, 5, 1, 'Nahe');
INSERT INTO vino_region_description VALUES(6, 6, 1, 'Pfalz');
INSERT INTO vino_region_description VALUES(7, 7, 1, 'Rhein');
INSERT INTO vino_region_description VALUES(8, 8, 1, 'Rheingau');
INSERT INTO vino_region_description VALUES(9, 9, 1, 'Rheinhessen');
INSERT INTO vino_region_description VALUES(10, 10, 1, 'Rheinischer');
INSERT INTO vino_region_description VALUES(11, 11, 1, 'Buenos Aires');
INSERT INTO vino_region_description VALUES(12, 12, 1, 'La Rioja');
INSERT INTO vino_region_description VALUES(13, 13, 1, 'Mendoza');
INSERT INTO vino_region_description VALUES(14, 14, 1, 'Patagonia');
INSERT INTO vino_region_description VALUES(15, 15, 1, 'Rio Negro');
INSERT INTO vino_region_description VALUES(16, 16, 1, 'Salta');
INSERT INTO vino_region_description VALUES(17, 17, 1, 'San Juan');
INSERT INTO vino_region_description VALUES(18, 18, 1, 'Valles Calchaquíes');
INSERT INTO vino_region_description VALUES(19, 19, 1, 'Australie-Méridionale');
INSERT INTO vino_region_description VALUES(20, 20, 1, 'Australie Occidentale');
INSERT INTO vino_region_description VALUES(21, 21, 1, 'Nouvelle-Galles du Sud');
INSERT INTO vino_region_description VALUES(22, 22, 1, 'South Eastern Australia');
INSERT INTO vino_region_description VALUES(23, 23, 1, 'Tasmanie');
INSERT INTO vino_region_description VALUES(24, 24, 1, 'Victoria');
INSERT INTO vino_region_description VALUES(25, 25, 1, 'Basse-Autriche (Niederösterreich)');
INSERT INTO vino_region_description VALUES(26, 26, 1, 'Burgenland');
INSERT INTO vino_region_description VALUES(27, 27, 1, 'Styrie (Steiermark)');
INSERT INTO vino_region_description VALUES(28, 28, 1, 'Campanha (Fronteira)');
INSERT INTO vino_region_description VALUES(29, 29, 1, 'Serra Gaúcha');
INSERT INTO vino_region_description VALUES(30, 30, 1, 'Plaines du Danube');
INSERT INTO vino_region_description VALUES(31, 31, 1, 'Thracian Valley');
INSERT INTO vino_region_description VALUES(32, 32, 1, 'Alberta');
INSERT INTO vino_region_description VALUES(33, 33, 1, 'Colombie-Britannique');
INSERT INTO vino_region_description VALUES(34, 34, 1, 'Nouvelle-Écosse');
INSERT INTO vino_region_description VALUES(35, 35, 1, 'Ontario');
INSERT INTO vino_region_description VALUES(36, 36, 1, 'Québec');
INSERT INTO vino_region_description VALUES(37, 37, 1, 'Terre-Neuve-et-Labrador');
INSERT INTO vino_region_description VALUES(38, 38, 1, 'Yukon');
INSERT INTO vino_region_description VALUES(39, 39, 1, 'Aconcagua');
INSERT INTO vino_region_description VALUES(40, 40, 1, 'Atacama');
INSERT INTO vino_region_description VALUES(41, 41, 1, 'Coquimbo');
INSERT INTO vino_region_description VALUES(42, 42, 1, 'Del Sur');
INSERT INTO vino_region_description VALUES(43, 43, 1, 'Valle Central');
INSERT INTO vino_region_description VALUES(44, 44, 1, 'Istra');
INSERT INTO vino_region_description VALUES(45, 45, 1, 'Andalousie');
INSERT INTO vino_region_description VALUES(46, 46, 1, 'Côte Méditerranéenne');
INSERT INTO vino_region_description VALUES(47, 47, 1, 'L’Espagne Verte');
INSERT INTO vino_region_description VALUES(48, 48, 1, 'Le Plateau (Meseta)');
INSERT INTO vino_region_description VALUES(49, 49, 1, 'Les Iles');
INSERT INTO vino_region_description VALUES(50, 50, 1, 'Vallée de l’Ebre');
INSERT INTO vino_region_description VALUES(51, 51, 1, 'Vallée du Duero');
INSERT INTO vino_region_description VALUES(52, 52, 1, 'Arizona');
INSERT INTO vino_region_description VALUES(53, 53, 1, 'Californie');
INSERT INTO vino_region_description VALUES(54, 54, 1, 'Connecticut');
INSERT INTO vino_region_description VALUES(55, 55, 1, 'Floride');
INSERT INTO vino_region_description VALUES(56, 56, 1, 'Georgie');
INSERT INTO vino_region_description VALUES(57, 57, 1, 'Illinois');
INSERT INTO vino_region_description VALUES(58, 58, 1, 'Indiana');
INSERT INTO vino_region_description VALUES(59, 59, 1, 'Iowa');
INSERT INTO vino_region_description VALUES(60, 60, 1, 'Kentucky');
INSERT INTO vino_region_description VALUES(61, 61, 1, 'Louisiane');
INSERT INTO vino_region_description VALUES(62, 62, 1, 'Maryland');
INSERT INTO vino_region_description VALUES(63, 63, 1, 'Michigan');
INSERT INTO vino_region_description VALUES(64, 64, 1, 'Minnesota');
INSERT INTO vino_region_description VALUES(65, 65, 1, 'Missouri');
INSERT INTO vino_region_description VALUES(66, 66, 1, 'New-Jersey');
INSERT INTO vino_region_description VALUES(67, 67, 1, 'New-York');
INSERT INTO vino_region_description VALUES(68, 68, 1, 'Oregon');
INSERT INTO vino_region_description VALUES(69, 69, 1, 'Pennsylvanie');
INSERT INTO vino_region_description VALUES(70, 70, 1, 'Tennessee');
INSERT INTO vino_region_description VALUES(71, 71, 1, 'Texas');
INSERT INTO vino_region_description VALUES(72, 72, 1, 'Vermont');
INSERT INTO vino_region_description VALUES(73, 73, 1, 'Virginie');
INSERT INTO vino_region_description VALUES(74, 74, 1, 'Washington');
INSERT INTO vino_region_description VALUES(75, 75, 1, 'Wisconsin');
INSERT INTO vino_region_description VALUES(76, 76, 1, 'Alsace');
INSERT INTO vino_region_description VALUES(77, 77, 1, 'Aquitaine-Charentes');
INSERT INTO vino_region_description VALUES(78, 78, 1, 'Beaujolais');
INSERT INTO vino_region_description VALUES(79, 79, 1, 'Bordeaux');
INSERT INTO vino_region_description VALUES(80, 80, 1, 'Bourgogne');
INSERT INTO vino_region_description VALUES(81, 81, 1, 'Centre-Ouest');
INSERT INTO vino_region_description VALUES(82, 82, 1, 'Champagne');
INSERT INTO vino_region_description VALUES(83, 83, 1, 'Corse');
INSERT INTO vino_region_description VALUES(84, 84, 1, 'Jura');
INSERT INTO vino_region_description VALUES(85, 85, 1, 'Languedoc-Roussillon');
INSERT INTO vino_region_description VALUES(86, 86, 1, 'Nord-Est');
INSERT INTO vino_region_description VALUES(87, 87, 1, 'Normandie');
INSERT INTO vino_region_description VALUES(88, 88, 1, 'Poitou-Charentes');
INSERT INTO vino_region_description VALUES(89, 89, 1, 'Provence');
INSERT INTO vino_region_description VALUES(90, 90, 1, 'Savoie et Bugey');
INSERT INTO vino_region_description VALUES(91, 91, 1, 'Sud-Est');
INSERT INTO vino_region_description VALUES(92, 92, 1, 'Sud-Ouest');
INSERT INTO vino_region_description VALUES(93, 93, 1, 'Vallée de la Loire');
INSERT INTO vino_region_description VALUES(94, 94, 1, 'Vallée du Rhône');
INSERT INTO vino_region_description VALUES(95, 95, 1, 'Crète');
INSERT INTO vino_region_description VALUES(96, 96, 1, 'Epirus');
INSERT INTO vino_region_description VALUES(97, 97, 1, 'Iles de la mer Égée');
INSERT INTO vino_region_description VALUES(98, 98, 1, 'Iles Ioniennes');
INSERT INTO vino_region_description VALUES(99, 99, 1, 'Macédoine');
INSERT INTO vino_region_description VALUES(100, 100, 1, 'Peloponnèse');
INSERT INTO vino_region_description VALUES(101, 101, 1, 'Sterea Ellada / Centre / Ile d’Eubee');
INSERT INTO vino_region_description VALUES(102, 102, 1, 'Thessalia');
INSERT INTO vino_region_description VALUES(103, 103, 1, 'Balaton');
INSERT INTO vino_region_description VALUES(104, 104, 1, 'Tokai');
INSERT INTO vino_region_description VALUES(105, 105, 1, 'Maharashtra');
INSERT INTO vino_region_description VALUES(106, 106, 1, 'Galilée (Galil)');
INSERT INTO vino_region_description VALUES(107, 107, 1, 'Judean Hills');
INSERT INTO vino_region_description VALUES(108, 108, 1, 'Samarie (Shomron)');
INSERT INTO vino_region_description VALUES(109, 109, 1, 'Samson');
INSERT INTO vino_region_description VALUES(110, 110, 1, 'Abruzzes');
INSERT INTO vino_region_description VALUES(111, 111, 1, 'Basilicate');
INSERT INTO vino_region_description VALUES(112, 112, 1, 'Calabre');
INSERT INTO vino_region_description VALUES(113, 113, 1, 'Campanie');
INSERT INTO vino_region_description VALUES(114, 114, 1, 'Émilie-Romagne');
INSERT INTO vino_region_description VALUES(115, 115, 1, 'Frioul-Vénétie Julienne');
INSERT INTO vino_region_description VALUES(116, 116, 1, 'Latium');
INSERT INTO vino_region_description VALUES(117, 117, 1, 'Les Marches');
INSERT INTO vino_region_description VALUES(118, 118, 1, 'Les Pouilles');
INSERT INTO vino_region_description VALUES(119, 119, 1, 'Lombardie');
INSERT INTO vino_region_description VALUES(120, 120, 1, 'Molise');
INSERT INTO vino_region_description VALUES(121, 121, 1, 'Ombrie');
INSERT INTO vino_region_description VALUES(122, 122, 1, 'Piémont');
INSERT INTO vino_region_description VALUES(123, 123, 1, 'Sardaigne');
INSERT INTO vino_region_description VALUES(124, 124, 1, 'Sicile');
INSERT INTO vino_region_description VALUES(125, 125, 1, 'Toscane');
INSERT INTO vino_region_description VALUES(126, 126, 1, 'Trentin Haut-Adige');
INSERT INTO vino_region_description VALUES(127, 127, 1, 'Vallée d’Aoste');
INSERT INTO vino_region_description VALUES(128, 128, 1, 'Vénétie');
INSERT INTO vino_region_description VALUES(129, 129, 1, 'Vallée de la Bekaa');
INSERT INTO vino_region_description VALUES(130, 130, 1, 'Moselle');
INSERT INTO vino_region_description VALUES(131, 131, 1, 'North Island');
INSERT INTO vino_region_description VALUES(132, 132, 1, 'South Island');
INSERT INTO vino_region_description VALUES(133, 133, 1, 'Alentejo');
INSERT INTO vino_region_description VALUES(134, 134, 1, 'Bairrada');
INSERT INTO vino_region_description VALUES(135, 135, 1, 'Beira');
INSERT INTO vino_region_description VALUES(136, 136, 1, 'Beira Interior');
INSERT INTO vino_region_description VALUES(137, 137, 1, 'Dâo E Lafôes');
INSERT INTO vino_region_description VALUES(138, 138, 1, 'Lisboa');
INSERT INTO vino_region_description VALUES(139, 139, 1, 'Madeira');
INSERT INTO vino_region_description VALUES(140, 140, 1, 'Péninsule de Setúbal');
INSERT INTO vino_region_description VALUES(141, 141, 1, 'Porto/Douro');
INSERT INTO vino_region_description VALUES(142, 142, 1, 'Tejo');
INSERT INTO vino_region_description VALUES(143, 143, 1, 'Vinho Verde');
INSERT INTO vino_region_description VALUES(144, 144, 1, 'Dealu Mare');
INSERT INTO vino_region_description VALUES(145, 145, 1, 'Recas');
INSERT INTO vino_region_description VALUES(146, 146, 1, 'Angleterre');
INSERT INTO vino_region_description VALUES(147, 147, 1, 'Écosse');
INSERT INTO vino_region_description VALUES(148, 148, 1, 'Irlande du nord');
INSERT INTO vino_region_description VALUES(149, 149, 1, 'Pays de Galles');
INSERT INTO vino_region_description VALUES(150, 150, 1, 'Little Carpathians');
INSERT INTO vino_region_description VALUES(151, 151, 1, 'Valais');
INSERT INTO vino_region_description VALUES(152, 152, 1, 'Canelones');
INSERT INTO vino_region_description VALUES(153, 153, 1, 'Colonia');
INSERT INTO vino_region_description VALUES(154, 154, 1, 'Paysandu');
INSERT INTO vino_region_description VALUES(155, 155, 1, 'Rivera');
INSERT INTO vino_region_description VALUES(156, 1, 2, 'Western Cape');
INSERT INTO vino_region_description VALUES(157, 2, 2, 'Baden');
INSERT INTO vino_region_description VALUES(158, 3, 2, 'Franken');
INSERT INTO vino_region_description VALUES(159, 4, 2, 'Mosel');
INSERT INTO vino_region_description VALUES(160, 5, 2, 'Nahe');
INSERT INTO vino_region_description VALUES(161, 6, 2, 'Pfalz');
INSERT INTO vino_region_description VALUES(162, 7, 2, 'Rhein');
INSERT INTO vino_region_description VALUES(163, 8, 2, 'Rheingau');
INSERT INTO vino_region_description VALUES(164, 9, 2, 'Rheinhessen');
INSERT INTO vino_region_description VALUES(165, 10, 2, 'Rheinischer');
INSERT INTO vino_region_description VALUES(166, 11, 2, 'Buenos Aires');
INSERT INTO vino_region_description VALUES(167, 12, 2, 'La Rioja');
INSERT INTO vino_region_description VALUES(168, 13, 2, 'Mendoza');
INSERT INTO vino_region_description VALUES(169, 14, 2, 'Patagonia');
INSERT INTO vino_region_description VALUES(170, 15, 2, 'Rio Negro');
INSERT INTO vino_region_description VALUES(171, 16, 2, 'Salta');
INSERT INTO vino_region_description VALUES(172, 17, 2, 'San Juan');
INSERT INTO vino_region_description VALUES(173, 18, 2, 'Valles Calchaquíes');
INSERT INTO vino_region_description VALUES(174, 19, 2, 'South Australia');
INSERT INTO vino_region_description VALUES(175, 20, 2, 'Western Australia');
INSERT INTO vino_region_description VALUES(176, 21, 2, 'New South Wales');
INSERT INTO vino_region_description VALUES(177, 22, 2, 'South Eastern Australia');
INSERT INTO vino_region_description VALUES(178, 23, 2, 'Tasmanie');
INSERT INTO vino_region_description VALUES(179, 24, 2, 'Victoria');
INSERT INTO vino_region_description VALUES(180, 25, 2, 'Niederösterreich');
INSERT INTO vino_region_description VALUES(181, 26, 2, 'Burgenland');
INSERT INTO vino_region_description VALUES(182, 27, 2, 'Steiermark');
INSERT INTO vino_region_description VALUES(183, 28, 2, 'Campanha (Fronteira)');
INSERT INTO vino_region_description VALUES(184, 29, 2, 'Serra Gaúcha');
INSERT INTO vino_region_description VALUES(185, 30, 2, 'Danubian Plain');
INSERT INTO vino_region_description VALUES(186, 31, 2, 'Thracian Valley');
INSERT INTO vino_region_description VALUES(187, 32, 2, 'Alberta');
INSERT INTO vino_region_description VALUES(188, 33, 2, 'British Columbia');
INSERT INTO vino_region_description VALUES(189, 34, 2, 'Nova Scotia');
INSERT INTO vino_region_description VALUES(190, 35, 2, 'Ontario');
INSERT INTO vino_region_description VALUES(191, 36, 2, 'Quebec');
INSERT INTO vino_region_description VALUES(192, 37, 2, 'Newfoundland and Labrador');
INSERT INTO vino_region_description VALUES(193, 38, 2, 'Yukon');
INSERT INTO vino_region_description VALUES(194, 39, 2, 'Aconcagua');
INSERT INTO vino_region_description VALUES(195, 40, 2, 'Atacama');
INSERT INTO vino_region_description VALUES(196, 41, 2, 'Coquimbo');
INSERT INTO vino_region_description VALUES(197, 42, 2, 'Del Sur');
INSERT INTO vino_region_description VALUES(198, 43, 2, 'Valle Central');
INSERT INTO vino_region_description VALUES(199, 44, 2, 'Istra');
INSERT INTO vino_region_description VALUES(200, 45, 2, 'Andaloucia');
INSERT INTO vino_region_description VALUES(201, 46, 2, 'Côte Méditerranéenne');
INSERT INTO vino_region_description VALUES(202, 47, 2, 'L’Espagne Verte');
INSERT INTO vino_region_description VALUES(203, 48, 2, 'Le Plateau (Meseta)');
INSERT INTO vino_region_description VALUES(204, 49, 2, 'Les Iles');
INSERT INTO vino_region_description VALUES(205, 50, 2, 'Vallée de l’Ebre');
INSERT INTO vino_region_description VALUES(206, 51, 2, 'Vallée du Duero');
INSERT INTO vino_region_description VALUES(207, 52, 2, 'Arizona');
INSERT INTO vino_region_description VALUES(208, 53, 2, 'California');
INSERT INTO vino_region_description VALUES(209, 54, 2, 'Connecticut');
INSERT INTO vino_region_description VALUES(210, 55, 2, 'Florida');
INSERT INTO vino_region_description VALUES(211, 56, 2, 'Georgia');
INSERT INTO vino_region_description VALUES(212, 57, 2, 'Illinois');
INSERT INTO vino_region_description VALUES(213, 58, 2, 'Indiana');
INSERT INTO vino_region_description VALUES(214, 59, 2, 'Iowa');
INSERT INTO vino_region_description VALUES(215, 60, 2, 'Kentucky');
INSERT INTO vino_region_description VALUES(216, 61, 2, 'Louisiana');
INSERT INTO vino_region_description VALUES(217, 62, 2, 'Maryland');
INSERT INTO vino_region_description VALUES(218, 63, 2, 'Michigan');
INSERT INTO vino_region_description VALUES(219, 64, 2, 'Minnesota');
INSERT INTO vino_region_description VALUES(220, 65, 2, 'Missouri');
INSERT INTO vino_region_description VALUES(221, 66, 2, 'New-Jersey');
INSERT INTO vino_region_description VALUES(222, 67, 2, 'New-York');
INSERT INTO vino_region_description VALUES(223, 68, 2, 'Oregon');
INSERT INTO vino_region_description VALUES(224, 69, 2, 'Pennsylvanie');
INSERT INTO vino_region_description VALUES(225, 70, 2, 'Tennessee');
INSERT INTO vino_region_description VALUES(226, 71, 2, 'Texas');
INSERT INTO vino_region_description VALUES(227, 72, 2, 'Vermont');
INSERT INTO vino_region_description VALUES(228, 73, 2, 'Virginie');
INSERT INTO vino_region_description VALUES(229, 74, 2, 'Washington');
INSERT INTO vino_region_description VALUES(230, 75, 2, 'Wisconsin');
INSERT INTO vino_region_description VALUES(231, 76, 2, 'Alsace');
INSERT INTO vino_region_description VALUES(232, 77, 2, 'Aquitaine-Charentes');
INSERT INTO vino_region_description VALUES(233, 78, 2, 'Beaujolais');
INSERT INTO vino_region_description VALUES(234, 79, 2, 'Bordeaux');
INSERT INTO vino_region_description VALUES(235, 80, 2, 'Bourgogne');
INSERT INTO vino_region_description VALUES(236, 81, 2, 'Centre-Ouest');
INSERT INTO vino_region_description VALUES(237, 82, 2, 'Champagne');
INSERT INTO vino_region_description VALUES(238, 83, 2, 'Corse');
INSERT INTO vino_region_description VALUES(239, 84, 2, 'Jura');
INSERT INTO vino_region_description VALUES(240, 85, 2, 'Languedoc-Roussillon');
INSERT INTO vino_region_description VALUES(241, 86, 2, 'Nord-Est');
INSERT INTO vino_region_description VALUES(242, 87, 2, 'Normandie');
INSERT INTO vino_region_description VALUES(243, 88, 2, 'Poitou-Charentes');
INSERT INTO vino_region_description VALUES(244, 89, 2, 'Provence');
INSERT INTO vino_region_description VALUES(245, 90, 2, 'Savoie et Bugey');
INSERT INTO vino_region_description VALUES(246, 91, 2, 'Sud-Est');
INSERT INTO vino_region_description VALUES(247, 92, 2, 'Sud-Ouest');
INSERT INTO vino_region_description VALUES(248, 93, 2, 'Vallée de la Loire');
INSERT INTO vino_region_description VALUES(249, 94, 2, 'Vallée du Rhône');
INSERT INTO vino_region_description VALUES(250, 95, 2, 'Crete');
INSERT INTO vino_region_description VALUES(251, 96, 2, 'Epirus');
INSERT INTO vino_region_description VALUES(252, 97, 2, 'Aegean islands');
INSERT INTO vino_region_description VALUES(253, 98, 2, 'Ionian islands');
INSERT INTO vino_region_description VALUES(254, 99, 2, 'Macedoine');
INSERT INTO vino_region_description VALUES(255, 100, 2, 'Peloponnese');
INSERT INTO vino_region_description VALUES(256, 101, 2, 'Sterea Ellada / Central Greece');
INSERT INTO vino_region_description VALUES(257, 102, 2, 'Thessalia');
INSERT INTO vino_region_description VALUES(258, 103, 2, 'Balaton');
INSERT INTO vino_region_description VALUES(259, 104, 2, 'Tokai');
INSERT INTO vino_region_description VALUES(260, 105, 2, 'Maharashtra');
INSERT INTO vino_region_description VALUES(261, 106, 2, 'Galilée (Galil)');
INSERT INTO vino_region_description VALUES(262, 107, 2, 'Judean Hills');
INSERT INTO vino_region_description VALUES(263, 108, 2, 'Samarie (Shomron)');
INSERT INTO vino_region_description VALUES(264, 109, 2, 'Samson');
INSERT INTO vino_region_description VALUES(265, 110, 2, 'Abruzzi');
INSERT INTO vino_region_description VALUES(266, 111, 2, 'Basilicata');
INSERT INTO vino_region_description VALUES(267, 112, 2, 'Calabria');
INSERT INTO vino_region_description VALUES(268, 113, 2, 'Campania');
INSERT INTO vino_region_description VALUES(269, 114, 2, 'Emilia-Romagna');
INSERT INTO vino_region_description VALUES(270, 115, 2, 'Friuli-Venezia Giulia');
INSERT INTO vino_region_description VALUES(271, 116, 2, 'Lazio');
INSERT INTO vino_region_description VALUES(272, 117, 2, 'The Marches');
INSERT INTO vino_region_description VALUES(273, 118, 2, 'Puglia');
INSERT INTO vino_region_description VALUES(274, 119, 2, 'Lombardy');
INSERT INTO vino_region_description VALUES(275, 120, 2, 'Molise');
INSERT INTO vino_region_description VALUES(276, 121, 2, 'Umbria');
INSERT INTO vino_region_description VALUES(277, 122, 2, 'Piedmont');
INSERT INTO vino_region_description VALUES(278, 123, 2, 'Sardinia');
INSERT INTO vino_region_description VALUES(279, 124, 2, 'Sicily');
INSERT INTO vino_region_description VALUES(280, 125, 2, 'Tuscany');
INSERT INTO vino_region_description VALUES(281, 126, 2, 'Trentino Alto Adige');
INSERT INTO vino_region_description VALUES(282, 127, 2, 'Valle d’Aosta');
INSERT INTO vino_region_description VALUES(283, 128, 2, 'Veneto');
INSERT INTO vino_region_description VALUES(284, 129, 2, 'Vallée de la Bekaa');
INSERT INTO vino_region_description VALUES(285, 130, 2, 'Moselle');
INSERT INTO vino_region_description VALUES(286, 131, 2, 'North Island');
INSERT INTO vino_region_description VALUES(287, 132, 2, 'South Island');
INSERT INTO vino_region_description VALUES(288, 133, 2, 'Alentejo');
INSERT INTO vino_region_description VALUES(289, 134, 2, 'Bairrada');
INSERT INTO vino_region_description VALUES(290, 135, 2, 'Beira');
INSERT INTO vino_region_description VALUES(291, 136, 2, 'Beira Interior');
INSERT INTO vino_region_description VALUES(292, 137, 2, 'Dâo E Lafôes');
INSERT INTO vino_region_description VALUES(293, 138, 2, 'Lisboa');
INSERT INTO vino_region_description VALUES(294, 139, 2, 'Madeira');
INSERT INTO vino_region_description VALUES(295, 140, 2, 'Setúbal Peninsul');
INSERT INTO vino_region_description VALUES(296, 141, 2, 'Porto/Douro');
INSERT INTO vino_region_description VALUES(297, 142, 2, 'Tejo');
INSERT INTO vino_region_description VALUES(298, 143, 2, 'Vinho Verde');
INSERT INTO vino_region_description VALUES(299, 144, 2, 'Dealu Mare');
INSERT INTO vino_region_description VALUES(300, 145, 2, 'Recas');
INSERT INTO vino_region_description VALUES(301, 146, 2, 'England');
INSERT INTO vino_region_description VALUES(302, 147, 2, 'Scotland');
INSERT INTO vino_region_description VALUES(303, 148, 2, 'North Ireland');
INSERT INTO vino_region_description VALUES(304, 149, 2, 'Wales');
INSERT INTO vino_region_description VALUES(305, 150, 2, 'Little Carpathians');
INSERT INTO vino_region_description VALUES(306, 151, 2, 'Valais');
INSERT INTO vino_region_description VALUES(307, 152, 2, 'Canelones');
INSERT INTO vino_region_description VALUES(308, 153, 2, 'Colonia');
INSERT INTO vino_region_description VALUES(309, 154, 2, 'Paysandu');
INSERT INTO vino_region_description VALUES(310, 155, 2, 'Rivera');

INSERT INTO vino_couleur VALUES(1);
INSERT INTO vino_couleur VALUES(2);
INSERT INTO vino_couleur VALUES(3);

INSERT INTO vino_couleur_description VALUES(1, 1, 1, 'vin blanc');
INSERT INTO vino_couleur_description VALUES(2, 2, 1, 'vin rosé');
INSERT INTO vino_couleur_description VALUES(3, 3, 1, 'vin rouge');
INSERT INTO vino_couleur_description VALUES(4, 1, 2, 'white wine');
INSERT INTO vino_couleur_description VALUES(5, 2, 2, 'rosé');
INSERT INTO vino_couleur_description VALUES(6, 3, 2, 'red wine');

INSERT INTO vino_format VALUES(1, 250, 'ml');
INSERT INTO vino_format VALUES(2, 375, 'ml');
INSERT INTO vino_format VALUES(3, 500, 'ml');
INSERT INTO vino_format VALUES(4, 620, 'ml');
INSERT INTO vino_format VALUES(5, 750, 'ml');
INSERT INTO vino_format VALUES(6, 1, 'L');
INSERT INTO vino_format VALUES(7, 1.5, 'L');
INSERT INTO vino_format VALUES(8, 3, 'L');
INSERT INTO vino_format VALUES(9, 4, 'L');
INSERT INTO vino_format VALUES(10, 4.5, 'L');
INSERT INTO vino_format VALUES(11, 5, 'L');
INSERT INTO vino_format VALUES(12, 6, 'L');

-- https://passwordsgenerator.net/sha512-hash-generator/
INSERT INTO vino_usager VALUES(1, 1, true, 'admin', 'admin@courriel.qc.ca', '3C9909AFEC25354D551DAE21590BB26E38D53F2173B8D3DC3EEE4C047E7AB1C1EB8B85103E3BE7BA613B31BB5C9C36214DC9F14A42FD7A2FDB84856BCA5C44C2');
INSERT INTO vino_usager VALUES(2, 1, false, 'proprietaire', 'proprietaire@courriel.qc.ca', '3C9909AFEC25354D551DAE21590BB26E38D53F2173B8D3DC3EEE4C047E7AB1C1EB8B85103E3BE7BA613B31BB5C9C36214DC9F14A42FD7A2FDB84856BCA5C44C2');
INSERT INTO vino_usager VALUES(3, 1, false, 'visiteur', 'visiteur@courriel.qc.ca', 
'3C9909AFEC25354D551DAE21590BB26E38D53F2173B8D3DC3EEE4C047E7AB1C1EB8B85103E3BE7BA613B31BB5C9C36214DC9F14A42FD7A2FDB84856BCA5C44C2');

INSERT INTO vino_bouteille VALUES(1, '10324623', NULL, 11.80, 3, 5, 13, 50, NULL, 'Borsao Seleccion', NULL);
INSERT INTO vino_bouteille VALUES(2, '10359156', NULL, 19.80, 3, 5, 13, 50, NULL, 'Monasterio de Las Vinas Gran Reserva', NULL);
INSERT INTO vino_bouteille VALUES(3, '11676671', NULL, 12.50, 3, 5, 13, 46, NULL, 'Castano Hecula', NULL);
INSERT INTO vino_bouteille VALUES(4, '11462446', NULL, 14.30, 3, 5, 13, 50, NULL, 'Campo Viejo Tempranillo Rioja', NULL);
INSERT INTO vino_bouteille VALUES(5, '12375942', NULL, 17.10, 3, 5, 13, 48, 33, 'Bodegas Atalaya Laya', NULL);
INSERT INTO vino_bouteille VALUES(6, '13467048', NULL, 37.20, 1, 8, 14, 53, NULL, 'Vin Vault Pinot Grigio', NULL);
INSERT INTO vino_bouteille VALUES(7, '13675841', NULL, 22.65, 1, 5, 7, 25, 33, 'Huber Riesling Engelsberg', NULL);
INSERT INTO vino_bouteille VALUES(8, '13802571', NULL, 18.25, 3, 5, 13, 51, 31, 'Dominio de Tares Estay Castilla y Léon', NULL);
INSERT INTO vino_bouteille VALUES(9, '12216562', NULL, 21.95, 3, 5, 15, 85, 32, 'Tessellae Old Vines Côtes du Roussillon', NULL);
INSERT INTO vino_bouteille VALUES(10, '13637422', NULL, 34.75, 3, 5, 21, 122, 31, 'Tenuta Il Falchetto Bricco Paradiso - Barbera d’Asti Superiore DOCG', NULL);

INSERT INTO vino_cellier VALUES(1, 'Domicile');
INSERT INTO vino_cellier VALUES(2, 'Chalet');

INSERT INTO vino_role VALUES(1, 1);
INSERT INTO vino_role VALUES(2, 0);

INSERT INTO vino_role_description VALUES(1, 1, 1, 'Proprietaire');
INSERT INTO vino_role_description VALUES(2, 2, 1, 'Visiteur');
INSERT INTO vino_role_description VALUES(3, 1, 2, 'Owner');
INSERT INTO vino_role_description VALUES(4, 2, 2, 'Visitor');

INSERT INTO vino_cellier__usager VALUES(1, 1, 2, 1);
INSERT INTO vino_cellier__usager VALUES(2, 2, 2, 1);
INSERT INTO vino_cellier__usager VALUES(3, 1, 3, 2);

INSERT INTO vino_cellier__bouteille VALUES(1, 1, 10, 3, NULL, NULL, NULL);
INSERT INTO vino_cellier__bouteille VALUES(2, 1, 10, 1, NULL, NULL, NULL);
INSERT INTO vino_cellier__bouteille VALUES(3, 1, 5, 10, '2019-01-16', '2020-12-31', NULL);
INSERT INTO vino_cellier__bouteille VALUES(4, 1, 5, 1, NULL, NULL, NULL);
INSERT INTO vino_cellier__bouteille VALUES(5, 2, 5, 1, NULL, NULL, NULL);
INSERT INTO vino_cellier__bouteille VALUES(6, 2, 5, 10, NULL, NULL, NULL);
INSERT INTO vino_cellier__bouteille VALUES(7, 2, 3, 1, '2019-01-26', NULL, NULL);
