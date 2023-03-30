<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;

class CategoryController extends AbstractController implements ControllerInterface{

    public function index(){
      

       $categoryManager = new CategoryManager();

        return [
            "view" => VIEW_DIR."forum/listCategories.php",
            "data" => [
                "categories" => $categoryManager->findAll(["categoryName", "DESC"])
                ]
        ];
    
    }

    public function addNewCategory(){
        //Si l'utilisateur en session est bien admin
        if(isset($_SESSION["user"]) && ($_SESSION["user"]->getRole()=="admin")){
            $categoryManager = new CategoryManager;
            //Si le formulaire est soumis
            if (isset($_POST["submit"])){
                //Si le champ categoryName est rempli et non vide
                if (isset($_POST["categoryName"]) && !empty($_POST["categoryName"])){
                    //On filtre les entrées
                    $categoryName= filter_input(INPUT_POST, "categoryName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                    //On ajoute la catégorie en bdd
                    $categoryManager->add(["categoryName" => $categoryName]);

                    //redirection
                    $this->redirectTo('category', 'index');
                }
            }
        }
    }
    // public function deleteCategory($id){
    //     if ($_SESSION["user"]->getRole()=="admin") {

    //         $categoryManager = new CategoryManager();
    //         $postManager = new PostManager();

            

    //         $categoryManager->delete($id);

    //         $this->redirectTo('category');
    //     }
    // }

}
?>