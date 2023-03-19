<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;

class PostController extends AbstractController implements ControllerInterface{

    public function index(){
      

       $postManager = new PostManager();

        return [
            "view" => VIEW_DIR."forum/listCategories.php",
            "data" => [
                "posts" => $postManager->findAll(["postDate", "ASC"])
            ]
        ];
    
    }

    public function findPostByTopic($id){

        $postManager = new PostManager();
        return [
            "view" => VIEW_DIR."forum/listPosts.php",
            "data" => [
                "posts" => $postManager->listPostByTopic($id)
            ]
        ];
    }
//problemes ici 
    public function findTopicName($topic){

        $postManager = new PostManager();
        return [
            "view" => VIEW_DIR."forum/listPosts.php",
            "data" => [
                "posts" => $postManager->topicNameByPost($topic)
            ]
        ];
    }
    

}
?>