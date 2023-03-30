<?php

namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use App\Manager;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;
use Model\Managers\UserManager;

class TopicController extends AbstractController implements ControllerInterface
{

    public function index()
    {

        $categoryManager = new CategoryManager();

        return [
            "view" => VIEW_DIR . "forum/listCategories.php",
            "data" => [
                "categories" => $categoryManager->findAll(["categoryName", "DESC"])
            ]
        ];
    }

    // méthode pour LISTER les TOPICS par CATEGORIE
    public function listTopicsByCategory($id)
    {

        $topicManager = new TopicManager();
        $categoryManager = new CategoryManager();

        return [
            "view" => VIEW_DIR . "forum/listTopics.php",
            "data" => [
                "topics" => $topicManager->findTopicsByCategory($id),
                "category" => $categoryManager->findOneById($id)
            ]
        ];
    }

    // méthode pour diriger vers la page d'ajout de topic et chercher les infos sur la catégorie
    public function linkAddTopic($id){
    if (isset($_SESSION['user'])) {
        $categoryManager = new CategoryManager();
        return [
            "view"=> VIEW_DIR . "forum/addTopic.php",
            "data" => [
                "category" => $categoryManager->findOneById($id)
            ]
        ];
    }
    }

    // méthode pour AJOUTER un TOPIC par $id category
    public function addTopic($id)
    {
    //$id = ID de la CATEGORY
    //Définition des variables
    $topicManager = new TopicManager();
    $postManager = new PostManager();
    // $postManager=new Postmanager();

    if (isset($_SESSION["user"])) {
        //Si le form est soumis
        if (isset($_POST["submit"])) {
            //et que les POST voulus sont définis && non vides
            if (
                isset($_POST["topicName"]) && (!empty($_POST["topicName"]))
                && (isset($_POST["text"]) && (!empty($_POST["text"])))
                && (isset($_SESSION["user"]))
            ) {
                //On filtre les entrées
                $topicName = filter_input(INPUT_POST, "topicName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $text = filter_input(INPUT_POST, "text", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                //user  recup les données de session/login
                // var_dump($_SESSION["user"]);die;
                $user = $_SESSION["user"]->getId();

                //On utilise la méthode add du Manager qui associe les clé/valeur de l'objet(table) correspondant
                // la methode add utilise la méthode insert qui renvoie le lastInsertId (c a d le dernier id de la donnée ajouté en bdd)
                $lastIdOfTopicAddedToDbb = $topicManager->add(["topicName" => $topicName, "user_id" => $user, "category_id" => $id]);

                //ajout en BDD
                $postManager->add(["topic_id"=>$lastIdOfTopicAddedToDbb, "user_id" => $user, "text" => $text]);

                //redirectTo permet de rediriger vers l'URL (controller, action, id)
                $this->redirectTo('topic', 'listTopicsByCategory', $id);
            } else {
                return [
                    "view"=> VIEW_DIR . "forum/addTopic.php",
                    "data" => [
                        "error" => "Echec de la création du topic"
                    ]
                ];
            }
        }
    }
    }
    public function deleteTopic($id){
        //Définition des variables
        $topicManager = new TopicManager();
        $postManager = new PostManager();
        $topic = $topicManager->findOneById($id);
        $idCategory = $topic->getCategory()->getId();

        //Si le user en session est (admin OU moderator) OU que le user en session est celui qui a créer le topic
        if($_SESSION["user"]->getRole()=='admin' || $_SESSION["user"]->getRole()=='moderator' || $_SESSION["user"]->getId==$topic->getUser())
        {
            $postManager->deletePostsByTopic($id);

            $topicManager->delete($id);

            $this->redirectTo('topic', 'listTopicsByCategory', $idCategory);
        }
        else{
            $this->redirectTo('topic', 'listTopicsByCategory', $idCategory);
        }
    }
    public function deleteTopicByCategory($id){
        //Définition des variables
        $categoryManager = new CategoryManager;
        $topicManager = new TopicManager;
        $postManager = new postManager;

        $topics = $topicManager->findTopicsByCategory($id);

        $posts = $postManager->findPostsByTopic();


    }
    public function lockTopic($id){

        //Définition des variables
        $topicManager = new TopicManager();
            //$topic = $id du topic
            $topic = $topicManager->findOneById($id);
            //$idCategory = $id de la categorie du topic 
            $idCategory = $topic->getCategory()->getId();

        //si le user est (admin OU moderator) OU que c'est celui qui a créer le topic
        if($_SESSION["user"]->getRole()=='admin' || $_SESSION["user"]->getRole()=='moderator' || $_SESSION["user"]->getId()==$topic->getUser()){
            //si le topic est ouvert
            if($topic->getLocked()==0){
            //on utilise la fonction du TopicManager pour lock le topic
            $topicManager->lockTopicById($id);
            //redirection vers la liste de categorie du topic lock 
            }

            //sinon si le topic est fermé
            else{
                //on utilise la fonction du topicManager pour unlock le topic
            $topicManager->unlockTopicById($id);
            }
        }
    //dans les 2 cas on redirige vers la liste de topic de la catégorie
    $this->redirectTo('topic', 'listTopicsByCategory', $idCategory);
    }
    public function lockTopicFromTopic($id){

        //Définition des variables
        $topicManager = new TopicManager();
            //$topic = $id du topic
            $topic = $topicManager->findOneById($id);
            //$idTopic = $id du topic
            $idTopic = $topic->getId();
        //si le user est (admin OU moderator) OU que c'est celui qui a créer le topic
        if($_SESSION["user"]->getRole()==('admin' || 'moderator') || $_SESSION["user"]->getId()==$topic->getUser()){
            //si le topic est ouvert
            if($topic->getLocked()==0){
            //on utilise la fonction du TopicManager pour lock le topic
            $topicManager->lockTopicById($id);
            //redirection vers la liste de categorie du topic lock 
            }

            //sinon si le topic est fermé
            else{
                //on utilise la fonction du topicManager pour unlock le topic
            $topicManager->unlockTopicById($id);
            }
        }
    //dans les 2 cas on redirige vers la liste de topic de la catégorie
    $this->redirectTo('post', 'listPostByTopic', $idTopic);
    }
    
}
