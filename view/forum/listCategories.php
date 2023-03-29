<?php
if (isset($result["data"]['error'])){
    $error = $result["data"]['error'];
};
// Au départ, on passe par l'index, qui va nous aiguiller vers une des methodes du controller
// Puis si on envoie une requette a la BDD, on passera par la couche "Manager" qui
// va renvoyer une réponse au "Controller" 
// et le controller va renvoyer une "View"

// dans le dossier view/forum, j'ai toutes mes views qui concernent le forum.

$categories = $result["data"]['categories'];

//(Vérification si le user est admin)
if (isset($_SESSION["user"]) && ($_SESSION["user"]->getRole()=='admin')) {
    $admin=true;
  }
  else{
    $admin=false;
  }
?>

<h3>Liste des categories</h3>

<?php
if($admin){
?>
    <form class="form-add-category" action="index.php?ctrl=category&action=addNewCategory" method="post">
        <label for="categoryName">Nouvelle catégorie :</label>
        <input type="text" name="categoryName" id="categoryName"></input>

        <input type="submit" name="submit" id="submit" value ="Créer la catégorie">
    </form>
    
<?php }
  
if($categories){?>

<table>
    <thead>
        <tr>
            <th>Nom des catégories</th>
        </tr>
    </thead>

    <tbody>
    <?php
foreach ($categories as $category) {
    ?>
    <tr>
        <td><a href="index.php?ctrl=topic&action=listTopicsByCategory&id=<?=$category->getId()?>"><?=$category->getCategoryName()?></a></td>
    </tr>
    <?php
}

    ?>
    </tbody>
</table>
<?php
}
if(isset($error)){
    echo "<p>".$error."</p>";}
?>

  
