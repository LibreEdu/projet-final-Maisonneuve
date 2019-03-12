function ValiderChamps(){ 


    if (document.form.nom.value=="" || document.form.nom.value== null || document.form.nom.value.length== 0 || /^\s+$/.test(document.form.nom.value)) { 
       alert("Entrez le nom de la bouteille") 
       document.form.nom.focus() 
       return (false); 
    } 
 
    /*if (document.form.Code_Postal.value=="" || document.form.Code_Postal.value== null || document.form.Code_Postal.value.length== 0 || /^\s+$/.test(document.form.Code_Postal.value)) {
       alert("�crivez votre code postal \n Enter your postal code")
       document.form.Code_Postal.focus()
       return false;
    }

    if (document.form.Courriel.value=="" || document.form.Courriel.value== null || document.form.Courriel.value.length== 0 || /^\s+$/.test(document.form.Courriel.value)) {
	alert("Adresse courriel vide \n Empty email");
	document.form.Courriel.focus();
	return false;
    }
	
    if(!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(document.form.Courriel.value))) {
	alert("Adresse courriel incorrecte \n Wrong email \n ex: name@domain.com");
	document.form.Courriel.focus();
	return false;
    }*/
return (true);
} 
