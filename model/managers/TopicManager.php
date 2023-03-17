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
        public function listTopicsByCategory($id_category){
            //ici request sql select from $tablename
            // voir manager getMultipleResult (findAll)
        }

    }
    ?>