-- https://dba.stackexchange.com/questions/76788/create-a-mysql-database-with-charset-utf-8
CREATE DATABASE IF NOT EXISTS vino
	CHARACTER SET utf8mb4
	COLLATE utf8mb4_unicode_ci;

USE vino;


DROP TABLE IF EXISTS vino_cellier__bouteille;
DROP TABLE IF EXISTS vino_bouteille;
DROP TABLE IF EXISTS vino_cellier__usager;
DROP TABLE IF EXISTS vino_role;
DROP TABLE IF EXISTS vino_usager;
DROP TABLE IF EXISTS vino_cellier;
DROP TABLE IF EXISTS vino_bouteille_saq;
DROP TABLE IF EXISTS vino_type;


CREATE TABLE vino_type (
	id INT NOT NULL AUTO_INCREMENT,
	libelle VARCHAR(20) NOT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB;

-- https://www.saq.com/page/en/saqcom///12216562
CREATE TABLE vino_bouteille_saq (
	id INT NOT NULL AUTO_INCREMENT,
	code_saq CHAR(8) NOT NULL,
	prix FLOAT NOT NULL,
	millesime CHAR(4) DEFAULT NULL,
	id_type INT NOT NULL,
	pays VARCHAR(30) NOT NULL,
	format VARCHAR(10) NOT NULL,
	libelle VARCHAR(200) NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id_type) REFERENCES vino_type(id)
) ENGINE=InnoDB;

CREATE TABLE vino_cellier (
	id INT NOT NULL AUTO_INCREMENT,
	date_creation DATE  NOT NULL,
	libelle VARCHAR(30) NOT NULL,
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
	UNIQUE (identifiant)
) ENGINE=InnoDB;

CREATE TABLE vino_role (
	id INT NOT NULL AUTO_INCREMENT,
	modifier BOOLEAN NOT NULL,
	role VARCHAR(30) NOT NULL,
	PRIMARY KEY (id)
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
	millesime CHAR(4) DEFAULT NULL,
	id_type INT NOT NULL,
	pays VARCHAR(30) NOT NULL,
	format VARCHAR(10) NOT NULL,
	libelle VARCHAR(200) NOT NULL,
	note TEXT DEFAULT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id_type) REFERENCES vino_type(id)
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

INSERT INTO vino_type VALUES(1, 'Vin blanc');
INSERT INTO vino_type VALUES(2, 'Vin rosé');
INSERT INTO vino_type VALUES(3, 'Vin rouge');

INSERT INTO vino_bouteille_saq VALUES(1, '10324623', 11.80, NULL, 3, 'Espagne', '750 ml', 'Borsao Seleccion');
INSERT INTO vino_bouteille_saq VALUES(2, '10359156', 19.80, NULL, 3, 'Espagne', '750 ml', 'Monasterio de Las Vinas Gran Reserva');
INSERT INTO vino_bouteille_saq VALUES(3, '11676671', 12.50, NULL, 3, 'Espagne', '750 ml', 'Castano Hecula');
INSERT INTO vino_bouteille_saq VALUES(4, '11462446', 14.30, NULL, 3, 'Espagne', '750 ml', 'Campo Viejo Tempranillo Rioja');
INSERT INTO vino_bouteille_saq VALUES(5, '12375942', 17.10, '2017', 3, 'Espagne', '750 ml', 'Bodegas Atalaya Laya');
INSERT INTO vino_bouteille_saq VALUES(6, '13467048', 37.20, NULL, 1, 'États-Unis', '3 L', 'Vin Vault Pinot Grigio');
INSERT INTO vino_bouteille_saq VALUES(7, '13675841', 22.65, '2017', 1, 'Autriche', '750 ml', 'Huber Riesling Engelsberg');
INSERT INTO vino_bouteille_saq VALUES(8, '13802571', 18.25, '2015', 3, 'Espagne', '750 ml', 'Dominio de Tares Estay Castilla y Léon');
INSERT INTO vino_bouteille_saq VALUES(9, '12216562', 21.95, '2016', 3, 'France', '750 ml', 'Tessellae Old Vines Côtes du Roussillon');
INSERT INTO vino_bouteille_saq VALUES(10, '13637422', 34.75, '2015', 3, 'Italie', '750 ml', 'Tenuta Il Falchetto Bricco Paradiso - Barbera d’Asti Superiore DOCG');

INSERT INTO vino_cellier VALUES(1, '2019-01-01', 'Domicile');
INSERT INTO vino_cellier VALUES(2, '2019-01-01', 'Chalet');
INSERT INTO vino_cellier VALUES(3, '2019-01-01', 'Domicile');
INSERT INTO vino_cellier VALUES(4, '2019-01-01', 'Domicile');
INSERT INTO vino_cellier VALUES(5, '2019-01-01', 'Home');

