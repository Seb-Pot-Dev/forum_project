<?php

namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;

class PostController extends AbstractController implements ControllerInterface
{

    public function index()
    {


        $postManager = new PostManager();

        return [
            "view" => VIEW_DIR . "forum/listCategories.php",
            "data" => [
                "posts" => $postManager->findAll(["postDate", "ASC"])
            ]
        ];
    }
    public function listPostByTopic($id)
    {
        $postManager = new Postmanager();
        $topicManager = new TopicManager();
        return [
            "view" => VIEW_DIR . "forum/listPosts.php",
            "data" => [
                "posts" => $postManager->findPostByTopic($id), "topic" => $topicManager->findOneById($id)
            ]
        ];
    }
    public function addPostByTopic($id)
    {
        //Définition des variables
        $postManager = new PostManager();
        $topicManager = new TopicManager();

        //Si le form est soumis 
        if ((isset($_POST["submit"]))
            && (isset($_SESSION["user"]))
        ) {
            //et que les POST voulus sont définis && non vides
            if (
                (isset($_POST["text"]) && (!empty($_POST["text"])))
            ) {
                //On filtre les entrées
                $text = filter_input(INPUT_POST, "text", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                //user arbitraire en attendant de recup les données de session/login
                $user = $_SESSION["user"]->getId();

                //On utilise la méthode add du Manager qui associe les clé/valeur de l'objet(table) correspondant
                // la methode add utilise la méthode insert qui renvoie le lastInsertId (c a d le dernier id de la donnée ajouté en bdd)

                $postManager->add(["topic_id" => $id, "user_id" => $user, "text" => $text]);

                //redirectTo permet de rediriger vers l'URL (controller, action, id)
                $this->redirectTo('post', 'listPostByTopic', $id);
            }
        } else {
            return [
                "view" => VIEW_DIR . "forum/listPosts.php",
                "data" => [
                    "posts" => $postManager->findPostByTopic($id), "topic" => $topicManager->findOneById($id),
                    "error" => "Veuillez vous connectez afin de répondre sur un topic"
                ]
            ];
        }
    }
    public function deletePost($id)
    {
        $postManager = new PostManager;

        //déclaration du $post en question
        $post = $postManager->findOneById($id);
        //déclaration de l'id du topic du post en question
        $topicId = $post->getTopic()->getId();

        //Si le rôle du user en session est Admin, ou que c'est son topic,
        if ($_SESSION["user"]->getRole() == 'admin' || $_SESSION["user"]->getId() == $post->getUser()->getId()) {

            $postManager->delete($id);

            //redirection vers le même topic
            $this->redirectTo('post', 'listPostByTopic', $topicId);
        }
    }
}
