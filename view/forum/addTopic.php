<?php if(isset($result["data"]['categorie'])){
    $categorie = $result["data"]['categorie'];
}
if(isset($_SESSION["user"])){
?>


<!--TITRE-->
<h3>Ajoutez un topic a la catégorie "<?=$categorie->getCategoryName()?>"</h3>

<!--FORM-->
<form class="form-add-topic" action="index.php?ctrl=topic&action=addTopic&id=<?= $categorie->getId() ?>" method="POST">

    <label for="topicName">Nom du topic</label>
    <input type="text" name="topicName" id="topicName">

    <label for="text">Description du topic</label>
    <textarea rows="5" name="text" id="text"></textarea>

    <input class="button-dark" type="submit" name="submit" id="submit" value="Créer le topic">

</form>
<?php 
}
else{
?>
<a href="index.php?ctrl=security&action=login">Veuillez vous connectez</a>

<?php } ?>
