<?php

namespace Model\Managers;

use App\Manager;
use App\DAO;
use Controller\ForumController;

class TopicManager extends Manager
{

    protected $className = "Model\Entities\Topic";
    protected $tableName = "topic";


    public function __construct()
    {
        parent::connect();
    }
    public function findTopicsByCategory($id)
    {
        parent::connect();

        $sql = "SELECT *
                        FROM " . $this->tableName . " a
                        WHERE a.category_id = :id
                        ";

        return $this->getMultipleResults(
            DAO::select($sql, ['id' => $id], true),
            $this->className
        );
    }
    public function lockTopicById($id)
    {
        parent::connect();

        $sql =  "UPDATE " . $this->tableName .
            " SET locked = 1
             WHERE id_topic = :id";


        return DAO::update($sql, ['id' => $id]);
    }
    
    public function unlockTopicById($id)
    {
        parent::connect();

        $sql =  "UPDATE " . $this->tableName .
            " SET locked = 0 
             WHERE id_topic = :id";


        return DAO::update($sql, ['id' => $id]);
    }
  
}
