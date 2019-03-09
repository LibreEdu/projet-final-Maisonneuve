-- https://dba.stackexchange.com/questions/76788/create-a-mysql-database-with-charset-utf-8
CREATE DATABASE IF NOT EXISTS vino
	CHARACTER SET utf8mb4
	COLLATE utf8mb4_unicode_ci;

USE vino;


DROP TABLE IF EXISTS vino_liste_achat__bouteille_saq;
DROP TABLE IF EXISTS vino_liste_achat;
DROP TABLE IF EXISTS vino_erreur;
DROP TABLE IF EXISTS vino_bouteille_partage;
DROP TABLE IF EXISTS vino_bouteille_bu;
DROP TABLE IF EXISTS vino_cellier__bouteille;
DROP TABLE IF EXISTS vino_bouteille;
DROP TABLE IF EXISTS vino_cellier__usager;
DROP TABLE IF EXISTS vino_role_description;
DROP TABLE IF EXISTS vino_role;
DROP TABLE IF EXISTS vino_usager;
DROP TABLE IF EXISTS vino_cellier;
DROP TABLE IF EXISTS vino_bouteille_saq;
DROP TABLE IF EXISTS vino_format;
DROP TABLE IF EXISTS vino_pays_description;
DROP TABLE IF EXISTS vino_pays;
DROP TABLE IF EXISTS vino_type_description;
DROP TABLE IF EXISTS vino_type;
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

CREATE TABLE vino_format (
	id INT NOT NULL AUTO_INCREMENT,
	contenance FLOAT NOT NULL,
	unite VARCHAR(10) NOT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB;

-- https://www.saq.com/page/en/saqcom/x/x/12216562
CREATE TABLE vino_bouteille_saq (
	id INT NOT NULL AUTO_INCREMENT,
	code_saq CHAR(8) NOT NULL,
	prix FLOAT NOT NULL,
	id_millesime INT DEFAULT NULL,
	id_type INT NOT NULL,
	id_pays INT NOT NULL,
	id_format INT NOT NULL,
	libelle VARCHAR(200) NOT NULL,
	PRIMARY KEY (id),
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

CREATE TABLE vino_usager (
	id INT NOT NULL AUTO_INCREMENT,
	id_langue INT NOT NULL,
	admin BOOLEAN NOT NULL,
	actif BOOLEAN NOT NULL,
	date_creation DATE NOT NULL,
	identifiant VARCHAR(30) NOT NULL,
	courriel VARCHAR(255) NOT NULL,
	nom VARCHAR(30) NOT NULL,
	prenom VARCHAR(30) NOT NULL,
	adresse VARCHAR(100) DEFAULT NULL,
	ville VARCHAR(30) DEFAULT NULL,
	province VARCHAR(20) DEFAULT NULL,
	codePostal VARCHAR(20) DEFAULT NULL,
	telephone VARCHAR(20) DEFAULT NULL,
	pays VARCHAR(30) DEFAULT NULL,
	hash CHAR(128) NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id_langue) REFERENCES vino_langue(id),
	UNIQUE (identifiant),
	UNIQUE (courriel)
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

CREATE TABLE vino_bouteille (
	id INT NOT NULL AUTO_INCREMENT,
	code_saq CHAR(8) DEFAULT NULL,
	date_buvable DATE DEFAULT NULL,
	prix FLOAT DEFAULT NULL,
	id_millesime INT DEFAULT NULL,
	id_type INT DEFAULT NULL,
	id_pays INT DEFAULT NULL,
	id_format INT DEFAULT NULL,
	libelle VARCHAR(200) NOT NULL,
	note TEXT DEFAULT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id_type) REFERENCES vino_type(id),
	FOREIGN KEY (id_format) REFERENCES vino_format(id),
	FOREIGN KEY (id_pays) REFERENCES vino_pays(id),
	FOREIGN KEY (id_millesime) REFERENCES vino_millesime(id)
) ENGINE=InnoDB;

CREATE TABLE vino_cellier__bouteille (
	id INT NOT NULL AUTO_INCREMENT,
	id_cellier  INT NOT NULL,
	id_bouteille  INT NOT NULL,
	quantite INT NOT NULL,
	date_achat DATE DEFAULT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id_bouteille) REFERENCES vino_bouteille(id),
	FOREIGN KEY (id_cellier) REFERENCES vino_cellier(id)
) ENGINE=InnoDB;

CREATE TABLE vino_bouteille_bu (
	id INT NOT NULL AUTO_INCREMENT,
	id_bouteille INT NOT NULL,
	date_degustation DATE NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id_bouteille) REFERENCES vino_bouteille(id)
) ENGINE=InnoDB;

CREATE TABLE vino_bouteille_partage (
	id INT NOT NULL AUTO_INCREMENT,
	id_bouteille INT NOT NULL,
	date_partage DATE NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id_bouteille) REFERENCES vino_bouteille(id)
) ENGINE=InnoDB;

