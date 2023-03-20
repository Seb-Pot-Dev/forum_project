<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;
    use Controller\ForumController;

    class TopicManager extends Manager{

        protected $className = "Model\Entities\Topic";
        protected $tableName = "topic";


        public function __construct(){
            parent::connect();
        }
        public function listTopicsByCategory($id){
            parent::connect();

                $sql = "SELECT *
                        FROM ".$this->tableName." a
                        WHERE a.category_id = :id
                        ";
    
                return $this->getMultipleResults(
                    DAO::select($sql, ['id' => $id], true), 
                    $this->className
                );

        }
        //problèmes ici
        public function topicName($id){
            parent::connect();

            $sql = "SELECT topicName
                    FROM ".$this->tableName." t
                    WHERE t.id_topic = :id
                    ";
            return $this->getOneOrNullResult(
                DAO::select($sql, ['id' => $id], false), 
                $this->className
            );
            
        }
    }
    ?>