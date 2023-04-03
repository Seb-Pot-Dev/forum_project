<?php
if (isset($result["data"]['post'])){
$post = $result["data"]['post'];
}
?>
<form action="index.php?ctrl=post&action=modifyPost&id=<?=$post->getId()?>" method="POST">

    <label for="text">Modifier la réponse</label>
    <textarea rows="5" name="text" id="text" required><?=$post->getText()?></textarea>
        
    <input type="submit" name="submit" id="submit" value="Modifier">

</form>