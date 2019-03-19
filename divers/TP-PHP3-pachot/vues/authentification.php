    <main>
        <div class="row bg-light">
            <div class="col">
                <p></p>
            </div>
        </div>
        <div class="row text-center bg-light">
            <div class="col">
                <h2>Authentification</h2>
            </div>
        </div>
        <div class="row bg-light">
            <div class="col">
                <form action="index.php?Usagers&action=authentification"  method="post">
                    <div class="form-group">
                        <label for="identifiant">Identifiant : admin / usager / banni / admin2</label>
                        <input type="text" id="identifiant" name="nomUsager" value="admin" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="mdp">Mot de passe : 12345</label>
                        <input type="password" id="mdp" name="motDePasse" value="12345" class="form-control" >
                    </div>
                    <button type="submit" class="btn btn-primary">Se connecter</button>
                </form>
            </div>
        </div>
        <div class="row bg-light">
            <div class="col">
                <p></p>
            </div>
        </div>
    </main>
