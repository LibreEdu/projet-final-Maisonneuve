var webStorage = (function(donnees){

    // Nom de la clé du localStorage
    var nomStockage = donnees["nomStockage"] ;

    // Tableau contenant les données des visiteurs
    var visiteurs = JSON.parse(localStorage.getItem(nomStockage)) || [] ;

    // Compteur des identifiants
    var dernierId = visiteurs.pop() || 0 ;

    // Identifiant du visiteur dont on modifie les données
    var modifId = 0 ;

    // Identifiant du tableau HTML qui va contenir les données
    var idTableauHTML = donnees["idTableauHTML"];

    // Identifiants des champs du formulaire
    var idPrenom = donnees["idPrenom"];
    var idNom = donnees["idNom"];
    var idCourriel = donnees["idCourriel"];

    // Tableau HTML qui va contenir les informations des visiteurs
    var tableauHTML = document.getElementById(idTableauHTML);

    // Remplissage du tableau HTML avec les données des utilisateurs
    for (let i = 0; i < visiteurs.length ; i++) {
        let ligne = tableauHTML.insertRow(i);

        ligne.insertCell(0).innerHTML = visiteurs[i]["id"];
        ligne.insertCell(1).innerHTML = visiteurs[i]["prenom"];
        ligne.insertCell(2).innerHTML = visiteurs[i]["nom"];
        ligne.insertCell(3).innerHTML = visiteurs[i]["courriel"];
        ligne.insertCell(4).innerHTML = '<a href=javascript:void(0) onclick="webStorage.modifier(' + visiteurs[i]["id"] + ')">Modifier</a>';
        ligne.insertCell(5).innerHTML = '<a href=javascript:void(0) onclick="webStorage.supprimer(' + visiteurs[i]["id"] + ')">Supprimer</a>';
    }



    // Sauvegarde des données en local
    // recharger = true => recharge la page
    // recharger = false => ne recharge pas la page
    var sauvegarde = function(recharger = true) {
        // Sauvegarde du compteur des identifiants dans le tableau des visiteurs
        visiteurs.push(dernierId);

        // Sauvegarde des données en local
        var chaineVisiteurs = JSON.stringify(visiteurs);
        localStorage.setItem(nomStockage, chaineVisiteurs);

        // Rechargement de la page... pour afficher l’ajout ou la modification
        if (recharger) {
            location.reload();
        }
    }



    // Recherche dans le tableau des visiteur l’index du visiteur ayant "id" comme identifiant
    var index = function(id) {
        return visiteurs.findIndex(v => v.id === id);
    }



    // Remplissage du formulaire
    var formulaire = function(prenom = "", nom = "", courriel = "") {
        document.getElementById(idPrenom).value = prenom;
        document.getElementById(idNom).value = nom;
        document.getElementById(idCourriel).value = courriel;
    }



    // Récupération de l’identifiant du champ
    var idChamp = function(event) {
        return event.srcElement.id;
    }



    // Récupération du contenu du champs
    var contenuChamp = function(event) {
        // Récupération de l’identifiant du champ
        var id = idChamp(event);

        return document.getElementById(id).value ;
    }



    /**
     * Le module webStorage permet de gérer (ajout, modification et suppression) une liste d’individus (nom, prénom et courriel) et de la stocker en local.
     * @exports webStorage
     * @param {Object} donneesWebStorage    - Tableau de chaines de caractères. Les cinq clés du tableau associatif sont :
     * @param {String} nomStockage          - – le nom de la clé du localStorage ;
     * @param {String} idTableauHTML        - – l’identifiant du tableau HTML qui va contenir les données à afficher ;
     * @param {String} idPrenom             - – l’identifiant du champ du formulaire contenant le prénom ;
     * @param {String} idNom                - – l’identifiant du champ du formulaire contenant le nom ;
     * @param {String} idCourriel           - – l’identifiant du champ du formulaire contenant le courriel.
     * @example
     * var donneesWebStorage                = [];
     * donneesWebStorage["nomStockage"]     = "visiteurs";
     * donneesWebStorage["idTableauHTML"]   = "tVisiteurs";
     * donneesWebStorage["idPrenom"]        = "prenom";
     * donneesWebStorage["idNom"]           = "nom";
     * donneesWebStorage["idCourriel"]      = "courriel";
     */
    var obj = {};



    /**
     * Afficher les données du visiteur dans les champs du formulaire choisi afin de les modifier.
     * @param {Number} id - Identifiant de l’utilisateur à modifier
     * @example <a href=javascript:void(0) onclick="webStorage.modifier(1)">Modifier</a>
     */
    obj.modifier = function(id) {
        // Récupération des données
        var visiteur = visiteurs[index(id)];

        // Remplissage du formulaire
        formulaire(visiteur.prenom, visiteur.nom, visiteur.courriel);

        // Prise en compte qu’il s’agit d’une modification
        modifId = id;
    }



    /**
     * Supprime les données du stockage local.
     * @param {Number} id - Identifiant de l’utilisateur à supprimer
     * @example <a href=javascript:void(0) onclick="webStorage.supprimer(1)">Modifier</a>
     */
    obj.supprimer = function(id) {
        // Suppression du visiteur situé à l’index "index(id)" du tableau des visiteurs
        visiteurs.splice(index(id), 1);

        // Sauvegarde des données en local
        sauvegarde();
    }



    /**
     * Efface les données du formulaire.
     * @example <button onclick="webStorage.annuler()">Annuler</button>
     */
    obj.annuler = function() {
        location.reload();
    }



    /**
     * Sauvegarde les données du formulaire en local (local storage).
     * @example <button onclick="webStorage.sauver()">Sauver</button>
     */
    obj.sauver = function() {
        // Récupération des données
        var prenom = document.getElementById(idPrenom).value;
        var nom = document.getElementById(idNom).value;
        var courriel = document.getElementById(idCourriel).value;

        // Vérification de la longueur du nom et du prénom
        var messageErreur = (prenom.length < 2) ? "Le prénom doit contenir au moins deux caractères.\n" : "";
        messageErreur += (nom.length < 2) ? "Le nom doit contenir au moins deux caractères.\n" : "";

        // Vérification du courriel (https://emailregex.com/)
        var masqueCourriel = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        messageErreur += (masqueCourriel.test(courriel)) ? "" : "Le courriel n’est pas valide.\n";

        if (messageErreur) {
            window.alert(messageErreur);
        } else {
            // Objet visiteur qui va contenir les données de l’utilisateur
            var visiteur = new Object();

            visiteur.id = (modifId) ? modifId : ++dernierId;
            visiteur.prenom = prenom;
            visiteur.nom = nom;
            visiteur.courriel = courriel;

            // Vient-on d’une modification ou d’un ajout ?
            if (modifId) {
                // Modification du visiteur
                visiteurs.splice(index(modifId), 1, visiteur);
            } else {
                // Ajout du visiteur
                visiteurs.push(visiteur);
            }

            // Sauvegarde des données en local
            sauvegarde();
        }
    }



    /**
     * Formate la saisie d’un champ du formulaire : on ne peut saisir que des lettres (a-zàâéèêëîïôùûüÿçaæœ) et le tiret.
     * La première lettre deviendra un majuscule, le reste sera en minuscules.
     * Une fois que l’on tape un tiret, il n’y a plus de formatage de la case.
     * Le champ doit avoir un id.
     *
     * @param {Object} event - Évènement
     * @example document.getElementById("prenom").addEventListener("input", (event)=>
     * {
     *     webStorage.casePrenom(event);
     * }, false);
     */
    obj.casePrenom = function(event) {
        // Contenu du champ
        var champ = contenuChamp(event);

        // Masque de saisie
        // Premier groupe : une lettre
        // Deuxième groupe : des lettres
        // Troisième groupe : lettres ou tirets
        // Quatrième groupe : le reste
        var masque = /([a-zàâéèêëîïôùûüÿçaæœ]?)([a-zàâéèêëîïôùûüÿçaæœ]*)([a-zàâéèêëîïôùûüÿçaæœ\-]*)(.*)/i;

        // Contenu filtré
        var resultat = champ.replace(masque, function(correspondance, p1, p2, p3) {
            return p1.toUpperCase() + p2.toLowerCase() + p3;
        });

        // Récupération de l’identifiant du champ
        var id = idChamp(event);

        // Mise à jour du champ
        document.getElementById(id).value = resultat;
    }



    /**
     * Formate la saisie d’un champ du formulaire : on ne peut saisir que des lettres (a-zàâéèêëîïôùûüÿçaæœ), le tiret, l’apostrophe et l’espace.
     * La première lettre deviendra un majuscule, le reste sera en minuscules.
     * Une fois que l’on tape un tiret, une apostrophe ou une espace, il n’y a plus de formatage de la case.
     * Le champ doit avoir un id.
     *
     * @param {Object} event - Évènement
     * @example document.getElementById("nom").addEventListener("input", (event)=>
     * {
     *     webStorage.caseNom(event);
     * }, false);
     */
    obj.caseNom = function(event) {
        // Contenu du champ
        var champ = contenuChamp(event);

        // On remplace l’apostrophe droit par l’apostrophe typographique
        champ = champ.replace("'", "’");

        // Masque de saisie
        // Premier groupe : une lettre
        // Deuxième groupe : des lettres
        // Troisième groupe : lettres, apostrophes, tirets ou espaces
        // Quatrième groupe : le reste
        var masque = /([a-zàâéèêëîïôùûüÿçaæœ]?)([a-zàâéèêëîïôùûüÿçaæœ]*)([a-zàâéèêëîïôùûüÿçaæœ’\- ]*)(.*)/i;

        // Contenu filtré
        var resultat = champ.replace(masque, function(correspondance, p1, p2, p3) {
            return p1.toUpperCase() + p2.toLowerCase() + p3;
        });

        // Identifiant du champ de l'évènement
        var id = idChamp(event);

        // Mise à jour du champ
        document.getElementById(id).value = resultat;
    }



    /**
     * Formate la saisie d’un champ du formulaire en minuscule.
     * Le champ doit avoir un id.
     *
     * @param {Object} event - Évènement
     * @example document.getElementById("courriel").addEventListener("input", (event)=>
     * {
     *     webStorage.minuscule(event);
     * }, false);
     */

    obj.minuscule = function(event) {

        // Récupération de l’identifiant du champ
        var id = idChamp(event);

        // Récupération du contenu du champs
        var champ = contenuChamp(event);

        // Mise à jour du champ
        document.getElementById(id).value = champ.toLowerCase();
    }


    return obj;

})(donneesWebStorage);
