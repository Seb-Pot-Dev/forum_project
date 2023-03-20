<?php
// Au départ, on passe par l'index, qui va nous aiguiller vers une des methodes du controller
// Puis si on envoie une requette a la BDD, on passera par la couche "Manager" qui
// va renvoyer une réponse au "Controller" 
// et le controller va renvoyer une "View"

// dans le dossier view/forum, j'ai toutes mes views qui concernent le forum.

$posts = $result["data"]['posts'];
$topic = $result["data"]['topic'];
?>

<div class="forum-container">
  <div class="forum-header">
    <h2 class="forum-category"><a href="index.php?ctrl=topic&action=listTopicsByCategory&id=<?=$topic->getCategory()->getId()?>"><?=$topic->getCategory()->getCategoryName()?></a></h2>
    <h1 class="forum-title">/<?=$topic->getTopicName()?></h1>
  </div>
  <div class="forum-posts">
    <?php
    if($posts){
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
</div>
