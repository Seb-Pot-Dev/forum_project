<?php
// Au départ, on passe par l'index, qui va nous aiguiller vers une des methodes du controller
// Puis si on envoie une requette a la BDD, on passera par la couche "Manager" qui
// va renvoyer une réponse au "Controller" 
// et le controller va renvoyer une "View"

// dans le dossier view/forum, j'ai toutes mes views qui concernent le forum.

$categories = $result["data"]['categories'];

?>

<h1>liste categories</h1>

<?php
if($categories){
foreach($categories as $category){

    ?>
    <a href="index.php?ctrl=topic&action=findTopicsByCategory&id=<?=$category->getId()?>"><?=$category->getCategoryName()?></a>
    <?php
}
};
?>

  
