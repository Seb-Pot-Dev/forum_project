
<h3>Créer un compte utilisateur</h3>

<!--FORM-->
<form class="form-add-topic" action="index.php?ctrl=security&action=register" method="POST">

    <label for="nickName">Pseudo</label>
    <input type="text" name="nickName" id="nickName" required>

    <label for="password">Mot de passe</label>
    <input type ="password" name="password" id="password" required></input>

    <label for="passwordConfirm">Confirmez le mot de passe</label>
    <input type ="password" name="passwordConfirm" id="passwordConfirm" required></input>

    <label for="email">Email</label>
    <input type ="text" name="email" id="email" required></input>


    <input class="button-dark" type="submit" name="submit" id="submit" value="Créer un compte">

</form>
<!--FIN FORM-->
