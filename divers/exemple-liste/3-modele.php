<?php
$servername = "localhost";
$dbname = "ajax";
$username = "root";
$password = "root";

$marque=$_POST["marque"];
// echo($marque);

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    // echo("SELECT DISTINCT `modele` from `voiture` WHERE `marque` = '$marque' ORDER BY `modele`");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->query("SELECT DISTINCT `modele` from `voiture` WHERE `marque` = '$marque' ORDER BY `modele`");
    $rows = $stmt->fetchAll();
    echo("<ul>\n");
    foreach($rows as $row) {
        $modele = $row['modele'];
        echo("<li>" . $modele . "</li>\n");
    }
    echo("</ul>\n");
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?> 
