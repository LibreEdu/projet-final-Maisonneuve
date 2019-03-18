CREATE DATABASE IF NOT EXISTS vino
	CHARACTER SET utf8mb4
	COLLATE utf8mb4_unicode_ci;

USE vino;

DROP TABLE IF EXISTS vino_bouteille;
DROP TABLE IF EXISTS vino_cellier;
DROP TABLE IF EXISTS vino_usager;
DROP TABLE IF EXISTS vino_bouteille_saq;
DROP TABLE IF EXISTS vino_type;

CREATE TABLE vino_type (
	id_type TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
	type VARCHAR(20) NOT NULL,
	PRIMARY KEY (id_type)
) ENGINE=InnoDB;

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
) ENGINE=InnoDB;

CREATE TABLE vino_usager (
	id_usager SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
	admin BOOLEAN NOT NULL,
	actif BOOLEAN NOT NULL,
	courriel VARCHAR(255) NOT NULL,
	nom VARCHAR(30) NOT NULL,
	prenom VARCHAR(30) NOT NULL,
	hash CHAR(128) NOT NULL,
	PRIMARY KEY (id_usager)
) ENGINE=InnoDB;

CREATE TABLE vino_cellier (
	id_cellier MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	id_usager SMALLINT UNSIGNED NOT NULL,
	nom VARCHAR(30) NOT NULL,
	PRIMARY KEY (id_cellier),
	FOREIGN KEY (id_usager) REFERENCES vino_usager(id_usager)
) ENGINE=InnoDB;

CREATE TABLE vino_bouteille (
	id_bouteille INT UNSIGNED NOT NULL AUTO_INCREMENT,
	id_cellier MEDIUMINT UNSIGNED NOT NULL,
	code_saq CHAR(8) NOT NULL,
	prix DECIMAL(7,2) unsigned NOT NULL,
	millesime SMALLINT(4) unsigned DEFAULT NULL,
	id_type TINYINT unsigned NOT NULL,
	pays VARCHAR(30) NOT NULL,
	format VARCHAR(10) NOT NULL,
	nom VARCHAR(200) NOT NULL,
	note TEXT DEFAULT NULL,
	quantite SMALLINT NOT NULL,
	date_achat DATE DEFAULT NULL,
	PRIMARY KEY (id_bouteille),
	FOREIGN KEY (id_cellier) REFERENCES vino_cellier(id_cellier),
	FOREIGN KEY (id_type) REFERENCES vino_type(id_type)
) ENGINE=InnoDB;
