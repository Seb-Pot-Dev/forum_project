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
}
