<?php

require_once('Connections/PHPSyslog.php');
mysqli_select_db($link, $database_PHPSyslog) or die ("Aucune database");

$DateToday = date("Y-m-d");						// Date actuelle au format MySQL
$HeureToday = date("H:i:s");					// Heure actuelle au format MySQL
$IP = get_ip();                       // Adresse IP de la machine qui nous envoie les informations

echo "La date est $DateToday<br>";


if ( isset($_GET['nom']) && isset($_GET['info']) ){

  $nom = $_GET['nom'];
  $info = $_GET['info'];
  if ( isset($_GET['IP'])) {          // On surcharge la variable IP si elle est transmise en même temps que les données
    $IP = $_GET['IP'];
  }

  // TODO : faire vérif que la taille de ces 2 données ne dépassent pas la taille maxi qui leur est dédiée dans la base/table

  // On vérifie que le module qui envoie des infos est reconnu
  $SQLRecupNom = "SELECT * FROM `IoT` WHERE `Nom` = '$nom';";
  $QuerySQLRecupNom = mysqli_query($link,$SQLRecupNom);
  $NbrReponseRecupNom = mysqli_num_rows($QuerySQLRecupNom);

  echo "NbrReponseRecupNom = $NbrReponseRecupNom<br>";
  if ($NbrReponseRecupNom == "1") {
    // On a bien trouvé le nom de la machine dans la config; on va pouvoir contnuer
    $SQLUpdateInfo = "INSERT INTO `ArchiveLOG` (`NomMachine`, `IP`, `DateEnregistrement`, `HeureEnregistrement`, `Information`) VALUES 
                      ('$nom', '$IP', '$DateToday', '$HeureToday', '$info');";
    echo $SQLUpdateInfo;
    mysqli_query($link,$SQLUpdateInfo) or die('Erreur SQL !'.$sql.'<br>'.mysqli_error().'<br>');

  } /*else {
      // Le nom de la machine renvoyé n'est pas présent dans la base
      // Il faut sortir
      echo "La machine n'est pas enregistrée dans le serveur : commencez par l'enregistrer !";

  } // Fin du test qui vérifie que le nom de la machine est bien déclarée
  
  
} // Fin du test qui vérifie la présence de données reçues
*/
mysqli_free_result($QuerySQLRecupNom);
}

//-- Fonction de récupération de l'adresse IP du visiteur
function get_ip()
{
    if ( isset ( $_SERVER['HTTP_X_FORWARDED_FOR'] ) )
    {
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
      echo "<br>HTTP_X_FORWARDED_FOR<br>";
    }
    elseif ( isset ( $_SERVER['HTTP_CLIENT_IP'] ) )
    {
      $ip  = $_SERVER['HTTP_CLIENT_IP'];
      echo "<br>HTTP_CLIENT_IP<br>";
    }
    else
    {
      $ip = $_SERVER['REMOTE_ADDR'];
      echo "<br>REMOTE_ADDR<br>";
    }
    return $ip;
}
?>
