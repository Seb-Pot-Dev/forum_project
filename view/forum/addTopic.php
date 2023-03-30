<?php if(isset($result["data"]['category'])){
    $category = $result["data"]['category'];
}
if(isset($_SESSION["user"])){
?>


<!--TITRE-->
<h3>Ajoutez un topic a la catégorie "<?=$category->getCategoryName()?>"</h3>

<!--FORM-->
<form class="form-add-topic" action="index.php?ctrl=topic&action=addTopic&id=<?= $category->getId() ?>" method="POST">

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
