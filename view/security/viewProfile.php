<?php 
$user=$_SESSION["user"];
?>
<p>Mon pseudo : <?=$user->getNickname();?></p>
<p>Role : <?=$user->getRole();?></p>
<p>Date d'inscription : <?=$user->getRegistrationDate();?></p>
<p>Mon email : <?=$user->getEmail();?></p>
<?php if($user->getBan()==1){

    echo "<p>Etat du compte : Votre compte a été banni par un administrateur.
    </p>";
}

?>
