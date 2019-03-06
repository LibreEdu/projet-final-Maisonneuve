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
DROP TABLE IF EXISTS vino_type_description;
DROP TABLE IF EXISTS vino_type;
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

CREATE TABLE vino_type (
	id INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE vino_type_description (
	id INT NOT NULL AUTO_INCREMENT,
	id_type INT NOT NULL,
	id_langue INT NOT NULL,
	libelle VARCHAR(20) NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id_type) REFERENCES vino_type(id),
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
	id_type INT DEFAULT NULL,
	id_format INT DEFAULT NULL,
	id_pays INT DEFAULT NULL,
	id_millesime INT DEFAULT NULL,
	libelle VARCHAR(200) NOT NULL,
	note TEXT DEFAULT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id_usager) REFERENCES vino_usager(id),
	FOREIGN KEY (id_type) REFERENCES vino_type(id),
	FOREIGN KEY (id_format) REFERENCES vino_format(id),
	FOREIGN KEY (id_pays) REFERENCES vino_pays(id),
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


-- SELECT *
-- FROM vino_cellier__bouteille cb
-- INNER JOIN vino_cellier__usager cu
-- 	ON cb.id_cellier = cu.id_cellier
-- INNER JOIN vino_usager usager
-- 	ON usager.id = cu.id_usager
-- INNER JOIN vino_role_description role_description
-- 	ON role_description.id_role = cu.id_role
-- INNER JOIN vino_bouteille bouteille 
-- 	ON bouteille.id = cb.id_bouteille
-- LEFT JOIN vino_type_description type_description
-- 	ON type_description.id_type = bouteille.id_type
-- LEFT JOIN vino_format format
-- 	ON format.id = bouteille.id_format
-- LEFT JOIN vino_pays_description pays_description
-- 	ON pays_description.id_pays = bouteille.id_pays
-- LEFT JOIN vino_region_description region_description
-- 	ON region_description.id_region = bouteille.id_region
-- LEFT JOIN vino_millesime millesime
-- 	ON millesime.id = bouteille.id_millesime
-- WHERE role_description.id_langue = 1
-- 	AND type_description.id_langue = 1
-- 	AND pays_description.id_langue = 1
-- 	AND region_description.id_langue = 1
-- 	AND cu.id_role = 1


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

INSERT INTO vino_type VALUES(1);
INSERT INTO vino_type VALUES(2);
INSERT INTO vino_type VALUES(3);

INSERT INTO vino_type_description VALUES(1, 1, 1, 'Vin blanc');
INSERT INTO vino_type_description VALUES(2, 2, 1, 'Vin rosé');
INSERT INTO vino_type_description VALUES(3, 3, 1, 'Vin rouge');
INSERT INTO vino_type_description VALUES(4, 1, 2, 'White wine');
INSERT INTO vino_type_description VALUES(5, 2, 2, 'Rosé');
INSERT INTO vino_type_description VALUES(6, 3, 2, 'Red wine ');

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
INSERT INTO vino_usager VALUES(2, 1, false, 'Unproprietaire', 'proprietaire@courriel.qc.ca', '3C9909AFEC25354D551DAE21590BB26E38D53F2173B8D3DC3EEE4C047E7AB1C1EB8B85103E3BE7BA613B31BB5C9C36214DC9F14A42FD7A2FDB84856BCA5C44C2');
INSERT INTO vino_usager VALUES(3, 1, false, 'Unvisiteur', 'visiteur@courriel.qc.ca', 
'3C9909AFEC25354D551DAE21590BB26E38D53F2173B8D3DC3EEE4C047E7AB1C1EB8B85103E3BE7BA613B31BB5C9C36214DC9F14A42FD7A2FDB84856BCA5C44C2');

INSERT INTO vino_bouteille VALUES(1, '10324623', NULL, 11.80, 3, 5, 13, NULL, 'Borsao Seleccion', NULL);
INSERT INTO vino_bouteille VALUES(2, '10359156', NULL, 19.80, 3, 5, 13, NULL, 'Monasterio de Las Vinas Gran Reserva', NULL);
INSERT INTO vino_bouteille VALUES(3, '11676671', NULL, 12.50, 3, 5, 13, NULL, 'Castano Hecula', NULL);
INSERT INTO vino_bouteille VALUES(4, '11462446', NULL, 14.30, 3, 5, 13, NULL, 'Campo Viejo Tempranillo Rioja', NULL);
INSERT INTO vino_bouteille VALUES(5, '12375942', NULL, 17.10, 3, 5, 13, 33, 'Bodegas Atalaya Laya', NULL);
INSERT INTO vino_bouteille VALUES(6, '13467048', NULL, 37.20, 1, 8, 14, NULL, 'Vin Vault Pinot Grigio', NULL);
INSERT INTO vino_bouteille VALUES(7, '13675841', NULL, 22.65, 1, 5, 7, 33, 'Huber Riesling Engelsberg', NULL);
INSERT INTO vino_bouteille VALUES(8, '13802571', NULL, 18.25, 3, 5, 13, 31, 'Dominio de Tares Estay Castilla y Léon', NULL);
INSERT INTO vino_bouteille VALUES(9, '12216562', NULL, 21.95, 3, 5, 15, 32, 'Tessellae Old Vines Côtes du Roussillon', NULL);
INSERT INTO vino_bouteille VALUES(10, '13637422', NULL, 34.75, 3, 5, 21, 31, 'Tenuta Il Falchetto Bricco Paradiso - Barbera d’Asti Superiore DOCG', NULL);

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
