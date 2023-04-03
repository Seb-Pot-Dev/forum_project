<?php
if (isset($result['data']['user'])) {
    $user = $result['data']['user'];
}
if($_SESSION["user"]->getId() == $user->getId()){ ?>

<form class="form-add-topic" action ="index.php?ctrl=security&action=modifyPassword&id=<?=$_SESSION["user"]->getId()?>" method = "POST">

    <label for="password">Mot de passe actuel</label>
    <input type="password" name="password" id="password" required>

    <label for="passwordConfirm">Nouveau mot de passe</label>
    <input type ="password" name="passwordConfirm" id="passwordConfirm" required></input>

    <label for="newPassword">Confirmez le nouveau mot de passe</label>
    <input type ="password" name="newPassword" id="newPassword" required></input>

    <input type="submit" name="submit" value="Changer">

</form>
<?php } ?>