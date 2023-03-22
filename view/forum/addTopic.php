<?php $categorie = $result["data"]['categorie'];?>
<p>Ajoutez un topic a la catégorie "<?=$categorie->getCategoryName()?>"</p>

<form class="form-add-topic" action="index.php?ctrl=topic&action=addTopic&id=<?= $categorie->getId() ?>" method="POST">

    <label for="topicName">Nom du topic</label>
    <input type="text" name="topicName" id="topicName">
    <label for="text">Description du topic</label>
    <textarea rows="5" name="text" id="text"></textarea>
    <!--<<input type="text" style="display:none" name="category_id" value="1">
    label for="text">text</label>
    <input type="text" name="text" id="text">-->

    <input class="button-dark" type="submit" name="submit" id="submit" value="Créer le topic">

</form>