INSERT INTO vino_usager VALUES(1, 1, true, true, "2019-01-01", 'admin', 'admin@vino.qc.ca', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '3C9909AFEC25354D551DAE21590BB26E38D53F2173B8D3DC3EEE4C047E7AB1C1EB8B85103E3BE7BA613B31BB5C9C36214DC9F14A42FD7A2FDB84856BCA5C44C2');
INSERT INTO vino_usager VALUES(2, 1, false, true, "2019-01-01", 'johanne', 'johanne@bell.ca', 'Johanne', 'Leblanc', '6775 Metivier', 'Montréal', 'QC', 'H4K2N4', '514 315-5964', 'Canada', '3C9909AFEC25354D551DAE21590BB26E38D53F2173B8D3DC3EEE4C047E7AB1C1EB8B85103E3BE7BA613B31BB5C9C36214DC9F14A42FD7A2FDB84856BCA5C44C2');
INSERT INTO vino_usager VALUES(3, 1, false, true, "2019-01-01", 'marcel', 'marcel@videotron.com', 'Marcel', 'Trudeau', '2210 Louis-XIV', 'Québec', 'QC', 'G1C1A2', '418 667-8015', 'Canada', 
'3C9909AFEC25354D551DAE21590BB26E38D53F2173B8D3DC3EEE4C047E7AB1C1EB8B85103E3BE7BA613B31BB5C9C36214DC9F14A42FD7A2FDB84856BCA5C44C2');
INSERT INTO vino_usager VALUES(4, 1, false, false, "2019-01-01", 'denise', 'denise@hydroquebec.com', 'Denise', 'Harvey', '846 Rue Du Mont Brome', 'Sherbrooke', 'QC', 'J1L2V9', '819 563-6038', 'Canada', 
'3C9909AFEC25354D551DAE21590BB26E38D53F2173B8D3DC3EEE4C047E7AB1C1EB8B85103E3BE7BA613B31BB5C9C36214DC9F14A42FD7A2FDB84856BCA5C44C2');
INSERT INTO vino_usager VALUES(5, 2, false, true, "2019-01-01", 'dov', 'dov@apple.com', 'Dov', 'Snow', '3034 W Jarvis Ave', 'Chicago', 'IL', '60645-1112', '516 569-1964', 'United States', 
'3C9909AFEC25354D551DAE21590BB26E38D53F2173B8D3DC3EEE4C047E7AB1C1EB8B85103E3BE7BA613B31BB5C9C36214DC9F14A42FD7A2FDB84856BCA5C44C2');

INSERT INTO vino_role VALUES(1, 1, 'Propriétaire');
INSERT INTO vino_role VALUES(2, 0, 'Visiteur');

INSERT INTO vino_cellier__usager VALUES(1, 1, 2, 1);
INSERT INTO vino_cellier__usager VALUES(2, 2, 2, 1);
INSERT INTO vino_cellier__usager VALUES(3, 3, 3, 1);
INSERT INTO vino_cellier__usager VALUES(4, 1, 3, 2);
INSERT INTO vino_cellier__usager VALUES(5, 4, 4, 1);
INSERT INTO vino_cellier__usager VALUES(6, 5, 5, 1);

INSERT INTO vino_bouteille VALUES(1, '13637422', NULL, 34.75, '2015', 3, 'Italie', '750 ml', 'Tenuta Il Falchetto Bricco Paradiso - Barbera d’Asti Superiore DOCG', 'Une bonne bouteille');
INSERT INTO vino_bouteille VALUES(2, '13637422', NULL, 34.75, '2015', 3, 'Italie', '750 ml', 'Tenuta Il Falchetto Bricco Paradiso - Barbera d’Asti Superiore DOCG', NULL);
INSERT INTO vino_bouteille VALUES(3, '12375942', '2020-12-31', 17.10, 40, 3,'Italie','750ml', 'Bodegas Atalaya Laya', NULL);
INSERT INTO vino_bouteille VALUES(4, '12375942', NULL, 17.10, '2017', 3, 'Espagne', '750 ml', 'Bodegas Atalaya Laya', NULL);
INSERT INTO vino_bouteille VALUES(5, '12375942', NULL, 17.10, '2017', 3, 'Espagne', '750 ml', 'Bodegas Atalaya Laya', NULL);
INSERT INTO vino_bouteille VALUES(6, '12375942', NULL, 17.10, '2017', 3, 'Espagne', '750 ml', 'Bodegas Atalaya Laya', NULL);
INSERT INTO vino_bouteille VALUES(7, '11676671', NULL, 12.50, NULL, 3, 'Espagne', '750 ml', 'Castano Hecula', NULL);

INSERT INTO vino_cellier__bouteille VALUES(1, 1, 1, 3, NULL);
INSERT INTO vino_cellier__bouteille VALUES(2, 3, 2, 1, NULL);
INSERT INTO vino_cellier__bouteille VALUES(3, 1, 3, 10, '2019-01-16');
INSERT INTO vino_cellier__bouteille VALUES(4, 3, 4, 1, NULL);
INSERT INTO vino_cellier__bouteille VALUES(5, 4, 5, 1, NULL);
INSERT INTO vino_cellier__bouteille VALUES(6, 5, 6, 10, NULL);
INSERT INTO vino_cellier__bouteille VALUES(7, 1, 7, 1, '2019-01-26');
INSERT INTO vino_cellier__bouteille VALUES(8, 2, 1, 1, NULL);
