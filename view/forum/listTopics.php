<?php
// Au départ, on passe par l'index, qui va nous aiguiller vers une des methodes du controller
// Puis si on envoie une requette a la BDD, on passera par la couche "Manager" qui
// va renvoyer une réponse au "Controller" 
// et le controller va renvoyer une "View"

// dans le dossier view/forum, j'ai toutes mes views qui concernent le forum.

$topics = $result["data"]['topics'];
$categorie = $result["data"]['categorie'];
?>
<div class="listTopic-header">
<h3>Catégorie : <?= $categorie->getCategoryName() ?></h3>

<a class="button-light" href="index.php?ctrl=topic&action=linkAddTopic&id=<?= $categorie->getId() ?>">NOUVEAU TOPIC</a>
</div>
<?php
if ($topics) { ?>
    <table>
        <thead>
            <tr>
                <th>Topics de la catégorie <?= $categorie->getCategoryName() ?>
                </th>
            </tr>
        </thead>
        <?php
        foreach ($topics as $topic) {
        ?>
            <tr>
                <td><a href="index.php?ctrl=post&action=listPostByTopic&id=<?= $topic->getId() ?>"><?= $topic->getTopicName() ?></a></td>
            </tr>
    <?php
        }
    };
    ?>
    </tbody>
    </table>
