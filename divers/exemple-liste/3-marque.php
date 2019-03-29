<?php
$servername = "localhost";
$dbname = "ajax";
$username = "root";
$password = "root";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->query("SELECT DISTINCT `marque` from `voiture` ORDER BY `marque`");
    $rows = $stmt->fetchAll();
    echo("<select id='marque2' name='marque' onchange='marque()'>");
    echo("<option value='' disabled selected style='display:none;'>Marque</option>\n");
    foreach($rows as $row) {
        $marque = $row['marque'];
        echo("<option value=" . $marque . ">" . $marque . "</option>\n");
    }
    echo("</select>");
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?> 
