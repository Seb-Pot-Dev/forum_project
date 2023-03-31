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

        /*Les sous-requette SELECT permettent de selectionner la 'date du dernier post' & 'le nb de post' pour chaque TOPIC 
        trouvés dans le SELECT principal  -> pas besoin de inner join*/
        $sql = "SELECT t.*, DATE_FORMAT(topicDate, '%d/%m/%Y %H:%i') AS formattedTopicDate,
                DATE_FORMAT((SELECT MAX(postDate) FROM post WHERE topic_id = t.id_topic), '%d/%m/%Y %H:%i') AS lastPostDate,
                (SELECT COUNT(*) FROM post WHERE topic_id = t.id_topic) AS countPost 
                FROM topic t 
                WHERE t.category_id = :id
                ORDER BY lastPostDate DESC
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
