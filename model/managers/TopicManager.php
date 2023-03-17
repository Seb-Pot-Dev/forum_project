<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;
    // use Model\Managers\TopicManager;
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
            
            //ici request sql select from $tablename
            // voir manager getMultipleResult (findAll)
        }

    }
    ?>