<?php 
$user=$_SESSION["user"];
?>
<p>Mon pseudo : <?=$user->getNickname();?></p>
<p>Role : <?=$user->getRole();?></p>
<p>Date d'inscription : <?=$user->getRegistrationDate();?></p>
<p>Mon email : <?=$user->getEmail();?></p>
<p><a href="index.php?ctrl=security&action=linkToModifyPassword&id=<?=$user->getId()?>">Modifier on mot de passe</a></p>
<p>Etat du compte : 
<?php if($user->getBan()==1){

    echo "<p>Votre compte a été banni par un modérateur/administrateur.
    </p>";
}
else{?>
Valide</p>
<?php
} ?>
