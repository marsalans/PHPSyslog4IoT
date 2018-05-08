<?php
// On importe les params de connexion à la base
require_once('Connections/PHPSyslog.php');
mysqli_select_db($link, $database_PHPSyslog) or die ("Aucune database");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>IoT Syslog : voir tous les LOGs</title>
</head>
<body>

<p>(<a href="index.php">Retour Page d'accueil</a>)</p>
<table width="80%" border="6" align="center">
  <tbody>
    <tr>
      <td bgcolor="#ABA3A3" style="text-align: center"><h1><strong>Date</strong></h1></td>
      <td bgcolor="#ABA3A3" style="text-align: center"><h1><strong>Heure</strong></h1></td>
      <td bgcolor="#ABA3A3" style="text-align: center"><h1><strong>Machine</strong></h1></td>
      <td bgcolor="#ABA3A3" style="text-align: center"><h1><strong>Informations</strong></h1></td>
    </tr>
    <tr>
<?php
  
  $DateToday = date("Y-m-d");						// Date actuelle au format MySQL

  $SQLAfficheTotal = "SELECT * FROM `ArchiveLOG` WHERE `DateEnregistrement` = '$DateToday';";
  $QuerySQLAfficheTotal = mysqli_query($link, $SQLAfficheTotal);
  while ($ResulSQLAfficheTotal = mysqli_fetch_assoc($QuerySQLAfficheTotal)) {
    
    echo "<td>" . $ResulSQLAfficheTotal['DateEnregistrement'] . "</td>\n";
    echo "<td>" . $ResulSQLAfficheTotal['HeureEnregistrement'] . "</td>\n";
    echo "<td>" . $ResulSQLAfficheTotal['NomMachine'] . "</td>\n";
    echo "<td>" . $ResulSQLAfficheTotal['Information'] . "</td>\n";
    echo "</tr>\n";
    
  }
  
?>
    </tr>
  </tbody>
</table>

<p>&nbsp;</p>
</body>
</html>