CREATE TABLE vino_erreur (
	id INT NOT NULL AUTO_INCREMENT,
	id_usager INT NOT NULL,
	id_bouteille_saq INT NOT NULL,
	date_erreur DATE NOT NULL,
	remarque TEXT DEFAULT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id_usager) REFERENCES vino_usager(id),
	FOREIGN KEY (id_bouteille_saq) REFERENCES vino_bouteille_saq(id)
) ENGINE=InnoDB;

CREATE TABLE vino_liste_achat (
	id INT NOT NULL AUTO_INCREMENT,
	id_usager INT NOT NULL,
	libelle INT NOT NULL,
	date_creation DATE NOT NULL,
	note TEXT DEFAULT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id_usager) REFERENCES vino_usager(id)
) ENGINE=InnoDB;

CREATE TABLE vino_liste_achat__bouteille_saq (
	id INT NOT NULL AUTO_INCREMENT,
	id_liste_achat INT NOT NULL,
	id_bouteille_saq INT NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id_liste_achat) REFERENCES vino_liste_achat(id),
	FOREIGN KEY (id_bouteille_saq) REFERENCES vino_bouteille_saq(id)
) ENGINE=InnoDB;


INSERT INTO vino_langue VALUES(1, 'Français', 'fr');
INSERT INTO vino_langue VALUES(2, 'English', 'en');

INSERT INTO vino_millesime VALUES(1, '1935');
INSERT INTO vino_millesime VALUES(2, '1951');
INSERT INTO vino_millesime VALUES(3, '1964');
INSERT INTO vino_millesime VALUES(4, '1965');
INSERT INTO vino_millesime VALUES(5, '1966');
INSERT INTO vino_millesime VALUES(6, '1967');
INSERT INTO vino_millesime VALUES(7, '1968');
INSERT INTO vino_millesime VALUES(8, '1979');
INSERT INTO vino_millesime VALUES(9, '1981');
INSERT INTO vino_millesime VALUES(10, '1982');
INSERT INTO vino_millesime VALUES(11, '1985');
INSERT INTO vino_millesime VALUES(12, '1986');
INSERT INTO vino_millesime VALUES(13, '1988');
INSERT INTO vino_millesime VALUES(14, '1989');
INSERT INTO vino_millesime VALUES(15, '1990');
INSERT INTO vino_millesime VALUES(16, '1992');
INSERT INTO vino_millesime VALUES(17, '1994');
INSERT INTO vino_millesime VALUES(18, '1995');
INSERT INTO vino_millesime VALUES(19, '1996');
INSERT INTO vino_millesime VALUES(20, '1997');
INSERT INTO vino_millesime VALUES(21, '1998');
INSERT INTO vino_millesime VALUES(22, '1999');
INSERT INTO vino_millesime VALUES(23, '2000');
INSERT INTO vino_millesime VALUES(24, '2001');
INSERT INTO vino_millesime VALUES(25, '2002');
INSERT INTO vino_millesime VALUES(26, '2003');
INSERT INTO vino_millesime VALUES(27, '2004');
INSERT INTO vino_millesime VALUES(28, '2005');
INSERT INTO vino_millesime VALUES(29, '2006');
INSERT INTO vino_millesime VALUES(30, '2007');
INSERT INTO vino_millesime VALUES(31, '2008');
INSERT INTO vino_millesime VALUES(32, '2009');
INSERT INTO vino_millesime VALUES(33, '2010');
INSERT INTO vino_millesime VALUES(34, '2011');
INSERT INTO vino_millesime VALUES(35, '2012');
INSERT INTO vino_millesime VALUES(36, '2013');
INSERT INTO vino_millesime VALUES(37, '2014');
INSERT INTO vino_millesime VALUES(38, '2015');
INSERT INTO vino_millesime VALUES(39, '2016');
INSERT INTO vino_millesime VALUES(40, '2017');
INSERT INTO vino_millesime VALUES(41, '2018');

INSERT INTO vino_type VALUES(1);
INSERT INTO vino_type VALUES(2);
INSERT INTO vino_type VALUES(3);

INSERT INTO vino_type_description VALUES(1, 1, 1, 'Vin blanc');
INSERT INTO vino_type_description VALUES(2, 2, 1, 'Vin rosé');
INSERT INTO vino_type_description VALUES(3, 3, 1, 'Vin rouge');
INSERT INTO vino_type_description VALUES(4, 1, 2, 'White wine');
INSERT INTO vino_type_description VALUES(5, 2, 2, 'Rosé');
INSERT INTO vino_type_description VALUES(6, 3, 2, 'Red wine ');

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

