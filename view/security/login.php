<?php
if (isset($result["data"]['error'])){
    $error = $result["data"]['error'];
};
if(isset(["data"]['success'])){
    $success = $result["data"]['success'];
};
// var_dump($error);die;
?>

<form class="form-add-topic" action="index.php?ctrl=security&action=login" method="post">

    <label for="email">Email</label>
    <input type ="text" name="email" id="email"></input>

    <label for="password">Mot de passe</label>
    <input type ="password" name="password" id="password"></input>

    <input class="button-dark" type="submit" name="submit" id="submit" value="Se connecter">

</form>

<?php if(isset($error)){
    echo "<p>".$error."</p>";}
    ;?>