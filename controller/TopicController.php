<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;

class TopicController extends AbstractController implements ControllerInterface{

    public function index(){
      
       $categoryManager = new CategoryManager();

        return [
            "view" => VIEW_DIR."forum/listCategories.php",
            "data" => [
                "categories" => $categoryManager->findAll(["categoryName", "DESC"])
            ]
        ];
    
    }
    public function findTopicsByCategory($id){

        $topicManager = new TopicManager();

        return [
            "view" => VIEW_DIR."forum/listTopics.php",
            "data" => [
                "topics" => $topicManager->listTopicsByCategory($id)
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


}
