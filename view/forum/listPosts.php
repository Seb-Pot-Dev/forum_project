<?php
// Au départ, on passe par l'index, qui va nous aiguiller vers une des methodes du controller
// Puis si on envoie une requette a la BDD, on passera par la couche "Manager" qui
// va renvoyer une réponse au "Controller" 
// et le controller va renvoyer une "View"

// dans le dossier view/forum, j'ai toutes mes views qui concernent le forum.

$posts = $result["data"]['posts'];
$topic = $result["data"]['topic'];
?>

<h1><?=$topic->getTopicName()?></h1>
<!-- VOIR PROBLEMES ICI -->

<?php
if($posts){
    foreach($posts as $post){

    ?>
    <p><?=$post->getPostDate()?></p>
    <p><?=$post->getUser()->getNickName()?></p>
    <p><?=$post->getText()?></p>
    
    <?php
    // La clé etrangère est considéré comme une classe grâce au framework 
}
};
?>

  
