<?php
// Au départ, on passe par l'index, qui va nous aiguiller vers une des methodes du controller
// Puis si on envoie une requette a la BDD, on passera par la couche "Manager" qui
// va renvoyer une réponse au "Controller" 
// et le controller va renvoyer une "View"

// dans le dossier view/forum, j'ai toutes mes views qui concernent le forum.
if (isset($result["data"]['posts'])){
$posts = $result["data"]['posts'];
}
if (isset($result["data"]['topic'])){
$topic = $result["data"]['topic'];
}
if (isset($result["data"]['error'])){
$error = $result["data"]['error'];
}
//Vérification si le user est admin OU que c'est son topic
$OwnerTopicId = $topic->getUser()->getId();
  if($_SESSION["user"]->getRole()=='admin' || $_SESSION["user"]->getId()==$OwnerTopicId){
    $admin = true;
  }
                
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
        //initialisation de $countPost a 0;
        $countPost = 0;
        /* Boucle qui pour chaque ligne stockées dans $posts
        va chercher les donnés demandées par les méthodes "getUser()" etc...
        */
        foreach($posts as $post){
        //on incrémente $countPost a chaque tour de boucle
        $countPost++;
      ?>
          <div class="forum-post-card">
              <div class="post-header">
                  <p class="post-user"><?=$post->getUser()->getNickName()?></p>
                  <p class="post-date"><?=$post->getPostDate()?></p>
                  <?php
                  //Si $admin est déclaré et que ce n'est pas le premier post
                  if($admin=true && $countPost>1){
                  echo
                  "<a href='index.php?ctrl=post&action=deletePost&id=".$post->getId()."'>
                  <p>Suppr</p>
                  </a>";
                  } ?>
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
