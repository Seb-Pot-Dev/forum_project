<?php
if (isset($result["data"]['user'])) {
    $user = $result["data"]['user'];
}

if (isset($_SESSION['user'])) {
    if ($_SESSION['user']->getRole() == ('admin' || 'administrator')) {
        $admin = true;
    } else {
        $admin = false;
    }
}

if ($admin && ($user->getBan()==0)) {
    // var_dump("text");die; // VOIR LES PROBLEMES ICI
?>
    <a class="button-red" href="index.php?ctrl=security&action=banUser&id=<?= $user->getId() ?>">Bannir cet utilisateur</a>

<?php
}
elseif($admin && ($user->getBan()==1)){
?>
    <a class ="button-green" href="index.php?ctrl=security&action=unbanUser&id=<?= $user->getId() ?>">Débannir cet utilisateur</a>
<?php
}
?>


<p>Pseudo : <?= $user->getNickname(); ?></p>
<p>Role : <?= $user->getRole(); ?></p>
<p>Date d'inscription : <?= $user->getRegistrationDate(); ?></p>
<p>Email: <?= $user->getEmail(); ?></p>
<div style="display:flex; flex-direction:row; align-items:center;">Etat du compte:
    <?php if ($user->getBan() == 1) {

        echo "<p class='button-red'>banni</p>";
    } else {
        echo "<p class='button-green'>valide</p>";
    }
    ?>
</div>