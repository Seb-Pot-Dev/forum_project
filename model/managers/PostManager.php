<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;
    // use Model\Managers\TopicManager;
    use Controller\ForumController;

    class PostManager extends Manager{

        protected $className = "Model\Entities\Post";
        protected $tableName = "post";


        public function __construct(){
            parent::connect();
        }

        public function listPostByTopic($id){

            parent::connect();

                $sql = "SELECT *
                        FROM ".$this->tableName." a
                        WHERE a.topic_id = :id
                        ";
    
                return $this->getMultipleResults(
                    DAO::select($sql, ['id' => $id], true), 
                    $this->className
                );
        }
        //problèmes ici
        public function topicNameByPost($topic){
            parent::connect();
            $sql = "SELECT topicName
                    FROM topic t
                    INNER JOIN post p ON t.id_topic = p.topic_id
                    WHERE p.topic_id = :topic
                    ";
            return $this->getOneOrNullResult(
                DAO::select($sql, ['topic' => $topic], false), 
                $this->className
            );
            
        }
    }
    ?>