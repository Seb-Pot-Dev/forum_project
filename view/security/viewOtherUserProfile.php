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

if ($admin) {
    // var_dump("text");die; // VOIR LES PROBLEMES ICI
?>
    <a href="index.php?ctrl=security&action=banUser&id=<?= $user->getId() ?>">Bannir cet utilisateur</a>

<?php
}
?>


<p>Pseudo : <?= $user->getNickname(); ?></p>
<p>Role : <?= $user->getRole(); ?></p>
<p>Date d'inscription : <?= $user->getRegistrationDate(); ?></p>
<p>Email: <?= $user->getEmail(); ?></p>
<p>Etat du compte:
    <?php if ($user->getBan() == 1) {

        echo "banni";
    } else {
        echo "normal";
    }
    ?>
</p>