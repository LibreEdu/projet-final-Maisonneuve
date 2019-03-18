    <main>
        <div class="row bg-light">
            <div class="col">
                <p>Bonjour <?= $_SESSION["nomUsager"] ?></p>
            </div>
<?php
if ($_SESSION["administrateur"]){
?>
            <div class="col">
                <p class="text-center"><a href="index.php?Usagers&action=usagers">Administration</a></p>
            </div>
<?php
}
?>
            <div class="col">
                <p class="text-right"><a href="index.php?Usagers&action=deconnexion">Se déconnecter</a></p>
            </div>
        </div>
