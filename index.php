<!DOCTYPE html>
<html>
	<head>
		<title>CRUD</title>
		<meta charset="utf-8"/>
		<link rel="stylesheet" href="sospartner.css">
	</head>

	<body>
			<div class="MenuApp">
				<span class="onglet"><a href="inscription.php">Je m'inscris !</a></span>
				<span class="onglet"><a href="rechercher.php">Rechercher</a></span>
				<span class="onglet"><a href="partenaires.php">Partenaires</a></span>
			</div>
		<div class="App">
			<h3>S.O.S Partner</h3>
				<p>Bienvenue sur l'application S.O.S partner , inscrivez-vous , connectez-vous puis trouver un partenaire pour vos activités préférées</p>

				<h2>Connexion</h2> 

<h3>Login</h3>
<form method="post" action="index.php">

<input type="text" name="pseudo"/>

<h3>Mot de passe</h3>

<input type="password" name="mdp"/>
<hr>
<input type="submit" value="Valider"/>
</br>
</br>
<input type="checkbox" name="ssvdm"
	
<?php if(isset($_COOKIE['ssvdm'])){
	echo 'checked';
						}
?> />  <b>Se Souvenir de Moi</b>
 <div>
<?php
session_start();

if (isset($_COOKIE['ssvdm'])) {
  if (isset($_SESSION['pseudo']) && isset($_SESSION['mdp'])){
      if($_SESSION['pseudo'] == $_COOKIE['pseudo'] && $_SESSION['mdp'] == $_COOKIE['mdp']){
       header('Location: crud.php');
       exit;
      }
    }
}


// Connexion a la bdd
try
{ 
$bdd = new PDO('mysql:host=localhost;dbname=bddmodules;charset=utf8', 'root', '');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

// Traitement du formulaire
if (isset($_POST['pseudo'])&& isset($_POST['mdp'])){

  $request = $bdd->query('select count(*) as nb from users WHERE login="'.$_POST['pseudo'].'" AND mdp="'.$_POST['mdp'].'"');

  $donnees = $request->fetch(PDO::FETCH_ASSOC);

  //while ($donnees = $request->fetch()){
  if ($donnees['nb'] == 1){
    // Renseigne la variable de session
    if(!isset($_SESSION['pseudo']) &&  !isset($_SESSION['mdp'])){
    $_SESSION['pseudo'] = $_POST['pseudo'];
    $_SESSION['mdp'] = $_POST['mdp'];
}
    
    if(isset($_POST['ssvdm'])) {
      $expiration = time() + 365*24*3600;
      setcookie('pseudo',$_POST['pseudo'], $expiration); 
      setcookie('mdp',$_POST['mdp'], $expiration);
      setcookie('ssvdm',$_POST['ssvdm'], $expiration); 
    }
    header('Location: crud.php');
    exit;
}
    else{
  echo "Les identifiants que vous avez entrez sont incorrects";
  }
}
else /*(!isset($_POST['pseudo']) && !isset($_POST['mdp']))*/{
	echo "Entrez vos identifiants";
}


?>

		</div>
	</body>

</html>