INSERT INTO vino_format VALUES(1, 50, 'ml');
INSERT INTO vino_format VALUES(2, 187, 'ml');
INSERT INTO vino_format VALUES(3, 200, 'ml');
INSERT INTO vino_format VALUES(4, 210, 'ml');
INSERT INTO vino_format VALUES(5, 250, 'ml');
INSERT INTO vino_format VALUES(6, 355, 'ml');
INSERT INTO vino_format VALUES(7, 375, 'ml');
INSERT INTO vino_format VALUES(8, 400, 'ml');
INSERT INTO vino_format VALUES(9, 500, 'ml');
INSERT INTO vino_format VALUES(10, 600, 'ml');
INSERT INTO vino_format VALUES(11, 620, 'ml');
INSERT INTO vino_format VALUES(12, 700, 'ml');
INSERT INTO vino_format VALUES(13, 720, 'ml');
INSERT INTO vino_format VALUES(14, 750, 'ml');
INSERT INTO vino_format VALUES(15, 1, 'L');
INSERT INTO vino_format VALUES(16, 1.125, 'L');
INSERT INTO vino_format VALUES(17, 1.5, 'L');
INSERT INTO vino_format VALUES(18, 3, 'L');
INSERT INTO vino_format VALUES(19, 4, 'L');
INSERT INTO vino_format VALUES(20, 4.5, 'L');
INSERT INTO vino_format VALUES(21, 5, 'L');
INSERT INTO vino_format VALUES(22, 6, 'L'); 

INSERT INTO vino_bouteille_saq VALUES(1, '10324623', 11.80, NULL, 3, 13, 14, 'Borsao Seleccion');
INSERT INTO vino_bouteille_saq VALUES(2, '10359156', 19.80, NULL, 3, 13, 14, 'Monasterio de Las Vinas Gran Reserva');
INSERT INTO vino_bouteille_saq VALUES(3, '11676671', 12.50, NULL, 3, 13, 14, 'Castano Hecula');
INSERT INTO vino_bouteille_saq VALUES(4, '11462446', 14.30, NULL, 3, 13, 14, 'Campo Viejo Tempranillo Rioja');
INSERT INTO vino_bouteille_saq VALUES(5, '12375942', 17.10, 40, 3, 13, 14, 'Bodegas Atalaya Laya');
INSERT INTO vino_bouteille_saq VALUES(6, '13467048', 37.20, NULL, 1, 14, 18, 'Vin Vault Pinot Grigio');
INSERT INTO vino_bouteille_saq VALUES(7, '13675841', 22.65, 40, 1, 7, 14, 'Huber Riesling Engelsberg');
INSERT INTO vino_bouteille_saq VALUES(8, '13802571', 18.25, 38, 3, 13, 14, 'Dominio de Tares Estay Castilla y Léon');
INSERT INTO vino_bouteille_saq VALUES(9, '12216562', 21.95, 39, 3, 15, 14, 'Tessellae Old Vines Côtes du Roussillon');
INSERT INTO vino_bouteille_saq VALUES(10, '13637422', 34.75, 38, 3, 21, 13, 'Tenuta Il Falchetto Bricco Paradiso - Barbera d’Asti Superiore DOCG');

INSERT INTO vino_cellier VALUES(1, 'Domicile');
INSERT INTO vino_cellier VALUES(2, 'Chalet');
INSERT INTO vino_cellier VALUES(3, 'Domicile');
INSERT INTO vino_cellier VALUES(4, 'Domicile');
INSERT INTO vino_cellier VALUES(5, 'Home');

INSERT INTO vino_usager VALUES(1, 1, true, true, "2019-01-01", 'admin', 'admin@vino.qc.ca', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '3C9909AFEC25354D551DAE21590BB26E38D53F2173B8D3DC3EEE4C047E7AB1C1EB8B85103E3BE7BA613B31BB5C9C36214DC9F14A42FD7A2FDB84856BCA5C44C2');
INSERT INTO vino_usager VALUES(2, 1, false, true, "2019-01-01", 'johanne', 'johanne@bell.ca', 'Johanne', 'Leblanc', '6775 Metivier', 'Montréal', 'QC', 'H4K2N4', '514 315-5964', 'Canada', '3C9909AFEC25354D551DAE21590BB26E38D53F2173B8D3DC3EEE4C047E7AB1C1EB8B85103E3BE7BA613B31BB5C9C36214DC9F14A42FD7A2FDB84856BCA5C44C2');
INSERT INTO vino_usager VALUES(3, 1, false, true, "2019-01-01", 'marcel', 'marcel@videotron.com', 'Marcel', 'Trudeau', '2210 Louis-XIV', 'Québec', 'QC', 'G1C1A2', '418 667-8015', 'Canada', 
'3C9909AFEC25354D551DAE21590BB26E38D53F2173B8D3DC3EEE4C047E7AB1C1EB8B85103E3BE7BA613B31BB5C9C36214DC9F14A42FD7A2FDB84856BCA5C44C2');
INSERT INTO vino_usager VALUES(4, 1, false, false, "2019-01-01", 'denise', 'denise@hydroquebec.com', 'Denise', 'Harvey', '846 Rue Du Mont Brome', 'Sherbrooke', 'QC', 'J1L2V9', '819 563-6038', 'Canada', 
'3C9909AFEC25354D551DAE21590BB26E38D53F2173B8D3DC3EEE4C047E7AB1C1EB8B85103E3BE7BA613B31BB5C9C36214DC9F14A42FD7A2FDB84856BCA5C44C2');
INSERT INTO vino_usager VALUES(5, 2, false, true, "2019-01-01", 'dov', 'dov@apple.com', 'Dov', 'Snow', '3034 W Jarvis Ave', 'Chicago', 'IL', '60645-1112', '516 569-1964', 'United States', 
'3C9909AFEC25354D551DAE21590BB26E38D53F2173B8D3DC3EEE4C047E7AB1C1EB8B85103E3BE7BA613B31BB5C9C36214DC9F14A42FD7A2FDB84856BCA5C44C2');

