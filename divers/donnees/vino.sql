DROP TABLE IF EXISTS vino_liste_affichage;
DROP TABLE IF EXISTS vino_liste_achat;
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
	prenom VARCHAR(30) NOT NULL,
	nom VARCHAR(30) NOT NULL,
	mot_de_passe CHAR(128) NOT NULL,
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

CREATE TABLE vino_liste_achat (
	id_liste_achat INT UNSIGNED NOT NULL AUTO_INCREMENT,
	id_usager SMALLINT unsigned NOT NULL,
	nom VARCHAR(200) NOT NULL,
	PRIMARY KEY (id_liste_achat),
	FOREIGN KEY (id_usager) REFERENCES vino_usager(id_usager)
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE vino_liste_affichage (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	id_liste_achat INT  UNSIGNED REFERENCES vino_liste_achat(id_liste_achat),	
	id_bouteille_saq MEDIUMINT unsigned REFERENCES vino_bouteille_saq(id_bouteille_saq),
	PRIMARY KEY (id)
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

INSERT INTO vino_usager VALUES(1, true, 'aa@aa.aa', 'Jonathan', 'Martel', '$2y$10$7h.i1V1Zvr3cpcUNGVpXBO5iZJOc.45ICY2oOUIlWD3MOsElxn2My');