SELECT cb.id AS id_cellier_bouteille,
cb.date_achat AS date_achat,
cb.quantite AS quantite,
cellier.libelle AS nom_cellier,
bouteille.id AS id_bouteille,
bouteille.libelle AS nom,
bouteille.code_saq AS code_SAQ,
bouteille.date_buvable AS date_buvable,
bouteille.prix AS prix,
bouteille.millesime AS millesime,
bouteille.pays AS pays,
bouteille.format AS format,
bouteille.note AS note,
type.libelle AS type
FROM vino_cellier__bouteille cb
INNER JOIN vino_cellier cellier
	ON cellier.id = cb.id_cellier
INNER JOIN vino_cellier__usager cu
	ON cu.id_cellier = cellier.id
INNER JOIN vino_usager usager
	ON usager.id = cu.id_usager
INNER JOIN vino_bouteille bouteille 
	ON bouteille.id = cb.id_bouteille
LEFT JOIN vino_type type
	ON type.id = bouteille.id_type
WHERE cu.id_role = 1
	AND cellier.id = ' . $id_cellier . '
ORDER BY bouteille.libelle

SELECT 
	id_bouteille,
	code_saq,
	prix,
	millesime,
	type,
	pays,
	format,
	bouteille.nom AS nom_bouteille,
	note,
	quantite,
	date_achat,
	boire_avant
FROM vino_bouteille AS bouteille
JOIN vino_cellier AS cellier
	ON bouteille.id_cellier = cellier.id_cellier
JOIN vino_usager AS usager
	ON cellier.id_usager = usager.id_usager
JOIN vino_type AS type
	ON bouteille.id_type = type.id_type
WHERE cellier.id_cellier = ' . $id_cellier . '
ORDER BY bouteille.nom