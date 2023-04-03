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
            "view" => VIEW_DIR . "forum/listPosts.php",
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
                "posts" => $postManager->findPostByTopic($id), 
                "topic" => $topicManager->findOneById($id)
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
            if ((isset($_POST["text"]) && (!empty($_POST["text"])))
            ) {
                //On filtre les entrées
                $text = filter_input(INPUT_POST, "text", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                //on récupère l'id du user en session
                $user = $_SESSION["user"]->getId();

                //On utilise la méthode add du Manager qui associe les clé/valeur de l'objet(table) correspondant
                // la methode add utilise la méthode insert qui renvoie le lastInsertId (c a d le dernier id de la donnée ajouté en bdd)

                $postManager->add(["topic_id" => $id, "user_id" => $user, "text" => $text]);

                //Message de succès d'ajout du msg
                Session::addFlash('success', 'Message ajouté avec succès');

                //redirectTo permet de rediriger vers l'URL (controller, action, id)
                $this->redirectTo('post', 'listPostByTopic', $id);
            }
        } else {
            //Ajout d'un message de succès
            Session::addFlash('error', "Echec de l'ajout du message");
            return [
                "view" => VIEW_DIR . "forum/listPosts.php",
                "data" => [
                    "posts" => $postManager->findPostByTopic($id), 
                    "topic" => $topicManager->findOneById($id),
                ]
            ];
            //redirige vers l'index du user
            $this->redirectTo('user', 'index');
        }
    }
    public function deletePost($id)
    {
        $postManager = new PostManager;

        //déclaration du $post en question
        $post = $postManager->findOneById($id);
        //déclaration de l'id du topic du post en question
        $topicId = $post->getTopic()->getId();

        //Si le rôle du user en session est admin OU moderator
        if ($_SESSION["user"]->getRole() == 'admin' || $_SESSION["user"]->getRole() == 'moderator') {

            $postManager->delete($id);

            //Message de succès
            Session::addFlash('success', "Message supprimé avec succès");
            //redirection vers le même topic
            $this->redirectTo('post', 'listPostByTopic', $topicId);
        }
    }

    public function linkToModifyPost($id){
    if ($_SESSION["user"]->getRole() == 'admin' || $_SESSION["user"]->getRole() == 'moderator'){

        $postManager = new PostManager();

        $post = $postManager->findOneById($id);

        return [
            "view" => VIEW_DIR . "forum/modifyPost.php",
            "data" => [
                "post" => $postManager->findOneById($id),
            ]
        ];

        }
        }
    public function modifyPost($id){
        $postManager = new PostManager;

        //déclaration du $post en question
        $post = $postManager->findOneById($id);
        //déclaration de l'id du topic du post en question
        $topicId = $post->getTopic()->getId();

        //Si le rôle du user en session est admin OU moderator
        if ($_SESSION["user"]->getRole() == 'admin' || $_SESSION["user"]->getRole() == 'moderator') {

            if(isset($_POST['submit'])){

                $text = filter_input(INPUT_POST, "text", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                if(isset($_POST["text"]) && (!empty($_POST["text"]))){
                    $postManager->updatePostById($id, $text);
                    //message de succès de modification du post
                    Session::addFlash('success', 'Message modifié avec succès');
                    //redirection vers le même topic
                    $this->redirectTo('post', 'listPostByTopic', $topicId);
                }
            }
            else{
                //message d'echec de modification du post
                Session::addFlash('error', 'Echec de modification du message');
                $this->redirectTo('post', 'listPostByTopic', $topicId);

            }

        }
    }
}
