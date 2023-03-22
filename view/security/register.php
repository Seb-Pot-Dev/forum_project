<!--TITRE-->
<?php
if (isset($result["data"]['error'])){
    $error = $result["data"]['error'];
};
// var_dump($error);die;
?>

<h3>Créer un compte utilisateur</h3>

<!--FORM-->
<form class="form-add-topic" action="index.php?ctrl=security&action=register" method="POST">

    <label for="nickName">Pseudo</label>
    <input type="text" name="nickName" id="nickName">

    <label for="password">Mot de passe</label>
    <input type ="text" name="password" id="password"></input>

    <label for="passwordConfirm">Confirmez le mot de passe</label>
    <input type ="text" name="passwordConfirm" id="passwordConfirm"></input>

    <label for="email">Email</label>
    <input type ="text" name="email" id="email"></input>


    <input class="button-dark" type="submit" name="submit" id="submit" value="Créer un compte">

</form>
<!--FIN FORM-->
<?php if(isset($error)){
    echo "<p>".$error."</p>";}
    ;?>