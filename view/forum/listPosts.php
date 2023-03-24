<?php
// Au départ, on passe par l'index, qui va nous aiguiller vers une des methodes du controller
// Puis si on envoie une requette a la BDD, on passera par la couche "Manager" qui
// va renvoyer une réponse au "Controller" 
// et le controller va renvoyer une "View"

// dans le dossier view/forum, j'ai toutes mes views qui concernent le forum.

$posts = $result["data"]['posts'];
$topic = $result["data"]['topic'];
$error = $result["data"]['error'];
?>
<!-- CONTAINER PRINCIPAL DU TOPIC -->
<div class="forum-container">
  <!--HEADER DU TOPIC -->
  <div class="forum-header">
    <h2 class="forum-category"><a href="index.php?ctrl=topic&action=listTopicsByCategory&id=<?=$topic->getCategory()->getId()?>"><?=$topic->getCategory()->getCategoryName()?></a></h2>
    <h1 class="forum-title">/<?=$topic->getTopicName()?></h1>
  </div>
    <!--LIST des POSTS DU TOPIC -->
    <div class="forum-posts">
      <?php
      //si $posts est défini
      if($posts){
        /* Alors boucle qui pour chaque ligne stockées dans $posts
        va chercher les donnés demandées par les méthodes "getUser()" etc...
        */
        foreach($posts as $post){
      ?>
          <div class="forum-post-card">
              <div class="post-header">
                  <p class="post-user"><?=$post->getUser()->getNickName()?></p>
                  <p class="post-date"><?=$post->getPostDate()?></p>
              </div>
                  <p class="post-text"><?=$post->getText()?></p>
          </div>
      <?php
        }
      };
      ?>
    </div>
    
  <?php
//affiche un message "Veuillez vous connecter..." si aucune $_SESSION["user"] a été défini 
if(isset($error)){
  echo "<p>".$error."</p>";
}
?>
    <!-- FORMULAIRE DE REPONSE -->
    <form class="form-add-topic" action="index.php?ctrl=post&action=addPostByTopic&id=<?= $topic->getId() ?>" method="POST">
      
    <label for="text">Texte de la réponse</label>
    <textarea rows="5" name="text" id="text"></textarea>
    
    <input type="submit" name="submit" id="submit" value="Répondre">
    
  </form>
</div>
