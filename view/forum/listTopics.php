<?php 
if(isset($result["data"]['topics'])){
    $topics = $result["data"]['topics'];
}
if(isset($result["data"]['category'])){
    $category = $result["data"]['category'];
}
if(isset($result["data"]['successDelete'])){
    $successDelete = $result["data"]['successDelete'];
}
if(isset($result["data"]['errorDelete'])){
    $errorDelete = $result["data"]['errorDelete'];
}

//(Vérification si le user est défini) ET (qu'il est admin OU modérateur)
if (isset($_SESSION["user"]) && ($_SESSION["user"]->getRole()=='admin' || $_SESSION["user"]->getRole()=='moderator')) {
    $admin=true;
  }
  else{
    $admin=false;
  }


?>

<!-- HEADER de listTopics-->
<div class="header-try">
    <a href="index.php?ctrl=category" class="button-red">Retour a la liste des catégories</a>
    <h3>Catégorie : <?= $category->getCategoryName() ?></h3>
    <a class="button-light" href="index.php?ctrl=topic&action=linkAddTopic&id=<?= $category->getId() ?>">NOUVEAU TOPIC</a>
</div>

<!-- LIST des TOPICS -->

<?php
//DEBUT CONDITION si $topics est défini
if (isset($topics) ){ ?>
    <!-- DEBUT de la TABLE -->
    <table>
        <thead>
            <tr>
                <!-- th CATEGORIE + th UTILISATEUR -->
                <th>Titre</th>
                <th>Auteur</th>
                <th>Etat</th>
                <th>Création</th>
                <th>NB</th>
                <th>Dernier MSG</th>
                <?php
                //Si $admin est déclaré
                if($admin){
                echo
                "<th>Admin</th>";
                }?>
            </tr>
        </thead>
        <tbody>
        <?php
        /* FOREACH qui pour chaque ligne stockées dans $topics
        va chercher les donnés demandées par les méthodes "getId()", "getTopicName()" etc...
        */
        foreach ($topics as $topic) {
        ?>
            <tr>
                <td><a href="index.php?ctrl=post&action=listPostByTopic&id=<?= $topic->getId() ?>"><?= $topic->getTopicName() ?></a></td>
                <td> 
                    <?php if($topic->getUser()->getRole() == 'normal'){ ?>
                    <p class="user-name">
                    <?php } elseif($topic->getUser()->getRole()==('admin' || 'moderator')){ ?>
                    <p class="user-name-red">
                    <?php } ?>    
                <a href="index.php?ctrl=security&action=viewOtherUserProfile&id=<?=$topic->getUser()->getId()?>"><?=$topic->getUser()->getNickName()?></a></td>
                    </p>

                </td>
                <?php //Etat du topic?>
                <td>
                <div class="container-icon-admin">
                <?php 
                if ($topic->getLocked()==1){ ?>
                <div class="icon-admin-red"><i class="fa-solid fa-lock"></i></div>
                <?php }else{ ?>
                <div class="icon-admin-green"><i class="fa-solid fa-lock-open"></i></div>
                <?php }?>
                </div>
                </td>
                <td><?=$topic->getFormattedTopicDate()?></td>
                <td><?=$topic->getCountPost()?></td>
                <td><?=$topic->getLastPostDate()?></td>
                <?php
                //Si $admin == true
                if($admin){ ?>
                    <td>
                    <div class='container-icon-admin'>
                        <a class='icon-admin-red' href='index.php?ctrl=topic&action=deleteTopic&id=<?=$topic->getId()?>'><i class='fa-solid fa-trash'></i></a> 
                        <a class='icon-admin' href='index.php?ctrl=topic&action=lockTopic&id=<?=$topic->getId()?>'><i class='fa-solid fa-lock'></i></a> 
                    </div>
                    </td>
                <?php } ?>
            </tr>
    <?php
        }
        // FIN FOREACH
    };
    //FIN CONDITION
    ?>
    </tbody>
</table>
<!--FIN de la TABLE-->

