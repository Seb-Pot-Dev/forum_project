<?php
// Au départ, on passe par l'index, qui va nous aiguiller vers une des methodes du controller
// Puis si on envoie une requette a la BDD, on passera par la couche "Manager" qui
// va renvoyer une réponse au "Controller" 
// et le controller va renvoyer une "View"

// dans le dossier view/forum, j'ai toutes mes views qui concernent le forum.

$topics = $result["data"]['topics'];

?>

<h1>liste topics</h1>

<?php
if($topics){
foreach($topics as $topic){

    ?>
    <p><?=$topic->getTopicName()?></p>
    <?php
}
};
?>

  
