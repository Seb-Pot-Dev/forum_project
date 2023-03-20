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
        public function findTopicsByCategory($id){
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
        public function findOneById($id){

            $sql = "SELECT *
                    FROM ".$this->tableName." a
                    WHERE a.id_".$this->tableName." = :id
                    ";

            return $this->getOneOrNullResult(
                DAO::select($sql, ['id' => $id], false), 
                $this->className
            );
            
        }
    }
    ?>