INSERT INTO vino_role VALUES(1, 1);
INSERT INTO vino_role VALUES(2, 0);

INSERT INTO vino_role_description VALUES(1, 1, 1, 'Propriétaire');
INSERT INTO vino_role_description VALUES(2, 2, 1, 'Visiteur');
INSERT INTO vino_role_description VALUES(3, 1, 2, 'Owner');
INSERT INTO vino_role_description VALUES(4, 2, 2, 'Visitor');

INSERT INTO vino_cellier__usager VALUES(1, 1, 2, 1);
INSERT INTO vino_cellier__usager VALUES(2, 2, 2, 1);
INSERT INTO vino_cellier__usager VALUES(3, 3, 3, 1);
INSERT INTO vino_cellier__usager VALUES(4, 1, 3, 2);
INSERT INTO vino_cellier__usager VALUES(5, 4, 4, 1);
INSERT INTO vino_cellier__usager VALUES(6, 5, 5, 1);

INSERT INTO vino_bouteille VALUES(1, '13637422', NULL, 34.75, 38, 3, 21, 14, 'Tenuta Il Falchetto Bricco Paradiso - Barbera d’Asti Superiore DOCG', 'Une bonne bouteille');
INSERT INTO vino_bouteille VALUES(2, '13637422', NULL, 34.75, 38, 3, 21, 14, 'Tenuta Il Falchetto Bricco Paradiso - Barbera d’Asti Superiore DOCG', NULL);
INSERT INTO vino_bouteille VALUES(3, '12375942', '2020-12-31', 17.10, 40, 3, 13, 14, 'Bodegas Atalaya Laya', NULL);
INSERT INTO vino_bouteille VALUES(4, '12375942', NULL, 17.10, 40, 3, 13, 14, 'Bodegas Atalaya Laya', NULL);
INSERT INTO vino_bouteille VALUES(5, '12375942', NULL, 17.10, 40, 3, 13, 14, 'Bodegas Atalaya Laya', NULL);
INSERT INTO vino_bouteille VALUES(6, '12375942', NULL, 17.10, 40, 3, 13, 14, 'Bodegas Atalaya Laya', NULL);
INSERT INTO vino_bouteille VALUES(7, '11676671', NULL, 12.50, NULL, 3, 13, 14, 'Castano Hecula', NULL);

INSERT INTO vino_cellier__bouteille VALUES(1, 1, 1, 3, NULL);
INSERT INTO vino_cellier__bouteille VALUES(2, 3, 2, 1, NULL);
INSERT INTO vino_cellier__bouteille VALUES(3, 1, 3, 10, '2019-01-16');
INSERT INTO vino_cellier__bouteille VALUES(4, 3, 4, 1, NULL);
INSERT INTO vino_cellier__bouteille VALUES(5, 4, 5, 1, NULL);
INSERT INTO vino_cellier__bouteille VALUES(6, 5, 6, 10, NULL);
INSERT INTO vino_cellier__bouteille VALUES(7, 1, 7, 1, '2019-01-26');
INSERT INTO vino_cellier__bouteille VALUES(8, 2, 1, 1, NULL);

INSERT INTO vino_bouteille_bu VALUES(1, 1, '2019-03-02');

INSERT INTO vino_bouteille_partage VALUES(1, 1, '2019-03-01');
INSERT INTO vino_bouteille_partage VALUES(2, 1, '2019-03-02');

INSERT INTO vino_erreur VALUES(1, 2, 1, '2019-03-01', NULL);

INSERT INTO vino_liste_achat VALUES(1, 2, 'Fin de projet', '2019-03-01', 'Ça se fête!');

INSERT INTO vino_liste_achat__bouteille_saq VALUES(1, 1, 10);
