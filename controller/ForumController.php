<?php
// Le dossier "controller" contient les dossiers qui vont être appelés par l'utilisateur dans notre URL.
    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;
    
    class ForumController extends AbstractController implements ControllerInterface{

        public function index(){
          

           $topicManager = new TopicManager();

            return [
                "view" => VIEW_DIR."forum/listTopics.php",
                "data" => [
                    "topics" => $topicManager->findAll(["topicDate", "DESC"])
                ]
            ];
        
        }
        public function linkToRules(){
            return [
                "view" => VIEW_DIR."forum/rules.php",
            ];
        }
        public function linkToMention(){
            return [
                "view" => VIEW_DIR."forum/mention.php",
            ];
        }
        

        

    }
