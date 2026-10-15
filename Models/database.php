<?php

try {
    $db_conn = new PDO("mysql:host=localhost;dbname=olympiade", "root");
    $db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie";
} catch (PDOException $ex) {
    echo "Connexion impossible" . $ex;
}
