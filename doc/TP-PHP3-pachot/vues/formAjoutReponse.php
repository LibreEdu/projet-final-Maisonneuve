        <div class="row bg-light">
            <div class="col">
                <br>
                <form method="POST" class="form-group">
                	Titre: <?php echo "<input type='text' name='titre' value='Re : {$data['sujet']->titre}' class='form-control'>"; 
?>

                	<br>
                	Réponse: <textarea name="reponse" class="form-control"></textarea>
                	<br>
<?php
    echo "\t\t\t\t\t<input type='hidden' name='id' value='" . $data['sujet']->id . "'>\n";
?>
                	<input type="hidden" name="action" value="insereReponse"/>
                    <button type="submit" value="Envoyer" class="btn btn-primary">Envoyer</button>   	
                </form>
<?php
	if($data["erreurs"] != ""){
		echo "<p>" . $data["erreurs"] . "</p>";
	}
?>
            </div>
        </div>

