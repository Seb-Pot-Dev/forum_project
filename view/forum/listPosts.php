<?php
// Au départ, on passe par l'index, qui va nous aiguiller vers une des methodes du controller
// Puis si on envoie une requette a la BDD, on passera par la couche "Manager" qui
// va renvoyer une réponse au "Controller" 
// et le controller va renvoyer une "View"

// dans le dossier view/forum, j'ai toutes mes views qui concernent le forum.

$posts = $result["data"]['posts'];
$topic = $result["data"]['topic'];
?>
<!-- "$topic->getCategory()" est un objet "Category" donc on peut lui appliquer une méthode de l'entité "Category" --->
<h1><a href="index.php?ctrl=topic&action=listTopicsByCategory&id=<?=$topic->getCategory()->getId()?>"><?=$topic->getCategory()->getCategoryName()?></a>/<?=$topic->getTopicName()?></h1>

<?php
if($posts){
    foreach($posts as $post){

    ?>
    <p><?=$post->getPostDate()?></p>
    <p><?=$post->getUser()->getNickName()?></p>
    <p><?=$post->getText()?></p>
    
    <?php
    // La clé etrangère est considéré comme une classe grâce au framework 
    // Donc $topic est une classe, 
}
};
?>

  
