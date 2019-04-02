/**
 * @file Gestionnaire d’évènements
 * @author Alexandre Pachot
 * @version 0.1
 */
window.addEventListener("load", () =>
{
	document.getElementById("btnImporter").addEventListener("click", ()=>
	{
		vinoAdmin.importer()
	}, false);

}, false)
