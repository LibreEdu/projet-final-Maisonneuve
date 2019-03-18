		<div class="row bg-light">
            <div class="col">
                <p></p>
            </div>
        </div>
        <div class="row text-center bg-light">
            <div class="col">
                <h2>Ajouter un sujet</h2>
            </div>
        </div>
        <div class="row bg-light">
            <div class="col">
                <form method="POST" class="form-group">
                	Titre: <input type='text' name='titre' class='form-control'>
                	<br>
                	Question: <textarea name="question" class="form-control"></textarea>
                	<br>
                	<input type="hidden" name="action" value="insereSujet"/>
                    <button type="submit" value="Envoyer" class="btn btn-primary">Envoyer</button>     	
                </form>
<?php
                	if($data["erreurs"] != ""){
                		echo "\t\t\t\t<p>" . $data["erreurs"] . "</p>\n";
                	}
?>
            </div>
        </div>
