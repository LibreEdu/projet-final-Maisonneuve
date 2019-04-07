var data = new Date(),
mois = '' + (data.getMonth() + 1),
jour = '' + data.getDate(),
annee = data.getFullYear();

if (mois.length < 2) mois = '0' + mois;
if (jour.length < 2) jour = '0' + jour;

date_jour = annee+'-'+mois+'-'+jour;

function ValiderChamps(){ 


   if (document.form.boire_avant.value < document.form.date_achat.value) {
      alert("La date doit être postérieur à la date d'achat")
      document.form.boire_avant.focus()
      return false;
   }

   if (document.form.date_achat.value > date_jour) {
		var resultat = confirm("Voulez-vous entrer une date d'achat postérieure à la date du jour ?");
		if(resultat == true){
			return true;
		}
		if(resultat == false){
			document.form.date_achat.focus();
			return false;
		}	
   }
return (true);
} 
