<p>Bonjour</p>
<?php $categorie = $result["data"]['categorie'];?>

<form style="display: flex; flex-direction:column; width:200px;" action="index.php?ctrl=topic&action=addTopic&id=<?= $categorie->getId() ?>" method="POST">

    <label for="topicName">topicName</label>
    <input type="text" name="topicName" id="topicName">
    <textarea style="max-width:200px; min-width:200px"rows="5" name="text" id="text"></textarea>
    <!--<<input type="text" style="display:none" name="category_id" value="1">
    label for="text">text</label>
    <input type="text" name="text" id="text">-->

    <input type="submit" name="submit" id="submit" value="Créer le topic">

</form>