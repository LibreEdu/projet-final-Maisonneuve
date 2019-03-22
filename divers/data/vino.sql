DROP TABLE IF EXISTS vino_bouteille;
DROP TABLE IF EXISTS vino_cellier;
DROP TABLE IF EXISTS vino_usager;
DROP TABLE IF EXISTS vino_bouteille_saq;
DROP TABLE IF EXISTS vino_type;

CREATE TABLE vino_type (
	id_type TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
	type VARCHAR(20) NOT NULL,
	PRIMARY KEY (id_type)
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE vino_bouteille_saq (
	id_bouteille_saq MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	code_saq CHAR(8) NOT NULL,
	prix DECIMAL(7,2) unsigned NOT NULL,
	millesime SMALLINT(4) unsigned DEFAULT NULL,
	id_type TINYINT unsigned NOT NULL,
	pays VARCHAR(30) NOT NULL,
	format VARCHAR(10) NOT NULL,
	nom VARCHAR(200) NOT NULL,
	PRIMARY KEY (id_bouteille_saq),
	FOREIGN KEY (id_type) REFERENCES vino_type(id_type)
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE vino_usager (
	id_usager SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
	admin BOOLEAN NOT NULL,
	courriel VARCHAR(255) NOT NULL,
	nom VARCHAR(30) NOT NULL,
	prenom VARCHAR(30) NOT NULL,
	hash CHAR(128) NOT NULL,
	PRIMARY KEY (id_usager)
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE vino_cellier (
	id_cellier MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	id_usager SMALLINT UNSIGNED NOT NULL,
	nom VARCHAR(30) NOT NULL,
	PRIMARY KEY (id_cellier),
	FOREIGN KEY (id_usager) REFERENCES vino_usager(id_usager)
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE vino_bouteille (
	id_bouteille INT UNSIGNED NOT NULL AUTO_INCREMENT,
	id_cellier MEDIUMINT UNSIGNED NOT NULL,
	code_saq CHAR(8) DEFAULT NULL,
	prix DECIMAL(7,2) unsigned DEFAULT NULL,
	millesime SMALLINT(4) unsigned DEFAULT NULL,
	id_type TINYINT unsigned NOT NULL,
	pays VARCHAR(30) DEFAULT NULL,
	format VARCHAR(10) DEFAULT NULL,
	nom VARCHAR(200) NULL,
	note TEXT DEFAULT NULL,
	quantite SMALLINT DEFAULT NULL,
	date_achat DATE DEFAULT NULL,
	boire_avant DATE DEFAULT NULL,
	PRIMARY KEY (id_bouteille),
	FOREIGN KEY (id_cellier) REFERENCES vino_cellier(id_cellier),
	FOREIGN KEY (id_type) REFERENCES vino_type(id_type)
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

INSERT INTO vino_type VALUES(1, 'Vin blanc');
INSERT INTO vino_type VALUES(2, 'Vin rosé');
INSERT INTO vino_type VALUES(3, 'Vin rouge');

INSERT INTO vino_bouteille_saq VALUES(1, '10324623', 11.80, NULL, 3, 'Espagne', '750 ml', 'Borsao Seleccion');
INSERT INTO vino_bouteille_saq VALUES(2, '10359156', 19.80, NULL, 3, 'Espagne', '750 ml', 'Monasterio de Las Vinas Gran Reserva');
INSERT INTO vino_bouteille_saq VALUES(3, '11676671', 12.50, NULL, 3, 'Espagne', '750 ml', 'Castano Hecula');
INSERT INTO vino_bouteille_saq VALUES(4, '11462446', 14.30, NULL, 3, 'Espagne', '750 ml', 'Campo Viejo Tempranillo Rioja');
INSERT INTO vino_bouteille_saq VALUES(5, '12375942', 17.10, 2017, 3, 'Espagne', '750 ml', 'Bodegas Atalaya Laya');
INSERT INTO vino_bouteille_saq VALUES(6, '13467048', 37.20, NULL, 1, 'États-Unis', '3 L', 'Vin Vault Pinot Grigio');
INSERT INTO vino_bouteille_saq VALUES(7, '13675841', 22.65, 2017, 1, 'Autriche', '750 ml', 'Huber Riesling Engelsberg');
INSERT INTO vino_bouteille_saq VALUES(8, '13802571', 18.25, 2015, 3, 'Espagne', '750 ml', 'Dominio de Tares Estay Castilla y Léon');
INSERT INTO vino_bouteille_saq VALUES(9, '12216562', 21.95, 2016, 3, 'France', '750 ml', 'Tessellae Old Vines Côtes du Roussillon');
INSERT INTO vino_bouteille_saq VALUES(10, '13637422', 34.75, 2015, 3, 'Italie', '750 ml', 'Tenuta Il Falchetto Bricco Paradiso - Barbera d’Asti Superiore DOCG');

INSERT INTO vino_usager VALUES(1, true, 'aa@aa.aa', 'Fatemeh', 'Homatash', '$2y$10$7h.i1V1Zvr3cpcUNGVpXBO5iZJOc.45ICY2oOUIlWD3MOsElxn2My');
INSERT INTO vino_usager VALUES(2, false, 'bb@bb.bb', 'Charef', 'Yagoubi', '$2y$10$7h.i1V1Zvr3cpcUNGVpXBO5iZJOc.45ICY2oOUIlWD3MOsElxn2My');
INSERT INTO vino_usager VALUES(3, false, 'cc@cc.cc', 'Jose', 'Ignacio', '$2y$10$7h.i1V1Zvr3cpcUNGVpXBO5iZJOc.45ICY2oOUIlWD3MOsElxn2My');
INSERT INTO vino_usager VALUES(4, false, 'dd@dd.dd', 'Alexandre', 'Pachot', '$2y$10$7h.i1V1Zvr3cpcUNGVpXBO5iZJOc.45ICY2oOUIlWD3MOsElxn2My');
INSERT INTO vino_usager VALUES(5, false, 'ee@ee.ee', 'Mina', 'Amir', '$2y$10$7h.i1V1Zvr3cpcUNGVpXBO5iZJOc.45ICY2oOUIlWD3MOsElxn2My');

INSERT INTO vino_cellier VALUES(1, 1, 'Domicile');
INSERT INTO vino_cellier VALUES(2, 2, 'Chalet');
INSERT INTO vino_cellier VALUES(3, 3, 'Domicile');
INSERT INTO vino_cellier VALUES(4, 4, 'Domicile');
INSERT INTO vino_cellier VALUES(5, 1, 'Home');
INSERT INTO vino_cellier VALUES(6, 2, 'Maison');
INSERT INTO vino_cellier VALUES(7, 5, 'Amis');

INSERT INTO vino_bouteille VALUES(1, 1, '13637422', 34.75, 2015, 3, 'Italie', '750 ml', 'Tenuta Il Falchetto Bricco Paradiso - Barbera d’Asti Superiore DOCG', 'Une bonne bouteille', 10, '2019-01-01', NULL);
INSERT INTO vino_bouteille VALUES(2, 2, '12375942', 17.10, NULL, 3, 'Italie', '750 ml', 'Bodegas Atalaya Laya', 'Une bonne bouteille', 15, '2014-09-22', NULL);
INSERT INTO vino_bouteille VALUES(3, 3, '11676671', 12.50, 2015, 3, 'Italie', '750 ml', 'Castano Hecula', 'Une bonne bouteille', 20, '2019-06-01', NULL);
INSERT INTO vino_bouteille VALUES(4, 4, '12216562', 21.95, 2015, 3, 'Italie', '750 ml', 'Tessellae Old Vines Côtes du Roussillon', 'Une bonne bouteille', 5, '2016-04-11', NULL);
INSERT INTO vino_bouteille VALUES(5, 1, '13802571', 18.25, 2015, 3, 'Espagne', '750 ml', 'Dominio de Tares Estay Castilla y Léon', 'Une bonne bouteille', 25, '2018-10-01', NULL);
INSERT INTO vino_bouteille VALUES(6, 2, '13675841', 22.65, 2017, 3, 'Autriche', '750 ml', 'Huber Riesling Engelsberg', 'Une mauvaise bouteille', 7, '2016-10-22', NULL);
INSERT INTO vino_bouteille VALUES(7, 3, '11676671', 12.50, 2015, 3, 'Italie', '750 ml', 'Castano Hecula', 'Une bonne bouteille', 20, '2019-06-01', NULL);
INSERT INTO vino_bouteille VALUES(8, 4, '12216562', 21.95, 2015, 3, 'Italie', '750 ml', 'Tessellae Old Vines Côtes du Roussillon', 'Une bonne bouteille', 5, '2016-04-11', NULL);
