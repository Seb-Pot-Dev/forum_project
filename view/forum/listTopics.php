<?php 
/*
-- INITALISATION des VARIABLES qui contiennent les DONNEES des "$TOPICS" et de la "$CATEGORIE"
-- tel que définis par le CONTROLLER "TopicController.php" 
-- dans la méthode "listTopicsByCategory()"
-- qui utilise la méthodes du MANAGER "TopicManager.php"
-- "findTopicsByCategory()" pour faire les requetes en BDD
*/

$topics = $result["data"]['topics'];
$categorie = $result["data"]['categorie'];
?>

<!-- HEADER de listTopics-->
<div class="listTopics-header">
    <h3>Catégorie : <?= $categorie->getCategoryName() ?></h3>
    <a class="button-light" href="index.php?ctrl=topic&action=linkAddTopic&id=<?= $categorie->getId() ?>">NOUVEAU TOPIC</a>
</div>

<!-- LIST des TOPICS -->

<?php
//DEBUT CONDITION si $topics est défini
if ($topics) { ?>
    <!-- DEBUT de la TABLE -->
    <table>
        <thead>
            <tr>
                <!-- th CATEGORIE + th UTILISATEUR -->
                <th>Categorie: <?= $categorie->getCategoryName() ?>
                </th>
                <th>Utilisateur</th>
            </tr>
        </thead>
        <?php
        /* FOREACH qui pour chaque ligne stockées dans $topics
        va chercher les donnés demandées par les méthodes "getId()", "getTopicName()" etc...
        */
        foreach ($topics as $topic) {
        ?>
            <tr>
                <td><a href="index.php?ctrl=post&action=listPostByTopic&id=<?= $topic->getId() ?>"><?= $topic->getTopicName() ?></a></td>
                <td><?=$topic->getUser()->getNickName()?></td>
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
