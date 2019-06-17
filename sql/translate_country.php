<?php
require_once("../config.php");
require_once("../model/Database.php");

// Composer black magic dependency injection
require __DIR__ . '/vendor/autoload.php';
use Stichoza\GoogleTranslate\GoogleTranslate;

// Instanciate Google Translate stuff
$tr = new GoogleTranslate('en'); // Translates into English
$tr->setSource('fr');

// Database replacement
$db = Database::getConnection();
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $db->prepare("select * from country");
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
while ($row = $stmt->fetch()) {
    $translation = ucfirst($tr->translate($row["name_fr"]));
    echo $row["name_fr"] . " | " . $translation . PHP_EOL;

    $stmt2 = $db->prepare("update country set name = :translation where name_fr = :original");
    $stmt2->bindParam(':translation', $translation);
    $stmt2->bindParam(':original'   , $row["name_fr"]);
    $stmt2->execute();
}
