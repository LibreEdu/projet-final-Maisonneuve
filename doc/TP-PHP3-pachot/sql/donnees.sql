CREATE DATABASE IF NOT EXISTS e1795854 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE e1795854;

CREATE TABLE php_usagers(
    nomUsager VARCHAR(30) NOT NULL,
    motDePasse VARCHAR(70) NOT NULL,
    administrateur BOOL NOT NULL,
    banni BOOL NOT NULL,
    PRIMARY KEY(nomUsager)
);

CREATE TABLE php_posts(
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    idSujet BIGINT UNSIGNED,
    nomUsager VARCHAR(30) NOT NULL,
    dateCreation DATETIME NOT NULL,
    titre VARCHAR(200) NOT NULL,
    texte TEXT NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(nomUsager) REFERENCES php_usagers(nomUsager)
);


-- https://www.developpez.net/forums/d1901645/php/langage/modele-mvc-cas-pratique/
-- https://www.developpez.net/forums/d1901861/php/php-sgbd/php-mysql/envoi-formulaire-fieldset/
-- https://www.developpez.net/forums/d1901415/php/php-sgbd/php-mysql/creer-table-mysql-automatiquement-via-form/

INSERT INTO php_usagers VALUES ("admin", "$2y$10$QE/gmwBMTz1I6syKKeQtde8xMj7TxuhBhpfvjgH7sHRWqgtI14mKy", 1, 0); # mot de passe = 12345
INSERT INTO php_usagers VALUES ("usager", "$2y$10$QE/gmwBMTz1I6syKKeQtde8xMj7TxuhBhpfvjgH7sHRWqgtI14mKy", 0, 0);  # mot de passe = 12345
INSERT INTO php_usagers VALUES ("admin2", "$2y$10$QE/gmwBMTz1I6syKKeQtde8xMj7TxuhBhpfvjgH7sHRWqgtI14mKy", 1, 0);  # mot de passe = 12345
INSERT INTO php_usagers VALUES ("banni", "$2y$10$QE/gmwBMTz1I6syKKeQtde8xMj7TxuhBhpfvjgH7sHRWqgtI14mKy", 0, 1);  # mot de passe = 12345


INSERT INTO php_posts VALUES (1, null, "banni", "2018-10-10 03:15:00", "Comment créer une table mySQL automatiquement via un form", "Bonjour,

comment générer automatiquement une table mySQL via un formulaire ?");

INSERT INTO php_posts VALUES (2, null, "admin", "2018-10-10 11:54:00", "Modele MVC. Cas pratique.", "Bonjour.
J'apprends la methode Mvc, en autodidacte. Je n'ai pas acces à mon éditeur de texte car mon pc bugg et va bientôt rendre l'âme.
En théorie, j'ai compris la méthode mvc et maintenant je me suis fait un exercice et c'est vrai que je ne suis pas certain de ma réponse.

C'est le premier exercice que je me lance. Il s'agit d'un formulaire à remplir.
Donc ma réponse est la suivante

Le formulaire, je le rédige dans la vue
Dans le modèle, j'ai crée une fonction qui permet de se connecter à la base de donnée
Dans le contrôleur, j'ai crée un code qui dit en gros que si l'utilisateur clique sur le bouton pour indiquer qu'il a rempli le formulaire et si l'ensemble des champs ont bien ete remplis, on affiche un message qui indique que le formulaire a bien été remplis

Mon code est il correcte*?
J'hésite, le code qui a pour but de voir si l'utilisateur a bien remplis le formulaire, je me demande si je ne dois pas le mettre dans le modele*?

Merci d'avance pour vos réponses");

INSERT INTO php_posts VALUES (3, 2, "usager", "2018-10-10 12:27:00", "Re : Modele MVC. Cas pratique.", "Salut,

la vérification de la présence/validité des données pour chaque action doit être faite par le modèle.
La raison est simple : c'est que tu peux dans ton code avoir besoin d’enchaîner des accès au modèle et dans ce cas, ils doivent être le plus autonome possible car tu vas t'affranchir du contrôleur.");

INSERT INTO php_posts VALUES (4, 1, "usager", "2018-10-10 22:54:00", "Re : Comment créer une table mySQL automatiquement via un form", "Oui dans le contrôleur tu contrôle juste l'envoi du formulaire, et dans le modèle tu contrôle la validité des données. En plus des avantages déjà indiqués par rawsrc cela te permettra d'avoir un contrôleur plus lisible et de renforcer la sécurité de tes scripts.");

INSERT INTO php_posts VALUES (5, 2, "usager", "2018-10-11 04:35:00", "Re : Modele MVC. Cas pratique.", "Oui dans le contrôleur tu contrôle juste l'envoi du formulaire, et dans le modèle tu contrôle la validité des données. En plus des avantages déjà indiqués par rawsrc cela te permettra d'avoir un contrôleur plus lisible et de renforcer la sécurité de tes scripts.");


INSERT INTO php_posts VALUES (6, null, "usager", "2018-10-11 06:02:00", "Envoi de formulaire avec <fieldset>", "Bonsoir,

J'ai un petit souci avec l'un de mes formulaires (j'ai mis le code source ci-dessous).
Ma requête SQL ne fonctionne pas avec le code tel quel. Pourtant, quand je retire les 3 <fieldset></fieldset>, la requête fonctionne et arrive bien dans ma BDD !
Je suis obligé de garder ces <fieldset>, sinon, ma page ne ressemble plus à rien.. (voir screen ci-dessous)

En vous remerciant pour votre aide,

à bientôt !");