<?php
// Au départ, on passe par l'index, qui va nous aiguiller vers une des methodes du controller
// Puis si on envoie une requette a la BDD, on passera par la couche "Manager" qui
// va renvoyer une réponse au "Controller" 
// et le controller va renvoyer une "View"

// dans le dossier view/forum, j'ai toutes mes views qui concernent le forum.

$categories = $result["data"]['categories'];

?>

<h3>Liste des categories</h3>

<?php
if($categories){?>

<table>
    <thead>
        <tr>
            <th>Nom des catégories</th>
        </tr>
    </thead>

    <tbody>
    <?php
foreach($categories as $category){
    ?>
    <tr>
        <td><a href="index.php?ctrl=topic&action=listTopicsByCategory&id=<?=$category->getId()?>"><?=$category->getCategoryName()?></a></td>
    </tr>
    <?php
}
};
?>
    </tbody>
</table>

  
