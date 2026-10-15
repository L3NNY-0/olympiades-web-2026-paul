<?php

function requeteBdd(string $requete)
{
    try {
        $db_conn = new PDO("mysql:host=localhost;dbname=olympiade", "root");
        $db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $requete = $db_conn->query($requete);
        
        while ($row = $requete->fetch()) {
            # code...
        }
    } catch (PDOException $ex) {
        echo "Connexion impossible : " . $ex;
    }
}
