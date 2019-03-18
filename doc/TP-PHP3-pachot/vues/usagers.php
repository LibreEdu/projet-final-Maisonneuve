        <div class="row bg-light">
            <div class="col">
                <p></p>
            </div>
        </div>
<?php
    // Récupération des données
    $usagers = $data["usagers"];

    foreach($usagers as $usager) {
        if ($usager->nomUsager != MAINADMIN) {
?>
        <div class="row bg-light">
<?php
            if ($usager->banni) {
?>
            <div class="col-lg-1">
<?php
                echo "\t\t\t\t$usager->nomUsager\n";
?>
            </div>
            <div class="col-lg-1">
<?php
                echo "\t\t\t\t<a href='index.php?Usagers&action=gracier&nomUsager={$usager->nomUsager}'>gracier</a>\n";
?>
            </div>
<?php
            } else {
?>
            <div class="col-lg-1">
<?php
                echo "\t\t\t\t$usager->nomUsager\n";
?>
            </div>
            <div class="col-lg-1">
<?php
                echo "\t\t\t\t<a href='index.php?Usagers&action=bannir&nomUsager={$usager->nomUsager}'>bannir</a>\n";
?>
            </div>
<?php
            }
?>
        </div>
<?php
        }
    }
?>
        <div class="row bg-light">
            <div class="col">
                <p></p>
            </div>
        </div>
    </main>
