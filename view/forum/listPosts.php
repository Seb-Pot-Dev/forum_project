<?php

if (isset($result["data"]['posts'])){
$posts = $result["data"]['posts'];
}
if (isset($result["data"]['topic'])){
$topic = $result["data"]['topic'];
}
if (isset($result["data"]['error'])){
$error = $result["data"]['error'];
}
  //Récupération du userId
  $OwnerTopicId = $topic->getUser()->getId();
//(Vérification si le user est défini) ET (qu'il est admin OU modérateur)
if (isset($_SESSION["user"]) && ($_SESSION["user"]->getRole()=='admin' || $_SESSION["user"]->getRole()=='moderator')) {
  $admin=true;
}
else{
  $admin=false;
}
                
?>
<!-- CONTAINER PRINCIPAL DU TOPIC -->
<div class="post-container">
  <!--HEADER DU TOPIC -->
  <div class="forum-header">
  <div class="forum-header-left">
    <h2 class="forum-category"><a href="index.php?ctrl=topic&action=listTopicsByCategory&id=<?=$topic->getCategory()->getId()?>"><?=$topic->getCategory()->getCategoryName()?></a></h2>
    <h1 class="forum-title">/<?=$topic->getTopicName()?></h1>
  </div>
      <div class="forum-header-right">
      <?php if($admin){
      if($topic->getLocked()==0){ ?>
        <a title="Vérouiller le sujet" class='icon-admin' href='index.php?ctrl=topic&action=lockTopicFromTopic&id=<?=$topic->getId()?>'><i class='fa-solid fa-lock'></i></a>      
      <?php }
      else{ ?>
        <a title="Déverouiller le sujet" class='icon-admin-green' href="index.php?ctrl=topic&action=lockTopicFromTopic&id=<?=$topic->getId()?>"><i class="fa-solid fa-lock-open"></i></a>
      <?php }
      if((isset($_SESSION["user"]) && $_SESSION["user"]->getId())==$topic->getUser()->getId()){?>
        <a title="Supprimer le sujet" class="icon-admin-red" href="index.php?ctrl=topic&action=deleteTopic&id=<?=$topic->getId()?>"><i class='fa-solid fa-trash'></i></a>
      <?php }} ?>
      </div>
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
                <div class="post-header-left">
                <?php 
                //Couleur si le user est normal
                if($post->getUser()->getRole() == 'normal'){ ?>
                  <p  class="user-name">
                <?php } 
                //Couleur si le user est admin
                elseif($post->getUser()->getRole()=='admin' || $_SESSION["user"]->getRole() == 'moderator'){ ?>
                  <p  class="user-name-red">
                <?php } ?>
                  <a  title="Voir le profil" href="index.php?ctrl=security&action=viewOtherUserProfile&id=<?=$post->getUser()->getId()?>"><?=$post->getUser()->getNickname()?></a></p>
                  <p class="post-date"><?=$post->getPostDate()?></p>
                  </div>
                  <div class="post-header-right">
                  <?php
                  //Si $admin est déclaré et que ce n'est pas le premier post
                  if($admin==true && $countPost>1){ ?>
                  <a href='index.php?ctrl=post&action=deletePost&id=<?=$post->getId()?>'>
                  <p title="Supprimer le post" class='icon-admin-red'><i class='fa-solid fa-trash'></i></p>
                  </a>
                  <?php }

                  //Si $admin est déclaré
                  if($admin==true){ ?>
                    <a href='index.php?ctrl=post&action=linkToModifyPost&id=<?=$post->getId()?>'>
                    <p title="Modifier le post" class='icon-admin'><i class="fa-regular fa-pen-to-square"></i></p>
                    </a>
                   <?php } ?>

                  </div>
                  </div>
                  <p class="post-text"><?=$post->getText()?></p>
          </div>
      <?php
        }
      };
      ?>
    </div>

    
  <?php
//Si le topic n'est pas locked 
if ($topic->getLocked()==0) {
    ?>
    <!-- FORMULAIRE DE REPONSE -->
    <form class="form-add-topic" action="index.php?ctrl=post&action=addPostByTopic&id=<?= $topic->getId() ?>" method="POST">
      
    <label for="text">Texte de la réponse</label>
    <textarea rows="5" name="text" id="text"></textarea>
    
    <input type="submit" name="submit" id="submit" value="Répondre">
    
  </form>
  <?php } ?>
</div>
