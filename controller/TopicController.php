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
    public function listTopicsByCategory($id){

        $topicManager = new TopicManager();
        $categoryManager = new CategoryManager();

        return [
            "view" => VIEW_DIR."forum/listTopics.php",
            "data" => [
                "topics" => $topicManager->findTopicsByCategory($id),
                "categorie" => $categoryManager->findOneById($id)
            ]
        ];

        

    }
    public function listPostByTopic($id){
        $postManager = new Postmanager();
        $topicManager = new TopicManager();
        return [
            "view" => VIEW_DIR."forum/listPosts.php",
            "data" => [
                "posts" => $postManager->findPostByTopic($id)
                ,"topic" => $topicManager->findOneById($id)
            ]
        ];
    }

}
