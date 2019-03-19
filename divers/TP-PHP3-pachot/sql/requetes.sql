Liste des sujets :

SELECT id, nomUsager, dateCreation, titre
FROM php_posts 
WHERE idSujet IS NULL


Count
SELECT idSujet, COUNT(*) as nbReponses
FROM php_posts
WHERE idSujet IS NOT NULL
GROUP BY idSujet


dateCreation
SELECT idSujet, dateCreation
FROM php_posts
WHERE idSujet IS NOT NULL
ORDER BY dateCreation DESC


SELECT nb.idSujet, COUNT(*) as nbReponses, dc.dateCreation

SELECT id, nomUsager, dateCreation, titre

SELECT *
FROM php_posts sujets
LEFT JOIN (
    SELECT dc.idSujet, dc.dateCreation, nbReponses
    FROM php_posts as dc
    JOIN(
        SELECT idSujet, COUNT(*) as nbReponses
        FROM php_posts
        WHERE idSujet IS NOT NULL
        GROUP BY idSujet
        ) as nb
    ON nb.idSujet = dc.idSujet
    WHERE dc.idSujet IS NOT NULL
    ORDER BY dc.dateCreation DESC
    ) as nbdc
ON nbdc.idSujet = sujets.id
ORDER BY GREATEST(sujets.dateCreation, nbdc.dateCreation) DESC, (nbdc.dateCreation, sujets.dateCreation) DESC



SELECT post.id, post.idSujet, post.nomUsager, post.dateCreation, post.titre, count.nbReponses
FROM php_posts post
LEFT JOIN (
    SELECT idSujet, COUNT(*) as nbReponses
    FROM php_posts
    WHERE idSujet IS NOT NULL
    GROUP BY idSujet
    ) as count
ON post.idSujet = count.idSujet
ORDER BY post.dateCreation DESC




SELECT idSujet, COUNT(*) as nbReponses
    FROM php_posts
    WHERE idSujet IS NOT NULL
    GROUP BY idSujet

SELECT *    
FROM php_posts as p1
RIGHT JOIN (
    SELECT *    
    FROM php_posts
    ) as p2
ON p1.id = p2.idSujet




GROUP BY dc.idSujet




CREATE TABLE php_usagers(
    nomUsager VARCHAR(30) NOT NULL,
    motDePasse VARCHAR(70) NOT NULL,
    administrateur BOOL NOT NULL,
    banni BOOL NOT NULL,
    PRIMARY KEY(nomUsager)
);

CREATE TABLE php_sujets(
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    nomUsager VARCHAR(30) NOT NULL,
    dateCreation DATE NOT NULL,
    titre VARCHAR(200) NOT NULL,
    texte TEXT NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(nomUsager) REFERENCES php_usagers(nomUsager)
);

CREATE TABLE php_reponses(
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    idSujet BIGINT UNSIGNED NOT NULL,
    nomUsager VARCHAR(30) NOT NULL,
    dateCreation DATE NOT NULL,
    titre VARCHAR(200) NOT NULL,
    texte TEXT NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(nomUsager) REFERENCES php_usagers(nomUsager),
    FOREIGN KEY(idSujet) REFERENCES php_sujets(id)
);


question b)

SELECT dateCreation FROM php_reponses
ORDER BY dateCreation DESC
LIMIT 1



SELECT id as idSujet, nomUsager, dateCreation as dateCreationSujet, titre, idReponse, dateCreationReponse
FROM php_sujets as sujets
LEFT JOIN (
    SELECT id as idReponse, idSujet, dateCreation as dateCreationReponse
    FROM php_reponses
    ) as reponses
ON sujets.id =  reponses.idSujet

ORDER BY dateCreation DESC



# Mots clés par popularité
SELECT id, dateCreation, nbReponses
FROM php_reponses a
ORDER BY dateCreation DESC
JOIN (
    SELECT id AS idcount, COUNT(*) AS nbReponses
    FROM php_reponses
    GROUP BY idSujet
    ) b ON a.id = b.idcount


SELECT id AS idcount, COUNT(*) AS nbReponses
FROM php_reponses b
GROUP BY idSujet
JOIN (
    SELECT id AS idcount, COUNT(*) AS nbReponses
    FROM php_reponses
    GROUP BY idSujet
    ) b ON a.id = b.idcount




SELECT id AS idcount, COUNT(*) AS nbReponses
FROM php_reponses as count
GROUP BY idSujet
JOIN (
    SELECT id, dateCreation
    FROM php_reponses
    ORDER BY dateCreation DESC
    LIMIT 1 
) on php_reponses





SELECT id, dateCreation, nbReponses
FROM php_reponses a
JOIN (
    SELECT id AS idcount, COUNT(*) AS nbReponses
    FROM php_reponses b
  
    
    ) b ON a.id = b.idcount
LIMIT 1 
GROUP BY idSujet
ORDER BY dateCreation DESC





GROUP BY IDMotCle
ORDER BY nbrOccurences DESC, motCle;

# Mots clés par popularité
SELECT a.IDMotCle, motCle
FROM blog_articleMotCle a
JOIN blog_motCle ON a.IDMotCle = blog_motCle.ID
JOIN (
    SELECT IDMotCle, COUNT(*) AS nbrOccurences
    FROM blog_articleMotCle
    GROUP BY IDMotCle
    ) b ON a.IDMotCle = b.IDMotCle
GROUP BY IDMotCle
ORDER BY nbrOccurences DESC, motCle;