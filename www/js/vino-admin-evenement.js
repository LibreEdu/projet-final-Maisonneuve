/**
 * @file Gestionnaire d’évènements de Vino admin
 * @author Alexandre Pachot
 * @version 0.1
 */
window.addEventListener("load", () =>
{
	document.getElementById("btnImporter").addEventListener("click", ()=>
	{
		vinoAdmin.importer();
	}, false);

	document.getElementById("btnIndice").addEventListener("input", ()=>
	{
		vinoAdmin.changerIndice();
	}, false);

}, false)
